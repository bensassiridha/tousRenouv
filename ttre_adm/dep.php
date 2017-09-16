<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				if ( !empty($_POST['nom']) && !empty($_POST['code']) )
				{
					$temp = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code="'.$_POST['code'].'" OR departement_nom="'.$_POST['nom'].'" ');
					if ( !$temp )
					{
						$my->req('INSERT INTO ttre_departement_france VALUES("",
										"'.$my->net_input($_POST['code']).'" ,
										"'.$my->net_input($_POST['nom']).'" 
										)');
						rediriger('?contenu=dep&ajouter=ok');
					}
					else
					{
						rediriger('?contenu=dep&action=ajouter&erreur=ok');
					}
				}
				else 
				{
					rediriger('?contenu=dep&action=ajouter&erreur=ok');
				}
			}
			else
			{
				if ( isset($_GET['erreur']) ) $alert='<div id="note" class="error"><p>Nom ou Code existe déjà</p></div>';
				else $alert='<div id="note"></div>';
				
				$form = new formulaire('modele_1','','<h2 class="titre_niv2">Ajouter Département :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<tr><td colspan="2">'.$alert.'</td></tr>');
				$form->text('Nom','nom','',1);
				$form->text('Code','code','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=dep">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				if ( !empty($_POST['nom']) && !empty($_POST['code']) )
				{
					$temp = $my->req_arr('SELECT * FROM ttre_departement_france WHERE ( departement_code LIKE "'.$_POST['code'].'" OR departement_nom LIKE "'.$_POST['nom'].'" ) AND departement_id != '.$_GET['id'].' ');
					if ( !$temp )
					{
						$my->req('UPDATE ttre_departement_france SET
									departement_code		=	"'.$my->net_input($_POST['code']).'" ,
									departement_nom			=	"'.$my->net_input($_POST['nom']).'" 
								WHERE departement_id = '.$_GET['id'].' ');
						rediriger('?contenu=dep&action=modifier&id='.$_GET['id'].'&modifier=ok');
					}
					else
					{
						rediriger('?contenu=dep&action=modifier&id='.$_GET['id'].'&erreur=ok');
					}
				}
				else
				{
					rediriger('?contenu=dep&action=modifier&id='.$_GET['id'].'&erreur=ok');
				}
			}
			else
			{
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Département modifié</p></div>';
				else if ( isset($_GET['erreur']) ) $alert='<div id="note" class="error"><p>Nom ou Code existe déjà</p></div>';
				else $alert='<div id="note"></div>';
				
				$temp = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$_GET['id'].' ');
				
				$form = new formulaire('modele_1','','<h2 class="titre_niv2">Modifier Département :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<tr><td colspan="2">'.$alert.'</td></tr>');
				$form->text('Nom','nom','',1,$temp['departement_nom']);
				$form->text('Code','code','',1,$temp['departement_code']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=dep">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_departement_france WHERE departement_id='.$_GET['id'].' ');
			rediriger('?contenu=dep&supprimer=ok');
			break;	
	}
}
else
{
	echo '<h1>Gérer les département</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Département ajouté.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Département supprimé.</p></div>';
	
	echo '<p>Pour ajouter un autre département, cliquer <a href="?contenu=dep&action=ajouter">ICI</a></p>';
	
	$req = $my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	if ( $my->num($req)>0 )
	{
		echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>ID</td>
							<td>Nom</td>
							<td>Code postal</td>
							<td class="bouton">Modifier</td>
							<td class="bouton">Supprimer</td>
						</tr>
					</thead>
					<tbody> 
			';
		while ( $res=$my->arr($req) )
		{
			$td_suprimer='
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette département ?\')) 
						{window.location=\'?contenu=dep&action=supprimer&id='.$res['departement_id'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
						  ';
			$req_scat=$my->req('SELECT * FROM ttre_villes_france WHERE ville_departement='.$res['departement_code'].' ');
			if ( $my->num($req_scat)>0 ) $td_suprimer='<td class="bouton"></td>';
			
			echo'
				<tr>
					<td class="nom_prod">'.$res['departement_id'].'</td>
					<td class="nom_prod">'.$res['departement_nom'].'</td>
					<td class="nom_prod">'.$res['departement_code'].'</td>
					<td class="bouton">
						<a href="?contenu=dep&action=modifier&id='.$res['departement_id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					'.$td_suprimer.'
				</tr>
				';
		}
		echo'
				</tbody> 
				</table>
			';
	}
	else
	{
		echo '<p>Pas Départements ...</p>';
	}
}
?>
<script type="text/javascript">
$(document).ready(function() 
{
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.nom.value) ) { mes_erreur+='Il faut entrer le champ nom !';this.nom.focus(); }
		else if( !$.trim(this.code.value) ) { mes_erreur+='Il faut entrer le champ code !';this.code.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.nom.value) ) { mes_erreur+='Il faut entrer le champ nom !';this.nom.focus(); }
		else if( !$.trim(this.code.value) ) { mes_erreur+='Il faut entrer le champ code !';this.code.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
});
</script>