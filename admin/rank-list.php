<?php 
require "core.php";
include 'header.php'; 


// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 6; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}



// Sayfalama ayarları
$limit = isset($_POST['show']) ? (int)$_POST['show'] : 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

// Rank verilerini al (güncellenmiş)
$rankSorgu = $db->prepare("SELECT * FROM rank ORDER BY level DESC LIMIT :limit OFFSET :offset");
$rankSorgu->bindParam(':limit', $limit, PDO::PARAM_INT);
$rankSorgu->bindParam(':offset', $offset, PDO::PARAM_INT);
$rankSorgu->execute();

// Toplam rank sayısını al
$totalRanksSayi = $db->query("SELECT COUNT(*) FROM rank")->fetchColumn();
$totalPages = ceil($totalRanksSayi / $limit); 

// Rank silme işlemi
if (isset($_GET['rank_sil']) && $_GET['rank_sil'] == 'ok' && isset($_GET['rank_id'])) {
    $rank_id = $_GET['rank_id'];

    // Silinen rank'ın bilgilerini al
    $rankSorgu = $db->prepare("SELECT * FROM rank WHERE id = :id");
    $rankSorgu->execute(['id' => $rank_id]);
    $rank = $rankSorgu->fetch(PDO::FETCH_ASSOC);
    
    if ($rank) {
        // Rank'ı veritabanından sil
        $sil = $db->prepare("DELETE FROM rank WHERE id = :id");
        $sil->execute(['id' => $rank_id]);

        // Log kaydı ekle
        logAction($db, $user['id'], $user['username'], 'Rank silindi', 'Rank silindi: ' . $rank['name']);
        header("Location: ./rank-list.php?durum=silindi");
        exit;
    }
}

function logAction($db, $userId, $username, $action, $details) {
    try {
        $stmt = $db->prepare("INSERT INTO logs (user_id, username, action, details, created_at) VALUES (:user_id, :username, :action, :details, NOW())");
        $stmt->execute([
            'user_id' => $userId,
            'username' => $username,
            'action' => $action,
            'details' => $details
        ]);
    } catch (PDOException $e) {
        error_log("Log kaydetme hatası: " . $e->getMessage());
        echo "Log kaydetme hatası: " . $e->getMessage(); 
    }
}
?>

<!-- HTML Kısmı -->

<main class="bmd-layout-content">
    <div class="container-fluid">
	    <?php include 'notification.php'; ?>
        <!-- Sayfa Başlığı -->
        <div class="row">
            <div class="page-header breadcrumb-header p-3 m-2">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <div class="d-inline">
                                <h3 class="lite-text">Rank Listesi</h3>
                                <span class="lite-text text-gray">Bu bölümde rank bilgilerini görüntüleyebilir ve düzenleyebilirsiniz. "Rank Ekle" butonuna tıklayarak yeni bir rank oluşturabilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Ranklar</a></li>
                            <li class="breadcrumb-item active">Rank Listesi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rank Tablosu -->
        <div class="jumbotron shade pt-5">
            <section class="content">
	
	<div class="row pt-4">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                   
                                        <div class="form-row align-items-center">
                                            
          
                
 
						<div class="col-lg-12">
						
                                <div class="breadcrumb float-sm-right">
 <a href="./rank-add"><button class="btn btn-success">Yeni Rank Oluştur</button></a>
                                </div>
											<div class="breadcrumb float-sm-right">
							 <a href="./rank-update"><button type="submit" class="btn btn-secondary">Rankları Düzenle<div class="ripple-container"></div></button></a>
                                            
                   </div>
                            </div>
							

                                       
                       
                                </div>
                            </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Rank Adı</th>
                                    <th>Görevi</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($rankcek = $rankSorgu->fetch(PDO::FETCH_ASSOC)) { 
                                ?>
                                <tr id="rank-<?php echo $rankcek['id']; ?>">
                                    <td><?php echo $rankcek['id']; ?></td>
                                    <td><?php echo htmlspecialchars($rankcek['name']); ?></td> <!-- Only show rank name -->
                                    <td><?php echo htmlspecialchars($rankcek['description']); ?></td> <!-- Assuming you have a role column -->
                                    <td><a href="?rank_sil=ok&rank_id=<?= $rankcek['id'] ?>"><button class="btn btn-danger">Sil</button></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Sayfalama -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>">Önceki</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>">Sonraki</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
