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
** File scrape.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
$self=explode("/", $_SERVER["PHP_SELF"]);
$last_key=(count($self)-1);
if (defined('IN_PMBT'))die ("You can't include this file...".$self[$last_key]);
define("IN_PMBT",true);
require_once("include/config_lite.php");
if(!isset($HTTP_SERVER_VARS["HTTP_USER_AGENT"])) $HTTP_SERVER_VARS["HTTP_USER_AGENT"] = '0';
if (preg_match("/(Mozilla|Opera|Lynx|Netscape)$/",$HTTP_SERVER_VARS["HTTP_USER_AGENT"])) {
       die("<html><head><title>Error!</title></head><body><h3>Sorry, but this file is not suitable for browsers.</h3></body></html>");
}

if ($stealthmode) die();

function hash_where($name, $hash_arr) {
        $new_hash_arr = Array();
        foreach ($hash_arr as $hash) {
                array_push($new_hash_arr,"'".addslashes(urldecode($hash))."'");
        }
        return $name." IN ( ".implode(",",$new_hash_arr)." )";
}

function err($msg) {
        benc_resp(array("failure reason" => array('type' => "string", 'value' => $msg)));
        die();
}

function hash_pad($hash) {
        return str_pad($hash, 20);
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
function benc_resp_raw($x) {
        header("Content-Type: text/plain");
        header("Pragma: no-cache");
        echo $x;
}
preg_match_all('/info_hash=([^&]*)/i', $_SERVER["QUERY_STRING"], $info_hash_array);
$info_hash_array = str_replace('info_hash=','',$info_hash_array[0]);
if (count($info_hash_array) < 1) $sql = "SELECT tracker, info_hash, seeders AS complete, completed AS downloaded, leechers AS incomplete, name FROM ".$db_prefix."_torrents WHERE tracker IS NULL AND exeem IS NULL ORDER BY id;";
else $sql = "SELECT info_hash, seeders AS complete, completed AS downloaded, leechers AS incomplete, name FROM ".$db_prefix."_torrents WHERE ".hash_where("info_hash", $info_hash_array);

if (! $res = $db->sql_query($sql)) err($sql);
if ($db->sql_numrows($res) < 1) err("Torrent NOT Registered with this tracker.");

$r .= "d" . benc_str("files") . "d";
while ($row = $db->sql_fetchrow($res)) {
        $r .= "20:" . hash_pad($row["info_hash"]) . "d" .
        benc_str("complete")."i". $row["complete"] ."e".
        benc_str("downloaded") . "i". $row["downloaded"] ."e".
        benc_str("incomplete") . "i". $row["incomplete"] ."e".
        "e";
}
$r .= "e";
if ($announce_interval > 0 OR $announce_interval_min > 0) {
        $r .= benc_str("flags")."d20:min_request_intervali".max($announce_interval,$announce_interval_min)."ee";
}
$r .= "e";

ob_clean();
benc_resp_raw($r);

$db->sql_query("",END_TRANSACTION);
if (!$db->persistency) $db->sql_close();
die();
?>