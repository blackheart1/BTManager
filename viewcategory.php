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
** File viewcategory.php 2018-02-17 14:32:00 Black_Heart
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
//include('include/functions_display.' . $phpEx);
include('include/file_functions.' . $phpEx);

$action	= request_var('action', '');
$game_id = request_var('g', 0);
$category_id = request_var('c', 0);
$offset = request_var('start', 0);
$search = request_var('keywords', '');

if (strlen($search) < 2)
{
	$search = '';
}

$user->set_lang('arcade',$user->ulanguage);
//$user->setup('posting');
// End session management

if (!$auth->acl_get('u_arcade_view_arcade'))
{
     trigger_error('NOT_AUTHORISED');
}

$template = new Template();
set_site_var('arcade');


if ($auth->acl_get('u_arcade_favorites'))
{
	$allow_favorites = true;
}
else
{
	$allow_favorites = false;
}

$template->assign_block_vars('navlinks', array(
	'FORUM_NAME'	=> $user->lang['ARCADE'],
	'U_VIEW_FORUM'	=> append_sid("arcade.$phpEx", '', true, $user->session_id))
);

// Check if category_id is a valid category
$sql = 'SELECT COUNT(category_id) AS row_count FROM ' . $db_prefix . "_ar_categories  WHERE category_id = $category_id";
$result = $db->sql_query($sql);
$row_count = (int) $db->sql_fetchfield('row_count');
if (!$row_count && $category_id != 0 && $category_id != 105121)
{
	header("Location: arcade.php");
}
$db->sql_freeresult($result);

$sql_addition_extra = '';
$sql_addition = '';

if ($category_id == 105121)
{
	// Grab game details for category display
	$sql = 'SELECT favorite_game
		FROM ' . $db_prefix . '_ar_favorites 
		WHERE favorite_user = ' . $user->id;
	$result = $db->sql_query($sql);
	$count = 1;
	while ($row = $db->sql_fetchrow($result))
	{
		if ($count < 2)
		{
			$sql_addition = 'WHERE game_id = ' . $row['favorite_game'] . ' AND game_enabled = 1';
			$sql_addition_extra = 'WHERE game_id = ' . $row['favorite_game'];
		}
		else
		{
			$sql_addition .= ' OR game_id = ' . $row['favorite_game'] . ' AND game_enabled = 1';
			$sql_addition_extra .= ' OR game_id = ' . $row['favorite_game'];
		}
		$count++;
	}
	$db->sql_freeresult($result);
}
else if ($category_id)
{
	$sql_addition = 'WHERE game_enabled = 1 AND game_category = ' . $category_id;
	$sql_addition_extra = ' WHERE game_category = ' . $category_id;
}
else
{
	$sql_addition = 'WHERE game_enabled = 1';
}

if ($category_id == 0)
{
	if ($auth->acl_get('a_arcade_manage'))
	{
		// Generate Pagination
		$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . "_ar_games";
		$result = $db->sql_query($sql);
		$total_games = (int) $db->sql_fetchfield('row_count');
	}
	else
	{
		// Generate Pagination
		$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 1';
		$result = $db->sql_query($sql);
		$total_games = (int) $db->sql_fetchfield('row_count');
	}
}
else if ($category_id == 105121 && $allow_favorites)
{
	// Generate Pagination
	$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games ' . $sql_addition;
	$result = $db->sql_query($sql);
	$total_games = (int) $db->sql_fetchfield('row_count');
	$template->assign_vars(array(
		'L_FAV_GAMES'	=> '(' . $total_games . ')',
		'S_FAVORITES'	=> true
	));
}
else
{
	// Generate Pagination
	$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 1 AND game_category = ' . $category_id;
	$result = $db->sql_query($sql);
	$total_games = (int) $db->sql_fetchfield('row_count');
}
$pagination = generate_pagination(append_sid("viewcategory.$phpEx", "c=$category_id", true, $user->session_id), $total_games, 10, $offset);
if(!$search)
{
	$template->assign_vars(array(
		'CAT_NUM_GAMES'	=> $total_games,
		'PAGINATION' 	=> $pagination,
		'PAGE_NUMBER' 	=> on_page($total_games, 10, $offset),
	));
}

