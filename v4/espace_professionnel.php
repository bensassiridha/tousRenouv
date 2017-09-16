<?php
require('inc/session.php');







if ( isset($_GET['idDevisPaye']) )
{
	$devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id="'.$_GET['idDevisPaye'].'" ');
	if ( $devis )
	{
		$ress=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevisPaye'].' AND statut_enchere=1 ');
		if ( $ress['id_client_pro']==$_SESSION['id_client_trn_pro'] )
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
								date_payement			=	"'.time().'" ,
								type_payement			=	"test" ,
								fichier_update			=	"site" 
							WHERE id_devis = "'.$devis['id'].'" ' );
			}
			header("location:espace_professionnel.php?contenu=devis_att_paye&paiement=effectuer");exit;
		}
		else
		{
			header("location:espace_professionnel.php?contenu=devis_att_paye&paiement=annuler");exit;
		}
	}
	else
	{
		header("location:espace_professionnel.php?contenu=devis_att_paye&paiement=annuler");exit;
	}
}
if ( isset($_GET['idDevisaPaye']) )
{
	$devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id="'.$_GET['idDevisaPaye'].'" ');
	if ( $devis['statut_valid_admin']==1 )
	{
		$adcp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['idDevisaPaye'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].' ');
		$id_devis=$devis['id'];
		$id_adresse=$devis['id_adresse'];
		$id_client_part=$devis['id_client'];
		$id_client_pro=$adcp['id_client_pro'];
		require_once 'mailAchatDevis.php';
		/*$my->req ( 'UPDATE ttre_achat_devis SET
						statut_valid_admin		=	"2" 
					WHERE id = "'.$devis['id'].'" ' );*/
		$my->req ( 'UPDATE ttre_achat_devis_client_pro SET
						date_payement			=	"'.time().'" ,
						type_payement			=	"test" ,
						fichier_update			=	"site" ,
						statut_achat			=	"1" 
					WHERE id = "'.$adcp['id'].'" ' );
	}
	header("location:espace_professionnel.php?contenu=devisa_att_paye&paiement=effectuer");exit;
}


