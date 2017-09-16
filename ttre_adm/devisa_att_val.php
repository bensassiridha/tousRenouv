<?php 


//$a=array(4,5,7);var_dump($a);//devis
//$b=array(1,2,3,4,5,6,7,8);var_dump($b);//client
//$c=array_intersect($a,$b);var_dump($c);
//if ( $a === $c ) echo 'true' ; else echo 'false';

$my = new mysql();
if ( isset($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'modifier' :
			$my->req('UPDATE ttre_achat_devis SET prix_achat="'.$_POST['prix'].'" , nbr_estimation="'.$_POST['est'].'" WHERE id='.$_POST['id']);
			rediriger('?contenu=devisa_att_val&modifier=ok');
			exit;
			break;
		case 'valider' :
			$tt = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id']);
			$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="1" WHERE id='.$_GET['id']);
			
			$suite='<table cellpadding="0" cellspacing="0">';
			$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ORDER BY ordre_categ ASC ');
			while ( $ress=$my->arr($reqq) )
			{
				if ( $nom_cat!=$ress['titre_categ'] )
				{
					$nom_cat=$ress['titre_categ'];
					$suite.='<tr style="background:#FFFF66;"><td>'.$nom_cat.'</td></tr>';
				}
				$suite.='<tr><td style="text-align:justify;">'.$ress['piece'].'<br /><br /></td></tr>';
			}
			$suite.='</table>';
			
			//---------recherche les client qui travaille sur la meme departement--------
			$devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id']);
			$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
			$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
			$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
			$req = $my->req('SELECT * FROM ttre_client_pro_departements D , ttre_client_pro C WHERE C.id=D.id_client AND C.stat_valid_general=1 AND D.id_departement='.$id_departement['departement_id']);
			if ( $my->num($req)>0 )
			{
				//---------recherche les client qui travaille sur les meme categories--------
				$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' '); while ( $r=$my->arr($q) ) $tab_devis[]=$r['id_categ'];
				while ( $res=$my->arr($req) )
				{
					$tab_client=array();
					$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' '); while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
					$c=array_intersect($tab_devis,$tab_client);
					if ( $tab_devis === $c ) 
					{
						$my->req('INSERT INTO ttre_achat_devis_client_pro VALUES("","'.$_GET['id'].'","'.$res['id_client'].'","","","","","","")');
						$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client'].' ');
						$nom=$temp['nom'];$mail=$temp['email'];
						//-------------- envoie mail -------------------------------
						$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=5 ');
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
										<p>Un particulier vient de déposer une demande de devis correspondant à vos critères.</p>
										<p>Accédez à votre interface <a href="http://tousrenov.fr/espace_professionnel.php"> Espace professionnel</a></p>
										<p>Département : '.$id_departement['departement_nom'].' <p>
										<p>Ville : '.$code_departement['ville_nom_reel'].' <p>
										<p>description des travaux  : <br /> '.$suite.' </p>
										<p>Le client  attend votre appel pour prendre RDV<p>
										<p>Attention : ce contact est disponible au moment de l\'envoi de cet email. 
												Il se peut qu\'il ne le soit plus lors de votre connexion, s\'il a été acheté entre temps par un autre Partenaire.<p>
			
										<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
											<p style="padding-top:10px;">
												L\'Equipe Tousrenov <br />
												contact@tousrenov.fr <br />
												09 73 27 20 67 <br />
											</p>
										</div>
									</div>
								</body>
								</html>
								';
						//$mail_client='bilelbadri@gmail.com';
						$sujet = $nom_client.' : Nouveau devis';
						$headers = "From: \" ".$nom." \"<".$mail.">\n";
						$headers .= "Reply-To: ".$mail."\n";
						$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
						mail($mail,$sujet,$message,$headers);
					}
				}
			}
			//---------------------------------------------------------------------------
			rediriger('?contenu=devisa_att_val&valider=ok');exit;
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_achat_devis WHERE id="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_achat_devis_details WHERE id_devis="'.$_GET['id'].'"');
			$req = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id']);
			while ( $res=$my->arr($req) )
			{
				@unlink('../upload/devis/'.$res['fichier']);
			}
			$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id_devis="'.$_GET['id'].'"');
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis="'.$_GET['id'].'"');
			$req = $my->req('SELECT * FROM ttre_achat_devis_cm WHERE id_devis='.$_GET['id']);
			while ( $res=$my->arr($req) )
			{
				$req1 = $my->req('SELECT * FROM ttre_achat_devis_cm_photo WHERE id_cm='.$res['id']);
				while ( $res1=$my->arr($req1) )
				{
					@unlink('../upload/galeries/800X600/'.$res1['photo']);
					@unlink('../upload/galeries/300X300/'.$res1['photo']);
					@unlink('../upload/galeries/100X100/'.$res1['photo']);
				}
				$my->req('DELETE FROM ttre_achat_devis_cm_photo WHERE id_cm="'.$res['id'].'"');
			}
			$my->req('DELETE FROM ttre_achat_devis_cm WHERE id_devis="'.$_GET['id'].'"');
			rediriger('?contenu=devisa_att_val&supprimer=ok');
			exit;
			break;
		case 'changer' :
			$info_devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('UPDATE ttre_achat_devis SET
					nbr_estimation			=	"'.$info_devis['stat_suppr'].'"	,
					prix_achat				=	"'.$info_devis['user_zone'].'"	,
					note_devis				=	"0"	,
					user_zone				=	"0"	,
					stat_suppr				=	"0"	,
					statut_valid_admin		=	"-1"
							WHERE id='.$_GET['id']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			while ( $res=$my->arr($req) ) @unlink('../upload/devis_client_pro/'.$res['fichier']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			rediriger('?contenu=devisa_att_val&changer=ok');exit;
			break;			
	}				
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des devis en attende de validation</h1>';
	$alert='';
	if ( isset($_GET['valider']) ) $alert='<div class="success"><p>Ce devis a bien été validé.</p></div>';
	elseif ( isset($_GET['modifier']) ) $alert='<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	elseif ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	elseif ( isset($_GET['changer']) ) echo '<div class="success"><p>Ce devis a bien été changé.</p></div>';
	
	
	$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=0 ORDER BY date_ajout DESC ');
	if ( $my->num($req)>0 )
	{
		echo'
			'.$alert.'
			<table id="liste_produits">
			<tr class="entete">
				<td>Date</td>
				<td>Client</td>
				<td>Catégorie</td>
				<td>Ville / Département</td>
				<td>Prix achat</td>
				<td class="bouton">Détail</td>
				<td class="bouton">Valider</td>
				<td class="bouton"></td>
			</tr>
			';
		$various='';
		while ( $res=$my->arr($req) )
		{
			$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
			if ( $userprofil['profil']==1 )
			{
				
				$detail='';
							
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
				$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
				$batiment = ucfirst(html_entity_decode($temp['batiment']));
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				$detail.='
					<ul id="compte_details_com" class="livraison">
						<li>
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N° d’appartement : '.$num_appart.'</dd>
								<dd>Bâtiment : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>								
						</li>				
					</ul>
					<div id="espace_compte">
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Désignation</td>														
							</tr>	
						 ';
				$nom_cat='';$nc='';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id'].' ORDER BY ordre_categ ASC ');
				while ( $ress=$my->arr($reqq) )
				{
					if ( $nom_cat!=$ress['titre_categ'] )
					{
						$nom_cat=$ress['titre_categ'];
						$detail.='
								<tr style="background:#FFFF66;">
									<td colspan="6">'.$nom_cat.'</td>
								</tr>
									';
						$nc.=$nom_cat.', ';
					}
					$detail.='
							<tr>
								<td style="text-align:justify;">'.$ress['piece'].'</td>		
							</tr>
						';
				}
				$detail.='
						</table>
					</div>
							';
				
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$res['id'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers à télécharger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="../upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p>';
				}
				
				$detail.='
						<div style="border: 1px solid #000000;margin: 35px 0 0 175px;padding: 15px;width: 350px;">
							<form method="POST" action="?contenu=devisa_att_val&action=modifier" >
								<p>Nombre d\'estimation : <input id="est" value="'.$res['nbr_estimation'].'" name="est" type="text" /></p><br />
								<p>Prix : <input id="prix" value="'.$res['prix_achat'].'" name="prix" type="text" /></p><br />
								<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
								<p><input type="submit" name="modif_prix" value="Modifier" style="margin:0 0 0 110px;"/></p>
							</form>
						</div>
						 ';
				$various.='
						<div style="display: none;">
							<div id="inline'.$res['id'].'" style="width:750px;height:500px;overflow:auto;">
								<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
									'.$detail.'
								</div>
							</div>
						</div>
							';	
					
				$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
				$vd='';
				$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
				$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
				$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
				echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).'</td>
						<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
						<td>'.$nc.'</td>
						<td>'.$vd.'</td>
						<td>'.number_format($res['prix_achat'],2).' €</td>
						<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
						<td class="bouton">
							<a href="?contenu=devisa_att_val&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
							<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
							{window.location=\'?contenu=devisa_att_val&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
							Supprimer</a>
							<br /><br /><a style="color:red;" href="?contenu=devisa_att_val&action=changer&id='.$res['id'].'" title="Par zone">Changer</a>		
						</td>
					</tr>	
					';
			}
			elseif ( $userprofil['profil']==2 )
			{
				$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
				$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
				$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['id_user'].' AND zone='.$rs3['departement_id'].' ');
				if ( $my->num($rq1)>0 )
				{
					$detail='';
						
					$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
					$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
					$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
					$batiment = ucfirst(html_entity_decode($temp['batiment']));
					$code_postal = $temp['code_postal'];
					$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
					$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
					$pays = ucfirst(html_entity_decode($temp['pays']));
					$detail.='
					<ul id="compte_details_com" class="livraison">
						<li>
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N° d’appartement : '.$num_appart.'</dd>
								<dd>Bâtiment : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>
						</li>
					</ul>
					<div id="espace_compte">
						<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
							<tr class="entete">
								<td>Désignation</td>
							</tr>
						 ';
					$nom_cat='';$nc='';
					$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id'].' ORDER BY ordre_categ ASC ');
					while ( $ress=$my->arr($reqq) )
					{
						if ( $nom_cat!=$ress['titre_categ'] )
						{
							$nom_cat=$ress['titre_categ'];
							$detail.='
								<tr style="background:#FFFF66;">
									<td colspan="6">'.$nom_cat.'</td>
								</tr>
									';
							$nc.=$nom_cat.', ';
						}
						$detail.='
							<tr>
								<td style="text-align:justify;">'.$ress['piece'].'</td>
							</tr>
						';
					}
					$detail.='
						</table>
					</div>
							';
					
					$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$res['id'].' ');
					if ( $my->num($req_f)>0 )
					{
						$detail.='<p><br /> Fichiers à télécharger : ';
						while ( $res_f=$my->arr($req_f) )
						{
							$detail.='<a target="_blanc" href="../upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
						}
						$detail.='</p>';
					}
					
					$detail.='
						<div style="border: 1px solid #000000;margin: 35px 0 0 175px;padding: 15px;width: 350px;">
							<form method="POST" action="?contenu=devisa_att_val&action=modifier" >
								<p>Nombre d\'estimation : <input id="est" value="'.$res['nbr_estimation'].'" name="est" type="text" /></p><br />
								<p>Prix : <input id="prix" value="'.$res['prix_achat'].'" name="prix" type="text" /></p><br />
								<input type="hidden" id="id" name="id" value="'.$res['id'].'" />
								<p><input type="submit" name="modif_prix" value="Modifier" style="margin:0 0 0 110px;"/></p>
							</form>
						</div>
						 ';
					$various.='
						<div style="display: none;">
							<div id="inline'.$res['id'].'" style="width:750px;height:500px;overflow:auto;">
								<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
									'.$detail.'
								</div>
							</div>
						</div>
							';
						
					$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
					$vd='';
					$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
					$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
					$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
					$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
					echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).'</td>
						<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
						<td>'.$nc.'</td>
						<td>'.$vd.'</td>
						<td>'.number_format($res['prix_achat'],2).' €</td>
						<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
						<td class="bouton">
							<a href="?contenu=devisa_att_val&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
							<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\'))
							{window.location=\'?contenu=devisa_att_val&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
							Supprimer</a>
						</td>
					</tr>
					';
				}
			}
		}
		echo'</table>'.$various;
	}
	else 
	{
		echo'<p> Pas de devis...</p>';
	}
}
?>
<link rel="stylesheet" type="text/css" href="../style_alert.css" />        
<link rel="stylesheet" type="text/css" href="../style_boutique.css" />   

<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$(".various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
});
</script>

