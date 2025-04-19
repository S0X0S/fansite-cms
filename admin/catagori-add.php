<?php 
require "core.php"; // Veritabanı bağlantısı
include 'header.php';

// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 5; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}
if (!isset($user['staff']) || $user['staff'] < 8) {
    // Yetki yoksa uyarı mesajı göster ve yönlendir
    echo "<script>alert('Bu sayfaya erişim izniniz yok.'); window.location.href='/admin';</script>";
    exit; // Yetki yoksa işlemi durdur
}
// Kategori ekleme kodu

if (isset($_POST['kategori_ekle'])) {
    $kategori_ad = $_POST['kategori_ad'];
    $kategori_aciklama = $_POST['kategori_aciklama'];

    // Kategori ekleme
    $ekle = $db->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
    $insert = $ekle->execute(array(
        'name' => $kategori_ad,
        'description' => $kategori_aciklama,
    ));

    if ($insert) {
        header("Location: catagori-list.php?durum=ok");
        exit; // header sonrası exit ekleyin
    } else {
        header("Location: catagori-list.php?durum=no");
        exit; // header sonrası exit ekleyin
    }
}
?>
<!-- HTML veya başka bir çıktı burada olmamalı -->

<main class="bmd-layout-content">
    <div class="container-fluid">
        <!-- Sayfa Başlığı -->
        <div class="row">
            <div class="page-header breadcrumb-header p-3 m-2">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <div class="d-inline">
                                <h3 class="lite-text">Haber Ayarlama ve Değiştirme</h3>
                                <span class="lite-text text-gray">
                                    Bu bölümde Yazarlar, önemli haberleri paylaşabilir. Haber başlığı ve açıklaması düzenlenebilir, 
                                    "Gönder" butonuna tıklanarak yayınlanabilir veya mevcut haber güncellenebilir. 
                                    Ayrıca, "Mevcut Haberi Sil" butonu ile haber kaldırılabilir.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Yazar</a></li>
                            <li class="breadcrumb-item active">Haberler</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Haber Listesi -->
        <div class="jumbotron shade pt-5">
            <h1>Kategori Ekle</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="kategori_ad">Kategori Adı:</label>
                    <input type="text" class="form-control" name="kategori_ad" required>
                </div>
                <div class="form-group">
                    <label for="kategori_aciklama">Açıklama:</label>
                    <textarea class="form-control" name="kategori_aciklama"></textarea>
                </div>
                <button type="submit" name="kategori_ekle" class="btn btn-success">Ekle</button>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
