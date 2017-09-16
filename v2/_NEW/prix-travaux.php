<?php
require('inc/session.php');


include('inc/head.php');?>
	<body id="page1">
		<div class="extra">
			<div class="main">
<!--==============================header=================================-->
				<header>
<?php include('inc/entete.php');?>
<?php include('inc/galerie2.php');?>
				</header>
<!--==============================aside================================-->
				
<!--==============================content================================-->
				<section id="content">
					<div class="wrapper">
						<article class="col-1">
							<div class="indent-left">
								<h2>Prix travaux</h2>





<script type="text/javascript">
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>


<?php 

//--------------------------------- Partie Categegorie ---------------------------
$reqCat=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
if ( $my->num($reqCat)>0 )
{
	$liCat='';
	while ( $resCat=$my->arr($reqCat) )
	{
		$style=' style="background:#F6A20E;color:#fff;" ';
		if ( isset($_GET['cat']) && $_GET['cat']==$resCat['id'] )$style=' style="background:#0495CB;" ';
		if ( !empty($resCat['photo']) ) $logo='<img src="upload/logosCateg/50X30/'.$resCat['photo'].'" />'; else $logo='';
		$liCat.='<li '.$style.'"><a href="prix-travaux.php?cat='.$resCat['id'].'">'.$logo.' <br /> '.$resCat['titre'].'</a></li>';
	}
	echo '<ul id="menu_cat" style="height:55px;">'.$liCat.'</ul>';
}
//--------------------------------- Partie Sous Categegorie ---------------------------
if ( isset($_GET['cat']) )
{
	$reqSCat=$my->req('SELECT * FROM ttre_categories WHERE parent='.$_GET['cat'].' ORDER BY ordre ASC');
	if ( $my->num($reqSCat)>0 )
	{
		$liSCat='';
		while ( $resSCat=$my->arr($reqSCat) )
		{
			$style=' style="background:#F6A20E;color:#fff;" ';
			if ( isset($_GET['scat']) && $_GET['scat']==$resSCat['id'] )$style=' style="background:#0495CB;" ';
			if ( !empty($resSCat['photo']) ) $logo='<img src="upload/logosSousCateg/50X30/'.$resSCat['photo'].'" />'; else $logo='';
			$liSCat.='<li '.$style.'"><a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$resSCat['id'].'">'.$logo.' <br /> '.$resSCat['titre'].'</a></li>';
		}
		echo '<ul id="menu_cat" style="height:55px;">'.$liSCat.'</ul><div style="clear:both;"></div>';
	}
}
//--------------------------------- Partie Partie & Partie Question ---------------------------
if ( isset($_GET['scat']) )
{
	
	$reqPart=$my->req('SELECT * FROM ttre_categories WHERE parent='.$_GET['scat'].' ORDER BY ordre ASC');
	$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_GET['scat'].' ORDER BY ordre ASC');
	if ( $my->num($reqPart)>0 )
	{
		echo '<form method="POST" action="" >';$affich_form=0;
		while ( $resPart=$my->arr($reqPart) )
		{
			if ( isset($_GET['part']) )
			{
				if ( $_GET['part']==$resPart['id'] )
				{
					echo'<p><strong>'.$resPart['titre'].' : <a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$_GET['scat'].'&part='.$resPart['id'].'">[ - ]</a></strong></p>';
					//----------------------------------- Partie Question ---------------------------
					$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_GET['part'].' ORDER BY ordre ASC ');
					if ( $my->num($reqQuest)>0 )
					{
						while ( $resQuest=$my->arr($reqQuest) )
						{
							if ( isset($_POST['quest_'.$resQuest['id_question']]) )
							{
								if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanTouche(event)" />';
								elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanFTouche(event)" />';
								else 
								{
									$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
									$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
									while ( $res_option=$my->arr($req_option) ) 
									{
										if ( $res_option['id_option']==$_POST['quest_'.$resQuest['id_question']] ) $sel='selected="selected"'; else $sel='';
										$champ.='<option value="'.$res_option['id_option'].'" '.$sel.'>'.$res_option['optionn'].'</option>';
									}
									$champ.='</select>';
								}
							}
							else
							{
								if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanTouche(event)" />';
								elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanFTouche(event)" />';
								else 
								{
									$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
									$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
									while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['optionn'].'</option>';
									$champ.='</select>';
								}
							}
							$affich_form=1;
							echo'<p>'.$resQuest['label'].' '.$champ.'</p>';
						}
					}
				}
				else
				{
					echo'<p><strong>'.$resPart['titre'].' : <a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$_GET['scat'].'&part='.$resPart['id'].'">[ + ]</a></strong></p>';
				}
			}
			else 
			{
				echo'<p><strong>'.$resPart['titre'].' : <a href="prix-travaux.php?cat='.$_GET['cat'].'&scat='.$_GET['scat'].'&part='.$resPart['id'].'">[ + ]</a></strong></p>';
			}
		}
		if ( $affich_form==1 ) echo'<input type="submit" name="demander_prix" value="Obtenir le prix" /></form>'; else echo'</form>';
	}
	elseif ( $my->num($reqQuest)>0 )
	{
		//----------------------------------- Partie Question ---------------------------
		if ( $my->num($reqQuest)>0 )
		{
			echo '<form method="POST" action="" >';
			while ( $resQuest=$my->arr($reqQuest) )
			{
				if ( isset($_POST['quest_'.$resQuest['id_question']]) )
				{
					if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanTouche(event)" />';
					elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" value="'.$_POST['quest_'.$resQuest['id_question']].'" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) 
						{
							if ( $res_option['id_option']==$_POST['quest_'.$resQuest['id_question']] ) $sel='selected="selected"'; else $sel='';
							$champ.='<option value="'.$res_option['id_option'].'" '.$sel.'>'.$res_option['optionn'].'</option>';
						}
						$champ.='</select>';
					}
				}
				else
				{
					if ( $resQuest['type']==1 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanTouche(event)" />';
					elseif ( $resQuest['type']==2 ) $champ='<input type="text" id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$resQuest['id_question'].'" name="quest_'.$resQuest['id_question'].'" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$resQuest['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['optionn'].'</option>';
						$champ.='</select>';
					}
				}
				echo'<p>'.$resQuest['label'].' '.$champ.'</p>';
			}
			echo'<input type="submit" name="demander_prix" value="Obtenir le prix" /></form>';
		}
	}
}
//echo'<pre>';print_r($_POST);echo'</pre>';
if ( isset($_POST['demander_prix']) )
{
	if ( isset($_GET['part']) ) $parent=$_GET['part'];
	elseif ( isset($_GET['scat']) ) $parent=$_GET['scat'];
	$i=1;$valid_detail_prix=1;
	$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$parent.' AND type=3 ORDER BY ordre ASC ');
	while ( $resQuest=$my->arr($reqQuest) )
	{
		$reqDetPrix=$my->req('SELECT * FROM ttre_questions_prix_detail WHERE id_question='.$resQuest['id_question'].' AND valeur='.$_POST['quest_'.$resQuest['id_question']].' ');
		if ( $my->num($reqDetPrix)>0 )
		{
			while ( $resDetPrix=$my->arr($reqDetPrix) ) 
			{ 
				$tab[$i][]=$resDetPrix['id_prix'];
			}
			//echo'<pre>';print_r($tab[$i]);echo'</pre>';
		}
		else
		{
			$valid_detail_prix=0;
		}
		if ( $valid_detail_prix==1 )
		{
			if ( $i==1 )
			{
				$tabb=array_intersect($tab[$i],$tab[$i]);
				//echo'array_intersect 1<pre>';print_r($tabb);echo'</pre>';
			}
			else 
			{
				$tabb=array_intersect($tabb,$tab[$i]);
				//echo'array_intersect<pre>';print_r($tabb);echo'</pre>';
			}
		}
		$i++;
	}
	if ( $valid_detail_prix==1 && count($tabb)>0 )
	{
		$resQuest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_categorie='.$parent.' AND type!=3 ORDER BY ordre ASC ');
		if ( $resQuest ) $val=$_POST['quest_'.$resQuest['id_question']]; else $val=1;
		//echo'pingo <pre>';print_r($tabb);echo'</pre>';
		foreach ($tabb as $value) { $id=$value; break; }
		$resPrix=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$id.' ');
		echo'<p>'.$resPrix['designation'].'</p>';
		$prixx=$resPrix['prix']*$val;
		echo'<p>'.number_format($prixx,2).' €</p>';
		if ( $prixx>0 )
		{
			echo'
				<form method="POST" action="?contenu=panier&action=ajouter">
					<input type="hidden" name="id_prix" value="'.$id.'" />
					<input type="hidden" name="qte" value="'.$val.'" />
					<input type="submit" name="ajouter_panier" value="Ajouter au demande de devis" />
				</form>
				';
		}
	}
	else
	{
		echo'<p>Désolé, pour cette combinaison le prix pas encore ajouté.</p>';
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
						$_SESSION['panier_trn'] 			= array();
						$_SESSION['panier_trn']['id'] 		= array();
						$_SESSION['panier_trn']['id_prod'] 	= array();
						$_SESSION['panier_trn']['qte'] 		= array();
						$_SESSION['panier_trn']['prix'] 	= array();
					}
					$indice = count($_SESSION['panier_trn']['id']) + 1;
					$prod=$_POST['id_prix'];$qua=$_POST['qte'];
					
					$produit=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$prod.''); 
					$prix=$produit['prix']; 
					
					$incrementer = -1;
					
					if ( count($_SESSION['panier_trn']['id_prod'])>0 && array_search($prod,$_SESSION['panier_trn']['id_prod'])!==false )
					{
						$i = 0;
						while ( $i<count($_SESSION['panier_trn']['id']) && $incrementer == -1 )
						{
							if ( $_SESSION['panier_trn']['id_prod'][$i]==$prod ) $incrementer = $i;
							$i++;
						}
					}
					if ( $incrementer != -1 )
					{ 
						$_SESSION['panier_trn']['qte'][$incrementer]=$_SESSION['panier_trn']['qte'][$incrementer]+$qua;
					}	
					else
					{
						$_SESSION['panier_trn']['id'][]=$indice;
						$_SESSION['panier_trn']['id_prod'][]=$prod;
						$_SESSION['panier_trn']['qte'][]=$qua; 
						$_SESSION['panier_trn']['prix'][]=$prix; 
					}				
					echo '<script>window.location="prix-travaux.php"</script>';
					break;
				case 'modifier' :
					for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )
					{	
						if ( isset($_POST['quantite'.$_SESSION['panier_trn']['id'][$i]]) )
						{
							$_SESSION['panier_trn']['qte'][$i]=$_POST['quantite'.$_SESSION['panier_trn']['id'][$i]];
						}
					}
					echo '<script>window.location="prix-travaux.php?modifier=ok"</script>';			
					break;
				case 'supprimer' :
					$_SESSION['panier_tmp'] 			= array();
					$_SESSION['panier_tmp']['id'] 		= array();
					$_SESSION['panier_tmp']['id_prod'] 	= array();
					$_SESSION['panier_tmp']['qte'] 		= array();
					$_SESSION['panier_tmp']['prix'] 	= array();
					$indice = 1;
					$nb_articles = count($_SESSION['panier_trn']['id']);
					for ( $x=0;$x<$nb_articles;$x++ )
					{
						# transférer tous les items dans le panier temp sauf ceux à supprimer
						if ( $_SESSION['panier_trn']['id'][$x] != $_GET['id'] )
						{
							array_push($_SESSION['panier_tmp']['id'],$indice);
							array_push($_SESSION['panier_tmp']['id_prod'],$_SESSION['panier_trn']['id_prod'][$x]);
							array_push($_SESSION['panier_tmp']['qte'],$_SESSION['panier_trn']['qte'][$x]); 
							array_push($_SESSION['panier_tmp']['prix'],$_SESSION['panier_trn']['prix'][$x]);
							$indice ++;
						}
					}
					$_SESSION['panier_trn'] = $_SESSION['panier_tmp'];
					unset($_SESSION['panier_tmp']);
					if ( $nb_articles == 1 )
					{
						unset($_SESSION['panier_trn']);
						echo '<script>window.location="prix-travaux.php"</script>';						
					}
					else
					{
						echo '<script>window.location="prix-travaux.php?supprimer=ok"</script>';						
					}
					break;
				case 'vider' :
					unset($_SESSION['panier_trn']);
					echo '<script>window.location="prix-travaux.php"</script>';
					break;
			}
			break;
	}
}

