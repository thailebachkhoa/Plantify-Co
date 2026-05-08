<?php
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

    public function index()
    {
        // Redirect admin to admin panel
        if (Auth::isAdmin()) {
            $this->redirect('admin');
            return;
        }

        // Show member dashboard
        if (Auth::isMember()) {
            $this->view('member/index', ['user' => Auth::user()]);
            return;
        }

        // Unknown role
        echo "Lỗi: Vai trò không xác định.";
        exit;
    }
}
