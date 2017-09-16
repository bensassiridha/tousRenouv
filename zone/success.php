<?php
require('inc/session.php');

//$item_no            = $_REQUEST['item_number'];
$item_transaction   = $_REQUEST['tx']; // Paypal transaction ID
$item_price         = $_REQUEST['amount']; // Paypal received amount
$item_currency      = $_REQUEST['currency_code']; // Paypal received currency type


$ress=$my->req_arr('SELECT * FROM ttre_devis WHERE id='.$res['id_devis'].' ');
$total=$ress['total_net']+$ress['total_tva']+$ress['frais_port'];
$price = $item_price;
$currency= $item_currency;

//Rechecking the product price and currency details
if($item_price==$price && $item_currency==$currency)
{
    $content = "<h1>Welcome, Guest</h1>";
    $content .= "<h1>Payment Successful</h1>";
}
else
{
    echo $price;
    echo $currency;
    $content = "<h1>Payment Failed</h1>";
}

$title = "PayPal Payment in PHP";
$heading = "Welcome to PayPal Payment PHP example.";
include('html.inc');
?>