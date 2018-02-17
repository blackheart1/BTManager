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
* @version $Id: 3.0.0 mytorrents.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
if (defined('IN_PMBT'))
{
	die ("You can't include this file");
}
else
{
	define("IN_PMBT",true);
}
require_once("common.php");
require_once("include/torrent_functions.php");
include_once("include/utf/utf_tools.php");
$user->set_lang('my_torrents',$user->ulanguage);
$template = new Template();
$op		= request_var('op', '');
set_site_var($user->lang['MY_TORRENTS']);
if (!$user->user)
{
	loginrequired("user");
}
switch ($op) {
        case "savetorrentgeneral": {
				$id	= request_var('id', '0');
				$private	= request_var('private', '');
				$minratio	= request_var('minratio', '');
                if (!is_numeric($id))
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['MY_TORRENTS'],
							'MESSAGE'			=> $user->lang['ERROR_ENTERING_DATA'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
                if (!isset($private) OR $private != "true") $private = "false";
                if (!isset($minratio) OR !preg_match("/^[0-1]\.[0-9]0$/",$minratio))
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['MY_TORRENTS'],
							'MESSAGE'			=> $user->lang['ERROR_ENTERING_DATA'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
                $sql = "UPDATE ".$db_prefix."_torrents SET private = '".$private."', min_ratio = '".$minratio."' WHERE id = '".$id."';";
                $db->sql_query($sql) or btsqlerror($sql);
                $op = "displaytorrent";
				meta_refresh(5, $siteurl . '/mytorrents.php?op=displaytorrent&id=' . $id);
				$template->assign_vars(array(
						'S_SUCCESS'				=> true,
						'TITTLE_M'				=>	 $user->lang['SUCCESS'],
						'MESSAGE'				=>	 $user->lang['PRIVAZY_UPDATED'] . back_link($siteurl . '/mytorrents.php?op=displaytorrent&id='.$id),
				));
						echo $template->fetch('message_body.html');
						close_out();
        }
        case "savetorrent": {
				$id	= request_var('id', '0');
                if (!is_numeric($id))
					{
						$template->assign_vars(array(
							'S_ERROR'			=> true,
							'S_FORWARD'			=> false,
							'TITTLE_M'			=> $user->lang['MY_TORRENTS'],
							'MESSAGE'			=> $user->lang['ERROR_ENTERING_DATA'],
						));
						echo $template->fetch('message_body.html');
						close_out();
					}
                $notifications = New MailingList();
				$auth_users	= request_var('auth_users', '');
                $auth_users = explode(",",$auth_users);
                foreach ($auth_users as $auth) {
                        if (!is_numeric($auth))
						{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['MY_TORRENTS'],
								'MESSAGE'			=> $user->lang['ERROR_ENTERING_DATA'],
							));
							echo $template->fetch('message_body.html');
							close_out();
						}
                        $uservar = "user".$auth;
                        switch ($$uservar) {
                                case "grant": {
                                        $sql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
                                        $row = $db->sql_fetchrow($db->sql_query($sql));
                                        if ($row["status"] != "granted") {
                                                $sql = "UPDATE ".$db_prefix."_privacy_file SET status = 'granted' WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
                                                $db->sql_query($sql) or btsqlerror($sql);
                                                $gr_sql = "SELECT U.email, U.language, U.username, T.name, T.id FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_torrents T ON T.id = '".$id."' WHERE U.id = ".$auth.";";
												$gr_res = $db->sql_query($gr_sql);
												list ($gr_email, $gr_language, $gr_name, $gr_tname, $gr_tid) = $db->fetch_array($gr_res);
												if (!$gr_language OR !file_exists("language/email/".$gr_language."/authreq.txt")) $lang_email = $language;
												else $lang_email = $gr_language;
                                                $confirm_mail = new eMail;
												$data = $confirm_mail->get_mail_text('authgrant',$lang_email);
												$pass = array(
												'gr_name' => $gr_name,
												'granter' => $user->name,
												'gr_tname' => $gr_tname,
												'gr_tid' => $gr_tid,
												'data'	=> $data);
												$confirm_mail->clean_body($pass);
                                                $confirm_mail->sender = $admin_email;
                                                $confirm_mail->Add($gr_email);
                                                $confirm_mail->subject = sprintf($user->lang['AUTH_EMAIL_SUB'],$sitename);
                                                $notifications->Insert($confirm_mail);
                                                //unset($confirm_mail);
                                        }
                                        break;

                                }
                                case "deny": {
												$sql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
												$row = $db->sql_fetchrow($db->sql_query($sql));
												if ($row["status"] != "denied") {
                                                $sql = "UPDATE ".$db_prefix."_privacy_file SET status = 'denied' WHERE master = '".$user->id."' AND slave = '".$auth."' AND torrent = '".$id."';";
                                                $db->sql_query($sql) or btsqlerror($sql);
                                                $gr_sql = "SELECT U.email, U.language, U.username, T.name, T.id FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_torrents T ON T.id = '".$id."' WHERE U.id = ".$auth.";";
												$gr_res = $db->sql_query($gr_sql);
												list ($gr_email, $gr_language, $gr_name, $gr_tname, $gr_tid) = $db->fetch_array($gr_res);
												if (!$gr_language OR !file_exists("language/email/".$gr_language."/authreq.txt")) $lang_email = $language;
												else $lang_email = $gr_language;
                                                $confirm_mail = New eMail;
												$data = $confirm_mail->get_mail_text('authdeny',$lang_email);
												$pass = array(
												'gr_name' => $gr_name,
												'granter' => $user->name,
												'gr_tname' => $gr_tname,
												'gr_tid' => $gr_tid,
												'data'	=> $data);
												$confirm_mail->clean_body($pass);
                                                $confirm_mail->sender = $admin_email;
                                                $confirm_mail->Add($gr_email);
                                                $confirm_mail->subject = sprintf($user->lang['AUTH_EMAIL_SUB'],$sitename);
                                                $notifications->Insert($confirm_mail);
                                                //unset($confirm_mail);
                                        }
                                        break;
                                }
                                case "alwaysgrant": {
                                        //PUT USER INTO WHITE LIST
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_global (master, slave, status) VALUES ('".$user->id."', '".$auth."', 'whitelist');";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_backup SELECT * FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."';" ;
                                                                                $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "SELECT U.email, U.language, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
										$gr_res = $db->sql_query($gr_sql);
										list ($gr_email, $gr_language, $gr_name) = $db->fetch_array($gr_res);
												if (!$gr_language OR !file_exists("language/email/".$gr_language."/authreq.txt")) $lang_email = $language;
												else $lang_email = $gr_language;
                                        $confirm_mail = New eMail;
												$data = $confirm_mail->get_mail_text('authallgrant',$lang_email);
												$pass = array(
												'gr_name' => $gr_name,
												'granter' => $user->name,
												'data'	=> $data);
												$confirm_mail->clean_body($pass);
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($gr_email);
                                        $confirm_mail->subject = sprintf($user->lang['AUTH_EMAIL_SUB'],$sitename);
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;

                                }
                                case "alwaysdeny": {
                                        //PUT USER INTO BLACK LIST
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_global (master, slave, status) VALUES ('".$user->id."', '".$auth."', 'blacklist');";
                                        $db->sql_query($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_backup SELECT * FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."';" ;
                                        $db->sql_query($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql);
                                        $gr_sql = "SELECT U.email, U.language, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
										$gr_res = $db->sql_query($gr_sql);
										list ($gr_email, $gr_language, $gr_name) = $db->fetch_array($gr_res);
												if (!$gr_language OR !file_exists("language/email/".$gr_language."/authreq.txt")) $lang_email = $language;
												else $lang_email = $gr_language;
                                        $confirm_mail = New eMail;
												$data = $confirm_mail->get_mail_text('authalldeny',$lang_email);
												$pass = array(
												'gr_name' => $gr_name,
												'granter' => $user->name,
												'data'	=> $data);
												$confirm_mail->clean_body($pass);
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($gr_email);
                                        $confirm_mail->subject = sprintf($user->lang['AUTH_EMAIL_SUB'],$sitename);
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                        }
                $notifications->Sendmail();
                //unset($notifications);
                }
        }
        case "displaytorrent": {
				$id	= request_var('id', '0');
                if (!is_numeric($id) OR $id < 1)
				{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['ERROR_NOT_NUMBER'],
					));
					echo $template->fetch('message_body.html');
					close_out();
				}
                $checkres = $db->sql_query("SELECT id, private, min_ratio FROM ".$db_prefix."_torrents WHERE id = '".$id."' AND owner = '".$user->id."';");
                if ($db->sql_numrows($checkres) != 1)
				{
					$template->assign_vars(array(
						'S_ERROR'			=> true,
						'S_FORWARD'			=> false,
						'TITTLE_M'			=> $user->lang['BT_ERROR'],
						'MESSAGE'			=> $user->lang['CANT_VIEW_OTHER_AUTH'],
					));
					echo $template->fetch('message_body.html');
					close_out();
				}
                list ($tid, $private, $min_ratio) = $db->fetch_array($checkres);
				//die($tid);
                $db->sql_freeresult($checkres);

                $sql = "SELECT 
							P.*, 
							T.name as torrent, 
							U.id as userid, 
							U.uploaded, 
							U.downloaded, 
							IF(U.name IS NULL, U.username, U.name) as user_name, 
							U.warn_kapta AS warn_kapta, 
							U.warn_hossz AS warn_hossz, 
							U.warned AS warned, 
							U.uploaded/U.downloaded as ratio, 
							U.aim AS aim, 
							U.country AS country, 
							U.icq AS icq, 
							U.msn AS msn, 
							U.yahoo AS yahoo, 
							U.skype AS skype, 
							U.jabber AS jabber, 
							U.accept_mail AS accept_mail, 
							U.ban as ban, 
							U.regdate AS regdate, 
							U.email AS email, 
							U.avatar AS avatar, 
							UNIX_TIMESTAMP(U.lastlogin) AS lststamp, 
							U.lastlogin AS lastlogin, 
							U.lastip AS lastip, 
							U.lasthost AS lasthost, 
							U.level as user_level, 
							U.can_do as can_do, 
							L.group_colour AS color, 
							L.group_name AS co_name, 
							C.name AS lname, 
							C.flagpic AS flagpic 
							FROM 
							".$db_prefix."_privacy_file P 
							LEFT JOIN ".$db_prefix."_users U ON U.id = P.slave 
							LEFT JOIN ".$db_prefix."_torrents T ON P.torrent = T.id 
						LEFT JOIN 
							".$db_prefix."_level_settings L ON L.group_id = U.can_do 
						LEFT JOIN 
							".$db_prefix."_countries C ON C.id = U.country 
							WHERE torrent = '".$id."';";
                $privacyres = $db->sql_query($sql);
                $auth_users = array();
                while ($privacyrow = $db->sql_fetchrow($privacyres))
				{
					$auth_users[] = $privacyrow["userid"];
							if (($privacyrow['accept_mail'] == 'yes') || checkaccess('u_can_view_others_email'))
							{
								$email = $privacyrow["email"];
							}
							else
							{
								$email = false;
							}
							$template->assign_block_vars('users', array(
												'U_ID'							=>	$privacyrow["userid"],
												'U_NAME'						=>	$privacyrow["user_name"],
												'U_BANNED'						=>	(($privacyrow["ban"] == '0') ? false : true),
												'U_LEVEL'						=>	$privacyrow["user_level"],
												'U_GROUP'						=>	$privacyrow["lname"],
												'U_COLOR'						=>	$privacyrow["color"],
												'U_YAHOO'						=>	(!empty($privacyrow["yahoo"])) ? $privacyrow["yahoo"] : false,
												'U_SKYPE'						=>	(!empty($privacyrow["skype"])) ? $privacyrow["skype"] : false,
												'U_MSN'							=>	(!empty($privacyrow["msn"])) ? $privacyrow["msn"] : false,
												'U_AIM'							=>	(!empty($privacyrow["aim"])) ? $privacyrow["aim"] : false,
												'U_ICQ'							=>	(!empty($privacyrow["icq"])) ? $privacyrow["icq"] : false,
												'U_JABBER'						=>	(!empty($privacyrow["jabber"])) ? $privacyrow["jabber"] : false,
												'U_REG'							=>	formatTimeStamp($privacyrow["regdate"]),
												'U_LAST_SEEN'					=>	formatTimeStamp($privacyrow["lastlogin"]),
												'U_IP'							=>  (checkaccess('a_see_ip'))? '<a href="javascript:popUp(\'whois.php?ip='.$privacyrow['lastip'].'\')">'.long2ip($privacyrow['lastip']).'</a>' : false,
												'U_HOST'						=>  (checkaccess('a_see_ip'))? $privacyrow['lasthost'] : false,
												'U_EMAIL'						=>	$email,
												'U_FROM'						=>	$privacyrow["co_name"],
												'U_FLAG'						=>	$privacyrow["flagpic"],
												'U_WARREND'						=>	($privacyrow["warned"]) ? true : false,
												'U_AVATAR'						=>	gen_avatar($privacyrow["u_id"]),
												'U_UPL'							=>	mksize($privacyrow["uploaded"]),
												'U_DL'							=>	mksize($privacyrow["downloaded"]),
												'U_RATIO'						=>	$privacyrow["ratio"],
												'U_RATIO_COLOR'					=>	get_u_ratio($privacyrow["uploaded"], $privacyrow["downloaded"]),
												'U_AUTH_STAT'					=>	$privacyrow["status"],
									   ));
				}


					$template->assign_vars(array(
							'AUTH_USERS'            =>	implode(",",$auth_users),
							'AUTH_TID'				=>	$id,
							'ACTION'            	=>	$op,
							'AUTH_PRIVATE'			=>	(($private == "true")? true : false),
							'AUTH_RATIO'			=>	$min_ratio,
					));
				echo $template->fetch('mytorrents.html');
					close_out();
                $db->sql_freeresult($privacyres);
                break;
        }
        case "saveglobals": {
                $notifications = new MailingList();
				$auth_users	= request_var('auth_users', '');
                $auth_users = explode(",",$auth_users);
                foreach ($auth_users as $auth) {
                        if ($auth != intval($auth))
						{
							$template->assign_vars(array(
								'S_ERROR'			=> true,
								'S_FORWARD'			=> false,
								'TITTLE_M'			=> $user->lang['MY_TORRENTS'],
								'MESSAGE'			=> $user->lang['ERROR_ENTERING_DATA'],
							));
							echo $template->fetch('message_body.html');
							close_out();
						}
                        $auth = intval($auth);
                        $uservar = "user".$auth;
                        switch ($$uservar) {
                                case "alwaysgrant": {
                                        $sql = "UPDATE ".$db_prefix."_privacy_global SET status = 'whitelist' WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $gr_sql = "SELECT U.email, U.language, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
										$gr_res = $db->sql_query($gr_sql);
										list ($gr_email, $gr_language, $gr_name) = $db->fetch_array($gr_res);
												if (!$gr_language OR !file_exists("language/email/".$gr_language."/authreq.txt")) $lang_email = $language;
												else $lang_email = $gr_language;
                                        $confirm_mail = New eMail;
												$data = $confirm_mail->get_mail_text('authallgrant',$lang_email);
												$pass = array(
												'gr_name' => $gr_name,
												'granter' => $user->name,
												'data'	=> $data);
												$confirm_mail->clean_body($pass);
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($gr_email);
                                        $confirm_mail->subject = sprintf($user->lang['AUTH_EMAIL_SUB'],$sitename);
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                                case "alwaysdeny": {
                                        $sql = "UPDATE ".$db_prefix."_privacy_global SET status = 'blacklist' WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlterror($sql);
                                        $gr_sql = "SELECT U.email, U.language, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
										$gr_res = $db->sql_query($gr_sql);
										list ($gr_email, $gr_language, $gr_name) = $db->fetch_array($gr_res);
												if (!$gr_language OR !file_exists("language/email/".$gr_language."/authreq.txt")) $lang_email = $language;
												else $lang_email = $gr_language;
                                        $confirm_mail = New eMail;
 												$data = $confirm_mail->get_mail_text('authalldeny',$lang_email);
												$pass = array(
												'gr_name' => $gr_name,
												'granter' => $user->name,
												'data'	=> $data);
												$confirm_mail->clean_body($pass);
                                       $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($gr_email);
                                        $confirm_mail->subject = sprintf($user->lang['AUTH_EMAIL_SUB'],$sitename);
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                                case "reset": {
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "INSERT INTO ".$db_prefix."_privacy_file SELECT * FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$user->id."' AND slave = '".$auth."';";
                                        $db->sql_query($sql) or btsqlerror($sql);
                                        $sql = "SELECT U.email, U.language, U.username FROM ".$db_prefix."_users U WHERE U.id = ".$auth.";";
										$gr_res = $db->sql_query($gr_sql);
										list ($gr_email, $gr_language, $gr_name) = $db->fetch_array($gr_res);
                                        $confirm_mail = New eMail;
 												$data = $confirm_mail->get_mail_text('authreset',$lang_email);
												$pass = array(
												'gr_name' => $gr_name,
												'granter' => $user->name,
												'data'	=> $data);
												$confirm_mail->clean_body($pass);
                                        $confirm_mail->sender = $admin_email;
                                        $confirm_mail->Add($row["email"]);
                                        $confirm_mail->subject = sprintf($user->lang['AUTH_EMAIL_SUB'],$sitename);
                                        $notifications->Insert($confirm_mail);
                                        //unset($confirm_mail);
                                        break;
                                }
                        }
                }
                $notifications->Sendmail();
        }
        default: {
                #My Torrents
                if (!isset($page) OR !is_numeric($page) OR $page < 1) $page = 1;
                $auth_users = array();
                $from = ($page - 1) * $torrent_per_page;

                $totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_torrents WHERE ".$db_prefix."_torrents.owner = '".$user->id."';";
                $totres = $db->sql_query($totsql) or btsqlerror($totsql);
                list ($tot) = $db->fetch_array($totres);
                $db->sql_freeresult($totres);
                $pages = ceil($tot / $torrent_per_page);
				$sql = "SELECT 
							".$db_prefix."_torrents.*, 
							IF(".$db_prefix."_torrents.numratings < '".$minvotes."', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, 
							".$db_prefix."_categories.name AS cat_name, 
							".$db_prefix."_categories.image AS cat_pic, 
							U.username, 
							IF(U.name IS NULL, U.username, U.name) as user_name, 
							U.level as user_level, 
							U.can_do as can_do, 
							L.group_colour AS color, 
							L.group_name AS lname 
						FROM 
							".$db_prefix."_torrents 
						LEFT JOIN 
							".$db_prefix."_categories ON category = ".$db_prefix."_categories.id 
						LEFT JOIN 
							".$db_prefix."_users U ON ".$db_prefix."_torrents.owner = U.id 
						LEFT JOIN 
							".$db_prefix."_level_settings L ON L.group_id = U.can_do 
						WHERE 
							".$db_prefix."_torrents.owner = '".$user->id."' 
						GROUP BY 
							".$db_prefix."_torrents.id 
						ORDER BY 
							".$db_prefix."_torrents.added DESC 
						LIMIT 
							".$from.",".$torrent_per_page.";";
                $myres = $db->sql_query($sql);
                if (!$myres) btsqlerror($sql);
                if ($db->sql_numrows($myres) < 1) {
					$template->assign_vars(array(
							'S_TORRENTS'            => false,
					));
                } else {
					$template->assign_vars(array(
							'S_TORRENTS'            => true,
					));
	                get_tor_vars($myres);
                	generate_torrentpager('mytorrents.php?page=', $page, $pages);
                }
                $db->sql_freeresult($myres);

                #My Global Authorizations
                if ($torrent_global_privacy) {
                        $sql = "SELECT 
									A.slave, 
									A.status, 
									B.id as u_id,
									B.uploaded, 
									B.downloaded, 
									IF(B.name IS NULL, B.username, B.name) as user_name, 
									B.warn_kapta AS warn_kapta, 
									B.warn_hossz AS warn_hossz, 
									B.warned AS warned, 
									B.uploaded/B.downloaded as ratio, 
									B.aim AS aim, 
									B.country AS country, 
									B.icq AS icq, 
									B.msn AS msn, 
									B.yahoo AS yahoo, 
									B.skype AS skype, 
									B.jabber AS jabber, 
									B.accept_mail AS accept_mail, 
									B.ban as ban, 
									B.regdate AS regdate, 
									B.email AS email, 
									B.avatar AS avatar, 
									UNIX_TIMESTAMP(B.lastlogin) AS lststamp, 
									B.lastlogin AS lastlogin, 
									B.lastip AS lastip, 
									B.lasthost AS lasthost, 
									B.level as user_level, 
									B.can_do as can_do, 
									L.group_colour AS color, 
									L.group_name AS co_name, 
									C.name AS lname, 
									C.flagpic AS flagpic 
								FROM 
									".$db_prefix."_privacy_global A 
								LEFT JOIN 
									".$db_prefix."_users B ON B.id = A.slave 
								LEFT JOIN 
									".$db_prefix."_level_settings L ON L.group_id = B.can_do 
								LEFT JOIN 
									".$db_prefix."_countries C ON C.id = B.country 
								WHERE 
									A.master = '".$user->id."';";
                        $myres = $db->sql_query($sql);
                        if (!$myres) btsqlerror($sql);
                        if ($db->sql_numrows($myres) > 0)
						{
                                while ($myauth = $db->sql_fetchrow($myres)) {
                                        $auth_users[] = $myauth["slave"];
							if (($myauth['accept_mail'] == 'yes') || checkaccess('u_can_view_others_email'))
							{
								$email = $myauth["email"];
							}
							else
							{
								$email = false;
							}
							$template->assign_block_vars('users', array(
												'U_ID'							=>	$myauth["u_id"],
												'U_NAME'						=>	$myauth["user_name"],
												'U_BANNED'						=>	(($myauth["ban"] == '0') ? false : true),
												'U_LEVEL'						=>	$myauth["user_level"],
												'U_GROUP'						=>	$myauth["lname"],
												'U_COLOR'						=>	$myauth["color"],
												'U_YAHOO'						=>	(!empty($myauth["yahoo"])) ? $myauth["yahoo"] : false,
												'U_SKYPE'						=>	(!empty($myauth["skype"])) ? $myauth["skype"] : false,
												'U_MSN'							=>	(!empty($myauth["msn"])) ? $myauth["msn"] : false,
												'U_AIM'							=>	(!empty($myauth["aim"])) ? $myauth["aim"] : false,
												'U_ICQ'							=>	(!empty($myauth["icq"])) ? $myauth["icq"] : false,
												'U_JABBER'						=>	(!empty($myauth["jabber"])) ? $myauth["jabber"] : false,
												'U_REG'							=>	formatTimeStamp($myauth["regdate"]),
												'U_LAST_SEEN'					=>	formatTimeStamp($myauth["lastlogin"]),
												'U_IP'							=>  (checkaccess('a_see_ip'))? '<a href="javascript:popUp(\'whois.php?ip='.$myauth['lastip'].'\')">'.long2ip($myauth['lastip']).'</a>' : false,
												'U_HOST'						=>  (checkaccess('a_see_ip'))? $myauth['lasthost'] : false,
												'U_EMAIL'						=>	$email,
												'U_FROM'						=>	$myauth["co_name"],
												'U_FLAG'						=>	$myauth["flagpic"],
												'U_WARREND'						=>	($myauth["warned"]) ? true : false,
												'U_AVATAR'						=>	gen_avatar($myauth["u_id"]),
												'U_UPL'							=>	mksize($myauth["uploaded"]),
												'U_DL'							=>	mksize($myauth["downloaded"]),
												'U_RATIO'						=>	$myauth["ratio"],
												'U_RATIO_COLOR'					=>	get_u_ratio($myauth["uploaded"], $myauth["downloaded"]),
												'U_AUTH_STAT'					=>	$myauth["status"],
									   ));
								}
                        }
                        $db->sql_freeresult($myres);
					$template->assign_vars(array(
							'AUTH_USERS'            => implode(",",$auth_users),
					));

        }
echo $template->fetch('mytorrents.html');
	close_out();
	}
}
?>