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
* @version $Id: 3.0.0 blackjack.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
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