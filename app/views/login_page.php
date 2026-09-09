<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$login_action = $login_action ?? site_url('login');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome!</h1>
    <p>Login to access products.</p>

    <?php if (isset($_SESSION['__lava_vars']['error'])): ?>
        <div><?= htmlspecialchars($_SESSION['__lava_vars']['error']) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= $login_action ?>">
        <label>Username</label>
        <input type="text" name="username" value="admin" required>

        <label>Password</label>
        <input type="password" name="password" value="admin123" required>

        <button type="submit">Login</button>
    </form>

    <a href="<?= site_url('users') ?>">View Users</a>
</body>
</html>
