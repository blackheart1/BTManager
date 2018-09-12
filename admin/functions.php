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
** File functions.php 2018-02-20 14:32:00 Black_Heart
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
/**
* Generate back link for acp pages
*/
function adm_back_link($u_action)
{
	global $user;
	return '<br /><br /><a href="' . $u_action . '">&laquo; ' . $user->lang['BACK_TO_PREV'] . '</a>';
}

/**
* Tidy database, doing some maintanance tasks
*/
function tidy_database()
{
	global $db, $db_prefix, $announce_interval;

	// Here we check permission consistency

	// Sometimes, it can happen permission tables having forums listed which do not exist
	$sql = 'SELECT forum_id
		FROM ' . $db_prefix . '_forums';
	$result = $db->sql_query($sql);

	$forum_ids = array(0);
	while ($row = $db->sql_fetchrow($result))
	{
		$forum_ids[] = $row['forum_id'];
	}
	$db->sql_freeresult($result);

	// Delete those rows from the acl tables not having listed the forums above
	$sql = 'DELETE FROM ' . $db_prefix . '_acl_groups 
		WHERE ' . $db->sql_in_set('forum_id', $forum_ids, true);
	$db->sql_query($sql);

	$sql = 'DELETE FROM ' . $db_prefix . '_acl_users 
		WHERE ' . $db->sql_in_set('forum_id', $forum_ids, true);
	$db->sql_query($sql);
	$local_query = "SHOW TABLE STATUS LIKE '".$db_prefix."_%';";
	$result = $db->sql_query($local_query) or btsqlerror($local_query);
	if ($db->sql_numrows($result) > 0) {
			while ($row = $db->sql_fetchrow($result)) {
					$local_query = "REPAIR TABLE ".$row['Name'];
					$db->sql_query($local_query) or btsqlerror($local_query);
					$local_query = "OPTIMIZE TABLE ".$row['Name'];
					$resultat  = $db->sql_query($local_query) or btsqlerror($local_query);
					$db->sql_freeresult($resultat);
			}
	}
	$db->sql_freeresult($result);
	$db->sql_query("UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0, speed = 0 WHERE tracker IS NULL;");
	
	$sql = "DELETE FROM ".$db_prefix."_peers WHERE UNIX_TIMESTAMP(last_action) < UNIX_TIMESTAMP(NOW()) - ".intval($announce_interval).";";
	$res = $db->sql_query($sql) or btsqlerror($sql);
	$sql = "SELECT count(*) as tot, torrent, seeder, (SUM(download_speed)+SUM(upload_speed))/2 as speed FROM ".$db_prefix."_peers GROUP BY torrent, seeder;";
	$res = $db->sql_query($sql) or btsqlerror($sql);
	while($row = $db->sql_fetchrow($res)) {
			if ($row["seeder"]=="yes") $sql = "UPDATE ".$db_prefix."_torrents SET seeders= '".$row["tot"]."', speed = speed + '".intval($row["speed"])."' WHERE id='".$row["torrent"]."'; ";
			else $sql = "UPDATE ".$db_prefix."_torrents SET leechers='".$row["tot"]."', speed = speed + '".intval($row["speed"])."' WHERE id='".$row["torrent"]."'; ";
			$db->sql_query($sql);
	}
	
	$db->sql_query("UPDATE ".$db_prefix."_torrents SET tot_peer = seeders + leechers;");
	$db->sql_query("UPDATE ".$db_prefix."_snatched SET seeder = 'no';");
	$sql = "SELECT uid, torrent FROM ".$db_prefix."_peers WHERE seeder = 'yes';";
	$res = $db->sql_query($sql) or btsqlerror($sql);
	while($row = $db->sql_fetchrow($res)) {
		$db->sql_query("UPDATE ".$db_prefix."_snatched SET seeder = 'yes' WHERE userid = '".$row["uid"]."' AND torrentid = '".$row["torrent"]."';");
	}

	set_config('database_last_gc', time(), true);
}
/**
* Tidy Warnings
* Remove all warnings which have now expired from the database
* The duration of a warning can be defined by the administrator
* This only removes the warning and reduces the associated count,
* it does not remove the user note recording the contents of the warning
*/
function tidy_warnings()
{
	global $db, $config, $db_prefix;

	$expire_date = time() - ($config['warnings_expire_days'] * 86400);
	$warning_list = $user_list = array();

	$sql = 'SELECT * FROM ' . $db_prefix . "_warnings
		WHERE warning_time < $expire_date";
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$warning_list[] = $row['warning_id'];
		$user_list[$row['user_id']] = isset($user_list[$row['user_id']]) ? ++$user_list[$row['user_id']] : 1;
	}
	$db->sql_freeresult($result);

	if (sizeof($warning_list))
	{

		$sql = 'DELETE FROM ' . $db_prefix . '_warnings
			WHERE ' . $db->sql_in_set('warning_id', $warning_list);
		$db->sql_query($sql);

		foreach ($user_list as $user_id => $value)
		{
			$sql = 'UPDATE ' . $db_prefix . "_users SET user_warnings = user_warnings - $value
				WHERE id = $user_id";
			$db->sql_query($sql);
		}

	}

	set_config('warnings_last_gc', time(), true);
}
/**
* Generate sort selection fields
*/
function validate_config_vars($config_vars, &$cfg_array, &$error)
{
	global $phpbb_root_path, $user;
	$type	= 0;
	$min	= 1;
	$max	= 2;

	foreach ($config_vars as $config_name => $config_definition)
	{
		if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
		{
			continue;
		}

		if (!isset($config_definition['validate']))
		{
			continue;
		}

		$validator = explode(':', $config_definition['validate']);

		// Validate a bit. ;) (0 = type, 1 = min, 2= max)
		switch ($validator[$type])
		{
			case 'string':
				$length = utf8_strlen($cfg_array[$config_name]);

				// the column is a VARCHAR
				$validator[$max] = (isset($validator[$max])) ? min(255, $validator[$max]) : 255;

				if (isset($validator[$min]) && $length < $validator[$min])
				{
					$error[] = sprintf($user->lang['SETTING_TOO_SHORT'] . 'tolong', $user->lang[$config_definition['lang']], $validator[$min]);
				}
				else if (isset($validator[$max]) && $length > $validator[2])
				{
					$error[] = sprintf($user->lang['SETTING_TOO_LONG']. 'toshort', $user->lang[$config_definition['lang']], $validator[$max]);
				}
			break;

			case 'bool':
				$cfg_array[$config_name] = ($cfg_array[$config_name]) ? 1 : 0;
			break;

			case 'int':
				$cfg_array[$config_name] = (int) $cfg_array[$config_name];

				if (isset($validator[$min]) && $cfg_array[$config_name] < $validator[$min])
				{
					$error[] = sprintf($user->lang['SETTING_TOO_LOW'] . 'tolow', $user->lang[$config_definition['lang']], $validator[$min]);
				}
				else if (isset($validator[$max]) && $cfg_array[$config_name] > $validator[$max])
				{
					$error[] = sprintf($user->lang['SETTING_TOO_BIG']. 'tobig', $user->lang[$config_definition['lang']], $validator[$max]);
				}

				if (strpos($config_name, '_max') !== false)
				{
					// Min/max pairs of settings should ensure that min <= max
					// Replace _max with _min to find the name of the minimum
					// corresponding configuration variable
					$min_name = str_replace('_max', '_min', $config_name);

					if (isset($cfg_array[$min_name]) && is_numeric($cfg_array[$min_name]) && $cfg_array[$config_name] < $cfg_array[$min_name])
					{
						// A minimum value exists and the maximum value is less than it
						$error[] = sprintf($user->lang['SETTING_TOO_LOW'], $user->lang[$config_definition['lang']], (int) $cfg_array[$min_name]);
					}
				}
			break;

			case 'email':
				if (!preg_match('/^' . get_preg_expression('email') . '$/i', $cfg_array[$config_name]))
				{
					//die(print_r($cfg_array));
					$error[] = $user->lang['EMAIL_INVALID_EMAIL_' . strtoupper($config_name)];
				}
			break;

			// Absolute path
			case 'script_path':
				if (!$cfg_array[$config_name])
				{
					break;
				}

				$destination = str_replace('\\', '/', $cfg_array[$config_name]);

				if ($destination !== '/')
				{
					// Adjust destination path (no trailing slash)
					if (substr($destination, -1, 1) == '/')
					{
						$destination = substr($destination, 0, -1);
					}

					$destination = str_replace(array('../', './'), '', $destination);

					if ($destination[0] != '/')
					{
						$destination = '/' . $destination;
					}
				}

				$cfg_array[$config_name] = trim($destination);

			break;

			// Absolute path
			case 'lang':
				if (!$cfg_array[$config_name])
				{
					break;
				}

				//$cfg_array[$config_name] = basename($cfg_array[$config_name]);

				if (!file_exists($phpbb_root_path . 'language/common/' . $cfg_array[$config_name] . '.php'))
				{
					$error[] = $user->lang['WRONG_DATA_LANG'];
				}
			break;

			// Relative path (appended $phpbb_root_path)
			case 'rpath':
			case 'rwpath':
				if (!$cfg_array[$config_name])
				{
					break;
				}

				$destination = $cfg_array[$config_name];

				// Adjust destination path (no trailing slash)
				if (substr($destination, -1, 1) == '/' || substr($destination, -1, 1) == '\\')
				{
					$destination = substr($destination, 0, -1);
				}

				$destination = str_replace(array('../', '..\\', './', '.\\'), '', $destination);
				if ($destination && ($destination[0] == '/' || $destination[0] == "\\"))
				{
					$destination = '';
				}

				$cfg_array[$config_name] = trim($destination);

			// Path being relative (still prefixed by phpbb_root_path), but with the ability to escape the root dir...
			case 'path':
			case 'wpath':

				if (!$cfg_array[$config_name])
				{
					break;
				}

				$cfg_array[$config_name] = trim($cfg_array[$config_name]);

				// Make sure no NUL byte is present...
				if (strpos($cfg_array[$config_name], "\0") !== false || strpos($cfg_array[$config_name], '%00') !== false)
				{
					$cfg_array[$config_name] = '';
					break;
				}

				if (!file_exists($phpbb_root_path . $cfg_array[$config_name]))
				{
					$error[] = sprintf($user->lang['DIRECTORY_DOES_NOT_EXIST'], $cfg_array[$config_name]);
				}

				if (file_exists($phpbb_root_path . $cfg_array[$config_name]) && !is_dir($phpbb_root_path . $cfg_array[$config_name]))
				{
					$error[] = sprintf($user->lang['DIRECTORY_NOT_DIR'], $cfg_array[$config_name]);
				}

				// Check if the path is writable
				if ($config_definition['validate'] == 'wpath' || $config_definition['validate'] == 'rwpath')
				{
					if (file_exists($phpbb_root_path . $cfg_array[$config_name]) && !phpbb_is_writable($phpbb_root_path . $cfg_array[$config_name]))
					{
						$error[] = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $cfg_array[$config_name]);
					}
				}

			break;
		}
	}

	return;
}
/**
* Lists inactive users
*/
function view_inactive_users(&$users, &$user_count, $limit = 0, $offset = 0, $limit_days = 0, $sort_by = 'user_inactive_time DESC')
{
	global $db, $user, $db_prefix;

	$sql = 'SELECT COUNT(id) AS user_count
		FROM ' . $db_prefix . '_users
		WHERE user_type = ' . 1 .
		(($limit_days) ? " AND user_inactive_time >= $limit_days" : '');
	$result = $db->sql_query($sql);
	$user_count = (int) $db->sql_fetchfield('user_count');
	$db->sql_freeresult($result);

	if ($user_count == 0)
	{
		// Save the queries, because there are no users to display
		return 0;
	}

	if ($offset >= $user_count)
	{
		$offset = ($offset - $limit < 0) ? 0 : $offset - $limit;
	}

	$sql = 'SELECT *
		FROM ' . $db_prefix . '_users
		WHERE user_type = ' . 1 .
		(($limit_days) ? " AND user_inactive_time >= $limit_days" : '') . "
		ORDER BY $sort_by";
		//die($sql . 'LIMIT ' . $offset . ' , ' . $limit);
	$result = $db->sql_query($sql . ' LIMIT ' . $offset . ' , ' . $limit);

	while ($row = $db->sql_fetchrow($result))
	{
		$row['inactive_reason'] = $user->lang['INACTIVE_REASON_UNKNOWN'];
		switch ($row['user_inactive_reason'])
		{
			case 1:
				$row['inactive_reason'] = $user->lang['INACTIVE_REASON_REGISTER'];
			break;

			case 2:
				$row['inactive_reason'] = $user->lang['INACTIVE_REASON_PROFILE'];
			break;

			case 3:
				$row['inactive_reason'] = $user->lang['INACTIVE_REASON_MANUAL'];
			break;

			case 4:
				$row['inactive_reason'] = $user->lang['INACTIVE_REASON_REMIND'];
			break;
		}

		$users[] = $row;
	}
//die(print_r($users));
	return $offset;
}
/**
* Build select field options in acp pages
*/
function build_select($option_ary, $option_default = false)
{
	global $user;

	$html = '';
	foreach ($option_ary as $value => $title)
	{
		$selected = ($option_default !== false && $value == $option_default) ? ' selected="selected"' : '';
		$html .= '<option value="' . $value . '"' . $selected . '>' . $user->lang[$title] . '</option>';
	}

	return $html;
}
function phpbb_is_writable($file)
{
	if (strtolower(substr(PHP_OS, 0, 3)) === 'win' || !function_exists('is_writable'))
	{
		if (file_exists($file))
		{
			// Canonicalise path to absolute path
			$file = phpbb_realpath($file);

			if (is_dir($file))
			{
				// Test directory by creating a file inside the directory
				$result = @tempnam($file, 'i_w');

				if (is_string($result) && file_exists($result))
				{
					unlink($result);

					// Ensure the file is actually in the directory (returned realpathed)
					return (strpos($result, $file) === 0) ? true : false;
				}
			}
			else
			{
				$handle = @fopen($file, 'r+');

				if (is_resource($handle))
				{
					fclose($handle);
					return true;
				}
			}
		}
		else
		{
			// file does not exist test if we can write to the directory
			$dir = dirname($file);

			if (file_exists($dir) && is_dir($dir) && phpbb_is_writable($dir))
			{
				return true;
			}
		}

		return false;
	}
	else
	{
		return is_writable($file);
	}
}

