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

    case "addEdit":
        addEdit();
        break;



}

/*
 * Get all categorie
 * @url = http://tousrenov.dev/api_rest/category_quote_manager?method=getAllCategory&parent=0
 */
function addEdit (){

    // dd($_GET);

    global $pdo;


    $table = "ttre_client_pro";
    $requete = null;

    //$_Post sous format {pays : 'france' , ... } => il faut decoder
    $pro_model = json_decode($_POST['pro']);


    //In Edit
    if ($_POST['in_edit'] == 1){

        $requete = $pdo->prepare("UPDATE `".$table."` SET 
                                                        `juridique` = :juridique , `raison` = :raison  , `taille` = :taille  ,`num_voie` = :num_voie  , `cadresse` = :cadresse  , `code_postal` = :code_postal  , `ville` = :ville  , `pays` = :pays , 
                                                         `num_sireen` = :num_sireen , `civ` = :civ , `nom` = :nom , `prenom` = :prenom , `telephone` = :telephone ,
                                                          `fax` = :fax , `email` = :email , `fichier1` = :fichier1 ,
                                                          `fichier2` = :fichier2 , `fichier3` = :fichier3 , `newsletter` = :newsletter , `stat_valid_zone` = :stat_valid_zone ,
                                                          `stat_valid_general` = :stat_valid_general 
                                                           WHERE `id` = :id");

    }
    //In Add
    else{


        $req = "INSERT INTO `ttre_client_pro` ( `date_inscription`, `juridique`, `raison`, `taille`, `num_voie`, `cadresse`, `code_postal`, `ville`, `pays`, `num_sireen`, `civ`, `nom`, `prenom`, `telephone`, `fax`, `email`, `fichier1`, `fichier2`, `fichier3`, `mdp`, `newsletter`, `stat_valid_general`, `stat_valid_zone`) VALUES
        ( :date, :juridique, :raison,:taille, :num_voie, :cadresse, :code_postal, :ville, :pays, :num_sireen, :civ, :nom, :prenom, :telephone, :fax, :email, :fichier1, :fichier2, :fichier3, :mdp, :newsletter, :stat_valid_zone, :stat_valid_general)";

        $requete = $pdo->prepare($req);


      //dd($pro_model->nom);

        $champ = 'frer';
        $cham = 1;

    }


    if($_POST['in_edit'] == 0){
        $requete->bindParam(':date',date());

        $requete->bindParam(':mdp',md5($pro_model->mdp));
    }

    if($_POST['in_edit'] == 1){
        $requete->bindParam(':id',$pro_model->id);

    }

    $requete->bindParam(':juridique',$pro_model->juridique);
    $requete->bindParam(':raison',$pro_model->raison);
    $requete->bindParam(':taille',$pro_model->taille);
    $requete->bindParam(':num_voie',$pro_model->num_voie);
    $requete->bindParam(':cadresse',$pro_model->cadresse);
    $requete->bindParam(':code_postal',$pro_model->code_postal);
    $requete->bindParam(':ville',$pro_model->ville);
    $requete->bindParam(':pays',$pro_model->pays);
    $requete->bindParam(':num_sireen',$pro_model->num_sireen);
    $requete->bindParam(':civ',$pro_model->civ);
    $requete->bindParam(':nom',$pro_model->nom);
    $requete->bindParam(':prenom',$pro_model->prenom);
    $requete->bindParam(':telephone',$pro_model->telephone);
    $requete->bindParam(':fax',$pro_model->fax);
    $requete->bindParam(':email',$pro_model->email);
    $requete->bindParam(':fichier1',$pro_model->fichier1);
    $requete->bindParam(':fichier2',$pro_model->fichier2);
    $requete->bindParam(':fichier3',$pro_model->fichier3);
    $requete->bindParam(':newsletter',$pro_model->newsletter);
    $requete->bindParam(':stat_valid_zone',$pro_model->stat_valid_zone);
    $requete->bindParam(':stat_valid_general',$pro_model->stat_valid_general);



    if( $requete->execute() ){
        $success = true;
        $_POST['id'] = $pdo->lastInsertId();
        $msg = 'l\'N a été modifier';
    } else {
        $success = false;
        $msg = $pdo->errorInfo();
    }

    reponse_json($success, $_POST, $msg);

}






