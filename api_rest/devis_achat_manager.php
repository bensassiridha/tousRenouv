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

  //  dd($_POST);

    $data = json_decode($_POST['quote']);

  // dd($data);
    /*
     * <pre>stdClass Object
(
    [id_client] => 4638
    [nbr_estimation] => 1
    [date] => 2017-09-04_20:38:4
    [reference] => R324322
    [products] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 2
                    [parent] => 0
                    [titre] => Menuiserie
                    [photo] => 3.png
                    [ordre] => 1
                    [piece] => cvvvdv
                )

        )

    [adresse] => stdClass Object
        (
            [id] => 4192
            [id_client] => 4638
            [num_voie] => 3232
            [num_appart] => fdfd
            [batiment] => vdvdv
            [code_postal] => 3232
            [ville] => 232
            [pays] => France
            [statut] => 1
        )

)
</pre>
     */

    //Generation reference
    $reference_devis = uniqid('R');

    $id_devis = null;

    //Save to table devis
    $req = $pdo->prepare("INSERT INTO `ttre_achat_devis` (`reference`, `date_ajout`, `id_client`, `id_adresse`, `nbr_estimation`, `prix_achat`, `note_devis`, `statut_valid_admin`, `stat_suppr`, `user_zone`, `tva_pro`, `tva_zone`)
                        VALUES (:reference, :date_ajout, :id_client, :id_adresse, :nbr_estimation,:prix_achat,:note_devis,:statut_valid_admin,:stat_suppr,:user_zone,:tva_pro,:tva_zone)");

    $val = 0;
    $val_Ok = 1;

    $req->bindParam(':reference', $reference_devis);
    $req->bindParam(':date_ajout', time());
    $req->bindParam(':id_client', $data->id_client);
    $req->bindParam(':id_adresse',$data->adresse->id);
    $req->bindParam(':nbr_estimation', $data->nbr_estimation);
    $req->bindParam(':prix_achat', $val);
    $req->bindParam(':note_devis', $val);

    //temporairement on affect 1 a statut_valid_admin
    $req->bindParam(':statut_valid_admin',$val_Ok );
    $req->bindParam(':stat_suppr', $val);
    $req->bindParam(':user_zone', $val);
    $req->bindParam(':tva_pro', $val);
    $req->bindParam(':tva_zone', $val);


    $msg = '';

    if( $req->execute() ){

       $id_devis =  $pdo->lastInsertId();
        $success = true;
        $msg =  $msg . 'Votre devis a été bien enregistrer Avec le reference = '.$reference_devis;
    } else {
        $success = false;
        $msg = $pdo->errorInfo();
    }

    //upload File & save it ttre_achat_devis_fichier_suite
    /*
     for ( $i=1 ; $i<=5 ; $i++ )
				{
					$handle = new Upload($_FILES['fichier'.$i]);
					if ($handle->uploaded)
					{
						$handle->Process('upload/devis/');
						if ($handle->processed)
						{
							$fichier  = $handle->file_dst_name ;	          // Destination file name
							$handle-> Clean();                           // Deletes the uploaded file from its temporary location
							$my->req("INSERT INTO ttre_achat_devis_fichier_suite VALUES('','".$id_devis."','".$fichier."')");
						}
					}
				}
     */

    /*
     *  Save devis detaile (les produit
     */

    foreach ($data->products as $product){
        echo $product->titre;

        //$req_tmp = $pdo->prepare("INSERT INTO `ttre_achat_devis_details` (`id_devis`, `ordre_categ`, `id_categ`, `titre_categ`, `nom_piece`) VALUES (:id_devis, :ordre_categ, :id_categ, :titre_categ,:nom_piece)");

        $req_tmp = $pdo->prepare( "INSERT INTO `ttre_devis_details` (`id`, `id_devis`, `ordre_categ`, `id_categ`, `titre_categ`, `nom_piece`, `id_prix`, `titre`, `tva`, `valeur_tva_prod`, `prix`, `qte`, `unite`, `commentaire`) VALUES
(26, 0, 0, 1, 'Ma&ccedil;onnerie', '', 1067, 'Main d\'Å“uvre et pose comprise en 20 cm d\'Ã©paisseur<br />\r\n', 3, 6.25, 12.5, 10, 'mÃ‚Â²', ''),
");

     /*   $req_tmp->bindParam(':id_devis', $id_devis);
        $req_tmp->bindParam(':ordre_categ', $product->ordre);
        $req_tmp->bindParam(':id_categ', $product->id);
        $req_tmp->bindParam(':titre_categ',$product->titre);
       $req_tmp->bindParam(':nom_piece', $product->piece);*/


        if( $req_tmp->execute() ){

            $success = true;
            $msg =  $msg . '<br> Votre detail devis a été bien enregistrer ';
        } else {
            $success = false;
            $msg = $pdo->errorInfo();
        }
    }



    reponse_json($success, $_POST, $msg);


}
