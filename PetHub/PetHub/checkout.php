<?php
require_once __DIR__ . '/includes/functions.php';
require_login();
if (!cart_items()) {
    flash('Add items to your cart before checkout.');
    redirect('products.php');
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'customer_email' => trim($_POST['customer_email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
    ];
    foreach ($data as $value) {
        if ($value === '') { $errors[] = 'Please complete all checkout fields.'; break; }
    }
    if (!$errors) {
        create_order($data);
        flash('Order placed successfully. You can view it in My Orders.');
        redirect('confirmation.php');
    }
}
$pageTitle = 'Secure Checkout';
require_once __DIR__ . '/includes/header.php';
?>
<main class="section"><div class="container">
  <div class="page-heading">
    <span class="pill">Protected checkout</span>
    <h1 class="section-title">Checkout</h1>
    <p class="section-sub">You are logged in as <?= e($_SESSION['user']['name']); ?>. Your order will be saved to your customer account.</p>
  </div>
  <?php if ($errors): ?><div class="flash error"><?= e($errors[0]); ?></div><?php endif; ?>
  <div class="two-col">
    <form class="form-card checkout-card" method="post">
      <h2>Delivery details</h2>
      <div class="field-row">
        <div><label>Full Name</label><input name="customer_name" value="<?= e($_SESSION['user']['name'] ?? ''); ?>" required></div>
        <div><label>Email</label><input type="email" name="customer_email" value="<?= e($_SESSION['user']['email'] ?? ''); ?>" required></div>
      </div>
      <div class="field-row">
        <div><label>Phone</label><input name="phone" placeholder="04xxxxxxxx" required></div>
        <div><label>Delivery Address</label><input name="address" placeholder="Street, suburb, state" required></div>
      </div>
      <button class="btn" type="submit" style="margin-top:16px;">Place Order</button>
    </form>
    <div class="summary card">
      <h3>Your Order</h3>
      <?php foreach (cart_items() as $item): ?>
        <div class="line"><span><?= e($item['name']); ?> × <?= (int)$item['quantity']; ?></span><span>$<?= number_format($item['price'] * $item['quantity'],2); ?></span></div>
      <?php endforeach; ?>
      <div class="line total"><span>Total</span><span>$<?= number_format(cart_total(), 2); ?></span></div>
      <p class="muted">After placing the order, it will appear in your My Orders page.</p>
    </div>
  </div>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
