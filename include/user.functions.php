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
** File user.functions.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
function user_ipwhois($ip)
{
	$ipwhois = '';

	// Check IP
	// Only supporting IPv4 at the moment...
	if (empty($ip) || !preg_match(get_preg_expression('ipv4'), $ip))
	{
		return '';
	}

	if (($fsk = fsockopen('whois.arin.net', 43, $errno, $errstr, 10)))
	{
		// CRLF as per RFC3912
		fputs($fsk, "$ip\r\n");
		while (!feof($fsk))
		{
			$ipwhois .= fgets($fsk, 1024);
		}
		fclose($fsk);
	}

	$match = array();

	// Test for referrals from ARIN to other whois databases, roll on rwhois
	if (preg_match('#ReferralServer: whois://(.+)#im', $ipwhois, $match))
	{
		if (strpos($match[1], ':') !== false)
		{
			$pos	= strrpos($match[1], ':');
			$server	= substr($match[1], 0, $pos);
			$port	= (int) substr($match[1], $pos + 1);
			unset($pos);
		}
		else
		{
			$server	= $match[1];
			$port	= 43;
		}

		$buffer = '';

		if (($fsk = fsockopen($server, $port)))
		{
			fputs($fsk, "$ip\r\n");
			while (!feof($fsk))
			{
				$buffer .= fgets($fsk, 1024);
			}
			@fclose($fsk);
		}

		// Use the result from ARIN if we don't get any result here
		$ipwhois = (empty($buffer)) ? $ipwhois : $buffer;
	}

	$ipwhois = htmlspecialchars($ipwhois);

	// Magic URL ;)
	return trim(make_clickable($ipwhois, false, ''));
}
/**
* gen_avatar
*
*
* Used to get the users avatar
*/
function avatar_remote($data, &$error)
{
		global $avstore, $avmaxwt, $avmaxht, $avminwt, $avminht, $avstore, $user;
		$upload_ary = array();
		$upload_ary['local_mode'] = true;

		if (!preg_match('#^(http|https|ftp)://#i', $data['remotelink'], $match))
		{
		$data['remotelink'] = 'http://' . $data['remotelink'];
		}
		if (!preg_match('#^(https?://).*?\.(gif|jpg|jpeg|png)$#i', $data['remotelink'], $match))
		{
			 bterror($user->lang['_URL_INVALID']);
		}
		if (empty($match[2]))
		{
			 bterror($user->lang['INVALID_IMAGE_EXT']);
		}
	if (!preg_match('#^(http|https|ftp)://(?:(.*?\.)*?[a-z0-9\-]+?\.[a-z]{2,4}|(?:\d{1,3}\.){3,5}\d{1,3}):?([0-9]*?).*?\.(gif|jpg|jpeg|png)$#i', $data['remotelink']))
	{
		$error[] = $user->lang['AVATAR_URL_INVALID'];
		return false;
	}

	// Make sure getimagesize works...
	if (($image_data = @getimagesize($data['remotelink'])) === false && (empty($data['width']) || empty($data['height'])))
	{
		$error[] = $user->lang['UNABLE_GET_IMAGE_SIZE'];
		return false;
	}

	if (!empty($image_data) && ($image_data[0] < 2 || $image_data[1] < 2))
	{
		$error[] = $user->lang['AVATAR_NO_SIZE'];
		return false;
	}

	$width = ($data['width'] && $data['height']) ? $data['width'] : $image_data[0];
	$height = ($data['width'] && $data['height']) ? $data['height'] : $image_data[1];

	if ($width < 2 || $height < 2)
	{
		$error[] = $user->lang['AVATAR_NO_SIZE'];
		return false;
	}


		$url = parse_url($data['remotelink']);

		$host = $url['host'];
		$path = $url['path'];
		$port = (!empty($url['port'])) ? (int) $url['port'] : 80;

		$upload_ary['type'] = 'application/octet-stream';

		$url['path'] = explode('.', $url['path']);
		$ext = array_pop($url['path']);

		$url['path'] = implode('', $url['path']);
		$upload_ary['name'] = basename($url['path']) . (($ext) ? '.' . $ext : '');
		$filename = $url['path'];
		$filesize = 0;

		$errno = 0;
		$errstr = '';

		if (!($fsock = @fsockopen($host, $port, $errno, $errstr)))
		{
			 bterror($user->lang['AVATAR_NOT_UPLOADED']);
		}

		// Make sure $path not beginning with /
		if (strpos($path, '/') === 0)
		{
			$path = substr($path, 1);
		}

		fputs($fsock, 'GET /' . $path . " HTTP/1.1\r\n");
		fputs($fsock, "HOST: " . $host . "\r\n");
		fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		$img_data = '';
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$img_data .= @fread($fsock, 1024);
			}
			else
			{
				$line = @fgets($fsock, 1024);

				if ($line == "\r\n")
				{
					$get_info = true;
				}
				else
				{
					if (stripos($line, 'content-type: ') !== false)
					{
						$upload_ary['type'] = rtrim(str_replace('content-type: ', '', strtolower($line)));
					}
					else if (stripos($line, '404 not found') !== false)
					{
			 bterror($user->lang['_URL_NOT_FOUND']);
					}
				}
			}
		}
		@fclose($fsock);

		if (empty($img_data))
		{
			 bterror($user->lang['INVALID_REMOTE_DATA']);
		}

		$filename = $data['upload_name'] . '.' .$match[2];

		if (!($fp = @fopen("cache/".$filename, 'wb')))
		{
			 bterror($user->lang['AVATAR_NOT_UPLOADED']);
		}

		$upload_ary['size'] = fwrite($fp, $img_data);
		fclose($fp);
		unset($img_data);

                                $imageinfo = getimagesize("cache/".$filename);
                                $width = $imageinfo[0];
                                $height = $imageinfo[1];
                                if ($width > $avmaxwt OR $height > $avmaxht) {
                                        $errors[] = $user->lang['INVALID_SIZE'];
                                        unlink($filename);
                                } elseif ($width < $avminwt OR $height < $avminht) {
                                        $errors[] = "Image is to small";
                                        unlink($filename);
                                }else{
                                        $newfname = preg_replace("/^([^\\\\:\/<>|*\"?])*\\.(gif|jpg|jpeg|png)$/si", $data['upload_name'].".\\2", $filename);
                                        //Deleting any previous images
										//rmdir($data['upload_dir'] . '/' . $data['user_id']);
										if(!is_dir($data['upload_dir'] . '/' . $data['user_id']))
										{
											 $oldumask = umask(0);
											 @mkdir($data['upload_dir'] . '/' . $data['user_id'],01777);
											 umask($oldumask);
										}

                                        $fhandle = opendir($data['upload_dir'] . '/' . $data['user_id']);
                                        while ($file = readdir($fhandle)) {
                                                if (preg_match("/^".$data['upload_name']."\.(gif|jpg|jpeg|png)$/si",$file)) @unlink($data['upload_dir'] . '/' . $data['user_id'] . '/' . $filename);
                                        }
                                        closedir($fhandle);
                                        copy("cache/".$filename,$data['upload_dir'] . '/' . $data['user_id']."/".$newfname);
                                        unlink("cache/".$filename);
                                }
	return array(1, $newfname, $width, $height);
}
function user_update_name($old_name, $new_name)
{
	global $config, $db, $db_prefix, $template;

	$update_ary = array(
		$db_prefix . '_forums'				=> array('forum_last_poster_name'),
		$db_prefix . '_moderator_cache'		=> array('username'),
		$db_prefix . '_posts'				=> array('post_username'),
		$db_prefix . '_topics'				=> array('topic_first_poster_name', 'topic_last_poster_name'),
	);

	foreach ($update_ary as $table => $field_ary)
	{
		foreach ($field_ary as $field)
		{
			$sql = "UPDATE $table
				SET $field = '" . $db->sql_escape($new_name) . "'
				WHERE $field = '" . $db->sql_escape($old_name) . "'";
			$db->sql_query($sql);
		}
	}


	// Because some tables/caches use username-specific data we need to purge this here.
	$template->destroy('sql', $db_prefix . '_moderator_cache');
}
function group_memberships($group_id_ary = false, $user_id_ary = false, $return_bool = false)
{
	global $db, $db_prefix;

	if (!$group_id_ary && !$user_id_ary)
	{
		return true;
	}

	if ($user_id_ary)
	{
		$user_id_ary = (!is_array($user_id_ary)) ? array($user_id_ary) : $user_id_ary;
	}

	if ($group_id_ary)
	{
		$group_id_ary = (!is_array($group_id_ary)) ? array($group_id_ary) : $group_id_ary;
	}

	$sql = 'SELECT ug.*, u.username, u.clean_username, u.email
		FROM ' . $db_prefix . '_user_group ug, ' . $db_prefix . '_users u
		WHERE ug.user_id = u.id
			AND ug.user_pending = 0 AND ';

	if ($group_id_ary)
	{
		$sql .= ' ' . $db->sql_in_set('ug.group_id', $group_id_ary);
	}

	if ($user_id_ary)
	{
		$sql .= ($group_id_ary) ? ' AND ' : ' ';
		$sql .= $db->sql_in_set('ug.user_id', $user_id_ary);
	}

	$result = ($return_bool) ? $db->sql_query($sql . ' LIMT 1') : $db->sql_query($sql) or btsqlerror($sql);

	$row = $db->sql_fetchrow($result);

	if ($return_bool)
	{
		$db->sql_freeresult($result);
		return ($row) ? true : false;
	}

	if (!$row)
	{
		return false;
	}

	$return = array();

	do
	{
		$return[] = $row;
	}
	while ($row = $db->sql_fetchrow($result));

	$db->sql_freeresult($result);

	return $return;
}
function avatar_gallery($category, $avatar_select, $items_per_column, $block_var = 'avatar_row')
{
	global $user, $pmbt_cache, $template, $avgal;
	global $config, $avconfig, $phpbb_root_path;

	$avatar_list = array();

	$path = $phpbb_root_path .  $avconfig['avatar_gallery_path'];
	//die($path);

	if (!file_exists($path) || !is_dir($path))
	{
		$avatar_list = array($user->lang['NO_AVATAR_CATEGORY'] => array());
	}
	else
	{
		// Collect images
		$dp = @opendir($path);

		if (!$dp)
		{
			return array($user->lang['NO_AVATAR_CATEGORY'] => array());
		}

		while (($file = readdir($dp)) !== false)
		{
		//echo $file . '     ';
			if ($file[0] != '.' && preg_match('#^[^&"\'<>]+$#i', $file) && $file != 'user' && is_dir("$path/$file"))
			{
				$avatar_row_count = $avatar_col_count = 0;

				if ($dp2 = @opendir("$path/$file"))
				{
					while (($sub_file = readdir($dp2)) !== false)
					{
						if (preg_match('#^[^&\'"<>]+\.(?:gif|png|jpe?g)$#i', $sub_file) && $sub_file != 'blank.gif')
						{
							$avatar_list[$file][$avatar_row_count][$avatar_col_count] = array(
								'file'		=> rawurlencode($file) . '/' . rawurlencode($sub_file),
								'filename'	=> rawurlencode($sub_file),
								'name'		=> ucfirst(str_replace('_', ' ', preg_replace('#^(.*)\..*$#', '\1', $sub_file))),
							);
							$avatar_col_count++;
							if ($avatar_col_count == $items_per_column)
							{
								$avatar_row_count++;
								$avatar_col_count = 0;
							}
						}
					}
					closedir($dp2);
				}
			}
		}
		closedir($dp);
	}

	if (!sizeof($avatar_list))
	{
		$avatar_list = array($user->lang['NO_AVATAR_CATEGORY'] => array());
	}

	@ksort($avatar_list);

	$category = (!$category) ? key($avatar_list) : $category;
	$avatar_categories = array_keys($avatar_list);

	$s_category_options = '';
	foreach ($avatar_categories as $cat)
	{
		$s_category_options .= '<option value="' . $cat . '"' . (($cat == $category) ? ' selected="selected"' : '') . '>' . $cat . '</option>';
	}

	$template->assign_vars(array(
		'S_AVATARS_ENABLED'		=> true,
		'S_IN_AVATAR_GALLERY'	=> true,
		'S_CAT_OPTIONS'			=> $s_category_options)
	);

	$avatar_list = (isset($avatar_list[$category])) ? $avatar_list[$category] : array();

	foreach ($avatar_list as $avatar_row_ary)
	{
		$template->assign_block_vars($block_var, array());

		foreach ($avatar_row_ary as $avatar_col_ary)
		{
			$template->assign_block_vars($block_var . '.avatar_column', array(
				'AVATAR_IMAGE'	=> $phpbb_root_path . $avgal . '/' . $avatar_col_ary['file'],
				'AVATAR_NAME'	=> $avatar_col_ary['name'],
				'AVATAR_FILE'	=> $avatar_col_ary['filename'])
			);

			$template->assign_block_vars($block_var . '.avatar_option_column', array(
				'AVATAR_IMAGE'	=> $phpbb_root_path . $avgal . '/' . $avatar_col_ary['file'],
				'S_OPTIONS_AVATAR'	=> $avatar_col_ary['filename'])
			);
		}
	}

	return $avatar_list;
}
function validate_string($string, $optional = false, $min = 0, $max = 0)
{
	if (empty($string) && $optional)
	{
		return false;
	}

	if ($min && utf8_strlen(htmlspecialchars_decode($string)) < $min)
	{
		return 'TOO_SHORT';
	}
	else if ($max && utf8_strlen(htmlspecialchars_decode($string)) > $max)
	{
		return 'TOO_LONG';
	}

	return false;
}
if (!function_exists("gen_avatar")){
function gen_avatar($id, $hight = false, $width = false){
        global $db, $db_prefix, $user, $theme, $avon, $avstore, $siteurl, $avgal;
		if(!$avon)return;
		// Colect Info on the user
			$sql = "SELECT COUNT(id) AS count, `name`, `username`, `avatar`, `avatar_type`, `avatar_ht`, `avatar_wt` FROM ".$db_prefix."_users WHERE `id` = '".$id."' LIMIT 1;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			$noavatar = false;
			if ($row['count'] == 0)
			{
			// Check to find the Default Avatar
			if (is_file("themes/{$theme}/pics/noavatar.gif") AND is_readable("themes/{$theme}/pics/noavatar.gif"))$noavatar = 'noavatar.gif';
			elseif (is_file("themes/{$theme}/pics/noavatar.png") AND is_readable("themes/{$theme}/pics/noavatar.png"))$noavatar = 'noavatar.png';
			elseif (is_file("themes/{$theme}/pics/noavatar.jpg") AND is_readable("themes/{$theme}/pics/noavatar.jpg"))$noavatar = 'noavatar.jpg';
			if($noavatar)return pic($noavatar);
			else return $noavatar;
			}else{
			if ($row["avatar"] == "blank.gif"){
			if (is_file("themes/{$theme}/pics/noavatar.gif") AND is_readable("themes/{$theme}/pics/noavatar.gif"))$noavatar = 'noavatar.gif';
			elseif (is_file("themes/{$theme}/pics/noavatar.png") AND is_readable("themes/{$theme}/pics/noavatar.png"))$noavatar = 'noavatar.png';
			elseif (is_file("themes/{$theme}/pics/noavatar.jpg") AND is_readable("themes/{$theme}/pics/noavatar.jpg"))$noavatar = 'noavatar.jpg';
			if($noavatar)return pic($noavatar);
			else return $noavatar;
			}
			$trueheight = $truewidth = 0;
                                if($row['avatar_type'] == 0)
								{
									$imageinfo = @getimagesize("/".$row["avatar"]);
                                	$truewidth = (isset($imageinfo[0]) ? $imageinfo[0] : 0);
                                	$trueheight = (isset($imageinfo[1]) ? $imageinfo[1] : 0);
								}
			$hight = " height=\"".(($hight)?$hight : $trueheight)."\"";
			$width = " width=\"".(($width)?$width : $truewidth)."\"";
			if($row['avatar_ht'] != "0")$hight = " height=\"".$row['avatar_ht']."px\"";
			if($row['avatar_wt'] != "0")$width = " width=\"".$row['avatar_wt']."px\"";
			if($row['avatar_type'] == 0)return "<img".$hight.$width."  src=\"$siteurl/avatars/".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\" class=\"avatar\">";
			if($row['avatar_type'] == 1)return "<img".$hight.$width." src=\"$siteurl/".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\" class=\"avatar\">";
			if($row['avatar_type'] == 2)return "<img".$hight.$width." src=\"".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\" class=\"avatar\">";
			if($row['avatar_type'] == 3)return "<img".$hight.$width." src=\"./".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\" class=\"avatar\">";
			}
			return $noavatar;
}
}
function checkEmail( $email ){
	if (phpversion() < '5.2.0')
	{
		if(preg_match("/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
    	return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}
}
function group_create(&$group_id, $type, $name, $desc, $group_attributes, $allow_desc_bbcode = false, $allow_desc_urls = false, $allow_desc_smilies = false)
{
	global $config, $db, $db_prefix, $user, $file_upload, $avmaxwt, $avmaxht, $avminwt, $avminht, $avgal;

	$error = array();

	// Attributes which also affect the users table
	$user_attribute_ary = array('group_colour', 'group_rank', 'group_avatar', 'group_avatar_type', 'group_avatar_width', 'group_avatar_height');

	// Check data. Limit group name length.
	if (!utf8_strlen($name) || utf8_strlen($name) > 60)
	{
		$error[] = (!utf8_strlen($name)) ? $user->lang['GROUP_ERR_USERNAME'] : $user->lang['GROUP_ERR_USER_LONG'];
	}

	$err = group_validate_groupname($group_id, $name);
	if (!empty($err))
	{
		$error[] = $user->lang[$err];
	}

	if (!in_array($type, array(0, 1, 2, 3, 4)))
	{
		$error[] = $user->lang['GROUP_ERR_TYPE'];
	}

	if (!sizeof($error))
	{
		$user_ary = array();
		$sql_ary = array(
			'group_name'			=> (string) $name,
			'group_desc'			=> (string) $desc,
			'group_desc_uid'		=> '',
			'group_desc_bitfield'	=> '',
			'group_type'			=> (int) $type,
		);

		// Parse description
		if ($desc)
		{
			generate_text_for_storage($sql_ary['group_desc'], $sql_ary['group_desc_uid'], $sql_ary['group_desc_bitfield'], $sql_ary['group_desc_options'], $allow_desc_bbcode, $allow_desc_urls, $allow_desc_smilies);
		}

		if (sizeof($group_attributes))
		{
			// Merge them with $sql_ary to properly update the group
			$sql_ary = array_merge($sql_ary, $group_attributes);
		}

		// Setting the log message before we set the group id (if group gets added)
		$log = ($group_id) ? 'LOG_GROUP_UPDATED' : 'LOG_GROUP_CREATED';

		$query = '';
		if ($group_id)
		{
			$sql = 'SELECT id
				FROM ' . $db_prefix . '_users
				WHERE can_do = ' . $group_id;
			$result = $db->sql_query($sql) or btsqlerror($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$user_ary[] = $row['id'];
			}
			$db->sql_freeresult($result);


			if (isset($sql_ary['group_rank']) && !$sql_ary['group_rank'])
			{
				remove_default_rank($group_id, $user_ary);
			}


			$sql = 'UPDATE ' . $db_prefix . '_level_settings
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
				WHERE group_id = $group_id";
			$db->sql_query($sql) or btsqlerror($sql);

		}
		else
		{
			$sql = 'INSERT INTO ' . $db_prefix . '_level_settings ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql) or btsqlerror($sql);
		}
		if (!$group_id OR $group_id == 0)
		{
			$sql = 'SELECT group_id
				FROM ' . $db_prefix . '_level_settings
				ORDER BY group_id DESC LIMIT 1';
			$result = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			$group_id = $row['group_id'];

			if (isset($sql_ary['group_avatar_type']) && $sql_ary['group_avatar_type'] == 1)
			{
				if (@is_dir('./' . $avgal . '/g0'))
				{
					if (!is_dir('./' . $avgal . "/g" . $group_id))
					{
						@mkdir('./' . $avgal . "/g" . $group_id,01777);
					}
                                        copy('./' . $avgal . '/g0/' . $sql_ary['group_avatar'], './' . $avgal . "/g" . $group_id . "/" . $sql_ary['group_avatar']);
										unlink('./' . $avgal . "/g0/" . $sql_ary['group_avatar']);
										rmdir('./' . $avgal . '/g0');
				}
					$sql = 'UPDATE ' . $db_prefix . '_level_settings
						SET group_avatar = \'' . $db->sql_escape($avgal . "/g" . $group_id . "/" . $sql_ary['group_avatar']) . "'
						WHERE group_id = $group_id";
					$db->sql_query($sql) or btsqlerror($sql);
			}
		}
		if (sizeof($sql_ary) && sizeof($user_ary))
		{
			group_set_user_default($group_id, $user_ary, $sql_ary);
		}

		$name = ($type == 3) ? $user->lang['G_' . $name] : $name;
		//add_log('admin', $log, $name);
	}

	return (sizeof($error)) ? $error : false;
}

/**
* Changes a group avatar's filename to conform to the naming scheme
*/
function group_correct_avatar($group_id, $old_entry)
{
	global $db, $db_prefix, $avstore;

	$group_id		= (int)$group_id;
	$ext 			= substr(strrchr($old_entry, '.'), 1);
	$old_filename 	= get_avatar_filename($old_entry);
	$new_filename 	= "_g$group_id.$ext";
	$new_entry 		= 'g' . $group_id . '_' . substr(time(), -5) . ".$ext";

	$avatar_path = $phpbb_root_path . $avstore;
	if (@rename($avatar_path . '/'. $old_filename, $avatar_path . '/' . $new_filename))
	{
		$sql = 'UPDATE ' . $db_prefix . '_level_settings
			SET group_avatar = \'' . $db->sql_escape($new_entry) . "'
			WHERE group_id = $group_id";
		$db->sql_query($sql) or btsqlerror($sql);
	}
}

function get_group_avatar($avatar, $avatar_type, $avatar_width, $avatar_height, $alt = 'USER_AVATAR', $ignore_config = false)
{
	global $user, $config, $avon, $avgalon, $avremoteon, $avgal, $avuploadon, $db_prefix;

	if (empty($avatar) || !$avatar_type || (!$avon && !$ignore_config))
	{
		return '';
	}

	$avatar_img = '';

	switch ($avatar_type)
	{
		case 1:
			if (!$avuploadon && !$ignore_config)
			{
				return '';
			}
			$avatar_img = './' . $avgal;
		break;

		case 3:
			if (!$avgalon && !$ignore_config)
			{
				return '';
			}
			$avatar_img = './' . $avgal . '/';
		break;

		case 2:
			if (!$avremoteupon && !$ignore_config)
			{
				return '';
			}
		break;
	}

	$avatar_img .= $avatar;
	return '<img src="' . (str_replace(' ', '%20', $avatar_img)) . '" width="' . $avatar_width . '" height="' . $avatar_height . '" alt="' . ((!empty($user->lang[$alt])) ? $user->lang[$alt] : $alt) . '" />';
}
function get_avatar_filename($avatar_entry)
{


	if ($avatar_entry[0] === 'g')
	{
		$avatar_group = true;
		$avatar_entry = substr($avatar_entry, 1);
	}
	else
	{
		$avatar_group = false;
	}
	$ext 			= substr(strrchr($avatar_entry, '.'), 1);
	$avatar_entry	= intval($avatar_entry);
	return (($avatar_group) ? 'g' : '') . $avatar_entry . '.' . $ext;
}


if (!function_exists("getuser")){
function getuser($name){
        global $db, $db_prefix;
            $sql = "SELECT
			`id`
			FROM ".$db_prefix."_users
			WHERE username ='".$db->sql_escape($name)."'
			OR name = '".$db->sql_escape($name)."'
			OR clean_username = '".$db->sql_escape(strtolower($name))."'";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "0";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['id'];
			}
}
}
if (!function_exists("username_is")){
function username_is($id)
{
        global $db, $db_prefix;
			$sql = "SELECT COUNT(id) AS count, `username` FROM ".$db_prefix."_users WHERE `id` = '".$id."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
            if ($row['count'] == 0) return "Guest";
			else{
		    return $row['username'];
			}

}
}
if (!function_exists("getlevel")){
function getlevel($userid){
        global $db, $db_prefix;
			$sql = "SELECT `can_do` FROM ".$db_prefix."_users WHERE `id` = '".$userid."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "guest";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['can_do'];
			}
}
}
if (!function_exists("getusercolor")){
function getusercolor($level){
        global $db, $db_prefix;
			$sql = "SELECT group_colour FROM ".$db_prefix."_level_settings WHERE `group_id` = '".$level."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
		return '#' . $row['group_colour'];
}
}
if (!function_exists("get_user_timezone")){
function get_user_timezone($id) {
        global $db, $db_prefix, $user;
  if ($user->user){
	   $sql = "SELECT * FROM ".$db_prefix."_users WHERE id='" . $id . "' LIMIT 1";
       $query = $db->sql_query($sql) or btsqlerror($sql);
       if ($db->sql_numrows($query) != "0") {
			$kasutaja = $db->sql_fetchrow($query);
			$timezone = $kasutaja["tzoffset"]+60;
			return $timezone;
		} else {
         return "377";
		} //Default timezone
	}
}
}
if (!function_exists("processinput")){
function processinput($name,&$input) {
        global $sqlfields, $sqlvalues;
        if (!get_magic_quotes_gpc()) $input = addslashes($input);
        $sqlfields[] = $name;
        $sqlvalues[] = ($input != "NULL") ? "'".$input."'" : "NULL";
}
}
if (!function_exists("processload")){
function processload($name,$input) {
        global $sqlfields, $sqlvalues;
        $sqlfields[] = $name;
        $sqlvalues[] = ($input != 0) ? "".$input."" : 0;
}
}
if (!function_exists("tz_select")){
	function tz_select($default = '', $userrow = '', $truncate = false)
	{
		global $user;
		$tz_select = '';
		foreach ($user->lang['tz_zones'] as $offset => $zone)
		{
			if ($truncate)
			{
				if (!function_exists("truncate_string"))
				{
					include('include/function_posting.php');
				}
				$zone_trunc = truncate_string($zone, 50, 255, false, '...');
			}
			else
			{
				$zone_trunc = $zone;
			}

			if (is_numeric($offset))
			{
				$selected = ($offset == $userrow["tzoffset"]) ? ' selected="selected"' : '';
				$tz_select .= '<option title="' . $zone . '" value="' . $offset . '"' . $selected . '>' . $zone_trunc . '</option>';
			}
		}
	return $tz_select;
	}
}
if (!function_exists("cnt_select")){
	function cnt_select($countries = '', $userrow = array("country" =>0,))
	{
	        global $db, $db_prefix;
		$sql = ("SELECT id,name from ".$db_prefix."_countries ORDER BY name");
		$ct_r = $db->sql_query($sql) or btsqlerror($sql);
		while ($ct_a = $db->sql_fetchrow($ct_r))
		  $countries .= "<option value=" . $ct_a['id'] . "" . ($userrow["country"] == $ct_a['id'] ? " selected" : "") . ">" . $ct_a['name'] . "</option>\n";
	return $countries;
	}
}
if (!function_exists("confirm_box")){
function confirm_box($check, $title = '', $hidden = '', $html_body = 'confirm_body.html', $u_action = '')
{
	global $user, $template, $db;

	if (isset($_POST['cancel']))
	{
		return false;
	}

	$confirm = false;
	if (isset($_POST['confirm']))
	{
		// language frontier
		if ($_POST['confirm'] === 'YES')
		{
			$confirm = true;
		}
	}

	if ($check && $confirm)
	{
		$user_id = request_var('user_id', 0);
		$session_id = request_var('sess', '');
		$confirm_key = request_var('confirm_key', '');

		if ($user_id != $user->id ||  !$confirm_key )
		{
			return false;
		}

		return true;
	}
	else if ($check)
	{
		return false;
	}

	$s_hidden_fields = build_hidden_fields(array(
		'user_id'	=> $user->id,
		'sess'		=> $user->session_id,
		'sid'		=> $user->session_id)
	);

	// generate activation key
	$confirm_key = RandomAlpha(10);


	// If activation key already exist, we better do not re-use the key (something very strange is going on...)
	if (request_var('confirm_key', ''))
	{
		// This should not occur, therefore we cancel the operation to safe the user
		return false;
	}

	$u_action .= ((strpos($u_action, '?') === false) ? '?' : '&amp;') . 'confirm_key=' . $confirm_key;
	$template->assign_vars(array(
		'MESSAGE_TITLE'		=> (defined('_'.$title)) ? constant('_'.$title) : 'CONFIRM',
		'MESSAGE_TEXT'		=> (defined('_'.$title.'_CONFIRM')) ? constant('_'.$title.'_CONFIRM') : '_CONFIRM',

		'YES_VALUE'			=> 'YES',
		'S_CONFIRM_ACTION'	=> $u_action,
		'S_HIDDEN_FIELDS'	=> $hidden . $s_hidden_fields)
	);
			  echo $template->fetch('confirm_body.html');
			  die;
}
}

