<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
'TITLE'		=> 'Forum features',
'TITLE_EXPLAIN'		=> 'Here you can enable/disable several forum features.',
	'ALLOW_ATTACHMENTS'			=> 'Allow attachments',
	'_admpmax_filesize'					=> 'Maximum attachment file size',
	'_admpmax_filesizeexplain'			=> 'For uploaded attachment files.',
	'_admpmax_attachments'				=>	'Maximum Attachments per post',
	'_admpmax_attachmentsexplain'		=>	'',
	'_admpmin_post_chars'				=>	'Minimum Charictors perpost',
	'_admpmin_post_charsexplain'		=>	'',
	'_admpimg_display_inlined'=>'Display attached images in line of the post',
	'_admpimg_display_inlinedexplain'=>'',
	'_admpload_search'					=>	'Load searcg bar on pages',
	'_admpload_searchexplain'					=>	'',
	'_admpload_moderators'				=> 'Enable display of moderators',
	'_admpboard_hide_emails'			=> 'Hide e-mail addresses',
	'_admpboard_hide_emailsexplain'		=> 'This function keeps e-mail addresses completely private.',
	'_admpenable_queue_trigger'			=> 'Enable queued posts',
	'_admpenable_queue_triggerexplain'	=> 'Ability to put registered users posts to post approval if their post count is lower than the specified value below. This setting has no effect on the permission setting for post/topic approval.',
	'_admpqueue_trigger_posts'			=> 'Maximum post count for queued posts',
	'_admpqueue_trigger_postsexplain'	=> 'If queued posts is enabled, this is the post count the user need to reach in order to post without post approval. If the users post count is below this number, the post is stored in the queue automatically.',
	'_admpallow_birthdays'				=> 'Allow birthdays',
	'_admpallow_birthdaysexplain'		=> 'Allow birthdays to be entered and age being displayed in profiles. Please note the birthday list within the board index is controlled by a separate load setting.',
	'_admpenable_urls'					=> 'Allow links in posts/private messages',
	'_admpenable_urlsexplain'			=> 'If disallowed the <code>[URL]</code> BBCode tag and automatic/magic URLs are disabled.',
	'_admpallow_post_flash'				=> 'Allow use of <code>[FLASH]</code> BBCode tag in posts',
	'_admpallow_post_flashexplain'		=> 'If disallowed the <code>[FLASH]</code> BBCode tag is disabled in posts. Otherwise the permission system controls which users can use the <code>[FLASH]</code> BBCode tag.',
	'_admpemail_enable'					=> 'Enable board-wide e-mails',
	'_admpemail_enableexplain'			=> 'If this is set to disabled no e-mails will be sent by the board at all.',
	'_admpdisplay_last_edited'			=> 'Display last edited time information',
	'_admpdisplay_last_editedexplain'	=> 'Choose if the last edited by information to be displayed on posts.',
	'_admpedit_time'					=> 'Limit editing time',
	'_admpedit_timeexplain'				=> 'Limits the time available to edit a new post. Setting the value to 0 disables this behaviour.',
	'_admphot_threshold'				=> 'Popular topic threshold',
	'_admphot_thresholdexplain'			=> 'Posts per topic threshold required for the popular topic annotation. Set to 0 to disable popular topics.',
	'_admpmax_poll_options'				=> 'Maximum number of poll options',
	'_admpmax_poll_optionsexplain'		=>	'',
	'_admpmax_post_font_size'			=> 'Maximum font size per post',
	'_admpmax_post_font_sizeexplain'	=> 'Maximum font size allowed in a post. Set to 0 for unlimited font size.',
	'_admpimg_link_height'				=> 'Maximum image height per post',
	'_admpimg_link_heightexplain'		=> 'Maximum height of an image/flash file in postings. Set to 0 for unlimited size.',
	'_admpimg_link_width'				=> 'Maximum image width per post',
	'_admpimg_link_widthexplain'		=> 'Maximum width of an image/flash file in postings. Set to 0 for unlimited size.',
	'_admpmax_post_urls'				=> 'Maximum links per post',
	'_admpmax_post_urlsexplain'			=> 'Maximum number of URLs in a post. Set to 0 for unlimited links.',
	'_admpmax_quote_depth'				=> 'Maximum nested quotes per post',
	'_admpmax_quote_depthexplain'		=> 'Maximum number of nested quotes in a post. Set to 0 for unlimited depth.',
	'_admpmax_post_smilies'				=> 'Maximum smilies per post',
	'_admpmax_post_smiliesexplain'		=> 'Maximum number of smilies in a post. Set to 0 for unlimited smilies.',
