<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Plantify Co</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">

</head>

<body>
    <div class="auth-box">
        <h2>🔐 Đăng nhập Hệ thống</h2>

        <?php if (isset($error)): ?>
            <div class="error">
                <strong>❌ Lỗi:</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success">
                <strong>✅ Thành công:</strong> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/auth/login" method="POST" id="loginForm" novalidate>
            <div class="form-group">
                <label for="username">📧 Tên tài khoản hoặc Email</label>
                <input type="text" name="username" id="username" placeholder="Nhập tên đăng nhập hoặc email"
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                <small id="usernameError" style="color: #dc3545; display: none;"></small>
            </div>
            <div class="form-group">
                <label for="password">🔑 Mật khẩu</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required>
                    <span class="toggle-password" onclick="showpass()" id="toggleText">Hiện</span>
                </div>
                <small id="passwordError" style="color: #dc3545; display: none;"></small>
            </div>
            <button type="submit" class="btn btn-success" style="background: #27ae60;">🚀 Đăng nhập</button>
            <button type="button" class="btn btn-secondary" style="background: #6c757d;" onclick="window.location.href='<?= BASE_URL ?>/auth/register'">📝 Đăng ký tài khoản mới</button>
        </form>

        
    </div>

    <!-- javascript check validation (client-side) -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let u = document.getElementById('username').value.trim();
            let p = document.getElementById('password').value.trim();
            let isValid = true;

            // Clear previous errors
            document.getElementById('usernameError').style.display = 'none';
            document.getElementById('passwordError').style.display = 'none';

            if (!u) {
                document.getElementById('usernameError').innerText = 'Vui lòng nhập tên tài khoản hoặc email';
                document.getElementById('usernameError').style.display = 'block';
                isValid = false;
            }

            if (!p) {
                document.getElementById('passwordError').innerText = 'Vui lòng nhập mật khẩu';
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            } else if (p.length < 3) {
                document.getElementById('passwordError').innerText = 'Mật khẩu phải có ít nhất 3 ký tự';
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        function showpass() {
            var x = document.getElementById("password");
            var t = document.getElementById("toggleText");
            if (x.type === "password") {
                x.type = "text";
                t.innerText = "Ẩn";
            } else {
                x.type = "password";
                t.innerText = "Hiện";
            }
        }
    </script>
</body>

</html>
