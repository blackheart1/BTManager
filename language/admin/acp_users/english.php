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
** File acp_users/english.php 2018-09-15 09:40:00 Thor
**
** CHANGES
**
** 2018-02-23 - Added New Masthead
** 2018-02-23 - Added New !defined('IN_PMBT')
** 2018-02-23 - Fixed Spelling
** 2018-03-28 - Amended the Wording of some Sentences
** 2018-03-28 - Amended !defined('IN_PMBT') Corrected Path
** 2018-05-14 - Added Missing Language
**/

if (!defined('IN_PMBT'))
{
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'INTRO'                       => 'User Administration',
    'INTRO_EXP'                   => 'Manage Registered Users by Editing their Profile, Setting their Level or Banning them.',
    'SORT_USERNAME'               => 'User Name',
    'SORT_DATE'                   => 'Registered Date',
    'SORT_IP'                     => 'User IP',
    'SORT_ACTION'                 => 'Last Login',
    'DISPLAY_WARNED'              => 'Display Logins from previous',
    'DELETE_USER'                 => 'Delete User',
    'BAN_USER'                    => 'Ban User Account',
    'SEARCH_USER'                 => 'Search User',
    'SEARCH_IP'                   => 'Search IP',
    'SEARCH_HOST'                 => 'Search Host',
    'SEARCH_EMAIL'                => 'Search email',
    'SEARCH_DUPIP'                => 'Search for Duplicate IP\'s',
    'MANAGE_USERS'                => 'Manage Users',
    'ACP_UPDATE'                  => 'Updating',
    'ACP_USERS_FORUM_PERMISSIONS' => 'Users Forum Permissions',
    'ACP_USERS_LOGS'              => 'User Logs',
    'ACP_USERS_PERMISSIONS'       => 'User Permissions',
    'ACP_USER_ATTACH'             => 'Attachments',
    'ACP_USER_AVATAR'             => 'Avatar',
    'ACP_USER_FEEDBACK'           => 'Feedback',
    'ACP_USER_GROUPS'             => 'Groups',
    'ACP_USER_MANAGEMENT'         => 'User Management',
    'ACP_USER_OVERVIEW'           => 'Overview',
    'ACP_USER_PERM'               => 'Permissions',
    'ACP_USER_PREFS'              => 'Preferences',
    'ACP_USER_PROFILE'            => 'Profile',
    'ACP_USER_RANK'               => 'Rank',
    'ACP_USER_ROLES'              => 'User Roles',
    'ACP_USER_SECURITY'           => 'User Security',
    'ACP_USER_SIG'                => 'Signature',
    'INACTIVE_USERS'              => 'Inactive Users',
    'ADMIN_SIG_PREVIEW'           => 'Signature Preview',

    'AT_LEAST_ONE_FOUNDER'        => 'You are NOT Allowed to Change this Founder to a Normal User.  There Needs to be at least One Founder Enabled for this Board.  If you want to Change this Users Founder Status, Promote another User to be a Founder First.',

    'BAN_ALREADY_ENTERED'         => 'The Ban was Previously Entered Successfully.  The Ban List has NOT been Updated.',
    'BAN_SUCCESSFUL'              => 'Ban Entered Successfully.',

    'CANNOT_BAN_FOUNDER'          => 'You are NOT Allowed to Ban Founder Accounts.',
    'CANNOT_BAN_YOURSELF'         => 'You are NOT Allowed to Ban Yourself.',
    'CANNOT_DEACTIVATE_BOT'       => 'You are NOT Allowed to Deactivate BOT Accounts.  Please Deactivate the BOT within the BOTS Page instead.',

    'CANNOT_DEACTIVATE_FOUNDER'   => 'You are NOT Allowed to Deactivate Founder Accounts.',
    'CANNOT_DEACTIVATE_YOURSELF'  => 'You are NOT Allowed to Deactivate Your Own Account.',

    'CANNOT_FORCE_REACT_BOT'      => 'You are NOT Allowed to Force Reactivation on BOT Accounts.  Please Reactivate the BOT within the BOTS Page instead.',

    'CANNOT_FORCE_REACT_FOUNDER'  => 'You are NOT Allowed to Force Reactivation on Founder Accounts.',
    'CANNOT_FORCE_REACT_YOURSELF' => 'You are NOT Allowed to Force Reactivation of Your Own Account.',
    'CANNOT_REMOVE_ANONYMOUS'     => 'You are NOT Allowed to Remove the Guest User Account.',
    'CANNOT_REMOVE_YOURSELF'      => 'You are NOT Allowed to Remove your Own User Account.',
    'CANNOT_SET_FOUNDER_IGNORED'  => 'You are NOT Allowed to Promote Ignored Users Founders.',

    'CANNOT_SET_FOUNDER_INACTIVE' => 'You Need to Activate Users before you Promote them to Founders.   Only Activated Users are able to be Promoted.',

    'CONFIRM_EMAIL_EXPLAIN'       => 'You Only Need to Specify this if you are Changing the Users email Address.',
    'CONTACT_USER'                => 'Contact User',

    'DELETE_POSTS'                => 'Delete Posts',
    'DELETE_USER'                 => 'Delete User',
    'DELETE_USER_EXPLAIN'         => 'Please Note that Deleting a User is Final, they can NOT be Recovered.',

    'FORCE_REACTIVATION_SUCCESS'  => 'Successfully Forced Reactivation.',
    'FOUNDER'                     => 'Founder',

    'FOUNDER_EXPLAIN'             => 'Founders have ALL Administrator Permissions and can NOT be Banned, Deleted or Altered by Non Founder Members.',

    'GROUP_APPROVE'               => 'Approve Member',
    'GROUP_DEFAULT'               => 'Make Group Default for Member',
    'GROUP_DELETE'                => 'Remove Member from Group',
    'GROUP_DEMOTE'                => 'Demote from Group Leader',
    'GROUP_PROMOTE'               => 'Promote to Group Leader',

    'IP_WHOIS_FOR'                => 'IP Whois for %s',

    'LAST_ACTIVE'                 => 'Last Active',

    'MOVE_POSTS_EXPLAIN'          => 'Please Select the Forum to which you wish to Move ALL the Posts this User has made.',

    'NO_SPECIAL_RANK'             => 'No Special Rank Assigned',

    'NOT_MANAGE_FOUNDER'          => 'You tried to Manage a User with Founder Status.  Only Founders are Allowed to Manage other Founders.',

    'QUICK_TOOLS'                 => 'Quick Tools',

    'REGISTERED'                  => 'Registered',
    'REGISTERED_IP'               => 'Registered from IP',
    'RETAIN_POSTS'                => 'Retain Posts',

    'SELECT_FORM'                 => 'Select Form',
    'SELECT_USER'                 => 'Select User',

    'USER_ADMIN'                  => 'User Administration',
    'USER_ADMIN_ACTIVATE'         => 'Activate Account',
    'USER_ADMIN_ACTIVATED'        => 'User Activated Successfully.',
    'USER_ADMIN_AVATAR_REMOVED'   => 'Successfully Removed the Avatar from User Account.',
    'USER_ADMIN_BAN_EMAIL'        => 'Ban by email',
    'USER_ADMIN_BAN_EMAIL_REASON' => 'email Address Banned via User Management',
    'USER_ADMIN_BAN_IP'           => 'Ban by IP',
    'USER_ADMIN_BAN_IP_REASON'    => 'IP Banned via User Management',
    'USER_ADMIN_BAN_NAME_REASON'  => 'Username Banned via User Management',
    'USER_ADMIN_BAN_USER'         => 'Ban by Username',
    'USER_ADMIN_DEACTIVATE'       => 'Deactivate Account',
    'USER_ADMIN_DEACTIVED'        => 'User Deactivated Successfully.',
    'USER_ADMIN_DEL_ATTACH'       => 'Delete ALL Attachments',
    'USER_ADMIN_DEL_AVATAR'       => 'Delete Avatar',
    'USER_ADMIN_DEL_POSTS'        => 'Delete ALL Posts',
    'USER_ADMIN_DEL_SIG'          => 'Delete Signature',
    'USER_ADMIN_EXPLAIN'          => 'Here you can Change your Users Information and Certain Specific Options.<br /><br />',
    'USER_ADMIN_FORCE'            => 'Force Reactivation',
    'USER_ADMIN_MOVE_POSTS'       => 'Move ALL Posts',
    'USER_ADMIN_SIG_REMOVED'      => 'Successfully Removed the Signature from User Account.',
    'USER_ATTACHMENTS_REMOVED'    => 'Successfully Removed ALL the Attachments made by this User.',
    'USER_AVATAR_UPDATED'         => 'Successfully Updated the User\'s Avatar Details.',
    'USER_CUSTOM_PROFILE_FIELDS'  => 'Custom Profile Fields',
    'USER_DELETED'                => 'User Deleted Successfully.',
    'USER_GROUP_ADD'              => 'Add User to Group',
    'USER_GROUP_NORMAL'           => 'User Defined Groups User is a Member of',
    'USER_GROUP_PENDING'          => 'Groups User is in Pending Mode',
    'USER_GROUP_SPECIAL'          => 'Pre-Defined Groups User is a Member of',
    'USER_NO_ATTACHMENTS'         => 'There are No Attached Files to Display.',
    'USER_OVERVIEW_UPDATED'       => 'User Details Updated.',
    'USER_POSTS_DELETED'          => 'Successfully Removed ALL the Posts made by this User.',
    'USER_POSTS_MOVED'            => 'Successfully Moved the Users Posts to the Target Forum.',
    'USER_PREFS_UPDATED'          => 'User Preferences Updated.',
    'USER_PROFILE'                => 'User Profile',
    'USER_PROFILE_UPDATED'        => 'User Profile Updated.',
    'USER_RANK'                   => 'User Rank',
    'USER_RANK_UPDATED'           => 'User Rank Updated.',
    'USER_SIG_UPDATED'            => 'User Signature Successfully Updated.',
    'USER_TOOLS'                  => 'Basic Tools',
    'UCP_AIM'                     => 'AOL Instant Messenger',
    'UCP_ATTACHMENTS'             => 'Attachments',
    'UCP_COPPA_BEFORE'            => 'Before %s',
    'UCP_COPPA_ON_AFTER'          => 'On or After %s',

    'UCP_EMAIL_ACTIVATE'          => 'Please Note that you will Need to Enter a Valid email Address before your Account is Activated.  You will Receive an email at the Address you Provide that Contains an Account Activation Link.',

    'UCP_ICQ'                     => 'ICQ Number',
    'UCP_JABBER'                  => 'Jabber Address',

    'UCP_MAIN'                    => 'Overview',
    'UCP_MAIN_ATTACHMENTS'        => 'Manage Attachments',
    'UCP_MAIN_BOOKMARKS'          => 'Manage Bookmarks',
    'UCP_MAIN_DRAFTS'             => 'Manage Drafts',
    'UCP_MAIN_FRONT'              => 'Front Page',
    'UCP_MAIN_SUBSCRIBED'         => 'Manage Subscriptions',

    'UCP_MSNM'                    => 'MSN Messenger',
    'UCP_NO_ATTACHMENTS'          => 'You haven\'t Posted any Files.',

    'UCP_PREFS'                   => 'Board Preferences',
    'UCP_PREFS_PERSONAL'          => 'Edit Global Settings',
    'UCP_PREFS_POST'              => 'Edit Posting Defaults',
    'UCP_PREFS_VIEW'              => 'Edit Display Options',

    'UCP_PM'                      => 'Private Messages',
    'UCP_PM_COMPOSE'              => 'Compose Message',
    'UCP_PM_DRAFTS'               => 'Manage PM Drafts',
    'UCP_PM_OPTIONS'              => 'Rules, Folders and Settings',
    'UCP_PM_POPUP'                => 'Private Messages',
    'UCP_PM_POPUP_TITLE'          => 'Private Message Popup',
    'UCP_PM_UNREAD'               => 'Unread Messages',
    'UCP_PM_VIEW'                 => 'View Messages',

    'UCP_PROFILE'                 => 'Profile',
    'UCP_PROFILE_AVATAR'          => 'Edit Avatar',
    'UCP_PROFILE_PROFILE_INFO'    => 'Edit Profile',
    'UCP_PROFILE_REG_DETAILS'     => 'Edit Account Settings',
    'UCP_PROFILE_SIGNATURE'       => 'Edit Signature',

    'UCP_USERGROUPS'              => 'Usergroups',
    'UCP_USERGROUPS_MEMBER'       => 'Edit Memberships',
    'UCP_USERGROUPS_MANAGE'       => 'Manage Groups',

    'UCP_REGISTER_DISABLE'        => 'Creating a New Account is currently NOT possible.',
    'UCP_REMIND'                  => 'Send Password',
    'UCP_RESEND'                  => 'Send Activation email',

    'UCP_WELCOME'                 => 'Welcome to the User Control Panel.  From here you can Monitor, View and Update your Profile, Preferences, Subscribed Forums and Topics.  You can also Send Messages to other Users (if Permitted).  Please ensure you Read any Announcements before continuing.',

    'UCP_YIM'                     => 'Yahoo Messenger',
    'UCP_ZEBRA'                   => 'Friends and Foes',
    'UCP_ZEBRA_FOES'              => 'Manage Foes',
    'UCP_ZEBRA_FRIENDS'           => 'Manage Friends',
    'BIRTHDAY'                    => 'Birthday',
    'BIRTHDAY_EXPLAIN'            => 'Setting a Year will List your Age when it is your Birthday.',
    'SORT'                        => 'Sort',
    'SORT_COMMENT'                => 'File Comment',
    'SORT_DOWNLOADS'              => 'Downloads',
    'SORT_EXTENSION'              => 'Extension',
    'SORT_FILENAME'               => 'Filename',
    'SORT_POST_TIME'              => 'Post Time',
    'SORT_SIZE'                   => 'File Size',
    'SORT_TOPIC_TITLE'            => 'Topic Title',
    'ASCENDING'                   => 'Ascending',
    'DESCENDING'                  => 'Descending',
    'FILENAME'                    => 'Filename',
    'FILESIZE'                    => 'File Size',
    'POST_TIME'                   => 'Post Time',
    'DOWNLOADS'                   => 'Downloads',
    'POST'                        => 'Post',
    'NO_ENTRIES'                  => 'No Log Entries for this Period.',
    'ADD_FEEDBACK'                => 'Add Feedback',
    'ADD_FEEDBACK_EXPLAIN'        => 'Add Notes to User\'s Account.<br /><br />',

    #Added in v3.0.1
    'USER_FORUM'        => 'User Forum',
    'VISITED'           => 'Visited',
    'JUMP_TO'           => 'Jump to Page',
    'SEARCH_USER'       => 'Search User',
    'SEARCH_EMAIL'      => 'Search email',
    'SEARCH_IP'         => 'Search IP',
    'SEARCH_HOST'       => 'Search Host',
    'SEARCH_DUPIP'      => 'Search for duplicate IP\'s',
    'USERNAME'          => 'Username',
    'EMAIL'             => 'email',
    'JOINED'            => 'Joined',
    'LAST_ACTIVITY'     => 'Last Activity',
    'POSTS'             => 'Posts',
    'TORRENTS'          => 'Torrents',
    'OPTIONS'           => 'Options',
    'WHOIS'             => 'Whois',
    'BAN_REASON'        => 'Ban Reason',
    'BAN_GIVE_REASON'   => 'Enter a Reason for the Ban',
    'SEARCH_USER_POSTS' => 'Search User\'s Forum Posts',
 ));

?>