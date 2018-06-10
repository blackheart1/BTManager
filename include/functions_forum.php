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
** File functions_forum.php 2018-02-18 14:32:00 joeroberts
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
function is_booked_marcked($id){
global $db, $db_prefix, $user;
$sql = "SELECT COUNT(`forum_id`) FROM`".$db_prefix."_forums_watch` WHERE `forum_id`='".$id."' AND `user_id`='".$user->id."';";
$arr = $db->sql_query($sql);
$res = $db->sql_fetchrow($arr);
return ($res[0]>=1) ? true : false;
}
function get_topic_title($id){
global $db, $db_prefix;
			        $sql = "SELECT `subject` FROM `".$db_prefix."_forum_topics` WHERE `id`='".$id."' LIMIT 1;";
					$arr = $db->sql_query($sql);
					while ($res = $db->sql_fetchrow($arr)) {
					return $res['subject'];
					}

}


function get_row_count($table, $suffix = "")
{
global $db, $db_prefix;
  if ($suffix)
    $suffix = " $suffix";
  ($r = $db->sql_query("SELECT COUNT(*) FROM $table$suffix")) or die(mysql_error());
  ($a = $db->sql_fetchrow($r)) or die(mysql_error());
  return $a[0];
}
// Mark all forums as read
function catch_up(){ 
global $db, $db_prefix, $user;
	$res = $db->sql_query("SELECT id, lastpost FROM ".$db_prefix."_forum_topics") or forumsqlerr(__FILE__, __LINE__);
	while ($arr = $db->sql_fetchrow($res)) {
		$topicid = $arr["id"];
		$postid = $arr["lastpost"];
		$r = $db->sql_query("SELECT id,lastpostread FROM ".$db_prefix."_forum_readposts WHERE userid=".$user->id." AND topicid=$topicid") or forumsqlerr(__FILE__, __LINE__);
		if ($db->sql_numrows($r) == 0){
			$db->sql_query("INSERT INTO ".$db_prefix."_forum_readposts (userid, topicid, lastpostread) VALUES(".$user->id.", $topicid, $postid)") or forumsqlerr(__FILE__, __LINE__);
		}else{
			$a = $db->sql_fetchrow($r);
			if ($a["lastpostread"] < $postid)
			$db->sql_query("UPDATE ".$db_prefix."_forum_readposts SET lastpostread=$postid WHERE id=" . $a["id"]) or forumsqlerr(__FILE__, __LINE__);
		}
	}
}
function forum_generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = false, $tpl_prefix = '')
{
	global $template, $user;

	// Make sure $per_page is a valid value
	$per_page = ($per_page <= 0) ? 1 : $per_page;

	$seperator = '<span class="page-sep">' . $user->lang['COMMA_SEPARATOR'] . '</span>';
	$total_pages = ceil($num_items / $per_page);

	if ($total_pages == 1 || !$num_items)
	{
		return false;
	}

	$on_page = floor($start_item / $per_page) + 1;
	$url_delim = (strpos($base_url, '?') === false) ? '?' : ((strpos($base_url, '?') === strlen($base_url) - 1) ? '' : '&amp;');

	$page_string = ($on_page == 1) ? '<strong>1</strong>' : '<a href="' . $base_url . '">1</a>';

	if ($total_pages > 5)
	{
		$start_cnt = min(max(1, $on_page - 4), $total_pages - 5);
		$end_cnt = max(min($total_pages, $on_page + 4), 6);

		$page_string .= ($start_cnt > 1) ? '<span class="page-dots"> ... </span>' : $seperator;

		for ($i = $start_cnt + 1; $i < $end_cnt; $i++)
		{
			$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}start=" . (($i - 1) * $per_page) . '">' . $i . '</a>';
			if ($i < $end_cnt - 1)
			{
				$page_string .= $seperator;
			}
		}

		$page_string .= ($end_cnt < $total_pages) ? '<span class="page-dots"> ... </span>' : $seperator;
	}
	else
	{
		$page_string .= $seperator;

		for ($i = 2; $i < $total_pages; $i++)
		{
			$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}start=" . (($i - 1) * $per_page) . '">' . $i . '</a>';
			if ($i < $total_pages)
			{
				$page_string .= $seperator;
			}
		}
	}

	$page_string .= ($on_page == $total_pages) ? '<strong>' . $total_pages . '</strong>' : '<a href="' . $base_url . "{$url_delim}start=" . (($total_pages - 1) * $per_page) . '">' . $total_pages . '</a>';

	if ($add_prevnext_text)
	{
		if ($on_page != 1)
		{
			$page_string = '<a href="' . $base_url . "{$url_delim}start=" . (($on_page - 2) * $per_page) . '">' . $user->lang['PREVIOUS'] . '</a>&nbsp;&nbsp;' . $page_string;
		}

		if ($on_page != $total_pages)
		{
			$page_string .= '&nbsp;&nbsp;<a href="' . $base_url . "{$url_delim}start=" . ($on_page * $per_page) . '">' . $user->lang['NEXT'] . '</a>';
		}
	}

	$template->assign_vars(array(
		$tpl_prefix . 'BASE_URL'		=> $base_url,
		'A_' . $tpl_prefix . 'BASE_URL'	=> addslashes($base_url),
		$tpl_prefix . 'PER_PAGE'		=> $per_page,

		$tpl_prefix . 'PREVIOUS_PAGE'	=> ($on_page == 1) ? '' : $base_url . "{$url_delim}start=" . (($on_page - 2) * $per_page),
		$tpl_prefix . 'NEXT_PAGE'		=> ($on_page == $total_pages) ? '' : $base_url . "{$url_delim}start=" . ($on_page * $per_page),
		$tpl_prefix . 'TOTAL_PAGES'		=> $total_pages,
	));

	return $page_string;
}
// Returns the minimum read/write class levels of a forum
function get_forum_access_levels($forumid, $var = ''){ 
global $db, $db_prefix, $user;
    $sql = "SELECT acl_read, acl_write FROM ".$db_prefix."_forums WHERE forum_id=" . $forumid . " LIMIT 1;";
	//die($sql);
	$res = $db->sql_query($sql);
	if ($db->sql_numrows($res) != 1)
		return false;
		if($var){
		if($user->group == '1')return true;
		if($arr[$var] == "0")return true;
		if (!$arr[$var] == "0" AND !in_array($user->group,explode(" ", $arr[$var])) AND !in_array($user->id,explode(" ", $arr[$var])))return false;
		}
	$arr = $db->sql_fetchrow($res);
		return array("read" => $arr["acl_read"], "write" => $arr["acl_write"]);
}