if (!function_exists("get_supported_image_types"))
{
function get_supported_image_types($type = false)
{
	if (@extension_loaded('gd'))
	{
		$format = imagetypes();
		$new_type = 0;

		if ($type !== false)
		{
			// Type is one of the IMAGETYPE constants - it is fetched from getimagesize()
			// We do not use the constants here, because some were not available in PHP 4.3.x
			switch ($type)
			{
				// GIF
				case 1:
					$new_type = ($format & IMG_GIF) ? IMG_GIF : false;
				break;

				// JPG, JPC, JP2
				case 2:
				case 9:
				case 10:
				case 11:
				case 12:
					$new_type = ($format & IMG_JPG) ? IMG_JPG : false;
				break;

				// PNG
				case 3:
					$new_type = ($format & IMG_PNG) ? IMG_PNG : false;
				break;

				// WBMP
				case 15:
					$new_type = ($format & IMG_WBMP) ? IMG_WBMP : false;
				break;
			}
		}
		else
		{
			$new_type = array();
			$go_through_types = array(IMG_GIF, IMG_JPG, IMG_PNG, IMG_WBMP);

			foreach ($go_through_types as $check_type)
			{
				if ($format & $check_type)
				{
					$new_type[] = $check_type;
				}
			}
		}

		return array(
			'gd'		=> ($new_type) ? true : false,
			'format'	=> $new_type,
			'version'	=> (function_exists('imagecreatetruecolor')) ? 2 : 1
		);
	}

	return array('gd' => false);
}
}
/**
* Update/Sync posted information for topics
*/
function update_posted_info(&$topic_ids)
{
	global $db, $db_prefix, $config;

	if (empty($topic_ids))
	{
		return;
	}

	// First of all, let us remove any posted information for these topics
	$sql = 'DELETE FROM ' . $db_prefix . '_topics_posted
		WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
	$db->sql_query($sql);

	// Now, let us collect the user/topic combos for rebuilding the information
	$sql = 'SELECT poster_id, topic_id
		FROM ' . $db_prefix . '_posts
		WHERE ' . $db->sql_in_set('topic_id', $topic_ids) . '
			AND poster_id <> 0
		GROUP BY poster_id, topic_id';
	$result = $db->sql_query($sql);

	$posted = array();
	while ($row = $db->sql_fetchrow($result))
	{
		// Add as key to make them unique (grouping by) and circumvent empty keys on array_unique
		$posted[$row['poster_id']][] = $row['topic_id'];
	}
	$db->sql_freeresult($result);

	// Now add the information...
	$sql_ary = array();
	foreach ($posted as $user_id => $topic_row)
	{
		foreach ($topic_row as $topic_id)
		{
			$sql_ary[] = array(
				'user_id'		=> (int) $user_id,
				'topic_id'		=> (int) $topic_id,
				'topic_posted'	=> 1,
			);
		}
	}
	unset($posted);

	$db->sql_multi_insert($db_prefix . '_topics_posted', $sql_ary);
}
function build_cfg_template($tpl_type, $key, &$new, $config_key, $vars)
{
	global $user, $module;

	$tpl = '';
	$name = 'config[' . $config_key . ']';

	// Make sure there is no notice printed out for non-existent config options (we simply set them)
	if (!isset($new[$config_key]))
	{
		$new[$config_key] = '';
	}

	switch ($tpl_type[0])
	{
		case 'text':
		case 'password':
			$size = (int) $tpl_type[1];
			$maxlength = (int) $tpl_type[2];

			$tpl = '<input id="' . $key . '" type="' . $tpl_type[0] . '"' . (($size) ? ' size="' . $size . '"' : '') . ' maxlength="' . (($maxlength) ? $maxlength : 255) . '" name="' . $name . '" value="' . $new[$config_key] . '"' . (($tpl_type[0] === 'password') ?  ' autocomplete="off"' : '') . ' />';
		break;

		case 'dimension':
			$size = (int) $tpl_type[1];
			$maxlength = (int) $tpl_type[2];

			$tpl = '<input id="' . $key . '" type="text"' . (($size) ? ' size="' . $size . '"' : '') . ' maxlength="' . (($maxlength) ? $maxlength : 255) . '" name="config[' . $config_key . '_width]" value="' . $new[$config_key . '_width'] . '" /> x <input type="text"' . (($size) ? ' size="' . $size . '"' : '') . ' maxlength="' . (($maxlength) ? $maxlength : 255) . '" name="config[' . $config_key . '_height]" value="' . $new[$config_key . '_height'] . '" />';
		break;

		case 'textarea':
			$rows = (int) $tpl_type[1];
			$cols = (int) $tpl_type[2];

			$tpl = '<textarea id="' . $key . '" name="' . $name . '" rows="' . $rows . '" cols="' . $cols . '">' . $new[$config_key] . '</textarea>';
		break;

		case 'radio':
			$key_yes	= ($new[$config_key]) ? ' checked="checked"' : '';
			$key_no		= (!$new[$config_key]) ? ' checked="checked"' : '';

			$tpl_type_cond = explode('_', $tpl_type[1]);
			$type_no = ($tpl_type_cond[0] == 'disabled' || $tpl_type_cond[0] == 'enabled') ? false : true;

			$tpl_no = '<label><input type="radio" name="' . $name . '" value="0"' . $key_no . ' class="radio" /> ' . (($type_no) ? $user->lang['NO'] : $user->lang['DISABLED']) . '</label>';
			$tpl_yes = '<label><input type="radio" id="' . $key . '" name="' . $name . '" value="1"' . $key_yes . ' class="radio" /> ' . (($type_no) ? $user->lang['YES'] : $user->lang['ENABLED']) . '</label>';

			$tpl = ($tpl_type_cond[0] == 'yes' || $tpl_type_cond[0] == 'enabled') ? $tpl_yes . $tpl_no : $tpl_no . $tpl_yes;
		break;

		case 'select':
		case 'custom':

			$return = '';

			if (isset($vars['method']))
			{
				$call = array($module->module, $vars['method']);
			}
			else if (isset($vars['function']))
			{
				$call = $vars['function'];
			}
			else
			{
				break;
			}

			if (isset($vars['params']))
			{
				$args = array();
				foreach ($vars['params'] as $value)
				{
					switch ($value)
					{
						case '{CONFIG_VALUE}':
							$value = $new[$config_key];
						break;

						case '{KEY}':
							$value = $key;
						break;
					}

					$args[] = $value;
				}
			}
			else
			{
				$args = array($new[$config_key], $key);
			}
//die(print_r($call));
			$return = @call_user_func_array($call, $args);

			if ($tpl_type[0] == 'select')
			{
				$tpl = '<select id="' . $key . '" name="' . $name . '">' . $return . '</select>';
			}
			else
			{
				$tpl = $return;
			}

		break;

		default:
		break;
	}

	if (isset($vars['append']))
	{
		$tpl .= $vars['append'];
	}

	return $tpl;
}
function filelist($rootdir, $dir = '', $type = 'gif|jpg|jpeg|png')
{
	$matches = array($dir => array());

	// Remove initial / if present
	$rootdir = (substr($rootdir, 0, 1) == '/') ? substr($rootdir, 1) : $rootdir;
	// Add closing / if not present
	$rootdir = ($rootdir && substr($rootdir, -1) != '/') ? $rootdir . '/' : $rootdir;

	// Remove initial / if present
	$dir = (substr($dir, 0, 1) == '/') ? substr($dir, 1) : $dir;
	// Add closing / if not present
	$dir = ($dir && substr($dir, -1) != '/') ? $dir . '/' : $dir;

	if (!is_dir($rootdir . $dir))
	{
		return $matches;
	}

	$dh = @opendir($rootdir . $dir);

	if (!$dh)
	{
		return $matches;
	}

	while (($fname = readdir($dh)) !== false)
	{
		if (is_file("$rootdir$dir$fname"))
		{
			if (filesize("$rootdir$dir$fname") && preg_match('#\.' . $type . '$#i', $fname))
			{
				$matches[$dir][] = $fname;
			}
		}
		else if ($fname[0] != '.' && is_dir("$rootdir$dir$fname"))
		{
			$matches += filelist($rootdir, "$dir$fname", $type);
		}
	}
	closedir($dh);

	return $matches;
}
function size_select_options($size_compare)
{
	global $user;

	$size_types_text = array($user->lang['BYTES'], $user->lang['KIB'], $user->lang['MIB']);
	$size_types = array('b', 'kb', 'mb');

	$s_size_options = '';

	for ($i = 0, $size = sizeof($size_types_text); $i < $size; $i++)
	{
		$selected = ($size_compare == $size_types[$i]) ? ' selected="selected"' : '';
		$s_size_options .= '<option value="' . $size_types[$i] . '"' . $selected . '>' . $size_types_text[$i] . '</option>';
	}

	return $s_size_options;
}
function h_radio($name, $input_ary, $input_default = false, $id = false, $key = false, $separator = '')
{
	global $user;

	$html = '';
	$id_assigned = false;
	foreach ($input_ary as $value => $title)
	{
		$selected = ($input_default !== false && $value == $input_default) ? ' checked="checked"' : '';
		$html .= '<label><input type="radio" name="' . $name . '"' . (($id && !$id_assigned) ? ' id="' . $id . '"' : '') . ' value="' . $value . '"' . $selected . (($key) ? ' accesskey="' . $key . '"' : '') . ' class="radio" /> ' . $user->lang[$title] . '</label>' . $separator;
		$id_assigned = true;
	}

	return $html;
}
	function display_order($value, $key = '')
	{
		$radio_ary = array(0 => 'DESCENDING', 1 => 'ASCENDING');

		return h_radio('config[display_order]', $radio_ary, $value, $key);
	}
