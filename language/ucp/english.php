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
** File ucp/english.php 2018-03-22 08:54:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You can't access this file directly");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'BLACK_LIST_USER'           => 'Refuse this User\'s Messages',
    'BLACK_LIST_REMOVE'         => 'Don\'t Refuse this User\'s Messages',
    'ADD_BUDDY'                 => 'Add to Buddies',
    'BUDDY_REMOVE'              => 'Remove from Buddies',
    'ERR_NO_BODY'               => 'Empty Message Body',
    'ERR_NO_SUB'                => 'You have to Specify a Subject',
    'UCP_WARNED_MES'            => 'You have been WARNNED by %1$s for %2$s with Reason: %3$s',
    'WARNNING'                  => 'Warning',
    'TOR_IMG_SEED'              => 'Torrents I\'m Seeding',
    'TOR_IMG_LEECH'             => 'Torrents I\'m Leeching',
    'EMAILS_NOT_MATCH'          => 'The email Address\'s you Entered DO NOT Match.',
    'UCP_DISABLE_ACC'           => 'Disable Account',
    'UCP_BAN_FORUM'             => 'Forum Ban',
    'UCP_SHOUT_BAN'             => 'Ban Shouts',
    'UCP_UNSHOUT_BAN'           => 'UnBan Shouts',
    'UCP_HELPER_FOR'            => 'What the User is helpful for',
    'ACTIVE_IN_FORUM'           => 'Most Active Forum',
    'ACTIVE_IN_TOPIC'           => 'Most Active Topic',
    'USER_SEEDBOX'              => 'User\'s Seedbox IP',
    'UCP_BAN_USER'              => 'Ban User',
    'UCP_UNBAN_USER'            => 'Unban User',
    'BACK_TO_DRAFTS'            => 'Back to Drafts',
    'YOU_CANT_BAN_YOURSELF'     => 'You can NOT Ban Yourself',
    'UCP_SHOUT_BAN_EXPL'        => 'User will NOT be able to View or Post Shouts',
    'UCP_DISABLE_ACC_EXPL'      => 'Disabled Accounts can NOT View Torrents Upload or Download Torrents.<br />Disabled Accounts will NO longer be able to Access all the Site.<br />This is a Mild form of Ban so that the User will be able to Access the Site to find out WHY they have been Disabled.',
    'INV_LEVEL_TO_EDIT'         => 'You DO NOT have Access to Edit this Person',
    'UCP_WARN_WEEK'             => '%s Week%s',
    'CONFERM_EMAIL_SUB'         => 'Confirm email on %1$s',
    'WARN_MOD_MES'              => '%1$s - Warned for %2$s  by %3$s - Reason: %4$s',
    'LOG_GROUP_CHANGE'          => 'Group Changed for %1$s To %2$s',
    'LOG_LEVEL_CHANGE'          => 'Level Changed for %1$s To %2$s',
    'UCP_WARN_REMOVED_MES'      => 'Your WARNNING was Deleted by %1$s!',
    'UCP_WARN_REASON_EXPL'      => 'Note Added to Users Private Message as to WHY they have been Warned',
    'WARN_REMOVE_MOD_MESS'      => '%1$s - WARN deleted by %2$s',
    'PROFILE_UPDATED'           => 'Your Profile has been Updated',
    'NO_AUTHBAN_SHOUTS'         => 'You DO NOT have Access to Ban Shouts',
    'SHOUTS_BANNED'             => 'User has been Banned from ShoutBox',
    'SHOUTS_UN_BANNED'          => 'User has been Unbanned from ShoutBox',
    'DRAFTS_EXPLAIN'            => 'Here you can View, Edit and Delete your Saved Drafts.',
    'LOGIN_ERROR_NP'            => 'Username or Password NOT Specified.',
    'LOGIN_ERROR_NP_WRONG'      => 'Incorrect Username or Password!!',
    'LOGIN_ERROR_NOT_ACTIVE'    => 'User Registered but NOT Active!!',
    'EMAIL_CHANGE_NOT_SET'      => 'NO email Change is Set',
    'EMAIL_CHANGED'             => 'Your email was Successfully Changed',
    'EMAIL_CHANGE_INV'          => 'Invalid Confirmation Code or User ID',
    'EMAIL_CHANGE'              => 'email Change',
    'USER_BAN_NO_DEL'           => 'User is Banned DO NOT Delete',
    'CONFERM_DELETE_USER'       => '<b>WARNING</b>: You are about to Completely and Permanently Delete %1$s\'s Account. %1$s Editing Permissions for ALL Torrents he/she Uploaded.  Re-registering with the same user name will be possible after that.',
    'PASS_RECOVER_NOT_SET'      => 'NO Recovery Password is Set',
    'PASS_RECOVER_INV'          => 'Invalid Confirmation Code or User ID',
    'PASS_RECOVER'              => 'Password Recovery',
    'PASS_RECOVER_COMPLETE'     => 'Password Changed.  Now you can Login with your NEW Password.',
    'ACC_NOW_ACTIVATED'         => 'Activation Complete.  Your Account is now Activated. You can Access our Services using the Username and Password that you provided.  Have a nice Download.',
    'VIEW_AVATARS'              => 'Display Avatars',
    'VIEW_EDIT'                 => 'View/Edit',
    'VIEW_FLASH'                => 'Display Flash Animations',
    'VIEW_IMAGES'               => 'Display Images within Posts',
    'VIEW_NEXT_HISTORY'         => 'Next PM in History',
    'VIEW_NEXT_PM'              => 'Next PM',
    'VIEW_PM'                   => 'View Message',
    'VIEW_PM_INFO'              => 'Message Details',
    'VIEW_PM_MESSAGE'           => '1 Message',
    'VIEW_PM_MESSAGES'          => '%d Messages',
    'VIEW_PREVIOUS_HISTORY'     => 'Previous PM in History',
    'VIEW_PREVIOUS_PM'          => 'Previous PM',
    'VIEW_SIGS'                 => 'Display Signatures',
    'VIEW_SMILIES'              => 'Display Smilies as Images',
    'VIEW_TOPICS_DAYS'          => 'Display Topics from Previous Days',
    'VIEW_TOPICS_DIR'           => 'Display Topic Order Direction',
    'VIEW_TOPICS_KEY'           => 'Display Topics Ordering by',
    'VIEW_POSTS_DAYS'           => 'Display Posts from Previous Days',
    'VIEW_POSTS_DIR'            => 'Display Post Order Direction',
    'VIEW_POSTS_KEY'            => 'Display Posts Ordering by',
    'DISABLE_CENSORS'           => 'Enable Word Censoring',
    'DEFAULT_ACTION'            => 'Default Action',
    'DEFAULT_ACTION_EXPLAIN'    => 'This Action will be Triggered if none of the above is Applicable.',
    'DEFAULT_ADD_SIG'           => 'Attach my Signature by Default',
    'DEFAULT_BBCODE'            => 'Enable BBCode by Default',
    'DEFAULT_NOTIFY'            => 'Notify me upon Replies by Default',
    'DEFAULT_SMILIES'           => 'Enable Smilies by Default',
    'BIRTHDAY'                  => 'Birthday',
    'BIRTHDAY_EXPLAIN'          => 'Setting a Year will List your Age when it is your Birthday.',
    'BOARD_DATE_FORMAT'         => 'My Date Format',
    'BOARD_DATE_FORMAT_EXPLAIN' => 'The Syntax Used is Identical to the PHP <a href="http://www.php.net/date">date()</a> Function.',
    'BOARD_DST'                 => 'Summer Time/<abbr title="Daylight Saving Time">DST</abbr> is in effect',
    'BOARD_LANGUAGE'            => 'My Language',
    'BOARD_STYLE'               => 'My Board Style',
    'BOARD_TIMEZONE'            => 'My Time Zone',
    'BOARD_COUNTRY'             => 'My Country',
    'BOOKMARKS'                 => 'Bookmarks',
    'BOOKMARKS_EXPLAIN'         => 'You can Bookmark Topics for Future Reference.  Select the Checkbox for any Bookmark you wish to Delete, then Press the <em>Remove Marked Bookmarks</em> Button.',
    'BOOKMARKS_DISABLED'        => 'Bookmarks are Disabled on this Board.',
    'BOOKMARKS_REMOVED'         => 'Bookmarks Removed Successfully.',
    'POPUP_ON_PM'               => 'Pop-Up Window on New Private Message',
    'NOTIFY_METHOD'             => 'Notification Method',
    'NOTIFY_METHOD_BOTH'        => 'Both',
    'TITLE'                     => 'Title',
    'NOTIFY_METHOD_EMAIL'       => 'email Only',
    'NOTIFY_METHOD_EXPLAIN'     => 'Method for Sending Messages sent via this Board.',
    'NOTIFY_METHOD_IM'          => 'Jabber Only',
    'NOTIFY_ON_PM'              => 'Notify me when New Private Messages are Received',
    'HIDE_ONLINE'               => 'Hide my Online Status',
    'HIDE_ONLINE_EXPLAIN'       => 'Changing this Setting won\'t become Effective until your Next Visit to the Board.',
    'HOLD_NEW_MESSAGES'         => 'DO NOT Accept New Messages (New Messages will be held back until enough Space is Available)',
    'HOLD_NEW_MESSAGES_SHORT'   => 'New Messages will be Held Back',
    'ALLOW_PM'                  => 'Allow Users to Send you Private Messages',
    'ALLOW_PM_EXPLAIN'          => 'Note that Administrators and Moderators will Always be able to Send you Messages.',
    'SHOW_EMAIL'                => 'Users can Contact me by email',
    'ADMIN_EMAIL'               => 'Administrators can email me Information',
    'NO_FRIENDS_ONLINE'         => 'NO Friends Online',
    'EDIT_DRAFT_EXPLAIN'        => 'Here you are able to Edit your Draft. Drafts DO NOT contain Attachment and Poll Information.',
    'NEW_PM'                    => 'New Message',
    'CHOOSE_AVATAR'             => 'Choose Avatar',
    'ACCOUT_STATUS'             => 'Account Status',
    'ACCOUT_EXP_STATUS'         => 'Set User Active/Inactive.  BEWARE! Setting a User that has been Registered for more than 48h to INACTIVE will also Delete the Account.',
    'NO_WATCHED_FORUMS'         => 'You are NOT Subscribed to any Forums.',
    'NO_WATCHED_TORRENTS'       => 'You are NOT Subscribed to any Torrents.',
    'NO_WATCHED_TOPICS'         => 'You are NOT Subscribed to any Topics.',
    'WATCHED_FORUMS'            => 'Watched Forums',
    'WATCHED_TOPICS'            => 'Watched Topics',
    'UNWATCH_MARKED'            => 'Unwatch Marked',
    '_WATCHED_TORRENTS'         => 'Watched Torrents',
    '_WATCHED_FORUMS'           => 'Watched Forums',
    '_WATCHED_TOPICS'           => 'Watched Topics',
    'SIGNATURE_PREVIEW'         => 'Your Signature will appear like this in Posts',
    'WATCHED_EXPLAIN'           => 'Below is a List of Forums and Topics that you are Subscribed to,and you\'ll be Notified of any New Posts. To Unsubscribe Mark the Forum or Topic and then, Press the <em>Unwatch Marked</em> Button.',
    'UCP_BAN_USER_FORUM'        => 'Ban User from the Forum',
    'USE_PASSKEY'               => 'Use Passkey',
    'RESSET_PASSKEY'            => 'Reset Passkey',
    'RES_PASSKEY_WARNING'       => '<b>WARNING</b>: ALL the Torrent Files you Downloaded so far will NOT be Valid any more!',
    'ACCEPT_EMAIL'              => 'Accept email from Other Users',
    'ACCEPT_EMAIL_EXP'          => 'Allow Users of this Site to see your email Address',
    'ACCEPT_EMAIL_ACP'          => 'Administrators can email me Information',
    'ACCEPT_EMAIL_ACP_EXP'      => 'Allow Mass email from this Site',
    'INACTIVE'                  => 'Inactive',
    'ACC_LEVEL'                 => 'Access Level',
    'ERROR_SUBJECT_NUBER'       => 'The Subscription is NOT a Number.  Please go back and try again',
    'NO_DRAFTS_SET'             => 'NO Draft is Set.  Please Check your Link',
    'DELETE_DRAFTS'             => 'Delete Drafts',
    'VIEW_FORUM_TOPICS'         => '%d Topics',
    'VIEW_FORUM_TOPIC'          => '1 Topic',
    'M_SITE_HELPER'             => 'Site Helper',
    'ACP_PM_NOTICE_EMAIL'       => 'Accespt pm notifacation',
    'ACP_PM_NOTICE_EMAIL_EXP'   => 'Allow system to send you a email Notice of new PM\'s',
    'TOR_PERPAGE'               => 'Torrents Perpage',
    'PARK_ACC'                  => 'Park account',
    'PARK_ACC_EXP'              => 'You can park your account for up to 90 days while on vacation or without internet, etc. Your account cannot be deleted during this time but on day 91 it can. HnR\'s will not accrue while parked but they will resume when unparked. You can not download any torrents while your account is parked!',
	'DELETE_DRAFT'				=>	'Remove selected drafts',
	'DELETE_DRAFT_CONFIRM'		=>	'Are you sure you want to delete all selected drafts?',
    'ACP_PM_NOTICE_EMAIL'       => 'Accept PM Notification',
    'ACP_PM_NOTICE_EMAIL_EXP'   => 'Allow System to Send you a email Notice of NEW PM\'s',
    'TOR_PERPAGE'               => 'Torrents Per Page',
    'PARK_ACC'                  => 'Park Account',
    'PARK_ACC_EXP'              => 'You can Park your Account for up to 90 days while on vacation or without internet, etc.  Your Account can NOT be Deleted during this time but, on day 91 it can. HnR\'s will NOT occur while Parked but, they will Resume when Un-Parked.  You can NOT Download any Torrents while your Account is Parked!',
));

?>