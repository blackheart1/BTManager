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
** File mcp_warn.php 2018-02-18 14:32:00 joeroberts
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
class mcp_warn_info
{
	function module()
	{
		return array(
			'filename'	=> 'mcp_warn',
			'title'		=> 'MCP_WARN',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'front'				=> array('title' => 'MCP_WARN_FRONT', 'auth' => 'aclf_m_warn', 'cat' => array('MCP_WARN')),
				'list'				=> array('title' => 'MCP_WARN_LIST', 'auth' => 'aclf_m_warn', 'cat' => array('MCP_WARN')),
				'warn_user'			=> array('title' => 'MCP_WARN_USER', 'auth' => 'aclf_m_warn', 'cat' => array('MCP_WARN')),
				'warn_post'			=> array('title' => 'MCP_WARN_POST', 'auth' => 'acl_m_warn && acl_f_read,$id', 'cat' => array('MCP_WARN')),
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