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
** File HNR.php 2018-02-23 14:32:00 Black_Heart
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
$user->set_lang('admin/acp_hnr_system',$user->ulanguage);
$cfgquery = "SELECT * FROM " . $db_prefix . "_hit_n_run;";
$cgfres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cgfres);
$db->sql_freeresult($cfgres);
		$do					= request_var('do', '');
if ($do == "take_config") {
        //First I create the two SQL arrays and one error
        $params = array();
        $values = array();
        $errors = array();
		$sub_hnr_system									= request_var('sub_hnr_system', 'false');
		if(!in_array($sub_hnr_system,array('true', 'false'))) $errors[] = sprintf($user->lang["ERR_ON"],$sub_hnr_system);
		$sub_ban_hnr_users								= request_var('sub_ban_hnr_users', 'false');
		if(!in_array($sub_ban_hnr_users,array('true', 'false'))) $errors[] = sprintf($user->lang["ERR_BAN_HNR"],$sub_ban_hnr_users);
		$sub_demote_hnr_users							= request_var('sub_demote_hnr_users', 'false');
		if(!in_array($sub_demote_hnr_users,array('true', 'false'))) $errors[] = sprintf($user->lang["ERR_DEMOTE"],$sub_demote_hnr_users);
		$sub_demote_hnr_users_to						= request_var('sub_demote_hnr_users_to', 'user');
		$sql = 'SELECT level
			FROM ' . $db_prefix . "_levels
			WHERE name = '" . $db->sql_escape($sub_demote_hnr_users_to) . "'";
		$query = $db->sql_query($sql);
		if(!$db->sql_numrows($query) > 0)$errors[] = sprintf($user->lang["ERR_DEMOTE_LEVEL"],$sub_demote_hnr_users_to);
		$sub_seedtime									= request_var('sub_seedtime', '0');
		if (!is_numeric($sub_seedtime))$errors[] = sprintf($user->lang["ERR_SEED_TIME"],$sub_seedtime);
		$sub_time_before_warn							= request_var('sub_time_before_warn', '0');
		if (!is_numeric($sub_time_before_warn))$errors[] = sprintf($user->lang["ERR_TIME_PREWARN"],$sub_time_before_warn);
		$sub_maxhitrun									= request_var('sub_maxhitrun', '0');
		if (!is_numeric($sub_maxhitrun))$errors[] = sprintf($user->lang["ERR_MAX_HITS"],$sub_maxhitrun);
		$sub_warnlength									= request_var('sub_warnlength', '0');
		if (!is_numeric($sub_warnlength))$errors[] = sprintf($user->lang["ERR_WARN_LEN"],$sub_warnlength);
		$sub_after_high_hnr								= request_var('sub_after_high_hnr', '0');
		if (!is_numeric($sub_after_high_hnr))$errors[] = sprintf($user->lang["ERR_AFTER_HIGH"],$sub_after_high_hnr);
		$sub_ban_time									= request_var('sub_ban_time', '0');
		if (!is_numeric($sub_ban_time))$errors[] = sprintf($user->lang["ERR_DEMOTE_TIME"],$sub_ban_time);
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
        if (!isset($sub_hnr_system) OR $sub_hnr_system != "true") $sub_hnr_system = "false"; array_push($params,"hnr_system"); array_push($values,$sub_hnr_system);
        if (!isset($sub_ban_hnr_users) OR $sub_ban_hnr_users != "true") $sub_ban_hnr_users = "false"; array_push($params,"ban_hnr_users"); array_push($values,$sub_ban_hnr_users);
        if (!isset($sub_demote_hnr_users) OR $sub_demote_hnr_users != "true") $sub_demote_hnr_users = "false"; array_push($params,"demote_hnr_users"); array_push($values,$sub_demote_hnr_users);
        array_push($params,"demote_hnr_users_to"); array_push($values,$sub_demote_hnr_users_to);
        if (is_numeric($sub_seedtime)) { array_push($params,"seedtime"); array_push($values,$sub_seedtime); }
        if (is_numeric($sub_time_before_warn)) { array_push($params,"time_before_warn"); array_push($values,$sub_time_before_warn); }
        if (is_numeric($sub_maxhitrun)) { array_push($params,"maxhitrun"); array_push($values,$sub_maxhitrun); }
        if (is_numeric($sub_warnlength)) { array_push($params,"warnlength"); array_push($values,$sub_warnlength); }
        if (is_numeric($sub_after_high_hnr)) { array_push($params,"after_high_hnr"); array_push($values,$sub_after_high_hnr); }
        if (is_numeric($sub_ban_time)) { array_push($params,"ban_time"); array_push($values,$sub_ban_time); }
        $sql = "INSERT INTO ".$db_prefix."_hit_n_run (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_hit_n_run;");
        $db->sql_query($sql);

				add_log('admin','LOG_HNR_SETTING_UPDATE');
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
drawRow(true,false, false ,$user->lang['HNR_HEADER']);
drawRow("hnr_system","checkbox");
drawRow("seedtime","text");
drawRow("time_before_warn","text");
drawRow("maxhitrun","text");
drawRow("warnlength","text");
drawRow("ban_hnr_users","checkbox");
drawRow("demote_hnr_users","checkbox");
drawRow("demote_hnr_users_to","text");
drawRow("after_high_hnr","text");
drawRow("ban_time","text");
echo $template->fetch('admin/acp_prune.html');
		close_out();
?>