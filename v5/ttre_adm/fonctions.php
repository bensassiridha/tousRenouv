<?php
require_once('mysql.php');
require_once('phpmailer/class.phpmailer.php');

function img_transfert($fichier,$tmp,$type,$repertoire)
{
	$taille= getimagesize($tmp);
	/*if ($taille [1] > 1000 || $taille [0] > 1500)
	{
		echo "<script>alert('Votre image est trop grande. Merci de ne pas dépasser 1500px de largeur et 1000px de hauteur.')</script>";
		exit;
	}
	*/
	//cree une nouvelle image vierge
	$vierge=imagecreatetruecolor($taille[0],$taille[1]);
	
	switch( strtolower($type))
	{
		case "image/jpg"  : $image=imagecreatefromjpeg($tmp); break;
		case "image/jpeg" : $image=imagecreatefromjpeg($tmp); break;
		case "image/gif"  : $image=imagecreatefromgif($tmp); break;
		case "image/png"  : $image=imagecreatefrompng($tmp); break;		
		case "image/x-png":	$image=imagecreatefrompng($tmp); break;														
		case "image/pjpeg": $image=imagecreatefromjpeg($tmp); break;	
		case "image/pjpg" : $image=imagecreatefromjpeg($tmp); break;								
	}							
	
	imagecopyresized($vierge,$image,0,0,0,0,$taille[0],$taille[1],$taille[0],$taille[1]);
	
	imagejpeg($vierge,$repertoire."$fichier");
	imagedestroy($vierge);
}
function traitementFormat($filename,$nom,$largeur,$hauteur,$repertoire){
    if($_FILES[$filename]['name']!=''){
        # test extension
        $typeok = false;
        $type = strtolower($_FILES[$filename]['type']);
        if ($type != 'image/jpg' && $type != 'image/jpeg' && $type != 'image/gif' &&
        $type != 'image/png' && $type != 'image/x-png' && $type != 'image/pjpeg' && $type != 'image/pjpg')
            echo '<script>alert("Veuillez sélectionner un fichier de type JPG, GIF ou PNG"")</script>';
        #
   
        else{
            $ratio = $largeur / $hauteur;
           
            $ext = explode('.',$_FILES[$filename]['name']);
            $nomphoto = $nom.".".$ext[(sizeof($ext)-1)];
           
            #transférer photo sur serveur
            img_transfert($nomphoto,$_FILES[$filename]['tmp_name'],$_FILES[$filename]["type"],$repertoire);
           
            #redimensionner
           
            $taille = getimagesize($repertoire."$nomphoto");
            $ratio_dest = $taille[0]/$taille[1];
            # traitement paysage
            if ($largeur > $hauteur){
                # ratio plus grand que ratio d'origine : redimensionner largeur
                if ($ratio_dest > $ratio){
                    redimage($repertoire."$nomphoto",$repertoire."$nomphoto",$largeur,'');
                }
                # ratio plus petit que ratio d'origine : redimensionner hauteur
                else{
                    redimage($repertoire."$nomphoto",$repertoire."$nomphoto",'',$hauteur);   
                }           
            }
            # traitement portrait
            elseif ($hauteur > $largeur){
                # ratio plus grand que ratio d'origine : redimensionner hauteur
                if ($ratio_dest < $ratio){
                    redimage($repertoire."$nomphoto",$repertoire."$nomphoto",'',$hauteur);   
                }
                # ratio plus grand que ratio d'origine : redimensionner largeur
                else{
                    redimage($repertoire."$nomphoto",$repertoire."$nomphoto",$largeur,'');
                }           
            }
            # traitement carré
            else{
                # largeur plus grande que hauteur : redimensionner largeur
                if ($taille[0] > $taille[1]){
                    redimage($repertoire."$nomphoto",$repertoire."$nomphoto",$largeur,'');
                }
                # hauteur plus grande que largeur : redimensionner hauteur
                else{
                    redimage($repertoire."$nomphoto",$repertoire."$nomphoto",'',$hauteur);
                }
            }   
                       
        }
    }
    else
        $nomphoto = '';
    return $nomphoto;
}
function uploadFiche($filename,$nom,$repertoire)
{
if($_FILES[$filename]["name"]!="")
	{
		# test extension
		$ext = explode('.',$_FILES[$filename]["name"]);
		$type=$ext[(sizeof($ext)-1)];
		if ($type != "pdf"&&$type != "doc"&&$type != "xls"&&$type != "ppt"&&$type != "pptx"&&$type != "docx"&&$type != "xlsx")
		{
			echo "<script>alert('Vérifiez le type du fichier')</script>";
		}
	
		else
		{
			$rand = substr(mt_rand(),1,3);
			$ext = explode('.',$_FILES[$filename]["name"]);
			$nomvideo = $nom.$rand.".".$ext[(sizeof($ext)-1)];
			
		}
		
	}
	if (move_uploaded_file($_FILES[$filename]["tmp_name"],$repertoire.$nomvideo))
	{
	return($nomvideo);
	}
}
function redimage($img_src,$img_dest,$dst_w,$dst_h)
{	
	# Infos sur la source
	$type = substr($img_src,-3);
	$size = getimagesize($img_src);
	
	/*if($size[0] > 1280 || $size[1] > 1024)
	{
		echo '<script language=javascript> alert ("L\'image est trop grande.");</script>';
		echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="javascript:history.go(-1)" </SCRIPT>';
		exit;
	}*/
	
	# Selon le type de source : 
	$source = imagecreatefromjpeg($img_src);
	
	
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	if ($dst_w == '') #largeur arrivée non renseignée
	{
		$dst_w = ($dst_h*$largeur_source)/$hauteur_source;
	}
	if ($dst_h == '') #hauteur arrivée non renseignée
	{
		$dst_h = ($dst_w*$hauteur_source)/$largeur_source;
	}
	
	if ($largeur_source > $dst_w)
	{
		# créer image 
		$destination = imagecreatetruecolor($dst_w, $dst_h);
		
		# créer miniature
		imagecopyresampled($destination, $source, 0, 0, 0, 0, $dst_w, $dst_h, $largeur_source, $hauteur_source);
		
		# enregistrer miniature
		if($type=='jpg'||$type=='JPG'||$type=='peg'||$type=='PEG')
		{
			imagejpeg($destination,$img_dest);
		}
		elseif($type=='gif'||$type=='GIF')
		{
			imagegif($destination,$img_dest);
		}
		else
		{
			imagepng($destination,$img_dest);
		}
	}
	else
	{
		$destination = imagecreatetruecolor($largeur_source, $hauteur_source);
		imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_source, $hauteur_source, $largeur_source, $hauteur_source);
		if($type=='jpg'||$type=='JPG'||$type=='peg'||$type=='PEG')
		{
			imagejpeg($destination,$img_dest);
		}
		elseif($type=='gif'||$type=='GIF')
		{
			imagegif($destination,$img_dest);
		}
		else
		{
			imagepng($destination,$img_dest);
		}
	}
	imagedestroy($source);
	return $img_dest;
}

