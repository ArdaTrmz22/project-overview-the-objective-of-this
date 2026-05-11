<?php
// get_projects.php
// Bu dosya veritabanındaki projeleri çekip JSON formatında döndürür (AJAX için)

require_once 'includes/db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // Projeleri veritabanından çek (En yeniden en eskiye doğru)
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();

    // Başarılı yanıt
    echo json_encode([
        'status' => 'success',
        'data' => $projects
    ]);
} catch (Exception $e) {
    // Hata durumunda JSON döndür
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Projeler yüklenirken bir hata oluştu.'
    ]);
}
?>
