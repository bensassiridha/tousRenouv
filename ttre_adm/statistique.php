<?php 
$my = new mysql();
echo '<h1>Statistique</h1>';	


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

$form = new formulaire('modele_1','?contenu=statistique','','','','sub','txt','','txt_obl','lab_obl');
$form->vide('<tr><td></td><td>Date sous la forme 21/11/2015</td></tr>');
$form->text('Date de début','dated','','',$dated);
$form->text('Date de fin','datef','','',$datef);
$form->afficher1('Rechercher');

$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$_SESSION['id_user'].' ');
if ( $user['profil']==1 ) $where1='';
elseif ( $user['profil']==2 || $user['profil']==3 ) $where1=' AND id_user='.$_SESSION['id_user'].' ';
		
$where2='';
if ( $dated!='' || $datef!='' ) $where2=' AND date_ajout>='.$dd.' AND date_ajout<='.$df.' ';


if ( $user['profil']==1 )
{
		echo'<br /><br /><p>Global</p>
			<table id="liste_produits">
			<tr class="entete">
				<td>Nombre de devis</td>
				<td>Statistique</td>
			</tr>
			';
			$c1=$my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-1 AND stat_suppr=0 '.$where2.' ');
			$c2=$my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-2 AND stat_suppr=0 '.$where2.' ');
			$c3=$my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-3 AND stat_suppr=0 '.$where2.' ');
			
			$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t0=0;
			while ( $cc1=$my->arr($c1) )
			{
				$t=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$cc1['id'].' ');
				list($p,$d) = split('[|]',$t['stat_devis_attente']);
				if ( $p==1 ) $t1++;
				elseif ( $p==2 ) $t2++;
				elseif ( $p==3 ) $t3++;
				elseif ( $p==4 ) $t4++;
				elseif ( $p==5 ) $t5++;
				elseif ( $p==6 ) $t6++;
				elseif ( $p==7 ) $t7++;
				elseif ( $p==8 ) $t8++;
				elseif ( $p==0 ) $t0++;
			}
			echo'
				<tr style="text-align:center;">
					<td style="width:40%"><p style="text-align:left;" >
						<strong>'.$my->num($c1).'</strong> devis en attente de traitement <br />
						<strong>'.$my->num($c2).'</strong> devis à atribuer <br />
						<strong>'.$my->num($c3).'</strong> devis signé 
					</td></p>
					<td style="width:30%"><p style="text-align:left;" >
						<strong>'.$t1.'</strong> RDV pris <span style="color:red"><strong>'.ceil($t1*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t2.'</strong> Ne répond pas <span style="color:red"><strong>'.ceil($t2*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t3.'</strong> Travaux fini <span style="color:red"><strong>'.ceil($t3*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t4.'</strong> Faux numéro <span style="color:red"><strong>'.intval($t4*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t5.'</strong> Déjà trouvé un artisan <span style="color:red"><strong>'.intval($t5*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t6.'</strong> Autres <span style="color:red"><strong>'.intval($t6*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t7.'</strong> Pas de travaux <span style="color:red"><strong>'.intval($t7*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t8.'</strong> Projet abandonné <span style="color:red"><strong>'.intval($t8*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t0.'</strong> Pa vue <span style="color:red"><strong>'.intval($t0*100/$my->num($c1)).'% </strong></span>
					</td></p>
				</tr>
				';
		echo'</table>';
}


