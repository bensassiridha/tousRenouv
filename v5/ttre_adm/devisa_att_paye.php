<?php 
$nom_client='TousRenov';
$url_site_client='http://tousrenov.fr';
// creation-site-web-tunisie.net/trn
$logo_client='http://tousrenov.fr/images/logo.png';
$mail_client='';



//$a=array(4,5,7);var_dump($a);//devis
//$b=array(1,2,3,4,5,6,7,8);var_dump($b);//client
//$c=array_intersect($a,$b);var_dump($c);
//if ( $a === $c ) echo 'true' ; else echo 'false';

$my = new mysql();
if ( isset($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'paye' :
			if ( isset($_GET['actionPaye']) )
			{
				switch( $_GET['actionPaye'] )
				{
					case 'valider' :
						$adcp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id="'.$_GET['id'].'" ');
						$devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id="'.$adcp['id_devis'].'" ');
						if ( $adcp['statut_achat']==0 )
						{
							$id_devis=$devis['id'];
							$id_adresse=$devis['id_adresse'];
							$id_client_part=$devis['id_client'];
							$id_client_pro=$adcp['id_client_pro'];
							require_once '../mailAchatDevis.php';
							$my->req('UPDATE ttre_achat_devis_client_pro SET 
										statut_achat 	= "1" ,
										date_payement 	= "'.time().'" , 
										type_payement	=	"test" ,
										fichier_update	=	"site"
									WHERE id = "'.$_GET['id'].'" ' );
						}
						/*$req_devis=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE statut_achat = 1 AND id_devis='.$devis['id'].' ');
						if ( $my->num($req_devis)==3 ) 
						{
							$my->req('UPDATE ttre_achat_devis SET statut_valid_admin = "2" WHERE id = "'.$devis['id'].'" ' );
							rediriger('?contenu=devisa_att_paye');
						}
						else
						{*/
						rediriger('?contenu=devisa_att_paye&action=paye&id='.$adcp['id_devis'].'');
						//}
						exit;
						break;
				}
			}
			else 
			{
				echo '<h1 style="margin-top:0;" >Gérer la liste des clients en attende de payement</h1>';
				$req=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ORDER BY id ASC ');	
				if ( $my->num($req)>0 )
				{
					echo'
						<table id="liste_produits">
						<tr class="entete">
							<td>Date</td>
							<td>Client</td>
							<td class="bouton">Valider</td>
						</tr>
						';
					while ( $res=$my->arr($req) )
					{
						if ( $res['statut_achat']==1 )
							$a_valid = '<a href="?contenu=devisa_att_paye&action=paye&actionPaye=valider&id='.$res['id'].'" ><img src="img/interface/icone_ok.jpeg" border="0" /></a>';
						else
							$a_valid = '<a href="?contenu=devisa_att_paye&action=paye&actionPaye=valider&id='.$res['id'].'" ><img src="img/interface/icone_nok.jpeg"  border="0" /></a>';
						
						$info_client=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client_pro'].'  ');
						if ( $res['date_payement']==0 ) $date=''; else $date=date('d/m/Y',$res['date_payement']);
						echo'
							<tr style="text-align:center;">
								<td>'.$date.'</td>
								<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
								<td class="bouton">'.$a_valid.'</td>
							</tr>	
							';
					}
					echo'</table>';
				}
			}
			break;
		/*case 'valider' :
			$devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id="'.$_GET['id'].'" ');
			$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="2" WHERE id='.$_GET['id']);
			rediriger('?contenu=devisa_att_paye&valider=ok');
			exit;
			break;*/
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
			rediriger('?contenu=devisa_att_paye&supprimer=ok');
			exit;
			break;
	}				
}
else
{
	echo '<h1 style="margin-top:0;" >Gérer la liste des devis en attende de payement</h1>';
	$alert='';
	if ( isset($_GET['valider']) ) $alert='<div class="success"><p>Ce devis a bien été validé.</p></div>';
	elseif ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=1 ORDER BY date_ajout DESC ');
	if ( $my->num($req)>0 )
	{
		//		<td class="bouton">Valider</td>
		echo'
			'.$alert.'
			<table id="liste_produits">
			<tr class="entete">
				<td>Date</td>
				<td>Client</td>
				<td>Prix</td>
				<td class="bouton">Détail</td>
				<td class="bouton">Clients</td>
				<td class="bouton">Supprimer</td>
			</tr>
			';
		$various='';
		while ( $res=$my->arr($req) )
		{
			$detail='';
			
			/*$temp=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id='.$res['id'].' ');
			$detail.='<p><strong>Description : </strong> '.$temp['description'].'</p>';*/
					
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
			$nom_cat='';
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
				
			$various.='
					<div style="display: none;">
						<div id="inline'.$res['id'].'" style="width:750px;height:500px;overflow:auto;">
							<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
								'.$detail.'
							</div>
						</div>
					</div>
						';	
				
			/*		<td class="bouton">
						<a href="?contenu=devisa_att_paye&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
						<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
					</td>*/
			$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].'  ');
			echo'
				<tr style="text-align:center;">
					<td>'.date('d/m/Y',$res['date_ajout']).'</td>
					<td><strong>'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</strong></td>
					<td>'.number_format($res['prix_achat'],2).' €</td>
					<td class="bouton"><a class="various1" href="#inline'.$res['id'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a></td>
					<td class="bouton">
						<a href="?contenu=devisa_att_paye&action=paye&id='.$res['id'].'" title="" >
						<img src="img/cart.png" alt="Valider"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
						{window.location=\'?contenu=devisa_att_paye&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/icone_delete.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>	
				';
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
