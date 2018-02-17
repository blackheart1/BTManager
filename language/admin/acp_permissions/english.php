<?php
/**
*
* acp_permissions [English]
*
* @package language
* @version $Id: permissions.php,v 1.6 2009/09/17 14:09:33 joerobe Exp $
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

$lang = array_merge($lang, array(
	'ACP_PERMISSIONS_EXPLAIN'	=> '
		<p>Permissions are highly granular and grouped into four major sections, which are:</p>

		<h2>Global Permissions</h2>
		<p>These are used to control access on a global level and apply to the entire bulletin board. They are further divided into Users\' Permissions, Groups\' Permissions, Administrators and Global Moderators.</p>

		<h2>Forum Based Permissions</h2>
		<p>These are used to control access on a per forum basis. They are further divided into Forum Permissions, Forum Moderators, Users\' Forum Permissions and Groups\' Forum Permissions.</p>

		<h2>Permission Roles</h2>
		<p>These are used to create different sets of permissions for the different permission types later being able to be assigned on a role-based basis. The default roles should cover the administration of bulletin boards large and small, though within each of the four divisions, you can add/edit/delete roles as you see fit.</p>

		<h2>Permission Masks</h2>
		<p>These are used to view the effective permissions assigned to Users, Moderators (Local and Global), Administrators or Forums.</p>

		<br />

		<p>For further information on setting up and managing permissions on your phpBB3 board, please see <a href="http://www.phpbb.com/support/documentation/3.0/quickstart/quick_permissions.html">Chapter 1.5 of our Quick Start Guide</a>.</p>
	',

	'ACL_NEVER'				=> 'Never',
	'ACL_SET'				=> 'Setting permissions',
	'ACL_SET_EXPLAIN'		=> 'Permissions are based on a simple <samp>YES</samp>/<samp>NO</samp> system. Setting an option to <samp>NEVER</samp> for a user or usergroup overrides any other value assigned to it. If you do not wish to assign a value for an option for this user or group select <samp>NO</samp>. If values are assigned for this option elsewhere they will be used in preference, else <samp>NEVER</samp> is assumed. All objects marked (with the checkbox in front of them) will copy the permission set you defined.',
	'ACL_SETTING'			=> 'Setting',

	'ACL_TYPE_A_'			=> 'Administrative permissions',
	'ACL_TYPE_F_'			=> 'Forum permissions',
	'ACL_TYPE_M_'			=> 'Moderative permissions',
	'ACL_TYPE_U_'			=> 'User permissions',

	'ACL_TYPE_GLOBAL_A_'	=> 'Administrative permissions',
	'ACL_TYPE_GLOBAL_U_'	=> 'User permissions',
	'ACL_TYPE_GLOBAL_M_'	=> 'Global Moderator permissions',
	'ACL_TYPE_LOCAL_M_'		=> 'Forum Moderator permissions',
	'ACL_TYPE_LOCAL_F_'		=> 'Forum permissions',

	'ACL_NO'				=> 'No',
	'ACL_VIEW'				=> 'Viewing permissions',
	'ACL_VIEW_EXPLAIN'		=> 'Here you can see the effective permissions the user/group is having. A red square indicates that the user/group does not have the permission, a green square indicates that the user/group does have the permission.',
	'ACL_YES'				=> 'Yes',

	'ACP_ADMINISTRATORS_EXPLAIN'				=> 'Here you can assign administrator permissions to users or groups. All users with administrator permissions can view the administration control panel.',
	'ACP_FORUM_MODERATORS_EXPLAIN'				=> 'Here you can assign users and groups as forum moderators. To assign users access to forums, to define global moderative permissions or administrators please use the appropriate page.',
	'ACP_FORUM_PERMISSIONS_EXPLAIN'				=> 'Here you can alter which users and groups can access which forums. To assign moderators or define administrators please use the appropriate page.',
	'ACP_GLOBAL_MODERATORS_EXPLAIN'				=> 'Here you can assign global moderator permissions to users or groups. These moderators are like ordinary moderators except they have access to every forum on your board.',
	'ACP_GROUPS_FORUM_PERMISSIONS_EXPLAIN'		=> 'Here you can assign forum permissions to groups.',
	'ACP_GROUPS_PERMISSIONS_EXPLAIN'			=> 'Here you can assign global permissions to groups - user permissions, global moderator permissions and administrator permissions. User permissions include capabilities such as the use of avatars, sending private messages, et cetera; global moderator permissions such as approving posts, manage topics, manage bans, et cetera and lastly administrator permissions such as altering permissions, define custom BBCodes, manage forums, et cetera. Individual users permissions should only be changed in rare occasions, the preferred method is putting users in groups and assigning the group\'s permissions.',
	'ACP_ADMIN_ROLES_EXPLAIN'					=> 'Here you are able to manage the roles for administrative permissions. Roles are effective permissions, if you change a role the items having this role assigned will change its permissions too.',
	'ACP_FORUM_ROLES_EXPLAIN'					=> 'Here you are able to manage the roles for forum permissions. Roles are effective permissions, if you change a role the items having this role assigned will change its permissions too.',
	'ACP_MOD_ROLES_EXPLAIN'						=> 'Here you are able to manage the roles for moderative permissions. Roles are effective permissions, if you change a role the items having this role assigned will change its permissions too.',
	'ACP_USER_ROLES_EXPLAIN'					=> 'Here you are able to manage the roles for user permissions. Roles are effective permissions, if you change a role the items having this role assigned will change its permissions too.',
	'ACP_USERS_FORUM_PERMISSIONS'	=> 'Users forum permissions',
	'ACP_GROUPS_FORUM_PERMISSIONS'	=> 'Groups forum permissions',
	'ACP_USERS_FORUM_PERMISSIONS_EXPLAIN'		=> 'Here you can assign forum permissions to users.',
	'ACP_USERS_PERMISSIONS_EXPLAIN'				=> 'Here you can assign global permissions to users - user permissions, global moderator permissions and administrator permissions. User permissions include capabilities such as the use of avatars, sending private messages, et cetera; global moderator permissions such as approving posts, manage topics, manage bans, et cetera and lastly administrator permissions such as altering permissions, define custom BBCodes, manage forums, et cetera. To alter these settings for large numbers of users the Group permissions system is the preferred method. User\'s permissions should only be changed in rare occasions, the preferred method is putting users in groups and assigning the group\'s permissions.',
	'ACP_VIEW_ADMIN_PERMISSIONS_EXPLAIN'		=> 'Here you can view the effective administrative permissions assigned to the selected users/groups.',
	'ACP_VIEW_GLOBAL_MOD_PERMISSIONS_EXPLAIN'	=> 'Here you can view the global moderative permissions assigned to the selected users/groups.',
	'ACP_VIEW_FORUM_PERMISSIONS_EXPLAIN'		=> 'Here you can view the forum permissions assigned to the selected users/groups and forums.',
	'ACP_VIEW_FORUM_MOD_PERMISSIONS'	=> 'View forum moderation permissions',
	'ACP_VIEW_FORUM_PERMISSIONS'		=> 'View forum-based permissions',
	'ACP_FORUM_BASED_PERMISSIONS'	=> 'Forum based permissions',
	'ACP_FORUM_LOGS'				=> 'Forum logs',
	'ACP_FORUM_MANAGEMENT'			=> 'Forum management',
	'ACP_FORUM_MODERATORS'			=> 'Forum moderators',
	'ACP_FORUM_PERMISSIONS'			=> 'Forum permissions',
	'ACP_FORUM_ROLES'				=> 'Forum roles',
	'ACP_VIEW_FORUM_MOD_PERMISSIONS_EXPLAIN'	=> 'Here you can view the forum moderator permissions assigned to the selected users/groups and forums.',
	'ACP_VIEW_USER_PERMISSIONS_EXPLAIN'			=> 'Here you can view the effective user permissions assigned to the selected users/groups.',

	'ADD_GROUPS'				=> 'Add groups',
	'ADD_PERMISSIONS'			=> 'Add permissions',
	'ADD_USERS'					=> 'Add users',
	'ADVANCED_PERMISSIONS'		=> 'Advanced Permissions',
	'ALL_GROUPS'				=> 'Select all groups',
	'ALL_NEVER'					=> 'All <samp>NEVER</samp>',
	'ALL_NO'					=> 'All <samp>NO</samp>',
	'ALL_USERS'					=> 'Select all users',
	'ALL_YES'					=> 'All <samp>YES</samp>',
	'APPLY_ALL_PERMISSIONS'		=> 'Apply all permissions',
	'APPLY_PERMISSIONS'			=> 'Apply permissions',
	'APPLY_PERMISSIONS_EXPLAIN'	=> 'The permissions and role defined for this item will only be applied to this item and all checked items.',
	'AUTH_UPDATED'				=> 'Permissions have been updated.',

	'CREATE_ROLE'				=> 'Create role',
	'CREATE_ROLE_FROM'			=> 'Use settings from…',
	'CUSTOM'					=> 'Custom…',

	'DEFAULT'					=> 'Default',
	'DELETE_ROLE'				=> 'Delete role',
	'DELETE_ROLE_CONFIRM'		=> 'Are you sure you want to remove this role? Items having this role assigned will <strong>not</strong> lose their permission settings.',
	'DISPLAY_ROLE_ITEMS'		=> 'View items using this role',

	'EDIT_PERMISSIONS'			=> 'Edit permissions',
	'EDIT_ROLE'					=> 'Edit role',

	'GROUPS_NOT_ASSIGNED'		=> 'No group assigned to this role',

	'LOOK_UP_GROUP'				=> 'Look up usergroup',
	'LOOK_UP_USER'				=> 'Look up user',

	'MANAGE_GROUPS'		=> 'Manage groups',
	'MANAGE_USERS'		=> 'Manage users',

	'NO_AUTH_SETTING_FOUND'		=> 'Permission settings not defined.',
	'NO_ROLE_ASSIGNED'			=> 'No role assigned…',
	'NO_ROLE_ASSIGNED_EXPLAIN'	=> 'Setting to this role does not change permissions on the right. If you want to unset/remove all permissions you should use the “All <samp>NO</samp>” link.',
	'NO_ROLE_AVAILABLE'			=> 'No role available',
	'NO_ROLE_NAME_SPECIFIED'	=> 'Please give the role a name.',
	'NO_ROLE_SELECTED'			=> 'Role could not be found.',
	'NO_USER_GROUP_SELECTED'	=> 'You haven\'t selected any user or group.',

	'ONLY_FORUM_DEFINED'	=> 'You only defined forums in your selection. Please also select at least one user or one group.',

	'PERMISSION_APPLIED_TO_ALL'		=> 'Permissions and role will also be applied to all checked objects',
	'PLUS_SUBFORUMS'				=> '+Subforums',

	'REMOVE_PERMISSIONS'			=> 'Remove permissions',
	'REMOVE_ROLE'					=> 'Remove role',
	'RESULTING_PERMISSION'			=> 'Resulting permission',
	'ROLE'							=> 'Role',
	'ROLE_ADD_SUCCESS'				=> 'Role successfully added.',
	'ROLE_ASSIGNED_TO'				=> 'Users/Groups assigned to %s',
	'ROLE_DELETED'					=> 'Role successfully removed.',
	'ROLE_DESCRIPTION'				=> 'Role description',

	'ROLE_ADMIN_FORUM'			=> 'Forum Admin',
	'ROLE_ADMIN_FULL'			=> 'Full Admin',
	'ROLE_ADMIN_STANDARD'		=> 'Standard Admin',
	'ROLE_ADMIN_USERGROUP'		=> 'User and Groups Admin',
	'ROLE_FORUM_BOT'			=> 'Bot Access',
	'ROLE_FORUM_FULL'			=> 'Full Access',
	'ROLE_FORUM_LIMITED'		=> 'Limited Access',
	'ROLE_FORUM_LIMITED_POLLS'	=> 'Limited Access + Polls',
	'ROLE_FORUM_NOACCESS'		=> 'No Access',
	'ROLE_FORUM_ONQUEUE'		=> 'On Moderation Queue',
	'ROLE_FORUM_POLLS'			=> 'Standard Access + Polls',
	'ROLE_FORUM_READONLY'		=> 'Read Only Access',
	'ROLE_FORUM_STANDARD'		=> 'Standard Access',
	'ROLE_MOD_FULL'				=> 'Full Moderator',
	'ROLE_MOD_QUEUE'			=> 'Queue Moderator',
	'ROLE_MOD_SIMPLE'			=> 'Simple Moderator',
	'ROLE_MOD_STANDARD'			=> 'Standard Moderator',
	'ROLE_USER_FULL'			=> 'All Features',
	'ROLE_USER_LIMITED'			=> 'Limited Features',
	'ROLE_USER_NOAVATAR'		=> 'No Avatar',
	'ROLE_USER_NOPM'			=> 'No Private Messages',
	'ROLE_USER_STANDARD'		=> 'Standard Features',

	'ROLE_DESCRIPTION_ADMIN_FORUM'			=> 'Can access the forum management and forum permission settings.',
	'ROLE_DESCRIPTION_ADMIN_FULL'			=> 'Has access to all administrative functions of this board.<br />Not recommended.',
	'ROLE_DESCRIPTION_ADMIN_STANDARD'		=> 'Has access to most administrative features but is not allowed to use server or system related tools.',
	'ROLE_DESCRIPTION_ADMIN_USERGROUP'		=> 'Can manage groups and users: Able to change permissions, settings, manage bans, and manage ranks.',
	'ROLE_DESCRIPTION_FORUM_BOT'			=> 'This role is recommended for bots and search spiders.',
	'ROLE_DESCRIPTION_FORUM_FULL'			=> 'Can use all forum features, including posting of announcements and stickies. Can also ignore the flood limit.<br />Not recommended for normal users.',
	'ROLE_DESCRIPTION_FORUM_LIMITED'		=> 'Can use some forum features, but cannot attach files or use post icons.',
	'ROLE_DESCRIPTION_FORUM_LIMITED_POLLS'	=> 'As per Limited Access but can also create polls.',
	'ROLE_DESCRIPTION_FORUM_NOACCESS'		=> 'Can neither see nor access the forum.',
	'ROLE_DESCRIPTION_FORUM_ONQUEUE'		=> 'Can use most forum features including attachments, but posts and topics need to be approved by a moderator.',
	'ROLE_DESCRIPTION_FORUM_POLLS'			=> 'Like Standard Access but can also create polls.',
	'ROLE_DESCRIPTION_FORUM_READONLY'		=> 'Can read the forum, but cannot create new topics or reply to posts.',
	'ROLE_DESCRIPTION_FORUM_STANDARD'		=> 'Can use most forum features including attachments and deleting own topics, but cannot lock own topics, and cannot create polls.',
	'ROLE_DESCRIPTION_MOD_FULL'				=> 'Can use all moderating features, including banning.',
	'ROLE_DESCRIPTION_MOD_QUEUE'			=> 'Can use the Moderation Queue to validate and edit posts, but nothing else.',
	'ROLE_DESCRIPTION_MOD_SIMPLE'			=> 'Can only use basic topic actions. Cannot send warnings or use moderation queue.',
	'ROLE_DESCRIPTION_MOD_STANDARD'			=> 'Can use most moderating tools, but cannot ban users or change the post author.',
	'ROLE_DESCRIPTION_USER_FULL'			=> 'Can use all available forum features for users, including changing the user name or ignoring the flood limit.<br />Not recommended.',
	'ROLE_DESCRIPTION_USER_LIMITED'			=> 'Can access some of the user features. Attachments, e-mails, or instant messages are not allowed.',
	'ROLE_DESCRIPTION_USER_NOAVATAR'		=> 'Has a limited feature set and is not allowed to use the Avatar feature.',
	'ROLE_DESCRIPTION_USER_NOPM'			=> 'Has a limited feature set, and is not allowed to use Private Messages.',
	'ROLE_DESCRIPTION_USER_STANDARD'		=> 'Can access most but not all user features. Cannot change user name or ignore the flood limit, for instance.',

	'ROLE_DESCRIPTION_EXPLAIN'		=> 'You are able to enter a short explanation of what the role is doing or for what it is meant for. The text you enter here will be displayed within the permissions screens too.',
	'ROLE_DESCRIPTION_LONG'			=> 'The role description is too long, please limit it to 4000 characters.',
	'ROLE_DETAILS'					=> 'Role details',
	'ROLE_EDIT_SUCCESS'				=> 'Role successfully edited.',
	'ROLE_NAME'						=> 'Role name',
	'ROLE_NAME_ALREADY_EXIST'		=> 'A role named <strong>%s</strong> already exist for the specified permission type.',
	'ROLE_NOT_ASSIGNED'				=> 'Role has not been assigned yet.',

	'SELECTED_FORUM_NOT_EXIST'		=> 'The selected forum(s) do not exist.',
	'SELECTED_GROUP_NOT_EXIST'		=> 'The selected group(s) do not exist.',
	'SELECTED_USER_NOT_EXIST'		=> 'The selected user(s) do not exist.',
	'SELECT_FORUM_SUBFORUM_EXPLAIN'	=> 'The forum you select here will include all subforums into the selection.',
	'SELECT_ROLE'					=> 'Select role…',
	'SELECT_TYPE'					=> 'Select type',
	'SET_PERMISSIONS'				=> 'Set permissions',
	'SET_ROLE_PERMISSIONS'			=> 'Set role permissions',
	'SET_USERS_PERMISSIONS'			=> 'Set users permissions',
	'SET_USERS_FORUM_PERMISSIONS'	=> 'Set users forum permissions',

	'LOOK_UP_FORUM'			=> 'Select a forum',
	'ALL_FORUMS'					=>	'All Forums',
	'LOOK_UP_FORUMS_EXPLAIN'=> 'You are able to select more than one forum.',
	'TRACE_DEFAULT'					=> 'By default every permission is <samp>NO</samp> (unset). So the permission can be overwritten by other settings.',
	'TRACE_FOR'						=> 'Trace for',
	'TRACE_GLOBAL_SETTING'			=> '%s (global)',
	'TRACE_GROUP_NEVER_TOTAL_NEVER'	=> 'This group\'s permission is set to <samp>NEVER</samp> like the total result so the old result is kept.',
	'TRACE_GROUP_NEVER_TOTAL_NEVER_LOCAL'	=> 'This group\'s permission for this forum is set to <samp>NEVER</samp> like the total result so the old result is kept.',
	'TRACE_GROUP_NEVER_TOTAL_NO'	=> 'This group\'s permission is set to <samp>NEVER</samp> which becomes the new total value because it wasn\'t set yet (set to <samp>NO</samp>).',
	'TRACE_GROUP_NEVER_TOTAL_NO_LOCAL'	=> 'This group\'s permission for this forum is set to <samp>NEVER</samp> which becomes the new total value because it wasn\'t set yet (set to <samp>NO</samp>).',
	'TRACE_GROUP_NEVER_TOTAL_YES'	=> 'This group\'s permission is set to <samp>NEVER</samp> which overwrites the total <samp>YES</samp> to a <samp>NEVER</samp> for this user.',
	'TRACE_GROUP_NEVER_TOTAL_YES_LOCAL'	=> 'This group\'s permission for this forum is set to <samp>NEVER</samp> which overwrites the total <samp>YES</samp> to a <samp>NEVER</samp> for this user.',
	'TRACE_GROUP_NO'				=> 'The permission is <samp>NO</samp> for this group so the old total value is kept.',
	'TRACE_GROUP_NO_LOCAL'			=> 'The permission is <samp>NO</samp> for this group within this forum so the old total value is kept.',
	'TRACE_GROUP_YES_TOTAL_NEVER'	=> 'This group\'s permission is set to <samp>YES</samp> but the total <samp>NEVER</samp> cannot be overwritten.',
	'TRACE_GROUP_YES_TOTAL_NEVER_LOCAL'	=> 'This group\'s permission for this forum is set to <samp>YES</samp> but the total <samp>NEVER</samp> cannot be overwritten.',
	'TRACE_GROUP_YES_TOTAL_NO'		=> 'This group\'s permission is set to <samp>YES</samp> which becomes the new total value because it wasn\'t set yet (set to <samp>NO</samp>).',
	'TRACE_GROUP_YES_TOTAL_NO_LOCAL'	=> 'This group\'s permission for this forum is set to <samp>YES</samp> which becomes the new total value because it wasn\'t set yet (set to <samp>NO</samp>).',
	'TRACE_GROUP_YES_TOTAL_YES'		=> 'This group\'s permission is set to <samp>YES</samp> and the total permission is already set to <samp>YES</samp>, so the total result is kept.',
	'TRACE_GROUP_YES_TOTAL_YES_LOCAL'	=> 'This group\'s permission for this forum is set to <samp>YES</samp> and the total permission is already set to <samp>YES</samp>, so the total result is kept.',
	'TRACE_PERMISSION'				=> 'Trace permission - %s',
	'TRACE_RESULT'					=> 'Trace result',
	'TRACE_SETTING'					=> 'Trace setting',

	'TRACE_USER_GLOBAL_YES_TOTAL_YES'		=> 'The forum independent user permission evaluates to <samp>YES</samp> but the total permission is already set to <samp>YES</samp>, so the total result is kept. %sTrace global permission%s',
	'TRACE_USER_GLOBAL_YES_TOTAL_NEVER'		=> 'The forum independent user permission evaluates to <samp>YES</samp> which overwrites the current local result <samp>NEVER</samp>. %sTrace global permission%s',
	'TRACE_USER_GLOBAL_NEVER_TOTAL_KEPT'	=> 'The forum independent user permission evaluates to <samp>NEVER</samp> which doesn\'t influence the local permission. %sTrace global permission%s',

	'TRACE_USER_FOUNDER'					=> 'The user has the founder type set, therefore admin permissions are set to <samp>YES</samp> by default.',
	'TRACE_USER_KEPT'						=> 'The user\'s permission is <samp>NO</samp> so the old total value is kept.',
	'TRACE_USER_KEPT_LOCAL'					=> 'The user\'s permission for this forum is <samp>NO</samp> so the old total value is kept.',
	'TRACE_USER_NEVER_TOTAL_NEVER'			=> 'The user\'s permission is set to <samp>NEVER</samp> and the total value is set to <samp>NEVER</samp>, so nothing is changed.',
	'TRACE_USER_NEVER_TOTAL_NEVER_LOCAL'	=> 'The user\'s permission for this forum is set to <samp>NEVER</samp> and the total value is set to <samp>NEVER</samp>, so nothing is changed.',
	'TRACE_USER_NEVER_TOTAL_NO'				=> 'The user\'s permission is set to <samp>NEVER</samp> which becomes the total value because it was set to NO.',
	'TRACE_USER_NEVER_TOTAL_NO_LOCAL'		=> 'The user\'s permission for this forum is set to <samp>NEVER</samp> which becomes the total value because it was set to NO.',
	'TRACE_USER_NEVER_TOTAL_YES'			=> 'The user\'s permission is set to <samp>NEVER</samp> and overwrites the previous <samp>YES</samp>.',
	'TRACE_USER_NEVER_TOTAL_YES_LOCAL'		=> 'The user\'s permission for this forum is set to <samp>NEVER</samp> and overwrites the previous <samp>YES</samp>.',
	'TRACE_USER_NO_TOTAL_NO'				=> 'The user\'s permission is <samp>NO</samp> and the total value was set to NO so it defaults to <samp>NEVER</samp>.',
	'TRACE_USER_NO_TOTAL_NO_LOCAL'			=> 'The user\'s permission for this forum is <samp>NO</samp> and the total value was set to NO so it defaults to <samp>NEVER</samp>.',
	'TRACE_USER_YES_TOTAL_NEVER'			=> 'The user\'s permission is set to <samp>YES</samp> but the total <samp>NEVER</samp> cannot be overwritten.',
	'TRACE_USER_YES_TOTAL_NEVER_LOCAL'		=> 'The user\'s permission for this forum is set to <samp>YES</samp> but the total <samp>NEVER</samp> cannot be overwritten.',
	'TRACE_USER_YES_TOTAL_NO'				=> 'The user\'s permission is set to <samp>YES</samp> which becomes the total value because it was set to <samp>NO</samp>.',
	'TRACE_USER_YES_TOTAL_NO_LOCAL'			=> 'The user\'s permission for this forum is set to <samp>YES</samp> which becomes the total value because it was set to <samp>NO</samp>.',
	'TRACE_USER_YES_TOTAL_YES'				=> 'The user\'s permission is set to <samp>YES</samp> and the total value is set to <samp>YES</samp>, so nothing is changed.',
	'TRACE_USER_YES_TOTAL_YES_LOCAL'		=> 'The user\'s permission for this forum is set to <samp>YES</samp> and the total value is set to <samp>YES</samp>, so nothing is changed.',
	'TRACE_WHO'								=> 'Who',
	'TRACE_TOTAL'							=> 'Total',

	'USERS_NOT_ASSIGNED'			=> 'No user assigned to this role',
	'USER_IS_MEMBER_OF_DEFAULT'		=> 'is a member of the following pre-defined groups',
	'USER_IS_MEMBER_OF_CUSTOM'		=> 'is a member of the following user defined groups',

	'VIEW_ASSIGNED_ITEMS'	=> 'View assigned items',
	'VIEW_LOCAL_PERMS'		=> 'Local permissions',
	'VIEW_GLOBAL_PERMS'		=> 'Global permissions',
	'VIEW_PERMISSIONS'		=> 'View permissions',

	'WRONG_PERMISSION_TYPE'				=> 'Wrong permission type selected.',
	'WRONG_PERMISSION_SETTING_FORMAT'	=> 'The permission settings are in a wrong format, phpBB is not able to process them correctly.',
));

$lang = array_merge($lang, array(
	'permission_cat'	=> array(
		'actions'		=> 'Actions',
		'content'		=> 'Content',
		'forums'		=> 'Forums',
		'misc'			=> 'Misc',
		'permissions'	=> 'Permissions',
		'pm'			=> 'Private messages',
		'polls'			=> 'Polls',
		'post'			=> 'Post',
		'post_actions'	=> 'Post actions',
		'posting'		=> 'Posting',
		'profile'		=> 'Profile',
		'settings'		=> 'Settings',
		'topic_actions'	=> 'Topic actions',
		'user_group'	=> 'Users &amp; Groups',
	),

	// With defining 'global' here we are able to specify what is printed out if the permission is within the global scope.
	'permission_type'	=> array(
		'u_'			=> 'User permissions',
		'a_'			=> 'Admin permissions',
		'm_'			=> 'Moderator permissions',
		'f_'			=> 'Forum permissions',
		'global'		=> array(
			'm_'			=> 'Global moderator permissions',
		),
	),
));

// User Permissions
$lang = array_merge($lang, array(
	'acl_u_viewprofile'	=> array('lang' => 'Can view profiles, memberlist and online list', 'cat' => 'profile'),
	'acl_u_chgname'		=> array('lang' => 'Can change username', 'cat' => 'profile'),
	'acl_u_chgpasswd'	=> array('lang' => 'Can change password', 'cat' => 'profile'),
	'acl_u_chgemail'	=> array('lang' => 'Can change e-mail address', 'cat' => 'profile'),
	'acl_u_chgavatar'	=> array('lang' => 'Can change avatar', 'cat' => 'profile'),
	'acl_u_chggrp'		=> array('lang' => 'Can change default usergroup', 'cat' => 'profile'),

	'acl_u_attach'		=> array('lang' => 'Can attach files', 'cat' => 'post'),
	'acl_u_download'	=> array('lang' => 'Can download files', 'cat' => 'post'),
	'acl_u_savedrafts'	=> array('lang' => 'Can save drafts', 'cat' => 'post'),
	'acl_u_chgcensors'	=> array('lang' => 'Can disable word censors', 'cat' => 'post'),
	'acl_u_sig'			=> array('lang' => 'Can use signature', 'cat' => 'post'),

	'acl_u_sendpm'		=> array('lang' => 'Can send private messages', 'cat' => 'pm'),
	'acl_u_masspm'		=> array('lang' => 'Can send messages to multiple users', 'cat' => 'pm'),
	'acl_u_masspm_group'=> array('lang' => 'Can send messages to groups', 'cat' => 'pm'),
	'acl_u_readpm'		=> array('lang' => 'Can read private messages', 'cat' => 'pm'),
	'acl_u_pm_edit'		=> array('lang' => 'Can edit own private messages', 'cat' => 'pm'),
	'acl_u_pm_delete'	=> array('lang' => 'Can remove private messages from own folder', 'cat' => 'pm'),
	'acl_u_pm_forward'	=> array('lang' => 'Can forward private messages', 'cat' => 'pm'),
	'acl_u_pm_emailpm'	=> array('lang' => 'Can e-mail private messages', 'cat' => 'pm'),
	'acl_u_pm_printpm'	=> array('lang' => 'Can print private messages', 'cat' => 'pm'),
	'acl_u_pm_attach'	=> array('lang' => 'Can attach files in private messages', 'cat' => 'pm'),
	'acl_u_pm_download'	=> array('lang' => 'Can download files in private messages', 'cat' => 'pm'),
	'acl_u_pm_bbcode'	=> array('lang' => 'Can post BBCode in private messages', 'cat' => 'pm'),
	'acl_u_pm_smilies'	=> array('lang' => 'Can post smilies in private messages', 'cat' => 'pm'),
	'acl_u_pm_img'		=> array('lang' => 'Can post images in private messages', 'cat' => 'pm'),
	'acl_u_pm_flash'	=> array('lang' => 'Can post Flash in private messages', 'cat' => 'pm'),

	'acl_u_sendemail'	=> array('lang' => 'Can send e-mails', 'cat' => 'misc'),
	'acl_u_sendim'		=> array('lang' => 'Can send instant messages', 'cat' => 'misc'),
	'acl_u_ignoreflood'	=> array('lang' => 'Can ignore flood limit', 'cat' => 'misc'),
	'acl_u_hideonline'	=> array('lang' => 'Can hide online status', 'cat' => 'misc'),
	'acl_u_viewonline'	=> array('lang' => 'Can view hidden online users', 'cat' => 'misc'),
	'acl_u_search'		=> array('lang' => 'Can search board', 'cat' => 'misc'),
));

// Forum Permissions
$lang = array_merge($lang, array(
	'acl_f_list'		=> array('lang' => 'Can see forum', 'cat' => 'post'),
	'acl_f_read'		=> array('lang' => 'Can read forum', 'cat' => 'post'),
	'acl_f_post'		=> array('lang' => 'Can start new topics', 'cat' => 'post'),
	'acl_f_reply'		=> array('lang' => 'Can reply to topics', 'cat' => 'post'),
	'acl_f_icons'		=> array('lang' => 'Can use topic/post icons', 'cat' => 'post'),
	'acl_f_announce'	=> array('lang' => 'Can post announcements', 'cat' => 'post'),
	'acl_f_sticky'		=> array('lang' => 'Can post stickies', 'cat' => 'post'),

	'acl_f_poll'		=> array('lang' => 'Can create polls', 'cat' => 'polls'),
	'acl_f_vote'		=> array('lang' => 'Can vote in polls', 'cat' => 'polls'),
	'acl_f_votechg'		=> array('lang' => 'Can change existing vote', 'cat' => 'polls'),

	'acl_f_attach'		=> array('lang' => 'Can attach files', 'cat' => 'content'),
	'acl_f_download'	=> array('lang' => 'Can download files', 'cat' => 'content'),
	'acl_f_sigs'		=> array('lang' => 'Can use signatures', 'cat' => 'content'),
	'acl_f_bbcode'		=> array('lang' => 'Can post BBCode', 'cat' => 'content'),
	'acl_f_smilies'		=> array('lang' => 'Can post smilies', 'cat' => 'content'),
	'acl_f_img'			=> array('lang' => 'Can post images', 'cat' => 'content'),
	'acl_f_flash'		=> array('lang' => 'Can post Flash', 'cat' => 'content'),

	'acl_f_edit'		=> array('lang' => 'Can edit own posts', 'cat' => 'actions'),
	'acl_f_delete'		=> array('lang' => 'Can delete own posts', 'cat' => 'actions'),
	'acl_f_user_lock'	=> array('lang' => 'Can lock own topics', 'cat' => 'actions'),
	'acl_f_bump'		=> array('lang' => 'Can bump topics', 'cat' => 'actions'),
	'acl_f_report'		=> array('lang' => 'Can report posts', 'cat' => 'actions'),
	'acl_f_subscribe'	=> array('lang' => 'Can subscribe forum', 'cat' => 'actions'),
	'acl_f_print'		=> array('lang' => 'Can print topics', 'cat' => 'actions'),
	'acl_f_email'		=> array('lang' => 'Can e-mail topics', 'cat' => 'actions'),

	'acl_f_search'		=> array('lang' => 'Can search the forum', 'cat' => 'misc'),
	'acl_f_ignoreflood' => array('lang' => 'Can ignore flood limit', 'cat' => 'misc'),
	'acl_f_postcount'	=> array('lang' => 'Increment post counter<br /><em>Please note that this setting only affects new posts.</em>', 'cat' => 'misc'),
	'acl_f_noapprove'	=> array('lang' => 'Can post without approval', 'cat' => 'misc'),
));

// Moderator Permissions
$lang = array_merge($lang, array(
	'acl_m_edit'		=> array('lang' => 'Can edit posts', 'cat' => 'post_actions'),
	'acl_m_delete'		=> array('lang' => 'Can delete posts', 'cat' => 'post_actions'),
	'acl_m_approve'		=> array('lang' => 'Can approve posts', 'cat' => 'post_actions'),
	'acl_m_report'		=> array('lang' => 'Can close and delete reports', 'cat' => 'post_actions'),
	'acl_m_chgposter'	=> array('lang' => 'Can change post author', 'cat' => 'post_actions'),

	'acl_m_move'	=> array('lang' => 'Can move topics', 'cat' => 'topic_actions'),
	'acl_m_lock'	=> array('lang' => 'Can lock topics', 'cat' => 'topic_actions'),
	'acl_m_split'	=> array('lang' => 'Can split topics', 'cat' => 'topic_actions'),
	'acl_m_merge'	=> array('lang' => 'Can merge topics', 'cat' => 'topic_actions'),

	'acl_m_info'	=> array('lang' => 'Can view post details', 'cat' => 'misc'),
	'acl_m_warn'	=> array('lang' => 'Can issue warnings<br /><em>This setting is only assigned globally. It is not forum based.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
	'acl_m_ban'		=> array('lang' => 'Can manage bans<br /><em>This setting is only assigned globally. It is not forum based.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
));

// Admin Permissions
$lang = array_merge($lang, array(
	'acl_a_board'		=> array('lang' => 'Can alter board settings/check for updates', 'cat' => 'settings'),
	'acl_a_server'		=> array('lang' => 'Can alter server/communication settings', 'cat' => 'settings'),
	'acl_a_jabber'		=> array('lang' => 'Can alter Jabber settings', 'cat' => 'settings'),
	'acl_a_phpinfo'		=> array('lang' => 'Can view php settings', 'cat' => 'settings'),

	'acl_a_forum'		=> array('lang' => 'Can manage forums', 'cat' => 'forums'),
	'acl_a_forumadd'	=> array('lang' => 'Can add new forums', 'cat' => 'forums'),
	'acl_a_forumdel'	=> array('lang' => 'Can delete forums', 'cat' => 'forums'),
	'acl_a_prune'		=> array('lang' => 'Can prune forums', 'cat' => 'forums'),

	'acl_a_icons'		=> array('lang' => 'Can alter topic/post icons and smilies', 'cat' => 'posting'),
	'acl_a_words'		=> array('lang' => 'Can alter word censors', 'cat' => 'posting'),
	'acl_a_bbcode'		=> array('lang' => 'Can define BBCode tags', 'cat' => 'posting'),
	'acl_a_attach'		=> array('lang' => 'Can alter attachment related settings', 'cat' => 'posting'),

	'acl_a_user'		=> array('lang' => 'Can manage users<br /><em>This also includes seeing the users browser agent within the viewonline list.</em>', 'cat' => 'user_group'),
	'acl_a_userdel'		=> array('lang' => 'Can delete/prune users', 'cat' => 'user_group'),
	'acl_a_group'		=> array('lang' => 'Can manage groups', 'cat' => 'user_group'),
	'acl_a_groupadd'	=> array('lang' => 'Can add new groups', 'cat' => 'user_group'),
	'acl_a_groupdel'	=> array('lang' => 'Can delete groups', 'cat' => 'user_group'),
	'acl_a_ranks'		=> array('lang' => 'Can manage ranks', 'cat' => 'user_group'),
	'acl_a_profile'		=> array('lang' => 'Can manage custom profile fields', 'cat' => 'user_group'),
	'acl_a_names'		=> array('lang' => 'Can manage disallowed names', 'cat' => 'user_group'),
	'acl_a_ban'			=> array('lang' => 'Can manage bans', 'cat' => 'user_group'),

	'acl_a_viewauth'	=> array('lang' => 'Can view permission masks', 'cat' => 'permissions'),
	'acl_a_authgroups'	=> array('lang' => 'Can alter permissions for individual groups', 'cat' => 'permissions'),
	'acl_a_authusers'	=> array('lang' => 'Can alter permissions for individual users', 'cat' => 'permissions'),
	'acl_a_fauth'		=> array('lang' => 'Can alter forum permission class', 'cat' => 'permissions'),
	'acl_a_mauth'		=> array('lang' => 'Can alter moderator permission class', 'cat' => 'permissions'),
	'acl_a_aauth'		=> array('lang' => 'Can alter admin permission class', 'cat' => 'permissions'),
	'acl_a_uauth'		=> array('lang' => 'Can alter user permission class', 'cat' => 'permissions'),
	'acl_a_roles'		=> array('lang' => 'Can manage roles', 'cat' => 'permissions'),
	'acl_a_switchperm'	=> array('lang' => 'Can use others permissions', 'cat' => 'permissions'),

	'acl_a_styles'		=> array('lang' => 'Can manage styles', 'cat' => 'misc'),
	'acl_a_viewlogs'	=> array('lang' => 'Can view logs', 'cat' => 'misc'),
	'acl_a_clearlogs'	=> array('lang' => 'Can clear logs', 'cat' => 'misc'),
	'acl_a_modules'		=> array('lang' => 'Can manage modules', 'cat' => 'misc'),
	'acl_a_language'	=> array('lang' => 'Can manage language packs', 'cat' => 'misc'),
	'acl_a_email'		=> array('lang' => 'Can send mass e-mail', 'cat' => 'misc'),
	'acl_a_bots'		=> array('lang' => 'Can manage bots', 'cat' => 'misc'),
	'acl_a_reasons'		=> array('lang' => 'Can manage report/denial reasons', 'cat' => 'misc'),
	'acl_a_backup'		=> array('lang' => 'Can backup/restore database', 'cat' => 'misc'),
	'acl_a_search'		=> array('lang' => 'Can manage search backends and settings', 'cat' => 'misc'),
));
$lang['permission_cat']['arcade'] = 'Arcade';

// Adding the permissions
$lang = array_merge($lang, array(
    'acl_a_arcade_settings'		=> array('lang' => 'Can change arcade settings',				'cat' => 'arcade'),
	'acl_a_arcade_manage'		=> array('lang' => 'Can manage arcade games and categories',	'cat' => 'arcade'),
	'acl_a_arcade_highscores'	=> array('lang' => 'Can manage arcade highscores',				'cat' => 'arcade'),
	
	'acl_m_arcade_comments'		=> array('lang' => 'Can manage arcade comments',	'cat' => 'arcade'),
	
	'acl_u_arcade_view_arcade'		=> array('lang' => 'Can view the arcade',			'cat' => 'arcade'),
	'acl_u_arcade_play_games'		=> array('lang' => 'Can play games in the arcade',	'cat' => 'arcade'),
	'acl_u_arcade_increase_views'	=> array('lang' => 'Increase views on games',		'cat' => 'arcade'),
	'acl_u_arcade_comment'			=> array('lang' => 'Can comment on games',			'cat' => 'arcade'),
	'acl_u_arcade_favorites'		=> array('lang' => 'Can have favorited games',		'cat' => 'arcade'),
	'acl_u_arcade_rating'			=> array('lang' => 'Can rate the games',			'cat' => 'arcade'),
	'acl_u_arcade_stats'			=> array('lang' => 'Can see arcade stats',			'cat' => 'arcade'),
));
?>