if ( $user['profil']==1 )
{
	$req=$my->req('SELECT * FROM ttre_users WHERE profil=1 AND id_user>1 '.$where1.' ');
	if ( $my->num($req)>0 )
	{
		echo'<br /><br /><p>Profil : Administrateur</p>
			<table id="liste_produits">
			<tr class="entete">
				<td>Nom</td>
				<td>Nombre de devis</td>
				<td>Statistique</td>
			</tr>
			';
		while ( $res=$my->arr($req) )
		{
			$c1=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-1 AND stat_suppr=0 '.$where2.' ');
			$c2=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-2 AND stat_suppr=0 '.$where2.' ');
			$c3=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-3 AND stat_suppr=0 '.$where2.' ');
			
			$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t0=0;
			while ( $cc1=$my->arr($c1) )
			{
				$t=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$cc1['id'].' ');
				list($p,$d) = split('[|]',$t['stat_devis_attente']);
				if ( $p==1 ) $t1++;
				elseif ( $p==2 ) $t2++;
				elseif ( $p==3 ) $t3++;
				elseif ( $p==4 ) $t4++;
				elseif ( $p==5 ) $t5++;
				elseif ( $p==6 ) $t6++;
				elseif ( $p==7 ) $t7++;
				elseif ( $p==8 ) $t8++;
				elseif ( $p==0 ) $t0++;
			}
			echo'
				<tr style="text-align:center;">
					<td style="width:30%">'.$res['nom'].'</td>
					<td style="width:40%"><p style="text-align:left;" >
						<strong>'.$my->num($c1).'</strong> devis en attente de traitement <br />
						<strong>'.$my->num($c2).'</strong> devis à atribuer <br />
						<strong>'.$my->num($c3).'</strong> devis signé 
					</td></p>
					<td style="width:30%"><p style="text-align:left;" >
						<strong>'.$t1.'</strong> RDV pris <span style="color:red"><strong>'.ceil($t1*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t2.'</strong> Ne répond pas <span style="color:red"><strong>'.ceil($t2*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t3.'</strong> Travaux fini <span style="color:red"><strong>'.ceil($t3*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t4.'</strong> Faux numéro <span style="color:red"><strong>'.intval($t4*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t5.'</strong> Déjà trouvé un artisan <span style="color:red"><strong>'.intval($t5*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t6.'</strong> Autres <span style="color:red"><strong>'.intval($t6*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t7.'</strong> Pas de travaux <span style="color:red"><strong>'.intval($t7*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t8.'</strong> Projet abandonné <span style="color:red"><strong>'.intval($t8*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t0.'</strong> Pa vue <span style="color:red"><strong>'.intval($t0*100/$my->num($c1)).'% </strong></span>
					</td></p>
				</tr>
				';
		}
		echo'</table>';
	}
}




if ( $user['profil']==1 || $user['profil']==2 )
{
	$req=$my->req('SELECT * FROM ttre_users WHERE profil=2 AND id_user>1 '.$where1.' ');
	if ( $my->num($req)>0 )
	{
		echo'<br /><br /><p>Profil : Admin par zone</p>
			<table id="liste_produits">
			<tr class="entete">
				<td>Nom</td>
				<td>Nombre de devis</td>
				<td>Statistique</td>
			</tr>
			';
		while ( $res=$my->arr($req) )
		{
			
			$c1 = $my->req('SELECT AD.id
							FROM
								ttre_achat_devis AD ,
								ttre_client_part_adresses A ,
								ttre_villes_france V ,
								ttre_departement_france D ,
								ttre_users_zones Z 
							WHERE
								AD.id_adresse=A.id
								AND A.ville=V.ville_id
								AND V.ville_departement=D.departement_code
			 					AND D.departement_id=Z.zone
								AND Z.id_user='.$res['id_user'].'
								AND AD.statut_valid_admin=-1
								AND AD.stat_suppr=0
							');
			
			$c2 = $my->req('SELECT *
							FROM
								ttre_achat_devis AD ,
								ttre_client_part_adresses A ,
								ttre_villes_france V ,
								ttre_departement_france D ,
								ttre_users_zones Z 
							WHERE
								AD.id_adresse=A.id
								AND A.ville=V.ville_id
								AND V.ville_departement=D.departement_code
			 					AND D.departement_id=Z.zone
								AND Z.id_user='.$res['id_user'].'
								AND AD.statut_valid_admin=-2
								AND AD.stat_suppr=0
							');
			
			$c3 = $my->req('SELECT *
							FROM
								ttre_achat_devis AD ,
								ttre_client_part_adresses A ,
								ttre_villes_france V ,
								ttre_departement_france D ,
								ttre_users_zones Z 
							WHERE
								AD.id_adresse=A.id
								AND A.ville=V.ville_id
								AND V.ville_departement=D.departement_code
			 					AND D.departement_id=Z.zone
								AND Z.id_user='.$res['id_user'].'
								AND AD.statut_valid_admin=-3
								AND AD.stat_suppr=0
							');
			
			
			//$c1=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-1 '.$where2.' ');
			//$c2=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-2 '.$where2.' ');
			//$c3=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-3 '.$where2.' ');
			
			$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t0=0;
			while ( $cc1=$my->arr($c1) )
			{
				$t=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$cc1['id'].' ');
				list($p,$d) = split('[|]',$t['stat_devis_attente']);
				if ( $p==1 ) $t1++;
				elseif ( $p==2 ) $t2++;
				elseif ( $p==3 ) $t3++;
				elseif ( $p==4 ) $t4++;
				elseif ( $p==5 ) $t5++;
				elseif ( $p==6 ) $t6++;
				elseif ( $p==7 ) $t7++;
				elseif ( $p==8 ) $t8++;
				elseif ( $p==0 ) $t0++;
			}
			$liste_zone='';
			$z = $my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$res['id_user'].' ');
			while ( $zz=$my->arr($z) )
			{
				$temp=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$zz['zone'].' ');
				$liste_zone.=$temp['departement_nom'].', ';
			}
			echo'
				<tr style="text-align:center;">
					<td style="width:30%"><strong>'.$res['nom'].'</strong> <br />Zone : '.$liste_zone.'</td>
					<td style="width:40%"><p style="text-align:left;" >
						<strong>'.$my->num($c1).'</strong> devis en attente de traitement <br />
						<strong>'.$my->num($c2).'</strong> devis à atribuer <br />
						<strong>'.$my->num($c3).'</strong> devis signé 
					</td></p>
					<td style="width:30%"><p style="text-align:left;" >
						<strong>'.$t1.'</strong> RDV pris <span style="color:red"><strong>'.ceil($t1*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t2.'</strong> Ne répond pas <span style="color:red"><strong>'.ceil($t2*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t3.'</strong> Travaux fini <span style="color:red"><strong>'.ceil($t3*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t4.'</strong> Faux numéro <span style="color:red"><strong>'.intval($t4*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t5.'</strong> Déjà trouvé un artisan <span style="color:red"><strong>'.intval($t5*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t6.'</strong> Autres <span style="color:red"><strong>'.intval($t6*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t7.'</strong> Pas de travaux <span style="color:red"><strong>'.intval($t7*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t8.'</strong> Projet abandonné <span style="color:red"><strong>'.intval($t8*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t0.'</strong> Pa vue <span style="color:red"><strong>'.intval($t0*100/$my->num($c1)).'% </strong></span>
					</td></p>
				</tr>
				';
		}
		echo'</table>';
	}
}



