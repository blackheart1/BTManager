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
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 actb.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db, $db_prefix, $search_cloud, $search_cloud_user_only, $user;
include_once 'include/function_posting.php';
if($search_cloud)
{
	if(($search_cloud_user_only AND $user->user) OR !$search_cloud_user_only)
	{
		$search = utf8_normalize_nfc(request_var('search', '',true));
		if(!empty($search))
		{
			$val = preg_replace("/[^0-9a-z -#\(\)\:\/\-\_\'\"\]\[]/i",'', $search);
			if (preg_match("/http:/i", $val)) $val="";
			if(strlen($val) > 1)
			{
				$compl = "UPDATE ".$db_prefix."_search_text SET hit = hit + '1'  WHERE text = '".$db->sql_escape($val)."';";
				$complinsert = "INSERT INTO ".$db_prefix."_search_text  VALUES (0, '".$db->sql_escape($val)."', '1')";
				$res = $db->sql_query($compl);
				if (!$db->sql_affectedrows($res))
				{
					$db->sql_query($complinsert);
				}
			}
		}		
	}
}
$abc = array(0=>'a');
                        $sql ="SELECT text FROM ".$db_prefix."_search_text  ORDER BY id LIMIT 200;";
                        $result = $db->sql_query($sql);
				while($row = $db->sql_fetchrow($result)){
					$s_text = str_replace(","," ",$row["text"]);
					$s_text = str_replace("'"," ",$s_text);
					$s_text = str_replace('"'," ",$s_text);
					$abc[] = $s_text;
					//$i++;
				}

$db->sql_freeresult($result);
if(isset($template))
{
$template->assign_vars(array(
        'S_ACTB'            => "<SCRIPT type=\"text/javascript\" language=\"JavaScript\">
 var customarray=new Array('".implode("', '",$abc)."');
</SCRIPT>
<script type=\"text/javascript\" src=\"java/actb.js\"></script>",
));
}
else
{
echo "<SCRIPT type=\"text/javascript\" language=\"JavaScript\">
 var customarray=new Array('".implode("', '",$abc)."');
</SCRIPT>
<script type=\"text/javascript\" src=\"java/actb.js\"></script>";
}
?>