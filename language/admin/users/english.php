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
** File users/english.php 2018-04-11 09:34:00 Thor
**
** CHANGES
**
** 2018-02-25 - Added New Masthead
** 2018-02-25 - Added New !defined('IN_PMBT')
** 2018-02-25 - Fixed Spelling
** 2018-04-11 - Amended the Wording of some Sentences
** 2018-04-11 - Amended !defined('IN_PMBT') Corrected Path
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
    'ADMIN_SIG_PREVIEW'           => 'Signature Preview',

    'AT_LEAST_ONE_FOUNDER'        => 'You are NOT able to Change this Founder to a Normal User.  There needs to be at least one Founder Enabled for this board.  If you want to Change this Users Founder Status, Promote another User to Founder First.',

    'BAN_ALREADY_ENTERED'         => 'The Ban had Previously been Entered Successfully.  The Ban List has NOT been Updated.',
    'BAN_SUCCESSFUL'              => 'Ban Entered Successfully.',

    'CANNOT_BAN_FOUNDER'          => 'You are NOT Allowed to Ban Founder Accounts.',
    'CANNOT_BAN_YOURSELF'         => 'You are NOT Allowed to Ban Yourself.',

    'CANNOT_DEACTIVATE_BOT'       => 'You are NOT Allowed to Deactivate BOT Accounts.  Please Deactivate the BOT within the BOTS Page instead.',

    'CANNOT_DEACTIVATE_FOUNDER'   => 'You are NOT Allowed to Deactivate Founder Accounts.',
    'CANNOT_DEACTIVATE_YOURSELF'  => 'You are NOT Allowed to Deactivate your Own Account.',

    'CANNOT_FORCE_REACT_BOT'      => 'You are NOT Allowed to Force Reactivation on BOT Accounts.  Please Reactivate the BOT within the Bots Page instead.',

    'CANNOT_FORCE_REACT_FOUNDER'  => 'You are NOT Allowed to Force Reactivation on Founder Accounts.',
    'CANNOT_FORCE_REACT_YOURSELF' => 'You are NOT Allowed to Force Reactivation of your Own Account.',
    'CANNOT_REMOVE_ANONYMOUS'     => 'You are NOT Allowed to Remove a Guest User Account.',
    'CANNOT_REMOVE_YOURSELF'      => 'You are NOT Allowed to Remove your Own User Account.',
    'CANNOT_SET_FOUNDER_IGNORED'  => 'You are NOT Allowed to Promote Ignored Users to be Founders.',

    'CANNOT_SET_FOUNDER_INACTIVE' => 'You need to Activate Users before you Promote them to Founders.  Only Activated Users are able to be Promoted.',

    'CONFIRM_EMAIL_EXPLAIN'       => 'You Only need to Specify this if you are Changing the Users email Address.',

    'DELETE_POSTS'                => 'Delete Posts',
    'DELETE_USER'                 => 'Delete User',
    'DELETE_USER_EXPLAIN'         => 'Please Note that Deleting a User is Final, they can NOT be Recovered.',

    'FORCE_REACTIVATION_SUCCESS'  => 'Successfully Forced Reactivation.',
    'FOUNDER'                     => 'Founder',

    'FOUNDER_EXPLAIN'             => 'Founders have ALL Administrator Permissions and can Never be Banned, Deleted or Altered by Non-Founder Members.',

    'GROUP_APPROVE'               => 'Approve Member',
    'GROUP_DEFAULT'               => 'Make Group Default for Member',
    'GROUP_DELETE'                => 'Remove Member from Group',
    'GROUP_DEMOTE'                => 'Demote from Group Leader',
    'GROUP_PROMOTE'               => 'Promote to Group Leader',

    'IP_WHOIS_FOR'                => 'IP Whois for %s',

    'LAST_ACTIVE'                 => 'Last Active',

    'MOVE_POSTS_EXPLAIN'          => 'Please Select the Forum to which you wish to Move ALL the Posts this User has made.',

    'NO_SPECIAL_RANK'             => 'No Special Rank Assigned',

    'NOT_MANAGE_FOUNDER'          => 'You tried to Manage a User with Founder Status.  Only Founders are Allowed to Manage Other Founders.',

    'QUICK_TOOLS'                 => 'Quick Tools',

    'REGISTERED'                  => 'Registered',
    'REGISTERED_IP'               => 'Registered from IP',
    'RETAIN_POSTS'                => 'Retain Posts',

    'SELECT_FORM'                 => 'Select Form',
    'SELECT_USER'                 => 'Select User',

    'USER_ADMIN'                  => 'User Administration',
    'USER_ADMIN_ACTIVATE'         => 'Activate Account',
    'USER_ADMIN_ACTIVATED'        => 'User Activated Successfully.',
    'USER_ADMIN_AVATAR_REMOVED'   => 'Successfully Removed Avatar from User Account.',
    'USER_ADMIN_BAN_EMAIL'        => 'Ban by email',
    'USER_ADMIN_BAN_EMAIL_REASON' => 'email Address Banned via User Management',
    'USER_ADMIN_BAN_IP'           => 'Ban by IP',
    'USER_ADMIN_BAN_IP_REASON'    => 'IP Banned via User Management',
    'USER_ADMIN_BAN_USER'         => 'Ban by Username',
    'USER_ADMIN_BAN_NAME_REASON'  => 'Username Banned via User Management',
    'USER_ADMIN_DEACTIVATE'       => 'Deactivate Account',
    'USER_ADMIN_DEACTIVED'        => 'User Deactivated Successfully.',
    'USER_ADMIN_DEL_ATTACH'       => 'Delete ALL Attachments',
    'USER_ADMIN_DEL_AVATAR'       => 'Delete Avatar',
    'USER_ADMIN_DEL_POSTS'        => 'Delete ALL Posts',
    'USER_ADMIN_DEL_SIG'          => 'Delete Signature',
    'USER_ADMIN_EXPLAIN'          => 'Here you can Change your Users Information and Certain Specific Options.',
    'USER_ADMIN_FORCE'            => 'Force Reactivation',
    'USER_ADMIN_MOVE_POSTS'       => 'Move ALL Posts',
    'USER_ADMIN_SIG_REMOVED'      => 'Successfully Removed Signature from User Account.',
    'USER_ATTACHMENTS_REMOVED'    => 'Successfully Removed ALL Attachments made by this User.',
    'USER_AVATAR_UPDATED'         => 'Successfully Updated User Avatars Details.',
    'USER_CUSTOM_PROFILE_FIELDS'  => 'Custom Profile Fields',
    'USER_DELETED'                => 'User Deleted Successfully.',
    'USER_GROUP_ADD'              => 'Add User to Group',
    'USER_GROUP_NORMAL'           => 'User-Defined Groups User is a Member of',
    'USER_GROUP_PENDING'          => 'Groups User is in Pending Mode',
    'USER_GROUP_SPECIAL'          => 'Pre-Defined Groups User is a Member of',
    'USER_NO_ATTACHMENTS'         => 'There are NO Attached Files to Display.',
    'USER_OVERVIEW_UPDATED'       => 'User Details Updated.',
    'USER_POSTS_DELETED'          => 'Successfully Removed ALL Posts made by this User.',
    'USER_POSTS_MOVED'            => 'Successfully Moved Users Posts to Target Forum.',
    'USER_PREFS_UPDATED'          => 'User Preferences Updated.',
    'USER_PROFILE'                => 'User Profile',
    'USER_PROFILE_UPDATED'        => 'User Profile Updated.',
    'USER_RANK'                   => 'User Rank',
    'USER_RANK_UPDATED'           => 'User Rank Updated.',
    'USER_SIG_UPDATED'            => 'User Signature Successfully Updated.',
    'USER_TOOLS'                  => 'Basic Tools',
));

?>