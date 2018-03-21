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
** File ucp/english.php 2018-03-20 14:08:00 Thor
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
    'ERR_NO_SUB'                => 'You have to specify a Subject',
    'UCP_WARNED_MES'            => 'You have been WARNNED by %1$s for  %2$s  with reason: %3$s',
    'WARNNING'                  => 'Warnning',
    'TOR_IMG_SEED'              => 'Torrents I\'m Seeding',
    'TOR_IMG_LEECH'             => 'Torrents I\'m Leeching',
    'EMAILS_NOT_MATCH'          => 'The email Adress\'s you entered are NOT the same',
    'UCP_DISABLE_ACC'           => 'Disable Account',
    'UCP_BAN_FORUM'             => 'Forum Ban',
    'UCP_SHOUT_BAN'             => 'Ban Shouts',
    'UCP_UNSHOUT_BAN'           => 'UnBan Shouts',
    'UCP_HELPER_FOR'            => 'What the User is helpfull for',
    'ACTIVE_IN_FORUM'           => 'Most active forum',
    'ACTIVE_IN_TOPIC'           => 'Most active topic',
    'USER_SEEDBOX'              => 'Users Seedbox IP',
    'UCP_BAN_USER'              => 'Ban User',
    'UCP_UNBAN_USER'            => 'UnBan User',
    'BACK_TO_DRAFTS'            => 'Back To Drafts',
    'YOU_CANT_BAN_YOURSELF'     => 'You can not ban Your Self',
    'UCP_SHOUT_BAN_EXPL'        => 'User well not beable to View or Post shouts',
    'UCP_DISABLE_ACC_EXPL'      => 'Disabled accounts can not view Torrents Upload or download Torrents.<br />Disabled accounts well no longer be able to access site announce.<br />This is a Mild form of Ban as the users well be able to access the site to find out why they have been Disabled',
    'INV_LEVEL_TO_EDIT'         => 'You do not have access to edit this Person',
    'UCP_WARN_WEEK'             => '%s Week%s',
    'CONFERM_EMAIL_SUB'         => 'Conferm email on %1$s',
    'WARN_MOD_MES'              => '%1$s - Warned for %2$s  by %3$s - Reason: %4$s',
    'LOG_GROUP_CHANGE'          => 'Group Changed for %1$s To %2$s',
    'LOG_LEVEL_CHANGE'          => 'Level Changed for %1$s To %2$s',
    'UCP_WARN_REMOVED_MES'      => 'Your WARNNING was deleted by %1$s!',
    'UCP_WARN_REASON_EXPL'      => 'Note added to users Private Message as to why they have been warned',
    'WARN_REMOVE_MOD_MESS'      => '%1$s - WARN deleted by %2$s',
    'PROFILE_UPDATED'           => 'Your Profile has been Updated',
    'NO_AUTHBAN_SHOUTS'         => 'You do not have access to Ban Shouts',
    'SHOUTS_BANNED'             => 'User has ben banned from ShoutBox',
    'SHOUTS_UN_BANNED'          => 'User has ben unbanned from ShoutBox',
    'DRAFTS_EXPLAIN'            => 'Here you can view, edit and delete your saved drafts.',
    'LOGIN_ERROR_NP'            => 'User name or Password NOT Specified.',
    'LOGIN_ERROR_NP_WRONG'      => 'Incorrect User name or Password!!',
    'LOGIN_ERROR_NOT_ACTIVE'    => 'User Registered but NOT Active!!',
    'EMAIL_CHANGE_NOT_SET'      => 'No email change is set',
    'EMAIL_CHANGED'             => 'Your email was Successfully changed',
    'EMAIL_CHANGE_INV'          => 'Invalid Confirmation Code or User ID',
    'EMAIL_CHANGE'              => 'email Change',
    'USER_BAN_NO_DEL'           => 'User is banned do not delete',
    'CONFERM_DELETE_USER'       => '<b>WARNING</b>: you are about to Completely and Permanently Delete %1$s\'s account. %1$s Editing Permissions for all torrents he/she uploaded. Re-registering with the same user name will be possible after that.',
    'PASS_RECOVER_NOT_SET'      => 'No recover password is set',
    'PASS_RECOVER_INV'          => 'Invalid Confirmation Code or User ID',
    'PASS_RECOVER'              => 'Password Recovery',
    'PASS_RECOVER_COMPLETE'     => 'Password Changed. Now you can Login with your NEW Password.',
    'ACC_NOW_ACTIVATED'         => 'Activation Complete. Your Account is now Permanently Active. From now on, you can Access our services using the User name and Password you provided. Have a nice download.',
    'VIEW_AVATARS'              => 'Display avatars',
    'VIEW_EDIT'                 => 'View/Edit',
    'VIEW_FLASH'                => 'Display Flash animations',
    'VIEW_IMAGES'               => 'Display images within posts',
    'VIEW_NEXT_HISTORY'         => 'Next PM in history',
    'VIEW_NEXT_PM'              => 'Next PM',
    'VIEW_PM'                   => 'View message',
    'VIEW_PM_INFO'              => 'Message details',
    'VIEW_PM_MESSAGE'           => '1 message',
    'VIEW_PM_MESSAGES'          => '%d messages',
    'VIEW_PREVIOUS_HISTORY'     => 'Previous PM in history',
    'VIEW_PREVIOUS_PM'          => 'Previous PM',
    'VIEW_SIGS'                 => 'Display signatures',
    'VIEW_SMILIES'              => 'Display smilies as images',
    'VIEW_TOPICS_DAYS'          => 'Display topics from previous days',
    'VIEW_TOPICS_DIR'           => 'Display topic order direction',
    'VIEW_TOPICS_KEY'           => 'Display topics ordering by',
    'VIEW_POSTS_DAYS'           => 'Display posts from previous days',
    'VIEW_POSTS_DIR'            => 'Display post order direction',
    'VIEW_POSTS_KEY'            => 'Display posts ordering by',
    'DISABLE_CENSORS'           => 'Enable word censoring',
    'DEFAULT_ACTION'            => 'Default action',
    'DEFAULT_ACTION_EXPLAIN'    => 'This action will be triggered if none of the above is applicable.',
    'DEFAULT_ADD_SIG'           => 'Attach my signature by default',
    'DEFAULT_BBCODE'            => 'Enable BBCode by default',
    'DEFAULT_NOTIFY'            => 'Notify me upon replies by default',
    'DEFAULT_SMILIES'           => 'Enable smilies by default',
    'BIRTHDAY'                  => 'Birthday',
    'BIRTHDAY_EXPLAIN'          => 'Setting a year will list your age when it is your birthday.',
    'BOARD_DATE_FORMAT'         => 'My date format',
    'BOARD_DATE_FORMAT_EXPLAIN' => 'The syntax used is identical to the PHP <a href="http://www.php.net/date">date()</a> function.',
    'BOARD_DST'                 => 'Summer Time/<abbr title="Daylight Saving Time">DST</abbr> is in effect',
    'BOARD_LANGUAGE'            => 'My language',
    'BOARD_STYLE'               => 'My board style',
    'BOARD_TIMEZONE'            => 'My timezone',
    'BOARD_COUNTRY'             => 'My Country',
    'BOOKMARKS'                 => 'Bookmarks',
    'BOOKMARKS_EXPLAIN'         => 'You can bookmark topics for future reference. Select the checkbox for any bookmark you wish to delete, then press the <em>Remove marked bookmarks</em> button.',
    'BOOKMARKS_DISABLED'        => 'Bookmarks are disabled on this board.',
    'BOOKMARKS_REMOVED'         => 'Bookmarks removed successfully.',
    'POPUP_ON_PM'               => 'Pop up window on new private message',
    'NOTIFY_METHOD'             => 'Notification method',
    'NOTIFY_METHOD_BOTH'        => 'Both',
    'TITLE'                     => 'Title',
    'NOTIFY_METHOD_EMAIL'       => 'email only',
    'NOTIFY_METHOD_EXPLAIN'     => 'Method for sending messages sent via this board.',
    'NOTIFY_METHOD_IM'          => 'Jabber only',
    'NOTIFY_ON_PM'              => 'Notify me on new private messages',
    'HIDE_ONLINE'               => 'Hide my online status',
    'HIDE_ONLINE_EXPLAIN'       => 'Changing this setting won\'t become effective until your next visit to the board.',
    'HOLD_NEW_MESSAGES'         => 'Do not accept new messages (New messages will be held back until enough space is available)',
    'HOLD_NEW_MESSAGES_SHORT'   => 'New messages will be held back',
    'ALLOW_PM'                  => 'Allow users to send you private messages',
    'ALLOW_PM_EXPLAIN'          => 'Note that administrators and moderators will always be able to send you messages.',
    'SHOW_EMAIL'                => 'Users can contact me by email',
    'ADMIN_EMAIL'               => 'Administrators can email me information',
    'NO_FRIENDS_ONLINE'         => 'No friends online',
    'EDIT_DRAFT_EXPLAIN'        => 'Here you are able to edit your draft. Drafts do not contain attachment and poll information.',
    'NEW_PM'                    => 'New Message',
    'CHOOSE_AVATAR'             => 'Choose Avatar',
    'ACCOUT_STATUS'             => 'Account Status',
    'ACCOUT_EXP_STATUS'         => 'Set User Active/Inactive. BEWARE! Setting a User that has been Registered for more than 48h to INACTIVE will also Delete the Account.',
    'NO_WATCHED_FORUMS'         => 'You are not subscribed to any forums.',
    'NO_WATCHED_TORRENTS'       => 'You are not subscribed to any torrents.',
    'NO_WATCHED_TOPICS'         => 'You are not subscribed to any topics.',
    'WATCHED_FORUMS'            => 'Watched forums',
    'WATCHED_TOPICS'            => 'Watched topics',
    'UNWATCH_MARKED'            => 'Unwatch marked',
    '_WATCHED_TORRENTS'         => 'Watched torrents',
    '_WATCHED_FORUMS'           => 'Watched forums',
    '_WATCHED_TOPICS'           => 'Watched topics',
    'SIGNATURE_PREVIEW'         => 'Your signature will appear like this in posts',
    'WATCHED_EXPLAIN'           => 'Below is a list of forums and topics you are subscribed to. You will be notified of new posts in either. To unsubscribe mark the forum or topic and then press the <em>Unwatch marked</em> button.',
    'UCP_BAN_USER_FORUM'        => 'Ban user from the Forum',
    'USE_PASSKEY'               => 'Use Passkey',
    'RESSET_PASSKEY'            => 'Reset Passkey',
    'RES_PASSKEY_WARNING'       => '<b>WARNING</b>: all the torrent files you downloaded so far will NOT be Valid any more!',
    'ACCEPT_EMAIL'              => 'Accept email by Other Users',
    'ACCEPT_EMAIL_EXP'          => 'Allow Users of this site to see your Email Address',
    'ACCEPT_EMAIL_ACP'          => 'Administrators can email me information',
    'ACCEPT_EMAIL_ACP_EXP'      => 'Allow mass email From this site',
    'INACTIVE'                  => 'Inactive',
    'ACC_LEVEL'                 => 'Access Level',
    'ERROR_SUBJECT_NUBER'       => 'The Subscription Is not a number please go back and try again',
    'NO_DRAFTS_SET'             => 'No Draft is set please check your link',
    'DELETE_DRAFTS'             => 'Delete Drafts',
    'VIEW_FORUM_TOPICS'         => '%d topics',
    'VIEW_FORUM_TOPIC'          => '1 topic',
    'M_SITE_HELPER'             => 'Site Helper',
    'ACP_PM_NOTICE_EMAIL'       => 'Accespt pm notifacation',
    'ACP_PM_NOTICE_EMAIL_EXP'   => 'Allow system to send you a email Notice of new PM\'s',
    'TOR_PERPAGE'               => 'Torrents Perpage',
    'PARK_ACC'                  => 'Park account',
    'PARK_ACC_EXP'              => 'You can park your account for up to 90 days while on vacation or without internet, etc. Your account cannot be deleted during this time but on day 91 it can. HnR\'s will not accrue while parked but they will resume when unparked. You can not download any torrents while your account is parked!',
));

?>