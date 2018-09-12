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
** File ajax/details.php 2018-08-04 07:32:00 Black_Heart
**
** CHANGES
**
** 2018-05-15 fixed header
** 2018-07-31 Added Language to bterror()
** 2018-08-04 Fix call to bad functio error()
**/

if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ("You can't access this file directly");
}

$user->set_lang('details', $user->ulanguage);

if($op == 'close_view_details')
    {
        $torrent = request_var('torrent', 0);
        $template->assign_vars(array(
                                'TORRENT' => $torrent,
                                'ACTION'  => $op,
                                ));
        echo $template->fetch('detail_ajax.html');
        close_out();
    }

if($op == 'close_view_details_page')
    {
        $template->assign_vars(array(
                                'ACTION' => $op,
                                ));
        echo $template->fetch('detail_ajax.html');
        close_out();
    }

if($op == 'view_peers_page')
	{
        if(!$user->user)bterror($user->lang['LOGIN_PEER_DETAILS']);

        $tracker  = request_var('tracker', '');
        $type     = request_var('type', '');
        $torrent  = request_var('torrent', 0);
        $password = request_var('password', '');
        $password = urldecode($password);

                if (!isset($torrent) OR !is_numeric($torrent) OR $torrent < 1) bterror($user->lang['INVALID_ID']);

                $sql = "SELECT 
							password .
							owner
						FROM 
							".$db_prefix."_torrents 
						WHERE 
							id = '".$torrent."' 
							AND 
							(password IS NULL 
								OR 
									password = '".$db->sql_escape($password)."') 
							LIMIT 
								1;";

                $res = $db->sql_query($sql);

                if ($db->sql_numrows($res) < 1)
                {
                    $row = $db->sql_fetchrow($res);

                    if ($row["password"] != "" AND !checkaccess("m_over_ride_password") AND $password != $row["password"] AND (!$user->user OR $user->id != $row["owner"]))
                    {
                        $template->assign_vars(array(
                          'ACTION'         => 'error',
                          'S_ERROR_HEADER' => $user->lang['PASS_PROT'],
                          'S_ERROR_MESS'   => $user->lang['PASSWORD_REQ'],
                                                ));

                        echo $template->fetch('detail_ajax.html');
                        close_out();
                    }
                }

                $db->sql_freeresult($res);

                $i = 0;
                $tropen = false;
                $sql = "SELECT 
							P.id AS pid, 
							P.peer_id AS peer_id, 
							P.downloaded AS downloaded, 
							P.uploaded AS uploaded, 
							P.download_speed AS download_speed, 
							P.upload_speed AS upload_speed, 
							P.ip AS ip, 
							P.real_ip AS real_ip, 
							P.to_go AS to_go, 
							P.seeder AS seeder, 
							UNIX_TIMESTAMP(P.started) AS started_ts, 
							UNIX_TIMESTAMP(P.last_action) AS last_action_ts, 
							P.connectable AS connectable, 
							P.client AS client, 
							P.version AS clientversion, 
							U.id AS uid, 
							U.username AS username, 
							U.name AS name, 
							UNIX_TIMESTAMP(U.lastlogin) AS user_lststamp, 
							U.avatar AS avatar, 
							U.can_do as can_do, 
							U.level AS level, 
							T.size AS torrent_size, 
							L.group_colour AS color, 
							L.group_name AS lname 
						FROM 
							".$db_prefix."_peers P 
						LEFT JOIN 
							".$db_prefix."_users U 
						ON 
							U.id = P.uid 
						LEFT JOIN 
							".$db_prefix."_torrents T 
						ON 
							T.id = P.torrent 
						LEFT JOIN 
							".$db_prefix."_level_settings L 
						ON 
							L.group_id = U.can_do
						WHERE 
							P.torrent = '".$torrent."' 
						ORDER BY 
							P.seeder 
							ASC;";
                $res = $db->sql_query($sql) or print_r($db->sql_error());
                if ($db->sql_numrows($res) < 1);

                while ($row = $db->sql_fetchrow($res))
				{
                        if ($row["downloaded"])$s = number_format($row["uploaded"]/$row["downloaded"],2);
                        else
                                if ($row["uploaded"])$s = number_format($row["uploaded"]/$row["torrent_size"],2);
                                else
                                        $s = "---";
						$edt = "&infin;";
                        if ($row["seeder"] == "no") {
                                if ($row["download_speed"]) {
                                        $edt_m = ($row["to_go"] / $row["download_speed"])/60; //to minutes
                                        $edt = ($edt_m % 60)."m"; //minutes
                                        $edt_h = floor($edt_m / 60);
                                        if ($edt_h>0) $edt = $edt_h."h ".$edt;
                                }
                        }
					$client = $row["client"]." ".$row["clientversion"];
					if ($row["client"] != "" AND is_readable("client_icons/".$row["client"].".gif")) $client_img = "<img src=\"client_icons/".htmlspecialchars($row["client"]).".gif\" alt=\"".$client."\" title=\"".$client."\" />";
					else $client_img =  "<img src=\"client_icons/Unknown.gif\" alt=\"".$client."\" title=\"".$client."\" />";
					if (!$user->admin) $ip = preg_replace('/\.\d+$/', ".xxx", long2ip($row["ip"]));
					else $ip = long2ip($row["ip"]);
					$template->assign_block_vars('peer_list', array(
                            'UPLOADED'       => mksize($row["uploaded"]),
                            'DOWNLOADED'     => mksize($row["downloaded"]),
                            'PERCENT'        => sprintf("%.2f%%", (1 - ($row["to_go"] / $row["torrent_size"])) * 100),
                            'RATIO'          => $s,
                            'SPEED'          => mksize($row["upload_speed"]),
                            'IS_SEEDER'      => (($row["seeder"] == "yes")?true : false),
                            'DOWNLOAD_SPEED' => (($row["seeder"] == "no")?mksize($row["download_speed"]):false),
                            'EST_DOWN_TIME'  => $edt,
                            'USER_CLIENT'    => $client,
                            'CLIENT_IMG'     => htmlspecialchars($row["client"]),
                            'CONECTABLE'     => (($row["connectable"] == "yes")?true:false),
                            'START_TIME'     => mkprettytime(time()-$row["started_ts"]),
                            'IDLE_TIME'      => mkprettytime(time()-$row["last_action_ts"]),
                            'USER_IP'        => $ip,
                            'AVATAR'         => gen_avatar($row["uid"]),
							'USER_HOST'		 =>	((checkaccess("a_see_ip"))? gethostbyaddr($ip) : false),
							'ONLINE'		 =>	(($row["user_lststamp"] > (time()-300))? true : false),
                            'RANK_IMG'       => '<img src="themes/' . $theme . '/pics/group/' . $row["can_do"] . '.png" title="' . ((!empty($user->lang[$row['lname']]))?$user->lang[$row['lname']]:$row['lname']) . '" alt="' . ((!empty($user->lang[$row['lname']]))?$user->lang[$row['lname']]:$row['lname']) . '">',

                            'IS_USER'        => (($row["uid"] != 0)? true : false),
                            'USER_ID'        => $row["uid"],
                            'USER_NAME'      => (($row["uid"] != 0)? $row["username"] : $user->lang['GUEST']),
                            'USER_COLOR'     => $row["color"],
                            'USER_LEVEL'     => $row["level"],
                            'USER_GROUP'     => ((!empty($user->lang[$row['lname']]))?$user->lang[$row['lname']]:$row['lname']),
                            'IMG_BAR_WIDTH'  => round(1 * sprintf("%.2f%%", (1 - ($row["to_go"] / $row["torrent_size"])) * 100)),
                        ));
                                                }
                $db->sql_freeresult($res);
                        $template->assign_vars(array(
                          'ACTION' => $op,
                                                ));
                                                //print_r($template->_tpldata['peer_info']);
                        echo $template->fetch('detail_ajax.html');
                        close_out();
    }
