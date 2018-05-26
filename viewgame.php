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
** File viewgame.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
include('include/function_posting.' . $phpEx);
include('include/file_functions.' . $phpEx);
					include_once('include/class.bbcode.php');

$game_id = request_var('g', 0);
$offset = request_var('start', 0);
if ($game_id == '')
{
	$url_loc = append_sid("arcade.$phpEx", '');
	header("Location: $url_loc");
}

$template = new Template();
set_site_var('arcade');
// Start session management
$auth->acl($user);
$user->set_lang('arcade',$user->ulanguage);

if (!$auth->acl_get('u_arcade_view_arcade'))
{
     trigger_error('NOT_AUTHORISED');
}
else
{
	$template->assign_vars(array(
			'S_BBCODE_ALLOWED'	=> true
	));
}

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

$sql = 'SELECT COUNT(game_name) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 0 AND game_id = ' . $game_id;
$result = $db->sql_query($sql);
$total_games = (int) $db->sql_fetchfield('row_count');
if ($total_games == 1 && $user->data['user_type'] != '1')
{
	$url_loc = append_sid("arcade.$phpEx");
	header("Location: $url_loc");
}

// Output page
//page_header($user->lang['ARCADE']);

$template->set_filenames(array(
	'body' => 'viewgame_body.html'
));

// Check if games can be commented on
$sql = 'SELECT COUNT(setting_id) AS row_count FROM ' . $db_prefix . '_ar_settings WHERE setting_id = 3 AND setting_value = 1';
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
if ($row_count)
{
	$allow_comments = true;
}
else
{
	$allow_comments = false;
}
$db->sql_freeresult($result);

// Generate Pagination
$sql = 'SELECT COUNT(comment_id) AS row_count FROM ' . $db_prefix . '_ar_comments WHERE comment_game = ' . $game_id;
$result = $db->sql_query($sql);
$total_games = (int) $db->sql_fetchfield('row_count');

$pagination = generate_pagination(append_sid("viewgame.$phpEx", "g=$game_id&amp;action=p"), $total_games, 5, $offset);

$template->assign_vars(array(
		'PAGINATION' 	=> $pagination,
		'PAGE_NUMBER' 	=> on_page($total_games, 5, $offset),
));

// Check hotlink protection is enabled
$sql = 'SELECT COUNT(setting_id) AS row_count FROM ' . $db_prefix . '_ar_settings WHERE setting_id = 4 AND setting_value = 1';
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
if ($row_count)
{
	$hotlink_protection = true;
}
else
{
	$hotlink_protection = false;
}
$db->sql_freeresult($result);

if ($user->user)

{
	$allow_favorites = true;
}
else
{
	$allow_favorites = false;
}

// Check if game is a highscore game
$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_id = ' . $game_id . ' AND game_highscore = 1';
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
if ($row_count)
{
	$game_highscore = true;
}
else
{
	$game_highscore = false;
}
$db->sql_freeresult($result);