function display_reasons($reason_id = 0)
{
	global $db, $user, $template, $db_prefix;

	$sql = 'SELECT *
		FROM ' . $db_prefix . '_reports_reasons
		ORDER BY reason_order ASC';
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		// If the reason is defined within the language file, we will use the localized version, else just use the database entry...
		if (isset($user->lang['report_reasons']['TITLE'][strtoupper($row['reason_title'])]) && isset($user->lang['report_reasons']['DESCRIPTION'][strtoupper($row['reason_title'])]))
		{
			$row['reason_description'] = $user->lang['report_reasons']['DESCRIPTION'][strtoupper($row['reason_title'])];
			$row['reason_title'] = $user->lang['report_reasons']['TITLE'][strtoupper($row['reason_title'])];
		}

		$template->assign_block_vars('reason', array(
			'ID'			=> $row['reason_id'],
			'TITLE'			=> $row['reason_title'],
			'DESCRIPTION'	=> $row['reason_description'],
			'S_SELECTED'	=> ($row['reason_id'] == $reason_id) ? true : false)
		);
	}
	$db->sql_freeresult($result);
}
// Returns the forum ID of a topic, or false on error
function multi_array_key_exists( $needle, $haystack ) {
 
    foreach ( $haystack as $key => $value ) :

        if ( preg_match("/\b".$needle."\b/i",$key) )
            return true;
       
        if ( is_array( $value ) ) :
             if ( multi_array_key_exists( $needle, $value ) == true )
                return true;
             else
                 continue;
        endif;
       
    endforeach;
   
    return false;
} 
function encodehtml($s, $linebreaks = true)
{
  $s = str_replace(array("<",">","\""), array("&lt;","&gt;","&quot;"), str_replace("&", "&amp;", $s));
  if ($linebreaks)
    $s = nl2br($s);
  return $s;
}
function CutName ($vTxt, $Car) {
	while(strlen($vTxt) > $Car) {
		return substr($vTxt, 0, $Car) . "...";
	} return $vTxt;
}
function is_valid_id($id)
{
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}
function parse_attachments($forum_id, &$message, &$attachments, &$update_count, $preview = false)
{
	if (!sizeof($attachments))
	{
		return;
	}

	global $template, $pmbt_cache, $user;
	global $extensions, $config, $phpbb_root_path, $phpEx, $db ,$siteurl,$db_prefix;

	//
	$compiled_attachments = array();

	if (!isset($template->filename['attachment_tpl']))
	{
		$template->set_filenames(array(
			'attachment_tpl'	=> 'attachment.html')
		);
	}

	if (empty($extensions) || !is_array($extensions))
	{
		$extensions = $pmbt_cache->obtain_attach_extensions($forum_id);
	}

	// Look for missing attachment information...
	$attach_ids = array();
	foreach ($attachments as $pos => $attachment)
	{
		// If is_orphan is set, we need to retrieve the attachments again...
		if (!isset($attachment['extension']) && !isset($attachment['physical_filename']))
		{
			$attach_ids[(int) $attachment['attach_id']] = $pos;
		}
	}

	// Grab attachments (security precaution)
	if (sizeof($attach_ids))
	{
		global $db,$db_prefix;

		$new_attachment_data = array();

		$sql = 'SELECT *
			FROM ' . $db_prefix . '_attachments
			WHERE ' . $db->sql_in_set('attach_id', array_keys($attach_ids));
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			if (!isset($attach_ids[$row['attach_id']]))
			{
				continue;
			}

			// If we preview attachments we will set some retrieved values here
			if ($preview)
			{
				$row['attach_comment'] = $attachments[$attach_ids[$row['attach_id']]]['attach_comment'];
			}

			$new_attachment_data[$attach_ids[$row['attach_id']]] = $row;
		}
		$db->sql_freeresult($result);

		$attachments = $new_attachment_data;
		unset($new_attachment_data);
	}

	// Sort correctly
	if ($config['display_order'])
	{
		// Ascending sort
		krsort($attachments);
	}
	else
	{
		// Descending sort
		ksort($attachments);
	}

	foreach ($attachments as $attachment)
	{
		if (!sizeof($attachment))
		{
			continue;
		}

		// We need to reset/empty the _file block var, because this function might be called more than once
		$template->destroy_block_vars('_file');

		$block_array = array();

		// Some basics...
		$attachment['extension'] = strtolower(trim($attachment['extension']));
		$filename = $config['upload_path'] . '/' . utf8_basename($attachment['physical_filename']);
		$thumbnail_filename = $config['upload_path'] . '/thumb_' . utf8_basename($attachment['physical_filename']);

		$upload_icon = '';

		if (isset($extensions[$attachment['extension']]))
		{
			if ($user->img('icon_topic_attach', '') && !$extensions[$attachment['extension']]['upload_icon'])
			{
				$upload_icon = $user->img('icon_topic_attach', '');
			}
			else if ($extensions[$attachment['extension']]['upload_icon'])
			{
				$upload_icon = '<img src="' . $phpbb_root_path . $config['upload_path'] . '/' . trim($extensions[$attachment['extension']]['upload_icon']) . '" alt="" />';
				
			}
		}
		$filesize = get_formatted_filesize($attachment['filesize'], false);

		$comment = bbcode_nl2br(censor_text($attachment['attach_comment']));
		$template->assign_vars(array(
			//'S_SHOW_ATTACH_BOX'	=> $show_attach_box,
			'S_HAS_ATTACHMENTS'	=> true,
			));
		$block_array += array(
			'UPLOAD_ICON'		=> $upload_icon,
			'FILESIZE'			=> $filesize['value'],
			'SIZE_LANG'			=> $filesize['unit'],
			'DOWNLOAD_NAME'		=> utf8_basename($attachment['real_filename']),
			'COMMENT'			=> $comment,
		);

		$denied = false;

		if (!extension_allowed($forum_id, $attachment['extension'], $extensions))
		{
			$denied = true;

			$block_array += array(
				'S_DENIED'			=> true,
				'DENIED_MESSAGE'	=> sprintf($user->lang['_EXTENSION_DISABLED_AFTER_POSTING'], $attachment['extension'])
			);
		}
		if (!$denied)
		{
			$l_downloaded_viewed = $download_link = '';
			$display_cat = $extensions[$attachment['extension']]['display_cat'];
			if ($display_cat == 1)
			{
				if ($attachment['thumbnail'])
				{
					$display_cat = 4;
				}
				else
				{
					if ($config['img_display_inlined'])
					{
						if ($config['img_link_width'] || $config['img_link_height'])
						{
							$dimension = @getimagesize($filename);

							// If the dimensions could not be determined or the image being 0x0 we display it as a link for safety purposes
							if ($dimension === false || empty($dimension[0]) || empty($dimension[1]))
							{
								$display_cat = 0;
							}
							else
							{
								$display_cat = ($dimension[0] <= $config['img_link_width'] && $dimension[1] <= $config['img_link_height']) ? 1 : 0;
							}
						}
					}
					else
					{
						$display_cat = 0;
					}
				}
			}
			// Make some descisions based on user options being set.
			/*if (($display_cat == 1 || $display_cat == 4) )
			{
				$display_cat = 0;
			}

			if ($display_cat == 5 )
			{
				$display_cat = 0;
			}*/

			$download_link = append_sid("{$siteurl}/file.$phpEx", 'id=' . $attachment['attach_id']);
			//die(print($display_cat));
			switch ($display_cat)
			{
				// Images
				case 1:
					$l_downloaded_viewed = 'VIEWED_COUNT';
					$inline_link = append_sid("{$siteurl}/file.$phpEx", 'id=' . $attachment['attach_id']);
					$download_link .= '&amp;mode=view';

					$block_array += array(
						'S_IMAGE'		=> true,
						'U_INLINE_LINK'		=> $inline_link,
					);

					$update_count[] = $attachment['attach_id'];
				break;

				// Images, but display Thumbnail
				case 4:
					$l_downloaded_viewed = 'VIEWED_COUNT';
					$thumbnail_link = append_sid("{$siteurl}/file.$phpEx", 'id=' . $attachment['attach_id'] . '&amp;t=1');
					$download_link .= '&amp;mode=view';

					$block_array += array(
						'S_THUMBNAIL'		=> true,
						'THUMB_IMAGE'		=> $thumbnail_link,
					);

					$update_count[] = $attachment['attach_id'];
				break;

				// Windows Media Streams
				case 2:
					$l_downloaded_viewed = 'VIEWED_COUNT';

					// Giving the filename directly because within the wm object all variables are in local context making it impossible
					// to validate against a valid session (all params can differ)
					// $download_link = $filename;

					$block_array += array(
						'U_FORUM'		=> generate_board_url(),
						'ATTACH_ID'		=> $attachment['attach_id'],
						'S_WM_FILE'		=> true,
					);

					// Viewed/Heared File ... update the download count
					$update_count[] = $attachment['attach_id'];
				break;

				// Real Media Streams
				case 3:
				case 6:
					$l_downloaded_viewed = 'VIEWED_COUNT';

					$block_array += array(
						'S_RM_FILE'			=> ($display_cat == 3) ? true : false,
						'S_QUICKTIME_FILE'	=> ($display_cat == 6) ? true : false,
						'U_FORUM'			=> $siteurl,
						'ATTACH_ID'			=> $attachment['attach_id'],
					);

					// Viewed/Heared File ... update the download count
					$update_count[] = $attachment['attach_id'];
				break;

				// Macromedia Flash Files
				case 5:
					list($width, $height) = @getimagesize($filename);

					$l_downloaded_viewed = 'VIEWED_COUNT';

					$block_array += array(
						'S_FLASH_FILE'	=> true,
						'WIDTH'			=> $width,
						'HEIGHT'		=> $height,
						'U_VIEW_LINK'	=> $download_link . '&amp;view=1',
					);

					// Viewed/Heared File ... update the download count
					$update_count[] = $attachment['attach_id'];
				break;

				default:
					$l_downloaded_viewed = 'DOWNLOAD_COUNT';

					$block_array += array(
						'S_FILE'		=> true,
					);
				break;
			}

			$l_download_count = (!isset($attachment['download_count']) || $attachment['download_count'] == 0) ? $user->lang[$l_downloaded_viewed . '_NONE'] : (($attachment['download_count'] == 1) ? sprintf($user->lang[$l_downloaded_viewed], $attachment['download_count']) : sprintf($user->lang[$l_downloaded_viewed . 'S'], $attachment['download_count']));

			$block_array += array(
				'U_DOWNLOAD_LINK'		=> $download_link,
				'L_DOWNLOAD_COUNT'		=> $l_download_count
			);
		}
		//unset($template->_tpldata['_file']);
		$template->assign_block_vars('_file', $block_array);
		$compiled_attachments[] = $template->assign_display('attachment_tpl');
	}
	$attachments = $compiled_attachments;