function get_folder($user_id, $folder_id = false)
{
	global $db, $user, $template, $db_prefix;


	$folder = array();

	// Get folder information
	$sql = 'SELECT folder_id, COUNT(msg_id) as num_messages, SUM(pm_unread) as num_unread
		FROM ' . $db_prefix . '_privmsgs_to
		WHERE user_id = ' . $user_id . '
			AND folder_id <> -3
		GROUP BY folder_id';
	$result = $db->sql_query($sql) or btsqlerror($sql);

	$num_messages = $num_unread = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$num_messages[(int) $row['folder_id']] = $row['num_messages'];
		$num_unread[(int) $row['folder_id']] = $row['num_unread'];
	}
	$db->sql_freeresult($result);

	// Make sure the default boxes are defined
	$available_folder = array(0, -2, -1);

	foreach ($available_folder as $default_folder)
	{
		if (!isset($num_messages[$default_folder]))
		{
			$num_messages[$default_folder] = 0;
		}

		if (!isset($num_unread[$default_folder]))
		{
			$num_unread[$default_folder] = 0;
		}
	}

	// Adjust unread status for outbox
	$num_unread[-2] = $num_messages[-2];

	$folder[0] = array(
		'folder_name'		=> $user->lang['_PM_INBOX'],
		'num_messages'		=> $num_messages[0],
		'unread_messages'	=> $num_unread[0]
	);

	// Custom Folder
	$sql = 'SELECT folder_id, folder_name, pm_count
		FROM ' . $db_prefix . "_privmsgs_folder
			WHERE user_id = $user_id";
	$result = $db->sql_query($sql) or btsqlerror($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$folder[$row['folder_id']] = array(
			'folder_name'		=> $row['folder_name'],
			'num_messages'		=> $row['pm_count'],
			'unread_messages'	=> ((isset($num_unread[$row['folder_id']])) ? $num_unread[$row['folder_id']] : 0)
		);
	}
	$db->sql_freeresult($result);

	$folder[-2] = array(
		'folder_name'		=> $user->lang['_PM_OUTBOX'],
		'num_messages'		=> $num_messages[-2],
		'unread_messages'	=> $num_unread[-2]
	);

	$folder[-1] = array(
		'folder_name'		=> $user->lang['_PM_SENTBOX'],
		'num_messages'		=> $num_messages[-1],
		'unread_messages'	=> $num_unread[-1]
	);

	// Define Folder Array for template designers (and for making custom folders usable by the template too)
	foreach ($folder as $f_id => $folder_ary)
	{
		$folder_id_name = ($f_id == 0) ? 'inbox' : (($f_id == -2) ? 'outbox' : 'sentbox');

		$template->assign_block_vars('folder', array(
			'FOLDER_ID'			=> $f_id,
			'FOLDER_NAME'		=> $folder_ary['folder_name'],
			'NUM_MESSAGES'		=> $folder_ary['num_messages'],
			'UNREAD_MESSAGES'	=> $folder_ary['unread_messages'],

			'U_FOLDER'			=> ($f_id) ? './pm.php?op=folder&amp;i=' . $f_id : './pm.php?op=folder&amp;i=' . $folder_id_name,

			'S_CUR_FOLDER'		=> ($f_id === $folder_id) ? true : false,
			'S_UNREAD_MESSAGES'	=> ($folder_ary['unread_messages']) ? true : false,
			'S_CUSTOM_FOLDER'	=> ($f_id > 0) ? true : false)
		);
	}

	if ($folder_id !== false && !isset($folder[$folder_id]))
	{
		trigger_error('UNKNOWN_FOLDER');
	}

	return $folder;
}
function message_options($id, $mode, $global_privmsgs_rules, $global_rule_conditions)
{
	global  $user, $template, $auth, $config, $db, $db_prefix;

	$redirect_url = "./pm.php?op=options";

	add_form_key('ucp_pm_options');
	// Change "full folder" setting - what to do if folder is full
	if (isset($_POST['fullfolder']))
	{
		check_form_key('ucp_pm_options', $config['form_token_lifetime'], $redirect_url);
		$full_action = request_var('full_action', 0);

		$set_folder_id = 0;
		switch ($full_action)
		{
			case 1:
				$set_folder_id = -2;
			break;

			case 2:
				$set_folder_id = request_var('full_move_to', 0);
			break;

			case 3:
				$set_folder_id = -1;
			break;

			default:
				$full_action = 0;
			break;
		}

		if ($full_action)
		{
			$sql = 'UPDATE ' . $db_prefix . '_users
				SET user_full_folder = ' . $set_folder_id . '
				WHERE id = ' . $user->id;
			$db->sql_query($sql) or btsqlerror($sql);

			$user->data['user_full_folder'] = $set_folder_id;

			$message = $user->lang['_FULL_FOLDER_OPTION_CHANGED'] . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $redirect_url . '">', '</a>');
			meta_refresh(3, $redirect_url);
		trigger_error($message);
		}
	}

	// Add Folder
	if (isset($_POST['addfolder']))
	{
		if (check_form_key('ucp_pm_options'))
		{
			$folder_name = request_var('foldername', '', true);
			$msg = '';

			if ($folder_name)
			{
				$sql = 'SELECT folder_name
					FROM ' . $db_prefix . "_privmsgs_folder
					WHERE folder_name = '" . $db->sql_escape($folder_name) . "'
						AND user_id = " . $user->id;
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ($row)
				{
$template->assign_vars(array(
		'ERROR_MESSAGE' => sprintf($user->lang['_FOLDER_NAME_EXIST'], $folder_name),
	));
					trigger_error(sprintf($user->lang['_FOLDER_NAME_EXIST'], $folder_name));
				}

				$sql = 'SELECT COUNT(folder_id) as num_folder
					FROM ' . $db_prefix . '_privmsgs_folder
						WHERE user_id = ' . $user->id;
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$num_folder = (int) $db->sql_fetchfield('num_folder');
				$db->sql_freeresult($result);

				if ($num_folder >= 11)
				{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'MAX_FOLDER_REACHED',
	));
					trigger_error('MAX_FOLDER_REACHED');
				}

				$sql = 'INSERT INTO ' . $db_prefix . '_privmsgs_folder ' . $db->sql_build_array('INSERT', array(
					'user_id'		=> (int) $user->id,
					'folder_name'	=> $folder_name)
				);
				$db->sql_query($sql) or btsqlerror($sql);
				$msg = $user->lang['_FOLDER_ADDED'];
			}
			else
			{
				$msg = $user->lang['_FOLDER_NAME_EMPTY'];
			}
		}
		else
		{
			$msg = $user->lang['_FORM_INVALID'];
		}
		$message = $msg . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $redirect_url . '">', '</a>');
		meta_refresh(3, $redirect_url);
		trigger_error($message);
	}

	// Rename folder
	if (isset($_POST['rename_folder']))
	{
		if (check_form_key('ucp_pm_options'))
		{
			$new_folder_name = request_var('new_folder_name', '', true);
			$rename_folder_id= request_var('rename_folder_id', 0);

			if (!$new_folder_name)
			{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'NO_NEW_FOLDER_NAME',
	));
				trigger_error('NO_NEW_FOLDER_NAME');
			}

			// Select custom folder
			$sql = 'SELECT folder_name, pm_count
				FROM ' . $db_prefix . "_privmsgs_folder
				WHERE user_id = {$user->id}
					AND folder_id = $rename_folder_id LIMIT 1";
			$result = $db->sql_query($sql) or btsqlerror($sql);
			$folder_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$folder_row)
			{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'CANNOT_RENAME_FOLDER',
	));
				trigger_error('CANNOT_RENAME_FOLDER');
			}

			$sql = 'UPDATE ' . $db_prefix . "_privmsgs_folder
				SET folder_name = '" . $db->sql_escape($new_folder_name) . "'
				WHERE folder_id = $rename_folder_id
					AND user_id = {$user->id}";
			$db->sql_query($sql) or btsqlerror($sql);
			$msg = $user->lang['_FOLDER_RENAMED'];
		}
		else
		{
			$msg = $user->lang['_FORM_INVALID'];
		}

		$message = $msg . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $redirect_url . '">', '</a>');

		meta_refresh(3, $redirect_url);
		trigger_error($message);
	}

	// Remove Folder
	if (isset($_POST['remove_folder']))
	{
		$remove_folder_id = request_var('remove_folder_id', '');

		// Default to "move all messages to inbox"
		$remove_action = request_var('remove_action', 1);
		$move_to = request_var('move_to', '');

		// Move to same folder?
		if ($remove_action == 1 && $remove_folder_id == $move_to)
		{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'CANNOT_MOVE_TO_SAME_FOLDER',
	));
			trigger_error('CANNOT_MOVE_TO_SAME_FOLDER');
		}

		// Select custom folder
		$sql = 'SELECT folder_name, pm_count
			FROM ' . $db_prefix . "_privmsgs_folder
			WHERE user_id = {$user->id}
				AND folder_id = $remove_folder_id LIMIT 1";
		$result = $db->sql_query($sql) or btsqlerror($sql);
		$folder_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$folder_row)
		{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'CANNOT_REMOVE_FOLDER',
	));
			trigger_error('CANNOT_REMOVE_FOLDER');
		}

		$s_hidden_fields = array(
			'remove_folder_id'	=> $remove_folder_id,
			'remove_action'		=> $remove_action,
			'move_to'			=> $move_to,
			'remove_folder'		=> 1
		);

		// Do we need to confirm?
		if (confirm_box(true))
		{
			// Gather message ids
			$sql = 'SELECT msg_id
				FROM ' . $db_prefix . '_privmsgs_to
				WHERE user_id = ' . $user->id . "
					AND folder_id = $remove_folder_id";
					//die($sql);
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$msg_ids = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$msg_ids[] = (int) $row['msg_id'];
			}
			$db->sql_freeresult($result);

			// First of all, copy all messages to another folder... or delete all messages
			switch ($remove_action)
			{
				// Move Messages
				case 1:

					$num_moved = move_pm($user->id, '10000', $msg_ids, $move_to, $remove_folder_id);

					// Something went wrong, only partially moved?
					if ($num_moved != $folder_row['pm_count'])
					{
$template->assign_vars(array(
		'ERROR_MESSAGE' => sprintf($user->lang['_MOVE_PM_ERROR'], $num_moved, $folder_row['pm_count']),
	));
						trigger_error(sprintf($user->lang['_MOVE_PM_ERROR'], $num_moved, $folder_row['pm_count']));
					}
				break;

				// Remove Messages
				case 2:
					//delete_pm($user->id, $msg_ids, $remove_folder_id);
				break;
			}

			// Remove folder
			$sql = 'DELETE FROM ' . $db_prefix . "_privmsgs_folder
				WHERE user_id = {$user->id}
					AND folder_id = $remove_folder_id";
			$db->sql_query($sql) or btsqlerror($sql);

			// Check full folder option. If the removed folder has been specified as destination switch back to inbox
			if ($user->data['user_full_folder'] == $remove_folder_id)
			{
				$sql = 'UPDATE ' . $db_prefix . '_users
					SET user_full_folder = ' . 0 . '
					WHERE id = ' . $user->id;
				$db->sql_query($sql) or btsqlerror($sql);

				$user->data['user_full_folder'] = 0;
			}

			// Now make sure the folder is not used for rules
			// We assign another folder id (the one the messages got moved to) or assign the INBOX (to not have to remove any rule)
			$sql = 'UPDATE ' . $db_prefix . '_private_messages_rules SET rule_folder_id = ';
			$sql .= ($remove_action == 1) ? $move_to : 0;
			$sql .= ' WHERE rule_folder_id = ' . $remove_folder_id;

			$db->sql_query($sql) or btsqlerror($sql);

			$meta_info = "./pm.php?op=$mode";
			$message = $user->lang['_FOLDER_REMOVED'];

			meta_refresh(3, $meta_info);
			$message .= '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $meta_info . '">', '</a>');
		trigger_error($message);
		}
		else
		{
			confirm_box(false, 'REMOVE_FOLDER', build_hidden_fields($s_hidden_fields),'confirm_body.html','pm.php?op=options');
		}
	}

	// Add Rule
	if (isset($_POST['add_rule']))
	{
		if (check_form_key('ucp_pm_options'))
		{
			$check_option	= request_var('check_option', 0);
			$rule_option	= request_var('rule_option', 0);
			$cond_option	= request_var('cond_option', '');
			$action_option	= explode('|', request_var('action_option', ''));
			$rule_string	= ($cond_option != 'none') ? request_var('rule_string', '', true) : '';
			$rule_user_id	= ($cond_option != 'none') ? request_var('rule_user_id', 0) : 0;
			$rule_group_id	= ($cond_option != 'none') ? request_var('rule_group_id', 0) : 0;

			$action = (int) $action_option[0];
			$folder_id = (int) $action_option[1];

			if (!$action || !$check_option || !$rule_option || !$cond_option || ($cond_option != 'none' && !$rule_string))
			{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'RULE_NOT_DEFINED',
	));
				trigger_error('RULE_NOT_DEFINED');
			}

			if (($cond_option == 'user' && !$rule_user_id) || ($cond_option == 'group' && !$rule_group_id))
			{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'RULE_NOT_DEFINED',
	));
				trigger_error('RULE_NOT_DEFINED');
			}

			$rule_ary = array(
				'user_id'			=> $user->id,
				'rule_check'		=> $check_option,
				'rule_connection'	=> $rule_option,
				'rule_string'		=> $rule_string,
				'rule_user_id'		=> $rule_user_id,
				'rule_group_id'		=> $rule_group_id,
				'rule_action'		=> $action,
				'rule_folder_id'	=> $folder_id
			);

			$sql = 'SELECT rule_id
				FROM ' . $db_prefix . '_private_messages_rules
				WHERE ' . $db->sql_build_array('SELECT', $rule_ary);
			$result = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if ($row)
			{
$template->assign_vars(array(
		'ERROR_MESSAGE' => 'RULE_ALREADY_DEFINED',
	));
				trigger_error('RULE_ALREADY_DEFINED');
			}

			$sql = 'INSERT INTO ' . $db_prefix . '_private_messages_rules ' . $db->sql_build_array('INSERT', $rule_ary);
			$db->sql_query($sql)or btsqlerror($sql);
			// Update users message rules
			$sql = 'UPDATE ' . $db_prefix . '_users
				SET user_message_rules = 1
				WHERE id = ' . $user->id;
			$db->sql_query($sql) or btsqlerror($sql);

			$msg = $user->lang['_RULE_ADDED'];
		}
		else
		{
			$msg = $user->lang['_FORM_INVALID'];
		}

		$message = $msg . '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $redirect_url . '">', '</a>');
		meta_refresh(3, $redirect_url);
		trigger_error($message);
	}

	// Remove Rule
	if (isset($_POST['delete_rule']) && !isset($_POST['cancel']))
	{
		$delete_id = array_keys(request_var('delete_rule', array(0 => 0)));
		$delete_id = (!empty($delete_id[0])) ? $delete_id[0] : 0;

		if (!$delete_id)
		{
			redirect('pm.php?op=' . $mode);
		}

		// Do we need to confirm?
		if (confirm_box(true))
		{
			$sql = 'DELETE FROM ' . $db_prefix . '_private_messages_rules
				WHERE user_id = ' . $user->id . "
					AND rule_id = $delete_id";
			$db->sql_query($sql) or btsqlerror($sql);

			$meta_info = 'pm.php?op=' . $mode;
			$message = $user->lang['_RULE_DELETED'];

			// Reset user_message_rules if no more assigned
			$sql = 'SELECT rule_id
				FROM ' . $db_prefix . '_private_messages_rules
				WHERE user_id = ' . $user->id . ' LIMIT 1';
			$result = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			// Update users message rules
			if (!$row)
			{
				$sql = 'UPDATE ' . $db_prefix . '_users
					SET user_message_rules = 0
					WHERE id = ' . $user->id;
				$db->sql_query($sql) or btsqlerror($sql);
			}

			meta_refresh(3, $meta_info);
			$message .= '<br /><br />' . sprintf($user->lang['_RETURN_UCP'], '<a href="' . $meta_info . '">', '</a>');
			trigger_error($message);
		}
		else
		{
			confirm_box(false, '_DELETE_RULE', build_hidden_fields(array('delete_rule' => array($delete_id => 1))),'confirm_body.html','pm.php?op=options');
		}
	}

	$folder = array();

	$sql = 'SELECT COUNT(msg_id) as num_messages
		FROM ' . $db_prefix . '_privmsgs_to
		WHERE user_id = ' . $user->id . '
			AND folder_id = ' . 0;
	$result = $db->sql_query($sql) or btsqlerror($sql);
	$num_messages = (int) $db->sql_fetchfield('num_messages');
	$db->sql_freeresult($result);

	$folder[0] = array(
		'folder_name'		=> $user->lang['_PM_INBOX'],
		'message_status'	=> sprintf($user->lang['_FOLDER_MESSAGE_STATUS'], $num_messages, $user->data['message_limit'])
	);

	$sql = 'SELECT folder_id, folder_name, pm_count
		FROM ' . $db_prefix . '_privmsgs_folder
			WHERE user_id = ' . $user->id;
	$result = $db->sql_query($sql) or btsqlerror($sql);

	$num_user_folder = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		$num_user_folder++;
		$folder[$row['folder_id']] = array(
			'folder_name'		=> $row['folder_name'],
			'message_status'	=> sprintf($user->lang['_FOLDER_MESSAGE_STATUS'], $row['pm_count'], $user->data['message_limit'])
		);
	}
	$db->sql_freeresult($result);

	$s_full_folder_options = $s_to_folder_options = $s_folder_options = '';

	if ($user->data['user_full_folder'] == -3)
	{
		// -3 here to let the correct folder id be selected
		$to_folder_id = $config['full_folder_action'] - 3;
	}
	else
	{
		$to_folder_id = $user->data['user_full_folder'];
	}

	foreach ($folder as $folder_id => $folder_ary)
	{
		$s_full_folder_options .= '<option value="' . $folder_id . '"' . (($user->data['user_full_folder'] == $folder_id) ? ' selected="selected"' : '') . '>' . $folder_ary['folder_name'] . ' (' . $folder_ary['message_status'] . ')</option>';
		$s_to_folder_options .= '<option value="' . $folder_id . '"' . (($to_folder_id == $folder_id) ? ' selected="selected"' : '') . '>' . $folder_ary['folder_name'] . ' (' . $folder_ary['message_status'] . ')</option>';

		if ($folder_id != 0)
		{
			$s_folder_options .= '<option value="' . $folder_id . '">' . $folder_ary['folder_name'] . ' (' . $folder_ary['message_status'] . ')</option>';
		}
	}

	$s_delete_checked = ($user->data['user_full_folder'] == -2) ? ' checked="checked"' : '';
	$s_hold_checked = ($user->data['user_full_folder'] == -1) ? ' checked="checked"' : '';
	$s_move_checked = ($user->data['user_full_folder'] >= 0) ? ' checked="checked"' : '';

	if ($user->data['user_full_folder'] == -3)
	{
		switch ($config['full_folder_action'])
		{
			case 1:
				$s_delete_checked = ' checked="checked"';
			break;

			case 2:
				$s_hold_checked = ' checked="checked"';
			break;
		}
	}

	$template->assign_vars(array(
		'S_FULL_FOLDER_OPTIONS'	=> $s_full_folder_options,
		'S_TO_FOLDER_OPTIONS'	=> $s_to_folder_options,
		'S_FOLDER_OPTIONS'		=> $s_folder_options,
		'S_DELETE_CHECKED'		=> $s_delete_checked,
		'S_HOLD_CHECKED'		=> $s_hold_checked,
		'S_MOVE_CHECKED'		=> $s_move_checked,
		'S_MAX_FOLDER_REACHED'	=>  false,
		'S_MAX_FOLDER_ZERO'		=> false,

		'DEFAULT_ACTION'		=> ($config['full_folder_action'] == 1) ? $user->lang['_DELETE_OLDEST_MESSAGES'] : $user->lang['_HOLD_NEW_MESSAGES'],

		'U_FIND_USERNAME'		=> './memberslist.php',
	));

	$rule_lang = $action_lang = $check_lang = array();

	// Build all three language arrays
	preg_replace_callback('#^((RULE|ACTION|CHECK)_([A-Z0-9_]+))$#', function ($match) use(&$rule_lang, &$action_lang, &$check_lang, $user) {
		${strtolower($match[2]) . '_lang'}[constant($match[1])] = $user->lang['PM_' . $match[2]][$match[3]];
	}, array_keys(get_defined_constants()));

	/*
		Rule Ordering:
			-> CHECK_* -> RULE_* [IN $global_privmsgs_rules:CHECK_*] -> [IF $rule_conditions[RULE_*] [|text|bool|user|group|own_group]] -> ACTION_*
	*/

	$check_option	= request_var('check_option', 0);
	$rule_option	= request_var('rule_option', 0);
	$cond_option	= request_var('cond_option', '');
	$action_option	= request_var('action_option', '');
	$back = (isset($_REQUEST['back'])) ? request_var('back', array('')) : array();

	if (sizeof($back))
	{
		if ($action_option)
		{
			$action_option = '';
		}
		else if ($cond_option)
		{
			$cond_option = '';
		}
		else if ($rule_option)
		{
			$rule_option = 0;
		}
		else if ($check_option)
		{
			$check_option = 0;
		}
	}

	if (isset($back['action']) && $cond_option == 'none')
	{
		$back['cond'] = true;
	}

	// Check
	if (!isset($global_privmsgs_rules[$check_option]))
	{
		$check_option = 0;
	}

	define_check_option(($check_option && !isset($back['rule'])) ? true : false, $check_option, $check_lang);
	if ($check_option && !isset($back['rule']))
	{
		define_rule_option(($rule_option && !isset($back['cond'])) ? true : false, $rule_option, $rule_lang, $global_privmsgs_rules[$check_option]);
	}
