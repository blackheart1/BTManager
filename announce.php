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
** File announce.php 2018-02-19 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
@error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE)); //We don't get stupid messages
#Stop from Including this file
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
$agent = $_SERVER['HTTP_USER_AGENT'];
#stop Broswer use
if (preg_match("/(Mozilla|Opera|Lynx|Netscape|Links)$/", $agent) || 
    isset($_SERVER['HTTP_COOKIE']) || 
    isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) || 
    isset($_SERVER['HTTP_ACCEPT_CHARSET']))
 {
                header("HTTP/1.0 401 Access Denied");
        die("<html><head><title>Error!</title></head><body><h3>Sorry, but this file is not suitable for browsers.</h3></body></html>");
}
#include Basic Configs
$phpEx = 'php';
require_once("include/config_lite.php");
include_once("include/utf/utf_tools.php");
include_once('include/auth.php');
require_once'include/class.cache.php';
$debug = false; //Enable to get mailed the full response. Useful if you don't have Ethereal
$user->set_lang('common',$user->ulanguage);
#Clear any unwanted blank spaces
if (extension_loaded('zlib')){ ob_end_clean();}
if (function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))
	ob_start('ob_gzhandler');
else
	ob_start();
ob_implicit_flush(0);

#Make sure local tracker is active
if ($stealthmode) die();
#create Basic Functions
function hash_where($name, $hash) 
{
	global $db, $phpEx;
        $shhash = preg_replace('/ *$/s', "", $hash);
		$utf_hash = utf8_encode($hash);
		$utf_clean = utf8_clean_string($hash);
	return "($name = '" . $db->sql_escape($utf_clean) . "'
			 OR $name = '" . $db->sql_escape($shhash) . "' 
			 OR $name = '" . $db->sql_escape($utf_hash) . "')";
}

