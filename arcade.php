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
** File arcade.php 2018-02-19 14:32:00 Black_Heart
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

$user->set_lang('arcade',$user->ulanguage);
$v3arcade = (isset($_POST['sessdo'])) ? request_var('sessdo', '') : '';
if (!empty($v3arcade))
{
	header('Location: arcade.php?v=' . $v3arcade);
	switch ($v3arcade)
	{
		case 'burn':
			$data 	= explode('|', $micro_one);
			$game_sid = $data[2];
			$game_scorevar	= str_replace("\'", "''", htmlspecialchars(trim($data[1])));
			$score 	= floatval($data[0]);
			header('Location: arcade.php');
		break;
	}
}

$template = new Template();
set_site_var('arcade');

$action	= request_var('action', '');
$game_id = request_var('g', 0);

$template->assign_block_vars('navlinks', array(
	'FORUM_NAME'	=> $user->lang['ARCADE'],
	'U_VIEW_FORUM'	=> append_sid("arcade.$phpEx", '', true, $user->session_id))
);

// Grab game details for category display
$sql = 'SELECT category_id, category_name
	FROM ' . $db_prefix . '_ar_categories
	ORDER BY category_name';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	// Grab game details for a total count for the category
	$sql = 'SELECT COUNT(game_category) AS row_count FROM ' . $db_prefix . '_ar_games  WHERE game_enabled = 1 AND game_category = ' . $row['category_id'];
	$result2 = $db->sql_query($sql);
	$row_count = (int) $db->sql_fetchfield('row_count');
	$db->sql_freeresult($result2);

	// Send vars to template
	$template->assign_block_vars('categoryrow', array(
			'CATEGORY_ID'			=> $row['category_id'],
			'CATEGORY_NAME'			=> $row['category_name'],
			'CATEGORY_COUNT'		=> '(' . $row_count . ')'
	));
}
$db->sql_freeresult($result);

if ($user->user)
{
	$template->assign_vars(array(
			'S_YOUR_INFO'	=> true
	));
}

// Grab game details for a total count
$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games  WHERE game_enabled = 1';
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
$total_games = $row_count;
if ($row_count > 0)
{
	$template->assign_vars(array(
		'L_NUM_GAMES'	=> '(' . $row_count . ')',
		'S_ARCADE'		=> true,
		'S_ALL_GAMES'	=> true
	));
}
else
{
	$template->assign_vars(array(
		'S_ARCADE'		=> true,
		'S_ALL_GAMES'	=> false
	));
}
$db->sql_freeresult($result);
if ($user->user)
{
	// Grab game details for a favorites count
	$sql = 'SELECT COUNT(favorite_id) AS row_count FROM ' . $db_prefix . '_ar_favorites  WHERE favorite_user = ' . $user->id;
	$result = $db->sql_query($sql);
	$row_count = (int) $db->sql_fetchfield('row_count');
	if ($row_count > 0)
	{
		$fav_url = append_sid("ucp.$phpEx", 'i=arcade&mode=favorites', true, $user->session_id);
		$template->assign_vars(array(
			'L_FAV_GAMES'	=> '(' . $row_count . ')',
			'S_FAVORITES'	=> true
		));
	}
	$db->sql_freeresult($result);
}

// Grab game details for game display based on date added
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games 
	WHERE game_enabled = 1
	ORDER BY game_id DESC
	LIMIT 3';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	if ($row['game_rating'] >  0)
	{
		$rstars = "<img src='flash/images/included/star_" . $row['game_rating'] . ".gif' alt='" . $row['game_rating'] . "' />";
	}
	else
	{
		$rstars = "<img src='flash/images/included/star.gif' alt='0' />";
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
	// Send vars to template
	$template->assign_block_vars('latestrow', array(
			'GAME_ID'			=> $row['game_id'],
			'GAME_NAME'			=> $row['game_name'],
			'GAME_IMAGE'		=> $row['game_image'],
			'GAME_PLAYS'		=> $row['game_plays'],
			'GAME_RATING'		=> $rstars . $kmextra,
			'GAME_NUM_RATINGS'	=> $row['game_num_ratings'],
			'GAME_SIZE'			=> get_file_size("flash/" . $row['game_filename'])
	));
}
$db->sql_freeresult($result);