'_admpforum_open'						=> 'Inable board',
'_admpforum_openexplain'				=> 'This will make the board available to users.',
'_admpboard_disable_msg'				=> 'Disable board message',
'_admpboard_disable_msgexplain'			=> 'You can enter a short (255 character) message to display if you wish.',
'_admpcensor_words'						=> 'Cenor Words',
'_admpcensor_wordsexplain'				=> 'Enable word censor well replace selected words and change them to replacement words.',
'_admppostsper_page'					=> 'Posts Listed Perpage',
'_admppostsper_pageexplain'				=> '',
'_admptopics_per_page'		=> 'Topics Listed Perpage',
'_admptopics_per_pageexplain'		=> '',
'_admpmax_subject_length'		=> 'Maximum characters in Subject',
'_admpmax_subject_lengthexplain'		=> '',
'_admpmax_post_length'		=> 'Maximum characters per post',
'_admpmax_post_lengthexplain'		=> 'The number of characters allowed within a post. <br />Set to 0 for unlimited characters.',
'_admpshow_latest_topic'		=> 'show_latest_topic',
'_admpshow_latest_topicexplain'		=> '',
'_admpsearch_word_min'		=> 'search_word_min',
'_admpsearch_word_minexplain'		=> '',
'_admpallow_bookmarks'		=> 'Allow bookmarking topics',
'_admpallow_bookmarksexplain'		=> 'User is able to store personal bookmarks.',
'_admpshout_new_topic'		=> 'shout_new_topic',
'_admpshout_new_topicexplain'		=> '',
'_admpshout_new_post'		=> 'shout_new_post',
'_admpshout_new_postexplain'		=> '',
'_admpallow_smilies'		=> 'Allow smilies:',
'_admpallow_smiliesexplain'		=> '',
'_admpallow_bbcode'		=> 'Allow BBCode:',
'_admpallow_bbcodeexplain'		=> '',
'_admpallow_signatures'		=> 'Allow signatures:',
'_admpallow_signaturesexplain'		=> '',
'_admpallow_disable_censor'		=> 'Allow disabling of word censoring:',
'_admpallow_disable_censorexplain'		=> 'Users can choose to disable the automatic word censoring of posts.',
'_admpcan_use_attachments'		=> 'Allow attachments',
'_admpcan_use_attachmentsexplain'		=> '',
'_admpflood_intervals'		=> 'Flood interval',
'_admpflood_intervalsexplain'		=> 'Number of seconds a user must wait between posting new messages. To enable users to ignore this alter their permissions.',
'_admpbump_intervals'		=> 'Bump interval',
'_admpbump_intervalsexplain'		=> 'Number of minutes, hours or days between the last post to a topic and the ability to bump this topic.',
'_admpallow_quick_reply'		=> 'allow_quick_reply',
'_admpallow_quick_replyexplain'		=> '',
'YES_NO_TF'					=> array('true'=> 'Yes','false'=>'No'),
'YES_NO'					=> array('yes'=> 'Yes','no'=>'No'),
'SEL_TIME_A'			=>array('m'=>'Minutes','h'=>'Hours','d'=>'Days'),
'SEL_TIME_B'			=>array('s'=>'Seconds','m'=>'Minutes'),
'FORM_UPDATED'			=> 'Forum configs',
));
?>