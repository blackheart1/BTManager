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
** File acp_asettings_bbcodercade.php 2018-02-23 14:32:00 Black_Heart
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
		$sql = 'SELECT * FROM `'.$db_prefix.'_settings`';
		$avres = $db->sql_query($sql) or btsqlerror($avsql);
		$cfgrow = array();
		while($adv_sett = $db->sql_fetchrow($avres))$cfgrow[$adv_sett['config_name']] = $adv_sett['config_value'] ;
	$do				= request_var('do', '');
	if(isset($do) && $do == "save")
	{
		$new_config = array();
		foreach($new_config as $key => $value)
		{
						set_config($config_name, $config_value);

			$db->sql_query('UPDATE ' . $db_prefix . '_settings SET config_value = \'' . $value . "' WHERE config_name = '" . $key . "' LIMIT 1;")or mysql_error();
		}
                                $template->assign_vars(array(
								        'S_SUCCESS'            => true,
										'S_FORWARD'			=> $siteurl."/admin.php?i=siteinfo&op=sig_settings",
								        'TITTLE_M'          => $user->lang['SUCCESS'],
                                        'MESSAGE'            => $user->lang['_admsaved'],
                                ));
		echo $template->fetch('message_body.html');
		die();
	}
				$hidden = build_hidden_fields(array(
							'do'		=> 'save',
							'i'			=> 'siteinfo',
							'op'		=> 'sig_settings',
						));
				$template->assign_vars(array(
				'L_TITLE'					=> $user->lang['MENU_SIG_SETTINGS'],
				'L_TITLE_EXPLAIN'			=> $user->lang['MENU_SIG_SETTINGS_EXP'],
				'U_ACTION'					=> "./admin.php",
				'S_FORM_TOKEN'			=> $hidden,
				));
echo $template->fetch('admin/site_settings.html');
		close_out();

?>