function validate_range($value_ary, &$error)
{
	global $user;

	$column_types = array(
		'BOOL'	=> array('php_type' => 'int', 		'min' => 0, 				'max' => 1),
		'USINT'	=> array('php_type' => 'int',		'min' => 0, 				'max' => 65535),
		'UINT'	=> array('php_type' => 'int', 		'min' => 0, 				'max' => (int) 0x7fffffff),
		'INT'	=> array('php_type' => 'int', 		'min' => (int) 0x80000000, 	'max' => (int) 0x7fffffff),
		'TINT'	=> array('php_type' => 'int',		'min' => -128,				'max' => 127),

		'VCHAR'	=> array('php_type' => 'string', 	'min' => 0, 				'max' => 255),
	);
	foreach ($value_ary as $value)
	{
		$column = explode(':', $value['column_type']);
		$max = $min = 0;
		$type = 0;
		if (!isset($column_types[$column[0]]))
		{
			continue;
		}
		else
		{
			$type = $column_types[$column[0]];
		}

		switch ($type['php_type'])
		{
			case 'string' :
				$max = (isset($column[1])) ? min($column[1],$type['max']) : $type['max'];
				if (strlen($value['value']) > $max)
				{
					$error[] = sprintf($user->lang['SETTING_TOO_LONG'], $user->lang[$value['lang']], $max);
				}
			break;

			case 'int':
				$min = (isset($column[1])) ? max($column[1],$type['min']) : $type['min'];
				$max = (isset($column[2])) ? min($column[2],$type['max']) : $type['max'];
				if ($value['value'] < $min)
				{
					$error[] = sprintf($user->lang['SETTING_TOO_LOW'], $user->lang[$value['lang']], $min);
				}
				else if ($value['value'] > $max)
				{
					$error[] = sprintf($user->lang['SETTING_TOO_BIG'], $user->lang[$value['lang']], $max);
				}
			break;
		}
	}
}
function set_config($config_name, $config_value, $is_dynamic = false)
{
	global $db, $db_prefix, $config;

	$sql = 'UPDATE ' . $db_prefix . "_settings
		SET config_value = '" . $db->sql_escape($config_value) . "'
		WHERE config_name = '" . $db->sql_escape($config_name) . "'";
	$db->sql_query($sql);

	if (!$db->sql_affectedrows() && !isset($config[$config_name]))
	{
		$sql = 'INSERT INTO ' . $db_prefix . '_settings ' . $db->sql_build_array('INSERT', array(
			'config_name'	=> $config_name,
			'config_value'	=> $config_value,
			'is_dynamic'	=> ($is_dynamic) ? 1 : 0));
		$db->sql_query($sql);
	}

	$config[$config_name] = $config_value;

	if (!$is_dynamic)
	{
		//$cache->destroy('config');
	}
}
function get_forum_list($acl_list = 'f_list', $id_only = true, $postable_only = false, $no_cache = false)
{
	global $db, $auth, $db_prefix;
	static $forum_rows;

	if (!isset($forum_rows))
	{
		// This query is identical to the jumpbox one
		$expire_time = ($no_cache) ? 0 : 600;

		$sql = 'SELECT forum_id, forum_name, parent_id, forum_type, left_id, right_id
			FROM ' . $db_prefix . '_forums
			ORDER BY left_id ASC';
		$result = $db->sql_query($sql, $expire_time);

		$forum_rows = array();

		$right = $padding = 0;
		$padding_store = array('0' => 0);

		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['left_id'] < $right)
			{
				$padding++;
				$padding_store[$row['parent_id']] = $padding;
			}
			else if ($row['left_id'] > $right + 1)
			{
				// Ok, if the $padding_store for this parent is empty there is something wrong. For now we will skip over it.
				// @todo digging deep to find out "how" this can happen.
				$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : $padding;
			}

			$right = $row['right_id'];
			$row['padding'] = $padding;

			$forum_rows[] = $row;
		}
		$db->sql_freeresult($result);
		unset($padding_store);
	}

	$rowset = array();
	foreach ($forum_rows as $row)
	{
		if ($postable_only && $row['forum_type'] != 1)
		{
			continue;
		}

		if ($acl_list == '' || ($acl_list != '' && $auth->acl_gets($acl_list, $row['forum_id'])))
		{
			$rowset[] = ($id_only) ? $row['forum_id'] : $row;
		}
	}

	return $rowset;
}
function view_log($mode, &$log, &$log_count, $limit = 0, $offset = 0, $forum_id = 0, $topic_id = 0, $user_id = 0, $limit_days = 0, $sort_by = 'l.datetime DESC')
{
	global $db, $user, $auth, $db_prefix, $phpEx, $phpbb_root_path, $phpbb_admin_path;
	if(!function_exists('bbcode_nl2br'))include_once('include/function_posting.php');

	$topic_id_list = $reportee_id_list = $is_auth = $is_mod = array();

	$profile_url = (defined('IN_ADMIN')) ? append_sid("{$phpbb_admin_path}index.$phpEx", 'i=users&amp;mode=overview') : append_sid("{$phpbb_root_path}user.$phpEx", 'op=profile');

	switch ($mode)
	{
		case 'admin':
			$log_type = 0;
			$sql_forum = '';
		break;

		case 'mod':
			$log_type = 1;

			if ($topic_id)
			{
				$sql_forum = 'AND l.topic_id = ' . intval($topic_id);
			}
			else if (is_array($forum_id))
			{
				$sql_forum = 'AND ' . $db->sql_in_set('l.forum_id', array_map('intval', $forum_id));
			}
			else
			{
				$sql_forum = ($forum_id) ? 'AND l.forum_id = ' . intval($forum_id) : '';
			}
		break;

		case 'user':
			$log_type = 3;
			$sql_forum = 'AND l.reportee_id = ' . (int) $user_id;
		break;

		case 'users':
			$log_type = 3;
			$sql_forum = '';
		break;

		case 'critical':
			$log_type = 2;
			$sql_forum = '';
		break;

		default:
			return;
	}

	$sql = "SELECT l.*,UNIX_TIMESTAMP(l.datetime) AS datetime, u.username, u.clean_username, u.can_do , b.group_colour AS user_colour
		FROM " . $db_prefix . "_log l, " . $db_prefix . "_users u, " . $db_prefix . "_level_settings b
		WHERE l.log_type = $log_type
			AND u.id = l.userid 
			AND b.group_id = u.can_do
			" . (($limit_days) ? "AND UNIX_TIMESTAMP(l.datetime) >= $limit_days" : '') . "
			$sql_forum
		ORDER BY $sort_by
		LIMIT $offset,$limit";
	$result = $db->sql_query($sql) or btsqlerror($sql);

	$i = 0;
	$log = array();
	while ($row = $db->sql_fetchrow($result))
	{
		if ($row['topic_id'])
		{
			$topic_id_list[] = $row['topic_id'];
		}

		if ($row['reportee_id'])
		{
			$reportee_id_list[] = $row['reportee_id'];
		}

		$log[$i] = array(
			'id'				=> $row['event'],

			'reportee_id'			=> $row['reportee_id'],
			'reportee_username'		=> '',
			'reportee_username_full'=> '',

			'user_id'			=> $row['userid'],
			'username'			=> $row['username'],
			'username_full'		=> get_username_string('full', $row['userid'], $row['username'], '#' . $row['user_colour'], false, $profile_url),

			'ip'				=> long2ip($row['ip']),
			'time'				=> $row['datetime'],
			'forum_id'			=> $row['forum_id'],
			'topic_id'			=> $row['topic_id'],

			'viewforum'			=> ($row['forum_id'] && $auth->acl_get('f_read', $row['forum_id'])) ? append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $row['forum_id']) : false,
			'action'			=> (isset($user->lang[$row['action']])) ? $user->lang[$row['action']] : '{' . ucfirst(str_replace('_', ' ', $row['action'])) . '}',
		);

		if (!empty($row['results']))
		{
			$log_data_ary = unserialize($row['results']);
			if(!is_array($log_data_ary))$log_data_ary = array($log_data_ary);
			//print_r($log_data_ary);

			if (isset($user->lang[$row['action']]))
			{
				// Check if there are more occurrences of % than arguments, if there are we fill out the arguments array
				// It doesn't matter if we add more arguments than placeholders
				if ((substr_count($log[$i]['action'], '%') - sizeof($log_data_ary)) > 0)
				{
					$log_data_ary = array_merge($log_data_ary, array_fill(0, substr_count($log[$i]['action'], '%') - sizeof($log_data_ary), ''));
				}

				$log[$i]['action'] = vsprintf($log[$i]['action'], $log_data_ary);

				// If within the admin panel we do not censor text out
				if (defined('IN_ADMIN'))
				{
					$log[$i]['action'] = bbcode_nl2br($log[$i]['action']);
				}
				else
				{
					$log[$i]['action'] = bbcode_nl2br(censor_text($log[$i]['action']));
				}
			}
			else
			{
				$log[$i]['action'] .= '<br />' . @implode('', $log_data_ary);
			}

			/* Apply make_clickable... has to be seen if it is for good. :/
			// Seems to be not for the moment, reconsider later...
			$log[$i]['action'] = make_clickable($log[$i]['action']);
			*/
		}

		$i++;
	}
	$db->sql_freeresult($result);

	if (sizeof($topic_id_list))
	{
		$topic_id_list = array_unique($topic_id_list);

		// This query is not really needed if move_topics() updates the forum_id field,
		// although it's also used to determine if the topic still exists in the database
		$sql = 'SELECT topic_id, forum_id
			FROM ' . $db_prefix . '_topics
			WHERE ' . $db->sql_in_set('topic_id', array_map('intval', $topic_id_list));
		$result = $db->sql_query($sql) or btsqlerror($sql);

		$default_forum_id = 0;

		while ($row = $db->sql_fetchrow($result))
		{
			if (!$row['forum_id'])
			{
				if ($auth->acl_getf_global('f_read'))
				{
					if (!$default_forum_id)
					{
						$sql = 'SELECT forum_id
							FROM ' . $db_prefix . '_forums
							WHERE forum_type = ' . 1 . '
							LIMIT 1';
						$f_result = $db->sql_query($sql) or btsqlerror($sql);
						$default_forum_id = (int) $db->sql_fetchfield('forum_id', false, $f_result);
						$db->sql_freeresult($f_result);
					}

					$is_auth[$row['topic_id']] = $default_forum_id;
				}
			}
			else
			{
				if ($auth->acl_get('f_read', $row['forum_id']))
				{
					$is_auth[$row['topic_id']] = $row['forum_id'];
				}
			}

			if ($auth->acl_gets('a_', 'm_', $row['forum_id']))
			{
				$is_mod[$row['topic_id']] = $row['forum_id'];
			}
		}
		$db->sql_freeresult($result);

		foreach ($log as $key => $row)
		{
			$log[$key]['viewtopic'] = (isset($is_auth[$row['topic_id']])) ? append_sid("{$phpbb_root_path}forum.$phpEx?action=viewtopic", 'f=' . $is_auth[$row['topic_id']] . '&amp;t=' . $row['topic_id']) : false;
			$log[$key]['viewlogs'] = (isset($is_mod[$row['topic_id']])) ? append_sid("{$phpbb_root_path}forum.$phpEx?action_mcp=mcp", 'i=logs&amp;mode=topic_logs&amp;t=' . $row['topic_id'], true, $user->session_id) : false;
		}
	}

	if (sizeof($reportee_id_list))
	{
		$reportee_id_list = array_unique($reportee_id_list);
		$reportee_names_list = array();

		$sql = 'SELECT id AS user_id, username, can_do , l.group_colour AS user_colour
			FROM ' . $db_prefix . '_users , ' . $db_prefix . '_level_settings l
			WHERE ' . $db->sql_in_set('id', $reportee_id_list) . '
			AND l.group_id = can_do';
		$result = $db->sql_query($sql) or btsqlerror($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$reportee_names_list[$row['user_id']] = $row;
		}
		$db->sql_freeresult($result);

		foreach ($log as $key => $row)
		{
			if (!isset($reportee_names_list[$row['reportee_id']]))
			{
				continue;
			}

			$log[$key]['reportee_username'] = $reportee_names_list[$row['reportee_id']]['username'];
			$log[$key]['reportee_username_full'] = get_username_string('full', $row['reportee_id'], $reportee_names_list[$row['reportee_id']]['username'], $reportee_names_list[$row['reportee_id']]['user_colour'], false, $profile_url);
		}
	}

	$sql = 'SELECT COUNT(l.event) AS total_entries
		FROM ' . $db_prefix . "_log l
		WHERE l.log_type = $log_type
			" . (($limit_days) ? "AND UNIX_TIMESTAMP(l.datetime) >= $limit_days" : '') . " 
			$sql_forum";
			//die($sql);
	$result = $db->sql_query($sql) or btsqlerror($sql);
	$log_count = (int) $db->sql_fetchfield('total_entries');
	$db->sql_freeresult($result);
	//echo $sql;
	//die(print_r($log));

	return;
}
function build_permission_dropdown($options, $default_option, $permission_scope)
{
	global $db, $user, $db_prefix;
	$s_dropdown_options = '';
	foreach ($options as $setting)
	{
		if (!checkaccess('a_' . str_replace('_', '', $setting) . 'auth'))
		{
			continue;
		}
		$selected = ($setting == $default_option) ? ' selected="selected"' : '';
		$l_setting = (isset($user->lang['permission_type'][$permission_scope][$setting])) ? $user->lang['permission_type'][$permission_scope][$setting] : $user->lang['permission_type'][$setting];
		$s_dropdown_options .= '<option value="' . $setting . '"' . $selected . '>' . $l_setting . '</option>';
	}

	return $s_dropdown_options;
}
	function update_forum_data(&$forum_data)
	{
		global $db, $user, $db_prefix, $phpbb_root_path;

		$errors = array();

		if (!$forum_data['forum_name'])
		{
			$errors[] = $user->lang['FORUM_NAME_EMPTY'];
		}

		if (mb_strlen($forum_data['forum_desc'], 'utf-8') > 4000)
		{
			$errors[] = $user->lang['FORUM_DESC_TOO_LONG'];
		}

		if (mb_strlen($forum_data['forum_rules'], 'utf-8') > 4000)
		{
			$errors[] = $user->lang['FORUM_RULES_TOO_LONG'];
		}

		if ($forum_data['forum_password'] || $forum_data['forum_password_confirm'])
		{
			if ($forum_data['forum_password'] != $forum_data['forum_password_confirm'])
			{
				$forum_data['forum_password'] = $forum_data['forum_password_confirm'] = '';
				$errors[] = $user->lang['FORUM_PASSWORD_MISMATCH'];
			}
		}

		if ($forum_data['prune_days'] < 0 || $forum_data['prune_viewed'] < 0 || $forum_data['prune_freq'] < 0)
		{
			$forum_data['prune_days'] = $forum_data['prune_viewed'] = $forum_data['prune_freq'] = 0;
			$errors[] = $user->lang['FORUM_DATA_NEGATIVE'];
		}

		$range_test_ary = array(
			array('lang' => 'FORUM_TOPICS_PAGE', 'value' => $forum_data['forum_topics_per_page'], 'column_type' => 'TINT:0'),
		);

		if (!empty($forum_data['forum_image']) && !file_exists($phpbb_root_path . $forum_data['forum_image']))
		{
			$errors[] = $user->lang['FORUM_IMAGE_NO_EXIST'];
		}
		validate_range($range_test_ary, $errors);

		// Set forum flags
		// 1 = link tracking
		// 2 = prune old polls
		// 4 = prune announcements
		// 8 = prune stickies
		// 16 = show active topics
		// 32 = enable post review
		$forum_data['forum_flags'] = 0;
		$forum_data['forum_flags'] += ($forum_data['forum_link_track']) ? 1 : 0;
		$forum_data['forum_flags'] += ($forum_data['prune_old_polls']) ? 2 : 0;
		$forum_data['forum_flags'] += ($forum_data['prune_announce']) ? 4 : 0;
		$forum_data['forum_flags'] += ($forum_data['prune_sticky']) ? 8 : 0;
		$forum_data['forum_flags'] += ($forum_data['show_active']) ? 16 : 0;
		$forum_data['forum_flags'] += ($forum_data['enable_post_review']) ? 32 : 0;
		$forum_data['forum_flags'] += ($forum_data['enable_quick_reply']) ? 64 : 0;

		// Unset data that are not database fields
		$forum_data_sql = $forum_data;

		unset($forum_data_sql['forum_link_track']);
		unset($forum_data_sql['prune_old_polls']);
		unset($forum_data_sql['prune_announce']);
		unset($forum_data_sql['prune_sticky']);
		unset($forum_data_sql['show_active']);
		unset($forum_data_sql['enable_post_review']);
		unset($forum_data_sql['enable_quick_reply']);
		unset($forum_data_sql['forum_password_confirm']);

		// What are we going to do tonight Brain? The same thing we do everynight,
		// try to take over the world ... or decide whether to continue update
		// and if so, whether it's a new forum/cat/link or an existing one
		if (sizeof($errors))
		{
			return $errors;
		}

		// As we don't know the old password, it's kinda tricky to detect changes
		if ($forum_data_sql['forum_password_unset'])
		{
			$forum_data_sql['forum_password'] = '';
		}
		else if (empty($forum_data_sql['forum_password']))
		{
			unset($forum_data_sql['forum_password']);
		}
		else
		{
			$forum_data_sql['forum_password'] = _hash($forum_data_sql['forum_password']);
		}
		unset($forum_data_sql['forum_password_unset']);

		if (!isset($forum_data_sql['forum_id']))
		{
			// no forum_id means we're creating a new forum
			unset($forum_data_sql['type_action']);

			if ($forum_data_sql['parent_id'])
			{
				$sql = 'SELECT left_id, right_id, forum_type
					FROM ' . $db_prefix . '_forums
					WHERE forum_id = ' . $forum_data_sql['parent_id'];
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					trigger_error($user->lang['PARENT_NOT_EXIST'] . back_link($u_action . '&amp;parent_id=' . $parent_id), E_USER_WARNING);
				}

				if ($row['forum_type'] == 2)
				{
					$errors[] = $user->lang['PARENT_IS_LINK_FORUM'];
					return $errors;
				}

				$sql = 'UPDATE ' . $db_prefix . '_forums
					SET left_id = left_id + 2, right_id = right_id + 2
					WHERE left_id > ' . $row['right_id'];
				$db->sql_query($sql) or btsqlerror($sql);

				$sql = 'UPDATE ' . $db_prefix . '_forums
					SET right_id = right_id + 2
					WHERE ' . $row['left_id'] . ' BETWEEN left_id AND right_id';
				$db->sql_query($sql) or btsqlerror($sql);

				$forum_data_sql['left_id'] = $row['right_id'];
				$forum_data_sql['right_id'] = $row['right_id'] + 1;
			}
			else
			{
				$sql = 'SELECT MAX(right_id) AS right_id
					FROM ' . $db_prefix . '_forums';
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$forum_data_sql['left_id'] = $row['right_id'] + 1;
				$forum_data_sql['right_id'] = $row['right_id'] + 2;
			}

			$sql = 'INSERT INTO ' . $db_prefix . '_forums ' . $db->sql_build_array('INSERT', $forum_data_sql);
			$db->sql_query($sql) or btsqlerror($sql);

			$forum_data['forum_id'] = $db->sql_nextid();

			add_log('admin','LOG_FORUM_ADD', $forum_data['forum_name']);
		}
		else
		{
			$row = get_forum_info($forum_data_sql['forum_id']);

			if ($row['forum_type'] == 1 && $row['forum_type'] != $forum_data_sql['forum_type'])
			{
				// Has subforums and want to change into a link?
				if ($row['right_id'] - $row['left_id'] > 1 && $forum_data_sql['forum_type'] == 2)
				{
					$errors[] = $user->lang['FORUM_WITH_SUBFORUMS_NOT_TO_LINK'];
					return $errors;
				}

				// we're turning a postable forum into a non-postable forum
				if ($forum_data_sql['type_action'] == 'move')
				{
					$to_forum_id = request_var('to_forum_id', 0);

					if ($to_forum_id)
					{
						$errors = move_forum_content($forum_data_sql['forum_id'], $to_forum_id);
					}
					else
					{
						return array($user->lang['NO_DESTINATION_FORUM']);
					}
				}
				else if ($forum_data_sql['type_action'] == 'delete')
				{
					$errors = delete_forum_content($forum_data_sql['forum_id']);
				}
				else
				{
					return array($user->lang['NO_FORUM_ACTION']);
				}

				$forum_data_sql['forum_posts'] = $forum_data_sql['forum_topics'] = $forum_data_sql['forum_topics_real'] = $forum_data_sql['forum_last_post_id'] = $forum_data_sql['forum_last_poster_id'] = $forum_data_sql['forum_last_post_time'] = 0;
				$forum_data_sql['forum_last_poster_name'] = $forum_data_sql['forum_last_poster_colour'] = '';
			}
			else if ($row['forum_type'] == 0 && $forum_data_sql['forum_type'] == 2)
			{
				// Has subforums?
				if ($row['right_id'] - $row['left_id'] > 1)
				{
					// We are turning a category into a link - but need to decide what to do with the subforums.
					$action_subforums = request_var('action_subforums', '');
					$subforums_to_id = request_var('subforums_to_id', 0);

					if ($action_subforums == 'delete')
					{
						$rows = get_forum_branch($row['forum_id'], 'children', 'descending', false);

						foreach ($rows as $_row)
						{
							// Do not remove the forum id we are about to change. ;)
							if ($_row['forum_id'] == $row['forum_id'])
							{
								continue;
							}

							$forum_ids[] = $_row['forum_id'];
							$errors = array_merge($errors, delete_forum_content($_row['forum_id']));
						}

						if (sizeof($errors))
						{
							return $errors;
						}

						if (sizeof($forum_ids))
						{
							$sql = 'DELETE FROM ' . $db_prefix . '_forums
								WHERE ' . $db->sql_in_set('forum_id', $forum_ids);
							$db->sql_query($sql) or btsqlerror($sql);

							$sql = 'DELETE FROM ' . $db_prefix . '_forum_permissions
								WHERE ' . $db->sql_in_set('forum_id', $forum_ids);
							$db->sql_query($sql) or btsqlerror($sql);
						}
					}
					else if ($action_subforums == 'move')
					{
						if (!$subforums_to_id)
						{
							return array($user->lang['NO_DESTINATION_FORUM']);
						}

						$sql = 'SELECT forum_name
							FROM ' . $db_prefix . '_forums
							WHERE forum_id = ' . $subforums_to_id;
						$result = $db->sql_query($sql) or btsqlerror($sql);
						$_row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						if (!$_row)
						{
							return array($user->lang['NO_FORUM']);
						}

						$subforums_to_name = $_row['forum_name'];

						$sql = 'SELECT forum_id
							FROM ' . $db_prefix . "_forums
							WHERE parent_id = {$row['forum_id']}";
						$result = $db->sql_query($sql) or btsqlerror($sql);

						while ($_row = $db->sql_fetchrow($result))
						{
							move_forum($_row['forum_id'], $subforums_to_id);
						}
						$db->sql_freeresult($result);

						$sql = 'UPDATE ' . $db_prefix . "_forums
							SET parent_id = $subforums_to_id
							WHERE parent_id = {$row['forum_id']}";
						$db->sql_query($sql) or btsqlerror($sql);
					}

					// Adjust the left/right id
					$sql = 'UPDATE ' . $db_prefix . '_forums
						SET right_id = left_id + 1
						WHERE forum_id = ' . $row['forum_id'];
					$db->sql_query($sql) or btsqlerror($sql);
				}
			}
			else if ($row['forum_type'] == 0 && $forum_data_sql['forum_type'] == 1)
			{
				// Changing a category to a forum? Reset the data (you can't post directly in a cat, you must use a forum)
				$forum_data_sql['forum_posts'] = 0;
				$forum_data_sql['forum_topics'] = 0;
				$forum_data_sql['forum_topics_real'] = 0;
				$forum_data_sql['forum_last_post_id'] = 0;
				$forum_data_sql['forum_last_post_subject'] = '';
				$forum_data_sql['forum_last_post_time'] = 0;
				$forum_data_sql['forum_last_poster_id'] = 0;
				$forum_data_sql['forum_last_poster_name'] = '';
				$forum_data_sql['forum_last_poster_colour'] = '';
			}

			if (sizeof($errors))
			{
				return $errors;
			}

			if ($row['parent_id'] != $forum_data_sql['parent_id'])
			{
				if ($row['forum_id'] != $forum_data_sql['parent_id'])
				{
					$errors = move_forum($forum_data_sql['forum_id'], $forum_data_sql['parent_id']);
				}
				else
				{
					$forum_data_sql['parent_id'] = $row['parent_id'];
				}
			}

			if (sizeof($errors))
			{
				return $errors;
			}

			unset($forum_data_sql['type_action']);

			if ($row['forum_name'] != $forum_data_sql['forum_name'])
			{
				// the forum name has changed, clear the parents list of all forums (for safety)
				$sql = 'UPDATE ' . $db_prefix . "_forums
					SET forum_parents = ''";
				$db->sql_query($sql) or btsqlerror($sql);
			}

			// Setting the forum id to the forum id is not really received well by some dbs. ;)
			$forum_id = $forum_data_sql['forum_id'];
			unset($forum_data_sql['forum_id']);

			$sql = 'UPDATE ' . $db_prefix . '_forums
				SET ' . $db->sql_build_array('UPDATE', $forum_data_sql) . '
				WHERE forum_id = ' . $forum_id;
			$db->sql_query($sql) or btsqlerror($sql);

			// Add it back
			$forum_data['forum_id'] = $forum_id;

			add_log('admin','LOG_FORUM_EDIT', $forum_data['forum_name']);
		}

		return $errors;
	}
