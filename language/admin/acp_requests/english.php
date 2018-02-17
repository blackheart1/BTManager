<?php
/**
*
* acp_requests [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
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
	'INTRO'								=>	'Requests Config',
	'INTRO_EXP'							=>	'',
	'YES_NO_OPTION'						=> array('1'=> 'Yes', '0' => 'No'),
	'_admpenable'						=> "Inable Requests",
	'_admpenableexplain'				=> "Inable Requests System",
	'_admpclass_allowed'				=> "Access Level",
	'_admpclass_allowedexplain'			=> "What Group is allow to Use requests system",
	'ERR_BAD_LEVEL'						=> 'One or more of the Groups you intered Is not Valid please go back and try again',
	'CONFIG_NOT_SET'					=> 'A error accurd while Processing the new Settings Please read Bellow!',
 ));

?>