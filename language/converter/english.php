<?php
/*
*------------------------------phpMyBitTorrent V 3.0.0-------------------------* 
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*--------            ©2013 BT.Manager Development Team                 --------*
*-----------               http://btmagaer.com                      -----------*
*------------------------------------------------------------------------------*
*--------------------  Wednesday, April 17, 2013 8:11 PM  ---------------------*
*
*
* converter [English]
*
* @package language
* @version $Id$
* @copyright (c) 2013 BT.Manager Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
define("_btfilenamerror","Error in File name");
define("_btnofilesintorrent","Missing Torrent Files");
define("_btmissinglength","Missing Files and Size");
define("_btinvpieces","Invalid Torrent Parts");
define("_btinvannounce","Invalid Announce URL. Must be ");
define("_bttrackerblacklisted","The Tracker used by this Torrent (<b>**trk**</b>) has been Blacklisted. Please use a different Tracker.");
define("_bttrackerdisabled","Our Tracker has been Disabled: Only External Torrents can be Uploaded.");
$lang = array_merge($lang, array(
		'WELCOME_MESSAGER'		=>	'Welcome to BT.Manager Conversion Tool!',
		'BTM_CONVERTER'			=>	'BT.Manager Converter!',
		'BTM_TABLES'			=>	'BT.Manager Tables',
		'STORE_LOCAL'			=>	'Store file locally',
		'DOWNLOAD_STORE'		=>	'Store and download',
		'RAR_FILE'				=>	'.rar',
		'ZIP_FILE'				=>	'.zip',
		'TEXT_FILE'				=>	'.sql',
		'BUILD_SQL'				=>	'Build SQL',
		'SELECT_ALL'			=>	'Select all',
		'DESELECT_ALL'			=>	'Deselect all',
		'CURENT_TABLES'			=>	'Curent Tables',
		'TABLE_SELECT'			=>	'Table select',
		'BACK_UP_FUL_OPTION'	=>	'Full Backup',
		'BACK_UP_FILE_OPTION'	=>	'Files Backup',
		'BACK_UP_DB_OPTION'		=>	'Data Base Backup',
		'BACK_UP_COMPLETE'		=>	'Backup Completed Success fully',
		'DOWN_LOAD_BACK_START'	=>	'Your Back Was Succes Fully Complete download well begin shortly IF your browser dose not all this <a href="%1$s">(Click Here)</a>',
		'BACKUP_SUCCESSFULL'	=>	'Your Back Was Succes Fully Complete!',
		'TABLE_COMPAIR'			=>	'We have Marked matched tables!',
		'TABLE_COMPAIR_EXP'		=>	'Below are tables Found Most of the BT.Manager tables are only use in BT.Manager and you well not have to do anything with them!<br />If the table is marked matched those well be the tables we are going to be working with.<br />You well notice that the user table and the torrent table do now show as we well work with these at a later point.',
		'CONVERT_EXP'			=>	'With this tool you well convert your old tracker source over to the New BT.Manager<br />There are sveral steps to this and it well take Time to complete.<br />In the First step we Well retreave your data base table information for both BT.Manager and your prevease source.<br />Before We start You may want to <strong>Back Up</strong> Your site If Not just click next!',
		'BACK_UPDATA_BASE'		=>	'Data Base Backup',
		'BACKUP_TYPE'			=>	'Backup type',
		'FILE_TYPE'				=>	'File Type',
		'FULL_BACKUP'			=>	'Full',
		'BACKUP'				=>	'BackUp',
		'BUILD_EXP'				=>	'We Are going to Start Building A Convertion SQL To Import some extra Information.<br />You well notice some of the tables are missing this is because they are ether not needed or well be adressed at a later point.<br />As we Go threw your data base tables we well try to find some matching tables and import the information From them.<br />If we find a Table that matchs But the information inside is defrent well well walk you threw Converting the information over.',
		'MATCH_FOUND'			=>	'This TAble is a match Would you like to Import it?',
		'MATCH_CONVERT'			=>	'This Table Is Not a Match would you like to convert it?',
		'MATCH_MOD'				=>	'Modify Match',
		'NEXT'					=>	'Next',
		'SKIP'					=>	'Skip',
		'SUCCES_MOD_TAKEN'		=>	'The Table has been modified and info imported you may now procead to the next table',
		'SUCCES_TABLES_CONV'	=>	'You Have finnished Modifying your tables and the info has been inported<br />We can Now Proseed to prosses your users <form action="converter.php" ><input type="hidden" name="op" value="4"><input type="hidden" name="op" value="2"><input class="btnmain" accesskey="s" tabindex="11" name="post" value="Build Users" type="submit">',
		'NEXT_STEP'				=>	'Now that we have finnish your Backup we can moe to the next stage of building the SQL Insert file To import Your Old site To BT.Manager <form   action="converter.php" ><input type="hidden" name="op" value="2"><input class="btnmain" accesskey="s" tabindex="11" name="post" value="Build SQL" type="submit">',
		'DATA_ONLY'				=>	'Data Only',
		'USER_TABLE_QA'			=>	'User Table Info',
		'USER_TABL_NAME'		=>	'User Table Name',
		'USER_TABL_NAME_EXP'	=>	'What is the name of the table for your User info!',
		'TOR_TABLE_QA'			=>	'Torrent Table/Folder',
		'TORRENT_FOLDER'		=>	'Torrent Folder',
		'SUC_FOLDER_FOUND'		=>	'Success Folder Found',
		'ER_FOLDER_FOUND'		=>	'Error Folder Not Found',
		'SUC_TORRENT_TABLE'		=>	'Success Table Found',
		'ER_TORRENT_TABLE'		=>	'Error Table Not Found',
		'TORRENT_FOLDER_SIZE'	=>	'Torrent Folder Size',
		'TORRENT_FOLDER_FILES'	=>	'Torrent Files',
		'TORRENTS_LISTED'		=>	'Torrnets Listed',
		'USER_TABLE_MODF_EXP'	=>	'Please Match as many rows as you can the most importamd rows Well be id, Name, E-mail, and Reg date,<br />Users with the same email address mu be fixxed Because BT.Manager dose not allow this so please select How to treate these accounts.',
		'YOUR_ID'				=>	'Your Old User ID',
		'TORRENT_PATH'			=>	'Old Torrent directory',
		'TORRENT_PATH_EXP'		=>	'Give the path to your old torrents.',
		'TORRENT_TABL_NAME'		=>	'Torrent Table',
		'TORRENT_TABL_NAME_EXP'	=>	'Give the Name of the data base torrent Table',
		'YOUR_ID_EXP'			=>	'What is Your old ID number?',
		'IMPORT_USER_EXP'		=>	'In this part we well Go threw your users table and try to get as much information as we can.',
		'USER_TABLE_INFO'		=>	'We Need a little Info to get started',
		'STRUCTURE_ONLY'		=>	'Structure only',
		'SUCCESS_USERS_IMPORTED'=>	'Your users Have been Success fully imported You well want to go threw your admins and Moderator accounts and adjust there levels and groups <form   action="converter.php" ><input type="hidden" name="op" value="5"><input class="btnmain" accesskey="s" tabindex="11" name="post" value="Next" type="submit"></form>',
		'EMAIL_NOTCE_SUB'		=>	'%1$s Has Changed Your Password',
		'EMAIL_BODY'			=>	'Dear %1$s,' . "\n\n We have Changed Our Source code and In doing so have had to change your password\nWe have taken this time to Inform you of this Action and provide you with your New Password\n" . '%2$s ' . "\n" . 'You can login and change it back if You like Here %3$s' . "\n" . '%4$s',
		'BACK_UP_EXP'			=>	'Here you can backup all your site data. You may store the resulting archive in your <samp>backups/</samp> folder or download it directly. Depending on your server configuration you may be able to compress the file in a number of formats.OR try to E-mail it to your self',
		'TABLE_USE'				=>	array(
											'PREFIX_acl_groups'									=>	'Permission roles and/or individual permissions assigned to groups',
											'PREFIX_acl_options'									=>	'This table contains the formation which permissions ("can read forum", "can post topics" etc.) are available.',
											'PREFIX_acl_roles'										=>	'Permission roles (Standard Moderator, Simple Moderator etc.)',
											'PREFIX_acl_roles_data'								=>	'This table stores which permissions each role contains.',
											'PREFIX_acl_users'										=>	'Permission roles and/or individual permissions assigned to users.',
											'PREFIX_attachments'									=>	'This Table stores attament info for the Forum and Private messages.',
											'PREFIX_attachments_config'							=>	'This Table holds the Attachment Configs.',
											'PREFIX_avatar_config'									=>	'This Table holds Avatar Configuration Settings.',
											'PREFIX_avps'											=>	'This Table Holds Clean uptimes for the site.',
											'PREFIX_banlist'										=>	'Forum Banned users.',
											'PREFIX_bans'											=>	'Site Ban List',
											'PREFIX_bbcodes'										=>	'Extra BBcodes Used in Shouts, Torrent upload info, Comments and Forum posts.',
											'PREFIX_bonus'											=>	'Table Of Items Users can spend Bonus Points on.',
											'PREFIX_bonus_points'									=>	'Bonus Points Config Table.',
											'PREFIX_bookmarks'										=>	'Over all Book Marks Table Used in the Forum',
											'PREFIX_cache_con'										=>	'Cache Config Table.',
											'PREFIX_categories'									=>	'Categories Used for Torrents.',
											'PREFIX_client_ban'									=>	'Torrent Client Ban List.',
											'PREFIX_comments'										=>	'Comment Table Used For Torrents.',
											'PREFIX_comments_notify'								=>	'Comment Notifacation Table Used For users that Want notified of new coments on a Torrent.',
											'PREFIX_complaints'									=>	'Torrent Complaint Table Used for Torrent Ratings, Complaints and Positive Feedback.', 
											'PREFIX_config'										=>	'Over all site Configuration Table.',
											'PREFIX_countries'										=>	'List of Countries Users can use in there Profile.',
											'PREFIX_download_completed'							=>	'Table of completed downloads For users.',
											'PREFIX_drafts'										=>	'Drafts Table Used to Hold forum Topics, Forum Posts and PM Drafts.',
											'PREFIX_extensions'									=>	'Table Of Extensions Used for Attachments.',
											'PREFIX_extension_groups'								=>	'List of Groups for Extentions',
											'PREFIX_faq'											=>	'Faqs Table.',
											'PREFIX_files'											=>	'Files Table Used for Holding A list of files included in Torrents.',
											'PREFIX_filter'										=>	'Fillter Table, A list of Key Words to exlude uploads.',
											'PREFIX_forums'										=>	'Forum Table For the Forum Topics and Forums.',
											'PREFIX_forums_access'									=>	'Forum Access Table For listing users in a forum.',
											'PREFIX_forums_track'									=>	'This table keeps record for visited forums in order to mark them as read or unread. We use the mark_time timestamp in conjunction with last post of forum x\'s timestamp to know when all topics in forum x were last marked read. ',
											'PREFIX_forums_watch'									=>	'Forum Watch Table Used for users that wish to watch a forom for new posts.',
											'PREFIX_forum_config'									=>	'Forum Configuration Table.',
											'PREFIX_forum_permissions'								=>	'Deperacated Table',
											'PREFIX_hit_n_run'										=>	'Hit And Run Configuration Table.',
											'PREFIX_icons'											=>	'Icons Table A list of Icons used for file types',
											'PREFIX_img_bucket'									=>	'Image Bucket Configuration Table.',
											'PREFIX_levels'										=>	'Levels Table List of groups and there privlages in the main site.',
											'PREFIX_level_privlages'								=>	'Level Privlages List of privlages on the main site.',
											'PREFIX_level_settings'								=>	'Level Settings list of groups and there settings such as avatar color.....',
											'PREFIX_log'											=>	'List Of site logs.',
											'PREFIX_massupload'									=>	'Table used to hold information while Using mass upload system',
											'PREFIX_moderator_cache'								=>	'Moderator Cache Table List of Moderators for each Forum.',
											'PREFIX_modules'										=>	'Modules Table A list of Modules used for the forum moderator section.',
											'PREFIX_online_users'									=>	'Online Users Table, List of users online.',
											'PREFIX_paypal'										=>	'PayPal Config Table.',
											'PREFIX_peers'											=>	'Peers Table, List of active Peers.',
											'PREFIX_pollanswers'									=>	'Poll Answer Table, List of Poll Answers used on the Fron side of the site.',
											'PREFIX_polls'											=>	'Polls Table, List of Polls and Quistions for the Main site.',
											'PREFIX_poll_options'									=>	'Poll Option Table, List of polls and Questions for the forums',
											'PREFIX_poll_votes'									=>	'Poll Votes Table, List of Poll Votes',
											'PREFIX_posts'											=>	'Posts Table, Post made in the forum.',
											'PREFIX_privacy_backup'								=>	'',
											'PREFIX_privacy_file'									=>	'',
											'PREFIX_privacy_global'								=>	'',
											'PREFIX_private_messages'								=>	'',
											'PREFIX_private_messages_blacklist'					=>	'',
											'PREFIX_private_messages_bookmarks'					=>	'',
											'PREFIX_private_messages_rules'						=>	'',
											'PREFIX_privmsgs_folder'								=>	'',
											'PREFIX_privmsgs_to'									=>	'',
											'PREFIX_ranks'											=>	'',
											'PREFIX_ratings'										=>	'',
											'PREFIX_ratiowarn'										=>	'',
											'PREFIX_ratiowarn_config'								=>	'',
											'PREFIX_reports'										=>	'',
											'PREFIX_reports_reasons'								=>	'',
											'PREFIX_rules'											=>	'',
											'PREFIX_search_cloud'									=>	'Search Cloud Configs.',
											'PREFIX_search_text'									=>	'Search Cloud Text.',
											'PREFIX_seeder_notify'									=>	'',
											'PREFIX_sessions'										=>	'',
											'PREFIX_shouts'										=>	'',
											'PREFIX_shout_config'									=>	'',
											'PREFIX_smiles'										=>	'',
											'PREFIX_snatched'										=>	'',
											'PREFIX_thanks'										=>	'',
											'PREFIX_time_offset'									=>	'',
											'PREFIX_topics'										=>	'',
											'PREFIX_topics_posted'									=>	'',
											'PREFIX_topics_track'									=>	'',
											'PREFIX_topics_watch'									=>	'',
											'PREFIX_torrents'										=>	'',
											'PREFIX_trackers'										=>	'',
											'PREFIX_userautodel'									=>	'',
											'PREFIX_users'											=>	'',
											'PREFIX_user_group'									=>	'',
											'PREFIX_warnings'										=>	'',
											'PREFIX_zebra'											=>	'',
											),
));
?>