function get_database_size()
{
	global $db, $db_prefix;

	$database_size = false;

	// This code is heavily influenced by a similar routine in phpMyAdmin 2.2.0
	switch ($db->sql_layer)
	{
		case 'mysql':
		case 'mysql4':
		case 'mysqli':
			$sql = 'SELECT VERSION() AS mysql_version';
			$result = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($row)
			{
				$version = $row['mysql_version'];

				if (preg_match('#(10\.1|[45]\.)#', $version))
				{
					$db_name = (preg_match('#^(?:3\.23\.(?:[6-9]|[1-9]{2}))|[45]\.#', $version)) ? "`{$db->dbname}`" : $db->dbname;

					$sql = 'SHOW TABLE STATUS
						FROM ' . $db_name;
					$result = $db->sql_query($sql, 7200);

					$database_size = 0;
					while ($row = $db->sql_fetchrow($result))
					{
						//die(print_r($row));
						if ((isset($row['Type']) && $row['Type'] != 'MRG_MyISAM') || (isset($row['Engine']) && ($row['Engine'] == 'MyISAM' || $row['Engine'] == 'InnoDB')))
						{
							if ($db_prefix != '')
							{
								if (strpos($row['Name'], $db_prefix) !== false)
								{
									$database_size += $row['Data_length'] + $row['Index_length'];
								}
							}
							else
							{
								$database_size += $row['Data_length'] + $row['Index_length'];
							}
						}
					}
					$db->sql_freeresult($result);
				}
			}
		break;

		case 'firebird':
			global $dbname;

			// if it on the local machine, we can get lucky
			if (file_exists($dbname))
			{
				$database_size = filesize($dbname);
			}

		break;

		case 'sqlite':
			global $dbhost;

			if (file_exists($dbhost))
			{
				$database_size = filesize($dbhost);
			}

		break;

		case 'mssql':
		case 'mssql_odbc':
			$sql = 'SELECT ((SUM(size) * 8.0) * 1024.0) as dbsize
				FROM sysfiles';
			$result = $db->sql_query($sql, 7200);
			$database_size = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
			$db->sql_freeresult($result);
		break;

		case 'postgres':
			$sql = "SELECT proname
				FROM pg_proc
				WHERE proname = 'pg_database_size'";
			$result = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($row['proname'] == 'pg_database_size')
			{
				$database = $db->dbname;
				if (strpos($database, '.') !== false)
				{
					list($database, ) = explode('.', $database);
				}

				$sql = "SELECT oid
					FROM pg_database
					WHERE datname = '$database'";
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$oid = $row['oid'];

				$sql = 'SELECT pg_database_size(' . $oid . ') as size';
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$database_size = $row['size'];
			}
		break;

		case 'oracle':
			$sql = 'SELECT SUM(bytes) as dbsize
				FROM user_segments';
			$result = $db->sql_query($sql, 7200);
			$database_size = ($row = $db->sql_fetchrow($result)) ? $row['dbsize'] : false;
			$db->sql_freeresult($result);
		break;
	}

	if ($database_size !== false)
	{
		$database_size = ($database_size >= 1048576) ? sprintf('%.2f ' . 'MB', ($database_size / 1048576)) : (($database_size >= 1024) ? sprintf('%.2f ' . 'KB', ($database_size / 1024)) : sprintf('%.2f ' . 'BYTES', $database_size));
	}
	else
	{
		$database_size = 'Not available';
	}

	return $database_size;
}

function fulladmincheck($user) {
        if (!$user->admin) return false;
        //THIS is the full check part
        global $db, $db_prefix, $_COOKIE;
        $userdata = cookie_decode($_COOKIE["btuser"]);
        if ($userdata[0] != $user->id) return false;
        if (addslashes($userdata[1]) != $user->name) return false;
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND username = '".$user->name."' AND level = 'admin' AND act_key = '".addslashes($userdata[3])."' AND password = '".addslashes($userdata[2])."';";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        $n = $db->sql_numrows($res);
        $db->sql_freeresult($res);
        if (!$n) return false;
        return true;
}
/* ADMIN ENTRY FUNCTION
DISPLAYS THE APPROPRIATE BUTTON FOR ADMIN SCRIPT

IN:
   NAME - NAME OF THE BUTTON
   OP - OPERATOR TO APPEND IN QUERY STRING
   TITLE - TEXT TO DISPLAY
OUT: NOTHING
*/
function adminentry($name, $op, $title,$section="torrentinfo", $mod, &$allow = false) {
        global $template, $theme, $admin_siteinfo, $admin_userinfo, $admin_torrentinfo, $admin_staff,$user,$allowed_acc,$val;
		$allowed_acc[$op.'.php'] = 1;
		$allowed_acc[$val] = 1;
        $image = "admin_".$name;
        if (file_exists("themes/$theme/pics/admin/".$image.".png")) {
                $image = "themes/$theme/pics/admin/".$image.".png";
        } elseif (file_exists("themes/$theme/pics/admin/".$image.".jpg")) {
                $image = "themes/$theme/pics/admin/".$image.".jpg";
        } elseif (file_exists("themes/$theme/pics/admin/".$image.".gif")) {
                $image = "themes/$theme/pics/admin/".$image.".gif";
        } elseif (file_exists("admin/buttons/".$image.".png")) {
                $image = "admin/buttons/".$image.".png";
        } elseif (file_exists("admin/buttons/".$image.".jpg")) {
                $image = "admin/buttons/".$image.".jpg";
        } elseif (file_exists("admin/buttons/".$image.".gif")) {
                $image = "admin/buttons/".$image.".gif";
        }
		$i			= request_var('i', '');
		$il			= request_var('op', '');
        $img = "<img src=\"".$image."\" border=\"0\" alt=\"".$title."\" title=\"".$title."\" />";
		$push = 'admin_'.$section;
        array_push($$push, array(
			'S_SELECTED'	=> ($il ==$op)? true:false,
			'IMG' => $img,
			'L_TITLE' => $title,
			'U_TITLE' => "admin.php?i=" . $i . "&amp;op=".$op."#".$op,
		));
		$allow = true;
		//return $allow;
}
function num_files($directory='.'){
    if ($handle = opendir($directory)) {
        $numFiles = 0;
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $numFiles++;
            }
        }
        closedir($handle);
        return $numFiles;
    }
} 
function esc_magic($x) {
        if (!get_magic_quotes_gpc()) return escape($x);
        else return $x;
}
function drawRow($param, $type, $options = NULL, $legend = false, $extra = false) {
        global $cfgrow, $template,$user,$siteurl;
        if ($type == "text") {
                $content = "<input type=\"text\" name=\"sub_".$param."\" value=\"".$cfgrow[$param]."\" size=\"40\"> " . $extra;
        }
        elseif ($type == "text2") {
                $content = "<input type=\"text\" name=\"sub_".$param."_A\" value=\"".$cfgrow[$param."_A"]."\" size=\"20\"> x <input type=\"text\" name=\"sub_".$param."_B\" value=\"".$cfgrow[$param."_B"]."\" size=\"20\"> px";
        }
        elseif ($type == "text3") {
                $content = "<textarea type=\"text\" name=\"sub_".$param."\" rows=\"15\" cols=\"76\">" . $cfgrow[$param] . "</textarea>";
        }
        elseif ($type == "textplus") {
                $content = "<input type=\"text\" name=\"sub_".$param."\" value=\"".$cfgrow[$param]."\" size=\"20\">&nbsp;";
				                $content .= "<select name=\"sel_".$extra."\">\n";
                foreach ($options as $key=>$val) {
                        $content .= "<option ";
                        if ($cfgrow[$extra] == $key) $content .= "selected";
                        $content .= " value=\"".$key."\">".$val."</option>\n";
                }
                $content .= "</select>";

        }
		elseif($type == "selecty_n")
		{
			$content = '<label><input id="' . $extra . '" name="sub_' . $extra . '" value="1" ' . (($cfgrow[$param] == '1')? 'checked="checked" ' : '') . 'class="radio" type="radio"> ' . $user->lang['YES'] . '</label><label><input name="sub_' . $extra . '" value="0" ' . (($cfgrow[$param] != '1')? 'checked="checked" ' : '') . 'class="radio" type="radio"> ' . $user->lang['NO'] . '</label>';
		}
		elseif($type == "select")
		{
                $content = "<select name=\"sub_".$param."\">\n";
                foreach ($options as $key=>$val) {
                        $content .= "<option ";
                        if ($cfgrow[$param] == $key) $content .= "selected";
                        $content .= " value=\"".$key."\">".$val."</option>\n";
                }
                $content .= "</select>";
        }
		elseif ($type == "checkbox")
		{
                $content = "<input type=\"checkbox\" name=\"sub_".$param."\" value=\"true\" ";
                if ($cfgrow[$param] == "true") $content .= "checked";
                $content .= ">";
        }
		elseif ($type == "textarea")
		{
				$template->assign_vars(array(
				'S_TEXT'			=> $cfgrow[$param],
				'T_AREA'			=> "sub_".$param,
				'U_MORE_SMILIES'	=> 'forum.php?action=posting&mode=smilies&amp;f=0'
				));
				$content = $template->fetch('text_area.html');
        }
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> ($legend)?true : false,
					'LEGEND'		=> (isset($user->lang[$legend])) ? $user->lang[$legend] : $legend,
					'KEY'			=> $config_key,
					'TITLE'			=> (isset($user->lang["_admp".$param])) ? $user->lang["_admp".$param] : "_admp".$param,
					'S_EXPLAIN'		=> (isset($user->lang["_admp".$param."explain"])) ? $user->lang["_admp".$param."explain"] : "_admp".$param."explain",
					'TITLE_EXPLAIN'	=> (isset($user->lang["_admp".$param."explain"])) ? $user->lang["_admp".$param."explain"] : "_admp".$param."explain",
					'CONTENT'		=> $content,
				));
}
	function display_progress_bar($start=1, $total=1)
	{
		global $db_prefix, $db,$template, $user;

		//adm_page_header($user->lang['SYNC_IN_PROGRESS']);

		$template->set_filenames(array(
			'body'	=> 'progress_bar.html')
		);

		$template->assign_vars(array(
			'L_PROGRESS'			=> $user->lang['SYNC_IN_PROGRESS'],
			'L_PROGRESS_EXPLAIN'	=> ($start && $total) ? sprintf($user->lang['SYNC_IN_PROGRESS_EXPLAIN'], $start, $total) : $user->lang['SYNC_IN_PROGRESS'])
		);

		adm_page_footer();
	}
