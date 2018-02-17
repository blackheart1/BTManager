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
		foreach($new_config as $key => $value)
		{
						set_config($config_name, $config_value);

			$db->sql_query('UPDATE ' . $db_prefix . '_settings SET config_value = \'' . $value . "' WHERE config_name = '" . $key . "' LIMIT 1;")or mysql_error();
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
echo $template->fetch('admin/site_settings.html');
		close_out();

?>