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
*------              ©2012 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 20, 2012 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 ajax/scrape.php  2012-5-20 00:22:48 joeroberts $
* @copyright (c) 2012 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("include/bdecoder.php");
require_once("include/bencoder.php");
$infohash_hex = $info_hash;
$info_hash = urlencode( pack('H*', $info_hash ? $info_hash : $info_hash ) );
        $tmp_tracker = str_replace("announce", "scrape", $tracker).((strpos($tracker,"?")) ? "&" : "?")."info_hash=".$info_hash;
        if ($fp = @fopen($tmp_tracker, "rb")) {
                stream_set_timeout($fp, 10);
                $page = "";
                while (!feof($fp)) {
                        $page .= @fread($fp,1000000);
                }
                @fclose($fp);
}
$scrape = Bdecode($page,"Scrape");
                        $seeders = 0+entry_read($scrape,"files/a".strtolower($infohash_hex)."/complete(Integer)","Scrape");
                        $leechers = 0+entry_read($scrape,"files/a".strtolower($infohash_hex)."/incomplete(Integer)","Scrape");
                        $completed = 0+entry_read($scrape,"files/a".strtolower($infohash_hex)."/downloaded(Integer)","Scrape");
  $xmldata = "Seeds: {$seeders}, Peers: {$leechers}, Completed: {$completed}";
  header('Content-Type: text/xml');
  header('status: 200');
  header('Seed: 200');
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\" ?>\n";
  echo $xmldata;  

?>