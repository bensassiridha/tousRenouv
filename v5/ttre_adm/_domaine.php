<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$my->req('INSERT INTO ttre_domaines VALUES("",
										"'.$my->net_input($_POST['titre']).'"
										)');
				rediriger('?contenu=domaine&ajouter=ok');
			}
			else
			{
				echo '<div id="note"></div>';
				$form = new formulaire('modele_1','?contenu=domaine&action=ajouter','<h2 class="titre_niv2">Ajouter domaine :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=domaine">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$my->req('UPDATE ttre_domaines SET 
									titre_domaine		=	"'.$my->net_input($_POST['titre']).'" 
								WHERE id_domaine = '.$_GET['id'].' ');				
				rediriger('?contenu=domaine&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) echo '<div id="note" class="success"><p>Ce domaine a bien été modifié.</p></div>';
				else echo '<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_domaines WHERE id_domaine='.$_GET['id'].' ');
				$form = new formulaire('modele_1','?contenu=domaine&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier domaine :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1,$temp['titre_domaine']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=domaine">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_domaines WHERE id_domaine='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_devis WHERE id_domaine='.$_GET['id'].' ');
			rediriger('?contenu=domaine&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1>Gérer les domaines</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce domaine a bien été ajouté.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce domaine a bien été supprimé.</p></div>';
	echo '<p>Pour ajouter un autre domaine, cliquer <a href="?contenu=domaine&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_domaines ORDER BY titre_domaine ASC ');
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
					<td class="nom_prod">'.$res['titre_domaine'].'</td>
					<td class="bouton">
						<a href="?contenu=domaine&action=modifier&id='.$res['id_domaine'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce domaine ?\')) 
						{window.location=\'?contenu=domaine&action=supprimer&id='.$res['id_domaine'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo '<p>Pas domaines ...</p>';
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
