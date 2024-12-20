<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('css/manage_users.css'); ?>">
</head>
<body>
<h2>Manage Users</h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)
            <a href="<?= site_url('admin/deleteUser/' . $user['id']) ?>" class="btn btn-danger">Delete</a>
        </li>
    <?php endforeach; ?>
    <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-primary">Back to Dashboard</a>
</ul>
</body>
</html>
