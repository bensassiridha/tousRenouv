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
    echo 'vous devez spécifier ine  methode ';
}



switch ($method){

    case "getAdressesByUser":
        getAdressesByUser();
        break;
    case "addAdresse":
        addAdresse();
        break;
    case "editAdresse":
        editAdresse();
        break;
    case "deleteAdresse":
        deleteAdresse();
        break;


}

/*
 * Get User By passed id
 * @url = http://tousrenov.dev/api_rest/adresse_manager?method=getAdressesByUser&id_user=4627
 */
function getAdressesByUser (){

    global $pdo;

    $id_user = $_GET['id_user'];

    $req = $pdo->prepare("select a.*,v.ville_nom_reel from ttre_client_part_adresses a LEFT JOIN ttre_villes_france v on (a.ville = v.ville_id )where a.id_client = :id");

    $req->bindParam(':id',$id_user);

    if ($req->execute()){
        $res = $req->fetchAll(PDO::FETCH_ASSOC);

        // dd($res);
        $success = true;
        $data['nombre'] = count($res);
        $data['adresses'] = $res;
    }else{
        $success = false;
        $msg = "Une erreur s'est produite";
    }


//Render response with json
    //Render response with json
    reponse_json($success, $data);

}


/*
 * add adresse for user
 * @url = http://tousrenov.dev/api_rest/adresse_manager?method=addAdresse&id_user=4627&num_voie=12 rue&num_appart=12&batiment=bat&code_postal=1234&ville=333&pays=france&statut=1
 */

function addAdresse(){

    global $pdo;

    $req = $pdo->prepare("INSERT INTO `ttre_client_part_adresses` (`id_client`, `num_voie`, `num_appart`, `batiment`, `code_postal`, `ville`, `pays`, `statut`) VALUES (:id_client, :num_voie, :num_appart, :batiment, :code_postal,:ville,:pays,:statut)");

    $req->bindParam(':id_client', $_GET['id_user']);
    $req->bindParam(':num_voie', $_GET['num_voie']);
    $req->bindParam(':num_appart', $_GET['num_appart']);
    $req->bindParam(':batiment', $_GET['batiment']);
    $req->bindParam(':code_postal', $_GET['code_postal']);
    $req->bindParam(':ville', $_GET['ville']);
    $req->bindParam(':pays', $_GET['pays']);
    $req->bindParam(':statut', $_GET['statut']);


    if( $req->execute() ){
        $success = true;
        $msg = 'l\'adresse a été ajouté';
    } else {
        $success = false;
        $msg = $pdo->errorInfo();
    }

    reponse_json($success, $_GET, $msg);

}

/*
 * edit adresse for user
 * @url = http://tousrenov.dev/api_rest/adresse_manager?method=editAdresse&id_user=4627&num_voie=12 rue&num_appart=12&batiment=bat&code_postal=1234&ville=333&pays=france&statut=1&id=4174
 */


function editAdresse(){

    global $pdo;

    //dd($_GET);


    $req = $pdo->prepare("UPDATE `ttre_client_part_adresses` SET `id_client` = :id_client ,`num_voie` = :num_voie, `num_appart`= :num_appart, `batiment` = :batiment, `code_postal` = :code_postal , `ville` = :ville, `pays` = :pays, `statut` = :statut WHERE `id` = :id");


    $req->bindParam(':id', $_GET['id']);
    $req->bindParam(':id_client', $_GET['id_user']);
    $req->bindParam(':num_voie', $_GET['num_voie']);
    $req->bindParam(':num_appart', $_GET['num_appart']);
    $req->bindParam(':batiment', $_GET['batiment']);
    $req->bindParam(':code_postal', $_GET['code_postal']);
    $req->bindParam(':ville', $_GET['ville']);
    $req->bindParam(':pays', $_GET['pays']);
    $req->bindParam(':statut', $_GET['statut']);


    if( $req->execute() ){
        $success = true;
        $msg = 'l\'adresse a été modifié';
    } else {
        $success = false;
        $msg = $pdo->errorInfo();
    }

    reponse_json($success, $_GET, $msg);

}


/*
 * delete adresse for user
 * @url = http://tousrenov.dev/api_rest/adresse_manager?method=deleteAdresse&id=4174
 */
function deleteAdresse(){

    global $pdo;

    $requete = $pdo->prepare("DELETE FROM `ttre_client_part_adresses` WHERE `id` = :id");
    $requete->bindParam(':id', $_GET['id']);

    if( $requete->execute() ){
        $success = true;
        $msg = 'L\'adresse est supprimé';
    } else {
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $_GET, $msg);

}




