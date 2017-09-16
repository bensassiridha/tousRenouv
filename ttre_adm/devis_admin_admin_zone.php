<?php 
$my = new mysql();


// stat_ajout_zone ?
// 0 : affiché sur ajout et zone
// 1 : affiché sur ajout
// 2 : affiché sur admin
// 4 : valider devis

//echo 'es'.(int)('5|4y52');

if ( isset($_GET['sms']) )
{
	require_once 'smsenvoi.php';
	$sms=new smsenvoi();
	$sms->debug=true;
	$cat = $my->req_arr('SELECT * FROM ttre_email WHERE id=8 ');
	$sms->sendSMS('+21652670834',html_entity_decode(strip_tags($cat['description'])));
	
	//$sms->sendSMS('+21652670834','Mon premier SM %0d%0a -test: http://www.smsenvoi.com ');
	//$sms->sendSMS('+33760255461','Mon premier SMS en PHP 1');
	//$sms->sendCALL('+21652670834','Bonjour voici un test');
	//$sms->sendCALL('+33760255461','Bonjour voici un test1');
	
	echo '<pre>';print_r($sms->checkCredits());echo'</pre>';
}



if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'detail' :
			if ( isset($_POST['modif_stat_comm']) )
			{
				if ( $_POST['pbd']==0 )
				{
					$pbb='';$stat_ajout_zone=1;
					if ( $_POST['pb']==1 ) { $pbb='1|'.$_POST['pb1'].'$'.$_POST['pb11']; $stat_ajout_zone=0; }
					elseif ( $_POST['pb']==2 ) { $pbb='2|'.$_POST['pb2'].'$'.$_POST['pb22']; $stat_ajout_zone=0; }
					elseif ( $_POST['pb']==3 ) { $pbb='3|'; $stat_ajout_zone=1; }
					elseif ( $_POST['pb']==4 ) { $pbb='4|'; $stat_ajout_zone=1; }
					elseif ( $_POST['pb']==5 ) { $pbb='5|'; $stat_ajout_zone=1; }
					elseif ( $_POST['pb']==6 ) { $pbb='6|'.$_POST['pb3']; $stat_ajout_zone=0; }
					elseif ( $_POST['pb']==7 ) { $pbb='7|'; $stat_ajout_zone=1; }
					elseif ( $_POST['pb']==8 ) { $pbb='8|'; $stat_ajout_zone=1; }
					$my->req('UPDATE ttre_achat_devis_suite SET stat_devis_attente="'.$pbb.'" , stat_ajout_zone="'.$stat_ajout_zone.'" WHERE id_devis='.$_GET['id']);
				}
				elseif ( $_POST['pbd']==2 )
				{
					$my->req('UPDATE ttre_achat_devis_suite SET stat_ajout_zone=2 WHERE id_devis='.$_GET['id']);
				}
				elseif ( $_POST['pbd']==4 )
				{
					$my->req('UPDATE ttre_achat_devis_suite SET stat_ajout_zone=4 WHERE id_devis='.$_GET['id']);
					//--------------------------------------------Debut Partie validation----------------------------------------
						$tt = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id']);
						$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="-2" WHERE id='.$_GET['id']);
						//---------recherche les client qui travaille sur la meme departement--------
						$devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id']);
						$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
						$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
						$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
						$req = $my->req('SELECT * FROM ttre_client_pro_departements WHERE id_departement='.$id_departement['departement_id']);
						if ( $my->num($req)>0 )
						{
							//---------recherche les client qui travaille sur les meme categories--------
							$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' '); while ( $r=$my->arr($q) ) $tab_devis[]=$r['id_categ'];
							while ( $res=$my->arr($req) )
							{
								$test1=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client'].' ');
								if ( $test1['stat_valid_zone']==1 )
								{
								$tab_client=array();
								$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' '); while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
								$c=array_intersect($tab_devis,$tab_client);
								if ( $tab_devis === $c )
								{
									$my->req('INSERT INTO ttre_achat_devis_client_pro VALUES("","'.$_GET['id'].'","'.$res['id_client'].'","","","","","","1")');
									$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client'].' ');
									$nom=$temp['nom'];$mail=$temp['email'];$tel=$temp['telephone'];
									//-------------- envoie mail -------------------------------
									$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=5 ');//$contenu_email['description']
						
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
										<p>Un nouveau devis a été realisé dans votre zone d\'intervention</p>
										<p>Voici les détails :</p>
										'.$suite.'
										<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
											<p style="padding-top:10px;">'.$nom_client.'</p>
										</div>
									</div>
								</body>
								</html>
								';
									//$mail_client='bilelbadri@gmail.com';
						
									$destinataire=$mail;
									//$destinataire='bilelbadri@gmail.com';
									$email_expediteur=$mail_client;
									$email_reply=$mail_client;
									$titre_mail=$nom_client;
									$sujet=$nom_client.' : Nouveau devis ';
						
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
						
									$cat = $my->req_arr('SELECT * FROM ttre_email WHERE id=7 ');
									if ( $cat['description']==1  && $tel!=0 )
									{
										if ( $tel==52670834 ) $tel='+21652670834';
										else $tel='+33'.$tel;
										$cat = $my->req_arr('SELECT * FROM ttre_email WHERE id=8 ');
											
										require_once 'smsenvoi.php';
										$sms=new smsenvoi();
										$sms->debug=true;
										$sms->sendSMS($tel,html_entity_decode(strip_tags($cat['description'])));
									}
						
								}
							}
							}
						}
						//---------------------------------------------------------------------------
						$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="-2" WHERE id='.$_GET['id']);
					//--------------------------------------------Fin Partie validation----------------------------------------
				}
				
				if ( !empty($_POST['commentaire']) )
					$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_user'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
				//rediriger('?contenu=devis_admin_ajouter&action=detail&id='.$_GET['id'].'&modifier=ok');exit;
				rediriger('?contenu=devis_admin_admin_zone&stat='.$_GET['stat'].'&modifier=ok');exit;
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
			$formsuitezone='';
		
			$pb1='';$pb2='';$pb3='';$pb4='';$pb5='';$pb6='';$pb7='';$pb8='';$d1='';$d11='';$d2='';$d22='';$d3='';
			$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			list($p,$d) = split('[|]',$respb['stat_devis_attente']);
			if ( $p==1 ) { $pb1='checked="checked"'; list($d1,$d11) = split('[$]',$d); }
			elseif ( $p==2 ) { $pb2='checked="checked"'; list($d2,$d22) = split('[$]',$d); }
			elseif ( $p==3 ) { $pb3='checked="checked"'; }
			elseif ( $p==4 ) { $pb4='checked="checked"'; }
			elseif ( $p==5 ) { $pb5='checked="checked"'; }
			elseif ( $p==6 ) { $pb6='checked="checked"'; $d3=$d; }
			elseif ( $p==7 ) { $pb7='checked="checked"'; }
			elseif ( $p==8 ) { $pb8='checked="checked"'; }
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
			$formsuitezone='
					<p><br />Pb devis :<br />
						<input type="radio" name="pb" '.$pb1.' value="1" >RDV pris le <input class="datepicker" name="pb1" type="text" value="'.$d1.'" /> à <input name="pb11" type="text" value="'.$d11.'" /><br />
						<input type="radio" name="pb" '.$pb2.' value="2" >A rappeler verifiez à la date <input class="datepicker" name="pb2" type="text" value="'.$d2.'" /> à <input name="pb22" type="text" value="'.$d22.'" /> <br />
						<input type="radio" name="pb" '.$pb3.' value="3" >Travaux fini<br />
						<input type="radio" name="pb" '.$pb4.' value="4" >Faux numéro<br />
						<input type="radio" name="pb" '.$pb5.' value="5" >Déjà trouver un artisan<br />
						<input type="radio" name="pb" '.$pb7.' value="7" >Pas de travaux<br />
						<input type="radio" name="pb" '.$pb8.' value="8" >Projet abandonné<br /><br /><br />
						<input type="radio" name="pb" '.$pb6.' value="6" >autres <textarea name="pb3" type="text" >'.$d3.'</textarea><br />
					</p>			
				  ';
			
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
					<form method="POST" action="?contenu=devis_admin_admin_zone&stat='.$_GET['stat'].'&action=detail&id='.$_GET['id'].'" enctype="multipart/form-data" >
						'.$formsuitezone.'	
						<p>Commentaire devis : 
							'.$touscom.'	
							<br /> Ajouter commentaire : <textarea name="commentaire" style="width:80%;height:150px;" ></textarea><br /><br />
						</p>
						<p>Statut devis :<br />
							<input type="radio" name="pbd" value="0" checked="checked" >En stand by<br />
							<input type="radio" name="pbd" value="2" >Refuser le devis et envoyer à l\'administrateur <span style="font-size:10px">( ajouter un commentaire explicatif )</span><br />
							<input type="radio" name="pbd" value="4" >Accepter le devis et valider <span style="font-size:10px"> ( ajouter un commentaire explicatif )</span><br />
						</p>
						<p><input type="submit" value="Modifier" name="modif_stat_comm" style="margin:0 0 0 110px;"/></p>
					</form>		
				';
			break;
	}
}
else
{
	if ( $_GET['stat']==1 ) $st='Rdv Pris';
	elseif ( $_GET['stat']==2 ) $st='A rappeler';
	elseif ( $_GET['stat']==3 ) $st='Traveau fini';
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
	$tabUse[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=3  ');
	while ( $rs=$my->arr($rq) ) $tabUse[$rs['id_user']]=$rs['nom'];
	
	if ( isset($_POST['cat']) && !empty($_POST['cat']) ) $cat=$_POST['cat']; else $cat=0;
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
	if ( isset($_POST['use']) && !empty($_POST['use']) ) $use=$_POST['use']; else $use=0;
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
					
	$form = new formulaire('modele_1','?contenu=devis_admin_admin_zone&stat='.$_GET['stat'].'','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Catégorie','cat',$tabCat,$cat);
	$form->select_cu('Département','dep',$tabDep,$dep);
	$form->select_cu('User ajout','use',$tabUse,$use);
	$form->vide('<tr><td colspan="2">
				Date de debut : <input class="datepicker" type="text" name="ddb" value="'.$ddb.'" />
				Date de fin : <input value="'.$dfn.'" name="dfn" class="datepicker" type="text" />
				</td></tr>');
	$form->afficher1('Rechercher');
		
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce devis a bien été ajouté.</p></div>';
	elseif ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	elseif ( isset($_GET['valider']) ) echo '<div class="success"><p>Ce devis a bien été validé.</p></div>';
	
	//echo '<p>Pour ajouter un autre devis, cliquer <a href="?contenu=devis_admin_ajouter&action=ajouter">ICI</a></p>';
	
	$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
	if ( $user['profil']==2|| $user['profil']==6)
	{
		if ( $dep==0 && $cat==0 )
		{
			$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_suite ADSS
								WHERE
									AD.statut_valid_admin=-1
									AND AD.stat_suppr=0
									'.$where_user.'
									'.$where_date.'
									AND	AD.id=ADSS.id_devis
									AND	ADSS.stat_ajout_zone=0
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
										'.$where_user.'
										'.$where_date.'
										AND ADS.id_categ='.$cat.'
										AND AD.statut_valid_admin=-1
										AND	AD.id=ADSS.id_devis
										AND	ADSS.stat_ajout_zone=0
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
										'.$where_user.'
										'.$where_date.'
										AND DF.departement_code=VF.ville_departement
										AND VF.ville_id=CPA.ville
										AND CPA.id=AD.id_adresse
										AND AD.statut_valid_admin=-1
										AND	AD.id=ADSS.id_devis
										AND	ADSS.stat_ajout_zone=0
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
										'.$where_user.'
										'.$where_date.'
										AND DF.departement_code=VF.ville_departement
										AND VF.ville_id=CPA.ville
										AND CPA.id=AD.id_adresse
										AND AD.id=ADS.id_devis
										AND ADS.id_categ='.$cat.'
										AND AD.statut_valid_admin=-1
										AND	AD.id=ADSS.id_devis
										AND	ADSS.stat_ajout_zone=0
										AND AD.stat_suppr=0
										AND ADSS.stat_devis_attente='.$_GET['stat'].'
									ORDER BY AD.id DESC');
		}
		//$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-1 ORDER BY id DESC ');
		if ( $my->num($req)>0 )
		{
			if ( $_GET['stat']==1 ) $drr1='<td>Rdv pris</td>';
			elseif ( $_GET['stat']==2 ) $drr1='<td>A rappeler</td>';
			else $drr1='';
			echo'
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Date / Ref</td>
								'.$drr1.'
								<td>Client</td>
								<td>User</td>
								<td>Ville / Département</td>
								<td class="bouton">Modifier</td>
							</tr>
						</thead>
						<tbody> 
				';
			while ( $ress=$my->arr($req) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
				$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
				
				$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
				$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
				$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['id_user'].' AND zone='.$rs3['departement_id'].' ');
				if ( $my->num($rq1)>0 )
				{
					$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
					$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
					$vd='';
					$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
					$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
					$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
					$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
					
					$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$res['id'].' ');$p='';$d='';
					list($p,$d) = split('[|]',$respb['stat_devis_attente']);
					list($d,$dd) = split('[$]',$d);
					
					if ( $_GET['stat']==1 || $_GET['stat']==2 ) $drr2='<td>'.$d.' à '.$dd.'</td>';
					else $drr2='';
					
					echo'
						<tr>
							<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
							'.$drr2.'
							<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
							<td>'.$u['nom'].'</td>
							<td>'.$vd.'</td>		
							<td class="bouton">
								<a href="?contenu=devis_admin_admin_zone&stat='.$_GET['stat'].'&action=detail&id='.$res['id'].'" target="_blanc">
								<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
							</td>
						</tr>
						';
				}
			}
			echo'
					</tbody> 
					</table>
				';
		}
		else
		{
			echo '<p>Pas devis ...</p>';
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