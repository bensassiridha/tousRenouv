<?php
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$my->req('UPDATE ttre_coordonnees SET 
								val1			=	"'.$my->net_input($_POST['valeur']).'" 
										WHERE id = "'.$_GET['id'].'" ');			
				rediriger('?contenu=coordonnees&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) echo '<div id="note" class="valid_box">Cette coordonnée a bien été modifiée.</div>';
				else echo '<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_coordonnees WHERE id='.$_GET['id'].' ');
				$form = new formulaire('modele_2','?contenu=coordonnees&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier coordonnée :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->text($temp['titre'],'valeur','',1,$temp['val1']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=coordonnees">Retour</a></p>';
			}
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des coordonnées</h1>';
	$req = $my->req('SELECT * FROM ttre_coordonnees ');
	echo'
		<table id="liste_produits">
			<tr class="entete">
				<td>Titre</td>
				<td class="bouton">Modifier</td>
			</tr>
		';
	while ( $res=$my->arr($req) )
	{
		echo'
			<tr>
				<td class="nom_prod">'.$res['titre'].'</td>
				<td class="bouton">
					<a href="?contenu=coordonnees&action=modifier&id='.$res['id'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
			</tr>
			';
	}
	echo'</table>';
}
?>






