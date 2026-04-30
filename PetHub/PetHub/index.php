<?php
$pageTitle = 'PetHub | Home';
require_once __DIR__ . '/includes/header.php';
$featured = featured_products();
?>
<main>
  <section class="hero">
    <div class="container hero-grid">
      <div>
        <span class="pill">Modern Pet Shopping</span>
        <h1>Everything your pet needs, all in one place.</h1>
        <p>PetHub is a clean and simple pet e-commerce website built with PHP and MySQL. Browse pet food, toys, grooming supplies, cages, and accessories in one friendly store.</p>
        <div style="display:flex;gap:14px;flex-wrap:wrap;margin-top:22px;">
          <a class="btn" href="products.php">Shop Now</a>
          <a class="btn alt" href="about.php">Learn More</a>
        </div>
      </div>
      <div class="hero-card"><div class="image-placeholder">PetHub</div></div>
    </div>
  </section>
  <section class="section">
    <div class="container">
      <h2 class="section-title">Why customers choose PetHub</h2>
      <p class="section-sub">Simple browsing, secure login, and easy checkout with a clean admin side for stock and order monitoring.</p>
      <div class="grid grid-3">
        <div class="card"><h3>Friendly Design</h3><p class="muted">Simple layout and clean navigation for a better shopping experience.</p></div>
        <div class="card"><h3>Secure Access</h3><p class="muted">Password hashing, session-based login, and a separated admin role.</p></div>
        <div class="card"><h3>Order Tracking</h3><p class="muted">Products, stock, customers, and orders can be viewed from the admin area.</p></div>
      </div>
    </div>
  </section>
  <section class="section">
    <div class="container">
      <h2 class="section-title">Featured products</h2>
      <div class="grid grid-4">
        <?php foreach ($featured as $product): ?>
          <div class="card product-card">
            <img src="<?= e($product['image']); ?>" alt="<?= e($product['name']); ?>">
            <div class="content">
              <span class="badge"><?= e($product['category']); ?></span>
              <h3><?= e($product['name']); ?></h3>
              <p class="muted"><?= e(substr($product['description'], 0, 72)); ?>...</p>
              <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
                <span class="price">$<?= number_format((float)$product['price'], 2); ?></span>
                <a class="btn" href="product.php?id=<?= (int)$product['id']; ?>">View</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
