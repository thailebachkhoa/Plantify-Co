<?php

/**
 * File: app/Views/pages/home.php
 * View: Trang chủ Plantify Co 
 */
?>
<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<main class="site-main">
    <!-- HERO SECTION -->
    <section class="page-hero modern-hero"
        style="background: linear-gradient(135deg, rgba(18, 56, 42, 0.86), rgba(31, 111, 77, 0.62)), url('https://images.unsplash.com/photo-1416879598056-0cbb04922e99?auto=format&fit=crop&w=1800&q=80') center/cover;">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row g-5 align-items-end">
                <div class="col-lg-8" data-aos="fade-up">
                    <span class="section-kicker text-white opacity-75">Khởi Đầu Mới</span>
                    <h1>Biến Không Gian Sống<br>Thành Vườn Xanh Bình Yên</h1>
                    <p class="text-white opacity-75" style="max-width: 600px;">Khám phá bộ sưu tập cây cảnh tuyển chọn
                        giúp thanh lọc không khí, mang lại cảm giác thư thái và nguồn năng lượng tích cực cho ngôi nhà
                        của bạn.</p>
                    <div class="hero-actions">
                        <a href="<?= BASE_URL ?>/shop" class="btn btn-success px-4"><i
                                class="fa-solid fa-bag-shopping me-2"></i> Mua Sắm Ngay</a>
                        <a href="<?= BASE_URL ?>/about" class="btn btn-outline-light px-4">Tìm Hiểu Thêm</a>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-left" data-aos-delay="100">
                    <div class="hero-insight-card">
                        <i class="fa-solid fa-leaf"></i>
                        <strong>100% Cây Khỏe Mạnh</strong>
                        <span>Được chăm sóc và kiểm tra kỹ lưỡng bởi chuyên gia thực vật trước khi giao đến tay
                            bạn.</span>
                    </div>
                </div>
            </div>
            <div class="hero-metrics" data-aos="fade-up" data-aos-delay="200">
                <div><strong>500+</strong><span>Sản phẩm đa dạng</span></div>
                <div><strong>100%</strong><span>Giao hàng an toàn</span></div>
                <div><strong>24/7</strong><span>Hỗ trợ chăm sóc</span></div>
                <div><strong>30 ngày</strong><span>Đồng hành cùng cây</span></div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="section-padding bg-soft">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <span class="section-kicker">Tại Sao Chọn Chúng Tôi</span>
                <h2>Chất lượng dịch vụ đi cùng vẻ đẹp mảng xanh</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="value-card h-100 text-center">
                        <div class="icon-box mx-auto"><i class="fa-solid fa-truck-fast"></i></div>
                        <h3>Giao Hàng Nhanh</h3>
                        <p class="mb-0">Miễn phí cho đơn hàng trên 500k. Đảm bảo cây luôn tươi mới khi đến tay.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-card h-100 text-center">
                        <div class="icon-box mx-auto"><i class="fa-solid fa-shield-check"></i></div>
                        <h3>Chất Lượng Đảm Bảo</h3>
                        <p class="mb-0">Tất cả cây đều được đội ngũ chuyên gia kiểm tra sức khỏe rễ và lá kỹ lưỡng.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-card h-100 text-center">
                        <div class="icon-box mx-auto"><i class="fa-solid fa-headset"></i></div>
                        <h3>Hỗ Trợ 24/7</h3>
                        <p class="mb-0">Tư vấn cách chăm sóc cây trọn đời qua Zalo và Hotline của Plantify.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="value-card h-100 text-center">
                        <div class="icon-box mx-auto"><i class="fa-solid fa-tag"></i></div>
                        <h3>Giá Cạnh Tranh</h3>
                        <p class="mb-0">Cam kết mức giá tốt nhất thị trường kèm nhiều chương trình ưu đãi hàng tháng.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCTS SECTION -->
    <section class="section-padding">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <span class="section-kicker">Sản Phẩm Nổi Bật</span>
                <h2>Bộ sưu tập được yêu thích nhất tháng</h2>
            </div>

            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="product-card h-100">
                        <img src="https://images.unsplash.com/photo-1599598425947-3300262b32ee?auto=format&fit=crop&w=600&q=80"
                            alt="Cây Hạnh Phúc">
                        <div class="product-body d-flex flex-column h-100">
                            <span>Lọc không khí</span>
                            <h3 class="mt-1 mb-2">Cây Hạnh Phúc</h3>
                            <p class="small flex-grow-1">Mang lại may mắn, sung túc và tạo điểm nhấn sang trọng cho
                                phòng khách.</p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-2">
                                <strong>150.000đ</strong>
                                <a href="<?= BASE_URL ?>/shop/detail/1" class="btn btn-outline-success btn-sm px-3">Chi
                                    Tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="product-card h-100">
                        <img src="https://images.unsplash.com/photo-1620127813580-5a3d078170c0?auto=format&fit=crop&w=600&q=80"
                            alt="Cây Lưỡi Hổ">
                        <div class="product-body d-flex flex-column h-100">
                            <span>Phòng ngủ</span>
                            <h3 class="mt-1 mb-2">Cây Lưỡi Hổ</h3>
                            <p class="small flex-grow-1">Khả năng lọc sạch độc tố, nhả oxy vào ban đêm, lý tưởng cho
                                không gian nghỉ ngơi.</p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-2">
                                <strong>120.000đ</strong>
                                <a href="<?= BASE_URL ?>/shop/detail/2" class="btn btn-outline-success btn-sm px-3">Chi
                                    Tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-card h-100">
                        <img src="https://images.unsplash.com/photo-1597558661625-f09db324b172?auto=format&fit=crop&w=600&q=80"
                            alt="Hoa Lan Ý">
                        <div class="product-body d-flex flex-column h-100">
                            <span>Có hoa</span>
                            <h3 class="mt-1 mb-2">Hoa Lan Ý</h3>
                            <p class="small flex-grow-1">Vẻ đẹp thanh tao, tinh khiết, giúp cân bằng độ ẩm không khí cực
                                tốt.</p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-2">
                                <strong>250.000đ</strong>
                                <a href="<?= BASE_URL ?>/shop/detail/3" class="btn btn-outline-success btn-sm px-3">Chi
                                    Tiết</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="product-card h-100">
                        <img src="https://images.unsplash.com/photo-1628157748443-bd21568c0dd4?auto=format&fit=crop&w=600&q=80"
                            alt="Cây Kim Tiền">
                        <div class="product-body d-flex flex-column h-100">
                            <span>Phong thủy</span>
                            <h3 class="mt-1 mb-2">Cây Kim Tiền</h3>
                            <p class="small flex-grow-1">Biểu tượng của tài lộc, phát triển mạnh mẽ và rất dễ chăm sóc
                                tại văn phòng.</p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-2">
                                <strong>200.000đ</strong>
                                <a href="<?= BASE_URL ?>/shop/detail/4" class="btn btn-outline-success btn-sm px-3">Chi
                                    Tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="<?= BASE_URL ?>/shop" class="btn btn-success px-4 py-2">Xem Tất Cả Sản Phẩm <i
                        class="fa-solid fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <!-- INFO SECTION -->
    <section class="section-padding about-story-section bg-soft">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image-stack">
                        <img src="https://images.unsplash.com/photo-1463320726281-696a485928c7?auto=format&fit=crop&w=1200&q=80"
                            alt="Câu chuyện Plantify" class="img-fluid rounded-image">
                        <div class="image-note">
                            <strong>Đồng hành cùng sự phát triển</strong>
                            <span>Chúng tôi cung cấp kiến thức để bất kỳ ai cũng có thể làm vườn.</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <span class="section-kicker">Câu Chuyện Của Chúng Tôi</span>
                    <h2 class="section-title">Khát khao mang không gian xanh vào cuộc sống hiện đại</h2>
                    <p>Plantify Co ra đời từ tình yêu với thiên nhiên. Chúng tôi tin rằng, một mầm xanh không chỉ làm
                        đẹp căn phòng mà còn là liệu pháp tinh thần vô giá sau những giờ làm việc căng thẳng.</p>
                    <p>Với quy trình tuyển chọn khắt khe từ các nhà vườn uy tín, chúng tôi cam kết mỗi sản phẩm gửi đi
                        đều đạt chất lượng cao nhất. Chúng tôi không chỉ bán cây, mà còn trao đi nguồn năng lượng chữa
                        lành từ tự nhiên.</p>
                    <div class="about-check-grid mt-4">
                        <span><i class="fa-solid fa-check"></i> Cây trồng hữu cơ</span>
                        <span><i class="fa-solid fa-check"></i> Chậu gốm thủ công</span>
                        <span><i class="fa-solid fa-check"></i> Tư vấn miễn phí</span>
                        <span><i class="fa-solid fa-check"></i> Bao bì thân thiện</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <div class="container position-relative">
            <div class="row align-items-center g-4 text-center text-lg-start">
                <div class="col-lg-8">
                    <h2>Sẵn sàng mang thiên nhiên vào nhà?</h2>
                    <p class="mb-0">Đừng ngần ngại liên hệ nếu bạn cần chuyên gia của Plantify tư vấn loại cây phù hợp
                        với không gian và mệnh của mình.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?= BASE_URL ?>/shop"
                        class="btn btn-light btn-lg text-success fw-bold px-4 rounded-pill cta-button">Bắt Đầu Mua
                        Sắm</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>