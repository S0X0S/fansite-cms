<?php require '../includes/config.php';
date_default_timezone_set('Europe/Istanbul'); // Türkiye saat dilimi

class Action {
    public function info($action, $author, $victim) {
        global $db;
        $a = $action;
        $i = $author;
        $v = $victim;
        $add_action = $db->prepare("INSERT INTO flux(action, author, post_at, victim) VALUES (?, ?, ?, ?)");
        $add_action->execute(array($a, $i, TIME, $v));
    }
}

$action = new Action();

// Kullanıcı ID'sini ve rütbe bilgilerini kontrol etme fonksiyonu
function check_user_permissions($db, $user_id, $channel_id) {
    // Kullanıcı bilgilerini al
    $user_query = "SELECT staff FROM users WHERE id = ?";
    $user_stmt = $db->prepare($user_query);
    $user_stmt->execute([$user_id]);
    $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        die("Kullanıcı bulunamadı.");
    }
    
    $author_level = $user['staff']; // Kullanıcının staff durumu

    // Rank bilgilerini al
    $rank_query = "SELECT id FROM rank WHERE level = ?";
    $rank_stmt = $db->prepare($rank_query);
    $rank_stmt->execute([$author_level]);
    $rank_result = $rank_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$rank_result) {
        die("Rütbe bilgisi bulunamadı.");
    }
    
    $rank_id = $rank_result['id'];

    // Rank izin kontrolü
    $permission_query = "SELECT can_view FROM rank_channel_permissions WHERE rank_id = ? AND channel_id = ?";
    $permission_stmt = $db->prepare($permission_query);
    $permission_stmt->execute([$rank_id, $channel_id]);
    $permission = $permission_stmt->fetch(PDO::FETCH_ASSOC);
    
    // İzin kontrolü
    if ($permission && $permission['can_view'] == 1) {
        return true; // İzin varsa
    }

    return false; // İzin yoksa
}





function showMessage() {
    if (isset($_GET['durum'])) {
        switch ($_GET['durum']) {
            case 'guncellendi':
                echo '<div class="alert alert-success" role="alert">Başarıyla güncellendi.</div>';
                break;
            case 'silindi':
                echo '<div class="alert alert-warning" role="alert">Haber başarıyla silindi.</div>';
                echo '<script>setTimeout(function() { window.location.href = "news.php"; }, 3000);</script>';
                break;
            case 'silme_hatasi':
                echo '<div class="alert alert-danger" role="alert">Haber silinirken bir hata oluştu.</div>';
                break;
            case 'hata':
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['mesaj']) . '</div>';
                break;
            case 'sifirlandi':
                echo '<div class="alert alert-success" role="alert">Başarıyla sıfırlandı.</div>';
                break;
            default:
                break;
        }
    }
}







?>
