<?php
require_once __DIR__ . '/../config/config.php';

function all_products(?string $search = null, ?string $category = null): array {
    $sql = 'SELECT * FROM products WHERE 1=1';
    $params = [];
    if ($search) {
        $sql .= ' AND (name LIKE :search OR description LIKE :search)';
        $params['search'] = '%' . $search . '%';
    }
    if ($category) {
        $sql .= ' AND category = :category';
        $params['category'] = $category;
    }
    $sql .= ' ORDER BY id DESC';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function featured_products(int $limit = 4): array {
    $stmt = db()->prepare('SELECT * FROM products ORDER BY id DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_product(int $id): ?array {
    $stmt = db()->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch();
    return $product ?: null;
}

function categories(): array {
    $stmt = db()->query('SELECT DISTINCT category FROM products ORDER BY category');
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function add_to_cart(int $productId, int $quantity = 1): void {
    $product = get_product($productId);
    if (!$product) {
        return;
    }
    $cart = $_SESSION['cart'] ?? [];
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        $cart[$productId] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => (float)$product['price'],
            'image' => $product['image'],
            'quantity' => $quantity,
        ];
    }
    $_SESSION['cart'] = $cart;
}

function update_cart_quantities(array $quantities): void {
    $cart = $_SESSION['cart'] ?? [];
    foreach ($quantities as $productId => $qty) {
        $qty = max(0, (int)$qty);
        if (isset($cart[$productId])) {
            if ($qty === 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $qty;
            }
        }
    }
    $_SESSION['cart'] = $cart;
}

function register_user(string $name, string $email, string $password): bool {
    $stmt = db()->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        return false;
    }
    $insert = db()->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');
    return $insert->execute([
        'name' => $name,
        'email' => $email,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'customer',
    ]);
}

function attempt_login(string $email, string $password): bool {
    $stmt = db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        return true;
    }
    return false;
}

function create_order(array $customerData): int {
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, customer_name, customer_email, phone, address, total_amount, status) VALUES (:user_id, :customer_name, :customer_email, :phone, :address, :total_amount, :status)');
        $stmt->execute([
            'user_id' => $_SESSION['user']['id'] ?? null,
            'customer_name' => $customerData['customer_name'],
            'customer_email' => $customerData['customer_email'],
            'phone' => $customerData['phone'],
            'address' => $customerData['address'],
            'total_amount' => cart_total(),
            'status' => 'Pending',
        ]);
        $orderId = (int)$pdo->lastInsertId();
        $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (:order_id, :product_id, :quantity, :unit_price)');
        $stockStmt = $pdo->prepare('UPDATE products SET stock = GREATEST(stock - :quantity, 0) WHERE id = :id');
        foreach (cart_items() as $item) {
            $itemStmt->execute([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
            $stockStmt->execute([
                'quantity' => $item['quantity'],
                'id' => $item['id'],
            ]);
        }
        $pdo->commit();
        $_SESSION['last_order_id'] = $orderId;
        $_SESSION['cart'] = [];
        return $orderId;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function latest_orders(): array {
    return db()->query('SELECT * FROM orders ORDER BY created_at DESC LIMIT 20')->fetchAll();
}

function all_customers(): array {
    return db()->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
}


function first_name(string $name): string {
    $parts = preg_split('/\s+/', trim($name));
    return $parts[0] ?? $name;
}

function current_customer_orders(): array {
    if (!is_logged_in()) {
        return [];
    }
    $stmt = db()->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC');
    $stmt->execute(['user_id' => $_SESSION['user']['id']]);
    return $stmt->fetchAll();
}

function order_items_for(int $orderId): array {
    $stmt = db()->prepare('SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE oi.order_id = :order_id');
    $stmt->execute(['order_id' => $orderId]);
    return $stmt->fetchAll();
}