// ----------------------------------------------------pour la gestion ----------------------------
if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'connexion' :
			if ( isset($_POST['conn_client']) )
			{
				$req=$my->req('SELECT * FROM ttre_client_pro WHERE email="'.$_POST['email_connexion'].'" AND mdp="'.md5($_POST['mdp_connexion']).'" AND stat_valid=1 ');
				if ( $my->num($req)==0 )
				{
					header("location:espace_professionnel.php?inscrit=erreur");exit;
				}
				else
				{
					$cl=$my->arr($req);
					$_SESSION['id_client_trn_pro']=$cl['id'];
					header("location:espace_professionnel.php");exit;
				}
			}
			break;
		case 'inscription' :
			if ( isset($_POST['ajout_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:espace_professionnel.php?contenu=inscription&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_client_pro WHERE email="'.$_POST['mail_nouveau'].'"');
					if ( $my->num($req)>0 ) {header("location:espace_professionnel.php?contenu=inscription&erreur=mail");exit;}
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
						$my->req("INSERT INTO ttre_client_pro VALUES('',
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
													'".$my->net_input($_POST["nom_nouveau"])."',
													'".$my->net_input($_POST["prenom_nouveau"])."',
													'".$my->net_input($_POST["telephone_nouveau"])."',
													'".$my->net_input($_POST["fax_nouveau"])."',
													'".$my->net_input($_POST["mail_nouveau"])."',
													'".$my->net_input($fich1_nouveau)."',
													'".$my->net_input($fich2_nouveau)."',
													'".$my->net_input($fich3_nouveau)."',
													'".md5($_POST["pass1_nouveau"])."',
													'0'
													)");
						$id_client=mysql_insert_id();
						if ( isset($_POST['newsletter']) )
						{
							$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_pro WHERE email="'.$_POST['mail_nouveau'].'" ');
							if ( $my->num($req_news)==0 ) $my->req("INSERT INTO ttre_inscrits_newsletters_pro VALUES('','".$my->net_input($_POST['mail_nouveau'])."') ");
						}
						else
						{
							$my->req('DELETE FROM ttre_inscrits_newsletters_pro WHERE email="'.$_POST['mail_nouveau'].'" ');
						}
						
						foreach ( $_POST['categorie'] as $value ) 
							$my->req("INSERT INTO ttre_client_pro_categories VALUES('','".$id_client."','".$value."')");
						foreach ( $_POST['departement'] as $value ) 
							$my->req("INSERT INTO ttre_client_pro_departements VALUES('','".$id_client."','".$value."')");
						header("location:espace_professionnel.php?inscrit=enattente");exit;			
					}
				}
			}
			break;
		case 'valider' :
			$my->req('UPDATE ttre_client_pro SET stat_valid="1" WHERE ref_valid="'.$_GET['ref'].'" AND stat_valid="0" ');
			header("location:espace_professionnel.php?inscrit=valider");exit;	
			break;
		case 'modif_param' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
			if ( isset($_POST['modif_client']) )
			{
				if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:espace_professionnel.php?contenu=modif_param&erreur=validation");exit;}
				else
				{
					$req=$my->req('SELECT * FROM ttre_client_pro WHERE email="'.$_POST['mail'].'" AND id!='.$_SESSION['id_client_trn_pro'].' ');
					if ( $my->num($req)>0 ) {header("location:espace_professionnel.php?contenu=modif_param&erreur=mail");exit;}
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
									nom					=	"'.$my->net_input($_POST['nom']).'" , 
									prenom				=	"'.$my->net_input($_POST['prenom']).'" , 
									telephone			=	"'.$my->net_input($_POST['telephone']).'" ,
									fax					=	"'.$my->net_input($_POST['fax']).'" , 
									email				=   "'.$my->net_input($_POST['mail']).'"  ,
									fichier1			=	"'.$my->net_input($fich1).'" , 
									fichier2			=	"'.$my->net_input($fich2).'" , 
									fichier3			=	"'.$my->net_input($fich3).'" , 
									stat_valid			=   "0"  
											WHERE id='.$_SESSION['id_client_trn_pro'].'') ;
						
						if ( isset($_POST['newsletter']) )
						{
							$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_pro WHERE email="'.$_POST['mail'].'" ');
							if ( $my->num($req_news)==0 ) $my->req("INSERT INTO ttre_inscrits_newsletters_pro VALUES('','".$my->net_input($_POST['mail'])."') ");
						}
						else
						{
							$my->req('DELETE FROM ttre_inscrits_newsletters_pro WHERE email="'.$_POST['mail'].'" ');
						}
						
						$my->req('DELETE FROM ttre_client_pro_categories WHERE id_client='.$_SESSION['id_client_trn_pro'].' ');
						foreach ( $_POST['categorie'] as $value ) 
							$my->req("INSERT INTO ttre_client_pro_categories VALUES('','".$_SESSION['id_client_trn_pro']."','".$value."')");
						$my->req('DELETE FROM ttre_client_pro_departements WHERE id_client='.$_SESSION['id_client_trn_pro'].' ');
						foreach ( $_POST['departement'] as $value ) 
							$my->req("INSERT INTO ttre_client_pro_departements VALUES('','".$_SESSION['id_client_trn_pro']."','".$value."')");
							
						unset ($_SESSION['id_client_trn_pro']);
						unset ($_SESSION['panier_trn']);
						header("location:espace_professionnel.php?modif=enattente");exit;	
					}
				}
			}
			break;
		case 'modif_mdp' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
			if ( isset($_POST['modif_mdp']) )
			{
				$can=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id="'.$_SESSION['id_client_trn_pro'].'"');
				if ( $can['mdp']!=md5($_POST['pass']) ){header("location:espace_professionnel.php?contenu=modif_mdp&erreur=mdp");exit;}
				else
				{
					$my->req('UPDATE ttre_client_pro SET mdp="'.md5($_POST['pass1']).'" WHERE id='.$_SESSION['id_client_trn_pro'].'') ;
					header("location:espace_professionnel.php?modif_mdp=ok");exit;
				}				
			}
			break;
		case 'devis_encours' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
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
								$sujet = $nom_client.' : Prix modifié pour devis de référence "'.$dd['reference'].'"';
								$headers = "From: \" ".$nom." \"<".$mail.">\n";
								$headers .= "Reply-To: ".$mail_client."\n";
								$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
								mail($mail,$sujet,$message,$headers);
							}
							header("location:espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=ok");exit;
						}
						else
						{
							header("location:espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=nok");exit;
						}
					}
					else
					{
						$my->req('UPDATE ttre_devis_client_pro SET prix_enchere="'.$_POST['prix'].'" , date_enchere='.time().' WHERE id_devis='.$_GET['idDevis'].' AND id_client_pro='.$_SESSION['id_client_trn_pro'].'') ;
						header("location:espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=ok");exit;
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
					$sujet = $nom_client.' : Proposotion validé pour devis de référence "'.$dd['reference'].'"';
					$headers = "From: \" ".$nom." \"<".$mail.">\n";
					$headers .= "Reply-To: ".$mail_client."\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
					mail($mail,$sujet,$message,$headers);
					header("location:espace_professionnel.php?contenu=devis_att_paye&idDevis=".$_GET['idDevis']."&enchere=ok");exit;
					exit;
				}
				else
				{
					header("location:espace_professionnel.php?contenu=devis_encours&idDevis=".$_GET['idDevis']."&modif_prix=nok");exit;
				}
			}
			break;
		case 'devis_att_paye' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
			break;
		case 'devis_histo' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
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
				header("location:espace_professionnel.php?contenu=devis_histo&idDevis=".$_GET['idDevis']."&envoyer=ok");exit;
			}
			break;
		case 'devisa_att_paye' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
			break;
		case 'devisa_histo' :
			if ( !isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
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
				$sujet = $nom_client.' : Nouveau message du devis avec achat immédiat "'.$dd['reference'].'"';
				$headers = "From: \" ".$nom." \"<".$mail.">\n";
				$headers .= "Reply-To: ".$mail_client."\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($mail,$sujet,$message,$headers);
				header("location:espace_professionnel.php?contenu=devisa_histo&idDevis=".$_GET['idDevis']."&envoyer=ok");exit;
			}
			break;
		case 'mdp_perdu' :
			if ( isset($_SESSION['id_client_trn_pro']) ) {header("location:espace_professionnel.php");exit;}
			if ( isset($_POST['mdp_perdu']) )
			{
				$rec=$my->req('SELECT * FROM ttre_client_pro WHERE email = "'.$_POST['mail'].'" ');
				if ( $my->num($rec)==0 ){header("location:espace_professionnel.php?contenu=mdp_perdu&erreur=mail");exit;}
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
								<p>Voici un mail automatique qui vous a été envoyé, suite à votre demande de modification de mots de passe. Vous trouverez dans cet e-mail votre nouveau mots de passe qui sera effectif à partir du moment où vous l\'aurez validé.</p>
								<div id="contenu-corps" style="background-color:#E6E6E6; text-align:center; font-size:14px; padding:10px;">
								
									<p>
										Nouveau mot de passe : '.$pass.'
									<br />
										Si vous avez demandé cette modification, veuillez cliquer sur le lien pour valider votre nouveau mots de passe : <br /> <a href="'.$url_site_client.'/espace_professionnel.php?contenu=mdp_perdu&ref='.$referencePass.'">Changement de mots de passe</a>.
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
					header("location:espace_professionnel.php?contenu=mdp_perdu&mdpperdu=ok");exit;
				}
			}
			elseif ( isset($_GET['ref']) )
			{
				$ligne=$my->req('SELECT * FROM ttre_client_pro_generation_pass WHERE cgp_reference="'.$_GET['ref'].'"');
				if ( $my->num($ligne)==0 ) {header("location:espace_professionnel.php?contenu=mdp_perdu&erreur=mdp");exit;}
				else
				{
					$forget=$my->arr($ligne);
					$req_modif = $my->req ( 'UPDATE ttre_client_pro SET mdp="'.$my->net_input($forget['cgp_mdp']).'" WHERE id = "'.$forget['cgp_client_id'].'"' );
					header("location:espace_professionnel.php?valid_mdp=ok");exit;
				}				
			}
			break;	
		case 'deconnexion' :
			unset ($_SESSION['id_client_trn_pro']);
			unset ($_SESSION['panier_trn']);
			header("location:espace_professionnel.php");exit;
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
						      <span class="courant">Détail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Devis en cours</span>';
			break;
		case 'devis_att_paye' :
			if ( !isset($_GET['etape']) && isset($_GET['idDevis']) ) 
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_att_paye">Devis en attende de payement</a></span> >
						      <span class="courant">Détail</span>';
			elseif ( isset($_GET['etape']) && $_GET['etape']=='paiement' )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_att_paye">Devis en attende de payement</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'">Détail</a></span> >
						      <span class="courant">Paiement</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Devis en attende de payement</span>';
			break;
		case 'devis_histo' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devis_histo">Historique</a></span> >
						      <span class="courant">Détail</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Historique</span>';
			break;
		case 'devisa_att_paye' :
			if ( !isset($_GET['etape']) && isset($_GET['idDevis']) ) 
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_att_paye">Devis avec achat immédiat en attende de payement</a></span> >
						      <span class="courant">Détail</span>';
			elseif ( isset($_GET['etape']) && $_GET['etape']=='paiement' )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_att_paye">Devis avec achat immédiat en attende de payement</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'">Détail</a></span> >
						      <span class="courant">Paiement</span>';
			else
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> > <span class="courant">Devis avec achat immédiat en attende de payement</span>';
			break;
		case 'devisa_histo' :
			if ( isset($_GET['idDevis']) )
				$varAriane = '<span class="home"><a href="espace_professionnel.php">Mon compte</a></span> >
							  <span><a href="espace_professionnel.php?contenu=devisa_histo">Historique</a></span> >
						      <span class="courant">Détail</span>';
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



 include('inc/head.php');?>
	<body id="page1">

