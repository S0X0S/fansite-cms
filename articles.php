<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<?php require "includes/config.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/alerte.php"; ?>

<?php
$parPage = 6;
$compteTopic = $db->query("SELECT id FROM news WHERE validity = 1");
$compteTotal = $compteTopic->rowCount();
$pagesTotales = ceil($compteTotal / $parPage);


$pageActuelle = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1],
]);

$depart = ($pageActuelle - 1) * $parPage;
?>


<style>


</style>

<div class="container" style="margin-top:20px;">
 
  
  <div class="row">
  <div class="col-sm-12">
<script type="text/javascript">
$(function(){
setInterval(function(){
	$(".slideshow ul").animate({marginLeft:-704},800,function(){
		$(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
	})
}, 3500);
});
</script>
<div class="panel panel-default">
    <div class="panel-heading" id="bg-panel" style="border-radius:3px;">Haberlere genel bakış!</div></div>
<div class="row">
	<?php
	$load_all_news = $db->query("SELECT * FROM news WHERE validity = 1 ORDER BY post_at DESC LIMIT " .$depart. "," .$parPage);
		while($news = $load_all_news->fetch()) {
		$load_info_author = $db->prepare("SELECT * FROM users WHERE id = ?");
		$load_info_author->execute(array($news['author']));
			$author = $load_info_author->fetch();
	?>
<div class="col-sm-4">
	<div class="panel panel-default">
    <div class="panel-heading" id="bg-nieuws" style="background-image:url('<?= $news['background']; ?>');"><div class="images-slider"><h2><?= $news['title']; ?></h2></div><br>
</div>
    <div class="panel-body" id="body-panel" style="height:120px">	<span class="label label-info"><?= $author['username']; ?></span>

<span class="label label-danger"><?= getDateComplete($news['post_at']); ?></span><br><br><?= $news['descr']; ?></div>
<div class="panel-footer">
          <a href="/article/<?= $news['id']; ?>"><button type="button" class="btn btn-default" data-dismiss="modal" style="font-size:12px;">Devamını Gör</button></a>
        </div>
  </div>
	</div>
	<?php }?>
	<div class="col-sm-12 pagination">
<div class="pagination">
    <?php
    for ($i = 1; $i <= $pagesTotales; $i++) {
        if ($i == $pageActuelle) {
            echo '<span class="page-actuel">' . $i . '</span>';
        } else {
            echo '<a href="/articles?page=' . $i . '">' . $i . '</a>';
        }
    }
    ?>
</div>

	</div>
</div>			</div>
		</div>
<div class="principal-droite">

</div>
</div>

<?php require "includes/footer.php"; ?>
</html>