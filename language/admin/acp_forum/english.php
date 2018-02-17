<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
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
	'FORUM_INDEX'					=> 'Board index',
	'SELECT_FORUM'					=> 'Select a forum',
	'FORUM_MANAGE'					=> 'Manage forums',
	'FORUM_CONF'					=> 'Forum Configs',
	'FORUMS_PRUNE'					=> 'Prune forums',
	'FORUMS_USER_PERM'				=> 'Users’ forum permissions',
	'FORUMS_GROUP_PERM'				=> 'Groups’ forum permissions',
	'FORUMS_PERMISSIONS'			=> 'Forum permissions',
	'FORUMS_MODERATORS'				=> 'Forum moderators',
	'FORUM_BASD_PERM'				=>	'Forum based permissions',
	'FORUM_RULES'					=> 'Forum rules',
	'PARSE_BBCODE'					=> 'Parse BBCode',
	'PARSE_SMILIES'					=> 'Parse smilies',
	'PARSE_URLS'					=> 'Parse links',
	'RESYNC'						=> 'Resynchronise',
	'AUTO_PRUNE_DAYS'				=> 'Auto-prune post age',
	'AUTO_PRUNE_DAYS_EXPLAIN'		=> 'Number of days since last post after which topic is removed.',
	'AUTO_PRUNE_FREQ'				=> 'Auto-prune frequency',
	'AUTO_PRUNE_FREQ_EXPLAIN'		=> 'Time in days between pruning events.',
	'AUTO_PRUNE_VIEWED'				=> 'Auto-prune post viewed age',
	'AUTO_PRUNE_VIEWED_EXPLAIN'		=> 'Number of days since topic was viewed after which topic is removed.',
	'COPY_PERMISSIONS'				=> 'Copy permissions from',
	'COPY_PERMISSIONS_EXPLAIN'		=> 'To ease up the permission setup for your new forum, you can copy the permissions of an existing forum.',
	'COPY_PERMISSIONS_ADD_EXPLAIN'	=> 'Once created, the forum will have the same permissions as the one you select here. If no forum is selected the newly created forum will not be visible until permissions had been set.',
	'COPY_PERMISSIONS_EDIT_EXPLAIN'	=> 'If you select to copy permissions, the forum will have the same permissions as the one you select here. This will overwrite any permissions you have previously set for this forum with the permissions of the forum you select here. If no forum is selected the current permissions will be kept.',
	'COPY_TO_ACL'					=> 'Alternatively, you are also able to %sset up new permissions%s for this forum.',
	'CREATE_FORUM'					=> 'Create new forum',

	'DECIDE_MOVE_DELETE_CONTENT'		=> 'Delete content or move to forum',
	'DECIDE_MOVE_DELETE_SUBFORUMS'		=> 'Delete subforums or move to forum',
	'DEFAULT_STYLE'						=> 'Default style',
	'DELETE_ALL_POSTS'					=> 'Delete posts',
	'DELETE_SUBFORUMS'					=> 'Delete subforums and posts',
	'DISPLAY_ACTIVE_TOPICS'				=> 'Enable active topics',
	'DISPLAY_ACTIVE_TOPICS_EXPLAIN'		=> 'If set to yes active topics in selected subforums will be displayed under this category.',

	'SETTING_TOO_LOW'				=> 'The provided value for the setting “%1$s” is too low. The minimum acceptable value is %2$d.',
	'SETTING_TOO_BIG'				=> 'The provided value for the setting “%1$s” is too high. The maximum acceptable value is %2$d.',
	'SETTING_TOO_LONG'				=> 'The provided value for the setting “%1$s” is too long. The maximum acceptable length is %2$d.',
	'SETTING_TOO_SHORT'				=> 'The provided value for the setting “%1$s” is too short. The minimum acceptable length is %2$d.',
	'EDIT_FORUM'					=> 'Edit forum',
	'ENABLE_INDEXING'				=> 'Enable search indexing',
	'ENABLE_INDEXING_EXPLAIN'		=> 'If set to yes posts made to this forum will be indexed for searching.',
	'ENABLE_POST_REVIEW'			=> 'Enable post review',
	'ENABLE_POST_REVIEW_EXPLAIN'	=> 'If set to yes users are able to review their post if new posts were made to the topic while users wrote theirs. This should be disabled for chat forums.',
	'ENABLE_QUICK_REPLY'			=> 'Enable quick reply',
	'ENABLE_QUICK_REPLY_EXPLAIN'	=> 'Enables the quick reply in this forum. This setting is not considered if the quick reply is disabled board wide. The quick reply will only be displayed for users who have permission to post in this forum.',
	'ENABLE_RECENT'					=> 'Display active topics',
	'ENABLE_RECENT_EXPLAIN'			=> 'If set to yes topics made to this forum will be shown in the active topics list.',
	'ENABLE_TOPIC_ICONS'			=> 'Enable topic icons',

	'FORUM_ADMIN'						=> 'Forum administration',
	'FORUM_ADMIN_EXPLAIN'				=> 'In phpBB3 there are no categories, everything is forum based. Each forum can have an unlimited number of sub-forums and you can determine whether each may be posted to or not (i.e. whether it acts like an old category). Here you can add, edit, delete, lock, unlock individual forums as well as set certain additional controls. If your posts and topics have got out of sync you can also resynchronise a forum. <strong>You need to copy or set appropriate permissions for newly created forums to have them displayed.</strong>',
	'FORUM_AUTO_PRUNE'					=> 'Enable auto-pruning',
	'FORUM_AUTO_PRUNE_EXPLAIN'			=> 'Prunes the forum of topics, set the frequency/age parameters below.',
	'FORUM_CREATED'						=> 'Forum created successfully.',
	'FORUM_DATA_NEGATIVE'				=> 'Pruning parameters cannot be negative.',
	'FORUM_DESC_TOO_LONG'				=> 'The forum description is too long, it must be less than 4000 characters.',
	'FORUM_DELETE'						=> 'Delete forum',
	'FORUM_DELETE_EXPLAIN'				=> 'The form below will allow you to delete a forum. If the forum is postable you are able to decide where you want to put all topics (or forums) it contained.',
	'FORUM_DELETED'						=> 'Forum fully deleted.',
	'FORUM_DESC'						=> 'Description',
	'FORUM_DESC_EXPLAIN'				=> 'Any HTML markup entered here will be displayed as is.',
	'FORUM_EDIT_EXPLAIN'				=> 'The form below will allow you to customise this forum. Please note that moderation and post count controls are set via forum permissions for each user or usergroup.',
	'FORUM_IMAGE'						=> 'Forum image',
	'FORUM_IMAGE_EXPLAIN'				=> 'Location, rsuccesselative to the phpBB root directory, of an additional image to associate with this forum.',
	'FORUM_IMAGE_NO_EXIST'				=> 'The specified forum image does not exist',
	'FORUM_LINK_EXPLAIN'				=> 'Full URL (including the protocol, i.e.: <samp>http://</samp>) to the destination location that clicking this forum will take the user, e.g.: <samp>http://www.phpbb.com/</samp>.',
	'FORUM_LINK_TRACK'					=> 'Track link redirects',
	'FORUM_LINK_TRACK_EXPLAIN'			=> 'Records the number of times a forum link was clicked.',
	'FORUM_NAME'						=> 'Forum name',
	'FORUM_NAME_EMPTY'					=> 'You must enter a name for this forum.',
	'FORUM_PARENT'						=> 'Parent forum',
	'FORUM_PASSWORD'						=> 'Forum password',
	'FORUM_PASSWORD_CONFIRM'				=> 'Confirm forum password',
	'FORUM_PASSWORD_CONFIRM_EXPLAIN'		=> 'Only needs to be set if a forum password is entered.',
	'FORUM_PASSWORD_EXPLAIN'				=> 'Defines a password for this forum, use the permission system in preference.',
	'FORUM_PASSWORD_UNSET'					=> 'Remove forum password',
	'FORUM_PASSWORD_UNSET_EXPLAIN'			=> 'Check here if you want to remove the forum password.',
	'FORUM_PASSWORD_OLD'					=> 'The forum password is using an old hashing method and should be changed.',
	'FORUM_PASSWORD_MISMATCH'				=> 'The passwords you entered did not match.',
	'FORUM_PRUNE_SETTINGS'					=> 'Forum prune settings',
	'FORUM_RESYNCED'						=> 'Forum “%s” successfully resynced',
	'FORUM_RULES_EXPLAIN'					=> 'Forum rules are displayed at any page within the given forum.',
	'FORUM_RULES_LINK'						=> 'Link to forum rules',
	'FORUM_RULES_LINK_EXPLAIN'				=> 'You are able to enter the URL of the page/post containing your forum rules here. This setting will override the forum rules text you specified.',
	'FORUM_RULES_PREVIEW'					=> 'Forum rules preview',
	'FORUM_RULES_TOO_LONG'					=> 'The forum rules must be less than 4000 characters.',
	'FORUM_SETTINGS'						=> 'Forum settings',
	'FORUM_STATUS'							=> 'Forum status',
	'FORUM_STYLE'							=> 'Forum style',
	'FORUM_TOPICS_PAGE'						=> 'Topics per page',
	'FORUM_TOPICS_PAGE_EXPLAIN'				=> 'If non-zero this value will override the default topics per page setting.',
	'FORUM_TYPE'							=> 'Forum type',
	'FORUM_UPDATED'							=> 'Forum information updated successfully.',
	'FORUM_WITH_SUBFORUMS_NOT_TO_LINK'		=> 'You want to change a postable forum having subforums to a link. Please move all subforums out of this forum before you proceed, because after changing to a link you are no longer able to see the subforums currently connected to this forum.',
	'GENERAL_FORUM_SETTINGS'			=> 'General forum settings',
	'LINK'								=> 'Link',
	'LIST_INDEX'						=> 'List subforum in parent-forum’s legend',
	'LIST_INDEX_EXPLAIN'		=> 'Displays this forum on the index and elsewhere as a link within the legend of its parent-forum if the parent-forum’s “List subforums in legend” option is enabled.',
	'LIST_SUBFORUMS'			=> 'List subforums in legend',
	'LIST_SUBFORUMS_EXPLAIN'	=> 'Displays this forum’s subforums on the index and elsewhere as a link within the legend if their “List subforum in parent-forum’s legend” option is enabled.',
	'LOCKED'					=> 'Locked',
	'MOVE_POSTS_NO_POSTABLE_FORUM'	=> 'The forum you selected for moving the posts to is not postable. Please select a postable forum.',
	'MOVE_POSTS_TO'					=> 'Move posts to',
	'MOVE_SUBFORUMS_TO'				=> 'Move subforums to',
	'NO_DESTINATION_FORUM'			=> 'You have not specified a forum to move content to.',
	'NO_FORUM_ACTION'				=> 'No action defined for what happens with the forum content.',
	'NO_PARENT'						=> 'No parent',
	'NO_PERMISSIONS'				=> 'Do not copy permissions',
	'NO_PERMISSION_FORUM_ADD'		=> 'You do not have the necessary permissions to add forums.',
	'NO_PERMISSION_FORUM_DELETE'	=> 'You do not have the necessary permissions to delete forums.',
	'PARENT_IS_LINK_FORUM'		=> 'The parent you specified is a forum link. Link forums are not able to hold other forums, please specify a category or forum as the parent forum.',
	'PARENT_NOT_EXIST'			=> 'Parent does not exist.',
	'PRUNE_ANNOUNCEMENTS'		=> 'Prune announcements',
	'PRUNE_STICKY'				=> 'Prune stickies',
	'PRUNE_OLD_POLLS'			=> 'Prune old polls',
	'PRUNE_OLD_POLLS_EXPLAIN'	=> 'Removes topics with polls not voted in for post age days.',
	'REDIRECT_ACL'				=> 'Now you are able to %sset permissions%s for this forum.',
	'SYNC_IN_PROGRESS'			=> 'Synchronizing forum',
	'SYNC_IN_PROGRESS_EXPLAIN'	=> 'Currently resyncing topic range %1$d/%2$d.',
	'TYPE_CAT'					=> 'Category',
	'TYPE_FORUM'				=> 'Forum',
	'TYPE_LINK'					=> 'Link',
));
$lang = array_merge($lang, array(
	'ACP_PRUNE_USERS_EXPLAIN'	=> 'This section allows you to delete or deactivate users on your board. Accounts can be filtered in a variety of ways; by post count, most recent activity, etc. Criteria may be combined to narrow down which accounts are affected. For example, you can prune users with fewer than 10 posts, who were also inactive after 2002-01-01. Alternatively, you may skip the criteria selection completely by entering a list of users (each on a separate line) into the text field. Take care with this facility! Once a user is deleted, there is no way to reverse the action.',

	'DEACTIVATE_DELETE'			=> 'Deactivate or delete',
	'DEACTIVATE_DELETE_EXPLAIN'	=> 'Choose whether to deactivate users or delete them entirely. Please note that deleted users cannot be restored!',
	'DELETE_USERS'				=> 'Delete',
	'DELETE_USER_POSTS'			=> 'Delete pruned user posts',
	'DELETE_USER_POSTS_EXPLAIN' => 'Removes posts made by deleted users, has no effect if users are deactivated.',

	'JOINED_EXPLAIN'			=> 'Enter a date in <kbd>YYYY-MM-DD</kbd> format.',

	'LAST_ACTIVE_EXPLAIN'		=> 'Enter a date in <kbd>YYYY-MM-DD</kbd> format. Enter <kbd>0000-00-00</kbd> to prune users who never logged in, <em>Before</em> and <em>After</em> conditions will be ignored.',

	'PRUNE_USERS_LIST'				=> 'Users to be pruned',
	'PRUNE_USERS_LIST_DELETE'		=> 'With the selected critera for pruning users the following accounts will be removed.',
	'PRUNE_USERS_LIST_DEACTIVATE'	=> 'With the selected critera for pruning users the following accounts will be deactivated.',

	'SELECT_USERS_EXPLAIN'		=> 'Enter specific usernames here, they will be used in preference to the criteria above. Founders cannot be pruned.',

	'USER_DEACTIVATE_SUCCESS'	=> 'The selected users have been deactivated successfully.',
	'USER_DELETE_SUCCESS'		=> 'The selected users have been deleted successfully.',
	'USER_PRUNE_FAILURE'		=> 'No users fit the selected criteria.',

	'WRONG_ACTIVE_JOINED_DATE'	=> 'The date entered is wrong, it is expected in <kbd>YYYY-MM-DD</kbd> format.',
));

