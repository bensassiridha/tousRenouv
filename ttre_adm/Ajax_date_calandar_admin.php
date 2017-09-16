<?php 
session_start();
header("Content-Type:text/plain; charset=iso-8859-1");
require_once 'mysql.php';
$my = new mysql();


if ( $_SESSION['user_calandar']!=0 )
{
	$req1 = $my->req('SELECT AD.id as idad
						FROM
							ttre_achat_devis AD ,
							ttre_achat_devis_suite ADSS
						WHERE
							AD.statut_valid_admin=-1
							AND	AD.id=ADSS.id_devis
							AND	ADSS.stat_ajout_zone=0
							AND AD.stat_suppr=0
							AND ADSS.stat_devis_attente=1
						');
	$req2 = $my->req('SELECT AD.id as idad
						FROM
							ttre_achat_devis AD ,
							ttre_achat_devis_suite ADSS
						WHERE
							AD.statut_valid_admin=-1
							AND	AD.id=ADSS.id_devis
							AND	ADSS.stat_ajout_zone=0
							AND AD.stat_suppr=0
							AND ADSS.stat_devis_attente=2 
						');
	
	//list($jour, $mois, $annee) = explode('/', date('d/m/Y',time()));
	//$date_rech = mktime(0,0,0,$mois,$jour,$annee);
	$date_rech = $_POST['date'];
	$_SESSION['tab_timestamp_rech_1']=array();
	while ( $ress=$my->arr($req1) )
	{
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
	
		$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
		$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
		$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
		$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['user_calandar'].' AND zone='.$rs3['departement_id'].' ');
		if ( $my->num($rq1)>0 )
		{
			list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
			list($d1,$d11) = split('[$]',$d);
			list($jour, $mois, $annee) = explode('/', $d1);
			$timestamp = mktime(0,0,0,$mois,$jour,$annee);
			if ( $timestamp==$date_rech )// cas n'existe
			{
				$_SESSION['tab_timestamp_rech_1'][]=$res['id'];
			}
		}
	}
	
	$test=1;
	foreach ( $_SESSION['tab_timestamp_rech_1'] as $value )
	{
		if ( $test==1 )
		{
			echo'
						<table id="liste_produits">
							<thead>
								<tr class="entete">
									<td colspan="6">Rdv pris le '.date('d/m/Y',$date_rech).'</td>
								</tr>
							</thead>
							<thead>
								<tr>
									<td colspan="6"></td>
								</tr>
							</thead>
							<thead>
								<tr class="entete">
									<td>Date / Ref</td>
									<td>Heure</td>
									<td>Client</td>
									<td>User</td>
									<td>Ville / Département</td>
									<td class="bouton">Modifier</td>
								</tr>
							</thead>
							<tbody>
					';
			$test=0;
		}
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$value.' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
	
		$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
		$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
		$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
		$vd=$rs2['ville_nom_reel'].' / '.$rs3['departement_nom'];
		$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
		$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
	
		$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
		list($p,$d) = split('[|]',$respb['stat_devis_attente']);
		list($d1,$d11) = split('[$]',$d);
	
	
		echo'
			<tr>
				<td>'.date('d/m/Y',$res['date_ajout']).' <br /><strong>'.$res['reference'].'</strong></td>
				<td>'.$d11.'</td>
				<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
				<td>'.$u['nom'].'</td>
				<td>'.$vd.'</td>
				<td class="bouton">
					<a href="?contenu=devis_admin_administrateur&stat='.$p.'&action=modifier&id='.$value.'" target="_blanc">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
			</tr>
			';
	}
	if ( $test==0 )
	{
		echo'
				</tbody>
				</table><br /><br />
			';
	}
	
	$_SESSION['tab_timestamp_rech_2']=array();
	while ( $ress=$my->arr($req2) )
	{
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
	
		$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
		$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
		$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
		$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$_SESSION['user_calandar'].' AND zone='.$rs3['departement_id'].' ');
		if ( $my->num($rq1)>0 )
		{
			list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
			list($d1,$d11) = split('[$]',$d);
			list($jour, $mois, $annee) = explode('/', $d1);
			$timestamp = mktime(0,0,0,$mois,$jour,$annee);
			if ( $timestamp==$date_rech )// cas n'existe
			{
				$_SESSION['tab_timestamp_rech_2'][]=$res['id'];
			}
		}
	}
	
	$test=1;
	foreach ( $_SESSION['tab_timestamp_rech_2'] as $value )
	{
		if ( $test==1 )
		{
			echo'
						<table id="liste_produits">
							<thead>
								<tr class="entete">
									<td colspan="6">A rappeler, verifiez à la date '.date('d/m/Y',$date_rech).'</td>
								</tr>
							</thead>
							<thead>
								<tr>
									<td colspan="6"></td>
								</tr>
							</thead>
							<thead>
								<tr class="entete">
									<td>Date / Ref</td>
									<td>Heure</td>
									<td>Client</td>
									<td>User</td>
									<td>Ville / Département</td>
									<td class="bouton">Modifier</td>
								</tr>
							</thead>
							<tbody>
					';
			$test=0;
		}
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$value.' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
	
		$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
		$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
		$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
		$vd=$rs2['ville_nom_reel'].' / '.$rs3['departement_nom'];
		$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
		$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
	
		$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
		list($p,$d) = split('[|]',$respb['stat_devis_attente']);
		list($d1,$d11) = split('[$]',$d);
	
	
		echo'
			<tr>
				<td>'.date('d/m/Y',$res['date_ajout']).' <br /><strong>'.$res['reference'].'</strong></td>
				<td>'.$d11.'</td>
				<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
				<td>'.$u['nom'].'</td>
				<td>'.$vd.'</td>
				<td class="bouton">
					<a href="?contenu=devis_admin_administrateur&stat='.$p.'&action=modifier&id='.$value.'" target="_blanc">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
			</tr>
			';
	}
	if ( $test==0 )
	{
		echo'
				</tbody>
				</table>
			';
	}
}
else
{
	$req1 = $my->req('SELECT AD.id as idad
						FROM
							ttre_achat_devis AD ,
							ttre_achat_devis_suite ADSS
						WHERE
							AD.statut_valid_admin=-1
							AND	AD.id=ADSS.id_devis
							AND	ADSS.stat_ajout_zone=0
							AND AD.stat_suppr=0
							AND ADSS.stat_devis_attente=1
						');
	$req2 = $my->req('SELECT AD.id as idad
						FROM
							ttre_achat_devis AD ,
							ttre_achat_devis_suite ADSS
						WHERE
							AD.statut_valid_admin=-1
							AND	AD.id=ADSS.id_devis
							AND	ADSS.stat_ajout_zone=0
							AND AD.stat_suppr=0
							AND ADSS.stat_devis_attente=2 
						');
	
	//list($jour, $mois, $annee) = explode('/', date('d/m/Y',time()));
	//$date_rech = mktime(0,0,0,$mois,$jour,$annee);
	$date_rech = $_POST['date'];
	$_SESSION['tab_timestamp_rech_1']=array();
	while ( $ress=$my->arr($req1) )
	{
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
		list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
		list($d1,$d11) = split('[$]',$d);
		list($jour, $mois, $annee) = explode('/', $d1);
		$timestamp = mktime(0,0,0,$mois,$jour,$annee);
		if ( $timestamp==$date_rech )// cas n'existe
		{
			$_SESSION['tab_timestamp_rech_1'][]=$res['id'];
		}
	}
	
	$test=1;
	foreach ( $_SESSION['tab_timestamp_rech_1'] as $value )
	{
		if ( $test==1 )
		{
			echo'
						<table id="liste_produits">
							<thead>
								<tr class="entete">
									<td colspan="7">Rdv pris le '.date('d/m/Y',$date_rech).'</td>
								</tr>
							</thead>
							<thead>
								<tr>
									<td colspan="7"></td>
								</tr>
							</thead>
							<thead>
								<tr class="entete">
									<td>Date / Ref</td>
									<td>Heure</td>
									<td>Client</td>
									<td>User Ajout</td>
									<td>User Zone</td>
									<td>Ville / Département</td>
									<td class="bouton">Modifier</td>
								</tr>
							</thead>
							<tbody>
					';
			$test=0;
		}
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$value.' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
	
		$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
		$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
		$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
		$vd=$rs2['ville_nom_reel'].' / '.$rs3['departement_nom'];
		$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
		$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
	
		$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
		list($p,$d) = split('[|]',$respb['stat_devis_attente']);
		list($d1,$d11) = split('[$]',$d);
	
		$az=$my->req_arr('SELECT * FROM ttre_users_zones UZ , ttre_users U WHERE U.id_user=UZ.id_user AND UZ.zone='.$rs3['departement_id'].' ');
		echo'
			<tr>
				<td>'.date('d/m/Y',$res['date_ajout']).' <br /><strong>'.$res['reference'].'</strong></td>
				<td>'.$d11.'</td>
				<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
				<td>'.$u['nom'].'</td>
				<td>'.$az['nom'].'</td>
				<td>'.$vd.'</td>
				<td class="bouton">
					<a href="?contenu=devis_admin_administrateur&stat='.$p.'&action=modifier&id='.$value.'" target="_blanc">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
			</tr>
			';
	}
	if ( $test==0 )
	{
		echo'
				</tbody>
				</table><br /><br />
			';
	}
	
	$_SESSION['tab_timestamp_rech_2']=array();
	while ( $ress=$my->arr($req2) )
	{
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
		list($p,$d) = split('[|]',$res_suite['stat_devis_attente']);
		list($d1,$d11) = split('[$]',$d);
		list($jour, $mois, $annee) = explode('/', $d1);
		$timestamp = mktime(0,0,0,$mois,$jour,$annee);
		if ( $timestamp==$date_rech )// cas n'existe
		{
			$_SESSION['tab_timestamp_rech_2'][]=$res['id'];
		}
	}
	
	$test=1;
	foreach ( $_SESSION['tab_timestamp_rech_2'] as $value )
	{
		if ( $test==1 )
		{
			echo'
						<table id="liste_produits">
							<thead>
								<tr class="entete">
									<td colspan="7">A rappeler, verifiez à la date '.date('d/m/Y',$date_rech).'</td>
								</tr>
							</thead>
							<thead>
								<tr>
									<td colspan="7"></td>
								</tr>
							</thead>
							<thead>
								<tr class="entete">
									<td>Date / Ref</td>
									<td>Heure</td>
									<td>Client</td>
									<td>User Ajout</td>
									<td>User Zone</td>
									<td>Ville / Département</td>
									<td class="bouton">Modifier</td>
								</tr>
							</thead>
							<tbody>
					';
			$test=0;
		}
		$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$value.' ');
		$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
	
		$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
		$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
		$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
		$vd=$rs2['ville_nom_reel'].' / '.$rs3['departement_nom'];
		$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
		$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
	
		$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$value.' ');
		list($p,$d) = split('[|]',$respb['stat_devis_attente']);
		list($d1,$d11) = split('[$]',$d);
	
		$az=$my->req_arr('SELECT * FROM ttre_users_zones UZ , ttre_users U WHERE U.id_user=UZ.id_user AND UZ.zone='.$rs3['departement_id'].' ');
		echo'
			<tr>
				<td>'.date('d/m/Y',$res['date_ajout']).' <br /><strong>'.$res['reference'].'</strong></td>
				<td>'.$d11.'</td>
				<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
				<td>'.$u['nom'].'</td>
				<td>'.$az['nom'].'</td>
				<td>'.$vd.'</td>
				<td class="bouton">
					<a href="?contenu=devis_admin_administrateur&stat='.$p.'&action=modifier&id='.$value.'" target="_blanc">
					<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
				</td>
			</tr>
			';
	}
	if ( $test==0 )
	{
		echo'
				</tbody>
				</table>
			';
	}
}
?>