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

    case "getAllDepartement":
        getAllDepartement();
        break;



}

/*
 * Get all categorie
 * @url = http://tousrenov.dev/api_rest/departement_manager?method=getAllDepartement
 */
function getAllDepartement (){

    global $pdo;



    $req = $pdo->prepare("select * from `ttre_departement_france`");

    if ($req->execute()){
        $res = $req->fetchAll(PDO::FETCH_ASSOC);

        // dd($res);
        $success = true;
        $data['nombre'] = count($res);
        $data['departements'] = $res;
    }else{
        $success = false;
        $msg = "Une erreur s'est produite";
    }


//Render response with json
    //Render response with json
    reponse_json($success, $data);

}






