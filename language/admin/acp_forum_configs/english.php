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
** File acp_forum_configs/english.php 2018-09-14 10:21:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
** 2018-03-10 - Removed ASCII Characters
** 2018-03-27 - Amended !defined('IN_PMBT')
** 2018-03-27 - Amended the Wording of some Sentences
** 2018-03-28 - Amended !defined('IN_PMBT') Corrected Path
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
    'YES_NO_TF'  => array('true' => 'Yes',
                          'false' => 'No'),

    'YES_NO'     => array('yes' => 'Yes',
                          'no' =>'No'),

    'YES_NO_NUM' => array('1' => 'Yes',
                          '0' => 'No'),

    'SEL_TIME_A' => array('m' => 'Minutes',
                          'h' => 'Hours',
                          'd' => 'Days'),

    'SEL_TIME_B' => array('s' => 'Seconds',
                          'm' => 'Minutes'),

    'TITLE'             => 'Forum Features',
    'TITLE_EXPLAIN'     => 'Here you can Enable/Disable Several Forum Features.<br /><br />',
    'ALLOW_ATTACHMENTS' => 'Allow Attachments',
    'FORM_UPDATED'      => 'Forum Configuration',

    '_admpmax_filesize'                => 'Maximum Attachment File Size',
    '_admpmax_filesizeexplain'         => 'Maximum File Size Per Attachment in <strong>Bytes</strong>.',
    '_admpmax_attachments'             => 'Maximum Attachments Per Post',
    '_admpmax_attachmentsexplain'      => 'Maximum Number of Attachments Allowed Per Post.',
    '_admpmin_post_chars'              => 'Minimum Characters Per Post',
    '_admpmin_post_charsexplain'       => 'Minimum Number of Characters Required Per Post.',
    '_admpimg_display_inlined'         => 'Display Attached Images Inline',
    '_admpimg_display_inlinedexplain'  => 'Display Attached Images Inline on Posts.',
    '_admpload_search'                 => 'Load Search Bar on Pages',
    '_admpload_searchexplain'          => 'Display the Search Bar on Pages.',
    '_admpload_moderators'             => 'Enable Display of Moderators',
    '_admpload_moderatorsexplain'      => 'Display the Forum Moderators on Pages',
    '_admpboard_hide_emails'           => 'Hide email Addresses',
    '_admpboard_hide_emailsexplain'    => 'This Function keeps email Addresses Completely Private.',
    '_admpenable_queue_trigger'        => 'Enable Queued Posts',

    '_admpenable_queue_triggerexplain' => 'Ability Change Registered Users Posts to Require Approval of their Posts if their Post Count is Lower than the Specified Value below.  This Setting has NO effect on the Permission Setting for Post/Topic Approval.',

    '_admpqueue_trigger_posts'         => 'Maximum Post Count for Queued Posts',

    '_admpqueue_trigger_postsexplain'  => 'This is the Post Count that the User needs to reach in order to Post without Post Approval.  If the Users Post Count is Below this Number, the Post is Stored in the Queue Automatically.',

    '_admpallow_birthdays'             => 'Allow Birthdays',

    '_admpallow_birthdaysexplain'      => 'Allow Birthdays to be Entered.  The Users Age will be Displayed in their Profile.<br />Please Note that Enable Birthday Listing needs to be Enabled so that it Displays their Username on the Board Index',

    '_admpload_birthdays'              => 'Enable Birthday Listing',
    '_admpload_birthdaysexplain'       => 'If Disabled the Birthday Listing is no longer displayed. To let this setting take effect the Birthday feature needs to be Enabled too.',

    '_admpenable_urls'                 => 'Allow use of the <em>[URL]</em> BBCode Tag in Posts/Private Messages',
    '_admpenable_urlsexplain'          => 'If Disallowed the <em>[URL]</em> BBCode Tag and Automatic/Magic URL\'s are Disabled.',
    '_admpallow_post_flash'            => 'Allow use of the <em>[FLASH]</em> BBCode Tag in Posts',

    '_admpallow_post_flashexplain'     => 'If Disallowed the <em>[FLASH]</em> BBCode Tag is Disabled in Posts.  Otherwise the Permission System Controls which Users can use the <em>[FLASH]</em> BBCode Tag.',

    '_admpemail_enable'                => 'Enable Forum wide emails',
    '_admpemail_enableexplain'         => 'If this is Set to Disabled then NO emails will be Sent by the Forum.',
    '_admpdisplay_last_edited'         => 'Display Last Edited Time Information',
    '_admpdisplay_last_editedexplain'  => 'Choose if the Last Edited by Information is to be Displayed on Posts.',
    '_admpedit_time'                   => 'Limit Editing Time',

    '_admpedit_timeexplain'            => 'Limits the Time Available to Edit a New Post.  Setting the Value to 0 Disables this Option.',

    '_admphot_threshold'               => 'Popular Topic Threshold',

    '_admphot_thresholdexplain'        => 'Posts Per Topic Threshold Required for the Popular Topic Annotation.  Set to 0 to Disable Popular Topics.',

    '_admpmax_poll_options'            => 'Maximum Number of Poll Options',
    '_admpmax_poll_optionsexplain'     => 'Maximum Number of Allowed Poll Questions.',
    '_admpmax_post_font_size'          => 'Maximum Font Size Per Post',
    '_admpmax_post_font_sizeexplain'   => 'Maximum Font Size Allowed in a Post.  Set to 0 for Unlimited Font Size.',
    '_admpimg_link_height'             => 'Maximum Image Height Per Post',
    '_admpimg_link_heightexplain'      => 'Maximum Height of an Image/Flash File in Posts.  Set to 0 for Unlimited Size.',
    '_admpimg_link_width'              => 'Maximum Image Width Per Post',
    '_admpimg_link_widthexplain'       => 'Maximum Width of an Image/Flash File in Posts.  Set to 0 for Unlimited Size.',
    '_admpmax_post_urls'               => 'Maximum Links Allowed Per Post',
    '_admpmax_post_urlsexplain'        => 'Maximum Number of URL\'s Allowed in a Post. Set to 0 for Unlimited Links.',
    '_admpmax_quote_depth'             => 'Maximum Nested Quotes Per Post',
    '_admpmax_quote_depthexplain'      => 'Maximum Number of Nested Quotes Allowed in a Post.  Set to 0 for Unlimited Depth.',
    '_admpmax_post_smilies'            => 'Maximum Smilies Per Post',
    '_admpmax_post_smiliesexplain'     => 'Maximum Number of Smilies Allowed in a Post.  Set to 0 for Unlimited Smilies.',
    '_admpforum_open'                  => 'Enable Forum',
    '_admpforum_openexplain'           => 'This will Make the Forum Visible to Users.',
    '_admpboard_disable_msg'           => 'Disable Forum Message',
    '_admpboard_disable_msgexplain'    => 'You can Enter a Short Message (255 Character) to Display if you wish?',
    '_admpcensor_words'                => 'Censor Words',
    '_admpcensor_wordsexplain'         => 'Enabling Word Censor will Replace Selected Words with Replacement Words.',
    '_admpposts_per_page'              => 'Posts Listed Per Page',
    '_admpposts_per_pageexplain'       => 'Maximum Number of Posts Displayed Per Page',
    '_admptopics_per_page'             => 'Topics Listed Per Page',
    '_admptopics_per_pageexplain'      => 'Maximum Number of Topics Displayed Per Page',
    '_admpmax_subject_length'          => 'Maximum Characters in Subject',
    '_admpmax_subject_lengthexplain'   => 'Maximum Number of Character Allowed in Subject Title',
    '_admpmax_post_length'             => 'Maximum Characters Per Post',

    '_admpmax_post_lengthexplain'      => 'Maximum Number of Characters Allowed within a Post. <br />Set to 0 for Unlimited Characters.',

    '_admpshow_latest_topic'           => 'Show Latest Topic',
    '_admpshow_latest_topicexplain'    => 'Show\'s the Latest Topic.',
    '_admpsearch_word_min'             => 'Search Word',
    '_admpsearch_word_minexplain'      => 'Minimum Number of Character\'s Allowed when Searching.',
    '_admpallow_bookmarks'             => 'Allow Bookmarking of Topics',
    '_admpallow_bookmarksexplain'      => 'Allow Users to Store Personal Bookmarks.',
    '_admpshout_new_topic'             => 'Shout New Topic',
    '_admpshout_new_topicexplain'      => 'Display New Topics in Shoutbox.',
    '_admpshout_new_post'              => 'Shout New Post',
    '_admpshout_new_postexplain'       => 'Display New Posts in Shoutbox.',
    '_admpallow_smilies'               => 'Allow Smilies:',
    '_admpallow_smiliesexplain'        => 'Allow Smilies in Posts.',
    '_admpallow_bbcode'                => 'Allow BBCode:',
    '_admpallow_bbcodeexplain'         => 'Allow BBCode in Posts.',
    '_admpallow_signatures'            => 'Allow Signatures:',
    '_admpallow_signaturesexplain'     => 'Show the User\'s Signature in Forum Posts.',
    '_admpallow_attachments'           => 'Allow Attachments:',
    '_admpallow_attachmentsexplain'    => 'Allow Attachments to be Uploaded on Forum Posts.',
    '_admpallow_disable_censor'        => 'Disable Word Censoring:',
    '_admpallow_disable_censorexplain' => 'Allow Users to Disable the Automatic Word Censoring of Posts.',
    '_admpcan_use_attachments'         => 'Allow Attachments',
    '_admpcan_use_attachmentsexplain'  => 'Allow Attachments to be Posted in Posts.',
    '_admpflood_intervals'             => 'Flood Interval',

    '_admpflood_intervalsexplain'      => 'Number of Seconds a User must Wait between Making/Replying to Posts.<br />To Enable Users to Ignore this Alter their Permissions.',

    '_admpbump_intervals'              => 'Bump Interval',

    '_admpbump_intervalsexplain'       => 'Number of Minutes, Hours or Days between the Last Post to a Topic and the ability to Bump this Topic.',

    '_admpallow_quick_reply'           => 'Allow Quick Reply',
    '_admpallow_quick_replyexplain'    => 'Display The Quick Reply Button.',
));

?>