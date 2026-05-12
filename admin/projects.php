<?php
// admin/projects.php
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

$message = '';

// Proje Silme İşlemi
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $message = "<div class='alert success'>Proje başarıyla silindi.</div>";
    } catch (Exception $e) {
        $message = "<div class='alert error'>Hata: Proje silinemedi.</div>";
    }
}

// Yeni Proje Ekleme İşlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image_url = ''; // Varsayılan boş

    // Dosya yükleme (Image Upload) işlemi
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $fileName;
        
        // Dosyayı uploads klasörüne taşı
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $image_url = 'uploads/' . $fileName; // Veritabanına kaydedilecek yol
        }
    }

    if (!empty($title) && !empty($description)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_url) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $image_url]);
            $message = "<div class='alert success'>Yeni proje başarıyla eklendi.</div>";
        } catch (Exception $e) {
            $message = "<div class='alert error'>Hata: Proje eklenemedi.</div>";
        }
    } else {
        $message = "<div class='alert error'>Lütfen başlık ve açıklama alanlarını doldurun.</div>";
    }
}

// Projeleri Veritabanından Çek
$stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeleri Yönet - Admin Panel</title>
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
        
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; }
        .btn { padding: 0.8rem 1.5rem; background: #3b82f6; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }
        .btn:hover { background: #2563eb; }
        .btn-danger { background: #ef4444; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 6px; font-size: 0.9rem; }
        .btn-danger:hover { background: #dc2626; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f1f5f9; font-weight: 600; }
        .project-img { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; }
        
        .alert { padding: 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="index.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="projects.php" class="active"><i class="fa-solid fa-briefcase"></i> Projeler</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Mesajlar</a>
    <a href="../index.html" target="_blank"><i class="fa-solid fa-globe"></i> Siteyi Gör</a>
    <a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Projeleri Yönet</h1>
    </div>

    <?= $message ?>

    <!-- Yeni Proje Ekleme Formu -->
    <div class="card">
        <h3><i class="fa-solid fa-plus"></i> Yeni Proje Ekle</h3>
        <form method="POST" action="projects.php" enctype="multipart/form-data" style="margin-top: 1rem;">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Proje Başlığı *</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group">
                <label>Proje Açıklaması *</label>
                <textarea name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Proje Görseli Seç (Opsiyonel)</label>
                <input type="file" name="image" accept="image/*" style="padding: 0.5rem;">
            </div>
            <button type="submit" class="btn">Projeyi Ekle</button>
        </form>
    </div>

    <!-- Proje Listesi Tablosu -->
    <div class="card">
        <h3>Mevcut Projeler</h3>
        <table>
            <thead>
                <tr>
                    <th>Görsel</th>
                    <th>Başlık</th>
                    <th>Açıklama</th>
                    <th>Eklenme Tarihi</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projects as $project): ?>
                <tr>
                    <td>
                        <img src="<?= htmlspecialchars($project['image_url'] ?: 'https://via.placeholder.com/80x50') ?>" class="project-img">
                    </td>
                    <td><?= htmlspecialchars($project['title']) ?></td>
                    <td><?= htmlspecialchars(mb_substr($project['description'], 0, 50)) ?>...</td>
                    <td><?= date('d.m.Y', strtotime($project['created_at'])) ?></td>
                    <td>
                        <a href="projects.php?delete=<?= $project['id'] ?>" class="btn-danger" onclick="return confirm('Bu projeyi silmek istediğinize emin misiniz?');"><i class="fa-solid fa-trash"></i> Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($projects) === 0): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #64748b;">Hiç proje bulunamadı.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
