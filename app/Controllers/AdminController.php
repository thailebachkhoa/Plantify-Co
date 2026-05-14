<?php

/**
 * AdminController
 * Handles admin dashboard: user management + news management + comment management
 * Part #4 additions: news(), news_create(), news_edit(), news_delete(),
 *                    comments(), comment_toggle(), comment_delete()
 */
class AdminController extends BaseController
{
    public function __construct()
    {
        // Require admin role
        if (!Auth::check()) {
            $this->redirect('auth');
            exit;
        }
        if (!Auth::isAdmin()) {
            $this->redirect('dashboard');
            exit;
        }
        if (!Auth::isActive()) {
            session_destroy();
            header('Location: ' . BASE_URL . '/auth');
            exit;
        }
    }

    /* =============================================
       USER MANAGEMENT (existing)
       ============================================= */

    public function index()
    {
        // Trang Dashboard tổng quan
        $this->view('admin/index', [
            'user' => Auth::user(),
            'pageTitle' => 'Tổng quan hệ thống'
        ]);
    }

    public function users()
    {
        $userModel = new User();

        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $users = $userModel->getPaginated($limit, $offset);
        $totalUsers = $userModel->countAll();
        $totalPages = ceil($totalUsers / $limit);

        $this->view('admin/users', [
            'user'  => Auth::user(),
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'pageTitle' => 'Quản lý thành viên'
        ]);
    }

    public function user_create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $data = [
                'username' => $_POST['username'],
                'fullname' => $_POST['fullname'],
                'email'    => $_POST['email'],
                'role'     => $_POST['role'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'status'   => 1
            ];

            if ($userModel->create($data)) {
                $this->redirect('admin/users');
                exit;
            }
        }

