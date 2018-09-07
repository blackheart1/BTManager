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
** File ucp/english.php 2018-08-31 18:40:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-22 - Amended the Wording of some Sentences
** 2018-04-23 - Added Missing Languages
** 2018-04-28 - Amended the Wording of some Sentences
** 2018-04-28 - Added Missing Languages
** 2018-06-16 - Added New Languages
** 2018-08-31 - Added Missing Languages
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'BLACK_LIST_USER'        => 'Refuse this User\'s Messages',
    'BLACK_LIST_REMOVE'      => 'Don\'t Refuse this User\'s Messages',
    'ADD_BUDDY'              => 'Add to Buddies',
    'BUDDY_REMOVE'           => 'Remove from Buddies',
    'ERR_NO_BODY'            => 'Empty Message Body',
    'ERR_NO_SUB'             => 'You have to Specify a Subject',
    'UCP_WARNED_MES'         => 'You have been WARNNED by %1$s for %2$s with Reason: %3$s',
    'WARNNING'               => 'Warning',
    'TOR_IMG_SEED'           => 'Currently Seeding',
    'TOR_IMG_LEECH'          => 'Currently Leeching',
    'EMAILS_NOT_MATCH'       => 'The email Address\'s you entered DO NOT Match.',
    'UCP_DISABLE_ACC'        => 'Disable Account',
    'UCP_BAN_FORUM'          => 'Forum Ban',
    'UCP_SHOUT_BAN'          => 'Ban Shouts',
    'UCP_UNSHOUT_BAN'        => 'Unban Shouts',
    'UCP_HELPER_FOR'         => 'What is the User Helpful for?',
    'ACTIVE_IN_FORUM'        => 'Most Active Forum',
    'ACTIVE_IN_TOPIC'        => 'Most Active Topic',
    'USER_SEEDBOX'           => 'User\'s Seedbox IP Address',
    'UCP_BAN_USER'           => 'Ban User',
    'UCP_UNBAN_USER'         => 'Unban User',
    'BACK_TO_DRAFTS'         => 'Back to Drafts',
    'YOU_CANT_BAN_YOURSELF'  => 'You can NOT Ban Yourself',
    'UCP_SHOUT_BAN_EXPL'     => 'User will NOT be able to View or Post Shouts',

    'UCP_DISABLE_ACC_EXPL'   => 'Disabled Accounts can NOT View or Download Torrents.<br />Disabled Accounts will NO longer be able to Access ALL the Site.<br />This is a Mild form of Banning, this way the User will be able to Access the Site to find out WHY they have been Disabled.',

    'INV_LEVEL_TO_EDIT'      => 'You DO NOT have Access to Edit this Person',
    'UCP_WARN_WEEK'          => '%s Week%s',
    'CONFERM_EMAIL_SUB'      => 'Confirm email on %1$s',
    'WARN_MOD_MES'           => '%1$s - Warned for %2$s by %3$s - Reason: %4$s',
    'LOG_GROUP_CHANGE'       => 'Group Changed for %1$s to %2$s',
    'LOG_LEVEL_CHANGE'       => 'Level Changed for %1$s to %2$s',
    'UCP_WARN_REMOVED_MES'   => 'Your Warning was Removed by %1$s!',
    'UCP_WARN_REASON_EXPL'   => 'Note Added to Users Private Message as to WHY they have been Warned',
    'WARN_REMOVE_MOD_MESS'   => '%1$s - Warning Removed by %2$s',
    'PROFILE_UPDATED'        => 'Your Profile has been Updated',
    'USE_PROFILE_UPDATED'    => 'User\'s Profile has been Updated',
    'NO_AUTHBAN_SHOUTS'      => 'You DO NOT have Access to Ban Shouts',
    'SHOUTS_BANNED'          => 'User has been Banned from the Shoutbox',
    'SHOUTS_UN_BANNED'       => 'User has been Unbanned from the Shoutbox',
    'DRAFTS_EXPLAIN'         => 'Here you can View, Edit and Delete your Saved Drafts.',
    'LOGIN_ERROR_NP'         => 'Username or Password NOT Specified.',
    'LOGIN_ERROR_NP_WRONG'   => 'Incorrect Username or Password!!',
    'LOGIN_ERROR_NOT_ACTIVE' => 'User Registered but NOT Active!!',
    'EMAIL_CHANGE_NOT_SET'   => 'No email Change is Set',
    'EMAIL_CHANGED'          => 'Your email was Successfully Changed',
    'EMAIL_CHANGE_INV'       => 'Invalid Confirmation Code or User ID',
    'EMAIL_CHANGE'           => 'email Change',
    'USER_BAN_NO_DEL'        => 'User is Banned.  DO NOT Delete',

    'CONFERM_DELETE_USER'    => '<strong>WARNING</strong>: You are about to Completely and Permanently Delete %1$s\'s Account. %1$s Editing Permissions for ALL Torrents that they\'ve Uploaded.  Re-Registering with the same Username will be possible after that.',

    'PASS_RECOVER_NOT_SET'   => 'No Recovery Password is Set',
    'PASS_RECOVER_INV'       => 'Invalid Confirmation Code or User ID',
    'PASS_RECOVER'           => 'Password Recovery',
    'PASS_RECOVER_COMPLETE'  => 'Password Changed.  Now you can Login with your NEW Password.',

    'ACC_NOW_ACTIVATED'      => 'Activation Complete.  Your Account is now Activated.  You can Access the Site using the Username and Password that you provided.  Have a nice Download.',

    'VIEW_AVATARS'           => 'Display Avatars',
    'VIEW_EDIT'              => 'View/Edit',
    'VIEW_FLASH'             => 'Display Flash Animations',
    'VIEW_IMAGES'            => 'Display Images within Posts',
    'VIEW_NEXT_HISTORY'      => 'Next Private Message in History',
    'VIEW_NEXT_PM'           => 'Next Private Message',
    'VIEW_PM'                => 'View Private Message',
    'VIEW_PM_INFO'           => 'Private Message Details',
    'VIEW_PM_MESSAGE'        => '1 Private Message',
    'VIEW_PM_MESSAGES'       => '%d Private Messages',
    'VIEW_PREVIOUS_HISTORY'  => 'Previous Private Message in History',
    'VIEW_PREVIOUS_PM'       => 'Previous Private Message',
    'VIEW_SIGS'              => 'Display Signatures',
    'VIEW_SMILIES'           => 'Display Smilies as Images',
    'VIEW_TOPICS_DAYS'       => 'Display Topics from Previous Days',
    'VIEW_TOPICS_DIR'        => 'Display Topic Order Direction',
    'VIEW_TOPICS_KEY'        => 'Display Topics Ordering by',
    'VIEW_POSTS_DAYS'        => 'Display Posts from Previous Days',
    'VIEW_POSTS_DIR'         => 'Display Post Order Direction',
    'VIEW_POSTS_KEY'         => 'Display Posts Ordering by',
    'DISABLE_CENSORS'        => 'Enable Word Censoring',
    'DEFAULT_ACTION'         => 'Default Action',
    'DEFAULT_ACTION_EXPLAIN' => 'This Action will be Triggered if None of the above is Applicable.',
    'DEFAULT_ADD_SIG'        => 'Attach my Signature by Default',
    'DEFAULT_BBCODE'         => 'Enable BBCode by Default',
    'DEFAULT_NOTIFY'         => 'Notify me upon Replies by Default',
    'DEFAULT_SMILIES'        => 'Enable Smilies by Default',
    'BIRTHDAY'               => 'Birthday',
    'BIRTHDAY_EXPLAIN'       => 'Setting a Year will List your Age when it is your Birthday.',
    'BOARD_DATE_FORMAT'      => 'My Date Format',
    'DAY'                    => 'Day',
    'MONTH'                  => 'Month',
    'YEAR'                   => 'Year',

    'BOARD_DATE_FORMAT_EXPLAIN' => 'The Syntax Used is Identical to the PHP <a href=\'http://www.php.net/date\'>date()</a> Function.',

    'BOARD_DST'               => 'Summer Time/<abbr title=\'Daylight Saving Time\'>DST</abbr> is in effect',
    'BOARD_LANGUAGE'          => 'My Language',
    'BOARD_STYLE'             => 'My Board Style',
    'BOARD_TIMEZONE'          => 'My Time Zone',
    'BOARD_COUNTRY'           => 'My Country',
    'BOOKMARKS'               => 'Bookmarks',

    'BOOKMARKS_EXPLAIN'       => 'You can Bookmark Topics for Future Reference.  Select the Checkbox for any Bookmarks you wish to Delete, then Press the <em>Remove Marked Bookmarks</em> Button.',

    'BOOKMARKS_DISABLED'      => 'Bookmarks are Disabled on this Board.',
    'BOOKMARKS_REMOVED'       => 'Bookmarks Removed Successfully.',
    'POPUP_ON_PM'             => 'Pop-Up Window on New Private Message',
    'NOTIFY_METHOD'           => 'Notification Method',
    'NOTIFY_METHOD_BOTH'      => 'Both',
    'TITLE'                   => 'Title',
    'NOTIFY_METHOD_EMAIL'     => 'email Only',
    'NOTIFY_METHOD_EXPLAIN'   => 'Method for Sending Messages Sent via this Board.',
    'NOTIFY_METHOD_IM'        => 'Jabber Only',
    'NOTIFY_ON_PM'            => 'Notify me when New Private Messages are Received',
    'HIDE_ONLINE'             => 'Hide my Online Status',
    'HIDE_ONLINE_EXPLAIN'     => 'Changing this Setting WILL NOT become Effective until your Next Visit to the Site.',
    'HOLD_NEW_MESSAGES'       => 'DO NOT Accept New Messages (New Messages will be Held Back until enough Space is Available)',
    'HOLD_NEW_MESSAGES_SHORT' => 'New Messages will be Held Back',
    'ALLOW_PM'                => 'Allow Users to Send you Private Messages',
    'ALLOW_PM_EXPLAIN'        => 'Note that Moderators and Administrators will Always be able to Send you Messages.',
    'SHOW_EMAIL'              => 'Users can Contact me by email',
    'ADMIN_EMAIL'             => 'Administrators can email me Information',
    'NO_FRIENDS_ONLINE'       => 'No Friends Online',
    'EDIT_DRAFT_EXPLAIN'      => 'Here you are able to Edit your Draft.  Drafts DO NOT contain Attachment and Poll Information.',
    'NEW_PM'                  => 'New Message',
    'CHOOSE_AVATAR'           => 'Choose Avatar',
    'ACCOUT_STATUS'           => 'Account Status',

    'ACCOUT_EXP_STATUS'       => 'Set User Active/Inactive.  BEWARE! Setting a User that has been Registered for Less than 48 hours will also Delete their Account.',

    'NO_WATCHED_FORUMS'       => 'You are NOT Subscribed to any Forums.',
    'NO_WATCHED_TORRENTS'     => 'You are NOT Subscribed to any Torrents.',
    'NO_WATCHED_TOPICS'       => 'You are NOT Subscribed to any Topics.',
    'WATCHED_FORUMS'          => 'Watched Forums',
    'WATCHED_TOPICS'          => 'Watched Topics',
    'UNWATCH_MARKED'          => 'Unwatch Marked',
    '_WATCHED_TORRENTS'       => 'Watched Torrents',
    '_WATCHED_FORUMS'         => 'Watched Forums',
    '_WATCHED_TOPICS'         => 'Watched Topics',
    'SIGNATURE_PREVIEW'       => 'Your Signature will appear like this in Posts',

    'WATCHED_EXPLAIN'         => 'Below is a List of Forums and Topics that you are Subscribed to.  You\'ll be Notified of any New Posts.  To Unsubscribe, Mark the Forum or Topic and then Press the <em>Unwatch Marked</em> Button.',

    'UCP_BAN_USER_FORUM'      => 'Ban the User from the Forums',
    'USE_PASSKEY'             => 'Use Passkey',
    'RESSET_PASSKEY'          => 'Reset Passkey',

    'RES_PASSKEY_WARNING'     => '<strong>WARNING</strong>: ALL the Torrent Files you Downloaded so far will NOT be Valid any more!',

    'ACCEPT_EMAIL'            => 'Accept emails from Other Users',
    'ACCEPT_EMAIL_EXP'        => 'Allow Users of this Site to see your email Address',
    'ACCEPT_EMAIL_ACP'        => 'Administrators can email me Information',
    'ACCEPT_EMAIL_ACP_EXP'    => 'Allow Mass email from this Site',
    'INACTIVE'                => 'Inactive',
    'ACC_LEVEL'               => 'Access Level',
    'ERROR_SUBJECT_NUBER'     => 'The Subscription is NOT a Number.  Please go back and try again!',
    'NO_DRAFTS_SET'           => 'No Draft is Set.  Please Check your Link!',
    'DELETE_DRAFTS'           => 'Delete Drafts',
    'DELETE_DRAFT'            => 'Remove Selected Drafts',
    'DELETE_DRAFT_CONFIRM'    => 'Are you Sure you want to Delete ALL Selected Drafts?',
    'VIEW_FORUM_TOPICS'       => '%d Topics',
    'VIEW_FORUM_TOPIC'        => '1 Topic',
    'M_SITE_HELPER'           => 'Site Helper',
    'ACP_PM_NOTICE_EMAIL'     => 'Accept Private Message Notifications',
    'ACP_PM_NOTICE_EMAIL_EXP' => 'Allow the System to Send you an email Notice of New Private Message\'s',
    'TOR_PERPAGE'             => 'Torrents Per Page',
    'PARK_ACC'                => 'Park Account',

    'PARK_ACC_EXP'            => 'You can Park your Account for up to 90 days while your on Vacation or without Internet Access, etc.  Your Account can NOT be Deleted during this time but, on day 91 it CAN.  HnR\'s will NOT occur while Parked but, they will Resume when Un-Parked.  You can NOT Download any Torrents while your Account is Parked!',

    'TO_REMOVE_USER'       => 'To Remove Usernames, Select them and Click Submit.',

    'FOES_EXPLAIN'         => 'Foes are Users which will be Ignored by Default.  Posts by these Users will NOT be Fully Visible.  Personal Messages from Foes are still Permitted.  Please Note: you can NOT Ignore Moderators or Administrators.',

    'NO_FOES'              => 'No Foes Currently Defined:',
    'YOUR_FOES'            => 'Your Foes:',
    'ADD_FOES'             => 'Add New Foes:',
    'ENTER_USERS'          => 'You may Enter Several Usernames, each on a Separate Line. ',
    'FIND_MEMBER'          => 'Find a Member',

    'FRIENDS_EXPLAIN'      => 'Friends Enable you to Quickly Access Users you Communicate with Frequently.  If the Template has relevant Support any Posts made by a Friend may be Highlighted.',

    'YOUR_FRIENDS'         => 'Your Friends:',
    'ADD_FRIENDS'          => 'Add New Friends:',
    'NO_FRIENDS'           => 'No Friends Currently Defined:',

    'UCP_EXPLANE'          => 'Welcome to the User Control Panel.  From here you can Monitor, View and Update your Profile, Preferences, Subscribed Forums and Topics.  You can also Send Messages to Other Users (if Permitted).  Please ensure you Read any Announcements before continuing.',

    'IMPORT_ANNOUNCE'      => 'Important Announcements',
    'NO_ANNOUNCEMENTS'     => 'No Important Announcements Present.',
    'YOUR_ACTIVATY'        => 'Your Activity',
    'JOINED'               => 'Date Joined ',
    'LAST_SEEN'            => 'Last Seen ',
    'TOTAL_POSTS'          => 'Total Posts ',
    'SHOW_YOUR_POSTS'      => 'Show your Posts',
    'OVERVIEW'             => 'Overview',
    'FRONT_PAGE'           => 'Front Page',
    'MANAGE_SUBS'          => 'Manage Subscriptions',
    'MANAGE_DRAFTS'        => 'Manage Drafts',
    'MANAGE_ATTACHMENTS'   => 'Manage Attachments',
    'PROFILE'              => 'Profile',
    'EDIT_PROFILE'         => 'Edit Profile',
    'EDIT_SIGNATURE'       => 'Edit Signature',
    'EDIT_AVATAR'          => 'Edit Avatar',
    'EDIT_SETTINGS'        => 'Edit Account Settings',
    'EDIT_ADMIN_SETTINGS'  => 'Administrator Account Settings',
    'BOARD_PREFS'          => 'Board Preferences',
    'EDIT_GLOBAL_SETTINGS' => 'Edit Global Settings',
    'FRIEND_FOE'           => 'Friends and Foes',
    'MANAGE_FRIENDS'       => 'Manage Friends',
    'MANAGE_FOES'          => 'Manage Foes',
    'FRIEND_ONLINE'        => 'Friends',
    'SIGNATURE_EXPLAIN'    => 'This is a Block of Text that can be Added to your Posts.  There is a 255 Character Limit.',
    'ONLINE'               => 'Online',

    #Added For 3.0.1
    '_AVATAR_EXPLAIN'          => 'Maximum Dimensions; Width: %1$d Pixels, Height: %2$d Pixels, File Size: %3$.2f KiB.',
    'UPLOAD_LOCAL_AVATAR'      => 'Upload Avatar from your Computer',
    'UPLOAD_LOCAL_AVATAR_EXP'  => 'Select an Image from your Computer to be Uploaded to the Site for use as your Avatar.',
    'UPLOAD_EXT_AVATAR'        => 'Upload from a URL',

    'UPLOAD_EXT_AVATAR_EXP'    => 'Enter the URL of the Location Containing the Image.  The Image will then be Copied to the Site.',

    'LINK_EXT_AVATAR'          => 'Link Off-Site',
    'LINK_EXT_AVATAR_EXP'      => 'Enter the URL of the Location Containing the Avatar Image you wish to Link to.',
    'LINK_REMOTE_SIZE'         => 'Avatar Dimensions',
    'LINK_REMOTE_SIZE_EXPLAIN' => 'Specify the Width and Height of the Avatar.  Leave Blank to Attempt Automatic Verification.',
    'AVATAR_GALLERY'           => 'Local Gallery',
    'MOD_COMMENTS'             => 'Mod Comments',
    'WARNED_TILL'              => 'Warned Until',
    'DELETE_WARNING'           => 'Delete Warning',
    'ONE_WEEK'                 => '1 Week',
    'TWO_WEEK'                 => '2 Weeks',
    'FOUR_WEEK'                => '4 Weeks',
    'EIGHT_WEEK'               => '8 Weeks',
    'NO_LIMET'                 => 'Unlimited Time',
    'FOR'                      => 'for',
    'WARN_USER_FOR'            => '<strong>Warn User</strong> for',
    'USER_NICK_EXP'            => 'Length must be between 3 and 20 Characters.',
    'PASSWORD_EXP'             => '(5 Characters Minimum)',
    'ICQ_IM'                   => 'ICQ Number',
    'AOL_IM'                   => 'AOL Instant Messenger',
    'MSN_IM'                   => 'MSN Messenger',
    'YH_IM'                    => 'Yahoo Messenger',
    'JAB_IM'                   => 'Jabber Address',
    'SKYPE_IM'                 => 'Skype Messenger',
    'PERSONAL'                 => 'Personal',
    'ICQ'                      => 'ICQ',
    'AIM'                      => 'AIM',
    'MSNM'                     => 'MSNM/WLM',
    'YIM'                      => 'YIM',
    'JABBER'                   => 'Jabber',
    'SKYPE'                    => 'Skype',
    'THANKS_LEFT'              => 'Thanks Left',
    'COMMENTS_LEFT'            => 'Comments Left',
    'SIGNATURE'                => 'Signature',
    'NUKED_TORRENT'            => 'Nuked Torrent',
    'FREE_TORRENT'             => 'Free Torrent',
    'BANNED_TORRENT'           => 'Banned Torrent',
    'BAN_EDIT'                 => 'Edit',
    'BAN_DELETE'               => 'Delete',
    'BAN_TORRENT'              => 'Ban Torrent',
    'REFRESH_TORRENT'          => 'Refresh Peer Data',
    'UPDATE_STATS'             => 'Stats Updated less than 30 minutes ago',
    'EXTERNAL_TORRENT'         => 'External Torrent',
    'PAGES'                    => 'Pages',
    '_PRIVATE_MESSAGE'         => 'Private Message',
    'DOWNLOAD'                 => 'Download',
    'SEARCH_USER_POST'         => 'Search User\'s Posts',
    'VIEW_USER_NOTES'          => 'View User Notes',
    'WARN_USER'                => 'Warn User',
    'RATIO'                    => 'Ratio',

    'DHT_EXPL'                 => 'This Torrent supports DHT.  With a State-of-the-art Client, you\'ll be able to Download this Torrent even if a Central Tracker goes down.',

    'DHT_SUPORT'               => 'DHT Support',
    'TORRENT DETAILS'          => 'Torrent Details',
    'POST_TIME'                => 'Post Time',
    'VIEW_DEAD_TORRENTS'       => 'View Dead Torrents',
    'VIEW_DEAD_TORRENTS_EXP'   => 'View Torrents that have No Peers.',
    'INVALID_OPTION'           => 'Invalid Option Set.  Please go back and try again!',
    'LOGGED_IN_USE_PRO_EDIT'   => 'You are Logged in.  Please use Edit Profile.',
    'NO_TOPIC_SET'             => 'No Topic is Set.  Please Check your Link.',
    'DRAFT_TITLE'              => 'Title',
    'SAVE_DATE'                => 'Date',
    'SAVE'                     => 'Save',
    'DELETE_RULE'              => 'Delete Rule',
));

?>