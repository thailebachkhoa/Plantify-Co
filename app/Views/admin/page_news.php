<?php

/**
 * File: admin/page_news.php
 * Chức năng: Chỉnh sửa nội dung trang tin tức (hero, search, empty state...).
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$db = Database::getInstance();
$message = '';
$error = '';

$newsPageDefaults = [
    // Hero
    ['news.hero_title',       'Trang tin tức', 'Tiêu đề hero',              'text',     'Tin Tức & Bài Viết'],
    ['news.hero_description', 'Trang tin tức', 'Mô tả hero',                'textarea', 'Khám phá các bài viết về cây cảnh, phong thủy và xu hướng trang trí xanh.'],
    // Search
    ['news.search_placeholder','Trang tin tức','Gợi ý ô tìm kiếm',          'text',     'Tìm kiếm tin tức, bài viết...'],
    ['news.search_button',     'Trang tin tức','Nhãn nút tìm kiếm',          'text',     'Tìm kiếm'],
    // Trạng thái rỗng
    ['news.empty_title',       'Trang tin tức','Thông báo không có kết quả', 'text',     'Không tìm thấy bài viết nào phù hợp!'],
    // Pagination
    ['news.prev_label',        'Trang tin tức','Nhãn nút trang trước',       'text',     'Trước'],
    ['news.next_label',        'Trang tin tức','Nhãn nút trang sau',          'text',     'Sau'],
    // Card labels
    ['news.card_author_label', 'Trang tin tức','Nhãn tác giả trên thẻ bài',  'text',     ''],
    ['news.card_readmore',     'Trang tin tức','Nhãn nút đọc thêm',           'text',     'Xem chi tiết'],
    // Meta SEO
    ['news.meta_title',        'Trang tin tức','Meta title trang tin tức',    'text',     'Tin Tức | Plantify Co'],
    ['news.meta_description',  'Trang tin tức','Meta description',             'textarea', 'Khám phá bài viết về cây cảnh, phong thủy và không gian xanh từ Plantify Co.'],
];

foreach ($newsPageDefaults as $row) {
    $db->query("INSERT INTO site_content (content_key, content_group, label, input_type, content_value)
                VALUES (:k, :g, :l, :t, :v)
                ON DUPLICATE KEY UPDATE content_group=VALUES(content_group), label=VALUES(label), input_type=VALUES(input_type)");
    $db->bind(':k', $row[0]); $db->bind(':g', $row[1]);
    $db->bind(':l', $row[2]); $db->bind(':t', $row[3]); $db->bind(':v', $row[4]);
    $db->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    foreach ($_POST['content'] as $key => $value) {
        $db->query("UPDATE site_content SET content_value = :v WHERE content_key = :k");
        $db->bind(':v', trim($value));
        $db->bind(':k', $key);
        $db->execute();
    }
    $message = 'Đã lưu nội dung trang tin tức!';
}

$db->query("SELECT * FROM site_content WHERE content_group = 'Trang tin tức' ORDER BY id");
$rows = $db->resultSet();
$byKey = [];
foreach ($rows as $r) $byKey[$r['content_key']] = $r;

$sections = [
    ['title' => 'SEO',
     'desc'  => 'Tên tab trình duyệt và mô tả tìm kiếm.',
     'keys'  => ['news.meta_title','news.meta_description']],
    ['title' => 'Hero đầu trang',
     'desc'  => 'Tiêu đề và mô tả phần banner trên cùng.',
     'keys'  => ['news.hero_title','news.hero_description']],
    ['title' => 'Tìm kiếm',
     'desc'  => 'Placeholder và nhãn nút tìm kiếm bài viết.',
     'keys'  => ['news.search_placeholder','news.search_button']],
    ['title' => 'Thẻ bài viết & phân trang',
     'desc'  => 'Nhãn nút đọc thêm, trang trước/sau.',
     'keys'  => ['news.card_readmore','news.prev_label','news.next_label']],
    ['title' => 'Trạng thái không có kết quả',
     'desc'  => 'Thông báo hiển thị khi tìm kiếm không ra bài viết.',
     'keys'  => ['news.empty_title']],
];

admin_layout_start([
    'pageTitle'  => 'Nội dung Trang tin tức',
    'heading'    => 'Nội dung Trang tin tức',
    'subtitle'   => 'Chỉnh sửa văn bản tĩnh trên trang danh sách tin tức.',
    'actionHtml' => '<a class="btn btn-outline-success" href="' . BASE_URL . '/news" target="_blank"><i class="fa-solid fa-eye me-2"></i>Xem trang tin tức</a>',
    'extraHead'  => '<style>
        .pe-editor-section{border:1px solid #e5ece6;border-radius:10px;background:#fff;overflow:hidden;margin-bottom:12px;}
        .pe-editor-section summary{cursor:pointer;list-style:none;padding:14px 18px;background:#f7fbf7;}
        .pe-editor-section summary::-webkit-details-marker{display:none;}
        .pe-section-title{display:flex;align-items:center;justify-content:space-between;gap:16px;}
        .pe-section-title strong{color:#1d5f35;font-size:15px;}
        .pe-section-title span{color:#748075;font-size:13px;}
        .pe-section-title i{color:#198754;transition:transform .2s;}
        .pe-editor-section[open] .pe-section-title i{transform:rotate(180deg);}
        .pe-section-body{padding:18px;border-top:1px solid #e5ece6;}
    </style>',
]);
?>

<?php if ($message): ?><div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i><?= e($message) ?>
</div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>

<form method="POST">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Nội dung trang tin tức</h4>
            <p class="text-muted mb-0">Mở từng mục để chỉnh văn bản tĩnh đang hiển thị.</p>
        </div>
        <button type="submit" class="btn btn-success px-4">
            <i class="fa-solid fa-floppy-disk me-2"></i>Lưu thay đổi
        </button>
    </div>

    <?php foreach ($sections as $i => $section): ?>
    <details class="pe-editor-section" <?= $i === 0 ? 'open' : '' ?>>
        <summary>
            <div class="pe-section-title">
                <div>
                    <strong><?= e($section['title']) ?></strong>
                    <span class="d-block"><?= e($section['desc']) ?></span>
                </div>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </summary>
        <div class="pe-section-body">
            <div class="row">
                <?php foreach ($section['keys'] as $key):
                    if (empty($byKey[$key])) continue;
                    $row = $byKey[$key];
                    $isTextarea = $row['input_type'] === 'textarea';
                ?>
                <div class="<?= $isTextarea ? 'col-12' : 'col-lg-6' ?> mb-3">
                    <label class="form-label">
                        <?= e($row['label']) ?>
                        <span class="d-block small text-muted"><?= e($key) ?></span>
                    </label>
                    <?php if ($isTextarea): ?>
                    <textarea class="form-control" name="content[<?= e($key) ?>]"
                        rows="3"><?= e($row['content_value']) ?></textarea>
                    <?php else: ?>
                    <input class="form-control" type="text" name="content[<?= e($key) ?>]"
                        value="<?= e($row['content_value']) ?>">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </details>
    <?php endforeach; ?>

    <div class="text-end mt-3 mb-5">
        <button type="submit" class="btn btn-success px-5">
            <i class="fa-solid fa-floppy-disk me-2"></i>Lưu tất cả thay đổi
        </button>
    </div>
</form>

<?php admin_layout_end(); ?>