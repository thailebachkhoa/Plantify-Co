<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Tài khoản</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/pages.css">

</head>

<body>
    <div class="auth-box">
        <h2>📝 Đăng ký Thành viên</h2>

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

        <!-- HTML5 Validation mixed with JS Validation -->
        <form action="<?= BASE_URL ?>/auth/register" method="POST" id="regForm" novalidate>
            <div class="form-group">
                <label for="fullname">👤 Họ và Tên</label>
                <input type="text" name="fullname" id="fullname" placeholder="Nhập họ và tên đầy đủ"
                    value="<?= htmlspecialchars($data['fullname'] ?? '') ?>" required>
                <small id="fullnameError" class="info-text" style="color: #dc3545; display: none;"></small>
            </div>

            <div class="form-group">
                <label for="username">👤 Tên đăng nhập</label>
                <input type="text" name="username" id="username" placeholder="Tên đăng nhập (chữ, số, _, -)"
                    value="<?= htmlspecialchars($data['username'] ?? '') ?>" required>
                <small class="info-text">Sử dụng chữ cái, số, gạch dưới (_) hoặc gạch ngang (-)</small>
                <small id="usernameError" class="info-text" style="color: #dc3545; display: none;"></small>
            </div>

            <div class="form-group">
                <label for="email">📧 Địa chỉ Email</label>
                <input type="email" name="email" id="email" placeholder="example@domain.com"
                    value="<?= htmlspecialchars($data['email'] ?? '') ?>" required>
                <small id="emailError" class="info-text" style="color: #dc3545; display: none;"></small>
            </div>

            <div class="form-group">
                <label for="password">🔑 Mật khẩu</label>
                <input type="password" name="password" id="password" placeholder="Nhập mật khẩu tối thiểu 6 ký tự" required>
                <small id="passwordError" class="info-text" style="color: #dc3545; display: none;"></small>
                <div class="password-requirements" id="passwordReqs" style="display: none;">
                    <strong>Yêu cầu mật khẩu:</strong>
                    <ul>
                        <li id="req-length"><span class="invalid">✗</span> Ít nhất 6 ký tự</li>
                        <li id="req-upper"><span class="invalid">✗</span> Ít nhất 1 chữ hoa (A-Z)</li>
                        <li id="req-lower"><span class="invalid">✗</span> Ít nhất 1 chữ thường (a-z)</li>
                        <li id="req-number"><span class="invalid">✗</span> Ít nhất 1 chữ số (0-9)</li>
                    </ul>
                </div>
            </div>

            <button type="submit" class="btn" id="submitBtn">✅ Tạo tài khoản</button>
            <button type="button" class="btn btn-back" onclick="window.location.href='<?= BASE_URL ?>/auth'">↩️ Quay lại Đăng nhập</button>
        </form>
    </div>

    <!-- JS Client Side Validation -->
    <script>
        const form = document.getElementById('regForm');
        const fullname = document.getElementById('fullname');
        const username = document.getElementById('username');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const submitBtn = document.getElementById('submitBtn');

        // Password strength checker
        password.addEventListener('input', function() {
            const val = this.value;
            const reqs = document.getElementById('passwordReqs');
            reqs.style.display = val.length > 0 ? 'block' : 'none';

            const hasLength = val.length >= 6;
            const hasUpper = /[A-Z]/.test(val);
            const hasLower = /[a-z]/.test(val);
            const hasNumber = /[0-9]/.test(val);

            updateReq('req-length', hasLength);
            updateReq('req-upper', hasUpper);
            updateReq('req-lower', hasLower);
            updateReq('req-number', hasNumber);
        });

        function updateReq(id, isValid) {
            const el = document.getElementById(id);
            if (isValid) {
                el.className = '';
                el.innerHTML = '<span class="valid">✓</span> ' + el.innerText.split(' ').slice(1).join(' ');
            } else {
                el.className = '';
                el.innerHTML = '<span class="invalid">✗</span> ' + el.innerText.split(' ').slice(1).join(' ');
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Clear errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.style.display = 'none');
            document.querySelectorAll('input').forEach(el => el.classList.remove('error-input'));

            // Validate fullname
            if (!fullname.value.trim()) {
                showError('fullname', 'Vui lòng nhập họ và tên');
                isValid = false;
            } else if (fullname.value.trim().length < 3) {
                showError('fullname', 'Họ và tên phải có ít nhất 3 ký tự');
                isValid = false;
            }

            // Validate username
            if (!username.value.trim()) {
                showError('username', 'Vui lòng nhập tên đăng nhập');
                isValid = false;
            } else if (username.value.trim().length < 3) {
                showError('username', 'Tên đăng nhập phải có ít nhất 3 ký tự');
                isValid = false;
            } else if (!/^[a-zA-Z0-9_-]+$/.test(username.value)) {
                showError('username', 'Tên đăng nhập chỉ được chứa chữ cái, số, gạch dưới và gạch ngang');
                isValid = false;
            }

            // Validate email
            if (!email.value.trim()) {
                showError('email', 'Vui lòng nhập email');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showError('email', 'Email không hợp lệ');
                isValid = false;
            }

            // Validate password
            if (!password.value) {
                showError('password', 'Vui lòng nhập mật khẩu');
                isValid = false;
            } else if (password.value.length < 6) {
                showError('password', 'Mật khẩu phải có ít nhất 6 ký tự');
                isValid = false;
            }

            if (isValid) {
                submitBtn.disabled = true;
                submitBtn.innerText = '⏳ Đang xử lý...';
                form.submit();
            }
        });

        function showError(fieldId, message) {
            const errorEl = document.getElementById(fieldId + 'Error');
            const inputEl = document.getElementById(fieldId);
            errorEl.innerText = message;
            errorEl.style.display = 'block';
            inputEl.classList.add('error-input');
        }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
    </script>
</body>

</html>