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
** File index.php 2018-02-17 14:32:00 Black_Heart
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
//die(mysqli_get_client_info());
require_once("common.php");
$template = new Template();
set_site_var($user->lang['INDEX']);
$birthday_list = '';
$now = getdate(time() - date('Z'));
$sql = "SELECT * FROM ".$db_prefix."_users WHERE ban = '0' AND birthday LIKE '" . $now['mday']."-". $now['mon']."-" . "%'";
	$result = $db->sql_query($sql) or btsqlerror($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		if($row["donator"] == 'true')$donator = true;
		else
		$donator = false;
$img = '';
                if ($row["level"] == "premium") $img .= pic("icon_premium.gif",'','premium');
                elseif ($row["level"] == "moderator") $img .= pic("icon_moderator.gif",'','moderator');
                elseif ($row["level"] == "admin") $img .= pic("icon_admin.gif",'','admin');
				if($donator) $img .= '<img src="images/donator.gif" height="16" width="16" title="donator" alt="donator" />';
		        if($row["warned"] == "1") $img .= '<img src="images/warning.gif" title="warned" alt="warned" />';
		
		$name = ($row['name'] == '' ? $row['username'] : $row['name']);
		$birthday_list .= (($birthday_list != '') ? ', ' : '') ."<a href=\"user.php?op=profile&amp;id=".$row["id"]."\"><font color=\"".getusercolor($row["can_do"])."\">{$name}</font></a>{$img}";
		if ($age = (int) substr($row['birthday'], -4))
		{		
			$birthday_list .= ' (' . ($now['year'] - $age) . ')';
		}
    }
	$db->sql_freeresult($result);
	if($birthday_list!= '')
$birthday_list = $user->lang['HAPPY_BIRTHDAY'].$birthday_list;
else 
$birthday_list = $user->lang['NO_BIRTHDAY'];
$template->assign_vars(array(
        'BIRTHDAY_LIST'            => $birthday_list,
));

echo $template->fetch('index_body.html');
close_out();
?>