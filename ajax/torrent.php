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
*------              ©2012 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*--------------------   Sunday, May 20, 2012 1:05 AM   ------------------------*
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 ajax/torrent.php  2012-5-20 00:22:48 joeroberts $
* @copyright (c) 2012 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if($op == 'edit_torrent_descr')
	{
		$torrent		= request_var('torrent', '0');
		if( !isset( $torrent ) || !is_numeric($torrent) )
			{
				error("Invalid torrent!" );
			}
			// get the torrent description
			$sql = "SELECT `descr`, `owner` FROM `".$db_prefix."_torrents` WHERE `id` = '".$torrent."'";
			$res = $db->sql_query($sql);
			$descr = $db->sql_fetchrow( $res );
			// make sure user is owner of torrent
			if (!$descr['owner'] = $user->id OR !$user->moderator){
			error("Invalid permissions!");
			}
			print( "<textarea enctype=\"multipart/form-data\" rows=\"10\" cols=\"80\" style=\"border:0px\" onblur=\"if(confirm('Save changes to torrent description?')==true){sndReq('op=save_torrent_descr&torrent=".$_GET['torrent']."&descr='+escape(this.value), 'descrTD".$_GET['torrent']."')}\">".$descr['descr']."</textarea>" );
	}
if($op == 'save_torrent_descr')
	{
		// check for valid ID
		$torrent		= request_var('torrent', '0');
		if( !isset( $torrent ) || !is_numeric($torrent) )
			{
				error("Invalid torrent!" );
			}
		// get the torrent description
		$sql = "SELECT `owner` FROM `".$db_prefix."_torrents` WHERE `id` = '".$torrent."'";
		$res = $db->sql_query($sql);
		$descr = $db->sql_fetchrow( $res );
		// make sure user is owner of torrent
        if (!$descr['owner'] = $user->id OR !$user->moderator){
		error("Invalid permissions!");
		}
		$torrent		= request_var('torrent', '0');
		$descr = $db->sql_escape(request_var('desc', ''));
		$upd_sql = "UPDATE `".$db_prefix."_torrents` SET `descr` = '".$descr."' WHERE `id` = '".$torrent."'";
		$db->sql_query($upd_sql) or btsqlerror($upd_sql);
		print(nl2br(stripslashes($descr)));
	}
