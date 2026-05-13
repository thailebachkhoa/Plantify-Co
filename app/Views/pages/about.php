<?php

/**
 * File: about.php
 * View: Trang giới thiệu Plantify Co
 */
?>
<?php require BASE_PATH . '/app/Views/partials/header.php'; ?>

<main class="site-main">
    <section class="page-hero about-hero modern-hero">
        <video
            class="hero-bg-video"
            data-hls-src="<?php echo e(asset($heroVideo)); ?>"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            aria-label="Video nền giới thiệu Plantify Co"></video>
        <div class="container">
            <div class="row g-5 align-items-end">
                <div class="col-lg-8" data-aos="fade-up">
                    <span class="section-kicker">Về Plantify</span>
                    <h1><?php echo e($page['title'] ?? 'Thiết kế mảng xanh bền vững cho không gian sống và làm việc hiện đại.'); ?></h1>
                    <p><?php echo e($page['content'] ?? 'Plantify kết hợp tư duy thiết kế, hiểu biết cây trồng và quy trình chăm sóc định kỳ để tạo nên những không gian xanh đẹp, khỏe và dễ duy trì.'); ?></p>
                    <div class="hero-actions">
                        <a href="faq" class="btn btn-success px-4">Xem FAQ</a>
                        <a href="faq" class="btn btn-outline-light px-4">Xem câu hỏi thường gặp</a>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="hero-insight-card">
                        <i class="fa-solid fa-sprout"></i>
                        <strong>Không chỉ đặt cây vào phòng</strong>
                        <span>Chúng tôi tính ánh sáng, luồng di chuyển, độ ẩm, chất liệu chậu và chi phí bảo dưỡng trước khi đề xuất phương án.</span>
                    </div>
                </div>
            </div>
            <div class="hero-metrics" data-aos="fade-up" data-aos-delay="120">
                <div><strong>120+</strong><span>không gian đã tư vấn</span></div>
                <div><strong>30 ngày</strong><span>theo dõi sau bàn giao</span></div>
                <div><strong>24h</strong><span>phản hồi hồ sơ online</span></div>
                <div><strong>4 bước</strong><span>quy trình triển khai rõ ràng</span></div>
            </div>
        </div>
    </section>

    <section class="section-padding about-story-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image-stack">
                        <?php $aboutImage = empty($page['image']) || preg_match('/^https?:\/\//', $page['image']) ? 'assets/images/aboutimg_1.png' : $page['image']; ?>
                        <img src="<?php echo e(media_url($aboutImage)); ?>" alt="Chăm sóc cây xanh trong không gian nội thất" class="img-fluid rounded-image">
                        <div class="image-note">
                            <strong>Khảo sát trước khi chọn cây</strong>
                            <span>Ánh sáng, hướng gió và thói quen sử dụng quyết định 70% độ bền của mảng xanh.</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <span class="section-kicker">Câu chuyện</span>
                    <h2 class="section-title">Từ những chậu cây nhỏ đến giải pháp xanh cho doanh nghiệp</h2>
                    <p>Chúng tôi phục vụ văn phòng, căn hộ dịch vụ, showroom, nhà hàng và không gian bán lẻ cần một hình ảnh xanh chỉn chu. Mỗi dự án bắt đầu bằng khảo sát thực tế, sau đó đội ngũ thiết kế chọn cây theo ánh sáng, độ ẩm, mật độ sử dụng và phong cách nội thất.</p>
                    <p>Plantify không chạy theo bố cục rườm rà. Chúng tôi tập trung vào cây khỏe, chậu đẹp, tỷ lệ hài hòa và quy trình chăm sóc sau bàn giao.</p>
                    <div class="about-check-grid">
                        <span><i class="fa-solid fa-check"></i> Tư vấn theo ngân sách</span>
                        <span><i class="fa-solid fa-check"></i> Bố trí theo mặt bằng</span>
                        <span><i class="fa-solid fa-check"></i> Chọn cây theo điều kiện sáng</span>
                        <span><i class="fa-solid fa-check"></i> Theo dõi sức khỏe cây</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-soft">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <span class="section-kicker">Năng lực cốt lõi</span>
                <h2>Thiết kế đẹp nhưng vẫn dễ vận hành mỗi ngày</h2>
                <p>Plantify xây dựng phương án theo cả thẩm mỹ lẫn chi phí duy trì, phù hợp cho không gian có nhiều người sử dụng.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="value-card feature-card h-100">
                        <i class="fa-solid fa-compass-drafting"></i>
                        <h3>Thiết kế đúng không gian</h3>
                        <p>Mỗi loại cây được chọn theo ánh sáng, diện tích, luồng di chuyển và chất liệu nội thất.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="80">
                    <div class="value-card feature-card h-100">
                        <i class="fa-solid fa-shield-heart"></i>
                        <h3>Cây khỏe, nguồn rõ</h3>
                        <p>Cây được kiểm tra rễ, lá, sâu bệnh và khả năng thích nghi trước khi bàn giao.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="160">
                    <div class="value-card feature-card h-100">
                        <i class="fa-solid fa-calendar-check"></i>
                        <h3>Bảo dưỡng đều đặn</h3>
                        <p>Lịch chăm sóc định kỳ giúp không gian xanh luôn sạch, an toàn và giữ hình ảnh chuyên nghiệp.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5" data-aos="fade-right">
                    <span class="section-kicker">Quy trình</span>
                    <h2 class="section-title">Rõ từng bước để khách hàng dễ theo dõi</h2>
                    <p class="text-muted">Từ ảnh không gian ban đầu đến chăm sóc định kỳ, mỗi giai đoạn đều có đầu ra cụ thể để bạn duyệt nhanh và kiểm soát ngân sách.</p>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="timeline-list">
                        <article>
                            <span>01</span>
                            <div>
                                <h3>Tiếp nhận nhu cầu</h3>
                                <p>Nhận ảnh, mặt bằng, phong cách mong muốn và mức ngân sách dự kiến.</p>
                            </div>
                        </article>
                        <article>
                            <span>02</span>
                            <div>
                                <h3>Khảo sát điều kiện</h3>
                                <p>Đánh giá ánh sáng, gió, ổ cắm, lối đi, vị trí tưới và rủi ro bẩn sàn.</p>
                            </div>
                        </article>
                        <article>
                            <span>03</span>
                            <div>
                                <h3>Đề xuất phương án</h3>
                                <p>Gợi ý cây, chậu, bố cục, tần suất chăm sóc và phương án thay thế khi cần.</p>
                            </div>
                        </article>
                        <article>
                            <span>04</span>
                            <div>
                                <h3>Bàn giao và duy trì</h3>
                                <p>Lắp đặt gọn, hướng dẫn chăm sóc, theo dõi cây sau bàn giao và bảo dưỡng định kỳ.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding testimonial-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <span class="section-kicker">Khách hàng nói gì</span>
                <h2>Phản hồi từ các dự án đã triển khai</h2>
            </div>
            <div class="row g-4">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="col-md-6" data-aos="fade-up">
                        <article class="testimonial-card h-100">
                            <i class="fa-solid fa-quote-left"></i>
                            <p><?php echo e($testimonial['quote']); ?></p>
                            <strong><?php echo e($testimonial['name']); ?></strong>
                            <span><?php echo e($testimonial['role']); ?></span>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section-padding map-section" id="plantifyMap">
        <div class="container">
            <div class="map-layout-row">
                <div class="map-copy-panel" data-aos="fade-right">
                    <div>
                        <span class="section-kicker">Vị trí</span>
                        <h2 class="section-title">Ghé Plantify để chọn cây và chậu trực tiếp</h2>
                        <p class="text-muted"><?php echo e(content_value('company.address', '')); ?></p>
                    </div>
                    <div class="map-contact-list">
                        <span><i class="fa-solid fa-phone"></i><?php echo e(content_value('company.phone', '')); ?></span>
                        <span><i class="fa-solid fa-clock"></i><?php echo e(content_value('company.hours', '')); ?></span>
                    </div>
                </div>
                <div class="map-embed-wrap" data-aos="fade-left" style="width:100%; max-width:100%; min-height:720px;">
                    <iframe
                        title="Ban do Plantify Co"
                        src="https://www.google.com/maps?q=<?php echo rawurlencode(content_value('company.address', '')); ?>&output=embed"
                        width="100%"
                        height="720"
                        style="width:100%; height:720px; min-height:72vh; display:block; border:0;"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section about-cta">
        <div class="container position-relative">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2>Muốn biết không gian của bạn hợp cây gì?</h2>
                    <p>Gửi ảnh hiện trạng, Plantify sẽ gợi ý nhóm cây, kích thước chậu và cách chăm sóc phù hợp.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo e(asset('faq')); ?>" class="btn btn-light">Xem FAQ</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>