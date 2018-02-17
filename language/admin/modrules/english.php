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
			'TITLE'														=>	'Site Rules',
			'EXPLAIN'													=>	'In This Section You can Create Edit and Delete Site Rules',
			'MESSAGE_BODY_EXP'											=>	'',
			'SELECT_GROUP'												=>	'Select Group',
			'SELECT_GROUP_EXP'											=>	'Select A Group For this Rule',
			'SECTION_TITTLE'											=>	'Rule Section Title',
			'SECTION_TITTLE_EXP'										=>	'Give a Title For the Group of Rules',
			'PUBLIC_VIEW'												=>	'Puplic View',
			'PUBLIC_VIEW_EXP'											=>	'Are these Rules Viewable By the Puplic?',
			'RULES_FEALD_BLANK'											=>	'Rules Feald was left Blank Please Go back and fill in missing fealds',
			'TITLE_BLANK'												=>	'Rules Title feald was left blank Please go back and fill in missing fealds',
			'PUPLIC_FEALD_BLANK'										=>	'You did not Set these rules as Public or private',
			'GROUP_NOT_SET'												=>	'You did not indecate what group these Rules are for.',
			'GO_BACK'													=>	'Go Back!',
			'RULE_ADDED'												=>	'Your New Rules have been added.',
			'ADD_NEW_RULE_SECTION'										=>	'Add A New Rules Section.',
			'ADVANCED_RULE_INFO'										=>	'Advanced Rule Information',
			'IS_PUBLIC'													=>	'IS this a Public Rule?',
			'IS_PUBLIC_EXP'												=>	'Public Rules can be seen By Unregisterd Users and all Groups',
			'VIEWABL_BY'												=>	'What Groups is this for?',
			'VIEWABL_BY_EXP'											=>	'These Rules apply to These groups and well only be seen by them.',
));
?>