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

    case "getAllSellerQuote":
        getAllSellerQuote();
        break;
    case "getDetailSellerQuote":
        getDetailSellerQuote();
        break;

    case "SaveQuote":
        saveQuote();
        break;

}

/*
 * Function to save quote
 * @url = http://tousrenov.dev/api_rest/devis_achat_manager?method=SaveQuote
 * @Post = Quote(products[],adresse , id_user )
 * $Post =   [quote] => {"id_client":4638,"nbr_estimation":1,"date":"2017-09-04_20:33:53","reference":"R324322","products":[{"id":"2","parent":"0","titre":"Menuiserie","photo":"3.png","ordre":"1","piece":"menuiseire description"},{"id":"5","parent":"0","titre":"Plomberie","photo":"9.png","ordre":"5","piece":"Plomberie description"}],"adresse":{"id":"4192","id_client":"4638","num_voie":"3232","num_appart":"fdfd","batiment":"vdvdv","code_postal":"3232","ville":"232","pays":"France","statut":"1"}}

 */
function saveQuote(){
    global $pdo;

   // dd($_POST);


    $data = null;


    if(!empty($_POST['quote'])){

        $data = json_decode($_POST['quote']);
    }


    //dd($data);

    //Generation reference
    $reference_devis = uniqid('R');

    $time_now = time();
    $val = 0;
    $val_Ok = 1;
    $adresee = $_POST['id_adresse'];
    $idClient =$_POST['id_client'];
    $nbr_estimation = $_POST['nbr_estimation'];

    //dd($_POST);

    $query = "INSERT INTO ttre_achat_devis  (`reference`, `date_ajout`, `id_client`, `id_adresse`, `nbr_estimation`, `prix_achat`, `note_devis`, `statut_valid_admin`, `stat_suppr`, `user_zone`, `tva_pro`, `tva_zone`) VALUES(
													'".$reference_devis."',
													'".time()."',
													".intval($idClient).",
													".$adresee.",
													'".$nbr_estimation."',
													'0',
													'0',
													'1', 
													'0',
													'0',
													'0',
													'0'
													)";

    //echo 'Query = '.$query;

    if( $pdo->exec($query) ){

       // $pdo->commit();

        $id_devis =  $pdo->lastInsertId();

        saveDetailQuote($id_devis);
    } else {
        $success = false;
        $msg = $pdo->errorInfo();
    }


}

function saveDetailQuote($id_devis){

    global $pdo;

    $success = false;
    $msg = '';

    $id_devis = $id_devis;


    $products = json_decode($_POST['products']);

    //dd($products);

    foreach ($products as $product){

       // echo $product->titre;

        $query = "INSERT INTO ttre_achat_devis_details VALUES(NULL ,
															'".$id_devis."',
															'".$product->ordre."',
															'".$product->id."',
															'".$product->titre."',
															'".$product->piece."'
															)";


        //echo 'Query = '.$query;


        if( $pdo->exec($query) ){

           // $id_devis =  $pdo->lastInsertId();
            $success = true;
            $msg = 'Votre devis a été bien enregistrer Avec id devis   = '.$id_devis;


        } else {
            $success = false;
            $msg = $pdo->errorInfo();
        }


    }


    reponse_json($success, $_POST, $msg);


}


