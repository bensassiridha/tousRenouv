<?php 

$my = new mysql();


/*

$info_devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id=1506 ' );
$info_adresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$info_devis['id_adresse'].' ');

$temp1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$info_devis['id'].' AND statut_achat=-2 ');
$info_devis_prix = $my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$temp1['id'].' ' );
$info_pro = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$temp1['id_client_pro'].' ');
$info_ville_pro=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_pro['ville'].' ');

$info_part = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$info_devis['id_client'].' ');
$info_ville_part=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_part['ville'].' ');


require_once('pdf/fpdf/fpdf.php');
require_once('pdf/fpdi/fpdi.php');



$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile('pdf/facture.pdf');
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0, 0);


$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(180, 12.5);$pdf->Write(0, date('d-m-Y',time()));//Date
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(130, 75);$pdf->Write(0, ''.$info_pro['civ'].' '.$info_pro['nom'].' '.$info_pro['prenom'].'');//nom et prenom client pro
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(130, 80);$pdf->Write(0, ''.$info_pro['code_postal'].' '.$info_ville_pro['ville_nom_reel'].'');//code pastal et ville client pro
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(130, 85);$pdf->Write(0, 'France');//Pays client pro
	
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(121, 109.6);$pdf->Write(0, $info_devis['id']);//n°
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(6, 141);$pdf->Write(0, $info_devis['reference']);//Ref
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(32, 146);$pdf->Write(0, ''.$info_part['id'].' '.$info_part['nom'].' '.$info_part['prenom'].'');//nom et prenom client part
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(32, 151);$pdf->Write(0, ''.$info_part['code_postal'].' '.$info_ville_part['ville_nom_reel'].'');//code pastal et ville client part
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(116, 141);$pdf->Write(0, number_format($info_devis_prix['prix'],2,',',' '));//PU HT
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(131, 141);$pdf->Write(0, number_format(($info_devis_prix['prix']+$info_devis_prix['prix']*$info_devis['tva_pro']/100),2,',',' '));//PU TTC
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 141);$pdf->Write(0, number_format($info_devis_prix['prix'],2,',',' '));//Total HT (colonne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(177, 141);$pdf->Write(0, number_format(($info_devis_prix['prix']+$info_devis_prix['prix']*$info_devis['tva_pro']/100),2,',',' '));//Total TTC (colonne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(191, 141);$pdf->Write(0, ''.$info_devis['tva_pro'].' %');//TVA (colonne)

$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 158);$pdf->Write(0, number_format($info_devis_prix['prix'],2,',',' '));//Total HT (ligne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 165);$pdf->Write(0, ''.$info_devis['tva_pro'].' %');//TVA (ligne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 173);$pdf->Write(0, number_format(($info_devis_prix['prix']+$info_devis_prix['prix']*$info_devis['tva_pro']/100),2,',',' '));//Total TTC (ligne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 181);$pdf->Write(0, number_format(0,2,',',' '));//Reglement
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 188);$pdf->Write(0, number_format(($info_devis_prix['prix']+$info_devis_prix['prix']*$info_devis['tva_pro']/100),2,',',' '));//Tet à payer


$pdf->Output('../upload/factures/facture_'.$info_devis['id'].'.pdf','f');


*/





/*
$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-3' );
while ( $res=$my->arr($req) )
{
	$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
	$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
	$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
	$rs4=$my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$rs3['departement_id'].' ');

	$my->req('UPDATE ttre_achat_devis SET user_zone="'.$rs4['id_user'].'" WHERE id='.$res['id']);
}
*/

