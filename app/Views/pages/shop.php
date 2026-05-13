<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<main class="site-main">
    <!-- HERO CỬA HÀNG -->
    <section class="page-hero" style="padding: 70px 0; background: linear-gradient(135deg, rgba(18, 56, 42, 0.9), rgba(45, 138, 95, 0.8)), url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1600&q=80') center/cover;">
        <div class="container text-center">
            <h1>Cửa Hàng Xanh</h1>
            <p class="mx-auto text-white opacity-75" style="max-width: 600px;">Tìm kiếm những chậu cây hoàn hảo để tô điểm không gian sống và thanh lọc tâm trí của bạn.</p>
        </div>
    </section>

    <section class="section-padding bg-soft">
        <div class="container">
            <!-- THANH FILTER (Giao diện) -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom" data-aos="fade-up">
                <div class="d-flex gap-2 mb-3 mb-md-0">
                    <button class="btn btn-success rounded-pill px-3 py-1">Tất cả</button>
                    <button class="btn btn-outline-success rounded-pill px-3 py-1">Để bàn</button>
                    <button class="btn btn-outline-success rounded-pill px-3 py-1">Sàn nhà</button>
                    <button class="btn btn-outline-success rounded-pill px-3 py-1">Ban công</button>
                </div>
                <select class="form-select w-auto" style="min-width: 200px;">
                    <option>Sắp xếp: Mới nhất</option>
                    <option>Giá: Thấp đến Cao</option>
                    <option>Giá: Cao xuống Thấp</option>
                </select>
            </div>

            <!-- GRID SẢN PHẨM -->
            <div class="row g-4">
                <?php foreach ($products as $item): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up">
                        <div class="product-card h-100 bg-white">
                            <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>">
                                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="w-100 object-fit-cover" style="height: 260px;">
                            </a>
                            <div class="product-body d-flex flex-column h-100">
                                <span class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;"><?= $item['category'] ?></span>
                                <h3 class="mt-1 mb-2">
                                    <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>">" class="text-dark text-decoration-none"><?= $item['name'] ?></a>
                                </h3>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                                    <strong style="font-size: 1.1rem;"><?= number_format($item['price'], 0, ',', '.') ?>đ</strong>
                                    <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>" class="btn btn-outline-success btn-sm px-3 rounded-pill"><i class="fa-solid fa-eye me-1"></i> Xem</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                        <li class="page-item active"><a class="page-link bg-success border-success" href="#">1</a></li>
                        <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
                        <li class="page-item"><a class="page-link text-success" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-success" href="#">Sau</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</main>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>