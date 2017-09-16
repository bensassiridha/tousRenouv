<?php 
session_start();
header("Content-Type:text/plain; charset=iso-8859-1");
require('mysql.php');$my=new mysql();
if ( isset($_POST['devis']) )
{
	if ( $_POST['devis']=='modifDomaine' )
	{
		$QA='';$QRA='';
		$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['nd'].' ORDER BY id_question ASC ');
		while ( $res=$my->arr($req) )
		{
			$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['ad'].' AND id_question='.$res['id_question'].' ');
			if ( $my->num($temp)==0 ) 
			{
				$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
				if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$res['id_question'].'" />';
				else 
				{
					$champ='<select name="quest_'.$res['id_question'].'" onchange="affichPreciser('.$res['id_question'].',this.value);" ><option value="0"></option>';
					$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
					while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
					$champ.='<option value="-1">Autre</option></select><span id="span_'.$res['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$res['id_question'].'" /></span>';
				}
				$QA.='<div id="question_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
			}
			else
			{
				$QRA.='|'.$res['id_question'];
			}
		}
		$QS='';
		$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['ad'].' ORDER BY id_question ASC ');
		while ( $res=$my->arr($req) )
		{
			$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['nd'].' AND id_question='.$res['id_question'].' ');
			if ( $my->num($temp)==0 ) 
			{
				$QS.='|'.$res['id_question'];
			}
		}
		//echo $QRA.'<>'.$AQ.'<>'.$QS;
		echo $QS.'|'.$QA;
	}
	elseif ( $_POST['devis']=='ajoutProf' )
	{
		$result='';$QA=array();
		$tab_av=explode('|',$_POST['sav']);
		$tab_op=explode('|',$_POST['ops']);
		$tab_rr=explode('|',$_POST['rrr']);
		for( $i=1;$i<count($tab_op);$i++)
		{
			$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_profession='.$tab_op[$i].' ORDER BY id_question ASC ');
			while ( $res=$my->arr($req) )
			{
				$test=0;
				for( $j=1;$j<count($tab_av);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_profession='.$tab_av[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				for( $j=1;$j<count($tab_rr);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_realisation='.$tab_rr[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				if ( array_search($res['id_question'], $QA)!== false ) $test=1;
				
				if ( $test==0 ) 
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$res['id_question'].'" />';
					else 
					{
						$champ='<select name="quest_'.$res['id_question'].'" onchange="affichPreciser('.$res['id_question'].',this.value);" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='<option value="-1">Autre</option></select><span id="span_'.$res['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$res['id_question'].'" /></span>';
					}
					$result.='<div id="question_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
					$QA[]=$res['id_question'];
				}
			}
		}
		$affichD='';
		if ( $result!='' && $_POST['affichDomaine']==1 )
		{
			$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['idD'].' ORDER BY id_question ASC ');
			while ( $res=$my->arr($req) )
			{
				$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
				if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$res['id_question'].'" />';
				else 
				{
					$champ='<select name="quest_'.$res['id_question'].'" onchange="affichPreciser('.$res['id_question'].',this.value);" ><option value="0"></option>';
					$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
					while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
					$champ.='<option value="-1">Autre</option></select><span id="span_'.$res['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$res['id_question'].'" /></span>';
				}
				$affichD.='<div id="question_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
			}
		}
		echo $affichD.$result;
	}
	elseif ( $_POST['devis']=='supprProf' )
	{
		$QS='';
		$tab_ap=explode('|',$_POST['sap']);
		$tab_op=explode('|',$_POST['ops']);
		$tab_rr=explode('|',$_POST['rrr']);
		for( $i=1;$i<count($tab_op);$i++)
		{
			$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_profession='.$tab_op[$i].' ORDER BY id_question ASC ');
			while ( $res=$my->arr($req) )
			{
				$test=0;
				for( $j=1;$j<count($tab_ap);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_profession='.$tab_ap[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				for( $j=1;$j<count($tab_rr);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_realisation='.$tab_rr[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				if ( $test==0 ) 
				{
					$QS.='|'.$res['id_question'];
				}
			}
		}
		$QD='';
		$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['idD'].' ORDER BY id_question ASC ');
		while ( $res=$my->arr($req) )
		{
			$QD.='|'.$res['id_question'];
		}
		if ( $_POST['sap']=='' && $_POST['rrr']=='' ) $QS.=$QD;
		echo $QS;
	}
	elseif ( $_POST['devis']=='ajoutReal' )
	{
		$result='';$QA=array();
		$tab_av=explode('|',$_POST['sav']);
		$tab_op=explode('|',$_POST['ops']);
		$tab_pp=explode('|',$_POST['ppp']);
		for( $i=1;$i<count($tab_op);$i++)
		{
			$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_realisation='.$tab_op[$i].' ORDER BY id_question ASC ');
			while ( $res=$my->arr($req) )
			{
				$test=0;
				for( $j=1;$j<count($tab_av);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_realisation='.$tab_av[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				for( $j=1;$j<count($tab_pp);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_profession='.$tab_pp[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				if ( array_search($res['id_question'], $QA)!== false ) $test=1;
				
				if ( $test==0 ) 
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$res['id_question'].'" />';
					else 
					{
						$champ='<select name="quest_'.$res['id_question'].'" onchange="affichPreciser('.$res['id_question'].',this.value);" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='<option value="-1">Autre</option></select><span id="span_'.$res['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$res['id_question'].'" /></span>';
					}
					$result.='<div id="question_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
					$QA[]=$res['id_question'];
				}
			}
		}
		$affichD='';
		if ( $result!='' && $_POST['affichDomaine']==1 )
		{
			$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['idD'].' ORDER BY id_question ASC ');
			while ( $res=$my->arr($req) )
			{
				$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
				if ( $quest['type_question']==1 ) $champ='<input type="text" name="quest_'.$res['id_question'].'" />';
				else 
				{
					$champ='<select name="quest_'.$res['id_question'].'" onchange="affichPreciser('.$res['id_question'].',this.value);" ><option value="0"></option>';
					$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
					while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
					$champ.='<option value="-1">Autre</option></select><span id="span_'.$res['id_question'].'" style="display:none;"> Préciser <input type="text" name="preciser_'.$res['id_question'].'" /></span>';
				}
				$affichD.='<div id="question_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</div>';
			}
		}
		echo $affichD.$result;
	}
	elseif ( $_POST['devis']=='supprReal' )
	{
		$QS='';
		$tab_ap=explode('|',$_POST['sap']);
		$tab_op=explode('|',$_POST['ops']);
		$tab_pp=explode('|',$_POST['ppp']);
		for( $i=1;$i<count($tab_op);$i++)
		{
			$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_realisation='.$tab_op[$i].' ORDER BY id_question ASC ');
			while ( $res=$my->arr($req) )
			{
				$test=0;
				for( $j=1;$j<count($tab_ap);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_realisation='.$tab_ap[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				for( $j=1;$j<count($tab_pp);$j++ )
				{
					$temp=$my->req('SELECT * FROM ttre_questions_devis WHERE id_profession='.$tab_pp[$j].' AND id_question='.$res['id_question'].' ');
					if ( $my->num($temp)>0 ) { $test=1; break; }
				}
				if ( $test==0 ) 
				{
					$QS.='|'.$res['id_question'];
				}
			}
		}
		$QD='';
		$req=$my->req('SELECT * FROM ttre_questions_devis WHERE id_domaine='.$_POST['idD'].' ORDER BY id_question ASC ');
		while ( $res=$my->arr($req) )
		{
			$QD.='|'.$res['id_question'];
		}
		if ( $_POST['sap']=='' && $_POST['ppp']=='' ) $QS.=$QD;
		echo $QS;
	}
}
elseif ( isset($_POST['prix']) )
{
	if ( $_POST['prix']=='affichScat' )
	{
		$affich='';
		$reqScat=$my->req('SELECT * FROM ttre_categories WHERE parent_categorie='.$_POST['idCat'].' AND id_categorie!=16 AND id_categorie!=24 AND id_categorie!=26 AND id_categorie!=31 AND id_categorie!=32 AND id_categorie!=33 AND id_categorie!=42 ORDER BY ordre ASC');
		if ( $my->num($reqScat)>0 )
		{
			$i=1;
			while ( $resScat=$my->arr($reqScat) )
			{
				$style='style="background:#F6A20E;color:#fff;"';
				if ( $i==1 ) { $style='style="background:#0495CB;color:#fff;"';$ScatID=$resScat['id_categorie']; }
				$logo='';
				if ( $resScat['id_categorie']==35 ) $logo='<img src="scatLogo/1/mur.png" />';
				elseif ( $resScat['id_categorie']==36 ) $logo='<img src="scatLogo/1/porte.png" />';
				elseif ( $resScat['id_categorie']==37 ) $logo='<img src="scatLogo/1/dalle.png" />';
				elseif ( $resScat['id_categorie']==38 ) $logo='<img src="scatLogo/1/plancher.png" />';
				elseif ( $resScat['id_categorie']==39 ) $logo='<img src="scatLogo/1/terassement.png" />';
				//elseif ( $resScat['id_categorie']==26 ) $logo='<img src="catLogo/3.png" />';
				elseif ( $resScat['id_categorie']==27 ) $logo='<img src="scatLogo/2/fenetre.png" />';
				elseif ( $resScat['id_categorie']==28 ) $logo='<img src="scatLogo/2/porte.png" />';
				elseif ( $resScat['id_categorie']==29 ) $logo='<img src="scatLogo/2/porte_fenetre.png" />';
				elseif ( $resScat['id_categorie']==30 ) $logo='<img src="catLogo/3.png" />';
				//elseif ( $resScat['id_categorie']==30 ) $logo='<img src="scatLogo/2/escalier.png" />';
				//elseif ( $resScat['id_categorie']==31 ) $logo='<img src="scatLogo/2/placard.png" />';
				//elseif ( $resScat['id_categorie']==32 ) $logo='<img src="scatLogo/2/portail.png" />';
				//elseif ( $resScat['id_categorie']==33 ) $logo='<img src="scatLogo/2/garage.png" />';
				elseif ( $resScat['id_categorie']==41 ) $logo='<img src="scatLogo/2/volet.png" />';
				elseif ( $resScat['id_categorie']==34 ) $logo='<img src="scatLogo/2/velux.png" />';
				elseif ( $resScat['id_categorie']==11 ) $logo='<img src="scatLogo/3/carrelage.png" />';
				elseif ( $resScat['id_categorie']==12 ) $logo='<img src="scatLogo/3/parquet.png" />';
				elseif ( $resScat['id_categorie']==13 ) $logo='<img src="scatLogo/3/dallage.png" />';
				elseif ( $resScat['id_categorie']==14 ) $logo='<img src="scatLogo/3/moquette.png" />';
				elseif ( $resScat['id_categorie']==15 ) $logo='<img src="scatLogo/3/chape.png" />';
				elseif ( $resScat['id_categorie']==7 ) $logo='<img src="scatLogo/4/peinture.png" />';
				elseif ( $resScat['id_categorie']==8 ) $logo='<img src="scatLogo/4/enduit.gif" />';
				elseif ( $resScat['id_categorie']==9 ) $logo='<img src="scatLogo/4/papier peint.png" />';
				elseif ( $resScat['id_categorie']==10 ) $logo='<img src="scatLogo/4/ravalement.png" />';
				elseif ( $resScat['id_categorie']==20 ) $logo='<img src="scatLogo/5/douche.png" />';
				elseif ( $resScat['id_categorie']==21 ) $logo='<img src="scatLogo/5/baignoire.png" />';
				elseif ( $resScat['id_categorie']==22 ) $logo='<img src="scatLogo/5/evier.png" />';
				elseif ( $resScat['id_categorie']==23 ) $logo='<img src="scatLogo/5/wc.png" />';
				//elseif ( $resScat['id_categorie']==24 ) $logo='<img src="scatLogo/5/tuiyau.png" />';
				elseif ( $resScat['id_categorie']==43 ) $logo='<img src="scatLogo/5/chauffage.jpg" />';
				//elseif ( $resScat['id_categorie']==25 ) $logo='<img src="scatLogo/5/Ballon.png" />';
				elseif ( $resScat['id_categorie']==25 ) $logo='<img src="catLogo/9.png" />';
				//elseif ( $resScat['id_categorie']==16 ) $logo='<img src="catLogo/10.png" />';
				elseif ( $resScat['id_categorie']==17 ) $logo='<img src="scatLogo/6/prise.png" />';
				elseif ( $resScat['id_categorie']==18 ) $logo='<img src="scatLogo/6/Eclairage.png" />';
				elseif ( $resScat['id_categorie']==19 ) $logo='<img src="scatLogo/6/tableau.png" />';
				elseif ( $resScat['id_categorie']==44 ) $logo='<img src="catLogo/4.png" />';
				elseif ( $resScat['id_categorie']==45 ) $logo='<img src="catLogo/7.png" />';
				if ( $resScat['id_categorie']==30 ) $tit='Autre'; 
				elseif ( $resScat['id_categorie']==25 ) $tit='Autre'; 
				else $tit=$resScat['titre_categorie'];
				$affich.='
					<li id="li_scat_'.$_POST['idCat'].'_'.$resScat['id_categorie'].'" onClick="affichQuest('.$_POST['idCat'].','.$resScat['id_categorie'].')" class="classLiScat" '.$style.'>
						'.$logo.' <br /> '.$tit.'
					</li>';
				$i=2;
			}
		}
		$menu_scat='<ul id="ul_scat_'.$_POST['idCat'].'" style="height:55px;">'.$affich.'</ul>';
		if ( $ScatID==28 ) // Porte : Porte + Portail + Porte de garage
		{
			// Porte
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$ScatID.' ORDER BY ordre ASC ');$affichQ1='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ1.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			// Portail
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie=32 ORDER BY ordre ASC ');$affichQ2='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ2.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			// Porte de garage
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie=33 ORDER BY ordre ASC ');$affichQ3='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ3.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			$affichQ='
					  <strong>Porte : </strong><span id="s_s_28_1" style="cursor:pointer;" onClick="return affich_suite(\'28_1\');" >[+]</span><div id="q_s_28_1" style="display:none;">
					  '.$affichQ1.'
					  </div><br /><strong>Portail : </strong><span id="s_s_28_2" style="cursor:pointer;" onClick="return affich_suite(\'28_2\');" >[+]</span><div id="q_s_28_2" style="display:none;">
					  '.$affichQ2.' 
					  </div><br /><strong>Porte de garage : </strong><span id="s_s_28_3" style="cursor:pointer;" onClick="return affich_suite(\'28_3\');" >[+]</span><div id="q_s_28_3" style="display:none;">
					  '.$affichQ3.'
					  </div>';
		}
		elseif ( $ScatID==20 ) // Plomberie : Douche
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$ScatID.' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					if ( $res['id_question']==100 )
					{
						$affichQ.='<div id="suite_quest_100" style="display:none;" ><p>Quel(s) est les métrages de(s) réseau(x) qu\'il doit être amené dans la pièce concernée ?</p>';
					}
					elseif ( $res['id_question']==104 )
					{
						$affichQ.='</div>';
					}
				}
			}
		}
		elseif ( $ScatID==11 ) // Revêtement de sol : carrelage 
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$ScatID.' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==19 )
					{
						$affichQ.='<div id="suite_quest_19" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
			}
		}
		elseif ( $ScatID==7 ) // Revêtement de murs et plafond : Murs intérieur 
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$ScatID.' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==9 )
					{
						$affichQ.='<div id="suite_quest_9" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					elseif ( $res['id_question']==10 )
					{
						$affichQ.='<div id="suite_quest_10" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
			}
		}
		else 
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$ScatID.' ORDER BY ordre,id_question ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
		}
		$list_Quest='<div id="question_'.$_POST['idCat'].'_'.$ScatID.'">'.$affichQ.'</div>';
		echo '<div id="menu_scat_quest_'.$_POST['idCat'].'">'.$menu_scat.'<div style="clear:both;"></div>'.$list_Quest.'</div>';
	}
	elseif ( $_POST['prix']=='affichQuest' )
	{
		if ( $_POST['idSCat']==28 ) // Porte : Porte + Portail + Porte de garage
		{
			// Porte
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ1='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ1.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			// Portail
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie=32 ORDER BY ordre ASC ');$affichQ2='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ2.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			// Porte de garage
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie=33 ORDER BY ordre ASC ');$affichQ3='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ3.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			$affichQ='
					  <strong>Porte : </strong><span id="s_s_28_1" style="cursor:pointer;" onClick="return affich_suite(\'28_1\');" >[+]</span><div id="q_s_28_1" style="display:none;">
					  '.$affichQ1.'
					  </div><br /><strong>Portail : </strong><span id="s_s_28_2" style="cursor:pointer;" onClick="return affich_suite(\'28_2\');" >[+]</span><div id="q_s_28_2" style="display:none;">
					  '.$affichQ2.' 
					  </div><br /><strong>Porte de garage : </strong><span id="s_s_28_3" style="cursor:pointer;" onClick="return affich_suite(\'28_3\');" >[+]</span><div id="q_s_28_3" style="display:none;">
					  '.$affichQ3.'
					  </div>';
		}
		elseif ( $_POST['idSCat']==20 ) // Plomberie : Douche
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					if ( $res['id_question']==100 )
					{
						$affichQ.='<div id="suite_quest_100" style="display:none;" ><p>Quel(s) est les métrages de(s) réseau(x) qu\'il doit être amené dans la pièce concernée ?</p>';
					}
					elseif ( $res['id_question']==104 )
					{
						$affichQ.='</div>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==21 ) // Plomberie : Bagnoire
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					if ( $res['id_question']==107 )
					{
						$affichQ.='<div id="suite_quest_107" style="display:none;" ><p>Quel(s) est les métrages de(s) réseau(x) qu\'il doit être amené dans la pièce concernée ?</p>';
					}
					elseif ( $res['id_question']==111 )
					{
						$affichQ.='</div>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==22 ) // Plomberie : Evier
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					if ( $res['id_question']==113 )
					{
						$affichQ.='<div id="suite_quest_113" style="display:none;" ><p>Quel(s) est les métrages de(s) réseau(x) qu\'il doit être amené dans la pièce concernée ?</p>';
					}
					elseif ( $res['id_question']==117 )
					{
						$affichQ.='</div>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==23 ) // Plomberie : wc
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					if ( $res['id_question']==119 )
					{
						$affichQ.='<div id="suite_quest_119" style="display:none;" ><p>Quel(s) est les métrages de(s) réseau(x) qu\'il doit être amené dans la pièce concernée ?</p>';
					}
					elseif ( $res['id_question']==121 )
					{
						$affichQ.='</div>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==30 ) // Autre : Escalier + placard
		{
			// Escalier
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ1='';
			while ( $res=$my->arr($req) ) 
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ1.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			// Placard
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie=31 ORDER BY ordre ASC ');$affichQ2='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ2.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			$affichQ=$affichQ1.$affichQ2;
		}
		elseif ( $_POST['idSCat']==41 ) // Volet : Volet + Volet roulant
		{
			// Volet
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ1='';
			while ( $res=$my->arr($req) ) 
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ1.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			// Volet roulant
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie=42 ORDER BY ordre ASC ');$affichQ2='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ2.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
			$affichQ='
					 <strong>Volet : </strong><span id="s_s_41_1" style="cursor:pointer;" onClick="return affich_suite(\'41_1\');" >[+]</span><div id="q_s_41_1" style="display:none;">
					 '.$affichQ1.'
					 </div><br /><strong> Volet Roulant : </strong><span id="s_s_41_2" style="cursor:pointer;" onClick="return affich_suite(\'41_2\');" >[+]</span><div id="q_s_41_2" style="display:none;">
					 '.$affichQ2.'
					 </div>
					 ';
		}
		elseif ( $_POST['idSCat']==43 ) // chauffage : chaudieres + radiateurs + chauffage sol
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';$i=1;
			while ( $res=$my->arr($req) )
			{
				if ( $i==1 )$affichQ.='<strong>Chaudieres : </strong><span id="s_s_43_1" style="cursor:pointer;" onClick="return affich_suite(\'43_1\');" >[+]</span><div id="q_s_43_1" style="display:none;">';
				elseif ( $i==5 )$affichQ.='</div><br /><strong>Radiateurs : </strong><span id="s_s_43_2" style="cursor:pointer;" onClick="return affich_suite(\'43_2\');" >[+]</span><div id="q_s_43_2" style="display:none;">';
				elseif ( $i==9 )$affichQ.='</div><br /><strong>Chauffage sol : </strong><span id="s_s_43_3" style="cursor:pointer;" onClick="return affich_suite(\'43_3\');" >[+]</span><div id="q_s_43_3" style="display:none;">';
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==131 )
					{
						$affichQ.='<div id="suite_quest_131" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
				$i++;
			}
			$affichQ.='</div>';
		}
		elseif ( $_POST['idSCat']==25 ) // Autre : 
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';$i=1;
			while ( $res=$my->arr($req) )
			{
				if ( $i==1 )$affichQ.='<strong>Chauffe eau : </strong><span id="s_s_25_1" style="cursor:pointer;" onClick="return affich_suite(\'25_1\');" >[+]</span><div id="q_s_25_1" style="display:none;">';
				if ( $i==11 )$affichQ.='</div><br /><strong>Alimentation / Evacuation pour électroménager : </strong><span id="s_s_25_2" style="cursor:pointer;" onClick="return affich_suite(\'25_2\');" >[+]</span><div id="q_s_25_2" style="display:none;">';
				if ( $i==12 )$affichQ.='</div><br /><strong>Remplacement d\'une robinetterie : </strong><span id="s_s_25_3" style="cursor:pointer;" onClick="return affich_suite(\'25_3\');" >[+]</span><div id="q_s_25_3" style="display:none;">';
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==134 )
					{
						$affichQ.='<div id="suite_quest_133" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
					elseif ( $res['id_question']==135 )
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					elseif ( $res['id_question']==137 )
					{
						$affichQ.='<div id="suite_quest_136_1" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					elseif ( $res['id_question']==138 )
					{
						$affichQ.='<div id="suite_quest_136_2" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
					elseif ( $res['id_question']==139 )
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					elseif ( $res['id_question']==140 )
					{
						$affichQ.='<div id="suite_quest_136_3" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
				$i++;
			}
			$affichQ.='</div>';
		}
		elseif ( $_POST['idSCat']==36 ) // Maçonnerie : Ouverture mur
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';$i=0;
			while ( $res=$my->arr($req) )
			{
				if ( $i==1 )$affichQ.='<strong>Pour fenetre : </strong><span id="s_s_36_1" style="cursor:pointer;" onClick="return affich_suite(\'36_1\');" >[+]</span><div id="q_s_36_1" style="display:none;">';
				if ( $i==3 )$affichQ.='</div><br /><strong>Pour porte ou porte fenetre : </strong><span id="s_s_36_2" style="cursor:pointer;" onClick="return affich_suite(\'36_2\');" >[+]</span><div id="q_s_36_2" style="display:none;">';
				if ( $i==5 )$affichQ.='</div><br /><strong>Creation d une nouvelle ouverture : </strong><span id="s_s_36_3" style="cursor:pointer;" onClick="return affich_suite(\'36_3\');" >[+]</span><div id="q_s_36_3" style="display:none;">';
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					if ( $res['id_question']==144 )
					{
						$affichQ.='<p>Quel est le type de l\'ouverture ?</p>';
					}
				}
				$i++;
			}
			$affichQ.='</div>';
		}
		elseif ( $_POST['idSCat']==38 ) // Maçonnerie : Ouverture mur
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';$i=1;
			while ( $res=$my->arr($req) )
			{
				if ( $i==1 )$affichQ.='<strong>Par l\'extérieur : </strong><span id="s_s_38_1" style="cursor:pointer;" onClick="return affich_suite(\'38_1\');" >[+]</span><div id="q_s_38_1" style="display:none;">';
				if ( $i==5 )$affichQ.='</div><br /><strong>Par l\'intérieur : </strong><span id="s_s_38_2" style="cursor:pointer;" onClick="return affich_suite(\'38_2\');" >[+]</span><div id="q_s_38_2" style="display:none;">';
				if ( $i==5 )$affichQ.='- Isolation de mur : <span id="s_s_38_3" style="cursor:pointer;" onClick="return affich_suite(\'38_3\');" >[+]</span><div id="q_s_38_3" style="display:none;">';
				if ( $i==8 )$affichQ.='</div><br />- Isolation de plafond : <span id="s_s_38_4" style="cursor:pointer;" onClick="return affich_suite(\'38_4\');" >[+]</span><div id="q_s_38_4" style="display:none;">';
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==152 )
					{
						$affichQ.='<div id="suite_quest_152" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					elseif ( $res['id_question']==153 )
					{
						$affichQ.='<div id="suite_quest_153" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else 
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
				$i++;
			}
			$affichQ.='</div></div>';
		}
		elseif ( $_POST['idSCat']==12 ) // Revêtement de sol : Parquet  
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==173 )
					{
						$affichQ.='<div id="suite_quest_173" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==13 ) // Revêtement de sol : Extérieur  
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';$i=1;
			while ( $res=$my->arr($req) )
			{
				if ( $i==1 )$affichQ.='<strong>Dallage : </strong><span id="s_s_13_1" style="cursor:pointer;" onClick="return affich_suite(\'13_1\');" >[+]</span><div id="q_s_13_1" style="display:none;">';
				if ( $i==7 )$affichQ.='</div><br /><strong>Pavés : </strong><span id="s_s_13_2" style="cursor:pointer;" onClick="return affich_suite(\'13_2\');" >[+]</span><div id="q_s_13_2" style="display:none;">';
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==28 )
					{
						$affichQ.='<div id="suite_quest_28" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					elseif ( $res['id_question']==183 )
					{
						$affichQ.='<div id="suite_quest_183" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
				$i++;
			}
			$affichQ.='</div>';
		}
		elseif ( $_POST['idSCat']==14 ) // Revêtement de sol : Moquette   
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==30 )
					{
						$affichQ.='<div id="suite_quest_30" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==15 ) // Revêtement de sol : Sol plastique   
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==196 )
					{
						$affichQ.='<div id="suite_quest_196" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==44 ) // Revêtement de sol : Autes finitions 
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';$i=1;
			while ( $res=$my->arr($req) )
			{
				if ( $i==1 )$affichQ.='<strong>Plinthe : </strong><span id="s_s_44_1" style="cursor:pointer;" onClick="return affich_suite(\'44_1\');" >[+]</span><div id="q_s_44_1" style="display:none;">';
				if ( $i==3 )$affichQ.='</div><br /><strong>Barre de seuil : </strong><span id="s_s_44_2" style="cursor:pointer;" onClick="return affich_suite(\'44_2\');" >[+]</span><div id="q_s_44_2" style="display:none;">';
				if ( $i==6 )$affichQ.='</div><br /><strong>Renovation parquet : </strong><span id="s_s_44_3" style="cursor:pointer;" onClick="return affich_suite(\'44_3\');" >[+]</span><div id="q_s_44_3" style="display:none;">';
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
				$i++;
			}
			$affichQ.='</div>';
		}
		elseif ( $_POST['idSCat']==8 ) // Revêtement de murs et plafond : Plafond  
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					if ( $res['id_question']==12 )
					{
						$affichQ.='<div id="suite_quest_12" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					elseif ( $res['id_question']==210 )
					{
						$affichQ.='<div id="suite_quest_210" style="display:none;" ><p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p></div>';
					}
					else
					{
						$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
					}
				}
			}
		}
		elseif ( $_POST['idSCat']==9 ) // Revêtement de murs et plafond : Portes et fenetres  
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre,id_question ASC ');$affichQ='';$i=1;
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					if ( $i==1 )$affichQ.='<strong>Portes : </strong><span id="s_s_8_1" style="cursor:pointer;" onClick="return affich_suite(\'8_1\');" >[+]</span><div id="q_s_8_1" style="display:none;">';
					if ( $i==5 )$affichQ.='</div><br /><strong>Portes fenetres : </strong><span id="s_s_8_2" style="cursor:pointer;" onClick="return affich_suite(\'8_2\');" >[+]</span><div id="q_s_8_2" style="display:none;">';
					if ( $i==10 )$affichQ.='</div><br /><strong>Fenetres : </strong><span id="s_s_8_3" style="cursor:pointer;" onClick="return affich_suite(\'8_3\');" >[+]</span><div id="q_s_8_3" style="display:none;">';
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
				$i++;
			}
			$affichQ.='</div>';
		}
		else
		{
			$req=$my->req('SELECT * FROM ttre_questions_prix WHERE id_categorie='.$_POST['idSCat'].' ORDER BY ordre,id_question ASC ');$affichQ='';
			while ( $res=$my->arr($req) )
			{
				if ( $res['id_question']!=8 )
				{
					$quest=$my->req_arr('SELECT * FROM ttre_questions WHERE id_question='.$res['id_question'].' ');
					if ( $quest['type_question']==1 ) $champ='<input onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" type="text" id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onKeyPress="return scanFTouche(event)" />';
					else 
					{
						$champ='<select id="quest_'.$res['id_question'].'" name="quest['.$res['id_question'].']" onchange="function_modif_panier('.$_POST['idCat'].','.$res['id_question'].');" ><option value="0"></option>';
						$req_option=$my->req('SELECT * FROM ttre_questions_option WHERE id_question='.$res['id_question'].' ORDER BY id_option ASC');
						while ( $res_option=$my->arr($req_option) ) $champ.='<option value="'.$res_option['id_option'].'">'.$res_option['option_option'].'</option>';
						$champ.='</select>';
					}
					$affichQ.='<p id="questp_'.$res['id_question'].'">'.$quest['label_question'].' '.$champ.'</p>';
				}
			}
		}
		
		$list_Quest='<div id="question_'.$_POST['idCat'].'_'.$_POST['idSCat'].'">'.$affichQ.'</div>';
		echo $list_Quest;
	}
}
?>

