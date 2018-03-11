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
** File converter/english.php 2018-03-09 10:56:00 Thor
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

define("_btfilenamerror","Error in Filename");
define("_btnofilesintorrent","Missing Torrent Files");
define("_btmissinglength","Missing Files and Size");
define("_btinvpieces","Invalid Torrent Parts");
define("_btinvannounce","Invalid Announce URL. Must be ");
define("_bttrackerblacklisted","The Tracker used by this Torrent (<b>**trk**</b>) has been Blacklisted. Please use a different Tracker.");

define("_bttrackerdisabled","Our Tracker has been Disabled: Only External Torrents can be Uploaded.");

$lang = array_merge($lang, array(
    'WELCOME_MESSAGER'    => 'Welcome to BTManager Conversion Tool!',
    'BTM_CONVERTER'       => 'BTManager Converter!',
    'BTM_TABLES'          => 'BTManager Tables',
    'STORE_LOCAL'         => 'Store File Locally',
    'DOWNLOAD_STORE'      => 'Store and Download',
    'RAR_FILE'            => '.rar',
    'ZIP_FILE'            => '.zip',
    'TEXT_FILE'           => '.sql',
    'BUILD_SQL'           => 'Build SQL',
    'SELECT_ALL'          => 'Select ALL',
    'DESELECT_ALL'        => 'Deselect ALL',
    'CURENT_TABLES'       => 'Current Tables',
    'TABLE_SELECT'        => 'Table Select',
    'BACK_UP_FUL_OPTION'  => 'Full Backup',
    'BACK_UP_FILE_OPTION' => 'Files Backup',
    'BACK_UP_DB_OPTION'   => 'Database Backup',
    'BACK_UP_COMPLETE'    => 'Backup Completed Successfully',

    'DOWN_LOAD_BACK_START' => 'Your Backup was Successfully Completed and the Download will begin shortly.  If your Browser Does NOT give you the Option to Start the Download then <a href=\'%1$s\'>(Click Here)</a>',

    'BACKUP_SUCCESSFULL' => 'Your Backup was Successfully Completed!',
    'TABLE_COMPAIR'      => 'We have Marked the Matched Tables!',

    'TABLE_COMPAIR_EXP'  => 'Below are Tables found to match BTManager\'s Tables so you will NOT have to do anything with them!<br />If the Table is Marked Matched those will be the Tables we are going to be working with.<br />You will Notice that the User Table and the Torrent Table now show as well so we\'ll work with these at a later point.',

    'CONVERT_EXP'        => 'With this Tool you will Convert your Old Tracker Source over to BTManager<br />There are several steps to this and it will take time to complete.<br />In the First Step we will retrieve your Database Table Information for both BTManager and your previous source.<br />Before we start you may want to <strong>Back Up</strong> Your Site if not just Click Next!',

    'BACK_UPDATA_BASE' => 'Database Backup',
    'BACKUP_TYPE'      => 'Backup Type',
    'FILE_TYPE'        => 'File Type',
    'FULL_BACKUP'      => 'Full',
    'BACKUP'           => 'BackUp',

    'BUILD_EXP'        => 'We Are going to Start Building a Conversion SQL to Import some Extra Information.<br />You will notice some of the Tables are Missing this is because they are ether NOT needed or will be Addressed at a later point.<br />As we go through your Database Tables we will try to find some Matching Tables and Import the Information from them.<br />If we find a Table that matches but the Information inside is different we will walk you through Converting the Information Over.',

    'MATCH_FOUND'      => 'This Table is a Match, would you like to Import it?',
    'MATCH_CONVERT'    => 'This Table Is NOT a Match would you like to Convert it?',
    'MATCH_MOD'        => 'Modify Match',
    'NEXT'             => 'Next',
    'SKIP'             => 'Skip',

    'SUCCES_MOD_TAKEN'   => 'The Table has been Modified and the Information Imported you may now Proceed to the Next Table',

    'SUCCES_TABLES_CONV' => 'You have finished Modifying your Tables and the Information has been Imported<br />We can now proceed to process your Users <form action=\'converter.php\' ><input type=\'hidden\' name=\'op\' value=\'4\'><input type=\'hidden\' name=\'op\' value=\'2\'><input class=\'btnmain\' accesskey=\'s\' tabindex=\'11\' name=\'post\' value=\'Build Users\' type=\'submit\'>',

    'NEXT_STEP' => 'Now that we have finished your Backup we can move to the Next Stage of building the SQL Insert File to Import your Old Site To BTManager <form action=\'converter.php\' ><input type=\'hidden\' name=\'op\' value=\'2\'><input class=\'btnmain\' accesskey=\'s\' tabindex=\'11\' name=\'post\' value=\'Build SQL\' type=\'submit\'>',

    'DATA_ONLY'              => 'Data Only',
    'USER_TABLE_QA'          => 'User Table Information',
    'USER_TABL_NAME'         => 'User Table Name',
    'USER_TABL_NAME_EXP'     => 'What is the Name of the Table for your User information?',
    'TOR_TABLE_QA'           => 'Torrent Table/Folder',
    'TORRENT_FOLDER'         => 'Torrent Folder',
    'SUC_FOLDER_FOUND'       => 'Success Folder Found',
    'ER_FOLDER_FOUND'        => 'Error Folder NOT Found',
    'SUC_TORRENT_TABLE'      => 'Success Table Found',
    'ER_TORRENT_TABLE'       => 'Error Table NOT Found',
    'TORRENT_FOLDER_SIZE'    => 'Torrent Folder Size',
    'TORRENT_FOLDER_FILES'   => 'Torrent Files',
    'TORRENTS_LISTED'        => 'Torrents Listed',

    'USER_TABLE_MODF_EXP'    => 'Please Match as many rows as you can the most important rows will be ID, Name, email, and Registered Date,<br />Users with the same email Address must be fixed because BTManager DOES NOT Allow this so, please select how to Create these Accounts.',

    'YOUR_ID'                => 'Your Old User ID',
    'TORRENT_PATH'           => 'Old Torrent Directory',
    'TORRENT_PATH_EXP'       => 'Give the Path to your Old Torrents.',
    'TORRENT_TABL_NAME'      => 'Torrent Table',
    'TORRENT_TABL_NAME_EXP'  => 'Give the Name of the Database Torrent Table',
    'YOUR_ID_EXP'            => 'What is your Old ID Number?',

    'IMPORT_USER_EXP'        => 'In this part we will go through your Users Table and try to get as much Information as we can.',

    'USER_TABLE_INFO'        => 'We need a little Information to get started',
    'STRUCTURE_ONLY'         => 'Structure Only',

    'SUCCESS_USERS_IMPORTED' => 'Your Users have been Successfully Imported.  You will want to go through your Administrator and Moderator Accounts and Adjust there Levels and Groups <form action=\'converter.php\' ><input type=\'hidden\' name=\'op\' value='5'><input class=\'btnmain\' accesskey=\'s\' tabindex='11' name=\'post\' value=\'Next\' type=\'submit\'></form>',

    'EMAIL_NOTCE_SUB' => '%1$s Has changed your Password',

    'EMAIL_BODY'      => 'Dear %1$s,' . '\n\n We have changed our source code and in doing so have had to change your password\nWe have taken this time to inform you of this Action and provide you with your New Password\n' . '%2$s ' . '\n' . 'You can login and change it back if you like Here %3$s' . '\n' . '%4$s',

    'BACK_UP_EXP'     => 'Here you can Backup ALL your Site Data. You may Store the Resulting Archive in your <samp>Backups/</samp> Folder or Download it Directly. Depending on your Server Configuration you may be able to Compress the File in a Number of Formats.  Or you could try to email it to yourself',

    'TABLE_USE' => array(
        'PREFIX_acl_groups'         => 'Permission Roles and/or Individual Permissions Assigned to Groups',

        'PREFIX_acl_options'        => 'This Table contains the information which Permissions (\'can Read Forum\', \'can Post Topics\' etc.) are available.',

        'PREFIX_acl_roles'          => 'Permission Roles (Standard Moderator, Simple Moderator etc.)',
        'PREFIX_acl_roles_data'     => 'This Table Stores which Permissions each Role Contains.',
        'PREFIX_acl_users'          => 'Permission Roles and/or Individual Permissions Assigned to Users.',
        'PREFIX_attachments'        => 'This Table Stores Attachment Information for the Forum and Private Messages.',
        'PREFIX_attachments_config' => 'This Table holds the Attachment Configuration.',
        'PREFIX_avatar_config'      => 'This Table holds Avatar Configuration Settings.',
        'PREFIX_avps'               => 'This Table Holds Cleanup Times for the Site.',
        'PREFIX_banlist'            => 'Forum Banned users.',
        'PREFIX_bans'               => 'Site Ban List',
        'PREFIX_bbcodes'            => 'Extra BBcodes Used in Shouts, Torrent Upload Information, Comments and Forum Posts.',
        'PREFIX_bonus'              => 'Table of Items Users can Spend Bonus Points on.',
        'PREFIX_bonus_points'       => 'Bonus Points Configuration Table.',
        'PREFIX_bookmarks'          => 'Overall Bookmarks Table used in the Forum',
        'PREFIX_cache_con'          => 'Cache Configuration Table.',
        'PREFIX_categories'         => 'Categories Used for Torrents.',
        'PREFIX_client_ban'         => 'Torrent Client Ban List.',
        'PREFIX_comments'           => 'Comment Table Used For Torrents.',
        'PREFIX_comments_notify'    => 'Comment Notification Table used for Users that want to be notified of New Comments on a Torrent.',

        'PREFIX_complaints'         => 'Torrent Complaint Table Used for Torrent Ratings, Complaints and Positive Feedback.',
        'PREFIX_config'             => 'Overall Site Configuration Table.',
        'PREFIX_countries'          => 'List of Countries Users can use in their Profile.',
        'PREFIX_download_completed' => 'Table of Completed Downloads for Users.',
        'PREFIX_drafts'             => 'Drafts Table used to hold Forum Topics, Forum Posts and PM Drafts.',
        'PREFIX_extensions'         => 'Table of Extensions used for Attachments.',
        'PREFIX_extension_groups'   => 'List of Groups for Extensions',
        'PREFIX_faq'                => 'FAQ\'s Table.',
        'PREFIX_files'              => 'Files Table Used for holding a List of Files Included in Torrents.',
        'PREFIX_filter'             => 'Filter Table, a List of Key Words to Exclude in Uploads.',
        'PREFIX_forums'             => 'Forum Table For the Forum Topics and Forums.',
        'PREFIX_forums_access'      => 'Forum Access Table for listing Users in a Forum.',

        'PREFIX_forums_track'       => 'This Table keeps a Record for Visited Forums in Order to Mark them as Read or Unread. We use the \'mark_time timestamp\' in conjunction with last post of Forum X\'s Timestamp to know when ALL Topics in Forum X were Last Marked Read. ',

        'PREFIX_forums_watch'       => 'Forum Watch Table used for Users that wish to Watch a Forum for New Posts.',
        'PREFIX_forum_config'       => 'Forum Configuration Table.',
        'PREFIX_forum_permissions'  => 'Deprecated Table',
        'PREFIX_hit_n_run'          => 'Hit And Run Configuration Table.',
        'PREFIX_icons'              => 'Icons Table a List of Icons used for File Types',
        'PREFIX_img_bucket'         => 'Image Bucket Configuration Table.',
        'PREFIX_levels'             => 'Levels Table, List of Groups and their Privileges in the Main Site.',
        'PREFIX_level_privlages'    => 'Level Privileges, List of Privileges on the Main Site.',
        'PREFIX_level_settings'     => 'Level Settings, List of Groups and their Settings such as Avatar, Colour.....',

        'PREFIX_log'                => 'List of Site Logs.',
        'PREFIX_massupload'         => 'Table used to hold Information while using the Mass Upload System',
        'PREFIX_moderator_cache'    => 'Moderator Cache Table, List of Moderators for each Forum.',
        'PREFIX_modules'            => 'Modules Table a List of Modules used for the Forum Moderator Section.',
        'PREFIX_online_users'       => 'Online Users Table, List of Users Online.',
        'PREFIX_paypal'             => 'PayPal Configuration Table.',
        'PREFIX_peers'              => 'Peers Table, List of Active Peers.',

        'PREFIX_pollanswers'        => 'Poll Answer Table, List of Poll Answers used on the Forum Side of the Site.',

        'PREFIX_polls'              => 'Polls Table, List of Polls and Questions for the Main site.',
        'PREFIX_poll_options'       => 'Poll Option Table, List of Polls and Questions for the Forums',
        'PREFIX_poll_votes'         => 'Poll Votes Table, List of Poll Votes',
        'PREFIX_posts'              => 'Posts Table, Post made in the Forum.',

        'PREFIX_privacy_backup'             => '',
        'PREFIX_privacy_file'               => '',
        'PREFIX_privacy_global'             => '',
        'PREFIX_private_messages'           => '',
        'PREFIX_private_messages_blacklist' => '',
        'PREFIX_private_messages_bookmarks' => '',
        'PREFIX_private_messages_rules'     => '',
        'PREFIX_privmsgs_folder'            => '',
        'PREFIX_privmsgs_to'                => '',
        'PREFIX_ranks'                      => '',
        'PREFIX_ratings'                    => '',
        'PREFIX_ratiowarn'                  => '',
        'PREFIX_ratiowarn_config'           => '',
        'PREFIX_reports'                    => '',
        'PREFIX_reports_reasons'            => '',
        'PREFIX_rules'                      => '',
        'PREFIX_search_cloud'               => 'Search Cloud Configurations.',
        'PREFIX_search_text'                => 'Search Cloud Text.',
        'PREFIX_seeder_notify'              => '',
        'PREFIX_sessions'                   => '',
        'PREFIX_shouts'                     => '',
        'PREFIX_shout_config'               => '',
        'PREFIX_smiles'                     => '',
        'PREFIX_snatched'                   => '',
        'PREFIX_thanks'                     => '',
        'PREFIX_time_offset'                => '',
        'PREFIX_topics'                     => '',
        'PREFIX_topics_posted'              => '',
        'PREFIX_topics_track'               => '',
        'PREFIX_topics_watch'               => '',
        'PREFIX_torrents'                   => '',
        'PREFIX_trackers'                   => '',
        'PREFIX_userautodel'                => '',
        'PREFIX_users'                      => '',
        'PREFIX_user_group'                 => '',
        'PREFIX_warnings'                   => '',
        'PREFIX_zebra'                      => '',
    ),
));

?>