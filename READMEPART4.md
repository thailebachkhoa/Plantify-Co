# 📰 READMEPART4.md — Hệ thống Tin tức & Bình luận

> **Dự án:** Plantify Co — Website Cây Cảnh  
> **Thành viên thực hiện:** Phần #4 — News/Blog System with Comments  
> **Công nghệ:** PHP 8.2 thuần · SQLite (PDO) · Bootstrap 5 · Font Awesome 6 · Custom CSS

---

## 1. Tổng quan Phần #4

Phần #4 xây dựng hoàn chỉnh hệ thống **Tin tức / Blog** cho website cây cảnh, gồm:

| Module | Mô tả |
|--------|-------|
| Frontend — Danh sách bài viết | Hiển thị lưới bài viết, tìm kiếm, phân trang |
| Frontend — Chi tiết bài viết | Nội dung đầy đủ, ảnh, tags, bài liên quan, bình luận |
| Admin — Quản lý Tin tức | CRUD hoàn chỉnh, upload ảnh, filter theo trạng thái |
| Admin — Quản lý Bình luận | Duyệt/ẩn/xóa bình luận, tìm kiếm |

---

## 2. Danh sách File Đã Tạo / Chỉnh sửa

### ✅ File mới (New)

```
database/
  (migration chạy qua PHP inline — ALTER TABLE thêm cột mới)

app/
  Models/
    News.php                          — Model đầy đủ cho bảng news
    Comment.php                       — Model đầy đủ cho bảng comments

  Controllers/
    NewsController.php                — Frontend: danh sách, chi tiết, gửi comment

  Views/
    news/
      index.php                       — Trang danh sách bài viết (user)
      detail.php                      — Trang chi tiết bài viết + bình luận (user)
    admin/
      layout/
        header.php                    — Layout header dùng chung cho tất cả trang admin
        footer.php                    — Layout footer dùng chung
      news-list.php                   — Admin: danh sách bài viết
      news-form.php                   — Admin: form tạo/sửa bài viết
      comment-list.php                — Admin: danh sách bình luận

public/
  assets/css/
    news.css                          — CSS riêng cho News module
  uploads/
    news/                             — Thư mục lưu ảnh upload (chmod 777)

READMEPART4.md                        — File này
```

### ✏️ File chỉnh sửa (Modified)

```
app/Controllers/AdminController.php   — Thêm: news(), news_create(), news_edit(),
                                         news_delete(), comments(), comment_toggle(),
                                         comment_delete(), processNewsForm()

app/Views/dashboard/admin.php         — Cập nhật sidebar: thêm link Tin tức & Bình luận
```

---

## 3. Chức năng Từng File

### `app/Models/News.php`
| Phương thức | Mô tả |
|-------------|-------|
| `generateSlug($title, $suffix)` | Tạo slug từ tiêu đề tiếng Việt (loại bỏ dấu) |
| `getPublished($page, $search)` | Frontend: lấy bài viết đã đăng, có phân trang + tìm kiếm |
| `countPublished($search)` | Đếm bài viết published (cho pagination) |
| `getBySlug($slug)` | Lấy 1 bài viết theo slug (frontend detail) |
| `getRelated($newsId, $tags, $limit)` | Lấy bài viết liên quan theo tags |
| `getAll($page, $search, $status)` | Admin: lấy tất cả bài viết |
| `countAll($search, $status)` | Admin: đếm bài viết |
| `getById($id)` | Lấy 1 bài viết theo ID |
| `create($data)` | Tạo bài viết mới, trả về ID mới |
| `updateSlug($id, $slug)` | Cập nhật slug sau khi tạo (gắn ID) |
| `update($id, $data)` | Cập nhật bài viết |
| `delete($id)` | Xóa bài viết |

### `app/Models/Comment.php`
| Phương thức | Mô tả |
|-------------|-------|
| `getByNewsId($newsId)` | Lấy comment đã duyệt cho 1 bài viết |
| `countByNewsId($newsId)` | Đếm comment đã duyệt |
| `create($data)` | Gửi comment mới (status = pending) |
| `getAll($page, $search)` | Admin: lấy tất cả comment |
| `countAll($search)` | Admin: đếm comment |
| `toggleStatus($id)` | Chuyển đổi approved ↔ hidden |
| `delete($id)` | Xóa comment |

