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
** File functions.php 2018-02-18 14:32:00 joeroberts
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
// This file contains Bit Torrent main functions. MUST be included before every
// other file at the beginning of any script
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (!function_exists("sha1")) require_once("include/sha1lib.php");
function append_sid($base, $link = false, $is_amp = true){
	$params_is_array = is_array($link);

	// Get anchor
	$anchor = '';
	if (strpos($base, '#') !== false)
	{
		list($base, $anchor) = explode('#', $base, 2);
		$anchor = '#' . $anchor;
	}
	else if (!$params_is_array && strpos($link, '#') !== false)
	{
		list($link, $anchor) = explode('#', $link, 2);
		$anchor = '#' . $anchor;
	}
	if (!$params_is_array && !$anchor)
	{
		if ($link === false)
		{
			return $base;
		}

	$amp_delim = ($is_amp) ? '&amp;' : '&';
		$url_delim = (strpos($base, '?') === false) ? '?' : (($is_amp) ? '&amp;' : '&');
	$append_url = (!empty($_EXTRA_URL)) ? implode($amp_delim, $_EXTRA_URL) : '';
		return $base . ($link !== false ? $url_delim. $link : '');
	}
	$amp_delim = ($is_amp) ? '&amp;' : '&';
	$url_delim = (strpos($base, '?') === false) ? '?' : $amp_delim;
	if ($link === false)
	{
			return $base . (($append_url) ? $url_delim . $append_url : '') . $anchor;
	}
	// Build string if parameters are specified as array
	if (is_array($link))
	{
		$output = array();

		foreach ($link as $key => $item)
		{
			if ($item === NULL)
			{
				continue;
			}

			if ($key == '#')
			{
				$anchor = '#' . $item;
				continue;
			}

			$output[] = $key . '=' . $item;
		}

		$link = implode($amp_delim, $output);
	}
	return $base . ((isset($append_url)) ? $url_delim . $append_url . $amp_delim : $url_delim) . $link .  $anchor;
//return $base . '?'. $link;
}
function make_clickable($text, $server_url = false, $class = 'postlink')
{

	static $magic_url_match;
	static $magic_url_replace;
	static $static_class;

	if (!is_array($magic_url_match) || $static_class != $class)
	{
		$static_class = $class;
		$class = ($static_class) ? ' class="' . $static_class . '"' : '';
		$local_class = ($static_class) ? ' class="' . $static_class . '-local"' : '';

		$magic_url_match = $magic_url_replace = array();
		// Be sure to not let the matches cross over. ;)

		// relative urls for this board
		$magic_url_match[] = '#(^|[\n\t (>.])(' . preg_quote($server_url, '#') . ')/(' . get_preg_expression('relative_url_inline') . ')#ie';
		$magic_url_replace[] = "make_clickable_callback(3, '\$1', '\$2', '\$3', '$local_class')";

		// matches a xxxx://aaaaa.bbb.cccc. ...
		$magic_url_match[] = '#(^|[\n\t (>.])(' . get_preg_expression('url_inline') . ')#ie';
		$magic_url_replace[] = "make_clickable_callback(2, '\$1', '\$2', '', '$class')";

		// matches a "www.xxxx.yyyy[/zzzz]" kinda lazy URL thing
		$magic_url_match[] = '#(^|[\n\t (>])(' . get_preg_expression('www_url_inline') . ')#ie';
		$magic_url_replace[] = "make_clickable_callback(4, '\$1', '\$2', '', '$class')";

		// matches an email@domain type address at the start of a line, or after a space or after what might be a BBCode.
		$magic_url_match[] = '/(^|[\n\t (>])(' . get_preg_expression('email') . ')/ie';
		$magic_url_replace[] = "make_clickable_callback(1, '\$1', '\$2', '', '')";
	}

	return preg_replace($magic_url_match, $magic_url_replace, $text);
}
function make_clickable_callback($type, $whitespace, $url, $relative_url, $class)
{
	$orig_url		= $url;
	$orig_relative	= $relative_url;
	$append			= '';
	$url			= htmlspecialchars_decode($url);
	$relative_url	= htmlspecialchars_decode($relative_url);

	// make sure no HTML entities were matched
	$chars = array('<', '>', '"');
	$split = false;

	foreach ($chars as $char)
	{
		$next_split = strpos($url, $char);
		if ($next_split !== false)
		{
			$split = ($split !== false) ? min($split, $next_split) : $next_split;
		}
	}

	if ($split !== false)
	{
		// an HTML entity was found, so the URL has to end before it
		$append			= substr($url, $split) . $relative_url;
		$url			= substr($url, 0, $split);
		$relative_url	= '';
	}
	else if ($relative_url)
	{
		// same for $relative_url
		$split = false;
		foreach ($chars as $char)
		{
			$next_split = strpos($relative_url, $char);
			if ($next_split !== false)
			{
				$split = ($split !== false) ? min($split, $next_split) : $next_split;
			}
		}

		if ($split !== false)
		{
			$append			= substr($relative_url, $split);
			$relative_url	= substr($relative_url, 0, $split);
		}
	}

	// if the last character of the url is a punctuation mark, exclude it from the url
	$last_char = ($relative_url) ? $relative_url[strlen($relative_url) - 1] : $url[strlen($url) - 1];

	switch ($last_char)
	{
		case '.':
		case '?':
		case '!':
		case ':':
		case ',':
			$append = $last_char;
			if ($relative_url)
			{
				$relative_url = substr($relative_url, 0, -1);
			}
			else
			{
				$url = substr($url, 0, -1);
			}
		break;

		// set last_char to empty here, so the variable can be used later to
		// check whether a character was removed
		default:
			$last_char = '';
		break;
	}

	$short_url = (strlen($url) > 55) ? substr($url, 0, 39) . ' ... ' . substr($url, -10) : $url;

	switch ($type)
	{
		case 3:
			$tag			= 'l';
			$relative_url	= preg_replace('/[&?]sid=[0-9a-f]{32}$/', '', preg_replace('/([&?])sid=[0-9a-f]{32}&/', '$1', $relative_url));
			$url			= $url . '/' . $relative_url;
			$text			= $relative_url;

			// this url goes to http://domain.tld/path/to/board/ which
			// would result in an empty link if treated as local so
			// don't touch it and let MAGIC_URL_FULL take care of it.
			if (!$relative_url)
			{
				return $whitespace . $orig_url . '/' . $orig_relative; // slash is taken away by relative url pattern
			}
		break;

		case 2:
			$tag	= 'm';
			$text	= $short_url;
		break;

		case 4:
			$tag	= 'w';
			$url	= 'http://' . $url;
			$text	= $short_url;
		break;

		case 1:
			$tag	= 'e';
			$text	= $short_url;
			$url	= 'mailto:' . $url;
		break;
	}

	$url	= htmlspecialchars($url);
	$text	= htmlspecialchars($text);
	$append	= htmlspecialchars($append);

	$html	= "$whitespace<!-- $tag --><a$class href=\"$url\">$text</a><!-- $tag -->$append";

	return $html;
}
function get_preg_expression($mode)
{
	switch ($mode)
	{
		case 'email':
			return '(?:[a-z0-9\'\.\-_\+\|]++|&amp;)+@[a-z0-9\-]+\.(?:[a-z0-9\-]+\.)*[a-z]+';
		break;

		case 'bbcode_htm':
			return array(
				'#<!\-\- e \-\-><a href="mailto:(.*?)">.*?</a><!\-\- e \-\->#',
				'#<!\-\- l \-\-><a (?:class="[\w-]+" )?href="(.*?)(?:(&amp;|\?)sid=[0-9a-f]{32})?">.*?</a><!\-\- l \-\->#',
				'#<!\-\- ([mw]) \-\-><a (?:class="[\w-]+" )?href="(.*?)">.*?</a><!\-\- \1 \-\->#',
				'#<!\-\- s(.*?) \-\-><img src="\smiles\/.*? \/><!\-\- s\1 \-\->#',
				'#<!\-\- .*? \-\->#s',
				'#<.*?>#s',
			);
		break;

		// Whoa these look impressive!
		// The code to generate the following two regular expressions which match valid IPv4/IPv6 addresses
		// can be found in the develop directory
		case 'ipv4':
			return '#^(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$#';
		break;

		case 'ipv6':
			return '#^(?:(?:(?:[\dA-F]{1,4}:){6}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:::(?:[\dA-F]{1,4}:){5}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:):(?:[\dA-F]{1,4}:){4}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,2}:(?:[\dA-F]{1,4}:){3}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,3}:(?:[\dA-F]{1,4}:){2}(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,4}:(?:[\dA-F]{1,4}:)(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,5}:(?:[\dA-F]{1,4}:[\dA-F]{1,4}|(?:(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?:\d{1,2}|1\d\d|2[0-4]\d|25[0-5])))|(?:(?:[\dA-F]{1,4}:){1,6}:[\dA-F]{1,4})|(?:(?:[\dA-F]{1,4}:){1,7}:))$#i';
		break;

		case 'url':
		case 'url_inline':
			$inline = ($mode == 'url') ? ')' : '';
			$scheme = ($mode == 'url') ? '[a-z\d+\-.]' : '[a-z\d+]'; // avoid automatic parsing of "word" in "last word.http://..."
			// generated with regex generation file in the develop folder
			return "[a-z]$scheme*:/{2}(?:(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})+|[0-9.]+|\[[a-z0-9.]+:[a-z0-9.]+:[a-z0-9.:]+\])(?::\d*)?(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
		break;

		case 'www_url':
		case 'www_url_inline':
			$inline = ($mode == 'www_url') ? ')' : '';
			return "www\.(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})+(?::\d*)?(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
		break;

		case 'relative_url':
		case 'relative_url_inline':
			$inline = ($mode == 'relative_url') ? ')' : '';
			return "(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*(?:/(?:[a-z0-9\-._~!$&'($inline*+,;=:@|]+|%[\dA-F]{2})*)*(?:\?(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?(?:\#(?:[a-z0-9\-._~!$&'($inline*+,;=:@/?|]+|%[\dA-F]{2})*)?";
		break;
	}

	return '';
}
function generate_text_for_display($text, $uid, $bitfield, $flags)
{
	static $bbcode;

	if (!$text)
	{
		return '';
	}

	$text = censor_text($text);

	// Parse bbcode if bbcode uid stored and bbcode enabled
	if ($uid && ($flags & 1))
	{
		if (!class_exists('bbcode'))
		{
			global $phpEx;
			include('./include/bbcode.' . $phpEx);
		}

		if (empty($bbcode))
		{
			$bbcode = new bbcode($bitfield);
		}
		else
		{
			$bbcode->bbcode($bitfield);
		}

		$bbcode->bbcode_second_pass($text, $uid);
	}

	//$text = bbcode_nl2br($text);
	//$text = smiley_text($text, !($flags & 2));

	return $text;
}
function generate_text_for_storage(&$text, &$uid, &$bitfield, &$flags, $allow_bbcode = false, $allow_urls = false, $allow_smilies = false)
{
	global $phpbb_root_path, $phpEx;

	$uid = $bitfield = '';
	$flags = (($allow_bbcode) ? 1 : 0) + (($allow_smilies) ? 2 : 0) + (($allow_urls) ? 4 : 0);

	if (!$text)
	{
		return;
	}

	if (!class_exists('parse_message'))
	{
		include('include/message_parser.' . $phpEx);
	}

	$message_parser = new parse_message($text);
	$message_parser->parse($allow_bbcode, $allow_urls, $allow_smilies);

	$text = $message_parser->message;
	$uid = $message_parser->bbcode_uid;

	// If the bbcode_bitfield is empty, there is no need for the uid to be stored.
	if (!$message_parser->bbcode_bitfield)
	{
		$uid = '';
	}

	$bitfield = $message_parser->bbcode_bitfield;

	return;
}
function pmbt_trigger_error($message='', $var = false, $meta = false, $rtime = '30'){
	global $template, $user;
	if(!isset($template))$template = new Template();
              set_site_var('- '.(($var)? $var : $user->lang['USER_CPANNEL']) . ' - ' . $user->lang['ACCESS_DENIED']);
                                $template->assign_vars(array(
								        'S_ERROR_HEADER'          =>	$user->lang['ACCESS_DENIED'],
                                        'S_ERROR_MESS'            =>	$message,
                                ));
			if($meta)meta_refresh($rtime, $meta);
             echo $template->fetch('error.html');
             close_out();
}
function meta_refresh($time, $url, $disable_cd_check = false)
{
	global $template;
	$url = str_replace('&amp;', '&', $url);
	// For XHTML compatibility we change back & to &amp;
	$template->assign_vars(array(
		'META' 		=> '<meta http-equiv="refresh" content="' . $time . ';url=' . $url . '" >',
		'S_REFRESH'	=>	true
	));

	return '<meta http-equiv="refresh" content="' . $time . ';url=' . $url . '" >';
}
define('STRIP', (get_magic_quotes_gpc()) ? true : false);
function set_var(&$result, $var, $type, $multibyte = false)
{
	settype($var, $type);
	$result = $var;

	if ($type == 'string')
	{
		$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $result), ENT_COMPAT, 'UTF-8'));

		if (!empty($result))
		{
			// Make sure multibyte characters are wellformed
			if ($multibyte)
			{
				if (!preg_match('/^./u', $result))
				{
					$result = '';
				}
			}
			else
			{
				// no multibyte, allow only ASCII (0-127)
				$result = preg_replace('/[\x80-\xFF]/', '?', $result);
			}
		}

		$result = (STRIP) ? stripslashes($result) : $result;
	}
}
function codeToMessage($code)
{
	switch ($code) {
		case UPLOAD_ERR_OK:
			return false;
			break;
		case UPLOAD_ERR_INI_SIZE:
			$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
			break;
		case UPLOAD_ERR_FORM_SIZE:
			$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
			break;
		case UPLOAD_ERR_PARTIAL:
			$message = "The uploaded file was only partially uploaded";
			break;
		case UPLOAD_ERR_NO_FILE:
			$message = "No file was uploaded";
			break;
		case UPLOAD_ERR_NO_TMP_DIR:
			$message = "Missing a temporary folder";
			break;
		case UPLOAD_ERR_CANT_WRITE:
			$message = "Failed to write file to disk";
			break;
		case UPLOAD_ERR_EXTENSION:
			$message = "File upload stopped by extension";
			break;

		default:
			$message = "Unknown upload error";
			break;
	}
	return $message;
} 
function request_var($var_name, $default, $multibyte = false, $cookie = false, $is_file = false)
{
	if ($is_file)
	{
		if($_FILES[$var_name])
		{
			return $_FILES[$var_name];
		}
		return array( 'name' => '', 'type' => '', 'tmp_name' => '', 'error' => 10, 'size' => 0);
	}
	if (!$cookie && isset($_COOKIE[$var_name]))
	{
		if (!isset($_GET[$var_name]) && !isset($_POST[$var_name]))
		{
			return (is_array($default)) ? array() : $default;
		}
		$_REQUEST[$var_name] = isset($_POST[$var_name]) ? $_POST[$var_name] : $_GET[$var_name];
	}

	$super_global = ($cookie) ? '_COOKIE' : '_REQUEST';
	if (!isset($GLOBALS[$super_global][$var_name]) || is_array($GLOBALS[$super_global][$var_name]) != is_array($default))
	{
		return (is_array($default)) ? array() : $default;
	}

	$var = $GLOBALS[$super_global][$var_name];
	if (!is_array($default))
	{
		$type = gettype($default);
	}
	else
	{
		list($key_type, $type) = each($default);
		$type = gettype($type);
		$key_type = gettype($key_type);
		if ($type == 'array')
		{
			reset($default);
			$default = current($default);
			list($sub_key_type, $sub_type) = each($default);
			$sub_type = gettype($sub_type);
			$sub_type = ($sub_type == 'array') ? 'NULL' : $sub_type;
			$sub_key_type = gettype($sub_key_type);
		}
	}

	if (is_array($var))
	{
		$_var = $var;
		$var = array();

		foreach ($_var as $k => $v)
		{
			set_var($k, $k, $key_type);
			if ($type == 'array' && is_array($v))
			{
				foreach ($v as $_k => $_v)
				{
					if (is_array($_v))
					{
						$_v = null;
					}
					set_var($_k, $_k, $sub_key_type, $multibyte);
					set_var($var[$k][$_k], $_v, $sub_type, $multibyte);
				}
			}
			else
			{
				if ($type == 'array' || is_array($v))
				{
					$v = null;
				}
				set_var($var[$k], $v, $type, $multibyte);
			}
		}
	}
	else
	{
		set_var($var, $var, $type, $multibyte);
	}

	return $var;
}
function sch_get_consant($value)
{
    $constants = get_defined_constants();
    $name = array_search($value, $constants, TRUE);   
    return $name;
}
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = false, $tpl_prefix = '')
{
	global $template, $user;

	// Make sure $per_page is a valid value
	$per_page = ($per_page <= 0) ? 1 : $per_page;

	$seperator = '<span class="page-sep">, </span>';
	$total_pages = ceil($num_items / $per_page);

	if ($total_pages == 1 || !$num_items)
	{
		return false;
	}

	$on_page = floor($start_item / $per_page) + 1;
	$url_delim = (strpos($base_url, '?') === false) ? '?' : '&amp;';

	$page_string = ($on_page == 1) ? '<strong>1</strong>' : '<a href="' . $base_url . '">1</a>';

	if ($total_pages > 5)
	{
		$start_cnt = min(max(1, $on_page - 4), $total_pages - 5);
		$end_cnt = max(min($total_pages, $on_page + 4), 6);

		$page_string .= ($start_cnt > 1) ? ' ... ' : $seperator;

		for ($i = $start_cnt + 1; $i < $end_cnt; $i++)
		{
			$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}page=" . $i . '">' . $i . '</a>';
			if ($i < $end_cnt - 1)
			{
				$page_string .= $seperator;
			}
		}

		$page_string .= ($end_cnt < $total_pages) ? ' ... ' : $seperator;
	}
	else
	{
		$page_string .= $seperator;

		for ($i = 2; $i < $total_pages; $i++)
		{
			$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . "{$url_delim}page=" . $i . '">' . $i . '</a>';
			if ($i < $total_pages)
			{
				$page_string .= $seperator;
			}
		}
	}

	$page_string .= ($on_page == $total_pages) ? '<strong>' . $total_pages . '</strong>' : '<a href="' . $base_url . "{$url_delim}page=" . $total_pages . '">' . $total_pages . '</a>';

	if ($add_prevnext_text)
	{
		if ($on_page != 1)
		{
			$page_string = '<a href="' . $base_url . "{$url_delim}page=" . ($on_page - 1) . '">'.$user->lang['PREVEASE'].'</a>&nbsp;&nbsp;' . $page_string;
		}

		if ($on_page != $total_pages)
		{
			$page_string .= '&nbsp;&nbsp;<a href="' . $base_url . "{$url_delim}page=" . ($on_page +1) . '">'.$user->lang['NEXT'].'</a>';
		}
	}

	$template->assign_vars(array(
		$tpl_prefix . 'BASE_URL'		=> $base_url,
		'A_' . $tpl_prefix . 'BASE_URL'	=> addslashes($base_url),
		$tpl_prefix . 'PER_PAGE'		=> $per_page,

		$tpl_prefix . 'PREVIOUS_PAGE'	=> ($on_page == 1) ? '' : $base_url . "{$url_delim}page=" . ($on_page - 1),
		$tpl_prefix . 'NEXT_PAGE'		=> ($on_page == $total_pages) ? '' : $base_url . "{$url_delim}page=" . ($on_page + 1),
		$tpl_prefix . 'TOTAL_PAGES'		=> $total_pages,
	));

	return $page_string;
}
function on_page($num_items, $per_page, $start)
{
	global $template, $user;
	// Make sure $per_page is a valid value
	$per_page = ($per_page <= 0) ? 1 : $per_page;

	$on_page = floor($start / $per_page) + 1;

	$template->assign_vars(array(
		'ON_PAGE'		=> $on_page)
	);

	return sprintf($user->lang['PAGE_OF'], $on_page, max(ceil($num_items / $per_page), 1));
}
#DEPRICATED FUNCTION
function format_date2($gmepoch, $format = false, $forcedate = false)
	{
		global $midnight,$u_datetime,$user,$db, $db_prefix;
		return $user->format_date($gmepoch, $format, $forcedate);
			list($d, $m, $y) = explode(' ', gmdate('j n Y', time() + $zone_offset));
			$midnight = gmmktime(0, 0, 0, $m, $d, $y) +get_user_timezone($user->id);

		$lang_dates = $user->lang['u_datetime'];
		$format = (!$format) ? 'D M d, Y g:i a' : $format;
		

		// Short representation of month in format
		if ((strpos($format, '\M') === false && strpos($format, 'M') !== false) || (strpos($format, '\r') === false && strpos($format, 'r') !== false))
		{
			$lang_dates['May'] = $lang_dates['May_short'];
		}

		unset($lang_dates['May_short']);

		if (!$midnight)
		{
			list($d, $m, $y) = explode(' ', gmdate('j n Y', time() + 0 + 3600));
			$midnight = gmmktime(0, 0, 0, $m, $d, $y) - 7200;
		}

		if (strpos($format, '|') === false || ($gmepoch < $midnight - 86400 && !$forcedate) || ($gmepoch > $midnight + 172800 && !$forcedate))
		{
			return strtr(@gmdate(str_replace('|', '', $format), $gmepoch +7200), $lang_dates);
		}

		if ($gmepoch > $midnight + 86400 && !$forcedate)
		{
			$format = substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1);
			return str_replace('||', $u_datetime['TOMORROW'], strtr(@gmdate($format, $gmepoch +7200), $lang_dates));
		}
		else if ($gmepoch > $midnight && !$forcedate)
		{
			$format = substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1);
			return str_replace('||', $u_datetime['TODAY'], strtr(@gmdate($format, $gmepoch +7200), $lang_dates));
		}
		else if ($gmepoch > $midnight - 86400 && !$forcedate)
		{
			$format = substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1);
			return str_replace('||', $u_datetime['YESTERDAY'], strtr(@gmdate($format, $gmepoch +7200), $lang_dates));
		}

		return strtr(@gmdate(str_replace('|', '', $format), $gmepoch +7200), $lang_dates);
	}
