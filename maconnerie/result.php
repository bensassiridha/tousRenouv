<?php
require('mysql.php');

$content = $_POST['form-about-yourself'];
$habitat = $_POST['habitat'];
$trav = $_POST['trav'];
$civil = $_POST['civilite'];
$firstname = $_POST['form-first-name'];
$lastname = $_POST['form-last-name'];
$email = $_POST['form-email'];
$phone = $_POST['form-phone'];
$street = $_POST['form-street'];
$postal = $_POST['form-code-postal'];
$city = $_POST['ville'];
$timedate = $_POST['timedate'];

$firstname = mysqli_real_escape_string($conn, $_POST['form-first-name']);
$lastname = mysqli_real_escape_string($conn, $_POST['form-last-name']);
$email = mysqli_real_escape_string($conn, $_POST['form-email']);
$civil = mysqli_real_escape_string($conn, $_POST['civilite']);
$phone = mysqli_real_escape_string($conn, $_POST['form-phone']);
$street = mysqli_real_escape_string($conn, $_POST['form-street']);
$postal = mysqli_real_escape_string($conn, $_POST['form-code-postal']);
$city = mysqli_real_escape_string($conn, $_POST['ville']);
$content = mysqli_real_escape_string($conn, $_POST['form-about-yourself']);
$habitat = mysqli_real_escape_string($conn, $_POST['habitat']);
$trav = mysqli_real_escape_string($conn, $_POST['trav']);
$timedate = mysqli_real_escape_string($conn, $_POST['timedate']);


$sql = "INSERT INTO demande_devis(first_name, last_name, email, civilit, phone, adresse, city, content, habitat, type_trav, time, postal) VALUES ('$firstname', '$lastname', '$email', '$civil', $phone, '$street', '$city', '$content', '$habitat', '$trav', '$timedate', '$postal' )";

if(mysqli_query($conn, $sql)){
    echo "New record created successfully";
} else {
    echo "Error:" . $sql . "<br/>" .mysqli_error($conn);
}

mysqli_close($conn);