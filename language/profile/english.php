<?php
/*
*-----------------------------phpMyBitTorrent V 3.0.0--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

// Privacy policy and T&C
$lang = array_merge($lang, array(
	'_NO_ACCESS_TO_PROFILE'		=> 'Your Access Level %1$s Dose not all You to View others Profile',
	'_VIEWING_USER_PROFILE'		=> 'Viewing profile Of: %1$s',
	'ACCOUNTACTIVATESUB'		=>	'Activate your account on %1$s',
	'PERMISSIONS_RESTORED'		=> 'Successfully restored original permissions.',
	'PERMISSIONS_TRANSFERRED'	=> 'Successfully transferred permissions from <strong>%s</strong>, you are now able to browse the board with this user\'s permissions.<br />Please note that admin permissions were not transferred. You are able to revert to your permission set at any time.',
	'POST_DAY'					=> '%.2f posts per day',
	'POST_PCT'					=> '%.2f%% of all posts',
	'USER_POST'					=> '%d Post',
	'USER_POSTS'				=> '%d Posts',
	'LOGIN'						=>	'Login',
	'LOST_PASSWORD'				=>	'Lost your Password?',
	'LOST_PASS_INTRO'			=>	'If you lost your Password, you can regain access to your account by entering your User name and a NEW Password.<br /> A confirmation mail will be sent to the E-mail address associated with your account.<br /> Make sure you can receive mail (i.e. your mailbox is not full) before submitting your Request.<br /> If you don\'t receive that mail, try checking your Spam-Filter.<br /><br /> <strong>(Notice: No changes well be made to your curent PassWord before you use the Comfirmation E-Mail)</strong>',
	'LOST_PASSWORD_SUB'			=> 'Your new Password on %1$s',
	'LOST_PASSWORD_SENT'		=>	'A Message has been sent to your E-mail address containing a Confirmation Link. Please click that Link for the Password Change to take effect.',
	'REMEMBER_ME'				=>	'Remember Me',
	'USER_SNATCH_LIST'			=> 'My Snatch List',
	'LOGIN_EXP'					=> 'The area you are trying to Access is Restricted to <b>Registered Users</b>.<br>Please provide your Access Credentials and try again. If you\'re not Signed Up yet, you can <a href="./user.php?op=register"><< <u>DO SO HERE </u>>></a> for FREE.',
	'BONUS_TRAN_TITTLE'			=>	'Bonus Transfer',
	'BONUS_TRAN_TITTLE_EXP'		=>	'You can transfer your seed bonus points to another member here',
	'HOW_MANY_POINTS_GIVE'		=>	'How many points to give',
	'GIVE_ANONYMUSLY'			=>	'Give Bonus Anonymusly',
	'GIVE_BONUS_TO'				=>	'Who would you like to send this to?',
	'GIVE_BONUS_MESS'			=>	'Send a Message as to Why<br />Leave Blank for No message.',
	'SEND_BONUS'				=>	'Send Bonus',
	'BONUS_TRAN_TO_MUCH'		=>	'You can\'t transfer more points than you have!',
	'BONUS_TO_SELF'				=>	'You can\'t transfer points to yourself!',
	'BONUS_TRANSFERD'			=>	'Job Done Bonus points Successfully sent to %s',
	'BONUS_TRANSFER_PM_SUB'		=>	'Bonus points received',
	'BONUS_TRANSFER_PM'			=>	'%1$s Has Given you %2$s bonus points ' . "\n" . 'Heres a message from them:' . "\n" . '%3$s',
	'WELCOME'					=>	'Welcome! <br />Register an Account to Join Our Community. This will enable you to use the full range of services on this site, and it will only take a few minutes. Choose a User name and a Password, and provide a Valid E-mail Address. Within a few minutes, you\'ll receive an e-mail, asking you to Confirm the Registration.',
	'PASSWORD_EXP'				=>	'(5 Chars Minimum)',
	'TERMS_CONDITION'			=>	'Terms and Conditions',
	'DISCLAIMER_ACCEPT'			=>	'I Accept',
	'DISCLAIMER_DECLINE'		=>	'I DO NOT Accept',
	'ERROR_LIMMET_REACHED'		=>	'Limmet reached',
	'SIGNUP_LIMMET_REACHED'		=>	'The current user account limit (%1$s) has been reached. Inactive accounts are pruned all the time, please check back again later...',
	'SIGNUPS_CLOSED'			=>	'Open sign ups are close The only way you can join this site is by Invite',
	'USER_EMAIL_ADD'			=>	'E-mail Address',
	'PROFILE_UPDATED'								=>	'Your Profile has been Updated',
	'SIGN_UP_ERROR'				=>	'Error during Sign up Process',
	'ERR_USER_ACSEST'				=> 'User name Already Exists.',
'ERR_EMAIL_NOT_VALID'			=> 'The E-mail Address you entered is NOT Valid.',
'ERR_EMAIL_ACSEST'				=> 'The E-mail Address you entered is already Registered. Want to Recover your Password? Go <a href="user.php?op=lostpassword">HERE</a>',
'ERR_PASS_NOT_MATCH'			=> 'The Passwords you entered are NOT the same',
'ERR_PASS_TO_SHORT'				=> 'The Password you entered is too Short. Minimum Length is 5.',
	'DISCL_NOT_ACCP'				=>	'You MUST ACCEPT our Disclaimer in order to Sign Up.',
	'NO_USERNAME_SET'				=>	'User Name NOT Specified.',
	'NO_PASSWORD_SET'				=>	'No User pass word was set.',
	'NO_EMAIL_SET'					=>	'E-mail Address NOT Specified.',
	'REG_SUCCESS'					=>	'Activation Complete. Your Account is now Permanently Active. From now on, you can Access our services using the User name and Password you provided. Have a nice download.',
	'REG_SUCCESS_CONFERM'			=>	'Sign up almost complete. You have 24 hours to Confirm your Registration. If you don\'t receive the
E-mail Confirmation, please check the data you entered. If you\'re having problems, please contact the Webmaster at %1$s',
	'LOGIN_ERROR_NP_WRONG'							=>	'Incorrect User name or Password!!',
	'LOGIN_ERROR_NOT_ACTIVE'						=>	'User Registered but NOT Active!!',
	'NO_EDIT_PREV'									=>	'You DO NOT have Access to Edit this Person',
	'EMAILS_NOT_MATCH'								=>	'The Email address you entered does not match!',
	));
?>