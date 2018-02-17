<?php
/**
*
* avatar [English]
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
'TITLE'					=>	'Lottery Configuration',
'TITLE_EXPLAIN'			=>	'',
'ERR_LOTTERY_OPEN'		=>	'Lottery Enabled',
'ERR_LOTTERY_OPEN_EXP'	=>	'Lottery is currently enabled, so this configuration page is closed.<br /><br />Classes playing in this lottery, are: <br />» %s',
		'TABLE_OPEN'						=> "The Lottery",
		'_admpenable'						=> "Enable The Lottery",
		'_admpenableexplain'				=> "Ones you have Enabled the lottery you well no longer be able to edit it!<br />So make sure it is How you want before doing so.",
		'_admpuse_prize_fund'						=> "Use Prize Fund",
		'_admpuse_prize_fundexplain'				=> "No. Sets the pot to uses default pot of all users",
		'_admpprize_fund'						=> "Prize Fund",
		'_admpprize_fundexplain'				=> "What Size well the pot be when a user wins<br />This is only If you set it to use the Prze fund.",
		'_admpticket_amount'						=> "Ticket Amount",
		'_admpticket_amountexplain'				=> "How much well you charge for a Ticket",
		'_admpticket_amount_type'						=> "Ticket Amount Type",
		'_admpticket_amount_typeexplain'				=> "",
		'_admpuser_tickets'						=> "Amount Of Tickets Allowed",
		'_admpuser_ticketsexplain'				=> "How many tickets is a user allowed to Purchace",
		'_admpclass_allowed'						=> "Access Level",
		'_admpclass_allowedexplain'				=> "Select the Group's you wish to allow to play Lottery.",
		'_admptotal_winners'						=> "Total Winners",
		'_admptotal_winnersexplain'				=> "How many Users well when the lottery.",
		'_admpcurenttime'						=> "Current Date/Time",
		'_admpcurenttimeexplain'				=> "",
		'_admpstart_date'						=> "Start Date",
		'_admpstart_dateexplain'				=> "This well set the start date of the lottery",
		'_admpend_date'						=> "End Date",
		'_admpend_dateexplain'				=> "This is the date the lottery well end",
		'YES_NO_TF'							=> array('1'=> 'Yes','0'=>'No'),
		'YES_NO'							=> array('yes'=> 'Yes','no'=>'No'),
		'GB_MB'								=> array('GB'=> 'GB','MB'=>'MB'),
		'AUTH_UPDATED'						=> 'Settings were successfully change',
));
?>