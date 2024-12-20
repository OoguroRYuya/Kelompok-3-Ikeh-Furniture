<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - IKEH</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css'); ?>">
</head>
<body>
<header>
    <h1>Admin Panel</h1>
    <div id="logout">
        <a href="<?= site_url('admin/logout') ?>" class="logout-btn">Logout</a>
    </div>
</header>

<main>
    <nav id="admin-nav">
        <ul>
            <li><a href="<?= site_url('admin/users') ?>" class="menu-link">Manage Users</a></li>
            <li><a href="<?= site_url('admin/orders') ?>" class="menu-link">Manage Orders</a></li>
            <li><a href="<?= site_url('admin/furniture') ?>" class="menu-link">Manage Furniture</a></li>
        </ul>
    </nav>
</main>

</body>
</html>