function unesc_magic($x) {
        return (get_magic_quotes_gpc()) ? stripslashes($x) : $x;
}
function err($msg, $sqlerror = false)
{
	if($sqlerror) $msg = $msg . '  ' . $sqlerror['message'];
	add_log('admin','LOG_ANNOUNCE',$msg);
   benc_resp(array("failure reason" => array('type' => "string", 'value' => $msg)));
   exit();
}
function benc_str($s) {
   return strlen($s) . ":$s";
}
function benc_resp($d)
{
   benc_resp_raw(benc(array('type' => "dictionary", 'value' => $d)));
}
function benc_int($i) {
return "i" . $i . "e";
}
function benc_list($a) {
$s = "l";
foreach ($a as $e) {
$s .= benc($e);
}
$s .= "e";
return $s;
}
function benc($obj) {
if (!is_array($obj) || !isset($obj["type"]) || !isset($obj["value"]))
return;
$c = $obj["value"];
switch ($obj["type"]) {
      case "string":
         return benc_str($c);
      case "integer":
         return benc_int($c);
      case "list":
         return benc_list($c);
      case "dictionary":
         return benc_dict($c);
      default:
         return;
   }
}
function benc_dict($d) {
   $s = "d";
   $keys = array_keys($d);
   sort($keys);
   foreach ($keys as $k) {
      $v = $d[$k];
      $s .= benc_str($k);
      $s .= benc($v);
   }
   $s .= "e";
   return $s;
}
function benc_resp_raw($x){
	header("Content-Type: text/plain");
	header("Pragma: no-cache");
	print($x);
}
function GetUserAgent($pid) {
        $strAgent = "Unknown";
        $strversion = "";
        $http = false;


        if ($pid[0] == "-" AND $pid[7] == "-") { //Azureus Convention
                $ltrs = $pid[1].$pid[2];
                $strversion = sprintf("%s.%s.%s.%s", $pid[3], $pid[4], $pid[5], $pid[6]);
                if ($ltrs == "AZ") { $strAgent = "Azureus"; $http = true;}
                elseif ($ltrs == "UT") { $strAgent = "&micro;Torrent"; $http = true;}
                elseif ($ltrs == "MT") $strAgent = "MoonlightTorrent";
                elseif ($ltrs == "LT") $strAgent = "libtorrent";
                elseif ($ltrs == "BX") $strAgent = "Bittorrent X";
                elseif ($ltrs == "TS") $strAgent = "Torrentstorm";
                elseif ($ltrs == "SS") $strAgent = "Swarmscope";
                elseif ($ltrs == "XT") $strAgent = "XanTorrent";
                elseif ($ltrs == "BB") $strAgent = "BitBuddy";
                elseif ($ltrs == "TN") $strAgent = "TorrentDOTnet";
				elseif ($ltrs == "BC") $strAgent = "BitComet";
                //else; Unknown client using this naming.
        } elseif ($pid[4] == '-' AND $pid[5] == '-' AND $pid[6] == '-' AND $pid[7] == '-' ) {
                $strversion = sprintf(" %i%i%i", $pid[1] - '0', $pid[2] - '0', $pid[3] - '0' );
                if ($pid[0] == 'A') $strAgent = "ABC";
                elseif ($pid[0] == 'S') $strAgent = "Shadow";
                elseif ($pid[0] == 'T') $strAgent = "BitTornado";
                elseif ($pid[0] == 'U') $strAgent = "UPnP NAT BT";
                //else; Unknown client using this naming.
        }
        return Array($strAgent, $strversion, $http);
}
//GET DETAILS OF PEERS ANNOUNCE
$req = "info_hash:peer_id:!ip:port:uploaded:downloaded:left:!event:!key:!compact:!no_peer_id:!passkey";
$passkey = request_var('passkey', '',true);
$info_hash = $GLOBALS['_REQUEST']['info_hash'];
$peer_id = $GLOBALS['_REQUEST']['peer_id'];
$ip = request_var('ip', getip());
$port = request_var('port', 0);
$uploaded = request_var('uploaded', 0.0);
if(isset($GLOBALS['_REQUEST']['uploaded']) AND is_numeric($uploaded) AND $uploaded == 0)$uploaded = '0';
$downloaded = request_var('downloaded', 0.0);
if(isset($GLOBALS['_REQUEST']['downloaded']) AND is_numeric($downloaded) AND $downloaded == 0)$downloaded = '0';
$left = request_var('left', 0.0);
if(isset($GLOBALS['_REQUEST']['left']) AND is_numeric($left) AND $left == 0)$left = '0';
$event = request_var('event', '');
$key = request_var('key', '',true);
$compact = request_var('compact', '',true);
$no_peer_id = request_var('no_peer_id', '');
//CLEAN UP PASSKEY
if (strpos($passkey, "?"))
{
  $tmp = substr($passkey , strpos($passkey , "?"));
  $passkey  = substr($passkey , 0,strpos($passkey , "?"));
  $tmpname = substr($tmp, 1, strpos($tmp, "=")-1);
  $tmpvalue = substr($tmp, strpos($tmp, "=")+1);
  $$tmpname = $tmpvalue;
}
//vERIFY NEEDED DATA
foreach (explode(":", $req) as $x) {

        if ($x[0] == "!") {
                $x = substr($x, 1);
                $opt = true;
        }
        else
                $opt = false;
				if($x == 'port')$dev = 0;
				elseif($x == 'downloaded')$dev = 0;
				elseif($x == 'uploaded')$dev = 0;
				elseif($x == 'left')$dev = 0;
				else $dev = '';
			$$x = $$x;
        if (!isset($$x) or $$x == '') {
                if (!$opt) err("missing key " . $x . ' ' . $$x);
                else $$x = "";
                continue;
        }
        $$x = unesc_magic($$x);
}
//CHECK FOR INFO HASH AND PEER ID AND CONFERM THEY ARE PROPERLY FORMATED
foreach (array("info_hash","peer_id") as $x) {
        if (strlen($$x) != 20)
                err("invalid $x (" . strlen($$x) . " - " . urlencode($$x) . ")");
}

$port = 0 + $port;
$downloaded = 0 + $downloaded;
$uploaded = 0 + $uploaded;
$left = 0 + $left;
//GET USER IP
$ip = $real_ip = getip();
		if($ip == "0.0.0.0")err("Bad Ip report");
else $ip = sprintf("%u",ip2long($ip));
#make sure Ip is not banned
$sql = "SELECT  ipstart, ban_exclude, ban_give_reason AS reason, ban_end FROM ".$db_prefix."_bans
              WHERE ban_email = ''
              AND (ban_userid = 0
              OR ban_exclude = 0);";
$ban_res = $db->sql_query($sql) or err("SQL Error: ".$sql ,$db->sql_error());
if ($db->sql_numrows($ban_res) >= 1) {
         while ($row = $db->sql_fetchrow($ban_res))
        {
            $ip_banned = false;

            if (!empty($row['ipstart']))
            {
                $ip_banned = preg_match('#^' . str_replace('\*', '.*?', preg_quote($row['ipstart'], '#')) . '$#i', getip());

                if ($row['ban_exclude'] == 1) $ip_banned = false;
            }

            $reason = $row['reason'];

            if ($ip_banned) err("You are banned from this tracker. Reason: ".$reason);
        }
}
$db->sql_freeresult($ban_res);
//IF FORCED PASSKEY IS SET CONFERM IT IS HERE
if ($force_passkey AND $passkey == "") err("Only users with Passkey are allowed to use our tracker.");

