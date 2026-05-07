<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức & Bài Viết - Plantify Co</title>
    <meta name="description" content="Khám phá các bài viết về cây cảnh, phong thủy, chăm sóc cây và xu hướng trang trí xanh.">
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
        <a href="<?= BASE_URL ?>/news" style="color: var(--primary); font-weight: 700;">Tin Tức</a>
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

<!-- ===== HERO ===== -->
<div class="news-hero">
    <h1>📰 Tin Tức & Bài Viết</h1>
    <p>Kiến thức cây cảnh, phong thủy và xu hướng xanh mới nhất</p>
</div>

<!-- ===== SEARCH BAR ===== -->
<div class="news-search-bar">
    <form action="<?= BASE_URL ?>/news" method="GET">
        <input type="text"
               name="search"
               placeholder="Tìm kiếm theo tiêu đề hoặc tag..."
               value="<?= htmlspecialchars($search) ?>"
               autocomplete="off">
        <button type="submit">🔍 Tìm</button>
    </form>
</div>

<!-- ===== PAGE ERROR (article not found, etc.) ===== -->
<?php if (!empty($pageError)): ?>
<div style="max-width:1200px; margin:2rem auto; padding:0 2rem;">
    <div class="alert-error">⚠️ <?= htmlspecialchars($pageError) ?></div>
</div>
<?php endif; ?>

<!-- ===== RESULTS INFO ===== -->
<div class="news-results-info">
    <span class="count">
        <?php if ($search): ?>
            Tìm thấy <strong><?= $total ?></strong> kết quả cho
        <?php else: ?>
            Hiển thị <strong><?= $total ?></strong> bài viết
        <?php endif; ?>
    </span>
    <?php if ($search): ?>
        <span class="search-tag">
            "<?= htmlspecialchars($search) ?>"
            <a href="<?= BASE_URL ?>/news" title="Xóa tìm kiếm">&times;</a>
        </span>
    <?php endif; ?>
</div>

<!-- ===== NEWS GRID ===== -->
<div class="news-section">
    <div class="news-grid">
        <?php if (empty($newsList)): ?>
            <div class="news-empty">
                <div class="empty-icon">🌱</div>
                <h3>Chưa có bài viết nào</h3>
                <p><?= $search ? 'Không tìm thấy kết quả phù hợp. Thử từ khoá khác nhé!' : 'Các bài viết sẽ sớm được đăng tải.' ?></p>
                <?php if ($search): ?>
                    <a href="<?= BASE_URL ?>/news" class="btn btn-primary" style="margin-top:1rem;">← Xem tất cả bài viết</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($newsList as $n): ?>
            <article class="news-card">
                <!-- Thumbnail -->
                <div class="news-card-img">
                    <?php if (!empty($n['thumbnail']) && file_exists(__DIR__ . '/../../../public/' . $n['thumbnail'])): ?>
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($n['thumbnail']) ?>"
                             alt="<?= htmlspecialchars($n['title']) ?>"
                             loading="lazy">
                    <?php else: ?>
                        🌿
                    <?php endif; ?>
                </div>
                <!-- Body -->
                <div class="news-card-body">
                    <div class="news-card-meta">
                        <span>📅 <?= date('d/m/Y', strtotime($n['created_at'])) ?></span>
                        <span>✍️ <?= htmlspecialchars($n['author'] ?? 'Admin') ?></span>
                    </div>
                    <h2 class="news-card-title">
                        <a href="<?= BASE_URL ?>/news/detail/<?= htmlspecialchars($n['slug']) ?>">
                            <?= htmlspecialchars($n['title']) ?>
                        </a>
                    </h2>
                    <p class="news-card-desc">
                        <?= htmlspecialchars($n['short_description'] ?: strip_tags(mb_substr($n['content'], 0, 160)) . '...') ?>
                    </p>
                    <div class="news-card-footer">
                        <!-- Tags -->
                        <div class="news-tags">
                            <?php foreach (array_slice(array_filter(array_map('trim', explode(',', $n['tags'] ?? ''))), 0, 3) as $tag): ?>
                                <a href="<?= BASE_URL ?>/news?search=<?= urlencode($tag) ?>" class="news-tag"><?= htmlspecialchars($tag) ?></a>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= BASE_URL ?>/news/detail/<?= htmlspecialchars($n['slug']) ?>" class="news-card-link">
                            Đọc thêm →
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ===== PAGINATION ===== -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination-wrap">
        <!-- Previous -->
        <?php if ($currentPage > 1): ?>
            <a href="<?= BASE_URL ?>/news?page=<?= $currentPage - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">‹</a>
        <?php else: ?>
            <span class="disabled">‹</span>
        <?php endif; ?>

        <?php
        // Show page numbers with smart truncation
        $startPage = max(1, $currentPage - 2);
        $endPage   = min($totalPages, $currentPage + 2);
        if ($startPage > 1): ?><a href="<?= BASE_URL ?>/news?page=1<?= $search ? '&search=' . urlencode($search) : '' ?>">1</a><?php endif; ?>
        <?php if ($startPage > 2): ?><span style="border:none;background:none;width:auto;padding:0 4px;color:var(--text-light);">…</span><?php endif; ?>
        <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
            <?php if ($p === $currentPage): ?>
                <span class="active"><?= $p ?></span>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/news?page=<?= $p ?><?= $search ? '&search=' . urlencode($search) : '' ?>"><?= $p ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($endPage < $totalPages - 1): ?><span style="border:none;background:none;width:auto;padding:0 4px;color:var(--text-light);">…</span><?php endif; ?>
        <?php if ($endPage < $totalPages): ?><a href="<?= BASE_URL ?>/news?page=<?= $totalPages ?><?= $search ? '&search=' . urlencode($search) : '' ?>"><?= $totalPages ?></a><?php endif; ?>

        <!-- Next -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="<?= BASE_URL ?>/news?page=<?= $currentPage + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">›</a>
        <?php else: ?>
            <span class="disabled">›</span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- ===== FOOTER ===== -->
<footer>
    <p>&copy; <?= date('Y') ?> Plantify Co. Tất cả các quyền được bảo lưu.</p>
    <p>
        <a href="<?= BASE_URL ?>/home/about">Về Chúng Tôi</a> |
        <a href="<?= BASE_URL ?>/home/contact">Liên Hệ</a> |
        <a href="<?= BASE_URL ?>/news">Tin Tức</a>
    </p>
</footer>

</body>
</html>
