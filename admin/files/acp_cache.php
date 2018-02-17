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
* @version $Id: 3.0.0 HNR.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/acp_cache',$user->ulanguage);
$cfgquery = "SELECT * FROM ".$db_prefix."_cache_con;";
$cfgrow = array();
$result = $db->sql_query($cfgquery);
			while ($row_attach = $db->sql_fetchrow($result))
			{
				$cfgrow[$row_attach['name']] = $row_attach['value'];
			}
$db->sql_freeresult($cfgres);
		$do					= request_var('do', '');
function is__writable($path) 
{
	if ($path{strlen($path)-1}=='/') return is__writable($path.uniqid(mt_rand()).'.tmp');

	if (file_exists($path)) {
		if (!($f = @fopen($path, 'r+'))) return false;
		fclose($f);
		return true;
	}


	if (!($f = @fopen($path, 'w')))	return false;
	fclose($f);
	unlink($path);
	return true;
}
if ($do == "take_config") {
		$sub_sql_time									= request_var('sub_sql_time', 0);
		$sub_theme_time									= request_var('sub_theme_time', 0);
		$sub_cache_dir									= request_var('sub_cache_dir', '');
        $params = array();
        $values = array();
        $errors = array();
		if (!is_numeric($sub_sql_time))$errors[] = sprintf($user->lang["ERR_SQL_TIME"],$sub_sql_time);
		if (!is_numeric($sub_theme_time))$errors[] = sprintf($user->lang["ERR_THEME_TIME"],$sub_theme_time);
        if (!isset($sub_cache_dir) OR $sub_cache_dir == "")$errors[] = sprintf($user->lang["ERR_CACHE_DIR_NOTSET"],$sub_cache_dir);
		if (!is__writable($sub_cache_dir.'/'))$errors[] = sprintf($user->lang["ERR_CACHE_DIR_NOT_WRITEABLE"],$sub_cache_dir);
        if (count($errors) > 0)
		{
			$report = '<ul>';
					foreach ($errors as $msg) {
							$report .= sprintf($user->lang['ERR_ARRAY_MESS'], $msg);
					}
			$report .= '</ul>';
									$template->assign_vars(array(
											'S_USER_NOTICE'					=> false,
											'S_FORWARD'						=> false,
											'MESSAGE_TITLE'					=> $user->lang['SETTINGS_NOT_SAVED'],
											'MESSAGE_TEXT'					=> $report.back_link($u_action),
									));
			echo $template->fetch('admin/message_body.html');
			close_out();
		}
			$sql_ary = array(
							array(
								'name'=>'sql_time',
								'value'=>$sub_sql_time
								),
							array(
								'name'=>'theme_time',
								'value'=>$sub_theme_time
								),
							array(
								'name'=>'cache_dir',
								'value'=>$sub_cache_dir
								)
							);
						$db->multi_insert = true;
		if (!$db->sql_multi_insert($db_prefix."_cache_con", $sql_ary)) btsqlerror($db->sql_build_array('INSERT', $sql_ary[0]));
		$db->sql_query("TRUNCATE TABLE ".$db_prefix."_cache_con;");
		$db->sql_multi_insert($db_prefix."_cache_con", $sql_ary);
		$pmbt_cache->remove_file("sql_".md5('caache').".php");
		$pmbt_cache->set_sql("caache", $sql_ary);
				logerror($user->lang['LOG_CACHE_SETTING_UPDATE'],'admin');
                                $template->assign_vars(array(
								        'S_USER_NOTICE'					=> true,
										'S_FORWARD'					=> $u_action,
								        'MESSAGE_TITLE'				=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'				=> $user->lang['SETTING_SAVED'].back_link($u_action),
                                ));
		echo $template->fetch('admin/message_body.html');
		close_out();
}
						$hidden = build_hidden_fields(array(
							'do'		=> 'take_config',
						));
$template->assign_vars(array(
        'L_TITLE'            		=> $user->lang["TITLE"],
        'L_TITLE_EXPLAIN'           => $user->lang["TITLE_EXP"],
		'U_ACTION'					=> $u_action,
		'HIDDEN'					=> $hidden,
));
drawRow(true,false, false ,$user->lang['CACHE']);
drawRow("sql_time","text");
drawRow("theme_time","text");
drawRow("cache_dir","text");
echo $template->fetch('admin/acp_cache.html');
		close_out();
?>