//die('test');

	if ($rule_option && !isset($back['cond']))
	{
		if (!isset($global_rule_conditions[$rule_option]))
		{
			$cond_option = 'none';
			$template->assign_var('NONE_CONDITION', true);
		}
		else
		{
			define_cond_option(($cond_option && !isset($back['action'])) ? true : false, $cond_option, $rule_option, $global_rule_conditions);
		}
	}

	if ($cond_option && !isset($back['action']))
	{
		define_action_option(false, $action_option, $action_lang, $folder);
	}

	show_defined_rules($user->id, $check_lang, $rule_lang, $action_lang, $folder);
}

/**
* Defining check option for message rules
*/
function define_check_option($hardcoded, $check_option, $check_lang)
{
	global $template;

	$s_check_options = '';
	if (!$hardcoded)
	{
		foreach ($check_lang as $value => $lang)
		{
			$s_check_options .= '<option value="' . $value . '"' . (($value == $check_option) ? ' selected="selected"' : '') . '>' . $lang . '</option>';
		}
	}

	$template->assign_vars(array(
		'S_CHECK_DEFINED'	=> true,
		'S_CHECK_SELECT'	=> ($hardcoded) ? false : true,
		'CHECK_CURRENT'		=> isset($check_lang[$check_option]) ? $check_lang[$check_option] : '',
		'S_CHECK_OPTIONS'	=> $s_check_options,
		'CHECK_OPTION'		=> $check_option)
	);
}