function confirm_box($check, $title = '', $hidden = '', $html_body = 'confirm_body.html', $u_action = '', $gfx = false)
{
	global $user, $template, $db, $gfx_check, $recap_puplic_key, $recap_private_key;
	$gfx = $gfx_check;
	if (isset($_POST['cancel']))
	{
		return false;
	}
	$confirm = false;
	if (isset($_POST['confirm']))
	{
		// language frontier
		if ($_POST['confirm'] === $user->lang['YES'])
		{
			$confirm = true;
		}
	}

	if ($check && $confirm)
	{
		$user_id 					= request_var('user_id', 0);
		$session_id 				= request_var('sess', '');
		$confirm_key				= request_var('confirm_key', '');
		$gfxcheck 					= request_var('gfxcheck', '');
		$gfxcode 					= request_var('gfxcode', '');
		$gfxcon 					= request_var('gfxcon', '');
		$recaptcha_response_field	= request_var('g-recaptcha-response', '');
		$recap_pass = true;
		if ($gfx_check AND $recap_puplic_key)
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recap_private_key."&response=".$recaptcha_response_field."&remoteip=".$ip);
			$responseKeys = json_decode($response,true);	     
			$recap_pass = intval($responseKeys["success"]) !== 1 ? false : true;
		}
		if($gfxcon == '1')
		{
			if($gfx_check AND $gfxcheck != md5(strtoupper($gfxcode)) AND !$recap_pass)
			{
				return false;
			}
		}

		if ($user_id != $user->id ||  !$confirm_key )
		{
			return false;
		}

		return true;
	}
	else if ($check)
	{
		return false;
	}
	$rnd_code	=	'';
	if($gfx)
	{
		$rnd_code = strtoupper(RandomAlpha(5));
	}
	$s_hidden_fields = build_hidden_fields(array(
		'user_id'	=> $user->id,
		'sess'		=> $user->session_id,
		'sid'		=> $user->session_id,
		'gfxcheck'	=>	($gfx)?md5($rnd_code):'',
		'gfxcon'	=>	($gfx)? '1':'0',)
	);

	// generate activation key
	$confirm_key = RandomAlpha(10);
	if ($gfx_check) {
		if($recap_puplic_key)
		{
		   $template->assign_vars(array(
					'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
					'RECAPTCHA'					=>	$recap_puplic_key,

			));
		}
	}


	// If activation key already exist, we better do not re-use the key (something very strange is going on...)
	if (request_var('confirm_key', ''))
	{
		// This should not occur, therefore we cancel the operation to safe the user
		return false;
	}
	$u_action .= ((strpos($u_action, '?') === false) ? '?' : '&amp;') . 'confirm_key=' . $confirm_key;
	$template->assign_vars(array(
		'MESSAGE_TITLE'		=> (!isset($user->lang[$title])) ? ((defined('_'.$title)) ? constant('_'.$title) : 'CONFIRM') : $user->lang[$title],
		'MESSAGE_TEXT'		=> (!isset($user->lang[$title . '_CONFIRM'])) ? ((defined('_'.$title.'_CONFIRM')) ? constant('_'.$title.'_CONFIRM') : ($title == '')?'_CONFIRM':$title) : $user->lang[$title . '_CONFIRM'],

		'YES_VALUE'			=> $user->lang['YES'],
		'S_CONFIRM_ACTION'	=> $u_action,
		'S_HIDDEN_FIELDS'	=> $hidden . $s_hidden_fields,
		'S_GFX'				=>	($gfx)?true:false,
		'GFX_CODE'			=>	base64_encode($rnd_code),)
	);
			  echo $template->fetch($html_body);
			  die;
}
function build_hidden_fields($field_ary, $specialchar = false, $stripslashes = false)
{
	$s_hidden_fields = '';

	foreach ($field_ary as $name => $vars)
	{
		$name = ($stripslashes) ? stripslashes($name) : $name;
		$name = ($specialchar) ? htmlspecialchars($name, ENT_COMPAT, 'UTF-8') : $name;

		$s_hidden_fields .= _build_hidden_fields($name, $vars, $specialchar, $stripslashes);
	}

	return $s_hidden_fields;
}
function _build_hidden_fields($key, $value, $specialchar, $stripslashes)
{
	$hidden_fields = '';

	if (!is_array($value))
	{
		$value = ($stripslashes) ? stripslashes($value) : $value;
		$value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;

		$hidden_fields .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
	}
	else
	{
		foreach ($value as $_key => $_value)
		{
			$_key = ($stripslashes) ? stripslashes($_key) : $_key;
			$_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;

			$hidden_fields .= _build_hidden_fields($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
		}
	}

	return $hidden_fields;
}
function get_u_ratio($upload, $download)
{
        if ($upload == 0 AND $download == 0) return "---";
        elseif ($download == 0) return "&infin;";
        else {
                $ratio = $upload/$download;

                if ($ratio < 0.1) $ratio = "<font color=\"#ff0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.2) $ratio = "<font color=\"#ee0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.3) $ratio = "<font color=\"#dd0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.4) $ratio = "<font color=\"#cc0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.5) $ratio = "<font color=\"#bb0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.6) $ratio = "<font color=\"#aa0000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.7) $ratio = "<font color=\"#990000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.8) $ratio = "<font color=\"#880000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 0.9) $ratio = "<font color=\"#770000\">" . number_format($ratio, 2) . "</font>";
                elseif ($ratio < 1)   $ratio = "<font color=\"#660000\">" . number_format($ratio, 2) . "</font>";
                else $ratio = "<font color=\"#00FF00\">".  number_format($ratio, 2) . "</font>";
        }
		return $ratio;
}
function bt_shout($user, $text, $id_to = 0){
        global $db, $db_prefix;
		if(!isset($user, $text)){
		}
                $db->sql_query("INSERT INTO ".$db_prefix."_shouts (user, text, posted, id_to) VALUES ('".$user."', '".$text."', NOW(), '".$id_to."');");
}
/*---------------------------------
ERROR HANDLING FUNCTIONS
----------------------------------*/
function add_log()
{
        global $db, $db_prefix, $user;
	$args = func_get_args();

	$mode			= array_shift($args);
	$reportee_id	= ($mode == 'user') ? intval(array_shift($args)) : '';
	$forum_id		= ($mode == 'mod') ? intval(array_shift($args)) : '';
	$topic_id		= ($mode == 'mod') ? intval(array_shift($args)) : '';
	$action			= array_shift($args);
	$data			= (!sizeof($args)) ? '' : serialize($args);
	//die(print_r($data));
	return logerror(array($mode,$reportee_id,$forum_id,$topic_id,$action,$data));
}
function logerror($message, $error = '',$tid = 0) {
        global $db, $db_prefix, $user;
		if($error == '')$error = $user->lang['BT_ERROR'];
			$ip = getip();
			$host = gethostbyaddr($ip);
			$ip = sprintf("%u",ip2long($ip));
		 if(is_array($message))
		 {
			$log_type = (($message[0] == 'admin')? '0' : ($message[0] == 'mod')? '1' : ($message[0] == 'critical')? '2' : '3');
			$mode			=	$message[0];
			$reportee_id	= $message[1];
			$forum_id		= $message[2];
			$topic_id		= $message[3];
			$action			= $message[4];
			$data			= $message[5];
			$sql_ary = array(
				'userid'		=> $user->id,
				'ip'		=> $ip,
				'host'		=> $host,
				'action'	=> $action,
				'results'		=> $data,
			);
			switch ($mode)
			{
				case 'admin':
					$sql_ary['log_type'] = '0';
				break;
		
				case 'mod':
					$sql_ary += array(
						'log_type'	=> '1',
						'forum_id'	=> $forum_id,
						'topic_id'	=> $topic_id
					);
				break;
		
				case 'user':
					$sql_ary += array(
						'log_type'		=> '3',
						'reportee_id'	=> $reportee_id
					);
				break;
		
				case 'critical':
					$sql_ary['log_type'] = '2';
				break;
		
				default:
					return false;
			}
		 }
		 else
		 {
			$error = $db->sql_escape(stripslashes($error));
			$message = $db->sql_escape(stripslashes($message));
			$sql_ary = array(
				'userid'		=> $user->id,
				'ip'		=> $ip,
				'host'		=> $host,
				'action'	=> $error,
				'results'		=> $message,
			);
			$sql_ary['log_type'] = '3';
			switch ($error)
			{
				case 'admin':
					$sql_ary['log_type'] = '0';
				break;
				case "HNR Demotion":
					$sql_ary['log_type'] = '1';
				break;
				case 'Failed Login':
				case 'user':
					$sql_ary['log_type'] = '3';
				break;
				case 'Donation':
				case "Data base sql error":
				case 'system':
					$sql_ary['log_type'] = '2';
				break;
			}
		}
       $sql = "INSERT INTO ".$db_prefix."_log " . $db->sql_build_array('INSERT', $sql_ary);
        $db->sql_query($sql);
        return $db->sql_nextid();
}
function getlevel_name($userid){
        global $db, $db_prefix;
			$sql = "SELECT `can_do` FROM ".$db_prefix."_users WHERE `id` = '".$userid."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "0";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['can_do'];
			}
}
function is_founder($id)//group_founder_manage
{
        global $db, $db_prefix, $user;
			$sql = "SELECT user_type FROM ".$db_prefix."_users WHERE `id` = " . $id . ";";
			$res = $db->sql_query($sql);
            if ($db->sql_numrows($res) == 0) return false;
			else{
			$row = $db->sql_fetchrow($res);
		    return ($row['user_type'] == 3)? true : false;
			}
}
function getlevel($can_do = 0){
        global $db, $db_prefix, $user;
			$sql = "SELECT group_name FROM ".$db_prefix."_level_settings WHERE `group_id` = " . $can_do . ";";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "guest";
			else{
			$row = $db->sql_fetchrow($res);
		    return ($user->lang[$row['group_name']])? $user->lang[$row['group_name']] : $row['group_name'];
			}
}
function getMetaTitle($content){
	if($user->id == 1)echo "||".$content."||";

if(!@file ("$content"))return $content;
$fcontents = implode ('', file ("$content"));
$fcontents = stristr($fcontents, '<title>');
$rest = substr($fcontents, 7);$extra = stristr($fcontents, '</title>');
$titlelen = strlen($rest) - strlen($extra);
$gettitle = trim(substr($rest, 0, $titlelen));
if($gettitle == "")return $content;
return $gettitle;
}
function getusercolor($level){
        global $db, $db_prefix;
			$sql = "SELECT group_colour FROM ".$db_prefix."_level_settings WHERE `group_id` = '".$level."';";
			$res = $db->sql_query($sql);
			$con = $db->sql_numrows($res);
			if($con == 0)return $level;
			$row = $db->sql_fetchrow($res);
		return '#'.$row['group_colour'];
}
function selectaccess($al= false){
        global $db, $db_prefix, $user;
			$sql = "SELECT level as level, name as name FROM ".$db_prefix."_levels;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$level = '<select name="group">';
		while ($tracker = $db->sql_fetchrow($res))
			{
				if($user->group =="1" AND $tracker['level'] == "1")continue;
				$level .= '<option ';
				if(isset($al) && $al == $tracker['level'])$level .= 'selected="selected"';
				$level .= 'value="'.$tracker['level'].'">'.$tracker['name'].'</option>';
			}
			$level .= '</select>';
			$db->sql_freeresult($res);
		return $level;
}
  function hitrun($hnrid = 0)
  {
        global $db, $db_prefix;
		if($hnrid == 0) return false;
			$sql = "SELECT `level`, dongift, can_do FROM ".$db_prefix."_users WHERE `id` = '".$hnrid."';";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			if($row['level']=='admin')return false;
			if($row['dongift']==2)return false;
			$sql2 = "SELECT `u_hit_run` FROM ".$db_prefix."_levels WHERE `level` = '".$row['can_do']."'";
			$res2 = $db->sql_query($sql2) or btsqlerror($sql2);
			$row2 = $db->sql_fetchrow($res2);
			if($row2['u_hit_run'] == 'true')return false;
			else return true;
  }
function decode_message(&$message, $bbcode_uid = '')
{
	global $config;

	if ($bbcode_uid)
	{
		$match = array('<br />', "[/*:m:$bbcode_uid]", ":u:$bbcode_uid", ":o:$bbcode_uid", ":$bbcode_uid");
		$replace = array("\n", '', '', '', '');
	}
	else
	{
		$match = array('<br />');
		$replace = array("\n");
	}

	$message = str_replace($match, $replace, $message);

	$match = get_preg_expression('bbcode_htm');
	$replace = array('\1', '\1', '\2', '\1', '', '');

	$message = preg_replace($match, $replace, $message);
}
function checkaccess_array()
{
        global $db, $db_prefix, $user,$_COOKIE;
		$args = func_get_args();
		$f = array_pop($args);

		if (!is_numeric($f))
		{
			$args[] = $f;
			$f = 0;
		}
		if (is_array($args[0]))
		{
			$args = $args[0];
		}

		$acl = 0;
		foreach ($args as $opt)
		{
			$acl |= checkaccess($opt, $f);
		}

		return $acl;
}
function checkaccess($access){
        global $db, $db_prefix, $user,$_COOKIE;
			$sql = "SELECT ".$access." FROM ".$db_prefix."_levels WHERE `group_id` = '".$user->group."';";
			$res = $db->sql_query($sql);
			$row = $db->sql_fetchrow($res);
			if($user->level != "guest")
			{
        $userdata = cookie_decode($_COOKIE["btuser"]);
        if ($userdata[0] != $user->id) return false;
        if (addslashes($userdata[1]) != $user->name) return false;
        $sql = "SELECT id FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND username = '".$user->name."' AND act_key = '".addslashes($userdata[3])."' AND password = '".addslashes($userdata[2])."';";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        $n = $db->sql_numrows($res);
        $db->sql_freeresult($res);
        if (!$n) return false;
		}
		if($user->user_type==3)return true;
		//echo $row[$access];
			if($row[$access] == "true")return true;
			else
			return false;
}
function sqlerr($sql = ''){
return  btsqlerror($sql);
}
function ip_first($ips) {
  if (($pos = strpos($ips, ',')) != false) {
    return substr($ips, 0, $pos);
  } else {
    return $ips;
  }
}

function ip_valid($ips) {
  if (isset($ips)) {
    $ip    = ip_first($ips);
    $ipnum = ip2long($ip);
    if ($ipnum !== -1 && $ipnum !== false && (long2ip($ipnum) === $ip)) { // PHP 4 and PHP 5
      if (($ipnum < 167772160   || $ipnum >   184549375) && // Not in 10.0.0.0/8
          ($ipnum < -1408237568 || $ipnum > -1407188993) && // Not in 172.16.0.0/12
          ($ipnum < -1062731776 || $ipnum > -1062666241))   // Not in 192.168.0.0/16
        return true;
    }
  }
  return false;
}

function getip() {
  $check = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
                 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
                 'HTTP_VIA', 'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM');

