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
** File functions_announce.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
function hash_where($name, $hash) {
global $db;
        $shhash = preg_replace('/ *$/s', "", $hash);
        $shhash2 = preg_replace('/ *$/s', "", iconv( 'ISO-8859-7','UTF-8', "$hash"));
//return "($name = '" . $db->sql_escape(iconv( 'UTF-8','ISO-8859-7', "$hash")) . "'  OR  $name = '" . $db->sql_escape($hash) . "'  OR  $name = '" . $db->sql_escape(urldecode($hash)) . "'  OR  $name = '" . $db->sql_escape(utf8_clean_string(bin2hex($hash))) . "'  OR $name = '" . $db->sql_escape(utf8_clean_string($hash)) . "'  OR $name = '" . $db->sql_escape($shhash) . "'  OR $name = '" . $db->sql_escape(utf8_clean_string($shhash)) . "')";
return 		"(
			HEX(`$name`) = HEX('" . $db->sql_escape(iconv( 'ISO-8859-7','UTF-8', "$hash")) . "')  OR   
			$name = '" . $db->sql_escape(stripslashes(iconv( 'ISO-8859-7','UTF-8', "$hash"))) . "'  OR   
			$name = '" . $db->sql_escape(iconv( 'UTF-8','ISO-8859-7', "$hash")) . "'  OR 
			$name = '" . $db->sql_escape($hash) . "'  OR  
			$name = '" . $db->sql_escape(utf8_encode_ncr($hash)) . "'  OR 
			$name = '" . $db->sql_escape(utf8_clean_string($hash)) . "' OR 
			$name = '" . $db->sql_escape(utf8_clean_string(iconv( 'ISO-8859-7','UTF-8', "$hash"))) . "' OR 
			$name = '" . $db->sql_escape($shhash2) . "'  OR  
			$name = '" . $db->sql_escape($shhash) . "')";
}
function unesc_magic($x) {
        return (get_magic_quotes_gpc()) ? stripslashes($x) : $x;
}
function err($msg)
{
global $db, $db_prefix, $user,$real_ip;
//logerror($msg . '\n' . $real_ip, 'announce');
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
function hex2bin($h)
  {
  if (!is_string($h)) return null;
  $r='';
  for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
  return $r;
  }
  function benc_resp_raw($x){
	$buffer = ob_get_clean();
	ob_start("ob_gzhandler");
	ob_implicit_flush(0);
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
