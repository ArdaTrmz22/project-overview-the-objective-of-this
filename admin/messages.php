<?php
// admin/messages.php
session_start();
require_once '../includes/db.php';

// Güvenlik: Admin girişi yapılmamışsa login'e gönder
$isLoggedIn = false;
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $isLoggedIn = true;
} elseif (isset($_COOKIE['admin_remember']) && $_COOKIE['admin_remember'] === 'true') {
    $_SESSION['admin_logged_in'] = true;
    $isLoggedIn = true;
}

if (!$isLoggedIn) {
    header("Location: login.php");
    exit;
}

$message_feedback = '';

// Mesaj Silme İşlemi
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$id]);
        $message_feedback = "<div class='alert success'>Mesaj başarıyla silindi.</div>";
    } catch (Exception $e) {
        $message_feedback = "<div class='alert error'>Hata: Mesaj silinemedi.</div>";
    }
}

// Mesajları Veritabanından Çek
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelen Mesajlar - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; font-family: 'Outfit', sans-serif; margin: 0; padding: 0; }
        body { background: #f8fafc; color: #0f172a; display: flex; min-height: 100vh; }
        
        /* Sidebar (Aynı) */
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
        
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; margin-bottom: 2rem; }
        
        .btn-danger { background: #ef4444; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 6px; font-size: 0.9rem; }
        .btn-danger:hover { background: #dc2626; }

        /* Message List */
        .message-item { border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem; background: #f8fafc; }
        .message-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; }
        .message-sender { font-weight: 600; color: #0f172a; font-size: 1.1rem; }
        .message-email { color: #3b82f6; font-size: 0.9rem; margin-top: 0.2rem; }
        .message-date { color: #64748b; font-size: 0.85rem; }
        .message-body { color: #334155; line-height: 1.6; white-space: pre-wrap; }
        
        .alert { padding: 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="index.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="projects.php"><i class="fa-solid fa-briefcase"></i> Projeler</a>
    <a href="messages.php" class="active"><i class="fa-solid fa-envelope"></i> Mesajlar</a>
    <a href="../index.html" target="_blank"><i class="fa-solid fa-globe"></i> Siteyi Gör</a>
    <a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Gelen Mesajlar</h1>
    </div>

    <?= $message_feedback ?>

    <div class="card">
        <h3><i class="fa-solid fa-inbox"></i> İletişim Formu Mesajları</h3>
        <p style="color: #64748b; margin-bottom: 1.5rem; margin-top: 0.5rem;">Ziyaretçilerinizden gelen mesajları buradan okuyabilirsiniz.</p>

        <?php foreach($messages as $msg): ?>
            <div class="message-item">
                <div class="message-header">
                    <div>
                        <div class="message-sender"><?= htmlspecialchars($msg['name']) ?></div>
                        <div class="message-email"><a href="mailto:<?= htmlspecialchars($msg['email']) ?>" style="color: inherit; text-decoration: none;"><i class="fa-regular fa-envelope"></i> <?= htmlspecialchars($msg['email']) ?></a></div>
                    </div>
                    <div style="text-align: right;">
                        <div class="message-date"><?= date('d.m.Y H:i', strtotime($msg['created_at'])) ?></div>
                        <a href="messages.php?delete=<?= $msg['id'] ?>" class="btn-danger" style="display: inline-block; margin-top: 0.5rem;" onclick="return confirm('Bu mesajı silmek istediğinize emin misiniz?');"><i class="fa-solid fa-trash"></i> Sil</a>
                    </div>
                </div>
                <div class="message-body"><?= nl2br(htmlspecialchars($msg['message'])) ?></div>
            </div>
        <?php endforeach; ?>

        <?php if(count($messages) === 0): ?>
            <div style="text-align: center; color: #64748b; padding: 2rem 0;">
                <i class="fa-solid fa-inbox" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                <p>Henüz gelen bir mesajınız bulunmuyor.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
