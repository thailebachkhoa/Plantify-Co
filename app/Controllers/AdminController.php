<?php
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

        // Check if admin account is locked
        if (!Auth::isActive()) {
            session_destroy();
            header('Location: ' . BASE_URL . '/auth');
            exit;
        }
    }

    public function index()
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        $this->view('dashboard/admin', [
            'user' => Auth::user(),
            'users' => $users
        ]);
    }

    /**
     * Toggle user status (lock/unlock)
     * Only admin can change non-admin user status
     */
    public function toggle_status($id)
    {
        $userModel = new User();
        $targetUser = $userModel->findById($id);

        // Prevent locking own account or admin accounts
        if ($targetUser && $targetUser['role'] !== 'admin' && $targetUser['id'] != Auth::id()) {
            $newStatus = ($targetUser['status'] === 'active') ? 'locked' : 'active';
            $userModel->updateStatus($id, $newStatus);
        }

        $this->redirect('admin');
    }

    /**
     * Reset user password to default (123456)
     * Only admin can reset passwords for non-admin users
     */
    public function reset_password($id)
    {
        $userModel = new User();
        $targetUser = $userModel->findById($id);

        // Prevent resetting own password and admin passwords
        if ($targetUser && $targetUser['role'] !== 'admin' && $targetUser['id'] != Auth::id()) {
            $defaultPassword = password_hash('123456', PASSWORD_DEFAULT);
            $userModel->resetPassword($id, $defaultPassword);
        }

        $this->redirect('admin');
    }

    /**
     * Delete user
     */
    public function delete_user($id)
    {
        // Prevent deleting own account and admin accounts
        if ($id == Auth::id()) {
            $this->redirect('admin');
            return;
        }

        $userModel = new User();
        $targetUser = $userModel->findById($id);

        if ($targetUser && $targetUser['role'] !== 'admin') {
            $userModel->deleteUser($id);
        }

        $this->redirect('admin');
    }
}
