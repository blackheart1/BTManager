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
** File details.php 2018-02-19 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/

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
include_once("include/utf/utf_tools.php");
$template = new Template();
$user->set_lang('details',$user->ulanguage);
define("AUTH_PENDING",0);
define("AUTH_GRANTED",1);
define("AUTH_DENIED",2);
define("AUTH_NONE",3);
$id					= (int)request_var('id', '0');
$password			= urldecode(request_var('password', ''));
$comm				= request_var('comm', '');
$op				= request_var('op', '');
$trig				= request_var('trig', '');
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

$sql = "SELECT A.id as id, A.exeem, A.seeders, A.leechers, A.tot_peer, A.speed, A.info_hash, A.filename, A.banned, A.nuked, A.nukereason, A.password, A.imdb, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(A.last_action) AS lastseed, A.numratings, A.name, IF(A.numratings < '".$minvotes."', NULL, ROUND(A.ratingsum / A.numratings, 1)) AS rating, A.save_as, A.descr, A.visible, A.size, A.plen, A.added, A.views, A.downloaded, A.completed, A.type, A.private, A.min_ratio, A.numfiles, A.owner, A.ownertype, A.complaints, A.evidence, A.tracker, A.tracker_list, A.dht as dht, A.md5sum as md5sum, A.uploader_host as user_host, B.name AS cat_name, IF(C.name IS NULL, C.username, C.name) as ownername, A.tracker_update, COUNT(S.status) as auths FROM ".$db_prefix."_torrents A LEFT JOIN ".$db_prefix."_categories B ON A.category = B.id LEFT JOIN ".$db_prefix."_users C ON A.owner = C.id LEFT JOIN ".$db_prefix."_privacy_file S ON S.torrent = A.id AND S.status = 'pending' WHERE A.id = '".$id."' LIMIT 1;";
$res = $db->sql_query($sql) or btsqlerror($sql);
$torrent = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
if (!$torrent OR ($torrent["banned"] == "yes" AND !$user->moderator))
	{
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										'S_FORWARD'			=> $siteurl.'/torrents.php',
								        'TITTLE_M'          => $user->lang['BT_ERROR'],
                                        'MESSAGE'           => $user->lang['NO_SUCH_TORRENT'] . back_link($siteurl.'/torrents.php'),
                                ));
		echo $template->fetch('message_body.html');
		close_out();
	}
set_site_var(sprintf($user->lang['TITTLE'],$torrent["name"]));
//If password is set, and user is not premium or owner, and if provided password is wrong, then give error
if ($torrent["password"] != "" AND !$user->premium AND $password != $torrent["password"] AND (!$user->user OR $user->id != $torrent["owner"])) {
        //Query user for Password
				$hidden = build_hidden_fields(array(
							'id'	=>	$id,
				));
                                $template->assign_vars(array(
										'S_LOGIN'			=> true,
										'U_ACTION'			=> 'details.php',
										'HIDDEN'			=> $hidden,
                                ));
        if ($password != "") { //Means that password is wrong
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
                                ));
        }
}
/*
A smart user would try to call upcomplete=1 to show the password link.
Password must be provided even after upload to show the link!!!
It is done automatically by the upload script
*/
if (($torrent["password"] == "" OR $password == $torrent["password"]) AND isset($upcomplete)) {
		$message = $user->lang['UPLOAD_SUCCESS'];

        if ($torrent["password"] != "") {
                $link = $siteurl."/details.php?id=".$id."&amp;password=".urlencode($torrent["password"]);
				$message .= sprintf($user->lang['UP_PASS_EXP'],htmlspecialchars($torrent["password"]),$link);
        }
		if (isset($upload_notice)) {
				$message .= $user->lang['HASH_CHANGE'];
		}
                                $template->assign_vars(array(
										'S_NOTICE'			=> true,
										'TITTLE_M'			=>	'UPLOAD_SUCCESS_ANN',
										'MESSAGE'			=>	$message,
                                ));
}

