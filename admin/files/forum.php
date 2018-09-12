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
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File forum.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** 2018-07-27 - Added Language to bterror()
**/

if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}

$user->set_lang('admin/acp_forum',$user->ulanguage);

include("include/forum_config.php");
include_once('include/functions_forum.php');
include_once 'include/function_posting.php';
include_once 'include/class.bbcode.php';

$template->assign_block_vars('l_block1.l_block2',array(
        'L_TITLE'    => $user->lang['FORUM_MANAGE'],
        'S_SELECTED' => true,
        'U_TITLE'    => '1',
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('forum' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['FORUM_MANAGE'],
        'U_TITLE'    => "admin.php?i=siteinfo&op=forum",
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('setting_forum_conf' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['FORUM_CONF'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=setting_forum_conf&amp;action=configs",
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('forum_pruning' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['FORUMS_PRUNE'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=forum_pruning&amp;action=prune&amp;mode=forums",
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('forum_words' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['ACP_WORDS'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=forum_words&amp;action=words",
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('forum_search' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['MENU_SEACH'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=forum_search&amp;action=search",
));

$template->assign_block_vars('l_block1.l_block2',array(
        'L_TITLE'    => $user->lang['FORUM_BASD_PERM'],
        'S_SELECTED' => true,
        'U_TITLE'    => '1',));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('setting_user_local' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['FORUMS_USER_PERM'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=setting_user_local&amp;action=permissions&amp;mode=setting_user_local",
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('setting_group_local' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['FORUMS_GROUP_PERM'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=setting_group_local&amp;action=permissions&amp;mode=setting_group_local",
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('setting_mod_local' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['FORUMS_MODERATORS'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=setting_mod_local&amp;action=permissions&amp;mode=setting_mod_local",
));

$template->assign_block_vars('l_block1.l_block2.l_block3',array(
        'S_SELECTED' => ('setting_forum_local' ==$op)? true:false,
        'IMG'        => '',
        'L_TITLE'    => $user->lang['FORUMS_PERMISSIONS'],
        'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=setting_forum_local&amp;action=permissions&amp;mode=setting_forum_local",
));

if ('forum_search' == $op)
{
    $template->assign_block_vars('l_block1.l_block2',array(
            'L_TITLE'    => $user->lang['MENU_SEACH'],
            'S_SELECTED' => true,
            'U_TITLE'    => '1',));

    $template->assign_block_vars('l_block1.l_block2.l_block3',array(
            'S_SELECTED' => ('forum_search' ==$op)? true:false,
            'IMG'        => '',
            'L_TITLE'    => $user->lang['ACP_SEARCH_SETTINGS'],
            'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=forum_search&amp;action=search",
    ));

    $template->assign_block_vars('l_block1.l_block2.l_block3',array(
            'S_SELECTED' => ('forum' ==$op)? true:false,
            'IMG'        => '',
            'L_TITLE'    => $user->lang['ACP_SEARCH_INDEX'],
            'U_TITLE'    => "admin.php?i=" . $i . "&amp;op=forum_search&amp;action=search&amp;mode=index",
    ));
}

		$action		= request_var('action', array('a'=>''));
		if(!count($action))$action		= (isset($_POST['add'])) ? 'add' : request_var('action', '');
		else $action		= key($action);
		//die($action);
		$update		= (isset($_POST['update'])) ? true : false;
		$forum_id	= request_var('f', 0);
		$parent_id	= request_var('parent_id', 0);
		$forum_data = $errors = array();
		$perm_delete = false;
		if($op == 'setting_user_local' or $op == 'setting_group_local' or $op == 'setting_mod_local' or $op == 'setting_forum_local')
		{
			if($action == 'delete')
			{
				$perm_delete = 'delete';
				$action = 'permissions';
			}
		}
		switch ($action)
		{
			case 'search':
			require_once("admin/files/acp_search.php");
			$mode = request_var('mode', 'settings');
			$auth = new auth();
			$auth->acl($user);
			$admin_role = new acp_search();
			$admin_role->u_action = "admin.php?i=" . $i . "&amp;op=forum_search&amp;action=search&amp;mode=$mode";
			$admin_role->main($i,$mode);
			echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
			close_out();
			break;
			case 'configs':
				if (!$update)
				{
					$cfgrow = $config;
					$user->set_lang('admin/acp_forum_configs',$user->ulanguage);
					drawRow("forumsettings","text", false ,'Forum Settings');
					drawRow("forum_open","select",$user->lang["YES_NO_NUM"]);
					drawRow("board_disable_msg","text");
					drawRow("email_enable","select",$user->lang["YES_NO_NUM"]);
					drawRow("topics_per_page","text");
					drawRow("posts_per_page","text");
					drawRow("max_post_length","text");
					drawRow("show_latest_topic","select",$user->lang["YES_NO_NUM"]);
					drawRow("search_word_min","text");
					drawRow("allow_bookmarks","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_forum_notify","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_topic_notify","select",$user->lang["YES_NO_NUM"]);
					drawRow("shout_new_topic","select",$user->lang["YES_NO_NUM"]);
					drawRow("shout_new_post","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_smilies","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_bbcode","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_signatures","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_disable_censor","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_attachments","select",$user->lang["YES_NO_NUM"]);
					drawRow("flood_intervals","textplus",$user->lang["SEL_TIME_B"],false,'set_flood_intervals');
					drawRow("bump_intervals","textplus",$user->lang["SEL_TIME_A"],false,'set_bump_intervals');
					drawRow("img_display_inlined","select",$user->lang["YES_NO_NUM"]);
					drawRow("img_link_width","text");
					drawRow("img_link_height","text");
					drawRow("enable_urls","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_quick_reply","select",$user->lang["YES_NO_NUM"]);
					drawRow("max_post_font_size","text");
					drawRow("max_attachments","text");
					drawRow("min_post_chars","text");
					drawRow("max_poll_options","text");
					drawRow("hot_threshold","text");
					drawRow("max_filesize","text");
					drawRow("edit_time","text");
					drawRow("max_post_urls","text");
					drawRow("max_post_smilies","text");
					drawRow("max_quote_depth","text");
					drawRow("load_search","select",$user->lang["YES_NO_NUM"]);
					drawRow("board_hide_emails","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_birthdays","select",$user->lang["YES_NO_NUM"]);
					drawRow("load_birthdays","select",$user->lang["YES_NO_NUM"]);
					drawRow("display_last_edited","select",$user->lang["YES_NO_NUM"]);
					drawRow("load_moderators","select",$user->lang["YES_NO_NUM"]);
					drawRow("allow_post_flash","select",$user->lang["YES_NO_NUM"]);
					drawRow("enable_queue_trigger","select",$user->lang["YES_NO_NUM"]);
					drawRow("queue_trigger_posts","text");
						$hidden = build_hidden_fields(array(
							'update'	=> 'save',
							'i'			=> 'siteinfo',
							'op'		=> 'forum',
							'action'	=> 'configs',
						));
					$template->assign_vars(array(
						'U_ACTION'	=> 'admin.php',
						'HIDEI'		=> $hidden,
					));
					echo $template->fetch('admin/acp_forum_settings.html');
					close_out();
					}
			break;
			case 'words':
			require_once("admin/files/acp_word.php");
			$auth = new auth();
			$auth->acl($user);
			$admin_role = new acp_words();
			$admin_role->u_action = "admin.php?i=" . $i . "&amp;op=forum_words&amp;action=words";
			$admin_role->main('',$mode);
			echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
			close_out();
			break;
			case 'prune':
			require_once("admin/files/acp_prune.php");
			$auth = new auth();
			$auth->acl($user);
			$admin_role = new acp_prune();
			$admin_role->u_action = "admin.php?i=" . $i . "&amp;op=forum_pruning&amp;action=prune&amp;mode=forums";
			$admin_role->main('',$mode);
			echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
			close_out();
			break;
			case 'permissions':
			case 'apply_all_permissions':
			require_once("include/auth.php");
			require_once("admin/files/acp_permissions.php");
			$action_a		= (isset($_POST['add_role'])) ? 'add' : request_var('action_a', '');
			$auth = new auth();
			$auth->acl($user);
			$admin_role = new acp_permissions();
			$admin_role->u_action = '/admin.php?op=' . $op . '&i=siteinfo' . (($mode)? '&amp;mode=' . $mode : '') . '&action=' . $action;

            $template->assign_vars(array(
                    'U_ACTION'                => '/admin.php?op=levels&i=userinfo' . (($mode)? '&amp;mode=' . $mode : '') . '&action=' . $action,
                    'ICON_MOVE_DOWN'          => $user->img('icon_down', 'NEW_POST'),
                    'ICON_MOVE_UP'            => $user->img('icon_up', 'NEW_POST'),
                    'ICON_MOVE_UP_DISABLED'   => $user->img('icon_up', 'NEW_POST'),
                    'ICON_MOVE_DOWN_DISABLED' => $user->img('icon_down', 'NEW_POST'),
                    'ICON_EDIT'               => $user->img('icon_edit', 'NEW_POST'),
                    'ICON_DELETE'             => $user->img('icon_delete', 'NEW_POST'),)
                );

			$admin_role->main('',$mode);
			echo $template->fetch('admin/' . $admin_role->tpl_name . '.html');
			close_out();
			break;			

				$user->set_lang('admin/acp_permissions',$user->ulanguage);
				switch ($mode)
				{
					case 'forum':
                        $do = request_var('do', '');
                        $s_hidden_fields = build_hidden_fields(array(
                                'type'   => ($op == 'setting_mod_local') ? 'm_' : 'f_',
                                'mode'   => 'forumgruop',
                                'i'      => $i,
                                'action' => 'permissions',
                                'op'     => 'forum_permissions',
                                'do'     => $do)
                        );

						$forum_list = make_forum_select(false, false, true, false, false, false, true);
						$s_forum_options = '';
						
						foreach ($forum_list as $f_id => $f_row)
						{
							$s_forum_options .= '<option value="' . $f_id . '"' . (($f_row['selected']) ? ' selected="selected"' : '') . (($f_row['disabled']) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $f_row['padding'] . $f_row['forum_name'] . '</option>';
						}
						
						$s_subforum_options		= build_subforum_options($forum_list);
						$permission_dropdown	= ($op == 'setting_mod_local') ? array('m_') : array('f_');
						$permission_victim		= array('forums', 'usergroup');
						$page_title				= ($op == 'setting_mod_local') ? 'ACP_FORUM_MODERATORS' : 'ACP_FORUM_PERMISSIONS';
						
						$template->assign_vars(array(
								'L_TITLE'				=> $user->lang[$page_title],
								'L_EXPLAIN'				=> $user->lang[$page_title . '_EXPLAIN'],
								'S_SELECT_VICTIM' 		=> true,
								'U_BACK'				=> "admin.php",
								'U_ACTION'				=> "admin.php",
								'S_SELECT_FORUM'		=> true,
								'S_FORUM_OPTIONS'		=> $s_forum_options,
								'S_SUBFORUM_OPTIONS'	=> $s_subforum_options,
								'S_FORUM_ALL'			=> true,
								'S_FORUM_MULTIPLE'		=> true,
								'S_HIDDEN_FIELDS'		=> $s_hidden_fields,
						));
					break;
					
					case 'forumgruop':
						$type			= request_var('type', '');
						$do				= request_var('do', '');
						$forum_id		= request_var('forum_id', array(0));
						$all_forums		= request_var('all_forums', 0);
						$subforum_id	= request_var('subforum_id', 0);
						
						// Build forum ids (of all forums are checked or subforum listing used)
						if ($all_forums)
						{
							$sql = 'SELECT forum_id
								FROM ' . $db_prefix .'_forums
								ORDER BY left_id';
							$result = $db->sql_query($sql);

							$forum_id = array();
							while ($row = $db->sql_fetchrow($result))
							{
								$forum_id[] = (int) $row['forum_id'];
							}
							$db->sql_freeresult($result);
						}
						else if ($subforum_id)
						{
							$forum_id = array();
							foreach (get_forum_branch($subforum_id, 'children') as $row)
							{
								$forum_id[] = (int) $row['forum_id'];
							}
						}
						if (sizeof($forum_id))
						{
							$sql = 'SELECT forum_name
								FROM ' . $db_prefix .'_forums
								WHERE ' . $db->sql_in_set('forum_id', $forum_id) . '
								ORDER BY left_id ASC';
							$result = $db->sql_query($sql);

							$forum_names = array();
							while ($row = $db->sql_fetchrow($result))
							{
								$forum_names[] = $row['forum_name'];
							}
							$db->sql_freeresult($result);
							
							$sql = 'SELECT `g_moderators`, `g_can_read`, `g_can_write`, `u_moderators`, `u_can_read`, `u_can_write`
									FROM `'.$db_prefix.'_forum_permissions` 
									WHERE ' . $db->sql_in_set('forum_id', $forum_id);
							$result = $db->sql_query($sql);

							while ($row = $db->sql_fetchrow($result))
							{
								$canwriteg = preg_split("/;;[\\s]*/",$row['g_can_write']);
								$canreadg = preg_split("/;;[\\s]*/",$row['g_can_read']);
								$modsg = preg_split("/;;[\\s]*/",$row['g_moderators']);
								$canwriteu = preg_split("/;;[\\s]*/",$row['u_can_write']);
								$canreadu = preg_split("/;;[\\s]*/",$row['u_can_read']);
								$modsu = preg_split("/;;[\\s]*/",$row['u_moderators']);
							}
							$db->sql_freeresult($result);
							$optionsg = (($type == 'm_')? $modsg : (($do == 'read')? $canreadg : $canwriteg));
							$optionsu = (($type == 'm_')? $modsu : (($do == 'read')? $canreadu : $canwriteu));
							//die(print_r($optionsg));
							$setvalg = $setvalu = '';
							if (sizeof($optionsg))
							{
							foreach($optionsg as $val)
							{
							if($val)$setvalg .= '<option class="sep" value="' . $val . '">' . getlevel($val) . '</option>';
							}
							}
							if (sizeof($optionsu))
							{
							foreach($optionsu as $val)
							{
							if($val <= 0){continue;}
							$setvalu .= '<option class="sep" value="' . $val . '">' . username_is($val) . '</option>';
							}
							}
							$s_hidden_fields = build_hidden_fields(array(
							'type'			=> $type,
							'mode'			=> 'takeforumgruop',
							'i'				=> $i,
							'action'		=> 'permissions',
							'op'			=> 'forum_permissions',
							'forum_id'		=> $forum_id,
							'do'			=>$do,
							));


							$template->assign_vars(array(
								'S_FORUM_NAMES'		=> (sizeof($forum_names)) ? true : false,
								'FORUM_NAMES'		=> implode(', ', $forum_names))
							);
						}//die(print_r($optionsg));
						$page_title = ($type == 'm_') ? 'ACP_FORUM_MODERATORS' : 'ACP_FORUM_PERMISSIONS';
						$template->assign_vars(array(
							'L_TITLE'					=> $user->lang[$page_title],
							'L_EXPLAIN'					=> $user->lang[$page_title . '_EXPLAIN'],
							'U_ACTION'					=> 'admin.php',
							'ANONYMOUS_USER_ID'			=> '0',
							'S_SELECT_USERGROUP'		=> true,
							'U_FIND_USERNAME'			=> append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=searchuser&amp;form=select_victim&amp;field=username&amp;select_single=true'),
							'S_SELECT_VICTIM'			=> true,
							'S_ALLOW_ALL_SELECT'		=> (sizeof($forum_id) > 5) ? false : true,
							'S_CAN_SELECT_USER'			=> true,
							'S_CAN_SELECT_GROUP'		=> true,
							'S_DEFINED_GROUP_OPTIONS'	=> $setvalg,
							'S_DEFINED_USER_OPTIONS'	=> $setvalu,
							'S_ADD_GROUP_OPTIONS'		=> group_select_options_id(false, $optionsg, false),	
							'S_HIDDEN_FIELDS'			=> $s_hidden_fields)
						);
					break;
					case 'takeforumgruop':
						$type				= request_var('type', '');
						$do					= request_var('do', '');
						$forum_id			= request_var('forum_id', array(0));
						$all_forums 		= request_var('all_forums', 0);
						$subforum_id 		= request_var('subforum_id', 0);
						$user_id			= request_var('user_id', array(''));
						$group_id			= request_var('group_id', array(''));
						$function			= request_var('function', array(''));
						$username 			= request_var('username', array(''), true);
						$usernames 			= request_var('usernames', '', true);
						$select_all_groups	= request_var('select_all_groups', 0);
						
						if ($usernames)
						{
							$username = explode("\n", strtolower($usernames));
						}
						unset($usernames);
						
						if (sizeof($username) && !sizeof($user_id))
						{

							user_get_id_name($user_id, $username);
							if (!sizeof($user_id))
							{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['SELECTED_USER_NOT_EXIST'] . back_link($u_action),
                                ));
								echo $template->fetch('admin/message_body.html');
								close_out();
							}
						}
						unset($username);
						// Build forum ids (of all forums are checked or subforum listing used)
						if ($all_forums)
						{
							$sql = 'SELECT forum_id
									FROM ' . $db_prefix .'_forums
									ORDER BY left_id';
							$result = $db->sql_query($sql);

							$forum_id = array();
								while ($row = $db->sql_fetchrow($result))
								{
									$forum_id[] = (int) $row['forum_id'];
								}
							$db->sql_freeresult($result);
						}
						else if ($subforum_id)
						{
							$forum_id = array();
							foreach (get_forum_branch($subforum_id, 'children') as $row)
							{
								$forum_id[] = (int) $row['forum_id'];
							}
						}
						$g_moderators = $g_can_read = $g_can_write = $group_only = $group_allow = $u_moderators = $u_can_read = $u_can_write = '';
						if (sizeof($user_id))$user_id = implode(';;',$user_id);
						if (sizeof($group_id))$group_id = implode(';;',$group_id);
						$values = array();
						if (isset($user_id) AND !$user_id == '')
						{
							$u_moderators = (($type == 'm_')? $db->sql_escape($user_id) : '');
							$u_can_read = (($type == 'f_' AND $do == 'read')? $db->sql_escape($user_id) : '');
							$u_can_write = (($type == 'f_' AND $do == 'rite')? $db->sql_escape($user_id) : '');
						}
						if (isset($group_id) AND !$group_id == '')
						{
							$g_moderators = (($type == 'm_')? $db->sql_escape($group_id) : '');
							$g_can_read = (($type == 'f_' AND $do == 'read')? $db->sql_escape($group_id) : '');
							$g_can_write = (($type == 'f_' AND $do == 'rite')? $db->sql_escape($group_id) : '');
						}
						if(!$function)
						{
							foreach($forum_id as $fid)
							{
								$update = false;
								$sql = 'SELECT count( * ) AS count, `g_moderators` , `g_can_read` , `g_can_write` , `group_only` , `group_allow` , `u_moderators` , `u_can_read` , `u_can_write` FROM `'.$db_prefix.'_forum_permissions` WHERE `forum_id` =' . $fid . ' LIMIT 1';
								$ch = $db->sql_query($sql);
								$chrow = $db->sql_fetchrow($ch);
								if($chrow['count'] > 0)
								{
									$update = true;
									$g_moderators_up = ((!$chrow['g_moderators'] == '')? $chrow['g_moderators'] . ((!$g_moderators == '')? ';;' . $g_moderators : '') : $g_moderators);
									$g_can_read_up = ((!$chrow['g_can_read'] == '')? $chrow['g_can_read'] . ((!$g_can_read == '')? ';;' . $g_can_read : '') : $g_can_read);
									$g_can_write_up = ((!$chrow['g_can_write'] == '')? $chrow['g_can_write'] . ((!$g_can_write == '')? ';;' . $g_can_write : '') : $g_can_write);
									$group_only_up = $chrow['group_only'];
									$group_allow_up = $chrow['group_allow'];
									$u_moderators_up = ((!$chrow['u_moderators'] == '')? $chrow['u_moderators'] . ((!$u_moderators == '')? ';;' . $u_moderators : '') : $u_moderators);
									$u_can_read_up = ((!$chrow['u_can_read'] == '')? $chrow['u_can_read'] . ((!$u_can_read == '')? ';;' . $u_can_read : '') : $u_can_read);
									$u_can_write_up = ((!$chrow['u_can_write'] == '')? $chrow['u_can_write'] . ((!$u_can_write == '')? ';;' . $u_can_write : '') : $u_can_write);
								}
								$sqlupdate = "UPDATE ".$db_prefix."_forum_permissions
											SET `g_moderators` ='" . $g_moderators_up . "', 
											`g_can_read` ='" . $g_can_read_up . "', 
											`g_can_write` ='" . $g_can_write_up . "', 
											`group_only` ='" . $group_only_up . "', 
											`group_allow` ='" . $group_allow_up . "', 
											`u_moderators` ='" . $u_moderators_up . "', 
											`u_can_read` ='" . $u_can_read_up . "', 
											`u_can_write` ='" . $u_can_write_up . "' 
											WHERE forum_id = ".$fid.";";
  					        	$sqlinsert = "INSERT INTO `".$db_prefix."_forum_permissions` (
										`forum_id` ,
										`g_moderators` ,
										`g_can_read` ,
										`g_can_write` ,
										`group_only` ,
										`group_allow` ,
										`u_moderators` ,
										`u_can_read` ,
										`u_can_write`
										)
										VALUES (
										'".$fid."', '".$g_moderators."', '".$g_can_read."', '".$g_can_write."', '0', '".$group_allow."', '".$u_moderators."', '".$u_can_read."', '".$u_can_write."'
										);";
       						 	if($update)$db->sql_query($sqlupdate)or btsqlerror($sqlupdate);
							 	else
       						 	$db->sql_query($sqlinsert)or btsqlerror($sqlinsert);
							}
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => true,
								        'MESSAGE_TITLE'     => $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'           => $user->lang['AUTH_UPDATED'] . back_link($u_action . '&amp;forum_id[]=' . implode('&amp;forum_id[]=', $forum_id)),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
						}
						else if($function)
						{
								if (isset($user_id) AND !$user_id == '')
								{
									if($type == 'm_')$select = 'u_moderators';
									if($type == 'f_' AND $do == 'read')$select = 'u_can_read';
									if($type == 'f_' AND $do == 'rite')$select = 'u_can_write';
								}
								if (isset($group_id) AND !$group_id == '')
								{
									if($type == 'm_')$select = 'g_moderators';
									if($type == 'f_' AND $do == 'read')$select = 'g_can_read';
									if($type == 'f_' AND $do == 'rite')$select = 'g_can_write';
								}
								if (isset($user_id) AND !$user_id == '')
								{
									$from_what = 'user_id';
								}
								if (isset($group_id) AND !$group_id == '')
								{
									$from_what = 'group_id';
								}
								$$from_what = explode(';;', $$from_what);
							foreach($forum_id as $fid)
							{
								$sql = 'SELECT ' . $select . ' FROM `'.$db_prefix.'_forum_permissions` WHERE `forum_id` =' . $fid . ' LIMIT 1';
								$ch = $db->sql_query($sql);
								$chrow = $db->sql_fetchrow($ch);
								$val_ret = explode(';;', $chrow[$select]);
								foreach($val_ret as $i=>$val)
								{
									foreach($$from_what as $ia=>$vald)
									{
										if($val === $vald)unset($val_ret[$i]);
									}
								}
								$sqlupdate = "UPDATE ".$db_prefix."_forum_permissions SET `" . $select . "` = '" . implode(';;', $val_ret) . "' WHERE `forum_id` = " . $fid;
								$db->sql_query($sqlupdate);
							}
						}
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => true,
								        'MESSAGE_TITLE'     => $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'           => $user->lang['AUTH_UPDATED'] . back_link($u_action . '&amp;forum_id[]=' . implode('&amp;forum_id[]=', $forum_id)),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
					break;
					}
				echo $template->fetch('admin/permissions.html');
				close_out();
			break;
			case 'progress_bar':
				$start = request_var('start', 0);
				$total = request_var('total', 0);

				display_progress_bar($start, $total);
				exit;
			break;

			case 'delete':

				if (!checkaccess('a_forumdel'))
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_PERMISSION_FORUM_DELETE'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

			break;

			case 'add':

				if (!checkaccess('a_forumadd'))
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_PERMISSION_FORUM_ADD'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

			break;
		}
		if ($update)
		{
			switch ($action)
			{
				case 'configs':
		        $errors = array();
		        $sqlfields = array();
		        $sqlvalues = array();
				$forum_open = request_var('sub_forum_open', '');
				$board_disable_msg = request_var('sub_board_disable_msg', '');
				$email_enable = request_var('sub_email_enable', '');
				$topics_per_page = request_var('sub_topics_per_page', '0');
				$postsper_page = request_var('sub_posts_per_page', '0');
				$max_post_length = request_var('sub_max_post_length', '0');
				$show_latest_topic = request_var('sub_show_latest_topic', '');
				$search_word_min = request_var('sub_search_word_min', '0');
				$allow_bookmarks = request_var('sub_allow_bookmarks', '');
				$shout_new_topic = request_var('sub_shout_new_topic', '');
				$shout_new_post = request_var('sub_shout_new_post', '');
				$allow_smilies = request_var('sub_allow_smilies', '');
				$allow_bbcode = request_var('sub_allow_bbcode', '');
				$allow_signatures = request_var('sub_allow_signatures', '');
				$allow_disable_censor = request_var('sub_allow_disable_censor', '');
				$allow_attachments = request_var('sub_allow_attachments', '');
				$flood_intervals = request_var('sub_flood_intervals', '0');
				$set_flood_intervals = request_var('sel_set_flood_intervals', '');
				$bump_intervals = request_var('sub_bump_intervals', '0');
				$set_bump_intervals = request_var('sel_set_bump_intervals', '');
				$img_display_inlined = request_var('sub_img_display_inlined', '');
				$img_link_width = request_var('sub_img_link_width', '0');
				$img_link_height = request_var('sub_img_link_height', '0');
				$enable_urls = request_var('sub_enable_urls', '');
				$max_post_font_size = request_var('sub_max_post_font_size', '0');
				$max_attachments = request_var('sub_max_attachments', '0');
				$min_post_chars = request_var('sub_min_post_chars', '0');
				$max_poll_options = request_var('sub_max_poll_options', '0');
				$hot_threshold = request_var('sub_hot_threshold', '0');
				$max_filesize = request_var('sub_max_filesize', '0');
				$edit_time = request_var('sub_edit_time', '0');
				$max_post_urls = request_var('sub_max_post_urls', '0');
				$max_post_smilies = request_var('sub_max_post_smilies', '0');
				$max_quote_depth = request_var('sub_max_quote_depth', '0');
				$load_search = request_var('sub_load_search', '');
				$board_hide_emails = request_var('sub_board_hide_emails', '');
				$allow_birthdays = request_var('sub_allow_birthdays', '');
				$load_birthdays = request_var('sub_load_birthdays', '');
				$display_last_edited = request_var('sub_display_last_edited', '');
				$load_moderators = request_var('sub_load_moderators', '');
				$allow_post_flash = request_var('sub_allow_post_flash', '');
				$allow_quick_reply = request_var('sub_allow_quick_reply', '');
				$enable_queue_trigger		= request_var('sub_enable_queue_trigger', '');
				$queue_trigger_posts		= request_var('sub_queue_trigger_posts', '0');
				$allow_forum_notify		= request_var('sub_allow_forum_notify', 0);
				$allow_topic_notify		= request_var('sub_allow_topic_notify', 0);
				set_config("forum_open",(!$forum_open ? "0" : "1"));
				set_config("allow_quick_reply",(!$allow_quick_reply ? "0" : "1"));
				set_config("allow_forum_notify",(!$allow_forum_notify ? "0" : "1"));
				set_config("allow_topic_notify",(!$allow_topic_notify ? "0" : "1"));
				set_config("board_disable_msg",$board_disable_msg);
				set_config("email_enable",((!$email_enable)? "0" : "1"));

				if($topics_per_page){
					if(is_numeric($topics_per_page)){
					set_config("topics_per_page",$topics_per_page);
					}
					else
						$errors[] = "ERROR_TPP_NOT_N";
					}
				else
					$errors[] = "ERROR_TPP_NOT_SET";

				if($postsper_page){
					if(is_numeric($postsper_page)){
						set_config("posts_per_page",$postsper_page);
					}
					else
						$errors[] = "ERROR_PPP_NOT_N";
					}
				else
					$errors[] = "ERROR_PPP_NOT_SET";

				if(!$max_post_length >= '0'){
					if(is_numeric($max_post_length)){
						set_config("max_post_length",$max_post_length);
					}
					else
						$errors[] = "ERROR_MAX_POST_LEN";
					}
				else
					$errors[] = "ERROR_MAX_POST_LEN_SET";

					set_config("show_latest_topic",((!$show_latest_topic)? "0" : "1"));

				if($search_word_min >= 0){
					if(is_numeric($search_word_min)){
						set_config("search_word_min",$search_word_min);
					}
					else
						$errors[] = "ERROR_SEARCH_W_MIN_N";
					}
				else
					$errors[] = "ERROR_SEARCH_W_MIN_SET";

					set_config("allow_bookmarks",((!$allow_bookmarks)? 0 : 1));
					set_config("shout_new_topic",((!$shout_new_topic)? 0 : 1));
					set_config("shout_new_post",((!$shout_new_post)? 0 : 1));
					set_config("allow_smilies",((!$allow_smilies)? 0 : 1));
					set_config("allow_bbcode",((!$allow_bbcode)? 0 : 1));
					set_config("allow_signatures",((!$allow_signatures)? 0 : 1));
					set_config("allow_disable_censor",(($allow_disable_censor == 'false')? 0 : 1));
					set_config("allow_attachments",((!$allow_attachments)? 0 : 1));
				if($flood_intervals >= 0){
					if(is_numeric($flood_intervals)){
					set_config("flood_intervals",$flood_intervals);
					}
					else
						$errors[] = "ERROR_FLOOD_INTER_N";
					}
				else
					$errors[] = "ERROR_FLOOD_INTER_SET";

					set_config("set_flood_intervals",(($set_flood_intervals == 'm')? "m" : "s"));

				if($bump_intervals >= 0){
					if(is_numeric($bump_intervals)){
					set_config("bump_intervals",$bump_intervals);
					}
					else
					$errors[] = "ERROR_BUMP_INTER_N";
				}
				else
					$errors[] = "ERROR_BUMP_INTER_SET";
				
					set_config("set_bump_intervals",(($set_bump_intervals == 'm')? "m" : (($set_bump_intervals == 'h')? "h" : "d")));
				
					set_config("img_display_inlined",((!$img_display_inlined)? "0" : "1"));
				if($img_link_width >= 0){
					if(is_numeric($img_link_width)){
						set_config("img_link_width",$img_link_width);
					}
					else
						$errors[] = "ERROR_IMG_LNG_W_N";
				}
				else
					$errors[] = "ERROR_IMG_LNG_W_SET";
				
				if($img_link_height >= 0){
					if(is_numeric($img_link_height)){
						set_config("img_link_height",$img_link_height);
					}
					else
						$errors[] = "ERROR_IMG_HGT_W_N";
				}
				else
					$errors[] = "ERROR_IMG_HGT_W_SET";
				
					set_config("enable_urls",((!$enable_urls)? 0 : 1));
				if($max_post_font_size >= 0){
					if(is_numeric($max_post_font_size)){
						set_config("max_post_font_size",$max_post_font_size);
					}
					else
						$errors[] = "ERROR_MAX_FONT_N";
				}
				else
					$errors[] = "ERROR_MAX_FONT_SET";
					
				if($max_attachments >= 0){
					if(is_numeric($max_attachments)){
						set_config("max_attachments",$max_attachments);
					}
					else
						$errors[] = "ERROR_MAX_ATTACH_N";
				}
				else
					$errors[] = "ERROR_MAX_ATTACH_SET";
				
				if($min_post_chars >= 0){
					if(is_numeric($min_post_chars)){
						set_config("min_post_chars",$min_post_chars);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "min_post_chars";
				
				if($max_poll_options >= 0){
					if(is_numeric($max_poll_options)){
						set_config("max_poll_options",$max_poll_options);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "max_poll_options";
				
				if($hot_threshold >= 0){
					if(is_numeric($hot_threshold)){
						set_config("hot_threshold",$hot_threshold);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "hot_threshold";
				
				if($max_filesize >= 0){
					if(is_numeric($max_filesize)){
						set_config("max_filesize",$max_filesize);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "max_filesize";
				
				if($edit_time >= 0){
					if(is_numeric($edit_time)){
					set_config("edit_time",$edit_time);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "edit_time";
				
				if($max_post_urls >= 0){
					if(is_numeric($max_post_urls)){
					set_config("max_post_urls",$max_post_urls);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "max_post_urls";
				
				if($max_post_smilies >= 0){
					if(is_numeric($max_post_smilies)){
					set_config("max_post_smilies",$max_post_smilies);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "max_post_smilies";
				
				if($max_quote_depth >= 0){
					if(is_numeric($max_quote_depth)){
					set_config("max_quote_depth",$max_quote_depth);
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "max_quote_depth";
				
					set_config("load_search",((!$load_search)? 0 : 1));
					set_config("board_hide_emails",((!$board_hide_emails)? 0 : 1));
					set_config("allow_birthdays",((!$allow_birthdays)? 0 : 1));
					set_config("load_birthdays",((!$load_birthdays)? 0 : 1));
					set_config("display_last_edited",((!$display_last_edited)? 0 : 1));
					set_config("load_moderators",((!$load_moderators)? 0 : 1));
					set_config("allow_post_flash",((!$allow_post_flash)? 0 : 1));
					set_config("enable_queue_trigger",((!$enable_queue_trigger)? 0 : 1));
				if($queue_trigger_posts >= 0){
					if(is_numeric($queue_trigger_posts)){
					set_config("queue_trigger_posts",(($queue_trigger_posts == 'false')? 0 : 1));
					}
					else
						$errors[] = "Topics Perpage not Numeric";
				}
				else
					$errors[] = "$queue_trigger_posts 1";
	
 		       if (count($errors) > 0)
				{
				bterror($errors,"Board settings not saved");
				die();
				}
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/".$u_action."&amp;action=configs",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => sprintf($user->lang['SITTINGS_SAVED'],$user->lang['FORM_UPDATED']),
                                ));
		echo $template->fetch('message_body.html');
		close_out();
				break;
				case 'delete':
					$action_subforums	= request_var('action_subforums', '');
					$subforums_to_id	= request_var('subforums_to_id', 0);
					$action_posts		= request_var('action_posts', '');
					$posts_to_id		= request_var('posts_to_id', 0);

					$errors = delete_forum($forum_id, $action_posts, $action_subforums, $posts_to_id, $subforums_to_id);

					if (sizeof($errors))
					{
						break;
					}


                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => true,
								        'MESSAGE_TITLE'     	=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'          => $user->lang['FORUM_DELETED'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();

				break;

				case 'edit':
					$forum_data = array(
						'forum_id'		=>	$forum_id
					);

				// No break here

				case 'add':
					require_once("include/auth.php");
					$auth = new auth();
					$auth->acl($user);
					$forum_data += array(
						'parent_id'				=> request_var('forum_parent_id', $parent_id),
						'forum_type'			=> request_var('forum_type', 1),
						'type_action'			=> request_var('type_action', ''),
						'forum_status'			=> request_var('forum_status', 0),
						'forum_parents'			=> '',
						'forum_name'			=> request_var('forum_name', '', true),
						'forum_link'			=> request_var('forum_link', ''),
						'forum_link_track'		=> request_var('forum_link_track', false),
						'forum_desc'			=> request_var('forum_desc', '', true),
						'forum_desc_uid'		=> '',
						'forum_desc_options'	=> 7,
						'forum_desc_bitfield'	=> '',
						'forum_rules'			=> request_var('forum_rules', '', true),
						'forum_rules_uid'		=> '',
						'forum_rules_options'	=> 7,
						'forum_rules_bitfield'	=> '',
						'forum_rules_link'		=> request_var('forum_rules_link', ''),
						'forum_image'			=> request_var('forum_image', ''),
						'forum_style'			=> request_var('forum_style', 0),
						'display_subforum_list'	=> request_var('display_subforum_list', false),
						'display_on_index'		=> request_var('display_on_index', false),
						'forum_topics_per_page'	=> request_var('topics_per_page', 0),
						'enable_indexing'		=> request_var('enable_indexing', true),
						'enable_icons'			=> request_var('enable_icons', false),
						'enable_prune'			=> request_var('enable_prune', false),
						'enable_post_review'	=> request_var('enable_post_review', true),
						'enable_quick_reply'	=> request_var('enable_quick_reply', false),
						'prune_days'			=> request_var('prune_days', 7),
						'prune_viewed'			=> request_var('prune_viewed', 7),
						'prune_freq'			=> request_var('prune_freq', 1),
						'prune_old_polls'		=> request_var('prune_old_polls', false),
						'prune_announce'		=> request_var('prune_announce', false),
						'prune_sticky'			=> request_var('prune_sticky', false),
						'forum_password'		=> request_var('forum_password', '', true),
						'forum_password_confirm'=> request_var('forum_password_confirm', '', true),
						'forum_password_unset'	=> request_var('forum_password_unset', false),
					);

					// On add, add empty forum_options... else do not consider it (not updating it)
					if ($action == 'add')
					{
						$forum_data['forum_options'] = 0;
					}

					// Use link_display_on_index setting if forum type is link
					if ($forum_data['forum_type'] == 2)
					{
						$forum_data['display_on_index'] = request_var('link_display_on_index', false);
					}

					// Linked forums and categories are not able to be locked...
					if ($forum_data['forum_type'] == 2 || $forum_data['forum_type'] == 0)
					{
						$forum_data['forum_status'] = 0;
					}

					$forum_data['show_active'] = ($forum_data['forum_type'] == 1) ? request_var('display_recent', true) : request_var('display_active', false);

					// Get data for forum rules if specified...
					if ($forum_data['forum_rules'])
					{
						generate_text_for_storage($forum_data['forum_rules'], $forum_data['forum_rules_uid'], $forum_data['forum_rules_bitfield'], $forum_data['forum_rules_options'], request_var('rules_parse_bbcode', false), request_var('rules_parse_urls', false), request_var('rules_parse_smilies', false));
					}

					// Get data for forum description if specified
					if ($forum_data['forum_desc'])
					{
						generate_text_for_storage($forum_data['forum_desc'], $forum_data['forum_desc_uid'], $forum_data['forum_desc_bitfield'], $forum_data['forum_desc_options'], request_var('desc_parse_bbcode', false), request_var('desc_parse_urls', false), request_var('desc_parse_smilies', false));
					}

					$errors = update_forum_data($forum_data);

					if (!sizeof($errors))
					{
						$forum_perm_from = request_var('forum_perm_from', 0);

						$copied_permissions = false;
						// Copy permissions?
						if ($forum_perm_from && $forum_perm_from != $forum_data['forum_id'] &&
							($action != 'edit' || empty($forum_id) || ($auth->acl_get('a_fauth') && $auth->acl_get('a_authusers') && $auth->acl_get('a_authgroups') && $auth->acl_get('a_mauth'))))
						{
							// if we edit a forum delete current permissions first
							if ($action == 'edit')
							{
								$sql = 'DELETE FROM ' . $db_prefix . '_acl_users
									WHERE forum_id = ' . (int) $forum_data['forum_id'];
								$db->sql_query($sql);

								$sql = 'DELETE FROM ' . $db_prefix . '_acl_groups
									WHERE forum_id = ' . (int) $forum_data['forum_id'];
								$db->sql_query($sql);
							}

							// From the mysql documentation:
							// Prior to MySQL 4.0.14, the target table of the INSERT statement cannot appear in the FROM clause of the SELECT part of the query. This limitation is lifted in 4.0.14.
							// Due to this we stay on the safe side if we do the insertion "the manual way"

							// Copy permisisons from/to the acl users table (only forum_id gets changed)
							$sql = 'SELECT user_id, auth_option_id, auth_role_id, auth_setting
								FROM ' . $db_prefix . '_acl_users
								WHERE forum_id = ' . $forum_perm_from;
							$result = $db->sql_query($sql);

							$users_sql_ary = array();
							while ($row = $db->sql_fetchrow($result))
							{
								$users_sql_ary[] = array(
									'user_id'			=> (int) $row['user_id'],
									'forum_id'			=> (int) $forum_data['forum_id'],
									'auth_option_id'	=> (int) $row['auth_option_id'],
									'auth_role_id'		=> (int) $row['auth_role_id'],
									'auth_setting'		=> (int) $row['auth_setting']
								);
							}
							$db->sql_freeresult($result);

							// Copy permisisons from/to the acl groups table (only forum_id gets changed)
							$sql = 'SELECT group_id, auth_option_id, auth_role_id, auth_setting
								FROM ' . $db_prefix . '_acl_groups
								WHERE forum_id = ' . $forum_perm_from;
							$result = $db->sql_query($sql);

							$groups_sql_ary = array();
							while ($row = $db->sql_fetchrow($result))
							{
								$groups_sql_ary[] = array(
									'group_id'			=> (int) $row['group_id'],
									'forum_id'			=> (int) $forum_data['forum_id'],
									'auth_option_id'	=> (int) $row['auth_option_id'],
									'auth_role_id'		=> (int) $row['auth_role_id'],
									'auth_setting'		=> (int) $row['auth_setting']
								);
							}
							$db->sql_freeresult($result);

							// Now insert the data
							$db->sql_multi_insert($db_prefix . '_acl_users', $users_sql_ary);
							$db->sql_multi_insert($db_prefix . '_acl_groups', $groups_sql_ary);
							cache_moderators();
						}

						$acl_url = '&amp;mode=setting_forum_local&amp;forum_id[]=' . $forum_data['forum_id'];

						$message = ($action == 'add') ? $user->lang['FORUM_CREATED'] : $user->lang['FORUM_UPDATED'];

						// Redirect to permissions
						if (checkaccess('a_fauth') && !$copied_permissions)
						{
							$message .= '<br /><br />' . sprintf($user->lang['REDIRECT_ACL'], '<a href="' . append_sid("./admin.php", 'op=levels&i=userinfo&action=setting_forum_local' . $acl_url) . '">', '</a>');
						}

						// redirect directly to permission settings screen if authed
						if ($action == 'add' && !$copied_permissions && checkaccess('a_fauth'))
						{
							meta_refresh(4, append_sid("./admin.php", 'op=levels&i=userinfo&action=setting_forum_local' . $acl_url));
						}

                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => true,
								        'MESSAGE_TITLE'     	=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'          => $message . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
					}

				break;
			}
		}
		switch ($action)
		{
			case 'move_up':
			case 'move_down':

				if (!$forum_id)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

				$sql = 'SELECT *
					FROM ' . $db_prefix ."_forums
					WHERE forum_id = $forum_id";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}
				$move_forum_name = move_forum_by($row, $action, 1);

				if ($move_forum_name !== false)
				{
					add_log('admin','LOG_FORUM_' . strtoupper($action), $row['forum_name'], $move_forum_name);
				}

			break;

			case 'sync':
				if (!$forum_id)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

				@set_time_limit(0);

				$sql = 'SELECT forum_name, forum_topics_real
					FROM ' . $db_prefix ."_forums
					WHERE forum_id = $forum_id";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

				if ($row['forum_topics_real'])
				{
					$sql = 'SELECT MIN(topic_id) as min_topic_id, MAX(topic_id) as max_topic_id
						FROM ' . $db_prefix . '_topics
						WHERE forum_id = ' . $forum_id;
					$result = $db->sql_query($sql);
					$row2 = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					// Typecast to int if there is no data available
					$row2['min_topic_id'] = (int) $row2['min_topic_id'];
					$row2['max_topic_id'] = (int) $row2['max_topic_id'];

					$start = request_var('start', $row2['min_topic_id']);

					$batch_size = 2000;
					$end = $start + $batch_size;
					// Sync all topics in batch mode...
					sync('topic_approved', 'range', 'topic_id BETWEEN ' . $start . ' AND ' . $end, true, false);
					sync('topic', 'range', 'topic_id BETWEEN ' . $start . ' AND ' . $end, true, true);

					if ($end < $row2['max_topic_id'])
					{
						// We really need to find a way of showing statistics... no progress here
						$sql = 'SELECT COUNT(topic_id) as num_topics
							FROM ' . $db_prefix . '_topics
							WHERE forum_id = ' . $forum_id . '
								AND topic_id BETWEEN ' . $start . ' AND ' . $end;
						$result = $db->sql_query($sql);
						$topics_done = request_var('topics_done', 0) + (int) $db->sql_fetchfield('num_topics');
						$db->sql_freeresult($result);

						$start += $batch_size;

						$url = $u_action . "&amp;parent_id={$parent_id}&amp;f=$forum_id&amp;action=sync&amp;start=$start&amp;topics_done=$topics_done&amp;total={$row['forum_topics_real']}";

						meta_refresh(0, $url);

						$template->assign_vars(array(
							'U_PROGRESS_BAR'		=> $u_action . "&amp;action=progress_bar&amp;start=$topics_done&amp;total={$row['forum_topics_real']}",
							'UA_PROGRESS_BAR'		=> addslashes($u_action . "&amp;action=progress_bar&amp;start=$topics_done&amp;total={$row['forum_topics_real']}"),
							'S_CONTINUE_SYNC'		=> true,
							'L_PROGRESS_EXPLAIN'	=> sprintf($user->lang['SYNC_IN_PROGRESS_EXPLAIN'], $topics_done, $row['forum_topics_real']))
						);

						;
					}
				}

				$url = $u_action . "&amp;parent_id={$parent_id}&amp;f=$forum_id&amp;action=sync_forum";
				meta_refresh(0, $url);

				$template->assign_vars(array(
					'U_PROGRESS_BAR'		=> $u_action . '&amp;action=progress_bar',
					'UA_PROGRESS_BAR'		=> addslashes($u_action . '&amp;action=progress_bar'),
					'S_CONTINUE_SYNC'		=> true,
					'L_PROGRESS_EXPLAIN'	=> sprintf($user->lang['SYNC_IN_PROGRESS_EXPLAIN'], 0, $row['forum_topics_real']))
				);

				break;

			break;

			case 'sync_forum':

				$sql = 'SELECT forum_name, forum_type
					FROM ' . $db_prefix ."_forums
					WHERE forum_id = $forum_id";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

				sync('forum', 'forum_id', $forum_id, false, true);

				add_log('admin','LOG_FORUM_SYNC', $row['forum_name']);

				$template->assign_var('L_FORUM_RESYNCED', sprintf($user->lang['FORUM_RESYNCED'], $row['forum_name']));

			break;

			case 'add':
			case 'edit':

				if ($update)
				{
					$forum_data['forum_flags'] = 0;
					$forum_data['forum_flags'] += (request_var('forum_link_track', false)) ? 1 : 0;
					$forum_data['forum_flags'] += (request_var('prune_old_polls', false)) ? 2 : 0;
					$forum_data['forum_flags'] += (request_var('prune_announce', false)) ? 4 : 0;
					$forum_data['forum_flags'] += (request_var('prune_sticky', false)) ? 8 : 0;
					$forum_data['forum_flags'] += ($forum_data['show_active']) ? 16 : 0;
					$forum_data['forum_flags'] += (request_var('enable_post_review', true)) ? 32 : 0;
					$forum_data['forum_flags'] += (request_var('enable_quick_reply', false)) ? 64 : 0;
				}

				// Show form to create/modify a forum
				if ($action == 'edit')
				{
					$page_title = 'EDIT_FORUM';
					$row = get_forum_info($forum_id);
					$old_forum_type = $row['forum_type'];

					if (!$update)
					{
						$forum_data = $row;
					}
					else
					{
						$forum_data['left_id'] = $row['left_id'];
						$forum_data['right_id'] = $row['right_id'];
					}

					// Make sure no direct child forums are able to be selected as parents.
					$exclude_forums = array();
					foreach (get_forum_branch($forum_id, 'children') as $row)
					{
						$exclude_forums[] = $row['forum_id'];
					}

					$parents_list = make_forum_select($forum_data['parent_id'], $exclude_forums, false, false, false);

					$forum_data['forum_password_confirm'] = $forum_data['forum_password'];
				}
				else
				{
					$page_title = 'CREATE_FORUM';

					$forum_id = $parent_id;
					$parents_list = make_forum_select($parent_id, false, false, false, false);

					// Fill forum data with default values
					if (!$update)
					{
						$forum_data = array(
							'parent_id'				=> $parent_id,
							'forum_type'			=> 1,
							'forum_status'			=> 0,
							'forum_name'			=> request_var('forum_name', '', true),
							'forum_link'			=> '',
							'forum_link_track'		=> false,
							'forum_desc'			=> '',
							'forum_rules'			=> '',
							'forum_rules_link'		=> '',
							'forum_image'			=> '',
							'forum_style'			=> 0,
							'display_subforum_list'	=> true,
							'display_on_index'		=> false,
							'forum_topics_per_page'	=> 0,
							'enable_indexing'		=> true,
							'enable_icons'			=> false,
							'enable_prune'			=> false,
							'prune_days'			=> 7,
							'prune_viewed'			=> 7,
							'prune_freq'			=> 1,
							'forum_flags'			=> 32 + 16,
							'forum_options'			=> 0,
							'forum_password'		=> '',
							'forum_password_confirm'=> '',
						);
					}
				}

				$forum_rules_data = array(
					'text'			=> $forum_data['forum_rules'],
					'allow_bbcode'	=> true,
					'allow_smilies'	=> true,
					'allow_urls'	=> true
				);

				$forum_desc_data = array(
					'text'			=> $forum_data['forum_desc'],
					'allow_bbcode'	=> true,
					'allow_smilies'	=> true,
					'allow_urls'	=> true
				);

				$forum_rules_preview = '';

				// Parse rules if specified
				if ($forum_data['forum_rules'])
				{
					if (!isset($forum_data['forum_rules_uid']))
					{
						// Before we are able to display the preview and plane text, we need to parse our request_var()'d value...
						$forum_data['forum_rules_uid'] = '';
						$forum_data['forum_rules_bitfield'] = '';
						$forum_data['forum_rules_options'] = 0;

						generate_text_for_storage($forum_data['forum_rules'], $forum_data['forum_rules_uid'], $forum_data['forum_rules_bitfield'], $forum_data['forum_rules_options'], request_var('rules_allow_bbcode', false), request_var('rules_allow_urls', false), request_var('rules_allow_smilies', false));
					}

					// Generate preview content
					$forum_rules_preview = generate_text_for_display($forum_data['forum_rules'], $forum_data['forum_rules_uid'], $forum_data['forum_rules_bitfield'], $forum_data['forum_rules_options']);

					// decode...
					$forum_rules_data = generate_text_for_edit($forum_data['forum_rules'], $forum_data['forum_rules_uid'], $forum_data['forum_rules_options']);
				}

				// Parse desciption if specified
				if ($forum_data['forum_desc'])
				{
					if (!isset($forum_data['forum_desc_uid']))
					{
						// Before we are able to display the preview and plane text, we need to parse our request_var()'d value...
						$forum_data['forum_desc_uid'] = '';
						$forum_data['forum_desc_bitfield'] = '';
						$forum_data['forum_desc_options'] = 0;

						generate_text_for_storage($forum_data['forum_desc'], $forum_data['forum_desc_uid'], $forum_data['forum_desc_bitfield'], $forum_data['forum_desc_options'], request_var('desc_allow_bbcode', false), request_var('desc_allow_urls', false), request_var('desc_allow_smilies', false));
					}

					// decode...
					$forum_desc_data = generate_text_for_edit($forum_data['forum_desc'], $forum_data['forum_desc_uid'], $forum_data['forum_desc_options']);
				}

				$forum_type_options = '';
				$forum_type_ary = array(0 => 'CAT', 1 => 'FORUM', 2 => 'LINK');

				foreach ($forum_type_ary as $value => $lang)
				{
					$forum_type_options .= '<option value="' . $value . '"' . (($value == $forum_data['forum_type']) ? ' selected="selected"' : '') . '>' . $user->lang['TYPE_' . $lang] . '</option>';
				}

				$styles_list = '';//style_select($forum_data['forum_style'], true);

				$statuslist = '<option value="' . 0 . '"' . (($forum_data['forum_status'] == 0) ? ' selected="selected"' : '') . '>' . $user->lang['UNLOCKED'] . '</option><option value="' . 1 . '"' . (($forum_data['forum_status'] == 1) ? ' selected="selected"' : '') . '>' . $user->lang['LOCKED'] . '</option>';

				$sql = 'SELECT forum_id
					FROM ' . $db_prefix .'_forums
					WHERE forum_type = ' . $db_prefix ."_posts
						AND forum_id <> $forum_id LIMIT 1";
				$result = $db->sql_query($sql, 1);

				$postable_forum_exists = false;
				if ($db->sql_fetchrow($result))
				{
					$postable_forum_exists = true;
				}
				$db->sql_freeresult($result);

				// Subforum move options
				if ($action == 'edit' && $forum_data['forum_type'] == 0)
				{
					$subforums_id = array();
					$subforums = get_forum_branch($forum_id, 'children');

					foreach ($subforums as $row)
					{
						$subforums_id[] = $row['forum_id'];
					}

					$forums_list = make_forum_select($forum_data['parent_id'], $subforums_id);

					if ($postable_forum_exists)
					{
						$template->assign_vars(array(
							'S_MOVE_FORUM_OPTIONS'		=> make_forum_select($forum_data['parent_id'], $subforums_id)) // , false, true, false???
						);
					}

					$template->assign_vars(array(
						'S_HAS_SUBFORUMS'		=> ($forum_data['right_id'] - $forum_data['left_id'] > 1) ? true : false,
						'S_FORUMS_LIST'			=> $forums_list)
					);
				}
				else if ($postable_forum_exists)
				{
					$template->assign_vars(array(
						'S_MOVE_FORUM_OPTIONS'		=> '',)//make_forum_select($forum_data['parent_id'], $forum_id, false, true, false))
					);
				}

				$s_show_display_on_index = false;

				if ($forum_data['parent_id'] > 0)
				{
					// if this forum is a subforum put the "display on index" checkbox
					if ($parent_info = get_forum_info($forum_data['parent_id']))
					{
						if ($parent_info['parent_id'] > 0 || $parent_info['forum_type'] == 0)
						{
							$s_show_display_on_index = true;
						}
					}
				}

				if (strlen($forum_data['forum_password']) == 32)
				{
					$errors[] = $user->lang['FORUM_PASSWORD_OLD'];
				}

				$template->assign_vars(array(
					'S_EDIT_FORUM'		=> true,
					'S_ERROR'			=> (sizeof($errors)) ? true : false,
					'S_PARENT_ID'		=> $parent_id,
					'S_FORUM_PARENT_ID'	=> $forum_data['parent_id'],
					'S_ADD_ACTION'		=> ($action == 'add') ? true : false,

					'U_BACK'		=> $u_action . '&amp;parent_id=' . $parent_id,
					'U_EDIT_ACTION'	=> $u_action . "&amp;parent_id={$parent_id}&amp;action=$action&amp;f=$forum_id",

					'L_COPY_PERMISSIONS_EXPLAIN'	=> $user->lang['COPY_PERMISSIONS_' . strtoupper($action) . '_EXPLAIN'],
					'L_TITLE'						=> $user->lang[$page_title],
					'ERROR_MSG'						=> (sizeof($errors)) ? implode('<br />', $errors) : '',

					'FORUM_NAME'				=> $forum_data['forum_name'],
					'FORUM_DATA_LINK'			=> $forum_data['forum_link'],
					'FORUM_IMAGE'				=> $forum_data['forum_image'],
					'FORUM_IMAGE_SRC'			=> ($forum_data['forum_image']) ? $phpbb_root_path . $forum_data['forum_image'] : '',
					'FORUM_POST'				=> 1,
					'FORUM_LINK'				=> 2,
					'FORUM_CAT'					=> 0,
					'PRUNE_FREQ'				=> $forum_data['prune_freq'],
					'PRUNE_DAYS'				=> $forum_data['prune_days'],
					'PRUNE_VIEWED'				=> $forum_data['prune_viewed'],
					'TOPICS_PER_PAGE'			=> $forum_data['forum_topics_per_page'],
					'FORUM_RULES_LINK'			=> $forum_data['forum_rules_link'],
					'FORUM_RULES'				=> $forum_data['forum_rules'],
					'FORUM_RULES_PREVIEW'		=> $forum_rules_preview,
					'FORUM_RULES_PLAIN'			=> $forum_rules_data['text'],
					'S_BBCODE_CHECKED'			=> ($forum_rules_data['allow_bbcode']) ? true : false,
					'S_SMILIES_CHECKED'			=> ($forum_rules_data['allow_smilies']) ? true : false,
					'S_URLS_CHECKED'			=> ($forum_rules_data['allow_urls']) ? true : false,
					'S_FORUM_PASSWORD_SET'		=> (empty($forum_data['forum_password'])) ? false : true,

					'FORUM_DESC'				=> $forum_desc_data['text'],
					'S_DESC_BBCODE_CHECKED'		=> ($forum_desc_data['allow_bbcode']) ? true : false,
					'S_DESC_SMILIES_CHECKED'	=> ($forum_desc_data['allow_smilies']) ? true : false,
					'S_DESC_URLS_CHECKED'		=> ($forum_desc_data['allow_urls']) ? true : false,

					'S_FORUM_TYPE_OPTIONS'		=> $forum_type_options,
					'S_STATUS_OPTIONS'			=> $statuslist,
					'S_PARENT_OPTIONS'			=> $parents_list,
					'S_STYLES_OPTIONS'			=> $styles_list,
					'S_FORUM_OPTIONS'			=> make_forum_select(($action == 'add') ? $forum_data['parent_id'] : false, ($action == 'edit') ? $forum_data['forum_id'] : false, false, false, false),
					'S_SHOW_DISPLAY_ON_INDEX'	=> $s_show_display_on_index,
					'S_FORUM_POST'				=> ($forum_data['forum_type'] == 1) ? true : false,
					'S_FORUM_ORIG_POST'			=> (isset($old_forum_type) && $old_forum_type == 1) ? true : false,
					'S_FORUM_ORIG_CAT'			=> (isset($old_forum_type) && $old_forum_type == 0) ? true : false,
					'S_FORUM_ORIG_LINK'			=> (isset($old_forum_type) && $old_forum_type == 2) ? true : false,
					'S_FORUM_LINK'				=> ($forum_data['forum_type'] == 2) ? true : false,
					'S_FORUM_CAT'				=> ($forum_data['forum_type'] == 0) ? true : false,
					'S_ENABLE_INDEXING'			=> ($forum_data['enable_indexing']) ? true : false,
					'S_TOPIC_ICONS'				=> ($forum_data['enable_icons']) ? true : false,
					'S_DISPLAY_SUBFORUM_LIST'	=> ($forum_data['display_subforum_list']) ? true : false,
					'S_DISPLAY_ON_INDEX'		=> ($forum_data['display_on_index']) ? true : false,
					'S_PRUNE_ENABLE'			=> ($forum_data['enable_prune']) ? true : false,
					'S_FORUM_LINK_TRACK'		=> ($forum_data['forum_flags'] & 1) ? true : false,
					'S_PRUNE_OLD_POLLS'			=> ($forum_data['forum_flags'] & 2) ? true : false,
					'S_PRUNE_ANNOUNCE'			=> ($forum_data['forum_flags'] & 4) ? true : false,
					'S_PRUNE_STICKY'			=> ($forum_data['forum_flags'] & 8) ? true : false,
					'S_DISPLAY_ACTIVE_TOPICS'	=> ($forum_data['forum_type'] == 1) ? ($forum_data['forum_flags'] & 16) : true,
					'S_ENABLE_ACTIVE_TOPICS'	=> ($forum_data['forum_type'] == 0) ? ($forum_data['forum_flags'] & 16) : false,
					'S_ENABLE_POST_REVIEW'		=> ($forum_data['forum_flags'] & 32) ? true : false,
					'S_ENABLE_QUICK_REPLY'		=> ($forum_data['forum_flags'] & 64) ? true : false,
					'S_CAN_COPY_PERMISSIONS'	=> ($action != 'edit' || empty($forum_id) || (checkaccess('a_fauth') && checkaccess('a_authusers') && checkaccess('a_authgroups') && checkaccess('a_mauth'))) ? true : false,
				));

				//return;

			break;

			case 'delete':

				if (!$forum_id)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

				$forum_data = get_forum_info($forum_id);

				$subforums_id = array();
				$subforums = get_forum_branch($forum_id, 'children');

				foreach ($subforums as $row)
				{
					$subforums_id[] = $row['forum_id'];
				}

				$forums_list = make_forum_select($forum_data['parent_id'], $subforums_id);

				$sql = 'SELECT forum_id
					FROM ' . $db_prefix .'_forums
					WHERE forum_type = ' . $db_prefix . "_posts
						AND forum_id <> $forum_id LIMIT 1";
				$result = $db->sql_query($sql);

				if ($db->sql_fetchrow($result))
				{
					$template->assign_vars(array(
						'S_MOVE_FORUM_OPTIONS'		=> make_forum_select($forum_data['parent_id'], $subforums_id, false, true)) // , false, true, false???
					);
				}
				$db->sql_freeresult($result);

				$parent_id = ($parent_id == $forum_id) ? 0 : $parent_id;

				$template->assign_vars(array(
					'S_DELETE_FORUM'		=> true,
					'U_ACTION_DEL'				=> $u_action . "&amp;update=save&amp;parent_id={$parent_id}&amp;action=delete&amp;f=$forum_id",
					'U_BACK'				=> $u_action . '&amp;parent_id=' . $parent_id,

					'FORUM_NAME'			=> $forum_data['forum_name'],
					'S_FORUM_POST'			=> ($forum_data['forum_type'] == 1) ? true : false,
					'S_FORUM_LINK'			=> ($forum_data['forum_type'] == 2) ? true : false,
					'S_HAS_SUBFORUMS'		=> ($forum_data['right_id'] - $forum_data['left_id'] > 1) ? true : false,
					'S_FORUMS_LIST'			=> $forums_list,
					'S_ERROR'				=> (sizeof($errors)) ? true : false,
					'ERROR_MSG'				=> (sizeof($errors)) ? implode('<br />', $errors) : '')
				);

				//return;
			break;

			case 'copy_perm':
				$forum_perm_from = request_var('forum_perm_from', 0);

				// Copy permissions?
				if (!empty($forum_perm_from) && $forum_perm_from != $forum_id)
				{
					copy_forum_permissions($forum_perm_from, $forum_id, true);

					$acl_url = '&amp;mode=setting_forum_local&amp;forum_id[]=' . $forum_id;

					$message = $user->lang['FORUM_UPDATED'];

					// Redirect to permissions
					if (checkaccess('a_fauth'))
					{
						$message .= '<br /><br />' . sprintf($user->lang['REDIRECT_ACL'], '<a href="' . append_sid("{$phpbb_admin_path}index.$phpEx", 'i=permissions' . $acl_url) . '">', '</a>');
					}

                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'] . back_link($u_action . '&amp;parent_id=' . $parent_id),
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
				}

			break;
		}
	function move_forum_by($forum_row, $action = 'move_up', $steps = 1)
	{
		global $db, $db_prefix;

		/**
		* Fetch all the siblings between the module's current spot
		* and where we want to move it to. If there are less than $steps
		* siblings between the current spot and the target then the
		* module will move as far as possible
		*/
		$sql = 'SELECT forum_id, forum_name, left_id, right_id
			FROM ' . $db_prefix ."_forums
			WHERE parent_id = {$forum_row['parent_id']}
				AND " . (($action == 'move_up') ? "right_id < {$forum_row['right_id']} ORDER BY right_id DESC" : "left_id > {$forum_row['left_id']} ORDER BY left_id ASC LIMIT $steps");
		$result = $db->sql_query($sql, $steps);

		$target = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$target = $row;
		}
		$db->sql_freeresult($result);

		if (!sizeof($target))
		{
			// The forum is already on top or bottom
			return false;
		}

		/**
		* $left_id and $right_id define the scope of the nodes that are affected by the move.
		* $diff_up and $diff_down are the values to substract or add to each node's left_id
		* and right_id in order to move them up or down.
		* $move_up_left and $move_up_right define the scope of the nodes that are moving
		* up. Other nodes in the scope of ($left_id, $right_id) are considered to move down.
		*/
		if ($action == 'move_up')
		{
			$left_id = $target['left_id'];
			$right_id = $forum_row['right_id'];

			$diff_up = $forum_row['left_id'] - $target['left_id'];
			$diff_down = $forum_row['right_id'] + 1 - $forum_row['left_id'];

			$move_up_left = $forum_row['left_id'];
			$move_up_right = $forum_row['right_id'];
		}
		else
		{
			$left_id = $forum_row['left_id'];
			$right_id = $target['right_id'];

			$diff_up = $forum_row['right_id'] + 1 - $forum_row['left_id'];
			$diff_down = $target['right_id'] - $forum_row['right_id'];

			$move_up_left = $forum_row['right_id'] + 1;
			$move_up_right = $target['right_id'];
		}

		// Now do the dirty job
		$sql = 'UPDATE ' . $db_prefix ."_forums
			SET left_id = left_id + CASE
				WHEN left_id BETWEEN {$move_up_left} AND {$move_up_right} THEN -{$diff_up}
				ELSE {$diff_down}
			END,
			right_id = right_id + CASE
				WHEN right_id BETWEEN {$move_up_left} AND {$move_up_right} THEN -{$diff_up}
				ELSE {$diff_down}
			END,
			forum_parents = ''
			WHERE
				left_id BETWEEN {$left_id} AND {$right_id}
				AND right_id BETWEEN {$left_id} AND {$right_id}";
		$db->sql_query($sql);

		return $target['forum_name'];
	}
	function get_forum_info($forum_id)
	{
		global $db,$db_prefix;

		$sql = 'SELECT *
			FROM ' . $db_prefix ."_forums 
			WHERE forum_id = $forum_id";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$row)
		{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'         => false,
								        'MESSAGE_TITLE'     	=> '',
                                        'MESSAGE_TEXT'          => $user->lang['NO_FORUM'],
                                ));
						echo $template->fetch('admin/message_body.html');
						close_out();
		}

		return $row;
	}
function get_groups()
{
        global $db, $db_prefix;
            $sql = "SELECT level as level, name as name FROM ".$db_prefix."_levels;";
            $res = $db->sql_query($sql) or btsqlerror($sql);
            return $res;
}
	$template->assign_vars(array(
		'ICON_MOVE_UP'				=> '<img src="themes/' . $theme.'/pics/admin/icon_up.gif" alt="' . $user->lang['MOVE_UP'] . '" title="' . $user->lang['MOVE_UP'] . '" />',
		'ICON_MOVE_UP_DISABLED'		=> '<img src="themes/' . $theme.'/pics/admin/icon_up_disabled.gif" alt="' . $user->lang['MOVE_UP'] . '" title="' . $user->lang['MOVE_UP'] . '" />',
		'ICON_MOVE_DOWN'			=> '<img src="themes/' . $theme.'/pics/admin/icon_down.gif" alt="' . $user->lang['MOVE_DOWN'] . '" title="' . $user->lang['MOVE_DOWN'] . '" />',
		'ICON_MOVE_DOWN_DISABLED'	=> '<img src="themes/' . $theme.'/pics/admin/icon_down_disabled.gif" alt="' . $user->lang['MOVE_DOWN'] . '" title="' . $user->lang['MOVE_DOWN'] . '" />',
		'ICON_EDIT'					=> '<img src="themes/' . $theme.'/pics/admin/icon_edit.gif" alt="' . $user->lang['EDIT'] . '" title="' . $user->lang['EDIT'] . '" />',
		'ICON_EDIT_DISABLED'		=> '<img src="themes/' . $theme.'/pics/admin/icon_edit_disabled.gif" alt="' . $user->lang['EDIT'] . '" title="' . $user->lang['EDIT'] . '" />',
		'ICON_DELETE'				=> '<img src="themes/' . $theme.'/pics/admin/icon_delete.gif" alt="' . $user->lang['DELETE'] . '" title="' . $user->lang['DELETE'] . '" />',
		'ICON_DELETE_DISABLED'		=> '<img src="themes/' . $theme.'/pics/admin/icon_delete_disabled.gif" alt="' . $user->lang['DELETE'] . '" title="' . $user->lang['DELETE'] . '" />',
		'ICON_SYNC'					=> '<img src="themes/' . $theme.'/pics/admin/icon_sync.gif" alt="' . $user->lang['RESYNC'] . '" title="' . $user->lang['RESYNC'] . '" />',
		'ICON_SYNC_DISABLED'		=> '<img src="themes/' . $theme.'/pics/admin/icon_sync_disabled.gif" alt="' . $user->lang['RESYNC'] . '" title="' . $user->lang['RESYNC'] . '" />',
	));
$icat	= request_var('icat', '');
		if (!$parent_id)
		{
			$navigation = $user->lang['FORUM_INDEX'];
		}
		else
		{
			$navigation = '<a href="' . $u_action . '">' . $user->lang['FORUM_INDEX'] . '</a>';

			$forums_nav = get_forum_branch($parent_id, 'parents', 'descending');
			//print_r($forums_nav);
			foreach ($forums_nav as $row)
			{
				if ($row['forum_id'] == $parent_id)
				{
					$navigation .= ' -&gt; ' . $row['forum_name'];
				}
				else
				{
					$navigation .= ' -&gt; <a href="' . $u_action . '&amp;parent_id=' . $row['forum_id'] . '">' . $row['forum_name'] . '</a>';
				}
			}
		}
		$forum_box = make_forum_select($parent_id, false, false, false, false);

		if ($action == 'sync' || $action == 'sync_forum')
		{
			$template->assign_var('S_RESYNCED', true);
		}
		$sql = 'SELECT *
			FROM ' . $db_prefix ."_forums
			WHERE parent_id = $parent_id
			ORDER BY left_id";
		$result = $db->sql_query($sql);
		if ($row = $db->sql_fetchrow($result))
		{
			$template->assign_vars(array(
				'S_FORUMS'		=> true,
				));
			do
			{
				$forum_type = $row['forum_type'];

				if ($row['show_topic'] == 1)
				{
					$folder_image = '<img src="themes/' . $theme.'/forums/topic_read_locked.png" alt="' . $user->lang['LOCKED'] . '" />';
				}
				else
				{
					switch ($forum_type)
					{
						case 3:
							$folder_image = '<img src="themes/' . $theme.'/forums/icon_folder_link.png" alt="' . $user->lang['LINK'] . '" />';
						break;

						default:
							$folder_image = ($row['left_id'] + 1 != $row['right_id']) ? '<img src="themes/' . $theme.'/forums/topic_read.png" alt="' . $user->lang['SUBFORUM'] . '" />' : '<img src="themes/' . $theme.'/forums/topic_read.png" alt="' . $user->lang['FOLDER'] . '" />';
						break;
					}
				}

				$url = $u_action . "&amp;parent_id=$parent_id&amp;f={$row['forum_id']}";
				$template->assign_block_vars('forums', array(
					'FOLDER_IMAGE'		=> $folder_image,
					'FORUM_IMAGE'		=> ($row['forum_image']) ? '<img src="' . $phpbb_root_path . $row['forum_image'] . '" alt="" />' : '',
					'FORUM_IMAGE_SRC'	=> ($row['forum_image']) ? $phpbb_root_path . $row['forum_image'] : '',
					'FORUM_NAME'		=> $row['forum_name'],
					'FORUM_DESCRIPTION'	=> generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
					'FORUM_TOPICS'		=> $row['forum_topics'],
					'FORUM_POSTS'		=> $row['forum_posts'],

					'S_FORUM_LINK'		=> ($forum_type == 2) ? true : false,
					'S_FORUM_POST'		=> ($forum_type == 1) ? true : false,

					'U_FORUM'			=> $u_action . '&amp;parent_id=' . $row['forum_id'],
					'U_MOVE_UP'			=> $url . '&amp;action=move_up',
					'U_MOVE_DOWN'		=> $url . '&amp;action=move_down',
					'U_EDIT'			=> $url . '&amp;action=edit',
					'U_DELETE'			=> $url . '&amp;action=delete',
					'U_SYNC'			=> $url . '&amp;action=sync')
				);
			}
			while ($row = $db->sql_fetchrow($result));
		}
		else if ($parent_id)
		{
			$row = get_forum_info($parent_id);

			$url = $u_action . '&amp;parent_id=' . $parent_id . '&amp;f=' . $row['forum_id'];

			$template->assign_vars(array(
				'S_NO_FORUMS'		=> true,

				'U_EDIT'			=> $url . '&amp;action=edit',
				'U_DELETE'			=> $url . '&amp;action=delete',
				'U_SYNC'			=> $url . '&amp;action=sync')
			);
		}
		$db->sql_freeresult($result);
		//echo $navigation;
		$template->assign_vars(array(
			'ERROR_MSG'		=> (sizeof($errors)) ? implode('<br />', $errors) : '',
			'NAVIGATION'	=> $navigation,
			'FORUM_BOX'		=> $forum_box,
			'U_SEL_ACTION'	=> $u_action,
			'U_ACTION'		=> $u_action . '&amp;parent_id=' . $parent_id,

			'U_PROGRESS_BAR'	=> $u_action . '&amp;action=progress_bar',
			'UA_PROGRESS_BAR'	=> addslashes($u_action . '&amp;action=progress_bar'),
		));

echo $template->fetch('admin/acp_forum.html');
		close_out();
?> 