<?php
require('inc/session.php');

if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'panier' :
			switch ( $_GET['action'] )
			{
				case 'ajouter' : 
					if( !isset($_SESSION['panier_trn']) )
					{
						$_SESSION['panier_trn'] 			= array();
						$_SESSION['panier_trn']['id'] 		= array();
						$_SESSION['panier_trn']['piece'] 	= array();
						$_SESSION['panier_trn']['or_cat'] 	= array();
						$_SESSION['panier_trn']['id_prod'] 	= array();
						$_SESSION['panier_trn']['qte'] 		= array();
						$_SESSION['panier_trn']['type'] 	= array();
						$_SESSION['panier_trn']['unite'] 	= array();
						$_SESSION['panier_trn']['prix'] 	= array();
					}
					$indice = count($_SESSION['panier_trn']['id']) + 1;
					$prod=$_POST['id_prix'];$qua=$_POST['qte'];$rf=$_POST['type_rf'];
					$unite=$_POST['unite'];$piece=$_POST['piece'];$or_cat=$_POST['or_cat'];
					
					$produit=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$prod.''); 
					$prix=$produit['prix']; 
					
					$incrementer = -1;
					
					if ( count($_SESSION['panier_trn']['id_prod'])>0 && array_search($prod,$_SESSION['panier_trn']['id_prod'])!==false )
					{
						$i = 0;
						while ( $i<count($_SESSION['panier_trn']['id']) && $incrementer == -1 )
						{
							if ( $_SESSION['panier_trn']['id_prod'][$i]==$prod ) $incrementer = $i;
							$i++;
						}
					}
					if ( $incrementer != -1 )
					{ 
						$_SESSION['panier_trn']['qte'][$incrementer]=$_SESSION['panier_trn']['qte'][$incrementer]+$qua;
					}	
					else
					{
						$cpt=0;
						for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )
						{
							if ( $i==0 && $or_cat<$_SESSION['panier_trn']['or_cat'][$i] )
							{
								// ajout au debut
								$cpt=0;break;
							}
							elseif ( $i==(count($_SESSION['panier_trn']['id'])-1) && $or_cat>=$_SESSION['panier_trn']['or_cat'][$i] )
							{
								// ajout au fin
								$cpt=count($_SESSION['panier_trn']['id']);
							}
							elseif ( $_SESSION['panier_trn']['or_cat'][$i]<=$or_cat && $or_cat<$_SESSION['panier_trn']['or_cat'][$i+1] )
							{
								// ajout au milieu
								$cpt=$i+1;break;
							}
						}
						if ( count($_SESSION['panier_trn']['id'])>0 )
						{
							$_SESSION['panier_tmp'] 			= array();
							$_SESSION['panier_tmp']['id'] 		= array();
							$_SESSION['panier_tmp']['piece'] 	= array();
							$_SESSION['panier_tmp']['or_cat'] 	= array();
							$_SESSION['panier_tmp']['id_prod'] 	= array();
							$_SESSION['panier_tmp']['qte'] 		= array();
							$_SESSION['panier_tmp']['type'] 	= array();
							$_SESSION['panier_tmp']['unite'] 	= array();
							$_SESSION['panier_tmp']['prix'] 	= array();
							$indice = 1;
							$nb_articles = count($_SESSION['panier_trn']['id']);$j=0;
							for ( $x=0;$x<=$nb_articles;$x++ )
							{
								# transférer tous les items dans le panier temp sauf ceux à supprimer
								if ( $j==0 && $x==$cpt )
								{
									$_SESSION['panier_tmp']['id'][]=$indice;
									$_SESSION['panier_tmp']['piece'][]=$piece;
									$_SESSION['panier_tmp']['or_cat'][]=$or_cat;
									$_SESSION['panier_tmp']['id_prod'][]=$prod;
									$_SESSION['panier_tmp']['qte'][]=$qua; 
									$_SESSION['panier_tmp']['type'][]=$rf; 
									$_SESSION['panier_tmp']['unite'][]=$unite; 
									$_SESSION['panier_tmp']['prix'][]=$prix; 
									$x=$x-1;$j=1;$indice ++;$nb_articles --;
								}
								else
								{
									array_push($_SESSION['panier_tmp']['id'],$indice);
									array_push($_SESSION['panier_tmp']['piece'],$_SESSION['panier_trn']['piece'][$x]);
									array_push($_SESSION['panier_tmp']['or_cat'],$_SESSION['panier_trn']['or_cat'][$x]);
									array_push($_SESSION['panier_tmp']['id_prod'],$_SESSION['panier_trn']['id_prod'][$x]);
									array_push($_SESSION['panier_tmp']['qte'],$_SESSION['panier_trn']['qte'][$x]); 
									array_push($_SESSION['panier_tmp']['type'],$_SESSION['panier_trn']['type'][$x]); 
									array_push($_SESSION['panier_tmp']['unite'],$_SESSION['panier_trn']['unite'][$x]); 
									array_push($_SESSION['panier_tmp']['prix'],$_SESSION['panier_trn']['prix'][$x]);
									$indice ++;
								}
							}
							$_SESSION['panier_trn'] = $_SESSION['panier_tmp'];
							unset($_SESSION['panier_tmp']);
						}
						else
						{
							$_SESSION['panier_trn']['id'][]=$indice;
							$_SESSION['panier_trn']['piece'][]=$piece;
							$_SESSION['panier_trn']['or_cat'][]=$or_cat;
							$_SESSION['panier_trn']['id_prod'][]=$prod;
							$_SESSION['panier_trn']['qte'][]=$qua; 
							$_SESSION['panier_trn']['type'][]=$rf; 
							$_SESSION['panier_trn']['unite'][]=$unite; 
							$_SESSION['panier_trn']['prix'][]=$prix; 
						}
					}				
					echo '<script>window.location="prix-travaux.php"</script>';
					break;
				case 'modifier' :
					for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )
					{	
						if ( isset($_POST['quantite'.$_SESSION['panier_trn']['id'][$i]]) )
						{
							$_SESSION['panier_trn']['qte'][$i]=$_POST['quantite'.$_SESSION['panier_trn']['id'][$i]];
						}
						if ( isset($_POST['nompiece'.$_SESSION['panier_trn']['id'][$i]]) )
						{
							$_SESSION['panier_trn']['piece'][$i]=$_POST['nompiece'.$_SESSION['panier_trn']['id'][$i]];
						}
					}
					echo '<script>window.location="prix-travaux.php?modifier=ok"</script>';			
					break;
				case 'supprimer' :
					$_SESSION['panier_tmp'] 			= array();
					$_SESSION['panier_tmp']['id'] 		= array();
					$_SESSION['panier_tmp']['piece'] 	= array();
					$_SESSION['panier_tmp']['or_cat'] 	= array();
					$_SESSION['panier_tmp']['id_prod'] 	= array();
					$_SESSION['panier_tmp']['qte'] 		= array();
					$_SESSION['panier_tmp']['type'] 	= array();
					$_SESSION['panier_tmp']['unite'] 	= array();
					$_SESSION['panier_tmp']['prix'] 	= array();
					$indice = 1;
					$nb_articles = count($_SESSION['panier_trn']['id']);
					for ( $x=0;$x<$nb_articles;$x++ )
					{
						# transférer tous les items dans le panier temp sauf ceux à supprimer
						if ( $_SESSION['panier_trn']['id'][$x] != $_GET['id'] )
						{
							array_push($_SESSION['panier_tmp']['id'],$indice);
							array_push($_SESSION['panier_tmp']['piece'],$_SESSION['panier_trn']['piece'][$x]);
							array_push($_SESSION['panier_tmp']['or_cat'],$_SESSION['panier_trn']['or_cat'][$x]);
							array_push($_SESSION['panier_tmp']['id_prod'],$_SESSION['panier_trn']['id_prod'][$x]);
							array_push($_SESSION['panier_tmp']['qte'],$_SESSION['panier_trn']['qte'][$x]); 
							array_push($_SESSION['panier_tmp']['type'],$_SESSION['panier_trn']['type'][$x]); 
							array_push($_SESSION['panier_tmp']['unite'],$_SESSION['panier_trn']['unite'][$x]); 
							array_push($_SESSION['panier_tmp']['prix'],$_SESSION['panier_trn']['prix'][$x]);
							$indice ++;
						}
					}
					$_SESSION['panier_trn'] = $_SESSION['panier_tmp'];
					unset($_SESSION['panier_tmp']);
					if ( $nb_articles == 1 )
					{
						unset($_SESSION['panier_trn']);
						echo '<script>window.location="prix-travaux.php"</script>';						
					}
					else
					{
						echo '<script>window.location="prix-travaux.php?supprimer=ok"</script>';						
					}
					break;
				case 'vider' :
					unset($_SESSION['panier_trn']);
					echo '<script>window.location="prix-travaux.php"</script>';
					break;
			}
			break;
		case 'authentification' :
			if ( !isset($_SESSION['panier_trn']) ) {header("location:prix-travaux.php");exit;}
			if ( isset($_SESSION['id_client_trn_part']) ) {header("location:prix-travaux.php?contenu=adresse");exit;}
			if ( isset($_GET['action']) )
			{
				switch ( $_GET['action'] )
				{
					case 'connexion' :
						if ( isset($_POST['conn_client']) )
						{
							$req=$my->req('SELECT * FROM ttre_client_part WHERE email="'.$_POST['email_connexion'].'" AND mdp="'.md5($_POST['mdp_connexion']).'" AND stat_valid=1 ');
							if ( $my->num($req)==0 )
							{
								header("location:prix-travaux.php?contenu=authentification&inscrit=erreur");exit;
							}
							else
							{
								$cl=$my->arr($req);
								$_SESSION['id_client_trn_part']=$cl['id'];
								header("location:prix-travaux.php?contenu=adresse");exit;
							}
						}
						break;
					case 'inscription' :
						if ( isset($_POST['ajout_client']) )
						{
							if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:prix-travaux.php?contenu=authentification&action=inscription&erreur=validation");exit;}
							else
							{
								$req=$my->req('SELECT * FROM ttre_client_part WHERE email="'.$_POST['mail_nouveau'].'"');
								if ( $my->num($req)>0 ) {header("location:prix-travaux.php?contenu=authentification&action=inscription&erreur=mail");exit;}
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
										$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters WHERE email="'.$_POST['mail_nouveau'].'" ');
										if ( $my->num($req_news)==0 ) $my->req("INSERT INTO ttre_inscrits_newsletters VALUES('','".$my->net_input($_POST['mail_nouveau'])."') ");
									}
									else 
									{
										$my->req('DELETE FROM ttre_inscrits_newsletters WHERE email="'.$_POST['mail_nouveau'].'" ');
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
									header("location:prix-travaux.php?contenu=authentification&inscrit=enattente");exit;			
								}
							}
						}
						break;
				}
			}
			break;
		case 'adresse' :
			if ( !isset($_SESSION['panier_trn']) ) {header("location:prix-travaux.php");exit;}
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:prix-travaux.php?contenu=authentification");exit;}
			
			if ( !isset($_GET['action']) )
			{
				$req=$my->req('SELECT * FROM ttre_client_part_adresses WHERE id_client='.$_SESSION['id_client_trn_part'].' AND statut=1 ');
				if ( $my->num($req)==0 ) {header("location:prix-travaux.php?contenu=adresse&action=ajouter");exit;}
			}

			if ( !isset($_SESSION['adresse_chantier_trn']) ) 
			{ 
				$min = $my->req_arr('SELECT min(id) AS min FROM ttre_client_part_adresses WHERE id_client='.$_SESSION['id_client_trn_part'].' AND statut=1 '); 
				$_SESSION['adresse_chantier_trn']=$min['min']; 
			}
			
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
	
							$_SESSION['adresse_chantier_trn']=mysql_insert_id();				
							header("location:prix-travaux.php?contenu=adresse");exit;
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
							$_SESSION['adresse_chantier_trn']=$_GET['id'];				
							header("location:prix-travaux.php?contenu=adresse");exit;
						}
						break;
					case 'valider' :
						$_SESSION['adresse_chantier_trn']=$_GET['id'];
						header("location:prix-travaux.php?contenu=adresse");exit;
						break;
				}
			}
			break;
		case 'envoyer' :
			if ( !isset($_SESSION['panier_trn']) ) {header("location:prix-travaux.php");exit;}
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:prix-travaux.php?contenu=authentification");exit;}
			if ( !isset($_SESSION['adresse_chantier_trn']) ) {header("location:prix-travaux.php?contenu=adresse");exit;}
			$reference_devis = uniqid('R');
			$my->req("INSERT INTO ttre_devis VALUES('',
												'".$reference_devis."',
												'".time()."',
												'0',
												'".$_SESSION['id_client_trn_part']."',
												'".$_SESSION['adresse_chantier_trn']."',
												'".$_SESSION['total_Net_trn']."',
												'".$_SESSION['total_tva_trn']."',
												'".$_SESSION['frais_Port_trn']."',
												'',
												'0',
												'0'
												)");
			$id_devis = mysqli_insert_id();
			for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )	
			{	
				$or_categ=$_SESSION['panier_trn']['or_cat'][$i];
				$temp=$my->req_arr('SELECT * FROM ttre_categories WHERE ordre='.$or_categ.' ');
				$id_categ=$temp['id'];
				$titre_categ=$temp['titre'];
				$nom_piece=$_SESSION['panier_trn']['piece'][$i];
				$id_prix=$_SESSION['panier_trn']['id_prod'][$i];
				$prod=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$_SESSION['panier_trn']['id_prod'][$i].' ');
				$titre = $prod['designation'];
				$tva = $prod['tva'];
				$prix = $_SESSION['panier_trn']['prix'][$i];
				$qte = $_SESSION['panier_trn']['qte'][$i];
				$ttva=$my->req_arr('SELECT * FROM ttre_tva WHERE id='.$prod['tva'].' ');
				$valeur_tva_prod = $prix * $qte * $ttva['valeur'] / 100 ;
				$unite = $_SESSION['panier_trn']['unite'][$i];
				$my->req("INSERT INTO ttre_devis_details VALUES('',
														'".$id_devis."',
														'".$or_categ."',
														'".$id_categ."',
														'".$my->net($titre_categ)."',
														'".$my->net($nom_piece)."',
														'".$id_prix."',
														'".$my->net($titre)."',
														'".$tva."',
														'".$valeur_tva_prod."',
														'".$prix."',
														'".$qte."',
														'".$my->net($unite)."'
														)");
			}
			$cl=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$_SESSION['id_client_trn_part'].' ');
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
						<p>un nouveau devis a été ajouté sur votre base de données par " '.html_entity_decode($cl['nom']).' '.html_entity_decode($cl['prenom']).' " 
						du montant '.number_format(($_SESSION['total_Net_trn']+$_SESSION['total_tva_trn']+$_SESSION['frais_Port_trn']),2).' €.</p> 
						<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
							<p style="padding-top:10px;">'.$nom_client.'</p>											
						</div>
					</div>
				</body>
				</html>
				';
			//$mail_client='bilelbadri@gmail.com';
			$sujet = $nom_client.' : Nouveau devis';
			$headers = "From: \" ".$nom_client." \"<".$mail_client.">\n";
			$headers .= "Reply-To: ".$cl['email']."\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			mail($mail_client,$sujet,$message,$headers);
			break;
	}
}










