<?php
require_once __DIR__ . '/includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    update_cart_quantities($_POST['quantities'] ?? []);
    flash('Cart updated.');
    redirect('cart.php');
}
$pageTitle = 'Cart';
require_once __DIR__ . '/includes/header.php';
$items = cart_items();
?>
<main class="section"><div class="container">
  <h1 class="section-title">Shopping Cart</h1>
  <?php if (!$items): ?>
    <div class="empty">Your cart is empty. <a href="products.php">Browse products</a>.</div>
  <?php else: ?>
    <div class="two-col">
      <form method="post" class="table-wrap">
        <table>
          <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr></thead>
          <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= e($item['name']); ?></td>
              <td>$<?= number_format($item['price'], 2); ?></td>
              <td><input type="number" name="quantities[<?= (int)$item['id']; ?>]" min="0" value="<?= (int)$item['quantity']; ?>" style="width:80px"></td>
              <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <div style="margin-top:18px;display:flex;gap:12px;"><button class="btn" type="submit">Update Cart</button><a class="btn alt" href="products.php">Continue Shopping</a></div>
      </form>
      <div class="summary card">
        <h3>Order Summary</h3>
        <div class="line"><span>Items</span><span><?= cart_count(); ?></span></div>
        <div class="line total"><span>Total</span><span>$<?= number_format(cart_total(), 2); ?></span></div>
        <?php if (is_logged_in()): ?>
          <a class="btn" href="checkout.php" style="margin-top:12px;">Proceed to Checkout</a>
        <?php else: ?>
          <a class="btn" href="login.php" style="margin-top:12px;">Login to Checkout</a>
          <p class="muted">Customers must create an account or log in before placing an order.</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
