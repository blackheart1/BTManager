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
** File smilies.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/acp_smilies',$user->ulanguage);
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
				$op		= request_var('op', '');
switch($op) {
        case "addsmile": {
				$sub_name		= request_var('sub_name', '');
				$sub_image		= request_var('sub_image', '',true);
				$sub_alt		= request_var('sub_alt', '');
				$sub_position	= request_var('sub_position', '');
                if (!isset($sub_name) OR empty($sub_name) OR !isset($sub_image) OR empty($sub_image)OR !isset($sub_alt) OR empty($sub_alt)) break;
                if ($sub_position == -1) {
                        $sql = "SELECT MAX(sort_index) FROM ".$db_prefix."_smiles;";
                        $res = $db->sql_query($sql);
                        list ($sort) = $db->fetch_array($res);
                        $db->sql_freeresult($res);
                } else $sort = intval($sub_position);
                $sort++;
                $sql = "INSERT INTO ".$db_prefix."_smiles (code, sort_index, file, alt) VALUES ('".$db->sql_escape($sub_name)."', '".$sort."', '".$db->sql_escape(html_entity_decode($sub_image))."', '".$db->sql_escape($sub_alt)."');";
                $db->sql_query($sql) or btsqlerror($sql);
                $op = "";
                RebuildSortIndex();
                break;
        }
        case "editsmile": {
				$id				= (int)request_var('id', '0');
				$sub_name		= request_var('sub_name', '');
				$sub_image		= request_var('sub_image', '',true);
				$sub_alt		= request_var('sub_alt', '');
                if (!isset($id) OR intval($id) < 1) break;
                if (!$sub_name == '' AND !$sub_image == '') {
                        $sql = "UPDATE ".$db_prefix."_smiles SET code = '".$db->sql_escape($sub_name)."', file = '".$db->sql_escape($sub_image)."', alt='". $db->sql_escape($sub_alt) ."' WHERE id = '".$id."';";
						$db->sql_query($sql) or btsqlerror($sql);
                        $op = "";
                }
                break;
        }
        case "delsmile": {
				$id				= (int)request_var('id', '0');
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
		'SUBSMI'	=> (($op == "editsmile")? "./smiles/".$row["file"] : "./images/blank.gif"),
		));
echo $template->fetch('admin/smilies.html');
		close_out();
?>