<?php 
//echo'<pre>';print_r($_POST);echo'</pre>';

if ( ! function_exists('couper'))
{
    function couper($chaine,$length)
    {
    	$chaine=str_replace('<br />',' ',$chaine);
    	if(strlen($chaine)>$length) 
        return substr_replace (substr($chaine,0,$length),' ...',strrpos(substr($chaine,0,$length),' '));
    	return $chaine;
    }
    
}

$my = new mysql();
if ( isset($_GET['action']) )
{
	switch ( $_GET['action'] )
	{
		case 'ajouter' :
			if ( isset($_POST['ajouter']) )
			{
				$i=1;$valid_detail_prix=1;
				$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_POST['idcat'].' AND type=3 ORDER BY ordre ASC ');
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
				if ( $valid_detail_prix==0 || count($tabb)==0 )
				{
					$my->req('INSERT INTO ttre_questions_prix VALUES("",
											"'.$my->net_input($_POST['idcat']).'" ,
											"'.$my->net_textarea($_POST['designation']).'" ,
											"'.$my->net_input($_POST['prix']).'" ,
											"'.$my->net_input($_POST['tva']).'" 
											)');
					$idPrix=mysql_insert_id();
					$req=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_POST['idcat'].' ORDER BY ordre ASC ');
					if ( $my->num($req)>0 )
					{
						while ( $res=$my->arr($req) )
						{
							$my->req('INSERT INTO ttre_questions_prix_detail VALUES("",
													"'.$my->net_input($idPrix).'" ,
													"'.$my->net_input($res['id_question']).'" ,
													"'.$my->net_input($_POST['quest_'.$res['id_question'].'']).'" 
													)');
						}
					}
					rediriger('?contenu=prix&cat='.$_POST['idcat'].'&ajouter=ok');
				}
				else rediriger('?contenu=prix&cat='.$_POST['idcat'].'&najouter=ok ');
			}
			else
			{
				$parent=0;
				if ( isset($_POST['cat']) ) $parent=$_POST['cat'];
				
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
				
				$form = new formulaire('modele_1','?contenu=prix&action=ajouter','<h2 class="titre_niv2">Ajouter prix :</h2>','','','sub','txt','','txt_obl','lab_obl');
				$form->vide('<div id="note"></div>');
				$form->vide('<tr><td><label>Catégorie : </label></td><td>'.$selectGroup.'</td></tr>');
				$form->afficher_simple();
				
				$req=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
				while ( $res=$my->arr($req) ) $tab_tva[$res['id']]=$res['titre'];
				
				$liste='';
				$req=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$parent.' ORDER BY ordre ASC ');
				if ( $my->num($req)>0 )
				{
					while ( $res=$my->arr($req) )
					{
						if ( $res['type']==1 ) $champ='<input type="text" id="quest_'.$res['id_question'].'" name="quest_'.$res['id_question'].'" value="1" onKeyPress="return scanTouche(event)" readonly/>';
						elseif ( $res['type']==2 ) $champ='<input type="text" id="quest_'.$res['id_question'].'" name="quest_'.$res['id_question'].'" value="1" onKeyPress="return scanFTouche(event)" readonly/>';
						else 
						{
							$champ='<select id="quest_'.$res['id_question'].'" name="quest_'.$res['id_question'].'" ><option value="0"></option>';
							$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
							while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['optionn'].'</option>';
							$champ.='</select>';
						}
						$liste.='<p>'.$res['label'].' '.$champ.'</p>';
					}
				}
				$form = new formulaire('modele_1','?contenu=prix&action=ajouter','','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->textarea('Désignation','designation');
				$form->vide('<tr><td>Listes des questions :</td><td>'.$liste.'</td></tr>');
				$form->text('Prix','prix','onKeyPress="return scanFTouche(event)"',1);
				$form->select('Tva','tva',$tab_tva,'',1);
				$form->hidden('','idcat',$parent);
				$form->afficher('Enregistrer','ajouter');
				echo '<p><a href="?contenu=prix">Retour</a></p>';
			}
			break;
		case 'modifier' :
			if ( isset($_POST['modifier']) )
			{
				$i=1;$valid_detail_prix=1;
				$reqQuest=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_POST['idcat'].' AND type=3 ORDER BY ordre ASC ');
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
				$id=0;
				if ( count($tabb)>0 )
				{
					foreach ($tabb as $value) { $id=$value; break; }
				}
				if ($valid_detail_prix==0 || count($tabb)==0 || (count($tabb)==1 && $id==$_GET['id'] ) )
				{
					$my->req('DELETE FROM ttre_questions_prix WHERE id_prix='.$_GET['id'].' ');
					$my->req('DELETE FROM ttre_questions_prix_detail WHERE id_prix='.$_GET['id'].' ');
					$my->req('INSERT INTO ttre_questions_prix VALUES("",
											"'.$my->net_input($_POST['idcat']).'" ,
											"'.$my->net_textarea($_POST['designation']).'" ,
											"'.$my->net_input($_POST['prix']).'" ,
											"'.$my->net_input($_POST['tva']).'" 
											)');
					$idPrix=mysql_insert_id();
					$req=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$_POST['idcat'].' ORDER BY ordre ASC ');
					if ( $my->num($req)>0 )
					{
						while ( $res=$my->arr($req) )
						{
							$my->req('INSERT INTO ttre_questions_prix_detail VALUES("",
													"'.$my->net_input($idPrix).'" ,
													"'.$my->net_input($res['id_question']).'" ,
													"'.$my->net_input($_POST['quest_'.$res['id_question'].'']).'" 
													)');
						}
					}
					rediriger('?contenu=prix&action=modifier&cat='.$_POST['idcat'].'&id='.$idPrix.'&modifier=ok');
				}
				else rediriger('?contenu=prix&action=modifier&cat='.$_POST['idcat'].'&id='.$_GET['id'].'&nmodifier=ok');
			}
			else
			{
				$parent=$_GET['cat'];
				if ( isset($_POST['cat']) ) $parent=$_POST['cat'];
				
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
				
				if ( isset($_GET['modifier']) ) $alert='<div id="note" class="success"><p>Ce prix a bien été modifié.</p></div>';
				elseif ( isset($_GET['nmodifier']) ) $alert='<div class="error"><p>Ce prix existe déjà.</p></div>';
				else $alert='<div id="note"></div>';
				
				$form = new formulaire('modele_1','?contenu=prix&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'','<h2 class="titre_niv2">Ajouter prix :</h2>','','','sub','txt','','txt_obl','lab_obl');
				$form->vide($alert);
				$form->vide('<tr><td><label>Catégorie : </label></td><td>'.$selectGroup.'</td></tr>');
				$form->afficher_simple();
				
				$req=$my->req('SELECT * FROM ttre_tva ORDER BY id ASC');
				while ( $res=$my->arr($req) ) $tab_tva[$res['id']]=$res['titre'];
				
				$liste='';
				$req=$my->req('SELECT * FROM ttre_questions WHERE id_categorie='.$parent.' ORDER BY ordre ASC ');
				if ( $my->num($req)>0 )
				{
					while ( $res=$my->arr($req) )
					{
						if ( $res['type']==1 )$champ='<input type="text" id="quest_'.$res['id_question'].'" name="quest_'.$res['id_question'].'" value="1" onKeyPress="return scanTouche(event)" readonly/>';
						elseif ( $res['type']==2 ) $champ='<input type="text" id="quest_'.$res['id_question'].'" name="quest_'.$res['id_question'].'" value="1" onKeyPress="return scanFTouche(event)" readonly/>';
						else 
						{
							$val=$my->req_arr('SELECT * FROM ttre_questions_prix_detail WHERE id_question='.$res['id_question'].' AND id_prix='.$_GET['id'].' ');
							if ( $val )
							{
								$champ='<select id="quest_'.$res['id_question'].'" name="quest_'.$res['id_question'].'" ><option value="0"></option>';
								$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
								while ( $res_option=$my->arr($req_option) ) 
								{
									if ( $res_option['id_option']==$val['valeur'] ) $sel='selected="selected"'; else $sel='';
									$champ.='<option value="'.$res_option['id_option'].'" '.$sel.'>'.$res_option['optionn'].'</option>';
								}
								$champ.='</select>';
							}
							else
							{
								$champ='<select id="quest_'.$res['id_question'].'" name="quest_'.$res['id_question'].'" ><option value="0"></option>';
								$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
								while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['optionn'].'</option>';
								$champ.='</select>';
							}
						}
						$liste.='<p>'.$res['label'].' '.$champ.'</p>';
					}
				}
				
				$temp = $my->req_arr('SELECT * FROM ttre_questions_prix WHERE id_prix='.$_GET['id'].' ');
				
				$form = new formulaire('modele_1','?contenu=prix&action=modifier&cat='.$_GET['cat'].'&id='.$_GET['id'].'','','ajouter','','sub','txt','','txt_obl','lab_obl');
				$form->textarea('Désignation','designation',str_replace('<br />',' ',$temp['designation']));
				$form->vide('<tr><td>Listes des questions :</td><td>'.$liste.'</td></tr>');
				$form->text('Prix','prix','onKeyPress="return scanFTouche(event)"',1,$temp['prix']);
				$form->select_cu('Tva','tva',$tab_tva,$temp['tva'],1);
				$form->hidden('','idcat',$parent);
				$form->afficher('Modifier','modifier');
				echo '<p><a href="?contenu=prix&cat='.$_GET['cat'].'">Retour</a></p>';
				
			}
			break;
		case 'supprimer' :
			$my->req('DELETE FROM ttre_questions_prix WHERE id_prix='.$_GET['id'].' ');
			$my->req('DELETE FROM ttre_questions_prix_detail WHERE id_prix='.$_GET['id'].' ');
			
			rediriger('?contenu=prix&cat='.$_GET['cat'].'&supprimer=ok');
			break;
	}
}
else
{
	$req=$my->req('SELECT * FROM ttre_questions');
	if ( $my->num($req)>0 )
	{
		echo '<h1>Gérer les prix</h1>';
		if ( isset($_GET['ajouter']) ) echo '<div class="success"><p>Ce prix a bien été ajouté.</p></div>';
		elseif ( isset($_GET['najouter']) ) echo '<div class="error"><p>Ce prix existe déjà.</p></div>';
		elseif ( isset($_GET['supprimer']) ) echo '<div class="success"><p>Ce prix a bien été supprimé.</p></div>';
		echo '<p>Pour ajouter un autre prix, cliquer <a href="?contenu=prix&action=ajouter">ICI</a></p>';
		
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
		
		
		$form = new formulaire('modele_1','?contenu=prix','','','','sub','txt','','txt_obl','lab_obl');
		$form->vide('<tr><td><label>Rechercher par catégorie : </label></td><td>'.$selectGroup.'</td></tr>');
		$form->afficher_simple();
		
		$req = $my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$parent.' ORDER BY id_prix DESC ');
		if ( $my->num($req)>0 )
		{
			echo'
				<table id="liste_produits">
					<thead>
						<tr class="entete">
							<td>Désignation</td>
							<td class="bouton">Prix</td>
							<td class="bouton">Modifier</td>
							<td class="bouton">Supprimer</td>
						</tr>
					</thead>
					<tbody>
				';
			while ( $res=$my->arr($req) )
			{
				echo'
					<tr>
						<td class="nom_prod">'.couper($res['designation'],80).'</td>
						<td class="bouton">'.number_format($res['prix'],2).' €</td>
						<td class="bouton">
							<a href="?contenu=prix&action=modifier&cat='.$parent.'&id='.$res['id_prix'].'">
							<img src="img/interface/btn_modifier.png" alt="Modifier"/></a>
						</td>
						<td class="bouton">
							<a href="#" onclick="if(confirm(\'Etes vous certain de vouloir supprimer ce prix ?\')) 
							{window.location=\'?contenu=prix&action=supprimer&cat='.$parent.'&id='.$res['id_prix'].'\'}" title="Supprimer">
							<img src="img/interface/btn_supp.png" alt="Supprimer" border="0" /></a>
						</td>
					</tr>
					';
			}
			echo'
					</tbody>
				</table>';
		}
		else
		{
			echo '<p>Pas prix ...</p>';
		}
	}
	else
	{
		echo '<p>Il faut ajouter des questions ...</p>';
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$('form[name="ajouter"]').submit(function ()
	{
		mes_erreur='';
		if( $.trim(this.idcat.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Catégorie !</p>'; }
		else if( !$.trim(this.designation.value) ) { mes_erreur+='<p>Il faut entrer le champ Désignation !</p>'; }
		else if( !$.trim(this.prix.value) ) { mes_erreur+='<p>Il faut entrer le champ Prix !</p>'; }
		else if( $.trim(this.prix.value)==0 ) { mes_erreur+='<p>Il faut entrer le champ Prix !</p>'; }
		//if( $.trim(this.type.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Type !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
	$('form[name="modifier"]').submit(function ()
	{
		mes_erreur='';
		if( $.trim(this.idcat.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Catégorie !</p>'; }
		else if( !$.trim(this.designation.value) ) { mes_erreur+='<p>Il faut entrer le champ Désignation !</p>'; }
		//if( $.trim(this.type.value)==0 ) { mes_erreur+='<p>Il faut choisir le champ Type !</p>'; }
		if ( mes_erreur ) { $("#note").addClass("error");$("#note").html(mes_erreur); return(false); }
	});
});
function codeTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d/;var codeDecimal=codeTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}

function codeFTouche(evenement){for(prop in evenement){if(prop=='which')return(evenement.which);}return(evenement.keyCode);}
function scanFTouche(evenement){var reCarSpeciaux=/[\x00\x08\x0D\x03\x16\x18\x1A]/;var reCarValides=/\d|\./;var codeDecimal=codeFTouche(evenement);var car=String.fromCharCode(codeDecimal);
                               var autorisation=reCarValides.test(car)||reCarSpeciaux.test(car);return autorisation;}
</script>
