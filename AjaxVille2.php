<?php 
header("Content-Type:text/plain; charset=iso-8859-1");
require_once 'mysql.php';
$my = new mysql();
if( isset($_POST['dep']) )
{
	$option='';
	$req=$my->req('SELECT * FROM ttre_villes_france VF WHERE ville_departement='.$_POST['dep'].' ORDER BY ville_id ASC');
	if ( $my->num($req)>0 )
	{
		$option='<option value="0"></option>';
		while ( $res=$my->arr($req) ) 
		{
			$option.='<option value="'.$res['ville_id'].'">'.$res['ville_nom_reel'].'</option>';
		}
	}
	echo $option ; 
}
?>