//echo'<pre>';print_r($_SESSION);echo'</pre>';


if ( isset($_SESSION['panier_trn']) )
{
	$montantTotal = 0;
	//$poidsTotal = 0;
	$panier='';
	
	for ( $i=0;$i<count($_SESSION['panier_trn']['id']);$i++ )	
	{	
		$prod=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$_SESSION['panier_trn']['id_prod'][$i].' ');
		
		$nomProduit = ucfirst(html_entity_decode($prod['designation']));
		$prixUnitaire = $_SESSION['panier_trn']['prix'][$i];
		$clef = $_SESSION['panier_trn']['id'][$i];
		$quantite = $_SESSION['panier_trn']['qte'][$i];
		$total = $prixUnitaire * $quantite;
		$montantTotal = $montantTotal + $total;
		//$poidsTotal = $poidsTotal + $prod['poids'];
		// pour le td ajouter class="align_left" pour ecrire au debut de colonne n'est pas au centre 
		$panier.='
				<tr>
					<td>'.$nomProduit.'</td>		
					<td>'.number_format($prixUnitaire, 2,'.','').' €</td>
					<td><input class="panier_qte" maxlength="3" type="text" name="quantite'.$clef.'" value="'.$quantite.'" onKeyPress="return scanFTouche(event)"/></td>
					<td>'.number_format($total, 2,'.','').' €</td>
					<td><a href="?contenu=panier&action=supprimer&id='.$clef.'" title="Supprimer ce article de panier"><img src="stockage_img/supprimer.png" alt="Supprimer ce article de panier"/></a></td>
				</tr>
			';
	}	
	$fraisPort=0;
	$montantTotalTTC = $montantTotal + $fraisPort ;
	/*$affich_frais='
			<tr class="total"><td colspan="5"><br /></td></tr>
			<tr class="total">
				<td colspan="4"><strong>Sous-total : </strong></td>
				<td class="prix_final">'.number_format($montantTotal, 2).'€</td>
			</tr>								
			<tr class="total">
				<td colspan="4"><strong>Frais de port : </strong></td>
				<td class="prix_final">'.number_format($fraisPort, 2).'€</td>
			</tr>								
		';*/
	$affich_frais='';
	if ( isset($_GET['supprimer']) ) $alert='<div id="note" class="notes" style="margin: 0 0 0 100px; width: 400px;"><p>Produit supprimé avec succès.</p></div><br />';
	elseif ( isset($_GET['modifier']) ) $alert='<div id="note" class="notes" style="margin: 0 0 0 100px; width: 400px;"><p>Quantité mise à jour avec succès.</p></div><br />';
	else  $alert='<div id="note" style="margin: 0 0 0 100px; width: 400px;"></div><br />';
	
