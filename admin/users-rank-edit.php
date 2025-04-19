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

// Kullanıcının rank seviyesini güncelle
if (isset($_POST['update_rank'])) {
    $user_id = $_POST['user_id'];
    $new_rank_id = $_POST['level'];

    // Seçilen rank'ın level değerini al
    if ($new_rank_id == 0) {
        $new_level = 0; // Sıfırlama işlemi
    } else {
        $rankSorgu = $db->prepare("SELECT level FROM rank WHERE id = :id");
        $rankSorgu->execute(['id' => $new_rank_id]);
        $rank = $rankSorgu->fetch(PDO::FETCH_ASSOC);
        
        if ($rank) {
            $new_level = $rank['level'];
        } else {
            header("Location: users-list.php?durum=hata");
            exit;
        }
    }

    // Mevcut kullanıcının seviyesini al
    $currentUserSorgu = $db->prepare("SELECT staff FROM users WHERE id = :id");
    $currentUserSorgu->execute(['id' => $user['id']]);
    $currentUser = $currentUserSorgu->fetch(PDO::FETCH_ASSOC);

    // Güncellenmek istenen kullanıcının seviyesini al
    $targetUserSorgu = $db->prepare("SELECT staff FROM users WHERE id = :id");
    $targetUserSorgu->execute(['id' => $user_id]);
    $targetUser = $targetUserSorgu->fetch(PDO::FETCH_ASSOC);

    // Eğer kullanıcı kendisine rank vermeye çalışıyorsa
    if ($user_id == $user['id']) {
        header("Location: users-list.php?durum=hata&mesaj=Kendinize rank veremezsiniz.");
        exit;
    }

    // Eğer mevcut kullanıcının seviyesi, hedef kullanıcının seviyesinden yüksekse güncellemeyi yapma
    if ($currentUser['staff'] <= $targetUser['staff']) {
        header("Location: users-list.php?durum=hata&mesaj=Kendi mevcut rank seviyenizden daha yüksek veya aynı bir kullanıcıya rank veremezsiniz.");
        exit;
    }

    // Eğer güncellenmek istenen rank, mevcut kullanıcının seviyesine eşitse güncellemeyi yapma
    if ($new_level == $targetUser['staff']) {
        header("Location: users-list.php?durum=hata&mesaj=Kendi mevcut rank seviyeniz ile aynı rank seviyesini veremezsiniz.");
        exit;
    }

    // Kullanıcı kendi rank seviyesini başka birine veremez
    if ($currentUser['staff'] == $new_level) {
        header("Location: users-list.php?durum=hata&mesaj=Kendi rank seviyenizi bir başkasına veremezsiniz.");
        exit;
    }

    // Kullanıcı kendi seviyesinden daha yüksek bir rank vermeye çalışıyorsa hata ver
    if ($new_level > $currentUser['staff']) {
        header("Location: users-list.php?durum=hata&mesaj=Kendi seviyenizden daha yüksek bir rank veremezsiniz.");
        exit;
    }

    // Kullanıcının rank seviyesini güncelle
    $updateSorgu = $db->prepare("UPDATE users SET staff = :level WHERE id = :id");
    $updateSorgu->execute([
        'level' => $new_level,
        'id' => $user_id
    ]);

    // Log kaydı ekle
    logAction($db, $user['id'], $user['username'], 'Rank seviyesi güncellendi', 'Kullanıcı ID: ' . $user_id . ' için yeni seviye: ' . $new_level);
    
    header("Location: users-list.php?durum=guncellendi");
    exit;
}

// Kullanıcının rank seviyesini sıfırla
if (isset($_POST['reset_rank'])) {
    $user_id = $_POST['user_id'];
    $new_level = 0; // Sıfırlama işlemi için seviyeyi 0 olarak ayarla

    // Kullanıcının rank seviyesini sıfırla
    $updateSorgu = $db->prepare("UPDATE users SET staff = :level WHERE id = :id");
    $updateSorgu->execute([
        'level' => $new_level,
        'id' => $user_id
    ]);

    // Log kaydı ekle
    logAction($db, $user['id'], $user['username'], 'Rank seviyesi sıfırlandı', 'Kullanıcı ID: ' . $user_id . ' için yeni seviye: ' . $new_level);
    
    header("Location: users-list.php?durum=sifirlandi");
    exit;
}

// Kullanıcı bilgilerini al
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $userSorgu = $db->prepare("
        SELECT u.id, u.username, u.staff, r.name AS rank_name 
        FROM users u
        LEFT JOIN rank r ON u.staff = r.level 
        WHERE u.id = :id
    ");
    $userSorgu->execute(['id' => $user_id]);
    $user = $userSorgu->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        header("Location: users-list.php?durum=hata");
        exit;
    }
} else {
    header("Location: users-list.php?durum=hata");
    exit;
}

// Rank seviyelerini al
$rankSorgu = $db->query("SELECT id, name, level FROM rank ORDER BY level ASC");
$ranklar = $rankSorgu->fetchAll(PDO::FETCH_ASSOC);

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
                                <h3 class="lite-text">Rank Seviyesini Güncelle</h3>
                                <span class="lite-text text-gray">Buradan kullanıcının rank seviyesini yükseltebilir veya düşürebilirsiniz.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Kullanıcılar</a></li>
                            <li class="breadcrumb-item active">Rank Güncelle</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kullanıcı Güncelleme Formu -->
        <div class="jumbotron shade pt-5">
            <form method="POST" action="">
                <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                <div class="form-group">
                    <label>Kullanıcı Adı</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Mevcut Rank</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['rank_name']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="level">Yeni Rank Seviyesi </label>
                    <select class="form-control" id="level" name="level" required>
                        <?php foreach ($ranklar as $rank): ?>
                            <option value="<?= $rank['id']; ?>" <?= ($user['staff'] == $rank['level']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($rank['name']); ?> (Seviye: <?= htmlspecialchars($rank['level']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="update_rank" class="btn btn-primary">Güncelle</button>
                <button type="submit" name="reset_rank" class="btn btn-danger">Sıfırla</button>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
