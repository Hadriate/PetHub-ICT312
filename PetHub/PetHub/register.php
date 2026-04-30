<?php
require_once __DIR__ . '/includes/functions.php';
if (is_logged_in()) {
    redirect(is_admin() ? 'admin/dashboard.php' : 'index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (!$name || !$email || !$password) {
        flash('Please complete all account fields.');
        redirect('register.php');
    }
    if ($password !== $confirm) {
        flash('Passwords do not match.');
        redirect('register.php');
    }
    if (strlen($password) < 6) {
        flash('Password must be at least 6 characters.');
        redirect('register.php');
    }
    if (register_user($name, $email, $password)) {
        flash('Customer account created. Please log in to continue.');
        redirect('login.php');
    }
    flash('Could not register. The email may already exist.');
    redirect('register.php');
}
$pageTitle = 'Create Customer Account';
require_once __DIR__ . '/includes/header.php';
?>
<main class="auth-page">
  <div class="container auth-grid reverse">
    <form class="form-card auth-card" method="post">
      <h1>Create Customer Account</h1>
      <p class="muted">Register as a PetHub customer to use protected checkout and view your orders.</p>
      <label>Full name</label>
      <input type="text" name="name" placeholder="Keane Frederick" required>
      <label>Email address</label>
      <input type="email" name="email" placeholder="you@example.com" required>
      <label>Password</label>
      <input type="password" name="password" placeholder="At least 6 characters" required>
      <label>Confirm password</label>
      <input type="password" name="confirm_password" placeholder="Repeat password" required>
      <button class="btn full" type="submit">Create Account</button>
      <p class="muted center">Already have an account? <a class="text-link" href="login.php">Login here</a>.</p>
    </form>
    <section class="auth-copy">
      <span class="pill">Join PetHub</span>
      <h1>Shop with a secure customer profile</h1>
      <p>The PetHub system allows customers to register and log in to their own account so they can place orders and access customer-related features.</p>
      <div class="auth-points">
        <div>✓ Customer accounts for normal shoppers</div>
        <div>✓ Admin interface kept separate from customers</div>
        <div>✓ Orders linked to the logged-in customer account</div>
      </div>
    </section>
  </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