//		<div id="espace_compte">
//			<div class="conteneur_ariane_cmd">
//				<ul id="compte_ariane_cmd">
//					<li class="courant">1. <a href="panier.php">Panier</a></li>
//					<li>2. S\'identifier</li>
//					<li>3. Livraison</li>	
//					<li>4. Récapitulatif</li>								
//					<li>5. Paiement</li>
//					<li class="ariane_cmd_fil"></li>
//				</ul>
//			</div>
//		</div><br />
	echo'
		<br /><br />
		'.$alert.'
		<div id="espace_compte">
			<form method="post" action="?contenu=panier&action=modifier">					
			<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
				<tr class="entete">
					<td>Désignation</td>														
					<td>P.U</td>
					<td>Qte</td>
					<td>Total</td>
					<td></td>
				</tr>		
				'.$panier.'
				'.$affich_frais.'
				<tr class="total">
					<td colspan="3"><strong>Total : </strong></td>
					<td colspan="2" class="prix_final">'.number_format($montantTotalTTC, 2,'.','').'€</td>
				</tr>								
			</table>
			<p id="panier_boutons">
				<span class="panier_actions"><a class="panier_vider" href="?contenu=panier&action=vider">Vider le panier</a></span>
				<input type="submit" value="Recalculer" name="recalcul_panier"/>
			</p>
		</form>
		</div>
		';				
