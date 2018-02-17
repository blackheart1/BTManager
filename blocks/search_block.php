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
* @version $Id: 3.0.0 search_block.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
global $db_prefix, $user, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache, $search, $wherecatina;
$wherecatina = (is_array($wherecatina)? $wherecatina : array());
$cat_main = array();
$cat_sub = array();
        if(! $res = $db->sql_query(
        "SELECT *
			FROM `".$db_prefix."_categories`
			ORDER BY `".$db_prefix."_categories`.`parent_id` , 
			`".$db_prefix."_categories`.`id` , 
			`".$db_prefix."_categories`.`sort_index` ASC"
        ))bterror("SELECT id, name FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC");
		$ncats = 0;
		$tabs = 0;
		$first=true;
        while ($row = $db->sql_fetchrow($res))
		{
			if($row['parent_id'] == '-1')
			{
			$tabs++;
				$cat_main[] = array(
						"ID"           => $row['id'],
						"NAME"         => $row['name'],
						"IMAGE"        => (file_exists("themes/".$theme."/pics/cat_pics/".$row["image"])) ? "<img class=\"cat_main_im\" src=\"themes/".$theme."/pics/cat_pics/".$row["image"]."\" title=\"".$row["name"]."\" border=\"0\" alt=\"".$row["name"]."\" >" : "<img class=\"cat_main_im\" src=\"cat_pics/".$row["image"]."\" border=\"0\" title=\"".$row["name"]."\" alt=\"".$row["name"]."\" >",
						"PARENT_ID"    =>  $row['parent_id'],
						"TABLETYPE"    =>  $tabs,
						"SUBSCOUNT"    =>  $row['subcount'],
						'CHECKED'		=>	((in_array($row['id'],$wherecatina))?true : false),
						'TABS'			=>	$tabs,
				   );
				$ncats = ($ncats + 1);
			}
			else
			{//subcount
			$cat_sub[$row['parent_id']][] = array(
						"ID"           => $row['id'],
						"NAME"         => $row['name'],
						"IMAGE"        => (file_exists("themes/".$theme."/pics/cat_pics/".$row["image"])) ? "<img class=\"cat_sub_im\" src=\"themes/".$theme."/pics/cat_pics/".$row["image"]."\" title=\"".$row["name"]."\" border=\"0\" alt=\"".$row["name"]."\" width=\"30px\">" : "<img class=\"cat_sub_im\" src=\"cat_pics/".$row["image"]."\" border=\"0\" title=\"".$row["name"]."\" alt=\"".$row["name"]."\" >",
						"PARENT_ID"    =>  $row['parent_id'],
						"TABLETYPE"    =>  $row['tabletype'],
						"SUBSCOUNT"    =>  $row['subcount'],
						'CHECKED'		=>	((in_array($row['id'],$wherecatina))?true : false)
				   );
				if($first_id == $row['parent_id'] and !isset($count)) $count = 0;
				if($count == 0)$count = $row['subcount'];
				$count = ($count -1);
			}
		}
	//	print_r($cat_sub);
		foreach($cat_main as $key=>$val)
		{
			$template->assign_block_vars('cats_main',$val);
			//print_r($val);
				foreach($cat_sub[$val['ID']] as $keys => $vals)
				{
					$template->assign_block_vars('cats_main.sub',$vals);
				}
		}
	$template->assign_vars(array(
			'NCATS_VAR'     => $ncats,
			'FIRST_SUB'     => $first_id,
			'SEARCH_TEXT'	=>	$search,
	));
?>