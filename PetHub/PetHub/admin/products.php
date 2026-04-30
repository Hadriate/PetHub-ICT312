<?php
$isAdmin = true;
require_once __DIR__ . '/../includes/functions.php';
require_admin();
$pageTitle = 'Admin Stock';
$products = all_products();
require_once __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
  <h1 class="section-title">Stock Management</h1>
  <div class="table-wrap"><table><thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th></tr></thead><tbody>
    <?php foreach ($products as $product): ?>
    <tr><td><?= (int)$product['id']; ?></td><td><?= e($product['name']); ?></td><td><?= e($product['category']); ?></td><td>$<?= number_format((float)$product['price'],2); ?></td><td><?= (int)$product['stock']; ?></td></tr>
    <?php endforeach; ?>
  </tbody></table></div>
</div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