$action	= request_var('action', '');
switch ($action)
{
	case 'remove':
		$sql = 'SELECT favorite_id FROM ' . $db_prefix . '_ar_favorites 
			WHERE favorite_user = ' . $user->id . "
				AND favorite_game = $game_id";
		$result = $db->sql_query($sql);
		$favorite_id = (int) $db->sql_fetchfield('favorite_id');
		if ($favorite_id)
		{
			$sql = 'DELETE FROM ' . $db_prefix . '_ar_favorites  WHERE favorite_id = ' . (int) $favorite_id;
			$db->sql_query($sql);
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		} else {
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		}
		$db->sql_freeresult($result);
	break;
	case 'newhighscore':
		if ($game_highscore == true && $user->user)
		{
			// Deny $HTTP_GET_VARS Mode Games
			if(@$HTTP_GET_VARS['score'])
			{
				$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
				header("Location: $url_loc");	
			}
			
			$score = (($HTTP_POST_VARS['score'])) ? $HTTP_POST_VARS['score'] : $_POST['score'];
			
			$sql = 'SELECT highscore_id FROM ' . $db_prefix . '_ar_highscores 
				WHERE highscore_user = ' . $user->id . "
					AND highscore_game = $game_id
					AND highscore = $score";
			$result = $db->sql_query($sql);
			$highscore_id = (int) $db->sql_fetchfield('highscore_id');
			if (!$highscore_id)
			{			
				$sql_ary = array(
					'highscore_game'	=> $game_id,
					'highscore_user'	=> $user->id,
					'highscore'			=> $score
				);
				$sql = 'INSERT INTO ' . $db_prefix . '_ar_highscores  ' . $db->sql_build_array('INSERT', $sql_ary);
				$db->sql_query($sql);
			}
			$db->sql_freeresult($result);
		}
		
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
		
		$sql = 'SELECT highscore_user, highscore
			FROM ' . $db_prefix . '_ar_highscores 
			WHERE highscore_game = ' . $game_id . '
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
		$sql = 'SELECT COUNT(trophy_game) AS row_count FROM ' . $db_prefix . "_ar_trophies  WHERE trophy_game = $game_id";
		$result = $db->sql_query($sql);
		$row_count = (int) $db->sql_fetchfield('row_count');
		$db->sql_freeresult($result);
		
		if ($row_count > 0)
		{
			$sql = 'SELECT trophy_user_gold, trophy_user_silver, trophy_user_bronze
				FROM ' . $db_prefix . '_ar_trophies 
				WHERE trophy_game = ' . $game_id;
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
				'trophy_game'			=> $game_id,
				'trophy_user_gold'		=> $top_ids[0],
				'trophy_user_silver'	=> $top_ids[1],
				'trophy_user_bronze'	=> $top_ids[2],
			);
			$sql = 'INSERT INTO ' . $db_prefix . '_ar_trophies  ' . $db->sql_build_array('INSERT', $sql_ary);
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
				WHERE trophy_game = ' . (int) $game_id;
			$db->sql_query($sql);
		}
		
		$sql = 'SELECT game_name
			FROM ' . $db_prefix . '_ar_games
			WHERE game_id = ' . (int) $game_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$game_name = $row['game_name'];
		$db->sql_freeresult($result);
		
		$path = explode('viewgame', $_SERVER["PHP_SELF"]);
		$url_loc = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "viewgame.$phpEx?g=" . $game_id;
		
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
				$sql = 'SELECT U.username, L.group_colour
			FROM ' . $db_prefix . '_users U, ' . $db_prefix . '_level_settings L
			WHERE U.id =' . (int) $top_ids[0] . '
			AND 
			L.group_id = U.can_do';
				$result2 = $db->sql_query($sql);
				$row2 = $db->sql_fetchrow($result2);
				$db->sql_freeresult($result2);
				
				$url_loc2 = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "user.php?op=profile&id=" . $top_ids[0];
				if ($row2['user_colour'])
				{
					$user_loc = '[b][url=' . $url_loc2 . '][color=#' . $row2['group_colour'] . ']' . $row2['username'] . '[/color][/url][/b]';
				}
				else
				{
					$user_loc = '[url=' . $url_loc2 . ']' . $row2['username'] . '[/url]';
				}
				$pm_message = $user->lang['ARCADE_PM_ONE'] . $pm_gold . $user->lang['ARCADE_PM_TWO'] . $user_loc . $user->lang['ARCADE_PM_THREE'] . $score . $user->lang['ARCADE_PM_FOUR'] . $game_loc;
				send_trophy_pm($pm_message, $old_ids[0]);
				unset($pm_message);
			}
			if ($top_ids[1] != $old_ids[1])
			{
				if ($old_ids[1] != $top_ids[0])
				{
					if (!isset($user_loc))
					{
						$sql = 'SELECT U.username, L.group_colour
			FROM ' . $db_prefix . '_users U, ' . $db_prefix . '_level_settings L
			WHERE U.id = ' . (int) $top_ids[1] . '
			AND 
			L.group_id = U.can_do';
						$result2 = $db->sql_query($sql);
						$row2 = $db->sql_fetchrow($result2);
						$db->sql_freeresult($result2);
						
						$url_loc2 = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "user.php?op=profile&id=" . $top_ids[1];
						if ($row2['group_colour'])
						{
							$user_loc = '[b][url=' . $url_loc2 . '][color=#' . $row2['group_colour'] . ']' . $row2['username'] . '[/color][/url][/b]';
						}
						else
						{
							$user_loc = '[url=' . $url_loc2 . ']' . $row2['username'] . '[/url]';
						}
					}
					$pm_message = $user->lang['ARCADE_PM_ONE'] . $pm_silver . $user->lang['ARCADE_PM_TWO'] . $user_loc . $user->lang['ARCADE_PM_THREE'] . $score . $user->lang['ARCADE_PM_FOUR'] . $game_loc;
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
						$sql = 'SELECT U.username, L.group_colour
			FROM ' . $db_prefix . '_users U, ' . $db_prefix . '_level_settings L
			WHERE U.id = ' . (int) $top_ids[2] . '
			AND 
			L.group_id = U.can_do';
						$result2 = $db->sql_query($sql);
						$row2 = $db->sql_fetchrow($result2);
						$db->sql_freeresult($result2);
						
						$url_loc2 = 'http://' . $_SERVER["HTTP_HOST"] . $path[0] . "user.php?op=profile&id=" . $top_ids[2];
						if ($row2['group_colour'])
						{
							$user_loc = '[b][url=' . $url_loc2 . '][color=#' . $row2['group_colour'] . ']' . $row2['username'] . '[/color][/url][/b]';
						}
						else
						{
							$user_loc = '[url=' . $url_loc2 . ']' . $row2['username'] . '[/url]';
						}
					}
					
					$pm_message = $user->lang['ARCADE_PM_ONE'] . $pm_bronze . $user->lang['ARCADE_PM_TWO'] . $user_loc . $user->lang['ARCADE_PM_THREE'] . $score . $user->lang['ARCADE_PM_FOUR'] . $game_loc;
					send_trophy_pm($pm_message, $old_ids[2]);
					unset($pm_message);
				}
			}
		}
		
		$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
		header("Location: $url_loc");
	break;
	case 'add':
		$sql = 'SELECT favorite_id FROM ' . $db_prefix . '_ar_favorites 
			WHERE favorite_user = ' . $user->id . "
				AND favorite_game = $game_id";
		$result = $db->sql_query($sql);
		$favorite_id = (int) $db->sql_fetchfield('favorite_id');
		if (!$favorite_id)
		{
			$sql_ary = array(
				'favorite_game'		=> $game_id,
				'favorite_user'		=> $user->id
			);
			$sql = 'INSERT INTO ' . $db_prefix . '_ar_favorites  ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql);
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		} else {
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		}
		$db->sql_freeresult($result);
	break;
	case 'delete':
		$comment_id = request_var('c', 0);
		$sql = 'SELECT *
			FROM ' . $db_prefix . '_ar_comments
			WHERE comment_id = ' . $comment_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($user->user || $user->id == $row['comment_user'])
		{
			$sql = 'DELETE FROM ' . $db_prefix . '_ar_comments WHERE comment_id = ' . (int) $comment_id;
			$db->sql_query($sql);
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		} else {
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		}
		$db->sql_freeresult($result);
	break;
	case 'edit':
		$comment_id = request_var('c', 0);
		$sql = 'SELECT *
			FROM ' . $db_prefix . '_ar_comments
			WHERE comment_id = ' . $comment_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		
		decode_message($row['comment'], $row['bbcode_uid']);
		if (!$allow_comments)
		{
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		}
		if ($user->user || $user->id == $row['comment_user'])
		{
			$url = 'viewgame.' . $phpEx . "?action=update&amp;c=$comment_id&amp;g=$game_id";
			$template->assign_vars(array(
					'S_EDIT'	=> true,
					'U_ACTION'	=> $url,
					'COMMENT'	=> $row['comment'],
					'S_BBCODE_ALLOWED'	=> true
			));
		} else {
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		}
		$db->sql_freeresult($result);
	break;
	case 'update':
		$comment_id = request_var('c', 0);
		$sql = 'SELECT *
			FROM ' . $db_prefix . '_ar_comments
			WHERE comment_id = ' . $comment_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		if ($user->user || $user->id == $row['comment_user'])
		{
			$comment = utf8_normalize_nfc(request_var('message', '', true));
			$uid = $bitfield = $options = ''; // will be modified by generate_text_for_storage
			$allow_bbcode = $allow_urls = $allow_smilies = true;
			generate_text_for_storage($comment, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);
			
			$sql_ary = array(
				'comment'			=> $comment,
				'bbcode_uid'        => $uid,
				'bbcode_bitfield'   => $bitfield,
				'enable_bbcode'     => $allow_bbcode,
				'enable_urls'       => $allow_urls,
				'enable_smilies'    => $allow_smilies
			);
			
			$sql = 'UPDATE ' . $db_prefix . '_ar_comments
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE comment_id = ' . (int) $comment_id;
			$db->sql_query($sql);
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		} else {
			$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
		}
		$db->sql_freeresult($result);
	break;
	case 'comment':
		$comment = utf8_normalize_nfc(request_var('message', '', true));
		if ($comment != '' && $allow_comments)
		{
			$comment = utf8_normalize_nfc(request_var('message', '', true));
			$uid = $bitfield = $options = ''; // will be modified by generate_text_for_storage
			$allow_bbcode = $allow_urls = $allow_smilies = true;
			generate_text_for_storage($comment, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);
			
			$sql_ary = array(
				'comment_game'		=> $game_id,
				'comment_user'		=> $user->id,
				'comment'			=> $comment,
				'bbcode_uid'        => $uid,
				'bbcode_bitfield'   => $bitfield,
				'enable_bbcode'     => $allow_bbcode,
				'enable_urls'       => $allow_urls,
				'enable_smilies'    => $allow_smilies,
			);
			
			$sql = 'INSERT INTO ' . $db_prefix . '_ar_comments ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql);
		}
		$url_loc = append_sid("viewgame.$phpEx", 'g=' . $game_id . '&action=p');
			header("Location: $url_loc");
	break;
	case 'rategame':
		$rating	= request_var('rating', 0);
		// Grab group details for rating display
		$sql = 'SELECT rating_id FROM ' . $db_prefix . '_ar_ratings 
			WHERE rating_user = ' . $user->id . "
				AND rating_game = $game_id";
		$result = $db->sql_query($sql);
		$rating_id = (int) $db->sql_fetchfield('rating_id');
		if ($rating_id)
		{
			// Update number of game plays this game has been played
			$sql = 'UPDATE ' . $db_prefix . '_ar_ratings  SET rating_score = ' . $rating . ' WHERE rating_id = '. $rating_id;
			$db->sql_query($sql);
		}
		else
		{
			// Update number of game plays this game has been played
			$sql_ary = array(
				'rating_game'		=> $game_id,
				'rating_user'		=> $user->id,
				'rating_score'		=> $rating
			);
			$sql = 'INSERT INTO ' . $db_prefix . '_ar_ratings  ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql);
		}
		$db->sql_freeresult($result);
		// Grab group details for rating display
		$sql = 'SELECT COUNT(rating_game) AS row_count FROM ' . $db_prefix . "_ar_ratings  WHERE rating_game = $game_id";
		$result = $db->sql_query($sql);
		$row_count = (int) $db->sql_fetchfield('row_count');
		$db->sql_freeresult($result);

		$sql = 'SELECT rating_game, rating_score
			FROM ' . $db_prefix . '_ar_ratings 
			WHERE rating_game = ' . $game_id;
		$result = $db->sql_query($sql);
		$rtotal = 0;
		while ($row = $db->sql_fetchrow($result))
		{
			$game_id = $row['rating_game'];
			$rtotal += $row['rating_score'];
		}
		$db->sql_freeresult($result);
		$rtotal = number_format($rtotal / $row_count, 0);
		$sql_ary = array(
			'game_rating'		=> $rtotal,
			'game_num_ratings'	=> $row_count
		);
		$sql = 'UPDATE ' . $db_prefix . '_ar_games
			SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE game_id = ' . (int) $game_id;
		$db->sql_query($sql);
	break;
}

