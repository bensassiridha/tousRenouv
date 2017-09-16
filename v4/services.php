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
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 2');
												echo $req['titre'];
											?>
										</h3>
										<div class="service-box">
										<p>
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 2');
												echo $req['description'];
											?>
										</p>
										<img src="images/slider/serv1.jpg" alt="Devis travaux maison">
										</div>
									</article>

									<article class="services">
												<h3>
													<?php
														$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 3');
														echo $req['titre'];
													?>
												</h3>
												<div class="service-box">
												<p>
													<?php
														$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 3');
														echo $req['description'];
													?>
												</p>
												<img src="images/slider/serv2.jpg" alt="Devis gratuit en ligne">
												</div>
									</article>

									<article class="services">
												<h3>
													<?php
														$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 4');
														echo $req['titre'];
													?>
												</h3>
												<div class="service-box">
												<p>
													<?php
														$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 4');
														echo $req['description'];
													?>
												</p>
												<img src="images/slider/serv3.jpg" alt="Trouver un artisan">
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