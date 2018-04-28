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
** File request/english.php 2018-04-28 07:33:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-28 - Amended the Wording of some Sentences
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
    'REQUESTS'            => 'Requests',
    'ADD_REQUESTS'        => 'Add a Request',
    'PERMISSION_DENIED'   => 'You DO NOT have Permissions to Access Requests at this time.',

    'VOTED_ALREADY'       => 'You\'ve already Voted on this Request.  ONLY <strong>One</strong> Vote Per Member is Allowed<br />Return to the <a href=\'viewrequests.php\'><strong>Request List</strong></a>',

    'THANKS_FOR_VOTE'     => 'Thank You for your Vote.',
    'VOTE_TAKEN'          => 'Your Vote has been Counted<br />Return to the <a href=\'viewrequests.php\'><strong>Request List</strong></a>',

    'DESCRIPTION_EXPLAIN'  => 'Add as much Information as Possible.  This will make it easier for the Uploader to find what your looking for.',


    'REQUIST_CLOSED'          => 'Request System is Currently Closed.  Please come back later.',
    'COMMENT_ADDED'           => 'Comment Successfully Added',
    'MAKE_REQUEST'            => 'Add a New Request',
    'REQUEST_UPDATED'         => 'The Request Information has been Updated!',
    'VIEW_OWN_REQ'            => 'View My Requests',
    'NO_REQUEST_NOW'          => 'There are NO Requests at this time.',
    'REQUESTED_BY'            => 'Requested by',
    'REQUEST_REMOVED'         => 'The Request was Successfully Removed',
    '_DELETE_REQUEST'         => 'Delete Request',
    '_DELETE_REQUEST_CONFIRM' => 'Are you sure you would like to <strong>Delete</strong> this Request?',

    'ONLINE'          => 'User Online',
    'VOTES'           => 'Votes',
    'VOTE'            => 'Vote',
    'VOTED'           => 'Voted',
    'FILLED'          => 'Filled',
    'COMMENT_EXPLAIN' => '',

    'ERROR_INVALID_COM_ID'     => '%1$d is an Invalid Comment ID',
    'ERROR_INVALID_FORUM_ID'   => '%1$d is an Invalid Request ID',
    'ERROR_NOT_REQUEST_OWNER'  => 'You are NOT the Owner of this Request and DO NOT have Permission to Edit it.',
    'ERROR_REQUEST'            => 'There is a Error on the Page you Requested.',
    'ERROR_REQ_DEL_EDIT_OWNER' => 'You are NOT the Owner of this Request and DO NOT have Permission to Edit/Delete it.',
    'ERROR_NOT_OWNER'          => 'You\'re NOT the Owner!  How did that happen?',
    'ERROR_NO_COMMENT'         => 'An Error Occurred.',

    'ERROR_COMMENT_BLANK'      => 'You can NOT Leave the Comment Field Blank.  If you wish to Delete the Comment please use the Delete Tab if provided',

    'COMMENT_UPDATED'   => 'Comment was Successfully Updated.',
    'COMMENT_REMOVED'   => 'Comment was Successfully Removed.',
    'LAST_EDIT_BY'      => '<br /><br /><a rel=\'nofollow\' href=\'user.php?op=profile&id=%1$d\'>Last edited by %2$s</a>; %3$s.',
    'UPLOADED_URL'      => 'Uploaded Details Link or #ID',
    'FILL_REUEST'       => 'Fill Request %1$s',
    'FILL_REUEST_RESET' => 'The Request %1$s was Reset.',
    'FILL_REUEST_INT'   => 'To Fill this Request',

    'FILL_REUEST_EXP'   => 'Enter the <strong>FULL</strong> Direct URL of the torrent i.e. <br />%1$s/details.php?id=134<br />(just Copy/Paste from another Window/Tab) or Modify the Existing URL to have the Correct ID Number.',

    'NEW_SHOUT'         => '/notice %1$s has made a Request for %2$s',
    'NEW_REQ_ADDED'     => 'Your Request for %1$s has been Added.  You will be Notified by PM once it has been Filled',
    'NOTHING_FOUND'     => 'Nothing Found!!',
    'UNKNOWN_ADD_ERROR' => 'An Unknown Error has Occurred.  Please Contact an Administrator or Moderator',

    'REQ_FILLED_PM'         => 'Your Request for, [url=%1$s/viewrequests.php?action=details&id=%2$s][b]%3$s[/b][/url], has been Filled by [url=%1$s/user.php?op=profile&id=%4$s>[b]%5$s[/b][/url].  You can Download your Request from [url][b]%6$s[/b][/url].  Please DO NOT forget to Leave a Thank You where due.  If for some reason this is NOT what you Requested, please Reset your Request so that someone else can Fill it by [url=%1$s/viewrequests.php?id=%2$s&action=reqfil&mode=reset]Clicking Here[/url].  [b]DO NOT[/b] Click this Link, unless you are sure that this DOES NOT Match your Request.',

    'REQ_FILLED_PM_SUB'     => 'Request Filled',
    'SUCCESS_REQ_FILLED_HD' => 'Request was %1$s Successfully Filled with <a href=\'%2$s\'>%2$s</a>',

    'SUCCESS_REQ_FILLED'    => 'User <a href=\'user.php?op=profile&id=%1$s\'><strong>%2$s</strong></a> was Automatically PM\'d.<br />If it was Accidentally Filled then no worries, <a href=\'reqreset.php?requestid=%3$s\'>CLICK HERE</a> to Mark the Request as Unfilled.  <strong>DO NOT</strong> Click this Link unless you are sure there is a problem.<br /><br />Thank You for Filling a Request :)<br /><br /><a href=\'viewrequests.php\'>View More Requests</a>',

    'ERROR_NOT_LOCAL'          => 'The Link you are providing <strong>%1$s</strong> is NOT for a Local Upload',
));

?>