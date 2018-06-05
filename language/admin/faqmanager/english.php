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
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File faq_manager/english.php 2018-06-04 09:19:00 Thor
**
** CHANGES
**
** 2018-02-24 - Added New Masthead
** 2018-02-24 - Added New !defined('IN_PMBT')
** 2018-02-24 - Fixed Spelling
** 2018-03-29 - Amended the Wording of some Sentences
** 2018-03-29 - Amended !defined('IN_PMBT') Corrected Path
** 2018-05-06 - Added Missing Languages
** 2018-06-04 - Added Missing Languages
**/

if (!defined('IN_PMBT'))
{
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'F_TITLE_D'            => 'FAQ Management',

    'F_TITLE_D_EXP'        => '<strong>Frequently Asked Questions</strong> are Listed Questions and Answers, ALL Supposedly to be Commonly Asked in some context, and pertaining to a particular Topic.',

    'F_TITLE_ED_CAT_EXP'   => 'Here you can Edit or Change the Category Name or the Status of the Category.',
    'F_TITLE_ED_IT_EXP'    => 'Here you can Edit or Change the Question, Answer, Category or Status .',
    'F_TITLE_AD_CAT_EXP'   => 'Here you can a Add a Category to your <strong>Frequently Asked Questions</strong>.',

    'F_TITLE_AD_IT_EXP'    => 'Here you can Add a New Question and Answer by Setting the Category and Status to your <strong>Frequently Asked Questions</strong>.',

    'F_TITLE_TAKE_CAT_EXP' => 'New Category Added to your <strong>Frequently Asked Questions</strong>.',
    'F_TITLE_TAKE_IT_EXP'  => 'New Question and Answer Added to your <strong>Frequently Asked Questions</strong>.',

    'F_ADDITM'   => 'Add Item',
    'F_REMOVED'  => 'Frequently Asked Question Removed',
    'F_UPDATED'  => 'Updated',
    'F_NORMAL'   => 'Normal',
    'F_HIDDEN'   => 'Hidden',
    'F_QUEST'    => 'Question',
    'F_ANSWER'   => 'Answer',
    'F_STATUS'   => 'Status',
    'F_CATIGORY' => 'Category',
    'F_NEW'      => 'New',
    'F_ID'       => 'ID',
    'F_FA_TITLE' => 'Title',
    'F_COBF_REQ' => 'Confirmation Required',
    'F_CON_DEL'  => 'Please Click <a href="faqactions.php?action=delete&amp;id=**id**&amp;confirm=yes">HERE</a> to Confirm.',
    'STYLES_TIP' => 'Tip: Styles can be Applied Quickly to Selected Text.',

    'F_ADD_SEC'                => 'Add Section',
    'EDIT_ITEM_SAVED'          => 'Frequently Asked Questions Item has been Updated in the Database.',
    'EDIT_SECTION_SAVED'       => 'Frequently Asked Questions Topic has been Updated in the Database.',
    'ADD_SECTION_SAVED'        => 'Frequently Asked Questions Category has been Added to the Database.',
    'ADD_ITEM_SAVED'           => 'Frequently Asked Questions has been Added to the Database.',
    'EDIT_REORDER_SAVED'       => 'Frequently Asked Questions have been Reordered and Updated in the Database.',
    'CONFIRM_OPERATION_DEL_FA' => 'Are you sure you wish to Remove this Frequently Asked Question?',

    #Added in v3.0.1
    'POSITION'      => 'Position',
    'SECTION_TITLE' => 'Section/Item Title',
    'STATUS'        => 'Status',
    'ACTIONS'       => 'Actions',
    'EDIT'          => 'Edit',
    'DELETE'        => 'Delete',
    'ADD_ITEM'      => 'Add New Item',
    'ADD_SECTION'   => 'Add New Section',
));

?>