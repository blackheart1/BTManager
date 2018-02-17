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
* @version $Id: 3.0.0 chat.php  2010-11-04 00:22:48 joeroberts $
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
$template = new Template();
set_site_var($user->lang['IRC_CHAT']);
function build_hidden_parms($field_ary, $specialchar = false, $stripslashes = false)
{
	$s_hidden_fields = '';

	foreach ($field_ary as $name => $vars)
	{
		$name = ($stripslashes) ? stripslashes($name) : $name;
		$name = ($specialchar) ? htmlspecialchars($name, ENT_COMPAT, 'UTF-8') : $name;

		$s_hidden_fields .= _build_hidden_parms($name, $vars, $specialchar, $stripslashes);
	}

	return $s_hidden_fields;
}
function _build_hidden_parms($key, $value, $specialchar, $stripslashes)
{
	$hidden_fields = '';

	if (!is_array($value))
	{
		$value = ($stripslashes) ? stripslashes($value) : $value;
		$value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;
		echo $val;

		$hidden_fields .= '<param name="' . $key . '" value="' . $value . '">' . "\n";
	}
	else
	{
		foreach ($value as $_key => $_value)
		{
			$_key = ($stripslashes) ? stripslashes($_key) : $_key;
			$_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;

			$hidden_fields .= _build_hidden_parms($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
		}
	}

	return $hidden_fields;
}
$ircconfig = parse_ini_file("include/irc.ini");
$nick = preg_replace("/[^a-z0-9_]/i","",$user->name);
if($user->nick != "")$nick2 = preg_replace("/[^a-z0-9_]/i","",$user->nick);
else
$nick2 = $nick."@bittorrent.".$cookiedomain;
$parms = array(
			'CABINETS'					=>	'pjirc/irc.cab,pjirc/securedirc.cab,pjirc/pixx.cab',
			'nick'						=>	$nick,
			'alternatenick'				=>	$nick2,
			'name'						=>	$user->name,
			'host'						=>	$ircconfig["server"],
			'language'					=>	"pjirc/".$language,
			'pixx:language'				=>	"pjirc/pixx-".$language,
			'gui'						=>	'pixx',
			'soundbeep'					=>	'pjirc/snd/bell2.au',
			'soundquery'				=>	'pjirc/snd/ding.au',
			'command1'					=>	"/join ".$ircconfig["channel"],
			'style:bitmapsmileys'		=>	'true',
			);


	
	$sql = "SELECT code, file FROM ".$db_prefix."_smiles GROUP BY file ORDER BY code ASC;";
$res = $db->sql_query($sql);
$i = 1;
$num = $db->sql_numrows($res);
$smlilie_list = '';
while (list($code, $file) = $db->fetch_array($res)) {
        $parms['style:smiley' . $i]		= $code . " smiles/" . $file;
        $i++;
}
$db->sql_freeresult($res);
//Other eventual parameters by .ini file
foreach ($ircconfig as $key=>$val) {
        if ($key == "server" OR $key == "channel") continue;
        $parms[$key]		= ($val == '')? 'false' : $val;
}
$template->assign_vars(array(
						'PARMS'				=>	build_hidden_parms($parms),
						));
echo $template->fetch('chat.html');
close_out();
?>