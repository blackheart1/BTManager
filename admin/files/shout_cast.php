<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 shout_cast.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/shout_cast',$user->ulanguage);
if(isset($do) && $do == "save")
{
	$errors = array();
	$sqlfields = array();
	$sqlvalues = array();
	$allow				= request_var('sub_allow', '');
	if($allow != ""){
		$sqlfields[] = (($allow == 'false')? "false" : "true");
		$sqlvalues[] = "allow";
	}
	else
		$errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"],$user->lang["_admpallow"],$allow);
	$ip					= request_var('sub_ip', '');
	if($ip != ""){
		$sqlfields[] = $ip;
		$sqlvalues[] = "ip";
	}
	elseif($allow != false)
		$errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"],$user->lang["_admpip"],$ip);
	$port					= request_var('sub_port', '0');
	if($port != ""){
		$sqlfields[] = $port;
		$sqlvalues[] = "port";
	}
	elseif($allow != false)
		$errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"],$user->lang["_admpport"],$port);
	$admin_name			= request_var('sub_admin_name', '');
	if($admin_name != ""){
		$sqlfields[] = $admin_name;
		$sqlvalues[] = "admin_name";
	}
	elseif($allow != false)
		$errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"],$user->lang["_admpadmin_name"],$admin_name);
	$admin_pass			= request_var('sub_admin_pass', '');
	if($admin_pass != ""){
		$sqlfields[] = $admin_pass;
		$sqlvalues[] = "admin_pass";
	}
	elseif($allow != false)
		$errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"],$user->lang["_admpadmin_pass"],$admin_pass);
	$host_dj				= request_var('sub_host_dj', '');
	if($host_dj != ""){
		$sqlfields[] = $host_dj;
		$sqlvalues[] = "host_dj";
	}
	elseif($allow != false)
		$errors[] = sprintf($user->lang["ERR_NOT_NUMERIC"],$user->lang["_admphost_dj"],$host_dj);

        $sql = "INSERT INTO ".$db_prefix."_shout_cast (".implode(", ",$sqlvalues).") VALUES ('".implode("', '",$sqlfields)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_shout_cast;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("shout_cast").".php");
				logerror($user->lang['LOG_CONFIG_AVATAR'],'admin');
                                $template->assign_vars(array(
								        'S_USER_NOTICE'					=> true,
										'S_FORWARD'						=> $u_action,
								        'MESSAGE_TITLE'					=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'					=> sprintf($user->lang['SITTINGS_SAVED'],$user->lang['AVATAR_SETTINGS']).back_link($u_action),
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
}
		$sql = "SELECT * FROM `".$db_prefix."_shout_cast`";
		$res = $db->sql_query($sql);
		$cfgrow = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
	$hidden = build_hidden_fields(array(
	'do'	=> 'save',
	));
		$template->assign_vars(array(
				'S_FORM_TOKEN'		=> $hidden,
		        'L_TITLE'            		=> $user->lang['TITLE'],
		        'L_TITLE_EXPLAIN'           => $user->lang['TITLE_EXPLAIN'],
				'U_ACTION'					=> "./admin.php?i=&op=shout_cast",
				'SETTINGS'					=> true,
		));
	drawRow("allow","text", false ,$user->lang['HEADER_SETTINGS']);
	drawRow("allow","checkbox");
	drawRow("ip","text");
	drawRow("port","text");
	drawRow("admin_name","text");
	drawRow("admin_pass","text");
	drawRow("host_dj","text");
echo $template->fetch('admin/acp_shout_cast.html');
?>