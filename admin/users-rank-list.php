<?php 
require "core.php"; // Veritabanı bağlantısı
include 'header.php';

// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 12; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}

// Sayfalama ayarları
$limit = isset($_POST['show']) ? (int)$_POST['show'] : 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

// Rank ve users tablolarını eşleştirerek veri al
$rankSorgu = $db->prepare("
    SELECT users.id AS user_id, users.username, users.staff, rank.id AS rank_id, rank.name, rank.level 
    FROM users 
    JOIN rank ON users.staff = rank.level 
    WHERE users.staff NOT IN (1, 0)  -- staff değeri 1 veya 0 olan kullanıcıları hariç tut
    ORDER BY rank.level DESC 
    LIMIT :limit OFFSET :offset
");
$rankSorgu->bindParam(':limit', $limit, PDO::PARAM_INT);
$rankSorgu->bindParam(':offset', $offset, PDO::PARAM_INT);
$rankSorgu->execute();

// Toplam eşleşen kullanıcı sayısını al
$totalRanksSayi = $db->query("
    SELECT COUNT(*) 
    FROM users 
    JOIN rank ON users.staff = rank.level
    WHERE users.staff NOT IN (1, 0)
")->fetchColumn();
$totalPages = ceil($totalRanksSayi / $limit); 

// Rank listesi gösterimi
?>
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
                                <h3 class="lite-text">Yetkili</h3>
                                <span class="lite-text text-gray">Bu bölümde görevli kişilerin ranklarını güncelleye bilir  görüntüleyebilir ve düzenleyebilirsiniz. "Düzenle" butonuna tıklayarak düzenleme yapabilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Yönetici</a></li>
                            <li class="breadcrumb-item active">Rank düzenleme</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rank Tablosu -->
        <div class="jumbotron shade pt-5">
            <section class="content">
                <div class="row pt-4">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Kullanıcı</th>
                                    <th>Görevi</th>
                                    <th>İşlem</th> <!-- Yeni sütun: İşlem -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row = $rankSorgu->fetch(PDO::FETCH_ASSOC)) { 
                                ?>
                                <tr>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td>
                                        <!-- Düzenle butonu -->
                                        <a href="users-rank-edit?id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm">Düzenle</a>
                                    </td>
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
