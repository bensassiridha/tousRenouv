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

    case "getAllCategory":
        getAllCategory();
        break;



}

/*
 * Get all categorie
 * @url = http://tousrenov.dev/api_rest/category_quote_manager?method=getAllCategory&parent=0
 */
function getAllCategory (){

    global $pdo;


    $parent = $_GET['parent'];

    $req = $pdo->prepare("select * from `ttre_categories` WHERE parent = :parent");

    $req->bindParam(':parent',$parent);


    if ($req->execute()){
        $res = $req->fetchAll(PDO::FETCH_ASSOC);

        // dd($res);
        $success = true;
        $data['nombre'] = count($res);
        $data['categories'] = $res;
    }else{
        $success = false;
        $msg = "Une erreur s'est produite";
    }


//Render response with json
    //Render response with json
    reponse_json($success, $data);

}






