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
* @version $Id: 3.0.0 settings.php  2014-01-24 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/bonus_system',$user->ulanguage);
		$action					= request_var('action', '');
switch ($action)
	{
		case 'configs' :
			$active						= request_var('sub_active', 'false');
			$by_torrent					= request_var('sub_by_torrent', '0');
			$upload						= request_var('sub_upload', '0');
			$comment					= request_var('sub_comment', '0');
			$offer						= request_var('sub_offer', '0');
			$fill_request				= request_var('sub_fill_request', '0');
			$seeding					= request_var('sub_seeding', '0');
			if (!$by_torrent) $by_torrent = "0";
			else
			$by_torrent = '1';

        	$sql = "INSERT INTO ".$db_prefix."_bonus_points (
					active, 
					upload, 
					comment, 
					offer, 
					fill_request, 
					seeding, 
					by_torrent
					) VALUES (
					'".$active."', 
					'".$upload."', 
					'".$comment."', 
					'".$offer."', 
					'".$fill_request."', 
					'".$seeding."', 
					'".$by_torrent."'
					);";
       	if (!$db->sql_query($sql)) btsqlerror($sql);
        	$db->sql_query("TRUNCATE TABLE ".$db_prefix."_bonus_points;");
        	$db->sql_query($sql);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?op=bonus_system&amp;i=userinfo&amp;saved=1#bonus_system",
								        'MESSAGE_TITLE'          => $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'            => $user->lang['SETTING_SAVED'].back_link($u_action),
                                ));
			echo $template->fetch('admin/message_body.html');
			close_out();
		break;
		case 'delete' :
			$b					= (int) request_var('b', '0');
			if($b <= 0)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'            => false,
								        'MESSAGE_TITLE'          => $user->lang['ERROR'],
                                        'MESSAGE_TEXT'            => $user->lang['NO_ID'].back_link($u_action),
                                ));
				echo $template->fetch('admin/message_body.html');
				close_out();
				}
			if (confirm_box(true))
				{
					$sql = 'DELETE FROM `' . $db_prefix . '_bonus` WHERE `' . $db_prefix . '_bonus`.`id` = ' . $b . ' LIMIT 1';
					$db->sql_query($sql);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'			=> true,
										'S_FORWARD'				=> $siteurl."/admin.php?op=bonus_system&amp;i=userinfo&amp;saved=1#bonus_system",
								        'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'			=> $user->lang['BONUS_REMOVED'].back_link($u_action),
                                ));
					echo $template->fetch('admin/message_body.html');
					close_out();
				}else
				{
								$hidden = build_hidden_fields(array(
								"i"			=> 'userinfo',
								"op"		=> 'bonus_system',
								'action'	=> 'delete',
								'b'			=> $b,
								));
				confirm_box(false, $user->lang['CONFIRM_OPERATION_DEL'], $hidden,'admin/confirm_body.html','admin.php');
				}
		break;
		case 'edit' :
			$b					= (int) request_var('b', '0');
			if($b <= 0)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'            => false,
								        'MESSAGE_TITLE'          => $user->lang['ERROR'],
                                        'MESSAGE_TEXT'            => $user->lang['NO_ID'].back_link($u_action),
                                ));
				echo $template->fetch('admin/message_body.html');
				close_out();
				}
						$sql = 'SELECT * FROM `' . $db_prefix . '_bonus` WHERE `id` = ' . $b . ' LIMIT 1';
                        $row = $db->sql_query($sql);
						$res = $db->sql_fetchrow($row);
								$hidden = build_hidden_fields(array(
								"i"			=> 'userinfo',
								"op"		=> 'bonus_system',
								'action'	=> 'take_edit',
								'b'			=> $b,
								));
									$template->assign_vars(array(
										'S_EDITBONUS'			=>true,
										'S_BONUS_NAME'			=> $res['bonusname'],
										'S_BONUS_POINTS'		=> $res['points'],
										'S_BONUS_DESC'			=> $res['description'],
										'S_BONUS_ART'			=> $res['art'],
										'S_BONUS_MENGE'			=> $res['menge'],
										'E_HIDDEN'				=> $hidden,
										'U_ACTION_EDIT'			=> './admin.php',
								));
		break;
		case 'take_edit' :
			$error = array();
				$b							= (int) request_var('b', '0');
				if($b <= 0) $error[] = $user->lang['NO_ID'];
				$bonusname					= request_var('bonusname', '');
				if($bonusname == '') $error[] = $user->lang['NO_NAME'];
				$points						= request_var('points', '');
				if($points == '') $error[] = $user->lang['NO_PONTS'];
				$description				= request_var('description', '');
				if($description == '') $error[] = $user->lang['NO_DESC'];
				$art						= request_var('art', 'traffic');
				$menge						= request_var('menge', '0');
				if($menge == 0) $error[] = $user->lang['NO_SYS_VAL'];
					if($b > 0)
					{
						$sql = 'SELECT count(id) as count FROM `' . $db_prefix . '_bonus` WHERE `id` = ' . $b . ' LIMIT 1';
                        $row = $db->sql_query($sql);
						$res = $db->sql_fetchrow($row);
						if($res['count'] < 1) $error[] = $user->lang['NOT_VALID_BONUS'];
					}
			if(count($error) > 0)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'            => false,
								        'MESSAGE_TITLE'          => $user->lang['ERROR'],
                                        'MESSAGE_TEXT'            => implode("<br />", $error).back_link($u_action),
                                ));
				echo $template->fetch('admin/message_body.html');
				close_out();
				}
			$sql = 'UPDATE `' . $db_prefix . "_bonus` SET 
					`bonusname` =  '" . $db->sql_escape($bonusname) . "', 
					`points` =  " . $points . ", 
					`description` =  '" . $db->sql_escape($description) . "', 
					`art` =  '" . $db->sql_escape($art) . "', 
					`menge` = " . $menge . " 
					WHERE `id` = " . $b . " LIMIT 1";
			$db->sql_query($sql);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'			=> true,
										'S_FORWARD'				=> $siteurl."/admin.php?op=bonus_system&amp;i=userinfo&amp;saved=1#bonus_system",
								        'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'			=> $user->lang['BONUS_UPDATED'].back_link($u_action),
                                ));
					echo $template->fetch('admin/message_body.html');
					close_out();
		break;
		case 'add_new' :
				$bonusname					= request_var('bonusname', '');
				if($bonusname == '') $error[] = $user->lang['NO_NAME'];
				$points						= request_var('points', '');
				if($points == '') $error[] = $user->lang['NO_PONTS'];
				$description				= request_var('description', '');
				if($description == '') $error[] = $user->lang['NO_DESC'];
				$art						= request_var('art', 'traffic');
				$menge						= request_var('menge', '0');
				if($menge == 0) $error[] = $user->lang['NO_SYS_VAL'];
			if(count($error) > 0)
				{
                                $template->assign_vars(array(
								        'S_USER_NOTICE'            => false,
								        'MESSAGE_TITLE'          => $user->lang['ERROR'],
                                        'MESSAGE_TEXT'            => implode("<br />", $error).back_link($u_action),
                                ));
				echo $template->fetch('admin/message_body.html');
				close_out();
				}
			$sql = 'INSERT INTO  `' . $db_prefix . "_bonus` (
					`bonusname` , 
					`points` , 
					`description` , 
					`art` , 
					`menge`
					) VALUES (
					'" . $db->sql_escape($bonusname) . "', 
					" . $points . ", 
					'" . $db->sql_escape($description) . "', 
					'" . $db->sql_escape($art) . "', 
					" . $menge . " 
					)";
					
			$db->sql_query($sql) or btsqlerror($sql);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'			=> true,
										'S_FORWARD'				=> $siteurl."/admin.php?op=bonus_system&amp;i=userinfo&amp;saved=1#bonus_system",
								        'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'			=> $user->lang['BONUS_ADDED'].back_link($u_action),
                                ));
					echo $template->fetch('admin/message_body.html');
					close_out();
		break;
}
		$cfgquery = "SELECT * FROM ".$db_prefix."_bonus_points ;";
		$cfgres = $db->sql_query($cfgquery) or btsqlerror($cfgquery);
		$cfgrow = $db->sql_fetchrow($cfgres);
		$db->sql_freeresult($cfgres);
						$hidden = build_hidden_fields(array(
							'update'	=> 'save',
							'i'			=> 'userinfo',
							'op'		=> 'bonus_system',
							'action'	=> 'configs',
						));
				$url = "./admin.php?i=userinfo&op=bonus_system";
