<?php
/**
*
* offers [English]
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
	'DONATIONS'					=> 'Donations',
	'DONATE'					=> 'DONATE',
	'GOAL'						=> 'Goal',
	'COLECTED'					=> 'Collected',
	'PROGRESS'					=> 'Donation Progress',
));
?>