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
** File acp_permissions/english.php 2018-09-15 07:49:00 Thor
**
** CHANGES
**
** 2018-02-23 - Added New Masthead
** 2018-02-23 - Added New !defined('IN_PMBT')
** 2018-02-23 - Fixed Spelling
** 2018-03-28 - Amended the Wording of some Sentences
** 2018-03-28 - Amended !defined('IN_PMBT') Corrected Path
** 2018-04-14 - Added Missing Languages
** 2018-04-14 - Amended !defined('IN_PMBT') New Version
** 2018-07-05 - Amended the Wording of some Sentences and Spell Checked
** 2018-07-05 - Added Missing Language
**/

if (!defined('IN_PMBT'))
{
    require_once($_SERVER['DOCUMENT_ROOT'].'/security.php');
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'ACP_PERMISSIONS_EXPLAIN' => '<p>Permissions are Grouped into Four Major Sections:</p>

    <h2>Global Permissions</h2>
    <p>These are used to Control Access on a Global Level and Apply to the Entire Site.  They are further divided into Users\' Permissions, Groups Permissions, Global Moderators and Administrators.</p>

    <h2>Forum Based Permissions</h2>
    <p>These are used to Control Access on a per Forum Basis.  They are further divided into Forum Permissions, Forum Moderators, Users Forum Permissions and Groups Forum Permissions.</p>

    <h2>Permission Roles</h2>
    <p>These are used to Create different Sets of Permissions for the different Permission Types, later being able to be Assigned on a Role Based Basis.  The Default Roles should cover the Administration of Sites of any size.  Within each of the Four Divisions, you can Add/Edit/Delete Roles as you see fit.</p>

    <h2>Permission Masks</h2>
    <p>These are used to View the Effective Permissions Assigned to Users, Moderators (Local and Global), Administrators or Forums.</p><br />

    <p>For further Information on Setting Up and Managing Permissions on your phpBB3 Board, please see <a href="http://www.phpbb.com/support/documentation/3.0/quickstart/quick_permissions.html">Chapter 1.5 of our Quick Start Guide</a>.</p>
    ',

    'ACL_NEVER'          => 'Never',
    'FORUMS'             => 'Forums',
    'SELECT_ANONYMOUS'   => 'Select Anonymous User',
    'FIND_USERNAME'      => 'Find a Member',
    'ACL_SET'            => 'Setting Permissions',

    'ACL_SET_EXPLAIN'    => 'Permissions are based on a Simple YES/NO System. Setting an Option to NEVER for a User or Usergroup Overrides any other Value Assigned to it. If you DO NOT wish to Assign a Value for an Option for this User or Group Select NO.  If Values are Assigned to this Option elsewhere they will be Used in Preference, else NEVER is assumed.  ALL Objects Marked (with the checkbox in front of them) will Copy the Permission Set you Defined.',

    'ACL_SETTING'        => 'Setting',

    'ACL_TYPE_A_'        => 'Administrator Permissions',
    'ACL_TYPE_F_'        => 'Forum Permissions',
    'ACL_TYPE_M_'        => 'Moderator Permissions',
    'ACL_TYPE_U_'        => 'User Permissions',

    'ACL_TYPE_GLOBAL_A_' => '<em>Administrator Permissions</em>',
    'ACL_TYPE_GLOBAL_U_' => '<em>User Permissions</em>',
    'ACL_TYPE_GLOBAL_M_' => '<em>Global Moderator Permissions</em>',
    'ACL_TYPE_LOCAL_M_'  => '<em>Forum Moderator Permissions</em>',
    'ACL_TYPE_LOCAL_F_'  => '<em>Forum Permissions</em>',

    'ACL_NO'             => 'No',
    'ACL_YES'            => 'Yes',
    'ACL_VIEW'           => 'Viewing Permissions',

    'ACL_VIEW_EXPLAIN' => 'Here you can see the Effective Permissions that the User/Group has.  A Green Square Indicates that the User/Group DOES have the Permission.  A Pink Square Indicates that the User/Group DOES NOT have the Permission.  A Red Square Indicates that the User/Group NEVER has Permission.',

    'ACP_ADMINISTRATORS_EXPLAIN'    => 'Here you can Assign Administrator Permissions to Users or Groups.  ALL Users with Administrator Permissions can View the Administration Control Panel.',

    'ACP_FORUM_MODERATORS_EXPLAIN'  => 'Here you can Assign Users and Groups as Forum Moderators.  To Assign Users to Forums, Define Global Moderator Permissions or Administrators, please use the appropriate page.<br /><br />',

    'ACP_FORUM_PERMISSIONS_EXPLAIN' => 'Here you can Assign which Users or Groups can Access which Forums.  To Assign Moderators or Define Administrators, please use the appropriate page.<br /><br />',

    'ACP_FORUM_PERMISSIONS_COPY_EXPLAIN'   => 'Here you can Copy Forum Permissions from one Forum to one or more other Forums.',

    'ACP_GLOBAL_MODERATORS_EXPLAIN'        => 'Here you can Assign Global Moderator Permissions to Users or Groups.  These Moderators are like ordinary Moderators except they have Access to Every Forum on your Board.',

    'ACP_GROUPS_FORUM_PERMISSIONS_EXPLAIN' => 'Here you can Assign Forum Permissions to Groups.',

    'ACP_GROUPS_PERMISSIONS_EXPLAIN'       => 'Here you can Assign Global Permissions to Groups - User Permissions, Global Moderator Permissions and Administrator Permissions.<br /><br /><ul><li>User Permissions include the ability to use Avatars, Send Private Messages etc. <li>Global Moderator Permissions include the ability to Approve Posts, Manage Topics, Manage Bans etc.<li>Administrator Permissions include the ability to Alter Permissions, Define Custom BBCodes, Manage Forums etc.</ul><br />Individual User Permissions should ONLY be changed in rare occasions, the preferred method is putting Users in Groups and assigning the Groups Permissions.<br /><br />',

    'ACP_ADMIN_ROLES_EXPLAIN' => 'Here you can Manage the Roles for Administrator Permissions.  Roles are Effective Permissions.  Any Users that are Assigned to this Role will have their Permissions Changed.<br /><br />',

    'ACP_FORUM_ROLES_EXPLAIN' => 'Here you can Manage the Roles for Forum Permissions.  Roles are Effective Permissions.  Any Users that are Assigned to this Role will have their Permissions Changed.<br /><br />',

    'ACP_MOD_ROLES_EXPLAIN'   => 'Here you can Manage the Roles for Moderator Permissions.  Roles are Effective Permissions.  Any Users that are Assigned to this Role will have their Permissions Changed.<br /><br />',

    'ACP_USER_ROLES_EXPLAIN'  => 'Here you can Manage the Roles for User Permissions.  Roles are Effective Permissions.  Any Users that are Assigned to this Role will have their Permissions Changed.<br /><br />',

    'ACP_USERS_FORUM_PERMISSIONS'          => 'Users Forum Permissions',
    'ACP_GROUPS_FORUM_PERMISSIONS'         => 'Groups Forum Permissions',
    'ACP_USERS_FORUM_PERMISSIONS_EXPLAIN'  => 'Here you can Assign Forum Permissions to Users.<br /><br />',
    'ACP_GROUPS_FORUM_PERMISSIONS_EXPLAIN' => 'Here you can Assign Forum Permissions to Groups.<br /><br />',

    'ACP_USERS_PERMISSIONS_EXPLAIN' => 'Here you can Assign Global Permissions to Groups - User Permissions, Global Moderator Permissions and Administrator Permissions.<br /><br /><ul><li>User Permissions include the ability to use Avatars, Send Private Messages etc. <li>Global Moderator Permissions include the ability to Approve Posts, Manage Topics, Manage Bans etc.<li>Administrator Permissions include the ability to Alter Permissions, Define Custom BBCodes, Manage Forums etc.</ul><br />Individual User Permissions should ONLY be changed in Rare Occasions.  The Preferred Method is to put Users in Groups and Assigning the Groups Permissions.<br /><br />',

    'ACP_GROUPS_PERMISSIONS_EXPLAIN' => 'Here you can Assign Global Permissions to Groups - User Permissions, Global Moderator Permissions and Administrator Permissions.<br /><br /><ul><li>User Permissions include the ability to use Avatars, Send Private Messages etc. <li>Global Moderator Permissions include the ability to Approve Posts, Manage Topics, Manage Bans etc.<li>Administrator Permissions include the ability to Alter Permissions, Define Custom BBCodes, Manage Forums etc.</ul><br />Individual User Permissions should ONLY be changed in Rare Occasions.  The Preferred Method is to put Users in Groups and Assigning the Groups Permissions.<br /><br />',

    'ACP_VIEW_ADMIN_PERMISSIONS_EXPLAIN'      => 'Here you can View the Administrator Permissions Assigned to the Selected Users/Groups.',

    'ACP_VIEW_GLOBAL_MOD_PERMISSIONS_EXPLAIN' => 'Here you can View the Global Moderator Permissions Assigned to the Selected Users/Groups.',

    'ACP_VIEW_FORUM_MOD_PERMISSIONS' => 'View Forum Moderator Permissions',
    'ACP_VIEW_FORUM_PERMISSIONS'     => 'View Forum Based Permissions',
    'ACP_FORUM_BASED_PERMISSIONS'    => 'Forum Based Permissions',
    'ACP_FORUM_LOGS'                 => 'Forum Logs',
    'ACP_FORUM_MANAGEMENT'           => 'Forum Management',
    'ACP_FORUM_MODERATORS'           => 'Forum Moderators',
    'ACP_FORUM_PERMISSIONS'          => 'Forum Permissions',
    'ACP_FORUM_ROLES'                => 'Forum Roles',
    'ACP_ADMIN_ROLES'                => 'Administrator Roles',
    'ACP_MOD_ROLES'                  => 'Moderator Roles',
    'ACP_USER_ROLES'                 => 'User Roles',

    'ACP_VIEW_FORUM_PERMISSIONS_EXPLAIN'     => 'Here you can View the Forum Permissions Assigned to the Selected Users/Groups and Forums.',

    'ACP_VIEW_FORUM_MOD_PERMISSIONS_EXPLAIN' => 'Here you can View the Forum Moderator Permissions Assigned to the Selected Users/Groups and Forums.',

    'ACP_VIEW_USER_PERMISSIONS_EXPLAIN'      => 'Here you can View the User Permissions Assigned to the Selected Users/Groups.',

    'ADD_GROUPS'            => 'Add Groups',
    'ADD_PERMISSIONS'       => 'Add Permissions',
    'ADD_USERS'             => 'Add Users',
    'ADVANCED_PERMISSIONS'  => 'Advanced Permissions',
    'ALL_GROUPS'            => 'Select ALL Groups',
    'ALL_NEVER'             => 'ALL <strong>NEVER</strong>',
    'ALL_NO'                => 'ALL <strong>NO</strong>',
    'ALL_USERS'             => 'Select ALL Users',
    'ALL_YES'               => 'ALL <strong>YES</strong>',
    'APPLY_ALL_PERMISSIONS' => 'Apply ALL Permissions',
    'APPLY_PERMISSIONS'     => 'Apply Permissions',

    'APPLY_PERMISSIONS_EXPLAIN' => 'The Permissions and Roles Defined for this Item will Only be Applied to this Item and ALL Checked Items.',

    'AUTH_UPDATED'        => 'Permissions have been Updated.',

    'Copy_permissions_confirm'            => 'Are you sure you wish to carry out this Operation?  Please be aware that this will Overwrite any Existing Permissions on the Selected Targets.',

    'COPY_PERMISSIONS_FORUM_FROM_EXPLAIN' => 'The Source Forum you want to Copy Permissions from.',
    'COPY_PERMISSIONS_FORUM_TO_EXPLAIN'   => 'The Destination Forums you want the Copied Permissions Applied to.',
    'COPY_PERMISSIONS_FROM'               => 'Copy Permissions from',
    'COPY_PERMISSIONS_TO'                 => 'Apply Permissions to',

    'CREATE_ROLE'         => 'Create a Role',
    'CREATE_ROLE_FROM'    => 'Use Settings from?',
    'CUSTOM'              => 'Custom?',

    'DEFAULT'             => 'Default',
    'DELETE_ROLE'         => 'Delete Role',

    'DELETE_ROLE_CONFIRM' => 'Are you sure you want to Remove this Role?  Items having this Role Assigned will <strong>NOT</strong> Loose their Permission Settings.',

    'DISPLAY_ROLE_ITEMS'  => 'View Items using this Role',

    'EDIT_PERMISSIONS'    => 'Edit Permissions',
    'EDIT_ROLE'           => 'Edit Role',

    'GROUPS_NOT_ASSIGNED' => 'No Group Assigned to this Role',

    'LOOK_UP_GROUP'       => 'Look up Usergroup',
    'LOOK_UP_USER'        => 'Look up User',

    'MANAGE_GROUPS'       => 'Manage Groups',
    'MANAGE_USERS'        => 'Manage Users',

    'NO_AUTH_SETTING_FOUND'     => 'Permission Settings NOT Defined.',
    'NO_ROLE_ASSIGNED'          => 'No Role Assigned?',

    'NO_ROLE_ASSIGNED_EXPLAIN'  => 'Setting this Role DOES NOT Change the Permissions on the Right.  If you want to Unset/Remove ALL Permissions you should use the ALL <strong>NO</strong> Link.',

    'NO_ROLE_AVAILABLE'      => 'No Role Available',
    'NO_ROLE_NAME_SPECIFIED' => 'Please give the Role a Name.',
    'NO_ROLE_SELECTED'       => 'Role Could NOT be Found.',
    'NO_USER_GROUP_SELECTED' => 'You haven\'t Selected any User or Group.',

    'ONLY_FORUM_DEFINED'     => 'You Only Defined Forums in your Selection.  Please also Select at least One User or One Group.',

    'PERMISSION_APPLIED_TO_ALL' => 'Permissions and Roles will also be Applied to ALL Checked Objects',
    'PLUS_SUBFORUMS'            => '+Subforums',

    'USERNAMES_EXPLAIN'        => 'Place each Username on a Separate Line.',
    'REMOVE_PERMISSIONS'       => 'Remove Permissions',
    'REMOVE_ROLE'              => 'Remove Role',
    'RESULTING_PERMISSION'     => 'Resulting Permission',
    'ROLE'                     => 'Role',
    'ROLE_ADD_SUCCESS'         => 'Role Successfully Added.',
    'ROLE_ASSIGNED_TO'         => 'Users/Groups Assigned to %s',
    'ROLE_DELETED'             => 'Role Successfully Removed.',
    'ROLE_DESCRIPTION'         => 'Role Description',
    'ROLE_ADMIN_FORUM'         => 'Forum Administrator',
    'ROLE_ADMIN_FULL'          => 'Full Administrator',
    'ROLE_ADMIN_STANDARD'      => 'Standard Administrator',
    'ROLE_ADMIN_USERGROUP'     => 'User and Groups Administrator',
    'ROLE_FORUM_BOT'           => 'BOT Access',
    'ROLE_FORUM_FULL'          => 'Full Access',
    'ROLE_FORUM_LIMITED'       => 'Limited Access',
    'ROLE_FORUM_LIMITED_POLLS' => 'Limited Access + Polls',
    'ROLE_FORUM_NOACCESS'      => 'No Access',
    'ROLE_FORUM_ONQUEUE'       => 'On Moderation Queue',
    'ROLE_FORUM_POLLS'         => 'Standard Access + Polls',
    'ROLE_FORUM_READONLY'      => 'Read Only Access',
    'ROLE_FORUM_STANDARD'      => 'Standard Access',
    'ROLE_FORUM_NEW_MEMBER'    => 'Newly Registered User',
    'ROLE_MOD_FULL'            => 'Full Moderator',
    'ROLE_MOD_QUEUE'           => 'Queue Moderator',
    'ROLE_MOD_SIMPLE'          => 'Simple Moderator',
    'ROLE_MOD_STANDARD'        => 'Standard Moderator',
    'ROLE_USER_FULL'           => 'ALL Features',
    'ROLE_USER_LIMITED'        => 'Limited Features',
    'ROLE_USER_NOAVATAR'       => 'No Avatar',
    'ROLE_USER_NOPM'           => 'No Private Messages',
    'ROLE_USER_STANDARD'       => 'Standard Features',
    'ROLE_USER_NEW_MEMBER'     => 'Newly Registered User',

    'ROLE_DESCRIPTION_ADMIN_FORUM'     => 'Can Access the Forum Management and Forum Permission Settings.',
    'ROLE_DESCRIPTION_ADMIN_FULL'      => 'Has Access to ALL Administrator Features of this Board.<br />NOT Recommended.',

    'ROLE_DESCRIPTION_ADMIN_STANDARD'  => 'Has Access to Most Administrator Features but, is NOT Allowed to use Server or System Related Tools.',

    'ROLE_DESCRIPTION_ADMIN_USERGROUP' => 'Can Manage Groups and Users and is able to Change Permissions, Settings, Manage Bans, and Manage Ranks.',

    'ROLE_DESCRIPTION_FORUM_BOT'       => 'This Role is Recommended for BOTS and Search Spiders.',

    'ROLE_DESCRIPTION_FORUM_FULL'      => 'Can Use ALL Forum Features, Including Posting of Announcements and Stickies.  Can also Ignore the Flood Limit.<br />NOT Recommended for Normal Users.',

    'ROLE_DESCRIPTION_FORUM_LIMITED'       => 'Can use some Forum Features, but can NOT Attach Files or use Post Icons.',
    'ROLE_DESCRIPTION_FORUM_LIMITED_POLLS' => 'As per Limited Access but can also Create Polls.',
    'ROLE_DESCRIPTION_FORUM_NOACCESS'      => 'Can NOT View or Access the Forum.',

    'ROLE_DESCRIPTION_FORUM_ONQUEUE'    => 'Can use most Forum Features Including Attachments, but Posts and Topics need to be Approved by a Moderator.',

    'ROLE_DESCRIPTION_FORUM_POLLS'      => 'Like Standard Access but can also Create Polls.',
    'ROLE_DESCRIPTION_FORUM_READONLY'   => 'Can Read the Forum, but can NOT Create New Topics or Reply to Posts.',

    'ROLE_DESCRIPTION_FORUM_STANDARD'   => 'Can use most Forum Features Including Attachments and Delete their Own Topics, but can NOT Lock their Own Topics, and can NOT Create Polls.',

    'ROLE_DESCRIPTION_FORUM_NEW_MEMBER' => 'A Role for Members of the Special Newly Registered Users Group; contains NEVER Permissions to Lock Features for New Users.',

    'ROLE_DESCRIPTION_MOD_FULL'        => 'Can use ALL Moderating Features, Including Banning.',
    'ROLE_DESCRIPTION_MOD_QUEUE'       => 'Can use the Moderation Queue to Validate and Edit Posts, but nothing else.',

    'ROLE_DESCRIPTION_MOD_SIMPLE'      => 'Can Only use Basic Topic Actions but, can NOT Send Warnings or Use the Moderation Queue.',

    'ROLE_DESCRIPTION_MOD_STANDARD'    => 'Can use most Moderating Tools, but can NOT Ban Users or Change the Post Author.',

    'ROLE_DESCRIPTION_USER_FULL'       => 'Can use ALL Available Forum Features for Users, Including Changing the User Name and Ignore The Flood Limit.<br />NOT Recommended.',

    'ROLE_DESCRIPTION_USER_LIMITED'    => 'Can Access some of the User Features but, NOT Attachments, emails or Instant Messages.',
    'ROLE_DESCRIPTION_USER_NOAVATAR'   => 'Has a Limited Feature Set, but is NOT Allowed to use the Avatar Feature.',
    'ROLE_DESCRIPTION_USER_NOPM'       => 'Has a Limited Feature Set, but is NOT Allowed to use Private Messages.',

    'ROLE_DESCRIPTION_USER_STANDARD'   => 'Can Access most of the User Features but can NOT Change User Name or Ignore the Flood Limit.',

    'ROLE_DESCRIPTION_USER_NEW_MEMBER' => 'A Role for Members of the Special Newly Registered Users Group; contains NEVER Permissions to Lock Function for New Users.',

    'ROLE_DESCRIPTION_EXPLAIN'         => 'You are able to Enter a Short Explanation of what the Role is doing or for what it is meant for.  The Text you Enter here will be Displayed within the Permissions Screens.',

    'ROLE_DESCRIPTION_LONG'   => 'The Role Description is Too Long.  Limit is 4000 Characters.',
    'ROLE_DETAILS'            => 'Role Details',
    'ROLE_EDIT_SUCCESS'       => 'Role Successfully Edited.',
    'ROLE_NAME'               => 'Role Name',
    'ROLE_NAME_ALREADY_EXIST' => 'A Role Named <strong>%s</strong> Already Exists for the Specified Permission Type.',
    'ROLE_NOT_ASSIGNED'       => 'Role has NOT been Assigned yet.',

    'SELECTED_FORUM_NOT_EXIST'      => 'The Selected Forum(s) DO NOT Exist.',
    'SELECTED_GROUP_NOT_EXIST'      => 'The Selected Group(s) DO NOT Exist.',
    'SELECTED_USER_NOT_EXIST'       => 'The Selected User(s) DO NOT Exist.',
    'SELECT_FORUM_SUBFORUM_EXPLAIN' => 'The Forum you Select here will Include ALL Subforums in the Selection.',
    'SELECT_ROLE'                   => 'Select Role',
    'SELECT_TYPE'                   => 'Select Type',
    'SET_PERMISSIONS'               => 'Set Permissions',
    'SET_ROLE_PERMISSIONS'          => 'Set Role Permissions',
    'SET_USERS_PERMISSIONS'         => 'Set User Permissions',
    'SET_USERS_FORUM_PERMISSIONS'   => 'Set User Forum Permissions',

    'LOOK_UP_FORUM'          => 'Select a Forum',
    'ALL_FORUMS'             => 'ALL Forums',
    'LOOK_UP_FORUMS_EXPLAIN' => 'You are able to Select More than One Forum.',

    'TRACE_DEFAULT'        => 'By Default Every Permission is <strong>NO</strong> (Unset).  The Permission can be Overwritten by Other Settings.',

    'TRACE_FOR'            => 'Trace for',
    'TRACE_GLOBAL_SETTING' => '%s (Global)',

    'TRACE_GROUP_NEVER_TOTAL_NEVER'       => 'The Groups Permission is Set to <strong>NEVER</strong> like the Total Result so the Old Result is Kept.',

    'TRACE_GROUP_NEVER_TOTAL_NEVER_LOCAL' => 'The Groups Permission for this Forum is Set to <strong>NEVER</strong> like the Total Result so the Old Result is Kept.',

    'TRACE_GROUP_NEVER_TOTAL_NO'          => 'The Groups Permission is Set to <strong>NEVER</strong> which becomes the New Total Value because it hasn\'t been Set Yet (Set to <strong>NO</strong>).',

    'TRACE_GROUP_NEVER_TOTAL_NO_LOCAL'    => 'The Groups Permission for this Forum is Set to <strong>NEVER</strong> which becomes the New Total Value because it hasn\'t been Set yet (Set to <strong>NO</strong>).',

    'TRACE_GROUP_NEVER_TOTAL_YES'         => 'The Groups Permission is Set to <strong>NEVER</strong> which Overwrites the Total <strong>YES</strong> to a <strong>NEVER</strong> for this User.',

    'TRACE_GROUP_NEVER_TOTAL_YES_LOCAL'   => 'The Groups Permission for this Forum is Set to <strong>NEVER</strong> which Overwrites the Total <strong>YES</strong> to a <strong>NEVER</strong> for this User.',

    'TRACE_GROUP_NO'              => 'The Permission is <strong>NO</strong> for this Group so the Old Total Value is Kept.',

    'TRACE_GROUP_NO_LOCAL'        => 'The Permission is <strong>NO</strong> for this Group within this Forum so the Old Total Value is Kept.',

    'TRACE_GROUP_YES_TOTAL_NEVER' => 'The Groups Permission is Set to <strong>YES</strong> but the Total <strong>NEVER</strong> can NOT be Overwritten.',

    'TRACE_GROUP_YES_TOTAL_NEVER_LOCAL' => 'The Groups Permission for this Forum is Set to <strong>YES</strong> but the Total <strong>NEVER</strong> can NOT be Overwritten.',

    'TRACE_GROUP_YES_TOTAL_NO'          => 'The Groups Permission is Set to <strong>YES</strong> which becomes the New Total Value because it hasn\'t been Set yet (Set to <strong>NO</strong>).',

    'TRACE_GROUP_YES_TOTAL_NO_LOCAL'    => 'The Groups Permission for this Forum is Set to <strong>YES</strong> which becomes the New Total Value because it hasn\'t been Set yet (Set to <strong>NO</strong>).',

    'TRACE_GROUP_YES_TOTAL_YES'         => 'The Groups Permission is Set to <strong>YES</strong> and the Total Permission is Already Set to <strong>YES</strong>, so the Total Result is Kept.',

    'TRACE_GROUP_YES_TOTAL_YES_LOCAL'   => 'The Groups Permission for this Forum is Set to <strong>YES</strong> and the Total Permission is Already Set to <strong>YES</strong>, so the Total Result is Kept.',

    'TRACE_PERMISSION' => 'Trace Permission - %s',
    'TRACE_RESULT'     => 'Trace Result',
    'TRACE_SETTING'    => 'Trace Setting',

    'TRACE_USER_GLOBAL_YES_TOTAL_YES'    => 'The Forum Independent User Permission Evaluates to <strong>YES</strong> but the Total Permission is Already Set to <strong>YES</strong>, so the Total Result is Kept.  Trace Global Permission',

    'TRACE_USER_GLOBAL_YES_TOTAL_NEVER'  => 'The Forum Independent User Permission Evaluates to <strong>YES</strong> which Overwrites the Current Local Result <strong>NEVER</strong>.  Trace Global Permission',

    'TRACE_USER_GLOBAL_NEVER_TOTAL_KEPT' => 'The Forum Independent User Permission Evaluates to <strong>NEVER</strong> which doesn\'t Influence the Local Permission.  Trace Global Permission',

    'TRACE_USER_FOUNDER'    => 'The User has the Founder Type Set, therefore Administrator Permissions are Set to <strong>YES</strong> by Default.',

    'TRACE_USER_KEPT'       => 'The Users Permission is <strong>NO</strong> so the Old Total Value is Kept.',
    'TRACE_USER_KEPT_LOCAL' => 'The Users Permission for this Forum is <strong>NO</strong> so the Old Total Value is Kept.',

    'TRACE_USER_NEVER_TOTAL_NEVER'       => 'The Users Permission is Set to <strong>NEVER</strong> and the Total Value is Set to <strong>NEVER</strong>, so nothing is changed.',

    'TRACE_USER_NEVER_TOTAL_NEVER_LOCAL' => 'The Users Permission for this Forum is Set to <strong>NEVER</strong> and the Total Value is Set to <strong>NEVER</strong>, so nothing is changed.',

    'TRACE_USER_NEVER_TOTAL_NO'          => 'The Users Permission is Set to <strong>NEVER</strong> which becomes the Total Value because it was Set to NO.',

    'TRACE_USER_NEVER_TOTAL_NO_LOCAL'    => 'The Users Permission for this Forum is Set to <strong>NEVER</strong> which becomes the Total Value because it was Set to NO.',

    'TRACE_USER_NEVER_TOTAL_YES'         => 'The Users Permission is Set to <strong>NEVER</strong> and Overwrites the previous <strong>YES</strong>.',

    'TRACE_USER_NEVER_TOTAL_YES_LOCAL'   => 'The Users Permission for this Forum is Set to <strong>NEVER</strong> and Overwrites the previous <strong>YES</strong>.',

    'TRACE_USER_NO_TOTAL_NO'             => 'The Users Permission is <strong>NO</strong> and the Total Value was Set to NO so it Defaults to <strong>NEVER</strong>.',

    'TRACE_USER_NO_TOTAL_NO_LOCAL'       => 'The Users Permission for this Forum is <strong>NO</strong> and the Total Value was Set to NO so it Defaults to <strong>NEVER</strong>.',

    'TRACE_USER_YES_TOTAL_NEVER'         => 'The Users Permission is Set to <strong>YES</strong> but the Total <strong>NEVER</strong> can NOT be Overwritten.',

    'TRACE_USER_YES_TOTAL_NEVER_LOCAL'   => 'The Users Permission for this Forum is Set to <strong>YES</strong> but the Total <strong>NEVER</strong> can NOT be Overwritten.',

    'TRACE_USER_YES_TOTAL_NO'            => 'The Users Permission is Set to <strong>YES</strong> which becomes the Total Value because it was Set to <strong>NO</strong>.',

    'TRACE_USER_YES_TOTAL_NO_LOCAL'      => 'The Users Permission for this Forum is Set to <strong>YES</strong> which becomes the Total Value because it was Set to <strong>NO</strong>.',

    'TRACE_USER_YES_TOTAL_YES'           => 'The Users Permission is Set to <strong>YES</strong> and the Total Value is set to <strong>YES</strong>, so nothing is changed.',

    'TRACE_USER_YES_TOTAL_YES_LOCAL'     => 'The Users Permission for this Forum is Set to <strong>YES</strong> and the Total Value is Set to <strong>YES</strong>, so nothing is changed.',

    'TRACE_WHO'                       => 'Who',
    'TRACE_TOTAL'                     => 'Total',

    'USERS_NOT_ASSIGNED'              => 'No User Assigned to this Role',
    'USER_IS_MEMBER_OF_DEFAULT'       => 'is a Member of the following Pre-Defined Groups',
    'USER_IS_MEMBER_OF_CUSTOM'        => 'is a Member of the following User-Defined Groups',

    'VIEW_ASSIGNED_ITEMS'             => 'View Assigned Items',
    'VIEW_LOCAL_PERMS'                => 'Local Permissions',
    'VIEW_GLOBAL_PERMS'               => 'Global Permissions',
    'VIEW_PERMISSIONS'                => 'View Permissions',

    'WRONG_PERMISSION_TYPE'           => 'Wrong Permission Type Selected.',

    'WRONG_PERMISSION_SETTING_FORMAT' => 'The Permission Settings are in the Wrong Format, phpBB is NOT able to process them correctly.',
));

