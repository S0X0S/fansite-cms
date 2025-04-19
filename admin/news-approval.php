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
 

// Sayfalama ayarları
$limit = isset($_POST['show']) ? (int)$_POST['show'] : 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

// Sadece validity = 0 olan haberleri al
$newsSorgu = $db->prepare("SELECT n.*, k.name AS kategori_name 
                             FROM news n
                             LEFT JOIN categories k ON n.category_id = k.id 
                             WHERE n.validity = 0
                             ORDER BY n.id DESC 
                             LIMIT :limit OFFSET :offset");
$newsSorgu->bindParam(':limit', $limit, PDO::PARAM_INT);
$newsSorgu->bindParam(':offset', $offset, PDO::PARAM_INT);
$newsSorgu->execute();

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
                        <h3 class="lite-text">Bekleyen Haberler</h3>
                        <span class="lite-text text-gray">Onay bekleyen Haberler</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Haberler</a></li>
                    <li class="breadcrumb-item active">Bekleyen Haberler</li>
                </ol>
            </div>
        </div>
    </div>
</div>
        <div class="jumbotron shade pt-5">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Yazar ID</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($newscek = $newsSorgu->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $newscek['id']; ?></td>
                        <td><?php echo htmlspecialchars($newscek['title']); ?></td>
                        <td><?php echo htmlspecialchars($newscek['descr']); ?></td>
                        <td><?php echo htmlspecialchars($newscek['author']); ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $newscek['post_at']); ?></td>
                        <td>
                            <a href="news-preview.php?id=<?= $newscek['id'] ?>" class="btn btn-info">Ön İzleme</a>
                            <a href="news-publish.php?id=<?= $newscek['id'] ?>" class="btn btn-success">Yayınla</a>

                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>