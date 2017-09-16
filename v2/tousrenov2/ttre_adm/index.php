<?php 
	include("inc/head.php");
		if (!isset($_SESSION['login']))
	{
		echo '<script>window.location="connect.php"</script>';
	}	
	if(isset($_GET["action"])&&$_GET["action"]=="logout")
	{
	session_destroy();
	echo '<script>
	window.location="connect.php"</script>';
	}

	
$nom_client='TousRenov';
$url_site_client='http://creation-site-web-tunisie.net/trn';
$logo_client='http://creation-site-web-tunisie.net/trn/images/logo.png';
$mail_client='';
	
?>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="images/logo.png" alt="" title="" border="0" /></a></div>
    
    <div class="right_header">Bienvenue <?php echo $_SESSION['login'];?> en tant qu'administrateur , <a href="../index.php" target="_blank">Visiter le site</a> | <a href="?action=logout" class="logout">Logout</a></div>
    </div>
    <div class="main_content">
				    <div class="menu">
					<ul>
                    <li>Bienvenue &agrave; votre espace Administrateur,</li>
                    </ul>
					</div> 
    <div class="center_content">  
    <div class="left_content">
    <!--Admin principal-->
        <div class="sidebarmenu">
                
                <a class="menuitem submenuheader" href="" >Gestion du Site</a>
                <div class="submenu">
                    <ul>
					<li><a href="?contenu=gestion_presentation">Pr&eacute;sentation</a></li>
					<li><a href="?contenu=gestion_mention">Mentions L&eacute;gales</a></li>
					<li><a href="?contenu=gestion_fonct">Fonctionnement</a></li>
					<li><a href="?contenu=gestion_faq">F.A.Q</a></li>
					<li><a href="?contenu=gestion_conseil">Conseils</a></li>
					<li><a href="?contenu=gestion_service">Nos services</a></li>
					<li><a href="?contenu=diaporama">Diaporama</a></li>
					<li><a href="?contenu=formulaire">Formulaires</a></li>
					<li><a href="?contenu=mail">Contenu email</a></li>
		          	<li><a href="?contenu=news_envoie">Envoie Newsletter</a></li>
		            <li><a href="?contenu=news_inscrit">Lites des inscrits</a></li>
				  </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Gestion du prix</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=panier">Commentaire panier</a></li>
          	<li><a href="?contenu=categorie">Catégorie</a></li>
          	<li><a href="?contenu=souscategorie">Sous Catégorie</a></li>
          	<li><a href="?contenu=partie">Partie</a></li>
          	<li><a href="?contenu=question">Question</a></li>
          	<li><a href="?contenu=tva">Tva</a></li>
          	<li><a href="?contenu=prix">Prix</a></li>
<!--          	<li><a href="?contenu=domaine">Domaine</a></li>-->
<!--          	<li><a href="?contenu=profession">Profession</a></li>-->
<!--          	<li><a href="?contenu=realisation">Réalisation</a></li>-->
<!--          	<li><a href="?contenu=categorie">Catégorie</a></li>-->
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Espace particulier</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=part_liste">Liste de clients</a></li>
          	<li><a href="?contenu=part_news_envoie">Envoie Newsletter</a></li>
            <li><a href="?contenu=part_news_inscrit">Lites des inscrits</a></li>
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Espace professionnel</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=pro_liste">Liste de clients</a></li>
          	<li><a href="?contenu=pro_news_envoie">Envoie Newsletter</a></li>
            <li><a href="?contenu=pro_news_inscrit">Lites des inscrits</a></li>
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Devis avec enchere</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=devis_att_val">Devis en attende de validation</a></li>
          	<li><a href="?contenu=devis_cour_ench">Devis en cours de enchere</a></li>
          	<li><a href="?contenu=devis_att_paye">Devis en attende de payement</a></li>
          	<li><a href="?contenu=devis_envoye">Devis envoyé</a></li>
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Devis avec achat imédiat</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=devisa_att_val">Devis en attende de validation</a></li>
          	<li><a href="?contenu=devisa_att_paye">Devis en attende de payement</a></li>
          	<li><a href="?contenu=devisa_envoye">Devis envoyé</a></li>
          </ul>
          </div>
          
           <a class="menuitem" href="index.php?contenu=users">Gestion des utilisateurs</a>
            </div>
        <div class="sidebar_box"></div>
    </div>  
                    
  </div>   <!--end of center content -->               
  	<div class="right_content"> 
