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
** File acp_forum_configs/english.php 2018-02-28 06:16:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

            <title>
                <?php if (isset($_GET['error']))
            {
                echo htmlspecialchars($_GET['error']);
            }
            ?> Error</title>

            <link rel='stylesheet' type='text/css' href='/errors/error-style.css' />
        </head>

        <body>
            <div id='container'>
                <div align='center' style='padding-top: 15px'>
                    <img src='/errors/error-images/alert.png' width='89' height='94' alt='' title='' />
                </div>

                <h1 class='title'>Error 404 - Page Not Found</h1>
                <p class='sub-title' align='center'>The page that you are looking for does not appear to exist on this site.</p>
                <p>If you typed the address of the page into the address bar of your browser, please check that you typed it in correctly.</p>
                <p>If you arrived at this page after you used an old Boomark or Favorite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
            </div>
        </body>
    </html>

    <?php
    exit();
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    'YES_NO_TF'  => array('true'=>'Yes','false'=>'No'),
    'YES_NO'     => array('yes' =>'Yes','no'   =>'No'),
    'YES_NO_NUM' => array('1' =>'Yes','0'   =>'No'),
    'SEL_TIME_A' => array('m'   =>'Minutes','h'=>'Hours','d'=>'Days'),
    'SEL_TIME_B' => array('s'   =>'Seconds','m'=>'Minutes'),

    'TITLE'             => 'Forum Features',
    'TITLE_EXPLAIN'     => 'Here you can Enable/Disable Several Forum Features.',
    'ALLOW_ATTACHMENTS' => 'Allow Attachments',
    'FORM_UPDATED'      => 'Forum Configuration',

    '_admpmax_filesize'                => 'Maximum Attachment File Size',
    '_admpmax_filesizeexplain'         => 'For Uploaded Attachment Files.',
    '_admpmax_attachments'             => 'Maximum Attachments Per Post',
    '_admpmax_attachmentsexplain'      => 'Maximum Number of Attachments Allowed Per Post.',
    '_admpmin_post_chars'              => 'Minimum Characters Per Post',
    '_admpmin_post_charsexplain'       => 'Minimum Number of Characters Allowed Per Post.',
    '_admpimg_display_inlined'         => 'Display Attached Images Inline',
    '_admpimg_display_inlinedexplain'  => 'Display Attached Images Inline on Posts.',
    '_admpload_search'                 => 'Load Search Bar on Pages',
    '_admpload_searchexplain'          => 'Display the Search Bar on Pages.',
    '_admpload_moderators'             => 'Enable Display of Moderators',
    '_admpload_moderatorsexplain'      => 'Display the Forum Moderators on Pages',
    '_admpboard_hide_emails'           => 'Hide e-mail Addresses',
    '_admpboard_hide_emailsexplain'    => 'This Function keeps email Addresses Completely Private.',
    '_admpenable_queue_trigger'        => 'Enable Queued Posts',
    '_admpenable_queue_triggerexplain' => 'Ability to put Registered Users Posts to Post Approval if their Post Count is Lower than the Specified Value below. This Setting has NO effect on the Permission Setting for Post/Topic Approval.',

    '_admpqueue_trigger_posts'         => 'Maximum Post Count for Queued Posts',
    '_admpqueue_trigger_postsexplain'  => 'If Queued Posts is Enabled, this is the Post Count that the User needs to reach in order to Post without Post Approval. If the Users Post Count is below this number, the Post is stored in the Queue Automatically.',

    '_admpallow_birthdays'             => 'Allow Birthdays',
    '_admpallow_birthdaysexplain'      => 'Allow Birthdays to be entered.  The Users age will be displayed in Profiles. Please Note the Birthday List within the Board Index is Controlled by a Separate Load Setting.',

    '_admpenable_urls'                 => 'Allow Links in Posts/Private Messages',
    '_admpenable_urlsexplain'          => 'If Disallowed the <code>[URL]</code> BBCode Tag and Automatic/Magic URLs are Disabled.',
    '_admpallow_post_flash'            => 'Allow use of <code>[FLASH]</code> BBCode Tag in Posts',

    '_admpallow_post_flashexplain'     => 'If Disallowed the <code>[FLASH]</code> BBCode tag is Disabled in Posts. Otherwise the Permission System Controls which Users can use the <code>[FLASH]</code> BBCode Tag.',

    '_admpemail_enable'                => 'Enable Forum wide emails',
    '_admpemail_enableexplain'         => 'If this is Set to Disabled then NO emails will be sent by the Forum.',
    '_admpdisplay_last_edited'         => 'Display Last Edited Time Information',
    '_admpdisplay_last_editedexplain'  => 'Choose if the Last Edited by Information is to be Displayed on Posts.',
    '_admpedit_time'                   => 'Limit Editing Time',
    '_admpedit_timeexplain'            => 'Limits the Time Available to Edit a New Post. Setting the Value to 0 Disables this Option.',

    '_admphot_threshold'               => 'Popular Topic Threshold',
    '_admphot_thresholdexplain'        => 'Posts Per Topic Threshold Required for the Popular Topic Annotation. Set to 0 to Disable Popular Topics.',

    '_admpmax_poll_options'            => 'Maximum Number of Poll Options',
    '_admpmax_poll_optionsexplain'     => 'Maximum Number of Allowed Poll Questions.',
    '_admpmax_post_font_size'          => 'Maximum Font Size Per Post',
    '_admpmax_post_font_sizeexplain'   => 'Maximum Font Size Allowed in a Post. Set to 0 for Unlimited Font Size.',
    '_admpimg_link_height'             => 'Maximum Image Height Per Post',
    '_admpimg_link_heightexplain'      => 'Maximum Height of an Image/Flash File in Posts. Set to 0 for Unlimited Size.',
    '_admpimg_link_width'              => 'Maximum Image Width Per Post',
    '_admpimg_link_widthexplain'       => 'Maximum Width of an Image/Flash File in Posts. Set to 0 for Unlimited Size.',
    '_admpmax_post_urls'               => 'Maximum Links Allowed Per Post',
    '_admpmax_post_urlsexplain'        => 'Maximum Number of URL\'s Allowed in a Post. Set to 0 for Unlimited Links.',
    '_admpmax_quote_depth'             => 'Maximum Nested Quotes Per Post',
    '_admpmax_quote_depthexplain'      => 'Maximum Number of Nested Quotes Allowed in a Post. Set to 0 for Unlimited Depth.',
    '_admpmax_post_smilies'            => 'Maximum Smilies Per Post',
    '_admpmax_post_smiliesexplain'     => 'Maximum Number of Smilies Allowed in a Post. Set to 0 for Unlimited Smilies.',
    '_admpforum_open'                  => 'Enable Forum',
    '_admpforum_openexplain'           => 'This will make the Forum Visible to Users.',
    '_admpboard_disable_msg'           => 'Disable Forum Message',
    '_admpboard_disable_msgexplain'    => 'You can enter a Short (255 Character) Message to Display if you wish?',
    '_admpcensor_words'                => 'Censor Words',
    '_admpcensor_wordsexplain'         => 'Enabling Word Censor will Replace Selected Words and Change them to Replacement Words.',
    '_admppostsper_page'               => 'Posts Listed Per Page',
    '_admppostsper_pageexplain'        => 'Maximum Number of Posts Displayed Per Page',
    '_admptopics_per_page'             => 'Topics Listed Per Page',
    '_admptopics_per_pageexplain'      => 'Maximum Number of Topics Displayed Per Page',
    '_admpmax_subject_length'          => 'Maximum Characters in Subject',
    '_admpmax_subject_lengthexplain'   => 'Maximum Number of Character Allowed in Subject Title',
    '_admpmax_post_length'             => 'Maximum Characters Per Post',
    '_admpmax_post_lengthexplain'      => 'Maximum Number of Characters Allowed within a Post. <br />Set to 0 for Unlimited Characters.',

    '_admpshow_latest_topic'           => 'Show Latest Topic',
    '_admpshow_latest_topicexplain'    => 'Show the Latest Topic.',
    '_admpsearch_word_min'             => 'Search Word Min',
    '_admpsearch_word_minexplain'      => 'Minimum Number of Character Allowed when Searching.',
    '_admpallow_bookmarks'             => 'Allow Bookmarking Topics',
    '_admpallow_bookmarksexplain'      => 'User is able to Store Personal Bookmarks.',
    '_admpshout_new_topic'             => 'Shout New Topic',
    '_admpshout_new_topicexplain'      => 'Display New Topics in Shoutbox.',
    '_admpshout_new_post'              => 'Shout New Post',
    '_admpshout_new_postexplain'       => 'Display New Posts in Shoutbox.',
    '_admpallow_smilies'               => 'Allow Smilies:',
    '_admpallow_smiliesexplain'        => 'Allow Smilies in Posts.',
    '_admpallow_bbcode'                => 'Allow BBCode:',
    '_admpallow_bbcodeexplain'         => 'Allow BBCode to be used in Posts.',
    '_admpallow_signatures'            => 'Allow Signatures:',
    '_admpallow_signaturesexplain'     => 'Show User Signature in Forum Posts.',
    '_admpallow_attachments'           => 'Allow Attachments:',
    '_admpallow_attachmentsexplain'    => 'Allow Attachments to be Uploaded on Forum Posts.',
    '_admpallow_disable_censor'        => 'Allow Disabling of Word Censoring:',
    '_admpallow_disable_censorexplain' => 'Users can choose to Disable the Automatic Word Censoring of Posts.',
    '_admpcan_use_attachments'         => 'Allow Attachments',
    '_admpcan_use_attachmentsexplain'  => 'Allow Attachments to be Posted in Posts.',
    '_admpflood_intervals'             => 'Flood Interval',
    '_admpflood_intervalsexplain'      => 'Number of Seconds a User must wait between making/replying to Posts. To Enable Users to Ignore this alter their Permissions.',

    '_admpbump_intervals'              => 'Bump Interval',
    '_admpbump_intervalsexplain'       => 'Number of Minutes, Hours or Days between the Last Post to a Topic and the ability to Bump this Topic.',

    '_admpallow_quick_reply'           => 'Allow Quick Reply',
    '_admpallow_quick_replyexplain'    => 'Display The Quick Reply Button.',
));

?>