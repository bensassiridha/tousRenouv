<?php
	session_start();
	ini_set('display_errors', 'off');
	error_reporting(E_ALL);
	require('mysql.php');
	require('formulaire.php');
	require('fonctions.php');
	require('class.upload.php');
	include("inc/inc_photo_bg.php");
	$rand = substr(mt_rand(),1,4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TOUSRENOV | ADMINISTRATION</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />

		<!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" href="ie6.css"/>
		<![endif]-->
<script type="text/javascript" src="clockp.js"></script>
<script type="text/javascript" src="clockh.js"></script> 
<!-- <script type="text/javascript" src="jquery.min.js"></script> -->

<script type="text/javascript" src="calandar/jquery-1.3.2.js"></script>

 <script type="text/javascript" src="ddaccordion.js"></script> 
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>








 <script type="text/javascript" src="jconfirmaction.jquery.js"></script> 
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
	function contenu_connect_admin()
	{
		$.ajax({
			 type: "post",
			 url: "AjaxConnectAdmin.php",
			 success: function(msg)
				{	
					//alert(msg);	 
				}
		 });
	}
	setInterval (contenu_connect_admin, 60000);//60000=1minute  900000=15minute
	
</script>



<script src="librairie.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/verifs.js"></script>
		<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<!-- 		<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" />	 -->
		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
        
        
        
        
        
        
        
        
        
        
        
        
        
<link type="text/css" href="style_alert.css" rel="stylesheet" />	        


</head>
