<?php

/**
 * File: admin/pages.php
 * Chức năng: Quản lý nội dung website (Giữ nguyên logic gốc của bạn)
 */
require_once __DIR__ . '/includes/AdminLayout.php';

$pageTitle = 'Quản lý nội dung | Plantify Admin';
$db = Database::getInstance();
$message = '';
$error = '';

function admin_page_image_upload($fieldName, &$error)
{
    if (empty($_FILES[$fieldName]) || ($_FILES[$fieldName]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return '';
    $file = $_FILES[$fieldName];
    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        $error = 'Upload hình ảnh thất bại.';
        return '';
    }
    $maxBytes = 5 * 1024 * 1024;
    if ($file['size'] > $maxBytes) {
        $error = 'Hình ảnh vượt quá 5MB.';
        return '';
    }
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
        $error = 'Chỉ hỗ trợ JPG, PNG, WEBP, GIF.';
        return '';
    }
    $uploadDir = STORAGE_PATH . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'pages';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
        $error = 'Không tạo được thư mục lưu trữ.';
        return '';
    }
    $fileName = 'page-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $extension;
    $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        $error = 'Không lưu được hình ảnh.';
        return '';
    }
    return 'storage/uploads/pages/' . $fileName;
}

if (!$db) {
    $error = 'Chưa kết nối được database.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_content') {
        $content = $_POST['content'] ?? [];
        if (!is_array($content)) {
            $error = 'Dữ liệu không hợp lệ.';
        } else {
            foreach ($content as $key => $value) {
                // SỬA LỖI Ở ĐÂY:
                // Class Database của bạn yêu cầu dùng bind() và execute() tách biệt
                $db->query('UPDATE site_content SET content_value = :val WHERE content_key = :key');
                $db->bind(':val', trim((string)$value));
                $db->bind(':key', (string)$key);
                $db->execute();
            }
            $message = 'Nội dung website đã được cập nhật.';
        }
    }

    if ($action === 'save_page') {
        $slug = trim($_POST['slug'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['page_content'] ?? '');
        $image = trim($_POST['current_image'] ?? '');

        $uploadedImage = admin_page_image_upload('image_file', $error);
        if ($uploadedImage) $image = $uploadedImage;

        if ($slug && $title && $content) {
            // SỬA LỖI Ở ĐÂY:
            $sql = 'INSERT INTO pages (slug, title, content, image) 
                    VALUES (:slug, :title, :content, :image) 
                    ON DUPLICATE KEY UPDATE title = :title, content = :content, image = :image';

            $db->query($sql);
            $db->bind(':slug', $slug);
            $db->bind(':title', $title);
            $db->bind(':content', $content);
            $db->bind(':image', $image);
            $db->execute();

            $message = 'Nội dung trang đã được cập nhật.';
        } else {
            $error = 'Vui lòng nhập đủ slug, tiêu đề và nội dung.';
        }
    }
}

// Lấy dữ liệu
$contentRows = [];
$pages = [];
$groupedContent = [];
$heroVideoAdmin = 'assets/videos/about/about-hero.m3u8';
if ($db) {
    try {
        // 1. Lấy dữ liệu Site Content
        $db->query('SELECT * FROM site_content ORDER BY content_group, id');
        $contentRows = $db->resultSet(); // Dùng resultSet() thay cho fetchAll()

        // 2. Lấy dữ liệu Pages
        $db->query('SELECT * FROM pages ORDER BY slug');
        $pages = $db->resultSet(); // Dùng resultSet() thay cho fetchAll()

    } catch (Exception $e) {
        $error = 'Lỗi truy vấn database: ' . $e->getMessage();
    }
}
foreach ($contentRows as $row) {
    $groupedContent[$row['content_group']][] = $row;
    if ($row['content_key'] === 'about.hero_video') $heroVideoAdmin = $row['content_value'];
}

admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Quản lý Nội dung Website',
    'subtitle' => 'Chỉnh sửa văn bản, tiêu đề và hình ảnh cho các trang tĩnh.',
    'actionHtml' => '<a class="btn btn-outline-success" href="' . BASE_URL . '"><i class="fa-solid fa-eye me-2"></i>Xem website</a>',
]);
?>

