<?php
session_start();
require('mysql.php');$my=new mysql();
$pageTitle = "Nos activités"; 
include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
						<div class="head-page-style2 subtitle">
							<div class="container">
								<div class="row">
								<div class="col-md-12">
									<h2>Nos Activit&eacute;s</h2>
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

						<div class="activite">
							<div class="container">
								<div class="row">
<!-- 									<div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </div> -->
										
										
										
<?php 
$temp=$my->req_arr('SELECT * FROM ttre_categories_details WHERE id=-1');
echo'<div class="desc">'.$temp['description'].'</div>';
$req = $my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
if ( $my->num($req)>0 )
{
	while ( $res=$my->arr($req) )
	{
		$resa = $my->req_arr('SELECT * FROM ttre_categories_details WHERE id='.$res['id'].' ');
		$photo='../upload/logosCateg/_no_1.jpg';
		if ( !empty($resa['photo']) ) $photo='../upload/logosCateg/550X240a/'.$resa['photo'];
		echo'
		<div class="col-md-6 col-xs-12">
			<div class="act effect">
				
				<img src="'.$photo.'" alt="'.$res['titre'].'" width="550" height="240" >
				<h3>'.$res['titre'].'</h3>
				<p>'.$resa['description'].'</p>
				<a href="prix-travaux.php?cat='.$res['id'].'">Creer devis</a>
				
			</div>
		</div>
			';
	}
}
?>										
									
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
<?php include('inc/pied.php');?>
	</body>
</html>