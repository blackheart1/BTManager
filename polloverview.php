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
* @version $Id: 3.0.0 polloverview.php  2010-11-04 00:22:48 joeroberts $
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
require_once("include/torrent_functions.php");
$user->set_lang('polls',$user->ulanguage);
$template = new Template();
$op						= request_var('op', '');
$pollid					= request_var('id', '0');
set_site_var($user->lang['POLL_OVER_VIEW']);
if (!$pollid)
{
	 
	$sql = $db->sql_query("SELECT id, added, question FROM ".$db_prefix."_polls ORDER BY id DESC");
	while ($poll = $db->sql_fetchrow($sql))
	{
				$template->assign_block_vars('polls', array(
								'ID'				=>	$poll['id'],
								'ADDED'				=>	gmdate("Y-m-d h-i-s",strtotime($poll['added'])),
								'HOW_LONG_AGO'		=>	get_elapsed_time(sql_timestamp_to_unix_timestamp($poll["added"])),
								'QUESTION'			=>	$poll['question'],
							   ));
	}
}
else
{

	if($pollid)
	{
		$sql = $db->sql_query("SELECT * FROM ".$db_prefix."_polls WHERE id = {$pollid} ORDER BY id DESC") or sqlerr();
	
	
	
	//print("<h1>Polls Overview</h1>\n");
	
	//print("<p><table width=750 border=1 cellspacing=0 cellpadding=5><tr>\n" .
	//"<td class=colhead align=center>ID</td><td class=colhead>Added</td><td class=colhead>Question</td></tr>\n");
	
		while ($poll = $db->sql_fetchrow($sql))
		{
						$template->assign_block_vars('polls', array(
										'ADDED'				=>	gmdate("Y-m-d h-i-s",strtotime($poll['added'])),
										'HOW_LONG_AGO'		=>	get_elapsed_time(sql_timestamp_to_unix_timestamp($poll["added"])),
										'QUESTION'			=>	$poll['question'],
									   ));
										$template->assign_vars(array(
										'SHOW_POLL'			=>	true,
												'QUESTION'			=> $poll['question'],
												'OP_A'				=> (($poll["option0"] != '')? $poll["option0"] : FALSE),
												'OP_B'				=> (($poll["option1"] != '')? $poll["option1"] : FALSE),
												'OP_C'				=> (($poll["option2"] != '')? $poll["option2"] : FALSE),
												'OP_D'				=> (($poll["option3"] != '')? $poll["option3"] : FALSE),
												'OP_E'				=> (($poll["option4"] != '')? $poll["option4"] : FALSE),
												'OP_F'				=> (($poll["option5"] != '')? $poll["option5"] : FALSE),
												'OP_G'				=> (($poll["option6"] != '')? $poll["option6"] : FALSE),
												'OP_H'				=> (($poll["option7"] != '')? $poll["option7"] : FALSE),
												'OP_I'				=> (($poll["option8"] != '')? $poll["option8"] : FALSE),
												'OP_J'				=> (($poll["option9"] != '')? $poll["option9"] : FALSE),
										));
						$sqlb = "SELECT 
									P. * , 
									U.uploaded, 
									U.downloaded, 
									IF(U.name IS NULL, U.username, U.name) as user_name, 
									U.warned AS warned, 
									U.uploaded/U.downloaded as ratio, 
									U.aim AS aim, 
									U.country AS country, 
									U.icq AS icq, 
									U.msn AS msn, 
									U.yahoo AS yahoo, 
									U.skype AS skype, 
									U.jabber AS jabber, 
									U.accept_mail AS accept_mail, 
									U.ban as ban, 
									U.regdate AS regdate, 
									U.email AS email, 
									U.avatar AS avatar, 
									UNIX_TIMESTAMP(U.lastlogin) AS lststamp, 
									U.lastlogin AS lastlogin, 
									U.lastip AS lastip, 
									U.lasthost AS lasthost, 
									U.level as user_level, 
									U.can_do as can_do, 
									L.group_colour AS color, 
									L.group_name AS co_name, 
									C.name AS lname, 
									C.flagpic AS flagpic 
								FROM 
									".$db_prefix."_pollanswers P 
								LEFT JOIN 
									".$db_prefix."_users U ON P.userid = U.id  
								LEFT JOIN 
									".$db_prefix."_level_settings L ON L.group_id = U.can_do 
						LEFT JOIN 
							".$db_prefix."_countries C ON C.id = U.country 
									WHERE P.pollid = {$pollid} 
									AND P.selection < 20 
									ORDER  BY P.selection DESC ";
							$sql2 =$db->sql_query($sqlb) or mysql_error();
		
			while ($useras = $db->sql_fetchrow($sql2))
			{
							$template->assign_block_vars('users_var', array(
											'NAME'				=>	$useras['user_name'],
											'ID'				=>	$useras['userid'],
											'UPLOADED'			=>	mksize($useras['uploaded']),
											'DOWNLOADED'		=>	mksize($useras['downloaded']),
											'RATIO'				=>	$useras['ratio'],
											'COLOR'				=>	$useras['color'],
											'QUESTION'			=>	$poll['question'],
											'U_LEVEL'						=>	$useras["user_level"],
											'U_GROUP'						=>	$useras["lname"],
											'U_YAHOO'						=>	(!empty($useras["yahoo"])) ? $useras["yahoo"] : false,
											'U_SKYPE'						=>	(!empty($useras["skype"])) ? $useras["skype"] : false,
											'U_MSN'							=>	(!empty($useras["msn"])) ? $useras["msn"] : false,
											'U_AIM'							=>	(!empty($useras["aim"])) ? $useras["aim"] : false,
											'U_ICQ'							=>	(!empty($useras["icq"])) ? $useras["icq"] : false,
											'U_JABBER'						=>	(!empty($useras["jabber"])) ? $useras["jabber"] : false,
											'U_REG'							=>	formatTimeStamp($useras["regdate"]),
											'U_LAST_SEEN'					=>	formatTimeStamp($useras["lastlogin"]),
											'U_IP'							=>  (checkaccess('a_see_ip'))? '<a href="javascript:popUp(\'whois.php?ip='.$useras['lastip'].'\')">'.long2ip($useras['lastip']).'</a>' : false,
											'U_HOST'						=>  (checkaccess('a_see_ip'))? $useras['lasthost'] : false,
											'U_EMAIL'						=>	$email,
											'ANSWER'						=>	$poll["option" . $useras["selection"]],
											'U_FROM'						=>	$useras["co_name"],
											'U_FLAG'						=>	$useras["flagpic"],
											'U_WARREND'						=>	($useras["warned"]) ? true : false,
											'U_AVATAR'						=>	gen_avatar($useras["userid"]),
											'U_RATIO_COLOR'					=>	get_u_ratio($useras["uploaded"], $useras["downloaded"]),
										   ));
			}
		}
	}
}


				echo $template->fetch('polloverview.html');
					close_out();
?>