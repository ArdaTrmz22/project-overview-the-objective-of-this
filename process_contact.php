<?php
// process_contact.php
// İletişim formundan gelen verileri işler ve veritabanına kaydeder.

require_once 'includes/db.php';

header('Content-Type: application/json; charset=utf-8');

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek yöntemi.']);
    exit;
}

// Gelen verileri al (Eğer JSON olarak geliyorsa)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Eğer form FormData nesnesi ile gelirse $_POST üzerinden de kontrol edelim
$name = $input['name'] ?? $_POST['name'] ?? '';
$email = $input['email'] ?? $_POST['email'] ?? '';
$message = $input['message'] ?? $_POST['message'] ?? '';

// Güvenlik (Sanitization)
$name = htmlspecialchars(strip_tags(trim($name)));
$email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(strip_tags(trim($message)));

// Temel Boşluk ve Format Validasyonu
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen tüm alanları doldurun.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Lütfen geçerli bir e-posta adresi girin.']);
    exit;
}

try {
    // Veritabanına PDO ile güvenli bir şekilde kaydet (SQL Injection koruması)
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    // Başarılı yanıt
    echo json_encode([
        'status' => 'success',
        'message' => 'Mesajınız başarıyla gönderildi. Sizinle en kısa sürede iletişime geçeceğim.'
    ]);

} catch (Exception $e) {
    // Veritabanı hatası
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Mesaj gönderilirken sunucu tarafında bir hata oluştu.'
    ]);
}
?>
