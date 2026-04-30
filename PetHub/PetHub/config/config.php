<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'pethub');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', '');

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    return $pdo;
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void {
    header('Location: ' . $path);
    exit;
}

function is_logged_in(): bool {
    return isset($_SESSION['user']);
}

function is_admin(): bool {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function require_login(): void {
    if (!is_logged_in()) {
        $_SESSION['flash'] = 'Please log in first.';
        redirect('login.php');
    }
}

function require_admin(): void {
    if (!is_admin()) {
        $_SESSION['flash'] = 'Admin access only.';
        redirect('login.php');
    }
}

function flash(?string $message = null): ?string {
    if ($message !== null) {
        $_SESSION['flash'] = $message;
        return null;
    }
    if (!empty($_SESSION['flash'])) {
        $message = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $message;
    }
    return null;
}

function cart_items(): array {
    return $_SESSION['cart'] ?? [];
}

function cart_count(): int {
    return array_sum(array_column(cart_items(), 'quantity'));
}

function cart_total(): float {
    $total = 0;
    foreach (cart_items() as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
