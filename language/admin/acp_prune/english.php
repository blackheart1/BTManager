<?php
/**
*
* prune [English]
*
* @package language
* @version $Id$
* @copyright (c) 2010 phpMyBitTorrent Group
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
	'TITLE'									=> 'Automated Pruning System',
	'TITLE_EXP'								=> '',
	'SETTING_SAVED'							=> 'Settings Have been saved to the date base',
	'USERPRUNE_HEADER'						=> 'User Prune Settings',
	'_admpautodel_users'					=> 'Turn on User Prune System',
	'_admpautodel_usersexplain'				=> 'Inable or Disable User Prune System',
	'_admpinactwarning_time'				=> 'Time before Email Warning In days',
	'_admpinactwarning_timeexplain'			=> 'How Long To allow a user to be inactive Before a notice is sent to them and account set inactive',
	'_admpautodel_users_time'				=> 'Time before delete In days',
	'_admpautodel_users_timeexplain'		=> 'How long after account is set Inactive To Prune it(Delete it)<br> This dose not include Parked or Banned accounts',
));

?>