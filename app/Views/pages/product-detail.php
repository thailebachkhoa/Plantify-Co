<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<main class="site-main page-main">
    <div class="container py-4">
        <!-- Thông báo (Success/Error) -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> <?= $_SESSION['success'];
                                                                unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-success text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/shop" class="text-success text-decoration-none">Cửa hàng</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Cột Trái: Ảnh Sản Phẩm -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="rounded-image w-100" style="min-height: 500px; object-fit: cover;">
                </div>
            </div>

            <!-- Cột Phải: Thông tin & Giỏ hàng -->
            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-kicker"><?= $product['category'] ?></span>
                <h1 class="mb-3" style="color: var(--green-900); font-weight: 850; font-size: 2.5rem;"><?= $product['name'] ?></h1>
                <h2 class="mb-4" style="color: var(--green-700); font-weight: 800; font-size: 2rem;">
                    <?= number_format($product['price'], 0, ',', '.') ?> VNĐ
                </h2>

                <p class="text-muted" style="font-size: 1.05rem; line-height: 1.8;">
                    <?= $product['description'] ?>
                </p>

                <!-- Các thông số cây (Dùng grid tương tự trang about)
                <div class="about-check-grid my-4">
                    <span><i class="fa-solid fa-sun"></i> Ánh sáng: Tán xạ</span>
                    <span><i class="fa-solid fa-droplet"></i> Nước: 1-2 lần/tuần</span>
                    <span><i class="fa-solid fa-temperature-half"></i> Nhiệt độ: 18 - 28°C</span>
                    <span><i class="fa-solid fa-shield-cat"></i> An toàn cho thú cưng</span>
                </div> -->

                <hr class="my-4 text-muted">

                <!-- Form Thêm vào giỏ hàng -->
                <?php if ($user): ?>
                    <form action="<?= BASE_URL ?>/shop/addToCart" method="POST" class="d-flex align-items-center gap-3">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <div class="d-flex align-items-center border rounded p-1" style="border-color: var(--stone-200);">
                            <label for="qty" class="me-2 ms-2 text-muted fw-bold">SL:</label>
                            <input type="number" id="qty" name="quantity" value="1" min="1" class="form-control border-0 text-center" style="width: 70px; box-shadow: none;">
                        </div>
                        <button type="submit" class="btn btn-success btn-lg px-4 flex-grow-1" style="height: 52px;">
                            <i class="fa-solid fa-cart-plus me-2"></i> Thêm Vào Giỏ
                        </button>
                    </form>
                <?php else: ?>
                    <div class="p-4 rounded" style="background: var(--mint-50); border: 1px dashed var(--green-300);">
                        <p class="mb-3 text-center text-muted"><i class="fa-solid fa-lock text-success mb-2 fs-3 d-block"></i> Bạn cần đăng nhập để mua hàng.</p>
                        <a href="<?= BASE_URL ?>/auth" class="btn btn-outline-success w-100">Đăng Nhập Ngay</a>
                    </div>
                <?php endif; ?>

                <!-- Cam kết -->
                <div class="mt-4 pt-3 border-top d-flex gap-4 text-muted" style="font-size: 0.9rem;">
                    <div><i class="fa-solid fa-leaf text-success me-1"></i> Cây khỏe mạnh 100%</div>
                    <div><i class="fa-solid fa-truck text-success me-1"></i> Giao hàng an toàn</div>
                    <div><i class="fa-solid fa-rotate-left text-success me-1"></i> 1 đổi 1 trong 3 ngày</div>
                </div>
            </div>
        </div>
    </div>

    <!-- SẢN PHẨM LIÊN QUAN -->
    <section class="section-padding bg-soft mt-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <h2>Có thể bạn cũng thích</h2>
            </div>
            <div class="row g-4">
                <?php foreach ($relatedProducts as $item): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="product-card h-100 bg-white">
                            <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>">
                                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="w-100 object-fit-cover" style="height: 220px;">
                            </a>
                            <div class="product-body">
                                <span><?= $item['category'] ?></span>
                                <h3 class="mt-1 mb-2 fs-5"><a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>" class="text-dark"><?= $item['name'] ?></a></h3>
                                <strong><?= number_format($item['price'], 0, ',', '.') ?>đ</strong>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>