if (isset($_SERVER)) { 
  foreach ($check as $c) {
    if (@ip_valid($_SERVER[$c])) {
      return ip_first($_SERVER[$c]);
    }
  }

  return ((isset($_SERVER['REMOTE_ADDR']))? $_SERVER['REMOTE_ADDR'] : '0.0.0.0');
} else { 
  foreach ($check as $c) {
    if (ip_valid(getenv($c))) {
      return ip_first(getenv($c));
    }
  }
  return getenv('REMOTE_ADDR');
}
}

function get_user_timezone($id) {
        global $db, $db_prefix, $user;
  if ($user->user){
	   $sql = "SELECT * FROM ".$db_prefix."_users WHERE id='" . $id . "' LIMIT 1";
       $query = $db->sql_query($sql) or btsqlerror($sql);
       if ($db->sql_numrows($query) != "0") {
			$kasutaja = $db->sql_fetchrow($query);
			$timezone = $kasutaja["tzoffset"]+60;
			return $timezone;
		} else {
         return "377";
		} //Default timezone
	}
}
function datum($datum=true)
{
	$sign = "+"; // Whichever direction from GMT to your timezone. + or -
	$h = "1"; // offset for time (hours)
	$dst = true; // true - use dst ; false - don't
	
	if ($dst==true) 
	{
		$daylight_saving = date('I');
		if ($daylight_saving)
		{
			if ($sign == "-")
			{ 
				$h=$h-1;  
			}
			else 
			{ 
				$h=$h+1; 
			}
		}
	}
	$hm = $h * 60;
	$ms = $hm * 60;
	if ($sign == "-")
	{ 
	$timestamp = time()-($ms); 
	}
	else 
	{
	 $timestamp = time()+($ms); 
	}
	$gmdate = gmdate("m.d.Y. g:i A", $timestamp);
	if($datum==true)
	{
		return $gmdate;
	}
	else 
	{
		return $timestamp;
	}
}
function removedinactive($uid, $mode = 'retain', $post_username = false){
                        global $db, $db_prefix, $forumshare,$phpEx, $config, $forumbase,$phpbb_root_path,$forumpx;
						$username = username_is($uid);
                        if (empty($username)) return;
                        $sql = "SELECT avatar, user_type, user_posts, active FROM ".$db_prefix."_users WHERE id = '".$uid."';";
                        $res = $db->sql_query($sql)or btsqlerror($sql);
                        list ($avatar, $user_type, $user_posts, $active) = $db->fetch_array($res);
                        $db->sql_freeresult($sql);
						// Before we begin, we will remove the reports the user issued.
						$sql = 'SELECT r.post_id, p.topic_id
							FROM ' . $db_prefix . '_reports r, ' . $db_prefix . '_posts p
							WHERE r.user_id = ' . $uid . '
								AND p.post_id = r.post_id';
						$result = $db->sql_query($sql);
					
						$report_posts = $report_topics = array();
						while ($row = $db->sql_fetchrow($result))
						{
							$report_posts[] = $row['post_id'];
							$report_topics[] = $row['topic_id'];
						}
						$db->sql_freeresult($result);
					
						if (sizeof($report_posts))
						{
							$report_posts = array_unique($report_posts);
							$report_topics = array_unique($report_topics);
					
							// Get a list of topics that still contain reported posts
							$sql = 'SELECT DISTINCT topic_id
								FROM ' . $db_prefix . '_posts
								WHERE ' . $db->sql_in_set('topic_id', $report_topics) . '
									AND post_reported = 1
									AND ' . $db->sql_in_set('post_id', $report_posts, true);
							$result = $db->sql_query($sql);
					
							$keep_report_topics = array();
							while ($row = $db->sql_fetchrow($result))
							{
								$keep_report_topics[] = $row['topic_id'];
							}
							$db->sql_freeresult($result);
					
							if (sizeof($keep_report_topics))
							{
								$report_topics = array_diff($report_topics, $keep_report_topics);
							}
							unset($keep_report_topics);
					
							// Now set the flags back
							$sql = 'UPDATE ' . $db_prefix . '_posts
								SET post_reported = 0
								WHERE ' . $db->sql_in_set('post_id', $report_posts);
							$db->sql_query($sql);
					
							if (sizeof($report_topics))
							{
								$sql = 'UPDATE ' . $db_prefix . '_topics
									SET topic_reported = 0
									WHERE ' . $db->sql_in_set('topic_id', $report_topics);
								$db->sql_query($sql);
							}
						}
					
						switch ($mode)
						{
							case 'retain':
					
					
								if ($post_username === false)
								{
									$post_username = $user->lang['GUEST'];
								}
					
								// If the user is inactive and newly registered we assume no posts from this user being there...
								if ($user_type == '1' && !$active == '1' && !$user_posts)
								{
								}
								else
								{
									$sql = 'UPDATE ' . $db_prefix . '_forums
										SET forum_last_poster_id = 0, forum_last_poster_name = \'' . $db->sql_escape($post_username) . "', forum_last_poster_colour = ''
										WHERE forum_last_poster_id = $uid";
									$db->sql_query($sql);
					
									$sql = 'UPDATE ' . $db_prefix . '_posts
										SET poster_id = 0, post_username = \'' . $db->sql_escape($post_username) . "'
										WHERE poster_id = $uid";
									$db->sql_query($sql);
					
									$sql = 'UPDATE ' . $db_prefix . '_posts
										SET post_edit_user = 0
										WHERE post_edit_user = ' .$uid;
									$db->sql_query($sql);
					
									$sql = 'UPDATE ' . $db_prefix . '_topics
										SET topic_poster = 0, topic_first_poster_name = \'' . $db->sql_escape($post_username) . "', topic_first_poster_colour = ''
										WHERE topic_poster = $uid";
									$db->sql_query($sql);
					
									$sql = 'UPDATE ' . $db_prefix . '_topics
										SET topic_last_poster_id = 0, topic_last_poster_name = \'' . $db->sql_escape($post_username) . "', topic_last_poster_colour = ''
										WHERE topic_last_poster_id = $uid";
									$db->sql_query($sql);
					
								}
					
					
							break;
					
							case 'remove':
					
								if (!function_exists('delete_posts'))
								{
									include('admin/functions.' . $phpEx);
								}
					
								$sql = 'SELECT topic_id, COUNT(post_id) AS total_posts
									FROM ' . $db_prefix . "_posts
									WHERE poster_id = $uid
									GROUP BY topic_id";
								$result = $db->sql_query($sql);
					
								$topic_id_ary = array();
								while ($row = $db->sql_fetchrow($result))
								{
									$topic_id_ary[$row['topic_id']] = $row['total_posts'];
								}
								$db->sql_freeresult($result);
					
								if (sizeof($topic_id_ary))
								{
									$sql = 'SELECT topic_id, topic_replies, topic_replies_real
										FROM ' . $db_prefix . '_topics
										WHERE ' . $db->sql_in_set('topic_id', array_keys($topic_id_ary));
									$result = $db->sql_query($sql);
					
									$del_topic_ary = array();
									while ($row = $db->sql_fetchrow($result))
									{
										if (max($row['topic_replies'], $row['topic_replies_real']) + 1 == $topic_id_ary[$row['topic_id']])
										{
											$del_topic_ary[] = $row['topic_id'];
										}
									}
									$db->sql_freeresult($result);
					
									if (sizeof($del_topic_ary))
									{
										$sql = 'DELETE FROM ' . $db_prefix . '_topics
											WHERE ' . $db->sql_in_set('topic_id', $del_topic_ary);
										$db->sql_query($sql);
									}
								}
					
								// Delete posts, attachments, etc.
								delete_posts('poster_id', $uid);
					
							break;
						}
						// Remove reports
						$db->sql_query('DELETE FROM ' . $db_prefix . '_reports WHERE user_id = ' . $uid);

                        if (preg_match("/^user\//",$avatar)) @unlink($avatar);
                        $sql = array();
                        //$sql[] = "DELETE FROM ".$db_prefix."_tickets WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_snatched WHERE userid = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_user_group WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_acl_users WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_topics_watch WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_forums_watch WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_topics_track WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_topics_posted WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_forums_track WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_moderator_cache WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_drafts WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_bookmarks WHERE user_id = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_shouts WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_download_completed WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_backup WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_file WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_privacy_global WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_comments_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_seeder_notify WHERE user = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_online_users WHERE id = '".$uid."';";
                        $sql[] = "UPDATE ".$db_prefix."_torrents SET owner = '0', ownertype = '2' WHERE owner = '".$uid."';";
                        $sql[] = "UPDATE ".$db_prefix."_peers SET uid = '0' WHERE uid = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages_blacklist WHERE master = '".$uid."' OR slave = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_private_messages_bookmarks WHERE master = '".$uid."' OR slave = '".$uid."';";
                        //$sql[] = "DELETE FROM ".$db_prefix."_private_messages WHERE recipient = '".$uid."';";
                        $sql[] = "DELETE FROM ".$db_prefix."_users WHERE id = '".$uid."';";

                        foreach ($sql as $query) {
                                $db->sql_query($query) or btsqlerror($sql);
                        }
	// Remove any undelivered mails...
	$sql = 'SELECT msg_id, user_id
		FROM ' . $db_prefix . '_privmsg_to
		WHERE author_id = ' . $uid . '
			AND folder_id = \'-3\'';
	$result = $db->sql_query($sql);

	$undelivered_msg = $undelivered_user = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$undelivered_msg[] = $row['msg_id'];
		$undelivered_user[$row['user_id']][] = true;
	}
	$db->sql_freeresult($result);

	if (sizeof($undelivered_msg))
	{
		$sql = 'DELETE FROM ' . $db_prefix . 'private_messages
			WHERE ' . $db->sql_in_set('id', $undelivered_msg);
		$db->sql_query($sql);
	}

	$sql = 'DELETE FROM ' . $db_prefix . '_privmsg_to
		WHERE author_id = ' . $uid . '
			AND folder_id = \'-3\'';
	$db->sql_query($sql);

	// Delete all to-information
	$sql = 'DELETE FROM ' . $db_prefix . '_privmsg_to
		WHERE user_id = ' . $uid;
	$db->sql_query($sql);

	// Set the remaining author id to anonymous - this way users are still able to read messages from users being removed
	$sql = 'UPDATE ' . $db_prefix . '_privmsg_to
		SET author_id = 0
		WHERE author_id = ' . $uid;
	$db->sql_query($sql);

	$sql = 'UPDATE ' . $db_prefix . 'private_messages
		SET sender = 0
		WHERE sender = ' . $uid;
	$db->sql_query($sql);

	foreach ($undelivered_user as $_user_id => $ary)
	{
		if ($_user_id == $uid)
		{
			continue;
		}

		$sql = 'UPDATE ' . $db_prefix . '_users
			SET user_new_privmsg = user_new_privmsg - ' . sizeof($ary) . ',
				user_unread_privmsg = user_unread_privmsg - ' . sizeof($ary) . '
			WHERE id = ' . $_user_id;
		$db->sql_query($sql);
	}

						//return;
} 
function mkglobal($vars) {
    if (!is_array($vars))
        $vars = explode(":", $vars);
    foreach ($vars as $v) {
        if (isset($_GET[$v]))
            $GLOBALS[$v] = unesc($_GET[$v]);
        elseif (isset($_POST[$v]))
            $GLOBALS[$v] = unesc($_POST[$v]);
        else
            return 0;
    }
    return 1;
}

function btsqlerror($sql, $u_action = false) { //Returns SQL Error
        global $db, $db_prefix, $theme, $template, $user;
		if(!isset($template))
		{
			include_once'include/class.template.php';
			$buffer = ob_get_clean();
			ob_start("ob_gzhandler");
			ob_implicit_flush(0);
			$user->set_lang('common',$user->ulanguage);
			$template = new Template();
			set_site_var($user->lang['GEN_ERROR']);
		}
        $err = Array();
        $err = $db->sql_error();
        $msg = "<p>\n";
        $msg .= $user->lang['SQL_ERRORSQL'].htmlspecialchars($sql) ;
        $msg .="<br />";
        $msg .= $user->lang['SQL_ERRORCODE'].$err["code"];
        $msg .="<br />";
        $msg .= $user->lang['SQL_ERRORMSG'].htmlspecialchars($err["message"]);
        $msg .= "</p>";
		                                $template->assign_vars(array(
										'S_ERROR'					=> true,
								        'S_USER_NOTICE'				=> false,
								        'MESSAGE_TITLE'				=> $user->lang['BT_ERROR'],
										'TITTLE_M'					=> $user->lang['BT_ERROR'],
                                        'MESSAGE_TEXT'  			=> $msg.(($u_action)?back_link($u_action):''),
										'MESSAGE'					=> $msg.(($u_action)?back_link($u_action):''),
                                ));
        logerror($msg, "Data base sql error");
        $db->sql_query("",END_TRANSACTION);
		echo $template->fetch(((preg_match("/admin.php/",$_SERVER["PHP_SELF"]))?'admin/':'').'message_body.html');
		close_out();
}

function get_elapsed_time($ts)
{
  $mins = floor((strtotime(gmdate("Y-m-d H:i:s", time())) - $ts) / 60);
  $hours = floor($mins / 60);
  $mins -= $hours * 60;
  $days = floor($hours / 24);
  $hours -= $days * 24;
  $weeks = floor($days / 7);
  $days -= $weeks * 7;
  $t = "";
  if ($weeks)
    return "$weeks week" . ($weeks > 1 ? "s" : "");
  if ($days)
    return "$days day" . ($days > 1 ? "s" : "");
  if ($hours)
    return "$hours hour" . ($hours > 1 ? "s" : "");
  if ($mins)
    return "$mins min" . ($mins > 1 ? "s" : "");
  return "< 1 min";
}
function validate_num($num, $optional = false, $min = 0, $max = 1E99)
{
	if (empty($num) && $optional)
	{
		return false;
	}

	if ($num < $min)
	{
		return 'TOO_SMALL';
	}
	else if ($num > $max)
	{
		return 'TOO_LARGE';
	}

	return false;
}
function validate_password($password)
{
	global $config, $db, $user;

	if (!$password)
	{
		return false;
	}

	$pcre = $mbstring = false;

	// generic UTF-8 character types supported?
	if ((version_compare(PHP_VERSION, '5.1.0', '>=') || (version_compare(PHP_VERSION, '5.0.0-dev', '<=') && version_compare(PHP_VERSION, '4.4.0', '>='))) && @preg_match('/\p{L}/u', 'a') !== false)
	{
		$upp = '\p{Lu}';
		$low = '\p{Ll}';
		$let = '\p{L}';
		$num = '\p{N}';
		$sym = '[^\p{Lu}\p{Ll}\p{N}]';
		$pcre = true;
	}
	else if (function_exists('mb_ereg_match'))
	{
		mb_regex_encoding('UTF-8');
		$upp = '[[:upper:]]';
		$low = '[[:lower:]]';
		$let = '[[:lower:][:upper:]]';
		$num = '[[:digit:]]';
		$sym = '[^[:upper:][:lower:][:digit:]]';
		$mbstring = true;
	}
	else
	{
		$upp = '[A-Z]';
		$low = '[a-z]';
		$let = '[a-zA-Z]';
		$num = '[0-9]';
		$sym = '[^A-Za-z0-9]';
		$pcre = true;
	}

	$chars = array();

	switch ($config['pass_complex'])
	{
		case 'PASS_TYPE_CASE':
			$chars[] = $low;
			$chars[] = $upp;
		break;

		case 'PASS_TYPE_ALPHA':
			$chars[] = $let;
			$chars[] = $num;
		break;

		case 'PASS_TYPE_SYMBOL':
			$chars[] = $low;
			$chars[] = $upp;
			$chars[] = $num;
			$chars[] = $sym;
		break;
	}

	if ($pcre)
	{
		foreach ($chars as $char)
		{
			if (!preg_match('#' . $char . '#u', $password))
			{
				return 'INVALID_CHARS';
			}
		}
	}
	else if ($mbstring)
	{
		foreach ($chars as $char)
		{
			if (mb_ereg($char, $password) === false)
			{
				return 'INVALID_CHARS';
			}
		}
	}

	return false;
}
function validate_email($email, $allowed_email = false)
{
	global $config, $db, $user;

	$email = strtolower($email);
	$allowed_email = ($allowed_email === false) ? strtolower($user->data['user_email']) : strtolower($allowed_email);

	if ($allowed_email == $email)
	{
		return false;
	}

	if (!preg_match('/^' . get_preg_expression('email') . '$/i', $email))
	{
		return 'EMAIL_INVALID';
	}

	// Check MX record.
	// The idea for this is from reading the UseBB blog/announcement. :)
	if ($config['email_check_mx'])
	{
		list(, $domain) = explode('@', $email);

		if (phpbb_checkdnsrr($domain, 'A') === false && phpbb_checkdnsrr($domain, 'MX') === false)
		{
			return 'DOMAIN_NO_MX_RECORD';
		}
	}

	//if (($ban_reason = $user->check_ban(false, false, $email, true)) !== false)
	//{
		//return ($ban_reason === true) ? 'EMAIL_BANNED' : $ban_reason;
	//}

		$sql = 'SELECT email
			FROM ' . $db_prefix . "_users
			WHERE email = '" . $db->sql_escape($email) . "'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($row)
		{
			return 'EMAIL_TAKEN';
		}

	return false;
}
function validate_username($username, $allowed_username = false)
{
	global $config, $db, $db_prefix, $user, $pmbt_cache;

	$clean_username = utf8_clean_string($username);
	$allowed_username = ($allowed_username === false) ? $user->data['username_clean'] : utf8_clean_string($allowed_username);

	if ($allowed_username == $clean_username)
	{
		return false;
	}

	// ... fast checks first.
	if (strpos($username, '&quot;') !== false || strpos($username, '"') !== false || empty($clean_username))
	{
		return 'INVALID_CHARS';
	}

	$mbstring = $pcre = false;

	// generic UTF-8 character types supported?
	if ((version_compare(PHP_VERSION, '5.1.0', '>=') || (version_compare(PHP_VERSION, '5.0.0-dev', '<=') && version_compare(PHP_VERSION, '4.4.0', '>='))) && @preg_match('/\p{L}/u', 'a') !== false)
	{
		$pcre = true;
	}
	else if (function_exists('mb_ereg_match'))
	{
		mb_regex_encoding('UTF-8');
		$mbstring = true;
	}

	switch ($config['allow_name_chars'])
	{
		case 'USERNAME_CHARS_ANY':
			$pcre = true;
			$regex = '.+';
		break;

		case 'USERNAME_ALPHA_ONLY':
			$pcre = true;
			$regex = '[A-Za-z0-9]+';
		break;

		case 'USERNAME_ALPHA_SPACERS':
			$pcre = true;
			$regex = '[A-Za-z0-9-[\]_+ ]+';
		break;

		case 'USERNAME_LETTER_NUM':
			if ($pcre)
			{
				$regex = '[\p{Lu}\p{Ll}\p{N}]+';
			}
			else if ($mbstring)
			{
				$regex = '[[:upper:][:lower:][:digit:]]+';
			}
			else
			{
				$pcre = true;
				$regex = '[a-zA-Z0-9]+';
			}
		break;

		case 'USERNAME_LETTER_NUM_SPACERS':
			if ($pcre)
			{
				$regex = '[-\]_+ [\p{Lu}\p{Ll}\p{N}]+';
			}
			else if ($mbstring)
			{
				$regex = '[-\]_+ \[[:upper:][:lower:][:digit:]]+';
			}
			else
			{
				$pcre = true;
				$regex = '[-\]_+ [a-zA-Z0-9]+';
			}
		break;

		case 'USERNAME_ASCII':
		default:
			$pcre = true;
			$regex = '[\x01-\x7F]+';
		break;
	}

	if ($pcre)
	{
		if (!preg_match('#^' . $regex . '$#u', $username))
		{
			return 'INVALID_CHARS';
		}
	}
	else if ($mbstring)
	{
		mb_ereg_search_init($username, '^' . $regex . '$');
		if (!mb_ereg_search())
		{
			return 'INVALID_CHARS';
		}
	}

	$sql = 'SELECT username
		FROM ' . $db_prefix . "_users
		WHERE clean_username = '" . $db->sql_escape($clean_username) . "'";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($row)
	{
		return 'USERNAME_TAKEN';
	}

	$sql = 'SELECT group_name
		FROM ' . $db_prefix . "_level_settings
		WHERE LOWER(group_name) = '" . $db->sql_escape(utf8_strtolower($username)) . "'";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($row)
	{
		return 'USERNAME_TAKEN';
	}

	$bad_usernames = $pmbt_cache->obtain_disallowed_usernames();

	foreach ($bad_usernames as $bad_username)
	{
		if (preg_match('#^' . $bad_username . '$#', $clean_username))
		{
			return 'USERNAME_DISALLOWED';
		}
	}

	return false;
}
function validate_match($string, $optional = false, $match = '')
{
	if (empty($string) && $optional)
	{
		return false;
	}

	if (empty($match))
	{
		return false;
	}

	if (!preg_match($match, $string))
	{
		return 'WRONG_DATA' . $match . '  |  ' . $string;
	}

	return false;
}
function validate_date($date_string, $optional = false)
{
	$date = explode('-', $date_string);
	if ((empty($date) || sizeof($date) != 3) && $optional)
	{
		return false;
	}
	else if ($optional)
	{
		for ($field = 0; $field <= 1; $field++)
		{
			$date[$field] = (int) $date[$field];
			if (empty($date[$field]))
			{
				$date[$field] = 1;
			}
		}
		$date[2] = (int) $date[2];
		// assume an arbitrary leap year
		if (empty($date[2]))
		{
			$date[2] = 1980;
		}
	}

	if (sizeof($date) != 3 || !checkdate($date[1], $date[0], $date[2]))
	{
		return 'INVALID';
	}

	return false;
}
function phpbb_check_hash($password, $hash)
{
	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	if (strlen($hash) == 34)
	{
		return (_hash_crypt_private($password, $hash, $itoa64) === $hash) ? true : false;
	}

	return (md5($password) === $hash) ? true : false;
}

