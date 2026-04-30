<?php
$isAdmin = true;
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$pageTitle = 'Admin Orders';
$orders = latest_orders();
require_once __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
  <h1 class="section-title">Order List</h1>
  <div class="table-wrap"><table><thead><tr><th>ID</th><th>Customer</th><th>Email</th><th>Status</th><th>Total</th><th>Date</th></tr></thead><tbody>
    <?php foreach ($orders as $order): ?>
    <tr><td>#<?= (int)$order['id']; ?></td><td><?= e($order['customer_name']); ?></td><td><?= e($order['customer_email']); ?></td><td><?= e($order['status']); ?></td><td>$<?= number_format((float)$order['total_amount'],2); ?></td><td><?= e($order['created_at']); ?></td></tr>
    <?php endforeach; ?>
  </tbody></table></div>
</div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
