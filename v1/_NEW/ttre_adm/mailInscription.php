<?php

$messageInscription = '
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Vert Désir</title>
</head>
									
	<body style="background:white; margin:10px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#000; font-size:14px;">
					
					<div id="corps" style="margin:0 auto; width:800px; height:auto;">
						<h1 style="background-color:#4C8C23; color:#FFF; font-size:16px; text-align:center;">Compte Vert Désir</h1>
								
						<p>Bonjour,</p>																
						<p>Voici un mail automatique qui vous a été envoyé, celui-ci récapitule vos informations personnelles, votre adresse. Si vous remarquez une erreur veillez à modifier vos informations personnelles directement depuis votre compte. <a href="'.$url_site_client.'/compte.php">Mon compte.</a></p>																
																						
						<h2 style="background-color:#4C8C23; color:#FFF; font-size:16px; text-align:center;">Informations personnelles</h2>																
						<div id="adresse" style="background-color:#E6E6E6; text-align:center; font-size:14px; padding:10px;">
									<table>
										<tr>
											<td>Nom : </td>
											<td>'.$nom.'</td>
										</tr>
										<tr>
											<td>Prénom : </td>
											<td>'.$prenom.'</td>
										</tr>
										<tr>
											<td>Adresse mail : </td>
											<td>'.$email.'</td>
										</tr>
										<tr>
											<td>Mots de passe : </td>
											<td>********</td>
										</tr>
										<tr>
											<td>Téléphone : </td>
											<td>'.$telephone.'</td>
										</tr>
										<tr>
											<td>Adresse : </td>
											<td>'.$adresse.'</td>
										</tr>
										<tr>
											<td>Ville : </td>
											<td>'.$codePostal.' '.$ville.'</td>
										</tr>
										
									</table>
						</div>		
						<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
								<p style="padding-top:10px;">
									Vous pouvez dès maintenant connecter sur notre site avec vos identifiants.
								<br />
									Merci d\'avoir choisi notre site <br />												
								</p>											
						</div>
				</div>
	</body>
</html>
';

$message = $messageInscription;

$Destinataire = $email;
$Sujet = "Inscription - ".$nom_client;

$From  = "From:Vert Desir\n";
$From .= "MIME-version: 1.0\n";
$From .= "Content-type: text/html; charset= iso-8859-1\n";

mail($Destinataire,$Sujet,$message,$From);
?>
