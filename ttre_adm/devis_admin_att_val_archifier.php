<?php 
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'detail' :
			if ( isset($_GET['choisir']) ) echo '<div class="success"><p>Ce client a bien été choisi.</p></div>';
			echo '<h1 style="margin-top:0;" >Gérer la liste des clients</h1>';
			$req=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ORDER BY id ASC ');
			if ( $my->num($req)>0 )
			{
				$d1=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
				$d2=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$d1['id_client'].' ');
				echo'
						<table id="liste_produits">
						<tr>
							<td><strong><span style="color:red">Num tel client particulier : </span></strong></td>
							<td colspan="3"><strong><span style="color:red">'.$d2['telephone'].'</span></strong></td>
						</tr>
						<tr class="entete">
							<td>Client</td>
							<td>Tel</td>
							<td class="bouton">Choisit</td>
							<td class="bouton">Accepter</td>
						</tr>
						';
				while ( $res=$my->arr($req) )
				{
					if ( $res['statut_achat']==-1 ) // il est dejà choisi
					{
						$a_choisi = '<a>déjà choisi</a>';
						$a_valide = '<a href="?contenu=devis_admin_att_val&action=valider&idadcp='.$res['id'].'&id='.$_GET['id'].'" >Accepter</a>';
					}
					else
					{
						$a_choisi = '<a href="?contenu=devis_admin_att_val&action=choisir&idadcp='.$res['id'].'&id='.$_GET['id'].'" >pas encore choisi</a>';
						$a_valide = '<a></a>';
					}
					$info_client=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client_pro'].'  ');
					echo'
						<tr style="text-align:center;">
							<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
							<td>'.$info_client['telephone'].'</td>
							<td class="bouton">'.$a_choisi.'</td>
							<td class="bouton">'.$a_valide.'</td>
						</tr>
						';
				}
				echo'</table>';
			}
			break;	
		case 'choisir' :
			$my->req('UPDATE ttre_achat_devis_client_pro SET statut_achat="-1" WHERE id='.$_GET['idadcp']);
			//envoie mail
			$suite='<table cellpadding="0" cellspacing="0">';
			$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ORDER BY ordre_categ ASC ');
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
			
			$temp3=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$temp3['id_client'].' ');
			$res_ville_client=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$info_client['ville'].'" ');
			$info_adresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$temp3['id_adresse'].' ');
			$res_ville_adresse=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$info_adresse['ville'].'" ');
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
										<strong>Ville : </strong> '.html_entity_decode($res_ville_client['ville_nom_reel']).'<br />
										<strong>Pays : </strong> '.html_entity_decode($info_client['pays']).'<br />
									</p>
									<p><span style="color:#0495CB;">Détails du l\'adresse du chantier :</span><br />
										<strong>Numéro et voie : </strong> '.html_entity_decode($info_adresse['num_voie']).'<br />
										<strong>N° d\'appartement, Etage, Escalier : </strong> '.html_entity_decode($info_adresse['num_appart']).'<br />
										<strong>Bâtiment, Résidence, Entrée : </strong> '.html_entity_decode($info_adresse['batiment']).'<br />
										<strong>Code postal : </strong> '.html_entity_decode($info_adresse['code_postal']).'<br />
										<strong>Ville : </strong> '.html_entity_decode($res_ville_adresse['ville_nom_reel']).'<br />
										<strong>Pays : </strong> '.html_entity_decode($info_adresse['pays']).'<br />
									</p>
									<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
										<p style="padding-top:10px;">'.$nom_client.'</p>
									</div>
								</div>
							</body>
							</html>
							';
			$temp1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id='.$_GET['idadcp'].' ');
			$temp2=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$temp1['id_client_pro'].' ');
			$destinataire=$temp2['email'];
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
			
			// Pièce jointe
			$rq=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].'');
			while( $rs=$my->arr($rq) )
			{
				$message .= '--'.$frontiere."\n";
			
				$file_type = mime_content_type('../upload/devis/'.$rs['fichier'].'');
					
				$message .= 'Content-Type: '.$file_type.'; name="../upload/devis/'.$rs['fichier'].'"'."\n";
				$message .= 'Content-Transfer-Encoding: base64'."\n";
				$message .= 'Content-Disposition:attachement; filename="'.$rs['fichier'].'"'."\n\n";
				$message .= chunk_split(base64_encode(file_get_contents('../upload/devis/'.$rs['fichier'].'')))."\n";
			}
			// Fin
				
			$message .= '--'.$frontiere.'--'."\r\n";
				
			mail($destinataire,$sujet,$message,$headers);
			
			
			rediriger('?contenu=devis_admin_att_val&action=detail&id='.$_GET['id'].'&choisir=ok');
			break;	
		case 'valider' :
			$my->req('UPDATE ttre_achat_devis_client_pro SET statut_achat="-2" , date_payement="'.time().'" WHERE id='.$_GET['idadcp']);
			$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="-3" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_admin_att_val&valider=ok');
			break;	
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
			$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			//$my->req('UPDATE ttre_achat_devis SET stat_suppr="1" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_admin_att_val_archifier&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Archiver : devis à atribuer</h1>';
	
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
	$tabUse[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=3  ');
	while ( $rs=$my->arr($rq) ) $tabUse[$rs['id_user']]=$rs['nom'];
	$tabUseZo[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=2  ');
	while ( $rs=$my->arr($rq) ) $tabUseZo[$rs['id_user']]=$rs['nom'];
	
	if ( isset($_POST['cat']) && !empty($_POST['cat']) ) $cat=$_POST['cat']; else $cat=0;
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
	if ( isset($_POST['use']) && !empty($_POST['use']) ) $use=$_POST['use']; else $use=0;
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
	if ( $use!=0 ) $where_user=' AND AD.nbr_estimation='.$use.' '; else $where_user='';
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
					
	$form = new formulaire('modele_1','?contenu=devis_admin_att_val_archifier','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Catégorie','cat',$tabCat,$cat);
	$form->select_cu('Département','dep',$tabDep,$dep);
	$form->select_cu('User ajout','use',$tabUse,$use);
	$form->select_cu('User zone','use_zo',$tabUseZo,$use_zo);
	$form->vide('<tr><td colspan="2">
				Date de debut : <input class="datepicker" type="text" name="ddb" value="'.$ddb.'" />
				Date de fin : <input value="'.$dfn.'" name="dfn" class="datepicker" type="text" />
				</td></tr>');
	$form->afficher1('Rechercher');
	
	
	if ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	elseif ( isset($_GET['valider']) ) echo '<div class="success"><p>Ce devis a bien été validé.</p></div>';
	
	if ( $dep==0 && $cat==0 )
	{
		$req = $my->req('SELECT AD.id as idad
							FROM
								ttre_achat_devis AD
							WHERE
								AD.statut_valid_admin=-2
								AND AD.stat_suppr=1
								'.$where_user.'
								'.$where_date.'
							ORDER BY AD.id DESC');
	}
	elseif ( $dep==0 && $cat!=0 )
	{
		$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_details ADS
								WHERE
									AD.id=ADS.id_devis
									'.$where_user.'
									'.$where_date.'
									AND ADS.id_categ='.$cat.'
									AND AD.statut_valid_admin=-2
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
									ttre_departement_france DF
								WHERE
									DF.departement_id='.$dep.'
									'.$where_user.'
									'.$where_date.'
									AND DF.departement_code=VF.ville_departement
									AND VF.ville_id=CPA.ville
									AND CPA.id=AD.id_adresse
									AND AD.statut_valid_admin=-2
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
									ttre_achat_devis_details ADS
								WHERE
									DF.departement_id='.$dep.'
									'.$where_user.'
									'.$where_date.'
									AND DF.departement_code=VF.ville_departement
									AND VF.ville_id=CPA.ville
									AND CPA.id=AD.id_adresse
									AND AD.id=ADS.id_devis
									AND ADS.id_categ='.$cat.'
									AND AD.statut_valid_admin=-2
									AND AD.stat_suppr=1
								ORDER BY AD.id DESC');
	}
	
	//$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-2 ORDER BY id DESC ');
	if ( $my->num($req)>0 )
	{
		$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
		echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Date / Ref</td>
							<td>Client</td>
							<td>User</td>
							<td>Catégorie</td>
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
			
			$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
			$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
			$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
			$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$use_zo.' AND zone='.$rs3['departement_id'].' ');
			if ( $my->num($rq1)>0 || $use_zo==0 )
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
					
					<form method="POST" action="?contenu=devis_admin_att_val_archifier&id='.$res['id'].'" enctype="multipart/form-data" >
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
				
				$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
				
				$vd='';
				$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
				$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
				echo'
					<tr>
						<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
						<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
						<td>'.$u['nom'].'</td>		
						<td>'.$nc.'</td>
						<td>'.$vd.'</td>
						<td>'.number_format($res['prix_achat'],2).' € </td>		
						<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>		
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
							{window.location=\'?contenu=devis_admin_att_val_archifier&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
							<img src="img/icone_delete.png" alt="Supprimer" /></a>
						</td>
					</tr>
					';
			}
		}
		echo'
				</tbody> 
				</table>
			'.$various;
	}
	else
	{
		echo '<p>Pas devis ...</p>';
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
