<?php
// admin/logout.php
session_start();

// Session (oturum) verilerini temizle
$_SESSION = [];
session_destroy();

// Çerezi (Cookie) sil (Süresini geçmiş bir zamana ayarlayarak)
if (isset($_COOKIE['admin_remember'])) {
    setcookie('admin_remember', '', time() - 3600, "/");
}

// Giriş sayfasına yönlendir
header("Location: login.php");
exit;
?>
