<?php
require "core.php"; // Veritabanı bağlantısı için gerekli dosya
// Sayfa başlığı
include 'header.php';
// Veritabanı bağlantısını kontrol et
if (!$db) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}
// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 6; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}
// Rank güncelleme işlemi
if (isset($_POST['rank_update'])) {
    // Her bir rank için güncelleme verilerini al
    foreach ($_POST['updates'] as $id => $data) {
        $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');
        $level = (int)$data['level'];

        // Rank güncelleme sorgusu
        $updateSql = "UPDATE rank SET name = ?, description = ?, level = ? WHERE id = ?";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->execute([$name, $description, $level, $id]);
    }

    // Güncelleme başarılı ise yönlendirme yap
    header("Location: rank-list.php?durum=guncellendi");
    exit; // Yönlendirme sonrasında scriptin çalışmasını durdur
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
                                <h3 class="lite-text">Mevcut Rankları Güncelle</h3>
                                <span class="lite-text text-gray">Bu form ile mevcut rank seviyelerini, isimlerini ve açıklamalarını güncelleyebilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Rank Güncelle</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rank Güncelleme Formu -->
        <div class="jumbotron shade pt-5">
            <form action="" method="POST">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank İsmi</th>
                            <th>Açıklama</th>
                            <th>Seviye</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mevcut rankları çek ve göster
                        $query = "SELECT id, name, description, level FROM rank ORDER BY level";
                        foreach ($db->query($query) as $row) {
                            echo "<tr>";
                            echo "<td><input type='text' name='updates[{$row['id']}][name]' value='" . htmlspecialchars($row['name']) . "' class='form-control' required></td>";
                            echo "<td><input type='text' name='updates[{$row['id']}][description]' value='" . htmlspecialchars($row['description']) . "' class='form-control' required></td>";
                            echo "<td><input type='number' name='updates[{$row['id']}][level]' value='{$row['level']}' class='form-control' required></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" name="rank_update" class="btn btn-primary">Güncelle</button>
            </form>
        </div>
    </div>
</main>

<?php
include 'footer.php';
$db = null; // Veritabanı bağlantısını kapat
?>
