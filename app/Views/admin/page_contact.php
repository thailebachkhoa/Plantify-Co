<?php

/**
 * File: admin/page_contact.php
 * Chức năng: Chỉnh sửa nội dung tĩnh trang liên hệ (hero, form labels, thông tin liên hệ...).
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$db = Database::getInstance();
$message = '';
$error = '';

$contactPageDefaults = [
    // SEO
    ['contact.meta_title',          'Trang liên hệ', 'Meta title',                          'text',     'Liên hệ | Plantify Co'],
    ['contact.meta_description',    'Trang liên hệ', 'Meta description',                     'textarea', 'Liên hệ Plantify Co để được tư vấn về cây xanh nội thất, thiết kế decor và dịch vụ chăm sóc định kỳ.'],
    // Hero
    ['contact.hero_kicker',         'Trang liên hệ', 'Nhãn hero',                           'text',     'Kết nối với Plantify'],
    ['contact.hero_title',          'Trang liên hệ', 'Tiêu đề hero',                        'text',     'Luôn sẵn sàng hỗ trợ bạn'],
    ['contact.hero_description',    'Trang liên hệ', 'Mô tả hero',                          'textarea', 'Dù bạn cần tư vấn chọn cây cho văn phòng, hỏi đáp về cách chăm sóc, hay phản hồi dịch vụ, chúng tôi luôn ở đây để lắng nghe.'],
    ['contact.hero_card_title',     'Trang liên hệ', 'Tiêu đề thẻ hero',                    'text',     'Phản hồi nhanh'],
    ['contact.hero_card_text',      'Trang liên hệ', 'Nội dung thẻ hero',                   'textarea', 'Đội ngũ CSKH cam kết trả lời các yêu cầu trực tuyến trong vòng 24 giờ làm việc.'],
    // Form
    ['contact.form_title',          'Trang liên hệ', 'Tiêu đề form liên hệ',                'text',     'Gửi tin nhắn cho chúng tôi'],
    ['contact.form_subtitle',       'Trang liên hệ', 'Mô tả dưới tiêu đề form',             'textarea', 'Để lại thông tin bên dưới, chuyên viên của Plantify sẽ liên hệ lại với bạn ngay.'],
    ['contact.label_name',          'Trang liên hệ', 'Nhãn trường Họ và tên',               'text',     'Họ và tên'],
    ['contact.placeholder_name',    'Trang liên hệ', 'Gợi ý trường Họ và tên',              'text',     'Ví dụ: Nguyễn Văn A'],
    ['contact.label_email',         'Trang liên hệ', 'Nhãn trường Email',                   'text',     'Email'],
    ['contact.placeholder_email',   'Trang liên hệ', 'Gợi ý trường Email',                  'text',     'example@email.com'],
    ['contact.label_subject',       'Trang liên hệ', 'Nhãn trường Chủ đề',                  'text',     'Chủ đề'],
    ['contact.subject_default',     'Trang liên hệ', 'Tùy chọn mặc định Chủ đề',            'text',     '-- Chọn chủ đề cần tư vấn --'],
    ['contact.subject_1',           'Trang liên hệ', 'Chủ đề 1',                            'text',     'Mua sắm cây xanh'],
    ['contact.subject_2',           'Trang liên hệ', 'Chủ đề 2',                            'text',     'Dịch vụ decor/setup văn phòng'],
    ['contact.subject_3',           'Trang liên hệ', 'Chủ đề 3',                            'text',     'Hỏi đáp cách chăm sóc cây'],
    ['contact.subject_4',           'Trang liên hệ', 'Chủ đề 4',                            'text',     'Khác'],
    ['contact.label_message',       'Trang liên hệ', 'Nhãn trường Nội dung',                'text',     'Nội dung'],
    ['contact.placeholder_message', 'Trang liên hệ', 'Gợi ý trường Nội dung',               'textarea', 'Nhập tin nhắn của bạn...'],
    ['contact.btn_submit',          'Trang liên hệ', 'Nhãn nút gửi form',                   'text',     'Gửi liên hệ'],
    // Success / Error messages
    ['contact.success_message',     'Trang liên hệ', 'Thông báo gửi thành công',             'textarea', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong vòng 24 giờ.'],
    // Sidebar thông tin
    ['contact.sidebar_title',       'Trang liên hệ', 'Tiêu đề sidebar thông tin',            'text',     'Bạn cần hỗ trợ gấp?'],
    ['contact.sidebar_description', 'Trang liên hệ', 'Mô tả sidebar',                        'textarea', 'Đừng ngại gọi cho hotline hoặc ghé trực tiếp showroom của chúng tôi để được giải đáp tức thời.'],
];

foreach ($contactPageDefaults as $row) {
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
    $message = 'Đã lưu nội dung trang liên hệ!';
}

$db->query("SELECT * FROM site_content WHERE content_group = 'Trang liên hệ' ORDER BY id");
$rows = $db->resultSet();
$byKey = [];
foreach ($rows as $r) $byKey[$r['content_key']] = $r;

$sections = [
    ['title' => 'SEO',
     'desc'  => 'Tên tab trình duyệt và mô tả tìm kiếm.',
     'keys'  => ['contact.meta_title','contact.meta_description']],
    ['title' => 'Hero đầu trang',
     'desc'  => 'Tiêu đề, mô tả và thẻ thông tin bên phải.',
     'keys'  => ['contact.hero_kicker','contact.hero_title','contact.hero_description','contact.hero_card_title','contact.hero_card_text']],
    ['title' => 'Form liên hệ',
     'desc'  => 'Tiêu đề form, nhãn các trường và nút gửi.',
     'keys'  => ['contact.form_title','contact.form_subtitle','contact.label_name','contact.placeholder_name','contact.label_email','contact.placeholder_email','contact.label_subject','contact.subject_default','contact.subject_1','contact.subject_2','contact.subject_3','contact.subject_4','contact.label_message','contact.placeholder_message','contact.btn_submit']],
    ['title' => 'Thông báo',
     'desc'  => 'Thông báo hiển thị sau khi gửi form thành công.',
     'keys'  => ['contact.success_message']],
    ['title' => 'Sidebar thông tin',
     'desc'  => 'Tiêu đề và mô tả cột bên phải (số điện thoại, địa chỉ lấy từ Công ty).',
     'keys'  => ['contact.sidebar_title','contact.sidebar_description']],
];

admin_layout_start([
    'pageTitle'  => 'Nội dung Trang liên hệ',
    'heading'    => 'Nội dung Trang liên hệ',
    'subtitle'   => 'Chỉnh sửa văn bản tĩnh trên trang Contact. Thông tin địa chỉ, SĐT, email lấy từ mục Công ty.',
    'actionHtml' => '<a class="btn btn-outline-success" href="' . BASE_URL . '/contact" target="_blank"><i class="fa-solid fa-eye me-2"></i>Xem trang liên hệ</a>',
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

<div class="alert alert-info d-flex gap-2 align-items-start mb-4">
    <i class="fa-solid fa-circle-info mt-1"></i>
    <div>Địa chỉ, số điện thoại, email và giờ làm việc được kéo từ nhóm <strong>Công ty</strong>. Chỉnh sửa tại
        <a href="<?= BASE_URL ?>/admin/pages#company" class="alert-link">Trang giới thiệu → Nội dung dùng chung</a>.
    </div>
</div>

<form method="POST">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Nội dung trang liên hệ</h4>
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