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
* @version $Id: 3.0.0 searchcloud.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/searchcloud',$user->ulanguage);
$cfgquery = "SELECT * FROM ".$db_prefix."_search_cloud;";
$cgfres = $db->sql_query($cfgquery);
$cfgrow = $db->sql_fetchrow($cgfres);
$db->sql_freeresult($cgfres);
		$do	= request_var('do', '');
		$op	= request_var('op', '');
		$page	= request_var('page', '0');

switch ($do)
{
	case "savesettings":
	{
        //First I create the one SQL arrays
        $params = array();
		//Now I create an error array
		$error = array();

        //Process Request

        //Then I accurately check each parameter before inserting it in SQL statement
        //Some parameters that must be numeric have to be checked with an if clause because intval() function truncates to max integer
		$sub_active		= request_var('sub_active', '0');
		$sub_user_only	= request_var('sub_user_only', '0');
		$sub_how_many	= request_var('sub_how_many', '0');
		if ($sub_active != "1") $sub_active = "0"; $params["active"] = $sub_active;
		if (!is_numeric($sub_active))
		{
			$error[] = $user->lang['ERR_ACTIVE'];
		}
		if ($sub_user_only != "1") $sub_user_only = "0"; $params["user_only"] = $sub_user_only;
		if (!is_numeric($sub_active))
		{
			$error[] = $user->lang['ERR_USERONLY'];
		}
		if (!is_numeric($sub_how_many))
		{
			$error[] = $user->lang['ERR_HOWMANY'];
		}
		$params["how_many"] = $sub_how_many;
		if (count($error) > 0){
		$template->assign_vars(array(
					'S_USER_NOTICE'			=> false,
					'S_FORWARD'				=> false,
					'MESSAGE_TITLE'			=> $user->lang['ERROR'],
					'MESSAGE_TEXT'			=> $user->lang['CONFIG_NOT_SET'] . '<br />' . implode("<br />",$error).back_link($u_action),
				));
		echo $template->fetch('admin/message_body.html');
		close_out();
		break;
		}

        //Now I save the settings
        $sql = "UPDATE ".$db_prefix."_search_cloud SET ".$db->sql_build_array('UPDATE', $params) . ";";
        if (!$db->sql_query($sql)) btsqlerror($sql);
        $db->sql_query($sql);

                                $template->assign_vars(array(
								        'S_USER_NOTICE'						=> true,
										'S_FORWARD'							=> $u_action,
								        'MESSAGE_TITLE'						=> $user->lang['SUCCESS'],
                                        'MESMESSAGE_TEXTSAGE'				=> $user->lang['SC_SET_UPDATED'],
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
		break;
	}
	case "delterm":
	{
		$sql = "DELETE FROM ".$db_prefix."_search_text WHERE id = '".$id."';";
		$db->sql_query($sql) or btsqlerror($sql);
		$template->assign_vars(array(
				'S_USER_NOTICE'				=> true,
				'S_FORWARD'					=> $u_action,
				'MESSAGE_TITLE'				=> $user->lang['SUCCESS'],
				'MESSAGE_TEXT'				=> $user->lang['SCTERM_REMOVED'],
				));
		echo $template->fetch('admin/message_body.html');
		close_out();
		break;
	}
	case "delallterm":
	{
		if (confirm_box(true))
		{
		$db->sql_query("TRUNCATE `".$db_prefix."_search_text`;");
						logerror($user->lang['SEARCH_CLOUD_CLEAR_ADMIN'],'admin');
                                $template->assign_vars(array(
								        'S_USER_NOTICE'				=> true,
										'S_FORWARD'					=> $u_action,
								        'MESSAGE_TITLE'          	=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'           	=> $user->lang['PRUNE_SUCCESS'],
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
		}
		else
		{
								$hidden = build_hidden_fields(array(
								"i"			=> 'staff',
								"op"		=> 'searchcloud',
								'do'		=>	'delallterm',
								));
		confirm_box(false, $user->lang['CONFIRM_OPERATION'], $hidden,'admin/confirm_body.html','admin.php');
		}
		break;
	}
}
                                $template->assign_vars(array(
								'L_TITLE'					=> $user->lang['SC_CONFIG'],
								'L_TITLE_EXPLAIN'			=> $user->lang['SCTITLEEXP'],
								'U_ACTION'					=> $u_action,
								'L_SCLOUD'					=> $user->lang['SCLOUD'],
								'SCACTIVE'					=> $user->lang['SCBLOCKDSP'],
								'SCACTIVE_EXPLAIN'			=> $user->lang['SCBLOCK_EXP'],
								'SCUSER_ONLY'				=> $user->lang['USER_ONLY_RC'],
								'SCUSER_ONLY_EXPLAIN'		=> $user->lang['USER_ONLY_RC_EXP'],
								'SCHOW_MANY'				=> $user->lang['HOW_MANY'],
								'SCHOW_MANY_EXPLAIN'		=> $user->lang['HOW_MANY_EXP'],
								'SCACTIVE_OPTION'			=> ($cfgrow['active']==1)?'checked':'',
								'SCUSER_ONLY_OPTION'		=> ($cfgrow['user_only']==1)?'checked':'',
								'SCHOW_MANY_OPT'			=> $cfgrow['how_many'],
								'HIDDEN'					=>	build_hidden_fields(array('op'	=>	'searchcloud',
																						  'do'	=>	'savesettings',
																						  'i'	=>	'staff',)),
								));








if ($page < 1) $page = 1;
$from = ($page - 1) * $torrent_per_page;


		$usearch	= request_var('usearch', '');
if(!isset($mod))$mod = false;


if (!empty($usearch)) {
        $sql = "SELECT id, text, hit FROM ".$db_prefix."_search_text WHERE text LIKE '%".addslashes($usearch)."%' ORDER BY hit DESC;";
        $totsql = "SELECT COUNT(id) FROM ".$db_prefix."_search_text WHERE text LIKE '%".addslashes($usearch)."%';";
        $totres = $db->sql_query($totsql);
        list ($tot) = $db->fetch_array($totres);
        $db->sql_freeresult($totres);
        $res = $db->sql_query($sql);
} else {
        $totsql = "SELECT COUNT(id) FROM ".$db_prefix."_search_text;";
        $sql = "SELECT id, text, hit FROM ".$db_prefix."_search_text ORDER BY hit DESC LIMIT ".$from.",$torrent_per_page;";

        $totres = $db->sql_query($totsql);
        list ($tot) = $db->fetch_array($totres);
        $db->sql_freeresult($totres);
}

$res = $db->sql_query($sql);
$pages = ceil($tot / $torrent_per_page);
$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;

                                $template->assign_vars(array(
								'S_SEARCH_TERM'	=> $usearch,
								'S_ON_PAGE'		=> on_page($tot, $torrent_per_page, $start),
								'PAGINATION'	=> generate_pagination($u_action . "&amp;$u_sort_param$keywords_param", $tot, $torrent_per_page, $start, true),
								));

//Terms Table
while ($row = $db->sql_fetchrow($res)){
			$template->assign_block_vars('search', array(
			'TEXT'			=> htmlspecialchars(stripslashes($row["text"])),
			'ID'			=> $row["id"],
			'HITS'			=> $row["hit"],
			'OPTION'		=> pic("drop.gif","./admin.php?op=" . $op . "&amp;do=delterm&id=".$row["id"]."",$user->lang['SCTERMREMOVE']),
			));

}
echo $template->fetch('admin/search_cloud.html');
		close_out();
?>