// Grab game details for category display
$sql = 'SELECT favorite_game
	FROM ' . $db_prefix . '_ar_favorites 
	WHERE favorite_user = ' . $user->id;
$result = $db->sql_query($sql);
$count = 1;
while ($row = $db->sql_fetchrow($result))
{
	if ($count < 2)
	{
		$sql_addition2 = 'WHERE game_id = ' . $row['favorite_game'] . ' AND game_enabled = 1';
	}
	else
	{
		@$sql_addition2 .= ' OR game_id = ' . $row['favorite_game'] . ' AND game_enabled = 1';
	}
	$count++;
}
$db->sql_freeresult($result);

if (isset($sql_addition2))
{
	// Check Favorite games count
	@$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games ' . $sql_addition2;
	$result = $db->sql_query($sql);
	$total_games = (int) $db->sql_fetchfield('row_count');
	$template->assign_vars(array(
		'L_FAV_GAMES'	=> '(' . $total_games . ')',
		'S_FAVORITES'	=> true
	));
}

if ($auth->acl_get('a_arcade_manage'))
{
	// Grab game details for a total count
	$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . "_ar_games";
	$result = $db->sql_query($sql);
	$row_count = (int) $db->sql_fetchfield('row_count');
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
}
else
{
	// Grab game details for a total count
	$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 1';
	$result = $db->sql_query($sql);
	$row_count = (int) $db->sql_fetchfield('row_count');
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
}

if ($category_id == 0)
{
	$row['category_name'] = 'All Games';
	$template->assign_vars(array(
		'S_IN_ALL_GAMES'			=> true
	));
}
else if ($category_id == 105121)
{
	$row['category_name'] = 'Favorites';
	$template->assign_vars(array(
		'S_IN_FAVORITES'			=> true
	));
}
else
{
	// Grab group details for category display
	$sql = 'SELECT category_name
		FROM ' . $db_prefix . '_ar_categories 
		WHERE category_id = ' . $category_id . '
		ORDER BY category_name';
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
}
$template->assign_vars(array(
	'CATEGORY_NAME'		=> $row['category_name'],
	'CATEGORY_ID'		=> $category_id,
	'S_ARCADE'			=> true
));

$template->assign_block_vars('navlinks', array(
	'FORUM_NAME'	=> $row['category_name'],
	'U_VIEW_FORUM'	=> append_sid("viewcategory.$phpEx", 'c=' . $category_id, true, $user->session_id))
);
$db->sql_freeresult($result);

// Grab game details for category display
$sql = 'SELECT category_id, category_name
	FROM ' . $db_prefix . '_ar_categories 
	ORDER BY category_name';
$result = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result))
{
	// Grab game details for a total count for the category
	$sql = 'SELECT COUNT(game_category) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_enabled = 1 AND game_category = ' . $row['category_id'];
	$result2 = $db->sql_query($sql);
	$row_count = (int) $db->sql_fetchfield('row_count');
	$db->sql_freeresult($result2);
	
	if ($row['category_id'] == $category_id) {
		// Send vars to template
		$template->assign_block_vars('categoryrow', array(
				'CATEGORY_ID'			=> $row['category_id'],
				'CATEGORY_NAME'			=> '<strong>' . $row['category_name'] . '</strong>',
				'CATEGORY_COUNT'		=> '(' . $row_count . ')'
		));
	}
	else
	{
		// Send vars to template
		$template->assign_block_vars('categoryrow', array(
				'CATEGORY_ID'			=> $row['category_id'],
				'CATEGORY_NAME'			=> $row['category_name'],
				'CATEGORY_COUNT'		=> '(' . $row_count . ')'
		));
	}
}
$db->sql_freeresult($result);

// Grab a random game to link to
$sql = 'SELECT game_id
	FROM ' . $db_prefix . '_ar_games ' .
	$sql_addition . '
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
	FROM ' . $db_prefix . '_ar_games ' .
	$sql_addition . '
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

// Grab game details for game display based on date added
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games
	' . $sql_addition . '
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
	' . $sql_addition . '
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
	' . $sql_addition . '
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

