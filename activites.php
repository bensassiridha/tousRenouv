<?php
require('mysql.php');$my=new mysql();
$pageTitle = "Nos activités"; 
include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
						<div class="header-page">
							<div class="container">
								<div class="row">
									<h2 class="page-title">Nos Activit&eacute;s</h2>
								</div>
							</div>
							
						</div>
						<div class="activite">
							<div class="container">
								<div class="row">
										
<?php 
$temp=$my->req_arr('SELECT * FROM ttre_categories_details WHERE id=-1');
echo'<div class="col-md-9"><div class="desc">'.nl2br($temp['description']).'</div></div>';
?>

<div class="col-md-3">
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
<div class="col-md-12">
	<div class="row">
		<div class="activities">
			<?php
			$req = $my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
			if ( $my->num($req)>0 )
			{
				while ( $res=$my->arr($req) )
				{
					$resa = $my->req_arr('SELECT * FROM ttre_categories_details WHERE id='.$res['id'].' ');
					$photo='upload/logosCateg/_no_1.jpg';
					if ( !empty($resa['photo']) ) $photo='upload/logosCateg/800X600a/'.$resa['photo'];
					echo'
					<div class="col-md-4 col-xs-12">
						<div class="activity">
							<div class="activity-card">

								<div class="front face thumbnail">
									<h3><span>'.$res['titre'].'</span></h3>
									<img src="'.$photo.'" alt="'.$res['titre'].'">
								</div>
								
								<div class="back face">
									<div class="activity-content">
										<h2>'.$res['titre'].'</h2>						
										<p>'.$resa['description'].'</p>
										<a href="prix-travaux.php?cat='.$res['id'].'">Creer devis</a>
									</div>
								</div>
						
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
<?php include('inc/pied.php');?>
	</body>
</html>