/**
* Defining action option for message rules
*/
function define_action_option($hardcoded, $action_option, $action_lang, $folder)
{
	global $db, $template, $user, $db_prefix;

	$l_action = $s_action_options = '';
	if ($hardcoded)
	{
		$option = explode('|', $action_option);
		$action = (int) $option[0];
		$folder_id = (int) $option[1];

		$l_action = $action_lang[$action];
		if ($action == ACTION_PLACE_INTO_FOLDER)
		{
			$l_action .= ' -> ' . $folder[$folder_id]['folder_name'];
		}
	}
	else
	{
		foreach ($action_lang as $action => $lang)
		{
			if ($action == ACTION_PLACE_INTO_FOLDER)
			{
				foreach ($folder as $folder_id => $folder_ary)
				{
					$s_action_options .= '<option value="' . $action . '|' . $folder_id . '"' . (($action_option == $action . '|' . $folder_id) ? ' selected="selected"' : '') . '>' . $lang . ' -> ' . $folder_ary['folder_name'] . '</option>';
				}
			}
			else
			{
				$s_action_options .= '<option value="' . $action . '|0"' . (($action_option == $action . '|0') ? ' selected="selected"' : '') . '>' . $lang . '</option>';
			}
		}
	}

	$template->assign_vars(array(
		'S_ACTION_DEFINED'	=> true,
		'S_ACTION_SELECT'	=> ($hardcoded) ? false : true,
		'ACTION_CURRENT'	=> $l_action,
		'S_ACTION_OPTIONS'	=> $s_action_options,
		'ACTION_OPTION'		=> $action_option)
	);
}

