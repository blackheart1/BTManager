<?php
/*
*----------------------------   BT.Manager V 3.0.0  ---------------------------*
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
*------                ©2014 BT.Manager Development Team                 ------*
*-----------                  http://btmanager.com                  -----------*
*------------------------------------------------------------------------------*
*--------------------  Friday, March 06, 2014 1:05 AM  ------------------------*
*
* @package BT.Manager
* @version $Id: 3.0.0 advance_settings.php  2014-03-06 00:22:48 joeroberts $
* @copyright (c) 2014 BT.Manager Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
		$sql = 'SELECT * FROM `'.$db_prefix.'_settings`';
		$avres = $db->sql_query($sql) or btsqlerror($avsql);
		$cfgrow = array();
		while($adv_sett = $db->sql_fetchrow($avres))$cfgrow[$adv_sett['config_name']] = $adv_sett['config_value'] ;
	$do				= request_var('do', '');
	if(isset($do) && $do == "save")
	{
		$new_config = array();
		$allow_privmsg				= request_var('sub_allow_privmsg', 0);
		$pm_max_boxes				= request_var('sub_pm_max_boxes', 0);
		$pm_max_msgs				= request_var('sub_pm_max_msgs', 0);
		$full_folder_action				= request_var('sub_full_folder_action', '1');
		$pm_edit_time				= request_var('sub_pm_edit_time', 0);
		$allow_mass_pm				= request_var('sub_allow_mass_pm', 0);
		$auth_bbcode_pm				= request_var('sub_auth_bbcode_pm', 0);
		$auth_smilies_pm				= request_var('sub_auth_smilies_pm', 0);
		$allow_pm_attach				= request_var('sub_allow_pm_attach', 0);
		$allow_sig_pm				= request_var('sub_allow_sig_pm', 0);
		$print_pm				= request_var('sub_print_pm', 0);
		$forward_pm				= request_var('sub_forward_pm', 0);
		$auth_img_pm				= request_var('sub_auth_img_pm', 0);
		$auth_flash_pm				= request_var('sub_auth_flash_pm', 0);
		$enable_pm_icons				= request_var('sub_enable_pm_icons', 0);
		if($cfgrow['allow_privmsg'] != $allow_privmsg)$new_config['allow_privmsg'] = $allow_privmsg;
		if($cfgrow['pm_max_boxes'] != $pm_max_boxes)$new_config['pm_max_boxes'] = $pm_max_boxes;
		if($cfgrow['pm_max_msgs'] != $pm_max_msgs)$new_config['pm_max_msgs'] = $pm_max_msgs;
		if($cfgrow['full_folder_action'] != $full_folder_action)$new_config['full_folder_action'] = $full_folder_action;
		if($cfgrow['pm_edit_time'] != $pm_edit_time)$new_config['pm_edit_time'] = $pm_edit_time;
		if($cfgrow['allow_mass_pm'] != $allow_mass_pm)$new_config['allow_mass_pm'] = $allow_mass_pm;
		if($cfgrow['auth_bbcode_pm'] != $auth_bbcode_pm)$new_config['auth_bbcode_pm'] = $auth_bbcode_pm;
		if($cfgrow['auth_smilies_pm'] != $auth_smilies_pm)$new_config['auth_smilies_pm'] = $auth_smilies_pm;
		if($cfgrow['allow_pm_attach'] != $allow_pm_attach)$new_config['allow_pm_attach'] = $allow_pm_attach;
		if($cfgrow['allow_sig_pm'] != $allow_sig_pm)$new_config['allow_sig_pm'] = $allow_sig_pm;
		if($cfgrow['print_pm'] != $print_pm)$new_config['print_pm'] = $print_pm;
		if($cfgrow['forward_pm'] != $forward_pm)$new_config['forward_pm'] = $forward_pm;
		if($cfgrow['auth_img_pm'] != $auth_img_pm)$new_config['auth_img_pm'] = $auth_img_pm;
		if($cfgrow['auth_flash_pm'] != $auth_flash_pm)$new_config['auth_flash_pm'] = $auth_flash_pm;
		if($cfgrow['enable_pm_icons'] != $enable_pm_icons)$new_config['enable_pm_icons'] = $enable_pm_icons;
		foreach($new_config as $config_name => $value)
		{
			set_config($config_name, $value);
		}
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=settings_pm",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['_admsaved'],
                                ));
		echo $template->fetch('message_body.html');
		die();
	}
				$hidden = build_hidden_fields(array(
							'do'		=> 'save',
							'i'			=> 'siteinfo',
							'op'		=> 'settings_pm',
						));
				$template->assign_vars(array(
				'L_TITLE'					=> 'Private message settings',
				'L_TITLE_EXPLAIN'			=> 'Here you can set all default settings for private messaging.',
				'U_ACTION'					=> "./admin.php",
				'S_FORM_TOKEN'			=> $hidden,
				));
	drawRow("sitename","text", false ,'General settings');
	drawRow("allow_privmsg","selecty_n",NULL,false,'allow_privmsg');
	drawRow("pm_max_boxes","text");
	drawRow('pm_max_msgs','text');
	drawRow('full_folder_action','select',$user->lang["PMFULLOPTION"]);
	drawRow('pm_edit_time','text',NULL,false,'Minutes');
	drawRow("sitename","text", false ,'General options');
	drawRow("allow_mass_pm","selecty_n",NULL,false,'allow_mass_pm');
	drawRow("auth_bbcode_pm","selecty_n",NULL,false,'auth_bbcode_pm');
	drawRow("auth_smilies_pm","selecty_n",NULL,false,'auth_smilies_pm');
	drawRow("allow_pm_attach","selecty_n",NULL,false,'allow_pm_attach');
	drawRow("allow_sig_pm","selecty_n",NULL,false,'allow_sig_pm');
	drawRow("print_pm","selecty_n",NULL,false,'print_pm');
	drawRow("forward_pm","selecty_n",NULL,false,'forward_pm');
	drawRow("auth_img_pm","selecty_n",NULL,false,'auth_img_pm');
	drawRow("auth_flash_pm","selecty_n",NULL,false,'auth_flash_pm');
	drawRow("enable_pm_icons","selecty_n",NULL,false,'enable_pm_icons');
echo $template->fetch('admin/site_settings.html');
		close_out();
?>