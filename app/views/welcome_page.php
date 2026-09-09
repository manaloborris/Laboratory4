<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
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
        <p class="cyber-copy">Click the button below to view the user records.</p>
        <a class="cyber-btn" href="<?= site_url('users') ?>" data-link>View Users</a>
    </div>
</body>
</html>