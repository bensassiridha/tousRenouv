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
					if( !isset($_SESSION['devis_trn']) )
					{
						$_SESSION['devis_trn'] 				= array();
						$_SESSION['devis_trn']['id'] 		= array();
						$_SESSION['devis_trn']['id_prod'] 	= array();
						$_SESSION['devis_trn']['or_cat'] 	= array();
						$_SESSION['devis_trn']['piece'] 	= array();
					}
					$indice = count($_SESSION['devis_trn']['id']) + 1;
					$prod=$_POST['id_prod'];
					$or_cat=$_POST['or_cat'];
					$piece=$_POST['piece'];
					
					$incrementer = -1;
					
					if ( count($_SESSION['devis_trn']['id_prod'])>0 && array_search($prod,$_SESSION['devis_trn']['id_prod'])!==false )
					{
						$i = 0;
						while ( $i<count($_SESSION['devis_trn']['id']) && $incrementer == -1 )
						{
							if ( $_SESSION['devis_trn']['id_prod'][$i]==$prod ) $incrementer = $i;
							$i++;
						}
					}
					if ( $incrementer != -1 )
					{ 
						$_SESSION['devis_trn']['piece'][$incrementer]=$piece;
					}	
					else
					{
						$cpt=0;
						for ( $i=0;$i<count($_SESSION['devis_trn']['id']);$i++ )
						{
							if ( $i==0 && $or_cat<$_SESSION['devis_trn']['or_cat'][$i] )
							{
								// ajout au debut
								$cpt=0;break;
							}
							elseif ( $i==(count($_SESSION['devis_trn']['id'])-1) && $or_cat>=$_SESSION['devis_trn']['or_cat'][$i] )
							{
								// ajout au fin
								$cpt=count($_SESSION['devis_trn']['id']);
							}
							elseif ( $_SESSION['devis_trn']['or_cat'][$i]<=$or_cat && $or_cat<$_SESSION['devis_trn']['or_cat'][$i+1] )
							{
								// ajout au milieu
								$cpt=$i+1;break;
							}
						}
						if ( count($_SESSION['devis_trn']['id'])>0 )
						{
							$_SESSION['devis_tmp'] 				= array();
							$_SESSION['devis_tmp']['id'] 		= array();
							$_SESSION['devis_tmp']['id_prod'] 	= array();
							$_SESSION['devis_tmp']['or_cat'] 	= array();
							$_SESSION['devis_tmp']['piece'] 	= array();
							$indice = 1;
							$nb_articles = count($_SESSION['devis_trn']['id']);$j=0;
							for ( $x=0;$x<=$nb_articles;$x++ )
							{
								# transférer tous les items dans le panier temp sauf ceux à supprimer
								if ( $j==0 && $x==$cpt )
								{
									$_SESSION['devis_tmp']['id'][]=$indice;
									$_SESSION['devis_tmp']['id_prod'][]=$prod;
									$_SESSION['devis_tmp']['or_cat'][]=$or_cat;
									$_SESSION['devis_tmp']['piece'][]=$piece;
									$x=$x-1;$j=1;$indice ++;$nb_articles --;
								}
								else
								{
									array_push($_SESSION['devis_tmp']['id'],$indice);
									array_push($_SESSION['devis_tmp']['id_prod'],$_SESSION['devis_trn']['id_prod'][$x]);
									array_push($_SESSION['devis_tmp']['or_cat'],$_SESSION['devis_trn']['or_cat'][$x]);
									array_push($_SESSION['devis_tmp']['piece'],$_SESSION['devis_trn']['piece'][$x]);
									$indice ++;
								}
							}
							$_SESSION['devis_trn'] = $_SESSION['devis_tmp'];
							unset($_SESSION['devis_tmp']);
						}
						else
						{
							$_SESSION['devis_trn']['id'][]=$indice;
							$_SESSION['devis_trn']['id_prod'][]=$prod;
							$_SESSION['devis_trn']['or_cat'][]=$or_cat;
							$_SESSION['devis_trn']['piece'][]=$piece;
						}
					}				
					echo '<script>window.location="devis.php"</script>';
					break;
				case 'supprimer' :
					$_SESSION['devis_tmp'] 				= array();
					$_SESSION['devis_tmp']['id'] 		= array();
					$_SESSION['devis_tmp']['id_prod'] 	= array();
					$_SESSION['devis_tmp']['or_cat'] 	= array();
					$_SESSION['devis_tmp']['piece'] 	= array();
					$indice = 1;
					$nb_articles = count($_SESSION['devis_trn']['id']);
					for ( $x=0;$x<$nb_articles;$x++ )
					{
						# transférer tous les items dans le panier temp sauf ceux à supprimer
						if ( $_SESSION['devis_trn']['id'][$x] != $_GET['id'] )
						{
							array_push($_SESSION['devis_tmp']['id'],$indice);
							array_push($_SESSION['devis_tmp']['id_prod'],$_SESSION['devis_trn']['id_prod'][$x]);
							array_push($_SESSION['devis_tmp']['or_cat'],$_SESSION['devis_trn']['or_cat'][$x]);
							array_push($_SESSION['devis_tmp']['piece'],$_SESSION['devis_trn']['piece'][$x]);
							$indice ++;
						}
					}
					$_SESSION['devis_trn'] = $_SESSION['devis_tmp'];
					unset($_SESSION['devis_tmp']);
					if ( $nb_articles == 1 )
					{
						unset($_SESSION['devis_trn']);
						echo '<script>window.location="devis.php"</script>';						
					}
					else
					{
						echo '<script>window.location="devis.php?supprimer=ok"</script>';						
					}
					break;
				case 'vider' :
					unset($_SESSION['devis_trn']);
					echo '<script>window.location="devis.php"</script>';
					break;
			}
			break;
		case 'authentification' :
			if ( !isset($_SESSION['devis_trn']) ) {header("location:devis.php");exit;}
			if ( isset($_SESSION['id_client_trn_part']) ) {header("location:devis.php?contenu=adresse");exit;}
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
								header("location:devis.php?contenu=authentification&inscrit=erreur");exit;
							}
							else
							{
								$cl=$my->arr($req);
								$_SESSION['id_client_trn_part']=$cl['id'];
								header("location:devis.php?contenu=adresse");exit;
							}
						}
						break;
					case 'inscription' :
						if ( isset($_POST['ajout_client']) )
						{
							if ( md5($_POST['validation']) != $_SESSION['valeur_image'] ){header("location:devis.php?contenu=authentification&action=inscription&erreur=validation");exit;}
							else
							{
								$req=$my->req('SELECT * FROM ttre_client_part WHERE email="'.$_POST['mail_nouveau'].'"');
								if ( $my->num($req)>0 ) {header("location:devis.php?contenu=authentification&action=inscription&erreur=mail");exit;}
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
									header("location:devis.php?contenu=authentification&inscrit=enattente");exit;			
								}
							}
						}
						break;
				}
			}
			break;
		case 'adresse' :
			if ( !isset($_SESSION['devis_trn']) ) {header("location:devis.php");exit;}
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:devis.php?contenu=authentification");exit;}
			
			if ( !isset($_GET['action']) )
			{
				$req=$my->req('SELECT * FROM ttre_client_part_adresses WHERE id_client='.$_SESSION['id_client_trn_part'].' AND statut=1 ');
				if ( $my->num($req)==0 ) {header("location:devis.php?contenu=adresse&action=ajouter");exit;}
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
							header("location:devis.php?contenu=adresse");exit;
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
							header("location:devis.php?contenu=adresse");exit;
						}
						break;
					case 'valider' :
						$_SESSION['adresse_chantier_trn']=$_GET['id'];
						header("location:devis.php?contenu=adresse");exit;
						break;
				}
			}
			break;
		case 'recapitulatif' :
			if ( !isset($_SESSION['devis_trn']) ) {header("location:devis.php");exit;}
			if ( !isset($_SESSION['id_client_trn_part']) ) {header("location:devis.php?contenu=authentification");exit;}
			if ( !isset($_SESSION['adresse_chantier_trn']) ) {header("location:devis.php?contenu=adresse");exit;}
			if ( isset($_POST['envoie_devis']) )
			{
				$reference_devis = uniqid('R');
				$my->req("INSERT INTO ttre_achat_devis VALUES('',
													'".$reference_devis."',
													'".time()."',
													'".$_SESSION['id_client_trn_part']."',
													'".$_SESSION['adresse_chantier_trn']."',
													'0',
													'0',
													'0'
													)");
				$id_devis = mysql_insert_id();
				
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
				
				for ( $i=0;$i<count($_SESSION['devis_trn']['id']);$i++ )	
				{	
					$or_categ=$_SESSION['devis_trn']['or_cat'][$i];
					$id_categ=$_SESSION['devis_trn']['id_prod'][$i];
					$temp=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$id_categ.' ');
					$titre_categ=$temp['titre'];
					$desc_piece=$_SESSION['devis_trn']['piece'][$i];
					$my->req("INSERT INTO ttre_achat_devis_details VALUES('',
															'".$id_devis."',
															'".$or_categ."',
															'".$id_categ."',
															'".$my->net($titre_categ)."',
															'".$my->net_textarea($desc_piece)."'
															)");
				}
				$cl=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$_SESSION['id_client_trn_part'].' ');
				$message = '
					<html>
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>'.$nom_client.'</title>
					</head>
														
					<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
						<div id="corps" style="margin:0 auto; width:800px; height:auto;">
							<center><img src="'.$logo_client.'" /></center><br />
							<h1 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">'.$nom_client.'</h1>
							<p>Bonjour,</p>																
							<p>un nouveau devis avec  achat imédiat a été ajouté sur votre base de données par " '.html_entity_decode($cl['nom']).' '.html_entity_decode($cl['prenom']).' ".</p> 
							<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
								<p style="padding-top:10px;">'.$nom_client.'</p>											
							</div>
						</div>
					</body>
					</html>
					';
				$mail_client='bilelbadri@gmail.com';
				$sujet = $nom_client.' : Nouveau devis';
				$headers = "From: \" ".$nom_client." \"<".$mail_client.">\n";
				$headers .= "Reply-To: ".$cl['email']."\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
				mail($mail_client,$sujet,$message,$headers);
				header("location:devis.php?contenu=envoyer");exit;
			}
			break;
	}
}










