<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin Panel') ?> — Plantify Co</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Local admin assets (fallback to CDN above if not present) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/metismenujs.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/typography.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/default-css.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/responsive.css">
</head>
<body>
<div class="page-container">

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo">
                <a href="<?= BASE_URL ?>/admin">
                    <h2 class="text-white">🌿 Admin</h2>
                </a>
            </div>
        </div>
        <div class="main-menu">
            <div class="menu-inner">
                <nav>
                    <ul class="metismenu list-unstyled mt-3 ms-3" id="menu">
                        <li class="<?= ($activePage ?? '') === 'users' ? 'active mm-active' : '' ?>">
                            <a href="<?= BASE_URL ?>/admin">
                                <i class="fa-solid fa-users"></i>
                                <span>Quản lý Người dùng</span>
                            </a>
                        </li>
                        <li class="<?= ($activePage ?? '') === 'news' ? 'active mm-active' : '' ?>">
                            <a href="<?= BASE_URL ?>/admin/news">
                                <i class="fa-solid fa-newspaper"></i>
                                <span>Quản lý Tin tức</span>
                            </a>
                        </li>
                        <li class="<?= ($activePage ?? '') === 'comments' ? 'active mm-active' : '' ?>">
                            <a href="<?= BASE_URL ?>/admin/comments">
                                <i class="fa-solid fa-comments"></i>
                                <span>Quản lý Bình luận</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/news" target="_blank">
                                <i class="fa-solid fa-globe"></i>
                                <span>Xem Tin tức</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>">
                                <i class="fa-solid fa-house"></i>
                                <span>Về Trang chủ</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- ===== END SIDEBAR ===== -->

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content" style="min-height: 100vh; background: #f3f8fb; padding: 20px;">

        <!-- Header area -->
        <div class="header-area mb-4">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-7">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/admin">Admin</a></li>
                            <?php if (!empty($breadcrumb)): ?>
                                <li class="breadcrumb-item active"><?= htmlspecialchars($breadcrumb) ?></li>
                            <?php endif; ?>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-5">
                    <div class="user-profile float-end d-flex align-items-center gap-2">
                        <span class="d-none d-sm-inline text-muted" style="font-size:14px;">
                            <i class="fa-solid fa-user-shield me-1 text-success"></i>
                            <strong><?= htmlspecialchars($user['fullname']) ?></strong>
                        </span>
                        <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page title -->
        <div class="page-title-area mb-4">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="page-title m-0"><?= htmlspecialchars($pageTitle ?? 'Admin Panel') ?></h3>
                </div>
                <?php if (!empty($pageAction)): ?>
                <div class="col-sm-6 text-end">
                    <?= $pageAction ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- ===== PAGE CONTENT START ===== -->
