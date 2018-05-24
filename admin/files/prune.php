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
** File prune.php 2018-02-23 14:32:00 Black_Heart
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
$user->set_lang('admin/acp_prune',$user->ulanguage);
if(!checkaccess('a_prune'))
{
				add_log('admin','LOG_ACL_ACCESS_NOTALLOW',$user->lang['USERPRUNE_HEADER']);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'			=> true,
										'S_FORWARD'				=> false,
								        'MESSAGE_TITLE'			=> $user->lang['GEN_ERROR'],
                                        'MESSAGE_TEXT'			=> sprintf($user->lang['DENIACC'],$user->lang['USERPRUNE_HEADER']),
                                ));
				echo $template->fetch('admin/message_body.html');
				close_out();
}
$cfgquery = "SELECT * FROM ".$db_prefix."_userautodel;";
$cfgres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);
		$do					= request_var('do', '');
if ($do == 'take_config'){
		$error = array();
		$sub_autodel_users									= request_var('sub_autodel_users', 'false');
		$sub_inactwarning_time								= request_var('sub_inactwarning_time', '0');
		$sub_autodel_users_time								= request_var('sub_autodel_users_time', '0');
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();
        if (!isset($sub_autodel_users) OR $sub_autodel_users != "true") $sub_autodel_users = "false"; array_push($params,"autodel_users"); array_push($values,$sub_autodel_users);
        if (is_numeric($sub_inactwarning_time)) { array_push($params,"inactwarning_time"); array_push($values,$sub_inactwarning_time); }
        if (is_numeric($sub_autodel_users_time)) { array_push($params,"autodel_users_time"); array_push($values,$sub_autodel_users_time); }
        $sql = "INSERT INTO ".$db_prefix."_userautodel (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_userautodel;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("userautodel").".php");
				add_log('admin','LOG_PRUNE_SETTING_UPDATE');
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
drawRow(true,false, false ,$user->lang['USERPRUNE_HEADER']);
drawRow("autodel_users","checkbox");
drawRow("inactwarning_time","text");
drawRow("autodel_users_time","text");
echo $template->fetch('admin/acp_prune.html');
		close_out();
?>