include('inc/head.php');?>
	<body id="">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
					<div class="wrapper">
						<div class="header-page-part">
							<div class="container">
								<div class="row">
								<div class="col-md-12">
									<h2>Simulateur</h2>
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
							<article id="devis">
								<div class="container">
									<div class="row">
										<div class="devis">
<?php 

//--------------------------------- Partie Categegorie ---------------------------
$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
if ( $my->num($reqCat)>0 )
{
	$liCat='';
	while ( $resCat=$my->arr($reqCat) )
	{
		$style=' style="background:#faca2e;color:#fff;" ';
		if ( isset($_GET['cat']) && $_GET['cat']==$resCat['id'] )$style=' style="background:#00acf0;" ';
		if ( !empty($resCat['photo']) ) $logo='<img src="upload/logosCateg/50X30/'.$resCat['photo'].'" />'; else $logo='';
		$liCat.='<li '.$style.'"><a href="devis.php?cat='.$resCat['id'].'">'.$logo.' <br /> '.$resCat['titre'].'</a></li>';
	}
	echo '<ul id="menu_cat" >'.$liCat.'</ul>';
}

if ( isset($_GET['cat']) )
{
	$temp=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$_GET['cat'].' ');
	$contenu='';
	if ( isset($_SESSION['devis_trn']) )
	{
		$prod=$_GET['cat'];
		$incrementer = -1;
		if ( count($_SESSION['devis_trn']['id_prod'])>0 && array_search($prod,$_SESSION['devis_trn']['id_prod'])!==false )
		{
			$i = 0;
			while ( $i<count($_SESSION['devis_trn']['id']) && $incrementer == -1 )
			{
				if ( $_SESSION['devis_trn']['id_prod'][$i]==$prod ) $incrementer = $i;
				$i++;
			}
		}
		if ( $incrementer != -1 ) $contenu = $_SESSION['devis_trn']['piece'][$incrementer];
	}
	echo'
		<br /><br /><br />
		<div id="">
			<form name="cat_ajout" action="devis.php?contenu=panier&action=ajouter" method="post" enctype="multipart/form-data" class="">
				<div class="container">
					<div class="row">
						<div class="description col-md-12">
							<!-- <h4>'.$temp['titre'].'</h4> -->
							<p>
								<!--<label for="ip_mail">Description : <span class="obli">*</span></label><br />-->
								<textarea id="ip_mail" type="text" name="piece" placeholder="Description" required>'.$contenu.'</textarea>
							</p>
									
							<p class="align_center padding_tb_20">
								<input value="'.$_GET['cat'].'" type="hidden" name="id_prod"/>
								<input value="'.$temp['ordre'].'" type="hidden" name="or_cat"/>
								<input value="VALIDER" class="sub" type="submit" name="ajout_client"/>
							</p>
							
						</div>					
					</div>
				</div>
			</form>	
		</div>							
		';
}

