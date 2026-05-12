<?php
/**
 * File: admin/pages.php
 * Chuc nang: Quan ly noi dung website tu bang site_content va pages.
 */

require_once __DIR__ . '/includes/AdminLayout.php';

$pageTitle = 'Quan ly noi dung | GreenNest Admin';
$db = getDatabaseConnection();
$message = '';
$error = '';

function admin_page_image_upload($fieldName, &$error)
{
    if (empty($_FILES[$fieldName]) || ($_FILES[$fieldName]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return '';
    }

    $file = $_FILES[$fieldName];
    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        $error = 'Upload hinh anh that bai. Vui long chon lai file.';
        return '';
    }

    $maxBytes = 5 * 1024 * 1024;
    if ($file['size'] > $maxBytes) {
        $error = 'Hinh anh vuot qua gioi han 5MB.';
        return '';
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true)) {
        $error = 'Chi ho tro dinh dang JPG, PNG, WEBP hoac GIF.';
        return '';
    }

    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $mime = '';
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime = (string) finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
        }
    }
    if ($mime && !in_array($mime, $allowedMimes, true)) {
        $error = 'File upload khong phai hinh anh hop le.';
        return '';
    }

    $uploadDir = STORAGE_PATH . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'pages';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
        $error = 'Khong tao duoc thu muc storage/uploads/pages.';
        return '';
    }

    $fileName = 'page-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $extension;
    $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        $error = 'Khong luu duoc hinh anh len server.';
        return '';
    }

    return 'storage/uploads/pages/' . $fileName;
}

if (!$db) {
    $error = 'Chua ket noi duoc database. Hay import database/migrations/schema.sql va kiem tra config/database.php.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_content') {
        $content = $_POST['content'] ?? [];
        if (!is_array($content)) {
            $error = 'Du lieu noi dung khong hop le.';
        } else {
            $stmt = $db->prepare('UPDATE site_content SET content_value = ? WHERE content_key = ?');
            foreach ($content as $key => $value) {
                $key = (string) $key;
                $value = trim((string) $value);
                if (!preg_match('/^[a-z0-9_.-]+$/', $key) || mb_strlen($key) > 120) {
                    $error = 'Key noi dung khong hop le.';
                    break;
                }
                if (mb_strlen($value) > 5000) {
                    $error = 'Gia tri noi dung khong duoc vuot qua 5000 ky tu.';
                    break;
                }
                $stmt->execute([$value, $key]);
            }
        }
        if (!$error) {
            $message = 'Noi dung website da duoc cap nhat.';
        }
    }

    if ($action === 'save_page') {
        $slug = trim($_POST['slug'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['page_content'] ?? '');
        $image = trim($_POST['current_image'] ?? '');
        $uploadedImage = admin_page_image_upload('image_file', $error);
        if ($uploadedImage) {
            $image = $uploadedImage;
        }

        if ($error) {
            // Upload validation already filled the message.
        } elseif (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $error = 'Slug chi duoc dung chu thuong, so va dau gach ngang.';
        } elseif (mb_strlen($title) > 255) {
            $error = 'Tieu de khong duoc vuot qua 255 ky tu.';
        } elseif ($slug && $title && $content) {
            $stmt = $db->prepare('INSERT INTO pages (slug, title, content, image) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), content = VALUES(content), image = VALUES(image)');
            $stmt->execute([$slug, $title, $content, $image]);
            $message = 'Noi dung trang da duoc cap nhat.';
        } else {
            $error = 'Vui long nhap du slug, tieu de va noi dung trang.';
        }
    }
}

