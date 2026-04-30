<?php
$pageTitle = 'Products';
require_once __DIR__ . '/includes/header.php';
$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$products = all_products($search ?: null, $category ?: null);
$categories = categories();
?>
<main class="section"><div class="container">
  <h1 class="section-title">Browse Products</h1>
  <p class="section-sub">Explore practical pet supplies with accurate product images for food, toys, bedding, grooming, cages, and accessories.</p>
  <form class="toolbar" method="get">
    <div class="field"><input type="text" name="search" placeholder="Search products" value="<?= e($search); ?>"></div>
    <div class="field"><select name="category"><option value="">All categories</option><?php foreach($categories as $cat): ?><option value="<?= e($cat); ?>" <?= $cat===$category?'selected':''; ?>><?= e($cat); ?></option><?php endforeach; ?></select></div>
    <button class="btn" type="submit">Filter</button>
  </form>
  <div class="grid grid-4">
    <?php foreach ($products as $product): ?>
      <div class="card product-card">
        <img src="<?= e($product['image']); ?>" alt="<?= e($product['name']); ?>">
        <div class="content">
          <span class="badge"><?= e($product['category']); ?></span>
          <h3><?= e($product['name']); ?></h3>
          <p class="muted"><?= e(substr($product['description'],0,60)); ?>...</p>
          <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
            <span class="price">$<?= number_format((float)$product['price'],2); ?></span>
            <a class="btn" href="product.php?id=<?= (int)$product['id']; ?>">Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
