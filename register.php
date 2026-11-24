<?php require_once 'config/config.php';
if (is_logged_in()) redirect('index.php');
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $pass = $_POST['password'] ?? '';
    if ($name === '') $errors[] = 'Please enter your name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!preg_match('/^[0-9+()\- ]{7,20}$/', $phone)) $errors[] = 'Enter a valid contact number.';
    if (strlen($pass) < 8) $errors[] = 'Password must contain at least 8 characters.';
    if (!$errors) 
    {
        $q = db()->prepare('SELECT id FROM users WHERE email=?');
        $q->execute([$email]);
        if ($q->fetch()) $errors[] = 'An account with this email already exists.';
        else {
            $q = db()->prepare('INSERT INTO users(name,email,phone,password_hash) VALUES(?,?,?,?)');
            $q->execute([$name, $email, $phone, password_hash($pass, PASSWORD_DEFAULT)]);
            set_flash('Account created. You can now log in.');
            redirect('login.php');
        }
    }
}
$pageTitle = 'Create account';
require 'includes/header.php'; ?>
<main class="auth-page">
    <div class="auth-card">
        <div class="eyebrow dark-eyebrow">JOIN FIREGUARD</div>
        <h1>Create your account</h1>
        <p class="muted">Register to submit and track fire incident reports.</p><?php if ($errors): ?><div class="alert alert-error"><?= e(implode(' ', $errors)) ?></div><?php endif; ?><form method="post" class="form-stack"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Full name<input name="name" required maxlength="100" value="<?= e($_POST['name'] ?? '') ?>" placeholder="Enter your full name"></label><label>Email address<input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>" placeholder="you@example.com"></label><label>Contact number<input name="phone" required value="<?= e($_POST['phone'] ?? '') ?>" placeholder="Enter contact number"></label><label>Password<input type="password" name="password" required minlength="8" placeholder="At least 8 characters"></label><button class="btn btn-red btn-full">Create account <span>→</span></button></form>
        <p class="auth-switch">Already registered? <a href="login.php">Log in</a></p>
    </div>
    <aside class="auth-aside">
        <div class="aside-mark">✦</div>
        <h2>Better information<br>starts with a clear report.</h2>
        <p>Keep your submitted incident details accessible in one place.</p>
        <div class="aside-bottom">FIREGUARD · INCIDENT REPORTING PORTAL</div>
    </aside>
</main><?php require 'includes/footer.php'; ?>