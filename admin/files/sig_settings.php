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
*------                �2014 BT.Manager Development Team                 ------*
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
		$allow_sig						= request_var('sub_allow_sig', 0);
		$allow_sig_bbcode				= request_var('sub_allow_sig_bbcode', 0);
		$allow_sig_img					= request_var('sub_allow_sig_img', 0);
		$allow_sig_flash				= request_var('sub_allow_sig_flash', 0);
		$allow_sig_smilies				= request_var('sub_allow_sig_smilies', 0);
		$allow_sig_links				= request_var('sub_allow_sig_links', 0);
		$max_sig_links				= request_var('sub_max_sig_links', 0);
		$max_sig_chars					= request_var('sub_max_sig_chars', 0);
		$max_sig_urls					= request_var('sub_max_sig_urls', 0);
		$max_sig_font_size				= request_var('sub_max_sig_font_size', 0);
		$max_sig_smilies				= request_var('sub_max_sig_smilies', 0);
		$max_sig_img_width				= request_var('sub_max_sig_img_width', 0);
		$max_sig_img_height				= request_var('sub_max_sig_img_height', 0);
		if($cfgrow['allow_sig'] != $allow_sig)$new_config['allow_sig'] = $allow_sig;
		if($cfgrow['allow_sig_bbcode'] != $allow_sig_bbcode)$new_config['allow_sig_bbcode'] = $allow_sig_bbcode;
		if($cfgrow['allow_sig_img'] != $allow_sig_img)$new_config['allow_sig_img'] = $allow_sig_img;
		if($cfgrow['allow_sig_flash'] != $allow_sig_flash)$new_config['allow_sig_flash'] = $allow_sig_flash;
		if($cfgrow['allow_sig_smilies'] != $allow_sig_smilies)$new_config['allow_sig_smilies'] = $allow_sig_smilies;
		if($cfgrow['allow_sig_links'] != $allow_sig_links)$new_config['allow_sig_links'] = $allow_sig_links;
		if($cfgrow['max_sig_chars'] != $max_sig_chars)$new_config['max_sig_chars'] = $max_sig_chars;
		if($cfgrow['max_sig_urls'] != $max_sig_urls)$new_config['max_sig_urls'] = $max_sig_urls;
		if($cfgrow['max_sig_font_size'] != $max_sig_font_size)$new_config['max_sig_font_size'] = $max_sig_font_size;
		if($cfgrow['max_sig_smilies'] != $max_sig_smilies)$new_config['max_sig_smilies'] = $max_sig_smilies;
		if($cfgrow['max_sig_img_width'] != $max_sig_img_width)$new_config['max_sig_img_width'] = $max_sig_img_width;
		if($cfgrow['max_sig_img_height'] != $max_sig_img_height)$new_config['max_sig_img_height'] = $max_sig_img_height;
		if($cfgrow['max_sig_links'] != $max_sig_links)$new_config['max_sig_links'] = $max_sig_links;
	//	die(print_r($new_config));
		foreach($new_config as $config_name => $config_value)
		{
			set_config($config_name, $config_value);
			//$db->sql_query('UPDATE ' . $db_prefix . '_settings SET config_value = \'' . $value . "' WHERE config_name = '" . $key . "' LIMIT 1;")or mysql_error();
		}
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=sig_settings",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['_admsaved'],
                                ));
		echo $template->fetch('message_body.html');
		die();
	}
				$hidden = build_hidden_fields(array(
							'do'		=> 'save',
							'i'			=> 'siteinfo',
							'op'		=> 'sig_settings',
						));
				$template->assign_vars(array(
				'L_TITLE'					=> $user->lang['MENU_SIG_SETTINGS'],
				'L_TITLE_EXPLAIN'			=> $user->lang['MENU_SIG_SETTINGS_EXP'],
				'U_ACTION'					=> "./admin.php",
				'S_FORM_TOKEN'			=> $hidden,
				));
	drawRow("sitename","text", false ,'General settings');
	drawRow("allow_sig","selecty_n",NULL,false,'allow_sig');
	drawRow("allow_sig_bbcode","selecty_n",NULL,false,'allow_sig_bbcode');
	drawRow("allow_sig_img","selecty_n",NULL,false,'allow_sig_img');
	drawRow("allow_sig_flash","selecty_n",NULL,false,'allow_sig_flash');
	drawRow("allow_sig_smilies","selecty_n",NULL,false,'allow_sig_smilies');
	drawRow("allow_sig_links","selecty_n",NULL,false,'allow_sig_links');
	drawRow("sitename","text", false ,'General Options');
	drawRow('max_sig_chars','text');
	drawRow('max_sig_urls','text');
	drawRow('max_sig_font_size','text',NULL,false,'%');
	drawRow('max_sig_smilies','text');
	drawRow('max_sig_img_width','text',NULL,false,'px');
	drawRow('max_sig_img_height','text',NULL,false,'px');
echo $template->fetch('admin/site_settings.html');
		close_out();

?>