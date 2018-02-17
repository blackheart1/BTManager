<?php
/*
*-----------------------------phpMyBitTorrent V 3.0.0--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2011 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*
* @package phpMyBitTorrent
* @version $Id: index.php 1 2011-07-05 00:22:48Z joeroberts $
* @copyright (c) 2011 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
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
set_site_var('Index');
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