function delete_posts($where_type, $where_ids, $auto_sync = true, $posted_sync = true, $post_count_sync = true, $call_delete_topics = true)
{
	global $db, $config, $phpbb_root_path, $phpEx,$db_prefix;
	include_once 'include/function_posting.php';

	if ($where_type === 'range')
	{
		$where_clause = $where_ids;
	}
	else
	{
		if (is_array($where_ids))
		{
			$where_ids = array_unique($where_ids);
		}
		else
		{
			$where_ids = array($where_ids);
		}

		if (!sizeof($where_ids))
		{
			return false;
		}

		$where_ids = array_map('intval', $where_ids);

/*		Possible code for splitting post deletion
		if (sizeof($where_ids) >= 1001)
		{
			// Split into chunks of 1000
			$chunks = array_chunk($where_ids, 1000);

			foreach ($chunks as $_where_ids)
			{
				delete_posts($where_type, $_where_ids, $auto_sync, $posted_sync, $post_count_sync, $call_delete_topics);
			}

			return;
		}*/

		$where_clause = $db->sql_in_set($where_type, $where_ids);
	}

	$approved_posts = 0;
	$post_ids = $topic_ids = $forum_ids = $post_counts = $remove_topics = array();

	$sql = 'SELECT post_id, poster_id, post_approved, post_postcount, topic_id, forum_id
		FROM ' . $db_prefix . '_posts
		WHERE ' . $where_clause;
	$result = $db->sql_query($sql) or btsqlerror($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$post_ids[] = (int) $row['post_id'];
		$poster_ids[] = (int) $row['poster_id'];
		$topic_ids[] = (int) $row['topic_id'];
		$forum_ids[] = (int) $row['forum_id'];

		if ($row['post_postcount'] && $post_count_sync && $row['post_approved'])
		{
			$post_counts[$row['poster_id']] = (!empty($post_counts[$row['poster_id']])) ? $post_counts[$row['poster_id']] + 1 : 1;
		}

		if ($row['post_approved'])
		{
			$approved_posts++;
		}
	}
	$db->sql_freeresult($result);

	if (!sizeof($post_ids))
	{
		return false;
	}

	//$db->sql_transaction('begin');

	$table_ary = array($db_prefix . '_posts', $db_prefix . '_reports');

	foreach ($table_ary as $table)
	{
		$sql = "DELETE FROM $table
			WHERE " . $db->sql_in_set('post_id', $post_ids);
		$db->sql_query($sql) or btsqlerror($sql);
	}
	unset($table_ary);

	// Adjust users post counts
	if (sizeof($post_counts) && $post_count_sync)
	{
		foreach ($post_counts as $poster_id => $substract)
		{
			$sql = 'UPDATE ' . $db_prefix . '_users
				SET user_posts = 0
				WHERE id = ' . $poster_id . '
				AND user_posts < ' . $substract;
			$db->sql_query($sql) or btsqlerror($sql);

			$sql = 'UPDATE ' . $db_prefix . '_users
				SET user_posts = user_posts - ' . $substract . '
				WHERE id = ' . $poster_id . '
				AND user_posts >= ' . $substract;
			$db->sql_query($sql) or btsqlerror($sql);
		}
	}

	// Remove topics now having no posts?
	if (sizeof($topic_ids))
	{
		$sql = 'SELECT topic_id
			FROM ' . $db_prefix . '_posts
			WHERE ' . $db->sql_in_set('topic_id', $topic_ids) . '
			GROUP BY topic_id';
		$result = $db->sql_query($sql) or btsqlerror($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$remove_topics[] = $row['topic_id'];
		}
		$db->sql_freeresult($result);

		// Actually, those not within remove_topics should be removed. ;)
		$remove_topics = array_diff($topic_ids, $remove_topics);
	}

	// Remove the message from the search index
	$search_type = basename($config['search_type']);

	if (!file_exists($phpbb_root_path . 'include/search/' . $search_type . '.' . $phpEx))
	{
		trigger_error('NO_SUCH_SEARCH_MODULE');
	}

	include_once("include/search/$search_type.$phpEx");

	$error = false;
	$search = new $search_type($error);

	if ($error)
	{
		trigger_error($error);
	}

	$search->index_remove($post_ids, $poster_ids, $forum_ids);

	delete_attachments('post', $post_ids, false);


	// Resync topics_posted table
	if ($posted_sync)
	{
		update_posted_info($topic_ids);
	}

	if ($auto_sync)
	{
		sync('topic_reported', 'topic_id', $topic_ids);
		sync('topic', 'topic_id', $topic_ids, true);
		sync('forum', 'forum_id', $forum_ids, true, true);
	}

	// We actually remove topics now to not be inconsistent (the delete_topics function calls this function too)
	if (sizeof($remove_topics) && $call_delete_topics)
	{
		delete_topics('topic_id', $remove_topics, $auto_sync, $post_count_sync, false);
	}

	return sizeof($post_ids);
}
function delete_topics($where_type, $where_ids, $auto_sync = true, $post_count_sync = true, $call_delete_posts = true)
{
	global $db, $config, $db_prefix;

	$approved_topics = 0;
	$forum_ids = $topic_ids = array();

	if ($where_type === 'range')
	{
		$where_clause = $where_ids;
	}
	else
	{
		$where_ids = (is_array($where_ids)) ? array_unique($where_ids) : array($where_ids);

		if (!sizeof($where_ids))
		{
			return array('topics' => 0, 'posts' => 0);
		}

		$where_clause = $db->sql_in_set($where_type, $where_ids);
	}

	// Making sure that delete_posts does not call delete_topics again...
	$return = array(
		'posts' => ($call_delete_posts) ? delete_posts($where_type, $where_ids, false, true, $post_count_sync, false) : 0,
	);

	$sql = 'SELECT topic_id, forum_id, topic_approved, topic_moved_id
		FROM ' . $db_prefix.'_topics
		WHERE ' . $where_clause;
	$result = $db->sql_query($sql) or btsqlerror($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$forum_ids[] = $row['forum_id'];
		$topic_ids[] = $row['topic_id'];

		if ($row['topic_approved'] && !$row['topic_moved_id'])
		{
			$approved_topics++;
		}
	}
	$db->sql_freeresult($result);

	$return['topics'] = sizeof($topic_ids);

	if (!sizeof($topic_ids))
	{
		return $return;
	}

	//$db->sql_transaction('begin');

	$table_ary = array($db_prefix."_topics_track", $db_prefix."_topics_posted", $db_prefix."_poll_votes", $db_prefix."_poll_options", $db_prefix."_topics_watch", $db_prefix."_topics");

	foreach ($table_ary as $table)
	{
		$sql = "DELETE FROM $table
			WHERE " . $db->sql_in_set('topic_id', $topic_ids);
		$db->sql_query($sql) or btsqlerror($sql);
	}
	unset($table_ary);

	$moved_topic_ids = array();

	// update the other forums
	$sql = 'SELECT topic_id, forum_id
		FROM ' . $db_prefix.'_topics
		WHERE ' . $db->sql_in_set('topic_moved_id', $topic_ids);
	$result = $db->sql_query($sql) or btsqlerror($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$forum_ids[] = $row['forum_id'];
		$moved_topic_ids[] = $row['topic_id'];
	}
	$db->sql_freeresult($result);

	if (sizeof($moved_topic_ids))
	{
		$sql = 'DELETE FROM ' . $db_prefix.'_topics
			WHERE ' . $db->sql_in_set('topic_id', $moved_topic_ids);
		$db->sql_query($sql) or btsqlerror($sql);
	}

	//$db->sql_transaction('commit');

	if ($auto_sync)
	{
		sync('forum', 'forum_id', array_unique($forum_ids), true, true);
		sync('topic_reported', $where_type, $where_ids);
	}


	return $return;
}

function adm_page_footer($copyright_html = true)
{
	global $db, $db_prefix, $config, $template, $user, $auth, $pmbt_cache;
	global $starttime, $phpbb_root_path, $phpbb_admin_path, $phpEx;

	// Output page creation time
	if (defined('PMBT_DEBUG'))
	{
		$mtime = explode(' ', microtime());
		$totaltime = $mtime[0] + $mtime[1] - $starttime;

		if (!empty($_REQUEST['explain']) && $auth->acl_get('a_') && defined('PMBT_DEBUG') && method_exists($db, 'sql_report'))
		{
			$db->sql_report('display');
		}

		$debug_output = sprintf('Time : %.3fs | ? Queries | GZIP : ' . (($config['gzip_compress']) ? 'On' : 'Off') . (($user->load) ? ' | Load : ' . $user->load : ''), $totaltime);

		if (defined('PMBT_DEBUG'))
		{
			if (function_exists('memory_get_usage'))
			{
				if ($memory_usage = memory_get_usage())
				{
					global $base_memory_usage;
					$memory_usage -= $base_memory_usage;
					$memory_usage = get_formatted_filesize($memory_usage);

					$debug_output .= ' | Memory Usage: ' . $memory_usage;
				}
			}

			$debug_output .= ' | <a href="/&amp;explain=1">Explain</a>';
		}
	}

	$template->assign_vars(array(
		'DEBUG_OUTPUT'		=> (defined('PMBT_DEBUG')) ? $debug_output : '',
		'TRANSLATION_INFO'	=> (!empty($user->lang['TRANSLATION_INFO'])) ? $user->lang['TRANSLATION_INFO'] : '',
		'S_COPYRIGHT_HTML'	=> $copyright_html,
		'VERSION'			=> $config['version'])
	);

	echo $template->fetch('admin/progress_bar.html');
}
function get_forum_branch($forum_id, $type = 'all', $order = 'descending', $include_forum = true)
{
	global $db, $db_prefix;

	switch ($type)
	{
		case 'parents':
			$condition = 'f1.left_id BETWEEN f2.left_id AND f2.right_id';
		break;

		case 'children':
			$condition = 'f2.left_id BETWEEN f1.left_id AND f1.right_id';
		break;

		default:
			$condition = 'f2.left_id BETWEEN f1.left_id AND f1.right_id OR f1.left_id BETWEEN f2.left_id AND f2.right_id';
		break;
	}

	$rows = array();

	$sql = 'SELECT f2.*
		FROM ' . $db_prefix . '_forums f1
		LEFT JOIN ' . $db_prefix . "_forums f2 ON ($condition)
		WHERE f1.forum_id = $forum_id
		ORDER BY f2.left_id " . (($order == 'descending') ? 'ASC' : 'DESC');
	$result = $db->sql_query($sql) or btsqlerror($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		if (!$include_forum && $row['forum_id'] == $forum_id)
		{
			continue;
		}

		$rows[] = $row;
	}
	$db->sql_freeresult($result);

	return $rows;
}
function group_select_options_id($group_ids, $exclude_ids = false, $manage_founder = false)
{
	global $db, $user, $config, $db_prefix;
	$sql = 'SELECT group_id, group_name, group_founder_manage FROM `' . $db_prefix . '_level_settings` ';
	$result = $db->sql_query($sql) or btsqlerror($sql); 
	$s_group_options = '';
	while ($row = $db->sql_fetchrow($result))
	{
	if($row['group_founder_manage'] == '1' AND !$user->user_type == 3){continue;}
	if($exclude_ids AND in_array($row['group_id'], $exclude_ids, true)){continue;}
		$selected = ($group_ids && in_array($row['group_id'],preg_split("/;;[\\s]*/",$group_ids))) ? ' selected="selected"' : '';
		$s_group_options .= '<option  class="sep" value="' . $row['group_id'] . '"' . $selected . '>' . (($user->lang[$row['group_name']])? $user->lang[$row['group_name']] : $row['group_name']) . '</option>';
	}
	$db->sql_freeresult($result);

	return $s_group_options;
}
function group_select_options($group_id, $exclude_ids = false, $manage_founder = false)
{
	global $db, $user, $config, $db_prefix;
	$sql = 'SELECT level, name FROM `' . $db_prefix . '_levels` ';
	$result = $db->sql_query($sql) or btsqlerror($sql); 
	$s_group_options = '';
	while ($row = $db->sql_fetchrow($result))
	{
	if($exclude_ids AND in_array($row['level'],$exclude_ids)){continue;}
		$selected = ($group_id && in_array($row['level'],preg_split("/;;[\\s]*/",$group_id))) ? ' selected="selected"' : '';
		$s_group_options .= '<option  class="sep" value="' . $row['level'] . '"' . $selected . '>' . $row['name'] . '</option>';
	}
	$db->sql_freeresult($result);

	return $s_group_options;
}
function get_acc_edit_rights()
{
	global $db, $db_prefix, $user;
	$sql = "SELECT COLUMN_NAME 
		FROM INFORMATION_SCHEMA.Columns 
		WHERE TABLE_NAME = '" . $db_prefix . "_levels'
		AND COLUMN_NAME NOT IN ('level','name','group_id','group_type','color','group_desc')";
	$result = $db->sql_query($sql) or btsqlerror($sql);
	$val = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$val[] = $row[0];
	}
	$db->sql_freeresult($result);
//implode(" = 'true' AND ", $val) . " = 'true'";
}
function delete_topic_shadows($forum_id, $sql_more = '', $auto_sync = true)
{
	global $db, $db_prefix;

	if (!$forum_id)
	{
		// Nothing to do.
		return;
	}

	// Set of affected forums we have to resync
	$sync_forum_ids = array();

	// Amount of topics we select and delete at once.
	$batch_size = 500;

	do
	{
		$sql = 'SELECT t2.forum_id, t2.topic_id
			FROM ' . $db_prefix . '_topics t2, ' . $db_prefix . '_topics t
			WHERE t2.topic_moved_id = t.topic_id
				AND t.forum_id = ' . (int) $forum_id . '
				' . (($sql_more) ? 'AND ' . $sql_more : '');
		$result = $db->sql_query($sql . "\n LIMIT " . $batch_size);

		$topic_ids = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$topic_ids[] = (int) $row['topic_id'];

			$sync_forum_ids[(int) $row['forum_id']] = (int) $row['forum_id'];
		}
		$db->sql_freeresult($result);

		if (!empty($topic_ids))
		{
			$sql = 'DELETE FROM ' . $db_prefix . '_topics
				WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
			$db->sql_query($sql) or btsqlerror($sql);
		}
	}
	while (sizeof($topic_ids) == $batch_size);

	if ($auto_sync)
	{
		sync('forum', 'forum_id', $sync_forum_ids, true, true);
	}

	return $sync_forum_ids;
}
	function delete_forum($forum_id, $action_posts = 'delete', $action_subforums = 'delete', $posts_to_id = 0, $subforums_to_id = 0)
	{
		global $db, $db_prefix, $user, $pmbt_cache;

		$forum_data = get_forum_info($forum_id);

		$errors = array();
		$log_action_posts = $log_action_forums = $posts_to_name = $subforums_to_name = '';
		$forum_ids = array($forum_id);

		if ($action_posts == 'delete')
		{
			$log_action_posts = 'POSTS';
			$errors = array_merge($errors, delete_forum_content($forum_id));
		}
		else if ($action_posts == 'move')
		{
			if (!$posts_to_id)
			{
				$errors[] = $user->lang['NO_DESTINATION_FORUM'];
			}
			else
			{
				$log_action_posts = 'MOVE_POSTS';

				$sql = 'SELECT forum_name
					FROM ' . $db_prefix . '_forums
					WHERE forum_id = ' . $posts_to_id;
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					$errors[] = $user->lang['NO_FORUM'];
				}
				else
				{
					$posts_to_name = $row['forum_name'];
					$errors = array_merge($errors, move_forum_content($forum_id, $posts_to_id));
				}
			}
		}

		if (sizeof($errors))
		{
			return $errors;
		}

		if ($action_subforums == 'delete')
		{
			$log_action_forums = 'FORUMS';
			$rows = get_forum_branch($forum_id, 'children', 'descending', false);

			foreach ($rows as $row)
			{
				$forum_ids[] = $row['forum_id'];
				$errors = array_merge($errors, delete_forum_content($row['forum_id']));
			}

			if (sizeof($errors))
			{
				return $errors;
			}

			$diff = sizeof($forum_ids) * 2;

			$sql = 'DELETE FROM ' . $db_prefix . '_forums
				WHERE ' . $db->sql_in_set('forum_id', $forum_ids);
			$db->sql_query($sql) or btsqlerror($sql);

			$sql = 'DELETE FROM ' . $db_prefix . '_forum_permissions
				WHERE ' . $db->sql_in_set('forum_id', $forum_ids);
			$db->sql_query($sql) or btsqlerror($sql);

		}
		else if ($action_subforums == 'move')
		{
			if (!$subforums_to_id)
			{
				$errors[] = $user->lang['NO_DESTINATION_FORUM'];
			}
			else
			{
				$log_action_forums = 'MOVE_FORUMS';

				$sql = 'SELECT forum_name
					FROM ' . $db_prefix . '_forums
					WHERE forum_id = ' . $subforums_to_id;
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$row)
				{
					$errors[] = $user->lang['NO_FORUM'];
				}
				else
				{
					$subforums_to_name = $row['forum_name'];

					$sql = 'SELECT forum_id
						FROM ' . $db_prefix . "_forums
						WHERE parent_id = $forum_id";
					$result = $db->sql_query($sql) or btsqlerror($sql);

					while ($row = $db->sql_fetchrow($result))
					{
						move_forum($row['forum_id'], $subforums_to_id);
					}
					$db->sql_freeresult($result);

					// Grab new forum data for correct tree updating later
					$forum_data = get_forum_info($forum_id);

					$sql = 'UPDATE ' . $db_prefix . "_forums
						SET parent_id = $subforums_to_id
						WHERE parent_id = $forum_id";
					$db->sql_query($sql) or btsqlerror($sql);

					$diff = 2;
					$sql = 'DELETE FROM ' . $db_prefix . "_forums
						WHERE forum_id = $forum_id";
					$db->sql_query($sql) or btsqlerror($sql);

					$sql = 'DELETE FROM ' . $db_prefix . "_forum_permissions
						WHERE forum_id = $forum_id";
					$db->sql_query($sql) or btsqlerror($sql);

				}
			}

			if (sizeof($errors))
			{
				return $errors;
			}
		}
		else
		{
			$diff = 2;
			$sql = 'DELETE FROM ' . $db_prefix . "_forums
				WHERE forum_id = $forum_id";
			$db->sql_query($sql) or btsqlerror($sql);

			$sql = 'DELETE FROM ' . $db_prefix . "_forum_permissions
				WHERE forum_id = $forum_id";
			$db->sql_query($sql) or btsqlerror($sql);

		}

		// Resync tree
		$sql = 'UPDATE ' . $db_prefix . "_forums
			SET right_id = right_id - $diff
			WHERE left_id < {$forum_data['right_id']} AND right_id > {$forum_data['right_id']}";
		$db->sql_query($sql) or btsqlerror($sql);

		$sql = 'UPDATE ' . $db_prefix . "_forums
			SET left_id = left_id - $diff, right_id = right_id - $diff
			WHERE left_id > {$forum_data['right_id']}";
		$db->sql_query($sql) or btsqlerror($sql);


		$log_action = implode('_', array($log_action_posts, $log_action_forums));

		switch ($log_action)
		{
			case 'MOVE_POSTS_MOVE_FORUMS':
				add_log('admin','LOG_FORUM_DEL_MOVE_POSTS_MOVE_FORUMS', $posts_to_name, $subforums_to_name, $forum_data['forum_name']);
			break;

			case 'MOVE_POSTS_FORUMS':
				add_log('admin','LOG_FORUM_DEL_MOVE_POSTS_FORUMS', $posts_to_name, $forum_data['forum_name']);
			break;

			case 'POSTS_MOVE_FORUMS':
				add_log('admin','LOG_FORUM_DEL_POSTS_MOVE_FORUMS', $subforums_to_name, $forum_data['forum_name']);
			break;

			case '_MOVE_FORUMS':
				add_log('admin','LOG_FORUM_DEL_MOVE_FORUMS', $subforums_to_name, $forum_data['forum_name']);
			break;

			case 'MOVE_POSTS_':
				add_log('admin','LOG_FORUM_DEL_MOVE_POSTS', $posts_to_name, $forum_data['forum_name']);
			break;

			case 'POSTS_FORUMS':
				add_log('admin','LOG_FORUM_DEL_POSTS_FORUMS', $forum_data['forum_name']);
			break;

			case '_FORUMS':
				add_log('admin','LOG_FORUM_DEL_FORUMS', $forum_data['forum_name']);
			break;

			case 'POSTS_':
				add_log('admin','LOG_FORUM_DEL_POSTS', $forum_data['forum_name']);
			break;

			default:
				add_log('admin','LOG_FORUM_DEL_FORUM', $forum_data['forum_name']);
			break;
		}

		return $errors;
	}

	/**
	* Delete forum content
	*/
	function delete_forum_content($forum_id)
	{
		global $db, $config, $phpEx, $db_prefix;

		include_once('include/function_posting.' . $phpEx);


		// Select then delete all attachments
		$sql = 'SELECT a.topic_id
			FROM ' . $db_prefix . '_posts p, ' . $db_prefix . "_attachments a
			WHERE p.forum_id = $forum_id
				AND a.in_message = 0
				AND a.topic_id = p.topic_id";
		$result = $db->sql_query($sql) or btsqlerror($sql);

		$topic_ids = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$topic_ids[] = $row['topic_id'];
		}
		$db->sql_freeresult($result);

		delete_attachments('topic', $topic_ids, false);

		// Delete shadow topics pointing to topics in this forum
		delete_topic_shadows($forum_id);

		// Before we remove anything we make sure we are able to adjust the post counts later. ;)
		$sql = 'SELECT poster_id
			FROM ' . $db_prefix . '_posts
			WHERE forum_id = ' . $forum_id . '
				AND post_postcount = 1
				AND post_approved = 1';
		$result = $db->sql_query($sql) or btsqlerror($sql);

		$post_counts = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$post_counts[$row['poster_id']] = (!empty($post_counts[$row['poster_id']])) ? $post_counts[$row['poster_id']] + 1 : 1;
		}
		$db->sql_freeresult($result);

		switch ($db->sql_layer)
		{
			case 'mysql4':
			case 'mysqli':

				// Delete everything else and thank MySQL for offering multi-table deletion
				$tables_ary = array(
					$db_prefix.'_reports'			=> 'post_id',
					$db_prefix.'_warnings'			=> 'post_id',
					$db_prefix.'_bookmarks'			=> 'topic_id',
					$db_prefix.'_topics_watch'		=> 'topic_id',
					$db_prefix.'_topics_posted'		=> 'topic_id',
					$db_prefix.'_poll_options'		=> 'topic_id',
					$db_prefix.'_pollanswers'		=> 'topic_id',
				);

				$sql = 'DELETE ' . $db_prefix . "_posts";
				$sql_using = "\nFROM " . $db_prefix . "_posts";
				$sql_where = "\nWHERE " . $db_prefix . "_posts.forum_id = $forum_id\n";

				foreach ($tables_ary as $table => $field)
				{
					$sql .= ", $table ";
					$sql_using .= ", $table ";
					$sql_where .= "\nAND $table.$field = " . $db_prefix . "_posts.$field";
				}

				$db->sql_query($sql . $sql_using . $sql_where);

			break;

			default:

				// Delete everything else and curse your DB for not offering multi-table deletion
				$tables_ary = array(
					'post_id'	=>	array(
						db_prefix.'_reports',
						$db_prefix.'_warnings',
					),

					'topic_id'	=>	array(
						$db_prefix.'_bookmarks',
						$db_prefix.'_topics_watch',
						$db_prefix.'_topics_posted',
						$db_prefix.'_poll_options',
						$db_prefix.'_pollanswers',
					)
				);

				// Amount of rows we select and delete in one iteration.
				$batch_size = 500;

				foreach ($tables_ary as $field => $tables)
				{
					$start = 0;

					do
					{
						$sql = "SELECT $field
							FROM " . $db_prefix . '_posts
							WHERE forum_id = ' . $forum_id;
						$result = $db->sql_query($sql . "\n LIMIT " . ((!empty($start))? $start : $batch_size));

						$ids = array();
						while ($row = $db->sql_fetchrow($result))
						{
							$ids[] = $row[$field];
						}
						$db->sql_freeresult($result);

						if (sizeof($ids))
						{
							$start += sizeof($ids);

							foreach ($tables as $table)
							{
								$db->sql_query("DELETE FROM $table WHERE " . $db->sql_in_set($field, $ids));
							}
						}
					}
					while (sizeof($ids) == $batch_size);
				}
				unset($ids);

			break;
		}

		$table_ary = array($db_prefix.'_forum_permissions', $db_prefix.'_forum_track', $db_prefix.'_forum_watch', $db_prefix.'_posts', $db_prefix.'_topics', $db_prefix.'_topics_track');

		foreach ($table_ary as $table)
		{
			$db->sql_query("DELETE FROM $table WHERE forum_id = $forum_id");
		}

		// Set forum ids to 0
		$table_ary = array($db_prefix.'_drafts');

		foreach ($table_ary as $table)
		{
			$db->sql_query("UPDATE $table SET forum_id = 0 WHERE forum_id = $forum_id");
		}

		// Adjust users post counts
		if (sizeof($post_counts))
		{
			foreach ($post_counts as $poster_id => $substract)
			{
				$sql = 'UPDATE ' . $db_prefix . '_users
					SET user_posts = 0
					WHERE id = ' . $poster_id . '
					AND user_posts < ' . $substract;
				$db->sql_query($sql) or btsqlerror($sql);

				$sql = 'UPDATE ' . $db_prefix . '_users
					SET user_posts = user_posts - ' . $substract . '
					WHERE id = ' . $poster_id . '
					AND user_posts >= ' . $substract;
				$db->sql_query($sql) or btsqlerror($sql);
			}
		}


		return array();
	}
