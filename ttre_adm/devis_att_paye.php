<?php 
$nom_client='TousRenov';
$url_site_client='http://creation-site-web-tunisie.net/trn';
$logo_client='http://creation-site-web-tunisie.net/trn/images/logo.png';
$mail_client='';



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
			$my->req('UPDATE ttre_devis SET commentaire="'.$my->net_textarea($_POST['commentaire']).'"  WHERE id='.$_POST['id']);
			rediriger('?contenu=devis_att_paye&modifier=ok');
			exit;
			break;
		case 'retour' :
			$my->req('UPDATE ttre_devis SET statut_valid_admin="1" WHERE id='.$_GET['id']);
			$my->req('UPDATE ttre_devis_client_pro SET statut_enchere="0" WHERE id_devis='.$_GET['id']);
			rediriger('?contenu=devis_att_paye&retour=ok');
			exit;
			break;
		case 'valider' :
			$devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id="'.$_GET['id'].'" ');
			if ( $devis )
			{
				if ( $devis['statut_valid_admin']==2 )
				{
					$id_devis=$devis['id'];
					$id_adresse=$devis['id_adresse'];
					$id_client_part=$devis['id_client'];
					require_once '../mailDevis.php';
					$my->req ( 'UPDATE ttre_devis SET
							statut_valid_admin		=	"3"
						WHERE id = "'.$devis['id'].'" ' );
					$my->req ( 'UPDATE ttre_devis_client_pro SET
							fichier_update			=	"admin"
						WHERE id_devis = "'.$devis['id'].'" ' );
				}
			}
			$my->req('UPDATE ttre_devis SET statut_valid_admin="3" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_att_paye&valider=ok');
			exit;
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_devis WHERE id="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_devis_client_pro WHERE id_devis="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_devis_details WHERE id_devis="'.$_GET['id'].'"');
			rediriger('?contenu=devis_att_paye&supprimer=ok');
			exit;
			break;
	}				
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des devis en attende de payement</h1>';
	$alert='';
	if ( isset($_GET['valider']) ) $alert='<div class="success"><p>Ce devis a bien été validé.</p></div>';
	elseif ( isset($_GET['modifier']) ) $alert='<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	elseif ( isset($_GET['retour']) ) $alert='<div class="success"><p>Ce devis a bien été retourné à l\'étape précédente.</p></div>';
	elseif ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	$req = $my->req('SELECT * FROM ttre_devis WHERE statut_valid_admin=2 ORDER BY date_ajout DESC ');
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
			
			$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
			if ( $userprofil['profil']==1 )
			{
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
					if ( !empty($ress['commentaire']) )$texte='<br /><strong>Commentaire : </strong>'.$ress['commentaire']; else $texte='';
					$detail.='
						<tr>
							<td>'.$ress['nom_piece'].'</td>
							<td style="text-align:justify;">'.$ress['titre'].' '.$texte.'</td>
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
					
				$q=$my->req('SELECT DISTINCT(id_client_pro) FROM ttre_devis_client_pro WHERE id_devis='.$res['id'].' ');
				if ( $my->num($q)>0 )
				{
					$detail.='<p>Liste des clients qui va enchérer : ';
					while ( $s=$my->arr($q) )
					{
						$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$s['id_client_pro'].' ');
						$detail.=''.$temp['nom'].' '.$temp['prenom'].', ';
					}
					$detail.='</p>';
				}
				
				$q=$my->req('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$res['id'].' ORDER BY date_enchere ASC');
				if ( $my->num($q)>0 )
				{
					$detail_many='';
					while ( $s=$my->arr($q) )
					{
						if ( $s['prix_enchere']>0 )
						{
							$p_valid='';
							if ( $s['statut_enchere']==1 )
								$p_valid=' <br /> date de payement : '.date('d/m/Y',$s['date_payement']).', type de payement :'.$s['type_payement'].' --- Proposotion validée --- <a href="?contenu=devis_att_paye&action=retour&id='.$res['id'].'"> Retour en cas d\'échec</a>';
							$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$s['id_client_pro'].' ');
							$detail_many.='<p>'.date('d/m/Y - H:i:s',$s['date_enchere']).' : '.$temp['nom'].' '.$temp['prenom'].' : '.$s['prix_enchere'].' € '.$p_valid.'</p>';
						}
					}
					if ( $detail_many=='' ) $detail_many='<p>Aucun client a donner une proposotion à ce moment</p>';
					$detail.='<br />'.$detail_many;
				}
				
				/*
				 $detail.='
				<div style="border: 1px solid #000000;margin: 35px 0 0 175px;padding: 15px;width: 275px;">
				<form method="POST" action="?contenu=devis_att_paye&action=modifier" >
				<p>Commentaire : <textarea name="commentaire" >'.str_replace('<br />',' ',$res['commentaire']).'</textarea><br /><br /></p>
				<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
				<p><input type="submit" name="modif_stat" value="Modifier" style="margin:0 0 0 110px;"/></p>
				</form>
				</div>
				';
				*/
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
						<a href="?contenu=devis_att_paye&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
						<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\'))
						{window.location=\'?contenu=devis_att_paye&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
			}
			elseif ( $userprofil['profil']==2 )
			{
				$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
				$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
				$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['id_user'].' AND zone='.$rs3['departement_id'].' ');
				if ( $my->num($rq1)>0 )
				{
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
						if ( !empty($ress['commentaire']) )$texte='<br /><strong>Commentaire : </strong>'.$ress['commentaire']; else $texte='';
						$detail.='
								<tr>
									<td>'.$ress['nom_piece'].'</td>		
									<td style="text-align:justify;">'.$ress['titre'].' '.$texte.'</td>		
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
					
					$q=$my->req('SELECT DISTINCT(id_client_pro) FROM ttre_devis_client_pro WHERE id_devis='.$res['id'].' ');
					if ( $my->num($q)>0 )
					{
						$detail.='<p>Liste des clients qui va enchérer : ';
						while ( $s=$my->arr($q) )
						{
							$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$s['id_client_pro'].' ');
							$detail.=''.$temp['nom'].' '.$temp['prenom'].', ';
						}
						$detail.='</p>';
					}
						
					$q=$my->req('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$res['id'].' ORDER BY date_enchere ASC');
					if ( $my->num($q)>0 )
					{
						$detail_many='';
						while ( $s=$my->arr($q) )
						{
							if ( $s['prix_enchere']>0 )
							{
								$p_valid='';
								if ( $s['statut_enchere']==1 )
									$p_valid=' <br /> date de payement : '.date('d/m/Y',$s['date_payement']).', type de payement :'.$s['type_payement'].' --- Proposotion validée --- <a href="?contenu=devis_att_paye&action=retour&id='.$res['id'].'"> Retour en cas d\'échec</a>';
								$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$s['id_client_pro'].' ');
								$detail_many.='<p>'.date('d/m/Y - H:i:s',$s['date_enchere']).' : '.$temp['nom'].' '.$temp['prenom'].' : '.$s['prix_enchere'].' € '.$p_valid.'</p>';
							}
						}
						if ( $detail_many=='' ) $detail_many='<p>Aucun client a donner une proposotion à ce moment</p>';
						$detail.='<br />'.$detail_many;
					}
						
					/*
					$detail.='
							<div style="border: 1px solid #000000;margin: 35px 0 0 175px;padding: 15px;width: 275px;">
								<form method="POST" action="?contenu=devis_att_paye&action=modifier" >
									<p>Commentaire : <textarea name="commentaire" >'.str_replace('<br />',' ',$res['commentaire']).'</textarea><br /><br /></p>
									<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
									<p><input type="submit" name="modif_stat" value="Modifier" style="margin:0 0 0 110px;"/></p>
								</form>
							</div>
							 ';
					*/
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
								<a href="?contenu=devis_att_paye&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
								<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
							</td>
							<td class="bouton">
								<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
								{window.location=\'?contenu=devis_att_paye&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
								<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
							</td>
						</tr>	
						';
				}
			}	
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
