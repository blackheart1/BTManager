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
* @version $Id: 3.0.0 re-seed.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once('include/function_posting.php');
include_once("include/utf/utf_tools.php");
$user->set_lang('reseed',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['RESEED_REQ']);


$reseedid = (int)request_var('id', '0');
$cookie = (int)request_var('PMBTreseedreq' . $reseedid, '0');
//check cookie for spam prevention
if ($cookie)
{ 
		$template->assign_vars(array(
				'S_ERROR'			=> true,
				'S_FORWARD'			=> false,
				'TITTLE_M'          => $user->lang['BT_ERROR'],
				'MESSAGE'           => $user->lang['ALREAD_REQUISTED'].back_link($siteurl.'/details.php?id='.$reseedid),
		));
		echo $template->fetch('message_body.html');
		close_out();
//end cookie check
}
else
{
	$sqlc = "SELECT COUNT(id) FROM ".$db_prefix."_peers WHERE seeder = 'yes' and torrent = " .$reseedid. "";
	$resc = $db->sql_query($sqlc);
	$torrowc = $db->sql_fetchrow($resc);
	if ($torrowc[0] >= 3)
	{
			$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'          => $user->lang['BT_ERROR'],
					'MESSAGE'           => sprintf($user->lang['ALREADY_SEEDED'],$torrowc[0]).back_link($siteurl.'/details.php?id='.$reseedid),
			));
			echo $template->fetch('message_body.html');
			close_out();
	}
	
	   //GET THE TORRENT AND USER ID FROM THIS TORRENTS COMPLETED LIST, YOU CAN AMMEND THIS TO LOOK AT SNATCHED TABLE IF NEEDED
	$sql = ("SELECT * FROM ".$db_prefix."_torrents WHERE id = " .$reseedid. "");
	$res = $db->sql_query($sql);
	$torrow = $db->sql_fetchrow($res);
	   
	$sql = ("SELECT * FROM ".$db_prefix."_download_completed WHERE torrent = " .$reseedid. "");
	$sres = $db->sql_query($sql);
	$tor			=	$siteurl . "/details.php?id=".$reseedid."&hit=1";
	$send			=	$user_>id;
	$f_name			=	$torrow['name'];
	$seeder_asked = array();
	include_once('include/function_posting.php');
	include_once('include/message_parser.php');
	include_once('include/class.bbcode.php');
	include_once('include/ucp/functions_privmsgs.php');
	$address_list = array();
	$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false;
	$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false;
	$img_status			= ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false;
	$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false;
	$url_status			= ($config['allow_post_links']) ? true : false;
	$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
	$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_pm_smilies'));
	$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_pm_bbcode'));
	$enable_urls		= ($config['enable_urls'])?true:false;
	$message_attachment = 0;
	$message_text = $message_subject = '';
	$message_parser = new parse_message();
	$message_parser->message = sprintf($user->lang['RESEED_PM'],$user->name,$torrow['name'], "<a href=\"details.php?id=".$reseedid."&hit=1\">".$torrow['name']."</a>");
	$bbcode_uid = $message_parser->bbcode_uid;
	while ($srow = $db->sql_fetchrow($sres))
	{
		//SELECT THE COMPLETED USERS DETAILS
		$sql = ("SELECT id, username, email, language FROM ".$db_prefix."_users WHERE id = ".$srow['user']." ") or die(mysql_error());
		$res = $db->sql_query($sql);
		$result=$db->sql_fetchrow($res);
		$seeder_asked[] = "<a href=\"user.php?op=profile&id=$result[id]\">".$result["username"]."</a> ";
		$address_list['u'][$result["id"]] = 'to';
	}
		@setcookie("PMBTreseedreq".$reseedid, $reseedid);
		//SEND MSG
									$pm_data = array(
										'msg_id'				=> 0,
										'from_user_id'			=> $user->id,
										'from_user_ip'			=> getip(),
										'from_username'			=> $user->name,
										'reply_from_root_level'	=> 0,
										'reply_from_msg_id'		=> 0,
										'icon_id'				=> 0,
										'enable_sig'			=> (bool) $enable_sig,
										'enable_bbcode'			=> (bool) $enable_bbcode,
										'enable_smilies'		=> (bool) $enable_smilies,
										'enable_urls'			=> (bool) $enable_urls,
										'bbcode_bitfield'		=> $message_parser->bbcode_bitfield,
										'bbcode_uid'			=> $message_parser->bbcode_uid,
										'message'				=> $message_parser->message,
										'attachment_data'		=> $message_parser->attachment_data,
										'filename_data'			=> $message_parser->filename_data,
										'address_list'			=> $address_list
									);
		$subject= $user->lang['RESEED_REQ'];
								$mid2 = submit_pm($action, $subject, $pm_data);
				meta_refresh(5, $siteurl . "/details.php?id=" . $id );
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['SUCCESS'],
					'MESSAGE'			=> sprintf($user->lang['RESEED_REQ_SENT'], implode($seeder_asked, '<br />')) . back_link("/details.php?id=" . $id ),
				));
				echo $template->fetch('message_body.html');
				close_out();
		   
}
?>