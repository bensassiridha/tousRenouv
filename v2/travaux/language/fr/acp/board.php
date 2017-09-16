<?php
/**
*
* acp_board [French]
*
* @package language
* @version 2.0.0
* @author Maël Soucaze (Maël Soucaze) <maelsoucaze@phpbb.com> http://mael.soucaze.com/
* @copyright (c) 2005 phpBB Group, 2005 phpBB.fr
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

// Board Settings
$lang = array_merge($lang, array(
	'ACP_BOARD_SETTINGS_EXPLAIN'	=> 'Vous pouvez effectuer ici les opérations basiques de votre forum, comme lui attribuer un nom et une description, régler son fuseau horaire ou encore définir sa langue par défaut.',
	'CUSTOM_DATEFORMAT'				=> 'Personnaliser…',
	'DEFAULT_DATE_FORMAT'			=> 'Format de la date ',
	'DEFAULT_DATE_FORMAT_EXPLAIN'	=> 'Le format de la date est similaire à celui de la fonction PHP <code>date</code>.',
	'DEFAULT_LANGUAGE'				=> 'Langue par défaut ',
	'DEFAULT_STYLE'					=> 'Style par défaut ',
	'DISABLE_BOARD'					=> 'Désactiver le forum ',
	'DISABLE_BOARD_EXPLAIN'			=> 'Cela rendra le forum indisponible aux utilisateurs. Si vous le souhaitez, vous pouvez également fournir une brève explication (de 255 caractères maximum) qui sera affichée aux utilisateurs.',
	'OVERRIDE_STYLE'				=> 'Écraser le style des utilisateurs ',
	'OVERRIDE_STYLE_EXPLAIN'		=> 'Remplace le style que utilisateurs ont sélectionné par le style par défaut.',
	'SITE_DESC'						=> 'Description du forum ',
	'SITE_NAME'						=> 'Nom du forum ',
	'SYSTEM_DST'					=> 'Activer l’heure d’été ',
	'SYSTEM_TIMEZONE'				=> 'Fuseau horaire des invités ',
	'SYSTEM_TIMEZONE_EXPLAIN'			=> 'Fuseau horaire utilisé afin d’afficher les heures aux utilisateurs qui ne sont pas connectés (comme les invités et les robots). Les utilisateurs connectés règlent eux-mêmes leur fuseau horaire durant leur inscription ou modifient ce réglage par l’intermédiaire du panneau de contrôle de l’utilisateur.',
	'WARNINGS_EXPIRE'				=> 'Durée des avertissements ',
	'WARNINGS_EXPIRE_EXPLAIN'		=> 'Nombre de jours qui s’écoulera avant qu’un avertissement n’expire automatiquement.',
));

// Board Features
$lang = array_merge($lang, array(
	'ACP_BOARD_FEATURES_EXPLAIN'	=> 'Vous pouvez activer ou désactiver ici plusieurs fonctionnalités du forum.',

	'ALLOW_ATTACHMENTS'			=> 'Autoriser les pièces jointes ',
	'ALLOW_BIRTHDAYS'			=> 'Autoriser les anniversaires ',
	'ALLOW_BIRTHDAYS_EXPLAIN'	=> 'Autorise la saisie des dates d’anniversaires et l’affichage de l’âge dans les profils. Veuillez noter que la liste des anniversaires qui est affichée sur l’index du forum ne dépend pas de ce réglage.',
	'ALLOW_BOOKMARKS'			=> 'Autoriser le signetage des sujets ',
	'ALLOW_BOOKMARKS_EXPLAIN'	=> 'Autorise les utilisateurs à enregistrer des signets personnels.',
	'ALLOW_BBCODE'				=> 'Autoriser le BBCode ',
	'ALLOW_FORUM_NOTIFY'		=> 'Autoriser l’abonnement aux forums ',
	'ALLOW_NAME_CHANGE'			=> 'Autoriser la modification des noms d’utilisateurs ',
	'ALLOW_NO_CENSORS'			=> 'Autoriser la désactivation de la censure de mots ',
	'ALLOW_NO_CENSORS_EXPLAIN'	=> 'Les utilisateurs pourront désactiver la censure de mots automatique dans les messages et les messages privés.',
	'ALLOW_PM_ATTACHMENTS'		=> 'Autoriser les pièces jointes dans les messages privés ',
	'ALLOW_PM_REPORT'			=> 'Autoriser les utilisateurs à rapporter des messages privés ',
	'ALLOW_PM_REPORT_EXPLAIN'	=> 'Si cette option est activée, les utilisateurs pourront rapporter aux modérateurs du forum les messages privés qu’ils ont reçus ou qu’ils ont envoyés. Ces messages privés seront alors visibles depuis le panneau de contrôle du modérateur.',
	'ALLOW_QUICK_REPLY'			=> 'Autoriser la réponse rapide ',
	'ALLOW_QUICK_REPLY_EXPLAIN'	=> 'Autorise l’utilisation de la réponse rapide sur le forum. Lorsque cette option est activée, les réglages spécifiques aux forums seront utilisés afin de déterminer si la réponse rapide doit être désactivée ou non sur chaque forum individuel.',
	'ALLOW_QUICK_REPLY_BUTTON'	=> 'Envoyer et activer la réponse rapide dans tous les forums',
	'ALLOW_SIG'					=> 'Autoriser les signatures ',
	'ALLOW_SIG_BBCODE'			=> 'Autoriser le BBCode dans la signature des utilisateurs ',
	'ALLOW_SIG_FLASH'			=> 'Autoriser l’utilisation de la balise BBCode <code>[FLASH]</code> dans la signature des utilisateurs ',
	'ALLOW_SIG_IMG'				=> 'Autoriser l’utilisation de la balise BBCode <code>[IMG]</code> dans la signature des utilisateurs ',
	'ALLOW_SIG_LINKS'			=> 'Autoriser l’insertion de liens dans la signature des utilisateurs ',
	'ALLOW_SIG_LINKS_EXPLAIN'	=> 'Si cette option est désactivée, la balise BBCode <code>[URL]</code> et la transformation automatique de texte en lien sera désactivée.',
	'ALLOW_SIG_SMILIES'			=> 'Autoriser l’insertion d’émoticônes dans la signature des utilisateurs ',
	'ALLOW_SMILIES'				=> 'Autoriser les émoticônes ',
	'ALLOW_TOPIC_NOTIFY'		=> 'Autoriser l’abonnement aux sujets ',
	'BOARD_PM'					=> 'Messagerie privée ',
	'BOARD_PM_EXPLAIN'			=> 'Activer la messagerie privée à tous les utilisateurs.',
));

// Avatar Settings
$lang = array_merge($lang, array(
	'ACP_AVATAR_SETTINGS_EXPLAIN'	=> 'Les avatars sont généralement de petites images uniques qu’un utilisateur peut associer à sa personnalité. Selon le style utilisé, ils sont habituellement affichés sous le nom d’utilisateur lors de la consultation de sujets. Vous pouvez déterminer ici quels sont les utilisateurs qui peuvent utiliser des avatars. Veuillez noter que pour transférer des avatars, vous devez avoir préalablement créé le répertoire que vous indiquerez ci-dessous et vous assurer qu’il soit inscriptible par le serveur internet. Veuillez également noter que les limitations de taille ne sont imposées qu’aux avatars transférés, elles ne s’appliquent pas aux images à distance.',

	'ALLOW_AVATARS'					=> 'Activer les avatars ',
	'ALLOW_AVATARS_EXPLAIN'			=> 'Autorise l’utilisation générale des avatars ;<br />Si vous désactivez l’utilisation générale ou particulière des avatars, les avatars désactivés ne s’afficheront plus sur le forum mais les utilisateurs seront toujours capables de télécharger leurs propres avatars depuis le panneau de contrôle de l’utilisateur.',
	'ALLOW_LOCAL'					=> 'Activer la galerie d’avatars ',
	'ALLOW_REMOTE'					=> 'Activer les avatars à distance ',
	'ALLOW_REMOTE_EXPLAIN'			=> 'Les avatars situés sur un site internet externe.',
	'ALLOW_REMOTE_UPLOAD'			=> 'Activer le transfert d’avatars à distance ',
	'ALLOW_REMOTE_UPLOAD_EXPLAIN'	=> 'Autorise le tranfert d’avatars à partir de sites internet externes.',
	'ALLOW_UPLOAD'					=> 'Activer le transfert d’avatars ',
	'AVATAR_GALLERY_PATH'			=> 'Chemin vers la galerie d’avatars ',
	'AVATAR_GALLERY_PATH_EXPLAIN'	=> 'Chemin depuis la racine de votre répertoire de phpBB vers les images, tel que <samp>images/avatars/gallery</samp>.',
	'AVATAR_STORAGE_PATH'			=> 'Chemin vers le répertoire de stockage des avatars ',
	'AVATAR_STORAGE_PATH_EXPLAIN'	=> 'Chemin depuis la racine de votre répertoire de phpBB, tel que <samp>images/avatars/upload</samp>.',
	'MAX_AVATAR_SIZE'				=> 'Dimensions maximales des avatars ',
	'MAX_AVATAR_SIZE_EXPLAIN'		=> 'Largeur x hauteur en pixels.',
	'MAX_FILESIZE'					=> 'Taille maximale des avatars ',
	'MAX_FILESIZE_EXPLAIN'			=> 'Cette option ne concerne que les avatars transférés.',
	'MIN_AVATAR_SIZE'				=> 'Dimensions minimales des avatars ',
	'MIN_AVATAR_SIZE_EXPLAIN'		=> 'Largeur x hauteur en pixels.',
));

// Message Settings
$lang = array_merge($lang, array(
	'ACP_MESSAGE_SETTINGS_EXPLAIN'		=> 'Vous pouvez effectuer ici tous les réglages par défaut concernant la messagerie privée.',

	'ALLOW_BBCODE_PM'			=> 'Autoriser le BBCode dans les messages privés ',
	'ALLOW_FLASH_PM'			=> 'Autoriser l’utilisation de la balise BBCode <code>[FLASH]</code> ',
	'ALLOW_FLASH_PM_EXPLAIN'	=> 'Notez que l’utilisation de Flash dans les messages privés dépend également des permissions.',
	'ALLOW_FORWARD_PM'			=> 'Autoriser le transfert de messages privés ',
	'ALLOW_IMG_PM'				=> 'Autoriser l’utilisation de la balise BBCode <code>[IMG]</code> ',
	'ALLOW_MASS_PM'				=> 'Autoriser l’envoi de messages privés à plusieurs utilisateurs et groupes ',
	'ALLOW_MASS_PM_EXPLAIN'		=> 'L’envoi de messages destinés aux groupes peut être ajusté de manière individuelle depuis la page des réglages relatifs aux groupes.',
	'ALLOW_PRINT_PM'			=> 'Autoriser l’accès à l’aperçu avant impression dans les messages privés ',
	'ALLOW_QUOTE_PM'			=> 'Autoriser les citations dans les messages privés ',
	'ALLOW_SIG_PM'				=> 'Autoriser les signatures dans les messages privés ',
	'ALLOW_SMILIES_PM'			=> 'Autoriser les émoticônes dans les messages privés ',
	'BOXES_LIMIT'				=> 'Nombre maximum de messages privés par boîte ',
	'BOXES_LIMIT_EXPLAIN'		=> 'Si leur boîte est pleine, les utilisateurs ne pourront pas recevoir davantage de messages privés que la valeur qui est insérée ici. Réglez cette valeur sur 0 afin de ne pas limiter le nombre de messages privés par boîte.',
	'BOXES_MAX'					=> 'Nombre maximum de dossiers de messages privés ',
	'BOXES_MAX_EXPLAIN'			=> 'Par défaut, les utilisateurs peuvent créer un certain nombre de dossiers qui leur permettent de stocker des messages privés.',
	'ENABLE_PM_ICONS'			=> 'Activer l’utilisation des icônes de sujets dans les messages privés ',
	'FULL_FOLDER_ACTION'		=> 'Action par défaut lorsque un dossier est plein ',
	'FULL_FOLDER_ACTION_EXPLAIN'=> 'L’action par défaut à réaliser lorsque le dossier d’un utilisateur est plein dans le cas où l’action spécifiée par l’utilisateur n’est pas applicable. La seule exception s’applique au dossier des « Messages envoyés », où l’action par défaut est d’automatiquement supprimer les messages les plus anciens.',
	'HOLD_NEW_MESSAGES'			=> 'Mettre en attente les nouveaux messages',
	'PM_EDIT_TIME'				=> 'Limite de la durée d’édition ',
	'PM_EDIT_TIME_EXPLAIN'		=> 'Limite la durée d’édition possible concernant les messages privés qui n’ont pas encore été délivrés. Réglez cette valeur sur 0 afin de désactiver ce comportement.',
	'PM_MAX_RECIPIENTS'			=> 'Nombre maximum de destinataires autorisés ',
	'PM_MAX_RECIPIENTS_EXPLAIN'	=> 'Le nombre maximum de destinataires autorisés dans un message privé. Réglez cette valeur sur 0 si vous ne souhaitez pas limiter ce nombre. Ce réglage peut être ajusté pour chaque groupe depuis la page des réglages relatifs aux groupes.',
));

// Post Settings
$lang = array_merge($lang, array(
	'ACP_POST_SETTINGS_EXPLAIN'			=> 'Vous pouvez effectuer ici tous les réglages concernant la publication.',
	'ALLOW_POST_LINKS'					=> 'Autoriser les liens dans les messages et les messages privés ',
	'ALLOW_POST_LINKS_EXPLAIN'			=> 'Si vous n’autorisez pas cette fonctionnalité, la balise BBCode <code>[URL]</code> et la transformation automatique de texte en lien sera désactivée.',
	'ALLOW_POST_FLASH'					=> 'Autoriser l’utilisation de la balise BBCode <code>[FLASH]</code> dans les messages ',
	'ALLOW_POST_FLASH_EXPLAIN'			=> 'Si vous n’autorisez pas cette fonctionnalité, la balise BBCode <code>[FLASH]</code> sera désactivée dans tous les messages. Dans le cas contraire, vous pourrez déterminer depuis le système de permissions quels seront les utilisateurs qui pourront, ou non, utiliser la balise BBCode <code>[FLASH]</code>.',

	'BUMP_INTERVAL'					=> 'Intervalle de remontée des sujets ',
	'BUMP_INTERVAL_EXPLAIN'			=> 'Nombre de minutes, d’heures ou de jours entre le dernier message d’un sujet et la possibilité de remonter ce même sujet. Réglez cette valeur sur 0 afin de désactiver la possibilité de remonter des sujets.',
	'CHAR_LIMIT'					=> 'Nombre maximum de caractère(s) par message et message privé ',
	'CHAR_LIMIT_EXPLAIN'			=> 'Le nombre maximum de caractère(s) que les utilisateurs peuvent saisir dans un message et dans un message privé. Réglez cette valeur sur 0 afin de ne pas limiter le nombre de caractère.',
	'DELETE_TIME'					=> 'Limite de la durée de suppression ',
	'DELETE_TIME_EXPLAIN'			=> 'Limite la durée de suppression possible concernant les nouveaux messages. Réglez cette valeur sur 0 afin de désactiver ce comportement.',
	'DISPLAY_LAST_EDITED'			=> 'Afficher l’information concernant la date de la dernière édition ',
	'DISPLAY_LAST_EDITED_EXPLAIN'	=> 'Affiche sur les messages l’information concernant la date de la dernière édition.',
	'EDIT_TIME'						=> 'Limite de la durée d’édition ',
	'EDIT_TIME_EXPLAIN'				=> 'Limite la durée d’édition possible concernant les nouveaux messages. Réglez cette valeur sur 0 afin de désactiver ce comportement.',
	'FLOOD_INTERVAL'				=> 'Intervalle d’affluence ',
	'FLOOD_INTERVAL_EXPLAIN'		=> 'Nombre de secondes qu’un utilisateur doit attendre avant d’avoir la possibilité de publier de nouveaux messages. Si vous souhaitez autoriser les utilisateurs à ignorer cet intervalle, vous devrez modifier leurs permissions.',
	'HOT_THRESHOLD'					=> 'Seuil de popularité des sujets ',
	'HOT_THRESHOLD_EXPLAIN'			=> 'Le nombre de messages par sujet à atteindre afin qu’un sujet soit considéré comme populaire. Réglez cette valeur sur 0 afin de désactiver cette fonctionnalité.',
	'MAX_POLL_OPTIONS'				=> 'Nombre maximum d’option(s) par sondage ',
	'MAX_POST_FONT_SIZE'			=> 'Taille maximale de la police de caractères dans les messages et messages privés ',
	'MAX_POST_FONT_SIZE_EXPLAIN'	=> 'La taille maximale de la police de caractères autorisée dans un message et dans un message privé. Réglez cette valeur sur 0 afin de ne pas limiter la taille de la police de caractères.',
	'MAX_POST_IMG_HEIGHT'			=> 'Hauteur maximale des images dans les messages et messages privés ',
	'MAX_POST_IMG_HEIGHT_EXPLAIN'	=> 'La hauteur maximale des images ou des fichiers Flash dans les messages et dans les messages privés. Réglez cette valeur sur 0 afin de ne pas limiter la hauteur.',
	'MAX_POST_IMG_WIDTH'			=> 'Largeur maximale des images dans les messages et messages privés ',
	'MAX_POST_IMG_WIDTH_EXPLAIN'	=> 'La largeur maximale des images ou des fichiers Flash dans les messages et dans les messages privés. Réglez cette valeur sur 0 afin de ne limiter la largeur.',
	'MAX_POST_URLS'					=> 'Nombre maximum de lien(s) par message et message privé ',
	'MAX_POST_URLS_EXPLAIN'			=> 'Le nombre maximum de lien(s) que les utilisateurs peuvent insérer dans un message et dans un message privé. Réglez cette valeur sur 0 afin de ne pas limiter le nombre de lien.',
	'MIN_CHAR_LIMIT'				=> 'Nombre minimum de caractère(s) par message et message privé ',
	'MIN_CHAR_LIMIT_EXPLAIN'		=> 'Le nombre minimum de caractère(s) que les utilisateurs doivent saisir afin d’être en mesure de publier un message ou un message privé.',
	'POSTING'						=> 'Publication',
	'POSTS_PER_PAGE'				=> 'Nombre de message(s) par page ',
	'QUOTE_DEPTH_LIMIT'				=> 'Profondeur maximale d’imbrication de citations ',
	'QUOTE_DEPTH_LIMIT_EXPLAIN'		=> 'La profondeur maximale d’imbrication de citations dans un message et dans un message privé. Réglez cette valeur sur 0 afin de ne pas limiter la profondeur.',
	'SMILIES_LIMIT'					=> 'Nombre maximum d’émoticône(s) par message et message privé ',
	'SMILIES_LIMIT_EXPLAIN'			=> 'Le nombre maximum d’émoticône(s) que les utilisateurs peuvent insérer dans un message et dans un message privé. Réglez cette valeur sur 0 afin de ne pas limiter le nombre d’émoticône.',
	'SMILIES_PER_PAGE'				=> 'Nombre d’émoticône(s) par page ',
	'TOPICS_PER_PAGE'				=> 'Nombre de sujet(s) par page ',
));

// Signature Settings
$lang = array_merge($lang, array(
	'ACP_SIGNATURE_SETTINGS_EXPLAIN'	=> 'Vous pouvez effectuer ici tous les réglages concernant les signatures.',

	'MAX_SIG_FONT_SIZE'				=> 'Taille maximale de la police de caractères dans la signature des utilisateurs ',
	'MAX_SIG_FONT_SIZE_EXPLAIN'		=> 'La taille maximale de la police de caractères autorisée dans la signature des utilisateurs. Réglez cette valeur sur 0 afin de ne pas limiter la taille de la police de caractères.',
	'MAX_SIG_IMG_HEIGHT'			=> 'Hauteur maximale des images dans la signature des utilisateurs ',
	'MAX_SIG_IMG_HEIGHT_EXPLAIN'	=> 'La hauteur maximale des images et des fichiers Flash dans la signature des utilisateurs. Réglez cette valeur sur 0 afin de ne pas limiter la hauteur.',
	'MAX_SIG_IMG_WIDTH'				=> 'Largeur maximale des images dans la signature des utilisateurs ',
	'MAX_SIG_IMG_WIDTH_EXPLAIN'		=> 'La largeur maximale des images et des fichiers Flash dans la signature des utilisateurs. Réglez cette valeur sur 0 afin de ne pas limiter la largeur.',
	'MAX_SIG_LENGTH'				=> 'Longueur maximale de la signature des utilisateurs ',
	'MAX_SIG_LENGTH_EXPLAIN'		=> 'Le nombre maximum de caractère(s) autorisé(s) dans la signature des utilisateurs.',
	'MAX_SIG_SMILIES'				=> 'Nombre maximum d’émoticône(s) dans la signature des utilisateurs ',
	'MAX_SIG_SMILIES_EXPLAIN'		=> 'Le nombre maximum d’émoticône(s) autorisée(s) dans la signature des utilisateurs. Réglez cette valeur sur 0 afin de ne pas limiter le nombre d’émoticône.',
	'MAX_SIG_URLS'					=> 'Nombre maximum de lien(s) dans la signature des utilisateurs ',
	'MAX_SIG_URLS_EXPLAIN'			=> 'Le nombre maximum de lien(s) autorisé(s) dans la signature des utilisateurs. Réglez cette valeur sur 0 afin de ne pas limiter le nombre de lien.',
));

// Registration Settings
$lang = array_merge($lang, array(
	'ACP_REGISTER_SETTINGS_EXPLAIN'		=> 'Vous pouvez effectuer ici les réglages relatifs aux inscriptions et aux profils des utilisateurs.',

	'ACC_ACTIVATION'			=> 'Activation du compte ',
	'ACC_ACTIVATION_EXPLAIN'	=> 'Détermine quels sont les utilisateurs qui bénéficieront d’un accès immédiat au forum ou si une confirmation leur sera demandée. Vous pouvez également désactiver entièrement les nouvelles inscriptions. « L’envoi de courriels par l’intermédiaire du forum » doit être activé afin d’être en mesure de pouvoir utiliser l’activation par l’administrateur ou par l’utilisateur.',
	'NEW_MEMBER_POST_LIMIT'			=> 'Limite de message(s) des nouveaux membres ',
	'NEW_MEMBER_POST_LIMIT_EXPLAIN'	=> 'Les nouveaux membres seront membres du groupe des <em>utilisateurs inscrits récemment</em> jusqu’à ce qu’ils atteignent ce nombre de message(s). Vous pouvez utiliser ce groupe afin de ne pas les autoriser à utiliser la messagerie privée ou à contrôler leurs messages. <strong>Réglez cette valeur sur 0 afin de désactiver cette fonctionnalité.</strong>',
	'NEW_MEMBER_GROUP_DEFAULT'		=> 'Régler par défaut le groupe des utilisateurs inscrits récemment ',
	'NEW_MEMBER_GROUP_DEFAULT_EXPLAIN'	=> 'Si cette option est activée et que la limite de message(s) des nouveaux membres est spécifiée, les nouveux membres ne seront pas uniquement membres du groupe des <em>utilisateurs inscrits récemment</em> mais ce groupe sera également leur groupe par défaut. Cela peut être pratique si vous souhaitez attribuer un rang ou un avatar par défaut afin que tous les nouveaux utilisateurs en profitent.',

	'ACC_ADMIN'					=> 'Par l’administrateur',
	'ACC_DISABLE'				=> 'Désactiver les inscriptions',
	'ACC_NONE'					=> 'Aucune activation',
	'ACC_USER'					=> 'Par l’utilisateur (vérification par courriel)',
//	'ACC_USER_ADMIN'			=> 'Par l’utilisateur et l’administrateur',
	'ALLOW_EMAIL_REUSE'			=> 'Autoriser les adresses de courrier électronique à être réutilisées ',
	'ALLOW_EMAIL_REUSE_EXPLAIN'	=> 'Différents utilisateurs pourront s’inscrire en spécifiant la même adresse de courrier électronique.',
	'COPPA'						=> 'COPPA',
	'COPPA_FAX'					=> 'Numéro de fax de la COPPA ',
	'COPPA_MAIL'				=> 'Adresse de courrier électronique de la COPPA ',
	'COPPA_MAIL_EXPLAIN'		=> 'L’adresse de courrier électronique à laquelle les parents devront envoyer les formulaires de la COPPA.',
	'ENABLE_COPPA'				=> 'Activer la COPPA ',
	'ENABLE_COPPA_EXPLAIN'		=> 'Oblige les utilisateurs à déclarer qu’ils ont 13 ans ou plus afin d’être conforme à la COPPA. Si cette option est désactivée, les groupes spécifiques à la COPPA ne seront plus affichés.',
	'MAX_CHARS'					=> 'Max',
	'MIN_CHARS'					=> 'Min',
	'NO_AUTH_PLUGIN'			=> 'Aucun plugin d’authentification n’a été trouvé.',
	'PASSWORD_LENGTH'			=> 'Longueur du mot de passe ',
	'PASSWORD_LENGTH_EXPLAIN'	=> 'Le nombre de caractères minimums et maximums qui sont obligatoires dans les mots de passe.',
	'REG_LIMIT'					=> 'Nombre de tentative(s) d’inscription ',
	'REG_LIMIT_EXPLAIN'			=> 'Le nombre de tentative(s) d’inscription que les utilisateurs seront autorisés d’essayer avant que leur session n’expire.',
	'USERNAME_ALPHA_ONLY'		=> 'Alphanumérique uniquement',
	'USERNAME_ALPHA_SPACERS'	=> 'Alphanumérique et espaces',
	'USERNAME_ASCII'			=> 'ASCII (aucun caractère international)',
	'USERNAME_LETTER_NUM'		=> 'Lettres et nombres',
	'USERNAME_LETTER_NUM_SPACERS'	=> 'Lettres, nombres et espaces',
	'USERNAME_CHARS'			=> 'Limite de caractères du nom d’utilisateur ',
	'USERNAME_CHARS_ANY'		=> 'Tous les caractères',
	'USERNAME_CHARS_EXPLAIN'	=> 'Limite le type de caractères qui peuvent être utilisés dans les noms d’utilisateurs. Les espaces comprennent : espace, -, +, _, [ et ].',
	'USERNAME_LENGTH'			=> 'Longueur du nom d’utilisateur ',
	'USERNAME_LENGTH_EXPLAIN'	=> 'Le nombre de caractères minimums et maximums qui sont obligatoires dans les noms d’utilisateurs.',
));

// Feeds
$lang = array_merge($lang, array(
	'ACP_FEED_MANAGEMENT'				=> 'Réglages des flux de syndication généraux',
	'ACP_FEED_MANAGEMENT_EXPLAIN'		=> 'Ce module rend disponible de multiples flux ATOM, en décomposant tout BBCode dans les messages afin de les rendre lisibles dans les flux externes.',

	'ACP_FEED_GENERAL'					=> 'Réglages du flux général',
	'ACP_FEED_POST_BASED'				=> 'Réglages du flux lié aux messages',
	'ACP_FEED_TOPIC_BASED'				=> 'Réglages du flux lié aux sujets',
	'ACP_FEED_SETTINGS_OTHER'			=> 'Autres réglages et flux',

	'ACP_FEED_ENABLE'					=> 'Activer les flux ',
	'ACP_FEED_ENABLE_EXPLAIN'			=> 'Active ou désactive les flux ATOM dans la totalité du forum.<br />En désactivant cette option, tous les flux seront désactivés, sans prendre en compte les réglages des options ci-dessous.',
	'ACP_FEED_LIMIT'					=> 'Nombre maximum d’objet(s) ',
	'ACP_FEED_LIMIT_EXPLAIN'			=> 'Le nombre maximum d’objet(s) à afficher dans les flux.',

	'ACP_FEED_OVERALL'					=> 'Activer le flux des messages de l’ensemble du forum ',
	'ACP_FEED_OVERALL_EXPLAIN'			=> 'Permet de consulter les nouveaux messages de l’ensemble du forum.',
	'ACP_FEED_FORUM'					=> 'Activer les flux par forum ',
	'ACP_FEED_FORUM_EXPLAIN'			=> 'Permet de consulter les nouveaux messages d’un forum unique et de ses sous-forums.',
	'ACP_FEED_TOPIC'					=> 'Activer les flux par sujet ',
	'ACP_FEED_TOPIC_EXPLAIN'			=> 'Permet de consulter les nouveaux d’un sujet unique.',

	'ACP_FEED_TOPICS_NEW'				=> 'Activer le flux des nouveaux sujets ',
	'ACP_FEED_TOPICS_NEW_EXPLAIN'		=> 'Active le flux des « nouveaux sujets », qui affiche les derniers sujets créés et leur le premier message.',
	'ACP_FEED_TOPICS_ACTIVE'			=> 'Activer le flux des sujets actifs ',
	'ACP_FEED_TOPICS_ACTIVE_EXPLAIN'	=> 'Active le flux des « sujet actifs », qui affiche les derniers sujets actifs et leur premier message.',
	'ACP_FEED_NEWS'						=> 'Flux des nouveautés ',
	'ACP_FEED_NEWS_EXPLAIN'				=> 'Extrait le premier message à partir de ces forums. Si vous ne souhaitez pas activer le flux des nouveautés, ne sélectionnez aucun forum.<br />Vous pouvez sélectionner et désélectionner plusieurs forums en pressant <samp>CTRL</samp> et en cliquant.',

	'ACP_FEED_OVERALL_FORUMS'			=> 'Activer le flux des forums ',
	'ACP_FEED_OVERALL_FORUMS_EXPLAIN'	=> 'Active le flux de « tous les forums », qui affiche une liste des forums.',

	'ACP_FEED_HTTP_AUTH'				=> 'Autoriser l’authentification HTTP ',
	'ACP_FEED_HTTP_AUTH_EXPLAIN'		=> 'Autorise l’authentification HTTP, ce qui permet aux utilisateurs de recevoir un contenu caché aux invités en ajoutant le paramètre <samp>auth=http</samp> à l’adresse du flux. Veuillez noter que certaines installations de PHP demandent à effectuer des modifications additionnelles sur le fichier .htaccess afin de fonctionner. Toutes les instructions sont contenues dans ce fichier.',
	'ACP_FEED_ITEM_STATISTICS'			=> 'Statistiques des objets ',
	'ACP_FEED_ITEM_STATISTICS_EXPLAIN'	=> 'Affiche les statistiques individuelles sous les articles du flux.<br />Exemples : auteur de la publication, date et heure de la publication, nombre de réponses, nombre de consultations, etc.',
	'ACP_FEED_EXCLUDE_ID'				=> 'Exclure ces forums ',
	'ACP_FEED_EXCLUDE_ID_EXPLAIN'		=> 'Le contenu de ces forums ne seront <strong>pas inclus dans ces flux</strong>. Si vous souhaitez extraire les données de ces forums, ne les sélectionnez pas.<br />Vous pouvez sélectionner et désélectionner plusieurs forums en pressant <samp>CTRL</samp> et en cliquant.',
));

// Visual Confirmation Settings
$lang = array_merge($lang, array(
	'ACP_VC_SETTINGS_EXPLAIN'		=> 'Vous pouvez sélectionner et configurer ici les plugins qui permettent de lutter contre l’envoi de formulaires par des robots indésirables. Ces plugins fonctionnent en général en demandant aux utilisateur de résoudre un <em>CAPTCHA</em>, qui est un outil permettant de différencier un utilisateur humain d’un robot.',
	'AVAILABLE_CAPTCHAS'					=> 'Plugins disponibles',
	'CAPTCHA_UNAVAILABLE'					=> 'Le plugin ne peut pas être sélectionné tant que ses exigences ne sont pas remplies.',
	'CAPTCHA_GD'							=> 'Bruit GD de l’image',
	'CAPTCHA_GD_3D'						=> 'Bruit GD en 3D de l’image',
	'CAPTCHA_GD_FOREGROUND_NOISE'			=> 'Bruit GD de premier plan',
	'CAPTCHA_GD_EXPLAIN'					=> 'Utilisez l’extension GD afin de rendre l’image plus difficile à déchiffrer.',
	'CAPTCHA_GD_FOREGROUND_NOISE_EXPLAIN'	=> 'Utilisez un bruit de premier plan afin de rendre l’image plus difficile à déchiffrer.',
	'CAPTCHA_GD_X_GRID'						=> 'Bruit de fond sur l’axe des abscisses',
	'CAPTCHA_GD_X_GRID_EXPLAIN'				=> 'Utilisez des valeurs faibles afin de rendre l’image plus difficile à déchiffrer. Réglez cette valeur à <samp>0</samp> afin de désactiver le bruit de fond sur l’axe des abscisses.',
	'CAPTCHA_GD_Y_GRID'						=> 'Bruit de fond sur l’axe des ordonnées',
	'CAPTCHA_GD_Y_GRID_EXPLAIN'				=> 'Utilisez des valeurs faibles afin de rendre l’image plus difficile à déchiffrer. Réglez cette valeur à <samp>0</samp> afin de désactiver le bruit de fond sur l’axe des ordonnées.',
	'CAPTCHA_GD_WAVE'						=> 'Distorsion en forme de vagues',
	'CAPTCHA_GD_WAVE_EXPLAIN'				=> 'Cela mettra en place une distorsion en forme de vagues sur l’image.',
 	'CAPTCHA_GD_3D_NOISE'					=> 'Ajouter des objets de bruit en 3D',
	'CAPTCHA_GD_3D_NOISE_EXPLAIN'			=> 'Cela ajoutera des objets supplémentaires sur l’image, par-dessus les lettres.',
	'CAPTCHA_GD_FONTS'						=> 'Utiliser des polices de caractères différentes',
	'CAPTCHA_GD_FONTS_EXPLAIN'				=> 'Ce réglage contrôle le nombre de différentes formes de lettres qui seront utilisées. Vous pouvez seulement utiliser les formes par défaut ou introduire de nouvelles lettres. L’ajout de lettres en minuscules est également possible.',
	'CAPTCHA_FONT_DEFAULT'					=> 'Défaut',
	'CAPTCHA_FONT_NEW'						=> 'Nouvelles formes',
	'CAPTCHA_FONT_LOWER'					=> 'Utiliser également des minuscules',
	'CAPTCHA_NO_GD'							=> 'Image simple',
	'CAPTCHA_PREVIEW_MSG'					=> 'Vos modifications n’ont pas été enregistrées, ceci n’est qu’une prévisualisation.',
	'CAPTCHA_PREVIEW_EXPLAIN'				=> 'Le plugin tel qu’il ressemblera lors de l’utilisation de la sélection actuelle.',

	'CAPTCHA_SELECT'						=> 'Plugins installés ',
	'CAPTCHA_SELECT_EXPLAIN'				=> 'La liste déroulante des plugins reconnus par le forum. Les entrées grises ne sont pas encore disponibles et peuvent avoir besoin d’être configurées avant de pouvoir être utilisées.',
	'CAPTCHA_CONFIGURE'						=> 'Configurer les plugins ',
	'CAPTCHA_CONFIGURE_EXPLAIN'				=> 'Modifie les réglages du plugin que vous avez sélectionné.',
	'CONFIGURE'								=> 'Configurer',
	'CAPTCHA_NO_OPTIONS'					=> 'Ce plugin n’a aucune option de configuration.',

	'VISUAL_CONFIRM_POST'					=> 'Activer les mesures de lutte contre les robots indésirables aux invités ',
	'VISUAL_CONFIRM_POST_EXPLAIN'			=> 'Cette option rend obligatoire aux invités de compléter des mesures de lutte contre les robots indésirables afin d’empêcher la publication de messages automatisés.',
	'VISUAL_CONFIRM_REG'					=> 'Activer les mesures de lutte contre les robots indésirables lors des inscriptions ',
	'VISUAL_CONFIRM_REG_EXPLAIN'			=> 'Oblige les nouveaux utilisateurs à compléter des mesures de lutte contre les robots indésirables afin d’empêcher les inscriptions automatisées.',
	'VISUAL_CONFIRM_REFRESH'				=> 'Autoriser les utilisateurs à rafraîchir les mesures de lutte contre les robots indésirables ',
	'VISUAL_CONFIRM_REFRESH_EXPLAIN'		=> 'Autorise les utilisateurs à demander une nouvelle mesure de lutte contre les robots indésirables s’ils sont incapables de déchiffrer la mesure actuelle. Il se peut que certains plugins ne supportent pas cette option.',
));

// Cookie Settings
$lang = array_merge($lang, array(
	'ACP_COOKIE_SETTINGS_EXPLAIN'		=> 'Ces informations définissent les données utilisées à envoyer sous forme de cookie au navigateur de vos utilisateurs. Dans la plupart des cas, les valeurs par défaut devraient être suffisantes. Si vous avez besoin de les modifier, faites-le avec précaution, des réglages incorrects peuvent empêcher les utilisateurs à se connecter correctement.',

	'COOKIE_DOMAIN'				=> 'Domaine du cookie ',
	'COOKIE_NAME'				=> 'Nom du cookie ',
	'COOKIE_PATH'				=> 'Chemin du cookie ',
	'COOKIE_SECURE'				=> 'Cookie sécurisé ',
	'COOKIE_SECURE_EXPLAIN'		=> 'N’activez cette option que si votre serveur fonctionne par l’intermédiaire d’SSL. Des erreurs surviendront lors des redirections si vous activez cette option alors que votre serveur n’utilise pas SSL.',
	'ONLINE_LENGTH'				=> 'Durée d’apparition dans la liste des utilisateurs en ligne ',
	'ONLINE_LENGTH_EXPLAIN'		=> 'Nombre de minutes après lesquelles les utilisateurs inactifs n’apparaîtront plus dans la liste des utilisateurs en ligne. Plus la valeur est élevée, plus le traitement afin de générer la liste sera long.',
	'SESSION_LENGTH'			=> 'Durée de la session ',
	'SESSION_LENGTH_EXPLAIN'	=> 'Les sessions expireront une fois que cette durée, en secondes, sera dépassée.',
));

// Load Settings
$lang = array_merge($lang, array(
	'ACP_LOAD_SETTINGS_EXPLAIN'	=> 'Vous pouvez activer et désactiver ici certaines fonctionnalités du forum afin de réduire sa quantité de traitement. Sur la plupart des serveurs, il n’y a pas besoin de désactiver ces fonctionnalités. Cependant, sur certains systèmes ou hébergements, il est préférable de désactiver certaines fonctionnalités dont vous n’avez pas réellement besoin. Vous pouvez également spécifier des limitations concernant la charge du système et les sessions actives au delà desquelles le forum apparaîtra hors-ligne.',

	'CUSTOM_PROFILE_FIELDS'			=> 'Champs de profil personnalisés',
	'LIMIT_LOAD'					=> 'Charge maximale du système ',
	'LIMIT_LOAD_EXPLAIN'			=> 'Si la charge du système dépasse cette valeur durant la dernière minute, le forum sera automatiquement désactivé. Une valeur de 1.0 équivaut à environ 100% de l’utilisation d’un processeur. Cela ne fonctionne que sur des serveurs basés sous UNIX et dans lesquels cette information est accessible. Cette valeur se réinitialise sur 0 si phpBB n’arrive pas à obtenir la valeur de la charge du système.',
	'LIMIT_SESSIONS'				=> 'Limiter les sessions ',
	'LIMIT_SESSIONS_EXPLAIN'		=> 'Si le nombre de sessions dépasse cette valeur durant une minute, le forum apparaîtra hors-ligne. Réglez cette valeur sur 0 afin de ne pas limiter le nombre de sessions.',
	'LOAD_CPF_MEMBERLIST'			=> 'Autoriser les styles à afficher des champs de profil personnalisés dans la liste des membres ',
	'LOAD_CPF_VIEWPROFILE'			=> 'Afficher les champs de profil personnalisés dans le profil des utilisateurs ',
	'LOAD_CPF_VIEWTOPIC'			=> 'Afficher les champs de profil personnalisés dans les pages des sujets ',
	'LOAD_USER_ACTIVITY'			=> 'Afficher l’activité des utilisateurs ',
	'LOAD_USER_ACTIVITY_EXPLAIN'	=> 'Affiche la liste des sujets et des forums actifs dans le profil et le panneau de contrôle de l’utilisateur. Il est recommandé de désactiver cette fonctionnalité sur les forums ayant plus d’un million de messages.',
	'RECOMPILE_STYLES'				=> 'Recompiler les composants expirés des styles ',
	'RECOMPILE_STYLES_EXPLAIN'		=> 'Vérifie les mises à jour des composants expirés des styles installés sur le système, puis les recompile.',
	'YES_ANON_READ_MARKING'			=> 'Activer l’indicateur de lecture des sujets pour les invités ',
	'YES_ANON_READ_MARKING_EXPLAIN'	=> 'Enregistre l’indicateur de lecture des sujets (s’ils sont lus ou non lus) pour les invités. Si cette option est désactivée, les messages seront toujours marqués comme lus pour les invités.',
	'YES_BIRTHDAYS'					=> 'Activer la liste des anniversaires ',
	'YES_BIRTHDAYS_EXPLAIN'			=> 'Si cette option est désactivée, la liste des anniversaires ne sera plus affichée. Pour que ce réglage prenne effet, la fonctionnalité des anniversaires doit également être activée.',
	'YES_JUMPBOX'					=> 'Activer l’affichage de l’accès rapide aux forums ',
	'YES_MODERATORS'				=> 'Activer l’affichage des modérateurs ',
	'YES_ONLINE'					=> 'Activer l’affichage de la liste des utilisateurs ',
	'YES_ONLINE_EXPLAIN'			=> 'Affiche la liste des utilisateurs en ligne parcourant l’index, les forums et les pages des sujets du forum.',
	'YES_ONLINE_GUESTS'				=> 'Activer l’affichage des invités dans la liste des utilisateurs ',
	'YES_ONLINE_GUESTS_EXPLAIN'		=> 'Affiche l’affichage des invités dans la liste des utilisateurs en ligne parcourant le forum.',
	'YES_ONLINE_TRACK'				=> 'Activer l’affichage de la vérification du statut des utilisateurs ',
	'YES_ONLINE_TRACK_EXPLAIN'		=> 'Affiche le statut en ligne des utilisateurs dans les profils et les pages des sujets.',
	'YES_POST_MARKING'				=> 'Activer les sujets pointés ',
	'YES_POST_MARKING_EXPLAIN'		=> 'Indique à l’utilisateur s’il a publié un message ou non dans un sujet.',
	'YES_READ_MARKING'				=> 'Activer l’indicateur de lecture par le serveur ',
	'YES_READ_MARKING_EXPLAIN'		=> 'Enregistre l’indicateur de lecture des sujets (s’ils sont lus ou non lus) dans la base de données à la place d’un cookie.',
	'YES_UNREAD_SEARCH'				=> 'Activer la recherche des messages non lus ',
));

// Auth settings
$lang = array_merge($lang, array(
	'ACP_AUTH_SETTINGS_EXPLAIN'	=> 'phpBB supporte les modules d’authentification. Ceux-ci vous permettent de déterminer la manière dont les utilisateurs s’authentifient lors de leur connexion au forum. Trois modules sont fournis par défaut : la base de données, LDAP et Apache. Toutes les méthodes ne nécessitent pas d’informations supplémentaires, ne remplissez les champs que s’ils sont appropriés à la méthode sélectionnée.',

	'AUTH_METHOD'				=> 'Sélectionner une méthode d’authentification ',

	'APACHE_SETUP_BEFORE_USE'	=> 'Vous devez configurer l’authentification d’Apache avant de faire fonctionner phpBB sous cette méthode d’authentification. Gardez à l’esprit que le nom d’utilisateur que vous utilisez afin de vous authentifier à Apache doit être le même que votre nom d’utilisateur phpBB. L’authentification par Apache ne peut être utilisé que si <var>mod_php</var> (sans CGI) et <var>safe_mode</var> sont désactivés.',

	'LDAP_DN'						=> 'Base LDAP vers <var>dn</var> ',
	'LDAP_DN_EXPLAIN'				=> 'Correspond au nom absolu situant toutes les informations des utilisateurs, telles que <samp>o=MaCompagnie,c=FR</samp>.',
	'LDAP_EMAIL'					=> 'Attribut LDAP des adresses de courrier électronique ',
	'LDAP_EMAIL_EXPLAIN'			=> 'Correspond au nom de l’attribut de l’adresse de courrier électronique de vos utilisateurs, s’il existe, qui permet de compléter automatiquement l’adresse de courrier électronique de tous vos nouveaux utilisateurs. Ne remplissez pas cette case si vous souhaitez que le champ de l’adresse de courrier électronique soit vide pour les utilisateurs qui se connectent pour la première fois.',
	'LDAP_INCORRECT_USER_PASSWORD'	=> 'La connexion au serveur LDAP a échouée car le nom d’utilisateur ou le mot de passe que vous avez spécifié est incorrect.',
	'LDAP_NO_EMAIL'					=> 'L’attribut de l’adresse de courrier électronique que vous avez spécifié n’existe pas.',
	'LDAP_NO_IDENTITY'				=> 'L’identifiant de connexion concernant %s est introuvable.',
	'LDAP_PASSWORD'					=> 'Mot de passe LDAP ',
	'LDAP_PASSWORD_EXPLAIN'			=> 'Laissez vide afin d’utiliser une connexion anonyme et dans le cas contraire, indiquez le mot de passe concernant l’utilisateur spécifié ci-dessus. Ceci est obligatoire pour les serveurs aux répertoires dits actifs.<br /><em><strong>Attention :</strong> ce mot de passe sera archivé en texte brut dans la base de données et sera donc visible à tous ceux qui ont accès à votre base de données ou à la page de configuration.</em>',
	'LDAP_PORT'						=> 'Port du serveur LDAP ',
	'LDAP_PORT_EXPLAIN'				=> 'Si vous le souhaitez, vous pouvez spécifier un port LDAP qui sera utilisé afin de vous connecter sur un port différent au port 389 qui est utilisé par défaut.',
	'LDAP_SERVER'					=> 'Nom du serveur LDAP ',
	'LDAP_SERVER_EXPLAIN'			=> 'Si vous utilisez LDAP, cela correspond au nom d’hôte ou à l’adresse IP du serveur LDAP. Vous pouvez également spécifier un lien, tel que <samp>ldap://hostname:port/</samp>.',
	'LDAP_UID'						=> 'Clé <var>uid</var> de LDAP ',
	'LDAP_UID_EXPLAIN'				=> 'Correspond à la clé avec laquelle vous pouvez rechercher un identifiant de connexion, tel que <var>uid</var>, <var>sn</var>, etc.',
	'LDAP_USER'						=> 'Utilisateur <var>dn</var> LDAP ',
	'LDAP_USER_EXPLAIN'				=> 'Laissez vide afin d’utiliser une connexion anonyme. Si cela a été renseigné dans phpBB, utilisez le nom absolu que vous avez spécifié lors des tentatives de connexion afin de trouver l’utilisateur correct, tel que <samp>uid=Nom,ou=MonUnité,o=MaCompagnie,c=FR</samp>. Ceci est obligatoire pour les serveurs aux répertoires dits actifs.',
	'LDAP_USER_FILTER'				=> 'Filtre de l’utilisateur LDAP ',
	'LDAP_USER_FILTER_EXPLAIN'		=> 'Si vous le souhaitez, vous pouvez limiter les objets recherchés grâce à des filtres additionnels. Par exemple, <samp>objectClass=posixGroup</samp> deviendra <samp>(&(uid=$username)(objectClass=posixGroup))</samp> lors de l’utilisation.',
));

// Server Settings
$lang = array_merge($lang, array(
	'ACP_SERVER_SETTINGS_EXPLAIN'	=> 'Vous pouvez effectuer ici les réglages relatifs au serveur et au domaine. Veuillez vous assurer que les données que vous saisissez sont correctes car des erreurs pourraient survenir dans l’envoi de courriels dans le cas contraire. Lorsque vous saisissez le nom de domaine, n’oubliez pas d’y inclure le protocole, comme <samp>http://</samp>. Ne modifiez le numéro de port que si vous savez que le serveur en utilise un différent. Sachez néanmoins que le port 80 est correct dans la plupart des cas.',

	'ENABLE_GZIP'				=> 'Activer la compression GZip ',
	'ENABLE_GZIP_EXPLAIN'		=> 'Le contenu généré sera compressé avant d’être envoyé aux utilisateurs. Cela peut réduire le trafic du réseau, mais cela augmentera également l’utilisation du processeur de votre serveur et celui de vos utilisateurs. L’extension PHP zlib doit être chargée afin que la compression GZip fonctionne.',
	'FORCE_SERVER_VARS'			=> 'Forcer les réglages des liens du serveur ',
	'FORCE_SERVER_VARS_EXPLAIN'	=> 'Si cette option est activée, les réglages du serveur spécifiés ici seront utilisés à la place des valeurs automatiques.',
	'ICONS_PATH'				=> 'Chemin vers le répertoire de stockage des icônes ',
	'ICONS_PATH_EXPLAIN'		=> 'Chemin depuis la racine de votre répertoire de phpBB, tel que <samp>images/icons</samp>.',
	'PATH_SETTINGS'				=> 'Réglages du chemin',
	'RANKS_PATH'				=> 'Chemin vers le répertoire de stockage des images de rangs ',
	'RANKS_PATH_EXPLAIN'		=> 'Chemin depuis la racine de votre répertoire de phpBB, tel que <samp>images/ranks</samp>.',
	'SCRIPT_PATH'				=> 'Chemin du script ',
	'SCRIPT_PATH_EXPLAIN'		=> 'Le chemin où phpBB est installé par rapport au nom de domaine, tel que <samp>/phpBB3</samp>.',
	'SERVER_NAME'				=> 'Nom de domaine ',
	'SERVER_NAME_EXPLAIN'		=> 'Le nom de domaine sur lequel votre serveur fonctionne, tel que <samp>www.example.com</samp>.',
	'SERVER_PORT'				=> 'Port du serveur ',
	'SERVER_PORT_EXPLAIN'		=> 'Le port sur lequel votre serveur fonctionne, habituellement le 80.',
	'SERVER_PROTOCOL'			=> 'Protocole du serveur ',
	'SERVER_PROTOCOL_EXPLAIN'	=> 'Ceci est utilisé comme protocole du serveur. Si celui-ci est vide ou qu’il n’a pas été forcé, le protocole à utiliser sera déterminé par le réglage des cookies sécurisés (<samp>http://</samp> ou <samp>https://</samp>).',
	'SERVER_URL_SETTINGS'		=> 'Réglages des liens du serveur',
	'SMILIES_PATH'				=> 'Chemin vers le répertoire de stockage des émoticônes ',
	'SMILIES_PATH_EXPLAIN'		=> 'Chemin depuis la racine de votre répertoire de phpBB, tel que <samp>images/smilies</samp>.',
	'UPLOAD_ICONS_PATH'			=> 'Chemin vers le répertoire de stockage des icônes des groupes d’extensions ',
	'UPLOAD_ICONS_PATH_EXPLAIN'	=> 'Chemin depuis la racine de votre répertoire de phpBB, tel que <samp>images/upload_icons</samp>.',
));

// Security Settings
$lang = array_merge($lang, array(
	'ACP_SECURITY_SETTINGS_EXPLAIN'		=> 'Vous pouvez effectuer ici les réglages relatifs aux sessions et aux connexions.',

	'ALL'							=> 'Tous',
	'ALLOW_AUTOLOGIN'				=> 'Autoriser les connexions automatiques ',
	'ALLOW_AUTOLOGIN_EXPLAIN'		=> 'Autorise les utilisateurs à se connecter automatiquement lors de leurs visites sur le forum.',
	'AUTOLOGIN_LENGTH'				=> 'Durée d’expiration des clés de connexions automatiques ',
	'AUTOLOGIN_LENGTH_EXPLAIN'		=> 'Une fois ce nombre de jours expiré, les clés de connexions automatiques seront supprimées. Réglez cette valeur sur 0 afin de désactiver ce comportement.',
	'BROWSER_VALID'					=> 'Valider les navigateurs ',
	'BROWSER_VALID_EXPLAIN'			=> 'Active la validation des navigateurs sur chaque session, ce qui améliore la sécurité.',
	'CHECK_DNSBL'					=> 'Vérifier l’adresse IP dans la liste noire des système d’adressage par domaines ',
	'CHECK_DNSBL_EXPLAIN'			=> 'Si cette option est activée, les adresses IP des utilisateurs seront vérifiées par les services DNSBL suivants lors de l’inscription et la publication de messages : <a href="http://spamcop.net">spamcop.net</a> et <a href="http://www.spamhaus.org">www.spamhaus.org</a>. Cette vérification peut durer un certain temps, tout dépend de la configuration du serveur sélectionné. Si vous remarquez des ralentissements ou des erreurs d’appréciation, il est conseillé de désactiver cette vérification.',
	'CLASS_B'						=> 'A.B',
	'CLASS_C'						=> 'A.B.C',
	'EMAIL_CHECK_MX'				=> 'Vérifier l’enregistrement MX des adresses de courrier électronique ',
	'EMAIL_CHECK_MX_EXPLAIN'		=> 'Si cette option est activée, le domaine de l’adresse de courrier électronique spécifié lors de l’inscription et des modifications du profil sera vérifié afin de s’assurer qu’il possède un enregistrement MX valide.',
	'FORCE_PASS_CHANGE'				=> 'Forcer la modification du mot de passe ',
	'FORCE_PASS_CHANGE_EXPLAIN'		=> 'Oblige les utilisateurs à modifier leur mot de passe après qu’un certain nombre de jours ne soit dépassé. Réglez cette valeur sur 0 afin de désactiver ce comportement.',
	'FORM_TIME_MAX'					=> 'Durée maximale de l’envoi des formulaires ',
	'FORM_TIME_MAX_EXPLAIN'			=> 'Détermine la durée maximale qu’un utilisateur ne doit pas dépasser afin d’envoyer un formulaire. Réglez cette valeur sur -1 afin de désactiver ce comportement. Veuillez noter que si la session d’un utilisateur expire, un formulaire peut devenir incorrect, mais cela ne dépend pas de ce réglage.',
	'FORM_SID_GUESTS'				=> 'Lier les formulaires aux sessions des invités ',
	'FORM_SID_GUESTS_EXPLAIN'		=> 'Si cette option est activée, les formulaires émis aux invités seront exclusifs à leur session. Cela peut entraîner quelques problèmes avec certains fournisseurs d’accès à internet.',
	'FORWARDED_FOR_VALID'			=> 'Valider l’en-tête <var>X_FORWARDED_FOR</var> ',
	'FORWARDED_FOR_VALID_EXPLAIN'	=> 'Les sessions ne continueront que si l’en-tête <var>X_FORWARDED_FOR</var> envoyé équivaut à celui qui avait été envoyé lors de la requête précédente. L’en-tête <var>X_FORWARDED_FOR</var> vérifiera également que les adresses IP n’ont pas été bannies.',
	'IP_VALID'						=> 'Valider la session IP ',
	'IP_VALID_EXPLAIN'				=> 'Détermine quelle partie de l’adresse IP des utilisateurs sera utilisée afin de valider une session ; <samp>Tous</samp> compare l’adresse complète, <samp>A.B.C</samp> les premiers x.x.x, <samp>A.B</samp> les premiers x.x et <samp>Aucune</samp> désactive cette vérification. Concernant les adresses IPv6, <samp>A.B.C</samp> compare les 4 premiers blocs et <samp>A.B</samp> les 3 premiers blocs.',
	'IP_LOGIN_LIMIT_MAX'			=> 'Nombre maximum de tentatives de connexion par adresse IP',
	'IP_LOGIN_LIMIT_MAX_EXPLAIN'	=> 'Le nombre de tentatives de connexion autorisées à partir d’une adresse IP unique avant que la saisie d’un code de confirmation ne soit requise. Réglez cette valeur sur 0 afin de ne pas demander la saisie d’un code de confirmation à partir des adresses IP.',
	'IP_LOGIN_LIMIT_TIME'			=> 'Délai d’expiration des tentatives de connexion par adresse IP',
	'IP_LOGIN_LIMIT_TIME_EXPLAIN'	=> 'Les tentatives de connexion expirent après que ce délai soit dépassé.',
	'IP_LOGIN_LIMIT_USE_FORWARDED'	=> 'Limite des tentatives de connexion par en-tête <var>X_FORWARDED_FOR</var>',
	'IP_LOGIN_LIMIT_USE_FORWARDED_EXPLAIN'	=> 'Limite les tentatives de connexion par les valeurs de <var>X_FORWARDED_FOR</var> au lieu de les limiter par adresse IP. <br /><em><strong>Attention :</strong> n’activez cette option que si vous utilisez un serveur proxy qui règle correctement les valeurs de <var>X_FORWARDED_FOR</var>.</em>',
	'MAX_LOGIN_ATTEMPTS'			=> 'Nombre maximum de tentatives de connexion par nom d’utilisateur ',
	'MAX_LOGIN_ATTEMPTS_EXPLAIN'	=> 'Le nombre de tentatives de connexion autorisées à partir d’un nom d’utilisateur unique avant que la saisie d’un code issu d’une mesure de lutte contre les robots indésirables ne soit demandée. Réglez cette valeur sur 0 afin de désactiver ce comportement.',
	'NO_IP_VALIDATION'				=> 'Aucune',
	'NO_REF_VALIDATION'				=> 'Aucune',
	'PASSWORD_TYPE'					=> 'Complexité du mot de passe ',
	'PASSWORD_TYPE_EXPLAIN'			=> 'Détermine la complexité des mots de passe qui sont demandés ou modifiés. Chaque option inclut les options précédentes.',
	'PASS_TYPE_ALPHA'				=> 'Doit contenir des lettres et des nombres',
	'PASS_TYPE_ANY'					=> 'Aucune obligation',
	'PASS_TYPE_CASE'				=> 'Doit contenir des majuscules et des minuscules',
	'PASS_TYPE_SYMBOL'				=> 'Doit contenir des symboles spéciaux',
	'REF_HOST'						=> 'Valider uniquement l’hôte',
	'REF_PATH'						=> 'Valider également le chemin',
	'REFERER_VALID'					=> 'Valider le référant ',
	'REFERER_VALID_EXPLAIN'			=> 'Si cette option est activée, le référant des requêtes <code>POST</code> sera vérifié à la place des réglages effectués sur le chemin de l’hôte ou sur le script. Cela peut s’avérer problématique concernant les forums utilisant plusieurs domaines ou connexions externes.',
	'TPL_ALLOW_PHP'					=> 'Autoriser le PHP dans les templates ',
	'TPL_ALLOW_PHP_EXPLAIN'			=> 'Si cette option est activée, les instructions <code>PHP</code> et <code>INCLUDEPHP</code> seront reconnues et analysées dans les templates.',
));

// Email Settings
$lang = array_merge($lang, array(
	'ACP_EMAIL_SETTINGS_EXPLAIN'	=> 'Ces informations sont utilisées lors de l’envoi de courriels à vos utilisateurs. Veuillez vous assurer que l’adresse de courrier électronique que vous avez spécifiée est correcte car les messages refusés ou qui ne peuvent pas être envoyés seront probablement retournés à cette adresse. Si votre hébergeur ne fournit aucun service d’envoi de courriels en PHP par défaut, vous pouvez envoyer directement des messages en utilisant le protocole SMTP. Cela demande l’adresse d’un serveur approprié (si besoin, demandez cela à votre hébergeur). Si le serveur exige une authentification (et seulement dans ce cas), saisissez le nom d’utilisateur, le mot de passe et la méthode d’authentification nécessaire.',

	'ADMIN_EMAIL'					=> 'Adresse de courrier électronique de retour ',
	'ADMIN_EMAIL_EXPLAIN'			=> 'Cette adresse sera utilisée comme l’adresse de retour dans tous les courriels. Cela correspond à l’adresse de courrier électronique du contact technique. Elle sera toujours utilisée comme l’adresse du chemin de retour et de l’expéditeur dans les courriels.',
	'BOARD_EMAIL_FORM'				=> 'Envoi de courriels par l’intermédiaire du forum ',
	'BOARD_EMAIL_FORM_EXPLAIN'		=> 'Si cette option est activée, les utilisateurs pourront, au lieu d’afficher les adresses de courrier électronique, envoyer des courriels par l’intermédiaire du forum.',
	'BOARD_HIDE_EMAILS'				=> 'Masquer les adresses de courrier électronique ',
	'BOARD_HIDE_EMAILS_EXPLAIN'		=> 'Masque les adresses de courrier électronique afin qu’elles soient entièrement confidentielles.',
	'CONTACT_EMAIL'					=> 'Adresse de courrier électronique de contact ',
	'CONTACT_EMAIL_EXPLAIN'			=> 'Cette adresse sera utilisée lorsqu’un contact particulier est nécessaire, comme en cas de pourriel, d’erreur survenue, etc. Elle sera toujours utilisée comme l’adresse du destinataire et du chemin de l’envoi dans les courriels.',
	'EMAIL_FUNCTION_NAME'			=> 'Nom de la fonction de la messagerie électronique ',
	'EMAIL_FUNCTION_NAME_EXPLAIN'	=> 'Correspond à la fonction PHP de la messagerie électronique qui est utilisée afin d’envoyer des courriels.',
	'EMAIL_PACKAGE_SIZE'			=> 'Nombre de courriels envoyés en une seule fois ',
	'EMAIL_PACKAGE_SIZE_EXPLAIN'	=> 'Correspond au nombre de courriels envoyés en une seule fois. Ce réglage est appliqué à la file d’attente de la messagerie électronique interne. Si vous rencontrez des problèmes lors de l’envoi de courriels alors que cette option est activée, il est conseillé de régler cette valeur sur 0.',
	'EMAIL_SIG'						=> 'Signature des courriels ',
	'EMAIL_SIG_EXPLAIN'				=> 'Ce texte sera inséré en bas de tous les courriels envoyés à partir du forum.',
	'ENABLE_EMAIL'					=> 'Autoriser l’envoi de courriels par l’intermédiaire du forum ',
	'ENABLE_EMAIL_EXPLAIN'			=> 'Si ce réglage est désactivé, aucun courriel ne pourra être envoyé à partir du forum. <em>Notez que ce réglage doit être activé afin que l’activation par l’utilisateur ou par l’administrateur soit fonctionnelle. Si vous utilisez actuellement l’activation « par l’utilisateur » ou « par l’administrateur » et que vous n’activez pas ce réglage, aucune activation ne sera nécessaire afin que les nouveaux comptes soient opérationnels.</em>',
	'SMTP_AUTH_METHOD'				=> 'Méthode d’authentification SMTP ',
	'SMTP_AUTH_METHOD_EXPLAIN'		=> 'N’est utilisé que si un nom d’utilisateur et un mot de passe ont été renseignés. Veuillez demander cette information à votre hébergeur si vous n’êtes pas certain de la méthode à utiliser.',
	'SMTP_CRAM_MD5'					=> 'CRAM-MD5',
	'SMTP_DIGEST_MD5'				=> 'DIGEST-MD5',
	'SMTP_LOGIN'					=> 'LOGIN',
	'SMTP_PASSWORD'					=> 'Mot de passe SMTP ',
	'SMTP_PASSWORD_EXPLAIN'			=> 'Ne saisissez un mot de passe que si votre serveur SMTP le demande.<br /><em><strong>Attention :</strong> ce mot de passe sera stocké en texte brut dans la base de données et sera visible à tous ceux qui peuvent accéder à votre base de données ou qui peuvent consulter cette page de configuration.</em>',
	'SMTP_PLAIN'					=> 'PLAIN',
	'SMTP_POP_BEFORE_SMTP'			=> 'POP-BEFORE-SMTP',
	'SMTP_PORT'						=> 'Port du serveur SMTP',
	'SMTP_PORT_EXPLAIN'				=> 'Ne modifiez cela que si vous savez que votre serveur SMTP utilise un port différent.',
	'SMTP_SERVER'					=> 'Adresse du serveur SMTP ',
	'SMTP_SETTINGS'					=> 'Réglages SMTP',
	'SMTP_USERNAME'					=> 'Nom d’utilisateur SMTP ',
	'SMTP_USERNAME_EXPLAIN'			=> 'Ne saisissez un nom d’utilisateur que si votre serveur SMTP le demande.',
	'USE_SMTP'						=> 'Utiliser un serveur SMTP pour l’envoi de courriels ',
	'USE_SMTP_EXPLAIN'				=> 'Activez cette option si vous souhaitez envoyer les courriels par l’intermédiaire d’un serveur SMTP à la place de la fonction locale.',
));

// Jabber settings
$lang = array_merge($lang, array(
	'ACP_JABBER_SETTINGS_EXPLAIN'	=> 'Vous pouvez activer et contrôler ici l’utilisation de Jabber afin d’envoyer des messages instantanés et des avertissements sur le forum. Jabber est un protocole libre et gratuit. Certains serveurs Jabber incluent des passerelles qui vous permettent de contacter des utilisateurs sur d’autres réseaux, mais tous les serveurs Jabber n’offrent pas cette possibilité. Veuillez vous assurer d’avoir déjà saisi les informations du compte inscrit - phpBB les utilisera comme telles.',

	'JAB_ENABLE'				=> 'Activer Jabber ',
	'JAB_ENABLE_EXPLAIN'		=> 'Active l’utilisation de Jabber concernant l’envoi de messages et d’avertissements.',
	'JAB_GTALK_NOTE'			=> 'Veuillez noter que GTalk ne fonctionnera pas car la fonction <samp>dns_get_record</samp> est introuvable. Cette fonction n’est ni implémentée dans PHP4, ni sur les plates-formes Windows et ni sur les systèmes basés sous BSD, en incluant Mac OS.',
	'JAB_PACKAGE_SIZE'			=> 'Nombre de messages envoyés en une fois ',
	'JAB_PACKAGE_SIZE_EXPLAIN'	=> 'Correspond au nombre de messages envoyés en une seule fois. Si cette valeur est réglée sur 0, les messages seront envoyés immédiatement et ne seront pas placés en file d’attente.',
	'JAB_PASSWORD'				=> 'Mot de passe Jabber ',
	'JAB_PASSWORD_EXPLAIN'		=> '<em><strong>Attention :</strong> ce mot de passe sera archivé en texte brut dans la base de données et sera visible à tous ceux qui peuvent accéder à votre base de données et qui peuvent consulter cette page de configuration.</em>',
	'JAB_PORT'					=> 'Port de Jabber ',
	'JAB_PORT_EXPLAIN'			=> 'Laissez vide sauf si vous savez que le port utilisé n’est pas le 5222.',
	'JAB_SERVER'				=> 'Serveur Jabber ',
	'JAB_SERVER_EXPLAIN'		=> 'Rendez-vous sur %sjabber.org%s afin de consulter la liste des serveurs.',
	'JAB_SETTINGS_CHANGED'		=> 'Les réglages de Jabber ont été modifiés avec succès.',
	'JAB_USE_SSL'				=> 'Utiliser une connexion SSL ',
	'JAB_USE_SSL_EXPLAIN'		=> 'Si cette option est activée, une connexion sécurisée essaiera d’être établie. Le port de Jabber sera modifié en 5223 si le port 5222 est spécifié.',
	'JAB_USERNAME'				=> 'Nom d’utilisateur Jabber ou JID ',
	'JAB_USERNAME_EXPLAIN'		=> 'Spécifiez un nom d’utilisateur inscrit ou un JID valide. La validité de ce nom d’utilisateur ne sera cependant pas vérifiée. Si vous ne spécifiez qu’un nom d’utilisateur, votre JID correspondra à votre nom d’utilisateur et au serveur spécifié ci-dessous. Dans le cas contraire, veuillez spécifier un JID valide, tel que utilisateur@jabber.org.',
));

?>