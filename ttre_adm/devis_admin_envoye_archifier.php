<?php 

$my = new mysql();
if ( isset($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_part WHERE id='.$temp['id_client'].' ');
			$my->req('DELETE FROM ttre_client_part_adresses WHERE id='.$temp['id_adresse'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			while ( $res=$my->arr($req) )
			{
				@unlink('../upload/devis/'.$res['fichier']);
			}
			@unlink('../upload/factures/facture_'.$_GET['id'].'.pdf');
			$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			//$my->req('UPDATE ttre_achat_devis SET stat_suppr="1" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_admin_envoye_archifier&supprimer=ok');
			break;
	}				
}
else
{
	echo '<h1 style="margin-top:0;" >Archiver : devis signés</h1>';
	
	if ( isset($_POST['modif_prix']) )
	{
		if ( !empty($_POST['commentaire']) )
			$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_user'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
		if ( isset($_POST['retour']) )
			$my->req('UPDATE ttre_achat_devis SET stat_suppr="0" WHERE id='.$_GET['id']);
	} 
	
	$tabCat[]='';
	$rq=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
	while ( $rs=$my->arr($rq) ) $tabCat[$rs['id']]=$rs['titre'];
	$tabDep[]='';
	$rq=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	while ( $rs=$my->arr($rq) ) $tabDep[$rs['departement_id']]=$rs['departement_nom'];
	$tabUseAj[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=3  ');
	while ( $rs=$my->arr($rq) ) $tabUseAj[$rs['id_user']]=$rs['nom'];
	$tabUseZo[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=2  ');
	while ( $rs=$my->arr($rq) ) $tabUseZo[$rs['id_user']]=$rs['nom'];
	
	if ( isset($_POST['cat']) && !empty($_POST['cat']) ) $cat=$_POST['cat']; else $cat=0;
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
	if ( isset($_POST['use_aj']) && !empty($_POST['use_aj']) ) $use_aj=$_POST['use_aj']; else $use_aj=0;
	if ( isset($_POST['use_zo']) && !empty($_POST['use_zo']) ) $use_zo=$_POST['use_zo']; else $use_zo=0;
	if ( isset($_POST['ddb']) && !empty($_POST['ddb']) ) $ddb=$_POST['ddb']; else $ddb='';
	if ( isset($_POST['dfn']) && !empty($_POST['dfn']) ) $dfn=$_POST['dfn']; else $dfn='';
	
	$sddb=0;$sdfn=0;
	if ( $ddb!='' && $dfn!='' )
	{
		list($jour, $mois, $annee) = explode('/', $ddb);
		$sddb = mktime(0,0,0,$mois,$jour,$annee);
		list($jour, $mois, $annee) = explode('/', $dfn);
		$sdfn = mktime(23,59,59,$mois,$jour,$annee);
	}
	if ( $sddb!=0 ) $where_date=' AND AD.date_ajout>='.$sddb.' AND AD.date_ajout<='.$sdfn.' '; else $where_date='';
	if ( $use_aj!=0 ) $where_user_ajout=' AND AD.nbr_estimation='.$use_aj.' '; else $where_user_ajout='';
	if ( $use_zo!=0 ) $where_user_zone=' AND AD.user_zone='.$use_zo.' '; else $where_user_zone='';
	?>
					<link type="text/css" href="calandar/themes/base/ui.all.css" rel="stylesheet" />
		<!--  				<script type="text/javascript" src="calandar/jquery-1.3.2.js"></script>  -->
					<script type="text/javascript" src="calandar/ui/ui.core.js"></script>
					<script type="text/javascript" src="calandar/ui/ui.datepicker.js"></script>
					<script type="text/javascript" src="calandar/ui/i18n/ui.datepicker-fr.js"></script>
					<link type="text/css" href="calandar/demos.css" rel="stylesheet" />
					<script type="text/javascript">
					    $(function() {
					    $.datepicker.setDefaults($.extend({showMonthAfterYear: false}, $.datepicker.regional['']));
					    $(".datepicker").datepicker($.datepicker.regional['fr']);
					    $('.datepicker').datepicker('option', $.extend({showMonthAfterYear: false},
					    $.datepicker.regional['fr']));
					    });
					</script>
	<?php 
	$form = new formulaire('modele_1','?contenu=devis_admin_envoye_archifier','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Catégorie','cat',$tabCat,$cat);
	$form->select_cu('Département','dep',$tabDep,$dep);
	$form->select_cu('User ajout','use_aj',$tabUseAj,$use_aj);
	$form->select_cu('User zone','use_zo',$tabUseZo,$use_zo);
	$form->vide('<tr><td colspan="2">
				Date de debut : <input class="datepicker" type="text" name="ddb" value="'.$ddb.'" />
				Date de fin : <input value="'.$dfn.'" name="dfn" class="datepicker" type="text" />
				</td></tr>');
	$form->afficher1('Rechercher');
	
	$alert='';
	if ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	if ( isset($_GET['modifier']) ) $alert='<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	
	if ( $dep==0 && $cat==0 )
	{
		$req = $my->req('SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_achat_devis_client_pro DC
							WHERE
								AD.statut_valid_admin=-3
								'.$where_user_ajout.'
								'.$where_user_zone.'
								'.$where_date.'
								AND AD.id=DC.id_devis
								AND DC.statut_achat=-2
								AND AD.stat_suppr=1
							ORDER BY AD.id DESC');
	}
	elseif ( $dep==0 && $cat!=0 )
	{
		$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_details ADS ,
									ttre_achat_devis_client_pro DC
								WHERE
									AD.id=ADS.id_devis
									'.$where_user_ajout.'
									'.$where_user_zone.'
									'.$where_date.'
									AND ADS.id_categ='.$cat.'
									AND AD.statut_valid_admin=-3
									AND AD.id=DC.id_devis
									AND DC.statut_achat=-2
									AND AD.stat_suppr=1
								ORDER BY AD.id DESC');
	}
	elseif ( $dep!=0 && $cat==0 )
	{
		$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_client_part_adresses CPA ,
									ttre_villes_france VF ,
									ttre_departement_france DF,
									ttre_achat_devis_client_pro DC
								WHERE
									DF.departement_id='.$dep.'
									'.$where_user_ajout.'
									'.$where_user_zone.'
									'.$where_date.'
									AND DF.departement_code=VF.ville_departement
									AND VF.ville_id=CPA.ville
									AND CPA.id=AD.id_adresse
									AND AD.statut_valid_admin=-3
									AND AD.id=DC.id_devis
									AND DC.statut_achat=-2
									AND AD.stat_suppr=1
								ORDER BY AD.id DESC');
	}
	elseif ( $dep!=0 && $cat!=0 )
	{
		$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_client_part_adresses CPA ,
									ttre_villes_france VF ,
									ttre_departement_france DF ,
									ttre_achat_devis_details ADS,
									ttre_achat_devis_client_pro DC
								WHERE
									DF.departement_id='.$dep.'
									'.$where_user_ajout.'
									'.$where_user_zone.'
									'.$where_date.'
									AND DF.departement_code=VF.ville_departement
									AND VF.ville_id=CPA.ville
									AND CPA.id=AD.id_adresse
									AND AD.id=ADS.id_devis
									AND ADS.id_categ='.$cat.'
									AND AD.statut_valid_admin=-3
									AND AD.id=DC.id_devis
									AND DC.statut_achat=-2
									AND AD.stat_suppr=1
								ORDER BY AD.id DESC');
	}
	//$req = $my->req('SELECT * FROM ttre_achat_devis D , ttre_achat_devis_client_pro DC WHERE D.id=DC.id_devis AND DC.statut_achat=-2 AND D.statut_valid_admin=-3 ORDER BY D.date_ajout DESC ');
	if ( $my->num($req)>0 )
	{
		$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
		if ( $userprofil['profil']==1 ) { $td_supp='<td class="bouton">Supprimer</td>'; $td_prix='<td>P.U.A <br /> P.D <br /> TVA PRO <br /> TVA ZON <br /> % </td>'; $td_cat=''; }
		else { $td_supp=''; $td_prix=''; $td_cat='<td>Catégorie</td>'; }
		echo'
			'.$alert.'
			<table id="liste_produits">
			<tr class="entete">
				<td>Date de création / Ref</td>
				<td>Date de signature</td>
				<td>Client</td>
				<td>User</td>	
				'.$td_cat.'
				<td>Ville / Département</td>
				'.$td_prix.'
				<td class="bouton">Détail</td>
				'.$td_supp.'
			</tr>
			';
		$various='';
		while ( $ress=$my->arr($req) )
		{
			$res = $my->req_arr('SELECT * FROM ttre_achat_devis D , ttre_achat_devis_client_pro DC WHERE D.id='.$ress['idad'].' AND D.id=DC.id_devis AND DC.statut_achat=-2 AND D.statut_valid_admin=-3 ORDER BY D.date_ajout DESC ');
			
				$detail='';
				
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
				$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
				$batiment = ucfirst(html_entity_decode($temp['batiment']));
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				
				$ress=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
				
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
								<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst(html_entity_decode($reso['nom'])).' '.ucfirst(html_entity_decode($reso['prenom'])).'</dd>
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
				
				$op='';
				$reqsel=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=0 ORDER BY id ASC ');
				while ( $ressel=$my->arr($reqsel) )
				{
					$info_client=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ressel['id_client_pro'].'  ');
					$op.='<option value="'.$ressel['id'].'">'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</option>';
				}
				
				$touscom='';
				$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$res['id_devis'].' ORDER BY date ASC');
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
							<div id="inline'.$res['id_devis'].'" style="width:750px;height:500px;overflow:auto;">
								<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
									'.$detail.'
									<br /><br />
										
									<form method="POST" action="?contenu=devis_admin_envoye_archifier&id='.$res['id_devis'].'" enctype="multipart/form-data" >
										<p>Commentaire devis :
											'.$touscom.'
											<br /> Ajouter commentaire : <textarea name="commentaire" style="width:80%;height:150px;" ></textarea><br /><br />
										</p>
									<input type="checkbox" name="retour"  value="0" > Re - activer le devis<br />
										<br /><br /><input type="submit" value="Modifier" name="modif_prix"/></p>
									</form>	
										
								</div>
							</div>
						</div>
							';
					
				$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
				
				$vd='';
				$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
				$ua =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
				$uz =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['user_zone'].'"');
				if ($res['date_payement']!=0 ) $dvcp=date('d/m/Y',$res['date_payement']); else $dvcp='';
				
				$p1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
				$p2=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$p1['id'].' ');
				
				echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
						<td>'.$dvcp.'</td>
						<td>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</td>
						<td>'.$ua['nom'].' (ajout) / '.$uz['nom'].' (zone)</td>		
						<td>'.$vd.'</td>
						<td>'.number_format($res['prix_achat'],2).' € <br /> '.number_format($p2['prix'],2).' <br /> '.$res['tva_pro'].' % <br /> '.$res['tva_zone'].' %<br />'.$res['note_devis'].' %</td>						
						<td class="bouton"><a class="various1" href="#inline'.$res['id_devis'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir Supprimer ce devis ?\'))
							{window.location=\'?contenu=devis_admin_envoye_archifier&action=supprimer&id='.$res['id_devis'].'\'}" title="Supprimer">
							<img src="img/icone_delete.png" alt="Supprimer" /></a>
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
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>
