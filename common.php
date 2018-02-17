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
*------              2009 phpMyBitTorrent Development Team              ------* 
*-----------               http://phpmybittorrent.com               -----------* 
*------------------------------------------------------------------------------* 
*-----------------   Sunday, September 14, 2008 9:05 PM   ---------------------* 
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 common.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/ 
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (!ini_get('display_errors')) {
	@ini_set('error_reporting', E_ALL);
    @ini_set('display_errors', 1);
}
require_once("include/errors.php");
$old_error_handler = set_error_handler("myErrorHandler");
$startpagetime = microtime();
if($_SERVER["PHP_SELF"] == '')$_SERVER["PHP_SELF"] = 'index.php';
if (!function_exists("sha1")) require_once("include/sha1lib.php");
require_once("include/config.php"); //if config file has not been loaded yet
		set_include_path($sourcedir);
		ini_set('include_path',$sourcedir);
		date_default_timezone_set($pmbt_time_zone);
include_once'include/class.template.php';
require_once("include/actions.php");
require_once("include/user.functions.php");
include'include/auth.php';
if (is_banned($user, $reason) && !preg_match("/ban.php/",$_SERVER["PHP_SELF"]))
{
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
		<html>
			<head>
			<meta http-equiv=\"refresh\" content=\"0;url=ban.php?reson=".urlencode($reason)."\">
			</head>
			<body>Banned</body>
		</html>";
        die();
}
if (!preg_match("/cron.php/",$_SERVER['PHP_SELF']))
{
	if($pivate_mode AND !$user->user AND !newuserpage($_SERVER["PHP_SELF"]))
	{
		//die($_SERVER["PHP_SELF"]);
		$a = 0;
		$returnto = '';
		while (list($var,$val) = each($_GET))
		{
			$returnto .= "&$var=$val";
			$a++;
		}
		$i = strpos($returnto, "&return=");
		if ($i !== false)
		{
			$returnto = substr($returnto, $i + 8);
		}
				$pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
		$returnto ='?page=' . $pagename . $returnto;
		$template = new Template();
										set_site_var($user->lang['BT_ERROR']);
								meta_refresh(5, $siteurl . "/login.php$returnto");
										$template->assign_vars(array(
												'S_ERROR'			=> true,
												'S_FORWARD'			=> $siteurl."/login.php$returnto",
												'TITTLE_M'          => $user->lang['BT_ERROR'],
												'MESSAGE'           => $user->lang['LOGIN_SITE'],
										));
				echo $template->fetch('message_body.html');
				close_out();
	}
	$auth = new auth();
	$auth->acl($user);
	if($user->user  && !preg_match("/httperror.php/",$_SERVER['PHP_SELF'])  && !preg_match("/file.php/",$_SERVER['PHP_SELF']) && !preg_match("/ajax.php/",$_SERVER['PHP_SELF']))
	{
		$ip = getip();
        $sql = "UPDATE ".$db_prefix."_users 
					SET 
						lastip = '".sprintf("%u",ip2long($ip))."', 
						lastpage = '".addslashes(str_replace("/", '',substr($_SERVER['REQUEST_URI'],strrpos($_SERVER["REQUEST_URI"],"/")+1)))."', 
						lastlogin = NOW() 
					WHERE 
						id = '".$user->id."' 
					LIMIT 1;";
        $db->sql_query($sql)or btsqlerror($sql);
	}
}
?>