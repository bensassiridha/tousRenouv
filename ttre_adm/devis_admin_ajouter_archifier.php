<?php 
$my = new mysql();


// stat_ajout_zone ?
// 0 : affiché sur ajout et zone
// 1 : affiché sur ajout
// 2 : affiché sur admin


//echo 'es'.(int)('5|4y52');

if ( isset($_GET['sms']) )
{
	require_once 'smsenvoi.php';
	$sms=new smsenvoi();
	$sms->debug=true;
	$cat = $my->req_arr('SELECT * FROM ttre_email WHERE id=8 ');
	$sms->sendSMS('+21652670834',html_entity_decode(strip_tags($cat['description'])));
	
	//$sms->sendSMS('+21652670834','Mon premier SM %0d%0a -test: http://www.smsenvoi.com ');
	//$sms->sendSMS('+33760255461','Mon premier SMS en PHP 1');
	//$sms->sendCALL('+21652670834','Bonjour voici un test');
	//$sms->sendCALL('+33760255461','Bonjour voici un test1');
	
	echo '<pre>';print_r($sms->checkCredits());echo'</pre>';
}


/*$req=$my->req('SELECT * FROM ttre_achat_devis_suite ');
while ( $res=$my->arr($req) )
{
	if ( !empty($res['commentaire']) )
		$my->req("INSERT INTO ttre_achat_devis_commentaire VALUES('',
								'".$my->net_input($res['id_devis'])."',
								'".$my->net_input('')."',
								'".$my->net_input($res['commentaire'])."'
								)");
	if ( !empty($res['commentaire_refuser']) )
		$my->req("INSERT INTO ttre_achat_devis_commentaire VALUES('',
								'".$my->net_input($res['id_devis'])."',
								'".$my->net_input('')."',
								'".$my->net_input($res['commentaire_refuser'])."'
								)");
}*/





