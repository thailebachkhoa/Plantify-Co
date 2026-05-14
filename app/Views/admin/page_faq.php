<?php

/**
 * File: admin/page_faq.php
 * Chức năng: Chỉnh sửa nội dung tĩnh trang FAQ (hero, sidebar, các bước, chatbot...).
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$db = Database::getInstance();
$message = '';
$error = '';

$faqPageDefaults = [
    // SEO
    ['faq.meta_title',          'Trang FAQ', 'Meta title',                   'text',     'FAQ | Câu hỏi thường gặp về cây cảnh và decor xanh'],
    ['faq.meta_description',    'Trang FAQ', 'Meta description',              'textarea', 'Giải đáp câu hỏi về khảo sát, bảo hành, chăm sóc định kỳ, tư vấn online và dịch vụ cây xanh doanh nghiệp.'],
    // Hero
    ['faq.hero_kicker',         'Trang FAQ', 'Nhãn hero',                    'text',     'FAQ & tư vấn nhanh'],
    ['faq.hero_title',          'Trang FAQ', 'Tiêu đề hero',                  'textarea', 'Câu hỏi thường gặp về cây xanh, decor và chăm sóc định kỳ'],
    ['faq.hero_description',    'Trang FAQ', 'Mô tả hero',                   'textarea', 'Tra cứu nhanh các thông tin quan trọng trước khi khảo sát, chọn cây, nhận báo giá hoặc sử dụng gói chăm sóc sau bàn giao.'],
    ['faq.hero_search_placeholder','Trang FAQ','Gợi ý ô tìm kiếm FAQ',       'text',     'Tìm nhanh: bảo hành, khảo sát, gửi ảnh, chăm sóc...'],
    ['faq.hero_card_title',     'Trang FAQ', 'Tiêu đề thẻ hero',              'text',     'Cần câu trả lời riêng?'],
    ['faq.hero_card_text',      'Trang FAQ', 'Nội dung thẻ hero',             'textarea', 'Mở trợ lý AI ở góc màn hình hoặc gửi ảnh không gian để được tư vấn theo điều kiện thực tế.'],
    // Sidebar
    ['faq.sidebar_kicker',      'Trang FAQ', 'Nhãn sidebar',                  'text',     'Điểm cần biết'],
    ['faq.sidebar_title',       'Trang FAQ', 'Tiêu đề sidebar',               'text',     'Chuẩn bị trước khi tư vấn'],
    ['faq.sidebar_description', 'Trang FAQ', 'Mô tả sidebar',                 'textarea', 'Thông tin càng rõ, phương án cây xanh càng sát nhu cầu và ngân sách.'],
    ['faq.sidebar_item_1',      'Trang FAQ', 'Gợi ý chuẩn bị 1',             'text',     'Ảnh tổng thể và góc cần đặt cây'],
    ['faq.sidebar_item_2',      'Trang FAQ', 'Gợi ý chuẩn bị 2',             'text',     'Thời lượng ánh sáng trong ngày'],
    ['faq.sidebar_item_3',      'Trang FAQ', 'Gợi ý chuẩn bị 3',             'text',     'Kích thước khu vực dự kiến'],
    ['faq.sidebar_item_4',      'Trang FAQ', 'Gợi ý chuẩn bị 4',             'text',     'Ngân sách hoặc mức ưu tiên'],
    ['faq.sidebar_cta',         'Trang FAQ', 'Nút CTA sidebar',               'text',     'Về Plantify'],
    // Quick questions (chips)
    ['faq.chip_1',              'Trang FAQ', 'Câu hỏi nhanh chip 1',          'text',     'Plantify có khảo sát trực tiếp trước khi thiết kế không?'],
    ['faq.chip_1_label',        'Trang FAQ', 'Nhãn chip 1',                   'text',     'Có khảo sát không?'],
    ['faq.chip_2',              'Trang FAQ', 'Câu hỏi nhanh chip 2',          'text',     'Tôi có thể gửi ảnh mặt bằng để được tư vấn online không?'],
    ['faq.chip_2_label',        'Trang FAQ', 'Nhãn chip 2',                   'text',     'Gửi ảnh tư vấn?'],
    ['faq.chip_3',              'Trang FAQ', 'Câu hỏi nhanh chip 3',          'text',     'Cây được bảo hành sau bàn giao như thế nào?'],
    ['faq.chip_3_label',        'Trang FAQ', 'Nhãn chip 3',                   'text',     'Bảo hành cây?'],
    // 3 bước sau FAQ
    ['faq.steps_kicker',        'Trang FAQ', 'Nhãn section các bước',         'text',     'Sau khi có câu trả lời'],
    ['faq.steps_title',         'Trang FAQ', 'Tiêu đề section các bước',      'text',     'Quy trình tiếp theo rất gọn'],
    ['faq.step_1_icon',         'Trang FAQ', 'Icon bước 1 (Font Awesome)',     'text',     'fa-paperclip'],
    ['faq.step_1_title',        'Trang FAQ', 'Tiêu đề bước 1',                'text',     'Gửi ảnh và nhu cầu'],
    ['faq.step_1_text',         'Trang FAQ', 'Nội dung bước 1',               'textarea', 'Đính kèm ảnh hiện trạng, phong cách mong muốn và ngân sách dự kiến.'],
    ['faq.step_2_icon',         'Trang FAQ', 'Icon bước 2',                   'text',     'fa-comments'],
    ['faq.step_2_title',        'Trang FAQ', 'Tiêu đề bước 2',                'text',     'Nhận tư vấn sơ bộ'],
    ['faq.step_2_text',         'Trang FAQ', 'Nội dung bước 2',               'textarea', 'Plantify đề xuất nhóm cây, kích thước chậu và mức chăm sóc phù hợp.'],
    ['faq.step_3_icon',         'Trang FAQ', 'Icon bước 3',                   'text',     'fa-calendar-days'],
    ['faq.step_3_title',        'Trang FAQ', 'Tiêu đề bước 3',                'text',     'Chốt lịch khảo sát'],
    ['faq.step_3_text',         'Trang FAQ', 'Nội dung bước 3',               'textarea', 'Đội ngũ kiểm tra thực tế trước khi báo giá và triển khai chính thức.'],
    // Chatbot widget
    ['faq.chatbot_title',       'Trang FAQ', 'Tiêu đề chatbot widget',        'text',     'Trợ lý AI Plantify'],
    ['faq.chatbot_subtitle',    'Trang FAQ', 'Mô tả chatbot widget',          'text',     'Hỏi về cây xanh, dịch vụ và FAQ'],
    ['faq.chatbot_greeting',    'Trang FAQ', 'Lời chào mở đầu chatbot',       'textarea', 'Xin chào! Tôi có thể giúp gì cho bạn về dịch vụ cây xanh hôm nay?'],
    ['faq.chatbot_placeholder', 'Trang FAQ', 'Placeholder ô nhập chatbot',    'text',     'Nhập câu hỏi...'],
];

foreach ($faqPageDefaults as $row) {
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
    $message = 'Đã lưu nội dung trang FAQ!';
}

$db->query("SELECT * FROM site_content WHERE content_group = 'Trang FAQ' ORDER BY id");
$rows = $db->resultSet();
$byKey = [];
foreach ($rows as $r) $byKey[$r['content_key']] = $r;

$sections = [
    ['title' => 'SEO',
     'desc'  => 'Meta title và description cho trang FAQ.',
     'keys'  => ['faq.meta_title','faq.meta_description']],
    ['title' => 'Hero đầu trang',
     'desc'  => 'Tiêu đề, mô tả, ô tìm kiếm và thẻ thông tin bên phải.',
     'keys'  => ['faq.hero_kicker','faq.hero_title','faq.hero_description','faq.hero_search_placeholder','faq.hero_card_title','faq.hero_card_text']],
    ['title' => 'Sidebar chuẩn bị tư vấn',
     'desc'  => 'Tiêu đề và danh sách gợi ý chuẩn bị trước khi liên hệ.',
     'keys'  => ['faq.sidebar_kicker','faq.sidebar_title','faq.sidebar_description','faq.sidebar_item_1','faq.sidebar_item_2','faq.sidebar_item_3','faq.sidebar_item_4','faq.sidebar_cta']],
    ['title' => 'Câu hỏi nhanh (chip buttons)',
     'desc'  => 'Nội dung câu hỏi và nhãn hiển thị của 3 chip bên dưới sidebar.',
     'keys'  => ['faq.chip_1_label','faq.chip_1','faq.chip_2_label','faq.chip_2','faq.chip_3_label','faq.chip_3']],
    ['title' => 'Quy trình 3 bước',
     'desc'  => 'Section phía dưới accordion FAQ.',
     'keys'  => ['faq.steps_kicker','faq.steps_title','faq.step_1_title','faq.step_1_text','faq.step_2_title','faq.step_2_text','faq.step_3_title','faq.step_3_text']],
    ['title' => 'Chatbot widget',
     'desc'  => 'Tiêu đề, lời chào và placeholder của widget trợ lý AI.',
     'keys'  => ['faq.chatbot_title','faq.chatbot_subtitle','faq.chatbot_greeting','faq.chatbot_placeholder']],
];

admin_layout_start([
    'pageTitle'  => 'Nội dung Trang FAQ',
    'heading'    => 'Nội dung Trang FAQ',
    'subtitle'   => 'Chỉnh sửa văn bản tĩnh hiển thị trên trang câu hỏi thường gặp.',
    'actionHtml' => '<a class="btn btn-outline-success" href="' . BASE_URL . '/faq" target="_blank"><i class="fa-solid fa-eye me-2"></i>Xem trang FAQ</a>',
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

<form method="POST">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Nội dung trang FAQ</h4>
            <p class="text-muted mb-0">Mở từng mục để chỉnh văn bản tĩnh.</p>
        </div>
        <button type="submit" class="btn btn-success px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Lưu thay
            đổi</button>
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
                    $row = $byKey[$key]; $isTextarea = $row['input_type'] === 'textarea';
                ?>
                <div class="<?= $isTextarea ? 'col-12' : 'col-lg-6' ?> mb-3">
                    <label class="form-label"><?= e($row['label']) ?><span
                            class="d-block small text-muted"><?= e($key) ?></span></label>
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
        <button type="submit" class="btn btn-success px-5"><i class="fa-solid fa-floppy-disk me-2"></i>Lưu tất cả thay
            đổi</button>
    </div>
</form>

<?php admin_layout_end(); ?>