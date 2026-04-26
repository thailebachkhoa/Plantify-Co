<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về Chúng Tôi - BTL Cây Cảnh</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">
</head>

<body>
    <nav class="navbar">
        <div style="font-size: 20px; font-weight: bold;">🌿 BTL Cây Cảnh</div>
        <div>
            <a href="<?= BASE_URL ?>">Trang Chủ</a>
            <a href="<?= BASE_URL ?>/home/shop">Cửa Hàng</a>
            <a href="<?= BASE_URL ?>/home/cart">🛒 Giỏ Hàng</a>
            <?php if ($user): ?>
                <a href="<?= BASE_URL ?>/dashboard">Dashboard</a>
                <a href="<?= BASE_URL ?>/auth/logout">Đăng Xuất</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/auth">Đăng Nhập</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div class="content">
            <h1>📖 Về Chúng Tôi</h1>

            <h2>🌱 Câu Chuyện Của BTL Cây Cảnh</h2>
            <p>
                BTL Cây Cảnh được thành lập vào năm 2020 với mục tiêu mang lại những cây cảnh
                chất lượng cao đến với mọi gia đình tại Việt Nam. Chúng tôi tin rằng cây cảnh
                không chỉ làm đẹp không gian sống mà còn giúp cải thiện chất lượng không khí
                và mang lại cảm giác bình yên cho tâm hồn.
            </p>

            <h2>🎯 Sứ Mệnh</h2>
            <p>
                Cung cấp những cây cảnh tuyệt đẹp, khỏe mạnh với giá cạnh tranh nhất,
                đồng thời trao tặng kiến thức chăm sóc cây cho mọi khách hàng.
            </p>

            <h2>✨ Tại Sao Chọn Chúng Tôi?</h2>
            <ul>
                <li><strong>Cây Chất Lượng:</strong> Tất cả cây đều được kiểm tra kỹ lưỡng trước khi giao cho khách hàng</li>
                <li><strong>Giá Hợp Lý:</strong> Chúng tôi cung cấp giá tốt nhất trên thị trường</li>
                <li><strong>Giao Hàng Nhanh:</strong> Giao hàng miễn phí cho đơn từ 500k</li>
                <li><strong>Hỗ Trợ Tận Tình:</strong> Đội ngũ nhân viên luôn sẵn sàng giúp đỡ 24/7</li>
                <li><strong>Tư Vấn Miễn Phí:</strong> Hướng dẫn chăm sóc chi tiết cho từng loại cây</li>
            </ul>

            <h2>📞 Liên Hệ Với Chúng Tôi</h2>
            <p>
                <strong>Email:</strong> <a href="mailto:info@btlcaycanhh.com">info@btlcaycanh.com</a><br>
                <strong>Điện Thoại:</strong> 0123 456 789<br>
                <strong>Địa Chỉ:</strong> 123 Đường ABC, Quận XYZ, TP HCM
            </p>
        </div>
    </div>
</body>

</html>