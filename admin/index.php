<?php require "core.php"; ?>
<?php 
if (!isset($_SESSION['user']) || empty($user) || $user['staff'] == 0) {
    $alert->message("Bu sayfaya erişim izniniz yok.", "/accueil");
    exit; 
}
?>
<?php require "header.php"; ?>
	<main class="bmd-layout-content">
			<div class="container-fluid ">

				<!-- content -->
				<!-- breadcrumb -->

				

				





			</div>
		</main>
<?php require "footer.php"; ?>