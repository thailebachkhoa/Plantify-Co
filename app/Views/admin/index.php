<?php

/**
 * File: app/Views/admin/index.php
 * Chức năng: Tổng quan khu vực quản trị (Sử dụng AdminLayout gốc)
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$pageTitle = 'Tổng quan hệ thống';

// Khởi tạo các class thay cho hàm toàn cục cũ
$db = Database::getInstance();
$dataModel = new Data();

$counts = [
    'content'   => 0,
    'pages'     => 0,
    'faqs'      => 0,
    'users'     => 0,
    'rag_lines' => 0
];

// 1. Đếm số lượng cấu hình (site_content)
$siteContent = $dataModel->site_content_all();
$counts['content'] = count($siteContent);

// 2. Đếm số lượng FAQ
$faqs = $dataModel->fetch_table_rows('faqs');
$counts['faqs'] = $faqs ? count($faqs) : 0;

// 3. Đếm số lượng Trang (pages)
try {
    $db->query("SELECT COUNT(*) as total FROM pages");
    $result = $db->single();
    $counts['pages'] = (int) ($result['total'] ?? 0);
} catch (Exception $e) {
}

// 4. Đếm số lượng Người dùng (users)
try {
    $db->query("SELECT COUNT(*) as total FROM users");
    $result = $db->single();
    $counts['users'] = (int) ($result['total'] ?? 0);
} catch (Exception $e) {
}

// 5. Đếm số dòng dữ liệu RAG (Bot)
$ragFile = realpath(STORAGE_PATH . '/rag/RAG.txt');
if ($ragFile && is_file($ragFile)) {
    $ragContent = trim((string) file_get_contents($ragFile));
    $counts['rag_lines'] = $ragContent === '' ? 0 : substr_count($ragContent, "\n") + 1;
}

// Chuẩn bị dữ liệu cho biểu đồ
$chartLabels = ['Nội dung', 'Trang', 'FAQ', 'Dữ liệu Bot (Dòng)', 'Thành viên'];
$chartValues = [$counts['content'], $counts['pages'], $counts['faqs'], $counts['rag_lines'], $counts['users']];
$dashboardChartData = json_encode([
    'labels' => $chartLabels,
    'values' => $chartValues,
]);

// BẮT ĐẦU GIAO DIỆN BẰNG ADMIN LAYOUT GỐC
admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Tổng quan hệ thống',
    'subtitle' => 'Dữ liệu trực tiếp từ Database & RAG'
]);
?>

<div class="row g-4 mb-4 mt-2">
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0 fw-bold">Người dùng</h6>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-users fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-stone-900"><?= $counts['users'] ?></h3>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0 fw-bold">Trang nội dung</h6>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-file-lines fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-stone-900"><?= $counts['pages'] ?></h3>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0 fw-bold">Hỏi đáp FAQ</h6>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-circle-question fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-stone-900"><?= $counts['faqs'] ?></h3>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0 fw-bold">Dữ liệu Bot RAG</h6>
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-robot fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-stone-900"><?= $counts['rag_lines'] ?> <span
                        class="fs-6 fw-normal text-muted">dòng</span></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-stone-900">Tổng quan dữ liệu</h5>
                    <span class="badge bg-light text-muted border">Live Database</span>
                </div>
                <div style="height: 320px;">
                    <canvas id="adminOverviewChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-stone-900">Tác vụ nhanh</h5>
                <div class="list-group list-group-flush gap-2">
                    <a href="<?= BASE_URL ?>/admin/pages"
                        class="list-group-item list-group-item-action border rounded-3 px-3 py-3 d-flex align-items-center justify-content-between hover-bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-pen-to-square text-success"></i>
                            <span class="fw-medium">Chỉnh sửa giới thiệu</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>

                    <a href="<?= BASE_URL ?>/admin/news_create"
                        class="list-group-item list-group-item-action border rounded-3 px-3 py-3 d-flex align-items-center justify-content-between hover-bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-newspaper text-primary"></i>
                            <span class="fw-medium">Đăng bài tin tức mới</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>

                    <a href="<?= BASE_URL ?>/admin/users"
                        class="list-group-item list-group-item-action border rounded-3 px-3 py-3 d-flex align-items-center justify-content-between hover-bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-user-shield text-warning"></i>
                            <span class="fw-medium">Kiểm duyệt tài khoản</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>

                    <a href="<?= BASE_URL ?>" target="_blank"
                        class="list-group-item list-group-item-action border rounded-3 px-3 py-3 d-flex align-items-center justify-content-between hover-bg-light mt-2 bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-arrow-up-right-from-square text-secondary"></i>
                            <span class="fw-medium text-secondary">Xem trang công khai</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// GÓI TOÀN BỘ SCRIPT VÀO BIẾN ĐỂ TRUYỀN CHO ADMIN_LAYOUT_END
$extraScripts = '
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="' . asset('vendor/srtdash/js/line-chart.js') . '"></script>
<script src="' . asset('vendor/srtdash/js/bar-chart.js') . '"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chartEl = document.getElementById("adminOverviewChart");
        var chartData = ' . $dashboardChartData . ';

        if (chartEl && window.Chart) {
            new Chart(chartEl, {
                type: "bar",
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: "Số lượng",
                        data: chartData.values,
                        backgroundColor: [
                            "rgba(16, 185, 129, 0.8)", // Green
                            "rgba(59, 130, 246, 0.8)", // Blue
                            "rgba(245, 158, 11, 0.8)", // Amber
                            "rgba(99, 102, 241, 0.8)", // Indigo
                            "rgba(236, 72, 153, 0.8)" // Pink
                        ],
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: "#1f2722",
                            padding: 12,
                            titleFont: { size: 14 },
                            bodyFont: { size: 14 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 },
                            grid: { borderDash: [4, 4] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });
</script>
';

admin_layout_end($extraScripts);
?>