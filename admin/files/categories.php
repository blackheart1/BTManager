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
** File categories.php 2018-07-09 20:10:00 Black_Heart
**
** CHANGES
**
** 2018-07-09 - Fixed Array error
** 2018-07-09 - Added Confirmation for delete
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/mcp_categories',$user->ulanguage);
$meta = "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
$meta .= "function ChangeThumb(pic) {\n";
$meta .= "        if (pic != 'none') document.images.Thumb.src = 'cat_pics/'+pic\n";
$meta .= "        else document.images.Thumb.src = 'cat_pics/blank2.gif';\n";
$meta .= "}\n";
$meta .= "</script>\n";

		$page_title = $user->lang['INTRO'];
				$template->assign_vars(array(
					'PAGE_TITLE'       	=> $page_title,
					'META'				=> $meta,
				));
/*
REBUILDSORTINDEX FUNCTION

REBUILDS THE SORT INDEX FOR TORRENT CATEGORIES
ALL TORRENTS ARE "SPACED" BY 10 IN ORDER TO ALLOW MORE CATEGORIES BETWEEN EXISTING ONES

INPUT/OUTPUT PARAMETERS: NONE
*/
function RebuildSortIndex() {
        global $db, $db_prefix;
        $sql = "SELECT id FROM ".$db_prefix."_categories ORDER BY parent_id, sort_index, id ASC;";
        $res = $db->sql_query($sql);
        $sort = 10;
        while (list ($id) = $db->fetch_array($res)) {
                $sql = "UPDATE ".$db_prefix."_categories SET sort_index = '".$sort."' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $sort += 10;
        }
        $db->sql_freeresult($res);
        return;
}
#add new icon
		$id									= request_var('id', 0);
		$do									= request_var('do', '');
