<?php
$isAdmin = true;
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$pageTitle = 'Admin Dashboard';
$stats = [
    'Products' => db()->query('SELECT COUNT(*) FROM products')->fetchColumn(),
    'Orders' => db()->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
    'Customers' => db()->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(),
    'Revenue' => db()->query('SELECT COALESCE(SUM(total_amount),0) FROM orders')->fetchColumn(),
];
require_once __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
  <h1 class="section-title">Admin Dashboard</h1>
  <div class="admin-links">
    <a class="btn alt" href="products.php">Stock</a>
    <a class="btn alt" href="orders.php">Orders</a>
    <a class="btn alt" href="customers.php">Customers</a>
  </div>
  <div class="stats">
    <div class="stat"><span>Products</span><strong><?= (int)$stats['Products']; ?></strong></div>
    <div class="stat"><span>Orders</span><strong><?= (int)$stats['Orders']; ?></strong></div>
    <div class="stat"><span>Customers</span><strong><?= (int)$stats['Customers']; ?></strong></div>
    <div class="stat"><span>Revenue</span><strong>$<?= number_format((float)$stats['Revenue'],2); ?></strong></div>
  </div>
  <div class="table-wrap">
    <h3>Recent Orders</h3>
    <table><thead><tr><th>ID</th><th>Customer</th><th>Status</th><th>Total</th><th>Date</th></tr></thead><tbody>
      <?php foreach (latest_orders() as $order): ?>
      <tr><td>#<?= (int)$order['id']; ?></td><td><?= e($order['customer_name']); ?></td><td><?= e($order['status']); ?></td><td>$<?= number_format((float)$order['total_amount'],2); ?></td><td><?= e($order['created_at']); ?></td></tr>
      <?php endforeach; ?>
    </tbody></table>
  </div>
</div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