<?php if ($message): ?><div class="alert alert-success"><?php echo e($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>

<form method="post" class="admin-card mb-4">
    <input type="hidden" name="action" value="save_content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Nội dung văn bản tĩnh</h4>
        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    </div>
    <?php foreach ($groupedContent as $group => $rows): ?>
        <div class="content-editor-group">
            <h5 class="text-success"><?php echo e($group); ?></h5>
            <div class="row">
                <?php foreach ($rows as $row): ?>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label"><?php echo e($row['label']); ?></label>
                        <?php if ($row['content_key'] === 'about.hero_video'): ?>
                            <input class="form-control bg-light" type="text" name="content[<?php echo e($row['content_key']); ?>]" value="<?php echo e($row['content_value']); ?>" readonly>
                        <?php elseif ($row['input_type'] === 'textarea'): ?>
                            <textarea class="form-control" name="content[<?php echo e($row['content_key']); ?>]" rows="3"><?php echo e($row['content_value']); ?></textarea>
                        <?php else: ?>
                            <input class="form-control" type="text" name="content[<?php echo e($row['content_key']); ?>]" value="<?php echo e($row['content_value']); ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</form>

<div class="admin-card video-upload-card mb-4">
    <h4>Cấu hình Video Hero</h4>
    <form id="heroVideoUploadForm" class="video-upload-grid" enctype="multipart/form-data">
        <label class="video-drop-zone" for="heroVideoFile">
            <input type="file" id="heroVideoFile" name="video" accept="video/*" required>
            <span class="video-drop-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
            <strong id="heroVideoFileName">Chọn video</strong>
        </label>
        <div class="video-upload-controls">
            <div class="row g-2">
                <div class="col-6"><label>Bắt đầu(s)</label><input type="number" class="form-control" name="start_second" value="0"></div>
                <div class="col-6"><label>Kết thúc(s)</label><input type="number" class="form-control" name="end_second" value="30"></div>
            </div>
            <div class="video-current-path"><span>File hiện tại</span><strong><?php echo e($heroVideoAdmin); ?></strong></div>
            <button type="submit" class="btn btn-success w-100">Upload & Chuyển đổi</button>
        </div>
    </form>
    <div class="video-upload-progress" id="heroVideoProgress" hidden>
        <div class="sort-spinner"></div>
    </div>
    <div class="video-upload-message" id="heroVideoMessage" hidden></div>
</div>

<div class="admin-card">
    <h4 class="mb-4">Quản lý các trang nội dung</h4>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="save_page">
        <input type="hidden" name="current_image" id="current_image">

        <div class="row">
            <!-- Đã đổi Slug từ input text sang select (Dropdown) -->
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">Chọn trang cần sửa</label>
                <select name="slug" id="slug" class="form-select border-success" required>
                    <option value="" disabled selected>-- Chọn một trang để chỉnh sửa --</option>
                    <?php foreach ($pages as $p): ?>
                        <option value="<?= e($p['slug']) ?>"><?= e($p['title']) ?> (<?= e($p['slug']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text text-muted">Hoặc gõ slug mới để tạo trang mới.</div>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="col-12 mb-3">
                <label class="form-label fw-bold">Nội dung</label>
                <textarea name="page_content" id="page_content" class="form-control admin-textarea-large"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Upload ảnh đại diện</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold d-block">Ảnh hiện tại</label>
                <div class="admin-image-preview border rounded d-flex align-items-center justify-content-center" style="height: 120px; width: 100%;">
                    <img id="pageImagePreview" src="" alt="Preview" style="max-height: 100%; max-width: 100%;" hidden>
                    <span id="pageImageEmpty" class="text-muted">Chưa có ảnh</span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success px-5 mt-2">Lưu trang</button>
    </form>
</div>

<?php
$pagesJson = json_encode($pages, JSON_UNESCAPED_UNICODE);
$extraScripts = '
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@10/dist/umd/simple-datatables.min.js"></script>
<script>
    const pages = <?php echo json_encode($pages, JSON_UNESCAPED_UNICODE); ?>;
    const slugSelect = document.getElementById("slug");
    const titleInput = document.getElementById("title");
    const contentTextarea = document.getElementById("page_content");
    const imageInput = document.getElementById("current_image");
    const previewImg = document.getElementById("pageImagePreview");
    const previewEmpty = document.getElementById("pageImageEmpty");

    slugSelect.addEventListener("change", function() {
        const selectedSlug = this.value;
        const page = pages.find(item => item.slug === selectedSlug);

        if (page) {
            titleInput.value = page.title;
            contentTextarea.value = page.content;
            imageInput.value = page.image;
            
            if (page.image) {
                previewImg.src = "<?= BASE_URL ?>/" + page.image;
                previewImg.hidden = false;
                previewEmpty.hidden = true;
            } else {
                previewImg.hidden = true;
                previewEmpty.hidden = false;
            }
        } else {
            // Reset nếu tạo trang mới (slug không tồn tại trong danh sách)
            titleInput.value = "";
            contentTextarea.value = "";
            imageInput.value = "";
            previewImg.hidden = true;
            previewEmpty.hidden = false;
        }
    });
</script>';
admin_layout_end($extraScripts);
?>