include('inc/head.php');?>
	<body id="page1">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
					<div class="wrapper">
						<div class="header-page-part">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
									<h2>Prix des travreaux</h2>
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
							<article id="price">
										<div class="price">



<script type="text/javascript">
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>


<?php 

//--------------------------------- Partie Categegorie ---------------------------
$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
if ( $my->num($reqCat)>0 )
{
	$liCat='';
	while ( $resCat=$my->arr($reqCat) )
	{
		$style=' style="background:#;color:#1e1e1e; border-bottom: 5px solid #1e1e1e; " ';
		if ( isset($_GET['cat']) && $_GET['cat']==$resCat['id'] )$style=' style="background:#; border-bottom: 5px solid #0495CB"; ';
		if ( !empty($resCat['photo']) ) $logo='<img src="upload/logosCateg/50X30/'.$resCat['photo'].'" />'; else $logo='';
		$liCat.='<li '.$style.'"><a href="prix-travaux.php?cat='.$resCat['id'].'">'.$logo.' <br /> '.$resCat['titre'].'</a></li>';
	}
	echo'<div class="container"><div class="row"><div class="col-md-12">';
	echo '<div class="col-md-12"><ul id="menu_cat" style="height:55px;">'.$liCat.'</ul>';
	echo '</div></div></div>';
}
//--------------------------------- Partie Sous Categegorie ---------------------------
if ( isset($_GET['cat']) )
{

	$reqSCat=$my->req('SELECT * FROM ttre_categories WHERE parent='.$_GET['cat'].' ORDER BY ordre ASC');

	if ( $my->num($reqSCat)>0 )
	{
		$liSCat='';
		while ( $resSCat=$my->arr($reqSCat) )
		{
			$style=' style="background:#0495CB;color:#fff;" ';
			if ( isset($_GET['scat']) && $_GET['scat']==$resSCat['id'] )$style=' style="background:#0495CB; border-bottom: none;" ';
			if ( !empty($resSCat['photo']) ) $logo='<img src="upload/logosSousCateg/50X30/'.$resSCat['photo'].'" />'; else $logo='';
			$liSCat.='<li '.$style.'"><a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$resSCat['id'].'">'.$logo.' <br /> '.$resSCat['titre'].'</a></li>';
		}
		echo'<div class="container"><div class="row"><div class="col-md-12">';
		echo '<ul id="menu_cat" style="height:55px;">'.$liSCat.'</ul><div style="clear:both;"></div>';
		echo '</div></div></div>';
	}
}
//--------------------------------- Partie Partie & Partie Question ---------------------------
if ( isset($_GET['scat']) )
{

	$reqPart=$my->req('SELECT * FROM ttre_categories WHERE parent='.$_GET['scat'].' ORDER BY ordre ASC');
	$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_GET['scat'].' ORDER BY ordre ASC');
	if ( $my->num($reqPart)>0 )
	
	{
		echo'<div class="container"><div class="row"><div class="col-md-12">';
		echo'<div class="quest">';
		echo'<form method="POST" action="" >';$affich_form=0;
		while ( $resPart=$my->arr($reqPart) )
		{
			if ( isset($_GET['part']) )
			{
				if ( $_GET['part']==$resPart['id'] )
				{	
					echo'<p><strong>'.$resPart['titre'].' : <a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$_GET['scat'].'&part='.$resPart['id'].'">[ - ]</a></strong></p>';
					//----------------------------------- Partie Question ---------------------------
					
					$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_GET['part'].' ORDER BY ordre ASC ');
					if ( $my->num($reqQuest)>0 )
					{
						
						while ( $resQuest=$my->arr($reqQuest) )
						{
							if ( isset($_POST['quest_'.$resQuest['id_question']]) )
							{
								if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanTouche(event)" />';
								elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanFTouche(event)" />';
								else 
								{
									$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
									$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
									while ( $res_option=$my->arr($req_option) ) 
									{
										if ( $res_option['id_option']==$_POST['quest_'.$resQuest['id_question']] ) $sel='selected="selected"'; else $sel='';
										$champ.='<option value="'.$res_option['id_option'].'" '.$sel.'>'.$res_option['optionn'].'</option>';
									}
									$champ.='</select>';
								}
							}
							else
							{
								if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanTouche(event)" />';
								elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanFTouche(event)" />';
								else 
								{
									$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
									$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
									while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['optionn'].'</option>';
									$champ.='</select>';
								}
							}
							$affich_form=1;
							echo'<p>'.$resQuest['label'].' '.$champ.'</p>';
						}
						
					}
				}
				else
				{
					echo'<p><strong>'.$resPart['titre'].' : <a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$_GET['scat'].'&part='.$resPart['id'].'">[ + ]</a></strong></p>';
				}
			}
			else 
			{
				echo'<p><strong>'.$resPart['titre'].' : <a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$_GET['scat'].'&part='.$resPart['id'].'">[ + ]</a></strong></p>';
			}
		}
		if ( $affich_form==1 ) echo'<input type="submit" name="demander_prix" value="Obtenir le prix" /></form>'; else echo'</form>';
	echo '</div>';
	echo '</div></div></div>';
	}
	elseif ( $my->num($reqQuest)>0 )
	{
		//----------------------------------- Partie Question ---------------------------
		if ( $my->num($reqQuest)>0 )
		{
			echo'<div class="container"><div class="row"><div class="col-md-12">';
			echo '<div class="quest">';
			echo '<form method="POST" action="" >';
			while ( $resQuest=$my->arr($reqQuest) )
			{
				if ( isset($_POST['quest_'.$resQuest['id_question']]) )
				{
					if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanTouche(event)" />';
					elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) 
						{
							if ( $res_option['id_option']==$_POST['quest_'.$resQuest['id_question']] ) $sel='selected="selected"'; else $sel='';
							$champ.='<option value="'.$res_option['id_option'].'" '.$sel.'>'.$res_option['optionn'].'</option>';
						}
						$champ.='</select>';
					}
				}
				else
				{
					if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanTouche(event)" />';
					elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['optionn'].'</option>';
						$champ.='</select>';
					}
				}
				echo'<p>'.$resQuest['label'].' '.$champ.'</p>';
			}
			echo'<input type="submit" name="demander_prix" value="Obtenir le prix" /></form>';
			echo '</div>';
			echo '</div></div></div>';
		}
	}
}
//echo'<pre>';print_r($_POST);echo'</pre>';
if ( isset($_POST['demander_prix']) )
{
	if ( isset($_GET['part']) ) $parent=$_GET['part'];
	elseif ( isset($_GET['scat']) ) $parent=$_GET['scat'];
	$i=1;$valid_detail_prix=1;$tabb=array();
	$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$parent.' AND type=3 ORDER BY ordre ASC ');
	while ( $resQuest=$my->arr($reqQuest) )
	{
		$reqDetPrix=$my->req('SELECT * FROM ttre_questions_prix_detail WHERE id_question='.$resQuest['id_question'].' AND valeur='.$_POST['quest_'.$resQuest['id_question']].' ');
		if ( $my->num($reqDetPrix)>0 )
		{
			while ( $resDetPrix=$my->arr($reqDetPrix) ) 
			{ 
				$tab[$i][]=$resDetPrix['id_prix'];
			}
			//echo'<pre>';print_r($tab[$i]);echo'</pre>';
		}
		else
		{
			$valid_detail_prix=0;
		}
		if ( $valid_detail_prix==1 )
		{
			if ( $i==1 )
			{
				$tabb=array_intersect($tab[$i],$tab[$i]);
				//echo'array_intersect 1<pre>';print_r($tabb);echo'</pre>';
			}
			else 
			{
				$tabb=array_intersect($tabb,$tab[$i]);
				//echo'array_intersect<pre>';print_r($tabb);echo'</pre>';
			}
		}
		$i++;
	}
	if ( $valid_detail_prix==1  )
	{
		$resQuest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_categorie='.$parent.' AND type!=3 ORDER BY ordre ASC ');
		if ( $resQuest ) 
		{ 
			$val=$_POST['quest_'.$resQuest['id_question']]; $rf=$resQuest['type'];$unite=$resQuest['unite'];
		}
		else 
		{
			$val=1;$rf='';$unite=$resQuest['unite'];
		}
		if ( count($tabb)>0 )
		{
			foreach ($tabb as $value) { $id=$value; break; }
			$resPrix=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$id.' ');
		}
		else 
		{
			if ( isset($_GET['part']) ) $categ=$_GET['part'];
			elseif ( isset($_GET['scat']) ) $categ=$_GET['scat'];
			$resPrix=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$categ.' ');
			$id=$resPrix['id_prix'];
		}
		echo'<div class="container"><div class="row"><div class="col-md-12">';
		echo'<div class="result">';
		echo'<p class="question1"><strong>Désignation :</strong> '.$resPrix['designation'].'</p>';
		$prixx=$resPrix['prix']*$val;
		echo'<p class="question1"><strong>Prix :</strong> '.number_format($prixx,2).' €</p>';

		if ( $prixx>0 )
		{
			$c=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$_GET['cat'].' ');
			echo'
				<form method="POST" action="?contenu=panier&action=ajouter">
					Nommer : <input type="text" name="piece" value="" />
					<input type="hidden" name="or_cat" value="'.$c['ordre'].'" />
					<input type="hidden" name="id_prix" value="'.$id.'" />
					<input type="hidden" name="qte" value="'.$val.'" />
					<input type="hidden" name="type_rf" value="'.$rf.'" />
					<input type="hidden" name="unite" value="'.$unite.'" />
					<input type="submit" name="ajouter_panier" value="Ajouter au demande de devis" />
				</form>
				';
		}
				echo '</div>';
		echo '</div></div></div>';
	}
	else
	{
		echo'<div class="container"><div class="row"><div class="col-md-12">';
		echo'<p class="worning"><i class="fa fa-warning"></i>Désolé, pour cette combinaison le prix pas encore ajouté.</p>';
		echo'</div></div></div>';
	}
	
}



