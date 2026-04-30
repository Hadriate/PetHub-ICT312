<?php
require_once __DIR__ . '/includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$product = get_product($id);
if (!$product) {
    flash('Product not found.');
    redirect('products.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_to_cart($id, max(1, (int)($_POST['quantity'] ?? 1)));
    flash('Product added to cart.');
    redirect('cart.php');
}
$pageTitle = $product['name'];
require_once __DIR__ . '/includes/header.php';
?>
<main class="section"><div class="container">
  <div class="product-detail card">
    <img src="<?= e($product['image']); ?>" alt="<?= e($product['name']); ?>">
    <div>
      <span class="badge"><?= e($product['category']); ?></span>
      <h1><?= e($product['name']); ?></h1>
      <p class="price">$<?= number_format((float)$product['price'], 2); ?></p>
      <div class="meta"><span class="badge">Stock: <?= (int)$product['stock']; ?></span></div>
      <p class="muted"><?= e($product['description']); ?></p>
      <form method="post">
        <div class="qty-row">
          <label for="quantity">Quantity</label>
          <input id="quantity" type="number" name="quantity" min="1" max="10" value="1" style="width:90px;">
        </div>
        <button class="btn" type="submit">Add to Cart</button>
      </form>
    </div>
  </div>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
