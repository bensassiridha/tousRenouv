<?php
session_start();
ini_set('display_errors', 'off');
require('mysql.php');
$my=new mysql();
require('ttre_adm/class.upload.php');
$nom_client='TousRenov';
$url_site_client='http://tousrenov.fr';
// creation-site-web-tunisie.net/trn
//$logo_client='http://tousrenov.fr/images/logo.png';
$temp = $my->req_arr('SELECT * FROM logo WHERE id=1 ');
$logo_client='upload/logo/150X100/'.$temp['photo'];
$mail_client='';

$tab_etes1=array(1=>'Particuler',
				2=>'Société',
				3=>'Commércant',
				4=>'Industriel',
				5=>'Libéral',
				6=>'Syndic',
				7=>'Promoteur',
				8=>'Administration',
				9=>'Association',
				10=>'Architecte',
				11=>'Agence immobilier',
				12=>'Autre');
$tab_etes2=array(1=>'Propriétaire',
				2=>'Locataire');
$tab_connus=array(1=>'Journal',
				2=>'Radio',
				3=>'Télévision',
				4=>'Internet',
				5=>'Bouche à orellle',
				6=>'Adresse',
				7=>'Autre');




if ( isset($_SESSION['id_client_trn_affil']) )
{
	$user =  $my->req_arr('SELECT * FROM ttre_users WHERE id_user="'.$_SESSION['id_client_trn_affil'].'"');
	if ( $user['statut']==0 )
	{
		if ( isset($_SESSION['id_connect_admin']) )
		{
			$my->req('UPDATE ttre_connection_admin SET fin="'.time().'" WHERE id = '.$_SESSION['id_connect_admin'].' ' );
		}
		session_destroy();
	}
}

	/*function _suppr_speciauxxx($nom)
	{
		$dest = strtr(strtolower($nom),'����������������������������������������������������/\'','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy__');
		$dest = strtr($dest,' ','_');
		$dest = strtr($dest,"'","_");
		return $dest;
	}*/

	function suppr_speciauxxx($chaine)
	{
		$caracteres=array( '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '@' => 'a',
				'�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e',
				'�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i',
				'�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o',
				'�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u',
				'�' => 'oe', '�' => 'oe',
				'$' => 's', ' ' =>'_');
	
		$chaine = strtr(html_entity_decode($chaine), $caracteres);
		//$chaine = preg_replace('#[^A-Za-z0-9]+#', '-', $chaine);
		$chaine = trim($chaine, '-');
		$chaine = strtolower($chaine);
	
		return $chaine;
	}
	
	
	
	

	function rediriger($location)
	{
		echo '<script>window.location="'.$location.'"</script>';
	}	
	

?>
<script type="text/javascript">
$(document).ready(function()
{

	// todo decomment this
	/* function testchat()
	{
		$.ajax({
			 type: 'post',
			 url: 'AjaxVerifChat.php',
			 success: function(msg)
				{	
					if (msg)
					{
						alert(msg);
					}					 
				}
		 });	
	}
	//setInterval (testchat, 1000);	//Reload file every 2.5 seconds*/

});	
</script>