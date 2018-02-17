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
* @version $Id: 3.0.0 mytorrents.php  2010-11-04 00:22:48 joeroberts $
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
$user->set_lang('snatch_list',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['SNATCH_DETAILS']);
$id		= request_var('id', 0);
if (!is_numeric($id) || $id == 0)
	{
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> $siteurl.'/torrents.php',
								        'TITTLE_M'          => $user->lang['BT_ERROR'],
                                        'MESSAGE'           => $user->lang['INVALID_ID'].back_link($siteurl.'/torrents.php'),
                                ));
		echo $template->fetch('message_body.html');
		close_out();
	}
				$page		= request_var('page', 0);
				include_once('include/function_posting.' . $phpEx);
				include_once('include/class.bbcode.php');
				
				$sql = "SELECT * FROM ".$db_prefix."_smiles GROUP BY file ORDER BY id ASC LIMIT 14;";
				$smile_res = $db->sql_query($sql);
				if ($db->sql_numrows($smile_res) > 0) {
						$smile_rows = $db->sql_fetchrowset($smile_res);
						foreach ($smile_rows as $smile) {
						$template->assign_block_vars('smilies', array(
												'SMILIE_CODE'				=>	$smile["code"],
												'SMILIE_IMG'				=>	$smile["file"],
												'SMILIE_ALT'				=>	$smile["alt"],
											));
						}
				}
				$db->sql_freeresult($smile_res);

$totsql = "SELECT COUNT( id ) AS tot
			FROM ".$db_prefix."_snatched
			WHERE torrentid =" . $id.";";
$totres = $db->sql_query($totsql) or btsqlerror($totsql);
list ($tot) = $db->fetch_array($totres);
$db->sql_freeresult($totres);
$pages = ceil($tot / $torrent_per_page);
$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;
$sql = "SELECT 
			S.*,
			U.uploaded AS user_up, 
			U.downloaded AS user_down, 
			IF(U.name IS NULL, U.username, U.name) as user_name, 
			U.warned AS user_warned, 
			U.uploaded/U.downloaded as user_ratio, 
			U.aim AS user_aim, 
			U.country AS user_country, 
			U.icq AS user_icq, 
			U.msn AS user_msn, 
			U.yahoo AS user_yahoo, 
			U.skype AS user_skype, 
			U.jabber AS user_jabber, 
			U.accept_mail AS user_accept_mail, 
			U.ban as user_ban, 
			U.regdate AS user_regdate, 
			U.email AS user_email, 
			U.avatar AS user_avatar,
			U.signature AS signature,
			U.sig_bbcode_bitfield AS sig_bbcode_bitfield,
			U.sig_bbcode_uid AS sig_bbcode_uid,
			U.bbcode_bitfield,
			U.bbcode_uid, 
			UNIX_TIMESTAMP(U.lastlogin) AS user_lststamp, 
			U.lastlogin AS user_lastlogin, 
			U.lastip AS user_lastip, 
			U.lasthost AS user_lasthost, 
			U.level as user_level, 
			U.can_do as can_do, 
			L.group_colour AS color, 
			L.group_name AS co_name, 
			C.name AS lname, 
			C.flagpic AS flagpic 
		FROM 
			".$db_prefix."_snatched S 
		LEFT JOIN 
			".$db_prefix."_users U ON S.userid = U.id 
		LEFT JOIN 
			".$db_prefix."_torrents T ON S.torrentid = T.id 
		LEFT JOIN 
			".$db_prefix."_level_settings L ON L.group_id = U.can_do 
		LEFT JOIN 
			".$db_prefix."_countries C ON C.id = U.country 
			WHERE  
			S.torrentid =" . $id . "
		LIMIT 
			".$start.",".$torrent_per_page;

		$template->assign_vars(array(
			'S_ON_PAGE'		=> on_page($tot, $torrent_per_page, $start),
			'PAGINATION'	=> generate_pagination("viewsnatches.php?id=" . $id, $tot, $torrent_per_page, $start, true),
			)
		);
		$myres = $db->sql_query($sql);
		while ($myauth = $db->sql_fetchrow($myres)) {
				$file_name = $myauth['torrent_name'];
				$bbcode = false;
				$signature = censor_text($myauth["signature"]);
				if ($myauth['sig_bbcode_bitfield'])
				{
					include_once('include/bbcode.' . $phpEx);
					$bbcode = new bbcode($myauth['sig_bbcode_bitfield']);
					$bbcode->bbcode_second_pass($signature, $myauth['sig_bbcode_uid'], $myauth['sig_bbcode_bitfield']);
				}
				// Parse the message and subject
				$signature = bbcode_nl2br($signature);
				$signature = parse_smiles($signature);
					$template->assign_block_vars('users_var', array(
									'NAME'							=>	$myauth['user_name'],
									'ID'							=>	$myauth['userid'],
									'USER_HOST'						=>	((checkaccess("a_see_ip"))? htmlspecialchars($myauth["user_lasthost"]) : false),
									'USER_IP'						=>	((checkaccess("a_see_ip"))? long2ip($myauth["user_lastip"]) : false),
									'RATIO'							=>	get_u_ratio($myauth["user_up"], $myauth["user_down"]),
									'SIGNATURE'						=>	$signature,
									'COLOR'							=>	$myauth['color'],
									'UPLOADED'						=>	mksize($myauth['user_up']),
									'DOWNLOADED'					=>	mksize($myauth['user_down']),
									'U_AVATAR'						=>	gen_avatar($myauth["userid"]),
									'T_UPLOADED'					=>	mksize($myauth['uploaded']),
									'T_DOWNLOADED'					=>	mksize($myauth['downloaded']),
									'T_RATIO'						=>	get_u_ratio($myauth["uploaded"], $myauth["downloaded"]),
									'ONLINE'						=>	(($myauth["user_lststamp"] > (time()-300))? true : false),
									'SEEDER'						=>	(($myauth["seeder"] == 'yes')? TRUE : FALSE),
									'SEED_TIME'						=>	get_formatted_timediff(sql_timestamp_to_unix_timestamp($myauth["completedat"]),(sql_timestamp_to_unix_timestamp($myauth["completedat"])+$myauth["seeding_time"])),
							   ));
							  // die($myauth["user_lststamp"] .'  |  '. (time()-300));
		}
		$template->assign_vars(array(
					'FILE_NAME'				=>	htmlspecialchars($file_name),
					'TID'					=>	$id,
					));

		$db->sql_freeresult($myres);
		echo $template->fetch('snatch_list.html');
			close_out();

?>