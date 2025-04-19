<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<?php require "includes/config.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/alerte.php"; ?>

<?php
if(isset($_GET['id']) && !empty($_GET['id'])) {
$id = $secu->get($_GET['id']);
	$load_the_article = $db->prepare("SELECT * FROM news WHERE id = ? AND validity = 1");
	$load_the_article->execute(array($id));
		$check = $load_the_article->rowCount();
	if($check > 0) {
	$news = $load_the_article->fetch();
	$load_info_author = $db->prepare("SELECT * FROM users WHERE id = ?");
	$load_info_author->execute(array($news['author']));
		$author = $load_info_author->fetch();
		if($news['corrector'] == 0) {
		$correction = 0;
		} else {
		$load_info_corrector = $db->prepare("SELECT username FROM users WHERE id = ?");
		$load_info_corrector->execute(array($news['corrector']));
			$corrector = $load_info_corrector->fetch();
			$correction = $corrector['username'];
		}
	} else {
		$alert->message("Article invalide", "/accueil");
	}
} else {
	$alert->message("Article inexistant", "/accueil");
}
?>

<?php
$parPage = 6;
$compteTopic = $db->prepare("SELECT id FROM comments WHERE news = ?");
$compteTopic->execute(array($id));
$compteTotal = $compteTopic->rowCount();
$pagesTotales = ceil($compteTotal/$parPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0) {
	$_GET['page'] = intval($_GET['page']);
	$pageActuelle = $_GET['page'];
} else {
	$pageActuelle = 1;
}

$depart = ($pageActuelle-1)*$parPage;
?>

<div class="container" style="margin-top:20px;">
  <div class="row">
  <div class="col-sm-8">

<div class="panel panel-default">
    <div class="panel-heading" id="bg-panel"><?= $news['title']; ?></div>
	<div class="panel-body" id="news-image" style="margin-top:-1px; background-image:url('<?= $news['background']; ?>');"></div>
    <div class="panel-body" id="body-panel">
	<span class="label label-info">Yazar <?= $author['username']; ?></b> 
					<?php if($author['staff'] == 4) {echo '[Yazar]';} ?>
					<?php if($author['staff'] == 6) {echo '[Özel. Sorumlu]';} ?>
					<?php if($author['staff'] == 7) {echo '[Baş. Yazar]';} ?>
					<?php if($author['staff'] == 8) {echo '[Yönetici]';} ?>
					<?php if($author['staff'] == 9) {echo '[Geliştirici]';} ?>
					<?php if($author['staff'] == 10) {echo '[Kurucu]';} ?></span>
<span class="label label-primary"><?php if($correction !== 0) {?>Güncelleyen <?= $correction; ?><?php }?></span>
<span class="label label-warning">Habbo</span>
<span class="label label-danger"><?= getDateComplete($news['post_at']); ?></span><br><br>
<?= $news['text']; ?>	</div>
  </div>





 <!-- CONTENT EIND --->

<!--- REACTIES GEDEELTE --->




  		<?php
		$load_all_comments = $db->prepare("SELECT * FROM comments WHERE news = ? ORDER BY post_at DESC LIMIT " .$depart. "," .$parPage);
		$load_all_comments->execute(array($id));
			while($comment = $load_all_comments->fetch()) {
			$load_author_comment = $db->prepare("SELECT * FROM users WHERE id = ?");
			$load_author_comment->execute(array($comment['author']));
				$author_comment = $load_author_comment->fetch();
		?>
		  <div class="panel panel-default">
<div class="panel-body" id="body-panel">
<div class="schedule-comment" style="float:left">
<div class="habbo-comment"><img style="margin-bottom:10px; margin-left:10px;" src="https://www.habbo.com.tr/habbo-imaging/avatarimage?hb=image&amp;user=<?= $author_comment['username']; ?>&amp;headonly=1&amp;direction=2&amp;head_direction=3&amp;action=&amp;gesture=&amp;size=m">
<div class="info-habbo-comment"><?= $author_comment['username']; ?></b>
				<?php if($author_comment['staff'] > 0) {?>
				<span style="color: red;">
					<?php if($author_comment['staff'] == 1) {echo '[Animasyon/WIREDci]';} ?>
					<?php if($author_comment['staff'] == 2) {echo '[Mimar]';} ?>
					<?php if($author_comment['staff'] == 3) {echo '[Düzeltici]';} ?>
					<?php if($author['staff'] == 4) {echo '[Yazar]';} ?>
					<?php if($author['staff'] == 6) {echo '[Özel. Sorumlu]';} ?>
					<?php if($author['staff'] == 7) {echo '[Baş. Yazar]';} ?>
					<?php if($author['staff'] == 8) {echo '[Yönetici]';} ?>
					<?php if($author['staff'] == 9) {echo '[Geliştirici]';} ?>
					<?php if($author['staff'] == 10) {echo '[Kurucu]';} ?>
				</span>
				<?php }?>
								<?php if($author_comment['staff'] == 0) { ?>
				<br><img src="/assets/icons/HH01.gif"> 
			<?php	} ?>
				
				<?php if($author_comment['staff'] > 0 ) { ?>
				<img src="/assets/icons-medewerkers/10.gif">
				<?php	} ?>
								<?php if($author_comment['username'] ==  $author['username']) { ?>
				<img src="/assets/icons/news_icon.gif">
				<?php	} ?>
				</div>
</div></div>
<div style="float:left; min-width: 100px; max-width: 600px; margin-left:10px;"><?= $comment['comment']; ?> <i></i></div>
	</div>
	</div>
			<?php }?>
  
	
		
		



