<!DOCTYPE HTML>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
	<head >
	 <meta charset="windows-1252">
		<!--  <meta http-equiv="Content-Type" content="text/html" charset="utf-8" > -->
		<title><?php echo $pageTitle; ?></title>




		 

		<meta name="keywords" content="devis gratuit, devis en ligne, travaux renovation, artisan renovations, devis, announces, devis immediat, devis de renovation, devis personnalise, gratuit" />
		<meta name="description" content="Devis de renovation gratuit en ligne et sans engagement.Un projet de construction, rénovation pour votre maison ou appartement ? Notre conseiller en travaux vous aide gratuitement a réalisé vos projets" />
<!--     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
    	 
    	<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="author" content="WEINNOVATE">


		<!-- StyleSheet -->
		<!-- <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"> -->

		<link rel="stylesheet" type="text/css" href="https://www.tousrenov.fr/zone/css/bootstrap.css">

		<link rel="stylesheet" type="text/css" href="https://www.tousrenov.fr/zone/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="https://www.tousrenov.fr/zone/css/globe.css">

		<link rel="stylesheet" type="text/css" href="https://www.tousrenov.fr/zone/css/flexslider.css"/>
		<link rel="stylesheet" href="https://www.tousrenov.fr/zone/css/responsive-nav.css">
		<link rel="stylesheet" href="https://www.tousrenov.fr/zone/css/responsive.css">
		<script src="https://www.tousrenov.fr/zone/js/responsive-nav.js"></script>
		<script src="https://www.tousrenov.fr/zone/js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
		<script src="https://www.tousrenov.fr/zone/js/vendor/jquery-1.11.0.min.js"></script>
		<script src="https://www.tousrenov.fr/zone/js/vendor/jquery.gmap3.min.js"></script>
		<script src="https://www.tousrenov.fr/zone/js/plugins.js"></script>
		<script src="https://www.tousrenov.fr/zone/js/main.js"></script>
		<script src="https://www.tousrenov.fr/zone/js/global.js"></script>
		<link href="https://www.tousrenov.fr/zone/css/owl.carousel.css" rel="stylesheet">
		<link href="https://www.tousrenov.fr/zone/css/owl.theme.css" rel="stylesheet">
		<script src="https://www.tousrenov.fr/zone/js/bootstrap.min.js"></script>
         
        <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>
		<!-- JavaScript -->
		<!-- <script src="js/jquery-1.6.3.min.js" type="text/javascript"></script>
		<script src="js/cufon-yui.js" type="text/javascript"></script>
		<script src="js/cufon-replace.js" type="text/javascript"></script>
		<script src="js/NewsGoth_BT_400.font.js" type="text/javascript"></script>
		<script src="js/FF-cash.js" type="text/javascript"></script>
		<script src="js/script.js" type="text/javascript"></script>
		<script src="js/jquery.equalheights.js" type="text/javascript"></script>
		<script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
		<script src="js/tms-0.3.js" type="text/javascript"></script>
		<script src="js/tms_presets.js" type="text/javascript"></script>
		<script src="js/easyTooltip.js" type="text/javascript"></script> -->

		<!--[if lt IE 7]>
		<div style=' clear: both; text-align:center; position: relative;'>
			<a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
				<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
			</a>
		</div>
		<![endif]-->
		<!--[if lt IE 9]>
			<script type="text/javascript" src="js/html5.js"></script>
			<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
		<![endif]-->
		
		<script src="https://www.tousrenov.fr/js/jquery-1.10.2.min.js"></script>
		
		<link rel="stylesheet" href="https://www.tousrenov.fr/ttre_adm/style_alert.css" type="text/css" media="screen">
		<link rel="stylesheet" href="https://www.tousrenov.fr/zone/style_boutique.css" type="text/css" media="screen">
		<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-58062035-2']);
	_gaq.push(['_trackPageview']); (function() { var ga = document.createElement('script');
	ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(ga, s); })();

</script>
		
		
		
		
		
		
	
<script type="text/javascript">
$(document).ready(function()
{
	function testchat()
	{
		$.ajax({
			 type: 'post',
			 url: 'AjaxVerifChat.php',
			 success: function(msg)
				{	
					if (msg)
					{
						alert(msg);
						window.location = 'chat.php';
					}					 
				}
		 });	
	}
	setInterval (testchat, 1000);	//Reload file every 2.5 seconds

	function contenu_connect_admin()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxConnectAdmin.php",
			 success: function(msg)
				{	
					//alert(msg);	 
				}
		 });
	}
	setInterval (contenu_connect_admin, 60000);//60000=1minute  
	
});	

	
</script>		
		
	</head>