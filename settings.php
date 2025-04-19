<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<?php require "includes/config.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/alerte.php"; ?>

<?php if(!isset($_SESSION['user'])) {$alert->message("Connectes-toi pour accéder à tes paramètres !", "/accueil");} ?>

<div class="container" style="margin-top:20px;">
  <div class="row">
  <div class="col-sm-12">

<div class="panel panel-default">
    
	
    <div class="panel-body" id="body-panel">
			<div class="titre">Kullanıcı adı değiştirici</div>
			<div class="inside">
				<div class="fonce">
				<form action="/parametres/username" method="POST">
					<input type="input" name="username" maxlength="22" required placeholder="kullanıcı adı" />

					<button class="bouton-vert">Kullanıcı adı değiştirici</button>
				</form>
				</div>
			</div>
		</div>
		<div class="box-half">
			<div class="titre">Şifre değiştir</div>
			<div class="inside">
				<div class="fonce">
				<form action="/parametres/mdp" method="POST">
					<input type="password" name="passi" minlength="5" required placeholder="Mevcut Şifre" />
					<input type="password" name="pass" minlength="5" required placeholder="Yeni Şifre" />
					<input type="password" name="pass2" minlength="5" required placeholder="Tekrar Yeni Şifre" />

					<button class="bouton-vert">Şifre değiştirici</button>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="principal-droite">

</div>
</div>

<?php require "includes/footer.php"; ?>
</html>