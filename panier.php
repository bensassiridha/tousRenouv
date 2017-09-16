<?php
session_start();
require('mysql.php');$my=new mysql();








if ( isset($_GET['ref']) )
{
	$com=$my->req_arr('SELECT * FROM ttre_client_pro_commandes WHERE reference="'.$_GET['ref'].'" ');
	if ( $com )
	{
		if ( $com['statut']==0 )
		{
			$req=$my->req('SELECT * FROM ttre_client_pro_commandes_contenu WHERE id_cmd='.$com['id'].' ');$suite='';
			while ( $res=$my->arr($req) )
			{
				$info_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
				
				$suite.='<table cellpadding="0" cellspacing="0">';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$info_devis['id'].' ORDER BY ordre_categ ASC ');
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
				
				$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$info_devis['id_client'].' ');
				$info_ville_client=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_client['ville'].' ');
				$info_adresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$info_devis['id_adresse'].' ');
				$info_ville_adresse=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_adresse['ville'].' ');
				
				$suite.='
						<p><span style="color:#0495CB;">D�tails du client :</span><br />
							<strong>Civilit� : </strong> '.ucfirst(html_entity_decode($info_client['civ'])).'<br />	
							<strong>Nom : </strong> '.ucfirst(html_entity_decode($info_client['nom'])).'<br />
							<strong>Pr�nom : </strong> '.ucfirst(html_entity_decode($info_client['prenom'])).'<br />
							<strong>T�l�phone : </strong> '.html_entity_decode($info_client['telephone']).'<br />
							<strong>Email : </strong> '.html_entity_decode($info_client['email']).'<br />
							<strong>Num�ro et voie : </strong> '.html_entity_decode($info_client['num_voie']).'<br />
							<strong>N� d\'appartement, Etage, Escalier : </strong> '.html_entity_decode($info_client['num_appart']).'<br />
							<strong>B�timent, R�sidence, Entr�e : </strong> '.html_entity_decode($info_client['batiment']).'<br />
							<strong>Code postal : </strong> '.html_entity_decode($info_client['code_postal']).'<br />
							<strong>Ville : </strong> '.html_entity_decode($info_ville_client['ville_nom_reel']).'<br />
							<strong>Pays : </strong> '.html_entity_decode($info_client['pays']).'<br />
						</p>
						<p><span style="color:#0495CB;">D�tails du l\'adresse du chantier :</span><br />
							<strong>Num�ro et voie : </strong> '.html_entity_decode($info_adresse['num_voie']).'<br />
							<strong>N� d\'appartement, Etage, Escalier : </strong> '.html_entity_decode($info_adresse['num_appart']).'<br />
							<strong>B�timent, R�sidence, Entr�e : </strong> '.html_entity_decode($info_adresse['batiment']).'<br />
							<strong>Code postal : </strong> '.html_entity_decode($info_adresse['code_postal']).'<br />
							<strong>Ville : </strong> '.html_entity_decode($info_ville_adresse['ville_nom_reel']).'<br />
							<strong>Pays : </strong> '.html_entity_decode($info_adresse['pays']).'<br />
						</p><br /><br /><br /><br />
						';
			}
			
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
									<p>D�tails de devis :</p>
									'.$suite.'
									<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
										<p style="padding-top:10px;">'.$nom_client.'</p>
									</div>
								</div>
							</body>
							</html>
							';
			$pro=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$com['id_client'].' ');
			
			$destinataire=$pro['email'];
			//$destinataire='bilelbadri@gmail.com';
			$email_expediteur=$mail_client;
			$email_reply=$mail_client;
			$titre_mail=$nom_client;
			$sujet=$nom_client.' : D�tail avanc� ';
				
			$frontiere = '-----=' . md5(uniqid(mt_rand()));
			$headers = 'From: "'.$titre_mail.'" '."\n";
			$headers .= 'Return-Path: <'.$email_reply.'>'."\n";
			$headers .= 'MIME-Version: 1.0'."\n";
			$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';
			
			$message = '';
			$message .= '--'.$frontiere."\n";
			$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
			$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
			
			$message .= $message_html."\n\n";
			
			$message .= '--'.$frontiere.'--'."\r\n";
			
			mail($destinataire,$sujet,$message,$headers);
			
			$my->req('UPDATE ttre_client_pro_commandes SET
							fichier_update	=	"site" ,
							statut			=	"1"
						WHERE reference = "'.$_GET['ref'].'" ' );
		}
		header("location:panier.php?paiement=effectuer");exit;
	}
	else
	{
		header("location:panier.php?paiement=annuler");exit;
	}
}


