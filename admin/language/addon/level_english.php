<?php
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'ACP_GROUPS_MANAGE_EXPLAIN'		=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',
	'GROUP_EDIT_EXPLAIN'			=> 'Here you can edit an existing group. You can change its name, description and type (open, closed, etc.). You can also set certain group wide options such as colouration, rank, etc. Changes made here override users’ current settings. Please note that group members can override group-avatar settings, unless you set appropriate user permissions.',
	'COPY_PERMISSIONS'				=> 'Copy permissions from',
	'COPY_PERMISSIONS_EXPLAIN'		=> 'Once created, the group will have the same permissions as the one you select here.',
	'CREATE_GROUP'					=> 'Create new group',
	'PRIMARY_GROUP'					=> 'Primary group',
	'REMOVE_SELECTED'				=> 'Remove selected',
	'USER_GROUP_CHANGE'				=> 'From “%1$s” group to “%2$s”',
	'GROUP_AVATAR'					=> 'Group avatar',
	'GROUP_COLOR'					=> 'Group colour',
	'GROUP_COLOR_EXPLAIN'			=> 'Defines the colour members’ usernames will appear in, leave blank for user default.',
	'GROUP_CREATED'					=> 'Group has been created successfully.',
	'GROUP_DEFAULT'					=> 'Make group default for member',
	'GROUP_DEFS_UPDATED'			=> 'Default group set for all selected members.',
	'GROUP_DELETED'					=> 'Group deleted and user default groups set successfully.',
	'GROUP_DESC'					=> 'Group description',
	'GROUP_LEGEND'					=> 'Display group in legend',
	'GROUP_LIST'					=> 'Current members',
	'GROUP_LIST_EXPLAIN'			=> 'This is a complete list of all the current users with membership of this group. You can delete members (except in certain special groups) or add new ones as you see fit.',
	'GROUP_MEMBERS'					=> 'Group members',
	'GROUP_NAME'					=> 'Group name',
	'GROUP_NAME_TAKEN'				=> 'The group name you entered is already in use, please select an alternative.',
	'GROUP_MAX_RECIPIENTS'			=> 'Maximum number of allowed recipients per private message',
	'GROUP_MAX_RECIPIENTS_EXPLAIN'	=> 'The maximum number of allowed recipients in a private message. If 0 is entered, the board-wide setting is used.',
	'GROUP_RECEIVE_PM'				=> 'Group able to receive private messages',
	'GROUP_UPDATED'					=> 'Group preferences updated successfully.',
	'NO_GROUPS_CREATED'			=> 'No groups created yet.',
	'NO_PERMISSIONS'			=> 'Do not copy permissions',
	'TOTAL_MEMBERS'				=> 'Members',
	'USER_DEF_GROUPS_EXPLAIN'		=> 'These are groups created by you or another admin on this board. You can manage memberships as well as edit group properties or even delete the group.',
	'USER_GROUP_DEFAULT_EXPLAIN'	=> 'Saying yes here will set this group as the default group for the added users.',
));

?>