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
$logo_client=$temp['logo'];

$mail_client='';

$tab_etes1=array(1=>'Particuler',
				2=>'SociΓ©tΓ©',
				3=>'CommΓ©rcant',
				4=>'Industriel',
				5=>'LibΓ©ral',
				6=>'Syndic',
				7=>'Promoteur',
				8=>'Administration',
				9=>'Association',
				10=>'Architecte',
				11=>'Agence immobilier',
				12=>'Autre');
$tab_etes2=array(1=>'PropriΓ©taire',
				2=>'Locataire');
$tab_connus=array(1=>'Journal',
				2=>'Radio',
				3=>'TΓ©lΓ©vision',
				4=>'Internet',
				5=>'Bouche Γ  orellle',
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
		$dest = strtr(strtolower($nom),'ΐΑΒΓΔΕΗΘΙΚΛΜΝΞΟÒΣΤΥΦΩΪΫάέΰαβγδεηθικλμνξοπςστυφωϊϋόύÿ/\'','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy__');
		$dest = strtr($dest,' ','_');
		$dest = strtr($dest,"'","_");
		return $dest;
	}*/

	function suppr_speciauxxx($chaine)
	{
		$caracteres=array( 'Α' => 'a', 'Β' => 'a', 'Δ' => 'a', 'ΰ' => 'a', 'α' => 'a', 'β' => 'a', 'δ' => 'a', '@' => 'a',
				'Θ' => 'e', 'Ι' => 'e', 'Κ' => 'e', 'Λ' => 'e', 'θ' => 'e', 'ι' => 'e', 'κ' => 'e', 'λ' => 'e', '€' => 'e',
				'Μ' => 'i', 'Ν' => 'i', 'Ξ' => 'i', 'Ο' => 'i', 'μ' => 'i', 'ν' => 'i', 'ξ' => 'i', 'ο' => 'i',
				'Ò' => 'o', 'Σ' => 'o', 'Τ' => 'o', 'Φ' => 'o', 'ς' => 'o', 'σ' => 'o', 'τ' => 'o', 'φ' => 'o',
				'Ω' => 'u', 'Ϊ' => 'u', 'Ϋ' => 'u', 'ά' => 'u', 'ω' => 'u', 'ϊ' => 'u', 'ϋ' => 'u', 'ό' => 'u', 'µ' => 'u',
				'' => 'oe', '' => 'oe',
				'$' => 's', ' ' =>'_');
	
		$chaine = strtr(html_entity_decode($chaine), $caracteres);
		//$chaine = preg_replace('#[^A-Za-z0-9]+#', '-', $chaine);
		$chaine = trim($chaine, '-');
		$chaine = strtolower($chaine);
	
		return $chaine;
	}

?>