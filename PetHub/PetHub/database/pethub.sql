CREATE DATABASE IF NOT EXISTS pethub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pethub;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  category VARCHAR(80) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  image VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  customer_name VARCHAR(120) NOT NULL,
  customer_email VARCHAR(120) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  address VARCHAR(255) NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  status VARCHAR(50) NOT NULL DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  CONSTRAINT fk_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  CONSTRAINT fk_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password_hash, role) VALUES
('PetHub Admin', 'admin@pethub.local', '$2y$12$vny13ZEj7n9MyDCGi38XW.mzfFgGGuTkfJ1QS8K.lf/sB3CamY6Fq', 'admin'),
('Keane Frederick', 'keane@example.com', '$2y$12$YYtht98vlemAA/cBfaVpSe35Q2.BFhjPnxbs3M7l2BjeocYNyT0MG', 'customer');

INSERT INTO products (name, category, price, stock, image, description) VALUES
('Premium Dog Food', 'Food', 29.99, 25, 'assets/images/products/dogfood.jpg', 'Nutritious dry food for adult dogs with balanced ingredients.'),
('Cat Scratching Post', 'Accessories', 49.90, 12, 'assets/images/products/scratchingpost.jpg', 'Durable scratching post to keep cats active and furniture protected.'),
('Pet Grooming Kit', 'Grooming', 24.50, 18, 'assets/images/products/groomingkit.jpg', 'Brushes and combs for keeping your pet clean and comfortable.'),
('Bird Cage Starter Set', 'Cages', 89.00, 8, 'assets/images/products/birdcage.jpg', 'Starter cage setup suitable for small birds with feeding bowls.'),
('Chew Toy Bundle', 'Toys', 15.99, 40, 'assets/images/products/toybundle.jpg', 'Colorful chew toys for playful dogs and puppies.'),
('Soft Pet Bed', 'Accessories', 39.95, 16, 'assets/images/products/petbed.jpg', 'Comfortable cushioned pet bed for cats and small dogs.');

INSERT INTO orders (user_id, customer_name, customer_email, phone, address, total_amount, status) VALUES
(2, 'Keane Frederick', 'keane@example.com', '0400000000', 'Sydney NSW', 54.49, 'Pending');

INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES
(1, 1, 1, 29.99),
(1, 5, 1, 15.99),
(1, 3, 1, 24.50);