//------------------------------------------------------------Panier------------------------------------------------------------


//echo'<pre>';print_r($_SESSION);echo'</pre>';
?>
<script type="text/javascript">
$(document).ready(function() {      
      
	$('.panier_qte').blur(function ()
	{
		mes_erreur='';stock=this.id;
		if( parseInt($(this).val())==0 || $(this).val()=="" ) { mes_erreur+='<p>Quantité doit être supérieur à 0.</p>'; }
		if ( mes_erreur ) { $(this).val(this.defaultValue);$("#note").attr('class','error');$("#note").hide().html(mes_erreur).fadeIn("slow");return(false); }
	});	
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
	$('form[name="adresse"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.numvoie.value) ) { mes_erreur+='<p>Il faut entrer le champ Numéro et voie !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( $.trim(this.ville.value)==0 ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
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
<?php 

//if ( md5($_POST["validation"]) != $_SESSION["valeur_image"] )

if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'authentification' :
			if ( isset($_GET['action']) )
			{
				switch ( $_GET['action'] )
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
							<br /><br />
							<div id="espace_compte">
								<div class="conteneur_ariane_cmd">
									<ul id="compte_ariane_cmd">
										<li class="done">1. <a href="prix-travaux.php">Ajouter au devis</a></li>
										<li class="courant">2. <a href="prix-travaux.php?contenu=authentification">S\'identifier</a></li>
										<li>3. Adresse</li>
										<li>4. Récapitulatif</li>
										<li class="ariane_cmd_fil"></li>
									</ul>
								</div>
							</div><br />
							'.$alert.'
							<div id="espace_compte" style="margin: 0 0 0 100px;">
								<form name="client_ajout" action="prix-travaux.php?contenu=authentification&action=inscription" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
								<fieldset>
									<legend>Informations personnelles</legend>
									<p>
										<label for="ip_etes1">Vous êtes : </label>
										<select id="ip_etes1" name="etes1"><option value=""></option>'.$option_etes1.'</select>
									</p>
									<p id="p_pre1" style="display:none;">
										<label for="ip_pre1">precisez : </label>
										<input id="ip_pre1" type="text" name="precisez1_nouveau"/>
									</p>
									<p>
										<label for="ip_etes2">Vous êtes : </label>
										<select id="ip_etes2" name="etes2_nouveau"><option value=""></option>'.$option_etes2.'</select>
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
										<label for="ip_voi">Numéro et voie : <span class="obli">*</span></label>
										<input id="ip_voi" type="text" name="numvoie_nouveau"/>
									</p>
									<p>
										<label for="ip_app">N° d\'appartement, Etage, Escalier : </label>
										<input id="ip_app" type="text" name="numapp_nouveau"/>
									</p>
									<p>
										<label for="ip_bat">Bâtiment, Résidence, Entrée : </label>
										<input id="ip_bat" type="text" name="bat_nouveau"/>
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
										<label for="ip_mail">Email : <span class="obli">*</span></label>
										<input id="ip_mail" type="text" name="mail_nouveau" oncopy="return false;" onpaste="return false;"/>
									</p>
									<p>
										<label for="ip_mail">Email de confirmation : <span class="obli">*</span></label>
										<input id="ip_mail" type="text" name="mailc_nouveau" oncopy="return false;" onpaste="return false;"/>
									</p>
									<p>
										<label for="ip_connus">Comment vous nous avez connus : </label>
										<select id="ip_connus" name="connus"><option value=""></option>'.$option_connus.'</select>
									</p>
									<p id="p_pre2" style="display:none;">
										<label for="ip_pre2">precisez : </label>
										<input id="ip_pre2" type="text" name="precisez2_nouveau"/>
									</p>
									<p>
										<label for="ip_mdp">Mot de passe : <span class="obli">*</span></label>
										<input id="ip_mdp" type="password" name="pass1_nouveau" />
									</p>
									<p>
										<label for="verif_mdp">Mot de passe <br /> de confirmation : <span class="obli">*</span></label>
										<input id="verif_mdp" type="password" name="pass2_nouveau" />
									</p>		
									<p>
										<label for="validation">Veuillez recopier le code <img src="Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
										<input id="validation" type="text" name="validation" />
									</p>		
									<p>
										<input type="checkbox" name="partenaire"/> Acceptation de recevoir offres partenaire
									</p>
									<p>
										<input type="checkbox" name="newsletter" checked="checked"/> S\'inscrire à notre newsletter
									</p>
									<p>
										<input type="checkbox" name="condition" id="condition"/> Acceptation des conditions générales
									</p>
									
									<p class="align_center padding_tb_20">
										<input value="valider" class="sub" type="submit" name="ajout_client"/>
									</p>
									<p class="note" id="text_erreur"><cite>( * ) champs obligatoires.</cite></p>
									
								</fieldset>
								</form>	
							</div>
							';			
						break;
				}
			}
			else
			{
				$alert='<div id="note"></div><br />';
				if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='erreur') ) $alert='<div id="note" class="error"><p>Erreur lors de l\'authentification.</p></div><br />';
				if ( isset($_GET['inscrit']) && ($_GET['inscrit']=='enattente') ) $alert='<div id="note" class="notice"><p>Votre compte est en cours de validation.</p></div><br />';
		
				echo'
					<br /><br />
					<div id="espace_compte">
						<div class="conteneur_ariane_cmd">
							<ul id="compte_ariane_cmd">
								<li class="done">1. <a href="prix-travaux.php">Ajouter au devis </a></li>
								<li class="courant">2. <a href="prix-travaux.php?contenu=authentification">S\'identifier </a></li>
								<li>3. Adresse</li>
								<li>4. Récapitulatif</li>
								<li class="ariane_cmd_fil"></li>
							</ul>
						</div>
					</div><br />
					'.$alert.'

				<div class="col-md-6 ">
					<div class="Login-part">
						<div class="title-sign-part">Vous avez déjà un compte ?</div>
						<form action="prix-travaux.php?contenu=authentification&action=connexion" name="client_conn" method="post" class="" >
							<div class="form-login-part">
											<input id="mail" type="text" name="email_connexion" placeholder="Votre e-mail" required/>
											<input id="mdp" type="password" name="mdp_connexion" placeholder="Mot de passe" required/>
											<input class="boutons_persos_1" value="Connexion" type="submit" name="conn_client"/>
											<p>Si vous avez oublié votre mot de passe, <a href="espace_pro.php?contenu=mdp_perdu">cliquez ici</a>.</p>																
										</p>
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
							<a href="prix-travaux.php?contenu=authentification&action=inscription" class="">Créer un compte</a>
						</div>
					</div>
				</div>

					';				
			}
			break;
		case 'adresse' :
			if ( isset($_GET['action']) )
			{
				switch ( $_GET['action'] ) 
				{
					case 'ajouter' :
						$alert='<div id="note"></div><br />';
						$contenu.='
							'.$alert.'
							<div id="espace_compte" style="margin: 0 0 0 100px;">
								<form name="adresse" action="prix-travaux.php?contenu=adresse&action=ajouter" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
								<fieldset>
									<legend>Informations personnelles</legend>
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
									
								</fieldset>
								</form>	
								<p class="margin_top_20"><a href="prix-travaux.php?contenu=adresse">Retour à la page précédente</a></p>
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
						$contenu.='
							'.$alert.'
							<div id="espace_compte" style="margin: 0 0 0 100px;">
								<form name="adresse" action="prix-travaux.php?contenu=adresse&action=modifier&id='.$_GET['id'].'" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
								<fieldset>
									<legend>Informations personnelles</legend>
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
									
								</fieldset>
								</form>	
								<p class="margin_top_20"><a href="prix-travaux.php?contenu=adresse&action=afficher">Retour à la page précédente</a></p>
							</div>
							';
						break;
					case 'afficher' :
						$contenu.='
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
						$req= $my->req('SELECT * FROM ttre_client_part_adresses WHERE id_client='.$_SESSION['id_client_trn_part'].' AND statut=1 ');					
						while ( $res=$my->arr($req) )
						{
							$ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
							$contenu.='
									<tr>
										<td>'.ucfirst($res['num_voie']).'</td>			
										<td>'.ucfirst($res['num_appart']).'</td>																							
										<td>'.ucfirst($res['batiment']).'</td>
										<td>'.ucfirst($res['code_postal']).'</td>
										<td>'.ucfirst($ville['ville_nom_reel']).'</td>
										<td>'.ucfirst($res['pays']).'</td>
										<td><a href="prix-travaux.php?contenu=adresse&action=modifier&id='.$res['id'].'" title="Modifier adresse"><img src="stockage_img/book_edit.png" alt="Modifier adresse"/></a></td>									
										<td><a href="prix-travaux.php?contenu=adresse&action=valider&id='.$res['id'].'" title="Supprimer adresse"><img src="stockage_img/accept.png" alt="Valider adresse"/></a></td>		
									</tr>		
									  ';
						}
						$contenu.='
								</table>	
								<p class="margin_top_20"><a href="prix-travaux.php?contenu=adresse">Retour à la page précédente</a> 
								| 
								<a href="prix-travaux.php?contenu=adresse&action=ajouter">Ajouter une autre adresse</a></p>
								  ';
						break;
				}
			}
			else 
			{
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$_SESSION['adresse_chantier_trn'].' ');
				$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
				$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
				$batiment = ucfirst(html_entity_decode($temp['batiment']));
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				$contenu.='
					<ul id="compte_details_com1" class="livraison1">
						<li>
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N° d’appartement : '.$num_appart.'</dd>
								<dd>Bâtiment : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
								<dd class="modifier"><a href="prix-travaux.php?contenu=adresse&action=afficher"> » Autre adresse </a></dd>
							</dl>								
						</li>				
					</ul>
		
					<p class="padding_bottom_20 overflow_hidden">
						<a href="prix-travaux.php" class="boutons_persos_1 float_left">Retour au panier</a>
						<a href="prix-travaux.php?contenu=recapitulatif" class="boutons_persos_1 float_right">Contenuer</a>
					</p>			
						 ';
				
			}
			$alert='<div id="note"></div><br />';
			echo'
				<br /><br />
				<div id="espace_compte">
					<div class="conteneur_ariane_cmd">
						<ul id="compte_ariane_cmd">
							<li class="done">1. <a href="prix-travaux.php">Ajouter au devis </a></li>
							<li class="done">2. <a href="prix-travaux.php?contenu=authentification">S\'identifier </a></li>
							<li class="courant">3. <a href="prix-travaux.php?contenu=adresse">Adresse</a></li>
							<li>4. Récapitulatif</li>
							<li class="ariane_cmd_fil"></li>
						</ul>
					</div>
				</div><br />
				'.$alert.'
				<div id="espace_compte">
					'.$contenu.'
				</div>
				';
			break;
		case 'recapitulatif' :
			$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$_SESSION['adresse_chantier_trn'].' ');
			$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
			$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
			$batiment = ucfirst(html_entity_decode($temp['batiment']));
			$code_postal = $temp['code_postal'];
			$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
			$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
			$pays = ucfirst(html_entity_decode($temp['pays']));
			$contenu='
				<ul id="compte_details_com1" class="livraison1">
					<li>
						<h4>Adresse de chantier</h4>
						<dl>
							<dd>Numero et voie : '.$num_voie.'</dd>
							<dd>N° d’appartement : '.$num_appart.'</dd>
							<dd>Bâtiment : '.$batiment.'</dd>
							<dd>'.$code_postal.' '.$ville.'</dd>
							<dd>'.$pays.'</dd>
							<dd class="modifier"><a href="prix-travaux.php?contenu=adresse&action=afficher"> » Autre adresse </a></dd>
						</dl>								
					</li>				
				</ul>
					 ';
			$montantTotal = 0;
			//$poidsTotal = 0;
			$panier='';
			$nom_cat='';
			
			$reqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
			while ( $ress=$my->arr($reqq) ) $tab_tva[$ress['id']]=0;
						
			for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )	
			{	
				$prod=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$_SESSION['panier_trn']['id_prod'][$i].' ');
				$ttva=$my->req_arr('SELECT * FROM ttre_tva WHERE id='.$prod['tva'].' ');
				
				$nomPiece = $_SESSION['panier_trn']['piece'][$i];
				$nomProduit = ucfirst(html_entity_decode($prod['designation']));
				$prixUnitaire = $_SESSION['panier_trn']['prix'][$i];
				$clef = $_SESSION['panier_trn']['id'][$i];
				$quantite = $_SESSION['panier_trn']['qte'][$i];
				$unite = $_SESSION['panier_trn']['unite'][$i];
				$total = $prixUnitaire * $quantite;
				$montantTotal = $montantTotal + $total;
				$tab_tva[$prod['tva']] = $tab_tva[$prod['tva']] + ( $total * $ttva['valeur'] / 100 );
				//$poidsTotal = $poidsTotal + $prod['poids'];
				// pour le td ajouter class="align_left" pour ecrire au debut de colonne n'est pas au centre 
				
				$affich_cat='';
				$c=$my->req_arr('SELECT * FROM ttre_categories WHERE ordre='.$_SESSION['panier_trn']['or_cat'][$i].' ');
				if ( $nom_cat!=$c['titre'] )
				{
					$nom_cat=$c['titre'];
					$affich_cat='
							<tr style="background:#faca2e;">
								<td colspan="7">'.$nom_cat.'</td>
							</tr>
								';
				}
				
				$panier.='
						'.$affich_cat.'
						<tr>
							<td>'.$nomPiece.'</td>		
							<td style="text-align:justify;">'.$nomProduit.'</td>		
							<td>'.number_format($prixUnitaire, 2,'.','').' €</td>
							<td>'.$quantite.'</td>
							<td>'.$unite.'</td>
							<td>'.number_format($total, 2,'.','').' €</td>
						</tr>
					';
			}	
			$fraisPort=0;
			/*$affich_frais='
					<tr class="total"><td colspan="5"><br /></td></tr>
					<tr class="total">
						<td colspan="4"><strong>Sous-total : </strong></td>
						<td class="prix_final">'.number_format($montantTotal, 2).'€</td>
					</tr>								
					<tr class="total">
						<td colspan="4"><strong>Frais de port : </strong></td>
						<td class="prix_final">'.number_format($fraisPort, 2).'€</td>
					</tr>								
				';*/
			$affich_frais='';
			$affich_tva='';$total_tva=0;
			$reqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
			if ( $my->num($reqq)>0 )
			{
				while ( $ress=$my->arr($reqq) )
				{
					if ( $tab_tva[$ress['id']] > 0 )
						$affich_tva.='
									<tr class="total">
										<td colspan="5"><strong>'.$ress['titre'].' : </strong></td>
										<td colspan="2" class="prix_final">'.number_format($tab_tva[$ress['id']], 2,'.','').'€</td>
									</tr>
									';
					$total_tva+=$tab_tva[$ress['id']];
				}
			}
			
			$montantTotalTTC = $montantTotal + $fraisPort + $total_tva ;
			$contenu.='
				<div id="espace_compte">
					<form method="post">	
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
						<tr class="entete">
							<td>Pièce</td>														
							<td>Désignation</td>														
							<td>P.U</td>
							<td>Qte</td>
							<td>Unité</td>
							<td>Total</td>
						</tr>		
						'.$panier.'
						<tr class="total">
							<td colspan="5"><strong>Total HT : </strong></td>
							<td colspan="2" class="prix_final">'.number_format($montantTotal, 2,'.','').'€</td>
						</tr>
						'.$affich_frais.'
						'.$affich_tva.'
						<tr class="total">
							<td colspan="5"><strong>Total TTC : </strong></td>
							<td colspan="2" class="prix_final">'.number_format($montantTotalTTC, 2,'.','').'€</td>
						</tr>								
					</table>
					<p id="panier_boutons">
							<span class="panier_actions"><a class="panier_modifier" href="prix-travaux.php">Modifier mon panier</a></span>
							<span class="droit_actions"><a class="panier_modifier" href="espace_particulier.php">Modifier mon profil</a></span>
							<input type="button" value="Envoyer mon devis" onclick="javascript:window.location=\'prix-travaux.php?contenu=envoyer\'" />
						 </p>
					</form>	
				</div>
				';	
			echo'
				<br /><br />
				<div id="espace_compte">
					<div class="conteneur_ariane_cmd">
						<ul id="compte_ariane_cmd">
							<li class="done">1. <a href="prix-travaux.php">Ajouter au devis </a></li>
							<li class="done">2. <a href="prix-travaux.php?contenu=authentification">S\'identifier </a></li>
							<li class="done">3. <a href="prix-travaux.php?contenu=adresse">Adresse</a></li>
							<li class="courant">4. <a href="prix-travaux.php?contenu=recapitulatif">Récapitulatif</a></li>
							<li class="ariane_cmd_fil"></li>
						</ul>
					</div>
				</div><br />
				'.$alert.'
				<div id="espace_compte">
					'.$contenu.'
				</div>
				';
			$_SESSION['frais_Port_trn']=$fraisPort;
			$_SESSION['total_tva_trn']=$total_tva;
			$_SESSION['total_Net_trn']=$montantTotal;	
			break;
		case 'envoyer' :
			echo'<br /><br /><br /><div id="note" class="notes"><p>Votre devis a bien été enregistré.</p></div>';
			unset($_SESSION['frais_Port_trn']);
			unset($_SESSION['total_tva_trn']);
			unset($_SESSION['total_Net_trn']);
			unset($_SESSION['adresse_chantier_trn']);
			unset($_SESSION['panier_trn']);
			break;
	}
}
elseif ( isset($_SESSION['panier_trn']) )
{
	$montantTotal = 0;
	//$poidsTotal = 0;
	$panier='';
	$nom_cat='';
	
	$reqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
	while ( $ress=$my->arr($reqq) ) $tab_tva[$ress['id']]=0;
				
	for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )	
	{	
		$prod=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$_SESSION['panier_trn']['id_prod'][$i].' ');
		$ttva=$my->req_arr('SELECT * FROM ttre_tva WHERE id='.$prod['tva'].' ');
		
		$nomPiece = $_SESSION['panier_trn']['piece'][$i];
		$nomProduit = ucfirst(html_entity_decode($prod['designation']));
		$prixUnitaire = $_SESSION['panier_trn']['prix'][$i];
		$clef = $_SESSION['panier_trn']['id'][$i];
		$quantite = $_SESSION['panier_trn']['qte'][$i];
		$unite = $_SESSION['panier_trn']['unite'][$i];
		$total = $prixUnitaire * $quantite;
		$montantTotal = $montantTotal + $total;
		$tab_tva[$prod['tva']] = $tab_tva[$prod['tva']] + ( $total * $ttva['valeur'] / 100 );
		//$poidsTotal = $poidsTotal + $prod['poids'];
		// pour le td ajouter class="align_left" pour ecrire au debut de colonne n'est pas au centre 
		
		if ( $_SESSION['panier_trn']['type'][$i]==1 ) $onkeyPress='onKeyPress="return scanTouche(event)"';
		elseif ( $_SESSION['panier_trn']['type'][$i]==2 ) $onkeyPress='onKeyPress="return scanFTouche(event)"';
		else $onkeyPress='';
		
		$affich_cat='';
		$c=$my->req_arr('SELECT * FROM ttre_categories WHERE ordre='.$_SESSION['panier_trn']['or_cat'][$i].' ');
		if ( $nom_cat!=$c['titre'] )
		{
			$nom_cat=$c['titre'];
			$affich_cat='
					<tr style="background:#faca2e;">
						<td colspan="7">'.$nom_cat.'</td>
					</tr>
						';
		}
		
		$panier.='
				'.$affich_cat.'
				<tr>
					<td><input type="text" name="nompiece'.$clef.'" value="'.$nomPiece.'" style="width:50px;"/></td>		
					<td style="text-align:justify;">'.$nomProduit.'</td>		
					<td>'.number_format($prixUnitaire, 2,'.','').' €</td>
					<td><input class="panier_qte" type="text" name="quantite'.$clef.'" value="'.$quantite.'" '.$onkeyPress.' style="width:40px;"/></td>
					<td>'.$unite.'</td>
					<td>'.number_format($total, 2,'.','').' €</td>
					<td><a href="prix-travaux.php?contenu=panier&action=supprimer&id='.$clef.'" title="Supprimer ce article de panier"><img src="stockage_img/supprimer.png" alt="Supprimer ce article de panier"/></a></td>
				</tr>
			';
	}	
	$fraisPort=0;
	/*$affich_frais='
			<tr class="total"><td colspan="5"><br /></td></tr>
			<tr class="total">
				<td colspan="4"><strong>Sous-total : </strong></td>
				<td class="prix_final">'.number_format($montantTotal, 2).'€</td>
			</tr>								
			<tr class="total">
				<td colspan="4"><strong>Frais de port : </strong></td>
				<td class="prix_final">'.number_format($fraisPort, 2).'€</td>
			</tr>								
		';*/
	$affich_frais='';
	$affich_tva='';$total_tva=0;
	$reqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
	if ( $my->num($reqq)>0 )
	{
		while ( $ress=$my->arr($reqq) )
		{
			if ( $tab_tva[$ress['id']] > 0 )
				$affich_tva.='
							<tr class="total">
								<td colspan="5"><strong>'.$ress['titre'].' : </strong></td>
								<td colspan="2" class="prix_final">'.number_format($tab_tva[$ress['id']], 2,'.','').'€</td>
							</tr>
							';
			$total_tva+=$tab_tva[$ress['id']];
		}
	}
	
	$montantTotalTTC = $montantTotal + $fraisPort + $total_tva ;
	
	if ( isset($_GET['supprimer']) ) $alert='<div id="note" class="notes"><p>Produit supprimé avec succès.</p></div><br />';
	elseif ( isset($_GET['modifier']) ) $alert='<div id="note" class="notes"><p>Quantité mise à jour avec succès.</p></div><br />';
	else  $alert='<div id="note"></div><br />';
	
	echo'
		<br /><br />
		<div id="espace_compte">
			<div class="conteneur_ariane_cmd">
				<ul id="compte_ariane_cmd">
					<li class="courant">1. <a href="prix-travaux.php">Ajouter au devis </a></li>
					<li>2. S\'identifier</li>
					<li>3. Adresse</li>
					<li>4. Récapitulatif</li>
					<li class="ariane_cmd_fil"></li>
				</ul>
			</div>
		</div><br />
		'.$alert.'
		<div id="espace_compte">
			<form method="post" action="?contenu=panier&action=modifier">					
			<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
				<tr class="entete">
					<td>Pièce</td>														
					<td>Désignation</td>														
					<td>P.U</td>
					<td>Qte</td>
					<td>Unité</td>
					<td>Total</td>
					<td></td>
				</tr>		
				'.$panier.'
				<tr class="total">
					<td colspan="5"><strong>Total HT : </strong></td>
					<td colspan="2" class="prix_final">'.number_format($montantTotal, 2,'.','').'€</td>
				</tr>
				'.$affich_frais.'
				'.$affich_tva.'
				<tr class="total">
					<td colspan="5"><strong>Total TTC : </strong></td>
					<td colspan="2" class="prix_final">'.number_format($montantTotalTTC, 2,'.','').'€</td>
				</tr>								
			</table>
			<p id="panier_boutons">
				<span class="panier_actions"><a class="panier_vider" href="prix-travaux.php?contenu=panier&action=vider">Vider le panier</a></span>
				<input type="submit" value="Recalculer" name="recalcul_panier"/>
				<input type="button" value="Poursuivre mon devis" onclick="javascript:window.location=\'prix-travaux.php?contenu=authentification\'" />
			</p>
		</form>
		</div>
		';	
	// $temp=$my->req_arr('SELECT * FROM ttre_panier WHERE id=1');	
	// echo $temp['description'];		
//				<input type="button" value="Poursuivre ma commande" onclick="javascript:window.location=\'panier.php?contenu=authentification\'" />
}

?>















<style>

#menu_cat ul{
	margin: 0;
	padding: 0;
}

ul#menu_cat li {
	cursor:pointer;
	float:left;
	height:80px;
	
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	width:175.5px;
	padding-left:1px;
	padding-right:1px;
	 -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 0px;
	margin-bottom:1px;
	font-size:10px;
	margin-left: .3px;
}

ul#menu_cat a{
	color: #1e1e1e;
	line-height: 40px;
}

ul#menu_cat a:hover{
	text-decoration: none;
}

ul#menu_cat li img{ margin-top:10px; height:30px;}
.classLiScat {
    cursor:pointer;
	float:left;
	height:90px;
	min-width:100px;
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	-moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
	font-size:12px;
	padding-left:1px;
	padding-right:1px;
	color: #fff;
}
.classLiScat img{ margin-top:10px; height:30px;}
</style>





										</div>

							</article>
						</div>
					</div>
					
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>



