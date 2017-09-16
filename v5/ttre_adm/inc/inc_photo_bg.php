<?php
function rename_file($nom){
 // enlever les accents    
 $nom = strtr($nom, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
 		 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
 	$nom = preg_replace('/\s+/', '-', $nom);
 // remplacer les caracteres autres que lettres, chiffres et point  par _   
   $nom = preg_replace('/([^.a-z0-9]+)/i', '_', $nom);    // copie du fichier
	return (strtolower($nom));
}
function toExtension($file,$ext)
{return strrev(strstr(strrev($file),".")).$ext;}
function create_resized($upload_field,$data,$nom=""){
	//global $msg_upload;
	$msg_upload = '';
	if (!$data[1]) return; // aucune définition de destination
	if(!$_FILES[$upload_field]['name']) return; // aucun fichier
	$repertoire1=$data[1]['repertoire'];
	$destfile="tmp123456789123";
	if($nom=="")
		$destname=rename_file($_FILES[$upload_field]['name']);
	else
		$destname=$nom;
	$path_parts = pathinfo($_FILES[$upload_field]['name']);
	//eregi("(...)$",$image,$regs); $type = $regs[1]; 
	$destfile.=".".$path_parts["extension"];
	if(eregi("(jpe?g)|(gif)|(png)",$path_parts["extension"])){
		//echo($path_parts["extension"]);
		//Envoi de l'image
	
		if (!move_uploaded_file($_FILES[$upload_field]['tmp_name'], $repertoire1. $destfile)) 
			die("Impossible de copier ".$_FILES[$upload_field]['tmp_name']." vers ".$repertoire1. $destfile);
		
		resize_file2($repertoire1,$destfile,$data,$destname,$upload_field);
		chmod($repertoire1.$destfile,0777);
		unlink($repertoire1.$destfile);
		
		$msg_upload="L'image a été envoyée avec succès !";	
		
		return $destname;
		//renvoie le nom de l'image créée.
	}else{
	$msg_upload="Echec de l'envoi de l'image, format incorrect (jpeg ou jpg obligatoire) !";
	}
}

function resize_file2($srcpath,$fichier,$data,$nom="",$field="")
{
	global $msg_upload;
	$file=$srcpath.$fichier;
	if (!$data[1]) return; // aucune définition de destination
	if(!$fichier) return; // aucun fichier
	$repertoire1=$data[1]['repertoire'];
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
	
		/*if (!copy($repertoire1. "/".$destfile, $repertoire1. "/".$destfile)) 
			die("Impossible de copier ".$file." vers ".$repertoire1. $destfile);*/
		if($nom=="")
			$destname=rename_file($fichier);
		else
			$destname=$nom;
		
		$a=getimagesize($file);
		
		$ratio= $a[0]/$a[1];
		
		//echo $path_parts["extension"];
		switch(strtolower($path_parts["extension"])){ 
			case "gif": $im2 = imagecreatefromgif($file ); break; 
			case "jpg": $im2 = imagecreatefromjpeg($file); break; 
			case "jpeg": $im2 = imagecreatefromjpeg($file); break; 
			case "png": $im2 = imagecreatefrompng($file); break; 
		}		
		
		foreach ($data as $donnees){
			//echo "création image $i<br>";
			if (isset($donnees["exclu"])&&!empty($donnees["exclu"])
			&&in_array($field,explode(" ",$donnees["exclu"]))) continue;
			$aspect=$donnees["aspect"];
			$repertoire=$donnees["repertoire"];
			$sizex=$donnees["sizex"];
			$sizey=(isset($donnees["sizey"]))?$donnees["sizey"]:$donnees["sizex"];
			$red2d=(isset($donnees["red2d"]))?$donnees["red2d"]:false;
			unset($bgcolor,$bgtransparent,$bgimg,$bgsizex,$no_bigger,$bgsizey);
			if (isset($donnees["bg"])&&preg_match("#[0-9a-fA-f]{6}#",$donnees["bg"]))
			{			
			$bgcolor=hexdec($donnees["bg"]);						
			}
			else
			if (isset($donnees["bg"])&&$donnees["bg"]=="transparent")
			{			
			$bgtransparent=true;						
			}
			else
			if (isset($donnees["bg"])&&is_file($donnees["bg"]))
			{			
			$bga=getimagesize($donnees["bg"]);
			switch($bga[2]){ 
			case IMG_GIF: $bgimg = imagecreatefromgif($donnees["bg"]); break; 
			case IMG_JPG: $bgimg = imagecreatefromjpeg($donnees["bg"]); break; 
			case IMG_PNG: $bgimg = imagecreatefrompng($donnees["bg"]); break; 
			}						
			}
			if (isset($donnees["no_bigger"])) $no_bigger=true;
			if (!($sizex.$sizey)) {// pas d'infos de redimentionnement
			
				if (!copy($file, $repertoire. $destname))
					die("Impossible de copier ".$repertoire1. $destfile." vers ".$repertoire. $destname);
					
				chmod($repertoire1. $destname,0777);
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
						if (($ratioUtilise>1)&&isset($no_bigger)&&$no_bigger) $ratioUtilise=1;
						if (isset($bgcolor)||isset($bgtransparent)||isset($bgimg)) {$bgsizex=$sizex;$bgsizey=$sizey;}						
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
				$im= imagecreatetruecolor(isset($bgsizex)?$bgsizex:$sizex,isset($bgsizey)?$bgsizey:$sizey);
				
				if (isset($bgsizex)&&isset($bgsizey)) 
				{				
				if (isset($bgcolor)) imagefill($im,0,0,$bgcolor);
				if (isset($bgimg))
				{
					imagecopy($im,$bgimg,0,0,0,0,$bgsizex,$bgsizey);
					imagedestroy($bgimg);
				}
				imagecopyresampled($im, $im2, ceil(abs($bgsizex-$sizex)/2), 
				ceil(abs($bgsizey-$sizey)/2), 0, 0, $sizex, $sizey, $a[0], $a[1]);
				if (isset($bgtransparent)) 
					{				
					imagetruecolortopalette($im,true,pow(2,16)-2);				
					imagecolortransparent($im,imagecolorallocate($im,0,0,0));
					}
				}
				else
				imagecopyresampled ( $im, $im2, 0, 0, 0, 0, $sizex, $sizey, $a[0], $a[1]);
				
				if (isset($bgtransparent))
				{				
				ImageGIF($im,$repertoire . toExtension($destname,"gif"));
				chmod($repertoire . toExtension($destname,"gif"),0777);
				}
				else
				ImageJPEG($im,$repertoire . $destname);
				
				@chmod($repertoire . $destname,0777);
				
				//echo ("<br>Image créée : $repertoire$destname");
				imagedestroy($im);
			}
		}
		//unlink($repertoire1."/".$destfile);
		
		$msg_upload="L'image a été envoyée avec succès !";
		
		return $fichier;
		//renvoie le nom de l'image créée.
	}else{
	$msg_upload="Echec de l'envoi de l'image, format incorrect (jpeg ou jpg obligatoire) !";
	}
}


?>