<?php
$my = new mysql();
if ( !empty($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'envoyer' :
			$tempo=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$_POST['id'].' ');
			$nom=$tempo['nom'];$mail=$tempo['email'];
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
						<p>'.$nom.'</p>
						<p>'.$_POST['message'].'</p>
						<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
							<p style="padding-top:10px;">'.$nom_client.'</p>
						</div>
					</div>
				</body>
				</html>
				';
			//$mail_client='bilelbadri@gmail.com';
			$sujet = $nom_client.' : Info ';
			$headers = "From: \" ".$nom." \"<".$mail.">\n";
			$headers .= "Reply-To: ".$mail_client."\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			mail($mail,$sujet,$message,$headers);
			rediriger('?contenu=part_liste&envoyer=ok');
			break;
		case 'supprimer' :	
			$my->req('DELETE FROM ttre_client_part WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_part_generation_pass WHERE cgp_client_id='.$_GET['id'].' ');
			rediriger('?contenu=part_liste&supprimer=ok');						
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des clients</h1>';
	if ( isset($_GET['supprimer']) ) echo'<div class="success"><p>Ce client a bien été supprimé.</p></div>';
	elseif ( isset($_GET['envoyer']) ) echo'<div class="success"><p>Le message a bien été envoyé.</p></div>';
	$req = $my->req('SELECT * FROM ttre_client_part ORDER BY id DESC');
	if ( $my->num($req)>0 )
	{
		$various='';
		echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td class="bouton">Détail</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Supprimer</td>
				</tr>';
		while ( $res=$my->arr($req) )
		{
			$p_etes1_autre='';
			if ( $res['etes1']==$my->net_input('Autre') ) $p_etes1_autre='<p><strong>Precisez : </strong> '.ucfirst(html_entity_decode($res['precisez1'])).'</p>'; 
			$p_connus_autre='';
			if ( $res['connus']==$my->net_input('Autre') ) $p_connus_autre='<p><strong>Precisez : </strong> '.ucfirst(html_entity_decode($res['precisez2'])).'</p>'; 
			$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
			$various.='
					<div style="display: none;">
						<div id="inline'.$res['id'].'" style="width:400px;overflow:auto;">
							<div id="espace_compte" style="width:300px;">
								<p><strong>Vous êtes : </strong> '.ucfirst(html_entity_decode($res['etes1'])).'</p>
								'.$p_etes1_autre.'
								<p><strong>Vous êtes : </strong> '.ucfirst(html_entity_decode($res['etes2'])).'</p>
								<p><strong>Civilité : </strong> '.ucfirst(html_entity_decode($res['civ'])).'</p>
								<p><strong>Nom : </strong> '.ucfirst(html_entity_decode($res['nom'])).'</p>
								<p><strong>Prénom : </strong> '.ucfirst(html_entity_decode($res['prenom'])).'</p>
								<p><strong>Téléphone : </strong> '.html_entity_decode($res['telephone']).'</p>
								<p><strong>Email : </strong> '.html_entity_decode($res['email']).'</p>
								<p><strong>Numéro et voie : </strong> '.html_entity_decode($res['num_voie']).'</p>
								<p><strong>N° d\'appartement, Etage, Escalier : </strong> '.html_entity_decode($res['num_appart']).'</p>
								<p><strong>Bâtiment, Résidence, Entrée : </strong> '.html_entity_decode($res['batiment']).'</p>
								<p><strong>Code postal : </strong> '.html_entity_decode($res['code_postal']).'</p>
								<p><strong>Ville : </strong> '.html_entity_decode($res_ville['ville_nom_reel']).'</p>
								<p><strong>Pays : </strong> '.html_entity_decode($res['pays']).'</p>
								<p><strong>Comment vous nous avez connus : </strong> '.html_entity_decode($res['connus']).'</p>
								'.$p_connus_autre.'
										
								<div style="border: 1px solid #000000;margin: 35px 0 0 10px;padding: 15px;width: 300px;">
									<form method="POST" action="?contenu=part_liste&action=envoyer" >
										<p>Contenu mail : <textarea name="message" ></textarea><br /><br /></p>
										<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
										<p><input type="submit" value="Envoyer" style="margin:0 0 0 110px;"/></p>
									</form>
								</div>
												
							</div>
						</div>
					</div>
						';
			if ( $res['stat_valid']==1 ) 
				$a_valid = '<a title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
			else	
				$a_valid = '<a title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
				
			echo'
				<tr>
					<td class="nom_prod">'.strtoupper(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</td>
					<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce client ?\')) 
						{window.location=\'?contenu=part_liste&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'</table>'.$various;
	}
	else
	{
		echo'<p> Pas clients ...</p>';
	}
}	
?>
<script type="text/javascript">
$(document).ready(function() {
	$(".various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
});
</script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.1.css" media="screen" />