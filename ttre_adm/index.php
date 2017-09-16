<?php 

session_start();
ini_set('display_errors', 'off');
error_reporting(E_ALL);
require('mysql.php');
require('formulaire.php');
require('fonctions.php');
require('class.upload.php');
include("inc/inc_photo_bg.php");
$rand = substr(mt_rand(),1,4);

	$my = new mysql();
	if (!isset($_SESSION['login']))
	{
		header("location:connect.php");exit;
		//echo '<script>window.location="connect.php"</script>';
	}	
	if(isset($_GET["action"])&&$_GET["action"]=="logout")
	{
		if ( isset($_SESSION['id_connect_admin']) )
		{
			$my->req('UPDATE ttre_connection_admin SET fin="'.time().'" WHERE id = '.$_SESSION['id_connect_admin'].' ' );
		}
		
		session_destroy();
		header("location:connect.php");exit;
		//echo '<script>window.location="connect.php"</script>';
	}

	
$ca = $my->req_arr('SELECT * FROM ttre_connection_admin WHERE id_user='.$_SESSION['id_user'].' ORDER BY id DESC ');
$my->req('UPDATE ttre_connection_admin SET fin_ajax="'.time().'" , fin=0 WHERE id = '.$ca['id'].' ' );
	
	
	
$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
if ( $user['statut']==0 )	
{
	if ( isset($_SESSION['id_connect_admin']) )
	{
		$my->req('UPDATE ttre_connection_admin SET fin="'.time().'" WHERE id = '.$_SESSION['id_connect_admin'].' ' );
	}
	session_destroy();
	header("location:connect.php");exit;
	//echo '<script>window.location="connect.php"</script>';
}
	

	include("inc/head.php");
	
	

	
$nom_client='TousRenov';
$url_site_client='http://tousrenov.fr';
$mail_client='';
	
//$logo_client='http://tousrenov.fr/images/logo.png';
$temp = $my->req_arr('SELECT * FROM logo WHERE id=1 ');
$logo_client='../upload/logo/150X100/'.$temp['photo'];





//---------------------- partie à rappeler -----------------------------------------
$req = $my->req('SELECT * FROM ttre_achat_devis_suite WHERE stat_devis_attente=2 AND stat_ajout_zone=0 ');
if ( $my->num($req)>0 )
{
	while ( $res=$my->arr($req) )
	{
		list($p,$d) = split('[|]',$res['stat_devis_attente']);
		list($jour, $mois, $annee) = explode('/', $d);
		$timestamp_date_fin = mktime(23,59,59,$mois,($jour+7),$annee);
		if ( time() > $timestamp_date_fin )
		{
			$my->req('UPDATE ttre_achat_devis_suite SET stat_ajout_zone=1 WHERE id_devis='.$res['id_devis']);
		}
	}
}
//---------------------------------------------------------------------------------




