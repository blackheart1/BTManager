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
** File download.php 2018-02-17 14:32:00 Black_Heart
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
include_once("include/utf/utf_tools.php");
$template = new Template();
set_site_var($user->lang['DOWNLOAD']);
$id = request_var('id', 0);
$rsskey = request_var('rsskey', '');

if(!checkaccess("u_download")){
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['NOT_AUTH_DOWNLOAD'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}


function str_replcae_tracker($mystring)
{
	global $user, $site_announce, $export;
	$new_ann = $mystring;
	foreach($site_announce as $row)
	{
						$query_char = (strpos($row,"?")) ? "&" : "?";
						if ($user->passkey != "" AND !$export)$passkey = $query_char."passkey=".urlencode($user->passkey);
						else
						$passkey = "";
                       $pos = strpos($mystring, $row);
					   #echo $row;
                       if ($pos !== false)$new_ann = $row.$passkey;
	}
	#die($new_ann);
    				   return $new_ann;
}
function replace_content( &$node, $new_content )
{
    $dom = $node->owner_document();
    $kids = $node->child_nodes();
    foreach ( $kids as $kid )
        if ( $kid->node_type() == XML_TEXT_NODE )
            $node->remove_child ($kid);
    $node->set_content($new_content);
}
if (!isset($id) OR !is_numeric($id)) bterror($user->lang['INVALID_ID']);

$sql = "SELECT id, filename, name, owner, banned, password, ownertype, private, min_ratio, backup_tracker, tracker FROM ".$db_prefix."_torrents WHERE id = '".$id."' LIMIT 1;";
$res = $db->sql_query($sql);
$row = $db->sql_fetchrow($res);
if (!$row) { //Torrent not present
        header("HTTP/1.0 404 Not found");
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['NO_SUCH_TORRENT'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}

$row_id_torrent = $row["id"];
$row_filename = $row["filename"];
$row_name = $row["name"];
$row_owner = $row["owner"];
$row_banned = $row["banned"];
$row_password = $row["password"];
$row_backup_tracker = $row["backup_tracker"];
$row_tracker = $row["tracker"];
$row_owner_type = $row["ownertype"];
$row_private = $row["private"];
$row_min_ratio = number_format($row["min_ratio"],2);

$id_user = $user->id;
$name_user = $user->name;
if ($row_banned == "yes" AND !$user->moderator) { //Stealth for Banned Torrent if not admin
        header("HTTP/1.0 404 Not found");
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['NO_SUCH_TORRENT'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}

if ($download_level == "user" AND !$user->user) {
meta_refresh(0, $siteurl . "/login.php");
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['LOGIN_SITE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if ($download_level == "premium" AND !$user->premium) {
meta_refresh(3, $siteurl . "/login.php");
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['LOGIN_GROUP'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}

if (!$user->premium AND $row_password != "" AND $password != $row_password AND ($row_owner != $id_user OR $id_user == 0)) {
meta_refresh(3, $siteurl . "/details.php?id=".$row_id_torrent);
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['PASS_WORD_REQ'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}


$errmsg = Array();

if (!$user->premium AND $row_owner != $id_user AND $row_tracker == "") {
        #Global Tracker Rules first

        ##Number of seeds
        $seednsql = "SELECT COUNT(id) as seeded FROM ".$db_prefix."_peers WHERE ip = '".$_SERVER["REMOTE_ADDR"]."' AND seeder = 'yes';";
        $seednres = $db->sql_query($seednsql) or btsqlerror($seednsql);
        list ($seeded) = $db->fetch_array($seednres);
        if ($min_num_seed_e > 0 AND $seeded < $min_num_seed_e) $errmsg[] = sprintf($user->lang['ERROR_MINSEED'],$min_num_seed_e);

        ##Seed Size
        $seedsizesql = "SELECT SUM(size) as size FROM ".$db_prefix."_torrents, ".$db_prefix."_peers WHERE ".$db_prefix."_peers.torrent = ".$db_prefix."_torrents.id AND (".$db_prefix."_peers.real_ip = '".ip2long($_SERVER["REMOTE_ADDR"])."' OR ".$db_prefix."_peers.uid = '".$id_user."') AND ".$db_prefix."_peers.seeder = 'yes';";
        $seedsizeres = $db->sql_query($seedsizesql) or btsqlerror($seedsizesql);
        list ($seedsize) = $db->fetch_array($seedsizeres);
        if ($min_size_seed_e > 0 AND $seedsize < $min_num_seed_e) $errmsg[] = sprintf($user->lang['ERROR_MINSEEDSIZE'],mksize($min_size_seed_e));

        #Private Torrent check
        if ($download_level == "user" AND $torrent_global_privacy AND $row_owner_type != 2 AND count($errors) == 0 AND $row_private == "true") {
                $ratio_authorized = false; //ratio authorization success

                if ($row_min_ratio > 0) {
                        $ratiosql = "SELECT uploaded, downloaded FROM ".$db_prefix."_users WHERE id = '".$id_user."' LIMIT 1;";
                        $ratiores = $db->sql_query($sql) or btsqlerror($ratiosql);
                        list ($uploaded, $downloaded) = $db->fetch_array($ratiores);
                        if ($downloaded == 0) $ratio_authorized = true;
                        elseif (number_format($uploaded/$downloaded) >= $row_min_ratio) $ratio_authorized = true;
                }

                $sql_privacy = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$row_owner."' AND slave = '".$id_user."' LIMIT 1;";
                $sql_privacy_file = "SELECT status FROM ".$db_prefix."_privacy_file WHERE torrent = '".$row_id_torrent."' AND slave = '".$id_user."' LIMIT 1;";

                $privacy_res = $db->sql_query($sql_privacy);
                $file_res = $db->sql_query($sql_privacy_file);
                #Checking against blacklist
                if ($db->sql_numrows($privacy_res) == 1) { //Global authorization set, but dunno which
                        list ($status) = $db->fetch_array($privacy_res);
                        if ($status == "blacklist") $errmsg[] = $user->lang['ERROR_BLACK_LISTED']; //The user is completely blacklistes
                        //Else the user is granted to access and needs nothing more
                } elseif ($db->sql_numrows($file_res) == 1) { //File autorization requested, but with unknown response
                        list ($status) = $db->fetch_array($file_res);
                        if ($status == "pending") $errmsg[] = $user->lang['ERROR_PRIVATE_FILE']; //Owner has not responded yet
                        elseif ($status == "denied") $errmsg[] = $user->lang['ERROR_PRIVATE_DENIDE']; //Owner denied download
                } elseif (!$ratio_authorized) { //User has not requested Download Authorization and his ratio is not compliant. Error and authorization request.
                        $sql = "INSERT INTO ".$db_prefix."_privacy_file (master, slave, torrent) VALUES (".$row_owner.", ".$id_user.",".$row_id_torrent.");";
						require_once("include/class.email.php");
						include_once('include/function_messenger.php');
                        $db->sql_query($sql) or btsqlerror($sql);
                        $owner_sql = "SELECT username, language, email, user_notify_type, jabber FROM ".$db_prefix."_users WHERE id = '".$row_owner."' LIMIT 1;";
                        $owner_res = $db->sql_query($owner_sql) or btsqlerror($owner_sql);
                        list ($master_name, $master_language, $email_to, $method, $jabber) = $db->fetch_array($owner_res);
                        $db->sql_freeresult($owner_res);
						//$user->set_lang('download',$user->ulanguage);
                        if (empty($master_language) OR !file_exists("language/email/".$master_language."/authreq.txt")) $lang_email = $language;
                        else $lang_email = $master_language;
						$slave = $user->name;
						$messenger = new messenger();
						$messenger->template('authreq', $lang_email);
						$messenger->to($email_to, $master_name);
						$messenger->assign_vars(array(
									'SUB_JECT'				=>	sprintf($user->lang['AUTH_REQ_MAIL_SUB'],$sitename),
									'TOR_URL'				=>	$siteurl . '/mytorrents.php?op=displaytorrent&id=' . $id,
									'TOR_NAME'				=>	$row_name ,
									'MASTER'				=>	$master_name,
									'SLAVE'					=>	$slave,
									));
						$messenger->send($method);
						$messenger->save_queue();
                        $errmsg[] = $user->lang['ERROR_PRIVATE_REQ_SENT']; //Page will return error
                }
                $db->sql_freeresult($privacy_res);
                $db->sql_freeresult($file_res);
        }
}
if (count($errmsg) > 0) {
				$msg = '';
                $msg .= "<p>".$user->lang['ALERT_ERROR']."</p>\n";
                $msg .= "<ul>\n";
                foreach ($error as $msg) {
                        $msg .= "<li><p>".$msg."</p></li>\n";
                }
                $msg .= "</ul>\n";
        //bterror($errmsg,_btdownload);
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $msg,
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$fn = "$torrent_dir/".$row_id_torrent.".torrent";
if (!is_file($fn) OR !is_readable($fn)) {
        header("HTTP/1.0 500 Internal Server Error");
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['FILE_UNAVAILABLE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
if (!isset($export) OR $export == 0) $export = false;
else $export = true;
if ($torrent_prefix != "") $row_filename = $torrent_prefix." - ".$row_filename;
$row_filename .= ".torrent";
#Finally, everything is correct and download is ready!!!
header("Content-Type: application/x-bittorrent");
header("Cache-control: private");
header("Content-Disposition: attachment; filename=\"".$row_filename."\"");

        @require_once("include/bencoder.php");
        @require_once("include/bdecoder.php");
        $query_char = (strpos($announce_url,"?")) ? "&" : "?";
        //Patch Torrent
        $page = @file_get_contents($fn);
        $torrent = BDecode($page);
        unset($page);
        $neannounce = entry_read($torrent,"announce(String)");
        $new_ann = str_replcae_tracker($neannounce);
        $root = $torrent->first_child();
        $anns = $root->get_elements_by_tagname("announce");
        $ann = $anns[0];
        $ann->remove_child($ann->first_child());
        $ann->set_content($new_ann);
		//Patch Backup
		if(entry_exists($torrent,"announce-list(List)","Torrent"))
		{
        $anns = $root->get_elements_by_tagname("announce-list");
        $ann = $anns[0];
        $uploaded = $torrent->create_element("Item");
        $uploaded->set_attribute("type","List");
        $uploaded = $ann->append_child($uploaded);
        $trackers = Array();
        $to_check = Array();
        $announce_list = entry_read($torrent,"announce-list(List)");
        foreach ($announce_list as $group) {
                $trackers_in_group = Array();
                foreach ($group->child_nodes() as $tracker_node) {
                        $tracker = $tracker_node->get_content();
						replace_content( $tracker_node, str_replcae_tracker($tracker) );
                }

        }
		}
        $page = Bencode($torrent);
        unset($torrent, $root, $anns, $ann);

        #Writing to output
		$buffer = ob_get_clean();
		if (function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))
		ob_start('ob_gzhandler');
		else
        ob_start();
		ob_implicit_flush(0);
        echo $page;

        unset($page);


if (!$db->persistency) $db->sql_close();
die();
?>