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
** File comment.php 2018-02-19 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
$startpagetime = microtime();
require_once("common.php");
include_once("include/utf/utf_tools.php");
require_once("include/torrent_functions.php");
if (!$user->user)header('Location: '.$siteurl.'/login.php');
				$edit = false;
$template = new Template();
$user->set_lang('edit',$user->ulanguage);
$user->set_lang('comment',$user->ulanguage);
set_site_var($user->lang['TITTLE_EDIT']);
$id	= (int)request_var('id', 0);
$cid	= (int)request_var('cid', 0);
$template->assign_vars(array(
        'T_ID'            => $id,
));

$cid = intval($cid);
$template->assign_vars(array(
        'T_CID'            => $cid,
));
$template->assign_vars(array(
        'S_FORWARD'            => "details.php?id=" . $id . "&comm=startcomments",
));
switch ($op) {
                case "add": {
                        global $language, $langlevel, $admin_mail;
						$comment	= request_var('comment', '',true);
if ($comment =='')
{
				$template->assign_vars(array(
					'S_ERROR'			=> true,
					'S_FORWARD'			=> false,
					'TITTLE_M'			=> $user->lang['BT_ERROR'],
					'MESSAGE'			=> $user->lang['NO_DESCR'] . '<br /><br /><a href="javascript:history.go(-1)"  onMouseOver="self.status=document.referrer;return true">' . $user->lang['GO_BACK'] . '</a>',
				));
				echo $template->fetch('message_body.html');
				close_out();
}
						include_once('include/function_posting.php');
						include_once('include/message_parser.php');
						include_once('include/class.bbcode.php');
						include_once('include/function_messenger.php');
						$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false;
						$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false;
						$img_status			= ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false;
						$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false;
						$url_status			= ($config['allow_post_links']) ? true : false;
						$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
						$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_pm_smilies'));
						$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_pm_bbcode'));
						$enable_urls		= ($config['enable_urls'])?true:false;
						$message_parser = new parse_message();
						$message_parser->message = $comment;
						$bbcode_uid = $message_parser->bbcode_uid;
						$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
						$comment = $db->sql_escape(stripslashes($message_parser->message));
                        $sql = "INSERT INTO ".$db_prefix."_comments (user, torrent, added, text, bbcode_bitfield, bbcode_uid) VALUES ('" .$user->id . "', '".$id."', NOW(), '" . $comment . "','" . $message_parser->bbcode_bitfield . "','" . $message_parser->bbcode_uid . "');";
                        $db->sql_query($sql) or btsqlerror($sql);

                        $newid = $db->sql_nextid();

                        $db->sql_query("UPDATE ".$db_prefix."_torrents SET comments = comments + 1 WHERE id = '".intval($id)."'") or btsqlerror("UPDATE ".$db_prefix."_torrents SET comments = comments + 1 WHERE id = '$id'");
                        $bon = "SELECT active, comment FROM ".$db_prefix."_bonus_points ;";
                        $bonset = $db->sql_query($bon);
                        list ($active, $comment) = $db->sql_fetchrow($bonset);
                        $db->sql_freeresult($bonset);
						if($active=='true' AND $user->id !=0)
						{
							$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$comment."' WHERE id= ".$user->id."" ;
							$db->sql_query($do) or btsqlerror($do);
						}
                        //Send notify
                        $sql = "SELECT U.name, U.email FROM ".$db_prefix."_users U, ".$db_prefix."_comments_notify C WHERE C.user = U.id AND C.status = 'active' AND C.torrent = '".$id."' ;";
                        $res = $db->sql_query($sql) or btsqlerror($sql);
        				$tor = "SELECT * FROM ".$db_prefix."_torrents WHERE id = '".intval($id)."' ;";
        				$nott = $db->sql_query($tor)or btsqlerror($tor);
	        			$tortn = $db->sql_fetchrow($nott);
	        			$db->sql_freeresult($nott);
						$messenger = new messenger();
						$messenger->template('comentnotify', $language);
						while($row = $db->sql_fetchrow($res))
						{
							$messenger->to($row["email"], $row["username"]);
						}
						$messenger->assign_vars(array(
									'SUB_JECT'				=>	sprintf($user->lang['COMMENTNOTIFY_SUB'],$sitename),
									'TOR_URL'				=>	$siteurl . '/details.php?id=' . $id ,
									'TOR_NAME'				=>	$tortn['name'] ,
									'TOR_URL_WATCH'			=>	$siteurl . '/details.php?op=comment&trig=off&id=' . $id . '#notify',
									));
						$messenger->send(0);
						$messenger->save_queue();

                        $sqlupldate = "UPDATE ".$db_prefix."_comments_notify SET status = 'stopped' WHERE ".$db_prefix."_comments_notify.torrent = '".$id."' ;";
                        $db->sql_query($sqlupldate);
						$template->assign_vars(array(
								'S_SUCCESS'            => true,
								'TITTLE_M'             => $user->lang['COMENT_ON_TOR'],
								'MESSAGE'              => sprintf($user->lang['COMMENT_POSTED'],$id),
						));
                        break;
                }
                case "delete": {
                        $sql = "SELECT user, text FROM ".$db_prefix."_comments WHERE id = '".$cid."' LIMIT 1;";
                        $res = $db->sql_query($sql) or bterror($sql);
                        list ($owner, $text) = $db->fetch_array($res);
						//die($text);
                        $db->sql_freeresult($res);
                        if ($owner != $user->id AND !checkaccess("m_delete_comments")) {
                                trigger_error($user->lang['ERROR_NOT_AUTH_EDCOM']);
                        } else {
                                $sql = "DELETE FROM ".$db_prefix."_comments WHERE id = '".$cid."';";
                                $db->sql_query($sql) or btsqlerror($sql);
								$lesthanks = '';
                                if($text === ':thankyou:')
								{
									$sql = "DELETE FROM ".$db_prefix."_thanks WHERE uid = '".$owner."' AND torid = '".$id."';";
									if($db->sql_query($sql))
									{
										$lesthanks = ', thanks = thanks - 1';
									}
								}
                                $squpdate = "UPDATE ".$db_prefix."_torrents SET comments = comments - 1" . $lesthanks . " WHERE id = '".$id."'";
                                $db->sql_query($squpdate) or btsqlerror($squpdate);
							$bon = "SELECT active, comment FROM ".$db_prefix."_bonus_points ;";
							$bonset = $db->sql_query($bon);
							list ($active, $comment) = $db->fetch_array($bonset);
							$db->sql_freeresult($bonset);
							if($active=='true' AND $user->id !=0)
							{
													$do="UPDATE ".$db_prefix."_users SET seedbonus = seedbonus - '".$comment."' WHERE id= ".$owner."" ;
													$db->sql_query($do) or btsqlerror($do);
							}
						meta_refresh(3, $siteurl . "/details.php?id=" . $id . "&comm=startcomments");
							$template->assign_vars(array(
									'S_SUCCESS'            => true,
									'TITTLE_M'             => $user->lang['COMENT_ON_TOR'],
									'MESSAGE'              => sprintf($user->lang['COMENT_REMOVED'],$id),
							));
                        }
                        break;
                }
                case "take_edit":
				{
					$msg	= request_var('msg', '',true);
					if($msg == '')
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['BT_ERROR'],
							'MESSAGE'			=> $user->lang['ERROR_COMMENT_BLANK'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
					$sql = "SELECT user, text FROM `".$db_prefix."_comments` WHERE `id`='" . $cid ."';";
					$res = $db->sql_query($sql) or btsqlerror($sql);
					$row = $db->sql_fetchrow($res);
					if(!$row[0])
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['BT_ERROR'],
							'MESSAGE'			=> $user->lang['ERROR_COMENT_ID'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
					if($row[0] == $user->id AND !checkaccess("u_edit_own_comments"))
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['BT_ERROR'],
							'MESSAGE'			=> $user->lang['ERROR_NOT_AUTH_EDCOM'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
					if(!$row[0] == $user->id AND !checkaccess("m_edit_comments"))
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['BT_ERROR'],
							'MESSAGE'			=> $user->lang['ERROR_NOT_AUTH_MDCOM'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
					$sql = "SELECT COUNT(id) FROM `".$db_prefix."_torrents` WHERE `id`='" . $id ."';";
					$res2 = $db->sql_query($sql) or btsqlerror($sql);
					$row2 = $db->sql_fetchrow($res2);
					if($row2[0] == 0)
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['BT_ERROR'],
							'MESSAGE'			=> $user->lang['ERROR_COMENT_TOR'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
					
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
 					$bbcode_status		= ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false;
					$smilies_status		= ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false;
					$img_status			= ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false;
					$flash_status		= ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false;
					$url_status			= ($config['allow_post_links']) ? true : false;
					$enable_sig			= ($config['allow_sig'] && $config['allow_sig_pm'] && checkaccess('u_sig'));
					$enable_smilies		= ($config['allow_smilies'] && checkaccess('u_pm_smilies'));
					$enable_bbcode		= ($config['allow_bbcode'] && checkaccess('u_pm_bbcode'));
					$enable_urls		= ($config['enable_urls'])?true:false;
					$message_parser = new parse_message();
					$message_parser->message = $msg;
					$bbcode_uid = $message_parser->bbcode_uid;
					$message_parser->parse($enable_bbcode, ($config['allow_post_links']) ? $enable_urls : false, $enable_smilies, $img_status, $flash_status, true, $config['allow_post_links']);
					$msg = $db->sql_escape(stripslashes($message_parser->message));
					$sql = 'UPDATE ' . $db_prefix . '_comments 
					SET 
						text = \'' . $msg . '\', 
						editedat = NOW(), 
						editedby = ' . $user->id . ", 
						bbcode_bitfield = '" . $message_parser->bbcode_bitfield . "', 
						bbcode_uid = '" . $message_parser->bbcode_uid . "' 
					WHERE 
						id = " . $cid . ' LIMIT 1;'; 
					$db->sql_query($sql)or die(mysql_error());
						meta_refresh(5, $siteurl . "/details.php?id=" . $id . "&comm=startcomments");
						$template->assign_vars(array(
							'S_SUCCESS'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['SUCCESS'],
							'MESSAGE'			=> $user->lang['SUCCES_EDIT_TAKEN'] . back_link("details.php?id=" . $id . "&comm=startcomments"),
						));
						echo $template->fetch('message_body.html');
						close_out();
				}
                case "edit_coment": {
                $take											= request_var('take', '');
					
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
					generate_smilies('inline', 0);
					$num_predefined_bbcodes = 22;
					$s_pm_icons = false;
				$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
					FROM '.$db_prefix.'_bbcodes
					WHERE display_on_posting = 1
					ORDER BY bbcode_tag';
				$result = $db->sql_query($sql);
			
				$i = 0;
				while ($rows = $db->sql_fetchrow($result))
				{
					// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
					if (isset($user->lang[strtoupper($rows['bbcode_helpline'])]))
					{
						$rows['bbcode_helpline'] = $user->lang[strtoupper($rows['bbcode_helpline'])];
					}
			
					$template->assign_block_vars('custom_tags', array(
						'BBCODE_NAME'		=> "'[{$row['bbcode_tag']}]', '[/" . str_replace('=', '', $row['bbcode_tag']) . "]'",
						'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
						'BBCODE_TAG'		=> $rows['bbcode_tag'],
						'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
						'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
					));
			
					$i++;
				}
				$db->sql_freeresult($result);
                $sql = "SELECT * FROM `".$db_prefix."_comments` WHERE `id`='" . $cid ."';";
                $res = $db->sql_query($sql) or btsqlerror($sql);
				$row = $db->sql_fetchrow($res);
					$message_parser = new parse_message();
					//die($row["text"]);
					$row["text"] = smiley_text($row["text"],true);
					$message_parser->message = $row["text"];
					$message_parser->decode_message($row['bbcode_uid']);
					//die($message_parser->message);
                $sql = "SELECT name FROM `".$db_prefix."_torrents` WHERE `id`='" . $id ."';";
                $res2 = $db->sql_query($sql) or btsqlerror($sql);
				$row2 = $db->sql_fetchrow($res2);
                    $template->assign_vars(array(
			        'L_EDIT_TITLE'				=> sprintf($user->lang['BLOCK_TITLE'],$row2[0]),
			        'C_ID'						=> $cid,
			        'T_ID'						=> $id,
			        'T_NAME'					=> $row2['name'],
					'U_ACTION'					=>	'./comment.php',
					'S_SHOW_PM_ICONS'			=> false,
					'S_SMILIES_ALLOWED'			=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
					'S_SHOW_SMILEY_LINK'		=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
					'S_BBCODE_ALLOWED'			=> ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false,
					'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
					'S_BBCODE_QUOTE'			=> true,
					'S_BBCODE_IMG'				=> ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false,
					'S_LINKS_ALLOWED'			=> ($config['allow_post_links']) ? true : false,
					'S_BBCODE_FLASH'			=> ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false,
					'HIDDEN'					=>	build_hidden_fields(array('op'=>'take_edit', 'id' => $id, 'cid' => $cid)),
			        'O_NAME'					=>	false,
					'O_CAT_SELECT'				=>	false,
			        'O_MESSAGE'					=> $message_parser->message,
                    'S_FORWARD'					=> "details.php?id=" . $id . "&comm=startcomments",
			        'S_ERROR'					=> false,
			        'S_SUCCESS'					=> true,
			        'TITTLE_M'					=> $user->lang['COMENT_ON_TOR'],
			        'MESSAGE'					=> "<p>".str_replace("**id**", $id,_btcommentdeleted)."</p>",
					));
				if(!$take ==1)$edit = true;
                        break;
				}
}
if(!$edit)
{
	echo $template->fetch('message_body.html');
}
else
{
	echo $template->fetch('edit_body.html');
}
	close_out();
?>