$contentRows = [];
$pages = [];
if ($db) {
    try {
        $defaultContent = [
            [
                'about.hero_video',
                'Trang gioi thieu',
                'Video nen dau trang gioi thieu',
                'text',
                'assets/videos/about/about-hero.m3u8',
            ],
        ];
        $defaultStmt = $db->prepare("INSERT INTO site_content (content_key, content_group, label, input_type, content_value) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE content_group = VALUES(content_group), label = VALUES(label), input_type = VALUES(input_type), content_value = IF(content_value = 'assets/videos/about/about.m3u8', VALUES(content_value), content_value)");
        foreach ($defaultContent as $defaultRow) {
            $defaultStmt->execute($defaultRow);
        }

        $contentRows = $db->query('SELECT * FROM site_content ORDER BY content_group, id')->fetchAll();
        $hiddenKeys = ['nav.' . 'home', 'nav.' . 'con' . 'tact', 'nav.cta'];
        $contentRows = array_values(array_filter($contentRows, function ($row) use ($hiddenKeys) {
            return strpos($row['content_key'], 'home.') !== 0 && !in_array($row['content_key'], $hiddenKeys, true);
        }));
        $pages = $db->query('SELECT * FROM pages ORDER BY slug')->fetchAll();
    } catch (PDOException $exception) {
            $error = 'Thieu bang noi dung. Hay import lai database/migrations/schema.sql.';
    }
}

$groupedContent = [];
$heroVideoAdmin = 'assets/videos/about/about-hero.m3u8';
foreach ($contentRows as $row) {
    $groupedContent[$row['content_group']][] = $row;
    if ($row['content_key'] === 'about.hero_video') {
        $heroVideoAdmin = $row['content_value'];
    }
}

admin_layout_start([
    'pageTitle' => $pageTitle,
    'heading' => 'Quan ly noi dung website',
    'subtitle' => 'Chinh cac doan chu, tieu de, nut bam va duong dan hinh anh dang hien thi tren website.',
    'actionHtml' => '<a class="btn btn-success" href="../zabout.php">Xem thay doi</a>',
    'extraHead' => '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/simple-datatables@10/dist/style.min.css">',
]);
?>

