<?php
require('mysql.php');$my=new mysql();
$pageTitle = "A propos | Devis gratuit en ligne et sans aucun engagement"; 
include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
					<div class="header-page">
						<div class="container">
							<div class="row">
								<h2 class="page-title">Qui Sommes Nous ?</h2>
							</div>
						</div>
						
					</div>

					<div id="content">

							<section class="aboutus-section">

								<div class="container">

									<div class="col-md-6">
										<div class="text">
											
											<h1>Devis de Renovation Gratuit en ligne et sans Engagement</h1>
											<div class="aboutus-description">
												<?php
												$req=$my->req_arr('SELECT * FROM ttre_presentation WHERE id = 2');
												echo $req['description'];

												?>
											</div>
											<a href="devis.php" class="btn1"><i class="fa fa-paper-plane" aria-hidden="true"></i> Créer Votre Devis</a>
											
										</div>
									</div>

									<div class="col-md-6">
										<img src="images/devis-renovation-gratuit.png" alt="Tousrenov demande de devis en ligne">
									</div>

								</div>

							</section>

							<section id="looking-for-projects" class="looking-for-projects-section">

								<div class="container">
									<div class="looking-for-projects">
										<div class="col-md-5">
											<img src="../images/man-image.png" alt="Profissionnel du batiment">
										</div>
										<div class="col-md-7">
											<h2>Professionnel Du Batiment</h2>
											<p><b>Vous cherchez des chantiers ?</b></p>
											<p>Rejoingez nous et assurez vous d'obtenir régulierement des chantiers de Qualité et 100% Qualifiés</p>
											<div class="looking-for-projects-btn">
												<a href="recherche.php" class="btn3"><i class="fa fa-search" aria-hidden="true"></i> Recherche</a>
											</div>
										</div>
									</div>
								</div>

							</section>
							<section id="references" class="references-section">
								<div class="container">
									<div class="row">
										<div class="col-md-12">

											<div class="title-block">
												<h2>Partenaires</h2>
												<!-- <img src="'.$photo.'" alt="'.$res['titre'].'"> -->
											</div>
											<?php 
											$req = $my->req('SELECT * FROM ttre_diaporama ');
											if ( $my->num($req)>0 )
											{
												echo'<div id="clients-logos">';
												while ( $res=$my->arr($req) )
												{
													$photo='upload/diaporamas/_no_2.jpg';
													if ( !empty($res['photo']) ) $photo='upload/diaporamas/150X150/'.$res['photo'];
													echo'
														<div class="item"><a target="_blanc" href="'.$res['lien'].'"><img src="'.$photo.'" alt="'.$res['titre'].'"/></a></div>
														';
												}
												echo'</div>';
											}
											?>	
											</div>
									</div>
								</div>
							</section> 

					</div>

					 
				</div>	

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>

<?php include('inc/pied.php');?>
	</body>
</html>