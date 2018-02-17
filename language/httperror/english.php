<?php
/**
*
* details [English]
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
		"A_ERROR_TTL"				=>	"HTTP 400 Error - Bad Request",
		'A_ERROR_EXP'				=>	'A 400 Error Occurred while processing your Request.<br /> Please check your Browser Settings and try again Accessing the Requested Page.<br /> Contact %1$s if you\'re having problems.',
		"B_ERROR_TTL"				=>	"HTTP 401 Error - Access Denied",
		'B_ERROR_EXP'				=>	'A 401 HTTP Error occurred while processing your Request.<br> You can\'t Access the Requested Page because you are NOT Authorized.<br> Please provide your Access Credentials, if you have any.<br> Contact %1$s if you\'re having problems.',
		"C_ERROR_TTL"				=>	"HTTP 403 Error - Access Denied",
		'C_ERROR_EXP'				=>	'A 403 HTTP Error Occurred while processing your Request.<br> You can\'t Access the Requested Page because the Server Configuration doesn\'t allow you to.<br> Please check carefully the URL Address on your Browser, and correct it if needed.<br> Contact %1$s if you\'re having problems.',
		"D_ERROR_TTL"				=>	"HTTP 404 Error - Access Denied",
		'D_ERROR_EXP'				=>	'A 404 HTTP Error Occurred while processing your Request.<br> The Requested Page Does Not Exist.<br> Please check the URL in your Browser carefully, and correct it if needed.<br> Contact %1$s if you\'re having problems.',
		"E_ERROR_TTL"				=>	"HTTP 500 Error - Access Denied",
		'E_ERROR_EXP'				=>	'A 500 HTTP Error Occurred while processing your Request.<br> An error Occurred while processing Your Data.<br> Detailed info can be found in the Server Logs.<br> Please send a detailed report about this to %1$s',
));
?>