$lang = array_merge($lang, array(
    'permission_cat' => array(
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
        'user_group'    => 'Users and Groups',
        'trac'          => 'Tracker',
        'arcade'        => 'Arcade',
    ),

    // With Defining 'Global' Here we are Able to Specify what is Printed Out, if the Permission is within the Global Scope.
    'permission_type' => array(
        'u_' => 'User Permissions',
        'a_' => 'Administrator Permissions',
        'm_' => 'Moderator Permissions',
        'f_' => 'Forum Permissions',
            'global' => array(
                'm_'     => 'Global Moderator Permissions',
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
    'acl_u_download_torrents' => array('lang' => 'Can Download Torrents', 'cat' => 'trac'),
));

// Forum Permissions
    $lang = array_merge($lang, array(
    'acl_f_list'        => array('lang' => 'Can View Forum', 'cat' => 'post'),
    'acl_f_read'        => array('lang' => 'Can Read Forum', 'cat' => 'post'),
    'acl_f_post'        => array('lang' => 'Can Start New Topics', 'cat' => 'post'),
    'acl_f_reply'       => array('lang' => 'Can Reply to Topics', 'cat' => 'post'),
    'acl_f_icons'       => array('lang' => 'Can Use Topic/Post Icons', 'cat' => 'post'),
    'acl_f_announce'    => array('lang' => 'Can Post Announcements', 'cat' => 'post'),
    'acl_f_sticky'      => array('lang' => 'Can Post Stickies', 'cat' => 'post'),

    'acl_f_poll'        => array('lang' => 'Can Create Polls', 'cat' => 'polls'),
    'acl_f_vote'        => array('lang' => 'Can Vote in Polls', 'cat' => 'polls'),
    'acl_f_votechg'     => array('lang' => 'Can Change Existing Vote', 'cat' => 'polls'),

    'acl_f_attach'      => array('lang' => 'Can Attach Files', 'cat' => 'content'),
    'acl_f_download'    => array('lang' => 'Can Download Files', 'cat' => 'content'),
    'acl_f_sigs'        => array('lang' => 'Can Use Signatures', 'cat' => 'content'),
    'acl_f_bbcode'      => array('lang' => 'Can Use BBCode', 'cat' => 'content'),
    'acl_f_smilies'     => array('lang' => 'Can Use Smilies', 'cat' => 'content'),
    'acl_f_img'         => array('lang' => 'Can Use Images', 'cat' => 'content'),
    'acl_f_flash'       => array('lang' => 'Can Use Flash', 'cat' => 'content'),

    'acl_f_edit'        => array('lang' => 'Can Edit their Own Posts', 'cat' => 'actions'),
    'acl_f_delete'      => array('lang' => 'Can Delete their Own Posts', 'cat' => 'actions'),
    'acl_f_user_lock'   => array('lang' => 'Can Lock their Own Topics', 'cat' => 'actions'),
    'acl_f_bump'        => array('lang' => 'Can Bump Topics', 'cat' => 'actions'),
    'acl_f_report'      => array('lang' => 'Can Report Posts', 'cat' => 'actions'),
    'acl_f_subscribe'   => array('lang' => 'Can Subscribe to Forum\'s', 'cat' => 'actions'),
    'acl_f_print'       => array('lang' => 'Can Print Topics', 'cat' => 'actions'),
    'acl_f_email'       => array('lang' => 'Can email Topics', 'cat' => 'actions'),

    'acl_f_search'      => array('lang' => 'Can Search the Forum\'s', 'cat' => 'misc'),
    'acl_f_ignoreflood' => array('lang' => 'Can Ignore the Flood Limit', 'cat' => 'misc'),

    'acl_f_postcount'   => array('lang' => 'Increment Post Counter<br /><em>Please Note that this Setting ONLY affects New Posts.</em>', 'cat' => 'misc'),

    'acl_f_noapprove'   => array('lang' => 'Can Post Without Approval', 'cat' => 'misc'),
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

    'acl_m_warn'      => array('lang' => 'Can Issue Warnings<br /><em>This Setting is ONLY Assigned Globally.  It is NOT Forum Based.</em>', 'cat' => 'misc'), // This Moderator Setting is Only Global (and NOT Local)

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

    'acl_a_user'            => array('lang' => 'Can Manage Users<br /><em>This also Includes Seeing the Users Browser Agent within the View Online List.</em>', 'cat' => 'user_group'),

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
    'acl_a_cache_dir'       => array('lang' => 'Can Manage Cache Directory', 'cat' => 'settings'),
    'acl_a_cache_settings'  => array('lang' => 'Can Alter Cache Settings', 'cat' => 'settings'),
    'acl_a_cache_time_sql'  => array('lang' => 'Can Manage Cache Data base Times Settings', 'cat' => 'settings'),
    'acl_a_cache_time_tmpl' => array('lang' => 'Can Manage Cache Theme Time Settings', 'cat' => 'settings'),

    #Updated Admin Access
    'acl_a_paypal'             => array('lang' => 'Can Manage PayPal Settings', 'cat' => 'settings'),
    'acl_a_irc'                => array('lang' => 'Can Manage IRC Settings', 'cat' => 'settings'),
    'acl_a_faq_manage'         => array('lang' => 'Can Manage FAQ\'s Settings', 'cat' => 'settings'),
    'acl_a_torrent_filter'     => array('lang' => 'Can Manage Torrent Upload Filters', 'cat' => 'trac'),
    'acl_a_torrent_clinic'     => array('lang' => 'Can Manage Torrent Clinic', 'cat' => 'trac'),
    'acl_a_client_ban'         => array('lang' => 'Can Ban Torrent Clients', 'cat' => 'trac'),
    'acl_a_torrent_categories' => array('lang' => 'Can Manage Torrent Categories', 'cat' => 'trac'),
    'acl_a_hit_and_run'        => array('lang' => 'Can Manage Hit and Run Settings', 'cat' => 'trac'),
    'acl_a_mass_message'       => array('lang' => 'Can Manage Mass Messaging', 'cat' => 'misc'),
    'acl_a_shouts'             => array('lang' => 'Can Manage Shoutbox Settings', 'cat' => 'settings'),
    'acl_a_shout_cast'         => array('lang' => 'Can Manage Shoutcast Settings', 'cat' => 'settings'),
    'acl_a_torrents'           => array('lang' => 'Can Manage Uploaded Torrents', 'cat' => 'trac'),
    'acl_a_smilies'            => array('lang' => 'Can Manage Smilies', 'cat' => 'settings'),
    'acl_a_trackers'           => array('lang' => 'Can Manage External Trackers', 'cat' => 'trac'),
    'acl_a_massupload'         => array('lang' => 'Can Use Mass Upload System', 'cat' => 'trac'),
    'acl_a_ratiowarn'          => array('lang' => 'Can Manage Ratio Warning System', 'cat' => 'trac'),
    'acl_a_search_cloud'       => array('lang' => 'Can Manage Search Cloud System', 'cat' => 'trac'),
    'acl_a_site_rules'         => array('lang' => 'Can Manage Rules Settings', 'cat' => 'settings'),
    'acl_a_bonus_system'       => array('lang' => 'Can Manage Bonus System', 'cat' => 'settings'),
));

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