<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 upload.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
//die('test');


if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
$user->set_lang('upload',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['UPLOAD']);
if(!checkaccess("u_upload")){
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['GROUP_NO_ACCESS_PAGE'],
				));
				echo $template->fetch('message_body.html');
				close_out();
}
$pop = request_var('pop','');
if($pop == 'smilies')
{
			$form	= request_var('form', '');
			$area	= request_var('area', '');
				$template->assign_vars(array(
					'FORM'			=> $form,
					'AREA'			=> $area,
				));
			$sql = "SELECT * FROM ".$db_prefix."_smiles GROUP BY file ORDER BY id ASC;";
			$smile_res = $db->sql_query($sql);
			$smile_count = 0;
			while ($smile = $db->sql_fetchrow($smile_res))
			{
				$template->assign_block_vars('smilies',array(
				'ID'			=>	$smile["id"],
				'CODE'			=>	$smile["code"],
				'FILE'			=>	$smile["file"],
				'ALT'			=>	$smile["alt"],
				'S_ROW_COUNT'	=>	$smile_count++,
				));
			}
				echo $template->fetch('smilies.html');
				close_out();
}
$op	= request_var('op', '');
	$template->assign_vars(array(
		'L_TITLE'					=> $user->lang['UPLOAD'],
		'L_INTRO'					=> $user->lang['INTRO'],
		'L_INTRO_EXP'				=> $user->lang['INTRO_EXP_SEL'],
		'S_MESSAGE'					=> false,
		'S_NOTICE'					=> false,
		'S_ACTION'					=> $op,
	));
		$postback			= request_var('postback', '');
switch ($op) {
        case "torrent": {
                include_once("upload/torrent.php");
                break;
        }
        case "link": {
               if(checkaccess('u_can_add_magnet_links')) include_once("upload/link.php");
                break;
        }
        case "taketorrent": {
                include_once("upload/taketorrent.php");
                break;
        }
        case "takelink": {
               if(checkaccess('u_can_add_magnet_links')) include_once("upload/takelink.php");
                break;
        }
}
echo $template->fetch('upload.html');
close_out();
?>