<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/common.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/reset_password.css'); ?>">
    <title>Reset Password</title>
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>Reset Password</h2>
                <p class="text-muted">Masukkan Password baru</p>
            </div>

            <form action="/reset_password" method="POST">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i id="password-icon">Lihat</i>
                    </span>
                </div>
                <button type="submit" class="login-button">Konfirmasi</button>
            </form>
        </div>
    </div>

    <script>
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
</body>
</html>
