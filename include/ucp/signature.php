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
** File signature.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))
{
	include_once './../../security.php';
	die ();
}
$user->set_lang('forum',$user->ulanguage);
		$preview	= (!empty($_POST['preview'])) ? true : false;
		$submit		= (!empty($_POST['submit'])) ? true : false;
				include_once('include/function_posting.php');
				include_once('include/message_parser.php');
				include_once('include/class.bbcode.php');
				$signature		= utf8_normalize_nfc(request_var('signature', (string) $userrow["signature"], true));
				$signature_parser = new parse_message();
				$signature_parser->message = $signature;
				$signature_parser->decode_message($userrow['sig_bbcode_uid']);
		generate_smilies('inline', 0,true);
		$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_helpline
			FROM '.$db_prefix.'_bbcodes
			WHERE display_on_posting = 1
			ORDER BY bbcode_tag';
		$result = $db->sql_query($sql);
			
		$i = 0;
		$num_predefined_bbcodes = 24;
		while ($rows = $db->sql_fetchrow($result))
		{
			// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
			if (isset($user->lang[strtoupper($rows['bbcode_helpline'])]))
			{
				$rows['bbcode_helpline'] = $user->lang[strtoupper($rows['bbcode_helpline'])];
			}
	
			$template->assign_block_vars('custom_tags', array(
				'BBCODE_NAME'		=> "'[{$rows['bbcode_tag']}]', '[/" . str_replace('=', '', $rows['bbcode_tag']) . "]'",
				'BBCODE_ID'			=> $num_predefined_bbcodes + ($i * 2),
				'BBCODE_TAG'		=> str_replace('=', '', $rows['bbcode_tag']),
				'BBCODE_HELPLINE'	=> $rows['bbcode_helpline'],
				'A_BBCODE_HELPLINE'	=> str_replace(
					array('&amp;', '&quot;', "'", '&lt;', '&gt;'), 
					array('&', '"', "\'", '<', '>'), $rows['bbcode_helpline']),
			));
	
			$i++;
		}
				if ($submit || $preview)
				{
					$enable_bbcode	= ($config['allow_sig_bbcode']) ? ((request_var('disable_bbcode', false)) ? false : true) : false;
					$enable_smilies	= ($config['allow_sig_smilies']) ? ((request_var('disable_smilies', false)) ? false : true) : false;
					$enable_urls	= ($config['allow_sig_links']) ? ((request_var('disable_magic_url', false)) ? false : true) : false;

					if (!sizeof($error))
					{
						$message_parser = new parse_message($signature);

						// Allowing Quote BBCode
						$message_parser->parse($enable_bbcode, $enable_urls, $enable_smilies, $config['allow_sig_img'], $config['allow_sig_flash'], true, $config['allow_sig_links'], true, 'sig');

						if (sizeof($message_parser->warn_msg))
						{
							$error[] = implode('<br />', $message_parser->warn_msg);
						}

						if (!check_form_key('ucp_sig'))
						{
							$error[] = 'FORM_INVALID';
						}

						if (!sizeof($error) && $submit)
						{
							$user->optionset('sig_bbcode', $enable_bbcode);
							$user->optionset('sig_smilies', $enable_smilies);
							$user->optionset('sig_links', $enable_urls);

							$sql_ary = array(
								'user_sig'					=> (string) $message_parser->message,
								'user_options'				=> $user->data['user_options'],
								'user_sig_bbcode_uid'		=> (string) $message_parser->bbcode_uid,
								'user_sig_bbcode_bitfield'	=> $message_parser->bbcode_bitfield
							);

							$sql = 'UPDATE ' . USERS_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE user_id = ' . $user->data['user_id'];
							//$db->sql_query($sql);

							$message = $user->lang['PROFILE_UPDATED'] . '<br /><br />' . sprintf($user->lang['RETURN_UCP'], '<a href="' . $this->u_action . '">', '</a>');
							trigger_error($message);
						}
					}

					// Replace "error" strings with their real, localised form
					$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				}
				$signature_preview = '';
				if ($preview)
				{
					// Now parse it for displaying
					$signature_preview = $message_parser->format_display($enable_bbcode, $enable_urls, $enable_smilies, false);
					unset($message_parser);
				}
		$db->sql_freeresult($result);
		$template->assign_vars(array(
						'SIGNATURE_PREVIEW'	=> $signature_preview,
						'S_SMILIES_ALLOWED'			=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_SHOW_SMILEY_LINK'		=> ($config['allow_smilies'] && $config['auth_smilies_pm'] && checkaccess('u_pm_smilies')) ? true : false,
						'S_BBCODE_ALLOWED'			=> ($config['allow_bbcode'] && $config['auth_bbcode_pm'] && checkaccess('u_pm_bbcode')) ? true : false,
						'T_TEMPLATE_PATH' 			=> 'themes/' . $theme . '/templates',
						'S_BBCODE_QUOTE'			=> true,
						'S_UCP_ACTION'				=> true,
						'MESSAGE'					=>	addslashes($shoutannounce),
						'S_BBCODE_IMG'				=> ($config['auth_img_pm'] && checkaccess('u_pm_img')) ? true : false,
						'S_LINKS_ALLOWED'			=> ($config['allow_post_links']) ? true : false,
						'S_BBCODE_FLASH'			=> ($config['auth_flash_pm'] && checkaccess('u_pm_flash')) ? true : false,
		));
$template->assign_vars(array(
		'SIGNATURE'             => $signature_parser->message,
));
?>