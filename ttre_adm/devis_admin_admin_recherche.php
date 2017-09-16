<?php 
$my = new mysql();


// stat_ajout_zone ?
// 0 : affiché sur ajout et zone
// 1 : affiché sur ajout
// 2 : affiché sur admin

/*
$req=$my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin<0 ');
while ( $res=$my->arr($req) )
{
	$reqq=$my->req('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$res['id'].' ');
	if ( $my->num($reqq)==0 )
		$my->req('INSERT INTO ttre_achat_devis_suite VALUES("","'.$res['id'].'","0","0")');
}
*/

if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		
	}
}
else
{
	echo '<h1>Recherche</h1>';
	
	
	
	if ( isset($_POST['mot']) && !empty($_POST['mot']) ) $mot=$_POST['mot']; else $mot='';
	
	$form = new formulaire('modele_1','?contenu=devis_admin_admin_recherche','','','','sub','txt','','txt_obl','lab_obl');
	$form->text('Mot','mot','',1,$mot);
	$form->afficher1('Rechercher');
		
	if ( $mot!='' )
	{
		$req = $my->req('SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_client_part CP ,
								ttre_users U ,
								ttre_client_part_adresses CPA ,
								ttre_villes_france V ,
								ttre_departement_france D 
							WHERE
								AD.statut_valid_admin<0
								AND AD.id_client=CP.id 
								AND AD.nbr_estimation=U.id_user 
								AND AD.id_adresse=CPA.id
								AND CPA.ville=V.ville_id 
								AND V.ville_departement=D.departement_code 
								AND ( CP.nom LIKE "%'.$mot.'%" 
									  OR CP.prenom LIKE "%'.$mot.'%" 
									  OR CP.telephone LIKE "%'.$mot.'%" 
									  OR CP.email LIKE "%'.$mot.'%" 
									  OR U.nom LIKE "%'.$mot.'%" 
									  OR CPA.code_postal LIKE "%'.$mot.'%" 
									  OR V.ville_nom_reel LIKE "%'.$mot.'%" 
									  OR D.departement_nom LIKE "%'.$mot.'%" 
									  OR AD.reference LIKE "%'.$mot.'%" 
									)					
				
						UNION
				
						SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_client_part_adresses CPA ,
								ttre_villes_france V ,
								ttre_departement_france D ,
								ttre_users U ,
								ttre_users_zones UZ 
							WHERE
								AD.statut_valid_admin<0
								AND AD.id_adresse=CPA.id
								AND CPA.ville=V.ville_id 
								AND V.ville_departement=D.departement_code 
								AND D.departement_id=UZ.zone 
								AND UZ.id_user=U.id_user 
								AND U.nom LIKE "%'.$mot.'%" 
	 
						UNION
				
						SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_achat_devis_client_pro ADCP ,
								ttre_client_pro CP 
							WHERE
								AD.statut_valid_admin=-2
								AND AD.id=ADCP.id_devis 
								AND ADCP.statut_achat<2 
								AND ADCP.id_client_pro=CP.id 
								AND ( CP.nom LIKE "%'.$mot.'%" 
									  OR CP.prenom LIKE "%'.$mot.'%" 
									  OR CP.telephone LIKE "%'.$mot.'%" 
									  OR CP.fax LIKE "%'.$mot.'%" 
									  OR CP.email LIKE "%'.$mot.'%" 
									)	
								
						UNION
				
						SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_achat_devis_client_pro ADCP ,
								ttre_client_pro CP 
							WHERE
								AD.statut_valid_admin=-3
								AND AD.id=ADCP.id_devis 
								AND ADCP.statut_achat=-2 
								AND ADCP.id_client_pro=CP.id 
								AND ( CP.nom LIKE "%'.$mot.'%" 
									  OR CP.prenom LIKE "%'.$mot.'%" 
									  OR CP.telephone LIKE "%'.$mot.'%" 
									  OR CP.fax LIKE "%'.$mot.'%" 
									  OR CP.email LIKE "%'.$mot.'%" 
									)					
	 
						');
		
		if ( $my->num($req)>0 )
		{
			echo'	<br /><br />
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Date / Ref</td>
								<td>Client Part</td>
								<td>User ajout</td>
								<td>User Zone</td>
								<td>Catégorie</td>
								<td class="bouton">Détail</td>
							</tr>
						</thead>
						<tbody id="ajax_tab"> 
				';
			while ( $ress=$my->arr($req) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
				$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$res['id'].' ');
				$user_ajout=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['nbr_estimation'].' ');
				$client_part=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
				
				$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
				$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
				$rs4=$my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$rs3['departement_id'].' ');
				$user_zone=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$rs4['id_user'].' ');
				
				if ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && !$res_suite ) $position='Devis en attente de traitement';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==0 ) $position='Devis en attente de traitement';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==1 ) $position='Statut : Rdv pris';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==2 ) $position='Statut : A rappeler';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==3 ) $position='Statut : Travaux fini';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==4 ) $position='Statut : Faux numéro';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==5 ) $position='Statut : Déjà trouver un artisan';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==6 ) $position='Statut : Autres';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==7 ) $position='Statut : Pas de traveaux';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==8 ) $position='Statut : Projet abondonné';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-2 ) $position='Devis à atribuer';
				elseif ( $res['stat_suppr']==0 && $res['statut_valid_admin']==-3 ) $position='Devis signé';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && !$res_suite ) $position='Archiver : Devis en attente de traitement';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==0 ) $position='Archiver : Devis en attente de traitement';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==1 ) $position='Archiver : Statut : Rdv pris';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==2 ) $position='Archiver : Statut : A rappeler';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==3 ) $position='Archiver : Statut : Travaux fini';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==4 ) $position='Archiver : Statut : Faux numéro';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==5 ) $position='Archiver : Statut : Déjà trouver un artisan';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==6 ) $position='Archiver : Statut : Autres';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==7 ) $position='Archiver : Statut : Pas de traveaux';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-1 && (int)$res_suite['stat_devis_attente']==8 ) $position='Archiver : Statut : Projet abondonné';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-2 ) $position='Archiver : Devis à atribuer';
				elseif ( $res['stat_suppr']==1 && $res['statut_valid_admin']==-3 ) $position='Archiver : Devis signé';
				
				//------------------------------- debut partie various ------------------------------------------------------------
				$detail='';
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
				$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
				$batiment = ucfirst(html_entity_decode($temp['batiment']));
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				
				$reso = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
				$reso_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$reso['ville'].'" ');
				
				$s='';
				if ( $res['statut_valid_admin']==-3 )
				{
					$ress=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id'].' AND statut_achat=-2 ');
					$resoo = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['id_client_pro'].' ');
					$resoo_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$resoo['ville'].'" ');
					$s='
							<li style="width:40%;text-align:left;">
								<h4>Informations de client professionnel</h4>
								<dl>
									<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst(html_entity_decode($resoo['nom'])).' '.ucfirst(html_entity_decode($resoo['prenom'])).'</dd>
									<dd>'.html_entity_decode($resoo['telephone']).' - '.html_entity_decode($resoo['email']).'</dd>
									<dd>Numéro et voie : '.html_entity_decode($resoo['num_voie']).'</dd>
									<dd>'.html_entity_decode($resoo['code_postal']).' '.html_entity_decode($resoo_ville['ville_nom_reel']).'</dd>
									<dd>'.html_entity_decode($resoo['pays']).'</dd>
								</dl>
							</li>
						';
				}
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
									<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst(html_entity_decode($reso['nom'])).' '.ucfirst(html_entity_decode($reso['prenom'])).'</dd>
									<dd>'.html_entity_decode($reso['telephone']).' - '.html_entity_decode($reso['email']).'</dd>
									<dd>Numéro et voie : '.html_entity_decode($reso['num_voie']).'</dd>
									<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($reso['num_appart']).'</dd>
									<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($reso['batiment']).'</dd>
									<dd>'.html_entity_decode($reso['code_postal']).' '.html_entity_decode($reso_ville['ville_nom_reel']).'</dd>
									<dd>'.html_entity_decode($reso['pays']).'</dd>
								</dl>
							</li>
							'.$s.'
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
				
				$touscom='';
				$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$res['id'].' ORDER BY date ASC');
				if ( $my->num($reqComm)>0 )
				{
					$touscom.='
						<table id="liste_produits">
							<thead>
								<tr class="entete">
									<td width="20%">Date</td>
									<td width="20%">User</td>
									<td>Commentaire</td>
								</tr>
							</thead>
							<tbody>
						';
					while ( $resComm=$my->arr($reqComm) )
					{
						if ( $resComm['date']!=0 ) $d=date('d/m/Y H:i',$resComm['date']); else $d='';
						$us =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$resComm['id_user'].'"');
						if ( $resComm['id_user']!=0 ) $u=$us['nom']; else $u='';
						if ( $us['profil']==1 ) $u='Administrateur';
						$touscom.='
									<tr>
										<td>'.$d.'</td>
										<td>'.$u.'</td>
										<td>'.$resComm['commentaire'].'</td>
									</tr>
							';
					}
					$touscom.='
						</tbody>
						</table>
						';
				}
				
				$various.='
							<div style="display: none;">
								<div id="inline'.$res['id'].'" style="width:750px;height:500px;overflow:auto;">
									<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
										'.$detail.'
				
				
						<br />
							<p>Prix : '.$res['prix_achat'].' €</p>
							<p>Commentaire devis :
								'.$touscom.'
							</p>
				
									</div>
								</div>
							</div>
								';
				//------------------------------- fin partie various ------------------------------------------------------------
				
				echo'
					<tr>
						<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
						<td>'.$client_part['nom'].' '.$client_part['prenom'].'</td>
						<td>'.$user_ajout['nom'].'</td>
						<td>'.$user_zone['nom'].'</td>
						<td>'.$position.'</td>		
						<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
					</tr>';
			}
			echo'
					</tbody> 
					</table>
				'.$various;
		}
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

function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>




