<?php
//header('Content-Type: application/json');
//to permise access for prevent this error ( No 'Access-Control-Allow-Origin' header is present on the requested resource)
header("Access-Control-Allow-Origin: *");

//Effecer les erreurs
ini_set('display_errors', '1');
error_reporting(E_ERROR | E_PARSE);

$success = false;
include('pdo.php');
$data = array();

$apikey = "12345";

function reponse_json($success, $data=NULL, $msgErreur=NULL) {
    $array['success'] = $success;
    $array['msg'] = $msgErreur;
    $array['result'] = $data;
    echo json_encode($array);
}

function dd($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    die();
}