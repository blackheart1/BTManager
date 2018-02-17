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
	'ACP_EMAIL_SETTINGS_EXPLAIN'	=> 'This information is used when the board sends e-mails to your users. Please ensure the e-mail address you specify is valid, any bounced or undeliverable messages will likely be sent to that address. If your host does not provide a native (PHP based) e-mail service you can instead send messages directly using SMTP. This requires the address of an appropriate server (ask your provider if necessary). If the server requires authentication (and only if it does) enter the necessary username, password and authentication method.',

	'ADMIN_EMAIL'					=> 'Return e-mail address',
	'ADMIN_EMAIL_EXPLAIN'			=> 'This will be used as the return address on all e-mails, the technical contact e-mail address. It will always be used as the <samp>Return-Path</samp> and <samp>Sender</samp> address in e-mails.',
	'BOARD_EMAIL_FORM'				=> 'Users send e-mail via board',
	'BOARD_EMAIL_FORM_EXPLAIN'		=> 'Instead of showing the users e-mail address users are able to send e-mails via the board.',
	'BOARD_HIDE_EMAILS'				=> 'Hide e-mail addresses',
	'BOARD_HIDE_EMAILS_EXPLAIN'		=> 'This function keeps e-mail addresses completely private.',
	'CONTACT_EMAIL'					=> 'Contact e-mail address',
	'CONTACT_EMAIL_EXPLAIN'			=> 'This address will be used whenever a specific contact point is needed, e.g. spam, error output, etc. It will always be used as the <samp>From</samp> and <samp>Reply-To</samp> address in e-mails.',
	'EMAIL_FUNCTION_NAME'			=> 'E-mail function name',
	'EMAIL_FUNCTION_NAME_EXPLAIN'	=> 'The e-mail function used to send mails through PHP.',
	'EMAIL_PACKAGE_SIZE'			=> 'E-mail package size',
	'EMAIL_PACKAGE_SIZE_EXPLAIN'	=> 'This is the number of maximum e-mails sent out in one package. This setting is applied to the internal message queue; set this value to 0 if you have problems with non-delivered notification e-mails.',
	'EMAIL_SIG'						=> 'E-mail signature',
	'EMAIL_SIG_EXPLAIN'				=> 'This text will be attached to all e-mails the board sends.',
	'ENABLE_EMAIL'					=> 'Enable board-wide e-mails',
	'ENABLE_EMAIL_EXPLAIN'			=> 'If this is set to disabled no e-mails will be sent by the board at all. <em>Note the user and admin account activation settings require this setting to be enabled. If currently using �user� or �admin� activation in the activation settings, disabling this setting will require no activation of new accounts.</em>',
	'SMTP_AUTH_METHOD'				=> 'Authentication method for SMTP',
	'SMTP_AUTH_METHOD_EXPLAIN'		=> 'Only used if a username/password is set, ask your provider if you are unsure which method to use.',
	'SMTP_CRAM_MD5'					=> 'CRAM-MD5',
	'SMTP_NTLM'						=> 'NTLM',
	'SMTP_LOGIN'					=> 'LOGIN',
	'SMTP_PASSWORD'					=> 'SMTP password',
	'SMTP_PASSWORD_EXPLAIN'			=> 'Only enter a password if your SMTP server requires it.<br /><em><strong>Warning:</strong> This password will be stored as plain text in the database, visible to everybody who can access your database or who can view this configuration page.</em>',
	'SMTP_PLAIN'					=> 'PLAIN',
	'SMTP_POP_BEFORE_SMTP'			=> 'POP-BEFORE-SMTP',
	'SMTP_PORT'						=> 'SMTP server port',
	'SMTP_PORT_EXPLAIN'				=> 'Only change this if you know your SMTP server is on a different port.',
	'SMTP_SERVER'					=> 'SMTP server address',
	'SMTP_SETTINGS'					=> 'SMTP settings',
	'SMTP_USERNAME'					=> 'SMTP username',
	'SMTP_USERNAME_EXPLAIN'			=> 'Only enter a username if your SMTP server requires it.',
	'USE_SMTP'						=> 'Use SMTP server for e-mail',
	'USE_SMTP_EXPLAIN'				=> 'Select �Yes� if you want or have to send e-mail via a named server instead of the local mail function.',
	'DISABLED'						=> 'Disabled',
	'ENABLED'						=> 'Enabled',
	'SMTP_SSL_NONE'					=>	'None',
	'SMTP_SSL_SSL'					=>	'SSL',
	'SMTP_SSL_TLS'					=>	'TLS',
	'SMTP_SSL_AUTO'					=>	'Auto',
));
?>