if ($passkey != "") {
        //Passkey authentication comes first
        $sql_where = "passkey = '".urldecode($passkey)."' ";
} elseif (array_key_exists("PHP_AUTH_USER",$_SERVER) AND array_key_exists("PHP_AUTH_PW",$_SERVER)) {
        //HTTP authentication has yeld over IP authentication
        $sql_where = "username = '".addslashes($_SERVER["PHP_AUTH_USER"])."' AND password = '".md5($_SERVER["PHP_AUTH_PW"])."'";
} else {
        $sql_where = "lastip = '".$ip."' OR seedbox = '".$ip."' ";
}
//GET THE USERS INFO
$user_sql = "SELECT id, username, password, act_key, level, uploaded, downloaded, ban, banreason, can_do, dongift, parked, disabled, disabled_reason FROM ".$db_prefix."_users WHERE ".$sql_where." ORDER BY lastlogin DESC LIMIT 1;";
if (!$userres = $db->sql_query($user_sql)) err("SQL Error: ". $user_sql ,$db->sql_error());
if ($userrow = $db->sql_fetchrow($userres)) {
        $uid = $userrow["id"];
		$usergift = $userrow['dongift'];
        $ulevel = $userrow["level"];
		$cookiedata = array($userrow["id"],addslashes($userrow["username"]),$userrow["password"],$userrow["act_key"]);
		$user = cookie_encode($cookiedata);
		$user = @new User($user);
		$auth = new auth();
		$auth->acl($user);
		if(!$auth->acl_get('u_download_torrents')){
			err("You are not allowed to Access this Download");
		}
} else {
	//REJECR INVALED PASSKEY
        if ($passkey != "") err("Invalid Passkey. It may have been renewed.");
        $uid = 0;
        $ulevel = "guest";
}
$db->sql_freeresult($userres);
if($userrow["parked"] == 'true')
{
	err('Your account is Parked');
}
if($userrow["disabled"] == 'true')
{
	err('Your account has been Disabled Reason Given is ' . $userrow["disabled_reason"]);
}
# Check If Client is banned
                        $sql = "SELECT client, reason FROM ".$db_prefix."_client_ban";
                        $res = $db->sql_query($sql);
                        while ($banedclient = $db->sql_fetchrow($res)){
                        if (strpos($peer_id,$banedclient['client'])) err($banedclient['reason']);
						}
                        $db->sql_freeresult($res);
/* CLIENT INFORMATION */

# Check If User is banned
if($userrow['ban'] == 1)err('You are banned on this site for '.$userrow['banreason']);

/* CLIENT INFORMATION */
list ($client, $clientversion, $http_auth) = GetUserAgent($peer_id);
if ($client == "Unknown") $client = "NULL";
else $client = "'".$client."'";

/* SHOULD GIVE HTTP ERROR ONLY IF CLIENT IS KNOWN TO SUPPORT HTTP AUTHENTICATION */
if ($announce_level == "user" AND $uid == 0) {
        //If client supports HTTP Authentication, we perform that
        if ($http_auth) {
                header("WWW-Authenticate: Basic realm=\"".$sitename."\"");
                header('HTTP/1.0 401 Unauthorized');
        }
        err("Only registered users are allowed to use our tracker");
}

$port = intval($port);
if (!is_numeric($downloaded)) err("Downloaded size must be numeric");
if (!is_numeric($uploaded)) err("Uploaded size must be numeric");
if (!is_numeric($left)) err("Left size must be numeric");

$rsize = 50;
foreach(array("num want", "numwant", "num_want") as $k) {
        if (isset($$k) AND $$k<50) {
                $rsize = intval($$k);
                break;
        }
}

if (!$port OR $port > 0xffff)
        err("Invalid port");

if (!isset($event))
        $event = "";
$seeder = ($left == 0 OR $event == "completed") ? "yes" : "no";
$sql_select = "SELECT id, name, added, seeders, ownertype, private, owner, leechers , completed, category, ratiobuild, size,  UNIX_TIMESTAMP(added) AS ts FROM ".$db_prefix."_torrents WHERE banned = 'no' AND " . hash_where("info_hash", $info_hash)." LIMIT 1;";
$res = $db->sql_query($sql_select) or err("SQL Error = ".$sql_select, $db->sql_error());

