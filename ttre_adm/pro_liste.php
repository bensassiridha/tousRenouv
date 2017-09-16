<?php
$tab_civ=array('Mr'=>'Mr','Mme'=>'Mme','Mlle'=>'Mlle');
    
    
$my = new mysql();
if ( !empty($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'devis' :
			echo'<h1>Gestion de devis</h1>';
			$req = $my->req('SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_achat_devis_client_pro DC
							WHERE
								AD.statut_valid_admin=-3
								AND AD.id=DC.id_devis
								AND DC.statut_achat=-2
								AND AD.stat_suppr=0
								AND DC.id_client_pro='.$_GET['id'].'
							ORDER BY AD.id DESC');
			
			$req1 = $my->req('SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_achat_devis_client_pro DC
							WHERE
								AD.statut_valid_admin=-3
								AND AD.id=DC.id_devis
								AND DC.statut_achat=-1
								AND AD.stat_suppr=0
								AND DC.id_client_pro='.$_GET['id'].'
							ORDER BY AD.id DESC');
			
			if ( $my->num($req)>0 )
			{
				echo'
					<table id="liste_produits">
					<tr class="entete">
						<td colspan="6"> Devis signés</td>
					</tr>
					<tr class="entete">
						<td>Date de création / Ref</td>
						<td>Date de signature</td>
						<td>Client</td>
						<td>Prix</td>
						<td>Devis</td>
						<td class="bouton">Détail</td>
					</tr>
					';
				while ( $resss=$my->arr($req) )
				{
					$res = $my->req_arr('SELECT * FROM ttre_achat_devis D , ttre_achat_devis_client_pro DC WHERE D.id='.$resss['idad'].' AND D.id=DC.id_devis ');
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
								<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst($reso['nom']).' '.ucfirst($reso['prenom']).'</dd>
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
								<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst($resoo['nom']).' '.ucfirst($resoo['prenom']).'</dd>
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
					$reqsel=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-1 ORDER BY id ASC ');
					while ( $ressel=$my->arr($reqsel) )
					{
						$info_client=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ressel['id_client_pro'].'  ');
						$op.='<option value="'.$ressel['id'].'">'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</option>';
					}
					
					$touscom='';
					$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$res['id_devis'].' ORDER BY date ASC');
					if ( $my->num($reqComm)>0 )
					{
						$touscom.='<p>Commentaire devis :</p><br />
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
											
								'.$touscom.'
										
								</div>
							</div>
						</div>
							';
					
					
					$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
					
					$p1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
					$p2=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$p1['id'].' ');
					
					if ($p1['date_payement']!=0 ) $dvcp=date('d/m/Y',$p1['date_payement']); else $dvcp='';
					$fich='<a href="../upload/devis_client_pro/'.$p2['fichier'].'" target="_blanc">'.$p2['fichier'].'</a><br />';
					
					$pp=$p2['prix']*$res['note_devis']/100;
					echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).' <strong><br />'.$res['reference'].'</strong></td>
						<td>'.$dvcp.'</td>
						<td>'.strtoupper($info_client['nom']).' '.ucfirst($info_client['prenom']).'</td>
						<td>
								HT :'.number_format($pp,2).' €
								<br />TVA :'.$res['tva_pro'].' %
								<br />TTC :'.number_format($pp+$pp*$res['tva_pro']/100,2).' €
						</td>
						<td>'.$fich.'</td>
						<td class="bouton"><a class="various1" href="#inline'.$res['id_devis'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
					</tr>
					';
					
				}
				echo'</table>'.$various;
			}
			
			if ( $my->num($req1)>0 )
			{
				echo'<br /><br />
					<table id="liste_produits">
					<tr class="entete">
						<td colspan="6"> Devis refusés</td>
					</tr>
					<tr class="entete">
						<td>Date de création / Ref</td>
						<td>Date de signature</td>
						<td>Client</td>
						<td>Prix</td>
						<td>Devis</td>
						<td class="bouton">Détail</td>
					</tr>
					';
				while ( $resss=$my->arr($req1) )
				{
					$res = $my->req_arr('SELECT * FROM ttre_achat_devis D , ttre_achat_devis_client_pro DC WHERE D.id='.$resss['idad'].' AND D.id=DC.id_devis ');
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
								<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst($reso['nom']).' '.ucfirst($reso['prenom']).'</dd>
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
								<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst($resoo['nom']).' '.ucfirst($resoo['prenom']).'</dd>
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
					$reqsel=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-1 ORDER BY id ASC ');
					while ( $ressel=$my->arr($reqsel) )
					{
						$info_client=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ressel['id_client_pro'].'  ');
						$op.='<option value="'.$ressel['id'].'">'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</option>';
					}
					
					$touscom='';
					$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$res['id_devis'].' ORDER BY date ASC');
					if ( $my->num($reqComm)>0 )
					{
						$touscom.='<p>Commentaire devis :</p><br />
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
											
								'.$touscom.'
										
								</div>
							</div>
						</div>
							';
					
					
					$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
					
					$p1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
					$p2=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$p1['id'].' ');
					
					
					if ($p1['date_payement']!=0 ) $dvcp=date('d/m/Y',$p1['date_payement']); else $dvcp='';
					$p11=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND id_client_pro='.$_GET['id'].' AND statut_achat=-1 ');
					$p22=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$p11['id'].' ');
					$fich='<a href="../upload/devis_client_pro/'.$p22['fichier'].'" target="_blanc">'.$p22['fichier'].'</a><br />';
					
					$pp=$p2['prix']*$res['note_devis']/100;
							/*	HT :'.number_format($pp,2).' €
								<br />TVA :'.$res['tva_pro'].' %
								<br />TTC :'.number_format($pp+$pp*$res['tva_pro']/100,2).' €*/
					echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).' <strong><br />'.$res['reference'].'</strong></td>
						<td>'.$dvcp.'</td>
						<td>'.strtoupper($info_client['nom']).' '.ucfirst($info_client['prenom']).'</td>
						<td>--</td>
						<td>'.$fich.'</td>
						<td class="bouton"><a class="various1" href="#inline'.$res['id_devis'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
					</tr>
					';
					
				}
				echo'</table>'.$various;
			}
			break;
		case 'envoyer' :	
			$tempo=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_POST['id'].' ');
			$nom=$tempo['nom'];$mail=$tempo['email'];
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
						<p>Bonjour,</p>
						<p>'.$nom.'</p>
						<p>'.$_POST['message'].'</p>
						<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
							<p style="padding-top:10px;">'.$nom_client.'</p>
						</div>
					</div>
				</body>
				</html>
				';
			//$mail_client='bilelbadri@gmail.com';
			/*$sujet = $nom_client.' : Info ';
			$headers = "From: \" ".$nom." \"<".$mail.">\n";
			$headers .= "Reply-To: ".$mail_client."\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			mail($mail,$sujet,$message_html,$headers);*/
			
			$destinataire=$mail;
			//$destinataire='bilelbadri@gmail.com';
			$mail_client='contact@tousrenov.fr';
			$email_expediteur=$mail_client;
			$email_reply=$mail_client;
			$titre_mail=$nom_client;
			$sujet=$nom_client.' : Info ';
			
			$frontiere = '-----=' . md5(uniqid(mt_rand()));
			$headers = 'From: "'.$titre_mail.'"<'.$email_reply.'> '."\n";
			$headers .= 'Return-Path: <'.$email_reply.'>'."\n";
			$headers .= 'MIME-Version: 1.0'."\n";
			$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
			
			$message = '';
			$message .= '--'.$frontiere."\n";
			$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
			$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
			
			$message .= $message_html."\n\n";
			
			// Pièce jointe
			$fileatt = $_FILES['fichier']['tmp_name'];
			$fileatt_name = $_FILES['fichier']['name'];
			if (file_exists($fileatt))
			{
				$file_type = filetype($fileatt);
				$file_size = filesize($fileatt);
			
				$handle = fopen($fileatt, 'r'); // or die('File '.$fileatt_name.'can t be open');
				$content = fread($handle, $file_size);
				$content = chunk_split(base64_encode($content));
				$f = fclose($handle);
			
				$message .= '--'.$frontiere."\r\n";
				$message .= 'Content-Type:'.$file_type.'; name='.$fileatt_name."\r\n";
				$message .= 'Content-Transfer-Encoding: base64'."\r\n";
				$message .= 'Content-Disposition: attachment; filename='.$fileatt_name." \n";
				$message .= $content."\r\n";
			}
			// Fin
			
			$message .= '--'.$frontiere.'--'."\r\n";
			
			mail($destinataire,$sujet,$message,$headers);
			
			
			rediriger('?contenu=pro_liste&envoyer=ok');						
			break;
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$fich1='';
				$handle = new Upload($_FILES['fichier1']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/client_pro/fichiers/');
					if ($handle->processed)
					{
						$fich1  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fich2='';
				$handle = new Upload($_FILES['fichier2']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/client_pro/fichiers/');
					if ($handle->processed)
					{
						$fich2  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fich3='';
				$handle = new Upload($_FILES['fichier3']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/client_pro/fichiers/');
					if ($handle->processed)
					{
						$fich3  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				if ( isset($_POST['newsletter']) ) $val_newsletter=1; else $val_newsletter=0;
				
				$my->req("INSERT INTO ttre_client_pro VALUES('',
									'".time()."' ,
									'".$my->net_input($_POST["juridique"])."',
									'".$my->net_input($_POST["raison"])."',
									'".$my->net_input($_POST["taille"])."',
									'".$my->net_input($_POST["voie"])."',
									'".$my->net_input($_POST["cadresse"])."',
									'".$my->net_input($_POST["cp"])."',
									'".$my->net_input($_POST["ville"])."',
									'".$my->net_input('France')."',
									'".$my->net_input($_POST["sireen"])."',
									'".$my->net_input($_POST["civ"])."',
									'".$_POST["nom"]."',
									'".$_POST["prenom"]."',
									'".$my->net_input($_POST["tel"])."',
									'".$my->net_input($_POST["fax"])."',
									'".$my->net_input($_POST["email"])."',
									'".$my->net_input($fich1)."',
									'".$my->net_input($fich2)."',
									'".$my->net_input($fich3)."',
									'".md5($_POST["pass"])."',
									'".$my->net_input($val_newsletter)."',
									'0',
									'0'
									)");
				
				$idc=mysql_insert_id();
				
				
				foreach ( $_POST['categorie'] as $value )
					$my->req("INSERT INTO ttre_client_pro_categories VALUES('','".$idc."','".$value."')");
				
				foreach ( $_POST['departement'] as $value )
					$my->req("INSERT INTO ttre_client_pro_departements VALUES('','".$idc."','".$value."')");
				
				rediriger('?contenu=pro_liste&ajouter=ok');
				
			}
			else
			{
				if ( ($temp['code_postal']>=75001 && $temp['code_postal']<=75020) || $temp['code_postal']==75116 )
				{
					$res=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal=75001 ');
					$tab_ville[$res['ville_id']]=$res['ville_nom_reel'];
				}
				else
				{
					$option='';
					$req=$my->req('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$temp['code_postal'].' ORDER BY ville_id ASC');
					if ( $my->num($req)>0 )
					{
						while ( $res=$my->arr($req) )
						{
							$tab_ville[$res['ville_id']]=$res['ville_nom_reel'];
						}
					}
				}
		
				$check_activite='';
				$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
				if ( $my->num($reqCat)>0 )
				{
					$i=0;
					while ( $resCat=$my->arr($reqCat) )
					{
						$check_activite.='<input type="checkbox" name="categorie[]" value="'.$resCat['id'].'" /> '.$resCat['titre'].'<br /> ';
					}
				}
		
				$zone_intervention='';
				$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');
				if ( $my->num($reqCat)>0 )
				{
					$i=1;$zone_intervention.='<table>';
					while ( $resCat=$my->arr($reqCat) )
					{
						if ( $i%3==1 ) $zone_intervention.='<tr>';
						$zone_intervention.='<td><input type="checkbox" name="departement[]" value="'.$resCat['departement_id'].'" /> '.$resCat['departement_nom'].'</td>';
						if ( $i%3==0 ) $zone_intervention.='</tr>';
						$i++;
					}
					$zone_intervention.='</table>';
				}
		
				$form = new formulaire('modele_1','','<h2 class="titre_niv2">Ajouter Client :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Forme juridique','juridique','',1);
				$form->text('Raison sociale','raison','',1);
				$form->text('Taille de l\'entreprise','taille','',1);
				$form->text('Numéro et voie','voie','',1);
				$form->text('Complèment d\'adresse','cadresse','',1);
				$form->text('Code Postal','cp','',1);
				$form->select('Ville','ville',$tab_ville);
				$form->text('Numéro de SIREEN','sireen','',1);
				$form->radio_cu('Civilité','civ',$tab_civ,1);
				$form->text('Nom','nom','',1);
				$form->text('Prénom','prenom','',1);
				$form->text('Téléphone','tel','',1);
				$form->text('Fax','fax','',1);
				$form->text('Email','email','',1);
				$form->text('Mot de passe','pass','',1);
				$form->photo('Téléchargement de justificatifs K bis','fichier1');
				$form->photo('Téléchargement d\'assurance décennal','fichier2');
				$form->photo('Autre documents','fichier3');
				$form->vide('<tr><td align="right"><label class="">Votre activité a cochez : </label></td><td>'.$check_activite.'<br /><br /></td></tr>');
				$form->vide('<tr><td align="right"><label class="">Zone d\'intervention : </label></td><td>'.$zone_intervention.'<br /><br /></td></tr>');
				$form->check('Newsletter','newsletter',1,'S\'inscrire à notre newsletter');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=pro_liste">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$cl=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_GET['id'].' ');
				$fich1=$cl['fichier1'];
				$handle = new Upload($_FILES['fichier1']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/client_pro/fichiers/');
					if ($handle->processed)
					{
						@unlink('../upload/client_pro/fichiers/'.$cl['fichier1']);
						$fich1  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fich2=$cl['fichier2'];
				$handle = new Upload($_FILES['fichier2']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/client_pro/fichiers/');
					if ($handle->processed)
					{
						@unlink('../upload/client_pro/fichiers/'.$cl['fichier2']);
						$fich2  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				$fich3=$cl['fichier3'];
				$handle = new Upload($_FILES['fichier3']);
				if ($handle->uploaded)
				{
					$handle->Process('../upload/client_pro/fichiers/');
					if ($handle->processed)
					{
						@unlink('../upload/client_pro/fichiers/'.$cl['fichier3']);
						$fich3  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
					}
				}
				
				if ( isset($_POST['newsletter']) ) $val_newsletter=1; else $val_newsletter=0;
				$my->req('UPDATE ttre_client_pro SET
								juridique		=	"'.$my->net_input($_POST['juridique']).'" ,
								raison			=	"'.$my->net_input($_POST['raison']).'" ,
								taille			=	"'.$my->net_input($_POST['taille']).'" ,
								num_voie		=	"'.$my->net_input($_POST['voie']).'" ,
								cadresse		=	"'.$my->net_input($_POST['cadresse']).'" ,
								code_postal		=	"'.$my->net_input($_POST['cp']).'" ,
								ville			=	"'.$my->net_input($_POST['ville']).'" ,
								num_sireen		=	"'.$my->net_input($_POST['sireen']).'" ,
								civ				=	"'.$my->net_input($_POST['civ']).'" ,
								nom				=	"'.$my->net_input($_POST['nom']).'" ,
								prenom			=	"'.$my->net_input($_POST['prenom']).'" ,
								telephone		=	"'.$my->net_input($_POST['tel']).'" ,
								fax				=	"'.$my->net_input($_POST['fax']).'" ,
								email			=	"'.$my->net_input($_POST['email']).'" ,
								fichier1		=	"'.$my->net_input($fich1).'" ,
								fichier2		=	"'.$my->net_input($fich2).'" ,
								fichier3		=	"'.$my->net_input($fich3).'" ,
								newsletter		=	"'.$my->net_input($val_newsletter).'" ,
								stat_valid_zone	=   "0" ,
								stat_valid_general	=   "0"
							WHERE id = '.$_GET['id'].' ');
				
				$my->req('DELETE FROM ttre_client_pro_categories WHERE id_client='.$_GET['id'].' ');
				foreach ( $_POST['categorie'] as $value )
					$my->req("INSERT INTO ttre_client_pro_categories VALUES('','".$_GET['id']."','".$value."')");
				
				$my->req('DELETE FROM ttre_client_pro_departements WHERE id_client='.$_GET['id'].' ');
				foreach ( $_POST['departement'] as $value )
					$my->req("INSERT INTO ttre_client_pro_departements VALUES('','".$_GET['id']."','".$value."')");
				
				rediriger('?contenu=pro_liste&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				$temp = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_GET['id'].' ');
				if ( isset($_GET['supprfichier1']) )
				{
					@unlink('../upload/client_pro/fichiers/'.$temp['fichier1']);
					$my->req('UPDATE ttre_client_pro SET fichier1="" WHERE id = '.$_GET['id'].' ');
					rediriger('?contenu=pro_liste&action=modifier&id='.$_GET['id'].'&fichiersuppr=ok');
				}
				if ( isset($_GET['supprfichier2']) )
				{
					@unlink('../upload/client_pro/fichiers/'.$temp['fichier2']);
					$my->req('UPDATE ttre_client_pro SET fichier2="" WHERE id = '.$_GET['id'].' ');
					rediriger('?contenu=pro_liste&action=modifier&id='.$_GET['id'].'&fichiersuppr=ok');
				}
				if ( isset($_GET['supprfichier3']) )
				{
					@unlink('../upload/client_pro/fichiers/'.$temp['fichier3']);
					$my->req('UPDATE ttre_client_pro SET fichier3="" WHERE id = '.$_GET['id'].' ');
					rediriger('?contenu=pro_liste&action=modifier&id='.$_GET['id'].'&fichiersuppr=ok');
				}
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Ce client a bien été modifié.</p></div>';
				elseif ( isset($_GET['fichiersuppr']) ) $alert='<div id="note" class="success"><p>Cette fichier a bien été supprimée.</p></div>';
				else $alert='<div id="note"></div>';
				
				if ( ($temp['code_postal']>=75001 && $temp['code_postal']<=75020) || $temp['code_postal']==75116 )
				{
					$res=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal=75001 ');
					$tab_ville[$res['ville_id']]=$res['ville_nom_reel'];
				}
				else
				{
					$option='';
					$req=$my->req('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$temp['code_postal'].' ORDER BY ville_id ASC');
					if ( $my->num($req)>0 )
					{
						while ( $res=$my->arr($req) )
						{
							$tab_ville[$res['ville_id']]=$res['ville_nom_reel'];
						}
					}
				}
				
				$check_activite='';
				$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
				if ( $my->num($reqCat)>0 )
				{
					$i=0;
					while ( $resCat=$my->arr($reqCat) )
					{
						$check='';
						$temp=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$_GET['id'].' AND id_categorie='.$resCat['id'].' ');
						if ( $my->num($temp)>0 )$check='checked="checked"';
						$check_activite.='<input type="checkbox" '.$check.' name="categorie[]" value="'.$resCat['id'].'" /> '.$resCat['titre'].'<br /> ';
					}
				}
				
				$zone_intervention='';
				$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');
				if ( $my->num($reqCat)>0 )
				{
					$i=1;$zone_intervention.='<table>';
					while ( $resCat=$my->arr($reqCat) )
					{
						if ( $i%3==1 ) $zone_intervention.='<tr>';
						$check='';
						$temp=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$_GET['id'].' AND id_departement='.$resCat['departement_id'].' ');
						if ( $my->num($temp)>0 )$check='checked="checked"';
						$zone_intervention.='<td><input type="checkbox" '.$check.' name="departement[]" value="'.$resCat['departement_id'].'" /> '.$resCat['departement_nom'].'</td>';
						if ( $i%3==0 ) $zone_intervention.='</tr>';
						$i++;
					}
					$zone_intervention.='</table>';
				}
				$temp = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_GET['id'].' ');
				if ( $temp['newsletter']==0 ) $news_check=0; else $news_check=1;
				
				
				$form = new formulaire('modele_1','?contenu=pro_liste&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier client :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->text('Forme juridique','juridique','',1,$temp['juridique']);
				$form->text('Raison sociale','raison','',1,$temp['raison']);
				$form->text('Taille de l\'entreprise','taille','',1,$temp['taille']);
				$form->text('Numéro et voie','voie','',1,$temp['num_voie']);
				$form->text('Complèment d\'adresse','cadresse','',1,$temp['cadresse']);
				$form->text('Code Postal','cp','',1,$temp['code_postal']);
				$form->select_cu('Ville','ville',$tab_ville,$temp['ville']);
				$form->text('Numéro de SIREEN','sireen','',1,$temp['num_sireen']);
				$form->radio_cu('Civilité','civ',$tab_civ,$temp['civ']);
				$form->text('Nom','nom','',1,$temp['nom']);
				$form->text('Prénom','prenom','',1,$temp['prenom']);
				$form->text('Téléphone','tel','',1,$temp['telephone']);
				$form->text('Fax','fax','',1,$temp['fax']);
				$form->text('Email','email','',1,$temp['email']);
				if ( !empty($temp['fichier1']) )
				{
					$form->vide('
							<tr><td></td>
								<td><a href="../upload/client_pro/fichiers/'.$temp['fichier1'].'" target="_blanc">'.$temp['fichier1'].'</a>
					            <a href="?contenu=pro_liste&action=modifier&id='.$_GET['id'].'&supprfichier1=1">Supprimer</a></td>
							</tr>
							 ');
				}
				$form->photo('Téléchargement de justificatifs K bis','fichier1');
				if ( !empty($temp['fichier2']) )
				{
					$form->vide('
							<tr><td></td>
								<td><a href="../upload/client_pro/fichiers/'.$temp['fichier2'].'" target="_blanc">'.$temp['fichier2'].'</a>
					            <a href="?contenu=pro_liste&action=modifier&id='.$_GET['id'].'&supprfichier2=1">Supprimer</a></td>
							</tr>
							 ');
				}
				$form->photo('Téléchargement d\'assurance décennal','fichier2');
				if ( !empty($temp['fichier3']) )
				{
					$form->vide('
							<tr><td></td>
								<td><a href="../upload/client_pro/fichiers/'.$temp['fichier3'].'" target="_blanc">'.$temp['fichier3'].'</a>
					            <a href="?contenu=pro_liste&action=modifier&id='.$_GET['id'].'&supprfichier3=1">Supprimer</a></td>
							</tr>
							 ');
				}
				$form->photo('Autre documents','fichier3');
				$form->vide('<tr><td align="right"><label class="">Votre activité a cochez : </label></td><td>'.$check_activite.'<br /><br /></td></tr>');
				$form->vide('<tr><td align="right"><label class="">Zone d\'intervention : </label></td><td>'.$zone_intervention.'<br /><br /></td></tr>');
				$form->check('Newsletter','newsletter',1,'S\'inscrire à notre newsletter',$news_check);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=pro_liste">Retour</a></p>';
			}
			break;
		case 'supprimer' :	
			$my->req('DELETE FROM ttre_client_pro WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_pro_generation_pass WHERE cgp_client_id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_pro_categories WHERE id_client='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_pro_departements WHERE id_client='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_client='.$_GET['id'].' AND statut_achat!=-2 ');
			rediriger('?contenu=pro_liste&supprimer=ok');						
			break;
		case 'valid_zone' :
			$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id="'.$_GET['id'].'"');
			$my->req('UPDATE ttre_client_pro SET stat_valid_zone="'.!$temp['stat_valid_zone'].'" WHERE id="'.$_GET['id'].'"');
			$message = '
						<html>
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>TOUSRENOV</title>
							</head>
			
							<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
								<div id="corps" style="margin:0 auto; width:800px; height:auto;">
									<h1 style="background-color:#687189; color:#FFF; font-size:16px; text-align:center;">TOUSRENOV</h1>
			
									<p> Bonjour,</p>
									<p> Nous vous remercions votre inscription sur le site www.tousrenov.fr .  </p>
									<p> Votre compte vient d etre verifier et activer par notre administrateur.</p>
									<p> Pour y acceder à votre espace en cliquant <a href="http://tousrenov.fr/espace_professionnel.php"> ici </a>  , tapez votre identifiant et votre mot de passe.</p> 
					                <p> Bonne visite</p>
			
									<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
											<p style="padding-top:10px;">
												TOUSRENOV
											</p>
									</div>
								</div>
							</body>
						</html>
					';
			$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id="'.$_GET['id'].'"');
			if ( $temp['stat_valid_zone']==1 )
			{
				$headers = "From: \" TOUSRENOV \"<contact@tousrenov.fr>\n";
				$headers .= "Reply-To: contact@tousrenov.fr\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($temp['email'],'Validation compte',$message,$headers);
			}
			
			
			//--------------------- recherche les devis pour le attribuer ------------------
			if ( $temp['stat_valid_zone']==1 )
			{
				$req_devis=$my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-2 ');
				while ( $res_devis=$my->arr($req_devis) )
				{
					$test1=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res_devis['id'].' AND id_client_pro='.$_GET['id'].' ');
					if ( $test1==0 )
					{
						$info_adresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res_devis['id_adresse']);
						$info_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_adresse['ville']);
						$info_departement=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$info_ville['ville_departement'].' ');
						$req_cpd=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$_GET['id'].' AND id_departement='.$info_departement['departement_id'].' ');
						if ( $my->num($req_cpd)>0 ) // il travaille pour cette zone
						{
							$req=$my->req('SELECT DISTINCT(id_categ) FROM ttre_achat_devis_details WHERE id_devis='.$res_devis['id'].' '); 
							while ( $res=$my->arr($req) ) $tab_devis[]=$res['id_categ'];
							$req=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$_GET['id'].' '); 
							while ( $res=$my->arr($req) ) $tab_client[]=$res['id_categorie'];
							$c=array_intersect($tab_devis,$tab_client);
							if ( $tab_devis === $c )
							{
								$my->req('INSERT INTO ttre_achat_devis_client_pro VALUES("","'.$res_devis['id'].'","'.$_GET['id'].'","","","","","","1")');
								$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_GET['id'].' ');
								$nom=$temp['nom'];$mail=$temp['email'];$tel=$temp['telephone'];
								//-------------- envoie mail -------------------------------
								$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=5 ');//$contenu_email['description']
								
								$suite='<table cellpadding="0" cellspacing="0">';
								$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res_devis['id'].' ORDER BY ordre_categ ASC ');
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
								$rq=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$res_devis['id'].'');
								while( $rs=$my->arr($rq) )
								{
									$message .= '--'.$frontiere."\n";
								
									$file_type = mime_content_type('../upload/devis/'.$rs['fichier'].'');
										
									$message .= 'Content-Type: '.$file_type.'; name="../upload/devis/'.$rs['fichier'].'"'."\n";
									$message .= 'Content-Transfer-Encoding: base64'."\n";
									$message .= 'Content-Disposition:attachement; filename="'.$rs['fichier'].'"'."\n\n";
									$message .= chunk_split(base64_encode(file_get_contents('../upload/devis/'.$rs['fichier'].'')))."\n";
								}
								
								$message .= '--'.$frontiere.'--'."\r\n";
								mail($destinataire,$sujet,$message,$headers);
								//-------------- Fin envoie mail -------------------------------
							}
							
						}
					}
				}
			}
			
			//--------------------------------------------------------------------------------
			
			rediriger('?contenu=pro_liste&modifier=ok');
			exit;
			break;
		case 'valid_general' :
			$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id="'.$_GET['id'].'"');
			$my->req('UPDATE ttre_client_pro SET stat_valid_general="'.!$temp['stat_valid_general'].'" WHERE id="'.$_GET['id'].'"');
			$message = '
						<html>
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>TOUSRENOV</title>
							</head>
			
							<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
								<div id="corps" style="margin:0 auto; width:800px; height:auto;">
									<h1 style="background-color:#687189; color:#FFF; font-size:16px; text-align:center;">TOUSRENOV</h1>
			
									<p> Bonjour,</p>
									<p> Nous vous remercions votre inscription sur le site www.tousrenov.fr .  </p>
									<p> Votre compte vient d etre verifier et activer par notre administrateur.</p>
									<p> Pour y acceder à votre espace en cliquant <a href="http://tousrenov.fr/espace_professionnel.php"> ici </a>  , tapez votre identifiant et votre mot de passe.</p> 
					                <p> Bonne visite</p>
			
									<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
											<p style="padding-top:10px;">
												TOUSRENOV
											</p>
									</div>
								</div>
							</body>
						</html>
					';
			$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id="'.$_GET['id'].'"');
			if ( $temp['stat_valid_general']==1 )
			{
				$headers = "From: \" TOUSRENOV \"<contact@tousrenov.fr>\n";
				$headers .= "Reply-To: contact@tousrenov.fr\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($temp['email'],'Validation compte',$message,$headers);
			}
			
			
			//--------------------- recherche les devis pour le attribuer ------------------
			if ( $temp['stat_valid_general']==1 )
			{
				$t = $my->req('SELECT * FROM ttre_devis WHERE statut_valid_admin="1" ');
				while ( $tt=$my->arr($t) )
				{
					if ( $tt['date_valid_mazad']>time() )
					{
						//---------recherche les client qui travaille sur la meme departement--------
						$devis = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$tt['id']);
						$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
						$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
						$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
						$req = $my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$_GET['id'].' AND id_departement='.$id_departement['departement_id']);
						if ( $my->num($req)>0 )
						{
							//---------recherche les client qui travaille sur les meme categories--------
							$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_devis_details WHERE id_devis='.$devis['id'].' '); while ( $r=$my->arr($q) ) $tab_devis[]=$r['id_categ'];
							while ( $res=$my->arr($req) )
							{
								$tab_client=array();
								$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' '); while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
								$c=array_intersect($tab_devis,$tab_client);
								if ( $tab_devis === $c )
								{
									$my->req('INSERT INTO ttre_devis_client_pro VALUES("","'.$devis['id'].'","'.$res['id_client'].'","","","","","","")');
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
					}
				}
				
				
				$t = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin="1" ');
				while ( $tt=$my->arr($t) )
				{
				
					$suite='<table cellpadding="0" cellspacing="0">';
					$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$tt['id'].' ORDER BY ordre_categ ASC ');
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
					
					$devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$tt['id']);
					$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
					$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
					$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
					$req = $my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$_GET['id'].' AND id_departement='.$id_departement['departement_id']);
					if ( $my->num($req)>0 )
					{
						//---------recherche les client qui travaille sur les meme categories--------
						$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_achat_devis_details WHERE id_devis='.$devis['id'].' '); while ( $r=$my->arr($q) ) $tab_devis[]=$r['id_categ'];
						while ( $res=$my->arr($req) )
						{
							$tab_client=array();
							$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' '); while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
							$c=array_intersect($tab_devis,$tab_client);
							if ( $tab_devis === $c )
							{
								$my->req('INSERT INTO ttre_achat_devis_client_pro VALUES("","'.$devis['id'].'","'.$res['id_client'].'","","","","","","")');
								$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client'].' ');
								$nom=$temp['nom'];$mail=$temp['email'];
								//-------------- envoie mail -------------------------------
								$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=5 ');
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
					
											<p>Bonjour,</p>
											<p>Un particulier vient de déposer une demande de devis correspondant à vos critères.</p>
											<p>Accédez à votre interface <a href="http://tousrenov.fr/espace_professionnel.php"> Espace professionnel</a></p>
											<p>Département : '.$id_departement['departement_nom'].' <p>
											<p>Ville : '.$code_departement['ville_nom_reel'].' <p>
											<p>description des travaux  : <br /> '.$suite.' </p>
											<p>Le client  attend votre appel pour prendre RDV<p>
											<p>Attention : ce contact est disponible au moment de l\'envoi de cet email.
													Il se peut qu\'il ne le soit plus lors de votre connexion, s\'il a été acheté entre temps par un autre Partenaire.<p>
			
											<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
												<p style="padding-top:10px;">
													L\'Equipe Tousrenov <br />
													contact@tousrenov.fr <br />
													09 73 27 20 67 <br />
												</p>
											</div>
										</div>
									</body>
									</html>
									';
								//$mail_client='bilelbadri@gmail.com';
								$sujet = $nom_client.' : Nouveau devis';
								$headers = "From: \" ".$nom." \"<".$mail.">\n";
								$headers .= "Reply-To: ".$mail."\n";
								$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
								mail($mail,$sujet,$message,$headers);
							}
						}
					}
				}
				
			}
				
			//--------------------------------------------------------------------------------
			
			rediriger('?contenu=pro_liste&modifier=ok');
			exit;
			break;
		case 'commentaire' :
			if ( !empty($_POST['commentaire']) )
					$my->req('INSERT INTO ttre_client_pro_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_user'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
			
			$reqComm = $my->req('SELECT * FROM ttre_client_pro_commentaire WHERE id_client='.$_GET['id'].' ORDER BY date ASC');
			if ( $my->num($reqComm)>0 )
			{
				echo'<br /><br />
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
					echo'
								<tr>
									<td>'.$d.'</td>
									<td>'.$u.'</td>
									<td>'.$resComm['commentaire'].'</td>
								</tr>
						';
				}
				echo'
					</tbody>
					</table><br /><br />
					';
			}
			$form = new formulaire('modele_1','','<h2 class="titre_niv2">Ajouter Commentaire :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
			$form->textarea('Commentaire','commentaire');
			$form->afficher('Enregistrer','ajouter');
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des clients professionnels</h1>';
	$tabCat[]='';
	$rq=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
	while ( $rs=$my->arr($rq) ) $tabCat[$rs['id']]=$rs['titre'];
	
	$tabDep[]='';
	$rq=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	while ( $rs=$my->arr($rq) ) $tabDep[$rs['departement_id']]=$rs['departement_nom'];
	
	if ( isset($_POST['cat']) && !empty($_POST['cat']) ) $cat=$_POST['cat']; else $cat=0;
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
	if ( isset($_POST['nom']) && !empty($_POST['nom']) ) $nom=$_POST['nom']; else $nom='';
	if ( isset($_POST['prenom']) && !empty($_POST['prenom']) ) $prenom=$_POST['prenom']; else $prenom='';
	if ( isset($_POST['tel']) && !empty($_POST['tel']) ) $tel=$_POST['tel']; else $tel='';
	if ( isset($_POST['email']) && !empty($_POST['email']) ) $email=$_POST['email']; else $email='';
	if ( isset($_POST['sireen']) && !empty($_POST['sireen']) ) $sireen=$_POST['sireen']; else $sireen='';
	if ( isset($_POST['date']) && !empty($_POST['date']) ) {$date=$_POST['date'];list($j,$m,$a)=explode('/',$_POST['date']);$datet=mktime(0,0,0,$m,$j,$a); } else { $date='';$datet=''; }
	
	$form = new formulaire('modele_1','?contenu=pro_liste','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Catégorie','cat',$tabCat,$cat);
	$form->select_cu('Zone d\'intervention','dep',$tabDep,$dep);
	$form->text('Nom','nom','','',$nom);
	$form->text('Prénom','prenom','','',$prenom);
	$form->text('Tel','tel','','',$tel);
	$form->text('Email','email','','',$email);
	$form->text('Numéro de SIREEN','sireen','','',$sireen);
	$form->text('Date inscription','date','','',$date);
	$form->vide('<tr><td colspan="2">La date d\'inscription doit être sous la forme 30/11/1979</td></tr>');
	$form->afficher1('Rechercher');
	
	if ( isset($_GET['ajouter']) ) echo'<div class="success"><p>Ce client a bien été ajouté.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo'<div class="success"><p>Ce client a bien été supprimé.</p></div>';
	elseif ( isset($_GET['envoyer']) ) echo'<div class="success"><p>Le message a bien été envoyé.</p></div>';
	elseif ( isset($_GET['modifier']) ) echo'<div class="success"><p>Le statut de ce client a bien été modifié.</p></div>';
	
	$where='';
	if ( $nom!='' ) $where.='AND P.nom = "'.$nom.'" ';
	if ( $prenom!='' ) $where.='AND P.prenom = "'.$prenom.'" ';
	if ( $tel!='' ) $where.='AND P.telephone = "'.$tel.'" ';
	if ( $email!='' ) $where.='AND P.email = "'.$email.'" ';
	if ( $sireen!='' ) $where.='AND P.num_sireen = "'.$sireen.'" ';
	if ( $date!='' ) $where.='AND P.date_inscription = '.$datet.' ';
		
	
	echo '<p>Pour ajouter un autre client, cliquer <a href="?contenu=pro_liste&action=ajouter">ICI</a></p>';
	
	
	if ( $dep==0 && $cat==0 )
	{
		$reqz = $my->req('SELECT P.id as idc 
							FROM 
								ttre_client_pro P 
							WHERE 
								P.stat_valid_zone=0 
								'.$where.' 
							ORDER BY P.date_inscription DESC');
		$reqg = $my->req('SELECT P.id as idc 
							FROM 
								ttre_client_pro P 
							WHERE 
								P.stat_valid_general=0 
								'.$where.' 
							ORDER BY P.date_inscription DESC');
		$req1z = $my->req('SELECT P.id as idc 
							FROM 
								ttre_client_pro P 
							WHERE 
								P.stat_valid_zone=1 
								'.$where.' 
							ORDER BY P.date_inscription DESC');
		$req1g = $my->req('SELECT P.id as idc 
							FROM 
								ttre_client_pro P 
							WHERE 
								P.stat_valid_general=1 
								'.$where.' 
							ORDER BY P.date_inscription DESC');
	}
	elseif ( $dep!=0 && $cat==0 )
	{
		$reqz = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D  
								WHERE 
									P.stat_valid_zone=0 
									AND P.id=D.id_client 
									AND D.id_departement='.$dep.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$reqg = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D  
								WHERE 
									P.stat_valid_general=0 
									AND P.id=D.id_client 
									AND D.id_departement='.$dep.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$req1z = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D  
								WHERE 
									P.stat_valid_zone=1 
									AND P.id=D.id_client 
									AND D.id_departement='.$dep.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$req1g = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D  
								WHERE 
									P.stat_valid_general=1 
									AND P.id=D.id_client 
									AND D.id_departement='.$dep.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
	}
	elseif ( $dep==0 && $cat!=0 )
	{
		$reqz = $my->req('SELECT C.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_zone=0 
									AND P.id=C.id_client 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$reqg = $my->req('SELECT C.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_general=0 
									AND P.id=C.id_client 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$req1z = $my->req('SELECT C.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_zone=1 
									AND P.id=C.id_client 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$req1g = $my->req('SELECT C.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_general=1 
									AND P.id=C.id_client 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
	}
	elseif ( $dep!=0 && $cat!=0 )
	{
		$reqz = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_zone=0 
									AND P.id=D.id_client 
									AND P.id=C.id_client 
									AND D.id_departement='.$dep.' 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$reqg = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_general=0 
									AND P.id=D.id_client 
									AND P.id=C.id_client 
									AND D.id_departement='.$dep.' 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$req1z = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_zone=1 
									AND P.id=D.id_client 
									AND P.id=C.id_client 
									AND D.id_departement='.$dep.' 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
		$req1g = $my->req('SELECT D.id_client as idc 
								FROM 
									ttre_client_pro P , 
									ttre_client_pro_departements D , 
									ttre_client_pro_categories C 
								WHERE 
									P.stat_valid_general=1 
									AND P.id=D.id_client 
									AND P.id=C.id_client 
									AND D.id_departement='.$dep.' 
									AND C.id_categorie='.$cat.' 
									'.$where.'
								ORDER BY P.date_inscription DESC');
	}
	
	$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
	if ( $userprofil['profil']==1 || $userprofil['profil']==5 )
	{
		if ( $my->num($reqg)>0 )
		{
			$tdm='';$tds='';
			if ( $userprofil['profil']==1 )	{ $tdm='<td class="bouton">Modifier</td>';$tds='<td class="bouton">Supp.</td>';	}
			echo'
				<table id="liste_produits">
					<tr class="entete">
						<td>ID / Date</td>
						<td>Nom</td>
						<td>Ville / Département</td>
						<td class="bouton">Note</td>
						<td class="bouton">Détail</td>
						<td class="bouton">Statut Zone</td>
						<td class="bouton">Statut General</td>
						<td class="bouton">Devis</td>
						<td class="bouton">Commentaires</td>
						'.$tdm.'
						'.$tds.'
					</tr>';
			$various='';
			while ( $ress=$my->arr($reqg) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['idc'].' ');
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
				$fichier1='---';
				if ( !empty($res['fichier1']) ) $fichier1='<a href="../upload/client_pro/fichiers/'.$res['fichier1'].'" target="_blanc">'.$res['fichier1'].'</a>';
				$fichier2='---';
				if ( !empty($res['fichier2']) ) $fichier2='<a href="../upload/client_pro/fichiers/'.$res['fichier2'].'" target="_blanc">'.$res['fichier2'].'</a>';
				$fichier3='---';
				if ( !empty($res['fichier3']) ) $fichier3='<a href="../upload/client_pro/fichiers/'.$res['fichier3'].'" target="_blanc">'.$res['fichier3'].'</a>';
				$catego='---';
				$reqCat=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id'].' ORDER BY id ASC');
				if ( $my->num($reqCat)>0 )
				{
					$catego='';
					while ( $resCat=$my->arr($reqCat) )
					{
						$res_categorie=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$resCat['id_categorie'].' ');
						$catego.=$res_categorie['titre'].', ';
					}
				}
				$depart='---';
				$reqCat=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' ORDER BY id ASC');
				if ( $my->num($reqCat)>0 )
				{
					$depart='';
					while ( $resCat=$my->arr($reqCat) )
					{
						$res_categorie=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$resCat['id_departement'].' ');
						$depart.=$res_categorie['departement_nom'].', ';
					}
				}
				$various.='
						<div style="display: none;">
							<div id="inline'.$res['id'].'" style="width:90%;overflow:auto;">
								<div id="espace_compte" style="width:90%;">
									<p><strong>Forme juridique : </strong> '.ucfirst(html_entity_decode($res['juridique'])).'</p>
									<p><strong>Raison sociale : </strong> '.ucfirst(html_entity_decode($res['raison'])).'</p>
									<p><strong>Taille de l\'entreprise : </strong> '.ucfirst(html_entity_decode($res['taille'])).'</p>
									<p><strong>Numéro et voie : </strong> '.html_entity_decode($res['num_voie']).'</p>
									<p><strong>Complèment d\'adresse : </strong> '.ucfirst(html_entity_decode($res['cadresse'])).'</p>
									<p><strong>Code postal : </strong> '.html_entity_decode($res['code_postal']).'</p>
									<p><strong>Ville : </strong> '.html_entity_decode($res_ville['ville_nom_reel']).'</p>
									<p><strong>Pays : </strong> '.html_entity_decode($res['pays']).'</p>
									<p><strong>Numéro de SIREEN : </strong> '.html_entity_decode($res['num_sireen']).'</p>
									<p><strong>Civilité : </strong> '.ucfirst(html_entity_decode($res['civ'])).'</p>
									<p><strong>Nom : </strong> '.ucfirst(html_entity_decode($res['nom'])).'</p>
									<p><strong>Prénom : </strong> '.ucfirst(html_entity_decode($res['prenom'])).'</p>
									<p><strong>Téléphone : </strong> '.html_entity_decode($res['telephone']).'</p>
									<p><strong>Fax : </strong> '.html_entity_decode($res['fax']).'</p>
									<p><strong>Email : </strong> '.html_entity_decode($res['email']).'</p>
									<p><strong>Téléchargement de justificatifs K bis : </strong> '.$fichier1.'</p>
									<p><strong>Téléchargement d\'assurance décennal : </strong> '.$fichier2.'</p>
									<p><strong>Autre documents : </strong> '.$fichier3.'</p>
									<p><strong>Votre activité : </strong> '.$catego.'</p>
									<p><strong>Zone d\'intervention : </strong> '.$depart.'</p>
				
				
									<div style="border: 1px solid #000000;margin: 35px 0 0 15px;padding: 10px;width: 100%;">
										<form method="POST" action="?contenu=pro_liste&action=envoyer" enctype="multipart/form-data" >
											<p>Contenu mail : <textarea name="message" style="width:100%;height:200px;" ></textarea><br /><br /></p>
											<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
											<p><input type="file" name="fichier" /></p>
											<p><input type="submit" value="Envoyer" style="margin:0 0 0 110px;"/></p>
										</form>
									</div>
				
				
								</div>
							</div>
						</div>
							';
				$nbr_devis=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
				$detail_note1='<p>Nombre de devis : '.$nbr_devis.' </p>';
				$detail_note='';
				for ( $i=1;$i<=20;$i++ )
				{
					$nbr=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND D.note_devis='.$i.' AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
					$stylenote='';
					$detail_note.='<p>'.$i.' / 20 : '.$nbr.' devis.</p>';
				}
				$various.='
						<div style="display: none;">
							<div id="inlinenote'.$res['id'].'" style="width:200px;overflow:auto;">
								'.$detail_note1.'
								'.$detail_note.'
							</div>
						</div>
						  ';
				
				if ( $res['stat_valid_zone']==1 )
					$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
				else
					$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
				
				if ( $res['stat_valid_general']==1 )
					$a_validg = '<a href="?contenu=pro_liste&action=valid_general&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
				else
					$a_validg = '<a href="?contenu=pro_liste&action=valid_general&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
				
				if ( $res['date_inscription']==0  ) $date='';
				else $date=date('d/m/Y',$res['date_inscription']);
				$vd='';
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$res['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
				
				$tdmm='';
				$tdss='';
				if ( $userprofil['profil']==1 )
				{
					$tdmm='
						<td class="bouton">
							<a href="?contenu=pro_liste&action=modifier&id='.$res['id'].'">
							<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
						</td>
							';
					$tdss='
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce client ?\'))
							{window.location=\'?contenu=pro_liste&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
							<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
						</td>
							';
				}
					
				$nbr=$my->num($my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_client_pro='.$res['id'].' AND statut_achat=-2 '));
				echo'
					<tr>
						<td>'.$res['id'].' <br /> '.$date.'</td>
						<td>'.strtoupper(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</td>
						<td>'.$vd.'</td>
						<td class="bouton"><a class="various1" href="#inlinenote'.$res['id'].'" title="Note"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
						<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
						<td class="bouton">'.$a_validz.'</td>
						<td class="bouton">'.$a_validg.'</td>
						<td class="bouton">
							<a href="?contenu=pro_liste&action=devis&id='.$res['id'].'" title="'.$nbr.' devis" >
							<img src="img/cart.png" alt="Client" border="0"/></a>
						</td>
						<td class="bouton">
							<a href="?contenu=pro_liste&action=commentaire&id='.$res['id'].'">
							<img src="img/icone_edit.png" alt="Commentaires" border="0" /></a>
						</td>
						'.$tdmm.'
						'.$tdss.'
					</tr>
					';
			}
			echo'</table>'.$various;
		}
		
		if ( $my->num($req1g)>0 )
		{
			$tdm='';$tds='';
			if ( $userprofil['profil']==1 )	{ $tdm='<td class="bouton">Modifier</td>';$tds='<td class="bouton">Supp.</td>';	}
			$various='';
			echo'<br /><br />
			<table id="liste_produits">
				<tr class="entete">
					<td>ID / Date</td>
					<td>Nom</td>
					<td>Ville / Département</td>
					<td class="bouton">Note</td>
					<td class="bouton">Détail</td>
					<td class="bouton">Statut Zone</td>
					<td class="bouton">Statut General</td>
					<td class="bouton">Devis</td>
					<td class="bouton">Commentaires</td>
					'.$tdm.'
					'.$tds.'
				</tr>';
			while ( $ress=$my->arr($req1g) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['idc'].' ');
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
				$fichier1='---';
				if ( !empty($res['fichier1']) ) $fichier1='<a href="../upload/client_pro/fichiers/'.$res['fichier1'].'" target="_blanc">'.$res['fichier1'].'</a>';
				$fichier2='---';
				if ( !empty($res['fichier2']) ) $fichier2='<a href="../upload/client_pro/fichiers/'.$res['fichier2'].'" target="_blanc">'.$res['fichier2'].'</a>';
				$fichier3='---';
				if ( !empty($res['fichier3']) ) $fichier3='<a href="../upload/client_pro/fichiers/'.$res['fichier3'].'" target="_blanc">'.$res['fichier3'].'</a>';
				$catego='---';
				$reqCat=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id'].' ORDER BY id ASC');
				if ( $my->num($reqCat)>0 )
				{
					$catego='';
					while ( $resCat=$my->arr($reqCat) )
					{
						$res_categorie=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$resCat['id_categorie'].' ');
						$catego.=$res_categorie['titre'].', ';
					}
				}
				$depart='---';
				$reqCat=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' ORDER BY id ASC');
				if ( $my->num($reqCat)>0 )
				{
					$depart='';
					while ( $resCat=$my->arr($reqCat) )
					{
						$res_categorie=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$resCat['id_departement'].' ');
						$depart.=$res_categorie['departement_nom'].', ';
					}
				}
				$various.='
					<div style="display: none;">
						<div id="inline'.$res['id'].'" style="width:90%;overflow:auto;">
							<div id="espace_compte" style="width:90%;">
								<p><strong>Forme juridique : </strong> '.ucfirst(html_entity_decode($res['juridique'])).'</p>
								<p><strong>Raison sociale : </strong> '.ucfirst(html_entity_decode($res['raison'])).'</p>
								<p><strong>Taille de l\'entreprise : </strong> '.ucfirst(html_entity_decode($res['taille'])).'</p>
								<p><strong>Numéro et voie : </strong> '.html_entity_decode($res['num_voie']).'</p>
								<p><strong>Complèment d\'adresse : </strong> '.ucfirst(html_entity_decode($res['cadresse'])).'</p>
								<p><strong>Code postal : </strong> '.html_entity_decode($res['code_postal']).'</p>
								<p><strong>Ville : </strong> '.html_entity_decode($res_ville['ville_nom_reel']).'</p>
								<p><strong>Pays : </strong> '.html_entity_decode($res['pays']).'</p>
								<p><strong>Numéro de SIREEN : </strong> '.html_entity_decode($res['num_sireen']).'</p>
								<p><strong>Civilité : </strong> '.ucfirst(html_entity_decode($res['civ'])).'</p>
								<p><strong>Nom : </strong> '.ucfirst(html_entity_decode($res['nom'])).'</p>
								<p><strong>Prénom : </strong> '.ucfirst(html_entity_decode($res['prenom'])).'</p>
								<p><strong>Téléphone : </strong> '.html_entity_decode($res['telephone']).'</p>
								<p><strong>Fax : </strong> '.html_entity_decode($res['fax']).'</p>
								<p><strong>Email : </strong> '.html_entity_decode($res['email']).'</p>
								<p><strong>Téléchargement de justificatifs K bis : </strong> '.$fichier1.'</p>
								<p><strong>Téléchargement d\'assurance décennal : </strong> '.$fichier2.'</p>
								<p><strong>Autre documents : </strong> '.$fichier3.'</p>
								<p><strong>Votre activité : </strong> '.$catego.'</p>
								<p><strong>Zone d\'intervention : </strong> '.$depart.'</p>
		
		
								<div style="border: 1px solid #000000;margin: 35px 0 0 15px;padding: 10px;width: 100%;">
									<form method="POST" action="?contenu=pro_liste&action=envoyer" enctype="multipart/form-data" >
										<p>Contenu mail : <textarea name="message" style="width:100%;height:200px;" ></textarea><br /><br /></p>
										<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
										<p><input type="file" name="fichier" /></p>
										<p><input type="submit" value="Envoyer" style="margin:0 0 0 110px;"/></p>
									</form>
								</div>
		
			
							</div>
						</div>
					</div>
						';
				$nbr_devis=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
				$detail_note1='<p>Nombre de devis : '.$nbr_devis.' </p>';
				$detail_note='';
				for ( $i=1;$i<=20;$i++ )
				{
					$nbr=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND D.note_devis='.$i.' AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
					$stylenote='';
					$detail_note.='<p>'.$i.' / 20 : '.$nbr.' devis.</p>';
				}
				$various.='
					<div style="display: none;">
						<div id="inlinenote'.$res['id'].'" style="width:200px;overflow:auto;">
							'.$detail_note1.'
							'.$detail_note.'
						</div>
					</div>
					  ';
		
				if ( $res['stat_valid_zone']==1 )
					$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
				else
					$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
				
				if ( $res['stat_valid_general']==1 )
					$a_validg = '<a href="?contenu=pro_liste&action=valid_general&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
				else
					$a_validg = '<a href="?contenu=pro_liste&action=valid_general&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
		
				if ( $res['date_inscription']==0  ) $date='';
				else $date=date('d/m/Y',$res['date_inscription']);
				$vd='';
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$res['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
		
				$tdmm='';
				$tdss='';
				if ( $userprofil['profil']==1 )
				{
					$tdmm='
					<td class="bouton">
						<a href="?contenu=pro_liste&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
						';
					$tdss='
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce client ?\'))
						{window.location=\'?contenu=pro_liste&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
					</td>
						';
				}
		
				$nbr=$my->num($my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_client_pro='.$res['id'].' AND statut_achat=-2 '));
				echo'
				<tr>
					<td>'.$res['id'].' <br /> '.$date.'</td>
					<td>'.strtoupper(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</td>
					<td>'.$vd.'</td>
					<td class="bouton"><a class="various1" href="#inlinenote'.$res['id'].'" title="Note"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
					<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
					<td class="bouton">'.$a_validz.'</td>
					<td class="bouton">'.$a_validg.'</td>
					<td class="bouton">
						<a href="?contenu=pro_liste&action=devis&id='.$res['id'].'" title="'.$nbr.' devis" >
						<img src="img/cart.png" alt="Client" border="0"/></a>
					</td>
					<td class="bouton">
						<a href="?contenu=pro_liste&action=commentaire&id='.$res['id'].'">
						<img src="img/icone_edit.png" alt="Commentaires" border="0" /></a>
					</td>
					'.$tdmm.'
					'.$tdss.'
				</tr>
				';
			}
			echo'</table>'.$various;
		}
	}
	elseif ( $userprofil['profil']==2 || $userprofil['profil']==6 )
	{
		if ( $my->num($reqz)>0 )
		{
			$various='';
			echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>ID / Date</td>
					<td>Nom</td>
					<td>Ville / Département</td>
					<td class="bouton">Note</td>
					<td class="bouton">Détail</td>
					<td class="bouton">Statut Zone</td>
					<td class="bouton">Devis</td>
					<td class="bouton">Commentaires</td>
				</tr>';
			while ( $ress=$my->arr($reqz) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['idc'].' ');
				$cd=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' '); $test=0;
				while ( $cdd=$my->arr($cd) )
				{
					$z=$my->req('SELECT * FROM ttre_users_zones WHERE zone='.$cdd['id_departement'].' AND id_user='.$_SESSION['id_user'].' ');
					if ( $my->num($z) ) $test=1 ;
				}
				
				if ( $test==1 )
				{
					$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
					$fichier1='---';
					if ( !empty($res['fichier1']) ) $fichier1='<a href="../upload/client_pro/fichiers/'.$res['fichier1'].'" target="_blanc">'.$res['fichier1'].'</a>';
					$fichier2='---';
					if ( !empty($res['fichier2']) ) $fichier2='<a href="../upload/client_pro/fichiers/'.$res['fichier2'].'" target="_blanc">'.$res['fichier2'].'</a>';
					$fichier3='---';
					if ( !empty($res['fichier3']) ) $fichier3='<a href="../upload/client_pro/fichiers/'.$res['fichier3'].'" target="_blanc">'.$res['fichier3'].'</a>';
					$catego='---';
					$reqCat=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id'].' ORDER BY id ASC');
					if ( $my->num($reqCat)>0 )
					{
						$catego='';
						while ( $resCat=$my->arr($reqCat) )
						{
							$res_categorie=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$resCat['id_categorie'].' ');
							$catego.=$res_categorie['titre'].', ';
						}
					}
					$depart='---';
					$reqCat=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' ORDER BY id ASC');
					if ( $my->num($reqCat)>0 )
					{
						$depart='';
						while ( $resCat=$my->arr($reqCat) )
						{
							$res_categorie=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$resCat['id_departement'].' ');
							$depart.=$res_categorie['departement_nom'].', ';
						}
					}
					$various.='
							<div style="display: none;">
								<div id="inline'.$res['id'].'" style="width:90%;overflow:auto;">
									<div id="espace_compte" style="width:90%;">
										<p><strong>Forme juridique : </strong> '.ucfirst(html_entity_decode($res['juridique'])).'</p>
										<p><strong>Raison sociale : </strong> '.ucfirst(html_entity_decode($res['raison'])).'</p>
										<p><strong>Taille de l\'entreprise : </strong> '.ucfirst(html_entity_decode($res['taille'])).'</p>
										<p><strong>Numéro et voie : </strong> '.html_entity_decode($res['num_voie']).'</p>
										<p><strong>Complèment d\'adresse : </strong> '.ucfirst(html_entity_decode($res['cadresse'])).'</p>
										<p><strong>Code postal : </strong> '.html_entity_decode($res['code_postal']).'</p>
										<p><strong>Ville : </strong> '.html_entity_decode($res_ville['ville_nom_reel']).'</p>
										<p><strong>Pays : </strong> '.html_entity_decode($res['pays']).'</p>
										<p><strong>Numéro de SIREEN : </strong> '.html_entity_decode($res['num_sireen']).'</p>
										<p><strong>Civilité : </strong> '.ucfirst(html_entity_decode($res['civ'])).'</p>
										<p><strong>Nom : </strong> '.ucfirst(html_entity_decode($res['nom'])).'</p>
										<p><strong>Prénom : </strong> '.ucfirst(html_entity_decode($res['prenom'])).'</p>
										<p><strong>Téléphone : </strong> '.html_entity_decode($res['telephone']).'</p>
										<p><strong>Fax : </strong> '.html_entity_decode($res['fax']).'</p>
										<p><strong>Email : </strong> '.html_entity_decode($res['email']).'</p>
										<p><strong>Téléchargement de justificatifs K bis : </strong> '.$fichier1.'</p>
										<p><strong>Téléchargement d\'assurance décennal : </strong> '.$fichier2.'</p>
										<p><strong>Autre documents : </strong> '.$fichier3.'</p>
										<p><strong>Votre activité : </strong> '.$catego.'</p>
										<p><strong>Zone d\'intervention : </strong> '.$depart.'</p>
				
				
										<div style="border: 1px solid #000000;margin: 35px 0 0 15px;padding: 10px;width: 100%;">
											<form method="POST" action="?contenu=pro_liste&action=envoyer" enctype="multipart/form-data" >
												<p>Contenu mail : <textarea name="message" style="width:100%;height:200px;" ></textarea><br /><br /></p>
												<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
												<p><input type="file" name="fichier" /></p>
												<p><input type="submit" value="Envoyer" style="margin:0 0 0 110px;"/></p>
											</form>
										</div>
				
				
									</div>
								</div>
							</div>
								';
					$nbr_devis=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
					$detail_note1='<p>Nombre de devis : '.$nbr_devis.' </p>';
					$detail_note='';
					for ( $i=1;$i<=20;$i++ )
					{
						$nbr=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND D.note_devis='.$i.' AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
						$stylenote='';
						$detail_note.='<p>'.$i.' / 20 : '.$nbr.' devis.</p>';
					}
					$various.='
							<div style="display: none;">
								<div id="inlinenote'.$res['id'].'" style="width:200px;overflow:auto;">
									'.$detail_note1.'
									'.$detail_note.'
								</div>
							</div>
							  ';
						
					if ( $res['stat_valid_zone']==1 )
						$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
					else
						$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
						
					if ( $res['date_inscription']==0  ) $date='';
					else $date=date('d/m/Y',$res['date_inscription']);
					$vd='';
					$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$res['ville'].' ');
					$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
					$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
						
					$nbr=$my->num($my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_client_pro='.$res['id'].' AND statut_achat=-2 '));
					echo'
						<tr>
							<td>'.$res['id'].' <br /> '.$date.'</td>
							<td>'.strtoupper(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</td>
							<td>'.$vd.'</td>
							<td class="bouton"><a class="various1" href="#inlinenote'.$res['id'].'" title="Note"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
							<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
							<td class="bouton">'.$a_validz.'</td>
							<td class="bouton">
								<a href="?contenu=pro_liste&action=devis&id='.$res['id'].'" title="'.$nbr.' devis" >
								<img src="img/cart.png" alt="Client" border="0"/></a>
							</td>
							<td class="bouton">
								<a href="?contenu=pro_liste&action=commentaire&id='.$res['id'].'">
								<img src="img/icone_edit.png" alt="Commentaires" border="0" /></a>
							</td>
						</tr>
						';
				}
			}
			echo'</table>'.$various;
		}
		if ( $my->num($req1z)>0 )
		{
			$various='';
			echo'<br /><br />
			<table id="liste_produits">
				<tr class="entete">
					<td>ID / Date</td>
					<td>Nom</td>
					<td>Ville / Département</td>
					<td class="bouton">Note</td>
					<td class="bouton">Détail</td>
					<td class="bouton">Statut Zone</td>
					<td class="bouton">Devis</td>
					<td class="bouton">Commentaires</td>
				</tr>';
			while ( $ress=$my->arr($req1z) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['idc'].' ');
				$cd=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' '); $test=0;
				while ( $cdd=$my->arr($cd) )
				{
					$z=$my->req('SELECT * FROM ttre_users_zones WHERE zone='.$cdd['id_departement'].' AND id_user='.$_SESSION['id_user'].' ');
					if ( $my->num($z) ) $test=1 ;
				}
				
				if ( $test==1 )
				{
					$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
					$fichier1='---';
					if ( !empty($res['fichier1']) ) $fichier1='<a href="../upload/client_pro/fichiers/'.$res['fichier1'].'" target="_blanc">'.$res['fichier1'].'</a>';
					$fichier2='---';
					if ( !empty($res['fichier2']) ) $fichier2='<a href="../upload/client_pro/fichiers/'.$res['fichier2'].'" target="_blanc">'.$res['fichier2'].'</a>';
					$fichier3='---';
					if ( !empty($res['fichier3']) ) $fichier3='<a href="../upload/client_pro/fichiers/'.$res['fichier3'].'" target="_blanc">'.$res['fichier3'].'</a>';
					$catego='---';
					$reqCat=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id'].' ORDER BY id ASC');
					if ( $my->num($reqCat)>0 )
					{
						$catego='';
						while ( $resCat=$my->arr($reqCat) )
						{
							$res_categorie=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$resCat['id_categorie'].' ');
							$catego.=$res_categorie['titre'].', ';
						}
					}
					$depart='---';
					$reqCat=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' ORDER BY id ASC');
					if ( $my->num($reqCat)>0 )
					{
						$depart='';
						while ( $resCat=$my->arr($reqCat) )
						{
							$res_categorie=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$resCat['id_departement'].' ');
							$depart.=$res_categorie['departement_nom'].', ';
						}
					}
					$various.='
							<div style="display: none;">
								<div id="inline'.$res['id'].'" style="width:90%;overflow:auto;">
									<div id="espace_compte" style="width:90%;">
										<p><strong>Forme juridique : </strong> '.ucfirst(html_entity_decode($res['juridique'])).'</p>
										<p><strong>Raison sociale : </strong> '.ucfirst(html_entity_decode($res['raison'])).'</p>
										<p><strong>Taille de l\'entreprise : </strong> '.ucfirst(html_entity_decode($res['taille'])).'</p>
										<p><strong>Numéro et voie : </strong> '.html_entity_decode($res['num_voie']).'</p>
										<p><strong>Complèment d\'adresse : </strong> '.ucfirst(html_entity_decode($res['cadresse'])).'</p>
										<p><strong>Code postal : </strong> '.html_entity_decode($res['code_postal']).'</p>
										<p><strong>Ville : </strong> '.html_entity_decode($res_ville['ville_nom_reel']).'</p>
										<p><strong>Pays : </strong> '.html_entity_decode($res['pays']).'</p>
										<p><strong>Numéro de SIREEN : </strong> '.html_entity_decode($res['num_sireen']).'</p>
										<p><strong>Civilité : </strong> '.ucfirst(html_entity_decode($res['civ'])).'</p>
										<p><strong>Nom : </strong> '.ucfirst(html_entity_decode($res['nom'])).'</p>
										<p><strong>Prénom : </strong> '.ucfirst(html_entity_decode($res['prenom'])).'</p>
										<p><strong>Téléphone : </strong> '.html_entity_decode($res['telephone']).'</p>
										<p><strong>Fax : </strong> '.html_entity_decode($res['fax']).'</p>
										<p><strong>Email : </strong> '.html_entity_decode($res['email']).'</p>
										<p><strong>Téléchargement de justificatifs K bis : </strong> '.$fichier1.'</p>
										<p><strong>Téléchargement d\'assurance décennal : </strong> '.$fichier2.'</p>
										<p><strong>Autre documents : </strong> '.$fichier3.'</p>
										<p><strong>Votre activité : </strong> '.$catego.'</p>
										<p><strong>Zone d\'intervention : </strong> '.$depart.'</p>
				
				
										<div style="border: 1px solid #000000;margin: 35px 0 0 15px;padding: 10px;width: 100%;">
											<form method="POST" action="?contenu=pro_liste&action=envoyer" enctype="multipart/form-data" >
												<p>Contenu mail : <textarea name="message" style="width:100%;height:200px;" ></textarea><br /><br /></p>
												<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
												<p><input type="file" name="fichier" /></p>
												<p><input type="submit" value="Envoyer" style="margin:0 0 0 110px;"/></p>
											</form>
										</div>
				
				
									</div>
								</div>
							</div>
								';
					$nbr_devis=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
					$detail_note1='<p>Nombre de devis : '.$nbr_devis.' </p>';
					$detail_note='';
					for ( $i=1;$i<=20;$i++ )
					{
						$nbr=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND D.note_devis='.$i.' AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
						$stylenote='';
						$detail_note.='<p>'.$i.' / 20 : '.$nbr.' devis.</p>';
					}
					$various.='
							<div style="display: none;">
								<div id="inlinenote'.$res['id'].'" style="width:200px;overflow:auto;">
									'.$detail_note1.'
									'.$detail_note.'
								</div>
							</div>
							  ';
						
					if ( $res['stat_valid_zone']==1 )
						$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
					else
						$a_validz = '<a href="?contenu=pro_liste&action=valid_zone&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
						
					if ( $res['date_inscription']==0  ) $date='';
					else $date=date('d/m/Y',$res['date_inscription']);
					$vd='';
					$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$res['ville'].' ');
					$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
					$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
						
					$nbr=$my->num($my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_client_pro='.$res['id'].' AND statut_achat=-2 '));
					echo'
						<tr>
							<td>'.$res['id'].' <br /> '.$date.'</td>
							<td>'.strtoupper(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</td>
							<td>'.$vd.'</td>
							<td class="bouton"><a class="various1" href="#inlinenote'.$res['id'].'" title="Note"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
							<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
							<td class="bouton">'.$a_validz.'</td>
							<td class="bouton">
								<a href="?contenu=pro_liste&action=devis&id='.$res['id'].'" title="'.$nbr.' devis" >
								<img src="img/cart.png" alt="Client" border="0"/></a>
							</td>
							<td class="bouton">
								<a href="?contenu=pro_liste&action=commentaire&id='.$res['id'].'">
								<img src="img/icone_edit.png" alt="Commentaires" border="0" /></a>
							</td>
						</tr>
						';
				}
			}
			echo'</table>'.$various;
		}
	}
	
}	
?>
<script type="text/javascript">
$(document).ready(function() {
	$(".various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
	$('input[name="cp"]').change(function ()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxVille.php",
			 data: "cp="+$('input[name="cp"]').val(),
			 success: function(msg)
				{			 
					//alert(msg);
					$('select[name="ville"]').html(msg);
				}
		 });
	});
});
</script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.1.css" media="screen" />

<link rel="stylesheet" type="text/css" href="../style_boutique.css" /> 


