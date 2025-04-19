<?php require "core.php"; ?>
<?php require "header.php"; ?>

<?php


// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 3; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}



// Duyuru gönderme veya silme işlemi
$message = ''; // Mesajı saklamak için değişken
$toastClass = ''; // Toast bildirim sınıfı
$toastTitle = ''; // Toast bildirim başlığı

// Veritabanından aktif duyuruyu çek (sayfa ilk yüklendiğinde)
$load_actual_alert = $db->query("SELECT * FROM alert");
$check = $load_actual_alert->rowCount();

if ($check > 0) {
    $annonce = $load_actual_alert->fetch(); // Aktif duyuruyu al
    // Eğer mevcut duyuru varsa, uyarı mesajını ayarla
    $toastClass = 'toast-warning'; // Mevcut duyuru için uyarı sınıfı
    $toastTitle = 'Duyuru Mevcut';
    $message = 'Mevcut bir duyuru var: ' . $annonce['text']; // Mevcut duyuruyu göster
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $secu->post($_POST['text']); // Kullanıcının girdiği metni al

    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'send') {
            if ($check == 0) {
                // Yeni duyuru ekle
                $add_annonce = $db->prepare("INSERT INTO alert(text, post_at) VALUES(?, ?)");
                $add_annonce->execute(array($text, time()));

                // Log kaydı ekle
                $log_action = 'Duyuru Ekleme';
                $log_details = "Kullanıcı İD:{$user['id']} ({$user['username']}) yeni duyuru ekledi: {$text}"; // Kullanıcı adını ekledik
                $log = $db->prepare("INSERT INTO logs (user_id, username, action, details) VALUES (?, ?, ?, ?)"); // username ekleniyor
                $log->execute(array($user['id'], $user['username'], $log_action, $log_details));

                $toastClass = 'toast-success'; // Yeni duyuru için başarı sınıfı
                $toastTitle = 'Başarılı';
                $message = 'Duyuru yayınlandı.'; // Başarı mesajını ayarla
            } else {
                // Mevcut duyuruyu güncelle
                $update_alert = $db->prepare("UPDATE alert SET text = ?, post_at = ? WHERE id = ?");
                $update_alert->execute(array($text, time(), $annonce['id']));

                // Log kaydı ekle
                $log_action = 'Duyuru Güncelleme';
                $log_details = "Kullanıcı İD:{$user['id']} ({$user['username']}) duyuruyu güncelledi: {$text}"; // Kullanıcı adını ekledik
                $log = $db->prepare("INSERT INTO logs (user_id, username, action, details) VALUES (?, ?, ?, ?)"); // username ekleniyor
                $log->execute(array($user['id'], $user['username'], $log_action, $log_details));

                $toastClass = 'toast-warning'; // Mevcut duyuru güncelleme için uyarı sınıfı
                $toastTitle = 'Uyarı';
                $message = 'Duyuru güncellendi.'; // Başarı mesajını ayarla
                // Mevcut duyuruyu tekrar çek
                $annonce['text'] = $text; // Güncellenmiş duyuru metni
            }

            // Güncellenmiş duyuruyu tekrar al
            $load_actual_alert = $db->query("SELECT * FROM alert");
            $annonce = $load_actual_alert->fetch(); // Güncellenmiş duyuruyu al
        } elseif ($_POST['action'] == 'delete') {
            // Duyuruyu sil
            $delete_alert = $db->query("TRUNCATE TABLE alert");

            // Log kaydı ekle
            $log_action = 'Duyuru Silme';
            $log_details = "Kullanıcı İD:{$user['id']} ({$user['username']}) mevcut duyuruyu sildi."; // Kullanıcı adını ekledik
            $log = $db->prepare("INSERT INTO logs (user_id, username, action, details) VALUES (?, ?, ?, ?)"); // username ekleniyor
            $log->execute(array($user['id'], $user['username'], $log_action, $log_details));

            $toastClass = 'toast-error'; // Silme için hata sınıfı
            $toastTitle = 'Başarılı';
            $message = 'Duyuru başarıyla silindi.'; // Başarı mesajını ayarla

            // Duyuru silindikten sonra $annonce'i boş bırak
            $annonce = []; // Duyuru silindiği için $annonce boş kalacak
            $check = 0; // Duyuru silindiği için check'i güncelle
        }
    }
}
?>

<!-- Sayfa İçeriği -->
<main class="bmd-layout-content">
    <div class="container-fluid">
        <!-- Sayfa Başlığı -->
        <div class="row">
            <div class="page-header breadcrumb-header p-3 m-2">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <div class="d-inline">
                                <h3 class="lite-text">Duyuru Ayarlama ve Değiştirme</h3>
                                <span class="lite-text text-gray">Bu bölümde yöneticiler, önemli bilgileri duyurabilir. Metin alanına yazılan duyuru, "Gönder" butonuna tıklanarak yayınlanabilir veya mevcut duyuru güncellenebilir. Ayrıca, "Mevcut Duyuruyu Sil" butonu ile duyuru kaldırılabilir.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Yönetici</a></li>
                            <li class="breadcrumb-item active">Duyurular</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Duyuru ve Yönetici Bölümleri -->
        <div class="jumbotron shade pt-5">
            <form class="form-group bmd-form-group" method="POST">
                <textarea class="form-control" rows="3" name="text" placeholder="Duyuruyu buraya yazın..."><?php if (isset($annonce['text'])) { echo $annonce['text']; } ?></textarea>
                <hr class="mt-0 mb-2">
                <div class="row">
                    <div class="col-4">
                        <button type="submit" name="action" value="send" class="btn btn-success btn-block">Gönder</button>
                    </div>
                    <div class="col-4">
                        <button type="submit" name="action" value="delete" class="btn btn-danger btn-block">Mevcut Duyuruyu Sil</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Toast Bildirim Container -->
<div id="toast-container" class="toast-top-right">
    <?php if ($message): ?>
        <div class="toast <?php echo $toastClass; ?>" aria-live="assertive" id="toast-notification">
            <div class="toast-title"><?php echo $toastTitle; ?></div>
            <div class="toast-message"><?php echo $message; ?></div>
        </div>
    <?php endif; ?>
</div>

<script>
// Toast bildirimlerini görüntüleme fonksiyonu
function showToast() {
    const toastContainer = document.getElementById('toast-container');
    const toast = document.getElementById('toast-notification');

    // Birkaç saniye sonra tostu otomatik olarak kaldır
    setTimeout(() => {
        toastContainer.removeChild(toast);
    }, 5000);
}

// Mesaj varsa tostu göster
<?php if ($message): ?>
    showToast();
<?php endif; ?>
</script>

<?php require "footer.php"; ?>
