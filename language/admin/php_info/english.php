<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
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
	'ACP_PHP_INFO_EXPLAIN'	=> 'This page lists information on the version of PHP installed on this server. It includes details of loaded modules, available variables and default settings. This information may be useful when diagnosing problems. Please be aware that some hosting companies will limit what information is displayed here for security reasons. You are advised to not give out any details on this page except when asked by <a href="http://www.phpbb.com/about/team/">official team members</a> on the support forums.',
	'NO_PHPINFO_AVAILABLE'	=> 'Information about your PHP configuration is unable to be determined. Phpinfo() has been disabled for security reasons.',
	'ACP_PHP_INFO'				=> 'PHP information',
));
?>