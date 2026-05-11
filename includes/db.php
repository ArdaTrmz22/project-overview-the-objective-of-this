<?php
// includes/db.php
// Veritabanı bağlantı ayarları

$host = 'localhost';
$dbname = 'portfolio_db';
$user = 'root'; // XAMPP varsayılan kullanıcı adı
$pass = ''; // XAMPP varsayılan şifresi boştur

try {
    // PDO ile güvenli veritabanı bağlantısı kurma
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    // Hata modunu Exception olarak ayarla ki hataları yakalayabilelim
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    
} catch (PDOException $e) {
    // Bağlantı hatası oluşursa ekrana bas
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
