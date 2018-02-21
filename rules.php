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
** File rules.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
$template = new Template();
set_site_var($user->lang['RULES']);
$template->assign_vars(array(
'S_RULES' => true,
'S_EDIT' => ($user->admin) ? true : false,
));
$sql_rule = "select * from ".$db_prefix."_rules order by level;";
$res = $db->sql_query($sql_rule);
	include_once('include/function_posting.' . $phpEx);
	include_once('include/class.bbcode.php');
	
	while ($arr = $db->sql_fetchrow($res)){
	$bbcode = false;
	$descript = censor_text($arr["text"]);
	// Instantiate BBCode if need be
	if ($arr['bbcode_bitfield'])
	{
		include_once('include/bbcode.' . $phpEx);
		$bbcode = new bbcode($arr['bbcode_bitfield']);
		$bbcode->bbcode_second_pass($descript, $arr['bbcode_uid'], $arr['bbcode_bitfield']);
	}
	// Parse the message and subject
	$descript = bbcode_nl2br($descript);
	$descript = parse_smiles($descript);
		if ($arr["public"]=="yes")
			{
				$template->assign_block_vars('rules_var',array(
				'ID' => $arr["id"],
				'TITLE' => $arr["title"],
				'RULE' => $descript,
				));
			}
	    elseif(in_array('[' . $user->group . ']',explode(',',$arr["level"])))
			{
				$template->assign_block_vars('rules_var',array(
				'ID' => $arr["id"],
				'TITLE' => $arr["title"],
				'RULE' => $descript,
				));
			}
	}
$db->sql_freeresult($res);
echo $template->fetch('rules_body.html');
close_out();
?>