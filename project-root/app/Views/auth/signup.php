<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - IKEH Furniture Store</title>
    <link rel="stylesheet" href="<?= base_url('css/signup.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/common.css'); ?>">
</head>
<body class="login-page">
    <div class="login-container">
    <div class="login-box">
            <div class="login-header">
                <h2>Akun Baru IKEH</h2>
                <p class="text-muted">Isi data-data berikut untuk membuat Akun IKEH</p>
            </div>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <form action="/signup" method="POST">
                <div class="input-group">
                    <input type="text" id="name" name="name" placeholder="Nama Lengkap" required>
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="text" id="address" name="address" placeholder="Alamat Lengkap" required>
                </div>
                <div class="input-group">
                    <input type="text" id="phone" name="phone" placeholder="Nomor Telepon (+62)" required>
                </div>
                <div class="input-group">
                    <button type="submit" class="login-button">Sign Up</button>
                </div>
                <div class="input-group">
                <a href="/" class="back-button">Sudah Punya Akun</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
