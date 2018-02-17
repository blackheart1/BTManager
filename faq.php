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
* @version $Id: 3.0.0 faq.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/ 
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
require_once("include/torrent_functions.php");
//$user->set_lang('faq',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['TITTLE']);
$res1 = "SELECT * FROM `".$db_prefix."_faq` ORDER BY `id` ASC;";
$res = $db->sql_query($res1);
$help_set = array();
while ($arr = $db->sql_fetchrow($res)) {
	if($arr['type'] == 'categ')
	{
		$help_set[$arr['id']] = array(0=>'--', 1=>$arr['question'],2=>array());
	}
	else
	{
		$help_set[$arr['categ']][2][] = array(0=>$arr['question'], 1=>$arr['answer']);
	}
}
$db->sql_freeresult($res);
$help = array();
$i = 0;
foreach($help_set as $var)
{
array_push($help,array('--',stripslashes($var[1])));
if($var[2])
{
foreach($var[2] as $val)
{
array_push($help,array(stripslashes($val[0]),stripslashes($val[1])));
}
}
$i++;
if($i == '5')
{
array_push($help,array('--','--'));
}
}
$switch_column = $found_switch = false;
$help_blocks = array();
foreach ($help as $help_ary)
{
	if ($help_ary[0] == '--')
	{
		if ($help_ary[1] == '--')
		{
			$switch_column = true;
			$found_switch = true;
			continue;
		}

		$template->assign_block_vars('faq_block', array(
			'BLOCK_TITLE'		=> $help_ary[1],
			'SWITCH_COLUMN'		=> $switch_column,
		));

		if ($switch_column)
		{
			$switch_column = false;
		}
		continue;
	}

	$template->assign_block_vars('faq_block.faq_row', array(
		'FAQ_QUESTION'		=> $help_ary[0],
		'FAQ_ANSWER'		=> $help_ary[1])
	);
}

// Lets build a page ...
$template->assign_vars(array(
	'L_FAQ_TITLE'				=> $user->lang['FAQ_EXPLAIN'],
	'L_BACK_TO_TOP'				=> $user->lang['BACK_TO_TOP'],

	'SWITCH_COLUMN_MANUALLY'	=> (!$found_switch) ? true : false,
));
	echo $template->fetch('faq.html');
	close_out();
?>