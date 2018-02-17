<?php
/*
*-----------------------------phpMyBitTorrent V 2.0.5--------------------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: edit_bookmarks.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
$t                                     = request_var('t', array(0));
$hid = '';
if(isset($t) && count($t) >=1){
foreach($t as $key => $value)
$hid .= "<input type=\"hidden\" name=\"t[".$key."]\" value=\"1\" />";
}
$hidden='<input type="hidden" name="take_edit" value="1" >
<input type="hidden" name="check" value="1" >
<input type="hidden" name="action" value="overview" >
<input type="hidden" name="op" value="editprofile" >
<input type="hidden" name="mode" value="bookmarks" />'.
$hid;
if(isset($check))$check=true;
else
$check = false;
			if(!confirm_box($check, 'bt_fm_del_bookm', $hidden,'confirm_body.html','?overview&mode=bookmarks')){
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
              $template->assign_var('S_IN_UCP', true);
			}
$t                                     = request_var('t', array(0));
    if(!isset($t) && !count($t) >=1)bterror("Delete BookMark","No Topic is set please check your link");
	foreach($t as $book=> $value){
		$db->sql_query("DELETE FROM ".$db_prefix."_bookmarks WHERE topic_id='".$book."' AND user_id='".$user->id."'");
     }

?>