<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
<div class="wrapper">
					<div class="header-page-pro">
						<div class="container">
							<div class="row">
							<div class="col-md-12">
								<h2>Espace Professionnel</h2>
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
									<div class="bttn-devis">
										<ul>
											<li><a href="devis.php"><i>Créer votre devis</i></a></li>
											<li><a href="prix-travaux.php"><i>Devis Immédiat</i></a></li>
										</ul>
									</div>
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
		if( !$.trim(this.numvoie_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Numéro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( !$.trim(this.ville.value) ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
		if( !$.trim(this.nom_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom_nouveau.value) ) { mes_erreur+='<p>Il faut entrer le champ Prénom !</p>'; }
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
		if( !$.trim(this.numvoie.value) ) { mes_erreur+='<p>Il faut entrer le champ Numéro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( !$.trim(this.ville.value) ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
		if( !$.trim(this.nom.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom.value) ) { mes_erreur+='<p>Il faut entrer le champ Prénom !</p>'; }
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
	$('form[name="message_envoie"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.message.value) ) { mes_erreur+='<p>Il faut entrer le champ Message !</p>'; }
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
		'width'				: '50%',
		'height'			: '70%',
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
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est déjà associé à un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erroné.</p></div><br />';
						
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
							<label for="ip_voi">Numéro et voie : <span class="obli">*</span></label>
							<input id="ip_voi" type="text" name="numvoie_nouveau"/>
						</p>
						<p>
							<label for="ip_ca">Complèment d\'adresse : </label>
							<input id="ip_ca" type="text" name="cadresse_nouveau"/>
						</p>
						<p>
							<label for="ip_cp">Code postal : <span class="obli">*</span></label>
							<input id="ip_cp" type="text" name="cp" onKeyPress="return scanTouche(event)"/>
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
							<label for="ip_see">Numéro de SIREEN : </label>
							<input id="ip_see" type="text" name="numsireen_nouveau"/>
						</p>
						<p>
							<label for="ip_civ">Civilité : <span class="obli">*</span></label>
							<input id="ip_civ" type="radio" value="Mr" name="civ_nouveau" checked="checked" /> Mr 
							<input id="ip_civ" type="radio" value="Mme" name="civ_nouveau"/> Mme 
							<input id="ip_civ" type="radio" value="Mlle" name="civ_nouveau"/> Mlle 
						</p>
						<p>
							<label for="ip_nom">Nom : <span class="obli">*</span></label>
							<input id="ip_nom" type="text" name="nom_nouveau"/>
						</p>
						<p>
							<label for="ip_prenom">Prénom : <span class="obli">*</span></label>
							<input id="ip_prenom" type="text" name="prenom_nouveau"/>
						</p>
						<p>
							<label for="ip_tel">Téléphone : <span class="obli">*</span></label>
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
							<label for="ip_fi1">Téléchargement de justificatifs K bis : </label>
							<input id="ip_fi1" type="file" style="width:200px;" name="fich1_nouveau" />
						</p>
						<p>
							<label for="ip_fi2">Téléchargement d\'assurance décennal : </label>
							<input id="ip_fi2" type="file" style="width:200px;" name="fich2_nouveau" />
						</p>
						<p>
							<label for="ip_fi3">Autre documents : </label>
							<input id="ip_fi3" type="file" style="width:200px;" name="fich3_nouveau" />
						</p>
						<p>
							<label for="ip_act" style="height:55px;margin:40px 0 0 0;" >Votre activité a cochez : <span class="obli">*</span></label>
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
					</form>	
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>
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
			
			$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_pro WHERE email="'.$cl['email'].'" ');
			if ( $my->num($req_news)==0 ) $news_check=''; else $news_check='checked="checked"';
			
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Erreur d\'inscription ou l\'adresse mail que vous venez de saisir est déjà associé à un compte.</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='validation' ) $alert='<div id="note" class="error"><p>Le code de validation est erroné.</p></div><br />';
						
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
						
							<label for="ip_voi">Numéro et voie : <span class="obli">*</span></label><br />
							<input id="ip_voi" type="text" name="numvoie" value="'.$cl['num_voie'].'"/><br/>
						
						
							<label for="ip_ca">Complèment d\'adresse : </label><br/>
							<input id="ip_ca" type="text" name="cadresse" value="'.$cl['cadresse'].'"/><br/>
						
						
							<label for="ip_cp">Code postal : <span class="obli">*</span></label><br/>
							<input id="ip_cp" type="text" name="cp" onKeyPress="return scanTouche(event)" value="'.$cl['code_postal'].'"/><br/>
						
							<label for="ip_ville">Ville : <span class="obli">*</span></label><br/>
							<select id="ip_ville" name="ville"/>'.$optionville.'</select><br/>
						
							<label for="ip_pays">Pays : <span class="obli">*</span></label><br/>
							<input id="ip_pays" type="text" name="pays" value="France" readonly="readonly" value="'.$cl['pays'].'" />
						</p>
						<p>
							<label for="ip_see">Numéro de SIREEN : </label>
							<input id="ip_see" type="text" name="numsireen" value="'.$cl['num_sireen'].'"/>
						</p>
						<p>
							<label for="ip_civ">Civilité : <span class="obli">*</span></label>
							<input id="ip_civ" type="radio" value="Mr" name="civ" '.$civ1.' /> Mr 
							<input id="ip_civ" type="radio" value="Mme" name="civ" '.$civ2.' /> Mme 
							<input id="ip_civ" type="radio" value="Mlle" name="civ" '.$civ3.' /> Mlle 
						</p>
						<p>
							<label for="ip_nom">Nom : <span class="obli">*</span></label>
							<input id="ip_nom" type="text" name="nom" value="'.$cl['nom'].'"/>
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
							<label for="ip_fi1">Téléchargement de justificatifs K bis : </label>
							'.$fichier1.'<input id="ip_fi1" type="file" style="width:200px;" name="fich1" />
						</p>
						<p>
							<label for="ip_fi2">Téléchargement d\'assurance décennal : </label>
							'.$fichier2.'<input id="ip_fi2" type="file" style="width:200px;" name="fich2" />
						</p>
						<p>
							<label for="ip_fi3">Autre documents : </label>
							'.$fichier3.'<input id="ip_fi3" type="file" style="width:200px;" name="fich3" />
						</p>
						<p>
							<label for="ip_act" style="height:55px;margin:40px 0 0 0;" >Votre activité a cochez : <span class="obli">*</span></label>
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
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>
				</div>
				';		
				break;
		case 'modif_mdp' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) )$alert='<div id="note" class="error"><p>Votre ancien mot de passe est incorrecte, merci de ré-essayer.</p></div><br />';
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
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>
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
								<tr style="background:#FFFF66;">
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
								<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' €</td>
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
					</table></div>';
				$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND prix_enchere>0 ORDER BY prix_enchere DESC');
				if ( $temp )
				{
					if ( $temp['id_client_pro']==$_SESSION['id_client_trn_pro'] )
						$texte='<p>Pour l\'instant vous etes le meilleure enchereur</p>
								<p>Dernier prix proposé : '.$temp['prix_enchere'].' € à la date '.date('d/m/Y',$temp['date_enchere']).' </p>';
					else
						$texte='<p>Il ya quelqu\'un qui a encheri sur vous</p>
								<p>Dernier prix proposé : '.$temp['prix_enchere'].' € à la date '.date('d/m/Y',$temp['date_enchere']).' </p>';
				}
				else
				{
					$texte='<p>Aucun client a donner une proposotion à ce moment</p>';
				}
				$alert='<div id="note"></div><br />';
				if ( isset($_GET['modif_prix']) && $_GET['modif_prix']=='nok')$alert='<div id="note" class="error"><p>Erreur prix.</p></div><br />';
				if ( isset($_GET['modif_prix']) && $_GET['modif_prix']=='ok')$alert='<div id="note" class="success"><p>Prix modifié.</p></div><br />';
					
				$reso = $my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevis'].' ');
				$total=$reso['total_net']+$reso['total_tva']+$reso['frais_port'];
				$prix_min=ceil($total*5/100);$prix_max=ceil($total*15/100);
				
				$detail.='
					<a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aperçu avant imprimer</a>
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
				
					<p class="margin_top_20 col-md-12"><a href="espace_professionnel.php?contenu=devis_encours">Retour à la page précédente</a></p>
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
									<td>Référence</td>							
									<td>Date</td>
									<td class="montant">Montant</td>								
									<td class="width_60">Détails</td>								
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
									<td><strong>'.number_format($total, 2,'.','').' €</strong></td>
									<td><a href="espace_professionnel.php?contenu=devis_encours&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								</tr>
								';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>';
				}
				else
				{
					$liste.='<p>Aucune devis à cet instant.</p>';
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
									<tr style="background:#FFFF66;">
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
									<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' €</td>
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
						</table><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aperçu avant imprimer</a>	';
					
					
					$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
					$detail.='<p>Prix proposé : '.$temp['prix_enchere'].' €  </p>';
						
					$detail.='
						<p id="panier_boutons"><input type="button" value="Payer" onclick="javascript:window.location=\'espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement\'" /></p>
						<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devis_att_paye">Retour à la page précédente</a></p>
							';
					if ( isset($_GET['enchere']) )$alert='<div id="note" class="success"><p>Vous avez gagné l\'enchere.</p></div><br />';
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
						$module_Test='';
						$module_Test='<p style="text-align: center;">Notre solution de paiement en ligne est en cours d\'intégration,<br /> merci de revenir plus tard.';
						if ( $_SESSION['id_client_trn_pro']==1 || $_SESSION['id_client_trn_pro']==6 || $_SESSION['id_client_trn_pro']==5 )
						{
							$module_Test='
							<p class="payment_module">
								<a title="Test" href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=test">
									<img width="86" height="49" alt="Test" src="stockage_img/test.jpg">
									Test
								</a>
							</p>
							';
						}
						echo'
							<div id="HOOK_PAYMENT" style="width: 530px; margin: 0px 0px 0px 50px;">
								'.$module_Test.'
							</div>
							<div id="espace_compte">
								<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$_GET['idDevis'].'">Retour à la page précédente</a></p>
							</div>
							';
					}
					else
					{
						if ( $_GET['module']=='test' )
						{
							$info.='
								<a href="espace_professionnel.php?contenu=devis_att_paye&idDevisPaye='.$_GET['idDevis'].'">Paiement effectué</a> |
								<a href="espace_professionnel.php?contenu=devis_att_paye&paiement=annuler">Paiement annulé</a></p>
								';
							echo'
								<div id="espace_compte">
									'.$info.'
								</div>
								';
						}
					}
				}
			}
			else
			{
				if ( isset($_GET['paiement']) && $_GET['paiement']=='effectuer' ) $alert='<div class="success"><p>Le paiement a été effectué avec succès.</p></div>';
				if ( isset($_GET['paiement']) && $_GET['paiement']=='annuler' ) $alert='<div class="notes"><p>Le paiement a été annulé.</p></div>';
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_devis_client_pro dc , ttre_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=2 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_enchere=1 ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Référence</td>							
									<td>Date</td>
									<td>Montant</td>								
									<td class="width_60">Détails</td>								
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
									<td><strong>'.number_format($total, 2,'.','').' €</strong></td>
									<td><a href="espace_professionnel.php?contenu=devis_att_paye&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								</tr>
								';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>';
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
								<dd>Numéro et voie : '.html_entity_decode($res['num_voie']).'</dd>
								<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($res['num_appart']).'</dd>
								<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($res['batiment']).'</dd>
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
								<tr style="background:#faca2e;">
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
								<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' €</td>
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
					</table>
					</div>
					<a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'&suite=ok">Aperçu avant imprimer</a>';
				
				$temp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$_GET['idDevis'].' AND statut_enchere=1 ');
				$detail.='<p>Prix proposé : '.number_format($temp['prix_enchere'],2).' €  </p><br /><br />';
					
				
				// ------------------------- Partie dialogue -----------------------------
				
				$alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" ></div>';
				if ( isset($_GET['envoyer']) ) $alert='<div id="note" style="margin: 10px 0 0 120px;width:400px;" class="success" ><p>Votre message a bien été envoyé.</p></div>';
				
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
							</div>
						</div>
					</div>
					';
				
				
				// -----------------------------------------------------------------------
				
				
				$detail.='
					<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devis_histo">Retour à la page précédente</a></p>
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
									<td>Référence</td>							
									<td>Date</td>
									<td>Type</td>
									<td>Montant</td>								
									<td class="width_60">Détails</td>								
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
									<td><strong>'.number_format($total, 2,'.','').' €</strong></td>
									<td><a href="espace_professionnel.php?contenu=devis_histo&idDevis='.$res['id_devis'].'" title="Detailles"><img src="stockage_img/zoom_in.png" alt="Detailles"/></a></td>
								</tr>
								';
					}
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>';
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
					
					$detail.='
						<p id="panier_boutons"><input type="button" value="Payer" onclick="javascript:window.location=\'espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement\'" /></p>
						<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devisa_att_paye">Retour à la page précédente</a></p>
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
						$module_Test='';
						$module_Test='<p style="text-align: center;">Notre solution de paiement en ligne est en cours d\'intégration,<br /> merci de revenir plus tard.';
						if ( $_SESSION['id_client_trn_pro']==1 || $_SESSION['id_client_trn_pro']==6 || $_SESSION['id_client_trn_pro']==5 )
						{
							$module_Test='
							<p class="payment_module">
								<a title="Test" href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'&etape=paiement&module=test">
									<img width="86" height="49" alt="Test" src="stockage_img/test.jpg">
									Test
								</a>
							</p>
							';
						}
						echo'
							<div id="HOOK_PAYMENT" style="width: 530px; margin: 0px 0px 0px 50px;">
								'.$module_Test.'
							</div>
							<div id="espace_compte">
								<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devisa_att_paye&idDevis='.$_GET['idDevis'].'">Retour à la page précédente</a></p>
							</div>
							';
					}
					else
					{
						if ( $_GET['module']=='test' )
						{
							$info.='
								<a href="espace_professionnel.php?contenu=devisa_att_paye&idDevisaPaye='.$_GET['idDevis'].'">Paiement effectué</a> |
								<a href="espace_professionnel.php?contenu=devisa_att_paye&paiement=annuler">Paiement annulé</a></p>
								';
							echo'
								<div id="espace_compte">
									'.$info.'
								</div>
								';
						}
					}
				}
			}
			else
			{
				if ( isset($_GET['paiement']) && $_GET['paiement']=='effectuer' ) $alert='<div class="success"><p>Le paiement a été effectué avec succès.</p></div>';
				if ( isset($_GET['paiement']) && $_GET['paiement']=='annuler' ) $alert='<div class="notes"><p>Le paiement a été annulé.</p></div>';
				$liste='';
				$req = $my->req('SELECT DISTINCT(dc.id_devis) FROM ttre_achat_devis_client_pro dc , ttre_achat_devis d WHERE dc.id_devis=d.id AND d.statut_valid_admin=1 AND dc.id_client_pro='.$_SESSION['id_client_trn_pro'].' AND dc.statut_achat=0 ORDER BY d.date_ajout DESC');
				if ( $my->num($req)>0 )
				{
					$liste.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Référence</td>							
									<td>Date</td>
									<td class="width_60">Détails</td>								
								</tr>
						';
					while ( $res=$my->arr($req) )
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
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>';
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
								<dd>Numéro et voie : '.html_entity_decode($res['num_voie']).'</dd>
								<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($res['num_appart']).'</dd>
								<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($res['batiment']).'</dd>
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
				$detail.='</table></div><a id="various3" href="imp_cheque.php?idDevis='.$_GET['idDevis'].'">Aperçu avant imprimer</a>';
				
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
							</div>
						</div>
					</div>
					';
				
				
				// -----------------------------------------------------------------------
				
				
				$detail.='
					<p class="margin_top_20"><a href="espace_professionnel.php?contenu=devisa_histo">Retour à la page précédente</a></p>
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
									<td>Référence</td>							
									<td>Date</td>
									<td>Type</td>
									<td class="width_60">Détails</td>								
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
					$liste.='</table><p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>';
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
		case 'mdp_perdu' :
			$alert='<div id="note"></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mail' ) $alert='<div id="note" class="error"><p>Cette adresse email n\'existe pas dans notre base !</p></div><br />';
			if ( isset($_GET['erreur']) && $_GET['erreur']=='mdp' ) $alert='<div id="note" class="error"><p>Changement Annulé.</p></div><br />';
			if ( isset($_GET['mdpperdu']) ) $alert='<div id="note" class="success"><p>Un nouveau mot de passe vous a été envoyé, vous devez maintenant le valider pour pouvoir vous connecter sur notre site.</p></div><br />';
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
					<p class="margin_top_20"><a href="espace_professionnel.php">Retour à la page précédente</a></p>
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
		if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='valider') ) $alert='<div id="note" class="success"><p>Votre compte a bien été validé.</p></div><br />';
		if ( isset($_GET['modif']) && ($_GET['modif']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		if ( isset($_GET['valid_mdp']) ) $alert='<div id="note" class="notice"><p>Votre mot de passe a bien été modifié, vous pouvez dès maintenant vous connecter.</p></div><br />';
		echo'
			'.$alert.'
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="Login-pro">
						<div class="title-sign-pro">Vous avez déjà un compte ?</div>
						<form action="espace_professionnel.php?contenu=connexion" name="client_conn" method="post" >
							<div class="form-login-pro">
								<input id="mail" type="text" name="email_connexion" placeholder="Votre adresse mail"/><br />
								<input id="mdp" type="password" name="mdp_connexion" placeholder="Votre mot de passe"/><br />
								<input class="boutons_persos_1" value="Connexion" type="submit" name="conn_client"/><br />
								<p>Si vous avez oublié votre mot de passe, <a href="espace_professionnel.php?contenu=mdp_perdu" style="color:#000">cliquez ici</a>.</p>	
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-6">
					<div class="Logup-pro">
						<div class="title-sign-pro">Vous êtes nouveau client ?</div>
						<div class="log-pro">
							<p>Vous devez créer un compte pour pouvoir gérer vos devis.</p>
							<p class="padding_top_5">Nous nous engageons à sécuriser vos informations et à les garder strictement confidentielles.</p>
							<a href="espace_professionnel.php?contenu=inscription"">Créer un compte</a>
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
		$alert='<div id="note"></div><br />';
		if ( isset($_GET['modif_mdp']) ) $alert='<div id="note" class="notice" ><p>Votre mot de passe a bien été modifié.</p></div><br />';
		echo'
			'.$alert.'
			<div id="espace_compte">
				<p class="padding_bottom_20">Bienvenue dans votre espace personnel, vous pouver depuis cette page gérer toutes vos informations personnelles ainsi que vos devis.</p>												
				<ul id="tableau_bord">
					<li id="compte_infos">
						<dl>
							<dt>Informations personnelles</dt>
							<dd class="description">C\'est dans cette section que vous pourrez accéder à vos informations personnelles et les modifier.</dd>
							<dd class="lien"><a href="espace_professionnel.php?contenu=modif_param">Modifier mes informations</a></dd>
						</dl>
					</li>
					<li id="compte_mdp" class="droite">
						<dl>
							<dt>Mot de passe</dt>
							<dd class="description">Pour des questions de sécurité, il est conseillé de modifier son mot de passe fréquemment.</dd>
							<dd class="lien"><a href="espace_professionnel.php?contenu=modif_mdp">Modifier mon mot de passe</a></dd>
						</dl>
					</li>
					<li id="compte_adresses">
						<dl>
							<dt>Devis en cours d\'enchére</dt>
							<dd class="description">C\'est dans cette section que vous pourrez consulter le détail de vos devis en cours d\'enchére et dans votre zone d\'intervention.</dd>
							<dd class="lien"><a href="espace_professionnel.php?contenu=devis_encours">Devis en cours ( '.$my->num($req_dev_cour).' )</a></dd>
						</dl>
					</li>
					<li id="compte_adresses" class="droite">
						<dl>
							<dt>Devis en attende de payement</dt>
							<dd class="description">C\'est dans cette section que vous pourrez consulter le détail de vos devis en attende de payement.</dd>
							<dd class="lien"><a href="espace_professionnel.php?contenu=devis_att_paye">Devis en attende de payement ( '.$my->num($req_att_pay).' )</a></dd>
						</dl>
					</li>
					<li id="compte_adresses">
						<dl>
							<dt>Historique de devis</dt>
							<dd class="description">C\'est dans cette section que vous pourrez consulter l\'historique de vos devis .</dd>
							<dd class="lien"><a href="espace_professionnel.php?contenu=devis_histo">historique</a></dd>
						</dl>
					</li>
					<li id="compte_adresses" class="droite">
						<dl>
							<dt>Devis avec achat immédiat en attende de pay.</dt>
							<dd class="description">C\'est dans cette section que vous pourrez consulter le détail de vos devis  avec achat immédiat en attende de payement.</dd>
							<dd class="lien"><a href="espace_professionnel.php?contenu=devisa_att_paye">Devis en attende de payement ( '.$my->num($req_att_pays).' )</a></dd>
						</dl>
					</li>
					<li id="compte_adresses">
						<dl>
							<dt>Historique de devis avec achat immédiat</dt>
							<dd class="description">C\'est dans cette section que vous pourrez consulter l\'historique de vos devis  avec achat immédiat.</dd>
							<dd class="lien"><a href="espace_professionnel.php?contenu=devisa_histo">historique</a></dd>
						</dl>
					</li>
				</ul>
				<p><a href="espace_professionnel.php?contenu=deconnexion"> » Se déconnecter</a></p>		
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