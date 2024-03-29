<?php
/**
*
* acp_language [Português]
*
* @package language
* @version 1.0.0
* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
* @copyright (c) 2005 phpBB Group
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
	'ACP_FILES'						=> 'Administração de idiomas',
	'ACP_LANGUAGE_PACKS_EXPLAIN'	=> 'Aqui pode Instalar e Desinstalar Idiomas no Fórum. O Idioma pré-definido está marcado com um asterisco (*).',

	'EMAIL_FILES'					=> 'Email Templates',

	'FILE_CONTENTS'					=> 'Ficheiros arquivados',
	'FILE_FROM_STORAGE'				=> 'Ficheiros da Pasta de arquivo',

	'HELP_FILES'					=> 'Ficheiros de Ajuda',

	'INSTALLED_LANGUAGE_PACKS'		=> 'Idiomas Instalados',
	'INVALID_LANGUAGE_PACK'			=> 'O idioma selecionado não é válido. Verifique o Pacote e envie-o novamente se necessário.',
	'INVALID_UPLOAD_METHOD'			=> 'O Método selecionado para o envio não é válido. Escolha um método diferente.',

	'LANGUAGE_DETAILS_UPDATED'		=> 'A Configuração dos idiomas foi atualizada com sucesso.',
	'LANGUAGE_ENTRIES'				=> 'Tradução de instruções',
	'LANGUAGE_ENTRIES_EXPLAIN'		=> 'Aqui pode alterar os pacotes de idiomas existentes ou não traduzidos.<br /><strong>Nota:</strong> Depois de efetuar as modificações clique em <b>Enviar e Descarregar Ficheiro</b> O mesmo será colocado na diretoria <b>/store</b>.<br /> Estas alterações só serão visíveis depois de substituir os ficheiros no servidor.',
	'LANGUAGE_FILES'				=> 'Ficheiros dos idiomas',
	'LANGUAGE_KEY'					=> 'Chave de Linguagem',
	'LANGUAGE_PACK_ALREADY_INSTALLED'=> 'O Pacote de idiomas já se encontra instalado.',
	'LANGUAGE_PACK_DELETED'			=> 'O Pacote de idiomas <strong>%s</strong> foi apagado com sucesso. O idiomas Oficial do Fórum foi atualizado para todos os Membros que estão a usá-lo.',
	'LANGUAGE_PACK_DETAILS'			=> 'Detalhes do Pacote de idiomas',
	'LANGUAGE_PACK_INSTALLED'		=> 'O Pacote de idiomas <strong>%s</strong> foi instalado com sucesso.',
	'LANGUAGE_PACK_ISO'				=> 'ISO',
	'LANGUAGE_PACK_LOCALNAME'		=> 'Nome do Local',
	'LANGUAGE_PACK_NAME'			=> 'Nome',
	'LANGUAGE_PACK_NOT_EXIST'		=> 'O Pacote de idiomas selecionado não existe.',
	'LANGUAGE_PACK_USED_BY'			=> 'Utilizado por (incluindo robots)',
	'LANGUAGE_VARIABLE'				=> 'Variável de linguagem',
	'LANG_AUTHOR'					=> 'Autor do Pacote de idioma',
	'LANG_ENGLISH_NAME'				=> 'Nome Inglês',
	'LANG_ISO_CODE'					=> 'Código ISO',
	'LANG_LOCAL_NAME'				=> 'Nome do Local',

	'MISSING_LANGUAGE_FILE'			=> 'Ficheiro de Linguagem ausente: <strong style="color:red">%s</strong>',
	'MISSING_LANG_VARIABLES'		=> 'Variáveis de Linguagem ausentes',
	'MODS_FILES'					=> 'Ficheiros de Linguagem de MODs',

	'NO_FILE_SELECTED'				=> 'Não foi selecionado o Ficheiro de Linguagem.',
	'NO_LANG_ID'					=> 'Não foi selecionado um pacote de idioma.',
	'NO_REMOVE_DEFAULT_LANG'		=> 'Não pode excluir o pacote de idioma Oficial<br />Se deseja excluir este pacote, altere o idioma Oficial do Fórum.',
	'NO_UNINSTALLED_LANGUAGE_PACKS'	=> 'Sem Pacotes de idiomas desinstalados',

	'REMOVE_FROM_STORAGE_FOLDER'	=> 'Excluir da Pasta de arquivo',

	'SELECT_DOWNLOAD_FORMAT'		=> 'Selecionar método de Transferência',
	'SUBMIT_AND_DOWNLOAD'			=> 'Enviar e Descarregar Ficheiro',
	'SUBMIT_AND_UPLOAD'				=> 'Enviar e fazer Upload do Ficheiro',

	'THOSE_MISSING_LANG_FILES'		=> 'Os Ficheiros seguintes estão ausentes da pasta %s de idiomas',
	'THOSE_MISSING_LANG_VARIABLES'	=> 'As variáveis seguintes estão ausentes do <strong>%s</strong> pacote de idiomas',

	'UNINSTALLED_LANGUAGE_PACKS'	=> 'Pacote de idiomas desinstalados',

	'UNABLE_TO_WRITE_FILE'			=> 'O Ficheiro não pôde ser escrito para %s.',
	'UPLOAD_COMPLETED'				=> 'O Envio foi realizado com sucesso.',
	'UPLOAD_FAILED'					=> 'O Envio falhou por razões desconhecidas. Deve substituir o Ficheiro manualmente.',
	'UPLOAD_METHOD'					=> 'Enviar Método',
	'UPLOAD_SETTINGS'				=> 'Enviar Configurações',

	'WRONG_LANGUAGE_FILE'			=> 'O Ficheiro selecionado é inválido.',
));

?>