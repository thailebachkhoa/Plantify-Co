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
            $fileExtension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $allowedExts) && $_FILES['avatar']['size'] < 5000000) {
                $newFileName = 'user_' . $userId . '_' . time() . '.' . $fileExtension;
                $uploadDir = BASE_PATH . '/public/assets/uploads/avatars/';

                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $newFileName)) {
                    $avatarPath = 'assets/uploads/avatars/' . $newFileName;
                }
            } else {
                $_SESSION['error'] = "Định dạng ảnh không hợp lệ hoặc quá lớn (Max 5MB)!";
                $this->redirect('dashboard');
                return;
            }
        }

        // Update vào DB
        if ($userModel->updateProfile($userId, $fullname, $avatarPath)) {
            $_SESSION['success'] = "Cập nhật hồ sơ thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại.";
        }

        $this->redirect('dashboard');
    }
}
