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
// Kategoriyi çekme
if (isset($_GET['id'])) {
    $kategori_id = $_GET['id'];
    $kategori_sor = $db->prepare("SELECT * FROM categories WHERE id = :id");
    $kategori_sor->execute(['id' => $kategori_id]);
    $kategoricek = $kategori_sor->fetch(PDO::FETCH_ASSOC);

    // Eğer kategori bulunamazsa yönlendir
    if (!$kategoricek) {
        header("Location: catagori-list.php?durum=no");
        exit;
    }
}

// Kategoriyi güncelleme
if (isset($_POST['kategori_duzenle'])) {
    $kategori_ad = $_POST['kategori_ad'];
    $kategori_aciklama = $_POST['kategori_aciklama'];

    $duzenle = $db->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
    $update = $duzenle->execute(array(
        'name' => $kategori_ad,
        'description' => $kategori_aciklama,
        'id' => $kategori_id,
    ));

    if ($update) {
        header("Location: catagori-list.php?durum=duzenlendi");
        exit;
    } else {
        header("Location: catagori-list.php?durum=no");
        exit;
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
                                <h3 class="lite-text">Kategori Düzenleme</h3>
                                <span class="lite-text text-gray">
                                    Buradan mevcut kategoriyi düzenleyebilirsiniz.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Yazar</a></li>
                            <li class="breadcrumb-item active">Kategoriler</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Düzenleme Formu -->
        <div class="jumbotron shade pt-5">
            <h1>Kategoriyi Düzenle</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="kategori_ad">Kategori Adı:</label>
                    <input type="text" class="form-control" name="kategori_ad" value="<?php echo htmlspecialchars($kategoricek['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori_aciklama">Açıklama:</label>
                    <textarea class="form-control" name="kategori_aciklama" required><?php echo htmlspecialchars($kategoricek['description']); ?></textarea>
                </div>
                <button type="submit" name="kategori_duzenle" class="btn btn-success">Düzenle</button>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
