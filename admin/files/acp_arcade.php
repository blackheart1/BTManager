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
** File acp_arcade.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
class acp_arcade
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $db_prefix, $user, $template, $u_action, $theme;
		global $phpEx;
		$this->u_action = $u_action;

		// Set up general vars
		$action	= request_var('action', '');

		$this->tpl_name = 'acp_arcade';
		$this->page_title = 'Arcade Room';
				
		require_once('include/file_functions.' . $phpEx);

		$sync = false;

		switch ($action)
		{
			case 'upload_archive':
				$category_id = request_var('c', 0);
				$uploadarchivespot = "flash/archives/" . basename(@$_FILES['archive_file']['name']); 
				if (move_uploaded_file(@$_FILES['archive_file']['tmp_name'], $uploadarchivespot))
				{
					trigger_error($user->lang['ARCHIVE_UPLOADED'] . back_link($this->u_action . "&amp;c=$category_id"));
				}
				else
				{
					trigger_error($user->lang['UPLOAD_ERROR'] . back_link($this->u_action . "&amp;c=$category_id"), E_USER_WARNING);
				}
			break;
			case 'add_archive':
				require('include/pclzip.lib.' . $phpEx);
				
				$category_id = request_var('c', 0);
				$file = 'flash/archives/' . request_var('archive_file', '');
				
				$tmp_name = file_temp_name('');
				dir_create('flash/archives/tmp/' . $tmp_name . '/');
				$extract_path = 'flash/archives/tmp/' . $tmp_name . '/';
				$archive = new PclZip($file);
				@$archive -> extract(PCLZIP_OPT_PATH, $extract_path);
				
				if (file_exists($extract_path . 'game.xml'))
				{
					$game_info = xml2array(file_get_contents($extract_path . 'game.xml'));
					if (isset($game_info['game']['name']['value']) && isset($game_info['game']['directions']['value']) && isset($game_info['game']['description']['value']) && isset($game_info['game']['width']['value']) && isset($game_info['game']['height']['value']) && isset($game_info['game']['highscore']['value']) && isset($game_info['game']['revscore']['value']) && isset($game_info['game']['keyboard']['value']) && isset($game_info['game']['mouse']['value']) && file_exists($extract_path . $game_info['game']['swf']['value']) && file_exists($extract_path . $game_info['game']['image']['value']))
					{
						$game_file_name = file_temp_name('.swf');
						$uploadgamespot = "flash/" . $game_file_name; 
						$game_image_type = get_file_type($extract_path . $game_info['game']['image']['value']);
						$image_file_name = file_temp_name('.' . $game_image_type);
						$uploadimagespot = "flash/images/" . $image_file_name;
						
						file_copy($extract_path . $game_info['game']['swf']['value'], $uploadgamespot);
						file_copy($extract_path . $game_info['game']['image']['value'], $uploadimagespot);
						
						$game_info['game']['description']['value'] = str_replace('\n', '\r', $game_info['game']['description']['value']);
						$game_info['game']['description']['value'] = str_replace('\r', '\n', $game_info['game']['description']['value']);
						
						$sql_ary = array(
							'game_name'			=> $game_info['game']['name']['value'],
							'game_image'		=> $image_file_name,
							'game_directions'	=> $game_info['game']['directions']['value'],
							'game_description'	=> $game_info['game']['description']['value'],
							'game_category'		=> $category_id,
							'game_filename'		=> $game_file_name,
							'game_width'		=> $game_info['game']['width']['value'],
							'game_height'		=> $game_info['game']['height']['value'],
							'game_enabled'		=> 0,
							'game_highscore'	=> ($game_info['game']['highscore']['value'] == 'true') ? 1 : 0,
							'game_rev_score'	=> ($game_info['game']['revscore']['value'] == 'true') ? 1 : 0,
							'game_keyboard'		=> ($game_info['game']['keyboard']['value'] == 'true') ? 1 : 0,
							'game_mouse'		=> ($game_info['game']['mouse']['value'] == 'true') ? 1 : 0
						);
						$sql = 'INSERT INTO ' . $db_prefix . '_ar_games ' . $db->sql_build_array('INSERT', $sql_ary);
						$db->sql_query($sql);
						
						dir_delete($extract_path, true);
						unlink($file);
						
						trigger_error($user->lang['GAME_ADDED'] . back_link($this->u_action . "&amp;c=$category_id"));
					}
					else
					{
						dir_delete($extract_path, true);
						trigger_error($user->lang['GAME_XML_ERROR'] . back_link($this->u_action . "&amp;c=$category_id"), E_USER_WARNING);
					}
				}
				else
				{
					dir_delete($extract_path, true);
					trigger_error($user->lang['GAME_ARCHIVE_ERROR'] . back_link($this->u_action . "&amp;c=$category_id"), E_USER_WARNING);
				}
			break;
			case 'update':
				require('includes/pclzip.lib.' . $phpEx);
				$newver = get_remote_file('www.phpAR.com', '/update', 'phpARversion.txt', $errstr, $errno);
				$curver = $user->lang['AR_VERSION'];
				$requestfile = 'http://www.phpAR.com/update/'.$curver.'-'.$newver.'.zip';
				$newfile = './phpARbeta.zip';
				if (@copy($requestfile, $newfile))
				{
					$archive = new PclZip($newfile);
					if (@$archive -> extract(PCLZIP_OPT_PATH, './'))
					{
						unlink($newfile);
						header("Location: ../update.php");
					}
				}
			break;
			case 'resetratings':
				$rating_id = array();
				$game_id = array();
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_ratings';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$rating_id[$row['rating_id']] = $row['rating_id'];
				}
				foreach ($rating_id as $rid)
				{
					$sql = 'DELETE FROM ' . $db_prefix . '_ar_ratings WHERE rating_id = ' . (int) $rid;
					$db->sql_query($sql);
				}
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_games';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$game_id[$row['game_id']] = $row['game_id'];
				}
				foreach ($game_id as $gid)
				{
					$sql_ary = array(
						'game_rating'		=> 0,
						'game_num_ratings'	=> 0
					);
					$sql = 'UPDATE ' . $db_prefix . '_ar_games 
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE game_id = ' . (int) $gid;
					$db->sql_query($sql);
				}
				trigger_error($user->lang['RATINGS_RESET'] . back_link($this->u_action));
			break;
			case 'resetratingsgame':
				$rating_id = array();
				$game_id = array();
				$gid = request_var('g', 0);
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_ratings';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$rating_id[$row['rating_id']] = $row['rating_id'];
				}
				foreach ($rating_id as $rid)
				{
					$sql = 'DELETE FROM ' . $db_prefix . '_ar_ratings WHERE rating_id = ' . (int) $rid . ' AND rating_game = ' . (int) $gid;
					$db->sql_query($sql);
				}
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_games
					WHERE game_id = ' . (int) $gid;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$game_id[$row['game_id']] = $row['game_id'];
				}
				foreach ($game_id as $gid)
				{
					$sql_ary = array(
						'game_rating'		=> 0,
						'game_num_ratings'	=> 0
					);
					$sql = 'UPDATE ' . $db_prefix . '_ar_games 
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE game_id = ' . (int) $gid;
					$db->sql_query($sql);
				}
				trigger_error($user->lang['RATING_RESET'] . back_link($this->u_action));
			break;
			case 'resethighscores':
				$highscore_id = array();
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_highscores';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$sql = 'DELETE FROM ' . $db_prefix . '_ar_highscores WHERE highscore_id = ' . $row['highscore_id'];
					$db->sql_query($sql);
				}
				trigger_error($user->lang['HIGHSCORES_RESET'] . back_link($this->u_action));
			break;
			case 'resethighscoresgame':
				$highscore_id = array();
				$gid = request_var('g', 0);
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_highscores';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$sql = 'DELETE FROM ' . $db_prefix . '_ar_highscores WHERE highscore_id = ' . $row['highscore_id'] . ' AND highscore_game = ' . (int) $gid;
					$db->sql_query($sql);
				}
				trigger_error($user->lang['HIGHSCORE_RESET'] . back_link($this->u_action));
			break;
			case 'resetviews':
				$sql = 'SELECT game_id
					FROM ' . $db_prefix . '_ar_games';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$sql_ary = array(
						'game_plays'		=> 0
					);
					$sql = 'UPDATE ' . $db_prefix . '_ar_games 
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE game_id = ' . (int) $row['game_id'];
					$db->sql_query($sql);
				}
				trigger_error($user->lang['VIEWS_RESET'] . back_link($this->u_action));
			break;
			case 'resetviewsgame':
				$gid = request_var('g', 0);
				$sql_ary = array(
					'game_plays'		=> 0
				);
				$sql = 'UPDATE ' . $db_prefix . '_ar_games 
					SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE game_id = ' . (int) $gid;
				$db->sql_query($sql);
				trigger_error($user->lang['VIEW_RESET'] . back_link($this->u_action));
			break;
			case 'deletecategory':
				$category_id = request_var('c', 0);
				$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_category = ' . (int) $category_id;
				$result = $db->sql_query($sql);
				$row_count = (int) $db->sql_fetchfield('row_count');
				if ($row_count)
				{
					trigger_error($user->lang['CAT_HAS_GAMES'] . back_link($this->u_action), E_USER_WARNING);
				}
				else
				{
					$sql = 'DELETE
						FROM ' . $db_prefix . '_ar_categories
						WHERE category_id = ' . (int) $category_id;
					$db->sql_query($sql);
					trigger_error($user->lang['CATEGORY_REMOVED'] . back_link($this->u_action));
				}
				$db->sql_freeresult($result);
			break;
			case 'deletegame':
				$game_id = request_var('g', 0);
				// Grab game details for deleting the flash and image files
				$sql = 'SELECT game_image, game_filename
					FROM ' . $db_prefix . '_ar_games
					WHERE game_id = ' . (int) $game_id;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$addurl = $this->u_action;
					$gamefile = "flash/" . $row['game_filename']; 
					unlink($gamefile);
					if ($row['game_image'] != 'no_image.gif')
					{
						$imagefile = "flash/images/" . $row['game_image'];
						unlink($imagefile);
					}
				}
				$db->sql_freeresult($result);
				// Delete the game
				$sql = 'DELETE
					FROM ' . $db_prefix . '_ar_games
					WHERE game_id = ' . (int) $game_id;
				$db->sql_query($sql);
				// Delete all highscores for game
				$sql = 'DELETE
					FROM ' . $db_prefix . '_ar_highscores
					WHERE highscore_game = ' . (int) $game_id;
				$db->sql_query($sql);
				// Delete game from favorites
				$sql = 'DELETE
					FROM ' . $db_prefix . '_ar_favorites
					WHERE favorite_game = ' . (int) $game_id;
				$db->sql_query($sql);
				// Delete game from played lists
				$sql = 'SELECT played_id, played_games
					FROM ' . $db_prefix . '_ar_played';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$new_played_games = array();
					$played_games = explode('-', $row['played_games']);
					foreach($played_games as $value)
					{
						if ($value != $game_id)
						{
							array_push($new_played_games, $value);
						}
					}
					$new_played_list = implode('-', $new_played_games);
					$sql_ary = array(
						'played_games'		=> $new_played_list
					);
					$sql = 'UPDATE ' . $db_prefix . '_ar_played 
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE played_id = ' . (int) $row['played_id'];
					$db->sql_query($sql);
				}
				trigger_error($user->lang['GAME_REMOVED'] . back_link($this->u_action));
			break;
			case 'addcategory':
				$category_name = request_var('category_name', '');
				// Grab game details for category display
				$sql_ary = array(
					'category_name'			=> $category_name,
				);
				$sql = 'INSERT INTO ' . $db_prefix . '_ar_categories ' . $db->sql_build_array('INSERT', $sql_ary);
				//echo $sql;
				$db->sql_query($sql);
				trigger_error($user->lang['CATEGORY_ADDED'] . back_link($this->u_action));
			break;
			case 'editcategory':
				$category_name = request_var('category_name', '');
				$category_id = request_var('category_id', '');
				$sql_ary = array(
					'category_name'		=> $category_name
				);
				$sql = 'UPDATE ' . $db_prefix . '_ar_categories 
					SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE category_id = ' . (int) $category_id;
				$db->sql_query($sql);
				trigger_error($user->lang['CATEGORY_UPDATED'] . back_link($this->u_action));
			break;
			case 'addgame':
				$category_id = request_var('c', 0);
				$game_name = request_var('game_name', '');
				// Grab game details for category display
				$sql = 'SELECT category_id, category_name
					FROM ' . $db_prefix . '_ar_categories
					ORDER BY category_name';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$url = $this->u_action . "&amp;c={$row['category_id']}";
					
					$extra = '';
					if ($category_id == $row['category_id'])
					{
						$extra = ' selected="selected"';
					}
					
					// Send vars to template
					$template->assign_block_vars('categoryrow', array(
							'CATEGORY_CODE'	=> '<option value="' . $row['category_id'] .'"' . $extra . '>' . $row['category_name'] . '</option>'
					));
				}
				$db->sql_freeresult($result);
				$url = $this->u_action . "&amp;c=$category_id";
				$template->assign_var('S_ADD_GAME', true);
				
				$files = array();
				$files = dir_get_files('flash/');
				foreach ($files as $file)
				{
					$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . "_ar_games WHERE game_filename = '$file'";
					$result = $db->sql_query($sql);
					$row_count = (int) $db->sql_fetchfield('row_count');
					if(get_file_type($file) == 'swf' && !$row_count)
					{
						$template->assign_block_vars('swfrow', array(
								'FILE'		=> $file
						));
					}
				}
				
				$template->assign_vars(array(
					'L_GAME_NAME'	=>	$game_name,
					'L_CATEGORY_ID'	=>	$category_id,
					'L_GAME_HEIGHT'	=>	'',
					'L_GAME_WIDTH'	=>	'',
					'L_GAME_DIR'	=>	'',
					'L_GAME_DESC'	=>	'',
				));
				$sync = true;
			break;
			case 'addgameinfo':
				$errors = false;
				$error_message = '';
				$game_file_name = file_temp_name('.swf');
				$uploadgamespot = "flash/" . $game_file_name; 
				$game_image_type = get_file_type($_FILES['game_image']['name']);
				$image_file_name = file_temp_name('.' . $game_image_type);
				$uploadimagespot = "flash/images/" . $image_file_name;
				if (file_exists($uploadgamespot) && $uploadgamespot != "flash/")
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['GAME_DUP'] . '<br />'
					));
				}
				if (file_exists($uploadimagespot) && $uploadimagespot != "flash/images/")
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['GAME_DUP'] . '<br />'
					));
				}
				$game_swf_file = request_var('game_swf_file', '');
				$game_file_type = get_file_type($_FILES['game_file']['name']);
				if ($_FILES['game_file']['name'] == '' && $game_swf_file == '')
				{
				$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['UP_GAME'] . '<br />'
					));
				}
				elseif ($game_file_type != 'swf' && $game_swf_file == '')
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['WRONG_GAME_TYPE'] . '<br />'
					));
				}
				if ($game_image_type != 'gif' && $game_image_type != 'jpeg' && $game_image_type != 'jpg' && $game_image_type != 'png' && $_FILES['game_image']['name'] != '')
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['WRONG_IMAGE_TYPE'] . '<br />'
					));
				}
				//die(print_r($_FILES));
				$info = @getimagesize($_FILES['game_image']['tmp_name']);
				$thumb_create = false;
				if ($info[0] > 50 || $info[1] > 50)
				{
					$thumb_create = true;
				}
				$game_name = request_var('game_name', '');
				if (!$game_name)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_NAME'] . '<br />'
					));
				}
				$game_enabled = request_var('game_enabled', 0);
				if ($game_enabled != 1)
				{
					$game_enabled = 0;
				}
				$game_highscore = request_var('game_highscore', 0);
				if ($game_highscore != 1)
				{
					$game_highscore = 0;
				}
				$game_rev_score = request_var('game_rev_score', 0);
				if ($game_rev_score != 1)
				{
					$game_rev_score = 0;
				}
				$game_keyboard = request_var('game_keyboard', 0);
				if ($game_keyboard != 1)
				{
					$game_keyboard = 0;
				}
				$game_mouse = request_var('game_mouse', 0);
				if ($game_mouse != 1)
				{
					$game_mouse = 0;
				}
				$game_height = request_var('game_height', '');
				if (!$game_height)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_HEIGHT'] . '<br />'
					));
				}
				$game_width = request_var('game_width', '');
				if (!$game_width)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_WIDTH'] . '<br />'
					));
				}
				$game_dir = request_var('game_dir', '');
				if (!$game_dir)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_DIR'] . '<br />'
					));
				}
				$game_cat = request_var('game_cat', '');
				if (!$game_cat)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_CAT'] . '<br />'
					));
				}
				$game_desc = request_var('game_desc', '');
				if (!$game_desc)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_DESC'] . '<br />'
					));
				}
				$game_cat = request_var('game_cat', '');
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_categories
					WHERE category_id = ' . (int) $game_cat;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$game_cat = $row['category_name'];
				}
				$db->sql_freeresult($result);
				if (!$errors)
				{
					//die('hold');
					if(move_uploaded_file($_FILES['game_file']['tmp_name'], $uploadgamespot) || copy('flash/' . $game_swf_file, $uploadgamespot))
					{
						if ($game_swf_file)
						{
							unlink('flash/' . $game_swf_file);
						}
						if($_FILES['game_image']['name'] != '')
						{
							if ($thumb_create != true)
							{
								if(!move_uploaded_file($_FILES['game_image']['tmp_name'], $uploadimagespot))
								{
									$template->assign_vars(array(
										'L_GAME_ERROR'	=>	$user->lang['ERROR_IMAGE']
									));
									$template->assign_var('S_ERROR', true);
								}
							}
							else
							{
								$sresult = create_thumb($_FILES['game_image']['tmp_name'], $uploadimagespot, 50);
							}
						}
						else
						{
							$image_file_name = 'no_image.gif';
						}
						$game_name = request_var('game_name', '');
						$template->assign_vars(array(
							'L_GAME_NAME'	=>	$game_name,
							'L_GAME_HEIGHT'	=>	$game_height,
							'L_GAME_WIDTH'	=>	$game_width,
							'L_GAME_DIR'	=>	$game_dir,
							'L_GAME_DESC'	=>	$game_desc,
							'L_GAMECAT'		=>	$game_cat,
						));

						$game_cat = request_var('game_cat', '');
						$sql_ary = array(
							'game_name'			=> $game_name,
							'game_image'		=> $image_file_name,
							'game_directions'	=> $game_dir,
							'game_description'	=> $game_desc,
							'game_category'		=> $game_cat,
							'game_filename'		=> $game_file_name,
							'game_width'		=> $game_width,
							'game_height'		=> $game_height,
							'game_enabled'		=> $game_enabled,
							'game_highscore'	=> $game_highscore,
							'game_rev_score'	=> $game_rev_score,
							'game_keyboard'		=> $game_keyboard,
							'game_mouse'		=> $game_mouse
						);
						$sql = 'INSERT INTO ' . $db_prefix . '_ar_games ' . $db->sql_build_array('INSERT', $sql_ary);
						$db->sql_query($sql);
						$game_cat = request_var('game_cat', '');
						// Grab game details for category display
						trigger_error($user->lang['GAME_ADDED'] . back_link($this->u_action . "&amp;c=$game_cat"));
					}
					else
					{
						$template->assign_vars(array(
							'L_GAME_ERROR'	=>	$user->lang['ERROR_GAME']
						));
						$template->assign_var('S_ERROR', true);
					}
				}
				else
				{
					$template->assign_var('S_ADD_GAME', true);
					$template->assign_var('S_ERROR', true);
					$category_id = request_var('c', 0);
					$game_name = request_var('game_name', '');
					// Grab game details for category display
					$sql = 'SELECT category_id, category_name
						FROM ' . $db_prefix . '_ar_categories
						ORDER BY category_name';
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$url = $this->u_action . "&amp;c={$row['category_id']}";
						
						$extra = '';
						if ($category_id == $row['category_id'])
						{
							$extra = ' selected="selected"';
						}
						
						// Send vars to template
						$template->assign_block_vars('categoryrow', array(
								'CATEGORY_CODE'	=> '<option value="' . $row['category_id'] .'"' . $extra . '>' . $row['category_name'] . '</option>'
						));
					}
					$db->sql_freeresult($result);
					$url = $this->u_action . "&amp;c=$category_id";
					
					$files = array();
					$files = dir_get_files('flash/');
					foreach ($files as $file)
					{
						$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . "_ar_games WHERE game_filename = '$file'";
						$result = $db->sql_query($sql);
						$row_count = (int) $db->sql_fetchfield('row_count');
						if(get_file_type($file) == 'swf' && !$row_count)
						{
							$template->assign_block_vars('swfrow', array(
								'FILE'		=> $file,
								'SELECTED'	=> ($game_swf_file == $file) ? true : false
							));
						}
					}
					
					$template->assign_vars(array(
						'L_GAME_NAME'		=>	$game_name,
						'L_GAME_HEIGHT'		=>	$game_height,
						'L_GAME_WIDTH'		=>	$game_width,
						'L_GAME_DIR'		=>	$game_dir,
						'L_GAME_DESC'		=>	$game_desc,
						'L_GAMECAT'			=>	$game_cat,
						'L_GAME_ERROR'		=>	$error_message,
						'S_ENABLED'			=>	$game_enabled,
						'S_HIGHSCORE'		=>	$game_highscore,
						'S_REV_SCORE'		=>	$game_rev_score,
						'S_KEYBOARD'		=>	$game_keyboard,
						'S_MOUSE'			=>	$game_mouse
					));
				}
				$sync = true;
			break;
			case 'enable_disable':
				$category_id = request_var('c', '');
				$game_id = request_var('g', '');
				$game_enabled = request_var('ed', '');
				$sql_ary = array(
					'game_enabled'		=> ($game_enabled == 'true') ? 1 : 0,
				);
				$sql = 'UPDATE ' . $db_prefix . '_ar_games 
					SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE game_id = ' . (int) $game_id;
				$db->sql_query($sql);
				
				if ($game_enabled == 'true')
				{
					trigger_error($user->lang['GAME_ENABLED'] . back_link($this->u_action . "&amp;c=$category_id"));
				}
				else
				{
					trigger_error($user->lang['GAME_DISABLED'] . back_link($this->u_action . "&amp;c=$category_id"));
				}
			break;
			case 'editgameinfo':
				$errors = false;
				$error_message = '';
				$game_cat = request_var('game_cat', '');
				$game_id = request_var('g', 0);
				$game_image_type = get_file_type($_FILES['game_image']['name']);
				$image_file_name = file_temp_name('.' . $game_image_type);
				$uploadimagespot = "flash/images/" . $image_file_name;
				if ($game_image_type != 'gif' && $game_image_type != 'jpeg' && $game_image_type != 'jpg' && $game_image_type != 'png' && $_FILES['game_image']['name'] != '')
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['WRONG_IMAGE_TYPE'] . '<br />'
					));
				}
				$info = @getimagesize($_FILES['game_image']['tmp_name']);
				$thumb_create = false;
				if ($info[0] > 50 || $info[1] > 50)
				{
					$thumb_create = true;
				}
				$remove_image = request_var('remove_image', '');
				if (!$remove_image)
				{
					$remove_image = 0;
				}
				$game_name = request_var('game_name', '');
				if (!$game_name)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_NAME'] . '<br />'
					));
				}
				$game_enabled = request_var('game_enabled', 0);
				if ($game_enabled != 1)
				{
					$game_enabled = 0;
				}
				$game_highscore = request_var('game_highscore', 0);
				if ($game_highscore != 1)
				{
					$game_highscore = 0;
				}
				$game_rev_score = request_var('game_rev_score', 0);
				if ($game_rev_score != 1)
				{
					$game_rev_score = 0;
				}
				$game_keyboard = request_var('game_keyboard', 0);
				if ($game_keyboard != 1)
				{
					$game_keyboard = 0;
				}
				$game_mouse = request_var('game_mouse', 0);
				if ($game_mouse != 1)
				{
					$game_mouse = 0;
				}
				$game_height = request_var('game_height', '');
				if (!$game_height)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_HEIGHT'] . '<br />'
					));
				}
				$game_width = request_var('game_width', '');
				if (!$game_width)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_WIDTH'] . '<br />'
					));
				}
				$game_cat = request_var('game_cat', '');
				if (!$game_cat)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_CAT'] . '<br />'
					));
				}
				$game_dir = request_var('game_dir', '');
				if (!$game_dir)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_DIR'] . '<br />'
					));
				}
				$game_desc = request_var('game_desc', '');
				if (!$game_desc)
				{
					$errors = true;
					$template->assign_vars(array(
						$error_message = $error_message . $user->lang['SPECIFY_DESC'] . '<br />'
					));
				}
				if (!$errors)
				{
					if($_FILES['game_image']['name'] != '' && $remove_image == 0)
					{
						if ($thumb_create != true)
						{
							if(!move_uploaded_file($_FILES['game_image']['tmp_name'], $uploadimagespot))
							{
								$template->assign_vars(array(
									'L_GAME_ERROR'	=>	$user->lang['ERROR_IMAGE']
								));
								$template->assign_var('S_ERROR', true);
							}
						}
						else
						{
							$sresult = create_thumb($_FILES['game_image']['tmp_name'], $uploadimagespot, 50);
						}
						$sql = 'SELECT game_image
							FROM ' . $db_prefix . '_ar_games
							WHERE game_id = ' . (int) $game_id;
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							if ($row['game_image'] != 'no_image.gif')
							{
								$imagefile = "flash/images/" . $row['game_image'];
								unlink($imagefile);
							}
						}
						$db->sql_freeresult($result);
					}
					elseif ($_FILES['game_image']['name'] != '')
					{
						$image_file_name = 'no_image.gif';
						$sql = 'SELECT game_image
							FROM ' . $db_prefix . '_ar_games
							WHERE game_id = ' . (int) $game_id;
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							if ($row['game_image'] != 'no_image.gif')
							{
								$imagefile = "flash/images/" . $row['game_image'];
								unlink($imagefile);
							}
						}
						$db->sql_freeresult($result);
					}
					else
					{
						$sql = 'SELECT game_image
							FROM ' . $db_prefix . '_ar_games
							WHERE game_id = ' . (int) $game_id;
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							$image_file_name = $row['game_image'];
						}
						$db->sql_freeresult($result);
					}
					$sql_ary = array(
						'game_name'			=> $game_name,
						'game_directions'	=> $game_dir,
						'game_description'	=> $game_desc,
						'game_image'		=> $image_file_name,
						'game_category'		=> $game_cat,
						'game_width'		=> $game_width,
						'game_height'		=> $game_height,
						'game_enabled'		=> $game_enabled,
						'game_highscore'	=> $game_highscore,
						'game_rev_score'	=> $game_rev_score,
						'game_keyboard'		=> $game_keyboard,
						'game_mouse'		=> $game_mouse
					);
					$sql = 'UPDATE ' . $db_prefix . '_ar_games 
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE game_id = ' . (int) $game_id;
					$db->sql_query($sql);
					$game_cat = request_var('game_cat', '');
					$sql = 'SELECT *
						FROM ' . $db_prefix . '_ar_categories
						WHERE category_id = ' . (int) $game_cat;
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$game_cat = $row['category_name'];
					}
					$db->sql_freeresult($result);
					$template->assign_vars(array(
						'L_GAME_NAME'	=>	$game_name,
						'L_GAME_HEIGHT'	=>	$game_height,
						'L_GAME_WIDTH'	=>	$game_width,
						'L_GAME_DIR'	=>	$game_dir,
						'L_GAME_DESC'	=>	$game_desc,
						'L_GAMECAT'		=>	$game_cat,
					));
					$game_cat = request_var('game_cat', '');
					trigger_error($user->lang['GAME_SAVED'] . back_link($this->u_action . "&amp;c=$game_cat"));
				}
				else
				{
					$template->assign_var('S_EDIT_GAME', true);
					$template->assign_var('S_ERROR', true);
					$game_id = request_var('g', 0);
					// Grab game details for game display
					$sql = 'SELECT *
						FROM ' . $db_prefix . '_ar_games
						WHERE game_id = ' . (int) $game_id;
					$result = $db->sql_query($sql);

					while ($row = $db->sql_fetchrow($result))
					{
						$category_id = $row['game_category'];
					}
					$db->sql_freeresult($result);
					// Grab game details for category display
					$sql = 'SELECT category_id, category_name
						FROM ' . $db_prefix . '_ar_categories
						ORDER BY category_name';
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$url = $this->u_action . "&amp;c={$row['category_id']}";
						
						$extra = '';
						if ($category_id == $row['category_id'])
						{
							$extra = ' selected="selected"';
						}
						
						// Send vars to template
						$template->assign_block_vars('categoryrow', array(
								'CATEGORY_CODE'	=> '<option value="' . $row['category_id'] .'"' . $extra . '>' . $row['category_name'] . '</option>'
						));
					}
					$db->sql_freeresult($result);
					$template->assign_vars(array(
						'L_GAME_NAME'		=>	$game_name,
						'L_GAME_HEIGHT'		=>	$game_height,
						'L_GAME_WIDTH'		=>	$game_width,
						'L_GAME_DIR'		=>	$game_dir,
						'L_GAME_DESC'		=>	$game_desc,
						'L_GAME_ERROR'		=>	$error_message,
						'S_ENABLED'			=>	$game_enabled,
						'S_HIGHSCORE'		=>	$game_highscore,
						'S_REV_SCORE'		=>	$game_rev_score,
						'S_REMOVE_IMAGE'	=>	$remove_image,
						'S_REV_SCORE'		=>	$game_rev_score,
						'S_KEYBOARD'	=>	$game_keyboard,
						'S_MOUSE'		=>	$game_mouse
					));
				}
				$sync = true;
			break;
			case 'updatesettings':
				$value = request_var('1', 0);
				$sql = 'UPDATE ' . $db_prefix . "_ar_settings SET setting_value = $value WHERE setting_id = 1";
				$db->sql_query($sql);
				$value = request_var('2', 0);
				$sql = 'UPDATE ' . $db_prefix . "_ar_settings SET setting_value = $value WHERE setting_id = 2";
				$db->sql_query($sql);
				$value = request_var('3', 0);
				$sql = 'UPDATE ' . $db_prefix . "_ar_settings SET setting_value = $value WHERE setting_id = 3";
				$db->sql_query($sql);
				$value = request_var('4', 0);
				$sql = 'UPDATE ' . $db_prefix . "_ar_settings SET setting_value = $value WHERE setting_id = 4";
				$db->sql_query($sql);
				$value = request_var('5', 0);
				$sql = 'UPDATE ' . $db_prefix . "_ar_settings SET setting_value = $value WHERE setting_id = 5";
				$db->sql_query($sql);
				trigger_error($user->lang['SETTINGS_UPDATED'] . back_link($this->u_action));
			break;
			case 'highscoreedit':
				$gid = request_var('gid', 0);
				$hid = request_var('hid', 0);
				$newhighscore = request_var('newhighscore', 0);
				$sql = 'UPDATE ' . $db_prefix . "_ar_highscores SET highscore = $newhighscore WHERE highscore_id = $hid";
				$db->sql_query($sql);

				
				
				
				
				
				function send_trophy_pm($message_content, $to_user_id)
				{	
					// note that multibyte support is enabled here 
					$subject	= utf8_normalize_nfc('Trophy Lost');
					$message	= utf8_normalize_nfc($message_content);
					
					// variables to hold the parameters for submit_pm
					$poll = $uid = $bitfield = $options = ''; 
					generate_text_for_storage($subject, $uid, $bitfield, $options, false, false, false);
					generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);
					
					$data = array( 
						'address_list'		=> array ('u' => array($to_user_id => 'to')),
						'from_user_id'		=> 2,
						'from_username'		=> 'arcade',
						'icon_id'			=> 0,
						'from_user_ip'		=> '127.0.0.1',
						 
						'enable_bbcode'		=> true,
						'enable_smilies'	=> true,
						'enable_urls'		=> true,
						'enable_sig'		=> false,
					
						'message'			=> $message,
						'bbcode_bitfield'	=> $bitfield,
						'bbcode_uid'		=> $uid,
					);
					
					submit_pm('post', $subject, $data, false);
				}
				
				include_once('include/ucp/functions_privmsgs.' . $phpEx);
				
				// Check if game can be has reverse scoring
				$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_id = ' . $gid . ' AND game_rev_score = 1';
				$result = $db->sql_query($sql);
				$row_count = (int) $db->sql_fetchfield('row_count');
				if ($row_count)
				{
					$rev_scoring = 'ASC';
				}
				else
				{
					$rev_scoring = 'DESC';
				}
				
				$sql = 'SELECT highscore_user, highscore
					FROM ' . $db_prefix . '_ar_highscores
					WHERE highscore_game = ' . $gid . '
					ORDER BY highscore ' . $rev_scoring;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					@$highscores[$row['highscore_user']][sizeof($highscores[$row['highscore_user']])] = str_replace('.0', '', $row['highscore']);
				}
				if (@$highscores)
				{
					$top_ids = array();
					foreach($highscores as $key => $value)
					{
						$top_ids[sizeof($top_ids)] = $key;
					}
				}
				unset($highscores);
				
				// Grab info to see if trophies exist for this game
				$sql = 'SELECT COUNT(trophy_game) AS row_count FROM ' . $db_prefix . "_ar_trophies WHERE trophy_game = $gid";
				$result = $db->sql_query($sql);
				$row_count = (int) $db->sql_fetchfield('row_count');
				$db->sql_freeresult($result);
				
				if ($row_count > 0)
				{
					$sql = 'SELECT trophy_user_gold, trophy_user_silver, trophy_user_bronze
						FROM ' . $db_prefix . '_ar_trophies
						WHERE trophy_game = ' . $gid;
					$result = $db->sql_query($sql);
					while ($row = $db->sql_fetchrow($result))
					{
						$old_ids[0] = $row['trophy_user_gold'];
						$old_ids[1] = $row['trophy_user_silver'];
						$old_ids[2] = $row['trophy_user_bronze'];
					}
				}
				
				if (sizeof($top_ids) > 2 && $row_count == 0)
				{
					$sql_ary = array(
						'trophy_game'			=> $gid,
						'trophy_user_gold'		=> $top_ids[0],
						'trophy_user_silver'	=> $top_ids[1],
						'trophy_user_bronze'	=> $top_ids[2],
					);
					$sql = 'INSERT INTO ' . $db_prefix . '_ar_trophies ' . $db->sql_build_array('INSERT', $sql_ary);
					$db->sql_query($sql);
				}
				elseif (sizeof($top_ids) > 2 && $row_count > 0)
				{
					$sql_ary = array(
						'trophy_user_gold'		=> $top_ids[0],
						'trophy_user_silver'	=> $top_ids[1],
						'trophy_user_bronze'	=> $top_ids[2],
					);
					
					$sql = 'UPDATE ' . $db_prefix . '_ar_trophies
						SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE trophy_game = ' . (int) $gid;
					$db->sql_query($sql);
				}
				
				$sql = 'SELECT game_name
					FROM ' . $db_prefix . '_ar_games
					WHERE game_id = ' . (int) $gid;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$game_name = $row['game_name'];
				$db->sql_freeresult($result);
				
				$path = explode('adm', $_SERVER["PHP_SELF"]);
				$url_loc = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "viewgame.$phpEx?g=" . $gid;
				
				$game_loc = '[url=' . $url_loc . ']' . $game_name . '[/url]';
				
				$images_path = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "flash/images/included/";
				
				$pm_gold = '[img]' . $images_path . 'trophy_gold.gif[/img]';
				$pm_silver = '[img]' . $images_path . 'trophy_silver.gif[/img]';
				$pm_bronze = '[img]' . $images_path . 'trophy_bronze.gif[/img]';
				
				if (isset($old_ids))
				{
					include_once('include/ucp/functions_privmsgs.' . $phpEx);
					if ($top_ids[0] != $old_ids[0])
					{
						$sql = 'SELECT username, user_colour
							FROM ' . $db_prefix . '_users
							WHERE id = ' . (int) $top_ids[0];
						$result2 = $db->sql_query($sql);
						$row2 = $db->sql_fetchrow($result2);
						$db->sql_freeresult($result2);
						
						$url_loc2 = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "user.php?op=profile&id=" . $top_ids[0];
						if ($row2['user_colour'])
						{
							$user_loc = '[b][url=' . $url_loc2 . '][color=#' . $row2['user_colour'] . ']' . $row2['username'] . '[/color][/url][/b]';
						}
						else
						{
							$user_loc = '[b][url=' . $url_loc2 . ']' . $row2['username'] . '[/url][/b]';
						}
						$pm_message = $user->lang['ARCADE_PM_ONE'] . $pm_gold . $user->lang['ARCADE_PM_TWO'] . $user_loc . $user->lang['ARCADE_PM_THREE'] . $newhighscore . $user->lang['ARCADE_PM_FOUR'] . $game_loc;
						send_trophy_pm($pm_message, $old_ids[0]);
						unset($pm_message);
					}
					if ($top_ids[1] != $old_ids[1])
					{
						if ($old_ids[1] != $top_ids[0])
						{
							if (!isset($user_loc))
							{
								$sql = 'SELECT username, user_colour
									FROM ' . $db_prefix . '_users
									WHERE id = ' . (int) $top_ids[1];
								$result2 = $db->sql_query($sql);
								$row2 = $db->sql_fetchrow($result2);
								$db->sql_freeresult($result2);
								
								$url_loc2 = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "user.php?op=profile&id=" . $top_ids[1];
								if ($row2['user_colour'])
								{
									$user_loc = '[b][url=' . $url_loc2 . '][color=#' . $row2['user_colour'] . ']' . $row2['username'] . '[/color][/url][/b]';
								}
								else
								{
									$user_loc = '[b][url=' . $url_loc2 . ']' . $row2['username'] . '[/url][/b]';
								}
							}
							$pm_message = $user->lang['ARCADE_PM_ONE'] . $pm_silver . $user->lang['ARCADE_PM_TWO'] . $user_loc . $user->lang['ARCADE_PM_THREE'] . $newhighscore . $user->lang['ARCADE_PM_FOUR'] . $game_loc;
							send_trophy_pm($pm_message, $old_ids[1]);
							unset($pm_message);
						}
					}
					if ($top_ids[2] != $old_ids[2])
					{
						if ($old_ids[2] != $top_ids[0] && $old_ids[2] != $top_ids[1])
						{
							if (!isset($user_loc))
							{
								$sql = 'SELECT username, user_colour
									FROM ' . $db_prefix . '_users
									WHERE id = ' . (int) $top_ids[2];
								$result2 = $db->sql_query($sql);
								$row2 = $db->sql_fetchrow($result2);
								$db->sql_freeresult($result2);
								
								$url_loc2 = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "user.php?op=profile&id=" . $top_ids[2];
								if ($row2['user_colour'])
								{
									$user_loc = '[b][url=' . $url_loc2 . '][color=#' . $row2['user_colour'] . ']' . $row2['username'] . '[/color][/url][/b]';
								}
								else
								{
									$user_loc = '[b][url=' . $url_loc2 . ']' . $row2['username'] . '[/url][/b]';
								}
							}
							
							$pm_message = $user->lang['ARCADE_PM_ONE'] . $pm_bronze . $user->lang['ARCADE_PM_TWO'] . $user_loc . $user->lang['ARCADE_PM_THREE'] . $newhighscore . $user->lang['ARCADE_PM_FOUR'] . $game_loc;
							send_trophy_pm($pm_message, $old_ids[2]);
							unset($pm_message);
						}
					}
				}
				
				
				
				
				
				
				
				
				trigger_error($user->lang['HIGHSCORE_UPDATED'] . back_link($this->u_action . "&amp;action=managehighscores&amp;g=$gid"));
			break;
			case 'highscoredelete':
				$gid = request_var('g', 0);
				$hid = request_var('hid', 0);
				$sql = 'DELETE FROM ' . $db_prefix . "_ar_highscores WHERE highscore_id = $hid";
				$db->sql_query($sql);
				trigger_error($user->lang['HIGHSCORE_DELETED'] . back_link($this->u_action . "&amp;action=managehighscores&amp;g=$gid"));
			break;
			case 'managehighscores':
				$game_id = request_var('g', 0);
				
				$template->set_filenames(array(
					'body' => 'viewgame_body.html'
				));
				
				$sql = 'SELECT game_name
					FROM ' . $db_prefix . '_ar_games
					WHERE game_id = ' . (int) $game_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$game_name = $row['game_name'];
				$db->sql_freeresult($result);
				
				// Check if game can be has reverse scoring
				$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_id = ' . $game_id . ' AND game_rev_score = 1';
				$result = $db->sql_query($sql);
				$row_count = (int) $db->sql_fetchfield('row_count');
				if ($row_count)
				{
					$rev_scoring = 'ASC';
				}
				else
				{
					$rev_scoring = 'DESC';
				}
				
				$sql = 'SELECT highscore_id, highscore, highscore_user
					FROM ' . $db_prefix . '_ar_highscores
					WHERE highscore_game = ' . $game_id . '
					ORDER BY highscore ' . $rev_scoring;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$sql = 'SELECT username, user_colour
						FROM ' . $db_prefix . '_users
						WHERE id = ' . (int) $row['highscore_user'];
					$result2 = $db->sql_query($sql);
					$row2 = $db->sql_fetchrow($result2);
					$username = get_username_string('full', $row['highscore_user'], $row2['username'], $row2['user_colour'], $row2['username']);
					$db->sql_freeresult($result2);
				
					@$highscores[$username][sizeof($highscores[$username])] = str_replace('.0', '', $row['highscore']);
					$highscore_ids[$username][str_replace('.0', '', $row['highscore'])] = $row['highscore_id'];
				}
				if (@$highscores)
				{
					$row_count = 0;
					foreach($highscores as $key => $value)
					{
						
						foreach($highscores[$key] as $key2 => $value2)
						{
							$row_count++;
							$url = $this->u_action . "&amp;action=highscoredelete&amp;g=" . $game_id . "&amp;hid=" . $highscore_ids[$key][$value2];
							// Send vars to template
							$template->assign_block_vars('scorerow', array(
									'ID'		=> $highscore_ids[$key][$value2],
									'COUNT'		=> $row_count,
									'USER'		=> $key,
									'SCORE'		=> $value2,
									'U_DELETE'	=> $url
							));
						}
					}
				}
				$db->sql_freeresult($result);
				$template->assign_vars(array(
					'S_MANAGE_HIGHSCORES'	=> true,
					'GAME_NAME'				=> $game_name,
					'GAME_ID'				=> $game_id,
				));
				$sync = true;
			break;
		}

		switch ($mode)
		{
			case 'manage':
				if (!$sync)
				{
					$category_id = request_var('c', 0);
					$game_id = request_var('g', 0);
					if ($category_id == 0 && $game_id == 0)
					{
						// Grab game details for category display
						$sql = 'SELECT category_id, category_name
							FROM ' . $db_prefix . '_ar_categories
							ORDER BY category_name';
						$result = $db->sql_query($sql);
							
						$template->assign_var('S_MANAGE_CATEGORY', true);
						$template->assign_var('S_TITLE', $user->lang['CAT_MANAGE']);
						
						$fcount = 0;
						while ($row = $db->sql_fetchrow($result))
						{
							$url = $this->u_action . "&amp;c={$row['category_id']}";
							$view = append_sid("viewcategory.$phpEx", "c={$row['category_id']}", true, $user->session_id);
							
							// Grab game details for a total count for the category
							$sql = 'SELECT COUNT(game_category) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_category = ' . $row['category_id'];
							$result2 = $db->sql_query($sql);
							$row_count = (int) $db->sql_fetchfield('row_count');
							$db->sql_freeresult($result2);
							
							// Send vars to template
							$fcount = $fcount + 1;
							$template->assign_block_vars('categoryrow', array(
									'CATEGORY_ID'		=> $row['category_id'],
									'CATEGORY_NAME'		=> $row['category_name'],
									'CATEGORY_COUNT'	=> $row_count,
									'COUNT'				=> $fcount,
									'U_CATEGORY'		=> $url,
									'U_DELETE'			=> $url . '&amp;action=deletecategory',
									'U_ACTION'			=> $url,
									'U_VIEW_CATEGORY'	=> $view
							));
						}
						$db->sql_freeresult($result);
					}
					else if ($game_id == 0)
					{
						// Grab game details for category display
						$sql = 'SELECT category_name
							FROM ' . $db_prefix . '_ar_categories
							WHERE category_id = ' . (int) $category_id;
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							$template->assign_var('S_TITLE', $user->lang['GAME_MANAGE'] . ' &laquo; ' . $row['category_name']);
						}
						$db->sql_freeresult($result);
						// Grab game details for game display
						$sql = 'SELECT *
							FROM ' . $db_prefix . '_ar_games
							WHERE game_category = ' . (int) $category_id . '
							ORDER BY game_name';
						$result = $db->sql_query($sql);
	
						$template->assign_var('S_MANAGE_GAME', true);

						$fcount = 0;
						while ($row = $db->sql_fetchrow($result))
						{
							$has_highscore = false;
							// Check if game has highscore
							$sql6 = 'SELECT COUNT(highscore_id) AS row_count FROM ' . $db_prefix . '_ar_highscores WHERE highscore_game = ' . (int) $row['game_id'];
							$result6 = $db->sql_query($sql6);
							$scores_count = (int) $db->sql_fetchfield('row_count');
							if ($scores_count > 0)
							{
								$has_highscore = true;
							}
							
							$addurl = $this->u_action;
							$url = $this->u_action . "&amp;g={$row['game_id']}";
							$view = append_sid("viewgame.$phpEx", "g={$row['game_id']}", true, $user->session_id);
							
							// Send vars to template
							$fcount = $fcount + 1;
							$ed = ($row['game_enabled']) ? 'false' : 'true';
							$template->assign_block_vars('gamerow', array(
									'DISABLED'				=> ($row['game_enabled']) ? false : true,
									'GAME_ID'				=> $row['game_id'],
									'GAME_NAME'				=> $row['game_name'],
									'COUNT'					=> $fcount,
									'S_HAS_HIGHSCORE'		=> $has_highscore,
									'U_GAME'				=> $url,
									'U_DELETE'				=> $url . '&amp;action=deletegame',
									'U_MANAGE_HIGHSCORE'	=> $url . '&amp;action=managehighscores&amp;c=' . $row['game_category'],
									'U_ENABLE_DISABLE'		=> $url . '&amp;action=enable_disable&amp;c=' . $row['game_category'] . '&amp;ed=' . $ed,
									'U_VIEW_GAME'			=> $view
							));
						}
						$db->sql_freeresult($result);
						$files = array();
						$files = dir_get_files('flash/archives/');
						foreach ($files as $file)
						{
							if(get_file_type($file) == 'zip')
							{
								$template->assign_block_vars('archiverow', array(
										'FILE'		=> $file
								));
							}
						}
						$template->assign_vars(array(
							'U_ARCHIVE_ACTION'		=> $this->u_action . "&amp;c=$category_id&action=add_archive",
							'U_UPLOAD_ARCHIVE'		=> $this->u_action . "&amp;c=$category_id&action=upload_archive"
						));
					}
					else
					{
						//Check how many users favorited the game
						$sql = 'SELECT COUNT(favorite_id) AS row_count FROM ' . $db_prefix . '_ar_favorites WHERE favorite_game = ' . (int) $game_id;
						$result = $db->sql_query($sql);
						$fav_count = (int) $db->sql_fetchfield('row_count');
						$db->sql_freeresult($result);
						// Grab game details for game display
						$sql = 'SELECT *
							FROM ' . $db_prefix . '_ar_games
							WHERE game_id = ' . (int) $game_id;
						$result = $db->sql_query($sql);
	
						$template->assign_var('S_EDIT_GAME', true);

						while ($row = $db->sql_fetchrow($result))
						{
							$view = append_sid("viewgame.$phpEx", "g={$row['game_id']}", true, $user->session_id);
							$template->assign_vars(array(
								'L_GAME_NAME'			=> $row['game_name'],
								'L_GAME_HEIGHT'			=> $row['game_height'],
								'L_GAME_WIDTH'			=> $row['game_width'],
								'L_GAME_DIR'			=> $row['game_directions'],
								'L_GAME_DESC'			=> $row['game_description'],
								'S_ENABLED'				=> $row['game_enabled'],
								'S_HIGHSCORE'			=> $row['game_highscore'],
								'S_REV_SCORE'			=> $row['game_rev_score'],
								'S_KEYBOARD'			=> $row['game_keyboard'],
								'S_MOUSE'				=> $row['game_mouse'],
								'GAME_INFO_ID'			=> $row['game_id'],
								'GAME_INFO_IMAGE'		=> './flash/images/' . $row['game_image'],
								'GAME_INFO_IMAGENAME'	=> $row['game_image'],
								'GAME_INFO_FILENAME'	=> $row['game_filename'],
								'GAME_INFO_PLAYS'		=> $row['game_plays'],
								'GAME_INFO_RATING'		=> $row['game_rating'],
								'GAME_INFO_NUMRATINGS'	=> $row['game_num_ratings'],
								'GAME_INFO_NUMFAVS'		=> $fav_count,
								'GAME_INFO_SIZE'		=> get_file_size('./flash/' . $row['game_filename']),
								'U_VIEW_GAME'	=> $view
							));
							$category_id = $row['game_category'];
						}
						$db->sql_freeresult($result);
						// Grab game details for category display
						$sql = 'SELECT category_id, category_name
							FROM ' . $db_prefix . '_ar_categories
							ORDER BY category_name';
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							$url = $this->u_action . "&amp;c={$row['category_id']}";
							
							$extra = '';
							if ($category_id == $row['category_id'])
							{
								$extra = ' selected="selected"';
							}
							
							// Send vars to template
							$template->assign_block_vars('categoryrow', array(
									'CATEGORY_CODE'	=> '<option value="' . $row['category_id'] .'"' . $extra . '>' . $row['category_name'] . '</option>'
							));
						}
						$db->sql_freeresult($result);
					}
				}
			break;
			case 'settings':
			if (!$sync)
			{
				$dir = 'flash/';
				if (!is_writable($dir)) {
//chmod('flash/', 0777);
//chmod('flash/tmp/', 0777);
//chmod('flash/images/', 0777);
				}
				$viewfile = get_remote_file('www.phpar.com', '/update', 'phpARversion.txt', $errstr, $errno);
				if ($viewfile)
				{
					$curver = $user->lang['AR_VERSION'];
					$url = $this->u_action . "&amp;action=update";
					$updateinfo = ' <strong>' . $curver . '</strong> ' . $user->lang['OUT_OF_DATE'] . ' <strong>' . $viewfile . '</strong> ' . $user->lang['OUT_NOW'] . ' <br /><a href="'.$url.'" target="_blank">' . $user->lang['CLICK_UPDATE'] . '</a><br /><a href="http://www.phpar.com/viewtopic.php?f=6&t=3">' . $user->lang['CLICK_UPDATE_ALT'] . '</a>';
					if (version_compare($viewfile, $curver, '>'))
					{
						$template->assign_var('L_ARCADE_RESYNCED', $updateinfo);
						$template->assign_var('S_UPDATE', true);
					}
					else
					{
						$template->assign_var('L_ARCADE_RESYNCED', $user->lang['YOUR'] . ' <strong>' . $curver . '</strong> ' . $user->lang['UP_TO_DATE']);
						$template->assign_var('S_RESYNCED', false);
						$template->assign_var('S_NO_UPDATE', true);
					}
				}
				else
				{
					$template->assign_var('L_ARCADE_RESYNCED', $user->lang['SERVER_ERROR']);
					$template->assign_var('S_UPDATE', false);
				}
				
				$template->assign_var('L_NOTIFY', 'Update Notifications');
				$template->assign_var('S_SETTINGS', true);
				// Grab game details for category display
				$sql = 'SELECT *
					FROM ' . $db_prefix . '_ar_settings
					ORDER BY setting_id';
				$result = $db->sql_query($sql);
				
				while ($row = $db->sql_fetchrow($result))
				{
					$setting_type = 1;
					if ($row['setting_id'] == 5)
					{
						$setting_type = 2;
					}
					// Send vars to template
					$template->assign_block_vars('settingrow', array(
							'ID'		=> $row['setting_id'],
							'NAME'		=> $row['setting_name'],
							'CONTENT'	=> $row['setting_value'],
							'TYPE'		=> $setting_type
					));
				}
				$db->sql_freeresult($result);
				
				// Get arcade stats
				$sql = 'SELECT COUNT(game_id) AS total_games FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 1';
				$result = $db->sql_query($sql);
					$total_games = (int) $db->sql_fetchfield('total_games');
				$db->sql_freeresult($result);
				$sql = 'SELECT SUM(game_plays) AS total_plays FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 1';
				$result = $db->sql_query($sql);
					$total_plays = (int) $db->sql_fetchfield('total_plays');
				$db->sql_freeresult($result);
				$sql = 'SELECT SUM(game_num_ratings) AS total_ratings FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 1';
				$result = $db->sql_query($sql);
					$total_ratings = (int) $db->sql_fetchfield('total_ratings');
				$db->sql_freeresult($result);
				$sql = 'SELECT AVG(game_rating) average_rating FROM ' . $db_prefix . '_ar_games WHERE game_rating > 0 AND game_enabled = 1';
				$result = $db->sql_query($sql);
					$average_rating = (int) $db->sql_fetchfield('average_rating');
				$db->sql_freeresult($result);
				$sql = 'SELECT COUNT(favorite_id) AS total_favorites FROM ' . $db_prefix . '_ar_favorites';
				$result = $db->sql_query($sql);
					$total_favorites = (int) $db->sql_fetchfield('total_favorites');
				$db->sql_freeresult($result);
				$sql = 'SELECT COUNT(comment_id) AS total_comments FROM ' . $db_prefix . '_ar_comments';
				$result = $db->sql_query($sql);
					$total_comments = (int) $db->sql_fetchfield('total_comments');
				$db->sql_freeresult($result);
				$total_swf_size = 0;
				$files = dir_get_files('flash/');
				foreach($files as $file)
				{
					$total_swf_size += filesize('flash/' . $file);
				}
				$total_swf_size = convert_file_size($total_swf_size);
				$total_img_size = 0;
				$files = dir_get_files('flash/images/');
				foreach($files as $file)
				{
					$total_img_size += filesize('flash/images/' . $file);
				}
				$total_img_size = convert_file_size($total_img_size);
				
				$days_passed = time() - file_get_contents('flash/start.date');
				$days_passed /= 86400;
				$plays_per_day = $total_plays / ceil($days_passed);
				$template->assign_vars(array(
					'TOTAL_GAMES'			=> $total_games,
					'TOTAL_PLAYS'			=> $total_plays,
					'TOTAL_RATINGS'			=> $total_ratings,
					'AVG_RATING'			=> $average_rating,
					'TOTAL_FAVORITES'		=> $total_favorites,
					'TOTAL_COMMENTS'		=> $total_comments,
					'TOKENS_SPENT'			=> 0,
					'TICKETS_DISPENSED'		=> 0,
					'TOTAL_SWF_SIZE'		=> $total_swf_size,
					'TOTAL_IMG_SIZE'		=> $total_img_size,
					'ARCADE_STARTED'		=> date("D M d, Y h:i a", mktime(3, 17, 0, 9, 17, 2008)),
					'PLAYS_PER_DAY'			=> round($plays_per_day, 2)
				));
			}
			break;
		}
	}
}
?>