<?php
/**
*
* acp_users [English]
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
 'INTRO'					=> 'User administration',
 'INTRO_EXP'				=> 'Manage registered users by editing their profile, setting their level or banning them.',
 'SORT_USERNAME'			=> 'User Name',
 'SORT_DATE'				=>	'Regester Date',
 'SORT_IP'					=>	'User Ip',
 'SORT_ACTION'				=>	'Last Login',
 'DISPLAY_WARNED'			=>	'Display logins from previous',
 'DELETE_USER'				=>	'Delete User',
 'BAN_USER'					=>	'Ban User Account',
 'SEARCH_USER'				=>	'Search User',
 'SEARCH_IP'				=>	'Search IP',
 'SEARCH_HOST'				=>	'Search Host',
 'SEARCH_EMAIL'				=>	'Search E-mail',
 'SEARCH_DUPIP'				=>	'Search for duplicate IP\'s',
 'MANAGE_USERS'				=>	'Manage Users',
	'ACP_UPDATE'					=> 'Updating',
	'ACP_USERS_FORUM_PERMISSIONS'	=> 'Users forum permissions',
	'ACP_USERS_LOGS'				=> 'User logs',
	'ACP_USERS_PERMISSIONS'			=> 'Users permissions',
	'ACP_USER_ATTACH'				=> 'Attachments',
	'ACP_USER_AVATAR'				=> 'Avatar',
	'ACP_USER_FEEDBACK'				=> 'Feedback',
	'ACP_USER_GROUPS'				=> 'Groups',
	'ACP_USER_MANAGEMENT'			=> 'User management',
	'ACP_USER_OVERVIEW'				=> 'Overview',
	'ACP_USER_PERM'					=> 'Permissions',
	'ACP_USER_PREFS'				=> 'Preferences',
	'ACP_USER_PROFILE'				=> 'Profile',
	'ACP_USER_RANK'					=> 'Rank',
	'ACP_USER_ROLES'				=> 'User roles',
	'ACP_USER_SECURITY'				=> 'User security',
	'ACP_USER_SIG'					=> 'Signature',
	'INACTIVE_USERS'				=> 'Inactive users',
	'ADMIN_SIG_PREVIEW'		=> 'Signature preview',
	'AT_LEAST_ONE_FOUNDER'	=> 'You are not able to change this founder to a normal user. There needs to be at least one founder enabled for this board. If you want to change this users founder status, promote another user to be a founder first.',

	'BAN_ALREADY_ENTERED'	=> 'The ban had been previously entered successfully. The ban list has not been updated.',
	'BAN_SUCCESSFUL'		=> 'Ban entered successfully.',

	'CANNOT_BAN_FOUNDER'			=> 'You are not allowed to ban founder accounts.',
	'CANNOT_BAN_YOURSELF'			=> 'You are not allowed to ban yourself.',
	'CANNOT_DEACTIVATE_BOT'			=> 'You are not allowed to deactivate bot accounts. Please deactivate the bot within the bots page instead.',
	'CANNOT_DEACTIVATE_FOUNDER'		=> 'You are not allowed to deactivate founder accounts.',
	'CANNOT_DEACTIVATE_YOURSELF'	=> 'You are not allowed to deactivate your own account.',
	'CANNOT_FORCE_REACT_BOT'		=> 'You are not allowed to force reactivation on bot accounts. Please reactivate the bot within the bots page instead.',
	'CANNOT_FORCE_REACT_FOUNDER'	=> 'You are not allowed to force reactivation on founder accounts.',
	'CANNOT_FORCE_REACT_YOURSELF'	=> 'You are not allowed to force reactivation of your own account.',
	'CANNOT_REMOVE_ANONYMOUS'		=> 'You are not able to remove the guest user account.',
	'CANNOT_REMOVE_YOURSELF'		=> 'You are not allowed to remove your own user account.',
	'CANNOT_SET_FOUNDER_IGNORED'	=> 'You are not able to promote ignored users to be founders.',
	'CANNOT_SET_FOUNDER_INACTIVE'	=> 'You need to activate users before you promote them to founders, only activated users are able to be promoted.',
	'CONFIRM_EMAIL_EXPLAIN'			=> 'You only need to specify this if you are changing the users e-mail address.',

	'DELETE_POSTS'			=> 'Delete posts',
	'DELETE_USER'			=> 'Delete user',
	'DELETE_USER_EXPLAIN'	=> 'Please note that deleting a user is final, they cannot be recovered.',

	'FORCE_REACTIVATION_SUCCESS'	=> 'Successfully forced reactivation.',
	'FOUNDER'						=> 'Founder',
	'FOUNDER_EXPLAIN'				=> 'Founders have all administrative permissions and can never be banned, deleted or altered by non-founder members.',

	'GROUP_APPROVE'					=> 'Approve member',
	'GROUP_DEFAULT'					=> 'Make group default for member',
	'GROUP_DELETE'					=> 'Remove member from group',
	'GROUP_DEMOTE'					=> 'Demote group leader',
	'GROUP_PROMOTE'					=> 'Promote to group leader',

	'IP_WHOIS_FOR'			=> 'IP whois for %s',

	'LAST_ACTIVE'			=> 'Last active',

	'MOVE_POSTS_EXPLAIN'	=> 'Please select the forum to which you wish to move all the posts this user has made.',

	'NO_SPECIAL_RANK'		=> 'No special rank assigned',
	'NOT_MANAGE_FOUNDER'	=> 'You tried to manage a user with founder status. Only founders are allowed to manage other founders.',

	'QUICK_TOOLS'			=> 'Quick tools',

	'REGISTERED'			=> 'Registered',
	'REGISTERED_IP'			=> 'Registered from IP',
	'RETAIN_POSTS'			=> 'Retain posts',

	'SELECT_FORM'			=> 'Select form',
	'SELECT_USER'			=> 'Select user',

	'USER_ADMIN'					=> 'User administration',
	'USER_ADMIN_ACTIVATE'			=> 'Activate account',
	'USER_ADMIN_ACTIVATED'			=> 'User activated successfully.',
	'USER_ADMIN_AVATAR_REMOVED'		=> 'Successfully removed avatar from user account.',
	'USER_ADMIN_BAN_EMAIL'			=> 'Ban by e-mail',
	'USER_ADMIN_BAN_EMAIL_REASON'	=> 'E-mail address banned via user management',
	'USER_ADMIN_BAN_IP'				=> 'Ban by IP',
	'USER_ADMIN_BAN_IP_REASON'		=> 'IP banned via user management',
	'USER_ADMIN_BAN_NAME_REASON'	=> 'Username banned via user management',
	'USER_ADMIN_BAN_USER'			=> 'Ban by username',
	'USER_ADMIN_DEACTIVATE'			=> 'Deactivate account',
	'USER_ADMIN_DEACTIVED'			=> 'User deactivated successfully.',
	'USER_ADMIN_DEL_ATTACH'			=> 'Delete all attachments',
	'USER_ADMIN_DEL_AVATAR'			=> 'Delete avatar',
	'USER_ADMIN_DEL_POSTS'			=> 'Delete all posts',
	'USER_ADMIN_DEL_SIG'			=> 'Delete signature',
	'USER_ADMIN_EXPLAIN'			=> 'Here you can change your users information and certain specific options.',
	'USER_ADMIN_FORCE'				=> 'Force reactivation',
	'USER_ADMIN_MOVE_POSTS'			=> 'Move all posts',
	'USER_ADMIN_SIG_REMOVED'		=> 'Successfully removed signature from user account.',
	'USER_ATTACHMENTS_REMOVED'		=> 'Successfully removed all attachments made by this user.',
	'USER_AVATAR_UPDATED'			=> 'Successfully updated user avatars details.',
	'USER_CUSTOM_PROFILE_FIELDS'	=> 'Custom profile fields',
	'USER_DELETED'					=> 'User deleted successfully.',
	'USER_GROUP_ADD'				=> 'Add user to group',
	'USER_GROUP_NORMAL'				=> 'User defined groups user is a member of',
	'USER_GROUP_PENDING'			=> 'Groups user is in pending mode',
	'USER_GROUP_SPECIAL'			=> 'Pre-defined groups user is a member of',
	'USER_NO_ATTACHMENTS'			=> 'There are no attached files to display.',
	'USER_OVERVIEW_UPDATED'			=> 'User details updated.',
	'USER_POSTS_DELETED'			=> 'Successfully removed all posts made by this user.',
	'USER_POSTS_MOVED'				=> 'Successfully moved users posts to target forum.',
	'USER_PREFS_UPDATED'			=> 'User preferences updated.',
	'USER_PROFILE'					=> 'User profile',
	'USER_PROFILE_UPDATED'			=> 'User profile updated.',
	'USER_RANK'						=> 'User rank',
	'USER_RANK_UPDATED'				=> 'User rank updated.',
	'USER_SIG_UPDATED'				=> 'User signature successfully updated.',
	'USER_TOOLS'					=> 'Basic tools',
	'UCP_AIM'					=> 'AOL Instant Messenger',
	'UCP_ATTACHMENTS'			=> 'Attachments',
	'UCP_COPPA_BEFORE'			=> 'Before %s',
	'UCP_COPPA_ON_AFTER'		=> 'On or after %s',
	'UCP_EMAIL_ACTIVATE'		=> 'Please note that you will need to enter a valid e-mail address before your account is activated. You will receive an e-mail at the address you provide that contains an account activation link.',
	'UCP_ICQ'					=> 'ICQ number',
	'UCP_JABBER'				=> 'Jabber address',

	'UCP_MAIN'					=> 'Overview',
	'UCP_MAIN_ATTACHMENTS'		=> 'Manage attachments',
	'UCP_MAIN_BOOKMARKS'		=> 'Manage bookmarks',
	'UCP_MAIN_DRAFTS'			=> 'Manage drafts',
	'UCP_MAIN_FRONT'			=> 'Front page',
	'UCP_MAIN_SUBSCRIBED'		=> 'Manage subscriptions',

	'UCP_MSNM'					=> 'MSN Messenger',
	'UCP_NO_ATTACHMENTS'		=> 'You have posted no files.',

	'UCP_PREFS'					=> 'Board preferences',
	'UCP_PREFS_PERSONAL'		=> 'Edit global settings',
	'UCP_PREFS_POST'			=> 'Edit posting defaults',
	'UCP_PREFS_VIEW'			=> 'Edit display options',

	'UCP_PM'					=> 'Private messages',
	'UCP_PM_COMPOSE'			=> 'Compose message',
	'UCP_PM_DRAFTS'				=> 'Manage PM drafts',
	'UCP_PM_OPTIONS'			=> 'Rules, folders &amp; settings',
	'UCP_PM_POPUP'				=> 'Private messages',
	'UCP_PM_POPUP_TITLE'		=> 'Private message popup',
	'UCP_PM_UNREAD'				=> 'Unread messages',
	'UCP_PM_VIEW'				=> 'View messages',

	'UCP_PROFILE'				=> 'Profile',
	'UCP_PROFILE_AVATAR'		=> 'Edit avatar',
	'UCP_PROFILE_PROFILE_INFO'	=> 'Edit profile',
	'UCP_PROFILE_REG_DETAILS'	=> 'Edit account settings',
	'UCP_PROFILE_SIGNATURE'		=> 'Edit signature',

	'UCP_USERGROUPS'			=> 'Usergroups',
	'UCP_USERGROUPS_MEMBER'		=> 'Edit memberships',
	'UCP_USERGROUPS_MANAGE'		=> 'Manage groups',

	'UCP_REGISTER_DISABLE'			=> 'Creating a new account is currently not possible.',
	'UCP_REMIND'					=> 'Send password',
	'UCP_RESEND'					=> 'Send activation e-mail',
	'UCP_WELCOME'					=> 'Welcome to the User Control Panel. From here you can monitor, view and update your profile, preferences, subscribed forums and topics. You can also send messages to other users (if permitted). Please ensure you read any announcements before continuing.',
	'UCP_YIM'						=> 'Yahoo Messenger',
	'UCP_ZEBRA'						=> 'Friends &amp; Foes',
	'UCP_ZEBRA_FOES'				=> 'Manage foes',
	'UCP_ZEBRA_FRIENDS'				=> 'Manage friends',
	'BIRTHDAY'					=> 'Birthday',
	'BIRTHDAY_EXPLAIN'			=> 'Setting a year will list your age when it is your birthday.',
	'SORT'						=> 'Sort',
	'SORT_COMMENT'				=> 'File comment',
	'SORT_DOWNLOADS'			=> 'Downloads',
	'SORT_EXTENSION'			=> 'Extension',
	'SORT_FILENAME'				=> 'Filename',
	'SORT_POST_TIME'			=> 'Post time',
	'SORT_SIZE'					=> 'File size',
	'SORT_TOPIC_TITLE'			=> 'Topic title',
	'ASCENDING'						=> 'Ascending',
	'DESCENDING'			=> 'Descending',
	'FILENAME'				=> 'Filename',
	'FILESIZE'				=> 'File size',
	'FILENAME'				=> 'Filename',
	'FILESIZE'				=> 'File size',
	'POST_TIME'				=> 'Post time',
	'DOWNLOADS'					=> 'Downloads',
	'POST'					=> 'Post',
 ));

?>