if ($user->user and isset($op)) {
        switch ($op) {
                case "seeder": {
                        if (!$torrent["tracker"] == "") break;
                        if ($trig == "on") {
                                $db->sql_query("INSERT INTO ".$db_prefix."_seeder_notify (torrent, user) VALUES ('".$id."','".$user->id."');");
                        } elseif ($trig == "off") {
						//die($torrent["tracker"]);
                                $db->sql_query("DELETE FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$id."' AND user = '".$user->id."';");
                        }

                        break;
                }
                case "comment": {
                        if ($trig == "on" AND $user->user) {
                                $db->sql_query("INSERT INTO ".$db_prefix."_comments_notify (torrent, user) VALUES ('".$id."','".$user->id."');");
                        } elseif ($trig == "off" AND $user->user) {
                                $db->sql_query("DELETE FROM ".$db_prefix."_comments_notify WHERE torrent = '".$id."' AND user = '".$user->id."';");
                        }
                        break;
                }
                case "authorization": {
                        if (!$torrent_global_privacy) break;
                        if ($torrent["ownertype"] == 2 OR $torrent["owner"] == $user->id OR $torrent["tracker"] != "") break;
                        if ($torrent["ownertype"] != 2) {
                                $sql = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$user->id."' LIMIT 1;";
                                $res = $db->sql_query($sql) or btsqlerror($sql);
                                if ($db->sql_numrows($res) == 1) {
                                        $db->sql_freeresult($res);
                                        break;
                                }
                        }
                        if (!$db->sql_query("INSERT INTO ".$db_prefix."_privacy_file (master, slave, torrent) VALUES (".$torrent["owner"].", ".$user->id.",".$id.");")) break;
						include_once('include/function_messenger.php');
						$slave = getusername($btuser);
                        $owner_res = $db->sql_query("SELECT username, language, email, user_notify_type, jabber FROM ".$db_prefix."_users WHERE id = '".$torrent["owner"]."' LIMIT 1");
                        list ($master_name, $master_language, $email_to, $method, $jabber) = $db->fetch_array($owner_res);
                        $db->sql_freeresult($owner_res);
                        if (!$master_language OR !file_exists("language/email/".$master_language."/authreq.txt")) $lang_email = $language;
                        else $lang_email = $master_language;
						$slave = $user->name;
						$messenger = new messenger();
						$messenger->template('authreq', $lang_email);
						$messenger->to($email_to, $master_name);
						$messenger->assign_vars(array(
									'SUB_JECT'				=>	sprintf($user->lang['AUTH_REQ_MAIL_SUB'],$sitename),
									'TOR_URL'				=>	$siteurl . '/mytorrents.php?op=displaytorrent&id=' . $id,
									'TOR_NAME'				=>	$torrent["name"] ,
									'MASTER'				=>	$master_name,
									'SLAVE'					=>	$slave,
									));
						$messenger->send($method);
						$messenger->save_queue();
                        break;
                }
        }
}


//$db->sql_query("UPDATE ".$db_prefix."_seeder_notify SET status = 'active' WHERE torrent = '".$id."' AND user = '".$user->id."';");
//$db->sql_query("UPDATE ".$db_prefix."_comments_notify SET status = 'active' WHERE torrent = '".$id."' AND user = '".$user->id."';");

if (isset($hit)) {
        $sqlupdate = "UPDATE ".$db_prefix."_torrents SET views = views + 1 WHERE id = '".$id."';";
        $db->sql_query($sqlupdate) or btsqlerror($sqlupdate);
}
if (can_download($user,$torrent)) {
        $can_access = true;
} else {
        $can_access = false;
}
$infohash_hex = preg_replace_callback('/./s', "hex_esc", str_pad($torrent["info_hash"],20));
if ($torrent["type"] != "link") {
	if ($torrent["tracker"] == "")
	{
		$complsql = "SELECT SUM(T.size-P.to_go)/(COUNT(P.id)*T.size) as complete FROM ".$db_prefix."_torrents T, ".$db_prefix."_peers P WHERE T.id = '".$id."' AND P.torrent = '".$id."';";
		$complres = $db->sql_query($complsql) or bterror($complsql);
		list ($completepercent) = $db->fetch_array($complres);
		$db->sql_freeresult($complres);
		if ($torrent["leechers"] > 0 AND $torrent["speed"] > 0)
		{
			$ro = $torrent["seeders"]/$torrent["leechers"];
			$speed_leech = ($ro == 0) ? round($torrent["speed"]/$torrent["leechers"]) : min($torrent["speed"],round($torrent["speed"]*$ro));
			$edt_m = ($torrent["size"] / $speed_leech)/60; //to minutes
			$edt = ($edt_m % 60)."m"; //minutes
			$edt_h = floor($edt_m / 60);
			if ($edt_h>0) $edt = $edt_h."h ".$edt;
			$speed_leech = mksize($speed_leech)."/s";
		}
		else
		{
			$speed_leech = "--";
			$edt = "--";
		}
	}
}
if($comm == ':thankyou:' OR $comm == 'startcomments'){
	$jload = 'view_coments_page';
}elseif($comm == 'imdb'){
	$jload = 'get_imdb';
}else{
	$jload = 'view_details_page';
}
$notify_seeder = $notify_coment = '';
if ($user->user AND $torrent["type"] != "link") {
        #Seeder Notification
        if ($torrent["tracker"] == "") {
                $sql = "SELECT * FROM ".$db_prefix."_comments_notify WHERE torrent = '".$torrent["id"]."' AND user = '".$user->id."';";
                $res = $db->sql_query($sql);
                if ($db->sql_numrows($res) == 1) {
                        $notify_coment = sprintf($user->lang['NOTIFY_COMMENTS_REMOVE'],$torrent["id"]);
                } else {
                        $notify_coment = sprintf($user->lang['NOTIFY_COMMENTS'],$torrent["id"]);
                }
        $db->sql_freeresult($res);
        }
		unset($res);
        #Comment notification
        $sql = "SELECT * FROM ".$db_prefix."_seeder_notify WHERE torrent = '".$torrent["id"]."' AND user = '".$user->id."';";
        $res = $db->sql_query($sql);
		$cres = $db->sql_fetchrow($res);
        if ($cres['status'] AND $cres['status'] == 'active') {
                        $notify_seeder = sprintf($user->lang['NOTIFY_SEEDERS_REMOVE'],$torrent["id"]);
        } else {
                        $notify_seeder = sprintf($user->lang['NOTIFY_SEEDERS'],$torrent["id"]);
        }
        $db->sql_freeresult($res);

}
$java_link = '&torrent=' . $id . (($password)? '&password=' . $password : '');
$template->assign_vars(array(
        'U_ID'					=>	$id,
		'U_PASSWORD'			=>	($password)? '&password=' . $password : '',
		'U_CAN_BOOK'			=>	($user->user AND $torrent["type"] != "link")? true : false,
		'U_DETAIL_LINK'			=>	'op=view_details_page' . $java_link,
        'U_NFO_LINK'			=>	(@is_readable($torrent_dir."/".$id.".nfo"))?'op=view_nfo_page' . $java_link : false,
        'U_IMDB_LINK'			=>	($torrent["imdb"] != "")?'op=get_imdb' . $java_link : false,
        'U_RATING_LINK'			=>	'op=view_rate_page' . $java_link,
        'U_COMM_LINK'			=>	'op=view_coments_page' . $java_link,
        'U_PEERS_LINK'			=>	(checkaccess('u_can_view_snatchlist') AND $torrent["tracker"] == "" AND $torrent["type"] != "link" AND $user->user)?'op=view_peers_page' . $java_link : false,
		'U_SEEDERS'				=>	($torrent["type"] != "link")?$torrent["seeders"] : false,
		'U_LEECHERS'			=>	($torrent["type"] != "link")?$torrent["leechers"] : false,
		'U_PEERS'				=>	($torrent["type"] != "link")?$torrent["tot_peer"] : false,
		'U_COMPLETED'			=>	($torrent["type"] != "link")? sprintf("%.2f%%", $completepercent * 100) : false,
		'U_DOWNLOAD_TIME'		=>	($torrent["type"] != "link")? $edt : false,
		'U_DOWNLOAD_SPEED'		=>	($torrent["type"] != "link")? $speed_leech : false,
		'U_J_LOAD'				=>	$jload,
		'U_NOTIFY_SEEDER'		=>	$notify_seeder,
		'U_NOTIFY_COMMENT'		=>	$notify_coment,
		'META'					=>	'<script type="text/javascript" src="bbcode.js"></script>'
));
if($comm == ':thankyou:' OR $comm == 'startcomments'){
	$jload = 'view_coments_page';
}elseif($comm == 'imdb'){
	$jload = 'get_imdb';
}else{
	$jload = 'view_details_page';
}
	echo $template->fetch('details.html');
	close_out();
?>