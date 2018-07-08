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
** File mysql.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}
if(!defined("SQL_LAYER"))
{
	define("SQL_LAYER","mysql");
	class sql_db
	{
	   /**
	   * Current sql layer
	   */
		var $any_char;
		var $one_char;
	   var $sql_layer = '';
        var $db_connect_id;
	   var $mysql_version;
        var $query_result;
        var $row = array();
        var $rowset = array();

        var $num_queries = 0;
	var $fetchtypes = array(
		'DBARRAY_NUM'   => MYSQL_NUM,
		'DBARRAY_ASSOC' => MYSQL_ASSOC,
		'DBARRAY_BOTH'  => MYSQL_BOTH
	);
	var $functions = array(
		'connect'            => 'mysql_connect',
		'pconnect'           => 'mysql_pconnect',
		'select_db'          => 'mysql_select_db',
		'query'              => 'mysql_query',
		'query_unbuffered'   => 'mysql_unbuffered_query',
		'fetch_row'          => 'mysql_fetch_row',
		'fetch_array'        => 'mysql_fetch_array',
		'fetch_field'        => 'mysql_fetch_field',
		'free_result'        => 'mysql_free_result',
		'data_seek'          => 'mysql_data_seek',
		'error'              => 'mysql_error',
		'errno'              => 'mysql_errno',
		'affected_rows'      => 'mysql_affected_rows',
		'num_rows'           => 'mysql_num_rows',
		'num_fields'         => 'mysql_num_fields',
		'field_name'         => 'mysql_field_name',
		'insert_id'          => 'mysql_insert_id',
		'escape_string'      => 'mysql_escape_string',
		'real_escape_string' => 'mysql_real_escape_string',
		'close'              => 'mysql_close',
		'client_encoding'    => 'mysql_client_encoding',
	);



        //

        // Constructor

        //

        function __construct($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)

        {
                $this->persistency = $persistency;
                $this->user = $sqluser;
                $this->password = $sqlpassword;
                $this->server = $sqlserver;
                $this->dbname = $database;
				$this->sql_layer = 'mysql';
				// Do not change this please! This variable is used to easy the use of it - and is hardcoded.
				$this->any_char = chr(0) . '%';
				$this->one_char = chr(0) . '_';
                if($this->persistency)
                {
                        $this->db_connect_id = @mysql_pconnect($this->server, $this->user, $this->password);
                }
                else
                {
                        $this->db_connect_id = @mysql_connect($this->server, $this->user, $this->password);
                }
                if($this->db_connect_id)
                {
                        if($database != "")
                        {
						$this->mysql_version = mysql_get_server_info($this->db_connect_id);
                                $this->dbname = $database;
                                $dbselect = @mysql_select_db($this->dbname);
                                if(!$dbselect)
                                {
                                        @mysql_close($this->db_connect_id);
                                        $this->db_connect_id = $dbselect;
                                }
                        }
                        return $this->db_connect_id;
                }
                else
                {
                        return false;
                }
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
	function sql_server_info()
	{
		return 'MySQL ' . $this->mysql_version;
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
	function sql_escape($msg)
	{
		if (!$this->db_connect_id)
		{
			return @mysql_real_escape_string($msg);
		}

		return @mysql_real_escape_string($msg, $this->db_connect_id);
	}


        //

        // Other base methods

        //

        function sql_close()
        {
			if($this->db_connect_id)
			{
				if($this->query_result)
				{
					@mysql_free_result($this->query_result);
				}
				$result = @mysql_close($this->db_connect_id);
				return $result;
			}
			else
			{
				return false;
			}
        }



        //

        // Base query method

        //

        function sql_query($query = "", $transaction = FALSE)

        {
			global $TheQueryCount;
			$TheQueryCount ++;
                // Remove any pre-existing queries
                unset($this->query_result);
                if($query != "")
                {
                        $this->query_result = @mysql_query($query, $this->db_connect_id);
                }
                if($this->query_result)
                {
                        unset($this->row[$this->query_result]);
                        unset($this->rowset[$this->query_result]);
                        return $this->query_result;
                }
                else
                {
                        return ( $transaction == END_TRANSACTION ) ? true : false;
                }
        }



        //

        // Other query methods

        //

        function sql_numrows($query_id = 0)
        {
                if(!$query_id)
                {
                        $query_id = $this->query_result;
                }
                if($query_id)
                {
                        $result = @mysql_num_rows($query_id);
                        return $result;
                }
                else
                {
                        return false;
                }
        }

 	function num_rows($queryresult)
	{
		return @$this->functions['num_rows']($queryresult);
	}
       function sql_affectedrows()

        {

                if($this->db_connect_id)

                {

                        $result = @mysql_affected_rows($this->db_connect_id);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_numfields($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_num_fields($query_id);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_fieldname($offset, $query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_field_name($query_id, $offset);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_fieldtype($offset, $query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_field_type($query_id, $offset);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_fetchrow($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $this->row[(int)$query_id] = @mysql_fetch_array($query_id);

                        return $this->row[(int)$query_id];

                }

                else

                {

                        return false;

                }

        }

        function sql_fetchrowset($query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        unset($this->rowset[$query_id]);

                        unset($this->row[$query_id]);

                        while($this->rowset['55'] = @mysql_fetch_array($query_id))

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

		function fetch_array($queryresult, $type = 'DBARRAY_ASSOC')
		{
			return $this->functions['fetch_array']($queryresult, $this->fetchtypes["$type"]);
		}
        function sql_fetchfield($field, $rownum = -1, $query_id = 0)

        {

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        if($rownum > -1)

                        {

                                $result = @mysql_result($query_id, $rownum, $field);

                        }

                        else

                        {

                                if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))

                                {

                                        if($this->sql_fetchrow())

                                        {

                                                $result = $this->row[(int)$query_id][$field];

                                        }

                                }

                                else

                                {

                                        if($this->rowset[$query_id])

                                        {

                                                $result = $this->rowset[$query_id][$field];

                                        }

                                        else if($this->row[(int)$query_id])

                                        {

                                                $result = $this->row[(int)$query_id][$field];

                                        }

                                }

                        }

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_rowseek($rownum, $query_id = 0){

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }

                if($query_id)

                {

                        $result = @mysql_data_seek($query_id, $rownum);

                        return $result;

                }

                else

                {

                        return false;

                }

        }

        function sql_nextid(){

                if($this->db_connect_id)

                {

                        $result = @mysql_insert_id($this->db_connect_id);

                        return $result;

                }

                else

                {

                        return false;

                }

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
        function sql_freeresult($query_id = 0){

                if(!$query_id)

                {

                        $query_id = $this->query_result;

                }



                if ( $query_id )

                {

                        unset($this->row[$query_id]);

                        unset($this->rowset[$query_id]);



                        @mysql_free_result($query_id);



                        return true;

                }

                else

                {

                        return false;

                }

        }

        function sql_error($query_id = 0)

        {

                $result["message"] = @mysql_error($this->db_connect_id);

                $result["code"] = @mysql_errno($this->db_connect_id);



                return $result;

        }



} // class sql_db



} // if ... define



?>