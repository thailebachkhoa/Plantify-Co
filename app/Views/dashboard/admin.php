<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard - User Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Fix đường dẫn assets bằng BASE_URL để tránh lỗi URL Rewrite nếu người dùng có sẵn file css nội bộ -->
    <!-- Trong trường hợp người dùng chưa cài assets nội bộ, em có fallback thêm Bootstrap CDN bên dưới để k bị nát thẻ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Original Template CSS references -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/metismenujs.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/typography.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/default-css.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/responsive.css">
</head>

<body>
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="<?= BASE_URL ?>/admin">
                        <h2 class="text-white">Admin Panel</h2>
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu list-unstyled mt-3 ms-3" id="menu">
                            <li class="active">
                                <a href="<?= BASE_URL ?>/admin" aria-expanded="true"><i class="fa-solid fa-users"></i> <span>Quản lý Người dùng</span></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-solid fa-box"></i> <span>Quản lý Sản phẩm</span></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-solid fa-newspaper"></i> <span>Quản lý Tin tức</span></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa-solid fa-cog"></i> <span>Cài đặt Website</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->

        <!-- main content area start -->
        <div class="main-content" style="min-height: 100vh; background: #f3f8fb; padding: 20px;">
            <!-- header area start -->
            <div class="header-area mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <!-- Navigation có thể giấu/ẩn theo template admin -->
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <div class="user-profile float-end d-flex align-items-center">
                            <h4 class="user-name dropdown-toggle m-0 me-3">Xin chào, <?= htmlspecialchars($user['fullname']) ?> (Admin)</h4>
                            <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header area end -->

            <!-- page title area start -->
            <div class="page-title-area mb-4">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h3 class="page-title float-start m-0">Quản lý Tài Khoản</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->

            <div class="main-content-inner" id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h4 class="header-title mb-4">Danh sách Thành viên Hệ thống</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered text-center align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên Đăng Nhập</th>
                                                <th>Họ và Tên</th>
                                                <th>Chức Vụ</th>
                                                <th>Email</th>
                                                <th>Trạng Thái</th>
                                                <th>Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $u): ?>
                                                <tr>
                                                    <td><?= $u['id'] ?></td>
                                                    <td><strong><?= htmlspecialchars($u['username']) ?></strong></td>
                                                    <td><?= htmlspecialchars($u['fullname']) ?></td>
                                                    <td>
                                                        <?php if ($u['role'] == 'admin'): ?>
                                                            <span class="badge bg-danger">Quản trị viên</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Thành viên</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                                    <td>
                                                        <?php if ($u['status'] == 'active'): ?>
                                                            <span class="badge bg-success">Hoạt động</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark">Bị Khoá</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($u['role'] != 'admin'): ?>
                                                            <a href="<?= BASE_URL ?>/admin/reset_password/<?= $u['id'] ?>" class="btn btn-warning btn-sm mx-1 text-white" onclick="return confirm('Bạn có chắc muốn cấp lại mật khẩu mặc định (123456) cho tài khoản này không?')">
                                                                <i class="fa-solid fa-key"></i> Reset
                                                            </a>

                                                            <?php if ($u['status'] == 'active'): ?>
                                                                <a href="<?= BASE_URL ?>/admin/toggle_status/<?= $u['id'] ?>" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Bạn có muốn khoá quyền truy cập của người này?')">
                                                                    <i class="fa-solid fa-lock"></i> Khoá
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="<?= BASE_URL ?>/admin/toggle_status/<?= $u['id'] ?>" class="btn btn-success btn-sm mx-1">
                                                                    <i class="fa-solid fa-unlock"></i> Mở
                                                                </a>
                                                            <?php endif; ?>

                                                            <a href="<?= BASE_URL ?>/admin/delete_user/<?= $u['id'] ?>" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Xóa người dùng này? Hành động này không thể hoàn tác!')">
                                                                <i class="fa-solid fa-trash"></i> Xóa
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted"><i class="fa-solid fa-shield"></i> Không thể can thiệp</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->

        <!-- footer area start-->
        <footer style="background: white; padding: 20px; text-align: center; border-top: 1px solid #eee;">
            <div class="footer-area">
                <p>© Copyright 2026. Quản trị hệ thống MVC BTL.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->

    <!-- bootstrap 5 js & CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/scripts.js"></script>
</body>

</html>