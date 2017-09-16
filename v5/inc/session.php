<?php
session_start();
require('mysql.php');
$my=new mysql();
require('ttre_adm/class.upload.php');
$nom_client='TousRenov';
$url_site_client='http://tousrenov.fr';
// creation-site-web-tunisie.net/trn
$logo_client='http://tousrenov.fr/images/logo.png';
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
?>