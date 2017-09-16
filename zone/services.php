<?php
session_start();
require('mysql.php');$my=new mysql();

$pageTitle = "Nos services"; 
include('inc/head.php');?>
	<body id="page1">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
<!--==============================aside================================-->
				
<!--==============================content================================-->
					<div class="wrapper">
						<div class="head-page-style1 subtitle">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
								<div class="header-page">
									<h2>Nos services</h2>
									<!-- <h5>Devis gratuit en ligne et sans aucun engagement</h5> -->
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
							</div>
								<div class="represtant-image">
									<div class="thumbnail">
										<?php $temp = $my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['user_zone'].' ');  ?>
										<img src="../upload/zcoordonnees/310X280	/<?php echo $temp['photo'];?>">
									</div>
								</div>

								<div class="search-btn" >
									<a href="recherche.php">Recherche</a>
								</div>
						</div>

			<div id="content">
				<div class="container">
					<div class="row">

					
<?php 
if ( isset($_GET['id']) )
{
	$temp = $my->req_arr('SELECT * FROM ttre_service WHERE id='.$_GET['id'].' ');
	$photo='';
	if ( !empty($temp['photoi']) ) $photo='upload/services/350X240i/'.$temp['photoi'];
	echo'
		<img src="'.$photo.'" alt="'.$temp['titre'].'">
		<h3>'.$temp['titre'].'</h3>
		<p>'.$temp['description'].'</p>
		';
}
else
{
?>						
						<section id="services" class="">
							<div class="container"> 
								<div class="row">
									<div class="title2">
										
									</div>
									<div class="services">
										<?php 
											function couper($chaine,$length)
											{
												if(strlen($chaine)>$length)
													return substr_replace (substr($chaine,0,$length),' ...',strrpos(substr($chaine,0,$length),' '));
												return $chaine;
											}
											$req = $my->req('SELECT * FROM ttre_service WHERE id_user='.$_SESSION['user_zone'].' ORDER BY id DESC');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													$photo='../upload/services/_no_1.jpg';
													if ( !empty($res['photoi']) ) $photo='../upload/services/350X240i/'.$res['photoi'];
													echo'
														<div class="col-md-4" style="height:450px;">
															<div class="service">
																<div class=""><img src="'.$photo.'" alt="'.$res['titre'].'"></div>
																<h3>'.$res['titre'].'</h3>
																<p>'.couper(strip_tags($res['description']),250).'</p>
																<p><a href="services.php?id='.$res['id'].'">Lire la suite</a></p>
															</div>
														</div>
														';
												}
											}
										?>											
									</div>
								</div>
							</div>
						</section>								
							
<?php 
}
?>							
							
								
								<!-- 
									<article class="services">
										<h3>
 Devis travaux maison en ligne 
										</h3>
										<div class="service-box">
										<p>
Particulier faire une demande de devis personalisé ou bien instantané, il met en ligne son devis sans coordonnees, trouver un artisan disponible, devis travaux gratuit, courtier en batiment, courtier, devis travaux immediat.
Tousrenov le met en contact avec un ou pluiseurs artisans pour faire ses travaux de renovation,menuiseirie,maconnerie,electricite,plomberie.
										</p>
										<img src="images/slider/serv1.jpg" alt="Devis travaux maison">
										</div>
									</article>

									<article class="services">
										<h3>
  Devis gratuit en ligne  
										</h3>
										<div class="service-box">
										<p>
Particulier faire une demande de devis personalisé ou bien instantané, il met en ligne son devis sans coordonnees, trouver un artisan disponible, devis travaux gratuit, courtier en batiment, courtier, devis travaux immediat.
Tousrenov le met en contact avec un ou pluiseurs artisans pour faire ses travaux de renovation,menuiseirie,maconnerie,electricite,plomberie.
										</p>
										<img src="images/slider/serv2.jpg" alt="Devis travaux maison">
										</div>
									</article>

									<article class="services">
										<h3>
  Trouver un artisan !  
										</h3>
										<div class="service-box">
										<p>
Particulier faire une demande de devis personalisé ou bien instantané, il met en ligne son devis sans coordonnees, trouver un artisan disponible, devis travaux gratuit, courtier en batiment, courtier, devis travaux immediat.
Tousrenov le met en contact avec un ou pluiseurs artisans pour faire ses travaux de renovation,menuiseirie,maconnerie,electricite,plomberie.										</p>
										<img src="images/slider/serv3.jpg" alt="Devis travaux maison">
										</div>
									</article>
									 -->
									
									
									
<div class="col-md-12">
					<div class="get-quote">						
						<div class="quote-img">
							<img src="../images/images/conseil-man-small.png" alt="Créer devis" >
						</div>
						<div class="quote-text">
								<h2>Devis Travaux Rénovation</h2>
								<p>Votre devis détaillée en ligne : Créer votre devis et ayez une estimations rapide de vos travaux</p>
						</div>
						<div class="quote-btns">
								<a href="devis.php" class="create">Créer votre devis</a>
								<a href="prix-travaux.php" class="get">Devis Immédiat</a>
						</div>
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
													if ( !empty($res['photo']) ) $photo='upload/diaporamas/150X150/'.$res['photo'];
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
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>