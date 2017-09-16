<?php 
$my = new mysql();


// stat_ajout_zone ?
// 0 : affiché sur ajout et zone
// 1 : affiché sur ajout
// 2 : affiché sur admin


//echo 'es'.(int)('5|4y52');








if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouterexel' :
			if ( isset($_POST['ajouter']) )
			{
				$handle = new Upload($_FILES['fichier']);
				if ($handle->uploaded)
				{
					$handle->Process('fichier_exel/');
					if ($handle->processed)
					{
						$fichier_exel  = $handle->file_dst_name ;	          // Destination file name
						$handle-> Clean();                           // Deletes the uploaded file from its temporary location
		
						require_once 'Excel/reader.php';
						$data = new Spreadsheet_Excel_Reader();
						$data->setOutputEncoding('CP1251');
						$data->read('fichier_exel/'.$fichier_exel);
						error_reporting(E_ALL ^ E_NOTICE);
		
		
						for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++)
						{
							$cpc=$data->sheets[0]['cells'][$i][21];
							$villec='';
							$test_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$cpc.' AND ville_nom_reel="'.$data->sheets[0]['cells'][$i][22].'" ');
							if ( $test_ville )$villec=$test_ville['ville_id'];
							
							$my->req("INSERT INTO ttre_client_part VALUES('',
										'".$my->net_input('--')."',
										'".$my->net_input('--')."',
										'".$my->net_input('--')."',
										'".$my->net_input($data->sheets[0]['cells'][$i][13])."',
										'".$data->sheets[0]['cells'][$i][14]."',
										'".$data->sheets[0]['cells'][$i][15]."',
										'".$my->net_input($data->sheets[0]['cells'][$i][17])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][16])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][18])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][19])."',
										'".$my->net_input($data->sheets[0]['cells'][$i][20])."',
										'".$my->net_input($cpc)."',
										'".$my->net_input($villec)."',
										'France',
										'".$my->net_input('--')."',
										'".$my->net_input('--')."',
										'--',
										'0',
										'--',
										'-1'
										)");
							$idc=mysql_insert_id();

							
							
							if ( empty($data->sheets[0]['cells'][$i][23]) && empty($data->sheets[0]['cells'][$i][24]) &&
									empty($data->sheets[0]['cells'][$i][25]) && empty($data->sheets[0]['cells'][$i][26]) &&
									empty($data->sheets[0]['cells'][$i][27]) )
							{
								$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
											'".$my->net_input($idc)."',
											'".$my->net_input($data->sheets[0]['cells'][$i][18])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][19])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][20])."',
											'".$my->net_input($cpc)."',
											'".$my->net_input($villec)."',
											'France',
											'1'
											)");
							
								$ida=mysql_insert_id();
							}
							else
							{
								$cpa=$data->sheets[0]['cells'][$i][26];
								$villea='';
								$test_ville=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$cpa.' AND ville_nom_reel="'.$data->sheets[0]['cells'][$i][27].'" ');
								if ( $test_ville )$villea=$test_ville['ville_id'];
									
								$my->req("INSERT INTO ttre_client_part_adresses VALUES('',
											'".$my->net_input($idc)."',
											'".$my->net_input($data->sheets[0]['cells'][$i][23])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][24])."',
											'".$my->net_input($data->sheets[0]['cells'][$i][25])."',
											'".$my->net_input($cpa)."',
											'".$my->net_input($villea)."',
											'France',
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
									'".$data->sheets[0]['cells'][$i][28]."',
									'".$data->sheets[0]['cells'][$i][29]."',
									'0',
									'0',
									'0',
									'0',
									'0',
									'0'
									)");
							$id_devis = mysql_insert_id();
									
							if ( !empty($data->sheets[0]['cells'][$i][1]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','0','1','".$my->net('Maçonnerie')."','".$my->net_textarea($data->sheets[0]['cells'][$i][1])."')");
							if ( !empty($data->sheets[0]['cells'][$i][2]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','1','2','".$my->net('Menuiserie')."','".$my->net_textarea($data->sheets[0]['cells'][$i][2])."')");
							if ( !empty($data->sheets[0]['cells'][$i][3]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','2','3','".$my->net('Revêtement de sol')."','".$my->net_textarea($data->sheets[0]['cells'][$i][3])."')");
							if ( !empty($data->sheets[0]['cells'][$i][4]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','3','4','".$my->net('Revêtement de murs et plafond')."','".$my->net_textarea($data->sheets[0]['cells'][$i][4])."')");
							if ( !empty($data->sheets[0]['cells'][$i][5]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','4','5','".$my->net('Plomberie')."','".$my->net_textarea($data->sheets[0]['cells'][$i][5])."')");
							if ( !empty($data->sheets[0]['cells'][$i][6]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','5','6','".$my->net('Electricité et enegie renouvlable')."','".$my->net_textarea($data->sheets[0]['cells'][$i][6])."')");
							if ( !empty($data->sheets[0]['cells'][$i][7]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','56','180','".$my->net('toiture')."','".$my->net_textarea($data->sheets[0]['cells'][$i][7])."')");
							if ( !empty($data->sheets[0]['cells'][$i][8]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','57','181','".$my->net('chauffage')."','".$my->net_textarea($data->sheets[0]['cells'][$i][8])."')");
							if ( !empty($data->sheets[0]['cells'][$i][9]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','58','182','".$my->net('piscine')."','".$my->net_textarea($data->sheets[0]['cells'][$i][9])."')");
							if ( !empty($data->sheets[0]['cells'][$i][10]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','59','183','".$my->net('isolation')."','".$my->net_textarea($data->sheets[0]['cells'][$i][10])."')");
							if ( !empty($data->sheets[0]['cells'][$i][11]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','60','184','".$my->net('veranda')."','".$my->net_textarea($data->sheets[0]['cells'][$i][11])."')");
							if ( !empty($data->sheets[0]['cells'][$i][12]) ) $my->req("INSERT INTO ttre_achat_devis_details VALUES('','".$id_devis."','61','185','".$my->net('Facade')."','".$my->net_textarea($data->sheets[0]['cells'][$i][12])."')");
		
						}//for
					}//$handle processed
				}//$handle uploaded
			rediriger('?contenu=devisa_admin_ajout&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','','<h2 class="titre_niv2">Ajouter Fichier Exel :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<tr><td colspan="2">Template ( télécharger et le remplir ) : <a href="_template.xls" target="_blanc">_template.xls</a></td></tr>');
				$form->photo('Fichier','fichier');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=devisa_admin_ajout">Retour</a></p>';
			}
			break;
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$my->req("INSERT INTO ttre_client_part VALUES('',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'".$my->net_input('--')."',
								'".$my->net_input($_POST["civ"])."',
								'".$_POST["nom"]."',
								'".$_POST["prenom"]."',
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
								'".$_POST["nbr"]."',
								'".$_POST["prix"]."',
								'0',
								'0',
								'0',
								'0',
								'0',
								'0'
								)");
				$id_devis = mysql_insert_id();
				
				$my->req('INSERT INTO ttre_achat_devis_suite VALUES("","'.$id_devis.'","0","0")');
				
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
				rediriger('?contenu=devisa_admin_ajout&ajouter=ok');
			}
			else
			{
				$form = new formulaire('modele_1','?contenu=devisa_admin_ajout&action=ajouter','<h2 class="titre_niv2">Ajouter Devis :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				
				$form->vide('<tr><td colspan="2">Détail de devis :</td></tr>');
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC ');
				while ( $res=$my->arr($req) )
				{
					$form->textarea($res['titre'],'cat_'.$res['id'].'');
				}
				$form->text('Nombre de vente','nbr','',1);
				$form->text('Prix','prix','',1);
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
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$info_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
				$my->req('UPDATE ttre_client_part SET
									civ					=	"'.$my->net_input($_POST['civ']).'" ,
									nom					=	"'.$_POST['nom'].'" ,
									prenom				=	"'.$_POST['prenom'].'" ,
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
				
				$my->req('UPDATE ttre_achat_devis SET prix_achat="'.$_POST['prix'].'", nbr_estimation="'.$_POST['nbr'].'"  WHERE id='.$_GET['id']);
				
				rediriger('?contenu=devisa_admin_ajout&modifier=ok');
			}
			else
			{
				if ( isset($_GET['supprfichier']) )
				{
					$temp=$my->req_arr('SELECT * FROM ttre_achat_devis_fichier_suite WHERE id="'.$_GET['supprfichier'].'"');
					@unlink('../upload/devis/'.$temp['fichier']);
					$my->req('DELETE FROM ttre_achat_devis_fichier_suite WHERE id = "'.$_GET['supprfichier'].'" ' );
					rediriger('?contenu=devisa_admin_ajout&action=modifier&id='.$_GET['id'].'&fichiersuppr=ok');
				}
				
				if ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
				if ( isset($_GET['fichiersuppr']) ) echo '<div class="success"><p>Cette fichier a bien été supprimée.</p></div>';
				$info_devis=$my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
				
				$form = new formulaire('modele_1','?contenu=devisa_admin_ajout&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier Devis :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
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
				$form->text('Nombre de vente','nbr','',1,$info_devis['nbr_estimation']);
				$form->text('Prix','prix','onKeyPress="return scanFTouche(event)"',1,$info_devis['prix_achat']);
				
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
							            <td><a href="?contenu=devisa_admin_ajout&action=modifier&id='.$_GET['id'].'&supprfichier='.$res_fic['id'].'">Supprimer</a></td>
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
				
				$form->vide('<tr><td><br /><br /></td><td></td></tr>');
				
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=devisa_admin_ajout">Retour</a></p>';
				
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
			rediriger('?contenu=devisa_admin_ajout&supprimer=ok');
			break;	
		case 'changer' :
			$info_devis = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$_GET['id'].' ');
			$my->req('UPDATE ttre_achat_devis SET
						nbr_estimation			=	"'.$info_devis['stat_suppr'].'"	,
						prix_achat				=	"'.$info_devis['user_zone'].'"	,
						note_devis				=	"0"	,
						user_zone				=	"0"	,
						stat_suppr				=	"0"	,
						statut_valid_admin		=	"-1"
								WHERE id='.$_GET['id']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro WHERE id_devis='.$_GET['id'].' ');
			$req=$my->req('SELECT * FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			while ( $res=$my->arr($req) ) @unlink('../upload/devis_client_pro/'.$res['fichier']);
			$my->req('DELETE FROM ttre_achat_devis_client_pro_suite WHERE id_devis='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_achat_devis_suite WHERE id_devis='.$_GET['id'].' ');
			rediriger('?contenu=devisa_admin_ajout&changer=ok');exit;
			break;			
	}
}
else
{
	echo '<h1>Ajouter devis</h1>';
		
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce devis a bien été ajouté.</p></div>';
	elseif ( isset($_GET['modifier']) ) echo '<div class="success"><p>Ce devis a bien été modifié.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce devis a bien été supprimé.</p></div>';
	elseif ( isset($_GET['changer']) ) echo '<div class="success"><p>Ce devis a bien été changé.</p></div>';
	
	echo '<p>Pour ajouter un autre devis, cliquer <a href="?contenu=devisa_admin_ajout&action=ajouter">ICI</a></p>';
	echo '<p>Pour ajouter un autre devis à partir d\'un fichier exel , cliquer <a href="?contenu=devisa_admin_ajout&action=ajouterexel">ICI</a></p>';
			$req = $my->req('SELECT AD.id as idad
								FROM
									ttre_achat_devis AD
								WHERE
									AD.statut_valid_admin=0
									AND AD.stat_suppr=0
								ORDER BY AD.id DESC');
		if ( $my->num($req)>0 )
		{
			echo'
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Date / Ref</td>
								<td>Client</td>
								<td>Catégorie</td>
								<td>Ville / Département</td>
								<td>Nombre de vente</td>
								<td>Prix</td>
								<td class="bouton">Modifier</td>
								<td class="bouton"></td>
							</tr>
						</thead>
						<tbody> 
				';
			while ( $ress=$my->arr($req) )
			{
				$res = $my->req_arr('SELECT * FROM ttre_achat_devis WHERE id='.$ress['idad'].' ');
				
				
				$nom_cat='';$nc='';
				$reqq=$my->req('SELECT * FROM ttre_achat_devis_details WHERE id_devis='.$res['id'].' ORDER BY ordre_categ ASC ');
				while ( $ress=$my->arr($reqq) )
				{
					if ( $nom_cat!=$ress['titre_categ'] )
					{
						$nom_cat=$ress['titre_categ'];
						$nc.=$nom_cat.', ';
					}
				}
				
					$tempc=$my->req_arr('SELECT * FROM ttre_client_part WHERE id='.$res['id_client'].' ');
					$vd='';
					$v1=$my->req_arr('SELECT * FROM ttre_client_part_adresses WHERE id='.$res['id_adresse'].' ');
					$v=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_id='.$v1['ville'].' ');
					$d=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_code='.$v['ville_departement'].' ');
					$vd=$v['ville_nom_reel'].' / '.$d['departement_nom'];
					echo'
						<tr>
							<td>'.date('d/m/Y',$res['date_ajout']).' <strong>'.$res['reference'].'</strong></td>
							<td>'.$tempc['nom'].' '.$tempc['prenom'].'</td>
							<td>'.$nc.'</td>		
							<td>'.$vd.'</td>		
							<td>'.$res['nbr_estimation'].'</td>	
							<td>'.number_format($res['prix_achat'],2).' €</td>	
															
							<td class="bouton">
								<a href="?contenu=devisa_admin_ajout&action=modifier&id='.$res['id'].'" target="_blanc">
								<img src="img/interface/btn_modifier.png" alt="Modifier" /></a>
							</td>
							<td class="bouton">
								<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir archiver ce devis ?\')) 
								{window.location=\'?contenu=devisa_admin_ajout&action=supprimer&id='.$res['id'].'\'}" title="Supprimer">
								Supprimer</a>
								<br /><br /><a style="color:red;" href="?contenu=devisa_admin_ajout&action=changer&id='.$res['id'].'" title="Par zone">Changer</a>		
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