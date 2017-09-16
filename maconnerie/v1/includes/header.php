<?php
    require('mysql.php');
?>

<!DOCTYPE html>
<htlml lang="fr">
    
    <head>
        <title><?php echo $title ?></title>
        
        <!-- META -->
        <meta name="viewport" content="width=device-with, initial-scale=1" >
        <meta charset="utf-8" content="text/html" >
        <meta http-equiv="X-UA-Compatible" content="IE=edge" >
        <meta name="description" content="Nous référencions soigneusement tous les professionnels, du bâtiment tous corps d’état, tous les artisans et entreprises du bâtiment que nous avons référencés s'engagent à fournir des prestations compétitives, effectuées dans les règles de l'art. Vos coordonnées restent confidentiel Nous sélectionnons pour vous des artisans qualifier et un très bon rapport qualité/prix." >
        <meta name="keywords" content="devis, gratuit, devis gratuit, Revêtement, Plomberie, Electricité, Maçonnerie, Menuiserie, Revêtement de Sol" >
         <meta name="author" content="Weinnovate">
        
        
        <!-- STYLESEET -->
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" >
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" >
        <link href="css/global.css" rel="stylesheet" type="text/css" >
        <link rel="stylesheet" href="css/form-elements.css">
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>

        
        <!-- JAVASCRIPT -->
        <script src="js/global.js"></script>
		<script src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {  
                $( "#ip_cp" ).change(function() {
                    $.ajax({
                        url: "AjaxVille.php",
                        type: "POST",
                        data: "ip_cp="+$('input[name="ip_cp"]').val(),
                        success: function(data)
                        {         
                            console.log(data)   
                            //alert(msg);
                            $('select[name="ville"]').html(data);
                        }
                    }); 
                });  
            });
        </script>   
    </head>
    
    
    <body>
        
        <!-- TOP NAVBAR -->
        <div class="navbar-top">
            <div class="container">
                <div class="row">                    
                    <!-- LOGO -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="info">
                                <div class="social-media">
        <ul>
            <li>
                <a href="https://www.facebook.com/tousrenovpro">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            <li>
                <a href="https://twitter.com/tousrenov1" title="Follow Me on Twitter">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li>
                <a href="https://plus.google.com/u/0/+devistravauxmaisontrouvezlemeilleurartisantousreno/posts" title="Follow Me on Twitter">
                    <i class="fa fa-google-plus"></i>
                </a>
            </li>
            <li>
                <a href="https://www.linkedin.com/profile/view?id=253312067" title="Follow Me on Twitter">
                    <i class="fa fa-linkedin"></i>
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/channel/UCzPvAqbAK23sa0HguRFPaIg" title="">
                    <i class="fa fa-youtube"></i>
                </a>
            </li>
        </ul> 
                                </div>
                            </div>
                        </div>
                    </div>                            

                    <!-- INFO & HELP -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="info-contact">
                                <ul>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        <span><label>Besoin d'aide : </label> 0651391912</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o"></i>
                                        <span>
                                            <label>Contacter Nous : </label>
                                            <a href="mailto:contact@tousrenov.fr">contact@tousrenov.f</a></span>
                                    </li>
                                </ul> 
                                    
                                </div>                         
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>                    
        
        <!-- MAIN NAVBAR -->
        <div class="navbar">
            <div class="container">
                <div class="row">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo.png" alt="">
                </a>
            </div>

            <nav class="navbar-default" role="navigation">

                        <div class="navbar-header page-sroll">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="fa fa-bars"></span>

                </button>
                        </div>


                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="navbar-nav nav">
                                <li class="hidden"><a class="page-scroll" href="#page-top"></a></li>
                                <li ><a class="page-scroll" href="maconnerie.php">Maçonnerie</a></li>
                                <li ><a class="page-scroll" href="menuiserie.php">Menuiserie</a></li>
                                <li ><a class="page-scroll" href="sol.php">Revêtement de sol</a></li>
                                <li ><a class="page-scroll" href="murs-plafond.php">Revêtement de murs et plafond</a></li>
                                <li ><a class="page-scroll" href="plomberie.php">Plomberie</a></li>
                                <li ><a class="page-scroll" href="electricite.php">Electricité</a></li>
                            </ul>
                        </div>

            </nav>   
                </div>
            </div>                     
        </div>