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
** File permissions/english.php 2018-04-11 07:26:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
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

// Define Categories and Permission Types
$lang = array_merge($lang, array(
    'permission_cat'    => array(
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
    ),

    // With Defining 'global' here we are able to Specify what is Printed Out if the Permission is within the Global Scope.
    'permission_type'   => array(
        'u_'            => 'User Permissions',
        'a_'            => 'Administrator Permissions',
        'm_'            => 'Moderator Permissions',
        'f_'            => 'Forum Permissions',
        'global'        => array('m_' => 'Global Moderator Permissions',
        ),
    ),
));

// User Permissions
$lang = array_merge($lang, array(
    'acl_u_viewprofile' => array('lang' => 'Can View Profiles, Member List and Online list', 'cat' => 'profile'),
    'acl_u_chgname'     => array('lang' => 'Can Change Username', 'cat' => 'profile'),
    'acl_u_chgpasswd'   => array('lang' => 'Can Change Password', 'cat' => 'profile'),
    'acl_u_chgemail'    => array('lang' => 'Can Change email Address', 'cat' => 'profile'),
    'acl_u_chgavatar'   => array('lang' => 'Can Change Avatar', 'cat' => 'profile'),
    'acl_u_chggrp'      => array('lang' => 'Can Change Default Usergroup', 'cat' => 'profile'),

    'acl_u_attach'      => array('lang' => 'Can Attach Files', 'cat' => 'post'),
    'acl_u_download'    => array('lang' => 'Can Download Files', 'cat' => 'post'),
    'acl_u_savedrafts'  => array('lang' => 'Can Save Drafts', 'cat' => 'post'),
    'acl_u_chgcensors'  => array('lang' => 'Can Disable Word Censors', 'cat' => 'post'),
    'acl_u_sig'         => array('lang' => 'Can use Signature', 'cat' => 'post'),

    'acl_u_sendpm'      => array('lang' => 'Can Send Private Messages', 'cat' => 'pm'),
    'acl_u_masspm'      => array('lang' => 'Can Send Private Messages to Multiple Users', 'cat' => 'pm'),
    'acl_u_masspm_group'=> array('lang' => 'Can Send Private Messages to Groups', 'cat' => 'pm'),
    'acl_u_readpm'      => array('lang' => 'Can Read Private Messages', 'cat' => 'pm'),
    'acl_u_pm_edit'     => array('lang' => 'Can Edit Own Private Messages', 'cat' => 'pm'),
    'acl_u_pm_delete'   => array('lang' => 'Can Remove Private Messages from their Own Folder', 'cat' => 'pm'),
    'acl_u_pm_forward'  => array('lang' => 'Can Forward Private Messages', 'cat' => 'pm'),
    'acl_u_pm_emailpm'  => array('lang' => 'Can email Private Messages', 'cat' => 'pm'),
    'acl_u_pm_printpm'  => array('lang' => 'Can Print Private Messages', 'cat' => 'pm'),
    'acl_u_pm_attach'   => array('lang' => 'Can Attach Files in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_download' => array('lang' => 'Can Download Files in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_bbcode'   => array('lang' => 'Can use BBCode in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_smilies'  => array('lang' => 'Can use Smilies in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_img'      => array('lang' => 'Can use Images in Private Messages', 'cat' => 'pm'),
    'acl_u_pm_flash'    => array('lang' => 'Can use Flash in Private Messages', 'cat' => 'pm'),

    'acl_u_sendemail'   => array('lang' => 'Can Send emails', 'cat' => 'misc'),
    'acl_u_sendim'      => array('lang' => 'Can Send Instant Messages', 'cat' => 'misc'),
    'acl_u_ignoreflood' => array('lang' => 'Can Ignore Flood Limit', 'cat' => 'misc'),
    'acl_u_hideonline'  => array('lang' => 'Can Hide Online Status', 'cat' => 'misc'),
    'acl_u_viewonline'  => array('lang' => 'Can View Hidden Online Users', 'cat' => 'misc'),
    'acl_u_search'      => array('lang' => 'Can Search Board', 'cat' => 'misc'),
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
    'acl_f_sigs'        => array('lang' => 'Can use Signatures', 'cat' => 'content'),
    'acl_f_bbcode'      => array('lang' => 'Can use BBCode', 'cat' => 'content'),
    'acl_f_smilies'     => array('lang' => 'Can use Smilies', 'cat' => 'content'),
    'acl_f_img'         => array('lang' => 'Can use Images', 'cat' => 'content'),
    'acl_f_flash'       => array('lang' => 'Can use Flash', 'cat' => 'content'),

    'acl_f_edit'        => array('lang' => 'Can Edit Own Posts', 'cat' => 'actions'),
    'acl_f_delete'      => array('lang' => 'Can Delete Own Posts', 'cat' => 'actions'),
    'acl_f_user_lock'   => array('lang' => 'Can Lock Own Topics', 'cat' => 'actions'),
    'acl_f_bump'        => array('lang' => 'Can Bump Topics', 'cat' => 'actions'),
    'acl_f_report'      => array('lang' => 'Can Report Posts', 'cat' => 'actions'),
    'acl_f_subscribe'   => array('lang' => 'Can Subscribe to a Forum', 'cat' => 'actions'),
    'acl_f_print'       => array('lang' => 'Can Print Topics', 'cat' => 'actions'),
    'acl_f_email'       => array('lang' => 'Can email Topics', 'cat' => 'actions'),

    'acl_f_search'      => array('lang' => 'Can Search the Forum', 'cat' => 'misc'),
    'acl_f_ignoreflood' => array('lang' => 'Can Ignore the Flood Limit', 'cat' => 'misc'),

    'acl_f_postcount'   => array('lang' => 'Increment Post Counter<br /><em>Please Note that this Setting ONLY affects New Posts.</em>', 'cat' => 'misc'),

    'acl_f_noapprove'   => array('lang' => 'Can Post Without Approval', 'cat' => 'misc'),
));

// Moderator Permissions
$lang = array_merge($lang, array(
    'acl_m_edit'        => array('lang' => 'Can Edit Posts', 'cat' => 'post_actions'),
    'acl_m_delete'      => array('lang' => 'Can Delete Posts', 'cat' => 'post_actions'),
    'acl_m_approve'     => array('lang' => 'Can Approve Posts', 'cat' => 'post_actions'),
    'acl_m_report'      => array('lang' => 'Can Close and Delete Reports', 'cat' => 'post_actions'),
    'acl_m_chgposter'   => array('lang' => 'Can Change Post Author', 'cat' => 'post_actions'),

    'acl_m_move'    => array('lang' => 'Can Move Topics', 'cat' => 'topic_actions'),
    'acl_m_lock'    => array('lang' => 'Can Lock Topics', 'cat' => 'topic_actions'),
    'acl_m_split'   => array('lang' => 'Can Split Topics', 'cat' => 'topic_actions'),
    'acl_m_merge'   => array('lang' => 'Can Merge Topics', 'cat' => 'topic_actions'),

    'acl_m_info'    => array('lang' => 'Can View Post Details', 'cat' => 'misc'),

    'acl_m_warn'    => array('lang' => 'Can Issue Warnings<br /><em>This Setting is ONLY Assigned Globally. It is NOT Forum Based.</em>', 'cat' => 'misc'), // This Moderator Setting is ONLY Global (and NOT Local)

    'acl_m_ban'     => array('lang' => 'Can Manage Bans<br /><em>This Setting is ONLY Assigned Globally. It is NOT Forum Based.</em>', 'cat' => 'misc'), // This Moderator Setting is ONLY Global (and NOT Local)
));

// Administrator Permissions
$lang = array_merge($lang, array(
    'acl_a_board'       => array('lang' => 'Can Alter Board Settings/Check for Updates', 'cat' => 'settings'),
    'acl_a_server'      => array('lang' => 'Can Alter Server/Communication Settings', 'cat' => 'settings'),
    'acl_a_jabber'      => array('lang' => 'Can Alter Jabber Settings', 'cat' => 'settings'),
    'acl_a_phpinfo'     => array('lang' => 'Can View php Settings', 'cat' => 'settings'),

    'acl_a_forum'       => array('lang' => 'Can Manage Forums', 'cat' => 'forums'),
    'acl_a_forumadd'    => array('lang' => 'Can Add New Forums', 'cat' => 'forums'),
    'acl_a_forumdel'    => array('lang' => 'Can Delete Forums', 'cat' => 'forums'),
    'acl_a_prune'       => array('lang' => 'Can Prune Forums', 'cat' => 'forums'),

    'acl_a_icons'       => array('lang' => 'Can Alter Topic/Post Icons and Smilies', 'cat' => 'posting'),
    'acl_a_words'       => array('lang' => 'Can Alter Word Censors', 'cat' => 'posting'),
    'acl_a_bbcode'      => array('lang' => 'Can Define BBCode Tags', 'cat' => 'posting'),
    'acl_a_attach'      => array('lang' => 'Can Alter Attachment Related Settings', 'cat' => 'posting'),

    'acl_a_user'        => array('lang' => 'Can Manage Users<br /><em>This also Includes seeing the Users Browser Agent within the View Online List.</em>', 'cat' => 'user_group'),

    'acl_a_userdel'     => array('lang' => 'Can Delete/Prune Users', 'cat' => 'user_group'),
    'acl_a_groupadd'    => array('lang' => 'Can Add New Groups', 'cat' => 'user_group'),
    'acl_a_groupdel'    => array('lang' => 'Can Delete Groups', 'cat' => 'user_group'),
    'acl_a_ranks'       => array('lang' => 'Can Manage Ranks', 'cat' => 'user_group'),
    'acl_a_profile'     => array('lang' => 'Can Manage Custom Profile Fields', 'cat' => 'user_group'),
    'acl_a_names'       => array('lang' => 'Can Manage Disallowed Names', 'cat' => 'user_group'),
    'acl_a_ban'         => array('lang' => 'Can Manage Bans', 'cat' => 'user_group'),

    'acl_a_viewauth'    => array('lang' => 'Can View Permission Masks', 'cat' => 'permissions'),
    'acl_a_authgroups'  => array('lang' => 'Can Alter Permissions for Individual Groups', 'cat' => 'permissions'),
    'acl_a_authusers'   => array('lang' => 'Can Alter Permissions for Individual Users', 'cat' => 'permissions'),
    'acl_a_fauth'       => array('lang' => 'Can Alter the Forum Permission Class', 'cat' => 'permissions'),
    'acl_a_mauth'       => array('lang' => 'Can Alter the Moderator Permission Class', 'cat' => 'permissions'),
    'acl_a_aauth'       => array('lang' => 'Can Alter the Administrator Permission Class', 'cat' => 'permissions'),
    'acl_a_uauth'       => array('lang' => 'Can Alter the User Permission Class', 'cat' => 'permissions'),
    'acl_a_roles'       => array('lang' => 'Can Manage Roles', 'cat' => 'permissions'),
    'acl_a_switchperm'  => array('lang' => 'Can use Others Permissions', 'cat' => 'permissions'),

    'acl_a_styles'      => array('lang' => 'Can Manage Styles', 'cat' => 'misc'),
    'acl_a_viewlogs'    => array('lang' => 'Can View Logs', 'cat' => 'misc'),
    'acl_a_clearlogs'   => array('lang' => 'Can Clear Logs', 'cat' => 'misc'),
    'acl_a_modules'     => array('lang' => 'Can Manage Modules', 'cat' => 'misc'),
    'acl_a_language'    => array('lang' => 'Can Manage Language Packs', 'cat' => 'misc'),
    'acl_a_email'       => array('lang' => 'Can Send Mass email\'s', 'cat' => 'misc'),
    'acl_a_bots'        => array('lang' => 'Can Manage BOTS', 'cat' => 'misc'),
    'acl_a_reasons'     => array('lang' => 'Can Manage the Report/Denial Reasons', 'cat' => 'misc'),
    'acl_a_backup'      => array('lang' => 'Can Backup/Restore the Database', 'cat' => 'misc'),
    'acl_a_search'      => array('lang' => 'Can Manage Search, Backend and Settings', 'cat' => 'misc'),
));

?>