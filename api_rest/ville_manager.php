<?php
/*
 * @author bensassi ridha
 * @url bensassiridha.com
 */
include('template.php');
//require('../mysql.php');$my=new mysql();

if (isset($_GET['method'])){
    $method = $_GET['method'];
}else{
    echo 'vous devez spécifier une  methode ';
}



switch ($method){

    case "getVilleByCp":
    getVilleByCp();
    break;

    case "getVilleByDepartment":
        getVilleByDepartment();
        break;



}

/*
 * Get all Ville by code Postal
 * @url = http://tousrenov.dev/api_rest/ville_manager?method=getVilleByCp&cp=01000
 */
function getVilleByCp (){

    // dd($_GET);

    global $pdo;
    $data = null;


    $table = "ttre_villes_france";
    $requete = null;


      //  $requete = $pdo->prepare("INSERT INTO `ttre_client_pro` (`juridique`, `raison`, `taille`, `num_voie`, `cadresse`, `code_postal`, `ville`, `pays`, `num_sireen`, `civ`, `nom`, `prenom`, `telephone`, `fax`, `email`, `fichier1`, `fichier2`, `fichier3`, `mdp`, `newsletter`, `stat_valid_general`, `stat_valid_zone`) VALUES (:juridique ,:raison,:taille,:num_voie ,:cadresse ,:code_postal ,:ville ,:pays ,:num_sireen ,:civ ,:nom ,:prenom , :telephone ,:fax ,:email ,:fichier1 , :fichier2 ,:fichier3 ,:newslettre,:stat_valid_zone,:stat_valid_general)");


    $req = null;

    if ( ($_GET['cp']>=75001 && $_GET['cp']<=75020) || $_GET['cp']==75116 )
    {
        $req='SELECT * FROM ttre_villes_france WHERE ville_code_postal=75001 ';

    }
    else
    {
        $req = "select * from `ttre_villes_france` WHERE  `ville_code_postal` LIKE :cp ORDER BY ville_id ASC";
    }




        $requete = $pdo->prepare($req);

        $requete->bindParam(':cp',$_GET['cp']);




    if ($requete->execute()){
        $res = $requete->fetchAll(PDO::FETCH_ASSOC);

        // dd($res);
        $success = true;
        $data['nombre'] = count($res);
        $data['villes'] = $res;
    }else{
        $success = false;
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $data, $msg);

}




/*
 * Get all Ville by code Postal
 * @url = http://tousrenov.dev/api_rest/ville_manager?method=getVilleByDepartment&depart=1
 */
function getVilleByDepartment (){

    // dd($_GET);

    global $pdo;
    $data = null;


    $table = "ttre_villes_france";
    $requete = null;

    $req = "select * from `ttre_villes_france` WHERE  `ville_departement` LIKE :depart";

    $requete = $pdo->prepare($req);

    $requete->bindParam(':depart',$_GET['depart']);



    if ($requete->execute()){
        $res = $requete->fetchAll(PDO::FETCH_ASSOC);

        // dd($res);
        $success = true;
        $data['nombre'] = count($res);
        $data['villes'] = $res;
    }else{
        $success = false;
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $data, $msg);

}






