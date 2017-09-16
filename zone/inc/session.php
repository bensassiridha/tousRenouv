<?php
session_start();
require('mysql.php');
$my=new mysql();
require('../ttre_adm/class.upload.php');
$nom_client='TousRenov';
$url_site_client='http://tousrenov.fr';
// creation-site-web-tunisie.net/trn
//$logo_client='http://tousrenov.fr/images/logo.png';
$temp = $my->req_arr('SELECT * FROM logo WHERE id=1 ');
$logo_client='../upload/logo/150X100/'.$temp['photo'];
$mail_client='';

$tab_etes1=array(1=>'Particuler',
				2=>'SociÃ©tÃ©',
				3=>'CommÃ©rcant',
				4=>'Industriel',
				5=>'LibÃ©ral',
				6=>'Syndic',
				7=>'Promoteur',
				8=>'Administration',
				9=>'Association',
				10=>'Architecte',
				11=>'Agence immobilier',
				12=>'Autre');
$tab_etes2=array(1=>'PropriÃ©taire',
				2=>'Locataire');
$tab_connus=array(1=>'Journal',
				2=>'Radio',
				3=>'TÃ©lÃ©vision',
				4=>'Internet',
				5=>'Bouche Ã  orellle',
				6=>'Adresse',
				7=>'Autre');



function suppr_speciauxxx($chaine)
{
	$caracteres=array( 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
			'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
			'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
			'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
			'Œ' => 'oe', 'œ' => 'oe',
			'$' => 's', ' ' =>'_');

	$chaine = strtr(html_entity_decode($chaine), $caracteres);
	//$chaine = preg_replace('#[^A-Za-z0-9]+#', '-', $chaine);
	$chaine = trim($chaine, '-');
	$chaine = strtolower($chaine);

	return $chaine;
}

?>