if($op == 'view_nfo_page')
	{
        $torrent  = (int)request_var('torrent', '0');
        $password = request_var('password', '');
		if( !isset( $torrent ) || !is_numeric($torrent) )
			{
				error("Invalid torrent!" );
			}
        $password = urldecode($password);
                $sql = "SELECT 
							password .
							owner
						FROM 
							".$db_prefix."_torrents 
						WHERE 
							id = '".$torrent."' 
							AND 
							(password IS NULL 
								OR 
									password = '".$db->sql_escape($password)."') 
							LIMIT 
								1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1)
				{
					$row = $db->sql_fetchrow($res);
					if ($row["password"] != "" AND !checkaccess("m_over_ride_password") AND $password != $row["password"] AND (!$user->user OR $user->id != $row["owner"]))
					{
						$template->assign_vars(array(
                          'ACTION'         => 'error',
                          'S_ERROR_HEADER' => $user->lang['PASS_PROT'],
                          'S_ERROR_MESS'   => $user->lang['PASSWORD_REQ'],
												));
						echo $template->fetch('detail_ajax.html');
						close_out();
					}
				}
                $db->sql_freeresult($res);
        $nfo = "";
        $nf = fopen($torrent_dir."/".$torrent.".nfo","rb");
        while (!feof($nf)) $nfo .= fread($nf,100);
        fclose($nf);
		$template->assign_vars(array(
                        'NFO_INFO' => $nfo,
                        'ACTION'   => $op,
						));
		echo $template->fetch('detail_ajax.html');
        unset($nfo);
		close_out();
	}
