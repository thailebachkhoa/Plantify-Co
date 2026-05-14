<?php

/**
 * File: admin/includes/Header.php
 * Chuc nang: Header/topbar admin theo SRTDash.
 */

if (!function_exists('admin_render_header')) {
    function admin_render_header($pageTitle = 'Admin')
    {
?>
<div class="header-area">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn float-start">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="admin-header-title float-start">
                <span>Plantify Admin</span>
                <strong><?php echo e($pageTitle); ?></strong>
            </div>
        </div>
        <div class="col-md-6 col-sm-4 clearfix">
            <ul class="notification-area float-end">
                <li id="full-view"><i class="ti-fullscreen"></i></li>
                <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                <li>
                    <a href="<?= BASE_URL ?>" title="Xem website" aria-label="Xem website">
                        <i class="ti-home" style="font-size: 25px; vertical-align: middle;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
    }
}