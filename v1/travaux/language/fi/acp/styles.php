<?php
/** 
*
* acp_styles [Finnish]
*
* @package language
* @copyright (c) 2006 phpBB Group 
* @author 2006-11-14 - Lurttinen@phpbbsuomi.com
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
	'ACP_IMAGESETS_EXPLAIN'	=> 'Kuvapaketteihin kuuluvat kaikki keskustelufoorumilla käytössä olevat kuvat mukaanlukien myös käytettävästä tyylistä riippumattomat kuvat. Voit ladata kuvapaketteja koneellesi, muokata niitä, poistaa ja halutessasi lisätä uusia paketteja.',
	'ACP_STYLES_EXPLAIN'	=> 'Täällä voit muokata käytettävissä olevia tyylejä. Tyyliin kuuluu mallineet, teemat ja kuvapaketit. Voit muokata jo asennettuja tyylejä, poistaa, ottaa käyttöön, luoda tai tuoda uusia. Voit katsoa miltä uusi tyyli näyttää käyttämällä esikatselua. Oletustyyli on merkitty tähtimerkillä (*). Tilasto näyttää myös kuinka monta käyttäjää on asettanut tietyn tyylin omaksi tyylikseen. Huomaa, että käyttäjän tyylin ohitus ei näy tässä listassa.',
	'ACP_TEMPLATES_EXPLAIN'	=> 'mallineet sisältävät kaiken tarvittavan kuvauksen sivun rakentamiseksi. Täällä voit muokata olemassa olevia mallineita, postaa, viedä, tuoda uusia ja esikatsella. Voit myös muokata BBCoden käyttämää koodia.',
	'ACP_THEMES_EXPLAIN'	=> 'Täällä voit luoda, asentaa, muokata, poistaa ja viedä mallineita. Teemat ovat kokoelma värejä ja kuvia, jotka lisätään käytettävissä olevaan mallinein, jossa luodaan keskustelufoorumin perus näkymä. Käytettävissä olevat vaihtoehdot riippuvat palvelimen asetuksista ja phpBB asennuksesta. Katso lisätietoja käyttö-oppaasta. Huomaa, että luodessasi uutta teemaa voit halutessasi käyttää vanhaa teemaa pohjana.',
	'ADD_IMAGESET'			=> 'Luo kuvapaketti',
	'ADD_IMAGESET_EXPLAIN'	=> 'Täällä voit luoda uusia kuvapaketteja. Palvelimen asetuksista ja tiedostojen oikeuksista riippuen sinulla voi olla enemmän vaihtoehtoja käytettävissä. Voit esimerkiksi perustaa tämän kuvapaketin olemassa olevien mukaan. Voit mahdollisesti ladata (store-hakemistosta) varastoidun kuvapaketin. Mikäli käytät varastoa, Kuvapaketin nimi voidaan ottaa vaihtoehtoisesti myös varastoidun paketin nimestä (Tämän tehdäksesi, jätä nimikenttä tyhjäksi).',
	'ADD_STYLE'				=> 'Luo tyyli',
	'ADD_STYLE_EXPLAIN'		=> 'Täällä voit luoda uuden tyylin. Palvelimen konfiguraatiosta ja tiedostojen oikeuksista riippuen sinulla voi olla lisä-asetuksia käytössäsi. Voit esimerkiksi käyttää uden tyylin pohjanan jotain vanhaa tyyliä. Voit myös mahdollisesti siirtää suoraan palvelimelle tai tuoda tyylin arkistotiedostoon (store-hakemistosta). Mikäli siirrät tai lataat tyylin arkistoon. Sen nimi määritellään automaattisesti.',
	'ADD_TEMPLATE'			=> 'Luo malline',
	'ADD_TEMPLATE_EXPLAIN'	=> 'Täällä voit lisätä uuden mallineen. Palvelimen konfiguraatiosta ja tiedostojen oikeuksista riippuen sinulla voi olla lisä-asetuksia käytössäsi. Voit esimerkiksi käyttää uden tyylin pohjanan jotain vanhaa mallinea. Voit myös mahdollisesti siirtää suoraan palvelimelle tai tuoda mallineen arkistotiedostoon (store-hakemistosta). Mikäli siirrät tai lataat mallineen. Sen nimi voidaan vaihtoehtoisesti ottaa myös arkistotiedoston nimestä.',
	'ADD_THEME'				=> 'Luo teema',
	'ADD_THEME_EXPLAIN'		=> 'Täällä voit luoda uuden teeman. Palvelimen konfiguraatiosta ja tiedostojen oikeuksista riippuen sinulla voi olla lisä-asetuksia käytössäsi. Voit esimerkiksi käyttää uden teeman pohjanan jotain vanhaa teemaa. Voit myös mahdollisesti siirtää suoraan palvelimelle tai tuoda teeman arkistotiedostoon (store-hakemistosta). Mikäli siirrät tai lataat teeman. Sen nimi voidaan vaihtoehtoisesti ottaa myös arkistotiedostosta (Tämän tehdäksesi jätä nimi tyhjäksi)',
	'ARCHIVE_FORMAT'		=> 'Tiedoston tyyppi',
	'AUTOMATIC_EXPLAIN'		=> 'Jätä tyhjäksi yrittääksesi automaattista tunnistusta.',

	'BACKGROUND'			=> 'Tausta',
	'BACKGROUND_COLOUR'		=> 'Taustan väri',
	'BACKGROUND_IMAGE'		=> 'Taustakuva',
	'BACKGROUND_REPEAT'		=> 'Taustan toisto',
	'BOLD'					=> 'lihavoitu',

	'CACHE'							=> 'Välimuisti',
	'CACHE_CACHED'					=> 'Välimuistissa',
	'CACHE_FILENAME'				=> 'malline tiedosto',
	'CACHE_FILESIZE'				=> 'Tiedoston koko',
	'CACHE_MODIFIED'				=> 'Muokattu',
	'CONFIRM_IMAGESET_REFRESH'		=> 'Haluatko varmasti virkistää kuvapaketit uudestaan? Kuvapaketin asetustiedosto ylikirjoittaa kaikki editorissa annetut tiedot.',
	'CONFIRM_TEMPLATE_CLEAR_CACHE'	=> 'Haluatko varmasti poistaa kaiken mallineihin liittyvän tiedon välimuistista?',
	'CONFIRM_TEMPLATE_REFRESH'		=> 'Haluatko varmasti virkistää tietokannassa olevan mallinetiedon käyttämällä tiedostojärjestelmässä olevia tiedostoja pohjana? Tämä ylikirjoittaa kaikki mallineihin liittyvät tiedot jotka on lisätty malline editorilla sillävälin, kun mallineen tiedot ovat olleet tallennettuna tietokantaan.',
	'CONFIRM_THEME_REFRESH'			=> 'Haluatko varmasti virkistää tietokannassa olevan teeman käyttämällä tiedostojärjestelmässä olevia tiedostoja pohjana? Tämä ylikirjoittaa kaikki teemoihin liittyvät tiedot jotka on lisätty teema editorilla sillävälin, kun teeman tiedot ovat olleet tallennettuna tietokantaan.',
	'COPYRIGHT'						=> 'Tekijänoikeudet',
	'CREATE_IMAGESET'				=> 'Luo uusi kuvapaketti',
	'CREATE_STYLE'					=> 'Luo uusi tyyli',
	'CREATE_TEMPLATE'				=> 'Luo uusi mallinepaketti',
	'CREATE_THEME'					=> 'Luo uusi teema',
	'CURRENT_IMAGE'					=> 'Nykyinen kuva',

	'DEACTIVATE_DEFAULT'		=> 'Et voi poistaa oletustyyliä käytöstä.',
	'DELETE_FROM_FS'			=> 'Poista tiedostojärjestelmästä',
	'DELETE_IMAGESET'			=> 'Poista kuvapaketti',
    'DELETE_IMAGESET_EXPLAIN'   => 'Täällä voit poistaa valitsemasi kuvapaketin tietokannasta. Huomaa, että toimintoa ei voi peruuttaa. Kuvapaketin vienti talteen myöhempää käyttöä varten on suositeltavaa.',
    'DELETE_STYLE'              => 'Poista tyyli',
    'DELETE_STYLE_EXPLAIN'      => 'Täällä voit poistaa valitsemasi tyylin. Ole varovainen, sillä tyyliä ei voi palauttaa sen jälkeen, kun se on poistettu. ',
    'DELETE_TEMPLATE'           => 'Poista malline',
    'DELETE_TEMPLATE_EXPLAIN'   => 'Täällä voit poistaa valitsemasi mallineen tietokannasta. Huomaa, että toimintoa ei voi peruuttaa. Mallineen vienti talteen myöhempää käyttöä varten on suositeltavaa.',
    'DELETE_THEME'              => 'Poista teema',
    'DELETE_THEME_EXPLAIN'      => 'Täällä voit poistaa valitsemasi teeman tietokannasta. Huomaa, että toimintoa ei voi peruuttaa. Teeman vienti talteen myöhempää käyttöä varten on suositeltavaa.',
	'DETAILS'					=> 'Tiedot',
	'DIMENSIONS_EXPLAIN'		=> 'Valitsemalla kyllä tähän. Voit lisätä leveys/korkeus arvot.',

	'EDIT_DETAILS_IMAGESET'				=> 'Muokkaa kuvapaketin yksityiskohtia',
	'EDIT_DETAILS_IMAGESET_EXPLAIN'		=> 'Täällä voit muokata kuvapaketin yksityiskohtia, kuten sen nimeä.',
	'EDIT_DETAILS_STYLE'				=> 'Muokkaa tyyliä',
	'EDIT_DETAILS_STYLE_EXPLAIN'		=> 'Voit muokata olemassaolevaa tyyliä käyttämällä alapuolella olevaa lomaketta. Voit muokata käytettävää mallinea, teemaa ja kuvapakettia jotka määrittelevät tyylin kokonaisuudessaan. Voit myös tehdä tästä tyylistä oletustyylin.',
	'EDIT_DETAILS_TEMPLATE'				=> 'Muokkaa mallineen yksityiskohtia',
	'EDIT_DETAILS_TEMPLATE_EXPLAIN'		=> 'Täällä voit muokata templatteihin liittyviä yksityiskohta, kuten sen nimeä. Sinulla voi olla mahdollisuus siirtää tyylitiedoston tallennuspaikka tiedostojärjestelmästä tietokantaan, tai päinvastoin. Tämä vaihtoehto riippuu palvelimen PHP konfiguraatiosta voiko palvelin kirjoittaa mallineihin.',
	'EDIT_DETAILS_THEME'				=> 'Muokkaa teeman yksityiskohtia',
	'EDIT_DETAILS_THEME_EXPLAIN'		=> 'Täällä voit muoksts teemaan liittyviä yksityiskohta, kuten sen nimeä. Sinulla voi olla mahdollisuus siirtää tyylitiedoston tallennuspaikka tiedostojärjestelmästä tietokantaan, tai päinvastoin. Tämä vaihtoehto riippuu palvelimen PHP konfiguraatiosta voiko palvelin kirjoittaa tyylitiedostoon.',
	'EDIT_IMAGESET'						=> 'Muokkaa kuvapakettia',
	'EDIT_IMAGESET_EXPLAIN'				=> 'Täällä voit muokata yksittäisiä kuvia, jotka määrittävät kuvapaketin. Voit myös määrittää kuvalle koon. Kuvan koon määrittäminen ei ole pakollista, mutta se voi auttaa ratkaisemaan ongelmia, joita joillain selaimilla voi olla sivun näyttämisessä. Mikäli et määrittele kokoa. Tietokannan koko pienenee hieman.',
	'EDIT_TEMPLATE'						=> 'Muokkaa mallinea',
	'EDIT_TEMPLATE_EXPLAIN'				=> 'Täällä voit muokata mallinepakettia suoraan. Huomaa, että nämä muutokset ovat pysyviä, eikä niitä voida perua sen jälkeen, kun olet lähettänyt muutokset. Mikäli PHP voi kirjoittaa palvelimen tiedostoihin. Kaikki muokkaukset tehdään suoraan niihin. Mikäli PHP ei voi kirjoittaa tiedostoihin. Muokkaukset tehdään tietokantaan ja vain sitä muokataan. Ole huolellinen, kun muokkaat mallinepakettia, Muista sulkea kaikki lausekkeet {XXXX} Ja suhteelliset käskyt.',
	'EDIT_TEMPLATE_STORED_DB'			=> 'mallinepaketti ei ole kirjoitettavissa, joten muokkaukset tallennettiin tietokantaan.',
	'EDIT_THEME'						=> 'Muokkaa teemaa',
	'EDIT_THEME_EXPLAIN'				=> 'Täällä voit muokata valitsemaasi teemaa. Vaihtaa värejä, kuvia, jne. Voit vaihtaa pois yksinkertaisesta näkymästä, jossa voit vaihtaa värejä, jne. Ja siirtyä tarkempaan näkymään, jossa voit muokata "raakaa CSS tietoa". Raaka muokkaus antaa sinun määritellä myös omia muokkauksia, kuten reunuksia, jne. Käytä vain niitä parametrejä, joita tarvitse ja jätä mut tyhjiksi.',
	'EDIT_THEME_STORED_DB'				=> 'Tyylitiedosto ei ole kirjoitettavissa, joten muutokset tallennettiin tietokantaan.',
	'EDIT_THEME_STORE_PARSED'			=> 'Tämä teema vaatii tyylitiedostonsa suorittamista. Tämä on mahdollista vain, mikäli se on tallennettu tietokantaan.',
    'EDITOR_DISABLED'               => 'Tyylin muokakus on poissa käytöstä.',
	'EXPORT'							=> 'Vie',

	'FOREGROUND'			=> 'Etuala',
	'FONT_COLOUR'			=> 'Fontin väri',
	'FONT_FACE'				=> 'Fontin tyyppi',
	'FONT_FACE_EXPLAIN'		=> 'Voit määrittää usean fontin erottamalla ne toisistaan pilkulla. Mikäli käyttäjällä ei ole tätä fonttia asennettuna, seuraavaksi toimiva fontti valitaan käyttöön.',
	'FONT_SIZE'				=> 'Fontin koko',

	'GLOBAL_IMAGES'			=> 'Yleinen',

	'HIDE_CSS'				=> 'Piilota raaka CSS tieto',

	'IMAGE_WIDTH'				=> 'Kuvan leveys',
	'IMAGE_HEIGHT'				=> 'Kuvan korkeus',
	'IMAGE'						=> 'Kuva',
	'IMAGE_NAME'				=> 'Kuvan nimi',
	'IMAGE_PARAMETER'			=> 'Parametri',
	'IMAGE_VALUE'				=> 'Arvo',
	'IMAGESET_ADDED'			=> 'Uusi kuvapaketti lisätty tiedostojärjestelmään',
	'IMAGESET_ADDED_DB'			=> 'Uusi kuvapaketti lisätty tietokantaan',
	'IMAGESET_DELETED'			=> 'Kuvapaketti on poistettu',
	'IMAGESET_DELETED_FS'		=> 'Kuvapaketti on poistettu tietokannasta, mutta joitain tiedotoja saattaa olla jäljellä tiedostojärjestelmässä',
	'IMAGESET_DETAILS_UPDATED'	=> 'Kuvapaketin tiedot ovat päivitetty',
	'IMAGESET_ERR_ARCHIVE'		=> 'Ole hyvä ja valitse arkistointitapa',
	'IMAGESET_ERR_COPY_LONG'	=> 'Tekijänoikeustiedot eivät voi olla 60 merkkiä pidemmät',
	'IMAGESET_ERR_NAME_CHARS'	=> 'Kuvapaketin nimessa voi olla vain alphanumeerisia merkkejä, -, +, _ ja välilyöntejä',
	'IMAGESET_ERR_NAME_EXIST'	=> 'Tämän niminen kuvapaketti on jo olemassa',
	'IMAGESET_ERR_NAME_LONG'	=> 'Kuvapaketin nimi ei voi olla 30 merkkiä pidempi',
	'IMAGESET_ERR_NOT_IMAGESET'	=> 'Määrittämässäsi arkistossa ei ole kelvollista kuvapakettia.',
	'IMAGESET_ERR_STYLE_NAME'	=> 'Anna nimi tälle kuvapaketille',
	'IMAGESET_EXPORT'			=> 'Vie kuvapaketti',
	'IMAGESET_EXPORT_EXPLAIN'	=> 'Täällä voit viedä kuvapaketin arkistoon. Tämä arkisto pitää sisällään kaiken tarvittavan tiedon, jotta sen voi asentaa toiselle keskustelufoorumille. Voit vlita lataatko tiedoston omalle koneellesi tai tallentaa sen store-hakemistoon myöhmpää käyttöä varten.',
	'IMAGESET_EXPORTED'			=> 'Kuvapaketti on viety onnistuneesti ja tallenenttu %s',
	'IMAGESET_NAME'				=> 'Kuvapaketin nimi',
	'IMAGESET_REFRESHED'		=> 'Kuvapaketti on virkistetty',
	'IMAGESET_UPDATED'			=> 'Kuvapaketti on päivitetty',
	'ITALIC'					=> 'Kursiivi',

	'IMG_CAT_BUTTONS'		=> 'Lokalisoidut nappulat',
	'IMG_CAT_CUSTOM'		=> 'Mukautetut kuvat',
	'IMG_CAT_FOLDERS'		=> 'Viestiketjujen kuvakkeet',
	'IMG_CAT_FORUMS'		=> 'Alueen kuvakkeet',
	'IMG_CAT_ICONS'			=> 'Yleiset kuvakkeet',
	'IMG_CAT_LOGOS'			=> 'Logot',
	'IMG_CAT_POLLS'			=> 'Äänestyksien kuvat',
	'IMG_CAT_UI'			=> 'Yleiset käyttöliittymän elementit',
	'IMG_CAT_USER'			=> 'Lisäkuvia',

	'IMG_SITE_LOGO'			=> 'Logo',
	'IMG_UPLOAD_BAR'		=> 'Latauksen edistymisen osoitin',
	'IMG_POLL_LEFT'			=> 'Äänestyksen vasemmanpuoleinen pääte',
	'IMG_POLL_CENTER'		=> 'Äänestyksen keskusta',
	'IMG_POLL_RIGHT'		=> 'Äänestyksen oikeanpuoleinen pääte',
	'IMG_ICON_FRIEND'		=> 'Lisää ystäväksi',
	'IMG_ICON_FOE'			=> 'Lisää vihamieheksi',

	'IMG_FORUM_LINK'			=> 'Alue linkki',
	'IMG_FORUM_READ'			=> 'Alue',
	'IMG_FORUM_READ_LOCKED'		=> 'Alue on lukittu',
	'IMG_FORUM_READ_SUBFORUM'	=> 'Sisäalueet',
	'IMG_FORUM_UNREAD'			=> 'Alueella on uusia viestejä',
	'IMG_FORUM_UNREAD_LOCKED'	=> 'Alue on lukittu ja sisältää uusia viestejä',
	'IMG_FORUM_UNREAD_SUBFORUM'	=> 'Sisäalueiden uudet viestit',
	'IMG_SUBFORUM_READ'			=> 'Näytä sisäalue etusivulla',
	'IMG_SUBFORUM_UNREAD'		=> 'Näytä alueen uudet viestit etusivulla',

	'IMG_TOPIC_MOVED'			=> 'Viestiketju on siirretty',

	'IMG_TOPIC_READ'				=> 'Viestiketju',
	'IMG_TOPIC_READ_MINE'			=> 'Viestiketju johon olen vastannut',
	'IMG_TOPIC_READ_HOT'			=> 'Viestiketju on suosittu',
	'IMG_TOPIC_READ_HOT_MINE'		=> 'Suosittu viestiketju johon olen vastannut',
	'IMG_TOPIC_READ_LOCKED'			=> 'Viestiketju on lukittu',
	'IMG_TOPIC_READ_LOCKED_MINE'	=> 'Lukittu viestiketju on lähetetty alueelle',

	'IMG_TOPIC_UNREAD'				=> 'Viestiketjussa on uusia viestejä',
	'IMG_TOPIC_UNREAD_MINE'			=> 'Vastaamaani viestiektjuun on tullut uusi vastaus',
	'IMG_TOPIC_UNREAD_HOT'			=> 'Suositussa viestiketjussa on uusia viestejä',
	'IMG_TOPIC_UNREAD_HOT_MINE'		=> 'Vastaamaani suosittuun viestiketjuun on tullut uusia viestejä',
	'IMG_TOPIC_UNREAD_LOCKED'		=> 'Uusi viesti, joka on lukittu',
	'IMG_TOPIC_UNREAD_LOCKED_MINE'	=> 'Kirjoittamani viestiketju on lukittu ja siinä on uusia viestejä',

	'IMG_STICKY_READ'				=> 'Tiedote',
	'IMG_STICKY_READ_MINE'			=> 'Pysyvä tiedote, johon olen vastannut',
	'IMG_STICKY_READ_LOCKED'		=> 'Lukittu pysyvä tiedote',
	'IMG_STICKY_READ_LOCKED_MINE'	=> 'Lukittu pysyvä tiedote, johon olen vastannut',
	'IMG_STICKY_UNREAD'				=> 'Uusi pysyvä tiedote',
	'IMG_STICKY_UNREAD_MINE'		=> 'Uusi pysyvä tiedote, johon olen vastannut',
	'IMG_STICKY_UNREAD_LOCKED'		=> 'Lukitty pysyvä tiedote, jossa on uusia viestejä',
	'IMG_STICKY_UNREAD_LOCKED_MINE'	=> 'Lukitty pysyvä tiedote, johon olen kirjoittanut',

	'IMG_ANNOUNCE_READ'					=> 'Tiedote',
	'IMG_ANNOUNCE_READ_MINE'			=> 'Tiedote, johon olen kirjoittanut',
	'IMG_ANNOUNCE_READ_LOCKED'			=> 'Lukittu tiedote',
	'IMG_ANNOUNCE_READ_LOCKED_MINE'		=> 'Lukittu tiedote, johon olen kirjoittanut',
	'IMG_ANNOUNCE_UNREAD'				=> 'Lukematon tiedote',
	'IMG_ANNOUNCE_UNREAD_MINE'			=> 'Tiedote, johon olen vastannut',
	'IMG_ANNOUNCE_UNREAD_LOCKED'		=> 'Tiedote, joka on lukittu',
	'IMG_ANNOUNCE_UNREAD_LOCKED_MINE'	=> 'Lukittu tiedote, johon olen vastannut',

	'IMG_GLOBAL_READ'					=> 'Yleinen',
	'IMG_GLOBAL_READ_MINE'				=> 'Yleistiedote, johon olen vastannut',
	'IMG_GLOBAL_READ_LOCKED'			=> 'Lukittu yleistiedote',
	'IMG_GLOBAL_READ_LOCKED_MINE'		=> 'Lukittu yleistiedote, johon olen vastannut ja uusia viestejä',
	'IMG_GLOBAL_UNREAD'					=> 'Yleistiedote, jossa on uusia viestejä',
	'IMG_GLOBAL_UNREAD_MINE'			=> 'Yleistiedote, johon olen vastannut ja siinä on uusia viestejä',
	'IMG_GLOBAL_UNREAD_LOCKED'			=> 'Lukittu yleistiedote, jossa on uusia viestejä',
	'IMG_GLOBAL_UNREAD_LOCKED_MINE'		=> 'Yleistiedote, joka on lukittu ja johon olen vastannut',

	'IMG_PM_READ'		=> 'Luettuja yksityisviestejä',
	'IMG_PM_UNREAD'		=> 'Lukemattomia yksityisviestejä',

	'IMG_ICON_BACK_TOP'		=> 'Ylös',

	'IMG_ICON_CONTACT_AIM'		=> 'AIM',
	'IMG_ICON_CONTACT_EMAIL'	=> 'Lähetä sähköpostia',
	'IMG_ICON_CONTACT_ICQ'		=> 'ICQ',
	'IMG_ICON_CONTACT_JABBER'	=> 'Jabber',
	'IMG_ICON_CONTACT_MSNM'		=> 'MSNM',
	'IMG_ICON_CONTACT_PM'		=> 'Lähetä viesti',
	'IMG_ICON_CONTACT_YAHOO'	=> 'YIM',
	'IMG_ICON_CONTACT_WWW'		=> 'Nettisivu',

	'IMG_ICON_POST_DELETE'			=> 'Poista viesti',
	'IMG_ICON_POST_EDIT'			=> 'Muokkaa viestiä',
	'IMG_ICON_POST_INFO'			=> 'Näytä viestin tiedot',
	'IMG_ICON_POST_QUOTE'			=> 'Lainaa viestiä',
	'IMG_ICON_POST_REPORT'			=> 'Ilmoita viesti',
	'IMG_ICON_POST_TARGET'			=> 'Miniviesti',
	'IMG_ICON_POST_TARGET_UNREAD'	=> 'Uusi miniviesti',


	'IMG_ICON_TOPIC_ATTACH'			=> 'Liitetiedosto',
	'IMG_ICON_TOPIC_LATEST'			=> 'Viimeisin viesti',
	'IMG_ICON_TOPIC_NEWEST'			=> 'Viimeisin lukematon viesti',
	'IMG_ICON_TOPIC_REPORTED'		=> 'Viesti on ilmoitettu',
	'IMG_ICON_TOPIC_UNAPPROVED'		=> 'Hylätty viesti',

	'IMG_ICON_USER_ONLINE'		=> 'Käyttäjä on paikalla',
	'IMG_ICON_USER_OFFLINE'		=> 'Käyttäjä ei ole paikalla',
	'IMG_ICON_USER_PROFILE'		=> 'Näytä profiili',
	'IMG_ICON_USER_SEARCH'		=> 'Etsi viestit',
	'IMG_ICON_USER_WARN'		=> 'Anna varoitus',

	'IMG_BUTTON_PM_FORWARD'		=> 'Lähetä yksityisviesti eteenpäin',
	'IMG_BUTTON_PM_NEW'			=> 'Uusi yksityisviesti',
	'IMG_BUTTON_PM_REPLY'		=> 'Vastaa yksityisviestiin',
	'IMG_BUTTON_TOPIC_LOCKED'	=> 'Aihe on lukittu',
	'IMG_BUTTON_TOPIC_NEW'		=> 'Uusi aihe',
	'IMG_BUTTON_TOPIC_REPLY'	=> 'Vastaa viestiketjuun',

	'IMG_USER_ICON1'		=> 'Käyttäjän määrittelemä kuva 1',
	'IMG_USER_ICON2'		=> 'Käyttäjän määrittelemä kuva 2',
	'IMG_USER_ICON3'		=> 'Käyttäjän määrittelemä kuva 3',
	'IMG_USER_ICON4'		=> 'Käyttäjän määrittelemä kuva 4',
	'IMG_USER_ICON5'		=> 'Käyttäjän määrittelemä kuva 5',
	'IMG_USER_ICON6'		=> 'Käyttäjän määrittelemä kuva 6',
	'IMG_USER_ICON7'		=> 'Käyttäjän määrittelemä kuva 7',
	'IMG_USER_ICON8'		=> 'Käyttäjän määrittelemä kuva 8',
	'IMG_USER_ICON9'		=> 'Käyttäjän määrittelemä kuva 9',
	'IMG_USER_ICON10'		=> 'Käyttäjän määrittelemä kuva 10',

	'INCLUDE_DIMENSIONS'		=> 'Ota kuvan koko',
	'INCLUDE_IMAGESET'			=> 'Ota kuvapaketti',
	'INCLUDE_TEMPLATE'			=> 'Ota malline',
	'INCLUDE_THEME'				=> 'Ota teema',
    'INHERITING_FROM'           => 'Lainaa komponentteja tyylistä',
	'INSTALL_IMAGESET'			=> 'Asenna kuvapaketti',
	'INSTALL_IMAGESET_EXPLAIN'	=> 'Täällä voit asentaa valitsemiasi kuvapaketteja. Voit halutessasi muokata joitain yksityiskohtia tai käyttää vain oletusasetuksia.',
	'INSTALL_STYLE'				=> 'Asenna tyyli',
	'INSTALL_STYLE_EXPLAIN'		=> 'Täällä voit asentaa uuden tyylin ja mahdollisesti siihen liittyviä elementtejä. Mikäli jotkin elementit ovat jo asennettu. Nitä ei ylikirjoiteta. Jotkut tyylit vaativat tiettyjen elementtien olevan asennettu. Mikäli näitä tyylin vaatimia elementtejä ei ole asennettu. Siitä ilmoitetaan.',
	'INSTALL_TEMPLATE'			=> 'Asenna malline',
	'INSTALL_TEMPLATE_EXPLAIN'	=> 'Täällä voit asentaa uuden mallinepaketin. Palvelimen asetuksista riippuen sinulla voi olla erilaisia vaihtoehtoja käytettävissä.',
	'INSTALL_THEME'				=> 'Asenna teema',
	'INSTALL_THEME_EXPLAIN'		=> 'Täällä voit asentaa valitsemasi teeman. Voit halutessasi muokata joitain yksityiskohtia tai käyttää vain oletusasetuksia.',
	'INSTALLED_IMAGESET'		=> 'Asennetut kuvapaketit',
	'INSTALLED_STYLE'			=> 'Asennetut tyylit',
	'INSTALLED_TEMPLATE'		=> 'Asennetut mallineet',
	'INSTALLED_THEME'			=> 'Asennetut teemat',
    'KEEP_IMAGESET'             => 'Säilytä “%s” kuvapaketti',
    'KEEP_TEMPLATE'             => 'Säilytä “%s” malline',
    'KEEP_THEME'                => 'Säilytä “%s” teema',

	'LINE_SPACING'				=> 'Rivin välistys',
	'LOCALISED_IMAGES'			=> 'Lokalisoitu',
    'LOCATION_DISABLED_EXPLAIN'   => 'Tämä asetus lainataan toisesta tyylistä, joten sitä ei voi muokata.',

	'NO_CLASS'					=> 'En löytänyt luokkaa tyylimäärittelystä',
	'NO_IMAGESET'				=> 'En löytänyt kuvapakettia tiedostojärjestelmästä',
	'NO_IMAGE'					=> 'Ei kuvaa',
	'NO_IMAGE_ERROR'			=> 'En löytänyt kuvaa tiedostojärjestelmästä.',
	'NO_STYLE'					=> 'En löytänyt tyyliä tiedostojärjestelmästä',
	'NO_TEMPLATE'				=> 'En löytänyt mallinetta tiedostojärjestelmästä',
	'NO_THEME'					=> 'En löytänyt teemaa tiedostojärjestelmästä',
	'NO_UNINSTALLED_IMAGESET'	=> 'En löytänyt asentamattomia kuvapaketteja',
	'NO_UNINSTALLED_STYLE'		=> 'En löytänyt asentamattomia tyylejä',
	'NO_UNINSTALLED_TEMPLATE'	=> 'En löytänyt asentamattomia mallineita',
	'NO_UNINSTALLED_THEME'		=> 'En löytänyt asentamattomia teemoja',
	'NO_UNIT'					=> 'Ei mitään',

	'ONLY_IMAGESET'			=> 'Tämä on ainoa jäljellä oleva kuvapaketti. Et voi poistaa sitä',
	'ONLY_STYLE'			=> 'Tämä on ainoa jäljellä oleva tyyli. Et voi poistaa sitä',
	'ONLY_TEMPLATE'			=> 'Tämä on ainoa jäljellä oleva mallinepaketti. Et voi poistaa sitä',
	'ONLY_THEME'			=> 'Tämä on ainoa jäljellä oleva teema. Et voi poistaa sitä',
	'OPTIONAL_BASIS'		=> 'vaihtoehtoisuus',

	'REFRESH'					=> 'Virkistä',
	'REPEAT_NO'					=> 'Ei mitään',
	'REPEAT_X'					=> 'vain vaakatasossa',
	'REPEAT_Y'					=> 'Vain pystysuunnassa',
	'REPEAT_ALL'				=> 'Kumpaankin suuntaan',
	'REPLACE_IMAGESET'			=> 'Korvaa kuvapaketti tällä',
	'REPLACE_IMAGESET_EXPLAIN'	=> 'Tämä kuvapaketti korvaa poistamasi kuvapaketin kaikissa tyyleissä.',
	'REPLACE_STYLE'				=> 'Korvaa tyyli tällä',
	'REPLACE_STYLE_EXPLAIN'		=> 'Tämä tyyli korvaa tyylin kaikilta käyttäjiltä, jotka käyttivät poistamaasi tyyliä.',
	'REPLACE_TEMPLATE'			=> 'Korvaa malline tällä',
	'REPLACE_TEMPLATE_EXPLAIN'	=> 'Tämä mallinepaketti korvaa poistamasi mallineen kaikissa käytössä olevissa tyyleissä.',
	'REPLACE_THEME'				=> 'Korvaa teema tällä',
	'REPLACE_THEME_EXPLAIN'		=> 'Tämä teema korvaa poistamasi teeman kaikissa tyyleissä, jotka käyttivät sitä.',
    'REPLACE_WITH_OPTION'       => 'Korvaa käyttämällä “%s”',
	'REQUIRES_IMAGESET'			=> 'Tämä tyyli vaatii %s kuvapaketin olevan asenenttu.',
	'REQUIRES_TEMPLATE'			=> 'Tämä tyyli vaatii %s mallinepaketin olevan asennettu.',
	'REQUIRES_THEME'			=> 'Tämä tyyli vaatii %s teeman olevan asennettu.',

	'SELECT_IMAGE'				=> 'Valitse kuva',
	'SELECT_TEMPLATE'			=> 'Valitse mallinetiedosto',
	'SELECT_THEME'				=> 'valitse teematiedosto',
	'SELECTED_IMAGE'			=> 'Valittu kuva',
	'SELECTED_IMAGESET'			=> 'Valittu kuvapaketti',
	'SELECTED_TEMPLATE'			=> 'Valittu malline',
	'SELECTED_TEMPLATE_FILE'	=> 'Valittu mallinetiedosto',
	'SELECTED_THEME'			=> 'Valittu teema',
	'SELECTED_THEME_FILE'		=> 'Valittu teema tiedosto',
	'STORE_DATABASE'			=> 'Tietokanta',
	'STORE_FILESYSTEM'			=> 'Tiedostojärjestelmä',
	'STYLE_ACTIVATE'			=> 'Aktivoi',
	'STYLE_ACTIVE'				=> 'Aktiivinen',
	'STYLE_ADDED'				=> 'Tyyli on lisätty',
	'STYLE_DEACTIVATE'			=> 'Deaktivoi',
	'STYLE_DEFAULT'				=> 'Aseta oletustyyliksi',
	'STYLE_DELETED'				=> 'Tyyli on poistettu',
	'STYLE_DETAILS_UPDATED'		=> 'Tyylin muokkaus onnistui',
	'STYLE_ERR_ARCHIVE'			=> 'Ole hyvä ja valitse arkistointi metodi',
	'STYLE_ERR_COPY_LONG'		=> 'Tekijänoikeustiedot eivät voi olla 60 merkkiä pidemmät',
	'STYLE_ERR_MORE_ELEMENTS'	=> 'Sinun pitää valita ainakin yksi tyylin elementti.',
	'STYLE_ERR_NAME_CHARS'		=> 'Tyylin nimi voi koostua vain alphanumeerisista merkeistä, -, +, _ ja välilyönnistä',
	'STYLE_ERR_NAME_EXIST'		=> 'Tämän niminen tyyli on jo olemassa',
	'STYLE_ERR_NAME_LONG'		=> 'Tyylin nimi ei voi olla yli 30 merkkiä pitkä',
	'STYLE_ERR_NO_IDS'			=> 'Sinun täytyy valita malline, teema ja kuvapaketti tälle tyylille',
	'STYLE_ERR_NOT_STYLE'		=> 'Siirtämässäsi tiedostossa ei ollut kelvollista arkistoitua tyyliä.',
	'STYLE_ERR_STYLE_NAME'		=> 'Sinun täytyy antaa nimi tälle tyylille',
	'STYLE_EXPORT'				=> 'Vie tyyli',
	'STYLE_EXPORT_EXPLAIN'		=> 'Täällä voit viedä tyylin arkistoon. Tämän tyylin ei tarvitse sisältää kaikkia elementtejä, mutta sillä on oltava ainakin yksi. Jos esimerkiksi olet luonut uuden teeman ja kuvapaketin yleisesti käytössä olevaan tyyliin. Voit yksinkertaisesti viedä vain teeman ja tyylin ja jättää mallineen pois. Voit valita lataatko tiedoton omalle koneellesi vai tallennatko sen store-hakemistoon palvelimella myöhempää latausta varten.',
	'STYLE_EXPORTED'			=> 'Tyyli on viety onnistuneesti ja tallennettu %s',
	'STYLE_IMAGESET'			=> 'Kuvapaketti',
	'STYLE_NAME'				=> 'Tyylin nimi',
	'STYLE_TEMPLATE'			=> 'malline',
	'STYLE_THEME'				=> 'Teema',
	'STYLE_USED_BY'				=> 'Käyttäjien lkm',

	'TEMPLATE_ADDED'			=> 'mallinepaketti on lisäty ja tallennettu tiedostojärjestelmään',
	'TEMPLATE_ADDED_DB'			=> 'mallinepaketti on lisätty ja tallennettu tietokantaan',
	'TEMPLATE_CACHE'			=> 'mallineen välimuisti',
	'TEMPLATE_CACHE_EXPLAIN'	=> 'Oletuksena phpBB pitää rakennetun mallineen välimuistissaan. Tämä pienentää palvelimen kuormitusta jokaisella kerralla, kun sivu ladataan ja nopeuttaa siten sivun rakennusaikoja. Täällä voit katsella ja poistaa yksittäisiä tiedostoja tai halutessasi voit tyhjentää välimuistin kokonaan.',
	'TEMPLATE_CACHE_CLEARED'	=> 'mallineen välimuisti on tyhjennetty',
	'TEMPLATE_CACHE_EMPTY'		=> 'Välimuistissa ei ole mallineita.',
	'TEMPLATE_DELETED'			=> 'mallinepaketti on poistettu',
    'TEMPLATE_DELETE_DEPENDENT'   => 'Tätä tyyliä ei voi poistaa, sillä yksi tai useampi tyyli lainaa siitä komponentteja:',
	'TEMPLATE_DELETED_FS'		=> 'mallinepaketti on poistettu tietokannasta, mutta joitain tiedostoja saattaa olla vielä tiedostojärjestelmässä',
	'TEMPLATE_DETAILS_UPDATED'	=> 'mallineen yksityiskohdat on päivitetty',
	'TEMPLATE_EDITOR'			=> 'Raaka HTML malline editori',
	'TEMPLATE_EDITOR_HEIGHT'	=> 'malline editorin korkeus',
	'TEMPLATE_ERR_ARCHIVE'		=> 'Ole hyvä ja valitse arkistointi metodi',
	'TEMPLATE_ERR_CACHE_READ'	=> 'Välimuistin käyttämää hakemistoa ei voitu avata.',
	'TEMPLATE_ERR_COPY_LONG'	=> 'Tekijänoikeustiedot eivät voi olla 60 merkkiä pidemmät',
	'TEMPLATE_ERR_NAME_CHARS'	=> 'mallineen nimi voi koostua vain alphanumeerisista merkeistä, -, +, _ ja välilyönneistä',
	'TEMPLATE_ERR_NAME_EXIST'	=> 'Tämän niminen mallinepaketti on jo olemassa',
	'TEMPLATE_ERR_NAME_LONG'	=> 'mallineen nimi ei voi olla 30 merkkiää pidempi',
	'TEMPLATE_ERR_NOT_TEMPLATE'	=> 'Määrittämässäsi arkistossa ei ole kelvollista mallinepakettia.',
    'TEMPLATE_ERR_REQUIRED_OR_INCOMPLETE' => 'Tämä tyyli tarvitsee %s -tyylin asennuksen, eikä voi lainata itseltään. ',
	'TEMPLATE_ERR_STYLE_NAME'	=> 'Anna nimi tälle mallineelle',
	'TEMPLATE_EXPORT'			=> 'Vie mallineita',
	'TEMPLATE_EXPORT_EXPLAIN'	=> 'Täällä voit viedä mallinepaketin arkistoon. Tämä arkisto pitää sisällään kaiken tarvittavan tiedon, jotta sen voi asentaa toiselle keskustelufoorumille. Voit vlita lataatko tiedoston omalle koneellesi tai tallentaa sen store-hakemistoon myöhmpää käyttöä varten.',
	'TEMPLATE_EXPORTED'			=> 'mallineet on viety onnistuneesti ja tallennettu %s',
	'TEMPLATE_FILE'				=> 'malline tiedosto',
	'TEMPLATE_FILE_UPDATED'		=> 'malline tiedosto on päivitetty.',
    'TEMPLATE_INHERITS'         => 'Tämä tyyli lainaa komponentteja tyylistä %s ja sen vuoksi sitä ei voi tallentaa eri menetelmällä, kuin se mistä lainaukset suoritetaan.',
	'TEMPLATE_LOCATION'			=> 'Tallenna mallineet',
	'TEMPLATE_LOCATION_EXPLAIN'	=> 'Kuvat tallennetaan aina tiedostojärjestelmään.',
	'TEMPLATE_NAME'				=> 'mallineen nimi',
	'TEMPLATE_FILE_NOT_WRITABLE'=> 'Mallinetiedoston %s kirjoitus epäonnistui. Ole hyvä ja tarkista hakemiston ja tiedoston oikeudet.',
	'TEMPLATE_REFRESHED'		=> 'malline on virkistetty',

	'THEME_ADDED'				=> 'Uusi teema lisätty tiedostojärjestelmään',
	'THEME_ADDED_DB'			=> 'Uusi teema lisätty tietokantaan',
	'THEME_CLASS_ADDED'			=> 'Mukautettu luokka lisätty',
	'THEME_DELETED'				=> 'Teema on poistettu',
	'THEME_DELETED_FS'			=> 'Teema on poistettu tietokannasta, mutta joitain tiedostoja on vielä tiedostojärjestelmässä',
	'THEME_DETAILS_UPDATED'		=> 'Teeman yksityiskohdat ovat päivitetty',
	'THEME_EDITOR'				=> 'Raaka CSS teema editori',
	'THEME_EDITOR_HEIGHT'		=> 'Teema editorin korkeus',
	'THEME_ERR_ARCHIVE'			=> 'Ole hyvä ja valitse arkistointi metodi',
	'THEME_ERR_CLASS_CHARS'		=> 'Vain alphanumeeriset merkit ja ., :, - ja # on sallittu luokkien nimissä.',
	'THEME_ERR_COPY_LONG'		=> 'Tekijänoikeustiedot eivät voi olla 60 merkkiä pidemmät',
	'THEME_ERR_NAME_CHARS'		=> 'Teeman nimessä voi olla vain alphanumeerisia merkkejä, -, +, _ ja välilyöntejä',
	'THEME_ERR_NAME_EXIST'		=> 'Tämän niminen teema on jo olemassa',
	'THEME_ERR_NAME_LONG'		=> 'Teeman nimi ei voi olla 30 merkkiä pidempi',
	'THEME_ERR_NOT_THEME'		=> 'Määrittämässäsi arkistossa ei ole kelvollista teemaa.',
	'THEME_ERR_REFRESH_FS'		=> 'Tämä teema on tiedostojärjestelmässä, joten sitä ei tarvitse virkistää.',
	'THEME_ERR_STYLE_NAME'		=> 'Sinun täytyy antaa nimi tälle teemalle',
	'THEME_FILE'				=> 'Teema tiedosto',
	'THEME_EXPORT'				=> 'Vie teema',
	'THEME_EXPORT_EXPLAIN'		=> 'Täällä voit viedä teeman arkistoon. Tämä arkisto pitää sisällään kaiken tarvittavan tiedon, jotta sen voi asentaa toiselle keskustelufoorumille. Voit vlita lataatko tiedoston omalle koneellesi tai tallentaa sen store-hakemistoon myöhmpää käyttöä varten.',
	'THEME_EXPORTED'			=> 'Teema on viety onnistuneesti ja tallennettu %s',
	'THEME_LOCATION'			=> 'Tallenna tyylitiedosto',
	'THEME_LOCATION_EXPLAIN'	=> 'Kuvat tallennetaan aina tiedostojärjestelmään.',
	'THEME_NAME'				=> 'Teeman nimi',
	'THEME_REFRESHED'			=> 'Teema on virkisettty onnistuneesti',
	'THEME_UPDATED'				=> 'Luokka on päivitetty onnistuneesti',

	'UNDERLINE'				=> 'Alleviivaus',
	'UNINSTALLED_IMAGESET'	=> 'Käyttämättömät kuvapaketit',
	'UNINSTALLED_STYLE'		=> 'Käyttämättömät tyylit',
	'UNINSTALLED_TEMPLATE'	=> 'Käyttämättömät mallineet',
	'UNINSTALLED_THEME'		=> 'Poistetut teemat',
	'UNSET'					=> 'Määrittämätön',

));

?>