if($op == 'view_files_page')
	{
		$id					= (int)request_var('torrent', '0');
		$password					= request_var('password', '');
                if (!isset($id) OR !is_numeric($id) OR $id < 1) error($user->lang['INVALID_ID']);
                $password = urldecode($password);
                $sql = "SELECT 
							password .
							owner
						FROM 
							".$db_prefix."_torrents 
						WHERE 
							id = '".$torrent."' 
							AND 
							(password IS NULL 
								OR 
									password = '".$db->sql_escape($password)."') 
							LIMIT 
								1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1)
				{
					$row = $db->sql_fetchrow($res);
					if ($row["password"] != "" AND !checkaccess("m_over_ride_password") AND $password != $row["password"] AND (!$user->user OR $user->id != $row["owner"]))
					{
						$template->assign_vars(array(
                          'ACTION'         => 'error',
                          'S_ERROR_HEADER' => $user->lang['PASS_PROT'],
                          'S_ERROR_MESS'   => $user->lang['PASSWORD_REQ'],
												));
						echo $template->fetch('detail_ajax.html');
						close_out();
					}
				}
                $db->sql_freeresult($res);

                $sql = "SELECT A.id as id, A.seeders, A.banned, A.leechers, A.info_hash, A.filename, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, A.numratings, A.name, IF(A.numratings < '$minvotes', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, A.save_as, A.descr, A.visible, A.size, A.added, A.views, A.downloaded, A.completed, A.type, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, A.tracker, B.name AS cat_name, IF(C.name IS NULL, C.username, C.name) as ownername, A.tracker_update, IF(A.tracker_update>(sysdate()-INTERVAL 15 MINUTE), 0, 1) as can_tracker_update FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id WHERE A.id = '".$id."';";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                $torrent = $db->sql_fetchrow($res);


                if (can_download($btuser,$torrent)) {
                        $can_access = true;
                } else{
                        $can_access = false;
                }

                if(!$fres = $db->sql_query("SELECT * FROM ".$db_prefix."_files WHERE torrent = '".$torrent["id"]."' ORDER BY id")) btsqlerror("SELECT * FROM ".$db_prefix."_files WHERE torrent = '".$id."' ORDER BY id");
                while ($frow = $db->sql_fetchrow($fres)) {
                        preg_match('/^(?P<name>.*)\\.(?P<ext>[A-Za-z0-9]+)$/', $frow["filename"], $filename);
                        $ext = strtolower($filename["ext"]);
                        $name = ($filename["name"] == '')? $frow["filename"] : $filename["name"];
						$template->assign_block_vars('file_info', array(
                                'FILENAME' => htmlspecialchars(str_replace(Array(".","_"),Array(" "," "),stripslashes($name))).".".$filename["ext"],

                                'FILE_EXT' => strtolower($filename["ext"]),
                                'FILESIZE' => mksize($frow["size"]),
                                'MAGLINK'  => (($frow["magnet"]  AND $can_access) ? stripslashes($frow["magnet"]) : FALSE),
                                'EDKLINK'  => (($frow["ed2k"]  AND $can_access)? str_replace("'","",$frow["ed2k"]) : FALSE),
                        ));
                        }
                        $template->assign_vars(array(
                          'ACTION' => $op,
                                                ));
                        echo $template->fetch('detail_ajax.html');
                        close_out();
    }
if($op == 'view_rate_page')
    {
        $id                 = (int)request_var('torrent', '0');
        $password                   = request_var('password', '');
        $password = urldecode($password);
        if( !isset( $id ) || !is_numeric($id) )
            {
                bterror($user->lang['INVALID_TORRENT']);
            }
                $sql = "SELECT 
							password .
							owner
						FROM 
							".$db_prefix."_torrents 
						WHERE 
							id = '".$torrent."' 
							AND 
							(password IS NULL 
								OR 
									password = '".$db->sql_escape($password)."') 
							LIMIT 
								1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1)
                {
                    $row = $db->sql_fetchrow($res);
                    if ($row["password"] != "" AND !checkaccess("m_over_ride_password") AND $password != $row["password"] AND (!$user->user OR $user->id != $row["owner"]))
                    {
                        $template->assign_vars(array(
                          'ACTION'         => 'error',
                          'S_ERROR_HEADER' => $user->lang['PASS_PROT'],
                          'S_ERROR_MESS'   => $user->lang['PASSWORD_REQ'],
                                                ));
                        echo $template->fetch('detail_ajax.html');
                        close_out();
                    }
                }
                $db->sql_freeresult($res);
                        $template->assign_vars(array(
                          'ACTION'          => $op,
                          'V_UVOTED'        => false,
                          'RATE_ID'         => $id,
                          'V_YOU_FILE'      => false,
                          'MINVOTES_NEEDED' => (($minvotes > 1)? true : false),
                                                ));

                $sql = "SELECT 
							A.id as id, 
							A.numratings, 
							A.name, 
							IF(A.numratings < '" . $minvotes . "', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, 
							A.owner, 
							A.ownertype, 
							A.complaints, 
							IF(C.name IS NULL, C.username, C.name) as ownername 
						FROM 
							".$db_prefix."_torrents A 
						LEFT JOIN 
							".$db_prefix."_users C ON A.owner = C.id 
						WHERE 
							A.id = '".$id."';";
                $res = $db->sql_query($sql) or btsqlerror($sql);
                $torrent = $db->sql_fetchrow($res);
		#Star Rating
		if (!isset($torrent["rating"]))
		{
			if ($minvotes >= 1)
			{
				$rate_out = sprintf($user->lang['MINVOTEDNOTMATCHED'],$torrent['numratings'],(($torrent['numratings'])? $torrent['numratings'] : $user->lang['NONE']));
			}
			else
			{
				$rate_out = $user->lang['NO_RATING'];
			}
		}
		else
		{
			$rate_out = sprintf($user->lang['TOTAL_RATING'],$torrent["rating"],$torrent['numratings']);
		}
						$template->assign_vars(array(
                          'RATIN_TOTAL' => $rate_out,
                          'STARS'       => round($torrent["rating"])
												));
		$ratings = array(
        5 => 'VOTE_E',
        4 => 'VOTE_D',
        3 => 'VOTE_C',
        2 => 'VOTE_B',
        1 => 'VOTE_A'
		);
		if ($torrent["owner"] != $user->id AND ($user->user))
		{
			$xres = $db->sql_query("SELECT rating, added FROM ".$db_prefix."_ratings WHERE torrent = '".$id."' AND user = '" . $user->id."'") or btsqlerror("SELECT rating, added FROM ".$db_prefix."_ratings WHERE torrent = '".$id."' AND user = '" . $user->id."'");
            if ($xrow = $db->sql_fetchrow($xres))
            {
                        $template->assign_vars(array(
                          'V_UVOTED'      => true,
                          'V_URATING_VAR' => $user->lang[$ratings[$xrow["rating"]]],
                          'V_URATING'     => $xrow["rating"],
                          'V_RATE_DATE'   => formatTimeStamp($xrow["added"]),
                                                ));
            }
            $db->sql_freeresult($xres);
        }
        elseif ($torrent["owner"] == $user->id AND ($user->user))
        {
                        $template->assign_vars(array(
                          'V_YOU_FILE' => true,
                                                ));
        }

        #Complaints
        if ($torrent_complaints)
        {
                        $template->assign_vars(array(
                          'V_COMPLAINTS' => true,
                                                ));
        #Separator
            echo "<tr><td><HR SIZE=1 NOSHADE></td><td></td></tr>\n";

            $complaintsql ="SELECT score FROM ".$db_prefix."_complaints WHERE torrent ='".$id."' AND user = '".$user->id."';";
            $complaintres = $db->sql_query($complaintsql) or btsqlerror($complaintsql);
            $complaints = explode(",",$torrent["complaints"]);
            $btcomplaints = getcomplaints();
            if ($db->sql_numrows($complaintres) != 0)
            {
                    list ($score) = $db->fetch_array($complaintres);
                        $template->assign_vars(array(
                          'U_COMPLAINT'   => true,
                          'U_P_COMP'      => $btcomplaints[$score],
                          'TOT_USER_COMP' => sprintf($user->lang['V_TOT_COMP'],$complaints[0],$complaints[1]),
                                                ));
            }
            else
            {
                            $complselect = '';
                            foreach ($btcomplaints as $k => $val) $complselect .= "<option value=\"".$k."\">".$val."</option>";
                        $template->assign_vars(array(
                          'U_COMPLAINT'   => false,
                          'TOT_USER_COMP' => sprintf($user->lang['V_TOT_COMP'],$complaints[0],$complaints[1]),
                          'COMP_SELECT'   => $complselect,
                                                ));
            }
        }
                        echo $template->fetch('detail_ajax.html');
                        close_out();
    }
