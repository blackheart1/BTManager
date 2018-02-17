<?php
/*
*-----------------------------phpMyBitTorrent V 3.0.0--------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*-----------------  Thursday, November 04, 2010 9:05 PM   ---------------------*
*/
/**
*
* @package phpMyBitTorrent
* @version $Id: 3.0.0 edit_drafts.php 1 2010-11-04 00:22:48Z joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
	$do                                     = request_var('do', '');
                switch($do) {
							case "edit_take" :
							{
							$edit_id = request_var('edit_id', '');
							if($edit_id == '') $error[] = $user->lang['INVALID_ID'];
							$subject = request_var('subject', '');
							if($subject == '') $error[] = $user->lang['ERR_NO_SUB'];
							$message = request_var('message', '');
							if($message == '') $error[] = $user->lang['ERR_NO_BODY'];
							if (count($error) > 0){
							$errmsg = "<p>".$user->lang['BT_ERROR']."</p>\n";
							$errmsg .= "<ul>\n";
									foreach ($error as $msg) {
									$errmsg .= "<li><p>".$msg."</p></li>\n";
									}
							$errmsg .= "</ul>\n";
							}else $errmsg = '';
							if($errmsg == '')
							{
								$subject = $db->sql_escape(stripslashes($subject));
								$message = $db->sql_escape(stripslashes($message));
								$sql = 'UPDATE `'.$db_prefix.'_drafts` SET `draft_subject` = \'' . $subject . '\', `draft_message` = \'' . $message . '\' WHERE `'.$db_prefix.'_drafts`.`draft_id` = ' . $edit_id . ' LIMIT 1;'; 
								$db->sql_query($sql);
							}
							$template->assign_vars(array('ERROR' => $errmsg));
							break;
							}
							case "edit_delete" :
							{
								$d                                     = request_var('d', array(0));
								$hidden = '';
								if(isset($d) && count($d) >=1){
									foreach($d as $key => $value)
									$hidden .= build_hidden_fields(array("d[".$key."]" 	=> 1));
								}
								$hidden .= build_hidden_fields(array(
								"op"			=> "editprofile",
								"take_edit"		=> "1",
								"check" 		=> 1,
								"action" 		=> 'overview',
								"mode"			=> 'drafts',
								"delete"		=> 1,
								"do"			=> "edit_delete"
								));
							if(isset($check))$check=true;
							else
							$check = false;
										confirm_box($check, 'bt_fm_del_draft', $hidden,'confirm_body.html','');							
							    if(!isset($d) OR !count($d) >=1)
								{
								$template->assign_vars(array('ERROR' => $user->lang['NO_DRAFTS_SET']));
								break;
								}
										 foreach($d as $book=> $value){
										 $db->sql_query("DELETE FROM ".$db_prefix."_drafts WHERE draft_id = '" . $book ."' AND user_id = '" . $uid ."' LIMIT 1");
									     }
								$template->assign_vars(array('ERROR' => ''));
								break;
							}
				}

?>