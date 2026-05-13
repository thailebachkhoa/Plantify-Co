<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<!-- Thêm class page-main (đã định nghĩa padding-top: 76px trong style.css) để tách Header -->
<main class="site-main page-main">

    <!-- HERO CỬA HÀNG -->
    <section class="page-hero" style="padding: 70px 0; background: linear-gradient(135deg, rgba(18, 56, 42, 0.9), rgba(45, 138, 95, 0.8)), url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1600&q=80') center/cover;">
        <!-- Thêm data-aos vào container để tạo hiệu ứng xuất hiện -->
        <div class="container text-center" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="display-4 fw-bold text-white">Cửa Hàng Xanh</h1>
            <p class="mx-auto text-white" data-aos="fade-left" data-aos-duration="500" data-aos-delay="200" style="max-width: 600px;">
                Tìm kiếm những chậu cây hoàn hảo để tô điểm không gian sống và thanh lọc tâm trí của bạn.
            </p>
        </div>
    </section>

    <section class="section-padding bg-soft">
        <div class="container">
            <!-- THANH FILTER -->
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
            <?php if (count($products) > 0): ?>
                <div class="row g-4">
                    <?php foreach ($products as $item): ?>
                        <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up">
                            <div class="product-card h-100 bg-white">
                                <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>">
                                    <img src="<?= htmlspecialchars($item['image'] ?? 'https://placehold.co/600x600?text=No+Image') ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-100 object-fit-cover" style="height: 260px;">
                                </a>
                                <div class="product-body d-flex flex-column h-100">
                                    <span class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                                        <?= htmlspecialchars($item['category'] ?? 'Sản phẩm') ?>
                                    </span>

                                    <!-- Sửa lỗi cú pháp thẻ <a> dư dấu ngoặc kép ở bản trước -->
                                    <h3 class="mt-1 mb-2">
                                        <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>" class="text-dark text-decoration-none">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </a>
                                    </h3>

                                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                                        <strong style="font-size: 1.1rem; color: var(--green-900);">
                                            <?= number_format($item['price'] ?? 0, 0, ',', '.') ?>đ
                                        </strong>
                                        <a href="<?= BASE_URL ?>/shop/detail/<?= $item['id'] ?>" class="btn btn-outline-success btn-sm px-3 rounded-pill">
                                            <i class="fa-solid fa-eye me-1"></i> Xem
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- HIỂN THỊ PHÂN TRANG (CHỈ HIỆN KHI CÓ TỪ 2 TRANG TRỞ LÊN) -->
                <?php if ($totalPages > 1): ?>
                    <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                        <nav aria-label="Điều hướng phân trang">
                            <ul class="pagination">
                                <!-- Nút Trước -->
                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link text-success" href="?page=<?= $currentPage - 1 ?>">Trước</a>
                                </li>

                                <!-- Vòng lặp số trang -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link <?= ($i == $currentPage) ? 'bg-success border-success text-white' : 'text-success' ?>"
                                            href="?page=<?= $i ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Nút Sau -->
                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link text-success" href="?page=<?= $currentPage + 1 ?>">Sau</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- GIAO DIỆN KHI KHÔNG CÓ SẢN PHẨM NÀO TRONG DB -->
                <div class="text-center py-5" data-aos="fade-up">
                    <div class="mb-3 text-muted" style="font-size: 4rem;">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <h3 style="color: var(--green-900);">Cửa hàng đang cập nhật sản phẩm</h3>
                    <p class="text-muted">Vui lòng quay lại sau nhé!</p>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>