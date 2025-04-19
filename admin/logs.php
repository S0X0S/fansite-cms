<?php
require "core.php"; // Veritabanı bağlantısı
include 'header.php';

// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 7; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}

// Ayarları
$limit = 10; // Her sayfada gösterilecek kayıt sayısı
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Arama sorgusu
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$actionFilter = isset($_GET['action']) ? $_GET['action'] : '';

// Log sorgusu
$query = "SELECT * FROM logs WHERE username LIKE :searchTerm";
if ($actionFilter) {
    $query .= " AND action = :action";
}
$query .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

$logSorgu = $db->prepare($query);
$logSorgu->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
if ($actionFilter) {
    $logSorgu->bindValue(':action', $actionFilter, PDO::PARAM_STR);
}
$logSorgu->bindValue(':limit', $limit, PDO::PARAM_INT);
$logSorgu->bindValue(':offset', $offset, PDO::PARAM_INT);
$logSorgu->execute();

// Toplam kayıt sayısını al
$totalQuery = "SELECT COUNT(*) FROM logs WHERE username LIKE :searchTerm";
if ($actionFilter) {
    $totalQuery .= " AND action = :action";
}
$totalSorgu = $db->prepare($totalQuery);
$totalSorgu->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
if ($actionFilter) {
    $totalSorgu->bindValue(':action', $actionFilter, PDO::PARAM_STR);
}
$totalSorgu->execute();
$totalLogs = $totalSorgu->fetchColumn();
$totalPages = ceil($totalLogs / $limit);

// Eşsiz işlemleri al
$actionQuery = "SELECT DISTINCT action FROM logs";
$actionSorgu = $db->prepare($actionQuery);
$actionSorgu->execute();
$actions = $actionSorgu->fetchAll(PDO::FETCH_COLUMN);
?>

<main class="bmd-layout-content">
    <div class="container-fluid">
        <?php include 'notification.php'; ?>
        <div class="jumbotron shade pt-5">
            <section class="content">
                <div class="row pt-4">
                    <div class="col-lg-12">
                        <h2>Log Listesi</h2>

                        <!-- Arama Formu -->
                        <form method="get" action="">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Kullanıcı ID Ara" value="<?php echo htmlspecialchars($searchTerm); ?>">
                                <select name="action" class="form-control">
                                    <option value="">Tüm İşlemler</option>
                                    <?php foreach ($actions as $action): ?>
                                        <option value="<?php echo htmlspecialchars($action); ?>" <?php echo ($actionFilter == $action) ? 'selected' : ''; ?>><?php echo htmlspecialchars($action); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Ara</button>
                                </div>
                            </div>
                        </form>

                        <!-- Log Tablosu -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kullanıcı ID</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>İşlem</th>
                                    <th>Açıklama</th>
                                    <th>Tarih</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Logları listele
                                while ($row = $logSorgu->fetch(PDO::FETCH_ASSOC)) { 
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                                    <td><?php echo htmlspecialchars($row['details']); ?></td>
                                    <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($row['created_at']))); ?></td>
                                    <td>

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
