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

    case "setDepartToPro":
        setDepartToPro();
        break;



}

/*
 * Affect categorie to pro
 * @url = http://tousrenov.dev/api_rest/pro_depart_manager?method=setDepartToPro
 */
function setDepartToPro (){

    global $pdo;

    $id_user = null;

    if(isset($_POST['id_pro']))
      $id_user = $_POST['id_pro'];
    else
     die('vous devez spécifiez l\'id de user');

    $requete = null;

    //$_Post sous format {pays : 'france' , ... } => il faut decoder
    $cat_departements = json_decode($_POST['departements']);

    foreach ($cat_departements as $val){

       // echo $id_user.' '. $val;

        $req = "INSERT INTO `ttre_client_pro_departements` ( `id_client`,`id_departement`) VALUES
        ( :id, :depart)";

        $requete = $pdo->prepare($req);

        $requete->bindParam(':id',intval($id_user));
       $requete->bindParam(':depart',intval($val));


        if( $requete->execute() ){
            $success = true;
            $msg = 'Les Departements associés ont été affecter Pour '.$id_user;
        } else {
            $success = false;
            $msg = $pdo->errorInfo();
        }

    }


    reponse_json($success, $_POST, $msg);

}






