<?php
/**
 * File: admin/faqs.php
 * Chuc nang: Quan ly FAQ (xem, them, sua, xoa).
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$pageTitle = 'Quan ly FAQ | GreenNest Admin';
$db = getDatabaseConnection();
$message = '';
$error = '';

if (!$db) {
    $error = 'Chua ket noi duoc database. Hay import database/migrations/schema.sql va kiem tra config/database.php.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    $question = trim($_POST['question'] ?? '');
    $answer = trim($_POST['answer'] ?? '');
    $sortOrder = max(0, (int) ($_POST['sort_order'] ?? 0));

    if ($action === 'reorder') {
        $orderedIds = json_decode($_POST['ordered_ids'] ?? '[]', true);
        if (is_array($orderedIds) && count($orderedIds) > 0) {
            $stmt = $db->prepare('UPDATE faqs SET sort_order = ? WHERE id = ?');
            foreach (array_values($orderedIds) as $index => $faqId) {
                $stmt->execute([$index + 1, (int) $faqId]);
            }
            if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest') {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => true, 'message' => 'Thu tu FAQ da duoc cap nhat.'], JSON_UNESCAPED_UNICODE);
                exit;
            }
            $message = 'Thu tu FAQ da duoc cap nhat.';
        } else {
            $error = 'Khong co du lieu sap xep FAQ.';
        }
    } elseif (($action === 'add' || $action === 'edit') && mb_strlen($question) > 255) {
        $error = 'Cau hoi khong duoc vuot qua 255 ky tu.';
    } elseif (($action === 'add' || $action === 'edit') && mb_strlen($answer) > 5000) {
        $error = 'Cau tra loi khong duoc vuot qua 5000 ky tu.';
    } elseif ($action === 'add' && $question && $answer) {
        $stmt = $db->prepare('INSERT INTO faqs (question, answer, sort_order) VALUES (?, ?, ?)');
        $stmt->execute([$question, $answer, $sortOrder]);
        $message = 'FAQ da duoc them.';
    } elseif ($action === 'edit' && $id && $question && $answer) {
        $stmt = $db->prepare('UPDATE faqs SET question = ?, answer = ?, sort_order = ? WHERE id = ?');
        $stmt->execute([$question, $answer, $sortOrder, $id]);
        $message = 'FAQ da duoc cap nhat.';
    } elseif ($action === 'delete' && $id) {
        $stmt = $db->prepare('DELETE FROM faqs WHERE id = ?');
        $stmt->execute([$id]);
        $message = 'FAQ da duoc xoa.';
    } else {
        $error = 'Vui long nhap du cau hoi va cau tra loi.';
    }
}

$faqs = [];
if ($db) {
    try {
        $faqs = $db->query('SELECT * FROM faqs ORDER BY sort_order, id')->fetchAll();
    } catch (PDOException $exception) {
        $error = 'Thieu bang FAQ. Hay import lai database/migrations/schema.sql.';
    }
}

admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Quan ly cau hoi/dap',
    'subtitle' => 'Cap nhat cac cau hoi thuong gap hien thi tren website va lam nguon noi dung cho khach hang tu tra cuu.',
    'actionHtml' => '<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Them FAQ</button>',
    'extraHead' => '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/simple-datatables@10/dist/style.min.css">',
]);
?>

<?php if ($message): ?><div class="alert alert-success"><?php echo e($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h4 class="header-title mb-0">Danh sach FAQ</h4>
            <span class="admin-muted">Keo tha cot thu tu de sap xep nhanh</span>
        </div>
        <div class="data-tables datatable-primary">
            <table id="faqTable" class="text-center admin-table">
                <thead class="text-capitalize">
                    <tr>
                        <th>Thu tu</th>
                        <th>Cau hoi</th>
                        <th>Cau tra loi</th>
                        <th>Thao tac</th>
                    </tr>
                </thead>
                <tbody id="faqSortTable">
                    <?php foreach ($faqs as $faq): ?>
                        <tr class="faq-sort-row" draggable="true" data-id="<?php echo e($faq['id']); ?>">
                            <td>
                                <button class="drag-handle" type="button" title="Keo tha de doi thu tu" aria-label="Keo tha de doi thu tu">
                                    <i class="fa-solid fa-grip-vertical"></i>
                                </button>
                                <span class="faq-order-number"><?php echo e($faq['sort_order']); ?></span>
                            </td>
                            <td><?php echo e($faq['question']); ?></td>
                            <td><?php echo e(mb_strimwidth($faq['answer'], 0, 120, '...')); ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" type="button" data-faq='<?php echo e(json_encode($faq, JSON_UNESCAPED_UNICODE)); ?>' onclick="editFaq(this)">Sua</button>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo e($faq['id']); ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xoa FAQ nay?')">Xoa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="sort-save-state mt-3" id="faqSortState" hidden>
            <strong>Dang luu thu tu...</strong>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Them FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="question" class="col-form-label">Cau hoi</label>
                        <input type="text" name="question" id="question" class="form-control" maxlength="255" required>
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="col-form-label">Cau tra loi</label>
                        <textarea name="answer" id="answer" class="form-control" rows="5" maxlength="5000" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sort_order" class="col-form-label">Thu tu</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huy</button>
                    <button type="submit" class="btn btn-success">Them</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Sua FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="editQuestion" class="col-form-label">Cau hoi</label>
                        <input type="text" name="question" id="editQuestion" class="form-control" maxlength="255" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAnswer" class="col-form-label">Cau tra loi</label>
                        <textarea name="answer" id="editAnswer" class="form-control" rows="5" maxlength="5000" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editSortOrder" class="col-form-label">Thu tu</label>
                        <input type="number" name="sort_order" id="editSortOrder" class="form-control" min="0" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huy</button>
                    <button type="submit" class="btn btn-success">Luu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$extraScripts = '
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@10/dist/umd/simple-datatables.min.js"></script>
<script>
function editFaq(button) {
    const faq = JSON.parse(button.dataset.faq);
    document.getElementById("editId").value = faq.id;
    document.getElementById("editQuestion").value = faq.question;
    document.getElementById("editAnswer").value = faq.answer;
    document.getElementById("editSortOrder").value = faq.sort_order || 0;
    new bootstrap.Modal(document.getElementById("editModal")).show();
}

document.addEventListener("DOMContentLoaded", function () {
    const faqTable = document.getElementById("faqTable");
    if (faqTable && window.simpleDatatables) {
        new simpleDatatables.DataTable(faqTable, { perPage: 10 });
    }
});

const faqSortTable = document.getElementById("faqSortTable");
const faqSortState = document.getElementById("faqSortState");
let draggedRow = null;
let saveTimer = null;

function updateFaqOrderNumbers() {
    Array.from(faqSortTable.querySelectorAll(".faq-sort-row")).forEach((row, index) => {
        row.querySelector(".faq-order-number").textContent = index + 1;
    });
}

function saveFaqOrder() {
    window.clearTimeout(saveTimer);
    saveTimer = window.setTimeout(() => {
        const orderedIds = Array.from(faqSortTable.querySelectorAll(".faq-sort-row")).map(row => row.dataset.id);
        const form = new FormData();
        form.append("action", "reorder");
        form.append("ordered_ids", JSON.stringify(orderedIds));
        faqSortState.hidden = false;

        fetch("faqs.php", {
            method: "POST",
            headers: { "X-Requested-With": "XMLHttpRequest" },
            body: form
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || "Khong luu duoc thu tu FAQ.");
                }
                faqSortState.querySelector("strong").textContent = "Da luu thu tu moi";
                window.setTimeout(() => {
                    faqSortState.hidden = true;
                    faqSortState.querySelector("strong").textContent = "Dang luu thu tu...";
                }, 900);
            })
            .catch(() => {
                faqSortState.querySelector("strong").textContent = "Luu thu tu that bai";
            });
    }, 250);
}

if (faqSortTable) {
    faqSortTable.addEventListener("dragstart", event => {
        draggedRow = event.target.closest(".faq-sort-row");
        if (!draggedRow) return;
        draggedRow.classList.add("is-dragging");
        event.dataTransfer.effectAllowed = "move";
    });

    faqSortTable.addEventListener("dragover", event => {
        event.preventDefault();
        const targetRow = event.target.closest(".faq-sort-row");
        if (!targetRow || targetRow === draggedRow) return;
        const rect = targetRow.getBoundingClientRect();
        const shouldInsertAfter = event.clientY > rect.top + rect.height / 2;
        faqSortTable.insertBefore(draggedRow, shouldInsertAfter ? targetRow.nextSibling : targetRow);
    });

    faqSortTable.addEventListener("dragend", () => {
        if (!draggedRow) return;
        draggedRow.classList.remove("is-dragging");
        draggedRow = null;
        updateFaqOrderNumbers();
        saveFaqOrder();
    });
}
</script>';

admin_layout_end($extraScripts);
?>
