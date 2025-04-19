<?php 
require "core.php";
include 'header.php'; 



// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 1; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}










// Sayfalama ayarları
$limit = isset($_POST['show']) ? (int)$_POST['show'] : 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

// Kategori verilerini al
$kategoriSorgu = $db->query("SELECT * FROM categories ORDER BY id ASC");
$kategoriler = $kategoriSorgu->fetchAll(PDO::FETCH_ASSOC);

// Kategori seçimi için sorgu oluştur
if (isset($_POST['kategori_sec'])) {
    $kategori = $_POST['kategori'];
    if ($kategori == '') {
        // Tüm haberler
        $newsSorgu = $db->prepare("SELECT n.*, k.name AS kategori_name 
                                     FROM news n
                                     LEFT JOIN categories k ON n.category_id = k.id 
                                     ORDER BY n.id DESC 
                                     LIMIT :limit OFFSET :offset");
    } else {
        // Belirli kategori
        $newsSorgu = $db->prepare("SELECT n.*, k.name AS kategori_name 
                                     FROM news n
                                     LEFT JOIN categories k ON n.category_id = k.id 
                                     WHERE k.id = :kategori 
                                     ORDER BY n.id DESC 
                                     LIMIT :limit OFFSET :offset");
        $newsSorgu->bindParam(':kategori', $kategori, PDO::PARAM_INT);
    }
    $newsSorgu->bindParam(':limit', $limit, PDO::PARAM_INT);
    $newsSorgu->bindParam(':offset', $offset, PDO::PARAM_INT);
    $newsSorgu->execute();
} else {
    // Tüm haberler
    $newsSorgu = $db->prepare("SELECT n.*, k.name AS kategori_name 
                                 FROM news n
                                 LEFT JOIN categories k ON n.category_id = k.id 
                                 ORDER BY n.id DESC 
                                 LIMIT :limit OFFSET :offset");
    $newsSorgu->bindParam(':limit', $limit, PDO::PARAM_INT);
    $newsSorgu->bindParam(':offset', $offset, PDO::PARAM_INT);
    $newsSorgu->execute();
}

// Toplam haber sayısını al
$totalNewsSayi = $db->query("SELECT COUNT(*) FROM news")->fetchColumn();
$totalPages = ceil($totalNewsSayi / $limit); 

// Haber ekleme işlemi
if (isset($_POST['newsekle'])) {
    $kaydet = $db->prepare("INSERT INTO news (title, descr, text, author, post_at, validity, background, corrector, category_id) VALUES (:title, :descr, :text, :author, :post_at, :validity, :background, :corrector, :kategori)");
    $insert = $kaydet->execute(array(
        'title' => $_POST['news_title'],
        'descr' => $_POST['news_descr'],
        'text' => $_POST['news_text'],
        'author' => $_POST['news_author'], 
        'post_at' => time(),
        'validity' => isset($_POST['validity']) ? 1 : 0,
        'background' => $_POST['background'] ?? NULL,
        'corrector' => $_POST['corrector'] ?? 0,
        'kategori' => $_POST['news_kategori']
    ));

    if ($insert) {
        // Log kaydı ekle
        logAction($db, $user['id'], $user['username'], 'Haber Ekle', 'Haber eklendi: ' . $_POST['news_title']);
        header("Location: ./news.php?durum=ok");
        exit;
    } else {
        header("Location: ./news.php?durum=no");
        exit;
    }
}

// Haber silme işlemi
if (isset($_GET['newsil']) && $_GET['newsil'] == 'ok' && isset($_GET['news_id'])) {
    $news_id = $_GET['news_id'];

    // Silinen haberin bilgilerini al
    $newsSorgu = $db->prepare("SELECT title FROM news WHERE id = :id");
    $newsSorgu->execute(['id' => $news_id]);
    $news = $newsSorgu->fetch(PDO::FETCH_ASSOC);
    
    if ($news) {
        // Haberi veritabanından sil
        $sil = $db->prepare("DELETE FROM news WHERE id = :id");
        $sil->execute(['id' => $news_id]);

        // Log kaydı ekle
        logAction($db, $user['id'], $user['username'], 'Haber silindi', 'Haber silindi başlıgı: ' . $news['title']);
        header("Location: ./news.php?durum=silindi");
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
        <!-- Sayfa Başlığı -->
<div class="row">
    <div class="page-header breadcrumb-header p-3 m-2">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h3 class="lite-text">Haber Listesi</h3>
                        <span class="lite-text text-gray">Bu bölümde yazarlar, mevcut haberleri görüntüleyebilir. Aşağıdaki form ile yeni haberler ekleyebilir ya da var olan haberleri güncelleyebilirsiniz. "Haber Ekle" butonuna tıklayarak yeni bir haber oluşturabilirsiniz.</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Haberler</a></li>
                    <li class="breadcrumb-item active">Haber Listesi</li>
                </ol>
            </div>
        </div>
    </div>
</div>


        <!-- Duyuru ve Yönetici Bölümleri -->
        <div class="jumbotron shade pt-5">

    <section class="content">
	
	<div class="row pt-4">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                   
                                        <div class="form-row align-items-center">
                                            <div class="col0">
          
                
                        <form method="POST" action="news.php" >
                            <select name="kategori" class="form-control mr-2" style="width: 200px;">
                                <option value="">Tüm Kategoriler</option>
                                <?php foreach ($kategoriler as $kategori): ?>
                                    <option value="<?= $kategori['id'] ?>"><?= htmlspecialchars($kategori['name']) ?></option>
                                <?php endforeach; ?>
                            </select></span>
							
							            </div>
                            <button type="submit" name="kategori_sec" class="btn btn-primary">Filtrele</button>	
                        </form>

                           
                     
                                          
						 <div class="col0">
                        <form method="POST" action="news.php" >
						<span class="bmd-form-group is-filled">
                            <select name="show" class="form-control mr-2" style="width: 200px;">
                                <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
                                <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                            </select>
							</div>
                            <button type="submit" class="btn btn-secondary">Göster</button>
                        </form>
						<div class="col-lg-7">
                                <div class="breadcrumb float-sm-right">
 <a href="./news-add"><button class="btn btn-success">Haber Ekle</button></a>
                                </div>
                            </div>
                                            
                  
                                        </div>
                       
                                </div>
                            </div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
                        <!-- Silme mesajı -->
                        <?php if (isset($_GET['durum'])): ?>
                            <?php if ($_GET['durum'] == 'silindi'): ?>
                                <div class="alert alert-warning" role="alert">
                                    Haber başarıyla silindi. 
                                </div>
                                <script>
                                    setTimeout(function() {
                                        window.location.href = "news.php"; 
                                    }, 3000);
                                </script>
                            <?php elseif ($_GET['durum'] == 'silme_hatasi'): ?>
                                <div class="alert alert-danger" role="alert">
                                    Haber silinirken bir hata oluştu.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Başlık</th>
                                    <th>Açıklama</th>
                                    <th>Yazar ID</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>Geçerlilik</th>
                                    <th>Düzenle</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $say = 0;
                                while ($newscek = $newsSorgu->fetch(PDO::FETCH_ASSOC)) { 
                                    $say++;
                                ?>
                                <tr id="news-<?php echo $newscek['id']; ?>">
                                    <td><?php echo $newscek['id']; ?></td>
                                    <td><?php echo htmlspecialchars($newscek['title']); ?></td>
                                    <td><?php echo htmlspecialchars($newscek['descr']); ?></td>
                                    <td><?php echo htmlspecialchars($newscek['author']); ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $newscek['post_at']); ?></td>
                                    <td><?php echo $newscek['validity'] == 1 ? 'Aktif' : 'Pasif'; ?></td>
                                    <td><a href="news-edit.php?id=<?= $newscek['id'] ?>"><button class="btn btn-warning">Düzenle</button></a></td>
                                    <td><a href="?newsil=ok&news_id=<?= $newscek['id'] ?>"><button class="btn btn-danger">Sil</button></a></td>
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

    </section>
</div>

<?php include 'footer.php'; ?>
