<?php
error_reporting(E_ALL);
session_start();
/********************************************************************************
* MP3 captchaform START INIT
* Include the mp3captchaformPHP4.php when your still not on PHP5
* The mp3captchaform.php is for PHP5 and up
********************************************************************************/
require_once('./include/mp3captchaform.php');

	/* init captchaform class */
$mp3captcha= new mp3captcha();
	/* set the current url */
$mp3captcha->url = $_SERVER['SCRIPT_NAME'];
	/* language switch */
$mp3captcha->langswitch();
	/* optional */
// $mp3captcha->session = "captcha_session_name";
// $mp3captcha->formkey = "form_captcha_field_name";
// $mp3captcha->dnsbl = array('zen.spamhaus.org','bl.spamcop.net','list.dsbl.org','tor.ahbl.org','opm.tornevall.org');

if (isset($_GET['cfsnd'])) {
		/* use language mapping */
	// $mp3captcha->mapping = true;
		/* output captcha mp3 */
	$mp3captcha->mp3stitch();
} else if (isset($_GET['cfimg'])) {
		/* options - see class for more info */
	// $mp3captcha->codelength = 6;
	// $mp3captcha->fonts =array("fontname1", "fontname2");
	// $mp3captcha->type = "gif";
	// $mp3captcha->transparant = "FFFFFF";
	// $mp3captcha->backgrounds =array("bg1.gif", "bg2.jpg");
	// $mp3captcha->fontsize = 20;
	// $mp3captcha->colors = array("FF0000", "990099", "0000FF");
	// $mp3captcha->shades = array("FFFF00");
	// $mp3captcha->shadesize = 2;
	// $mp3captcha->rotate = 30;
		/* output captcha image */
	$mp3captcha->image();
}

	/* validate captcha value on post - validation can also be done on a different page 
	set the session_start(); and $mp3captcha= new mp3captcha(); first on a different page */
$msg = "";
if ($mp3captcha->post()) { 
	$msg = "Your captcha code is correct";
	// Do your POST action here
}

/********************************************************************************
* MP3 captchaform END INIT
********************************************************************************/
?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
		<title>
		Mp3 Captcha Form
		</title>
<meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
</head>
<body>

<br />
<div style="position: absolute; left: 150px; z-index: 10;">
<form action="" method="post">
<br />
<?php echo $msg; ?>
<br />
<br />


<?php 
/********************************************************************************
* MP3 captchaform HTML
********************************************************************************/
/* optinal set another template */
// $mp3captcha->template = 'captcha_js.txt';
echo $mp3captcha->html(); 
?>


<input type="submit" value="Send form" id="submit" />
</form>
</div>
</body>
</html>
