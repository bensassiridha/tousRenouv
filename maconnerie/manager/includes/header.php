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
