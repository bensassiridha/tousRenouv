<?php
session_start();
require('mysql.php');$my=new mysql();
$pageTitle = "Nos Conseils"; 
include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
						<div class="head-page-style4 subtitle">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
									<h2>Nos conseils</h2>
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
											<li><a href="devis.php"><i>Créer votre devis</i></a></li>
											<li><a href="prix-travaux.php"><i>Devis Immédiat</i></a></li>
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
<?php 

function couper($chaine,$length)
	{
		if(strlen($chaine)>$length)
			return substr_replace (substr($chaine,0,$length),' ...',strrpos(substr($chaine,0,$length),' '));
		return $chaine;
	}
$req = $my->req('SELECT * FROM ttre_conseil ');
if ( $my->num($req)>0 )
{
	while ( $res=$my->arr($req) )
	{
		$photo='../upload/conseils/_no_1.jpg';
		if ( !empty($res['photo']) ) $photo='../upload/conseils/1920X800/'.$res['photo'];
		echo'
			<div class="col-md-4 col-xs-12">
				<div class="conseil-box">		
					<div class="conseil-thumb"><img src="'.$photo.'" alt="'.$res['titre'].'"></div> 
					<div class="conseil-title">
						<a href="single.php?id='.$res['id'].'"><h2>'.$res['titre'].'</h2></a>
					</div>
					<div class="conseil-desc">
						'.couper(strip_tags($res['description']),270).'
					</div>
					<div class="readmore"><a href="single.php?id='.$res['id'].'">En savoir plus <i class="fa fa-long-arrow-right"></i></a></div>
				</div>
      		</div>
			';
	}
}
?>			


<div class="col-md-12">
	<div class="get-quote">						
		<div class="quote-img">
			<img src="../images/images/conseil-man-small.png" alt="Créer Devis" >
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
													
		

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>
<?php include('inc/pied.php');?>
	</body>
</html>