if ($action != 'edit')
{
$template->assign_block_vars('navlinks', array(
	'FORUM_NAME'	=> $user->lang['ARCADE'],
	'U_VIEW_FORUM'	=> append_sid("arcade.$phpEx", ''))
);

// Check if game_id is a valid game
$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . "_ar_games WHERE game_id = $game_id";
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
if (!$row_count)
{
	header("Location: arcade.php");
}
else
{
	$valid_game = true;
}
$db->sql_freeresult($result);

if ($action === '' && $user->user)
{
	// Update number of game plays this game has been played
	$sql = 'UPDATE ' . $db_prefix . '_ar_games SET game_plays = game_plays + 1 WHERE game_id = ' . (int) $game_id;
	$db->sql_query($sql);
}

//Check how many users favorited the game
$sql = 'SELECT COUNT(favorite_id) AS row_count FROM ' . $db_prefix . '_ar_favorites  WHERE favorite_game = ' . (int) $game_id;
$result = $db->sql_query($sql);
$fav_count = (int) $db->sql_fetchfield('row_count');
$db->sql_freeresult($result);

if ($valid_game)
{
	// Make sure the game currently being played is on the users played game list
	$sql = 'SELECT played_id, played_games
		FROM ' . $db_prefix . '_ar_played 
		WHERE played_user = ' . (int) $user->id;
	$result = $db->sql_query($sql);
	$played_games = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$played_games = explode('-', $row['played_games']);
		$played_id = $row['played_id'];
	}
	$db->sql_freeresult($result);
	$already_listed = false;
	foreach($played_games as $value)
	{
		if ($value == $game_id)
		{
			$already_listed = true;
		}
	}
	if ($already_listed != true)
	{
		array_push($played_games, $game_id);
		$games_played = implode('-', $played_games);
		if (!$played_id)
		{
			$sql_ary = array(
				'played_user'		=> $user->id,
				'played_games'		=> $games_played
				
			);
			$sql = 'INSERT INTO ' . $db_prefix . '_ar_played  ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql);
		}
		else
		{
			$sql_ary = array(
				'played_user'		=> $user->id,
				'played_games'		=> $games_played
			);
			
			$sql = 'UPDATE ' . $db_prefix . '_ar_played 
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE played_id = ' . (int) $played_id;
			$db->sql_query($sql);
		}
	}
}

