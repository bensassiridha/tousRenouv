<?php
session_start();
require('mysql.php');
$my=new mysql();
require('ttre_adm/class.upload.php');
$nom_client='TousRenov';
$url_site_client='http://creation-site-web-tunisie.net/trn';
$logo_client='http://creation-site-web-tunisie.net/trn/images/logo.png';
$mail_client='';

$tab_etes1=array(1=>'Particuler',
				2=>'Soci�t�',
				3=>'Comm�rcant',
				4=>'Industriel',
				5=>'Lib�ral',
				6=>'Syndic',
				7=>'Promoteur',
				8=>'Administration',
				9=>'Association',
				10=>'Architecte',
				11=>'Agence immobilier',
				12=>'Autre');
$tab_etes2=array(1=>'Propri�taire',
				2=>'Locataire');
$tab_connus=array(1=>'Journal',
				2=>'Radio',
				3=>'T�l�vision',
				4=>'Internet',
				5=>'Bouche � orellle',
				6=>'Adresse',
				7=>'Autre');
?>