if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'panier' :
			switch ( $_GET['action'] )
			{
				case 'ajouter' :
					if( !isset($_SESSION['panier_trn']) )
					{
						$_SESSION['panier_trn'] 				= array();
						$_SESSION['panier_trn']['id'] 			= array();
						$_SESSION['panier_trn']['id_prod'] 		= array();
						$_SESSION['panier_trn']['type'] 		= array();
						$_SESSION['panier_trn']['prix'] 		= array();
					}
					$indice = count($_SESSION['panier_trn']['id']) + 1;
					$prod=$_GET['idDevisAImm'];$type='DevisAImm';
					$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$prod.' ');
					$prix=$infos_devis['prix_achat']+$infos_devis['prix_achat']*20/100;
					$incrementer = -1;
					if ( count($_SESSION['panier_trn']['id_prod'])>0 && array_search($prod,$_SESSION['panier_trn']['id_prod'])!==false && array_search($type,$_SESSION['panier_trn']['type'])!==false )
					{
						$i = 0;
						while ( $i<count($_SESSION['panier_trn']['id']) && $incrementer == -1 )
						{
							if ( $_SESSION['panier_trn']['id_prod'][$i]==$prod && $_SESSION['panier_trn']['type'][$i]==$type ) $incrementer = $i;
							$i++;
						}
					}
					if ( $incrementer != -1 )
					{
						//$_SESSION['panier_vv']['qte'][$incrementer]=$_SESSION['panier_vv']['qte'][$incrementer]+$qua;
					}
					else
					{
						$_SESSION['panier_trn']['id'][]=$indice;
						$_SESSION['panier_trn']['id_prod'][]=$prod;
						$_SESSION['panier_trn']['type'][]=$type;
						$_SESSION['panier_trn']['prix'][]=$prix;
					}
					header("location:panier.php");
					break;
				case 'supprimer' :
					$_SESSION['panier_tmp'] 			= array();
					$_SESSION['panier_tmp']['id'] 		= array();
					$_SESSION['panier_tmp']['id_prod'] 	= array();
					$_SESSION['panier_tmp']['type'] 	= array();
					$_SESSION['panier_tmp']['prix'] 	= array();
					$indice = 1;
					$nb_articles = count($_SESSION['panier_trn']['id']);
					for ( $x=0;$x<$nb_articles;$x++ )
					{
						# transf�rer tous les items dans le panier temp sauf ceux � supprimer
						if ( $_SESSION['panier_trn']['id'][$x] != $_GET['id'] )
						{
							array_push($_SESSION['panier_tmp']['id'],$indice);
							array_push($_SESSION['panier_tmp']['id_prod'],$_SESSION['panier_trn']['id_prod'][$x]);
							array_push($_SESSION['panier_tmp']['type'],$_SESSION['panier_trn']['type'][$x]);
							array_push($_SESSION['panier_tmp']['prix'],$_SESSION['panier_trn']['prix'][$x]);
							$indice ++;
						}
					}
					$_SESSION['panier_trn'] = $_SESSION['panier_tmp'];
					unset($_SESSION['panier_tmp']);
					if ( $nb_articles == 1 )
					{
						unset($_SESSION['panier_trn']);
						header("location:panier.php");
					}
					else
					{
						header("location:panier.php?supprimer=ok");
					}
					break;
				case 'vider' :
					unset($_SESSION['panier_trn']);
					header("location:panier.php");
					break;
			}
			break;
		case 'paiement';
			if ( !isset($_SESSION['panier_trn']) ) {header("location:panier.php");exit;}
			if ( isset($_GET['module']) )
			{
				$type_de_payement='';// 0
				if ( $_GET['module']=='test' )  $type_de_payement='Test';
				elseif ( $_GET['module']=='paypal' ) $type_de_payement='Paypal';
				elseif ( $_GET['module']=='virement' ) $type_de_payement='Virement';
				elseif ( $_GET['module']=='cheque' ) $type_de_payement='Ch�que';
				$reference_commande = uniqid('R');
				if ( isset($_SESSION['id_client_trn_pro']) )
				{
					$my->req("INSERT INTO ttre_client_pro_commandes VALUES('',
													'".$reference_commande."',
													'".$_SESSION['id_client_trn_pro']."',
													'".time()."',
													'".$type_de_payement."',
													'".$_SESSION['total']."',
													'0' ,
													'')");
				}
				elseif ( isset($_SESSION['id_client_trn_pro_desactiver']) )
				{
					$my->req("INSERT INTO ttre_client_pro_commandes VALUES('',
													'".$reference_commande."',
													'".$_SESSION['id_client_trn_pro_desactiver']."',
													'".time()."',
													'".$type_de_payement."',
													'".$_SESSION['total']."',
													'0' ,
													'')");
				}
				$id_cmd = mysql_insert_id();

				echo '<pre>';print_r($_SESSION['panier_trn']);die();

				for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )
				{
					$id_prod=$_SESSION['panier_trn']['id_prod'][$i];
					$type=$_SESSION['panier_trn']['type'][$i];
					$prix = $_SESSION['panier_trn']['prix'][$i];
					$c=$my->req("INSERT INTO ttre_client_pro_commandes_contenu VALUES('','".$id_cmd."','".$id_prod."','".$type."','".$prix."')");
				}
			}
			break;			
	}
}




