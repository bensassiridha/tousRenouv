<?php

	class formulaire
	{
		
		function formulaire($class_tableau,$action,$titre='',$nom='',$onsubmit='',$classe_bouton,$champs,$classe_libele,$champs_obligatoire,$classe_libele_obligatoire)
		{
			$this->conteneur = array();
			$this->nb_composants = 0;
			
			$this->bouton = $classe_bouton;
			$this->champs = $champs;
			$this->libele = $classe_libele;
			$this->champs_obligatoire = $champs_obligatoire;
			$this->libele_obligatoire = $classe_libele_obligatoire;
			
			/*---	Compteur pour la génération automatique du traitement	---*/
			$this->compteur_text = 0;
			$this->valeurs_text = array();
			$this->compteur_pass = 0;
			$this->valeurs_pass = array();
			$this->compteur_photo = 0;
			$this->valeurs_photo = array();
			$this->compteur_files = 0;
			$this->valeurs_files = array();
			$this->compteur_hidden = 0;
			$this->valeurs_hidden = array();
			$this->compteur_check = 0;
			$this->valeurs_check = array();
			$this->compteur_radio = 0;
			$this->valeurs_radio = array();
			$this->compteur_textarea = 0;
			$this->valeurs_textarea = array();
			$this->compteur_select = 0;
			$this->valeurs_select = array();
			$this->compteur_captcha = 0;
			$this->valeurs_captcha = array();
			
			/*---	Création du formulaire	---*/
			$this->conteneur[] = '<form action="'.$action.'" name="'.$nom.'" onSubmit="'.$onsubmit.'" method="post" enctype="multipart/form-data">'."\n";
			if(!empty($titre))
				$this->conteneur[] = "\t".$titre."\n";
			$this->conteneur[] = "\t".'<table class="'.$class_tableau.'">'."\n";
			return $this->conteneur;
		}
		
		function creer_libele($lib,$obl)
		{
			if($obl == true)
				$tempo = "\t\t".'<tr><td align="right"><label class="'.$this->libele_obligatoire.'">'.$lib.' : </label></td>';
			else
				$tempo = "\t\t".'<tr><td align="right"><label class="'.$this->libele.'">'.$lib.' : </label></td>';
			
			return $tempo;
		}
		
		function calculer_param($type,$lib)
		{
			switch($type)
			{
				case 0:
					$this->compteur_text++;
					$this->valeurs_text[] = $lib;
				break;
				case 1:
					$this->compteur_pass++;
					$this->valeurs_pass[] = $lib;
				break;
				case 2:
					$this->compteur_photo++;
					$this->valeurs_photo[] = $lib;
				break;
				case 3:
					$this->compteur_files++;
					$this->valeurs_files[] = $lib;			
				break;
				case 4:
					$this->compteur_hidden++;
					$this->valeurs_hidden = $lib;
				break;
				case 5:
					$this->compteur_check++;
					$this->valeurs_check[] = $lib;
				break;
				case 6:
					$this->compteur_radio++;
					$this->valeurs_radio[] = $lib;
				break;
				case 7:
					$this->compteur_select++;
					$this->valeurs_select[] = $lib;
				break;
				case 8:
					$this->compteur_captcha++;
					$this->valeurs_captcha[] = $lib;
				break;
				case 9:
					$this->compteur_textarea++;
					$this->valeurs_textarea[] = $lib;
				break;
			}
		}
		function tinyMCE($libele,$nom,$value='')
		{
			formulaire::calculer_param(9,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = '<tr><td align="center" colspan="2"><b>'.$libele.'</b></td></tr>';
				$this->conteneur[]= '<tr><td align="center" colspan="2"><textarea style="width:100%"  name="'.$nom.'" >'.$value.'</textarea></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
	function datepicker($libele,$nom,$value='',$obl=false,$max=255,$size='25')
		{
			formulaire::calculer_param(10,$nom);
			$taille_deb = sizeof($this->conteneur);
			$this->conteneur[] = formulaire::creer_libele($libele,$obl);
			
			if($obl == false)
    			$this->conteneur[]= '<td align="left">
    			<input type="text" name="'.$nom.'" class="'.$this->champs.'" id="datepicker" size="'.$size.'" maxlenght="'.$max.'" value="'.$value.'"/>';
				else
				    $this->conteneur[]= '<td align="left">
    			<input type="text" name="'.$nom.'" class="'.$this->champs_obligatoire.'" id="datepicker" size="'.$size.'" maxlenght="'.$max.'" value="'.$value.'"/>';
			
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
			
		}
		function datepicker1($libele,$nom,$value='',$obl=false,$max=255,$size='25')
		{
			formulaire::calculer_param(10,$nom);
			$taille_deb = sizeof($this->conteneur);
			$this->conteneur[] = formulaire::creer_libele($libele,$obl);
			
			if($obl == false)
    			$this->conteneur[]= '<td align="left">
    			<input type="text" name="'.$nom.'" class="'.$this->champs.'" id="datepicker1" size="'.$size.'" maxlenght="'.$max.'" value="'.$value.'"/>';
				else
				    $this->conteneur[]= '<td align="left">
    			<input type="text" name="'.$nom.'" class="'.$this->champs_obligatoire.'" id="datepicker1" size="'.$size.'" maxlenght="'.$max.'" value="'.$value.'"/>';
			
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
			
		}
		function text($libele,$nom,$ajax='',$obl=false,$value='',$max=255)
		{
			formulaire::calculer_param(0,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				if($obl == false)
					$this->conteneur[] = '<td align="left"><input type="text" name="'.$nom.'" maxlenght="'.$max.'" value="'.$value.'" class="'.$this->champs.'" '.$ajax.' /></td></tr>'."\n";
				else
					$this->conteneur[] = '<td align="left"><input type="text" name="'.$nom.'" maxlenght="'.$max.'" value="'.$value.'" class="'.$this->champs_obligatoire.'" '.$ajax.' /></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function text_datepicker($libele,$nom,$ajax='',$obl=false,$value='',$max=255)
		{
			formulaire::calculer_param(0,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				if($obl == false)
					$this->conteneur[] = '<td align="left"><input type="text" name="'.$nom.'" maxlenght="'.$max.'" value="'.$value.'" class="datepicker '.$this->champs.'" '.$ajax.' /></td></tr>'."\n";
				else
					$this->conteneur[] = '<td align="left"><input type="text" name="'.$nom.'" maxlenght="'.$max.'" value="'.$value.'" class="datepicker '.$this->champs_obligatoire.'" '.$ajax.' /></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function password($libele,$nom,$obl=false,$max=255)
		{
			formulaire::calculer_param(1,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				if($obl === false)
					$this->conteneur[] = '<td align="left"><input type="password" name="'.$nom.'" maxlenght="'.$max.'" class="'.$this->champs.'" /></td></tr>'."\n";
				else
					$this->conteneur[] = '<td align="left"><input type="password" name="'.$nom.'" maxlenght="'.$max.'" class="'.$this->champs_obligatoire.'" /></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function photo($libele,$nom,$obl=false)
		{
			formulaire::calculer_param(2,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				if($obl == 0)
					$this->conteneur[] = '<td align="left"><input type="file" name="'.$nom.'" class="'.$this->champs.'" /></td></tr>'."\n";
				else
					$this->conteneur[] = '<td align="left"><input type="file" name="'.$nom.'" class="'.$this->champs_obligatoire.'" /></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function fichier($libele,$nom,$obl=false)
		{
			formulaire::calculer_param(3,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				if($obl === 0)
					$this->conteneur[] = '<td align="left"><input type="file" name="'.$nom.'" class="'.$this->champs.'" /></td></tr>'."\n";
				else
					$this->conteneur[] = '<td align="left"><input type="file" name="'.$nom.'" class="'.$this->champs_obligatoire.'" /></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function hidden($libele,$nom,$value)
		{
			formulaire::calculer_param(4,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = "\t\t".'<tr><td colspan="2"><input type="hidden" name="'.$nom.'" value="'.$value.'" /></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}		
		
		function check($libele,$nom,$valeur,$value,$checked,$obl=false)
		{
			formulaire::calculer_param(5,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				$this->conteneur[] = '<td align="left">';
				$this->conteneur[] = '<input type="checkbox" value="'.$valeur.'" name="'.$nom.'"';
				if (!empty($checked))
				{
					$this->conteneur[] = 'checked="checked"';
				}
				$this->conteneur[] = ' /> '.$value.' ';
				$this->conteneur[] = '</td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function check_cu($libele,$nom,$tableau,$selection,$valeur,$contenu,$obl=false)
		{
			formulaire::calculer_param(5,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				$this->conteneur[] = "\t\t".'<td align="left">';
		
					if(in_array($selection,$tableau))
						$this->conteneur[] = '<input type="checkbox" value="'.$valeur.'" checked="checked" name="'.$nom.'" />'.$contenu.' ';
					else
						$this->conteneur[] = '<input type="checkbox" value="'.$valeur.'" name="'.$nom.'" />'.$contenu.' ';
				
				$this->conteneur[] = '</td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function radio($libele,$nom,$tableau,$obl=false)
		{
			formulaire::calculer_param(6,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				$this->conteneur[]= '<td align="left">';
				foreach($tableau as $cle => $value)
				{
					$this->conteneur[] = '<input type="radio" value="'.$cle.'" name="'.$nom.'" />'.$value.' ';
				}
				$this->conteneur[] = '</td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function radio_cu($libele,$nom,$tableau,$search,$obl=false)
		{
			formulaire::calculer_param(6,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				$this->conteneur[]= '<td align="left">';
				foreach($tableau as $cle => $value)
				{	
					if($search == $cle)
						$this->conteneur[] = '<input type="radio" checked="checked" value="'.$cle.'" name="'.$nom.'" />'.$value.' ';
					else
						$this->conteneur[] = '<input type="radio" value="'.$cle.'" name="'.$nom.'" />'.$value.' ';
				}
				$this->conteneur[] = '</td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function select($libele,$nom,$tableau,$onchange='',$obl=false)
		{
			formulaire::calculer_param(7,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				$this->conteneur[]= '<td align="left">';
				$this->conteneur[] = '<select name="'.$nom.'" id="'.$nom.'" onchange="'.$onchange.'" class="'.$this->champs.'">'."\n";
				foreach($tableau as $cle => $value)
					$this->conteneur[] = "\t\t\t".'<option value="'.$cle.'">'.$value.'</option>'."\n";
			$this->conteneur[] = '</select></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
/*
$tab['Swedish'][1]='Volvo';
$tab['Swedish'][2]='Saab';
$tab['German'][3]='Mercedes';
$tab['German'][4]='Audi';

echo'<select>';
foreach($tab as $cle => $value)
{
	echo'<optgroup label="'.$cle.'">';
	foreach($value as $clee => $valuee)
	{
		echo'<option value="'.$clee.'">'.$valuee.'</option>';
	}
	echo'</optgroup>';
}
echo'</select>';
*/		
		function selectGroup($libele,$nom,$tableau,$search='',$onchange='',$obl=false)
		{
			formulaire::calculer_param(7,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				$this->conteneur[]= '<td align="left">';
				$this->conteneur[] = '<select name="'.$nom.'" id="'.$nom.'" onchange="'.$onchange.'" class="'.$this->champs.'">'."\n";
//				$this->conteneur[] = "\t\t\t".'<option value="0"></option>'."\n";
				foreach($tableau as $cle => $value)
				{
					$this->conteneur[]= '<optgroup label="'.$cle.'">';
					foreach($value as $clee => $valuee)
					{
						if($clee == $search)
							$this->conteneur[] = "\t\t\t".'<option selected="selected" value="'.$clee.'">'.$valuee.'</option>'."\n";
						else
							$this->conteneur[] = "\t\t\t".'<option value="'.$clee.'">'.$valuee.'</option>'."\n";
					}
					$this->conteneur[]= '</optgroup>';
				}
			$this->conteneur[] = '</select></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function select_cu($libele,$nom,$tableau,$search,$onchange='',$obl=false)
		{
			formulaire::calculer_param(7,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,$obl);
				$this->conteneur[]= '<td align="left">';
				$this->conteneur[] = '<select name="'.$nom.'" onchange="'.$onchange.'">'."\n";
				foreach($tableau as $cle => $value)
				{
					if($cle == $search)
						$this->conteneur[] = "\t\t\t".'<option selected="selected" value="'.$cle.'">'.$value.'</option>'."\n";
					else
						$this->conteneur[] = "\t\t\t".'<option value="'.$cle.'">'.$value.'</option>'."\n";
				}
				$this->conteneur[] = '</select></td></tr>'."\n";				
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		
		function captcha($nom)
		{
			formulaire::calculer_param(8,$nom);
			$this->conteneur[] = '<tr>'."\n";
			$this->conteneur[] = '<td align="left">';
			$this->conteneur[] = '<label class="'.$this->classe_libele_obligatoire.'"><img src="Captcha/validation.php" border="0" /></label></td>'."\n";
			$this->conteneur[] = '<td align="left"><input class="'.$this->champs_obligatoire.'" type="text" name="'.$nom.'" /></td>'."\n";
			$this->conteneur[] = '</tr>'."\n\n";
		}
		
		function textarea($libele,$nom,$value='',$cols=25,$rows=5)
		{
			formulaire::calculer_param(9,$nom);
			$taille_deb = sizeof($this->conteneur);
				$this->conteneur[] = formulaire::creer_libele($libele,0);
				$this->conteneur[]= '<td align="left"><textarea class="'.$this->champs.'" name="'.$nom.'" cols="'.$cols.'" rows="'.$rows.'">'.$value.'</textarea></td></tr>'."\n";
			$taille_fin = sizeof($this->conteneur);
			return $this->conteneur;
		}
		
		function vide($content)
		{
			$this->conteneur[] = $content;
			return $this->conteneur;
		}
		
		function separation()
		{
			$this->conteneur[] = '<tr><td colspan="2" class="separation"></td></tr>';
			return $this->conteneur;
		}
		
		
		function fckeditor($label,$contenu='',$nom="message",$width="100%",$height="300",$toolbar='Default')
		{
			include_once("fckeditor/fckeditor.php");
			$editeur = new FCKeditor($nom);
			$editeur->BasePath='fckeditor/';
			$editeur->Value = $contenu;
			$editeur->ToolbarSet=$toolbar;
			$editeur->Width  = $width;
			$editeur->Height = $height;
			$this->conteneur[] = '<tr><td align="center" colspan="2">'.$label.'</td></tr><tr><td align="center" colspan="2">'.$editeur->Create().'</td></tr>';
			return $this->conteneur;
		}
		
		function afficher($text,$name='',$reset=false)
		{
			if($name == '')$name='valid';
			
			if($reset == true)
				$this->conteneur[] = '<tr><td></td>
				<td><input type="reset" value="RAZ" class="'.$this->bouton.'" /><input type="submit" value="'.$text.'" class="'.$this->boutons.'" /></td></tr>';
			else							  
				$this->conteneur[] = '<tr><td></td>
				<td><input name="'.$name.'" type="submit" value="'.$text.'" class="'.$this->bouton.'" /></td></tr>';	
			
			$this->conteneur[] = '</table>
			
			<p class="note_obl '.$this->libele_obligatoire.'">Les champs en rouge sont obligatoires.</p></form>';
			foreach($this->conteneur as $cle => $value)
				echo $value;
		}
		function afficher1($text,$reset=false)
		{
			if($reset == true)
				$this->conteneur[] = '<tr><td></td>
				<td><input type="reset" value="RAZ" class="'.$this->bouton.'" /><input type="submit" value="'.$text.'" class="'.$this->boutons.'" /></td></tr>';
			else							  
				$this->conteneur[] = '<tr><td></td>
				<td><input type="submit" value="'.$text.'" class="'.$this->bouton.'" /></td></tr>';	
			
			$this->conteneur[] = '</table>
			
			</form>';
			foreach($this->conteneur as $cle => $value)
				echo $value;
		}
		function afficher_simple()
		{			
			$this->conteneur[] = '</table></form>';
			foreach($this->conteneur as $cle => $value)
				echo $value;			
		}
	}

?>