$template->assign_vars(array(
        'L_TITLE'            		=> $user->lang["_admbonsetting"],
        'L_TITLE_EXPLAIN'           => $user->lang["_admsettingexplain"],
		'U_ACTION'					=> "./admin.php",
		'HIDDEN'					=> $hidden,
		'ICON_EDIT'					=> '<img src="themes/' . $theme.'/pics/admin/icon_edit.gif" alt="' . $user->lang['EDIT'] . '" title="' . $user->lang['EDIT'] . '" />',
		'ICON_DELETE'				=> '<img src="themes/' . $theme.'/pics/admin/icon_delete.gif" alt="' . $user->lang['DELETE'] . '" title="' . $user->lang['DELETE'] . '" />',
		'S_EDITBONUS'				=> (($action == 'edit')? true : false),
		'U_ACTION_NEW'				=> ((!$action == 'edit')? append_sid($u_action, 'action=add_new') : ''),
));
				if($cfgrow['by_torrent'] == '1')$cfgrow['by_torrent'] = 'true';
drawRow(true,false, false ,$user->lang['_admbonsetting']);
drawRow("active","checkbox");
drawRow("upload","text");
drawRow("comment","text");
drawRow("offer","text");
drawRow("fill_request","text");
drawRow("seeding","text");
drawRow("by_torrent","checkbox");
						$sql = 'SELECT `id` , `bonusname` , `points` , `description` , `art` , `menge` FROM `' . $db_prefix . '_bonus` ORDER BY `art`';
                        $row = $db->sql_query($sql);
						while ($res = $db->sql_fetchrow($row))
						{ 
							$template->assign_block_vars('bonus', array(
								'NAME'							=> $res['bonusname'],
								'POINTS'						=> $res['points'],
								'DESC'							=> $res['description'],
								'ART'							=> $res['art'],
								'MENGE'							=> $res['menge'],
								'EDIT'							=> $url . '&amp;action=edit&amp;b=' .$res['id'] . '#edit' ,
								'DELETE'						=> $url . '&amp;action=delete&amp;b=' .$res['id'] ,
							));
						}
						$db->sql_freeresult($row);

echo $template->fetch('admin/acp_bonus_system.html');
close_out();
?>