<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
"IRC_INTRO"				=> "Configure phpMyBitTorrent's built-in IRC Chat.",
"IRC_INTRO_EXP"				=> "You may configure every aspect of the PJIRC client: please read PJIRC's documentation before editing advanced parameters.<br />
<b>NOTICE</b>: file <i>include/irc.ini</i> MUST be writable",
"IRC_SERVER"				=> "Server",
"IRC_CHANNEL"				=> "Channel",
"IRC_ADV_SETTING"			=> "Advanced Settings",
"IRC_ADV_SETTING_EXP"		=> "Here you can configure PJIRC's advanced settings. According to PJIRC documentation, insert the parameters with the following syntax:<br />
<i>name</i> = </i>value</i>",
"APPLY_SETTINGS"				=> "Apply settings",
"VALUE"					=> "VALUE",
"RESET"					=> "Reset",
"IRC_ENABLE"				=> "Enable IRC",
"IRC_DISABLE"			=> "Disable IRC",
"IRC_WRIET_PROT"			=> "Cannot delete <i>include/irc.ini</i> because it's write-protected. Please delete the file manually. IRC Chat is still enabled!",
"IRC_INVALID_HOST"		=> "Invalid hostname or IP address",
"IRC_INVALID_CHANNEL"		=> "Invalid channel name",
"IRC_INVALID_SYNTAX"	=> "Invalid syntax for advanced parameters",
"IRC_WRIET_PROT_SAVE"			=> "<p>Cannot save <i>include/irc.ini</i> because it's write-protected. Please save the file manually with the following content:</p><p>&nbsp;</p><p class=\"nfo\">%s</p>",
'ERR_ARRAY_MESS'			=> '<li><p>%s</p></li>',
'ERROR'						=>'Error',
'SAVED_SET'					=>'Settings saved!',
));

?>