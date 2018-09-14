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
** File acp_search/english.php 2018-09-14 09:06:00 Thor
**
** CHANGES
**
** 2018-05-19 - Added New Masthead
** 2018-05-20 - Fixed Spelling
** 2018-05-20 - Amended the Wording of some Sentences
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
    'ACP_SEARCH'                            => 'Search Configuration',
    'ACP_SEARCH_INDEX'                      => 'Search Index',
    'ACP_SEARCH_SETTINGS'                   => 'Search Settings',

    'ACP_SEARCH_INDEX_EXPLAIN'              => 'Here you can manage the Search Index System.  Since you normally use only one Index System you should Delete ALL Indexes that you Do Not make use of.  After altering some of the Search Settings (e.g. the number of Minimum/Maximum Characters) it might be worth Recreating the Index so it reflects those changes.',

    'ACP_SEARCH_SETTINGS_EXPLAIN'           => 'Here you can Define what Search Criteria will be used for Indexing Posts and Performing Searches.  You can Set Various Options that can Influence how much Processing these Actions Require.  Some of these Settings are the same for all Search Engine Systems.<br /><br />',

    'COMMON_WORD_THRESHOLD'                 => 'Common Word Threshold',

    'COMMON_WORD_THRESHOLD_EXPLAIN'         => 'Words which are contained in a Greater Percentage of ALL Posts will be regarded as Common.  Common Words are Ignored in Search Queries.  Set to Zero to Disable.  This Only takes effect if there are more than 100 Posts.  If you want Words that are Regarded as Common to be Reconsidered then you have to Recreate the Index.',

    'CONFIRM_SEARCH_BACKEND'                => 'Are you Sure you Wish to Switch to a Different Search System?  After changing the Search System you will need to Create a New Index for the New Search System.  If you don\'t plan on Switching Back then you can Delete the Old System\'s Index in Order to Free System Resources.',

    'CONTINUE_DELETING_INDEX'               => 'Continue Previous Index Removal Process',

    'CONTINUE_DELETING_INDEX_EXPLAIN'       => 'An Index Removal Process has been Started.  In Order to Access the Search Index Page you will have to Complete it or Cancel it.
    ',
    'CONTINUE_INDEXING'                     => 'Continue Previous Indexing Process',

    'CONTINUE_INDEXING_EXPLAIN'             => 'An Indexing Process has been Started.  In Order to Access the Search Index Page you will have to Complete it or Cancel it.',

    'CREATE_INDEX'                          => 'Create Index',

    'DELETE_INDEX'                          => 'Delete Index',
    'DELETING_INDEX_IN_PROGRESS'            => 'Deleting the Index.  Please Wait...',
    'DELETING_INDEX_IN_PROGRESS_EXPLAIN'    => 'The Search System is Cleaning it\'s Index.  This can take a few minutes.',

    'FULLTEXT_MYSQL_INCOMPATIBLE_VERSION'   => 'The MySQL fulltext System can Only be used with MySQL4 and above.',

    'FULLTEXT_MYSQL_NOT_SUPPORTED'          => 'MySQL fulltext Indexes can Only be used with MyISAM or InnoDB Tables.  MySQL 5.6.4 or later is Required for fulltext Indexes on InnoDB Tables.',

    'FULLTEXT_MYSQL_TOTAL_POSTS'            => 'Total Number of Indexed Posts',
    'FULLTEXT_MYSQL_MBSTRING'               => 'Support for non-latin UTF-8 Characters using mbstring:',
    'FULLTEXT_MYSQL_PCRE'                   => 'Support for non-latin UTF-8 Characters using PCRE:',
    'FULLTEXT_MYSQL_MBSTRING_EXPLAIN'       => 'If PCRE Does Not have Unicode Character Properties, the Search System will try to use mbstring\'s Regular Expression Engine.',

    'FULLTEXT_MYSQL_PCRE_EXPLAIN'           => 'This Search System Requires PCRE Unicode Character Properties.  If you want to Search for non-latin Characters you\'ll Require PHP 4.4, 5.1 and above.',

    'FULLTEXT_MYSQL_MIN_SEARCH_CHARS_EXPLAIN'   => 'Words with at least this many Characters will be Indexed for Searching.  You or your Host can Change this Setting by Changing the MySQL Configuration.',

    'FULLTEXT_MYSQL_MAX_SEARCH_CHARS_EXPLAIN'   => 'Words with no more than this many Characters will be Indexed for Searching. You or your host can Change this Setting by Changing the MySQL Configuration.',

    'GENERAL_SEARCH_SETTINGS'               => 'General Search Settings',
    'GO_TO_SEARCH_INDEX'                    => 'Go to Search Index Page',

    'INDEX_STATS'                           => 'Index Statistics',
    'INDEXING_IN_PROGRESS'                  => 'Indexing in Progress',

    'INDEXING_IN_PROGRESS_EXPLAIN'          => 'The Search System is Currently Indexing ALL Posts on the Board. This can take from a few minutes to a few hours depending on your Board\'s Size.',

    'LIMIT_SEARCH_LOAD'                     => 'Search Page System Load Limit',

    'LIMIT_SEARCH_LOAD_EXPLAIN'             => 'If the 1 Minute System Load Exceeds this Value, the Search Page will go Offline.  1.0 Equals ~100% Utilisation of One Processor.  This Only Functions on UNIX Based Servers.',

    'MAX_SEARCH_CHARS'                      => 'Maximum Characters Indexed by Search',
    'MAX_SEARCH_CHARS_EXPLAIN'              => 'Words with no more than this many Characters will be Indexed for Searching.',
    'MAX_NUM_SEARCH_KEYWORDS'               => 'Maximum Number of Allowed Keywords',

    'MAX_NUM_SEARCH_KEYWORDS_EXPLAIN'       => 'Maximum Number of Words the User is able to Search for.  A Value of 0 Allows an Unlimited Number of Words.',

    'MIN_SEARCH_CHARS'                      => 'Minimum Characters Indexed by Search',
    'MIN_SEARCH_CHARS_EXPLAIN'              => 'Words with at least this many Characters will be Indexed for Searching.',
    'MIN_SEARCH_AUTHOR_CHARS'               => 'Minimum Author Name Characters',

    'MIN_SEARCH_AUTHOR_CHARS_EXPLAIN'       => 'Users need to enter at least this many Characters of the Name when performing a Wildcard Author Search.  If the Author\'s Username is Shorter than this Number, you can still Search for the Author\'s Posts by entering the Complete Username.',

    'PROGRESS_BAR'                          => 'Progress Bar',

    'SEARCH_GUEST_INTERVAL'                 => 'Guest Search Flood Interval',

    'SEARCH_GUEST_INTERVAL_EXPLAIN'         => 'Number of seconds Guests must wait between Searches.  If one Guest Searches, then ALL others have to Wait until the Time Interval has Passed.',

    'SEARCH_INDEX_CREATE_REDIRECT'          => 'ALL Posts up to Post ID %1$d have now been Indexed, of which %2$d Posts were within this Step.<br />The Current Rate of Indexing is Approximately %3$.1f Posts Per Second.<br />Indexing in Progress...',

    'SEARCH_INDEX_DELETE_REDIRECT'          => 'ALL Posts up to Post id %1$d have been Removed from the Search Index.<br />Deleting in progress...',

    'SEARCH_INDEX_CREATED'                  => 'Successfully Indexed ALL Posts in the Board Database.',
    'SEARCH_INDEX_REMOVED'                  => 'Successfully Deleted the Search Index for this System.',
    'SEARCH_INTERVAL'                       => 'User Search Flood Interval',

    'SEARCH_INTERVAL_EXPLAIN'               => 'Number of seconds Users Must Wait between Searches.  This Interval is Checked Independently for each User.',

    'SEARCH_STORE_RESULTS'                  => 'Search Result Cache Length',

    'SEARCH_STORE_RESULTS_EXPLAIN'          => 'Cached Search Results will Expire after this time (in seconds).  Set to 0 if you want to Disable the Search Cache.',

    'SEARCH_TYPE'                           => 'Search System',

    'SEARCH_TYPE_EXPLAIN'                   => 'BTManager Allows you to choose the System that is Used for Searching Text in Post\'s.  By Default the Search will use BTManager\'s own fulltext Search.',

    'SWITCHED_SEARCH_BACKEND'               => 'You Switched the Search System.  In Order to use the New Search System you should make sure that there is an Index for the System you chose.',

    'TOTAL_WORDS'                           => 'Total Number of Indexed Words',
    'TOTAL_MATCHES'                         => 'Total Number of Word to Post Relations Indexed',

    'YES_SEARCH'                            => 'Enable Search Facilities',
    'YES_SEARCH_EXPLAIN'                    => 'Enables User Facing Search Functionality Including Member Search.',
    'YES_SEARCH_UPDATE'                     => 'Enable fulltext Updating',
    'YES_SEARCH_UPDATE_EXPLAIN'             => 'Updating of fulltext Indexes when Posting, Overridden if Search is Disabled.',
    'VALUE'                                 => 'Value',
    'STATISTIC'                             => 'Statistics',
    'CONTINU'                               => 'Continue',
));

?>