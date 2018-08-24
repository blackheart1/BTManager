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
** File profile.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
require_once("include/torrent_functions.php");
$template = new Template();
$user->set_lang('profile',$user->ulanguage);
$id = intval(request_var('id', 0));
$username = request_var('username', '');
$p1 = request_var('p1', '');
$p2 = request_var('p2', '');
$p3 = request_var('p3', '');
$p4 = request_var('p4', '');
if (!isset($p1) OR !is_numeric($p1) OR $p1 < 1) $p1 = 1;
if (!isset($p2) OR !is_numeric($p2) OR $p2 < 1) $p2 = 1;
if (!isset($p3) OR !is_numeric($p3) OR $p3 < 1) $p3 = 1;
if (!isset($p4) OR !is_numeric($p4) OR $p4 < 1) $p4 = 1;
if (!checkaccess('m_over_ride_password')) $passwhere = " AND T.password IS NULL ";
else $passwhere = "";
if (isset($id) AND $id != 0 AND is_numeric($id)) {
        $sql_profile = "SELECT count(F.post_id)AS forumposts,
		U.id AS id,
		 U.warn_kapta AS warn_kapta, 
		 U.warn_hossz AS warn_hossz, 
		 U.can_shout AS can_shout, 
		 U.username AS username, 
		 U.name AS name, 
		 U.tzoffset AS tzoffset, 
		 U.level AS level, 
		 U.user_type AS user_type, 
		 U.regdate AS regdate, 
		 U.email AS email, 
		 U.avatar AS avatar, 
		 UNIX_TIMESTAMP(U.lastlogin) AS lststamp, 
		 U.lastlogin AS lastlogin, 
		 U.lastip AS lastip, 
		 U.lasthost AS lasthost, 
		 U.uploaded AS uploaded, 
		 U.downloaded AS downloaded, 
		 U.uploaded/U.downloaded as ratio, 
		 U.accept_mail AS accept_mail, 
		 U.active AS active, 
		 U.aim AS aim, 
		 U.icq AS icq, 
		 U.msn AS msn, 
		 U.yahoo AS yahoo, 
		 U.jabber AS jabber, 
		 U.skype AS skype, 
		 U.invited_by AS invited_by, 
		 U.invitees AS invitees, 
		 U.invites AS invites, 
		 U.invitedate AS invitedate, 
		 U.warned AS warned, 
		 U.country AS country, 
		 U.seedbonus AS seedbonus, 
		 U.hitruns AS hitruns, 
		 U.can_do AS can_do, 
		 U.helper AS helper, 
		 U.help_able AS help_able, 
		 U.client as client, 
		 U.signature as signature,
		 U.sig_bbcode_bitfield,
		 U.sig_bbcode_uid, 
		 U.birthday as birthday, 
		 U.ban as ban 
		 FROM ".$db_prefix."_users U 
		 LEFT JOIN 
		 ".$db_prefix."_posts F 
		 ON U.id = F.poster_id 
		 where U.id = '".$id."' LIMIT 1;";
        $sql_owned_torrents = "SELECT T.*, IF(T.numratings < '$minvotes', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic FROM ".$db_prefix."_users U, ".$db_prefix."_torrents T, ".$db_prefix."_categories C WHERE T.category = C.id AND T.owner = U.id AND T.ownertype = 0 AND U.id = '".$id."' ".$passwhere." ORDER BY T.added DESC;";
} elseif (isset($username) AND $username != "") {
        $sql_profile = "SELECT count(F.post_id)AS forumposts,U.id AS id, U.warn_kapta AS warn_kapta, U.warn_hossz AS warn_hossz ,U.can_shout AS can_shout, U.username AS username, U.name AS name, U.tzoffset AS tzoffset, U.level AS level, U.user_type AS user_type, U.regdate AS regdate, U.email AS email, U.avatar AS avatar, UNIX_TIMESTAMP(U.lastlogin) AS lststamp, U.lastlogin AS lastlogin, U.lastip AS lastip, U.lasthost AS lasthost, U.uploaded AS uploaded, U.downloaded AS downloaded, U.uploaded/U.downloaded AS ratio, U.accept_mail AS accept_mail, U.active AS active, U.aim AS aim, U.icq AS icq, U.msn AS msn, U.yahoo AS yahoo, U.skype AS skype, U.jabber AS jabber,U.invited_by AS invited_by, U.invitees AS invitees, U.invites AS invites, U.sig_bbcode_bitfield, U.sig_bbcode_uid, U.invitedate AS invitedate, U.warned AS warned, U.country AS country, U.seedbonus AS seedbonus, U.hitruns AS hitruns, U.can_do AS can_do, U.helper AS helper, U.help_able AS help_able, U.client as client, U.signature as signature, U.birthday as birthday, U.ban as ban FROM ".$db_prefix."_users U 
		LEFT JOIN ".$db_prefix."_posts F ON U.id = F.poster_id where U.username = '".$username."' LIMIT 1;";
        $sql_owned_torrents = "SELECT T.*, IF(T.numratings < '$minvotes', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic FROM ".$db_prefix."_users U, ".$db_prefix."_torrents T, ".$db_prefix."_categories C WHERE T.category = C.id AND T.owner = U.id AND T.ownertype = 0 AND U.username = '".$username."' ".$passwhere." ORDER BY T.added DESC;";
}else{
        $sql_profile = "SELECT count(F.post_id)AS forumposts,U.id AS id, U.warn_kapta AS warn_kapta, U.warn_hossz AS warn_hossz ,U.can_shout AS can_shout, U.username AS username,U.sig_bbcode_bitfield, U.sig_bbcode_uid, U.name AS name, U.tzoffset AS tzoffset, U.level AS level, U.user_type AS user_type, U.regdate AS regdate, U.email AS email, U.avatar AS avatar, UNIX_TIMESTAMP(U.lastlogin) AS lststamp, U.lastlogin AS lastlogin, U.lastip AS lastip, U.lasthost AS lasthost, U.uploaded AS uploaded, U.downloaded AS downloaded, U.uploaded/U.downloaded AS ratio, U.accept_mail AS accept_mail, U.active AS active, U.aim AS aim, U.icq AS icq, U.msn AS msn, U.yahoo AS yahoo, U.skype AS skype, U.jabber AS jabber,U.invited_by AS invited_by, U.invitees AS invitees, U.invites AS invites, U.invitedate AS invitedate, U.warned AS warned, U.country AS country, U.seedbonus AS seedbonus, U.hitruns AS hitruns, U.can_do AS can_do, U.helper AS helper, U.help_able AS help_able, U.client as client, U.signature as signature, U.birthday as birthday, U.ban as ban FROM ".$db_prefix."_users U LEFT JOIN ".$db_prefix."_posts F ON U.id = F.poster_id where U.id = '".$user->id."' LIMIT 1;";
        $sql_owned_torrents = "SELECT T.*, IF(T.numratings < '$minvotes', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, C.name AS cat_name, C.image AS cat_pic FROM ".$db_prefix."_users U, ".$db_prefix."_torrents T, ".$db_prefix."_categories C WHERE T.category = C.id AND T.owner = U.id AND T.ownertype = 0 AND U.id = '".$user->id."' ".$passwhere." ORDER BY T.added DESC;";
}
$res = $db->sql_query($sql_profile) OR btsqlerror($sql_profile);
if ($db->sql_numrows($res) < 1) bterror($user->lang['NO_SUCH_USER'],$user->lang['USER_CPANNEL']);
$userrow = $db->sql_fetchrow($res);
// Country code
$sql = ("SELECT name,flagpic FROM ".$db_prefix."_countries WHERE id='".$userrow['country']."' LIMIT 1");
$res = $db->sql_query($sql) OR btsqlerror($sql);
if ($db->sql_numrows($res) == 1) 
{
  $arr = $db->sql_fetchrow($res);
  $country = $arr['name'];
  $flag = $arr['flagpic'];
}
if($user->id == 0 OR ($user->id != $userrow["id"] && !$auth->acl_get('u_viewprofile'))){
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
if($user->admin AND isset($mode) AND $mode == 'switch_perm'){
setcookie("user_perm_from",$userrow["id"],time() + 31536000,$cookiepath,$cookiedomain,0);
setcookie("bttestperm",$userrow["can_do"],time() + 31536000,$cookiepath,$cookiedomain,0);
setcookie("bttestlevel",$userrow["level"],time() + 31536000,$cookiepath,$cookiedomain,0);
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['INFORMATION']);
                                $template->assign_vars(array(
										'S_SUCCESS'			=> true,
								        'TITTLE_M'          =>$user->lang['INFORMATION'],
                                        'MESSAGE'           => sprintf($user->lang['PERMISSIONS_TRANSFERRED'],$userrow["name"]),
										'S_FORWARD'			=> $siteurl."/user.php?op=profile&id=".$userrow["id"],
                                ));
echo $template->fetch('message_body.html');
close_out();
}
if($_COOKIE["bttestperm"] AND isset($mode) AND $mode == 'return_perm'){
setcookie("bttestperm",'',time() - 31536000,$cookiepath,$cookiedomain,0);
setcookie("bttestlevel",'',time() - 31536000,$cookiepath,$cookiedomain,0);
              set_site_var('- '.$user->lang['USER_CPANNEL'].' - '.$user->lang['INFORMATION']);
                                $template->assign_vars(array(
										'S_SUCCESS'			=> true,
								        'TITTLE_M'          =>$user->lang['INFORMATION'],
                                        'MESSAGE'           => $user->lang['PERMISSIONS_RESTORED'],
										'S_FORWARD'			=> $siteurl."/user.php?op=profile&id=".$userrow["id"],
                                ));
echo $template->fetch('message_body.html');
close_out();
}
set_site_var(sprintf($user->lang['_VIEWING_USER_PROFILE'],$userrow["username"]));
switch ($userrow["level"]) {
        case "banned": {
                $ulevel =  $user->lang['BANNED'];
                break;
        }
        case "user": {
                $ulevel =  $user->lang['USER'];
                break;
        }
        case "moderator": {
                $ulevel =  $user->lang['G_MODERATOR'];
                break;
        }
        case "premium": {
                $ulevel =  $user->lang['G_PREMIUM_USER'];
                break;
        }
        case "admin": {
                $ulevel =  $user->lang['G_ADMINISTRATORS'];
                break;
        }
}
$sqlbook = "SELECT slave FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$user->id."' AND slave = '".$userrow["id"]."';";
$sqlblack = "SELECT slave FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$user->id."' AND slave = '".$userrow["id"]."';";
$resbook = $db->sql_query($sqlbook) or btsqlerror($sqlbook);
$resblack = $db->sql_query($sqlblack) or btsqlerror($sqlblack);
$sqlublack = "SELECT slave FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$userrow["id"]."' AND slave = '".$user->id."';";
$resublack = $db->sql_query($sqlublack) or btsqlerror($sqlublack);
if($userrow["forumposts"] > 0){
$sql="SELECT count(post_id)as num FROM `".$db_prefix."_posts`;";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$post_count = $db->sql_fetchrow($res);
$sql = " SELECT count(`".$db_prefix."_posts`.`topic_id`)as posts, `".$db_prefix."_posts`.`topic_id` as id, forum_id FROM `".$db_prefix."_posts` WHERE `".$db_prefix."_posts`.`poster_id` = '" . $userrow["id"] . "' GROUP BY `".$db_prefix."_posts`.`topic_id` ORDER BY topic_id  ASC LIMIT 1;";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$most_in = $db->sql_fetchrow($res);
$sql = "SELECT `topic_title`, `forum_id` FROM `".$db_prefix."_topics` WHERE `topic_id` = '" . $most_in['id'] . "';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$active_t_name = $db->sql_fetchrow($res);
$sql = "SELECT `forum_name`, `forum_id` FROM `".$db_prefix."_forums` WHERE `forum_id` = '" . $active_t_name['forum_id'] . "';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$active_f_name = $db->sql_fetchrow($res);
$t_post_in = array();
$sql = "SELECT `topic_id` FROM `".$db_prefix."_topics` WHERE `forum_id` = '" . $active_f_name['forum_id'] . "';";
$res = $db->sql_query($sql) OR btsqlerror($sql);
while($row = $db->sql_fetchrow($res)){
$t_post_in[] = $row['topic_id'];
}
$sql = " SELECT count(`".$db_prefix."_posts`.`post_id`)as posts FROM `".$db_prefix."_posts` WHERE `".$db_prefix."_posts`.`topic_id` IN ('".implode("', '",$t_post_in)."') AND `".$db_prefix."_posts`.`poster_id` = " . $userrow["id"] . ";";
$res = $db->sql_query($sql) OR btsqlerror($sql);
$most_in_f = $db->sql_fetchrow($res);
}
$sql = 'SELECT count( `tid` ) AS thanks
FROM `'.$db_prefix.'_thanks`
WHERE `uid` =\''.$userrow["id"].'\';';
$res = $db->sql_query($sql) OR btsqlerror($sql);
$thanks = $db->sql_fetchrow($res);
$sql = 'SELECT count( `id` ) AS tcoments
FROM `'.$db_prefix.'_comments`
WHERE `user` =\''.$userrow["id"].'\';';
$res = $db->sql_query($sql) OR btsqlerror($sql);
$tcoments = $db->sql_fetchrow($res);
		$memberdays = max(1, round((time() - sql_timestamp_to_unix_timestamp($userrow["regdate"])) / 86400));
		$posts_per_day = $userrow["forumposts"] / $memberdays;
		$percentage = ($post_count['num']) ? min(100, ($userrow["forumposts"] / $post_count['num']) * 100) : 0;
