<?php
	session_start();
	include('./validation.php');
	include_once('./include/mp3captchaform.php');
	$mp3captcha= new mp3captcha();
	$mp3captcha->url = $_SERVER['validation.php'];
	$mp3captcha->langswitch();
	if (isset($_GET['cfsnd']))
	{
   /* output captcha mp3 */
	   $mp3captcha->mp3stitch();
	}
	elseif(isset($_GET['cfimg']))
	{
	   /* output captcha image */
	   $mp3captcha->image();
	}
	if ($mp3captcha->post())
	{
   // Do your POST action here
	}

?> 

<?php
/********************************************************************************
* MP3 captchaform HTML - Echo this in your form
********************************************************************************/
echo $mp3captcha->html();
?>
<?php
   /* Create a page for the mp3 and link to it in the below javascript
   Set the : var mp3cf to link to this page
   */
include_once('./include/mp3captchaform.php');
   /* init captchaform class */
$mp3captcha= new mp3captcha($_SESSION['your_captcha_session']);
   /* create mp3 */
$mp3captcha->mp3stitch();
?>

<?php
/* validation part */
if (strtolower($_POST['your_captchaval']) == strtolower($_SESSION['your_captcha_session'])) {
  echo "It passed";
}
/*
Javascript and Html to use with your form
*/
echo '
<script language="javascript" type="text/javascript">
   
   var mp3cf = "/captcha/mp3captcha.php";
 
   var delaytime = 2500;
 
   var IEswitch = true;
   var msie = navigator.userAgent.toLowerCase();
   msie = (msie.indexOf("msie") > -1) ? true : false;
   function captchaMp3() {
       var d = new Date();
       if (delayer) {
           return false;
       }
       delayer = true;
       setTimeout(\'resetdelay()\', delaytime);
       if (IEswitch && document.all && msie) {    
       
           if (Number(parseFloat(navigator.appVersion.split(\'MSIE\')[1])) < 7) {
               embed = document.createElement("bgsound");
               embed.setAttribute("src", mp3cf + "?cfsnd=" + d.getTime());
               document.getElementsByTagName("body")[0].appendChild(embed);
               return true;
           }
       }
       if (document.getElementById) {
           var mp3player = \'<embed src="\' + mp3cf + "?cfsnd=" + d.getTime() + \'"\';
           mp3player += \' hidden="true" type="audio/x-mpeg" autostart="true" />\';
           document.getElementById(\'codecf\').innerHTML = mp3player;
       }
       return true;
   }
   function resetdelay() {
      delayer = false;
   }
  //--></script>
<div id="codecf" style="position: absolute; width: 1px; height: 1px; visible: hidden;">
</div>

<a href="javascript:captchaMp3();void(0)" onmouseover="window.status=\'\'; return true;">Listen to code</a>
';
?> 