switch($do) {
		case 'takenew':
		{
				$ct = request_var('catcon', '',true,false,true);//$_FILES["catcon"];
				//die(print_r($ct));
                $nfname = unesc($ct["name"]);
				$errmsg = array();
                if ($nfname != "") {
                        if (!is_filename($nfname)) $errmsg[] = $user->lang['INVALID_ICON'];
                        if (!preg_match('/^(.+)\.(gif|jpg|jpeg|png)$/si', $nfname)) $errmsg[] = $user->lang['INVALID_ICON'];
                        if (!is_uploaded_file($ct["tmp_name"])) $errmsg[] = $user->lang['FATAL_ERROR_UPLOAD'];
                        if ($ct["size"] <= 0) $errmsg[] = $user->lang['EMPTY_FILE'];
                                $imageinfo = getimagesize($ct["tmp_name"]);
                                $width = $imageinfo[0];
                                $height = $imageinfo[1];
                                if ($width > 48 OR $height > 48) $errmsg[] = $user->lang['CAT_UPLOAD_TOBIG'];
						
                }
				//die(print($nfname));
                if (count($errmsg) > 0)
				{
					$err = "<ul>\n";
					foreach ($errmsg as $msg)
					{
						$err .= "<li><p>".$msg."</p></li>\n";
					}
					$err .= "</ul>\n";
					//die($err);
					$template->assign_vars(array(
								'S_MESSAGE'				=> true,
								'S_USER_NOTICE'			=> false,
								'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
								'MESSAGE_TEXT'			=> $err,
								));
					break;
				}
                if (!empty($nfname)) {
                        @unlink($nfopath);
                        if(!@move_uploaded_file($ct["tmp_name"],"cat_pics/".$nfname))
						{
						
					$template->assign_vars(array(
								'S_MESSAGE'				=> true,
								'S_USER_NOTICE'			=> false,
								'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
								'MESSAGE_TEXT'			=> $user->lang['UPLOAD_FAILED'],
								));
						}
						else
						{
					$template->assign_vars(array(
								'S_MESSAGE'				=> true,
								'S_USER_NOTICE'			=> true,
								'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
								'MESSAGE_TEXT'			=> $user->lang['UPLOAD_SUCCESSFUL'],
								));
						}
                }
                break;
		}
        case "addcategory": {
		$sub_image									= request_var('sub_image', '');
		$sub_name									= request_var('sub_name', '');
		$sub_position									= request_var('sub_position', '');
		$sub_parent									= request_var('sub_parent', '');
                if ($sub_name == '' OR $sub_image == '') break;
                if ($sub_position == -1) {
                        $sql = "SELECT MAX(sort_index) FROM ".$db_prefix."_categories;";
                        $res = $db->sql_query($sql);
                        list ($sort) = $db->fetch_array($res);
                        $db->sql_freeresult($res);
                } else $sort = intval($sub_position);
                $sort++;
		        $sql_edit1 = "SELECT tabletype FROM ".$db_prefix."_categories  ORDER BY tabletype DESC LIMIT 1;";
                $res_edit1 = $db->sql_query($sql_edit1);
                $row1 = $db->sql_fetchrow($res_edit1);
                $db->sql_freeresult($res_edit1);
				if(!is_numeric($sub_parent))$sub_parent = "-1";
				if(!isset($sub_parent) or $sub_parent == '')$sub_parent = "-1";
				if($sub_parent == "-1")$sub_tabletype = ($row1['tabletype']+1);
				else
				$sub_tabletype = "1";
                $sql = "INSERT INTO ".$db_prefix."_categories (name, sort_index, image, parent_id, tabletype,subcount) VALUES ('".addslashes($sub_name)."', '".$sort."', '".addslashes(html_entity_decode($sub_image))."', '".$sub_parent."', '".$sub_tabletype."',0);";
                $db->sql_query($sql) or btsqlerror($sql);
                $op = "";
                RebuildSortIndex();
                break;
        }
        case "editcategory": {
		        $sql_edit1 = "SELECT tabletype FROM ".$db_prefix."_categories  ORDER BY tabletype DESC LIMIT 1;";
                $res_edit1 = $db->sql_query($sql_edit1);
                $row1 = $db->sql_fetchrow($res_edit1);
                $db->sql_freeresult($res_edit1);
                if (intval($id) < 1) break;
                if (isset($sub_name) AND isset($sub_image)) {
				if(!is_numeric($sub_parent))$sub_parent = "-1";
				if(!isset($sub_parent) or $sub_parent == '')$sub_parent = "-1";
				if($sub_parent == "-1")$sub_tabletype = $id;
				else
				$sub_tabletype = "1";
                        $sql = "UPDATE ".$db_prefix."_categories SET name = '".$db->sql_escape($sub_name)."', image = '".$db->sql_escape(html_entity_decode($sub_image))."', parent_id = '".$sub_parent."', tabletype = '".$sub_tabletype."' WHERE id = '".$id."';";
                        $db->sql_query($sql) or btsqlerror($sql);
                        $do = "";
                }
                break;
        }
        case "delcategory": {
                if (!isset($id) OR intval($id) < 1) break;
			if (confirm_box(true))
			{
				$sql = "DELETE FROM ".$db_prefix."_categories WHERE id = '".intval($id)."';";
				add_log('admin','TOR_CATEGORY_REMOVED');
                $db->sql_query($sql) or btsqlerror($sql);
                break;
			}
			else
			{
				$hidden = build_hidden_fields(array(
					"id"				=> $id,
					"i"					=> 'torrentinfo',
					"op"				=> 'categories',
					"do"				=> $do,
				));
				confirm_box(false, 'DELETE_CON', $hidden,'confirm_body.html','admin.php');
			}
        }
        case "sortindexrebuild": {
                RebuildSortIndex();
                break;
        }
}

