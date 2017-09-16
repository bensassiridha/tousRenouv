<!--

CREATE TABLE IF NOT EXISTS `paypal_payment_info` (
  `txn_id` text NOT NULL,
  `payment_status` text NOT NULL,
  `receiver_email` text NOT NULL,
  `custom` text NOT NULL,
  `payment_amount` text NOT NULL,
  `payment_currency` text NOT NULL,
  `contenu` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-->
<?php
$test_mail = 'bilelbadri@gmail.com';
$mail_boutique_paypal = 'bilelbusiness@yahoo.fr';

$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) 
{
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$verify_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$req;
//$verify_url = 'https://ipnpb.paypal.com/cgi-bin/webscr?'.$req;
$res = file_get_contents( $verify_url );	

$req_insert=$my->req("INSERT INTO paypal_payment_info VALUES
														('".$txn_id."',
														'".$payment_status."',
														'".$receiver_email."',
														'".$custom."',
														'".$payment_amount."',
														'".$payment_currency."',
														'".$datas."')");

if (strcmp ($res, "VERIFIED") == 0) 
{  
	// Response is VERIFIED
    $payment_status = $_POST['payment_status']; // Vérifier que payment_status soit bien égal à "Completed"
    $mes=' -- payment_status : '.$payment_status;
    $txn_id = $_POST['txn_id']; // Vérifier que l'ID de transaction txn_id n'a pas déjà été traité
    $mes.=' -- txn_id : '.$txn_id;
    $receiver_email = $_POST['receiver_email']; // Vérifier que receiver_email est votre adresse email PayPal principale
    $mes.=' -- receiver_email : '.$receiver_email;
    $payment_amount = $_POST['mc_gross']; //  solde de commande
    $mes.=' -- mc_gross : '.$payment_amount;
    $payment_currency = $_POST['mc_currency']; // EUR
    $mes.=' -- mc_currency : '.$payment_currency;
    $custom = $_POST['custom']; // reference de commande
    $mes.=' -- custom : '.$custom;
    $datas=serialize($_POST); // contient tous les valeurs
    $mes.=' -- tout : '.$datas;
    
	/*require_once('admin/mysql.php');
	$my = mysql::Connect();	
     
    // vérifier que payment_status a la valeur Completed
    if ( $payment_status == "Completed") 
    {
    	// vérifier que txn_id n'a pas été précédemment traité: Créez une fonction qui va interroger votre base de données
    	$req_txn=$my->req('SELECT * FROM paypal_payment_info WHERE txn_id="'.$txn_id.'"') ;
    	if ( $my->num($req_txn)==0 ) 
        {
	    	// vérifier que receiver_email est votre adresse email PayPal principale
	        if ( $mail_boutique_paypal == $receiver_email) 
	        {     
	        	// vérifier que payment_amount et payment_currency sont corrects
	        	$infoCom=$my->req_arr('SELECT * FROM clients_commandes WHERE ref="'.$custom.'"') ;
                if ( $infoCom ) 
                {
                	$tot=$infoCom['total_net']+$infoCom['frais_port'];
                	if ( ($payment_amount==$tot ) && ($payment_currency=='EUR') )
                	{
                		// traiter le paiement
                		$pwd=$my->req('UPDATE clients_commandes SET statut=1 , type="Paypal" , fichier_update="notify_paypal_test" WHERE ref="'.$custom.'"') ;
						$ress=$my->req_arr('SELECT * FROM clients_commandes WHERE ref="'.$custom.'"') ;
						$req=$my->req('SELECT * FROM clients_commandes_contenu WHERE id_c='.$ress['id'].'');
						while ( $res=$my->arr($req) )
						{
							$chat=0;$mail=0;$tel=0;$rdv_tel=0; $chat_slaf=0;$mail_slaf=0;$tel_slaf=0;$rdv_tel_slaf=0;
							$cc=$my->req_arr('SELECT * FROM clients_credit WHERE id_c='.$ress['id_c'].'');
							if ( $cc ){ $chat=$cc['chat'];$mail=$cc['mail'];$tel=$cc['tel'];$rdv_tel=$cc['rdv_tel'];
									$chat_slaf=$cc['slaf_chat'];$mail_slaf=$cc['slaf_mail'];$tel_slaf=$cc['slaf_tel'];$rdv_tel_slaf=$cc['slaf_rdv_tel'];}
							$tt=$my->req_arr('SELECT * FROM tarifs WHERE id='.$res['id_p'].'');
							if ( ! $cc ) $pwd=$my->req("INSERT INTO clients_credit VALUES('','".$ress['id_c']."','0','0','0','0','0','0','0','0')");
							if ( $tt['statut']==1 ) 
							{
								$total=$chat+$tt['temps']*60*$res['qte'];
								if ( ($total-$chat_slaf)>=0 ) { $nvc=$total-$chat_slaf; $nvs=0; } else { $nvc=0; $nvs=$chat_slaf-$total; }
								$pwd=$my->req('UPDATE clients_credit SET chat='.$nvc.' , slaf_chat='.$nvs.' WHERE id_c="'.$ress['id_c'].'"') ;
							}
							elseif ( $tt['statut']==2 ) 
							{
								$total=$mail+$tt['temps']*$res['qte'];
								if ( ($total-$mail_slaf)>=0 ) { $nvc=$total-$mail_slaf; $nvs=0; } else { $nvc=0; $nvs=$mail_slaf-$total; }
								$pwd=$my->req('UPDATE clients_credit SET mail='.$nvc.' , slaf_mail='.$nvs.' WHERE id_c="'.$ress['id_c'].'"') ;
							}
							elseif ( $tt['statut']==3 ) 
							{
								$total=$tel+$tt['temps']*60*$res['qte'];
								if ( ($total-$tel_slaf)>=0 ) { $nvc=$total-$tel_slaf; $nvs=0; } else { $nvc=0; $nvs=$tel_slaf-$total; }
								$pwd=$my->req('UPDATE clients_credit SET tel='.$nvc.' , slaf_tel='.$nvs.' WHERE id_c="'.$ress['id_c'].'"') ;
							}
							elseif ( $tt['statut']==4 ) 
							{
								$total=$rdv_tel+$tt['temps']*60*$res['qte'];
								if ( ($total-$rdv_tel_slaf)>=0 ) { $nvc=$total-$rdv_tel_slaf; $nvs=0; } else { $nvc=0; $nvs=$rdv_tel_slaf-$total; }
								$pwd=$my->req('UPDATE clients_credit SET rdv_tel='.$nvc.' , slaf_rdv_tel='.$nvs.' WHERE id_c="'.$ress['id_c'].'"') ;
							}
						}   
						// fin de traitement
                	}
                }
				$req_insert=$my->req("INSERT INTO paypal_payment_info VALUES 
														('".$txn_id."',
														'".$payment_status."',
														'".$receiver_email."',
														'".$custom."',
														'".$payment_amount."',
														'".$payment_currency."',
														'".$datas."')");
                    	
	        }  	
        }
    }*/
	//mail($test_mail, 'paypal', 'VERIFIED'.$mes ); 
}
else if (strcmp ($res, "INVALID") == 0) 
{
	//mail($test_mail, 'paypal', 'INVALID'); 
}
else 
{
  	// erreur
  	//mail($test_mail, 'paypal', 'erreur'.print_r($res, true)); 
}
?>


