<?php

define('SMSENVOI_EMAIL','contact@tousrenov.fr');
define('SMSENVOI_APIKEY','9K39LU32P2W9AEA99AN9');
define('SMSENVOI_VERSION','3.0.4');
//ADDED SINCE 3.0.1 : STOPS
//ADDED SINCE 3.0.2 : CALLS
//ADDED SINCE 3.0.3 : RICHSMS

function iscurlinstalled() {
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else{
		return false;
	}
}

if(!iscurlinstalled()){ die("L'API SMSENVOI NECESSITE L'INSTALLATION DE CURL"); }

?>