### `app/Controllers/NewsController.php`
| Method | Route | Mô tả |
|--------|-------|-------|
| `index()` | `GET /news` | Danh sách bài viết, tìm kiếm, phân trang |
| `detail($slug)` | `GET /news/detail/{slug}` | Chi tiết bài viết + danh sách comment |
| `comment_post()` | `POST /news/comment_post` | Gửi bình luận (yêu cầu đăng nhập) |

### `app/Controllers/AdminController.php` (bổ sung)
| Method | Route | Mô tả |
|--------|-------|-------|
| `news()` | `GET /admin/news` | Danh sách bài viết (admin) |
| `news_create()` | `GET/POST /admin/news_create` | Thêm bài viết mới |
| `news_edit($id)` | `GET/POST /admin/news_edit/{id}` | Sửa bài viết |
| `news_delete($id)` | `GET /admin/news_delete/{id}` | Xóa bài viết |
| `comments()` | `GET /admin/comments` | Danh sách bình luận |
| `comment_toggle($id)` | `GET /admin/comment_toggle/{id}` | Duyệt/ẩn bình luận |
| `comment_delete($id)` | `GET /admin/comment_delete/{id}` | Xóa bình luận |

---

## 4. Luồng Hoạt Động

### Luồng đăng bài (Admin)
```
Admin → /admin/news_create (GET) → Điền form
  → POST /admin/news_create
    → validate server-side
    → upload ảnh → public/uploads/news/
    → INSERT vào DB
    → UPDATE slug với ID
    → redirect /admin/news + flash success
```

### Luồng đọc bài viết (User)
```
User → /news → danh sách bài (getPublished)
  → click bài → /news/detail/{slug}
    → getBySlug → hiển thị nội dung
    → getRelated → sidebar bài liên quan
    → getByNewsId (approved only) → danh sách comment
```

### Luồng bình luận
```
User đăng nhập → POST /news/comment_post
  → validate JS (client-side)
  → validate PHP (server-side)
  → INSERT comment (status = 'pending')
  → redirect + flash "đang chờ duyệt"

Admin → /admin/comments
  → click ✅ Duyệt → /admin/comment_toggle/{id}
    → UPDATE status = 'approved'
    → comment hiển thị ngoài website
```

---

## 5. Database Sử Dụng

### Bảng `news` (mở rộng từ schema gốc)

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | INTEGER PK AUTO | Khóa chính |
| title | VARCHAR(255) | Tiêu đề bài viết |
| **slug** | VARCHAR(255) | URL-friendly, unique |
| **short_description** | TEXT | Mô tả ngắn (hiển thị trên listing) |
| content | TEXT | Nội dung HTML đầy đủ |
| **thumbnail** | VARCHAR(255) | Đường dẫn ảnh (relative, public/) |
| tags | VARCHAR(255) | Tags phân cách bằng dấu phẩy |
| seo_desc | VARCHAR(255) | Meta description SEO |
| **author** | VARCHAR(100) | Tên tác giả |
| **status** | TEXT | `published` / `draft` / `hidden` |
| created_at | TIMESTAMP | Ngày tạo |
| **updated_at** | TIMESTAMP | Ngày cập nhật |

> **In đậm** = cột mới thêm bởi Part #4

### Bảng `comments` (mở rộng từ schema gốc)

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| id | INTEGER PK AUTO | Khóa chính |
| user_id | INT FK → users.id | Người bình luận |
| target_id | INT | ID bài viết |
| target_type | TEXT | `news` |
| content | TEXT | Nội dung bình luận |
| **status** | TEXT | `pending` / `approved` / `hidden` |
| created_at | TIMESTAMP | Ngày gửi |
| **updated_at** | TIMESTAMP | Ngày cập nhật |

> **In đậm** = cột mới thêm bởi Part #4

---

## 6. Hướng Dẫn Chạy

```bash
# 1. Start server
php -S 0.0.0.0:5000 -t public/

# 2. Chạy migration (nếu cần reset DB)
php console.php migrate

# 3. Truy cập
# Frontend news: http://localhost:5000/?url=news
# Admin news:    http://localhost:5000/?url=admin/news
# Admin comment: http://localhost:5000/?url=admin/comments
```

---

## 7. Tài Khoản Test