$game_add_remove = '';
$u_add_remove = '';

// Grab group details for game display
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games
	WHERE game_id = ' . $game_id . '
	ORDER BY game_name';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	if ($user->user)
	{
		//check if current user favorited the game
		$sql = 'SELECT favorite_id FROM ' . $db_prefix . '_ar_favorites 
			WHERE favorite_user = ' . $user->id . '
				AND favorite_game = ' . $row['game_id'];
		$result2 = $db->sql_query($sql);
		$favorite_id = (int) $db->sql_fetchfield('favorite_id');
		$db->sql_freeresult($result2);
		if ($favorite_id)
		{
			$game_add_remove = "<img src='flash/images/included/star_r.gif' alt='*' />";
			$u_add_remove = 'viewgame.php?action=remove&g=' . $row['game_id'];
		}
		else
		{
			$game_add_remove = "<img src='flash/images/included/star_p.gif' alt='*' />";
			$u_add_remove = 'viewgame.php?action=add&g=' . $row['game_id'];
		}
	}
	if ($user->user)
	{
		$rate1 = append_sid("viewgame.$phpEx", 'action=rategame&rating=1&g=' . $row['game_id']);
		$rate2 = append_sid("viewgame.$phpEx", 'action=rategame&rating=2&g=' . $row['game_id']);
		$rate3 = append_sid("viewgame.$phpEx", 'action=rategame&rating=3&g=' . $row['game_id']);
		$rate4 = append_sid("viewgame.$phpEx", 'action=rategame&rating=4&g=' . $row['game_id']);
		$rate5 = append_sid("viewgame.$phpEx", 'action=rategame&rating=5&g=' . $row['game_id']);
		$starbegin = "<a href='";
		$staryes =  "'><img src='flash/images/included/star_yes.gif' alt='*' /></a>";
		$star = "'><img src='flash/images/included/star.gif' alt='*' /></a>";
		if ($row['game_rating'] == 0)
		{
			$rstars = $starbegin . $rate1 . $star . $starbegin . $rate2 . $star . $starbegin . $rate3 . $star . $starbegin . $rate4 . $star . $starbegin . $rate5 . $star;
		}
		elseif ($row['game_rating'] == 1)
		{
			$rstars = $starbegin . $rate1 . $staryes . $starbegin . $rate2 . $star . $starbegin . $rate3 . $star . $starbegin . $rate4 . $star . $starbegin . $rate5 . $star;
		}
		elseif ($row['game_rating'] == 2)
		{
			$rstars = $starbegin . $rate1 . $staryes . $starbegin . $rate2 . $staryes . $starbegin . $rate3 . $star . $starbegin . $rate4 . $star . $starbegin . $rate5 . $star;
		}
		elseif ($row['game_rating'] == 3)
		{
			$rstars = $starbegin . $rate1 . $staryes . $starbegin . $rate2 . $staryes . $starbegin . $rate3 . $staryes . $starbegin . $rate4 . $star . $starbegin . $rate5 . $star;
		}
		elseif ($row['game_rating'] == 4)
		{
			$rstars = $starbegin . $rate1 . $staryes . $starbegin . $rate2 . $staryes . $starbegin . $rate3 . $staryes . $starbegin . $rate4 . $staryes . $starbegin . $rate5 . $star;
		}
		elseif ($row['game_rating'] == 5)
		{
			$rstars = $starbegin . $rate1 . $staryes . $starbegin . $rate2 . $staryes . $starbegin . $rate3 . $staryes . $starbegin . $rate4 . $staryes . $starbegin . $rate5 . $staryes;
		}
	} else {
		$staryes =  "<img src='flash/images/included/star_yes.gif' alt='*' />";
		$star = "<img src='flash/images/included/star.gif' alt='*' />";
		if ($row['game_rating'] == 0)
		{
			$rstars = $star . $star . $star . $star . $star;
		}
		elseif ($row['game_rating'] == 1)
		{
			$rstars = $staryes . $star . $star . $star . $star;
		}
		elseif ($row['game_rating'] == 2)
		{
			$rstars = $staryes . $staryes . $star . $star . $star;
		}
		elseif ($row['game_rating'] == 3)
		{
			$rstars = $staryes . $staryes . $staryes . $star . $star;
		}
		elseif ($row['game_rating'] == 4)
		{
			$rstars = $staryes . $staryes . $staryes . $staryes . $star;
		}
		elseif ($row['game_rating'] == 5)
		{
			$rstars = $staryes . $staryes . $staryes . $staryes . $staryes;
		}
	}
	$description = censor_text($row['game_description']);
	$description = str_replace("\n", '<br />', $description);
	$directions = censor_text($row['game_directions']);
	$directions = str_replace("\n", '<br />', $directions);
	// Send vars to template
	$filename = 'flash/' . $row['game_filename'];
	if($hotlink_protection)
	{
		$sql2 = 'SELECT *
			FROM ' . $db_prefix . '_ar_hotlinks
			WHERE hotlink_game = ' . $game_id;
		$result2 = $db->sql_query($sql2);
		$row2 = $db->sql_fetchrow($result2);
		$db->sql_freeresult($result2);
		$make_new = false;
		if(isset($row2['hotlink_file']))
		{
			$time = time();
			$file_life = $time - filemtime($row2['hotlink_file']);
			if ($file_life > 60)
			{
				unlink($row2['hotlink_file']);
				$sql3 = 'DELETE FROM ' . $db_prefix . '_ar_hotlinks WHERE hotlink_id = ' . (int) $row2['hotlink_id'];
				$db->sql_query($sql3);
				$make_new = true;
			}
			else
			{
				$filename = $row2['hotlink_file'];
			}
		}
		else
		{
			$make_new = true;
		}
		if($make_new == true)
		{
			$new_name = 'flash/tmp/' . file_temp_name('.swf');
			copy($filename, $new_name);
			$sql_ary = array(
				'hotlink_game'		=> $game_id,
				'hotlink_file'		=> $new_name
			);
			$sql4 = 'INSERT INTO ' . $db_prefix . '_ar_hotlinks ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql4);
			$filename = $new_name;
		}
	}
	$kmextra = '&nbsp;';
	if ($row['game_keyboard'] == 1)
	{
		$kmextra .= "<img src='flash/images/included/keyboard.gif' alt='keyboard' />&nbsp;";
	}
	if ($row['game_mouse'] == 1)
	{
		$kmextra .= "<img src='flash/images/included/mouse.gif' alt='mouse' />&nbsp;";
	}
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
					generate_smilies('inline', 0);
					$num_predefined_bbcodes = 22;
		$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
			FROM '.$db_prefix.'_bbcodes
			WHERE display_on_posting = 1
			ORDER BY bbcode_tag';
		$result = $db->sql_query($sql);
			
		$i = 0;
		while ($rows = $db->sql_fetchrow($result))
		{
			// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
			if (isset($user->lang[strtoupper($rows['bbcode_helpline'])]))
			{
				$rows['bbcode_helpline'] = $user->lang[strtoupper($rows['bbcode_helpline'])];
			}
	
			$template->assign_block_vars('custom_tags', array(
				'BBCODE_NAME'		=> "'[{$rows['bbcode_tag']}]', '[/" . str_replace('=', '', $rows['bbcode_tag']) . "]'",
				'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
				'BBCODE_TAG'		=> str_replace('=', '', $rows['bbcode_tag']),
				'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
				'A_BBCODE_HELPLINE'	=> str_replace(
					array('&amp;', '&quot;', "'", '&lt;', '&gt;'), 
					array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
			));
	
			$i++;
		}
		$db->sql_freeresult($result);
	$template->assign_block_vars('gamerow', array(
			'GAME_ID'			=> $row['game_id'],
			'GAME_NAME'			=> $row['game_name'],
			'GAME_IMAGE'		=> $row['game_image'],
			'GAME_DESC'			=> $description,
			'GAME_DIR'			=> $directions,
			'GAME_USES'			=> $kmextra,
			'GAME_FILENAME'		=> $filename,
			'GAME_WIDTH'		=> $row['game_width'],
			'GAME_HEIGHT'		=> $row['game_height'],
			'GAME_PLAY'			=> $row['game_plays'],
			'GAME_RATING'		=> $rstars,
			'GAME_NUMRATINGS'	=> $row['game_num_ratings'],
			'GAME_NUMFAVORITES'	=> $fav_count,
			'GAME_SIZE'			=> get_file_size($filename),
			'GAME_ADD_REMOVE'	=> $game_add_remove,
			'U_ADD_REMOVE'		=> $u_add_remove,
	));
}
$db->sql_freeresult($result);

