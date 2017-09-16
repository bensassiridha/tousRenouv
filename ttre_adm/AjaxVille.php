<?php 
header("Content-Type:text/plain; charset=iso-8859-1");
require_once 'mysql.php';
$my = new mysql();
if( isset($_POST['cp']) )
{
	if ( ($_POST['cp']>=75001 && $_POST['cp']<=75020) || $_POST['cp']==75116 )
	{
		$res=$my->req_arr('SELECT * FROM ttre_villes_france WHERE ville_code_postal=75001 ');
		$option='<option value="'.$res['ville_id'].'">'.$res['ville_nom_reel'].'</option>';
	}
	else
	{
		$option='';
		$req=$my->req('SELECT * FROM ttre_villes_france WHERE ville_code_postal='.$_POST['cp'].' ORDER BY ville_id ASC');
		if ( $my->num($req)>0 )
		{
			$option='<option value="0"></option>';
			while ( $res=$my->arr($req) ) 
			{
				$option.='<option value="'.$res['ville_id'].'">'.$res['ville_nom_reel'].'</option>';
			}
		}
	}
	echo $option ; 
}
?>