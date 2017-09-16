<?php
/*session_start();
header("Content-Type:text/plain; charset=iso-8859-1");
require('mysql.php');
$my=new mysql();

if ( isset($_SESSION['id_fichier_chat']) )
{
	$temp=$my->req_arr('SELECT * FROM fichiers_chat WHERE id='.$_SESSION['id_fichier_chat']);
	if( $temp['statut']==1 )
	{
		$util=$my->req_arr('SELECT * FROM ttre_users WHERE id_user='.$temp['id_u'].' ');
		$my->req('UPDATE fichiers_chat SET statut="2" WHERE id='.$_SESSION['id_fichier_chat'].' ' );
		echo ''.$util['nom'].' est desponible pour chatter, Merci de le rejoindre';
	}
}*/
?>