if ( isset($_GET['action']) )
{
	switch( $_GET['action'] )
	{
		case 'archifier' :
			/*$temp=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_part WHERE id='.$temp['id_client'].' ');
			$my->req('DELETE FROM ttre_client_part_adresses WHERE id='.$temp['id_adresse'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			while ( $res=$my->arr($req) )
			{
				@unlink('../upload/devis/'.$res['fichier']);
			}
			$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');*/
			$my->req('UPDATE ttre_achat_devis SET stat_suppr="1" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_admin_envoye&supprimer=ok');
			break;
		case 'creerfacture' :
			//------------------------------------- debut facture ------------------------------------------
			$info_devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ' );
			$info_adresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$info_devis['id_adresse'].' ');
				
			$temp1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$info_devis['id'].' AND statut_achat=-2 ');
			$info_devis_prix = $my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$temp1['id'].' ' );
			$info_pro = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$temp1['id_client_pro'].' ');
			$info_ville_pro=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_pro['ville'].' ');
				
			$info_part = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$info_devis['id_client'].' ');
			$info_ville_part=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_part['ville'].' ');
				
			require_once('pdf/fpdf/fpdf.php');
			require_once('pdf/fpdi/fpdi.php');
				
			$pdf = new FPDI();
			$pdf->AddPage();
			$pdf->setSourceFile('pdf/facture.pdf');
			$tplIdx = $pdf->importPage(1);
			$pdf->useTemplate($tplIdx, 0, 0, 0);
				
			$pp=$info_devis_prix['prix']*$info_devis['note_devis']/100;
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(180, 12.5);$pdf->Write(0, date('d-m-Y',time()));//Date
			$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(130, 75);$pdf->Write(0, ''.$info_pro['civ'].' '.$info_pro['nom'].' '.$info_pro['prenom'].'');//nom et prenom client pro
			$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(130, 80);$pdf->Write(0, ''.$info_pro['code_postal'].' '.$info_ville_pro['ville_nom_reel'].'');//code pastal et ville client pro
			$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(130, 85);$pdf->Write(0, 'France');//Pays client pro
				
			$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(121, 109.6);$pdf->Write(0, $info_devis['id']);//n°
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(6, 141);$pdf->Write(0, $info_devis['reference']);//Ref
			$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(32, 146);$pdf->Write(0, ''.$info_part['civ'].' '.$info_part['nom'].' '.$info_part['prenom'].'');//nom et prenom client part
			$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(32, 151);$pdf->Write(0, ''.$info_part['code_postal'].' '.$info_ville_part['ville_nom_reel'].'');//code pastal et ville client part
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(116, 141);$pdf->Write(0, number_format($pp,2,',',' '));//PU HT
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(131, 141);$pdf->Write(0, number_format(($pp+$pp*$info_devis['tva_pro']/100),2,',',' '));//PU TTC
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 141);$pdf->Write(0, number_format($pp,2,',',' '));//Total HT (colonne)
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(177, 141);$pdf->Write(0, number_format(($pp+$pp*$info_devis['tva_pro']/100),2,',',' '));//Total TTC (colonne)
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(191, 141);$pdf->Write(0, ''.$info_devis['tva_pro'].' %');//TVA (colonne)
				
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 158);$pdf->Write(0, number_format($pp,2,',',' '));//Total HT (ligne)
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 165);$pdf->Write(0, ''.$info_devis['tva_pro'].' %');//TVA (ligne)
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 173);$pdf->Write(0, number_format(($pp+$pp*$info_devis['tva_pro']/100),2,',',' '));//Total TTC (ligne)
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 181);$pdf->Write(0, number_format(0,2,',',' '));//Reglement
			$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 0);$pdf->SetXY(161.5, 188);$pdf->Write(0, number_format(($pp+$pp*$info_devis['tva_pro']/100),2,',',' '));//Tet à payer
				
			$pdf->Output('../upload/factures/facture_'.$info_devis['id'].'.pdf','f');
			
			rediriger('?contenu=devis_admin_envoye&creerFacture=ok');
			break;
		case 'envoyerfacture' :
			$info_devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ' );
			$info_adresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$info_devis['id_adresse'].' ');
			
			$temp1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$info_devis['id'].' AND statut_achat=-2 ');
			$info_devis_prix = $my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$temp1['id'].' ' );
			$info_pro = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$temp1['id_client_pro'].' ');
			$info_ville_pro=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_pro['ville'].' ');
			
			$info_part = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$info_devis['id_client'].' ');
			$info_ville_part=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$info_part['ville'].' ');
			
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
								<p>Voici votre facture.</p>
								<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
									<p style="padding-top:10px;">'.$nom_client.'</p>
								</div>
							</div>
						</body>
						</html>
						';
			$destinataire=$info_pro['email'];
			//$destinataire='bilelbadri@gmail.com';
			$email_expediteur=$mail_client;
			$email_reply=$mail_client;
			$titre_mail=$nom_client;
			$sujet=$nom_client.' : Facture ';
		
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
				
			$message .= '--'.$frontiere."\n";
		
			$file_type = mime_content_type('../upload/factures/facture_'.$info_devis['id'].'.pdf');
			$message .= 'Content-Type: '.$file_type.'; name="../upload/factures/facture_'.$info_devis['id'].'.pdf"'."\n";
			$message .= 'Content-Transfer-Encoding: base64'."\n";
			$message .= 'Content-Disposition:attachement; filename="facture_'.$info_devis['id'].'.pdf"'."\n\n";
			$message .= chunk_split(base64_encode(file_get_contents('../upload/factures/facture_'.$info_devis['id'].'.pdf')))."\n";
				
			$message .= '--'.$frontiere.'--'."\r\n";
				
			mail($destinataire,$sujet,$message,$headers);
				
			$sujet=$nom_client.' : Copie Facture ';
			mail($mail_client,$sujet,$message,$headers);
				
			//------------------------------------- fin facture ------------------------------------------
				
				
			rediriger('?contenu=devis_admin_envoye&envoyerFacture=ok');
			break;
		case 'changer' :
			$info_devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ' );
			$my->req('UPDATE ttre_achat_devis SET
						nbr_estimation			=	"0"	,
						prix_achat				=	"0"	,
						note_devis				=	"0"	,
						user_zone				=	"'.$info_devis['prix_achat'].'"	,
						stat_suppr				=	"'.$info_devis['nbr_estimation'].'"	,
						statut_valid_admin		=	"0"
								WHERE id='.$_GET['id']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			while ( $res=$my->arr($req) ) @unlink('../upload/devis_client_pro/'.$res['fichier']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			rediriger('?contenu=devis_admin_envoye&changer=ok');exit;
			break;
	}				
}
else
{
	if ( isset($_POST['mod_cl_pro']) )
	{
		if ( $_POST['selret']!=0 ) 
		{
			$temp=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id='.$_POST['selret']);
			@unlink('../upload/factures/facture_'.$temp['id_devis'].'.pdf');
			$my->req('UPDATE ttre_achat_devis_client_pro SET statut_achat="0" WHERE id_devis='.$temp['id_devis']);
			$my->req('UPDATE ttre_achat_devis_client_pro SET statut_achat="-2" , date_payement="'.time().'" WHERE id='.$_POST['selret']);
		}
		rediriger('?contenu=devis_admin_envoye&modifier=ok');
	}
	if ( isset($_POST['modif_prix']) )
	{
		if ( !empty($_POST['commentaire']) )
			$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_user'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
		
		if ( isset($_POST['prix']) )
			$my->req('UPDATE ttre_achat_devis SET prix_achat="'.$_POST['prix'].'" , tva_pro="'.$_POST['tva_pro'].'" , tva_zone="'.$_POST['tva_zone'].'" , note_devis="'.$_POST['pourcentage'].'" WHERE id='.$_GET['id']);
		
		if ( isset($_POST['retour_devis']) )
		{
			$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="-2" , user_zone="0"  WHERE id='.$_GET['id']);
			$my->req('UPDATE ttre_achat_devis_client_pro SET statut_achat="0" , date_payement="" WHERE id_devis='.$_GET['id']);
			@unlink('../upload/factures/facture_'.$_GET['id'].'.pdf');
		}
	}
	echo '<h1 style="margin-top:0;" >Gérer la liste des devis signés</h1>';
	
	$tabCat[]='';
	$rq=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
	while ( $rs=$my->arr($rq) ) $tabCat[$rs['id']]=$rs['titre'];
	$tabDep[]='';
	$rq=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	while ( $rs=$my->arr($rq) ) $tabDep[$rs['departement_id']]=$rs['departement_nom'];
	$tabUseAj[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=3  ');
	while ( $rs=$my->arr($rq) ) $tabUseAj[$rs['id_user']]=$rs['nom'];
	$tabUseZo[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=2  ');
	while ( $rs=$my->arr($rq) ) $tabUseZo[$rs['id_user']]=$rs['nom'];
	
	if ( isset($_POST['cat']) && !empty($_POST['cat']) ) $cat=$_POST['cat']; else $cat=0;
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
	if ( isset($_POST['use_aj']) && !empty($_POST['use_aj']) ) $use_aj=$_POST['use_aj']; else $use_aj=0;
	if ( isset($_POST['use_zo']) && !empty($_POST['use_zo']) ) $use_zo=$_POST['use_zo']; else $use_zo=0;
	if ( isset($_POST['ddb']) && !empty($_POST['ddb']) ) $ddb=$_POST['ddb']; else $ddb='';
	if ( isset($_POST['dfn']) && !empty($_POST['dfn']) ) $dfn=$_POST['dfn']; else $dfn='';
	
	$sddb=0;$sdfn=0;
	if ( $ddb!='' && $dfn!='' )
	{
		list($jour, $mois, $annee) = explode('/', $ddb);
		$sddb = mktime(0,0,0,$mois,$jour,$annee);
		list($jour, $mois, $annee) = explode('/', $dfn);
		$sdfn = mktime(23,59,59,$mois,$jour,$annee);
	}
	if ( $sddb!=0 ) $where_date=' AND AD.date_ajout>='.$sddb.' AND AD.date_ajout<='.$sdfn.' '; else $where_date='';
	if ( $use_aj!=0 ) $where_user_ajout=' AND AD.nbr_estimation='.$use_aj.' '; else $where_user_ajout='';
	if ( $use_zo!=0 ) $where_user_zone=' AND AD.user_zone='.$use_zo.' '; else $where_user_zone='';
	?>
					<link type="text/css" href="calandar/themes/base/ui.all.css" rel="stylesheet" />
		<!--  				<script type="text/javascript" src="calandar/jquery-1.3.2.js"></script>  -->
					<script type="text/javascript" src="calandar/ui/ui.core.js"></script>
					<script type="text/javascript" src="calandar/ui/ui.datepicker.js"></script>
					<script type="text/javascript" src="calandar/ui/i18n/ui.datepicker-fr.js"></script>
					<link type="text/css" href="calandar/demos.css" rel="stylesheet" />
					<script type="text/javascript">
					    $(function() {
					    $.datepicker.setDefaults($.extend({showMonthAfterYear: false}, $.datepicker.regional['']));
					    $(".datepicker").datepicker($.datepicker.regional['fr']);
					    $('.datepicker').datepicker('option', $.extend({showMonthAfterYear: false},
					    $.datepicker.regional['fr']));
					    });
					</script>
	<?php 
	$form = new formulaire('modele_1','?contenu=devis_admin_envoye','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Catégorie','cat',$tabCat,$cat);
	$form->select_cu('Département','dep',$tabDep,$dep);
	$form->select_cu('User ajout','use_aj',$tabUseAj,$use_aj);
	$form->select_cu('User zone','use_zo',$tabUseZo,$use_zo);
	$form->vide('<tr><td colspan="2">
				Date de debut : <input class="datepicker" type="text" name="ddb" value="'.$ddb.'" />
				Date de fin : <input value="'.$dfn.'" name="dfn" class="datepicker" type="text" />
				</td></tr>');
	$form->afficher1('Rechercher');
	
	$alert='';
	if ( isset($_GET['supprimer']) ) $alert='<div class="success"><p>Ce devis a bien été archivé.</p></div>';
	if ( isset($_GET['modifier']) ) $alert='<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	if ( isset($_GET['creerFacture']) ) $alert='<div class="success"><p>La facture a bien été crée.</p></div>';
	if ( isset($_GET['envoyerFacture']) ) $alert='<div class="success"><p>La facture a bien été envoyé.</p></div>';
	if ( isset($_GET['changer']) ) echo '<div class="success"><p>Ce devis a bien été changé.</p></div>';
	
	if ( $dep==0 && $cat==0 )
	{
		$req = $my->req('SELECT AD.id as idad
							FROM
								ttre_achat_devis AD ,
								ttre_achat_devis_client_pro DC
							WHERE
								AD.statut_valid_admin=-3
								'.$where_user_ajout.'
								'.$where_user_zone.'
								'.$where_date.'
								AND AD.id=DC.id_devis
								AND DC.statut_achat=-2
								AND AD.stat_suppr=0
							ORDER BY AD.id DESC');
	}
	elseif ( $dep==0 && $cat!=0 )
	{
		$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_achat_devis_details ADS ,
									ttre_achat_devis_client_pro DC
								WHERE
									AD.id=ADS.id_devis
									'.$where_user_ajout.'
									'.$where_user_zone.'
									'.$where_date.'
									AND ADS.id_categ='.$cat.'
									AND AD.statut_valid_admin=-3
									AND AD.id=DC.id_devis
									AND DC.statut_achat=-2
									AND AD.stat_suppr=0
								ORDER BY AD.id DESC');
	}
	elseif ( $dep!=0 && $cat==0 )
	{
		$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_client_part_adresses CPA ,
									ttre_villes_france VF ,
									ttre_departement_france DF,
									ttre_achat_devis_client_pro DC
								WHERE
									DF.departement_id='.$dep.'
									'.$where_user_ajout.'
									'.$where_user_zone.'
									'.$where_date.'
									AND DF.departement_code=VF.ville_departement
									AND VF.ville_id=CPA.ville
									AND CPA.id=AD.id_adresse
									AND AD.statut_valid_admin=-3
									AND AD.id=DC.id_devis
									AND DC.statut_achat=-2
									AND AD.stat_suppr=0
								ORDER BY AD.id DESC');
	}
	elseif ( $dep!=0 && $cat!=0 )
	{
		$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD ,
									ttre_client_part_adresses CPA ,
									ttre_villes_france VF ,
									ttre_departement_france DF ,
									ttre_achat_devis_details ADS,
									ttre_achat_devis_client_pro DC
								WHERE
									DF.departement_id='.$dep.'
									'.$where_user_ajout.'
									'.$where_user_zone.'
									'.$where_date.'
									AND DF.departement_code=VF.ville_departement
									AND VF.ville_id=CPA.ville
									AND CPA.id=AD.id_adresse
									AND AD.id=ADS.id_devis
									AND ADS.id_categ='.$cat.'
									AND AD.statut_valid_admin=-3
									AND AD.id=DC.id_devis
									AND DC.statut_achat=-2
									AND AD.stat_suppr=0
								ORDER BY AD.id DESC');
	}
	//$req = $my->req('SELECT * FROM ttre_achat_devis D , ttre_achat_devis_client_pro DC WHERE D.id=DC.id_devis AND DC.statut_achat=-2 AND D.statut_valid_admin=-3 ORDER BY D.date_ajout DESC ');
	if ( $my->num($req)>0 )
	{
		$userprofil =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
		if ( $userprofil['profil']==1 ) { $td_supp='<td class="bouton"></td>'; $td_prix='<td>P.U.A <br /> P.D <br /> TVA PRO  <br /> TVA ZON <br /> % </td>'; $td_cat=''; $td_facture='<td class="bouton">Facture</td>'; }
		else { $td_supp=''; $td_prix='<td>Prix</td>'; $td_cat='<td>Catégorie</td>'; $td_facture=''; }
				
		echo'
			'.$alert.'
			<table id="liste_produits">
			<tr class="entete">
				<td>Date de création / Ref</td>
				<td>Date de signature</td>
				<td>Client</td>
				<td>User</td>	
				'.$td_cat.'
				<td>Ville / Département</td>
				'.$td_prix.'
				'.$td_facture.'
				<td class="bouton">Détail / <br /> Imprimer</td>
				'.$td_supp.'
			</tr>
			';
		$various='';
		while ( $ress=$my->arr($req) )
		{
			$res = $my->req_arr('SELECT * FROM ttre_achat_devis D , ttre_achat_devis_client_pro DC WHERE D.id='.$ress['idad'].' AND D.id=DC.id_devis AND DC.statut_achat=-2 AND D.statut_valid_admin=-3 ORDER BY D.date_ajout DESC ');
			
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
				
				$ress=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
				
				$reso = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
				$reso_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$reso['ville'].'" ');
				$resoo = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['id_client_pro'].' ');
				$resoo_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$resoo['ville'].'" ');
				
				$detail.='
					<ul id="compte_details_com" class="livraison">
						<li style="width:20%">
							<h4>Adresse de chantier</h4>
							<dl>
								<dd>Numero et voie : '.$num_voie.'</dd>
								<dd>N° d’appartement : '.$num_appart.'</dd>
								<dd>Bâtiment : '.$batiment.'</dd>
								<dd>'.$code_postal.' '.$ville.'</dd>
								<dd>'.$pays.'</dd>
							</dl>
						</li>
						<li style="width:30%">
							<h4>Informations de client particulier</h4>
							<dl>
								<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst($reso['nom']).' '.ucfirst($reso['prenom']).'</dd>
								<dd>'.html_entity_decode($reso['telephone']).' - '.html_entity_decode($reso['email']).'</dd>
								<dd>Numéro et voie : '.html_entity_decode($reso['num_voie']).'</dd>
								<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($reso['num_appart']).'</dd>
								<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($reso['batiment']).'</dd>
								<dd>'.html_entity_decode($reso['code_postal']).' '.html_entity_decode($reso_ville['ville_nom_reel']).'</dd>
								<dd>'.html_entity_decode($reso['pays']).'</dd>
							</dl>
						</li>
						<li style="width:40%;text-align:left;">
							<h4>Informations de client professionnel</h4>
							<dl>
								<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst($resoo['nom']).' '.ucfirst($resoo['prenom']).'</dd>
								<dd>'.html_entity_decode($resoo['telephone']).' - '.html_entity_decode($resoo['email']).'</dd>
								<dd>Numéro et voie : '.html_entity_decode($resoo['num_voie']).'</dd>
								<dd>'.html_entity_decode($resoo['code_postal']).' '.html_entity_decode($resoo_ville['ville_nom_reel']).'</dd>
								<dd>'.html_entity_decode($resoo['pays']).'</dd>
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
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id_devis'].' ORDER BY ordre_categ ASC ');
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
				
				$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$res['id_devis'].' ');
				if ( $my->num($req_f)>0 )
				{
					$detail.='<p><br /> Fichiers à télécharger : ';
					while ( $res_f=$my->arr($req_f) )
					{
						$detail.='<a target="_blanc" href="../upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
					}
					$detail.='</p>';
				}
				
				$op='';
				$reqsel=$my->req('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-1 ORDER BY id ASC ');
				while ( $ressel=$my->arr($reqsel) )
				{
					$info_client=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ressel['id_client_pro'].'  ');
					$op.='<option value="'.$ressel['id'].'">'.strtoupper(html_entity_decode($info_client['nom'])).' '.ucfirst(html_entity_decode($info_client['prenom'])).'</option>';
				}
				
				$touscom='';
				$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$res['id_devis'].' ORDER BY date ASC');
				if ( $my->num($reqComm)>0 )
				{
					$touscom.='
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td width="20%">Date</td>
								<td width="20%">User</td>
								<td>Commentaire</td>
							</tr>
						</thead>
						<tbody>
					';
					while ( $resComm=$my->arr($reqComm) )
					{
						if ( $resComm['date']!=0 ) $d=date('d/m/Y H:i',$resComm['date']); else $d='';
						$us =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$resComm['id_user'].'"');
						if ( $resComm['id_user']!=0 ) $u=$us['nom']; else $u='';
						if ( $us['profil']==1 ) $u='Administrateur';
						$touscom.='
								<tr>
									<td>'.$d.'</td>
									<td>'.$u.'</td>
									<td>'.$resComm['commentaire'].'</td>
								</tr>
						';
					}
					$touscom.='
					</tbody>
					</table>
					';
				}
				
				$various.='
						<div style="display: none;">
							<div id="inline'.$res['id_devis'].'" style="width:750px;height:500px;overflow:auto;">
								<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
									'.$detail.'
									<br /><br />
									<form method="post">
										<select name="selret">
											<option value="0">Selectionner un autre client</option>
											'.$op.'
										</select>
										<input type="submit" name="mod_cl_pro" value="Modifier" />
									</form>	
									<br /><br />
						<form method="POST" action="?contenu=devis_admin_envoye&id='.$res['id_devis'].'" enctype="multipart/form-data" >
							<p>Commentaire devis :
								'.$touscom.'
								<br /> Ajouter commentaire : <textarea name="commentaire" style="width:80%;height:150px;" ></textarea><br /><br />
							</p>
							<br /><p>Prix : <input type="text" name="prix" value="'.$res['prix_achat'].'" onKeyPress="return scanFTouche(event)" >
							<br />TVA PRO : <input type="text" name="tva_pro" value="'.$res['tva_pro'].'" onKeyPress="return scanTouche(event)" >
							<br />TVA ZONE : <input type="text" name="tva_zone" value="'.$res['tva_zone'].'" onKeyPress="return scanTouche(event)" >
							<br /><br /><p>Pourcentage : <input type="text" name="pourcentage" value="'.$res['note_devis'].'" onKeyPress="return scanFTouche(event)" >
							<br /><br /><input type="checkbox" name="retour_devis"  value="0" > Retour à l\'étape precédente			
							<br /><br /><input type="submit" value="Modifier" name="modif_prix"/></p>
						</form>
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
				$ua =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
				$uz =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['user_zone'].'"');
				if ($res['date_payement']!=0 ) $dvcp=date('d/m/Y',$res['date_payement']); else $dvcp='';
						//<td>'.$nc.'</td>
						
				$p1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
				$p2=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$p1['id'].' ');
				
				if ( file_exists('../upload/factures/facture_'.$res['id_devis'].'.pdf') )
				{
					$facture='<a href="../upload/factures/facture_'.$res['id_devis'].'.pdf" target="_blanc" > Voir </a>
							<br /><br /><a href="?contenu=devis_admin_envoye&action=creerfacture&id='.$res['id_devis'].'"> Modifier </a>
							<br /><br /><a href="?contenu=devis_admin_envoye&action=envoyerfacture&id='.$res['id_devis'].'"> Envoyer </a>
							';
				}
				else
					$facture='<a href="?contenu=devis_admin_envoye&action=facture&id='.$res['id_devis'].'"> Pas encore créer </a>';
					
					//<br /><a href="../upload/factures/facture_'.$res['id_devis'].'.pdf" target="_blanc">voir la facture</a> 
					
					
				echo'
					<tr style="text-align:center;">
						<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
						<td>'.$dvcp.'</td>
						<td>'.strtoupper($info_client['nom']).' '.ucfirst($info_client['prenom']).'</td>
						<td>'.$ua['nom'].' (ajout) / '.$uz['nom'].' (zone)</td>		
						<td>'.$vd.'</td>
						<td>'.number_format($res['prix_achat'],2).' € <br /> '.number_format($p2['prix'],2).' <br /> '.$res['tva_pro'].' % <br /> '.$res['tva_zone'].' %<br />'.$res['note_devis'].' %</td>						
						<td class="bouton">'.$facture.'</td>
						<td class="bouton">
							<a class="various1" href="#inline'.$res['id_devis'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a>		
							/ 
							<a id="various3" href="imp_devis_envoye.php?id='.$res['id_devis'].'" title="Devis"><img src="img/icone_imprimer.png" alt="Devis" border="0" /></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir archiver ce devis ?\'))
							{window.location=\'?contenu=devis_admin_envoye&action=archifier&id='.$res['id_devis'].'\'}" title="Archiver">
							Archiver</a>
							<br /><br /><a style="color:red;" href="?contenu=devis_admin_envoye&action=changer&id='.$res['id_devis'].'" title="Achat immédiat">Changer</a>
						</td>
					</tr>
					';
			}
			elseif ( $userprofil['profil']==2 || $userprofil['profil']==6 )
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
					
					$ress=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
					
					$reso = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
					$reso_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$reso['ville'].'" ');
					$resoo = $my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$ress['id_client_pro'].' ');
					$resoo_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$resoo['ville'].'" ');
					
					$detail.='
						<ul id="compte_details_com" class="livraison">
							<li style="width:20%">
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>Numero et voie : '.$num_voie.'</dd>
									<dd>N° d’appartement : '.$num_appart.'</dd>
									<dd>Bâtiment : '.$batiment.'</dd>
									<dd>'.$code_postal.' '.$ville.'</dd>
									<dd>'.$pays.'</dd>
								</dl>	
							</li>	
							<li style="width:30%">
								<h4>Informations de client particulier</h4>
								<dl>
									<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst($reso['nom']).' '.ucfirst($reso['prenom']).'</dd>
									<dd>'.html_entity_decode($reso['telephone']).' - '.html_entity_decode($reso['email']).'</dd>
									<dd>Numéro et voie : '.html_entity_decode($reso['num_voie']).'</dd>
									<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($reso['num_appart']).'</dd>
									<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($reso['batiment']).'</dd>
									<dd>'.html_entity_decode($reso['code_postal']).' '.html_entity_decode($reso_ville['ville_nom_reel']).'</dd>
									<dd>'.html_entity_decode($reso['pays']).'</dd>
								</dl>
							</li>
							<li style="width:40%;text-align:left;">
								<h4>Informations de client professionnel</h4>
								<dl>
									<dd>'.ucfirst(html_entity_decode($resoo['civ'])).' '.ucfirst($resoo['nom']).' '.ucfirst($resoo['prenom']).'</dd>
									<dd>'.html_entity_decode($resoo['telephone']).' - '.html_entity_decode($resoo['email']).'</dd>
									<dd>Numéro et voie : '.html_entity_decode($resoo['num_voie']).'</dd>
									<dd>'.html_entity_decode($resoo['code_postal']).' '.html_entity_decode($resoo_ville['ville_nom_reel']).'</dd>
									<dd>'.html_entity_decode($resoo['pays']).'</dd>
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
					$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id_devis'].' ORDER BY ordre_categ ASC ');
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
					
					$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$res['id_devis'].' ');
					if ( $my->num($req_f)>0 )
					{
						$detail.='<p><br /> Fichiers à télécharger : ';
						while ( $res_f=$my->arr($req_f) )
						{
							$detail.='<a target="_blanc" href="../upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
						}
						$detail.='</p>';
					}
					
					$touscom='';
					$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$res['id_devis'].' ORDER BY date ASC');
					if ( $my->num($reqComm)>0 )
					{
						$touscom.='
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td width="20%">Date</td>
								<td width="20%">User</td>
								<td>Commentaire</td>
							</tr>
						</thead>
						<tbody>
					';
						while ( $resComm=$my->arr($reqComm) )
						{
							if ( $resComm['date']!=0 ) $d=date('d/m/Y H:i',$resComm['date']); else $d='';
							$us =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$resComm['id_user'].'"');
							if ( $resComm['id_user']!=0 ) $u=$us['nom']; else $u='';
							if ( $us['profil']==1 ) $u='Administrateur';
							$touscom.='
								<tr>
									<td>'.$d.'</td>
									<td>'.$u.'</td>
									<td>'.$resComm['commentaire'].'</td>
								</tr>
						';
						}
						$touscom.='
					</tbody>
					</table>
					';
					}
					
					$various.='
							<div style="display: none;">
								<div id="inline'.$res['id_devis'].'" style="width:750px;height:500px;overflow:auto;">
									<div id="espace_compte" style="width:700px;margin:0 0 0 25px;">
										'.$detail.'
								
										<form method="POST" action="?contenu=devis_admin_envoye&id='.$res['id_devis'].'" enctype="multipart/form-data" >
											<p>Commentaire devis :
												'.$touscom.'
												<br /> Ajouter commentaire : <textarea name="commentaire" style="width:80%;height:150px;" ></textarea><br /><br />
											</p>
											<br /><br />			
											<input type="submit" value="Ajouter" name="modif_prix"/></p>
										</form>
										
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
					$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
					if ($res['date_payement']!=0 ) $dvcp=date('d/m/Y',$res['date_payement']); else $dvcp='';
					
					$p1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id_devis'].' AND statut_achat=-2 ');
					$p2=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$p1['id'].' ');
					$p=($p2['prix']*$res['note_devis']/100)/2;
					$ptva=$p+($p*$res['tva_zone']/100);
					echo'
						<tr style="text-align:center;">
							<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
							<td>'.$dvcp.'</td>
							<td>'.strtoupper($info_client['nom']).' '.ucfirst($info_client['prenom']).'</td>
							<td>'.$u['nom'].'</td>		
							<td>'.$nc.'</td>
							<td>'.$vd.'</td>
							<td>'.number_format($ptva,2).' €</td>
							<td class="bouton">
								<a class="various1" href="#inline'.$res['id_devis'].'" title="Détail"><img src="img/icone_detail.gif" alt="Modifier" border="0" /></a>		
								/ 
								<a id="various3" href="imp_devis_envoye.php?id='.$res['id_devis'].'" title="Devis"><img src="img/icone_imprimer.png" alt="Devis" border="0" /></a>
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
	$("a.example2").fancybox({
		'titleShow'		: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	$("a#various3").fancybox({
		'width'				: '72%',
		'height'			: '97%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>
