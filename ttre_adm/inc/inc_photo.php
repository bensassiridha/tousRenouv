<?php
//echo 'test';
function rename_file($nom){
 // enlever les accents    
 $nom = strtr($nom, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
 		 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
 	$nom = preg_replace('/\s+/', '-', $nom);
 // remplacer les caracteres autres que lettres, chiffres et point  par _   
   $nom = preg_replace('/([^.a-z0-9]+)/i', '_', $nom);    // copie du fichier
	return (strtolower($nom));
}

function create_resized($upload_field,$data,$nom=""){
	$msg_upload='';
	/*
	Le tableau data contient les données de redimentionnement de l'image.
	$data[$i]['repertoire'] contient le répertoire destination
	$data[$i]['aspect'] = 0 ou 1. Si 1, le redimentionnement se fait a proportion d'une des tailles
	$data[$i]['sizex'] taille x de redimentionnent
	$data[$i]['sizey'] taille y de redimentionnent
	si $data[$i]['sizex'] et $data[$i]['sizey'] sont vides, l'image n'est pas redimentionnée: copiée taille réelle.
	avec $i = 1..n.
	*/
	//echo "image resized<br>";
	
	if (!$data[1]) return; // aucune définition de destination
	if(!$_FILES[$upload_field]['name']) return; // aucun fichier
	
	$repertoire1=$data[1]['repertoire'];
	$destfile="tmp123456789123";
	
	//echo $_FILES[$upload_field]['tmp_name'];
	
	if($nom=="")
		$destname=rename_file($_FILES[$upload_field]['name']);
	else
		$destname=$nom;
	
	//Test de l'extension
	$path_parts = pathinfo($_FILES[$upload_field]['name']);
	
	/*preg_match('/(...)$/i',$image,$regs); 
	$type = $regs[1]; */

	if(preg_match("/(jpe?g)|(gif)|(png)/i",$path_parts["extension"])){
		//echo($path_parts["extension"]);
		//Envoi de l'image
	
		if (!move_uploaded_file($_FILES[$upload_field]['tmp_name'], $repertoire1. $destfile)) 
			die("Impossible de copier ".$_FILES[$upload_field]['tmp_name']." vers ".$repertoire1. $destfile);
		if($nom=="")
			$destname=rename_file($_FILES[$upload_field]['name']);
		else
			$destname=$nom;
		
		$a=getimagesize($repertoire1.$destfile);
		
		$ratio= $a[0]/$a[1];
		
		//echo $path_parts["extension"];
		switch(strtolower($path_parts["extension"])){ 
			case "gif": 
				$im2 = imagecreatefromgif($repertoire1.$destfile );
				$functionName = 'imagegif';
				$imageQuality = 100;
				break; 
			case "jpg": 
				$im2 = imagecreatefromjpeg($repertoire1.$destfile); 
				$functionName = 'imagejpeg';
				$imageQuality = 100;
				break; 
			case "jpeg": 
				$im2 = imagecreatefromjpeg($repertoire1.$destfile); 
				$functionName = 'imagejpeg';
				$imageQuality = 100;
				break; 
			case "png": 
				$im2 = imagecreatefrompng($repertoire1.$destfile); 
				$functionName = 'imagepng';
				$imageQuality = 9;
				break; 
		}		
		
		foreach ($data as $donnees){
			//echo "création image $i<br>";
			$aspect=$donnees["aspect"];
			$repertoire=$donnees["repertoire"];
			$sizex=$donnees["sizex"];
			$sizey=(isset($donnees["sizey"]))?$donnees["sizey"]:$donnees["sizex"];
			$red2d=(isset($donnees["red2d"]))?true:false;
			if (!($sizex.$sizey)) {// pas d'infos de redimentionnement
			
				if (!copy($repertoire1. $destfile, $repertoire. $destname))
					die("Impossible de copier ".$repertoire1. $destfile." vers ".$repertoire. $destname);
					
				chmod($repertoire1. $destfile,0774);
			}
			else {//des infos de redimentionnement
				if ((!$sizex)||(!$sizey)) $aspect=1;
				if ($aspect==1)	{ // retail la hauteur ou la largeur
					if($red2d && $sizex && $sizey) {
					// on calcule le rapport d'aggrandissement
						// initialisation
						$ratiox = 1; $ratioy = 1;
						// calcul des 2 rapports si necessaire
						$ratiox = $sizex/$a[0];
						$ratioy = $sizey/$a[1];
						// On récupère le plus petit
						$ratioUtilise = min($ratiox, $ratioy);
						$sizex = $a[0] * $ratioUtilise;
						$sizey = $a[1] * $ratioUtilise;
					} elseif ($sizex) {
						$sizey=floor($sizex/$ratio);
					} else {
						$sizex = floor($sizey*$ratio);
					}
				} 
				else if ($aspect==2)	{ // taille max horizontal et vertical
					$ratio_image = $ratio;
					$ratio_retail = $sizex / $sizey;
					if($ratio_retail>$ratio_image){
						$sizex=floor($sizey*$ratio_image);
					}
					else{
						$sizey=floor($sizex/$ratio_image);
					}

				}
				$im= imagecreatetruecolor($sizex,$sizey);
				imagealphablending($im, false);
				imagesavealpha($im, true);
				imagecopyresampled( $im, $im2, 0, 0, 0, 0, $sizex, $sizey, $a[0], $a[1]);
				
				$functionName($im,$repertoire . $destname,$imageQuality);
				
				chmod($repertoire . $destname,0774);
				
				//echo ("<br>Image créée : $repertoire$destname");
				imagedestroy($im);
			}
		}
		unlink($repertoire1."/".$destfile);
		
		$msg_upload="L'image a été envoyée avec succès !";
		
		return $destname;
		//renvoie le nom de l'image créée.
	}else{
	$msg_upload="Echec de l'envoi de l'image, format incorrect (jpeg ou jpg obligatoire) !";
	}
}

function resize_file($srcpath,$fichier,$data,$nom="")
{
	$msg_upload='';
	/*
	Le tableau data contient les données de redimentionnement de l'image.
	$data[$i]['repertoire'] contient le répertoire destination
	$data[$i]['aspect'] = 0 ou 1. Si 1, le redimentionnement se fait a proportion d'une des tailles
	$data[$i]['sizex'] taille x de redimentionnent
	$data[$i]['sizey'] taille y de redimentionnent
	si $data[$i]['sizex'] et $data[$i]['sizey'] sont vides, l'image n'est pas redimentionnée: copiée taille réelle.
	avec $i = 1..n.
	*/
	//echo "<p>$fichier<br></p>\n";
	
	$file=$srcpath.$fichier;
	
	if (!$data[1]) return; // aucune définition de destination
	if(!$fichier) return; // aucun fichier
	
	$repertoire1=$data[1]['repertoire'];
	$destfile="tmp123456789123";
	
	//echo $_FILES[$upload_field]['tmp_name'];
	
	if($nom=="")
		$destname=rename_file($fichier);
	else
		$destname=$nom;
	
	//Test de l'extension
	$path_parts = pathinfo($fichier);
	
	
	//eregi("(...)$",$image,$regs); $type = $regs[1]; 

	if(eregi("(jpe?g)|(gif)|(png)",$path_parts["extension"])){
		//echo($path_parts["extension"]);
		//Envoi de l'image
	
		if (!copy($file, $repertoire1. $destfile)) 
			die("Impossible de copier ".$file." vers ".$repertoire1. $destfile);
		if($nom=="")
			$destname=rename_file($fichier);
		else
			$destname=$nom;
		
		$a=getimagesize($repertoire1.$destfile);
		
		$ratio= $a[0]/$a[1];
		
		//echo $path_parts["extension"];
		switch(strtolower($path_parts["extension"])){ 
			case "gif": $im2 = imagecreatefromgif($repertoire1.$destfile ); break; 
			case "jpg": $im2 = imagecreatefromjpeg($repertoire1.$destfile); break; 
			case "jpeg": $im2 = imagecreatefromjpeg($repertoire1.$destfile); break; 
			case "png": $im2 = imagecreatefrompng($repertoire1.$destfile); break; 
		}		
		
		foreach ($data as $donnees){
			//echo "création image $i<br>";
			$aspect=$donnees["aspect"];
			$repertoire=$donnees["repertoire"];
			$sizex=$donnees["sizex"];
			$sizey=$donnees["sizey"];
			$red2d=$donnees["red2d"];
			if (!($sizex.$sizey)) {// pas d'infos de redimentionnement
			
				if (!copy($repertoire1. $destfile, $repertoire. $destname))
					die("Impossible de copier ".$repertoire1. $destfile." vers ".$repertoire. $destname);
					
				chmod($repertoire1. $destfile,0774);
			}
			else {//des infos de redimentionnement
				if ((!$sizex)||(!$sizey)) $aspect=1;
				if ($aspect==1)	{ // retail la hauteur ou la largeur
					if($red2d && $sizex && $sizey) {
					// on calcule le rapport d'aggrandissement
						// initialisation
						$ratiox = 1; $ratioy = 1;
						// calcul des 2 rapports si necessaire
						$ratiox = $sizex/$a[0];
						$ratioy = $sizey/$a[1];
						// On récupère le plus petit
						$ratioUtilise = min($ratiox, $ratioy);
						$sizex = $a[0] * $ratioUtilise;
						$sizey = $a[1] * $ratioUtilise;
					} elseif ($sizex) {
						$sizey=floor($sizex/$ratio);
					} else {
						$sizex = floor($sizey*$ratio);
					}
				} 
				else if ($aspect==2)	{ // taille max horizontal et vertical
					$ratio_image = $ratio;
					$ratio_retail = $sizex / $sizey;
					if($ratio_retail>$ratio_image){
						$sizex=floor($sizey*$ratio_image);
					}
					else{
						$sizey=floor($sizex/$ratio_image);
					}

				}
				$im= imagecreatetruecolor($sizex,$sizey);
				
				imagecopyresampled ( $im, $im2, 0, 0, 0, 0, $sizex, $sizey, $a[0], $a[1]);
				
				ImageJPEG($im,$repertoire . $destname);
				
				chmod($repertoire . $destname,0774);
				
				//echo ("<br>Image créée : $repertoire$destname");
				imagedestroy($im);
			}
		}
		unlink($repertoire1."/".$destfile);
		
		$msg_upload="L'image a été envoyée avec succès !";
		
		return $destname;
		//renvoie le nom de l'image créée.
	}else{
	$msg_upload="Echec de l'envoi de l'image, format incorrect (jpeg ou jpg obligatoire) !";
	}
}

function copy_file($upload_field,$dir,$nom="")
{
	if(!$_FILES[$upload_field]['name']) return; // aucun fichier
	$destfile="tmp123456789123";
	if ($dir!="")
	{
		if (!ereg("[/]$",$dir)) $dir.="/";
	}
	//echo $_FILES[$upload_field]['tmp_name'];
	
	if($nom=="")
		$destname=rename_file($_FILES[$upload_field]['name']);
	else
		$destname=$nom;
	if (!move_uploaded_file($_FILES[$upload_field]['tmp_name'], $dir. $destname)) 
			die("Impossible de copier ".$_FILES[$upload_field]['tmp_name']." vers ".$dir. $destname);
	return $destname;
}

function list_dir($path)
{
	$handle=opendir($path);
	if (!$handle) return;
	while($fichier=readdir($handle))
	{
		//echo("$repertoire$subdir$fichier : ".is_dir("$repertoire$subdir$fichier")."<br>");
		if(!is_dir("$path$fichier")&&($fichier!=".")&&($fichier!="..")) 
		{
			$listfic[]=$fichier;
		}
	}
	sort($listfic);
	closedir($handle);
	return $listfic;
	
}?>