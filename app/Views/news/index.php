<?php

/**
 * File: app/Views/news/index.php
 */
require BASE_PATH . '/app/Views/partials/header.php';
?>

<main class="site-main">
    <section class="news-hero">
        <div class="container" data-aos="fade-up">
            <h1>Tin Tức & Bài Viết</h1>
            <p>Khám phá các bài viết về cây cảnh, phong thủy và xu hướng trang trí xanh.</p>
        </div>
    </section>

    <div class="container">
        <div class="news-search-bar" data-aos="fade-up" data-aos-delay="100">
            <form action="<?= BASE_URL ?>/news" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm tin tức, bài viết..." value="<?= e($search ?? '') ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i>Tìm kiếm</button>
            </form>
        </div>
    </div>

    <section class="news-list py-5">
        <div class="container">
            <?php if (!empty($search)): ?>
                <p class="mb-4 text-muted">Kết quả tìm kiếm cho: <strong><?= e($search) ?></strong> (<?= $total ?? 0 ?> bài viết)</p>
            <?php endif; ?>

            <?php if (empty($newsList)): ?>
                <div class="alert alert-info text-center py-4">Không tìm thấy bài viết nào phù hợp!</div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($newsList as $news): ?>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up">
                            <article class="news-card">
                                <a href="<?= BASE_URL ?>/news/detail/<?= $news['slug'] ?>" class="news-card-img">
                                    <?php
                                    // Dùng PUBLIC_PATH (đã cấu hình trong Bootstrap) để check file vật lý chính xác nhất
                                    $thumbPath = !empty($news['thumbnail']) ? PUBLIC_PATH . '/' . ltrim($news['thumbnail'], '/') : '';

                                    if (!empty($news['thumbnail']) && file_exists($thumbPath)):
                                    ?>
                                        <img src="<?= BASE_URL ?>/<?= ltrim($news['thumbnail'], '/') ?>"
                                            alt="<?= e($news['title']) ?>"
                                            loading="lazy">
                                    <?php else: ?>
                                        <div class="news-img-placeholder">
                                            <i class="fa-solid fa-leaf"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="news-card-body">
                                    <span class="date"><i class="fa-regular fa-calendar me-2"></i><?= date('d/m/Y', strtotime($news['created_at'])) ?></span>
                                    <h3><a href="<?= BASE_URL ?>/news/detail/<?= $news['slug'] ?>"><?= e($news['title']) ?></a></h3>
                                    <p><?= e($news['short_description'] ?? mb_substr(strip_tags($news['content']), 0, 100) . '...') ?></p>
                                </div>
                                <div class="news-card-footer">
                                    <span class="author"><i class="fa-solid fa-pen-nib me-2"></i><?= e($news['author'] ?? 'Admin') ?></span>
                                    <a href="<?= BASE_URL ?>/news/detail/<?= $news['slug'] ?>" class="read-more">Xem chi tiết <i class="fa-solid fa-arrow-right ms-1"></i></a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="pagination-wrapper mt-5">
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="<?= BASE_URL ?>/news?page=<?= $currentPage - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"><i class="fa-solid fa-chevron-left"></i></a>
                        <?php else: ?>
                            <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
                        <?php endif; ?>

                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <?php if ($p === $currentPage): ?>
                                <span class="active"><?= $p ?></span>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/news?page=<?= $p ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"><?= $p ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="<?= BASE_URL ?>/news?page=<?= $currentPage + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"><i class="fa-solid fa-chevron-right"></i></a>
                        <?php else: ?>
                            <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require BASE_PATH . '/app/Views/partials/footer.php'; ?>