function user_ban($mode, $ban, $ban_len, $ban_len_other, $ban_exclude, $ban_reason, $ban_give_reason = '')
{
	global $db, $db_prefix, $user, $auth, $cache;

	// Delete stale bans
	$sql = 'DELETE FROM ' . $db_prefix . '_bans
		WHERE ban_end < ' . time() . '
			AND ban_end <> 0';
	$db->sql_query($sql);

	$ban_list = (!is_array($ban)) ? array_unique(explode("\n", $ban)) : $ban;
	$ban_list_log = implode(', ', $ban_list);
	//die($ban_list_log);

	$current_time = time();

	// Set $ban_end to the unix time when the ban should end. 0 is a permanent ban.
	if ($ban_len)
	{
		if ($ban_len != -1 || !$ban_len_other)
		{
			$ban_end = max($current_time, $current_time + ($ban_len) * 60);
		}
		else
		{
			$ban_other = explode('-', $ban_len_other);
			if (sizeof($ban_other) == 3 && ((int)$ban_other[0] < 9999) &&
				(strlen($ban_other[0]) == 4) && (strlen($ban_other[1]) == 2) && (strlen($ban_other[2]) == 2))
			{
				$ban_end = max($current_time, gmmktime(0, 0, 0, (int)$ban_other[1], (int)$ban_other[2], (int)$ban_other[0]));
			}
			else
			{
				trigger_error('LENGTH_BAN_INVALID');
			}
		}
	}
	else
	{
		$ban_end = 0;
	}

	$founder = $founder_names = $founder_ip = array();

	if (!$ban_exclude)
	{
		// Create a list of founder...
		$sql = 'SELECT id AS user_id, email AS user_email, clean_username AS username_clean, lastip
			FROM ' . $db_prefix . '_users
			WHERE user_type = 3';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$founder[$row['user_id']] = $row['user_email'];
			$founder_names[$row['user_id']] = $row['username_clean'];
			$founder_ip[$row['user_id']] = long2ip($row['lastip']);
		}
		$db->sql_freeresult($result);
	}

	$banlist_ary = array();

	switch ($mode)
	{
		case 'user':
			$type = 'ban_userid';

			// At the moment we do not support wildcard username banning

			// Select the relevant user_ids.
			$sql_usernames = array();
			foreach ($ban_list as $username)
			{
				$username = trim($username);
				if ($username != '')
				{
					$clean_name = utf8_clean_string($username);
					if ($clean_name == $user->data['clean_username'])
					{
						trigger_error('CANNOT_BAN_YOURSELF', E_USER_WARNING);
					}
					if (in_array($clean_name, $founder_names))
					{
						trigger_error('CANNOT_BAN_FOUNDER', E_USER_WARNING);
					}
					$sql_usernames[] = $clean_name;
				}
			}
			// Make sure we have been given someone to ban
			if (!sizeof($sql_usernames))
			{
				trigger_error('NO_USER_SPECIFIED');
			}

			$sql = 'SELECT id AS user_id
				FROM ' . $db_prefix . '_users
				WHERE ' . $db->sql_in_set('clean_username', $sql_usernames);
			// Do not allow banning yourself
			if (sizeof($founder))
			{
				$sql .= ' AND ' . $db->sql_in_set('id', array_merge(array_keys($founder), array($user->id)), true);
			}
			else
			{
				$sql .= ' AND id <> ' . $user->id;
			}

			$result = $db->sql_query($sql);

			if ($row = $db->sql_fetchrow($result))
			{
				do
				{
					$banlist_ary[] = (int) $row['user_id'];
				}
				while ($row = $db->sql_fetchrow($result));
			}
			else
			{
				$db->sql_freeresult($result);
				trigger_error('NO_USERS');
			}
			$db->sql_freeresult($result);
		break;

		case 'ip':
			$type = 'ipstart';
			#founder and self check
			foreach ($ban_list as $ip)
			{
					if ($ip == getip())
					{
						trigger_error('CANNOT_BAN_YOURSELF', E_USER_WARNING);
					}
					if (in_array($ip, $founder_ip))
					{
						trigger_error('CANNOT_BAN_FOUNDER', E_USER_WARNING);
					}
			}

			foreach ($ban_list as $ban_item)
			{
				if (preg_match('#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})[ ]*\-[ ]*([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#', trim($ban_item), $ip_range_explode))
				{
					// This is an IP range
					// Don't ask about all this, just don't ask ... !
					$ip_1_counter = $ip_range_explode[1];
					$ip_1_end = $ip_range_explode[5];

					while ($ip_1_counter <= $ip_1_end)
					{
						$ip_2_counter = ($ip_1_counter == $ip_range_explode[1]) ? $ip_range_explode[2] : 0;
						$ip_2_end = ($ip_1_counter < $ip_1_end) ? 254 : $ip_range_explode[6];

						if ($ip_2_counter == 0 && $ip_2_end == 254)
						{
							$ip_2_counter = 256;
							$ip_2_fragment = 256;

							$banlist_ary[] = "$ip_1_counter.*";
						}

						while ($ip_2_counter <= $ip_2_end)
						{
							$ip_3_counter = ($ip_2_counter == $ip_range_explode[2] && $ip_1_counter == $ip_range_explode[1]) ? $ip_range_explode[3] : 0;
							$ip_3_end = ($ip_2_counter < $ip_2_end || $ip_1_counter < $ip_1_end) ? 254 : $ip_range_explode[7];

							if ($ip_3_counter == 0 && $ip_3_end == 254)
							{
								$ip_3_counter = 256;
								$ip_3_fragment = 256;

								$banlist_ary[] = "$ip_1_counter.$ip_2_counter.*";
							}

							while ($ip_3_counter <= $ip_3_end)
							{
								$ip_4_counter = ($ip_3_counter == $ip_range_explode[3] && $ip_2_counter == $ip_range_explode[2] && $ip_1_counter == $ip_range_explode[1]) ? $ip_range_explode[4] : 0;
								$ip_4_end = ($ip_3_counter < $ip_3_end || $ip_2_counter < $ip_2_end) ? 254 : $ip_range_explode[8];

								if ($ip_4_counter == 0 && $ip_4_end == 254)
								{
									$ip_4_counter = 256;
									$ip_4_fragment = 256;

									$banlist_ary[] = "$ip_1_counter.$ip_2_counter.$ip_3_counter.*";
								}

								while ($ip_4_counter <= $ip_4_end)
								{
									$banlist_ary[] = "$ip_1_counter.$ip_2_counter.$ip_3_counter.$ip_4_counter";
									$ip_4_counter++;
								}
								$ip_3_counter++;
							}
							$ip_2_counter++;
						}
						$ip_1_counter++;
					}
				}
				else if (preg_match('#^([0-9]{1,3})\.([0-9\*]{1,3})\.([0-9\*]{1,3})\.([0-9\*]{1,3})$#', trim($ban_item)) || preg_match('#^[a-f0-9:]+\*?$#i', trim($ban_item)))
				{
					// Normal IP address
					$banlist_ary[] = trim($ban_item);
				}
				else if (preg_match('#^\*$#', trim($ban_item)))
				{
					// Ban all IPs
					$banlist_ary[] = '*';
				}
				else if (preg_match('#^([\w\-_]\.?){2,}$#is', trim($ban_item)))
				{
					// hostname
					$ip_ary = gethostbynamel(trim($ban_item));

					if (!empty($ip_ary))
					{
						foreach ($ip_ary as $ip)
						{
							if ($ip)
							{
								if (strlen($ip) > 40)
								{
									continue;
								}

								$banlist_ary[] = $ip;
							}
						}
					}
				}
				else
				{
					trigger_error('NO_IPS_DEFINED');
				}
			}
		break;

		case 'email':
			$type = 'ban_email';

			foreach ($ban_list as $ban_item)
			{
				$ban_item = trim($ban_item);

				if (preg_match('#^.*?@*|(([a-z0-9\-]+\.)+([a-z]{2,3}))$#i', $ban_item))
				{
					if (strlen($ban_item) > 100)
					{
						continue;
					}

					if (!sizeof($founder) || !in_array($ban_item, $founder))
					{
						$banlist_ary[] = $ban_item;
					}
				}
			}


			if (sizeof($ban_list) == 0)
			{
				trigger_error('NO_EMAILS_DEFINED');
			}
		break;

		default:
			trigger_error('NO_MODE');
		break;
	}

	// Fetch currently set bans of the specified type and exclude state. Prevent duplicate bans.
	$sql_where = ($type == 'ban_userid') ? 'ban_userid <> 0' : "$type <> ''";

	$sql = "SELECT $type
		FROM " . $db_prefix . "_bans
		WHERE $sql_where
			AND ban_exclude = " . (int) $ban_exclude;
			//die($sql);
	$result = $db->sql_query($sql);

	// Reset $sql_where, because we use it later...
	$sql_where = '';

	if ($row = $db->sql_fetchrow($result))
	{
		$banlist_ary_tmp = array();
		do
		{
			switch ($mode)
			{
				case 'user':
					$banlist_ary_tmp[] = $row['ban_userid'];
				break;

				case 'ip':
					$banlist_ary_tmp[] = $row['ipstart'];
				break;

				case 'email':
					$banlist_ary_tmp[] = $row['ban_email'];
				break;
			}
		}
		while ($row = $db->sql_fetchrow($result));

		$banlist_ary = array_unique(array_diff($banlist_ary, $banlist_ary_tmp));
		unset($banlist_ary_tmp);
	}
	$db->sql_freeresult($result);

	// We have some entities to ban
	if (sizeof($banlist_ary))
	{
		$sql_ary = array();

		foreach ($banlist_ary as $ban_entry)
		{
			$sql_ary[] = array(
				$type				=> $ban_entry,
				'ban_start'			=> (int) $current_time,
				'ban_end'			=> (int) $ban_end,
				'ban_exclude'		=> (int) $ban_exclude,
				'reason'			=> (string) $ban_reason,
				'ban_give_reason'	=> (string) $ban_give_reason,
			);
			if($type == 'ban_userid')
			{
				$sql = 'UPDATE ' . $db_prefix . "_users  SET `ban` = '1', `banreason` = '" . $ban_give_reason . "' WHERE `id` ='" . $ban_entry . "';";
				$db->sql_query($sql);
			}

		}
//die(print_r($sql_ary));
		$db->sql_multi_insert($db_prefix . '_bans', $sql_ary);

		// If we are banning we want to logout anyone matching the ban
		if (!$ban_exclude)
		{
			switch ($mode)
			{
				case 'user':
					$sql_where = 'WHERE ' . $db->sql_in_set('session_user_id', $banlist_ary);
				break;

				case 'ip':
					$sql_where = 'WHERE ' . $db->sql_in_set('session_ip', $banlist_ary);
				break;

				case 'email':
					$banlist_ary_sql = array();

					foreach ($banlist_ary as $ban_entry)
					{
						$banlist_ary_sql[] = (string) str_replace('*', '%', $ban_entry);
					}

					$sql = 'SELECT id AS user_id
						FROM ' . $db_prefix . '_users
						WHERE ' . $db->sql_in_set('email', $banlist_ary_sql);
					$result = $db->sql_query($sql);

					$sql_in = array();

					if ($row = $db->sql_fetchrow($result))
					{
						do
						{
							$sql_in[] = $row['user_id'];
						}
						while ($row = $db->sql_fetchrow($result));

						$sql_where = 'WHERE ' . $db->sql_in_set('session_user_id', $sql_in);
					}
					$db->sql_freeresult($result);
				break;
			}

		}

		// Update log
		$log_entry = ($ban_exclude) ? 'LOG_BAN_EXCLUDE_' : 'LOG_BAN_';

		// Add to moderator and admin log
		add_log('admin', $log_entry . strtoupper($mode), $ban_reason, $ban_list_log);
		//add_log('mod', 0, 0, $log_entry . strtoupper($mode), $ban_reason, $ban_list_log);
		return true;
	}
	return false;
}
function user_unban($mode, $ban)
{
	global $db, $db_prefix, $user, $auth, $pmbt_cache;

	// Delete stale bans
	$sql = 'DELETE FROM ' . $db_prefix . '_bans
		WHERE ban_end < ' . time() . '
			AND ban_end <> 0';
	$db->sql_query($sql);

	if (!is_array($ban))
	{
		$ban = array($ban);
	}

	$unban_sql = array_map('intval', $ban);

	if (sizeof($unban_sql))
	{
		// Grab details of bans for logging information later
		switch ($mode)
		{
			case 'user':
				$sql = 'SELECT u.username AS unban_info, u.id AS user_id
					FROM ' . $db_prefix . '_users u, ' . $db_prefix . '_bans b
					WHERE ' . $db->sql_in_set('b.id', $unban_sql) . '
						AND u.id = b.ban_userid';
			break;

			case 'email':
				$sql = 'SELECT ban_email AS unban_info
					FROM ' . $db_prefix . '_bans
					WHERE ' . $db->sql_in_set('ban_id', $unban_sql);
			break;

			case 'ip':
				$sql = 'SELECT ban_ip AS unban_info
					FROM ' . $db_prefix . '_bans
					WHERE ' . $db->sql_in_set('ban_id', $unban_sql);
			break;
		}
		$result = $db->sql_query($sql);

		$l_unban_list = '';
		$user_ids_ary = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$l_unban_list .= (($l_unban_list != '') ? ', ' : '') . $row['unban_info'];
			if ($mode == 'user')
			{
				$user_ids_ary[] = $row['user_id'];
			}
		}
		$db->sql_freeresult($result);

		$sql = 'DELETE FROM ' . $db_prefix . '_bans
			WHERE ' . $db->sql_in_set('id', $unban_sql);
		$db->sql_query($sql);

		// Add to moderator log, admin log and user notes
		add_log('admin', 'LOG_UNBAN_' . strtoupper($mode), $l_unban_list);
		add_log('mod', 0, 0, 'LOG_UNBAN_' . strtoupper($mode), $l_unban_list);
		if ($mode == 'user')
		{
			foreach ($user_ids_ary as $user_id)
			{
				add_log('user', $user_id, 'LOG_UNBAN_' . strtoupper($mode), $l_unban_list);
				$sql = 'UPDATE ' . $db_prefix . '_users  SET `ban` = \'0\', `banreason` = \'\' WHERE `id` =' . $user_id . ';';
				$db->sql_query($sql);
			}
		}
	}

	//$pmbt_cache->destroy('sql', $db_prefix . '_bans');

	return false;
}
/**
* Defining rule option for message rules
*/
function define_rule_option($hardcoded, $rule_option, $rule_lang, $check_ary)
{
	global $template;
	global $module;

	$exclude = array();


	$s_rule_options = '';
	if (!$hardcoded)
	{
		foreach ($check_ary as $value => $_check)
		{
			if (isset($exclude[$value]))
			{
				continue;
			}
			$s_rule_options .= '<option value="' . $value . '"' . (($value == $rule_option) ? ' selected="selected"' : '') . '>' . $rule_lang[$value] . '</option>';
		}
	}

	$template->assign_vars(array(
		'S_RULE_DEFINED'	=> true,
		'S_RULE_SELECT'		=> !$hardcoded,
		'RULE_CURRENT'		=> isset($rule_lang[$rule_option]) ? $rule_lang[$rule_option] : '',
		'S_RULE_OPTIONS'	=> $s_rule_options,
		'RULE_OPTION'		=> $rule_option)
	);
}

