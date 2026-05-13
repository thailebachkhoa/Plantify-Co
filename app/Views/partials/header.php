<?php

/**
 * File: header.php
 * Chuc nang: Tao phan dau trang dung chung cho website.
 */

// Đặt giá trị mặc định nếu Database chưa có
$companyName = $company['name'] ?? 'Plantify Co';

$pageTitle = $pageTitle ?? $companyName;
$pageDescription = $pageDescription ?? content_value('site.default_description', 'Website công ty cây cảnh, cây xanh và decor thiên nhiên cho văn phòng, showroom.');
?>
<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="keywords" content="cây cảnh, cây xanh, decor cây xanh, cây nội thất, thiết kế cảnh quan">
    <meta name="author" content="<?php echo e($companyName); ?>">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    <?php if (!empty($extraCss) && is_array($extraCss)): ?>
        <?php foreach ($extraCss as $cssFile): ?>
            <?php $cssPath = strpos($cssFile, 'http') === 0 ? $cssFile : BASE_URL . '/' . ltrim($cssFile, '/'); ?>
            <link href="<?= $cssPath ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <header class="site-header">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>" aria-label="<?php echo e($companyName); ?>">
                    <span class="brand-mark"><i class="fa-solid fa-leaf"></i></span>
                    <span class="brand-text"><?php echo e($companyName); ?></span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Mở menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active_page(''); ?>" href="<?= BASE_URL ?>">Trang Chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active_page('shop'); ?>" href="<?= BASE_URL ?>/shop">Cửa Hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active_page('news'); ?>" href="<?= BASE_URL ?>/news">Tin Tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active_page('about'); ?>" href="<?= BASE_URL ?>/about">Về Chúng Tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active_page('contact'); ?>" href="<?= BASE_URL ?>/contact">Liên Hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_active_page('faq'); ?>" href="<?= BASE_URL ?>/faq"><?php echo e(content_value('nav.faq', 'FAQ')); ?></a>
                        </li>
                    </ul>
                    </ul>

                    <div class="d-flex align-items-center gap-2 ms-lg-4 mt-3 mt-lg-0">
                        <?php if (!empty($user)): ?>
                            <span class="text-secondary fw-medium me-2">
                                <i class="fa-solid fa-user me-1"></i><?= htmlspecialchars($user['fullname']) ?>
                            </span>
                            <a href="<?= BASE_URL ?>/dashboard" class="btn btn-sm btn-outline-success">
                                <i class="fa-solid fa-chart-simple me-1"></i>Dashboard
                            </a>
                            <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-right-from-bracket me-1"></i>Đăng Xuất
                            </a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>/auth" class="btn btn-sm btn-outline-success">
                                <i class="fa-solid fa-lock me-1"></i>Đăng Nhập
                            </a>
                            <a href="<?= BASE_URL ?>/auth/register" class="btn btn-sm btn-success">
                                <i class="fa-solid fa-pen-to-square me-1"></i>Đăng Ký
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="site-main">