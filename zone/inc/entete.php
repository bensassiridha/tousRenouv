					<header>
					<div class="top-navbar">
						<div class="container">
							<div class="row">
								<div class="col-md-5">
									<div class="contact">
										<ul>
											<li><?php $temp = $my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$_SESSION['user_zone'].' '); echo $temp['nom']; ?></li> 
											<li><a href="contact.php"><i class="fa fa-envelope"></i><?php $temp = $my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['user_zone'].' '); echo $temp['email']; ?></a></li>
											<!--<li><i class="fa fa-phone"></i>+1 0 00 00 00 00</li><i class="sparator">|</i> -->
											<li><i class="fa fa-phone"></i><?php $temp = $my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['user_zone'].' '); echo $temp['tel']; ?></li>
										</ul>								
									</div>
								</div>
								<div class="col-md-7">
									<div class="space">
										<ul>									
											<!-- <li><span style="color:#fff;">BB | <a href="#">Déconnexion</a></span></li> -->

<?php 
$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');$option='';
while ( $resCat=$my->arr($reqCat) )
{
	$sel='';
	if ( $resCat['departement_id']==$_SESSION['zone'] ) $sel=' selected="selected" ';
	$option.='<option value="'.$resCat['departement_id'].'" '.$sel.'>'.$resCat['departement_nom'].'</option>';
}
echo'
	<li class="icon mobile-left">
		<form>
			<select name="sel_zone" id="selzone">
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
			 url: "https://www.tousrenov.fr/zone/AjaxZone.php",
			 data: "id="+$('select[name="sel_zone"]').val(),
			 success: function(msg)
				{			 
					//alert(msg);
					if ( msg=='' )
				 		window.location='https://www.tousrenov.fr/';
					else
				 		window.location='https://www.tousrenov.fr/'+msg+'/';
				 	
				}
		 });

	});

	var location = document.getElementById('selzone').options[document.getElementById('selzone').selectedIndex].text;
	$("#location").append(location);
});
</script>
										
											<li class="icon mobile-left"> <a href="annonces.php"><i class="fa fa-bullhorn"></i><span>Annonces</span></a></li>
											<?php 
											$temp = $my->req_arr('SELECT * FROM ttre_coordonnees WHERE id=3 ');
											if ( !empty($temp['val1']) ) echo'<li class="icon mobile-left"><a target="_blanc" href="'.$temp['val1'].'"><i class="fa fa-share"></i><span>Petites annonces</span></a></li>';
											?>	
											<li class="part-hover icon mobile-right"><a href="espace_particulier.php"><i class="fa fa-user"></i><span>Espace Particulier</span></a></li>
											<li class="pro-hover icon mobile-right"><a href="espace_professionnel.php"><i class="fa fa-briefcase"></i><span>Espace Professionnel</span></a></li>
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
										</ul>		 						
									</div>
								</div>
							</div>
						</div>
					</div>
<?php 
$temp = $my->req_arr('SELECT * FROM logo WHERE id=1 ');
$logo_client='../upload/logo/150X100/'.$temp['photo'];
?>					
					<div class="main-navbar">
						<div class="container">
							<div class="row">
									<div class="col-md-3"><div class="logo" style=""><a href="index.php"><img src="<?php echo $logo_client; ?>" alt="Tousrenov, Devis gratuit en ligne et sans aucun engagement"></a></div></div>
									<div class="col-md-9">
										<div class="menu" style="">
											<ul>
												<li><a href="index.php">Accueil</a></li>
												<li><a href="services.php">Nos services</a></li>
												<li><a href="activites.php">Nos activit&eacute;s</a></li>
												<li><a href="recherche.php">Recherche</a></li>
												<li><a href="conseils.php">Conseils</a></li>
												<li><a href="simulateur.php">Simulateur</a></li>										
												<li><a href="propos.php">A  propos</a></li>
												<li><a href="#" onClick="window.open('chat.php','popup','width=800,height=500,left=200,top=200,scrollbars=1')">Chat</a></li>
												<li><a href="contact.php">Contact</a></li>
											</ul> 
											
										<!-- <div class="zone-img" style=""></div> -->		
										</div>	
									</div>

							</div>
						</div>
					</div> 
					</header>