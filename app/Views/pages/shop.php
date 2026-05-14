<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<?php
// Lấy các tham số từ URL để duy trì trạng thái lọc
$currentCategory = $_GET['category'] ?? 'all';
$currentSort = $_GET['sort'] ?? 'newest';
$searchKeyword = $_GET['search'] ?? '';

// Hàm tạo URL để không làm mất các tham số khác khi nhấn vào lọc/phân trang
function buildUrl($overrides = [])
{
    $params = array_merge($_GET, $overrides);
    return "?" . http_build_query($params);
}
?>

<main class="site-main" style="padding-top: 0;">

    <section class="page-hero" style="padding: 120px 0 60px 0; background: linear-gradient(135deg, rgba(18, 56, 42, 0.9), rgba(45, 138, 95, 0.8)), url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1600&q=80') center/cover;">
        <div class="container text-center" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-white">Cửa Hàng Xanh</h1>
            <p class="mx-auto text-white opacity-75" style="max-width: 600px;">
                Khám phá bộ sưu tập cây xanh được tuyển chọn để làm mới không gian sống của bạn.
            </p>

            <div class="mt-4 mx-auto" style="max-width: 500px;">
                <form action="" method="GET" class="input-group shadow-lg rounded-pill overflow-hidden">
                    <input type="hidden" name="category" value="<?= htmlspecialchars($currentCategory) ?>">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($currentSort) ?>">

                    <input type="text" name="search" class="form-control border-0 ps-4 py-3"
                        placeholder="Tìm kiếm cây bạn yêu thích..."
                        value="<?= htmlspecialchars($searchKeyword) ?>">
                    <button class="btn btn-success px-4" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section class="section-padding bg-soft py-5">
        <div class="container">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 pb-3 border-bottom" data-aos="fade-up">

                <div class="d-flex gap-2 mb-3 mb-lg-0">
                    <?php
                    $categories = [
                        'all' => 'Tất cả',
                        'Để bàn' => 'Để bàn',
                        'Sàn nhà' => 'Sàn nhà',
                        'Ban công' => 'Ban công'
                    ];
                    foreach ($categories as $key => $label): ?>
                        <a href="<?= buildUrl(['category' => $key, 'page' => 1]) ?>"
                            class="btn <?= $currentCategory === $key ? 'btn-success' : 'btn-outline-success' ?> rounded-pill px-4">
                            <?= $label ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted d-none d-md-inline">Sắp xếp:</span>
                    <select class="form-select w-auto rounded-pill" onchange="window.location.href=this.value">
                        <option value="<?= buildUrl(['sort' => 'newest']) ?>" <?= $currentSort === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                        <option value="<?= buildUrl(['sort' => 'price_asc']) ?>" <?= $currentSort === 'price_asc' ? 'selected' : '' ?>>Giá: Thấp đến Cao</option>
                        <option value="<?= buildUrl(['sort' => 'price_desc']) ?>" <?= $currentSort === 'price_desc' ? 'selected' : '' ?>>Giá: Cao xuống Thấp</option>
                    </select>
                </div>
            </div>

            <?php if ($searchKeyword): ?>
                <div class="mb-4" data-aos="fade-in">
                    <h5 class="text-muted">
                        Kết quả tìm kiếm cho: <span class="text-success">"<?= htmlspecialchars($searchKeyword) ?>"</span>
                        <a href="?" class="ms-2 btn btn-sm btn-light rounded-pill">Xóa tìm kiếm</a>
                    </h5>
                </div>
            <?php endif; ?>

            <?php if (count($products) > 0): ?>
                <div class="row g-4">
                    <?php foreach ($products as $item): ?>
                        <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up">
                            <div class="product-card h-100 bg-white shadow-sm rounded-4 overflow-hidden border-0 transition-hover">
                                <div class="position-relative overflow-hidden">
                                    <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>">
                                        <img src="<?= htmlspecialchars($item['image'] ?? 'https://placehold.co/600x600?text=No+Image') ?>"
                                            alt="<?= htmlspecialchars($item['name']) ?>"
                                            class="w-100 object-fit-cover" style="height: 250px;">
                                    </a>
                                    <?php if ($item['is_featured']): ?>
                                        <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark shadow-sm">Nổi bật</span>
                                    <?php endif; ?>
                                </div>

                                <div class="product-body p-3 d-flex flex-column h-100">
                                    <small class="text-success fw-bold text-uppercase" style="font-size: 0.7rem;">
                                        <?= htmlspecialchars($item['category']) ?>
                                    </small>
                                    <h3 class="h6 mt-1 mb-2">
                                        <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>" class="text-dark text-decoration-none">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </h3>

                                    <div class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                                        <span class="fw-bold text-danger fs-5">
                                            <?= number_format($item['price'], 0, ',', '.') ?>đ
                                        </span>
                                        <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>" class="btn btn-sm btn-success rounded-circle">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($totalPages > 1): ?>
                    <div class="d-flex justify-content-center mt-5">
                        <nav>
                            <ul class="pagination pagination-rounded">
                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= buildUrl(['page' => $currentPage - 1]) ?>">Trước</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= buildUrl(['page' => $i]) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= buildUrl(['page' => $currentPage + 1]) ?>">Sau</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" width="100" alt="Not found" class="opacity-50 mb-3">
                    <h3 class="text-muted">Không tìm thấy cây nào phù hợp</h3>
                    <p>Vui lòng thử từ khóa khác hoặc xóa bộ lọc.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
    /* Hiệu ứng hover cho card sản phẩm */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .pagination-rounded .page-link {
        border-radius: 50% !important;
        margin: 0 3px;
        border: none;
        color: #198754;
    }

    .pagination-rounded .page-item.active .page-link {
        background-color: #198754;
        color: white;
    }
</style>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>