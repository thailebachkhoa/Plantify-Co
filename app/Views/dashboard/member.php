<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thành viên - Member Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">

</head>

<body>
    <div class="member-nav">
        <div style="font-size: 18px; font-weight: bold; color: var(--text-main);">👤 Thành viên | Xin chào, <strong style="color: var(--primary);"> <?= htmlspecialchars($user['fullname']) ?></strong></div>
        <div>
            <a href="<?= BASE_URL ?>" class="btn btn-primary" style="margin-right: 10px;">🌿 Mua Sắm</a>
            <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-danger"> 🚪 Đăng xuất</a>
        </div>
    </div>

    <div class="container dashboard-container" style="grid-template-columns: 1fr; padding-top: 1rem;">
        <h1 style="color: var(--text-main);">Khu vực Thành Viên</h1>
        <div class="member-welcome">
            <span style="font-size: 24px;">👋</span> Chào mừng bạn quay trở lại! Email liên hệ của bạn là: <strong><?= htmlspecialchars($user['email']) ?></strong>
        </div>

        <div class="member-menu-list">
            <div class="member-menu-item">
                <h3 style="color: var(--primary-dark);"> Đổi ảnh đại diện</h3>
                <p>Cập nhật Avatar cá nhân</p>
            </div>
            <div class="member-menu-item">
                <h3 style="color: var(--primary-dark);"> Thông tin & Đổi Pass</h3>
                <p>Cập nhật bảo mật</p>
            </div>
            <div class="member-menu-item">
                <h3 style="color: var(--primary-dark);"> Bình luận của tôi</h3>
                <p>Xem lại bài viết / đánh giá</p>
            </div>
            <div class="member-menu-item">
                <h3 style="color: var(--primary-dark);"> Mua hàng</h3>
                <p>Xem giỏ hàng & sản phẩm</p>
            </div>
        </div>

        <div class="dashboard-content" style="margin-top: 2rem;">
            <h2>Tin tức mới dành cho bạn</h2>
            <p style="color: var(--text-light); margin-top: 1rem;">Hệ thống đang được cập nhật...</p>
        </div>
    </div>
</body>

</html>