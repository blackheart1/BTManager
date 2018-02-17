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
* @version $Id: 3.0.0 faqmanage.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
$user->set_lang('admin/faqmanager',$user->ulanguage);
$action			= request_var('action', '');
$order			= request_var('order', array(0));
$fid			= request_var('id', '');
$question		= utf8_normalize_nfc(request_var('question', '',true));
$type			= request_var('type', '');
$flag			= request_var('flag', '');
$title			= utf8_normalize_nfc(request_var('title', '',true));
$answer			= utf8_normalize_nfc(request_var('answer', '',true));
$categ			= utf8_normalize_nfc(request_var('categ', '',true));
$inid			= request_var('inid', '');
if ($action == "reorder") {
 foreach($order as $id => $position) $db->sql_query("UPDATE `".$db_prefix."_faq` SET `order`='$position' WHERE id='$id'") or sqlerr();
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['EDIT_REORDER_SAVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}
elseif ($action == "edit" && isset($fid)) {
	$res1 = "SELECT * FROM `".$db_prefix."_faq` WHERE `id`='".$fid."' LIMIT 1;";
 	$res = $db->sql_query($res1);
	$db->sql_freeresult($res1);
	$u_action = "./admin.php";
	while ($arr = $db->sql_fetchrow($res)) {
		$arr['question'] = stripslashes($arr['question']);
  		$arr['answer'] = stripslashes($arr['answer']);
  		if ($arr['type'] == "item") {
	$hidden = build_hidden_fields(array(
	"id"		=> $fid,
	'action'	=> 'edititem',
	'i'			=> 'staff',
	'op'		=> 'faqmanage',
	));
   			if ($arr['flag'] == "0") $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\">".$user->lang['F_NEW']."</option></select>";
   			elseif ($arr['flag'] == "2") $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\" selected=\"selected\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\">".$user->lang['F_NEW']."</option></select>";
   			elseif ($arr['flag'] == "3") $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">".$user->lang['F_NEW']."</option></select>";
   			else $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\">".$user->lang['F_NEW']."</option></select>";
   			$res3 = "SELECT `id`, `question` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
			$res = $db->sql_query($res3);
			$db->sql_freeresult($res3);
   			$catsel = "<select style=\"width: 300px;\" name=\"categ\" />";
			while ($arr2 = $db->sql_fetchrow($res)) {
    			$selected = ($arr2['id'] == $arr['categ']) ? " selected=\"selected\"" : "";
    			$catsel .="<option value=\"".$arr2['id']."\"". $selected .">".$arr2['question']."</option>";
   			}
   			$catsel .="</select>";
   			$template->assign_vars(array(
				'L_TITLE'            => $user->lang['F_TITLE_D'],
				'L_EXPLAIN'            => $user->lang['F_TITLE_ED_IT_EXP'],
				'ISITEM'			=> true,
   				'F_ID'				=> $arr['id'],
   				'F_Q_AREA'			=> 'question',
   				'F_QUEST'			=> $arr['question'],
   				'T_AREA'			=> 'answer',
   				'F_STATUS'			=> $flag,
   				'F_CATIGORY'		=> $catsel,
   				'S_TEXT'			=> $arr['answer'],
				'HIDEN'				=> $hidden,
				'U_ACTION'			=> $u_action,
   			));
  		}
  		elseif ($arr[type] == "categ") {
	$hidden = build_hidden_fields(array(
	"id"		=> $fid,
	'action'	=> 'editsect',
	'i'			=> 'staff',
	'op'		=> 'faqmanage',
	));
   			if ($arr[flag] == "0") $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\" selected=\"selected\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\">".$user->lang['F_NORMAL']."</option></select>";
   			else $flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">".$user->lang['F_NORMAL']."</option></select>";
   			$template->assign_vars(array(
				'L_TITLE'            => $user->lang['F_TITLE_D'],
				'L_EXPLAIN'            => $user->lang['F_TITLE_ED_CAT_EXP'],
				'ISITEM'			=> false,
   				'F_ID'				=> $arr['id'],
   				'F_STATUS'			=> $flag,
   				'F_QUEST'			=> $arr['question'],
				'HIDEN'				=> $hidden,
				'U_ACTION'			=> $u_action,
   			));
  		}
 	}
echo $template->fetch('admin/edit_faqs.html');
close_out(); 
}
elseif ($action == "edititem" && $fid != NULL && $question != NULL && $answer != NULL && $flag != NULL && $categ != NULL) {
 $question = $db->sql_escape(stripslashes(htmlspecialchars_decode($question)));
 $answer = $db->sql_escape(stripslashes(htmlspecialchars_decode($answer)));
 $db->sql_query("UPDATE `".$db_prefix."_faq` SET `question`='$question', `answer`='$answer', `flag`='$flag', `categ`='$categ' WHERE id='$fid'") or sqlerr();
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['EDIT_ITEM_SAVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}
elseif ($action == "editsect" && $fid != NULL && $title != NULL && $flag != NULL) {
 $title = $db->sql_escape(stripslashes(htmlspecialchars_decode($title)));
 $db->sql_query("UPDATE `".$db_prefix."_faq` SET `question`='$title', `answer`='', `flag`='$flag', `categ`='0' WHERE id='$fid'") or sqlerr();
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['EDIT_SECTION_SAVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}
elseif ($action == "delete" && isset($fid)) {
$confirm_key			= request_var('confirm_key', '');
		if (confirm_box(true))
		{
  $db->sql_query("DELETE FROM `".$db_prefix."_faq` WHERE `id`='".$fid."' LIMIT 1") or sqlerr();
						logerror($user->lang['F_REMOVED'],'admin');//log group chonge
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['F_REMOVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
		}
		else
		{
								$hidden = build_hidden_fields(array(
								"id"				=> $fid,
								"i"					=> 'staff',
								"op"				=> 'faqmanage',
								"action"			=> 'delete',
								));
		confirm_box(false, $user->lang['CONFIRM_OPERATION_DEL_FA'], $hidden,'confirm_body.html','admin.php');
		}

}
elseif ($action == "additem" && $inid) {
								$hidden = build_hidden_fields(array(
								"i"					=> 'staff',
								"op"				=> 'faqmanage',
								"action"			=> 'addnewitem',
								));
   			$res3 = "SELECT `id`, `question` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
			$res = $db->sql_query($res3);
			$db->sql_freeresult($res3);
   			$catsel = "<select style=\"width: 300px;\" name=\"categ\" />";
			while ($arr2 = $db->sql_fetchrow($res)) {
    			$selected = ($inid == $arr['categ']) ? " selected=\"selected\"" : "";
    			$catsel .="<option value=\"".$arr2['id']."\"". $selected .">".$arr2['question']."</option>";
   			}
   			$catsel .="</select>";
			$flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" >".$user->lang['F_NORMAL']."</option><option value=\"2\" style=\"color: #0000FF;\">".$user->lang['F_UPDATED']."</option><option value=\"3\" style=\"color: #008000;\" selected=\"selected\">".$user->lang['F_NEW']."</option></select>";
			$u_action = 'admin.php';
   			$template->assign_vars(array(
				'L_TITLE'            => $user->lang['F_TITLE_D'],
				'L_EXPLAIN'            => $user->lang['F_TITLE_AD_IT_EXP'],
				'ISITEM'			=> true,
				'F_NEW'				=> true,
   				'F_Q_AREA'			=> 'question',
   				'F_QUEST'			=> '',
   				'T_AREA'			=> 'answer',
   				'F_STATUS'			=> $flag,
   				'F_CATIGORY'		=> $catsel,
   				'S_TEXT'			=> '',
				'HIDEN'				=> $hidden,
				'U_ACTION'			=> $u_action,
   			));
echo $template->fetch('admin/edit_faqs.html');
close_out(); 
}

// ACTION: addsection - add a new section
elseif ($action == "addsection") {
								$hidden = build_hidden_fields(array(
								"i"					=> 'staff',
								"op"				=> 'faqmanage',
								"action"			=> 'addnewsect',
								));
			$flag = "<select name=\"flag\" style=\"width: 110px;\"><option value=\"0\" style=\"color: #FF0000;\">".$user->lang['F_HIDDEN']."</option><option value=\"1\" style=\"color: #000000;\" selected=\"selected\">".$user->lang['F_NORMAL']."</option></select>";			$u_action = 'admin.php';
   			$template->assign_vars(array(
				'L_TITLE'            => $user->lang['F_TITLE_D'],
				'L_EXPLAIN'            => $user->lang['F_TITLE_AD_CAT_EXP'],
				'ISITEM'			=> false,
				'F_NEW'				=> true,
   				'F_Q_AREA'			=> 'title',
   				'F_QUEST'			=> '',
   				'F_STATUS'			=> $flag,
				'HIDEN'				=> $hidden,
				'U_ACTION'			=> $u_action,
   			));
echo $template->fetch('admin/edit_faqs.html');
close_out(); 
}

// subACTION: addnewitem - add a new item to the db
elseif ($action == "addnewitem" && $question != NULL && $answer != NULL && $flag != NULL && $categ != NULL) {
 $question = $db->sql_escape(stripslashes(htmlspecialchars_decode($question)));
 $answer = $db->sql_escape(stripslashes(htmlspecialchars_decode($answer)));
 $res1 = "SELECT MAX(`order`) FROM `".$db_prefix."_faq` WHERE `type`='item' AND `categ`='$categ';";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res)) $order = $arr[0] + 1;
 $db->sql_query("INSERT INTO `".$db_prefix."_faq` (`type`, `question`, `answer`, `flag`, `categ`, `order`) VALUES ('item', '$question', '$answer', '$flag', '$categ', '$order')") or sqlerr();
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['ADD_ITEM_SAVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}

// subACTION: addnewsect - add a new section to the db
elseif ($action == "addnewsect" && $title != NULL && $flag != NULL) {
 $title = $db->sql_escape(stripslashes(htmlspecialchars_decode($title)));
 $res1 ="SELECT MAX(`order`) FROM `".$db_prefix."_faq` WHERE `type`='categ';";
$res = $db->sql_query($res1);
$db->sql_freeresult($res1);
while ($arr = $db->sql_fetchrow($res)) $order = $arr[0] + 1;
 $db->sql_query("INSERT INTO `".$db_prefix."_faq` (`type`, `question`, `answer`, `flag`, `categ`, `order`) VALUES ('categ', '$title', '', '$flag', '0', '$order')") or sqlerr();
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=staff&op=faqmanage",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['ADD_SECTION_SAVED'],
                                ));
		echo $template->fetch('message_body.html');
		close_out();
}
$template->assign_vars(array(
'L_TITLE'            => $user->lang['F_TITLE_D'],
'L_EXPLAIN'            => $user->lang['F_TITLE_D_EXP'],
));
$orphanc = '0';
$res1 = "SELECT `id`, `type`, `question`, `answer`, `flag`, `categ`, `order` FROM `".$db_prefix."_faq` WHERE `type`='categ' ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$c_count = $db->sql_numrows($res);
$db->sql_freeresult($res1);
while ($arr1 = $db->sql_fetchrow($res)) {
$orphanc .= ','.$arr1['id'];
  $orderc = "<select name=\"order[". $arr1['id'] ."]\">";
  for ($n=1; $n <= $c_count; $n++) {
   $sel = ($n == $arr1['order']) ? " selected=\"selected\"" : "";
   $orderc .= "<option value=\"$n\"". $sel .">". $n ."</option>";
  }
  $orderc .= "</select>";
  unset($n);
  $status = ($arr1['flag'] == "0") ? "<font color=\"red\">"._adm_faq_hidden."</font>" : ""._adm_faq_norm."";
							$template->assign_block_vars('f_block1',array(
					'L_TITLE'		=> '',
					'S_SELECTED'	=> true,
					'U_TITLE'		=> '',));
							$template->assign_block_vars('f_block1.f_block2',array(
					'F_ID'			=> $arr1['id'],
					'F_TYPE'		=> $arr1['type'],
					'F_TITLE'		=> $arr1['question'],
					'F_ANSWER'		=> $arr1['answer'],
					'F_FLAG'		=> $status,
					'F_CATEG'		=> $arr1['categ'],
					'F_ORDER'		=> $orderc,
					));
$res1 = "SELECT `id`, `type`, `question`, `answer`, `flag`, `categ`, `order` FROM `".$db_prefix."_faq` WHERE `type`='item' AND `categ`='".$arr1['id']."'ORDER BY `order` ASC;";
$res3 = $db->sql_query($res1);
$f_count = $db->sql_numrows($res3);
$db->sql_freeresult($res1);
while ($arr2 = $db->sql_fetchrow($res3)) {
  $orderi = "<select name=\"order[". $arr2['id'] ."]\">";
  for ($ni=1; $ni <= $f_count; $ni++) {
   $seli = ($ni == $arr2['order']) ? " selected=\"selected\"" : "";
   $orderi .= "<option value=\"$ni\"". $seli .">". $ni ."</option>";
  }
  $orderi .= "</select>";
  unset($ni);
    if ($arr2['flag'] == "0") $status = "<font color=\"#FF0000\">"._adm_faq_hidden."</font>";
    elseif ($arr2['flag'] == "2") $status = "<font color=\"#0000FF\">"._adm_faq_updated."</font>";
    elseif ($arr2['flag'] == "3") $status = "<font color=\"#008000\">"._adm_faq_new."</font>";
    else $status = "Normal";
							$template->assign_block_vars('f_block1.f_block2.f_block3',array(
					'F_ID'			=> $arr2['id'],
					'F_TYPE'		=> $arr2['type'],
					'F_TITLE'		=> stripslashes($arr2['question']),
					'F_ANSWER'		=> stripslashes($arr2['answer']),
					'F_FLAG'		=> $status,
					'F_CATEG'		=> $arr2['categ'],
					'F_ORDER'		=> $orderi,
					));
}
}
$res1 = "SELECT `id`, `type`, `question`, `answer`, `flag`, `categ`, `order` FROM `".$db_prefix."_faq` WHERE `categ` NOT IN (".$orphanc.") ORDER BY `order` ASC;";
$res = $db->sql_query($res1);
$f_count = $db->sql_numrows($res);
$db->sql_freeresult($res1);
while ($arr1 = $db->sql_fetchrow($res)) {
    if ($arr1['flag'] == "0") $status = "<font color=\"#FF0000\">"._adm_faq_hidden."</font>";
    elseif ($arr1['flag'] == "2") $status = "<font color=\"#0000FF\">"._adm_faq_updated."</font>";
    elseif ($arr1['flag'] == "3") $status = "<font color=\"#008000\">"._adm_faq_new."</font>";
    else $status = "Normal";
							$template->assign_block_vars('orphanc',array(
					'F_ID'			=> $arr1['id'],
					'F_TYPE'		=> $arr1['type'],
					'F_TITLE'		=> stripslashes($arr1['question']),
					'F_ANSWER'		=> stripslashes($arr1['answer']),
					'F_FLAG'		=> $status,
					'F_CATEG'		=> $arr1['categ'],
					'F_ORDER'		=> $arr1['order'],
					));
}
echo $template->fetch('admin/faqmanager.html');
		close_out();
?>