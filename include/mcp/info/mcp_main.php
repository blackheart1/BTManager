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
** File mcp_main.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../../security.php';
	die ();
}
class mcp_main_info
{
	function module()
	{
		return array(
			'filename'	=> 'mcp_main',
			'title'		=> 'MCP_MAIN',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'front'			=> array('title' => 'MCP_MAIN_FRONT', 'auth' => '', 'cat' => array('MCP_MAIN')),
				'forum_view'	=> array('title' => 'MCP_MAIN_FORUM_VIEW', 'auth' => 'acl_m_,$id', 'cat' => array('MCP_MAIN')),
				'topic_view'	=> array('title' => 'MCP_MAIN_TOPIC_VIEW', 'auth' => 'acl_m_,$id', 'cat' => array('MCP_MAIN')),
				'post_details'	=> array('title' => 'MCP_MAIN_POST_DETAILS', 'auth' => 'acl_m_,$id || (!$id && aclf_m_)', 'cat' => array('MCP_MAIN')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>