</div>

    <div class="col-sm-4">
	



		<style>
input {
    padding: 10px;
    box-sizing: border-box;
    width: 100%;
    border-radius: 3px;
    box-shadow: inset 0 5px rgba(255,255,255,0.2), inset 0 -3px rgba(0,0,0,0.1), inset 0 0 0 1px rgba(0,0,0,0.2);
    -webkit-box-shadow: inset 0 5px rgba(255,255,255,0.2), inset 0 -3px rgba(0,0,0,0.1), inset 0 0 0 1px rgba(0,0,0,0.2);
    -moz-box-shadow: inset 0 5px rgba(255,255,255,0.2),inset 0 -3px rgba(0,0,0,0.1),inset 0 0 0 1px rgba(0,0,0,0.2);
    -webkit-appearance: none;
    color: #000;
    outline: none;
    border: none;
    margin-bottom: 5px;
    resize: none;
}
.text {
	height: 100px;
    padding: 10px;
    box-sizing: border-box;
    width: 325px;
    border-radius: 3px;
    box-shadow: inset 0 5px rgba(255,255,255,0.2), inset 0 -3px rgba(0,0,0,0.1), inset 0 0 0 1px rgba(0,0,0,0.2);
    -webkit-box-shadow: inset 0 5px rgba(255,255,255,0.2), inset 0 -3px rgba(0,0,0,0.1), inset 0 0 0 1px rgba(0,0,0,0.2);
    -moz-box-shadow: inset 0 5px rgba(255,255,255,0.2),inset 0 -3px rgba(0,0,0,0.1),inset 0 0 0 1px rgba(0,0,0,0.2);
    -webkit-appearance: none;
    color: #000;
    outline: none;
    border: none;
    margin-bottom: 5px;
    resize: none;
	background:white;
}
.button {
	background-color: #28B62C;
        position: relative;
    padding: 10px;
    outline: none;
    color: #FFF;
    text-align: center;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    border: none;
    border-radius: 5px;
    box-shadow: inset 0 2px rgba(255,255,255,0.2), inset 0 -1px rgba(0,0,0,0.1), inset 0 0 0 1px rgba(0,0,0,0.2), 0 1px rgba(0,0,0,0.1);
}
</style>
<div class="panel panel-default">
    <div class="panel-heading" id="bg-panel">Yorum Yap</div>
    <div class="panel-body" id="body-panel">
	<?php if(isset($_SESSION['user'])) {?>
				<form action="/article/<?= $id; ?>/comment" method="POST">
				<textarea class="text" required name="comment" placeholder="Mesajınızı buraya girin!" maxlength="400"></textarea>

				<button class="button">Gönder</button>

			</form>
			<?php } else {?>
					<div class="alert alert-warning">Bu habere yanıt vermek için giriş yapın!</div>
			<?php }?>
  
				
			</div></div></div>
</div></div>

</div>
</div>

<?php require "includes/footer.php"; ?>
</html>