//------------------------------------------------------------Panier------------------------------------------------------------


//echo'<pre>';print_r($_SESSION);echo'</pre>';
?>
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

//echo'<pre>';print_r($_POST);echo'</pre>';
//echo'<pre>';print_r($_SESSION['devis_trn']);echo'</pre>';
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
										<li class="done">1. <a href="devis.php">Ajouter au devis</a></li>
										<li class="courant">2. <a href="devis.php?contenu=authentification">S\'identifier</a></li>
										<li>3. Adresse</li>
										<li>4. Récapitulatif</li>
										<li class="ariane_cmd_fil"></li>
									</ul>
								</div>
							</div><br />
							'.$alert.'
							<div id="espace_compte" style="margin: 0 0 0 100px;">
								<form name="client_ajout" action="devis.php?contenu=authentification&action=inscription" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
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
										<input type="checkbox" name="newsletter" checked="checked" /> S\'inscrire à notre newsletter
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
								<li class="done">1. <a href="devis.php">Ajouter au devis </a></li>
								<li class="courant">2. <a href="devis.php?contenu=authentification">S\'identifier </a></li>
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
								<form name="adresse" action="devis.php?contenu=adresse&action=ajouter" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
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
								<p class="margin_top_20"><a href="devis.php?contenu=adresse">Retour à la page précédente</a></p>
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
								<form name="adresse" action="devis.php?contenu=adresse&action=modifier&id='.$_GET['id'].'" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
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
								<p class="margin_top_20"><a href="devis.php?contenu=adresse&action=afficher">Retour à la page précédente</a></p>
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
										<td><a href="devis.php?contenu=adresse&action=modifier&id='.$res['id'].'" title="Modifier adresse"><img src="stockage_img/book_edit.png" alt="Modifier adresse"/></a></td>									
										<td><a href="devis.php?contenu=adresse&action=valider&id='.$res['id'].'" title="Supprimer adresse"><img src="stockage_img/accept.png" alt="Valider adresse"/></a></td>		
									</tr>		
									  ';
						}
						$contenu.='
								</table>	
								<p class="margin_top_20"><a href="devis.php?contenu=adresse">Retour à la page précédente</a> 
								| 
								<a href="devis.php?contenu=adresse&action=ajouter">Ajouter une autre adresse</a></p>
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
					<ul id="compte_details_com" class="livraison">
						<li>
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N° d’appartement : '.$num_appart.'</dd>
								<dd>Bâtiment : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
								<dd class="modifier"><a href="devis.php?contenu=adresse&action=afficher"> » Autre adresse </a></dd>
							</dl>								
						</li>				
					</ul>
		
					<p class="padding_bottom_20 overflow_hidden">
						<a href="devis.php" class="boutons_persos_1 float_left">Retour au panier</a>
						<a href="devis.php?contenu=recapitulatif" class="boutons_persos_1 float_right">Contenuer</a>
					</p>			
						 ';
				
			}
			$alert='<div id="note"></div><br />';
			echo'
				<br /><br />
				<div id="espace_compte">
					<div class="conteneur_ariane_cmd">
						<ul id="compte_ariane_cmd">
							<li class="done">1. <a href="devis.php">Ajouter au devis </a></li>
							<li class="done">2. <a href="devis.php?contenu=authentification">S\'identifier </a></li>
							<li class="courant">3. <a href="devis.php?contenu=adresse">Adresse</a></li>
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
				<ul id="compte_details_com" class="livraison">
					<li>
						<h4>Adresse de chantier</h4>
						<dl>
							<dd>Numero et voie : '.$num_voie.'</dd>
							<dd>N° d’appartement : '.$num_appart.'</dd>
							<dd>Bâtiment : '.$batiment.'</dd>
							<dd>'.$code_postal.' '.$ville.'</dd>
							<dd>'.$pays.'</dd>
							<dd class="modifier"><a href="devis.php?contenu=adresse&action=afficher"> » Autre adresse </a></dd>
						</dl>								
					</li>				
				</ul>
					 ';
			$panier='';
			$nom_cat='';
			
						
			for ( $i=0;$i<count($_SESSION['devis_trn']['id']);$i++ )	
			{	
				
				$descPiece = nl2br($_SESSION['devis_trn']['piece'][$i]);
				// pour le td ajouter class="align_left" pour ecrire au debut de colonne n'est pas au centre 
				
				$affich_cat='';
				$c=$my->req_arr('SELECT * FROM ttre_categories WHERE ordre='.$_SESSION['devis_trn']['or_cat'][$i].' ');
				if ( $nom_cat!=$c['titre'] )
				{
					$nom_cat=$c['titre'];
					$affich_cat='
							<tr style="background:#d6d6d6;">
								<td colspan="7">'.$nom_cat.'</td>
							</tr>
								';
				}
				
				$panier.='
						'.$affich_cat.'
						<tr>
							<td style="text-align:justify;">'.$descPiece.'</td>		
						</tr>
					';
			}	
			$contenu.='
				<div id="espace_compte">
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
						<tr class="entete">
							<td>Désignation</td>														
						</tr>		
						'.$panier.'
					</table><br /><br />
			
					<form name="devis" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
				
						<fieldset>
							<legend>Joindre des fichiers</legend>
							<p>
								<label for="ip_fich1">Fichier 1 : </label>
								<input id="ip_fich1" type="file" name="fichier1"  />
							</p>
							<p>
								<label for="ip_fich2">Fichier 2 : </label>
								<input id="ip_fich2" type="file" name="fichier2"  />
							</p>
							<p>
								<label for="ip_fich3">Fichier 3 : </label>
								<input id="ip_fich3" type="file" name="fichier3"  />
							</p>
							<p>
								<label for="ip_fich4">Fichier 4 : </label>
								<input id="ip_fich4" type="file" name="fichier4"  />
							</p>
							<p>
								<label for="ip_fich5">Fichier 5 : </label>
								<input id="ip_fich5" type="file" name="fichier5"  />
							</p>
						</fieldset>
				
						<p id="panier_boutons">
							<span class="panier_actions"><a class="panier_modifier" href="devis.php">Modifier mon panier</a></span>
							<span class="droit_actions"><a class="panier_modifier" href="espace_particulier.php">Modifier mon profil</a></span>
							<input type="submit" name="envoie_devis" value="Envoyer mon devis"  />
						 </p>
					</form>	
				</div>
				';	
				//			<input type="button" value="Envoyer mon devis" onclick="javascript:window.location=\'devis.php?contenu=envoyer\'" />
			echo'
				<br /><br />
				<div id="espace_compte">
					<div class="conteneur_ariane_cmd">
						<ul id="compte_ariane_cmd">
							<li class="done">1. <a href="devis.php">Ajouter au devis </a></li>
							<li class="done">2. <a href="devis.php?contenu=authentification">S\'identifier </a></li>
							<li class="done">3. <a href="devis.php?contenu=adresse">Adresse</a></li>
							<li class="courant">4. <a href="devis.php?contenu=recapitulatif">Récapitulatif</a></li>
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
		case 'envoyer' :
			echo'<br /><br /><br /><div id="note" class="notes"><p>Votre devis a bien été enregistré.</p></div>';
			unset($_SESSION['adresse_chantier_trn']);
			unset($_SESSION['devis_trn']);
			break;
	}
}
elseif ( isset($_SESSION['devis_trn']) )
{
	$panier='';
	$nom_cat='';
	
	for ( $i=0;$i<count($_SESSION['devis_trn']['id']);$i++ )	
	{	
		$descPiece = nl2br($_SESSION['devis_trn']['piece'][$i]);
		$clef = $_SESSION['devis_trn']['id_prod'][$i];
		
		$affich_cat='';
		$c=$my->req_arr('SELECT * FROM ttre_categories WHERE ordre='.$_SESSION['devis_trn']['or_cat'][$i].' ');
		if ( $nom_cat!=$c['titre'] )
		{
			$nom_cat=$c['titre'];
			$affich_cat='
					<tr style="background:#d6d6d6;">
						<td colspan="7">'.$nom_cat.'</td>
					</tr>
						';
		}
		
		$panier.='
				'.$affich_cat.'
				<tr>
					<td style="text-align:justify;">'.$descPiece.'</td>		
					<td><a href="devis.php?contenu=panier&action=supprimer&id='.$clef.'" title="Supprimer ce article de panier"><img src="stockage_img/supprimer.png" alt="Supprimer ce article de panier"/></a></td>
				</tr>
			';
	}	
	
	
	if ( isset($_GET['supprimer']) ) $alert='<div id="note" class="notes"><p>Produit supprimé avec succès.</p></div><br />';
	elseif ( isset($_GET['modifier']) ) $alert='<div id="note" class="notes"><p>Quantité mise à jour avec succès.</p></div><br />';
	else  $alert='<div id="note"></div><br />';
	
	echo'
		<br /><br />
		<div id="espace_compte">
			<div class="conteneur_ariane_cmd">
				<ul id="compte_ariane_cmd">
					<li class="courant">1. <a href="devis.php">Ajouter au devis </a></li>
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
					<td>Désignation</td>														
					<td></td>
				</tr>		
				'.$panier.'
			</table>
			<p id="panier_boutons">
				<span class="panier_actions"><a class="panier_vider" href="devis.php?contenu=panier&action=vider">Vider le panier</a></span>
				<input type="button" value="Poursuivre mon devis" onclick="javascript:window.location=\'devis.php?contenu=authentification\'" />
			</p>
		</form>
		</div>
		';	
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
	min-width:72px;
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	width:187px;
	padding-left:1px;
	padding-right:1px;
	-moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
	margin-bottom:10px;
	font-size:12px;
}

ul#menu_cat a{
	color: #fff;
	line-height: 40px;
}

ul#menu_cat a:hover{
	text-decoration: none;
}

ul#menu_cat li img{ margin-top:10px; height:30px;}
.classLiScat {
     cursor:pointer;
	float:left;
	height:80px;
	min-width:100px;
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	 -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
	font-size:12px;
	padding-left:1px;
	padding-right:1px;

}
.classLiScat img{ margin-top:10px; height:30px;}
</style>




										</div>
									</div>
								</div>
							</article>
						</div>
					</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>



