<?php 
$my = new mysql();
echo '<h1>Connexion admin</h1>';
	
$tabAdmin[]='';
$rq=$my->req('SELECT * FROM ttre_users WHERE profil!=1 AND profil!=0 ORDER BY nom ASC ');
while ( $rs=$my->arr($rq) ) $tabAdmin[$rs['id_user']]=$rs['nom'];

if ( isset($_POST['ad']) && !empty($_POST['ad']) ) $ad=$_POST['ad']; else $ad=0;
if ( isset($_POST['dated']) && !empty($_POST['dated']) ) $dated=$_POST['dated']; else $dated='';
if ( isset($_POST['datef']) && !empty($_POST['datef']) ) $datef=$_POST['datef']; else $datef='';

if ( $dated!='' && $datef!='' )
{
	list($jour, $mois, $annee) = explode('/', $dated); 
	$dd = mktime(0,0,0,$mois,$jour,$annee);
	
	list($jour, $mois, $annee) = explode('/', $datef);
	$df = mktime(23,59,59,$mois,$jour,$annee);
}
elseif ( $dated!='' && $datef=='' )
{
	list($jour, $mois, $annee) = explode('/', $dated); 
	$dd = mktime(0,0,0,$mois,$jour,$annee);
	
	$df = mktime(23,59,59,$mois,$jour,$annee);
}
elseif ( $dated=='' && $datef!='' )
{
	list($jour, $mois, $annee) = explode('/', $datef); 
	$dd = mktime(0,0,0,$mois,$jour,$annee);
	
	$df = mktime(23,59,59,$mois,$jour,$annee);
}

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
$form = new formulaire('modele_1','?contenu=connect_admin','','','','sub','txt','','txt_obl','lab_obl');
$form->vide('<tr><td></td><td>Date sous la forme 21/11/2015</td></tr>');
$form->text_datepicker('Date de début','dated','','',$dated);
$form->text_datepicker('Date de fin','datef','','',$datef);
$form->select_cu('Utilisateur','ad',$tabAdmin,$ad);
$form->afficher1('Rechercher');