//print_r($attachments);
	unset($compiled_attachments);

	$tpl_size = sizeof($attachments);

	$unset_tpl = array();

	preg_match_all('#<!\-\- ia([0-9]+) \-\->(.*?)<!\-\- ia\1 \-\->#', $message, $matches, PREG_PATTERN_ORDER);

	$replace = array();
	foreach ($matches[0] as $num => $capture)
	{
		// Flip index if we are displaying the reverse way
		$index = ($config['display_order']) ? ($tpl_size-($matches[1][$num] + 1)) : $matches[1][$num];

		$replace['from'][] = $matches[0][$num];
		$replace['to'][] = (isset($attachments[$index])) ? $attachments[$index] : sprintf($user->lang['_MISSING_INLINE_ATTACHMENT'], $matches[2][array_search($index, $matches[1])]);

		$unset_tpl[] = $index;
	}

	if (isset($replace['from']))
	{
		$message = str_replace($replace['from'], $replace['to'], $message);
	}

	$unset_tpl = array_unique($unset_tpl);

	// Needed to let not display the inlined attachments at the end of the post again
	foreach ($unset_tpl as $index)
	{
		unset($attachments[$index]);
	}
}
function topic_generate_pagination($replies, $url)
{
	global $torrent_per_page, $user, $config;

	// Make sure $per_page is a valid value
	$per_page = ($config['posts_per_page'] <= 0) ? 1 : $config['posts_per_page'];

	if (($replies + 1) > $per_page)
	{
		$total_pages = ceil(($replies + 1) / $per_page);
		$pagination = '';

		$times = 1;
		for ($j = 0; $j < $replies + 1; $j += $per_page)
		{
			$pagination .= '<a href="' . $url . '&amp;start=' . $j . '">' . $times . '</a>';
			if ($times == 1 && $total_pages > 5)
			{
				$pagination .= ' ... ';

				// Display the last three pages
				$times = $total_pages - 3;
				$j += ($total_pages - 4) * $per_page;
			}
			else if ($times < $total_pages)
			{
				$pagination .= '<span class="page-sep">' . $user->lang['COMMA_SEPARATOR'] . '</span>';
			}
			$times++;
		}
	}
	else
	{
		$pagination = '';
	}

	return $pagination;
}
function bump_topic_allowed($forum_id, $topic_bumped, $last_post_time, $topic_poster, $last_topic_poster)
{
	global $config, $user, $auth;

	// Check permission and make sure the last post was not already bumped
	if (!$auth->acl_get('f_bump', $forum_id) || $topic_bumped)
	{
		return false;
	}

	// Check bump time range, is the user really allowed to bump the topic at this time?
	$bump_time = ($config['bump_type'] == 'm') ? $config['bump_interval'] * 60 : (($config['bump_type'] == 'h') ? $config['bump_interval'] * 3600 : $config['bump_interval'] * 86400);

	// Check bump time
	if ($last_post_time + $bump_time > time())
	{
		return false;
	}

	// Check bumper, only topic poster and last poster are allowed to bump
	if ($topic_poster != $user->id && $last_topic_poster != $user->id)
	{
		return false;
	}

	// A bump time of 0 will completely disable the bump feature... not intended but might be useful.
	return $bump_time;
}
function get_topic_tracking($forum_id, $topic_ids, &$rowset, $forum_mark_time, $global_announce_list = false)
{
	global $config, $user, $db, $db_prefix;

	$last_read = array();

	if (!is_array($topic_ids))
	{
		$topic_ids = array($topic_ids);
	}

	foreach ($topic_ids as $topic_id)
	{
		if (!empty($rowset[$topic_id]['mark_time']))
		{
			$last_read[$topic_id] = $rowset[$topic_id]['mark_time'];
		}
	}

	$topic_ids = array_diff($topic_ids, array_keys($last_read));

	if (sizeof($topic_ids))
	{
		$mark_time = array();

		// Get global announcement info
		if ($global_announce_list && sizeof($global_announce_list))
		{
			if (!isset($forum_mark_time[0]))
			{
				global $db, $db_prefix;

				$sql = 'SELECT mark_time
					FROM ' . $db_prefix."_forums_track
					WHERE user_id = {$user->id}
						AND forum_id = 0";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if ($row)
				{
					$mark_time[0] = $row['mark_time'];
				}
			}
			else
			{
				if ($forum_mark_time[0] !== false)
				{
					$mark_time[0] = $forum_mark_time[0];
				}
			}
		}

		if (!empty($forum_mark_time[$forum_id]) && $forum_mark_time[$forum_id] !== false)
		{
			$mark_time[$forum_id] = $forum_mark_time[$forum_id];
		}

		$user_lastmark = (isset($mark_time[$forum_id])) ? $mark_time[$forum_id] : $user->data['user_lastmark'];

		foreach ($topic_ids as $topic_id)
		{
			if ($global_announce_list && isset($global_announce_list[$topic_id]))
			{
				$last_read[$topic_id] = (isset($mark_time[0])) ? $mark_time[0] : $user_lastmark;
			}
			else
			{
				$last_read[$topic_id] = $user_lastmark;
			}
		}
	}

	return $last_read;
}
function extension_allowed($forum_id, $extension, &$extensions)
{
	if (empty($extensions))
	{
		global $pmbt_cache;
		global $db, $db_prefix;
		$extensions = $pmbt_cache->obtain_attach_extensions($forum_id);
	}
	return (!isset($extensions['_allowed_'][$extension])) ? false : true;
}
function posting_gen_attachment_entry($attachment_data, &$filename_data, $show_attach_box = true)
{
	global $template, $config, $phpbb_root_path, $phpEx, $user, $auth;

	// Some default template variables
	$template->assign_vars(array(
		'S_SHOW_ATTACH_BOX'	=> $show_attach_box,
		'S_HAS_ATTACHMENTS'	=> true,
		'FILESIZE'			=> $config['max_filesize'],
		'FILE_COMMENT'		=> (isset($filename_data['filecomment'])) ? $filename_data['filecomment'] : '',
	));

	if (sizeof($attachment_data))
	{
		// We display the posted attachments within the desired order.
		($config['display_order']) ? krsort($attachment_data) : ksort($attachment_data);

		foreach ($attachment_data as $count => $attach_row)
		{
			$hidden = '';
			$attach_row['real_filename'] = $attach_row['real_filename'];

			foreach ($attach_row as $key => $value)
			{
				$hidden .= '<input type="hidden" name="attachment_data[' . $count . '][' . $key . ']" value="' . $value . '" />';
			}

			$download_link = append_sid("{$phpbb_root_path}file.$phpEx", 'mode=view&amp;id=' . (int) $attach_row['attach_id'], true, ($attach_row['is_orphan']) ? $user->session_id : false);

			$template->assign_block_vars('attach_row', array(
				'FILENAME'			=> $attach_row['real_filename'],
				'A_FILENAME'		=> addslashes($attach_row['real_filename']),
				'FILE_COMMENT'		=> $attach_row['attach_comment'],
				'ATTACH_ID'			=> $attach_row['attach_id'],
				'S_IS_ORPHAN'		=> $attach_row['is_orphan'],
				'ASSOC_INDEX'		=> $count,

				'U_VIEW_ATTACHMENT'	=> $download_link,
				'S_HIDDEN'			=> $hidden)
			);
		}
	}

	return sizeof($attachment_data);
}
function acl_get($can,$from=0)
{
	global $db, $db_prefix, $user, $pmbt_cache;
	if($from == 0)
	{
		return checkaccess($can);
	}
global $auth_get_all;
if (empty($auth_get_all) || !is_array($auth_get_all))
{
$auth_get_all = array();
}
$auth_get_all[][$can] = $from;
return true;
}
	function acl_getf_global($opt)
	{
		return true;
		if (is_array($opt))
		{
			// evaluates to true as soon as acl_getf_global is true for one option
			foreach ($opt as $check_option)
			{
				if ($this->acl_getf_global($check_option))
				{
					return true;
				}
			}

			return false;
		}

		if (isset($this->acl_options['local'][$opt]))
		{
			foreach ($this->acl as $f => $bitstring)
			{
				// Skip global settings
				if (!$f)
				{
					continue;
				}

				// as soon as the user has any permission we're done so return true
				if ((!isset($this->cache[$f][$opt])) ? $this->acl_get($opt, $f) : $this->cache[$f][$opt])
				{
					return true;
				}
			}
		}
		else if (isset($this->acl_options['global'][$opt]))
		{
			return $this->acl_get($opt);
		}

		return false;
	}
	function acl_gets()
	{
		$args = func_get_args();
		$f = array_pop($args);

		if (!is_numeric($f))
		{
			$args[] = $f;
			$f = 0;
		}

		// alternate syntax: acl_gets(array('m_', 'a_'), $forum_id)
		if (is_array($args[0]))
		{
			$args = $args[0];
		}

		$acl = 0;
		foreach ($args as $opt)
		{
			$acl |= acl_get($opt, $f);
		}

		return $acl;
	}
