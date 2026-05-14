<?php

/**
 * File: admin/page_home.php
 * Chức năng: Chỉnh sửa nội dung trang chủ (hero, features, CTA...).
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$db = Database::getInstance();
$message = '';
$error = '';

/* ── Seed các key mặc định ── */
$homeDefaults = [
    // Hero
    ['home.hero_kicker',       'Trang chủ', 'Nhãn hero',              'text',     'Khởi Đầu Mới'],
    ['home.hero_title',        'Trang chủ', 'Tiêu đề hero (HTML OK)', 'textarea', 'Biến Không Gian Sống<br>Thành Vườn Xanh Bình Yên'],
    ['home.hero_description',  'Trang chủ', 'Mô tả hero',             'textarea', 'Khám phá bộ sưu tập cây cảnh tuyển chọn giúp thanh lọc không khí, mang lại cảm giác thư thái và nguồn năng lượng tích cực cho ngôi nhà của bạn.'],
    ['home.hero_btn_primary',  'Trang chủ', 'Nút hero chính',         'text',     'Mua Sắm Ngay'],
    ['home.hero_btn_secondary','Trang chủ', 'Nút hero phụ',           'text',     'Tìm Hiểu Thêm'],
    ['home.hero_card_title',   'Trang chủ', 'Tiêu đề thẻ hero',       'text',     '100% Cây Khỏe Mạnh'],
    ['home.hero_card_text',    'Trang chủ', 'Nội dung thẻ hero',      'textarea', 'Được chăm sóc và kiểm tra kỹ lưỡng bởi chuyên gia thực vật trước khi giao đến tay bạn.'],
    // Metrics
    ['home.metric_1_value',    'Trang chủ', 'Chỉ số 1',               'text', '500+'],
    ['home.metric_1_label',    'Trang chủ', 'Nhãn chỉ số 1',          'text', 'Sản phẩm đa dạng'],
    ['home.metric_2_value',    'Trang chủ', 'Chỉ số 2',               'text', '100%'],
    ['home.metric_2_label',    'Trang chủ', 'Nhãn chỉ số 2',          'text', 'Giao hàng an toàn'],
    ['home.metric_3_value',    'Trang chủ', 'Chỉ số 3',               'text', '24/7'],
    ['home.metric_3_label',    'Trang chủ', 'Nhãn chỉ số 3',          'text', 'Hỗ trợ chăm sóc'],
    ['home.metric_4_value',    'Trang chủ', 'Chỉ số 4',               'text', '30 ngày'],
    ['home.metric_4_label',    'Trang chủ', 'Nhãn chỉ số 4',          'text', 'Đồng hành cùng cây'],
    // Features (About section)
    ['home.features_kicker',   'Trang chủ', 'Nhãn section về chúng tôi', 'text', 'Về Chúng Tôi'],
    ['home.features_title',    'Trang chủ', 'Tiêu đề section về chúng tôi', 'textarea', 'Chăm sóc từ tâm, xanh tươi không gian sống'],
    ['home.features_lead',     'Trang chủ', 'Mô tả dẫn đầu',          'textarea', 'Plantify không chỉ bán cây, chúng tôi trao đi nguồn năng lượng chữa lành từ tự nhiên.'],
    ['home.feature_1',         'Trang chủ', 'Điểm mạnh 1',            'text', 'Cây trồng hữu cơ chuẩn VietGAP'],
    ['home.feature_2',         'Trang chủ', 'Điểm mạnh 2',            'text', 'Chậu gốm thủ công nghệ thuật'],
    ['home.feature_3',         'Trang chủ', 'Điểm mạnh 3',            'text', 'Tư vấn phong thủy miễn phí 24/7'],
    ['home.feature_4',         'Trang chủ', 'Điểm mạnh 4',            'text', 'Bao bì sinh học bảo vệ môi trường'],
    // Products section
    ['home.products_kicker',   'Trang chủ', 'Nhãn section sản phẩm',  'text', 'Bộ Sưu Tập Tuyển Chọn'],
    ['home.products_title',    'Trang chủ', 'Tiêu đề section sản phẩm','text', 'Sản Phẩm Nổi Bật'],
    // Story section
    ['home.story_kicker',      'Trang chủ', 'Nhãn câu chuyện',        'text', 'Câu Chuyện Của Chúng Tôi'],
    ['home.story_title',       'Trang chủ', 'Tiêu đề câu chuyện',     'textarea', 'Khát khao mang không gian xanh vào cuộc sống hiện đại'],
    ['home.story_p1',          'Trang chủ', 'Đoạn câu chuyện 1',      'textarea', 'Plantify Co ra đời từ tình yêu với thiên nhiên. Chúng tôi tin rằng, một mầm xanh không chỉ làm đẹp căn phòng mà còn là liệu pháp tinh thần vô giá sau những giờ làm việc căng thẳng.'],
    ['home.story_p2',          'Trang chủ', 'Đoạn câu chuyện 2',      'textarea', 'Với quy trình tuyển chọn khắt khe từ các nhà vườn uy tín, chúng tôi cam kết mỗi sản phẩm gửi đi đều đạt chất lượng cao nhất.'],
    // CTA
    ['home.cta_title',         'Trang chủ', 'Tiêu đề CTA',            'textarea', 'Sẵn sàng mang thiên nhiên vào nhà?'],
    ['home.cta_text',          'Trang chủ', 'Mô tả CTA',              'textarea', 'Đừng ngần ngại liên hệ nếu bạn cần chuyên gia của Plantify tư vấn loại cây phù hợp với không gian và mệnh của mình.'],
    ['home.cta_button',        'Trang chủ', 'Nút CTA',                'text',     'Bắt Đầu Mua Sắm'],
];