// Grab game details for game display of games in the category
if ($search && $auth->acl_get('a_arcade_manage'))
{
	$sql = 'SELECT *
		FROM ' . $db_prefix . '_ar_games ' .
		$sql_addition_extra . '
		ORDER BY game_name';
	$result = $db->sql_query($sql);
}
elseif ($search)
{
	$sql = 'SELECT *
		FROM ' . $db_prefix . '_ar_games
		' . $sql_addition . '
		ORDER BY game_name';
	$result = $db->sql_query($sql);
}
elseif ($auth->acl_get('a_arcade_manage'))
{
	$sql = 'SELECT *
		FROM ' . $db_prefix . '_ar_games ' .
		$sql_addition_extra . '
		ORDER BY game_name
		LIMIT ' . $offset . ',10';
	$result = $db->sql_query($sql);
}
else
{
	$sql = 'SELECT *
		FROM ' . $db_prefix . '_ar_games
		' . $sql_addition . '
		ORDER BY game_name
		LIMIT ' . $offset . ',10';
	$result = $db->sql_query($sql);
}
$cat_count = 0;
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
	
	// Check if game can be has reverse scoring
	$sql = 'SELECT COUNT(game_id) AS row_count FROM ' . $db_prefix . '_ar_games WHERE game_id = ' . $row['game_id'] . ' AND game_rev_score = 1';
	$result3 = $db->sql_query($sql);
	$row_count = (int) $db->sql_fetchfield('row_count');
	if ($row_count)
	{
		$rev_scoring = 'ASC';
	}
	else
	{
		$rev_scoring = 'DESC';
	}
	$username = '';
	// Get highest score for game
	$sql = 'SELECT highscore_user, highscore
		FROM ' . $db_prefix . '_ar_highscores
		WHERE highscore_game = ' . $row['game_id'] . '
		ORDER BY highscore ' . $rev_scoring;
	$result2 = $db->sql_query($sql);
	$row2 = $db->sql_fetchrow($result2);
	$highest_score = str_replace('.0', '', $row2['highscore']);
	$highest_score_user = $row2['highscore_user'];
	$db->sql_freeresult($result2);
	if ($highest_score)
	{
		// Grab game details for a total count for the category
		$sql = 'SELECT U.username, L.group_colour
			FROM ' . $db_prefix . '_users U, ' . $db_prefix . '_level_settings L
			WHERE U.id = ' . (int) $highest_score_user . '
			AND 
			L.group_id = U.can_do';
		$result2 = $db->sql_query($sql);
		$row2 = $db->sql_fetchrow($result2);
		$username = ' - ' . get_username_string('full', $highest_score_user, $row2['username'], $row2['group_colour'], $row2['username']);
		$db->sql_freeresult($result3);
	}
	if ($highest_score == 0)
	{
		$highest_score = '-';
	}
	if ($row['game_enabled'] == 0)
	{
		$disabled = true;
	}
	else
	{
		$disabled = false;
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
	if ($search)
	{
		$in_row = strpos(strtolower($row['game_name']), strtolower($search));

	}
	if (!$search || $in_row !== false)
	{
		$cat_count++;
		// Send vars to template
		$template->assign_block_vars('gamerow', array(
				'COUNT'				=> $cat_count,
				'GAME_ID'			=> $row['game_id'],
				'GAME_NAME'			=> $row['game_name'],
				'GAME_DESC'			=> $row['game_description'],
				'GAME_IMAGE'		=> $row['game_image'],
				'GAME_PLAYS'		=> $row['game_plays'],
				'GAME_RATING'		=> $rstars,
				'GAME_USES'			=> $kmextra,
				'GAME_NUM_RATINGS'	=> $row['game_num_ratings'],
				'GAME_SIZE'			=> get_file_size("flash/" . $row['game_filename']),
				'GAME_HIGH_SCORE'	=> $highest_score . $username,
				'S_DISABLED'		=> $disabled
		));
	}
}
$db->sql_freeresult($result);

// Grab game details for random game display
$sql = 'SELECT *
	FROM ' . $db_prefix . '_ar_games
	' . $sql_addition . '
	ORDER BY RAND()
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
echo $template->fetch('viewcategory_body.html');
close_out();
?>