function generate_text_for_edit($text, $uid, $flags)
{
	global $phpbb_root_path, $phpEx;

	decode_message($text, $uid);

	return array(
		'allow_bbcode'	=> ($flags & 1) ? 1 : 0,
		'allow_smilies'	=> ($flags & 2) ? 1 : 0,
		'allow_urls'	=> ($flags & 4) ? 1 : 0,
		'text'			=> $text
	);
}
function make_forum_select($select_id = false, $ignore_id = false, $ignore_acl = false, $ignore_nonpost = false, $ignore_emptycat = true, $only_acl_post = false, $return_array = false)
{
	global $db, $db_prefix, $user, $auth;

	// This query is identical to the jumpbox one
	$sql = 'SELECT forum_id, forum_name, parent_id, forum_type, forum_flags, forum_options, left_id, right_id
		FROM ' . $db_prefix . '_forums
		ORDER BY left_id ASC';
		//echo $sql;
	$result = $db->sql_query($sql)or mysql_error();

	$right = 0;
	$padding_store = array('0' => '');
	$padding = '';
	$forum_list = ($return_array) ? array() : '';

	// Sometimes it could happen that forums will be displayed here not be displayed within the index page
	// This is the result of forums not displayed at index, having list permissions and a parent of a forum with no permissions.
	// If this happens, the padding could be "broken"
//echo 'test';
	while ($row = $db->sql_fetchrow($result))
	{
	//echo $row['left_id'] . 'a';
		if ($row['left_id'] < $right)
		{
			$padding .= '&nbsp; &nbsp;';
			$padding_store[$row['parent_id']] = $padding;
		}
		else if ($row['left_id'] > $right + 1)
		{
			$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : '';
		}

		$right = $row['right_id'];
		$disabled = false;

		if (!$ignore_acl)
		{
			if ($only_acl_post)
			{
				$disabled = true;
			}
		}
		else if (!$ignore_acl)
		{
			continue;
		}

		if (
			((is_array($ignore_id) && in_array($row['forum_id'], $ignore_id)) || $row['forum_id'] == $ignore_id)
			||
			// Non-postable forum with no subforums, don't display
			($row['forum_type'] == 0 && ($row['left_id'] + 1 == $row['right_id']) && $ignore_emptycat)
			||
			($row['forum_type'] != 1 && $ignore_nonpost)
			)
		{
			$disabled = true;
		}

		if ($return_array)
		{
			// Include some more information...
			$selected = (is_array($select_id)) ? ((in_array($row['forum_id'], $select_id)) ? true : false) : (($row['forum_id'] == $select_id) ? true : false);
			$forum_list[$row['forum_id']] = array_merge(array('padding' => $padding, 'selected' => ($selected && !$disabled), 'disabled' => $disabled), $row);
		}
		else
		{
			$selected = (is_array($select_id)) ? ((in_array($row['forum_id'], $select_id)) ? ' selected="selected"' : '') : (($row['forum_id'] == $select_id) ? ' selected="selected"' : '');
			$forum_list .= '<option value="' . $row['forum_id'] . '"' . (($disabled) ? ' disabled="disabled" class="disabled-option"' : $selected) . '>' . $padding . $row['forum_name'] . '</option>';
		}
	}
	$db->sql_freeresult($result);
	unset($padding_store);
//die($forum_list);
	return $forum_list;
}
function display_forums($root_data = '', $display_moderators = false, $return_moderators = false)
{
	global $db, $auth, $user, $template, $theme;
	global $phpbb_root_path, $phpEx, $config, $db_prefix;
			$forum_rows = $subforums = $forum_ids = $forum_ids_moderator = $forum_moderators = $active_forum_ary = array();
	$parent_id = $visible_forums = 0;
	$sql_from = '';

	// Mark forums read?
	$mark_read = request_var('mark', '');

	if ($mark_read == 'all')
	{
		$mark_read = '';
	}

	if (!$root_data)
	{
		if ($mark_read == 'forums')
		{
			$mark_read = 'all';
		}

		$root_data = array('forum_id' => 0);
		$sql_where = '';
	}
	else
	{
		$sql_where = 'left_id > ' . $root_data['left_id'] . ' AND left_id < ' . $root_data['right_id'];
	}

	// Handle marking everything read
	if ($mark_read == 'all')
	{
		$redirect = build_url(array('mark', 'hash'));
		meta_refresh(3, $redirect);

		if (check_link_hash(request_var('hash', ''), 'global'))
		{
			markread('all');

			trigger_error(
				$user->lang['FORUMS_MARKED'] . '<br /><br />' .
				sprintf($user->lang['RETURN_INDEX'], '<a href="' . $redirect . '">', '</a>')
			);
		}
		else
		{
			trigger_error(sprintf($user->lang['RETURN_PAGE'], '<a href="' . $redirect . '">', '</a>'));
		}
	}
	// Display list of active topics for this category?
	$show_active = (isset($root_data['forum_flags']) && ($root_data['forum_flags'] & 16)) ? true : false;

	$sql_array = array(
		'SELECT'	=> 'f.*',
		'FROM'		=> array(
			$db_prefix.'_forums'		=> 'f'
		),
		'LEFT_JOIN'	=> array(),
	);

	if ($user->user)
	{
		$sql_array['LEFT_JOIN'][] = array('FROM' => array($db_prefix.'_forums_track' => 'ft'), 'ON' => 'ft.user_id = ' . $user->id . ' AND ft.forum_id = f.forum_id');
		$sql_array['SELECT'] .= ', ft.mark_time';
	}

	if ($show_active)
	{
		$sql_array['LEFT_JOIN'][] = array(
			'FROM'	=> array($db_prefix.'_forums_access' => 'fa'),
			'ON'	=> "fa.forum_id = f.forum_id AND fa.session_id = '" . $db->sql_escape($user->session_id) . "'"
		);

		$sql_array['SELECT'] .= ', fa.user_id';
	}

	$sql = $db->sql_build_query('SELECT', array(
		'SELECT'	=> $sql_array['SELECT'],
		'FROM'		=> $sql_array['FROM'],
		'LEFT_JOIN'	=> $sql_array['LEFT_JOIN'],

		'WHERE'		=> $sql_where,

		'ORDER_BY'	=> 'f.left_id',
	));
	$result = $db->sql_query($sql);

	$forum_tracking_info = array();
	$branch_root_id = $root_data['forum_id'];
	while ($row = $db->sql_fetchrow($result))
	{
		$forum_id = $row['forum_id'];

		// Mark forums read?
		if ($mark_read == 'forums' || $mark_read == 'all')
		{
			if ($auth->acl_get('f_list', $forum_id))
			{
				$forum_ids[] = $forum_id;
				continue;
			}
		}

		// Category with no members
		if ($row['forum_type'] == 0 && ($row['left_id'] + 1 == $row['right_id']))
		{
			continue;
		}

		// Skip branch
		if (isset($right_id))
		{
			if ($row['left_id'] < $right_id)
			{
				continue;
			}
			unset($right_id);
		}

		if (!$auth->acl_get('f_list', $forum_id))
		{
			// if the user does not have permissions to list this forum, skip everything until next branch
			$right_id = $row['right_id'];
			continue;
		}

		$forum_ids[] = $forum_id;

		if ($user->user)
		{
			$forum_tracking_info[$forum_id] = (!empty($row['mark_time'])) ? $row['mark_time'] : $user->data['user_lastmark'];
		}

		$row['forum_topics'] = ($auth->acl_get('m_approve', $forum_id)) ? $row['forum_topics_real'] : $row['forum_topics'];

		// Display active topics from this forum?
		if ($show_active && $row['forum_type'] == 1 && $auth->acl_get('f_read', $forum_id) && ($row['forum_flags'] & 16))
		{
			if (!isset($active_forum_ary['forum_topics']))
			{
				$active_forum_ary['forum_topics'] = 0;
			}

			if (!isset($active_forum_ary['forum_posts']))
			{
				$active_forum_ary['forum_posts'] = 0;
			}

			$active_forum_ary['forum_id'][]		= $forum_id;
			$active_forum_ary['enable_icons'][]	= $row['enable_icons'];
			$active_forum_ary['forum_topics']	+= $row['forum_topics'];
			$active_forum_ary['forum_posts']	+= $row['forum_posts'];

			// If this is a passworded forum we do not show active topics from it if the user is not authorised to view it...
			if ($row['forum_password'] && $row['user_id'] != $user->id)
			{
				$active_forum_ary['exclude_forum_id'][] = $forum_id;
			}
		}

		//
		if ($row['parent_id'] == $root_data['forum_id'] || $row['parent_id'] == $branch_root_id)
		{
			if ($row['forum_type'] != 0)
			{
				$forum_ids_moderator[] = (int) $forum_id;
			}

			// Direct child of current branch
			$parent_id = $forum_id;
			$forum_rows[$forum_id] = $row;

			if ($row['forum_type'] == 0 && $row['parent_id'] == $root_data['forum_id'])
			{
				$branch_root_id = $forum_id;
			}
			$forum_rows[$parent_id]['forum_id_last_post'] = $row['forum_id'];
			$forum_rows[$parent_id]['orig_forum_last_post_time'] = $row['forum_last_post_time'];
		}
		else if ($row['forum_type'] != 0)
		{
			$subforums[$parent_id][$forum_id]['display'] = ($row['display_on_index']) ? true : false;
			$subforums[$parent_id][$forum_id]['name'] = $row['forum_name'];
			$subforums[$parent_id][$forum_id]['orig_forum_last_post_time'] = $row['forum_last_post_time'];
			$subforums[$parent_id][$forum_id]['children'] = array();

			if (isset($subforums[$parent_id][$row['parent_id']]) && !$row['display_on_index'])
			{
				$subforums[$parent_id][$row['parent_id']]['children'][] = $forum_id;
			}

			$forum_rows[$parent_id]['forum_topics'] += $row['forum_topics'];

			// Do not list redirects in LINK Forums as Posts.
			if ($row['forum_type'] != 2)
			{
				$forum_rows[$parent_id]['forum_posts'] += $row['forum_posts'];
			}

			if ($row['forum_last_post_time'] > $forum_rows[$parent_id]['forum_last_post_time'])
			{
				$forum_rows[$parent_id]['forum_last_post_id'] = $row['forum_last_post_id'];
				$forum_rows[$parent_id]['forum_last_post_subject'] = $row['forum_last_post_subject'];
				$forum_rows[$parent_id]['forum_last_post_time'] = $row['forum_last_post_time'];
				$forum_rows[$parent_id]['forum_last_poster_id'] = $row['forum_last_poster_id'];
				$forum_rows[$parent_id]['forum_last_poster_name'] = $row['forum_last_poster_name'];
				$forum_rows[$parent_id]['forum_last_poster_colour'] = $row['forum_last_poster_colour'];
				$forum_rows[$parent_id]['forum_id_last_post'] = $forum_id;
			}
		}
	}
	$db->sql_freeresult($result);

	$result = $db->sql_query($sql);
	if ($display_moderators)
	{
		if ($return_moderators)
		{
			$forum_ids_moderator[] = $root_data['forum_id'];
		}
		get_moderators($forum_moderators, $forum_ids_moderator);
	}
	$last_catless = true;
	foreach ($forum_rows as $row)
	{
		// Empty category
		if ($row['parent_id'] == $root_data['forum_id'] && $row['forum_type'] == 0)
		{
			$template->assign_block_vars('forumrow', array(
				'S_IS_CAT'				=> true,
				'FORUM_ID'				=> $row['forum_id'],
				'FORUM_NAME'			=> $row['forum_name'],
				'FORUM_DESC'			=> generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
				'FORUM_FOLDER_IMG'		=> '',
				'FORUM_FOLDER_IMG_SRC'	=> '',
				'FORUM_IMAGE'			=> ($row['forum_image']) ? '<img src="' . $phpbb_root_path . $row['forum_image'] . '" alt="' . $user->lang['FORUM_CAT'] . '" />' : '',
				'FORUM_IMAGE_SRC'		=> ($row['forum_image']) ? $phpbb_root_path . $row['forum_image'] : '',
				'U_VIEWFORUM'			=> append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $row['forum_id']))
			);

			continue;
		}

		$visible_forums++;
		$forum_id = $row['forum_id'];

		$forum_unread = (isset($forum_tracking_info[$forum_id]) && $row['orig_forum_last_post_time'] > $forum_tracking_info[$forum_id]) ? true : false;

		$folder_image = $folder_alt = $l_subforums = '';
		$subforums_list = array();

		// Generate list of subforums if we need to
		if (isset($subforums[$forum_id]))
		{
			foreach ($subforums[$forum_id] as $subforum_id => $subforum_row)
			{
				$subforum_unread = (isset($forum_tracking_info[$subforum_id]) && $subforum_row['orig_forum_last_post_time'] > $forum_tracking_info[$subforum_id]) ? true : false;

				if (!$subforum_unread && !empty($subforum_row['children']))
				{
					foreach ($subforum_row['children'] as $child_id)
					{
						if (isset($forum_tracking_info[$child_id]) && $subforums[$forum_id][$child_id]['orig_forum_last_post_time'] > $forum_tracking_info[$child_id])
						{
							// Once we found an unread child forum, we can drop out of this loop
							$subforum_unread = true;
							break;
						}
					}
				}

				if ($subforum_row['display'] && $subforum_row['name'])
				{
					$subforums_list[] = array(
						'link'		=> append_sid("{$phpbb_root_path}forum.$phpEx?action=viewforum", 'f=' . $subforum_id),
						'name'		=> $subforum_row['name'],
						'unread'	=> $subforum_unread,
					);
				}
				else
				{
					unset($subforums[$forum_id][$subforum_id]);
				}

				// If one subforum is unread the forum gets unread too...
				if ($subforum_unread)
				{
					$forum_unread = true;
				}
			}

			$l_subforums = (sizeof($subforums[$forum_id]) == 1) ? $user->lang['SUBFORUM'] . ': ' : $user->lang['SUBFORUMS'] . ': ';
			$folder_image = ($forum_unread) ? 'forum_unread_subforum' : 'forum_read_subforum';
		}
		else
		{
			switch ($row['forum_type'])
			{
				case 1:
					$folder_image = ($forum_unread) ? 'forum_unread' : 'forum_read';
				break;

				case 2:
					$folder_image = '2';
				break;
			}
		}

		// Which folder should we display?
		if ($row['forum_status'] == 1)
		{
			$folder_image = ($forum_unread) ? 'forum_unread_locked' : 'forum_read_locked';
			$folder_alt = 'FORUM_LOCKED';
		}
		else
		{
			$folder_alt = ($forum_unread) ? 'NEW_POSTS' : 'NO_NEW_POSTS';
		}

		// Create last post link information, if appropriate
		if ($row['forum_last_post_id'])
		{
			$last_post_subject = $row['forum_last_post_subject'];
			$last_post_time = $user->format_date($row['forum_last_post_time']);
			//die(print_r($row));
			$last_post_url = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewtopic&amp;f=' . $row['forum_id_last_post'] . '&amp;t=' . $row['forum_id_last_post'] . '&amp;p=' . $row['forum_last_post_id']) . '#p' . $row['forum_last_post_id'];
		}
		else
		{
			$last_post_subject = $last_post_time = $last_post_url = '';
		}

		// Output moderator listing ... if applicable
		$l_moderator = $moderators_list = '';
		if ($display_moderators && !empty($forum_moderators[$forum_id]))
		{
			$l_moderator = (sizeof($forum_moderators[$forum_id]) == 1) ? $user->lang['MODERATOR'] : $user->lang['MODERATORS'];
			$moderators_list = implode(', ', $forum_moderators[$forum_id]);
		}

		$l_post_click_count = ($row['forum_type'] == 2) ? 'CLICKS' : 'POSTS';
		$post_click_count = ($row['forum_type'] != 2 || $row['forum_flags'] & 1) ? $row['forum_posts'] : '';

		$s_subforums_list = array();
		foreach ($subforums_list as $subforum)
		{
			$s_subforums_list[] = '<a href="' . $subforum['link'] . '" class="subforum ' . (($subforum['unread']) ? 'unread' : 'read') . '" title="' . (($subforum['unread']) ? $user->lang['NEW_POSTS'] : $user->lang['NO_NEW_POSTS']) . '">' . $subforum['name'] . '</a>';
		}
		$s_subforums_list = (string) implode(', ', $s_subforums_list);
		$catless = ($row['parent_id'] == $root_data['forum_id']) ? true : false;

		if ($row['forum_type'] != 2)
		{
			$u_viewforum = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $row['forum_id']);
		}
		else
		{
			// If the forum is a link and we count redirects we need to visit it
			// If the forum is having a password or no read access we do not expose the link, but instead handle it in viewforum
			if (($row['forum_flags'] & 1) || $row['forum_password'] || !$auth->acl_get('f_read', $forum_id))
			{
				$u_viewforum = append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $row['forum_id']);
			}
			else
			{
				$u_viewforum = $row['2'];
			}
		}