if ( $user['profil']==1 || $user['profil']==3 )
{
	$req=$my->req('SELECT * FROM ttre_users WHERE profil=3 AND id_user>1 '.$where1.' ');
	if ( $my->num($req)>0 )
	{
		echo'<br /><br /><p>Profil : Ajouter un devis</p>
			<table id="liste_produits">
			<tr class="entete">
				<td>Nom</td>
				<td>Nombre de devis</td>
				<td>Statistique</td>
			</tr>
			';
		while ( $res=$my->arr($req) )
		{
			$c1=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-1 AND stat_suppr=0 '.$where2.' ');
			$c2=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-2 AND stat_suppr=0 '.$where2.' ');
			$c3=$my->req('SELECT * FROM ttre_achat_devis WHERE nbr_estimation='.$res['id_user'].' AND statut_valid_admin=-3 AND stat_suppr=0 '.$where2.' ');
			
			$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t0=0;
			while ( $cc1=$my->arr($c1) )
			{
				$t=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$cc1['id'].' ');
				list($p,$d) = split('[|]',$t['stat_devis_attente']);
				if ( $p==1 ) $t1++;
				elseif ( $p==2 ) $t2++;
				elseif ( $p==3 ) $t3++;
				elseif ( $p==4 ) $t4++;
				elseif ( $p==5 ) $t5++;
				elseif ( $p==6 ) $t6++;
				elseif ( $p==7 ) $t7++;
				elseif ( $p==8 ) $t8++;
				elseif ( $p==0 ) $t0++;
			}
			echo'
				<tr style="text-align:center;">
					<td style="width:30%">'.$res['nom'].'</td>
					<td style="width:40%"><p style="text-align:left;" >
						<strong>'.$my->num($c1).'</strong> devis en attente de traitement <br />
						<strong>'.$my->num($c2).'</strong> devis à atribuer <br />
						<strong>'.$my->num($c3).'</strong> devis signé 
					</td></p>
					<td style="width:30%"><p style="text-align:left;" >
						<strong>'.$t1.'</strong> RDV pris <span style="color:red"><strong>'.ceil($t1*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t2.'</strong> Ne répond pas <span style="color:red"><strong>'.ceil($t2*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t3.'</strong> Travaux fini <span style="color:red"><strong>'.ceil($t3*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t4.'</strong> Faux numéro <span style="color:red"><strong>'.intval($t4*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t5.'</strong> Déjà trouvé un artisan <span style="color:red"><strong>'.intval($t5*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t6.'</strong> Autres <span style="color:red"><strong>'.intval($t6*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t7.'</strong> Pas de travaux <span style="color:red"><strong>'.intval($t7*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t8.'</strong> Projet abandonné <span style="color:red"><strong>'.intval($t8*100/$my->num($c1)).'% </strong></span><br />
						<strong>'.$t0.'</strong> Pa vue <span style="color:red"><strong>'.intval($t0*100/$my->num($c1)).'% </strong></span>
					</td></p>
				</tr>
				';
		}
		echo'</table>';
	}
}

?>
