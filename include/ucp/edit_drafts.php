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
** And Joe Robertson (aka joeroberts/Black_Heart)
** Project Leaders: Black_Heart, Thor.
** File edit_drafts.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}
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
										confirm_box($check, 'DELETE_DRAFT', $hidden,'confirm_body.html','');							
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