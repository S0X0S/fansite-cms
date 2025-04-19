<?php
//  :¨·.·¨:
 //  `·.  Discord : Hasanx ★°*ﾟ
// Hasanxuk Cms★°*ﾟ Edit by Hasanx

?>
<?php if(!isset($_SESSION['user'])) {?>
<script>
$(document).ready(function() {
	$('#box_membre_inscription').hide();

	$('#membre_connexion, #membre_inscription').on('click', function() {
		$('#box_membre_connexion, #box_membre_inscription').toggle()
	});
});
</script>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
        <div class="modal-body">
          <p>
Web sitesindeki fonksiyonları kullanabilmek için <b>Giriş</b> yapın! Henüz bir hesabınız yok mu? O zaman <b>ÜCRETSİZ</b> bir hesap oluşturun!.<br>
							<form method="POST">
								<div class="form-group">
									<input type="text" name="username" onclick="this.value=''" value="Kullanıcı Adın" class="form-control"><br>
									<input type="password" name="pass" onclick="this.value=''" value="**********" class="form-control">
								</div>
								
							
							</p>
        </div>
        <div class="modal-footer">
          <button type="submit" formaction="/connexion" class="btn btn-default">Giriş yap</button></form>
        </div>
      </div>
      
    </div>
	</div>
							  
<li><a data-toggle="modal" data-target="#register"><img src="assets/icons/news_icon.gif" style="margin-top:-5px; margin-right: 5px;"> Kayıt ol </a></li>

<div class="modal fade" id="register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Kayıt Ol</h4>
            </div>
            <div class="modal-body">
			<p>
			Web sitesinin tüm özelliklerinden faydalanmak için <b>Kayıt ol</b>!<br>
                <div class="membre-inscription fond">
             
                    <form method="POST" action="/inscription">
                        <div class="form-group">
                            <input type="text" name="username" placeholder="Kullanıcı Adın" maxlength="22" class="form-control" required />
                            <input type="password" name="pass" placeholder="**********" minlength="5" class="form-control" required />
                            <input type="password" name="pass2" placeholder="**********" class="form-control" required />
                        </div>

                 
                </div>
				</p>
            </div>
            <div class="modal-footer">
			                        <button type="submit" class="btn btn-default">Kayıt ol</button>   </form>
            </div>
        </div>
    </div>
</div>
<?php } else {?>

<?php }?>