<?php
// On d�marre une session
session_start();
/*
Pour cr�er une image, on envoie un en-t�te avec la fonction header() 
pour dire au navigateur qu'on envoie une image
Lorsqu'on va appeler l'image avec <img src="..." /> on utlisera 
bien image.php et non bruit.png
*/
header("Content-Type: text/html");
/**
  mt_rand() g�n�re un nombre al�atoire : cette fonction est 
  plus rapide que rand() de la biblioth�que standard
  sha1() renvoie une chaine crypt�e de son param�tre. Elle est similaire 
  � md5() mais renvoie une chaine plus longue, la probabilit� de 
  collision est donc r�duite
  substr() retourne le segement d'une chaine. Dans notre cas on prend un segment 
  de 5 caract�res en partant du caract�re 0
  On stocke alors la chaine obtenue dans $rand_str
  */
  $rand_str = substr( sha1( mt_rand() ), 0, 5);
  //echo "trace";
// On hash ensuite cette valeur avec md5() puis on stocke ce r�sultat 
//  dans variable de session $_SESSION['valeur_image'] de la session en cours 
  $_SESSION['valeur_image'] = md5($rand_str);
// Afin de personnaliser chacun de nos caract�res, on les stocke un 
 // par un dans des variables
  $char1=substr($rand_str,0,1);
  $char2=substr($rand_str,1,1);
  $char3=substr($rand_str,2,1);
  $char4=substr($rand_str,3,1);
  $char5=substr($rand_str,4,1);
/*
  imagecreatefrompng() cr�e une nouvelle image PNG � partir d'un 
  fichier
  On la stocke dans $image pour pouvoir y mettre ensuite nos caract�res
  */
  $image=imagecreatefrompng("bruit.png");
/*
  putenv() fixe la valeur de la variable d'environnement pour GD. Cette valeur 
  n'existera que durant la vie du script courant, et l'environnement initial sera 
  restaur� lorsque le script sera termin�
  Cette ligne est utile si vous avez des probl�mes lorsque la police de 
  caract�re r�side dans le m�me dossier que le script qui 
  l'utilise
  Remarquez que lorsqu'on utilisera les polices, il faudra enlever l'extension 
  .tff
  */
  putenv('GDFONTPATH=' . realpath('.'));
/*
  glob() retourne un tableau contenant les fichiers trouv�s dans le dossier 
  avec l'extension .ttf
  Vous pouvez donc ajouter autant de police TTF que vous voulez
  */
  $files = glob("*.ttf");
/*
  Pour chaque nom de fichier trouv�, on retire l'extension .tff
  Et on l'ajoute au tableau $font[]
  */
  foreach ($files as $filename) {
  $filename = substr($filename,0,-4); // retire l'extension .tff
  $fonts[] = $filename; // ajoute les noms des polices sans leur extension dans 
  //un tableau
  }
/*
  imagecolorallocate() retourne un identifiant de couleur
  On d�finit les couleurs RVB qu'on va utiliser pour nos polices et on 
  les stocke dans le tableau $colors[]
  Vous pouvez ajouter autant de couleurs que vous voulez
  */
  $colors = array(imagecolorallocate($image, 99,0,0));

/*
  On cr�e la fonction aleatoire() qui va retourner une valeur prise au hasard dans un tableau
  Elle sera utilis�e pour piocher une couleur et une police au hasard pour chaque caract�re
  */
  function aleatoire($tab){
  $max = count($tab)-1;
  $hasard = mt_rand(0,$max);
  return ($tab[$hasard]);
  }
/*
  On met en forme nos caract�res un par un pour les disposer sur notre 
  image d'origine bruit.png
  imagettftext(image, taille_de_la_police, angle, coordonn�e_X_�_partir_du_bord, 
  coordonn�e_Y_�_partir_du_bord, couleur_RVB, police_de_caract�res, 
  texte) dessine un texte avec une police TrueType
  */
  imagettftext($image, 17, -10, 5, 25, aleatoire($colors), "arial.ttf", $char1);
  imagettftext($image, 17, 20, 25, 25, aleatoire($colors), "arial.ttf", $char2);
  imagettftext($image, 17, -35, 45, 25, aleatoire($colors), "arial.ttf", $char3);
  imagettftext($image, 17, 25, 65, 25, aleatoire($colors), "arial.ttf", $char4);
  imagettftext($image, 17, -15, 85, 25, aleatoire($colors), "arial.ttf", $char5);

  // imagepng() cr�e une image PNG en utilisant l'image $image
  imagepng($image);

  //L'image a �t� cr��e, on appelle donc imagedestroy() qui lib�re toute la m�moire associ�e � l'image $image
  imagedestroy($image);
  ?>