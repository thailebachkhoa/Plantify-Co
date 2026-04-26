## 📁 Cấu trúc thư mục

```text
btl/
│
├── app/                  # Application Layer
│   ├── Controllers/      # Các lớp điều khiển (AuthController, DashboardController...)
│   ├── Models/           # Tương tác Database, xử lý nghiệp vụ (User.php...)
│   ├── Views/            # Chứa giao diện HTML/PHP
│   └── Core/             # Các lớp nền tảng (BaseController, Database, Env)
│
├── config/               # Chứa các file cấu hình hệ thống
│
├── database/             # Nơi chứa các file cấu trúc bảng SQL
│   └── migrations/
│       └── schema.sql    # Lược đồ bảng users, products, news,...
│
├── public/               # Thư mục duy nhất public ra Internet
│   ├── assets/           # CSS, JS, Images, Fonts
│   ├── .htaccess         # Điều hướng request trỏ về index.php
│   └── index.php         # Front Controller - Điểm vào duy nhất
│
├── storage/              # Lưu trữ các file sinh ra lúc runtime (logs, cache, uploads)
│
├── .env                  # Tệp lưu thông tin kết nối DB thực tế (Sẽ không đưa lên Git)
├── .env.example          # Tệp mẫu
├── console.php           # Script command line hỗ trợ tạo CSDL tự động
└── composer.json         # Danh sách packages PHP dự án yêu cầu
```

## 🛠️ Yêu cầu môi trường

- **XAMPP Control Panel** (Bao gồm Apache và MySQL)
- **PHP:** >= 8.0

---

## 🚦 Hướng dẫn cài đặt và khởi chạy (Với XAMPP)

### Bước 1: Chuẩn bị môi trường & XAMPP
1. Khởi động **XAMPP Control Panel**.
2. Nhấn nút **Start** đối với 2 dịch vụ là **Apache** và **MySQL**.
3. Di chuyển toàn bộ code thư mục `btl/` vào trong htdocs của XAMPP, hoặc sử dụng **Virtual Host** trỏ DocumentRoot thẳng vào `btl/public`.

### Bước 2: Cấu hình biến môi trường Database
Copy file `.env.example` và đổi tên thành `.env` (hoặc mở `.env` trực tiếp nếu đã có).
Sau đó, đảm bảo thông tin kết nối khớp với MySQL của XAMPP:
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=btlweb
DB_USERNAME=root
DB_PASSWORD=
```
*(Nếu cài đặt XAMPP mặc định, username luôn là root và password để trống).*

### Bước 3: Tự động khởi tạo Cơ Sở Dữ Liệu
Bạn không cần phải import file SQL bằng tay vào phpMyAdmin. Dự án đã cung cấp sẵn công cụ thao tác tự động!

Mở **Terminal** (Trong VS Code) hoặc mở **Shell** (nằm ở cạnh bên phải của XAMPP window), trỏ đường dẫn vào thư mục gốc `btl/` và chạy lệnh sau:
```bash
php console.php migrate
```
Lệnh này sẽ tự động:
- Tạo Database tên là `btlweb`.
- Tạo toàn bộ các bảng: `users`, `products`, `news`, `comments`,...
- Cấp sẵn 2 tài khoản mẫu đã được mã hoá mật khẩu:
   - **Tài khoản Admin:** `admin` / pass: 123456
   - **Tài khoản Thành viên:** `thanhvien` / pass: 123456

### Bước 4: Trải nghiệm ứng dụng
Truy cập vào tên miền ảo (vd: `http://btl.local`) hoặc ứng với cấu trúc folder localhost của bạn (vd: `http://localhost/BTLWEB/btl/public`).

Hệ thống sẽ chạy và bạn có thể thử đăng nhập hoặc tạo tài khoản mới. Trình duyệt đã được tích hợp Validate bằng cả Frontend (JS) và Backend (PHP).

## 🔄 Git Workflow

### Commit Message Convention

The project uses [Conventional Commits](https://www.conventionalcommits.org/):

```bash
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

**Types:**

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation update
- `style`: Formatting changes that don't affect code logic
- `refactor`: Code refactoring
- `perf`: Performance improvement
- `test`: Adding or fixing tests
- `chore`: Build tasks, package manager configs, etc.

**Examples:**

```bash
git commit -m "feat(auth): add user login functionality"
git commit -m "fix(api): resolve user data fetching issue"
git commit -m "docs: update installation guide"
git commit -m "style(client): format code with prettier"
```
### Standard Workflow

1. **Create a new branch**
   Always branch off from the latest version of `main`.

   ```bash
   git checkout main
   git pull origin main
   git checkout -b feature/your-feature-name
   ```

2. **Work on your feature**
   Make your code changes and commit them using the [Conventional Commits](https://www.conventionalcommits.org/) format:

   ```bash
   git add .
   git commit -m "feat(auth): add login functionality"
   ```

3. **Rebase with the latest main branch**
   Before pushing, make sure your branch is up to date with `main`:

   ```bash
   git fetch origin
   git rebase origin/main
   ```

4. **Push your branch to remote**

   ```bash
   git push origin feature/your-feature-name
   ```

5. **Create a Pull Request (PR)**
   Open a PR to merge your branch into `main`.
   Wait for review and approval before merging.

6. **After Merge — Sync and Clean Up**
   Once your PR is merged:

   ```bash
   git checkout main
   git pull origin main
   ```
