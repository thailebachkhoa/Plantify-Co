<?php

/**
 * File: admin/includes/Sidebar.php
 */

if (!function_exists('admin_sidebar_item')) {
    function admin_sidebar_item($route, $icon, $label, $activeMatch)
    {
        // Lấy URI hiện tại để kiểm tra active
        $currentUri = $_SERVER['REQUEST_URI'] ?? '';
        $active = (strpos($currentUri, $activeMatch) !== false) ? ' class="active"' : '';

        echo '<li' . $active . '>';
        echo '<a href="' . BASE_URL . '/admin/' . ltrim($route, '/') . '"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
        echo '</li>';
    }
}

if (!function_exists('admin_render_sidebar')) {
    function admin_render_sidebar()
    {
?>
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="<?= BASE_URL ?>/admin">
                <i class="fa-solid fa-leaf admin-brand-icon"></i>
                <span>Plantify Admin</span>
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <?php admin_sidebar_item('', 'ti-dashboard', 'Dashboard', 'admin'); ?>
                    <?php admin_sidebar_item('shop_settings', 'ti-shopping-cart-full', 'Cấu hình Cửa hàng', 'shop-settings'); ?>
                    <?php admin_sidebar_item('pages', 'ti-layout-media-center', 'Nội dung Trang Giới Thiệu', 'pages'); ?>
                    <?php admin_sidebar_item('news', 'ti-agenda', 'Quản lý Tin tức', 'news'); ?>
                    <?php admin_sidebar_item('comments', 'ti-comments-smiley', 'Bình luận', 'comments'); ?>
                    <?php admin_sidebar_item('faqs', 'ti-help-alt', 'FAQ', 'faqs'); ?>
                    <?php admin_sidebar_item('users', 'ti-user', 'Thành viên', 'users'); ?>
                    <?php admin_sidebar_item('rag', 'ti-comments', 'Dữ liệu bot', 'rag'); ?>
                    <?php admin_sidebar_item('products', 'ti-package', 'Quản lý Sản phẩm', 'products'); ?>
                    <?php admin_sidebar_item('contacts', 'ti-email', 'Liên hệ', 'contacts'); ?>
                    <li>
                        <a href="<?= BASE_URL ?>"><i class="ti-home"></i><span>Xem website</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php
    }
}