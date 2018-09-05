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
** File class.user.php 2018-02-18 14:32:00 joeroberts
**
** CHANGES
**
** 04-03-2018 added parked, disabled keys
**/
if (!defined('IN_PMBT'))
{
	include_once './../security.php';
	die ();
}
class User {
        var $id;
		var $view_dead_tor;
        var $name;
        var $level;
        var $group;
		var $ulanguage;
        var $user;
		var $ip;
        var $premium;
        var $moderator;
        var $admin;
		var $user_permissions;
		var $pm_popup;
        var $theme;
        var $act_key;
		var $seedbonus;
        var $email;
        var $passkey;
        var $session_id;
		var $can_shout;
		var $user_torrent_per_page;
		var $lang = array();
		var $new_pm;
		var $unread_pm;
		var $timezone = '0';
		var $host;
		var $pm_rule;
		var $load = 0;
		var $date_format = 'd M Y H:i';
		var $img;
		var $dst = false;
		var $lastpage;
		var $parked;
		var $disabled_reason;
		var $data = array();
		var $img_array = array();
		var $keyoptions = array('viewimg' => 0, 'viewflash' => 1, 'viewsmilies' => 2, 'viewsigs' => 3, 'viewavatars' => 4, 'viewcensors' => 5, 'attachsig' => 6, 'bbcode' => 8, 'smilies' => 9, 'popuppm' => 10, 'sig_bbcode' => 15, 'sig_smilies' => 16, 'sig_links' => 17, 'offensive' => 18);
		var $keyvalues = array();
		var $browser = '';

