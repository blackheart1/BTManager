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
	'SC_CONFIG'			=> 'Search Cloud Controle',
	'USER_ONLY_RC'		=>	'Record only user',
	'USER_ONLY_RC_EXP'	=>	'Record only <stong>Users</strong> Search terms to data base',
	'HOW_MANY'			=>	'How Many',
	'HOW_MANY_EXP'		=>	'How many search terms Would you Like to Display in the search Cloud',
	'CONFIG_NOT_SET'	=>	'There seems to be a Problem with your intreys Configs not set',
	'ERR_HOWMANY'		=>	'The enterd Value for "<stong>How Many</strong>" was not Numeric',
	'ERR_ACTIVE'		=>	'The enterd Value for "<stong>Display Search Cloud</strong>" was not Properly SET',
	'ERR_USERONLY'		=>	'The enterd Value for "<stong>Record only user</strong>" was not Properly SET',
	'SCBLOCKDSP'		=> 'Display Search Cloud',
	'SCBLOCK_EXP'		=> 'Display a Block with a Search Cloud. All terms your users search for are recorded and displayed in a cloud. The more often a term is searched, the larger the font size/weight.',
	'SCTERM'			=> 'Search Term',
	'SCTERMS'			=> 'Search Terms',
	'SCTITLEEXP'		=> 'This tool allows you to list and remove search terms saved in the database and displayed in the Search Cloud. Terms are ordered by search frequency, and can be searched.',
	'SCTIMES'			=> 'Times Searched',
	'SCTERM_ID'			=> 'Term ID',
	'SCTERM_REMOVED'	=> 'Term Removed',
	'SCTERMREMOVE'		=> 'Remove Term from Database',
	'SCLOUD'			=> 'Search Cloud',
	'SC_SET_UPDATED'	=> 'Settings Updated Successfully',
	'PRUNE_SUCCESS'		=>	'All search terms Have been removed',
	'CONFIRM_OPERATION'	=>	'Are You sure you wish to remove all Search terms?<br />This Action can not be Un done.',
	'DELETE_ALL'		=>	'Delete all Terms',
	
));
?>