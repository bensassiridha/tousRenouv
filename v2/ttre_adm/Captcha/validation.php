<?php
// On démarre une session
session_start();

header("Content-Type: text/html");

  $rand_str = substr( sha1( mt_rand() ), 0, 5);

  $_SESSION['valeur_image'] = md5($rand_str);
  //$_SESSION['valeur_reel'] = $rand_str;

  $char1=substr($rand_str,0,1);
  $char2=substr($rand_str,1,1);
  $char3=substr($rand_str,2,1);
  $char4=substr($rand_str,3,1);
  $char5=substr($rand_str,4,1);

  $image=imagecreatefrompng("bruit.png");

  putenv('GDFONTPATH=' . realpath('.'));

  $files = glob("*.ttf");

  foreach ($files as $filename)
  {
	  $filename = substr($filename,0,-4);
	  $fonts[] = $filename;
  }

  $colors = array(imagecolorallocate($image,0,0,0),imagecolorallocate($image,102,102,102),imagecolorallocate($image,178,81,124));

  function aleatoire($tab)
  {
	  $max = count($tab)-1;
	  $hasard = mt_rand(0,$max);
	  return ($tab[$hasard]);
  }

  imagettftext($image, 25, -10, 10, 35, aleatoire($colors), "arial.ttf", $char1);
  imagettftext($image, 25, 20, 40, 35, aleatoire($colors), "arial.ttf", $char2);
  imagettftext($image, 25, -35, 60, 35, aleatoire($colors), "arial.ttf", $char3);
  imagettftext($image, 25, 25, 100, 35, aleatoire($colors), "arial.ttf", $char4);
  imagettftext($image, 25, -15, 120, 35, aleatoire($colors), "arial.ttf", $char5);

  // imagepng() crée une image PNG en utilisant l'image $image
  imagepng($image);

  //L'image a été créée, on appelle donc imagedestroy() qui libère toute la mémoire associée à l'image $image
  imagedestroy($image);
  ?>