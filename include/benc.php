<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

if (eregi("benc.php",$_SERVER['PHP_SELF'])) die("You can't access this file directly");

function benc($obj) {
		global $user;
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

function benc_str($s) {
		global $user;
        return strlen($s) . ":$s";
}

function benc_int($i) {
		global $user;
        return "i" . $i . "e";
}

function benc_list($a) {
		global $user;
        $s = "l";
        foreach ($a as $e) {
                $s .= benc($e);
        }
        $s .= "e";
        return $s;
}

function benc_dict($d) {
		global $user;
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

function bdec_file($f) {
		global $user;
        $fp = @fopen($f, "rb");
        if (!$fp)
                return;
        while (!feof($fp))
                $e = @fread($fp, 1000);
        fclose($fp);
        return bdec($e);
}

function bdec($s) {
		global $user;
        if (preg_match('/^(\d+):/', $s, $m)) {
                $l = $m[1];
                $pl = strlen($l) + 1;
                $v = substr($s, $pl, $l);
                $ss = substr($s, 0, $pl + $l);
                if (strlen($v) != $l)
                        return;
                return array("type" => "string", "value" => $v, "strlen" => strlen($ss), "string" => $ss);
        }
        if (preg_match('/^i(\d+)e/', $s, $m)) {
                $v = $m[1];
                $ss = "i" . $v . "e";
                if ($v === "-0")
                        return;
                if ($v[0] == "0" && strlen($v) != 1)
                        return;
                return array("type" => "integer", "value" => $v, "strlen" => strlen($ss), "string" => $ss);
        }
        switch ($s[0]) {
                case "l":
                        return bdec_list($s);
                case "d":
                        return bdec_dict($s);
                default:
                        return;
        }
}

function bdec_list($s) {
		global $user;
        if ($s[0] != "l")
                return;
        $sl = strlen($s);
        $i = 1;
        $v = array();
        $ss = "l";
        for (;;) {
                if ($i >= $sl)
                        return;
                if ($s[$i] == "e")
                        break;
                $ret = bdec(substr($s, $i));
                if (!isset($ret) || !is_array($ret))
                        return;
                $v[] = $ret;
                $i += $ret["strlen"];
                $ss .= $ret["string"];
        }
        $ss .= "e";
        return array("type" => "list", "value" => $v, "strlen" => strlen($ss), "string" => $ss);
}

function bdec_dict($s) {
		global $user;
        if ($s[0] != "d")
                return;
        $sl = strlen($s);
        $i = 1;
        $v = array();
        $ss = "d";
        for (;;) {
                if ($i >= $sl)
                        return;
                if ($s[$i] == "e")
                        break;
                $ret = bdec(substr($s, $i));
                if (!isset($ret) || !is_array($ret) || $ret["type"] != "string")
                        return;
                $k = $ret["value"];
                $i += $ret["strlen"];
                $ss .= $ret["string"];
                if ($i >= $sl)
                        return;
                $ret = bdec(substr($s, $i));
                if (!isset($ret) || !is_array($ret))
                        return;
                $v[$k] = $ret;
                $i += $ret["strlen"];
                $ss .= $ret["string"];
        }
        $ss .= "e";
        return array("type" => "dictionary", "value" => $v, "strlen" => strlen($ss), "string" => $ss);
}
function dict_check($d, $s) {
		global $user;
        if ($d["type"] != "dictionary")
                bterror($user->lang['T_DIR_NOT_PRES'],_btuploaderror);
        $a = explode(":", $s);
        $dd = $d["value"];
        $ret = array();
        foreach ($a as $k) {
                unset($t);
                if (preg_match('/^(.*)\((.*)\)$/', $k, $m)) {
                        $k = $m[1];
                        $t = $m[2];
                }
                if (!isset($dd[$k]))
                        bterror($user->lang['T_DIR_MES_KEY'],_btuploaderror);
                if (isset($t)) {
                        if ($dd[$k]["type"] != $t)
                                bterror($user->lang['INV_DATA_IN_DIR'],_btuploaderror);
                        $ret[] = $dd[$k]["value"];
                }
                else
                        $ret[] = $dd[$k];
        }
        return $ret;
}
function dict_exists($d, $s) {
		global $user;
        if ($d["type"] != "dictionary") return false;
        $a = explode(":", $s);
        $dd = $d["value"];
        $ret = array();
        foreach ($a as $k) {
                unset($t);
                if (preg_match('/^(.*)\((.*)\)$/', $k, $m)) {
                        $k = $m[1];
                        $t = $m[2];
                }
                if (!isset($dd[$k]))
                        return false;
                if (isset($t)) {
                        if ($dd[$k]["type"] != $t)
                                return false;
                }
        }
        return true;
}
function dict_get($d, $k, $t) {
		global $user;
        if ($d["type"] != "dictionary")
                bterror($user->lang['T_DIR_NOT_PRES'],_btuploaderror);
        $dd = $d["value"];
        if (!isset($dd[$k]))
                return;
        $v = $dd[$k];
        if ($v["type"] != $t)
                bterror($user->lang['INV_DATA_IN_DIR'],_btuploaderror);
        return $v["value"];
}

?>
