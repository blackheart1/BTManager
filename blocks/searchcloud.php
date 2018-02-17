<?php
/*
*------------------------------phpMyBitTorrent V 3.0.0-------------------------* 
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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 14, 2010 9:05 PM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 searchcloud.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db_prefix, $user, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache,$search_cloud_limmit;
if(!$pmbt_cache->get_sql("searchcloud")){
unset($rowsets);
$rowsets = array();
                        $sql ="SELECT text, hit FROM ".$db_prefix."_search_text ORDER BY RAND() LIMIT " . $search_cloud_limmit . " ;";
                        $result = $db->sql_query($sql);
                        while($row = $db->sql_fetchrow($result)){
        $rowsets[] = (isset($row))? $row : array();
    }
$pmbt_cache->set_sql("searchcloud", $rowsets);
}else{
$rowsets = $pmbt_cache->get_sql("searchcloud");
}
        foreach ($rowsets  as $id=>$row) {
					    $hit = $row['hit']/2;
					    if($hit>=5) $hit = "5";
					    $text = str_replace(' ','+',$row["text"]);
		   $template->assign_block_vars('seach_cloud', array(
				"HIT"                =>  $hit,
				"TEXT"                =>  $text,
		   ));
						}
        $db->sql_freeresult($result);
echo $template->fetch('search_cloud.html');				
?>