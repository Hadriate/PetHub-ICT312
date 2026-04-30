<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <h4>PetHub</h4>
      <p>Simple, clean, and friendly pet shopping for food, toys, grooming, and accessories.</p>
    </div>
    <div>
      <h4>Quick Links</h4>
      <p><a href="<?= isset($isAdmin) ? '../products.php' : 'products.php' ?>">Products</a></p>
      <p><a href="<?= isset($isAdmin) ? '../checkout.php' : 'checkout.php' ?>">Checkout</a></p>
      <p><a href="<?= isset($isAdmin) ? '../contact.php' : 'contact.php' ?>">Contact</a></p>
    </div>
    <div>
      <h4>Contact</h4>
      <p>Email: hello@pethub.local</p>
      <p>Phone: +61 400 123 456</p>
    </div>
  </div>
</footer>
</body>
</html>
