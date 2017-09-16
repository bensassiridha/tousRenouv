<script type="text/javascript" src="ordre/ui.core.js"></script>
<script type="text/javascript" src="ordre/ui.sortable.js"></script>
<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$ordre= $my->req_obj('SELECT max( ordre ) AS tot FROM ttre_categories');
				if ($ordre) $ordre = $ordre->tot; else $ordre=0;
				
				$my->req('INSERT INTO ttre_categories VALUES("",
										"'.$my->net_input($_POST['idcat']).'" ,
										"'.$my->net_input($_POST['titre']).'",
										"",
										"'.($ordre+1).'"
										)');
				rediriger('?contenu=partie&cat='.$_POST['idcat'].'&ajouterPart=ok');
			}
			else
			{
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
				while ( $res=$my->arr($req) )
				{
					$reqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$res['id'].' ORDER BY ordre ASC ');
					while ( $ress=$my->arr($reqq) ) $tabCat[$res['titre']][$ress['id']]=$ress['titre'];
				}
				
				$form = new formulaire('modele_1','?contenu=partie&action=ajouter','<h2 class="titre_niv2">Ajouter partie :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->selectGroup('Catégorie','idcat',$tabCat,'',1);
				$form->text('Titre','titre','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=partie">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$my->req('UPDATE ttre_categories SET 
									parent		=	"'.$my->net_input($_POST['idcat']).'" ,
									titre		=	"'.$my->net_input($_POST['titre']).'" 
								WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=partie&action=modifier&cat='.$_GET['cat'].'&&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Cette partie a bien été modifiée.</p></div>';
				else $alert='<div id="note"></div>';
				
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
				while ( $res=$my->arr($req) )
				{
					$reqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$res['id'].' ORDER BY ordre ASC ');
					while ( $ress=$my->arr($reqq) ) $tabCat[$res['titre']][$ress['id']]=$ress['titre'];
				}
				
				$temp = $my->req_arr('SELECT * FROM ttre_categories WHERE id='.$_GET['id'].' ');
				
				$form = new formulaire('modele_1','?contenu=partie&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier catégorie :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->selectGroup('Catégorie','idcat',$tabCat,$temp['parent'],'',1);
				$form->text('Titre','titre','',1,$temp['titre']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=partie&cat='.$_GET['cat'].'">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_categories WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=partie&cat='.$_GET['cat'].'&supprimerPart=ok');
			break;	
		case 'ordre' :
			foreach ($_POST['ordre'] as $key=>$value)
				$my->req('UPDATE ttre_categories SET ordre="'.$my->net($key).'" WHERE id='.$my->net($value));
			rediriger('?contenu=partie&cat='.$_POST['idcat'].'&ordre=ok');
			break;
	}
}
else
{
	$req=$my->req('SELECT * FROM ttre_categories WHERE parent!=0 ORDER BY ordre ASC ');
	if ( $my->num($req)>0 )
	{
		echo '<h1>Gérer les parties</h1>';
		if ( isset($_GET['ordre']) ) echo '<div class="success"><p>L\'ordre a bien été modifié.</p></div>';
		elseif ( isset($_GET['ajouterPart']) ) echo '<div class="success"><p>La partie a bien été ajoutée.</p></div>';
		elseif ( isset($_GET['supprimerPart']) ) echo '<div class="success"><p>La partie a bien été supprimée.</p></div>';
		echo '<p>Pour ajouter une autre partie, cliquer <a href="?contenu=partie&action=ajouter">ICI</a></p>';
		
		$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');$i=1;
		while ( $res=$my->arr($req) )
		{
			$reqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$res['id'].' ORDER BY ordre ASC ');
			while ( $ress=$my->arr($reqq) )
			{	
				$tabCat[$res['titre']][$ress['id']]=$ress['titre'];
				if ( $i==1 ) $parent=$ress['id'];
				$i++;
			}
		}
		if ( isset($_POST['cat']) ) $parent=$_POST['cat'];
		elseif ( isset($_GET['cat']) ) $parent=$_GET['cat'];
		
		$form = new formulaire('modele_1','?contenu=partie','','','','sub','txt','','txt_obl','lab_obl');
		$form->selectGroup('Rechercher par catégorie','cat',$tabCat,$parent,'form.submit()');
		$form->afficher_simple();
		
		$req = $my->req('SELECT * FROM ttre_categories WHERE parent='.$parent.' ORDER BY ordre ASC ');
		if ( $my->num($req)>0 )
		{
			echo'
				<form method="POST" action="?contenu=partie&action=ordre" >
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Titre</td>
								<td class="bouton">Modifier</td>
								<td class="bouton">Supprimer</td>
								<td class="bouton">Ordre</td>
							</tr>
						</thead>
						<tbody> 
				';
			while ( $res=$my->arr($req) )
			{
				$td_suprimer='
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette partie?\')) 
							{window.location=\'?contenu=partie&action=supprimer&cat='.$parent.'&id='.$res['id'].'\'}" title="Supprimer">
							<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
						</td>
							  ';
				$req_quest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$res['id'].' ');
				if ( $my->num($req_quest)>0 ) $td_suprimer='<td class="bouton"></td>';
				echo'
					<tr>
						<td class="nom_prod">'.$res['titre'].'</td>
						<td class="bouton">
							<a href="?contenu=partie&action=modifier&cat='.$parent.'&id='.$res['id'].'">
							<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
						</td>
						'.$td_suprimer.'
						<td class="bouton" style="cursor: move;">
							<img src="ordre/cursor_move.gif" alt="Mover" border="0" />
							<input type="hidden" name="ordre[]" value="' . $res ['id'] . '" />
						</td>	
					</tr>
					';
			}
			echo'
					</tbody> 
					</table>
					<input id="idcat" name="idcat" value="'.$parent.'" type="hidden" />
					<input type="submit"  value="Modifier l\'ordre" style="margin:10px 0 0 250px;"/>
				</form>
				';
		}
		else
		{
			echo '<p>Pas parties ...</p>';
		}
	}
	else
	{
		echo '<p>Il faut ajouter des sous catégories ...</p>';
	}
}
?>
<script type="text/javascript">
$(document).ready(function() 
{
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
});

$(function() {

	// Return a helper with preserved width of cells
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};

	$("#liste_produits tbody tr").css('background-color','#FFF');
	$("#liste_produits tbody").sortable({
		helper: fixHelper, placeholder: 'ui-state-highlight'  
	}).disableSelection();
   
});

</script>