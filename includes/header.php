<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<!DOCTYPE html>
<html lang="tr_TR">
<head>
    <base href="/">
<meta charset="UTF-8">

		<meta name="robots" content="all, follow"> 
		<meta name="keywords" content="<?= TAG; ?>">
		<title><?= NOM; ?></title>
  <!-- BOOSTRAP CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- EIGEN CSS -->
  <link rel="stylesheet" href="assets/css/body.css?422h">
  <!-- BOOSTRAP SCRIPTS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=nwthnur2r3dx0qetkfv7yuwyoxp7exnxdmwh909x3leb3ryp"></script>
		
		<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111521918-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111521918-1');
</script>
</head>
<body>
  
  <!-- NAVIGATOR -->
    	<style>
.oenemliDuyuruPla {
    z-index: 1;
    padding: 10px;
    position: relative;
    width: 100%;
    height: auto;
    text-align: center;
    color: #fff;
    background-color: #A80000;
    border-bottom: 2px solid #fff;
}
	</style>
  <nav class="navbar navbar-default" id="nav-body">
<a href=""><img class="animated bounce infinite" src="assets/images/H.png" style="float:left;"></a>
  <div class="container-fluid">  
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li>
          <a href="xuk"><img src="assets/icons/news_icon.gif" style="margin-top:-5px; margin-right: 5px;">Anasayfa</a>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="assets/icons/news_icon.gif" style="margin-top:-5px;"> <?= NOM; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" id="nav-dropdown">
            <li><a href="equipe"> Ekip</a></li>
          </ul>
        </li>
		  <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="assets/icons/news_icon.gif" style="margin-top:-5px; margin-right: 5px;">Haberler <span class="caret"></span></a>
          <ul class="dropdown-menu" id="nav-dropdown">
            <li><a href="articles">Tüm Haberler</a></li>
          </ul>
        </li>
		  <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="assets/icons/news_icon.gif" style="margin-top:-5px; margin-right: 5px;">Habbo <span class="caret"></span></a>
          <ul class="dropdown-menu" id="nav-dropdown">
            <li><a href="">Habbo Güvenlik</a></li>
            <li><a href="">Habbo Kurallar</a></li>
			<li><a href="">Habbo personeller</a></li>
          </ul>
        </li>
		
      </ul>
      <ul class="nav navbar-nav navbar-right">	
  
	  <?php if(!isset($_SESSION['user'])) {?>
	          <li><a href="#" data-toggle="modal" data-target="#myModal"> <img src="assets/icons/news_icon.gif" style="margin-top:-5px; margin-right: 5px;"> Login </a></li>
<li><a data-toggle="modal" data-target="#register"><img src="assets/icons/news_icon.gif" style="margin-top:-5px; margin-right: 5px;"> Kayıt ol </a></li>
				<?php } else {?>
				
				<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="https://www.habbo.com.tr/habbo-imaging/avatarimage?&user=<?= $user['username']; ?>&action=&direction=3&head_direction=3&img_format=png&gesture=&headonly=1&size=s" style="margin-top:-5px; margin-right: 5px;"><?= $user['username']; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" id="nav-dropdown">

				<?php if($user['staff'] > 0) {?>
            <li><a href="/admin">Admin Panel</a></li>
			<?php }?>
			<li><a href="/settings">Ayarlar</a></li>
			<li><a href="/deconnexion">Çıkış Yap</a></li>
          </ul>
        </li>			
						
				
<?php }?>				


      </ul>
    </div>
  </div>
</nav>

<!-- EINDE NAVIGATOR -->

<!-- LOGIN -->


	
<!-- Modal -->
	<?php require 'includes/connexion-inscription.php'; ?>
	
	
	<!-- EINDE LOGIN -->
	
	<style>
	.images-slider {
	}
	.images-slider h1 {
		font-size: 12pt;
    color: white;
    margin: 0px;
    padding: 10px;
    font-weight: normal;
    min-width: 50px;
    display: inline-block;
    background: rgb(0, 0, 0);
    background: rgba(0, 0, 0, 0.5);
	}
	.images-slider h2 {
    font-size: 8.5pt;
    color: white;
    margin: 0px;
    padding: 10px;
    font-weight: normal;
    min-width: 50px;
    display: inline-block;
    background: rgb(0, 0, 0);
    background: rgba(0, 0, 0, 0.5);
}
	</style>
	<!-- HEADER -->
	
<div class="header">
<div id="header-1" class="marquee"></div>
<img src="assets/images/hotel.gif" style="position: absolute; z-index: 99; margin-top:-419px; left:50%;">
  <div class="container" style="margin-top:-200px;">
 
  
  <div class="row">

  <div class="col-sm-4">
  
  <div class="panel panel-default">
    <div class="panel-body" id="body-panel" style="height:200px; padding:2px;">

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <div class="images-slider" style="border-radius:3px; padding-top:20px; color:white; padding-left:20px; height: 196px; width: 100%; background-image:url('https://i.ytimg.com/vi/G1Z6I0KpzT0/hqdefault.jpg'); background-position:100%;">

<h1>Hasanxuk CMS</h1><br>
<h2>Hasan26 Habbo Youtube Adresinden CMS Mizi İndire Bilirsiniz</h2><br>
	<span class="label label-info">Hasan26</span>
<span class="label label-warning">Hasanxuk</span>
<span class="label label-danger">4 saat önce</span>

</div>
      </div>
	    


    

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

	</div>
  </div>
  
  </div></div></div>
</div>
  
  <!-- EINDE HEADER -->
  
<!-- CONTAINER -->

<!--- HIER WORDEN DE PAGINAS GEINCLUDE --->
   <!-- CONTAINER -->