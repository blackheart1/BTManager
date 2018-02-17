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
* @version $Id: 3.0.0 filter.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
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

                if (!$keyword) $errors[] = $user->lang['MISSING_KYEWORD'];

                if (!$whatfor) $errors[] = $user->lang['MISSING_REASON'];

                if (count($errors) > 0) {

					$err = "<ul>\n";
					foreach ($error as $msg)
					{
						$err .= "<li><p>".$msg."</p></li>\n";
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
					foreach ($error as $msg)
					{
						$err .= "<li><p>".$msg."</p></li>\n";
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

                $sql = "DELETE FROM ".$db_prefix."_filter WHERE id = '".intval($id)."'";

                $db->sql_query($sql) or btsqlerror($sql);
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