<?php
if(isset($_GET['contenu']))
{
	switch($_GET['contenu']){	
		
//									case 'domaine'	        		: include 'domaine.php'; 			            	break;
//									case 'profession'	        	: include 'profession.php'; 			            break;
//									case 'realisation'	        	: include 'realisation.php'; 			            break;
									case 'panier'	        		: include 'panier.php'; 			            	break;
									case 'categorie'	        	: include 'categorie.php'; 			            	break;
									case 'souscategorie'	        : include 'souscategorie.php'; 			            break;
									case 'partie'	        		: include 'partie.php'; 			            	break;
									case 'question'	        		: include 'question.php'; 			            	break;
									case 'tva'	        			: include 'tva.php'; 			            		break;
									case 'prix'	        			: include 'prix.php'; 			            		break;
									
									case 'part_liste'	        	: include 'part_liste.php'; 			            break;
									case 'part_news_envoie'			: include 'part_news_envoie.php'; 					break;
									case 'part_news_inscrit'		: include 'part_news_inscrit.php'; 					break;
									
									case 'pro_liste'	        	: include 'pro_liste.php'; 			            	break;
									case 'pro_news_envoie'			: include 'pro_news_envoie.php'; 					break;
									case 'pro_news_inscrit'			: include 'pro_news_inscrit.php'; 					break;
									
									case 'mail'	        			: include 'mail.php'; 			            		break;
									case 'devis_att_val'	        : include 'devis_att_val.php'; 			            break;
									case 'devis_cour_ench'	        : include 'devis_cour_ench.php'; 			        break;
									case 'devis_att_paye'	        : include 'devis_att_paye.php'; 			        break;
									case 'devis_envoye'	        	: include 'devis_envoye.php'; 			        	break;
									
									case 'devisa_att_val'	        : include 'devisa_att_val.php'; 			        break;
									case 'devisa_att_paye'	        : include 'devisa_att_paye.php'; 			        break;
									case 'devisa_envoye'	        : include 'devisa_envoye.php'; 			        	break;
									
									case 'ajout_faq'	            : include 'ajout_faq.php'; 			            	break;
									case 'gestion_faq'	            : include 'gestion_faq.php'; 			            break;
									case 'gestion_presentation'	    : include 'gestion_presentation.php'; 			    break;
									case 'gestion_mention'	        : include 'gestion_mention.php'; 			        break;
									case 'gestion_fonct'	        : include 'gestion_fonct.php'; 			            break;
									case 'gestion_conseil'	        : include 'gestion_conseil.php'; 			        break;
									case 'gestion_service'	        : include 'gestion_service.php'; 			        break;
									case 'diaporama'	        	: include 'diaporama.php'; 			    	  	 	break;
									case 'formulaire'	        	: include 'page_formulaire.php'; 			       	break;
									case 'news_envoie'				: include 'news_envoie.php'; 						break;
									case 'news_inscrit'				: include 'news_inscrit.php'; 						break;
									case 'users'                    : include 'users.php';					            break;
									default : 
									{
									}
									break;
	}
}
else{
?>
        <strong>Bonjour et bienvenue sur votre interface d'administration.</strong><br />
        
        <p>Les diff&eacute;rentes sections sur votre gauche vous permettent de g&eacute;rer les pages de votre site de fa&ccedil;on autonome.
        
        Vous pouvez &eacute;galement ajouter des utilisateurs, afin de leur laisser un acc&eacute;s &agrave; ce service d'administration.
        
        Vous trouverez enfin une page d'informations pour contacter Liweb agency.</p>
<?php } ?>     
  	</div>                  
	<div class="clear"></div>
    </div> <!--end of main content-->
    <div class="footer">
    	<div class="left_footer">2012 &copy; Powered by Liweb Agency</div>
    	<div class="right_footer"></div>
    </div>
</div>		
</body>
</html>