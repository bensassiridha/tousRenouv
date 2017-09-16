<?php 
session_start();
header("Content-Type:text/plain; charset=iso-8859-1");
require_once 'mysql.php';
$my = new mysql();

$nom='';
$temp=$my->req_arr('SELECT * FROM fichiers_chat WHERE statut=0 AND id_u='.$_SESSION['id_user'].' ');
if ( $temp )
{
	$nom=$temp['nom'].' veut chatter avec toi ';
	$_SESSION['idf']=$temp['id'];
}
	//$my->req('UPDATE fichiers_chat SET statut="1" WHERE id_u='.$_SESSION['id_user'].' ' );
echo $nom;
?>