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
** File forum_search/english.php 2018-04-22 05:43:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-22 - Amended the Wording of some Sentences
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'ALL_AVAILABLE'                  => 'ALL Available',
    'ALL_RESULTS'                    => 'ALL Results',

    'DISPLAY_RESULTS'                => 'Display Results as',

    'FOUND_SEARCH_MATCH'             => 'Search Found %d Match',
    'FOUND_SEARCH_MATCHES'           => 'Search Found %d Matches',
    'FOUND_MORE_SEARCH_MATCHES'      => 'Search Found more than %d Matches',

    'SGLOBAL'                        => 'Global Announcement',

    'IGNORED_TERMS'                  => 'Ignored',

    'IGNORED_TERMS_EXPLAIN'          => 'The following Words in your Search Query were Ignored because the Words are Too Common: <strong>%s</strong>.',

    'JUMP_TO_POST'                   => 'Jump to Post',

    'LOGIN_EXPLAIN_EGOSEARCH'        => 'The Board Requires you to be Registered and Logged in to View your Own Posts.',
    'LOGIN_EXPLAIN_UNREADSEARCH'     => 'The Board Requires you to be Registered and Logged in to View your Unread Posts.',

    'LOGIN_EXPLAIN_NEWPOSTS'         => 'The Board Requires you to be Registered and Logged in to View New Posts since your Last Visit.',

    'MAX_NUM_SEARCH_KEYWORDS_REFINE' => 'You Specified Too Many Words to Search for.  Please DO NOT enter more than %1$d Words.',

    'NO_KEYWORDS'                    => 'You must Specify at least One Word to Search for.  Each Word must consist of at least %d Characters and must NOT contain more than %d Characters, Excluding Wildcards.',

    'NO_RECENT_SEARCHES'             => 'No Searches have been carried out recently.',
    'NO_SEARCH'                      => 'Sorry.  You are NOT Permitted to use the Search System.',
    'NO_SEARCH_RESULTS'              => 'No Suitable Matches were found.',
    'NO_SEARCH_TIME'                 => 'Sorry.  You can NOT use Search at this time.  Please try again later.',
    'NO_SEARCH_UNREADS'              => 'Sorry.  Searching for Unread Posts has been Disabled on this Board.',
    'WORD_IN_NO_POST'                => 'No Posts were found.  The Word <strong>%s</strong> is NOT Contained in any Post.',
    'WORDS_IN_NO_POST'               => 'No Posts were found.  The Words <strong>%s</strong> are NOT Contained in any Post.',

    'POST_CHARACTERS'                => 'Characters of Posts',

    'RECENT_SEARCHES'                => 'Recent Searches',
    'RESULT_DAYS'                    => 'Limit Results to previous',
    'RESULT_SORT'                    => 'Sort Results by',
    'RETURN_FIRST'                   => 'Return First',
    'RETURN_TO_SEARCH_ADV'           => 'Return to Advanced Search',

    'SEARCHED_FOR'                   => 'Search Term Used',
    'SEARCH_KEYWORDS'                => 'Search Keywords',
    'SEARCHED_TOPIC'                 => 'Searched Topic',
    'SEARCH_ALL_TERMS'               => 'Search for ALL Terms or Use Query as Entered',
    'SEARCH_ANY_TERMS'               => 'Search for Any Terms',
    'SEARCH_AUTHOR'                  => 'Search for Author',
    'SEARCH_AUTHOR_EXPLAIN'          => 'Use * as a Wildcard for Partial Matches.',
    'SEARCH_FIRST_POST'              => 'First Post of Topics Only',
    'SEARCH_FORUMS'                  => 'Search in Forums',

    'SEARCH_FORUMS_EXPLAIN'          => 'Select the Forum or Forums you wish to Search in.  Sub-Forums are Searched Automatically if you DO NOT Disable Search Sub-Forums below.',

    'SEARCH_IN_RESULTS'              => 'Search these Results',

    'SEARCH_KEYWORDS_EXPLAIN'        => 'Place an <strong>+</strong> in Front of a Word which must be found and place an <strong>-</strong> in Front of a Word which must NOT be found.  Put a List of Words Separated by an <strong>|</strong> into Brackets if Only One of the Words must be found.  Use * as a Wildcard for Partial Matches.',

    'SEARCH_MSG_ONLY'                => 'Message Text Only',
    'SEARCH_OPTIONS'                 => 'Search Options',
    'SEARCH_QUERY'                   => 'Search Query',
    'SEARCH_SUBFORUMS'               => 'Search Sub-Forums',
    'SEARCH_TITLE_MSG'               => 'Post Subjects and Message Text',
    'SEARCH_TITLE_ONLY'              => 'Topic Titles Only',
    'SEARCH_WITHIN'                  => 'Search within',
    'SORT_ASCENDING'                 => 'Ascending',
    'SORT_AUTHOR'                    => 'Author',
    'SORT_DESCENDING'                => 'Descending',
    'SORT_FORUM'                     => 'Forum',
    'SORT_POST_SUBJECT'              => 'Post Subject',
    'SORT_TIME'                      => 'Post Time',

    'TOO_FEW_AUTHOR_CHARS'           => 'You must Specify at least %d Characters of the Authors Name.',
    'NO_SUCH_SEARCH_MODULE'          => 'No Search Criteria Found',
));

?>