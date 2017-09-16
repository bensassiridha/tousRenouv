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

    case "setCatToPro":
        setCatToPro();
        break;



}

/*
 * Affect categorie to pro
 * @url = http://tousrenov.dev/api_rest/pro_cat_manager?method=setCatToPro
 */
function setCatToPro (){

    // dd($_GET);

    global $pdo;

    $id_user = null;

    if(isset($_POST['id_pro']))
      $id_user = $_POST['id_pro'];
    else
     die('vous devez spécifiez l\'id de user');

    $table = "ttre_client_pro";
    $requete = null;

    //$_Post sous format {pays : 'france' , ... } => il faut decoder
    $cat_ids = json_decode($_POST['categories']);

    foreach ($cat_ids as $val){

        $req = "INSERT INTO `ttre_client_pro_categories` ( `id_client`, `id_categorie`) VALUES
        ( :id_client, :id_cat)";

        $requete = $pdo->prepare($req);

        $requete->bindParam(':id_client',$id_user);
        $requete->bindParam(':id_cat',$val);


        if( $requete->execute() ){
            $success = true;
            $msg = 'Les activités ont été affecter Pour '.$id_user;
        } else {
            $success = false;
            $msg = $pdo->errorInfo();
        }

    }


    reponse_json($success, $_POST, $msg);

}






