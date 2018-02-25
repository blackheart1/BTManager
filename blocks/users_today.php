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
** File users_today.php 2018-02-18 14:32:00 joeroberts
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
global $db_prefix, $user, $db, $pmbt_cache,$template;
if(!$pmbt_cache->get_sql("today_online")){
		unset($rowsets);
		$rowsets = array();
        $sql = "SELECT U.id as id, IF(U.name IS NULL, U.username, U.name) as name, U.donator as donator, U.warned as warned, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(lastlogin)) as def, U.can_do as can_do, U.level as level, UNIX_TIMESTAMP(U.lastlogin) as lastlogin, L.group_colour as color
			FROM ".$db_prefix."_users U , ".$db_prefix."_level_settings L 
		WHERE U.active = 1 
		AND UNIX_TIMESTAMP(U.lastlogin) > UNIX_TIMESTAMP(NOW()) - 86400 
		AND L.group_id = U.can_do
		ORDER BY username  ASC;";
        $res = $db->sql_query($sql);
	while ($rowset = $db->sql_fetchrow($res) ) {
        $rowsets[] = $rowset;
    }
        $db->sql_freeresult($res);
$pmbt_cache->set_sql("today_online", $rowsets);
}else{
$rowsets = $pmbt_cache->get_sql("today_online");
}
if (sizeof($rowsets)){
        foreach ($rowsets  as $id=>$row) {
   			$template->assign_block_vars('user_today', array(
			"USERNAME"          => htmlspecialchars($row["name"]),
			"DONER"             => ($row["donator"] == 'true') ? true : false,
			"WARNED"            => ($row["warned"] == '1') ? true : false,
			"ID"                =>  $row['id'],
			"COLOR"             => $row["color"],
			"LEVEL_ICON"        => ($row["level"] == "admin") ? pic("icon_admin.gif",'','admin') : (($row["level"] == "moderator") ? pic("icon_moderator.gif",'','moderator') : (($row["level"] == "premium") ?  pic("icon_premium.gif",'','premium') : '')),
			'LAST_CLICK'        =>  get_formatted_timediff($row["lastlogin"])
  		 ));
		}
}
echo $template->fetch('users_today.html');				
?>