<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 functions.php  2010-11-04 00:22:48 joeroberts $
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
	'MAIN_TEXT'						=> 'Mass Messages',
	'MAIN_INTRO_EXP'				=> 'With this Tool you well be able to send Multable messages out at the same time By eather Mass PM or Mass E-Mail.',
	'ACP_EMAIL_BODY'				=> "Message received from  ".'%3$s'." on ".'%1$s'."  GMT.\n
	---------------------------------------------------------------------\n\n
	".'%2$s'." \n\n
	---------------------------------------------------------------------\nRegards,\n
	".'%3$s'." Staff\n
	".'%4$s'."\n",
	'SECTION_TITLE_SENPM'			=>'Send A Mass PM',
	'SECTION_TITLE_SENEMAIL'		=>'Send A Mass Email',
	'BLOCK_TITLE'					=>'Mass Messanger',
	'MAY_USE_LINKS'					=> 'You May Use Links In Your E-mails',
	'TX_BODY'						=> 'Body',
	'TX_SUBJ'						=> 'Subject',
	'BTACCESS_LEVEL'				=> 'Access Level',
	'BTACCESS_LEVEL_PM_EXP'			=> 'Users must be in the specified Level to be PMed if you select a user Level here',
	'BTACCESS_LEVEL_EXP'			=> 'Users must be in the specified Level to be eMailed if you select a user Level here',
	'BTACCESS_GROUP'				=> 'Access Group',
	'BTACCESS_GROUP_PM_EXP'			=> 'Users must be in the specified group to be PMed if you select a usergroup here',
	'BTACCESS_GROUP_EXP'			=> 'Users must be in the specified group to be eMailed if you select a usergroup here',
	'MASS_MAIL_EXP'					=> 'Here you can e-mail a message to either all of your users or all users of a specific group having the option to receive mass e-mails enabled. To achieve this an e-mail will be sent out to the administrative e-mail address supplied, with a blind carbon copy sent to all recipients. The default setting is to only include 50 recipients in such an e-mail, for more recipients more e-mails will be sent. If you are emailing a large group of people please be patient after submitting and do not stop the page halfway through. It is normal for a mass emailing to take a long time, you will be notified when the script has completed.',
	'MASS_MAIL'						=> 'Mass Email System',
	'MASS_PM_SYS'					=> 'Mass Private Message System',
	'MASS_PM_SYS_EXP'				=> 'Here you can send Mass Private Message to either all of your users or all users of a specific group',
	'EM_MANGER'						=> 'Email Manager',
	'AC_TEST_EM'					=> 'Test Email Only?',
	'AC_TEST_EM_EXP'				=> 'Will not send any email out',
	'ICON'							=> 'Icon',
	'NO_PM_ICON'					=> 'No PM icon',
	'MESS_SENT'						=>'Message Sent Successfully',
	'MESS_NOT_SENT'					=>'An error has accurd and the message was not sent to one or more users.<br />Please use the back button and try again.',
	'BODY_EXP'						=> 'Please note that you may enter only plain text. All markup will be removed before sending.',
	'LEVEL_ADMIN'					=> 'Admin',
	'LEVEL_MODER'					=> 'Moderator',
	'LEVEL_PREM'					=> 'Premium',
	'LEVEL_USER'					=> 'User',
	'MAIL_BYPAS'					=> 'Bypass mass email Block',
	'MAIL_BYPAS_EXP'				=> 'By Sellecting Yes you well By pass the user\'s wish Not to reseave Mass eMail from this site.<br />This should only be done in urgent situations!',
	'MESSAGE_BODY_EXPLAIN'			=> 'Enter your message here, it may contain no more than <strong>%d</strong> characters.',
	'PREVIEW'						=> 'Preview',
	'MORE_LEVEL'					=> 'Aditional Group\'s <br /> These are Default Level to use',
	'ERR_NO_RECIP'					=> 'You have to specify a Recipient',
	'ERR_NO_SUB'					=> 'You have to specify a Subject',
	'ERR_NO_BODY'					=> 'Empty Message Body',
));

?>