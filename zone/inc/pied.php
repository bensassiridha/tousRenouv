		<footer>
		<div class="footer-section">
		<div class="overlay5"></div>
			<div class="container">
				<div class="row">
					<div class="categories">

						<!-- CATEGORY -->
						<div class="col-md-2">
							<a href="prix-travaux.php?cat=1">
							<div class="category" >
								<div class="cat-icon">
									<img src="../images/icons/Maconnorie.png" alt="Maçonnerie">
								</div>
								<span>Maçonnorie</span>
							</div>
								<div class="overlay4"></div> 
							</a>
						</div>

						<!-- CATEGORY -->
						<div class="col-md-2">
							<a href="prix-travaux.php?cat=2">
							<div class="category" >
								<div class="cat-icon">
									<img src="../images/icons/Menuiserie.png" alt="Menuiserie">
								</div>
								<span>Menuiserie</span>
							</div>
								<div class="overlay4"></div> 
							</a>
						</div>

						<!-- CATEGORY -->
						<div class="col-md-2">
							<a href="prix-travaux.php?cat=3">
							<div class="category" >
								<div class="cat-icon">
									<img src="../images/icons/sol.png" alt="revêtement de sol">
								</div>
								<span>Revêtement de sol</span>
							</div>
								<div class="overlay4"></div> 
							</a>
						</div>

						<!-- CATEGORY -->
						<div class="col-md-2">
							<a href="prix-travaux.php?cat=4">
							<div class="category" >
								<div class="cat-icon">
									<img src="../images/icons/Murs.png" alt="Revêtement de murs et plafond">
								</div>
								<span>Rev de murs et plafond</span>
							</div>
								<div class="overlay4"></div> 
							</a>
						</div>

						<!-- CATEGORY -->
						<div class="col-md-2">
							<a href="prix-travaux.php?cat=5">
							<div class="category" >
								<div class="cat-icon">
									<img src="../images/icons/Plomberie.png" alt="Plomberie">
								</div>
								<span>Plomberie</span>
							</div>
								<div class="overlay4"></div> 
							</a>
						</div>

						<!-- CATEGORY -->
						<div class="col-md-2">
							<a href="prix-travaux.php?cat=6">
							<div class="category" >
								<div class="cat-icon">
									<img src="../images/icons/Electricite.png" alt="Electricite">
								</div>
								<span>Electricité</span>
							</div>
								<div class="overlay4"></div> 
							</a>
						</div>

						
						
