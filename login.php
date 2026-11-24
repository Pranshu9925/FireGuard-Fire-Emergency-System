<?php require_once 'config/config.php'; 
    if(is_logged_in())redirect(current_user()['role']==='admin'?'dashboard.php':'my-reports.php');
    $error='';
    if($_SERVER['REQUEST_METHOD']==='POST')
        {
            verify_csrf();
            $email=strtolower(trim($_POST['email']??''));
            $pass=$_POST['password']??'';
            $q=db()->prepare('SELECT id,name,email,phone,password_hash,role FROM users WHERE email=?');
            $q->execute([$email]);
            $u=$q->fetch();
            if($u&&password_verify($pass,$u['password_hash']))
            {
                session_regenerate_id(true);
                unset($u['password_hash']);
                $_SESSION['user']=$u;
                set_flash('Welcome back, '.$u['name'].'.');
                redirect($u['role']==='admin'?'dashboard.php':'my-reports.php');
            }
            else 
            {
                $error='Email or password is incorrect.';
            } 
        }
            
            $pageTitle='Log in';require 'includes/header.php'; ?>
        
<main class="auth-page">
    <div class="auth-card">
        <div class="eyebrow dark-eyebrow">WELCOME BACK</div>
        <h1>Log in to FireGuard</h1>
        <p class="muted">Access your reports and incident updates.</p>
        <?php if($error): ?>
            <div class="alert alert-error">
                <?= e($error) ?>
            </div>
            <?php endif; ?>
            <form method="post" class="form-stack">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <label>Email address<input type="email" name="email" required value="<?= e($_POST['email']??'') ?>" placeholder="you@example.com"></label>
                <label>Password<input type="password" name="password" required placeholder="Enter your password"></label>
                <button class="btn btn-red btn-full">Log in <span>→</span></button>
            </form>
            <p class="auth-switch">New to FireGuard? 
                <a href="register.php">Create an account</a></p></div>
                <aside class="auth-aside">
                    <div class="aside-mark">✦</div>
                    <h2>Your reports.<br>One organized place.</h2>
                    <p>Sign in to submit an incident or follow the latest recorded status.</p>
                    <div class="aside-bottom">FIREGUARD · INCIDENT REPORTING PORTAL</div>
                </aside>
            </main>
            <?php require 'includes/footer.php'; ?>
