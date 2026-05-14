<?php

/**
 * Dashboard Controller
 * Handle member area, profile management and role routing
 */
class DashboardController extends BaseController
{

    public function __construct()
    {
        // Require user to be logged in
        if (!Auth::check()) {
            $this->redirect('auth');
            exit;
        }

        // Check if user is locked
        if (!Auth::isActive()) {
            session_destroy();
            header('Location: ' . BASE_URL . '/auth');
            echo 'Tài khoản của bạn đã bị khoá.';
            exit;
        }
    }

    /**
     * Dashboard Home / Profile Page
     */
    public function index()
    {
        // Redirect admin to admin panel
        if (Auth::isAdmin()) {
            $this->redirect('admin');
            return;
        }

        // Show member dashboard (Tích hợp thông tin user mới nhất)
        if (Auth::isMember()) {
            require_once BASE_PATH . '/app/Models/User.php';
            $userModel = new User();

            // Lấy dữ liệu user mới nhất từ DB để đồng bộ với avatar/tên vừa sửa
            $currentUser = $userModel->findById(Auth::user()['id']);

            $this->view('pages/dashboard', ['user' => $currentUser]);
            return;
        }

        // Unknown role
        echo "Lỗi: Vai trò không xác định.";
        exit;
    }

    /**
     * Handle Profile Update (Update Name & Avatar)
     */
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('dashboard');
            return;
        }

        require_once BASE_PATH . '/app/Models/User.php';
        $userModel = new User();
        $userId = Auth::user()['id'];
        $fullname = trim($_POST['fullname'] ?? '');

        // Lấy lại user hiện tại để giữ lại avatar cũ nếu không upload mới
        $currentUser = $userModel->findById($userId);
        $avatarPath = $currentUser['avatar'];

        // Validate
        if (empty($fullname)) {
            $_SESSION['error'] = "Họ và tên không được để trống!";
            $this->redirect('dashboard');
            return;
        }

        // XỬ LÝ UPLOAD ẢNH
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']) && $_FILES['avatar']['size'] < 5000000) {
                $newFileName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
                // Lưu vào STORAGE_PATH thay vì public/assets
                $uploadDir = STORAGE_PATH . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR;

                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $newFileName)) {
                    // Xóa ảnh cũ (nếu có) - Cần dùng STORAGE_PATH để unlink
                    if ($avatarPath && file_exists(STORAGE_PATH . DIRECTORY_SEPARATOR . $avatarPath)) {
                        @unlink(STORAGE_PATH . DIRECTORY_SEPARATOR . $avatarPath);
                    }
                    // Lưu đường dẫn kiểu: "uploads/avatars/tenfile.jpg"
                    $avatarPath = 'uploads/avatars/' . $newFileName;
                }
            } else {
                $_SESSION['error'] = "Định dạng ảnh không hợp lệ hoặc quá lớn (Max 5MB)!";
                $this->redirect('dashboard');
                return;
            }
        }

        // Update vào DB
        if ($userModel->updateProfile($userId, $fullname, $avatarPath)) {
            // Cập nhật lại session ngay lập tức
            $_SESSION['user']['fullname'] = $fullname;
            $_SESSION['user']['avatar'] = $avatarPath; // Đường dẫn mới vào session

            $_SESSION['success'] = "Cập nhật hồ sơ thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại.";
        }

        $this->redirect('dashboard');
    }

    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('dashboard');
            return;
        }

        require_once BASE_PATH . '/app/Models/User.php';
        $userModel = new User();
        $userId = Auth::user()['id'];

        $currentPass = $_POST['current_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        $user = $userModel->findById($userId);

        if (!password_verify($currentPass, $user['password'])) {
            $_SESSION['error'] = "Mật khẩu hiện tại không đúng!";
        } elseif ($newPass !== $confirmPass) {
            $_SESSION['error'] = "Mật khẩu mới không khớp!";
        } elseif (strlen($newPass) < 6) {
            $_SESSION['error'] = "Mật khẩu mới phải từ 6 ký tự trở lên!";
        } else {
            $userModel->updatePassword($userId, password_hash($newPass, PASSWORD_DEFAULT));
            $_SESSION['success'] = "Đổi mật khẩu thành công!";
        }

        $this->redirect('dashboard');
    }
}
