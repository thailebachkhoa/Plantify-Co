<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thành viên - Member Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">
    <style>
        .navbar {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }

        .navbar a {
            background: white;
            color: #27ae60;
        }

        .navbar a:hover {
            background: #e8f8f5;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
            border-top: 4px solid #27ae60;
        }

        .welcome {
            background: #d5f4e6;
            border: 1px solid #27ae60;
            color: #1e8449;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .menu-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .menu-item {
            background: white;
            border: 1px solid #dee2e6;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .menu-item:hover {
            border-color: #27ae60;
            background: #f8f9fa;
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
        }

        .menu-item h3 {
            margin: 0 0 10px 0;
            color: #333;
        }

        .menu-item p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .menu-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div style="font-size: 18px;">👤 Thành viên | Xin chào, <strong><?= htmlspecialchars($user['fullname']) ?></strong></div>
        <div>
            <a href="<?= BASE_URL ?>">🌿 Mua Sắm</a>
            <a href="<?= BASE_URL ?>/auth/logout" style="background: #dc3545;"> 🚪 Đăng xuất</a>
        </div>
    </div>

    <div class="container">
        <h1>Khu vực Thành Viên</h1>
        <div class="welcome">
            Chào mừng bạn quay trở lại! Email liên hệ của bạn là: <?= htmlspecialchars($user['email']) ?>
        </div>

        <div class="menu-list">
            <div class="menu-item">
                <h3> Đổi ảnh đại diện</h3>
                <p>Cập nhật Avatar cá nhân</p>
            </div>
            <div class="menu-item">
                <h3> Thông tin & Đổi Pass</h3>
                <p>Cập nhật bảo mật</p>
            </div>
            <div class="menu-item">
                <h3> Bình luận của tôi</h3>
                <p>Xem lại bài viết / đánh giá</p>
            </div>
            <div class="menu-item">
                <h3> Mua hàng</h3>
                <p>Xem giỏ hàng & sản phẩm</p>
            </div>
        </div>

        <div class="card">
            <h2>Tin tức mới dành cho bạn</h2>
            <p>Hệ thống đang được cập nhật...</p>
        </div>
    </div>
</body>

</html>