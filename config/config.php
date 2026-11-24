<?php
// Update these values to match your Laragon MySQL configuration.
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'fire_emergency_system');
define('DB_USER', 'root');
define('DB_PASS', '');
define('APP_NAME', 'FireGuard');
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $path): never { header('Location: '.$path); exit; }
function is_logged_in(): bool { return isset($_SESSION['user']); }
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void { if (!is_logged_in()) { set_flash('Please log in to continue.', 'error'); redirect('login.php'); } }
function require_admin(): void { require_login(); if (($_SESSION['user']['role'] ?? '') !== 'admin') { http_response_code(403); exit('Access denied. Administrator permission required.'); } }
function set_flash(string $message, string $type='success'): void { $_SESSION['flash'] = ['message'=>$message, 'type'=>$type]; }
function get_flash(): ?array { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void { if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Invalid or expired form token. Please go back and try again.'); } }
function status_label(string $status): string { return ucwords(str_replace('_', ' ', $status)); }
?>
