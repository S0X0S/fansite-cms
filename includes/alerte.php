<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>

<div class="oenemliDuyuruPla"><p><h4><strong>+ + + <?php 
$alerte = $db->query("SELECT * FROM alert");
if($alerte->rowCount() > 0) {
	$alert = $alerte->fetch();
?>
	<?= $alert['text']; ?>
 + + +
<?php }?> </a>&nbsp;</strong></h4></p>
</div>