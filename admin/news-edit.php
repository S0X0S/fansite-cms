<?php
require "core.php"; // Ensure this file establishes the $db variable
include 'header.php';


// Kullanıcı ID bilgisi
$author_id = $user['id']; 

// Kanal ID'sini belirt
$channel_id = 2; 

// Kullanıcı izinlerini kontrol et
if (!check_user_permissions($db, $author_id, $channel_id)) {
    die("Bu kanalda haber eklemek için izniniz yok.");
}


// Check if connection is established
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Kullanıcı ID bilgisi (örneğin, oturum açmış kullanıcı bilgisi)
$corrector_id = $user['id']; // Oturum açmış kullanıcının ID'si
$username = $user['username']; // Kullanıcının adı veya rumuzu

// Eğer haber güncelleniyorsa
if (isset($_POST['news_update'])) {
    $news_id = (int)$_POST['news_id']; // Güncellenecek haberin ID'si
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $descr = htmlspecialchars($_POST['descr'], ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    $background = htmlspecialchars($_POST['background'], ENT_QUOTES, 'UTF-8'); // Öne çıkan fotoğraf URL
    $validity = (int)$_POST['validity']; // Geçerlilik durumu
    $category_id = (int)$_POST['category_id']; // Kategori ID'sini al

    // Haber güncellemek için SQL sorgusu
    $sql = "UPDATE news SET title = ?, descr = ?, text = ?, corrector = ?, validity = ?, category_id = ?, background = ? WHERE id = ?";
    $stmt = $db->prepare($sql);

    // Parametreleri bağla
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $descr);
    $stmt->bindParam(3, $text);
    $stmt->bindParam(4, $corrector_id); // Güncelleyen kullanıcı ID'si
    $stmt->bindParam(5, $validity);
    $stmt->bindParam(6, $category_id);
    $stmt->bindParam(7, $background);
    $stmt->bindParam(8, $news_id); // Güncellenecek haberin ID'si

    if ($stmt->execute()) {
        // Başarıyla güncellendiğinde logs tablosuna kayıt ekle
        $log_sql = "INSERT INTO logs (user_id, username, action, details, created_at) VALUES (?, ?, ?, ?, ?)";
        $log_stmt = $db->prepare($log_sql);
        $action = "Haber güncellendi";
        $details = "Güncellenen haber ID: " . $news_id . ", Yeni başlık: " . $title;
        $created_at = date("Y-m-d H:i:s");

        // Log kaydı için parametreleri bağla
        $log_stmt->bindParam(1, $corrector_id); // Güncelleyen kullanıcı ID'si
        $log_stmt->bindParam(2, $username);
        $log_stmt->bindParam(3, $action);
        $log_stmt->bindParam(4, $details);
        $log_stmt->bindParam(5, $created_at);

        if ($log_stmt->execute()) {
            echo "Haber başarıyla güncellendi ve log kaydı eklendi.";
        } else {
            echo "Log kaydı eklenirken hata oluştu: " . $log_stmt->errorInfo()[2];
        }

        header("Location: news.php");
        exit();
    } else {
        echo "Hata: " . $stmt->errorInfo()[2];
    }

    $stmt->closeCursor();
}

// Haber güncellenmeden önce mevcut verileri almak için
if (isset($_GET['id'])) {
    $news_id = (int)$_GET['id'];
    $news_sql = "SELECT * FROM news WHERE id = ?";
    $news_stmt = $db->prepare($news_sql);
    $news_stmt->bindParam(1, $news_id);
    $news_stmt->execute();
    $news_data = $news_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$news_data) {
        die("Haber bulunamadı.");
    }
} else {
    die("Geçersiz istek.");
}

// Fetch categories from the database using PDO
$category_sql = "SELECT * FROM categories"; // Query to fetch categories
$category_result = $db->query($category_sql); // Execute the query

// Check if the query was successful
if ($category_result === false) {
    die("Error fetching categories: " . $db->errorInfo()[2]);
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
                                <h3 class="lite-text">Haber Güncelleme</h3>
                                <span class="lite-text text-gray">Bu bölümde var olan haberleri güncelleyebilirsiniz. Aşağıdaki formu doldurarak haber başlığını, açıklamasını ve içeriğini güncelleyebilirsiniz. "Güncelle" butonuna tıklayarak güncellemelerinizi kaydedebilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Yazar</a></li>
                            <li class="breadcrumb-item active">Haber Güncelleme</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Haber Güncelleme Formu -->
        <div class="jumbotron shade pt-5">
            <form action="" method="POST">
                <input type="hidden" name="news_id" value="<?= htmlspecialchars($news_data['id'], ENT_QUOTES, 'UTF-8') ?>">
                <div class="form-group">
                    <label>Başlık</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($news_data['title'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="descr" class="form-control" required><?= htmlspecialchars($news_data['descr'], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Metin</label>
                    <textarea name="text" class="form-control" required><?= htmlspecialchars($news_data['text'], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Öne Çıkan Fotoğraf (URL)</label>
                    <input type="url" name="background" class="form-control" value="<?= htmlspecialchars($news_data['background'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Kategori Seçin</option>
                        <?php while ($row = $category_result->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?>" <?= $row['id'] == $news_data['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="news_update" class="btn btn-success">Güncelle</button>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<?php
$db = null; // Veritabanı bağlantısını kapat
?>
