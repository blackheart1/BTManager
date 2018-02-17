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
* @version $Id: 3.0.0 prune.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/acp_prune',$user->ulanguage);
if(!checkaccess('a_prune'))
{
				logerror(sprintf($user->lang['LOG_ACL_ACCESS_NOTALLOW'], $user->lang['USERPRUNE_HEADER']),'admin');
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
				logerror($user->lang['LOG_PRUNE_SETTING_UPDATE'],'admin');
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