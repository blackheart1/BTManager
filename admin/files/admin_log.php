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
** File admin_log.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
include_once('include/user.functions.php');
$user->set_lang('admin/acp_logs',$user->ulanguage);
define('ADMIN_MODE',0);
define('MOD_MODE',1);
define('USERS_MODE',3);
define('CRITICAL_MODE',2);
		$deletemark = (!empty($_POST['delmarked'])) ? true : false;
		$deleteall	= (!empty($_POST['delall'])) ? true : false;
		$marked		= request_var('mark', array(0));
		$sort_days	= request_var('st', '0');
		$sort_key	= request_var('sk', 't');
		$sort_dir	= request_var('sd', 'd');
		$del		= request_var('del', '');
		$mode		= request_var('mode', 'admin');
		$u_action 	= './admin.php?i=siteinfo&amp;op=log&amp;mode=' . $mode;
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE'		=> $user->lang['ACP_LOGGING'],
							'S_SELECTED'	=> true,
							'U_TITLE'		=> '1',));
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('admin' ==$mode)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['ACP_ADMIN_LOGS'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=log&amp;mode=admin'),
								));
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('mod' ==$mode)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['ACP_MOD_LOGS'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=log&amp;mode=mod'),
								));
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('users' ==$mode)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['ACP_USERS_LOGS'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=log&amp;mode=users'),
								));
								$template->assign_block_vars('l_block1.l_block2.l_block3',array(
								'S_SELECTED'	=> ('critical' ==$mode)? true:false,
								'IMG' => '',
								'L_TITLE' => $user->lang['ACP_CRITICAL_LOGS'],
								'U_TITLE' => append_sid("{$siteurl}/admin.$phpEx", 'i=siteinfo&amp;op=log&amp;mode=critical'),
								));
