<?php
require "core.php"; // Veritabanı bağlantısı ve kullanıcı bilgileri


// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 9; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}


// Haber ID'si kontrolü
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Geçersiz haber ID");
}

$news_id = (int) $_GET['id'];

// Haberin mevcut durumunu kontrol et
$sql = "SELECT * FROM news WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$news_id]);
$news = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$news) {
    die("Haber bulunamadı!");
}

// Eğer haber zaten yayındaysa işlem yapma
if ($news['validity'] == 1) {
    die("Bu haber zaten yayında!");
}

// Haberi yayına al (validity = 1)
$update_sql = "UPDATE news SET validity = 1 WHERE id = ?";
$update_stmt = $db->prepare($update_sql);

if ($update_stmt->execute([$news_id])) {
    // Log kaydı ekle
    $log_sql = "INSERT INTO logs (user_id, username, action, details, created_at) VALUES (?, ?, ?, ?, ?)";
    $log_stmt = $db->prepare($log_sql);
    $action = "Haber yayınlandı";
    $details = "Yayınlanan haber ID: " . $news_id;
    $created_at = date("Y-m-d H:i:s");

    $log_stmt->execute([$user['id'], $user['username'], $action, $details, $created_at]);

    // Başarı mesajı ve yönlendirme
    echo "<script>
        alert('Haber başarıyla yayınlandı!');
        window.location.href = 'news.php'; // Haber listesi sayfasına yönlendir
    </script>";
} else {
    echo "Hata oluştu!";
}
?>
