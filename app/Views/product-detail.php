<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm - BTL Cây Cảnh</title>
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
        <a href="<?= BASE_URL ?>/home/shop" style="color: #667eea; text-decoration: none; margin-bottom: 1rem; display: inline-block;">← Quay lại Cửa Hàng</a>

        <div class="product-detail">
            <div class="product-image">🌿</div>

            <div class="product-info">
                <h1>Cây Hạnh Phúc</h1>

                <div class="rating">⭐⭐⭐⭐⭐ (25 đánh giá)</div>

                <div class="price">150.000 VNĐ</div>

                <div class="description">
                    <p>Cây Hạnh Phúc (Money Plant) là một loại cây cảnh phổ biến, được cho rằng mang lại may mắn và thịnh vượng cho gia đình.</p>
                </div>

                <div class="info-box">
                    <strong>✓ Lọc không khí tuyệt vời</strong><br>
                    <strong>✓ Dễ chăm sóc, phù hợp với người mới bắt đầu</strong><br>
                    <strong>✓ Phát triển nhanh trong ánh sáng gián tiếp</strong>
                </div>

                <div class="quantity">
                    <label>Số lượng:</label>
                    <input type="number" value="1" min="1" max="10">
                </div>

                <button class="btn" onclick="addToCart()">🛒 Thêm vào Giỏ Hàng</button>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #ddd;">
                    <h3>📋 Chi Tiết Sản Phẩm</h3>
                    <p style="margin-top: 1rem; color: #666;">
                        <strong>Kích thước:</strong> 25-30cm<br>
                        <strong>Loại chậu:</strong> Sứ cao cấp<br>
                        <strong>Mức độ chăm sóc:</strong> Dễ<br>
                        <strong>Ánh sáng:</strong> Gián tiếp<br>
                        <strong>Tần suất tưới:</strong> 2-3 lần/tuần
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToCart() {
            alert('Đã thêm vào giỏ hàng!');
        }
    </script>
</body>

</html>