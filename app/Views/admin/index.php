<?php
/**
 * File: admin/index.php
 * Chuc nang: Tong quan khu vuc quan tri noi dung gioi thieu va FAQ.
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$pageTitle = 'Admin | GreenNest Landscape';
$db = data_db();
$counts = [
    'content' => count(site_content_all()),
    'pages' => 0,
    'faqs' => count($faqs),
    'rag_lines' => 0,
];

$ragFile = realpath(STORAGE_PATH . '/rag/RAG.txt');
if ($ragFile && is_file($ragFile)) {
    $ragContent = (string) file_get_contents($ragFile);
    $counts['rag_lines'] = $ragContent === '' ? 0 : substr_count($ragContent, "\n") + 1;
}

if ($db) {
    foreach (['faqs', 'pages'] as $table) {
        try {
            $counts[$table] = (int) $db->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
        } catch (PDOException $exception) {
            continue;
        }
    }
}

$chartLabels = ['Noi dung', 'Trang', 'FAQ', 'Dong RAG'];
$chartValues = [$counts['content'], $counts['pages'], $counts['faqs'], $counts['rag_lines']];
$dashboardChartData = json_encode([
    'labels' => $chartLabels,
    'values' => $chartValues,
], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Dashboard noi dung',
    'subtitle' => 'Tong quan nhanh cho phan trang gioi thieu, FAQ va du lieu hoi dap.',
    'actionHtml' => '<a href="pages.php" class="btn btn-success">Sua trang gioi thieu</a>',
]);
?>

<div class="sales-report-area mb-5">
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pe--20 pt--30 mb-3">
                    <div class="icon icon-blue"><i class="ti-write"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Khoi noi dung</h4>
                    </div>
                    <span class="admin-report-value"><?php echo e($counts['content']); ?></span>
                </div>
                <canvas id="coin_sales1" height="100"></canvas>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pe--20 pt--30 mb-3">
                    <div class="icon icon-amber"><i class="ti-layout-media-center-alt"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Trang gioi thieu</h4>
                    </div>
                    <span class="admin-report-value"><?php echo e($counts['pages']); ?></span>
                </div>
                <canvas id="coin_sales2" height="100"></canvas>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="single-report mb-xs-30">
                <div class="s-report-inner pe--20 pt--30 mb-3">
                    <div class="icon icon-emerald"><i class="ti-help-alt"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">FAQ</h4>
                    </div>
                    <span class="admin-report-value"><?php echo e($counts['faqs']); ?></span>
                </div>
                <canvas id="coin_sales3" height="100"></canvas>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="single-report">
                <div class="s-report-inner pe--20 pt--30 mb-3">
                    <div class="icon icon-blue"><i class="ti-comments"></i></div>
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Du lieu bot</h4>
                    </div>
                    <span class="admin-report-value"><?php echo e($counts['rag_lines']); ?></span>
                </div>
                <canvas id="coin_sales4" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-center">
                    <h4 class="header-title mb-0">Tong quan module gioi thieu va QA</h4>
                    <span class="admin-muted">Live count tu database va RAG.txt</span>
                </div>
                <div class="admin-chart-wrap mt-4">
                    <canvas id="adminOverviewChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 mt-lg-30 mt-md-30 mt-xs-30">
        <div class="card h-full">
            <div class="card-body">
                <h4 class="header-title">Tac vu nhanh</h4>
                <div class="admin-meta-list mt-4">
                    <div>
                        <span>Noi dung trang gioi thieu</span>
                        <strong><a href="pages.php">Chinh sua noi dung</a></strong>
                    </div>
                    <div>
                        <span>Cau hoi thuong gap</span>
                        <strong><a href="faqs.php">Quan ly FAQ</a></strong>
                    </div>
                    <div>
                        <span>Du lieu bot hoi dap</span>
                        <strong><a href="rag.php">Cap nhat RAG.txt</a></strong>
                    </div>
                    <div>
                        <span>Website public</span>
                        <strong><a href="../zabout.php">Mo trang gioi thieu</a></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$extraScripts = '
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
<script src="' . asset('assets/vendor/srtdash/js/line-chart.js') . '"></script>
<script src="' . asset('assets/vendor/srtdash/js/bar-chart.js') . '"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var chartEl = document.getElementById("adminOverviewChart");
    var chartData = ' . $dashboardChartData . ';
    if (chartEl && window.Chart) {
        new Chart(chartEl, {
            type: "bar",
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: "So luong",
                    data: chartData.values,
                    backgroundColor: ["#3b82f6", "#f59e0b", "#10b981", "#6366f1"],
                    borderRadius: 8
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }
});
</script>';

admin_layout_end($extraScripts);
?>
