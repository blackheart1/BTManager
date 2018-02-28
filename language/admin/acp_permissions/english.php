<?php

/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File acp_permissions/english.php 2018-02-28 07:52:00 Thor
**
** CHANGES
**
** 2018-02-23 - Added New Masthead
** 2018-02-23 - Added New !defined('IN_PMBT')
** 2018-02-23 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

            <title>
        <?php if (isset($_GET['error']))
            {
        echo htmlspecialchars($_GET['error']);
            }
            ?> Error</title>

            <link rel='stylesheet' type='text/css' href='/errors/error-style.css' />
        </head>

        <body>
            <div id='container'>
        <div align='center' style='padding-top: 15px'>
            <img src='/errors/error-images/alert.png' width='89' height='94' alt='' title='' />
        </div>

        <h1 class='title'>Error 404 - Page Not Found</h1>
        <p class='sub-title' align='center'>The page that you are looking for does not appear to exist on this site.</p>
        <p>If you typed the address of the page into the address bar of your browser, please check that you typed it in correctly.</p>
        <p>If you arrived at this page after you used an old Bookmark or Favourite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
            </div>
        </body>
    </html>

    <?php
    exit();
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files must use UTF-8 as their encoding and the files must Not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You Do Not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a String contains only two placeholders which are used to wrap text
// in a URL you again Do Not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ACP_PERMISSIONS_EXPLAIN'	=> '
		<p>Permissions are Grouped into Four Major Sections:</p>

		<h2>Global Permissions</h2>
		<p>These are used to control access on a Global Level and apply to the entire site. They are further divided into Users\' Permissions, Groups Permissions, Global Moderators and Administrators.</p>

		<h2>Forum Based Permissions</h2>
		<p>These are used to control access on a per Forum basis. They are further divided into Forum Permissions, Forum Moderators, Users Forum Permissions and Groups Forum Permissions.</p>

		<h2>Permission Roles</h2>
		<p>These are used to Create different Sets of Permissions for the different Permission Types, later being able to be assigned on a Role Based basis. The Default Roles should cover the Administration of Sites of any size.  Within each of the Four Divisions, you can Add/Edit/Delete Roles as you see fit.</p>

		<h2>Permission Masks</h2>
		<p>These are used to View the Effective Permissions Assigned to Users, Moderators (Local and Global), Administrators or Forums.</p>

		<br />

		<p>For further Information on Setting Up and Managing Permissions on your phpBB3 Board, please see <a href="http://www.phpbb.com/support/documentation/3.0/quickstart/quick_permissions.html">Chapter 1.5 of our Quick Start Guide</a>.</p>
	',

	'ACL_NEVER'				=> 'Never',
	'ACL_SET'				=> 'Setting Permissions',
	'ACL_SET_EXPLAIN'		=> 'Permissions are based on a Simple <samp>YES</samp>/<samp>NO</samp> System. Setting an option to <samp>NEVER</samp> for a User or Usergroup overrides any other value assigned to it. If you DO NOT wish to assign a value for an option for this User or Group Select <samp>NO</samp>. If values are assigned to this option elsewhere they will be used in preference, else <samp>NEVER</samp> is assumed. ALL objects marked (with the checkbox in front of them) will Copy the Permission Set you defined.',
	'ACL_SETTING'			=> 'Setting',

	'ACL_TYPE_A_'			=> 'Administrator Permissions',
	'ACL_TYPE_F_'			=> 'Forum Permissions',
	'ACL_TYPE_M_'			=> 'Moderator Permissions',
	'ACL_TYPE_U_'			=> 'User Permissions',

	'ACL_TYPE_GLOBAL_A_'	=> 'Administrator Permissions',
	'ACL_TYPE_GLOBAL_U_'	=> 'User Permissions',
	'ACL_TYPE_GLOBAL_M_'	=> 'Global Moderator Permissions',
	'ACL_TYPE_LOCAL_M_'		=> 'Forum Moderator Permissions',
	'ACL_TYPE_LOCAL_F_'		=> 'Forum Permissions',

	'ACL_NO'				=> 'No',
	'ACL_VIEW'				=> 'Viewing Permissions',
	'ACL_VIEW_EXPLAIN'		=> 'Here you can see the Effective Permissions that the User/Group has. A Red Square indicates that the User/Group DOES NOT have the Permission, a Green Square indicates that the User/Group DOES have the Permission.',
	'ACL_YES'				=> 'Yes',

    'ACP_ADMINISTRATORS_EXPLAIN'              => 'Here you can Assign Administrator Permissions to Users or Groups. ALL Users with Administrator Permissions Can View the Administration Control Panel.',

    'ACP_FORUM_MODERATORS_EXPLAIN'            => 'Here you can Assign Users and Groups as Forum Moderators. To Assign Users Access to Forums, to Define Global Moderator Permissions or Administrators please use the appropriate page.',

    'ACP_FORUM_PERMISSIONS_EXPLAIN'           => 'Here you can Alter which Users and Groups can Access which Forums. To Assign Moderators or Define Administrators please use the appropriate page.<br /><br />',

    'ACP_GLOBAL_MODERATORS_EXPLAIN'           => 'Here you can Assign Global Moderator Permissions to Users or Groups. These Moderators are like ordinary Moderators except they have Access to Every Forum on your Board.',

    'ACP_GROUPS_FORUM_PERMISSIONS_EXPLAIN'    => 'Here you can Assign Forum Permissions to Groups.',

    'ACP_GROUPS_PERMISSIONS_EXPLAIN'          => 'Here you can Assign Global Permissions to Groups - User Permissions, Global Moderator Permissions and Administrator Permissions. <ul><li>User Permissions include the ability to use Avatars, send Private Messages etc. <li>Global Moderator Permissions include the ability to Approve Posts, Manage Topics, Manage Bans etc.<li>Administrator Permissions include the ability to Alter Permissions, Define Custom BBCodes, Manage Forums etc.</ul>Individual User Permissions should ONLY be changed in rare occasions, the preferred method is putting Users in Groups and assigning the Groups Permissions.',

    'ACP_ADMIN_ROLES_EXPLAIN'                 => 'Here you can Manage the Roles for Administrator Permissions. Roles are Effective Permissions, if you change a Role the items having this Role Assigned will change its Permissions too.',

    'ACP_FORUM_ROLES_EXPLAIN'                 => 'Here you can Manage the Roles for Forum Permissions. Roles are Effective Permissions, if you change a Role the items having this Role Assigned will change its Permissions too.',

    'ACP_MOD_ROLES_EXPLAIN'                   => 'Here you can Manage the Roles for Moderator Permissions. Roles are Effective Permissions, if you change a Role the items having this Role Assigned will change its Permissions too.',

    'ACP_USER_ROLES_EXPLAIN'                  => 'Here you can Manage the Roles for User Permissions. Roles are Effective Permissions, if you change a Role the items having this Role Assigned will change its Permissions too.',

    'ACP_USERS_FORUM_PERMISSIONS'             => 'Users Forum Permissions',
    'ACP_GROUPS_FORUM_PERMISSIONS'            => 'Groups Forum Permissions',
    'ACP_USERS_FORUM_PERMISSIONS_EXPLAIN'     => 'Here you can Assign Forum Permissions to Users.',

    'ACP_USERS_PERMISSIONS_EXPLAIN'           => 'Here you can Assign Global Permissions to Users - User Permissions, Global Moderator Permissions and Administrator Permissions. <ul><li>User Permissions include capabilities such as using Avatars, Sending Private Messages, etc. <li>Global Moderator Permissions such as Approving Posts, Manage Topics, Manage Bans, etc.<li>Administrator Permissions such as Altering Permissions, Define Custom BBCodes, Manage Forums, etc.</ul>To Alter these Settings for a large numbers of Users the Group Permissions System is the preferred method. Users Permissions should only be changed in rare occasions, the preferred method is putting Users in Groups and Assigning the Groups Permissions.',

    'ACP_VIEW_ADMIN_PERMISSIONS_EXPLAIN'      => 'Here you can View the effective Administrator Permissions Assigned to the Selected Users/Groups.',

    'ACP_VIEW_GLOBAL_MOD_PERMISSIONS_EXPLAIN' => 'Here you can View the Global Moderator Permissions Assigned to the Selected Users/Groups.',

    'ACP_VIEW_FORUM_PERMISSIONS_EXPLAIN'      => 'Here you can View the Forum Permissions Assigned to the Selected Users/Groups and Forums.',

    'ACP_VIEW_FORUM_MOD_PERMISSIONS'         => 'View Forum Moderator Permissions',
    'ACP_VIEW_FORUM_PERMISSIONS'             => 'View Forum Based Permissions',
    'ACP_FORUM_BASED_PERMISSIONS'            => 'Forum Based Permissions',
    'ACP_FORUM_LOGS'                         => 'Forum Logs',
    'ACP_FORUM_MANAGEMENT'                   => 'Forum Management',
    'ACP_FORUM_MODERATORS'                   => 'Forum Moderators',
    'ACP_FORUM_PERMISSIONS'                  => 'Forum Permissions',
    'ACP_FORUM_ROLES'                        => 'Forum Roles',
    'ACP_VIEW_FORUM_MOD_PERMISSIONS_EXPLAIN' => 'Here you can View the Forum Moderator Permissions Assigned to the Selected Users/Groups and Forums.',
    'ACP_VIEW_USER_PERMISSIONS_EXPLAIN'      => 'Here you can View the effective User Permissions Assigned to the Selected Users/Groups.',

    'ADD_GROUPS'                => 'Add Groups',
    'ADD_PERMISSIONS'           => 'Add Permissions',
    'ADD_USERS'                 => 'Add Users',
    'ADVANCED_PERMISSIONS'      => 'Advanced Permissions',
    'ALL_GROUPS'                => 'Select ALL Groups',
    'ALL_NEVER'                 => 'All <samp>NEVER</samp>',
    'ALL_NO'                    => 'All <samp>NO</samp>',
    'ALL_USERS'                 => 'Select ALL Users',
    'ALL_YES'                   => 'All <samp>YES</samp>',
    'APPLY_ALL_PERMISSIONS'     => 'Apply ALL Permissions',
    'APPLY_PERMISSIONS'         => 'Apply Permissions',
    'APPLY_PERMISSIONS_EXPLAIN' => 'The Permissions and Roles Defined for this Item will Only be applied to this item and ALL Checked Items.',
    'AUTH_UPDATED'              => 'Permissions have been Updated.',

    'CREATE_ROLE'               => 'Create a Role',
    'CREATE_ROLE_FROM'          => 'Use Settings from?',
    'CUSTOM'                    => 'Custom?',

    'DEFAULT'                   => 'Default',
    'DELETE_ROLE'               => 'Delete Role',
    'DELETE_ROLE_CONFIRM'       => 'Are you sure you want to Remove this Role? Items having this Role Assigned will <strong>NOT</strong> loose their Permission Settings.',
    'DISPLAY_ROLE_ITEMS'        => 'View Items using this Role',

    'EDIT_PERMISSIONS'          => 'Edit Permissions',
    'EDIT_ROLE'                 => 'Edit Role',

    'GROUPS_NOT_ASSIGNED'       => 'No Group Assigned to this Role',

    'LOOK_UP_GROUP'             => 'Look up Usergroup',
    'LOOK_UP_USER'              => 'Look up a User',

    'MANAGE_GROUPS'             => 'Manage Groups',
    'MANAGE_USERS'              => 'Manage Users',

    'NO_AUTH_SETTING_FOUND'     => 'Permission Settings NOT Defined.',
    'NO_ROLE_ASSIGNED'          => 'NO Role Assigned?',
    'NO_ROLE_ASSIGNED_EXPLAIN'  => 'Setting this Role DOES NOT change Permissions on the Right. If you want to Unset/Remove ALL Permissions you should use the ALL <samp>NO</samp> Link.',
    'NO_ROLE_AVAILABLE'         => 'No Role Available',
    'NO_ROLE_NAME_SPECIFIED'    => 'Please give the Role a Name.',
    'NO_ROLE_SELECTED'          => 'Role Could NOT be Found.',
    'NO_USER_GROUP_SELECTED'    => 'You haven\'t Selected any User or Group.',

    'ONLY_FORUM_DEFINED'        => 'You Only Defined Forums in your Selection. Please also Select at least one User or one Group.',

    'PERMISSION_APPLIED_TO_ALL' => 'Permissions and Roles will also be applied to ALL Checked Objects',
    'PLUS_SUBFORUMS'            => '+Subforums',

    'REMOVE_PERMISSIONS'        => 'Remove Permissions',
    'REMOVE_ROLE'               => 'Remove Role',
    'RESULTING_PERMISSION'      => 'Resulting Permission',
    'ROLE'                      => 'Role',
    'ROLE_ADD_SUCCESS'          => 'Role Successfully Added.',
    'ROLE_ASSIGNED_TO'          => 'Users/Groups Assigned to %s',
    'ROLE_DELETED'              => 'Role Successfully Removed.',
    'ROLE_DESCRIPTION'          => 'Role Description',

    'ROLE_ADMIN_FORUM'          => 'Forum Administrator',
    'ROLE_ADMIN_FULL'           => 'Full Administrator',
    'ROLE_ADMIN_STANDARD'       => 'Standard Administrator',
    'ROLE_ADMIN_USERGROUP'      => 'User and Groups Administrator',
    'ROLE_FORUM_BOT'            => 'BOT Access',
    'ROLE_FORUM_FULL'           => 'Full Access',
    'ROLE_FORUM_LIMITED'        => 'Limited Access',
    'ROLE_FORUM_LIMITED_POLLS'  => 'Limited Access + Polls',
    'ROLE_FORUM_NOACCESS'       => 'No Access',
    'ROLE_FORUM_ONQUEUE'        => 'On Moderation Queue',
    'ROLE_FORUM_POLLS'          => 'Standard Access + Polls',
    'ROLE_FORUM_READONLY'       => 'Read Only Access',
    'ROLE_FORUM_STANDARD'       => 'Standard Access',
    'ROLE_MOD_FULL'             => 'Full Moderator',
    'ROLE_MOD_QUEUE'            => 'Queue Moderator',
    'ROLE_MOD_SIMPLE'           => 'Simple Moderator',
    'ROLE_MOD_STANDARD'         => 'Standard Moderator',
    'ROLE_USER_FULL'            => 'ALL Features',
    'ROLE_USER_LIMITED'         => 'Limited Features',
    'ROLE_USER_NOAVATAR'        => 'NO Avatar',
    'ROLE_USER_NOPM'            => 'NO Private Messages',
    'ROLE_USER_STANDARD'        => 'Standard Features',

    'ROLE_DESCRIPTION_ADMIN_FORUM'         => 'Can Access the Forum Management and Forum Permission Settings.',
    'ROLE_DESCRIPTION_ADMIN_FULL'          => 'Has Access to ALL Administrator Functions of this Board.<br />NOT Recommended.',
    'ROLE_DESCRIPTION_ADMIN_STANDARD'      => 'Has Access to Most Administrator Features but, is NOT Allowed to Use Server or System Related Tools.',

    'ROLE_DESCRIPTION_ADMIN_USERGROUP'     => 'Can Manage Groups and Users and is able to Change Permissions, Settings, Manage Bans, and Manage Ranks.',

    'ROLE_DESCRIPTION_FORUM_BOT'           => 'This Role is Recommended for BOTS and Search Spiders.',
    'ROLE_DESCRIPTION_FORUM_FULL'          => 'Can Use ALL Forum Features, Including Posting of Announcements and Stickies. Can also Ignore the Flood Limit.<br />NOT Recommended for Normal Users.',
    'ROLE_DESCRIPTION_FORUM_LIMITED'       => 'Can Use some Forum Features, but can NOT Attach Files or use Post Icons.',
    'ROLE_DESCRIPTION_FORUM_LIMITED_POLLS' => 'As per Limited Access but can also Create Polls.',
    'ROLE_DESCRIPTION_FORUM_NOACCESS'      => 'Can NOT View or Access the Forum.',
    'ROLE_DESCRIPTION_FORUM_ONQUEUE'       => 'Can use most Forum Features Including Attachments, but Posts and Topics need to be Approved by a Moderator.',

    'ROLE_DESCRIPTION_FORUM_POLLS'         => 'Like Standard Access but can also Create Polls.',
    'ROLE_DESCRIPTION_FORUM_READONLY'      => 'Can Read the Forum, but can NOT Create New Topics or Reply to Posts.',
    'ROLE_DESCRIPTION_FORUM_STANDARD'      => 'Can use most Forum Features Including Attachments and Delete their Own Topics, but can NOT Lock their Own Topics, and can NOT Create Polls.',
    'ROLE_DESCRIPTION_MOD_FULL'            => 'Can use ALL Moderating Features, Including Banning.',
    'ROLE_DESCRIPTION_MOD_QUEUE'           => 'Can use the Moderation Queue to Validate and Edit Posts, but nothing else.',
    'ROLE_DESCRIPTION_MOD_SIMPLE'          => 'Can Only use Basic Topic Actions but, can NOT Send Warnings or Use the Moderation Queue.',
    'ROLE_DESCRIPTION_MOD_STANDARD'        => 'Can use most Moderating Tools, but can NOT Ban Users or Change the Post Author.',
    'ROLE_DESCRIPTION_USER_FULL'           => 'Can use ALL Available Forum Features for Users, Including Changing the User Name and Ignore The Flood Limit.<br />NOT Recommended.',
    'ROLE_DESCRIPTION_USER_LIMITED'        => 'Can Access some of the User Features but, NOT Attachments, emails or Instant Messages.',
    'ROLE_DESCRIPTION_USER_NOAVATAR'       => 'Has a Limited Feature Set, but is NOT Allowed to use the Avatar Feature.',
    'ROLE_DESCRIPTION_USER_NOPM'           => 'Has a Limited Feature Set, but is NOT Allowed to use Private Messages.',
    'ROLE_DESCRIPTION_USER_STANDARD'       => 'Can Access most of the User Features but can NOT Change User Name or Ignore the Flood Limit.',

    'ROLE_DESCRIPTION_EXPLAIN'             => 'You are able to enter a Short Explanation of what the Role is doing or for what it is meant for. The Text you enter here will be Displayed within the Permissions Screens.',
    'ROLE_DESCRIPTION_LONG'                => 'The Role Description is too Long, please Limit it to 4000 Characters.',
    'ROLE_DETAILS'                         => 'Role Details',
    'ROLE_EDIT_SUCCESS'                    => 'Role Successfully Edited.',
    'ROLE_NAME'                            => 'Role Name',
    'ROLE_NAME_ALREADY_EXIST'              => 'A Role Named <strong>%s</strong> Already Exists for the Specified Permission Type.',
    'ROLE_NOT_ASSIGNED'                    => 'Role has NOT been Assigned yet.',

    'SELECTED_FORUM_NOT_EXIST'      => 'The Selected Forum(s) DO NOT Exist.',
    'SELECTED_GROUP_NOT_EXIST'      => 'The Selected Group(s) DO NOT Exist.',
    'SELECTED_USER_NOT_EXIST'       => 'The Selected User(s) DO NOT Exist.',
    'SELECT_FORUM_SUBFORUM_EXPLAIN' => 'The Forum you Select here will include all Subforums in the Selection.',
    'SELECT_ROLE'                   => 'Select Role?',
    'SELECT_TYPE'                   => 'Select Type',
    'SET_PERMISSIONS'               => 'Set Permissions',
    'SET_ROLE_PERMISSIONS'          => 'Set Role Permissions',
    'SET_USERS_PERMISSIONS'         => 'Set User Permissions',
    'SET_USERS_FORUM_PERMISSIONS'   => 'Set User Forum Permissions',

    'LOOK_UP_FORUM'          => 'Select a Forum',
    'ALL_FORUMS'             =>	'All Forums',
    'LOOK_UP_FORUMS_EXPLAIN' => 'You are able to Select more than one Forum.',

    'TRACE_DEFAULT'                       => 'By Default every Permission is <samp>NO</samp> (unset). So the Permission can be Overwritten by Other Settings.',

    'TRACE_FOR'                           => 'Trace for',
    'TRACE_GLOBAL_SETTING'                => '%s (global)',
    'TRACE_GROUP_NEVER_TOTAL_NEVER'       => 'This Groups Permission is Set to <samp>NEVER</samp> like the Total Result so the Old Result is Kept.',

    'TRACE_GROUP_NEVER_TOTAL_NEVER_LOCAL' => 'This Groups Permission for this Forum is Set to <samp>NEVER</samp> like the Total Result so the Old Result is Kept.',

    'TRACE_GROUP_NEVER_TOTAL_NO'          => 'This Groups Permission is Set to <samp>NEVER</samp> which becomes the New Total Value because it wasn\'t Set yet (Set to <samp>NO</samp>).',

    'TRACE_GROUP_NEVER_TOTAL_NO_LOCAL'    => 'This Groups Permission for this Forum is Set to <samp>NEVER</samp> which becomes the New Total Value because it wasn\'t Set yet (Set to <samp>NO</samp>).',

    'TRACE_GROUP_NEVER_TOTAL_YES'         => 'This Groups Permission is Set to <samp>NEVER</samp> which Overwrites the Total <samp>YES</samp> to a <samp>NEVER</samp> for this User.',

    'TRACE_GROUP_NEVER_TOTAL_YES_LOCAL'   => 'This Groups Permission for this Forum is Set to <samp>NEVER</samp> which Overwrites the Total <samp>YES</samp> to a <samp>NEVER</samp> for this User.',

    'TRACE_GROUP_NO'                      => 'The Permission is <samp>NO</samp> for this Group so the Old Total Value is Kept.',
    'TRACE_GROUP_NO_LOCAL'                => 'The Permission is <samp>NO</samp> for this Group within this Forum so the Old Total Value is Kept.',

    'TRACE_GROUP_YES_TOTAL_NEVER'         => 'This Groups Permission is Set to <samp>YES</samp> but the Total <samp>NEVER</samp> can NOT be Overwritten.',

    'TRACE_GROUP_YES_TOTAL_NEVER_LOCAL'   => 'This Groups Permission for this Forum is Set to <samp>YES</samp> but the Total <samp>NEVER</samp> can NOT be Overwritten.',

    'TRACE_GROUP_YES_TOTAL_NO'            => 'This Groups Permission is Set to <samp>YES</samp> which becomes the New Total Value because it wasn\'t Set yet (Set to <samp>NO</samp>).',

    'TRACE_GROUP_YES_TOTAL_NO_LOCAL'      => 'This Groups Permission for this Forum is Set to <samp>YES</samp> which becomes the New Total Value because it wasn\'t Set yet (Set to <samp>NO</samp>).',

    'TRACE_GROUP_YES_TOTAL_YES'           => 'This Groups Permission is Set to <samp>YES</samp> and the Total Permission is already Set to <samp>YES</samp>, so the Total Result is Kept.',

    'TRACE_GROUP_YES_TOTAL_YES_LOCAL'     => 'This Groups Permission for this Forum is Set to <samp>YES</samp> and the Total Permission is Already Set to <samp>YES</samp>, so the Total Result is Kept.',

    'TRACE_PERMISSION'                    => 'Trace Permission - %s',
    'TRACE_RESULT'                        => 'Trace Result',
    'TRACE_SETTING'                       => 'Trace Setting',

    'TRACE_USER_GLOBAL_YES_TOTAL_YES'     => 'The Forum Independent User Permission evaluates to <samp>YES</samp> but the Total Permission is Already Set to <samp>YES</samp>, so the Total Result is Kept. %sTrace Global Permission%s',

    'TRACE_USER_GLOBAL_YES_TOTAL_NEVER'   => 'The Forum Independent User Permission evaluates to <samp>YES</samp> which Overwrites the Current Local Result <samp>NEVER</samp>. %sTrace Global Permission%s',

    'TRACE_USER_GLOBAL_NEVER_TOTAL_KEPT'  => 'The Forum Independent User Permission evaluates to <samp>NEVER</samp> which doesn\'t influence the Local Permission. %sTrace Global Permission%s',

    'TRACE_USER_FOUNDER'                  => 'The User has the Founder Type Set, therefore Administrator Permissions are Set to <samp>YES</samp> by Default.',
    'TRACE_USER_KEPT'                     => 'The Users Permission is <samp>NO</samp> so the Old Total Value is Kept.',
    'TRACE_USER_KEPT_LOCAL'               => 'The Users Permission for this Forum is <samp>NO</samp> so the Old Total Value is Kept.',

    'TRACE_USER_NEVER_TOTAL_NEVER'        => 'The Users Permission is Set to <samp>NEVER</samp> and the Total Value is Set to <samp>NEVER</samp>, so nothing is changed.',

    'TRACE_USER_NEVER_TOTAL_NEVER_LOCAL'  => 'The Users Permission for this Forum is Set to <samp>NEVER</samp> and the Total Value is Set to <samp>NEVER</samp>, so nothing is changed.',

    'TRACE_USER_NEVER_TOTAL_NO'           => 'The Users Permission is Set to <samp>NEVER</samp> which becomes the Total Value because it was Set to NO.',

    'TRACE_USER_NEVER_TOTAL_NO_LOCAL'     => 'The Users Permission for this Forum is Set to <samp>NEVER</samp> which becomes the Total Value because it was Set to NO.',

    'TRACE_USER_NEVER_TOTAL_YES'          => 'The Users Permission is Set to <samp>NEVER</samp> and Overwrites the previous <samp>YES</samp>.',
    'TRACE_USER_NEVER_TOTAL_YES_LOCAL'    => 'The Users Permission for this Forum is Set to <samp>NEVER</samp> and Overwrites the previous <samp>YES</samp>.',

    'TRACE_USER_NO_TOTAL_NO'              => 'The Users Permission is <samp>NO</samp> and the Total Value was Set to NO so it Defaults to <samp>NEVER</samp>.',

    'TRACE_USER_NO_TOTAL_NO_LOCAL'        => 'The Users Permission for this Forum is <samp>NO</samp> and the Total Value was Set to NO so it Defaults to <samp>NEVER</samp>.',

    'TRACE_USER_YES_TOTAL_NEVER'          => 'The Users Permission is Set to <samp>YES</samp> but the Total <samp>NEVER</samp> can NOT be Overwritten.',

    'TRACE_USER_YES_TOTAL_NEVER_LOCAL'    => 'The Users Permission for this Forum is Set to <samp>YES</samp> but the Total <samp>NEVER</samp> can NOT be Overwritten.',

    'TRACE_USER_YES_TOTAL_NO'             => 'The Users Permission is Set to <samp>YES</samp> which becomes the Total Value because it was Set to <samp>NO</samp>.',

    'TRACE_USER_YES_TOTAL_NO_LOCAL'       => 'The Users Permission for this Forum is Set to <samp>YES</samp> which becomes the Total Value because it was Set to <samp>NO</samp>.',

    'TRACE_USER_YES_TOTAL_YES'            => 'The Users Permission is Set to <samp>YES</samp> and the Total Value is set to <samp>YES</samp>, so nothing is changed.',

    'TRACE_USER_YES_TOTAL_YES_LOCAL'      => 'The Users Permission for this Forum is Set to <samp>YES</samp> and the Total Value is Set to <samp>YES</samp>, so nothing is changed.',

    'TRACE_WHO'                           => 'Who',
    'TRACE_TOTAL'                         => 'Total',

    'USERS_NOT_ASSIGNED'              => 'No User Assigned to this Role',
    'USER_IS_MEMBER_OF_DEFAULT'       => 'is a Member of the following Pre Defined Groups',
    'USER_IS_MEMBER_OF_CUSTOM'        => 'is a Member of the following User Defined Groups',

    'VIEW_ASSIGNED_ITEMS'             => 'View Assigned Items',
    'VIEW_LOCAL_PERMS'                => 'Local Permissions',
    'VIEW_GLOBAL_PERMS'               => 'Global Permissions',
    'VIEW_PERMISSIONS'                => 'View Permissions',

    'WRONG_PERMISSION_TYPE'           => 'Wrong Permission Type Selected.',
    'WRONG_PERMISSION_SETTING_FORMAT' => 'The Permission Settings are in a Wrong Format, phpBB is NOT able to process them correctly.',
));

