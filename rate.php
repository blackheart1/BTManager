<?php
/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File rate.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
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
                        $scorequery = $db->sql_query($scoresql) or btsqlerror($scoresql);
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