<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$my->req('INSERT INTO ttre_realisations VALUES("",
										"'.$my->net_input($_POST['titre']).'"
										)');
				rediriger('?contenu=realisation&ajouter=ok');
			}
			else
			{
				echo '<div id="note"></div>';
				$form = new formulaire('modele_1','?contenu=realisation&action=ajouter','<h2 class="titre_niv2">Ajouter réalisation :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=realisation">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$my->req('UPDATE ttre_realisations SET 
									titre_realisation		=	"'.$my->net_input($_POST['titre']).'" 
								WHERE id_realisation = '.$_GET['id'].' ');				
				rediriger('?contenu=realisation&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) echo '<div id="note" class="success"><p>Cette réalisation a bien été modifiée.</p></div>';
				else echo '<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_realisations WHERE id_realisation='.$_GET['id'].' ');
				$form = new formulaire('modele_1','?contenu=realisation&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier réalisation :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->text('Titre','titre','',1,$temp['titre_realisation']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=realisation">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_realisations WHERE id_realisation='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_devis WHERE id_realisation='.$_GET['id'].' ');
			rediriger('?contenu=realisation&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1>Gérer les réalisations</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Cette réalisation a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette réalisation a bien été supprimée.</p></div>';
	echo '<p>Pour ajouter une autre réalisation, cliquer <a href="?contenu=realisation&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_realisations ORDER BY titre_realisation ASC ');
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
					<td class="nom_prod">'.$res['titre_realisation'].'</td>
					<td class="bouton">
						<a href="?contenu=realisation&action=modifier&id='.$res['id_realisation'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette réalisation ?\')) 
						{window.location=\'?contenu=realisation&action=supprimer&id='.$res['id_realisation'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo '<p>Pas réalisations ...</p>';
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
