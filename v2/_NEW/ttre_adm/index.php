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
					<li><a href="?contenu=gestion_faq">F.A.Q</li>
				  </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Gestion du devis</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=categorie">Catégorie</a></li>
          	<li><a href="?contenu=souscategorie">Sous Catégorie</a></li>
          	<li><a href="?contenu=partie">Partie</a></li>
          	<li><a href="?contenu=question">Question</a></li>
          	<li><a href="?contenu=prix">Prix</a></li>
<!--          	<li><a href="?contenu=domaine">Domaine</a></li>-->
<!--          	<li><a href="?contenu=profession">Profession</a></li>-->
<!--          	<li><a href="?contenu=realisation">Réalisation</a></li>-->
<!--          	<li><a href="?contenu=categorie">Catégorie</a></li>-->
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
									case 'categorie'	        	: include 'categorie.php'; 			            	break;
									case 'souscategorie'	        : include 'souscategorie.php'; 			            break;
									case 'partie'	        		: include 'partie.php'; 			            	break;
									case 'question'	        		: include 'question.php'; 			            	break;
									case 'prix'	        			: include 'prix.php'; 			            		break;
									
									case 'ajout_faq'	            : include 'ajout_faq.php'; 			            	break;
									case 'gestion_faq'	            : include 'gestion_faq.php'; 			            break;
									case 'gestion_presentation'	    : include 'gestion_presentation.php'; 			    break;
									case 'gestion_mention'	        : include 'gestion_mention.php'; 			        break;
									case 'gestion_fonct'	        : include 'gestion_fonct.php'; 			            break;
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