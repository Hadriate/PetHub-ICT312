<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? 'PetHub'); ?></title>
  <link rel="stylesheet" href="<?= isset($isAdmin) ? '../' : '' ?>assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container nav-wrap">
    <a class="logo" href="<?= isset($isAdmin) ? '../index.php' : 'index.php' ?>">🐾 PetHub</a>
    <nav>
      <a href="<?= isset($isAdmin) ? '../index.php' : 'index.php' ?>">Home</a>
      <a href="<?= isset($isAdmin) ? '../about.php' : 'about.php' ?>">About</a>
      <a href="<?= isset($isAdmin) ? '../products.php' : 'products.php' ?>">Products</a>
      <a href="<?= isset($isAdmin) ? '../contact.php' : 'contact.php' ?>">Contact</a>
      <?php if (is_logged_in() && !is_admin()): ?>
        <a href="<?= isset($isAdmin) ? '../my-orders.php' : 'my-orders.php' ?>">My Orders</a>
      <?php endif; ?>
      <?php if (is_admin()): ?>
        <a href="<?= isset($isAdmin) ? 'dashboard.php' : 'admin/dashboard.php' ?>">Admin</a>
      <?php endif; ?>
      <a href="<?= isset($isAdmin) ? '../cart.php' : 'cart.php' ?>">Cart (<?= cart_count(); ?>)</a>
      <?php if (is_logged_in()): ?>
        <span class="nav-status">Hi, <?= e(first_name($_SESSION['user']['name'] ?? 'User')); ?></span>
        <a class="nav-button" href="<?= isset($isAdmin) ? '../logout.php' : 'logout.php' ?>">Logout</a>
      <?php else: ?>
        <a class="nav-button" href="<?= isset($isAdmin) ? '../login.php' : 'login.php' ?>">Login</a>
        <a class="nav-button light" href="<?= isset($isAdmin) ? '../register.php' : 'register.php' ?>">Create Account</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<?php if ($flash = flash()): ?>
  <div class="container"><div class="flash"><?= e($flash); ?></div></div>
<?php endif; ?>
