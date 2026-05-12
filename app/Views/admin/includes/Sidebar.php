<?php
/**
 * File: admin/includes/Sidebar.php
 * Chuc nang: Sidebar admin theo structure cua SRTDash.
 */

if (!function_exists('admin_sidebar_item')) {
    function admin_sidebar_item($href, $icon, $label, $activePage)
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        $current = basename($path);
        $active = $current === $activePage ? ' class="active"' : '';

        echo '<li' . $active . '>';
        echo '<a href="' . e($href) . '"><i class="' . e($icon) . '"></i><span>' . e($label) . '</span></a>';
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
                    <a href="index.php" aria-label="GreenNest admin">
                        <i class="fa-solid fa-leaf admin-brand-icon"></i>
                        <span>GreenNest</span>
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <?php admin_sidebar_item('index.php', 'ti-dashboard', 'Dashboard', 'index.php'); ?>
                            <?php admin_sidebar_item('pages.php', 'ti-layout-media-center-alt', 'Noi dung website', 'pages.php'); ?>
                            <?php admin_sidebar_item('faqs.php', 'ti-help-alt', 'FAQ', 'faqs.php'); ?>
                            <?php admin_sidebar_item('rag.php', 'ti-comments', 'Du lieu bot', 'rag.php'); ?>
                            <li>
                                <a href="../zabout.php"><i class="ti-home"></i><span>Xem website</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <?php
    }
}
