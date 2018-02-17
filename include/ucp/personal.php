<?php
/*
*-----------------------------phpMyBitTorrent V 3.0.0--------------------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: personal.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
        $languages = Array();
        $langdir = "language/common";
        $langhandle = opendir($langdir);
        while ($langfile = readdir($langhandle)) {
                if (preg_match("/\.php$/",$langfile) AND strtolower($langfile) != "mailtexts.php")
                        $languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
        }
        closedir($langhandle);
        unset($langdir,$langfile);
		$custlang = '';
foreach ($languages as $key=>$val) {
        $custlang .="<option ";
        if ($userrow["language"] == $key) $custlang .="selected";
        $custlang .=" value=\"".$key."\">".$val."</option>\n";
}
unset($languages);
        $themes = Array();
        $thememaindir = "themes";
        $themehandle = opendir($thememaindir);
        while ($themedir = readdir($themehandle)) {
                if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
                        $themes[$themedir] = $themedir;
        }
        closedir($themehandle);
        unset($thememaindir,$themedir);
		$custtheme = '';
foreach ($themes as $key=>$val) {
        $custtheme .="<option ";
        if ($userrow["theme"] == $key) $custtheme .="selected";
        $custtheme .=" value=\"".$key."\">".$val."</option>\n";
}
unset($themes);
$off_set ='';
$sql = ("SELECT id,name from ".$db_prefix."_time_offset ORDER BY name");
$tz_r = $db->sql_query($sql);
while ($tz_a = $db->sql_fetchrow($tz_r))
  $off_set .= "<option value=$tz_a[id]" . ($userrow["tzoffset"] == $tz_a['id'] ? " selected" : "") . ">$tz_a[name]</option>\n";
$hidden = array(
			'op'		=> 'editprofile',
			'action'	=> 'preferences',
			'mode'		=> 'personal',
			'take_edit'	=> '1'
			);
			//die($userrow["pm_popup"]);
$template->assign_vars(array(
		'S_HIDDEN_FIELDS'		=> build_hidden_fields($hidden),
		'CP_TORPERPAGE'			=> $userrow["torrent_per_page"],
		'CP_SHOW_ONLINE'		=> ($userrow["Show_online"] == 'true')? true : false,
		'CP_PM_POPUP'			=> ($userrow["pm_popup"] == 'true')? true : false,
		'CP_ALLOW_PM'			=> ($userrow["user_allow_pm"] == '1')? true : false,
		'CP_ALLOW_MASS_MAIL'	=> ($userrow["mass_mail"] == 'yes')? true : false,
		'CP_PM_NOTIVY'			=> ($userrow["pm_notify"] == 'true')? true : false,
		'U_ALLOW_EMAIL'			=> ($userrow["accept_mail"] == 'yes')? true : false,
		'CP_PASSKEY'			=> $userrow["passkey"],
		'TX_OFF_SET'			=> tz_select('',$userrow),
		'U_COUNTRY'				=> cnt_select("" , $userrow ),
		'U_THEMES'				=> $custtheme,
		'U_LANGUAGES'			=> $custlang,
));
?>