if ($db->sql_numrows($res) < 1) err("Torrent not registered with this tracker.");
$torrent = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
$torrentadded = $torrent["added"];
$tadded = $torrent["ts"];
$torrentid = $torrent["id"];
$torrentname = $torrent["name"];
$seeders = $torrent["seeders"];
$leechers = $torrent["leechers"];
$completed = $torrent["completed"];
$ratiobuild = $torrent["ratiobuild"];
$torrentcategory = $torrent["category"];
$size = $torrent['size'];
//CONFERM WAIT TIME
   if ($wait_time){
      if ($left > 0 && $userrow["level"] == "user")
         {
            $gigs = $userrow["uploaded"] / (1024*1024*1024);
            $elapsed = floor((strtotime(gmdate("Y-m-d H:i:s")) - $tadded) / 3600);
            if ($userrow['downloaded'] == 0) $ratio = 0;
            else
            $ratio = (($userrow["downloaded"] > 0) ? ($userrow["uploaded"] / $userrow["downloaded"]) : 1);
            if ($ratio == 0 && $gigs == 0) $wait = 24+4;
            elseif ($ratio < $RATIOA || $gigs < $GIGSA) $wait = $WAITA+4;
            elseif ($ratio < $RATIOB || $gigs < $GIGSB) $wait = $WAITB+4;
            elseif ($ratio < $RATIOC || $gigs < $GIGSC) $wait = $WAITC+4;
            elseif ($ratio < $RATIOD || $gigs < $GIGSD) $wait = $WAITD+4;
            else $wait = 0;
         if ($wait)
         if ($elapsed < $wait)
            err("Not authorized Most Wait(" . ($wait - $elapsed) . "h) - READ THE FAQ! $siteurl/faq.php#69");
         }
   }
unset($sql_select, $res, $torrent);
if(isset($compact) AND $compact ==1)$compact = true;
else
$compact = false;

$seedwhere = "";
//BUILD PEER LIST FOR CLIENT
if(!$compact){
$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e". benc_str("complete") . "i" . $seeders . "e" . benc_str("incomplete") . "i" . $leechers . "e" . benc_str("downloaded") . "i" . $completed . "e" . benc_str('size') . "i" . $size . "e" . benc_str("private") . 'i1e' . benc_str("peers") . "le" . benc_str("min interval") . "i" . $announce_interval_min . "e";
if (!empty($announce_text)) $resp .= "15:warning message". strlen($announce_text) .":". $announce_text;
}else{
$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e". benc_str("complete") . "i" . $seeders . "e" . benc_str("incomplete") . "i" . $leechers . "e" . benc_str("downloaded") . "i" . $completed . "e" . benc_str('size') . "i" . $size . "e" . benc_str("min interval") . "i" . $announce_interval_min . "e";
if (!empty($announce_text)) $resp .= "15:warning message". strlen($announce_text) .":". $announce_text;
}

if ($event != "stopped") {
        $sql_select = "SELECT seeder, peer_id, unique_id, ip, port FROM ".$db_prefix."_peers WHERE torrent = '".$torrentid."' ".$seedwhere." ORDER BY RAND() LIMIT ".$rsize.";";
        $res = $db->sql_query($sql_select) or err("SQL Error = ".$sql_select,$db->sql_error());
        unset($seedwhere, $rsize);
if(!$compact){
                $resp .= benc_str("peers")."l";
                while ($row = $db->sql_fetchrow($res)) {
						#Skip user
                        if ($row["peer_id"] === utf8_clean_string($peer_id)) {
                                continue;
                        }
   				$resp .= "d" .
      			benc_str("ip") . benc_str(long2ip($row["ip"])) .
      			benc_str("peer id") . benc_str(stripslashes($row["peer_id"])) .
      			benc_str("port") . "i" . $row["port"] . "e" .
      			"e";
                }
} else {
                $peers = "";
               while ($row = $db->sql_fetchrow($res)) {
                        $peers .= pack("Nn", sprintf("%d",$row["ip"]), $row["port"]);
                }
					$resp .= benc_str("peers") . strlen($peers).":".$peers;

}
        $db->sql_freeresult($res);

}
$resp .= "ee";
                unset($row, $sql_select, $res);
        $shhash = preg_replace('/ *$/s', "", $key);
		$utf_hash = utf8_encode($key);
		$utf_clean = utf8_clean_string($key);
        $shhasha = preg_replace('/ *$/s', "", $peer_id);
		$utf_hasha = utf8_encode($peer_id);
		$utf_cleana = utf8_clean_string($peer_id);
	$where = "(P.unique_id = '" . $db->sql_escape($utf_clean) . "'
			 OR P.unique_id = '" . $db->sql_escape($shhash) . "' 
			 OR P.unique_id = '" . $db->sql_escape($utf_hash) . "'
			 OR P.peer_id = '" . $db->sql_escape($utf_cleana) . "'
			 OR P.peer_id = '" . $db->sql_escape($shhasha) . "' 
			 OR P.peer_id = '" . $db->sql_escape($utf_hasha) . "')";