//---------------------- partie alert pour rappeler et rdv pris -----------------------------------------
$alert_rdv_rappeler='';
$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
if ( $user['profil']==2 || $user['profil']==6 )
{
	$arap=0;$ardv=0;$alert_rappeler='';$alert_rdv='';
	$req1 = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_suite ADSS
								WHERE
									AD.statut_valid_admin=-1
									AND AD.stat_suppr=0
									AND	AD.id=ADSS.id_devis
									AND	ADSS.stat_ajout_zone=0
									AND ADSS.stat_devis_attente=1
								ORDER BY AD.id DESC');
	
	if ( $my->num($req1)>0 )
	{
		while ( $ress=$my->arr($req1) )
		{
			$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
			$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
			
			$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
			$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
			$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
			$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['id_user'].' AND zone='.$rs3['departement_id'].' ');
			if ( $my->num($rq1)>0 )
			{
				
				list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
				list($jour, $mois, $annee) = explode('/', $d);
				$timestamp_date_fin = mktime(0,0,0,$mois,($jour+1),$annee);
				if ( time() > $timestamp_date_fin )
				{
					$alert_rdv.='- '.$res['reference'].' - Lien : <a href="http://tousrenov.fr/ttre_adm/index.php?contenu=devis_admin_administrateur&stat=2&action=modifier&id='.$res['id'].'" target="_blanc" >Modifier le statut</a> <br />';
				}
			}
		}
		if ( $alert_rdv!='' )
		{
			$alert_rdv='<p><span style="color:#32CD32;"><strong>Date dépassé pour le devis à rdv pris : </strong></span><br /> '.$alert_rdv.' </p>';
		}		
	}	
	$req2 = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_suite ADSS
								WHERE
									AD.statut_valid_admin=-1
									AND AD.stat_suppr=0
									AND	AD.id=ADSS.id_devis
									AND	ADSS.stat_ajout_zone=0
									AND ADSS.stat_devis_attente=2
								ORDER BY AD.id DESC');
	
	if ( $my->num($req2)>0 )
	{
		while ( $ress=$my->arr($req2) )
		{
			$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
			$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
			
			$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
			$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
			$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
			$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['id_user'].' AND zone='.$rs3['departement_id'].' ');
			if ( $my->num($rq1)>0 )
			{
				
				list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
				list($jour, $mois, $annee) = explode('/', $d);
				$timestamp_date_fin = mktime(0,0,0,$mois,($jour+1),$annee);
				if ( time() > $timestamp_date_fin )
				{
					$alert_rappeler.='- '.$res['reference'].' - Lien : <a href="http://tousrenov.fr/ttre_adm/index.php?contenu=devis_admin_administrateur&stat=2&action=modifier&id='.$res['id'].'" target="_blanc" >Modifier le statut</a> <br />';
				}
			}
		}
		if ( $alert_rappeler!='' )
		{
			$alert_rappeler='<p><span style="color:#32CD32;"><strong>Date dépassé pour le devis à rappeler : </strong></span><br /> '.$alert_rappeler.' </p>';
		}			
	}	
	$alert_rdv_rappeler=$alert_rdv.' '.$alert_rappeler;
}
elseif ( $user['profil']==1 )
{
	$arap=0;$ardv=0;$alert_rappeler='';$alert_rdv='';
	$req1 = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_suite ADSS
								WHERE
									AD.statut_valid_admin=-1
									AND AD.stat_suppr=0
									AND	AD.id=ADSS.id_devis
									AND	ADSS.stat_ajout_zone=0
									AND ADSS.stat_devis_attente=1
								ORDER BY AD.id DESC');
	
	if ( $my->num($req1)>0 )
	{
		while ( $ress=$my->arr($req1) )
		{
			$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
			$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
			list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
			list($jour, $mois, $annee) = explode('/', $d);
			$timestamp_date_fin = mktime(0,0,0,$mois,($jour+1),$annee);
			if ( time() > $timestamp_date_fin )
			{
				$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$az=$my->req_arr('SELECT * FROM ttre_users_zones UZ , ttre_users U WHERE U.id_user=UZ.id_user AND UZ.zone='.$d['departement_id'].' ');
				$alert_rdv.='- '.$res['reference'].' - '.$az['nom'].' - Lien : <a href="http://tousrenov.fr/ttre_adm/index.php?contenu=devis_admin_administrateur&stat=2&action=modifier&id='.$res['id'].'" target="_blanc" >Modifier le statut</a> <br />';
			}
		}
		if ( $alert_rdv!='' )
		{
			$alert_rdv='<p><span style="color:#32CD32;"><strong>Date dépassé pour le devis à rdv pris : </strong></span><br /> '.$alert_rdv.' </p>';
		}		
	}	
	$req2 = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_suite ADSS
								WHERE
									AD.statut_valid_admin=-1
									AND AD.stat_suppr=0
									AND	AD.id=ADSS.id_devis
									AND	ADSS.stat_ajout_zone=0
									AND ADSS.stat_devis_attente=2
								ORDER BY AD.id DESC');
	
	if ( $my->num($req2)>0 )
	{
		while ( $ress=$my->arr($req2) )
		{
			$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
			$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
			list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
			list($jour, $mois, $annee) = explode('/', $d);
			$timestamp_date_fin = mktime(0,0,0,$mois,($jour+1),$annee);
			if ( time() > $timestamp_date_fin )
			{
				$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$az=$my->req_arr('SELECT * FROM ttre_users_zones UZ , ttre_users U WHERE U.id_user=UZ.id_user AND UZ.zone='.$d['departement_id'].' ');
				$alert_rappeler.='- '.$res['reference'].' - '.$az['nom'].' - Lien : <a href="http://tousrenov.fr/ttre_adm/index.php?contenu=devis_admin_administrateur&stat=2&action=modifier&id='.$res['id'].'" target="_blanc" >Modifier le statut</a> <br />';
			}
		}
		if ( $alert_rappeler!='' )
		{
			$alert_rappeler='<p><span style="color:#32CD32;"><strong>Date dépassé pour le devis à rappeler : </strong></span><br /> '.$alert_rappeler.' </p>';
		}			
	}	
	$alert_rdv_rappeler=$alert_rdv.' '.$alert_rappeler;
	
}

