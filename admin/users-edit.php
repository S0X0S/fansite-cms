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

// Kullanıcı ID'sini al
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kullanıcı bilgilerini al
$userSorgu = $db->prepare("SELECT * FROM users WHERE id = :userId");
$userSorgu->bindParam(':userId', $userId, PDO::PARAM_INT);
$userSorgu->execute();
$user = $userSorgu->fetch(PDO::FETCH_ASSOC);

// Kullanıcı güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff = $_POST['staff'];
    $ban = $_POST['ban'];
    $banReason = isset($_POST['ban_reason']) ? $_POST['ban_reason'] : null; // Ban nedeni

    // Kullanıcıyı güncelle
    $updateSorgu = $db->prepare("UPDATE users SET staff = :staff, ban = :ban, ban_reason = :banReason WHERE id = :userId");
    $updateSorgu->bindParam(':staff', $staff);
    $updateSorgu->bindParam(':ban', $ban);
    $updateSorgu->bindParam(':banReason', $banReason);
    $updateSorgu->bindParam(':userId', $userId);
    
    if ($updateSorgu->execute()) {
        // Başarılı güncelleme sonrası yönlendirme
        header("Location: users-list.php?durum=guncellendi");
        exit();
    } else {
        echo "Kullanıcı güncellenirken bir hata oluştu.";
    }
}
?>

<main class="bmd-layout-content">
    <div class="container-fluid">
        <div class="jumbotron shade pt-5">
            <section class="content">
                <div class="row pt-4">
                    <div class="col-lg-12">
                        <h2>Kullanıcı Düzenle</h2>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">

                            <div class="form-group">
                                <label for="username">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="ban">Ban Durumu</label>
                                <select class="form-control" id="ban" name="ban" onchange="toggleBanReason()">
                                    <option value="0" <?php echo ($user['ban'] == 0) ? 'selected' : ''; ?>>Banlı Değil</option>
                                    <option value="1" <?php echo ($user['ban'] == 1) ? 'selected' : ''; ?>>Banla</option>
                                </select>
                            </div>

                            <div class="form-group" id="banReasonContainer" style="display: <?php echo ($user['ban'] == 1) ? 'block' : 'none'; ?>;">
                                <label for="ban_reason">Ban Nedeni</label>
                                <input type="text" class="form-control" id="ban_reason" name="ban_reason" value="<?php echo htmlspecialchars($user['ban_reason']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="look">Görünüm</label>
                                <input type="text" class="form-control" id="look" name="look" value="<?php echo htmlspecialchars($user['look']); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="born">Doğum Tarihi</label>
                                <input type="text" class="form-control" id="born" name="born" value="  <?php 
    echo empty($row['born']) ? 'null' : htmlspecialchars(date('Y-m-d H:i', $row['born'])); 
    ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="last">Son Görülme</label>
                                <input type="datetime-local" class="form-control" id="last" name="last" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', $user['last'])); ?>" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">Düzenle</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<script>
    function toggleBanReason() {
        var banSelect = document.getElementById("ban");
        var banReasonContainer = document.getElementById("banReasonContainer");
        banReasonContainer.style.display = (banSelect.value == "1") ? "block" : "none";
    }
</script>

<?php include 'footer.php'; ?>