$dt1 = strtotime(gmdate("Y-m-d H:i:s", time())) - 600;
$dt = date("Y-m-d H:i:s", $dt1);
$online = ((time() - $userrow['lststamp']) < 600 ?  'on' : 'off');
				include_once('include/function_posting.' . $phpEx);
				include_once('include/class.bbcode.php');
				$signature = censor_text($userrow["signature"]);
				if ($userrow['sig_bbcode_bitfield'])
				{
					include_once('include/bbcode.' . $phpEx);
					$bbcode = new bbcode($userrow['sig_bbcode_bitfield']);
					$bbcode->bbcode_second_pass($signature, $userrow['sig_bbcode_uid'], $userrow['sig_bbcode_bitfield']);
				}
//$signature = format_comment($userrow["signature"]);
//parse_smiles($signature);
	if ($userrow['accept_mail'] == 'yes' || $auth->acl_get('a_override_email_block'))
	{
		$email = pic("icon_mail.gif","mailto:".$userrow["email"]);
	}
	else
	{
		$email = '';
	}
	$user_owner = (!is_founder($id)? true : ($user->user_type==3)? true : false);
$l_active_pct = ($user->user && $userrow["id"] == $user->id) ? '%.2f%% of your posts' : '%.2f%% of user\'s posts';
$active_t_pct = ($userrow["forumposts"]) ? ($most_in['posts'] / $userrow["forumposts"]) * 100 : 0;
$active_f_pct = ($userrow["forumposts"]) ? ($most_in_f['posts'] / $userrow["forumposts"]) * 100 : 0;
$now = getdate(time() - date('Z'));
$template->assign_vars(array(
        'CP_UNAME'              => $userrow["username"],
        'CP_UID'                => $userrow["id"],
        'CP_UUPLOADED'          => mksize($userrow["uploaded"]),
        'CP_UDOWNLOADED'        => mksize($userrow["downloaded"]),
		'CP_EDIT_USER'			=> ($user->id == $userrow["id"]) ? true : ($userrow["user_type"] == 3 && !$user->user_type == 3)? false : checkaccess('m_edit_user'),
        'CP_URATIO'             => get_u_ratio($userrow["uploaded"], $userrow["downloaded"]),
        'CP_UCOLOR'             => getusercolor($userrow["can_do"]),
        'CP_UAVATAR'            => gen_avatar($userrow["id"]),
        'CP_UCANSHOUT'          => ($userrow["can_shout"] == 'true') ? true : false,
        'CP_UWARNED'            => ($userrow["warned"]) ? true : false,
        'CP_UWARNEDTELL'        => gmdate("Y-m-d H:i:s",($userrow["warn_kapta"]+$userrow["warn_hossz"])),
        'CP_UNICK'              => (!empty($userrow["name"]))? $userrow["name"]: false,
        'CP_ULEVEL'             => $ulevel,
		'UPERMSET'              => (isset($_COOKIE["bttestperm"])) ? 'return_perm' : 'switch_perm',
        'CP_UCAN_DO'            => $userrow["can_do"],
		'CP_WARN_USE'			=> (($user->id != $userrow["id"]) AND $auth->acl_get('m_warn')),
        'CP_UGROUP'             => getlevel($userrow["can_do"]),
        'CP_UREGDATE'           => formatTimeStamp($userrow["regdate"]),
        'CP_ULASTSEEN'          => formatTimeStamp($userrow["lastlogin"]),
        'CP_ONLINE'             => $online,
		'CP_POST_COUNT'         => $userrow["forumposts"],
		'POSTS_DAY'             => sprintf($user->lang['POST_DAY'], $posts_per_day),
		'POSTS_PCT'             => sprintf($user->lang['POST_PCT'], $percentage),
		'ACTIVE_FORUM'			=> $active_f_name['forum_name'],
		'ACTIVE_FORUM_POSTS'	=> ($active_f_count == 1) ? sprintf($user->lang['USER_POST'], 1) : sprintf($user->lang['USER_POSTS'], $most_in_f['posts']),
		'ACTIVE_FORUM_PCT'		=> sprintf($l_active_pct, $active_f_pct),
		'ACTIVE_TOPIC'			=> $active_t_name['topic_title'],
		'ACTIVE_TOPIC_POSTS'	=> ($most_in['posts'] == 1) ? sprintf($user->lang['USER_POST'], 1) : sprintf($user->lang['USER_POSTS'], $most_in['posts']),
		'ACTIVE_TOPIC_PCT'		=> sprintf($l_active_pct, $active_t_pct),
		'U_ACTIVE_FORUM'		=> './forum.php?action=viewforum&f='.$active_t_name['forum_id'],
		'U_ACTIVE_TOPIC'		=> './forum.php?action=viewtopic&f='.$most_in['forum_id'] . '&t=' . $most_in['id'],
		'S_GROUP_OPTIONS'	    => selectaccess($userrow["can_do"]),
		'S_SHOW_ACTIVITY'		=> true,
		'SIGNATURE'             => $signature,
		'U_ADD_FRIEND'		    => ($userrow["id"] != $user->id) ? ((!$db->sql_numrows($resbook)) ? "pm.php?op=bookmark&id=".$userrow["id"] : '') : '',
		'U_ADD_FOE'			    => (!$db->sql_numrows($resblack)) ? "pm.php?op=blacklist&id=".$userrow["id"] : '',
		'U_REMOVE_FRIEND'	    => ($db->sql_numrows($resbook)) ? "pm.php?op=removebookmark&id=".$userrow["id"] : '',
		'U_REMOVE_FOE'		    => ($db->sql_numrows($resblack)) ? "pm.php?op=removeblacklist&id=".$userrow["id"] : '',
		'LOCATION'		        => (!$userrow["country"] == 0) ? "<img src=\"images/flag/".$flag."\" alt=\"$country\">" : '',
		'U_EMAIL'		        => $email,
		'T_THANKS'		        => $thanks['thanks'],
		'T_COMMENTS'	        => $tcoments['tcoments'],
		'U_IP'                  =>  ($auth->acl_get('m_info'))? '<a href="javascript:popUp(\'whois.php?ip='.$userrow['lastip'].'\')">'.long2ip($userrow['lastip']).'</a>' : '',
		'U_IP_HOST'             =>  ($auth->acl_get('m_info'))? $userrow['lasthost'] : '',
		'U_PM'				    => (!$db->sql_numrows($resublack)) ? pic("pm_write.png","pm.php?op=send&to=".$userrow["id"],$user->lang['NEW_PM']) : '',
		'U_ICQ'				    => (!empty($userrow["icq"])) ? pic("button_icq.gif","http://www.icq.com/whitepages/wwp.php?to=".$userrow["icq"]) : '',
		'U_AIM'				    => (!empty($userrow["aim"])) ? pic("button_aim.gif","aim:goim?screenname=".$userrow["aim"]).$userrow["aim"] : '',
		'U_YIM'				    => (!empty($userrow["yahoo"])) ? pic("button_yahoo.gif","http://edit.yahoo.com/config/send_webmesg?.target=".$userrow["yahoo"]) : '',
		'U_MSN'				    => (!empty($userrow["msn"])) ? pic("button_msn.gif","http://members.msn.com/".$userrow["msn"]) : '',
		'U_JABBER'			    => (!empty($userrow["jabber"])) ? pic("button_jabber.gif",null,$userrow["jabber"]) : '',
		'U_SKYPE'			    => (!empty($userrow["skype"])) ? pic("button_yahoo.gif","http://edit.yahoo.com/config/send_webmesg?.target=".$userrow["yahoo"]) : '',
		'AGE'				    => ($age = (int) substr($userrow['birthday'], -4)) ? ($now['year'] - $age) : '',
		'RANK_IMG'              => '<img src="themes/' . $theme . '/pics/group/' . $userrow["can_do"] . '.png" title="' . $userrow["can_do"] . '" alt="' . $userrow["can_do"] . '">',
		'U_BAN_USER'            => (($userrow["id"] != $user->id) AND $user_owner AND $auth->acl_get('a_ban'))? (($userrow["ban"] == '0') ? '<a href="admin.php?op=addban&amp;u=' . $userrow["id"] . '">' . $user->lang['UCP_BAN_USER'] .  '</a>' : '<a href="admin.php?op=delban&amp;uid=' . $userrow["id"] . '">' . $user->lang['UCP_UNBAN_USER'] .  '</a>') :'',
		'U_BAN_SHOUTS'          => (($userrow["id"] != $user->id) AND $user_owner AND checkaccess('m_bann_shouts'))? (($userrow["can_shout"] == 'true') ? '<a href="user.php?op=banchat&amp;id=' . $userrow["id"] . '">' . $user->lang['UCP_SHOUT_BAN'] . '</a>' : '<a href="user.php?op=unbanchat&amp;id=' . $userrow["id"] . '">' . $user->lang['UCP_UNSHOUT_BAN'] . '</a>') : '',
		));