// Forum Pruning
$lang = array_merge($lang, array(
	'ACP_PRUNE_FORUMS'			=> 'Prune forums',
	'ALL_FORUMS'					=> 'All forums',
	'ACP_PRUNE_FORUMS_EXPLAIN'	=> 'This will delete any topic which has not been posted to or viewed within the number of days you select. If you do not enter a number then all topics will be deleted. By default, it will not remove topics in which polls are still running nor will it remove stickies and announcements.',
	'LOOK_UP_FORUM'			=> 'Select a forum',
	'LOOK_UP_FORUMS_EXPLAIN'=> 'You are able to select more than one forum.',

	'FORUM_PRUNE'		=> 'Forum prune',

	'NO_PRUNE'			=> 'No forums pruned.',

	'SELECTED_FORUM'	=> 'Selected forum',
	'SELECTED_FORUMS'	=> 'Selected forums',

	'POSTS_PRUNED'					=> 'Posts pruned',
	'PRUNE_ANNOUNCEMENTS'			=> 'Prune announcements',
	'PRUNE_FINISHED_POLLS'			=> 'Prune closed polls',
	'PRUNE_FINISHED_POLLS_EXPLAIN'	=> 'Removes topics with polls which have ended.',
	'PRUNE_FORUM_CONFIRM'			=> 'Are you sure you want to prune the selected forums with the settings specified? Once removed, there is no way to recover the pruned posts and topics.',
	'PRUNE_NOT_POSTED'				=> 'Days since last posted',
	'PRUNE_NOT_VIEWED'				=> 'Days since last viewed',
	'PRUNE_OLD_POLLS'				=> 'Prune old polls',
	'PRUNE_OLD_POLLS_EXPLAIN'		=> 'Removes topics with polls not voted in for post age days.',
	'PRUNE_STICKY'					=> 'Prune stickies',
	'PRUNE_SUCCESS'					=> 'Pruning of forums was successful.',

	'TOPICS_PRUNED'		=> 'Topics pruned',
));

?>