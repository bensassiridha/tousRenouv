<?php 
session_start();
header("Content-Type:text/plain; charset=iso-8859-1");
require_once 'mysql.php';
$my = new mysql();

if ( isset($_SESSION['id_connect_admin']) )
{
	$my->req('UPDATE ttre_connection_admin SET fin_ajax="'.time().'" WHERE id = '.$_SESSION['id_connect_admin'].' ' );
}

$req=$my->req('SELECT * FROM ttre_connection_admin WHERE fin=0 ');
while ( $res=$my->arr($req) )
{
	$diff=time()-$res['fin_ajax'];
	if ( $diff > 90 ) // chaque 1min30sec on teste si l'admin a quitter la page sans cliquer sur deconnexion
		$my->req('UPDATE ttre_connection_admin SET fin="'.$res['fin_ajax'].'" WHERE id = '.$res['id'].' ' );
}

echo $_SESSION['id_connect_admin'];	
?>