// Grab game details for game display based on plays
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games 
	WHERE game_enabled = 1
	ORDER BY game_plays DESC
	LIMIT 3';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	if ($row['game_rating'] >  0)
	{
		$rstars = "<img src='flash/images/included/star_" . $row['game_rating'] . ".gif' alt='" . $row['game_rating'] . "' />";
	}
	else
	{
		$rstars = "<img src='flash/images/included/star.gif' alt='0' />";
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
	// Send vars to template
	$template->assign_block_vars('playedrow', array(
			'GAME_ID'			=> $row['game_id'],
			'GAME_NAME'			=> $row['game_name'],
			'GAME_IMAGE'		=> $row['game_image'],
			'GAME_PLAYS'		=> $row['game_plays'],
			'GAME_RATING'		=> $rstars . $kmextra,
			'GAME_NUM_RATINGS'	=> $row['game_num_ratings'],
			'GAME_SIZE'			=> get_file_size("flash/" . $row['game_filename'])
	));
}
$db->sql_freeresult($result);

// Grab game details for game display based on rating
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games 
	WHERE game_enabled = 1
	ORDER BY game_rating DESC, game_num_ratings DESC
	LIMIT 3';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	if ($row['game_rating'] >  0)
	{
		$rstars = "<img src='flash/images/included/star_" . $row['game_rating'] . ".gif' alt='" . $row['game_rating'] . "' />";
	}
	else
	{
		$rstars = "<img src='flash/images/included/star.gif' alt='0' />";
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
	// Send vars to template
	$template->assign_block_vars('ratingrow', array(
			'GAME_ID'			=> $row['game_id'],
			'GAME_NAME'			=> $row['game_name'],
			'GAME_IMAGE'		=> $row['game_image'],
			'GAME_PLAYS'		=> $row['game_plays'],
			'GAME_RATING'		=> $rstars . $kmextra,
			'GAME_NUM_RATINGS'	=> $row['game_num_ratings'],
			'GAME_SIZE'			=> get_file_size("flash/" . $row['game_filename'])
	));
}
$db->sql_freeresult($result);

$user_golds = 0;
$user_silvers = 0;
$user_bronzes = 0;
$bronze = "<img src='flash/images/included/trophy_bronze.gif' align='absmiddle' alt='bronze' />";
$silver = "<img src='flash/images/included/trophy_silver.gif' align='absmiddle' alt='silver' />";
$gold = "<img src='flash/images/included/trophy_gold.gif' align='absmiddle' alt='gold' />";

$sql = 'SELECT trophy_user_gold, trophy_user_silver, trophy_user_bronze
	FROM ' . $db_prefix . '_ar_trophies
	WHERE trophy_user_gold = ' . $user->id . '
		OR trophy_user_silver = ' . $user->id . '
		OR trophy_user_bronze = ' . $user->id;
$result2 = $db->sql_query($sql);
while ($row2 = $db->sql_fetchrow($result2))
{
	@$user_gold_count[$row2['trophy_user_gold']] += 1;
	@$user_silver_count[$row2['trophy_user_silver']] += 1;
	@$user_bronze_count[$row2['trophy_user_bronze']] += 1;
}
$db->sql_freeresult($result2);

if (!isset($user_gold_count[$user->id]))
{
	$user_gold_count[$user->id] = 0;
}
if (!isset($user_silver_count[$user->id]))
{
	$user_silver_count[$user->id] = 0;
}
if (!isset($user_bronze_count[$user->id]))
{
	$user_bronze_count[$user->id] = 0;
}

