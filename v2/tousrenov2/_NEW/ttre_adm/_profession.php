<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$my->req('INSERT INTO ttre_professions VALUES("",
										"'.$my->net_input($_POST['titre']).'"
										)');
				rediriger('?contenu=profession&ajouter=ok');
			}
			else
			{
				echo '<div id="note"></div>';
				$form = new formulaire('modele_1','?contenu=profession&action=ajouter','<h2 class="titre_niv2">Ajouter profession :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=profession">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$my->req('UPDATE ttre_professions SET 
									titre_profession		=	"'.$my->net_input($_POST['titre']).'" 
								WHERE id_profession = '.$_GET['id'].' ');				
				rediriger('?contenu=profession&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) echo '<div id="note" class="success"><p>Cette profession a bien été modifiée.</p></div>';
				else echo '<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_professions WHERE id_profession='.$_GET['id'].' ');
				$form = new formulaire('modele_1','?contenu=profession&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier profession :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1,$temp['titre_profession']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=profession">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_professions WHERE id_profession='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_devis WHERE id_profession='.$_GET['id'].' ');
			rediriger('?contenu=profession&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1>Gérer les professions</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Cette profession a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette profession a bien été supprimée.</p></div>';
	echo '<p>Pour ajouter une autre profession, cliquer <a href="?contenu=profession&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_professions ORDER BY titre_profession ASC ');
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
					<td class="nom_prod">'.$res['titre_profession'].'</td>
					<td class="bouton">
						<a href="?contenu=profession&action=modifier&id='.$res['id_profession'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette profession ?\')) 
						{window.location=\'?contenu=profession&action=supprimer&id='.$res['id_profession'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo '<p>Pas professions ...</p>';
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='<p>Il faut entrer le champ Titre !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='<p>Il faut entrer le champ Titre !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
});
</script>