if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		/*case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$my->req("INSERT INTO ttre_client_part VALUES('',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'".$my->net_input($_POST["civ"])."',
								'".$my->net_input($_POST["nom"])."',
								'".$my->net_input($_POST["prenom"])."',
								'".$my->net_input($_POST["tel"])."',
								'".$my->net_input($_POST["email"])."',
								'".$my->net_input($_POST["voiec"])."',
								'".$my->net_input($_POST["appc"])."',
								'".$my->net_input($_POST["batc"])."',
								'".$my->net_input($_POST["cpc"])."',
								'".$my->net_input($_POST["villec"])."',
								'".$my->net_input($_POST["paysc"])."',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'--',
								'0',
								'--',
								'-1'
								)");
				$idc=mysql_insert_id();
				
				if ( $_POST['radadd']==1 )
				{
					$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
								'".$my->net_input($idc)."',
								'".$my->net_input($_POST["voiec"])."',
								'".$my->net_input($_POST["appc"])."',
								'".$my->net_input($_POST["batc"])."',
								'".$my->net_input($_POST["cpc"])."',
								'".$my->net_input($_POST["villec"])."',
								'".$my->net_input($_POST["paysc"])."',
								'1'
								)");
					$ida=mysql_insert_id();
				}
				else
				{
					$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
								'".$my->net_input($idc)."',
								'".$my->net_input($_POST["voiea"])."',
								'".$my->net_input($_POST["appa"])."',
								'".$my->net_input($_POST["bata"])."',
								'".$my->net_input($_POST["cpa"])."',
								'".$my->net_input($_POST["villea"])."',
								'".$my->net_input($_POST["paysa"])."',
								'1'
								)");
					$ida=mysql_insert_id();
				}
				
				$reference_devis = uniqid('R');
				$my->req("INSERT INTO ttre_achat_devis VALUES('',
								'".$reference_devis."',
								'".time()."',
								'".$idc."',
								'".$ida."',
								'".$_SESSION['id_user']."',
								'0',
								'0',
								'-1',
								'0'
								)");
				$id_devis = mysql_insert_id();
				
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) )
				{
					if ( !empty($_POST['cat_'.$res['id'].'']) )
					{
						$or_categ=$res['ordre'];
						$id_categ=$res['id'];
						$titre_categ=$res['titre'];
						$desc_piece=$_POST['cat_'.$res['id'].''];
						$my->req("INSERT INTO ttre_achat_devis_details VALUES('',
										'".$id_devis."',
										'".$or_categ."',
										'".$id_categ."',
										'".$my->net($titre_categ)."',
										'".$my->net_textarea($desc_piece)."'
										)");
					}
				}
				
				for ( $i=1 ; $i<=5 ; $i++ )
				{
					$handle = new Upload($_FILES['fichier'.$i]);
					if ($handle->uploaded)
					{
						$handle->Process('../upload/devis/');
						if ($handle->processed)
						{
							$fichier  = $handle->file_dst_name ;	          // Destination file name
							$handle-> Clean();                           // Deletes the uploaded file from its temporary location
							$my->req("INSERT INTO ttre_achat_devis_fichier_suite VALUES('','".$id_devis."','".$fichier."')");
						}
					}
				}
				//--------------------- Envoie SMS --------------------------
				$devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$id_devis);
				$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
				$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
				$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
				$req = $my->req('SELECT * FROM ttre_client_pro_departements WHERE id_departement='.$id_departement['departement_id']);
				if ( $my->num($req)>0 )
				{
					$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_achat_devis_details WHERE id_devis='.$id_devis.' ');
					while ( $r=$my->arr($q) ) 
					{
						$tab_devis[]=$r['id_categ'];
						$qqq=$my->req_arr('SELECT * FROM ttre_categories WHERE id='.$r['id_categ'].' ');
						$cccat.=$qqq['titre'].' ,';
					}
					while ( $res=$my->arr($req) )
					{
						$tab_client=array();
						$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' '); 
						while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
						$c=array_intersect($tab_devis,$tab_client);
						if ( $tab_devis === $c )
						{
							$temptemp=$my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$id_departement['departement_id'].' ');
							$temp=$my->req_arr('SELECT * FROM ttre_zcoordonnees WHERE id='.$temptemp['id_user'].' ');
							if ( $temp['tel']==52670834 ) $tel='+21652670834';
							else $tel='+33'.$temp['tel'];
							
							$vvville=$code_departement['ville_nom_reel'];
							$dddep=$id_departement['departement_nom'];
							$cpart = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$devis['id_client']);
							$messsms='Merci de contacter "'.$cpart['nom'].'" "'.$cpart['prenom'].'" 
									 - Tel : "'.$cpart['telephone'].'" - Catégorie : "'.$cccat.'" 
									 - dans la ville "'.$vvville.'" / "'.$dddep.'" ';
							
							require_once 'smsenvoi.php';
							$sms=new smsenvoi();
							$sms->debug=true;
							$sms->sendSMS($tel,$messsms);
						}
					}
				}
				
				
				//-----------------------------------------------------------
				rediriger('?contenu=devis_admin_ajouter&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','?contenu=devis_admin_ajouter&action=ajouter','<h2 class="titre_niv2">Ajouter Devis :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				
				$form->vide('<tr><td colspan="2">Détail de devis :</td></tr>');
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) )
				{
					$form->textarea($res['titre'],'cat_'.$res['id'].'');
				}
				//$form->hidden('Nombre d\'estimation','nbr','',1);
				for ( $i=1 ; $i<=5 ; $i++ )
				{
					$form->photo('Fichier '.$i.'','fichier'.$i.'');
				}
				
				$form->vide('<tr><td colspan="2"><br /><br />Détail de Client :</td></tr>');
				$tabciv=array('Mr'=>'Mr','Mlle'=>'Mlle','Mme'=>'Mme');
				$form->radio_cu('Civilité','civ',$tabciv,'Mr');
				$form->text('Nom','nom','',1);
				$form->text('Prénom','prenom','',1);
				$form->text('Email','email','',1);
				$form->text('Téléphone','tel','',1);
				$form->text('Numéro et voie','voiec','',1);
				$form->text('N° d\'appartement, Etage, Escalier','appc','',1);
				$form->text('Bâtiment, Résidence, Entrée','batc','',1);
				$form->text('Code postal','cpc','',1);
				$form->select('Ville','villec','','',1);
				$form->text('Pays','paysc','readonly="readonly"',1,'France');
				
				
				$tabadd=array(1=>'Oui',0=>'Non');
				$form->radio_cu('<br /><br />L\'adresse du chantier est <br />la meme que l\'adresse du client ?','radadd',$tabadd,1);
				$form->vide('<table id="adresse_chantier" style="display:none">');
				$form->vide('<tr><td colspan="2"><br /><br />Détail de l\'adresse du chantier:</td></tr>');
				$form->text('Numéro et voie','voiea','',1);
				$form->text('N° d\'appartement, Etage, Escalier','appa','',1);
				$form->text('Bâtiment, Résidence, Entrée','bata','',1);
				$form->text('Code postal','cpa','',1);
				$form->select('Ville','villea','','',1);
				$form->text('Pays','paysa','readonly="readonly"',1,'France');
				$form->vide('</table>');
				
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=devis_admin_ajouter">Retour</a></p>';
			}
			break;*/
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$info_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
				$my->req('UPDATE ttre_client_part SET
									civ					=	"'.$my->net_input($_POST['civ']).'" ,
									nom					=	"'.$my->net_input($_POST['nom']).'" ,
									prenom				=	"'.$my->net_input($_POST['prenom']).'" ,
									telephone			=	"'.$my->net_input($_POST['tel']).'" ,
									email				=   "'.$my->net_input($_POST['email']).'"  ,
									num_voie			=	"'.$my->net_input($_POST['voiec']).'" ,
									num_appart			=	"'.$my->net_input($_POST['appc']).'" ,
									batiment			=	"'.$my->net_input($_POST['batc']).'" ,
									code_postal			=	"'.$my->net_input($_POST['cpc']).'" ,
									ville				=	"'.$my->net_input($_POST['villec']).'" ,
									pays				=	"'.$my->net_input($_POST['paysc']).'" 
											WHERE id='.$info_devis['id_client'].'') ;
				if ( $_POST['radadd']==1 )
				{
					$my->req ('UPDATE ttre_client_part_adresses SET
											num_voie			=	"'.$my->net_input($_POST['voiec']).'" ,
											num_appart			=	"'.$my->net_input($_POST['appc']).'" ,
											batiment			=	"'.$my->net_input($_POST['batc']).'" ,
											code_postal			=	"'.$my->net_input($_POST['cpc']).'" ,
											ville				=	"'.$my->net_input($_POST['villec']).'" ,
											pays				=	"'.$my->net_input($_POST['paysc']).'"
												WHERE id="'.$info_devis['id_adresse'].'"' );
				}
				else
				{
					$my->req ('UPDATE ttre_client_part_adresses SET
											num_voie			=	"'.$my->net_input($_POST['voiea']).'" ,
											num_appart			=	"'.$my->net_input($_POST['appa']).'" ,
											batiment			=	"'.$my->net_input($_POST['bata']).'" ,
											code_postal			=	"'.$my->net_input($_POST['cpa']).'" ,
											ville				=	"'.$my->net_input($_POST['villea']).'" ,
											pays				=	"'.$my->net_input($_POST['paysa']).'"
												WHERE id="'.$info_devis['id_adresse'].'"' );
				}
				//$my->req ('UPDATE ttre_achat_devis SET nbr_estimation =	"'.$my->net_input($_POST['nbr']).'" WHERE id="'.$_GET['id'].'"' );
				
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) )
				{
					if ( !empty($_POST['cat_'.$res['id'].'']) )
					{
						$or_categ=$res['ordre'];
						$id_categ=$res['id'];
						$titre_categ=$res['titre'];
						$desc_piece=$_POST['cat_'.$res['id'].''];
						$reqqa=$my->req('SELECT *  FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' AND id_categ='.$res['id'].' ');
						if ( $my->num($reqqa)>0 )
						{
							$my->req ('UPDATE ttre_achat_devis_details SET piece = "'.$my->net_textarea($desc_piece).'" WHERE id_devis='.$_GET['id'].' AND id_categ='.$res['id'].' ');
						}
						else
						{
							$my->req("INSERT INTO ttre_achat_devis_details VALUES('',
											'".$_GET['id']."',
											'".$or_categ."',
											'".$id_categ."',
											'".$my->net($titre_categ)."',
											'".$my->net_textarea($desc_piece)."'
											)");
						}
					}
					else
					{
						$my->req('DELETE FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' AND id_categ='.$res['id'].' ');
					}
				}
				
				$req_fic=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
				if ( $my->num($req_fic)>0 )
				{
					$i=0;
					while ( $res_fic=$my->arr($req_fic) )
					{
						$i++;
						$handle = new Upload($_FILES['fichier_'.$i]);
						if ($handle->uploaded)
						{
							$handle->Process('../upload/devis/');
							if ($handle->processed)
							{
								@unlink('../upload/devis/'.$res_fic['fichier']);
								$fichier  = $handle->file_dst_name ;	          // Destination file name
								$handle-> Clean();                           // Deletes the uploaded file from its temporary location
								$my->req('UPDATE ttre_achat_devis_fichier_suite SET fichier = "'.$fichier.'" WHERE id='.$res_fic['id'].' ');
							}
						}
					}
				}
				$ff=$my->req('SELECT *  FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
				$reste=5-$my->num($ff);
				
				for ( $i=1 ; $i<=$reste ; $i++ )
				{
					$handle = new Upload($_FILES['fichier'.$i]);
					if ($handle->uploaded)
					{
						$handle->Process('../upload/devis/');
						if ($handle->processed)
						{
							$fichier  = $handle->file_dst_name ;	          // Destination file name
							$handle-> Clean();                           // Deletes the uploaded file from its temporary location
							$my->req("INSERT INTO ttre_achat_devis_fichier_suite VALUES('','".$_GET['id']."','".$fichier."')");
						}
					}
				}
				
				$my->req('UPDATE ttre_achat_devis SET prix_achat="'.$_POST['prix'].'" WHERE id='.$_GET['id']);
				
				$pbb=0;$stat_ajout_zone=0;
				if ( $_POST['pb']==1 ) { $pbb='1|'.$_POST['pb1'].'$'.$_POST['pb11']; $stat_ajout_zone=0; }
				elseif ( $_POST['pb']==2 ) { $pbb='2|'.$_POST['pb2'].'$'.$_POST['pb22']; $stat_ajout_zone=0; }
				elseif ( $_POST['pb']==3 ) { $pbb='3|'; $stat_ajout_zone=1; }
				elseif ( $_POST['pb']==4 ) { $pbb='4|'; $stat_ajout_zone=1; }
				elseif ( $_POST['pb']==5 ) { $pbb='5|'; $stat_ajout_zone=1; }
				elseif ( $_POST['pb']==6 ) { $pbb='6|'.$_POST['pb3']; $stat_ajout_zone=0; }
				elseif ( $_POST['pb']==7 ) { $pbb='7|'; $stat_ajout_zone=1; }
				elseif ( $_POST['pb']==8 ) { $pbb='8|'; $stat_ajout_zone=1; }
				$req = $my->req('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
				if ( $my->num($req)==0 )
					$my->req('INSERT INTO ttre_achat_devis_suite VALUES("","'.$_GET['id'].'","'.$pbb.'","'.$stat_ajout_zone.'")');
				else
					$my->req('UPDATE ttre_achat_devis_suite SET stat_devis_attente="'.$pbb.'" , stat_ajout_zone="'.$stat_ajout_zone.'" WHERE id_devis='.$_GET['id']);
				
				if ( !empty($_POST['commentaire']) )
					$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_user'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
				
				if ( isset($_POST['retour']) )
					$my->req('UPDATE ttre_achat_devis SET stat_suppr="0" WHERE id='.$_GET['id']);
				
				rediriger('?contenu=devis_admin_ajouter_archifier&modifier=ok');
			}
			else
			{
				if ( isset($_GET['supprfichier']) )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id="'.$_GET['supprfichier'].'"');
					@unlink('../upload/devis/'.$temp['fichier']);
					$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id = "'.$_GET['supprfichier'].'" ' );
					rediriger('?contenu=devis_admin_ajouter_archifier&action=modifier&id='.$_GET['id'].'&fichiersuppr=ok');
				}
				
				if ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
				if ( isset($_GET['fichiersuppr']) ) echo '<div class="success"><p>Cette fichier a bien été supprimée.</p></div>';
				$info_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
				
				$form = new formulaire('modele_1','?contenu=devis_admin_ajouter_archifier&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier Devis :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				
				$form->vide('<tr><td colspan="2">Détail de devis :</td></tr>');
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) )
				{
					$info_devis_detail=$my->req_arr('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' AND id_categ='.$res['id'].' ');
					if ( $info_devis_detail )
						$form->textarea($res['titre'],'cat_'.$res['id'].'',str_replace('<br />',' ',$info_devis_detail['piece']));
					else
						$form->textarea($res['titre'],'cat_'.$res['id'].'');
				}
				//$form->hidden('Nombre d\'estimation','nbr','',1,$info_devis['nbr_estimation']);
				
				
				$req_fic=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
				if ( $my->num($req_fic)>0 )
				{
					$form->vide('<tr><td colspan="2"><br /><br />
							<table>
								<thead>
							    	<tr style="background-color:#D3DCE3;text-align:center;">
							            <th align="center"><label>Fichier</label></th>
							            <th align="center"><label>Modifier</label></th>
							            <th align="center"><label>Supprimer</label></th>
							        </tr>
				   		 		</thead>
				    			<tbody>
								 ');
					$j=0;
					while ( $res_fic=$my->arr($req_fic) )
					{
						$j++;
						$form->vide('
									<tr style="background-color:#E5E5E5;text-align:center;">
										<td><a href="../upload/devis/'.$res_fic['fichier'].'" target="_blanc">'.$res_fic['fichier'].'</a></td>
							            <td><input type="file" name="fichier_'.$j.'"  /></td>
							            <td><a href="?contenu=devis_admin_ajouter&action=modifier&id='.$_GET['id'].'&supprfichier='.$res_fic['id'].'">Supprimer</a></td>
									</tr>
									 ');
					}
					$form->vide('
								</tbody>
							</table><br /><br /></td></tr>
								  ');
				}
				$ff=$my->req('SELECT *  FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
				$reste=5-$my->num($ff);
				for ( $i=1 ; $i<=$reste ; $i++ )
				{
					$form->photo('Fichier '.$i.'','fichier'.$i.'');
				}
				
				$info_client=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$info_devis['id_client'].' ');
				if ( ($info_client['code_postal']>=75001 && $info_client['code_postal']<=75020) || $info_client['code_postal']==75116 )
				{
					$res=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal=75001 ');
					$tab_villec[$res['ville_id']]=$res['ville_nom_reel'];
				}
				else
				{
					$option='';
					$req=$my->req('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$info_client['code_postal'].' ORDER BY ville_id ASC');
					if ( $my->num($req)>0 )
					{
						while ( $res=$my->arr($req) )
						{
							$tab_villec[$res['ville_id']]=$res['ville_nom_reel'];
						}
					}
				}
				$form->vide('<tr><td colspan="2"><br /><br />Détail de Client :</td></tr>');
				$tabciv=array('Mr'=>'Mr','Mlle'=>'Mlle','Mme'=>'Mme');
				$form->radio_cu('Civilité','civ',$tabciv,$info_client['civ']);
				$form->text('Nom','nom','',1,$info_client['nom']);
				$form->text('Prénom','prenom','',1,$info_client['prenom']);
				$form->text('Email','email','',1,$info_client['email']);
				$form->text('Téléphone','tel','',1,$info_client['telephone']);
				$form->text('Numéro et voie','voiec','',1,$info_client['num_voie']);
				$form->text('N° d\'appartement, Etage, Escalier','appc','',1,$info_client['num_appart']);
				$form->text('Bâtiment, Résidence, Entrée','batc','',1,$info_client['batiment']);
				$form->text('Code postal','cpc','',1,$info_client['code_postal']);
				$form->select_cu('Ville','villec',$tab_villec,$info_client['ville'],1);
				$form->text('Pays','paysc','readonly="readonly"',1,$info_client['pays']);
				
				$info_addresse=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$info_devis['id_adresse'].' ');
				if ( ($info_addresse['code_postal']>=75001 && $info_addresse['code_postal']<=75020) || $info_addresse['code_postal']==75116 )
				{
					$res=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal=75001 ');
					$tab_villea[$res['ville_id']]=$res['ville_nom_reel'];
				}
				else
				{
					$option='';
					$req=$my->req('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$info_addresse['code_postal'].' ORDER BY ville_id ASC');
					if ( $my->num($req)>0 )
					{
						while ( $res=$my->arr($req) )
						{
							$tab_villea[$res['ville_id']]=$res['ville_nom_reel'];
						}
					}
				}
				if ( $info_client['num_voie']==$info_addresse['num_voie'] && $info_client['num_appart']==$info_addresse['num_appart'] && $info_client['batiment']==$info_addresse['batiment'] && $info_client['code_postal']==$info_addresse['code_postal'] && $info_client['ville']==$info_addresse['ville'] && $info_client['pays']==$info_addresse['pays'] )
				{
					$style=' style="display:none" ';
					$er=1;
				}
				else 
				{
					$style=' style="display:block" ';
					$er=0;
				}
				$tabadd=array(1=>'Oui',0=>'Non');
				$form->radio_cu('<br /><br />L\'adresse du chantier est <br />la meme que l\'adresse du client ?','radadd',$tabadd,$er);
				$form->vide('<table id="adresse_chantier" '.$style.' >');
				$form->vide('<tr><td colspan="2"><br /><br />Détail de l\'adresse du chantier:</td></tr>');
				$form->text('Numéro et voie','voiea','',1,$info_addresse['num_voie']);
				$form->text('N° d\'appartement, Etage, Escalier','appa','',1,$info_addresse['num_appart']);
				$form->text('Bâtiment, Résidence, Entrée','bata','',1,$info_addresse['batiment']);
				$form->text('Code postal','cpa','',1,$info_addresse['code_postal']);
				$form->select_cu('Ville','villea',$tab_villea,$info_addresse['ville'],1);
				$form->text('Pays','paysa','readonly="readonly"',1,$info_addresse['pays']);
				$form->vide('</table>');
				
				$pb1='';$pb2='';$pb3='';$pb4='';$pb5='';$pb6='';$pb7='';$pb8='';$d1='';$d11='';$d2='';$d22='';$d3='';
				$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
				list($p,$d) = split('[|]',$respb['stat_devis_attente']);
				if ( $p==1 ) { $pb1='checked="checked"'; list($d1,$d11) = split('[$]',$d); }
				elseif ( $p==2 ) { $pb2='checked="checked"'; list($d2,$d22) = split('[$]',$d); }
				elseif ( $p==3 ) { $pb3='checked="checked"'; }
				elseif ( $p==4 ) { $pb4='checked="checked"'; }
				elseif ( $p==5 ) { $pb5='checked="checked"'; }
				elseif ( $p==6 ) { $pb6='checked="checked"'; $d3=$d; }
				elseif ( $p==7 ) { $pb7='checked="checked"'; }
				elseif ( $p==8 ) { $pb8='checked="checked"'; }
				
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
								
				$form->vide('<tr><td colspan="2"><br /><br />Pb devis : </td></tr>');
				$form->vide('<tr><td colspan="2"><br />');
				$form->vide('<input type="radio" name="pb" '.$pb1.' value="1" >RDV pris le <input class="datepicker" name="pb1" type="text" value="'.$d1.'" /> à <input name="pb11" type="text" value="'.$d11.'" /><br />');
				$form->vide('<input type="radio" name="pb" '.$pb2.' value="2" >A rappeler verifiez à la date <input class="datepicker" name="pb2" type="text" value="'.$d2.'" /> à <input name="pb22" type="text" value="'.$d22.'" /> <br />');
				$form->vide('<input type="radio" name="pb" '.$pb3.' value="3" >Travaux fini<br />');
				$form->vide('<input type="radio" name="pb" '.$pb4.' value="4" >Faux numéro<br />');
				$form->vide('<input type="radio" name="pb" '.$pb5.' value="5" >Déjà trouver un artisan<br />');
				$form->vide('<input type="radio" name="pb" '.$pb7.' value="7" >Pas de travaux<br />');
				$form->vide('<input type="radio" name="pb" '.$pb8.' value="8" >Projet abandonné<br />');
				$form->vide('<input type="radio" name="pb" '.$pb6.' value="6" >autres <textarea name="pb3" type="text" >'.$d3.'</textarea><br /><br /><br />');
				$form->vide('</td></tr>');
				
				$touscom='';
				$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ORDER BY date ASC');
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
				
				$form->vide('<tr><td colspan="2">');
				$form->vide('
								'.$formsuitezone.'
								<p>Commentaire devis :
									'.$touscom.'
								<br /> Ajouter commentaire : <textarea name="commentaire" style="width:80%;height:150px;" ></textarea><br /><br />
								</p>

							');
				$form->vide('</td></tr>');
				$form->text('Prix','prix','onKeyPress="return scanFTouche(event)"',1,$info_devis['prix_achat']);
				$form->vide('<tr><td colspan="2"><br /><br /><input type="checkbox" name="retour"  value="0" > Re - activer le devis<br /><br /><br /></td></tr>');
				$form->vide('<tr><td><br /><br /></td><td></td></tr>');
				
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=devis_admin_ajouter">Retour</a></p>';
				
			}
			break;
		case 'supprimer' :
			$temp=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_client_part WHERE id='.$temp['id_client'].' ');
			$my->req('DELETE FROM ttre_client_part_adresses WHERE id='.$temp['id_adresse'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			while ( $res=$my->arr($req) )
			{
				@unlink('../upload/devis/'.$res['fichier']);
			}
			$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			//$my->req('UPDATE ttre_achat_devis SET stat_suppr="1" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_admin_ajouter_archifier&supprimer=ok');
			break;	
		/*case 'valider' :
			$tt = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id']);
			$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="-2" WHERE id='.$_GET['id']);
			//---------recherche les client qui travaille sur la meme departement--------
			$devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id']);
			$adresse = $my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$devis['id_adresse']);
			$code_departement = $my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$adresse['ville']);
			$id_departement = $my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$code_departement['ville_departement']);
			$req = $my->req('SELECT * FROM ttre_client_pro_departements WHERE id_departement='.$id_departement['departement_id']);
			if ( $my->num($req)>0 )
			{
				//---------recherche les client qui travaille sur les meme categories--------
				$q=$my->req('SELECT DISTINCT(id_categ) FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' '); while ( $r=$my->arr($q) ) $tab_devis[]=$r['id_categ'];
				while ( $res=$my->arr($req) )
				{
					$tab_client=array();
					$q=$my->req('SELECT * FROM ttre_client_pro_categories WHERE id_client='.$res['id_client'].' '); while ( $r=$my->arr($q) ) $tab_client[]=$r['id_categorie'];
					$c=array_intersect($tab_devis,$tab_client);
					if ( $tab_devis === $c )
					{
						$my->req('INSERT INTO ttre_achat_devis_client_pro VALUES("","'.$_GET['id'].'","'.$res['id_client'].'","","","","","")');
						$temp=$my->req_arr('SELECT * FROM ttre_client_pro WHERE id='.$res['id_client'].' ');
						$nom=$temp['nom'];$mail=$temp['email'];$tel=$temp['telephone'];
						//-------------- envoie mail -------------------------------
						$contenu_email=$my->req_arr('SELECT * FROM ttre_email WHERE id=5 ');//$contenu_email['description']
						
						$suite='<table cellpadding="0" cellspacing="0">';
						$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ORDER BY ordre_categ ASC ');
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
									<p>Un nouveau devis a été realisé dans votre zone d\'intervention</p>
									<p>Voici les détails :</p>
									'.$suite.'
									<div id="pied" style="width:800px; height:auto; font-size:14px; margin-top:20px;">
										<p style="padding-top:10px;">'.$nom_client.'</p>
									</div>
								</div>
							</body>
							</html>
							';
						//$mail_client='bilelbadri@gmail.com';
						
						$destinataire=$mail;
						//$destinataire='bilelbadri@gmail.com';
						$email_expediteur=$mail_client;
						$email_reply=$mail_client;
						$titre_mail=$nom_client;
						$sujet=$nom_client.' : Nouveau devis ';
						
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
						
						// Pièce jointe
						$rq=$my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].'');
						while( $rs=$my->arr($rq) )
						{
							$message .= '--'.$frontiere."\n";
						
							$file_type = mime_content_type('../upload/devis/'.$rs['fichier'].'');
							
							$message .= 'Content-Type: '.$file_type.'; name="../upload/devis/'.$rs['fichier'].'"'."\n";
							$message .= 'Content-Transfer-Encoding: base64'."\n";
							$message .= 'Content-Disposition:attachement; filename="'.$rs['fichier'].'"'."\n\n";
							$message .= chunk_split(base64_encode(file_get_contents('../upload/devis/'.$rs['fichier'].'')))."\n";
						}
						// Fin
							
						$message .= '--'.$frontiere.'--'."\r\n";
							
						mail($destinataire,$sujet,$message,$headers);
						
						$cat = $my->req_arr('SELECT * FROM ttre_email WHERE id=7 ');
						if ( $cat['description']==1  && $tel!=0 )
						{
							if ( $tel==52670834 ) $tel='+21652670834';
							else $tel='+33'.$tel;
							$cat = $my->req_arr('SELECT * FROM ttre_email WHERE id=8 ');
							
							require_once 'smsenvoi.php';
							$sms=new smsenvoi();
							$sms->debug=true;
							$sms->sendSMS($tel,html_entity_decode(strip_tags($cat['description'])));
						}
						
					}
				}
			}
			//---------------------------------------------------------------------------
			$my->req('UPDATE ttre_achat_devis SET statut_valid_admin="-2" WHERE id='.$_GET['id']);
			rediriger('?contenu=devis_admin_ajouter&valider=ok');exit;
			break;*/
		/*case 'detail' :
			$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
			if ( isset($_POST['modif_stat_comm']) )
			{
				if ( $user['profil']==2 )
				{
					$pbb=0;$stat_ajout_zone=0;
					if ( $_POST['pb']==1 ) { $pbb='1|'.$_POST['pb1']; $stat_ajout_zone=0; }
					elseif ( $_POST['pb']==2 ) { $pbb='2|'.$_POST['pb2']; $stat_ajout_zone=0; }
					elseif ( $_POST['pb']==3 ) { $pbb='3|'; $stat_ajout_zone=1; }
					elseif ( $_POST['pb']==4 ) { $pbb='4|'; $stat_ajout_zone=1; }
					elseif ( $_POST['pb']==5 ) { $pbb='5|'; $stat_ajout_zone=1; }
					elseif ( $_POST['pb']==6 ) { $pbb='6|'.$_POST['pb3']; $stat_ajout_zone=0; }
					$req = $my->req('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
					if ( $my->num($req)==0 )
						$my->req('INSERT INTO ttre_achat_devis_suite VALUES("","'.$_GET['id'].'","'.$pbb.'","'.$stat_ajout_zone.'")');
					else
						$my->req('UPDATE ttre_achat_devis_suite SET stat_devis_attente="'.$pbb.'" , stat_ajout_zone="'.$stat_ajout_zone.'" WHERE id_devis='.$_GET['id']);
				}
				
				if ( !empty($_POST['commentaire']) )
					$my->req('INSERT INTO ttre_achat_devis_commentaire VALUES("","'.$_GET['id'].'","'.$_SESSION['id_user'].'","'.time().'","'.$my->net_textarea($_POST['commentaire']).'")');
				//rediriger('?contenu=devis_admin_ajouter&action=detail&id='.$_GET['id'].'&modifier=ok');exit;
				rediriger('?contenu=devis_admin_ajouter&modifier=ok');exit;
			}
			if ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
			$detail='';
			$res=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			
			$temp=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
			$num_voie = strtoupper(html_entity_decode($temp['num_voie']));
			$num_appart = ucfirst(html_entity_decode($temp['num_appart']));
			$batiment = ucfirst(html_entity_decode($temp['batiment']));
			$code_postal = $temp['code_postal'];
			$res_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$temp['ville'].'" ');
			$ville = ucfirst(html_entity_decode($res_ville['ville_nom_reel']));
			$pays = ucfirst(html_entity_decode($temp['pays']));
			
			$reso = $my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
			$reso_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id="'.$reso['ville'].'" ');
			
			$detail.='
				<ul id="compte_details_com" class="livraison">
					<li>
						<h4>Informations générales</h4>
						<dl>
							<dd>Date Devis : '.date("d-m-Y",$res['date_ajout']).'</dd>
							<dd>Référence : '.$res['reference'].'</dd>
						</dl>									
					</li>
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
					<li>
						<h4>Informations de client particulier</h4>
						<dl>
							<dd>'.ucfirst(html_entity_decode($reso['civ'])).' '.ucfirst(html_entity_decode($reso['nom'])).' '.ucfirst(html_entity_decode($reso['prenom'])).'</dd>
							<dd>'.html_entity_decode($reso['telephone']).' - '.html_entity_decode($reso['email']).'</dd>
							<dd>Numéro et voie : '.html_entity_decode($reso['num_voie']).'</dd>
							<dd>N° d\'appartement, Etage, Escalier : '.html_entity_decode($reso['num_appart']).'</dd>
							<dd>Bâtiment, Résidence, Entrée : '.html_entity_decode($reso['batiment']).'</dd>
							<dd>'.html_entity_decode($reso['code_postal']).' '.html_entity_decode($reso_ville['ville_nom_reel']).'</dd>
							<dd>'.html_entity_decode($reso['pays']).'</dd>
						</dl>
					</li>
					<li></li>
				</ul>
				<div id="espace_compte">
					<table class="tpl_table_defaut" cellpadding="0" cellspacing="0">
						<tr class="entete">
							<td>Désignation</td>														
						</tr>	
					 ';
			$nom_cat='';
			$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$_GET['id'].' ORDER BY ordre_categ ASC ');
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
			$req_f = $my->req('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id_devis='.$_GET['id'].' ');
			if ( $my->num($req_f)>0 )
			{
				$detail.='<p><br /> Fichiers à télécharger : ';
				while ( $res_f=$my->arr($req_f) )
				{
					$detail.='<a target="_blanc" href="../upload/devis/'.$res_f['fichier'].'">'.$res_f['fichier'].'</a> - ';
				}
				$detail.='</p>';
			}
			$formsuitezone='';

			if ( $user['profil']==2 )
			{		
				$pb1='';$pb2='';$pb3='';$pb4='';$pb5='';$pb6='';$d1='';$d2='';$d3='';
				$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
				list($p,$d) = split('[|]',$respb['stat_devis_attente']);
				if ( $p==1 ) { $pb1='checked="checked"'; $d1=$d; }
				elseif ( $p==2 ) { $pb2='checked="checked"'; $d2=$d; }
				elseif ( $p==3 ) { $pb3='checked="checked"'; }
				elseif ( $p==4 ) { $pb4='checked="checked"'; }
				elseif ( $p==5 ) { $pb5='checked="checked"'; }
				elseif ( $p==6 ) { $pb6='checked="checked"'; $d3=$d; }
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
				$formsuitezone='
						<p><br />Pb devis :<br />
							<input type="radio" name="pb" '.$pb1.' value="1" >RDV pris le <input class="datepicker" name="pb1" type="text" value="'.$d1.'" /><br />
							<input type="radio" name="pb" '.$pb2.' value="2" >A rappeler verifiez à la date <input class="datepicker" name="pb2" type="text" value="'.$d2.'" /> <br />
							<input type="radio" name="pb" '.$pb3.' value="3" >Travaux fini<br />
							<input type="radio" name="pb" '.$pb4.' value="4" >Faux numéro<br />
							<input type="radio" name="pb" '.$pb5.' value="5" >Déjà trouvé un artisan<br />
							<input type="radio" name="pb" '.$pb6.' value="6" >autres <textarea name="pb3" type="text" >'.$d3.'</textarea><br /><br /><br />
						</p>			
					  ';
			}
			
			$touscom='';
			$reqComm = $my->req('SELECT * FROM ttre_achat_devis_commentaire WHERE id_devis='.$_GET['id'].' ORDER BY date ASC');
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
			
			echo '
					<div id="espace_compte">'.$detail.'</div>
					<form method="POST" action="?contenu=devis_admin_ajouter&action=detail&id='.$_GET['id'].'" enctype="multipart/form-data" >
						'.$formsuitezone.'	
						<p>Commentaire devis : 
							'.$touscom.'	
						<br /> Ajouter commentaire : <textarea name="commentaire" style="width:80%;height:150px;" ></textarea><br /><br />
						</p>
						<p><input type="submit" value="Modifier" name="modif_stat_comm" style="margin:0 0 0 110px;"/></p>
					</form>		
				';
			break;*/
	}
}
else
{
	echo '<h1>Archiver : Devis pas encore vu</h1>';
	
	
	$tabCat[]='';
	$rq=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
	while ( $rs=$my->arr($rq) ) $tabCat[$rs['id']]=$rs['titre'];
	$tabDep[]='';
	$rq=$my->req('SELECT * FROM ttre_departement_france ORDER BY departement_nom ASC ');
	while ( $rs=$my->arr($rq) ) $tabDep[$rs['departement_id']]=$rs['departement_nom'];
	$tabUse[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=3  ');
	while ( $rs=$my->arr($rq) ) $tabUse[$rs['id_user']]=$rs['nom'];
	$tabUseZo[]='';
	$rq=$my->req('SELECT * FROM ttre_users WHERE profil=2  ');
	while ( $rs=$my->arr($rq) ) $tabUseZo[$rs['id_user']]=$rs['nom'];
	
	if ( isset($_POST['cat']) && !empty($_POST['cat']) ) $cat=$_POST['cat']; else $cat=0;
	if ( isset($_POST['dep']) && !empty($_POST['dep']) ) $dep=$_POST['dep']; else $dep=0;
	if ( isset($_POST['use']) && !empty($_POST['use']) ) $use=$_POST['use']; else $use=0;
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
	if ( $use!=0 ) $where_user=' AND AD.nbr_estimation='.$use.' '; else $where_user='';
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
	$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_user'].'"');
	
	$form = new formulaire('modele_1','?contenu=devis_admin_ajouter_archifier','','','','sub','txt','','txt_obl','lab_obl');
	$form->select_cu('Catégorie','cat',$tabCat,$cat);
	$form->select_cu('Département','dep',$tabDep,$dep);
	if ( $user['profil']!=3 ) $form->select_cu('User ajout','use',$tabUse,$use);
	$form->select_cu('User zone','use_zo',$tabUseZo,$use_zo);
	$form->vide('<tr><td colspan="2">
				Date de debut : <input class="datepicker" type="text" name="ddb" value="'.$ddb.'" />
				Date de fin : <input value="'.$dfn.'" name="dfn" class="datepicker" type="text" />
				</td></tr>');
	$form->afficher1('Rechercher');
		
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce devis a bien été ajouté.</p></div>';
	elseif ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	elseif ( isset($_GET['valider']) ) echo '<div class="success"><p>Ce devis a bien été validé.</p></div>';
	
	//echo '<p>Pour ajouter un autre devis, cliquer <a href="?contenu=devis_admin_ajouter&action=ajouter">ICI</a></p>';
	
		//echo '<p>Pour ajouter un autre devis, cliquer <a href="?contenu=devis_admin_ajouter&action=ajouter">ICI</a></p>';
		if ( $dep==0 && $cat==0 )
		{
			$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD
								WHERE
									AD.statut_valid_admin=-1
									AND AD.stat_suppr=1
									'.$where_user.'
									'.$where_date.'
								ORDER BY AD.id DESC');
		}
		elseif ( $dep==0 && $cat!=0 )
		{
			$req = $my->req('SELECT AD.id as idad
									FROM
										ttre_achat_devis AD ,
										ttre_achat_devis_details ADS
									WHERE
										AD.id=ADS.id_devis
										'.$where_user.'
										'.$where_date.'
										AND ADS.id_categ='.$cat.'
										AND AD.stat_suppr=1
										AND AD.statut_valid_admin=-1
									ORDER BY AD.id DESC');
		}
		elseif ( $dep!=0 && $cat==0 )
		{
			$req = $my->req('SELECT AD.id as idad
									FROM
										ttre_achat_devis AD ,
										ttre_client_part_adresses CPA ,
										ttre_villes_france VF ,
										ttre_departement_france DF
									WHERE
										DF.departement_id='.$dep.'
										'.$where_user.'
										'.$where_date.'
										AND DF.departement_code=VF.ville_departement
										AND VF.ville_id=CPA.ville
										AND CPA.id=AD.id_adresse
										AND AD.stat_suppr=1
										AND AD.statut_valid_admin=-1
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
										ttre_achat_devis_details ADS
									WHERE
										DF.departement_id='.$dep.'
										'.$where_user.'
										'.$where_date.'
										AND DF.departement_code=VF.ville_departement
										AND VF.ville_id=CPA.ville
										AND CPA.id=AD.id_adresse
										AND AD.id=ADS.id_devis
										AND ADS.id_categ='.$cat.'
										AND AD.stat_suppr=1
										AND AD.statut_valid_admin=-1
									ORDER BY AD.id DESC');
		}
		//$req = $my->req('SELECT * FROM ttre_achat_devis WHERE statut_valid_admin=-1 ORDER BY id DESC ');
		if ( $my->num($req)>0 )
		{
			echo'
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Date / Ref</td>
								<td>Client</td>
								<td>User</td>
								<td>Ville / Département</td>
								<td>Prix</td>
								<td class="bouton">Modifier</td>
								<td class="bouton">Supprimer</td>
							</tr>
						</thead>
						<tbody> 
				';
			while ( $ress=$my->arr($req) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
				
				$rs1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
				$rs2=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$rs1['ville'].' ');
				$rs3=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$rs2['ville_departement'].' ');
				$rq1=$my->req('SELECT * FROM ttre_users_zones WHERE id_user='.$use_zo.' AND zone='.$rs3['departement_id'].' ');
				if ( $my->num($rq1)>0 || $use_zo==0 )
				{
					
					$res_suite = $my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$ress['idad'].' ');
					
					if ( $res_suite['stat_ajout_zone']==1 ) $affich=0;
					elseif ( $res_suite['stat_ajout_zone']==2 ) $affich=0;
					elseif ( $res_suite['stat_ajout_zone']==0 )
					{
						if ( $res_suite['stat_devis_attente']==0 ) $affich=1;
						else $affich=0;
					}
					
					if ( $affich==1 )
					{
						$u =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$res['nbr_estimation'].'"');
						$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
						$vd='';
						$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
						$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
						$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
						$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
						/*$respb=$my->req_arr('SELECT * FROM ttre_achat_devis_suite WHERE id_devis='.$res['id'].' ');$pb='';$p='';$d='';
						list($p,$d) = split('[|]',$respb['stat_devis_attente']);
						if ( $p==1 ) { $pb='Rdv pris le '.$d; }
						elseif ( $p==2 ) { $pb='A rappeler verifiez à la date '.$d; }
						elseif ( $p==3 ) { $pb='Travaux fini'; }
						elseif ( $p==4 ) { $pb='Faut numéro'; }
						elseif ( $p==5 ) { $pb='Déjà trouvé un artisan'; }
						elseif ( $p==6 ) { $pb='Autre ( '.$d.' )'; }*/
						echo'
							<tr>
								<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
								<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
								<td>'.$u['nom'].'</td>
								<td>'.$vd.'</td>		
								<td>'.number_format($res['prix_achat'],2).' € </td>	
	
								<td class="bouton">
									<a href="?contenu=devis_admin_ajouter_archifier&action=modifier&id='.$res['id'].'" target="_blanc">
									<img src="img/interface/btn_modifier.png" alt="Modifier" /></a>
								</td>
									
								<td class="bouton">
									<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce devis ?\')) 
									{window.location=\'?contenu=devis_admin_ajouter_archifier&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
									<img src="img/icone_delete.png" alt="Supprimer" /></a>
								</td>
							</tr>
							';
							/*	<td class="bouton">
									'.$pb.'<br /><a href="?contenu=devis_admin_ajouter&action=valider&id='.$res['id'].'" title="Devis pas encore validé" >
									<img src="img/interface/icone_nok.jpeg" alt="Valider"/></a>
								</td>*/		
					}
				}	
			}
			echo'
					</tbody> 
					</table>
				';
		}
		else
		{
			echo '<p>Pas devis ..</p>';
		}
}
?>
<link rel="stylesheet" type="text/css" href="../style_boutique.css" /> 
<script type="text/javascript">
$(document).ready(function() 
{
	$('input[name="radadd"]').change(function ()
	{
		if ( $('input[name="radadd"]:checked').val()==0 ) $('#adresse_chantier').css('display','block');
		else $('#adresse_chantier').css('display','none');
	});
	$('input[name="cpc"]').change(function ()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxVille.php",
			 data: "cp="+$('input[name="cpc"]').val(),
			 success: function(msg)
				{			 
					//alert(msg);
					$('select[name="villec"]').html(msg);
				}
		 });
	});
	$('input[name="cpa"]').change(function ()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxVille.php",
			 data: "cp="+$('input[name="cpa"]').val(),
			 success: function(msg)
				{			 
					//alert(msg);
					$('select[name="villea"]').html(msg);
				}
		 });
	});
	
	/*$('form[name="ajouter"]').submit(function ()
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
	});	*/

	function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
	function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
	                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

	function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
	function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
	                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
    	
});

</script>