        $this->view('admin/user-form', [
            'user'      => Auth::user(),
            'pageTitle' => 'Thêm thành viên mới'
        ]);
    }

    /** Toggle user status (lock/unlock) */
    public function toggle_status($id)
    {
        $userModel  = new User();
        $targetUser = $userModel->findById($id);
        if ($targetUser && $targetUser['role'] !== 'admin' && $targetUser['id'] != Auth::id()) {
            $newStatus = ($targetUser['status'] === 'active') ? 'locked' : 'active';
            $userModel->updateStatus($id, $newStatus);
        }
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $this->redirect('admin/users');
    }

    /** Reset user password to default (123456) */
    public function reset_password($id)
    {
        $userModel  = new User();
        $targetUser = $userModel->findById($id);
        if ($targetUser && $targetUser['role'] !== 'admin' && $targetUser['id'] != Auth::id()) {
            $userModel->resetPassword($id, password_hash('123456', PASSWORD_DEFAULT));
        }
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $this->redirect('admin/users');
    }

    /** Delete a member account */
    public function delete_user($id)
    {
        if ($id == Auth::id()) {
            $this->redirect('admin/users');
            return;
        }
        $userModel  = new User();
        $targetUser = $userModel->findById($id);
        if ($targetUser && $targetUser['role'] !== 'admin') {
            $userModel->deleteUser($id);
        }
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $this->redirect('admin/users');
    }

    /* =============================================
       NEWS MANAGEMENT 
       ============================================= */

    /** GET /admin/news — list all news with search + pagination */
    public function news()
    {
        $newsModel    = new News();
        $search       = trim($_GET['search'] ?? '');
        $statusFilter = $_GET['status'] ?? '';
        $page         = max(1, (int)($_GET['page'] ?? 1));

        $total      = $newsModel->countAll($search, $statusFilter);
        $newsList   = $newsModel->getAll($page, $search, $statusFilter);
        $totalPages = $total > 0 ? (int)ceil($total / $newsModel->getAdminPerPage()) : 1;

        $success = $_SESSION['admin_success'] ?? null;
        $error   = $_SESSION['admin_error']   ?? null;
        unset($_SESSION['admin_success'], $_SESSION['admin_error']);

        $this->view('admin/news-list', [
            'user'         => Auth::user(),
            'newsList'     => $newsList,
            'search'       => $search,
            'statusFilter' => $statusFilter,
            'currentPage'  => $page,
            'totalPages'   => $totalPages,
            'total'        => $total,
            'success'      => $success,
            'error'        => $error,
        ]);
    }

    /** GET /admin/news_create — show form
     *  POST /admin/news_create — handle creation */
    public function news_create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->processNewsForm();
            if ($result['error']) {
                $this->view('admin/news-form', [
                    'user'     => Auth::user(),
                    'mode'     => 'create',
                    'news'     => null,
                    'error'    => $result['error'],
                    'formData' => $_POST,
                ]);
                return;
            }

            $newsModel = new News();
            $newId     = $newsModel->create($result['data']);

            // Append numeric ID to slug for uniqueness
            $finalSlug = News::generateSlug($result['data']['title'], $newId);
            $newsModel->updateSlug($newId, $finalSlug);

            $_SESSION['admin_success'] = 'Bài viết đã được tạo thành công!';
            $this->redirect('admin/news');
        } else {
            $this->view('admin/news-form', [
                'user'     => Auth::user(),
                'mode'     => 'create',
                'news'     => null,
                'error'    => null,
                'formData' => null,
            ]);
        }
    }

    /** GET /admin/news_edit/{id} — show edit form
     *  POST /admin/news_edit/{id} — handle update */
    public function news_edit($id = null)
    {
        $newsModel = new News();
        $news      = $newsModel->getById((int)$id);

        if (!$news) {
            $_SESSION['admin_error'] = 'Bài viết không tồn tại!';
            $this->redirect('admin/news');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->processNewsForm($news['thumbnail']);
            if ($result['error']) {
                $this->view('admin/news-form', [
                    'user'     => Auth::user(),
                    'mode'     => 'edit',
                    'news'     => $news,
                    'error'    => $result['error'],
                    'formData' => array_merge($news, $_POST),
                ]);
                return;
            }

            $newsModel->update((int)$id, $result['data']);
            $_SESSION['admin_success'] = 'Bài viết đã được cập nhật!';
            $this->redirect('admin/news');
        } else {
            $this->view('admin/news-form', [
                'user'     => Auth::user(),
                'mode'     => 'edit',
                'news'     => $news,
                'error'    => null,
                'formData' => $news,
            ]);
        }
    }

    /** GET /admin/news_delete/{id} — delete a news article */
    public function news_delete($id = null)
    {
        $newsModel = new News();
        $news      = $newsModel->getById((int)$id);

        if ($news) {
            // Delete thumbnail file from disk
            if (!empty($news['thumbnail'])) {
                $thumbPath = __DIR__ . '/../../public/' . $news['thumbnail'];
                if (file_exists($thumbPath)) {
                    @unlink($thumbPath);
                }
            }
            $newsModel->delete((int)$id);
            $_SESSION['admin_success'] = 'Bài viết đã được xóa!';
        } else {
            $_SESSION['admin_error'] = 'Bài viết không tồn tại!';
        }

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $this->redirect('admin/news');
    }

    /* =============================================
       COMMENT MANAGEMENT (Part #4)
       ============================================= */

    /** GET /admin/comments — list all comments with search + pagination */
    public function comments()
    {
        $commentModel = new Comment();
        $search       = trim($_GET['search'] ?? '');
        $page         = max(1, (int)($_GET['page'] ?? 1));

        $total        = $commentModel->countAll($search);
        $commentsList = $commentModel->getAll($page, $search);
        $totalPages   = $total > 0 ? (int)ceil($total / $commentModel->getPerPage()) : 1;

        $success = $_SESSION['admin_success'] ?? null;
        unset($_SESSION['admin_success']);

        $this->view('admin/comment-list', [
            'user'         => Auth::user(),
            'commentsList' => $commentsList,
            'search'       => $search,
            'currentPage'  => $page,
            'totalPages'   => $totalPages,
            'total'        => $total,
            'success'      => $success,
        ]);
    }

    /** GET /admin/comment_toggle/{id} — toggle comment approved ↔ hidden */
    public function comment_toggle($id = null)
    {
        $commentModel = new Comment();
        $commentModel->toggleStatus((int)$id);
        $_SESSION['admin_success'] = 'Trạng thái bình luận đã được cập nhật!';
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $this->redirect('admin/comments');
    }

    /** GET /admin/comment_delete/{id} — delete a comment */
    public function comment_delete($id = null)
    {
        $commentModel = new Comment();
        $commentModel->delete((int)$id);
        $_SESSION['admin_success'] = 'Bình luận đã được xóa!';
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            // Chuyển hướng về lại đúng URL đó (giữ nguyên page và search)
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $this->redirect('admin/comments');
    }

    /* =============================================
       PRIVATE HELPER
       ============================================= */

    /**
     * Process and validate the news create/edit form.
     * Returns ['error' => string|null, 'data' => array|null]
     *
     * @param string|null $existingThumbnail  Current thumbnail path (for edit)
     */
    private function processNewsForm($existingThumbnail = null)
    {
        $title     = trim($_POST['title']             ?? '');
        $shortDesc = trim($_POST['short_description'] ?? '');
        $content   = trim($_POST['content']           ?? '');
        $tags      = trim($_POST['tags']              ?? '');
        $seoDesc   = trim($_POST['seo_desc']          ?? '');
        $author    = trim($_POST['author']            ?? 'Admin');
        $status    = in_array($_POST['status'] ?? '', ['published', 'draft', 'hidden'])
            ? $_POST['status'] : 'draft';

        // ---- Server-side validation ----
        if (empty($title))              return ['error' => 'Tiêu đề không được để trống!',         'data' => null];
        if (mb_strlen($title) < 5)     return ['error' => 'Tiêu đề phải có ít nhất 5 ký tự!',     'data' => null];
        if (mb_strlen($title) > 255)   return ['error' => 'Tiêu đề không được vượt quá 255 ký tự!', 'data' => null];
        if (empty($shortDesc))         return ['error' => 'Mô tả ngắn không được để trống!',       'data' => null];
        if (empty($content))           return ['error' => 'Nội dung bài viết không được để trống!', 'data' => null];

        // ---- Image upload (optional) ----
        $thumbnail = $existingThumbnail ?? '';

        if (!empty($_FILES['thumbnail']['name'])) {
            $file    = $_FILES['thumbnail'];
            $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($file['type'], $allowed) && !in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                return ['error' => 'Chỉ chấp nhận file ảnh: JPG, JPEG, PNG, WEBP!', 'data' => null];
            }
            if ($file['size'] > 2 * 1024 * 1024) {
                return ['error' => 'Ảnh không được vượt quá 2MB!', 'data' => null];
            }
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['error' => 'Lỗi khi upload ảnh (code: ' . $file['error'] . ')!', 'data' => null];
            }

            $uploadDir = __DIR__ . '/../../public/uploads/news/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filename = 'news_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $dest     = $uploadDir . $filename;

            if (!move_uploaded_file($file['tmp_name'], $dest)) {
                return ['error' => 'Không thể lưu file ảnh lên server!', 'data' => null];
            }

            // Delete old thumbnail
            if (!empty($existingThumbnail)) {
                $oldPath = __DIR__ . '/../../public/' . $existingThumbnail;
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $thumbnail = 'uploads/news/' . $filename;
        }

        // ---- Build and sanitize data ----
        $slug = News::generateSlug($title);

        return [
            'error' => null,
            'data'  => [
                'title'             => htmlspecialchars($title,     ENT_QUOTES, 'UTF-8'),
                'slug'              => $slug,
                'short_description' => htmlspecialchars($shortDesc, ENT_QUOTES, 'UTF-8'),
                'content'           => $content,   // Admin content — allow HTML
                'thumbnail'         => $thumbnail,
                'tags'              => htmlspecialchars($tags,      ENT_QUOTES, 'UTF-8'),
                'seo_desc'          => htmlspecialchars($seoDesc,   ENT_QUOTES, 'UTF-8'),
                'author'            => htmlspecialchars($author,    ENT_QUOTES, 'UTF-8'),
                'status'            => $status,
            ],
        ];
    }
    /* =============================================
       QUẢN LÝ NỘI DUNG, FAQ & RAG
       ============================================= */

    public function pages()
    {
        require_once BASE_PATH . '/app/Models/Content.php';
        $contentModel = new Content();

        // Lấy dữ liệu từ DB
        $contentRows = $contentModel->getAllSiteContent();
        $pages = $contentModel->getAllPages();

        // Nhóm dữ liệu để hiển thị (giống logic cũ của bạn)
        $groupedContent = [];
        foreach ($contentRows as $row) {
            $groupedContent[$row['content_group']][] = $row;
        }

        $this->view('admin/pages', [
            'user' => Auth::user(),
            'groupedContent' => $groupedContent,
            'pages' => $pages,
            'pageTitle' => 'Quản lý Nội dung',
            'message'        => $_SESSION['admin_success'] ?? '', // Truyền từ session
            'error'          => $_SESSION['admin_error'] ?? ''
        ]);
    }

    public function save_pages()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once BASE_PATH . '/app/Models/Content.php';
            $contentModel = new Content();

            foreach ($_POST['content'] as $key => $value) {
                $contentModel->updateSiteContent($key, $value);
            }
            $_SESSION['admin_success'] = "Đã lưu thay đổi!";
            $this->redirect('admin/pages');
        }
    }

    public function faqs()
    {
        $this->view('admin/faqs', [
            'user' => Auth::user()
        ]);
    }

    public function rag()
    {
        $this->view('admin/rag', [
            'user' => Auth::user()
        ]);
    }

    /* =============================================
   PRODUCT MANAGEMENT
   ============================================= */

    public function products()
    {
        $productModel = new Product();

        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $products = $productModel->getPaginated($limit, $offset);
        $totalProducts = $productModel->countAll();
        $totalPages = ceil($totalProducts / $limit);

        $this->view('admin/products', [
            'user'      => Auth::user(),
            'products'  => $products,
            'pageTitle' => 'Quản lý Sản phẩm',
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function product_create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productModel = new Product();

            // Xử lý upload ảnh
            $imagePath = $this->handleProductImageUpload();

            $data = [
                'name'        => $_POST['name'],
                'category'    => $_POST['category'],
                'price'       => (float)$_POST['price'],
                'description' => $_POST['description'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'image'       => $imagePath
            ];

            if ($productModel->create($data)) {
                $this->redirect('admin/products');
            }
        }

        $this->view('admin/product-form', [
            'user'      => Auth::user(),
            'pageTitle' => 'Thêm sản phẩm mới',
            'mode'      => 'create'
        ]);
    }

    public function product_edit($id)
    {
        $productModel = new Product();
        $product = $productModel->findById($id);

        if (!$product) {
            $this->redirect('admin/products');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $this->handleProductImageUpload($product['image']);

            $data = [
                'name'        => $_POST['name'],
                'category'    => $_POST['category'],
                'price'       => (float)$_POST['price'],
                'description' => $_POST['description'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'image'       => $imagePath
            ];

            if ($productModel->update($id, $data)) {
                $this->redirect('admin/products');
            }
        }

        $this->view('admin/product-form', [
            'user'      => Auth::user(),
            'product'   => $product,
            'pageTitle' => 'Chỉnh sửa sản phẩm',
            'mode'      => 'edit'
        ]);
    }

    public function shop_settings()
    {
        $this->view('admin/shop-settings', [
            'user'      => Auth::user(),
            'pageTitle' => 'Cấu hình Cửa hàng'
        ]);
    }

    /**
     * Helper: Xử lý upload ảnh sản phẩm
     */
    private function handleProductImageUpload($existingImage = null)
    {
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/assets/uploads/products/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
            $fileName = 'prod_' . time() . '_' . uniqid() . '.' . $ext;

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadDir . $fileName)) {
                // Xóa ảnh cũ nếu có
                if ($existingImage && file_exists(BASE_PATH . '/public/' . $existingImage)) {
                    @unlink(BASE_PATH . '/public/' . $existingImage);
                }
                return 'assets/uploads/products/' . $fileName;
            }
        }
        return $existingImage; // Giữ nguyên ảnh cũ nếu không có upload mới
    }

    public function product_delete($id)
    {
        $productModel = new Product();
        $product = $productModel->findById($id);

        if ($product) {
            // Xóa file ảnh trên server
            if (!empty($product['image']) && file_exists(BASE_PATH . '/public/' . $product['image'])) {
                @unlink(BASE_PATH . '/public/' . $product['image']);
            }
            $productModel->delete($id);
        }

        $this->redirect('admin/products');
    }

     /** GET /admin/contacts — danh sách liên hệ */
    public function contacts()
    {
        $db      = Database::getInstance();
        $search  = trim($_GET['search'] ?? '');
        $statusF = $_GET['status'] ?? '';
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $offset  = ($page - 1) * $perPage;
 
        $where = '1=1';
        if ($search) $where .= ' AND (name LIKE :s1 OR email LIKE :s2 OR message LIKE :s3)';
        if ($statusF === 'unread') $where .= ' AND is_read = 0';
        if ($statusF === 'read')   $where .= ' AND is_read = 1';
 
        $db->query("SELECT COUNT(*) as total FROM contacts WHERE $where");
        if ($search) {
            $db->bind(':s1', '%'.$search.'%');
            $db->bind(':s2', '%'.$search.'%');
            $db->bind(':s3', '%'.$search.'%');
        }
        $total = (int)($db->single()['total'] ?? 0);
 
        $db->query("SELECT * FROM contacts WHERE $where ORDER BY is_read ASC, created_at DESC LIMIT :lim OFFSET :off");
        if ($search) {
            $db->bind(':s1', '%'.$search.'%');
            $db->bind(':s2', '%'.$search.'%');
            $db->bind(':s3', '%'.$search.'%');
        }
        $db->bind(':lim', $perPage);
        $db->bind(':off', $offset);
        $contacts = $db->resultSet();
 
        $success = $_SESSION['admin_success'] ?? null;
        unset($_SESSION['admin_success']);
 
        $this->view('admin/contacts', [
            'user'         => Auth::user(),
            'contacts'     => $contacts,
            'search'       => $search,
            'statusFilter' => $statusF,
            'currentPage'  => $page,
            'totalPages'   => $total > 0 ? (int)ceil($total / $perPage) : 1,
            'total'        => $total,
            'success'      => $success,
        ]);
    }
 
    /** GET /admin/contact_read/{id} — đánh dấu đã đọc */
    public function contact_read($id = null)
    {
        $db = Database::getInstance();
        $db->query("UPDATE contacts SET is_read = 1 WHERE id = :id");
        $db->bind(':id', (int)$id);
        $db->execute();
        $_SESSION['admin_success'] = 'Đã đánh dấu đã đọc!';
        $this->redirect('admin/contacts');
    }
 
    /** GET /admin/contact_delete/{id} — xóa liên hệ */
    public function contact_delete($id = null)
    {
        $db = Database::getInstance();
        $db->query("DELETE FROM contacts WHERE id = :id");
        $db->bind(':id', (int)$id);
        $db->execute();
        $_SESSION['admin_success'] = 'Đã xóa liên hệ!';
        $this->redirect('admin/contacts');
    }
 
}