if($op == 'change_banned_torrent')
	{
		$torrent		= request_var('torrent', '0');
		if( !isset( $torrent ) || !is_numeric($torrent) )
			{
				error("Invalid torrent!" );
			}
		// check is mod or higher
		if(!checkaccess("m_bann_torrents")){
		error("Invalid permissions!" );
		}
		// create the select
		print( "<select onchange=\"if(confirm('Save banned state?')==true){sndReq('op=save_banned_torrent&torrent=".$torrent."&banned='+this.selectedIndex, 'bannedChange')}\">
		<option value=\"\" selected=\"selected\">Banned?</option>
		<option value=\"1\">Yes</option>
		<option value=\"0\">No</option>
		</select>
		");
	}
if($op == 'save_banned_torrent')
	{
		//check valid torrent
		$banned		= request_var('banned', '0');
		$torrent		= request_var('torrent', '0');
		if( !isset( $torrent ) || !is_numeric($torrent) )
			{
				error("Invalid torrent!" );
			}
		// check is mod or higher
		if(!checkaccess("m_bann_torrents")){
		error("Invalid permissions!" );
		}
		// convert $_GET['banned'] to 'yes' or 'no'
		switch( $banned ){
		case 1 : $state = 'yes'; break;
		case 2 : $state = 'no'; break;
		default : $state = 'no'; break;
		}
		// do the SQL
		$sql = "UPDATE `".$db_prefix."_torrents` SET `banned` = '".$state."' WHERE `id` = '".$torrent."' LIMIT 1";
		$db->sql_query($sql) or btsqlerror($sql);
		// print the outcome
		print( $state );
	}
if($op == 'change_type_torrent')
	{
		//check valid torrent
		$torrent		= request_var('torrent', '0');
		if( !isset( $torrent ) || !is_numeric($torrent) )
			{
				error("Invalid torrent!" );
			}
		ob_end_flush();
$db->sql_close();
die();

		}
		// check is mod or higher
		if(!$user->moderator){
		error("Invalid permissions!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		// create the select
		print("<select onchange=\"if(confirm('Save type change?')==true){sndReq('op=save_type_torrent&torrent=".$torrent."&type='+this.options[this.selectedIndex].value, 'catTD')}\">");
		$cats = catlist();
		print("<option value=\"\">(choose one)</option>\n");
		foreach ($cats as $row){
		print("<option value=\"".$row["id"]."\">".htmlspecialchars($row["name"])."</option>\n");
		}
		print("</select>\n");
	}
if($op == 'save_type_torrent')
	{
		//check valid torrent
		$torrent		= request_var('torrent', '0');
		if( !isset( $torrent ) || !is_numeric($torrent) )
			{
				error("Invalid torrent!" );
			}
		ob_end_flush();
$db->sql_close();
die();

		}
		// check is mod or higher
		if(!$user->moderator){
		error("Invalid permissions!" );
		ob_end_flush();
$db->sql_close();
die();

		}
		$type		= request_var('type', '0');
		// do the SQL
		$sql = "UPDATE `".$db_prefix."_torrents` SET `category` = '".$type."' WHERE `id` = '".$torrent."' LIMIT 1";
		$db->sql_query($sql) or btsqlerror($sql);
		// get the category in text form
		$res = "SELECT `name` FROM `".$db_prefix."_categories` WHERE `id` = '".$type."'";
		$cats_res = $db->sql_query($res);
		$cat = $db->sql_fetchrow( $cats_res);
		// print the outcome
		print( $cat['name'] );
	}
if($op == 'edit_torrent_comment')
	{
		//check valid comment
		$comment		= request_var('comment', '0');
		if( !isset( $comment ) || !is_numeric($comment) )
			{
		error("Invalid comment!" );
		ob_end_flush();
		$db->sql_close();
		die();
		}
		// get comment details
		$sql = "SELECT `user`, `text` FROM `".$db_prefix."_comments` WHERE `id` = '".$comment."' LIMIT 1";
		$res = $db->sql_query($sql);
		$details = $db->sql_fetchrow( $res );
		// check owner
		if(!$user->moderator || $user->id != $details['user'] ){
		error("Invalid permissions!");
		ob_end_flush();
		$db->sql_close();
		die();
		}
		print("<textarea rows=\"8\" cols=\"25\" onblur=\"if(confirm('Save changes?')==true){sndReq('op=save_torrent_comment&comment=".$comment."&text='+escape(this.value), 'comment_".$_GET['comment']."')}\">".$details['text']."</textarea>");
		ob_end_flush();
		$db->sql_close();
		die();
	}
if($op == 'save_torrent_comment')
	{
		//check valid comment
		$comment		= request_var('comment', '0');
		if( !isset( $comment ) || !is_numeric($comment) )
			{
		error("Invalid comment!" );
		ob_end_flush();
		$db->sql_close();
		die();
		}

		}
		// get comment details
		$sql = "SELECT `user` FROM `".$db_prefix."_comments` WHERE `id` = '".$comment."' LIMIT 1";
		$res = $db->sql_query($sql);
		$details = $db->sql_fetchrow( $res );
		// check owner
		if(!$user->moderator || $user->id != $details['user'] ){
		error("Invalid permissions!");
		ob_end_flush();
$db->sql_close();
die();

		}
		// make sure not blank
		$text		= request_var('text', '');
		if( !isset( $text ) || empty( $text ) ){
		error("Body can not be empty!");
		ob_end_flush();
$db->sql_close();
die();

		}
		// save changes
		$editedat = get_date_time();
		$db->sql_query("UPDATE `".$db_prefix."_comments` SET `text` = '".$db->sql_escape($text)."' WHERE `id` = '".$comment."' LIMIT 1");
		// print out the comment
		print( nl2br( stripslashes( $_GET['text'] ) ) );
		ob_end_flush();
$db->sql_close();
die();

	}
if($op == 'delete_torrent_comment')
	{
		$postid 		= request_var('postid', '0');
		if (!$user->moderator || !is_valid_id($postid)){
		error("Invalid operation!" );
		die;
		}
		//------- Delete comment
		$db->sql_query("DELETE FROM `".$db_prefix."_comments` WHERE id=$postid");
		ob_end_flush();
$db->sql_close();
die();
?>