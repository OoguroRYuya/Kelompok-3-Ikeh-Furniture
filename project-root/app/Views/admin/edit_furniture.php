<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Furniture - Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('css/edit_furniture.css'); ?>">
</head>
<body>
<h2>Edit Furniture</h2>

<form method="POST" enctype="multipart/form-data" action="<?= site_url('admin/updateFurniture/' . $furniture['furniture_id']) ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $furniture['name']) ?>" required>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="<?= old('price', $furniture['price']) ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?= old('description', $furniture['description']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', $furniture['stock']) ?>" required>
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" id="image" name="image">
        <?php if ($furniture['image']): ?>
            <img src="<?= base_url('images/' . $furniture['image']) ?>" alt="Furniture Image" width="100">
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Update Furniture</button>
    <a href="<?= site_url('admin/furniture') ?>" class="btn btn-secondary">Back to Furniture List</a>
</form>
</body>
</html>
