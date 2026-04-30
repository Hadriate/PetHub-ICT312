<?php $pageTitle = 'Order Confirmation'; require_once __DIR__ . '/includes/header.php'; ?>
<main class="section"><div class="container">
  <div class="form-card success-card" style="text-align:center;">
    <div class="success-icon">✓</div>
    <h1>Thank you for your order</h1>
    <p>Your order has been placed successfully.</p>
    <p class="muted">Order reference: #<?= (int)($_SESSION['last_order_id'] ?? 0); ?></p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:18px;">
      <?php if (is_logged_in() && !is_admin()): ?><a class="btn" href="my-orders.php">View My Orders</a><?php endif; ?>
      <a class="btn alt" href="products.php">Continue Shopping</a>
    </div>
  </div>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
