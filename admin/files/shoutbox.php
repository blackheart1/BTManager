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
*------              �2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 shoutbox.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$cfgquery = "SELECT * FROM ".$db_prefix."_shout_config;";
$cfgres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cfgres);
$db->sql_freeresult($cfgres);
$user->set_lang('admin/shout_box',$user->ulanguage);
		$do						= request_var('do', '');
if ($do == "saveshout") {
		$sub_announce_ment						= request_var('sub_announce_ment', '',true);
		$sub_shoutnewuser						= request_var('sub_shoutnewuser', '');
		$sub_shout_new_torrent					= request_var('sub_shout_new_torrent', '');
		$sub_shout_new_porn						= request_var('sub_shout_new_porn', '');
		$sub_turn_on							= request_var('sub_turn_on', '');
		$sub_refresh_time						= request_var('sub_refresh_time', '');
		$sub_shouts_to_show						= request_var('sub_shouts_to_show', '');
		$sub_bbcode_on							= request_var('sub_bbcode_on', '');
		$sub_allow_url							= request_var('sub_allow_url', '');
		$sub_autodelete_time					= request_var('sub_autodelete_time', '');
		$sub_canedit_on							= request_var('sub_canedit_on', '');
		$sub_candelete_on						= request_var('sub_candelete_on', '');
        //First I create the two SQL arrays
        $params = Array();
        $values = Array();
        array_push($params,"announce_ment"); array_push($values,esc_magic($sub_announce_ment));
        array_push($params,"shoutnewuser"); array_push($values,$sub_shoutnewuser);
        array_push($params,"shout_new_torrent"); array_push($values,$sub_shout_new_torrent);
        array_push($params,"shout_new_porn"); array_push($values,$sub_shout_new_porn);
        array_push($params,"turn_on"); array_push($values,$sub_turn_on);
        array_push($params,"refresh_time"); array_push($values,intval($sub_refresh_time));
        array_push($params,"idle_time"); array_push($values,intval($sub_idle_time));
        array_push($params,"shouts_to_show"); array_push($values,intval($sub_shouts_to_show));
        if ($sub_bbcode_on != "yes") $sub_bbcode_on = "no"; array_push($params,"bbcode_on"); array_push($values,$sub_bbcode_on);
        if ($sub_allow_url != "yes") $sub_allow_url = "no"; array_push($params,"allow_url"); array_push($values,$sub_allow_url);
        array_push($params,"autodelete_time"); array_push($values,intval($sub_autodelete_time));
        if ($sub_canedit_on != "yes") $sub_canedit_on = "no"; array_push($params,"canedit_on"); array_push($values,$sub_canedit_on);
        if ($sub_candelete_on != "yes") $sub_candelete_on = "no"; array_push($params,"candelete_on"); array_push($values,$sub_candelete_on);

        //Now I save the settings
        //but first I test the insertion against SQL errors, or I lose everything in case of error
        $sql = "INSERT INTO ".$db_prefix."_shout_config (".implode(", ",$params).") VALUES ('".implode("', '",$values)."');";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query("TRUNCATE TABLE ".$db_prefix."_shout_config;");
        $db->sql_query($sql);
		$pmbt_cache->remove_file("sql_".md5("shout").".php");

        //Finally, I redirect the user to configuration page
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=shoutbox",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['_admsaved'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}

$template->assign_vars(array(
        'L_TITLE'            		=> $user->lang["SHOUT_CONF"],
        'L_TITLE_EXPLAIN'           => $user->lang["SHOUT_CONF_EXP"],
		'U_ACTION'					=> "./admin.php?i=siteinfo&op=shoutbox&do=saveshout",
));

drawRow("announce_ment","text", false , $user->lang["BT_SHOUT"]);
drawRow("announce_ment","text", $user->lang["BT_SHOUT_ANNOUNCEMENT"]);
drawRow("shoutnewuser","select",$user->lang["YES_NO"]);
drawRow("shout_new_torrent","select",$user->lang["YES_NO"]);
drawRow("shout_new_porn","select",$user->lang["YES_NO"]);
drawRow("turn_on","select",$user->lang["YES_NO"]);
drawRow("refresh_time","text");
drawRow("idle_time","text");
drawRow("shouts_to_show","text");
drawRow("bbcode_on","select",$user->lang["YES_NO"]);
drawRow("allow_url","select",$user->lang["YES_NO"]);
drawRow("autodelete_time","text");
drawRow("canedit_on","select",$user->lang["YES_NO"]);
drawRow("candelete_on","select",$user->lang["YES_NO"]);
echo $template->fetch('admin/shout_box.html');
		close_out();
?>