if($op == 'view_coments_page')
    {
        if(isset($_GET["amp;torrent"]))$_GET["torrent"] = $_GET["amp;torrent"];
        if(isset($_GET["amp;password"]))$_GET["password"] = $_GET["amp;password"];
#Read Comments
                $id                 = (int)request_var('torrent', '0');
        if( !isset( $id ) || !is_numeric($id) )
            {
                bterror($user->lang['INVALID_TORRENT']);
            }
				include_once('include/function_posting.' . $phpEx);
				include_once('include/class.bbcode.php');
				
                $password = urldecode($password);
				$sql = "SELECT * FROM ".$db_prefix."_smiles ORDER BY id ASC LIMIT 14;";
				$smile_res = $db->sql_query($sql);
				if ($db->sql_numrows($smile_res) > 0) {
						$smile_rows = $db->sql_fetchrowset($smile_res);
						foreach ($smile_rows as $smile) {
						$template->assign_block_vars('smilies', array(
                                                'SMILIE_CODE' => $smile["code"],
                                                'SMILIE_IMG'  => $smile["file"],
                                                'SMILIE_ALT'  => $smile["alt"],
											));
						}
				}
				$db->sql_freeresult($smile_res);
		$password					= request_var('password', '');
        $password = urldecode($password);
                $sql = "SELECT 
							password .
							owner
						FROM 
							".$db_prefix."_torrents 
						WHERE 
							id = '".$torrent."' 
							AND 
							(password IS NULL 
								OR 
									password = '".$db->sql_escape($password)."') 
							LIMIT 
								1;";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1)
				{
					$row = $db->sql_fetchrow($res);
					if ($row["password"] != "" AND !checkaccess("m_over_ride_password") AND $password != $row["password"] AND (!$user->user OR $user->id != $row["owner"]))
					{
						$template->assign_vars(array(
                          'ACTION'         => 'error',
                          'S_ERROR_HEADER' => $user->lang['PASS_PROT'],
                          'S_ERROR_MESS'   => $user->lang['PASSWORD_REQ'],
												));
						echo $template->fetch('detail_ajax.html');
						close_out();
					}
				}
                $db->sql_freeresult($res);
                $sql = "SELECT 
							C.*, 
							U.id as uid, 
							U.can_do as can_do, 
							U.username, 
							U.name, 
							U.donator AS donator,
							U.ban as ban, 
							IF(U.name IS NULL, U.username, U.name) as user_name, 
							L.group_colour AS color, 
							L.group_name AS lname  
						FROM 
							".$db_prefix."_comments C 
						LEFT JOIN 
							".$db_prefix."_users U ON C.user = U.id 
						LEFT JOIN 
							".$db_prefix."_level_settings L ON L.group_id = U.can_do 
						WHERE 
							C.torrent ='".$id."' 
						ORDER BY 
							added ASC;";
                $res = $db->sql_query($sql) or btsqlerror($sql);
							$template->assign_vars(array(
                          'CAN_COMMENT' => checkaccess("u_can_comment"),
                          'T_ID'        => $id,
                          'ACTION'      => $op,
							));
                while ($comment = $db->sql_fetchrow($res)) {
				$bbcode = false;
				$comment_txt = censor_text($comment["text"]);
				if ($comment['bbcode_bitfield'])
				{
					include_once('include/bbcode.' . $phpEx);
					$bbcode = new bbcode($comment['bbcode_bitfield']);
					$bbcode->bbcode_second_pass($comment_txt, $comment['bbcode_uid'], $comment['bbcode_bitfield']);
				}
				// Parse the message and subject
				//$comment_txt = bbcode_nl2br($comment_txt);
				//$comment_txt = parse_smiles($comment_txt);
				$can_edit = checkaccess("u_edit_own_comments");
				if(checkaccess("m_edit_comments")) $can_edit = true;
				$can_del = checkaccess("u_delete_comments");
				if(checkaccess("m_delete_comments")) $can_del = true;

						$template->assign_block_vars('comments', array(
                                            'USER_ID'      => $comment["uid"],
                                            'USER_NAME'    => htmlspecialchars($comment["user_name"]),
                                            'USER_COLOR'   => $comment["color"],
                                            'USER_DONER'   => ($comment['donator'] == 'true') ? true : false,
                                            'USER_WARNED'  => ($comment["warned"] == "1")? true : false,
                                            'USER_AVATAR'  => gen_avatar($comment["uid"]),
                                            'USER_GROUP'   => $comment["lname"],
                                            'COMMENT_ID'   => $comment["id"],
                                            'COMMENT_TIME' => formatTimestamp($comment["added"]),
                                            'COMMENT_TXT'  => $comment_txt,
                                            'CAN_EDIT'     => $can_edit,
                                            'CAN_DELETE'   => $can_del,
											));
						}
						echo $template->fetch('detail_ajax.html');
						close_out();
#Post comment form, if user is logged in
	}
