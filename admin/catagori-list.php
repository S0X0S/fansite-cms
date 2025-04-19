<?php 
require "core.php"; // Veritabanı bağlantısı
include 'header.php';

// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 4; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}

// Sayfalama ayarları
$limit = isset($_POST['show']) ? (int)$_POST['show'] : 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

// Kategorileri al
$kategoriSorgu = $db->query("SELECT * FROM categories ORDER BY id ASC LIMIT $limit OFFSET $offset");
$kategoriler = $kategoriSorgu->fetchAll(PDO::FETCH_ASSOC);

// Toplam kategori sayısını bul
$totalKategoriler = $db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$totalPages = ceil($totalKategoriler / $limit); 
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
                                <h3 class="lite-text">Kategori Listesi</h3>
                                <span class="lite-text text-gray">Bu bölümde mevcut kategorileri görüntüleyebilir, yeni kategoriler ekleyebilir veya var olanları düzenleyebilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active">Kategoriler</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Filtreleme ve Listeleme -->
        <div class="jumbotron shade pt-5">
            <section class="content">
                <div class="row pt-4">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <form method="POST" action="catagori-list.php">
                                    <select name="show" class="form-control mr-2" style="width: 200px;">
                                        <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
                                        <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                                        <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
                                    </select>
                                    <button type="submit" class="btn btn-secondary">Göster</button>
                                </form>
                            </div>
                            <div class="col-lg-7">
                                <div class="breadcrumb float-sm-right">
                                    <a href="catagori-add.php"><button class="btn btn-success">Kategori Ekle</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kategori Adı</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kategoriler as $kategori): ?>
                        <tr>
                            <td><?= $kategori['id'] ?></td>
                            <td><?= htmlspecialchars($kategori['name']) ?></td>
                            <td><a href="catagori-edit.php?id=<?= $kategori['id'] ?>"><button class="btn btn-warning">Düzenle</button></a></td>
                        </tr>
                        <?php endforeach; ?>
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
            </section>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
