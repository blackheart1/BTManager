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
*------              �2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 httperror.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
//die('test');
//require_once("include/torrent_functions.php");
$errid												= request_var('errid', '');

$template = new Template();
$user->set_lang('httperror',$user->ulanguage);

switch ($errid) {
        case 400: {
                header("HTTP/1.0 400 Bad request");
				$e = 'A';
                break;
        }
        case 401: {
                header("HTTP/1.0 401 Access Denied");
				$e = 'B';
                break;
        }
        case 403: {
                header("HTTP/1.0 403 Forbidden");
				$e = 'C';
                break;
        }
        case 404: {
                header("HTTP/1.0 404 Access Denied");
				$e = 'D';
                break;
        }
        case 500: {
                header("HTTP/1.0 500 Internal Server Error");
				$e = 'E';
                break;
        }
}
								set_site_var($user->lang['BT_ERROR']);
                                $template->assign_vars(array(
										'S_ERROR'			=> true,
										//'S_FORWARD'			=> $siteurl.'/index.php',
								        'TITTLE_M'          => $user->lang[$e . '_ERROR_TTL'],
                                        'MESSAGE'           => sprintf($user->lang[$e . '_ERROR_EXP'],$admin_email) . $_SERVER["REQUEST_URI"],
                                ));
		echo $template->fetch('message_body.html');
		//close_out();

?>