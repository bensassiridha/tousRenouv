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
						<div class="header-page">
							<div class="container">
								<div class="row">
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
								</div>
							</div>
						</div>

						<div id="content">
							<article class="services">
								<div class="container">
									<div class="row">
										<h3>
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 2');
												echo $req['titre'];
											?>
										</h3>

										<p>
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 2');
												echo $req['description'];
											?>
										</p>
										<img src="images/slider/serv1.jpg">
									</div>
								</div>
							</article>

							<article class="services">
								<div class="container">
									<div class="row">
										<h3>
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 3');
												echo $req['titre'];
											?>
										</h3>

										<p>
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 3');
												echo $req['description'];
											?>
										</p>
										<img src="images/slider/serv2.jpg">
									</div>
								</div>
							</article>

							<article class="services">
								<div class="container">
									<div class="row">
										<h3>
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 4');
												echo $req['titre'];
											?>
										</h3>

										<p>
											<?php
												$req=$my->req_arr('SELECT * FROM ttre_service WHERE id = 4');
												echo $req['description'];
											?>
										</p>
										<img src="images/slider/serv3.jpg">
									</div>
								</div>
							</article>
						</div>
					</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>