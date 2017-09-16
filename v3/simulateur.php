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

<!-- <iframe src="http://www.renovation-info-service.gouv.fr/simulation/" width="670px" height="1000px"></iframe> -->
					<div class="wrapper">
						<div class="header-page">
							<div class="container">
								<div class="row">
									<h2>Simulateur</h2>
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
							<article id="simulateur">
								<div class="container">
									<div class="row">
										<div class="simulateur col-md-12">
										<ul>
											<li><a target="_blanc" href="http://www.archimist.com/index.php?option=com_content&view=article&id=93&Itemid=64"><i>Simulateur d'energie</i></a></li>
											<li><a target="_blanc" href="http://www.renovation-info-service.gouv.fr/simulation/"><i>Prime rénovation énergétique</i></a></li>
										</ul>
										</div>
									</div>
								</div>
							</article>
						</div>
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