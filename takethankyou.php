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
* @version $Id: 3.0.0 takethankyou.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once('include/function_posting.php');
include_once("include/utf/utf_tools.php");
$user->set_lang('comment',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['THANK_YOU']);

$id = (int)request_var('id', '0');
if(!$id)
{
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['BT_ERROR'],
                                        'MESSAGE'           => $user->lang['NO_ID_SET'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}
$res = $db->sql_query("SELECT id FROM ".$db_prefix."_torrents WHERE id = $id");
$row = $db->sql_fetchrow($res);
if (!$row)
{
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['BT_ERROR'],
                                        'MESSAGE'           => $user->lang['BAD_ID_NO_FILE'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}

$sql = "SELECT tid FROM ".$db_prefix."_thanks WHERE torid='$id' AND uid ='" .$user->id . "' ";
//die($sql);
$ras = $db->sql_query($sql) or btsqlerror($sql);
$raw = $db->sql_fetchrow($ras);
if ($raw['tid'])
{
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['BT_ERROR'],
                                        'MESSAGE'           => $user->lang['ALREADY_THANKED'].back_link($siteurl.'/details.php?id='.$id),
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}

$db->sql_query("INSERT INTO ".$db_prefix."_thanks (uid, torid, thank_date) VALUES ('" .$user->id . "',$id, NOW())");
$db->sql_query("INSERT INTO ".$db_prefix."_comments (user, torrent, added, text) VALUES ('" .$user->id . "', '".$id."', NOW(), ':thankyou:')");
$db->sql_query("UPDATE ".$db_prefix."_torrents SET comments = comments + 1, thanks = thanks + 1 WHERE id = $id");

$bon = "SELECT active, comment FROM ".$db_prefix."_bonus_points ;";
$bonset = $db->sql_query($bon);
list ($active, $comment) = $db->fetch_array($bonset);
$db->sql_freeresult($bonset);
if($active=='true' AND $user->id !=0)
{
	$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$comment."' WHERE id= ".$user->id."" ;
	$db->sql_query($do) or btsqlerror($do);
}
                        //Send notify
                        $sql = "SELECT U.name, U.email, U.language FROM ".$db_prefix."_users U, ".$db_prefix."_comments_notify C WHERE C.user = U.id AND C.status = 'active' AND C.torrent = '".$id."' AND U.id != '".$user->id."' ;";
                        $res = $db->sql_query($sql) or btsqlerror($sql);
        				$tor = "SELECT * FROM ".$db_prefix."_torrents WHERE id = '" . $id . "' ;";
        				$nott = $db->sql_query($tor)or btsqlerror($tor);
	        			$tortn = $db->sql_fetchrow($nott);
						$torrent_name = $tortn['name'];
						$torrent_url = $siteurl . "/details.php?id=" . $id . "&op=comment&trig=off";
	        			$db->sql_freeresult($nott);
                        $sqlupldate = "UPDATE ".$db_prefix."_comments_notify SET status = 'stopped' WHERE ".$db_prefix."_comments_notify.torrent = '".$id."' ;";
                        $db->sql_query($sqlupldate);
						
						$messenger = new messenger();
						$messenger->template('comentnotify', $language);
						while($row = $db->sql_fetchrow($res))
						{
							$messenger->to($row["email"], $row["username"]);
						}
						$messenger->assign_vars(array(
									'SUB_JECT'				=>	sprintf($user->lang['COMMENTNOTIFY_SUB'],$sitename),
									'TOR_URL'				=>	$siteurl . '/details.php?id=' . $id ,
									'TOR_NAME'				=>	$torrent_name ,
									'TOR_URL_WATCH'			=>	$siteurl . '/details.php?op=comment&trig=off&id=' . $id . '#notify',
									));
						$messenger->send(0);
						$messenger->save_queue();

				meta_refresh(5, $siteurl . "/details.php?id=" . $id );
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['SUCCESS'],
					'MESSAGE'			=> $user->lang['THANK_TAKEN'] . back_link("/details.php?id=" . $id ),
				));
				echo $template->fetch('message_body.html');
				close_out();
?>