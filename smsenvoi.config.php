<?php

define('SMSENVOI_EMAIL','bilelbadri@gmail.com');
define('SMSENVOI_APIKEY','EL9H66D2M3NPWL84TEHH');
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