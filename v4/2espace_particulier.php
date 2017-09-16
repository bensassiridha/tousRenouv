è<?php
require('inc/session.php');

// ----------------------------------------------------pour la gestion ----------------------------
if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'connexion' :
			if ( isset($_POST['conn_client']) )
			{
				$req=$my->req('SELECT * FROM ttre_client_part WHERE email="'.$_POST['email_connexion'].'" AND mdp="'.md5($_POST['mdp_connexion']).'" AND stat_valid=1 ');
				if ( $my->num($req)==0 )
				{
					header("location:espace_particulier.php?inscrit=erreur");exit;
				}
				else
				{
					$cl=$my->arr($req);
					$_SESSION['id_client_trn_part']=$cl['id'];
					header("location:espace_particulier.php");exit;
				}
			}
			break;
		case 'inscription' :
			if ( isset($_POST['ajout_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:espace_particulier.php?contenu=inscription&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_client_part WHERE email="'.$_POST['mail_nouveau'].'"');
					if ( $my->num($req)>0 ) {header("location:espace_particulier.php?contenu=inscription&erreur=mail");exit;}
					else
					{
						$referenceValid = uniqid('R');
						if ( $_POST['etes1']=='Autre' ) $precisez1_nouveau=$_POST["precisez1_nouveau"]; else $precisez1_nouveau='';
						if ( $_POST['connus']=='Autre' ) $precisez2_nouveau=$_POST["precisez2_nouveau"]; else $precisez2_nouveau='';
						$my->req("INSERT INTO ttre_client_part VALUES('',
													'".$my->net_input($_POST["etes1"])."',
													'".$my->net_input($precisez1_nouveau)."',
													'".$my->net_input($_POST["etes2_nouveau"])."',
													'".$my->net_input($_POST["civ_nouveau"])."',
													'".$my->net_input($_POST["nom_nouveau"])."',
													'".$my->net_input($_POST["prenom_nouveau"])."',
													'".$my->net_input($_POST["telephone_nouveau"])."',
													'".$my->net_input($_POST["mail_nouveau"])."',
													'".$my->net_input($_POST["numvoie_nouveau"])."',
													'".$my->net_input($_POST["numapp_nouveau"])."',
													'".$my->net_input($_POST["bat_nouveau"])."',
													'".$my->net_input($_POST["cp"])."',
													'".$my->net_input($_POST["ville"])."',
													'".$my->net_input($_POST["pays_nouveau"])."',
													'".$my->net_input($_POST["connus"])."',
													'".$my->net_input($precisez2_nouveau)."',
													'".md5($_POST["pass1_nouveau"])."',
													'".$my->net_input($referenceValid)."',
													'0'
													)");
						$id=mysql_insert_id();
						$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
													'".$my->net_input($id)."',
													'".$my->net_input($_POST["numvoie_nouveau"])."',
													'".$my->net_input($_POST["numapp_nouveau"])."',
													'".$my->net_input($_POST["bat_nouveau"])."',
													'".$my->net_input($_POST["cp"])."',
													'".$my->net_input($_POST["ville"])."',
													'".$my->net_input($_POST["pays_nouveau"])."',
													'1'
													)");
						if ( isset($_POST['newsletter']) )
						{
							$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_part WHERE email="'.$_POST['mail_nouveau'].'" ');
							if ( $my->num($req_news)==0 ) $my->req("INSERT INTO ttre_inscrits_newsletters_part VALUES('','".$my->net_input($_POST['mail_nouveau'])."') ");
						}
						else 
						{
							$my->req('DELETE FROM ttre_inscrits_newsletters_part WHERE email="'.$_POST['mail_nouveau'].'" ');
						}
						if ( isset($_POST['partenaire']) )
						{
							$req_part=$my->req('SELECT * FROM ttre_inscrits_partenaires WHERE email="'.$_POST['mail_nouveau'].'" ');
							if ( $my->num($req_part)==0 ) $my->req("INSERT INTO ttre_inscrits_partenaires VALUES('','".$my->net_input($_POST['mail_nouveau'])."') ");
						}
						else 
						{
							$my->req('DELETE FROM ttre_inscrits_partenaires WHERE email="'.$_POST['mail_nouveau'].'" ');
						}
		
						$etes1 = htmlentities($_POST['etes1']);
						if ( $etes1=='Autre' ) $etes1.= ' - '.htmlentities($_POST['precisez1_nouveau']);
						$etes2 = htmlentities($_POST['etes2_nouveau']);
						$civ = htmlentities($_POST['civ_nouveau']);
						$nom = html_entity_decode($_POST['nom_nouveau']);
						$prenom = html_entity_decode($_POST['prenom_nouveau']);
						$telephone = htmlentities($_POST['telephone_nouveau']);
						$email = html_entity_decode($_POST['mail_nouveau']);
						$numvoie = htmlentities($_POST['numvoie_nouveau']);
						$numapp = htmlentities($_POST['numapp_nouveau']);
						$bat = htmlentities($_POST['bat_nouveau']);
						$cp = htmlentities($_POST['cp']);
						$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$_POST['ville'].'" ');
						$ville = htmlentities($res_ville['ville_nom_reel']);
						$pays = htmlentities($_POST['pays_nouveau']);
						$connus = htmlentities($_POST['connus']);
						if ( $connus=='Autre' ) $connus.= ' - '.htmlentities($_POST['precisez2_nouveau']);
						require_once('mailInscriptionPart.php');
						header("location:espace_particulier.php?inscrit=enattente");exit;			
					}
				}
			}
			break;
		case 'valider' :
			$my->req('UPDATE ttre_client_part SET stat_valid="1" WHERE ref_valid="'.$_GET['ref'].'" AND stat_valid="0" ');
			header("location:espace_particulier.php?inscrit=valider");exit;	
			break;
		case 'modif_param' :
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:espace_particulier.php");exit;}
			if ( isset($_POST['modif_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:espace_particulier.php?contenu=modif_param&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_client_part WHERE email="'.$_POST['mail'].'" AND id!='.$_SESSION['id_client_trn_part'].' ');
					if ( $my->num($req)>0 ) {header("location:espace_particulier.php?contenu=modif_param&erreur=mail");exit;}
					else
					{
						$referenceValid = uniqid('R');
						if ( $_POST['etes1']=='Autre' ) $precisez1=$_POST["precisez1"]; else $precisez1='';
						if ( $_POST['connus']=='Autre' ) $precisez2=$_POST["precisez2"]; else $precisez2='';
						$my->req('UPDATE ttre_client_part SET 
									etes1				=	"'.$my->net_input($_POST["etes1"]).'" , 
									precisez1			=	"'.$my->net_input($precisez1).'" , 
									etes2				=	"'.$my->net_input($_POST['etes2']).'" , 
									civ					=	"'.$my->net_input($_POST['civ']).'" , 
									nom					=	"'.$my->net_input($_POST['nom']).'" , 
									prenom				=	"'.$my->net_input($_POST['prenom']).'" , 
									telephone			=	"'.$my->net_input($_POST['telephone']).'" ,
									email				=   "'.$my->net_input($_POST['mail']).'"  ,
									num_voie			=	"'.$my->net_input($_POST['numvoie']).'" , 
									num_appart			=	"'.$my->net_input($_POST['numapp']).'" , 
									batiment			=	"'.$my->net_input($_POST['bat']).'" , 
									code_postal			=	"'.$my->net_input($_POST['cp']).'" , 
									ville				=	"'.$my->net_input($_POST['ville']).'" , 
									pays				=	"'.$my->net_input($_POST['pays']).'" , 
									connus				=	"'.$my->net_input($_POST['connus']).'" , 
									precisez2			=	"'.$my->net_input($precisez2).'" , 
									ref_valid			=	"'.$my->net_input($referenceValid).'" , 
									stat_valid			=   "0"  
											WHERE id='.$_SESSION['id_client_trn_part'].'') ;
						if ( isset($_POST['newsletter']) )
						{
							$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_part WHERE email="'.$_POST['mail'].'" ');
							if ( $my->num($req_news)==0 ) $my->req("INSERT INTO ttre_inscrits_newsletters_part VALUES('','".$my->net_input($_POST['mail'])."') ");
						}
						else 
						{
							$my->req('DELETE FROM ttre_inscrits_newsletters_part WHERE email="'.$_POST['mail'].'" ');
						}
						if ( isset($_POST['partenaire']) )
						{
							$req_part=$my->req('SELECT * FROM ttre_inscrits_partenaires WHERE email="'.$_POST['mail'].'" ');
							if ( $my->num($req_part)==0 ) $my->req("INSERT INTO ttre_inscrits_partenaires VALUES('','".$my->net_input($_POST['mail'])."') ");
						}
						else 
						{
							$my->req('DELETE FROM ttre_inscrits_partenaires WHERE email="'.$_POST['mail'].'" ');
						}
		
						$etes1 = htmlentities($_POST['etes1']);
						if ( $etes1=='Autre' ) $etes1.= ' - '.htmlentities($_POST['precisez1']);
						$etes2 = htmlentities($_POST['etes2']);
						$civ = htmlentities($_POST['civ']);
						$nom = html_entity_decode($_POST['nom']);
						$prenom = html_entity_decode($_POST['prenom']);
						$telephone = htmlentities($_POST['telephone']);
						$email = html_entity_decode($_POST['mail']);
						$numvoie = htmlentities($_POST['numvoie']);
						$numapp = htmlentities($_POST['numapp']);
						$bat = htmlentities($_POST['bat']);
						$cp = htmlentities($_POST['cp']);
						$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$_POST['ville'].'" ');
						$ville = htmlentities($res_ville['ville_nom_reel']);
						$pays = htmlentities($_POST['pays']);
						$connus = htmlentities($_POST['connus']);
						if ( $connus=='Autre' ) $connus.= ' - '.htmlentities($_POST['precisez2']);
						require_once('mailInscriptionPart.php');
						unset ($_SESSION['id_client_trn_part']);
						unset ($_SESSION['panier_trn']);
						header("location:espace_particulier.php?modif=enattente");exit;	
					}
				}
			}
			break;
		case 'modif_mdp' :
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:espace_particulier.php");exit;}
			if ( isset($_POST['modif_mdp']) )
			{
				$can=$my->req_arr('SELECT * FROM ttre_client_part WHERE id="'.$_SESSION['id_client_trn_part'].'"');
				if ( $can['mdp']!=md5($_POST['pass']) ){header("location:espace_particulier.php?contenu=modif_mdp&erreur=mdp");exit;}
				else
				{
					$my->req('UPDATE ttre_client_part SET mdp="'.md5($_POST['pass1']).'" WHERE id='.$_SESSION['id_client_trn_part'].'') ;
					header("location:espace_particulier.php?modif_mdp=ok");exit;
				}				
			}
			break;
		case 'adresse' :
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:espace_particulier.php");exit;}
			if ( isset($_GET['action']) )
			{
				switch ( $_GET['action'] )
				{
					case 'ajouter' :
						if ( isset($_POST['ajout_adresse']) )
						{
							$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
													'".$_SESSION['id_client_trn_part']."',
													'".$my->net_input($_POST["numvoie"])."',
													'".$my->net_input($_POST["numapp"])."',
													'".$my->net_input($_POST["bat"])."',
													'".$my->net_input($_POST["cp"])."',
													'".$my->net_input($_POST["ville"])."',
													'".$my->net_input($_POST["pays"])."',
													'1'
													)");
	
							header("location:espace_particulier.php?contenu=adresse&ajout_adress=ok");exit;
						}
						break;
					case 'modifier' :
						if ( isset($_POST['modif_adresse']) )
						{
							$r=$my->req('SELECT * FROM ttre_devis WHERE id_adresse='.$_GET['id'].' ');
							if ( $my->num($r)==0 )
							{
								$req_modif = $my->req ( 'UPDATE ttre_client_part_adresses SET 	
											num_voie			=	"'.$my->net_input($_POST['numvoie']).'" , 
											num_appart			=	"'.$my->net_input($_POST['numapp']).'" , 
											batiment			=	"'.$my->net_input($_POST['bat']).'" , 
											code_postal			=	"'.$my->net_input($_POST['cp']).'" , 
											ville				=	"'.$my->net_input($_POST['ville']).'" , 
											pays				=	"'.$my->net_input($_POST['pays']).'" 
												WHERE id  = "'.$_GET['id'].'"' );
							}	
							else 
							{
								$req_modif = $my->req ( 'UPDATE ttre_client_part_adresses SET statut="0" WHERE id = "'.$_GET['id'].'"' );
								$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
													'".$_SESSION['id_client_trn_part']."',
													'".$my->net_input($_POST["numvoie"])."',
													'".$my->net_input($_POST["numapp"])."',
													'".$my->net_input($_POST["bat"])."',
													'".$my->net_input($_POST["cp"])."',
													'".$my->net_input($_POST["ville"])."',
													'".$my->net_input($_POST["pays"])."',
													'1'
													)");
							}						
							header("location:espace_particulier.php?contenu=adresse&modif_adress=ok");exit;
						}
						break;
					case 'supprimer' :
						$r=$my->req('SELECT * FROM ttre_devis WHERE id_adresse='.$_GET['id'].' ');
						if ( $my->num($r)==0 )	$my->req('DELETE FROM ttre_client_part_adresses WHERE id='.$_GET['id']);
						else $my->req('UPDATE ttre_client_part_adresses SET statut="0" WHERE id = "'.$_GET['id'].'"' );
						header("location:espace_particulier.php?contenu=adresse&suppr_adress=ok");exit;
						break;
				}
			}	
			break;	
		case 'mdp_perdu' :
			if ( isset($_SESSION['id_client_trn_part']) ) {header("location:espace_particulier.php");exit;}
			if ( isset($_POST['mdp_perdu']) )
			{
				$rec=$my->req('SELECT * FROM ttre_client_part WHERE email = "'.$_POST['mail'].'" ');
				if ( $my->num($rec)==0 ){header("location:espace_particulier.php?contenu=mdp_perdu&erreur=mail");exit;}
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
					
					$my->req('DELETE FROM ttre_client_part_generation_pass WHERE cgp_client_id='.$can['id']);
					$my->req("INSERT INTO ttre_client_part_generation_pass VALUES('','".$can['id']."','".$my->net_input($passBdd)."','".$my->net_input($referencePass)."')");
					$message ='
						<html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
							<title>'.$nom_client.'</title>
						</head>
						
						<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#0066CC; font-size:14px;">
							<div id="en-tete" style="height:40px; width:800px; background-repeat:no-repeat; text-align:right;">
								<p><a href="'.$url_site_client.'/espace_particulier.php">Mon compte</a></p>
							</div>
					
							<div id="corps" style="width:800px; height:auto;">
								<h1 style="background-color:#FBD525; color:#FFF; font-size:16px; text-align:center;">Nouveau mot de passe</h1>
										
								<p>Bonjour,</p>																
								<p>Voici un mail automatique qui vous a été envoyé, suite à votre demande de modification de mots de passe. Vous trouverez dans cet e-mail votre nouveau mots de passe qui sera effectif à partir du moment où vous l\'aurez validé.</p>
								<div id="contenu-corps" style="background-color:#E6E6E6; text-align:center; font-size:14px; padding:10px;">
								
									<p>
										Nouveau mot de passe : '.$pass.'
									<br />
										Si vous avez demandé cette modification, veuillez cliquer sur le lien pour valider votre nouveau mots de passe : <br /> <a href="'.$url_site_client.'/espace_particulier.php?contenu=mdp_perdu&ref='.$referencePass.'">Changement de mots de passe</a>.
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
					header("location:espace_particulier.php?contenu=mdp_perdu&mdpperdu=ok");exit;
				}
			}
			elseif ( isset($_GET['ref']) )
			{
				$ligne=$my->req('SELECT * FROM ttre_client_part_generation_pass WHERE cgp_reference="'.$_GET['ref'].'"');
				if ( $my->num($ligne)==0 ) {header("location:espace_particulier.php?contenu=mdp_perdu&erreur=mdp");exit;}
				else
				{
					$forget=$my->arr($ligne);
					$req_modif = $my->req ( 'UPDATE ttre_client_part SET mdp="'.$my->net_input($forget['cgp_mdp']).'" WHERE id = "'.$forget['cgp_client_id'].'"' );
					header("location:espace_particulier.php?valid_mdp=ok");exit;
				}				
			}
			break;	
		case 'devis_histo' :
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:espace_particulier.php");exit;}
			if ( isset($_POST['envoie_note']) )
			{
				$my->req('UPDATE ttre_devis SET note_devis="'.$_POST["val"].'" WHERE id = "'.$_GET['idDevis'].'"' );
				header("location:espace_particulier.php?contenu=devis_histo&idDevis=".$_GET['idDevis']."&enregistrer=ok");exit;
			}
			if ( isset($_POST['envoie_message']) )
			{
				$my->req("INSERT INTO ttre_devis_cm VALUES('',
													'".$_GET['idDevis']."',
													'part',
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
				$temmp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
				$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$temmp['id_client_pro'].' ');
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
				header("location:espace_particulier.php?contenu=devis_histo&idDevis=".$_GET['idDevis']."&envoyer=ok");exit;
			}
			break;
		case 'devisa_encours' :
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:espace_particulier-.php");exit;}
			if ( isset($_GET['idDevis']) )
			{
				if ( isset($_GET['action']) )
				{
					switch ( $_GET['action'] )
					{
						case 'supprimer' :
							$my->req('UPDATE ttre_achat_devis SET statut_valid_admin = "-1" WHERE id = "'.$_GET['idDevis'].'" ' );
							$my->req('UPDATE ttre_achat_devis_client_pro SET statut_valid = "-1" WHERE id_devis = "'.$_GET['idDevis'].'" ' );
							header("location:espace_particulier.php?contenu=devisa_encours&supprimer=ok");exit;
							break;
						case 'valider' :
							$my->req('UPDATE ttre_achat_devis SET statut_valid_admin = "2" WHERE id = "'.$_GET['idDevis'].'" ' );
							$my->req('UPDATE ttre_achat_devis_client_pro SET statut_valid = "1" WHERE id = "'.$_GET['idADCP'].'" ' );
							header("location:espace_particulier.php?contenu=devisa_encours&valider=ok");exit;
							break;
					}
				}
			}
			break;
		case 'devisa_histo' :
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:espace_particulier.php");exit;}
			if ( isset($_POST['envoie_note']) )
			{
				$my->req('UPDATE ttre_achat_devis SET note_devis="'.$_POST["val"].'" WHERE id = "'.$_GET['idDevis'].'"' );
				header("location:espace_particulier.php?contenu=devisa_histo&idDevis=".$_GET['idDevis']."&enregistrer=ok");exit;
			}
			if ( isset($_POST['envoie_message']) )
			{
				$my->req("INSERT INTO ttre_achat_devis_cm VALUES('',
													'".$_GET['idDevis']."',
													'part',
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
				$temmp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_valid=1 ');
				$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$temmp['id_client_pro'].' ');
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
				$sujet = $nom_client.' : Nouveau message du devis avec achat immédiat de référence "'.$dd['reference'].'"';
				$headers = "From: \" ".$nom." \"<".$mail.">\n";
				$headers .= "Reply-To: ".$mail_client."\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($mail,$sujet,$message,$headers);
				header("location:espace_particulier.php?contenu=devisa_histo&idDevis=".$_GET['idDevis']."&envoyer=ok");exit;
			}
			break;
		case 'deconnexion' :
			unset ($_SESSION['id_client_trn_part']);
			unset ($_SESSION['panier_trn']);
			header("location:espace_particulier.php");exit;
			break;	
	}
}
// ----------------------------------------------------pour varAriane ----------------------------
if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'inscription' :
			$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Inscription</span>';
			break;
		case 'modif_param' :
			$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Informations personnelles</span>';
			break;
		case 'modif_mdp' :
			$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Mot de passe</span>';
			break;
		case 'adresse' :
			if ( isset($_GET['action']) )
			{
				switch ( $_GET['action'] )
				{
					case 'ajouter' :
						$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > 
									  <a href="espace_particulier.php?contenu=adresse">Carnet d\'adresses</a> > 
									  <span class="courant">Ajouter une adresse</span>';
						break;
					case 'modifier' :
						$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > 
									  <a href="espace_particulier.php?contenu=adresse">Carnet d\'adresses</a> > 
									  <span class="courant">Modifier une adresse</span>';
						break;
				}
			}	
			else 
				$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Carnet d\'adresse</span>';
			break;
		case 'devis_histo' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> >
						  <span><a href="espace_particulier.php?contenu=devis_histo">Historique</a></span> >
					      <span class="courant">Détail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Historique</span>';
			break;
		case 'mdp_perdu' :
			$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Nouveau mot de passe</span>';
			break;	
		case 'devisa_encours' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <a href="espace_particulier.php?contenu=devisa_encours">Gestion de devis avec achat immédiat</a> > <span class="courant">Détail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Gestion de devis avec achat immédiat</span>';
			break;	
		case 'devisa_histo' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> >
						  <span><a href="espace_particulier.php?contenu=devisa_histo">Historique</a></span> >
					      <span class="courant">Détail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_particulier.php">Mon compte</a></span> > <span class="courant">Historique</span>';
			break;	
	}
}
else
{
	if ( !isset($_SESSION['id_client_trn_part']) )
	{
		$varAriane = '<a href="espace_particulier.php">Mon compte</a>  ';
	}
	else 
	{
		$varAriane = '<a href="espace_particulier.php">Mon compte</a>';
	}
}
// -------------------------------------------------------------------------------------------------



 include('inc/head.php');?>
	<body id="page1">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
				<div class="wrapper">
					<div class="header-page-conseil">
						<div class="container">
							<div class="row">
								<h2>Espace Particulier</h2>
								<div class="formulaire">
									<h6>Formulaire</h6>
										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a href="upload/fichiers/'.$res['fichier'].'" target="_blanc">'.$res['titre'].'</a></li>';
												}
											}
										?>
										
										</ul>
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

	$('form[name="client_conn"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.email_connexion.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.email_connexion.value))) { mes_erreur+='<p>Votre Adresse mail est incorrect !</p>'; } }
		if( !$.trim(this.mdp_connexion.value) ) { mes_erreur+='<p>Il faut entrer le champ Mot de passe !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});
	$('select[name="etes1"]').change(function ()
	{
		if ( $('select[name="etes1"]').val()=='Autre' ) $('#p_pre1').css('display','') ;
		else $('#p_pre1').css('display','none') ;
	});	
	$('select[name="connus"]').change(function ()
	{
		if ( $('select[name="connus"]').val()=='Autre' ) $('#p_pre2').css('display','') ;
		else $('#p_pre2').css('display','none') ;
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
		if( !$.trim(this.nom_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Prénom !</p>'; }
		if( !$.trim(this.telephone_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Téléphone !</p>'; }
		if( !$.trim(this.numvoie_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Numéro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( $.trim(this.ville.value)==0 ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
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
		if( !$.trim(this.prenom.value) ) { mes_erreur+='<p>Il faut entrer le champ Prénom !</p>'; }
		if( !$.trim(this.telephone.value) ) { mes_erreur+='<p>Il faut entrer le champ Téléphone !</p>'; }
		if( !$.trim(this.numvoie.value) ) { mes_erreur+='<p>Il faut entrer le champ Numéro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( $.trim(this.ville.value)==0 ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
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
	$('form[name="adresse"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.numvoie.value) ) { mes_erreur+='<p>Il faut entrer le champ Numéro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( $.trim(this.ville.value)==0 ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
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
	$('form[name="note_envoie"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.val.value) ) { mes_erreur+='<p>Il faut entrer le champ Note !</p>'; }
		if( $.trim(this.val.value)>20 ) { mes_erreur+='<p>Il faut que le champ Note soit <= 20 !</p>'; }
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
<?php

echo'
	<div id="espace_compte">
		<p id="compte_ariane">
			<cite>Vous êtes ici : </cite>
			'.$varAriane.'
		</p>
	</div>
	';

if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'inscription' :
			$option_etes1='';
			for ( $i=1;$i<=count($tab_etes1);$i++ )
			{
				$option_etes1.='<option value="'.$tab_etes1[$i].'">'.$tab_etes1[$i].'</option>';
			}
			$option_etes2='';
			for ( $i=1;$i<=count($tab_etes2);$i++ )
			{
				$option_etes2.='<option value="'.$tab_etes2[$i].'">'.$tab_etes2[$i].'</option>';
			}
			$option_connus='';
			for ( $i=1;$i<=count($tab_connus);$i++ )
			{
				$option_connus.='<option value="'.$tab_connus[$i].'">'.$tab_connus[$i].'</option>';
			}
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est déjà associé à un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erroné.</p></div><br />';
						
			echo'
				'.$alert.'
				<div class="col-md-12" >
					<form name="client_ajout" action="espace_particulier.php?contenu=inscription" method="post" enctype="multipart/form-data" >
					<div class="container">
						<div class="row">
							<div class="col-md-12">
						
								
						<div class="form-groupe-part ">
						<div class="title-info"><h1>Informations personnelles</h1></div>
							<label for="ip_etes1">Vous êtes : </label><br />
							<select id="ip_etes1" name="etes1" class="not_chosen" ><option value=""></option>'.$option_etes1.'</select>
						</p>
						<p id="p_pre1" style="display:none;">
							<label for="ip_pre1">precisez : </label><br />
							<input id="ip_pre1" type="text" name="precisez1_nouveau"/>
						</p>
						<!-- <p>
							<label for="ip_etes2">Vous êtes : </label><br />
							<select id="ip_etes2" name="etes2_nouveau " class="not_chosen><option value="" ></option>'.$option_etes2.'</select>
						</p> -->
						<p>
							<label for="ip_civ">Civilité : <span class="obli">*</span></label>
							<input id="ip_civ" type="radio" value="Mr" name="civ_nouveau" checked="checked" /> Mr 
							<input id="ip_civ" type="radio" value="Mme" name="civ_nouveau"/> Mme 
							<input id="ip_civ" type="radio" value="Mlle" name="civ_nouveau"/> Mlle 
						</p>
							<label for="ip_nom">Nom : <span class="obli">*</span></label><br />
							<input id="ip_nom" type="text" name="nom_nouveau" placeholder="Nom"/><br />
							<label for="ip_prenom">Prénom : <span class="obli">*</span></label><br />
							<input id="ip_prenom" type="text" name="prenom_nouveau" placeholder="Prénom"/><br />
							<label for="ip_tel">Téléphone : <span class="obli">*</span></label><br />
							<input id="ip_tel" type="text" name="telephone_nouveau" placeholder="Téléphone"/><br />
							<label for="ip_voi">Numéro et voie : <span class="obli">*</span></label><br />
							<input id="ip_voi" type="text" name="numvoie_nouveau" placeholder="Numéro et voie"/><br />
							<label for="ip_app">N° d\'appartement, Etage, Escalier : <span class="obli">*</span></label><br />
							<input id="ip_app" type="text" name="numapp_nouveau" placeholder="N° d\'appartement, Etage, Escalier"/><br />
							<label for="ip_bat">Bâtiment, Résidence, Entrée: <span class="obli">*</span></label><br />
							<input id="ip_bat" type="text" name="bat_nouveau" placeholder="Bâtiment, Résidence, Entrée"/><br />
							<label for="ip_cp">Code Postal : <span class="obli">*</span></label><br />
							<input id="ip_cp" type="text" name="cp" onKeyPress="return scanTouche(event)" placeholder="Code postal"/><br />
							<label for="ip_ville">Ville : <span class="obli">*</span></label><br />
							<select id="ip_ville" name="ville"/></select><br />
							<label for="ip_pays">Pays : <span class="obli">*</span></label><br />
							<input id="ip_pays" type="text" name="pays_nouveau" value="France" readonly="readonly" placeholder="Pays" /><br />
							<label for="ip_mail">E-mail : <span class="obli">*</span></label><br />
							<input id="ip_mail" type="text" name="mail_nouveau" oncopy="return false;" onpaste="return false;" placeholder="E-mail"/><br />
							<label for="ip_mail">Confirmation de E-mail : <span class="obli">*</span></label><br />
							<input id="ip_mail" type="text" name="mailc_nouveau" oncopy="return false;" onpaste="return false;" placeholder="Email de confirmation"/><br />
							<label for="ip_connus">Comment vous nous avez connus : </label><br />
							<select id="ip_connus" name="connus"><option value=""></option>'.$option_connus.'</select><br />
						<p id="p_pre2" style="display:none;">
							<label for="ip_pre2">precisez : </label><br /><br />
							<input id="ip_pre2" type="text" name="precisez2_nouveau"/>
						</p><br />
							<label for="ip_mdp">Mot de passe : </label><br />
							<input id="ip_mdp" type="password" name="pass1_nouveau" placeholder="Mot de passe"/><br />
							<label for="verif_mdp">Cofirmation de mot de passe : </label><br />
							<input id="verif_mdp" type="password" name="pass2_nouveau" placeholder="Mot de passe de confirmation"/><br />
						<div class="valid">
							<label for="validation" >Veuillez recopier le code <img src="Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
							<input id="validation" type="text" name="validation" class="text-valid" />
						</div>		
						<p>
							<input type="checkbox" name="partenaire"/> Acceptation de recevoir offres partenaire
						</p>
						<p>
							<input type="checkbox" name="newsletter" checked="checked" /> S\'inscrire à notre newsletter
						</p>
						<p>
							<input type="checkbox" name="condition" id="condition"/> Acceptation des <a href="mention.php" target="_blanc"> conditions générales </a>
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
					<p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a></p>
				</div>
				';			
			break;
		case 'modif_param' :
			$cl=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$_SESSION['id_client_trn_part'].' ');
			$option_etes1='';
			for ( $i=1;$i<=count($tab_etes1);$i++ )
			{
				if ( $my->net_input($tab_etes1[$i])==$cl['etes1'] ) $sel='selected="selected"'; else $sel=''; 
				$option_etes1.='<option value="'.$tab_etes1[$i].'" '.$sel.' >'.$tab_etes1[$i].'</option>';
			}
			if ( $cl['etes1']!=$my->net_input('Autre') ) $styleetes1=' style="display:none;"'; else $styleetes1='';
			$option_etes2='';
			for ( $i=1;$i<=count($tab_etes2);$i++ )
			{
				if ( $my->net_input($tab_etes2[$i])==$cl['etes2'] ) $sel='selected="selected"'; else $sel=''; 
				$option_etes2.='<option value="'.$tab_etes2[$i].'" '.$sel.' >'.$tab_etes2[$i].'</option>';
			}
			$option_connus='';
			for ( $i=1;$i<=count($tab_connus);$i++ )
			{
				if ( $my->net_input($tab_connus[$i])==$cl['connus'] ) $sel='selected="selected"'; else $sel=''; 
				$option_connus.='<option value="'.$tab_connus[$i].'" '.$sel.' >'.$tab_connus[$i].'</option>';
			}
			if ( $cl['connus']!=$my->net_input('Autre') ) $styleconnus=' style="display:none;"'; else $styleconnus='';
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
			$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_part WHERE email="'.$cl['email'].'" ');
			if ( $my->num($req_news)==0 ) $news_check=''; else $news_check='checked="checked"';
			$req_part=$my->req('SELECT * FROM ttre_inscrits_partenaires WHERE email="'.$cl['email'].'" ');
			if ( $my->num($req_part)==0 ) $part_check=''; else $part_check='checked="checked"';
			
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est déjà associé à un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erroné.</p></div><br />';
						
			echo'
				'.$alert.'
				<div class="col-md-12">
					<form name="client_modif" action="espace_particulier.php?contenu=modif_param" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
							<div class="form-groupe-part ">
									<div class="title-info"><h1>Informations personnelles</h1></div>
						<p>
							<label for="ip_etes1">Vous êtes : </label>
							<select id="ip_etes1" name="etes1"><option value=""></option>'.$option_etes1.'</select>
						</p>
						<p id="p_pre1" '.$styleetes1.' >
							<label for="ip_pre1">precisez : </label>
							<input id="ip_pre1" type="text" name="precisez1" value="'.$cl['precisez1'].'" />
						</p>
						<p>
							<label for="ip_etes2">Vous êtes : </label>
							<select id="ip_etes2" name="etes2"><option value=""></option>'.$option_etes2.'</select>
						</p>
						<p>
							<label for="ip_civ">Civilité : <span class="obli">*</span></label>
							<input id="ip_civ" type="radio" value="Mr" name="civ" '.$civ1.' /> Mr 
							<input id="ip_civ" type="radio" value="Mme" name="civ" '.$civ2.' /> Mme 
							<input id="ip_civ" type="radio" value="Mlle" name="civ" '.$civ3.' /> Mlle 
						</p>
						<p>
							<label for="ip_nom">Nom : <span class="obli">*</span></label>
							<input id="ip_nom" type="text" name="nom" value="'.$cl['nom'].'" />
						</p>
						<p>
							<label for="ip_prenom">Prénom : <span class="obli">*</span></label>
							<input id="ip_prenom" type="text" name="prenom" value="'.$cl['prenom'].'"/>
						</p>
						<p>
							<label for="ip_tel">Téléphone : <span class="obli">*</span></label>
							<input id="ip_tel" type="text" name="telephone" value="'.$cl['telephone'].'"/>
						</p>
						<p>
							<label for="ip_voi">Numéro et voie : <span class="obli">*</span></label>
							<input id="ip_voi" type="text" name="numvoie" value="'.$cl['num_voie'].'"/>
						</p>
						<p>
							<label for="ip_app">N° d\'appartement, Etage, Escalier : </label>
							<input id="ip_app" type="text" name="numapp" value="'.$cl['num_appart'].'"/>
						</p>
						<p>
							<label for="ip_bat">Bâtiment, Résidence, Entrée : </label>
							<input id="ip_bat" type="text" name="bat" value="'.$cl['batiment'].'"/>
						</p>
						<p>
							<label for="ip_cp">Code postal : <span class="obli">*</span></label>
							<input id="ip_cp" type="text" name="cp" value="'.$cl['code_postal'].'" onKeyPress="return scanTouche(event)"/>
						</p>
						<p>
							<label for="ip_ville">Ville : <span class="obli">*</span></label>
							<select id="ip_ville" name="ville"/>'.$optionville.'</select>
						</p>
						<p>
							<label for="ip_pays">Pays : <span class="obli">*</span></label>
							<input id="ip_pays" type="text" name="pays" value="France" readonly="readonly" />
						</p>
						<p>
							<label for="ip_mail">Email : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" value="'.$cl['email'].'" name="mail" oncopy="return false;" onpaste="return false;"/>
						</p>
						<p>
							<label for="ip_mail">Email de confirmation : <span class="obli">*</span></label>
							<input id="ip_mail" type="text" value="'.$cl['email'].'" name="mailc" oncopy="return false;" onpaste="return false;"/>
						</p>
						<p>
							<label for="ip_connus">Comment vous nous avez connus : </label>
							<select id="ip_connus" name="connus"><option value=""></option>'.$option_connus.'</select>
						</p>
						<p id="p_pre2" '.$styleconnus.' >
							<label for="ip_pre2">precisez : </label>
							<input id="ip_pre2" type="text" name="precisez2" value="'.$cl['precisez2'].'"/>
						</p>
						<div class="valid">
							<label for="validation">Veuillez recopier le code <img src="Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
							<input id="validation" type="text" name="validation" />
						</div>		
						<p>
							<input type="checkbox" name="partenaire" '.$part_check.' /> Acceptation de recevoir offres partenaire
						</p>
						<p>
							<input type="checkbox" name="newsletter" '.$news_check.' /> S\'inscrire à notre newsletter
						</p>
						<p>
							<input type="checkbox" name="condition" id="condition"/> Acceptation des <a href="mention.php" target="_blanc"> conditions générales </a>
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
					<p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a></p>
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
					<p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a></p>
				</div>
				';
			break;
		case 'adresse' :
			if ( isset($_GET['action']) )
			{
				switch ( $_GET['action'] )
				{
					case 'ajouter' :
						
						$alert='<div id="note"></div><br />';
						echo'
							'.$alert.'
							<div id="">
								<form name="adresse" action="espace_particulier.php?contenu=adresse&action=ajouter" method="post" enctype="multipart/form-data" class="">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<div class="form-groupe-part ">
												<div class="title-info"><h1>Informations personnelles</h1></div>
													<p>
														<label for="ip_voi">Numéro et voie : <span class="obli">*</span></label>
														<input id="ip_voi" type="text" name="numvoie" value=""/>
													</p>
													<p>
														<label for="ip_app">N° d\'appartement, Etage, Escalier : </label>
														<input id="ip_app" type="text" name="numapp" value=""/>
													</p>
													<p>
														<label for="ip_bat">Bâtiment, Résidence, Entrée : </label>
														<input id="ip_bat" type="text" name="bat" value=""/>
													</p>
													<p>
														<label for="ip_cp">Code postal : <span class="obli">*</span></label>
														<input id="ip_cp" type="text" name="cp" value="" onKeyPress="return scanTouche(event)"/>
													</p>
													<p>
														<label for="ip_ville">Ville : <span class="obli">*</span></label>
														<select id="ip_ville" name="ville"/></select>
													</p>
													<p>
														<label for="ip_pays">Pays : <span class="obli">*</span></label>
														<input id="ip_pays" type="text" name="pays" value="France" readonly="readonly" />
													</p>
													
													<p class="align_center padding_tb_20">
														<input value="valider" class="sub" type="submit" name="ajout_adresse"/>
													</p>
													<p class="note" id="text_erreur"><cite>( * ) champs obligatoires.</cite></p>
											</div>
										</div>
									</div>
								</div>
								</form>	
								<p class="margin_top_20"><a href="espace_particulier.php?contenu=adresse">Retour à la page précédente</a></p>
							</div>
							';			
						break;				
					case 'modifier' :
						$cl=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$_GET['id'].'');
						
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
					
						$alert='<div id="note"></div><br />';
						echo'
							'.$alert.'
							<div id="">
								<form name="adresse" action="espace_particulier.php?contenu=adresse&action=modifier&id='.$_GET['id'].'" method="post" enctype="multipart/form-data" class="">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<div class="form-groupe-part ">
												<div class="title-info"><h1>Informations personnelles</h1></div>
									<p>
										<label for="ip_voi">Numéro et voie : <span class="obli">*</span></label>
										<input id="ip_voi" type="text" name="numvoie" value="'.$cl['num_voie'].'"/>
									</p>
									<p>
										<label for="ip_app">N° d\'appartement, Etage, Escalier : </label>
										<input id="ip_app" type="text" name="numapp" value="'.$cl['num_appart'].'"/>
									</p>
									<p>
										<label for="ip_bat">Bâtiment, Résidence, Entrée : </label>
										<input id="ip_bat" type="text" name="bat" value="'.$cl['batiment'].'"/>
									</p>
									<p>
										<label for="ip_cp">Code postal : <span class="obli">*</span></label>
										<input id="ip_cp" type="text" name="cp" value="'.$cl['code_postal'].'" onKeyPress="return scanTouche(event)"/>
									</p>
									<p>
										<label for="ip_ville">Ville : <span class="obli">*</span></label>
										<select id="ip_ville" name="ville"/>'.$optionville.'</select>
									</p>
									<p>
										<label for="ip_pays">Pays : <span class="obli">*</span></label>
										<input id="ip_pays" type="text" name="pays" value="France" readonly="readonly" />
									</p>
									
									<p class="align_center padding_tb_20">
										<input value="valider" class="sub" type="submit" name="modif_adresse"/>
									</p>
									<p class="note" id="text_erreur"><cite>( * ) champs obligatoires.</cite></p>
									
											</div>
										</div>
									</div>
								</div>
								</form>	
								<p class="margin_top_20"><a href="espace_particulier.php?contenu=adresse">Retour à la page précédente</a></p>
							</div>
							';			
						break;
				}
			}	
			else
			{
				$alert='<div id="note"></div><br />';
				if ( isset($_GET['ajout_adress']) )echo'<div id="note" class="notes"><p>Adresse ajoutée.</p></div><br />';
				elseif ( isset($_GET['modif_adress']) )echo'<div id="note" class="notes"><p>Adresses modifiée.</p></div><br />';
				elseif ( isset($_GET['suppr_adress']) )echo'<div id="note" class="notes"><p>Adresse supprimée.</p></div><br />';
				$contenu_adresse='';
				$req= $my->req('SELECT * FROM ttre_client_part_adresses WHERE id_client="'.$_SESSION['id_client_trn_part'].'" AND statut=1 ');
				if ( $my->num($req)>0 )
				{
					$contenu_adresse.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Numero et voie</td>							
									<td>N° d’appartement</td>																								
									<td>Bâtiment</td>
									<td>CP</td>
									<td>Ville</td>
									<td>Pays</td>	
									<td class="width_20"></td>									
									<td class="width_20"></td>								
								</tr>
									  ';	
					while ( $res=$my->arr($req) )
					{
						$ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
						$contenu_adresse.='
								<tr>
									<td>'.ucfirst($res['num_voie']).'</td>			
									<td>'.ucfirst($res['num_appart']).'</td>																							
									<td>'.ucfirst($res['batiment']).'</td>
									<td>'.ucfirst($res['code_postal']).'</td>
									<td>'.ucfirst($ville['ville_nom_reel']).'</td>
									<td>'.ucfirst($res['pays']).'</td>
									<td><a href="espace_particulier.php?contenu=adresse&action=modifier&id='.$res['id'].'" title="Modifier cette adresse"><img src="stockage_img/book_edit.png" alt="Modifier cette adresse"/></a></td>									
									<td><a href="espace_particulier.php?contenu=adresse&action=supprimer&id='.$res['id'].'" title="Supprimer cette adresse"><img src="stockage_img/book_delete.png" alt="Supprimer cette adresse"/></a></td>		
								</tr>		
									  	  ';	
					}
					$contenu_adresse.='</table>';	
									
				}
				else
				{
					$contenu_adresse.='<p class="padding_bottom_20">Votre carnet ne contient actuellement aucune adresse (cela signifie donc que, pour le moment, vous ne pouvez pas faire des devis).</p>';
				}
				$contenu_adresse.='<p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a> | <a href="espace_particulier.php?contenu=adresse&action=ajouter">Ajouter une adresse</a></p>';
				echo'
					<div id="espace_compte">
						'.$contenu_adresse.'
					</div>
					';
			}
			break;
		case 'mdp_perdu' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Cette adresse email n\'existe pas dans notre base !</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mdp' ) $alert='<div id="note" class="error"><p>Changement Annulé.</p></div><br />';
			if ( isset($_GET['mdpperdu']) ) $alert='<div id="note" class="success"><p>Un nouveau mot de passe vous a été envoyé, vous devez maintenant le valider pour pouvoir vous connecter sur notre site.</p></div><br />';
			echo'
				'.$alert.'
				<div id="espace_compte" style="margin: 0 0 0 100px;">
					<form name="perdu_mdp" method="post" action="espace_particulier.php?contenu=mdp_perdu" class="tpl_form_defaut intitules_moyens champs_larges" >
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
					<p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a></p>
				</div>
				';		
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
							<h4>Informations générales</h4>
							<dl>
								<dt>Date Devis : </dt>
								<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
								<dt>Date Payement : </dt>
								<dd>'.date("d-m-Y",$tempp['date_payement']).'</dd>
								<dt>Mode de paiement : </dt>
								<dd>'.$tempp['type_payement'].'</dd>
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
					<li class="centeral col-md-4">
						<h4>Adresse de chantier</h4>
						<dl>
							<dd>Numero et voie : '.$num_voie.'</dd>
							<dd>N° d’appartement : '.$num_appart.'</dd>
							<dd>Bâtiment : '.$batiment.'</dd>
							<dd>'.$code_postal.' '.$ville.', '.$pays.'</dd>
							
						</dl>
					</li>
					';
				$resoo = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$tempp['id_client_pro'].' ');
				$resoo_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$resoo['ville'].'" ');
				
				$res = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$infos_devis['id_client'].' ');
				$detail.='
					<li class="col-md-4">
						<h4>Informations de client professionnel</h4>
						<dl>
							<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst(html_entity_decode($resoo['nom'])).' '.ucfirst(html_entity_decode($resoo['prenom'])).'</dd>
							<dd>'.html_entity_decode($resoo['telephone']).' - '.html_entity_decode($resoo['email']).'</dd>
							<dd>Numéro et voie : '.html_entity_decode($resoo['num_voie']).'</dd>
							<dd>'.html_entity_decode($resoo['code_postal']).' '.html_entity_decode($resoo_ville['ville_nom_reel']).', '.html_entity_decode($resoo['pays']).'</dd>
						
						</dl>
					</li>
				</ul>
				</div>';
				$detail.='
				<div class="col-md-12">
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
				$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
				while ( $ress=$my->arr($reqq) )
				{
					if ( $nom_cat!=$ress['titre_categ'] )
					{
						$nom_cat=$ress['titre_categ'];
						$detail.='
							<tr>
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
							<td class="mnt-total">'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' €</td>
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
								<td colspan="1" class="prix_final">'.number_format($temp['prix_total'], 2,'.','').'€</td>
							</tr>
							';
				}
				$detail.='
					<tr class="total">
						<td colspan="5"><strong>Total TTC : </strong></td>
						<td colspan="1" class="prix_final">'.$total.' €</td>
					</tr>
				</table></div><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'&suite=ok">Aperçu avant imprimer</a>';
			
				$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
				$detail.='<p>Prix proposé : '.number_format($temp['prix_enchere'],2).' €  </p><br /><br />';
					
				
				// ------------------------- Partie dialogue -----------------------------
				$alert='<div id="note"></div>';
				if ( isset($_GET['envoyer']) ) $alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" class="success" ><p>Votre message a bien été envoyé.</p></div>';
				if ( isset($_GET['enregistrer']) ) $alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" class="success" ><p>Votre note a bien été enregistré.</p></div>';
				
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
							<form  name="message_envoie" method="post" class="" enctype="multipart/form-data" >
								<div class="dialogue-part">
									
									<p>
										<textarea id="message" type="text" name="message" placeholder="Message *" required></textarea>
									</p>
									<p>
										<table id="tblPhoto">
											<tr>
												<td>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[+]" onclick="addRowToTablePhoto();" /></div>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[-]" onclick="removeRowFromTablePhoto();" /></div>
												</td>
											</tr>
											<tr>
												<th>N°</td>
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
							<form  name="note_envoie" method="post" class="tpl_form_defaut " enctype="multipart/form-data" >
								<div class="note">
									<h6>Note :</h6>
									<p class="input">
										<label for="val">Note / 20 : <span class="obli">*</span></label>
										<input id="val" type="text" placeholder="Note /20 *" name="val" value="'.$id['note_devis'].'" onKeyPress="return scanTouche(event)" />
									</p>
									
									<p class="align_center padding_tb_20">
										<input value="Enregistrer" type="submit" name="envoie_note"/>
									</p>
								</div>
							</form>
					</div>';
				
				// -----------------------------------------------------------------------
				
				
				$detail.='<div class="col-md-7">
				<p class="margin_top_20"><a href="espace_particulier.php?contenu=devis_histo">Retour à la page précédente</a></p>
					</div>';
				echo'
				<div id="espace_compte">
					'.$detail.'
				</div>
				';
			}
			else
			{
				$liste='';
				$req = $my->req('SELECT * FROM ttre_devis WHERE statut_valid_admin=3 AND id_client='.$_SESSION['id_client_trn_part'].' ORDER BY date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Référence</td>
								<td>Date</td>
								<td>Type</td>
								<td>Montant</td>
								<td class="width_60">Détails</td>
							</tr>
					';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$res['id'].' ');
						$resss=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$res['id'].' AND statut_enchere=1 ');
						$total=$ress['total_net']+$ress['total_tva']+$ress['frais_port'];
						$liste.='
							<tr>
								<td><a href="espace_particulier.php?contenu=devis_histo&idDevis='.$res['id'].'">'.$ress['reference'].'</a></td>
								<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
								<td>'.$resss['type_payement'].'</td>
								<td><strong>'.number_format($total, 2,'.','').' €</strong></td>
								<td><a href="espace_particulier.php?contenu=devis_histo&idDevis='.$res['id'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
							</tr>
							';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis à cet instant.</p>';
				}
				echo'
				'.$alert.'
				<div id="espace_compte">
					'.$liste.'
				</div>
				';
			}
			break;
		case 'devisa_encours' :
			if ( isset($_GET['idDevis']) )
			{
				$detail='';
				/*$temp=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id='.$_GET['idDevis'].' ');
				$detail.='<p><strong>Description : </strong> '.$temp['description'].'</p>';*/
							
				$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
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
								<td colspan="6">'.$nom_cat.'</td>
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
				$detail.='</table><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aperçu avant imprimer</a>';
				
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['idDevis'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers à télécharger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p>';
				}
				
				$req= $my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis="'.$_GET['idDevis'].'" AND statut_achat=1 ');
				if ( $my->num($req)>0 )
				{
					$detail.='
							<br /><br /><p>Liste des clients professionnels :</p><br />
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Nom et prénom</td>
									<td>Email</td>
									<td class="width_20"></td>
								</tr>
									  ';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client_pro'].' ');
						$detail.='
								<tr>
									<td>'.ucfirst($ress['nom']).' '.ucfirst($ress['prenom']).'</td>
									<td>'.ucfirst($ress['email']).'</td>
									<td><a href="espace_particulier.php?contenu=devisa_encours&idDevis='.$_GET['idDevis'].'&action=valider&idADCP='.$res['id'].'" titre="Valider ce client"><img src="stockage_img/accept.png" alt="Valider ce client"/></a></td>
								</tr>
									  	  ';
					}
					$detail.='</table>';
						
				}
				else
				{
					$detail.='<br /><br /><p class="padding_bottom_20">Pas de client pour cette instant.</p>';
				}
				
				$detail.='
				<p class="margin_top_20"><a href="espace_particulier.php?contenu=devisa_encours">Retour à la page précédente</a></p>
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
				$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=1 AND id_client='.$_SESSION['id_client_trn_part'].' ORDER BY date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Référence</td>
								<td>Date</td>
								<td class="width_60">Détails</td>
								<td class="width_60">Supp.</td>
							</tr>
					';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id'].' ');
						$liste.='
							<tr>
								<td><a href="espace_particulier.php?contenu=devisa_encours&idDevis='.$res['id'].'">'.$ress['reference'].'</a></td>
								<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
								<td><a href="espace_particulier.php?contenu=devisa_encours&idDevis='.$res['id'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								<td><a href="espace_particulier.php?contenu=devisa_encours&idDevis='.$res['id'].'&action=supprimer" title="Supprimer"><img src="stockage_img/supprimer.png" alt="Supprimer"/></a></td>
							</tr>
							';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis à cet instant.</p>';
				}
				$alert='';
				if ( isset($_GET['valider']) ) $alert='<div id="note" class="success"><p>Votre devis a bien été validé.</p></div><br />';
				if ( isset($_GET['supprimer']) ) $alert='<div id="note" class="success"><p>Votre devis a bien été supprimé.</p></div><br />';
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
					<ul id="compte_details_com">
						<li>
							<h4>Informations générales</h4>
							<dl>
								<dt>Date Devis : </dt>
								<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
								<dt>Date Payement : </dt>
								<dd>'.date("d-m-Y",$tempp['date_payement']).'</dd>
								<dt>Mode de paiement : </dt>
								<dd>'.$tempp['type_payement'].'</dd>
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
					';
				$resoo = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$tempp['id_client_pro'].' ');
				$resoo_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$resoo['ville'].'" ');
				
				$res = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$infos_devis['id_client'].' ');
				$detail.='
					<li>
						<h4>Informations de client professionnel</h4>
						<dl>
							<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst(html_entity_decode($resoo['nom'])).' '.ucfirst(html_entity_decode($resoo['prenom'])).'</dd>
							<dd>'.html_entity_decode($resoo['telephone']).' - '.html_entity_decode($resoo['email']).'</dd>
							<dd>Numéro et voie : '.html_entity_decode($resoo['num_voie']).'</dd>
							<dd>'.html_entity_decode($resoo['code_postal']).' '.html_entity_decode($resoo_ville['ville_nom_reel']).'</dd>
							<dd>'.html_entity_decode($resoo['pays']).'</dd>
						</dl>
					</li>
				</ul>';
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
							<tr style="background:#cecece;">
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
				$detail.='</table><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'&suite=ok">Aperçu avant imprimer</a>';
		
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['idDevis'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers à télécharger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p><br />';
				}
				
				// ------------------------- Partie dialogue -----------------------------
				$alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" ></div>';
				if ( isset($_GET['envoyer']) ) $alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" class="success" ><p>Votre message a bien été envoyé.</p></div>';
				if ( isset($_GET['enregistrer']) ) $alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" class="success" ><p>Votre note a bien été enregistré.</p></div>';
				
				$id = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevis'].' ');
				$idd = $my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_valid=1 ');
				$icpa = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$id['id_client'].' ');
				$icpr = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$idd['id_client_pro'].' ');
				$req = $my->req('SELECT * FROM ttre_achat_devis_cm WHERE id_devis='.$_GET['idDevis'].' ORDER BY date ASC ');
				if ( $my->num($req)>0 )
				{
					$detail.='<ul>';
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
					$detail.='</ul>';
				}
				
				$detail.='
						</div>
						'.$alert.'
						
						<div class="container">
							<div class="row">
								<div class="col-md-7">
							<form name="message_envoie" method="post" class="" enctype="multipart/form-data" >
											<div class="dialogue-part">
											<h6>Message </h6>
									<p>
										<label for="mdp">Message : <span class="obli">*</span></label>
										<textarea id="message" type="text" name="message"></textarea>
									</p>
									<p>
										<input type="hidden" name="nbrPhoto" id="nbrPhoto" value="1" >
										<table id="tblPhoto" >
											<tr>
												<td>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[+]" onclick="addRowToTablePhoto();" /></div>
													<div class="add-camera"><i class="fa fa-camera"></i><input type="button" value="[-]" onclick="removeRowFromTablePhoto();" /></div>
												</td>
											</tr>
											<tr>
												<th>N°</td>
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
							<form  name="note_envoie" method="post" class="tpl_form_defaut intitules_moyens champs_larges" enctype="multipart/form-data" >
								<div class="note">
									<h6>Note :</h6>
									<p class="input">
										<label for="val">Note / 20 : <span class="obli">*</span></label>
										<input id="val" type="text" placholder="Note /20 *" name="val" value="'.$id['note_devis'].'" onKeyPress="return scanTouche(event)" />
									</p>
									
									<p class="align_center padding_tb_20">
										<input value="Enregistrer" type="submit" name="envoie_note"/>
									</p>
								</div>
							</form>
							</div>
							</div>
							</div>
					';
				
				// -----------------------------------------------------------------------
				
				
				$detail.='
				<p class="margin_top_20"><a href="espace_particulier.php?contenu=devisa_histo">Retour à la page précédente</a></p>
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
				$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=2 AND id_client='.$_SESSION['id_client_trn_part'].' ORDER BY date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Référence</td>
								<td>Date</td>
								<td>Type</td>
								<td class="width_60">Détails</td>
							</tr>
					';
					while ( $res=$my->arr($req) )
					{
						$ress=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id'].' ');
						$resss=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id'].' AND statut_valid=1 ');
						$liste.='
							<tr>
								<td><a href="espace_particulier.php?contenu=devisa_histo&idDevis='.$res['id'].'">'.$ress['reference'].'</a></td>
								<td>'.date("d-m-Y",$ress['date_ajout']).'</td>
								<td>'.$resss['type_payement'].'</td>
								<td><a href="espace_particulier.php?contenu=devisa_histo&idDevis='.$res['id'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
							</tr>
							';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_particulier.php">Retour à la page précédente</a></p>';
				}
				else
				{
					$liste.='<p>Aucun devis à cet instant.</p>';
				}
				echo'
				'.$alert.'
				<div id="espace_compte">
					'.$liste.'
				</div>
				';
			}
			break;
	}
}
else
{
	if ( !isset($_SESSION['id_client_trn_part']) )
	{
		$alert='<div id="note"></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='erreur') ) $alert='<div id="note" class="error"><p>Erreur lors de l\'authentification.</p></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='valider') ) $alert='<div id="note" class="success"><p>Votre compte a bien été validé.</p></div><br />';
		if ( isset($_GET['modif']) && ($_GET['modif']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		if ( isset($_GET['valid_mdp']) ) $alert='<div id="note" class="notice"><p>Votre mot de passe a bien été modifié, vous pouvez dès maintenant vous connecter.</p></div><br />';
		echo'
			'.$alert.'
			
				<div class="col-md-6 ">
					<div class="Login-part">
						<div class="title-sign-part">Vous avez déjà un compte ?</div>
						<form action="espace_particulier.php?contenu=connexion" name="client_conn" method="post" class="" >
							<div class="form-login-part">
									<input id="mail" type="text" name="email_connexion" placeholder="Votre adresse mail" /><br />
									<input id="mdp" type="password" name="mdp_connexion" placeholder="Votre mot de passe"/><br />
									<input class="boutons_persos_1" value="Connexion" type="submit" name="conn_client"/><br />
									<p>Si vous avez oublié votre mot de passe, <a href="espace_particulier.php?contenu=mdp_perdu" style="color:#000">cliquez ici</a>.</p>
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
							<a href="espace_particulier.php?contenu=inscription" class="">Créer un compte</a>
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
			<div id="espace_compte">
				<p class="padding_bottom_20">Bienvenue dans votre espace personnel, vous pouver depuis cette page gérer toutes vos informations personnelles ainsi que vos commandes.</p>												
				<ul id="tableau_bord">
					<li id="compte_infos">
						<dl>
							<dt>Informations personnelles</dt>
							<dd class="description">C\'est dans cette section que vous pourrez accéder à vos informations personnelles et les modifier.</dd>
							<dd class="lien"><a href="espace_particulier.php?contenu=modif_param">Modifier mes informations</a></dd>
						</dl>
					</li>
					<li id="compte_mdp" class="droite">
						<dl>
							<dt>Mot de passe</dt>
							<dd class="description">Pour des questions de sécurité, il est conseillé de modifier son mot de passe fréquemment.</dd>
							<dd class="lien"><a href="espace_particulier.php?contenu=modif_mdp">Modifier mon mot de passe</a></dd>
						</dl>
					</li>
					<li id="compte_adresses">
						<dl>
							<dt>Carnet d\'adresses</dt>
							<dd class="description">C\'est dans cette section que vous pouvez ajouter, modifier et supprimer vos adresses.</dd>
							<dd class="lien"><a href="espace_particulier.php?contenu=adresse">Gérer mes adresses</a></dd>
						</dl>
					</li>
					<li id="compte_adresses" class="droite">
						<dl>
							<dt>Historique de devis avec enchère</dt>
							<dd class="description">C\'est dans cette section que vous pourrez consulter l\'historique de vos devis avec enchère.</dd>
							<dd class="lien"><a href="espace_particulier.php?contenu=devis_histo">historique</a></dd>
						</dl>
					</li>
					<li id="compte_adresses">
						<dl>
							<dt>Gestion de devis avec achat immédiat</dt>
							<dd class="description">C\'est dans cette section que vous pourrez valider ou arréter votre devis avec achat immédiat.</dd>
							<dd class="lien"><a href="espace_particulier.php?contenu=devisa_encours">Devis en cours</a></dd>
						</dl>
					</li>
					<li id="compte_adresses" class="droite">
						<dl>
							<dt>Historique de devis avec achat immédiat</dt>
							<dd class="description">C\'est dans cette section que vous pourrez consulter l\'historique de vos devis avec achat immédiat.</dd>
							<dd class="lien"><a href="espace_particulier.php?contenu=devisa_histo">historique</a></dd>
						</dl>
					</li>
				</ul>
				<p><a href="espace_particulier.php?contenu=deconnexion"> » Se déconnecter</a></p>		
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