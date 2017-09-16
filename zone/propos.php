<?php
session_start();
require('mysql.php');$my=new mysql();
$pageTitle = "A propos | Devis gratuit en ligne et sans aucun engagement"; 
include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
					<div class="head-page-style7 subtitle">
						<div class="container">
							<div class="row">
							<div class="col-md-12"> 
								<h2>Qui sommes nous</h2>
								<!-- <h1>Devis gratuit en ligne et sans aucun engagement</h1> -->
								<div class="formulaire">
									<h6>Formulaire</h6>
										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a target="_blanc" href="../upload/fichiers/'.$res['fichier'].'">'.$res['titre'].'</a></li>';
												}
											}
										?>
										</ul>
									</div>
									<!-- <div class="bttn-devis">
										<ul>
											<li><a href="devis.php"><i>Cr&eacute;er votre devis</i></a></li>
											<li><a href="prix-travaux.php"><i>Devis Imm&eacute;diat</i></a></li>
										</ul>
									</div> -->
								</div>
							</div>
						</div>
									<div class="search-btn" >
										<a href="recherche.php">Recherche</a>
									</div>						
					</div>
					<div id="content">
							<div class="container">
								<div class="row">
								<div class="propos">
									<img src="../images/slider/slider-img2.jpg" alt="Tousrenov demande de devis en ligne">
									<div class="text">
										<?php
												$req=$my->req_arr('SELECT * FROM ttre_presentation WHERE id = 2');
												echo $req['description'];

												?>
									</div>
								</div>
							</div>
						</div>
					</div>
											<!-- <section id="partner">
							<div class="container section4">
								<div class="row">
									<div class="partner">
										<div class="col-md-12">
											<div class="title"><h6>Partenaires</h6></div><hr>
											<?php 
											$req = $my->req('SELECT * FROM ttre_diaporama ');
											if ( $my->num($req)>0 )
											{
												echo'<div id="owl-demo">';
												while ( $res=$my->arr($req) )
												{
													$photo='upload/diaporamas/_no_2.jpg';
													if ( !empty($res['photo']) ) $photo='../upload/diaporamas/150X150/'.$res['photo'];
													echo'
														<div class="item"><img src="'.$photo.'" alt="'.$res['titre'].'"/></div>
														';
												}
												echo'</div>';
											}
											?>	
											</div>
										</div>
								</div>
							</div>
						</section> -->
				</div>	

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>

<?php include('inc/pied.php');?>
	</body>
</html>