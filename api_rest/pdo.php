<?php
$hote = '127.0.0.1';
//in case we use a profile port = 4040 .. without 3306
$port = "3306";
$nom_bdd = 'tousrenovcfr';
$utilisateur = 'root';
$mot_de_passe ='';

 $pdo  = null;

try {
	//On test la connexion à la base de donnée
    $pdo = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bdd, $utilisateur, $mot_de_passe, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Uncommen line to show sql error in profiler
   // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(Exception $e) {
	//Si la connexion n'est pas établie, on stop le chargement de la page.
	reponse_json($success, $data, 'Echec de la connexion à la base de données');
    exit();
}