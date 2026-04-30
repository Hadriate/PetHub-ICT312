<?php
$isAdmin = true;
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$pageTitle = 'Admin Customers';
$customers = all_customers();
require_once __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
  <h1 class="section-title">Customer List</h1>
  <div class="table-wrap"><table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead><tbody>
    <?php foreach ($customers as $customer): ?>
    <tr><td><?= (int)$customer['id']; ?></td><td><?= e($customer['name']); ?></td><td><?= e($customer['email']); ?></td><td><?= e($customer['role']); ?></td><td><?= e($customer['created_at']); ?></td></tr>
    <?php endforeach; ?>
  </tbody></table></div>
</div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
