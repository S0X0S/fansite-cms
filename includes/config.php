<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<?php

session_start();
include 'fonction.php';

// Yapılandırma
define("Habbo", "Hasanxuk");
define("NOM", "Hasanxuk");
define("TAG", "Hasan26 Fansite, Hasanx, CMS, Fansite, Site de fan");
define("TIME", time());
define("IP", $_SERVER["REMOTE_ADDR"]);
define("AVATAR", "https://www.habbo.com/habbo-imaging/avatarimage?figure=");
define("DEFAULT_LOOK", "hasan26");

define("HOST", "localhost");
define("DBNAME", "beta");
define("USER", "root");
define("MDP", "");

// DB bağlantısı
try{
	$db = new PDO('mysql:host=' .HOST. ';dbname=' .DBNAME. ';charset=utf8', ''.USER.'', ''.MDP.'');
}
catch (Exception $e) {
	die('hata : ' . $e->getMessage());
}

// Oturum
if(isset($_SESSION["user"])) {
$username = $secu->get($_SESSION["user"]);
	$my_session = $db->prepare("SELECT * FROM users WHERE username = ?");
	$my_session->execute(array($username));
	$user = $my_session->fetch();

	$update = $db->prepare("UPDATE users SET last = ? WHERE username = ?");
	$update->execute(array(TIME, $username));
	if($user['ban'] == 1) {
		session_destroy();
		$redirect->url("/xuk");
	}
}

// Üye alanı
if(isset($_GET["identifiant"])) {
// Giriş
if($secu->get($_GET["identifiant"]) == "login") {
$nom = $secu->post($_POST["username"]);
$pass = $hash->hashme($_POST["pass"]);
	if(isset($nom) || isset($pass)) {
		if(empty($nom) || empty($pass)) {
			$alert->message("Yanlış tanımlayıcı", "/xuk");
		} else {
		$check_login = $db->prepare("SELECT * FROM users WHERE username = ? AND pass = ?");
		$check_login->execute(array($nom, $pass));
		$row = $check_login->rowCount();
			$about_login = $check_login->fetch();
			if($row < 1) {
			$alert->message("Yanlış tanımlayıcı", "/xuk");
			} else {
				if($about_login['ban'] == 1) {
				$ban_reason = $about_login['ban_reason'];
					$alert->message("Bu hesap aşağıdaki nedenlerle yasaklandı : ".$ban_reason, "/xuk");
				} else {
					$_SESSION["user"] = $nom;
						$alert->message("Aramızda tekrar hoşgeldiniz " .$nom. " !", "/xuk");
				}
			}
		}
	}
}
// Çıkış Yap
if($secu->get($_GET["identifiant"]) == "logout") {
	session_destroy();
	$redirect->url("/xuk");
}
// Kayıt ol
if($secu->get($_GET["identifiant"]) == "register") {
	$username = $secu->post($_POST["username"]);
	$pass = $secu->post($_POST["pass"]);
	$pass2 = $secu->post($_POST["pass2"]);
	if(isset($username) || isset($pass) || isset($pass2)) {$check = $db->prepare("SELECT * FROM users WHERE username = ?");
		$check->execute(array($username));
		if($check->rowCount() > 0) {
		$alert->message("Bu takma ad zaten kullanılıyor", "/xuk");
		} else {
			if(!preg_match('`^([a-zA-Z0-9-_]{2,36})$`', $username)) {
				$alert->message("Özel karakterler sözde kabul etmiyor", "/xuk");
			} else {
				if(strlen($username) > 22) {
					$alert->message("Takma ad çok uzun (maks. 22)", "/xuk");
				} else if($pass !== $pass2) {
					$alert->message("Şifreler uyuşmuyor", "/xuk");
				} else {
					$passfinal = $hash->hashme($_POST["pass"]);
					$create_account = $db->prepare("INSERT INTO users(username,pass,ip,look,born,last) VALUES (?,?,?,?,?,?)");
					$create_account->execute(array($username, $passfinal, IP, DEFAULT_LOOK, TIME, TIME));
						$_SESSION["user"] = $username;
						$alert->message("Hoş geldiniz!", "/xuk");
				}
			}
		}
	}
}
}

// Yorumlar
if(isset($_GET['news'])) {
if($secu->get($_GET['news']) == 'comment') {
$id = $secu->get($_GET['id']);
$comment = $secu->post($_POST['comment']);
	$add_comment = $db->prepare("INSERT INTO comments(author,look,post_at,comment,news) VALUES(?,?,?,?,?)");
	$add_comment->execute(array($user['id'], $user['look'], TIME, $comment, $id));
		$alert->message("Yorum posteri!", "/article/" .$id);
}
}

// Parametreler

if(isset($_GET['parameters'])) {
// Takma ad değişikliği

if($secu->get($_GET['parameters']) == "username") {
$username = $secu->post($_POST['username']);
	$check_parameters = $db->prepare("SELECT username FROM users WHERE username = ?");
	$check_parameters->execute(array($username));
		$row = $check_parameters->rowCount();
	if($row > 0) {
		$alert->message("Bu takma ad zaten kullanılıyor!", "/parametres");
	} else {
		if(!preg_match('`^([a-zA-Z0-9-_]{2,36})$`', $username)) {
			$alert->message("Özel karakterler sözde kabul etmiyor", "/parametres");
		} else {
			if(strlen($username) > 22) {
				$alert->message("Takma ad çok uzun (maks. 22)", "/parametres");
			} else {
				$upate_parameters = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
				$upate_parameters->execute(array($username, $user['id']));
					$_SESSION['user'] = $username;
					$alert->message("Takma ad doğru şekilde değiştirildi!", "/parametres");
			}
		}
	}
}

// Şifreyi değiştir

if($secu->get($_GET['parameters']) == "pass") {
$pass_actual = $hash->hashme($_POST['passi']);
$pass = $secu->post($_POST['pass']);
$pass2 = $secu->post($_POST['pass2']);
	if($user['pass'] !== $pass_actual) {
		$alert->message("Hatalı geçerli şifre.", "/parametres");
	} else {
		if($pass !== $pass2) {
			$alert->message("İki yeni şifre eşleşmiyor.", "/parametres");
		} else {
		$passfinal = $hash->hashme($_POST["pass"]);
			$upate_parameters = $db->prepare("UPDATE users SET pass = ? WHERE id = ?");
			$upate_parameters->execute(array($passfinal, $user['id']));
				$alert->message("Şifre doğru bir şekilde değişti!", "/parametres");
		}
	}
}


}

// İletişim


if(isset($_GET['contact'])) {
// Yanıtla

if($secu->get($_GET['contact']) == "answer") {
$id = $secu->get($_GET['id']);
$text = $secu->post($_POST['answer']);
	$add_comment = $db->prepare("INSERT INTO contact_answers(author,text,post_at,contact) VALUES(?,?,?,?)");
	$add_comment->execute(array($user['id'], $text, TIME, $id));
		$alert->message("Yanıt gönder!", "/contact/" .$id);
}

// Yeni bilet

if($secu->get($_GET['contact']) == "new") {
$title = $secu->post($_POST['title']);
$text = $secu->post($_POST['text']);
	$add_comment = $db->prepare("INSERT INTO contact(author,text,post_at,title) VALUES(?,?,?,?)");
	$add_comment->execute(array($user['id'], $text, TIME, $title));
		$alert->message("Bilet oluştur!", "/contact");
}
}