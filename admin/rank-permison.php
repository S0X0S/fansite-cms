<?php
require "core.php"; // Veritabanı bağlantısı
include 'header.php';

// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 11; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}
// Veritabanından tüm rank ve kanalları çek
$ranks = $db->query("SELECT id, name FROM rank")->fetchAll(PDO::FETCH_ASSOC);
$channels = $db->query("SELECT id, name FROM channels")->fetchAll(PDO::FETCH_ASSOC); // Kanal tablosunun adını düzenleyin

// Rank ve kanal izinlerini kaydet
if (isset($_POST['save_permissions'])) {
    foreach ($ranks as $rank) {
        foreach ($channels as $channel) {
            $permissionValue = isset($_POST['permissions'][$rank['id']][$channel['id']]) ? 1 : 0;

            // Mevcut izin durumu kontrolü
            $checkQuery = "SELECT COUNT(*) FROM rank_channel_permissions WHERE rank_id = ? AND channel_id = ?";
            $checkStmt = $db->prepare($checkQuery);
            $checkStmt->execute([$rank['id'], $channel['id']]);
            $exists = $checkStmt->fetchColumn();

            if ($exists) {
                // İzin güncelle
                $updateQuery = "UPDATE rank_channel_permissions SET can_view = ? WHERE rank_id = ? AND channel_id = ?";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->execute([$permissionValue, $rank['id'], $channel['id']]);
            } else {
                // Yeni izin ekle
                $insertQuery = "INSERT INTO rank_channel_permissions (rank_id, channel_id, can_view) VALUES (?, ?, ?)";
                $insertStmt = $db->prepare($insertQuery);
                $insertStmt->execute([$rank['id'], $channel['id'], $permissionValue]);
            }
        }
    }

    echo "İzinler başarıyla kaydedildi.";
    header("Location: ./rank-permison"); // Kaydettikten sonra sayfayı yeniden yükle
    exit();
}


?>

<main class="bmd-layout-content">
    <div class="container-fluid">
        <!-- Sayfa Başlığı -->
        <div class="row">
            <div class="page-header breadcrumb-header p-3 m-2">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <div class="d-inline">
                                <h3 class="lite-text">Admin Panel İzin</h3>
                                <span class="lite-text text-gray">Admin panel sayfa izinleri ve rank kısıtlaması ayarları</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Kurucu</a></li>
                            <li class="breadcrumb-item active">Sayfa Düzeni</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="jumbotron shade pt-5">
    <div class="container-fluid">
        <h3>Panel Erişim İzinleri</h3>
        <form action="" method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <?php foreach ($channels as $channel): ?>
                            <th><?php echo htmlspecialchars($channel['name']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ranks as $rank): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($rank['name']); ?></td>
                            <?php foreach ($channels as $channel): 
                                // Mevcut izin durumu
                                $permissionQuery = "SELECT can_view FROM rank_channel_permissions WHERE rank_id = ? AND channel_id = ?";
                                $permissionStmt = $db->prepare($permissionQuery);
                                $permissionStmt->execute([$rank['id'], $channel['id']]);
                                $canView = $permissionStmt->fetchColumn();
                            ?>
                                <td>
                                    <input type="checkbox" name="permissions[<?php echo $rank['id']; ?>][<?php echo $channel['id']; ?>]" <?php echo $canView ? 'checked' : ''; ?>>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="save_permissions" class="btn btn-primary">İzinleri Kaydet</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