/*
 * Get all Seller Quote
 * @url = http://tousrenov.dev/api_rest/quote_achat_manager?method=getAllSellerQuote&activity=1&ville=3
 */
 function getAllSellerQuote (){

    global $pdo;

    $id_user = $_GET['id_user'];

    $parent = $_GET['parent'];

    $limit = $_GET['page'];

    $req = null;


 //filter by departement
    if($_GET['ville'] != 0){
        $req = $pdo->prepare("SELECT d.id as id_devis , d.id_adresse , d.date_ajout,d.reference,d.prix_achat FROM ttre_achat_devis d Left join ttre_client_part_adresses a on(d.id_adresse = a.id) WHERE d.stat_suppr=0 AND d.statut_valid_admin=1 and a.ville = :ville  ORDER BY d.id DESC LIMIT 100 ");

        $req->bindParam(':ville',$_GET['ville']);
    }else if($_GET['activity'] != 0)  {
        $req = $pdo->prepare("SELECT d.id as id_devis , d.id_adresse , d.date_ajout,d.reference,d.prix_achat FROM ttre_achat_devis d Left join ttre_achat_devis_details a on(d.id = a.id_devis) WHERE d.stat_suppr=0 AND d.statut_valid_admin=1 and a.id_categ = :activity  ORDER BY d.id DESC LIMIT 100 ");

        $req->bindParam(':activity',$_GET['activity']);
    }else{

        $req = $pdo->prepare("SELECT id as id_devis , id_adresse , date_ajout,reference,prix_achat FROM ttre_achat_devis WHERE stat_suppr=0 AND  statut_valid_admin=1  ORDER BY id DESC LIMIT 100 ");


    }


    $chantiers = null;
    if ($req->execute()){
        $all_chantier = $req->fetchAll(PDO::FETCH_OBJ);

       // dd($all_chantier);


        $current_quote = null;
        foreach ($all_chantier as $index => $chantier){

            //Get quote by id
            $req_tmp = $pdo->prepare("SELECT * FROM ttre_achat_devis WHERE id = :id");
            $req_tmp->bindParam(':id',$chantier->id_devis);


            if($req_tmp->execute()){
                $current_quote    = $req_tmp->fetchAll(PDO::FETCH_OBJ);

              //  dd($current_quote);

                //autre commande pour des autres pro
                $req_tmp = $pdo->prepare("SELECT * FROM ttre_client_pro_commandes_contenu CC , ttre_client_pro_commandes C
					WHERE C.id=CC.id_cmd AND CC.id_devis= :id_devis  AND C.statut=1 ");

                //$id = 4203;
                $req_tmp->bindParam(':id_devis',$current_quote->id);

                if ($req_tmp->execute()){
                    $clients_pro_cmd  = $req_tmp->fetch(PDO::FETCH_ASSOC);

                    //echo 'hhhh';
                    //dd (count(array_filter($clients_pro_cmd)));
                    if ($current_quote[0]->nbr_estimation> count(array_filter($clients_pro_cmd))){


                        //if(getActivities($chantier->id_devis) != '')
                        $arr  = array('id_devis'=> $chantier->id_devis,'chantier_title'=>'Chantier N°'.$index,'activities'=>ucfirst(html_entity_decode(getActivities($chantier->id_devis))),'zone_intervention'=>getZoneIntervention($chantier->id_adresse),'date'=> date('d/m/Y', $chantier->date_ajout),'reference'=>$chantier->reference,'prix_achat'=>$chantier->prix_achat.' €','tva'=>'20 %','pric_ttc'=>floatval (number_format(($chantier->prix_achat*0.2)+$chantier->prix_achat,2)),'reste_estimation'=>$current_quote[0]->nbr_estimation - count(array_filter($clients_pro_cmd)) );

                        $chantiers[]  =  $arr;


                    }
                }

            }else{
                echo 'error sql !! ';
            }


        }

        //dd($chantiers);

        $success = true;
        $data['nombre'] = count($chantiers);
        $data['chantiers'] = $chantiers;
    }else{
        $success = false;
        $msg = "Une erreur s'est produite";
    }


//Render response with json
    //Render response with json
    reponse_json($success, $data);

}

/*
 * get concerned activity for a quote
 */

function getActivities($id_devis){

    global $pdo;

    $req = "SELECT * FROM ttre_achat_devis_details where id_devis = :id ";






    $activite='';
    $req_tmp = $pdo->prepare($req);
    $req_tmp->bindParam(':id',$id_devis);



    if($req_tmp->execute()) {
        $quote_details = $req_tmp->fetchAll(PDO::FETCH_OBJ);


        foreach ($quote_details as $det){

            $activite =$activite . $det->titre_categ.'|'.$det->piece.', ';
        }
    }

    return $activite;

}

/*
 * get zone intervention
 */
function getZoneIntervention($id_adresse){

    global $pdo;

    $zone = "";

    $req_tmp = $pdo->prepare("SELECT * FROM ttre_client_part_adresses where id = :id");
    $req_tmp->bindParam(':id',$id_adresse);

    if($req_tmp->execute()) {
        $adresse = $req_tmp->fetchAll(PDO::FETCH_OBJ);


        $code_postal = $adresse[0]->code_postal ;



            $ville = getVille($adresse[0]->ville);

        $pays = $adresse[0]->pays;

        $zone = ' '.$code_postal.' - '.$ville.' - '.$pays.' ';


    }


    return $zone;

}

/*
 * get ville
 */

function getVille($id_ville){

    global $pdo;


    $ville = "";
    $req_tmp = $pdo->prepare("SELECT * FROM ttre_villes_france where ville_id = :id");
    $req_tmp->bindParam(':id',$id_ville);

    if ($req_tmp->execute()){
        $ville =  $req_tmp->fetchAll(PDO::FETCH_OBJ);

    }

    return $ville[0]->ville_nom_reel;

}






