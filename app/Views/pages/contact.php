<?php

/**
 * File: app/Views/pages/contact.php
 * Chức năng: Trang liên hệ đồng bộ UI với style.css
 */
$pageTitle = 'Liên Hệ | Plantify Co';
require BASE_PATH . '/app/Views/partials/header.php';
?>

<main class="site-main">
    <!-- HERO SECTION -->
    <section class="page-hero modern-hero" style="background: linear-gradient(135deg, rgba(18, 56, 42, 0.88), rgba(46, 111, 134, 0.62)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80') center/cover; padding: 100px 0 60px;">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row g-5 align-items-end">
                <div class="col-lg-8" data-aos="fade-up">
                    <span class="section-kicker text-white opacity-75">Kết Nối Với Plantify</span>
                    <h1>Luôn sẵn sàng hỗ trợ bạn</h1>
                    <p class="text-white opacity-75" style="max-width: 600px;">Dù bạn cần tư vấn chọn cây cho văn phòng, hỏi đáp về cách chăm sóc, hay phản hồi dịch vụ, chúng tôi luôn ở đây để lắng nghe.</p>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="hero-insight-card">
                        <i class="fa-solid fa-clock"></i>
                        <strong>Phản hồi siêu tốc</strong>
                        <span>Đội ngũ CSKH cam kết trả lời các yêu cầu trực tuyến trong vòng 24 giờ làm việc.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-soft">
        <div class="container">
            <div class="row g-5">
                <!-- Cột trái: Form liên hệ -->
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="contact-panel bg-white p-4 p-md-5 rounded" style="border: 1px solid var(--stone-200); box-shadow: 0 10px 28px rgba(18, 56, 42, 0.07); border-radius: 12px;">
                        <h2 class="mb-2" style="color: var(--green-900); font-weight: 820; font-size: 2rem;">Gửi tin nhắn cho chúng tôi</h2>
                        <p class="text-muted mb-4">Để lại thông tin bên dưới, chuyên viên của Plantify sẽ liên hệ lại với bạn ngay.</p>

                        <form id="contactForm" method="POST" action="<?= BASE_URL ?>/home/submitContact">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold" style="color: var(--stone-700);">Họ và tên</label>
                                    <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Ví dụ: Nguyễn Văn A" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold" style="color: var(--stone-700);">Email của bạn</label>
                                    <input type="email" class="form-control bg-light" id="email" name="email" placeholder="example@email.com" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label fw-bold" style="color: var(--stone-700);">Chủ đề</label>
                                    <select class="form-select bg-light" id="subject" name="subject" required>
                                        <option value="">-- Chọn chủ đề cần tư vấn --</option>
                                        <option value="buy">Mua sắm cây xanh</option>
                                        <option value="decor">Dịch vụ Decor/Setup văn phòng</option>
                                        <option value="care">Hỏi đáp cách chăm sóc cây</option>
                                        <option value="other">Khác</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label fw-bold" style="color: var(--stone-700);">Nội dung chi tiết</label>
                                    <textarea class="form-control bg-light" id="message" name="message" rows="5" placeholder="Nhập tin nhắn của bạn..." required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-success btn-lg w-100" id="btnSubmit">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Gửi Liên Hệ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cột phải: Thông tin liên hệ -->
                <div class="col-lg-5" data-aos="fade-left">
                    <aside class="faq-side h-100 d-flex flex-column justify-content-center">
                        <span class="section-kicker">Thông Tin Trực Tiếp</span>
                        <h2 class="mb-4">Bạn cần hỗ trợ gấp?</h2>
                        <p>Đừng ngại gọi cho hotline hoặc ghé trực tiếp showroom của chúng tôi để được giải đáp tức thời.</p>

                        <div class="faq-prep-list mt-4">
                            <div>
                                <i class="fa-solid fa-location-dot"></i>
                                <span><strong>Địa chỉ:</strong><br>123 Đường Cây Xanh, Quận 1, TP HCM</span>
                            </div>
                            <div>
                                <i class="fa-solid fa-phone"></i>
                                <span><strong>Điện thoại:</strong><br><a href="tel:0123456789" class="text-success text-decoration-none">0123 456 789</a></span>
                            </div>
                            <div>
                                <i class="fa-solid fa-envelope"></i>
                                <span><strong>Email:</strong><br><a href="mailto:info@plantify.com" class="text-success text-decoration-none">info@plantify.com</a></span>
                            </div>
                            <div>
                                <i class="fa-solid fa-clock"></i>
                                <span><strong>Giờ làm việc:</strong><br>8:00 - 20:00 (Thứ 2 - Chủ Nhật)</span>
                            </div>
                        </div>

                        <div class="social-links mt-5">
                            <strong class="d-block mb-3" style="color: var(--green-900);">Theo dõi chúng tôi trên:</strong>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-success rounded-circle" style="width:45px; height:45px; display:inline-flex; align-items:center; justify-content:center;"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-outline-success rounded-circle" style="width:45px; height:45px; display:inline-flex; align-items:center; justify-content:center;"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" class="btn btn-outline-success rounded-circle" style="width:45px; height:45px; display:inline-flex; align-items:center; justify-content:center;"><i class="fa-brands fa-tiktok"></i></a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <!-- Bản đồ -->
    <section class="section-padding map-section pt-0">
        <div class="container">
            <div class="map-embed-wrap" data-aos="fade-up" style="width:100%; min-height:450px; border-radius: 18px; overflow: hidden;">
                <iframe
                    title="Bản đồ Plantify Co"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.460232421718!2d106.69762141533423!3d10.776019462143224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f40a3b49e59%3A0xa1bd14e483a6028c!2sDinh%20%C4%90%E1%BB%99c%20L%E1%BA%ADp!5e0!3m2!1svi!2s!4v1684300000000!5m2!1svi!2s"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</main>

<!-- SweetAlert2 (Dùng để hiển thị thông báo đẹp mắt thay cho alert() mặc định) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');

        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Ngăn chặn form chuyển trang ngay lập tức

                // Lấy nút submit
                const btn = document.getElementById('btnSubmit');
                const originalText = btn.innerHTML;

                // Hiệu ứng đang gửi
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Đang gửi...';
                btn.disabled = true;

                // Giả lập delay gửi mail 1 giây
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Gửi thành công!',
                        text: 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể qua Email.',
                        confirmButtonColor: '#2d8a5f'
                    });

                    // Trả lại trạng thái ban đầu
                    contactForm.reset();
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 1000);
            });
        }
    });
</script>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>