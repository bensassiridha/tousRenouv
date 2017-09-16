
<?php
echo '<h1>Mot de passe :</h1>';
$rand = substr(mt_rand(),1,5);

$my = new mysql();

			if(!empty($_POST['mdp1']))
			{
				(isset($_POST['mdp1']) && $_POST['mdp1'] = $_POST['mdp2'])?$mdp = md5($_POST['mdp1']): $mdp=$user['password'];
				
				$req_modif_user = $my->req('UPDATE ttre_users SET 
													password = "'.$mdp.'" 
												WHERE id_user = "'.$_SESSION['id_user'].'"');
				echo '<script> alert ("Mot de passe a bien \351t\351 modifi\351.");</script>';
				echo '<script>document.location.href="?contenu=userspwd" </script>';
				exit;
			}
			else
			{		
				$form = new formulaire('modele_1','?contenu=userspwd','','','','sub','txt','','txt_obl','lab_obl','');
				$form->password('Nouveau mot de passe','mdp1');
				$form->password('V&eacute;rification du mot de passe','mdp2');
				$form->afficher('Enregistrer les modifications');
			}

?>
