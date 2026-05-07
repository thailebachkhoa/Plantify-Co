<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - BTL Cây Cảnh</title>
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
        <div class="contact-form">
            <h1>📧 Liên Hệ Với Chúng Tôi</h1>

            <form method="POST" id="contactForm">
                <div class="form-group">
                    <label for="name">Tên của bạn</label>
                    <input type="text" id="name" name="name" placeholder="Nhập tên" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="example@email.com" required>
                </div>

                <div class="form-group">
                    <label for="message">Tin Nhắn</label>
                    <textarea id="message" name="message" placeholder="Nhập tin nhắn của bạn..." required></textarea>
                </div>

                <button type="submit" class="btn">📤 Gửi Liên Hệ</button>
            </form>

            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #ddd;">
                <h2 style="color: #667eea; margin-bottom: 1rem;">📍 Thông Tin Liên Hệ</h2>
                <p><strong>Email:</strong> info@btlcaycanh.com</p>
                <p><strong>Điện Thoại:</strong> 0123 456 789</p>
                <p><strong>Địa Chỉ:</strong> 123 Đường ABC, Quận XYZ, TP HCM</p>
                <p><strong>Giờ Làm Việc:</strong> Thứ 2 - Chủ Nhật: 8:00 - 20:00</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
            this.reset();
        });
    </script>
</body>

</html>