/**
* Defining condition option for message rules
*/
function define_cond_option($hardcoded, $cond_option, $rule_option, $global_rule_conditions)
{
	global $db, $template, $auth, $user, $db_prefix;

	$template->assign_vars(array(
		'S_COND_DEFINED'	=> true,
		'S_COND_SELECT'		=> (!$hardcoded && isset($global_rule_conditions[$rule_option])) ? true : false)
	);

	// Define COND_OPTION
	if (!isset($global_rule_conditions[$rule_option]))
	{
		$template->assign_vars(array(
			'COND_OPTION'	=> 'none',
			'COND_CURRENT'	=> false)
		);
		return;
	}

	// Define Condition
	$condition = $global_rule_conditions[$rule_option];
	$current_value = '';

	switch ($condition)
	{
		case 'text':
			$rule_string = request_var('rule_string', '', true);

			$template->assign_vars(array(
				'S_TEXT_CONDITION'	=> true,
				'CURRENT_STRING'	=> $rule_string,
				'CURRENT_USER_ID'	=> 0,
				'CURRENT_GROUP_ID'	=> 0)
			);

			$current_value = $rule_string;
		break;

		case 'user':
			$rule_user_id = request_var('rule_user_id', 0);
			$rule_string = request_var('rule_string', '', true);

			if ($rule_string && !$rule_user_id)
			{
				$sql = 'SELECT id
					FROM ' . $db_prefix . "_users
					WHERE clean_username = '" . $db->sql_escape(strtolower($rule_string)) . "'";
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$rule_user_id = (int) $db->sql_fetchfield('id');
				$db->sql_freeresult($result);

				if (!$rule_user_id)
				{
					$rule_string = '';
				}
			}
			else if (!$rule_string && $rule_user_id)
			{
				$sql = 'SELECT username
					FROM ' . $db_prefix . "_users
					WHERE id = $rule_user_id";
				$result = $db->sql_query($sql) or btsqlerror($sql);
				$rule_string = $db->sql_fetchfield('username');
				$db->sql_freeresult($result);

				if (!$rule_string)
				{
					$rule_user_id = 0;
				}
			}

			$template->assign_vars(array(
				'S_USER_CONDITION'	=> true,
				'CURRENT_STRING'	=> $rule_string,
				'CURRENT_USER_ID'	=> $rule_user_id,
				'CURRENT_GROUP_ID'	=> 0)
			);

			$current_value = $rule_string;
		break;


		case 'group':
			$rule_group_id = request_var('rule_group_id', 0);
			$rule_string = request_var('rule_string', '', true);

			$sql = 'SELECT g.group_id, g.group_name, g.group_type
					FROM ' . $db_prefix . '_level_settings g ';

			if (!$auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel'))
			{
				$sql .= 'LEFT JOIN ' . $db_prefix . '_user_group ug
					ON (
						g.group_id = ug.group_id
						AND ug.user_id = ' . $user->id . '
						AND ug.user_pending = 0
					)
					WHERE (ug.user_id = ' . $user->id . ' OR g.group_type <> ' . 2 . ')
					AND';
			}
			else
			{
				$sql .= 'WHERE';
			}

			$sql .= " (g.group_name NOT IN ('GUESTS', 'BOTS') OR g.group_type <> " . 3 . ')
				ORDER BY g.group_type DESC, g.group_name ASC';

			$result = $db->sql_query($sql) or btsqlerror($sql);

			$s_group_options = '';
			while ($row = $db->sql_fetchrow($result))
			{
				if ($rule_group_id && ($row['group_id'] == $rule_group_id))
				{
					$rule_string = (($row['group_type'] == 3) ? $user->lang[$row['group_name']] : $row['group_name']);
				}

				$s_class	= ($row['group_type'] == 3) ? ' class="sep"' : '';
				$s_selected	= ($row['group_id'] == $rule_group_id) ? ' selected="selected"' : '';

				$s_group_options .= '<option value="' . $row['group_id'] . '"' . $s_class . $s_selected . '>' . (($row['group_type'] == 3) ? $user->lang[$row['group_name']] : $row['group_name']) . '</option>';
			}
			$db->sql_freeresult($result);

			$template->assign_vars(array(
				'S_GROUP_CONDITION'	=> true,
				'S_GROUP_OPTIONS'	=> $s_group_options,
				'CURRENT_STRING'	=> $rule_string,
				'CURRENT_USER_ID'	=> 0,
				'CURRENT_GROUP_ID'	=> $rule_group_id)
			);

			$current_value = $rule_string;
		break;

		default:
			return;
	}

	$template->assign_vars(array(
		'COND_OPTION'	=> $condition,
		'COND_CURRENT'	=> $current_value)
	);
}

/**
* Display defined message rules
*/
function checkfriend($user_id = '0'){
if($user_id == '0')return false;
	global $db, $db_prefix, $user;
$sql = "SELECT * FROM `" . $db_prefix . "_private_messages_bookmarks` WHERE `master`= '" . $user->id . "' AND `slave`= '" . $user_id . "'";
$result = $db->sql_query($sql) or btsqlerror($sql);
if($db->sql_fetchrow($result))return true;
else return false;
}
function checkfoe($user_id = '0'){
if($user_id == '0')return false;
	global $db, $db_prefix;
$sql = "SELECT * FROM `" . $db_prefix . "_private_messages_blacklist` WHERE `master`= '" . $user->id . "' AND `slave`= '" . $user_id . "'";
$result = $db->sql_query($sql) or btsqlerror($sql);
if($db->sql_fetchrow($result))return true;
else return false;
}
function show_defined_rules($user_id, $check_lang, $rule_lang, $action_lang, $folder)
{
	global $db, $db_prefix, $template;

	$sql = 'SELECT *
		FROM ' . $db_prefix . '_private_messages_rules
		WHERE user_id = ' . $user_id . '
		ORDER BY rule_id ASC';
	$result = $db->sql_query($sql) or btsqlerror($sql);

	$count = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		$template->assign_block_vars('rule', array(
			'COUNT'		=> ++$count,
			'RULE_ID'	=> $row['rule_id'],
			'CHECK'		=> $check_lang[$row['rule_check']],
			'RULE'		=> $rule_lang[$row['rule_connection']],
			'STRING'	=> $row['rule_string'],
			'ACTION'	=> $action_lang[$row['rule_action']],
			'FOLDER'	=> ($row['rule_action'] == ACTION_PLACE_INTO_FOLDER) ? $folder[$row['rule_folder_id']]['folder_name'] : '')
		);
	}
	$db->sql_freeresult($result);
}

