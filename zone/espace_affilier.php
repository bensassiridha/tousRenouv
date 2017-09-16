<?php
require('inc/session.php');

// ----------------------------------------------------pour la gestion ----------------------------
if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'connexion' :
			if ( isset($_POST['conn_client']) )
			{
				$req=$my->req('SELECT * FROM ttre_users WHERE login="'.$_POST['email_connexion'].'" AND password="'.md5($_POST['mdp_connexion']).'" AND profil=3 AND statut=1 ');
				if ( $my->num($req)==0 )
				{
					header("location:espace_affilier.php?inscrit=erreur");exit;
				}
				else
				{
					$cl=$my->arr($req);
					$_SESSION['id_client_trn_affil']=$cl['id_user'];
					$my->req('INSERT INTO ttre_connection_admin VALUES("","'.$_SESSION['id_client_trn_affil'].'","'.time().'","0","'.time().'")');
					$_SESSION['id_connect_admin'] = mysql_insert_id();
					header("location:espace_affilier.php");exit;
				}
			}
			break;
		case 'inscription' :
			if ( isset($_POST['ajout_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:espace_affilier.php?contenu=inscription&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_users WHERE login="'.$_POST['mail_nouveau'].'"');
					if ( $my->num($req)>0 ) {header("location:espace_affilier.php?contenu=inscription&erreur=mail");exit;}
					else
					{
						$referenceValid = uniqid('R');
						$my->req("INSERT INTO ttre_users VALUES('',
													'".$_POST["nom_nouveau"]."',
													'".$my->net_input($_POST["mail_nouveau"])."',
													'".md5($_POST["pass1_nouveau"])."',
													'3' ,
													'0' 
													)");
						$id=mysql_insert_id();
						$my->req("INSERT INTO ttre_zcoordonnees VALUES('".$my->net_input($id)."',
													'".$my->net_input($_POST["mail_nouveau"])."',
													'".$my->net_input($_POST["telephone_nouveau"])."',
													'affilier'
													)");
						if ( isset($_POST['partenaire']) )
						{
							$req_part=$my->req('SELECT * FROM ttre_partenaire_affi WHERE email="'.$_POST['mail_nouveau'].'" ');
							if ( $my->num($req_part)==0 ) $my->req("INSERT INTO ttre_partenaire_affi VALUES('','".$my->net_input($_POST['mail_nouveau'])."') ");
						}
						else
						{
							$my->req('DELETE FROM ttre_partenaire_affi WHERE email="'.$_POST['mail_nouveau'].'" ');
						}
						
						header("location:espace_affilier.php?inscrit=enattente");exit;			
					}
				}
			}
			break;
		case 'modif_param' :
			if ( !isset($_SESSION['id_client_trn_affil']) ) {header("location:espace_affilier.php");exit;}
			if ( isset($_POST['modif_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:espace_affilier.php?contenu=modif_param&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_users WHERE login="'.$_POST['mail'].'" AND id!='.$_SESSION['id_client_trn_affil'].' ');
					if ( $my->num($req)>0 ) {header("location:espace_affilier.php?contenu=modif_param&erreur=mail");exit;}
					else
					{
						$my->req('UPDATE ttre_users SET 
									nom					=	"'.$_POST['nom'].'" , 
									login				=   "'.$my->net_input($_POST['mail']).'"  ,
									statut				=   "0"  
											WHERE id_user='.$_SESSION['id_client_trn_affil'].'') ;
						$my->req('UPDATE ttre_zcoordonnees SET 
									email				=   "'.$my->net_input($_POST['mail']).'"  ,
									tel					=	"'.$_POST['telephone'].'" 
											WHERE id='.$_SESSION['id_client_trn_affil'].'') ;
						
						if ( isset($_POST['partenaire']) )
						{
							$req_part=$my->req('SELECT * FROM ttre_partenaire_affi WHERE email="'.$_POST['mail_nouveau'].'" ');
							if ( $my->num($req_part)==0 ) $my->req("INSERT INTO ttre_partenaire_affi VALUES('','".$my->net_input($_POST['mail_nouveau'])."') ");
						}
						else
						{
							$my->req('DELETE FROM ttre_partenaire_affi WHERE email="'.$_POST['mail_nouveau'].'" ');
						}
						
						unset ($_SESSION['id_client_trn_affil']);
						header("location:espace_affilier.php?modif=enattente");exit;	
					}
				}
			}
			break;
		case 'modif_mdp' :
			if ( !isset($_SESSION['id_client_trn_affil']) ) {header("location:espace_affilier.php");exit;}
			if ( isset($_POST['modif_mdp']) )
			{
				$can=$my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_client_trn_affil'].'"');
				if ( $can['password']!=md5($_POST['pass']) ){header("location:espace_affilier.php?contenu=modif_mdp&erreur=mdp");exit;}
				else
				{
					$my->req('UPDATE ttre_users SET password="'.md5($_POST['pass1']).'" WHERE id_user='.$_SESSION['id_client_trn_affil'].'') ;
					header("location:espace_affilier.php?modif_mdp=ok");exit;
				}				
			}
			break;
		case 'mdp_perdu' :
			if ( isset($_SESSION['id_client_trn_affil']) ) {header("location:espace_affilier.php");exit;}
			if ( isset($_POST['mdp_perdu']) )
			{
				$rec=$my->req('SELECT * FROM ttre_users WHERE login = "'.$_POST['mail'].'" ');
				if ( $my->num($rec)==0 ){header("location:espace_affilier.php?contenu=mdp_perdu&erreur=mail");exit;}
				else
				{
					$can=$my->arr($rec);
					# Génération d'un mots de passe aléatoire
					$chaine = "abBDEFcdefghijkmnPQRSTUVWXYpqrst23456789"; 
					srand((double)microtime()*1000000); 
					
					$pass = ''; 
					for($i=0; $i<8; $i++) 
					{ 
						$pass .= $chaine[rand()%strlen($chaine)];  
					}
					
					$passBdd = md5($pass);
					$referencePass = uniqid('R');
					
					$my->req('DELETE FROM ttre_users_generation_pass WHERE cgp_client_id='.$can['id_user']);
					$my->req("INSERT INTO ttre_users_generation_pass VALUES('','".$can['id_user']."','".$my->net_input($passBdd)."','".$my->net_input($referencePass)."')");
					$message ='
						<html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
							<title>'.$nom_client.'</title>
						</head>
						
						<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#0066CC; font-size:14px;">
							<div id="en-tete" style="height:40px; width:800px; background-repeat:no-repeat; text-align:right;">
								<p><a href="'.$url_site_client.'/espace_affilier.php">Mon compte</a></p>
							</div>
					
							<div id="corps" style="width:800px; height:auto;">
								<h1 style="background-color:#FBD525; color:#FFF; font-size:16px; text-align:center;">Nouveau mot de passe</h1>
										
								<p>Bonjour,</p>																
								<p>Voici un mail automatique qui vous a été envoyé, suite à votre demande de modification de mots de passe. Vous trouverez dans cet e-mail votre nouveau mots de passe qui sera effectif à partir du moment où vous l\'aurez validé.</p>
								<div id="contenu-corps" style="background-color:#E6E6E6; text-align:center; font-size:14px; padding:10px;">
								
									<p>
										Nouveau mot de passe : '.$pass.'
									<br />
										Si vous avez demandé cette modification, veuillez cliquer sur le lien pour valider votre nouveau mots de passe : <br /> <a href="'.$url_site_client.'/espace_affilier.php?contenu=mdp_perdu&ref='.$referencePass.'">Changement de mots de passe</a>.
									</p>														
								</div>
							</div>
									
							<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">											
								<p style="padding-top:10px;">
									Merci d\'avoir '.$nom_client.'
								</p>											
							</div>
						</body>
						</html>';
					
					$nom = html_entity_decode($can['nom']);
					$email = html_entity_decode($can['login']);
					$sujet = $nom_client.' : Mot de passe perdu';
					$headers = "From: \" ".$nom."  \"<".$email.">\n";
					$headers .= "Reply-To: ".$mail_client."\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
					mail($email,$sujet,$message,$headers);
					header("location:espace_affilier.php?contenu=mdp_perdu&mdpperdu=ok");exit;
				}
			}
			elseif ( isset($_GET['ref']) )
			{
				$ligne=$my->req('SELECT * FROM ttre_users_generation_pass WHERE cgp_reference="'.$_GET['ref'].'"');
				if ( $my->num($ligne)==0 ) {header("location:espace_affilier.php?contenu=mdp_perdu&erreur=mdp");exit;}
				else
				{
					$forget=$my->arr($ligne);
					$req_modif = $my->req ( 'UPDATE ttre_users SET password="'.$my->net_input($forget['cgp_mdp']).'" WHERE id_user = "'.$forget['cgp_client_id'].'"' );
					header("location:espace_affilier.php?valid_mdp=ok");exit;
				}				
			}
			break;	
		case 'devis' :
			if ( !isset($_SESSION['id_client_trn_affil']) ) {header("location:espace_affilier.php");exit;}
			if ( isset($_GET['action']) && $_GET['action']=='ajouter' && isset($_POST['ajouter']) )
			{
				$my->req("INSERT INTO ttre_client_part VALUES('',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'".$my->net_input($_POST["civ"])."',
								'".$_POST["nom"]."',
								'".$_POST["prenom"]."',
								'".$my->net_input($_POST["tel"])."',
								'".$my->net_input($_POST["email"])."',
								'".$my->net_input($_POST["voiec"])."',
								'".$my->net_input($_POST["appc"])."',
								'".$my->net_input($_POST["batc"])."',
								'".$my->net_input($_POST["cpc"])."',
								'".$my->net_input($_POST["villec"])."',
								'".$my->net_input($_POST["paysc"])."',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'--',
								'0',
								'--',
								'-1'
								)");
				$idc=mysql_insert_id();
				
				if ( $_POST['radadd']==1 )
				{
					$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
								'".$my->net_input($idc)."',
								'".$my->net_input($_POST["voiec"])."',
								'".$my->net_input($_POST["appc"])."',
								'".$my->net_input($_POST["batc"])."',
								'".$my->net_input($_POST["cpc"])."',
								'".$my->net_input($_POST["villec"])."',
								'".$my->net_input($_POST["paysc"])."',
								'1'
								)");
					$ida=mysql_insert_id();
				}
				else
				{
					$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
								'".$my->net_input($idc)."',
								'".$my->net_input($_POST["voiea"])."',
								'".$my->net_input($_POST["appa"])."',
								'".$my->net_input($_POST["bata"])."',
								'".$my->net_input($_POST["cpa"])."',
								'".$my->net_input($_POST["villea"])."',
								'".$my->net_input($_POST["paysa"])."',
								'1'
								)");
					$ida=mysql_insert_id();
				}
				
				$reference_devis = uniqid('R');
				$my->req("INSERT INTO ttre_achat_devis VALUES('',
								'".$reference_devis."',
								'".time()."',
								'".$idc."',
								'".$ida."',
								'".$_SESSION['id_client_trn_affil']."',
								'0',
								'0',
								'-1',
								'0',
								'0',
								'0',
								'0'
								)");
				$id_devis = mysql_insert_id();
				
				$my->req('INSERT INTO ttre_achat_devis_suite VALUES("","'.$id_devis.'","0","0")');
				
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) )
				{
					if ( !empty($_POST['cat_'.$res['id'].'']) )
					{
						$or_categ=$res['ordre'];
						$id_categ=$res['id'];
						$titre_categ=$res['titre'];
						$desc_piece=$_POST['cat_'.$res['id'].''];
						$my->req("INSERT INTO ttre_achat_devis_details VALUES('',
										'".$id_devis."',
										'".$or_categ."',
										'".$id_categ."',
										'".$my->net($titre_categ)."',
										'".$my->net_textarea($desc_piece)."'
										)");
					}
				}
				for ( $i=1 ; $i<=5 ; $i++ )
				{
					$handle = new Upload($_FILES['fichier'.$i]);
					if ($handle->uploaded)
					{
						$handle->Process('upload/devis/');
						if ($handle->processed)
						{
							$fichier  = $handle->file_dst_name ;	          // Destination file name
							$handle-> Clean();                           // Deletes the uploaded file from its temporary location
							$my->req("INSERT INTO ttre_achat_devis_fichier_suite VALUES('','".$id_devis."','".$fichier."')");
						}
					}
				}
				
				//--------------------- Envoie SMS --------------------------
				/*$devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$id_devis);
				$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
				$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
				$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
				$req = $my->req('SELECT * FROM ttre_client_pro_departements WHERE id_departement='.$id_departement['departement_id']);
				if ( $my->num($req)>0 )
				{
					$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_achat_devis_details WHERE id_devis='.$id_devis.' ');
					while ( $r=$my->arr($q) )
					{
						$tab_devis[]=$r['id_categ'];
						$qqq=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$r['id_categ'].' ');
						$cccat.=$qqq['titre'].' ,';
					}
					while ( $res=$my->arr($req) )
					{
						$tab_client=array();
						$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' ');
						while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
						$c=array_intersect($tab_devis,$tab_client);
						if ( $tab_devis === $c )
						{
							$temptemp=$my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$id_departement['departement_id'].' ');
							$temp=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$temptemp['id_user'].' ');
							if ( $temp['tel']==52670834 ) $tel='+21652670834';
							else $tel='+33'.$temp['tel'];
								
							$vvville=$code_departement['ville_nom_reel'];
							$dddep=$id_departement['departement_nom'];
							$cpart = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$devis['id_client']);
							$messsms='Merci de contacter "'.$cpart['nom'].'" "'.$cpart['prenom'].'"
									 - Tel : "'.$cpart['telephone'].'" - Catégorie : "'.$cccat.'"
									 - dans la ville "'.$vvville.'" / "'.$dddep.'" ';
								
							require_once 'smsenvoi.php';
							$sms=new smsenvoi();
							$sms->debug=true;
							$sms->sendSMS($tel,$messsms);
						}
					}
				}*/
				
				//-----------------------------------------------------------
				header("location:espace_affilier.php?contenu=devis&ajouter=ok");exit;
				
			}
			elseif ( isset($_GET['action']) && $_GET['action']=='ajouterexel' && isset($_POST['ajouterexel']) )
			{
				$handle = new Upload($_FILES['fichier']);
				if ($handle->uploaded)
				{
					$handle->Process('ttre_adm/fichier_exel/');
					if ($handle->processed)
					{
						$fichier_exel  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
		
						require_once 'Excel/reader.php';
						$data = new Spreadsheet_Excel_Reader();
						$data->setOutputEncoding('CP1251');
						$data->read('ttre_adm/fichier_exel/'.$fichier_exel);
						error_reporting(E_ALL ^ E_NOTICE);
		
			
						for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++)
						{
							$cpc=$data->sheets[0]['cells'][$i][21];
							$villec='';
							
							$test_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$cpc.' AND ville_nom_reel="'.$data->sheets[0]['cells'][$i][22].'" ');
							if ( $test_ville )$villec=$test_ville['ville_id'];
							
							$my->req("INSERT INTO ttre_client_part VALUES('',
										'".$my->net_input('--')."',
										'".$my->net_input('--')."',
										'".$my->net_input('--')."',
										'".$my->net_input($data->sheets[0]['cells'][$i][13])."',
										'".$data->sheets[0]['cells'][$i][14]."',
										'".$data->sheets[0]['cells'][$i][15]."',
										'".$my->net_input($data->sheets[0]['cells'][$i][17])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][16])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][18])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][19])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][20])."',
										'".$my->net_input($cpc)."',
										'".$my->net_input($villec)."',
										'France',
										'".$my->net_input('--')."',
										'".$my->net_input('--')."',
										'--',
										'0',
										'--',
										'-1'
										)");
							$idc=mysql_insert_id();

							if ( empty($data->sheets[0]['cells'][$i][23]) && empty($data->sheets[0]['cells'][$i][24]) &&
									empty($data->sheets[0]['cells'][$i][25]) && empty($data->sheets[0]['cells'][$i][26]) &&
									empty($data->sheets[0]['cells'][$i][27]) )
							{
								$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
											'".$my->net_input($idc)."',
											'".$my->net_input($data->sheets[0]['cells'][$i][18])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][19])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][20])."',
											'".$my->net_input($cpc)."',
											'".$my->net_input($villec)."',
											'France',
											'1'
											)");
							
								$ida=mysql_insert_id();
							}
							else
							{
								$cpa=$data->sheets[0]['cells'][$i][26];
								$villea='';
								$test_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$cpa.' AND ville_nom_reel="'.$data->sheets[0]['cells'][$i][27].'" ');
								if ( $test_ville )$villea=$test_ville['ville_id'];
				
										
								$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
											'".$my->net_input($idc)."',
											'".$my->net_input($data->sheets[0]['cells'][$i][23])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][24])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][25])."',
											'".$my->net_input($cpa)."',
											'".$my->net_input($villea)."',
											'France',
											'1'
											)");
								$ida=mysql_insert_id();
							}
								
							$reference_devis = uniqid('R');
							$my->req("INSERT INTO ttre_achat_devis VALUES('',
										'".$reference_devis."',
										'".time()."',
										'".$idc."',
										'".$ida."',
										'".$_SESSION['id_client_trn_affil']."',
										'0',
										'0',
										'-1',
										'0',
										'0',
										'0',
										'0'
										)");
							$id_devis = mysql_insert_id();
											
							$my->req('INSERT INTO ttre_achat_devis_suite VALUES("","'.$id_devis.'","0","0")');
	
							if ( !empty($data->sheets[0]['cells'][$i][1]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','0','1','".$my->net('Maçonnerie')."','".$my->net_textarea($data->sheets[0]['cells'][$i][1])."')");
							if ( !empty($data->sheets[0]['cells'][$i][2]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','1','2','".$my->net('Menuiserie')."','".$my->net_textarea($data->sheets[0]['cells'][$i][2])."')");
							if ( !empty($data->sheets[0]['cells'][$i][3]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','2','3','".$my->net('Revêtement de sol')."','".$my->net_textarea($data->sheets[0]['cells'][$i][3])."')");
							if ( !empty($data->sheets[0]['cells'][$i][4]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','3','4','".$my->net('Revêtement de murs et plafond')."','".$my->net_textarea($data->sheets[0]['cells'][$i][4])."')");
							if ( !empty($data->sheets[0]['cells'][$i][5]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','4','5','".$my->net('Plomberie')."','".$my->net_textarea($data->sheets[0]['cells'][$i][5])."')");
							if ( !empty($data->sheets[0]['cells'][$i][6]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','5','6','".$my->net('Electricité et enegie renouvlable')."','".$my->net_textarea($data->sheets[0]['cells'][$i][6])."')");
							if ( !empty($data->sheets[0]['cells'][$i][7]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','56','180','".$my->net('toiture')."','".$my->net_textarea($data->sheets[0]['cells'][$i][7])."')");
							if ( !empty($data->sheets[0]['cells'][$i][8]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','57','181','".$my->net('chauffage')."','".$my->net_textarea($data->sheets[0]['cells'][$i][8])."')");
							if ( !empty($data->sheets[0]['cells'][$i][9]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','58','182','".$my->net('piscine')."','".$my->net_textarea($data->sheets[0]['cells'][$i][9])."')");
							if ( !empty($data->sheets[0]['cells'][$i][10]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','59','183','".$my->net('isolation')."','".$my->net_textarea($data->sheets[0]['cells'][$i][10])."')");
							if ( !empty($data->sheets[0]['cells'][$i][11]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','60','184','".$my->net('veranda')."','".$my->net_textarea($data->sheets[0]['cells'][$i][11])."')");
							if ( !empty($data->sheets[0]['cells'][$i][12]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','61','185','".$my->net('Facade')."','".$my->net_textarea($data->sheets[0]['cells'][$i][12])."')");
			
						}//for
					}//$handle processed
				}//$handle uploaded
				header("location:espace_affilier.php?contenu=devis&ajouter=ok");exit;
			}
			elseif ( isset($_GET['action']) && $_GET['action']=='supprimer' )
			{
				$my->req('UPDATE ttre_achat_devis SET stat_suppr="1" WHERE id='.$_GET['id']);
				header("location:espace_affilier.php?contenu=devis&supprimer=ok");exit;
			}
			break;	
		case 'probleme' :
			if ( isset($_GET['action']) && $_GET['action']=='detail' )
			{
				if ( isset($_POST['modif_comm_stat']) )
				{
					if ( $_POST['pb']==2 )
						$my->req('UPDATE ttre_achat_devis_suite SET stat_ajout_zone=2 WHERE id_devis='.$_GET['id']);
					elseif ( $_POST['pb']==0 )
						$my->req('UPDATE ttre_achat_devis_suite SET stat_devis_attente=0 , stat_ajout_zone=0 WHERE id_devis='.$_GET['id']);
				
					if ( !empty($_POST['commentaire']) )
						$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_client_trn_affil'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
				
					header("location:espace_affilier.php?contenu=probleme&stat=".$_GET['stat']."&modifier=ok");exit;
				}
			}
			elseif ( isset($_GET['action']) && $_GET['action']=='supprimer' )
			{
				$my->req('UPDATE ttre_achat_devis SET stat_suppr="1" WHERE id='.$_GET['id']);
				header("location:espace_affilier.php?contenu=probleme&stat=".$_GET['stat']."&supprimer=ok");exit;
			}
			break;	
		case 'deconnexion' :
			if ( isset($_SESSION['id_connect_admin']) )
			{
				$my->req('UPDATE ttre_connection_admin SET fin="'.time().'" WHERE id = '.$_SESSION['id_connect_admin'].' ' );
			}
			unset ($_SESSION['id_client_trn_affil']);
			header("location:espace_affilier.php");exit;
			break;	
	}
}


$pageTitle = "Espace Affilier | Devis gratuit en ligne et sans aucun engagement"; 
 include('inc/head.php');?>
	<body id="">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
				<div class="wrapper">
					<div class="particulier-space">
						<div class="container">
							<div class="row">
							<div class="col-md-12">
								<h2>Espace Affilier</h2>
								<h5>Gérer toutes vos informations personnelles</h5>
								<div class="formulaire">
									<h6>Formulaire</h6>
										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a target="_blanc" href="upload/fichiers/'.$res['fichier'].'" target="_blanc">'.$res['titre'].'</a></li>';
												}
											}
										?>
										
										</ul>
								</div>  
							</div>
							</div>
						</div>
					</div>

					<div id="content">
						<div class="container">
							<div class="row">
								<div class="espace-particulier col-md-12">





<script type="text/javascript">
$(document).ready(function() {								

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
	$('input[name="radadd"]').change(function ()
	{
		if ( $('input[name="radadd"]:checked').val()==0 ) $('#adresse_chantier').css('display','block');
		else $('#adresse_chantier').css('display','none');
	});
	$('form[name="client_conn"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.email_connexion.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail !</p>'; }
		/*else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.email_connexion.value))) { mes_erreur+='<p>Votre Adresse mail est incorrect !</p>'; } }*/
		if( !$.trim(this.mdp_connexion.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});
	$('form[name="client_ajout"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.nom_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.telephone_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Téléphone !</p>'; }
		if( !$.trim(this.mail_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mail_nouveau.value))) { mes_erreur+='<p>Votre Adresse mail est incorrect !</p>'; } }
		if( !$.trim(this.mailc_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail de confirmation !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mailc_nouveau.value))) { mes_erreur+='<p>Votre Adresse mail de confirmation est incorrect !</p>'; } }
		if( $.trim(this.mail_nouveau.value)!=$.trim(this.mailc_nouveau.value) ) { mes_erreur+='<p>Erreur de confirmation Mail !</p>'; }
		if( !$.trim(this.pass1_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe !</p>'; }
		if( !$.trim(this.pass2_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe de confirmation !</p>'; }
		if( $.trim(this.pass1_nouveau.value)!=$.trim(this.pass2_nouveau.value) ) { mes_erreur+='<p>Erreur de confirmation Mot de passe !</p>'; }
		if( !$.trim(this.validation.value) ) { mes_erreur+='<p>Il faut entrer le champ code de validation !</p>'; }
		if ( !$('#condition').is(':checked') ){ mes_erreur+='<p>Il faut accepter les condition générales !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});
	$('form[name="client_modif"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.nom.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.telephone.value) ) { mes_erreur+='<p>Il faut entrer le champ Téléphone !</p>'; }
		if( !$.trim(this.mail.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mail.value))) { mes_erreur+='<p>Votre Adresse mail est incorrect !</p>'; } }
		if( !$.trim(this.mailc.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail de confirmation !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mailc.value))) { mes_erreur+='<p>Votre Adresse mail de confirmation est incorrect !</p>'; } }
		if( $.trim(this.mail.value)!=$.trim(this.mailc.value) ) { mes_erreur+='<p>Erreur de confirmation Mail !</p>'; }
		if( !$.trim(this.validation.value) ) { mes_erreur+='<p>Il faut entrer le champ code de validation !</p>'; }
		if ( !$('#condition').is(':checked') ){ mes_erreur+='<p>Il faut accepter les condition générales !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});
	$('form[name="mdp_modif"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.pass.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe actuel !</p>'; }
		if( !$.trim(this.pass1.value) ) { mes_erreur+='<p>Il faut entrer le champ Nouveau mot de passe !</p>'; }
		if( !$.trim(this.pass2.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe de confirmation !</p>'; }
		if( $.trim(this.pass1.value)!=$.trim(this.pass2.value) ) { mes_erreur+='<p>Erreur Vérifiaction du mot de passe !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
	$('form[name="perdu_mdp"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.mail.value) ) { mes_erreur+='<p>Il faut entrer le champ Email !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mail.value))) { mes_erreur+='<p>Votre Email est incorrect !</p>'; } }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});				
});
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script> 	
	
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.1.css" media="screen" />
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
	$("a#various3").fancybox({
		'width'				: '100%',
		'height'			: '100%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
</script>


<!-- echo'
	<div id="espace_compte">
		<p id="compte_ariane">
			<cite>Vous êtes ici : </cite>
			'.$varAriane.'
		</p>
	</div>
	'; -->


<?php



if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'inscription' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est déjà associé à un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erroné.</p></div><br />';
					
			echo'
				'.$alert.'
				<div class="col-md-12" >
					<form name="client_ajout" action="espace_affilier.php?contenu=inscription" method="post" enctype="multipart/form-data" >
					<div class="container">
						<div class="row">
							<div class="col-md-12">
						
								
						<div class="form-groupe-part ">
							<div class="title-info"><h1>Informations personnelles</h1></div>
								<label for="ip_nom">Nom : <span class="obli">*</span></label><br />
									<input id="ip_nom" type="text" name="nom_nouveau" placeholder="Nom"/><br />
								<label for="ip_tel">Téléphone : <span class="obli">*</span></label><br />
									<input id="ip_tel" type="text" name="telephone_nouveau" placeholder="Téléphone"/><br />
								<label for="ip_mail">E-mail : <span class="obli">*</span></label><br />
									<input id="ip_mail" type="text" name="mail_nouveau" oncopy="return false;" onpaste="return false;" placeholder="E-mail"/><br />
								<label for="ip_mail">Confirmation de E-mail : <span class="obli">*</span></label><br />
									<input id="ip_mail" type="text" name="mailc_nouveau" oncopy="return false;" onpaste="return false;" placeholder="Email de confirmation"/><br />
								<label for="ip_mdp">Mot de passe : </label><br />
									<input id="ip_mdp" type="password" name="pass1_nouveau" placeholder="Mot de passe"/><br />
								<label for="verif_mdp">Cofirmation de mot de passe : </label><br />
									<input id="verif_mdp" type="password" name="pass2_nouveau" placeholder="Mot de passe de confirmation"/><br />
								<div class="valid">
									<label for="validation" >Veuillez recopier le code <img src="../Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
									<input id="validation" type="text" name="validation" class="text-valid" />
								</div>		
								<p>
									<input type="checkbox" name="partenaire" checked="checked" /> Acceptation de recevoir offres partenaire
								</p>
								<p>
									<input type="checkbox" name="condition" id="condition"/> Acceptation des <a href="mention.php#affi" target="_blanc" title="Conditions générales"> conditions générales </a>
								</p>
							
								<p class="align_center padding_tb_20">
									<input value="valider" class="sub" type="submit" name="ajout_client"/>
								</p>
								<p class="note" id="text_erreur"><cite>( * ) champs obligatoires.</cite></p>
							</div>
						</div>
							
						</div>
						</div>
						</div>
					</form>	
					<p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p>
				</div>
							
				';			
			break;
		case 'modif_param' :
			$cl=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$_SESSION['id_client_trn_affil'].' ');
			$cll=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$_SESSION['id_client_trn_affil'].' ');
			
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est déjà associé à un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erroné.</p></div><br />';
				
			$req_part=$my->req('SELECT * FROM ttre_partenaire_affi WHERE email="'.$cl['email'].'" ');
			if ( $my->num($req_part)==0 ) $part_check=''; else $part_check='checked="checked"';
			
			echo'
				'.$alert.'
				<div class="col-md-12">
					<form name="client_modif" action="espace_affilier.php?contenu=modif_param" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
							<div class="form-groupe-part ">
									<div class="title-info"><h1>Informations personnelles</h1></div>
										<p>
											<label for="ip_nom">Nom : <span class="obli">*</span></label>
											<input id="ip_nom" type="text" name="nom" value="'.$cl['nom'].'" />
										</p>
										<p>
											<label for="ip_tel">Téléphone : <span class="obli">*</span></label>
											<input id="ip_tel" type="text" name="telephone" value="'.$cll['tel'].'"/>
										</p>
										<p>
											<label for="ip_mail">Email : <span class="obli">*</span></label>
											<input id="ip_mail" type="text" value="'.$cll['email'].'" name="mail" oncopy="return false;" onpaste="return false;"/>
										</p>
										<p>
											<label for="ip_mail">Email de confirmation : <span class="obli">*</span></label>
											<input id="ip_mail" type="text" value="'.$cll['email'].'" name="mailc" oncopy="return false;" onpaste="return false;"/>
										</p>
										<div class="valid">
											<label for="validation">Veuillez recopier le code <img src="../Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
											<input id="validation" type="text" name="validation" />
										</div>	
										<p>
											<input type="checkbox" name="partenaire" '.$part_check.' /> Acceptation de recevoir offres partenaire
										</p>
										<p>
											<input type="checkbox" name="condition" id="condition"/> Acceptation des <a  href="mention.php#affi" target="_blanc" title="Conditions générales"> conditions générales </a>
										</p>
										
										<p class="align_center padding_tb_20">
											<input value="valider" class="sub" type="submit" name="modif_client"/>
										</p>
										<p class="note" id="text_erreur"><cite>( * ) champs obligatoires.</cite></p>
						
						</div>
						</div>
						</div>
						</div>
					</form>	
					<p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p>
				</div>
				';
			break;
		case 'modif_mdp' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) )$alert='<div id="note" class="error"><p>Votre ancien mot de passe est incorrecte, merci de ré-essayer.</p></div><br />';
			echo'
				'.$alert.'
				<div class="col-md-12">
					<form name="mdp_modif" method="post" class="">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div class="form-groupe-part ">
										<div class="title-info"><h1>Nouveau mot de passe</h1></div>
											<p>
												<label for="mdp">Mot de passe actuel : <span class="obli">*</span></label>
												<input id="mdp" type="password" name="pass" placeholder="Mote de passe actuel" />
											</p>
											<p>
												<label for="mdpp">Nouveau mot de passe : <span class="obli">*</span></label>
												<input id="mdpp" type="password" name="pass1" placeholder="Nouveaux mot de passe" />
											</p>
											<p>
												<label for="verif_mdp">Confirmer nouveau mot de passe : <span class="obli">*</span></label>
												<input id="verif_mdp" type="password" name="pass2" placeholder="Confirmer nouveau mot de passe"/>
											</p>							
											<p class="align_center padding_tb_20">
												<input value="Modifier mon mot de passe" type="submit" name="modif_mdp"/>
											</p>
											<p class="note" id="text_erreur"><cite>( * ) Champs Obligatoires.</cite></p>
									</div>
								</div>
							</div>
						</div>
					</form>	
					<p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p>
				</div>
				';
			break;
		case 'mdp_perdu' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Cette adresse email n\'existe pas dans notre base !</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mdp' ) $alert='<div id="note" class="error"><p>Changement Annulé.</p></div><br />';
			if ( isset($_GET['mdpperdu']) ) $alert='<div id="note" class="success"><p>Un nouveau mot de passe vous a été envoyé, vous devez maintenant le valider pour pouvoir vous connecter sur notre site.</p></div><br />';
			echo'
				'.$alert.'
				<div id="espace_compte">
					<form name="perdu_mdp" method="post" action="espace_affilier.php?contenu=mdp_perdu" class="tpl_form_defaut intitules_moyens champs_larges" >
					<fieldset>
						<legend>Nouveau mot de passe : </legend>
						<p>
							<label for="ip_mail">Email : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" name="mail"/>
						</p>
						<p class="align_center padding_tb_20">
							<input value="Envoyer" type="submit" name="mdp_perdu"/>
						</p>
						<p class="note" id="text_erreur"><cite>( * ) Champs Obligatoires.</cite></p>
					</fieldset>
					</form>	
					<p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p>
				</div>
				';		
			break;	
		case 'devis' :
			if ( isset($_GET['action']) && $_GET['action']=='ajouterexel' )
			{
				echo'
					<div class="col-md-12">
						<form name="" method="post" class="" enctype="multipart/form-data" >
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="form-groupe-part ">
											<div class="title-info"><h1>Ajouter devis</h1></div>
												<p>
													Template ( télécharger et le remplir ) : <a href="ttre_adm/template.xls" target="_blanc">template.xls</a>
												</p>
												<p>
													<label for="fiche">Fichier Exel : </label>
													<input id="fiche" type="file" name="fichier" />
												</p>
												<p class="align_center padding_tb_20">
													<input value="Ajouter" type="submit" name="ajouterexel"/>
												</p>
												<p class="note" id="text_erreur"><cite>( * ) Champs Obligatoires.</cite></p>
										</div>
									</div>
								</div>
							</div>
						</form>
						<p class="margin_top_20"><a href="espace_affilier.php?contenu=devis">Retour à la page précédente</a></p>
					</div>
				'	;
			}
			elseif ( isset($_GET['action']) && $_GET['action']=='ajouter' )
			{
				$alert='<div id="note"></div><br />';
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');$cat='';
				while ( $res=$my->arr($req) )
				{
					$cat.='
							<p>
								<label for="cat'.$res['id'].'">'.$res['titre'].' : </label>
								<input id="cat'.$res['id'].'" type="text" name="cat_'.$res['id'].'" />
							</p>
						  ';
				}
				$fiche='';
				for ( $i=1 ; $i<=5 ; $i++ )
				{
					$fiche.='
							<p>
								<label for="fiche'.$i.'">Fichier '.$i.' : </label>
								<input id="fiche'.$i.'" type="file" name="fichier'.$i.'" />
							</p>
						  ';
				}
				echo'
					'.$alert.'
					<div class="col-md-12">
						<form name="ajouter_devis" method="post" class="" enctype="multipart/form-data" >
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="form-groupe-part ">
											<div class="title-info"><h1>Ajouter devis</h1></div>
												'.$cat.'
												'.$fiche.'
														
												<p><br /><br />Détail de Client :</p>		
												<p>
													<label for="ip_civ">Civilité : <span class="obli">*</span></label>
													<input id="ip_civ" type="radio" value="Mr" name="civ" checked="checked" /> Mr 
													<input id="ip_civ" type="radio" value="Mme" name="civ"/> Mme 
													<input id="ip_civ" type="radio" value="Mlle" name="civ"/> Mlle 
												</p>	
												<label for="ip_nom">Nom : <span class="obli">*</span></label><br />
													<input id="ip_nom" type="text" name="nom" placeholder="Nom"/><br />
												<label for="ip_prenom">Prénom : <span class="obli">*</span></label><br />
													<input id="ip_prenom" type="text" name="prenom" placeholder="Prénom"/><br />
												<label for="ip_mail">E-mail : <span class="obli">*</span></label><br />
													<input id="ip_mail" type="text" name="email" placeholder="E-mail"/><br />
												<label for="ip_tel">Téléphone : <span class="obli">*</span></label><br />
													<input id="ip_tel" type="text" name="tel" placeholder="Téléphone"/><br />
												<label for="ip_voiec">Numéro et voie : <span class="obli">*</span></label><br />
													<input id="ip_voiec" type="text" name="voiec" placeholder="Numéro et voie"/><br />
												<label for="ip_appc">N° d\'appartement : <span class="obli">*</span></label><br />
													<input id="ip_appc" type="text" name="appc" placeholder="N° d\'appartement"/><br />
												<label for="ip_batc">Bâtiment, Résidence, Entrée : <span class="obli">*</span></label><br />
													<input id="ip_batc" type="text" name="batc" placeholder="Bâtiment, Résidence, Entrée"/><br />
												<label for="ip_cp">Code Postal : <span class="obli">*</span></label><br />
													<input id="ip_cp" type="text" name="cpc" onKeyPress="return scanTouche(event)" placeholder="Code postal"/><br />
												<label for="ip_ville">Ville : <span class="obli">*</span></label><br />
													<select id="ip_ville" name="villec"/></select><br />
												<label for="ip_pays">Pays : <span class="obli">*</span></label><br />
													<input id="ip_pays" type="text" name="paysc" value="France" readonly="readonly" placeholder="Pays" /><br />
	
	
												<p>
													<label for="ip_civ"><br /><br />L\'adresse du chantier est la meme que l\'adresse du client ?<span class="obli">*</span></label><br />
													<input id="ip_civ" type="radio" value="1" name="radadd" checked="checked" /> Oui 
													<input id="ip_civ" type="radio" value="0" name="radadd"/> Non 
												</p>			
												<div id="adresse_chantier" style="display:none">
													<p><br />Détail de l\'adresse du chantier:</p>			
													<label for="ip_voiec">Numéro et voie : <span class="obli">*</span></label><br />
														<input id="ip_voiec" type="text" name="voiea" placeholder="Numéro et voie"/><br />
													<label for="ip_appc">N° d\'appartement : <span class="obli">*</span></label><br />
														<input id="ip_appc" type="text" name="appa" placeholder="N° d\'appartement"/><br />
													<label for="ip_batc">Bâtiment, Résidence, Entrée : <span class="obli">*</span></label><br />
														<input id="ip_batc" type="text" name="bata" placeholder="Bâtiment, Résidence, Entrée"/><br />
													<label for="ip_cp">Code Postal : <span class="obli">*</span></label><br />
														<input id="ip_cp" type="text" name="cpa" onKeyPress="return scanTouche(event)" placeholder="Code postal"/><br />
													<label for="ip_ville">Ville : <span class="obli">*</span></label><br />
														<select id="ip_ville" name="villea"/></select><br />
													<label for="ip_pays">Pays : <span class="obli">*</span></label><br />
														<input id="ip_pays" type="text" name="paysa" value="France" readonly="readonly" placeholder="Pays" /><br />
												</div>		
														
														
														
												<p class="align_center padding_tb_20">
													<input value="Ajouter" type="submit" name="ajouter"/>
												</p>
												<p class="note" id="text_erreur"><cite>( * ) Champs Obligatoires.</cite></p>
										</div>
									</div>
								</div>
							</div>
						</form>	
						<p class="margin_top_20"><a href="espace_affilier.php?contenu=devis">Retour à la page précédente</a></p>
					</div>
				'	;
			}
			elseif ( isset($_GET['action']) && $_GET['action']=='detail' )
			{
				if ( !empty($_POST['commentaire']) )
					$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_client_trn_affil'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
				
				$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
				$detail.='
						<div class="container">
						<div class="row">
						<div class="col-md-12">
							<ul id="compte_details_com">
					
								<li class="col-md-6">
									<h4>Informations générales</h4>
									<dl>
										<dt>Date Devis : </dt>
										<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
										<dt>Référence : </dt>
										<dd>'.$infos_devis['reference'].'</dd>
									</dl>
								</li>
						';
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$infos_devis['id_adresse'].' ');
				$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
				$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
				$batiment = ucfirst(html_entity_decode($temp['batiment']));
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				$detail.='
							<li class="col-md-6  right-info">
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>Numero et voie : '.$num_voie.'</dd>
									<dd>N° d’appartement : '.$num_appart.'</dd>
									<dd>Bâtiment : '.$batiment.'</dd>
									<dd>'.$code_postal.' '.$ville.', '.$pays.'</dd>
								</dl>
							</li>
					
						</ul>
						';
				$detail.='
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
						<tr class="entete">
							<td>Désignation</td>
						</tr>
					';
				$nom_cat='';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
				while ( $ress=$my->arr($reqq) )
				{
					if ( $nom_cat!=$ress['titre_categ'] )
					{
						$nom_cat=$ress['titre_categ'];
						$detail.='
							<tr >
								<td colspan="6"><strong>'.$nom_cat.'</strong></td>
							</tr>
								';
					}
					$detail.='
									<tr>
										<td style="text-align:justify;">'.$ress['piece'].'</td>
									</tr>
								</div>
							</div>
							</div>';
				}
				
				$detail.='</table>';
				
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers à télécharger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p>';
				}
				$touscom='';
				$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ORDER BY date ASC');
				if ( $my->num($reqComm)>0 )
				{
					$touscom.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Date</td>
									<td>User</td>
									<td>Commentaire</td>
								</tr>
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
					$touscom.='</table>';
				}
				
				echo'
					<div id="espace_compte">
						'.$detail.'
						<br /><br />
						'.$touscom.'
				
						<form method="post" >
							<p>Ajouter Commentaire : <textarea type="text" name="commentaire"></textarea><br /></p>
							<p><input value="Ajouter" class="sub" type="submit" name="ajout_commentaire"/></p>
						</form>
				
						<p class="margin_top_20"><a href="espace_affilier.php?contenu=devis">Retour à la page précédente</a></p>
					</div>
					';
			}
			else 
			{
				if ( isset($_GET['ajouter'])) echo'<div id="note" class="notes"><p>Devis ajouté.</p></div><br />';
				if ( isset($_GET['supprimer'])) echo'<div id="note" class="notes"><p>Devis supprimé.</p></div><br />';
				
				echo '<p>Pour ajouter un autre devis, cliquer <a href="espace_affilier.php?contenu=devis&action=ajouter">ICI</a></p>';
				echo '<p>Pour ajouter un autre devis à partir d\'un fichier exel , cliquer <a href="espace_affilier.php?contenu=devis&action=ajouterexel">ICI</a></p>';
				
				echo'<div id="espace_compte">';
				$req=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_client_trn_affil'].' AND stat_suppr=0 AND statut_valid_admin=-1 ');
				if ( $my->num($req)>0 )
				{
					echo'
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Date / Ref</td>
									<td>Client</td>
									<td>Ville / Département</td>
									<td>Prix</td>
									<td class="width_20"></td>
									<td class="width_20"></td>
								</tr>
									  ';
					while ( $res=$my->arr($req) )
					{
						$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$res['id'].' ');
						
						if ($res_suite['stat_ajout_zone']==0 && $res_suite['stat_devis_attente']==0 ) $affich=1;
						else $affich=0;
						if ( $affich==1 )
						{
							$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
							$vd='';
							$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
							$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
							$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
							$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
							
							echo'
									<tr>
										<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</td>
										<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
										<td>'.$vd.'</td>
										<td>'.number_format($res['prix_achat'],2).' €</td>
										<td><a href="espace_affilier.php?contenu=devis&action=detail&id='.$res['id'].'" title="Détail"><img src="stockage_img/zoom_in.png" alt="Détail"/></a></td>
										<td><a href="espace_affilier.php?contenu=devis&action=supprimer&id='.$res['id'].'" title="Supprimer"><img src="stockage_img/book_delete.png" alt="Supprimer"/></a></td>
									</tr>
										  	  ';
						}
					}
					echo'</table>';
				}
				else 
				{
					echo'<p>Pas devis ...</p>';
				}
				echo'<br /><p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p>';
				echo'</div>';
			}
			break;	
		case 'probleme' :
			if ( isset($_GET['action']) && $_GET['action']=='detail' )
			{
				$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
				$detail.='
						<div class="container">
						<div class="row">
						<div class="col-md-12">
							<ul id="compte_details_com">
			
								<li class="col-md-6">
									<h4>Informations générales</h4>
									<dl>
										<dt>Date Devis : </dt>
										<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
										<dt>Référence : </dt>
										<dd>'.$infos_devis['reference'].'</dd>
									</dl>
								</li>
						';
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$infos_devis['id_adresse'].' ');
				$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
				$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
				$batiment = ucfirst(html_entity_decode($temp['batiment']));
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				$detail.='
							<li class="col-md-6  right-info">
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>Numero et voie : '.$num_voie.'</dd>
									<dd>N° d’appartement : '.$num_appart.'</dd>
									<dd>Bâtiment : '.$batiment.'</dd>
									<dd>'.$code_postal.' '.$ville.', '.$pays.'</dd>
								</dl>
							</li>
			
						</ul>
						';
				$detail.='
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
						<tr class="entete">
							<td>Désignation</td>
						</tr>
					';
				$nom_cat='';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
				while ( $ress=$my->arr($reqq) )
				{
					if ( $nom_cat!=$ress['titre_categ'] )
					{
						$nom_cat=$ress['titre_categ'];
						$detail.='
							<tr >
								<td colspan="6"><strong>'.$nom_cat.'</strong></td>
							</tr>
								';
					}
					$detail.='
									<tr>
										<td style="text-align:justify;">'.$ress['piece'].'</td>
									</tr>
								</div>
							</div>
							</div>';
				}
				
				$detail.='</table>';
				
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers à télécharger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p>';
				}
				$touscom='';
				$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ORDER BY date ASC');
				if ( $my->num($reqComm)>0 )
				{
					$touscom.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Date</td>
									<td>User</td>
									<td>Commentaire</td>
								</tr>
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
					$touscom.='</table>';
				}
				
				echo'
					<div id="espace_compte">
						'.$detail.'
						<br /><br />
						'.$touscom.'
				
						<form method="post" >
							<p>Ajouter Commentaire : <textarea type="text" name="commentaire"></textarea><br /></p>
											
							<br /><br />				
							<p>Statut devis :<br />
								<input type="radio" name="pb" value="1" checked="checked" >En stand by<br />
								<input type="radio" name="pb" value="0" >Re - envoyer à la répresentant par zone <span style="font-size:10px">( ajouter un commentaire explicatif )</span><br />
								<input type="radio" name="pb" value="2" >Re - envoyer à l\'administrateur <span style="font-size:10px"> ( ajouter un commentaire explicatif )</span><br />
							</p>				
							<br /><br />				
											
							<p><input type="submit" value="Modifier" name="modif_comm_stat" /></p>
						</form>
				
											
						<p class="margin_top_20"><a href="espace_affilier.php?contenu=probleme&stat='.$_GET['stat'].'">Retour à la page précédente</a></p>
					</div>
					';
				
			}
			else
			{
				if ( isset($_GET['modifier'])) echo'<div id="note" class="notes"><p>Devis modifié.</p></div><br />';
				if ( isset($_GET['supprimer'])) echo'<div id="note" class="notes"><p>Devis supprimé.</p></div><br />';
				
				if ( isset($_GET['stat']) ) $stat=$_GET['stat']; else $stat=2;
				
				if ( $stat==2 ) $st='Client injoignable';
				elseif ( $stat==3 ) $st='Travau fini';
				elseif ( $stat==4 ) $st='Faux numéro';
				elseif ( $stat==5 ) $st='Déjà trouver un artisan';
				elseif ( $stat==7 ) $st='Pas de travaux';
				elseif ( $stat==8 ) $st='Projet abandonné';
				$tableau='';
				
				
				$req = $my->req('SELECT AD.id as idad
									FROM
										ttre_achat_devis AD ,
										ttre_achat_devis_suite ADSS
									WHERE
										AD.statut_valid_admin=-1
										AND AD.stat_suppr=0
										AND AD.nbr_estimation='.$_SESSION['id_client_trn_affil'].'
										AND	AD.id=ADSS.id_devis
										AND	ADSS.stat_ajout_zone=1
										AND ADSS.stat_devis_attente='.$stat.'
									ORDER BY AD.id DESC');
	
				if ( $my->num($req)>0 )
				{
					$tableau.='
								<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
									<tr class="entete">
										<td>Date / Ref</td>
										<td>Client</td>
										<td>Ville / Département</td>
										<td>Prix</td>
										<td class="width_20"></td>
										<td class="width_20"></td>
									</tr>
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
							
						$tableau.='
									<tr>
										<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</td>
										<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
										<td>'.$vd.'</td>
										<td>'.number_format($res['prix_achat'],2).' €</td>
										<td><a href="espace_affilier.php?contenu=probleme&action=detail&id='.$res['id'].'&stat='.$_GET['stat'].'" title="Détail"><img src="stockage_img/zoom_in.png" alt="Détail"/></a></td>
										<td><a href="espace_affilier.php?contenu=probleme&action=supprimer&id='.$res['id'].'&stat='.$_GET['stat'].'" title="Supprimer"><img src="stockage_img/book_delete.png" alt="Supprimer"/></a></td>
									</tr>
										  	  ';
					}
					$tableau.='</table>';
				}
				else 
				{
					$tableau.='<p>Pas devis ...</p>';
				}
				
				
				echo'
	                   <div id="espace_compte">  
	                   		<p>Différentes Status :
	                        	<a href="espace_affilier.php?contenu=probleme&stat=2">Client injoignable</a> - 
	                        	<a href="espace_affilier.php?contenu=probleme&stat=3">Travaux fini</a> - 
	                        	<a href="espace_affilier.php?contenu=probleme&stat=4">Faux numéro</a> - 
	                        	<a href="espace_affilier.php?contenu=probleme&stat=5">Déjà trouver un artisan</a> - 
	                        	<a href="espace_affilier.php?contenu=probleme&stat=7">Pas de travaux</a> - 
	                        	<a href="espace_affilier.php?contenu=probleme&stat=8">Projet abondonné</a>.
	                        </p>  
							<br /><br /><br />
							<p>Statut : '.$st.'</p><br /><br />
	                        '.$tableau.'
	
							<br /><p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p>
	                   </div>          		
	                ';
			}
			break;	
		case 'statistique' :
			echo'<div id="espace_compte">';
			$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$_SESSION['id_client_trn_affil'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_client_trn_affil'].' AND stat_suppr=0  ');
			if ( $my->num($req)>0 )
			{
				echo'<br /><br />
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
					<tr class="entete">
						<td>Nom</td>
						<td>Nombre de devis</td>
						<td>Statistique</td>
					</tr>
					';
					$c1=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_client_trn_affil'].' AND statut_valid_admin=-1 AND stat_suppr=0  ');
					$c2=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_client_trn_affil'].' AND statut_valid_admin=-2 AND stat_suppr=0  ');
					$c3=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_client_trn_affil'].' AND statut_valid_admin=-3 AND stat_suppr=0  ');
						
					$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t0=0;
					while ( $cc1=$my->arr($c1) )
					{
						$t=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$cc1['id'].' ');
						list($p,$d) = split('[|]',$t['stat_devis_attente']);
						if ( $p==1 ) $t1++;
						elseif ( $p==2 ) $t2++;
						elseif ( $p==3 ) $t3++;
						elseif ( $p==4 ) $t4++;
						elseif ( $p==5 ) $t5++;
						elseif ( $p==6 ) $t6++;
						elseif ( $p==7 ) $t7++;
						elseif ( $p==8 ) $t8++;
						elseif ( $p==0 ) $t0++;
					}
					echo'
						<tr style="text-align:center;">
							<td style="width:30%">'.$user['nom'].'</td>
							<td style="width:40%"><p style="text-align:left;" >
								<strong>'.$my->num($c1).'</strong> devis en attente de traitement <br />
								<strong>'.$my->num($c2).'</strong> devis à atribuer <br />
								<strong>'.$my->num($c3).'</strong> devis signé
							</td></p>
							<td style="width:30%"><p style="text-align:left;" >
								<strong>'.$t1.'</strong> RDV pris <span style="color:red"><strong>'.ceil($t1*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t2.'</strong> Ne répond pas <span style="color:red"><strong>'.ceil($t2*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t3.'</strong> Travaux fini <span style="color:red"><strong>'.ceil($t3*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t4.'</strong> Faux numéro <span style="color:red"><strong>'.intval($t4*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t5.'</strong> Déjà trouvé un artisan <span style="color:red"><strong>'.intval($t5*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t6.'</strong> Autres <span style="color:red"><strong>'.intval($t6*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t7.'</strong> Pas de travaux <span style="color:red"><strong>'.intval($t7*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t8.'</strong> Projet abandonné <span style="color:red"><strong>'.intval($t8*100/$my->num($c1)).'% </strong></span><br />
								<strong>'.$t0.'</strong> Pa vue <span style="color:red"><strong>'.intval($t0*100/$my->num($c1)).'% </strong></span>
							</td></p>
						</tr>
						';
				echo'</table>';
			}
			else 
			{
				echo'<p>Pas devis ...</p>';
			}
			echo'<br /><p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p></div>';
			break;	
		case 'paiement' :
			echo'<div id="espace_compte">';
			$total=0;
			//devis achat immediat
			$req_user = $my->req('SELECT * FROM ttre_achat_devis WHERE stat_suppr='.$_SESSION['id_client_trn_affil'].' AND statut_valid_admin>=0 ');
			while ( $res_user=$my->arr($req_user) ) $total=$total+$res_user['user_zone'];
			//devis admin ajout
			$req_user = $my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_client_trn_affil'].' AND stat_suppr=0 AND statut_valid_admin<-1 ');
			while ( $res_user=$my->arr($req_user) ) $total=$total+$res_user['prix_achat'];
			$req_user = $my->req('SELECT * FROM ttre_achat_devis AD , ttre_achat_devis_suite ADSS
					WHERE AD.nbr_estimation='.$_SESSION['id_client_trn_affil'].' AND AD.statut_valid_admin=-1 AND AD.stat_suppr=0 AND AD.id=ADSS.id_devis
					AND	ADSS.stat_ajout_zone=0 AND ( ADSS.stat_devis_attente=1 ) ');
					//AND	ADSS.stat_ajout_zone=0 AND ( ADSS.stat_devis_attente=1 || ADSS.stat_devis_attente=6 ) ');
			while ( $res_user=$my->arr($req_user) ) $total=$total+$res_user['prix_achat'];
			
			
			$payer=0;
			$req_user = $my->req('SELECT * FROM ttre_pyement_user_ajout WHERE id_user='.$_SESSION['id_client_trn_affil'].' ');
			while ( $res_user=$my->arr($req_user) ) $payer=$payer+$res_user['montant'];
			
			echo'
				<br /><br />
				<p>Montant total : '.number_format($total,2).' €</p>
				<p>Montant payé : '.number_format($payer,2).' €</p>
				<p>Montant resté : '.number_format($total-$payer,2).' €</p>
				<br /><br />
					';
			$req = $my->req('SELECT * FROM ttre_pyement_user_ajout WHERE id_user='.$_SESSION['id_client_trn_affil'].' ORDER BY date DESC ');
			if ( $my->num($req)>0 )
			{
				echo'
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<thead>
								<tr class="entete" style="text-align:center;">
									<td colspan="3">Virement</td>
								</tr>
								<tr class="entete">
									<td>Date</td>
									<td>Montant</td>
									<td>Commentaire</td>
								</tr>
							</thead>
							<tbody>
					';
				while ( $res=$my->arr($req) )
				{
					echo'
						<tr>
							<td>'.date('d/m/Y',$res['date']).'</td>
							<td>'.number_format($res['montant'],2).' €</td>
							<td>'.$res['commentaire'].'</td>
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
				echo '<p>Pas virement ...</p>';
			}
		
			echo'<br /><p class="margin_top_20"><a href="espace_affilier.php">Retour à la page précédente</a></p></div>';
			break;	
	}
}
else
{
	if ( !isset($_SESSION['id_client_trn_affil']) )
	{
		$alert='<div id="note"></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='erreur') ) $alert='<div id="note" class="error"><p>Erreur lors de l\'authentification.</p></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		//if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='valider') ) $alert='<div id="note" class="success"><p>Votre compte a bien été validé.</p></div><br />';
		if ( isset($_GET['modif']) && ($_GET['modif']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		if ( isset($_GET['valid_mdp']) ) $alert='<div id="note" class="notice"><p>Votre mot de passe a bien été modifié, vous pouvez dès maintenant vous connecter.</p></div><br />';
		echo'
			'.$alert.'
			
				<div class="col-md-6 ">
					<div class="Login-part">
						<div class="title-sign-part">Vous avez déjà un compte ?</div>
						<form action="espace_affilier.php?contenu=connexion" name="client_conn" method="post" class="" >
							<div class="form-login-part">
									<input id="mail" type="text" name="email_connexion" placeholder="Votre adresse mail" /><br />
									<input id="mdp" type="password" name="mdp_connexion" placeholder="Votre mot de passe"/><br />
									<input class="boutons_persos_1" value="Connexion" type="submit" name="conn_client"/><br />
									<p>Si vous avez oublié votre mot de passe, <a href="espace_affilier.php?contenu=mdp_perdu" style="color:#000">cliquez ici</a>.</p>
							</div>
						</form>
						
					</div>
				</div>
				<div class="col-md-6">
					<div class="Logup-part">
						<div class="title-sign-part">Vous êtes nouveau client ?</div>
						<div class="log-part">
							<p>Vous devez créer un compte pour pouvoir gérer vos devis.</p>
							<p>Nous nous engageons à sécuriser vos informations et à les garder strictement confidentielles.</p>
							<a href="espace_affilier.php?contenu=inscription" class="">Créer un compte</a>
						</div>
					</div>
				</div>
			
			';
	}
	else
	{
		$alert='<div id="note"></div><br />';
		if ( isset($_GET['modif_mdp']) ) $alert='<div id="note" class="notice" ><p>Votre mot de passe a bien été modifié.</p></div><br />';
		echo'
			'.$alert.'		

				<div class="col-md-4">
					<div class="espace-box1">
						<img src="../images/icons/1-1.png">
						<h3>Informations personnelles</h3>
						<p>C\'est dans cette section que vous pourrez accéder à vos informations personnelles et les modifier.</p>
						<a href="espace_affilier.php?contenu=modif_param">Modifier mes informations</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="espace-box1">
						<img src="../images/icons/1-2.png">
						<h3>Mot de passe</h3>
						<p>Pour des questions de sécurité, il est conseillé de modifier son mot de passe fréquemment.</p>
						<a href="espace_affilier.php?contenu=modif_mdp">Modifier mon mot de passe</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="espace-box1">
						<img src="../images/icons/1-3.png">
						<h3>Devis en attente de traitement</h3>
						<p>C\'est dans cette section que vous pouvez ajouter des devis.</p>
						<a href="espace_affilier.php?contenu=devis">Gérer mes devis</a>
					</div>
				</div>	

				<div class="col-md-4">
					<div class="espace-box1">
						<img src="../images/icons/1-6.png">
						<h3>Problème devis</h3>
						<p>C\'est dans cette section que vous pourrez consulter le problème de devis.</p>
						<a href="espace_affilier.php?contenu=probleme">Devis</a>
					</div>
				</div>	
											
				<div class="col-md-4">
					<div class="espace-box1">
						<img src="../images/icons/1-4.png">
						<h3>Paiement</h3>
						<p>C\'est dans cette section que vous pourrez consulter l\'historique de vos paiement.</p>
						<a href="espace_affilier.php?contenu=paiement">Paiement</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="espace-box1">
						<img src="../images/icons/1-5.png">
						<h3>Statistique</h3>
						<p>C\'est dans cette section que vous pourrez consulter le statistique.</p>
						<a href="espace_affilier.php?contenu=statistique">Statistique</a>
					</div>
				</div>    


				
				<div class="col-md-12">
					<div class="get-quote">						
						<div class="quote-img">
							<img src="../images/images/conseil-man-small.png" >
						</div>
						<div class="quote-text">
								<h2>Devis Travaux Rénovation</h2>
								<p>Votre devis détaillée en ligne : Créer votre devis et ayez une estimations rapide de vos travaux</p>
						</div>
						<div class="quote-btns">
								<a href="devis.php" class="create">Créer votre devis</a>
								<a href="prix-travaux.php" class="get">Devis Immédiat</a>
						</div>
					</div>
				</div>
				
				<p><a href="espace_affilier.php?contenu=deconnexion"> » Se déconnecter</a></p>		
			</div>
			';
	}
}
?>






</div>
				</div>
			</div>
		</div>
	</div>		
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>