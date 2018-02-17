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
		'_admbonsetting'					=> "Bonus Settings",
		'_admsettingexplain'				=> 'Set you Bonus System up to how you would like to handle things such as upload bonus, seeding bonus, and More.',
		'_admbonalo'						=> "Allow Bonus",
		'_admpactive'						=> "Bonus On/Off",
		'_admpactiveexplain'				=> "This well Turn on Or Off Bonus System.",
		'_admpupload'						=> "Upload Bonus",
		'_admpuploadexplain'				=> "This is the amount a user well get<br />for Uploading a torrent.",
		'_admpcommentexplain'				=> "This is the amount a user well get<br />for making a torrent comment.",
		'_admpcomment'						=> "Comment Bonus",
		'_admpofferexplain'					=> "This is the amount a user well get<br />for making a torrent Offer.",
		'_admpoffer'						=> "Offer Bonus",
		'_admpseedingexplain'				=> "This is the amount a user well get<br />for Seeding a torrent.<br />This setting works with Auto Clean Timer in settings",
		'_admpseeding'						=> "Seeding Bonus",
		'_admbonseedtor'					=> "Give Bonus for Each Torrent",
		'_admpby_torrentexplain'			=> "If active Users well get a bonus for each torrent that they are seeding<br />If not they well only get a single bonus no matter how many torrents they seed",
		'_admpby_torrent'					=> "Bonus For Each/All Torrents",
		'_admbonreq'						=> "Request Fill",
		'_admpfill_requestexplain'			=> "This is the amount a user well get<br />for Uploading a Torrent That was requested. This is ontop of the Uploading Bonus",
		'_admpfill_request'					=> "Filling Request Bonus",
		'_admbonbongo'						=> "Edit Bonus!",
		'SUBMIT'							=> 'Submit',
		'TRADE_FOR'							=> 'Trade For',
		'POINTS'							=> 'Points Needed',
		'DESC'								=> 'Description',
		'SUCCESS'							=> 'Success!',
		'SETTING_SAVED'						=> 'Settings have been saved to the data base',
		'CONFIRM_OPERATION_DEL'				=> 'Are you suren you wish to remove this Bonus Option.',
		'ERROR'								=> 'Error!',
		'NO_ID'								=> 'A error has accurd and no ID was set',
		'BONUS_REMOVED'						=> 'Bonus Option has been removed from the data base.',
		'BONUS_NAME'						=> 'Bonus Points Name',
		'BONUS_POINTS'						=> 'How many points are needed',
		'BONUS_DESC'						=> 'Trade points Explain',
		'BONUS_ART'							=> 'What are they getting',
		'BONUS_MENGE'						=> 'The system value',
		'BONUS_NAME_EXP'					=> 'Give a Descriptive name for what the user is getting for there points.<br />1GB upload, 1.5GB\'s upload, 1 invite',
		'BONUS_POINTS_EXP'					=> 'Let the user know How many points it well take to get this Bonus',
		'BONUS_DESC_EXP'					=> 'Explane in detail what well happen when Exchanged',
		'BONUS_ART_EXP'						=> 'Let the system know for order of display what it is for (traffic/invite)',
		'BONUS_MENGE_EXP'					=> 'let the system know how many to give out in newmeric 1, 10, 100',
		'ADD_TITLE'							=> 'Add New Bonus',
		'ADD_EXPLANE'						=> 'You can add a new bonus to the system at any time from here<br />Make sure you fill in all the fealds!',
		'EDIT_TITLE'						=> 'Edit You bonus',
		'EDIT_EXPLANE'						=> 'You can change the Bonus to how you would like for it to be.',
		'NO_NAME'							=> 'No Name has been set',
		'NO_PONTS'							=> 'No Points have been set',
		'NO_DESC'							=> 'No Description has been given',
		'NO_SYS_VAL'						=> 'No system requird Value is set',
		'NOT_VALID_BONUS'					=> 'There seems to Be No bonus in the system with this ID!',
		'BONUS_UPDATED'						=> 'Values for this Bonus have been updated',
		'BONUS_ADDED'						=> 'New Bonus was successfully added to the data base',
));
?>