<?php


$my = new mysql();

if (!empty($_GET['action']))
{
		
	switch($_GET['action'])
	{
		case 'modifier' :
			$req_cat 	=  $my->req('SELECT * FROM entreprise_langue WHERE id="'.$_GET['id'].'"');
	$cat		=  $my->arr($req_cat);

			if(!empty($_POST['titre']))
			{
			$nom_fichier 	= suppr_speciaux($_POST['titre']);
					if($_FILES['photo']['name']!="")
					{
					$rand = substr(mt_rand(),1,5);
					$photos 		= uploadImg('photo', 'vin_'.$nom_fichier.$rand, 640, '', 'photos/');
					$thumbs   		= uploadImg('photo', 'thumb_'.$nom_fichier.$rand, 100, '', 'photos/');

					}
				else
					{
					$photos=$cat["photo"];
					$thumbs=$cat["thumb"];
					}
			$req_ajout_cat = $my->req("update entreprise_langue
			set titre='".$_POST['titre']."', description='".$_POST["description"]."',photo='".$photos."', thumb='".$thumbs."' where id=".$_GET["id"]);
			if(!$req_ajout_cat)
			{
				echo '<script> alert ("Erreur de dialogue avec la base de données.");</script>';
			}
			else
			{
				echo '<script> alert ("La langue a bien \351t\351 modifiée.");</script>';
				echo '<script>document.location.href="?contenu=gestion_langue" </script>';
				exit;
			}
			}
			else
			{
			if (isset($_GET['supprimg']))
				{
					@unlink('photos/'.$cat['photo']);	
					@unlink('photos/'.$cat['thumb']);
					$my->req('UPDATE entreprise_langue SET photo= "",thumb="" WHERE id = "'.$cat['id'].'"');
					echo '<script>alert("La photo a bien \351t\351 supprim\351e.");
					window.location="?contenu=gestion_langue&action=modifier&id='.$cat['id'].'"</script>';					
				}	
				
				#				# formulaire de modification
				
				$form = new formulaire('modele_1','?contenu=gestion_langue&action=modifier&id='.$_GET['id'],'<h2 class="titre_niv2">Modifier '.$cat['titre'].' :</h2>','','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1,$cat['titre']);
				$form->textarea('Description','description',$cat['description']);
				
				//$form->check('Affichée la langue sur le site','affich',1,'',$cat['affich'],'');
				if(!empty($cat['photo']))
				{
					$form->vide('<tr>
					<td><label>Photo actuelle : </label></td>
					<td><img src="photos/'.$cat['thumb'].'" />
					<br>
					<a class="lien_1" href="#" onclick="
					if(confirm(\'Etes vous certain de vouloir supprimer cette photo ?\')) 
               		{window.location=\'?contenu=gestion_langue&action=modifier&id='.$cat['id'].'&supprimg=1\'}" class="lien_1">Supprimer</a>
					</td>
					</tr>');
					$form->photo('Remplacer la photo ','photo');
				}
				else
				{				
					$form->photo('Photo ','photo');
				}
				$form->afficher('Enregistrer les modifications');
			}
		break;
		case 'supprimer' :
			
			# supprimer produits
			$req_del_stickers = $my->req('DELETE FROM entreprise_langue WHERE id="'.$_GET['id'].'"');
			if(!$req_del_stickers)
			{
				echo '<script> alert ("Erreur de dialogue avec la base de donnÃ©es.");</script>';
				echo '<script>document.location.href="?contenu=gestion_langue" </script>';
				exit;
			}
			else
			{
				echo '<script> alert ("La langue a bien été supprimée.");</script>';
				echo '<script>document.location.href="?contenu=gestion_langue" </script>';
				exit;
			}
		break;
		
		case 'ajouter':
		if(!empty($_POST['langue']))
{	
		if($_FILES['photo']['name']!="")
					{
					$rand = substr(mt_rand(),1,5);
					$photos 		= uploadImg('photo', 'langue_'.$rand, 640, '', 'photos/');
					$thumbs   		= uploadImg('photo', 'thumb_'.$rand, 100, '', 'photos/thumbs');

					}
				else
					{
					$photos="";
					
					}	
	$req_ajout_cat = $my->req("INSERT INTO entreprise_langue
	VALUES('','".$_POST['langue']."','".$_POST['prefix']."','".$photos."')");
	if(!$req_ajout_cat)
	{
		echo '<script> alert ("Erreur de dialogue avec la base de données.");</script>';
	}
	else
	{
	$my->req('ALTER TABLE `entreprise_news` ADD `titre_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `description_fr` ,
ADD `description_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `titre_'.$_POST['prefix'].'`');
	$my->req('ALTER TABLE `entreprise_partenaire` ADD `nom_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `description_fr` ,
ADD `description_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `nom_'.$_POST['prefix'].'`');
$my->req('ALTER TABLE `entreprise_agenda` ADD `titre_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `description_fr` ,
ADD `description_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `titre_'.$_POST['prefix'].'`');
	$my->req('ALTER TABLE `entreprise_activite` ADD `titre_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `description_fr` ,
ADD `description_'.$_POST['prefix'].'` TEXT NOT NULL AFTER `titre_'.$_POST['prefix'].'`');
	$my->req('ALTER TABLE `entreprise_gouvernorat` ADD `titre_'.$_POST['prefix'].'` INT NOT NULL AFTER `titre_fr`' );
	
		/*echo '<script> alert ("La langue a bien \351t\351 enregistr\351e.");</script>';
		echo '<script>document.location.href="?contenu=gestion_langue" </script>';
		exit;*/
	}
}
else
{
	/*---	Création du formulaire	---*/
	$form = new formulaire('modele_1','?contenu=gestion_langue&action=ajouter','','','','sub','txt','','txt_obl','lab_obl');
	$form->text('language','langue','',1);
	$form->text('extention','prefix','');
	$form->photo('Photo ','photo');
	//$form->check('Affichée la langue sur le site','affich',1,'','','');
	$form->afficher('Enregistrer');
}	
		break;
	}
}
else
{
	echo '<h1>G&eacute;rer les language</h1>';

	echo '<h2><a href="?contenu=gestion_langue&action=ajouter">ajouter</a></h2>';
	echo '
		<table id="liste_produits">
			<tr class="entete">
				<td>Titre</td>
				<td >Photo</td>
				<td class="bouton">Modifier</td>
			
					</tr>
		';
		
			$req_cat = $my->req('SELECT * FROM entreprise_langue');
			while($infos_cat = $my->arr($req_cat))
			{
				echo '
				<tr>
					<td class="nom_prod">'.$infos_cat['nom'].'</td>
					<td ><img src="photos/thumbs/'.$infos_cat['photo'].'" width="100" height="100" /></td>
					<td class="bouton">
					<a href="?contenu=gestion_langue&action=modifier&id='.$infos_cat['id'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					
				</tr>
				';				
			}
		echo '</table>';
}	

?>