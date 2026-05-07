<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($news['title']) ?> - Plantify Co</title>
    <meta name="description" content="<?= htmlspecialchars($news['seo_desc'] ?: mb_substr(strip_tags($news['content']), 0, 160)) ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/news.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="logo">
        <a href="<?= BASE_URL ?>">🌿 Plantify Co</a>
    </div>
    <nav>
        <a href="<?= BASE_URL ?>">Trang Chủ</a>
        <a href="<?= BASE_URL ?>/home/shop">Cửa Hàng</a>
        <a href="<?= BASE_URL ?>/news" style="color: var(--primary); font-weight:700;">Tin Tức</a>
        <a href="<?= BASE_URL ?>/home/about">Về Chúng Tôi</a>
        <a href="<?= BASE_URL ?>/home/contact">Liên Hệ</a>
    </nav>
    <div class="user-menu">
        <?php if ($user): ?>
            <span>👤 <?= htmlspecialchars($user['fullname']) ?></span>
            <a href="<?= BASE_URL ?>/dashboard">📊 Dashboard</a>
            <a href="<?= BASE_URL ?>/auth/logout" class="logout">Đăng Xuất</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/auth">🔐 Đăng Nhập</a>
            <a href="<?= BASE_URL ?>/auth/register">📝 Đăng Ký</a>
        <?php endif; ?>
    </div>
</nav>

<!-- ===== BREADCRUMB ===== -->
<div style="max-width:1100px;margin:1.5rem auto;padding:0 2rem;">
    <nav style="font-size:13px;color:var(--text-light);">
        <a href="<?= BASE_URL ?>">Trang chủ</a>
        &rsaquo; <a href="<?= BASE_URL ?>/news">Tin tức</a>
        &rsaquo; <span><?= htmlspecialchars(mb_substr($news['title'], 0, 50)) ?>...</span>
    </nav>
</div>