//echo '/'.$_SESSION['id_client_trn_pro'].'--'.$_SESSION['id_client_trn_pro_desactiver'].'/';






































$pageTitle = "Panier"; 
include('inc/head.php');?>
	<body id="page2">
<!--==============================header=================================-->
<?php include('inc/entete.php');?>
<!--==============================header=================================-->
				<div class="wrapper">
						<div class="head-page-style3 subtitle">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
									<h2>Panier</h2>
									<!-- <h1>Devis gratuit en ligne et sans aucun engagement</h1> -->
									<div class="formulaire">
									<h6>Formulaire</h6>

										<ul>
											
										<?php 
											$req = $my->req('SELECT * FROM ttre_formulaire ORDER BY id DESC ');
											if ( $my->num($req)>0 )
											{
												while ( $res=$my->arr($req) )
												{
													echo'<li><a target="_blanc" href="upload/fichiers/'.$res['fichier'].'">'.$res['titre'].'</a></li>';
												}
											}
										?>
										</ul>
									</div>
									<!-- <div class="bttn-devis">
										<ul>
											<li><a href="devis.php"><i>Cr�er votre devis</i></a></li>
											<li><a href="prix-travaux.php"><i>Devis Imm�diat</i></a></li>
										</ul>
									</div> -->
								</div>
								</div>
							</div>
						</div>
						<div id="content">
							
							<div class="conseil">
								<div class="desc"></div>
								
		
		
		
								
								
								

								
								
								
								
								
								
								
								
								