	/**
	* Constuctor
	* Set User
	*/
   function __construct($user) {
			global $db, $db_prefix, $siteurl, $cookiepath, $cookiedomain, $localhost_autologin, $sourcedir, $language, $theme, $_COOKIE, $_SERVER;
			$this->host					= $this->extract_current_hostname();
			$this->page					= $this->extract_current_page($sourcedir);
			$this->ip = getip();
			$val = microtime();
			if ((function_exists('sys_getloadavg') && $load = sys_getloadavg()) || ($load = explode(' ', @file_get_contents('/proc/loadavg'))))
			{
				$this->load = array_slice($load, 0, 1);
				$this->load = floatval($this->load[0]);
			}
			if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1" AND $localhost_autologin)
			{
					$uid = 1;
					$sql ="SELECT U.*, L.group_type, L.group_founder_manage, L.group_skip_auth, L.group_message_limit, L.group_colour
					FROM ".$db_prefix."_users U , ".$db_prefix."_level_settings L
					WHERE L.group_id = U.can_do AND id = '1'";
					$result = $db->sql_query($sql);
					if ($row = $db->sql_fetchrow($result)) {
							$this->id = $row["id"];
							$this->name = $row["username"];
							$this->level = $row["level"];
							$this->theme = (($row["theme"] AND $row["theme"] != 'NULL')? $row["theme"] : $theme);
							$this->email = $row["email"];
							if(isset($_COOKIE["bttestperm"]) AND $row["level"]== "admin")
							{
								$this->data['user_perm_from'] = $_COOKIE["user_perm_from"];
								$this->group = $_COOKIE["bttestperm"];
							}
							else
							$this->group = $row["can_do"];
							if (file_exists("./language/common/".$row["language"].".php"))
							$this->ulanguage = $row["language"];
							else
							$this->ulanguage = 'english';
							$this->passkey = $row["passkey"];
							$this->act_key = $row["act_key"];
							$this->lastpage = $row['lastpage'];
							$this->uploaded = $row["uploaded"];
							$this->downloaded = $row["downloaded"];
							$this->modcomment = $row["modcomment"];
							$this->invites = $row["invites"];
							$this->invitees = $row["invitees"];
							$this->seedbonus = $row["seedbonus"];
							$this->can_shout = $row["can_shout"];
							$this->color = $row["group_colour"];
							$this->lastlogin = $row["lastlogin"];
							$this->session_id = substr($val, 4, 16);
							$this->forumbanned = (($row["forumbanned"]== 'yes')? true : false);
							$this->user_torrent_per_page = $row["torrent_per_page"];
							$this->view_dead_tor = $row["view_dead_tor"];
							$this->sig = $row["signature"];
							$this->sig_bbcode_bitfield = $row["sig_bbcode_bitfield"];
							$this->sig_bbcode_uid = $row["sig_bbcode_uid"];
							$this->bbcode_bitfield = $row["bbcode_bitfield"];
							$this->bbcode_uid = $row["bbcode_uid"];
							$this->lapost = $row["user_lastpost_time"];
							$this->new_pm = $row["user_new_privmsg"];
							$this->unread_pm = $row["user_unread_privmsg"];
							$this->pm_popup = (($row["pm_popup"] == 'true')? true : false);
							$this->pm_rule = $row["user_message_rules"];
							$this->user_permissions = $row["user_permissions"];
							$this->user_notify = $row['user_notify'];
							$this->topic_show_days = $row['user_topic_show_days'];
							$this->topic_sortby_type = $row['user_topic_sortby_type'];
							$this->topic_sortby_dir = $row['user_topic_sortby_dir'];
							$this->posts_show_days = $row['user_post_show_days'];
							$this->posts_sortby_type = $row['user_post_sortby_type'];
							$this->posts_sortby_dir = $row['user_post_sortby_dir'];
							$this->user_type = $row["user_type"];
							$this->dst = $row["user_dst"] * 3600;
							$this->data['message_limit'] = '200';
							$this->data['session_page'] = $row['lastpage'];
							$this->data['user_full_folder'] = $row['user_full_folder'];
							$this->data['user_type'] = $row['user_type'];
							$this->data['user_lastmark'] = $row['user_lastmark'];
							$this->data['user_options'] = $row['user_options'];
							$this->data['signature'] = $row['signature'];
							$this->data['sig_bbcode_bitfield'] = $row['sig_bbcode_bitfield'];
							$this->data['sig_bbcode_uid'] = $row['sig_bbcode_uid'];
							$this->data['clean_username'] = $row['clean_username'];
							$this->date_format = $row['user_dateformat'];
							$this->timezone = $row['tzoffset']*60;
							$this->lastpost = $row['user_lastpost_time'];
							$this->posts = $row['user_posts'];
							$this->optionset('viewimg', 1);
							$this->parked = (($row['parked'] == 'true')? true : false);
							$this->disabled = (($row['disabled'] == 'true')? true : false);
							$this->disabled_reason = $row['disabled_reason'];
							$this->admin = true;
							$this->moderator = true;
							$this->premium = true;
							$this->user = true;
							$this->browser	= (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';
							return;
					} else die ("FATAL ERROR! NO ADMINISTRATOR SET. THIS SHOULD NEVER HAPPEN");
					return;
			}
			$user = cookie_decode($user);
			$uid = intval($user[0]);
			$username = addslashes($user[1]);
			$pwd = $user[2];
			$act_key = $user[3];

			if ($uid != "" AND $pwd != "") {
					$sql ="SELECT U.*, L.group_type, L.group_founder_manage, L.group_skip_auth, L.group_message_limit, L.group_colour
					FROM ".$db_prefix."_users U , ".$db_prefix."_level_settings L
					WHERE L.group_id = U.can_do AND id = '".$uid."' AND username = '".$username."' AND password = '".addslashes($pwd)."' AND act_key = '".addslashes($act_key)."';";
					$result = $db->sql_query($sql);
					if($row = $db->sql_fetchrow($result)) {
							if(isset($_COOKIE["bttestlevel"]) AND $row["level"]== "admin")$row["level"] = $_COOKIE["bttestlevel"];
							$this->id = $row["id"];
							$this->name = $row["username"];
							$this->nick = $row["name"];
							$this->level = $row["level"];
							$this->theme = (($row["theme"] AND $row["theme"] != 'NULL')? $row["theme"] : $theme);
							if(isset($_COOKIE["bttestperm"]) AND $row["level"]== "admin")
							{
								$this->data['user_perm_from'] = $_COOKIE["user_perm_from"];
								$this->group = $_COOKIE["bttestperm"];
							}
							else
							$this->group = $row["can_do"];
							$this->email = $row["email"];
							if (file_exists("./language/common/".$row["language"].".php"))
							$this->ulanguage = $row["language"];
							else
							$this->ulanguage = 'english';
							$this->passkey = $row["passkey"];
							$this->lastpage = $row['lastpage'];
							$this->act_key = $row["act_key"];
							$this->uploaded = $row["uploaded"];
							$this->downloaded = $row["downloaded"];
							$this->color = $row["group_colour"];
							$this->modcomment = $row["modcomment"];
							$this->invites = $row["invites"];
							$this->invitees = $row["invitees"];
							$this->seedbonus = $row["seedbonus"];
							$this->can_shout = $row["can_shout"];
							$this->lastlogin = $row["lastlogin"];
							$this->user_permissions = $row["user_permissions"];
							$this->user_type = $row["user_type"];
							$this->session_id = substr($val, 4, 16);
							$this->forumbanned = (($row["forumbanned"]== 'yes')? true : false);
							$this->user_torrent_per_page = $row["torrent_per_page"];
							$this->view_dead_tor = $row["view_dead_tor"];
							$this->sig = $row["signature"];
							$this->sig_bbcode_bitfield = $row["sig_bbcode_bitfield"];
							$this->user_notify = $row['user_notify'];
							$this->topic_show_days = $row['user_topic_show_days'];
							$this->topic_sortby_type = $row['user_topic_sortby_type'];
							$this->topic_sortby_dir = $row['user_topic_sortby_dir'];
							$this->posts_show_days = $row['user_post_show_days'];
							$this->posts_sortby_type = $row['user_post_sortby_type'];
							$this->posts_sortby_dir = $row['user_post_sortby_dir'];
							$this->sig_bbcode_uid = $row["sig_bbcode_uid"];
							$this->bbcode_bitfield = $row["bbcode_bitfield"];
							$this->bbcode_uid = $row["bbcode_uid"];
							$this->lapost = $row["user_lastpost_time"];
							$this->new_pm = $row["user_new_privmsg"];
							$this->unread_pm = $row["user_unread_privmsg"];
							$this->pm_rule = $row["user_message_rules"];
							$this->pm_popup = (($row["pm_popup"] == 'true')? true : false);
							$this->dst = $row["user_dst"] * 3600;
							$this->data['message_limit'] = $row['group_message_limit'];
							$this->data['session_page'] = $row['lastpage'];
							$this->data['user_full_folder'] = $row["user_full_folder"];
							$this->data['user_lastmark'] = $row['user_lastmark'];
							$this->data['user_type'] = $row['user_type'];
							$this->data['user_options'] = $row['user_options'];
							$this->data['signature'] = $row['signature'];
							$this->data['sig_bbcode_bitfield'] = $row['sig_bbcode_bitfield'];
							$this->data['sig_bbcode_uid'] = $row['sig_bbcode_uid'];
							$this->data['user_dateformat'] = $row['user_dateformat'];
							$this->data['clean_username'] = $row['clean_username'];
							$this->lastpost = $row['user_lastpost_time'];
							$this->posts = $row['user_posts'];
							$this->optionset('viewimg', 1);
							$this->timezone = $row['tzoffset']*60;
							$this->date_format = $row['user_dateformat'];
							$this->parked = (($row['parked'] == 'true')? true : false);
							$this->disabled = (($row['disabled'] == 'true')? true : false);
							$this->disabled_reason = $row['disabled_reason'];
							if ($row["level"] == "admin") {
									$this->admin = true;
									$this->moderator = true;
									$this->premium = true;
									$this->user = true;
							} elseif ($row["level"] == "moderator") {
									$this->admin = false;
									$this->moderator = true;
									$this->premium = true;
									$this->user = true;
							} elseif ($row["level"] == "premium") {
									$this->admin = false;
									$this->moderator = false;
									$this->premium = true;
									$this->user = true;
							} else {
									$this->admin = false;
									$this->moderator = false;
									$this->premium = false;
									$this->user = true;
							}
							$this->browser	= (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';
							return;
					}
			}
			$this->id = '0';
			$this->name = "Anonymous";
			$this->level = "guest";
			$this->ulanguage = $language;
			$this->group = "6";
			$this->admin = false;
			$this->moderator = false;
			$this->premium = false;
			$this->user = false;
			$this->email = "anonymous@phpmybittorrent";
			$this->act_key = "";
			$this->user_type = 0;
			$this->data['user_type'] = 0;
			$this->passkey = "";
			$this->invites = "";
			$this->color = $row["group_colour"];
			$this->data['user_dateformat'] = 'd M Y H:i';
			$this->date_format = $this->data['user_dateformat'];
			$this->user_torrent_per_page = "10";
			$this->view_dead_tor = 0;
			global $theme;
			$this->theme = $theme;
			$this->forumbanned = true;
			$this->seedbonus = '0';
			$this->nick = "guest";
			$this->lastlogin = '0000-00-00 00:00:00';
			$this->browser	= (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';
	}
	/*To not break everyone using your library, you have to keep backwards compatibility: 
	Add the PHP5-style constructor, but keep the PHP4-style one. */
	function User($user)
	{
		$this->__construct($user);
	}
	function lang()
	{
		$args = func_get_args();
		$key = $args[0];

		if (is_array($key))
		{
			$lang = &$this->lang[array_shift($key)];

			foreach ($key as $_key)
			{
				$lang = &$lang[$_key];
			}
		}
		else
		{
			$lang = &$this->lang[$key];
		}

		// Return if language string does not exist
		if (!isset($lang) || (!is_string($lang) && !is_array($lang)))
		{
			return $key;
		}

		// If the language entry is a string, we simply mimic sprintf() behaviour
		if (is_string($lang))
		{
			if (sizeof($args) == 1)
			{
				return $lang;
			}

			// Replace key with language entry and simply pass along...
			$args[0] = $lang;
			return call_user_func_array('sprintf', $args);
		}

		// It is an array... now handle different nullar/singular/plural forms
		$key_found = false;

		// We now get the first number passed and will select the key based upon this number
		for ($i = 1, $num_args = sizeof($args); $i < $num_args; $i++)
		{
			if (is_int($args[$i]))
			{
				$numbers = array_keys($lang);

				foreach ($numbers as $num)
				{
					if ($num > $args[$i])
					{
						break;
					}

					$key_found = $num;
				}
			}
		}

		// Ok, let's check if the key was found, else use the last entry (because it is mostly the plural form)
		if ($key_found === false)
		{
			$numbers = array_keys($lang);
			$key_found = end($numbers);
		}

		// Use the language string we determined and pass it to sprintf()
		$args[0] = $lang[$key_found];
		return call_user_func_array('sprintf', $args);
	}
	function set_lang($path, $langfile)
	{
		global $db, $db_prefix;
		if(file_exists("language/" . $path . "/" . $langfile . ".php"))
		{
			require_once("language/" . $path . "/" . $langfile . ".php");
		}
		else
		{
			require_once("language/" . $path . "/english.php");
		}
		if(isset($lang))
		{
			foreach($lang as $key => $value){
				$this->lang[$key] = $value;
			}
		}
		return @constant;
	}
	function img($img, $alt = '', $width = false, $suffix = '', $type = 'full_tag')
	{
		static $imgs;
		global $siteurl, $theme;

		$img_data = &$imgs[$img];
			// Use URL if told so
			$root_path = './' ;

		if (empty($img_data))
		{
			if (!isset($this->img_array[$img]))
			{

				// Do not fill the image to let designers decide what to do if the image is empty
				$img_data = array();
				if($suffix == '')
				{
					if (file_exists( $root_path . 'themes/' . $theme . '/pics/' . $this->ulanguage .'/' . $img . '.gif'))$suffix = 'gif';
					elseif (file_exists($root_path . 'themes/' . $theme . '/pics/' . $this->ulanguage .'/' . $img . '.png'))$suffix = 'png';
					elseif (file_exists($root_path . 'themes/' . $theme . '/pics/' . $this->ulanguage .'/' . $img . '.jpg'))$suffix = 'jpg';
				}
                $imageinfo = @getimagesize($root_path . 'themes/' . $theme . '/pics/' . $this->ulanguage .'/' . $img . '.' . $suffix);
				$this->img_array[$img]['image_width'] =(isset($imageinfo[0]) ? $imageinfo[0] : 0);
				$this->img_array[$img]['image_filename'] =$img . '.' . $suffix;
				$this->img_array[$img]['image_height'] =(isset($imageinfo[1]) ? $imageinfo[1] : 0);
			}

			if(!file_exists('./themes/' . $theme . '/pics/' . $this->ulanguage .'/' . $this->img_array[$img]['image_filename']))return $alt;
			$img_data['src'] = $siteurl . '/themes/' . $theme . '/pics/' . $this->ulanguage .'/' . $this->img_array[$img]['image_filename'];
			$img_data['width'] = $this->img_array[$img]['image_width'];
			$img_data['height'] = $this->img_array[$img]['image_height'];
		}

		$alt = (!empty($this->lang[$alt])) ? $this->lang[$alt] : $alt;

		switch ($type)
		{
			case 'src':
				return $img_data['src'];
			break;

			case 'width':
				return ($width === false) ? $img_data['width'] : $width;
			break;

			case 'height':
				return $img_data['height'];
			break;

			default:
				$use_width = ($width === false) ? $img_data['width'] : $width;

				return '<img src="' . $img_data['src'] . '"' . (($use_width) ? ' width="' . $use_width . '"' : '') . (($img_data['height']) ? ' height="' . $img_data['height'] . '"' : '') . ' alt="' . $alt . '" title="' . (($this->lang[$alt])? $this->lang[$alt] : $alt) . '" />';
			break;
		}
	}
	function optionset($key, $value, $data = false)
	{
		$var = ($data) ? $data : $this->data['user_options'];

		if ($value && !($var & 1 << $this->keyoptions[$key]))
		{
			$var += 1 << $this->keyoptions[$key];
		}
		else if (!$value && ($var & 1 << $this->keyoptions[$key]))
		{
			$var -= 1 << $this->keyoptions[$key];
		}
		else
		{
			return ($data) ? $var : false;
		}

		if (!$data)
		{
			$this->data['user_options'] = $var;
			return true;
		}
		else
		{
			return $var;
		}
	}
 	function optionget($key, $data = false)
	{
		if (!isset($this->keyvalues[$key]))
		{
			$var = ($data) ? $data : $this->data['user_options'];
			$this->keyvalues[$key] = ($var & 1 << $this->keyoptions[$key]) ? true : false;
		}

		return $this->keyvalues[$key];
	}
	function extract_current_hostname()
	{
		global $siteurl, $cookiepath, $cookiedomain;

		// Get hostname
		$host = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : ((!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : getenv('SERVER_NAME'));

		// Should be a string and lowered
		$host = (string) strtolower($host);

		// If host is equal the cookie domain or the server name (if config is set), then we assume it is valid
		if ((isset($cookiedomain) && $host === $cookiedomain) || (isset($siteurl) && $host === $siteurl))
		{
			return $host;
		}

		// Is the host actually a IP? If so, we use the IP... (IPv4)
		if (long2ip(ip2long($host)) === $host)
		{
			return $host;
		}

		// Now return the hostname (this also removes any port definition). The http:// is prepended to construct a valid URL, hosts never have a scheme assigned
		$host = @parse_url('http://' . $host);
		$host = (!empty($host['host'])) ? $host['host'] : '';

		// Remove any portions not removed by parse_url (#)
		$host = str_replace('#', '', $host);

		// If, by any means, the host is now empty, we will use a "best approach" way to guess one
		if (empty($host))
		{
			if (!empty($siteurl))
			{
				$host = $siteurl;
			}
			else if (!empty($cookiedomain))
			{
				$host = (strpos($cookiedomain, '.') === 0) ? substr($cookiedomain, 1) : $cookiedomain;
			}
			else
			{
				// Set to OS hostname or localhost
				$host = (function_exists('php_uname')) ? gethostbyaddr(gethostbyname(php_uname('n'))) : 'localhost';
			}
		}

		// It may be still no valid host, but for sure only a hostname (we may further expand on the cookie domain... if set)
		return $host;
	}
	function extract_current_page($root_path)
	{
		$page_array = array();

		// First of all, get the request uri...
		$script_name = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');
		$args = (!empty($_SERVER['QUERY_STRING'])) ? explode('&', $_SERVER['QUERY_STRING']) : explode('&', getenv('QUERY_STRING'));

		// If we are unable to get the script name we use REQUEST_URI as a failover and note it within the page array for easier support...
		if (!$script_name)
		{
			$script_name = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
			$script_name = (($pos = strpos($script_name, '?')) !== false) ? substr($script_name, 0, $pos) : $script_name;
			$page_array['failover'] = 1;
		}

		// Replace backslashes and doubled slashes (could happen on some proxy setups)
		$script_name = str_replace(array('\\', '//'), '/', $script_name);

		// Now, remove the sid and let us get a clean query string...
		$use_args = array();

		// Since some browser do not encode correctly we need to do this with some "special" characters...
		// " -> %22, ' => %27, < -> %3C, > -> %3E
		$find = array('"', "'", '<', '>');
		$replace = array('%22', '%27', '%3C', '%3E');

		foreach ($args as $key => $argument)
		{
			if (strpos($argument, 'sid=') === 0)
			{
				continue;
			}

			$use_args[] = str_replace($find, $replace, $argument);
		}
		unset($args);

		// The following examples given are for an request uri of {path to the phpbb directory}/adm/index.php?i=10&b=2

		// The current query string
		$query_string = trim(implode('&', $use_args));

		// basenamed page name (for example: index.php)
		$page_name = basename($script_name);
		$page_name = urlencode(htmlspecialchars($page_name));

		// current directory within the phpBB root (for example: adm)
		$root_dirs = explode('/', str_replace('\\', '/', btmr_realpath($root_path)));
		$page_dirs = explode('/', str_replace('\\', '/', btmr_realpath('./')));
		$intersection = array_intersect_assoc($root_dirs, $page_dirs);

		$root_dirs = array_diff_assoc($root_dirs, $intersection);
		$page_dirs = array_diff_assoc($page_dirs, $intersection);

		$page_dir = str_repeat('../', sizeof($root_dirs)) . implode('/', $page_dirs);

		if ($page_dir && substr($page_dir, -1, 1) == '/')
		{
			$page_dir = substr($page_dir, 0, -1);
		}

		// Current page from BTManager root (for example: adm/index.php?i=10&b=2)
		$page = (($page_dir) ? $page_dir . '/' : '') . $page_name . (($query_string) ? "?$query_string" : '');

		// The script path from the webroot to the current directory (for example: /phpBB3/adm/) : always prefixed with / and ends in /
		$script_path = trim(str_replace('\\', '/', dirname($script_name)));

		// The script path from the webroot to the BTManager root (for example: /BTManager/)
		$script_dirs = explode('/', $script_path);
		array_splice($script_dirs, -sizeof($page_dirs));
		$root_script_path = implode('/', $script_dirs) . (sizeof($root_dirs) ? '/' . implode('/', $root_dirs) : '');

		// We are on the base level (BTManager root == webroot), lets adjust the variables a bit...
		if (!$root_script_path)
		{
			$root_script_path = ($page_dir) ? str_replace($page_dir, '', $script_path) : $script_path;
		}

		$script_path .= (substr($script_path, -1, 1) == '/') ? '' : '/';
		$root_script_path .= (substr($root_script_path, -1, 1) == '/') ? '' : '/';

		$page_array += array(
			'page_name'			=> $page_name,
			'page_dir'			=> $page_dir,

			'query_string'		=> $query_string,
			'script_path'		=> str_replace(' ', '%20', htmlspecialchars($script_path)),
			'root_script_path'	=> str_replace(' ', '%20', htmlspecialchars($root_script_path)),

			'page'				=> $page,
			'forum'				=> (isset($_REQUEST['f']) && $_REQUEST['f'] > 0) ? (int) $_REQUEST['f'] : 0,
		);

		return $page_array;
	}
	function format_date($gmepoch, $format = false, $forcedate = false)
	{
		static $midnight;
		static $date_cache;

		$format = (!$format) ? $this->date_format : $format;
		$now = time();
		$delta = $now - $gmepoch;

		if (!isset($date_cache[$format]))
		{
			// Is the user requesting a friendly date format (i.e. 'Today 12:42')?
			$date_cache[$format] = array(
				'is_short'		=> strpos($format, '|'),
				'format_short'	=> substr($format, 0, strpos($format, '|')) . '||' . substr(strrchr($format, '|'), 1),
				'format_long'	=> str_replace('|', '', $format),
				'lang'			=> $this->lang['u_datetime'],
			);

			// Short representation of month in format? Some languages use different terms for the long and short format of May
			if ((strpos($format, '\M') === false && strpos($format, 'M') !== false) || (strpos($format, '\r') === false && strpos($format, 'r') !== false))
			{
				$date_cache[$format]['lang']['May'] = $this->lang['u_datetime']['May_short'];
			}
		}

		// Zone offset
		$zone_offset = ($this->timezone) + $this->dst;

		// Show date <= 1 hour ago as 'xx min ago' but not greater than 60 seconds in the future
		// A small tolerence is given for times in the future but in the same minute are displayed as '< than a minute ago'
		if ($delta <= 3600 && $delta > -60 && ($delta >= -5 || (($now / 60) % 60) == (($gmepoch / 60) % 60)) && $date_cache[$format]['is_short'] !== false && !$forcedate && isset($this->lang['u_datetime']['AGO']))
		{
			return $this->lang(array('u_datetime', 'AGO'), max(0, (int) floor($delta / 60)));
		}

		if (!$midnight)
		{
			list($d, $m, $y) = explode(' ', gmdate('j n Y', time() . $zone_offset));
			$midnight = gmmktime(0, 0, 0, $m, $d, $y) - $zone_offset;
		}

		if ($date_cache[$format]['is_short'] !== false && !$forcedate && !($gmepoch < $midnight - 86400 || $gmepoch > $midnight + 172800))
		{
			$day = false;

			if ($gmepoch > $midnight + 86400)
			{
				$day = $this->lang['TOMORROW'];
			}
			else if ($gmepoch > $midnight)
			{
				$day = $this->lang['TODAY'];
			}
			else if ($gmepoch > $midnight - 86400)
			{
				$day = $this->lang['YESTERDAY'];
			}

			if ($day !== false)
			{
				return str_replace('||', $this->lang['u_datetime'][$day], strtr(@gmdate($date_cache[$format]['format_short'], $gmepoch + $zone_offset), $date_cache[$format]['lang']));
			}
		}

		return strtr(@gmdate($date_cache[$format]['format_long'], $gmepoch + $zone_offset), $date_cache[$format]['lang']);
	}
}
?>