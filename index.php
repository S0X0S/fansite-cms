<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>

<?php require "includes/config.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/alerte.php"; ?>

<div class="container" style="margin-top:20px;">
 
  
  <div class="row">
  <div class="col-sm-8">
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
				$found_latest_news = $db->query("SELECT * FROM news WHERE validity = 1 ORDER BY post_at DESC LIMIT 0,3");
					while($news = $found_latest_news->fetch()) {
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
			</div>
		</div>
<div class="col-sm-4">




<div class="panel panel-default">
    <div class="panel-heading" id="bg-panel">Bugünkü etkinlikler!</div>
    <div class="panel-body" id="body-panel">

	
	<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">zaman</th>
      <th scope="col">başlık</th>
	  <th scope="col">icerik</th>

    </tr>
  </thead>	<tbody> <tr>
  			<?php

			$load_all_events = $db->query("SELECT *,  DATE_FORMAT(for_the, 'Le %d %M %Y' ) AS dateEvent FROM events WHERE validity = 1 ORDER BY for_the limit 0,3");
				while($event = $load_all_events->fetch()) {
				$link = $event['place'];
			?>
      <th scope="row"><?= $event['dateEvent']; ?></th>
      <td><?= $event['title']; ?></td>
      <td><a onclick="location.href='<?= $link; ?>';"><?= $event['text']; ?></a></td>
    </tr>
		<?php }?>
		    </tbody></table>
 
  
<?php // Bugünün tarihini almak
$today = strftime('%e %B %Y %A'); // "%e %B %Y %A" : 4 Ocak 2020 Cumartesi gibi

// Bugün tarihiyle mesajı yazdırmak
echo "Bugün <b>" . $today . ",</b> bugünkü etkinliklere katılıyorsunuz, belki güzel bir ödül kazanırsınız!"; ?>

	</div>
  </div>
  
  
  
  
  <div class="panel panel-default">
    <div class="panel-heading" id="bg-panel">Yorumlar</div>
   
	<ul class="list-group">
	
				<?php
			$found_latest_comments = $db->query("SELECT * FROM comments ORDER BY post_at DESC LIMIT 0,5");
				while($comment = $found_latest_comments->fetch()) {
				$info_author = $db->prepare("SELECT * FROM users WHERE id = ?");
				$info_author->execute(array($comment['author']));
					$author = $info_author->fetch();
				$info_news = $db->prepare("SELECT * FROM news WHERE id = ?");
				$info_news->execute(array($comment['news']));
					$news = $info_news->fetch();
			?>
	<li class="list-group-item">

 <a href="/article/<?= $news['id']; ?>" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="<?= $news['title'] ?>" data-original-title="<?= $author['username']; ?>">
<img style="margin-right:10px;" src="http://www.habbo.com.tr/habbo-imaging/avatarimage?&user=Hasan26&action=&direction=3&head_direction=3&img_format=png&gesture=spk&headonly=1&size=b"><?= ($comment['comment']) ?></a><span style="margin-right:5px; margin-top:15px; float:right;" class="label label-success"><?= $author['username']; ?></span><span style="margin-right:5px; margin-top:15px; float:right;" class="label label-warning"><?= ago($comment['post_at']) ?></span></li>


</ul>
			<?php }?>

</div>

	</div>
</div>
</div>
<div class="principal-droite">

</div>
</div>

<?php require "includes/footer.php"; ?>
</html>