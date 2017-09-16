<?php

$servername = "tousrenovcfr.mysql.db";
$username = "tousrenovcfr";
$password = "MAROC2015";
$db = "tousrenovcfr";

//Create Connection
$conn = mysqli_connect($servername, $username, $password, $db);

//Check Connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

