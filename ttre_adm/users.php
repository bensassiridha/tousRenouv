
<?php

$rand = substr(mt_rand(),1,5);

$my = new mysql();

$tab_profil_1=array(1=>'Administrateur',
		2=>'Admin par zone',
		3=>'Ajouter devis',
		4=>'Gestion de prix',
		5=>'Espace proffessionnel',
		6=>'Super admin',
		7=>'Départements et villes',
		8=>'Gestion du Site',
		9=>'Espace particulier',
		10=>'Devis avec enchere',
		11=>'Devis avec achat imédiat',
		12=>'Gestion des commandes',
		13=>'Admin chat'
);


//$my->req('UPDATE ttre_users SET statut="1" ');

if (!empty($_GET['action']))
{

	
	switch($_GET['action'])
	{
		case 'envoyer' :
			$u=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$_GET['id'].' ');
			$e=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_GET['id'].' ');
			$nom=$u['nom'];$mail=$e['email'];
			$message_html = '
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
					<title>'.$nom_client.'</title>
				</head>
		
				<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
					<div id="corps" style="margin:0 auto; width:800px; height:auto;">
						<center><img src="'.$logo_client.'" /></center><br />
						<h1 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">'.$nom_client.'</h1>
						<p>Bonjour,</p>
						<p>'.$nom.'</p>
						<p>'.$_POST['contenu'].'</p>
						<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
							<p style="padding-top:10px;">'.$nom_client.'</p>
						</div>
					</div>
				</body>
				</html>
				';
			//$mail_client='bilelbadri@gmail.com';
			/*$sujet = $nom_client.' : Info ';
			 $headers = "From: \" ".$nom." \"<".$mail.">\n";
			$headers .= "Reply-To: ".$mail_client."\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			mail($mail,$sujet,$message_html,$headers);*/
				
			$destinataire=$mail;
			//$destinataire='bilelbadri@gmail.com';
			$mail_client='contact@tousrenov.fr';
			$email_expediteur=$mail_client;
			$email_reply=$mail_client;
			$titre_mail=$nom_client;
			$sujet=$nom_client.' : Info ';
				
			$frontiere = '-----=' . md5(uniqid(mt_rand()));
			$headers = 'From: "'.$titre_mail.'"<'.$email_reply.'> '."\n";
			$headers .= 'Return-Path: <'.$email_reply.'>'."\n";
			$headers .= 'MIME-Version: 1.0'."\n";
			$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
				
			$message = '';
			$message .= '--'.$frontiere."\n";
			$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
			$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
				
			$message .= $message_html."\n\n";
				
			$message .= '--'.$frontiere.'--'."\r\n";
				
			mail($destinataire,$sujet,$message,$headers);
				
				
			rediriger('?contenu=users');
			break;
			
		case 'ajouter' :	
			$my->req('INSERT INTO ttre_users VALUES("","'.$_POST['nom'].'","'.$_POST['login'].'","'.md5($_POST['mdp1']).'","'.$_POST['prof'].'","1")');
			$id=mysql_insert_id();
			$my->req('INSERT INTO ttre_zcoordonnees VALUES("'.$id.'","'.$_POST['email'].'","'.$_POST['tel'].'","" )');
			if ( $_POST['prof']==2 )
			{
				foreach ( $_POST['departement'] as $value )
					$my->req("INSERT INTO ttre_users_zones VALUES('','".$id."','".$value."')");
			}
			if ( $_POST['prof']==6 )
			{
				foreach ( $_POST['super_departement'] as $value )
					$my->req("INSERT INTO ttre_users_zones VALUES('','".$id."','".$value."')");
			}
			echo '<script> alert ("L\'utilisateur a bien \351t\351 ajout\351.");</script>';
			echo '<script>document.location.href="?contenu=users" </script>';
			exit;
		break;
		
		case 'modifier' :
			$user 	=  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_GET['id'].'"');
			$zuser=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_GET['id']);
			if(!empty($_POST['nom']))
			{
				(isset($_POST['mdp1']) && $_POST['mdp1'] = $_POST['mdp2'])?$mdp = md5($_POST['mdp1']): $mdp=$user['password'];
				
				$req_modif_user = $my->req('UPDATE ttre_users SET 
													nom = "'.$_POST['nom'].'", 
													login = "'.$_POST['login'].'", 
													password = "'.$mdp.'" ,
													profil = "'.$_POST['prof'].'"
												WHERE id_user = "'.$_GET['id'].'"');
				$my->req('UPDATE ttre_zcoordonnees SET
					email			=	"'.$my->net_input($_POST['email']).'" ,
					tel				=	"'.$my->net_input($_POST['tel']).'" 
							WHERE id = "'.$_GET['id'].'" ');
				
				$my->req('DELETE FROM ttre_users_zones WHERE id_user='.$_GET['id'].' ');
				if ( $_POST['prof']==2 )
				{
					foreach ( $_POST['departement'] as $value )
						$my->req("INSERT INTO ttre_users_zones VALUES('','".$_GET['id']."','".$value."')");
				}
				if ( $_POST['prof']==6 )
				{
					foreach ( $_POST['super_departement'] as $value )
						$my->req("INSERT INTO ttre_users_zones VALUES('','".$_GET['id']."','".$value."')");
				}
				echo '<script> alert ("L\'utilisateur a bien \351t\351 modifi\351.");</script>';
				echo '<script>document.location.href="?contenu=users" </script>';
				exit;
			}
			else
			{		
				# formulaire de modification
				$zone_intervention='';
				$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');
				if ( $my->num($reqCat)>0 )
				{
					$i=1;$zone_intervention.='<table>';
					while ( $resCat=$my->arr($reqCat) )
					{
						if ( $i%3==1 ) $zone_intervention.='<tr>';
						$check='';
						$temp=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_GET['id'].' AND zone='.$resCat['departement_id'].' ');
						if ( $my->num($temp)>0 )$check='checked="checked"';
						$reqDisabled=$my->req('SELECT * FROM ttre_users U , ttre_users_zones Z WHERE U.id_user=Z.id_user AND Z.zone='.$resCat['departement_id'].' AND U.profil=2 AND Z.id_user!='.$_GET['id'].'  ');
						if ( $my->num($reqDisabled)>0 ) $disabled=' disabled="disabled" ';else $disabled='';
						$zone_intervention.='<td><input type="checkbox" '.$check.' name="departement[]" value="'.$resCat['departement_id'].'" '.$disabled.' /> '.$resCat['departement_nom'].'</td>';
						if ( $i%3==0 ) $zone_intervention.='</tr>';
						$i++;
					}
					$zone_intervention.='</table>';
				}
				
				$super_zone_intervention='';
				$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');
				if ( $my->num($reqCat)>0 )
				{
					$i=1;$super_zone_intervention.='<table>';
					while ( $resCat=$my->arr($reqCat) )
					{
						if ( $i%3==1 ) $super_zone_intervention.='<tr>';
						$check='';
						$temp=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_GET['id'].' AND zone='.$resCat['departement_id'].' ');
						if ( $my->num($temp)>0 )$check='checked="checked"';
						$reqDisabled=$my->req('SELECT * FROM ttre_users U , ttre_users_zones Z WHERE U.id_user=Z.id_user AND Z.zone='.$resCat['departement_id'].' AND U.profil=6 AND Z.id_user!='.$_GET['id'].'  ');
						if ( $my->num($reqDisabled)>0 ) $disabled=' disabled="disabled" ';else $disabled='';
						$super_zone_intervention.='<td><input type="checkbox" '.$check.' name="super_departement[]" value="'.$resCat['departement_id'].'" '.$disabled.' /> '.$resCat['departement_nom'].'</td>';
						if ( $i%3==0 ) $super_zone_intervention.='</tr>';
						$i++;
					}
					$super_zone_intervention.='</table>';
				}
				
				if ( $user['profil']==2 ) $style=''; else $style='style="display:none;"';
				if ( $user['profil']==6 ) $super_style=''; else $super_style='style="display:none;"';
				$form = new formulaire('modele_1','?contenu=users&action=modifier&id='.$_GET['id'],'','','','sub','txt','','txt_obl','lab_obl','');
				$form->text('Nom','nom','',true,$user['nom']);
				$form->text('Email','email','',true,$zuser['email']);
				$form->text('Tel','tel','',true,$zuser['tel']);
				$form->text('Identifiant','login','',true,$user['login']);
				$form->password('Nouveau mot de passe','mdp1');
				$form->password('V&eacute;rification du mot de passe','mdp2');
				$form->radio_cu('Profil','prof',$tab_profil_1,$user['profil']);
				$form->vide('<tr id="zone" '.$style.'><td align="right"><label class="">Zone d\'intervention : </label></td><td>'.$zone_intervention.'<br /><br /></td></tr>');
				$form->vide('<tr id="super_zone" '.$super_style.'><td align="right"><label class="">Zone d\'intervention : </label></td><td>'.$super_zone_intervention.'<br /><br /></td></tr>');
				$form->afficher('Enregistrer les modifications');
				/*$form = new formulaire('modele_1','?contenu=users&action=envoyer&id='.$_GET['id'],'','','','sub','txt','','txt_obl','lab_obl','');
				$form->textarea('Contenu Email','contenu');
				$form->afficher('Envoyer');*/
			}
		break;
		
		case 'supprimer' :			
			$my->req('DELETE FROM ttre_users WHERE id_user="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_users_zones WHERE id_user='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_users_coordonnees WHERE id_user='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_zcoordonnees WHERE id='.$_GET['id'].' ');
			echo '<script> alert ("L\'utilisateur a bien \351t\351 supprim\351.");</script>';
			echo '<script>document.location.href="?contenu=users" </script>';
			exit;
		break;	
		case 'valid' :
			$temp=$my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_GET['id'].'"');
			$my->req('UPDATE ttre_users SET statut="'.!$temp['statut'].'" WHERE id_user="'.$_GET['id'].'"');
			$req=$my->req('SELECT * FROM ttre_connection_admin WHERE fin=0 AND id_user='.$_GET['id'].'');
			while ( $res=$my->arr($req) )
			{
					$my->req('UPDATE ttre_connection_admin SET fin="'.$res['fin_ajax'].'" WHERE id = '.$res['id'].' ' );
			}
			echo '<script> alert ("Le statut a bien \351t\351 modifi\351.");</script>';
			echo '<script>document.location.href="?contenu=users" </script>';
			exit;
		break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des utilisateurs</h1>';
	
	$tabDep[]='';
	$rq=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	while ( $rs=$my->arr($rq) ) $tabDep[$rs['departement_id']]=$rs['departement_nom'];
	
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
	
	$form = new formulaire('modele_1','?contenu=users','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Zone','dep',$tabDep,$dep);
	$form->afficher1('Rechercher');
	
	if ( $dep==0 )
	{
		$req_users2 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=2 ORDER BY nom ASC');
		$req_users6 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=6 ORDER BY nom ASC');
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=4 ORDER BY nom ASC');
		$req_users5 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=5 ORDER BY nom ASC');
		$affich=1;
	}
	elseif ( $dep!=0 )
	{
		$req_users2 = $my->req('SELECT *
								FROM
									ttre_users U ,
									ttre_users_zones Z
								WHERE
									U.id_user=Z.id_user
									AND Z.zone='.$dep.'
									AND U.id_user > 1
				 					AND profil=2
								ORDER BY U.nom ASC');
		
		$req_users6 = $my->req('SELECT *
								FROM
									ttre_users U ,
									ttre_users_super_zones Z
								WHERE
									U.id_user=Z.id_user
									AND Z.zone='.$dep.'
									AND U.id_user > 1
				 					AND profil=6
								ORDER BY U.nom ASC');
		
		$affich=0;
	}
	
	
	if ( $affich==1 )
	{
		$req_users1 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=1 ORDER BY nom ASC');
		if($my->num($req_users1)>0)
		{
			echo '<br /><br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users1))
			{
				$profil='';
				if ( $infos_user['profil']==1 ) $profil.='Administrateur';
				elseif ( $infos_user['profil']==3 ) $profil.='Ajouter un devis';
				elseif ( $infos_user['profil']==2 ) 
				{
					$zz='';
					$req = $my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$infos_user['id_user'].' ');
					while ( $res=$my->arr($req) )
					{
						$temp=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$res['zone'].' ');
						$zz.=$temp['departement_nom'].', ';
					}
					$profil.='Admin pour : '.$zz;
				}
	
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
				
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>'.$profil.'</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
					if ($infos_user['id_user'] > 2)
					{
						echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
					}
					echo '
					</a>
					</td>
				</tr>
				';			
			}
			echo '</table>';
		}
	}	
		
	
	if($my->num($req_users2)>0)
	{
		echo '<br /><br />
		<table id="liste_produits">
			<tr class="entete">
				<td>Nom</td>
				<td>Profil</td>
				<td class="bouton">Statut</td>
				<td class="bouton">Modifier</td>
				<td class="bouton">Supprimer</td>
			</tr>
		';
		while($infos_user = $my->arr($req_users2))
		{
			$profil='';
			if ( $infos_user['profil']==1 ) $profil.='Administrateur';
			elseif ( $infos_user['profil']==3 ) $profil.='Ajouter un devis';
			elseif ( $infos_user['profil']==2 ) 
			{
				$zz='';
				$req = $my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$infos_user['id_user'].' ');
				while ( $res=$my->arr($req) )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$res['zone'].' ');
					$zz.=$temp['departement_nom'].', ';
				}
				$profil.='Admin pour : '.$zz;
			}
			
			if ( $infos_user['statut']==1 )
				$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
			else
				$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
			
			if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
			
			echo '
			<tr '.$style.' >
				<td>'.$infos_user['nom'].'</td>
				<td>'.$profil.'</td>
				<td class="bouton">'.$a_valid.'</td>
				<td class="bouton">
				<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
				<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
				<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
				</a>
				</td>
			</tr>
			';			
		}
		echo '</table>';
	}
	
	if($my->num($req_users6)>0)
	{
		echo '<br /><br />
		<table id="liste_produits">
			<tr class="entete">
				<td>Nom</td>
				<td>Profil</td>
				<td class="bouton">Statut</td>
				<td class="bouton">Modifier</td>
				<td class="bouton">Supprimer</td>
			</tr>
		';
		while($infos_user = $my->arr($req_users6))
		{
			$profil='';
			if ( $infos_user['profil']==1 ) $profil.='Administrateur';
			elseif ( $infos_user['profil']==3 ) $profil.='Ajouter un devis';
			elseif ( $infos_user['profil']==6 )
			{
				$zz='';
				$req = $my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$infos_user['id_user'].' ');
				while ( $res=$my->arr($req) )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$res['zone'].' ');
					$zz.=$temp['departement_nom'].', ';
				}
				$profil.='Super Admin pour : '.$zz;
			}
	
			if ( $infos_user['statut']==1 )
				$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
			else
				$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
				
			if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
			
			echo '
			<tr '.$style.' >
				<td>'.$infos_user['nom'].'</td>
				<td>'.$profil.'</td>
				<td class="bouton">'.$a_valid.'</td>
				<td class="bouton">
				<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
				<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
				<td class="bouton">';
			if ($infos_user['id_user'] > 2)
			{
				echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
			}
			echo '
				</a>
				</td>
			</tr>
			';
		}
		echo '</table>';
	}
	
	
	if ( $affich==1 )
	{
		$req_users3 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=3 ORDER BY nom ASC');
		if($my->num($req_users3)>0)
		{
			echo '<br /><br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users3))
			{
				$profil='';
				if ( $infos_user['profil']==1 ) $profil.='Administrateur';
				elseif ( $infos_user['profil']==3 ) $profil.='Ajouter un devis';
				elseif ( $infos_user['profil']==2 )
				{
					$zz='';
					$req = $my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$infos_user['id_user'].' ');
					while ( $res=$my->arr($req) )
					{
						$temp=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$res['zone'].' ');
						$zz.=$temp['departement_nom'].', ';
					}
					$profil.='Admin pour : '.$zz;
				}
	
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>'.$profil.'</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		
		//---------------------------- Départements et villes --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=7 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Départements et villes</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		//---------------------------- Gestion du Site --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=8 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Gestion du Site</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		//---------------------------- Gestion de prix --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=4 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Gestion de prix</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		//---------------------------- Espace particulier --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=9 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Espace particulier</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		//---------------------------- Espace professionnel --------------------------------------------------------------------------------
		$req_users5 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=5 ORDER BY nom ASC');
		if($my->num($req_users5)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users5))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
				
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Espace professionnel</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		//---------------------------- Devis avec enchere --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=10 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Devis avec enchere</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		//---------------------------- Devis avec achat imédiat --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=11 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Devis avec achat imédiat</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		//---------------------------- Devis avec achat imédiat --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=12 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Gestion des commandes</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		//---------------------------- Admin chat --------------------------------------------------------------------------------
		$req_users4 = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 AND profil=13 ORDER BY nom ASC');
		if($my->num($req_users4)>0)
		{
			echo '<br />
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td>Profil</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
			while($infos_user = $my->arr($req_users4))
			{
				
				if ( $infos_user['statut']==1 )
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user validé">User validé</a>';
				else
					$a_valid = '<a href="?contenu=users&action=valid&id='.$infos_user['id_user'].'" title="user pas validé">User suspendu</a>';
					
				if ( $infos_user['statut']==1 ) $style = ''; else $style = ' style="color:red;" ';
				
				echo '
				<tr '.$style.' >
					<td>'.$infos_user['nom'].'</td>
					<td>Admin chat</td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
					<a href="?contenu=users&action=modifier&id='.$infos_user['id_user'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">';
				if ($infos_user['id_user'] > 2)
				{
					echo '<a href="?contenu=users&action=supprimer&id='.$infos_user['id_user'].'" onClick="return confirm(\'&Ecirc;tes-vous sur de vouloir supprimer cet utilisateur ?\')"><img src="img/interface/btn_supp.png" alt="" border="0" />';
				}
				echo '
					</a>
					</td>
				</tr>
				';
			}
			echo '</table><br />';
		}
		//----------------------------------------------------------------------------------------------------------------------------------
		
		
		
	}
	
	
	
	
	
	echo '<h2 class="titre_niv2">Ajouter un utilisateur</h2>';
	$zone_intervention='';
	$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');
	if ( $my->num($reqCat)>0 )
	{
		$i=1;$zone_intervention.='<table>';
		while ( $resCat=$my->arr($reqCat) )
		{
			if ( $i%3==1 ) $zone_intervention.='<tr>';
			$reqDisabled=$my->req('SELECT * FROM ttre_users U , ttre_users_zones Z WHERE U.id_user=Z.id_user AND Z.zone='.$resCat['departement_id'].' AND U.profil=2 ');
			if ( $my->num($reqDisabled)>0 ) $disabled=' disabled="disabled" ';else $disabled='';
			$zone_intervention.='<td><input type="checkbox" name="departement[]" value="'.$resCat['departement_id'].'" '.$disabled.' /> '.$resCat['departement_nom'].'</td>';
			if ( $i%3==0 ) $zone_intervention.='</tr>';
			$i++;
		}
		$zone_intervention.='</table>';
	}
	
	$super_zone_intervention='';
	$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');
	if ( $my->num($reqCat)>0 )
	{
		$i=1;$super_zone_intervention.='<table>';
		while ( $resCat=$my->arr($reqCat) )
		{
			if ( $i%3==1 ) $super_zone_intervention.='<tr>';
			$reqDisabled=$my->req('SELECT * FROM ttre_users U , ttre_users_zones Z WHERE U.id_user=Z.id_user AND Z.zone='.$resCat['departement_id'].' AND U.profil=6 ');
			if ( $my->num($reqDisabled)>0 ) $disabled=' disabled="disabled" ';else $disabled='';
			$super_zone_intervention.='<td><input type="checkbox" name="super_departement[]" value="'.$resCat['departement_id'].'" '.$disabled.' /> '.$resCat['departement_nom'].'</td>';
			if ( $i%3==0 ) $super_zone_intervention.='</tr>';
			$i++;
		}
		$super_zone_intervention.='</table>';
	}
	
	$form = new formulaire('modele_1','?contenu=users&action=ajouter','','','','sub','txt','','txt_obl','lab_obl','return verifForm()');
	$form->text('Nom','nom','',true);
	$form->text('Email','email','',true);
	$form->text('Tel','tel','',true);
	$form->text('Identifiant','login','',true);
	$form->password('Mot de passe','mdp1',true);
	$form->radio('Profil','prof',$tab_profil_1);
	$form->vide('<tr id="zone" style="display:none;"><td align="right"><label class="">Zone d\'intervention : </label></td><td>'.$zone_intervention.'<br /><br /></td></tr>');
	$form->vide('<tr id="super_zone" style="display:none;"><td align="right"><label class="">Zone d\'intervention : </label></td><td>'.$super_zone_intervention.'<br /><br /></td></tr>');
	$form->afficher('Enregistrer l\'utilisateur');
}	

?>
<script type="text/javascript">
$(document).ready(function() 
{
	$('input[name="prof"]').click(function ()
	{
		$('#zone').css('display','none');
		$('#super_zone').css('display','none');
		if ( $('input[name="prof"]:checked').val()==2 ) $('#zone').css('display','');
		else if ( $('input[name="prof"]:checked').val()==6 ) $('#super_zone').css('display','');
	});
});
</script>