//-------------------------------------------------------------------------------------------------------




?>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="<?php echo $logo_client; ?>" alt="" title="" border="0" /></a></div>
    
    <div class="right_header">Bienvenue <?php echo $_SESSION['login'];?> <!-- en tant qu'administrateur--> , <a href="../index.php" target="_blank">Visiter le site</a> | <a href="?action=logout" class="logout">Logout</a></div>
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
                
                
<?php 

$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
if ( $user['profil']==7 ) // Départements et villes
{
	echo'
                <a class="menuitem submenuheader" href="" >Départements et villes</a>
                <div class="submenu">
                    <ul>
          			<li><a href="?contenu=dep">Départements</a></li>
					<li><a href="?contenu=vil">Villes</a></li>
				  </ul>
          </div>
			<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
        ';
}
elseif ( $user['profil']==8 ) // Gestion du Site
{
		echo'
			<a class="menuitem submenuheader" href="" >Gestion du Site</a>
                <div class="submenu">
                    <ul>
          			<li><a href="?contenu=coordonnees">Coordonnées</a></li>
					<li><a href="?contenu=gestion_presentation">Pr&eacute;sentation <br /> Qui sommes nous</a></li>
					<li><a href="?contenu=gestion_mention">Mentions L&eacute;gales</a></li>
					<li><a href="?contenu=gestion_fonct">Fonctionnement</a></li>
					<li><a href="?contenu=gestion_faq">F.A.Q</a></li>
					<li><a href="?contenu=conseil">Conseils</a></li>
          			<li><a href="?contenu=annonce">Annonces</a></li>
					<li><a href="?contenu=service">Nos services</a></li>
					<li><a href="?contenu=diaporama">Diaporama partenaires</a></li>
					<li><a href="?contenu=formulaire">Formulaires</a></li>
          			<li><a href="?contenu=simulateur">Simulateur</a></li>
					<li><a href="?contenu=mail">Contenu, email et sms</a></li>
		          	<li><a href="?contenu=news_envoie">Envoie Newsletter</a></li>
		            <li><a href="?contenu=news_inscrit">Lites des inscrits</a></li>
				  </ul>
          </div>
		<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
            ';
}
elseif ( $user['profil']==4 ) // gestion prix
{
	echo'
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
          </ul>
          </div>
		<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
			';

}
elseif ( $user['profil']==9 ) // Espace particulier
{
	echo'
          <a class="menuitem submenuheader" href="" >Espace particulier</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=part_liste">Liste de clients</a></li>
          	<li><a href="?contenu=part_news_envoie">Envoie Newsletter</a></li>
            <li><a href="?contenu=part_news_inscrit">Lites des inscrits</a></li>
		
          	<li><a href="?contenu=part_envoie_partenaire">Newsletter - Partenaire</a></li>
            <li><a href="?contenu=part_inscrit_partenaire">Inscrits - Partenaire</a></li>
          </ul>
          </div>
			<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
			';

}
elseif ( $user['profil']==5 ) // espace professionnel
{
	echo'
			<a class="menuitem submenuheader" href="" >Espace professionnel</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=pro_liste">Liste de clients</a></li>
          	<li><a href="?contenu=pro_news_envoie">Envoie Newsletter</a></li>
            <li><a href="?contenu=pro_news_inscrit">Lites des inscrits</a></li>
					
			<li><a href="?contenu=pro_envoie_partenaire">Newsletter - Partenaire</a></li>
            <li><a href="?contenu=pro_inscrit_partenaire">Inscrits - Partenaire</a></li>
          </ul>
          </div>
		<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
            ';
}
elseif ( $user['profil']==10 ) // Devis avec enchere
{
	echo'
           <a class="menuitem submenuheader" href="" >Devis avec enchere</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=devis_att_val">Devis à atribuer</a></li>
          	<li><a href="?contenu=devis_cour_ench">Devis en cours de enchere</a></li>
          	<li><a href="?contenu=devis_att_paye">Devis en attende de payement</a></li>
          	<li><a href="?contenu=devis_envoye">Devis signé</a></li>
          </ul>
          </div>
		<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
			';

}
elseif ( $user['profil']==11 ) // Devis avec achat imédiat
{
	echo'
          <a class="menuitem submenuheader" href="" >Devis avec achat imédiat</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=devisa_admin_ajout">Ajouter devis</a></li>
          	<li><a href="?contenu=devisa_att_val">Devis à atribuer</a></li>
          	<li><a href="?contenu=devisa_att_paye">Devis en attende de payement</a></li>
          	<li><a href="?contenu=devisa_envoye">Devis signé</a></li>
          </ul>
          </div>
		<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
			';

}
elseif ( $user['profil']==12 ) // Gestion des commandes
{
	echo'
         <a class="menuitem submenuheader" href="" >Gestion des commandes</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=commandes_att_paye">Commandes en attende de paiement</a></li>
          	<li><a href="?contenu=commandes_valides">Commandes validées</a></li>
          </ul>
          </div>
			<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
			';

}
elseif ( $user['profil']==3 ) // admin ajout
{
		echo'
			<a class="menuitem submenuheader" href="" >Devis ajoutés par l\'admin</a>
          <div class="submenu">
          <ul>	
          	<li><a href="?contenu=devis_admin_ajouter">Devis en attente de traitement</a></li>
			<li><a href="?contenu=devis_admin_admin_ajout&stat=2">Statut : Client injoignable</a></li>
			<li><a href="?contenu=devis_admin_admin_ajout&stat=3">Statut : Travaux fini</a></li>
			<li><a href="?contenu=devis_admin_admin_ajout&stat=4">Statut : Faux numéro</a></li>
			<li><a href="?contenu=devis_admin_admin_ajout&stat=5">Statut : Déjà trouver un artisan</a></li>
			<li><a href="?contenu=devis_admin_admin_ajout&stat=7">Statut : Pas de travaux</a></li>
			<li><a href="?contenu=devis_admin_admin_ajout&stat=8">Statut : Projet abondonné</a></li>
          </ul>
          </div>

		<a class="menuitem" href="index.php?contenu=payement_ajout">Paiement</a>
		<a class="menuitem" href="index.php?contenu=statistique">Statistique</a>
		<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
            ';
}
elseif ( $user['profil']==13 ) // admin chat
{
		echo'
				<a class="menuitem" href="index.php?contenu=chat">Chat</a>
			';
		echo'

          			
          	 <a class="menuitem" href="index.php?contenu=userspwd">Modifier mot de passe</a>
            ';
}
elseif ( $user['profil']==2 || $user['profil']==6 ) // admin zone
{
	//if ( $user['id_user']==253 ) echo '<a class="menuitem" href="index.php?contenu=chat">Chat</a>';
		echo'
				<a class="menuitem" href="index.php?contenu=chat">Chat</a>
				<a class="menuitem" href="index.php?contenu=agenda">Agenda</a>	
                <a class="menuitem submenuheader" href="" >Gestion du Site</a>
                <div class="submenu">
                    <ul>
					<li><a href="?contenu=zcoordonnees">Coordonnées</a></li>
					<li><a href="?contenu=zannonce">Annonces</a></li>
					<li><a href="?contenu=zservice">Nos services</a></li>
					<li><a href="?contenu=zdiaporama">Diaporama partenaires</a></li>
				  </ul>
          		</div>
			';
		echo'
			<a class="menuitem submenuheader" href="" >Espace professionnel</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=pro_liste">Liste de clients</a></li>
          	<li><a href="?contenu=pro_news_envoie">Envoie Newsletter</a></li>
            <li><a href="?contenu=pro_news_inscrit">Lites des inscrits</a></li>
						
			<li><a href="?contenu=pro_envoie_partenaire">Newsletter - Partenaire</a></li>
            <li><a href="?contenu=pro_inscrit_partenaire">Inscrits - Partenaire</a></li>
          </ul>
          </div>				
            ';
		echo'
			<a class="menuitem submenuheader" href="" >Devis ajoutés par l\'admin</a>
          <div class="submenu">
          <ul>	
          	<li><a href="?contenu=devis_admin_ajouter">Devis en attente de traitement</a></li>	
			<li><a href="?contenu=devis_admin_admin_zone&stat=1">Statut : rdv pris</a></li>
			<li><a href="?contenu=devis_admin_admin_zone&stat=2">Statut : a rappeler</a></li>
          	<li><a href="?contenu=devis_admin_admin_zone&stat=6">Statut : autres</a></li>						
          	<li><a href="?contenu=devis_admin_att_val">Devis à atribuer</a></li>
          	<li><a href="?contenu=devis_admin_envoye">Devis signé</a></li>
          </ul>
          </div>	

          			
          	 <a class="menuitem" href="index.php?contenu=userspwd">Modifier mot de passe</a>
          	<a class="menuitem" href="index.php?contenu=payement_zone">Paiement</a>		
			<a class="menuitem" href="index.php?contenu=statistique">Statistique</a>
			<a class="menuitem" href="index.php?contenu=doc">Documents</a>	
			<a class="menuitem" href="index.php?contenu=email">Envoie Email</a>	
            ';
}
elseif ( $user['profil']==1 ) // admin general
{
	//if ( $user['id_user']==1 ) echo '<a class="menuitem" href="index.php?contenu=chatt">Chat</a>';
	echo'
				<a class="menuitem" href="index.php?contenu=chat">Chat</a>
				<a class="menuitem" href="index.php?contenu=chatt">Historique Chat</a>
          		<a class="menuitem" href="index.php?contenu=agenda_admin">Agenda</a>		
                <a class="menuitem submenuheader" href="" >Départements et villes</a>
                <div class="submenu">
                    <ul>
          			<li><a href="?contenu=dep">Départements</a></li>
					<li><a href="?contenu=vil">Villes</a></li>
				  </ul>
          </div>
          
                <a class="menuitem submenuheader" href="" >Gestion du Site</a>
                <div class="submenu">
                    <ul>
          			<li><a href="?contenu=logo">Logo</a></li>
          			<li><a href="?contenu=coordonnees">Coordonnées</a></li>
					<li><a href="?contenu=gestion_presentation">Pr&eacute;sentation <br /> Qui sommes nous</a></li>
					<li><a href="?contenu=gestion_mention">Mentions L&eacute;gales</a></li>
					<li><a href="?contenu=gestion_fonct">Fonctionnement</a></li>
					<li><a href="?contenu=gestion_faq">F.A.Q</a></li>
					<li><a href="?contenu=conseil">Conseils</a></li>
          			<li><a href="?contenu=annonce">Annonces</a></li>
					<li><a href="?contenu=service">Nos services</a></li>
					<li><a href="?contenu=diaporama">Diaporama partenaires</a></li>
					<li><a href="?contenu=formulaire">Formulaires</a></li>
          			<li><a href="?contenu=simulateur">Simulateur</a></li>
					<li><a href="?contenu=mail">Contenu, email et sms</a></li>
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
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Espace particulier</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=part_liste">Liste de clients</a></li>
          	<li><a href="?contenu=part_news_envoie">Envoie Newsletter</a></li>
            <li><a href="?contenu=part_news_inscrit">Lites des inscrits</a></li>
			
			<li><a href="?contenu=part_envoie_partenaire">Newsletter - Partenaire</a></li>
            <li><a href="?contenu=part_inscrit_partenaire">Inscrits - Partenaire</a></li>
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Espace professionnel</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=pro_liste">Liste de clients</a></li>
          	<li><a href="?contenu=pro_news_envoie">Envoie Newsletter</a></li>
            <li><a href="?contenu=pro_news_inscrit">Lites des inscrits</a></li>
					
			<li><a href="?contenu=pro_envoie_partenaire">Newsletter - Partenaire</a></li>
            <li><a href="?contenu=pro_inscrit_partenaire">Inscrits - Partenaire</a></li>
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Devis avec enchere</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=devis_att_val">Devis à atribuer</a></li>
          	<li><a href="?contenu=devis_cour_ench">Devis en cours de enchere</a></li>
          	<li><a href="?contenu=devis_att_paye">Devis en attende de payement</a></li>
          	<li><a href="?contenu=devis_envoye">Devis signé</a></li>
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Devis avec achat imédiat</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=devisa_admin_ajout">Ajouter devis</a></li>
          	<li><a href="?contenu=devisa_att_val">Devis à atribuer</a></li>
          	<li><a href="?contenu=devisa_att_paye">Devis en attende de payement</a></li>
          	<li><a href="?contenu=devisa_envoye">Devis signé</a></li>
          </ul>
          </div>
					
          <a class="menuitem submenuheader" href="" >Gestion des commandes</a>
          <div class="submenu">
          <ul>
          	<li><a href="?contenu=commandes_att_paye">Commandes en attende de paiement</a></li>
          	<li><a href="?contenu=commandes_valides">Commandes validées</a></li>
          </ul>
          </div>
          
          <a class="menuitem submenuheader" href="" >Devis ajoutés par l\'admin</a>
          <div class="submenu">
          <ul>	
          	<li><a href="?contenu=devis_admin_ajouter">Devis en attente de traitement</a></li>
          		
          	<li><a href="?contenu=devis_admin_administrateur&stat=1">Statut : rdv pris</a></li>
			<li><a href="?contenu=devis_admin_administrateur&stat=2">Statut : a rappeler</a></li>
          	<li><a href="?contenu=devis_admin_administrateur&stat=3">Statut : Travaux fini</a></li>
			<li><a href="?contenu=devis_admin_administrateur&stat=4">Statut : Faux numéro</a></li>
			<li><a href="?contenu=devis_admin_administrateur&stat=5">Statut : Déjà trouver un artisan</a></li>
          	<li><a href="?contenu=devis_admin_administrateur&stat=6">Statut : autres</a></li>	
          	<li><a href="?contenu=devis_admin_administrateur&stat=7">Statut : Pas de travaux</a></li>
			<li><a href="?contenu=devis_admin_administrateur&stat=8">Statut : Projet abondonné</a></li>	
          				
          	<li><a href="?contenu=devis_admin_att_val">Devis à atribuer</a></li>		
          	<li><a href="?contenu=devis_admin_envoye">Devis signé</a></li>
          </ul>
          </div>
          			
          <a class="menuitem submenuheader" href="" >Devis archiver</a>
          <div class="submenu">
          <ul>	
          	<li><a href="?contenu=devis_admin_ajouter_archifier">Devis en attente de traitement</a></li>
          		
          	<li><a href="?contenu=devis_admin_administrateur_archifier&stat=1">Statut : rdv pris</a></li>
			<li><a href="?contenu=devis_admin_administrateur_archifier&stat=2">Statut : a rappeler</a></li>
          	<li><a href="?contenu=devis_admin_administrateur_archifier&stat=3">Statut : Travaux fini</a></li>
			<li><a href="?contenu=devis_admin_administrateur_archifier&stat=4">Statut : Faux numéro</a></li>
			<li><a href="?contenu=devis_admin_administrateur_archifier&stat=5">Statut : Déjà trouver un artisan</a></li>
          	<li><a href="?contenu=devis_admin_administrateur_archifier&stat=6">Statut : autres</a></li>	
          	<li><a href="?contenu=devis_admin_administrateur_archifier&stat=7">Statut : Pas de travaux</a></li>
			<li><a href="?contenu=devis_admin_administrateur_archifier&stat=8">Statut : Projet abondonné</a></li>	
          					
          	<li><a href="?contenu=devis_admin_att_val_archifier">Devis à atribuer</a></li>		
          	<li><a href="?contenu=devis_admin_envoye_archifier">Devis signé</a></li>
          </ul>
          </div>

          		
           <a class="menuitem" href="index.php?contenu=devis_admin_admin_recherche">Recherche globale</a>
          			
          		
          <a class="menuitem submenuheader" href="" >Gestion des utilisateurs</a>
          <div class="submenu">
          <ul>	
          	<li><a href="?contenu=users">Gestion des utilisateurs</a></li>
					
			<li><a href="?contenu=affi_envoie_partenaire">Newsletter - Partenaire</a></li>
            <li><a href="?contenu=affi_inscrit_partenaire">Inscrits - Partenaire</a></li>
					
          	<li><a href="?contenu=connect_admin">Connexion admin</a></li>
          	<li><a href="?contenu=payement_ajout_admin">Paiement user ajout</a></li>
          	<li><a href="?contenu=payement_zone_admin">Paiement user zone</a></li>
          	<li><a href="?contenu=statistique">Statistique</a></li>
          </ul>
          </div>

			<a class="menuitem" href="index.php?contenu=doc">Documents</a>	
			<a class="menuitem" href="index.php?contenu=emaill">Envoie Email</a>	
           <a class="menuitem" href="index.php?contenu=boutique">Gestion modules de paiement</a>
        ';
}
?>               
                