$sql = "SELECT * FROM ".$db_prefix."_categories ORDER BY sort_index ASC;";
$res = $db->sql_query($sql);
$cat_array = array();
$parnts = array();
if ($db->sql_numrows($res) > 0) 
 {
        while ($row = $db->sql_fetchrow($res)) {
		if($row["parent_id"] == "-1")
		{
		$parnts[(int)$row["id"]] = $row["name"];
		$cat_array[(int)$row["id"]] = array(
											'ID'			=>	$row["id"],
											'NAME'			=>	$row["name"],
											'IMAGE'			=>	$row["image"],
											'SUBCATS'		=>	array()
											);
		}
		else
		{
		$cat_array[(int)$row["parent_id"]]['SUBCATS'][] = array(
											'ID'			=>	$row["id"],
											'NAME'			=>	$row["name"],
											'IMAGE'			=>	$row["image"],
											);
		}
        }

}
$db->sql_freeresult($res);
foreach($cat_array as $val)
{
			$template->assign_block_vars('category', array(
				'IMAGE'				=> $val["IMAGE"],
				'NAME'				=> htmlspecialchars($val["NAME"]),
				'ID'				=> $val["ID"],
				));
	if(is_array($val["SUBCATS"]) AND count($val["SUBCATS"])>0)
	{
		foreach($val["SUBCATS"] as $vala)
		{
			$template->assign_block_vars('category.child', array(
				'IMAGE'				=> $vala["IMAGE"],
				'NAME'				=> htmlspecialchars($vala["NAME"]),
				'ID'				=> $vala["ID"],
				));
		}
	}
}
if ($do != "editcategory")
{
	$hidden = array(
			'op'		=> 'editcategory',
			'i'			=> 'torrentinfo',
			"do" 		=> "addcategory"
			);
}
else
{
	$hidden = array(
			'op'		=> 'editcategory',
			'i'			=> 'torrentinfo',
			"do" 		=> "editcategory",
			"id" 		=> intval($id),
			);
        $sql_edit = "SELECT * FROM ".$db_prefix."_categories WHERE id = '".intval($id)."';";
        $res_edit = $db->sql_query($sql_edit);
        $row = $db->sql_fetchrow($res_edit);
        $db->sql_freeresult($res_edit);
}
$sel_parent = "<option value=\"none\">".$user->lang['CHOOSE']."</option>\n";
$sel_parent .= "<option value=\"-1\" " .(($do == "editcategory" AND $row["parent_id"] == '-1')? 'selected' : '') . ">".$user->lang['SETASPARENT']."</option>\n";
foreach($parnts as $var=>$val)
{
	$sel_parent .= "<option value=\"{$var}\" " .(($do == "editcategory" AND $row["parent_id"] == $var)? 'selected' : '') . ">{$val}</option>\n";
}
$sel_image = "<option value=\"none\">".$user->lang['CHOOSE']."</option>\n";
$dhandle = opendir("./cat_pics/");
while ($file = readdir($dhandle)) {
        if (is_dir("./cat_pics/".$file) OR !preg_match('/^(.+)\.(gif|jpg|jpeg|png)$/si', $file)) continue;
        $sel_image .= "<option value=\"".htmlentities($file)."\" ";
        if ($do == "editcategory" AND $row["image"] == $file) $sel_image .= "selected";
        $sel_image .= ">".htmlentities($file)."</option>\n";
}
closedir($dhandle);
$row_pos = ($row["sort_index"] -10);
$position = "<option value=\"-1\">".$user->lang['AT_END']."</option>\n";
$position .= "<option value=\"0\"  " . (($do == "editcategory" AND $row["sort_index"] == '10')? 'selected' : '') . ">".$user->lang['AT_BEGIN']."</option>\n";
        $sql = "SELECT name, sort_index FROM ".$db_prefix."_categories ORDER BY sort_index ASC;";
        $res_position = $db->sql_query($sql);
        while ($row_position = $db->sql_fetchrow($res_position)) {
                $position .="<option value=\"".$row_position["sort_index"]."\" " . (($do == "editcategory" AND $row_pos == $row_position["sort_index"])? 'selected' : '') . ">".sprintf($user->lang['AFTER'],$row_position["name"])."</option>\n";
        }
        $db->sql_freeresult($res_position);
                                $template->assign_vars(array(
								'SUBNAME'		=> ($do == "editcategory")?$row["name"] : '',
								'SUBPARENT'		=> $sel_parent,
								'ICONS'			=> $sel_image,
								'ICON_SET'		=> ($do == "editcategory")? 'cat_pics/' . $row["image"] : 'cat_pics/blank2.gif',
								'POSITION'		=> $position,
								'HIDDEN'				=> build_hidden_fields($hidden),
								'U_ACTION'				=> './admin.php',
								));
//die(print_r($row));
echo $template->fetch('admin/mcp_categories.html');
		close_out();
?>