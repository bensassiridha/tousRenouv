<?php
$tempp=$my->req_arr('SELECT * FROM ttre_devis_client_pro WHERE id_devis='.$id_devis.' AND statut_enchere=1 ');
$temppp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$tempp['id_client_pro'].' ');
$nom=$temppp['nom'];$mail=$temppp['email'];

$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$id_adresse.' ');
$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
$batiment = ucfirst(html_entity_decode($temp['batiment']));
$code_postal = $temp['code_postal'];
$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
$pays = ucfirst(html_entity_decode($temp['pays']));

$res = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$id_client_part.' ');

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
				<p>'.$nom.'</p>
				<p>Votre payement a bien été effectué. </p>
				<p>Vous pouvez consultez le detail de devis sur votre compte professionnel.</p>
				<p>Voilà le détail de chantier :</p>
						
						<h4>Adresse de chantier</h4>
						<dl>
							<dd>Numero et voie : '.$num_voie.'</dd>
							<dd>N° d’appartement : '.$num_appart.'</dd>
							<dd>Bâtiment : '.$batiment.'</dd>
							<dd>'.$code_postal.' '.$ville.'</dd>
							<dd>'.$pays.'</dd>
						</dl>

						<h4>Information client</h4>	
						<dl>					
							<dd>Civilité : '.ucfirst(html_entity_decode($res['civ'])).'</dd>
							<dd>Nom : '.ucfirst(html_entity_decode($res['nom'])).'</dd>
							<dd>Prénom : '.ucfirst(html_entity_decode($res['prenom'])).'</dd>
							<dd>Téléphone : '.html_entity_decode($res['telephone']).'</dd>
							<dd>Email : '.html_entity_decode($res['email']).'</dd>
							<dd>Numéro et voie : '.html_entity_decode($res['num_voie']).'</dd>
							<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($res['num_appart']).'</dd>
							<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($res['batiment']).'</dd>
							<dd>Code postal : '.html_entity_decode($res['code_postal']).'</dd>
							<dd>Ville : '.html_entity_decode($res_ville['ville_nom_reel']).'</dd>
							<dd>Pays : '.html_entity_decode($res['pays']).'</dd>			
						</dl>
											
				<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
					<p style="padding-top:10px;">'.$nom_client.'</p>
				</div>
			</div>
		</body>
		</html>
		';
//$mail_client='bilelbadri@gmail.com';
//$mail='bilelbadri@gmail.com';
//$nom='dd';
//$message='<p>bingo</p>';
$sujet = $nom_client.' : Adresse chantier';
$headers = "From: \" ".$nom." \"<".$mail.">\n";
$headers .= "Reply-To: ".$mail_client."\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
mail($mail,$sujet,$message,$headers);
?>
