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
		case 'paye' :
			if ( isset($_GET['actionPaye']) )
			{
				switch( $_GET['actionPaye'] )
				{
					case 'valider' :
						$adcp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id="'.$_GET['id'].'" ');
						$devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id="'.$adcp['id_devis'].'" ');
						if ( $adcp['statut_achat']==0 )
						{
							$id_devis=$devis['id'];
							$id_adresse=$devis['id_adresse'];
							$id_client_part=$devis['id_client'];
							$id_client_pro=$adcp['id_client_pro'];
							require_once '../mailAchatDevis.php';
							$my->req('UPDATE ttre_achat_devis_client_pro SET 
										statut_achat 	= "1" ,
										fichier_update	=	"admin"
									WHERE id = "'.$_GET['id'].'" ' );
						}
						/*$req_devis=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE statut_achat = 1 AND id_devis='.$devis['id'].' ');
						if ( $my->num($req_devis)==3 ) 
						{
							$my->req('UPDATE ttre_achat_devis SET statut_valid_admin = "2" WHERE id = "'.$devis['id'].'" ' );
							rediriger('?contenu=devisa_att_paye');
						}
						else
						{*/
						rediriger('?contenu=devisa_att_paye&action=paye&id='.$adcp['id_devis'].'');
						//}
						exit;
						break;
					case 'envoyer' :
						$my->req('UPDATE ttre_achat_devis SET statut_valid_admin = "2" WHERE id = "'.$_GET['id'].'" ' );
						$my->req('UPDATE ttre_achat_devis_client_pro SET statut_valid = "1" WHERE id = "'.$_GET['idadcp'].'" ' );
						rediriger('?contenu=devisa_att_paye&valider=ok');
						break;
				}
			}
			else 
			{
				echo '<h1 style="margin-top:0;" >Gérer la liste des clients en attende de payement</h1>';
				$req=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ORDER BY id ASC ');	
				if ( $my->num($req)>0 )
				{
					$req_test=$my->req('SELECT * FROM ttre_achat_devis D , ttre_client_part C  WHERE D.id_client=C.id AND D.id='.$_GET['id'].' AND C.stat_valid=-1 ');	
					if ( $my->num($req_test)==0 ) $test=0; else $test=1;
					if ( $test==1 ) $td1='<td class="bouton">Valider</td>'; 
					else $td1=''; 
					echo'
						<table id="liste_produits">
						<tr class="entete">
							<td>Date</td>
							<td>Client</td>
							<td class="bouton">Type de payement</td>
							<td class="bouton">Valider le payement</td>
							'.$td1.'
						</tr>
						';
					while ( $res=$my->arr($req) )
					{
						if ( $res['statut_achat']==1 )
							$a_valid = '<a href="?contenu=devisa_att_paye&action=paye&actionPaye=valider&id='.$res['id'].'" ><img src="img/interface/icone_ok.jpeg" border="0" /></a>';
						else
							$a_valid = '<a href="?contenu=devisa_att_paye&action=paye&actionPaye=valider&id='.$res['id'].'" ><img src="img/interface/icone_nok.jpeg"  border="0" /></a>';
						
						$info_client=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client_pro'].'  ');
						if ( $res['date_payement']==0 ) $date=''; else $date=date('d/m/Y',$res['date_payement']);
						if ( $test==1 ) $td2='<td class="bouton"><a href="?contenu=devisa_att_paye&action=paye&actionPaye=envoyer&id='.$_GET['id'].'&idadcp='.$res['id'].'">Confirmer</a></td>';
						else $td2='';
						echo'
							<tr style="text-align:center;">
								<td>'.$date.'</td>
								<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
								<td>'.$res['type_payement'].'</td>
								<td class="bouton">'.$a_valid.'</td>
								'.$td2.'
							</tr>	
							';
					}
					echo'</table>';
				}
				
			}
			break;
		/*case 'valider' :
			$devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id="'.$_GET['id'].'" ');
			$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="2" WHERE id='.$_GET['id']);
			rediriger('?contenu=devisa_att_paye&valider=ok');
			exit;
			break;*/
		case 'supprimer' :
			$my->req('DELETE FROM ttre_achat_devis WHERE id="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_achat_devis_details WHERE id_devis="'.$_GET['id'].'"');
			$req = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id']);
			while ( $res=$my->arr($req) )
			{
				@unlink('../upload/devis/'.$res['fichier']);
			}
			$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id_devis="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis="'.$_GET['id'].'"');
			$req = $my->req('SELECT * FROM ttre_achat_devis_cm WHERE id_devis='.$_GET['id']);
			while ( $res=$my->arr($req) )
			{
				$req1 = $my->req('SELECT * FROM ttre_achat_devis_cm_photo WHERE id_cm='.$res['id']);
				while ( $res1=$my->arr($req1) )
				{
					@unlink('../upload/galeries/800X600/'.$res1['photo']);
					@unlink('../upload/galeries/300X300/'.$res1['photo']);
					@unlink('../upload/galeries/100X100/'.$res1['photo']);
				}
				$my->req('DELETE FROM ttre_achat_devis_cm_photo WHERE id_cm="'.$res['id'].'"');
			}
			$my->req('DELETE FROM ttre_achat_devis_cm WHERE id_devis="'.$_GET['id'].'"');
			rediriger('?contenu=devisa_att_paye&supprimer=ok');
			exit;
			break;
		case 'changer' :
			$info_devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('UPDATE ttre_achat_devis SET
					nbr_estimation			=	"'.$info_devis['stat_suppr'].'"	,
					prix_achat				=	"'.$info_devis['user_zone'].'"	,
					note_devis				=	"0"	,
					user_zone				=	"0"	,
					stat_suppr				=	"0"	,
					statut_valid_admin		=	"-1"
							WHERE id='.$_GET['id']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			while ( $res=$my->arr($req) ) @unlink('../upload/devis_client_pro/'.$res['fichier']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			rediriger('?contenu=devisa_att_paye&changer=ok');exit;
			break;
	}				
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des devis en attende de payement</h1>';
	$alert='';
	if ( isset($_GET['valider']) ) $alert='<div class="success"><p>Ce devis a bien été validé.</p></div>';
	elseif ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	elseif ( isset($_GET['changer']) ) echo '<div class="success"><p>Ce devis a bien été changé.</p></div>';
	
	
	$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=1 ORDER BY date_ajout DESC ');
	if ( $my->num($req)>0 )
	{
		//		<td class="bouton">Valider</td>
		echo'
			'.$alert.'
			<table id="liste_produits">
			<tr class="entete">
				<td>Date</td>
				<td>Client</td>
				<td>Catégorie</td>
				<td>Ville / Département</td>
				<td>Prix</td>
				<td class="bouton">Détail</td>
				<td class="bouton">Artisan</td>
				<td class="bouton"></td>
			</tr>
			';
		$various='';
		while ( $res=$my->arr($req) )
		{
			$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
			if ( $userprofil['profil']==1 )
			{
				
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
				
				$detail.='
					<ul id="compte_details_com" class="livraison">
						<li style="width:250px" >
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N° d’appartement : '.$num_appart.'</dd>
								<dd>Bâtiment : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>	
						</li>	
						<li style="width:350px" >
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
						<p><br /><br />Nombre d\'estimation : '.$res['nbr_estimation'].' </p>
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
					
				$various.='
						<div style="display: none;">
							<div id="inline'.$res['id'].'" style="width:750px;height:500px;overflow:auto;">
								<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
									'.$detail.'
								</div>
							</div>
						</div>
							';	
					
				/*		<td class="bouton">
							<a href="?contenu=devisa_att_paye&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
							<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
						</td>*/
				$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
				
				$vd='';
				$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
				echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).'</td>
						<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
						<td>'.$nc.'</td>
						<td>'.$vd.'</td>
						<td>'.number_format($res['prix_achat'],2).' €</td>
						<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
						<td class="bouton">
							<a href="?contenu=devisa_att_paye&action=paye&id='.$res['id'].'" title="" >
							<img src="img/cart.png" alt="Valider"/></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
							{window.location=\'?contenu=devisa_att_paye&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
							Supprimer</a>
							<br /><br /><a style="color:red;" href="?contenu=devisa_att_paye&action=changer&id='.$res['id'].'" title="Par zone">Changer</a>		
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
					$detail='';
					
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
						<p><br /><br />Nombre d\'estimation : '.$res['nbr_estimation'].' </p>
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
						
					$various.='
						<div style="display: none;">
							<div id="inline'.$res['id'].'" style="width:750px;height:500px;overflow:auto;">
								<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
									'.$detail.'
								</div>
							</div>
						</div>
							';
						
					/*		<td class="bouton">
					 <a href="?contenu=devisa_att_paye&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
					<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
					</td>*/
					$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
					$vd='';
					$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
					$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
					$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
					$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
					echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).'</td>
						<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
						<td>'.$nc.'</td>
						<td>'.$vd.'</td>
						<td>'.number_format($res['prix_achat'],2).' €</td>
						<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
						<td class="bouton">
							<a href="?contenu=devisa_att_paye&action=paye&id='.$res['id'].'" title="" >
							<img src="img/cart.png" alt="Valider"/></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\'))
							{window.location=\'?contenu=devisa_att_paye&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
							Supprimer</a>
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