function get_username_string($mode, $user_id, $username, $username_colour = '', $guest_username = false, $custom_profile_url = false)
{
	static $_profile_cache;

	// We cache some common variables we need within this function
	if (empty($_profile_cache))
	{
		global $siteurl, $phpEx;

		$_profile_cache['base_url'] = append_sid("{$siteurl}/user.$phpEx", 'op=profile&amp;id={USER_ID}');
		$_profile_cache['tpl_noprofile'] = '{USERNAME}';
		$_profile_cache['tpl_noprofile_colour'] = '<span style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</span>';

		$_profile_cache['tpl_profile'] = '<a href="{PROFILE_URL}">{USERNAME}</a>';
		$_profile_cache['tpl_profile_colour'] = '<a href="{PROFILE_URL}" style="color: {USERNAME_COLOUR};" class="username-coloured">{USERNAME}</a>';
	}

	global $user;

	// This switch makes sure we only run code required for the mode
	switch ($mode)
	{
		case 'full':
		case 'no_profile':
		case 'colour':

			// Build correct username colour
			$username_colour = ($username_colour) ? $username_colour : '';

			// Return colour
			if ($mode == 'colour')
			{
				return $username_colour;
			}

		// no break;

		case 'username':

			// Build correct username
			if ($guest_username === false)
			{
				$username = ($username) ? $username : $user->lang['GUEST'];
			}
			else
			{
				$username = ($user_id && $user_id != 0) ? $username : ((!empty($guest_username)) ? $guest_username : $user->lang['GUEST']);
			}

			// Return username
			if ($mode == 'username')
			{
				return $username;
			}

		// no break;

		case 'profile':

			// Build correct profile url - only show if not anonymous and permission to view profile if registered user
			// For anonymous the link leads to a login page.
			if ($user_id && $user_id != 0 && ($user->id == 0 || checkaccess('u_can_view_profiles')))
			{
				$profile_url = ($custom_profile_url !== false) ? $custom_profile_url . '&amp;id=' . (int) $user_id : str_replace(array('={USER_ID}', '=%7BUSER_ID%7D'), '=' . (int) $user_id, $_profile_cache['base_url']);
			}
			else
			{
				$profile_url = '';
			}

			// Return profile
			if ($mode == 'profile')
			{
				return $profile_url;
			}

		// no break;
	}

	if (($mode == 'full' && !$profile_url) || $mode == 'no_profile')
	{
		return str_replace(array('{USERNAME_COLOUR}', '{USERNAME}'), array($username_colour, $username), (!$username_colour) ? $_profile_cache['tpl_noprofile'] : $_profile_cache['tpl_noprofile_colour']);
	}

	return str_replace(array('{PROFILE_URL}', '{USERNAME_COLOUR}', '{USERNAME}'), array($profile_url, $username_colour, $username), (!$username_colour) ? $_profile_cache['tpl_profile'] : $_profile_cache['tpl_profile_colour']);
}
if (!function_exists("newuserpage")){
function newuserpage($page)
{
if(preg_match("/rules.php/",$page))return true;
if(preg_match("/faq.php/",$page))return true;
if(preg_match("/pm_ajax.php/",$page))return true;
if(preg_match("/login.php/",$page))return true;
if(preg_match("/gfxgen.php/",$page))return true;
if(preg_match("/user.php/",$page))return true;
if(preg_match("/invite.php/",$page))return true;
if(preg_match("/confirminvite.php/",$page))return true;
if(preg_match("/user.php/",$page))return true;
if(preg_match("/backend.php/",$page))return true;
if(preg_match("/cron.php/",$page))return true;
if(preg_match("/download.php/",$page))return true;
if(preg_match("/ban.php/",$page))return true;
if(preg_match("/httperror.php/",$page))return true;
if(preg_match("/ajax.php/",$page))return true;
return false;
}
}
function build_user_array($id)
 {
 	global $db, $db_prefix;
	$sql = 'SELECT U.language AS language, U.username AS name, U.lastlogin AS lastlogin, U.lastip AS ip, U.lasthost AS lasthost, U.name AS nick, U.can_do AS goup, U.level AS level, U.regdate AS reg, U.email AS email, U.uploaded AS uploaded, U.downloaded AS downloaded, U.uploaded/U.downloaded AS ratio, U.modcomment AS mdcoment, U.warned as warned, U.warn_hossz as length, U.warn_kapta as received, U.user_posts AS postcount, U.banreason AS banreason, U.ban AS banned, L.group_colour AS color, L.group_name AS lname
			FROM `' . $db_prefix . '_users` U, `' . $db_prefix . '_level_settings` L
			WHERE
			U.id = ' . $id . ' and
			L.group_id = U.can_do LIMIT 1';
			$arr = $db->sql_query($sql) or btsqlerror($sql);
			$arrt = $db->sql_fetchrow($arr);
	$row = array();
	$row['name'] 				= $arrt['name'];
	$row['nick'] 				= $arrt['nick'];
	$row['group'] 				= $arrt['lname'];
	$row['level'] 				= $arrt['level'];
	$row['lang']				= (file_exists("./language/".$arrt["language"].".php"))? $arrt["language"] : 'english';
	$row['reg'] 				= ($arrt['reg'] == '0000-00-00 00:00:00')? '--' : $arrt['reg'];
	$row['lastlogin'] 			= ($arrt['lastlogin'] == '0000-00-00 00:00:00')? '--' : $arrt['lastlogin'];
	$row['ip'] 					= $arrt['ip'];
	$row['long2ip'] 			= long2ip($arrt['ip']);
	$row['lasthost'] 			= $arrt['lasthost'];
	$row['email'] 				= $arrt['email'];
	$row['color'] 				= $arrt['color'];
	$row['can_do'] 				= $arrt['goup'];
	$row['uploaded'] 			= $arrt['uploaded'];
	$row['downloaded'] 			= $arrt['downloaded'];
	$row['ratio'] 				= $arrt['ratio'];
	$row['mdcoment']			= $arrt['mdcoment'];
	$row['warn_received'] 		= $arrt['received'];
	$row['warn_length']			= $arrt['length'];
	$row['postcount']			= $arrt['postcount'];
	$row['banned']				= $arrt['banned'];
	$row['banreason']			= $arrt['banreason'];
	$row['warned']				= $arrt['warned'];
	return $row;
 }
function get_group_name($group_id)
{
	global $db, $db_prefix, $user;

	$sql = 'SELECT group_name, group_type
		FROM ' . $db_prefix . '_level_settings
		WHERE group_id = ' . (int) $group_id;
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if (!$row)
	{
		return '';
	}

	return ($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];
}
function group_user_attributes($action, $group_id, $user_id_ary = false, $username_ary = false, $group_name = false, $group_attributes = false)
{
	global $db, $db_prefix, $auth, $phpbb_root_path, $phpEx, $config;

	// We need both username and user_id info
	$result = user_get_id_name($user_id_ary, $username_ary);

	if (!sizeof($user_id_ary) || $result !== false)
	{
		return 'NO_USERS';
	}

	if (!$group_name)
	{
		$group_name = get_group_name($group_id);
	}

	switch ($action)
	{
		case 'demote':
		case 'promote':

			$sql = 'SELECT user_id FROM ' . $db_prefix . "_user_group
				WHERE group_id = $group_id
					AND user_pending = 1
					AND " . $db->sql_in_set('user_id', $user_id_ary);
			$result = $db->sql_query($sql . ' LIMT 1');
			$not_empty = ($db->sql_fetchrow($result));
			$db->sql_freeresult($result);
			if ($not_empty)
			{
				return 'NO_VALID_USERS';
			}

			$sql = 'UPDATE ' . $db_prefix . '_user_group
				SET group_leader = ' . (($action == 'promote') ? 1 : 0) . "
				WHERE group_id = $group_id
					AND user_pending = 0
					AND " . $db->sql_in_set('user_id', $user_id_ary);
			$db->sql_query($sql) or btsqlerror($sql);

			$log = ($action == 'promote') ? 'LOG_GROUP_PROMOTED' : 'LOG_GROUP_DEMOTED';
		break;

		case 'approve':
			// Make sure we only approve those which are pending ;)
			$sql = 'SELECT u.id AS user_id, u.email AS user_email, u.username, u.clean_username AS username_clean, u.user_notify_type, u.jabber AS user_jabber, u.language AS user_lang
				FROM ' . $db_prefix . '_users u, ' . $db_prefix . '_user_group ug
				WHERE ug.group_id = ' . $group_id . '
					AND ug.user_pending = 1
					AND ug.user_id = u.id
					AND ' . $db->sql_in_set('ug.user_id', $user_id_ary);
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$user_id_ary = $email_users = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$user_id_ary[] = $row['user_id'];
				$email_users[] = $row;
			}
			$db->sql_freeresult($result);

			if (!sizeof($user_id_ary))
			{
				return false;
			}

			$sql = 'UPDATE ' . $db_prefix . "_user_group
				SET user_pending = 0
				WHERE group_id = $group_id
					AND " . $db->sql_in_set('user_id', $user_id_ary);
			$db->sql_query($sql) or btsqlerror($sql);

			// Send approved email to users...
			include_once($phpbb_root_path . 'include/function_messenger.' . $phpEx);
			$messenger = new messenger();

			foreach ($email_users as $row)
			{
				$messenger->template('group_approved', $row['user_lang']);

				$messenger->to($row['user_email'], $row['username']);
				$messenger->im($row['user_jabber'], $row['username']);

				$messenger->assign_vars(array(
					'USERNAME'		=> htmlspecialchars_decode($row['username']),
					'GROUP_NAME'	=> htmlspecialchars_decode($group_name),
					'U_GROUP'		=> generate_board_url() . "/ucp.$phpEx?i=groups&mode=membership")
				);

				$messenger->send($row['user_notify_type']);
			}

			$messenger->save_queue();

			$log = 'LOG_USERS_APPROVED';
		break;

		case 'default':
			$sql = 'SELECT id AS user_id, can_do AS  group_id FROM ' . $db_prefix . '_users
				WHERE ' . $db->sql_in_set('id', $user_id_ary, false, true);
			$result = $db->sql_query($sql) or btsqlerror($sql);

			$groups = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if (!isset($groups[$row['group_id']]))
				{
					$groups[$row['group_id']] = array();
				}
				$groups[$row['group_id']][] = $row['user_id'];
			}
			$db->sql_freeresult($result);

			foreach ($groups as $gid => $uids)
			{
				remove_default_rank($gid, $uids);
				remove_default_avatar($gid, $uids);
			}
			group_set_user_default($group_id, $user_id_ary, $group_attributes);
			$log = 'LOG_GROUP_DEFAULTS';
		break;
	}
	//die();

	// Clear permissions cache of relevant users
	$auth->acl_clear_prefetch($user_id_ary);

	add_log('admin', $log, $group_name, implode(', ', $username_ary));

	group_update_listings($group_id);

	return false;
}
function remove_default_avatar($group_id, $user_ids)
{
	global $db, $db_prefix;

	if (!is_array($user_ids))
	{
		$user_ids = array($user_ids);
	}
	if (empty($user_ids))
	{
		return false;
	}

	$user_ids = array_map('intval', $user_ids);

	$sql = 'SELECT *
		FROM ' . $db_prefix . '_level_settings
		WHERE group_id = ' . (int)$group_id;
	$result = $db->sql_query($sql);
	if (!$row = $db->sql_fetchrow($result))
	{
		$db->sql_freeresult($result);
		return false;
	}
	$db->sql_freeresult($result);

	$sql = 'UPDATE ' . $db_prefix . "_users
		SET avatar = 'blank.gif',
			avatar_type = 0,
			avatar_wt = 0,
			avatar_ht = 0
		WHERE can_do = " . (int) $group_id . "
		AND avatar = '" . $db->sql_escape($row['group_avatar']) . "'
		AND " . $db->sql_in_set('id', $user_ids);

	$db->sql_query($sql);
}
function remove_default_rank($group_id, $user_ids)
{
	global $db, $db_prefix;

	if (!is_array($user_ids))
	{
		$user_ids = array($user_ids);
	}
	if (empty($user_ids))
	{
		return false;
	}

	$user_ids = array_map('intval', $user_ids);

	$sql = 'SELECT *
		FROM ' . $db_prefix . '_level_settings
		WHERE group_id = ' . (int)$group_id;
	$result = $db->sql_query($sql);
	if (!$row = $db->sql_fetchrow($result))
	{
		$db->sql_freeresult($result);
		return false;
	}
	$db->sql_freeresult($result);

	$sql = 'UPDATE ' . $db_prefix . '_users
		SET user_rank = 0
		WHERE can_do = ' . (int)$group_id . '
		AND user_rank <> 0
		AND user_rank = ' . (int)$row['group_rank'] . '
		AND ' . $db->sql_in_set('id', $user_ids);
	$db->sql_query($sql);
}
function group_user_add($group_id, $user_id_ary = false, $username_ary = false, $group_name = false, $default = false, $leader = 0, $pending = 0, $group_attributes = false)
{
	global $db, $db_prefix, $auth;

	// We need both username and user_id info
	if(!is_array($user_id_ary)) $user_id_ary = array($user_id_ary);
	$result = user_get_id_name($user_id_ary, $username_ary);

	if (!sizeof($user_id_ary) || $result !== false)
	{
		return 'NO_USER';
	}

	// Remove users who are already members of this group
	$sql = 'SELECT user_id, group_leader
		FROM ' . $db_prefix . '_user_group
		WHERE ' . $db->sql_in_set('user_id', $user_id_ary) . "
			AND group_id = $group_id";
	$result = $db->sql_query($sql);

	$add_id_ary = $update_id_ary = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$add_id_ary[] = (int) $row['user_id'];

		if ($leader && !$row['group_leader'])
		{
			$update_id_ary[] = (int) $row['user_id'];
		}
	}
	$db->sql_freeresult($result);

	// Do all the users exist in this group?
	$add_id_ary = array_diff($user_id_ary, $add_id_ary);

	// If we have no users
	if (!sizeof($add_id_ary) && !sizeof($update_id_ary))
	{
		return 'GROUP_USERS_EXIST';
	}



	// Insert the new users
	if (sizeof($add_id_ary))
	{
		$sql_ary = array();

		foreach ($add_id_ary as $user_id)
		{
			$sql_ary[] = array(
				'user_id'		=> (int) $user_id,
				'group_id'		=> (int) $group_id,
				'group_leader'	=> (int) $leader,
				'user_pending'	=> (int) $pending,
			);
		}

		$db->sql_multi_insert($db_prefix . '_user_group', $sql_ary);
	}

	if (sizeof($update_id_ary))
	{
		$sql = 'UPDATE ' . $db_prefix . '_user_group
			SET group_leader = 1
			WHERE ' . $db->sql_in_set('user_id', $update_id_ary) . "
				AND group_id = $group_id";
		$db->sql_query($sql);
	}

	if ($default)
	{
		group_set_user_default($group_id, $user_id_ary, $group_attributes);
	}


	// Clear permissions cache of relevant users
	$auth->acl_clear_prefetch($user_id_ary);

	if (!$group_name)
	{
		$group_name = get_group_name($group_id);
	}

	$log = ($leader) ? 'LOG_MODS_ADDED' : 'LOG_USERS_ADDED';

	add_log('admin', $log, $group_name, implode(', ', $username_ary));

	group_update_listings($group_id);

	// Return false - no error
	return false;
}

