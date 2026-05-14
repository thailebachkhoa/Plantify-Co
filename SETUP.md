# 🚀 Hướng Dẫn Cài Đặt & Sử Dụng - BTL Cây Cảnh

## 📋 Yêu Cầu Hệ Thống

- **PHP:** 7.4 trở lên
- **MySQL:** 5.7 trở lên
- **Web Server:** Apache (với mod_rewrite) hoặc Nginx

---

## 💾 Cài Đặt Database

### 1️⃣ Tạo Database

```bash
# Mở MySQL
mysql -u root -p

# Chạy file schema
source database/migrations/schema.sql;
```

### 2️⃣ Hoặc Dùng phpMyAdmin

1. Mở phpMyAdmin
2. Tạo database mới: `plantify`
3. Import file `database/migrations/schema.sql`

---

## 🔧 Cấu Hình Ứng Dụng

### 1️⃣ Copy `.env.example` → `.env`

```bash
cp .env.example .env
```

### 2️⃣ Chỉnh Sửa `.env`

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plantify
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3️⃣ Tạo thư mục logs (nếu chưa tồn tại)

```bash
mkdir -p storage/logs
mkdir -p storage/uploads
mkdir -p storage/cache
chmod -R 777 storage/
```

---

## 🌐 URL Rewrite Setup

### Apache (`public/.htaccess`)

File `.htaccess` đã tồn tại. Nếu chưa có, tạo file:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /btl/public/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?url=$1 [L]
</IfModule>
```

### Nginx

```nginx
location / {
    try_files $uri $uri/ /index.php?url=$uri&$args;
}
```

---

## 🚀 Chạy Ứng Dụng

### Tùy Chọn 1: Dùng PHP Built-in Server

```bash
cd public
php -S localhost:8000
```

### Tùy Chọn 2: XAMPP/WAMP

1. Copy project vào `htdocs/` (XAMPP) hoặc `www/` (WAMP)
2. Truy cập: `http://localhost/btl/public/`

### Tùy Chọn 3: Docker (nếu có)

```bash
docker-compose up -d
```

---

## 👥 Tài Khoản Mặc Định

### Admin

```
Tên đăng nhập: admin
Mật khẩu:     admin
Email:        admin@localhost.com
```

### Member

```
Tên đăng nhập: thanhvien
Mật khẩu:     admin
Email:        member@localhost.com
```

---

## 📂 Cấu Trúc Thư Mục

```
btl/
├── app/
│   ├── Controllers/          # Các controller
│   │   ├── AuthController.php
│   │   ├── GuestController.php
│   │   ├── DashboardController.php
│   │   └── AdminController.php
│   ├── Core/                 # Core classes
│   │   ├── BaseController.php
│   │   ├── Database.php
│   │   ├── Auth.php         # Auth middleware
│   │   └── Env.php
│   ├── Models/              # Models
│   │   └── User.php
│   └── Views/               # Templates
│       ├── auth/
│       ├── guest/
│       ├── dashboard/
│       └── ...
├── database/
│   └── migrations/
│       └── schema.sql       # Database schema
├── public/                  # Public folder
│   ├── index.php           # Entry point
│   ├── .htaccess
│   └── assets/
│       ├── css/
│       ├── js/
│       └── images/
├── storage/
│   ├── logs/
│   ├── uploads/
│   └── cache/
├── vendor/                  # Composer packages
├── config/                  # Configuration files
├── .env.example            # Environment example
├── .env                    # Environment config
├── composer.json           # PHP dependencies
├── README.md              # Project README
└── AUTHENTICATION.md      # Auth documentation
```

---

## 🔐 Bảo Mật Cơ Bản

### ✅ Kiểm Tra Danh Sách

- [x] Password hashing (PASSWORD_DEFAULT)
- [x] SQL injection protection (PDO prepared statements)
- [x] XSS protection (htmlspecialchars)
- [x] Session management
- [x] Input validation
- [x] CSRF protection (có thể thêm)

### ⚠️ Khuyến Nghị Bổ Sung

```php
// 1. Thêm CSRF Token vào form
<input type="hidden" name="csrf_token" value="<?= generateToken() ?>">

// 2. Thêm rate limiting cho login
// 3. Thêm email verification
// 4. Thêm 2FA (Two-factor authentication)
// 5. Dùng HTTPS cho production
```

---

## 🧪 Testing Tính Năng

### 1️⃣ Test Đăng Ký

1. Truy cập: `http://localhost:8000/auth/register`
2. Nhập:
   - Họ tên: `Nguyễn Văn A`
   - Username: `nguyenvana`
   - Email: `nguyenvana@test.com`
   - Password: `abc123ABC`