<!-- ===== MAIN LAYOUT: ARTICLE + SIDEBAR ===== -->
<div class="news-detail-wrap">

    <!-- ===== MAIN ARTICLE ===== -->
    <main class="news-detail-main">

        <!-- Header -->
        <div class="news-detail-header">
            <h1><?= htmlspecialchars($news['title']) ?></h1>
            <div class="news-detail-meta">
                <span>📅 <?= date('d/m/Y H:i', strtotime($news['created_at'])) ?></span>
                <span>✍️ <?= htmlspecialchars($news['author'] ?? 'Admin') ?></span>
                <span>💬 <?= $commentCount ?> bình luận</span>
            </div>
        </div>

        <!-- Thumbnail -->
        <?php if (!empty($news['thumbnail']) && file_exists(__DIR__ . '/../../../public/' . $news['thumbnail'])): ?>
            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($news['thumbnail']) ?>"
                 alt="<?= htmlspecialchars($news['title']) ?>"
                 class="news-detail-img">
        <?php else: ?>
            <div class="news-detail-img-placeholder">🌿</div>
        <?php endif; ?>

        <!-- Content -->
        <div class="news-detail-content">
            <?= $news['content'] /* raw HTML content from admin */ ?>
        </div>

        <!-- Tags -->
        <?php if (!empty($news['tags'])): ?>
        <div class="news-detail-tags">
            <span class="label">🏷️ Tags:</span>
            <?php foreach (array_filter(array_map('trim', explode(',', $news['tags']))) as $tag): ?>
                <a href="<?= BASE_URL ?>/news?search=<?= urlencode($tag) ?>" class="news-tag">
                    <?= htmlspecialchars($tag) ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- ===== COMMENTS SECTION ===== -->
        <div class="comments-section" id="comments">
            <h3>💬 Bình luận <span style="font-size:16px;color:var(--text-light);">(<?= $commentCount ?>)</span></h3>

            <!-- Flash messages -->
            <?php if ($commentError): ?>
                <div class="alert-error">❌ <?= htmlspecialchars($commentError) ?></div>
            <?php endif; ?>
            <?php if ($commentSuccess): ?>
                <div class="alert-success">✅ <?= htmlspecialchars($commentSuccess) ?></div>
            <?php endif; ?>

            <!-- Approved comments list -->
            <?php if (empty($comments)): ?>
                <p style="color:var(--text-light);font-size:14px;padding:1rem 0;">
                    Chưa có bình luận nào. Hãy là người đầu tiên bình luận!
                </p>
            <?php else: ?>
                <?php foreach ($comments as $c): ?>
                <div class="comment-item">
                    <div class="comment-author">
                        <div class="comment-avatar">
                            <?= mb_strtoupper(mb_substr($c['fullname'] ?? $c['username'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div>
                            <div class="comment-author-name"><?= htmlspecialchars($c['fullname'] ?: $c['username']) ?></div>
                            <div class="comment-date">📅 <?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></div>
                        </div>
                    </div>
                    <p class="comment-text"><?= nl2br(htmlspecialchars($c['content'])) ?></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Comment form OR login prompt -->
            <?php if ($user): ?>
            <div class="comment-form-box">
                <h4>✏️ Viết bình luận</h4>
                <form action="<?= BASE_URL ?>/news/comment_post" method="POST" id="commentForm" novalidate>
                    <input type="hidden" name="news_id" value="<?= (int)$news['id'] ?>">
                    <input type="hidden" name="slug"    value="<?= htmlspecialchars($news['slug']) ?>">
                    <textarea name="content"
                              id="commentContent"
                              placeholder="Chia sẻ ý kiến của bạn về bài viết này..."
                              maxlength="1000"
                              required></textarea>
                    <div class="char-counter" id="charCounter">0 / 1000 ký tự</div>
                    <div id="commentError" style="color:#dc2626;font-size:13px;margin:6px 0;display:none;"></div>
                    <button type="submit" class="btn btn-primary" style="margin-top:0.75rem;padding:10px 24px;font-size:14px;">
                        🚀 Gửi bình luận
                    </button>
                </form>
            </div>
            <?php else: ?>
            <div class="comment-login-prompt">
                <p style="margin-bottom:0.75rem;color:var(--text-light);">
                    🔐 Bạn cần đăng nhập để bình luận
                </p>
                <a href="<?= BASE_URL ?>/auth" class="btn btn-primary" style="padding:10px 24px;font-size:14px;">
                    Đăng Nhập Ngay
                </a>
                <a href="<?= BASE_URL ?>/auth/register" class="btn btn-secondary" style="padding:10px 24px;font-size:14px;margin-left:8px;">
                    Đăng Ký
                </a>
            </div>
            <?php endif; ?>
        </div>
        <!-- END COMMENTS -->

    </main>
    <!-- END MAIN ARTICLE -->

    <!-- ===== SIDEBAR ===== -->
    <aside class="news-detail-sidebar">

        <!-- Author info -->
        <div class="sidebar-widget">
            <h4>✍️ Tác giả</h4>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:48px;height:48px;background:var(--primary-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">🌿</div>
                <div>
                    <div style="font-weight:700;font-size:15px;"><?= htmlspecialchars($news['author'] ?? 'Admin') ?></div>
                    <div style="font-size:12px;color:var(--text-light);">Biên tập viên Plantify Co</div>
                </div>
            </div>
        </div>

        <!-- Related articles -->
        <?php if (!empty($related)): ?>
        <div class="sidebar-widget">
            <h4>📚 Bài viết liên quan</h4>
            <?php foreach ($related as $r): ?>
            <div class="related-item">
                <div class="related-thumb">
                    <?php if (!empty($r['thumbnail']) && file_exists(__DIR__ . '/../../../public/' . $r['thumbnail'])): ?>
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($r['thumbnail']) ?>" alt="">
                    <?php else: ?>
                        🌿
                    <?php endif; ?>
                </div>
                <div class="related-info">
                    <h6><a href="<?= BASE_URL ?>/news/detail/<?= htmlspecialchars($r['slug']) ?>"><?= htmlspecialchars($r['title']) ?></a></h6>
                    <small>📅 <?= date('d/m/Y', strtotime($r['created_at'])) ?></small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Tags cloud -->
        <?php if (!empty($news['tags'])): ?>
        <div class="sidebar-widget">
            <h4>🏷️ Tags</h4>
            <div class="news-tags" style="flex-wrap:wrap;">
                <?php foreach (array_filter(array_map('trim', explode(',', $news['tags']))) as $tag): ?>
                    <a href="<?= BASE_URL ?>/news?search=<?= urlencode($tag) ?>" class="news-tag" style="margin-bottom:6px;">
                        <?= htmlspecialchars($tag) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Back to list -->
        <div class="sidebar-widget" style="text-align:center;">
            <a href="<?= BASE_URL ?>/news" class="btn btn-secondary" style="width:100%;justify-content:center;">
                ← Tất cả bài viết
            </a>
        </div>

    </aside>
    <!-- END SIDEBAR -->

</div>
<!-- END MAIN LAYOUT -->

<!-- ===== FOOTER ===== -->
<footer>
    <p>&copy; <?= date('Y') ?> Plantify Co. Tất cả các quyền được bảo lưu.</p>
    <p>
        <a href="<?= BASE_URL ?>/home/about">Về Chúng Tôi</a> |
        <a href="<?= BASE_URL ?>/home/contact">Liên Hệ</a> |
        <a href="<?= BASE_URL ?>/news">Tin Tức</a>
    </p>
</footer>

<!-- ===== JS: Comment form validation ===== -->
<script>
const content  = document.getElementById('commentContent');
const counter  = document.getElementById('charCounter');
const errBox   = document.getElementById('commentError');
const form     = document.getElementById('commentForm');

if (content) {
    content.addEventListener('input', function () {
        const len = this.value.length;
        counter.textContent = len + ' / 1000 ký tự';
        counter.classList.toggle('over', len > 1000);
    });
}

if (form) {
    form.addEventListener('submit', function (e) {
        errBox.style.display = 'none';
        const val = content.value.trim();
        if (!val) {
            e.preventDefault();
            errBox.textContent = 'Vui lòng nhập nội dung bình luận!';
            errBox.style.display = 'block';
            content.focus();
            return;
        }
        if (val.length < 5) {
            e.preventDefault();
            errBox.textContent = 'Bình luận phải có ít nhất 5 ký tự!';
            errBox.style.display = 'block';
            content.focus();
            return;
        }
        if (val.length > 1000) {
            e.preventDefault();
            errBox.textContent = 'Bình luận không được vượt quá 1000 ký tự!';
            errBox.style.display = 'block';
            return;
        }
    });
}
</script>
</body>
</html>
