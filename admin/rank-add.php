<?php
require "core.php"; // Veritabanı bağlantısı için gerekli dosya
include 'header.php';
// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 6; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}
// Veritabanı bağlantısını kontrol et
if (!$db) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Rank ekleme işlemi
if (isset($_POST['rank_add'])) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $level = (int)$_POST['level']; // Seviye

    // Seviye mevcut mu kontrol et
    $checkSql = "SELECT COUNT(*) FROM rank WHERE level = ?";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->execute([$level]);
    $levelExists = $checkStmt->fetchColumn();

    if ($levelExists > 0) {
        echo "Hata: Seçtiğiniz seviye zaten mevcut.";
    } else {
        // Veritabanına rank ekleme sorgusu
        $sql = "INSERT INTO rank (name, description, level) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$name, $description, $level]);

        echo "Yeni rank başarıyla eklendi.";
        header("Location: rank-list.php"); // Başarılı eklemeden sonra yönlendirme
        exit();
    }
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
                                <h3 class="lite-text">Rank Ekle</h3>
                                <span class="lite-text text-gray">Bu formu doldurarak yeni rank ekleyebilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Rank Ekle</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rank Ekleme Formu -->
        <div class="jumbotron shade pt-5">
            <form action="" method="POST">
                <div class="form-group">
                    <label>Rank İsmi</label>
                    <input type="text" name="name" class="form-control" placeholder="Rank İsmi" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <input type="text" name="description" class="form-control" placeholder="Görev Açıklaması" required>
                </div>
                <div class="form-group">
                    <label>Seviye</label>
                    <input type="number" name="level" class="form-control" placeholder="Seviye" required>
                </div>
                <button type="submit" name="rank_add" class="btn btn-success">Rank Ekle</button>
            </form>
        </div>

    </div>
</main>

<?php
include 'footer.php';
$db = null; // Veritabanı bağlantısını kapat
?>