$template->assign_vars(array(
	'GOLD'			=> $gold,
	'SILVER'		=> $silver,
	'BRONZE'		=> $bronze,
	'USER_GOLD'		=> $user_gold_count[$user->id],
	'USER_SILVER'	=> $user_silver_count[$user->id],
	'USER_BRONZE'	=> $user_bronze_count[$user->id]
));

// Check how many games the user has played
$sql = 'SELECT played_games
	FROM ' . $db_prefix . '_ar_played
	WHERE played_user = ' . (int) $user->id;
$result = $db->sql_query($sql);
$played_games = array();
while ($row = $db->sql_fetchrow($result))
{
	$played_games = explode('-', $row['played_games']);
}
$db->sql_freeresult($result);
$games_played = sizeof($played_games);
$sql = 'SELECT COUNT(rating_id) AS row_count FROM ' . $db_prefix . '_ar_ratings  WHERE rating_user = ' . (int) $user->id;
$result = $db->sql_query($sql);
$rated_games = (int) $db->sql_fetchfield('row_count');
$template->assign_vars(array(
	'PLAYED_GAMES'		=> $games_played,
	'TOTAL_GAMES'		=> $total_games,
	'RATED_GAMES'		=> $rated_games
));

// Grab a random game to link to
$sql = 'SELECT game_id
	FROM ' . $db_prefix . '_ar_games 
	WHERE game_enabled = 1
	ORDER BY RAND()
	LIMIT 1';
$result = $db->sql_query($sql);
$row_count = 0;
while ($row = $db->sql_fetchrow($result))
{
	// Send vars to template
	$template->assign_vars(array(
		'RANDOM_ID'	=> $row['game_id']
	));
}
$db->sql_freeresult($result);

// Grab all games for quickJump box
$sql = 'SELECT game_id, game_name
	FROM ' . $db_prefix . '_ar_games 
	WHERE game_enabled = 1
	ORDER BY game_name';
$result = $db->sql_query($sql);
$row_count = 0;
while ($row = $db->sql_fetchrow($result))
{
	$template->assign_block_vars('quickjumprow', array(
		'GAME_ID'			=> $row['game_id'],
		'GAME_NAME'			=> $row['game_name']
	));
}
$db->sql_freeresult($result);

$sql_addition = '';
if ($user->user)
{
	// Grab game details for favorites display
	$sql = 'SELECT favorite_game
		FROM ' . $db_prefix . '_ar_favorites 
		WHERE favorite_user = ' . $user->id;
	$result = $db->sql_query($sql);
	$count = 1;
	while ($row = $db->sql_fetchrow($result))
	{
		if ($count < 2)
		{
			$sql_addition = 'WHERE game_id = ' . $row['favorite_game'];
		}
		else
		{
			$sql_addition .= ' OR game_id = ' . $row['favorite_game'];
		}
		$count++;
	}
	$db->sql_freeresult($result);
}

if (@$sql_addition)
{
	$sql_addition .= ' AND game_enabled = 1';
}
else
{
	$sql_addition = 'WHERE game_enabled = 1';
}

// Grab game details for favorites section
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games 
	' . $sql_addition . '
	ORDER BY RAND()
	LIMIT 8';
$result = $db->sql_query($sql);
$row_count = 0;
while ($row = $db->sql_fetchrow($result))
{
	if ($row['game_rating'] >  0)
	{
		$rstars = "<img src='flash/images/included/star_" . $row['game_rating'] . ".gif' alt='" . $row['game_rating'] . "' />";
	}
	else
	{
		$rstars = "<img src='flash/images/included/star.gif' alt='0' />";
	}
	$row_count++;
	$kmextra = '&nbsp;';
	if ($row['game_keyboard'] == 1)
	{
		$kmextra .= "<img src='flash/images/included/keyboard.gif' alt='keyboard' />&nbsp;";
	}
	if ($row['game_mouse'] == 1)
	{
		$kmextra .= "<img src='flash/images/included/mouse.gif' alt='mouse' />&nbsp;";
	}
	if ($sql_addition)
	{
		// Send vars to template
		$template->assign_vars(array(
			'S_FAVORITE_GAMES'	=> true
		));
	}
	$template->assign_block_vars('favoriterow', array(
			'ROW_COUNT'			=> $row_count,
			'GAME_ID'			=> $row['game_id'],
			'GAME_NAME'			=> $row['game_name'],
			'GAME_IMAGE'		=> $row['game_image'],
			'GAME_PLAYS'		=> $row['game_plays'],
			'GAME_RATING'		=> $rstars . $kmextra,
			'GAME_NUM_RATINGS'	=> $row['game_num_ratings'],
			'GAME_SIZE'			=> get_file_size("flash/" . $row['game_filename'])
	));
}
$db->sql_freeresult($result);

