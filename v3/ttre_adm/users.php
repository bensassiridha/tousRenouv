
<?php

$rand = substr(mt_rand(),1,5);

$my = new mysql();

if (!empty($_GET['action']))
{

	
	switch($_GET['action'])
	{
		case 'ajouter' :			
			$req_add_user = $my->req('INSERT INTO ttre_users VALUES("","'.$_POST['nom'].'","'.$_POST['login'].'","'.md5($_POST['mdp1']).'")');
			if(!$req_add_user)
			{
				echo '<script> alert ("Une erreur est survenue lors de l\'ajout. Veuillez recommencer ult\351rieurement.");</script>';
				echo '<script>document.location.href="javascript:history.go(-1)" </script>';
				exit;
			}
			else
			{
				echo '<script> alert ("L\'utilisateur a bien \351t\351 ajout\351.");</script>';
				echo '<script>document.location.href="?contenu=users" </script>';
				exit;
			}
		break;
		
		case 'modifier' :
			$user 	=  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_GET['id'].'"');			
			if(!empty($_POST['nom']))
			{
				(isset($_POST['mdp1']) && $_POST['mdp1'] = $_POST['mdp2'])?$mdp = md5($_POST['mdp1']): $mdp=$user['password'];
				
				$req_modif_user = $my->req('UPDATE ttre_users SET 
				nom = "'.$_POST['nom'].'", login = "'.$_POST['login'].'", password = "'.$mdp.'" 
				WHERE id_user = "'.$_GET['id'].'"');
				if(!$req_modif_user)
				{
					echo '<script> alert ("Une erreur est survenue lors de la modification. Veuillez recommencer ult\351rieurement.");</script>';
				}
				else
				{
					echo '<script> alert ("L\'utilisateur a bien \351t\351 modifi\351.");</script>';
					echo '<script>document.location.href="?contenu=users" </script>';
					exit;
				}
			}
			else
			{				
				# formulaire de modification
				$form = new formulaire('modele_1','?contenu=users&action=modifier&id='.$_GET['id'],'','formuser','return valid(this)','sub','txt','','txt_obl','lab_obl','return verifForm()');
				$form->text('Nom','nom','',true,$user['nom']);
				$form->text('Identifiant','login','',true,$user['login']);
				$form->password('Nouveau mot de passe','mdp1');
				$form->password('V&eacute;rification du mot de passe','mdp2');
				$form->afficher('Enregistrer les modifications');
			}
		break;
		
		case 'supprimer' :			
			$req_del_user = $my->req('DELETE FROM ttre_users WHERE id_user="'.$_GET['id'].'"');
			if(!$req_del_user)
			{
				echo '<script> alert ("Une erreur est survenue lors de la suppression. Veuillez recommencer ult\351rieurement.");</script>';
				echo '<script>document.location.href="?contenu=users" </script>';
				exit;
			}
			else
			{
				echo '<script> alert ("L\'utilisateur a bien \351t\351 supprim\351.");</script>';
				echo '<script>document.location.href="?contenu=users" </script>';
				exit;
			}
		break;
	}
}
else
{
	$req_users = $my->req('SELECT * FROM ttre_users WHERE id_user > 1 ORDER BY nom');
	if($my->num($req_users)>0)
	{
		echo '
		<table id="liste_produits">
			<tr class="entete">
				<td>Nom</td>
				<td class="bouton">Modifier</td>
				<td class="bouton">Supprimer</td>
			</tr>
		';
		while($infos_user = $my->arr($req_users))
		{
			echo '
			<tr>
				<td>'.$infos_user['nom'].'</td>
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
	echo '<h2 class="titre_niv2">Ajouter un utilisateur</h2>';
	$form = new formulaire('modele_1','?contenu=users&action=ajouter','','formuser','return valid(this)','sub','txt','','txt_obl','lab_obl','return verifForm()');
	$form->text('Nom','nom','',true);
	$form->text('Identifiant','login','',true);
	$form->password('Mot de passe','mdp1',true);
	//$form->password('V&eacute;rification du mot de passe','mdp2',true);
	$form->afficher('Enregistrer l\'utilisateur');
}	

?>