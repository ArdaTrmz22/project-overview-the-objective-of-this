<?php
// api/get_projects.php
require_once '../includes/db.php';

// CORS Başlıkları (Live Server vb. farklı origin'lerden gelen isteklere izin ver)
header('Access-Control-Allow-Origin: *'); // Her yerden gelen isteklere açık (Geliştirme için)
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// OPTIONS isteği (Preflight) gelirse hemen yanıt verip çık
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'data' => $projects
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Projeler yüklenirken bir hata oluştu.'
    ]);
}
?>
