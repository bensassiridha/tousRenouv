<?php
require('mysql.php');$my=new mysql();

include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
				</header>
<!--==============================header=================================-->
				<div class="wrapper">
					<div class="header-page-propos">
						<div class="container">
							<div class="row">
							<div class="col-md-12">
								<h2>Qui sommes nous</h2>
								<div class="formulaire">
									<h6>Formulaire</h6>
										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a href="upload/fichiers/'.$res['fichier'].'" target="_blanc">'.$res['titre'].'</a></li>';
												}
											}
										?>
										</ul>
									</div>
									<div class="bttn-devis">
										<ul>
											<li><a href="devis.php"><i>Créer votre devis</i></a></li>
											<li><a href="prix-travaux.php"><i>Devis Immédiat</i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="content">
							<div class="container">
								<div class="row">
								<div class="propos">
									<img src="images/slider/slider-img2.jpg">
									<div class="text">
										<p>Ici bientôt un site internet pour faire vos devis en ligne gratuit afin de chiffrer le côut de vos travaux de rénovation Travaux interieur et exterieur, electricite, plomberie, mensuiserie, maconnerie jardinage.</p>
										<ul>
											<li>Trouver un artisan disponible,</li>
											<li>Trouver un electricien,</li>
											<li>Trouver un plombier,</li>
											<li>Trouver un macon,</li>
											<li>Trouver un peintre,</li>
										</ul>
										Pour les artisan trouver un chantier pres de chez vous.
										devis travaux immediat gratuit et en ligne, devis gratuit sans engagement.
										<p>Ici vous pouvez demandez devis gratuitement et sur mesure et sans engagement de votre part.
										ce concerne les artisants ainsi que les particuliers.
										Inscrivez vous sur notre espace et gérez librement vos espace personnel.</p>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>

<?php include('inc/pied.php');?>
	</body>
</html>