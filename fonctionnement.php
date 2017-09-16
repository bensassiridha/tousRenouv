<?php
require('mysql.php');$my=new mysql();
 include('inc/head.php');?>
	<body id="page1">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
					<div class="wrapper">
						<div class="header-page-part">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
								<div class="header-page">
									<h2>Fonctionnement</h2>
									<div class="formulaire">
									<h6>Formulaire</h6>
										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a target="_blanc" href="upload/fichiers/'.$res['fichier'].'" target="_blanc">'.$res['titre'].'</a></li>';
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
								<div class="col-md-12">
									<div class="">
										<?php
										$req=$my->req_arr('SELECT * FROM ttre_fonct WHERE id = 1');
										echo $req['description'];
										?>
									</div>

<?php // include('inc/droite.php');?>
									</div>
								</div>
							</div>
						</div>
					</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>