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
* @version $Id: 3.0.0 smilies.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/smilies',$user->ulanguage);
function RebuildSortIndex() {
        global $db, $db_prefix;
        $sql = "SELECT id FROM ".$db_prefix."_smiles ORDER BY sort_index ASC;";
        $res = $db->sql_query($sql);
        $sort = 10;
        while (list ($id) = $db->fetch_array($res)) {
                $sql = "UPDATE ".$db_prefix."_smiles SET sort_index = '".$sort."' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sort += 10;
        }
        $db->sql_freeresult($res);
        return;
}
switch($op) {
        case "addsmile": {
                if (!isset($sub_name) OR empty($sub_name) OR !isset($sub_image) OR empty($sub_image)OR !isset($sub_alt) OR empty($sub_alt)) break;
                if ($sub_position == -1) {
                        $sql = "SELECT MAX(sort_index) FROM ".$db_prefix."_smiles;";
                        $res = $db->sql_query($sql);
                        list ($sort) = $db->fetch_array($res);
                        $db->sql_freeresult($res);
                } else $sort = intval($sub_position);
                $sort++;
                $sql = "INSERT INTO ".$db_prefix."_smiles (code, sort_index, file, alt) VALUES ('".addslashes($sub_name)."', '".$sort."', '".addslashes(html_entity_decode($sub_image))."', '".addslashes($sub_alt)."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $op = "";
                RebuildSortIndex();
                break;
        }
        case "editsmile": {
                if (!isset($id) OR intval($id) < 1) break;
                if (isset($sub_name) AND isset($sub_image)) {
                        $sql = "UPDATE ".$db_prefix."_smiles SET code = '".addslashes($sub_name)."', file = '".addslashes(html_entity_decode($sub_image))."' WHERE id = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $op = "";
                }
                break;
        }
        case "delsmile": {
                if (!isset($id) OR intval($id) < 1) break;
                $sql = "DELETE FROM ".$db_prefix."_smiles WHERE id = '".intval($id)."';";
                $db->sql_query($sql) or btsqlerror($sql);
                break;
		}
}
#CATEGORY IMAGE SCRIPT
$sql = "SELECT * FROM ".$db_prefix."_smiles ORDER BY sort_index;";
$res = $db->sql_query($sql);
        while ($row = $db->sql_fetchrow($res)) {
			$template->assign_block_vars('smilies', array(
			'ID'		=> $row["id"],
			'ALT'		=> $row["alt"],
			'IMG'		=> "<img src=\"smiles/".$row["file"]."\" alt=\"".$row["alt"]."\" />",
			'CODE'		=> $row["code"],
			));
        }
$db->sql_freeresult($res);
			$option = ($op != "editsmile")? "addsmile" : "editsmile";
								$hidden = build_hidden_fields(array(
								"op"			=> $option,
								"id"		=> $id,
								"i"			=> 'staff',
								));
if ($op == "editsmile")
{
        $sql_edit = "SELECT * FROM ".$db_prefix."_smiles WHERE id = '".intval($id)."';";
        $res_edit = $db->sql_query($sql_edit);
        $row = $db->sql_fetchrow($res_edit);
        $db->sql_freeresult($res_edit);
}

if ($op != "editsmile") $subname = "<input type=\"text\" name=\"sub_name\" size=\"20\" />";
else $subname = "<input type=\"text\" name=\"sub_name\" size=\"20\" value =\"".$row["code"]."\" />";
$optimg = "<option value=\"none\">".$user->lang['CHOSE']."</option>";
$dhandle = opendir("./smiles/");
while ($file = readdir($dhandle)) {
        if (is_dir("./smiles/".$file) OR !preg_match('#^(http[s]?+):\/\/(.*)\.(gif|jpg|jpeg|png)$#i',$siteurl.'/'.$file)) continue;
        $optimg .= "<option value=\"".htmlentities($file)."\" ";
        if ($op == "editsmile" AND $row["file"] == $file) $optimg .= "selected";
        $optimg .=">".htmlentities($file)."</option>";
}
closedir($dhandle);
if ($op == "editsmile")$altsub = "<input type=\"text\" name=\"sub_alt\" size=\"20\" value =\"".$row["alt"]."\" />";
else
$altsub = "<input type=\"text\" name=\"sub_alt\" size=\"20\" value =\"\" />";
$posit = false;
if ($op != "editsmile") {
        $posit = "<option value=\"-1\">".$user->lang['PL_AT_END']."</option>";
        $posit .=  "<option value=\"0\">".$user->lang['PL_AT_BEGGIN']."</option>";
        $sql = "SELECT code, sort_index FROM ".$db_prefix."_smiles ORDER BY sort_index ASC;";
        $res_position = $db->sql_query($sql);
        while ($row_position = $db->sql_fetchrow($res_position)) {
                $posit .= "<option value=\"".$row_position["sort_index"]."\">".$user->lang['PL_AFT_']." - ".$row_position["code"]."</option>";
        }
        $db->sql_freeresult($res_position);
}
		$template->assign_vars(array(
		'HIDE'		=> $hidden,
		'EDACTION'	=> "admin.php#smilies",
		'SUB_NAME'	=> $subname,
		'SELIMG'	=>	$optimg,
		'ALTSUB'	=> $altsub,
		'SUBPOS'	=> $posit,
		));
echo $template->fetch('admin/smilies.html');
		close_out();
?>