function sync($mode, $where_type = '', $where_ids = '', $resync_parents = false, $sync_extra = false)
{
	global $db_prefix, $db;

	if (is_array($where_ids))
	{
		$where_ids = array_unique($where_ids);
		$where_ids = array_map('intval', $where_ids);
	}
	else if ($where_type != 'range')
	{
		$where_ids = ($where_ids) ? array((int) $where_ids) : array();
	}

	if ($mode == 'forum' || $mode == 'topic' || $mode == 'topic_approved' || $mode == 'topic_reported' || $mode == 'post_reported')
	{
		if (!$where_type)
		{
			$where_sql = '';
			$where_sql_and = 'WHERE';
		}
		else if ($where_type == 'range')
		{
			// Only check a range of topics/forums. For instance: 'topic_id BETWEEN 1 AND 60'
			$where_sql = 'WHERE (' . $mode[0] . ".$where_ids)";
			$where_sql_and = $where_sql . "\n\tAND";
		}
		else
		{
			// Do not sync the "global forum"
			$where_ids = array_diff($where_ids, array(0));

			if (!sizeof($where_ids))
			{
				// Empty array with IDs. This means that we don't have any work to do. Just return.
				return;
			}

			// Limit the topics/forums we are syncing, use specific topic/forum IDs.
			// $where_type contains the field for the where clause (forum_id, topic_id)
			$where_sql = 'WHERE ' . $db->sql_in_set($mode[0] . '.' . $where_type, $where_ids);
			$where_sql_and = $where_sql . "\n\tAND";
		}
	}
	else
	{
		if (!sizeof($where_ids))
		{
			return;
		}

		// $where_type contains the field for the where clause (forum_id, topic_id)
		$where_sql = 'WHERE ' . $db->sql_in_set($mode[0] . '.' . $where_type, $where_ids);
		$where_sql_and = $where_sql . "\n\tAND";
	}

	switch ($mode)
	{
		case 'topic_moved':
			switch ($db->sql_layer)
			{
				case 'mysql4':
				case 'mysqli':
					$sql = 'DELETE FROM ' . $db_prefix . '_topics
						USING ' . $db_prefix . '_topics t1, ' . $db_prefix . "_topics t2
						WHERE t1.topic_moved_id = t2.topic_id
							AND t1.forum_id = t2.forum_id";
					$db->sql_query($sql) or btsqlerror($sql);
				break;

				default:
					$sql = 'SELECT t1.topic_id
						FROM ' .$db_prefix . '_topics t1, ' . $db_prefix . "_topics t2
						WHERE t1.topic_moved_id = t2.topic_id
							AND t1.forum_id = t2.forum_id";
					$result = $db->sql_query($sql) or btsqlerror($sql);

					$topic_id_ary = array();
					while ($row = $db->sql_fetchrow($result))
					{
						$topic_id_ary[] = $row['topic_id'];
					}
					$db->sql_freeresult($result);

					if (!sizeof($topic_id_ary))
					{
						return;
					}

					$sql = 'DELETE FROM ' . $db_prefix . '_topics
						WHERE ' . $db->sql_in_set('topic_id', $topic_id_ary);
					$db->sql_query($sql) or btsqlerror($sql);

				break;
			}

			break;

		case 'topic_approved':

			switch ($db->sql_layer)
			{
				case 'mysql4':
				case 'mysqli':
					$sql = 'UPDATE ' . $db_prefix . '_topics t, ' . $db_prefix . "_posts p
						SET t.topic_approved = p.post_approved
						$where_sql_and t.topic_first_post_id = p.post_id";
					$db->sql_query($sql) or btsqlerror($sql);
				break;

				default:
					$sql = 'SELECT t.topic_id, p.post_approved
						FROM ' . $db_prefix . '_topics t, ' . $db_prefix . "_posts p
						$where_sql_and p.post_id = t.topic_first_post_id
							AND p.post_approved <> t.topic_approved";
					$result = $db->sql_query($sql) or btsqlerror($sql);

					$topic_ids = array();
					while ($row = $db->sql_fetchrow($result))
					{
						$topic_ids[] = $row['topic_id'];
					}
					$db->sql_freeresult($result);

					if (!sizeof($topic_ids))
					{
						return;
					}

					$sql = 'UPDATE ' . $db_prefix . '_topics
						SET topic_approved = 1 - topic_approved
						WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
					$db->sql_query($sql) or btsqlerror($sql);
				break;
			}

			break;

		case 'post_reported':
			$post_ids = $post_reported = array();


			$sql = 'SELECT p.post_id, p.post_reported
				FROM ' . $db_prefix . "_posts p
				$where_sql
				GROUP BY p.post_id, p.post_reported";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$post_ids[$row['post_id']] = $row['post_id'];
				if ($row['post_reported'])
				{
					$post_reported[$row['post_id']] = 1;
				}
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT DISTINCT(post_id)
				FROM ' . $db_prefix . '_reports
				WHERE ' . $db->sql_in_set('post_id', $post_ids) . '
					AND report_closed = 0';
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$post_ids = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (!isset($post_reported[$row['post_id']]))
				{
					$post_ids[] = $row['post_id'];
				}
				else
				{
					unset($post_reported[$row['post_id']]);
				}
			}
			$db->sql_freeresult($result);

			// $post_reported should be empty by now, if it's not it contains
			// posts that are falsely flagged as reported
			foreach ($post_reported as $post_id => $void)
			{
				$post_ids[] = $post_id;
			}

			if (sizeof($post_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_posts
					SET post_reported = 1 - post_reported
					WHERE ' . $db->sql_in_set('post_id', $post_ids);
				$db->sql_query($sql) or btsqlerror($sql);
			}

			break;

		case 'topic_reported':
			if ($sync_extra)
			{
				sync('post_reported', $where_type, $where_ids);
			}

			$topic_ids = $topic_reported = array();


			$sql = 'SELECT DISTINCT(t.topic_id)
				FROM ' . $db_prefix . "_posts t
				$where_sql_and t.post_reported = 1";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$topic_reported[$row['topic_id']] = 1;
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT t.topic_id, t.topic_reported
				FROM ' . $db_prefix . "_topics t
				$where_sql";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['topic_reported'] ^ isset($topic_reported[$row['topic_id']]))
				{
					$topic_ids[] = $row['topic_id'];
				}
			}
			$db->sql_freeresult($result);

			if (sizeof($topic_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_topics
					SET topic_reported = 1 - topic_reported
					WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
				$db->sql_query($sql) or btsqlerror($sql);
			}

			break;

		case 'post_attachment':
			$post_ids = $post_attachment = array();

			////$db->sql_transaction('begin');

			$sql = 'SELECT p.post_id, p.post_attachment
				FROM ' . $db_prefix . "_posts p
				$where_sql
				GROUP BY p.post_id, p.post_attachment";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$post_ids[$row['post_id']] = $row['post_id'];
				if ($row['post_attachment'])
				{
					$post_attachment[$row['post_id']] = 1;
				}
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT DISTINCT(post_msg_id)
				FROM ' . $db_prefix . '_attachments
				WHERE ' . $db->sql_in_set('post_msg_id', $post_ids) . '
					AND in_message = 0';
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$post_ids = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (!isset($post_attachment[$row['post_msg_id']]))
				{
					$post_ids[] = $row['post_msg_id'];
				}
				else
				{
					unset($post_attachment[$row['post_msg_id']]);
				}
			}
			$db->sql_freeresult($result);

			// $post_attachment should be empty by now, if it's not it contains
			// posts that are falsely flagged as having attachments
			foreach ($post_attachment as $post_id => $void)
			{
				$post_ids[] = $post_id;
			}

			if (sizeof($post_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_posts
					SET post_attachment = 1 - post_attachment
					WHERE ' . $db->sql_in_set('post_id', $post_ids);
				$db->sql_query($sql) or btsqlerror($sql);
			}

			////$db->sql_transaction('commit');
			break;

		case 'topic_attachment':
			if ($sync_extra)
			{
				sync('post_attachment', $where_type, $where_ids);
			}

			$topic_ids = $topic_attachment = array();

			////$db->sql_transaction('begin');

			$sql = 'SELECT DISTINCT(t.topic_id)
				FROM ' . $db_prefix . "_posts t
				$where_sql_and t.post_attachment = 1";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$topic_attachment[$row['topic_id']] = 1;
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT t.topic_id, t.topic_attachment
				FROM ' . $db_prefix . "_topics t
				$where_sql";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['topic_attachment'] ^ isset($topic_attachment[$row['topic_id']]))
				{
					$topic_ids[] = $row['topic_id'];
				}
			}
			$db->sql_freeresult($result);

			if (sizeof($topic_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_topics
					SET topic_attachment = 1 - topic_attachment
					WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
				$db->sql_query($sql) or btsqlerror($sql);
			}

			////$db->sql_transaction('commit');

			break;

		case 'forum':

			////$db->sql_transaction('begin');

			// 1: Get the list of all forums
			$sql = 'SELECT f.*
				FROM ' . $db_prefix . "_forums f
				$where_sql";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$forum_data = $forum_ids = $post_ids = $last_post_id = $post_info = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['forum_type'] == 2)
				{
					continue;
				}

				$forum_id = (int) $row['forum_id'];
				$forum_ids[$forum_id] = $forum_id;

				$forum_data[$forum_id] = $row;
				if ($sync_extra)
				{
					$forum_data[$forum_id]['posts'] = 0;
					$forum_data[$forum_id]['topics'] = 0;
					$forum_data[$forum_id]['topics_real'] = 0;
				}
				$forum_data[$forum_id]['last_post_id'] = 0;
				$forum_data[$forum_id]['last_post_subject'] = '';
				$forum_data[$forum_id]['last_post_time'] = 0;
				$forum_data[$forum_id]['last_poster_id'] = 0;
				$forum_data[$forum_id]['last_poster_name'] = '';
				$forum_data[$forum_id]['last_poster_colour'] = '';
			}
			$db->sql_freeresult($result);

			if (!sizeof($forum_ids))
			{
				break;
			}

			$forum_ids = array_values($forum_ids);

			// 2: Get topic counts for each forum (optional)
			if ($sync_extra)
			{
				$sql = 'SELECT forum_id, topic_approved, COUNT(topic_id) AS forum_topics
					FROM ' . $db_prefix . '_topics
					WHERE ' . $db->sql_in_set('forum_id', $forum_ids) . '
					GROUP BY forum_id, topic_approved';
				$result = $db->sql_query($sql) or btsqlerror($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$forum_id = (int) $row['forum_id'];
					$forum_data[$forum_id]['topics_real'] += $row['forum_topics'];

					if ($row['topic_approved'])
					{
						$forum_data[$forum_id]['topics'] = $row['forum_topics'];
					}
				}
				$db->sql_freeresult($result);
			}

			// 3: Get post count for each forum (optional)
			if ($sync_extra)
			{
				if (sizeof($forum_ids) == 1)
				{
					$sql = 'SELECT SUM(t.topic_replies + 1) AS forum_posts
						FROM ' . $db_prefix . '_topics t
						WHERE ' . $db->sql_in_set('t.forum_id', $forum_ids) . '
							AND t.topic_approved = 1
							AND t.topic_status <> ' . 2;
				}
				else
				{
					$sql = 'SELECT t.forum_id, SUM(t.topic_replies + 1) AS forum_posts
						FROM ' . $db_prefix . '_topics t
						WHERE ' . $db->sql_in_set('t.forum_id', $forum_ids) . '
							AND t.topic_approved = 1
							AND t.topic_status <> ' . 2 . '
						GROUP BY t.forum_id';
				}

				$result = $db->sql_query($sql) or btsqlerror($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$forum_id = (sizeof($forum_ids) == 1) ? (int) $forum_ids[0] : (int) $row['forum_id'];

					$forum_data[$forum_id]['posts'] = (int) $row['forum_posts'];
				}
				$db->sql_freeresult($result);
			}

			// 4: Get last_post_id for each forum
			if (sizeof($forum_ids) == 1)
			{
				$sql = 'SELECT MAX(t.topic_last_post_id) as last_post_id
					FROM ' . $db_prefix . '_topics t
					WHERE ' . $db->sql_in_set('t.forum_id', $forum_ids) . '
						AND t.topic_approved = 1';
			}
			else
			{
				$sql = 'SELECT t.forum_id, MAX(t.topic_last_post_id) as last_post_id
					FROM ' . $db_prefix . '_topics t
					WHERE ' . $db->sql_in_set('t.forum_id', $forum_ids) . '
						AND t.topic_approved = 1
					GROUP BY t.forum_id';
			}

			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$forum_id = (sizeof($forum_ids) == 1) ? (int) $forum_ids[0] : (int) $row['forum_id'];

				$forum_data[$forum_id]['last_post_id'] = (int) $row['last_post_id'];

				$post_ids[] = $row['last_post_id'];
			}
			$db->sql_freeresult($result);

			// 5: Retrieve last_post infos
			if (sizeof($post_ids))
			{
				$sql = 'SELECT p.post_id, p.poster_id, p.post_subject, p.post_time, p.post_username, u.can_do , u.username, L.group_colour AS user_colour
					FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, ' . $db_prefix . '_level_settings L
					WHERE ' . $db->sql_in_set('p.post_id', $post_ids) . '
						AND p.poster_id = u.id
						AND L.group_id = u.can_do';
				$result = $db->sql_query($sql) or btsqlerror($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$post_info[$row['post_id']] = $row;
				}
				$db->sql_freeresult($result);

				foreach ($forum_data as $forum_id => $data)
				{
					if ($data['last_post_id'])
					{
						if (isset($post_info[$data['last_post_id']]))
						{
							$forum_data[$forum_id]['last_post_subject'] = $post_info[$data['last_post_id']]['post_subject'];
							$forum_data[$forum_id]['last_post_time'] = $post_info[$data['last_post_id']]['post_time'];
							$forum_data[$forum_id]['last_poster_id'] = $post_info[$data['last_post_id']]['poster_id'];
							$forum_data[$forum_id]['last_poster_name'] = ($post_info[$data['last_post_id']]['poster_id'] != 0) ? $post_info[$data['last_post_id']]['username'] : $post_info[$data['last_post_id']]['post_username'];
							$forum_data[$forum_id]['last_poster_colour'] = $post_info[$data['last_post_id']]['user_colour'];
						}
						else
						{
							// For some reason we did not find the post in the db
							$forum_data[$forum_id]['last_post_id'] = 0;
							$forum_data[$forum_id]['last_post_subject'] = '';
							$forum_data[$forum_id]['last_post_time'] = 0;
							$forum_data[$forum_id]['last_poster_id'] = 0;
							$forum_data[$forum_id]['last_poster_name'] = '';
							$forum_data[$forum_id]['last_poster_colour'] = '';
						}
					}
				}
				unset($post_info);
			}

			// 6: Now do that thing
			$fieldnames = array('last_post_id', 'last_post_subject', 'last_post_time', 'last_poster_id', 'last_poster_name', 'last_poster_colour');

			if ($sync_extra)
			{
				array_push($fieldnames, 'posts', 'topics', 'topics_real');
			}

			foreach ($forum_data as $forum_id => $row)
			{
				$sql_ary = array();

				foreach ($fieldnames as $fieldname)
				{
					if ($row['forum_' . $fieldname] != $row[$fieldname])
					{
						if (preg_match('#(name|colour|subject)$#', $fieldname))
						{
							$sql_ary['forum_' . $fieldname] = (string) $row[$fieldname];
						}
						else
						{
							$sql_ary['forum_' . $fieldname] = (int) $row[$fieldname];
						}
					}
				}

				if (sizeof($sql_ary))
				{
					$sql = 'UPDATE ' . $db_prefix . '_forums
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE forum_id = ' . $forum_id;
					$db->sql_query($sql) or btsqlerror($sql);
				}
			}

			////$db->sql_transaction('commit');
			break;

		case 'topic':
			$topic_data = $post_ids = $approved_unapproved_ids = $resync_forums = $delete_topics = $delete_posts = $moved_topics = array();

			////$db->sql_transaction('begin');

			$sql = 'SELECT t.topic_id, t.forum_id, t.topic_moved_id, t.topic_approved, ' . (($sync_extra) ? 't.topic_attachment, t.topic_reported, ' : '') . 't.topic_poster, t.topic_time, t.topic_replies, t.topic_replies_real, t.topic_first_post_id, t.topic_first_poster_name, t.topic_first_poster_colour, t.topic_last_post_id, t.topic_last_post_subject, t.topic_last_poster_id, t.topic_last_poster_name, t.topic_last_poster_colour, t.topic_last_post_time
				FROM ' . $db_prefix . "_topics t
				$where_sql";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['topic_moved_id'])
				{
					$moved_topics[] = $row['topic_id'];
					continue;
				}

				$topic_id = (int) $row['topic_id'];
				$topic_data[$topic_id] = $row;
				$topic_data[$topic_id]['replies_real'] = -1;
				$topic_data[$topic_id]['replies'] = 0;
				$topic_data[$topic_id]['first_post_id'] = 0;
				$topic_data[$topic_id]['last_post_id'] = 0;
				unset($topic_data[$topic_id]['topic_id']);

				// This array holds all topic_ids
				$delete_topics[$topic_id] = '';

				if ($sync_extra)
				{
					$topic_data[$topic_id]['reported'] = 0;
					$topic_data[$topic_id]['attachment'] = 0;
				}
			}
			$db->sql_freeresult($result);

			// Use "t" as table alias because of the $where_sql clause
			// NOTE: 't.post_approved' in the GROUP BY is causing a major slowdown.
			$sql = 'SELECT t.topic_id, t.post_approved, COUNT(t.post_id) AS total_posts, MIN(t.post_id) AS first_post_id, MAX(t.post_id) AS last_post_id
				FROM ' . $db_prefix . "_posts t
				$where_sql
				GROUP BY t.topic_id, t.post_approved";
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$topic_id = (int) $row['topic_id'];

				$row['first_post_id'] = (int) $row['first_post_id'];
				$row['last_post_id'] = (int) $row['last_post_id'];

				if (!isset($topic_data[$topic_id]))
				{
					// Hey, these posts come from a topic that does not exist
					$delete_posts[$topic_id] = '';
				}
				else
				{
					// Unset the corresponding entry in $delete_topics
					// When we'll be done, only topics with no posts will remain
					unset($delete_topics[$topic_id]);

					$topic_data[$topic_id]['replies_real'] += $row['total_posts'];
					$topic_data[$topic_id]['first_post_id'] = (!$topic_data[$topic_id]['first_post_id']) ? $row['first_post_id'] : min($topic_data[$topic_id]['first_post_id'], $row['first_post_id']);

					if ($row['post_approved'] || !$topic_data[$topic_id]['last_post_id'])
					{
						$topic_data[$topic_id]['replies'] = $row['total_posts'] - 1;
						$topic_data[$topic_id]['last_post_id'] = $row['last_post_id'];
					}
				}
			}
			$db->sql_freeresult($result);

			foreach ($topic_data as $topic_id => $row)
			{
				$post_ids[] = $row['first_post_id'];
				if ($row['first_post_id'] != $row['last_post_id'])
				{
					$post_ids[] = $row['last_post_id'];
				}
			}

			// Now we delete empty topics and orphan posts
			if (sizeof($delete_posts))
			{
				delete_posts('topic_id', array_keys($delete_posts), false);
				unset($delete_posts);
			}

			if (!sizeof($topic_data))
			{
				// If we get there, topic ids were invalid or topics did not contain any posts
				delete_topics($where_type, $where_ids, true);
				return;
			}

			if (sizeof($delete_topics))
			{
				$delete_topic_ids = array();
				foreach ($delete_topics as $topic_id => $void)
				{
					unset($topic_data[$topic_id]);
					$delete_topic_ids[] = $topic_id;
				}

				delete_topics('topic_id', $delete_topic_ids, false);
				unset($delete_topics, $delete_topic_ids);
			}

			$sql = 'SELECT p.post_id, p.topic_id, p.post_approved, p.poster_id, p.post_subject, p.post_username, p.post_time, u.username, u.can_do , l.group_colour AS user_colour
				FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, ' . $db_prefix . '_level_settings l
				WHERE ' . $db->sql_in_set('p.post_id', $post_ids) . '
					AND u.id = p.poster_id
					AND l.group_id = u.can_do';
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$post_ids = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$topic_id = intval($row['topic_id']);

				if ($row['post_id'] == $topic_data[$topic_id]['first_post_id'])
				{
					if ($topic_data[$topic_id]['topic_approved'] != $row['post_approved'])
					{
						$approved_unapproved_ids[] = $topic_id;
					}
					$topic_data[$topic_id]['time'] = $row['post_time'];
					$topic_data[$topic_id]['poster'] = $row['poster_id'];
					$topic_data[$topic_id]['first_poster_name'] = ($row['poster_id'] == 0) ? $row['post_username'] : $row['username'];
					$topic_data[$topic_id]['first_poster_colour'] = $row['user_colour'];
				}

				if ($row['post_id'] == $topic_data[$topic_id]['last_post_id'])
				{
					$topic_data[$topic_id]['last_poster_id'] = $row['poster_id'];
					$topic_data[$topic_id]['last_post_subject'] = $row['post_subject'];
					$topic_data[$topic_id]['last_post_time'] = $row['post_time'];
					$topic_data[$topic_id]['last_poster_name'] = ($row['poster_id'] == 0) ? $row['post_username'] : $row['username'];
					$topic_data[$topic_id]['last_poster_colour'] = $row['user_colour'];
				}
			}
			$db->sql_freeresult($result);

			// Make sure shadow topics do link to existing topics
			if (sizeof($moved_topics))
			{
				$delete_topics = array();

				$sql = 'SELECT t1.topic_id, t1.topic_moved_id
					FROM ' . $db_prefix . '_topics t1
					LEFT JOIN ' . $db_prefix . '_topics t2 ON (t2.topic_id = t1.topic_moved_id)
					WHERE ' . $db->sql_in_set('t1.topic_id', $moved_topics) . '
						AND t2.topic_id IS NULL';
				$result = $db->sql_query($sql) or btsqlerror($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$delete_topics[] = $row['topic_id'];
				}
				$db->sql_freeresult($result);

				if (sizeof($delete_topics))
				{
					delete_topics('topic_id', $delete_topics, false);
				}
				unset($delete_topics);

				// Make sure shadow topics having no last post data being updated (this only rarely happens...)
				$sql = 'SELECT topic_id, topic_moved_id, topic_last_post_id, topic_first_post_id
					FROM ' . $db_prefix . '_topics
					WHERE ' . $db->sql_in_set('topic_id', $moved_topics) . '
						AND topic_last_post_time = 0';
				$result = $db->sql_query($sql) or btsqlerror($sql);

				$shadow_topic_data = $post_ids = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$shadow_topic_data[$row['topic_moved_id']] = $row;
					$post_ids[] = $row['topic_last_post_id'];
					$post_ids[] = $row['topic_first_post_id'];
				}
				$db->sql_freeresult($result);

				$sync_shadow_topics = array();
				if (sizeof($post_ids))
				{
					$sql = 'SELECT p.post_id, p.topic_id, p.post_approved, p.poster_id, p.post_subject, p.post_username, p.post_time, u.username, u.can_do , l.group_colour AS user_colour
						FROM ' . $db_prefix . '_posts p, ' . $db_prefix . '_users u, ' . $db_prefix . '_level_settings l
						WHERE ' . $db->sql_in_set('p.post_id', $post_ids) . '
							AND u.id = p.poster_id
							AND l.group_id = u.can_do';
					$result = $db->sql_query($sql) or btsqlerror($sql);

					$post_ids = array();
					while ($row = $db->sql_fetchrow($result))
					{
						$topic_id = (int) $row['topic_id'];

						// Ok, there should be a shadow topic. If there isn't, then there's something wrong with the db.
						// However, there's not much we can do about it.
						if (!empty($shadow_topic_data[$topic_id]))
						{
							if ($row['post_id'] == $shadow_topic_data[$topic_id]['topic_first_post_id'])
							{
								$orig_topic_id = $shadow_topic_data[$topic_id]['topic_id'];

								if (!isset($sync_shadow_topics[$orig_topic_id]))
								{
									$sync_shadow_topics[$orig_topic_id] = array();
								}

								$sync_shadow_topics[$orig_topic_id]['topic_time'] = $row['post_time'];
								$sync_shadow_topics[$orig_topic_id]['topic_poster'] = $row['poster_id'];
								$sync_shadow_topics[$orig_topic_id]['topic_first_poster_name'] = ($row['poster_id'] == 0) ? $row['post_username'] : $row['username'];
								$sync_shadow_topics[$orig_topic_id]['topic_first_poster_colour'] = $row['user_colour'];
							}

							if ($row['post_id'] == $shadow_topic_data[$topic_id]['topic_last_post_id'])
							{
								$orig_topic_id = $shadow_topic_data[$topic_id]['topic_id'];

								if (!isset($sync_shadow_topics[$orig_topic_id]))
								{
									$sync_shadow_topics[$orig_topic_id] = array();
								}

								$sync_shadow_topics[$orig_topic_id]['topic_last_poster_id'] = $row['poster_id'];
								$sync_shadow_topics[$orig_topic_id]['topic_last_post_subject'] = $row['post_subject'];
								$sync_shadow_topics[$orig_topic_id]['topic_last_post_time'] = $row['post_time'];
								$sync_shadow_topics[$orig_topic_id]['topic_last_poster_name'] = ($row['poster_id'] == 0) ? $row['post_username'] : $row['username'];
								$sync_shadow_topics[$orig_topic_id]['topic_last_poster_colour'] = $row['user_colour'];
							}
						}
					}
					$db->sql_freeresult($result);

					$shadow_topic_data = array();

					// Update the information we collected
					if (sizeof($sync_shadow_topics))
					{
						foreach ($sync_shadow_topics as $sync_topic_id => $sql_ary)
						{
							$sql = 'UPDATE ' . $db_prefix . '_topics
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE topic_id = ' . $sync_topic_id;
							$db->sql_query($sql) or btsqlerror($sql);
						}
					}
				}

				unset($sync_shadow_topics, $shadow_topic_data);
			}

			// approved becomes unapproved, and vice-versa
			if (sizeof($approved_unapproved_ids))
			{
				$sql = 'UPDATE ' . $db_prefix . '_topics
					SET topic_approved = 1 - topic_approved
					WHERE ' . $db->sql_in_set('topic_id', $approved_unapproved_ids);
				$db->sql_query($sql) or btsqlerror($sql);
			}
			unset($approved_unapproved_ids);

			// These are fields that will be synchronised
			$fieldnames = array('time', 'replies', 'replies_real', 'poster', 'first_post_id', 'first_poster_name', 'first_poster_colour', 'last_post_id', 'last_post_subject', 'last_post_time', 'last_poster_id', 'last_poster_name', 'last_poster_colour');

			if ($sync_extra)
			{
				// This routine assumes that post_reported values are correct
				// if they are not, use sync('post_reported') first
				$sql = 'SELECT t.topic_id, p.post_id
					FROM ' . $db_prefix . '_topics t, ' . $db_prefix . "_posts p
					$where_sql_and p.topic_id = t.topic_id
						AND p.post_reported = 1
					GROUP BY t.topic_id, p.post_id";
				$result = $db->sql_query($sql) or btsqlerror($sql);

				$fieldnames[] = 'reported';
				while ($row = $db->sql_fetchrow($result))
				{
					$topic_data[intval($row['topic_id'])]['reported'] = 1;
				}
				$db->sql_freeresult($result);

				// This routine assumes that post_attachment values are correct
				// if they are not, use sync('post_attachment') first
				$sql = 'SELECT t.topic_id, p.post_id
					FROM ' . $db_prefix . '_topics t, ' . $db_prefix . "_posts p
					$where_sql_and p.topic_id = t.topic_id
						AND p.post_attachment = 1
					GROUP BY t.topic_id, p.post_id";
				$result = $db->sql_query($sql) or btsqlerror($sql);

				$fieldnames[] = 'attachment';
				while ($row = $db->sql_fetchrow($result))
				{
					$topic_data[intval($row['topic_id'])]['attachment'] = 1;
				}
				$db->sql_freeresult($result);
			}

			foreach ($topic_data as $topic_id => $row)
			{
				$sql_ary = array();

				foreach ($fieldnames as $fieldname)
				{
					if (isset($row[$fieldname]) && isset($row['topic_' . $fieldname]) && $row['topic_' . $fieldname] != $row[$fieldname])
					{
						$sql_ary['topic_' . $fieldname] = $row[$fieldname];
					}
				}

				if (sizeof($sql_ary))
				{
					$sql = 'UPDATE ' . $db_prefix . '_topics
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE topic_id = ' . $topic_id;
					$db->sql_query($sql) or btsqlerror($sql);

					$resync_forums[$row['forum_id']] = $row['forum_id'];
				}
			}
			unset($topic_data);


			// if some topics have been resync'ed then resync parent forums
			// except when we're only syncing a range, we don't want to sync forums during
			// batch processing.
			if ($resync_parents && sizeof($resync_forums) && $where_type != 'range')
			{
				sync('forum', 'forum_id', array_values($resync_forums), true, true);
			}
			break;
	}

	return;
}
function group_validate_groupname($group_id, $group_name)
{
	global $config, $db, $db_prefix;

	$group_name =  utf8_clean_string($group_name);

	if (!empty($group_id))
	{
		$sql = 'SELECT group_name
			FROM ' . $db_prefix . '_level_settings
			WHERE group_id = ' . (int) $group_id;
		$result = $db->sql_query($sql) or btsqlerror($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$row)
		{
			return false;
		}

		$allowed_groupname = utf8_clean_string($row['group_name']);

		if ($allowed_groupname == $group_name)
		{
			return false;
		}
	}

	$sql = 'SELECT group_name
		FROM ' . $db_prefix . "_level_settings
		WHERE LOWER(group_name) = '" . $db->sql_escape(utf8_strtolower($group_name)) . "'";
	$result = $db->sql_query($sql) or btsqlerror($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($row)
	{
		return 'GROUP_NAME_TAKEN';
	}

	return false;
}
function add_permission_language()
{
	global $user, $phpEx;

	// First of all, our own file. We need to include it as the first file because it presets all relevant variables.
	$user->set_lang('admin/acp_permissions',$user->ulanguage);

	$files_to_add = array();

	// Now search in acp and mods folder for permissions_ files.
	foreach (array('acp/', 'mods/') as $path)
	{
		$dh = @opendir($user->lang_path . $user->lang_name . '/' . $path);

		if ($dh)
		{
			while (($file = readdir($dh)) !== false)
			{
				if ($file !== 'permissions_phpbb.' . $phpEx && strpos($file, 'permissions_') === 0 && substr($file, -(strlen($phpEx) + 1)) === '.' . $phpEx)
				{
					$files_to_add[] = $path . substr($file, 0, -(strlen($phpEx) + 1));
				}
			}
			closedir($dh);
		}
	}

	if (!sizeof($files_to_add))
	{
		return false;
	}

	$user->add_lang($files_to_add);
	return true;
}
function update_foes($group_id = false, $user_id = false)
{
	global $db, $db_prefix, $auth;

	// update foes for some user
	if (is_array($user_id) && sizeof($user_id))
	{
		$sql = 'DELETE FROM ' . $db_prefix . '_zebra
			WHERE ' . $db->sql_in_set('zebra_id', $user_id) . '
				AND foe = 1';
		$db->sql_query($sql);
		return;
	}

	// update foes for some group
	if (is_array($group_id) && sizeof($group_id))
	{
		// Grab group settings...
		$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'a.group_id',

			'FROM'		=> array(
				$db_prefix . '_acl_options'	=> 'ao',
				$db_prefix . '_acl_groups'	=> 'a'
			),

			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array($db_prefix . '_acl_roles_data' => 'r'),
					'ON'	=> 'a.auth_role_id = r.role_id'
				),
			),

			'WHERE'		=> '(ao.auth_option_id = a.auth_option_id OR ao.auth_option_id = r.auth_option_id)
				AND ' . $db->sql_in_set('a.group_id', $group_id) . "
				AND ao.auth_option IN ('a_', 'm_')",

			'GROUP_BY'	=> 'a.group_id'
		));
		$result = $db->sql_query($sql) or btsqlerror($sql);

		$groups = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$groups[] = (int) $row['group_id'];
		}
		$db->sql_freeresult($result);

		if (!sizeof($groups))
		{
			return;
		}

		switch ($db->sql_layer)
		{
			case 'mysqli':
			case 'mysql4':
				$sql = 'DELETE ' . (($db->sql_layer === 'mysqli' || version_compare($db->sql_server_info(true), '4.1', '>=')) ? 'z.*' : ZEBRA_TABLE) . '
					FROM ' . $db_prefix . '_zebra z, ' . $db_prefix . '_user_group ug
					WHERE z.zebra_id = ug.user_id
						AND z.foe = 1
						AND ' . $db->sql_in_set('ug.group_id', $groups);
				$db->sql_query($sql) or btsqlerror($sql);
			break;

			default:
				$sql = 'SELECT user_id
					FROM ' . $db_prefix . '_user_group
					WHERE ' . $db->sql_in_set('group_id', $groups);
				$result = $db->sql_query($sql) or btsqlerror($sql);

				$users = array();
				while ($row = $db->sql_fetchrow($result))
				{
					$users[] = (int) $row['user_id'];
				}
				$db->sql_freeresult($result);

				if (sizeof($users))
				{
					$sql = 'DELETE FROM ' . $db_prefix . '_zebra
						WHERE ' . $db->sql_in_set('zebra_id', $users) . '
							AND foe = 1';
					$db->sql_query($sql) or btsqlerror($sql);
				}
			break;
		}

		return;
	}

	// update foes for everyone
	$perms = array();
	foreach ($auth->acl_get_list(false, array('a_', 'm_'), false) as $forum_id => $forum_ary)
	{
		foreach ($forum_ary as $auth_option => $user_ary)
		{
			$perms = array_merge($perms, $user_ary);
		}
	}

	if (sizeof($perms))
	{
		$sql = 'DELETE FROM ' . $db_prefix . '_zebra
			WHERE ' . $db->sql_in_set('zebra_id', array_unique($perms)) . '
				AND foe = 1';
		$db->sql_query($sql) or btsqlerror($sql);
	}
	unset($perms);
}
function view_warned_users(&$users, &$user_count, $limit = 0, $offset = 0, $limit_days = 0, $sort_by = 'user_warnings DESC')
{
	global $db, $db_prefix;

	$sql = 'SELECT id, username, can_do, l.group_colour AS user_colour, user_warnings, user_last_warning
		FROM ' . $db_prefix . '_users , ' . $db_prefix . '_level_settings l
		WHERE 
		l.group_id = can_do 
		AND user_warnings > 0
		' . (($limit_days) ? "AND user_last_warning >= $limit_days" : '') . "
		ORDER BY $sort_by 
		LIMIT $offset, $limit";
		//die($sql);
	$result = $db->sql_query($sql);
	$users = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$sql = 'SELECT count(id) AS user_count
		FROM ' . $db_prefix . '_users
		WHERE user_warnings > 0
		' . (($limit_days) ? "AND user_last_warning >= $limit_days" : '');
	$result = $db->sql_query($sql);
	$user_count = (int) $db->sql_fetchfield('user_count');
	$db->sql_freeresult($result);

	return;
}

