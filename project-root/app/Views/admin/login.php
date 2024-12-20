<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - IKEH Furniture Store</title>
    <link rel="stylesheet" href="<?= base_url('css/common.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/login.css'); ?>">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>Selamat datang di Admin IKEH!</h2>
                <p class="text-muted">Login untuk Mengelola Layanan</p>
            </div>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <form action="/admin/login" method="POST">
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email Admin" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password Admin" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i id="password-icon">Lihat</i>
                    </span>
                </div>
                <div class="input-group">
                    <button type="submit" class="login-button">Login</button>
                </div>
                <?php if (isset($error)): ?>
                    <div class="error-message"><?= $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Popup untuk pesan error -->
    <div id="error-popup" class="error-popup" style="display: none;">
        <span id="error-message"></span>
        <button onclick="closePopup()">Close</button>
    </div>

    <script>
        function closePopup() {
            document.getElementById("error-popup").style.display = "none";
        }

        function showError(message) {
            document.getElementById("error-message").textContent = message;
            document.getElementById("error-popup").style.display = "block";
        }

        const urlParams = new URLSearchParams(window.location.search);
        const errorType = urlParams.get('error');

        if (errorType === 'email') {
            showError("Email tidak terdaftar!");
        } else if (errorType === 'password') {
            showError("Password salah!");
        }

        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const passwordIcon = document.getElementById("password-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.textContent = "Tutup";
            } else {
                passwordInput.type = "password";
                passwordIcon.textContent = "Lihat";
            }
        }
    </script>

    <style>
        .error-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f44336;
            color: white;
            padding: 20px;
            border-radius: 10px;
            z-index: 1000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }

        .error-popup button {
            background-color: #fff;
            color: #f44336;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</body>
</html>