<!--              
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
           
    -->           
           
           
           
           
            </div>
        <div class="sidebar_box"></div>
    </div>  
                    
  </div>   <!--end of center content -->               
  	<div class="right_content"> 




<?php
echo '<div style="color:red;">'.$alert_rdv_rappeler.'</div>' ;

	if(isset($_GET['contenu']))
	{
		switch($_GET['contenu'])
		{
			case 'agenda'	        		: include 'agenda.php'; 			       			break;
			case 'chat'	        			: include 'chat.php'; 			       				break;
			case 'chatt'	        		: include 'chatt.php'; 			       				break;
			
			case 'logo'	        			: include 'logo.php'; 			       				break;
			case 'dep'	        			: include 'dep.php'; 			       				break;
			case 'vil'	        			: include 'vil.php'; 			       				break;
			
			case 'agenda_admin'	        	: include 'agenda_admin.php'; 			       		break;
			case 'zcoordonnees'	        	: include 'zcoordonnees.php'; 			    	  	break;
			case 'zannonce'	        		: include 'zannonce.php'; 			       			break;
			case 'zservice'	       			: include 'zservice.php'; 			        		break;
			case 'zdiaporama'	        	: include 'zdiaporama.php'; 			    	  	break;
			
			case 'coordonnees'	        	: include 'coordonnees.php'; 			    	  	break;
			case 'gestion_presentation'	    : include 'gestion_presentation.php'; 			    break;
			case 'gestion_mention'	        : include 'gestion_mention.php'; 			        break;
			case 'gestion_fonct'	        : include 'gestion_fonct.php'; 			            break;
			case 'ajout_faq'	            : include 'ajout_faq.php'; 			            	break;
			case 'gestion_faq'	            : include 'gestion_faq.php'; 			            break;
			case 'conseil'	        		: include 'conseil.php'; 			        		break;
			case 'annonce'	        		: include 'annonce.php'; 			       			break;
			case 'service'	       			: include 'service.php'; 			        		break;
			case 'diaporama'	        	: include 'diaporama.php'; 			    	  	 	break;
			case 'formulaire'	        	: include 'page_formulaire.php'; 			       	break;
			case 'simulateur'	        	: include 'page_simulateur.php'; 			       	break;
			case 'mail'	        			: include 'mail.php'; 			            		break;
			case 'news_envoie'				: include 'news_envoie.php'; 						break;
			case 'news_inscrit'				: include 'news_inscrit.php'; 						break;
	
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
			case 'part_envoie_partenaire'	: include 'part_envoie_partenaire.php'; 			break;
			case 'part_inscrit_partenaire'	: include 'part_inscrit_partenaire.php'; 			break;
			
			case 'pro_liste'	        	: include 'pro_liste.php'; 			            	break;
			case 'pro_news_envoie'			: include 'pro_news_envoie.php'; 					break;
			case 'pro_news_inscrit'			: include 'pro_news_inscrit.php'; 					break;
			case 'pro_envoie_partenaire'	: include 'pro_envoie_partenaire.php'; 				break;
			case 'pro_inscrit_partenaire'	: include 'pro_inscrit_partenaire.php'; 			break;
			
			case 'affi_envoie_partenaire'	: include 'affi_envoie_partenaire.php'; 			break;
			case 'affi_inscrit_partenaire'	: include 'affi_inscrit_partenaire.php'; 			break;
			
				
			case 'devis_att_val'	        : include 'devis_att_val.php'; 			            break;
			case 'devis_cour_ench'	        : include 'devis_cour_ench.php'; 			        break;
			case 'devis_att_paye'	        : include 'devis_att_paye.php'; 			        break;
			case 'devis_envoye'	        	: include 'devis_envoye.php'; 			        	break;
				
			case 'devisa_admin_ajout'	    : include 'devisa_admin_ajout.php'; 			    break;
			case 'devisa_att_val'	        : include 'devisa_att_val.php'; 			        break;
			case 'devisa_att_paye'	        : include 'devisa_att_paye.php'; 			        break;
			case 'devisa_envoye'	        : include 'devisa_envoye.php'; 			        	break;
			
			case 'commandes_att_paye'	    : include 'commandes_att_paye.php'; 			    break;
			case 'commandes_valides'	    : include 'commandes_valides.php'; 			        break;
				
			case 'devis_admin_ajouter'	    : include 'devis_admin_ajouter.php'; 			    break;
			case 'devis_admin_admin_ajout'	: include 'devis_admin_admin_ajout.php'; 		    break;
			case 'devis_admin_admin_zone'	: include 'devis_admin_admin_zone.php'; 		    break;
			case 'devis_admin_administrateur'	: include 'devis_admin_administrateur.php';     break;
			case 'devis_admin_att_val'	    : include 'devis_admin_att_val.php'; 			    break;
			case 'devis_admin_envoye'	    : include 'devis_admin_envoye.php'; 			    break;
			
			case 'devis_admin_ajouter_archifier'	    : include 'devis_admin_ajouter_archifier.php'; 			    break;
			case 'devis_admin_administrateur_archifier'	: include 'devis_admin_administrateur_archifier.php';     break;
			case 'devis_admin_att_val_archifier'	    : include 'devis_admin_att_val_archifier.php'; 			    break;
			case 'devis_admin_envoye_archifier'	    : include 'devis_admin_envoye_archifier.php'; 			    break;
			
			case 'devis_admin_admin_recherche'	: include 'devis_admin_admin_recherche.php'; 			    break;
			
			case 'users'                    : include 'users.php';					            break;
			case 'connect_admin'            : include 'connect_admin.php';					    break;
			case 'payement_ajout'           : include 'payement_ajout.php';					    break;
			case 'payement_zone'            : include 'payement_zone.php';					    break;
			case 'payement_ajout_admin'     : include 'payement_ajout_admin.php';				break;
			case 'payement_zone_admin'      : include 'payement_zone_admin.php';				break;
			case 'statistique'            	: include 'statistique.php';					    break;
			case 'userspwd'                 : include 'userspwd.php';					        break;
			case 'boutique'                 : include 'boutique.php';					        break;
			
			case 'doc'                      : include 'doc.php';					            break;
			case 'email'                     : include 'email.php';					            break;
			case 'emaill'                     : include 'emaill.php';					            break;
		}
	}	


if ( !isset($_GET['contenu']) )
{
	echo'
		<strong>Bonjour et bienvenue sur votre interface d\'administration.</strong><br />
        
        <p>Les diff&eacute;rentes sections sur votre gauche vous permettent de g&eacute;rer les pages de votre site de fa&ccedil;on autonome.
        
        Vous pouvez &eacute;galement ajouter des utilisateurs, afin de leur laisser un acc&eacute;s &agrave; ce service d\'administration.
        
        Vous trouverez enfin une page d\'informations pour contacter Liweb agency.</p>
		';
}
/*
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
<?php } */?>     
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