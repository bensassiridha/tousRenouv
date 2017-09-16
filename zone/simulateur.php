<?php
session_start();
require('mysql.php');$my=new mysql();
$pageTitle = "Simulateur"; 
include('inc/head.php');?>
	<body id="page1">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================aside================================-->
				
<!--==============================content================================-->

<!-- <iframe src="http://www.renovation-info-service.gouv.fr/simulation/" width="670px" height="1000px"></iframe> -->
					<div class="wrapper">
						<div class="head-page-style6 subtitle">
							<div class="container">
								<div class="row">
								<div class="col-md-12"> 
									<h2>Simulateur</h2> 
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
										<div class="col-md-12">
										<div class="simulateur">
										
<?php 
$req=$my->req('SELECT * FROM ttre_simulateur ORDER BY id DESC');
if ( $my->num($req)>0 )
{
	while ( $res=$my->arr($req) )
	{
		if ( !empty($res['photo']) )
		{
			echo'
				<div class="col-md-6">
					<div class="simulator-box1" style="background: rgba(0, 0, 0, 0) url(\'../upload/simulateur/540X250/'.$res['photo'].'\') repeat scroll 0 0;">
						<a target="_blanc" href="'.$res['url'].'">'.$res['titre'].'</a>
					</div>
				</div>
				';
		}
		else
		{
			echo'
				<div class="col-md-6">
					<div class="simulator-box1"><a target="_blanc" href="'.$res['url'].'">'.$res['titre'].'</a></div>
				</div>
				';
		}
	
	}
}
?>										
<!-- <li><a target="_blanc" href="http://www.archimist.com/index.php?option=com_content&view=article&id=93&Itemid=64"><i>Simulateur d'energie</i></a></li> -->
<!-- <li><a target="_blanc" href="http://www.renovation-info-service.gouv.fr/simulation/"><i>Prime rénovation énergétique</i></a></li> -->
											
											
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
											$req = $my->req('SELECT * FROM ttre_diaporama WHERE id_user='.$_SESSION['user_zone'].' ');
											if ( $my->num($req)>0 )
											{
												echo'<div id="owl-demo">';
												while ( $res=$my->arr($req) )
												{
													$photo='../upload/diaporamas/_no_2.jpg';
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

<!-- </div>
						</article>
<?php //include('inc/droite.php');?>
						</div>
					<div class="block"></div>
				</section>
			</div>
		</div> -->
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>