$where = "P.torrent = '" . $torrentid . "' AND " . $where;
$selfwhere = $where;
unset($self);
$sql_select = "SELECT P.seeder, P.peer_id, P.unique_id, P.uid, P.ip, P.real_ip, P.port, P.uploaded, P.downloaded, P.upload_speed, UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(P.last_action) as seconds, U.level FROM ".$db_prefix."_peers P LEFT JOIN ".$db_prefix."_users U ON P.uid = U.id WHERE ".$selfwhere.";";
if (!$res = $db->sql_query($sql_select)) err("Error ",$db->sql_error());
$self = $db->sql_fetchrow($res);
$db->sql_freeresult($res);
$selfupload = 0+$self['uploaded'];
$selfdownloaded = 0+$self['downloaded'];
$selfrealip = $self['real_ip'];
unset($sql, $res);
$updateset = Array();
$stoppeer = false;
// EVENT TEST
if ($event == "stopped") {
      //UPDATE SNATCHED 

        $sql="UPDATE ".$db_prefix."_snatched SET seeder = 'no', connectable='no' WHERE torrent = $torrentid AND userid = ".$uid.";";
        $db->sql_query($sql) or err("SQL Error = ".$sql,$db->sql_error());
      	unset($sql);
        $sql_delete = "DELETE FROM ".$db_prefix."_peers WHERE torrent = '".$torrentid."' AND ".hash_where("peer_id", $peer_id).";";
        $db->sql_query($sql_delete) or err("SQL Error: ".$sql_delete,$db->sql_error());
        if ($db->sql_affectedrows() > 0) {
        $hitrun = (($torrentadded > get_date_time(gmtime() - 10800) && ($downloaded / 2) > $uploaded) ? "IF(hitrun = '0000-00-00 00:00:00', '".get_date_time()."', hitrun)" : "hitrun");
       //$db->sql_query("UPDATE ".$db_prefix."_snatched SET  ip = '".$ip."', port = $port, agent= '".$agent.$clientversion."', last_action = '".get_date_time()."', hitrun = $hitrun WHERE torrentid = $torrentid AND userid = $uid") or err(mysql_error());		
                if ($self["seeder"] == "yes")
                        $updateset[] = "seeders = if(`seeders` > 0,`seeders` - 1, `seeders`)";
                else
                        $updateset[] = "leechers = if(`leechers` > 0,`leechers` - 1, `leechers`)";

                $updateset[] = "tot_peer = if(`tot_peer` > 0,`tot_peer` - 1, `tot_peer`)";
                $updateset[] = "speed = speed - '".$self["upload_speed"]."'";
        }
        unset($sql_delete);
		$stoppeer = true;
}
elseif($event == "completed")
{
        if ($uid != 0) {
			$sql="UPDATE ".$db_prefix."_snatched SET  finished  = 'yes', completedat = NOW() WHERE torrent = $torrentid AND userid = ".$uid.";";
			$db->sql_query($sql);
			unset($sql);
			$sql = "INSERT INTO ".$db_prefix."_download_completed ( user , torrent , completed ) VALUES ('".$uid."', '".$torrentid."', NOW());";
			$db->sql_query($sql);
			unset($sql);
        }
        require_once("include/class.email.php");
        require_once("include/utf/utf_tools.php");
		$user->set_lang('download',$user->ulanguage);
		$data = @file_get_contents('language/email/' . $language . '/seednotif.txt');
		eval('$data = "' . $data . '";');
		$e_message = wordwrap(utf8_wordwrap($data), 70, "\r\n", true);
        $sql_trigger = "SELECT U.email FROM ".$db_prefix."_users U, ".$db_prefix."_seeder_notify S WHERE S.torrent = '".$torrentid."' AND S.user = U.id AND S.status = 'active';";
        $res_trigger = $db->sql_query($sql_trigger) or err("Error SQL = ".$sql_trigger,$db->sql_error());
        $notify_mail = New eMail();
        $notify_mail->sender = $admin_email;
        $notify_mail->subject = sprintf($user->lang['MAIL_NEWSEEDER'],$sitename);
        $notify_mail->body = $e_message;
        while ($row_trigger = $db->sql_fetchrow($res_trigger)) {
                $notify_mail->Add($row_trigger["email"]);
        }
        $notify_mail->Send();
        $db->sql_freeresult($res_trigger);
        unset($res_trigger, $sql_trigger);

        $sql_update = "UPDATE ".$db_prefix."_seeder_notify SET status = 'stopped' WHERE torrent = '".$torrentid."';";
        $db->sql_query($sql_update) or err("SQL Error: ".$sql_update,$db->sql_error());
        unset($sql_update);
        $updateset[] = "completed = completed + 1";
        $updateset[] = "seeders = seeders + 1";
        $updateset[] = "leechers = if(leechers > 0,leechers - 1, leechers)";
}

