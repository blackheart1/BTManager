<?php
/**
*
* acp_permissions [English]
*
* @package language
* @version $Id: permissions.php,v 1.6 2009/09/17 14:09:33 joerobe Exp $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'CACHE'							=>	'Cache',
	'TITLE'							=>	'Site Cache',
	'TITLE_EXP'						=>	'Here is where you can Set the time`s to Hold cache Files before the get updated.<br>The longer you can keep them the better the site speed well be.',
	'_admpsql_time'					=>	'SQL Cache Time',
	'_admpsql_timeexplain'			=>	'These Files are some of the Base query`s for the site such as the Config Settings, Shout Box configs and more',
	'_admptheme_time'				=>	'Theme Cache Time',
	'_admptheme_timeexplain'		=>	'These Files the Generated Files for your Themes',
	'_admpcache_dir'				=>	'Cache Directory',
	'_admpcache_direxplain'			=>	'This Directory well need to be writable by the system.<br>Do Not add the Trailing slash `/`',
	'ERR_SQL_TIME'					=>	'There seems to be a problem with the time you set for the SQl Cache Please check the Form and try again. (%1$s)',
	'ERR_THEME_TIME'				=>	'There seems to be a problem with the time you set for the Theme Cache Please check the Form and try again. (%1$s)',
	'ERR_CACHE_DIR_NOTSET'			=>	'There seems to be a problem locating the Cache directory you choice (%1$s) Please check the form and try again.',
	'ERR_CACHE_DIR_NOT_WRITEABLE'	=>	'The Directory is not writeable (%1$s)',
	'ERR_ARRAY_MESS'				=>	'<li>%s</li>',
));
?>