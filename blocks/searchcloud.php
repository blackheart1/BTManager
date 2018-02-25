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
** File searchcloud.php 2018-02-18 14:32:00 joeroberts
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