<?php 
$reqCat=$my->req('SELECT * FROM ttre_categories WHERE id>6 AND parent=0 ORDER BY ordre ASC');
while ( $resCat=$my->arr($reqCat) )
{
	$logo='';
	//if ( !empty($resCat['photo']) ) $logo='<img src="upload/logosCateg/50X30/'.$resCat['photo'].'" alt="'.$resCat['titre'].'" />'; 
	echo'
		<div class="col-md-2" style="margin-top:10px;">
			<a href="prix-travaux.php?cat='.$resCat['id'].'">
			<div class="category" >
				<div class="cat-icon">
					'.$logo.'
				</div>
				<span>'.$resCat['titre'].'</span>
			</div>
				<div class="overlay4"></div> 
			</a>
		</div>
		';
}
?>							
						
						
						
					</div>
					<!-- <div class="activite-icon  col-md-12">
						<div class="title-activite col-md-2 col-xs-12"><h1>Devis Travaux Rénovation</h1></div>
						<div class="icon-activite col-md-10 col-xs-12">
							<ul>
								<li class="col-xs-6 col-md-2"><a href="prix-travaux.php?cat=1"><img src="images/devis/1.png"><br /><span>Maçonnerie</span></a></li>
								<li class="col-xs-6 col-md-2"><a href="prix-travaux.php?cat=2"><img src="images/devis/2.png"><br /><span>Menuiserie</span></a></li>
								<li class="col-xs-6 col-md-2"><a href="prix-travaux.php?cat=3"><img src="images/devis/3.png"><br /><span>Révêtement de sol</span></a></li>
								<li class="col-xs-6 col-md-2"><a href="prix-travaux.php?cat=4"><img src="images/devis/4.png"><br /><span>Murs et plafond</span></a></li>
								<li class="col-xs-6 col-md-2"><a href="prix-travaux.php?cat=5"><img src="images/devis/5.png"><br /><span>Plomberie</span></a></li>
								<li class="col-xs-6 col-md-2"><a href="prix-travaux.php?cat=6"><img src="images/devis/6.png"><br /><span>Electricité</span></a></li>
							</ul>
						</div>
					</div> -->

					<div class="links">
						<div class="col-md-12">
                            
                        <div class="col-md-4">
	                        <div class="widget">
	                        	<div class="divider"></div>
								<h3>Tousrenov.fr</h3>
	                            <p>
	                            En conformité avec la loi Informatique et liberté du 6 janvier 1978, TousRenov est enregistré auprès des services de la CNIL sous le n° 1928302V0. En application de la loi Informatique et Liberté, vous disposez à tout moment d'un droit d'accès et de modification sur les données personnelles vous concernant. 
	                            </p>
	                            <div class="social-media">
							<ul>
								<li><a target="_blanc" href="https://www.facebook.com/tousrenovpro" title="Like Us"><span class="fa fa-facebook"></span></a></li>
								<li><a target="_blanc" href="https://twitter.com/tousrenov1" title="Follow Me on Twitter"><span class="fa fa-twitter"></span></a></li>
								<li><a target="_blanc" href="https://plus.google.com/u/0/+devistravauxmaisontrouvezlemeilleurartisantousreno/posts" title="Follow Me on Twitter"><span class="fa fa-google-plus"></span></a></li>
								<li><a target="_blanc" href="https://www.linkedin.com/profile/view?id=253312067" title="Follow Me on Twitter"><span class="fa fa-linkedin"></span></a></li>
								<li><a target="_blanc" href="https://www.youtube.com/channel/UCzPvAqbAK23sa0HguRFPaIg" title=""><span class="fa fa-youtube"></span></a></li>
								<li><a target="_blanc" href="http://fr.viadeo.com/fr/profile/tousrenov.renovation.interieur"><span class="viadeo"><img src="../images/viadeo.png" alt="Tousrenov Viadeo"></span></a></li>
							</ul>
							</div>
	                        </div>
						</div>
						<div class="col-md-2">
							<div class="widget">
							<div class="divider"></div>
							<h3>Liens de site</h3>
							<ul>
								<li><a href="index.php"><i class="fa fa-link"></i>Acceuil</a></li>
								<li><a href="services.php"><i class="fa fa-link"></i>Nos Services</a></li>
								<li><a href="activites.php"><i class="fa fa-link"></i>Nos Activités</a></li>
								<li><a href="conseils.php"><i class="fa fa-link"></i>Conseils</a></li>
								<li><a href="propos.php"><i class="fa fa-link"></i>à propos</a></li>
								<li><a href="contact.php"><i class="fa fa-link"></i>Contact</a></li>
							</ul>
							</div>
						</div>

						<div class="col-md-3">
							<div class="widget">
							<div class="divider"></div>
								<h3>Inscription newsletter</h3>
									<?php include('inc/droite.php');?>
							</div>
						</div>

						<div class="col-md-3">
							<div class="">
							<img src="../images/images/worker-footer.png" alt="devis travaux renovation">
							</div>
							
						</div>
						</div>
					</div>
					</div>
				</div>
			</div>
					<div class="rights">
						<div class="container">
							<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="copyright">Copyright © 2017 TOUSRENOV.</div>
										</div>
									</div>
									<div class="col-md-6 link">
										<ul>
											<li><a href="faq.php">F.A.Q</a></li>
											<li><a href="fonctionnement.php">Fonctionnement</a></li>
											<li><a href="mention.php">Mentions legales</a></li>
										</ul>
									</div>
									<!-- <div class="col-md-4 weinnovate">Passionnément conçu par WEINNOVATE</div> -->
							</div>
						</div>
					</div>

		</footer>
		
		<script type="text/javascript">


			var navigation = responsiveNav(".menu", {
        animate: true,                    // Boolean: Use CSS3 transitions, true or false
        transition: 284,                  // Integer: Speed of the transition, in milliseconds
        label: "Menu",                    // String: Label for the navigation toggle
        insert: "before",                  // String: Insert the toggle before or after the navigation
        customToggle: "",                 // Selector: Specify the ID of a custom toggle
        closeOnNavClick: false,           // Boolean: Close the navigation when one of the links are clicked
        openPos: "relative",              // String: Position of the opened nav, relative or static
        navClass: "menu",         // String: Default CSS class. If changed, you need to edit the CSS too!
        navActiveClass: "js-nav-active",  // String: Class that is added to <html> element when nav is active
        jsClass: "js",                    // String: 'JS enabled' class which is added to <html> element
        init: function(){},               // Function: Init callback
        open: function(){},               // Function: Open callback
        close: function(){}               // Function: Close callback
      });
		</script>
<script> 
$(document).ready(function() {
$("#owl-demo").owlCarousel({

      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
      });
  });
 	 </script>
 	 <script src="https://www.tousrenov.fr/zone/js/owl.carousel.js"></script>