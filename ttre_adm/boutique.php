<?php
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'modifier' :
			if( $_GET['id']==1 ) // Paypal
			{
				if ( isset($_POST['modifier']) )
				{
					$my->req('UPDATE ttre_module_payement SET 
									val1			=	"'.$my->net_input($_POST['email']).'" 
											WHERE id = "'.$_GET['id'].'" ');			
					rediriger('?contenu=boutique&action=modifier&id='.$_GET['id'].'&modifier=ok');
				}
				else
				{
					if ( isset($_GET['modifier']) ) echo '<div id="note" class="valid_box">Ce module a bien été modifié.</div>';
					else echo '<div id="note"></div>';
					$temp = $my->req_arr('SELECT * FROM ttre_module_payement WHERE id='.$_GET['id'].' ');
					$form = new formulaire('modele_2','?contenu=boutique&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier module Paypal :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
					$form->text('Email','email','',1,$temp['val1']);
					$form->afficher('Modifier','modifier');
					echo '<p><a href="?contenu=boutique">Retour</a></p>';
				}
			}
			elseif( $_GET['id']==2 ) // Virement bancaire
			{
				if ( isset($_POST['modifier']) )
				{
					$my->req('UPDATE ttre_module_payement SET 
									val1			=	"'.$my->net_input($_POST['iban']).'" ,
									val2			=	"'.$my->net_input($_POST['ordree']).'" , 
									val3			=	"'.$my->net_input($_POST['swift']).'"  
											WHERE id = "'.$_GET['id'].'" ');			
					rediriger('?contenu=boutique&action=modifier&id='.$_GET['id'].'&modifier=ok');
				}
				else
				{
					if ( isset($_GET['modifier']) ) echo '<div id="note" class="valid_box">Ce module a bien été modifié.</div>';
					else echo '<div id="note"></div>';
					$temp = $my->req_arr('SELECT * FROM ttre_module_payement WHERE id='.$_GET['id'].' ');
					$form = new formulaire('modele_2','?contenu=boutique&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier module Virement bancaire :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
					$form->text('IBAN','iban','',1,$temp['val1']);
					$form->text('Ordre','ordree','',1,$temp['val2']);
					$form->text('SWIFT','swift','',1,$temp['val3']);
					$form->afficher('Modifier','modifier');
					echo '<p><a href="?contenu=boutique">Retour</a></p>';
				}
			}
			elseif( $_GET['id']==3 ) // Chéque
			{
				if ( isset($_POST['modifier']) )
				{
					$my->req('UPDATE ttre_module_payement SET 
									val1			=	"'.$my->net_input($_POST['ordree']).'" ,
									val2			=	"'.$my->net_input($_POST['adresse']).'" 
											WHERE id = "'.$_GET['id'].'" ');			
					rediriger('?contenu=boutique&action=modifier&id='.$_GET['id'].'&modifier=ok');
				}
				else
				{
					if ( isset($_GET['modifier']) ) echo '<div id="note" class="valid_box">Ce module a bien été modifié.</div>';
					else echo '<div id="note"></div>';
					$temp = $my->req_arr('SELECT * FROM ttre_module_payement WHERE id='.$_GET['id'].' ');
					$form = new formulaire('modele_2','?contenu=boutique&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier module Chéque :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
					$form->text('Ordre','ordree','',1,$temp['val1']);
					$form->text('Adresse','adresse','',1,$temp['val2']);
					$form->afficher('Modifier','modifier');
					echo '<p><a href="?contenu=boutique">Retour</a></p>';
				}
			}
			break;
		case 'valid' :
			$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id="'.$_GET['id'].'"');
			$my->req('UPDATE ttre_module_payement SET statut="'.!$temp['statut'].'" WHERE id="'.$_GET['id'].'"');
			rediriger('?contenu=boutique&modifier=ok');
			exit;
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des modules</h1>';
	if ( isset($_GET['modifier']) ) echo'<div class="success"><p>Le statut de ce client a bien été modifié.</p></div>';
	$req = $my->req('SELECT * FROM ttre_module_payement ');
	echo'
		<table id="liste_produits">
			<tr class="entete">
				<td>Titre</td>
				<td class="bouton">Statut</td>
				<td class="bouton">Modifier</td>
			</tr>
		';
	while ( $res=$my->arr($req) )
	{
		if ( $res['statut']==1 )
			$a_valid = '<a href="?contenu=boutique&action=valid&id='.$res['id'].'" title="Module affiché sur le site"><img src="img/interface/icone_ok.jpeg" alt="Module affiché sur le site" border="0" /></a>';
		else
			$a_valid = '<a href="?contenu=boutique&action=valid&id='.$res['id'].'" title="Module pas affiché sur le site"><img src="img/interface/icone_nok.jpeg" alt="Module pas affiché sur le site" border="0" /></a>';
			
		echo'
			<tr>
				<td class="nom_prod">'.$res['titre'].'</td>
				<td class="bouton">'.$a_valid.'</td>
				<td class="bouton">
					<a href="?contenu=boutique&action=modifier&id='.$res['id'].'">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
			</tr>
			';
	}
	echo'</table>';
}
?>






