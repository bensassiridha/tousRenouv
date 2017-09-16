<?php 
session_start();
ini_set('display_errors', 'off');
error_reporting(E_ALL);
require('mysql.php');

$my = new mysql();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../style_boutique.css" /> 
</head>
<body>


<?php 


$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
$detail='';
$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
$batiment = ucfirst(html_entity_decode($temp['batiment']));
$code_postal = $temp['code_postal'];
$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
$pays = ucfirst(html_entity_decode($temp['pays']));

$ress=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id'].' AND statut_achat=-2 ');

$reso = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
$reso_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$reso['ville'].'" ');
$resoo = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['id_client_pro'].' ');
$resoo_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$resoo['ville'].'" ');

$detail.='
	<ul id="compte_details_com" class="livraison">
		<li style="width:20%">
			<h4>Adresse de chantier</h4>
			<dl>
				<dd>Numero et voie : '.$num_voie.'</dd>
				<dd>N° d’appartement : '.$num_appart.'</dd>
				<dd>Bâtiment : '.$batiment.'</dd>
				<dd>'.$code_postal.' '.$ville.'</dd>
				<dd>'.$pays.'</dd>
			</dl>	
		</li>	
		<li style="width:30%">
			<h4>Informations de client particulier</h4>
			<dl>
				<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst($reso['nom']).' '.ucfirst($reso['prenom']).'</dd>
				<dd>'.html_entity_decode($reso['telephone']).' - '.html_entity_decode($reso['email']).'</dd>
				<dd>Numéro et voie : '.html_entity_decode($reso['num_voie']).'</dd>
				<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($reso['num_appart']).'</dd>
				<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($reso['batiment']).'</dd>
				<dd>'.html_entity_decode($reso['code_postal']).' '.html_entity_decode($reso_ville['ville_nom_reel']).'</dd>
				<dd>'.html_entity_decode($reso['pays']).'</dd>
			</dl>
		</li>
		<li style="width:40%;text-align:left;">
			<h4>Informations de client professionnel</h4>
			<dl>
				<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst($resoo['nom']).' '.ucfirst($resoo['prenom']).'</dd>
				<dd>'.html_entity_decode($resoo['telephone']).' - '.html_entity_decode($resoo['email']).'</dd>
				<dd>Numéro et voie : '.html_entity_decode($resoo['num_voie']).'</dd>
				<dd>'.html_entity_decode($resoo['code_postal']).' '.html_entity_decode($resoo_ville['ville_nom_reel']).'</dd>
				<dd>'.html_entity_decode($resoo['pays']).'</dd>
			</dl>
		</li>
														
	</ul>
	<div id="espace_compte">
		<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
			<tr class="entete">
				<td>Désignation</td>
			</tr>
						 ';
$nom_cat='';$nc='';
$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id'].' ORDER BY ordre_categ ASC ');
while ( $ress=$my->arr($reqq) )
{
	if ( $nom_cat!=$ress['titre_categ'] )
	{
		$nom_cat=$ress['titre_categ'];
		$detail.='
					<tr style="background:#FFFF66;">
						<td colspan="6">'.$nom_cat.'</td>
					</tr>
						';
		$nc.=$nom_cat.', ';
	}
	$detail.='
				<tr>
					<td style="text-align:justify;">'.$ress['piece'].'</td>
				</tr>
			';
}
$detail.='
		</table>
	</div>
			';

/*
$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$res['id'].' ');
if ( $my->num($req_f)>0 )
{
	$detail.='<p><br /> Fichiers à télécharger : ';
	while ( $res_f=$my->arr($req_f) )
	{
		$detail.='<a target="_blanc" href="../upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
	}
	$detail.='</p>';
}
*/


echo'
	<div id="espace_compte">'.$detail.'</div>						
	<form name="cheque" method="post">
		<p align="center">
			<input type="button" value="Imprimer" onclick="javascript:window.print();" />
		</p>
	</form>		
	';

?>
</body>
</html>