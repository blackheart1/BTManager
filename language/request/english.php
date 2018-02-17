<?php
/*
*----------------------------phpMyBitTorrent V 3.0.0---------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------------   And Joe Robertson (aka joeroberts)   -------------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2010 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 17, 2009 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 english.php  2010-11-04 00:22:48 joeroberts $
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
	'REQUESTS'								=>	'Requests',
	'ADD_REQUESTS'							=>	'Add A Requests',
	'PERMISSION_DENIED'						=>	'You DO NOT have Permissions to Access Requests at this time',
	'VOTED_ALREADY'							=>	'You\'ve already Voted to this Request, ONLY <strong>1</strong> Vote per Member is Allowed<br />Return to <a href=./viewrequests.php><b>Request List</b></a>',
	'THANKS_FOR_VOTE'						=>	'Thank you for your Vote',
	'DESCRIPTION_EXPLAIN'					=>	'Please Give as Much imformation as You can so The Uploader can Get what you are looking for.',
	'VOTE_TAKEN'							=>	'Your Vote has been counted<br />Back to <a href=viewrequests.php><b>Request List</b></a>',
	'REQUIST_CLOSED'						=>	'Request System is Closed, come back later... ',
	'COMMENT_ADDED'							=>	'Comment successfuly added',
	'MAKE_REQUEST'							=>	'Add New Request',
	'REQUEST_UPDATED'						=>	'The Request information has Been Updated!',
	'VIEW_OWN_REQ'							=>	'View my Requests',
	'NO_REQUEST_NOW'						=>	'There are No Requests at this time.',
	'REQUESTED_BY'							=>	'Requested By',
	'REQUEST_REMOVED'						=>	'This Requist was Successfuly removed',
	'_DELETE_REQUEST'						=>	'Delete Request',
	'_DELETE_REQUEST_CONFIRM'				=>	'Are you Sure you would like to cary out this Action?<br />Once done it can not be undone.',
	'ONLINE'								=>	'User Online',
	'VOTES'									=>	'Votes',
	'VOTE'									=>	'Vote',
	'VOTED'									=>	'Voted',
	'FILLED'								=>	'Filled',
	'COMMENT_EXPLAIN'						=>	'',
	'ERROR_INVALID_COM_ID'					=>	'%1$d is a Invalid Comment ID',
	'ERROR_INVALID_FORUM_ID'				=>	'%1$d is a Invalid Requests ID',
	'ERROR_NOT_REQUEST_OWNER'				=>	'You are not the owner of this Request and do not have prevlages to edit it.',
	'ERROR_REQUEST'							=>	'There is a error in the page you requisted',
	'ERROR_REQ_DEL_EDIT_OWNER'				=>	'You are not the owner of this requist and do not have permistion to edit/delete it',
	'ERROR_NOT_OWNER'						=>	'You\'re not the owner! How did that happen?',
	'ERROR_NO_COMMENT'						=>	'A error acured and there is no such Comment',
	'ERROR_COMMENT_BLANK'					=>	'You can not Leave Comment feald blank If you wish to delete the Coment Please use the Delete tab if Provided',
	'COMMENT_UPDATED'						=>	'Comment was Successfully updated.',
	'COMMENT_REMOVED'						=>	'Comment was Successfully Removed.',
	'LAST_EDIT_BY'							=>	'<br /><br /><a rel="nofollow" href="./user.php?op=profile&id=%1$d">Last edited by %2$s</a>; %3$s.',
	'UPLOADED_URL'							=>	'Uploaded details link Or #Id',
	'FILL_REUEST'							=>	'Fill Request %1$s',
	'FILL_REUEST_RESET'						=>	'The Request %1$s Was reset',
	'FILL_REUEST_INT'						=>	'To Fill This Request',
	'FILL_REUEST_EXP'						=>	'Enter the <strong>full</strong> direct URL of the torrent i.e. <br />%1$s/details.php?id=134 <br />(just copy/paste from another window/tab) or modify the existing URL to have the correct ID number',
	'NEW_SHOUT'								=>	'/notice %1$s has made a request for %2$s',
	'NEW_REQ_ADDED'							=>	'Your Request for %1$s Has been added You well Be notefide By Private message once it has been Filled',
	'NOTHING_FOUND'							=>	'NOTHING FOUND',
	'UNKNOWN_ADD_ERROR'						=>	'A Unknown Error has accurd Please contact A admin Or moderator',
	'REQ_FILLED_PM'							=>	'Your request, [url=%1$s/viewrequests.php?action=details&id=%2$s][b]%3$s[/b][/url], has been filled by [url=%1$s/user.php?op=profile&id=%4$s>[b]%5$s[/b][/url]. You can download your request from [url][b]%6$s[/b][/url].  Please do not forget to leave thanks where due.  If for some reason this is not what you requested, please reset your request so someone else can fill it by following [url=%1$s/viewrequests.php?id=%2$s&action=reqfil&mode=reset]this link[/url].  Do [b]NOT[/b] follow this link unless you are sure that this does not match your request.',
	'REQ_FILLED_PM_SUB'						=>	'Request Filled',
	'SUCCESS_REQ_FILLED_HD'					=>	'Request %1$s successfully filled with <a href=%2$s>%2$s</a>',
	'SUCCESS_REQ_FILLED'					=>	'User <a href=user.php?op=profile&id=%1$s><b>%2$s</b></a> automatically PMd.<br>Filled that accidently? No worries, <a href=reqreset.php?requestid=%3$s>CLICK HERE</a> to mark the request as unfilled.  Do <b>NOT</b> follow this link unless you are sure there is a problem.<br><br>Thank you for filling a request :)<br><br><a href=viewrequests.php>View More Requests</a>',
	'ERROR_NOT_LOCAL'						=>	'The Link you are providing "<strong>%1$s</strong>" is not for a local Upload',
));
?>