/* IF NOT SEEDER OR PREMIUM, CHECK AGAINST REQUIREMENTS */
if ($announce_level == "user" AND $ulevel == "user" AND $seeder == "no" AND $event != "stopped")
{
        $torrentsql = "SELECT * FROM ".$db_prefix."_torrents WHERE id = '".$torrentid."' LIMIT 1;";
        $torrentres = $db->sql_query($torrentsql);
        $torrent = $db->sql_fetchrow($torrentres);
        $db->sql_freeresult($torrentres);
        unset($torrentsql, $torrentres);

        $ratiosql = "SELECT uploaded, downloaded FROM ".$db_prefix."_users WHERE id = '".$uid."' LIMIT 1;";
        $ratiores = $db->sql_query($ratiosql) or err("SQL Error: ".$ratiosql,$db->sql_error());
        list ($useruploaded, $userdownloaded) = $db->fetch_array($ratiores);

        if ($global_min_ratio > 0 AND $userdownloaded > 0) {
                if (number_format($useruploaded/$userdownloaded,2) < $global_min_ratio) err("You need a ratio of at least ".$global_min_ratio." to proceed with download. Seed more files to let your ratio raise!");
        }

        $check_seed = true; // false = trigger found
        $check_leech = true;// false = trigger found

        #Global Privacy Check
        if ($torrent_global_privacy AND $torrent["ownertype"] != 2 AND $torrent["private"] == "true" AND $torrent["owner"] != $uid ) {
                $authorized = false;
                $found = false;

                $globalauthqry = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$uid."' LIMIT 1;";
                $globalauthres = $db->sql_query($globalauthqry) or err("SQL Error: ".$globalauthsql,$db->sql_error());
                unset($globalauthqry);
                if ($db->sql_numrows($globalauthres) == 1) {
                        list ($globalauthstatus) = $db->fetch_array($globalauthres);

                        $found = true;
                        if ($globalauthstatus = "whitelist") $authorized = true;
                        unset($globalauthstatus, $globalauthres);
                } else {
                        $torrentauthsql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE master = '".$torrent["owner"]."' AND torrent = '".$torrentid."' LIMIT 1;";
                        $torrentauthres = $db->sql_query($torrentauthsql) or err("SQL Error: ".$torrentauthsql,$db->sql_error());
                        if ($db->sql_numrows($torrentauthres) == 1) {
                                list ($torrentauthstatus) = $db->fetch_array($torrentauthres);
                                $found = true;
                                if ($torrentauthstatus == "granted") $authorized = true;
                                unset($torrentauthstatus);
                        }
                        $db->sql_freeresult($torrentauthres);
                        unset($torrentauthsql, $torrentauthres);
                }
                $db->sql_freeresult($globalauthres);
                if (!$found) { //If we are not sure that the user is denied from downloading
                        $min_ratio = number_format($torrent["min_ratio"], 2);
                        if ($min_ratio > 0) {
                                if ($userdownloaded == 0) $authorized = true;
                                elseif (number_format($useruploaded/$userdownloaded) > $min_ratio) $authorized = true;
                                unset($useruploaded, $userdownloaded);
                        }
                }
                unset($found);

                if (!$authorized) err("You are not authorized to download this Torrent. Check your requirements on the Tracker page");
        }
        unset($authorized, $torrent);

        $sql_trigger = "SELECT count(A.seeder) AS tot_seeder_files, A.seeder AS seed, SUM(B.size) AS tot_size, U.level as level FROM ".$db_prefix."_peers A LEFT JOIN ".$db_prefix."_users U ON U.id = '".$uid."', ".$db_prefix."_torrents B WHERE A.uid = '".$uid."' AND A.torrent = B.id GROUP BY ip, seed order by seed";
        $res_trigger = $db->sql_query($sql_trigger) or err("SQL Error: $sql_trigger",$db->sql_error());
        unset($sql_trigger);
        $row_trigger = $db->sql_fetchrow($res_trigger);

        if ($min_share_seed > 0) {
                if ($row_trigger["seed"] == "no" OR $row_trigger["tot_size"] < $min_share_seed) $check_seed = false;
        }


        if (!$check_seed OR !$check_leech) err("You can't download so much. Wait for your uploads to reach minimum limit and try again");
        $db->sql_freeresult($res_trigger);
        unset($row_trigger);
}

