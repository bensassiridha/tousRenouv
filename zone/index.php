<?php
session_start();
require('mysql.php');$my=new mysql();

/*
$_SESSION['zone']=76;
$zz = $my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$_SESSION['zone'].'  ');
$_SESSION['user_zone']=$zz['id_user'];
*/

$pageTitle = "Tousrenov | Devis gratuit en ligne et sans aucun engagement"; 
 include('inc/head.php');?>
	<body>
<!--==============================header=================================-->
			
<?php include('inc/entete.php');?>
		
<!--==============================aside================================-->

						<section id="slider-fullwidth" class="slider-fullwidth-section">
							<div class="container">
								<div class="row">
								<div class="departement">

								</div>
									<div class="slider-info">
									<div class="departement-carte">
										<div class="thumbnail">
											<?php $temp = $my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['user_zone'].' ');  ?>
											
											<img src="../upload/zcoordonnees/310X280/<?php echo $temp['photo'];?>">

										</div>
										<div class="cart-info clearfix">
											<p>Je suis votre conseiller en travaux pour vous aidez gratuitement dans le departement :</p>
											<ul>
												<li id="location"><i class="fa fa-map-marker"></i></li>
												<li><a><i class="fa fa-envelope"></i> <?php $temp = $my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['user_zone'].' '); echo $temp['email']; ?></a></li>
												<li><a><i class="fa fa-phone"></i> <?php $temp = $my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['user_zone'].' '); echo $temp['tel']; ?></a></li>
											</ul>
										</div>
									</div>
										<!-- <h1>Recevez Instantanément<br/> Une Offre Détaillée et Personnalisée<br/>Ou La Visite d'un ou  Plusieurs Artisans</h1>
											<ul>
												<li><a href="devis.php" class="btn1">Créer Votre Devis</a></li>
												<!-- <li><a href="prix-travaux.php" class="btn2">Devis immédiat</a></li> -->
												<!-- <li><a href="recherche.php" class="btn3">Recherche</a></li>
											</ul> -->
									</div>  
								</div>
							</div>
						</section>

							<section id="about" class="about-section">
							<div class="container">
								<div class="row">
									<div class="title0">
										<h2>QUI SOMMES NOUS ?</h2>
										<p>Tousrenov.fr : un service sur mesure Pas de travaux sans devis. Et parce qu’on sait que la réalisation du devis est cruciale ainsi que celle du choix d artisan, www.tousrenov.fr s en charge de les faires pour vous. Tousrenov.fr est une plateforme de service en ligne de chiffrage du cout de vos travaux, sans engagement et gratuite...</p>
										<a href="propos.php">En savoir plus</a>
									</div>
								</div>
							</div>
						</section>

						<section id="espaces" class="espace-clients">
							<div class="container">
								<div class="row">
                                    <div class="col-md-7 col-xs-12">
                                        <div class="particulier">
                                        	<div class="overlay1"></div>
                                        	<img src="../images/images/part-client.jpg" alt="Devis Travaux Rénovation">
                                            <div class="title1">
                                                <h2>Particulier</h2>
                                            </div>
                                            <div class="espace-desc">
                                                <span>Devis Travaux Rénovation</span>
                                                <p>Votre devis détaillée en ligne : Créer votre devis et ayez une estimations rapide de vos travaux</p>
                                            </div>
                                            <div class="devis-btns">
                                                <div class="creer-devis">
                                                    <a href="devis.php">Créer votre devis</a>
                                                </div>
                                                <div class="devis-immediat">
                                                    <a href="prix-travaux.php"><span>Devis Immédiat</span><br/><p>Recevez instantanément une offre détaillée et personnalisée</p></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class=" col-md-5 col-xs-12">
                                        <div class="professionnal">
                                        	<div class="overlay2"></div>
                                        	<img src="../images/images/prof-client.jpg" alt="Partenaire">
                                            <div class="title1">
                                                <h2>Entreprise</h2>
                                            </div>
                                            <div class="espace-desc">
                                                <span>Devenez Partenaire !</span>
                                                <p>Gestion facile et rapide de vos devis , factures ...</p>
                                                
                                            </div>
                                            <div class="account-btn">
                                                <span>Vous n’êtes pas inscrit ?</span>
                                                <div class="creer-compte">
                                                    <a href="espace_professionnel.php">Créer votre compte</a>
                                                </div>
                                                <div class="recherche-btn">
                                                    <a href="prix-travaux.php"><span>Recherche</span><br/><p>Recherche chantiers prés de chez vous</p></a>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
						</section>

						<section id="services" class="services-section">
							<div class="container">
								<div class="row">
									<div class="title2">
										<div class="divder"></div>
										<h2>SERVICES</h2>
										<!-- <img src="'.$photo.'" alt="'.$res['titre'].'"> -->
									</div>
									<div class="services">
										<?php 
											function couper($chaine,$length)
											{
												if(strlen($chaine)>$length)
													return substr_replace (substr($chaine,0,$length),' ...',strrpos(substr($chaine,0,$length),' '));
												return $chaine;
											}
											$req = $my->req('SELECT * FROM ttre_service ORDER BY rand() LIMIT 0,3');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													$photo='upload/services/_no_1.jpg';
													if ( !empty($res['photoi']) ) $photo='upload/services/350X240i/'.$res['photoi'];
													echo'
														<div class="col-md-4">
															<div class="service">
																<div class="icon-services"><img src="../images/images/chiffrer-vos-travaux.png" alt="Chiffrer le cout de vos travaux" /></div>
																<h3>'.$res['titre'].'</h3>
																<p>'.couper(strip_tags($res['description']),310).'</p>
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

						<section id="conseils" class="section-conseils">
							<div class="container">
								<div class="row">
									<div class="col-md-4">
										<img src="../images/images/conseil-man.png" alt="conseil">
									</div>

									<div class="col-md-8">
										<div class="title2">
											<div class="divder"></div>
											<h2>CONSEILS</h2>
										</div>
												<?php 
													$req = $my->req('SELECT * FROM ttre_conseil ');
													if ( $my->num($req)>0 )
													{
														$i=1;
														while ( $res=$my->arr($req) )
														{
															if ( $i==1 ) { $active='active'; $in='in'; } else { $active=''; $in=''; }
															echo'
																<div class="col-md-6">
																	<div class="conseil">
																		<a href="single.php?id='.$res['id'].'">    
												 							<i class="fa fa-check"></i> <span>'.$res['titre'].'</span>
																		</a>
																		<span class="conseil-description">
																			'.couper(strip_tags($res['description']),170).'
														                </span>			
														            </div>														
																</div>
																';
															$i++;
														}
													}
												?>  
									</div>
									
								</div>
							</div>
						</section>

						<section id="simulator" class="simulator-section">
							<div class="container">
								<div class="row">
									<div class="col-md-4">
										<?php 
										$cat = $my->req_arr('SELECT * FROM ttre_email WHERE id=6 ');
										
												echo '<div class="title2">
													<div class="divder"></div>
													<h2>simulateur</h2>
												</div>
												<div class="msg">';
														echo $cat['description'];
												echo '</div>'; ?>
									</div>	
										<?php
										$req=$my->req('SELECT * FROM ttre_simulateur ORDER BY rand() LIMIT 0,2');
										if ( $my->num($req)>0 )
										{
											while ( $res=$my->arr($req) )
											{
												echo'<div class="col-md-4 col-xs-12">
														<div class="simulator-box"><a href="'.$res['url'].'"><div class="overlay3"></div><span>'.$res['titre'].'</span></a></div>
													</div>';
											}
										}
										?> 
									</div>
								</div>
						</section>

						
 <section id="partner">
							<div class="container section4">
								<div class="row">
									<div class="partner">
										<div class="col-md-12">
											<div class="title2">
												<div class="divder"></div>
												<h2>Partenaires</h2>
											</div>
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
														<div class="item"><a target="_blanc" href="'.$res['lien'].'"><img src="'.$photo.'" alt="'.$res['titre'].'"/></a></div>
														';
												}
												echo'</div>';
											}
											?>	
											</div>
										</div>
								</div>
							</div>
						</section> 
						
						
						
						
						
						
												
						<!--  
						<section id="partner" class="partner-section clearfix">
							<div class="container">
								<div class="row">
									<div class="partner">
										<div class="col-md-12">
											<div class="title2">
												<div class="divder"></div>
												<h2>Partenaires</h2>
											</div>
												<div class="well">
								                    <div id="myCarousel" class="carousel fdi-Carousel slide">

							                        <div class="carousel fdi-Carousel slide" id="eventCarousel" data-interval="0">
							                            
							                            <?php 
															/*$req = $my->req('SELECT * FROM ttre_diaporama ');
															if ( $my->num($req)>0 )
															{
																echo'<div class="carousel-inner onebyone-carosel"><div class="item">';
																while ( $res=$my->arr($req) )
																{
																	$photo='upload/diaporamas/_no_2.jpg';
																	if ( !empty($res['photo']) ) $photo='upload/diaporamas/150X150/'.$res['photo'];
																	echo'
																		<div class="col-md-2"><a target="_blanc" href="'.$res['lien'].'"><img src="'.$photo.'" alt="'.$res['titre'].'"/></a></div>
																		';
																}
																echo'</div></div>';
															}*/
														?>	
							                                
							                        </div>
							                            <a class="left carousel-control" href="#eventCarousel" data-slide="prev"></a>
							                            <a class="right carousel-control" href="#eventCarousel" data-slide="next"></a>
							                        </div>
							                    </div>
                						</div>									
											
									</div>
								</div>
							</div>
						</section>-->


<!--==============================footer=================================-->

<script type="text/javascript">
	$(document).ready(function () {
    $('#myCarousel').carousel({
        interval: 10000
    })
    $('.fdi-Carousel .item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        if (next.next().length > 0) {
            next.next().children(':first-child').clone().appendTo($(this));
        }
        else {
            $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
        }
    });
});
</script>
<?php include('inc/pied.php');?>

	</body>
</html>