function renommer_fichier($fichier)
{
	$dest_fichier = basename($fichier);
	$dest_fichier = strtr($dest_fichier,'ÀÁÂÃÄÅÇÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEIIIIOOOOOUUUUYaaaaaaceeeiiiioooooouuuuyy');
	$dest_fichier = strtr($dest_fichier,' ','_');
	$dest_fichier = time().$dest_fichier;
	return $dest_fichier;
}

function test_extension($fichier)
{
	$extensions_ok = array('jpg','JPG','jpeg','JPEG');
	if(!in_array(substr(strrchr($fichier,'.'),1),$extensions_ok))
	{
		echo '<script language=javascript> alert ("Veuillez s&eacute;lectionner un fichier de type jpeg ou jpg !");</script>';
		echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="javascript:history.go(-1)" </SCRIPT>';
		exit;
	}
}  
function uploadVid($filename,$nom,$repertoire)
{
if($_FILES[$filename]["name"]!="")
	{
		# test extension
		$ext = explode('.',$_FILES[$filename]["name"]);
		$type=$ext[(sizeof($ext)-1)];
		if ($type != "wmv" && $type != "flv" && $type != "avi")
		{
			echo "<script>alert('Vérifiez le type du fichier video')</script>";
		echo '<script>document.location.href="javascript:history.go(-1)" </script>';
		}
	
		else
		{
			$rand = substr(mt_rand(),1,3);
			$ext = explode('.',$_FILES[$filename]["name"]);
			$nomvideo = $nom.$rand.".".$ext[(sizeof($ext)-1)];
			
		}
		
	}
	if (move_uploaded_file($_FILES[$filename]["tmp_name"],$repertoire.$nomvideo))
	{
	return($nomvideo);
	}
}
function uploadmp3($filename,$nom,$repertoire)
{
if($_FILES[$filename]["name"]!="")
	{
		# test extension
		$ext = explode('.',$_FILES[$filename]["name"]);
		$type=$ext[(sizeof($ext)-1)];
		if ($type != "mp3")
		{
			echo "<script>alert('Vérifiez le type du fichier ')</script>";
		echo '<script>document.location.href="javascript:history.go(-1)" </script>';
		}
	
		else
		{
			$rand = substr(mt_rand(),1,3);
			$ext = explode('.',$_FILES[$filename]["name"]);
			$nommp3 = $nom.$rand.".".$ext[(sizeof($ext)-1)];
			
		}
		
	}
	if (move_uploaded_file($_FILES[$filename]["tmp_name"],$repertoire.$nommp3))
	{
	return($nommp3);
	}
}

