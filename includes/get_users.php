<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<?php
require "config.php";

header('Content-Type: application/json');

// Kullanıcı adlarını al
if (isset($_GET['term'])) {
    $term = htmlspecialchars($_GET['term']);  // Girilen terimi al
    try {
        $stmt = $db->prepare("SELECT username FROM users WHERE username LIKE ? LIMIT 10");
        $stmt->execute(["%" . $term . "%"]);
        $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode($usernames);  // JSON olarak kullanıcı adlarını döndür
    } catch (PDOException $e) {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
