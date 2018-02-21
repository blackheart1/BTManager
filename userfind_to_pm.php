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
** File userfind_to_pm.php 2018-02-17 14:32:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (defined('IN_PMBT'))die ("You can't include this file");
define("IN_PMBT",true);
require_once("common.php");
$user->set_lang('user_find',$user->ulanguage);
$template = new Template();
set_site_var($user->lang['FIND_USER_PM']);
$find				=	request_var('usersearch', '');
$umailsearch		= 	request_var('umailsearch', '');
$uipsearch			=	request_var('uipsearch', '');
$uhostsearch		=	request_var('uhostsearch', '');
$action				=	request_var('action', '');
$mode				=	request_var('mode', '');
$form				=	request_var('form', '');
$field				=	request_var('field', '');
$select_single		=	request_var('select_single', '');
if ($action!="find")
	{
	//search forum
		$hidden = build_hidden_fields(array(
					'mode'				=>	$mode,
					'form'				=>	$form,
					'field'				=>	$field,
					'select_single'		=>	$select_single,
		));
		$template->assign_vars(array(
				'S_SUCCESS'			=>	true,
				'TITTLE_M'          =>	$user->lang['FIND_USER_PM'],
				'MESSAGE'           =>	$user->lang['FIND_USER_PM_EXP'],
				'SEARCH_FEALD'		=>	$find,
				'FINDUSER'			=>	true,
				'HIDDEN'			=>	$hidden,
		));
	}
	else
	{
		$template->assign_vars(array(
				'SEARCH_FEALD_NAME'			=>	$find,
				'SEARCH_FEALD_EMAIL'		=>	$umailsearch,
				'SEARCH_FEALD_IP'			=>	$uipsearch,
				'SEARCH_FEALD_HOST'			=>	$uhostsearch,
		));
		if($find != '')
		{
			$where = "WHERE U.clean_username LIKE '%".$db->sql_escape(strtolower($find))."%'";
		}
		elseif($umailsearch != '')
		{
			$where = "WHERE U.email LIKE '%".$db->sql_escape($umailsearch)."%'";
		}
		elseif($uipsearch != '')
		{
			$where = "WHERE U.lastip = '".sprintf("%u",ip2long($uipsearch))."'";
		}
		elseif($uhostsearch != '')
		{
			$where = "WHERE U.lasthost LIKE '%".$db->sql_escape($uhostsearch)."%'";
		}
		$sql = 'SELECT 
					U.id AS id, 
					U.username AS name, 
					U.lastlogin AS lastlogin, 
					U.lastip AS ip, 
					U.lasthost AS lasthost, 
					U.name AS nick, 
					U.aim AS aim, 
					U.msn AS msn, 
					U.yahoo AS yahoo, 
					U.icq AS icq, 
					U.jabber AS jabber, 
					U.skype AS skype, 
					U.can_do AS goup, 
					U.level AS level, 
					U.regdate AS reg, 
					U.email AS email, 
					U.accept_mail AS accept_mail,
					U.uploaded AS uploaded, 
					U.downloaded AS downloaded, 
					U.uploaded/U.downloaded AS ratio, 
					U.modcomment AS mdcoment, 
					U.warned as warned, 
					U.warn_hossz as length, 
					U.warn_kapta as received, 
					U.user_posts AS postcount, 
					U.banreason AS banreason, 
					U.ban AS banned, 
					L.group_colour AS color, 
					L.group_name AS lname 
				FROM 
					`' . $db_prefix . '_users` U, 
					`' . $db_prefix . '_level_settings` L
					' . $where . " and
					L.group_id = U.can_do";
					//die($sql);
		$res = $db->sql_query($sql);
		if (!$res or $db->sql_numrows($res)==0)
			{
				//error no one found
				$hidden = build_hidden_fields(array(
							'mode'				=>	$mode,
							'form'				=>	$form,
							'field'				=>	$field,
							'select_single'		=>	$select_single,
				));
				$template->assign_vars(array(
						'S_ERROR'			=>	true,
						'TITTLE_M'          =>	$user->lang['ERROR_FIND_USER_PM'],
						'MESSAGE'           =>	$user->lang['ERROR_FIND_USER_PM_EXP'],
						'SEARCH_FEALD'		=>	$find,
						'FINDUSER'			=>	true,
						'HIDDEN'			=>	$hidden,
				));
			}
			else
			{
				$subres = $db->sql_query("SELECT COUNT(*) as num FROM " . $db_prefix . "_users U " . $where);
				$subrow = $db->sql_fetchrow($subres);
				$count = $subrow['num'];
				//echo "SELECT COUNT(*) FROM " . $db_prefix . "_users " . $where;
				if ($count >= "500")
					{
						//error to many found narrow your search
						$hidden = build_hidden_fields(array(
							'mode'				=>	$mode,
							'form'				=>	$form,
							'field'				=>	$field,
							'select_single'		=>	$select_single,
						));
						$template->assign_vars(array(
								'S_ERROR'			=>	true,
								'TITTLE_M'          =>	$user->lang['ERROR_TO_MANY_FOUND'],
								'MESSAGE'           =>	$user->lang['ERROR_TO_MANY_FOUND_EXP'],
								'SEARCH_FEALD'		=>	$find,
								'SINGLE_USER'		=>	($select_single == 'true')? true:false,
								'FINDUSER'			=>	true,
								'HIDDEN'			=>	$hidden,
						));
					}
					else
					{
						//multible users found
						$template->assign_vars(array(
								'S_ERROR'			=>	false,
								'TITTLE_M'          =>	$user->lang['ERROR_TO_MANY_FOUND'],
								'MESSAGE'           =>	$user->lang['ERROR_TO_MANY_FOUND_EXP'],
								'FINDUSER'			=>	false,
								'FORM_FEALD'		=>	$form,
								'TEXT_FEALD'		=>	$field,
								'NUM_FOUND'			=>	$count,
								'SINGLE_USER'		=>	($select_single == 'true')? true:false,
						));
						while($result=$db->sql_fetchrow($res))
							{
								//build user info
								$row = array();
								$row['ID'] 					= $result['id'];
								$row['NAME'] 				= $result['name'];
								$row['NICK'] 				= $result['nick'];
								$row['GROUP'] 				= ((!empty($user->lang[$result['lname']]))?$user->lang[$result['lname']]:$result['lname']);
								$row['LEVEL'] 				= $result['level'];
								$row['REGDATE'] 			= ($result['reg'] == '0000-00-00 00:00:00')? '--' : $result['reg'];
								$row['LASTLOGIN'] 			= ($result['lastlogin'] == '0000-00-00 00:00:00')? '--' : $result['lastlogin'];
								$row['IP'] 					= $result['ip'];
								$row['IPLONG@'] 			= long2ip($result['ip']);
								$row['LASTHOST'] 			= $result['lasthost'];
								$row['EMAIL'] 				= ($result['accept_mail'] == 'yes')?$result['email'] : false;
								$row['COLOR'] 				= $result['color'];
								$row['GOUP_ID'] 			= $result['goup'];
								$row['UPLOAD'] 				= $result['uploaded'];
								$row['DOWNLOAD'] 			= $result['downloaded'];
								$row['RATIO'] 				= $result['ratio'];
								$row['MODCOMMENT']			= $result['mdcoment'];
								$row['POSTCOUNT']			= $result['postcount'];
								$row['BANNED']				= $result['banned'];
								$row['BANREASON']			= $result['banreason'];
								$row['WARNED']				= $result['warned'];
								$row['AIM']					= (!empty($result["aim"]))? $result['aim'] : false;
								$row['SKYPE']				= (!empty($result["skype"]))? $result['skype'] : false;
								$row['YAHOO']				= (!empty($result["yahoo"]))? $result['yahoo'] : false;
								$row['NSN']					= (!empty($result["msn"]))? $result['msn'] : false;
								$row['ICQ']					= (!empty($result["icq"]))? $result['icq'] : false;
								$row['JABBER']				= (!empty($result["jabber"]))? $result['jabber'] : false;
								$row['COUNTRY']				= '';
								$template->assign_block_vars('users_found',$row);
							}
					}
			}
	}
	echo $template->fetch('userfind_to_pm.html');
	close_out();
?>