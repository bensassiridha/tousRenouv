<?php
session_start();
require('mysql.php');$my=new mysql();




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
						<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
						<title>TOUSRENOV</title>
					</head>
							
					<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
						<div id="corps" style="margin:0 auto; width:800px; height:auto;">
							<center><img src="http://creation-site-web-tunisie.net/trn/images/logo.png" /></center><br />
							<h1 style="background-color:#687189; color:#FFF; font-size:16px; text-align:center;">TOUSRENOV</h1>
		
							<p>Bonjour,</p>
		
							<h2 style="background-color:#0495CB; color:#FFF; font-size:16px; text-align:center;">Informations personnelles</h2>
							<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
								<table>
									<tr>
										<td style="text-align: right;color:#941B80;">Civilit� : </td>
										<td>'.$civ.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Nom : </td>
										<td>'.$nom.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">Pr�nom : </td>
										<td>'.$prenom.'</td>
									</tr>
									<tr>
										<td style="text-align: right;color:#941B80;">T�l�phone : </td>
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
		$mail_client = 'contact@liweb-agency.net';
		
		$headers = "From: \" ".$nom." \"<".$mail_client.">\n";
		$headers .= "Reply-To: ".$mail_reply."\n";
		$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
		mail($mail_client,$sujet,$message,$headers);
			
		header("location:contact.php?envoie=ok");exit;
	}
}









include('inc/head.php');?>
	<body id="page1">
		<div class="extra">
			<div class="main">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
				<section id="content">
					<div class="wrapper">
						<article class="col-1">
							<div class="indent-left">
								<h2>Contact</h2>










<script type="text/javascript">
$(document).ready(function() {								

	$('form[name="contact"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.nom.value) ) { mes_erreur+='<p>Il faut entrer le champ Nom !</p>'; }
		if( !$.trim(this.prenom.value) ) { mes_erreur+='<p>Il faut entrer le champ Pr�nom !</p>'; }
		if( !$.trim(this.telephone.value) ) { mes_erreur+='<p>Il faut entrer le champ T�l�phone !</p>'; }
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
if ( isset($_GET['erreur']) ) $alert='<div id="note" class="error"><p>Le code de validation est erron�.</p></div><br />';
if ( isset($_GET['envoie']) ) $alert='<div id="note" class="success"><p>Le message a bien �t� envoy�.</p></div><br />';
	
echo'
	'.$alert.'
	<div id="espace_compte" style="margin: 0 0 0 100px;">
		<form name="contact" method="post" enctype="multipart/form-data" class="tpl_form_defaut intitules_moyens champs_larges">
		<fieldset>
			<legend>Informations personnelles</legend>
			<p>
				<label for="ip_civ">Civilit� : <span class="obli">*</span></label>
				<input id="ip_civ" type="radio" value="Mr" name="civ" checked="checked" /> Mr
				<input id="ip_civ" type="radio" value="Mme" name="civ"/> Mme
				<input id="ip_civ" type="radio" value="Mlle" name="civ"/> Mlle
			</p>
			<p>
				<label for="ip_nom">Nom : <span class="obli">*</span></label>
				<input id="ip_nom" type="text" name="nom"/>
			</p>
			<p>
				<label for="ip_prenom">Pr�nom : <span class="obli">*</span></label>
				<input id="ip_prenom" type="text" name="prenom"/>
			</p>
			<p>
				<label for="ip_tel">T�l�phone : <span class="obli">*</span></label>
				<input id="ip_tel" type="text" name="telephone"/>
			</p>
			<p>
				<label for="ip_cp">Code postal : <span class="obli">*</span></label>
				<input id="ip_cp" type="text" name="cp" onKeyPress="return scanTouche(event)"/>
			</p>
			<p>
				<label for="ip_ville">Ville : <span class="obli">*</span></label>
				<input id="ip_ville" type="text" name="ville" />
			</p>
			<p>
				<label for="ip_pays">Pays : <span class="obli">*</span></label>
				<input id="ip_pays" type="text" name="pays" value="France" readonly="readonly" />
			</p>
			<p>
				<label for="ip_mail">Email : <span class="obli">*</span></label>
				<input id="ip_mail" type="text" name="mail"  />
			</p>
		</fieldset>
		<fieldset>
			<legend>Message</legend>
			<p>
				<label for="ip_titre">Titre : <span class="obli">*</span></label>
				<input id="ip_titre" type="text" name="titre"  />
			</p>
			<p>
				<label for="ip_desc">Message : <span class="obli">*</span></label>
				<textarea id="ip_desc" type="text" name="message" style="height:50px;" ></textarea>
			</p>
		</fieldset>
		<fieldset>
			<legend>Validation</legend>
			<p>
				<label for="validation">Veuillez recopier le code <img src="Captcha/validation.php" alt="Captcha"  class="captcha"/><span class="obli">*</span></label>
				<input id="validation" type="text" name="validation" />
			</p>

			<p class="align_center padding_tb_20">
				<input value="valider" class="sub" type="submit" name="envoyer_form"/>
			</p>
			<p class="note" id="text_erreur"><cite>( * ) champs obligatoires.</cite></p>
		</fieldset>

		</form>
	</div>
	';
?>









































</div>
						</article>
<?php include('inc/droite.php');?>
						</div>
					<div class="block"></div>
				</section>
			</div>
		</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>