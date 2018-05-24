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
** File acp_cache.php 2018-02-17 14:32:00 Black_Heart
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
if(!$auth->acl_get('a_cache_settings'))
{
	$user->set_lang('common',$user->ulanguage);
	$template->assign_vars(array(
		'S_USER_NOTICE'			=> false,
		'S_FORWARD'				=> false,
		'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
		'MESSAGE_TEXT'			=> $user->lang['GROUP_NO_ACCESS_PAGE'],
	));
	echo $template->fetch('admin/message_body.html');
	close_out();
}
$user->set_lang('admin/acp_cache',$user->ulanguage);
$cfgquery = "SELECT * FROM ".$db_prefix."_cache_con;";
$cfgrow = array();
$result = $db->sql_query($cfgquery);
			while ($row_attach = $db->sql_fetchrow($result))
			{
				$cfgrow[$row_attach['name']] = $row_attach['value'];
			}
$db->sql_freeresult($cfgres);
		$do					= request_var('do', '');
function is__writable($path) 
{
	if ($path{strlen($path)-1}=='/') return is__writable($path.uniqid(mt_rand()).'.tmp');

	if (file_exists($path)) {
		if (!($f = @fopen($path, 'r+'))) return false;
		fclose($f);
		return true;
	}


	if (!($f = @fopen($path, 'w')))	return false;
	fclose($f);
	unlink($path);
	return true;
}
if ($do == "take_config") {
		$sub_sql_time									= request_var('sub_sql_time',$cfgrow['sql_time']);
		$sub_theme_time									= request_var('sub_theme_time', $cfgrow['theme_time']);
		$sub_cache_dir									= request_var('sub_cache_dir', $cfgrow['cache_dir']);
        $params = array();
        $values = array();
        $errors = array();
		if (!is_numeric($sub_sql_time))$errors[] = sprintf($user->lang["ERR_SQL_TIME"],$sub_sql_time);
		if (!is_numeric($sub_theme_time))$errors[] = sprintf($user->lang["ERR_THEME_TIME"],$sub_theme_time);
        if (!isset($sub_cache_dir) OR $sub_cache_dir == "")$errors[] = sprintf($user->lang["ERR_CACHE_DIR_NOTSET"],$sub_cache_dir);
		if (!is__writable($sub_cache_dir.'/'))$errors[] = sprintf($user->lang["ERR_CACHE_DIR_NOT_WRITEABLE"],$sub_cache_dir);
        if (count($errors) > 0)
		{
			$report = '<ul>';
					foreach ($errors as $msg) {
							$report .= sprintf($user->lang['ERR_ARRAY_MESS'], $msg);
					}
			$report .= '</ul>';
									$template->assign_vars(array(
											'S_USER_NOTICE'					=> false,
											'S_FORWARD'						=> false,
											'MESSAGE_TITLE'					=> $user->lang['SETTINGS_NOT_SAVED'],
											'MESSAGE_TEXT'					=> $report.back_link($u_action),
									));
			echo $template->fetch('admin/message_body.html');
			close_out();
		}
			$sql_ary = array(
							array(
								'name'=>'sql_time',
								'value'=>$sub_sql_time
								),
							array(
								'name'=>'theme_time',
								'value'=>$sub_theme_time
								),
							array(
								'name'=>'cache_dir',
								'value'=>$sub_cache_dir
								)
							);
						$db->multi_insert = true;
		if (!$db->sql_multi_insert($db_prefix."_cache_con", $sql_ary)) btsqlerror($db->sql_build_array('INSERT', $sql_ary[0]));
		$db->sql_query("TRUNCATE TABLE ".$db_prefix."_cache_con;");
		$db->sql_multi_insert($db_prefix."_cache_con", $sql_ary);
		$pmbt_cache->remove_file("sql_".md5('cache').".php");
		$pmbt_cache->set_sql("cache", $sql_ary);
				add_log('admin','LOG_CACHE_SETTING_UPDATE');
                                $template->assign_vars(array(
								        'S_USER_NOTICE'					=> true,
										'S_FORWARD'					=> $u_action,
								        'MESSAGE_TITLE'				=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'				=> $user->lang['SETTING_SAVED'].back_link($u_action),
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
}
						$hidden = build_hidden_fields(array(
							'do'		=> 'take_config',
						));
$template->assign_vars(array(
        'L_TITLE'            		=> $user->lang["TITLE"],
        'L_TITLE_EXPLAIN'           => $user->lang["TITLE_EXP"],
		'U_ACTION'					=> $u_action,
		'HIDDEN'					=> $hidden,
));
drawRow(true,false, false ,$user->lang['CACHE']);
if($auth->acl_get('a_cache_time_sql'))drawRow("sql_time","text");
if($auth->acl_get('a_cache_time_tmpl'))drawRow("theme_time","text");
if($auth->acl_get('a_cache_dir'))drawRow("cache_dir","text");
echo $template->fetch('admin/acp_cache.html');
		close_out();
?>