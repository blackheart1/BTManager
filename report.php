<?php
/*
*------------------------------phpMyBitTorrent V 3.0.0-------------------------* 
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
*--------            ©2013 BT.Manager Development Team                 --------*
*-----------               http://btmagaer.com                      -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, April 14, 2013 4:41 PM    ---------------------*
*
*
* report.php
*
* @package language
* @version $Id$
* @copyright (c) 2013 BT.Manager Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
include_once("include/forum_config.php");
include'include/functions_forum.php';
include'include/utf/utf_tools.php';
$template = new Template();
$user->set_lang('mcp',$user->ulanguage);
set_site_var($user->lang['FORUM']);

$forum_id		= request_var('f', 0);
$post_id		= request_var('p', 0);
$reason_id		= request_var('reason_id', 0);
$report_text	= utf8_normalize_nfc(request_var('report_text', '', true));
$user_notify	= ($user->user) ? request_var('notify', 0) : false;

$submit = (isset($_POST['submit'])) ? true : false;

if (!$post_id)
{
	trigger_error('NO_POST_SELECTED');
}

$redirect_url = append_sid("{$phpbb_root_path}forum.$phpEx", "action=viewforum&f=$forum_id&p=$post_id") . "#p$post_id";

// Has the report been cancelled?
if (isset($_POST['cancel']))
{
	redirect($redirect_url);
}

// Grab all relevant data
$sql = 'SELECT t.*, p.*
	FROM ' . $db_prefix . '_posts p, ' . $db_prefix . "_topics t
	WHERE p.post_id = $post_id
		AND p.topic_id = t.topic_id";
$result = $db->sql_query($sql);
$report_data = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$report_data)
{
	trigger_error('POST_NOT_EXIST');
}

$forum_id = (int) ($report_data['forum_id']) ? $report_data['forum_id'] : $forum_id;
$topic_id = (int) $report_data['topic_id'];

$sql = 'SELECT *
	FROM ' . $db_prefix . '_forums
	WHERE forum_id = ' . $forum_id;
$result = $db->sql_query($sql);
$forum_data = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$forum_data)
{
	trigger_error('FORUM_NOT_EXIST');
}

// Check required permissions
$acl_check_ary = array('f_list' => 'POST_NOT_EXIST', 'f_read' => 'USER_CANNOT_READ', 'f_report' => 'USER_CANNOT_REPORT');

foreach ($acl_check_ary as $acl => $error)
{
	if (!$auth->acl_get($acl, $forum_id))
	{
		trigger_error($error);
	}
}
unset($acl_check_ary);

if ($report_data['post_reported'])
{
	$message = $user->lang['ALREADY_REPORTED'];
	$message .= '<br /><br />' . sprintf($user->lang['RETURN_TOPIC'], '<a href="' . $redirect_url . '">', '</a>');
	trigger_error($message);
}

// Submit report?
if ($submit && $reason_id)
{
	$sql = 'SELECT *
		FROM ' . $db_prefix . "_reports_reasons
		WHERE reason_id = $reason_id";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if (!$row || (!$report_text && strtolower($row['reason_title']) == 'other'))
	{
		trigger_error('EMPTY_REPORT');
	}

	$sql_ary = array(
		'reason_id'		=> (int) $reason_id,
		'post_id'		=> $post_id,
		'user_id'		=> (int) $user->id,
		'user_notify'	=> (int) $user_notify,
		'report_closed'	=> 0,
		'report_time'	=> (int) time(),
		'report_text'	=> (string) $report_text
	);

	$sql = 'INSERT INTO ' . $db_prefix . '_reports ' . $db->sql_build_array('INSERT', $sql_ary);
	$db->sql_query($sql);
	$report_id = $db->sql_nextid();

	if (!$report_data['post_reported'])
	{
		$sql = 'UPDATE ' . $db_prefix . '_posts
			SET post_reported = 1
			WHERE post_id = ' . $post_id;
		$db->sql_query($sql);
	}

	if (!$report_data['topic_reported'])
	{
		$sql = 'UPDATE ' . $db_prefix . '_topics
			SET topic_reported = 1
			WHERE topic_id = ' . $report_data['topic_id'] . '
				OR topic_moved_id = ' . $report_data['topic_id'];
		$db->sql_query($sql);
	}

	meta_refresh(3, $redirect_url);

	$message = $user->lang['POST_REPORTED_SUCCESS'] . '<br /><br />' . sprintf($user->lang['RETURN_TOPIC'], '<a href="' . $redirect_url . '">', '</a>');
	trigger_error($message);
}

// Generate the reasons
display_reasons($reason_id);

$template->assign_vars(array(
	'REPORT_TEXT'		=> $report_text,
	'S_REPORT_ACTION'	=> append_sid("{$phpbb_root_path}report.$phpEx", 'f=' . $forum_id . '&amp;p=' . $post_id),

	'S_NOTIFY'			=> $user_notify,
	'S_CAN_NOTIFY'		=> ($user->data['is_registered']) ? true : false)
);

generate_forum_nav($forum_data);
make_jumpbox(append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum"), $forum_id,false,false,true);

// Start output of page
echo $template->fetch('report_body.html');
close_out();
?>