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
$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				list($jour, $mois, $annee) = explode('/', $_POST['date']);
				$timestamp = mktime(0,0,0,$mois,$jour,$annee);
				$my->req('INSERT INTO ttre_pyement_user_zone VALUES("",
										"'.$my->net_input($timestamp).'",
										"'.$my->net_input($_POST['iduser']).'",
										"'.$my->net_input($_POST['prix']).'",
										"'.$my->net_textarea($_POST['commentaire']).'"
										)');
				rediriger('?contenu=payement_zone_admin&ajouter=ok');
			}
			else
			{
				$tabUse[]='';
				$rq=$my->req('SELECT * FROM ttre_users WHERE profil=2  ');
				while ( $rs=$my->arr($rq) ) $tabUse[$rs['id_user']]=$rs['nom'];
				
				$form = new formulaire('modele_1','?contenu=payement_zone_admin&action=ajouter','','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->select('User ajout','iduser',$tabUse);
				$form->text_datepicker('Date','date','',1);
				$form->text('Prix','prix','onKeyPress="return scanFTouche(event)"',1,'0');
				$form->textarea('Commentaire','commentaire');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=payement_zone_admin">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				list($jour, $mois, $annee) = explode('/', $_POST['date']);
				$timestamp = mktime(0,0,0,$mois,$jour,$annee);
				$my->req('UPDATE ttre_pyement_user_zone SET 
									date		=	"'.$my->net_input($timestamp).'" ,
									id_user		=	"'.$my->net_input($_POST['iduser']).'" ,
									montant		=	"'.$my->net_input($_POST['prix']).'" ,
									commentaire	=	"'.$my->net_textarea($_POST['commentaire']).'" 
								WHERE id = '.$_GET['id'].' ');				
				rediriger('?contenu=payement_zone_admin&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				$tabUse[]='';
				$rq=$my->req('SELECT * FROM ttre_users WHERE profil=2  ');
				while ( $rs=$my->arr($rq) ) $tabUse[$rs['id_user']]=$rs['nom'];
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Ce virement a bien été modifié.</p></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_pyement_user_zone WHERE id='.$_GET['id'].' ');
				$form = new formulaire('modele_1','?contenu=payement_zone_admin&action=modifier&id='.$_GET['id'].'','','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->select_cu('User ajout','iduser',$tabUse,$temp['id_user']);
				$form->text_datepicker('Date','date','',1,date('d/m/Y',$temp['date']));
				$form->text('Prix','prix','onKeyPress="return scanFTouche(event)"',1,$temp['montant']);
				$form->textarea('Commentaire','commentaire',str_replace('<br />','',$temp['commentaire']));
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=payement_zone_admin">Retour</a></p>';
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_pyement_user_zone WHERE id='.$_GET['id'].' ');
			rediriger('?contenu=payement_zone_admin&supprimer=ok');
			break;	
	}
}
else
{
	echo '<h1>Gérer les virements</h1>';
	
	$tabUse[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=2  ');
	while ( $rs=$my->arr($rq) ) $tabUse[$rs['id_user']]=$rs['nom'];
	
	if ( isset($_POST['use']) && !empty($_POST['use']) ) $use=$_POST['use']; else $use=0;
	
	$form = new formulaire('modele_1','?contenu=payement_zone_admin','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('User zone','use',$tabUse,$use);
	$form->afficher1('Rechercher');
	
	if ( $use!=0 ) 
	{
		$total=0;$total_tva=0;
		$req = $my->req('SELECT * FROM ttre_achat_devis WHERE user_zone='.$use.' AND statut_valid_admin=-3 AND stat_suppr=0  ');
		while ( $res=$my->arr($req) ) 
		{
			$p1=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro WHERE id_devis='.$res['id'].' AND statut_achat=-2 ');
			$p2=$my->req_arr('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_adcp='.$p1['id'].' ');
			$p=($p2['prix']*$res['note_devis']/100)/2;
			$total=$total+$p;
			$tva=$p*$res['tva_zone']/100;
			$total_tva=$total_tva+$tva;
		}
		
		$payer=0;
		$req_user = $my->req('SELECT * FROM ttre_pyement_user_zone WHERE id_user='.$use.' ');
		while ( $res_user=$my->arr($req_user) ) $payer=$payer+$res_user['montant'];
		
		echo'
			<br /><br />
			<p>THT: '.number_format($total,2).' €</p>			
			<p>TVA: '.number_format($total_tva,2).' €</p>			
			<p>TTC: '.number_format($total+$total_tva,2).' €</p>
			<br />			
			<p>Montant payé : '.number_format($payer,2).' €</p>			
			<p>Montant resté : '.number_format($total+$total_tva-$payer,2).' €</p>	
			<br /><br />					
			';
		$where_user=' AND id_user='.$use.' '; 
	}
	else $where_user='';
	
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce virement a bien été ajouté.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce virement a bien été supprimée.</p></div>';
	echo '<p>Pour ajouter un autre virement, cliquer <a href="?contenu=payement_zone_admin&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_pyement_user_zone WHERE 1=1 '.$where_user.' ORDER BY date DESC ');
	if ( $my->num($req)>0 )
	{
		echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Date</td>
							<td>User</td>
							<td>Montant</td>
							<td>Commentaire</td>
							<td class="bouton">Modifier</td>
							<td class="bouton">Supprimer</td>
						</tr>
					</thead>
					<tbody> 
			';
		while ( $res=$my->arr($req) )
		{
			$info_user=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_user'].'  ');
			echo'
				<tr>
					<td>'.date('d/m/Y',$res['date']).'</td>
					<td>'.$info_user['nom'].'</td>		
					<td>'.number_format($res['montant'],2).' €</td>
					<td>'.$res['commentaire'].'</td>
					<td class="bouton">
						<a href="?contenu=payement_zone_admin&action=modifier&id='.$res['id'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer cette conseil ?\')) 
						{window.location=\'?contenu=payement_zone_admin&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'
				</tbody> 
				</table>
			';
	}
	else
	{
		echo '<p>Pas virement ...</p>';
	}
}
?>
<script type="text/javascript">
/*$(document).ready(function() 
{
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.titre.value) ) { mes_erreur+='Il faut entrer le champ Titre !';this.titre.focus(); }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").hide().html(mes_erreur).fadeIn("slow"); return(false); }
	});	
});*/
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>