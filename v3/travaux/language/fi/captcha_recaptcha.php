<?php
/**
*
* recaptcha [Finnish]
*
* @package language
* @version $Id: captcha_recaptcha.php 9933 2009-08-06 09:12:21Z marshalrusty $
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'RECAPTCHA_LANG'				=> 'fi',
	'RECAPTCHA_NOT_AVAILABLE'		=> 'reCaptchan käyttöä varten tarvitset käyttäjätilin. Voit rekisteröidä tilin osoitteessa <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',
	'CAPTCHA_RECAPTCHA'				=> 'reCaptcha',
	'RECAPTCHA_INCORRECT'			=> 'Antamasi visuaalinen varmennus oli väärin',

	'RECAPTCHA_PUBLIC'				=> 'Avoin reCaptcha-avain',
	'RECAPTCHA_PUBLIC_EXPLAIN'		=> 'Avoin reCaptcha-avaimesi. Avaimia voi hankkia osoitteesta <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a></a>.',
	'RECAPTCHA_PRIVATE'				=> 'Yksityinen reCaptcha-avain',
	'RECAPTCHA_PRIVATE_EXPLAIN'		=> 'Yksityinen reCaptcha-avain. Avaimia voi hankkia osoitteesta <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',

	'RECAPTCHA_EXPLAIN'				=> 'Haluamme sinun kirjoittavan nämä kaksi sanaa vieressä olevaan laatikkoon. Tämän on tarkoitus estää automaattista roskapostitusta.',
));

?>