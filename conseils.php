<?php
require('mysql.php');$my=new mysql();
$pageTitle = "Nos Conseils"; 
include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
						<div class="header-page">
							<div class="container">
								<div class="row">
									<h2 class="page-title">Nos Conseils</h2>
								</div>
							</div>
							
						</div>
						<div id="content">
							<div class="container"> 
							<div class="row">

<div class="col-md-9">	
<?php 

function couper($chaine,$length)
	{
		if(strlen($chaine)>$length)
			return substr_replace (substr($chaine,0,$length),' ...',strrpos(substr($chaine,0,$length),' '));
		return $chaine;
	}
$req = $my->req('SELECT * FROM ttre_conseil ');
if ( $my->num($req)>0 )
{
	while ( $res=$my->arr($req) )
	{
		$photo='upload/conseils/_no_1.jpg';
		if ( !empty($res['photo']) ) $photo='upload/conseils/1920X800/'.$res['photo'];
		echo'
			<div class="col-md-6 col-xs-12">
				<div class="conseil-box">		
					<div class="conseil-thumb"><img src="'.$photo.'" alt="'.$res['titre'].'"></div> 
					<div class="conseil-title">
						<h2><a href="single.php?id='.$res['id'].'">'.$res['titre'].'</a></h2>
					</div>
					<div class="conseil-desc">
						'.couper(strip_tags($res['description']),270).'
					</div>
					<div class="readmore"><a href="single.php?id='.$res['id'].'">En savoir plus <i class="fa fa-long-arrow-right"></i></a></div>
				</div>
      		</div>
			';
	}
}
?>	
</div>

					<div class="col-md-3">
						<div class="sidebar">
							<div class="get-free-quote-form">
								<form id="ajax-contact" role="form" action="mailer.php" method="post" class="registration-form">
                		
	                        		<fieldset>
			                        	<div class="form-top">
			                        		<div class="form-top-left">
			                        			<h3>Mon Projet</h3>
			                            		<p>Décrivez votre projet</p>
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
			                        			<h3>Mes coordonnées</h3>
			                            		<p>Compléter vos information personnelles</p>
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
					                        	<label class="sr-only" for="form-last-name">Prénom</label>
					                        	<input type="text" name="form-last-name" placeholder="Prénom..." class="form-last-name form-control" id="form-last-name">
					                        	</div>
					                        </div>
					                        <div class="form-group">
					                        	<label class="sr-only" for="form-email">Email</label>
					                        	<input type="text" name="form-email" placeholder="Email..." class="form-email form-control" id="form-email">
					                        </div>
					                        <div class="form-group">
					                    		<label class="sr-only" for="form-phone">Téléphone</label>
					                        	<input type="tel" name="form-phone" placeholder="Téléphone..." class="form-password form-control" id="form-phone">
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
							<div class="formulaires">
								<h2><span>Formulaire</span></h2>
								<ul>
									
								<?php 
									$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
									if ( $my->num($req)>0 )
									{
										while ( $res=$my->arr($req) )
										{
											echo'<li><a target="_blanc" href="upload/fichiers/'.$res['fichier'].'"><i class="fa fa-file-pdf-o"></i> '.$res['titre'].'</a></li>';
										}
									}
								?>
								
								</ul>
							</div>

							<div class="get-quote-widget">
								<h2><span>Devis Gratuit</span></h2>
								<span class="quote-description">Devis de renovation gratuit en ligne et sans engagement</span>
								<a href="activites.php">Créer mon devis</a>
							</div>

							<div class="social-media-widget">
								<h2><span>SUIVEZ-NOUS</span></h2>
								<ul>
<li><a target="_blanc" href="https://www.facebook.com/tousrenovpro" class="facebook" title="Like Us"><i class="fa fa-facebook"></i></a></li>
<li><a target="_blanc" href="https://twitter.com/tousrenov1" class="twitter" title="Follow Me on Twitter"><i class="fa fa-twitter"></i></a></li>
<li><a target="_blanc" href="https://plus.google.com/u/0/+devistravauxmaisontrouvezlemeilleurartisantousreno/posts" class="google" title="Follow Me on Twitter"><i class="fa fa-google-plus"></i></a></li>
<li><a target="_blanc" href="https://www.linkedin.com/profile/view?id=253312067" class="linkedin" title="Follow Me on Twitter"><i class="fa fa-linkedin"></i></a></li>
<li><a target="_blanc" href="https://www.youtube.com/channel/UCzPvAqbAK23sa0HguRFPaIg" class="youtube" title=""><i class="fa fa-youtube"></i></a></li>
<li><a target="_blanc" href="http://fr.viadeo.com/fr/profile/tousrenov.renovation.interieur" class="viadeo"><i class="fa fa-viadeo"></i></a></li>
							</ul>
							</div>
							</div>			
</div>
								</div>
							</div>

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
				</div>	
													
		

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>
<?php include('inc/pied.php');?>
	</body>
</html>