3. Nhấn Đăng Ký
4. Nên nhận thông báo thành công

### 2️⃣ Test Đăng Nhập

1. Truy cập: `http://localhost:8000/auth`
2. Thử với tài khoản demo admin
3. Nên redirect đến `/admin`
4. Thử với tài khoản demo member
5. Nên redirect đến `/dashboard`

### 3️⃣ Test Guest Access

1. Truy cập: `http://localhost:8000/guest`
2. Nên thấy trang chủ với navigation
3. Thử các link: Shop, Cart, About, Contact
4. Logout từ `/auth/logout`

### 4️⃣ Test Admin Quản Lý

1. Đăng nhập bằng admin
2. Truy cập `/admin`
3. Thử:
   - Khoá/Mở tài khoản
   - Reset mật khẩu
   - Xóa user

---

## 📝 Log & Debugging

### Xem Logs

```bash
tail -f storage/logs/*.log
```

### Enable Debug Mode

Thêm vào `index.php`:

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Check Database Connection

```bash
mysql -u root -p btlweb
SELECT * FROM users;
```

---

## 🐛 Troubleshooting

### ❌ "Database Connection Error"

```
→ Kiểm tra `.env` file
→ Kiểm tra MySQL đã chạy?
→ Kiểm tra credentials
```

### ❌ "Class not found"

```
→ Kiểm tra autoloader trong `public/index.php`
→ Kiểm tra tên file & class khớp nhau
```

### ❌ "404 Not Found"

```
→ Kiểm tra `.htaccess` (Apache)
→ Kiểm tra URL rewrite rules (Nginx)
→ Kiểm tra RewriteBase trong .htaccess
```

### ❌ "Session không hoạt động"

```
→ Kiểm tra `session_start()` được gọi
→ Kiểm tra storage permissions
```

---

## 📊 Các Tính Năng Chính

### ✅ Đã Hoàn Thành

- [x] Hệ thống đăng nhập/đăng ký
- [x] Validation form (Client & Server)
- [x] Password hashing bảo mật
- [x] Role-based access control
- [x] Middleware xác thực
- [x] Trang chủ công khai
- [x] Dashboard thành viên
- [x] Admin quản lý người dùng
- [x] Trang sản phẩm (stub)
- [x] Giỏ hàng (stub)
- [x] Thanh toán (stub)
- [x] Trang về chúng tôi
- [x] Trang liên hệ

### 📋 Có Thể Thêm

- [ ] Shopping cart functionality
- [ ] Payment gateway integration
- [ ] Product management (Admin)
- [ ] Order management
- [ ] User profile update
- [ ] Avatar upload
- [ ] Email notifications
- [ ] Search & filters
- [ ] Reviews & ratings
- [ ] API endpoints

---

## 🔗 Useful Links

| Chức Năng    | URL               |
| ------------ | ----------------- |
| Trang Chủ    | `/` hoặc `/guest` |
| Đăng Ký      | `/auth/register`  |
| Đăng Nhập    | `/auth`           |
| Dashboard    | `/dashboard`      |
| Admin        | `/admin`          |
| Cửa Hàng     | `/guest/shop`     |
| Giỏ Hàng     | `/guest/cart`     |
| Thanh Toán   | `/guest/checkout` |
| Về Chúng Tôi | `/guest/about`    |
| Liên Hệ      | `/guest/contact`  |

---

## 💡 Tips & Tricks

### 1. Auth Helper Shortcuts

```php
// Trong views
<?php if (Auth::check()): ?>
    <p>Xin chào <?= Auth::user()['fullname'] ?></p>
<?php endif; ?>

// Trong controllers
if (!Auth::isAdmin()) {
    $this->redirect('dashboard');
}
```

### 2. Redirect Shortcuts

```php
// Các cách redirect khác nhau
$this->redirect('auth');                    // /auth
$this->redirect('dashboard');               // /dashboard
$this->redirect('guest/shop');              // /guest/shop
$this->redirect('admin/users');             // /admin/users
```

### 3. View Data Passing

```php
$this->view('page-name', [
    'user' => $user,
    'products' => $products,
    'error' => 'Some error message'
]);
```

---

## 📞 Hỗ Trợ

Nếu gặp vấn đề:

1. Đọc tài liệu: `AUTHENTICATION.md`
2. Kiểm tra logs: `storage/logs/`
3. Chạy test: Xem phần "Testing Tính Năng"
4. Debug: Enable display_errors

---

**Last Updated:** 2026-04-25 | **Version:** 1.0 | **By:** BTL Cây Cảnh
