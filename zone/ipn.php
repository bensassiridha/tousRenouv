<?php
$email_account = "youness.elbezzazi-facilitator@gmail.com";
$req = 'cmd=_notify-validate';

foreach($_POST as $key => $value){
    $value = urlencode(stripslashes($value));
    $req .="&$key=$value";
}

//Renvoyer au syst@me PayPal pour validation
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-lenght: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
parse_str($POST['custom'],$custom);

if (!$fp){

} else {
    fputs($fp, $header .$req);
    while (!feot($fp)){
        $res = fgets ($fp, 1024);
        if (strcmp ($res, "VERIFIED") == 0){
            // Vérifier que payment_status a la valeur Completed
            if($payment_status == "Completed"){
                if($email_account == $ receiver_email){
                    /** C'est la que tout se passe
                    * PS :tjrs penser à vérifier la somme !!
                    */
                    file_put_contents('log', print_r($_POST,true));
                    
                    $devis=$my->req_arr('SELECT * FROM ttre_devis WHERE id="'.$_GET['idDevisPaye'].'" ');
                    
                    if ( $ress['id_client_pro']==$_SESSION['id_client_trn_pro'] )
                    {
                        if ( $devis['statut_valid_admin']==2 )
                        {
                            $id_devis=$devis['id'];
                            $id_adresse=$devis['id_adresse'];
                            $id_client_part=$devis['id_client'];
                            require_once 'mailDevis.php';
                            $my->req ( 'UPDATE ttre_devis SET
                                            statut_valid_admin		=	"3" 
                                        WHERE id = "'.$devis['id'].'" ' );
                            $my->req ( 'UPDATE ttre_devis_client_pro SET
                                            date_payement			=	"'.time().'" ,
                                            type_payement			=	"Paypal" ,
                                            fichier_update			=	"Site" 
                                        WHERE id_devis = "'.$devis['id'].'" ' );
                        }
                    }
                        file_put_contents('log', 'Le paiement a bien été confirmé');
                    }else{
                        file_put_contents('log', 'Le paiement ne correspond à aucune offre'));
                    }
                    
                } else {
                //statut de paiement: Echac
                }
            exit();
        }
        else if(strcmp ($res, "INVALID") == 0){
            //transaction invalide
        }
        }
        fclose($fp);
    }
?>