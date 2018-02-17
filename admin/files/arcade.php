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
		$user->set_lang('admin/arcade',$user->ulanguage);
		$mode			= request_var('mode', 'manage');
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE'		=> $user->lang['ARCADE'],
							'S_SELECTED'	=> true,
							'U_TITLE'		=> '1',));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('settings' ==$mode)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['A_SETTINGS'],
							'U_TITLE' => append_sid($u_action, 'mode=settings'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('manage' ==$mode)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['A_MANAGE'],
							'U_TITLE' => append_sid($u_action, 'mode=manage'),
							));
		require_once 'admin/files/acp_arcade.php';
		$arcade = new acp_arcade($u_action);
		$module_id		= request_var('id', '');
		$arcade->main($module_id, $mode);
		$template->assign_vars(array(
			'ICON_EDIT'					=> '<img src="themes/' . $themne . '/pics/edit.gif" alt="Edit" title="Edit" border="0">',
			'ICON_DELETE'				=> '<img src="themes/' . $themne . '/pics/drop.gif" alt="Delete" title="Delete" border="0">',
			'ACP_BBCODES'				=> 'BBCodes',
		));
		echo $template->fetch('admin/' . $arcade->tpl_name . '.html');
		close_out();
?>