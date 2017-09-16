<link rel="stylesheet" href="style_boutique.css" type="text/css" media="screen">
<?php
require_once 'inc/session.php';

if ( !isset($_GET['suite']) )
{
	$infos_devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
	$total=number_format($infos_devis['total_net']+$infos_devis['total_tva']+$infos_devis['frais_port'],2);
	$detail='
							<ul id="compte_details_com">
								<li>
									<h4>Informations générales</h4>
									<dl>
										<dt>Date Devis : </dt>
										<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
										<dt>Référence : </dt>
										<dd>'.$infos_devis['reference'].'</dd>
									</dl>
								</li>
							';
	$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$infos_devis['id_adresse'].' ');
	$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
	$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
	$batiment = ucfirst(html_entity_decode($temp['batiment']));
	$code_postal = $temp['code_postal'];
	$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
	$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
	$pays = ucfirst(html_entity_decode($temp['pays']));
	$detail.='
							<li>
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>'.$code_postal.' '.$ville.'</dd>
									<dd>'.$pays.'</dd>
								</dl>
							</li>
						</ul>';
}
else 
{
	$infos_devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
	$tempp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
	$total=number_format($infos_devis['total_net']+$infos_devis['total_tva']+$infos_devis['frais_port'],2);
	$detail='
						<ul id="compte_details_com">
							<li>
								<h4>Informations générales</h4>
								<dl>
									<dt>Date Devis : </dt>
									<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
									<dt>Date Payement : </dt>
									<dd>'.date("d-m-Y",$tempp['date_payement']).'</dd>
									<dt>Mode de paiement : </dt>
									<dd>'.$tempp['type_payement'].'</dd>
									<dt>Référence : </dt>
									<dd>'.$infos_devis['reference'].'</dd>
								</dl>
							</li>
						';
	$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$infos_devis['id_adresse'].' ');
	$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
	$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
	$batiment = ucfirst(html_entity_decode($temp['batiment']));
	$code_postal = $temp['code_postal'];
	$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
	$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
	$pays = ucfirst(html_entity_decode($temp['pays']));
	$detail.='
						<li>
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N° d’appartement : '.$num_appart.'</dd>
								<dd>Bâtiment : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>
						</li>
						';
	$res = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$infos_devis['id_client'].' ');
	$detail.='
						<li>
							<h4>Information de client</h4>
							<dl>
								<dd>'.ucfirst(html_entity_decode($res['civ'])).' '.ucfirst(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</dd>
								<dd>'.html_entity_decode($res['telephone']).' - '.html_entity_decode($res['email']).'</dd>
								<dd>Numéro et voie : '.html_entity_decode($res['num_voie']).'</dd>
								<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($res['num_appart']).'</dd>
								<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($res['batiment']).'</dd>
								<dd>'.html_entity_decode($res['code_postal']).' '.html_entity_decode($res_ville['ville_nom_reel']).'</dd>
								<dd>'.html_entity_decode($res['pays']).'</dd>
							</dl>
						</li>
					</ul>';	
}
$detail.='
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Pièce</td>
								<td>Désignation</td>
								<td>P.U</td>
								<td>Qte</td>
								<td>Unité</td>
								<td>Total</td>
							</tr>
						';
$nom_cat='';
$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
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
	}
	$detail.='
							<tr>
								<td>'.$ress['nom_piece'].'</td>
								<td style="text-align:justify;">'.$ress['titre'].'</td>
								<td>'.number_format($ress['prix'], 2,'.','').' €</td>
								<td>'.$ress['qte'].'</td>
								<td>'.$ress['unite'].'</td>
								<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' €</td>
							</tr>
						';
}
$reqqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
while ( $resss=$my->arr($reqqq) )
{
	$temp=$my->req_arr('SELECT SUM(valeur_tva_prod) AS prix_total FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' AND tva='.$resss['id'].' ');
	if ( $temp['prix_total'] > 0 )
		$detail.='
								<tr class="total">
									<td colspan="5"><strong>'.$resss['titre'].' : </strong></td>
									<td colspan="1" class="prix_final">'.number_format($temp['prix_total'], 2,'.','').'€</td>
								</tr>
								';
}
$detail.='
						<tr class="total">
							<td colspan="5"><strong>Total TTC : </strong></td>
							<td colspan="1" class="prix_final">'.$total.' €</td>
						</tr>
					</table>';
		
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
	</head>
	<body>
		<div id="espace_compte">							
			'.$detail.'
			<form name="cheque" method="post">
				<p align="center">
					<input type="button" value="Imprimer" onclick="javascript:window.print();" />
				</p>
			</form>
		</div>
	</body>
</html>
	';
?>
