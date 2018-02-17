<?php
/**
*
* ucp [English]
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
	'TITLE'									=> 'Automated Hit and Run System',
	'TITLE_EXP'								=> 'A Hit and Run user is some one that well down load a file and as soon as it is completely down loaded close there torrent client with out Seeding back so that others may get the Help from them so they may complete the file.<br />With this system you can monitor your users to make sure that this dose not happen and take actions for those that do.',
	'HNR_HEADER'							=> 'Hit and Run setting\'s',
	'SETTING_SAVED'							=> 'Settings Have been saved to the date base',
	'_admphnr_system'						=> 'Turn on Hit And Run System',
	'_admphnr_systemexplain'				=> 'Inable or Disable Hit And Run System',
	'_admpseedtime'							=> 'Seed Time',
	'_admpseedtimeexplain'					=> 'The Set Time In Minutes how long A Member Must Seed a Torrent',
	'_admptime_before_warn'					=> 'Time allowed Between announce',
	'_admptime_before_warnexplain'			=> 'How Long After First Missed Announce to Give a Member Before First Warning PM(Set Time In Minutes)',
	'_admpmaxhitrun'						=> 'Max Number OF Hit And Runs',
	'_admpmaxhitrunexplain'					=> 'Max Hit And Runs Before a Member gets a Site Warning',
	'_admpwarnlength'						=> 'How long of a warning for Hit and run',
	'_admpwarnlengthexplain'				=> 'How Long should warning be for Hit And Run(Time Set In Day\'s)',
	'_admpban_hnr_users'					=> 'Ban User for Hit and Run',
	'_admpban_hnr_usersexplain'				=> 'Ban User for Hit and Run',
	'_admpdemote_hnr_users'					=> 'Demote User for Hit and Run',
	'_admpdemote_hnr_usersexplain'			=> 'Demote User for Hit and Run',
	'_admpafter_high_hnr'					=> 'Demote After Max Number OF Hit And Runs',
	'_admpafter_high_hnrexplain'			=> 'Demote After Max Number OF Hit And Runs',
	'_admpdemote_hnr_users_to'				=> 'Demote User to',
	'_admpdemote_hnr_users_toexplain'		=> 'Demote User to',
	'_admpban_time'							=> 'How long to Demote for Hit and run',
	'_admpban_timeexplain'					=> 'How Long should Demotion be for Hit And Run(Time Set In Day\'s)',
	'ERR_ON'								=> 'Invalid entery for "<b>Turn on Hit And Run System</b>"  ( %s )',
	'ERR_DEMOTE'							=> 'Invalid entery for "<b>Demote User for Hit and Run</b>"  ( %s )',
	'ERR_DEMOTE_TIME'						=> 'Invalid entery for "<b>How long to Demote for Hit and run</b>" ( %s ) is Not numeric',
	'ERR_DEMOTE_LEVEL'						=> 'Invalid entery for "<b>Demote User to</b>" ( %s ) is Not a Valid Group',
	'ERR_SEED_TIME'							=> 'Invalid entery for "<b>Seed Time</b>" ( %s ) is Not numeric',
	'ERR_TIME_PREWARN'						=> 'Invalid entery for "<b>Time allowed Between announce</b>" ( %s ) is Not numeric',
	'ERR_MAX_HITS'							=> 'Invalid entery for "<b>Max Number OF Hit And Runs</b>" ( %s ) is Not numeric',
	'ERR_WARN_LEN'							=> 'Invalid entery for "<b>How long of a warning for Hit and run</b>" ( %s ) is Not numeric',
	'ERR_AFTER_HIGH'						=> 'Invalid entery for "<b>Demote After Max Number OF Hit</b>" ( %s ) is Not numeric',
	'ERR_BAN_HNR'							=> 'Invalid entery for "<b>Ban User for Hit and Run</b>"  ( %s )',
'ERR_ARRAY_MESS'			=> '<li>%s</li>',
'SETTINGS_NOT_SAVED'					=> 'Hit And Run settings not saved',
));

?>