/**
* Generate salt for hash generation
*/
function _hash_gensalt_private($input, &$itoa64, $iteration_count_log2 = 6)
{
	if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31)
	{
		$iteration_count_log2 = 8;
	}

	$output = '$H$';
	$output .= $itoa64[min($iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30)];
	$output .= _hash_encode64($input, 6, $itoa64);

	return $output;
}
function validate_data($data, $val_ary)
{
	global $user;

	$error = array();

	foreach ($val_ary as $var => $val_seq)
	{
		if (!is_array($val_seq[0]))
		{
			$val_seq = array($val_seq);
		}

		foreach ($val_seq as $validate)
		{
			$function = array_shift($validate);
			array_unshift($validate, $data[$var]);

			if ($result = call_user_func_array('validate_' . $function, $validate))
			{
				// Since errors are checked later for their language file existence, we need to make sure custom errors are not adjusted.
				$error[] = (empty($user->lang[$result . '_' . strtoupper($var)])) ? $result : $result . '_' . strtoupper($var);
			}
		}
	}

	return $error;
}
function validate_jabber($jid)
{
	if (!$jid)
	{
		return false;
	}

	$seperator_pos = strpos($jid, '@');

	if ($seperator_pos === false)
	{
		return 'WRONG_DATA';
	}

	$username = substr($jid, 0, $seperator_pos);
	$realm = substr($jid, $seperator_pos + 1);

	if (strlen($username) == 0 || strlen($realm) < 3)
	{
		return 'WRONG_DATA';
	}

	$arr = explode('.', $realm);

	if (sizeof($arr) == 0)
	{
		return 'WRONG_DATA';
	}

	foreach ($arr as $part)
	{
		if (substr($part, 0, 1) == '-' || substr($part, -1, 1) == '-')
		{
			return 'WRONG_DATA';
		}

		if (!preg_match("@^[a-zA-Z0-9-.]+$@", $part))
		{
			return 'WRONG_DATA';
		}
	}

	$boundary = array(array(0, 127), array(192, 223), array(224, 239), array(240, 247), array(248, 251), array(252, 253));

	// Prohibited Characters RFC3454 + RFC3920
	$prohibited = array(
		// Table C.1.1
		array(0x0020, 0x0020),		// SPACE
		// Table C.1.2
		array(0x00A0, 0x00A0),		// NO-BREAK SPACE
		array(0x1680, 0x1680),		// OGHAM SPACE MARK
		array(0x2000, 0x2001),		// EN QUAD
		array(0x2001, 0x2001),		// EM QUAD
		array(0x2002, 0x2002),		// EN SPACE
		array(0x2003, 0x2003),		// EM SPACE
		array(0x2004, 0x2004),		// THREE-PER-EM SPACE
		array(0x2005, 0x2005),		// FOUR-PER-EM SPACE
		array(0x2006, 0x2006),		// SIX-PER-EM SPACE
		array(0x2007, 0x2007),		// FIGURE SPACE
		array(0x2008, 0x2008),		// PUNCTUATION SPACE
		array(0x2009, 0x2009),		// THIN SPACE
		array(0x200A, 0x200A),		// HAIR SPACE
		array(0x200B, 0x200B),		// ZERO WIDTH SPACE
		array(0x202F, 0x202F),		// NARROW NO-BREAK SPACE
		array(0x205F, 0x205F),		// MEDIUM MATHEMATICAL SPACE
		array(0x3000, 0x3000),		// IDEOGRAPHIC SPACE
		// Table C.2.1
		array(0x0000, 0x001F),		// [CONTROL CHARACTERS]
		array(0x007F, 0x007F),		// DELETE
		// Table C.2.2
		array(0x0080, 0x009F),		// [CONTROL CHARACTERS]
		array(0x06DD, 0x06DD),		// ARABIC END OF AYAH
		array(0x070F, 0x070F),		// SYRIAC ABBREVIATION MARK
		array(0x180E, 0x180E),		// MONGOLIAN VOWEL SEPARATOR
		array(0x200C, 0x200C), 		// ZERO WIDTH NON-JOINER
		array(0x200D, 0x200D),		// ZERO WIDTH JOINER
		array(0x2028, 0x2028),		// LINE SEPARATOR
		array(0x2029, 0x2029),		// PARAGRAPH SEPARATOR
		array(0x2060, 0x2060),		// WORD JOINER
		array(0x2061, 0x2061),		// FUNCTION APPLICATION
		array(0x2062, 0x2062),		// INVISIBLE TIMES
		array(0x2063, 0x2063),		// INVISIBLE SEPARATOR
		array(0x206A, 0x206F),		// [CONTROL CHARACTERS]
		array(0xFEFF, 0xFEFF),		// ZERO WIDTH NO-BREAK SPACE
		array(0xFFF9, 0xFFFC),		// [CONTROL CHARACTERS]
		array(0x1D173, 0x1D17A),	// [MUSICAL CONTROL CHARACTERS]
		// Table C.3
		array(0xE000, 0xF8FF),		// [PRIVATE USE, PLANE 0]
		array(0xF0000, 0xFFFFD),	// [PRIVATE USE, PLANE 15]
		array(0x100000, 0x10FFFD),	// [PRIVATE USE, PLANE 16]
		// Table C.4
		array(0xFDD0, 0xFDEF),		// [NONCHARACTER CODE POINTS]
		array(0xFFFE, 0xFFFF),		// [NONCHARACTER CODE POINTS]
		array(0x1FFFE, 0x1FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x2FFFE, 0x2FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x3FFFE, 0x3FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x4FFFE, 0x4FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x5FFFE, 0x5FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x6FFFE, 0x6FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x7FFFE, 0x7FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x8FFFE, 0x8FFFF),	// [NONCHARACTER CODE POINTS]
		array(0x9FFFE, 0x9FFFF),	// [NONCHARACTER CODE POINTS]
		array(0xAFFFE, 0xAFFFF),	// [NONCHARACTER CODE POINTS]
		array(0xBFFFE, 0xBFFFF),	// [NONCHARACTER CODE POINTS]
		array(0xCFFFE, 0xCFFFF),	// [NONCHARACTER CODE POINTS]
		array(0xDFFFE, 0xDFFFF),	// [NONCHARACTER CODE POINTS]
		array(0xEFFFE, 0xEFFFF),	// [NONCHARACTER CODE POINTS]
		array(0xFFFFE, 0xFFFFF),	// [NONCHARACTER CODE POINTS]
		array(0x10FFFE, 0x10FFFF),	// [NONCHARACTER CODE POINTS]
		// Table C.5
		array(0xD800, 0xDFFF),		// [SURROGATE CODES]
		// Table C.6
		array(0xFFF9, 0xFFF9),		// INTERLINEAR ANNOTATION ANCHOR
		array(0xFFFA, 0xFFFA),		// INTERLINEAR ANNOTATION SEPARATOR
		array(0xFFFB, 0xFFFB),		// INTERLINEAR ANNOTATION TERMINATOR
		array(0xFFFC, 0xFFFC),		// OBJECT REPLACEMENT CHARACTER
		array(0xFFFD, 0xFFFD),		// REPLACEMENT CHARACTER
		// Table C.7
		array(0x2FF0, 0x2FFB),		// [IDEOGRAPHIC DESCRIPTION CHARACTERS]
		// Table C.8
		array(0x0340, 0x0340),		// COMBINING GRAVE TONE MARK
		array(0x0341, 0x0341),		// COMBINING ACUTE TONE MARK
		array(0x200E, 0x200E),		// LEFT-TO-RIGHT MARK
		array(0x200F, 0x200F),		// RIGHT-TO-LEFT MARK
		array(0x202A, 0x202A),		// LEFT-TO-RIGHT EMBEDDING
		array(0x202B, 0x202B),		// RIGHT-TO-LEFT EMBEDDING
		array(0x202C, 0x202C),		// POP DIRECTIONAL FORMATTING
		array(0x202D, 0x202D),		// LEFT-TO-RIGHT OVERRIDE
		array(0x202E, 0x202E),		// RIGHT-TO-LEFT OVERRIDE
		array(0x206A, 0x206A),		// INHIBIT SYMMETRIC SWAPPING
		array(0x206B, 0x206B),		// ACTIVATE SYMMETRIC SWAPPING
		array(0x206C, 0x206C),		// INHIBIT ARABIC FORM SHAPING
		array(0x206D, 0x206D),		// ACTIVATE ARABIC FORM SHAPING
		array(0x206E, 0x206E),		// NATIONAL DIGIT SHAPES
		array(0x206F, 0x206F),		// NOMINAL DIGIT SHAPES
		// Table C.9
		array(0xE0001, 0xE0001),	// LANGUAGE TAG
		array(0xE0020, 0xE007F),	// [TAGGING CHARACTERS]
		// RFC3920
		array(0x22, 0x22),			// "
		array(0x26, 0x26),			// &
		array(0x27, 0x27),			// '
		array(0x2F, 0x2F),			// /
		array(0x3A, 0x3A),			// :
		array(0x3C, 0x3C),			// <
		array(0x3E, 0x3E),			// >
		array(0x40, 0x40)			// @
	);

	$pos = 0;
	$result = true;

	while ($pos < strlen($username))
	{
		$len = $uni = 0;
		for ($i = 0; $i <= 5; $i++)
		{
			if (ord($username[$pos]) >= $boundary[$i][0] && ord($username[$pos]) <= $boundary[$i][1])
			{
				$len = $i + 1;
				$uni = (ord($username[$pos]) - $boundary[$i][0]) * pow(2, $i * 6);

				for ($k = 1; $k < $len; $k++)
				{
					$uni += (ord($username[$pos + $k]) - 128) * pow(2, ($i - $k) * 6);
				}

				break;
			}
		}

		if ($len == 0)
		{
			return 'WRONG_DATA';
		}

		foreach ($prohibited as $pval)
		{
			if ($uni >= $pval[0] && $uni <= $pval[1])
			{
				$result = false;
				break 2;
			}
		}

		$pos = $pos + $len;
	}

	if (!$result)
	{
		return 'WRONG_DATA';
	}

	return false;
}
function bterror($error, $title = 'GEN_ERROR', $fatal = true, $redirect = false, $tm = 3) {
        global $db, $db_prefix, $user, $template;
		if(!isset($template))
		{
			include_once'include/class.template.php';
			$buffer = ob_get_clean();
			ob_start("ob_gzhandler");
			ob_implicit_flush(0);
			$user->set_lang('common',$user->ulanguage);
			$template = new Template();
			set_site_var($user->lang['GEN_ERROR']);
		}
			$title = ((isset($user->lang[$title]))? $user->lang[$title] : $title);
		$msg = '';
        if (is_array($error)) {
                $msg .= "<p>".$user->lang['ALERT_ERROR']."</p>\n";
                $msg .= "<ul>\n";
                foreach ($error as $msg) {
                        $msg .= "<li><p>". ((isset($user->lang[$msg]))? $user->lang[$msg] : $msg) ."</p></li>\n";
                }
                $msg .= "</ul>\n";
        }else {
                 $msg .= ((isset($user->lang[$error]))? $user->lang[$error] : $error);
        }
		if($redirect)
		{
			meta_refresh($tm, $redirect);
		}

		                                $template->assign_vars(array(
								        'S_USER_NOTICE'			=> false,
								        'S_ERROR'				=> true,
								        'MESSAGE_TITLE'			=> $title,
										'TITTLE_M'				=> $title,
                                        'MESSAGE_TEXT'			=> $msg,
										'MESSAGE'				=> $msg,
                                ));
		echo $template->fetch(((preg_match("/admin.php/",$_SERVER["PHP_SELF"]))?'admin/':'').'message_body.html');
        if (!preg_match("/admin.php/",$_SERVER["PHP_SELF"])) logerror($error,'user');
		if($fatal)close_out();
}

function loginrequired($level, $guickclose = false) {
        global $user, $template, $db, $db_prefix, $gfx_check, $autoscrape,$recap_puplic_key, $recap_private_key;
		require_once("include/recaptchalib.php");
			if(!isset($template))$template = new Template();
              set_site_var('- '.(($var)? $var : $user->lang['USER_CPANNEL']) . ' - ' . $user->lang['ACCESS_DENIED']);

		$hidden = array();
		$redirect = '';
		$user->set_lang('profile',$user->ulanguage);
							   $template->assign_vars(array(
                                        'S_ERROR'            => false,
										'PAGE_TITLE'		=>	$user->lang['LOGIN'],
                                ));

		if (!$admin)
		{
			$redirect .= ($user->page['page_dir']) ? $user->page['page_dir'] . '/' : '';
		}

		$redirect .= $user->page['page_name'] . (($user->page['query_string']) ? '?' . htmlspecialchars($user->page['query_string']) : '');
	    $returnto = $redirect;
		$login_op									= request_var('login_op', '');
		switch($login_op)
		{
				case 'login':
				{
					$username									= request_var('username', '');
					$password									= request_var('password', '');
					$gfxcode									= request_var('gfxcode', '');
					$returnto									= request_var('returnto', '');
					$remember									= request_var('remember', '');
					$recaptcha_response_field					= request_var('g-recaptcha-response', '');
					$recap_pass = true;
					if ($gfx_check AND $recap_puplic_key)
					{
						$ip = $_SERVER['REMOTE_ADDR'];
						$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recap_private_key."&response=".$recaptcha_response_field."&remoteip=".$ip);
						$responseKeys = json_decode($response,true);	     
						$recap_pass = intval($responseKeys["success"]) !== 1 ? false : true;
					}
					   if ($username == "" OR $password == "") {
										$template->assign_vars(array(
												'S_ERROR'            => true,
												'S_ERROR_MESS'            => $user->lang['LOGIN_ERROR_NP'],
										));
										break;
						}
						elseif ($gfx_check AND $recap_puplic_key AND !$recap_pass)
						{
												$template->assign_vars(array(
												'S_ERROR'            => true,
												'S_ERROR_MESS'            => 'badcode',
												));
												//die;
											break;
						} elseif ($gfx_check AND !$recap_puplic_key AND (!isset($gfxcode) OR $gfxcode == "" OR $gfxcheck != md5(strtoupper($gfxcode)))) {
											$template->assign_vars(array(
													'S_ERROR'            => true,
													'S_ERROR_MESS'            => $user->lang['SEC_CODE_ERROR'],
											));
											//die;
											break;
						} 
						else 
						{
								$result = $db->sql_query("SELECT active FROM ".$db_prefix."_users WHERE clean_username = '".$db->sql_escape(strtolower($username))."' AND password = '".md5($password)."'");
								if ($db->sql_numrows($result) == 1) 
								{
										list ($active) = $db->fetch_array($result);
										if ($active == 1) {
										$ip = getip();
										$sql = "UPDATE ".$db_prefix."_users SET 
												lastip = '".sprintf("%u",ip2long($ip))."', 
												lasthost = '".gethostbyaddr($ip)."', 
												lastlogin = NOW() WHERE 
												clean_username = '".$db->sql_escape(strtolower($username))."';";
										$db->sql_query($sql);
		
										if (isset($remember) AND $remember == "yes")
										{
											$db->sql_query("UPDATE ".$db_prefix."_users SET rem = 'yes' WHERE clean_username = '".$db->sql_escape(strtolower($username))."';");
										 }
												userlogin($username, $btuser);
												return;
										}
										else 
										{
												//user not active
											$template->assign_vars(array(
												'S_ERROR'            => true,
												'S_ERROR_MESS'            => $user->lang['LOGIN_ERROR_NOT_ACTIVE'],
										));
										}
								} 
								else 
								{
										//bad data
										logerror('User login failed for '.$username . ' using '. $db->sql_escape(stripslashes($password)), 'Failed Login');
										$template->assign_vars(array(
												'S_ERROR'            => true,
												'S_ERROR_MESS'            => $user->lang['LOGIN_ERROR_NP_WRONG'],
										));
								}
						}
				}
		}
		$gfximage = '';
			if ($gfx_check) {
				if($recap_puplic_key)
				{
							   $template->assign_vars(array(
										'META'						=> "<script src='https://www.google.com/recaptcha/api.js'></script>",
                                ));
					$gfximage = true;
				}else{
					$rnd_code = strtoupper(RandomAlpha(5));
					$hidden ['gfxcheck'] = md5($rnd_code);
					$gfximage = "<img src=\"gfxgen.php?code=".base64_encode($rnd_code)."\">";
				}
			}
			$hidden['login_op'] = 'login';
						   $template->assign_vars(array(
									'LOGIN_SUCCESS'				=> $login_complete,
									'S_GFX_CHECK'				=>	($gfx_check)? $gfximage : false,
									'HIDDEN'					=>	build_hidden_fields($hidden),
									'U_ACTION'					=>	$redirect,
									'RECAPTCHA'					=>	$recap_puplic_key,
							));

		echo $template->fetch('login.html');
		close_out();
}
function autoclean() {
    global $db, $db_prefix, $autoclean_interval, $announce_interval, $pmbt_cache;
    $now = time();
    $cln = "SELECT value_u FROM ".$db_prefix."_avps WHERE arg = 'lastcleantime'";
	$res = $db->sql_query($cln)or btsqlerror($cln);
    $row = $db->sql_fetchrow($res);
    if (!$row) {
        $db->sql_query("INSERT INTO ".$db_prefix."_avps (arg, value_u) VALUES ('lastcleantime',$now)")or btsqlerror("INSERT INTO ".$db_prefix."_avps (arg, value_u) VALUES ('lastcleantime',$now)");
        return;
    }
    $ts = $row['value_u'];
    if ($ts + $autoclean_interval > $now) return;
    $db->sql_query("UPDATE ".$db_prefix."_avps SET value_u=$now WHERE arg='lastcleantime' AND value_u = $ts");
    bonouse();
}