$sql = 'SELECT *
    FROM ' . $db_prefix . '_ar_comments
	WHERE comment_game = ' . $game_id . '
	ORDER BY comment_id DESC
	LIMIT ' . $offset . ',5';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	// Grab game details for a total count for the category
	$sql = 'SELECT U.username, L.group_colour
			FROM ' . $db_prefix . '_users U, ' . $db_prefix . '_level_settings L
			WHERE U.id = ' . (int) $row['comment_user'] . '
			AND 
			L.group_id = U.can_do';
	$result2 = $db->sql_query($sql);
	$row2 = $db->sql_fetchrow($result2);
	$username = get_username_string('full', $row['comment_user'], $row2['username'], $row2['group_colour'], $row2['username']);
	$db->sql_freeresult($result2);
	$row['bbcode_options'] = (($row['enable_bbcode']) ? '1' : 0) +
    ((@$row['enable_smilies']) ? '1' : 0) + 
    ((@$row['enable_magic_url']) ? '1' : 0);
	$message = generate_text_for_display($row['comment'], $row['bbcode_uid'], $row['bbcode_bitfield'], 1);
	
	// Holding maximum post time for marking topic read
	// We need to grab it because we do reverse ordering sometimes
	$sql2 = 'SELECT *
		FROM ' . $db_prefix . '_users
		WHERE user_id = ' . $row['comment_user'];
	$result2 = $db->sql_query($sql2);
	
	// Posts are stored in the $rowset array while $attach_list, $user_cache
	// and the global bbcode_bitfield are built
	while ($row2 = $db->sql_fetchrow($result2))
	{
		// Cache various user specific data ... so we don't have to recompute
		// this each time the same user appears on this page
		if (!isset($user_cache[$row['comment_user']]))
		{
			$id_cache[$row['comment_user']] = $row['comment_user'];
			$user_cache[$row['comment_user']] = array(
				'viewonline'	=> $row2['user_allow_viewonline'],
	
				'online'		=> false,
	
				'avatar'		=> ($user->optionget('viewavatars')) ? get_user_avatar($row2['avatar'], $row2['avatar_type'], $row2['user_avatar_wt'], $row2['user_avatar_ht']) : '',
	
				'rank_title'		=> '',
				'rank_image'		=> '',
				'rank_image_src'	=> '',
			);
	
			get_user_rank($row2['can_do'], $row2['user_posts'], $user_cache[$row['comment_user']]['rank_title'], $user_cache[$row['comment_user']]['rank_image'], $user_cache[$row['comment_user']]['rank_image_src']);
		}
	}
	$db->sql_freeresult($result2);
	unset($today);
	// Generate online information for user
	if ($config['load_onlinetrack'] && sizeof(@$id_cache))
	{
		$sql3 = 'SELECT session_user_id, MAX(session_time) as online_time, MIN(session_viewonline) AS viewonline
			FROM ' . SESSIONS_TABLE . '
			WHERE ' . $db->sql_in_set('session_user_id', $id_cache) . '
			GROUP BY session_user_id';
		$result3 = $db->sql_query($sql3);
	
		$update_time = $config['load_online_time'] * 60;
		while ($row3 = $db->sql_fetchrow($result3))
		{
			$user_cache[$row3['session_user_id']]['online'] = (time() - $update_time < $row3['online_time'] && (($row3['viewonline'] && $user_cache[$row3['session_user_id']]['viewonline']) || $user->user)) ? true : false;
		}
		$db->sql_freeresult($result3);
	}
	unset($id_cache);	
	
	$delete = '';
	$edit = '';
	if ($user->admin || $user->id == $row['comment_user'])
	{
		$delete = append_sid("viewgame.$phpEx", 'action=delete&c=' . $row['comment_id'] . '&g=' . $game_id);
		$edit = append_sid("viewgame.$phpEx", 'action=edit&c=' . $row['comment_id'] . '&g=' . $game_id);
		$template->assign_vars(array(
				'S_COMMENTS'		=> true
		));
	}
	
	// Send vars to template
	$template->assign_block_vars('commentrow', array(
			'COMMENT_USER'		=> $username,
			'COMMENT'			=> $message,
			'U_DELETE'			=> $delete,
			'U_EDIT'			=> $edit,
			'S_ONLINE'			=> ($row['comment_user'] == ANONYMOUS || !$config['load_onlinetrack']) ? false : (($user_cache[$row['comment_user']]['online']) ? true : false),
			'POSTER_AVATAR'		=> $user_cache[$row['comment_user']]['avatar'],
			'RANK_TITLE'		=> $user_cache[$row['comment_user']]['rank_title'],
			'RANK_IMG'			=> $user_cache[$row['comment_user']]['rank_image'],
			'RANK_IMG_SRC'		=> $user_cache[$row['comment_user']]['rank_image_src'],
	));
	$template->assign_vars(array(
			'S_HAS_COMMENTS'		=> true
	));
}
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

