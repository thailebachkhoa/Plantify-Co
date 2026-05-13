<?php
require_once __DIR__ . '/includes/AdminLayout.php';
admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => $pageTitle
]);
$p = $product ?? [];
?>

<div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-body p-4">
        <form action="" method="POST">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control" value="<?= $p['name'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả ngắn</label>
                        <textarea name="description" class="form-control" rows="4"><?= $p['description'] ?? '' ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Danh mục</label>
                        <select name="category" class="form-select">
                            <option value="Để bàn" <?= ($p['category'] ?? '') == 'Để bàn' ? 'selected' : '' ?>>Để bàn</option>
                            <option value="Sàn nhà" <?= ($p['category'] ?? '') == 'Sàn nhà' ? 'selected' : '' ?>>Sàn nhà</option>
                            <option value="Ban công" <?= ($p['category'] ?? '') == 'Ban công' ? 'selected' : '' ?>>Ban công</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                        <input type="number" name="price" class="form-control" value="<?= $p['price'] ?? 0 ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Link ảnh</label>
                        <input type="text" name="image_url" class="form-control" value="<?= $p['image'] ?? '' ?>" placeholder="https://...">
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="feat" <?= ($p['is_featured'] ?? 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="feat">Sản phẩm nổi bật</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Lưu dữ liệu</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php admin_layout_end(); ?>