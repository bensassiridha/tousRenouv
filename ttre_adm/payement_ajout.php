<?php 
$my = new mysql();
echo '<h1>Gérer les virements</h1>';

$total=0;
//devis achat immediat
$req_user = $my->req('SELECT * FROM ttre_achat_devis WHERE stat_suppr='.$_SESSION['id_user'].' AND statut_valid_admin>=0 ');
while ( $res_user=$my->arr($req_user) ) $total=$total+$res_user['user_zone'];
//devis admin ajout
$req_user = $my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$_SESSION['id_user'].' AND stat_suppr=0 AND statut_valid_admin<-1 ');
while ( $res_user=$my->arr($req_user) ) $total=$total+$res_user['prix_achat'];
$req_user = $my->req('SELECT * FROM ttre_achat_devis AD , ttre_achat_devis_suite ADSS 
		WHERE AD.nbr_estimation='.$_SESSION['id_user'].' AND AD.statut_valid_admin=-1 AND AD.stat_suppr=0 AND AD.id=ADSS.id_devis
		AND	ADSS.stat_ajout_zone=0 AND ( ADSS.stat_devis_attente=1 ) ');
		//AND	ADSS.stat_ajout_zone=0 AND ( ADSS.stat_devis_attente=1 || ADSS.stat_devis_attente=6 ) ');
while ( $res_user=$my->arr($req_user) ) $total=$total+$res_user['prix_achat'];


$payer=0;
$req_user = $my->req('SELECT * FROM ttre_pyement_user_ajout WHERE id_user='.$_SESSION['id_user'].' ');
while ( $res_user=$my->arr($req_user) ) $payer=$payer+$res_user['montant'];

echo'
	<br /><br />
	<p>Montant total : '.number_format($total,2).' €</p>			
	<p>Montant payé : '.number_format($payer,2).' €</p>			
	<p>Montant resté : '.number_format($total-$payer,2).' €</p>	
	<br /><br />					
		';
	
$req = $my->req('SELECT * FROM ttre_pyement_user_ajout WHERE id_user='.$_SESSION['id_user'].' ORDER BY date DESC ');
if ( $my->num($req)>0 )
{
	echo'
			<table id="liste_produits">
				<thead>
					<tr class="entete">
						<td colspan="3">Virement</td>
					</tr>
					<tr>
						<td colspan="3"></td>
					</tr>
					<tr class="entete">
						<td>Date</td>
						<td>Montant</td>
						<td>Commentaire</td>
					</tr>
				</thead>
				<tbody> 
		';
	while ( $res=$my->arr($req) )
	{
		echo'
			<tr>
				<td>'.date('d/m/Y',$res['date']).'</td>
				<td>'.number_format($res['montant'],2).' €</td>
				<td>'.$res['commentaire'].'</td>
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