<?php
/**
 * File: admin/rag.php
 * Chuc nang: Quan ly noi dung RAG/RAG.txt de cap nhat nguon thong tin cho bot.
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$pageTitle = 'Du lieu bot | GreenNest Admin';
$ragPath = realpath(STORAGE_PATH . '/rag');
$ragFile = $ragPath ? $ragPath . DIRECTORY_SEPARATOR . 'RAG.txt' : null;
$message = '';
$error = '';

if (!$ragPath || !$ragFile) {
    $error = 'Khong tim thay thu muc RAG.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['rag_content'] ?? '';

    if (strlen($content) > 1024 * 1024) {
        $error = 'Noi dung RAG.txt khong duoc vuot qua 1MB.';
    } elseif (file_put_contents($ragFile, $content, LOCK_EX) === false) {
        $error = 'Khong the luu RAG.txt. Hay kiem tra quyen ghi cua thu muc RAG.';
    } else {
        $message = 'Da cap nhat RAG.txt cho bot.';
    }
}

$ragContent = '';
if ($ragFile && is_file($ragFile)) {
    $ragContent = file_get_contents($ragFile);
    if ($ragContent === false) {
        $ragContent = '';
        $error = $error ?: 'Khong the doc RAG.txt.';
    }
} elseif ($ragFile && !$error) {
    $error = 'Khong tim thay file RAG.txt.';
}

clearstatcache(true, $ragFile ?: '');
$fileSize = ($ragFile && is_file($ragFile)) ? filesize($ragFile) : 0;
$updatedAt = ($ragFile && is_file($ragFile)) ? date('d/m/Y H:i:s', filemtime($ragFile)) : 'Chua co';
$lineCount = $ragContent === '' ? 0 : substr_count($ragContent, "\n") + 1;

admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Du lieu huan luyen bot',
    'subtitle' => 'Sua noi dung trong RAG.txt de cap nhat kien thuc ma tro ly AI dung khi tra loi khach hang.',
]);
?>

<?php if ($message): ?><div class="alert alert-success"><?php echo e($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>

<div class="row">
    <div class="col-xl-8">
        <form method="post" class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="header-title mb-1">Noi dung RAG.txt</h4>
                        <p class="admin-muted mb-0">Nen viet theo tung muc ro rang: dich vu, san pham, quy trinh, FAQ, lien he.</p>
                    </div>
                    <button type="submit" class="btn btn-success mt-3 mt-sm-0">Luu du lieu bot</button>
                </div>
                <textarea class="form-control admin-textarea-large" name="rag_content" spellcheck="false"><?php echo e($ragContent); ?></textarea>
            </div>
        </form>
    </div>
    <div class="col-xl-4 mt-lg-30 mt-md-30 mt-xs-30">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Thong tin file</h4>
                <div class="admin-meta-list mt-4">
                    <div>
                        <span>Cap nhat lan cuoi</span>
                        <strong><?php echo e($updatedAt); ?></strong>
                    </div>
                    <div>
                        <span>Dung luong</span>
                        <strong><?php echo e(number_format((float) $fileSize / 1024, 2)); ?> KB</strong>
                    </div>
                    <div>
                        <span>So dong</span>
                        <strong><?php echo e($lineCount); ?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="header-title">Goi y cap nhat</h4>
                <p class="admin-muted mb-0">Sau khi luu, neu server RAG dang giu du lieu trong bo nho, hay khoi dong lai process chatbot de bot doc phien ban moi cua file.</p>
            </div>
        </div>
    </div>
</div>

<?php admin_layout_end(); ?>