function uploadImg($filename,$nom,$largeur,$hauteur,$repertoire)
{
	if($_FILES[$filename]["name"]!="")
	{
		# test extension
		$typeok = false;
		$type = strtolower($_FILES[$filename]["type"]);
		if ($type != "image/jpg" && $type != "image/jpeg" && $type != "image/gif" && 
		$type != "image/png" && $type != "image/x-png" && $type != "image/pjpeg" && $type != "image/pjpg")
		{
			echo "<script>alert('Veuillez sélectionner un fichier de type JPG, GIF ou PNG')</script>";
		}
		#
	
		else
		{
			$ext = explode('.',$_FILES[$filename]["name"]);
			$nomphoto = $nom.".".$ext[(sizeof($ext)-1)];
			
			#transférer photo sur serveur
			img_transfert($nomphoto,$_FILES[$filename]["tmp_name"],$_FILES[$filename]["type"],$repertoire);
			
			#redimensionner
			redimage($repertoire."$nomphoto",$repertoire."$nomphoto",$largeur,$hauteur);
			
		}
	}
	else
	{
		$nomphoto = '';
	}
	return $nomphoto;
}

function suppr_speciaux($nom)
{
	$dest = strtr($nom,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ/\'','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy__');
	$dest = strtr($dest,' ','_');
	$dest = strtr($dest,"'","_");
	return $dest;
}

/*
	
	$couleurs	= $conn->req('SELECT * FROM couleurs ORDER BY id_couleur');
	$i = 0;
	while ($infos_couleur = $conn->arr($couleurs))
	{
		$carre	= imagecreatetruecolor(20,20);
		$color	= imagecolorallocate($carre,
		hexdec(substr($infos_couleur['code_hexa'],0,2)),
		hexdec(substr($infos_couleur['code_hexa'],2,2)),
		hexdec(substr($infos_couleur['code_hexa'],4,2)));
		imagefill($carre,0,0,$color);
		if (!is_file('img/carre'.$i.'.png'))
		{
			$couleur    = imagepng($carre,'img/carre'.$i.'.png');
		}
		
		echo '<img src="img/carre'.$i.'.png" />';
		
		$i++;
	}
	*/
function uploadfichier($fileName,$nom_fichier,$uploadDir)
{
    if (!empty($_FILES[$fileName]['name']))
    { 
		if ($_FILES[$fileName]['error']) 
        {
            switch ($_FILES[$fileName]['error'])
            {
                case 1:
                echo '<script>alert("Le fichier dépasse la limite autorisée par le serveur (2 Mo)")</script>';
                break;
                case 3:
                echo '<script>alert("L\'envoi du fichier a été interrompu pendant le transfert. Merci de recommencer ultérieurement.")</script>';
                break;
            }
        }
        else
        { 
			$ext     = explode('.',$_FILES[$fileName]["name"]);
			$jointe  = $nom_fichier.'.'.$ext[1];
			if (move_uploaded_file($_FILES[$fileName]["tmp_name"],$uploadDir.$jointe))
			{
				return $jointe;
			}          
        }
    }
}

function changeImageColor($myImage,$red,$green,$blue) 
{ 
    for($i=0;$i<imagecolorstotal($myImage);$i = $i+1) 
      { 
          $col=imagecolorsforindex($myImage,$i); 
          //nouvelle couleur = couleur_saisie + ancienne_couleur
          $red_set=($red+$col['red']);  
          $green_set=($green+$col['green']); 
          $blue_set=($blue+$col['blue']); 
          if ($red_set > 255) $red_set=255; 
          if ($green_set>255)$green_set=255; 
          if ($blue_set>255)$blue_set=255;
          imagecolorset($myImage,$i,$red_set,$green_set,$blue_set);
      } 
}


function envoimail($dest,$sujet,$message)
{
	$mail = new PHPmailer();
	$mail->IsSMTP();
	$mail->IsHTML(true);
	$mail->Host='smtp2.ict-backbone.com';
	$mail->FromName= " ";
	$mail->From='';	
	$mail->AddAddress($dest);
	$mail->AddBcc("");
	$mail->AddReplyTo('oussamaaniba@gmail.com');	
	$mail->Subject=$sujet;
	$mail->Body='<html>
		<head>
		<style>
		body
		{
			font-family:Arial, Helvetica, sans-serif;
			font-size:12px;
		}
		</style></head>
		
		<body>'.$message.'
			
	<p>Cordialement,<br />
</p> 
	</body>
	</html>';
	return $mail->Send();
}

function alert($message)
{
	echo '<script>alert("'.$message.'")</script>';
}

function rediriger($location)
{	
	echo '<script>window.location="'.$location.'"</script>';
}

function afficher_prix($prix)
{
	return number_format($prix,2);
}
?>