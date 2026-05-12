<?php
/**
 * File: header.php
 * Chuc nang: Tao phan dau trang dung chung cho website.
 */

$pageTitle = $pageTitle ?? $company['name'];
$pageDescription = $pageDescription ?? content_value('site.default_description', 'Website công ty cây cảnh, cây xanh và decor thiên nhiên cho văn phòng, showroom.');
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="keywords" content="cây cảnh, cây xanh, decor cây xanh, cây nội thất, thiết kế cảnh quan">
    <meta name="author" content="<?php echo e($company['name']); ?>">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="<?php echo asset('assets/css/style.css') . '?v=' . filemtime(PUBLIC_PATH . '/assets/css/style.css'); ?>" rel="stylesheet">
</head>
<body>
<header class="site-header">
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="zabout.php" aria-label="<?php echo e($company['name']); ?>">
                <span class="brand-mark"><i class="fa-solid fa-leaf"></i></span>
                <span class="brand-text"><?php echo e($company['name']); ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="<?php echo e(content_value('nav.toggle', 'Mở menu')); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('zabout.php'); ?>" href="zabout.php"><?php echo e(content_value('nav.about', 'Giới thiệu')); ?></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo is_active_page('faq.php'); ?>" href="faq.php"><?php echo e(content_value('nav.faq', 'FAQ')); ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="page-main">
