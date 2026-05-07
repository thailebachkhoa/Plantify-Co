﻿<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng Bán Cây Cảnh - Plantify Co</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="<?= BASE_URL ?>">🌿 Plantify Co</a>
        </div>
        <nav>
            <a href="<?= BASE_URL ?>">Trang Chủ</a>
            <a href="<?= BASE_URL ?>/home/shop">Cửa Hàng</a>
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

    <!-- Hero Section -->
    <section class="hero">
        <h1>🌿 Cửa Hàng Bán Cây Cảnh Plantify Co</h1>
        <p>Khám phá bộ sưu tập cây cảnh tuyệt đẹp cho không gian sống của bạn</p>
        <div class="btn-group">
            <a href="<?= BASE_URL ?>/home/shop" class="btn btn-primary">🛍️ Mua Sắm Ngay</a>
            <a href="<?= BASE_URL ?>/home/about" class="btn btn-secondary">Tìm Hiểu Thêm</a>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <div class="feature">
            <div class="feature-icon">🚚</div>
            <h3>Giao Hàng Nhanh</h3>
            <p>Giao hàng miễn phí cho đơn hàng trên 500k</p>
        </div>
        <div class="feature">
            <div class="feature-icon">✅</div>
            <h3>Chất Lượng Đảm Bảo</h3>
            <p>Tất cả cây đều được kiểm tra kỹ trước giao</p>
        </div>
        <div class="feature">
            <div class="feature-icon">💬</div>
            <h3>Hỗ Trợ 24/7</h3>
            <p>Đội ngũ chăm sóc khách hàng sẵn sàng giúp bạn</p>
        </div>
        <div class="feature">
            <div class="feature-icon">💰</div>
            <h3>Giá Cạnh Tranh</h3>
            <p>Giá tốt nhất thị trường, thường xuyên có khuyến mãi</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products">
        <div class="products-container">
            <h2>🌱 Sản Phẩm Nổi Bật</h2>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">🪴</div>
                    <div class="product-info">
                        <h3>Cây Hạnh Phúc</h3>
                        <p>Cây lọc không khí tuyệt vời</p>
                        <div class="product-price">150.000 VNĐ</div>
                        <a href="<?= BASE_URL ?>/home/product/1" class="btn">Chi Tiết</a>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">🌿</div>
                    <div class="product-info">
                        <h3>Cây Dây Ô</h3>
                        <p>Dễ chăm sóc, tạo không gian xanh</p>
                        <div class="product-price">120.000 VNĐ</div>
                        <a href="<?= BASE_URL ?>/home/product/2" class="btn">Chi Tiết</a>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">🌸</div>
                    <div class="product-info">
                        <h3>Cây Hoa Lan</h3>
                        <p>Hoa đẹp, kéo dài suốt mùa</p>
                        <div class="product-price">250.000 VNĐ</div>
                        <a href="<?= BASE_URL ?>/home/product/3" class="btn">Chi Tiết</a>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">🍀</div>
                    <div class="product-info">
                        <h3>Cây Tứ Quý</h3>
                        <p>Mang may mắn cho gia đình</p>
                        <div class="product-price">200.000 VNĐ</div>
                        <a href="<?= BASE_URL ?>/home/product/4" class="btn">Chi Tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="info-section">
        <h2>📖 Về Cửa Hàng Của Chúng Tôi</h2>
        <p>
            BTL Cây Cảnh là một cửa hàng chuyên cung cấp các loại cây cảnh chất lượng cao,
            phù hợp cho nhiều không gian từ nhà ở, văn phòng, đến các không gian công cộng.
        </p>
        <p>
            Với đội ngũ nhân viên chuyên nghiệp, chúng tôi cam kết cung cấp những sản phẩm tốt nhất
            với giá cạnh tranh nhất. Chúng tôi cũng cung cấp hướng dẫn chăm sóc cho khách hàng
            để giúp cây của bạn phát triển khỏe mạnh.
        </p>
        <p>
            <strong>Hãy ghé thăm cửa hàng của chúng tôi hoặc mua sắm trực tuyến ngay hôm nay!</strong>
        </p>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Plantify Co. Tất cả các quyền được bảo lưu.</p>
        <p>
            <a href="<?= BASE_URL ?>/home/about">Về Chúng Tôi</a> |
            <a href="<?= BASE_URL ?>/home/contact">Liên Hệ</a> |
            <a href="#">Chính Sách Bảo Mật</a>
        </p>
    </footer>
</body>

</html>
