<?php
/**
*
* ajaz/shouts [English]
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
		'SHOUT_COMAND_HELP_USER'			=>	'[quote]As an user, you have the folowing commands:
If you want to view this message in the shout, use the /help command
If you want to slap a user /slapuser user name
If you want to send a quick Private Message /pmuser (user name or id);(message)
If you want to speak at 3rd person, use the /me command.[/quote]',
		'SHOUT_COMAND_HELP_ADMIN'			=>	'[quote]If you want to make an notice - use the /notice command.
	If you want to empty shouts - use the /empty command 
	If you want to warn or unwarn a user - use the /warn (user) and /unwarn (user) commands 
	If you want to ban(disable) or unban(enable) a user - use the /ban (user) and /unban (user) commands 
	To delete all notices from the shout, use /deletenotice command
	If you want to slap a user /slapuser user name
	If you want to send a quick Private Message /pmuser (user name or id);(message)
	If you want to speak at 3rd person, use the /me (message)command.[/quote]',
	'NO_SHOUTS'								=>	'No Shouts at this Time!',
	'SHOUTBOX_ARCHIVE'						=>	'Shoutbox Archive',
	'TOTAL_SHOUTS_POSTED'					=>	'Total shouts posted',
	'SHOUTS_IN_TWFOUR'						=>	'Shouts in past 24 hours',
	'YOUR_SHOUTS'							=>	'Your shouts',
	'TOPFIFTEEN_SHOUTERS'					=>	'Top 15 Shouters',
	'SORT_BY'								=>	'Sort Results By',
	'NEW_FIRST'								=>	'Newest First',
	'OLD_FIRST'								=>	'Oldest First',
	'SEARCH_TIME'							=>	'Within Past <em>X</em> Hours',
	'USERNAME_CONTAINS'						=>	'Username Contains',
	'SEARCH_CONTAINS'						=>	'Shout Contains',
	'SEARCH_TERM'							=>	'Search Terms',
	'SEARCH_SHOUTS'							=>	'Search Shouts',
	
	
));
?>