function cache_moderators()
{
	global $db, $db_prefix, $pmbt_cache, $auth, $phpbb_root_path, $phpEx;

	// Remove cached sql results
	//$pmbt_cache->destroy('sql', $db_prefix . '_moderator_cache');

	// Clear table
	switch ($db->sql_layer)
	{
		case 'sqlite':
		case 'firebird':
			$db->sql_query('DELETE FROM ' . $db_prefix . '_moderator_cache');
		break;

		default:
			$db->sql_query('TRUNCATE TABLE ' . $db_prefix . '_moderator_cache');
		break;
	}

	// We add moderators who have forum moderator permissions without an explicit ACL_NEVER setting
	$hold_ary = $ug_id_ary = $sql_ary = array();

	// Grab all users having moderative options...
	$hold_ary = $auth->acl_user_raw_data(false, 'm_%', false);

	// Add users?
	if (sizeof($hold_ary))
	{
		// At least one moderative option warrants a display
		$ug_id_ary = array_keys($hold_ary);

		// Remove users who have group memberships with DENY moderator permissions
		$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'a.forum_id, ug.user_id',

			'FROM'		=> array(
				$db_prefix . '_acl_options'	=> 'o',
				$db_prefix . '_user_group'	=> 'ug',
				$db_prefix . '_acl_groups'	=> 'a'
			),

			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array($db_prefix . '_acl_roles_data' => 'r'),
					'ON'	=> 'a.auth_role_id = r.role_id'
				)
			),

			'WHERE'		=> '(o.auth_option_id = a.auth_option_id OR o.auth_option_id = r.auth_option_id)
				AND ((a.auth_setting = ' . 0 . ' AND r.auth_setting IS NULL)
					OR r.auth_setting = ' . 0 . ')
				AND a.group_id = ug.group_id
				AND ' . $db->sql_in_set('ug.user_id', $ug_id_ary) . "
				AND ug.user_pending = 0
				AND o.auth_option " . $db->sql_like_expression('m_' . $db->any_char),
		));
		$result = $db->sql_query($sql) or btsqlerror($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			if (isset($hold_ary[$row['user_id']][$row['forum_id']]))
			{
				unset($hold_ary[$row['user_id']][$row['forum_id']]);
			}
		}
		$db->sql_freeresult($result);

		if (sizeof($hold_ary))
		{
			// Get usernames...
			$sql = 'SELECT id AS user_id, username
				FROM ' . $db_prefix . '_users
				WHERE ' . $db->sql_in_set('id', array_keys($hold_ary));
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$usernames_ary = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$usernames_ary[$row['user_id']] = $row['username'];
			}

			foreach ($hold_ary as $user_id => $forum_id_ary)
			{
				// Do not continue if user does not exist
				if (!isset($usernames_ary[$user_id]))
				{
					continue;
				}

				foreach ($forum_id_ary as $forum_id => $auth_ary)
				{
					$sql_ary[] = array(
						'forum_id'		=> (int) $forum_id,
						'user_id'		=> (int) $user_id,
						'username'		=> (string) $usernames_ary[$user_id],
						'group_id'		=> 0,
						'group_name'	=> ''
					);
				}
			}
		}
	}

	// Now to the groups...
	$hold_ary = $auth->acl_group_raw_data(false, 'm_%', false);

	if (sizeof($hold_ary))
	{
		$ug_id_ary = array_keys($hold_ary);

		// Make sure not hidden or special groups are involved...
		$sql = 'SELECT group_name, group_id, group_type
			FROM ' . $db_prefix . '_level_settings
			WHERE ' . $db->sql_in_set('group_id', $ug_id_ary);
		$result = $db->sql_query($sql) or btsqlerror($sql);

		$groupnames_ary = array();
		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['group_type'] == 2 || $row['group_type'] == 3)
			{
				unset($hold_ary[$row['group_id']]);
			}

			$groupnames_ary[$row['group_id']] = $row['group_name'];
		}
		$db->sql_freeresult($result);

		foreach ($hold_ary as $group_id => $forum_id_ary)
		{
			// If there is no group, we do not assign it...
			if (!isset($groupnames_ary[$group_id]))
			{
				continue;
			}

			foreach ($forum_id_ary as $forum_id => $auth_ary)
			{
				$flag = false;
				foreach ($auth_ary as $auth_option => $setting)
				{
					// Make sure at least one ACL_YES option is set...
					if ($setting == 1)
					{
						$flag = true;
						break;
					}
				}

				if (!$flag)
				{
					continue;
				}

				$sql_ary[] = array(
					'forum_id'		=> (int) $forum_id,
					'user_id'		=> 0,
					'username'		=> '',
					'group_id'		=> (int) $group_id,
					'group_name'	=> (string) $groupnames_ary[$group_id]
				);
			}
		}
	}
