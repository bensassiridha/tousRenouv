<?php
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$fichier='';
				$handle = new Upload($_FILES['fichier']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/fichiers/');
					if ($handle->processed)
					{
						$fichier  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$my->req('INSERT INTO ttre_formulaire VALUES("",
										"'.$my->net_input($_POST['titre']).'" ,
										"'.$fichier.'" 
										)');
				rediriger('?contenu=formulaire&ajouter=ok');
			}
			else
			{
				echo '<div id="note"></div>';
				$form = new formulaire('modele_2','?contenu=formulaire&action=ajouter','','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1);
				$form->photo('Fichier','fichier');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=formulaire">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_formulaire WHERE id='.$_GET['id']);
				$fichier=$temp['fichier'];
				$handle = new Upload($_FILES['fichier']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/fichiers/');
					if ($handle->processed)
					{
						@unlink('../upload/fichiers/'.$temp['fichier']);
						$fichier  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$my->req('UPDATE ttre_formulaire SET 
								titre			=	"'.$my->net_input($_POST['titre']).'" ,
								fichier			=	"'.$fichier.'" 
										WHERE id = "'.$_GET['id'].'" ');			
				rediriger('?contenu=formulaire&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) echo '<div id="note" class="valid_box">Ce fichier a bien été modifié.</div>';
				else echo '<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_formulaire WHERE id='.$_GET['id'].' ');
				$form = new formulaire('modele_2','?contenu=formulaire&action=modifier&id='.$_GET['id'].'','','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->vide('<tr><td>Fichier actuelle : </td><td><a href="../upload/fichiers/'.$temp['fichier'].'" target="_blanc">'.$temp['fichier'].'</a></td></tr>');
				$form->photo('Fichier','fichier');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=formulaire">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_formulaire WHERE id='.$_GET['id']);
			@unlink('../upload/fichiers/'.$temp['fichier']);
			$my->req('DELETE FROM ttre_formulaire WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=formulaire&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des fichiers</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="valid_box">Ce fichier a bien été ajouté.</div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="valid_box">Ce fichier a bien été supprimé.</div>';
	echo '<p>Pour ajouter un fichier, cliquer <a href="?contenu=formulaire&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
	if ( $my->num($req)>0 )
	{
		echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>Titre</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
		while ( $res=$my->arr($req) )
		{
			echo'
				<tr>
					<td class="nom_prod">'.$res['titre'].'</td>
					<td class="bouton">
						<a href="?contenu=formulaire&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce fichier ?\')) 
						{window.location=\'?contenu=formulaire&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo '<p>Pas fichiers ...</p>';
	}
}
?>
 <script type="text/javascript"> 
$(document).ready(function() {
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !'; }
		else if( !$.trim(this.fichier.value) ) { mes_erreur+='Il faut choisir un fichier !'; }
		if ( mes_erreur ) { $("#note").addClass("error_box");$("#note").html(mes_erreur); return(false); }
	});
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !'; }
		if ( mes_erreur ) { $("#note").addClass("error_box");$("#note").html(mes_erreur); return(false); }
	});
});
 </script> 






