<?php
// admin/login.php
session_start();
require_once '../includes/db.php';

// Eğer kullanıcı zaten giriş yapmışsa panele yönlendir
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// "Beni Hatırla" çerezi (Cookie) varsa otomatik giriş yap (Güvenlik amaçlı basitleştirilmiş)
if (isset($_COOKIE['admin_remember']) && $_COOKIE['admin_remember'] === 'true') {
    $_SESSION['admin_logged_in'] = true;
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']) ? true : false;

    if (!empty($username) && !empty($password)) {
        // Veritabanından kullanıcıyı sorgula
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Şifre doğrulama (password_verify kullanılır)
        if ($user && password_verify($password, $user['password_hash'])) {
            // Başarılı giriş - Session (Oturum) başlat
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $user['username'];

            // Cookie (Çerez) işlemi (Eğer 'Beni Hatırla' işaretlendiyse)
            if ($remember) {
                // 30 günlük cookie oluştur (Saniye cinsinden)
                setcookie('admin_remember', 'true', time() + (86400 * 30), "/");
            }

            header("Location: index.php");
            exit;
        } else {
            $error = "Hatalı kullanıcı adı veya şifre.";
        }
    } else {
        $error = "Lütfen tüm alanları doldurun.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi - Portföy</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background: #0f172a; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; color: #f1f5f9; }
        .login-box { background: rgba(30, 41, 59, 0.7); padding: 3rem; border-radius: 16px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); }
        h2 { text-align: center; margin-bottom: 2rem; color: #60a5fa; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; }
        input[type="text"], input[type="password"] { width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #334155; background: #020617; color: white; }
        .btn { width: 100%; padding: 1rem; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 1rem; }
        .btn:hover { background: #2563eb; }
        .error { color: #f43f5e; text-align: center; margin-bottom: 1rem; }
        .remember-me { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Yönetici Girişi</h2>
    <?php if($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>Kullanıcı Adı</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Şifre</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin: 0; cursor: pointer;">Beni Hatırla</label>
        </div>
        <button type="submit" class="btn">Giriş Yap</button>
        <a href="../index.php" style="display:block; text-align:center; margin-top: 1rem; color: #94a3b8; text-decoration: none;">Siteye Dön</a>
    </form>
</div>

</body>
</html>
