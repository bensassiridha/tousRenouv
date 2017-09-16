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

    case "saveCmd":
        saveCmd();
        break;
    case "saveCmdDetail":
        saveCmdDetail();
        break;


}

/*
 * Function to save commande
 * @url = http://tousrenov.dev/api_rest/commande_manager?method=saveCmd
 * @Post = Commande(client,adresse , chantiers)
 * $Post =   [quote] => {"id_client":4638,"nbr_estimation":1,"date":"2017-09-04_20:33:53","reference":"R324322","products":[{"id":"2","parent":"0","titre":"Menuiserie","photo":"3.png","ordre":"1","piece":"menuiseire description"},{"id":"5","parent":"0","titre":"Plomberie","photo":"9.png","ordre":"5","piece":"Plomberie description"}],"adresse":{"id":"4192","id_client":"4638","num_voie":"3232","num_appart":"fdfd","batiment":"vdvdv","code_postal":"3232","ville":"232","pays":"France","statut":"1"}}

 */
function saveCmd(){

    global $pdo;

   /*
    * stdClass Object
(
    [client] => stdClass Object
        (
            [0] => 4638
            [1] => Particuler
            [2] =>
            [3] =>
            [4] => Mr
            [5] => ben sassi
            [6] => ridha
            [7] => 92702009
            [8] => hola@hola.com
            [9] => 12 rue
            [10] => 12
            [11] => bat
            [12] => 75007
            [13] => 30438
            [14] => France
            [15] => Journal
            [16] =>
            [17] => 0cc175b9c0f1b6a831c399e269772661
            [18] => 1
            [19] => R59997f529234e
            [20] => 1
            [id] => 4638
            [etes1] => Particuler
            [precisez1] =>
            [etes2] =>
            [civ] => Mr
            [nom] => ben sassi
            [prenom] => ridha
            [telephone] => 92702009
            [email] => hola@hola.com
            [num_voie] => 12 rue
            [num_appart] => 12
            [batiment] => bat
            [code_postal] => 75007
            [ville] => 30438
            [pays] => France
            [connus] => Journal
            [precisez2] =>
            [mdp] => 0cc175b9c0f1b6a831c399e269772661
            [newsletter] => 1
            [ref_valid] => R59997f529234e
            [stat_valid] => 1
        )

    [chantier] => Array
        (
            [0] => stdClass Object
                (
                    [id_devis] => 3950
                    [chantier_title] => Chantier N°45
                    [activities] => Veranda|Achetez un seul  RDV pour des travaux de Veranda 100% QUALITE  ** Les coordonnées des clients sont vérifiées .,
                    [zone_intervention] =>  71000 - Sancé - France
                    [date] => 04/04/2017
                    [reference] => R58e35c434f8cf
                    [prix_achat] => 49 €
                    [tva] => 20 %
                    [pric_ttc] => 58.8
                    [reste_estimation] => 499
                )

            [1] => stdClass Object
                (
                    [id_devis] => 3949
                    [chantier_title] => Chantier N°46
                    [activities] => Veranda|Achetez un seul  RDV pour des travaux de Veranda 100% QUALITE  ** Les coordonnées des clients sont vérifiées .,
                    [zone_intervention] =>  70000 - Magnoray - France
                    [date] => 04/04/2017
                    [reference] => R58e35c434f3b8
                    [prix_achat] => 49 €
                    [tva] => 20 %
                    [pric_ttc] => 58.8
                    [reste_estimation] => 499
                )

            [2] => stdClass Object
                (
                    [id_devis] => 4205
                    [chantier_title] => Chantier N°0
                    [activities] => Menuiserie|,
                    [zone_intervention] =>  75007 - Paris - France
                    [date] => 10/09/2017
                    [reference] => R59b5685c1abf3
                    [prix_achat] => 0 €
                    [tva] => 20 %
                    [pric_ttc] => 0
                    [reste_estimation] => 1
                )

        )

    [total] => 117.6
)
    */


    $data = null;


    if(!empty($_POST['cmd'])){

        $data = json_decode($_POST['cmd']);
    }



    //Generation reference
    $reference_cmd = uniqid('R');

    $time_now = time();

    //dd($_POST);

    $query = "INSERT INTO ttre_client_pro_commandes VALUES(NULL ,
													'".$reference_cmd."',
													'".$data->client->id."',
													'".time()."',
													'".$data->typePayement."',
													'".$data->total."',
													'0' ,
													'')";

    //echo 'Query = '.$query;

    if( $pdo->exec($query) ){

       // $pdo->commit();

        $id_cmd =  $pdo->lastInsertId();

        saveDetailCmd($id_cmd,$data->chantier);
    } else {
        $success = false;
        $msg = $pdo->errorInfo();
    }


}

function saveDetailCmd($id_cmd,$chantiers){

    global $pdo;

    $success = false;
    $msg = '';

    $id_cmd = $id_cmd;


    $products = json_decode($_POST['products']);

    //dd($products);

    foreach ($chantiers as $chantier){

       // echo $product->titre;


        $type = "DevisAImm";


        $query = "INSERT INTO ttre_client_pro_commandes_contenu VALUES
                                                               (NULL ,'".$id_cmd."','".$chantier->id_devis."','".$type."','".$chantier->pric_ttc."')";


        //echo 'Query = '.$query;


        if( $pdo->exec($query) ){

           // $id_devis =  $pdo->lastInsertId();
            $success = true;
            $msg = 'Votre commande a été bien enregistrer Avec id cmd   = '.$id_cmd;


        } else {
            $success = false;
            $msg = $pdo->errorInfo();
        }


    }

    reponse_json($success, $_POST, $msg);


}

