<?php
require('mysql.php');$my=new mysql();


include('inc/head.php');?>
	<body id="page1">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
					<div class="wrapper">
						<div class="hed">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
								<div class="header-page">
									<h2>Nos services</h2>
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
						</div>

						<div id="content">
							<div class="container">
								<div class="row">
									<article class="services">
										<h3>
 Devis travaux maison en ligne 
										</h3>
										<div class="service-box">
										<p>
particulier faire une demande de devis personalisé ou bien instantané, il met en ligne son devis sans coordonnees, trouver un artisan disponible, devis travaux gratuit, courtier en batiment, courtier, devis travaux immediat.
tousrenov le met en contact avec un  ou pluiseurs artisans   pour faire ses travaux de renovation,menuiseirie,maconnerie,electricite,plomberie
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
particulier faire une demande de devis personalisé ou bien instantané, il met en ligne son devis sans coordonnees, trouver un artisan disponible, devis travaux gratuit, courtier en batiment, courtier, devis travaux immediat.
tousrenov le met en contact avec un  ou pluiseurs artisans   pour faire ses travaux de renovation,menuiseirie,maconnerie,electricite,plomberie
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
particulier faire une demande de devis personalisé ou bien instantané, il met en ligne son devis sans coordonnees, trouver un artisan disponible, devis travaux gratuit, courtier en batiment, courtier, devis travaux immediat.
tousrenov le met en contact avec un  ou pluiseurs artisans   pour faire ses travaux de renovation,menuiseirie,maconnerie,electricite,plomberie
										</p>
										<img src="images/slider/serv3.jpg" alt="Devis travaux maison">
										</div>
									</article>
								</div>
							</div>
						</div>
					</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>