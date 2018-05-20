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
** File acp_search.php 2018-05-18 14:32:00 Black_Heart
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

/**
* @package acp
*/
class acp_search
{
	var $u_action;
	var $state;
	var $search;
	var $max_post_id;
	var $batch_size = 100;

	function main($id, $mode)
	{
		global $user;

		$user->set_lang('admin/acp_search',$user->ulanguage);

		// For some this may be of help...
		@ini_set('memory_limit', '128M');

		switch ($mode)
		{
			case 'settings':
				$this->settings($id, $mode);
			break;

			case 'index':
				$this->index($id, $mode);
			break;
		}
	}

	function settings($id, $mode)
	{
		global $db, $user, $auth, $db_prefix, $template, $pmbt_cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$submit = (isset($_POST['submit'])) ? true : false;

		$search_types = $this->get_search_types();

		$settings = array(
			'search_interval'			=> 'float',
			'search_anonymous_interval'	=> 'float',
			'load_search'				=> 'bool',
			'limit_search_load'			=> 'float',
			'min_search_author_chars'	=> 'integer',
			'max_num_search_keywords'	=> 'integer',
			'search_store_results'		=> 'integer',
			'search_block_size'			=> 'integer',
		);

		$search = null;
		$error = false;
		$search_options = '';
		foreach ($search_types as $type)
		{
			if ($this->init_search($type, $search, $error))
			{
				continue;
			}

			$name = ucfirst(strtolower(str_replace('_', ' ', $type)));
			$selected = ($config['search_type'] == $type) ? ' selected="selected"' : '';
			$search_options .= '<option value="' . $type . '"' . $selected . '>' . $name . '</option>';

			if (method_exists($search, 'acp'))
			{
				$vars = $search->acp();

				if (!$submit)
				{
					$template->assign_block_vars('backend', array(
						'NAME'		=> $name,
						'SETTINGS'	=> $vars['tpl'])
					);
				}
				else if (is_array($vars['config']))
				{
					$settings = array_merge($settings, $vars['config']);
				}
			}
		}
		unset($search);
		unset($error);

		$cfg_array = (isset($_REQUEST['config'])) ? request_var('config', array('' => ''), true) : array();
		$updated = request_var('updated', false);

		foreach ($settings as $config_name => $var_type)
		{
			if (!isset($cfg_array[$config_name]))
			{
				continue;
			}

			// e.g. integer:4:12 (min 4, max 12)
			$var_type = explode(':', $var_type);

			$config_value = $cfg_array[$config_name];
			settype($config_value, $var_type[0]);

			if (isset($var_type[1]))
			{
				$config_value = max($var_type[1], $config_value);
			}

			if (isset($var_type[2]))
			{
				$config_value = min($var_type[2], $config_value);
			}

			// only change config if anything was actually changed
			if ($submit && ($config[$config_name] != $config_value))
			{
				set_config($config_name, $config_value);
				$updated = true;
			}
		}

		if ($submit)
		{
			$extra_message = '';
			if ($updated)
			{
				add_log('admin', 'LOG_CONFIG_SEARCH');
			}

			if (isset($cfg_array['search_type']) && in_array($cfg_array['search_type'], $search_types, true) && ($cfg_array['search_type'] != $config['search_type']))
			{
				$search = null;
				$error = false;

				if (!$this->init_search($cfg_array['search_type'], $search, $error))
				{
					if (confirm_box(true))
					{
						if (!method_exists($search, 'init') || !($error = $search->init()))
						{
							set_config('search_type', $cfg_array['search_type']);

							if (!$updated)
							{
								add_log('admin', 'LOG_CONFIG_SEARCH');
							}
							$extra_message = '<br />' . $user->lang['SWITCHED_SEARCH_BACKEND'] . '<br /><a href="' . append_sid("{$phpbb_admin_path}admin.$phpEx", 'op=forum_search&amp;action=search&amp;i=siteinfo&amp;mode=index') . '">&raquo; ' . $user->lang['GO_TO_SEARCH_INDEX'] . '</a>';
						}
						else
						{
							trigger_error($error . adm_back_link($this->u_action), E_USER_WARNING);
						}
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_SEARCH_BACKEND'], build_hidden_fields(array(

							'i'			=> $id,
							'op'		=> 'forum_search',
							'mode'		=> $mode,
							'action'	=> 'search',
							'submit'	=> true,
							'updated'	=> $updated,
							'config'	=> array('search_type' => $cfg_array['search_type']),
						)));
					}
				}
				else
				{
					trigger_error($error . adm_back_link($this->u_action), E_USER_WARNING);
				}
			}

			$search = null;
			$error = false;
			if (!$this->init_search($config['search_type'], $search, $error))
			{
				if ($updated)
				{
					if (method_exists($search, 'config_updated'))
					{
						if ($search->config_updated())
						{
							trigger_error($error . adm_back_link($this->u_action), E_USER_WARNING);
						}
					}
				}
			}
			else
			{
				trigger_error($error . adm_back_link($this->u_action), E_USER_WARNING);
			}

			trigger_error($user->lang['CONFIG_UPDATED'] . $extra_message . adm_back_link($this->u_action));
		}
		unset($cfg_array);

		$this->tpl_name = 'acp_search';
		$this->page_title = 'ACP_SEARCH_SETTINGS';

		$template->assign_vars(array(
			'LIMIT_SEARCH_LOAD'		=> (float) $config['limit_search_load'],
			'MIN_SEARCH_AUTHOR_CHARS'	=> (int) $config['min_search_author_chars'],
			'SEARCH_INTERVAL'		=> (float) $config['search_interval'],
			'SEARCH_GUEST_INTERVAL'	=> (float) $config['search_anonymous_interval'],
			'SEARCH_STORE_RESULTS'	=> (int) $config['search_store_results'],
			'MAX_NUM_SEARCH_KEYWORDS'	=> (int) $config['max_num_search_keywords'],
			'SEARCH_BLOCK_SIZE'	=> (int) $config['search_block_size'],

			'S_SEARCH_TYPES'		=> $search_options,
			'S_YES_SEARCH'			=> (bool) $config['load_search'],
			'S_SETTINGS'			=> true,

			'U_ACTION'				=> $this->u_action)
		);
	}

	function index($id, $mode)
	{
		global $db, $user, $auth, $db_prefix, $template, $pmbt_cache;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		if (isset($_REQUEST['a_action']) && is_array($_REQUEST['a_action']))
		{
			$a_action = request_var('a_action', array('' => false));
			$a_action = key($a_action);
		}
		else
		{
			$a_action = request_var('a_action', '');
		}
		$this->state = explode(',', $config['search_indexing_state']);

		if (isset($_POST['cancel']))
		{
			$a_action = '';
			$this->state = array();
			$this->save_state();
		}

		if ($a_action)
		{
			switch ($a_action)
			{
				case 'progress_bar':
					$type = request_var('type', '');
					$this->display_progress_bar($type);
				break;

				case 'delete':
					$this->state[1] = 'delete';
				break;

				case 'create':
					$this->state[1] = 'create';
				break;

				default:
					trigger_error('NO_ACTION', E_USER_ERROR);
				break;
			}

			if (empty($this->state[0]))
			{
				$this->state[0] = request_var('search_type', '');
			}

			$this->search = null;
			$error = false;
			if ($this->init_search($this->state[0], $this->search, $error))
			{
				trigger_error($error . adm_back_link($this->u_action), E_USER_WARNING);
			}
			$name = ucfirst(strtolower(str_replace('_', ' ', $this->state[0])));

			$a_action = &$this->state[1];

			$this->max_post_id = $this->get_max_post_id();

			$post_counter = (isset($this->state[2])) ? $this->state[2] : 0;
			$this->state[2] = &$post_counter;
			$this->save_state();

			switch ($a_action)
			{
				case 'delete':
					if (method_exists($this->search, 'delete_index'))
					{
						// pass a reference to myself so the $search object can make use of save_state() and attributes
						if ($error = $this->search->delete_index($this, append_sid("{$phpbb_admin_path}index.$phpEx", "i=$id&mode=$mode&action=delete", false)))
						{
							$this->state = array('');
							$this->save_state();
							trigger_error($error . adm_back_link($this->u_action) . $this->close_popup_js(), E_USER_WARNING);
						}
					}
					else
					{
						$starttime = explode(' ', microtime());
						$starttime = $starttime[1] + $starttime[0];
						$row_count = 0;
						while (still_on_time() && $post_counter <= $this->max_post_id)
						{
							$sql = 'SELECT post_id, poster_id, forum_id
								FROM ' . $db_prefix . '_posts
								WHERE post_id >= ' . (int) ($post_counter + 1) . '
									AND post_id <= ' . (int) ($post_counter + $this->batch_size);
							$result = $db->sql_query($sql);

							$ids = $posters = $forum_ids = array();
							while ($row = $db->sql_fetchrow($result))
							{
								$ids[] = $row['post_id'];
								$posters[] = $row['poster_id'];
								$forum_ids[] = $row['forum_id'];
							}
							$db->sql_freeresult($result);
							$row_count += sizeof($ids);

							if (sizeof($ids))
							{
								$this->search->index_remove($ids, $posters, $forum_ids);
							}

							$post_counter += $this->batch_size;
						}
						// save the current state
						$this->save_state();

						if ($post_counter <= $this->max_post_id)
						{
							$mtime = explode(' ', microtime());
							$totaltime = $mtime[0] + $mtime[1] - $starttime;
							$rows_per_second = $row_count / $totaltime;
							meta_refresh(1, append_sid($this->u_action . '&amp;action=delete&amp;skip_rows=' . $post_counter));
							trigger_error(sprintf($user->lang['SEARCH_INDEX_DELETE_REDIRECT'], $post_counter, $row_count, $rows_per_second));
						}
					}

					$this->search->tidy();

					$this->state = array('');
					$this->save_state();

					add_log('admin', 'LOG_SEARCH_INDEX_REMOVED', $name);
					trigger_error($user->lang['SEARCH_INDEX_REMOVED'] . adm_back_link($this->u_action) . $this->close_popup_js());
				break;

				case 'create':
					if (method_exists($this->search, 'create_index'))
					{
						// pass a reference to acp_search so the $search object can make use of save_state() and attributes
						if ($error = $this->search->create_index($this, append_sid("{$phpbb_admin_path}index.$phpEx", "i=$id&mode=$mode&action=create", false)))
						{
							$this->state = array('');
							$this->save_state();
							trigger_error($error . adm_back_link($this->u_action) . $this->close_popup_js(), E_USER_WARNING);
						}
					}
					else
					{
						$sql = 'SELECT forum_id, enable_indexing
							FROM ' . $db_prefix . '_forums';
						$result = $db->sql_query($sql);

						while ($row = $db->sql_fetchrow($result))
						{
							$forums[$row['forum_id']] = (bool) $row['enable_indexing'];
						}
						$db->sql_freeresult($result);

						$starttime = explode(' ', microtime());
						$starttime = $starttime[1] + $starttime[0];
						$row_count = 0;
						while (still_on_time() && $post_counter <= $this->max_post_id)
						{
							$sql = 'SELECT post_id, post_subject, post_text, poster_id, forum_id
								FROM ' . $db_prefix . '_posts
								WHERE post_id >= ' . (int) ($post_counter + 1) . '
									AND post_id <= ' . (int) ($post_counter + $this->batch_size);
							$result = $db->sql_query($sql);

							$buffer = true;//$db->sql_buffer_nested_transactions();

							if ($buffer)
							{
								$rows = $db->sql_fetchrowset($result);
								$rows[] = false; // indicate end of array for while loop below

								$db->sql_freeresult($result);
							}

							$i = 0;
							while ($row = ($buffer ? $rows[$i++] : $db->sql_fetchrow($result)))
							{
								// Indexing enabled for this forum or global announcement?
								// Global announcements get indexed by default.
								if (!$row['forum_id'] || (isset($forums[$row['forum_id']]) && $forums[$row['forum_id']]))
								{
									$this->search->index('post', $row['post_id'], $row['post_text'], $row['post_subject'], $row['poster_id'], $row['forum_id']);
								}
								$row_count++;
							}
							if (!$buffer)
							{
								$db->sql_freeresult($result);
							}

							$post_counter += $this->batch_size;
						}
						// save the current state
						$this->save_state();

						// pretend the number of posts was as big as the number of ids we indexed so far
						// just an estimation as it includes deleted posts
						$num_posts = $config['num_posts'];
						$config['num_posts'] = min($config['num_posts'], $post_counter);
						$this->search->tidy();
						$config['num_posts'] = $num_posts;

						if ($post_counter <= $this->max_post_id)
						{
							$mtime = explode(' ', microtime());
							$totaltime = $mtime[0] + $mtime[1] - $starttime;
							$rows_per_second = $row_count / $totaltime;
							meta_refresh(1, append_sid($this->u_action . '&amp;action=create&amp;skip_rows=' . $post_counter));
							trigger_error(sprintf($user->lang['SEARCH_INDEX_CREATE_REDIRECT'], $post_counter, $row_count, $rows_per_second));
						}
					}

					$this->search->tidy();

					$this->state = array('');
					$this->save_state();

					add_log('admin', 'LOG_SEARCH_INDEX_CREATED', $name);
					trigger_error($user->lang['SEARCH_INDEX_CREATED'] . adm_back_link($this->u_action) . $this->close_popup_js());
				break;
			}
		}

		$search_types = $this->get_search_types();

		$search = null;
		$error = false;
		$search_options = '';
		foreach ($search_types as $type)
		{
			if ($this->init_search($type, $search, $error) || !method_exists($search, 'index_created'))
			{
				continue;
			}

			$name = ucfirst(strtolower(str_replace('_', ' ', $type)));

			$data = array();
			if (method_exists($search, 'index_stats'))
			{
				$data = $search->index_stats();
			}

			$statistics = array();
			foreach ($data as $statistic => $value)
			{
				$n = sizeof($statistics);
				if ($n && sizeof($statistics[$n - 1]) < 3)
				{
					$statistics[$n - 1] += array('statistic_2' => $statistic, 'value_2' => $value);
				}
				else
				{
					$statistics[] = array('statistic_1' => $statistic, 'value_1' => $value);
				}
			}

			$template->assign_block_vars('backend', array(
				'L_NAME'			=> $name,
				'NAME'				=> $type,

				'S_ACTIVE'			=> ($type == $config['search_type']) ? true : false,
				'S_HIDDEN_FIELDS'	=> build_hidden_fields(array('search_type' => $type)),
				'S_INDEXED'			=> (bool) $search->index_created(),
				'S_STATS'			=> (bool) sizeof($statistics))
			);

			foreach ($statistics as $statistic)
			{
				$template->assign_block_vars('backend.data', array(
					'STATISTIC_1'	=> $statistic['statistic_1'],
					'VALUE_1'		=> $statistic['value_1'],
					'STATISTIC_2'	=> (isset($statistic['statistic_2'])) ? $statistic['statistic_2'] : '',
					'VALUE_2'		=> (isset($statistic['value_2'])) ? $statistic['value_2'] : '')
				);
			}
		}
		unset($search);
		unset($error);
		unset($statistics);
		unset($data);

		$this->tpl_name = 'acp_search';
		$this->page_title = 'ACP_SEARCH_INDEX';

		$template->assign_vars(array(
			'S_INDEX'				=> true,
			'U_ACTION'				=> $this->u_action,
			'U_PROGRESS_BAR'		=> append_sid("admin.$phpEx", "op=forum_search&amp;action=search&amp;i=$id&amp;mode=$mode&amp;a_action=progress_bar"),
			'UA_PROGRESS_BAR'		=> addslashes(append_sid("admin.$phpEx", "op=forum_search&amp;action=search&amp;i=$id&amp;mode=$mode&amp;a_action=progress_bar")),
		));

		if (isset($this->state[1]))
		{
			$template->assign_vars(array(
				'S_CONTINUE_INDEXING'	=> $this->state[1],
				'U_CONTINUE_INDEXING'	=> $this->u_action . '&amp;action=' . $this->state[1],
				'L_CONTINUE'			=> ($this->state[1] == 'create') ? $user->lang['CONTINUE_INDEXING'] : $user->lang['CONTINUE_DELETING_INDEX'],
				'L_CONTINUE_EXPLAIN'	=> ($this->state[1] == 'create') ? $user->lang['CONTINUE_INDEXING_EXPLAIN'] : $user->lang['CONTINUE_DELETING_INDEX_EXPLAIN'])
			);
		}
	}

	function display_progress_bar($type)
	{
		global $template, $user;

		$l_type = ($type == 'create') ? 'INDEXING_IN_PROGRESS' : 'DELETING_INDEX_IN_PROGRESS';

		//adm_page_header($user->lang[$l_type]);

		$template->set_filenames(array(
			'body'	=> 'progress_bar.html')
		);

		$template->assign_vars(array(
			'L_PROGRESS'			=> $user->lang[$l_type],
			'L_PROGRESS_EXPLAIN'	=> $user->lang[$l_type . '_EXPLAIN'])
		);

			echo $template->fetch('admin/progress_bar.html');
			close_out();
			die();
	}

	function close_popup_js()
	{
		return "<script type=\"text/javascript\">\n" .
			"// <![CDATA[\n" .
			"	close_waitscreen = 1;\n" .
			"// ]]>\n" .
			"</script>\n";
	}

	function get_search_types()
	{
		global $phpbb_root_path, $phpEx;

		$search_types = array();

		$dp = @opendir($phpbb_root_path . 'include/search');

		if ($dp)
		{
			while (($file = readdir($dp)) !== false)
			{
				if ((preg_match('#\.' . $phpEx . '$#', $file)) && ($file != "search.$phpEx"))
				{
					$search_types[] = preg_replace('#^(.*?)\.' . $phpEx . '$#', '\1', $file);
				}
			}
			closedir($dp);

			sort($search_types);
		}

		return $search_types;
	}

	function get_max_post_id()
	{
		global $db, $db_prefix;

		$sql = 'SELECT MAX(post_id) as max_post_id
			FROM '. $db_prefix . '_posts';
		$result = $db->sql_query($sql);
		$max_post_id = (int) $db->sql_fetchfield('max_post_id');
		$db->sql_freeresult($result);

		return $max_post_id;
	}

	function save_state($state = false)
	{
		if ($state)
		{
			$this->state = $state;
		}

		ksort($this->state);

		set_config('search_indexing_state', implode(',', $this->state), true);
	}

	/**
	* Initialises a search backend object
	*
	* @return false if no error occurred else an error message
	*/
	function init_search($type, &$search, &$error)
	{
		global $phpbb_root_path, $phpEx, $user;

		if (!preg_match('#^\w+$#', $type) || !file_exists("{$phpbb_root_path}include/search/$type.$phpEx"))
		{
			$error = $user->lang['NO_SUCH_SEARCH_MODULE'];
			return $error;
		}

		include_once("{$phpbb_root_path}include/search/$type.$phpEx");

		if (!class_exists($type))
		{
			$error = $user->lang['NO_SUCH_SEARCH_MODULE'];
			return $error;
		}

		$error = false;
		$search = new $type($error);

		return $error;
	}
}

function still_on_time($extra_time = 15)
{
	static $max_execution_time, $start_time;

	$time = explode(' ', microtime());
	$current_time = $time[0] + $time[1];

	if (empty($max_execution_time))
	{
		$max_execution_time = (function_exists('ini_get')) ? (int) @ini_get('max_execution_time') : (int) @get_cfg_var('max_execution_time');

		// If zero, then set to something higher to not let the user catch the ten seconds barrier.
		if ($max_execution_time === 0)
		{
			$max_execution_time = 50 + $extra_time;
		}

		$max_execution_time = min(max(10, ($max_execution_time - $extra_time)), 50);

		// For debugging purposes
		// $max_execution_time = 10;

		global $starttime;
		$start_time = (empty($starttime)) ? $current_time : $starttime;
	}

	return (ceil($current_time - $start_time) < $max_execution_time) ? true : false;
}
?>