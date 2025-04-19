<?php
require "core.php"; // Veritabanı bağlantısı için gerekli dosya
include 'header.php';
// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 10; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}


if (!$db) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Hata ayıklama için PHP hatalarını göster
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Log kaydı fonksiyonu
function logAction($db, $userId, $username, $action, $details) {
    try {
        $stmt = $db->prepare("INSERT INTO logs (user_id, username, action, details, created_at) VALUES (:user_id, :username, :action, :details, NOW())");
        $stmt->execute([
            'user_id' => $userId,
            'username' => $username,
            'action' => $action,
            'details' => $details
        ]);
        echo "Log başarıyla kaydedildi.<br>"; // Hata ayıklama çıktısı
    } catch (PDOException $e) {
        error_log("Log kaydetme hatası: " . $e->getMessage());
        echo "Log kaydetme hatası: " . $e->getMessage(); 
    }
}

// Kullanıcı bilgileri (örnek kullanıcı ID ve kullanıcı adı)
$userId = 1; // Örnek kullanıcı ID'si
$username = "admin"; // Örnek kullanıcı adı

// Mevcut ayarları çek
$sql = "SELECT name, value FROM settings";
$stmt = $db->prepare($sql);
$stmt->execute();
$settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ayarları bir diziye aktar
$settingsArray = [];
foreach ($settings as $setting) {
    $settingsArray[$setting['name']] = $setting['value'];
}

// Ayarlar güncelleme işlemi
if (isset($_POST['settings_update'])) {
    $updated = false; // Güncellenen ayar var mı diye kontrol etmek için flag
    foreach ($_POST['settings'] as $settingName => $settingValue) {
        if ($settingName === 'site_url') {
            echo "Hata: URL değişikliği yapma yetkiniz yok.<br>";
            continue;
        }
        $settingValue = htmlspecialchars($settingValue, ENT_QUOTES, 'UTF-8');

        // Eski ve yeni değerleri karşılaştırma ve log kaydetme
        if ($settingValue !== $settingsArray[$settingName]) {
            $oldValue = $settingsArray[$settingName];
            $newValue = $settingValue;
            $details = "$settingName güncellendi | Eski Değer: $oldValue | Yeni Değer: $newValue";
            logAction($db, $userId, $username, "Ayar Güncelleme", $details); // Log kaydı ekleniyor

            // Ayarı güncelle
            $sql = "UPDATE settings SET value = ? WHERE name = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$settingValue, $settingName]);

            $updated = true; // Eğer ayar güncellendiyse flag'ı true yap
        }
    }

    if ($updated) {
        // Eğer güncelleme yapıldıysa, kullanıcıyı yönlendir
        header("Location: site-settings.php?durum=guncellendi"); // Yönlendirme
        exit(); // Yönlendirme sonrası kodun çalışmasını durdur
    } else {
        // Hiçbir değişiklik yapılmadıysa, farklı bir yönlendirme
        header("Location: site-settings.php?durum=hata");
        exit();
    }
}


?>

<main class="bmd-layout-content">
    <div class="container-fluid">
	<?php include 'notification.php'; ?>
        <!-- Ayar Güncelleme Formu -->
        <div class="jumbotron shade pt-5">
            <h4>Site Ayarları</h4>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Site İsmi</label>
                    <input type="text" name="settings[site_name]" class="form-control" value="<?php echo htmlspecialchars($settingsArray['site_name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Site Açıklaması</label>
                    <input type="text" name="settings[site_description]" class="form-control" value="<?php echo htmlspecialchars($settingsArray['site_description'] ?? ''); ?>" required>
                </div>

                <!-- Anahtar Kelimeler Alanı -->
                <div class="form-group">
                    <label>Anahtar Kelimeler</label>
                    <div id="keywords-container" class="form-control" style="min-height: 60px;">
                        <!-- Dinamik olarak eklenen etiketler burada görüntülenir -->
                    </div>
                    <input type="hidden" name="settings[site_keywords]" id="keywords-input" value="<?php echo htmlspecialchars($settingsArray['site_keywords'] ?? ''); ?>">
                    <input type="text" id="keyword-entry" class="form-control mt-2" placeholder="Anahtar kelime ekle">
                </div>

                <div class="form-group">
                    <label>Site Info</label>
                    <input type="text" name="settings[site_info]" class="form-control" value="<?php echo htmlspecialchars($settingsArray['site_info'] ?? ''); ?>" required>
                </div>
                <button type="submit" name="settings_update" class="btn btn-success mt-3">Ayarları Güncelle</button>
            </form>
        </div>
    </div>
</main>

<script>
// Mevcut anahtar kelimeleri ayıkla ve listele
let keywords = "<?php echo htmlspecialchars($settingsArray['site_keywords'] ?? ''); ?>".split(',');

// Etiketleri görüntülemek için işlev
function renderKeywords() {
    const container = document.getElementById('keywords-container');
    container.innerHTML = '';
    keywords.forEach((keyword, index) => {
        if (keyword.trim() === '') return;
        const tag = document.createElement('span');
        tag.className = 'badge badge-secondary m-1';
        tag.textContent = keyword;
        const removeButton = document.createElement('span');
        removeButton.className = 'ml-1 text-danger';
        removeButton.style.cursor = 'pointer';
        removeButton.textContent = '✖';
        removeButton.onclick = () => {
            keywords.splice(index, 1);
            updateKeywordsInput();
            renderKeywords();
        };
        tag.appendChild(removeButton);
        container.appendChild(tag);
    });
}

// Anahtar kelimeleri güncelleme ve gizli input'a aktarma
function updateKeywordsInput() {
    document.getElementById('keywords-input').value = keywords.join(',');
}

// Yeni anahtar kelime eklemek için işlev
document.getElementById('keyword-entry').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const newKeyword = e.target.value.trim();
        if (newKeyword && !keywords.includes(newKeyword)) {
            keywords.push(newKeyword);
            e.target.value = '';
            updateKeywordsInput();
            renderKeywords();
        }
    }
});

// İlk anahtar kelimeleri yükleme
renderKeywords();
</script>

<style>
/* Basit etiket stili */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    background-color: #6c757d;
    color: #fff;
    border-radius: 15px;
}
</style>

<?php
include 'footer.php';
$db = null; // Veritabanı bağlantısını kapat
?>
