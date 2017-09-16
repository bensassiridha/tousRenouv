<?php
require('mysql.php');$my=new mysql();



$pageTitle = "Tousrenov | Devis gratuit en ligne et sans aucun engagement"; 
 include('inc/head.php');?>
	<body>
<!--==============================header=================================-->
			
<?php include('inc/entete.php');?>
		
<!--==============================aside================================-->

						<section id="slider-fullwidth" class="slider-fullwidth-section">
							<div class="container">
								<div class="row">
									<div class="col-md-8">
										<div class="slider-info">
										<h1>Recevez Instantan�ment<br/> Une Offre D�taill�e et Personnalis�e<br/>Ou la Visite d'un ou  Plusieurs Artisans</h1>
											<ul>
												<li><a href="devis.php" class="btn1"><i class="fa fa-paper-plane" aria-hidden="true"></i> Cr�er Votre Devis</a></li>
												<li><a href="prix-travaux.php" class="btn2"><i class="fa fa-rocket" aria-hidden="true"></i> Devis imm�diat</a></li>
												<li><a href="recherche.php" class="btn3"><i class="fa fa-search" aria-hidden="true"></i> Nos chantiers disponible</a></li>
											</ul>
									</div>
									</div>

									<div class="col-md-4">
										<div class="get-free-quote-form">
										<form id="ajax-contact" role="form" action="mailer.php" method="post" class="registration-form">
                        		
			                        		<fieldset>
					                        	<div class="form-top">
					                        		<div class="form-top-left">
					                        			<h3>Mon Projet</h3>
					                            		<p>D�crivez votre projet</p>
					                        		</div>
					                            </div>
					                            <div class="form-bottom">
							                    	
							                        <div class="form-group">
							                        	<label class="sr-only" for="form-about-project">About yourself</label>
							                        	<textarea name="form-about-project" placeholder="Votre Projet" 
							                        				class="form-about-project form-control" id="form-about-project"></textarea>
							                        </div>
							                        <button type="button" class="btn btn-next">Suivant</button>
							                    </div>
						                    </fieldset>
						                    
						                    <fieldset>
					                        	<div class="form-top">
					                        		<div class="form-top-left">
					                        			<h3>Mes coordonn�es</h3>
					                            		<p>Compl�ter vos information personnelles</p>
					                            		<div id="form-messages"></div>
					                        		</div>
					                        	
					                            </div>
					                            <div class="form-bottom">
					                           		<div class="form-group col-md-6">
					                           			<div class="row">
							                    		<label class="sr-only" for="form-first-name">Nom</label>
							                        	<input type="text" name="form-first-name" placeholder="Nom..." class="form-first-name form-control" id="form-first-name">
							                        	</div>
							                        </div>
							                        <div class="form-group col-md-6">
							                        	<div class="row">
							                        	<label class="sr-only" for="form-last-name">Pr�nom</label>
							                        	<input type="text" name="form-last-name" placeholder="Pr�nom..." class="form-last-name form-control" id="form-last-name">
							                        	</div>
							                        </div>
							                        <div class="form-group">
							                        	<label class="sr-only" for="form-email">Email</label>
							                        	<input type="text" name="form-email" placeholder="Email..." class="form-email form-control" id="form-email">
							                        </div>
							                        <div class="form-group">
							                    		<label class="sr-only" for="form-phone">T�l�phone</label>
							                        	<input type="tel" name="form-phone" placeholder="T�l�phone..." class="form-password form-control" id="form-phone">
							                        </div>
							                        <div class="form-group">
							                        	<label class="sr-only" for="form-adresse">Adresse</label>
							                        	<input type="text" name="form-adresse" placeholder="Adresse..." class="form-adresse form-control" id="form-adresse">
							                        </div>
							                        <div class="form-group col-md-6">
							                        	<div class="row">
							                        	<label class="sr-only" for="form-cp">Code Postal</label>
							                        	<input type="text" name="form-cp" placeholder="Code Postal..." class="form-cp form-control" id="form-cp">
							                        	</div>
							                        </div>
							                        <div class="form-group col-md-6">
							                        	<div class="row">
							                    		<label class="sr-only" for="form-city">Ville</label>
							                        	<input type="text" name="form-city" placeholder="Ville..." class="form-city form-control" id="form-city">
							                        	</div>
							                        </div>
							                        <button type="button" class="btn btn-previous">Retour</button>
							                        <button type="submit" class="btn">Valider</button>
							                    </div>
						                    </fieldset>
					                    </form>  
										</div>
									</div>
								</div>
							</div>
						</section>

						<section id="about" class="about-section clearfix">
								<div class="col-md-12">
									<div class="row">
										<div class="content-block">
											<div class="title-block">
												<h2>QUI SOMMES NOUS ?</h2>

												<div class="content-description">
												 <?php

													$req=$my->req_arr('SELECT * FROM ttre_presentation WHERE id = 2');
                                                     //print_r($req);die('ici !! ');
													$chaine=$req['description'];
													echo '<div class="content-description">'.substr_replace (substr($chaine,0,160),' ...',strrpos(substr($chaine,0,160),' ')).'</div>';
													echo '<div class="content-description">'. $chaine.'</div>';

													?>	

												</div>
												<a href="propos.php">En savoir plus <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
											</div>
										</div>
									</div>
								</div>

								
							</section>	

						<section id="espaces" class="espace-clients">
							<div class="container">
								<div class="row">
                                    <div class="col-md-4 col-xs-12">
                                        <div class="account">
                                        	<div class="account-content">
	                                            <h1 class="account-title">Particulier</h1>
	                                            <div class="account-description">
	                                                <h2>Devis Travaux R�novation</h2>
	                                                <p>Votre devis d�taill�e en ligne : Cr�er votre devis et ayez une estimations rapide de vos travaux</p>
	                                                
	                                            </div>
	                                            <div class="account-call-to-action">
	                                                <div class="new-account">
	                                                    <a href="devis.php">Cr�er votre devis</a>
	                                                </div>
	                                                <div class="search">
	                                                    <a href="prix-travaux.php">
		                                                    <span>Devis Imm�diat</span>
		                                                    <p>Recevez instantan�ment une offre d�taill�e</p>
	                                                    </a>
	                                                </div>
	                                            </div>
                                        	</div>

                                        	<img src="../images/particluier.jpg" alt="Devis Travaux R�novation">

                                        </div>
                                    </div>
									<div class=" col-md-4 col-xs-12">
                                        <div class="account">
                                            <div class="account-content">
	                                            <h1 class="account-title">Entreprise</h1>
	                                            <div class="account-description">
	                                                <h2>Devenez Partenaire !</h2>
	                                                <p>Gestion facile et rapide de vos devis , factures ...</p>
	                                                
	                                            </div>
	                                            <div class="account-call-to-action">
	                                                <span class="text">Vous n��tes pas inscrit ?</span>
	                                                <div class="new-account">
	                                                    <a href="espace_professionnel.php">Cr�er votre compte</a>
	                                                </div>
	                                                <div class="search">
	                                                    <a href="recherche.php">
		                                                    <span>Recherche</span>
		                                                    <p>Recherche chantiers pr�s de chez vous</p>
	                                                    </a>
	                                                </div>
	                                            </div>
                                        	</div>
                                        	<img src="../images/professionnel.jpg" alt="Devenez Partenaire !">
                                        </div>
									</div>

									<div class=" col-md-4 col-xs-12">
                                        <div class="account">
                                        	<div class="account-content">
	                                            <h1 class="account-title">Affili�</h1>
	                                            <div class="account-description">
	                                                <h2>Devenez affili�</h2>
	                                                <p>Gestion facile et rapide de vos devis , factures ...</p>
	                                                
	                                            </div>
	                                            <div class="account-call-to-action">
	                                                <span class="text">Vous n��tes pas inscrit ?</span>
	                                                <div class="new-account">
	                                                    <a href="espace_affilier.php">Cr�er votre compte</a>
	                                                </div>
	                                                <div class="search">
	                                                    <a href="recherche.php">
		                                                    <span>Recherche</span>
		                                                    <p>Recherche chantiers pr�s de chez vous</p>
	                                                    </a>
	                                                </div>
	                                            </div>
                                        	</div>
                                        	<img src="../images/affilier.jpg" alt="Devenez affili�">
                                        </div>
									</div>
								</div>
							</div>
						</section>

						<section id="looking-for-projects" class="looking-for-projects-section">
							<div class="container">
								<div class="looking-for-projects">
									<div class="col-md-5">
										<img src="../images/man-image.png" alt="Profissionnel du batiment">
									</div>
									<div class="col-md-7">
										<h2>Professionnel Du Batiment</h2>
										<p><b>Vous cherchez des chantiers ?</b></p>
										<p>Rejoingez nous et assurez vous d'obtenir r�gulierement des chantiers de Qualit� et 100% Qualifi�s</p>
										<div class="looking-for-projects-btn">
											<a href="recherche.php" class="btn3"><i class="fa fa-search" aria-hidden="true"></i> Recherche</a>
										</div>
									</div>
								</div>
							</div>
						</section>
				<section id="services" class="services-section">
					<div class="container">
						<div class="row">
							<div class="title-block">
								<h2>SERVICES</h2>
								<!-- <img src="'.$photo.'" alt="'.$res['titre'].'"> -->
							</div>
							<div class="services" id="services-carousel">
								<?php 
									function couper($chaine,$length)
									{
										if(strlen($chaine)>$length)
											return substr_replace (substr($chaine,0,$length),' ...',strrpos(substr($chaine,0,$length),' '));
										return $chaine;
									}
									$req = $my->req('SELECT * FROM ttre_service ORDER BY rand() LIMIT 0,9');
									if ( $my->num($req)>0 )
									{
										while ( $res=$my->arr($req) )
										{
											$photo='upload/services/_no_1.jpg';
											if ( !empty($res['photoi']) ) $photo='upload/services/350X240i/'.$res['photoi'];
											echo'
												<div class="col-md-12">
													<div class="service_block">
														<div class="thumbnail"><img src="'.$photo.'" alt="'.$res['titre'].'"></div>
														<div class="service-content">
															<h2>'.$res['titre'].'</h2>
															<p>'.couper(strip_tags($res['description']),110).'</p>
														</div>
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
							<div class="col-md-8">
								<div class="title2-block">
									<h2>CONSEILS</h2>
									<a class="read-more" href="http://tousrenov.fr/conseils.php">D�couvez nos Conseils</a>
								</div>
										<?php 
											$req = $my->req('SELECT * FROM ttre_conseil LIMIT 6');
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
																	'.couper(strip_tags($res['description']),140).'
												                </span>		
												                <a href="single.php?id='.$res['id'].'" class="read-more">En Savoir Plus</a>	
												            </div>														
														</div>
														';
													$i++;
												}
											}
										?>  
							</div>
								
							<div class="col-md-4">
								<img src="../images/images/conseil-man.png" alt="conseil">
							</div>
						</div>
					</div>
				</section>

						<!-- <section id="simulator" class="simulator-section">
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
						</section> -->

						
 						<section id="references" class="references-section">
							<div class="container">
								<div class="row">
									<div class="col-md-12">

										<div class="title-block">
											<h2>Partenaires</h2>
											<!-- <img src="'.$photo.'" alt="'.$res['titre'].'"> -->
										</div>
										<?php 
										$req = $my->req('SELECT * FROM ttre_diaporama ');
										if ( $my->num($req)>0 )
										{
											echo'<div id="clients-logos">';
											while ( $res=$my->arr($req) )
											{
												$photo='upload/diaporamas/_no_2.jpg';
												if ( !empty($res['photo']) ) $photo='upload/diaporamas/150X150/'.$res['photo'];
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
						</section> 
						
						
						
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