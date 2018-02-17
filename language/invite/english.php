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
*--------------------   Sunday, Feb 18, 2010 1:05 AM   ------------------------*
*/
/**
*
* invite [English]
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
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'INVITE'						=>	'Invite',
	'INVITE_HEADER'					=>	'Invite System',
	'INVITES_DISSABLED'				=>	'Invites Disabled',
	'INVITES_DISSABLED_EXP'			=>	'Our Invites are Disabled Please have your Friend Use the Registration Link',
	'INVITE_EXP'					=>	'Welcome To our Invite system<br />Here You can send out a invite to your friends or even family members.',
	'INVITES'						=>	'Invites',
	'INV_MAIL_SUB'					=>	'Your Invite To %1$s',
	'WELCOME'						=>	'Welcome to %1$s!<br />Please fill in the info below to finnish the Invite that was sent to you',
	'USER_NAME'						=>	'User Name',
	'PASSWORD_EXP'					=>	'(5 Chars Minimum)',
	'TERMS_CONDITION'				=>	'Terms and Conditions',
	'EMAIL_ADD'						=>	'Add Email Address',
	'EMAIL_ADD_EXP'					=>	'Please enter a Valid email address for this invite to be sent to.',
	'ADD_MESSAGE'					=>	'Add a Message',
	'ADD_MESSAGE_EXP'				=>	'Enter a message to the person your sending this invite to so that they know who sent it.',
	'SUBMIT_ONES'					=>	'Send Invite (PRESS ONLY ONCE)',
	'LIMMIT_REACHED'				=>	'Site User Limmit Reached',
	'MAX_USERS_REACHED'				=>	'The current user account limit (<strong>%s</strong>) has been reached. Inactive accounts are pruned all the time, please check back again later...',
	'NO_INVITES'					=>	'NO Invites',
	'NO_INVITES_EXP'				=>	'You do not have any invites to use at this time.<br />If you feel you reached this error By mistake please contact a modderator.',
	'INVALID_ID_EXP'				=>	'There seems to be a problem with the ID provided it is invalid',
	'DUPE_IP'						=>	'Duplicate Ip In use',
	'DUPE_IP_EXP'					=>	'The Ip your using is already in our system We do not allow users to have more then one account',
	'ACCOUNT_ACTIVE'				=>	'This Account is Activayed',
	'ACCOUNT_ACTIVE_EXP'			=>	'This Account was already Activated and no further action is needed.<br />Please login.',
	'INVALID_INVITE'				=>	'The Invite is invalid',
	'INVALID_INVITE_RXP'			=>	'This Invite is not In our data base.<br />You may have taken to long to use it or the id number is wrong.',
	'INVALID_ACTKEY'				=>	'Invalid Activation Key',
	'INVALID_ACTKEY_EXP'			=>	'There seems to be a problem prossessing the Activation Key you provided Please check the link',
	'USE_LIM_REACHED'				=>	'Not Tsking New Users',
	'USE_LIM_REACHED_EXP'			=>	'The Current User Account Limit (%1$s) has been reached. Inactive Accounts are Pruned all the time, please check back again later...',
	'NO_MESSAGE'					=>	'No Message',
	'NO_MESSAGE_EXP'				=>	'You did not add a message for the user to know Who was sending it.',
	'BAD_EMAIL'						=>	'The E-mail is Bad',
	'BAD_EMAIL_EXP'					=>	'There seems to be a problem with the e-mail you are sending this to',
	'EMAIL_USED'					=>	'The E-mail is in use',
	'EMAIL_USED_EXP'				=>	'The E-mail You are sending this to is already in use Please select another E-mail Address',
	'ACTIVATION_COMPLETE'			=>	'Activation Complete. Your Account is now Permanently Active. From now on, you can Access our services using the User name and Password you provided. Have a nice download.',
	'USER_LINNET_REACHED'			=>	'Sorry, user limit reached. Please try again later.',
	'USERNAME_NOT_SET'				=>	'User Name NOT Specified.',
	'BAD_ID'						=>	'There seems to be a problem with the ID please check your link and try again.',
	'USER_IS_ACTIVE'				=>	'User is already Active. No more Activation Required',
	'PASS_DONT_MATCH'				=>	"Passwords don't match",
	'YOU_HAVE_BLANK_FEALDS'			=>	'You did not fill in all fealds please go back and make sure all fealds are filled in .',
	'INVALID_USER_NAME'				=>	'You are trying to use a invalid user name please go back and try a defrent name',
	'DISCL_NOT_ACCP'				=>	'You MUST ACCEPT our Disclaimer in order to Sign Up.',
	'USER_NAME_TO_LONG'				=>	'That User name is to long',
	'PASS_TO_SHORT'					=>	'That PassWorrd is to short',
));
?>