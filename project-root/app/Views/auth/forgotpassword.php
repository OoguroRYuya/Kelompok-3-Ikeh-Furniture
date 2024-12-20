<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('css/common.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/reset_password.css'); ?>">
    <title>Check Email</title>
</head>

<body class="login-page">
    <div class="login-container">
    <div class="login-box">
            <div class="login-header">
                <h2>Cek Email</h2>
                <p class="text-muted">Masukkan Email untuk mereset Password</p>
            </div>
            <form action="forgotpassword" method="POST">
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <button type="submit" class="login-button">Check Email</button>
            </form>
        </div>
    </div>
</body>
</html>