$template->assign_vars(array(
        'S_GENTIME'            => abs(round(microtime()-$startpagetime,2)),
));
if (!$user->moderator) $ownertype = "AND ownertype = 0";
else $ownertype = "";

$from = ($p1 - 1) * $torrent_per_page;

$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_torrents WHERE banned = 'no' AND owner = '".$userrow["id"]."' ".$ownertype.";";
$totres = $db->sql_query($totsql);
list ($tot) = $db->fetch_array($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / $torrent_per_page);
$sql = "SELECT 
			".$db_prefix."_torrents.*, 
			IF(".$db_prefix."_torrents.numratings < '$minvotes', NULL, ROUND(".$db_prefix."_torrents.ratingsum / ".$db_prefix."_torrents.numratings, 1)) AS rating, 
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
			banned = 'no' 
			AND 
			owner = '".$userrow["id"]."' ".$ownertype." 
		ORDER BY 
			".$db_prefix."_torrents.added 
		DESC LIMIT ".$from.",".$torrent_per_page.";";
$res = $db->sql_query($sql);
if ($db->sql_numrows($res) < 1) {
                $template->assign_vars(array(
                        'S_TORRENTSMYU'            => false,
                ));
} else {
generate_torrentpager('user.php?op=profile&amp;id='.$userrow["id"] .'&amp;p1=', $p1, $pages, $cat = false, '', '', $extra = 'MYU');
                $template->assign_vars(array(
                        'S_TORRENTSMYU'            => true,
                ));
        get_tor_vars($res, "",  "", "", 'myu');
}
$db->sql_freeresult($res);
unset($res, $row, $sql);
$from = ($p2 - 1) * $torrent_per_page;

