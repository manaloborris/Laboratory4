<?php
$products = $products ?? [];
$success = isset($_SESSION['__lava_vars']['success']) ? $_SESSION['__lava_vars']['success'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="<?= css_url('cyber_style.css') ?>">
</head>
<body>
    <div class="cyber-shell">
        <h1 class="cyber-title">Products</h1>

        <?php if (!empty($success)): ?>
            <div class="cyber-alert"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="cyber-toolbar">
            <a class="cyber-btn" href="<?= site_url('products/create') ?>">Add Product</a>
            <a class="cyber-btn cyber-btn-secondary" href="<?= site_url('logout') ?>">Logout</a>
        </div>

        <table class="cyber-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= (int)$product['id'] ?></td>
                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                            <td><?= number_format((float)$product['price'], 2) ?></td>
                            <td><?= (int)$product['quantity'] ?></td>
                            <td><?= htmlspecialchars($product['created_at']) ?></td>
                            <td>
                                <a class="cyber-btn cyber-btn-small" href="<?= site_url('products/edit/' . (int)$product['id']) ?>">Edit</a>
                                <a class="cyber-btn cyber-btn-danger cyber-btn-small" href="<?= site_url('products/delete/' . (int)$product['id']) ?>" onclick="return confirm('Delete this product?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
