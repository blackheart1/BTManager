<?php
/**
*
* pm [English]
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
	'AUTHORIZE'						=>	'Authorize',
	'UCP_TORRENTS'					=>	'Torrent Control Panel',
	'UCP_TORRENTS_EXP'				=>	'In this area, you can Manage the torrents you uploaded (except for those with Stealth Mode selected).<br> You can also manage other Users\' Download Requests. By selecting the appropriate Icon, you can view ALL the Requests</br>sent to you by other Users. You\'ll have to decide whether to Accept or Refuse the Download Request.<br> Pay Attention to Upload and Download Amounts of the User. People who download without Sharing are of NO Benefit for</br>the BitTorrent Network. Refusing their Download Request can be an appropriate way to encourage them to Share more.',
	'MY_TORRENTS'					=>	'User Torrent Pannel',
	'MY_GLONAL_AUTH'				=>	'My Global Authorizations',
	'NO_GLOBAL_AUYH'				=>	'There are NO Global Authorizations yet',
	'ALL_USERS_AUTHORIZED'			=>	'All Users have been Authorized',
	'SELECT_USERS_AUTHOEIZED'		=>	'Selected User has been Authorized',
	'OWNER_AUTH_YOU'				=>	'Owner has Authorized you to Download his Files',
	'FREELY_DOWN_USER_TOR'			=>	'You can now Freely Download all the User\'s Files.\nWe Protect your Privacy.',
	'PENDING_AUTH'					=>	'Pending Authorizations',
	'USERS_REQUEST_AUTH'			=>	'The following Users have Requested Download Authorization',
	'NO_TORRENTS'					=>	'There are NO Torrents',
	'NO_UPLOADED_TORRENTS'			=>	'You have NOT Uploaded any Torrents yet',
	'ALWAYS_AUTH'					=>	'Always Authorize',
	'NEVER_AUTH'					=>	'Never Authorize',
	'DONT_AUTH'						=>	'DO NOT Authorize',
	'CANT_VIEW_OTHER_AUTH'			=>	'You can\'t view other Users Torrents Permissions!',
	'DOWNL_AUTH_PANEL'				=>	'Download Authorizations Control Panel',
	'NO_AUTH_TO_MANAGE'				=>	'There are NO Authorizations to Manage',
	'USER_AUTH_SETT_EXP'			=>	'Select this option to require Users to ask for a Download Authorization to Access this Torrent. You will be notified of each new Pending Authorization via E-mail.You will be able to choose to Grant or Deny the Authorization for this Single Torrent or for ALL your Torrents',
	'USER_AUTH_RATO_SET_EXP'		=>	'You can set a Minimum Ratio Value to Auto-Authorize Users. Users with Ratio Above or Equal to this will be able to download without Requesting Authorization.The value of the Minimum Ratio will NOT be displayed, except to Administrators',
	'AUTH_MINEATIO'					=>	'Minimum Ratio',
	'DISABLE'						=>	'Disabled',
	'PRIVATE'						=>	'Private',
	'GEN_OPTION'					=>	'General Options',
	'CANCEL_MOD'					=>	'Cancel Modifications',
	'PRIVAZY_UPDATED'				=>	'Your Privacy Settings Updated',
	'ERROR_ENTERING_DATA'			=>	'Error while entering Data',
	'MY_TORRENTS'					=>	'My Torrents',
	'AUTH_EMAIL_SUB'				=>	'Download Authorization at %1$s"',
));
?>