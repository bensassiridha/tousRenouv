<?php
$my = new mysql();
if ( !empty($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'envoyer' :	
			$tempo=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$_POST['id'].' ');
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
			rediriger('?contenu=pro_liste&envoyer=ok');						
			break;
		case 'supprimer' :	
			$my->req('DELETE FROM ttre_client_pro WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_pro_generation_pass WHERE cgp_client_id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_pro_categories WHERE id_client='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_pro_departements WHERE id_client='.$_GET['id'].' ');
			rediriger('?contenu=pro_liste&supprimer=ok');						
			break;
		case 'valid' :
			$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id="'.$_GET['id'].'"');
			$my->req('UPDATE ttre_client_pro SET stat_valid="'.!$temp['stat_valid'].'" WHERE id="'.$_GET['id'].'"');
			rediriger('?contenu=pro_liste&modifier=ok');
			exit;
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des clients</h1>';
	if ( isset($_GET['supprimer']) ) echo'<div class="success"><p>Ce client a bien été supprimé.</p></div>';
	elseif ( isset($_GET['envoyer']) ) echo'<div class="success"><p>Le message a bien été envoyé.</p></div>';
	elseif ( isset($_GET['modifier']) ) echo'<div class="success"><p>Le statut de ce client a bien été modifié.</p></div>';
	$req = $my->req('SELECT * FROM ttre_client_pro ORDER BY id DESC');
	if ( $my->num($req)>0 )
	{
		$various='';
		echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td class="bouton">Note</td>
					<td class="bouton">Détail</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Supprimer</td>
				</tr>';
		while ( $res=$my->arr($req) )
		{
			$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$res['ville'].'" ');
			$fichier1='---';
			if ( !empty($res['fichier1']) ) $fichier1='<a href="../upload/client_pro/fichiers/'.$res['fichier1'].'" target="_blanc">'.$res['fichier1'].'</a>';
			$fichier2='---';
			if ( !empty($res['fichier2']) ) $fichier2='<a href="../upload/client_pro/fichiers/'.$res['fichier2'].'" target="_blanc">'.$res['fichier2'].'</a>';
			$fichier3='---';
			if ( !empty($res['fichier3']) ) $fichier3='<a href="../upload/client_pro/fichiers/'.$res['fichier3'].'" target="_blanc">'.$res['fichier3'].'</a>';
			$catego='---';
			$reqCat=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id'].' ORDER BY id ASC');
			if ( $my->num($reqCat)>0 )
			{
				$catego='';
				while ( $resCat=$my->arr($reqCat) ) 
				{
					$res_categorie=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$resCat['id_categorie'].' ');
					$catego.=$res_categorie['titre'].', ';
				}
			}
			$depart='---';
			$reqCat=$my->req('SELECT * FROM ttre_client_pro_departements WHERE id_client='.$res['id'].' ORDER BY id ASC');
			if ( $my->num($reqCat)>0 )
			{
				$depart='';
				while ( $resCat=$my->arr($reqCat) ) 
				{
					$res_categorie=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$resCat['id_departement'].' ');
					$depart.=$res_categorie['departement_nom'].', ';
				}
			}
			$various.='
					<div style="display: none;">
						<div id="inline'.$res['id'].'" style="width:720px;overflow:auto;">
							<div id="espace_compte" style="width:700px;">
								<p><strong>Forme juridique : </strong> '.ucfirst(html_entity_decode($res['juridique'])).'</p>
								<p><strong>Raison sociale : </strong> '.ucfirst(html_entity_decode($res['raison'])).'</p>
								<p><strong>Taille de l\'entreprise : </strong> '.ucfirst(html_entity_decode($res['taille'])).'</p>
								<p><strong>Numéro et voie : </strong> '.html_entity_decode($res['num_voie']).'</p>
								<p><strong>Complèment d\'adresse : </strong> '.ucfirst(html_entity_decode($res['cadresse'])).'</p>
								<p><strong>Code postal : </strong> '.html_entity_decode($res['code_postal']).'</p>
								<p><strong>Ville : </strong> '.html_entity_decode($res_ville['ville_nom_reel']).'</p>
								<p><strong>Pays : </strong> '.html_entity_decode($res['pays']).'</p>
								<p><strong>Numéro de SIREEN : </strong> '.html_entity_decode($res['num_sireen']).'</p>
								<p><strong>Civilité : </strong> '.ucfirst(html_entity_decode($res['civ'])).'</p>
								<p><strong>Nom : </strong> '.ucfirst(html_entity_decode($res['nom'])).'</p>
								<p><strong>Prénom : </strong> '.ucfirst(html_entity_decode($res['prenom'])).'</p>
								<p><strong>Téléphone : </strong> '.html_entity_decode($res['telephone']).'</p>
								<p><strong>Fax : </strong> '.html_entity_decode($res['fax']).'</p>
								<p><strong>Email : </strong> '.html_entity_decode($res['email']).'</p>
								<p><strong>Téléchargement de justificatifs K bis : </strong> '.$fichier1.'</p>
								<p><strong>Téléchargement d\'assurance décennal : </strong> '.$fichier2.'</p>
								<p><strong>Autre documents : </strong> '.$fichier3.'</p>
								<p><strong>Votre activité : </strong> '.$catego.'</p>
								<p><strong>Zone d\'intervention : </strong> '.$depart.'</p>
										
										
								<div style="border: 1px solid #000000;margin: 35px 0 0 175px;padding: 15px;width: 300px;">
									<form method="POST" action="?contenu=pro_liste&action=envoyer" >
										<p>Contenu mail : <textarea name="message" ></textarea><br /><br /></p>
										<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
										<p><input type="submit" value="Envoyer" style="margin:0 0 0 110px;"/></p>
									</form>
								</div>

												
							</div>
						</div>
					</div>
						';	
			$nbr_devis=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
			$detail_note1='<p>Nombre de devis : '.$nbr_devis.' </p>';
			$detail_note='';
			for ( $i=1;$i<=20;$i++ )
			{
				$nbr=$my->num($my->req('SELECT * FROM ttre_devis D , ttre_devis_client_pro C WHERE D.id=C.id_devis AND D.note_devis='.$i.' AND C.id_client_pro='.$res['id'].' AND C.statut_enchere=1 '));
				$stylenote='';
				$detail_note.='<p>'.$i.' / 20 : '.$nbr.' devis.</p>';
			}
			$various.='
					<div style="display: none;">
						<div id="inlinenote'.$res['id'].'" style="width:200px;overflow:auto;">
							'.$detail_note1.'
							'.$detail_note.'
						</div>
					</div>
					  ';
			
			if ( $res['stat_valid']==1 ) 
				$a_valid = '<a href="?contenu=pro_liste&action=valid&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
			else	
				$a_valid = '<a href="?contenu=pro_liste&action=valid&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
			
			echo'
				<tr>
					<td class="nom_prod">'.strtoupper(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</td>
					<td class="bouton"><a class="various1" href="#inlinenote'.$res['id'].'" title="Note"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
					<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce client ?\')) 
						{window.location=\'?contenu=pro_liste&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
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