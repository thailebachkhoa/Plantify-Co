<?php
/**
 * File: footer.php
 * Chuc nang: Tao phan cuoi trang dung chung cho website.
 */
?>
</main>
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="brand-mark"><i class="fa-solid fa-leaf"></i></span>
                    <strong><?php echo e($company['name']); ?></strong>
                </div>
                <p class="footer-text"><?php echo e($company['tagline']); ?>. <?php echo e(content_value('footer.description', 'Chúng tôi mang cây xanh vào không gian sống và làm việc bằng giải pháp tinh gọn, bền vững.')); ?></p>
            </div>
            <div class="col-md-6 col-lg-3">
                <h2 class="footer-title"><?php echo e(content_value('footer.info_title', 'Thông tin')); ?></h2>
                <ul class="footer-list">
                    <li><i class="fa-solid fa-phone"></i> <?php echo e($company['phone']); ?></li>
                    <li><i class="fa-solid fa-envelope"></i> <?php echo e($company['email']); ?></li>
                    <li><i class="fa-solid fa-clock"></i> <?php echo e($company['hours']); ?></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-3">
                <h2 class="footer-title"><?php echo e(content_value('footer.nav_title', 'Điều hướng')); ?></h2>
                <ul class="footer-links">
                    <li><a href="zabout.php"><?php echo e(content_value('nav.about', 'Giới thiệu')); ?></a></li>
                    <li><a href="faq.php"><?php echo e(content_value('nav.faq', 'FAQ')); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; <?php echo date('Y'); ?> <?php echo e($company['name']); ?>. All rights reserved.</span>
            <span><?php echo e($company['address']); ?></span>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
<script src="<?php echo asset('assets/js/main.js'); ?>"></script>
</body>
</html>
