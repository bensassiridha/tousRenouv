<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'cat' :
			if ( isset($_GET['actionCat']) )
			{
				switch ( $_GET['actionCat'] )
				{
					case 'ajouter' :
						if ( isset($_POST['ajouter']) )
						{
							$my->req('INSERT INTO ttre_categories VALUES("",
													"0" ,
													"'.$my->net_input($_POST['titre']).'",
													"0"
													)');
							rediriger('?contenu=categorie&ajouterCat=ok');
						}
						else
						{
							echo '<div id="note"></div>';
							$form = new formulaire('modele_1','?contenu=categorie&action=cat&actionCat=ajouter','<h2 class="titre_niv2">Ajouter catégorie :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
							$form->text('Titre','titre','',1);
							$form->afficher('Enregistrer','ajouter');
							echo '<p><a href="?contenu=categorie">Retour</a></p>';
						}
						break;
					case 'modifier' :
						if ( isset($_POST['modifier']) )
						{
							$my->req('UPDATE ttre_categories SET 
												titre_categorie		=	"'.$my->net_input($_POST['titre']).'" 
											WHERE id_categorie = '.$_GET['id'].' ');				
							rediriger('?contenu=categorie&action=cat&actionCat=modifier&id='.$_GET['id'].'&modifier=ok');
						}
						else
						{
							if ( isset($_GET['modifier']) ) echo '<div id="note" class="success"><p>Cette catégorie a bien été modifiée.</p></div>';
							else echo '<div id="note"></div>';
							$temp = $my->req_arr('SELECT * FROM ttre_categories WHERE id_categorie='.$_GET['id'].' ');
							$form = new formulaire('modele_1','?contenu=categorie&action=cat&actionCat=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier catégorie :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
							$form->text('Titre','titre','',1,$temp['titre_categorie']);
							$form->afficher('Modifier','modifier');
							echo '<p><a href="?contenu=categorie">Retour</a></p>';
						}
						break;
					case 'supprimer' :
						$my->req('DELETE FROM ttre_categories WHERE id_categorie='.$_GET['id'].' ');
						rediriger('?contenu=categorie&supprimerCat=ok');
						break;
				}
			}
			break;
		case 'scat' :
			if ( isset($_GET['actionScat']) )
			{
				switch ( $_GET['actionScat'] )
				{
					case 'ajouter' :
						if ( isset($_POST['ajouter']) )
						{
							$my->req('INSERT INTO ttre_categories VALUES("",
													"'.$_GET['idCat'].'" ,
													"'.$my->net_input($_POST['titre']).'",
													"0"
													)');
							rediriger('?contenu=categorie&ajouterScat=ok');
						}
						else
						{
							echo '<div id="note"></div>';
							$form = new formulaire('modele_1','?contenu=categorie&action=scat&actionScat=ajouter&idCat='.$_GET['idCat'].'','<h2 class="titre_niv2">Ajouter sous catégorie :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
							$form->text('Titre','titre','',1);
							$form->afficher('Enregistrer','ajouter');
							echo '<p><a href="?contenu=categorie">Retour</a></p>';
						}
						break;
					case 'modifier' :
						if ( isset($_POST['modifier']) )
						{
							$my->req('UPDATE ttre_categories SET 
												titre_categorie		=	"'.$my->net_input($_POST['titre']).'" 
											WHERE id_categorie = '.$_GET['id'].' ');				
							rediriger('?contenu=categorie&action=scat&actionScat=modifier&id='.$_GET['id'].'&modifier=ok');
						}
						else
						{
							if ( isset($_GET['modifier']) ) echo '<div id="note" class="success"><p>Cette sous catégorie a bien été modifiée.</p></div>';
							else echo '<div id="note"></div>';
							$temp = $my->req_arr('SELECT * FROM ttre_categories WHERE id_categorie='.$_GET['id'].' ');
							$form = new formulaire('modele_1','?contenu=categorie&action=scat&actionScat=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier sous catégorie :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
							$form->text('Titre','titre','',1,$temp['titre_categorie']);
							$form->afficher('Modifier','modifier');
							echo '<p><a href="?contenu=categorie">Retour</a></p>';
						}
						break;
					case 'supprimer' :
						$my->req('DELETE FROM ttre_categories WHERE id_categorie='.$_GET['id'].' ');
						$my->req('DELETE FROM ttre_questions_prix WHERE id_categorie='.$_GET['id'].' ');
						rediriger('?contenu=categorie&supprimerScat=ok');
						break;
				}
			}
			break;
	}
}
else
{
	echo '<h1>Gérer les catégories</h1>';
	if ( isset($_GET['ajouterCat']) ) echo '<div class="success"><p>Cette catégorie a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['ajouterScat']) ) echo '<div class="success"><p>Cette sous catégorie a bien été ajoutée.</p></div>';
	elseif ( isset($_GET['supprimerCat']) ) echo '<div class="success"><p>Cette catégorie a bien été supprimée.</p></div>';
	elseif ( isset($_GET['supprimerScat']) ) echo '<div class="success"><p>Cette sous catégorie a bien été supprimée.</p></div>';
	echo '<p>Pour ajouter une autre catégorie, cliquer <a href="?contenu=categorie&action=cat&actionCat=ajouter">ICI</a></p>';
	$req_cat = $my->req('SELECT * FROM ttre_categories WHERE parent_categorie=0 ORDER BY titre_categorie ASC ');
	if ( $my->num($req_cat)>0 )
	{
		while ( $res_cat=$my->arr($req_cat) )
		{
			/*$td_supprimer='
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette catégorie ?\')) 
							{window.location=\'?contenu=categorie&action=cat&actionCat=supprimer&id='.$res_cat['id_categorie'].'\'}" title="Supprimer">
							<img src="img/interface/icone_delete.png" alt="Supprimer" border="0" /></a>
						</td>
						  ';*/
			$td_supprimer='<td class="bouton"></td>';
			$tr_scat='';
			$req_scat = $my->req('SELECT * FROM ttre_categories WHERE parent_categorie='.$res_cat['id_categorie'].' ORDER BY ordre ASC ');
			if ( $my->num($req_scat)>0 )
			{
				$td_supprimer='<td class="bouton"></td>';
				while ( $res_scat=$my->arr($req_scat) )
				{
					$tr_scat.='
						<tr>
							<td class="nom_prod">'.$res_scat['titre_categorie'].'</td>
							<td class="bouton">
								<a href="?contenu=categorie&action=scat&actionScat=modifier&id='.$res_scat['id_categorie'].'">
								<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
							</td>
							<td class="bouton">
								<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette sous catégorie ?\')) 
								{window.location=\'?contenu=categorie&action=scat&actionScat=supprimer&id='.$res_scat['id_categorie'].'\'}" title="Supprimer">
								<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
							</td>
						</tr>
						';
				}
			}
			$td_modifier='<td class="bouton">
							<a href="?contenu=categorie&action=cat&actionCat=modifier&id='.$res_cat['id_categorie'].'">
							<img src="img/interface/icone_edit.png" alt="Modifier"/></a>
						</td>';
			$td_modifier='<td class="bouton"></td>';
			echo'
				<table id="liste_produits">
					<tr class="entete">
						<td>'.$res_cat['titre_categorie'].'</td>
						'.$td_modifier.'
						'.$td_supprimer.'
					</tr>
					'.$tr_scat.'
					<tr>
						<td style="border:0;"></td>
						<td colspan="2" style="text-align:center;"><a href="?contenu=categorie&action=scat&actionScat=ajouter&idCat='.$res_cat['id_categorie'].'">Ajouter une sous catégorie</a></td>
					</tr>
				</table>
				<br />
				';
		}
	}
	else
	{
		echo '<p>Pas catégories ...</p>';
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
