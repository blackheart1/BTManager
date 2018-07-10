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
** File torrents.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** 2018-07-09 - Fix Foreach() error
** 2018-07-09 - Fix for not showing
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ('Error 404 - Page Not Found');
}
global $db_prefix, $user, $auth, $db, $shout_config,$template,$siteurl,$language,$pmbt_cache,$minvotes;
        global $name, $search, $user, $download_level, $torrent_global_privacy, $onlysearch, 
		$autoscrape, $theme, $btback1, $btback2, $btback3, $free_dl,$page, $prev, $pages, $pager, $next;
$cat_main = array();
$cat_sub = array();
	if (!isset($template->filename['index_tor']))
	{
		$template->set_filenames(array(
			'index_tor'	=> 'index_torrents.html')
		);
	}
        if(! $res = $db->sql_query(
        "SELECT *
			FROM `".$db_prefix."_categories`
			ORDER BY `".$db_prefix."_categories`.`parent_id` , 
			`".$db_prefix."_categories`.`id` , 
			`".$db_prefix."_categories`.`sort_index` ASC"
        ))bterror("SELECT id, name FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC");

        while ($row = $db->sql_fetchrow($res))
		{
			if($row['parent_id'] == '-1')
			{
				$cat_main[] = array(
						"ID"           => $row['id'],
						"NAME"         => $row['name'],
						"IMAGE"        => (file_exists("themes/".$theme."/pics/cat_pics/".$row["image"])) ? "<img src=\"themes/".$theme."/pics/cat_pics/".$row["image"]."\" title=\"".$row["name"]."\" border=\"0\" alt=\"".$row["name"]."\" width=\"30px\">" : "<img src=\"cat_pics/".$row["image"]."\" border=\"0\" title=\"".$row["name"]."\" alt=\"".$row["name"]."\" width=\"30px\">",
				   );
			}
			else
			{//subcount
			$cat_sub[$row['parent_id']][] = array(
						"ID"           => $row['id'],
				   );
			}
		}

$orderby = " ORDER BY ".$db_prefix."_torrents.evidence DESC, ";//
$catmainv = '';
if ($user->moderator)$catmainv = '1';
require_once("include/torrent_functions.php");

		foreach($cat_main as $key=>$val)
		{
			$template->assign_vars(array(
					'IND_CAT_NAME'     => $val['NAME'],
					));
					$template->assign_block_vars('index_tor',array('NAME' =>$val['NAME']));
				foreach($cat_sub[$val['ID']] as $keys => $vals)
			{
				$catwhere = " AND ".$db_prefix."_torrents.category = ".intval($vals['ID']);
				$passwhere = " AND ".$db_prefix."_torrents.password IS NULL ";
				$viswhere = "visible = 'yes' AND banned = 'no'";
				if ($user->moderator) $viswhere = "";
				if ($user->premium) $passwhere = "";
				$sql = "SELECT 
							".$db_prefix."_torrents.*, 
							IF(".$db_prefix."_torrents.numratings < '".$minvotes."', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, 
							".$db_prefix."_categories.name AS cat_name, 
							".$db_prefix."_categories.image AS cat_pic, 
							U.username, 
							IF(U.name IS NULL, U.username, U.name) as user_name, 
							U.level as user_level, 
							U.can_do as can_do, 
							L.group_colour AS color, 
							L.group_name AS lname 
						FROM 
							".$db_prefix."_torrents 
						LEFT JOIN 
							".$db_prefix."_categories ON category = ".$db_prefix."_categories.id 
						LEFT JOIN 
							".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id 
						LEFT JOIN 
							".$db_prefix."_level_settings L ON L.group_id = U.can_do 
						WHERE 
							".$catmainv.$viswhere.$catwhere.$passwhere.$orderby.$db_prefix."_torrents.added 
							DESC 
							LIMIT 0,5;";
				$res = $db->sql_query($sql) or mysql_error();
        if ($db->sql_numrows($res) > 0) {
	$template->assign_vars(array(
			'S_TORRENTS'     => true,
			));
		//die($sql);
                get_tor_vars($res, "",  "", "", '_ind');
				$template->assign_block_vars('index_tor.tsble',array('OUT' => $template->assign_display('index_tor')));
				unset($template->_tpldata['torrent_var_ind']);
				}
				$db->sql_freeresult($res);

			}
		}

	$template->assign_vars(array(
			'SHOW_ALL'     => true,
			));

echo $template->fetch('index_torrents.html');
?>