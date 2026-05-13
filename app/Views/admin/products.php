<?php
require_once __DIR__ . '/includes/AdminLayout.php';
$pageTitle = 'Quản lý Sản phẩm | Plantify Admin';

$actionHtml = '<a href="' . BASE_URL . '/admin/product_create" class="btn btn-primary rounded-pill px-4"><i class="fa fa-plus me-2"></i>Thêm sản phẩm</a>';

admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Quản lý Sản phẩm',
    'subtitle' => 'Danh sách cây cảnh và phụ kiện trong hệ thống.',
    'actionHtml' => $actionHtml
]);
?>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Nổi bật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $p): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded shadow-sm">
                                    </td>
                                    <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                                    <td class="text-center"><span class="badge bg-info text-dark"><?= htmlspecialchars($p['category']) ?></span></td>
                                    <td class="text-center"><?= number_format($p['price'], 0, ',', '.') ?>đ</td>
                                    <td class="text-center">
                                        <?= $p['is_featured'] ? '<span class="text-warning"><i class="fa fa-star"></i></span>' : '' ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= BASE_URL ?>/admin/product_edit/<?= $p['id'] ?>" class="btn btn-outline-primary btn-sm mx-1">
                                            <i class="fa-solid fa-pen-to-square"></i> Sửa
                                        </a>
                                        <a href="<?= BASE_URL ?>/admin/product_delete/<?= $p['id'] ?>" class="btn btn-outline-danger btn-sm mx-1" onclick="return confirm('Xóa sản phẩm này?')">
                                            <i class="fa-solid fa-trash"></i> Xóa
                                        </a>
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

<?php admin_layout_end(); ?>