<?php 


//$a=array(4,5,7);var_dump($a);//devis
//$b=array(1,2,3,4,5,6,7,8);var_dump($b);//client
//$c=array_intersect($a,$b);var_dump($c);
//if ( $a === $c ) echo 'true' ; else echo 'false';

$my = new mysql();
if ( isset($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'modifier' :
			$timestamp='';
			if(! empty($_POST['date']))
			{
				list($jour, $mois, $annee) = explode('/', $_POST['date']);
				$timestamp = mktime(23,59,59,$mois,$jour,$annee);
			}
			//$my->req('UPDATE ttre_devis SET commentaire="'.$my->net_textarea($_POST['commentaire']).'" , date_valid_mazad="'.$timestamp.'"  WHERE id='.$_POST['id']);
			$my->req('UPDATE ttre_devis SET date_valid_mazad="'.$timestamp.'"  WHERE id='.$_POST['id']);
			rediriger('?contenu=devis_att_val&modifier=ok');
			exit;
			break;
		case 'valider' :
			$tt = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['id']);
			if ( $tt['date_valid_mazad']>time() )
			{
				$my->req('UPDATE ttre_devis SET statut_valid_admin="1" WHERE id='.$_GET['id']);
				//---------recherche les client qui travaille sur la meme departement--------
				$devis = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['id']);
				$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
				$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
				$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
				$req = $my->req('SELECT * FROM ttre_client_pro_departements WHERE id_departement='.$id_departement['departement_id']);
				if ( $my->num($req)>0 )
				{
					//---------recherche les client qui travaille sur les meme categories--------
					$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_devis_details '); while ( $r=$my->arr($q) ) $tab_devis[]=$r['id_categ'];
					while ( $res=$my->arr($req) )
					{
						$tab_client=array();
						$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' '); while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
						$c=array_intersect($tab_devis,$tab_client);
						if ( $tab_devis === $c ) 
						{
							$my->req('INSERT INTO ttre_devis_client_pro VALUES("","'.$_GET['id'].'","'.$res['id_client'].'","","","","","","")');
							$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client'].' ');
							$nom=$temp['nom'];$mail=$temp['email'];
							//-------------- envoie mail -------------------------------
							$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=1 ');
							$message = '
								<html>
								<head>
									<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
									<title>'.$nom_client.'</title>
								</head>
											
								<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
									<div id="corps" style="margin:0 auto; width:800px; height:auto;">
										<center><img src="'.$logo_client.'" /></center><br />
										<h1 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">'.$nom_client.'</h1>
										'.$contenu_email['description'].'
										<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
											<p style="padding-top:10px;">'.$nom_client.'</p>
										</div>
									</div>
								</body>
								</html>
								';
							//$mail_client='bilelbadri@gmail.com';
							$sujet = $nom_client.' : Nouveau devis';
							$headers = "From: \" ".$nom." \"<".$mail.">\n";
							$headers .= "Reply-To: ".$mail_client."\n";
							$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
							mail($mail,$sujet,$message,$headers);
						}
					}
				}
				//---------------------------------------------------------------------------
				rediriger('?contenu=devis_att_val&valider=ok');exit;
			}
			else
			{
				rediriger('?contenu=devis_att_val&nonvalider=ok');exit;
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_devis WHERE id="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_devis_details WHERE id_devis="'.$_GET['id'].'"');
			rediriger('?contenu=devis_att_val&supprimer=ok');
			exit;
			break;
	}				
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des devis en attende de validation</h1>';
	$alert='';
	if ( isset($_GET['valider']) ) $alert='<div class="success"><p>Ce devis a bien été validé.</p></div>';
	elseif ( isset($_GET['nonvalider']) ) $alert='<div class="error"><p>Erreur date de limite d\'enchere .</p></div>';
	elseif ( isset($_GET['modifier']) ) $alert='<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	elseif ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	$req = $my->req('SELECT * FROM ttre_devis WHERE statut_valid_admin=0 ORDER BY date_ajout DESC ');
	if ( $my->num($req)>0 )
	{
		echo'
			'.$alert.'
			<table id="liste_produits">
			<tr class="entete">
				<td>Date</td>
				<td>Client</td>
				<td>Total</td>
				<td class="bouton">Détail</td>
				<td class="bouton">Valider</td>
				<td class="bouton">Supprimer</td>
			</tr>
			';
		$various='';
		while ( $res=$my->arr($req) )
		{
			$detail='';
			$total=number_format($res['total_net']+$res['total_tva']+$res['frais_port'],2);
			
			$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
			$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
			$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
			$batiment = ucfirst(html_entity_decode($temp['batiment']));
			$code_postal = $temp['code_postal'];
			$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
			$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
			$pays = ucfirst(html_entity_decode($temp['pays']));
			$detail.='
				<ul id="compte_details_com" class="livraison">
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
				</ul>
				<div id="espace_compte">
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
			$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$res['id'].' ORDER BY ordre_categ ASC ');
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
				$temp=$my->req_arr('SELECT SUM(valeur_tva_prod) AS prix_total FROM ttre_devis_details WHERE id_devis='.$res['id'].' AND tva='.$resss['id'].' ');
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
							<td colspan="1" class="prix_final">'.$total.'€</td>
						</tr>								
					</table>
				</div>
						';
			
			$dd='';
			if ( !empty($res['date_valid_mazad']) ) $dd=date('d/m/Y',$res['date_valid_mazad']) ;
			$textarea_commentaire='<p>Commentaire : <textarea name="commentaire" >'.str_replace('<br />',' ',$res['commentaire']).'</textarea><br /><br /></p>';
			$textarea_commentaire='';
			$detail.='
					<div style="border: 1px solid #000000;margin: 35px 0 0 175px;padding: 15px;width: 300px;">
						<form method="POST" action="?contenu=devis_att_val&action=modifier" >
							<p>Date de limite d\'enchére : <input id="date" value="'.$dd.'" name="date" type="text" /></p><br />
							'.$textarea_commentaire.'
							<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
							<p><input type="submit" name="modif_stat" value="Modifier" style="margin:0 0 0 110px;"/></p>
						</form>
					</div>
					 ';
			$various.='
					<div style="display: none;">
						<div id="inline'.$res['id'].'" style="width:750px;height:500px;overflow:auto;">
							<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
								'.$detail.'
							</div>
						</div>
					</div>
						';	
				
			$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
			echo'
				<tr style="text-align:center;">
					<td>'.date('d/m/Y',$res['date_ajout']).'</td>
					<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
					<td> '.$total.' €</td>
					<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
					<td class="bouton">
						<a href="?contenu=devis_att_val&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
						<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
						{window.location=\'?contenu=devis_att_val&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>	
				';
		}
		echo'</table>'.$various;
	}
	else 
	{
		echo'<p> Pas de devis...</p>';
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
});
</script>

