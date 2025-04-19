<?php
require "core.php"; // Veritabanı bağlantısı
include 'header.php';

// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 8; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}

// Arama sorgusu ve veritabanından kullanıcıları çek
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$userSorgu = $db->prepare("
    SELECT 
        u.id, 
        u.staff, 
        u.username, 
        u.born, 
        u.last, 
        u.ban, 
        u.ban_reason, 
        r.name AS rank_name 
    FROM users u 
    LEFT JOIN rank r ON u.staff = r.level 
    WHERE u.username LIKE :searchTerm
");
$userSorgu->execute([':searchTerm' => '%' . $searchTerm . '%']);

?>
<main class="bmd-layout-content">
    <div class="container-fluid">
        <?php include 'notification.php'; ?>
        <div class="jumbotron shade pt-5">
            <section class="content">
                <div class="row pt-4">
                    <div class="col-lg-12">
                        <h2>Kullanıcılar Listesi</h2>
                        
                        <!-- Arama Formu -->
                        <form method="get" action="">
                            <span class="bmd-form-group">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" class="form-control" placeholder="Kullanıcı adı" aria-label="Kullanıcı adı" value="<?php echo htmlspecialchars($searchTerm); ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary c-primary" type="submit" id="button-addon2">
                                            <i class="fab fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </span>
                        </form>

                        <!-- Kullanıcı Tablosu -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Doğum Tarihi</th>
                                    <th>Son Giriş</th>
                                    <th>Ban Durumu</th>

                                    <th>Rank</th>
									              <th>Rank ver / Al</th>
                                    <th>Düzenle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Kullanıcıları listele
                                while ($row = $userSorgu->fetch(PDO::FETCH_ASSOC)) { 
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td>  <?php 
    echo empty($row['born']) ? 'null' : htmlspecialchars(date('Y-m-d H:i', $row['born'])); 
    ?></td>
                                    <td><?php echo htmlspecialchars(date('Y-m-d H:i', $row['last'])); ?></td>
                                    <td><?php echo $row['ban'] == 1 ? 'Banlı' : 'Banlı degil'; ?></td>

                                    <td>
                                        <?php if (!empty($row['rank_name'])): ?>
                                            <?php echo htmlspecialchars($row['rank_name']); ?>
                                        <?php else: ?>
                                            null
                                        <?php endif; ?>
                                    </td>
									<td>
									 <a href="users-rank-edit?id=<?= $row['id'] ?>"><button class="btn btn-danger">Rank Ayarla</button></a>
									</td>
                                    <td>
                                        <!-- Düzenle Butonu -->
                                        <a href="users-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Düzenle</a>
                                       
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
