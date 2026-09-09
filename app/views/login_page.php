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
    <link rel="stylesheet" href="<?= css_url('cyber_style.css') ?>" type="text/css">
</head>
<body>
    <div class="cyber-shell">
        <h1 class="cyber-title">Welcome!</h1>
        <p class="cyber-copy">Login to access products.</p>

        <?php if (isset($_SESSION['__lava_vars']['error'])): ?>
            <div class="cyber-alert cyber-alert-error"><?= htmlspecialchars($_SESSION['__lava_vars']['error']) ?></div>
        <?php endif; ?>

        <form class="cyber-form" method="post" action="<?= $login_action ?>">
            <label class="cyber-label" for="username">Username</label>
            <input class="cyber-input" type="text" id="username" name="username" value="admin" required>

            <label class="cyber-label" for="password">Password</label>
            <input class="cyber-input" type="password" id="password" name="password" value="admin123" required>

            <button class="cyber-btn" type="submit">Login</button>
        </form>

        <a class="cyber-link" href="<?= site_url('users') ?>">View Users</a>
    </div>
</body>
</html>
