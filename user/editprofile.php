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
** File editprofile.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** 04-03-2016 added park feature
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
require_once("common.php");
$user->set_lang('profile',$user->ulanguage);
$user->set_lang('ucp',$user->ulanguage);
$template = new Template();
$id												= request_var('id', $user->id);
$mode											= request_var('mode', 'front');
$action											= request_var('action', 'overview');
$take_edit										= (($_POST['preview'])? false : request_var('take_edit', ''));
$admin_mode = false;
if($user->id == 0 OR ($user->id != $userrow["id"] && !$auth->acl_get('a_user'))){
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
                                $template->assign_vars(array(
								        'S_ERROR'			=> true,
										'S_FORWARD'				=> false,
								        'TITTLE_M'			=> $user->lang['GEN_ERROR'],
                                        'MESSAGE'			=> sprintf($user->lang['_NO_ACCESS_TO_PROFILE'],getlevel($user->group)).back_link('./index.php'),
                                ));
							echo $template->fetch('message_body.html');
							close_out();
}
if (isset($id)) {
		if($user->id != $id && (!$auth->acl_get('a_user')) && (is_founder($id) && !$user->user_type==3)){
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['BT_ERROR']);
			  meta_refresh('5',$siteurl."/index.php");
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          =>$user->lang['ACCESS_DENIED'],
                                        'S_ERROR_MESS'            => $user->lang['NO_EDIT_PREV'],
                                ));
             echo $template->fetch('error.html');
			close_out();
	}
	else
	{
                $uid = intval($id);
    }
}
else $uid = $user->id;

if(!$uid == $user->id)
{
$admin_mode = true;
}
if($auth->acl_get('a_user'))
{
	if(is_founder($id) && !$user->user_type==3) $admin_mode = false;
	else
	$admin_mode = true;

}
$template->assign_vars(array(
		'S_MOD_MODE'			=> $admin_mode,
		'PMBT_LINK_BACK'		=> ($admin_mode)? $siteurl.'/user.php?op=editprofile&amp;'.'id=' . $uid . '&amp;' : $siteurl.'/user.php?op=editprofile&amp;',
		'T_TEMPLATE_PATH'		=> $siteurl . "/themes/" . $theme . "/templates",
));
$sql_profile = "SELECT 
					U.* , 
					count(F.post_id)AS forumposts, 
					COUNT(DISTINCT B.topic_id)AS book 
					FROM ".$db_prefix."_users U 
					LEFT JOIN ".$db_prefix."_posts F ON U.id = F.poster_id 
					LEFT JOIN ".$db_prefix."_bookmarks B ON U.id = B.user_id  WHERE U.id ='".$uid."' LIMIT 1;";
$res_profile = $db->sql_query($sql_profile);
$userrow = $db->sql_fetchrow($res_profile);
$db->sql_freeresult($res_profile);
if ($admin_mode) $uname = $userrow["username"];
else $uname = $user->name;
$off_set = tz_select($default = '',$userrow);
$countries = "<option value=0>----</option>\n";
$countries .= cnt_select($countries , $userrow );
set_site_var($userrow["username"]);
$template->assign_vars(array(
        'ACTION'                => (isset($action)) ? $action : '',
        'MODE'                  => $mode,
));
if($take_edit){
        $errors = Array();
        $sqlfields = Array();
        $sqlvalues = Array();
                switch($mode) {
				               case "subscribed":{
						                        include 'include/ucp/edit_subscribed.php';
							                    break;
							                    }
				               case "bookmarks":{
						                        include 'include/ucp/edit_bookmarks.php';
							                    break;
							                    }
				               case "drafts":{
						                      include 'include/ucp/edit_drafts.php';
							                  break;
							                  }
				               case "attachments":{
							                      break;
							                      }
				               case "profile_info":{
							                       include 'include/ucp/edit_profile_info.php';
							                       break;
							                       }
				               case "signature":{
							                     include 'include/ucp/edit_signature.php';
							                     break;
							                     }
				               case "avatar":{
							                 include 'include/ucp/edit_avatar.php';
							                 break;
							                 }
				               case "admin_reg_details":{
							                 include 'include/ucp/edit_admin_reg_details.php';
							                            break;
							                            }
				               case "reg_details":{
							                 include 'include/ucp/edit_reg_details.php';
							                      break;
							                      }
				               case "personal":{
							                   include 'include/ucp/edit_personal.php';
							                   break;
							                   }
				               case "friends":{
							                  include 'include/ucp/edit_friends.php';
							                  break;
							                  }
				               case "foes":{
							               include 'include/ucp/edit_foes.php';
							               break;
							               }
							  }
              }