$sql = 'SELECT highscore_user, highscore
    FROM ' . $db_prefix . '_ar_highscores 
	WHERE highscore_game = ' . $game_id . '
	ORDER BY highscore ' . $rev_scoring;
$result = $db->sql_query($sql);
while ($row = $db->sql_fetchrow($result))
{
	$sql = 'SELECT username, user_colour
		FROM ' . $db_prefix . '_users
		WHERE user_id = ' . (int) $row['highscore_user'];
	$result2 = $db->sql_query($sql);
	$row2 = $db->sql_fetchrow($result2);
	$username = get_username_string('full', $row['highscore_user'], $row2['username'], $row2['user_colour'], $row2['username']);
	$db->sql_freeresult($result2);
	
	$user_ids[$username] = $row['highscore_user'];
	@$highscores[$username][sizeof($highscores[$username])] = str_replace('.0', '', $row['highscore']);
}
if (@$highscores)
{
	$bronze = "<img src='flash/images/included/trophy_bronze.gif' align='absmiddle' alt='bronze' />";
	$silver = "<img src='flash/images/included/trophy_silver.gif' align='absmiddle' alt='silver' />";
	$gold = "<img src='flash/images/included/trophy_gold.gif' align='absmiddle' alt='gold' />";
	$user_count = 0;
	$prev_highscore = 0;
	$gold_pos = 1;
	$silver_pos = 2;
	$bronze_pos = 3;
	foreach($highscores as $key => $value)
	{
		unset($extra);
		$extra = '';
		if ($user_ids[$key] == $user->id)
		{
			$current_user = true;
		}
		else
		{
			$current_user = false;
		}
		$score_count = sizeof($highscores[$key]);
		if ($highscores[$key][0] == $prev_highscore)
		{
			if ($user_count <= $gold_pos)
			{
				$gold_pos++;
				$silver_pos++;
				$bronze_pos++;
			}
			else if ($user_count <= $silver_pos)
			{
				$silver_pos++;
				$bronze_pos++;
			}
			else if ($user_count <= $bronze_pos)
			{
				$bronze_pos++;
			}
		}
		$prev_highscore = $highscores[$key][0];
		if ($score_count > 1)
		{
			$url_loc = append_sid("viewhighscores.$phpEx", 'g=' . $game_id . '&amp;u=' . $user_ids[$key]);
			$extra = "(<a href=\"javascript:popUp('$url_loc',700,500,1);\">$score_count</a>)";
		}
		$user_count++;
		if ($user_count < 10)
		{
			if (sizeof($user_ids) > 2)
			{
				if ($user_count <= 1)
				{
					$extra .= $gold;
				}
				else if ($user_count <= 2)
				{
					$extra .= $silver;
				}
				else if ($user_count <= 3)
				{
					$extra .= $bronze;
				}
			}
			else
			{
				$template->assign_vars(array(
					'S_NOT_ENOUGH'		=> true
				));
			}
			// Send vars to template
			$template->assign_block_vars('scorerow', array(
					'SCORE_USER'	=> $key . $extra,
					'SCORE'			=> $highscores[$key][0],
					'CURRENT_USER'	=> $current_user
			));
		}
		elseif ($user_count < 30)
		{

			// Send vars to template
			$template->assign_block_vars('extrascorerow', array(
					'SCORE_USER'	=> $key . $extra,
					'SCORE'			=> $highscores[$key][0],
					'CURRENT_USER'	=> $current_user
			));
			$template->assign_vars(array(
					'S_EXTRA_SCORES'		=> true
			));
		}
	}
}
$db->sql_freeresult($result);