| Username | Mật khẩu | Role | Ghi chú |
|----------|----------|------|---------|
| `admin` | `123456` | Admin | Truy cập admin panel đầy đủ |
| `thanhvien` | `123456` | Member | Có thể đọc bài và gửi bình luận |

---

## 8. Các Tính Năng Đã Hoàn Thành

### Frontend (User)
- [x] Trang danh sách bài viết — grid responsive, thumbnail, meta
- [x] Tìm kiếm bài viết theo tiêu đề và tags
- [x] Phân trang có smart truncation (hiển thị …)
- [x] Trang chi tiết bài viết — nội dung HTML, ảnh, tags
- [x] Sidebar bài viết liên quan (theo tags)
- [x] Hiển thị bình luận đã được duyệt
- [x] Form gửi bình luận (chỉ user đăng nhập)
- [x] Giao diện responsive — mobile/tablet/desktop

### Admin Dashboard
- [x] Danh sách bài viết với tìm kiếm và filter trạng thái
- [x] Thêm bài viết mới với upload ảnh
- [x] Sửa bài viết (giữ ảnh cũ nếu không upload mới)
- [x] Xóa bài viết (kèm xóa file ảnh khỏi server)
- [x] Auto-generate slug từ tiêu đề tiếng Việt
- [x] Preview ảnh khi chọn file upload
- [x] Danh sách bình luận với tìm kiếm
- [x] Duyệt / ẩn bình luận (toggle)
- [x] Xóa bình luận
- [x] Sidebar admin đã cập nhật với link News & Comments

---

## 9. Các Validate Đã Thực Hiện

### Client-side (JavaScript)
| Form | Validate |
|------|----------|
| Comment form | Không rỗng, ≥5 ký tự, ≤1000 ký tự, counter realtime |
| News form (admin) | Tiêu đề ≥5 ký tự, nội dung không rỗng |
| Image upload (admin) | MIME type, kích thước ≤2MB, preview ngay lập tức |
| Slug auto-gen | Từ tiêu đề, loại ký tự không hợp lệ |

### Server-side (PHP)
| Kiểm tra | Xử lý |
|----------|-------|
| SQL Injection | Prepared Statements (PDO bind) cho mọi query |
| XSS — comment | `htmlspecialchars` + `strip_tags` trước khi lưu |
| XSS — news fields | `htmlspecialchars(ENT_QUOTES)` cho text fields |
| File upload type | Kiểm tra extension + MIME type |
| File upload size | Giới hạn 2MB |
| Upload error code | Kiểm tra `$_FILES['...']['error'] === UPLOAD_ERR_OK` |
| Empty fields | Validate title, short_description, content |
| Integer overflow | `(int)` cast cho mọi ID param |
| Auth guard | Admin: kiểm tra role + status trong `__construct()` |
| Comment auth | Redirect + flash error nếu chưa đăng nhập |

---

## 10. Điểm Nổi Bật Kỹ Thuật

1. **Slug tiếng Việt:** `News::generateSlug()` chuyển đổi toàn bộ bảng ký tự Unicode tiếng Việt (150+ ký tự) sang ASCII, đảm bảo URL đẹp và SEO-friendly.

2. **Shared Admin Layout:** `app/Views/admin/layout/header.php` và `footer.php` tái sử dụng header/sidebar Bootstrap 5 trên tất cả trang admin — không trùng lặp code, sidebar tự highlight trang hiện tại qua biến `$activePage`.

3. **Comment Moderation:** Bình luận mới luôn có `status = 'pending'` — không bao giờ hiển thị tự động trên frontend. Admin phải duyệt để chuyển sang `approved`.

4. **Image Upload Safety:** Upload ảnh kiểm tra cả `file['type']` (MIME) lẫn `PATHINFO_EXTENSION`, đặt tên file ngẫu nhiên (`news_timestamp_hex.ext`) để tránh path traversal và ghi đè.

5. **Pagination Smart Truncation:** Pagination frontend hiển thị dấu `…` khi nhiều trang, luôn giữ trang đầu/cuối và ±2 trang quanh trang hiện tại.

6. **Flash Messages qua Session:** `$_SESSION['admin_success/error']` được set trước redirect và đọc+xóa ngay sau — tránh lặp lại khi F5.

7. **Zero framework dependency:** Toàn bộ Part #4 viết bằng PHP thuần, không dùng Composer, không có dependency ngoài — chạy được ngay với `php -S`.