$totsql = "SELECT COUNT(DISTINCT torrent) AS tot FROM ".$db_prefix."_peers WHERE uid = '".$userrow["id"]."' AND seeder = 'yes';";
$totres = $db->sql_query($totsql) or btsqlerror($totsql);
list ($tot) = $db->fetch_array($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / $torrent_per_page);
$sql = "SELECT 
			P.uid, 
			T.*, 
			IF(T.numratings < '".$minvotes."', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, 
			C.name AS cat_name, 
			C.image AS cat_pic, 
			U.username, 
			IF(U.name IS NULL, U.username, U.name) as user_name, 
			U.level as user_level, 
			U.can_do as can_do, 
			L.group_colour AS color, 
			L.group_name AS lname  
		FROM 
			".$db_prefix."_peers P 
		LEFT JOIN 
			".$db_prefix."_torrents T ON P.torrent = T.id 
		LEFT JOIN 
			".$db_prefix."_categories C ON category = C.id 
		LEFT JOIN 
			".$db_prefix."_users U ON P.uid = U.id 
		LEFT JOIN 
			".$db_prefix."_level_settings L ON L.group_id = U.can_do 
		WHERE 
			banned = 'no' 
			AND 
			P.uid = '".$userrow["id"]."' 
			AND 
			P.seeder = 'yes' 
		ORDER BY 
			T.added 
		DESC LIMIT 
			".$from.",".$torrent_per_page.";";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) < 1) {
                $template->assign_vars(array(
                        'S_TORRENTSMYS'            => false,
                ));
} else {
generate_torrentpager('user.php?op=profile&amp;id='.$userrow["id"] .'&amp;p2=', $p2, $pages, $cat = false, '', '', $extra = 'MYS');
                $template->assign_vars(array(
                        'S_TORRENTSMYS'            => true,
                ));
        get_tor_vars($res, "",  "", "", 'mys');
}
$db->sql_freeresult($res);
unset($res);
$from = ($p3 - 1) * $torrent_per_page;

