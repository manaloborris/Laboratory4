<?php
$product = $product ?? [];
$mode = $mode ?? 'create';
$errors = $errors ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $mode === 'edit' ? 'Edit Product' : 'Create Product' ?></title>
    <link rel="stylesheet" href="<?= css_url('cyber_style.css') ?>">
</head>
<body>
    <div class="cyber-shell">
        <h1 class="cyber-title"><?= $mode === 'edit' ? 'Edit Product' : 'Create Product' ?></h1>

        <?php if (!empty($errors)): ?>
            <div class="cyber-alert cyber-alert-error">
                <?php foreach ($errors as $error): ?>
                    <div><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= $mode === 'edit' ? site_url('products/update/' . (int)($product['id'] ?? 0)) : site_url('products/store') ?>">
            <div class="cyber-form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" required>
            </div>

            <div class="cyber-form-group">
                <label>Description</label>
                <textarea name="description" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>

            <div class="cyber-form-group">
                <label>Price</label>
                <input type="number" min="0" step="0.01" name="price" value="<?= htmlspecialchars($product['price'] ?? '0.00') ?>" required>
            </div>

            <div class="cyber-form-group">
                <label>Quantity</label>
                <input type="number" min="0" name="quantity" value="<?= htmlspecialchars($product['quantity'] ?? '0') ?>" required>
            </div>

            <div class="cyber-toolbar">
                <button class="cyber-btn" type="submit"><?= $mode === 'edit' ? 'Update Product' : 'Save Product' ?></button>
                <a class="cyber-btn cyber-btn-secondary" href="<?= site_url('products') ?>">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
