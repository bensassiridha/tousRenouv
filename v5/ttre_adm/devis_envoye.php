<?php 
$nom_client='TousRenov';
$url_site_client='http://tousrenov.fr';
// creation-site-web-tunisie.net/trn
$logo_client='http://tousrenov.fr/images/logo.png';
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
			rediriger('?contenu=devis_envoye&modifier=ok');
			exit;
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_devis WHERE id="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_devis_client_pro WHERE id_devis="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_devis_details WHERE id_devis="'.$_GET['id'].'"');
			rediriger('?contenu=devis_envoye&supprimer=ok');
			exit;
			break;
	}				
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des devis envoyés</h1>';
	$val='';
	if ( isset($_POST['mot']) ) $val=$_POST['mot'];
	echo'
		<form method="POST">
			<label class="lab">Nom ou prénom : </label><input type="text" name="mot" class="txt"  value="'.$val.'" />
			<input type="submit" value="Rechercher" name="rechercher" />
		</form><br /><br />';
	$alert='';
	if ( isset($_GET['modifier']) ) $alert='<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	elseif ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	if ( isset($_POST['mot']) && !empty($_POST['mot']) )
	{
		$rech=$my->net_input($_POST['mot']);
		$req =$my->req('SELECT * FROM ttre_devis D , ttre_client_pro CPR , ttre_client_part CPA , ttre_devis_client_pro DC
						WHERE D.id=DC.id_devis AND D.id_client=CPA.id AND DC.id_client_pro=CPR.id AND D.statut_valid_admin=3 AND DC.statut_enchere=1
						AND ( CPR.nom LIKE "%'.$rech.'%" OR CPR.prenom LIKE "%'.$rech.'%"
				 		OR CPA.nom LIKE "%'.$rech.'%" OR CPA.prenom LIKE "%'.$rech.'%" ) ORDER BY D.date_ajout DESC ');
	}
	else
		$req = $my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro DC WHERE D.id=DC.id_devis AND DC.statut_enchere=1 AND D.statut_valid_admin=3 ORDER BY D.date_ajout DESC ');
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
			
			$ress=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_enchere=1 ');
			
			$reso = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
			$reso_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$reso['ville'].'" ');
			$resoo = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['id_client_pro'].' ');
			$resoo_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$resoo['ville'].'" ');
			
			$detail.='
				<ul id="compte_details_com" class="livraison">
					<li>
						<h4>Informations générales</h4>
						<dl>
							<dd>Date Devis : '.date("d-m-Y",$res['date_ajout']).'</dd>
							<dd>Date d\'enchere : '.date("d-m-Y",$ress['date_enchere']).'</dd>
							<dd>Date Payement : '.date("d-m-Y",$ress['date_payement']).'</dd>
							<dd>Mode de paiement : '.$ress['type_payement'].'</dd>
							<dd>Référence : '.$res['reference'].'</dd>
						</dl>									
					</li>
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
					<li>
						<br /><br />
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
					<li>
						<br /><br />			
						<h4>Informations de client professionnel</h4>
						<dl>
							<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst(html_entity_decode($resoo['nom'])).' '.ucfirst(html_entity_decode($resoo['prenom'])).'</dd>
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
							<td>Pièce</td>														
							<td>Désignation</td>														
							<td>P.U</td>
							<td>Qte</td>
							<td>Unité</td>
							<td>Total</td>
						</tr>	
					 ';
			$nom_cat='';
			$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$res['id_devis'].' ORDER BY ordre_categ ASC ');
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
				$temp=$my->req_arr('SELECT SUM(valeur_tva_prod) AS prix_total FROM ttre_devis_details WHERE id_devis='.$res['id_devis'].' AND tva='.$resss['id'].' ');
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
			
			$q=$my->req('SELECT DISTINCT(id_client_pro) FROM ttre_devis_client_pro WHERE id_devis='.$res['id_devis'].' ');
			if ( $my->num($q)>0 )
			{
				$detail.='<p>Liste des clients qui ont enchérer : ';
				while ( $s=$my->arr($q) )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$s['id_client_pro'].' ');
					$detail.=''.$temp['nom'].' '.$temp['prenom'].', ';
				}
				$detail.='</p>';
			}
			
			$q=$my->req('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$res['id_devis'].' ORDER BY date_enchere ASC');
			if ( $my->num($q)>0 )
			{
				$detail_many='';
				while ( $s=$my->arr($q) )
				{
					if ( $s['prix_enchere']>0 )
					{
						$p_valid='';
						if ( $s['statut_enchere']==1 )
							$p_valid=' --- Proposotion validée et payée';
						$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$s['id_client_pro'].' ');
						$detail_many.='<p>'.date('d/m/Y - H:i:s',$s['date_enchere']).' : '.$temp['nom'].' '.$temp['prenom'].' : '.$s['prix_enchere'].' € '.$p_valid.'</p>';
					}
				}
				if ( $detail_many=='' ) $detail_many='<p>Aucun client a donner une proposotion à ce moment</p>';
				$detail.='<br />'.$detail_many;
			}
			
			$id = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$res['id_devis'].' ');
			$idd = $my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_enchere=1 ');
			$icpa = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$id['id_client'].' ');
			$icpr = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$idd['id_client_pro'].' ');
			$reqa = $my->req('SELECT * FROM ttre_devis_cm WHERE id_devis='.$res['id_devis'].' ORDER BY date ASC ');
			if ( $my->num($reqa)>0 )
			{
				$detail.='<br /><br /><ul>';
				while ( $resa=$my->arr($reqa) )
				{
					$galerie='';
					$req_g = $my->req('SELECT * FROM ttre_devis_cm_photo WHERE id_cm='.$resa['id'].' ');
					if ( $my->num($req_g)>0 )
					{
						$galerie.='<p>';
						while ( $res_g=$my->arr($req_g) )
						{
							$galerie.='<a target="_blanc" href="../upload/galeries/800X600/'.$res_g['photo'].'"><img src="../upload/galeries/300X300/'.$res_g['photo'].'" width="100" style="margin:10px;"/></a>';
						}
						$galerie.='</p>';
					}
					$nom='';
					if ( $resa['client']=='pro' ) $nom=$icpr['nom'];
					elseif ( $resa['client']=='part' ) $nom=$icpa['nom'];
					$detail.='	<li>
										<strong>'.date('d/m/Y - H:i',$resa['date']).' '.$nom.'</strong> : '.$resa['message'].'
										'.$galerie.'
									</li>';
				}
				$detail.='</ul>';
			}
			
			$detail.='<br /><br /><p>Note : '.$res['note_devis'].' / 20 </p>';
			
			/*
			$detail.='
					<div style="border: 1px solid #000000;margin: 35px 0 0 175px;padding: 15px;width: 275px;">
						<form method="POST" action="?contenu=devis_envoye&action=modifier" >
							<p>Commentaire : <textarea name="commentaire" >'.str_replace('<br />',' ',$res['commentaire']).'</textarea><br /><br /></p>
							<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
							<p><input type="submit" name="modif_stat" value="Modifier" style="margin:0 0 0 110px;"/></p>
						</form>
					</div>
					 ';
			*/
			$various.='
					<div style="display: none;">
						<div id="inline'.$res['id_devis'].'" style="width:750px;height:500px;overflow:auto;">
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
					<td class="bouton"><a class="various1" href="#inline'.$res['id_devis'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
						{window.location=\'?contenu=devis_envoye&action=supprimer&id='.$res['id_devis'].'\'}" title="Supprimer">
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
	$("a.example2").fancybox({
		'titleShow'		: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
});
</script>