$totsql = "SELECT COUNT(DISTINCT torrent) AS tot FROM ".$db_prefix."_peers WHERE uid = '".$userrow["id"]."' AND seeder = 'no';";
$totres = $db->sql_query($totsql) or btsqlerror($totsql);
list ($tot) = $db->fetch_array($totres);
$db->sql_freeresult($totres);

$pages = ceil($tot / $torrent_per_page);
$sql = "SELECT 
			P.uid, 
			T.*, 
			IF(T.numratings < '".$minvotes."', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating, 
			C.name AS cat_name, 
			C.image AS cat_pic, 
			U.username, 
			IF(U.name IS NULL, U.username, U.name) as user_name, 
			U.level as user_level, 
			U.can_do as can_do, 
			L.group_colour AS color, 
			L.group_name AS lname  
		FROM 
			".$db_prefix."_peers P 
		LEFT JOIN 
			".$db_prefix."_torrents T ON P.torrent = T.id 
		LEFT JOIN 
			".$db_prefix."_categories C ON category = C.id 
		LEFT JOIN 
			".$db_prefix."_users U ON P.uid = U.id 
		LEFT JOIN 
			".$db_prefix."_level_settings L ON L.group_id = U.can_do 
		WHERE 
			banned = 'no' 
		AND 
			P.uid = '".$userrow["id"]."' 
		AND 
			P.seeder = 'no' 
		ORDER BY 
			T.added 
		DESC LIMIT 
			".$from.",".$torrent_per_page.";";
$res = $db->sql_query($sql) or btsqlerror($sql);
if ($db->sql_numrows($res) < 1) {
                $template->assign_vars(array(
                        'S_TORRENTSMYL'            => false,
                ));
} else {
generate_torrentpager('user.php?op=profile&amp;id='.$userrow["id"] .'&amp;p3=', $p3, $pages, $cat = false, '', '', $extra = 'MYL');
                $template->assign_vars(array(
                        'S_TORRENTSMYL'            => true,
                ));
        get_tor_vars($res, "",  "", "", 'myl');
}
$db->sql_freeresult($res);
unset($res);
$totsql = "SELECT COUNT(DISTINCT P.torrent) AS tot 
FROM ".$db_prefix."_snatched P, 
".$db_prefix."_torrents T  
WHERE 
P.userid = '".$userrow["id"]."'
AND T.id = P.torrent
AND T.banned = 'no';";
$totres = $db->sql_query($totsql) or btsqlerror($totsql);
list ($tot) = $db->fetch_array($totres);
if ($tot > 0)
{
                $template->assign_vars(array(
                        'S_TORRENTSMYSN'            => true,
                ));
$pages = ceil($tot / $torrent_per_page);
generate_torrentpager('user.php?op=profile&amp;id='.$userrow["id"] .'&amp;p4=', $p4, $pages, $cat = false, '', '', $extra = 'MYSN');
$sql = "SELECT 
			P.userid, 
			T.*, 
			IF(T.numratings < '".$minvotes."', NULL, ROUND(T.ratingsum / T.numratings, 1)) AS rating,
			C.name AS cat_name, C.image AS cat_pic,
			U.username,
			IF(U.name IS NULL, U.username, U.name) as user_name, 
			U.level as user_level, 
			U.can_do as can_do, 
			L.group_colour AS color, 
			L.group_name AS lname   
		FROM 
			".$db_prefix."_snatched P 
		LEFT JOIN 
			".$db_prefix."_torrents T ON P.torrent = T.id 
		LEFT JOIN 
			".$db_prefix."_categories C ON category = C.id 
		LEFT JOIN 
			".$db_prefix."_users U ON P.userid = U.id 
		LEFT JOIN 
			".$db_prefix."_level_settings L ON L.group_id = U.can_do 
		WHERE 
			banned = 'no' 
		AND 
			P.userid = '".$userrow["id"]."' 
		ORDER BY 
			T.added DESC 
			LIMIT 
			".$from.",".$torrent_per_page.";";
$res = $db->sql_query($sql) or btsqlerror($sql);
        get_tor_vars($res, "",  "", "", 'mysn');
}
else
{
                $template->assign_vars(array(
                        'S_TORRENTSMYSN'            => false,
                ));
}
$db->sql_freeresult($totres);
echo $template->fetch('ucp_profile.html');
close_out();
?>