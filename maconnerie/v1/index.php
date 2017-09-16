<?php
    require('mysql.php');

    $title = "Devis gratuit en ligne et sans aucun engagement. Chiffrer le coût de vos travaux de rénovation ou de construction";

    include_once('includes/header.php');
    
?>

        
        <!-- SLIDER -->
        <section id="intro" class="intro-section">
            <div class="container">
                <div class="row">
                    <div class="bg-overlay"></div>
                    <div class="intro-content">
                        <h1>Devis de Renovation</h1>
                        <lead>Gratuit en ligne et sans engagement Chiffrer le coût de vos travaux de rénovation ou de construction</lead>
                    </div>
                </div>
            </div>
        </section>
        <section id="featured" class="featured-section">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="featured">
                            <i class="fa fa-rocket"></i>
                            <h3>Simplicité et rapidité</h3>
                            <lead>Dans les 24h, un conseiller traite votre demande</lead>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="featured colored">
                            <i class="fa fa-unlock"></i>
                            <h3>Gratuit et facile</h3>
                            <lead>Comparez et sélectionnez l'artisan de votre choix</lead>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="featured">
                            <i class="fa fa-star"></i>
                            <h3>Liberté et qualité</h3>
                            <lead>Choisir librement l’artisan de votre choix</lead>                    
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        
        <section id="quote" class="quote-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                    <lead>Sélectionnez le secteur ci-dessous pour lequel vous désirez trouver des professionnels et obtenir des devis gratuits.</lead>
                    </div>
                    
                    <!-- DEMANDE DE DEVIS -->
                    <div class="col-md-4">
                        <div class="quote">
                            <div class="thumbnail">
                                <div class="request">
                                    <a href="maconnerie.php">Demandez un devis</a>
                                </div>                            
                                <div class="overlay"></div>
                                <img src="images/activite-1.jpg" alt="Maçonnerie" >
                            </div>
                            <div class="heading">
                                <div class="icon-quote"><img src="images/icons/Maconnorie.png"></div>
                                <div class="title">
                                    <h2><a href="maconnerie.php">Maçonnerie</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- DEMANDE DE DEVIS -->
                    <div class="col-md-4">
                        <div class="quote">
                            <div class="thumbnail">
                                <div class="request">
                                    <a href="menuiserie.php">Demandez un devis</a>
                                </div>                            
                                <div class="overlay"></div>
                                <img src="images/activite-2.jpg" alt="Menuiserie" >
                            </div>
                            <div class="heading">
                                <div class="icon-quote"><img src="images/icons/Menuiserie.png"></div>
                                <div class="title">
                                    <h2><a href="menuiserie.php">Menuiserie</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    
                    <!-- DEMANDE DE DEVIS -->
                    <div class="col-md-4">
                        <div class="quote">
                            <div class="thumbnail">
                                <div class="request">
                                    <a href="sol.php">Demandez un devis</a>
                                </div>                            
                                <div class="overlay"></div>
                                <img src="images/activite-5.jpg" alt="Revêtement de sol" >
                            </div>
                            <div class="heading">
                                <div class="icon-quote"><img src="images/icons/sol.png"></div>
                                <div class="title">
                                    <h2><a href="sol.php">Revêtement de Sol</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    
                    <!-- DEMANDE DE DEVIS -->
                    <div class="col-md-4">
                        <div class="quote">
                            <div class="thumbnail">
                                <div class="request">
                                    <a href="murs-plafond.php">Demandez un devis</a>
                                </div>                            
                                <div class="overlay"></div>
                                <img src="images/activite-4.jpg" alt="Revêtement de murs et plafond" >
                            </div>
                            <div class="heading">
                                <div class="icon-quote"><img src="images/icons/Murs.png"></div>
                                <div class="title">
                                    <h2><a href="murs-plafond.php">Revêtement de Murs et Plafond</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    
                    <!-- DEMANDE DE DEVIS -->
                    <div class="col-md-4">
                        <div class="quote">
                            <div class="thumbnail">
                                <div class="request">
                                    <a href="plomberie.php">Demandez un devis</a>
                                </div>                            
                                <div class="overlay"></div>
                                <img src="images/activite-3.jpg" alt="Plomberie" >
                            </div>
                            <div class="heading">
                                <div class="icon-quote"><img src="images/icons/Plomberie.png"></div>
                                <div class="title">
                                    <h2><a href="plomberie.php">Plomberie</a></h2>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    
                    <!-- DEMANDE DE DEVIS -->
                    <div class="col-md-4">
                        <div class="quote">
                            <div class="thumbnail">
                                <div class="request">
                                    <a href="electricite.php">Demandez un devis</a>
                                </div>
                                <div class="overlay"></div>
                                <img src="images/activite-6.jpg" alt="Electricité" >
                            </div>
                            <div class="heading">
                                <div class="icon-quote"><img src="images/icons/Electricite.png"></div>
                                <div class="title">
                                    <h2><a href="electricite.php">Electricité</a></h2>
                                </div>
                                
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </section>

<?php include_once('includes/footer.php'); ?>    