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
$author_id = $user['id']; // Oturum açmış kullanıcı ID'si yoksa 0 olarak belirler
$username = $user['username']; // Kullanıcının adı veya rumuzu

// Bağlantıyı kontrol et
if (isset($_POST['news_add'])) {
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $descr = htmlspecialchars($_POST['descr'], ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    $background = htmlspecialchars($_POST['background'], ENT_QUOTES, 'UTF-8'); // Öne çıkan fotoğraf URL
    $validity = (int)$_POST['validity']; // Geçerlilik durumu
    $category_id = (int)$_POST['category_id']; // Kategori ID'sini al

    // Haber eklemek için SQL sorgusu
    $sql = "INSERT INTO news (title, descr, text, author, corrector, post_at, validity, category_id, background) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $post_at = time(); // Şu anki zamanı al
    $corrector = ''; // İlk eklemede boş olacak

    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $descr);
    $stmt->bindParam(3, $text);
    $stmt->bindParam(4, $author_id); // Otomatik alınan yazar ID'si
    $stmt->bindParam(5, $corrector);
    $stmt->bindParam(6, $post_at);
    $stmt->bindParam(7, $validity);
    $stmt->bindParam(8, $category_id);
    $stmt->bindParam(9, $background); // Öne çıkan fotoğraf URL
    $validity = 0; 

if ($stmt->execute()) {
        // Haber başarıyla eklendiğinde logs tablosuna kayıt ekle
        $log_sql = "INSERT INTO logs (user_id, username, action, details, created_at) VALUES (?, ?, ?, ?, ?)";
        $log_stmt = $db->prepare($log_sql);
        $action = "Haber eklendi";
        $details = "Eklenen haber başlığı: " . $title;
        $created_at = date("Y-m-d H:i:s");

        $log_stmt->bindParam(1, $author_id);
        $log_stmt->bindParam(2, $username);
        $log_stmt->bindParam(3, $action);
        $log_stmt->bindParam(4, $details);
        $log_stmt->bindParam(5, $created_at);

        if ($log_stmt->execute()) {
            echo "Yeni haber ve log kaydı başarıyla eklendi.";
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
                                <h3 class="lite-text">Haber Ekleme</h3>
                                <span class="lite-text text-gray">Bu bölümde Yazarlar, yeni haber ekleyebilir. Aşağıdaki formu doldurarak haber başlığı, açıklaması ve içeriğini ekleyebilirsiniz. "Ekle" butonuna tıklayarak haberinizi yayınlayabilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Yazar</a></li>
                            <li class="breadcrumb-item active">Haber Ekleme</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Haber Ekleme Formu -->
        <div class="jumbotron shade pt-5">

                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Başlık</label>
                                <input type="text" name="title" class="form-control" placeholder="Haber Başlığı" required>
                            </div>
                        <div class="form-group">
                            <label>Açıklama</label>
                            <textarea name="descr" class="form-control" placeholder="Açıklama" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Metin</label>

                            <textarea  name="text" class="trumbowyg-textarea" placeholder="Haber Metni" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Öne Çıkan Fotoğraf (URL)</label>
                            <input type="url" name="background" class="form-control" placeholder="Fotoğraf URL" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Kategori Seçin</option>
                                <?php while ($row = $category_result->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" name="news_add" class="btn btn-success">Ekle</button>
                    </form>

    </section>
</div>
<script>
$('#editor')
.trumbowyg({
    btns: [
        'viewHTML',
        'h4'
    ],
    plugins: {
        allowTagsFromPaste: {
            allowedTags: ['h4', 'p', 'br']
        }
    }
});
     
</script>
<?php include 'footer.php'; ?>

<?php
$db = null; // Veritabanı bağlantısını kapat
?>