//die(print_r($sql_ary));
	$db->sql_multi_insert($db_prefix . '_moderator_cache', $sql_ary);
}
function move_topics($topic_ids, $forum_id, $auto_sync = true)
{
	global $db, $db_prefix;

	if (empty($topic_ids))
	{
		return;
	}

	$forum_ids = array($forum_id);

	if (!is_array($topic_ids))
	{
		$topic_ids = array($topic_ids);
	}

	$sql = 'DELETE FROM ' . $db_prefix . '_topics
		WHERE ' . $db->sql_in_set('topic_moved_id', $topic_ids) . '
			AND forum_id = ' . $forum_id;
	$db->sql_query($sql);

	if ($auto_sync)
	{
		$sql = 'SELECT DISTINCT forum_id
			FROM ' . $db_prefix . '_topics
			WHERE ' . $db->sql_in_set('topic_id', $topic_ids);
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$forum_ids[] = $row['forum_id'];
		}
		$db->sql_freeresult($result);
	}

	$table_ary = array($db_prefix . '_topics', $db_prefix . '_posts', $db_prefix . '_log', $db_prefix . '_drafts', $db_prefix . '_topics_track');
	foreach ($table_ary as $table)
	{
		$sql = "UPDATE $table
			SET forum_id = $forum_id
			WHERE " . $db->sql_in_set('topic_id', $topic_ids);
		$db->sql_query($sql);
	}
	unset($table_ary);

	if ($auto_sync)
	{
		sync('forum', 'forum_id', $forum_ids, true, true);
		unset($forum_ids);
	}
}
function validateURL($url)
{
    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
    $regex .= "([a-z0-9-.]*)\.([a-z0-9]{2,3})"; // Host or IP
    $regex .= "(\:[0-9])?"; // Port
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
	if(preg_match("/^$regex$/", $url)) 
	{ 
		return true;
	} 
	else
	{
		return false;
	}
}
?>