if($op == 'view_details_page')
	{
		if(request_var('amp;torrent', '0') > 0)$torrent = request_var('amp;torrent', '0');
		else
        $torrent     = request_var('torrent', '0');
        $torrent_var = $torrent;
        $password    = request_var('password', '');

        if(!defined('AUTH_PENDING')) define('AUTH_PENDING', 0 );
        if(!defined('AUTH_GRANTED')) define('AUTH_GRANTED', 1 );
        if(!defined('AUTH_DENIED')) define('AUTH_DENIED', 2 );
        if(!defined('AUTH_NONE')) define('AUTH_NONE', 3 );

		$sql = "SELECT A.id as id,
				A.post_img,
				A.bbcode_bitfield as tbbcode_bitfield,
				A.bbcode_uid as tbbcode_uid,
				A.screan1,
				A.screan2,
				A.screan3,
				A.screan4, 
				A.exeem, 
				A.seeders, 
				A.leechers, 
				A.tot_peer, 
				A.speed, 
				A.info_hash, 
				A.filename, 
				A.banned, 
				A.nuked, 
				A.nukereason, 
				A.password, 
				UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, 
				A.numratings, 
				A.name, 
				IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, 
				A.save_as, 
				A.descr, 
				A.visible, 
				A.size, 
				A.plen, 
				A.added, 
				A.views, 
				A.downloaded, 
				A.completed, 
				A.type, 
				A.private, 
				A.min_ratio, 
				A.numfiles, 
				A.owner, 
				A.ownertype, 
				A.complaints, 
				A.evidence, 
				A.tracker, 
				A.tracker_list, 
				A.dht as dht, 
				A.md5sum as md5sum, 
				A.uploader_host as user_host, 
				B.name AS cat_name, 
				IF(C.name IS NULL, C.username, C.name) as ownername, 
				C.can_do as can_do, 
				L.group_colour AS color, 
				L.group_name AS lname ,
				A.tracker_update, 
				COUNT(S.status) as auths 
				FROM ".$db_prefix."_torrents A 
				LEFT JOIN ".$db_prefix."_categories B ON 
				A.category = B.id 
				LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id 
				LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' 
			LEFT JOIN 
				".$db_prefix."_level_settings L ON L.group_id = C.can_do 
				WHERE A.id = '".$torrent."' 
				GROUP BY A.id LIMIT 1;";
		$res = $db->sql_query($sql) or btsqlerror($sql);
		$torrent = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
		if (can_download($user,$torrent)) {
        $can_access = true;
		} else {
        $can_access = false;
		}
		$infohash_hex = preg_replace_callback('/./s', "hex_esc", str_pad(utf8_decode($torrent["info_hash"]),20));
		if ($torrent["password"] != "" AND !checkaccess("m_over_ride_password") AND $password != $torrent["password"] AND (!$user->user OR $user->id != $torrent["owner"])) {
            if ($password != "") { //Means that password is wrong
                            $template->assign_vars(array(
                              'ERROR'   => false,
                              'E_ERROR' => $user->lang['WRONG_PASS'],
                          ));
            }
                        $template->assign_vars(array(
                          'ACTION'   => $op,
                          'TITTLE_M' => $user->lang['PASSWORD_REQ'],
                          'HIDDEN'   => build_hidden_fields(array('id' => $id)),
                          'LOGIN'    => true,
                                                ));
                        echo $template->fetch('detail_ajax.html');
                        close_out();
        }
								$speed_leech = $user->lang["NOT_APLICABLE_SHORT"];
								$edt = $user->lang["NOT_APLICABLE_SHORT"];
		if ($torrent["type"] != "link") {
				if ($torrent["tracker"] == "") {
						$complsql = "SELECT SUM(T.size-P.to_go)/(COUNT(P.id)*T.size) as complete FROM ".$db_prefix."_torrents T, ".$db_prefix."_peers P WHERE T.id = '".$torrent_var."' AND P.torrent = '".$torrent_var."';";
						$complres = $db->sql_query($complsql) or bterror($complsql);
						list ($completepercent) = $db->fetch_array($complres);
						$db->sql_freeresult($complres);
						if ($torrent["leechers"] > 0 AND $torrent["speed"] > 0) {
								$ro = $torrent["seeders"]/$torrent["leechers"];
								$speed_leech = ($ro == 0) ? round($torrent["speed"]/$torrent["leechers"]) : min($torrent["speed"],round($torrent["speed"]*$ro));
								$edt_m = ($torrent["size"] / $speed_leech)/60; //to minutes
								$edt = ($edt_m % 60)."m"; //minutes
								$edt_h = floor($edt_m / 60);
								if ($edt_h>0) $edt = $edt_h."h ".$edt;
								$speed_leech = mksize($speed_leech)."/s";
						} else {
								$speed_leech = "--";
								$edt = "--";
						}
				}
		}
		$flag = getauthstatus($torrent);
		$torrent_link = $rxport_link = $magnet_link = $edit_link = $delete_link = $ban_link = $torrent_lock = $auth_needed = false;
		$can_edit=$can_delete=true;
		$can_ban = false;
		if ($torrent['owner'] == $user->id AND !checkaccess("u_edit_own_torrents"))
		{
		$can_edit=false;
		} 
		if ($torrent['owner'] == $user->id AND !checkaccess("u_delete_own_torrents"))
		{
		$can_delete=false;
		} 
		if ($torrent['owner'] != $user->id AND !checkaccess("m_delete_others_torrents"))
		{
		$can_delete=false;
		} 
		if ($torrent['owner'] != $user->id AND !checkaccess("m_can_edit_others_torrents"))
		{
		$can_edit=false;
		}
		if (checkaccess("m_bann_torrents"))$can_ban = true;
        $passlink = "";
        if ($torrent["password"] != "") $passlink = "&amp;password=".urlencode($torrent["password"]);
		$maglinks_b = array();
		$trackers_sub = array();
		if ($user->passkey != "" )$passkey = $query_char."passkey=".urlencode($user->passkey);
		else
		$passkey = "";
        if ($torrent["tracker"] == "") {
				$maglinks_b[] = urlencode($siteurl . '/announce.php?' . $passkey);
				$trackers_sub[] = $siteurl;
        } else {
				$maglinks_b[] = $torrent["tracker"];
				$trackers_sub[] = $torrent["tracker"];
        }
        if ($torrent["tracker_list"] != "") {
                $trackers = explode("\n\n",$torrent["tracker_list"]);
                for ($i = 0; $i < count($trackers); $i++) {
                        $trackers[$i] = explode("\n",$trackers[$i]);

                        for ($j = 0; $j < count($trackers[$i]); $j++) {
								$pos = strpos($trackers[$i][$j], $announce_url);
                                if ($pos !== false){
									$maglinks_b[] = urlencode($trackers[$i][$j] . '/announce.php?' . $passkey);
									$trackers_sub[] = $siteurl;
								}
								else
								{
									$maglinks_b[] = $trackers[$i][$j];
									$trackers_sub[] = $trackers[$i][$j];
								}
                        }

                }
        }
		foreach($trackers_sub as $key)
		{
			$template->assign_block_vars('trakers', array(
                                                'LINK' => $key,
										));
		}
		if ($torrent["filename"] != "" AND $torrent["type"] != "link") {
				$passlink = "";
				if ($can_access) {
						$torrent_link = "download.php?id=".$torrent_var.$passlink;
						$magnet_link = 'magnet:?xt=urn:btih:' . strtolower(hex_to_base32($infohash_hex)) . '&dn=' . $torrent["filename"] . '&xl=' . $torrent["size"] . '&tr=' . implode('&tr=',$maglinks_b);
		
						if ($user->passkey != "")
								$rxport_link = "download.php?id=".$torrent_var.$passlink."&amp;export=1";
				} elseif ($user->user AND $torrent_global_privacy AND $torrent["owner"] != $user->id AND $torrent["ownertype"] != 2) {
						if ($flag == AUTH_NONE)
						{
							 $torrent_link = "details.php?op=authorization&amp;id=".$torrent_var.$passlink;
							 $torrent_unlock = true;
						}
				}
		}
		include_once('include/function_posting.' . $phpEx);
		include_once('include/class.bbcode.php');
		
		// Grab icons
		$icons = $pmbt_cache->obtain_icons();
		$bbcode = false;
		$descript = censor_text($torrent['descr']);
		// Instantiate BBCode if need be
		if ($torrent['tbbcode_bitfield'])
		{
			include_once('include/bbcode.' . $phpEx);
			$bbcode = new bbcode($torrent['tbbcode_bitfield']);
			$bbcode->bbcode_second_pass($descript, $torrent['tbbcode_uid'], $torrent['tbbcode_bitfield']);
		}
		// Parse the message and subject
		$descript = bbcode_nl2br($descript);
		$descript = parse_smiles($descript);
		switch ($torrent["ownertype"]) {
				case 0: {
				$u_name = htmlspecialchars($torrent["ownername"]);
				$u_color = $torrent["color"];
				$u_id = $torrent["owner"];
				$u_host = ((checkaccess("a_see_ip"))? htmlspecialchars($torrent["user_host"]) : false);
						break;
				}
				case 1: {
						if (checkaccess("see_hidden_uploader"))
						{
							$u_name = htmlspecialchars($torrent["ownername"]);
							$u_color = $torrent["color"];
							$u_id = $torrent["owner"];
							$u_host = ((checkaccess("a_see_ip"))? htmlspecialchars($torrent["user_host"]) : false);
						} 
						else $private = true;
				}
				case 2: {
						$u_host = ((checkaccess("a_see_ip"))? htmlspecialchars($torrent["user_host"]) : false);
						$private = true;
				}
		}
		if ($torrent["tracker"] != "") {
			if ($user->user){
				if (time()- sql_timestamp_to_unix_timestamp($torrent["tracker_update"])> 1800) {
				$refreshable = true;
				}else{
				$refreshable = false;
				}
			}elseif ($user->moderator){
				$refreshable = true;
			}else{
				$refreshable = false;
               		}
		}
		$scrape_url = false;
		if (checkaccess("u_update_peers") AND $torrent["tracker"] != "")
		{
			$scrape_url = "scrape-external.php?id=".$torrent["id"]."&amp;tracker=".$torrent["tracker"]."&amp;back=yes";
        }
		$auth_torrent = $auth_pending = false;
		if ($torrent["owner"] == $user->id AND $torrent_global_privacy AND $torrent["tracker"] == "") {
			$auth_torrent = true;
				if ($torrent["auths"] > 0)
				{
					$auth_pending = true;
				}
		}
						$template->assign_vars(array(
                                'ACTION'           => $op,
                                'T_ID'             => $torrent_var,
                                'POSTER'           => (($torrent["post_img"] !='')?$torrent["post_img"] :false),

                                'TITLE'            => htmlspecialchars(str_replace(Array(".","_"),Array(" "," "),stripslashes($torrent["name"]))),

                                'LEECH_SPEED'      => $speed_leech,
                                'EST_DNLLOAD_TIME' => $edt,
                                'AUTH_NEEDED'      => $auth_pending,
                                'AUTH_TORRENT'     => $auth_torrent,
                                'TORRENT_LINK'     => $torrent_link,
                                'TORRENT_LOCKED'   => $torrent_lock,
                                'TORRENT_UNLOCK'   => $torrent_unlock,
                                'TORRENT_SCARPE'   => $scrape_url,
                                'CAN_REFRESH'      => $refreshable,
                                'TIMES_COMPLETE'   => $torrent["completed"],
                                'TIMES_DOWNLOADED' => $torrent["downloaded"],
                                'TIMES_SEEN'       => $torrent["views"],
                                'TORRENT_DESCP'    => $descript,
                                'TORRENT_SIZE'     => mksize($torrent["size"]),
								'TORRENT_PRIVATE'	=> ($torrent["private"] == 'true')? $torrent["min_ratio"] : false,

                                'TORRENT_INFOHASH' => strtoupper(chunk_split(preg_replace_callback('/./s', "hex_esc", str_pad(utf8_decode($torrent["info_hash"]),20)),5,' ')),

                                'FILE_COUNT'       => $torrent["numfiles"],
                                'EXPORT_LINK'      => $rxport_link,
                                'MAGNET_LINK'      => $magnet_link,
                                'EDIT_LINK'        => ($can_edit) ? true : false,
                                'DELETE_LINK'      => $can_delete,
                                'BAN_LINK'         => $can_ban,
                                'TORRENT_SEEDS'    => $torrent["seeders"],
                                'TORRENT_LEECH'    => $torrent["leechers"],
                                'TORRENT_SPEED'    => $speed_leech,
                                'TIME_TO_COMP'     => $edt,
                                'TORRENT_COMPL'    => $torrent["completed"],
                                'TORRENT_ADDED'    => formatTimeStamp($torrent["added"]),
                                'UPLOADER'         => $u_name,
                                'UPLOADER_ID'      => $u_id,
                                'UPLOADER_COLOR'   => $u_color,
                                'UPLOADER_HOST'    => $u_host,
                                'UPLOADER_HIDE'    => $private,
                                'LAST_ACTION'      => mkprettytime($torrent["lastseed"]),

                                'SNATCH_LIST'      => ((checkaccess("u_can_view_snatchlist"))?(($torrent["tracker"] == "")?true : false) : false),

                                'NUKED'            => $user->lang[strtoupper($torrent["nuked"])],
                                'NUKED_REASON'     => $torrent["nukereason"],

                                'RESEED'           => ((checkaccess("u_requist_reseed"))?(($torrent["tracker"] == "")?true : false) : false),

                                'SHOW_PASS_WORD'   => ((checkaccess("m_over_ride_password") AND $torrent["password"] != "" AND ($user->id == $torrent["owner"] OR $user->premium))? htmlspecialchars($torrent["password"]) : false),

                                'PASSWORD_LINK'    => $siteurl . "/details.php?id=" . $torrent_var . "&amp;password=" . urlencode($torrent["password"]),
                        ));

		$sql = "SELECT 
					C.user AS id, 
					IF(U.name IS NULL, U.username, U.name) AS username, 
					U.can_do as can_do, 
					L.group_colour AS color, 
					L.group_name AS lname ,
					U.level 
				FROM 
					".$db_prefix."_download_completed C, 
					".$db_prefix."_users U, 
					".$db_prefix."_level_settings L 
				WHERE 
					C.user = U.id 
				AND 
					L.group_id = U.can_do 
				AND
					C.torrent = '".$torrent_var."';";
		$comres = $db->sql_query($sql);
		
		if ($db->sql_numrows($comres) > 0) {
		
				while ($comrow = $db->sql_fetchrow($comres)) {
					$template->assign_block_vars('completer', array(
                              'ID'    => $comrow["id"],
                              'COLOR' => $comrow["color"],
                              'GROUP' => $comrow["lname"],
                              'NAME'  => $comrow["username"]
					));
				}
		
		}
		
		$db->sql_freeresult($comres);
		

        if($torrent["screan1"] !=''){
        $template->assign_block_vars('screen_shots', array(
                                            'SHOT' => stripslashes($torrent["screan1"]),
        ));
        }

        if($torrent["screan2"] !=''){
        $template->assign_block_vars('screen_shots', array(
                                            'SHOT' => stripslashes($torrent["screan2"]),
        ));
        }

        if($torrent["screan3"] !=''){
        $template->assign_block_vars('screen_shots', array(
                                            'SHOT' => stripslashes($torrent["screan3"]),
        ));
        }

        if($torrent["screan4"] !=''){
        $template->assign_block_vars('screen_shots', array(
                                            'SHOT' => stripslashes($torrent["screan4"]),
        ));
        }
                        echo $template->fetch('detail_ajax.html');
                        close_out();
    }
