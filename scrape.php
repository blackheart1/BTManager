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
* @version $Id: 3.0.0 scrape.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
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