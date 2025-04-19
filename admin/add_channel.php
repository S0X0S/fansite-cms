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
// Yeni bir kanal eklemek için form gönderildiğinde işlem yap
if (isset($_POST['add_channel'])) {
    $channelName = $_POST['channel_name'];
    $channelDescription = $_POST['channel_description'] ?? null;

    $insertQuery = "INSERT INTO channels (name, description) VALUES (?, ?)";
    $stmt = $db->prepare($insertQuery);
    $stmt->execute([$channelName, $channelDescription]);

    echo "Kanal başarıyla eklendi.";
    header("Location: add_channel.php"); // Kanal eklendikten sonra sayfayı yeniden yükleyin
    exit();
}

// Tüm kanalları listele
$channels = $db->query("SELECT * FROM channels")->fetchAll(PDO::FETCH_ASSOC);


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
            <section class="content">
	
	<div class="row pt-4">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                   
                                        <div class="form-row align-items-center">
                                            
          
                
 
						<div class="col-lg-12">

											<div class="breadcrumb float-sm-right">
							 <a href="./rank-permison"><button type="submit" class="btn btn-secondary">Rank Panel İzinlerini Düzenle<div class="ripple-container"></div></button></a>
                                            
                   </div></div>
                            </div>
							

                                       
                       
                                </div>
                            </div>
        <!-- Yeni Kanal Ekleme Formu -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="channel_name">Kanal Adı</label>
                <input type="text" name="channel_name" id="channel_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="channel_description">Kanal Açıklaması (Opsiyonel)</label>
                <textarea name="channel_description" id="channel_description" class="form-control"></textarea>
            </div>
            <button type="submit" name="add_channel" class="btn btn-primary">Kanal Ekle</button>
        </form>

        <!-- Kanal Listesi -->
        <h4>Mevcut Sayfalar</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>Açıklama</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($channels as $channel): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($channel['id']); ?></td>
                        <td><?php echo htmlspecialchars($channel['name']); ?></td>
                        <td><?php echo htmlspecialchars($channel['description']); ?></td>
                        <td>
                            <a href="delete_channel.php?id=<?php echo $channel['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu kanalı silmek istediğinize emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>              </div> 
            </section>
			  </div>
</main>

<?php include 'footer.php'; ?>
