<?php
/**
**********************
** BTManager v3.0.1 **
**********************
** http://www.btmanager.org/
** https://github.com/blackheart1/BTManager
** http://demo.btmanager.org/index.php
** Licence Info: GPL
** Copyright (C) 2018
** Formerly Known As phpMyBitTorrent
** Created By Antonio Anzivino (aka DJ Echelon)
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File ucp_pm_functions.php 2018-02-20 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once 'security.php';
	die ("You can't access this file directly");
}
// grab the counts of all users that have PMs
function rpm_get_pm_users($totalpms)
{
	global $db, $db_prefix;
	$res = "SELECT COUNT(`pm`.`recipient`) AS total, REPLACE(`pm`.`recipient`, 'u_', '') as `recipient`, `user`.`can_do`, `user`.`uploaded`, `user`.`downloaded`, `user`.`lastlogin`, `user`.`username`, `user`.`id` AS `userid`,`group`.`group_colour` as color FROM `" . $db_prefix . "_private_messages` AS `pm` INNER JOIN `" . $db_prefix . "_users` AS `user` ON (REPLACE(`recipient`, 'u_', '') = `user`.`id`) INNER JOIN `" . $db_prefix . "_level_settings` AS `group` ON (`user`.`can_do` = `group`.`group_id`) WHERE REPLACE(`recipient`, 'u_', '') = `user`.`id` GROUP BY recipient HAVING total = " . $totalpms . " ORDER BY `pm`.`recipient` DESC ";
	$pms=$db->sql_query($res) or btsqlerror($res);
	return $pms;
}
function rpm_get_all_pm_users()
{
	global $db, $db_prefix;
	$totals = $db->sql_query("
		SELECT COUNT(*) AS total, `recipient`
		FROM `" . $db_prefix . "_private_messages`
		GROUP BY `recipient`
		ORDER BY total DESC
	");
	return $totals;
}
function rpm_get_pm($pmtextid)
{
	global $db, $db_prefix;
	$pmsql = "
		SELECT 
			`pm`.`sender`, 
			`pm`.`text`, 
			`pm`.`sent`, 
			`pm`.`subject`, 
			`pm`.`bbcode_bitfield`, 
			`pm`.`bbcode_uid`, 
			`pm`.`message_attachment`, 
			`autgroup`.`group_name` as autgroup_name,
			`autgroup`.`group_colour` as aut_colour,
			`group`.`group_colour` as rec_colour,
			`autuser`.`can_do` as autcan_do, 
			`recuser`.`can_do` as reccan_do, 
			`recuser`.`username` as recusername, 
			`autuser`.`username` as autusername, 
			REPLACE(`pm`.`recipient`, 'u_', '') as `recipient`
		FROM `" . $db_prefix . "_private_messages` AS pm
		LEFT JOIN 
			`" . $db_prefix . "_users` AS `autuser` ON `pm`.`sender` = `autuser`.`id` 
		LEFT JOIN 
			`" . $db_prefix . "_users` AS `recuser` ON REPLACE(`recipient`, 'u_', '') = `recuser`.`id` 
		LEFT JOIN 
			`" . $db_prefix . "_level_settings` AS `group` ON `recuser`.`can_do` = `group`.`group_id`
		LEFT JOIN 
			`" . $db_prefix . "_level_settings` AS `autgroup` ON `autuser`.`can_do` = `autgroup`.`group_id`
		WHERE `pm`.`id` = " . $pmtextid;
		$pmq = $db->sql_query($pmsql) or btsqlerror($pmsql);
	$get_pm = $db->sql_fetchrow($pmq);
	return $get_pm;
}
function print_description_row($text, $htmlise = false, $colspan = 2, $class = '', $align = '', $helpname = NULL)
{
	global $stylevar;

	if (!$class)
	{
		//$class = fetch_row_bgclass();
	}


	echo "<tr valign=\"top\">
	<td class=\"$class\"" . iif($colspan != 1," colspan=\"$colspan\"") . iif($align, " align=\"$align\"") . ">" . iif($htmlise, htmlspecialchars_uni($text), $text) . "</td>\n</tr>\n";
}
function rpm_user_exists($userid)
{
	global $db, $db_prefix;
	$exists = $db->sql_fetchrow($db->sql_query("
		SELECT `id`
		FROM `" . $db_prefix . "_users`
		WHERE `id` = " . $userid . "
	"));
	if ($exists)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function print_table_footer($colspan = 2, $rowhtml = '', $tooltip = '', $echoform = true)
{
	global $tableadded, $vbulletin;

	if ($rowhtml)
	{
		$tooltip = iif($tooltip != '', " title=\"$tooltip\"", '');
		if ($tableadded)
		{
			echo "<tr>\n\t<td class=\"tfoot\"" . iif($colspan != 1 ," colspan=\"$colspan\"") . " align=\"center\"$tooltip>$rowhtml</td>\n</tr>\n";
		}
		else
		{
			echo "<p align=\"center\"$tooltip>$extra</p>\n";
		}
	}

	if ($tableadded)
	{
		echo "</table>\n";
	}

	if ($echoform)
	{

		echo "</form>\n\n\n";
	}
}
function rpm_username_exists($username)
{
	global $db, $db_prefix;
	$exists = $db->sql_fetchrow($db->sql_query("
		SELECT `id`
		FROM `" . $db_prefix . "_users`
		WHERE LOWER(`username`) = LOWER('" . $username . "')
	"));
	if ($exists)
	{
		return $exists['id'];
	}
	else
	{
		return false;
	}
}
function rpm_get_name($userid)
{
	global $db, $db_prefix;
	$result = $db->sql_fetchrow($db->sql_query("
		SELECT `username`
		FROM `" . $db_prefix . "_users`
		WHERE `id` = " . $userid . "
	"));
	return $result['username'];
}
// search for PMs that match key search terms
function rpm_search_pms($search_for, $match)
{
	global $db, $db_prefix;
	if ($match == 'exact')
	{
		$ands = $search_for;
	}
	elseif ($match == 'all')
	{
		$a = explode(' ', $search_for);
		$ands = implode("%' AND `message` LIKE '%", $a);
	}
	else
	{
		$a = explode(' ', $search_for);
		$ands = implode("%' OR `text` LIKE '%", $a);
	}
	
		$sql = "SELECT 
				DISTINCT `pm`.`id`, 
			`pm`.`sender`, 
			`pm`.`text`, 
			`pm`.`sent`, 
			`pm`.`subject`, 
			`pm`.`bbcode_bitfield`, 
			`pm`.`bbcode_uid`, 
			`pm`.`message_attachment`, 
			`autgroup`.`group_name` as autgroup_name,
			`autgroup`.`group_colour` as aut_colour,
			`group`.`group_colour` as rec_colour,
			`autuser`.`can_do` as autcan_do, 
			`recuser`.`can_do` as reccan_do, 
			`recuser`.`username` as recusername, 
			`autuser`.`username` as autusername, 
			REPLACE(`pm`.`recipient`, 'u_', '') as `recipient`
			FROM 
				`" . $db_prefix . "_private_messages` AS pm
			LEFT JOIN 
				`" . $db_prefix . "_users` AS `autuser` ON `pm`.`sender` = `autuser`.`id` 
			LEFT JOIN 
				`" . $db_prefix . "_users` AS `recuser` ON REPLACE(`recipient`, 'u_', '') = `recuser`.`id` 
			LEFT JOIN 
				`" . $db_prefix . "_level_settings` AS `group` ON `recuser`.`can_do` = `group`.`group_id`
			LEFT JOIN 
				`" . $db_prefix . "_level_settings` AS `autgroup` ON `autuser`.`can_do` = `autgroup`.`group_id`
			WHERE `text` LIKE '%" . $ands . "%'
			ORDER BY `sent` DESC";
	$result = $db->sql_query($sql);
	$pms = array();
	while($array = $db->sql_fetchrow($result))
	{
		$pms[] = $array;
	}
$db->sql_freeresult($result);
	return $pms;
}
function rpm_get_latest_pms($limit_by)
{
	global $db, $db_prefix;
	$res = "
		SELECT 
			`pm`.`id`, 
			`pm`.`sender`, 
			`pm`.`text`, 
			`pm`.`sent`, 
			`pm`.`subject`, 
			`pm`.`bbcode_bitfield`, 
			`pm`.`bbcode_uid`, 
			`pm`.`message_attachment`, 
			`autgroup`.`group_name` as autgroup_name,
			`autgroup`.`group_colour` as aut_colour,
			`group`.`group_colour` as rec_colour,
			`autuser`.`can_do` as autcan_do, 
			`recuser`.`can_do` as reccan_do, 
			`recuser`.`username` as recusername, 
			`autuser`.`username` as autusername, 
			REPLACE(`pm`.`recipient`, 'u_', '') as `recipient`
			FROM 
				`" . $db_prefix . "_private_messages` AS pm
			LEFT JOIN 
				`" . $db_prefix . "_users` AS `autuser` ON `pm`.`sender` = `autuser`.`id` 
			LEFT JOIN 
				`" . $db_prefix . "_users` AS `recuser` ON REPLACE(`recipient`, 'u_', '') = `recuser`.`id` 
			LEFT JOIN 
				`" . $db_prefix . "_level_settings` AS `group` ON `recuser`.`can_do` = `group`.`group_id`
			LEFT JOIN 
				`" . $db_prefix . "_level_settings` AS `autgroup` ON `autuser`.`can_do` = `autgroup`.`group_id`
		ORDER BY `sent` DESC
		LIMIT 0, " . $limit_by . "
	";
	$result = $db->sql_query($res) or btsqlerror($res);
	$pms = array();
	while($array = $db->sql_fetchrow($result))
	{
		$pms[] = $array;
	}
$db->sql_freeresult($result);
	return $pms;
}
function rpm_get_pms($userid)
{
	global $db, $db_prefix;
	$res = "
		SELECT 	*
		FROM `" . $db_prefix . "_private_messages` AS pm
		WHERE pm.sender=" . $userid . " OR pm.recipient='u_" . $userid . "'
		ORDER BY `sent` DESC
	";
	$result = $db->sql_query($res) or btsqlerror($res);
	$pms = array();
	while($array = $db->sql_fetchrow($result))
	{
		$pms[] = $array;
	}
$db->sql_freeresult($result);
	return $pms;
}
function print_cells_row($array, $isheaderrow = false, $class = false, $i = 0, $valign = 'top', $column = false, $smallfont = false)
{
	global $colspan, $bgcounter, $stylevar;

	if (is_array($array))
	{
		$colspan = sizeof($array);
		if ($colspan)
		{
			$j = 0;
			$doecho = 0;

			if (!$class AND !$column AND !$isheaderrow)
			{
				//$bgclass = fetch_row_bgclass();
			}
			elseif ($isheaderrow)
			{
				$bgclass = 'thead';
			}
			else
			{
				$bgclass = $class;
			}

			//$bgcounter = iif($column, 0, $bgcounter);
			$out = "<tr valign=\"$valign\" align=\"center\">\n";

			foreach($array AS $key => $val)
			{
				$j++;
				if ($val == '' AND !is_int($val))
				{
					$val = '&nbsp;';
				}
				else
				{
					$doecho = 1;
				}

				if ($i++ < 1)
				{
					$align = " align=\"$stylevar[left]\"";
				}
				elseif ($j == $colspan AND $i == $colspan AND $j != 2)
				{
					$align = " align=\"$stylevar[right]\"";
				}
				else
				{
					$align = '';
				}

				if (!$class AND $column)
				{
					$bgclass = fetch_row_bgclass();
				}
				if ($smallfont)
				{
					$val = "<span class=\"smallfont\">$val</span>";
				}
				$out .= "\t<td" . "$align>$val</td>\n";
			}

			$out .= "</tr>\n";

			if ($doecho)
			{
				echo $out;
			}
		}
	}
}
function print_label_row($title, $value = '&nbsp;', $class = '', $valign = 'top', $helpname = NULL, $dowidth = false)
{
	global $stylevar;

	if (!$class)
	{
		$class = fetch_row_bgclass();
	}

	if ($helpname !== NULL AND $helpbutton = construct_table_help_button($helpname))
	{
		$value = '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr valign="top"><td>' . $value . "</td><td align=\"$stylevar[right]\" style=\"padding-$stylevar[left]:4px\">$helpbutton</td></tr></table>";
	}

	if ($dowidth)
	{
		if (is_numeric($dowidth))
		{
			$left_width = $dowidth;
			$right_width = 100 - $dowidth;
		}
		else
		{
			$left_width = 70;
			$right_width = 30;
		}
	}

	echo "<tr valign=\"$valign\">
	<td class=\"$class\"" . ($dowidth ? " width=\"$left_width%\"" : '') . ">$title</td>
	<td class=\"$class\"" . ($dowidth ? " width=\"$right_width%\"" : '') . ">$value</td>\n</tr>\n";
}
function rpm_print_stop_back($text = 'error')
{
	global $vbphrase;
	echo '<p>&nbsp;</p><p>&nbsp;</p>';
	print_form_header('', '', 0, 1, 'messageform', '65%');
	print_table_header($vbphrase['vbulletin_message']);
	print_description_row("<blockquote><br />$text<br /><br /></blockquote>");
	print_table_footer(2, '<input class="button" value="Go Back" title="" tabindex="1" onclick="window.location=\'javascript:history.back(1)\';" type="button">');
	rpm_print_footer();
}
?>