//die($last_post_url);
		$template->assign_block_vars('forumrow', array(
			'S_IS_CAT'			=> false,
			'S_NO_CAT'			=> $catless && !$last_catless,
			'S_IS_LINK'			=> ($row['forum_type'] == 2) ? true : false,
			'S_UNREAD_FORUM'	=> $forum_unread,
			'S_LOCKED_FORUM'	=> ($row['forum_status'] == 1) ? true : false,
			'S_LIST_SUBFORUMS'	=> ($row['display_subforum_list']) ? true : false,
			'S_SUBFORUMS'		=> (sizeof($subforums_list)) ? true : false,

			'FORUM_ID'				=> $row['forum_id'],
			'FORUM_NAME'			=> $row['forum_name'],
			'FORUM_DESC'			=> generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
			'TOPICS'				=> $row['forum_topics'],
			$l_post_click_count		=> $post_click_count,
			'FORUM_FOLDER_IMG'		=> $user->img($folder_image, $folder_alt),
			'FORUM_FOLDER_IMG_SRC'	=> $user->img($folder_image, $folder_alt, false, '', 'src'),
			'FORUM_FOLDER_IMG_ALT'	=> isset($user->lang[$folder_alt]) ? $user->lang[$folder_alt] : '',
			'FORUM_IMAGE'			=> ($row['forum_image']) ? '<img src="' . $phpbb_root_path . $row['forum_image'] . '" alt="' . $user->lang[$folder_alt] . '" />' : '',
			'FORUM_IMAGE_SRC'		=> ($row['forum_image']) ? $phpbb_root_path . $row['forum_image'] : '',
			'LAST_POST_SUBJECT'		=> censor_text($last_post_subject),
			'LAST_POST_TIME'		=> $last_post_time,
			'LAST_POSTER'			=> get_username_string('username', $row['forum_last_poster_id'], $row['forum_last_poster_name'],'#' . $row['forum_last_poster_colour']),
			'LAST_POSTER_COLOUR'	=> get_username_string('colour', $row['forum_last_poster_id'], $row['forum_last_poster_name'],'#' . $row['forum_last_poster_colour']),
			'LAST_POSTER_FULL'		=> get_username_string('full', $row['forum_last_poster_id'], $row['forum_last_poster_name'],'#' . $row['forum_last_poster_colour']),
			'MODERATORS'			=> $moderators_list,
			'SUBFORUMS'				=> $s_subforums_list,

			'L_SUBFORUM_STR'		=> $l_subforums,
			'L_FORUM_FOLDER_ALT'	=> $folder_alt,
			'L_MODERATOR_STR'		=> $l_moderator,

			'U_VIEWFORUM'		=> $u_viewforum,
			'U_LAST_POSTER'		=> get_username_string('profile', $row['forum_last_poster_id'], $row['forum_last_poster_name'],'#' . $row['forum_last_poster_colour']),
			'U_LAST_POST'		=> $last_post_url)
		);

		// Assign subforums loop for style authors
		foreach ($subforums_list as $subforum)
		{
			$template->assign_block_vars('forumrow.subforum', array(
				'U_SUBFORUM'	=> $subforum['link'],
				'SUBFORUM_NAME'	=> $subforum['name'],
				'S_UNREAD'		=> $subforum['unread'])
			);
		}

		$last_catless = $catless;
	}

	$template->assign_vars(array(
		'T_THEME_PATH'		=>	'themes/' . $theme .'/',
		'U_MARK_FORUMS'		=> ($user->user) ? append_sid("{$phpbb_root_path}forum.$phpEx", 'hash=' . generate_link_hash('global') . '&amp;mark=forums') : '',
		'S_HAS_SUBFORUM'	=> ($visible_forums) ? true : false,
		'L_SUBFORUM'		=> ($visible_forums == 1) ? $user->lang['SUBFORUM'] : $user->lang['SUBFORUMS'],
		'LAST_POST_IMG'		=> $user->img('icon_topic_latest', 'VIEW_LATEST_POST'))
	);
	if ($return_moderators)
	{
		return array($active_forum_ary, $forum_moderators);
	}

	return array($active_forum_ary, array());
}
function build_url($strip_vars = false)
{
	global $user, $siteurl;

	// Append SID
	$redirect = append_sid($user->lastpage, false, false);

	// Add delimiter if not there...
	if (strpos($redirect, '?') === false)
	{
		$redirect .= '?';
	}

	// Strip vars...
	if ($strip_vars !== false && strpos($redirect, '?') !== false)
	{
		if (!is_array($strip_vars))
		{
			$strip_vars = array($strip_vars);
		}

		$query = $_query = array();

		$args = substr($redirect, strpos($redirect, '?') + 1);
		$args = ($args) ? explode('&', $args) : array();
		$redirect = substr($redirect, 0, strpos($redirect, '?'));

		foreach ($args as $argument)
		{
			$arguments = explode('=', $argument);
			$key = $arguments[0];
			unset($arguments[0]);

			$query[$key] = implode('=', $arguments);
		}

		// Strip the vars off
		foreach ($strip_vars as $strip)
		{
			if (isset($query[$strip]))
			{
				unset($query[$strip]);
			}
		}

		// Glue the remaining parts together... already urlencoded
		foreach ($query as $key => $value)
		{
			$_query[] = $key . '=' . $value;
		}
		$query = implode('&', $_query);

		$redirect .= ($query) ? '?' . $query : '';
	}

	return $siteurl . '/' . str_replace('&', '&amp;', $redirect);
}
function generate_forum_rules(&$forum_data)
{
	if (!$forum_data['forum_rules'] && !$forum_data['forum_rules_link'])
	{
		return;
	}

	global $template, $phpbb_root_path, $phpEx;

	if ($forum_data['forum_rules'])
	{
		$forum_data['forum_rules'] = generate_text_for_display($forum_data['forum_rules'], $forum_data['forum_rules_uid'], $forum_data['forum_rules_bitfield'], $forum_data['forum_rules_options']);
	}

	$template->assign_vars(array(
		'S_FORUM_RULES'	=> true,
		'U_FORUM_RULES'	=> $forum_data['forum_rules_link'],
		'FORUM_RULES'	=> $forum_data['forum_rules'])
	);
}
function generate_forum_nav(&$forum_data)
{
	global $db, $user, $auth, $template, $db_prefix;
	global $phpEx, $phpbb_root_path;

	if (!$auth->acl_get('f_list', $forum_data['forum_id']))
	{
		return;
	}
	// Get forum parents
	$forum_parents = get_forum_parents($forum_data);
	//die(print_r($forum_parents));

	// Build navigation links
	if (!empty($forum_parents))
	{
		foreach ($forum_parents as $parent_forum_id => $parent_data)
		{
			list($parent_name, $parent_type) = array_values($parent_data);

			// Skip this parent if the user does not have the permission to view it
			if (!$auth->acl_get('f_list', $parent_forum_id))
			{
				continue;
			}

			$template->assign_block_vars('navlinks', array(
				'S_IS_CAT'		=> ($parent_type == 0) ? true : false,
				'S_IS_LINK'		=> ($parent_type == 2) ? true : false,
				'S_IS_POST'		=> ($parent_type == 1) ? true : false,
				'FORUM_NAME'	=> $parent_name,
				'FORUM_ID'		=> $parent_forum_id,
				'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $parent_forum_id))
			);
		}
	}

	$template->assign_block_vars('navlinks', array(
		'S_IS_CAT'		=> ($forum_data['forum_type'] == 0) ? true : false,
		'S_IS_LINK'		=> ($forum_data['forum_type'] == 2) ? true : false,
		'S_IS_POST'		=> ($forum_data['forum_type'] == 1) ? true : false,
		'FORUM_NAME'	=> $forum_data['forum_name'],
		'FORUM_ID'		=> $forum_data['forum_id'],
		'U_VIEW_FORUM'	=> append_sid("{$phpbb_root_path}forum.$phpEx", 'action=viewforum&amp;f=' . $forum_data['forum_id']))
	);

	$template->assign_vars(array(
		'FORUM_ID' 		=> $forum_data['forum_id'],
		'FORUM_NAME'	=> $forum_data['forum_name'],
		'FORUM_DESC'	=> generate_text_for_display($forum_data['forum_desc'], $forum_data['forum_desc_uid'], $forum_data['forum_desc_bitfield'], $forum_data['forum_desc_options']))
	);

	return;
}
function get_forum_parents(&$forum_data)
{
	global $db, $db_prefix;

	$forum_parents = array();

	if ($forum_data['parent_id'] > 0)
	{
		if ($forum_data['forum_parents'] == '')
		{
			$sql = 'SELECT forum_id, forum_name, forum_type
				FROM ' . $db_prefix.'_forums
				WHERE left_id < ' . $forum_data['left_id'] . '
					AND right_id > ' . $forum_data['right_id'] . '
				ORDER BY left_id ASC';
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				$forum_parents[$row['forum_id']] = array($row['forum_name'], (int) $row['forum_type']);
			}
			$db->sql_freeresult($result);

			$forum_data['forum_parents'] = serialize($forum_parents);

			$sql = 'UPDATE ' . $db_prefix."_forums
				SET forum_parents = '" . $db->sql_escape($forum_data['forum_parents']) . "'
				WHERE parent_id = " . $forum_data['parent_id'];
			$db->sql_query($sql);
		}
		else
		{
			$forum_parents = unserialize($forum_data['forum_parents']);
		}
	}

	return $forum_parents;
}
function login_forum_box($forum_data)
{
	global $db, $config, $user, $template, $db_prefix, $phpEx, $action;

	$password = request_var('password', '', true);

	$sql = 'SELECT forum_id
		FROM ' . $db_prefix.'_forums_access
		WHERE forum_id = ' . $forum_data['forum_id'] . '
			AND user_id = ' . $user->id . "
			AND session_id = '" . $db->sql_escape($user->act_key) . "'";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($row)
	{
		return true;
	}

	if ($password)
	{
		// Remove expired authorised sessions
		$sql = 'SELECT f.session_id
			FROM ' . $db_prefix.'_forums_access f
			LEFT JOIN ' . $db_prefix.'_sessions s ON (f.session_id = s.session_id)
			WHERE s.session_id IS NULL';
		$result = $db->sql_query($sql);

		if ($row = $db->sql_fetchrow($result))
		{
			$sql_in = array();
			do
			{
				$sql_in[] = (string) $row['session_id'];
			}
			while ($row = $db->sql_fetchrow($result));

			// Remove expired sessions
			$sql = 'DELETE FROM ' . $db_prefix.'_forums_access
				WHERE ' . $db->sql_in_set('session_id', $sql_in);
			$db->sql_query($sql);
		}
		$db->sql_freeresult($result);

		if ($password == $forum_data['forum_password'])
		{
			$sql_ary = array(
				'forum_id'		=> (int) $forum_data['forum_id'],
				'user_id'		=> (int) $user->id,
				'session_id'	=> (string) $user->act_key,
			);

			$db->sql_query('INSERT INTO ' . $db_prefix.'_forums_access ' . $db->sql_build_array('INSERT', $sql_ary));

			return true;
		}

		$template->assign_var('LOGIN_ERROR', $user->lang['WRONG_PASSWORD']);
	}


	$template->assign_vars(array(
		'HIDDEN'		=> build_hidden_fields(array('f' => $forum_data['forum_id'], 'action' => $action)))
	);

		echo $template->fetch('login.html');
		close_out();
}
function make_jumpbox($action, $forum_id = false, $select_all = false, $acl_list = false, $force_display = false)
{
	global $config, $auth, $template, $user, $db, $db_prefix;

	// We only return if the jumpbox is not forced to be displayed (in case it is needed for functionality)
	if ($force_display === false)
	{
		return;
	}

	$sql = 'SELECT forum_id, forum_name, parent_id, forum_type, left_id, right_id
		FROM ' . $db_prefix.'_forums
		ORDER BY left_id ASC';
	$result = $db->sql_query($sql);

	$right = $padding = 0;
	$padding_store = array('0' => 0);
	$display_jumpbox = false;
	$iteration = 0;

	// Sometimes it could happen that forums will be displayed here not be displayed within the index page
	// This is the result of forums not displayed at index, having list permissions and a parent of a forum with no permissions.
	// If this happens, the padding could be "broken"

	while ($row = $db->sql_fetchrow($result))
	{
		if ($row['left_id'] < $right)
		{
			$padding++;
			$padding_store[$row['parent_id']] = $padding;
		}
		else if ($row['left_id'] > $right + 1)
		{
			// Ok, if the $padding_store for this parent is empty there is something wrong. For now we will skip over it.
			// @todo digging deep to find out "how" this can happen.
			$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : $padding;
		}

		$right = $row['right_id'];

		if ($row['forum_type'] == 0 && ($row['left_id'] + 1 == $row['right_id']))
		{
			// Non-postable forum with no subforums, don't display
			continue;
		}

		if (!$auth->acl_get('f_list', $row['forum_id']))
		{
			// if the user does not have permissions to list this forum skip
			continue;
		}

		if ($acl_list && !$auth->acl_gets($acl_list, $row['forum_id']))
		{
			continue;
		}

		if (!$display_jumpbox)
		{
			$template->assign_block_vars('jumpbox_forums', array(
				'FORUM_ID'		=> ($select_all) ? 0 : -1,
				'FORUM_NAME'	=> ($select_all) ? $user->lang['ALL_FORUMS'] : $user->lang['SELECT_FORUM'],
				'S_FORUM_COUNT'	=> $iteration)
			);

			$iteration++;
			$display_jumpbox = true;
		}

		$template->assign_block_vars('jumpbox_forums', array(
			'FORUM_ID'		=> $row['forum_id'],
			'FORUM_NAME'	=> $row['forum_name'],
			'SELECTED'		=> ($row['forum_id'] == $forum_id) ? ' selected="selected"' : '',
			'S_FORUM_COUNT'	=> $iteration,
			'S_IS_CAT'		=> ($row['forum_type'] == 0) ? true : false,
			'S_IS_LINK'		=> ($row['forum_type'] == 2) ? true : false,
			'S_IS_POST'		=> ($row['forum_type'] == 1) ? true : false)
		);

		for ($i = 0; $i < $padding; $i++)
		{
			$template->assign_block_vars('jumpbox_forums.level', array());
		}
		$iteration++;
	}
	$db->sql_freeresult($result);
	unset($padding_store);

	$template->assign_vars(array(
		'S_DISPLAY_JUMPBOX'	=> $display_jumpbox,
		'S_JUMPBOX_ACTION'	=> $action)
	);

	return;
}
function topic_status(&$topic_row, $replies, $unread_topic, &$folder_img, &$folder_alt, &$topic_type)
{
	global $user, $config;

	$folder = $folder_new = '';

	if ($topic_row['topic_status'] == 2)
	{
		$topic_type = $user->lang['VIEW_TOPIC_MOVED'];
		$folder_img = 'topic_moved';
		$folder_alt = 'TOPIC_MOVED';
	}
	else
	{
		switch ($topic_row['topic_type'])
		{
			case 3:
				$topic_type = $user->lang['VIEW_TOPIC_GLOBAL'];
				$folder = 'global_read';
				$folder_new = 'global_unread';
			break;

			case 2:
				$topic_type = $user->lang['VIEW_TOPIC_ANNOUNCEMENT'];
				$folder = 'announce_read';
				$folder_new = 'announce_unread';
			break;

			case 1:
				$topic_type = $user->lang['VIEW_TOPIC_STICKY'];
				$folder = 'sticky_read';
				$folder_new = 'sticky_unread';
			break;

			default:
				$topic_type = '';
				$folder = 'topic_read';
				$folder_new = 'topic_unread';

				// Hot topic threshold is for posts in a topic, which is replies + the first post. ;)
				if ($config['hot_threshold'] && ($replies + 1) >= $config['hot_threshold'] && $topic_row['topic_status'] != 1)
				{
					$folder .= '_hot';
					$folder_new .= '_hot';
				}
			break;
		}

		if ($topic_row['topic_status'] == 1)
		{
			$topic_type = $user->lang['VIEW_TOPIC_LOCKED'];
			$folder .= '_locked';
			$folder_new .= '_locked';
		}


		$folder_img = ($unread_topic) ? $folder_new : $folder;
		$folder_alt = ($unread_topic) ? 'NEW_POSTS' : (($topic_row['topic_status'] == 1) ? 'TOPIC_LOCKED' : 'NO_NEW_POSTS');

		// Posted image?
		if (!empty($topic_row['topic_posted']) && $topic_row['topic_posted'])
		{
			$folder_img .= '_mine';
		}
	}

	if ($topic_row['poll_start'] && $topic_row['topic_status'] != 2)
	{
		$topic_type = $user->lang['VIEW_TOPIC_POLL'];
	}
}
function gen_forum_auth_level($mode, $forum_id, $forum_status)
{
	global $template, $auth, $user, $config;

	$locked = ($forum_status == 1 && !$auth->acl_get('m_edit', $forum_id)) ? true : false;

	$rules = array(
		($auth->acl_get('f_post', $forum_id) && !$locked) ? $user->lang['RULES_POST_CAN'] : $user->lang['RULES_POST_CANNOT'],
		($auth->acl_get('f_reply', $forum_id) && !$locked) ? $user->lang['RULES_REPLY_CAN'] : $user->lang['RULES_REPLY_CANNOT'],
		($user->user && $auth->acl_gets('f_edit', 'm_edit', $forum_id) && !$locked) ? $user->lang['RULES_EDIT_CAN'] : $user->lang['RULES_EDIT_CANNOT'],
		($user->user && $auth->acl_gets('f_delete', 'm_delete', $forum_id) && !$locked) ? $user->lang['RULES_DELETE_CAN'] : $user->lang['RULES_DELETE_CANNOT'],
	);

	if ($config['allow_attachments'])
	{
		$rules[] = ($auth->acl_get('f_attach', $forum_id) && $auth->acl_get('u_attach') && !$locked) ? $user->lang['RULES_ATTACH_CAN'] : $user->lang['RULES_ATTACH_CANNOT'];
	}

	foreach ($rules as $rule)
	{
		$template->assign_block_vars('rules', array('RULE' => $rule));
	}

	return;
}
function watch_topic_forum($mode, &$s_watching, $user_id, $forum_id, $topic_id, $notify_status = 'unset', $start = 0)
{
	global $template, $db, $user, $phpEx, $start, $phpbb_root_path, $db_prefix;

	$table_sql = ($mode == 'forum') ? $db_prefix . '_forums_watch' : $db_prefix . '_topics_watch';
	$where_sql = ($mode == 'forum') ? 'forum_id' : 'topic_id';
	$match_id = ($mode == 'forum') ? $forum_id : $topic_id;
	$u_url = "uid={$user->id}";
	$u_url .= ($mode == 'forum') ? '&amp;f' : '&amp;f=' . $forum_id . '&amp;t';

	// Is user watching this thread?
	if ($user_id != 0)
	{
		$can_watch = true;

		if ($notify_status == 'unset')
		{
			$sql = "SELECT notify_status
				FROM $table_sql
				WHERE $where_sql = $match_id
					AND user_id = $user_id";
			$result = $db->sql_query($sql);

			$notify_status = ($row = $db->sql_fetchrow($result)) ? $row['notify_status'] : NULL;
			$db->sql_freeresult($result);
		}

		if (!is_null($notify_status) && $notify_status !== '')
		{

			if (isset($_GET['unwatch']))
			{
				$uid = request_var('uid', 0);
				if ($uid != $user_id)
				{
					$redirect_url = append_sid("{$phpbb_root_path}forum.php","action=view$mode&amp;$u_url=$match_id&amp;start=$start");
					$message = $user->lang['ERR_UNWATCHING'] . '<br /><br />' . sprintf($user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
					trigger_error($message);
				}
				if ($_GET['unwatch'] == $mode)
				{
					$is_watching = 0;

					$sql = 'DELETE FROM ' . $table_sql . "
						WHERE $where_sql = $match_id
							AND user_id = $user_id";
					$db->sql_query($sql);
				}

				$redirect_url = append_sid("{$phpbb_root_path}forum.php","action=view$mode&amp;$u_url=$match_id&amp;start=$start");

				meta_refresh(3, $redirect_url);

				$message = $user->lang['NOT_WATCHING_' . strtoupper($mode)] . '<br /><br />' . sprintf($user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
				$template->assign_vars(array(
					'MESSAGE'		=>$message,
				));
				echo $template->fetch('message_body.html');
				close_out();

				trigger_error($message);
			}
			else
			{
				$is_watching = true;

				if ($notify_status)
				{
					$sql = 'UPDATE ' . $table_sql . "
						SET notify_status = 0
						WHERE $where_sql = $match_id
							AND user_id = $user_id";
					$db->sql_query($sql);
				}
			}
		}
		else
		{
			if (isset($_GET['watch']))
			{
				$token = request_var('hash', '');
				$redirect_url = append_sid("{$phpbb_root_path}forum.php","action=view$mode&amp;$u_url=$match_id&amp;start=$start");

				if ($_GET['watch'] == $mode && check_link_hash($token, "{$mode}_$match_id"))
				{
					$is_watching = true;

					$sql = 'INSERT INTO ' . $table_sql . " (user_id, $where_sql, notify_status)
						VALUES ($user_id, $match_id, 0)";
					$db->sql_query($sql);
					$message = $user->lang['ARE_WATCHING_' . strtoupper($mode)] . '<br /><br />' . sprintf($user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
				}
				else
				{
					$message = $user->lang['ERR_WATCHING'] . '<br /><br />' . sprintf($user->lang['RETURN_' . strtoupper($mode)], '<a href="' . $redirect_url . '">', '</a>');
				}

				meta_refresh(3, $redirect_url);
				$template->assign_vars(array(
					'MESSAGE'		=>$message,
				));
				echo $template->fetch('message_body.html');
				close_out();

				trigger_error($message);
			}
			else
			{
				$is_watching = 0;
			}
		}
	}
	else
	{
		if (isset($_GET['unwatch']) && $_GET['unwatch'] == $mode)
		{
			login_box();
		}
		else
		{
			$can_watch = 0;
			$is_watching = 0;
		}
	}

	if ($can_watch)
	{
		$s_watching['link'] = append_sid("{$phpbb_root_path}forum.php","action=view$mode&amp;$u_url=$match_id&amp;" . (($is_watching) ? 'unwatch' : 'watch') . "=$mode&amp;start=$start&amp;hash=" . generate_link_hash("{$mode}_$match_id"));
		$s_watching['title'] = $user->lang[(($is_watching) ? 'STOP' : 'START') . '_WATCHING_' . strtoupper($mode)];
		$s_watching['is_watching'] = $is_watching;
	}

	return;
}
function generate_link_hash($link_name)
{
	global $user;

	if (!isset($user->data["hash_$link_name"]))
	{
		$user->data["hash_$link_name"] = substr(sha1($user->act_key . $link_name), 0, 8);
	}

	return $user->data["hash_$link_name"];
}
function check_link_hash($token, $link_name)
{
	return $token === generate_link_hash($link_name);
}
function get_moderators(&$forum_moderators, $forum_id = false)
{
	global $config, $template, $db, $phpbb_root_path, $phpEx, $user, $db_prefix, $auth;

	// Have we disabled the display of moderators? If so, then return
	// from whence we came ...
	if (!$config['load_moderators'])
	{
		return;
	}

	$forum_sql = '';

	if ($forum_id !== false)
	{
		if (!is_array($forum_id))
		{
			$forum_id = array($forum_id);
		}

		// If we don't have a forum then we can't have a moderator
		if (!sizeof($forum_id))
		{
			return;
		}

		$forum_sql = 'AND m.' . $db->sql_in_set('forum_id', $forum_id);
	}

	$sql_array = array(
		'SELECT'	=> 'm.*, g.group_colour AS user_colour, g.group_colour, g.group_type',

		'FROM'		=> array(
			$db_prefix . '_moderator_cache'	=> 'm',
		),

		'LEFT_JOIN'	=> array(
			array(
				'FROM'	=> array($db_prefix . '_users' => 'u'),
				'ON'	=> 'm.user_id = u.id',
			),
			array(
				'FROM'	=> array($db_prefix . '_level_settings' => 'g'),
				'ON'	=> 'm.group_id = g.group_id',
			),
		),

		'WHERE'		=> "m.display_on_index = 1 $forum_sql",
	);

	$sql = $db->sql_build_query('SELECT', $sql_array);
	$result = $db->sql_query($sql, 3600);

	while ($row = $db->sql_fetchrow($result))
	{
		if (!empty($row['user_id']))
		{
			$forum_moderators[$row['forum_id']][] = get_username_string('full', $row['user_id'], $row['username'], '#' . $row['user_colour']);
		}
		else
		{
			$group_name = (($row['group_type'] == 3) ? $user->lang['G_' . $row['group_name']] : $row['group_name']);

			if ($user->id != 0 && !$auth->acl_get('u_viewprofile'))
			{
				$forum_moderators[$row['forum_id']][] = '<span' . (($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . ';"' : '') . '>' . $group_name . '</span>';
			}
			else
			{
				$forum_moderators[$row['forum_id']][] = '<a' . (($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . ';"' : '') . ' href="' . append_sid("{$phpbb_root_path}userfind_to_pm.$phpEx", 'mode=group&amp;g=' . $row['group_id']) . '">' . $group_name . '</a>';
			}
		}
	}
	$db->sql_freeresult($result);

	return;
}
	function move_forum($from_id, $to_id)
	{
	global $db, $db_prefix, $user, $auth;

		$to_data = $moved_ids = $errors = array();

		// Check if we want to move to a parent with link type
		if ($to_id > 0)
		{
			$to_data = get_forum_info($to_id);

			if ($to_data['forum_type'] == 2)
			{
				$errors[] = $user->lang['PARENT_IS_LINK_FORUM'];
				return $errors;
			}
		}

		$moved_forums = get_forum_branch($from_id, 'children', 'descending');
		$from_data = $moved_forums[0];
		$diff = sizeof($moved_forums) * 2;

		$moved_ids = array();
		for ($i = 0; $i < sizeof($moved_forums); ++$i)
		{
			$moved_ids[] = $moved_forums[$i]['forum_id'];
		}

		// Resync parents
		$sql = 'UPDATE ' . $db_prefix . "_forums
			SET right_id = right_id - $diff, forum_parents = ''
			WHERE left_id < " . $from_data['right_id'] . "
				AND right_id > " . $from_data['right_id'];
		$db->sql_query($sql);

		// Resync righthand side of tree
		$sql = 'UPDATE ' . $db_prefix . "_forums
			SET left_id = left_id - $diff, right_id = right_id - $diff, forum_parents = ''
			WHERE left_id > " . $from_data['right_id'];
		$db->sql_query($sql);

		if ($to_id > 0)
		{
			// Retrieve $to_data again, it may have been changed...
			$to_data = get_forum_info($to_id);

			// Resync new parents
			$sql = 'UPDATE ' . $db_prefix . "_forums
				SET right_id = right_id + $diff, forum_parents = ''
				WHERE " . $to_data['right_id'] . ' BETWEEN left_id AND right_id
					AND ' . $db->sql_in_set('forum_id', $moved_ids, true);
			$db->sql_query($sql);

			// Resync the righthand side of the tree
			$sql = 'UPDATE ' . $db_prefix . "_forums
				SET left_id = left_id + $diff, right_id = right_id + $diff, forum_parents = ''
				WHERE left_id > " . $to_data['right_id'] . '
					AND ' . $db->sql_in_set('forum_id', $moved_ids, true);
			$db->sql_query($sql);

			// Resync moved branch
			$to_data['right_id'] += $diff;

			if ($to_data['right_id'] > $from_data['right_id'])
			{
				$diff = '+ ' . ($to_data['right_id'] - $from_data['right_id'] - 1);
			}
			else
			{
				$diff = '- ' . abs($to_data['right_id'] - $from_data['right_id'] - 1);
			}
		}
		else
		{
			$sql = 'SELECT MAX(right_id) AS right_id
				FROM ' . $db_prefix . '_forums
				WHERE ' . $db->sql_in_set('forum_id', $moved_ids, true);
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$diff = '+ ' . ($row['right_id'] - $from_data['left_id'] + 1);
		}

		$sql = 'UPDATE ' . $db_prefix . "_forums
			SET left_id = left_id $diff, right_id = right_id $diff, forum_parents = ''
			WHERE " . $db->sql_in_set('forum_id', $moved_ids);
		$db->sql_query($sql);

		return $errors;
	}
	function build_subforum_options($forum_list)
	{
		global $user;

		$s_options = '';

		$forum_list = array_merge($forum_list);

		foreach ($forum_list as $key => $row)
		{
			if ($row['disabled'])
			{
				continue;
			}

			$s_options .= '<option value="' . $row['forum_id'] . '"' . (($row['selected']) ? ' selected="selected"' : '') . '>' . $row['padding'] . $row['forum_name'];

			// We check if a branch is there...
			$branch_there = false;

			foreach (array_slice($forum_list, $key + 1) as $temp_row)
			{
				if ($temp_row['left_id'] > $row['left_id'] && $temp_row['left_id'] < $row['right_id'])
				{
					$branch_there = true;
					break;
				}
				continue;
			}

			if ($branch_there)
			{
				$s_options .= ' [' . $user->lang['PLUS_SUBFORUMS'] . ']';
			}

			$s_options .= '</option>';
		}

		return $s_options;
	}
function copy_forum_permissions($src_forum_id, $dest_forum_ids, $clear_dest_perms = true, $add_log = true)
{
	global $db, $db_prefix, $user;

	// Only one forum id specified
	if (!is_array($dest_forum_ids))
	{
		$dest_forum_ids = array($dest_forum_ids);
	}

	// Make sure forum ids are integers
	$src_forum_id = (int) $src_forum_id;
	$dest_forum_ids = array_map('intval', $dest_forum_ids);

	// No source forum or no destination forums specified
	if (empty($src_forum_id) || empty($dest_forum_ids))
	{
		return false;
	}

	// Check if source forum exists
	$sql = 'SELECT forum_name
		FROM ' . $db_prefix . 'forums
		WHERE forum_id = ' . $src_forum_id;
	$result = $db->sql_query($sql);
	$src_forum_name = $db->sql_fetchfield('forum_name');
	$db->sql_freeresult($result);

	// Source forum doesn't exist
	if (empty($src_forum_name))
	{
		return false;
	}

	// Check if destination forums exists
	$sql = 'SELECT forum_id, forum_name
		FROM ' . $db_prefix . 'forums
		WHERE ' . $db->sql_in_set('forum_id', $dest_forum_ids);
	$result = $db->sql_query($sql);

	$dest_forum_ids = $dest_forum_names = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$dest_forum_ids[]	= (int) $row['forum_id'];
		$dest_forum_names[]	= $row['forum_name'];
	}
	$db->sql_freeresult($result);

	// No destination forum exists
	if (empty($dest_forum_ids))
	{
		return false;
	}

	// From the mysql documentation:
	// Prior to MySQL 4.0.14, the target table of the INSERT statement cannot appear
	// in the FROM clause of the SELECT part of the query. This limitation is lifted in 4.0.14.
	// Due to this we stay on the safe side if we do the insertion "the manual way"

	// Rowsets we're going to insert
	$users_sql_ary = $groups_sql_ary = array();

	// Query acl users table for source forum data
	$sql = 'SELECT g_moderators, g_can_read, g_can_write, group_only, group_allow, u_moderators, u_can_read, u_can_write
		FROM ' . $db_prefix . '_forum_permissions
		WHERE forum_id = ' . $src_forum_id;
	$result = $db->sql_query($sql);

	while ($row = $db->sql_fetchrow($result))
	{
		$row = array(
			'g_moderators'			=> $row['g_moderators'],
			'g_can_read'			=> $row['g_can_read'],
			'g_can_write'			=> $row['g_can_write'],
			'group_only'			=> $row['group_only'],
			'group_allow'			=> $row['group_allow'],
			'u_moderators'			=> $row['u_moderators'],
			'u_can_read'			=> $row['u_can_read'],
			'u_can_write'			=> $row['u_can_write'],
		);

		foreach ($dest_forum_ids as $dest_forum_id)
		{
			$users_sql_ary[] = $row + array('forum_id' => $dest_forum_id);
		}
	}
	$db->sql_freeresult($result);

	if ($clear_dest_perms)
	{
		$sql = 'DELETE FROM ' . $db_prefix . '_forum_permissions
			WHERE ' . $db->sql_in_set('forum_id', $dest_forum_ids);
		$db->sql_query($sql);

	}

	$db->sql_multi_insert($db_prefix . '_forum_permissions', $users_sql_ary);

	if ($add_log)
	{
			add_log('admin','LOG_FORUM_COPIED_PERMISSIONS', $src_forum_name, implode(', ', $dest_forum_names));
	}


	return true;
}
function markread($mode, $forum_id = false, $topic_id = false, $post_time = 0, $user_id = 0)
{
	global $db, $user, $config, $db_prefix;
	//die($mode);

	if ($mode == 'all')
	{
		if ($forum_id === false || !sizeof($forum_id))
		{
			if ($user->user)
			{
				// Mark all forums read (index page)
				$db->sql_query('DELETE FROM ' . $db_prefix . "_topics_track WHERE user_id = {$user->id}");
				$db->sql_query('DELETE FROM ' . $db_prefix . "_forums_track WHERE user_id = {$user->id}");
				$db->sql_query('UPDATE ' . $db_prefix . '_users SET user_lastmark = ' . time() . " WHERE id = {$user->id}") or mysql_error();
			}
		}

		return;
	}
	else if ($mode == 'topics')
	{
		// Mark all topics in forums read
		if (!is_array($forum_id))
		{
			$forum_id = array($forum_id);
		}

		// Add 0 to forums array to mark global announcements correctly
		$forum_id[] = 0;

		if ($user->user)
		{
			$sql = 'DELETE FROM ' . $db_prefix . "_topics_track
				WHERE user_id = {$user->id}
					AND " . $db->sql_in_set('forum_id', $forum_id);
			$db->sql_query($sql);

			$sql = 'SELECT forum_id
				FROM ' . $db_prefix . "_forums_track
				WHERE user_id = {$user->id}
					AND " . $db->sql_in_set('forum_id', $forum_id);
			$result = $db->sql_query($sql);

			$sql_update = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$sql_update[] = (int) $row['forum_id'];
			}
			$db->sql_freeresult($result);

			if (sizeof($sql_update))
			{
				$sql = 'UPDATE ' . $db_prefix . '_forums_track
					SET mark_time = ' . time() . "
					WHERE user_id = {$user->id}
						AND " . $db->sql_in_set('forum_id', $sql_update);
				$db->sql_query($sql);
			}

			if ($sql_insert = array_diff($forum_id, $sql_update))
			{
				$sql_ary = array();
				foreach ($sql_insert as $f_id)
				{
					$sql_ary[] = array(
						'user_id'	=> (int) $user->id,
						'forum_id'	=> (int) $f_id,
						'mark_time'	=> time()
					);
				}

				$db->sql_multi_insert($db_prefix . "_forums_track", $sql_ary);
			}
		}

		return;
	}
	else if ($mode == 'topic')
	{
		if ($topic_id === false || $forum_id === false)
		{
			return;
		}

		if ($user->user)
		{
			$sql = 'UPDATE ' . $db_prefix . '_topics_track
				SET mark_time = ' . (($post_time) ? $post_time : time()) . "
				WHERE user_id = {$user->id}
					AND topic_id = $topic_id";
			$db->sql_query($sql);

			// insert row
			if (!$db->sql_affectedrows())
			{
				//$db->sql_return_on_error(true);

				$sql_ary = array(
					'user_id'		=> $user->id,
					'topic_id'		=> (int) $topic_id,
					'forum_id'		=> (int) $forum_id,
					'mark_time'		=> ($post_time) ? (int) $post_time : time(),
				);

				$db->sql_query('INSERT INTO ' . $db_prefix . '_topics_track ' . $db->sql_build_array('INSERT', $sql_ary));

				//$db->sql_return_on_error(false);
			}
		}

		return;
	}
	else if ($mode == 'post')
	{
		if ($topic_id === false)
		{
			return;
		}

		$use_user_id = (!$user_id) ? $user->id : $user_id;

		if ($use_user_id != 0)
		{
			//$db->sql_return_on_error(true);

			$sql_ary = array(
				'user_id'		=> (int) $use_user_id,
				'topic_id'		=> (int) $topic_id,
				'topic_posted'	=> 1
			);

			$db->sql_query('INSERT INTO ' . $db_prefix . '_topics_posted ' . $db->sql_build_array('INSERT', $sql_ary));

			//$db->sql_return_on_error(false);
		}

		return;
	}
}
function get_user_avatar($avatar, $avatar_type, $avatar_width, $avatar_height, $alt = 'USER_AVATAR')
{
	global $user, $config, $phpbb_root_path, $phpEx;

	if (empty($avatar) || !$avatar_type)
	{
		return '';
	}

	$avatar_img = '';

	switch ($avatar_type)
	{
		case 1:
			$avatar_img = $phpbb_root_path ;
		break;

		case 3:
			$avatar_img = $phpbb_root_path ;
		break;
	}

	$avatar_img .= $avatar;
	return '<img class="avatar" src="' . (str_replace(' ', '%20', $avatar_img)) . '" width="' . $avatar_width . '" height="' . $avatar_height . '" alt="' . ((!empty($user->lang[$alt])) ? $user->lang[$alt] : $alt) . '" />';
}
function update_forum_tracking_info($forum_id, $forum_last_post_time, $f_mark_time = false, $mark_time_forum = false)
{
	global $db, $tracking_topics, $user, $config, $db_prefix;

	// Determine the users last forum mark time if not given.
	if ($mark_time_forum === false)
	{
		if ($user->user)
		{
			$mark_time_forum = (!empty($f_mark_time)) ? $f_mark_time : $user->data['user_lastmark'];
		}
	}

	// Check the forum for any left unread topics.
	// If there are none, we mark the forum as read.
	if ($user->user)
	{
		if ($mark_time_forum >= $forum_last_post_time)
		{
			// We do not need to mark read, this happened before. Therefore setting this to true
			$row = true;
		}
		else
		{
			$sql = 'SELECT t.forum_id FROM ' . $db_prefix . '_topics t
				LEFT JOIN ' . $db_prefix . '_topics_track tt ON (tt.topic_id = t.topic_id AND tt.user_id = ' . $user->id . ')
				WHERE t.forum_id = ' . $forum_id . '
					AND t.topic_last_post_time > ' . $mark_time_forum . '
					AND t.topic_moved_id = 0
					AND (tt.topic_id IS NULL OR tt.mark_time < t.topic_last_post_time)
				GROUP BY t.forum_id LIMIT 1';
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}
	}
	else
	{
		$row = true;
	}

	if (!$row)
	{
		markread('topics', $forum_id);
		return true;
	}

	return false;
}
function get_complete_topic_tracking($forum_id, $topic_ids, $global_announce_list = false)
{
	global $config, $user, $db_prefix;

	$last_read = array();

	if (!is_array($topic_ids))
	{
		$topic_ids = array($topic_ids);
	}

	if ($user->user)
	{
		global $db;

		$sql = 'SELECT topic_id, mark_time
			FROM ' . $db_prefix."_topics_track
			WHERE user_id = {$user->id}
				AND " . $db->sql_in_set('topic_id', $topic_ids);
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$last_read[$row['topic_id']] = $row['mark_time'];
		}
		$db->sql_freeresult($result);

		$topic_ids = array_diff($topic_ids, array_keys($last_read));

		if (sizeof($topic_ids))
		{
			$sql = 'SELECT forum_id, mark_time
				FROM ' . $db_prefix."_forums_track
				WHERE user_id = {$user->id}
					AND forum_id " .
					(($global_announce_list && sizeof($global_announce_list)) ? "IN (0, $forum_id)" : "= $forum_id");
			$result = $db->sql_query($sql);

			$mark_time = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$mark_time[$row['forum_id']] = $row['mark_time'];
			}
			$db->sql_freeresult($result);

			$user_lastmark = (isset($mark_time[$forum_id])) ? $mark_time[$forum_id] : $user->data['user_lastmark'];

			foreach ($topic_ids as $topic_id)
			{
				if ($global_announce_list && isset($global_announce_list[$topic_id]))
				{
					$last_read[$topic_id] = (isset($mark_time[0])) ? $mark_time[0] : $user_lastmark;
				}
				else
				{
					$last_read[$topic_id] = $user_lastmark;
				}
			}
		}
	}

	return $last_read;
}
?>