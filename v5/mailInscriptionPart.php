<?php

$messageInscription = '
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
		<p>Voici un mail automatique qui vous a été envoyé, celui-ci récapitule vos informations personnelles.</p> 
		<h2 style="background-color:#F6A20E; color:#FFF; font-size:16px; text-align:center;">Informations personnelles</h2>																
		<div id="adresse" style="background-color:#E6E6E6; font-size:14px; padding:10px;">
			<table>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Vous êtes : </td>
					<td style="width:400px;">'.$etes1.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Vous êtes : </td>
					<td style="width:400px;">'.$etes2.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Civilité : </td>
					<td style="width:400px;">'.$civ.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Nom : </td>
					<td style="width:400px;">'.$nom.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Prénom : </td>
					<td style="width:400px;">'.$prenom.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Téléphone : </td>
					<td style="width:400px;">'.$telephone.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Email : </td>
					<td style="width:400px;">'.$email.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Numéro et voie : </td>
					<td style="width:400px;">'.$numvoie.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">N° d\'appartement, Etage, Escalier : </td>
					<td style="width:400px;">'.$numapp.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Bâtiment, Résidence, Entrée : </td>
					<td style="width:400px;">'.$bat.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Code postal : </td>
					<td style="width:400px;">'.$cp.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Ville : </td>
					<td style="width:400px;">'.$ville.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Pays : </td>
					<td style="width:400px;">'.$pays.'</td>
				</tr>
				<tr>
					<td style="text-align: right;color:#941B80;width:400px;">Comment vous nous avez connus : </td>
					<td style="width:400px;">'.$connus.'</td>
				</tr>
			</table>
		</div>		
		<p>Veuillez cliquer sur le lien pour valider votre compte : <br /> <a href="'.$url_site_client.'/espace_particulier.php?contenu=valider&ref='.$referenceValid.'">Validation du compte</a></p>
		<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
			<p style="padding-top:10px;">Merci d\'avoir choisi notre site</p>											
		</div>
	</div>
</body>
</html>
';

$message = $messageInscription;
$sujet = $nom_client.' : Inscription';
$headers = "From: \" ".$nom." ".$prenom." \"<".$email.">\n";
$headers .= "Reply-To: ".$mail_client."\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
mail($email,$sujet,$message,$headers);
?>
