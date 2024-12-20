<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('css/manage_orders.css'); ?>">
</head>
<body>
<h2>Manage Orders</h2>
<ul>
    <?php foreach ($orders as $order): ?>
        <li>
            Order #<?= htmlspecialchars($order['order_id']) ?> - 
            <strong>Status: <?= htmlspecialchars($order['shipment_status']) ?></strong>
            <!-- Admin mengubah status shipment -->
            <form method="POST" action="<?= site_url('admin/updateShipmentStatus/' . $order['order_id']) ?>">
                <select name="status">
                    <option value="Pending" <?= $order['shipment_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Confirmed" <?= $order['shipment_status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                    <option value="Shipped" <?= $order['shipment_status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="Delivered" <?= $order['shipment_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                </select>
                <button type="submit">Update</button>
                <a href="<?= site_url('admin/order/delete/' . $order['order_id']) ?>" class="btn btn-danger">Delete</a>
            </form>
        </li>
    <?php endforeach; ?>
    <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-primary">Back to Dashboard</a>
</ul>
</body>
</html>
