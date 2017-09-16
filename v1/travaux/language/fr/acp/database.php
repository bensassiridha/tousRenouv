<?php
/**
*
* acp_database [French]
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

// Database Backup/Restore
$lang = array_merge($lang, array(
	'ACP_BACKUP_EXPLAIN'	=> 'Vous pouvez sauvegarder ici toutes les données relatives à votre forum. Vous pouvez stocker l’archive de sauvegarde dans votre répertoire <samp>store/</samp> ou la télécharger directement. Selon la configuration de votre serveur, vous pourrez compresser cette archive dans un certain nombre de formats.',
	'ACP_RESTORE_EXPLAIN'	=> 'Cela exécutera une restauration complète de toutes les tables de phpBB à partir d’un fichier de sauvegarde. Si cette fonctionnalité est compatible avec votre serveur, vous pouvez utiliser un fichier texte compressé en GZip ou BZip2 qui sera automatiquement décompressé. <strong>ATTENTION :</strong> cela écrasera toutes les données existantes. La restauration est un processus qui peut durer un certain temps, veillez à rester sur cette page tant que l’opération n’est pas terminée. Les sauvegardes sont stockées dans le répertoire <samp>store/</samp> et sont supposées être réalisées par l’intermédiaire de l’outil de restauration qui est intégré à phpBB. Il est possible que la restauration des bases de données qui n’ont pas été sauvegardées avec cet outil ne fonctionnent pas.',

	'BACKUP_DELETE'		=> 'Le fichier de sauvegarde a été supprimé avec succès.',
	'BACKUP_INVALID'	=> 'Le fichier de sauvegarde que vous avez sélectionné n’est pas valide.',
	'BACKUP_OPTIONS'	=> 'Options de sauvegarde',
	'BACKUP_SUCCESS'	=> 'Le fichier de sauvegarde a été créé avec succès.',
	'BACKUP_TYPE'		=> 'Type de sauvegarde ',

	'DATABASE'			=> 'Utilitaires de la base de données',
	'DATA_ONLY'			=> 'Uniquement les données',
	'DELETE_BACKUP'		=> 'Supprimer la sauvegarde',
	'DELETE_SELECTED_BACKUP'	=> 'Êtes-vous sûr de vouloir supprimer la sauvegarde que vous avez sélectionnée ?',
	'DESELECT_ALL'		=> 'Tout désélectionner',
	'DOWNLOAD_BACKUP'	=> 'Télécharger la sauvegarde',

	'FILE_TYPE'			=> 'Type de fichier ',
	'FILE_WRITE_FAIL'	=> 'Impossible d’écrire le fichier dans le répertoire de stockage.',
	'FULL_BACKUP'		=> 'Complète',

	'RESTORE_FAILURE'		=> 'Le fichier de sauvegarde semble corrompu.',
	'RESTORE_OPTIONS'		=> 'Options de restauration',
	'RESTORE_SUCCESS'		=> 'La base de données a été restaurée avec succès.<br /><br />Votre forum devrait être tel qu’il était lors de la dernière sauvegarde.',

	'SELECT_ALL'			=> 'Tout sélectionner',
	'SELECT_FILE'			=> 'Sélectionner un fichier',
	'START_BACKUP'			=> 'Démarrer la sauvegarde',
	'START_RESTORE'			=> 'Démarrer la restauration',
	'STORE_AND_DOWNLOAD'	=> 'Stocker et télécharger',
	'STORE_LOCAL'			=> 'Stocker le fichier localement',
	'STRUCTURE_ONLY'		=> 'Uniquement la structure',

	'TABLE_SELECT'		=> 'Sélectionner la table ',
	'TABLE_SELECT_ERROR'=> 'Vous devez sélectionner au moins une table.',
));

?>