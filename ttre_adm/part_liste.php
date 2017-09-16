<?php
$my = new mysql();

$tab_civ=array('Mr'=>'Mr','Mme'=>'Mme','Mlle'=>'Mlle');
$tab_etes1=array(0=>'',
		1=>'Particulier',
		2=>'Société',
		3=>'Commercant',
		4=>'Industriel',
		5=>'Libèral',
		6=>'Syndic',
		7=>'Promoteur',
		8=>'Administration',
		9=>'Association',
		10=>'Architecte',
		11=>'Agence immobilier',
		12=>'Autre');
$tab_etes2=array(0=>'',
		1=>'Propriétaire',
		2=>'Locataire');
$tab_connus=array(0=>'',
		1=>'Journal',
		2=>'Radio',
		3=>'Télévision',
		4=>'Internet',
		5=>'Bouche à orellle',
		6=>'Adresse',
		7=>'Autre');

if ( !empty($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'envoyer' :
			$tempo=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$_POST['id'].' ');
			$nom=$tempo['nom'];$mail=$tempo['email'];
			$message_html = '
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
			/*$sujet = $nom_client.' : Info ';
			$headers = "From: \" ".$nom." \"<".$mail.">\n";
			$headers .= "Reply-To: ".$mail_client."\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			mail($mail,$sujet,$message,$headers);*/
			
			$destinataire=$mail;
			//$destinataire='bilelbadri@gmail.com';
			$mail_client='contact@tousrenov.fr';
			$email_expediteur=$mail_client;
			$email_reply=$mail_client;
			$titre_mail=$nom_client;
			$sujet=$nom_client.' : Info ';
				
			$frontiere = '-----=' . md5(uniqid(mt_rand()));
			$headers = 'From: "'.$titre_mail.'" <'.$email_reply.'> '."\n";
			$headers .= 'Return-Path: <'.$email_reply.'>'."\n";
			$headers .= 'MIME-Version: 1.0'."\n";
			$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
				
			$message = '';
			$message .= '--'.$frontiere."\n";
			$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
			$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
				
			$message .= $message_html."\n\n";
				
			// Pièce jointe
			$fileatt = $_FILES['fichier']['tmp_name'];
			$fileatt_name = $_FILES['fichier']['name'];
			if (file_exists($fileatt))
			{
				$file_type = filetype($fileatt);
				$file_size = filesize($fileatt);
					
				$handle = fopen($fileatt, 'r'); // or die('File '.$fileatt_name.'can t be open');
				$content = fread($handle, $file_size);
				$content = chunk_split(base64_encode($content));
				$f = fclose($handle);
					
				$message .= '--'.$frontiere."\r\n";
				$message .= 'Content-Type:'.$file_type.'; name='.$fileatt_name."\r\n";
				$message .= 'Content-Transfer-Encoding: base64'."\r\n";
				$message .= 'Content-Disposition: attachment; filename='.$fileatt_name." \n";
				$message .= $content."\r\n";
			}
			// Fin
				
			$message .= '--'.$frontiere.'--'."\r\n";
				
			mail($destinataire,$sujet,$message,$headers);
				
			
			rediriger('?contenu=part_liste&envoyer=ok');
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$my->req('UPDATE ttre_client_part SET
									etes1			=	"'.$my->net_input($tab_etes1[$_POST['etes1']]).'" ,
									etes2			=	"'.$my->net_input($tab_etes2[$_POST['etes2']]).'" ,
									civ				=	"'.$my->net_input($_POST['civ']).'" ,
									nom				=	"'.$my->net_input($_POST['nom']).'" ,
									prenom			=	"'.$my->net_input($_POST['prenom']).'" ,
									telephone		=	"'.$my->net_input($_POST['tel']).'" ,
									email			=	"'.$my->net_input($_POST['email']).'" ,
									num_voie		=	"'.$my->net_input($_POST['voie']).'" ,
									num_appart		=	"'.$my->net_input($_POST['app']).'" ,
									batiment		=	"'.$my->net_input($_POST['bat']).'" ,
									code_postal		=	"'.$my->net_input($_POST['cp']).'" ,
									ville			=	"'.$my->net_input($_POST['ville']).'" ,
									connus			=	"'.$my->net_input($tab_connus[$_POST['connus']]).'" 
								WHERE id = '.$_GET['id'].' ');
				if ( isset($_POST['newsletter']) )
				{
					$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_part WHERE email="'.$_POST['email'].'" ');
					if ( $my->num($req_news)==0 ) $my->req("INSERT INTO ttre_inscrits_newsletters_part VALUES('','".$my->net_input($_POST['email'])."') ");
				}
				else
				{
					$my->req('DELETE FROM ttre_inscrits_newsletters_part WHERE email="'.$_POST['email'].'" ');
				}
				if ( isset($_POST['partenaire']) )
				{
					$req_part=$my->req('SELECT * FROM ttre_inscrits_partenaires WHERE email="'.$_POST['email'].'" ');
					if ( $my->num($req_part)==0 ) $my->req("INSERT INTO ttre_inscrits_partenaires VALUES('','".$my->net_input($_POST['email'])."') ");
				}
				else
				{
					$my->req('DELETE FROM ttre_inscrits_partenaires WHERE email="'.$_POST['email'].'" ');
				}
				rediriger('?contenu=part_liste&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Ce client a bien été modifié.</p></div>';
				else $alert='<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$_GET['id'].' ');
				foreach($tab_etes1 as $cle => $value) if( $my->net_input($value) == $temp['etes1']) $cle1=$cle;
				foreach($tab_etes2 as $cle => $value) if( $my->net_input($value) == $temp['etes2']) $cle2=$cle;
				foreach($tab_connus as $cle => $value) if( $my->net_input($value) == $temp['connus']) $cle3=$cle;
				if ( ($temp['code_postal']>=75001 && $temp['code_postal']<=75020) || $temp['code_postal']==75116 )
				{
					$res=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal=75001 ');
					$tab_ville[$res['ville_id']]=$res['ville_nom_reel'];
				}
				else
				{
					$option='';
					$req=$my->req('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$temp['code_postal'].' ORDER BY ville_id ASC');
					if ( $my->num($req)>0 )
					{
						while ( $res=$my->arr($req) )
						{
							$tab_ville[$res['ville_id']]=$res['ville_nom_reel'];
						}
					}
				}
				$req_part=$my->req('SELECT * FROM ttre_inscrits_partenaires WHERE email="'.$temp['email'].'" ');
				if ( $my->num($req_part)==0 ) $part_check=0; else $part_check=1;
				$req_news=$my->req('SELECT * FROM ttre_inscrits_newsletters_part WHERE email="'.$temp['email'].'" ');
				if ( $my->num($req_news)==0 ) $news_check=0; else $news_check=1;
				
				$form = new formulaire('modele_1','?contenu=part_liste&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier client :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->select_cu('Vous êtes','etes1',$tab_etes1,$cle1);
				$form->select_cu('Vous êtes','etes2',$tab_etes2,$cle2);
				$form->radio_cu('Civilité','civ',$tab_civ,$temp['civ']);
				$form->text('Nom','nom','',1,$temp['nom']);
				$form->text('Prénom','prenom','',1,$temp['prenom']);
				$form->text('Téléphone','tel','',1,$temp['telephone']);
				$form->text('Email','email','',1,$temp['email']);
				$form->text('Numéro et voie','voie','',1,$temp['num_voie']);
				$form->text('N° d\'appartement, Etage, Escalier','app','',1,$temp['num_appart']);
				$form->text('Bâtiment, Résidence, Entrée','bat','',1,$temp['batiment']);
				$form->text('Code Postal','cp','',1,$temp['code_postal']);
				$form->select_cu('Ville','ville',$tab_ville,$temp['ville']);
				$form->select_cu('Comment vous nous avez connus','connus',$tab_connus,$cle3);
				$form->check('Partenaire','partenaire',1,'Acceptation de recevoir offres partenaire',$part_check);
				$form->check('Newsletter','newsletter',1,'S\'inscrire à notre newsletter',$news_check);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=part_liste">Retour</a></p>';
			}
			break;
		case 'supprimer' :	
			$my->req('DELETE FROM ttre_client_part WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_part_generation_pass WHERE cgp_client_id='.$_GET['id'].' ');
			rediriger('?contenu=part_liste&supprimer=ok');						
			break;
		case 'valid' :
			$temp=$my->req_arr('SELECT * FROM ttre_client_part WHERE id="'.$_GET['id'].'"');
			$my->req('UPDATE ttre_client_part SET stat_valid="'.!$temp['stat_valid'].'" WHERE id="'.$_GET['id'].'"');
			rediriger('?contenu=part_liste&modifier=ok');
			exit;
			break;
	}
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des clients</h1>';
	
	
	if ( isset($_POST['nom']) && !empty($_POST['nom']) ) $nom=$_POST['nom']; else $nom='';
	if ( isset($_POST['prenom']) && !empty($_POST['prenom']) ) $prenom=$_POST['prenom']; else $prenom='';
	if ( isset($_POST['tel']) && !empty($_POST['tel']) ) $tel=$_POST['tel']; else $tel='';
	if ( isset($_POST['email']) && !empty($_POST['email']) ) $email=$_POST['email']; else $email='';
	
	$form = new formulaire('modele_1','?contenu=part_liste','','','','sub','txt','','txt_obl','lab_obl');
	$form->text('Nom','nom','','',$nom);
	$form->text('Prénom','prenom','','',$prenom);
	$form->text('Tel','tel','','',$tel);
	$form->text('Email','email','','',$email);
	$form->afficher1('Rechercher');
	
	
	if ( isset($_GET['supprimer']) ) echo'<div class="success"><p>Ce client a bien été supprimé.</p></div>';
	elseif ( isset($_GET['envoyer']) ) echo'<div class="success"><p>Le message a bien été envoyé.</p></div>';
	elseif ( isset($_GET['modifier']) ) echo'<div class="success"><p>Le statut de ce client a bien été modifié.</p></div>';
	
	
	
	$where='';
	if ( $nom!='' ) $where.='AND P.nom = "'.$nom.'" ';
	if ( $prenom!='' ) $where.='AND P.prenom = "'.$prenom.'" ';
	if ( $tel!='' ) $where.='AND P.telephone = "'.$tel.'" ';
	if ( $email!='' ) $where.='AND P.email = "'.$email.'" ';
	$req = $my->req('SELECT * FROM ttre_client_part P WHERE P.stat_valid>=0 '.$where.' ORDER BY P.id DESC');
	
	
	
	if ( $my->num($req)>0 )
	{
		$various='';
		echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>Nom</td>
					<td class="bouton">Détail</td>
					<td class="bouton">Statut</td>
					<td class="bouton">Modifier</td>
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
						<div id="inline'.$res['id'].'" style="width:700px;overflow:auto;">
							<div id="espace_compte" style="width:650px;">
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
										
								<div style="border: 1px solid #000000;margin: 35px 0 0 10px;padding: 15px;width: 600px;">
									<form method="POST" action="?contenu=part_liste&action=envoyer" enctype="multipart/form-data" >
										<p>Contenu mail : <textarea name="message" style="width:100%;height:200px;" ></textarea><br /><br /></p>
										<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
										<p><input type="file" name="fichier" /></p>		
										<p><input type="submit" value="Envoyer" style="margin:0 0 0 110px;"/></p>
									</form>
								</div>
												
							</div>
						</div>
					</div>
						';
			if ( $res['stat_valid']==1 ) 
				$a_valid = '<a href="?contenu=part_liste&action=valid&id='.$res['id'].'" title="Client validé"><img src="img/interface/icone_ok.jpeg" alt="Client validé" border="0" /></a>';
			else	
				$a_valid = '<a href="?contenu=part_liste&action=valid&id='.$res['id'].'" title="Client pas encore validé"><img src="img/interface/icone_nok.jpeg" alt="Client pas encore validé" border="0" /></a>';
				
			echo'
				<tr>
					<td class="nom_prod">'.strtoupper(html_entity_decode($res['nom'])).' '.ucfirst(html_entity_decode($res['prenom'])).'</td>
					<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Détail" border="0" /></a></td>
					<td class="bouton">'.$a_valid.'</td>
					<td class="bouton">
						<a href="?contenu=part_liste&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>		
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
});
</script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.1.css" media="screen" />