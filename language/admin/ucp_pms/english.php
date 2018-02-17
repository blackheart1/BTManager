<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2010 phpMyBitTorrent Group
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
	'READ_USER_PMS'					=>	'Read PMs - Read A User\'s PMs',
	'HEADER_READ_USER'				=>	'Read User PMs',
	'USER_ID_SEARCH'				=>	'User ID or Username',
	'USER_ID_SEARCH_EXP'			=>	'Search a Users ID Or Name Only the sign up name well be searched',
	'LIST_OF_PMS'					=>	'List Users with PMs',
	'LIST_OF_PMS_EXP'				=>	'Show a list of users with PM\'s and how many they have',
	'HEADER_SEARCH'					=>	'Search for PMs',
	'SEARCH_PMS'					=>	'Search for',
	'SEARCH_PMS_EXP'				=>	'Separate each search term with a space.<br />Each search should be no less than 4 characters long.',
	'SEARCH_MATCH'					=>	'Match',
	'EXACT_TEXT'					=>	'The exact text',
	'ALL_WORDS'						=>	'all of the words',
	'ATLEAST_ONE_WORD'				=>	'at least one of the words',
	'LATEST_PMS'					=>	'Latest PMs',
	'NUM_TO_SHOW'					=>	'Number of PMs to show',
	'RAED_USER_EXP'					=>	'',
	'PM_MANAGER'					=>	'PM Management',
	'PM_MANAGER_EXP'				=>	'PM Management is Used to keep a eye on users PM\'s to look for spammers or trouble makers on your site<br />Use this tool to search all users PM\'s',
	'LATEST_HEADER'					=>	'Show Last "%1$s" PMs',
	'LIST_HEADER'					=>	'',
	'HAVE_PMS_HEADER'				=>	'Read PMs - List Users with PMs',
	'HEADER_SENT_PMS'				=>	'%1$s PMs sent by %2$s',
	'HEADER_RESEAVED_PMS'			=>	'%1$s PMs recieved for %2$s',
	'VIEW_PMS'						=>	'View Private Message',
	'FROM'							=>	'From',
	'TO'							=>	'To',
	'SENT'							=>	'Sent',
	'LINK_TO_USER'					=>	'Link goes to users Details.',
	'GO_BACK'						=>	'Go Back',
	'LIST_USERS'					=>	'List All Users',
	'LIST_ROW_COUNT'				=>	'There is %1$s user with %2$s PMs',
	'ERROR_MUST_ONE_WORD'			=>	'You must type in at least one word to search for.',
	'ERROR_MUST_FOUR_LETTERS'		=>	'You must type in at least one word to search for.',
	'ERROR_LATEST_NUM'				=>	'Enter a positive number greater than 0.',
	'ERROR_NO_PMS'					=>	'There are no PMs to view.',
	'ERROR_EMPTY_FEALD'				=>	'You need to enter a User ID or Username.',
	'ERROR_NO_SUCH_USER_NAME'		=>	'User <b>%1$s</b> does not exist.',
	'ERROR_NO_SUCH_USER_ID'			=>	'User ID: <b>%1$s</b> does not exist.',
));

?>