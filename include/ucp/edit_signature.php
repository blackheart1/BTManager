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
** File edit_signature.php 2018-02-18 14:32:00 joeroberts
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
				if (!$auth->acl_get('u_sig'))
				{
					trigger_error('NO_AUTH_SIGNATURE');
				}
				$error = array();
				if(request_var('preview',''))
				{
					$signature		= utf8_normalize_nfc(request_var('signature', (string) $user->data['signature'], true));
					$userrow["signature"] = $signature;
					include_once("include/utf/utf_tools.php");
					include_once('include/function_posting.' . $phpEx);
					include_once('include/class.bbcode.php');
					include_once('include/message_parser.php');
					$enable_bbcode	= ($config['allow_sig_bbcode']) ? ((request_var('disable_bbcode', !$user->optionget('bbcode'))) ? false : true) : false;
					$enable_smilies	= ($config['allow_sig_smilies']) ? ((request_var('disable_smilies', !$user->optionget('smilies'))) ? false : true) : false;
					$enable_urls	= ($config['allow_sig_links']) ? ((request_var('disable_magic_url', false)) ? false : true) : false;
					$message_parser = new parse_message($signature);
					$message_parser->parse($enable_bbcode, $enable_urls, $enable_smilies, $config['allow_sig_img'], $config['allow_sig_flash'], true, $config['allow_sig_links'], true, 'sig');
					$signature = $message_parser->message;


						include_once('include/bbcode.' . $phpEx);
						$bbcode = new bbcode($message_parser->bbcode_bitfield);
						$bbcode->bbcode_second_pass($signature, $message_parser->bbcode_uid, $message_parser->bbcode_bitfield);
						$signature = bbcode_nl2br($signature);
						$signature = smiley_text($signature);
                                $template->assign_vars(array(
								'SIGNATURE_PREVIEW'			=>	$signature,
								
								));

				}
				else
				{

					include_once("include/utf/utf_tools.php");
					include_once('include/function_posting.php');
					include_once('include/message_parser.php');
					include_once('include/class.bbcode.php');
					$enable_bbcode	= ($config['allow_sig_bbcode']) ? ((request_var('disable_bbcode', !$user->optionget('bbcode'))) ? false : true) : false;
					$enable_smilies	= ($config['allow_sig_smilies']) ? ((request_var('disable_smilies', !$user->optionget('smilies'))) ? false : true) : false;
					$enable_urls	= ($config['allow_sig_links']) ? ((request_var('disable_magic_url', false)) ? false : true) : false;
					$signature		= utf8_normalize_nfc(request_var('signature', (string) $user->data['signature'], true));
					if (!sizeof($error))
					{
						$message_parser = new parse_message($signature);

						// Allowing Quote BBCode
						$message_parser->parse($enable_bbcode, $enable_urls, $enable_smilies, $config['allow_sig_img'], $config['allow_sig_flash'], true, $config['allow_sig_links'], true, 'sig');

						if (sizeof($message_parser->warn_msg))
						{
							$error[] = implode('<br />', $message_parser->warn_msg);
						}

						if (!sizeof($error))
						{
							$sql_ary = array(
								'signature'					=> (string) $message_parser->message,
								'sig_bbcode_uid'		=> (string) $message_parser->bbcode_uid,
								'sig_bbcode_bitfield'	=> $message_parser->bbcode_bitfield
							);

							$sql = 'UPDATE ' . $db_prefix . '_users
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE id = ' . $uid;
							$db->sql_query($sql);
                                $template->assign_vars(array(
										'S_REFRESH'				=> true,
										'META' 				  	=> '<meta http-equiv="refresh" content="5;url=' . $siteurl . '/user.php?op=editprofile' . ((!$admin_mode) ? '' : "&amp;id=" .$uid  ) . '&amp;action=profile&amp;mode=signature" />',
										'S_ERROR_HEADER'		=>$user->lang['UPDATED'],
                                        'S_ERROR_MESS'			=> $user->lang['PROFILE_UPDATED'],
                                ));
							echo $template->fetch('error.html');
							die();
						}
					}
				}

					// Replace "error" strings with their real, localised form
					//$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				//die(print_r($error));
?>