if (($row_count & 1) != 0)
{
	$template->assign_vars(array(
		'S_LAST_PART'	=> true
	));
	$rand_count = round($row_count / 2);
}
else
{
	$rand_count = floor($row_count / 2);
}
// Grab game details for random game display
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games 
	WHERE game_enabled = 1
	ORDER BY RAND()
	LIMIT ' . $rand_count;
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	if ($row['game_rating'] >  0)
	{
		$rstars = "<img src='flash/images/included/star_" . $row['game_rating'] . ".gif' alt='" . $row['game_rating'] . "' />";
	}
	else
	{
		$rstars = "<img src='flash/images/included/star.gif' alt='0' />";
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
	// Send vars to template
	$template->assign_block_vars('randomrow', array(
			'GAME_ID'			=> $row['game_id'],
			'GAME_NAME'			=> $row['game_name'],
			'GAME_IMAGE'		=> $row['game_image'],
			'GAME_PLAYS'		=> $row['game_plays'],
			'GAME_RATING'		=> $rstars . $kmextra,
			'GAME_NUM_RATINGS'	=> $row['game_num_ratings'],
			'GAME_SIZE'			=> get_file_size("flash/" . $row['game_filename'])
	));
}
$db->sql_freeresult($result);

$user_golds = 0;
$user_silvers = 0;
$user_bronzes = 0;
$bronze = "<img src='flash/images/included/trophy_bronze.gif' align='absmiddle' alt='bronze' />";
$silver = "<img src='flash/images/included/trophy_silver.gif' align='absmiddle' alt='silver' />";
$gold = "<img src='flash/images/included/trophy_gold.gif' align='absmiddle' alt='gold' />";
$bronze_crown = "<img src='flash/images/included/bronze_crown.png' align='absmiddle' alt='bronze' />";
$silver_crown = "<img src='flash/images/included/silver_crown.png' align='absmiddle' alt='silver' />";
$gold_crown = "<img src='flash/images/included/gold_crown.png' align='absmiddle' alt='gold' />";

$user_score = array();

$sql = 'SELECT trophy_user_gold, trophy_user_silver, trophy_user_bronze FROM ' . $db_prefix . '_ar_trophies';
$result2 = $db->sql_query($sql);
$user_ids = array();
while ($row2 = $db->sql_fetchrow($result2))
{
	@$user_score[$row2['trophy_user_gold']] += 3;
	@$user_gold[$row2['trophy_user_gold']] += 1;
	
	@$user_score[$row2['trophy_user_silver']] += 2;
	@$user_silver[$row2['trophy_user_silver']] += 1;
	
	@$user_score[$row2['trophy_user_bronze']] += 1;
	@$user_bronze[$row2['trophy_user_bronze']] += 1;
}

