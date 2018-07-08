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
** File mysqli.php 2018-02-18 10:18:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT')) die ("You can't access this file directly");

if(!defined("SQL_LAYER"))
{
	define("SQL_LAYER","mysqli");
	class sql_db
	{
		var $any_char;
		var $one_char;
	   var $sql_layer = 'mysqli';
        var $db_connect_id;
	   var $mysql_version;
        var $query_result;
        var $row = array();
        var $rowset = array();
		var $transaction = false;
       // var $num_queries = 0;
		var $multi_insert = true;
		var $connect_error = '';
		var $open_queries = array();
		var $num_queries = array(
			'cached'		=> 0,
			'normal'		=> 0,
			'total'			=> 0,
		);

		/**
		* Constuctor
		* Connect to server
		*/
		function __construct($sqlserver, $sqluser, $sqlpassword, $database, $persistency = false)
		{
			if (!function_exists('mysqli_connect'))
			{
				$this->connect_error = 'mysqli_connect function does not exist, is mysqli extension installed?';
				return $this->sql_error('');
			}
	
			// Mysqli extension supports persistent connection since PHP 5.3.0
			$this->persistency = (version_compare(PHP_VERSION, '5.3.0', '>=')) ? $persistency : false;
			$this->user = $sqluser;
	
			// If persistent connection, set dbhost to localhost when empty and prepend it with 'p:' prefix
			$this->server = ($this->persistency) ? 'p:' . (($sqlserver) ? $sqlserver : 'localhost') : $sqlserver;
	
			$this->dbname = $database;
			$port =  NULL;
				$this->any_char = chr(0) . '%';
				$this->one_char = chr(0) . '_';
	
			// If port is set and it is not numeric, most likely mysqli socket is set.
			// Try to map it to the $socket parameter.
			$socket = NULL;
			if ($port)
			{
				if (is_numeric($port))
				{
					$port = (int) $port;
				}
				else
				{
					$socket = $port;
					$port = NULL;
				}
			}
	
			$this->db_connect_id = @mysqli_connect($this->server, $this->user, $sqlpassword, $this->dbname, $port, $socket);
	
			if ($this->db_connect_id && $this->dbname != '')
			{
				@mysqli_query($this->db_connect_id, "SET NAMES 'utf8'");
	
				// enforce strict mode on databases that support it
				if (version_compare($this->sql_server_info(true), '5.0.2', '>='))
				{
					$result = @mysqli_query($this->db_connect_id, 'SELECT @@session.sql_mode AS sql_mode');
					$row = @mysqli_fetch_assoc($result);
					@mysqli_free_result($result);
	
					$modes = array_map('trim', explode(',', $row['sql_mode']));
	
					// TRADITIONAL includes STRICT_ALL_TABLES and STRICT_TRANS_TABLES
					if (!in_array('TRADITIONAL', $modes))
					{
						if (!in_array('STRICT_ALL_TABLES', $modes))
						{
							$modes[] = 'STRICT_ALL_TABLES';
						}
	
						if (!in_array('STRICT_TRANS_TABLES', $modes))
						{
							$modes[] = 'STRICT_TRANS_TABLES';
						}
					}
	
					$mode = implode(',', $modes);
					@mysqli_query($this->db_connect_id, "SET SESSION sql_mode='{$mode}'");
				}
				return $this->db_connect_id;
			}
	
			return $this->sql_error('');
		}

		/*To not break everyone using your library, you have to keep backwards compatibility: 
		Add the PHP5-style constructor, but keep the PHP4-style one. */
		function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = false)
		{
			$this->__construct($sqlserver, $sqluser, $sqlpassword, $database, $persistency);
		}
		function sql_build_query($query, $array)
		{
			$sql = '';
			switch ($query)
			{
				case 'SELECT':
				case 'SELECT_DISTINCT';
	
					$sql = str_replace('_', ' ', $query) . ' ' . $array['SELECT'] . ' FROM ';
	
					// Build table array. We also build an alias array for later checks.
					$table_array = $aliases = array();
					$used_multi_alias = false;
	
					foreach ($array['FROM'] as $table_name => $alias)
					{
						if (is_array($alias))
						{
							$used_multi_alias = true;
	
							foreach ($alias as $multi_alias)
							{
								$table_array[] = $table_name . ' ' . $multi_alias;
								$aliases[] = $multi_alias;
							}
						}
						else
						{
							$table_array[] = $table_name . ' ' . $alias;
							$aliases[] = $alias;
						}
					}
	
					// We run the following code to determine if we need to re-order the table array. ;)
					// The reason for this is that for multi-aliased tables (two equal tables) in the FROM statement the last table need to match the first comparison.
					// DBMS who rely on this: Oracle, PostgreSQL and MSSQL. For all other DBMS it makes absolutely no difference in which order the table is.
					if (!empty($array['LEFT_JOIN']) && sizeof($array['FROM']) > 1 && $used_multi_alias !== false)
					{
						// Take first LEFT JOIN
						$join = current($array['LEFT_JOIN']);
	
						// Determine the table used there (even if there are more than one used, we only want to have one
						preg_match('/(' . implode('|', $aliases) . ')\.[^\s]+/U', str_replace(array('(', ')', 'AND', 'OR', ' '), '', $join['ON']), $matches);
	
						// If there is a first join match, we need to make sure the table order is correct
						if (!empty($matches[1]))
						{
							$first_join_match = trim($matches[1]);
							$table_array = $last = array();
	
							foreach ($array['FROM'] as $table_name => $alias)
							{
								if (is_array($alias))
								{
									foreach ($alias as $multi_alias)
									{
										($multi_alias === $first_join_match) ? $last[] = $table_name . ' ' . $multi_alias : $table_array[] = $table_name . ' ' . $multi_alias;
									}
								}
								else
								{
									($alias === $first_join_match) ? $last[] = $table_name . ' ' . $alias : $table_array[] = $table_name . ' ' . $alias;
								}
							}
	
							$table_array = array_merge($table_array, $last);
						}
					}
	
					$sql .= $this->_sql_custom_build('FROM', implode(', ', $table_array));
	
					if (!empty($array['LEFT_JOIN']))
					{
						foreach ($array['LEFT_JOIN'] as $join)
						{
							$sql .= ' LEFT JOIN ' . key($join['FROM']) . ' ' . current($join['FROM']) . ' ON (' . $join['ON'] . ')';
						}
					}
	
					if (!empty($array['WHERE']))
					{
						$sql .= ' WHERE ' . $this->_sql_custom_build('WHERE', $array['WHERE']);
					}
	
					if (!empty($array['GROUP_BY']))
					{
						$sql .= ' GROUP BY ' . $array['GROUP_BY'];
					}
	
					if (!empty($array['ORDER_BY']))
					{
						$sql .= ' ORDER BY ' . $array['ORDER_BY'];
					}
	
				break;
			}
	
			return $sql;
		}
		function sql_build_array($query, $assoc_ary = false)
		{
			if (!is_array($assoc_ary))
			{
				return false;
			}
	
			$fields = $values = array();
	
			if ($query == 'INSERT' || $query == 'INSERT_SELECT')
			{
				foreach ($assoc_ary as $key => $var)
				{
					$fields[] = $key;
	
					if (is_array($var) && is_string($var[0]))
					{
						// This is used for INSERT_SELECT(s)
						$values[] = $var[0];
					}
					else
					{
						$values[] = $this->_sql_validate_value($var);
					}
				}
	
				$query = ($query == 'INSERT') ? ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')' : ' (' . implode(', ', $fields) . ') SELECT ' . implode(', ', $values) . ' ';
			}
			else if ($query == 'MULTI_INSERT')
			{
				trigger_error('The MULTI_INSERT query value is no longer supported. Please use sql_multi_insert() instead.', E_USER_ERROR);
			}
			else if ($query == 'UPDATE' || $query == 'SELECT')
			{
				$values = array();
				foreach ($assoc_ary as $key => $var)
				{
					$values[] = "$key = " . $this->_sql_validate_value($var);
				}
				$query = implode(($query == 'UPDATE') ? ', ' : ' AND ', $values);
			}
	
			return $query;
		}
		function _sql_validate_value($var)
		{
			if (is_null($var))
			{
				return 'NULL';
			}
			else if (is_string($var))
			{
				return "'" . $this->sql_escape($var) . "'";
			}
			else
			{
				return (is_bool($var)) ? intval($var) : $var;
			}
		}
	function sql_multi_insert($table, &$sql_ary)
	{
		if (!sizeof($sql_ary))
		{
			return false;
		}

		if ($this->multi_insert)
		{
			$ary = array();
			foreach ($sql_ary as $id => $_sql_ary)
			{
				// If by accident the sql array is only one-dimensional we build a normal insert statement
				if (!is_array($_sql_ary))
				{
					return $this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('INSERT', $sql_ary));
				}

				$values = array();
				foreach ($_sql_ary as $key => $var)
				{
					$values[] = $this->_sql_validate_value($var);
				}
				$ary[] = '(' . implode(', ', $values) . ')';
			}

			return $this->sql_query('INSERT INTO ' . $table . ' ' . ' (' . implode(', ', array_keys($sql_ary[0])) . ') VALUES ' . implode(', ', $ary));
		}
		else
		{
			foreach ($sql_ary as $ary)
			{
				if (!is_array($ary))
				{
					return false;
				}
				$result = $this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('INSERT', $ary));

				if (!$result)
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	* Version information about used database
	* @param bool $use_cache If true, it is safe to retrieve the value from the cache
	* @return string sql server version
	*/
	function sql_server_info($raw = false, $use_cache = true)
	{
			$result = @mysqli_query($this->db_connect_id, 'SELECT VERSION() AS version');
			$row = @mysqli_fetch_assoc($result);
			@mysqli_free_result($result);

			$this->sql_server_version = $row['version'];

		return ($raw) ? $this->sql_server_version : 'MySQL(i) ' . $this->sql_server_version;
	}

	/**
	* SQL Transaction
	* @access private
	*/
	function _sql_transaction($status = 'begin')
	{
		switch ($status)
		{
			case 'begin':
				return @mysqli_autocommit($this->db_connect_id, false);
			break;

			case 'commit':
				$result = @mysqli_commit($this->db_connect_id);
				@mysqli_autocommit($this->db_connect_id, true);
				return $result;
			break;

			case 'rollback':
				$result = @mysqli_rollback($this->db_connect_id);
				@mysqli_autocommit($this->db_connect_id, true);
				return $result;
			break;
		}

		return true;
	}

	/**
	* Base query method
	*
	* @param	string	$query		Contains the SQL query which shall be executed
	* @param	int		$cache_ttl	Either 0 to avoid caching or the time in seconds which the result shall be kept in cache
	* @return	mixed				When casted to bool the returned value returns true on success and false on failure
	*
	* @access	public
	*/
	function sql_query($query = '', $cache_ttl = 0)
	{
			global $TheQueryCount;
			$TheQueryCount ++;
		if ($query != '')
		{
			global $cache;
			$this->query_result =  false;
			$this->sql_add_num_queries($this->query_result);

			if ($this->query_result === false)
			{
				if (($this->query_result = @mysqli_query($this->db_connect_id, $query)) === false)
				{
					$this->sql_error($query);
				}
			}
		}
		else
		{
			return false;
		}

		return $this->query_result;
	}
	function sql_add_num_queries($cached = false)
	{
		$this->num_queries['cached'] += ($cached !== false) ? 1 : 0;
		$this->num_queries['normal'] += ($cached !== false) ? 0 : 1;
		$this->num_queries['total'] += 1;
	}
        function sql_numrows($query_id = 0)
        {
                if(!$query_id)
                {
                        $query_id = $this->query_result;
                }
                if($query_id)
                {
                        $result_query = @mysqli_num_rows($query_id);
						//echo $result_query;
                        return (int)$result_query;
                }
                else
                {
                        return false;
                }
        }
		function fetch_array($queryresult, $type = MYSQLI_NUM)
		{
			return mysqli_fetch_array($queryresult,$type);
		}
        function sql_fetchrowset($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        //unset($this->rowset[$query_id]);

                       // unset($this->row[$query_id]);

                        while($this->rowset['55'] = @mysqli_fetch_array($query_id))

                        {

                                $result[] = $this->rowset['55'];

                        }

                        return $result;

                }

                else

                {

                        return false;

                }

        }
	function sql_fetchfield($field, $rownum = false, $query_id = false)
	{
		global $cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if ($query_id !== false)
		{
			if ($rownum !== false)
			{
				$this->sql_rowseek($rownum, $query_id);
			}

			if (!is_object($query_id))
			{
				return;
			}

			$row = $this->sql_fetchrow($query_id);
			return (isset($row[$field])) ? $row[$field] : false;
		}

		return false;
	}
	/**
	* Build LIMIT query
	*/
	function _sql_query_limit($query, $total, $offset = 0, $cache_ttl = 0)
	{
		$this->query_result = false;

		// if $total is set to 0 we do not want to limit the number of rows
		if ($total == 0)
		{
			// MySQL 4.1+ no longer supports -1 in limit queries
			$total = '18446744073709551615';
		}

		$query .= "\n LIMIT " . ((!empty($offset)) ? $offset . ', ' . $total : $total);

		return $this->sql_query($query, $cache_ttl);
	}

	/**
	* Return number of affected rows
	*/
	function sql_affectedrows()
	{
		return ($this->db_connect_id) ? @mysqli_affected_rows($this->db_connect_id) : false;
	}

	/**
	* Fetch current row
	*/
	function sql_fetchrow($query_id = false)
	{
		global $cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if ($query_id !== false)
		{
			$result = @mysqli_fetch_assoc($query_id);
			return $result !== null ? $result : false;
		}

		return false;
	}

	/**
	* Seek to given row number
	* rownum is zero-based
	*/
	function sql_rowseek($rownum, &$query_id)
	{

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}


		return ($query_id !== false) ? @mysqli_data_seek($query_id, $rownum) : false;
	}
	function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		if (!sizeof($array))
		{
			if (!$allow_empty_set)
			{
				// Print the backtrace to help identifying the location of the problematic code
				$this->sql_error('No values specified for SQL IN comparison');
			}
			else
			{
				// NOT IN () actually means everything so use a tautology
				if ($negate)
				{
					return '1=1';
				}
				// IN () actually means nothing so use a contradiction
				else
				{
					return '1=0';
				}
			}
		}

		if (!is_array($array))
		{
			$array = array($array);
		}

		if (sizeof($array) == 1)
		{
			@reset($array);
			$var = current($array);

			return $field . ($negate ? ' <> ' : ' = ') . $this->_sql_validate_value($var);
		}
		else
		{
			return $field . ($negate ? ' NOT IN ' : ' IN ') . '(' . implode(', ', array_map(array($this, '_sql_validate_value'), $array)) . ')';
		}
	}

	/**
	* Get last inserted id after insert statement
	*/
	function sql_nextid()
	{
		return ($this->db_connect_id) ? @mysqli_insert_id($this->db_connect_id) : false;
	}

	/**
	* Free sql result
	*/
	function sql_freeresult($query_id = false)
	{
		global $cache;

		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if (!is_object($query_id))
		{
			return ;
		}

		return @mysqli_free_result($query_id);
	}

	/**
	* Escape string used in sql query
	*/
	function sql_escape($msg)
	{
		return @mysqli_real_escape_string($this->db_connect_id, $msg);
	}

	/**
	* Gets the estimated number of rows in a specified table.
	*
	* @param string $table_name		Table name
	*
	* @return string				Number of rows in $table_name.
	*								Prefixed with ~ if estimated (otherwise exact).
	*
	* @access public
	*/
	function get_estimated_row_count($table_name)
	{
		$table_status = $this->get_table_status($table_name);

		if (isset($table_status['Engine']))
		{
			if ($table_status['Engine'] === 'MyISAM')
			{
				return $table_status['Rows'];
			}
			else if ($table_status['Engine'] === 'InnoDB' && $table_status['Rows'] > 100000)
			{
				return '~' . $table_status['Rows'];
			}
		}

		return parent::get_row_count($table_name);
	}

	/**
	* Gets the exact number of rows in a specified table.
	*
	* @param string $table_name		Table name
	*
	* @return string				Exact number of rows in $table_name.
	*
	* @access public
	*/
	function get_row_count($table_name)
	{
		$table_status = $this->get_table_status($table_name);

		if (isset($table_status['Engine']) && $table_status['Engine'] === 'MyISAM')
		{
			return $table_status['Rows'];
		}

		return parent::get_row_count($table_name);
	}

	/**
	* Gets some information about the specified table.
	*
	* @param string $table_name		Table name
	*
	* @return array
	*
	* @access protected
	*/
	function get_table_status($table_name)
	{
		$sql = "SHOW TABLE STATUS
			LIKE '" . $this->sql_escape($table_name) . "'";
		$result = $this->sql_query($sql);
		$table_status = $this->sql_fetchrow($result);
		$this->sql_freeresult($result);

		return $table_status;
	}

	/**
	* Build LIKE expression
	* @access private
	*/
	function _sql_like_expression($expression)
	{
		return $expression;
	}
 	function sql_like_expression($expression)
	{
		$expression = str_replace(array('_', '%'), array("\_", "\%"), $expression);
		$expression = str_replace(array(chr(0) . "\_", chr(0) . "\%"), array('_', '%'), $expression);

		return $this->_sql_like_expression('LIKE \'' . $this->sql_escape($expression) . '\'');
	}

	/**
	* Build db-specific query data
	* @access private
	*/
	function _sql_custom_build($stage, $data)
	{
		switch ($stage)
		{
			case 'FROM':
				$data = '(' . $data . ')';
			break;
		}

		return $data;
	}

	/**
	* return sql error array
	* @access private
	*/
	function sql_error()
	{
		if ($this->db_connect_id)
		{
			$error = array(
				'message'	=> @mysqli_error($this->db_connect_id),
				'code'		=> @mysqli_errno($this->db_connect_id)
			);
		}
		else if (function_exists('mysqli_connect_error'))
		{
			$error = array(
				'message'	=> @mysqli_connect_error(),
				'code'		=> @mysqli_connect_errno(),
			);
		}
		else
		{
			$error = array(
				'message'	=> $this->connect_error,
				'code'		=> '',
			);
		}

		return $error;
	}

	/**
	* Close sql connection
	* @access private
	*/
	function sql_close()
	{
		if (!$this->db_connect_id)
		{
			return false;
		}

		if ($this->transaction)
		{
			do
			{
				$this->sql_transaction('commit');
			}
			while ($this->transaction);
		}

		foreach ($this->open_queries as $query_id)
		{
			$this->sql_freeresult($query_id);
		}

		// Connection closed correctly. Set db_connect_id to false to prevent errors
		if ($result = $this->_sql_close())
		{
			$this->db_connect_id = false;
		}

		return $result;
	}
	function _sql_close()
	{
		return @mysqli_close($this->db_connect_id);
	}

	/**
	* Build db-specific report
	* @access private
	*/
	function _sql_report($mode, $query = '')
	{
		static $test_prof;

		// current detection method, might just switch to see the existance of INFORMATION_SCHEMA.PROFILING
		if ($test_prof === null)
		{
			$test_prof = false;
			if (strpos(mysqli_get_server_info($this->db_connect_id), 'community') !== false)
			{
				$ver = mysqli_get_server_version($this->db_connect_id);
				if ($ver >= 50037 && $ver < 50100)
				{
					$test_prof = true;
				}
			}
		}

		switch ($mode)
		{
			case 'start':

				$explain_query = $query;
				if (preg_match('/UPDATE ([a-z0-9_]+).*?WHERE(.*)/s', $query, $m))
				{
					$explain_query = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
				}
				else if (preg_match('/DELETE FROM ([a-z0-9_]+).*?WHERE(.*)/s', $query, $m))
				{
					$explain_query = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
				}

				if (preg_match('/^SELECT/', $explain_query))
				{
					$html_table = false;

					// begin profiling
					if ($test_prof)
					{
						@mysqli_query($this->db_connect_id, 'SET profiling = 1;');
					}

					if ($result = @mysqli_query($this->db_connect_id, "EXPLAIN $explain_query"))
					{
						while ($row = @mysqli_fetch_assoc($result))
						{
							$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
						}
					}
					@mysqli_free_result($result);

					if ($html_table)
					{
						$this->html_hold .= '</table>';
					}

					if ($test_prof)
					{
						$html_table = false;

						// get the last profile
						if ($result = @mysqli_query($this->db_connect_id, 'SHOW PROFILE ALL;'))
						{
							$this->html_hold .= '<br />';
							while ($row = @mysqli_fetch_assoc($result))
							{
								// make <unknown> HTML safe
								if (!empty($row['Source_function']))
								{
									$row['Source_function'] = str_replace(array('<', '>'), array('&lt;', '&gt;'), $row['Source_function']);
								}

								// remove unsupported features
								foreach ($row as $key => $val)
								{
									if ($val === null)
									{
										unset($row[$key]);
									}
								}
								$html_table = $this->sql_report('add_select_row', $query, $html_table, $row);
							}
						}
						@mysqli_free_result($result);

						if ($html_table)
						{
							$this->html_hold .= '</table>';
						}

						@mysqli_query($this->db_connect_id, 'SET profiling = 0;');
					}
				}

			break;

			case 'fromcache':
				$endtime = explode(' ', microtime());
				$endtime = $endtime[0] + $endtime[1];

				$result = @mysqli_query($this->db_connect_id, $query);
				while ($void = @mysqli_fetch_assoc($result))
				{
					// Take the time spent on parsing rows into account
				}
				@mysqli_free_result($result);

				$splittime = explode(' ', microtime());
				$splittime = $splittime[0] + $splittime[1];

				$this->sql_report('record_fromcache', $query, $endtime, $splittime);

			break;
		}
	}
	}
}

?>