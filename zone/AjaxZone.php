<?php 
session_start();
header("Content-Type:text/plain; charset=iso-8859-1");
require_once 'mysql.php';
$my = new mysql();
if( isset($_POST['id']) )
{
	$_SESSION['zone']=$_POST['id'];
	$zz = $my->req_arr('SELECT * FROM ttre_users_zones WHERE zone='.$_SESSION['zone'].'  ');
	$_SESSION['user_zone']=$zz['id_user'];
	$dep=$my->req_arr('SELECT * FROM ttre_departement_france WHERE departement_id='.$_SESSION['zone'].' ');
	$_SESSION['nom_zone']=$dep['departement_nom'];
	echo $_SESSION['nom_zone'] ; 
}
?>