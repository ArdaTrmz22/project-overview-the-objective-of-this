<?php
// api/process_contact.php
require_once '../includes/db.php';

// CORS Başlıkları (Live Server desteği için)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// OPTIONS (Preflight) isteğine anında cevap dön
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek yöntemi.']);
    exit;
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

$name = $input['name'] ?? $_POST['name'] ?? '';
$email = $input['email'] ?? $_POST['email'] ?? '';
$message = $input['message'] ?? $_POST['message'] ?? '';

$name = htmlspecialchars(strip_tags(trim($name)));
$email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(strip_tags(trim($message)));

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen tüm alanları doldurun.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen geçerli bir e-posta adresi girin.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Mesajınız başarıyla gönderildi. Sizinle en kısa sürede iletişime geçeceğim.'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Mesaj gönderilirken sunucu tarafında bir hata oluştu.'
    ]);
}
?>