foreach ($homeDefaults as $row) {
    $db->query("INSERT INTO site_content (content_key, content_group, label, input_type, content_value)
                VALUES (:k, :g, :l, :t, :v)
                ON DUPLICATE KEY UPDATE content_group=VALUES(content_group), label=VALUES(label), input_type=VALUES(input_type)");
    $db->bind(':k', $row[0]); $db->bind(':g', $row[1]);
    $db->bind(':l', $row[2]); $db->bind(':t', $row[3]); $db->bind(':v', $row[4]);
    $db->execute();
}

/* ── Xử lý POST ── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    foreach ($_POST['content'] as $key => $value) {
        $db->query("UPDATE site_content SET content_value = :v WHERE content_key = :k");
        $db->bind(':v', trim($value));
        $db->bind(':k', $key);
        $db->execute();
    }
    $message = 'Đã lưu nội dung trang chủ!';
}

/* ── Đọc dữ liệu ── */
$db->query("SELECT * FROM site_content WHERE content_group = 'Trang chủ' ORDER BY id");
$rows = $db->resultSet();
$byKey = [];
foreach ($rows as $r) $byKey[$r['content_key']] = $r;

/* ── Cấu trúc editor ── */
$sections = [
    ['title' => 'Hero đầu trang',
     'desc'  => 'Tiêu đề lớn, mô tả, nút bấm và thẻ thông tin.',
     'keys'  => ['home.hero_kicker','home.hero_title','home.hero_description','home.hero_btn_primary','home.hero_btn_secondary','home.hero_card_title','home.hero_card_text']],
    ['title' => 'Các chỉ số nổi bật',
     'desc'  => 'Bốn con số hiển thị ngay dưới hero.',
     'keys'  => ['home.metric_1_value','home.metric_1_label','home.metric_2_value','home.metric_2_label','home.metric_3_value','home.metric_3_label','home.metric_4_value','home.metric_4_label']],
    ['title' => 'Section "Về chúng tôi"',
     'desc'  => 'Tiêu đề, mô tả và danh sách điểm mạnh.',
     'keys'  => ['home.features_kicker','home.features_title','home.features_lead','home.feature_1','home.feature_2','home.feature_3','home.feature_4']],
    ['title' => 'Section Sản phẩm nổi bật',
     'desc'  => 'Nhãn và tiêu đề phần hiển thị sản phẩm featured.',
     'keys'  => ['home.products_kicker','home.products_title']],
    ['title' => 'Câu chuyện thương hiệu',
     'desc'  => 'Đoạn nội dung kể về Plantify phía cuối trang.',
     'keys'  => ['home.story_kicker','home.story_title','home.story_p1','home.story_p2']],
    ['title' => 'CTA cuối trang',
     'desc'  => 'Khối kêu gọi hành động.',
     'keys'  => ['home.cta_title','home.cta_text','home.cta_button']],
];

admin_layout_start([
    'pageTitle'  => 'Nội dung Trang chủ',
    'heading'    => 'Nội dung Trang chủ',
    'subtitle'   => 'Chỉnh sửa văn bản hiển thị trên trang chủ website.',
    'actionHtml' => '<a class="btn btn-outline-success" href="' . BASE_URL . '/" target="_blank"><i class="fa-solid fa-eye me-2"></i>Xem trang chủ</a>',
    'extraHead'  => '<style>
        .pe-editor-section { border:1px solid #e5ece6; border-radius:10px; background:#fff; overflow:hidden; margin-bottom:12px; }
        .pe-editor-section summary { cursor:pointer; list-style:none; padding:14px 18px; background:#f7fbf7; }
        .pe-editor-section summary::-webkit-details-marker { display:none; }
        .pe-section-title { display:flex; align-items:center; justify-content:space-between; gap:16px; }
        .pe-section-title strong { color:#1d5f35; font-size:15px; }
        .pe-section-title span { color:#748075; font-size:13px; }
        .pe-section-title i { color:#198754; transition:transform .2s; }
        .pe-editor-section[open] .pe-section-title i { transform:rotate(180deg); }
        .pe-section-body { padding:18px; border-top:1px solid #e5ece6; }
    </style>',
]);
?>

<?php if ($message): ?><div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i><?= e($message) ?>
</div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>

<form method="POST">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Nội dung trang chủ</h4>
            <p class="text-muted mb-0">Mở từng mục để chỉnh văn bản đang hiển thị.</p>
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