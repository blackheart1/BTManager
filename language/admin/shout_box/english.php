<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
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
	'SHOUT_CONF'	=> 'ShoutBox Configuration',
	'SHOUT_CONF_EXP'	=> 'Here is where You set all your seeting\'s for the site Shoutbox including Refresh rate, Idle time, and Turn it on or off.',
	'_admsaved'	=> 'Settings saved!',
	'BT_SHOUT'	=>'Shout Box',
	'YES_NO'	=> array("yes"=>'Yes', "no"=>'No'),
"BT_SHOUT_ANNOUNCEMENT"		=> "Shout Box Announcement ",
"_admpannounce_ment"		=> "Shout Box Announcement ",
"_admpannounce_mentexplain"		=> "A Text that stays at the top of shout box",
"_admpturn_on"		=> "Turn on Shoutbox ",
"_admpturn_onexplain"		=> "Inable or Disable shoutbox",
"_admpidle_time"			=>	"Idle time",
"_admpidle_timeexplain"		=>	"Set the Idle duration time",
"_admprefresh_time"		=> "Shoutbox refresh rate ",
"_admprefresh_timeexplain"		=> "This is the time shoutbox refreshes",
"_admpbbcode_on"		=> "Allow the use of BBcode in shouts ",
"_admpbbcode_onexplain"		=> "Inable users to use the bbcodes in Ther shouts",
"_admpautodelete_time"		=> "Auto Delete ",
"_admpautodelete_timeexplain"		=> "This is How long you want shouts to Apear",
"_admpcanedit_on"		=> "Can edit Shouts ",
"_admpcanedit_onexplain"		=> "Allow Users to edit there shouts",
"_admpcandelete_on"		=> "Can Delete Shouts ",
"_admpcandelete_onexplain"		=> "Allow Users to delete there shouts",
"_admpshouts_to_show"		=> "Shouts To Show ",
"_admpshouts_to_showexplain"		=> "How Many Shouts You Want To Display",
"_admpallow_url"		=> "Allow Links In Shouts ",
"_admpallow_urlexplain"		=> "Allow Users to Use Links In Shouts",
"_admpshoutnewuser"		=> "Announce New Users ",
"_admpshoutnewuserexplain"		=> "Automaticly Shout A Welcome For New Users",
"_admpshout_new_torrent"		=> "Announce New Torrents ",
"_admpshout_new_torrentexplain"		=> "Automaticly Shout New Uploaded Torrents",
"_admpshout_new_porn"		=> "Announce New Porn Torrents ",
"_admpshout_new_pornexplain"		=> "Automaticly Shout New Uploaded Porn Torrents This Dose Not Over Ride If Announce New Torents Is Off",
));
?>