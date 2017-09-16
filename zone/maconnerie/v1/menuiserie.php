<?php
    require('mysql.php');

    $title = "Menuiserie";

    include_once('includes/header.php');
    
?>
        <!-- SLIDER -->
        <section id="intro" class="head-page-section">
            <div class="container">
                <div class="row">
                    <div class="bg-overlay"></div>
                    <div class="head-content">
                        <h1>Menuiserie</h1>
                        <lead>Recevez instantanément une offre détaillée et personnalisée ou la visite d'un ou plusieurs artisans</lead>
                    </div>
                </div>
            </div>
        </section>


        
        <section id="request" class="request-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <img src="images/activite-2.jpg" alt="Maçonnerie" >
                            <div class="col-md-4">
                            	<div class="avantages">
	                            	<i class="fa fa-rocket"></i>
	                            	<h3>Simplicité<br/> et rapidité</h3>
	                            	<lead>Dans les 24h, un conseiller traite votre demande<!--  et vous recevez par mail les coordonnées de 3 artisans. --></lead>
                            	</div>
                            </div>

							<div class="col-md-4">
								<div class="avantages">
	                            	<i class="fa fa-unlock"></i>
	                            	<h3>Gratuit<br/>et facile</h3>
	                            	<lead>Comparez et sélectionnez l'artisan de votre choix</lead>
	                            </div>
                            </div>

                            <div class="col-md-4">
                            	<div class="avantages">
	                            	<i class="fa fa-star"></i>
	                            	<h3>Liberté<br/>et qualité</h3>
	                            	<lead>Vous n’avez plus qu’à choisir librement l’artisan de votre choix</lead>
	                            </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <?php include_once('booking-form.php'); ?>
                        </div>
                    </div>                
                </div>
            </div>
        </section>
        

<?php include_once('includes/footer.php'); ?>