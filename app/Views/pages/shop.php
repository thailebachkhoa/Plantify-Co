<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng - BTL Cây Cảnh</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <a href="<?= BASE_URL ?>">🌿 Plantify Co</a>
        </div>
        <nav>
            <a href="<?= BASE_URL ?>">Trang Chủ</a>
            <a href="<?= BASE_URL ?>/home/shop" style="color: var(--primary); font-weight:700;">Cửa Hàng</a>
            <a href="<?= BASE_URL ?>/news">Tin Tức</a>
            <a href="<?= BASE_URL ?>/home/about">Về Chúng Tôi</a>
            <a href="<?= BASE_URL ?>/home/contact">Liên Hệ</a>
        </nav>
        <div class="user-menu">
            <?php if ($user): ?>
                <span>👤 <?= htmlspecialchars($user['fullname']) ?></span>
                <a href="<?= BASE_URL ?>/dashboard">📊 Dashboard</a>
                <a href="<?= BASE_URL ?>/auth/logout" class="logout">Đăng Xuất</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/auth">🔐 Đăng Nhập</a>
                <a href="<?= BASE_URL ?>/auth/register">📝 Đăng Ký</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <h1>🌱 Cửa Hàng</h1>
        <div class="product-grid">
            <div class="product-card">
                <div class="product-image">🪴</div>
                <div class="product-info">
                    <h3>Cây Hạnh Phúc</h3>
                    <p>Cây lọc không khí tuyệt vời</p>
                    <div class="product-price">150.000 VNĐ</div>
                    <button class="btn">🛒 Thêm vào Giỏ</button>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">🌿</div>
                <div class="product-info">
                    <h3>Cây Dây Ô</h3>
                    <p>Dễ chăm sóc, tạo không gian xanh</p>
                    <div class="product-price">120.000 VNĐ</div>
                    <button class="btn">🛒 Thêm vào Giỏ</button>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">🌸</div>
                <div class="product-info">
                    <h3>Cây Hoa Lan</h3>
                    <p>Hoa đẹp, kéo dài suốt mùa</p>
                    <div class="product-price">250.000 VNĐ</div>
                    <button class="btn">🛒 Thêm vào Giỏ</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>