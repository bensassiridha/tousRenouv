<?php 
$my = new mysql();
echo '<h1>Commandes en attente de paiement</h1>';


if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'detail' :
			$com = $my->req_arr('SELECT * FROM ttre_client_pro_commandes WHERE id='.$_GET['id'].' ');
			$pro=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$com['id_client'].'  ');
			echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Date / Ref</td>
							<td>Client</td>
							<td>Montant</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>'.date('d/m/Y',$com['date']).' / '.$com['reference'].'</td>
							<td>'.$pro['nom'].' '.$pro['prenom'].'</td>
							<td>'.number_format($com['montant'],2).' €</td>
						</tr>
					</tbody>
				</table><br /><br />
				';
			$req = $my->req('SELECT * FROM ttre_client_pro_commandes_contenu WHERE id_cmd='.$_GET['id'].'  ');
			if ( $my->num($req)>0 )
			{
				echo'
						<table id="liste_produits">
							<thead>
								<tr class="entete">
									<td>Ref</td>
									<td>Montant</td>
									<td class="bouton">Détail</td>
								</tr>
							</thead>
							<tbody>
					';
				while ( $res=$my->arr($req) )
				{
					$dev = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
					
					$detail='';
					$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$dev['id_adresse'].' ');
					$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
					$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
					$batiment = ucfirst(html_entity_decode($temp['batiment']));
					$code_postal = $temp['code_postal'];
					$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
					$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
					$pays = ucfirst(html_entity_decode($temp['pays']));
						
					$reso = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$dev['id_client'].' ');
					$reso_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$reso['ville'].'" ');
					$detail.='
							<ul id="compte_details_com" class="livraison">
								<li style="width:30%">
									<h4>Adresse de chantier</h4>
									<dl>
										<dd>Numero et voie : '.$num_voie.'</dd>
										<dd>N° d’appartement : '.$num_appart.'</dd>
										<dd>Bâtiment : '.$batiment.'</dd>
										<dd>'.$code_postal.' '.$ville.'</dd>
										<dd>'.$pays.'</dd>
									</dl>
								</li>
								<li style="width:50%">
									<h4>Informations de client particulier</h4>
									<dl>
										<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst(html_entity_decode($reso['nom'])).' '.ucfirst(html_entity_decode($reso['prenom'])).'</dd>
										<dd>'.html_entity_decode($reso['telephone']).' - '.html_entity_decode($reso['email']).'</dd>
										<dd>Numéro et voie : '.html_entity_decode($reso['num_voie']).'</dd>
										<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($reso['num_appart']).'</dd>
										<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($reso['batiment']).'</dd>
										<dd>'.html_entity_decode($reso['code_postal']).' '.html_entity_decode($reso_ville['ville_nom_reel']).'</dd>
										<dd>'.html_entity_decode($reso['pays']).'</dd>
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
					$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id_devis'].' ORDER BY ordre_categ ASC ');
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
						
					$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$res['id_devis'].' ');
					if ( $my->num($req_f)>0 )
					{
						$detail.='<p><br /> Fichiers à télécharger : ';
						while ( $res_f=$my->arr($req_f) )
						{
							$detail.='<a target="_blanc" href="../upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
						}
						$detail.='</p>';
					}
					
					$various.='
							<div style="display: none;">
								<div id="inline'.$res['id_devis'].'" style="width:750px;height:500px;overflow:auto;">
									<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
										'.$detail.'
									</div>
								</div>
							</div>
								';
					echo'
						<tr>
							<td>'.$dev['reference'].'</td>
							<td>'.number_format($res['prix'],2).' €</td>
							<td class="bouton">
								<a class="various1" href="#inline'.$res['id_devis'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a>
							</td>
						</tr>
						';
				}
				echo'
						</tbody>
						</table>
					'.$various;
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_client_pro_commandes WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_pro_commandes_contenu WHERE id_cmd='.$_GET['id'].' ');
			rediriger('?contenu=commandes_att_paye&supprimer=ok');
			break;
		case 'valid' :
			$com=$my->req_arr('SELECT * FROM ttre_client_pro_commandes WHERE id="'.$_GET['id'].'"');
			$my->req('UPDATE ttre_client_pro_commandes SET statut="'.!$com['statut'].'" , fichier_update="admin" WHERE id="'.$com['id'].'"');
				
			$req=$my->req('SELECT * FROM ttre_client_pro_commandes_contenu WHERE id_cmd='.$com['id'].' ');$suite='';
			while ( $res=$my->arr($req) )
			{
				$info_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
					
				$suite.='<table cellpadding="0" cellspacing="0">';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$info_devis['id'].' ORDER BY ordre_categ ASC ');
				while ( $ress=$my->arr($reqq) )
				{
					if ( $nom_cat!=$ress['titre_categ'] )
					{
						$nom_cat=$ress['titre_categ'];
						$suite.='<tr style="background:#FFFF66;"><td>'.$nom_cat.'</td></tr>';
					}
					$suite.='<tr><td style="text-align:justify;">'.$ress['piece'].'<br /><br /></td></tr>';
				}
				$suite.='</table>';
					
				$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$info_devis['id_client'].' ');
				$info_ville_client=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_client['ville'].' ');
				$info_adresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$info_devis['id_adresse'].' ');
				$info_ville_adresse=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_adresse['ville'].' ');
					
				$suite.='
					<p><span style="color:#0495CB;">Détails du client :</span><br />
						<strong>Civilité : </strong> '.ucfirst(html_entity_decode($info_client['civ'])).'<br />
						<strong>Nom : </strong> '.ucfirst(html_entity_decode($info_client['nom'])).'<br />
						<strong>Prénom : </strong> '.ucfirst(html_entity_decode($info_client['prenom'])).'<br />
						<strong>Téléphone : </strong> '.html_entity_decode($info_client['telephone']).'<br />
						<strong>Email : </strong> '.html_entity_decode($info_client['email']).'<br />
						<strong>Numéro et voie : </strong> '.html_entity_decode($info_client['num_voie']).'<br />
						<strong>N° d\'appartement, Etage, Escalier : </strong> '.html_entity_decode($info_client['num_appart']).'<br />
						<strong>Bâtiment, Résidence, Entrée : </strong> '.html_entity_decode($info_client['batiment']).'<br />
						<strong>Code postal : </strong> '.html_entity_decode($info_client['code_postal']).'<br />
						<strong>Ville : </strong> '.html_entity_decode($info_ville_client['ville_nom_reel']).'<br />
						<strong>Pays : </strong> '.html_entity_decode($info_client['pays']).'<br />
					</p>
					<p><span style="color:#0495CB;">Détails du l\'adresse du chantier :</span><br />
						<strong>Numéro et voie : </strong> '.html_entity_decode($info_adresse['num_voie']).'<br />
						<strong>N° d\'appartement, Etage, Escalier : </strong> '.html_entity_decode($info_adresse['num_appart']).'<br />
						<strong>Bâtiment, Résidence, Entrée : </strong> '.html_entity_decode($info_adresse['batiment']).'<br />
						<strong>Code postal : </strong> '.html_entity_decode($info_adresse['code_postal']).'<br />
						<strong>Ville : </strong> '.html_entity_decode($info_ville_adresse['ville_nom_reel']).'<br />
						<strong>Pays : </strong> '.html_entity_decode($info_adresse['pays']).'<br />
					</p><br /><br /><br /><br />
					';
			}
		
			$message_html = '
						<html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
							<title>'.$nom_client.'</title>
						</head>
		
						<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
							<div id="corps" style="margin:0 auto; width:800px; height:auto;">
								<center><img src="'.$logo_client.'" /></center><br />
								<h1 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">'.$nom_client.'</h1>
								<p>Détails de devis :</p>
								'.$suite.'
								<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
									<p style="padding-top:10px;">'.$nom_client.'</p>
								</div>
							</div>
						</body>
						</html>
						';
			$pro=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$com['id_client'].' ');
		
			$destinataire=$pro['email'];
			//$destinataire='bilelbadri@gmail.com';
			$email_expediteur=$mail_client;
			$email_reply=$mail_client;
			$titre_mail=$nom_client;
			$sujet=$nom_client.' : Détail avancé ';
				
			$frontiere = '-----=' . md5(uniqid(mt_rand()));
			$headers = 'From: "'.$titre_mail.'" '."\n";
			$headers .= 'Return-Path: <'.$email_reply.'>'."\n";
			$headers .= 'MIME-Version: 1.0'."\n";
			$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
		
			$message = '';
			$message .= '--'.$frontiere."\n";
			$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
			$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
		
			$message .= $message_html."\n\n";
		
			$message .= '--'.$frontiere.'--'."\r\n";
		
			mail($destinataire,$sujet,$message,$headers);
			rediriger('?contenu=commandes_att_paye&valider=ok');
			break;
	}
}
else 
{
	if ( isset($_GET['valider']) ) echo '<div class="success"><p>Cette commande a bien été validée.</p></div>';
	if ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Cette commande a bien été supprimée.</p></div>';
	
	
	$req = $my->req('SELECT * FROM ttre_client_pro_commandes WHERE statut=0 ORDER BY date DESC ');
	if ( $my->num($req)>0 )
	{
		echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Date / Ref</td>
							<td>Client</td>
							<td>Montant</td>
							<td class="bouton">Détail</td>
							<td class="bouton">Valider</td>
							<td class="bouton">Supprimer</td>
						</tr>
					</thead>
					<tbody>
			';
		while ( $res=$my->arr($req) )
		{
			$pro=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client'].'  ');
			echo'
				<tr>
					<td>'.date('d/m/Y',$res['date']).' / '.$res['reference'].'</td>
					<td>'.$pro['nom'].' '.$pro['prenom'].'</td>
					<td>'.number_format($res['montant'],2).' €</td>
					<td class="bouton">
						<a href="?contenu=commandes_att_paye&action=detail&id='.$res['id'].'" target="_blanc" >
						<img src="img/interface/btn_modifier.png" alt="Détail"/></a>
					</td>
					<td class="bouton">
						<a href="?contenu=commandes_att_paye&action=valid&id='.$res['id'].'" >
						<img src="img/interface/icone_nok.jpeg"  border="0" /></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette commande ?\'))
						{window.location=\'?contenu=commandes_att_paye&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
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
		echo '<p>Pas commandes ...</p>';
	}
}
?>

<link rel="stylesheet" type="text/css" href="../style_alert.css" />        
<link rel="stylesheet" type="text/css" href="../style_boutique.css" />   

<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$(".various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
	$("a#various3").fancybox({
		'width'				: '72%',
		'height'			: '97%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>



