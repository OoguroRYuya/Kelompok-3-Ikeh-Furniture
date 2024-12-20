<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Furniture - Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('css/admin.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/manage_furniture.css'); ?>">
</head>
<body>
<header>
    <h1>Manage Furniture</h1>
    <div id="logout">
        <a href="<?= site_url('admin/logout') ?>" class="logout-btn">Logout</a>
    </div>
</header>

<main>
    <section id="manage-furniture-section">
        <h2>Furniture List</h2>

        <div class="table-form-container">
    <form method="POST" action="<?= site_url('admin/addFurniture') ?>" enctype="multipart/form-data" class="add-furniture-form">
        <input type="text" name="name" placeholder="Furniture Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <input type="file" name="image" required>
        <button type="submit">Add Furniture</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($furniture as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['price']) ?></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td><?= htmlspecialchars($item['stock']) ?></td>
                        <td>
                            <?php if ($item['image']): ?>
                                <img src="<?= base_url('images/' . $item['image']) ?>" alt="Furniture Image" width="80">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= site_url('admin/furniture/edit/' . $item['furniture_id']) ?>" class="btn btn-warning">Edit</a>
                            <a href="<?= site_url('admin/furniture/delete/' . $item['furniture_id']) ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>    
            </tbody>
        </table>
    </div>
</div>


        <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-primary">Back to Dashboard</a>
    </section>
</main>

</body>
</html>