//				<input type="button" value="Poursuivre ma commande" onclick="javascript:window.location=\'panier.php?contenu=authentification\'" />
}
else 
{
	if ( isset($_GET['paiement']) )
	{
		if ( $_GET['paiement']=='valider' ) 
			echo'<br /><br /><br /><div id="note" class="notes" style="margin: 0 0 0 60px; width: 400px;"><p>Le paiement a été effectué avec succés.</p></div>';
		elseif ( $_GET['paiement']=='annuler' )
			echo'<br /><br /><br /><div id="note" class="notes" style="margin: 0 0 0 60px; width: 400px;"><p>Le paiement a été annulé.</p></div>';
	}
	else
	{
		//echo'<p>Votre panier est vide.</p>';	
	}
}

?>















<style>
ul#menu_cat li {
	cursor:pointer;
	float:left;
	height:80px;
	min-width:72px;
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	width:100px;
	padding-left:1px;
	padding-right:1px;
	 -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
	margin-bottom:10px;
	font-size:12px;
}
ul#menu_cat li img{ margin-top:10px; height:30px;}
.classLiScat {
     cursor:pointer;
	float:left;
	height:80px;
	min-width:100px;
	text-align:center;
	margin:0 1px 0 0;
	line-height:20px;
	 -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
	font-size:12px;
	padding-left:1px;
	padding-right:1px;
}
.classLiScat img{ margin-top:10px; height:30px;}
</style>





</div>
						</article>
<?php include('inc/droite.php');?>
						</div>
					<div class="block"></div>
				</section>
			</div>
		</div>
<!--==============================footer=================================-->
<?php include('inc/pied.php');?>
	</body>
</html>