function bonouse(){
    global $db, $db_prefix, $announce_interval, $pmbt_cache;
        #Reset Statistics. Run where there is a dead peer
        $sql = "DELETE FROM ".$db_prefix."_peers WHERE UNIX_TIMESTAMP(last_action) < UNIX_TIMESTAMP(NOW()) - ".($announce_interval+60).";"; //One minute of tolerance
        $res = $db->sql_query($sql);
        if ($db->sql_affectedrows($res) > 0) {
                $db->sql_query("UPDATE ".$db_prefix."_torrents SET seeders = 0, leechers = 0, tot_peer = 0, speed = 0 WHERE tracker IS NULL OR backup_tracker = 'true';");

                $sql = "SELECT COUNT(*) AS tot, torrent, seeder, SUM(upload_speed) AS speed FROM ".$db_prefix."_peers GROUP BY torrent, seeder;";
                $res = $db->sql_query($sql);
                while($row = $db->sql_fetchrow($res)) {
                        if ($row["seeder"] == "yes") $sql = "UPDATE ".$db_prefix."_torrents SET seeders = '".$row["tot"]."', speed = speed + '".$row["speed"]."' WHERE id='".$row["torrent"]."';";
                        else $sql = "UPDATE ".$db_prefix."_torrents SET leechers = '".$row["tot"]."', speed = speed + '".$row["speed"]."' WHERE id='".$row["torrent"]."';";
                        $db->sql_query($sql);
                }

                $db->sql_query("UPDATE ".$db_prefix."_torrents SET tot_peer = seeders + leechers;");
        }
	#cache Bonus configs
	if(!$pmbt_cache->get_sql("bonconfig"))
		{
			$bon = 'SELECT active, seeding, by_torrent 
				FROM '.$db_prefix.'_bonus_points';
			$bonset = $db->sql_query($bon)or btsqlerror($bon);
			$bon_config = $db->sql_fetchrow($bonset);
			$pmbt_cache->set_sql("bonconfig", $bon_config);
			$db->sql_freeresult($bonset);
		}
		else
		{
			$bon_config = $pmbt_cache->get_sql("bonconfig");
		}
	$seeding_point = $bon_config['seeding'];
	$point_per = ($bon_config['by_torrent'] == '1')? true : false;
	if($bon_config['active'] == 'true')
		{
			if($point_per)
				{
					$sql = 'SELECT DISTINCT uid 
						FROM '.$db_prefix."_peers 
						WHERE seeder = 'yes'";
					$res = $db->sql_query($sql);
					$sql2 = 'SELECT COUNT(uid) 
						FROM '.$db_prefix."_peers 
						WHERE seeder = 'yes' 
						GROUP BY id";
					$res2 = $db->sql_query($sql2);
					list ($count) = $db->fetch_array($res2);
					$db->sql_freeresult($res2);
					if ($count > 0)
						{
							while ($arr = $db->sql_fetchrow($res))
								{
									$sql_work = 'select count(uid) as count 
											FROM '.$db_prefix."_peers 
											WHERE seeder ='yes' 
												AND uid = {$arr['uid']} 
											GROUP BY id";
									$work = $db->sql_query($sql_work);
									$row_count = $db->sql_fetchrow($work);
									$seedbonus = $seeding_point*$row_count['count'];
									$db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$seedbonus."' WHERE id = ".$arr['uid']." AND active = '1' AND warned = '0'") or sqlerr(__FILE__, __LINE__);
								}
						}
				}
				else
				{
					$sql = 'SELECT DISTINCT uid 
						FROM '.$db_prefix."_peers 
						WHERE seeder = 'yes'";
					$res = $db->sql_query($sql);
					$sql2 = 'SELECT COUNT(uid) 
						FROM '.$db_prefix."_peers 
						WHERE seeder = 'yes' 
						GROUP BY id";
					$res2 = $db->sql_query($sql2);
					list ($count) =  $db->fetch_array($res2);
					$db->sql_freeresult($res2);
					if ($count > 0)
						{
							while ($arr = $db->sql_fetchrow($res))
								{
									$db->sql_query("UPDATE ".$db_prefix."_users SET seedbonus = seedbonus + '".$seeding_point."' WHERE id = ".$arr['uid']." AND active = '1' AND warned = '0'");
								}
						}
				}
		}
}
/*---------------------------------
SECURITY FUNCTIONS
---------------------------------*/
function cookie_decode($cookie) {
        global $use_rsa, $rsa;
        if ($use_rsa) $cookie = $rsa->decrypt($cookie);
        else $cookie = base64_decode($cookie);
        $cookie = stripslashes($cookie);
        $cookie = addslashes($cookie);
        $cookie = explode("::", $cookie);
        if (count($cookie) != 4) return Array("","","","");
        return $cookie;
}

function cookie_encode(&$cookie) {
        global $use_rsa, $rsa;
        $cookie = implode("::",$cookie);
        if ($use_rsa) $cookie = $rsa->encrypt($cookie);
        else $cookie = base64_encode($cookie);
        return $cookie;
}

function is_banned($user, &$reason) {
        //Both checking against username and IP
        global $db, $db_prefix, $_SERVER;
        $ip = sprintf("%u",ip2long(getip()));

        $sqlip = "SELECT ban_give_reason as reason FROM ".$db_prefix."_bans WHERE  ipstart <= '".$ip."' AND ipend >= '".$ip."'  LIMIT 1;";
        $resip = $db->sql_query($sqlip) or btsqlerror($sqlip);
        $sql = "SELECT banreason as reason FROM ".$db_prefix."_users WHERE id = '".$user->id."' AND ban = 1 UNION SELECT reason FROM ".$db_prefix."_bans WHERE ipstart <= '".$ip."' AND ipend >= '".$ip."'  LIMIT 1;";
        $res = $db->sql_query($sql) or btsqlerror($sql);
        if ($db->sql_numrows($resip) >= 1) {
                list ($reason) = $db->fetch_array($resip);
                return true;
		}
        if ($db->sql_numrows($res) < 1) {
                $reason = "";
                return false;
        } else {
                list ($reason) = $db->fetch_array($res);
                return true;
        }
}

function is_user($user) {//Deprecated
        //trigger_error("Function is_user() is deprecated",E_USER_WARNING);
        global $user;
        return $user->user;
}

function is_btadmin($user) {//Deprecated
        //trigger_error("Function is_btadmin() is deprecated",E_USER_WARNING);
        global $user;
        return $user->admin;
}

function is_premium($user) {//Deprecated
        //trigger_error("Function is_premium() is deprecated",E_USER_WARNING);
        global $user;
        return $user->premium;
}

function is_moderator($user) {//Deprecated
        //trigger_error("Function is_moderator() is deprecated",E_USER_WARNING);
        global $user;
        return $user->moderator;
}

function can_download($user, &$torrent) {
        global $db, $db_prefix, $download_level, $torrent_global_privacy, $auth;
        if ($auth->acl_get('u_download_torrents') AND checkaccess("u_download") AND $torrent["tracker"] != "" AND !$user->parked) return true;
        if (checkaccess("u_download") AND !$torrent_global_privacy) return true;
        if (checkaccess("m_down_load_private_torrents") AND $torrent_global_privacy) return true;
        if (!checkaccess("m_down_load_private_torrents") AND $torrent_global_privacy)
		{
                if (checkaccess("u_download") AND $torrent["ownertype"] == 2 OR $torrent["private"] != "true") return true;
                $ratioqry = "SELECT uploaded, downloaded FROM ".$db_prefix."_users WHERE id = '".$user->id."';";
                $ratiores = $db->sql_query($ratioqry);
                list ($uploaded, $downloaded) = $db->fetch_array($ratiores);
                $db->sql_freeresult($ratiores);
                if ($torrent["min_ratio"] > "0.00" AND ($downloaded > 0) AND $uploaded/$downloaded >= $torrent["min_ratio"]) return true;

                $sql = "SELECT status FROM ".$db_prefix."_privacy_global WHERE master = '".$torrent["owner"]."' AND slave = '".$user->id."';";
                $privacylist = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($privacylist) == 1) {
                        $privacy = $db->sql_fetchrow($privacylist);
                        if ($privacy["status"] == "whitelist") return true;
                        else return false;
                }
                $sql = "SELECT status FROM ".$db_prefix."_privacy_file WHERE slave = '".$user->id."' AND torrent = '".$torrent["id"]."';";
                $authqry = $db->sql_query($sql) or btsqlerror($sql);
                if ($db->sql_numrows($authqry) == 0) return false;
                $authrow = $db->sql_fetchrow($authqry);
                if ($authrow["status"] == "granted") return true;
                else return false;
        }
        return false;
}
function userlogin($username, &$cookiedata) {
global $db, $db_prefix, $cookiedomain, $cookiepath, $logintime;
$res = $db->sql_query("SELECT * FROM ".$db_prefix."_users WHERE clean_username ='".$db->sql_escape(strtolower($username))."';");
if (!$res) return;
$row = $db->sql_fetchrow($res);
if (!$row) return;
$remember = 'yes';
$session_time = time() + (($logintime) ? 3200 * (int) $logintime : 31536000);
$cookiedata = Array($row["id"],addslashes($row["username"]),$row["password"],$row["act_key"]);
cookie_encode($cookiedata);
if ($remember=="no"){
setcookie("btuser",$cookiedata,$session_time,$cookiepath,$cookiedomain,0);
if ($row["theme"] != "" AND is_dir("themes/".$row["theme"]) AND $row["theme"] != "CVS") setcookie("bttheme",$row["theme"],$session_time,$cookiepath,$cookiedomain,0);
else setcookie("bttheme","",$session_time,$cookiepath,$cookiedomain,0);
if ($row["language"] != "" AND is_readable("language/".$row["language"].".php")) setcookie("btlanguage",$row["language"],$session_time,$cookiepath,$cookiedomain,0);
else setcookie("btlanguage","",$session_time,$cookiepath,$cookiedomain,0);
return;
}else{
        setcookie("btuser",$cookiedata,time()+8640000,$cookiepath,$cookiedomain,0);
        if ($row["theme"] != "" AND is_dir("themes/".$row["theme"]) AND $row["theme"] != "CVS") setcookie("bttheme",$row["theme"],time()+8640000,$cookiepath,$cookiedomain,0);
        else setcookie("bttheme","",time()+8640000,$cookiepath,$cookiedomain,0);
        if ($row["language"] != "" AND is_readable("language/".$row["language"].".php")) setcookie("btlanguage",$row["language"],time()+8640000,$cookiepath,$cookiedomain,0);
        else setcookie("btlanguage","",time()+8640000,$cookiepath,$cookiedomain,0);
        return;
}
} 
function getuserid($user) { //Deprecated
        //trigger_error("Function getuserid() is deprecated",E_USER_WARNING);
        global $user;
        return $user->id;
}

function getusername($user) { //Gets the user name from cookie
        //trigger_error("Function getusername() is deprecated",E_USER_WARNING);
        global $user;
        return $user->name;
}
function is_url($url) {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}
function is_email($email) {
        return preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\\-+)|([A-Za-z0-9]+\\.+)|([A-Za-z0-9]+\\++))*[A-Za-z0-9_]+@((\\w+\\-+)|(\\w+\\.))*\\w{1,63}\\.[a-zA-Z]{2,6}$/",$email);
}
function is_filename($name) { //Is the file name valid?
        return preg_match('/^[^\\\\:\/<>|*"?]*$/si', $name);
}
function escape($x) { //Like mysql_escape_string()
        return addslashes($x);
}
function unescape($x) {
        return stripslashes($x);
}
function sqlwildcardesc($x) { //Replaces wildcards
        return str_replace(array("%","_"), array("\\%","\\_"), str_replace("'", "\'", $x));
}

function RandomNum($num) {
        $set = "0123456789";
        $resp = "";
        for ($i=1; $i<=$num; $i++) {
                $char = rand(0,strlen($set));
                $resp.=$set[$char];
        }
        return $resp;
}
function RandomAlpha($num) {
        $set = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvxyz0123456789";
        $resp = "";
        for ($i=1; $i<=$num; $i++) {
                $char = rand(0,strlen($set)-1);
                $resp.=$set[$char];
        }
        return $resp;
}
function spellmail($email) {
	global $user;
        $search = Array("@",".");
        $replace = Array($user->lang['_at'],$user->lang['_dot']);
        return "<i>".str_replace($search,$replace,$email)."</i>";
}

function sql_timestamp_to_unix_timestamp($s)
{
  return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}
define('INT_SECOND', 1);
define('INT_MINUTE', 60);
define('INT_HOUR', 3600);
define('INT_DAY', 86400);
define('INT_WEEK', 604800);

function get_formatted_timediff($then, $now = false)
{
    $now      = (!$now) ? time() : $now;
    $timediff = ($now - $then);
    $weeks    = (int) intval($timediff / INT_WEEK);
    $timediff = (int) intval($timediff - (INT_WEEK * $weeks));
    $days     = (int) intval($timediff / INT_DAY);
    $timediff = (int) intval($timediff - (INT_DAY * $days));
    $hours    = (int) intval($timediff / INT_HOUR);
    $timediff = (int) intval($timediff - (INT_HOUR * $hours));
    $mins     = (int) intval($timediff / INT_MINUTE);
    $timediff = (int) intval($timediff - (INT_MINUTE * $mins));
    $sec      = (int) intval($timediff / INT_SECOND);
    $timediff = (int) intval($timediff - ($sec * INT_SECOND));

    $str = '';
    if ( $weeks )
    {
        $str .= intval($weeks);
        $str .= ($weeks > 1) ? 'w\'s' : 'w';
    }

    if ( $days )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($days);
        $str .= ($days > 1) ? 'd\'s' : 'd';
    }

    if ( $hours )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($hours);
        $str .= ($hours > 1) ? 'h\'s' : 'h';
    }

    if ( $mins )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($mins);
        $str .= ($mins > 1) ? 'm\'s' : 'm';
    }

    if ( $sec )
    {
        $str .= ($str) ? ',' : '';
        $str .= intval($sec);
        $str .= ($sec > 1) ? 's\'s' : 's';
    }
   
    if ( !$weeks && !$days && !$hours && !$mins && !$sec )
    {
        $str .= '0seconds ';
    }
    else
    {
        $str .= '';
    }
   
    return $str;
}

/*---------------------------------
TEXT & GRAPHICS FUNCTIONS
----------------------------------*/

/*
GETURL FUNCTION
RETURNS URL IN NORMAL STYLE

PARAMETERS:
 FILE = THE FILE TO LOAD IN MAIN DIRECTORY
 ARGS = [KEY]=>[VAL] ARRAY OF ADDITIONAL GET PARAMETERS

EXAMPLE:
GETURL("INDEX",ARRAY("OP"=>"LOAD","ACTION"=>"DOIT"));

RETURNS
INDEX.PHP?OP=LOAD&ACTION=DOIT
*/
function geturl($file, $args = Array()) {
        $s = $file.".php";
        if (count($args) > 0) $s .="?";
        $i = 0;
        foreach ($args as $key=>$val) {
                if ($i != 0) $s .= "&";
                $s .= $key."=".$val;
                $i++;
        }
        return htmlspecialchars($s); //Required by W3C specifications
}
function unesc($x) { //Useful for escaping strings
        if (get_magic_quotes_gpc())
                return stripslashes($x);
        return $x;
}
function mksize($s) { //Byte, Kilobyte, Megabyte, Gigabyte size
        $x = 4;
        $a = array("","K","M","G","T");
        for (;;) {
                $v = pow(1024, $x);
                if (!$x OR $s >= $v) {
                        $ss = sprintf("%.2f", ($s / $v));
                        $xx = $ss . " " . $a[$x] . "B";
                        break;
                }
                $x--;
        }
        return $xx;
}
function formatTimestamp($time) {//Formats date & time
	global $user;
    setlocale(LC_TIME, $user->lang['_LOCALE']);
    preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $time, $datetime);
    $datetime = strftime($user->lang['_DATESTRING'], mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
    $datetime = ucfirst($datetime);
    return($datetime);
}
function mkprettytime($s) {//Formats date&time?
	global $user;
        if ($s < 0)
                $s = 0;
        $t = array();
        foreach (array("60:sec","60:min","24:hour","0:day") as $x) {
                $y = explode(":", $x);
                if ($y[0] > 1) {
                        $v = $s % $y[0];
                        $s = floor($s / $y[0]);
                }
                else
                        $v = $s;
                $t[$y[1]] = $v;
        }

        if ($t["day"])
                return $t["day"].$user->lang['_btdays'].", ".$t["hour"].$user->lang['_bthours']. $t["min"].$user->lang['_btmins'].$t["sec"].$user->lang['_btsecs'];
        if ($t["hour"])
                return $t["hour"].$user->lang['_bthours']. $t["min"].$user->lang['_btmins']. $t["sec"].$user->lang['_btsecs'];
        if ($t["min"])
                return $t["min"].$user->lang['_btmins']. $t["sec"].$user->lang['_btsecs'];
        return $t["sec"]. $user->lang['_btsecs'];
}

