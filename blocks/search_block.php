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
** File search_block.php 2018-02-18 14:32:00 joeroberts
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
			if(!isset($cat_sub[$val['ID']]))
			{
				$cat_sub[$val['ID']] = array();
			}
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