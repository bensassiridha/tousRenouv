<script type="text/javascript" src="ordre/ui.core.js"></script>
<script type="text/javascript" src="ordre/ui.sortable.js"></script>
<?php 
//echo'<pre>';print_r($_POST);echo'</pre>';

$my = new mysql();
$tab_type=array(1=>'Champ INTEGER',2=>'Champ FLOAT',3=>'champ SELECT');
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$ordre= $my->req_obj('SELECT max( ordre ) AS tot FROM ttre_questions');
				if ($ordre) $ordre = $ordre->tot; else $ordre=0;
				
				$my->req('INSERT INTO ttre_questions VALUES("",
										"'.$my->net_input($_POST['idcat']).'" ,
										"'.$my->net_input($_POST['label']).'" ,
										"'.$my->net_input($_POST['type']).'" ,
										"'.$my->net_input($_POST['unite']).'" ,
										"'.($ordre+1).'"
										)');
				$idQuest=mysql_insert_id();
				if ( $_POST['type']==3 ) // champ select
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
				$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idcat'].' ');
				while ( $res=$my->arr($req) ) $my->req('INSERT INTO ttre_questions_prix_detail VALUES("","'.$res['id_prix'].'","'.$idQuest.'","0")');
				rediriger('?contenu=question&cat='.$_POST['idcat'].'&ajouter=ok');
			}
			else
			{
				$parent=0;
				$selectGroup='<select name="idcat" id="idcat" class="txt">';
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
				while ( $res=$my->arr($req) )
				{
					$selectGroup.='<optgroup label="'.$res['titre'].'">';$test=0;
					$reqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$res['id'].' ORDER BY ordre ASC ');
					while ( $ress=$my->arr($reqq) )
					{	
						$reqqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$ress['id'].' ORDER BY ordre ASC ');
						if ( $my->num($reqqq)>0 )
						{
							$selectGroup.='<optgroup style="margin:0 0 0 20px;font-weight:normal;" label="'.$ress['titre'].'">';
							while ( $resss=$my->arr($reqqq) )
							{
								if ($resss['id']==$parent ) $sel='selected="selected"'; else $sel='';
								$selectGroup.='<option style="" value="'.$resss['id'].'" '.$sel.'>'.$resss['titre'].'</option>';
							}
							$selectGroup.='</optgroup>';$test=1;
						}
						else
						{
							if ( $test==1 ) $style='style="margin:0 0 0 20px;"'; else $style='';
							if ($ress['id']==$parent ) $sel='selected="selected"'; else $sel='';
							$selectGroup.='<option '.$style.' value="'.$ress['id'].'" '.$sel.'>'.$ress['titre'].'</option>';
						}
					}
					$selectGroup.='</optgroup>';
				}
				$selectGroup.='</select>';
				
				$form = new formulaire('modele_1','?contenu=question&action=ajouter','<h2 class="titre_niv2">Ajouter question :</h2>','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->vide('<tr><td><label class="lab_obl">Catégorie : </label></td><td>'.$selectGroup.'</td></tr>');
				$form->text('Label','label','',1);
				$form->select('Type','type',$tab_type,'',1);
				$form->vide('
							<tr id="tr_unite">
								<td>Unité : </td>
								<td><input type="text" class="txt_obl" value="" maxlenght="255" name="unite"><td>
							</tr>
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
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=question">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$idQuest=$_GET['id'];
				
				$temp = $my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$_GET['id'].' ');
				if ( $temp['id_categorie']!=$_POST['idcat'] )
				{
					$my->req('DELETE FROM ttre_questions_prix_detail WHERE id_question='.$_GET['id'].' ');
					$req=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_GET['cat'].' ');
					if ( $my->num($req)==1 )
						$my->req('DELETE FROM ttre_questions_prix WHERE id_categorie='.$_GET['cat'].' ');
				}
				
				$my->req('UPDATE ttre_questions SET 
									id_categorie	=	"'.$my->net_input($_POST['idcat']).'" ,
									label 			=	"'.$my->net_input($_POST['label']).'" ,
									type  			=	"'.$my->net_input($_POST['type']).'" ,
									unite  			=	"'.$my->net_input($_POST['unite']).'" 
								WHERE id_question = '.$idQuest.' ');	

				if ( $_POST['type']==3 ) // champ select
				{
					$req = $my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$idQuest.' ORDER BY id_option ASC');	
					if ( $my->num($req)>0 )				  
					{
						$i=0;
						while ( $res=$my->arr($req) )
						{
							$i++;
							if ( !empty($_POST['option'.$i]) )
								$my->req('UPDATE ttre_questions_option SET optionn="'.$my->net_input($_POST['option'.$i]).'" WHERE id_option='.$res['id_option'].'');                
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
				
				rediriger('?contenu=question&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'&modifier=ok');
			}
			else
			{
				if (isset($_GET['supprOption'] ))
				{
					$my->req ('DELETE FROM ttre_questions_option WHERE id_option='.$_GET['supprOption'].' ');
					$my->req('UPDATE ttre_questions_prix_detail SET valeur="0" WHERE id_question='.$_GET['id'].' AND valeur='.$_GET['supprOption'].' ');	
					rediriger('?contenu=question&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'&optionSuppr=ok');
				}
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Ce question a bien été modifié.</p></div>';
				elseif ( isset($_GET['optionSuppr']) ) $alert='<div id="note" class="success"><p>Cette option a bien été supprimée.</p></div>';
				else $alert='<div id="note"></div>';
				
				$temp = $my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$_GET['id'].' ');
				
				$parent=$temp['id_categorie'];
				$selectGroup='<select name="idcat" id="idcat" class="txt">';
				$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
				while ( $res=$my->arr($req) )
				{
					$selectGroup.='<optgroup label="'.$res['titre'].'">';$test=0;
					$reqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$res['id'].' ORDER BY ordre ASC ');
					while ( $ress=$my->arr($reqq) )
					{	
						$reqqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$ress['id'].' ORDER BY ordre ASC ');
						if ( $my->num($reqqq)>0 )
						{
							$selectGroup.='<optgroup style="margin:0 0 0 20px;font-weight:normal;" label="'.$ress['titre'].'">';
							while ( $resss=$my->arr($reqqq) )
							{
								if ($resss['id']==$parent ) $sel='selected="selected"'; else $sel='';
								$selectGroup.='<option style="" value="'.$resss['id'].'" '.$sel.'>'.$resss['titre'].'</option>';
							}
							$selectGroup.='</optgroup>';$test=1;
						}
						else
						{
							if ( $test==1 ) $style='style="margin:0 0 0 20px;"'; else $style='';
							if ($ress['id']==$parent ) $sel='selected="selected"'; else $sel='';
							$selectGroup.='<option '.$style.' value="'.$ress['id'].'" '.$sel.'>'.$ress['titre'].'</option>';
						}
					}
					$selectGroup.='</optgroup>';
				}
				$selectGroup.='</select>';
				
				$form = new formulaire('modele_1','?contenu=question&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'','<h2 class="titre_niv2">Modifier question :</h2>','modifier','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->vide('<tr><td><label class="lab_obl">Catégorie : </label></td><td>'.$selectGroup.'</td></tr>');
				$form->text('Label','label','',1,$temp['label']);
				$form->select_cu('Type','type',$tab_type,$temp['type'],'',1);
				if ( $temp['type']==3 ) 
				{
					$tr_option_unite='style="display:none;"';
					$tr_option_style='';
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
												<td><input type="text" name="option'.$i.'" value="'.$res['optionn'].'"/></td> 
												<td>							
													<a class="lien_1" href="#" onclick="
														if(confirm(\'Etes vous certain de vouloir supprimer cette option ?\')) 
														{window.location=\'?contenu=question&action=modifier&cat='.$_GET['cat'].'&supprOption='.$res['id_option'].'&id='.$_GET['id'].'\'}">
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
					$tr_option_unite='';
					$tr_option_style='style="display:none;"';
					$tab_option='';
				}
				$form->vide('
							<tr id="tr_unite" '.$tr_option_unite.'>
								<td>Unité : </td>
								<td><input type="text" class="txt_obl" value="'.$temp['unite'].'" maxlenght="255" name="unite"><td>
							</tr>
							<tr id="tr_option" '.$tr_option_style.' >
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
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=question&cat='.$_GET['cat'].'">Retour</a></p>';				
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_questions WHERE id_question='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_option WHERE id_question='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_prix_detail WHERE id_question='.$_GET['id'].' ');
			$req=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_GET['cat'].' ');
			if ( $my->num($req)==0 )
				$my->req('DELETE FROM ttre_questions_prix WHERE id_categorie='.$_GET['cat'].' ');
			rediriger('?contenu=question&cat='.$_GET['cat'].'&supprimer=ok');
			break;
		case 'ordre' :
			foreach ($_POST['ordre'] as $key=>$value)
				$my->req('UPDATE ttre_questions SET ordre="'.$my->net($key).'" WHERE id_question='.$my->net($value));
			rediriger('?contenu=question&cat='.$_POST['idcat'].'&ordre=ok');
			break;
	}
}
else
{
	$req=$my->req('SELECT * FROM ttre_categories WHERE parent!=0 ORDER BY ordre ASC ');
	if ( $my->num($req)>0 )
	{
		echo '<h1>Gérer les questions</h1>';
		if ( isset($_GET['ordre']) ) echo '<div class="success"><p>L\'ordre a bien été modifié.</p></div>';
		elseif ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce question a bien été ajouté.</p></div>';
		elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce question a bien été supprimé.</p></div>';
		echo '<p>Pour ajouter un autre question, cliquer <a href="?contenu=question&action=ajouter">ICI</a></p>';
		
		$parent=0;
		if ( isset($_POST['cat']) ) $parent=$_POST['cat'];
		elseif ( isset($_GET['cat']) ) $parent=$_GET['cat'];
		
		$selectGroup='<select name="cat" id="cat" onchange="form.submit()" class="txt"><option value="0"></option>';
		$req=$my->req('SELECT * FROM ttre_categories WHERE parent=0 ORDER BY ordre ASC');
		while ( $res=$my->arr($req) )
		{
			$selectGroup.='<optgroup label="'.$res['titre'].'">';$test=0;
			$reqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$res['id'].' ORDER BY ordre ASC ');
			while ( $ress=$my->arr($reqq) )
			{	
				$reqqq=$my->req('SELECT * FROM ttre_categories WHERE parent='.$ress['id'].' ORDER BY ordre ASC ');
				if ( $my->num($reqqq)>0 )
				{
					$selectGroup.='<optgroup style="margin:0 0 0 20px;font-weight:normal;" label="'.$ress['titre'].'">';
					while ( $resss=$my->arr($reqqq) )
					{
						if ($resss['id']==$parent ) $sel='selected="selected"'; else $sel='';
						$selectGroup.='<option style="" value="'.$resss['id'].'" '.$sel.'>'.$resss['titre'].'</option>';
					}
					$selectGroup.='</optgroup>';$test=1;
				}
				else
				{
					if ( $test==1 ) $style='style="margin:0 0 0 20px;"'; else $style='';
					if ($ress['id']==$parent ) $sel='selected="selected"'; else $sel='';
					$selectGroup.='<option '.$style.' value="'.$ress['id'].'" '.$sel.'>'.$ress['titre'].'</option>';
				}
			}
			$selectGroup.='</optgroup>';
		}
		$selectGroup.='</select>';
		
		
		$form = new formulaire('modele_1','?contenu=question','','','','sub','txt','','txt_obl','lab_obl');
		$form->vide('<tr><td><label>Rechercher par catégorie : </label></td><td>'.$selectGroup.'</td></tr>');
		$form->afficher_simple();
		
		$req = $my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$parent.' ORDER BY ordre ASC ');
		if ( $my->num($req)>0 )
		{
			echo'
				<form method="POST" action="?contenu=question&action=ordre" >
					<table id="liste_produits">
						<thead>
							<tr class="entete">
								<td>Question</td>
								<td class="bouton">Modifier</td>
								<td class="bouton">Supprimer</td>
								<td class="bouton">Ordre</td>
							</tr>
						</thead>
						<tbody>
				';
			while ( $res=$my->arr($req) )
			{
				echo'
					<tr>
						<td class="nom_prod">'.$res['label'].'</td>
						<td class="bouton">
							<a href="?contenu=question&action=modifier&cat='.$parent.'&id='.$res['id_question'].'">
							<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce question ?\')) 
							{window.location=\'?contenu=question&action=supprimer&cat='.$parent.'&id='.$res['id_question'].'\'}" title="Supprimer">
							<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
						</td>
						<td class="bouton" style="cursor: move;">
							<img src="ordre/cursor_move.gif" alt="Mover" border="0" />
							<input type="hidden" name="ordre[]" value="' . $res ['id_question'] . '" />
						</td>	
					</tr>
					';
			}
			echo'
					</tbody>
				</table>
				<input id="idcat" name="idcat" value="'.$parent.'" type="hidden" />
				<input type="submit"  value="Modifier l\'ordre" style="margin:10px 0 0 250px;"/>
				</form>';
		}
		else
		{
			echo '<p>Pas questions ...</p>';
		}
	}
	else
	{
		echo '<p>Il faut ajouter des sous catégories ...</p>';
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.label.value) ) { mes_erreur+='<p>Il faut entrer le champ Label !</p>'; }
		//if( $.trim(this.type.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Type !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( !$.trim(this.label.value) ) { mes_erreur+='<p>Il faut entrer le champ Label !</p>'; }
		//if( $.trim(this.type.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Type !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
	$('select[name="type"]').change(function ()
	{
		if( $(this).val()==3 ) 
		{
			$("#tr_option").css("display","");
			$("#tr_unite").css("display","none");
		}
		else 
		{
			$("#tr_option").css("display","none");
			$("#tr_unite").css("display","");
		}
		
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

$(function() {

	// Return a helper with preserved width of cells
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};

	$("#liste_produits tbody tr").css('background-color','#FFF');
	$("#liste_produits tbody").sortable({
		helper: fixHelper, placeholder: 'ui-state-highlight'  
	}).disableSelection();
   
});
</script>