unset($row_trigger);
if ($self) { //Peer is already connected
        if (!$stoppeer AND !$event == "started" AND !$event == "stopped" AND !$event == "completed" AND !$self["seconds"] == 0 AND $self["seconds"]+5 < $announce_interval_min)
		{
			//err("You cannot hammer this tracker. Wait ". intval($announce_interval_min - $self["seconds"]) ." seconds and try again.");
			if(!$compact){
				$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e". benc_str("complete") . "i" . $seeders . "e" . benc_str("incomplete") . "i" . $leechers . "e" . benc_str("downloaded") . "i" . $completed . "e" . benc_str('size') . "i" . $size . "e" . benc_str("private") . 'i1e' . benc_str("peers") . "le" . benc_str("min interval") . "i" . $announce_interval_min . "e";
				$resp .= "15:warning message". strlen("You cannot hammer this tracker. Wait ". intval($announce_interval_min - $self["seconds"]) ." seconds and try again.") .":". "You cannot hammer this tracker. Wait ". intval($announce_interval_min - $self["seconds"]) ." seconds and try again.";
   				$resp .= "d" .
      			benc_str("ip") . benc_str(long2ip($ip)) .
      			benc_str("peer id") . benc_str(stripslashes($peer_id)) .
      			benc_str("port") . "i" . $port . "e" .
      			"e";
			}else{
				$resp = "d" . benc_str("interval") . "i" . $announce_interval . "e". benc_str("complete") . "i" . $seeders . "e" . benc_str("incomplete") . "i" . $leechers . "e" . benc_str("downloaded") . "i" . $completed . "e" . benc_str('size') . "i" . $size . "e" . benc_str("min interval") . "i" . $announce_interval_min . "e";
				$resp .= "15:warning message". strlen("You cannot hammer this tracker. Wait ". intval($announce_interval_min - $self["seconds"]) ." seconds and try again.") .":". "You cannot hammer this tracker. Wait ". intval($announce_interval_min - $self["seconds"]) ." seconds and try again.";
                        $peers = pack("Nn", sprintf("%d",$ip), $port);
					$resp .= benc_str("peers") . strlen($peers).":".$peers;
			}
			$resp .= "ee";
			benc_resp_raw($resp);
			$db->sql_close();
			die();
		}
        if ($self["seconds"] != 0){
                $upload_speed = round(($uploaded - $self["uploaded"]) / $self["seconds"]);
                $download_speed = round(($downloaded - $self["downloaded"]) / $self["seconds"] );
                $updateset[] = "speed = speed - '".$self["upload_speed"]."' + '".$upload_speed."'";
        } else {
                $upload_speed = 0;
                $download_speed = 0;
        }
//SNATCH UPDATE
   $res=$db->sql_query("SELECT uploaded, downloaded, seeding_time FROM ".$db_prefix."_snatched WHERE torrent = $torrentid AND userid = $uid")or err("HELP4");
      $row = mysqli_fetch_array($res);
      $sockres = @fsockopen($real_ip, $port, $errno, $errstr, 1.5);
      if($event != "stopped")
      $seeder2 = $seeder;
      else
      {
      $seeder2 = "no";
      }
     if (!$sockres)
      $connectable = "no";
     else
    {
      $connectable = "yes";
      @fclose($sockres);
   }
   $seed_overal = $row['seeding_time'] + $announce_interval_min;
   if($seeder2 == "yes")$seed_for = ", seeding_time = '".$seed_overal."'";
   else
   $seed_for='';
      $downloaded2=$downloaded - $self["downloaded"];
      $uploaded2=$uploaded - $self["uploaded"];
      $usna = "UPDATE ".$db_prefix."_snatched SET uploaded = uploaded+$uploaded2, downloaded = downloaded+$downloaded2, port = '".$port."', seeder = 'yes', connectable = '$connectable'".$seed_for.", agent= " . $client . ", ip = '".$ip."', to_go = '".$left."',speedup='".$upload_speed."',speeddown='".$download_speed."', last_action = '".get_date_time()."', warned = 'no', hnr_warning = 'no' WHERE torrent = $torrentid AND userid = ".$uid."";
	  if (!$db->sql_query($usna))err("Error ".$usna);

//END SNATCH UPDATE

        $sql_update = "UPDATE ".$db_prefix."_peers SET ip = '".$ip."', real_ip = '".$real_ip."', connectable = '".$connectable."', port = '".$port."', uploaded = '".$uploaded."', downloaded = '".$downloaded."', to_go = '".$left."', last_action = NOW(), seeder = '".$seeder."', download_speed='".$download_speed."', upload_speed='".$upload_speed."' WHERE torrent = '".$torrentid."' AND  " . hash_where("peer_id", $peer_id) . ";";
        unset($download_speed, $upload_speed, $where);
        if (!$db->sql_query($sql_update)) err("Error ".$sql_update,$db->sql_error());
        unset($sql_update);

} else {
        $connectable = "yes";
        if ($autoscrape) {
                $sockres = @fsockopen($real_ip, $port, $errno, $errstr, 1.5);
                if (!$sockres) $connectable = "no";
                @fclose($sockres);
                unset($sockres,$errno,$errstr);
        }
               //SNATCHED MOD
         $res = $db->sql_query("SELECT torrent, userid FROM ".$db_prefix."_snatched WHERE torrent = $torrentid AND userid = $uid")or err("HELP2");
           $check = $db->sql_fetchrow($res);
         if (!$check['userid'] AND $seeder == "yes")$db->sql_query("INSERT INTO ".$db_prefix."_snatched (torrent, torrentid, userid, ip, port, startdat, last_action, agent, torrent_name, torrent_category, finished, completedat) VALUES ($torrentid, $torrentid, $uid, '".$ip."', $port, '".get_date_time()."', '".get_date_time()."', '" . addslashes($agent) .$clientversion. "' , '" . addslashes($torrentname) . "', $torrentcategory, 'yes', NOW())")or err('SQL Error',$db->sql_error());
         if (!$check['userid'] AND $seeder != "yes")$db->sql_query("INSERT INTO ".$db_prefix."_snatched (torrent, torrentid, userid, ip, port, startdat, last_action, agent, torrent_name, torrent_category) VALUES ($torrentid, $torrentid, $uid, '".$ip."', $port, '".get_date_time()."', '".get_date_time()."', '" . addslashes($agent) .$clientversion. "' , '" . addslashes($torrentname) . "', $torrentcategory)")or err('SQL Error',$db->sql_error());
           //END SNATCHED

        $sql_insert = "INSERT INTO ".$db_prefix."_peers (connectable, torrent, peer_id, ip, port, uploaded, downloaded, to_go, started, last_action, seeder, real_ip, client, version, user_agent, unique_id, uid) VALUES ('".$connectable."', '".$torrentid."', '".$db->sql_escape(utf8_clean_string($peer_id)). "', '".$ip."', '".$port."', '".$uploaded."', '".$downloaded."', '".$left."', NOW(), NOW(), '".$seeder."', '".$real_ip."', $client, '".$clientversion."', '".$_SERVER["HTTP_USER_AGENT"]."', '".$key."', '".$uid."')";
        if ($db->sql_query($sql_insert)) {
  $hitrun = "IF(hitrun > '".get_date_time(gmtime() - 5400)."', '0000-00-00 00:00:00', hitrun)";
  $hitrunwarn = "IF(hitrun > '".get_date_time(gmtime() - 5400)."', 'no', hitrunwarn)";
  $snh_up = "UPDATE ".$db_prefix."_snatched SET ip = ".$ip.", port = $port, agent = ".addslashes($agent).$clientversion.", last_action = '".get_date_time()."', hitrun = $hitrun, seeder = '".$seeder."', hitrunwarn = $hitrunwarn WHERE torrentid = $torrentid AND userid = $uid";
  $snh_in = "INSERT INTO ".$db_prefix."_snatched (torrentid, userid, port, startdate, agent,ip) VALUES ($torrentid, $uid, $port, '".get_date_time()."', '" . $db->sql_escape($agent) .$clientversion. "','" . $ip . "')";
  if(!$db->sql_query($snh_up))$db->sql_query($snh_in);
                if ($seeder == "yes")
                        $updateset[] = "seeders = seeders + 1";
                else
                        $updateset[] = "leechers = leechers + 1";
                $updateset[] = "tot_peer = tot_peer + 1";
        } else err("SQL Error = $sql_insert",$db->sql_error());
        unset($sql_insert);
}

