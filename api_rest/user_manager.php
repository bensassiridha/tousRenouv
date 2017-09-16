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
    echo 'vous devez spécifier la methode concernée';
}


switch ($method){

    case "getUserById":
        getUserById();
        break;
    case "auth":
        auth();
        break;
    case "changePassword":
        changePassword();
        break;
    case "changeInformation":
        changeInformation();
        break;


}

/*
 * Get User By passed id (Pro Or Paticular
 * @url = http://tousrenov.dev/api_rest/user_manager?method=getUserById&id_user=4627&isPro=0
 */
function getUserById(){

    global $pdo;

    $id_user = $_GET['id_user'];
    $is_pro = $_GET['isPro'];
    $table = "ttre_client_part";
    $res = null ;

    if($is_pro != "0"){
        $table =  "ttre_client_pro";
    }

    $req = $pdo->prepare("select * from ".$table." where `id` = :id");
    $req->bindParam(':id',$id_user);

    if ($req->execute()){
        $res = $req->fetchAll(PDO::FETCH_ASSOC);

       // dd($res);
        $success = true;
        $data['nombre'] = count($res);
        $data['user'] = $res;
    }else{
        $msg = "Une erreur s'est produite";
        $msg =" welecome";
    }


//Render response with json
    echo json_encode($res);



}

/*
 *  authenticate user (Particular or Professional)
 */

function auth(){

    global $pdo;

 //url esapce par = http://tousrenov.dev/api_rest/user_manager.php?method=auth&email_connexion=bensassiridha@gmail.com&mdp_connexion=ridhaisi&is_pro=0
//url esapce pro  http://tousrenov.dev/api_rest/user_manager?method=auth&email_connexion=henda@henda.com&mdp_connexion=henda&isPro=1
if ( isset($_GET['email_connexion']) &&  isset($_GET['mdp_connexion']) ){

   // dd($_GET);

    //Espace particulier
    if(isset($_GET['isPro']) & $_GET['isPro']== "0" ){

        $req = $pdo->prepare("select * from ttre_client_part where email like :mail and mdp like :password and stat_valid=1");

      //  dd('part');
    }
    //Espace pro
    else{


        $req = $pdo->prepare("select * from ttre_client_pro where email like :mail and mdp like :password");
    }

    $mail = $_GET['email_connexion'];
    $mdp = md5($_GET['mdp_connexion']);

    $req->bindParam(':mail',$mail);
    $req->bindParam(':password', $mdp);

    if ($req->execute()){
        $res = $req->fetchAll();

       // dd($res);

        $success = true;
        $data['nombre'] = count($res);
        $data['user'] = $res;
    }else{
        $msg = "Une erreur s'est produite";
        $msg =" welecome";
    }


//Render response with json
    reponse_json($success, $data);

}
}

/*
 * function to change password
 * @url = http://tousrenov.dev/api_rest/user_manager?method=changePassword&id_user=4627&password=ridhaisi2016&isPro=0
 */
