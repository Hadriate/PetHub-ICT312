<?php
require_once __DIR__ . '/includes/functions.php';
require_login();
if (is_admin()) {
    redirect('admin/dashboard.php');
}
$pageTitle = 'My Orders';
require_once __DIR__ . '/includes/header.php';
$orders = current_customer_orders();
?>
<main class="section"><div class="container">
  <div class="page-heading">
    <span class="pill">Customer area</span>
    <h1 class="section-title">My Orders</h1>
    <p class="section-sub">Welcome, <?= e($_SESSION['user']['name']); ?>. This page shows orders linked to your customer account.</p>
  </div>
  <?php if (!$orders): ?>
    <div class="empty">You have not placed any orders yet. <a href="products.php">Browse products</a>.</div>
  <?php else: ?>
    <div class="orders-list">
      <?php foreach ($orders as $order): ?>
        <?php $items = order_items_for((int)$order['id']); ?>
        <article class="card order-card">
          <div class="order-head">
            <div>
              <h3>Order #<?= (int)$order['id']; ?></h3>
              <p class="muted">Placed on <?= e(date('d M Y, h:i A', strtotime($order['created_at']))); ?></p>
            </div>
            <div class="order-status"><?= e($order['status']); ?></div>
          </div>
          <div class="table-wrap compact-table">
            <table>
              <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
              <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td><?= e($item['name']); ?></td>
                  <td><?= (int)$item['quantity']; ?></td>
                  <td>$<?= number_format((float)$item['unit_price'], 2); ?></td>
                  <td>$<?= number_format((float)$item['unit_price'] * (int)$item['quantity'], 2); ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="order-total">Total: $<?= number_format((float)$order['total_amount'], 2); ?></div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