function urlparse($m) { //Makes URLs clickable
        $t = $m[0];
        if (preg_match(',^\w+://,', $t))
                return "<a href=\"".$t."\">".$t."</a>";
        return "<a href=\"http://".$t."\">".$t."</a>";
}
function parsedescr($d) { //Parses Torrent description
        $pd = str_replace(array("\n", "\r"), array("<br />\n", ""), htmlspecialchars($d));
       $pd = preg_replace_callback("`(http|ftp)+(s)?:(//)((\w|\.|\-|_)+)(/)?(\S+)?`i", "urlparse", $pd);
        return $pd;
}
function searchfield($s) {
        $s= preg_replace(array('/[^a-z0-9]/si', '/^\s*/s', '/\s*$/s', '/\s+/s'), array(" ", "", "", " "), $s);
		return str_replace(" ", " +", $s);
}
function parse_html(&$text) {
        $allowed_tags = Array(
		"<br />",
        "<p>",
        "<i>",
        "<u>",
        "<br>",
        "<img>",
        "<a>",
        "<ul>",
        "<ol>",
        "<tr>",
        "<td>",
        "<thead>",
        "<tbody>",
        "<hr>",
        "<div>",
        "<span>",
        "<strong>",
        "<strike>",
        "<pre>",
        "<address>",
        "<font>",
        "<h1>",
        "<h2>",
        "<h3>",
        "<h4>",
        "<h5>",
        "<h6>",
        "<h7>"
        );
       // $text = strip_tags($text,implode(",",$allowed_tags));
}
function get_formatted_filesize($value, $string_only = true, $allowed_units = false)
{
	global $user;

	$available_units = array(
		'gb' => array(
			'min' 		=> 1073741824, // pow(2, 30)
			'index'		=> 3,
			'si_unit'	=> 'GB',
			'iec_unit'	=> 'GIB',
		),
		'mb' => array(
			'min'		=> 1048576, // pow(2, 20)
			'index'		=> 2,
			'si_unit'	=> 'MB',
			'iec_unit'	=> 'MIB',
		),
		'kb' => array(
			'min'		=> 1024, // pow(2, 10)
			'index'		=> 1,
			'si_unit'	=> 'KB',
			'iec_unit'	=> 'KIB',
		),
		'b' => array(
			'min'		=> 0,
			'index'		=> 0,
			'si_unit'	=> 'BYTES', // Language index
			'iec_unit'	=> 'BYTES',  // Language index
		),
	);

	foreach ($available_units as $si_identifier => $unit_info)
	{
		if (!empty($allowed_units) && $si_identifier != 'b' && !in_array($si_identifier, $allowed_units))
		{
			continue;
		}

		if ($value >= $unit_info['min'])
		{
			$unit_info['si_identifier'] = $si_identifier;

			break;
		}
	}
	unset($available_units);

	for ($i = 0; $i < $unit_info['index']; $i++)
	{
		$value /= 1024;
	}
	$value = round($value, 2);

	// Lookup units in language dictionary
	$unit_info['si_unit'] = (isset($user->lang[$unit_info['si_unit']])) ? $user->lang[$unit_info['si_unit']] : $unit_info['si_unit'];
	$unit_info['iec_unit'] = (isset($user->lang[$unit_info['iec_unit']])) ? $user->lang[$unit_info['iec_unit']] : $unit_info['iec_unit'];

	// Default to IEC
	$unit_info['unit'] = $unit_info['iec_unit'];

	if (!$string_only)
	{
		$unit_info['value'] = $value;

		return $unit_info;
	}

	return $value  . ' ' . $unit_info['unit'];
}
function parse_smiles(&$text) { //Parses text against smiles
        global $db, $db_prefix;
        $sql = "SELECT * FROM ".$db_prefix."_smiles;";
        $smile_res = $db->sql_query($sql);
        $search = Array();
        $replace = Array();
        while ($smile = $db->sql_fetchrow($smile_res)) {
                $search[] = $smile["code"];
                $replace[] = "<img src=\"smiles/".$smile["file"]."\" border=\"0\" alt=\"".$smile["alt"]."\">";
        }
        $text = str_replace($search,$replace,$text);
        $db->sql_freeresult($smile_res);
		return $text;
}
function hex_esc($matches) {
        return sprintf("%02x", ord($matches[0]));
}
function catlist() { //Category List
        global $db, $db_prefix;
        $ret = array();
        if(! $res = $db->sql_query("SELECT id, name, image FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC") )
                bterror("SELECT id, name FROM ".$db_prefix."_categories ORDER BY sort_index, id ASC");
        while ($row = $db->sql_fetchrow($res))
                $ret[] = $row;
        return $ret;
}

function pic($name, $url = "", $alt = "", $h = false, $w = false) {//Gets a picture from theme directory
        global $theme, $user;
		$hi ="";
		$wi ="";
		if($h)$hi ="hidth=\"".$h."\"";
		if($w)$wi ="width=\"".$w."\"";
        if ($alt == "" AND $alt != null AND defined("_btalt_".$name)) $alt = constant("_btalt_".$name);

        $ret = "<img src=\"themes/".$theme."/pics/".$name."\" border=\"0\" alt=\"".$alt."\" title=\"".$alt."\" ".$hi." ".$wi." />";
        if ($url != "") {
                return "<a href=\"".$url."\">".$ret."</a>";
        }
        return $ret;
}

/**
* Generate regexp for naughty words censoring
* Depends on whether installed PHP version supports unicode properties
*
* @param string	$word			word template to be replaced
* @param bool	$use_unicode	whether or not to take advantage of PCRE supporting unicode
*
* @return string $preg_expr		regex to use with word censor
*/
function get_censor_preg_expression($word, $use_unicode = true)
{
	static $unicode_support = null;

	// Check whether PHP version supports unicode properties
	if (is_null($unicode_support))
	{
		$unicode_support = ((version_compare(PHP_VERSION, '5.1.0', '>=') || (version_compare(PHP_VERSION, '5.0.0-dev', '<=') && version_compare(PHP_VERSION, '4.4.0', '>='))) && @preg_match('/\p{L}/u', 'a') !== false) ? true : false;
	}

	// Unescape the asterisk to simplify further conversions
	$word = str_replace('\*', '*', preg_quote($word, '#'));

	if ($use_unicode && $unicode_support)
	{
		// Replace asterisk(s) inside the pattern, at the start and at the end of it with regexes
		$word = preg_replace(array('#(?<=[\p{Nd}\p{L}_])\*+(?=[\p{Nd}\p{L}_])#iu', '#^\*+#', '#\*+$#'), array('([\x20]*?|[\p{Nd}\p{L}_-]*?)', '[\p{Nd}\p{L}_-]*?', '[\p{Nd}\p{L}_-]*?'), $word);

		// Generate the final substitution
		$preg_expr = '#(?<![\p{Nd}\p{L}_-])(' . $word . ')(?![\p{Nd}\p{L}_-])#iu';
	}
	else
	{
		// Replace the asterisk inside the pattern, at the start and at the end of it with regexes
		$word = preg_replace(array('#(?<=\S)\*+(?=\S)#iu', '#^\*+#', '#\*+$#'), array('(\x20*?\S*?)', '\S*?', '\S*?'), $word);

		// Generate the final substitution
		$preg_expr = '#(?<!\S)(' . $word . ')(?!\S)#iu';
	}

	return $preg_expr;
}
function ratingpic($num) {//Gets the correct star rating picture
        $r = round($num * 2) / 2;
		//echo $r.'<br>';
        if ($r < 1 OR $r > 5) return;
		//echo pic($r."-rating.png");
        return pic($r."-rating.png");
}
function censor_text($text){
	static $censors;

	// Nothing to do?
	if ($text === '')
	{
		return '';
	}

	// We moved the word censor checks in here because we call this function quite often - and then only need to do the check once
	if (!isset($censors) || !is_array($censors))
	{
		global $config, $user, $auth, $pmbt_cache;

		// We check here if the user is having viewing censors disabled (and also allowed to do so).
		if (!$user->optionget('viewcensors') && $config['allow_nocensors'] && $auth->acl_get('u_chgcensors'))
		{
			$censors = array();
		}
		else
		{
			$censors = $pmbt_cache->obtain_word_list();
		}
	}

	if (sizeof($censors))
	{
		return preg_replace($censors['match'], $censors['replace'], $text);
	}

	return $text;
}
function no_parse_message($text_noparse) {
	$text_noparse = str_replace('[', '**-NoParseTagBegin-**', $text_noparse);
	$text_noparse = str_replace(']', '**-NoParseTagEnd-**', $text_noparse);
	$text_noparse = str_replace(':', '**-NoParseTagsmileis-**', $text_noparse);
	$text_noparse = str_replace('http', '**-NoParseurls-**', $text_noparse);
	$text_noparse = str_replace('HTTP', '**-NoParseurls-**', $text_noparse);
	return $text_noparse;
}
function format_comment($text, $strip_html = false, $strip_slash = false, $allow_urls = true)
{
	//return;
	global $smilies, $privatesmilies, $user, $db, $db_prefix;

	$s = $text;

	if ($strip_html)
		$s = htmlspecialchars($s);

	if ($strip_slash)
		$s = stripslashes($s);
	$s = preg_replace('#\[noparse\](.*)\[/noparse\]#sU', 'no_parse_message(\'$1\')', $s);
	$s = preg_replace('#\[np\](.*)\[/np\]#sU', 'no_parse_message(\'$1\')', $s);

$s = str_replace("]\n", "]", $s);
$match = array(
"/\[list\]\s*((\s|.)+?)\s*\[\/list\]/i",
"/\[list=(.*?)\]\s*((\s|.)+?)\s*\[\/list=(.*?)\]/i",
"/\[\*\]/i",
"/\[br\]/",
"/\[hr\]/",
"/\[b\]((\s|.)+?)\[\/b\]/",
"/\[i\]((\s|.)+?)\[\/i\]/",
"/\[u\]((\s|.)+?)\[\/u\]/",
"/\[img\](.*?)\[\/img\]/is",
"/\[img=((http|https):\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png))\]/i",
"/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",
"/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i",
"/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
"/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i",
"/\[size=([0-900]+)\]((\s|.)+?)\[\/size\]/i",
"/\[center\]((\s|.)+?)\[\/center\]/i",
"/\[font=([a-zA-Z ,]+)\]((\s|.)+?)\[\/font\]/i",
"/\[video=[^\s'\"<>]*video.google.com.*docid=(-?[0-9]+).*\]/ims",
'#\[code\](.*?)\[\/code\]#s',
'#\[code=php\](.*?)\[\/code\]#s',
'#\[php\](.*?)\[\/php\]#s',
"/\[skype\]((\s|.)+?)\[\/skype\]\s*/i",
"/\[website\](.*?)\[\/website\]\s*/i",
"/\[aim=(.*?)\](.*?)\[\/aim\]\s*/i",
"/\[attachment=(.*?)\](.*?)\[\/attachment\]\s*/i",
);
$replace = array(
"<span><ul>\\1</ul></span>",
"<span><ol TYPE=\\1>\\2</ol></span>",
"<li>",
"<br>",
"<hr>",
"<b>\\1</b>",
"<i>\\1</i>",
"<u>\\1</u>",
"<a href=\"\\1\" rel=\"lightbox[roadtrip]\" title=\"Image resized click to view full\" ><img border=0 src=\"\\1\" onload=\"SetSize(this, 500);\"></a>",
"<a href=\"\\1\" rel=\"lightbox[roadtrip]\" title=\"Image resized click to view full\" ><img border=0 src=\"\\1\" onload=\"SetSize(this, 500);\"></a>",
"<font color=\\1>\\2</font>",
"<font color=\\1>\\2</font>",
"<a href=redirect.php?url=\\1 target=\"_blank\">\\3</a>",
"<a href=redirect.php?url=\\1 target=\"_blank\">\\1</a>",
"<font size=\\1>\\2</font>",
"<center>\\1</center>",
"<font face=\"\\1\">\\2</font>",
"<embed style=\"width:500px; height:410px;\" id=\"VideoPlayback\" align=\"middle\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=\\1\" allowScriptAccess=\"sameDomain\" quality=\"best\" bgcolor=\"#ffffff\" scale=\"noScale\" wmode=\"window\" salign=\"TL\"  FlashVars=\"playerMode=embedded\"> </embed>",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.stripslashes('$1').'<td></tr></table><br /></dl>'",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.highlight_string(stripslashes('$1'), true).'<td></tr></table><br /></dl>'",
"'<dl class=\"codebox\"><dt>Code: <a href=\"#\" onclick=\"selectCode(this); return false;\">Select all</a></dt><table class=main2 border=0 cellspacing=0 cellpadding=10><tr><td>'.highlight_string(stripslashes('$1'), true).'<td></tr></table><br /></dl>'",
"<script type=\"text/javascript\" src=\"http://download.skype.com/share/skypebuttons/js/skypeCheck.js\"></script><a href=\"skype:spockst?call\"><img src=\"http://mystatus.skype.com/smallclassic/\\1\" style=\"border: none;\" width=\"114\" height=\"20\" alt=\"My status\" /></a>",
"<iframe src=\"\\1\" name=\"frame1\" scrolling=\"auto\" frameborder=\"0\" align=\"middle\" height = \"500px\" width = \"600px\"></iframe>",
"<img src=http://www.funnyweb.dk:8080/aim/\\1 alt=\\2>",
"<img src=./file.php?id=\\1 alt=\\2>",
);
$s = preg_replace($match, $replace, $s);
	// URLs
$sql = "SELECT *
FROM `" . $db_prefix . "_bbcodes`";
$res = $db->sql_query($sql);
$m = array();
$r = array();
        while ($row = $db->sql_fetchrow($res)) {
		$m[] = str_replace(array('[/','!\\','!i','!s','+)\\'),array('[\/','/\\','/','\s*/i','+?)\\'),$row['second_pass_match']);
		$r[] = $row['second_pass_replace'];
		}
$s = preg_replace($m, $r, $s);
	if($allow_urls)$s = format_urls($s);


	// Maintain spacing
	$s = str_replace("  ", " &nbsp;", $s);
	//Quotes
$s = format_quotes($s);
	// Linebreaks
	$s = nl2br($s);
	$s = str_replace('**-NoParseTagBegin-**', '[', $s);
	$s = str_replace('**-NoParseTagEnd-**', ']', $s);
	$s = str_replace('**-NoParseTagsmileis-**', ':', $s);
	$s = str_replace('**-NoParseurls-**', 'http', $s);

	return $s;
}
function format_urls($s)
{
global $user;

$s= preg_replace(array("/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^<>\s]+)/i"),array("[url=$2]$2[/url]"), $s);
$s= preg_replace(array('#\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]#s'),array("'<a href=redirect.php?url=$1 target=\"_blank\">'.getMetaTitle('$1').'</a>'"), $s);
	return $s;
}
function format_quotes($s)
{
   preg_match_all('/\\[quote.*?\\]/', $s, $result, PREG_PATTERN_ORDER);
    $openquotecount = count($openquote = $result[0]);
   preg_match_all('/\\[\/quote\\]/', $s, $result, PREG_PATTERN_ORDER);
    $closequotecount = count($closequote = $result[0]);

   if ($openquotecount != $closequotecount) return $s; // quote mismatch. Return raw string...

   // Get position of opening quotes
    $openval = array();
   $pos = -1;

   foreach($openquote as $val)
 $openval[] = $pos = strpos($s,$val,$pos+1);

   // Get position of closing quotes
   $closeval = array();
   $pos = -1;

   foreach($closequote as $val)
       $closeval[] = $pos = strpos($s,$val,$pos+1);


   for ($i=0; $i < count($openval); $i++)
 if ($openval[$i] > $closeval[$i]) return $s; // Cannot close before opening. Return raw string...


    $s = str_replace("[quote]","<p class=sub><b>Quote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>",$s);
   $s = preg_replace("/\\[quote=(.+?)\\]/", "<p class=sub><b>\\1 wrote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>", $s);
   $s = str_replace("[/quote]","</td></tr></table><br><p>",$s);
   return $s;
}
function username_is($id)
{
        global $db, $db_prefix;
			$sql = "SELECT COUNT(id) AS count, `name`, `username` FROM ".$db_prefix."_users WHERE `id` = '".$id."' GROUP BY id;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
            if ($row['count'] == 0) return "guest";
			else{
		    return (!$row['name'] == '' ? $row['name'] : $row['username']);
			}

}
function user_get_id_name(&$user_id_ary, &$username_ary, $user_type = false)
{
	global $db,$db_prefix;
	//die(print_r($username_ary));

	// Are both arrays already filled? Yep, return else
	// are neither array filled?
	if ($user_id_ary && $username_ary)
	{
		return false;
	}
	else if (!$user_id_ary && !$username_ary)
	{
		return 'NO_USERS';
	}

	$which_ary = ($user_id_ary) ? 'user_id_ary' : 'username_ary';

	if ($$which_ary && !is_array($$which_ary))
	{
		$$which_ary = array($$which_ary);
	}

	$sql_in = ($which_ary == 'user_id_ary') ? array_map('intval', $$which_ary) : array_map('utf8_clean_string', $$which_ary);
	unset($$which_ary);

	$user_id_ary = $username_ary = array();

	// Grab the user id/username records
	$sql_where = ($which_ary == 'user_id_ary') ? 'id' : 'clean_username';
	$sql = 'SELECT id, username
		FROM ' . $db_prefix . '_users
		WHERE ' . $db->sql_in_set($sql_where, $sql_in);

	if ($user_type !== false && !empty($user_type))
	{
		$sql .= ' AND ' . $db->sql_in_set('level', $user_type);
	}
	$result = $db->sql_query($sql);

	if (!($row = $db->sql_fetchrow($result)))
	{
		$db->sql_freeresult($result);
		return 'NO_USERS';
	}

	do
	{
		$username_ary[$row['id']] = $row['username'];
		$user_id_ary[] = $row['id'];
	}
	while ($row = $db->sql_fetchrow($result));
	$db->sql_freeresult($result);

	return false;
}
function getuser($name){
        global $db, $db_prefix;
            $sql = "SELECT `id` FROM ".$db_prefix."_users WHERE username ='".escape($name)."' OR name = '".escape($name)."' OR clean_username = '".escape(strtolower($name))."'";
			$res = $db->sql_query($sql) or btsqlerror($sql);
            if ($db->sql_numrows($res) == 0) return "0";
			else{
			$row = $db->sql_fetchrow($res);
		    return $row['id'];
			}
}
function gen_avatar($id, $hight = false, $width = false){
        global $db, $db_prefix, $user, $theme, $avon, $avstore, $siteurl, $avgal;	
		if(!$avon)return;
		// Colect Info on the user
			$sql = "SELECT COUNT(id) AS count, `name`, `username`, `avatar`, `avatar_type`, `avatar_ht`, `avatar_wt` FROM ".$db_prefix."_users WHERE `id` = '".$id."' LIMIT 1;";
			$res = $db->sql_query($sql) or btsqlerror($sql);
			$row = $db->sql_fetchrow($res);
			$noavatar = false;
			if ($row['count'] == 0)
			{
			// Check to find the Default Avatar
			if (is_file("themes/{$theme}/pics/noavatar.gif") AND is_readable("themes/{$theme}/pics/noavatar.gif"))$noavatar = 'noavatar.gif';
			elseif (is_file("themes/{$theme}/pics/noavatar.png") AND is_readable("themes/{$theme}/pics/noavatar.png"))$noavatar = 'noavatar.png';
			elseif (is_file("themes/{$theme}/pics/noavatar.jpg") AND is_readable("themes/{$theme}/pics/noavatar.jpg"))$noavatar = 'noavatar.jpg';
			if($noavatar)return pic($noavatar);
			else return $noavatar;
			}else{
			if ($row["avatar"] == "blank.gif"){
			if (is_file("themes/{$theme}/pics/noavatar.gif") AND is_readable("themes/{$theme}/pics/noavatar.gif"))$noavatar = 'noavatar.gif';
			elseif (is_file("themes/{$theme}/pics/noavatar.png") AND is_readable("themes/{$theme}/pics/noavatar.png"))$noavatar = 'noavatar.png';
			elseif (is_file("themes/{$theme}/pics/noavatar.jpg") AND is_readable("themes/{$theme}/pics/noavatar.jpg"))$noavatar = 'noavatar.jpg';
			if($noavatar)return pic($noavatar);
			else return $noavatar;
			}
			//die( $row['avatar_type']);
			$trueheight = $truewidth = 0;
                                if($row['avatar_type'] == 0)
								{
									$imageinfo = getimagesize("$siteurl/avatars/".$row["avatar"]);
                                	$truewidth = (isset($imageinfo[0]) ? $imageinfo[0] : 0);
                                	$trueheight = (isset($imageinfo[1]) ? $imageinfo[1] : 0);
								}
			$hight = " height=\"".(($hight)?$hight : $trueheight)."\"";
			$width = " width=\"".(($width)?$width : $truewidth)."\"";
			if($row['avatar_ht'] != "0")$hight = " height=\"".$row['avatar_ht']."px\"";
			if($row['avatar_wt'] != "0")$width = " width=\"".$row['avatar_wt']."px\"";
			if($row['avatar_type'] == 0)return "<img".$hight.$width."  src=\"$siteurl/avatars/".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			if($row['avatar_type'] == 1)return "<img".$hight.$width." src=\"$siteurl/".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			if($row['avatar_type'] == 2)return "<img".$hight.$width." src=\"".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			if($row['avatar_type'] == 3)return "<img".$hight.$width." src=\"./".$row["avatar"]."\" alt=\"".(($row["name"] == "") ? htmlspecialchars($row["username"]):htmlspecialchars($row["name"]))."\" border=\"0\">";
			}
			return $noavatar;
}
function is_image($path){
	if(is_array(@getimagesize($path))){
		return true;
	}
	return false;
}
if (!function_exists('stripos'))
{
	function stripos($haystack, $needle)
	{
		if (preg_match('#' . preg_quote($needle, '#') . '#i', $haystack, $m))
		{
			return strpos($haystack, $m[0]);
		}

		return false;
	}
}
function genrelist2() {
        global $db, $db_prefix;
 $row = $db->sql_query("SELECT id, name, image, parent_id, tabletype FROM ".$db_prefix."_categories ORDER BY parent_id, sort_index, id ASC");

 while ($mysqlcats = $db->sql_fetchrow($row))
 $allcats[] = $mysqlcats;

 $allcats2 = $allcats;
 
 $i = 0;
 
 foreach ($allcats as $cat)
 {

 if ($cat['parent_id'] == -1) 
 {

 $cats[] = $cat;
 $j = 0;
 foreach ($allcats2 as $subcat)
 {

 if (isset($cat['id']) AND $cat['id'] == $subcat['parent_id']) {

 //Subcategories
 $cats[$i]['subcategory'][] = $subcat;

 //Subcategories add parenttabletype
 $cats[$i]['subcategory'][$j]['parenttabletype'] = $cat['tabletype'];

 //Subcategories add idtabletype
 $cats[$i]['subcategory'][$j]['idtabletype'] = $subcat['id'].$subcat['tabletype'];

 //Subcategories description
 $cats[$i]['subcategory'][$j]['description'] = $cat['name']."->".$subcat['name'];

 //All link array for cats
 @$cats[$i]['categories'] .= "cats$cat[tabletype][]=$subcat[id]&amp;";

 $j++;
 }
 }
 
 //All link for cats
 $cats[$i]['categories'] = substr($cats[$i]['categories'],0,-5);
 $i++;

 }

 }

 return $cats;

}