if($deleteall && $auth->acl_get('a_clearlogs'))
{
		if (confirm_box(true))
		{
			$sql = "DELETE FROM ".$db_prefix."_log WHERE log_type = " . constant(strtoupper($mode) . '_MODE') . ";";
			$db->sql_query($sql);
					add_log('admin', 'LOG_CLEAR_' . strtoupper($mode));
                                $template->assign_vars(array(
								        'S_USER_NOTICE'				=> true,
										'S_FORWARD'					=> $u_action,
								        'MESSAGE_TITLE'          	=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'           	=> $user->lang['PRUNE_SUCCESS'],
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
		}
		else
		{
								$hidden = build_hidden_fields(array(
								"st"		=> $sort_days,
								"sk"		=> $sort_key,
								"sd" 		=> $sort_dir,
								"delall" 	=> $deleteall,
								"i"			=> 'siteinfo',
								'mode'		=> $mode,
								"op"		=> 'log',
								));
		confirm_box(false, $user->lang['CONFIRM_OPERATION'], $hidden,'admin/confirm_body.html','admin.php',true);
		}
}
if($delmarked && $auth->acl_get('a_clearlogs'))
{
		if (confirm_box(true))
		{
                        $sql = "DELETE FROM ".$db_prefix."_log WHERE event IN (".$del.");";
                        $db->sql_query($sql) or btsqlerror($sql);
					add_log('admin', 'LOG_CLEAR_' . strtoupper($mode));
                                $template->assign_vars(array(
								        'S_USER_NOTICE'            => true,
										'S_FORWARD'			=> $u_action,
								        'MESSAGE_TITLE'          => $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'            => $user->lang['PRUNE_SEL_SUCCESS'],
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
		}
		else
		{
		if(!$auth->acl_get('a_clearlogs')){
		$template->assign_vars(array(
	        'S_ERROR'            => true,
	        'TITTLE_M'           => $user->lang['BT_ERROR'],
	        'MESSAGE'            => $user->lang['AUTH_CLEAR_LOGS_FAIL'],
		));
		echo $template->fetch('message_body.html');
		close_out();
		}
						$marks = Array();
						foreach ($marked as $key=>$val) {
						$marks[]=$val;
						}
								$hidden = build_hidden_fields(array(
								"st"			=> $sort_days,
								"sk"		=> $sort_key,
								"sd" 		=> $sort_dir,
								"delmarked" 		=> $deletemark,
								"i"			=> 'siteinfo',
								"op"		=> 'log',
								"del"		=> implode(",",$marks),
								'mode'		=> $mode,
								));
		confirm_box(false, $user->lang['CONFIRM_OPERATION'], $hidden,'admin/confirm_body.html','admin.php');
		}
}
		$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text = array('u' => $user->lang['SORT_USERNAME'], 't' => $user->lang['SORT_DATE'], 'i' => $user->lang['SORT_IP'], 'o' => $user->lang['SORT_ACTION']);
		$sort_by_sql = array('u' => 'userid', 't' => 'datetime', 'i' => 'ip', 'o' => 'event');

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);


		$action		= request_var('action', '');
		$page		= request_var('page', 0);

		// Define where and sort sql for use in displaying logs
		$sql_where = ($sort_days > 0) ? (time() - ($sort_days * 86400)) : 0;
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		$keywords = utf8_normalize_nfc(request_var('keywords', '', true));
		$start = ($page >=1)?(($config['topics_per_page'] * $page) - $config['topics_per_page']) : 0;
		$startp = $start;
			// Define forum list if we're looking @ mod logs
		if ($mode == 'mod')
		{
			include_once('include/functions_forum.php');
			$forum_box = '<option value="0">' . $user->lang['ALL_FORUMS'] . '</option>' . make_forum_select($forum_id);
			
			$template->assign_vars(array(
				'S_SHOW_FORUMS'			=> true,
				'S_FORUM_BOX'			=> $forum_box)
			);
		}

	// Grab log data
		$log_data = array();
		$log_count = 0;
		$start = view_log($mode, $log_data, $log_count, $config['topics_per_page'], $start, $forum_id, 0, 0, $sql_where, $sql_sort, $keywords);
		$l_title = $user->lang['ACP_' . strtoupper($mode) . '_LOGS'];
		$l_title_explain = $user->lang['ACP_' . strtoupper($mode) . '_LOGS_EXPLAIN'];
		$template->assign_vars(array(
			'L_TITLE'		=> $l_title,
			'L_EXPLAIN'		=> $l_title_explain,
			'U_ACTION'		=> $u_action . "&amp;$keywords_param&amp;start=$start",
			
			'S_ON_PAGE'		=> on_page($log_count, $config['topics_per_page'], $startp),
			'PAGINATION'	=> generate_pagination($u_action . "&amp;$u_sort_param$keywords_param", $log_count, $config['topics_per_page'], $startp, true),
			
			'S_LIMIT_DAYS'	=> $s_limit_days,
			'S_SORT_KEY'	=> $s_sort_key,
			'S_SORT_DIR'	=> $s_sort_dir,
			'S_CLEARLOGS'	=> $auth->acl_get('a_clearlogs'),
			'S_KEYWORDS'	=> $keywords,
			'S_LOG_OPTIONS'	=> ($log_data) ? true : false,
			)
		);
		foreach ($log_data as $errors)
		{
		$data = array();
		$errors['ip_g'] = $errors["ip"];
			$data = array();
				
			$checks = array('viewtopic', 'viewlogs', 'viewforum');
			foreach ($checks as $check)
			{
				if (isset($errors[$check]) && $errors[$check])
				{
					$data[] = '<a href="' . $errors[$check] . '">' . $user->lang['LOGVIEW_' . strtoupper($check)] . '</a>';
				}
			}
			//echo $errors['time'];
			$template->assign_block_vars('log', array(
				'USERNAME'			=> $errors['username_full'],
				'USER_ID'			=>	$errors['user_id'],
				'REPORTEE_USERNAME'	=> ($errors['reportee_username'] && $errors['user_id'] != $errors['reportee_id']) ? $errors['reportee_username_full'] : '',
				'IP'				=> $errors["ip"],
				'DATE'				=> $user->format_date($errors['time']),
				'ACTION'			=> $errors['action'],
				'DATA'				=> (sizeof($data)) ? implode(' | ', $data) : '',
				'ID'				=> $errors['id'],
				)
			);
        } 
		$db->sql_freeresult($res);
echo $template->fetch('admin/log.html');
		close_out();
?>