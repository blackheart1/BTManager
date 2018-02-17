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
* @version $Id: 3.0.0 bittorrent.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/functions.php");
require_once("include/class.user.php");
require_once("include/class.email.php");
if ($use_rsa) $rsa = New RSA($rsa_modulo, $rsa_public, $rsa_private);
if(!function_exists('str_ireplace')) {
    function str_ireplace($search, $replacement, $string){
        $delimiters = array(1,2,3,4,5,6,7,8,14,15,16,17,18,19,20,21,22,23,24,25,
        26,27,28,29,30,31,33,247,215,191,190,189,188,187,186,
        185,184,183,182,180,177,176,175,174,173,172,171,169,
        168,167,166,165,164,163,162,161,157,155,153,152,151,
        150,149,148,147,146,145,144,143,141,139,137,136,135,
        134,133,132,130,129,128,127,126,125,124,123,96,95,94,
        63,62,61,60,59,58,47,46,45,44,38,37,36,35,34);
        foreach ($delimiters as $d) {
            if (strpos($string, chr($d))===false){
                $delimiter = chr($d);
                break;
            }
        }
        if (!empty($delimiter)) {
            return preg_replace($delimiter.quotemeta($search).$delimiter.'i', $replacement, $string);
        }
        else { 
            trigger_error('Homemade str_ireplace could not find a proper delimiter.', E_USER_ERROR);
        }
    }
}
function search_word($word, $search){
if(empty($search))return $word;
$search = str_replace("+"," ",$search);
$newterm = str_ireplace($search,"<span class=\"highlight\">$search</span>",$word);
return $newterm;
}
?>