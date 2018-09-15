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
** File filter.php 2018-02-23 14:32:00 Black_Heart
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
$user->set_lang('admin/mcp_filter',$user->ulanguage);
		$page_title = $user->lang['INTRO'];
				$template->assign_vars(array(
					'PAGE_TITLE'       => $page_title,
				));
$is_edit = false;
$banedit_key = Array("keyword" => "", "reason" => "");
		$postback_client					= request_var('postback_client', '');
		$id									= request_var('id', 0);
		$do									= request_var('do', '');
switch ($do) {

        case "addfilter": {

						$keyword					= request_var('keyword', '');
						$whatfor					= request_var('whatfor', '');
                $errors = Array();

                if (!$keyword) $errors[] = $user->lang['MISSING_KEYWORD'];

                if (!$whatfor) $errors[] = $user->lang['MISSING_REASON'];

                if (count($errors) > 0) {

					$err = "<ul>\n";
					foreach ($errors as $msg)
					{
						$err .= "<li>".$msg."</li>\n";
					}
					$err .= "</ul>\n";


                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $err,
											));
                        break;

                }

                $keyword = strtolower($db->sql_escape($keyword));

                $whatfor = $db->sql_escape(htmlspecialchars(trim($whatfor)));

                if (!preg_match("/^[\w]{5,50}$/",$keyword)) $errors[] = $user->lang['BAD_KEY_WORD'];

                if (strlen($whatfor) > 255) $errors[] = $user->lang['BAD_REASON'];

                if (count($errors) > 0) {
					$err = "<ul>\n";
					foreach ($errors as $msg)
					{
						$err .= "<li>".$msg."</li>\n";
					}
					$err .= "</ul>\n";


                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> false,
											'MESSAGE_TITLE'			=> $user->lang['BT_ERROR'],
											'MESSAGE_TEXT'			=> $err,
											));
                        break;

                }

                $sql = "INSERT INTO ".$db_prefix."_filter (keyword, reason) VALUES ('" . $keyword . "','" . $whatfor . "');";

                $db->sql_query($sql) or btsqlerror($sql);
				add_log('admin', 'LOG_FILTER_ADD', $keyword);
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> true,
											'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
											'MESSAGE_TEXT'			=> $user->lang['KEYWORD_ADDED'],
											));

                break;

        }

        case "editfilter": {

                if ($id AND is_numeric($id))
				{
						$keyword					= request_var('keyword', '');
						$whatfor					= request_var('whatfor', '');
                        if ($keyword AND $whatfor)
						{

                                $sql = "UPDATE ".$db_prefix."_filter SET keyword = '".strtolower(escape($keyword))."', reason = '".htmlspecialchars(escape(trim($whatfor)))."' WHERE id = '".$id."'";

                                $db->sql_query($sql) or btsqlerror($sql);
								add_log('admin', 'LOG_FILTER_EDIT', $keyword);
                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> true,
											'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
											'MESSAGE_TEXT'			=> $user->lang['KEYWORD_UPDATED'],
											));

                        }
						else
						{
                            $sql = "SELECT * FROM ".$db_prefix."_filter WHERE id = '".$id."';";
                            if (!$res_edit = $db->sql_query($sql)) btsqlerror($sql);
                            if ($db->sql_numrows($res_edit) == 1)
							{
								$row = $db->sql_fetchrow($res_edit);
								$db->sql_freeresult($res_edit);
								$banedit_key["keyword"] = $row["keyword"];
								$banedit_key["reason"] = $row["reason"];
								$is_edit = true;
								break;
							}
                        }
                }
                break;
        }

        case "delfilter": {
                if ($id AND is_numeric($id)) {

					$sql = 'SELECT keyword
						FROM ' . $db_prefix . "_filter
						WHERE id = $id";
					$result = $db->sql_query($sql);
					$deleted_word = $db->sql_fetchfield('keyword');
					$db->sql_freeresult($result);
                $sql = "DELETE FROM ".$db_prefix."_filter WHERE id = '".intval($id)."'";

                $db->sql_query($sql) or btsqlerror($sql);
					add_log('admin', 'LOG_FILTER_DELETE', $deleted_word);
				}

                                $template->assign_vars(array(
											'S_MESSAGE'				=> true,
											'S_USER_NOTICE'			=> true,
											'MESSAGE_TITLE'			=> $user->lang['SUCCESS'],
											'MESSAGE_TEXT'			=> $user->lang['KEYWORD_REMOVED'],
											));
                break;

        }

}
$sql = "SELECT * FROM ".$db_prefix."_filter ORDER BY id ASC;";
$res = $db->sql_query($sql);
if ($db->sql_numrows($res) > 0) {
        while ($row = $db->sql_fetchrow($res)) {
			$template->assign_block_vars('kyewords', array(
				'KEYWORD'				=> $row["keyword"],
				'WHATFOR'				=> htmlspecialchars($row["reason"]),
				'ID'							=> $row["id"],
				));
        }
}
$db->sql_freeresult($res);
if (!$is_edit)
{
	$hidden = array(
			'op'		=> 'filter',
			'i'			=> 'torrentinfo',
			"do" 		=> "addfilter"
			);
}
else
{
	$hidden = array(
			'op'		=> 'filter',
			'i'			=> 'torrentinfo',
			"do" 		=> "editfilter",
			"id" 		=> intval($id),
			);
}
                                $template->assign_vars(array(
								'KEYWORD'		=> $banedit_key["keyword"],
								'WHATFOR'		=> $banedit_key["reason"],
								'HIDDEN'				=> build_hidden_fields($hidden),
								'U_ACTION'				=> './admin.php',
								));
echo $template->fetch('admin/mcp_filter.html');
		close_out();

?>