if ( isset($_POST['ad']) )
{
	if ( $ad!=0 && $dated!='' && $datef!='' )
	{
		$req2=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=2 AND C.id_user='.$_POST['ad'].' AND C.debut>='.$dd.' AND C.fin<='.$df.'  ORDER BY C.id DESC ');
		$req3=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=3 AND C.id_user='.$_POST['ad'].' AND C.debut>='.$dd.' AND C.fin<='.$df.'  ORDER BY C.id DESC ');
	}
	elseif ( $ad!=0 && ( $dated!='' || $datef!='' ) ) 
	{
		$req2=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=2 AND C.id_user='.$_POST['ad'].' AND ( ( C.debut>='.$dd.' AND C.debut<='.$df.' ) OR ( C.fin>='.$dd.' AND C.fin<='.$df.' ) ) ORDER BY C.id DESC ');
		$req3=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=3 AND C.id_user='.$_POST['ad'].' AND ( ( C.debut>='.$dd.' AND C.debut<='.$df.' ) OR ( C.fin>='.$dd.' AND C.fin<='.$df.' ) ) ORDER BY C.id DESC ');
	}
	elseif ( $ad==0 && $dated!='' && $datef!='' ) 
	{
		$req2=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=2 AND C.debut>='.$dd.' AND C.fin<='.$df.'  ORDER BY C.id DESC ');
		$req3=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=3 AND C.debut>='.$dd.' AND C.fin<='.$df.'  ORDER BY C.id DESC ');
	}
	elseif ( $ad==0 && ( $dated!='' || $datef!='' ) ) 
	{
		$req2=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=2 AND ( ( C.debut>='.$dd.' AND C.debut<='.$df.' ) OR ( C.fin>='.$dd.' AND C.fin<='.$df.' ) ) ORDER BY C.id DESC ');
		$req3=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=3 AND ( ( C.debut>='.$dd.' AND C.debut<='.$df.' ) OR ( C.fin>='.$dd.' AND C.fin<='.$df.' ) ) ORDER BY C.id DESC ');
	}
	elseif ( $ad!=0 && $dated=='' && $datef=='' ) 
	{
		$req2=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=2 AND C.id_user='.$_POST['ad'].' ORDER BY C.id DESC ');
		$req3=$my->req('SELECT * FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=3 AND C.id_user='.$_POST['ad'].' ORDER BY C.id DESC ');
	}
	if ( $my->num($req2)>0 || $my->num($req3)>0 )
	{
		echo'<br /><br /><p>Historique de connexion :</p>
				
				
			<table id="liste_produits">
				<thead>
					<tr class="entete">
						<td colspan="3">Admin Zone</td>
					</tr>
				</thead>
				<thead>
					<tr>
						<td colspan="3"></td>
					</tr>
				</thead>
				<tr class="entete">
					<td>Début</td>
					<td>Fin</td>
					<td>User</td>
				</tr>
			';
		while ( $res=$my->arr($req2) )
		{
			$util=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_user'].' ');
			if ( $res['fin']==0 ) $f='en cours'; else $f=date('d/m/Y H:i',$res['fin']);
			echo'
				<tr style="text-align:center;">
					<td>'.date('d/m/Y H:i',$res['debut']).'</td>
					<td>'.$f.'</td>
					<td>'.$util['nom'].'</td>
				</tr>
				';
		}
		echo'</table>';
		
		echo'<br /><br />
				
				
			<table id="liste_produits">
				<thead>
					<tr class="entete">
						<td colspan="3">Admin Ajout</td>
					</tr>
				</thead>
				<thead>
					<tr>
						<td colspan="3"></td>
					</tr>
				</thead>
				<tr class="entete">
					<td>Début</td>
					<td>Fin</td>
					<td>User</td>
				</tr>
			';
		while ( $res=$my->arr($req3) )
		{
			$util=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_user'].' ');
			if ( $res['fin']==0 ) $f='en cours'; else $f=date('d/m/Y H:i',$res['fin']);
			echo'
				<tr style="text-align:center;">
					<td>'.date('d/m/Y H:i',$res['debut']).'</td>
					<td>'.$f.'</td>
					<td>'.$util['nom'].'</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo'<p>Pas de connexion .</p>';
	}
}
else
{
	$req2=$my->req('SELECT DISTINCT ( C.id_user ) FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=2 AND C.fin=0 ');
	$req3=$my->req('SELECT DISTINCT ( C.id_user ) FROM ttre_connection_admin C , ttre_users U WHERE C.id_user=U.id_user AND U.profil=3 AND C.fin=0 ');
	if ( $my->num($req2)>0 || $my->num($req3)>0 )
	{
		echo'<br /><br /><p>La listes des utilisateurs en cours de connexion :</p>
				
			<table id="liste_produits">
				<thead>
					<tr class="entete">
						<td colspan="2">Admin Zone</td>
					</tr>
				</thead>
				<thead>
					<tr>
						<td colspan="2"></td>
					</tr>
				</thead>
				<tr class="entete">
					<td>Début</td>
					<td>User</td>
				</tr>
			';
		while ( $res=$my->arr($req2) )
		{
			$util=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_user'].' ');
			$connect=$my->req_arr('SELECT * FROM ttre_connection_admin WHERE id_user='.$res['id_user'].' ORDER BY id DESC  ');
			echo'
				<tr style="text-align:center;">
					<td>'.date('d/m/Y H:i',$connect['debut']).'</td>
					<td>'.$util['nom'].'</td>
				</tr>
				';
		}
		echo'</table>';
		
		echo'<br /><br />
				
			<table id="liste_produits">
				<thead>
					<tr class="entete">
						<td colspan="2">Admin Ajout</td>
					</tr>
				</thead>
				<thead>
					<tr>
						<td colspan="2"></td>
					</tr>
				</thead>
				<tr class="entete">
					<td>Début</td>
					<td>User</td>
				</tr>
			';
		while ( $res=$my->arr($req3) )
		{
			$util=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$res['id_user'].' ');
			$connect=$my->req_arr('SELECT * FROM ttre_connection_admin WHERE id_user='.$res['id_user'].' ORDER BY id DESC  ');
			echo'
				<tr style="text-align:center;">
					<td>'.date('d/m/Y H:i',$connect['debut']).'</td>
					<td>'.$util['nom'].'</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo'<p>Pas d\'utilisateur en cours de connexion .</p>';
	}
}
?>
