<?php
session_start();
require('mysql.php');$my=new mysql();

if ( isset($_GET['newsletter']) && $_GET['newsletter']=='desinscrit' )
{
	$my->req('DELETE FROM ttre_inscrits_newsletters WHERE email="'.$_GET['email'].'"');
}

if ( isset($_POST['envoyer_form']) )
{
	if ( md5($_POST['validation']) != $_SESSION['valeur_image'] )
	{
		header("location:devis.php?erreur=validation");exit;
	}
	else
	{
		$civ=$_POST['civ'];
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$telephone=$_POST['telephone'];
		$cp=$_POST['cp'];
		$ville=$_POST['ville'];
		$pays=$_POST['pays'];
		$mail=$_POST['mail'];
		$titre=$_POST['titre'];
		$message=$_POST['message'];
		
		$message = '
				<html>
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>TOUSRENOV</title>
					</head>
							
					<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
						<div id="corps" style="margin:0 auto; width:800px; height:auto;">
							<center><img src="'.$logo_client.'" /></center><br />
							<h1 style="background-color:#687189; color:#FFF; font-size:16px; text-align:center;">TOUSRENOV</h1>
		
							<p>Bonjour,</p>
		
							<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Informations personnelles</h2>
							<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
								<table>
									<tr>
										<td style="text-align: right;color:#941B80;">Civilité : </td>
										<td>'.$civ.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Nom : </td>
										<td>'.$nom.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Prénom : </td>
										<td>'.$prenom.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Téléphone : </td>
										<td>'.$telephone.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Code postal : </td>
										<td>'.$cp.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Ville : </td>
										<td>'.$ville.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Pays : </td>
										<td>'.$pays.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Email : </td>
										<td>'.$mail.'</td>
									</tr>
								</table>
							</div>
												
							<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Message</h2>
							<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
								<table>
									<tr>
										<td style="text-align: right;color:#941B80;">Titre : </td>
										<td>'.$titre.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Message : </td>
										<td>'.nl2br($message).'</td>
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
		
		$sujet='Contact - '.$titre.' ';
		$mail_reply = $mail;
		//$mail_client = 'bilelbadri@gmail.com';
		$mail_client = 'contact@tousrenov.fr';
		
		$headers = "From: \" ".$nom." \"<".$mail_client.">\n";
		$headers .= "Reply-To: ".$mail_reply."\n";
		$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
		mail($mail_client,$sujet,$message,$headers);
			
		header("location:contact.php?envoie=ok");exit;
	}
}

$pageTitle = "Contacter nous"; 

include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
					<div class="header-page">
						<div class="container">
							<div class="row">
								<h2 class="page-title">Contacter Nous</h2>
							</div>
						</div>
						
					</div>

					<div id="content">
						<div class="container">
							<div class="row">

<script type="text/javascript">
$(document).ready(function() {								

	$('form[name="contact"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.nom.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom.value) ) { mes_erreur+='<p>Il faut entrer le champ Prénom !</p>'; }
		if( !$.trim(this.telephone.value) ) { mes_erreur+='<p>Il faut entrer le champ Téléphone !</p>'; }
		if( !$.trim(this.cp.value) ) { mes_erreur+='<p>Il faut entrer le champ Code postal !</p>'; }
		if( $.trim(this.ville.value)==0 ) { mes_erreur+='<p>Il faut entrer le champ Ville !</p>'; }
		if( !$.trim(this.mail.value) ) { mes_erreur+='<p>Il faut entrer le champ Adresse mail !</p>'; }
		else { var exp=new RegExp('^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$');
			if(!exp.test($.trim(this.mail.value))) { mes_erreur+='<p>Votre Adresse mail est incorrect !</p>'; } }
		if( !$.trim(this.titre.value) ) { mes_erreur+='<p>Il faut entrer le champ Titre !</p>'; }
		if( !$.trim(this.message.value) ) { mes_erreur+='<p>Il faut entrer le champ Message !</p>'; }
		if( !$.trim(this.validation.value) ) { mes_erreur+='<p>Il faut entrer le champ code de validation !</p>'; }
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
$alert='<div id="note"></div><br />';
if ( isset($_GET['erreur']) ) $alert='<div id="note" class="error"><p>Le code de validation est erroné.</p></div><br />';
if ( isset($_GET['envoie']) ) $alert='<div id="note" class="success"><p>Le message a bien été envoyé.</p></div><br />';
if ( isset($_GET['newsletter']) ) $alert='<div id="note" class="success"><p>Vous �tes d�sincrit � la newsletter.</p></div><br />';
	
echo'
	'.$alert.'
								<div class="contact-form col-md-12">
									<form name="contact" method="post" enctype="multipart/form-data" class="">
									<div class="col-md-4">
										<div class="form-groupe-left">										
											<label for="ip_civ">Civilit&eacute; : <span class="obli">*</span></label>
											<input type="radio" value="Mr" id="ip_civ" name="civ" checked="checked" /> Mr
											<input type="radio" value="Mme" id="ip_civ" name="civ" /> Mme
											<input type="radio" value="Mlle" id="ip_civ" name="civ"  /> Mlle<br />
<!-- <label for="ip_nom">Nom : <span class="obli">*</span></label> -->
											<div class="last-first-name">
												<input id="ip_nom" type="text" name="nom" placeholder="Votre Nom"/>
												<input id="ip_prenom" type="text" name="prenom" placeholder="Votre Pr&eacute;nom"/><br />
											</div>
											<div class="perso-info">
												<input id="ip_tel" type="text" name="telephone" placeholder="T&eacute;l&eacute;phone"/><br />
												<input id="ip_cp" type="text" name="cp" placeholder="Code Postal"/><br />
												<input id="ip_ville" type="text" name="ville" placeholder="Ville"/><br />
												<input id="ip_pays" type="text" name="pays" value="France" placeholder="Pays"/><br />
												<input id="ip_mail" type="text" name="mail" value="" placeholder="Votre E-mail"/><br />									
											</div>

										</div>
									</div>

									<div class="col-md-8">
										<div class="form-groupe-right">
											<input id="ip_titre" type="text" name="titre" value="" placeholder="Sujet"/><br />
											<textarea id="ip_desc" name="message" placeholder="Message"></textarea><br />
											<div class="validation">
												<label for="validation">Veuillez recopier le code <img src="Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
												<input id="validation" type="text" name="validation" /><br/>
												<input value="VALIDER" class="sub" type="submit" name="envoyer_form"/>
											</div>
										</div>
									</div>
									</form>
								</div>
	';
?>
							</div>
						</div>
					</div>
						<section id="references" class="references-section">
							<div class="container">
								<div class="row">
									<div class="col-md-12">

										<div class="title-block">
											<h2>Partenaires</h2>
											<!-- <img src="'.$photo.'" alt="'.$res['titre'].'"> -->
										</div>
										<?php 
										$req = $my->req('SELECT * FROM ttre_diaporama ');
										if ( $my->num($req)>0 )
										{
											echo'<div id="clients-logos">';
											while ( $res=$my->arr($req) )
											{
												$photo='upload/diaporamas/_no_2.jpg';
												if ( !empty($res['photo']) ) $photo='upload/diaporamas/150X150/'.$res['photo'];
												echo'
													<div class="item"><a target="_blanc" href="'.$res['lien'].'"><img src="'.$photo.'" alt="'.$res['titre'].'"/></a></div>
													';
											}
											echo'</div>';
										}
										?>	
										</div>
								</div>
							</div>
						</section> 
				</div>	

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>

<?php include('inc/pied.php');?>
	</body>
</html>