$user_friends = '';
        $sql = "SELECT B.slave, U.username, IF (U.name IS NULL, U.username, U.name) as name, U.can_do as can_do, U.lastlogin as laslogin, U.Show_online as show_online FROM ".$db_prefix."_private_messages_bookmarks B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$userrow["id"]."' ORDER BY name ASC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($n = $db->sql_numrows($res)) {
							$template->assign_vars(array(
                                        'S_FRIENS'            => true,
                                ));
                for ($i = 1; list($uid2, $username, $user_name, $can_do, $laslogin, $show_online) = $db->fetch_array($res); $i++) {
                        $user_friends .= "<option value=\"" . $uid2 ."\">" . $user_name . "</option>";
						$which = (time() - 300 < sql_timestamp_to_unix_timestamp($laslogin) && ($show_online == 'true' || $user->admin)) ? 'online' : 'offline';
						$template->assign_block_vars("friends_{$which}", array(
							'USER_ID'		=> $uid2,
							'USER_COLOUR'	=> getusercolor($can_do),
							'USERNAME'		=> $username,
							'USERNAME_FULL'	=> $user_name)
						);
				}
			}
$user_foes = '';
        $sql = "SELECT B.slave, U.username, IF (U.name IS NULL, U.username, U.name) as name, U.can_do as can_do, U.lastlogin as laslogin, U.Show_online as show_online FROM ".$db_prefix."_private_messages_blacklist B LEFT JOIN ".$db_prefix."_users U ON B.slave = U.id WHERE B.master = '".$userrow["id"]."' ORDER BY name ASC;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($n = $db->sql_numrows($res)) {
                for ($i = 1; list($uid2, $username, $user_name, $can_do, $laslogin, $show_online) = $db->fetch_array($res); $i++) {
                        $user_foes .= "<option value=\"" . $uid2 ."\">" . $user_name . "</option>";
				}
			}
switch($mode) {
			   case "front":{
       				         include 'include/ucp/ucp_front.php';
						     break;
						     }
			   case "subscribed":{
       				         include 'include/ucp/subscribed.php';
						     break;
						     }
				case "bookmarks":{
						      include 'include/ucp/bookmarks.php';
							  break;
							  }
			   case "drafts":{
       				         include 'include/ucp/drafts.php';
						     break;
						     }
			   case "attachments":{
       				         include 'include/ucp/attachments.php';
						     break;
						     }
			   case "profile_info":{
       				         include 'include/ucp/profile_info.php';
						     break;
						     }
			   case "signature":{
       				         include 'include/ucp/signature.php';
						     break;
						     }
			   case "avatar":{
       				         include 'include/ucp/avatar.php';
						     break;
						     }
			   case "reg_details":{
       				         include 'include/ucp/reg_details.php';
						     break;
						     }
			   case "admin_reg_details":{
							 include 'include/ucp/admin_reg_details.php';
							 break;
							 }
			   case "personal":{
       				         include 'include/ucp/personal.php';
						     break;
						     }
			   case "friends":{
       				         include 'include/ucp/friends.php';
						     break;
						     }
			   case "foes":{
       				         include 'include/ucp/foes.php';
						     break;
						     }
				default:{
				        include 'include/ucp/ucp_front.php';
						break;
					}
			  }
        $db->sql_freeresult($res);
$template->assign_var('S_IN_UCP', true);

$template->assign_vars(array(
		'UCP'				   => $user->lang['USER_CPANNEL'],
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
));
echo $template->fetch('ucp_edit_profile.html');
close_out();
?>