if($op == 'get_imdb')
	{
		if(request_var('amp;torrent', '0') > 0)$id = request_var('amp;torrent', '0');
		else
		$id		= request_var('torrent', '0');
		//die($id);
		if( !isset( $id ) || !is_numeric($id) )
			{
				bterror($user->lang['INVALID_ID']);
			}

        $password = request_var('password', '');
        $password = urldecode($password);

                $sql = "SELECT 
							password, 
							owner
						FROM 
							".$db_prefix."_torrents 
						WHERE 
							id = '".$id."' 
							AND 
							(password IS NULL 
								OR 
									password = '".$db->sql_escape($password)."') 
							LIMIT 
								1;";

                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) < 1)
				{
					$row = $db->sql_fetchrow($res);
					if ($row["password"] != "" AND !checkaccess("m_over_ride_password") AND $password != $row["password"] AND (!$user->user OR $user->id != $row["owner"]))
					{
                        $template->assign_vars(array(
                                'ACTION'         => 'error',
                                'S_ERROR_HEADER' => $user->lang['PASS_PROT'],
                                'S_ERROR_MESS'   => $user->lang['PASSWORD_REQ'],
                        ));

						echo $template->fetch('detail_ajax.html');
						close_out();
					}
				}

                $db->sql_freeresult($res);
        require_once ("imdb/imdb.class.php");
        $sql = "SELECT 
					imdb 
				FROM 
					".$db_prefix."_torrents 
				WHERE id = '".$id."'  LIMIT 1;";

		$res = $db->sql_query($sql) or btsqlerror($sql);
		$torrent = $db->sql_fetchrow($res);
		$db->sql_freeresult($res);
		if (can_download($user,$torrent)) {
        $can_access = true;
		} else {
        $can_access = false;
		}
                $thenumbers = ltrim(strrchr($torrent["imdb"],'tt'),'tt');
                $thenumbers = preg_replace("/[^A-Za-z0-9]/", "", $thenumbers);
                $movie = new imdb ($thenumbers);
				$release = $movie->release_date();
				$mpaa  =  $movie->mpaa();
				$movie->trailers();
				$trailers = $movie->trailers();
				//die($movie->trailers);
				$tags = $movie->taglines ();
				$director = $movie->director();
                $cast = $movie->cast();
                $write = $movie->writing();
                $gen = $movie->genres();
				$movie->photo_localurl();
				$template->assign_vars(array(
                        'ACTION'             => $op,
                        'IMDB_TITLE'         => $movie->title (),
                        'IMDB_YEAR'          => $movie->year (),
                        'IMDB_RUNTIME'       => $movie->runtime_all (),
                        'IMDB_TAGLINE'       => $movie->plotoutline (),
                        'MOVE_COMMENTS'      => $movie->comment (),
                        'IMDB_POSTER'        => $movie->main_photo,
                        'IMDB_COUNTRY'       => implode(",",$movie->country ()),
                        'IMDB_RELEASE_DATE'  => $release,
                        'IMDB_VOTES'         => $movie->votes (),
                        'IMDB_SCORE'         => $movie->rating (),
                        'IMDB_RATTING'       => $mpaa['USA'],
                        'IMDB_RATTING_LOWER' => strtolower($mpaa['USA']),
                        'IMDB_MPAA'          => implode(",",$movie->mpaa ()),
                        'IMDB_PLOT'          => implode(",",$movie->plot ()),
				));
				//print_r($movie->taglines ());
                foreach($movie->mpaa () as $key=>$val)
                {
                $template->assign_block_vars('mpaarate', array(
                    'RATING'        => $val,
                    'COUNTRY'       => $key,
                    'S_LAST_ROW'    => (($val == end($mpaa))? true : false),
                ));
                }

                for ($i = 0; $i  < count($tags); $i++) {
                $template->assign_block_vars('taglines', array(
                    'TAGS' => $tags[$i],
                ));
                }

                for ($i = 0; $i  < count($gen); $i++) {
                $template->assign_block_vars('genre', array(
                    'GENRE' => strip_tags($gen[$i]),
                ));
                }

                for ($i = 0; $i < count ($director); $i++) {
                $template->assign_block_vars('director', array(
                    'LINK' => $director[$i]["imdb"],
                    'NAME' => $director[$i]["name"],
                ));
                }

               for ($i = 0; $i < count ($cast); $i++) {
               if ($i > 9) {
                break;
               }

                $template->assign_block_vars('cast', array(
                        'IMAGE' => $cast[$i]["img"],
                        'LINK'  => $cast[$i]["imdb"],
                        'NAME'  => $cast[$i]["name"],
                        'ROLE'  => $cast[$i]["role"],
                ));
                }

                for ($i = 0; $i < count ($write); $i++) {
                $template->assign_block_vars('writers', array(
                        'LINK' => $write[$i]["imdb"],
                        'NAME' => $write[$i]["name"],
                        'ROLE' => $write[$i]["role"],
                ));
               }

				if (!empty($trailers))
				{
					for ($i=0;$i<count($trailers);++$i) {
						if ($i > 14) {
							break;
						}
						$template->assign_block_vars('trailers', array(
                            'LINK' => $trailers[$i],
						));
					}
				}

						echo $template->fetch('detail_ajax.html');
						close_out();
	}
?>