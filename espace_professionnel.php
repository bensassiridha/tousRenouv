<?php
require('inc/session.php');


if ( strpos($_SERVER['HTTP_REFERER'],'recherche.php?idDevis') ) $_SESSION['lien']=$_SERVER['HTTP_REFERER'];


if ( isset($_GET['idDevisAImm']) )
{
	$exist=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['idDevisAImm'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].' ');
	if ( $my->num($exist)==0 ) $my->req('INSERT INTO ttre_achat_devis_client_pro VALUES("","'.$_GET['idDevisAImm'].'","'.$_SESSION['id_client_trn_pro'].'","","","","","")');
	rediriger("espace_professionnel.php?contenu=devisa_att_paye&idDevis=".$_GET['idDevisAImm']."&etape=paiement");exit;
}
elseif ( isset($_GET['idDevisEnch']) )
{
	$exist=$my->req('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevisEnch'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].' ');
	if ( $my->num($exist)==0 ) $my->req('INSERT INTO ttre_devis_client_pro VALUES("","'.$_GET['idDevisEnch'].'","'.$_SESSION['id_client_trn_pro'].'","","","","","","")');
	rediriger("espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevisEnch']."");exit;
}

if ( isset($_GET['idEncherePaye']) )
{
	$enchere=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id="'.$_GET['idEncherePaye'].'" ');
	$devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id="'.$enchere['id_devis'].'" ');
	if ( $devis )
	{
		if ( $devis['statut_valid_admin']==2 )
		{
			$id_devis=$devis['id'];
			$id_adresse=$devis['id_adresse'];
			$id_client_part=$devis['id_client'];
			require_once 'mailDevis.php';
			$my->req ( 'UPDATE ttre_devis SET
							statut_valid_admin		=	"3" 
						WHERE id = "'.$devis['id'].'" ' );
			$my->req ( 'UPDATE ttre_devis_client_pro SET
							fichier_update			=	"Site" 
						WHERE id_devis = "'.$devis['id'].'" ' );
		}
		rediriger("espace_professionnel.php?contenu=devis_att_paye&paiement=effectuer");exit;
	}
	else
	{
		rediriger("espace_professionnel.php?contenu=devis_att_paye&paiement=annuler");exit;
	}
}
if ( isset($_GET['idEstimPaye']) )
{
	$estim=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id="'.$_GET['idEstimPaye'].'" ');
	$devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id="'.$estim['id_devis'].'" ');
	if ( $devis )
	{
		if ( $devis['statut_valid_admin']==1 )
		{
			$adcp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id="'.$_GET['idEstimPaye'].'" ');
			$id_devis=$devis['id'];
			$id_adresse=$devis['id_adresse'];
			$id_client_part=$devis['id_client'];
			$id_client_pro=$adcp['id_client_pro'];
			require_once 'mailAchatDevis.php';
			$my->req ( 'UPDATE ttre_achat_devis_client_pro SET
							fichier_update			=	"site" ,
							statut_achat			=	"1" 
						WHERE id = "'.$adcp['id'].'" ' );
		}
		rediriger("espace_professionnel.php?contenu=devisa_att_paye&paiement=effectuer");exit;
	}
	else
	{
		rediriger("espace_professionnel.php?contenu=devisa_att_paye&paiement=annuler");exit;
	}
}


// ----------------------------------------------------pour la gestion ----------------------------
if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'connexion' :
			if ( isset($_POST['conn_client']) )
			{
				$req=$my->req('SELECT * FROM ttre_client_pro WHERE email="'.$_POST['email_connexion'].'" AND mdp="'.md5($_POST['mdp_connexion']).'" AND ( stat_valid_zone=1 OR stat_valid_general=1) ');
				if ( $my->num($req)==0 )
				{
					rediriger("espace_professionnel.php?inscrit=erreur");exit;
				}
				else
				{
					$cl=$my->arr($req);
					$_SESSION['id_client_trn_pro']=$cl['id'];
					
					if ( isset($_SESSION['lien']) )
						rediriger("".$_SESSION['lien']."");
					else
						rediriger("espace_professionnel.php");exit;
				}
			}
			break;
		case 'inscription' :
			if ( isset($_POST['ajout_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){rediriger("espace_professionnel.php?contenu=inscription&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_client_pro WHERE email="'.$_POST['mail_nouveau'].'"');
					if ( $my->num($req)>0 ) {rediriger("espace_professionnel.php?contenu=inscription&erreur=mail");exit;}
					else
					{
						$fich1_nouveau='';
						$handle = new Upload($_FILES['fich1_nouveau']);
						if ($handle->uploaded) 
						{
							$handle->Process('upload/client_pro/fichiers/');
							if ($handle->processed) 
							{
								$fich1_nouveau  = $handle->file_dst_name ;	          // Destination file name              
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
							}
						}
						$fich2_nouveau='';
						$handle = new Upload($_FILES['fich2_nouveau']);
						if ($handle->uploaded) 
						{
							$handle->Process('upload/client_pro/fichiers/');
							if ($handle->processed) 
							{
								$fich2_nouveau  = $handle->file_dst_name ;	          // Destination file name              
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
							}
						}
						$fich3_nouveau='';
						$handle = new Upload($_FILES['fich3_nouveau']);
						if ($handle->uploaded) 
						{
							$handle->Process('upload/client_pro/fichiers/');
							if ($handle->processed) 
							{
								$fich3_nouveau  = $handle->file_dst_name ;	          // Destination file name              
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
							}
						}
						list($jour, $mois, $annee) = explode('/', date('d/m/Y',time()) );
						$timestamp = mktime(0,0,0,$mois,$jour,$annee);
						
						if ( isset($_POST['newsletter']) ) $val_newsletter=1; else $val_newsletter=0;
						$my->req("INSERT INTO ttre_client_pro VALUES('',
													'".$timestamp."' ,
													'".$my->net_input($_POST["juridique_nouveau"])."',
													'".$my->net_input($_POST["raison_nouveau"])."',
													'".$my->net_input($_POST["taille_nouveau"])."',
													'".$my->net_input($_POST["numvoie_nouveau"])."',
													'".$my->net_input($_POST["cadresse_nouveau"])."',
													'".$my->net_input($_POST["cp"])."',
													'".$my->net_input($_POST["ville"])."',
													'".$my->net_input($_POST["pays_nouveau"])."',
													'".$my->net_input($_POST["numsireen_nouveau"])."',
													'".$my->net_input($_POST["civ_nouveau"])."',
													'".$_POST["nom_nouveau"]."',
													'".$_POST["prenom_nouveau"]."',
													'".$my->net_input($_POST["telephone_nouveau"])."',
													'".$my->net_input($_POST["fax_nouveau"])."',
													'".$my->net_input($_POST["mail_nouveau"])."',
													'".$my->net_input($fich1_nouveau)."',
													'".$my->net_input($fich2_nouveau)."',
													'".$my->net_input($fich3_nouveau)."',
													'".md5($_POST["pass1_nouveau"])."',
													'".$my->net_input($val_newsletter)."',
													'0',
													'0'
													)");
						$id_client=mysql_insert_id();
						
						if ( isset($_POST['partenaire']) )
						{
							$req_part=$my->req('SELECT * FROM ttre_partenaire_pro WHERE email="'.$_POST['mail_nouveau'].'" ');
							if ( $my->num($req_part)==0 ) $my->req("INSERT INTO ttre_partenaire_pro VALUES('','".$my->net_input($_POST['mail_nouveau'])."') ");
						}
						else
						{
							$my->req('DELETE FROM ttre_partenaire_pro WHERE email="'.$_POST['mail_nouveau'].'" ');
						}
						
						foreach ( $_POST['categorie'] as $value ) 
							$my->req("INSERT INTO ttre_client_pro_categories VALUES('','".$id_client."','".$value."')");
						foreach ( $_POST['departement'] as $value ) 
						{
							$my->req("INSERT INTO ttre_client_pro_departements VALUES('','".$id_client."','".$value."')");
							$message = '
									<html>
										<head>
											<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
											<title>TOUSRENOV</title>
										</head>
									
										<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
											<div id="corps" style="margin:0 auto; width:800px; height:auto;">
												<h1 style="background-color:#687189; color:#FFF; font-size:16px; text-align:center;">TOUSRENOV</h1>
												
												<p>Bonjour,</p>
												<p>Un artisan ou societ� "'.$_POST['raison'].'" vient de s\'inscrire. 
													veuillez verifier ses documents avant de valider son inscription.   
													<a href="http://tousrenov.fr/ttre_adm/index.php?contenu=pro_liste">Espace admin</a>
												</p>
												
												<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Informations personnelles</h2>
												<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
													<table>
														<tr>
															<td style="text-align: right;color:#941B80;">Nom : </td>
															<td>'.$_POST["nom_nouveau"].'</td>
														</tr>
														<tr>
															<td style="text-align: right;color:#941B80;">Pr�nom : </td>
															<td>'.$_POST["prenom_nouveau"].'</td>
														</tr>
													</table>
												</div>
																	
												<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
														<p style="padding-top:10px;">
															TOUSRENOV
														</p>
												</div>
											</div>
										</body>
									</html>
								';
							
							$t=$my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$value.' ');
							if ( $t )
							{
								$tt=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$t['id_user'].' ');
								if ( !empty($tt['email']) )
								{
									$mail_admin_zone=$tt['email'];
									
									$sujet='Nouveau artisan ';
									$mail_reply = $_POST["mail_nouveau"];
									//$mail_client = 'bilelbadri@gmail.com';
									
									$headers = "From: \" ".$_POST["nom_nouveau"]." \"<".$mail_reply.">\n";
									$headers .= "Reply-To: ".$mail_reply."\n";
									$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
									mail($mail_admin_zone,$sujet,$message,$headers);
								}
							}
						}
						mail('contact@tousrenov.fr',$sujet,$message,$headers);
						rediriger("espace_professionnel.php?inscrit=enattente");exit;			
					}
				}
			}
			break;
		case 'valider' :
			$my->req('UPDATE ttre_client_pro SET stat_valid="1" WHERE ref_valid="'.$_GET['ref'].'" AND stat_valid="0" ');
			rediriger("espace_professionnel.php?inscrit=valider");exit;	
			break;
		case 'modif_param' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_POST['modif_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){rediriger("espace_professionnel.php?contenu=modif_param&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_client_pro WHERE email="'.$_POST['mail'].'" AND id!='.$_SESSION['id_client_trn_pro'].' ');
					if ( $my->num($req)>0 ) {rediriger("espace_professionnel.php?contenu=modif_param&erreur=mail");exit;}
					else
					{
						$cl=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_SESSION['id_client_trn_pro'].' ');
						if ( isset($_POST['suppr_fich1']) )
						{
							@unlink('upload/client_pro/fichiers/'.$cl['fichier1']);
							$my->req('UPDATE ttre_client_pro SET fichier1="" WHERE id='.$_SESSION['id_client_trn_pro'].' ');
						}
						if ( isset($_POST['suppr_fich2']) )
						{
							@unlink('upload/client_pro/fichiers/'.$cl['fichier2']);
							$my->req('UPDATE ttre_client_pro SET fichier2="" WHERE id='.$_SESSION['id_client_trn_pro'].' ');
						}
						if ( isset($_POST['suppr_fich3']) )
						{
							@unlink('upload/client_pro/fichiers/'.$cl['fichier3']);
							$my->req('UPDATE ttre_client_pro SET fichier3="" WHERE id='.$_SESSION['id_client_trn_pro'].' ');
						}
						$cl=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_SESSION['id_client_trn_pro'].' ');
						$fich1=$cl['fichier1'];
						$handle = new Upload($_FILES['fich1']);
						if ($handle->uploaded) 
						{
							$handle->Process('upload/client_pro/fichiers/');
							if ($handle->processed) 
							{
								@unlink('upload/client_pro/fichiers/'.$cl['fichier1']);
								$fich1  = $handle->file_dst_name ;	          // Destination file name              
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
							}
						}
						$fich2=$cl['fichier2'];
						$handle = new Upload($_FILES['fich2']);
						if ($handle->uploaded) 
						{
							$handle->Process('upload/client_pro/fichiers/');
							if ($handle->processed) 
							{
								@unlink('upload/client_pro/fichiers/'.$cl['fichier2']);
								$fich2  = $handle->file_dst_name ;	          // Destination file name              
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
							}
						}
						$fich3=$cl['fichier3'];
						$handle = new Upload($_FILES['fich3']);
						if ($handle->uploaded) 
						{
							$handle->Process('upload/client_pro/fichiers/');
							if ($handle->processed) 
							{
								@unlink('upload/client_pro/fichiers/'.$cl['fichier3']);
								$fich3  = $handle->file_dst_name ;	          // Destination file name              
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location    
							}
						}
						if ( isset($_POST['newsletter']) ) $val_newsletter=1; else $val_newsletter=0;
						$my->req('UPDATE ttre_client_pro SET 
									juridique			=	"'.$my->net_input($_POST["juridique"]).'" , 
									raison				=	"'.$my->net_input($_POST['raison']).'" , 
									taille				=	"'.$my->net_input($_POST['taille']).'" , 
									num_voie			=	"'.$my->net_input($_POST['numvoie']).'" , 
									cadresse			=	"'.$my->net_input($_POST['cadresse']).'" , 
									code_postal			=	"'.$my->net_input($_POST['cp']).'" , 
									ville				=	"'.$my->net_input($_POST['ville']).'" , 
									pays				=	"'.$my->net_input($_POST['pays']).'" , 
									num_sireen			=	"'.$my->net_input($_POST['numsireen']).'" , 
									civ					=	"'.$my->net_input($_POST['civ']).'" , 
									nom					=	"'.$_POST['nom'].'" , 
									prenom				=	"'.$_POST['prenom'].'" , 
									telephone			=	"'.$my->net_input($_POST['telephone']).'" ,
									fax					=	"'.$my->net_input($_POST['fax']).'" , 
									email				=   "'.$my->net_input($_POST['mail']).'"  ,
									fichier1			=	"'.$my->net_input($fich1).'" , 
									fichier2			=	"'.$my->net_input($fich2).'" , 
									fichier3			=	"'.$my->net_input($fich3).'" , 
									newsletter			=	"'.$my->net_input($val_newsletter).'" , 
									stat_valid_zone		=   "0"  ,
									stat_valid_general	=   "0"  
											WHERE id='.$_SESSION['id_client_trn_pro'].'') ;
						
						if ( isset($_POST['partenaire']) )
						{
							$req_part=$my->req('SELECT * FROM ttre_partenaire_pro WHERE email="'.$_POST['mail'].'" ');
							if ( $my->num($req_part)==0 ) $my->req("INSERT INTO ttre_partenaire_pro VALUES('','".$my->net_input($_POST['mail'])."') ");
						}
						else
						{
							$my->req('DELETE FROM ttre_partenaire_pro WHERE email="'.$_POST['mail'].'" ');
						}
						
						$my->req('DELETE FROM ttre_client_pro_categories WHERE id_client='.$_SESSION['id_client_trn_pro'].' ');
						foreach ( $_POST['categorie'] as $value ) 
							$my->req("INSERT INTO ttre_client_pro_categories VALUES('','".$_SESSION['id_client_trn_pro']."','".$value."')");
						$my->req('DELETE FROM ttre_client_pro_departements WHERE id_client='.$_SESSION['id_client_trn_pro'].' ');
						foreach ( $_POST['departement'] as $value ) 
						{
							$my->req("INSERT INTO ttre_client_pro_departements VALUES('','".$_SESSION['id_client_trn_pro']."','".$value."')");
							$message = '
									<html>
										<head>
											<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
											<title>TOUSRENOV</title>
										</head>
					
										<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
											<div id="corps" style="margin:0 auto; width:800px; height:auto;">
												<h1 style="background-color:#687189; color:#FFF; font-size:16px; text-align:center;">TOUSRENOV</h1>
							
												<p>Bonjour,</p>
												<p>Un artisan ou societ� "'.$_POST['raison'].'" vient de faire des modifications dans  son espace personnel.       
													Merci de le reverifier avant de le revalider.  
													<a href="http://tousrenov.fr/ttre_adm/index.php?contenu=pro_liste">Espace admin</a>
												</p>
												<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Informations personnelles</h2>
												<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
													<table>
														<tr>
															<td style="text-align: right;color:#941B80;">Nom : </td>
															<td>'.$_POST["nom"].'</td>
														</tr>
														<tr>
															<td style="text-align: right;color:#941B80;">Pr�nom : </td>
															<td>'.$_POST["prenom"].'</td>
														</tr>
													</table>
												</div>
									
												<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
														<p style="padding-top:10px;">
															TOUSRENOV
														</p>
												</div>
											</div>
										</body>
									</html>
								';
								
							$t=$my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$value.' ');
							if ( $t )
							{
								$tt=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$t['id_user'].' ');
								if ( !empty($tt['email']) )
								{
									$mail_admin_zone=$tt['email'];
									$mail_admin_zone = 'bilelbadri@gmail.com';
										
									$sujet='Modif artisan ';
									$mail_reply = $_POST["mail_nouveau"];
									//$mail_client = 'bilelbadri@gmail.com';
										
									$headers = "From: \" ".$_POST["nom_nouveau"]." \"<".$mail_reply.">\n";
									$headers .= "Reply-To: ".$mail_reply."\n";
									$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
									mail($mail_admin_zone,$sujet,$message,$headers);
								}
							}
						}	
						mail('contact@tousrenov.fr',$sujet,$message,$headers);
						unset ($_SESSION['id_client_trn_pro']);
						unset ($_SESSION['panier_trn']);
						rediriger("espace_professionnel.php?modif=enattente");exit;	
					}
				}
			}
			break;
		case 'modif_mdp' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_POST['modif_mdp']) )
			{
				$can=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id="'.$_SESSION['id_client_trn_pro'].'"');
				if ( $can['mdp']!=md5($_POST['pass']) ){rediriger("espace_professionnel.php?contenu=modif_mdp&erreur=mdp");exit;}
				else
				{
					$my->req('UPDATE ttre_client_pro SET mdp="'.md5($_POST['pass1']).'" WHERE id='.$_SESSION['id_client_trn_pro'].'') ;
					rediriger("espace_professionnel.php?modif_mdp=ok");exit;
				}				
			}
			break;
		case 'devis_encours' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_POST['prix_enchere']) )
			{
				$reso = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
				$total=$reso['total_net']+$reso['total_tva']+$reso['frais_port'];
				$prix_minimum=$total*5/100;$prix_maximum=$total*15/100;
				if ( ceil($_POST['prix'])<ceil($prix_maximum) && ceil($_POST['prix'])>=ceil($prix_minimum) )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND prix_enchere>0 ORDER BY prix_enchere DESC');
					if ( $temp )
					{
						if ( ceil($temp['prix_enchere'])<ceil($_POST['prix']) )
						{
							$tempp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].' AND prix_enchere>0 ');
							if ( $tempp )
								$my->req('INSERT INTO ttre_devis_client_pro VALUES("","'.$_GET['idDevis'].'","'.$_SESSION['id_client_trn_pro'].'","'.$_POST['prix'].'","'.time().'","","","","")');
							else 
								$my->req('UPDATE ttre_devis_client_pro SET prix_enchere="'.$_POST['prix'].'" , date_enchere='.time().' WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].'') ;
							
							//-------------- envoie mail -------------------------------
							$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=2 ');
							$dd = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
							$req=$my->req('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro!='.$_SESSION['id_client_trn_pro'].' ');
							while ( $res=$my->arr($req) )
							{
								$tempo=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client_pro'].' ');
								$nom=$tempo['nom'];$mail=$tempo['email'];
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
								$sujet = $nom_client.' : Prix modifi� pour devis de r�f�rence "'.$dd['reference'].'"';
								$headers = "From: \" ".$nom." \"<".$mail.">\n";
								$headers .= "Reply-To: ".$mail_client."\n";
								$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
								mail($mail,$sujet,$message,$headers);
							}
							rediriger("espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=ok");exit;
						}
						else
						{
							rediriger("espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=nok");exit;
						}
					}
					else
					{
						$my->req('UPDATE ttre_devis_client_pro SET prix_enchere="'.$_POST['prix'].'" , date_enchere='.time().' WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].'') ;
						rediriger("espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=ok");exit;
					}
				}
				elseif ( ceil($_POST['prix'])==ceil($prix_maximum) )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND prix_enchere>0 ORDER BY prix_enchere DESC');
					if ( $temp )
					{
						$tempp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].' AND prix_enchere>0 ');
						if ( $tempp )
							$my->req('INSERT INTO ttre_devis_client_pro VALUES("","'.$_GET['idDevis'].'","'.$_SESSION['id_client_trn_pro'].'","'.$_POST['prix'].'","'.time().'","1","","","")');
						else
							$my->req('UPDATE ttre_devis_client_pro SET prix_enchere="'.$_POST['prix'].'" , date_enchere='.time().' , statut_enchere=1 WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].'') ;
					}
					else 
					{
						$my->req('UPDATE ttre_devis_client_pro SET prix_enchere="'.$_POST['prix'].'" , date_enchere='.time().' , statut_enchere=1 WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].'') ;
					}
					$my->req('UPDATE ttre_devis SET statut_valid_admin="2" WHERE id='.$_GET['idDevis']);
					/*$q=$my->req('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' ORDER BY prix_enchere DESC');
					$i=1;
					while ( $s=$my->arr($q) )
					{
						if ( $i>1 )$my->req('DELETE FROM ttre_devis_client_pro WHERE id="'.$s['id'].'"');
						$i++;
					}*/
					$dd = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
					$temmp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
					$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$temmp['id_client_pro'].' ');
					$nom=$temp['nom'];$mail=$temp['email'];
					//-------------- envoie mail -------------------------------
					$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=3 ');
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
					$sujet = $nom_client.' : Proposotion valid� pour devis de r�f�rence "'.$dd['reference'].'"';
					$headers = "From: \" ".$nom." \"<".$mail.">\n";
					$headers .= "Reply-To: ".$mail_client."\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
					mail($mail,$sujet,$message,$headers);
					rediriger("espace_professionnel.php?contenu=devis_att_paye&idDevis=".$_GET['idDevis']."&enchere=ok");exit;
					exit;
				}
				else
				{
					rediriger("espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=nok");exit;
				}
			}
			break;
		case 'devis_att_paye' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_GET['etape']) && $_GET['etape']=='paiement' && isset($_GET['module']) )
			{
				$type_de_payement='';// 0
				if ( $_GET['module']=='test' )  $type_de_payement='Test';
				elseif ( $_GET['module']=='paypal' ) $type_de_payement='Paypal';
				elseif ( $_GET['module']=='virement' ) $type_de_payement='Virement';
				elseif ( $_GET['module']=='cheque' ) $type_de_payement='Ch�que';
				$my->req ( 'UPDATE ttre_devis_client_pro SET date_payement="'.time().'" , type_payement = "'.$type_de_payement.'" WHERE id = "'.$_GET['idEnchere'].'" ' );
			}
			break;
		case 'devis_histo' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_POST['envoie_message']) )
			{
				$my->req("INSERT INTO ttre_devis_cm VALUES('',
													'".$_GET['idDevis']."',
													'pro',
													'".$my->net_textarea($_POST["message"])."',
													'".time()."'
													)");
				$id=mysql_insert_id();
				for ($i = 1; $i <= $_POST['nbrPhoto']; $i++)
				{
					$image ='';
					$handle = new Upload($_FILES['Photo_'.$i]);
					if ($handle->uploaded)
					{
						//$handle->file_name_body_pre     = 'News_';    // prepends to the name body (default: '')
						//$handle->image_ratio_crop       = true;       // t3abi alcadre wa tkos zayed
						//$handle->image_ratio_fill       = true;       // tkos wa t3abi transparent nakes
						//$handle->image_ratio            = true;       // resize image conserving the original sizes ratio(default: false)
						$handle->image_ratio_no_zoom_in = true;       // same as image_ratio, but won't resize if the source image is smaller than image_x  x image_y  (default: false)
						$handle->image_resize           = true;       // determines is an image will be resized (default: false)
						$handle->image_x                = 800;        // destination image width (default: 150)
						$handle->image_y                = 600;        // destination image height (default: 150)
						$handle->Process('upload/galeries/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.
					
						//$handle->image_ratio_no_zoom_in = true;
						$handle->image_ratio_crop       = true;
						$handle->image_resize           = true;
						$handle->image_x                = 300;
						$handle->image_y                = 300;
						$handle->Process('upload/galeries/300X300/');
					
						$handle->image_ratio_no_zoom_in = true;
						$handle->image_resize           = true;
						$handle->image_x                = 100;
						$handle->image_y                = 100;
						$handle->Process('upload/galeries/100X100/');
						if ($handle->processed)
						{
							$image  = $handle->file_dst_name ;	          // Destination file name
							$handle-> Clean();                           // Deletes the uploaded file from its temporary location
							$my->req('INSERT INTO ttre_devis_cm_photo VALUES("","'.$id.'","'.$image.'")');
						}
					}
				}
				//-------------- envoie mail -------------------------------
				$dd = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
				$temp=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$dd['id_client'].' ');
				$nom=$temp['nom'];$mail=$temp['email'];
				$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=4 ');
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
				$sujet = $nom_client.' : Nouveau message du devis "'.$dd['reference'].'"';
				$headers = "From: \" ".$nom." \"<".$mail.">\n";
				$headers .= "Reply-To: ".$mail_client."\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($mail,$sujet,$message,$headers);
				rediriger("espace_professionnel.php?contenu=devis_histo&idDevis=".$_GET['idDevis']."&envoyer=ok");exit;
			}
			break;
		case 'devisa_att_paye' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_GET['etape']) && $_GET['etape']=='paiement' && isset($_GET['module']) )
			{
				$type_de_payement='';// 0
				if ( $_GET['module']=='test' )  $type_de_payement='Test';
				elseif ( $_GET['module']=='paypal' ) $type_de_payement='Paypal';
				elseif ( $_GET['module']=='virement' ) $type_de_payement='Virement';
				elseif ( $_GET['module']=='cheque' ) $type_de_payement='Ch�que';
				$my->req ( 'UPDATE ttre_achat_devis_client_pro SET date_payement="'.time().'" , type_payement = "'.$type_de_payement.'" WHERE id = "'.$_GET['idEstim'].'" ' );
			}
			break;
		case 'devisa_histo' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_POST['envoie_message']) )
			{
				$my->req("INSERT INTO ttre_achat_devis_cm VALUES('',
													'".$_GET['idDevis']."',
													'pro',
													'".$my->net_textarea($_POST["message"])."',
													'".time()."'
													)");
				$id=mysql_insert_id();
				for ($i = 1; $i <= $_POST['nbrPhoto']; $i++)
				{
					$image ='';
					$handle = new Upload($_FILES['Photo_'.$i]);
					if ($handle->uploaded)
					{
						//$handle->file_name_body_pre     = 'News_';    // prepends to the name body (default: '')
						//$handle->image_ratio_crop       = true;       // t3abi alcadre wa tkos zayed
						//$handle->image_ratio_fill       = true;       // tkos wa t3abi transparent nakes
						//$handle->image_ratio            = true;       // resize image conserving the original sizes ratio(default: false)
						$handle->image_ratio_no_zoom_in = true;       // same as image_ratio, but won't resize if the source image is smaller than image_x  x image_y  (default: false)
						$handle->image_resize           = true;       // determines is an image will be resized (default: false)
						$handle->image_x                = 800;        // destination image width (default: 150)
						$handle->image_y                = 600;        // destination image height (default: 150)
						$handle->Process('upload/galeries/800X600/');                  // This function copies the uploaded file to the given location, eventually performing actions on it.
					
						//$handle->image_ratio_no_zoom_in = true;
						$handle->image_ratio_crop       = true;
						$handle->image_resize           = true;
						$handle->image_x                = 300;
						$handle->image_y                = 300;
						$handle->Process('upload/galeries/300X300/');
					
						$handle->image_ratio_no_zoom_in = true;
						$handle->image_resize           = true;
						$handle->image_x                = 100;
						$handle->image_y                = 100;
						$handle->Process('upload/galeries/100X100/');
						if ($handle->processed)
						{
							$image  = $handle->file_dst_name ;	          // Destination file name
							$handle-> Clean();                           // Deletes the uploaded file from its temporary location
							$my->req('INSERT INTO ttre_achat_devis_cm_photo VALUES("","'.$id.'","'.$image.'")');
						}
					}
				}
				//-------------- envoie mail -------------------------------
				$dd = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
				$temp=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$dd['id_client'].' ');
				$nom=$temp['nom'];$mail=$temp['email'];
				$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=4 ');
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
				$sujet = $nom_client.' : Nouveau message du devis avec achat imm�diat "'.$dd['reference'].'"';
				$headers = "From: \" ".$nom." \"<".$mail.">\n";
				$headers .= "Reply-To: ".$mail_client."\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($mail,$sujet,$message,$headers);
				rediriger("espace_professionnel.php?contenu=devisa_histo&idDevis=".$_GET['idDevis']."&envoyer=ok");exit;
			}
			break;
		case 'mdp_perdu' :
			if ( isset($_SESSION['id_client_trn_pro']) ) {rediriger("espace_professionnel.php");exit;}
			if ( isset($_POST['mdp_perdu']) )
			{
				$rec=$my->req('SELECT * FROM ttre_client_pro WHERE email = "'.$_POST['mail'].'" ');
				if ( $my->num($rec)==0 ){rediriger("espace_professionnel.php?contenu=mdp_perdu&erreur=mail");exit;}
				else
				{
					$can=$my->arr($rec);
					# G�n�ration d'un mots de passe al�atoire
					$chaine = "abBDEFcdefghijkmnPQRSTUVWXYpqrst23456789"; 
					srand((double)microtime()*1000000); 
					
					$pass = ''; 
					for($i=0; $i<8; $i++) 
					{ 
						$pass .= $chaine[rand()%strlen($chaine)];  
					}
					
					$passBdd = md5($pass);
					$referencePass = uniqid('R');
					
					$my->req('DELETE FROM ttre_client_pro_generation_pass WHERE cgp_client_id='.$can['id']);
					$my->req("INSERT INTO ttre_client_pro_generation_pass VALUES('','".$can['id']."','".$my->net_input($passBdd)."','".$my->net_input($referencePass)."')");
					$message ='
						<html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
							<title>'.$nom_client.'</title>
						</head>
						
						<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#0066CC; font-size:14px;">
							<div id="en-tete" style="height:40px; width:800px; background-repeat:no-repeat; text-align:right;">
								<p><a href="'.$url_site_client.'/espace_professionnel.php">Mon compte</a></p>
							</div>
					
							<div id="corps" style="width:800px; height:auto;">
								<h1 style="background-color:#FBD525; color:#FFF; font-size:16px; text-align:center;">Nouveau mot de passe</h1>
										
								<p>Bonjour,</p>																
								<p>Voici un mail automatique qui vous a �t� envoy�, suite � votre demande de modification de mots de passe. Vous trouverez dans cet e-mail votre nouveau mots de passe qui sera effectif � partir du moment o� vous l\'aurez valid�.</p>
								<div id="contenu-corps" style="background-color:#E6E6E6; text-align:center; font-size:14px; padding:10px;">
								
									<p>
										Nouveau mot de passe : '.$pass.'
									<br />
										Si vous avez demand� cette modification, veuillez cliquer sur le lien pour valider votre nouveau mots de passe : <br /> <a href="'.$url_site_client.'/espace_professionnel.php?contenu=mdp_perdu&ref='.$referencePass.'">Changement de mots de passe</a>.
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
					$prenom = html_entity_decode($can['prenom']);
					$email = html_entity_decode($can['email']);
					$sujet = $nom_client.' : Mot de passe perdu';
					$headers = "From: \" ".$nom." ".$prenom." \"<".$email.">\n";
					$headers .= "Reply-To: ".$mail_client."\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
					mail($email,$sujet,$message,$headers);
					rediriger("espace_professionnel.php?contenu=mdp_perdu&mdpperdu=ok");exit;
				}
			}
			elseif ( isset($_GET['ref']) )
			{
				$ligne=$my->req('SELECT * FROM ttre_client_pro_generation_pass WHERE cgp_reference="'.$_GET['ref'].'"');
				if ( $my->num($ligne)==0 ) {rediriger("espace_professionnel.php?contenu=mdp_perdu&erreur=mdp");exit;}
				else
				{
					$forget=$my->arr($ligne);
					$req_modif = $my->req ( 'UPDATE ttre_client_pro SET mdp="'.$my->net_input($forget['cgp_mdp']).'" WHERE id = "'.$forget['cgp_client_id'].'"' );
					rediriger("espace_professionnel.php?valid_mdp=ok");exit;
				}				
			}
			break;	
		case 'deconnexion' :
			unset ($_SESSION['id_client_trn_pro']);
			unset ($_SESSION['id_client_trn_pro_desactiver']);
			unset ($_SESSION['panier_trn']);
			rediriger("espace_professionnel.php");exit;
			break;	
	}
}
// ----------------------------------------------------pour varAriane ----------------------------
if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'inscription' :
			$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Inscription</span>';
			break;
		case 'modif_param' :
			$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Informations personnelles</span>';
			break;
		case 'modif_mdp' :
			$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Mot de passe</span>';
			break;
		case 'devis_encours' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_encours">Devis en cours</a></span> >
						      <span class="courant">D�tail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Devis en cours</span>';
			break;
		case 'devis_att_paye' :
			if ( !isset($_GET['etape']) && isset($_GET['idDevis']) ) 
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_att_paye">Devis en attende de payement</a></span> >
						      <span class="courant">D�tail</span>';
			elseif ( isset($_GET['etape']) && $_GET['etape']=='paiement' )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_att_paye">Devis en attende de payement</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'">D�tail</a></span> >
						      <span class="courant">Paiement</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Devis en attende de payement</span>';
			break;
		case 'devis_histo' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_histo">Historique</a></span> >
						      <span class="courant">D�tail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Historique</span>';
			break;
		case 'devisa_att_paye' :
			if ( !isset($_GET['etape']) && isset($_GET['idDevis']) ) 
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_att_paye">Devis avec achat imm�diat en attende de payement</a></span> >
						      <span class="courant">D�tail</span>';
			elseif ( isset($_GET['etape']) && $_GET['etape']=='paiement' )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_att_paye">Devis avec achat imm�diat en attende de payement</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'">D�tail</a></span> >
						      <span class="courant">Paiement</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Devis avec achat imm�diat en attende de payement</span>';
			break;
		case 'devisa_histo' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_histo">Historique</a></span> >
						      <span class="courant">D�tail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Historique</span>';
			break;
		case 'mdp_perdu' :
			$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Nouveau mot de passe</span>';
			break;	
	}
}
else
{
	if ( !isset($_SESSION['id_client_trn_pro']) )
	{
		$varAriane = '<a href="espace_professionnel.php">Mon compte</a>  ';
	}
	else 
	{
		$varAriane = '<a href="espace_professionnel.php">Mon compte</a>';
	}
}
// -------------------------------------------------------------------------------------------------


