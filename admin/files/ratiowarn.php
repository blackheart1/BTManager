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
** File ratiowarn.php 2018-02-23 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ("You can't access this file directly");
}
$user->set_lang('admin/acp_ratio',$user->ulanguage);
if(!checkaccess('a_warn_sys'))
{
				add_log('admin','LOG_ACL_ACCESS_NOTALLOW',$user->lang['TITLE_INDEX']);
                                $template->assign_vars(array(
								        'S_USER_NOTICE'			=> true,
										'S_FORWARD'				=> false,
								        'MESSAGE_TITLE'			=> $user->lang['GEN_ERROR'],
                                        'MESSAGE_TEXT'			=> sprintf($user->lang['DENIACC'],$user->lang['TITLE_INDEX']),
                                ));
				echo $template->fetch('admin/message_body.html');
				close_out();
}
		$do			= request_var('do', 'index');
		$action		= request_var('action', '');
							$template->assign_block_vars('l_block1.l_block2',array(
							'L_TITLE'		=> $user->lang['BLOCK_TITLE'],
							'S_SELECTED'	=> true,
							'U_TITLE'		=> $u_action,));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('config' ==$do)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['SECTION_TITLE_CONFIG'],
							'U_TITLE' => append_sid($u_action,'do=config'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('warned' ==$do)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['SECTION_TITLE_WARNED'],
							'U_TITLE' => append_sid($u_action,'do=warned'),
							));
							$template->assign_block_vars('l_block1.l_block2.l_block3',array(
							'S_SELECTED'	=> ('watched' ==$do)? true:false,
							'IMG' => '',
							'L_TITLE' => $user->lang['SECTION_TITLE_WATCHED'],
							'U_TITLE' => append_sid($u_action,'do=watched'),
							));
		switch ($do)
		{
			case 'config':
				if($action == 'take_con')
				{
					$new_con = array();
					$enable				= request_var('sub_enable', 'false');
					$ratio_mini			= request_var('sub_ratio_mini', '0.0');
					$ratio_warn			= request_var('sub_ratio_warn', '0');
					$ratio_ban			= request_var('sub_ratio_ban', '0');
					$new_con['enable'] = $enable;
					$new_con['ratio_mini'] = $ratio_mini;
					$new_con['ratio_warn'] = $ratio_warn;
					$new_con['ratio_ban'] = $ratio_ban;
					foreach($new_con as $set=>$val)
					{
						$sql = "UPDATE ".$db_prefix."_ratiowarn_config SET value = '$val' WHERE name = '$set' LIMIT 1";
						$db->sql_query($sql)or btsqlerror($sql);
					}
				}
						$hidden = build_hidden_fields(array(
							'do'		=> 'config',
							'action'	=> 'take_con',
						));
                                $template->assign_vars(array(
									'U_ACTION' => $u_action,
									'S_FORM_TOKEN' => $hidden,
								));
				$cfgrow = array();
    			$resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn_config");
				while ($arr = $db->sql_fetchrow($resrws))$cfgrow[$arr['name']] = $arr['value'];
				drawRow("enable","text", false ,$user->lang['TITLE_CONFIG']);
				drawRow("enable","select",$user->lang['SEL_YES_NO']);
				drawRow("ratio_mini","text");
				drawRow("ratio_warn","text");
				drawRow("ratio_ban","text");
			break;
			case 'warned':
				require_once("include/user.functions.php");
						$resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn_config");
						while ($arr = $db->sql_fetchrow($resrws))$arr_config[$arr['name']] = $arr['value'];
				$resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn WHERE warned='yes'");
				$reqrws = $db->sql_fetchrow($resrws);
				$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_ratiowarn WHERE warned='yes'";
				$totres = $db->sql_query($totsql)or btsqlerror($totsql);
				list ($tot) = $db->fetch_array($totres);
				$db->sql_freeresult($totres);
				$pages = ceil($tot / $torrent_per_page);
				$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;
				$res_rws = $db->sql_query("SELECT *, TO_DAYS(NOW()) - TO_DAYS(warntime) as difference FROM ".$db_prefix."_ratiowarn WHERE warned='yes' LIMIT ".$start.",".$torrent_per_page.";");
				$num = $db->sql_numrows($res_rws);
				if($num > 0)
				{
					$template->assign_vars(array(
					'S_WARNED'			=> true,
					));
					for ($i = 0; $i < $num; ++$i)
					{
						$arr = $db->sql_fetchrow($res_rws);
						$uinfo = build_user_array($arr['userid']);
						$banned = $arr['banned'];
				
						if($banned == 'no'){
							$timeleft = ($arr['difference'] - $RATIOWARN_BAN)/-1;
						}else{
							$timeleft = "null";
						}
							$template->assign_block_vars('user', array(
								'USER_ID'				=> $arr['userid'],
								'USER_NAME'				=> $uinfo['name'],
								'USER_NICK'				=> $uinfo['nick'],
								'USER_GROUP'			=> $uinfo['lname'],
								'USER_LEVEL'			=> $uinfo['level'],
								'USER_REG_DATE'			=> $uinfo['reg'],
								'USER_EMAIL'			=> $uinfo['email'],
								'USER_COLOR'			=> $uinfo['color'],
								'USER_UPED'				=> mksize($uinfo['uploaded']),
								'USER_DOWNED'			=> mksize($uinfo['downloaded']),
								'USER_RATIO'			=> $uinfo['ratio'],
								'USER_RATIO_COLORED'	=> get_u_ratio($uinfo['uploaded'], $uinfo['downloaded']),
								'TIME_LEFT'				=> sprintf($user->lang['TO_GO'],$timeleft),
								'USER_ACTION'			=> $timeleft,
								'WARNED'				=> (($arr['userid'] == 'yes')?$user->lang['YES']:$user->lang['NO']),
								'BANNED'				=> (($arr['banned'] == 'yes')?$user->lang['YES']:$user->lang['NO']),
							));
					}
					$template->assign_vars(array(
					'S_ON_PAGE'		=> on_page($num, $torrent_per_page, $start),
					'PAGINATION'	=> generate_pagination(append_sid($u_action,'do=warned'), $tot, $torrent_per_page, $start, true),
					'U_ACTION'		=> $u_action,
					));
				}
			break;
			case 'watched':
				require_once("include/user.functions.php");
						$resrws = $db->sql_query("SELECT * FROM ".$db_prefix."_ratiowarn_config");
						while ($arr = $db->sql_fetchrow($resrws))$arr_config[$arr['name']] = $arr['value'];
				if($action == 'edit')
				{
				$id		= request_var('id', '');
                                $template->assign_vars(array(
								        'S_USER_NOTICE'			=> true,
										'S_FORWARD'				=> false,
								        'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
                                        'MESSAGE_TEXT'			=> sprintf($user->lang['USER_STST_UPDATE'],username_is($id)).back_link(append_sid($u_action,'do=warned')),
                                ));
				$do="DELETE FROM ".$db_prefix."_ratiowarn WHERE userid =" . $id . " LIMIT 1" ;
				$db->sql_query($do)or btsqlerror($do);
				echo $template->fetch('admin/message_body.html');
				close_out();
				}
				$page		= request_var('page', 0);
				$totsql = "SELECT COUNT(*) as tot FROM ".$db_prefix."_ratiowarn WHERE warned='no'";
				$totres = $db->sql_query($totsql)or btsqlerror($totsql);
				list ($tot) = $db->fetch_array($totres);
				$db->sql_freeresult($totres);
				$pages = ceil($tot / $torrent_per_page);
				$start = ($page >=1)?(($torrent_per_page * $page) - $torrent_per_page) : 0;
				$res_rws = $db->sql_query("SELECT *, TO_DAYS(NOW()) - TO_DAYS(ratiodate) as difference FROM ".$db_prefix."_ratiowarn WHERE warned='no' LIMIT ".$start.",".$torrent_per_page.";");
				$num = $db->sql_numrows($res_rws);
					for ($i = 0; $i < $num; ++$i)
					{            
						$arr = $db->sql_fetchrow($res_rws);
						$uinfo = build_user_array($arr['userid']);
						$timeleft = ($arr['difference'] - $arr_config["ratio_warn"])/-1;
						$template->assign_block_vars('user', array(
							'USER_ID'				=> $arr['userid'],
							'USER_NAME'				=> $uinfo['name'],
							'USER_NICK'				=> $uinfo['nick'],
							'USER_GROUP'			=> $uinfo['lname'],
							'USER_LEVEL'			=> $uinfo['level'],
							'USER_REG_DATE'			=> $uinfo['reg'],
							'USER_EMAIL'			=> $uinfo['email'],
							'USER_COLOR'			=> $uinfo['color'],
							'USER_UPED'				=> mksize($uinfo['uploaded']),
							'USER_DOWNED'			=> mksize($uinfo['downloaded']),
							'USER_RATIO'			=> $uinfo['ratio'],
							'USER_RATIO_COLORED'	=> get_u_ratio($uinfo['uploaded'], $uinfo['downloaded']),
							'TIME_LEFT'				=> sprintf($user->lang['TO_GO'],$timeleft),
							'USER_ACTION'			=> $timeleft,
							'WARNED'				=> (($arr['userid'] == 'yes')?$user->lang['YES']:$user->lang['NO']),
						));
					}
					$template->assign_vars(array(
					'S_ON_PAGE'		=> on_page($tot, $torrent_per_page, $start),
					'PAGINATION'	=> generate_pagination(append_sid($u_action,'do=watched'), $tot, $torrent_per_page, $start, true),
					'U_ACTION'		=> $u_action,
					));
			break;
			case 'index':
			break;
		}
                                $template->assign_vars(array(
								        'MODE'						=> $do,
								        'L_TITLE'     				=> $user->lang['TITLE_' . strtoupper($do)],
                                        'L_TITLE_EXPLAIN'			=> $user->lang['TITLE_EXPLAIN_' . strtoupper($do)],
                                ));
	echo $template->fetch('admin/acp_warnings.html');
	close_out();
?>