// Grab game details for a total comment count
$sql = 'SELECT COUNT(comment_id) AS row_count FROM ' . $db_prefix . '_ar_comments WHERE comment_game = ' . $game_id;
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
if ($row_count != 1)
{
	$template->assign_vars(array(
		'L_NUM_COMMENTS'	=> $row_count . ' ' . $user->lang['COMMENTS']
	));
}
else
{
	$template->assign_vars(array(
		'L_NUM_COMMENTS'	=> $row_count . $user->lang['COMMENT']
	));
}

if ($user->user)
{
     $template->assign_vars(array(
			'S_CAN_COMMENT'		=> true,
			'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
	));
}

if ($allow_comments)
{
	$url = 'viewgame.' . $phpEx . "?action=comment&amp;g=$game_id";
	$template->assign_vars(array(
			'S_COMMENT'		=> true,
			'U_ACTION'		=> $url
	));
}
if ($allow_favorites)
{
	$template->assign_vars(array(
			'S_ALLOW_FAV'	=> true
	));
}
if ($game_highscore)
{
	$template->assign_vars(array(
			'S_HIGHSCORE'	=> true
	));
}

$template->assign_vars(array(
		'S_ARCADE'	=> true,
));

// Grab arcade details for nav display
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games
	WHERE game_id = ' . $game_id;
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_categories 
	WHERE category_id = ' . $row['game_category'];
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$template->assign_block_vars('navlinks', array(
	'FORUM_NAME'	=> $row['category_name'],
	'U_VIEW_FORUM'	=> append_sid("viewcategory.$phpEx", 'c=' . $row['category_id']))
);

$arcade_list = array();

// Grab game details for previous and next games
$list_count = 0;
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games
	WHERE game_id = ' . $game_id;
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games
	WHERE game_category = ' . $row['game_category'] . '
		AND game_enabled = 1
	ORDER BY game_name';
$result = $db->sql_query($sql);
while ($row = $db->sql_fetchrow($result))
{
	$arcade_list[$list_count] = $row['game_id'];
	$list_count++;
}
foreach($arcade_list as $key => $value)
{
	if ($value == $game_id)
	{
		$cur_game_loc = $key;
	}
}
$previous_url = '';
$next_url = '';
if ($cur_game_loc != 0)
{
	$previous_url = append_sid("viewgame.$phpEx", 'g=' . $arcade_list[$cur_game_loc-1]);
}
if ($cur_game_loc != sizeof($arcade_list)-1)
{
	$next_url = append_sid("viewgame.$phpEx", 'g=' . $arcade_list[$cur_game_loc+1]);
}
$template->assign_vars(array(
		'PREVIOUS_PAGE'		=> $previous_url,
		'NEXT_PAGE'			=> $next_url
));
}
echo $template->fetch('viewgame_body.html');
close_out();
?>