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
*--------------------   Sunday, May 17, 2010 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 image-buket/english.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
'NEW_USER_CREAT'					=> 'Add New User',
'NEW_USER_CREAT_EXP'				=> 'Adding a new user via the Admin CP is the same as some one registering a new account except that the "add form" in the Admin CP is free of the required fields and agreements that are imposed on the registration form. For example, you can create an account without a Valid email address when using the Admin CP.',
'ERROR'							=> 'Error!',
'USER_NAME'						=> 'User Name',
'USER_NAME_EXP'					=> 'Enter the username of the user here. A member\'s username is used when logging in and is displayed next to their posts. ',
'USER_NICK'						=> 'Complete Name',
'USER_NICK_EXP'					=> 'Length must be between 3 and 20 characters.',
'USER_PASS'						=> 'Password (5 Chars Minimum)',
'USER_PASS_EXP'					=> 'Enter the user\'s password here.',
'USER_PASS_CON'					=> 'Confirm Password',
'USER_PASS_CON_EXP'				=> 'Confirm the user\'s password here.',
'USER_EMAIL'						=> 'E-mail Address',
'USER_EMAIL_EXP'					=> 'Enter the email address of the user, this will be used when contact is made with the user by the system or other user\'s If allowed.',
'USER_UPLOAD'						=> 'Uploaded',
'USER_UPLOAD_EXP'					=> '',
'USER_DOWNLOAD'					=> 'Downloaded',
'USER_DOWNLOAD_EXP'				=> '',
'USER_SEED'						=> 'Seeding Bonus',
'USER_SEED_EXP'					=> '',
'USER_INVITES'					=> 'Invites',
'USER_INVITES_EXP'				=> '',
'USER_ACTIVE'					=> 'Active',
'USER_ACTIVE_EXP'				=> 'By not setting the user active you well receave a link to provide the new user to use in order for them to activate the account.<br />If they do not activate the account it well be deleted after 24 hours.',
'USER_LEVEL'					=> 'Level',
'USER_LEVEL_EXP'				=> 'Set the Level you would like to have this user in.',
'USER_GROUPS'					=> 'Group',
'USER_GROUPS_EXP'				=> 'Set the group you would like to have this user in.',
'ERR_NO_EMAIL'					=> 'E-mail Address NOT Specified.',
'ERR_EMAIL_ACSEST'				=> 'The E-mail Address you entered is already Registered.',
'ERR_EMAIL_NOT_VALID'			=> 'The E-mail Address you entered is NOT Valid.',
'ERR_NO_NAME'					=> 'User Name NOT Specified.',
'ERR_USER_ACSEST'				=> 'User name Already Exists.',
'ERR_REGED_NO_ACTIVE'			=> 'User Registered but NOT Active!!',
'ERR_NO_PASS'					=> 'No Password set',
'ERR_PASS_NOT_MATCH'			=> 'The Passwords you entered are NOT the same',
'ERR_PASS_TO_SHORT'				=> 'The Password you entered is too Short. Minimum Length is 5.',
'ERR_FORM_NOT_SET'				=> 'Form not submitted due to the fallowing errors.<br />',
'MOD_COMENT'					=> 'Account created By moderator',
'ACTION_LOG'					=> '%1$s created a new account for “%2$s”',
'USER_VREATED'					=> 'The user “%1$s” Was created.<br /> %2$s This action was logged.<br /> You can check there Account and verify the information <a class="altlink" href="user.php?op=profile&amp;id=%3$s">Here</a>',
'ACTIVATE_LINK'					=> 'The user well need to use this link<br /> %1$s <br />to conferm there account they have 24 hours in wich to do so.<br />',
));

?>