arsort($user_score);
$limit = 0;
foreach($user_score as $user_id => $value)
{
	if ($limit < 3)
	{
		$sql = 'SELECT U.username, L.group_colour
			FROM ' . $db_prefix . '_users U, ' . $db_prefix . '_level_settings L
			WHERE U.id = ' . (int) $user_id . '
			AND 
			L.group_id = U.can_do';
		$result2 = $db->sql_query($sql);
		$row2 = $db->sql_fetchrow($result2);
		$user_names[$user_id] = get_username_string('full', $user_id, $row2['username'], $row2['group_colour'], $row2['username']);
		$db->sql_freeresult($result2);
	}
	$limit++;
}
if (@is_array($user_score))
{
	arsort($user_score);
	$top_users = 0;
	foreach($user_score as $key => $value)
	{
		if($top_users == 0)
		{
			$number_one = $key;
		}
		if($top_users == 1)
		{
			$number_two = $key;
		}
		if($top_users == 2)
		{
			$number_three = $key;
		}
		$top_users++;
	}
	$values = array($number_one, $number_two, $number_three);
	foreach ($values as $value)
	{
		if (!isset($user_gold[$value]))
		{
			$user_gold[$value] = 0;
		}
		if (!isset($user_silver[$value]))
		{
			$user_silver[$value] = 0;
		}
		if (!isset($user_bronze[$value]))
		{
			$user_bronze[$value] = 0;
		}
	}
	
	// Send vars to template
	$template->assign_block_vars('toprow', array(
			'TROPHY'			=> $silver_crown,
			'USER_NAME'			=> $user_names[$number_two],
			'USER_GOLD'			=> $user_gold[$number_two],
			'USER_SILVER'		=> $user_silver[$number_two],
			'USER_BRONZE'		=> $user_bronze[$number_two]
	));
	// Send vars to template
	$template->assign_block_vars('toprow', array(
			'TROPHY'			=> $gold_crown,
			'USER_NAME'			=> $user_names[$number_one],
			'USER_GOLD'			=> $user_gold[$number_one],
			'USER_SILVER'		=> $user_silver[$number_one],
			'USER_BRONZE'		=> $user_bronze[$number_one]
	));
	// Send vars to template
	$template->assign_block_vars('toprow', array(
			'TROPHY'			=> $bronze_crown,
			'USER_NAME'			=> $user_names[$number_three],
			'USER_GOLD'			=> $user_gold[$number_three],
			'USER_SILVER'		=> $user_silver[$number_three],
			'USER_BRONZE'		=> $user_bronze[$number_three]
	));
}

// Check if games can be commented on
$sql = 'SELECT COUNT(setting_id) AS row_count FROM ' . $db_prefix . '_ar_settings  WHERE setting_id = 1 AND setting_value = 1';
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
if ($row_count || $auth->acl_get('u_arcade_stats'))
{
	// Get arcade stats
	$sql = 'SELECT SUM(game_plays) AS total_plays FROM ' . $db_prefix . '_ar_games  WHERE game_enabled = 1';
	$result = $db->sql_query($sql);
		$total_plays = (int) $db->sql_fetchfield('total_plays');
	$db->sql_freeresult($result);
	$sql = 'SELECT SUM(game_num_ratings) AS total_ratings FROM ' . $db_prefix . '_ar_games  WHERE game_enabled = 1';
	$result = $db->sql_query($sql);
		$total_ratings = (int) $db->sql_fetchfield('total_ratings');
	$db->sql_freeresult($result);
	$sql = 'SELECT AVG(game_rating) average_rating FROM ' . $db_prefix . '_ar_games  WHERE game_rating > 0 AND game_enabled = 1';
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
		'S_STATISTICS'			=> true,
		'TOTAL_PLAYS'			=> $total_plays,
		'TOTAL_RATINGS'			=> $total_ratings,
		'AVG_RATING'			=> $average_rating,
		'TOTAL_FAVORITES'		=> $total_favorites,
		'TOTAL_COMMENTS'		=> $total_comments,
		'TOKENS_SPENT'			=> 0,
		'TICKETS_DISPENSED'		=> 0,
		'TOTAL_SWF_SIZE'		=> $total_swf_size,
		'TOTAL_IMG_SIZE'		=> $total_img_size,
		'PLAYS_PER_DAY'			=> round($plays_per_day, 2)
	));
}
$db->sql_freeresult($result);
echo $template->fetch('arcade_body.html');
close_out();
?>