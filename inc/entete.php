				<header>
					<div class="navbar navbar-default" role="navigation">
						<div class="top-navbar">
							<div class="container">
								<div class="row">
									<div class="col-md-3 col-xs-4">
									<div class="row">
										<div class="contact">
											<ul>
												<!--<li><a href="mailto:contact@tousrenov.fr"><i class="fa fa-envelope"></i>contact@tousrenov.fr</a></li> -->
												<li><a href="contact.php"><i class="fa fa-envelope"></i><span><?php $temp = $my->req_arr('SELECT * FROM ttre_coordonnees WHERE id=1 '); echo $temp['val1']; ?></span></a></li>
												<!--<li><i class="fa fa-phone"></i>+1 0 00 00 00 00</li><i class="sparator">|</i> -->
												<li><a href="<?php $temp = $my->req_arr('SELECT * FROM ttre_coordonnees WHERE id=2 '); echo $temp['val1']; ?>"><i class="fa fa-phone"></i><span><?php $temp = $my->req_arr('SELECT * FROM ttre_coordonnees WHERE id=2 '); echo $temp['val1']; ?></span></a></li>
											</ul>								
										</div>
										</div>
									</div> 
									<div class="col-md-9 col-xs-8">
									<div class="row">
										<div class="spaces">
											<ul>									
												<!-- <li><span style="color:#fff;">BB | <a href="#">Déconnexion</a></span></li> -->

	<?php 
	$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');$option='';
	while ( $resCat=$my->arr($reqCat) )
	{
		$option.='<option value="'.$resCat['departement_id'].'">'.$resCat['departement_nom'].'</option>';
	}
	echo'
		<li class="icon mobile-left departement">
			<form>
				<select name="sel_zone">
					<option>Choisir un département</option>
					'.$option.'
				</select>
			</form>
		</li>
		';
	?>		
	<script type="text/javascript">
	$(document).ready(function() 
	{
		$('select[name="sel_zone"]').change(function ()
		{
			//alert( $('select[name="sel_zone"]').val() );
			$.ajax({
				 type: "post",
				 url: "AjaxZone.php",
				 data: "id="+$('select[name="sel_zone"]').val(),
				 success: function(msg)
					{			 
						//alert(msg);
					 	window.location='http://tousrenov.fr/'+msg+'/';
					}
			 });
		});
	});
	</script>								
												
												
												<!-- <li class="icon mobile-left"> </li> -->
												<!-- <?php 
												$temp = $my->req_arr('SELECT * FROM ttre_coordonnees WHERE id=3 ');
												if ( !empty($temp['val1']) ) echo'<li class="icon mobile-left"><a target="_blanc" href="'.$temp['val1'].'"><span>Petites annonces</span></a></li>';
												?>	 -->
												<li class="spaces-btns blut-btn icon mobile-right"><a href="espace_particulier.php"><i class="icon-male"></i><span>Espace Particulier</span></a></li>
												<li class="spaces-btns yellow-btn icon mobile-right"><a href="espace_professionnel.php"><i class="icon-engineer"></i><span>Espace Professionnel</span></a></li>
												<li class="spaces-btns blut-btn icon mobile-right"><a href="espace_affilier.php"><i class="icon-office-worker-outline"></i><span>Espace Affilié</span></a></li>
												<?php 
												if ( isset($_SESSION['id_client_trn_part']) )
												{
													$cl=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$_SESSION['id_client_trn_part'].' ');
													echo'<li><span style="color:#fff;">'.$cl['nom'].'</span> <a href="espace_particulier.php?contenu=deconnexion"><i class="fa fa-power-off"></i></a></li>';
												}
												elseif ( isset($_SESSION['id_client_trn_pro']) )
												{
													$cl=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_SESSION['id_client_trn_pro'].' ');
													echo'<li><span style="color:#fff;">'.$cl['nom'].'</span> <a href="espace_professionnel.php?contenu=deconnexion"><i class="fa fa-power-off"></i></a></li>';
												}
												?>
												<li class="dropdown langs-block">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img id="imgNavFra" src="" alt="..." class="img-thumbnail icon-small">  <span id="lanNavFra">Fr</span> <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a id="navFr" href="https://www.tousrenov.fr" class="language"> <img id="imgNavFr" src="" alt="..." class="img-thumbnail icon-small">  <span id="lanNavFr">France</span></a></li>
                                                        <li><a id="navCh" href="https://www.tousrenov.ch" class="language"> <img id="imgNavCh" src="" alt="..." class="img-thumbnail icon-small">  <span id="lanNavCh">Suisse</span></a></li>
                                                        <li><a id="navBe" href="https://www.tousrenov.be" class="language"><img id="imgNavBe" src="" alt="..." class="img-thumbnail icon-small">  <span id="lanNavBe">Belgium</span></a></li>
                                                    </ul>
                                                </li>
                                                <li>
							                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							                            <span class="sr-only">Toggle Navigation</span>
							                            <i class="fa fa-navicon"></i>
							                        </button>
												</li>	
											</ul>								
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="main-navbar">

			                <div class="container">
			                	<div class="row">
				                    <div class="navbar-header page-scroll">
<?php 
$temp = $my->req_arr('SELECT * FROM logo WHERE id=1 ');
$logo_client='upload/logo/150X100/'.$temp['photo'];
?>
				                        <!-- WEBSITE LOGO --><!-- images/logo/logo.png -->
				                        <div class="logo" style=""><a href="index.php"><img src="<?php echo $logo_client; ?>" alt="Tousrenov, Devis gratuit en ligne et sans aucun engagement"></a></div>
				                    </div>

				                    <!-- MAIN NAV -->
				                    <div class="collapse navbar-collapse navbar-ex1-collapse menu">
				                        <ul class="nav navbar-nav">
				                           <li><a href="index.php">Accueil</a></li>
											<li><a href="services.php">Nos services</a></li>
											<li><a href="activites.php">Nos activit&eacute;s</a></li>
											<li><a href="conseils.php">Conseils</a></li>
											<li><a href="simulateur.php">Simulateur</a></li>										
											<li><a href="propos.php">A  propos</a></li>
											<li><a href="annonces.php"><span>Annonces</span></a></li>
				                           <li><a href="#" onClick="window.open('chat.php','popup','width=800,height=500,left=200,top=200,scrollbars=1')">Chat</a></li>
											<li><a href="contact.php">Contact</a></li>
											<li><a href="recherche.php"><i class="fa fa-search"></i></a></li>
				                        </ul>
				                    </div>
				                    <!-- END MAIN NAV -->
				                </div>
			                </div>
						</div>
		            </div>
				</header>