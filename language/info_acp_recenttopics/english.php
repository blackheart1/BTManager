<?php

/**
*
* @package - NV recent topics
* @version $Id$
* @copyright (c) nickvergessen ( http://www.flying-bits.org/ )
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'RECENT_TOPICS'						=> 'Recent topics',
	'POST_BY_AUTHOR'		=> 'by',
	'IN'						=> 'in',
	'RECENT_TOPICS_LIST'				=> 'View on “recent topics”',
	'RECENT_TOPICS_LIST_EXPLAIN'		=> 'Shall topics of this forum be displayed on the index in “recent topics”?',
	'RECENT_TOPICS_MOD'					=> '“Recent topics” MOD',

	'RT_CONFIG'							=> 'Configuration',
	'RT_ANTI_TOPICS'					=> 'Excluded topics',
	'RT_ANTI_TOPICS_EXP'				=> 'Separated by “, ” (Example: “7, 9”)<br />If you don’t want to exclude a topic, just enter 0.',
	'RT_NUMBER'							=> 'Recent topics',
	'RT_NUMBER_EXP'						=> 'Number of topics displayed on the index.',
	'RT_PAGE_NUMBER'					=> 'Recent topics pages',
	'RT_PAGE_NUMBER_EXP'				=> 'You can display some more recent topics on a little pagination. Just enter 1 to disable this feature. If you enter 0 there will be so much pages as needed to display all topics.',
	'RT_PARENTS'						=> 'Display parent forums',
	'RT_SAVED'							=> 'Saved adjustments.',

	'RT_VIEW_ON'		=> 'view NV recent-topics on',
	'RT_MEMBERLIST'		=> 'Memberlist',
	'RT_INDEX'			=> 'Index',
	'RT_SEARCH'			=> 'Search',
	'RT_FAQ'			=> 'FAQ',
	'RT_MCP'			=> 'MCP (Moderator Control Panel)',
	'RT_UCP'			=> 'UCP (User Control Panel)',
	'RT_VIEWFORUM'		=> 'Viewforum',
	'RT_VIEWTOPIC'		=> 'Viewtopic',
	'RT_VIEWONLINE'		=> 'Viewonline',
	'RT_POSTING'		=> 'Posting',
	'RT_REPORT'			=> 'Reporting',
	'RT_OTHERS'			=> 'other Site',

	// Installer
	'INSTALL_RECENT_TOPICS_MOD'				=> 'Install “Recent topics” MOD',
	'INSTALL_RECENT_TOPICS_MOD_CONFIRM'		=> 'Are you sure you want to install the “Recent topics” MOD?',
	'UPDATE_RECENT_TOPICS_MOD'				=> 'Update “Recent topics” MOD',
	'UPDATE_RECENT_TOPICS_MOD_CONFIRM'		=> 'Are you sure you want to update the “Recent topics” MOD?',
	'UNINSTALL_RECENT_TOPICS_MOD'			=> 'Uninstall “Recent topics” MOD',
	'UNINSTALL_RECENT_TOPICS_MOD_CONFIRM'	=> 'Are you sure you want to uninstall the “Recent topics” MOD?',
));

?>