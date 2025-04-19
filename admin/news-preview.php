<?php
require "core.php";
include 'header.php'; 



// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 9; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Geçersiz haber ID");
}

$news_id = (int) $_GET['id'];

// Haberi veritabanından çek
$sql = "SELECT * FROM news WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$news_id]);
$news = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$news) {
    die("Haber bulunamadı!");
}


?>

<main class="bmd-layout-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="lite-text"><?= htmlspecialchars($news['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="<?= htmlspecialchars($news['background'], ENT_QUOTES, 'UTF-8') ?>" class="img-fluid mb-3" alt="Öne çıkan görsel">
                        <p><strong>Açıklama:</strong> <?= nl2br(htmlspecialchars($news['descr'], ENT_QUOTES, 'UTF-8')) ?></p>
                        <hr>
                        <p><?= nl2br(htmlspecialchars($news['text'], ENT_QUOTES, 'UTF-8')) ?></p>
                        <hr>
                        <small class="text-muted">Kategori ID: <?= $news['category_id'] ?> | Yayınlanma Zamanı: <?= date("d-m-Y H:i", $news['post_at']) ?></small>
                    </div>
                    <div class="card-footer text-right">
                        <a href="news.php" class="btn btn-secondary">Geri Dön</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