function group_set_user_default($group_id, $user_id_ary, $group_attributes = false, $update_listing = false)
{
	global $db, $db_prefix;

	if (empty($user_id_ary))
	{
		return;
	}

	$attribute_ary = array(
		'group_colour'			=> 'string',
		'group_rank'			=> 'int',
		'group_avatar'			=> 'string',
		'group_avatar_type'		=> 'int',
		'group_avatar_width'	=> 'int',
		'group_avatar_height'	=> 'int',
	);

	$sql_ary = array(
		'can_do'		=> $group_id
	);

	// Were group attributes passed to the function? If not we need to obtain them
	if ($group_attributes === false)
	{
		$sql = 'SELECT ' . implode(', ', array_keys($attribute_ary)) . '
			FROM ' . $db_prefix . "_level_settings
			WHERE group_id = $group_id";
		$result = $db->sql_query($sql);
		$group_attributes = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	}

	foreach ($attribute_ary as $attribute => $type)
	{
		if (isset($group_attributes[$attribute]))
		{
			// If we are about to set an avatar or rank, we will not overwrite with empty, unless we are not actually changing the default group
			if ((strpos($attribute, 'group_avatar') === 0 || strpos($attribute, 'group_rank') === 0) && !$group_attributes[$attribute])
			{
				continue;
			}

			settype($group_attributes[$attribute], $type);
			$sql_ary[str_replace(array('group_', 'height', 'width'),array('user_','ht','wt'), $attribute)] = $group_attributes[$attribute];
		}
	}

	// Before we update the user attributes, we will make a list of those having now the group avatar assigned
	if (isset($sql_ary['avatar']))
	{
		// Ok, get the original avatar data from users having an uploaded one (we need to remove these from the filesystem)
		$sql = 'SELECT id AS user_id, can_do, can_do AS group_id, avatar AS user_avatar, username, l.group_colour AS user_colour
			FROM ' . $db_prefix . '_users, ' . $db_prefix . '_level_settings l
			WHERE ' . $db->sql_in_set('id', $user_id_ary) . '
			AND l.group_id = can_do
				AND avatar_type = 1';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			avatar_delete('user', $row);
		}
		$db->sql_freeresult($result);
	}
	else
	{
		unset($sql_ary['avatar_type']);
		unset($sql_ary['avatar_ht']);
		unset($sql_ary['avatar_wt']);
	}

	$sql = 'UPDATE ' . $db_prefix . '_users SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
		WHERE ' . $db->sql_in_set('id', $user_id_ary);
	$db->sql_query($sql);

	if (isset($sql_ary['user_colour']))
	{
		// Update any cached colour information for these users
		$sql = 'UPDATE ' .  $db_prefix . "_forums SET forum_last_poster_colour = '" . $db->sql_escape($sql_ary['user_colour']) . "'
			WHERE " . $db->sql_in_set('forum_last_poster_id', $user_id_ary);
		$db->sql_query($sql);

		$sql = 'UPDATE ' .  $db_prefix . "_topics SET topic_first_poster_colour = '" . $db->sql_escape($sql_ary['user_colour']) . "'
			WHERE " . $db->sql_in_set('topic_poster', $user_id_ary);
		$db->sql_query($sql);

		$sql = 'UPDATE ' .  $db_prefix . "_topics SET topic_last_poster_colour = '" . $db->sql_escape($sql_ary['user_colour']) . "'
			WHERE " . $db->sql_in_set('topic_last_poster_id', $user_id_ary);
		$db->sql_query($sql);


	}

}
function avatar_delete($mode, $row, $clean_db = false)
{
	global $phpbb_root_path, $config, $db, $user;

	// Check if the users avatar is actually *not* a group avatar
	if ($mode == 'user')
	{
		if (strpos($row['avatar'], 'g') === 0 || (($row['avatar'] !== 'blank.gif') && (strpos($row['avatar'], $row['username']) === 0)))
		{
			return false;
		}
	}

	if (file_exists($row['avatar']))
	{
		@unlink($row['avatar']);
		return true;
	}

	return false;
}
function group_user_del($group_id, $user_id_ary = false, $username_ary = false, $group_name = false)
{
	global $db, $db_prefix, $auth, $config;

		$group_order = array('Owner', 'ADMINISTRATORS', 'MODERATOR', 'PREMIUM_USER', 'USER', 'Guest');

	// We need both username and user_id info
	$result = user_get_id_name($user_id_ary, $username_ary);

	if (!sizeof($user_id_ary) || $result !== false)
	{
		return 'NO_USER';
	}

	$sql = 'SELECT *
		FROM ' . $db_prefix . '_level_settings
		WHERE ' . $db->sql_in_set('group_name', $group_order);
	$result = $db->sql_query($sql);

	$group_order_id = $special_group_data = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$group_order_id[$row['group_name']] = $row['group_id'];

		$special_group_data[$row['group_id']] = array(
			'group_colour'			=> $row['group_colour'],
			'group_rank'				=> $row['group_rank'],
		);

		// Only set the group avatar if one is defined...
		if ($row['group_avatar'])
		{
			$special_group_data[$row['group_id']] = array_merge($special_group_data[$row['group_id']], array(
				'group_avatar'			=> $row['group_avatar'],
				'group_avatar_type'		=> $row['group_avatar_type'],
				'group_avatar_width'		=> $row['group_avatar_width'],
				'group_avatar_height'	=> $row['group_avatar_height'])
			);
		}
	}
	$db->sql_freeresult($result);

	// Get users default groups - we only need to reset default group membership if the group from which the user gets removed is set as default
	$sql = 'SELECT id AS user_id, can_do AS group_id
		FROM ' . $db_prefix . '_users
		WHERE ' . $db->sql_in_set('id', $user_id_ary);
	$result = $db->sql_query($sql);

	$default_groups = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$default_groups[$row['user_id']] = $row['group_id'];
	}
	$db->sql_freeresult($result);

	// What special group memberships exist for these users?
	$sql = 'SELECT g.group_id, g.group_name, ug.user_id
		FROM ' . $db_prefix . '_user_group ug, ' . $db_prefix . '_level_settings g
		WHERE ' . $db->sql_in_set('ug.user_id', $user_id_ary) . "
			AND g.group_id = ug.group_id
			AND g.group_id <> $group_id
			AND g.group_type = " . 3 . '
		ORDER BY ug.user_id, g.group_id';
	$result = $db->sql_query($sql);

	$temp_ary = array();
	while ($row = $db->sql_fetchrow($result))
	{
		if ($default_groups[$row['user_id']] == $group_id && (!isset($temp_ary[$row['user_id']]) || $group_order_id[$row['group_name']] < $temp_ary[$row['user_id']]))
		{
			$temp_ary[$row['user_id']] = $row['group_id'];
		}
	}
	$db->sql_freeresult($result);

	// sql_where_ary holds the new default groups and their users
	$sql_where_ary = array();
	foreach ($temp_ary as $uid => $gid)
	{
		$sql_where_ary[$gid][] = $uid;
	}
	unset($temp_ary);

	foreach ($special_group_data as $gid => $default_data_ary)
	{
		if (isset($sql_where_ary[$gid]) && sizeof($sql_where_ary[$gid]))
		{
			remove_default_rank($gid, $sql_where_ary[$gid]);
			remove_default_avatar($group_id, $sql_where_ary[$gid]);
			group_set_user_default($gid, $sql_where_ary[$gid], $default_data_ary);
		}
	}
	unset($special_group_data);

	$sql = 'DELETE FROM ' . $db_prefix . "_user_group
		WHERE group_id = $group_id
			AND " . $db->sql_in_set('user_id', $user_id_ary);
	$db->sql_query($sql);

	// Clear permissions cache of relevant users
	$auth->acl_clear_prefetch($user_id_ary);

	if (!$group_name)
	{
		$group_name = get_group_name($group_id);
	}

	$log = 'LOG_GROUP_REMOVE';

	add_log('admin', $log, $group_name, implode(', ', $username_ary));

	group_update_listings($group_id);

	// Return false - no error
	return false;
}
function group_update_listings($group_id)
{
	global $db, $db_prefix, $auth;

	$hold_ary = $auth->acl_group_raw_data($group_id, array('a_', 'm_'));

	if (!sizeof($hold_ary))
	{
		return;
	}

	$mod_permissions = $admin_permissions = false;

	foreach ($hold_ary as $g_id => $forum_ary)
	{
		foreach ($forum_ary as $forum_id => $auth_ary)
		{
			foreach ($auth_ary as $auth_option => $setting)
			{
				if ($mod_permissions && $admin_permissions)
				{
					break 3;
				}

				if ($setting != 1)
				{
					continue;
				}

				if ($auth_option == 'm_')
				{
					$mod_permissions = true;
				}

				if ($auth_option == 'a_')
				{
					$admin_permissions = true;
				}
			}
		}
	}

	if ($mod_permissions)
	{
		if (!function_exists('cache_moderators'))
		{
			global $phpbb_root_path, $phpEx;
			include_once($phpbb_root_path . 'admin/function.' . $phpEx);
		}
		cache_moderators();
	}

	if ($mod_permissions || $admin_permissions)
	{
		if (!function_exists('update_foes'))
		{
			global $phpbb_root_path, $phpEx;
			include_once($phpbb_root_path . 'admin/function.' . $phpEx);
		}
		update_foes(array($group_id));
	}
}
/**
* Get option bitfield from custom data
*
* @param int	$bit		The bit/value to get
* @param int	$data		Current bitfield to check
* @return bool	Returns true if value of constant is set in bitfield, else false
*/
function btm_optionget(&$user_row, $key, $data = false)
{
		global $user;

		$var = ($data) ? $data : $user_row['user_options'];
		return ($var & 1 << $user->keyoptions[$key]) ? true : false;
}

/**
* Set option bitfield
*
* @param int	$bit		The bit/value to set/unset
* @param bool	$set		True if option should be set, false if option should be unset.
* @param int	$data		Current bitfield to change
*
* @return int	The new bitfield
*/
function btm_optionset(&$userrow, $key, $value, $data = false)
	{
		global $user;

		$var = ($data) ? $data : $userrow['user_options'];

		if ($value && !($var & 1 << $user->keyoptions[$key]))
		{
			$var += 1 << $user->keyoptions[$key];
		}
		else if (!$value && ($var & 1 << $user->keyoptions[$key]))
		{
			$var -= 1 << $user->keyoptions[$key];
		}
		else
		{
			return ($data) ? $var : false;
		}

		if (!$data)
		{
			$userrow['user_options'] = $var;
			return true;
		}
		else
		{
			return $var;
		}
	}

/**
* Flips user_type from active to inactive and vice versa, handles group membership updates
*
* @param string $mode can be flip for flipping from active/inactive, activate or deactivate
*/
function user_active_flip($mode, $user_id_ary, $reason = 1)
{
	global $config, $db, $db_prefix, $user, $auth;

	$deactivated = $activated = 0;
	$sql_statements = array();

	if (!is_array($user_id_ary))
	{
		$user_id_ary = array($user_id_ary);
	}

	if (!sizeof($user_id_ary))
	{
		return;
	}

	$sql = 'SELECT id, can_do, active, user_type, user_inactive_reason
		FROM ' . $db_prefix . '_users
		WHERE ' . $db->sql_in_set('id', $user_id_ary);
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$sql_ary = array();

		if ($row['user_type'] == '2' || $row['user_type'] == '3' ||
			($mode == 'activate' && $row['user_type'] != '1') ||
			($mode == 'deactivate' && $row['user_type'] == '1'))
		{
			continue;
		}


		$sql_ary += array(
			'user_type'				=> ($row['user_type'] == '0') ? '1' : '0',
			'user_inactive_time'	=> ($row['user_type'] == '0') ? time() : '0',
			'user_inactive_reason'	=> ($row['user_type'] == '0') ? $reason : '0',
		);
		if ($row['active'] == '0')
		{
			$sql_ary += array(
			'active'	=>	'1',
			);
		}

		$sql_statements[$row['id']] = $sql_ary;
	}
	$db->sql_freeresult($result);

	if (sizeof($sql_statements))
	{
		foreach ($sql_statements as $user_id => $sql_ary)
		{
			$sql = 'UPDATE ' . $db_prefix . '_users
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE id = ' . $user_id;
			$db->sql_query($sql);
		}

		$auth->acl_clear_prefetch(array_keys($sql_statements));
	}


}
?>