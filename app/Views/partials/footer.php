<?php

/**
 * File: footer.php
 * Chuc nang: Tao phan cuoi trang dung chung cho website.
 */

// Đặt giá trị mặc định cho toàn bộ thông tin footer
$c_name    = content_value('company.name', 'Plantify Co');
$c_tagline = content_value('company.tagline', 'Mang thiên nhiên vào không gian của bạn');
$c_phone   = content_value('company.phone', '0908 246 135');
$c_email   = content_value('company.email', 'info@plantify.com');
$c_hours   = content_value('company.hours', '8:00 - 17:00');
$c_address = content_value('company.address', '268, Lý Thường Kiệt, Phường 14, Quận 10, TP. Hồ Chí Minh');
?>
</main>
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="brand-mark"><i class="fa-solid fa-leaf"></i></span>
                    <strong><?php echo e($c_name); ?></strong>
                </div>
                <p class="footer-text"><?php echo e($c_tagline); ?>. <?php echo e(content_value('footer.description', 'Chúng tôi mang cây xanh vào không gian sống và làm việc bằng giải pháp tinh gọn, bền vững.')); ?></p>
            </div>
            <div class="col-md-6 col-lg-3">
                <h2 class="footer-title"><?php echo e(content_value('footer.info_title', 'Thông tin')); ?></h2>
                <ul class="footer-list">
                    <li><i class="fa-solid fa-phone"></i> <?php echo e($c_phone); ?></li>
                    <li><i class="fa-solid fa-envelope"></i> <?php echo e($c_email); ?></li>
                    <li><i class="fa-solid fa-clock"></i> <?php echo e($c_hours); ?></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3">
                <h2 class="footer-title"><?php echo e(content_value('footer.nav_title', 'Điều hướng')); ?></h2>
                <ul class="footer-links">
                    <li><a href="about"><?php echo e(content_value('nav.about', 'Giới thiệu')); ?></a></li>
                    <li><a href="faq"><?php echo e(content_value('nav.faq', 'FAQ')); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; <?php echo date('Y'); ?> <?php echo e($c_name); ?>. All rights reserved.</span>
            <span><?php echo e($c_address); ?></span>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
<script src="<?php echo asset('assets/js/main.js'); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    });
</script>
</body>

</html>