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
* @version $Id: 3.0.0 rate.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once('include/function_posting.php');
$user->set_lang('rate',$user->ulanguage);
$template = new Template();
if (!$user->user){
pmbt_trigger_error($user->lang['LOGIN_SITE'],$user->lang['BT_ERROR'],$siteurl."/login.php&returnto=" . $_SERVER['QUERY_STRING'],'3');
die();
}
$op									= request_var('op', '');
$id									= (int)request_var('id', '0');
$rating								= (int)request_var('rating', '0');
$torrent_complaints					= request_var('torrent_complaints', '');
$complaints							= request_var('complaint', '0');
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

switch ($op) {
        case "star": {
                #Star Rating
                $rating = intval($rating);

                if ($rating <= 0 || $rating > 5)
				{
								set_site_var($user->lang['BT_ERROR']);
						meta_refresh(5, $siteurl . "/details.php?id=" . $id );
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['VOTE_FAIL'],
                                        'MESSAGE'           => $user->lang['INVALID_VOTE'].back_link($siteurl . "/details.php?id=" . $id),
                                ));
						echo $template->fetch('message_body.html');
						close_out();
				}

                $res = $db->sql_query("SELECT owner FROM ".$db_prefix."_torrents WHERE id = '".$id."'") or btsqlerror("SELECT owner FROM ".$db_prefix."_torrents WHERE id = '".$id."'");
                if (!$row = $db->sql_fetchrow($res))
				{
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['VOTE_FAIL'],
                                        'MESSAGE'           => $user->lang['INVALID_ID'],
                                ));
						echo $template->fetch('message_body.html');
						close_out();
				}
                $db->sql_freeresult($res);
                if (($row["owner"] == $user->id))
				{
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['VOTE_FAIL'],
                                        'MESSAGE'           => $user->lang['CANT_RATE_OWN'],
                                ));
						echo $template->fetch('message_body.html');
						close_out();
				}
                $sql = "SELECT * FROM ".$db_prefix."_ratings WHERE torrent = '".$id."' AND user = '".$user->id."' LIMIT 1;";
                $res = $db->sql_query($sql) or btsqlerror($sql);

                if ($db->sql_numrows($res) > 0 )
				{
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['VOTE_FAIL'],
                                        'MESSAGE'           => $user->lang['CANT_RATE_TWICE'],
                                ));
						echo $template->fetch('message_body.html');
						close_out();
				}
                $db->sql_freeresult($res);
                $sql = "INSERT INTO ".$db_prefix."_ratings (torrent, user, rating, added) VALUES ('$id', '" . $user->id . "', '$rating', NOW())";
                $db->sql_query($sql) or btsqlerror($sql);

                $sql = "UPDATE ".$db_prefix."_torrents SET numratings = numratings + 1, ratingsum = ratingsum + '$rating' WHERE id = '$id'";
                $db->sql_query($sql) or btsqlerror($sql);

						meta_refresh(5, $siteurl . "/details.php?id=" . $id );
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['SUCCESS'],
					'MESSAGE'			=> $user->lang['VOTE_TAKEN'],
				));
				echo $template->fetch('message_body.html');
				close_out();
        }
        case "complaint": {
		//die($complaints);
                if ($complaints < 0 || $complaints > 5)
				{
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['VOTE_FAIL'],
                                        'MESSAGE'           => $user->lang['NO_COMPLAINT_ERR'],
                                ));
						echo $template->fetch('message_body.html');
						close_out();
				}
				$banned = false;
                #Complaint Rating
                $complaint = intval($complaint);
                $sqlcheck = "SELECT * FROM ".$db_prefix."_complaints WHERE torrent = '".$id."' AND user = '".$user->id."';";

                if ($db->sql_numrows($db->sql_query($sqlcheck)) != 0 )
				{ //Have you voted yet?
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> false,
								        'TITTLE_M'          => $user->lang['VOTE_FAIL'],
                                        'MESSAGE'           => $user->lang['TWO_COMPLAINTS_ERR'],
                                ));
						echo $template->fetch('message_body.html');
						close_out();
				}

                $addsql = "INSERT INTO ".$db_prefix."_complaints (user, torrent, datetime, host, score) VALUES (".$user->id.",".intval($id).",NOW(),'".gethostbyaddr($_SERVER["REMOTE_ADDR"])."',".$complaint.");";
                $db->sql_query($addsql) or btsqlerror($sql);

                $countsql = "SELECT COUNT(score) as score FROM ".$db_prefix."_complaints WHERE torrent = '".$id."' AND score = 0 UNION SELECT COUNT(score) as score FROM ".$db_prefix."_complaints WHERE torrent = '".$id."' AND score <> 0;";
                $complqry = $db->sql_query($countsql);
                $rowcompl = $db->sql_fetchrowset($complqry);
                $positive = intval($rowcompl["0"]["score"]);
                $negative = intval($rowcompl["1"]["score"]);

                $updqry = "UPDATE ".$db_prefix."_torrents SET complaints = '".$positive.",".$negative."' WHERE id = '".$id."';";
                $db->sql_query($updqry) or btsqlerror($updqry);
                $msg = sprintf($user->lang['COMPLAINT_RANK'],$positive,$negative);
                if (($negative >= 20) AND ($negative >= (($negative+$positive)/100))) {
                        $banquery = "UPDATE ".$db_prefix."_torrents SET banned = 'yes' WHERE id = ".intval($id).";";
                        $log = fopen($torrent_dir."/".intval($id)."ban.log","w");
                        $btcomplaints = getcomplaints();
                        $scoresql = "SELECT A.torrent, A.user as user, A.host as host, A.datetime as time, A.score, B.username as username FROM ".$db_prefix."_complaints A LEFT JOIN ".$prefix."_users B ON A.user=B.user_id WHERE A.torrent = ".intval($id).";";
                        $scorequery = $db->sql_query($scoresql);
                        if (!$scorequery) bterror($scoresql);
                        while ($row = $db->sql_fetchrow($scorequery)) {
                                fputs($log,"At ".formatTimeStamp($row["datetime"]).", user ".$row["username"]." from ".$row["host"]." gave this Torrent the following rating: ".$scorarray[$row["score"]]."\n");
                        }
                        fclose($log);
                        $delsql = "DELETE FROM ".$db_prefix."_complaints WHERE torrent = ".intval($id).";";
                        $db->sql_query($delsql) or btsqlerror($delsql);
                        $db->sql_query($banquery) or btsqlerror($banquery);
                       $msg .= $user->lang['COMPLAINT_REG'];
                }
                $msg .= $user->lang['COMPLAINT_TAKEN'];
								set_site_var($user->lang['SUCCESS']);
				meta_refresh(5, $siteurl . "/details.php?id=" . $id );
				$template->assign_vars(array(
					'S_SUCCESS'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['SUCCESS'],
					'MESSAGE'			=> $msg . back_link("/details.php?id=" . $id ),
				));
				echo $template->fetch('message_body.html');
				close_out();
        }
}
?>