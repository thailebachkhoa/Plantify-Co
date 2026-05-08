<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - BTL Cây Cảnh</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">
</head>

<body>
    <nav class="navbar">
        <div style="font-size: 20px; font-weight: bold;">🌿 BTL Cây Cảnh</div>
        <div>
            <a href="<?= BASE_URL ?>">Trang Chủ</a>
            <a href="<?= BASE_URL ?>/home/shop">Cửa Hàng</a>
            <a href="<?= BASE_URL ?>/news">Tin Tức</a>
            <?php if ($user): ?>
                <a href="<?= BASE_URL ?>/dashboard">Dashboard</a>
                <a href="<?= BASE_URL ?>/auth/logout">Đăng Xuất</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/auth">Đăng Nhập</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <h1>🛒 Giỏ Hàng</h1>
        <div class="empty-cart">
            <h2>Giỏ hàng trống</h2>
            <p>Bạn chưa thêm sản phẩm nào vào giỏ hàng.</p>
            <a href="<?= BASE_URL ?>/home/shop" class="btn">← Tiếp tục mua sắm</a>
        </div>
    </div>
</body>

</html>