function changePassword(){

    global $pdo;

    $id_user = $_GET['id_user'];
    $isPro = $_GET['isPro'];
    $table = "ttre_client_part";

    if ($isPro == 1) {
     $table = "ttre_client_pro";
    }

        $requete = $pdo->prepare("UPDATE `".$table."` SET `mdp` = :password  WHERE `id` = :id");
        $requete->bindParam(':password', md5($_GET['password']));
        $requete->bindParam(':id', $id_user);


        if( $requete->execute() ){
            $success = true;
            $msg = 'le mot de passe de l\'utilisateur a été modifier';
        } else {
            $msg = "Une erreur s'est produite";
        }

    reponse_json($success, $_POST, $msg);

    }


    /*
    * function to update or add user information
    * @url (espace particulier = http://tousrenov.dev/api_rest/user_manager?method=changeInformation&id_user=4627&isPro=0&etes1=example&precisez1=example&etes2=example&civ=example&nom=example&prenom=example&telephone=example&email=example@example.com&num_voie=example&num_appart=example&batiment=example&code_postal=111&ville=222&pays=tunis&connus=example&precisez2=example&newsletter=1&ref_valid=eeeee&stat_valid=1
    * @url (espace pro = http://tousrenov.dev/api_rest/user_manager?method=changeInformation&id_user=609&isPro=1&juridique=juridique&raison=raison&taille=taille&num_voie=ezezeze&cadresse=rzrre&code_postal=2112&ville=3232&pays=ezzez&num_sireen=num_sireen&civ=civ&nom=nom&prenom=prenom&telephone=121212&fax=fax&email=email@email.com&fichier1=fichier1&fichier2=fichier2&fichier3=fichier3&newsletter=1&stat_valid_zone=1&stat_valid_general=1
    */
    function changeInformation(){

       // dd($_GET);

        global $pdo;

        $id_user = $_GET['id_user'];
        $isPro = $_GET['isPro'];
        $table = "ttre_client_part";
        $requete = null;


         //Espace Pro
        if ($isPro == 1) {

          // the traitement of pro is has deplaced in pro_manager :)

        }
        //Espace Particulier
        else{

            //In Edit
            if ($_GET['id_user']) {
                $requete = $pdo->prepare("UPDATE `" . $table . "` SET 
                                                        `etes1` = :etes1 , `precisez1` = :precisez1  , `etes2` = :etes2  ,
                                                         `civ` = :civ , `nom` = :nom , `prenom` = :prenom , `telephone` = :telephone , `email` = :email ,
                                                          `num_voie` = :num_voie , `num_appart` = :num_appart , `batiment` = :batiment ,
                                                          `code_postal` = :code_postal , `ville` = :ville , `pays` = :pays , `connus` = :connus ,
                                                          `precisez2` = :precisez2 , `newsletter` = :newsletter , `ref_valid` = :ref_valid ,  `stat_valid` = :stat_valid
                                                           WHERE `id` = :id");

                $requete->bindParam(':id', $_GET['id_user']);

            }
            //In Add
            // url = http://tousrenov.dev/api_rest/user_manager?method=changeInformation&isPro=0&etes1=etes1&precisez1=aa&etes2=etes2&civ=civ&nom=nom&prenom=prenom&telephone=telephone&email=email&num_voie=num_voie&num_appart=num_appart&batiment=batiment&code_postal=11111&ville=333&pays=pays&connus=connus&precisez2=%27%27&newsletter=1&ref_valid=%27%27&stat_valid=0&mdp=mdp
            else{

                $requete = $pdo->prepare("INSERT INTO `" . $table . "` (`etes1`,`precisez1`,`etes2`,`civ`,`nom`,`prenom`,`telephone`,`email`,`num_voie`,`num_appart`,`batiment`,`code_postal`,`ville`, `pays`,`connus`,`precisez2`,`newsletter`,`ref_valid`, `stat_valid`,`mdp`) values 
                                                        (:etes1 ,:precisez1,:etes2,:civ ,:nom ,:prenom ,:telephone ,:email ,:num_voie ,:num_appart ,:batiment ,:code_postal , :ville ,:pays ,:connus ,:precisez2 , :newsletter ,:ref_valid ,:stat_valid,:mdp)");

                $requete->bindParam(':mdp', md5($_GET['mdp']));
            }




            $requete->bindParam(':etes1', $_GET['etes1']);
            $requete->bindParam(':precisez1', $_GET['precisez1']);
            $requete->bindParam(':etes2', $_GET['etes2']);
            $requete->bindParam(':civ', $_GET['civ']);
            $requete->bindParam(':nom', $_GET['nom']);
            $requete->bindParam(':prenom', $_GET['prenom']);
            $requete->bindParam(':telephone', $_GET['telephone']);
            $requete->bindParam(':email', $_GET['email']);
            $requete->bindParam(':num_voie', $_GET['num_voie']);
            $requete->bindParam(':num_appart', $_GET['num_appart']);
            $requete->bindParam(':batiment', $_GET['batiment']);
            $requete->bindParam(':code_postal', $_GET['code_postal']);
            $requete->bindParam(':ville', $_GET['ville']);
            $requete->bindParam(':pays', $_GET['pays']);
            $requete->bindParam(':connus', $_GET['connus']);
            $requete->bindParam(':precisez2', $_GET['precisez2']);
            $requete->bindParam(':newsletter', $_GET['newsletter']);
            $requete->bindParam(':ref_valid', $_GET['ref_valid']);
            $requete->bindParam(':stat_valid', $_GET['stat_valid']);
        }




     //   dd($requete);


       // var_dump($requete->queryString );

        if( $requete->execute() ){
            $success = true;
            $msg = 'l\'utilisateur a été modifier';
        } else {
            $success = false;
            $msg = $pdo->errorInfo();
        }

        reponse_json($success, $_GET, $msg);

    }

?>