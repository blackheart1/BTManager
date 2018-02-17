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
	'F_TITLE_D'			=> 'FAQ\'s Management',
	'F_TITLE_D_EXP'			=> '<b>Frequently asked questions</b> are listed questions and answers, all supposed to be commonly asked in some context, and pertaining to a particular topic.',
	'F_TITLE_ED_CAT_EXP'	=> 'Here you can edit or change the catigory Name or the status of the catigory.',
	'F_TITLE_ED_IT_EXP'	=> 'Here you can edit or change the question, answer, catigory, or status .',
	'F_TITLE_AD_CAT_EXP'	=> 'Here you can a catigory To your <b>Frequently asked questions</b>.',
	'F_TITLE_AD_IT_EXP'	=> 'Here you can add a new question and answer allong with setting the catigory and status To your <b>Frequently asked questions</b>.',
	'F_TITLE_TAKE_CAT_EXP'	=> 'New catigory added to your <b>Frequently asked questions</b>.',
	'F_TITLE_TAKE_IT_EXP'	=> 'New question and answer added to your <b>Frequently asked questions</b>.',
	'F_ADDITM'			=> 'Add Item',
	'F_REMOVED'			=> 'Frequently asked question removed',
	'F_UPDATED'			=> 'Updated',
	'F_NORMAL'			=> 'Normal',
	'F_HIDDEN'			=> 'Hidden',
	'F_QUEST'			=> 'Question',
	'F_ANSWER'			=> 'Answer',
	'F_STATUS'			=> 'Status',
	'F_CATIGORY'		=> 'Category',
	'F_NEW'				=> 'New',
	'F_ID'				=> 'ID',
	'F_FA_TITLE'		=> 'Title',
	'F_COBF_REQ'		=> 'Confirmation Required',
	'F_CON_DEL'			=> 'Please click <a href="faqactions.php?action=delete&amp;id=**id**&amp;confirm=yes">here</a> to confirm.',
	'F_ADD_SEC'			=> 'Add Section',
	'EDIT_ITEM_SAVED'	=> 'Frequently asked questions Item has been updated to the data base.',
	'EDIT_SECTION_SAVED'=> 'Frequently asked questions Topic has been updated to the data base.',
	'ADD_SECTION_SAVED'	=> 'Frequently asked questions catigory has been added to the data base.',
	'ADD_ITEM_SAVED'=> 'Frequently asked questions has been added to the data base.',
	'EDIT_REORDER_SAVED'=> 'Frequently asked questions have been Reorder and updated to the data base.',
	'CONFIRM_OPERATION_DEL_FA'	=> 'Are you surten you wish to remove this Frequently asked question.',
));
?>