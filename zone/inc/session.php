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

?>