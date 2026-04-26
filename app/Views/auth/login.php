<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hệ thống BTL</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }

        .auth-box {
            max-width: 400px;
            width: 100%;
            margin: 1rem;
        }

        .auth-box h2 {
            color: #27ae60;
        }

        .auth-box input:focus {
            border-color: #27ae60;
            box-shadow: 0 0 5px rgba(39, 174, 96, 0.3);
        }

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            font-size: 12px;
            color: #6c757d;
            user-select: none;
            font-weight: normal;
        }

        #password {
            padding-right: 40px;
        }
    </style>
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

        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd; text-align: center; font-size: 12px; color: #6c757d;">
            <p>Tài khoản demo: <strong>admin</strong> / <strong>admin</strong></p>
        </div>
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