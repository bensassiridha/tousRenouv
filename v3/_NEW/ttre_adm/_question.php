<?php 
//echo'<pre>';print_r($_POST);echo'</pre>';

$my = new mysql();
$tab_type=array(0=>'',1=>'Champ Text',2=>'champ Select');
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$my->req('INSERT INTO ttre_questions VALUES("",
										"'.$my->net_input($_POST['label']).'" ,
										"'.$my->net_input($_POST['type']).'" 
										)');
				$idQuest=mysql_insert_id();
				if ( $_POST['type']==2 ) // champ select
				{
					for ( $i=1;$i<=$_POST['nbrOption'];$i++ )
					{
						if ( trim($_POST['option_'.$i.''])!='' )
						{
							$my->req('INSERT INTO ttre_questions_option VALUES("",
											"'.$idQuest.'" ,
											"'.$my->net_input($_POST['option_'.$i.'']).'" 
											)');
						}
					}
				}
				$my->req('INSERT INTO ttre_questions_prix VALUES("",
								"'.$idQuest.'" ,
								"'.$my->net_input($_POST['cat']).'" ,
								"0"
								)');
				for ( $i=1;$i<=$_POST['nbrDomaine'];$i++ )
				{
					if ( $_POST['domaine_'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_domaine='.$_POST['domaine_'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"'.$my->net_input($_POST['domaine_'.$i.'']).'" ,
											"0" ,
											"0" 
											)');
						}
					}
				}
				for ( $i=1;$i<=$_POST['nbrProfession'];$i++ )
				{
					if ( $_POST['profession_'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_profession='.$_POST['profession_'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"0" ,
											"'.$my->net_input($_POST['profession_'.$i.'']).'" ,
											"0" 
											)');
						}
					}
				}
				for ( $i=1;$i<=$_POST['nbrRealisation'];$i++ )
				{
					if ( $_POST['realisation_'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_realisation='.$_POST['realisation_'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"0" ,
											"0" ,
											"'.$my->net_input($_POST['realisation_'.$i.'']).'"
											)');
						}
					}
				}
				rediriger('?contenu=question&ajouter=ok');
			}
			else
			{
				echo '<div id="note"></div>';
				$form = new formulaire('modele_1','?contenu=question&action=ajouter','<h2 class="titre_niv2">Ajouter question :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->text('Label','label','',1);
				$form->select('Type','type',$tab_type,'',1);
				$form->vide('
							<tr id="tr_option" style="display:none;">
								<td>Option :</td>
								<td>
									<input type="hidden" name="nbrOption" id="nbrOption" value="1" >
									<table style="text-align:center;" id="tblOption" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableOption();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableOption();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Option</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><input type="text" class="txt" name="option_1" /></td>
										</tr>
									</table>								
								</td>
							</tr>
							');
				$tab_categorie=array();
				$req_categorie=$my->req('SELECT * FROM ttre_categories WHERE parent_categorie=0 ORDER BY titre_categorie ASC');
				while ( $res_categorie=$my->arr($req_categorie) ) 
				{ 
					$req_sous_categorie=$my->req('SELECT * FROM ttre_categories WHERE parent_categorie='.$res_categorie['id_categorie'].' ORDER BY titre_categorie ASC');
					while ( $res_sous_categorie=$my->arr($req_sous_categorie) ) 
					{
						$tab_categorie[$res_categorie['titre_categorie']][$res_sous_categorie['id_categorie']]=$res_sous_categorie['titre_categorie'];
					}
				}
				$form->selectGroup('Catégorie','cat',$tab_categorie);
				$req_domaine=$my->req('SELECT * FROM ttre_domaines ORDER BY titre_domaine ASC');$option_domaine='';
				while ( $res_domaine=$my->arr($req_domaine) ) { $option_domaine.='<option value="'.$res_domaine['id_domaine'].'">'.$res_domaine['titre_domaine'].'</option>'; }
				$form->vide('
							<tr>
								<td>Domaine :</td>
								<td>
									<input type="hidden" name="nbrDomaine" id="nbrDomaine" value="1" >
									<table style="text-align:center;" id="tblDomaine" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableDomaine();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableDomaine();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Domaine</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><select name="domaine_1"><option value="0"></option>'.$option_domaine.'</select></td>
										</tr>
									</table>								
								</td>
							</tr>
							');		
				$req_profession=$my->req('SELECT * FROM ttre_professions ORDER BY titre_profession ASC');$option_profession='';
				while ( $res_profession=$my->arr($req_profession) ) { $option_profession.='<option value="'.$res_profession['id_profession'].'">'.$res_profession['titre_profession'].'</option>'; }
				$form->vide('
							<tr>
								<td>Profession :</td>
								<td>
									<input type="hidden" name="nbrProfession" id="nbrProfession" value="1" >
									<table style="text-align:center;" id="tblProfession" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableProfession();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableProfession();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Profession</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><select name="profession_1"><option value="0"></option>'.$option_profession.'</select></td>
										</tr>
									</table>								
								</td>
							</tr>
							');	
				$req_realisation=$my->req('SELECT * FROM ttre_realisations ORDER BY titre_realisation ASC');$option_realisation='';
				while ( $res_realisation=$my->arr($req_realisation) ) { $option_realisation.='<option value="'.$res_realisation['id_realisation'].'">'.$res_realisation['titre_realisation'].'</option>'; }
				$form->vide('
							<tr>
								<td>Réalisation :</td>
								<td>
									<input type="hidden" name="nbrRealisation" id="nbrRealisation" value="1" >
									<table style="text-align:center;" id="tblRealisation" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableRealisation();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableRealisation();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Réalisation</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><select name="realisation_1"><option value="0"></option>'.$option_realisation.'</select></td>
										</tr>
									</table>								
								</td>
							</tr>
							');
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=question">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$idQuest=$_GET['id'];
				$my->req('UPDATE ttre_questions SET 
									label_question 		=	"'.$my->net_input($_POST['label']).'" ,
									type_question  		=	"'.$my->net_input($_POST['type']).'" 
								WHERE id_question = '.$idQuest.' ');	

				if ( $_POST['type']==2 ) // champ select
				{
					$req = $my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$idQuest.' ORDER BY id_option ASC');	
					if ( $my->num($req)>0 )				  
					{
						$i=0;
						while ( $res=$my->arr($req) )
						{
							$i++;
							if ( !empty($_POST['option'.$i]) )
								$my->req('UPDATE ttre_questions_option SET option_option="'.$my->net_input($_POST['option'.$i]).'" WHERE id_option='.$res['id_option'].'');                  
						}
					}
					for ( $i=1;$i<=$_POST['nbrOption'];$i++ )
					{
						if ( trim($_POST['option_'.$i.''])!='' )
						{
							$my->req('INSERT INTO ttre_questions_option VALUES("",
											"'.$idQuest.'" ,
											"'.$my->net_input($_POST['option_'.$i.'']).'" 
											)');
						}
					}
				}
				else $my->req('DELETE FROM ttre_questions_option WHERE id_question='.$idQuest.' ');
				$my->req('DELETE FROM ttre_questions_prix WHERE id_question='.$idQuest.' ');
				$my->req('INSERT INTO ttre_questions_prix VALUES("",
								"'.$idQuest.'" ,
								"'.$my->net_input($_POST['cat']).'" ,
								"0"
								)');
				$req = $my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_domaine!=0 ORDER BY id_qd ASC');	
				$nbr=$my->num($req);
				$my->req('DELETE FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_domaine!=0 ');
				for ( $i=1;$i<=$nbr;$i++ )
				{
					if ( $_POST['domaine'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_domaine='.$_POST['domaine'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"'.$my->net_input($_POST['domaine'.$i.'']).'" ,
											"0" ,
											"0" 
											)');
						}
					}
				}
				for ( $i=1;$i<=$_POST['nbrDomaine'];$i++ )
				{
					if ( $_POST['domaine_'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_domaine='.$_POST['domaine_'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"'.$my->net_input($_POST['domaine_'.$i.'']).'" ,
											"0" ,
											"0" 
											)');
						}
					}
				}
				$req = $my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_profession!=0 ORDER BY id_qd ASC');	
				$nbr=$my->num($req);
				$my->req('DELETE FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_profession!=0 ');
				for ( $i=1;$i<=$nbr;$i++ )
				{
					if ( $_POST['profession'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_profession='.$_POST['profession'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"0" ,
											"'.$my->net_input($_POST['profession'.$i.'']).'" ,
											"0" 
											)');
						}
					}
				}
				for ( $i=1;$i<=$_POST['nbrProfession'];$i++ )
				{
					if ( $_POST['profession_'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_profession='.$_POST['profession_'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"0" ,
											"'.$my->net_input($_POST['profession_'.$i.'']).'" ,
											"0" 
											)');
						}
					}
				}
				$req = $my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_realisation!=0 ORDER BY id_qd ASC');	
				$nbr=$my->num($req);
				$my->req('DELETE FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_realisation!=0 ');
				for ( $i=1;$i<=$nbr;$i++ )
				{
					if ( $_POST['realisation'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_realisation='.$_POST['realisation'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"0" ,
											"0" ,
											"'.$my->net_input($_POST['realisation'.$i.'']).'"
											)');
						}
					}
				}
				for ( $i=1;$i<=$_POST['nbrRealisation'];$i++ )
				{
					if ( $_POST['realisation_'.$i.'']!=0 )
					{
						$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$idQuest.' AND id_realisation='.$_POST['realisation_'.$i.''].' ');
						if ( $my->num($temp)==0 )
						{
							$my->req('INSERT INTO ttre_questions_devis VALUES("",
											"'.$idQuest.'" ,
											"0" ,
											"0" ,
											"'.$my->net_input($_POST['realisation_'.$i.'']).'"
											)');
						}
					}
				}
				
				rediriger('?contenu=question&action=modifier&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if (isset($_GET['supprOption'] ))
				{
					$my->req ('DELETE FROM ttre_questions_option WHERE id_option='.$_GET['supprOption'].' ');
					rediriger('?contenu=question&action=modifier&id='.$_GET['id'].'&optionSuppr=ok');
				}
				if (isset($_GET['supprLiaison'] ))
				{
					$my->req ('DELETE FROM ttre_questions_devis WHERE id_qd='.$_GET['supprLiaison'].' ');
					rediriger('?contenu=question&action=modifier&id='.$_GET['id'].'&liaisonSuppr=ok');
				}
				
				if ( isset($_GET['modifier']) ) echo '<div id="note" class="success"><p>Ce question a bien été modifié.</p></div>';
				elseif ( isset($_GET['optionSuppr']) ) echo '<div id="note" class="success"><p>Cette option a bien été supprimée.</p></div>';
				elseif ( isset($_GET['liaisonSuppr']) ) echo '<div id="note" class="success"><p>Cette liaison a bien été supprimée.</p></div>';
				else echo '<div id="note"></div>';
				$temp = $my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$_GET['id'].' ');
				$form = new formulaire('modele_1','?contenu=question&action=modifier&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier question :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->text('Label','label','',1,$temp['label_question']);
				$form->select_cu('Type','type',$tab_type,$temp['type_question'],'',1);
				if ( $temp['type_question']==2 ) 
				{
					$tr_style='';
					$tab_option='';
					$req=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$_GET['id'].' ORDER BY id_option ASC');
					if ( $my->num($req)>0 )
					{ 
						$tab_option.='
										<table >
											<tr style="background-color:#D3DCE3;text-align: center;">
												<th><label>Option</label></th>
												<th><label>Supprimer</label></th>
											</tr>
									 ';
						$i=0;
						while ( $res=$my->arr($req) )
						{
							 $i++ ;
							 $tab_option.='
											<tr style="background-color:#E5E5E5;">
												<td><input type="text" name="option'.$i.'" value="'.$res['option_option'].'"/></td> 
												<td>							
													<a class="lien_1" href="#" onclick="
														if(confirm(\'Etes vous certain de vouloir supprimer cette option ?\')) 
														{window.location=\'?contenu=question&action=modifier&supprOption='.$res['id_option'].'&id='.$_GET['id'].'\'}">
														Supprimer
													</a>
												</td>
											 </tr>
										  ';
						}
						$tab_option.='</table>';
					}			
				}
				else
				{
					$tr_style='style="display:none;"';
					$tab_option='';
				}
				$form->vide('
							<tr id="tr_option" '.$tr_style.' >
								<td>Option :</td>
								<td>
									'.$tab_option.'
									<input type="hidden" name="nbrOption" id="nbrOption" value="1" >
									<table style="text-align:center;" id="tblOption" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableOption();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableOption();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Option</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><input type="text" class="txt" name="option_1" /></td>
										</tr>
									</table>								
								</td>
							</tr>
							');
				$tab_categorie=array();
				$req_categorie=$my->req('SELECT * FROM ttre_categories WHERE parent_categorie=0 ORDER BY titre_categorie ASC');
				while ( $res_categorie=$my->arr($req_categorie) ) 
				{ 
					$req_sous_categorie=$my->req('SELECT * FROM ttre_categories WHERE parent_categorie='.$res_categorie['id_categorie'].' ORDER BY titre_categorie ASC');
					while ( $res_sous_categorie=$my->arr($req_sous_categorie) ) 
					{
						$tab_categorie[$res_categorie['titre_categorie']][$res_sous_categorie['id_categorie']]=$res_sous_categorie['titre_categorie'];
					}
				}
				$tempp=$my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_question='.$_GET['id'].' ');
				$form->selectGroup('Catégorie','cat',$tab_categorie,$tempp['id_categorie']);
				$tab_domaine='';
				$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$_GET['id'].' AND id_domaine!=0 ORDER BY id_qd ASC');
				if ( $my->num($req)>0 )
				{ 
					$tab_domaine.='
									<table >
										<tr style="background-color:#D3DCE3;text-align: center;">
											<th><label>Domaine</label></th>
											<th><label>Supprimer</label></th>
										</tr>
								 ';
					$i=0;
					while ( $res=$my->arr($req) )
					{
						$i++ ;
						$req_domaine=$my->req('SELECT * FROM ttre_domaines ORDER BY titre_domaine ASC');$option_domaine='';
						while ( $res_domaine=$my->arr($req_domaine) )
						{ 
							if ( $res_domaine['id_domaine']==$res['id_domaine'] ) $sel='selected="selected"'; else $sel='';
							$option_domaine.='<option value="'.$res_domaine['id_domaine'].'" '.$sel.' >'.$res_domaine['titre_domaine'].'</option>'; 
						}
						$tab_domaine.='
										<tr style="background-color:#E5E5E5;">
											<td><select name="domaine'.$i.'"><option value="0"></option>'.$option_domaine.'</select></td> 
											<td>							
												<a class="lien_1" href="#" onclick="
													if(confirm(\'Etes vous certain de vouloir supprimer cette liaison ?\')) 
													{window.location=\'?contenu=question&action=modifier&supprLiaison='.$res['id_qd'].'&id='.$_GET['id'].'\'}">
													Supprimer
												</a>
											</td>
										 </tr>
									  ';
					}
					$tab_domaine.='</table>';
				}	
				$req_domaine=$my->req('SELECT * FROM ttre_domaines ORDER BY titre_domaine ASC');$option_domaine='';
				while ( $res_domaine=$my->arr($req_domaine) ) { $option_domaine.='<option value="'.$res_domaine['id_domaine'].'">'.$res_domaine['titre_domaine'].'</option>'; }
				$form->vide('
							<tr>
								<td>Domaine :</td>
								<td>
									'.$tab_domaine.'
									<input type="hidden" name="nbrDomaine" id="nbrDomaine" value="1" >
									<table style="text-align:center;" id="tblDomaine" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableDomaine();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableDomaine();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Domaine</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><select name="domaine_1"><option value="0"></option>'.$option_domaine.'</select></td>
										</tr>
									</table>								
								</td>
							</tr>
							');	
				$tab_profession='';
				$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$_GET['id'].' AND id_profession!=0 ORDER BY id_qd ASC');
				if ( $my->num($req)>0 )
				{ 
					$tab_profession.='
									<table >
										<tr style="background-color:#D3DCE3;text-align: center;">
											<th><label>Profession</label></th>
											<th><label>Supprimer</label></th>
										</tr>
								 ';
					$i=0;
					while ( $res=$my->arr($req) )
					{
						$i++ ;
						$req_profession=$my->req('SELECT * FROM ttre_professions ORDER BY titre_profession ASC');$option_profession='';
						while ( $res_profession=$my->arr($req_profession) )
						{ 
							if ( $res_profession['id_profession']==$res['id_profession'] ) $sel='selected="selected"'; else $sel='';
							$option_profession.='<option value="'.$res_profession['id_profession'].'" '.$sel.' >'.$res_profession['titre_profession'].'</option>'; 
						}
						$tab_profession.='
										<tr style="background-color:#E5E5E5;">
											<td><select name="profession'.$i.'"><option value="0"></option>'.$option_profession.'</select></td> 
											<td>							
												<a class="lien_1" href="#" onclick="
													if(confirm(\'Etes vous certain de vouloir supprimer cette liaison ?\')) 
													{window.location=\'?contenu=question&action=modifier&supprLiaison='.$res['id_qd'].'&id='.$_GET['id'].'\'}">
													Supprimer
												</a>
											</td>
										 </tr>
									  ';
					}
					$tab_profession.='</table>';
				}		
				$req_profession=$my->req('SELECT * FROM ttre_professions ORDER BY titre_profession ASC');$option_profession='';
				while ( $res_profession=$my->arr($req_profession) ) { $option_profession.='<option value="'.$res_profession['id_profession'].'">'.$res_profession['titre_profession'].'</option>'; }
				$form->vide('
							<tr>
								<td>Profession :</td>
								<td>
									'.$tab_profession.'
									<input type="hidden" name="nbrProfession" id="nbrProfession" value="1" >
									<table style="text-align:center;" id="tblProfession" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableProfession();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableProfession();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Profession</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><select name="profession_1"><option value="0"></option>'.$option_profession.'</select></td>
										</tr>
									</table>								
								</td>
							</tr>
							');	
				$tab_realisation='';
				$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_question='.$_GET['id'].' AND id_realisation!=0 ORDER BY id_qd ASC');
				if ( $my->num($req)>0 )
				{ 
					$tab_realisation.='
									<table >
										<tr style="background-color:#D3DCE3;text-align: center;">
											<th><label>Réalisation</label></th>
											<th><label>Supprimer</label></th>
										</tr>
								 ';
					$i=0;
					while ( $res=$my->arr($req) )
					{
						$i++ ;
						$req_realisation=$my->req('SELECT * FROM ttre_realisations ORDER BY titre_realisation ASC');$option_realisation='';
						while ( $res_realisation=$my->arr($req_realisation) )
						{ 
							if ( $res_realisation['id_realisation']==$res['id_realisation'] ) $sel='selected="selected"'; else $sel='';
							$option_realisation.='<option value="'.$res_realisation['id_realisation'].'" '.$sel.' >'.$res_realisation['titre_realisation'].'</option>'; 
						}
						$tab_realisation.='
										<tr style="background-color:#E5E5E5;">
											<td><select name="realisation'.$i.'"><option value="0"></option>'.$option_realisation.'</select></td> 
											<td>							
												<a class="lien_1" href="#" onclick="
													if(confirm(\'Etes vous certain de vouloir supprimer cette liaison ?\')) 
													{window.location=\'?contenu=question&action=modifier&supprLiaison='.$res['id_qd'].'&id='.$_GET['id'].'\'}">
													Supprimer
												</a>
											</td>
										 </tr>
									  ';
					}
					$tab_realisation.='</table>';
				}	
				$req_realisation=$my->req('SELECT * FROM ttre_realisations ORDER BY titre_realisation ASC');$option_realisation='';
				while ( $res_realisation=$my->arr($req_realisation) ) { $option_realisation.='<option value="'.$res_realisation['id_realisation'].'">'.$res_realisation['titre_realisation'].'</option>'; }
				$form->vide('
							<tr>
								<td>Réalisation :</td>
								<td>
									'.$tab_realisation.'
									<input type="hidden" name="nbrRealisation" id="nbrRealisation" value="1" >
									<table style="text-align:center;" id="tblRealisation" >
										<tr>
											<td colspan="2" style="text-align:center;">
												<input type="button" value="[+]" onclick="addRowToTableRealisation();"  style="cursor:pointer"/>
												<input type="button" value="[-]" onclick="removeRowFromTableRealisation();"  style="cursor:pointer"/>
											</td>
										</tr>
										<tr style="text-align:center; background-color:#D3DCE3;">
											<th>N°</td>
											<th>Réalisation</td>
										</tr>
										<tr style="background-color:#E5E5E5;">
											<td>1</td>
											<td><select name="realisation_1"><option value="0"></option>'.$option_realisation.'</select></td>
										</tr>
									</table>								
								</td>
							</tr>
							');
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=question">Retour</a></p>';				
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_questions WHERE id_question='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_option WHERE id_question='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_prix WHERE id_question='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_devis WHERE id_question='.$_GET['id'].' ');
			rediriger('?contenu=question&supprimer=ok');
			break;
	}
}
else
{
	echo '<h1>Gérer les questions</h1>';
	if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce question a bien été ajouté.</p></div>';
	elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce question a bien été supprimé.</p></div>';
	echo '<p>Pour ajouter un autre question, cliquer <a href="?contenu=question&action=ajouter">ICI</a></p>';
	$req = $my->req('SELECT * FROM ttre_questions ORDER BY label_question ASC ');
	if ( $my->num($req)>0 )
	{
		echo'
			<table id="liste_produits">
				<tr class="entete">
					<td>Question</td>
					<td class="bouton">Modifier</td>
					<td class="bouton">Supprimer</td>
				</tr>
			';
		while ( $res=$my->arr($req) )
		{
			echo'
				<tr>
					<td class="nom_prod">'.$res['label_question'].'</td>
					<td class="bouton">
						<a href="?contenu=question&action=modifier&id='.$res['id_question'].'">
						<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
					</td>
					<td class="bouton">
						<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce question ?\')) 
						{window.location=\'?contenu=question&action=supprimer&id='.$res['id_question'].'\'}" title="Supprimer">
						<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
					</td>
				</tr>
				';
		}
		echo'</table>';
	}
	else
	{
		echo '<p>Pas questions ...</p>';
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.label.value) ) { mes_erreur+='<p>Il faut entrer le champ Label !</p>'; }
		if( $.trim(this.type.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Type !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.label.value) ) { mes_erreur+='<p>Il faut entrer le champ Label !</p>'; }
		if( $.trim(this.type.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Type !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
	$('select[name="type"]').change(function ()
	{
		if( $(this).val()==2 ) $("#tr_option").css("display","");
		else $("#tr_option").css("display","none");
	});	
});
function addRowToTableOption()
{
  	var tbl = document.getElementById('tblOption');
 	var lastRow = tbl.rows.length;
  	var iteration = lastRow-1;
  
  	var row = tbl.insertRow(lastRow);
  	$("#tblOption tr:last").css("background-color","#E5E5E5");
  	  
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	var cellRightSel = row.insertCell(1);
  	var el=$('<input type="text" name="option_'+iteration+'" class="txt" />');
  	$(cellRightSel).append(el);
	
	document.getElementById('nbrOption').value = iteration;
}
function removeRowFromTableOption()
{
  	var tbl = document.getElementById('tblOption');
  	var lastRow = tbl.rows.length;
  	if (lastRow > 3) 
  	{
      	tbl.deleteRow(lastRow - 1);
      	document.getElementById('nbrOption').value --;
  	}
}
function addRowToTableDomaine()
{
  	var tbl = document.getElementById('tblDomaine');
 	var lastRow = tbl.rows.length;
  	var iteration = lastRow-1;
  
  	var row = tbl.insertRow(lastRow);
  	$("#tblDomaine tr:last").css("background-color","#E5E5E5");
  	  
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	var cellRightSel = row.insertCell(1);
  	var el=$('<select name="domaine_'+iteration+'">'+($('select[name="domaine_1"]').html())+'</select>');
  	$(cellRightSel).append(el);
	
	document.getElementById('nbrDomaine').value = iteration;
}
function removeRowFromTableDomaine()
{
  	var tbl = document.getElementById('tblDomaine');
  	var lastRow = tbl.rows.length;
  	if (lastRow > 3) 
  	{
      	tbl.deleteRow(lastRow - 1);
      	document.getElementById('nbrDomaine').value --;
  	}
}
function addRowToTableProfession()
{
  	var tbl = document.getElementById('tblProfession');
 	var lastRow = tbl.rows.length;
  	var iteration = lastRow-1;
  
  	var row = tbl.insertRow(lastRow);
  	$("#tblProfession tr:last").css("background-color","#E5E5E5");
  	  
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	var cellRightSel = row.insertCell(1);
  	var el=$('<select name="profession_'+iteration+'">'+($('select[name="profession_1"]').html())+'</select>');
  	$(cellRightSel).append(el);
	
	document.getElementById('nbrProfession').value = iteration;
}
function removeRowFromTableProfession()
{
  	var tbl = document.getElementById('tblProfession');
  	var lastRow = tbl.rows.length;
  	if (lastRow > 3) 
  	{
      	tbl.deleteRow(lastRow - 1);
      	document.getElementById('nbrProfession').value --;
  	}
}
function addRowToTableRealisation()
{
  	var tbl = document.getElementById('tblRealisation');
 	var lastRow = tbl.rows.length;
  	var iteration = lastRow-1;
  
  	var row = tbl.insertRow(lastRow);
  	$("#tblRealisation tr:last").css("background-color","#E5E5E5");
  	  
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	var cellRightSel = row.insertCell(1);
  	var el=$('<select name="realisation_'+iteration+'">'+($('select[name="realisation_1"]').html())+'</select>');
  	$(cellRightSel).append(el);
	
	document.getElementById('nbrRealisation').value = iteration;
}
function removeRowFromTableRealisation()
{
  	var tbl = document.getElementById('tblRealisation');
  	var lastRow = tbl.rows.length;
  	if (lastRow > 3) 
  	{
      	tbl.deleteRow(lastRow - 1);
      	document.getElementById('nbrRealisation').value --;
  	}
}
</script>