$clientused = str_replace("'","",$client) . " " . $clientversion;
        unset($connectable, $ip, $port, $left, $real_ip, $client, $clientversion, $key);

$updateset[] = "visible = 'yes'";
if ($seeder == "yes") {
        $updateset[] = "last_action = NOW()";
} 
unset($seeder);
if (count($updateset)) {
        $sql_update = "UPDATE ".$db_prefix."_torrents SET " . implode(",", $updateset) . " WHERE id = '".$torrentid."';";
        $db->sql_query($sql_update) or err("Error SQL = ".$sql_update ,$db->sql_error());
        unset($updateset,$sql_update);
}
unset($torrentid);
$setdownload = 0;
$setupload = 0;
if($usergift == 1)$ratiobuild = 'yes';
		$setupload = $uploaded-$selfupload;
		$setdownload = $downloaded-$selfdownloaded;
if ($free_dl OR $ratiobuild == "yes" )$setdownload = 0;
//Update user ratio
if ($uid != 0 AND !($event =="started")) {
        $sql = "UPDATE ".$db_prefix."_users SET uploaded = uploaded + ".$setupload.", downloaded = downloaded + ".$setdownload." WHERE id=".$uid." LIMIT 1;";
        $db->sql_query($sql) or err("SQL Error: ".$sql,$db->sql_error());
}
unset($uploaded ,$downloaded, $self, $uid, $sql);

if ($debug) {
	add_log('admin','LOG_ANNOUNCE',$_SERVER["REQUEST_URI"]."\n\n\n".$resp);
        //$email = New eMail();
        //$email->Add('black_heart@me.com');
        //$email->subject = "Announce Debug";
        //$email->body = $_SERVER["REQUEST_URI"]."\n\n\n".$resp;
        //$email->Send();
}

benc_resp_raw($resp);
$db->sql_close();
die();
?>