function categories_table($cats, $wherecatina, $linkpage = '', $display = 'block')
{
global $theme;

 $html = "";

 $html .= "<div id=\"cats\" style=\"display: {$display};\">";
 $html .= "<table>";
 $html .= "<tbody align=\"left\"><tr>";

 $i = 0;

 $ncats = count($cats);
 $catsperrow = $ncats;

 $width = 100/$ncats;

 if(count($ncats) > 0);
 foreach( $cats as $cat )
 {
if (file_exists("themes/".$theme."/pics/cat_pics/".$cat['image']))$img = "themes/".$theme."/pics/cat_pics/" . $cat['image'] ;
else
$img = "cat_pics/" . $cat['image'] ;
 $html .= ($i && $i % $catsperrow == 0) ? "</tr><tr>" : "";
 $html .= "<td class=\"nopad\" style=\"padding-bottom: 2px;padding-left: 7px;\"><img src=\"" . $img  . "\" title=\"" . htmlspecialchars($cat['name']) . "\" alt=\"" . htmlspecialchars($cat['name']) . "\" width=\"30px\" border=\"0\">&nbsp;&nbsp;<input id=\"checkAll{$cat[tabletype]}\" type=\"checkbox\" onclick=\"checkAllFields(1,{$cat['tabletype']});\" type=\"checkbox\" " . ($cat['checked'] ? "checked " : "") . "><a href=\"javascript: ShowHideMainSubCats({$cat['tabletype']},{$ncats})\"><img border=\"0\" src=\"themes/".$theme."/pics/plus.gif\" id=\"pic{$cat['tabletype']}\" alt=\"Show/Hide\">&nbsp;" . htmlspecialchars($cat['name']) . "</a>&nbsp;".(($linkpage != '') ? "<a class=\"catlink\" href=\"{$linkpage}?{$cat['categories']}\">(All)</a>" : "")."</td>\n";
 $i++;
 }



 $nrows = ceil($ncats/$catsperrow);
 $lastrowcols = $ncats % $catsperrow;

 if ($lastrowcols != 0)
 {
 if ($catsperrow - $lastrowcols != 1)
 $html .= "<td rowspan=\"" . ($catsperrow - $lastrowcols) . "\">&nbsp;</td>";
 else
 $html .= "<td>&nbsp;</td>";
 }

 $html .= "</tr><tbody>";
 $html .= "</table>";
 $html .= "</div>";

 if(count($cats) > 0);
 foreach( $cats as $cat )
 {
 $subcats = $cat[subcategory];

 if (count($subcats) > 0)
 {
 $html .= subcategories_table($cat, $wherecatina, $linkpage, $ncats);
 }

 }

 return $html;
}