<?php if ($message): ?><div class="alert alert-success"><?php echo e($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>

<form method="post" class="card mb-5">
    <input type="hidden" name="action" value="save_content">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h4 class="header-title mb-0">Noi dung theo tung khu vuc</h4>
            <button type="submit" class="btn btn-success mt-3 mt-sm-0">Luu noi dung</button>
        </div>

        <?php foreach ($groupedContent as $group => $rows): ?>
            <div class="admin-form-section">
                <h5 class="mb-3"><?php echo e($group); ?></h5>
                <div class="row">
                    <?php foreach ($rows as $row): ?>
                        <div class="col-lg-6 mb-4">
                            <label class="col-form-label" for="content_<?php echo e($row['id']); ?>">
                                <?php echo e($row['label']); ?>
                                <span class="admin-muted d-block"><?php echo e($row['content_key']); ?></span>
                            </label>
                            <?php if ($row['content_key'] === 'about.hero_video'): ?>
                                <input id="content_<?php echo e($row['id']); ?>" class="form-control" type="text" name="content[<?php echo e($row['content_key']); ?>]" value="<?php echo e($row['content_value']); ?>" readonly>
                                <small class="form-text text-muted">Dung khung upload video ben duoi de cap nhat file m3u8.</small>
                            <?php elseif ($row['input_type'] === 'textarea'): ?>
                                <textarea id="content_<?php echo e($row['id']); ?>" class="form-control" name="content[<?php echo e($row['content_key']); ?>]" rows="4"><?php echo e($row['content_value']); ?></textarea>
                            <?php else: ?>
                                <input id="content_<?php echo e($row['id']); ?>" class="form-control" type="<?php echo $row['input_type'] === 'url' ? 'url' : 'text'; ?>" name="content[<?php echo e($row['content_key']); ?>]" value="<?php echo e($row['content_value']); ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</form>

<div class="card mb-5">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="header-title mb-1">Upload video trang chu</h4>
                <p class="admin-muted mb-0">Chon video, cat theo khoang giay mong muon, he thong se doi sang m3u8 va gan vao hero.</p>
            </div>
            <span class="badge bg-success mt-3 mt-sm-0">MP4 / MOV / WEBM -> M3U8</span>
        </div>
        <form id="heroVideoUploadForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <label class="video-drop-zone" for="heroVideoFile">
                        <input type="file" id="heroVideoFile" name="video" accept="video/mp4,video/quicktime,video/webm" required>
                        <span class="video-drop-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                        <strong id="heroVideoFileName">Keo tha hoac bam de chon video</strong>
                        <small>Video se duoc toi uu thanh HLS cho nen trang gioi thieu.</small>
                    </label>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="videoStartSecond" class="col-form-label">Bat dau tu giay</label>
                            <input type="number" class="form-control" id="videoStartSecond" name="start_second" min="0" step="0.1" value="0">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="videoEndSecond" class="col-form-label">Ket thuc o giay</label>
                            <input type="number" class="form-control" id="videoEndSecond" name="end_second" min="0" max="120" step="0.1" placeholder="Mac dinh 30 giay">
                        </div>
                    </div>
                    <div class="video-current-path mb-3">
                        <span>Dang dung</span>
                        <strong id="heroVideoCurrentPath"><?php echo e($heroVideoAdmin); ?></strong>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa-solid fa-wand-magic-sparkles me-2"></i>Upload va doi sang m3u8
                    </button>
                </div>
            </div>
        </form>
        <div class="video-upload-progress" id="heroVideoProgress" hidden>
            <strong>Dang xu ly video...</strong>
            <span class="d-block">He thong se cat toi da 120 giay de video nen tai nhanh va on dinh.</span>
        </div>
        <div class="video-upload-message" id="heroVideoMessage" hidden></div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="header-title">Trang noi dung dai</h4>
        <form method="post" class="mb-5" enctype="multipart/form-data">
            <input type="hidden" name="action" value="save_page">
            <input type="hidden" name="current_image" id="current_image">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="slug" class="col-form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="about" pattern="[a-z0-9-]+" maxlength="100" required>
                </div>
                <div class="col-md-9 mb-3">
                    <label for="title" class="col-form-label">Tieu de</label>
                    <input type="text" name="title" id="title" class="form-control" maxlength="255" required>
                </div>
                <div class="col-12 mb-3">
                    <label for="page_content" class="col-form-label">Noi dung</label>
                    <textarea name="page_content" id="page_content" class="form-control" rows="6" required></textarea>
                </div>
                <div class="col-lg-8 mb-3">
                    <label for="image_file" class="col-form-label">Upload hinh anh</label>
                    <input type="file" name="image_file" id="image_file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                    <small class="form-text text-muted">Anh se duoc luu vao server trong thu muc storage/uploads/pages. Gioi han 5MB.</small>
                </div>
                <div class="col-lg-4 mb-3">
                    <label class="col-form-label">Anh hien tai</label>
                    <div class="admin-image-preview">
                        <img id="pageImagePreview" src="" alt="" hidden>
                        <span id="pageImageEmpty">Chua co anh</span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Luu trang</button>
        </form>

        <div class="single-table">
            <div class="table-responsive">
                <table class="table text-center" id="pagesTable">
                    <thead class="text-uppercase bg-light">
                        <tr><th scope="col">Slug</th><th scope="col">Tieu de</th><th scope="col">Anh</th><th scope="col">Cap nhat</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                            <tr>
                                <td><?php echo e($page['slug']); ?></td>
                                <td><?php echo e($page['title']); ?></td>
                                <td><?php echo e($page['image'] ?: 'Chua co'); ?></td>
                                <td><?php echo e($page['updated_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$pagesJson = json_encode($pages, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
$extraScripts = '
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@10/dist/umd/simple-datatables.min.js"></script>
<script>
const pages = ' . $pagesJson . ';
const slugInput = document.getElementById("slug");
const pageImagePreview = document.getElementById("pageImagePreview");
const pageImageEmpty = document.getElementById("pageImageEmpty");
const currentImageInput = document.getElementById("current_image");

function fillPageForm() {
    const page = pages.find(item => item.slug === slugInput.value);
    if (!page) return;
    document.getElementById("title").value = page.title || "";
    document.getElementById("page_content").value = page.content || "";
    currentImageInput.value = page.image || "";
    if (page.image && !/^https?:\/\//i.test(page.image)) {
        pageImagePreview.src = "../" + page.image;
        pageImagePreview.hidden = false;
        pageImageEmpty.hidden = true;
    } else {
        pageImagePreview.hidden = true;
        pageImageEmpty.hidden = false;
    }
}
slugInput.addEventListener("change", fillPageForm);
fillPageForm();

const pagesTable = document.getElementById("pagesTable");
if (pagesTable && window.simpleDatatables) {
    new simpleDatatables.DataTable(pagesTable, { perPage: 10 });
}

const heroVideoUploadForm = document.getElementById("heroVideoUploadForm");
const heroVideoFile = document.getElementById("heroVideoFile");
const heroVideoFileName = document.getElementById("heroVideoFileName");
const heroVideoProgress = document.getElementById("heroVideoProgress");
const heroVideoMessage = document.getElementById("heroVideoMessage");
const heroVideoCurrentPath = document.getElementById("heroVideoCurrentPath");
const maxHeroVideoSize = 512 * 1024 * 1024;

if (heroVideoFile) {
    heroVideoFile.addEventListener("change", () => {
        heroVideoFileName.textContent = heroVideoFile.files[0] ? heroVideoFile.files[0].name : "Keo tha hoac bam de chon video";
    });
}

if (heroVideoUploadForm) {
    heroVideoUploadForm.addEventListener("submit", event => {
        event.preventDefault();
        if (heroVideoFile.files[0] && heroVideoFile.files[0].size > maxHeroVideoSize) {
            heroVideoMessage.textContent = "Video vuot qua gioi han 512MB. Hay cat ngan hon hoac nen file truoc khi upload.";
            heroVideoMessage.className = "video-upload-message is-error";
            heroVideoMessage.hidden = false;
            return;
        }
        const form = new FormData(heroVideoUploadForm);
        heroVideoProgress.hidden = false;
        heroVideoMessage.hidden = true;
        heroVideoUploadForm.classList.add("is-uploading");

        fetch("../api/upload-video.php", {
            method: "POST",
            body: form
        })
            .then(response => response.text().then(text => {
                let data = null;
                try {
                    data = JSON.parse(text);
                } catch (error) {
                    if (response.status === 413) {
                        throw new Error("Video qua lon, server dang chan upload. Gioi han hien tai la 512MB sau khi cap nhat .htaccess.");
                    }
                    throw new Error("Server tra ve HTML thay vi JSON. Hay kiem tra log Apache/PHP.");
                }
                if (!response.ok) {
                    throw new Error(data.message || "Upload video that bai.");
                }
                return data;
            }))
            .then(data => {
                if (!data.success) {
                    throw new Error(data.detail || data.message || "Khong upload duoc video.");
                }
                heroVideoCurrentPath.textContent = data.path;
                document.querySelectorAll(\'input[name="content[about.hero_video]"]\').forEach(input => {
                    input.value = data.path;
                });
                heroVideoMessage.textContent = data.message || "Da cap nhat video hero.";
                heroVideoMessage.className = "video-upload-message is-success";
            })
            .catch(error => {
                heroVideoMessage.textContent = error.message || "Upload video that bai.";
                heroVideoMessage.className = "video-upload-message is-error";
            })
            .finally(() => {
                heroVideoProgress.hidden = true;
                heroVideoMessage.hidden = false;
                heroVideoUploadForm.classList.remove("is-uploading");
            });
    });
}
</script>';

admin_layout_end($extraScripts);
?>