$lang = array_merge($lang, array(
	'permission_cat'	=> array(
        'actions'       => 'Actions',
        'content'       => 'Content',
        'forums'        => 'Forums',
        'misc'          => 'Misc',
        'permissions'   => 'Permissions',
        'pm'            => 'Private Messages',
        'polls'         => 'Polls',
        'post'          => 'Post',
        'post_actions'  => 'Post Actions',
        'posting'       => 'Posting',
        'profile'       => 'Profile',
        'settings'      => 'Settings',
        'topic_actions' => 'Topic Actions',
        'user_group'    => 'Users &amp; Groups',
	),

	// With Defining 'Global' Here we are able to specify what is Printed Out if the Permission is within the Global Scope.
	'permission_type'	=> array(
        'u_'			=> 'User Permissions',
        'a_'			=> 'Administrator Permissions',
        'm_'			=> 'Moderator Permissions',
        'f_'			=> 'Forum Permissions',
        'global'		=> array(
        'm_'			=> 'Global Moderator Permissions',
		),
	),
));

// User Permissions
$lang = array_merge($lang, array(
    'acl_u_viewprofile'  => array('lang' => 'Can View Profiles, Member List and Online List', 'cat' => 'profile'),
    'acl_u_chgname'      => array('lang' => 'Can Change Username', 'cat' => 'profile'),
    'acl_u_chgpasswd'    => array('lang' => 'Can Change Password', 'cat' => 'profile'),
    'acl_u_chgemail'     => array('lang' => 'Can Change email Address', 'cat' => 'profile'),
    'acl_u_chgavatar'    => array('lang' => 'Can Change Avatar', 'cat' => 'profile'),
    'acl_u_chggrp'       => array('lang' => 'Can Change Default Usergroup', 'cat' => 'profile'),

    'acl_u_attach'       => array('lang' => 'Can Attach Files', 'cat' => 'post'),
    'acl_u_download'     => array('lang' => 'Can Download Files', 'cat' => 'post'),
    'acl_u_savedrafts'   => array('lang' => 'Can Save Drafts', 'cat' => 'post'),
    'acl_u_chgcensors'   => array('lang' => 'Can Disable Word Censors', 'cat' => 'post'),
    'acl_u_sig'          => array('lang' => 'Can Use Signature', 'cat' => 'post'),

    'acl_u_sendpm'       => array('lang' => 'Can Send Private Messages', 'cat' => 'pm'),
    'acl_u_masspm'       => array('lang' => 'Can Send Messages to Multiple Users', 'cat' => 'pm'),
    'acl_u_masspm_group' => array('lang' => 'Can Send Messages to Groups', 'cat' => 'pm'),
    'acl_u_readpm'       => array('lang' => 'Can Read Private Messages', 'cat' => 'pm'),
    'acl_u_pm_edit'      => array('lang' => 'Can Edit Own Private Messages', 'cat' => 'pm'),
    'acl_u_pm_delete'    => array('lang' => 'Can Remove Private Messages from their Own Folder', 'cat' => 'pm'),
    'acl_u_pm_forward'   => array('lang' => 'Can Forward Private Messages', 'cat' => 'pm'),
    'acl_u_pm_emailpm'   => array('lang' => 'Can email Private Messages', 'cat' => 'pm'),
    'acl_u_pm_printpm'   => array('lang' => 'Can Print Private Messages', 'cat' => 'pm'),
    'acl_u_pm_attach'    => array('lang' => 'Can Attach Files in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_download'  => array('lang' => 'Can Download Files in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_bbcode'    => array('lang' => 'Can Use BBCode in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_smilies'   => array('lang' => 'Can Use Smilies in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_img'       => array('lang' => 'Can Use Images in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_flash'     => array('lang' => 'Can Use Flash in Private Messages', 'cat' => 'pm'),

    'acl_u_sendemail'    => array('lang' => 'Can Send emails', 'cat' => 'misc'),
    'acl_u_sendim'       => array('lang' => 'Can Send Instant Messages', 'cat' => 'misc'),
    'acl_u_ignoreflood'  => array('lang' => 'Can Ignore Flood Limit', 'cat' => 'misc'),
    'acl_u_hideonline'   => array('lang' => 'Can Hide Online Status', 'cat' => 'misc'),
    'acl_u_viewonline'   => array('lang' => 'Can View Hidden Online Users', 'cat' => 'misc'),
    'acl_u_search'       => array('lang' => 'Can Search Board', 'cat' => 'misc'),
));

// Forum Permissions
    $lang = array_merge($lang, array(
    'acl_f_list'		=> array('lang' => 'Can View Forum', 'cat' => 'post'),
    'acl_f_read'		=> array('lang' => 'Can Read Forum', 'cat' => 'post'),
    'acl_f_post'		=> array('lang' => 'Can Start New Topics', 'cat' => 'post'),
    'acl_f_reply'		=> array('lang' => 'Can Reply to Topics', 'cat' => 'post'),
    'acl_f_icons'		=> array('lang' => 'Can Use Topic/Post Icons', 'cat' => 'post'),
    'acl_f_announce'	=> array('lang' => 'Can Post Announcements', 'cat' => 'post'),
    'acl_f_sticky'		=> array('lang' => 'Can Post Stickies', 'cat' => 'post'),

    'acl_f_poll'		=> array('lang' => 'Can Create Polls', 'cat' => 'polls'),
    'acl_f_vote'		=> array('lang' => 'Can Vote in Polls', 'cat' => 'polls'),
    'acl_f_votechg'		=> array('lang' => 'Can Change Existing Vote', 'cat' => 'polls'),

    'acl_f_attach'		=> array('lang' => 'Can Attach Files', 'cat' => 'content'),
    'acl_f_download'	=> array('lang' => 'Can Download Files', 'cat' => 'content'),
    'acl_f_sigs'		=> array('lang' => 'Can Use Signatures', 'cat' => 'content'),
    'acl_f_bbcode'		=> array('lang' => 'Can Use BBCode', 'cat' => 'content'),
    'acl_f_smilies'		=> array('lang' => 'Can Use Smilies', 'cat' => 'content'),
    'acl_f_img'			=> array('lang' => 'Can Use Images', 'cat' => 'content'),
    'acl_f_flash'		=> array('lang' => 'Can Use Flash', 'cat' => 'content'),

    'acl_f_edit'		=> array('lang' => 'Can Edit their Own Posts', 'cat' => 'actions'),
    'acl_f_delete'		=> array('lang' => 'Can Delete their Own Posts', 'cat' => 'actions'),
    'acl_f_user_lock'	=> array('lang' => 'Can Lock their Own Topics', 'cat' => 'actions'),
    'acl_f_bump'		=> array('lang' => 'Can Bump Topics', 'cat' => 'actions'),
    'acl_f_report'		=> array('lang' => 'Can Report Posts', 'cat' => 'actions'),
    'acl_f_subscribe'	=> array('lang' => 'Can Subscribe to Forum\'s', 'cat' => 'actions'),
    'acl_f_print'		=> array('lang' => 'Can Print Topics', 'cat' => 'actions'),
    'acl_f_email'		=> array('lang' => 'Can email Topics', 'cat' => 'actions'),

    'acl_f_search'		=> array('lang' => 'Can Search the Forum\'s', 'cat' => 'misc'),
    'acl_f_ignoreflood' => array('lang' => 'Can Ignore the Flood Limit', 'cat' => 'misc'),
    'acl_f_postcount'	=> array('lang' => 'Increment Post Counter<br /><em>Please Note that this Setting ONLY affects New Posts.</em>', 'cat' => 'misc'),

    'acl_f_noapprove'	=> array('lang' => 'Can Post Without Approval', 'cat' => 'misc'),
));

// Moderator Permissions
$lang = array_merge($lang, array(
    'acl_m_edit'      => array('lang' => 'Can Edit Posts', 'cat' => 'post_actions'),
    'acl_m_delete'    => array('lang' => 'Can Delete Posts', 'cat' => 'post_actions'),
    'acl_m_approve'   => array('lang' => 'Can Approve Posts', 'cat' => 'post_actions'),
    'acl_m_report'    => array('lang' => 'Can Close and Delete Reports', 'cat' => 'post_actions'),
    'acl_m_chgposter' => array('lang' => 'Can Change Post Author', 'cat' => 'post_actions'),

    'acl_m_move'      => array('lang' => 'Can Move Topics', 'cat' => 'topic_actions'),
    'acl_m_lock'      => array('lang' => 'Can Lock Topics', 'cat' => 'topic_actions'),
    'acl_m_split'     => array('lang' => 'Can Split Topics', 'cat' => 'topic_actions'),
    'acl_m_merge'     => array('lang' => 'Can Merge Topics', 'cat' => 'topic_actions'),

    'acl_m_info'      => array('lang' => 'Can View Post Details', 'cat' => 'misc'),
    'acl_m_warn'      => array('lang' => 'Can Issue Warnings<br /><em>This Setting is ONLY Assigned Globally. It is NOT Forum Based.</em>', 'cat' => 'misc'), // This Moderator Setting is Only Global (and NOT Local)

    'acl_m_ban'       => array('lang' => 'Can Manage Bans<br /><em>This Setting is ONLY Assigned Globally. It is NOT Forum Based.</em>', 'cat' => 'misc'), // This Moderator Setting is Only Global (and NOT Local)
));

// Administrator Permissions
$lang = array_merge($lang, array(
    'acl_a_board'           => array('lang' => 'Can Alter Board Settings/Check for Updates', 'cat' => 'settings'),
    'acl_a_server'          => array('lang' => 'Can Alter Server/Communication Settings', 'cat' => 'settings'),
    'acl_a_jabber'          => array('lang' => 'Can Alter Jabber Settings', 'cat' => 'settings'),
    'acl_a_phpinfo'         => array('lang' => 'Can View php Settings', 'cat' => 'settings'),

    'acl_a_forum'           => array('lang' => 'Can Manage Forums', 'cat' => 'forums'),
    'acl_a_forumadd'        => array('lang' => 'Can Add New Forums', 'cat' => 'forums'),
    'acl_a_forumdel'        => array('lang' => 'Can Delete Forums', 'cat' => 'forums'),
    'acl_a_prune'           => array('lang' => 'Can Prune Forums', 'cat' => 'forums'),

    'acl_a_icons'           => array('lang' => 'Can Alter Topic/Post Icons and Smilies', 'cat' => 'posting'),
    'acl_a_words'           => array('lang' => 'Can Alter Word Censors', 'cat' => 'posting'),
    'acl_a_bbcode'          => array('lang' => 'Can Define BBCode Tags', 'cat' => 'posting'),
    'acl_a_attach'          => array('lang' => 'Can Alter Attachment Related Settings', 'cat' => 'posting'),

    'acl_a_user'            => array('lang' => 'Can Manage Users<br /><em>This also includes seeing the Users Browser Agent within the View Online List.</em>', 'cat' => 'user_group'),

    'acl_a_userdel'         => array('lang' => 'Can Delete/Prune Users', 'cat' => 'user_group'),
    'acl_a_group'           => array('lang' => 'Can Manage Groups', 'cat' => 'user_group'),
    'acl_a_groupadd'        => array('lang' => 'Can Add New Groups', 'cat' => 'user_group'),
    'acl_a_groupdel'        => array('lang' => 'Can Delete Groups', 'cat' => 'user_group'),
    'acl_a_ranks'           => array('lang' => 'Can Manage Ranks', 'cat' => 'user_group'),
    'acl_a_profile'         => array('lang' => 'Can Manage Custom Profile Fields', 'cat' => 'user_group'),
    'acl_a_names'           => array('lang' => 'Can Manage Disallowed Names', 'cat' => 'user_group'),
    'acl_a_ban'             => array('lang' => 'Can Manage Bans', 'cat' => 'user_group'),

    'acl_a_viewauth'        => array('lang' => 'Can View Permission Masks', 'cat' => 'permissions'),
    'acl_a_authgroups'      => array('lang' => 'Can Alter Permissions for Individual Groups', 'cat' => 'permissions'),
    'acl_a_authusers'       => array('lang' => 'Can Alter Permissions for Individual Users', 'cat' => 'permissions'),
    'acl_a_fauth'           => array('lang' => 'Can Alter Permissions for Forum Class', 'cat' => 'permissions'),
    'acl_a_mauth'           => array('lang' => 'Can Alter Permissions for Moderator Class', 'cat' => 'permissions'),
    'acl_a_aauth'           => array('lang' => 'Can Alter Permissions for Administrator Class', 'cat' => 'permissions'),
    'acl_a_uauth'           => array('lang' => 'Can Alter Permissions for User Class', 'cat' => 'permissions'),
    'acl_a_roles'           => array('lang' => 'Can Manage Roles', 'cat' => 'permissions'),
    'acl_a_switchperm'      => array('lang' => 'Can Use Others Permissions', 'cat' => 'permissions'),

    'acl_a_styles'          => array('lang' => 'Can Manage Styles', 'cat' => 'misc'),
    'acl_a_viewlogs'        => array('lang' => 'Can View Logs', 'cat' => 'misc'),
    'acl_a_clearlogs'       => array('lang' => 'Can Clear Logs', 'cat' => 'misc'),
    'acl_a_modules'         => array('lang' => 'Can Manage Modules', 'cat' => 'misc'),
    'acl_a_language'        => array('lang' => 'Can Manage Language Packs', 'cat' => 'misc'),
    'acl_a_email'           => array('lang' => 'Can Send Mass email', 'cat' => 'misc'),
    'acl_a_bots'            => array('lang' => 'Can Manage BOTS', 'cat' => 'misc'),
    'acl_a_reasons'         => array('lang' => 'Can Manage Report/Denial Reasons', 'cat' => 'misc'),
    'acl_a_backup'          => array('lang' => 'Can Backup/Restore Database', 'cat' => 'misc'),
    'acl_a_search'          => array('lang' => 'Can Manage Search Backend and Settings', 'cat' => 'misc'),
    'acl_a_cache_dir'       => array('lang' => 'Can Manage Cache', 'cat' => 'misc'),
    'acl_a_cache_settings'  => array('lang' => 'Can Alter Cache Settings', 'cat' => 'misc'),
    'acl_a_cache_time_sql'  => array('lang' => 'Can Manage Cache Times', 'cat' => 'misc'),
    'acl_a_cache_time_tmpl' => array('lang' => 'Can Alter Cache Time Settings', 'cat' => 'misc'),

));
$lang['permission_cat']['arcade'] = 'Arcade';

// Adding the Permissions
$lang = array_merge($lang, array(
    'acl_a_arcade_settings'       => array('lang' => 'Can Change Arcade Settings', 'cat' => 'arcade'),
    'acl_a_arcade_manage'         => array('lang' => 'Can Manage Arcade Games and Categories', 'cat' => 'arcade'),
    'acl_a_arcade_highscores'     => array('lang' => 'Can Manage Arcade Highscores', 'cat' => 'arcade'),

    'acl_m_arcade_comments'       => array('lang' => 'Can Manage Arcade Comments', 'cat' => 'arcade'),

    'acl_u_arcade_view_arcade'    => array('lang' => 'Can View the Arcade', 'cat' => 'arcade'),
    'acl_u_arcade_play_games'     => array('lang' => 'Can Play Games in the Arcade', 'cat' => 'arcade'),
    'acl_u_arcade_increase_views' => array('lang' => 'Increase Views on Games', 'cat' => 'arcade'),
    'acl_u_arcade_comment'        => array('lang' => 'Can Comment on Games', 'cat' => 'arcade'),
    'acl_u_arcade_favorites'      => array('lang' => 'Can have Favourite Games', 'cat' => 'arcade'),
    'acl_u_arcade_rating'         => array('lang' => 'Can Rate the Games', 'cat' => 'arcade'),
    'acl_u_arcade_stats'          => array('lang' => 'Can see Arcade Statistics', 'cat' => 'arcade'),
));
?>