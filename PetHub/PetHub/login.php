<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) {
    redirect(is_admin() ? 'admin/dashboard.php' : 'index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (attempt_login(trim($_POST['email'] ?? ''), $_POST['password'] ?? '')) {
        flash('Welcome back. You are now logged in.');
        redirect(is_admin() ? 'admin/dashboard.php' : 'index.php');
    }
    flash('Invalid email or password. Please try again.');
    redirect('login.php');
}
$pageTitle = 'Customer Login';
require_once __DIR__ . '/includes/header.php';
?>
<main class="auth-page">
  <div class="container auth-grid">
    <section class="auth-copy">
      <span class="pill">Customer account</span>
      <h1>Welcome back to PetHub</h1>
      <p>Log in to place orders, track your purchases, and access your PetHub customer features. Administrators can also use this login to access the admin dashboard.</p>
      <div class="auth-points">
        <div>✓ Protected checkout for registered customers</div>
        <div>✓ Order history through My Orders</div>
        <div>✓ Separate admin access for product and order management</div>
      </div>
    </section>
    <form class="form-card auth-card" method="post">
      <h1>Login</h1>
      <p class="muted">Enter your account details below.</p>
      <label>Email address</label>
      <input type="email" name="email" placeholder="you@example.com" required>
      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>
      <button class="btn full" type="submit">Login</button>
      <p class="muted center">No customer account yet? <a class="text-link" href="register.php">Create one here</a>.</p>
      <div class="demo-box">
        <strong>Demo accounts</strong><br>
        Customer: keane@example.com / password123<br>
        Admin: admin@pethub.local / admin123
      </div>
    </form>
  </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