$pageTitle = "Espace Professionnel | Devis gratuit en ligne et sans aucun engagement"; 
 include('inc/head.php');?>
	<body id="page1">

<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
<div class="wrapper">
					<div class="professional-space">
						<div class="container">
							<div class="row">
							<div class="col-md-12">
								<h2>Espace Professionnel</h2>
								<h5>G�rer toutes vos informations personnelles ainsi que vos devis</h5>
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
									<!-- <div class="bttn-devis">
										<ul>
											<li><a href="devis.php"><i>Cr�er votre devis</i></a></li>
											<li><a href="prix-travaux.php"><i>Devis Imm�diat</i></a></li>
										</ul>
									</div> -->
							</div>
							</div>
						</div>
					</div>

					<div id="content">
						<div class="container">
							<div class="row">
							<div class="espace-professionnel col-md-12">


<script type="text/javascript">
$(document).ready(function() {								

	$('form[name="client_conn"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.email_connexion.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.email_connexion.value))) { mes_erreur+='<p>Votre Adresse mail est incorrect !</p>'; } }
		if( !$.trim(this.mdp_connexion.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
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
	$('form[name="client_ajout"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.numvoie_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Num�ro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( !$.trim(this.ville.value) ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
		if( !$.trim(this.nom_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Pr�nom !</p>'; }
		if( !$.trim(this.telephone_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ T�l�phone !</p>'; }
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
		if ( !$('#condition').is(':checked') ){ mes_erreur+='<p>Il faut accepter les condition g�n�rales !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});
	$('form[name="client_modif"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.numvoie.value) ) { mes_erreur+='<p>Il faut entrer le champ Num�ro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( !$.trim(this.ville.value) ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
		if( !$.trim(this.nom.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom.value) ) { mes_erreur+='<p>Il faut entrer le champ Pr�nom !</p>'; }
		if( !$.trim(this.telephone.value) ) { mes_erreur+='<p>Il faut entrer le champ T�l�phone !</p>'; }
		if( !$.trim(this.mail.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mail.value))) { mes_erreur+='<p>Votre Adresse mail est incorrect !</p>'; } }
		if( !$.trim(this.mailc.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail de confirmation !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mailc.value))) { mes_erreur+='<p>Votre Adresse mail de confirmation est incorrect !</p>'; } }
		if( $.trim(this.mail.value)!=$.trim(this.mailc.value) ) { mes_erreur+='<p>Erreur de confirmation Mail !</p>'; }
		if( !$.trim(this.validation.value) ) { mes_erreur+='<p>Il faut entrer le champ code de validation !</p>'; }
		if ( !$('#condition').is(':checked') ){ mes_erreur+='<p>Il faut accepter les condition g�n�rales !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});
	$('form[name="mdp_modif"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.pass.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe actuel !</p>'; }
		if( !$.trim(this.pass1.value) ) { mes_erreur+='<p>Il faut entrer le champ Nouveau mot de passe !</p>'; }
		if( !$.trim(this.pass2.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe de confirmation !</p>'; }
		if( $.trim(this.pass1.value)!=$.trim(this.pass2.value) ) { mes_erreur+='<p>Erreur V�rifiaction du mot de passe !</p>'; }
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
	$('form[name="message_envoie"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.message.value) ) { mes_erreur+='<p>Il faut entrer le champ Message !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
	$('form[name="form_paiemant"]').submit();
});
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script> 	
<script type="text/javascript">
function addRowToTablePhoto()
{
  	var tbl = document.getElementById('tblPhoto');
 	var lastRow = tbl.rows.length;
  	var iteration = lastRow-1;
  
  	var row = tbl.insertRow(lastRow);
  	/*$("#tblPhoto tr:last").css("background-color","#E5E5E5");*/
  	  
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	var cellRightSel = row.insertCell(1);
  	var el=$('<input type="file" name="Photo_'+iteration+'" />');
  	$(cellRightSel).append(el);
	
	document.getElementById('nbrPhoto').value = iteration;
}
function removeRowFromTablePhoto()
{
  	var tbl = document.getElementById('tblPhoto');
  	var lastRow = tbl.rows.length;
  	if (lastRow > 3) 
  	{
      	tbl.deleteRow(lastRow - 1);
      	document.getElementById('nbrPhoto').value --;
  	}
}
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
		'height'			: '70%',
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
			<cite>Vous �tes ici : </cite>
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
			$check_activite='';
			$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
			if ( $my->num($reqCat)>0 )
			{
				$i=0;
				while ( $resCat=$my->arr($reqCat) )
				{
					$check_activite.='<input id="ip_act" type="checkbox" name="categorie[]" value="'.$resCat['id'].'" /> '.$resCat['titre'].'<br /> ';
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
					$zone_intervention.='<td><input id="ip_zone" type="checkbox" name="departement[]" value="'.$resCat['departement_id'].'" /> '.$resCat['departement_nom'].'</td>';
					if ( $i%3==0 ) $zone_intervention.='</tr>';
					$i++;
				}
				$zone_intervention.='</table>';
			}
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est d�j� associ� � un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erron�.</p></div><br />';
				
			$mmention=$my->req_arr('SELECT * FROM ttre_mention WHERE id = 1');
				
			echo'
				'.$alert.'
				<div id="">
					<form name="client_ajout" action="espace_professionnel.php?contenu=inscription" method="post" enctype="multipart/form-data" >
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="form-groupe-pro ">
									<div class="title-info"><h1>Informations personnelles</h1></div>
						<p>
							<label for="ip_fo">Forme juridique : </label>
							<input id="ip_fo" type="text" name="juridique_nouveau"/>
						</p>
						<p>
							<label for="ip_ra">Raison sociale : </label>
							<input id="ip_ra" type="text" name="raison_nouveau"/>
						</p>
						<p>
							<label for="ip_ta">Taille de l\'entreprise : </label>
							<input id="ip_ta" type="text" name="taille_nouveau"/>
						</p>
						<p>
							<label for="ip_voi">Num�ro et voie : <span class="obli">*</span></label>
							<input id="ip_voi" type="text" name="numvoie_nouveau"/>
						</p>
						<p>
							<label for="ip_ca">Compl�ment d\'adresse : </label>
							<input id="ip_ca" type="text" name="cadresse_nouveau"/>
						</p>
						<p>
							<label for="ip_cp">Code postal : <span class="obli">*</span></label>
							<input id="ip_cp" type="text" name="cp"/>
						</p>
						<p>
							<label for="ip_ville">Ville : <span class="obli">*</span></label>
							<select id="ip_ville" name="ville"/></select>
						</p>
						<p>
							<label for="ip_pays">Pays : <span class="obli">*</span></label>
							<input id="ip_pays" type="text" name="pays_nouveau" value="France" readonly="readonly" />
						</p>
						<p>
							<label for="ip_see">Num�ro de SIREEN : </label>
							<input id="ip_see" type="text" name="numsireen_nouveau"/>
						</p>
						<p>
							<label for="ip_civ">Civilit� : <span class="obli">*</span></label>
							<input id="ip_civ" type="radio" value="Mr" name="civ_nouveau" checked="checked" /> Mr 
							<input id="ip_civ" type="radio" value="Mme" name="civ_nouveau"/> Mme 
							<input id="ip_civ" type="radio" value="Mlle" name="civ_nouveau"/> Mlle 
						</p>
						<p>
							<label for="ip_nom">Nom : <span class="obli">*</span></label>
							<input id="ip_nom" type="text" name="nom_nouveau"/>
						</p>
						<p>
							<label for="ip_prenom">Pr�nom : <span class="obli">*</span></label>
							<input id="ip_prenom" type="text" name="prenom_nouveau"/>
						</p>
						<p>
							<label for="ip_tel">T�l�phone : <span class="obli">*</span></label>
							<input id="ip_tel" type="text" name="telephone_nouveau"/>
						</p>
						<p>
							<label for="ip_fax">Fax : </label>
							<input id="ip_fax" type="text" name="fax_nouveau"/>
						</p>
						<p>
							<label for="ip_mail">Email : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" name="mail_nouveau" oncopy="return false;" onpaste="return false;"/>
						</p>
						<p>
							<label for="ip_mail">Email de confirmation : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" name="mailc_nouveau" oncopy="return false;" onpaste="return false;"/>
						</p>
						<p>
							<label for="ip_fi1">T�l�chargement de justificatifs K bis : </label>
							<input id="ip_fi1" type="file" style="width:200px;" name="fich1_nouveau" />
						</p>
						<p>
							<label for="ip_fi2">T�l�chargement d\'assurance d�cennal : </label>
							<input id="ip_fi2" type="file" style="width:200px;" name="fich2_nouveau" />
						</p>
						<p>
							<label for="ip_fi3">Autre documents : </label>
							<input id="ip_fi3" type="file" style="width:200px;" name="fich3_nouveau" />
						</p>
						<p>
							<label for="ip_act" style="height:55px;margin:40px 0 0 0;" >Votre activit� a cochez : <span class="obli">*</span></label>
							'.$check_activite.'
						</p>
						<p>
							<label for="ip_zone" >Zone d\'intervention : <span class="obli">*</span></label><br />
							'.$zone_intervention.'<br />
						</p>
						<p>
							<label for="ip_mdp">Mot de passe : <span class="obli">*</span></label>
							<input id="ip_mdp" type="password" name="pass1_nouveau" />
						</p>
						<p>
							<label for="verif_mdp">Mot de passe <br /> de confirmation : <span class="obli">*</span></label>
							<input id="verif_mdp" type="password" name="pass2_nouveau" />
						</p>		
						<div class="valid">
							<label for="validation">Veuillez recopier le code <img src="Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
							<input id="validation" type="text" name="validation" />
						</div>		
						<p>
							<input type="checkbox" name="partenaire" checked="checked" /> Acceptation de recevoir offres partenaire
						</p>
						<p>
							<input type="checkbox" name="newsletter" checked="checked" /> S\'inscrire � notre newsletter
						</p>
						<p>
							<input type="checkbox" name="condition" id="condition"/> Acceptation des <a href="mentionPro.php" target="_blanc" title="Conditions g�n�rales"> conditions g�n�rales </a>
						</p>
						
						<p class="align_center padding_tb_20">
							<input value="valider" class="sub" type="submit" name="ajout_client"/>
						</p>
						<p class="note" id="text_erreur"><cite>( * ) champs obligatoires.</cite></p>
						
						</div>
						</div>
						</div>
						</div>
					</form>	
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>
				</div>
				<div style="display: none;">
						<div id="inline_insc" style="width:90%;height:500px;overflow:auto;">
							<div id="espace_compte" style="width:80%;margin:0 0 0 25px;">
								'.$mmention['description'].'
							</div>
						</div>
					</div>
				</div>
				';			
			break;
		case 'modif_param' :
			$cl=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_SESSION['id_client_trn_pro'].' ');
			$civ1='';$civ2='';$civ3='';
			if ( $cl['civ']=='Mr' ) $civ1='checked="checked"';
			elseif ( $cl['civ']=='Mme' ) $civ2='checked="checked"';
			elseif ( $cl['civ']=='Mlle' ) $civ3='checked="checked"';
			$optionville='';
			$req=$my->req('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$cl['code_postal'].' ORDER BY ville_id ASC');
			if ( $my->num($req)>0 )
			{
				$optionville='<option value="0"></option>';
				while ( $res=$my->arr($req) ) 
				{
					if ( $res['ville_id']==$cl['ville'] ) $sel='selected="selected"'; else $sel=''; 
					$optionville.='<option value="'.$res['ville_id'].'" '.$sel.' >'.$res['ville_nom_reel'].'</option>';
				}
			}
			$fichier1='';
			if ( !empty($cl['fichier1']) ) 
				$fichier1='
							<a href="upload/client_pro/fichiers/'.$cl['fichier1'].'" target="_blanc">'.$cl['fichier1'].'</a>
							 | Supprimer <input type="checkbox" name="suppr_fich1" value="1" /> <br />
						  ';
			$fichier2='';
			if ( !empty($cl['fichier2']) ) 
				$fichier2='
							<a href="upload/client_pro/fichiers/'.$cl['fichier2'].'" target="_blanc">'.$cl['fichier2'].'</a>
							 | Supprimer <input type="checkbox" name="suppr_fich2" value="1" /> <br />
						  ';
			$fichier3='';
			if ( !empty($cl['fichier3']) ) 
				$fichier3='
							<a href="upload/client_pro/fichiers/'.$cl['fichier3'].'" target="_blanc">'.$cl['fichier3'].'</a>
							 | Supprimer <input type="checkbox" name="suppr_fich3" value="1" /> <br />
						  ';
			$check_activite='';
			$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
			if ( $my->num($reqCat)>0 )
			{
				$i=0;
				while ( $resCat=$my->arr($reqCat) )
				{
					$check='';
					$temp=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$_SESSION['id_client_trn_pro'].' AND id_categorie='.$resCat['id'].' ');
					if ( $my->num($temp)>0 )$check='checked="checked"';
					$check_activite.='<input id="ip_act" type="checkbox" '.$check.' name="categorie[]" value="'.$resCat['id'].'" /> '.$resCat['titre'].'<br /> ';
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
					$temp=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$_SESSION['id_client_trn_pro'].' AND id_departement='.$resCat['departement_id'].' ');
					if ( $my->num($temp)>0 )$check='checked="checked"';
					$zone_intervention.='<td><input id="ip_zone" type="checkbox" '.$check.' name="departement[]" value="'.$resCat['departement_id'].'" /> '.$resCat['departement_nom'].'</td>';
					if ( $i%3==0 ) $zone_intervention.='</tr>';
					$i++;
				}
				$zone_intervention.='</table>';
			}
			
			if ( $cl['newsletter']==0 ) $news_check=''; else $news_check='checked="checked"';
			$req_part=$my->req('SELECT * FROM ttre_partenaire_pro WHERE email="'.$cl['email'].'" ');
			if ( $my->num($req_part)==0 ) $part_check=''; else $part_check='checked="checked"';
			
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est d�j� associ� � un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erron�.</p></div><br />';
						
			$mmention=$my->req_arr('SELECT * FROM ttre_mention WHERE id = 1');			
			
			echo'
				'.$alert.'
				<div id="">
					<form name="client_modif" action="espace_professionnel.php?contenu=modif_param" method="post" enctype="multipart/form-data">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="form-groupe-pro">
									<div class="title-info"><h1>Informations personnelles</h1></div>
						
							<label for="ip_fo">Forme juridique : </label><br />
							<input id="ip_fo" type="text" name="juridique" value="'.$cl['juridique'].'"/><br/>
						
						
							<label for="ip_ra">Raison sociale : </label><br />
							<input id="ip_ra" type="text" name="raison" value="'.$cl['raison'].'"/><br/>
						
						
							<label for="ip_ta">Taille de l\'entreprise : </label><br />
							<input id="ip_ta" type="text" name="taille" value="'.$cl['taille'].'"/><br/>
						
							<label for="ip_voi">Num�ro et voie : <span class="obli">*</span></label><br />
							<input id="ip_voi" type="text" name="numvoie" value="'.$cl['num_voie'].'"/><br/>
						
						
							<label for="ip_ca">Compl�ment d\'adresse : </label><br/>
							<input id="ip_ca" type="text" name="cadresse" value="'.$cl['cadresse'].'"/><br/>
						
						
							<label for="ip_cp">Code postal : <span class="obli">*</span></label><br/>
							<input id="ip_cp" type="text" name="cp" onKeyPress="return scanTouche(event)" value="'.$cl['code_postal'].'"/><br/>
						
							<label for="ip_ville">Ville : <span class="obli">*</span></label><br/>
							<select id="ip_ville" name="ville"/>'.$optionville.'</select><br/>
						
							<label for="ip_pays">Pays : <span class="obli">*</span></label><br/>
							<input id="ip_pays" type="text" name="pays" value="France" readonly="readonly" value="'.$cl['pays'].'" />
						</p>
						<p>
							<label for="ip_see">Num�ro de SIREEN : </label>
							<input id="ip_see" type="text" name="numsireen" value="'.$cl['num_sireen'].'"/>
						</p>
						<p>
							<label for="ip_civ">Civilit� : <span class="obli">*</span></label>
							<input id="ip_civ" type="radio" value="Mr" name="civ" '.$civ1.' /> Mr 
							<input id="ip_civ" type="radio" value="Mme" name="civ" '.$civ2.' /> Mme 
							<input id="ip_civ" type="radio" value="Mlle" name="civ" '.$civ3.' /> Mlle 
						</p>
						<p>
							<label for="ip_nom">Nom : <span class="obli">*</span></label>
							<input id="ip_nom" type="text" name="nom" value="'.$cl['nom'].'"/>
						</p>
						<p>
							<label for="ip_prenom">Pr�nom : <span class="obli">*</span></label>
							<input id="ip_prenom" type="text" name="prenom" value="'.$cl['prenom'].'"/>
						</p>
						<p>
							<label for="ip_tel">T�l�phone : <span class="obli">*</span></label>
							<input id="ip_tel" type="text" name="telephone" value="'.$cl['telephone'].'"/>
						</p>
						<p>
							<label for="ip_fax">Fax : </label>
							<input id="ip_fax" type="text" name="fax" value="'.$cl['fax'].'"/>
						</p>
						<p>
							<label for="ip_mail">Email : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" name="mail" oncopy="return false;" onpaste="return false;" value="'.$cl['email'].'"/>
						</p>
						<p>
							<label for="ip_mail">Email de confirmation : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" name="mailc" oncopy="return false;" onpaste="return false;" value="'.$cl['email'].'"/>
						</p>
						<p>
							<label for="ip_fi1">T�l�chargement de justificatifs K bis : </label>
							'.$fichier1.'<input id="ip_fi1" type="file" style="width:200px;" name="fich1" />
						</p>
						<p>
							<label for="ip_fi2">T�l�chargement d\'assurance d�cennal : </label>
							'.$fichier2.'<input id="ip_fi2" type="file" style="width:200px;" name="fich2" />
						</p>
						<p>
							<label for="ip_fi3">Autre documents : </label>
							'.$fichier3.'<input id="ip_fi3" type="file" style="width:200px;" name="fich3" />
						</p>
						<p>
							<label for="ip_act" style="height:55px;margin:40px 0 0 0;" >Votre activit� a cochez : <span class="obli">*</span></label>
							'.$check_activite.'
						</p>
						<p>
							<label for="ip_zone" >Zone d\'intervention : <span class="obli">*</span></label><br />
							'.$zone_intervention.'<br />
						</p>
						<div class="valid">
							<label for="validation">Veuillez recopier le code <img src="Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
							<input id="validation" type="text" name="validation" />
						</div>		
						<p>
							<input type="checkbox" name="partenaire" '.$part_check.' /> Acceptation de recevoir offres partenaire
						</p>
						<p>
							<input type="checkbox" name="newsletter" '.$news_check.' /> S\'inscrire � notre newsletter
						</p>
						<p>
							<input type="checkbox" name="condition" id="condition"/> Acceptation des <a href="mentionPro.php" target="_blanc" title="Conditions g�n�rales"> conditions g�n�rales </a>
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
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>
				</div>
				<div style="display: none;">
						<div id="inline_insc2" style="width:90%;height:500px;overflow:auto;">
							<div id="espace_compte" style="width:80%;margin:0 0 0 25px;">
								'.$mmention['description'].'
							</div>
						</div>
					</div>
				</div>
				';		
				break;
		case 'modif_mdp' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) )$alert='<div id="note" class="error"><p>Votre ancien mot de passe est incorrecte, merci de r�-essayer.</p></div><br />';
			echo'
				'.$alert.'
				<div id="">
					<form name="mdp_modif" method="post" class="">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="form-groupe-pro ">
									<div class="title-info"><h1>Nouveau mot de passe :</h1></div>
									<label for="mdp">Mot de passe actuel : <span class="obli">*</span></label><br/>
									<input id="mdp" type="password" name="pass" /><br/>

									<label for="mdpp">Nouveau mot de passe : <span class="obli">*</span></label><br/>
									<input id="mdpp" type="password" name="pass1" /><br/>

									<label for="verif_mdp">Confirmer nouveau mot de passe : <span class="obli">*</span></label><br/>
									<input id="verif_mdp" type="password" name="pass2" /><br/>

									<p class="align_center padding_tb_20">
										<input value="Modifier mon mot de passe" type="submit" name="modif_mdp"/>
									</p>
									<p class="note" id="text_erreur"><cite>( * ) Champs Obligatoires.</cite></p>
								</div>
							</div>
						</div>
					</div>
					</form>	
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>
				</div>
				';
			break;
		case 'devis_encours' :
			if ( isset($_GET['idDevis']) )
			{
				$infos_devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
				$total=number_format($infos_devis['total_net']+$infos_devis['total_tva']+$infos_devis['frais_port'],2);
				$detail='
					<div class="col-md-12">
						<ul id="compte_details_com">
							<li>
								<h4>Informations g�n�rales</h4>
								<dl>
									<dt>Date Devis : </dt>
									<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
									<dt>R�f�rence : </dt>
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
						<li class="right-info">
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>
						</li>
					</ul>
					</div>';
				$detail.='
				<div class="col-md-12">
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Pi�ce</td>														
								<td>D�signation</td>														
								<td>P.U</td>
								<td>Qte</td>
								<td>Unit�</td>
								<td>Total</td>
							</tr>	
						';
				$nom_cat='';
				$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
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
								<td>'.number_format($ress['prix'], 2,'.','').' �</td>
								<td>'.$ress['qte'].'</td>
								<td>'.$ress['unite'].'</td>
								<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' �</td>
							</tr>
						';
				}
				$reqqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
				while ( $resss=$my->arr($reqqq) )
				{
					$temp=$my->req_arr('SELECT SUM(valeur_tva_prod) AS prix_total FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' AND tva='.$resss['id'].' ');
					if ( $temp['prix_total'] > 0 )
						$detail.='
								<tr class="total">
									<td colspan="5"><strong>'.$resss['titre'].' : </strong></td>
									<td colspan="1" class="prix_final">'.number_format($temp['prix_total'], 2,'.','').'�</td>
								</tr>
								';
				}
				$detail.='
						<tr class="total">
							<td colspan="5"><strong>Total TTC : </strong></td>
							<td colspan="1" class="prix_final">'.$total.' �</td>
						</tr>
					</table></div>';
				$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND prix_enchere>0 ORDER BY prix_enchere DESC');
				if ( $temp )
				{
					if ( $temp['id_client_pro']==$_SESSION['id_client_trn_pro'] )
						$texte='<p>Pour l\'instant vous etes le meilleure enchereur</p>
								<p>Dernier prix propos� : '.$temp['prix_enchere'].' � � la date '.date('d/m/Y',$temp['date_enchere']).' </p>';
					else
						$texte='<p>Il ya quelqu\'un qui a encheri sur vous</p>
								<p>Dernier prix propos� : '.$temp['prix_enchere'].' � � la date '.date('d/m/Y',$temp['date_enchere']).' </p>';
				}
				else
				{
					$texte='<p>Aucun client a donner une proposotion � ce moment</p>';
				}
				$alert='<div id="note"></div><br />';
				if ( isset($_GET['modif_prix']) && $_GET['modif_prix']=='nok')$alert='<div id="note" class="error"><p>Erreur prix.</p></div><br />';
				if ( isset($_GET['modif_prix']) && $_GET['modif_prix']=='ok')$alert='<div id="note" class="success"><p>Prix modifi�.</p></div><br />';
					
				$reso = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
				$total=$reso['total_net']+$reso['total_tva']+$reso['frais_port'];
				$prix_min=ceil($total*5/100);$prix_max=ceil($total*15/100);
				
				$detail.='
					<a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aper�u avant imprimer</a>
					'.$alert.'
					
					<form name="prix_enchere" method="post" action="espace_professionnel.php?contenu=devis_encours&idDevis='.$_GET['idDevis'].'" class="" >
					<div class="col-md-4 price1">
							<h2>Prix : </h2><br/>
							<h6>'.$texte.'</h6><br/>
							<p>
								<label for="ip_mail">Prix ( Entre '.$prix_min.' et '.$prix_max.' ) :<span class="obli">*</span></label>
								<input required id="ip_mail" type="text" name="prix" onKeyPress="return scanTouche(event)"/>
							</p>
							<p class="align_center padding_tb_20">
								<input value="Envoyer" type="submit" name="prix_enchere"/>
							</p>
					</div>
					</form>
				
					<p class="margin_top_20 col-md-12"><a href="espace_professionnel.php?contenu=devis_encours">Retour � la page pr�c�dente</a></p>
						';
				echo'
					<div id="espace_compte">
						'.$detail.'
					</div>
					';
			}
			else
			{
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_devis_client_pro dc , ttre_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=1 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND d.date_valid_mazad>'.time().' ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>R�f�rence</td>							
									<td>Date</td>
									<td class="montant">Montant</td>								
									<td class="width_60">D�tails</td>								
								</tr>
						';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$res['id_devis'].' ');
						$total=$ress['total_net']+$ress['total_tva']+$ress['frais_port'];
						$liste.='
								<tr>
									<td><a href="espace_professionnel.php?contenu=devis_encours&idDevis='.$res['id_devis'].'">'.$ress['reference'].'</a></td>
									<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
									<td><strong>'.number_format($total, 2,'.','').' �</strong></td>
									<td><a href="espace_professionnel.php?contenu=devis_encours&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								</tr>
								';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>';
				}
				else
				{
					$liste.='<p>Aucune devis � cet instant.</p>';
				}
				echo'
					<div id="espace_compte">
						'.$liste.'
					</div>
					';
			}
			break;	
		case 'devis_att_paye' :
			if ( isset($_GET['idDevis']) )
			{
				if ( ! isset($_GET['etape']) )
				{
					$infos_devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
					$total=number_format($infos_devis['total_net']+$infos_devis['total_tva']+$infos_devis['frais_port'],2);
					$detail='
							<ul id="compte_details_com">
								<li>
									<h4>Informations g�n�rales</h4>
									<dl>
										<dt>Date Devis : </dt>
										<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
										<dt>R�f�rence : </dt>
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
							<li>
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>'.$code_postal.' '.$ville.'</dd>
									<dd>'.$pays.'</dd>
								</dl>
							</li>
						</ul>';
					$detail.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Pi�ce</td>														
									<td>D�signation</td>														
									<td>P.U</td>
									<td>Qte</td>
									<td>Unit�</td>
									<td>Total</td>
								</tr>	
							';
					$nom_cat='';
					$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
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
									<td>'.number_format($ress['prix'], 2,'.','').' �</td>
									<td>'.$ress['qte'].'</td>
									<td>'.$ress['unite'].'</td>
									<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' �</td>
								</tr>
							';
					}
					$reqqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
					while ( $resss=$my->arr($reqqq) )
					{
						$temp=$my->req_arr('SELECT SUM(valeur_tva_prod) AS prix_total FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' AND tva='.$resss['id'].' ');
						if ( $temp['prix_total'] > 0 )
							$detail.='
									<tr class="total">
										<td colspan="5"><strong>'.$resss['titre'].' : </strong></td>
										<td colspan="1" class="prix_final">'.number_format($temp['prix_total'], 2,'.','').'�</td>
									</tr>
									';
					}
					$detail.='
							<tr class="total">
								<td colspan="5"><strong>Total TTC : </strong></td>
								<td colspan="1" class="prix_final">'.$total.' �</td>
							</tr>
						</table><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aper�u avant imprimer</a>	';
					
					
					$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
					$detail.='<p>Prix propos� : '.$temp['prix_enchere'].' �  </p>';
					

					$detail.='
						<p id="panier_boutons"><input type="button" value="Payer" onclick="javascript:window.location=\'espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement\'" /></p>
						<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devis_att_paye">Retour � la page pr�c�dente</a></p>
                        
							';
					if ( isset($_GET['enchere']) )$alert='<div id="note" class="success"><p>Vous avez gagn� l\'enchere.</p></div><br />';
					echo'									
						'.$alert.'
						<div id="espace_compte">
							'.$detail.'
						</div>
						';
				}
				elseif ( isset($_GET['etape']) && $_GET['etape']=='paiement' )
				{
					if ( !isset($_GET['module']) )
					{
						$adcp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].' ');
						$module_Test='';$module_paypal='';$module_virement='';$module_cheque='';
						//$module_Test='<p style="text-align: center;">Notre solution de paiement en ligne est en cours d\'int�gration,<br /> merci de revenir plus tard.';
						if ( $_SESSION['id_client_trn_pro']==72 )
						{
							$module_Test='
						 				<p class="payment_module">
						 					<a title="Payer par Test" href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=test&idEnchere='.$adcp['id'].'">
						 						<img width="86" height="49" alt="Test" src="stockage_img/test.jpg">
						 						Test
						 					</a>
						 				</p>
						 		';
						 }
						$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=1 ');
						if ( $temp['statut']==1 && !empty($temp['val1']) ) 
						{
							$module_paypal='
										<p class="payment_module">
											<a title="Payer par Paypal" href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=paypal&idEnchere='.$adcp['id'].'">
												<img width="86" height="49" alt="Payer par Paypal" src="carte-bleue.jpeg">
												Payer par Carte bleue
											</a>
										</p>
											';
						}
						$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=2 ');
						if ( $temp['statut']==1 && !empty($temp['val1']) && !empty($temp['val2']) && !empty($temp['val3']) ) 
						{
							$module_virement='
										<p class="payment_module">
											<a title="Payer par Virement" href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=virement&idEnchere='.$adcp['id'].'">
												<img width="86" height="49" alt="Payer par Virement" src="stockage_img/bankwire.jpg">
												Payer par Virement bancaire 
											</a>
										</p>
											';
						}
						$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=3 ');
						if ( $temp['statut']==1 && !empty($temp['val1']) && !empty($temp['val2']) ) 
						{
							$module_cheque='
											<p class="payment_module">
												<a title="Payer par Ch�que" href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=cheque&idEnchere='.$adcp['id'].'">
													<img width="86" height="49" alt="Payer par Virement" src="stockage_img/cheque.jpg">
													Payer par Ch�que 
												</a>
											</p>
											';
						}
						echo'
							<div id="HOOK_PAYMENT" style="width: 530px; margin: 0px 0px 0px 50px;">
								'.$module_Test.'
								'.$module_paypal.'
								'.$module_virement.'
								'.$module_cheque.'
							</div>
							<div id="espace_compte">
								<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'">Retour � la page pr�c�dente</a></p>
							</div>
							';
					}
					else
					{
						if ( $_GET['module']=='test' )
						{
							echo'
								<div id="espace_compte">
									<a href="espace_professionnel.php?contenu=devis_att_paye&idEncherePaye='.$_GET['idEnchere'].'">Paiement effectu�</a> |
									<a href="espace_professionnel.php?contenu=devis_att_paye&paiement=annuler">Paiement annul�</a></p>
								</div>
								';
						}
						elseif ( $_GET['module']=='paypal' )
						{
							$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=1 ');
							$tempdevis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
							$tempdevisclient=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id='.$_GET['idEnchere'].' ');
							$test=0;
							if ( $test==1 )
							{
								$action_form='https://www.sandbox.paypal.com/cgi-bin/webscr';
								$email_business='bilelbusiness@yahoo.fr';
								$ipn='ipn_test.php'; 
							}
							else
							{
								//$action_form='https://ipnpb.paypal.com/cgi-bin/webscr';
								$action_form='https://www.paypal.com/cgi-bin/webscr';
								$email_business=$temp['val1'];
								$ipn='ipn.php';
							}
							echo'
								<div id="espace_compte">
									<p style="text-align: center"><i>Vous �tes rederig� sur le site de paypal en quelque instant ...</i></p>
									<p style="text-align: center;margin:20px 0 50px 0;d"><img src="stockage_img/ajax-loader.gif" /></p>
									<div style="display:none;">
										<form action="'.$action_form.'" method="post" name="form_paiemant">
											<input type="hidden" name="amount" value="'.$tempdevisclient['prix_enchere'].'">
											<input name="currency_code" type="hidden" value="EUR" />
											<input name="shipping" type="hidden" value="0.00" />
											<input name="tax" type="hidden" value="0.00" />
											<input name="return" type="hidden" value="http://tousrenov.fr/espace_professionnel.php?contenu=devis_att_paye&idEncherePaye='.$_GET['idEnchere'].'" />
											<input name="cancel_return" type="hidden" value="http://tousrenov.fr/espace_professionnel.php?contenu=devis_att_paye&paiement=annuler" />
											<input name="notify_url" type="hidden" value="http://tousrenov.fr/'.$ipn.'" />
											<input name="cmd" type="hidden" value="_xclick" />
											<input name="business" type="hidden" value="'.$email_business.'" />
											<input name="item_name" type="hidden" value="'.$nom_client.'" />
											<input name="custom" type="hidden" value="'.$tempdevis['reference'].'" />
											<input alt="Effectuez vos paiements via PayPal : une solution rapide, gratuite et s�curis�e" name="submit" 
												src="img/paypal.png" type="image" />
												<img src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
										</form>
									</div>	
								</div>
								';
						}
						elseif ( $_GET['module']=='virement' )
						{
							$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=2 ');
							$tempdevis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
							$tempdevisclient=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id='.$_GET['idEnchere'].' ');
							//$text_envoie_mail='<br />Un email contenant ces informations vous a �t� envoy�.';
							$text_envoie_mail='';
							//<br />- � cette banque <span class="bold"> ---- BANQUE ---- </span>
							echo'
								<div id="espace_compte" style="margin:0 0 0 80px;">
									<p>Votre commande sur '.$nom_client.' est bien enregistr�.</p>
									<p>Merci de nous envoyer un virement bancaire avec :
										<br />- d\'un total de <strong> '.number_format($tempdevisclient['prix_enchere'],2).' � </strong>
										<br />- � l\'ordre de <strong> '.$temp['val2'].' </strong> 
										<br />- suivant ces d�tails 
										<br />
										IBAN : <strong> '.$temp['val1'].' </strong>
										<br />
										SWIFT BIC : <strong> '.$temp['val3'].' </strong> 
										<br />- N\'oubliez pas d\'indiquer votre r�f�rence de commande <strong> "'.$tempdevis['reference'].'" </strong> dans le sujet de votre virement
										'.$text_envoie_mail.'
										<p>Votre commande vous sera valid� d�s r�ception du paiement.</p>
										<p>Pour toute question ou information compl�mentaire merci de contacter notre <a href="contact.php">support client</a></p>.
									</p>
								</div>
								';
						}
						elseif ( $_GET['module']=='cheque' )
						{
							$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=3 ');
							$tempdevis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
							$tempdevisclient=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id='.$_GET['idEnchere'].' ');
							//$text_envoie_mail='<br />Un email contenant ces informations vous a �t� envoy�.';
							$text_envoie_mail='';
							echo'
								<div id="espace_compte" style="margin:0 0 0 80px;">
									<p>Votre commande sur '.$nom_client.' est bien enregistr�.</p>
									<p>Merci de nous envoyer un ch�que :
										<br />- d\'un total de <strong> '.number_format($tempdevisclient['prix_enchere'],2).' � </strong>
										<br />- � l\'ordre de  <strong> '.$temp['val1'].' </strong> 
										<br />- � envoyer � 
										<br />
										<strong> '.$temp['val2'].' </strong>
										'.$text_envoie_mail.'
										<br />- N\'oubliez pas d\'indiquer votre r�f�rence de commande <strong> "'.$tempdevis['reference'].'" </strong> sur le ch�que
										<p>Votre commande vous sera valid� d�s r�ception du paiement.</p>
										<p>Pour toute question ou information compl�mentaire merci de contacter notre <a href="contact.php">support client</a></p>.
									</p>
								</div>
								';
						}
					}
				}
			}
			else
			{
				if ( isset($_GET['paiement']) && $_GET['paiement']=='effectuer' ) $alert='<div class="success"><p>Le paiement a �t� effectu� avec succ�s.</p></div>';
				if ( isset($_GET['paiement']) && $_GET['paiement']=='annuler' ) $alert='<div class="notes"><p>Le paiement a �t� annul�.</p></div>';
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_devis_client_pro dc , ttre_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=2 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_enchere=1 ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>R�f�rence</td>							
									<td>Date</td>
									<td>Montant</td>								
									<td class="width_60">D�tails</td>								
								</tr>
						';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$res['id_devis'].' ');
						$total=$ress['total_net']+$ress['total_tva']+$ress['frais_port'];
						$liste.='
								<tr>
									<td><a href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$res['id_devis'].'">'.$ress['reference'].'</a></td>
									<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
									<td><strong>'.number_format($total, 2,'.','').' �</strong></td>
									<td><a href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								</tr>
								';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis � cet instant.</p>';
				}
				echo'
					'.$alert.'		
					<div id="espace_compte">
						'.$liste.'
					</div>
					';
			}
			break;	
		case 'devis_histo' :
			if ( isset($_GET['idDevis']) )
			{
				$infos_devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
				$tempp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
				$total=number_format($infos_devis['total_net']+$infos_devis['total_tva']+$infos_devis['frais_port'],2);
				$detail='
					<div class="col-md-12">
						<ul id="compte_details_com">
							<li class="col-md-4">
								<h4>Informations g�n�rales</h4>
								<dl>
									<dt>Date Devis : </dt>
									<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
									<dt>Date Payement : </dt>
									<dd>'.date("d-m-Y",$tempp['date_payement']).'</dd>
									<dt>Mode de paiement : </dt>
									<dd>'.$tempp['type_payement'].'</dd>
									<dt>R�f�rence : </dt>
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
						<li class="centeral col-md-4">
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N� d�appartement : '.$num_appart.'</dd>
								<dd>B�timent : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>
						</li>
						';
				$res = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$infos_devis['id_client'].' ');
				$detail.='
						<li class="col-md-4">
							<h4>Information de client</h4>
							<dl>
								<dd>'.ucfirst(html_entity_decode($res['civ'])).' '.ucfirst(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</dd>
								<dd>'.html_entity_decode($res['telephone']).' - '.html_entity_decode($res['email']).'</dd>
								<dd>Num�ro et voie : '.html_entity_decode($res['num_voie']).'</dd>
								<dd>N� d\'appartement, Etage, Escalier : '.html_entity_decode($res['num_appart']).'</dd>
								<dd>B�timent, R�sidence, Entr�e : '.html_entity_decode($res['batiment']).'</dd>
								<dd>'.html_entity_decode($res['code_postal']).' '.html_entity_decode($res_ville['ville_nom_reel']).'</dd>
								<dd>'.html_entity_decode($res['pays']).'</dd>
							</dl>
						</li>
					</ul>
					</div>';
				$detail.='
					<div class="col-md-12">
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Pi�ce</td>														
								<td>D�signation</td>														
								<td>P.U</td>
								<td>Qte</td>
								<td>Unit�</td>
								<td>Total</td>
							</tr>	
						';
				$nom_cat='';
				$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
				while ( $ress=$my->arr($reqq) )
				{
					if ( $nom_cat!=$ress['titre_categ'] )
					{
						$nom_cat=$ress['titre_categ'];
						$detail.='
								<tr style="background:#faca2e;">
									<td colspan="6">'.$nom_cat.'</td>
								</tr>
									';
					}
					if ( !empty($ress['commentaire']) )$texte='<br /><strong>Commentaire : </strong>'.$ress['commentaire']; else $texte='';
					$detail.='
							<tr>
								<td>'.$ress['nom_piece'].'</td>		
								<td style="text-align:justify;">'.$ress['titre'].' '.$texte.'</td>		
								<td>'.number_format($ress['prix'], 2,'.','').' �</td>
								<td>'.$ress['qte'].'</td>
								<td>'.$ress['unite'].'</td>
								<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' �</td>
							</tr>
						';
				}
				$reqqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
				while ( $resss=$my->arr($reqqq) )
				{
					$temp=$my->req_arr('SELECT SUM(valeur_tva_prod) AS prix_total FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' AND tva='.$resss['id'].' ');
					if ( $temp['prix_total'] > 0 )
						$detail.='
								<tr class="total">
									<td colspan="5"><strong>'.$resss['titre'].' : </strong></td>
									<td colspan="1" class="prix_final">'.number_format($temp['prix_total'], 2,'.','').'�</td>
								</tr>
								';
				}
				$detail.='
						<tr class="total">
							<td colspan="5"><strong>Total TTC : </strong></td>
							<td colspan="1" class="prix_final">'.$total.' �</td>
						</tr>
					</table>
					</div>
					<a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'&suite=ok">Aper�u avant imprimer</a>';
				
				$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
				$detail.='<p>Prix propos� : '.number_format($temp['prix_enchere'],2).' �  </p><br /><br />';
					
				
				// ------------------------- Partie dialogue -----------------------------
				
				$alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" ></div>';
				if ( isset($_GET['envoyer']) ) $alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" class="success" ><p>Votre message a bien �t� envoy�.</p></div>';
				
				$id = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
				$idd = $my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
				$icpa = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$id['id_client'].' ');
				$icpr = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$idd['id_client_pro'].' ');
				$req = $my->req('SELECT * FROM ttre_devis_cm WHERE id_devis='.$_GET['idDevis'].' ORDER BY date ASC ');
				if ( $my->num($req)>0 )
				{
					$detail.='<div class="col-md-7 dialogue-user"><ul>';
					while ( $res=$my->arr($req) )
					{
						$galerie='';
						$req_g = $my->req('SELECT * FROM ttre_devis_cm_photo WHERE id_cm='.$res['id'].' ');
						if ( $my->num($req_g)>0 )
						{
							$galerie.='<p>';
							while ( $res_g=$my->arr($req_g) )
							{
								$galerie.='<a class="example2" href="upload/galeries/800X600/'.$res_g['photo'].'"><img src="upload/galeries/300X300/'.$res_g['photo'].'" width="100" style="margin:10px;"/></a>';
							}
							$galerie.='</p>';
						}
						$nom='';
						if ( $res['client']=='pro' ) $nom=$icpr['nom'];
						elseif ( $res['client']=='part' ) $nom=$icpa['nom'];
						$detail.='	<li>
										<strong>'.date('d/m/Y - H:i',$res['date']).' '.$nom.'</strong> : '.$res['message'].'
										'.$galerie.'
									</li>';
					}
					$detail.='</ul></div>';
				}
				
				$detail.='
						</div>
						'.$alert.'
						<div class="container">
							<div class="row">
								<div class="col-md-7">
							<form name="message_envoie" method="post" class="" enctype="multipart/form-data" >
								<div class="dialogue-part">
									<p>
										<textarea id="message" type="text" name="message" required placeholder="Message"></textarea>
									</p>
									<p>
										
										<input type="hidden" name="nbrPhoto" id="nbrPhoto" value="1" >
										<table id="tblPhoto" >
											<tr>
												<td>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[+]" onclick="addRowToTablePhoto();""/></div>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[-]" onclick="removeRowFromTablePhoto();"  style="cursor:pointer"/></div>
												</td>
											</tr>
											<tr>
												<th>N�</td>
												<th>Photo</td>
											</tr>
											<tr>
												<td>1</td>
												<td><input type="file" name="Photo_1" /></td>
											</tr>
										</table>									
									</p>
									<p class="align_center padding_tb_20">
										<input value="Envoyer" type="submit" name="envoie_message"/>
									</p>
								</div>
							</form>
							</div>
						</div>
					</div>
					';
				
				
				// -----------------------------------------------------------------------
				
				
				$detail.='
					<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devis_histo">Retour � la page pr�c�dente</a></p>
						';
				echo'
					<div id="espace_compte">
						'.$detail.'
					</div>
					';
			}
			else
			{
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_devis_client_pro dc , ttre_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=3 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_enchere=1 ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>R�f�rence</td>							
									<td>Date</td>
									<td>Type</td>
									<td>Montant</td>								
									<td class="width_60">D�tails</td>								
								</tr>
						';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$res['id_devis'].' ');
						$resss=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_enchere=1 ');
						$total=$ress['total_net']+$ress['total_tva']+$ress['frais_port'];
						$liste.='
								<tr>
									<td><a href="espace_professionnel.php?contenu=devis_histo&idDevis='.$res['id_devis'].'">'.$ress['reference'].'</a></td>
									<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
									<td>'.$resss['type_payement'].'</td>
									<td><strong>'.number_format($total, 2,'.','').' �</strong></td>
									<td><a href="espace_professionnel.php?contenu=devis_histo&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								</tr>
								';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis � cet instant.</p>';
				}
				echo'
					'.$alert.'		
					<div id="espace_compte">
						'.$liste.'
					</div>
					';
			}
			break;	
		case 'devisa_att_paye' :
			if ( isset($_GET['idDevis']) )
			{
				if ( ! isset($_GET['etape']) )
				{
					$detail='';
					/*$temp=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id='.$_GET['idDevis'].' ');
					$detail.='<p><strong>Description : </strong> '.$temp['description'].'</p>';*/
					
					$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
					$detail.='
							<ul id="compte_details_com">
								<li>
									<h4>Informations g�n�rales</h4>
									<dl>
										<dt>Date Devis : </dt>
										<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
										<dt>R�f�rence : </dt>
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
							<li>
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>'.$code_postal.' '.$ville.'</dd>
									<dd>'.$pays.'</dd>
								</dl>
							</li>
						</ul>';
					$detail.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>D�signation</td>														
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
									<tr style="background:#faca2e;">
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
					$detail.='</table>';
					//$detail.='</table><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aper�u avant imprimer</a>';
					
					$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['idDevis'].' ');
					if ( $my->num($req_f)>0 )
					{
						$detail.='<p><br /> Fichiers � t�l�charger : ';
						while ( $res_f=$my->arr($req_f) )
						{
							$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
						}
						$detail.='</p>';
					}
					
					$detail.= '<p>Prix HT: '.number_format($infos_devis['prix_achat'],2).' �</p>';
					$detail.= '<p>TVA : 20 %</p>';
					$detail.= '<p>Prix TTC: '.number_format(($infos_devis['prix_achat']+$infos_devis['prix_achat']*20/100),2).' �</p>';
					
					$detail.='
						<p id="panier_boutons"><input type="button" value="Payer" onclick="javascript:window.location=\'espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement\'" /></p>
						<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devisa_att_paye">Retour � la page pr�c�dente</a></p>
							';
					echo'
						'.$alert.'
						<div id="espace_compte">
							'.$detail.'
						</div>
						';
				}
				elseif ( isset($_GET['etape']) && $_GET['etape']=='paiement' )
				{
					if ( !isset($_GET['module']) )
					{
						$adcp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].' ');
						$module_Test='';$module_paypal='';$module_virement='';$module_cheque='';
						//$module_Test='<p style="text-align: center;">Notre solution de paiement en ligne est en cours d\'int�gration,<br /> merci de revenir plus tard.';
						if ( $_SESSION['id_client_trn_pro']==72 )
						{
							$module_Test='
										<p class="payment_module">
											<a title="Payer par Test" href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=test&idEstim='.$adcp['id'].'">
												<img width="86" height="49" alt="Test" src="stockage_img/test.jpg">
												Test
											</a>
										</p>
							';
						}
						$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=1 ');
						if ( $temp['statut']==1 && !empty($temp['val1']) ) 
						{
							$module_paypal='
										<p class="payment_module">
											<a title="Payer par Paypal" href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=paypal&idEstim='.$adcp['id'].'">
												<img width="86" height="49" alt="Payer par Paypal" src="carte-bleue.jpeg">
												Payer par Carte bleue 
											</a>
										</p>
											';
						}
						$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=2 ');
						if ( $temp['statut']==1 && !empty($temp['val1']) && !empty($temp['val2']) && !empty($temp['val3']) ) 
						{
							$module_virement='
										<p class="payment_module">
											<a title="Payer par Virement" href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=virement&idEstim='.$adcp['id'].'">
												<img width="86" height="49" alt="Payer par Virement" src="stockage_img/bankwire.jpg">
												Payer par Virement bancaire 
											</a>
										</p>
											';
						}
						$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=3 ');
						if ( $temp['statut']==1 && !empty($temp['val1']) && !empty($temp['val2']) ) 
						{
							$module_cheque='
											<p class="payment_module">
												<a title="Payer par Ch�que" href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=cheque&idEstim='.$adcp['id'].'">
													<img width="86" height="49" alt="Payer par Virement" src="stockage_img/cheque.jpg">
													Payer par Ch�que 
												</a>
											</p>
											';
						}
						echo'
							<div id="HOOK_PAYMENT" style="width: 530px; margin: 0px 0px 0px 50px;">
								'.$module_Test.'
								'.$module_paypal.'
								'.$module_virement.'
								'.$module_cheque.'
							</div>
							<div id="espace_compte">
								<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'">Retour � la page pr�c�dente</a></p>
							</div>
							';
					}
					else
					{
						if ( $_GET['module']=='test' )
						{
							echo'
								<div id="espace_compte">
									<a href="espace_professionnel.php?contenu=devisa_att_paye&idEstimPaye='.$_GET['idEstim'].'">Paiement effectu�</a> |
									<a href="espace_professionnel.php?contenu=devisa_att_paye&paiement=annuler">Paiement annul�</a></p>
								</div>
								';
						}
						elseif ( $_GET['module']=='paypal' )
						{
							$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=1 ');
							$tempdevis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
							$montantapayer=($tempdevis['prix_achat']+$tempdevis['prix_achat']*20/100);
							$test=0;
							if ( $test==1 )
							{
								$action_form='https://www.sandbox.paypal.com/cgi-bin/webscr';
								$email_business='bilelbusiness@yahoo.fr';
								$ipn='ipn_test.php';
							}
							else
							{
								//$action_form='https://ipnpb.paypal.com/cgi-bin/webscr';
								$action_form='https://www.paypal.com/cgi-bin/webscr';
								$email_business=$temp['val1'];
								$ipn='ipn.php';
							}
							echo'
								<div id="espace_compte">
									<p style="text-align: center"><i>Vous �tes rederig� sur le site de paypal en quelque instant ...</i></p>
									<p style="text-align: center;margin:20px 0 50px 0;d"><img src="stockage_img/ajax-loader.gif" /></p>
									<div style="display:none;">
										<form action="'.$action_form.'" method="post" name="form_paiemant">
											<input type="hidden" name="amount" value="'.$montantapayer.'">
											<input name="currency_code" type="hidden" value="EUR" />
											<input name="shipping" type="hidden" value="0.00" />
											<input name="tax" type="hidden" value="0.00" />
											<input name="return" type="hidden" value="http://tousrenov.fr/espace_professionnel.php?contenu=devisa_att_paye&idEstimPaye='.$_GET['idEstim'].'" />
											<input name="cancel_return" type="hidden" value="http://tousrenov.fr/espace_professionnel.php?contenu=devisa_att_paye&paiement=annuler" />
											<input name="notify_url" type="hidden" value="http://tousrenov.fr/'.$ipn.'" />
											<input name="cmd" type="hidden" value="_xclick" />
											<input name="business" type="hidden" value="'.$email_business.'" />
											<input name="item_name" type="hidden" value="'.$nom_client.'" />
											<input name="custom" type="hidden" value="'.$tempdevis['reference'].'" />
											<input alt="Effectuez vos paiements via PayPal : une solution rapide, gratuite et s�curis�e" name="submit" 
												src="img/paypal.png" type="image" />
												<img src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
										</form>
									</div>	
								</div>
								';
						}
						elseif ( $_GET['module']=='virement' )
						{
							$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=2 ');
							$tempdevis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
							$montantapayer=($tempdevis['prix_achat']+$tempdevis['prix_achat']*20/100);
							//$text_envoie_mail='<br />Un email contenant ces informations vous a �t� envoy�.';
							$text_envoie_mail='';
							//<br />- � cette banque <span class="bold"> ---- BANQUE ---- </span>
							echo'
								<div id="espace_compte" style="margin:0 0 0 80px;">
									<p>Votre commande sur '.$nom_client.' est bien enregistr�.</p>
									<p>Merci de nous envoyer un virement bancaire avec :
										<br />- d\'un total de <strong> '.number_format($montantapayer,2).' � </strong>
										<br />- � l\'ordre de <strong> '.$temp['val2'].' </strong> 
										<br />- suivant ces d�tails 
										<br />
										IBAN : <strong> '.$temp['val1'].' </strong>
										<br />
										SWIFT BIC : <strong> '.$temp['val3'].' </strong> 
										<br />- N\'oubliez pas d\'indiquer votre r�f�rence de commande <strong> "'.$tempdevis['reference'].'" </strong> dans le sujet de votre virement
										'.$text_envoie_mail.'
										<p>Votre commande vous sera valid� d�s r�ception du paiement.</p>
										<p>Pour toute question ou information compl�mentaire merci de contacter notre <a href="contact.php">support client</a></p>.
									</p>
								</div>
								';
						}
						elseif ( $_GET['module']=='cheque' )
						{
							$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=3 ');
							$tempdevis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
							$montantapayer=($tempdevis['prix_achat']+$tempdevis['prix_achat']*20/100);
							//$text_envoie_mail='<br />Un email contenant ces informations vous a �t� envoy�.';
							$text_envoie_mail='';
							echo'
								<div id="espace_compte" style="margin:0 0 0 80px;">
									<p>Votre commande sur '.$nom_client.' est bien enregistr�.</p>
									<p>Merci de nous envoyer un ch�que :
										<br />- d\'un total de <strong> '.number_format($montantapayer,2).' � </strong>
										<br />- � l\'ordre de  <strong> '.$temp['val1'].' </strong> 
										<br />- � envoyer � 
										<br />
										<strong> '.$temp['val2'].' </strong>
										'.$text_envoie_mail.'
										<br />- N\'oubliez pas d\'indiquer votre r�f�rence de commande <strong> "'.$tempdevis['reference'].'" </strong> sur le ch�que
										<p>Votre commande vous sera valid� d�s r�ception du paiement.</p>
										<p>Pour toute question ou information compl�mentaire merci de contacter notre <a href="contact.php">support client</a></p>.
									</p>
								</div>
								';
						}
					}
				}
			}
			else
			{
				if ( isset($_GET['paiement']) && $_GET['paiement']=='effectuer' ) $alert='<div class="success"><p>Le paiement a �t� effectu� avec succ�s.</p></div>';
				if ( isset($_GET['paiement']) && $_GET['paiement']=='annuler' ) $alert='<div class="notes"><p>Le paiement a �t� annul�.</p></div>';
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_achat_devis_client_pro dc , ttre_achat_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=1 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_achat=0 ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>R�f�rence</td>							
									<td>Date</td>
									<td class="width_60">D�tails</td>								
								</tr>
						';
					while ( $res=$my->arr($req) )
					{
						$ec=$my->req('SELECT * FROM ttre_client_pro_commandes_contenu CC, ttre_client_pro_commandes C
							WHERE CC.id_cmd=C.id AND C.id_client='.$_SESSION['id_client_trn_pro'].' AND CC.id_devis='.$res['id_devis'].' ');
						if ( $my->num($ec)==0 )
						{
							$d=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
							$acp=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=1 ');
							if ( $d['nbr_estimation']>$my->num($acp) ) 
							{
								
								$ress=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
								$liste.='
										<tr>
											<td><a href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$res['id_devis'].'">'.$ress['reference'].'</a></td>
											<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
											<td><a href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
										</tr>
										';
							}
						}
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis � cet instant.</p>';
				}
				echo'
					'.$alert.'		
					<div id="espace_compte">
						'.$liste.'
					</div>
					';
			}
			break;	
		case 'devisa_histo' :
			if ( isset($_GET['idDevis']) )
			{
				$detail='';
				/*$temp=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id='.$_GET['idDevis'].' ');
				$detail.='<p><strong>Description : </strong> '.$temp['description'].'</p>';*/
				
				$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
				$tempp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_valid=1 ');
				$detail.='
					<div class="col-md-12">
						<ul id="compte_details_com">
							<li class="col-md-4">
								<h4>Informations g�n�rales</h4>
								<dl>
									<dt>Date Devis : </dt>
									<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
									<dt>Date Payement : </dt>
									<dd>'.date("d-m-Y",$tempp['date_payement']).'</dd>
									<dt>Mode de paiement : </dt>
									<dd>'.$tempp['type_payement'].'</dd>
									<dt>R�f�rence : </dt>
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
						<li class="centeral col-md-4">
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N� d�appartement : '.$num_appart.'</dd>
								<dd>B�timent : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>
						</li>
						';
				$res = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$infos_devis['id_client'].' ');
				$detail.='
						<li class="col-md-4">
							<h4>Information de client</h4>
							<dl>
								<dd>'.ucfirst(html_entity_decode($res['civ'])).' '.ucfirst(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</dd>
								<dd>'.html_entity_decode($res['telephone']).' - '.html_entity_decode($res['email']).'</dd>
								<dd>Num�ro et voie : '.html_entity_decode($res['num_voie']).'</dd>
								<dd>N� d\'appartement, Etage, Escalier : '.html_entity_decode($res['num_appart']).'</dd>
								<dd>B�timent, R�sidence, Entr�e : '.html_entity_decode($res['batiment']).'</dd>
								<dd>'.html_entity_decode($res['code_postal']).' '.html_entity_decode($res_ville['ville_nom_reel']).'</dd>
								<dd>'.html_entity_decode($res['pays']).'</dd>
							</dl>
						</li>
					</ul>
					</div>';
				$detail.='
					<div class="col-md-12">
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>D�signation</td>														
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
				$detail.='</table></div><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aper�u avant imprimer</a>';
				
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['idDevis'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers � t�l�charger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p><br />';
				}
				
				// ------------------------- Partie dialogue -----------------------------
				
				$alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" ></div>';
				if ( isset($_GET['envoyer']) ) $alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" class="success" ><p>Votre message a bien �t� envoy�.</p></div>';
				
				$id = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
				$idd = $my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_valid=1 ');
				$icpa = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$id['id_client'].' ');
				$icpr = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$idd['id_client_pro'].' ');
				$req = $my->req('SELECT * FROM ttre_achat_devis_cm WHERE id_devis='.$_GET['idDevis'].' ORDER BY date ASC ');
				if ( $my->num($req)>0 )
				{
					$detail.='<div class="col-md-7 dialogue-user"><ul>';
					while ( $res=$my->arr($req) )
					{
						$galerie='';
						$req_g = $my->req('SELECT * FROM ttre_achat_devis_cm_photo WHERE id_cm='.$res['id'].' ');
						if ( $my->num($req_g)>0 )
						{
							$galerie.='<p>';
							while ( $res_g=$my->arr($req_g) )
							{
								$galerie.='<a class="example2" href="upload/galeries/800X600/'.$res_g['photo'].'"><img src="upload/galeries/300X300/'.$res_g['photo'].'" width="100" style="margin:10px;"/></a>';
							}
							$galerie.='</p>';
						}
						$nom='';
						if ( $res['client']=='pro' ) $nom=$icpr['nom'];
						elseif ( $res['client']=='part' ) $nom=$icpa['nom'];
						$detail.='	<li>
										<strong>'.date('d/m/Y - H:i',$res['date']).' '.$nom.'</strong> : '.$res['message'].'
										'.$galerie.'
									</li>';
					}
					$detail.='</ul></div>';
				}
				
				$detail.='
						</div>
						'.$alert.'
						<div class="container">
							<div class="row">
								<div class="col-md-7">	
						<form name="message_envoie" method="post" class="" enctype="multipart/form-data" >
									<div class="dialogue-part">
										<textarea id="message" type="text" name="message" required placeholder="Message *"></textarea>
									</p>
									<p>
										<label for="mdp">Photos : </label>
										<input type="hidden" name="nbrPhoto" id="nbrPhoto" value="1" >
										<table id="tblPhoto" >
											<tr>
												<td>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[+]" onclick="addRowToTablePhoto();" "/></div>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[-]" onclick="removeRowFromTablePhoto();"  style="cursor:pointer"/></div>
												</td>
											</tr>
											<tr>
												<th>N�</td>
												<th>Photo</td>
											</tr>
											<tr>
												<td>1</td>
												<td><input type="file" name="Photo_1" /></td>
											</tr>
										</table>									
									</p>
									<p class="align_center padding_tb_20">
										<input value="Envoyer" type="submit" name="envoie_message"/>
									</p>
									
								</div>
							</form>
							</div>
						</div>
					</div>
					';
				
				
				// -----------------------------------------------------------------------
				
				
				$detail.='
					<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devisa_histo">Retour � la page pr�c�dente</a></p>
						';
				echo'
					<div id="espace_compte">
						'.$detail.'
					</div>
					';
			}
			else
			{
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_achat_devis_client_pro dc , ttre_achat_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=2 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_valid=1 ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>R�f�rence</td>							
									<td>Date</td>
									<td>Type</td>
									<td class="width_60">D�tails</td>								
								</tr>
						';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
						$resss=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_valid=1 ');
						$liste.='
								<tr>
									<td><a href="espace_professionnel.php?contenu=devisa_histo&idDevis='.$res['id_devis'].'">'.$ress['reference'].'</a></td>
									<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
									<td>'.$resss['type_payement'].'</td>
									<td><a href="espace_professionnel.php?contenu=devisa_histo&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								</tr>
								';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis � cet instant.</p>';
				}
				echo'
					'.$alert.'		
					<div id="espace_compte">
						'.$liste.'
					</div>
					';
			}
			break;	
		case 'devis_admin' :
			if ( isset($_GET['idDevis']) )
			{
				$detail='';
					
				$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
				$detail.='
					<ul id="compte_details_com">
						<li>
							<h4>Informations g�n�rales</h4>
							<dl>
								<dt>Date Devis : </dt>
								<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
								<dt>R�f�rence : </dt>
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
					<li>
						<h4>Adresse de chantier</h4>
						<dl>
							<dd>'.$code_postal.' '.$ville.'</dd>
							<dd>'.$pays.'</dd>
						</dl>
					</li>
				</ul>';
				$detail.='
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
						<tr class="entete">
							<td>D�signation</td>
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
							<tr style="background:#faca2e;">
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
				$detail.='</table>';
					
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['idDevis'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers � t�l�charger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p>';
				}
					
				$detail.='
				<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devis_admin">Retour � la page pr�c�dente</a></p>
					';
				echo'
				<div id="espace_compte">
					'.$detail.'
				</div>
				';
			}
			else
			{
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_achat_devis_client_pro dc , ttre_achat_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=-2 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_achat=0 ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>R�f�rence</td>
								<td>Date</td>
								<td class="width_60">D�tails</td>
							</tr>
					';
					while ( $res=$my->arr($req) )
					{
						$d=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
						$acp=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=1 ');
								
						$ress=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
						$liste.='
							<tr>
								<td><a href="espace_professionnel.php?contenu=devis_admin&idDevis='.$res['id_devis'].'">'.$ress['reference'].'</a></td>
								<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
								<td><a href="espace_professionnel.php?contenu=devis_admin&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
							</tr>
							';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis � cet instant.</p>';
				}
				echo'
				'.$alert.'
				<div id="espace_compte">
					'.$liste.'
				</div>
				';
			}
			break;
		case 'mdp_perdu' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Cette adresse email n\'existe pas dans notre base !</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mdp' ) $alert='<div id="note" class="error"><p>Changement Annul�.</p></div><br />';
			if ( isset($_GET['mdpperdu']) ) $alert='<div id="note" class="success"><p>Un nouveau mot de passe vous a �t� envoy�, vous devez maintenant le valider pour pouvoir vous connecter sur notre site.</p></div><br />';
			echo'
				'.$alert.'
				<div id="espace_compte" style="margin: 0 0 0 100px;">
					<form name="perdu_mdp" method="post" action="espace_professionnel.php?contenu=mdp_perdu" class="tpl_form_defaut intitules_moyens champs_larges" >
					<div class="container">
						<div class="row">
							<div class="col-md-12">
							<div class="form-groupe-part ">
									<div class="title-info"><h1>Nouveau mot de passe</h1></div>
						<p>
							<label for="ip_mail">Email : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" name="mail"/>
						</p>
						<p class="align_center padding_tb_20">
							<input value="Envoyer" type="submit" name="mdp_perdu"/>
						</p>
						<p class="note" id="text_erreur"><cite>( * ) Champs Obligatoires.</cite></p>
					</div>
					</div>
					</div>
					</div>
					</form>	
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour � la page pr�c�dente</a></p>
				</div>
				';		
			break;	
	}
}
else
{
	if ( !isset($_SESSION['id_client_trn_pro']) )
	{
		$alert='<div id="note"></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='erreur') ) $alert='<div id="note" class="error"><p>Erreur lors de l\'authentification.</p></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='valider') ) $alert='<div id="note" class="success"><p>Votre compte a bien �t� valid�.</p></div><br />';
		if ( isset($_GET['modif']) && ($_GET['modif']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		if ( isset($_GET['valid_mdp']) ) $alert='<div id="note" class="notice"><p>Votre mot de passe a bien �t� modifi�, vous pouvez d�s maintenant vous connecter.</p></div><br />';
		echo'
			'.$alert.'
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="Login-pro">
						<div class="title-sign-pro">Vous avez d�j� un compte ?</div>
						<form action="espace_professionnel.php?contenu=connexion" name="client_conn" method="post" >
							<div class="form-login-pro">
								<input id="mail" type="text" name="email_connexion" placeholder="Votre adresse mail"/><br />
								<input id="mdp" type="password" name="mdp_connexion" placeholder="Votre mot de passe"/><br />
								<input class="boutons_persos_1" value="Connexion" type="submit" name="conn_client"/><br />
								<p>Si vous avez oubli� votre mot de passe, <a href="espace_professionnel.php?contenu=mdp_perdu" style="color:#000">cliquez ici</a>.</p>	
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-6">
					<div class="Logup-pro">
						<div class="title-sign-pro">Vous �tes nouveau client ?</div>
						<div class="log-pro">
							<p>Vous devez cr�er un compte pour pouvoir g�rer vos devis.</p>
							<p class="padding_top_5">Nous nous engageons � s�curiser vos informations et � les garder strictement confidentielles.</p>
							<a href="espace_professionnel.php?contenu=inscription"">Cr�er un compte</a>
						</div>
					<div>
				</div>		
			</div>
			';


	}
	else
	{
		$req_dev_cour = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_devis_client_pro dc , ttre_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=1 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND d.date_valid_mazad>'.time().' ');
		$req_att_pay = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_devis_client_pro dc , ttre_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=2 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_enchere=1  ');
		$req_att_pays = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_achat_devis_client_pro dc , ttre_achat_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=1 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_achat=0  ');
		$nbrAD=0;
		while ( $res_att_pays=$my->arr($req_att_pays) )
		{
			$ec=$my->req('SELECT * FROM ttre_client_pro_commandes_contenu CC, ttre_client_pro_commandes C 
							WHERE CC.id_cmd=C.id AND C.id_client='.$_SESSION['id_client_trn_pro'].' AND CC.id_devis='.$res_att_pays['id_devis'].' ');
			if ( $my->num($ec)==0 )
			{
				$d=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res_att_pays['id_devis'].' ');
				$acp=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res_att_pays['id_devis'].' AND statut_achat=1 ');
				if ( $d['nbr_estimation']>$my->num($acp) ) $nbrAD++;
			}
		}
		$alert='<div id="note"></div><br />';
		if ( isset($_GET['modif_mdp']) ) $alert='<div id="note" class="notice" ><p>Votre mot de passe a bien �t� modifi�.</p></div><br />';
		//<div id="espace_compte">
		//<p class="padding_bottom_20">Bienvenue dans votre espace personnel, vous pouver depuis cette page g�rer toutes vos informations personnelles ainsi que vos devis.</p>												
		echo'
			'.$alert.'
			
				

				<div class="col-md-4">
					<div class="espace-box2">
						<img src="../images/icons/2-1.png">
						<h3>Informations personnelles</h3>
						<p>C\'est dans cette section que vous pourrez acc�der � vos informations personnelles et les modifier.</p>
						<a href="espace_professionnel.php?contenu=modif_param">Modifier mes informations</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="espace-box2">
						<img src="../images/icons/2-2.png">
						<h3>Mot de passe</h3>
						<p>Pour des questions de s�curit�, il est conseill� de modifier son mot de passe fr�quemment.</p>
						<a href="espace_professionnel.php?contenu=modif_mdp">Modifier mon mot de passe</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="espace-box2">
						<img src="../images/icons/1-3.png">
						<h3>Devis en cours d\'ench�re</h3>
						<p>Vous pourrez consulter le d�tail de vos devis en cours d\'ench�re et dans votre zone d\'intervention.</p>
						<a href="espace_professionnel.php?contenu=devis_encours">Devis en cours ( '.$my->num($req_dev_cour).' )</a>
					</div>
				</div>	

				<div class="col-md-4">
					<div class="espace-box2">
						<img src="../images/icons/2-4.png">
						<h3>Devis en attende de payement</h3>
						<p>C\'est dans cette section que vous pourrez consulter le d�tail de vos devis en attende de payement.</p>
						<a href="espace_professionnel.php?contenu=devis_att_paye">Devis en attende de payement ( '.$my->num($req_att_pay).' )</a>
					</div>
				</div>
 
				<div class="col-md-4">
					<div class="espace-box2">
						<img src="../images/icons/2-5.png">
						<h3>Historique de devis</h3>
						<p>C\'est dans cette section que vous pourrez consulter l\'historique de vos devis.</p>
						<a href="espace_professionnel.php?contenu=devis_histo">historique</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="espace-box2">
						<img src="../images/icons/2-6.png">
						<h3>Devis avec achat imm�diat en attende de pay</h3>
						<p>Vous pourrez consulter le d�tail de vos devis avec achat imm�diat en attende de payement.</p>
						<a href="espace_professionnel.php?contenu=devisa_att_paye">Devis en attende de payement ( '.$nbrAD.' )</a>
					</div>
				</div>	

				<div class="col-md-4">
					<div class="espace-box2">
						<img src="../images/icons/1-6.png">
						<h3>Historique de devis avec achat imm�diat</h3>
						<p>C\'est dans cette section que vous pourrez consulter l\'historique de vos devis  avec achat imm�diat.</p>
						<a href="espace_professionnel.php?contenu=devisa_histo">historique</a>
					</div>
				</div>	

				<div class="col-md-8">
					<div class="espace-box3">
						<div class="overlay3"></div>
						<img src="../images/images/recherche.jpg">
						<div class="title1"><h2>Recherche</h2></div>
						
						<a href="recherche.php">Recherche</a>
					</div>
				</div>	

				<div class="col-md-12">
					<div class="get-quote">						
						<div class="quote-img">
							<img src="../images/images/conseil-man-small.png" >
						</div>
						<div class="quote-text">
								<h2>Devis Travaux R�novation</h2>
								<p>Votre devis d�taill�e en ligne : Cr�er votre devis et ayez une estimations rapide de vos travaux</p>
						</div>
						<div class="quote-btns" style="padding-right:10px;" >
								<a href="devis.php" style="padding:12px 10px;" class="create">Cr�er votre devis</a>
								<a href="prix-travaux.php" style="padding:12px 10px;" class="get">Devis Imm�diat</a>
								<a href="espace_professionnel.php?contenu=devis_admin" style="padding:12px 10px;" class="create">Autre devis</a>
						</div>
					</div>
				</div>
					
			
			';
	}
}
?>
<!-- <p><a href="espace_professionnel.php?contenu=deconnexion"> � Se d�connecter</a></p>	 -->
</div>
				</div>
			</div>
		</div>
	</div>	
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>