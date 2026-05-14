<?php

/**
 * File: app/Views/pages/contact.php
 */
$pageTitle = 'Liên hệ | Plantify Co';
require BASE_PATH . '/app/Views/partials/header.php';
?>

<main class="site-main">
    <section class="page-hero modern-hero"
        style="background: linear-gradient(135deg, rgba(18, 56, 42, 0.88), rgba(46, 111, 134, 0.62)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80') center/cover; padding: 100px 0 60px;">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row g-5 align-items-end">
                <div class="col-lg-8" data-aos="fade-up">
                    <span class="section-kicker text-white opacity-75">Kết nối với Plantify</span>
                    <h1>Luôn sẵn sàng hỗ trợ bạn</h1>
                    <p class="text-white opacity-75" style="max-width: 600px;">Dù bạn cần tư vấn chọn cây cho văn phòng,
                        hỏi đáp về cách chăm sóc, hay phản hồi dịch vụ, chúng tôi luôn ở đây để lắng nghe.</p>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="hero-insight-card">
                        <i class="fa-solid fa-clock"></i>
                        <strong>Phản hồi nhanh</strong>
                        <span>Đội ngũ CSKH cam kết trả lời các yêu cầu trực tuyến trong vòng 24 giờ làm việc.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-soft">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="contact-panel bg-white p-4 p-md-5 rounded"
                        style="border: 1px solid var(--stone-200); box-shadow: 0 10px 28px rgba(18, 56, 42, 0.07); border-radius: 12px;">
                        <h2 class="mb-2" style="color: var(--green-900); font-weight: 820; font-size: 2rem;">Gửi tin
                            nhắn cho chúng tôi</h2>
                        <p class="text-muted mb-4">Để lại thông tin bên dưới, chuyên viên của Plantify sẽ liên hệ lại
                            với bạn ngay.</p>

                        <!-- Flash messages -->
                        <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                            <i class="fa-solid fa-circle-check me-2"></i> <?= htmlspecialchars($success) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <!-- Form POST thật tới ContactController::submit() -->
                        <form id="contactForm" method="POST" action="<?= BASE_URL ?>/contact/submit" novalidate>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold" style="color: var(--stone-700);">Họ và
                                        tên <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"
                                            style="color: var(--green-700);"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" class="form-control bg-light border-start-0 ps-0" id="name"
                                            name="name" placeholder="Ví dụ: Nguyễn Văn A"
                                            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                                    </div>
                                    <div id="nameError" class="text-danger small mt-1" style="display:none;"></div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold" style="color: var(--stone-700);">Email
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"
                                            style="color: var(--green-700);"><i class="fa-solid fa-envelope"></i></span>
                                        <input type="email" class="form-control bg-light border-start-0 ps-0" id="email"
                                            name="email" placeholder="example@email.com"
                                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                                    </div>
                                    <div id="emailError" class="text-danger small mt-1" style="display:none;"></div>
                                </div>

                                <div class="col-12">
                                    <label for="subject" class="form-label fw-bold" style="color: var(--stone-700);">Chủ
                                        đề <span class="text-danger">*</span></label>
                                    <select class="form-select bg-light" id="subject" name="subject" required>
                                        <option value="">-- Chọn chủ đề cần tư vấn --</option>
                                        <option value="Mua sắm cây xanh"
                                            <?= ($_POST['subject'] ?? '') === 'Mua sắm cây xanh'     ? 'selected' : '' ?>>
                                            Mua sắm cây xanh</option>
                                        <option value="Dịch vụ decor/setup văn phòng"
                                            <?= ($_POST['subject'] ?? '') === 'Dịch vụ decor/setup văn phòng' ? 'selected' : '' ?>>
                                            Dịch vụ decor/setup văn phòng</option>
                                        <option value="Hỏi đáp cách chăm sóc cây"
                                            <?= ($_POST['subject'] ?? '') === 'Hỏi đáp cách chăm sóc cây' ? 'selected' : '' ?>>
                                            Hỏi đáp cách chăm sóc cây</option>
                                        <option value="Khác"
                                            <?= ($_POST['subject'] ?? '') === 'Khác'                 ? 'selected' : '' ?>>
                                            Khác</option>
                                    </select>
                                    <div id="subjectError" class="text-danger small mt-1" style="display:none;"></div>
                                </div>

                                <div class="col-12">
                                    <label for="message" class="form-label fw-bold" style="color: var(--stone-700);">Nội
                                        dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control bg-light" id="message" name="message" rows="5"
                                        placeholder="Nhập tin nhắn của bạn..." maxlength="2000"
                                        required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                                    <div class="d-flex justify-content-between mt-1">
                                        <div id="messageError" class="text-danger small" style="display:none;"></div>
                                        <div class="text-muted small ms-auto" id="charCounter">0 / 2000 ký tự</div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-success btn-lg w-100" id="btnSubmit"
                                        style="height: 52px; border-radius: 10px;">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Gửi liên hệ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5" data-aos="fade-left">
                    <aside class="faq-side h-100 d-flex flex-column justify-content-center">
                        <span class="section-kicker">Thông tin trực tiếp</span>
                        <h2 class="mb-4">Bạn cần hỗ trợ gấp?</h2>
                        <p>Đừng ngại gọi cho hotline hoặc ghé trực tiếp showroom của chúng tôi để được giải đáp tức
                            thời.</p>

                        <div class="faq-prep-list mt-4">
                            <div>
                                <i class="fa-solid fa-location-dot"></i>
                                <span><strong>Địa
                                        chỉ:</strong><br><?= htmlspecialchars(content_value('company.address', '268 Lý Thường Kiệt, Q.10, TP.HCM')) ?></span>
                            </div>
                            <div>
                                <i class="fa-solid fa-phone"></i>
                                <span><strong>Điện thoại:</strong><br>
                                    <a href="tel:<?= htmlspecialchars(content_value('company.phone', '')) ?>"
                                        class="text-success text-decoration-none">
                                        <?= htmlspecialchars(content_value('company.phone', '0908 246 135')) ?>
                                    </a>
                                </span>
                            </div>
                            <div>
                                <i class="fa-solid fa-envelope"></i>
                                <span><strong>Email:</strong><br>
                                    <a href="mailto:<?= htmlspecialchars(content_value('company.email', '')) ?>"
                                        class="text-success text-decoration-none">
                                        <?= htmlspecialchars(content_value('company.email', 'info@plantify.com')) ?>
                                    </a>
                                </span>
                            </div>
                            <div>
                                <i class="fa-solid fa-clock"></i>
                                <span><strong>Giờ làm
                                        việc:</strong><br><?= htmlspecialchars(content_value('company.hours', 'Thứ 2 - Thứ 7: 08:00 - 18:00')) ?></span>
                            </div>
                        </div>

                        <div class="social-links mt-5">
                            <strong class="d-block mb-3" style="color: var(--green-900);">Theo dõi chúng tôi
                                trên:</strong>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-success rounded-circle"
                                    style="width:45px;height:45px;display:inline-flex;align-items:center;justify-content:center;"><i
                                        class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-outline-success rounded-circle"
                                    style="width:45px;height:45px;display:inline-flex;align-items:center;justify-content:center;"><i
                                        class="fa-brands fa-instagram"></i></a>
                                <a href="#" class="btn btn-outline-success rounded-circle"
                                    style="width:45px;height:45px;display:inline-flex;align-items:center;justify-content:center;"><i
                                        class="fa-brands fa-tiktok"></i></a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding map-section pt-0">
        <div class="container">
            <div class="map-embed-wrap" data-aos="fade-up"
                style="width:100%;min-height:450px;border-radius:18px;overflow:hidden;">
                <iframe title="Bản đồ Plantify Co"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.460232421718!2d106.69762141533423!3d10.776019462143224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f40a3b49e59%3A0xa1bd14e483a6028c!2sDinh%20%C4%90%E1%BB%99c%20L%E1%BA%ADp!5e0!3m2!1svi!2s!4v1684300000000!5m2!1svi!2s"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Char counter
    const msg = document.getElementById('message');
    const counter = document.getElementById('charCounter');
    if (msg && counter) {
        msg.addEventListener('input', function() {
            counter.textContent = this.value.length + ' / 2000 ký tự';
        });
    }

    // Client-side validation
    const form = document.getElementById('contactForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        let ok = true;

        const fields = [{
                id: 'name',
                errId: 'nameError',
                minLen: 2,
                msg: 'Họ tên phải có ít nhất 2 ký tự!'
            },
            {
                id: 'subject',
                errId: 'subjectError',
                select: true,
                msg: 'Vui lòng chọn chủ đề!'
            },
            {
                id: 'message',
                errId: 'messageError',
                minLen: 10,
                msg: 'Nội dung phải có ít nhất 10 ký tự!'
            },
        ];

        // Reset errors
        document.querySelectorAll('[id$="Error"]').forEach(el => el.style.display = 'none');

        fields.forEach(function(f) {
            const el = document.getElementById(f.id);
            const errEl = document.getElementById(f.errId);
            if (!el || !errEl) return;
            const val = el.value.trim();
            let invalid = false;

            if (f.select && !val) invalid = true;
            if (f.minLen && val.length < f.minLen) invalid = true;

            if (invalid) {
                errEl.textContent = f.msg;
                errEl.style.display = 'block';
                ok = false;
            }
        });

        // Email
        const emailEl = document.getElementById('email');
        const emailErr = document.getElementById('emailError');
        if (emailEl && emailErr) {
            const emailVal = emailEl.value.trim();
            if (!emailVal || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
                emailErr.textContent = 'Email không hợp lệ!';
                emailErr.style.display = 'block';
                ok = false;
            }
        }

        if (!ok) {
            e.preventDefault();
            window.scrollTo({
                top: form.offsetTop - 100,
                behavior: 'smooth'
            });
            return;
        }

        // Disable button khi submit
        const btn = document.getElementById('btnSubmit');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang gửi...';
        }
    });
});
</script>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>