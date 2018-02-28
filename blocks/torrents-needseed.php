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
** File torrents_needseed.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
global $db_prefix, $user, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache;
$sql = ("SELECT id, name, downloaded, completed, seeders, leechers, added FROM ".$db_prefix."_torrents WHERE leechers > 0 AND seeders = 0 ORDER BY leechers DESC LIMIT 10");
$res = $db->sql_query($sql) or btsqlerror($sql);
$need_seed = array();
if ($db->sql_numrows($res) > 0)
	{
	$template->assign_vars(array(
	'IS_NEED_SEEDS' => true,
	));
	$i=0;
		while ($arr = $db->sql_fetchrow($res))
			{
			$torrname = htmlspecialchars($arr['name']);
			$torrname = str_replace(array('-','_'),array(' ',' '),$torrname);
				if (strlen($torrname) > 55)
				$torrname = substr($torrname, 0, 55) . "...";
$need_seed[] = array_push($need_seed,array(
'SEED_NAME_SHORT' => $torrname,
'SEED_ID' => $arr['id'],
'SEED_NAME' => htmlspecialchars(stripslashes($arr['name'])),
'SEED_LEECH' => number_format($arr['leechers']),
'SEED_DOWN' => number_format($arr['downloaded']),
'SEED_ADDED' => $arr['added'],
'SEED_COMPL' => number_format($arr['completed'])));
}
$i++;
}
else
{
	$template->assign_vars(array(
	'IS_NEED_SEEDS' => false
	));
}
foreach($need_seed as $val){
if(is_array($val))$template->assign_block_vars('need_seeded',$val);
}
echo $template->fetch('need_seeders.html');				
?>