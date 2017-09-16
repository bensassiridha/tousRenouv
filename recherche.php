<?php
session_start();
require('mysql.php');$my=new mysql();
$pageTitle = "Recherche"; 
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
									<h2><a href="recherche.php">Nos chantiers disponible</a></h2>
									<!-- <h1>Devis gratuit en ligne et sans aucun engagement</h1> -->
									<div class="formulaire">
									<h6>Formulaire</h6>
                                         <!-- liste des documents pdf -->
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
$(document).ready(function() {								

	/*$('input[name="cp"]').change(function ()
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
	});	*/
	$('select[name="dep"]').change(function ()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxVille2.php",
			 data: "dep="+$('select[name="dep"]').val(),
			 success: function(msg)
				{			 
					//alert(msg);
					$('select[name="ville"]').html(msg);
				}
		 });
	});	
	
});
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script> 	
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	$("a.example2").fancybox({
		'titleShow'		: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	$("a#various3").fancybox({
		'width'				: '100%',
		'height'			: '70%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
</script>								
<?php 
if ( isset($_GET['idDevisEnch']) )
{

	$infos_devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$_GET['idDevisEnch'].' ');
	$total=number_format($infos_devis['total_net']+$infos_devis['total_tva']+$infos_devis['frais_port'],2);
	$detail='
							<ul id="compte_details_com">
								<li>
									<h4>Informations g�n�rales</h4>
									<dl>
										<dt>Date Devis : </dt>
										<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
										<dt>R�f�rence : </dt>
										<dd>'.$infos_devis['reference'].'</dd>
									</dl>
								</li>
							';
	$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$infos_devis['id_adresse'].' ');
	$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
	$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
	$batiment = ucfirst(html_entity_decode($temp['batiment']));
	$code_postal = $temp['code_postal'];
	$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
	$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
	$pays = ucfirst(html_entity_decode($temp['pays']));
	$detail.='
							<li>
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>'.$code_postal.' '.$ville.'</dd>
									<dd>'.$pays.'</dd>
								</dl>
							</li>
						</ul>';
	$detail.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>Pi�ce</td>
									<td>D�signation</td>
									<td>P.U</td>
									<td>Qte</td>
									<td>Unit�</td>
									<td>Total</td>
								</tr>
							';
	$nom_cat='';
	$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
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
		if ( !empty($ress['commentaire']) )$texte='<br /><strong>Commentaire : </strong>'.$ress['commentaire']; else $texte='';
		$detail.='
								<tr>
									<td>'.$ress['nom_piece'].'</td>
									<td style="text-align:justify;">'.$ress['titre'].' '.$texte.'</td>
									<td>'.number_format($ress['prix'], 2,'.','').' �</td>
									<td>'.$ress['qte'].'</td>
									<td>'.$ress['unite'].'</td>
									<td>'.number_format(($ress['prix']*$ress['qte']), 2,'.','').' �</td>
								</tr>
							';
	}
	$reqqq=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
	while ( $resss=$my->arr($reqqq) )
	{
		$temp=$my->req_arr('SELECT SUM(valeur_tva_prod) AS prix_total FROM ttre_devis_details WHERE id_devis='.$infos_devis['id'].' AND tva='.$resss['id'].' ');
		if ( $temp['prix_total'] > 0 )
			$detail.='
									<tr class="total">
										<td colspan="5"><strong>'.$resss['titre'].' : </strong></td>
										<td colspan="1" class="prix_final">'.number_format($temp['prix_total'], 2,'.','').'�</td>
									</tr>
									';
	}
	$detail.='
							<tr class="total">
								<td colspan="5"><strong>Total TTC : </strong></td>
								<td colspan="1" class="prix_final">'.$total.' �</td>
							</tr>
						</table>	
				';
	if ( !isset($_SESSION['id_client_trn_pro']) )
	{
		$detail.='<p style="font-size:18px;"><br /><br /><a href="espace_professionnel.php">Connexion</a> | <a href="espace_professionnel.php?contenu=inscription">Inscription</a></p>';
	}
	else
	{
		$detail.='<p id="panier_boutons"><input type="button" value="Encherer" onclick="javascript:window.location=\'espace_professionnel.php?idDevisEnch='.$_GET['idDevisEnch'].'\'" /></p>';
	}
		
	echo'
						<div id="espace_compte">
							'.$detail.'
						</div>
						';	
}

// Nos chantiers
elseif ( isset($_GET['idDevisAImm']) )
{
	$detail='';
		
	$infos_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['idDevisAImm'].' ');
	$detail.='
							<ul id="compte_details_com">
								<li>
									<h4>Informations g�n�rales</h4>
									<dl>
										<dt>Date Devis : </dt>
										<dd>'.date("d-m-Y",$infos_devis['date_ajout']).'</dd>
										<dt>R�f�rence : </dt>
										<dd>'.$infos_devis['reference'].'</dd>
									</dl>
								</li>
							';
	$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$infos_devis['id_adresse'].' ');
	$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
	$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
	$batiment = ucfirst(html_entity_decode($temp['batiment']));
	$code_postal = $temp['code_postal'];
	$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
	$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
	$pays = ucfirst(html_entity_decode($temp['pays']));
	$detail.='
							<li>
								<h4>Adresse de chantier</h4>
								<dl>
									<dd>'.$code_postal.' '.$ville.'</dd>
									<dd>'.$pays.'</dd>
								</dl>
							</li>
						</ul>';
	$detail.='
							<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
								<tr class="entete">
									<td>D�signation</td>
								</tr>
							';

	//Travaux
	$nom_cat='';
	$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$infos_devis['id'].' ORDER BY ordre_categ ASC ');
	while ( $ress=$my->arr($reqq) )
	{
		if ( $nom_cat!=$ress['titre_categ'] )
		{
			$nom_cat=$ress['titre_categ'];
			$detail.='
									<tr style="background:#faca2e;">
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
	$detail.='</table>';

	// jointed File
	$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['idDevisAImm'].' ');
	if ( $my->num($req_f)>0 )
	{
		$detail.='<p><br /> Fichiers � t�l�charger : ';
		while ( $res_f=$my->arr($req_f) )
		{
			$detail.='<a target="_blanc" href="upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
		}
		$detail.='</p>';
	}

	//Price
	if ( $infos_devis['statut_valid_admin']==1 )
	{
		$detail.= '<p>Prix HT: '.number_format($infos_devis['prix_achat'],2).' �</p>';
		$detail.= '<p>TVA : 20 %</p>';
		$detail.= '<p>Prix TTC: '.number_format(($infos_devis['prix_achat']+$infos_devis['prix_achat']*20/100),2).' �</p>';
		if ( !isset($_SESSION['id_client_trn_pro_desactiver']) && !isset($_SESSION['id_client_trn_pro']) )
		{
			$detail.='<p style="text-align:center;font-size:18px;" ><br /><br /><a href="espace_pro.php">Connexion</a> | <a href="espace_pro.php?contenu=inscription">Inscription</a></p>';
		}
		else
		{
			//$detail.='<p id="panier_boutons"><input type="button" value="Payer" onclick="javascript:window.location=\'espace_professionnel.php?idDevisAImm='.$_GET['idDevisAImm'].'\'" /></p>';
			$detail.='<p id="panier_boutons"><input type="button" value="Ajouter au panier" onclick="javascript:window.location=\'panier.php?contenu=panier&action=ajouter&idDevisAImm='.$_GET['idDevisAImm'].'\'" /></p>';
		}
	}
	
		
	echo'
						<div id="espace_compte">
							'.$detail.'
						</div>
						';
}
elseif ( isset($_GET['formRech']) )
{
	$i=1;

	/*$req = $my->req('SELECT DISTINCT(DD.id_devis) 
			FROM ttre_devis D , ttre_devis_details DD , ttre_client_part_adresses CA
			WHERE D.id=DD.id_devis AND D.id_adresse=CA.id AND D.statut_valid_admin=1 '.$wherActi.' '.$wherAdres.' ');
	*/
	
	
	if ( isset($_GET['cat']) && !empty($_GET['cat']) ) $cat=$_GET['cat']; else $cat=0;
	if ( isset($_GET['dep']) && !empty($_GET['dep']) ) $dep=$_GET['dep']; else $dep=0;
	if ( isset($_GET['ville']) && !empty($_GET['ville']) ) $vil=$_GET['ville']; else $vil=0;
	
	
	
	
	
	/*if ( $dep==0 && $cat==0 )
	{
		$req = $my->req('SELECT * FROM ttre_devis WHERE statut_valid_admin=1 ORDER BY id DESC');
	}
	elseif ( $dep==0 && $cat!=0 )
	{
		$req = $my->req('SELECT * 
							FROM 
								ttre_devis D , 
								ttre_devis_details DD 
							WHERE 
								D.statut_valid_admin=1 
								AND D.id=DD.id_devis 
								AND DD.id_categ='.$cat.'  
							ORDER BY D.id DESC');
	}
	elseif ( $dep!=0 && $vil==0 && $cat==0 )
	{
		$req = $my->req('SELECT D.id as id_devis 
							FROM 
								ttre_devis D , 
								ttre_client_part_adresses A ,
								ttre_villes_france V  
							WHERE 
								D.statut_valid_admin=1 
								AND V.ville_departement='.$dep.'
								AND V.ville_id=A.ville  
								AND A.id=D.id_adresse
							ORDER BY D.id DESC');
	
	}
	elseif ( $dep!=0 && $vil!=0 && $cat==0 )
	{
		$req = $my->req('SELECT D.id as id_devis 
							FROM 
								ttre_devis D , 
								ttre_client_part_adresses A ,
							WHERE 
								D.statut_valid_admin=1 
								AND A.ville='.$vil.'
								AND A.id=D.id_adresse
							ORDER BY D.id DESC');
	
	}
	elseif ( $dep!=0 && $vil==0 && $cat!=0 )
	{
		$req = $my->req('SELECT * 
							FROM 
								ttre_devis D , 
								ttre_devis_details DD ,
								ttre_client_part_adresses A ,
								ttre_villes_france V  
							WHERE 
								D.statut_valid_admin=1 
								AND DD.id_categ='.$cat.'
								AND D.id=DD.id_devis 
								AND V.ville_departement='.$dep.'
								AND V.ville_id=A.ville  
								AND A.id=D.id_adresse
							ORDER BY D.id DESC');
	}
	elseif ( $dep!=0 && $vil!=0 && $cat!=0 )
	{
		$req = $my->req('SELECT * 
							FROM 
								ttre_devis D , 
								ttre_devis_details DD ,
								ttre_client_part_adresses A ,
							WHERE 
								D.statut_valid_admin=1 
								AND DD.id_categ='.$cat.'
								AND D.id=DD.id_devis 
								AND A.ville='.$vil.'
								AND A.id=D.id_adresse
							ORDER BY D.id DESC');
	}
	
	if ( $my->num($req)>0 )
	{
		while ( $res=$my->arr($req) )
		{
			$activite='';
			$reqq=$my->req('SELECT * FROM ttre_devis_details WHERE id_devis='.$res['id_devis'].' ');
			while ( $ress=$my->arr($reqq) ) $activite.=$ress['titre_categ'].', ';
			$tempp=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$res['id_devis'].' ');
			$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$tempp['id_adresse'].' ');
			$code_postal = $temp['code_postal'];
			$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
			$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
			$pays = ucfirst(html_entity_decode($temp['pays']));
			$zone_intervention=' '.$code_postal.' '.$ville.' - '.$pays.' ';
			echo'
				<div class="con" style="height:150px;padding: 10px 10px 10px 10px;margin:0 0 10px;">
					<div class="container">
						<div class="row">
							<h1>Devis n�'.$i.' :</h1>
							<p><strong>Activit� : </strong> '.$activite.'<br />
							<strong>Zone d\'intervention : </strong> '.$zone_intervention.'<br />
							<a href="recherche.php?idDevisEnch='.$res['id_devis'].'">+ D�tail</a>
						</div>
					</div>
				</div>
				';
			$i++;
		}
	}*/
	
	/*$req = $my->req('SELECT DISTINCT(DD.id_devis) 
			FROM ttre_achat_devis D , ttre_achat_devis_details DD , ttre_client_part_adresses CA
			WHERE D.id=DD.id_devis AND D.id_adresse=CA.id AND D.statut_valid_admin=1 '.$wherActi.' '.$wherAdres.' ');
	
	*/
	
	if ( $dep==0 && $cat==0 )
	{
		//$req = $my->req('SELECT id as id_devis FROM ttre_achat_devis WHERE stat_suppr=0 AND ( statut_valid_admin=1 || statut_valid_admin=-2 ) ORDER BY id DESC');
		$req = $my->req('SELECT id as id_devis FROM ttre_achat_devis WHERE stat_suppr=0 AND statut_valid_admin=1 ORDER BY id DESC');
	}
	elseif ( $dep==0 && $cat!=0 )
	{
		$req = $my->req('SELECT * 
							FROM 
								ttre_achat_devis D , 
								ttre_achat_devis_details DD 
							WHERE 
							    D.statut_valid_admin=1)
								AND D.id=DD.id_devis 
								AND D.stat_suppr=0 
								AND DD.id_categ='.$cat.'  
							ORDER BY D.id DESC');
	}
	elseif ( $dep!=0 && $vil==0 && $cat==0 )
	{
		$req = $my->req('SELECT D.id as id_devis 
							FROM 
								ttre_achat_devis D , 
								ttre_client_part_adresses A ,
								ttre_villes_france V  
							WHERE 
								D.statut_valid_admin=1
								AND V.ville_departement='.$dep.'
								AND V.ville_id=A.ville  
								AND A.id=D.id_adresse
								AND D.stat_suppr=0
							ORDER BY D.id DESC');
	
	}
	elseif ( $dep!=0 && $vil!=0 && $cat==0 )
	{
		$req = $my->req('SELECT D.id as id_devis 
							FROM 
								ttre_achat_devis D , 
								ttre_client_part_adresses A ,
							WHERE 
								D.statut_valid_admin=1 
								AND A.ville='.$vil.'
								AND A.id=D.id_adresse
								AND D.stat_suppr=0
							ORDER BY D.id DESC');
	
	}
	elseif ( $dep!=0 && $vil==0 && $cat!=0 )
	{
		$req = $my->req('SELECT * 
							FROM 
								ttre_achat_devis D , 
								ttre_achat_devis_details DD ,
								ttre_client_part_adresses A ,
								ttre_villes_france V  
							WHERE 
								D.statut_valid_admin=1 
								AND DD.id_categ='.$cat.'
								AND D.id=DD.id_devis 
								AND V.ville_departement='.$dep.'
								AND V.ville_id=A.ville  
								AND A.id=D.id_adresse
								AND D.stat_suppr=0
							ORDER BY D.id DESC');
	}
	elseif ( $dep!=0 && $vil!=0 && $cat!=0 )
	{
		$req = $my->req('SELECT * 
							FROM 
								ttre_achat_devis D , 
								ttre_achat_devis_details DD ,
								ttre_client_part_adresses A ,
							WHERE 
								D.statut_valid_admin=1
								AND DD.id_categ='.$cat.'
								AND D.id=DD.id_devis 
								AND A.ville='.$vil.'
								AND A.id=D.id_adresse
								AND D.stat_suppr=0
							ORDER BY D.id DESC');
	}
	if ( $my->num($req)>0 )
	{
		while ( $res=$my->arr($req) )
		{
			$bb=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
			$a=$my->req('SELECT * FROM ttre_client_pro_commandes_contenu CC , ttre_client_pro_commandes C  
					WHERE C.id=CC.id_cmd AND CC.id_devis='.$res['id_devis'].' AND C.statut=1 ');
			
			if ( $bb['nbr_estimation']>$my->num($a) )
			{
				$activite='';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id_devis'].' ');
				while ( $ress=$my->arr($reqq) ) $activite.=$ress['titre_categ'].', ';
				$tempp=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$tempp['id_adresse'].' ');
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				$zone_intervention=' '.$code_postal.' '.$ville.' - '.$pays.' ';
				echo'
					<div class="con" style="height:150px;padding: 10px 10px 10px 10px;margin:0 0 10px;">
						<div class="container">
							<div class="row">
								<h1>Chantier n�'.$i.' :</h1>
								<p><strong>Date : </strong> '.date('d/m/Y',$bb['date_ajout']).'<br />
								<strong>Activit� : </strong> '.$activite.'<br />
								<strong>Zone d\'intervention : </strong> '.$zone_intervention.'<br />
								<a href="recherche.php?idDevisAImm='.$res['id_devis'].'">+ D�tail</a>
							</div>
						</div>
					</div>
					';
				$i++;
			}
		}
	}
}
else
{
	//$check_activite='';
	$select_activite='';
	$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
	if ( $my->num($reqCat)>0 )
	{
		$i=0;
		$select_activite.='<select name="cat" id="ip_act"><option value="0"></option> ';
		while ( $resCat=$my->arr($reqCat) )
		{
			//$check_activite.='<input id="ip_act" type="checkbox" name="categorie[]" value="'.$resCat['id'].'" /> '.$resCat['titre'].'<br /> ';
			$select_activite.='<option value="'.$resCat['id'].'"> '.$resCat['titre'].'</option> ';
		}
		$select_activite.='</select>';
	}
	
	$select_dep='';
	$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC');
	if ( $my->num($reqCat)>0 )
	{
		$i=0;
		$select_dep.='<select name="dep" id="ip_dep"><option value="0"></option> ';
		while ( $resCat=$my->arr($reqCat) )
		{
			//$check_activite.='<input id="ip_act" type="checkbox" name="categorie[]" value="'.$resCat['id'].'" /> '.$resCat['titre'].'<br /> ';
			$select_dep.='<option value="'.$resCat['departement_code'].'"> '.$resCat['departement_nom'].'</option> ';
		}
		$select_dep.='</select>';
	}
	
	
	/*
	 $zone_intervention='';
	$reqCat=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_code ASC');
	if ( $my->num($reqCat)>0 )
	{
	$i=1;$zone_intervention.='<table>';
	while ( $resCat=$my->arr($reqCat) )
	{
	if ( $i%3==1 ) $zone_intervention.='<tr>';
	$zone_intervention.='<td><input id="ip_zone" type="checkbox" name="departement[]" value="'.$resCat['departement_id'].'" /> '.$resCat['departement_nom'].'</td>';
	if ( $i%3==0 ) $zone_intervention.='</tr>';
	$i++;
	}
	$zone_intervention.='</table>';
	}
	<p>
	<label for="ip_zone" >Zone d\'intervention : </label><br />
	'.$zone_intervention.'<br />
	</p>
	*/

	echo'
		<form method="get" >
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="form-groupe-pro ">
							<div class="title-info"><h1>Nos chantiers disponible</h1></div>
							<p>
								<label for="ip_act" >Activit� : </label><br />
								'.$select_activite.'
							</p>
							<p>
								<label for="ip_dep">D�partement : </label><br />
								'.$select_dep.'
							</p>
							<p>
								<label for="ip_ville">Ville : </label><br />
								<select name="ville" id="ip_ville"><option value="0"></option>
							</p>

							<p class="align_center padding_tb_20">
								<input value="Rechercher" class="sub" type="submit" name="formRech"/>
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
		';


	///////////////////////////////////// **** Liste des chantiers  ***************/////////////////////////////////////
	$i=1;
	$req = $my->req('SELECT id as id_devis FROM ttre_achat_devis WHERE stat_suppr=0 AND statut_valid_admin=1 ORDER BY id DESC');

	$res=$my->arr($req);



	if ( $my->num($req)>0 )
	{


		while ( $res=$my->arr($req) )
		{
			$bb=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
			$a=$my->req('SELECT * FROM ttre_client_pro_commandes_contenu CC , ttre_client_pro_commandes C
					WHERE C.id=CC.id_cmd AND CC.id_devis='.$res['id_devis'].' AND C.statut=1 ');
				
			if ( $bb['nbr_estimation']>$my->num($a) )
			{
				$activite='';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id_devis'].' ');
				while ( $ress=$my->arr($reqq) ) $activite.=$ress['titre_categ'].', ';
				$tempp=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$res['id_devis'].' ');
				$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$tempp['id_adresse'].' ');
				$code_postal = $temp['code_postal'];
				$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
				$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
				$pays = ucfirst(html_entity_decode($temp['pays']));
				$zone_intervention=' '.$code_postal.' '.$ville.' - '.$pays.' ';

				echo'
					<div class="con" style="height:150px;padding: 10px 10px 10px 10px;margin:0 0 10px;">
						<div class="container">
							<div class="row">
								<h1>Chantier n�'.$i.' :</h1>
								<p><strong>Date : </strong> '.date('d/m/Y',$bb['date_ajout']).'<br />
								<strong>Activit� : </strong> '.$activite.'<br />
								<strong>Zone d\'intervention : </strong> '.$zone_intervention.'<br />
								<a href="recherche.php?idDevisAImm='.$res['id_devis'].'">+ D�tail</a>
							</div>
						</div>
					</div>
					';
				$i++;
			}
		}
	}
}
						/*	<p>
								<label for="ip_ville">Ville : <span class="obli">*</span></label><br />
								<select id="ip_ville" name="ville"><option value="0"></option></select>
							</p>*/
?>									 
								<!-- 
								<div class="con" style="height:150px;padding: 10px 10px 10px 10px;">
									<div class="container">
										<div class="row">
											<h1>Devis n�1 :</h1>
											<p><strong>Activit� : </strong> Lorem ipsum dolor sit amet<br />
											<strong>Zone d'intervention : </strong> Lorem ipsum dolor sit amet�<br />
											<a href="#">+ D�tail</a>
										</div>
									</div>
								</div>
								
								<div class="con" style="height:150px;padding: 10px 10px 10px 10px;">
									<div class="container">
										<div class="row">
											<h1>Devis n�2 :</h1>
											<p><strong>Activit� : </strong> Lorem ipsum dolor sit amet<br />
											<strong>Zone d'intervention : </strong> Lorem ipsum dolor sit amet�<br />
											<a href="#">+ D�tail</a>
										</div>
									</div>
								</div>
								
								<div class="con" style="height:150px;padding: 10px 10px 10px 10px;">
									<div class="container">
										<div class="row">
											<h1>Devis n�3 :</h1>
											<p><strong>Activit� : </strong> Lorem ipsum dolor sit amet<br />
											<strong>Zone d'intervention : </strong> Lorem ipsum dolor sit amet�<br />
											<a href="#">+ D�tail</a>
										</div>
									</div>
								</div>

								

								
								-->
								
								
								
							</div>
						</div>
						<section id="partner">
							<div class="container section4">
								<div class="row">
									<div class="partner">
										<div class="col-md-12">
											<div class="title2">
												<div class="divder"></div>
												<h2>Partenaires</h2>
											</div>
											<?php 
											$req = $my->req('SELECT * FROM ttre_diaporama ');
											if ( $my->num($req)>0 )
											{
												echo'<div id="owl-demo">';
												while ( $res=$my->arr($req) )
												{
													$photo='upload/diaporamas/_no_2.jpg';
													if ( !empty($res['photo']) ) $photo='upload/diaporamas/150X150/'.$res['photo'];
													echo'
														<div class="item"><a target="_blanc" href="'.$res['lien'].'"><img src="'.$photo.'" alt="'.$res['titre'].'"/></a></div>
														';
												}
												echo'</div>';
											}
											?>	
											</div>
										</div>
								</div>
							</div>
						</section>
				</div>	

<?php
$req=$my->req_arr('SELECT * FROM ttre_conseil WHERE id = 1');
// echo $req['description'];
?>

<?php include('inc/pied.php');?>
	</body>
</html>