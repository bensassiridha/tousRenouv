<?php 
$my = new mysql();


// stat_ajout_zone ?
// 0 : affiché sur ajout et zone
// 1 : affiché sur ajout
// 2 : affiché sur admin


//echo 'es'.(int)('5|4y52');




if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		/*case 'reenvoyer' :
			$my->req('UPDATE ttre_achat_devis_suite SET stat_ajout_zone="0" , stat_devis_attente="0" WHERE id_devis='.$_GET['id']);
			rediriger('?contenu=devis_admin_admin_ajout&stat='.$_GET['stat'].'&reenvoyer=ok');exit;
			break;*/
		case 'detail' :
			if ( isset($_POST['modif_comm_stat']) )
			{
				if ( $_POST['pb']==2 )
					$my->req('UPDATE ttre_achat_devis_suite SET stat_ajout_zone=2 WHERE id_devis='.$_GET['id']);
				else
					$my->req('UPDATE ttre_achat_devis_suite SET stat_devis_attente=0 , stat_ajout_zone=0 WHERE id_devis='.$_GET['id']);
				
				if ( !empty($_POST['commentaire']) )
					$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_user'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
				
				rediriger('?contenu=devis_admin_admin_ajout&stat='.$_GET['stat'].'&modifier=ok');exit;
			}
			//if ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
			$detail='';
			$res=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			
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
					<li>
						<h4>Informations générales</h4>
						<dl>
							<dd>Date Devis : '.date("d-m-Y",$res['date_ajout']).'</dd>
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
					<li></li>
				</ul>
				<div id="espace_compte">
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
						<tr class="entete">
							<td>Désignation</td>														
						</tr>	
					 ';
			$nom_cat='';
			$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ORDER BY ordre_categ ASC ');
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
							<td style="text-align:justify;">'.$ress['piece'].'</td>		
						</tr>
					';
			}
			$detail.='
					</table>
				</div>
						';
			$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
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
			$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ORDER BY date ASC');
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
			
			echo '
					<div id="espace_compte">'.$detail.'</div>
					<form method="POST" action="?contenu=devis_admin_admin_ajout&stat='.$_GET['stat'].'&action=detail&id='.$_GET['id'].'" enctype="multipart/form-data" >
						<p>Commentaire devis :
							'.$touscom.'
							<br /> Ajouter commentaire : <textarea name="commentaire" style="width:80%;height:150px;" ></textarea><br /><br />
						</p>
						<p>Statut devis :<br />
							<input type="radio" name="pb" value="1" checked="checked" >En stand by<br />
							<input type="radio" name="pb" value="0" >Re - envoyer à la répresentant par zone <span style="font-size:10px">( ajouter un commentaire explicatif )</span><br />
							<input type="radio" name="pb" value="2" >Re - envoyer à l\'administrateur <span style="font-size:10px"> ( ajouter un commentaire explicatif )</span><br />
						</p>
						<p><input type="submit" value="Modifier" name="modif_comm_stat" style="margin:0 0 0 110px;"/></p>
					</form>
				';
			break;
		case 'archifier' :
			/*$temp=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			 $my->req('DELETE FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			 $my->req('DELETE FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ');
			 $my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			 $my->req('DELETE FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ');
			 $my->req('DELETE FROM ttre_client_part WHERE id='.$temp['id_client'].' ');
			 $my->req('DELETE FROM ttre_client_part_adresses WHERE id='.$temp['id_adresse'].' ');
			 $req=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			 while ( $res=$my->arr($req) )
			 {
			 @unlink('../upload/devis/'.$res['fichier']);
			 }
			 $my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');*/
			$my->req('UPDATE ttre_achat_devis SET stat_suppr="1" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_admin_admin_ajout&stat='.$_GET['stat'].'&supprimer=ok');
			break;
	}
}
else
{
	if ( $_GET['stat']==1 ) $st='Rdv Pris';
	elseif ( $_GET['stat']==2 ) $st='A rappeler';
	elseif ( $_GET['stat']==3 ) $st='Travau fini';
	elseif ( $_GET['stat']==4 ) $st='Faux numéro';
	elseif ( $_GET['stat']==5 ) $st='Déjà trouver un artisan';
	elseif ( $_GET['stat']==6 ) $st='Autre';
	elseif ( $_GET['stat']==7 ) $st='Pas de travaux';
	elseif ( $_GET['stat']==8 ) $st='Projet abandonné';
	echo '<h1>Statut : '.$st.'</h1>';
	
	
	$tabCat[]='';
	$rq=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
	while ( $rs=$my->arr($rq) ) $tabCat[$rs['id']]=$rs['titre'];
	$tabDep[]='';
	$rq=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	while ( $rs=$my->arr($rq) ) $tabDep[$rs['departement_id']]=$rs['departement_nom'];
	
	if ( isset($_POST['cat']) && !empty($_POST['cat']) ) $cat=$_POST['cat']; else $cat=0;
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
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
					
	$form = new formulaire('modele_1','?contenu=devis_admin_admin_ajout&stat='.$_GET['stat'].'','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Catégorie','cat',$tabCat,$cat);
	$form->select_cu('Département','dep',$tabDep,$dep);
	$form->vide('<tr><td colspan="2">
				Date de debut : <input class="datepicker" type="text" name="ddb" value="'.$ddb.'" />
				Date de fin : <input value="'.$dfn.'" name="dfn" class="datepicker" type="text" />
				</td></tr>');
	$form->afficher1('Rechercher');
		
	if ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	if ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	//if ( isset($_GET['reenvoyer']) ) echo '<div class="success"><p>Ce devis a bien été re-envoyé.</p></div>';
	
	//echo '<p>Pour ajouter un autre devis, cliquer <a href="?contenu=devis_admin_ajouter&action=ajouter">ICI</a></p>';
	
		
	$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
	if ( $user['profil']==3 )
	{
		//echo '<p>Pour ajouter un autre devis, cliquer <a href="?contenu=devis_admin_ajouter&action=ajouter">ICI</a></p>';
		if ( $dep==0 && $cat==0 )
		{
			$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_suite ADSS
								WHERE
									AD.statut_valid_admin=-1
									AND AD.stat_suppr=0
									'.$where_date.'
									AND AD.nbr_estimation='.$_SESSION['id_user'].' 
									AND	AD.id=ADSS.id_devis
									AND	ADSS.stat_ajout_zone=1
									AND ADSS.stat_devis_attente='.$_GET['stat'].'
								ORDER BY AD.id DESC');
		}
		elseif ( $dep==0 && $cat!=0 )
		{
			$req = $my->req('SELECT AD.id as idad
									FROM
										ttre_achat_devis AD ,
										ttre_achat_devis_details ADS ,
										ttre_achat_devis_suite ADSS
									WHERE
										AD.id=ADS.id_devis
										'.$where_date.'
										AND ADS.id_categ='.$cat.'
										AND AD.statut_valid_admin=-1
										AND AD.nbr_estimation='.$_SESSION['id_user'].'
										AND	AD.id=ADSS.id_devis
										AND	ADSS.stat_ajout_zone=1
										AND AD.stat_suppr=0
										AND ADSS.stat_devis_attente='.$_GET['stat'].'
									ORDER BY AD.id DESC');
		}
		elseif ( $dep!=0 && $cat==0 )
		{
			$req = $my->req('SELECT AD.id as idad
									FROM
										ttre_achat_devis AD ,
										ttre_client_part_adresses CPA ,
										ttre_villes_france VF ,
										ttre_departement_france DF ,
										ttre_achat_devis_suite ADSS
									WHERE
										DF.departement_id='.$dep.'
										'.$where_date.'
										AND DF.departement_code=VF.ville_departement
										AND VF.ville_id=CPA.ville
										AND CPA.id=AD.id_adresse
										AND AD.statut_valid_admin=-1
										AND AD.nbr_estimation='.$_SESSION['id_user'].'
										AND	AD.id=ADSS.id_devis
										AND	ADSS.stat_ajout_zone=1
										AND AD.stat_suppr=0
										AND ADSS.stat_devis_attente='.$_GET['stat'].'
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
										ttre_achat_devis_details ADS ,
										ttre_achat_devis_suite ADSS
									WHERE
										DF.departement_id='.$dep.'
										'.$where_date.'
										AND DF.departement_code=VF.ville_departement
										AND VF.ville_id=CPA.ville
										AND CPA.id=AD.id_adresse
										AND AD.id=ADS.id_devis
										AND ADS.id_categ='.$cat.'
										AND AD.statut_valid_admin=-1
										AND AD.nbr_estimation='.$_SESSION['id_user'].'
										AND	AD.id=ADSS.id_devis
										AND	ADSS.stat_ajout_zone=1
										AND AD.stat_suppr=0
										AND ADSS.stat_devis_attente='.$_GET['stat'].'
									ORDER BY AD.id DESC');
		}	
		//$req = $my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_user'].' AND statut_valid_admin=-1 ORDER BY id DESC ');
		if ( $my->num($req)>0 )
		{
			echo'
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Date / Ref</td>
								<td>Client</td>
								<td>Ville / Département</td>
								<td>Prix</td>
								<td class="bouton">Détail</td>
								<td class="bouton">Supprimer</td>
							</tr>
						</thead>
						<tbody> 
				';
			while ( $ress=$my->arr($req) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
				
				$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
				$vd='';
				$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
				echo'
					<tr>
						<td class="nom_prod">'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
						<td class="nom_prod">'.$tempc['nom'].' '.$tempc['prenom'].'</td>
						<td class="nom_prod">'.$vd.'</td>	
						<td class="nom_prod">'.number_format($res['prix_achat'],2).' €</td>					
						<td class="bouton">
							<a href="?contenu=devis_admin_admin_ajout&stat='.$_GET['stat'].'&action=detail&id='.$res['id'].'" target="_blanc">
							<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
						</td>	
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir archiver ce devis ?\')) 
							{window.location=\'?contenu=devis_admin_admin_ajout&stat='.$_GET['stat'].'&action=archifier&id='.$res['id'].'\'}" title="Supprimer">
							<img src="img/icone_delete.png" alt="Supprimer" /></a>
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
			echo '<p>Pas devis .</p>';
		}
	}
	
	
}
?>
<link rel="stylesheet" type="text/css" href="../style_boutique.css" /> 
<script type="text/javascript">
$(document).ready(function() 
{
	$('input[name="radadd"]').change(function ()
	{
		if ( $('input[name="radadd"]:checked').val()==0 ) $('#adresse_chantier').css('display','block');
		else $('#adresse_chantier').css('display','none');
	});
	$('input[name="cpc"]').change(function ()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxVille.php",
			 data: "cp="+$('input[name="cpc"]').val(),
			 success: function(msg)
				{			 
					//alert(msg);
					$('select[name="villec"]').html(msg);
				}
		 });
	});
	$('input[name="cpa"]').change(function ()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxVille.php",
			 data: "cp="+$('input[name="cpa"]').val(),
			 success: function(msg)
				{			 
					//alert(msg);
					$('select[name="villea"]').html(msg);
				}
		 });
	});
	
	/*$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	*/
});

</script>