<script type="text/javascript">
$(document).ready(function() 
{	
	$('form[name="form_paiemant"]').submit();	
});
</script>									
								
								
								
								
<?php 								
if ( isset($_GET['contenu']) )
{
	switch ( $_GET['contenu'] )
	{
		case 'paiement' :
			echo'
				<div id="espace_compte">
					<div class="conteneur_ariane_cmd">
						<ul id="compte_ariane_cmd">
							<li class="done">1. <a href="panier.php">Panier</a></li>
							<li class="courant">2. Paiement</li>
							<li class="ariane_cmd_fil"></li>
						</ul>
					</div>
				</div><br />
			';
			if ( !isset($_GET['module']) )
			{
				$module_Test='';$module_paypal='';$module_virement='';$module_cheque='';
				//$module_Test='<p style="text-align: center;">Notre solution de paiement en ligne est en cours d\'int�gration,<br /> merci de revenir plus tard.';
				if ( $_SESSION['id_client_trn_pro']==420 )
				{
					$module_Test='
					 				<p class="payment_module">
					 					<a title="Payer par Test" href="panier.php?contenu=paiement&module=test">
					 						<img width="86" height="49" alt="Test" src="stockage_img/test.jpg">
					 						Test
					 					</a>
					 				</p>
							 		';
				}
				$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=1 ');
				if ( $temp['statut']==1 && !empty($temp['val1']) )
				{
					$module_paypal='
									<p class="payment_module">
										<a title="Payer par Paypal" href="panier.php?contenu=paiement&module=paypal">
											<img width="86" height="49" alt="Payer par Paypal" src="carte-bleue.jpeg">
											Payer par Carte bleue
										</a>
									</p>
									';
				}
				$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=2 ');
				if ( $temp['statut']==1 && !empty($temp['val1']) && !empty($temp['val2']) && !empty($temp['val3']) )
				{
					$module_virement='
									<p class="payment_module">
										<a title="Payer par Virement" href="panier.php?contenu=paiement&module=virement">
											<img width="86" height="49" alt="Payer par Virement" src="stockage_img/bankwire.jpg">
											Payer par Virement bancaire
										</a>
									</p>
									';
				}
				$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=3 ');
				if ( $temp['statut']==1 && !empty($temp['val1']) && !empty($temp['val2']) )
				{
					$module_cheque='
									<p class="payment_module">
										<a title="Payer par Ch�que" href="panier.php?contenu=paiement&module=cheque">
											<img width="86" height="49" alt="Payer par Virement" src="stockage_img/cheque.jpg">
											Payer par Ch�que
										</a>
									</p>
									';
				}
				echo'
					<div id="HOOK_PAYMENT">
						'.$module_Test.'
						'.$module_paypal.'
						'.$module_virement.'
						'.$module_cheque.'
					</div>
					';
			}
			else
			{
				if ( $_GET['module']=='test' )
				{
					echo'
						<div id="espace_compte">
							<a href="panier.php?ref='.$reference_commande.'">Paiement effectu�</a> |
							<a href="panier.php?paiement=annuler">Paiement annul�</a></p>
						</div>
						';
				}
				elseif ( $_GET['module']=='paypal' )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=1 ');
					$test=0;
					if ( $test==1 )
					{
						$action_form='https://www.sandbox.paypal.com/cgi-bin/webscr';
						$email_business='bilelbusiness@yahoo.fr';
						$ipn='ipn_test.php';
					}
					else
					{
						//$action_form='https://ipnpb.paypal.com/cgi-bin/webscr';
						$action_form='https://www.paypal.com/cgi-bin/webscr';
						$email_business=$temp['val1'];
						$ipn='ipnn.php';
					}
					//$_SESSION['total']=1;
					echo'
								<div id="espace_compte">
									<p style="text-align: center"><i>Vous �tes rederig� sur le site de paypal en quelque instant ...</i></p>
									<p style="text-align: center;margin:20px 0 50px 0;d"><img src="stockage_img/ajax-loader.gif" /></p>
									<div style="display:none;">
										<form action="'.$action_form.'" method="post" name="form_paiemant">
											<input type="hidden" name="amount" value="'.$_SESSION['total'].'">
											<input name="currency_code" type="hidden" value="EUR" />
											<input name="shipping" type="hidden" value="0.00" />
											<input name="tax" type="hidden" value="0.00" />
											<input name="return" type="hidden" value="http://tousrenov.fr/panier.php?ref='.$reference_commande.'" />
											<input name="cancel_return" type="hidden" value="http://tousrenov.fr/panier.php?paiement=annuler" />
											<input name="notify_url" type="hidden" value="http://tousrenov.fr/'.$ipn.'" />
											<input name="cmd" type="hidden" value="_xclick" />
											<input name="business" type="hidden" value="'.$email_business.'" />
											<input name="item_name" type="hidden" value="'.$nom_client.'" />
											<input name="custom" type="hidden" value="'.$reference_commande.'" />
											<input alt="Effectuez vos paiements via PayPal : une solution rapide, gratuite et s�curis�e" name="submit"
												src="img/paypal.png" type="image" />
												<img src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
										</form>
									</div>
								</div>
								';
				}
				elseif ( $_GET['module']=='virement' )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=2 ');
					echo'
								<div id="espace_compte" style="margin:0 0 0 80px;">
									<p>Votre commande sur '.$nom_client.' est bien enregistr�.</p>
									<p>Merci de nous envoyer un virement bancaire avec :
										<br />- d\'un total de <strong> '.number_format($_SESSION['total'],2).' � </strong>
										<br />- � l\'ordre de <strong> '.$temp['val2'].' </strong>
										<br />- suivant ces d�tails
										<br />
										IBAN : <strong> '.$temp['val1'].' </strong>
										<br />
										SWIFT BIC : <strong> '.$temp['val3'].' </strong>
										<br />- N\'oubliez pas d\'indiquer votre r�f�rence de commande <strong> "'.$reference_commande.'" </strong> dans le sujet de votre virement
										<p>Votre commande vous sera valid� d�s r�ception du paiement.</p>
										<p>Pour toute question ou information compl�mentaire merci de contacter notre <a href="contact.php">support client</a></p>.
									</p>
								</div>
								';
				}
				elseif ( $_GET['module']=='cheque' )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_module_payement WHERE id=3 ');
					echo'
								<div id="espace_compte" style="margin:0 0 0 80px;">
									<p>Votre commande sur '.$nom_client.' est bien enregistr�.</p>
									<p>Merci de nous envoyer un ch�que :
										<br />- d\'un total de <strong> '.number_format($_SESSION['total'],2).' � </strong>
										<br />- � l\'ordre de  <strong> '.$temp['val1'].' </strong>
										<br />- � envoyer �
										<br />
										<strong> '.$temp['val2'].' </strong>
										<br />- N\'oubliez pas d\'indiquer votre r�f�rence de commande <strong> "'.$reference_commande.'" </strong> sur le ch�que
										<p>Votre commande vous sera valid� d�s r�ception du paiement.</p>
										<p>Pour toute question ou information compl�mentaire merci de contacter notre <a href="contact.php">support client</a></p>.
									</p>
								</div>
								';
				}
			}
			break;
	}
}
elseif ( isset($_SESSION['panier_trn']) )
{
	$montantTotal = 0;
	$panier='';
	for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )
	{
		$prod=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_SESSION['panier_trn']['id_prod'][$i].'');
		$nomProduit=$prod['reference'];
		$prix = $_SESSION['panier_trn']['prix'][$i];
		$clef = $_SESSION['panier_trn']['id'][$i];
		$montantTotal = $montantTotal + $prix;
		$panier.='
				<tr>
					<td>'.$nomProduit.'</td>
					<td>'.number_format($prix, 2,'.','').' �</td>
					<td><a href="panier.php?contenu=panier&action=supprimer&id='.$clef.'" title="Supprimer ce article de panier"><img src="stockage_img/supprimer.png" alt="Supprimer ce article de panier"/></a></td>
				</tr>
			';
	}
	$_SESSION['total']=$montantTotal;
	 
	if ( isset($_GET['supprimer']) ) $alert='<div id="note" class="notice" ><p>Devis supprim�.</p></div><br />';
	else  $alert='<div id="note"></div><br />';
	
	echo'
			<div id="espace_compte">
				<div class="conteneur_ariane_cmd">
					<ul id="compte_ariane_cmd">
						<li class="courant">1. <a href="panier.php">Panier</a></li>
						<li>2. Paiement</li>
						<li class="ariane_cmd_fil"></li>
					</ul>
				</div>
			</div><br />
			'.$alert.'
			<div id="espace_compte">
				<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
					<tr class="entete">
						<td>D�signation</td>
						<td>Prix</td>
						<td class="width_40">Supr.</td>
					</tr>
					'.$panier.'
					<tr class="total">
						<td colspan="2"><strong>Total : </strong></td>
						<td class="prix_final">'.number_format($montantTotal, 2,'.','').'�</td>
					</tr>
				</table>
				<p id="panier_boutons">
					<span class="panier_actions"><a class="panier_vider" href="panier.php?contenu=panier&action=vider">Vider le panier</a></span>
					<input type="button" value="Payer ma commande" onclick="javascript:window.location=\'panier.php?contenu=paiement\'" />
					<input type="button" value="Continuer vos achats" onclick="javascript:history.go(-2)" />
				</p>
			</div>
		';
}	
else
{
	if ( isset($_GET['paiement']) && $_GET['paiement']=='valider' ) $mp='<div id="note" class="success">Le paiement a �t� effectu� avec succ�s.</div>';
	else if ( isset($_GET['paiement'])&& $_GET['paiement']=='annuler' )$mp='<div id="note" class="error">Le paiement a �t� annul�e.</div>';
	echo '<div class="bloc-consult"><p>Votre panier est vide.</p></div>';
}							
?>								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
							</div>
						</div>
						
						
						
				</div>	

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>

<?php include('inc/pied.php');?>
	</body>
</html>