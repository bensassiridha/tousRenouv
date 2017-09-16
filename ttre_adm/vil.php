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
					$temp = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal="'.$_POST['code'].'" AND ville_nom_reel="'.$_POST['nom'].'" ');
					if ( !$temp )
					{
						$my->req('INSERT INTO ttre_villes_france VALUES("",
										"'.$my->net_input($_POST['dep']).'" ,
										"'.$my->net_input($_POST['nom']).'" ,
										"'.$my->net_input($_POST['code']).'" 
										)');
						rediriger('?contenu=vil&ajouter=ok');
					}
					else
					{
						rediriger('?contenu=vil&action=ajouter&erreur=ok');
					}
				}
				else
				{
					rediriger('?contenu=vil&action=ajouter&erreur=ok');
				}
			}
			else
			{
				if ( isset($_GET['erreur']) ) $alert='<div id="note" class="error"><p>Nom ou Code existe déjà</p></div>';
				else $alert='<div id="note"></div>';
				
				$req=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
				while ( $res=$my->arr($req) ) $tabDep[$res['departement_code']]=$res['departement_nom'];
				
				$form = new formulaire('modele_1','','<h2 class="titre_niv2">Ajouter Ville :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<tr><td colspan="2">'.$alert.'</td></tr>');
				$form->select('Département','dep',$tabDep,'',1);
				$form->text('Nom','nom','',1);
				$form->text('Code','code','',1);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=vil&depart='.$_GET['depart'].'">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				if ( !empty($_POST['nom']) && !empty($_POST['code']) )
				{
					$temp = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ( ville_code_postal="'.$_POST['code'].'" AND ville_nom_reel="'.$_POST['nom'].'" ) AND ville_id != '.$_GET['id'].' ');
					if ( !$temp )
					{
						$my->req('UPDATE ttre_villes_france SET
									ville_departement		=	"'.$my->net_input($_POST['dep']).'" ,
									ville_code_postal		=	"'.$my->net_input($_POST['code']).'" ,
									ville_nom_reel			=	"'.$my->net_input($_POST['nom']).'"
								WHERE ville_id = '.$_GET['id'].' ');
						rediriger('?contenu=vil&action=modifier&depart='.$_GET['depart'].'&id='.$_GET['id'].'&modifier=ok');
					}
					else
					{
						rediriger('?contenu=vil&action=modifier&depart='.$_GET['depart'].'&id='.$_GET['id'].'&erreur=ok');
					}
				}
				else
				{
					rediriger('?contenu=vil&action=modifier&depart='.$_GET['depart'].'&id='.$_GET['id'].'&erreur=ok');
				}
			}
			else
			{
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Ville modifiée</p></div>';
				else if ( isset($_GET['erreur']) ) $alert='<div id="note" class="error"><p>Nom ou Code existe déjà</p></div>';
				else $alert='<div id="note"></div>';
				
				$temp = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$_GET['id'].' ');
				
				$req=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
				while ( $res=$my->arr($req) ) $tabDep[$res['departement_code']]=$res['departement_nom'];
				
				$form = new formulaire('modele_1','','<h2 class="titre_niv2">Modifier Ville :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<tr><td colspan="2">'.$alert.'</td></tr>');
				$form->select_cu('Département','dep',$tabDep,$temp['ville_departement'],'',1);
				$form->text('Nom','nom','',1,$temp['ville_nom_reel']);
				$form->text('Code','code','',1,$temp['ville_code_postal']);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=vil&depart='.$_GET['depart'].'">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_villes_france WHERE ville_id='.$_GET['id'].' ');
			rediriger('?contenu=vil&depart='.$_GET['depart'].'&supprimer=ok');
			break;	
	}
}
else
{
	$req=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	if ( $my->num($req)>0 )
	{
		echo '<h1>Gérer les villes</h1>';
		if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ville ajoutée.</p></div>';
		elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ville supprimée.</p></div>';
		
		echo '<p>Pour ajouter une autre ville, cliquer <a href="?contenu=vil&action=ajouter">ICI</a></p>';
		
		while ( $res=$my->arr($req) ) $tabDep[$res['departement_code']]=$res['departement_nom'];
		
		$temp=$my->req_arr('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');$depart=$temp['departement_code'];
		if ( isset($_POST['depart']) ) $depart=$_POST['depart'];
		elseif ( isset($_GET['depart']) ) $depart=$_GET['depart'];
		
		$form = new formulaire('modele_1','?contenu=vil','','','','sub','txt','','txt_obl','lab_obl');
		$form->select_cu('Rechercher par département','depart',$tabDep,$depart,'form.submit()');
		$form->afficher_simple();
		
		$req = $my->req('SELECT * FROM ttre_villes_france WHERE ville_departement='.$depart.' ORDER BY ville_nom_reel ASC ');
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
				echo'
					<tr>
						<td class="nom_prod">'.$res['ville_id'].'</td>
						<td class="nom_prod">'.$res['ville_nom_reel'].'</td>
						<td class="nom_prod">'.$res['ville_code_postal'].'</td>
						<td class="bouton">
							<a href="?contenu=vil&action=modifier&depart='.$depart.'&id='.$res['ville_id'].'">
							<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette ville ?\')) 
							{window.location=\'?contenu=vil&action=supprimer&depart='.$depart.'&id='.$res['ville_id'].'\'}" title="Supprimer">
							<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
						</td>
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
			echo '<p>Pas villes ...</p>';
		}
	}
	else
	{
		echo '<p>Il faut ajouter des départements ...</p>';
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