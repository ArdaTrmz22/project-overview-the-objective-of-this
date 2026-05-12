<?php
// admin/index.php
session_start();

// Güvenlik Kontrolü: Oturum açılmış mı veya geçerli bir Cookie var mı?
$isLoggedIn = false;

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $isLoggedIn = true;
} elseif (isset($_COOKIE['admin_remember']) && $_COOKIE['admin_remember'] === 'true') {
    // Çerez geçerliyse oturumu yeniden canlandır
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['username'] = 'admin'; // Gerçek senaryoda veritabanından çekilir
    $isLoggedIn = true;
}

if (!$isLoggedIn) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; font-family: 'Outfit', sans-serif; margin: 0; padding: 0; }
        body { background: #f8fafc; color: #0f172a; display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 250px; background: #1e293b; color: white; padding: 2rem 1rem; display: flex; flex-direction: column; }
        .sidebar h2 { margin-bottom: 2rem; text-align: center; color: #38bdf8; }
        .sidebar a { display: block; padding: 1rem; color: #cbd5e1; text-decoration: none; border-radius: 8px; margin-bottom: 0.5rem; transition: background 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #334155; color: white; }
        .sidebar a i { margin-right: 10px; width: 20px; text-align: center; }
        .logout-btn { margin-top: auto; background: #ef4444; text-align: center; }
        .logout-btn:hover { background: #dc2626; }

        /* Main Content */
        .main-content { flex: 1; padding: 2rem 5%; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; }
        
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="index.php" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="projects.php"><i class="fa-solid fa-briefcase"></i> Projeler</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Mesajlar</a>
    <a href="../index.html" target="_blank"><i class="fa-solid fa-globe"></i> Siteyi Gör</a>
    <a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Hoş Geldiniz, Yönetici</h1>
        <div>Tarih: <?= date('d.m.Y') ?></div>
    </div>
    
    <div class="card">
        <h3>Sistem Durumu</h3>
        <p style="margin-top: 1rem; color: #64748b;">Giriş başarılı. Sol menüden projelerinizi ekleyip silebilir veya sitenizden gelen iletişim formlarını (mesajları) okuyabilirsiniz.</p>
    </div>
</div>

</body>
</html>
