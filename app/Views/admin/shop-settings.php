<?php

/**
 * File: admin/shop_settings.php
 * Chức năng: Cấu hình các câu chữ, nhãn (site_content) cho trang Shop và Chi tiết sản phẩm.
 */
require_once __DIR__ . '/includes/AdminLayout.php';

$pageTitle = 'Cấu hình Cửa hàng | Plantify Admin';
$db = Database::getInstance();
$message = '';
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_shop_content'])) {
    try {
        $contents = $_POST['content'] ?? [];
        foreach ($contents as $key => $value) {
            $db->query("UPDATE site_content SET content_value = :val WHERE content_key = :key");
            $db->bind(':val', $row_value = $value); // Giữ nguyên value, không strip tags nếu cần dùng HTML nhẹ
            $db->bind(':key', $key);
            $db->execute();
        }
        $message = "Đã cập nhật các cấu hình cửa hàng thành công!";
    } catch (Exception $e) {
        $error = "Có lỗi xảy ra: " . $e->getMessage();
    }
}


$db->query("SELECT * FROM site_content 
            WHERE content_group IN ('Trang cửa hàng', 'Trang chi tiết SP', 'Trang giỏ hàng') 
            ORDER BY FIELD(content_group, 'Trang cửa hàng', 'Trang chi tiết SP', 'Trang giỏ hàng'), id ASC");
$allSettings = $db->resultSet();


$groups = [];
foreach ($allSettings as $item) {
    $groups[$item['content_group']][] = $item;
}

admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Cấu hình giao diện Cửa hàng',
    'subtitle' => 'Chỉnh sửa các tiêu đề, nút bấm và nhãn hiển thị trên trang bán hàng.'
]);
?>

<div class="row">
    <div class="col-12 mt-4">
        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i> <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <?php foreach ($groups as $groupName => $items): ?>
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 text-success fw-bold"><i class="ti-settings me-2"></i> <?= $groupName ?></h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <?php foreach ($items as $item): ?>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-dark">
                                        <?= htmlspecialchars($item['label']) ?>
                                        <small class="text-muted fw-normal d-block" style="font-size: 0.7rem;">Key: <?= $item['content_key'] ?></small>
                                    </label>

                                    <?php if ($item['input_type'] === 'textarea'): ?>
                                        <textarea name="content[<?= $item['content_key'] ?>]" class="form-control" rows="3"><?= htmlspecialchars($item['content_value']) ?></textarea>
                                    <?php else: ?>
                                        <input type="text" name="content[<?= $item['content_key'] ?>]" class="form-control" value="<?= htmlspecialchars($item['content_value']) ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="settings-actions mb-5">
                <button type="submit" name="update_shop_content" class="btn btn-success btn-lg px-5 rounded-pill shadow">
                    <i class="fa-solid fa-save me-2"></i> Lưu tất cả thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<?php admin_layout_end(); ?>