function subcategories_table($cats, $wherecatina, $linkpage = '', $ncats)
{
global $theme;
 $html = "";
 $html .= "<div id=\"tabletype".$cats['tabletype']."\" style=\"display: none;\">";
 $html .= "<table>";
 $html .= "<tbody align=\"left\"><tr>";
 $width = 100/$ncats;
 $subcats = $cats['subcategory'];
 $catsperrow = $ncats;
 $i = 0;
 if (count($subcats) >0)
 foreach ($subcats as $cat)
 {
if (file_exists("themes/".$theme."/pics/cat_pics/".$cat['image']))$img = "themes/".$theme."/pics/cat_pics/" . $cat['image'] ;
else
 $img = "cat_pics/" . $cat['image'] ;
 $html .= ($i && $i % $catsperrow == 0) ? "</tr><tr>" : "";
 $html .= "<td class=\"subcatlink\" style=\"padding-bottom: 2px;padding-left: 7px; width: ".$width."%;\">"
           ."<img src=\"" . $img  . "\" title=\"" . htmlspecialchars($cat['name']) . "\" alt=\"" . htmlspecialchars($cat['name']) . "\" width=\"30px\" border=\"0\">"
		   ."&nbsp;&nbsp;<input type=\"checkbox\" onclick=\"checkAllFields(2,".$cats['tabletype'].");\" name=\"cats".$cats['tabletype']."[]\" value=\"".$cat['id']."\" type=\"checkbox\" " . (in_array($cat['id'],$wherecatina) ? "checked " : "") . ">"
		   .(($linkpage != '') ? "<a href=\"".$linkpage."?cats".$cats['tabletype']."[]=".$cat['id']."\">" . htmlspecialchars($cat['name']) . "</a>" : htmlspecialchars($cat['name']))."</td>\n";
 $i++;
 }
 $nsubcats = count($subcats);
 $nrows = ceil($nsubcats/$catsperrow);
 $lastrowcols = $nsubcats % $catsperrow;
 if ($lastrowcols != 0)
 {
 if ($catsperrow - $lastrowcols != 1)
 $html .= "<td rowspan=\"" . ($catsperrow - $lastrowcols) . "\">&nbsp;</td>";
 else
 $html .= "<td>&nbsp;</td>";
 }
 $html .= "</tr>";
 $html .= "</tbody>";
 $html .= "</table>";
 $html .= "</div>";
 return $html;
}
function set_site_var($page_title = '')
{
    global $db, $db_prefix, $announce_message, $donatein, $donateasked, $nodonate, $donations, $phpEx, 
	$most_users_online_when, $most_users_online, $welcome_message, $version, $pivate_mode, $addprivate, 
	$theme, $template, $user, $sitename, $siteurl, $torrent_per_page, $allow_change_email,$shout_config,$auth;
				$languages = Array();
				$langdir = "language/common";
				$langhandle = opendir($langdir);
				while ($langfile = readdir($langhandle)) {
						if (preg_match("/\.php$/",$langfile) AND strtolower($langfile) != "mailtexts.php")
								$languages[str_replace(".php","",$langfile)] = ucwords(str_replace(".php","",$langfile));
				}
				closedir($langhandle);
				unset($langdir,$langfile);
		foreach ($languages as $key=>$val) {
		$template->assign_block_vars('lang_var', array(
											'KEY'			=>	$key,
											'VAL'			=>	$val,
											'SET'			=>	($user->ulanguage == $key)?true : false,
									));
		}
		unset($languages);
				$themes = Array();
				$thememaindir = "themes";
				$themehandle = opendir($thememaindir);
				while ($themedir = readdir($themehandle)) {
						if (is_dir($thememaindir."/".$themedir) AND $themedir != "." AND $themedir != ".." AND $themedir != "CVS")
								$themes[$themedir] = $themedir;
				}
				closedir($themehandle);
				unset($thememaindir,$themedir);
		foreach ($themes as $key=>$val) {
		$template->assign_block_vars('theme_var', array(
									'KEY'			=>	$key,
									'VAL'			=>	$val,
									'SET'			=>	($user->theme == $key)?true : false,
									));
		}
		unset($themes);
     if($user->user)
	 {
       //---Get User Peer Info --//
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'yes' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) $tseeding = "<p>".implode($torrents,"<br>")."</p>";
        else $tseeding = pic("upload.gif",null,$user->lang['T_U_SEED']);
        $tseedingcnt = $cnt;
        $db->sql_freeresult($res);
        unset($sql, $res, $torrents, $tor, $cnt);
        #Number of downloading Torrents
        $sql = "SELECT P.torrent AS id, T.name as name FROM ".$db_prefix."_peers P, ".$db_prefix."_torrents T WHERE P.uid = '".$user->id."' AND P.seeder = 'no' AND T.id = P.torrent;";
        $res = $db->sql_query($sql);
        $cnt = $db->sql_numrows($res);
        $torrents = Array();
        while ($tor = $db->sql_fetchrow($res)) {
                $torrents[] = htmlspecialchars((strlen($tor["name"]) > 33) ? substr($tor["name"],0,30)."..." : $tor["name"]);
        }
        if ($cnt > 0) $tleeching = "<p>".implode($torrents,"<br>")."</p>";
        else $tleeching = pic("download.gif",null,$user->lang['T_U_LEECH']);
        $tleechingcnt = $cnt;
        $db->sql_freeresult($res);
        unset($sql, $res, $torrents, $tor, $cnt);
		//---End User Peer Info --//
	}
	$welcome_message = format_comment($welcome_message);
	parse_smiles($welcome_message);
	$announce_message = format_comment($announce_message);
	parse_smiles($announce_message);
	//---Donation Info --//
	if($nodonate == "US")$type = "$";
	elseif($nodonate == "EU")$type = "&euro;";
	elseif($nodonate == "UK")$type = "&pound;";
	$perc = @round(100 * $donatein/$donateasked);
	$width = round(1.5 * $perc);
 	 if ($perc<= 1) {$pic = "".$nodonate.".gif"; $width = "100";}
 	 elseif ($perc<= 40) $pic = "loadbarred.gif";
	elseif ($perc<= 70) $pic = "loadbaryellow.gif";
    else $pic = "loadbargreen.gif";
	$donateimage = "<img height=15 width=$width src=\"images/$pic\" alt='$donatein)%'>";
	$template->assign_vars(array(
	    'SITE_NEWS'        => ($welcome_message != "") ? $welcome_message : '',
		'SITE_URL'		   => $siteurl,
		'PRIVATE_MODE'     => $pivate_mode,
		'PMBT_VER'       => $version,
		'PAGE_TITLE'       => $page_title,
		'SITENAME'         => $sitename,
		'S_ANNOUCEMENTS'   => $announce_message,
		'DONATION_IN'      => $type.$donatein,
		'DONATION_ASKED'   => $type.$donateasked,
		'DONATION_IMAGE'   => $donateimage,
		'DONATIO_ON'		=>	$donations,
		'DONATION_PERC'    => $perc,
		'S_MOST_USERS_ON'  => $most_users_online,
		'S_MOST_USERS_WN'  => $most_users_online_when,
		'U_SHOW_ARCADE'	   => $auth->acl_get('u_arcade_play_games')? true : false,
		'U_USER'           => $user->user,
		'U_PREMIUM'        => $user->premium,
		'U_MODERATOR'      => $user->moderator,
		'U_ADMIN'          => $user->admin,
		'U_VIEW_ADMIN_PAN'	=> checkaccess("m_see_admin_cp"),
		'S_USER_ID'        => $user->id,
		'S_IN_MCP'        => false,
		'S_IN_UCP'        => false,
		'U_USER_USERNAME'  => $user->name,
		'U_USER_NICK'	   => ($user->nick) ? $user->nick : false,
		'U_USER_LEVEL'     => $user->level,
		'U_USER_NEW_PM'    => $user->new_pm,
		'U_USER_UNRED_PM'  => $user->unread_pm,
		'U_USER_GROUP'     => $user->group,
		'U_USER_LANG'      => $user->ulanguage,
		'U_USER_CAN_SHOUT' => ($user->can_shout == 'true') ? true : false,
		'U_USER_LAST_SEEN' => $user->lastlogin,
		'U_USER_FORUM_BAN' => $user->forumbanned,
		'U_SEED_BONUS'     => ($user->user) ? $user->seedbonus : '',
		'U_UPLOADED'       => ($user->user) ? mksize($user->uploaded) : '0',
		'U_DOWNLOADED'     => ($user->user) ? mksize($user->downloaded) : '0',
		'U_RATIO'          => ($user->user) ? get_u_ratio($user->uploaded, $user->downloaded) : '--',
		'U_TSEEDING'       => ($user->user) ? (($tseedingcnt >0) ? addslashes($tseeding) : false) : false,
		'U_TSEEDING_CNT'   => ($user->user) ? $tseedingcnt : false,
		'U_TLEECHING'      => ($user->user) ? (($tleechingcnt > 0) ? addslashes($tleeching) : false) : false,
		'U_TLEECHINGCNT'   => ($user->user) ? $tleechingcnt : false,
		'U_AVATAR'         => gen_avatar($user->id),
		'U_USER_COLOR'     => $user->color,
		'U_INVITES'        => ($user->user) ? $user->invites : '0',
		'ALLOW_EMAIL_CHANGE'=> $allow_change_email,
		'S_SHOUT_IDL'		=>	$shout_config['idle_time'],
		'S_SHOUT_REF'		=>	$shout_config['refresh_time'],
		'S_CONTENT_DIRECTION' 	=> $user->lang['DIRECTION'],
		'S_CONTENT_FLOW_BEGIN'	=> ($user->lang['DIRECTION'] == 'ltr') ? 'left' : 'right',
		'S_CONTENT_FLOW_END'	=> ($user->lang['DIRECTION'] == 'ltr') ? 'right' : 'left',
		'S_CONTENT_ENCODING' 	=> $user->lang['CONTENT_ENCODING'],
		'S_USER_LANG'			=>	$user->lang['USER_LANG'],
		'T_IMAGESET_LANG_PATH'	=> "themes/" . $theme . '/pics/' . $user->ulanguage,
	));
}
function pmbt_include_templ($file, $block)
{
    global $db, $db_prefix, $phpEx,  $pmbt_cache, $welcome_message, $version, $pivate_mode, $addprivate, $theme, $template, $user, $sitename, $siteurl, $torrent_per_page;
	include_once($file);
	if(isset($array))
	{
		foreach($array as $val)
		{
			if(is_array($val))$template->assign_block_vars($block,$val);
		}
	}
}
function gmtime()
{
    return strtotime(get_date_time());
}
function get_date_time($timestamp = 0)
{
  if ($timestamp)
    return date("Y-m-d H:i:s", $timestamp);
  else
    return gmdate("Y-m-d H:i:s");
}
function close_out()
{
        global $db, $db_prefix, $user, $admin_email, $btuser, $autoscrape,$most_users_online , $dead_torrent_interval, $announce_interval, $down_limit, $autodel_users, $sitename, $autodel_users_time, $inactwarning_time, $siteurl,$forumbase, $forumshare;
        global $phpEx, $sourcedir, $config, $phpbb_root_path, $forumpx, $shout_config,$time_tracker_update,$pmbt_cache,$rewrite_engine;
	if ($user->user)
	{
        $pagename = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
        $sqlupdate = "UPDATE ".$db_prefix."_online_users 
						SET 
							page = '".$db->sql_escape($pagename)."', 
							last_action = NOW() 
						WHERE 
							id = ".$user->id." LIMIT 1;";
        $sqlinsert = "INSERT INTO ".$db_prefix."_online_users 
						VALUES (
							'".$user->id."',
							'".$db->sql_escape($pagename)."',
							 NOW(),
							  NOW()
						)";
        $res = $db->sql_query($sqlupdate);
        if (!$db->sql_affectedrows($res)) $db->sql_query($sqlinsert);
        $db->sql_query("UPDATE ".$db_prefix."_users 
						SET 
							lastpage = '".$db->sql_escape($user->page['page'])."' 
						WHERE 
							id = '".$user->id."'");
	}
	if($rewrite_engine)@include_once("include/rewrite.php");
	if(defined('PMBT_DEBUG'))include_once("include/cleanup.php");
	else
	@include_once("include/cleanup.php");
ob_end_flush();
die();
}
function mksecret($len = 20) {
    $ret = "";
    for ($i = 0; $i < $len; $i++)
        $ret .= chr(mt_rand(0, 255));
    return $ret;
}

function back_link($u_action)
{
	global $user;
	return '<br /><br /><a href="' . $u_action . '">&laquo; ' . $user->lang['BACK_TO_PREV'] . '</a>';
}
function _hash_crypt_private($password, $setting, &$itoa64)
{
	$output = '*';

	// Check for correct hash
	if (substr($setting, 0, 3) != '$H$')
	{
		return $output;
	}

	$count_log2 = strpos($itoa64, $setting[3]);

	if ($count_log2 < 7 || $count_log2 > 30)
	{
		return $output;
	}

	$count = 1 << $count_log2;
	$salt = substr($setting, 4, 8);

	if (strlen($salt) != 8)
	{
		return $output;
	}

	/**
	* We're kind of forced to use MD5 here since it's the only
	* cryptographic primitive available in all versions of PHP
	* currently in use.  To implement our own low-level crypto
	* in PHP would result in much worse performance and
	* consequently in lower iteration counts and hashes that are
	* quicker to crack (by non-PHP code).
	*/
	if (PHP_VERSION >= 5)
	{
		$hash = md5($salt . $password, true);
		do
		{
			$hash = md5($hash . $password, true);
		}
		while (--$count);
	}
	else
	{
		$hash = pack('H*', md5($salt . $password));
		do
		{
			$hash = pack('H*', md5($hash . $password));
		}
		while (--$count);
	}

	$output = substr($setting, 0, 12);
	$output .= _hash_encode64($hash, 16, $itoa64);

	return $output;
}
function _hash_encode64($input, $count, &$itoa64)
{
	$output = '';
	$i = 0;

	do
	{
		$value = ord($input[$i++]);
		$output .= $itoa64[$value & 0x3f];

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 8;
		}

		$output .= $itoa64[($value >> 6) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		if ($i < $count)
		{
			$value |= ord($input[$i]) << 16;
		}

		$output .= $itoa64[($value >> 12) & 0x3f];

		if ($i++ >= $count)
		{
			break;
		}

		$output .= $itoa64[($value >> 18) & 0x3f];
	}
	while ($i < $count);

	return $output;
}
function _hash($password)
{
	$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	$random_state = substr(md5(microtime()), 4, 16);
	$random = '';
	$count = 6;

	if (($fh = @fopen('/dev/urandom', 'rb')))
	{
		$random = fread($fh, $count);
		fclose($fh);
	}

	if (strlen($random) < $count)
	{
		$random = '';

		for ($i = 0; $i < $count; $i += 16)
		{
			$random_state = md5(substr(md5(microtime()), 4, 16) . $random_state);
			$random .= pack('H*', md5($random_state));
		}
		$random = substr($random, 0, $count);
	}

	$hash = _hash_crypt_private($password, _hash_gensalt_private($random, $itoa64), $itoa64);

	if (strlen($hash) == 34)
	{
		return $hash;
	}

	return md5($password);
}
if (!function_exists('str_split'))
{
	/**
	* A wrapper for the PHP5 function str_split()
	* @param array $string contains the string to be converted
	* @param array $split_length contains the length of each chunk
	*
	* @return  Converts a string to an array. If the optional split_length parameter is specified,
	*  	the returned array will be broken down into chunks with each being split_length in length,
	*  	otherwise each chunk will be one character in length. FALSE is returned if split_length is
	*  	less than 1. If the split_length length exceeds the length of string, the entire string is
	*  	returned as the first (and only) array element.
	*/
	function str_split($string, $split_length = 1)
	{
		if ($split_length < 1)
		{
			return false;
		}
		else if ($split_length >= strlen($string))
		{
			return array($string);
		}
		else
		{
			preg_match_all('#.{1,' . $split_length . '}#s', $string, $matches);
			return $matches[0];
		}
	}
}
function gen_sort_selects(&$limit_days, &$sort_by_text, &$sort_days, &$sort_key, &$sort_dir, &$s_limit_days, &$s_sort_key, &$s_sort_dir, &$u_sort_param, $def_st = false, $def_sk = false, $def_sd = false)
{
	global $user;

	$sort_dir_text = array('a' => $user->lang['ASCENDING'], 'd' => $user->lang['DESCENDING']);

	$sorts = array(
		'st'	=> array(
			'key'		=> 'sort_days',
			'default'	=> $def_st,
			'options'	=> $limit_days,
			'output'	=> &$s_limit_days,
		),

		'sk'	=> array(
			'key'		=> 'sort_key',
			'default'	=> $def_sk,
			'options'	=> $sort_by_text,
			'output'	=> &$s_sort_key,
		),

		'sd'	=> array(
			'key'		=> 'sort_dir',
			'default'	=> $def_sd,
			'options'	=> $sort_dir_text,
			'output'	=> &$s_sort_dir,
		),
	);
	$u_sort_param  = '';

	foreach ($sorts as $name => $sort_ary)
	{
		$key = $sort_ary['key'];
		$selected = $$sort_ary['key'];

		// Check if the key is selectable. If not, we reset to the default or first key found.
		// This ensures the values are always valid. We also set $sort_dir/sort_key/etc. to the
		// correct value, else the protection is void. ;)
		if (!isset($sort_ary['options'][$selected]))
		{
			if ($sort_ary['default'] !== false)
			{
				$selected = $$key = $sort_ary['default'];
			}
			else
			{
				@reset($sort_ary['options']);
				$selected = $$key = key($sort_ary['options']);
			}
		}

		$sort_ary['output'] = '<select name="' . $name . '" id="' . $name . '">';
		foreach ($sort_ary['options'] as $option => $text)
		{
			$sort_ary['output'] .= '<option value="' . $option . '"' . (($selected == $option) ? ' selected="selected"' : '') . '>' . $text . '</option>';
		}
		$sort_ary['output'] .= '</select>';

		$u_sort_param .= ($selected !== $sort_ary['default']) ? ((strlen($u_sort_param)) ? '&amp;' : '') . "{$name}={$selected}" : '';
	}

	return;
}
function GetFolderSize($d ="." ) {
    // © kasskooye and patricia benedetto
    $h = @opendir($d);
    if($h==0)return 0;

    while ($f=readdir($h)){
        if ( $f!= "..") {
            $sf+=filesize($nd=$d."/".$f);
            if($f!="."&&is_dir($nd)){
                $sf+=GetFolderSize ($nd);
            }
        }
    }
    closedir($h);
    return $sf ;
}
function getcomplaints() {
global $user;
       return array(0=>	$user->lang['RATE_A'],
	   				1=> $user->lang['RATE_B'],
					2=> $user->lang['RATE_C'],
					3=> $user->lang['RATE_D'],
					4=> $user->lang['RATE_E'],
					5=> $user->lang['RATE_F'],
					6=> $user->lang['RATE_G']
					);
} 
function btmr_own_realpath($path)
{
	// Now to perform funky shizzle

	// Switch to use UNIX slashes
	$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
	$path_prefix = '';

	// Determine what sort of path we have
	if (is_absolute($path))
	{
		$absolute = true;

		if ($path[0] == '/')
		{
			// Absolute path, *NIX style
			$path_prefix = '';
		}
		else
		{
			// Absolute path, Windows style
			// Remove the drive letter and colon
			$path_prefix = $path[0] . ':';
			$path = substr($path, 2);
		}
	}
	else
	{
		// Relative Path
		// Prepend the current working directory
		if (function_exists('getcwd'))
		{
			// This is the best method, hopefully it is enabled!
			$path = str_replace(DIRECTORY_SEPARATOR, '/', getcwd()) . '/' . $path;
			$absolute = true;
			if (preg_match('#^[a-z]:#i', $path))
			{
				$path_prefix = $path[0] . ':';
				$path = substr($path, 2);
			}
			else
			{
				$path_prefix = '';
			}
		}
		else if (isset($_SERVER['SCRIPT_FILENAME']) && !empty($_SERVER['SCRIPT_FILENAME']))
		{
			// Warning: If chdir() has been used this will lie!
			// Warning: This has some problems sometime (CLI can create them easily)
			$path = str_replace(DIRECTORY_SEPARATOR, '/', dirname($_SERVER['SCRIPT_FILENAME'])) . '/' . $path;
			$absolute = true;
			$path_prefix = '';
		}
		else
		{
			// We have no way of getting the absolute path, just run on using relative ones.
			$absolute = false;
			$path_prefix = '.';
		}
	}

	// Remove any repeated slashes
	$path = preg_replace('#/{2,}#', '/', $path);

	// Remove the slashes from the start and end of the path
	$path = trim($path, '/');

	// Break the string into little bits for us to nibble on
	$bits = explode('/', $path);

	// Remove any . in the path, renumber array for the loop below
	$bits = array_values(array_diff($bits, array('.')));

	// Lets get looping, run over and resolve any .. (up directory)
	for ($i = 0, $max = sizeof($bits); $i < $max; $i++)
	{
		// @todo Optimise
		if ($bits[$i] == '..' )
		{
			if (isset($bits[$i - 1]))
			{
				if ($bits[$i - 1] != '..')
				{
					// We found a .. and we are able to traverse upwards, lets do it!
					unset($bits[$i]);
					unset($bits[$i - 1]);
					$i -= 2;
					$max -= 2;
					$bits = array_values($bits);
				}
			}
			else if ($absolute) // ie. !isset($bits[$i - 1]) && $absolute
			{
				// We have an absolute path trying to descend above the root of the filesystem
				// ... Error!
				return false;
			}
		}
	}

	// Prepend the path prefix
	array_unshift($bits, $path_prefix);

	$resolved = '';

	$max = sizeof($bits) - 1;

	// Check if we are able to resolve symlinks, Windows cannot.
	$symlink_resolve = (function_exists('readlink')) ? true : false;

	foreach ($bits as $i => $bit)
	{
		if (@is_dir("$resolved/$bit") || ($i == $max && @is_file("$resolved/$bit")))
		{
			// Path Exists
			if ($symlink_resolve && is_link("$resolved/$bit") && ($link = readlink("$resolved/$bit")))
			{
				// Resolved a symlink.
				$resolved = $link . (($i == $max) ? '' : '/');
				continue;
			}
		}
		else
		{
			// Something doesn't exist here!
			// This is correct realpath() behaviour but sadly open_basedir and safe_mode make this problematic
			// return false;
		}
		$resolved .= $bit . (($i == $max) ? '' : '/');
	}

	// @todo If the file exists fine and open_basedir only has one path we should be able to prepend it
	// because we must be inside that basedir, the question is where...
	// @internal The slash in is_dir() gets around an open_basedir restriction
	if (!@file_exists($resolved) || (!is_dir($resolved . '/') && !is_file($resolved)))
	{
		return false;
	}

	// Put the slashes back to the native operating systems slashes
	$resolved = str_replace('/', DIRECTORY_SEPARATOR, $resolved);

	// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
	if (substr($resolved, -1) == DIRECTORY_SEPARATOR)
	{
		return substr($resolved, 0, -1);
	}

	return $resolved; // We got here, in the end!
}

if (!function_exists('realpath'))
{
	/**
	* A wrapper for realpath
	* @ignore
	*/
	function btmr_realpath($path)
	{
		return btmr_own_realpath($path);
	}
}
else
{
	/**
	* A wrapper for realpath
	*/
	function btmr_realpath($path)
	{
		$realpath = realpath($path);

		// Strangely there are provider not disabling realpath but returning strange values. :o
		// We at least try to cope with them.
		if ($realpath === $path || $realpath === false)
		{
			return btmr_own_realpath($path);
		}

		// Check for DIRECTORY_SEPARATOR at the end (and remove it!)
		if (substr($realpath, -1) == DIRECTORY_SEPARATOR)
		{
			$realpath = substr($realpath, 0, -1);
		}

		return $realpath;
	}
}
function generate_board_url($without_script_path = false)
{
	global $config, $user;

	$server_name = $user->host;
	$server_port = (!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');

		// Do not rely on cookie_secure, users seem to think that it means a secured cookie instead of an encrypted connection
		$cookie_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;
		$url = (($cookie_secure) ? 'https://' : 'http://') . $server_name;

		$script_path = $user->page['root_script_path'];

	if ($server_port && (($cookie_secure && $server_port <> 443) || (!$cookie_secure && $server_port <> 80)))
	{
		// HTTP HOST can carry a port number (we fetch $user->host, but for old versions this may be true)
		if (strpos($server_name, ':') === false)
		{
			$url .= ':' . $server_port;
		}
	}

	if (!$without_script_path)
	{
		$url .= $script_path;
	}

	// Strip / from the end
	if (substr($url, -1, 1) == '/')
	{
		$url = substr($url, 0, -1);
	}

	return $url;
}
function redirect($url, $return = false, $disable_cd_check = false)
{
	global $db, $user, $phpbb_root_path;

	if (empty($user->lang))
	{
		$user->set_lang('common',$user->ulanguage);
	}

	// Make sure no &amp;'s are in, this will break the redirect
	$url = str_replace('&amp;', '&', $url);

	// Determine which type of redirect we need to handle...
	$url_parts = parse_url($url);

	if ($url_parts === false)
	{
		// Malformed url, redirect to current page...
		$url = generate_board_url() . '/' . $user->page['page'];
	}
	else if (!empty($url_parts['scheme']) && !empty($url_parts['host']))
	{
		// Attention: only able to redirect within the same domain if $disable_cd_check is false (yourdomain.com -> www.yourdomain.com will not work)
		if (!$disable_cd_check && $url_parts['host'] !== $user->host)
		{
			$url = generate_board_url();
		}
	}
	else if ($url[0] == '/')
	{
		// Absolute uri, prepend direct url...
		$url = generate_board_url(true) . $url;
	}
	else
	{
		// Relative uri
		$pathinfo = pathinfo($url);

		// Is the uri pointing to the current directory?
		if ($pathinfo['dirname'] == '.')
		{
			$url = str_replace('./', '', $url);

			// Strip / from the beginning
			if ($url && substr($url, 0, 1) == '/')
			{
				$url = substr($url, 1);
			}

			if ($user->page['page_dir'])
			{
				$url = generate_board_url() . '/' . $user->page['page_dir'] . '/' . $url;
			}
			else
			{
				$url = generate_board_url() . '/' . $url;
			}
		}
		else
		{
			// Used ./ before, but $phpbb_root_path is working better with urls within another root path
			$root_dirs = explode('/', str_replace('\\', '/', phpbb_realpath($phpbb_root_path)));
			$page_dirs = explode('/', str_replace('\\', '/', phpbb_realpath($pathinfo['dirname'])));
			$intersection = array_intersect_assoc($root_dirs, $page_dirs);

			$root_dirs = array_diff_assoc($root_dirs, $intersection);
			$page_dirs = array_diff_assoc($page_dirs, $intersection);

			$dir = str_repeat('../', sizeof($root_dirs)) . implode('/', $page_dirs);

			// Strip / from the end
			if ($dir && substr($dir, -1, 1) == '/')
			{
				$dir = substr($dir, 0, -1);
			}

			// Strip / from the beginning
			if ($dir && substr($dir, 0, 1) == '/')
			{
				$dir = substr($dir, 1);
			}

			$url = str_replace($pathinfo['dirname'] . '/', '', $url);

			// Strip / from the beginning
			if (substr($url, 0, 1) == '/')
			{
				$url = substr($url, 1);
			}

			$url = (!empty($dir) ? $dir . '/' : '') . $url;
			$url = generate_board_url() . '/' . $url;
		}
	}

	// Make sure no linebreaks are there... to prevent http response splitting for PHP < 4.4.2
	if (strpos(urldecode($url), "\n") !== false || strpos(urldecode($url), "\r") !== false || strpos($url, ';') !== false)
	{
		trigger_error('Tried to redirect to potentially insecure url.' . $url , E_USER_ERROR);
	}

	// Now, also check the protocol and for a valid url the last time...
	$allowed_protocols = array('http', 'https', 'ftp', 'ftps');
	$url_parts = parse_url($url);

	if ($url_parts === false || empty($url_parts['scheme']) || !in_array($url_parts['scheme'], $allowed_protocols))
	{
		trigger_error('Tried to redirect to potentially insecure url.'.$url, E_USER_ERROR);
	}

	if ($return)
	{
		return $url;
	}

	// Redirect via an HTML form for PITA webservers
	if (@preg_match('#Microsoft|WebSTAR|Xitami#', getenv('SERVER_SOFTWARE')))
	{
		header('Refresh: 0; URL=' . $url);

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml" dir="' . $user->lang['DIRECTION'] . '" lang="' . $user->ulanguage . '" xml:lang="' . $user->ulanguage . '">';
		echo '<head>';
		echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
		echo '<meta http-equiv="refresh" content="0; url=' . str_replace('&', '&amp;', $url) . '" />';
		echo '<title>' . $user->lang['REDIRECT'] . '</title>';
		echo '</head>';
		echo '<body>';
		echo '<div style="text-align: center;">' . sprintf($user->lang['URL_REDIRECT'], '<a href="' . str_replace('&', '&amp;', $url) . '">', '</a>') . '</div>';
		echo '</body>';
		echo '</html>';

		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $url);
	exit;
}
?>