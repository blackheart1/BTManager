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
** File function_messenger.php 2018-02-18 14:32:00 joeroberts
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
class messenger
{
	var $vars, $msg, $replyto, $from, $subject;
	var $addresses = array();

	var $mail_priority = 3;
	var $use_queue = true;
	var $extra_headers = array();

	var $tpl_obj = NULL;
	var $tpl_msg = array();
	var $eol = "\n";

	/**
	* Constructor
	*/
	function __construct($use_queue = true)
	{
		global $config;

		$this->use_queue = (!$config['email_package_size']) ? false : $use_queue;
		$this->subject = '';

		// Determine EOL character (\n for UNIX, \r\n for Windows and \r for Mac)
		$this->eol = (!defined('PHP_EOL')) ? (($eol = strtolower(substr(PHP_OS, 0, 3))) == 'win') ? "\r\n" : (($eol == 'mac') ? "\r" : "\n") : PHP_EOL;
		$this->eol = (!$this->eol) ? "\n" : $this->eol;
	}
	/*To not break everyone using your library, you have to keep backwards compatibility: 
	Add the PHP5-style constructor, but keep the PHP4-style one. */
	function messenger($use_queue = true)
	{
		$this->__construct($use_queue);
	}

	/**
	* Resets all the data (address, template file, etc etc) to default
	*/
	function reset()
	{
		$this->addresses = $this->extra_headers = array();
		$this->vars = $this->msg = $this->replyto = $this->from = '';
		$this->mail_priority = 3;
	}

	/**
	* Sets an email address to send to
	*/
	function to($address, $realname = '')
	{
		global $config;

		if (!trim($address))
		{
			return;
		}

		$pos = isset($this->addresses['to']) ? sizeof($this->addresses['to']) : 0;

		$this->addresses['to'][$pos]['email'] = trim($address);

		// If empty sendmail_path on windows, PHP changes the to line
		if (!$config['smtp_delivery'] && DIRECTORY_SEPARATOR == '\\')
		{
			$this->addresses['to'][$pos]['name'] = '';
		}
		else
		{
			$this->addresses['to'][$pos]['name'] = trim($realname);
		}
	}

	/**
	* Sets an cc address to send to
	*/
	function cc($address, $realname = '')
	{
		if (!trim($address))
		{
			return;
		}

		$pos = isset($this->addresses['cc']) ? sizeof($this->addresses['cc']) : 0;
		$this->addresses['cc'][$pos]['email'] = trim($address);
		$this->addresses['cc'][$pos]['name'] = trim($realname);
	}

	/**
	* Sets an bcc address to send to
	*/
	function bcc($address, $realname = '')
	{
		if (!trim($address))
		{
			return;
		}

		$pos = isset($this->addresses['bcc']) ? sizeof($this->addresses['bcc']) : 0;
		$this->addresses['bcc'][$pos]['email'] = trim($address);
		$this->addresses['bcc'][$pos]['name'] = trim($realname);
	}

	/**
	* Sets a im contact to send to
	*/
	function im($address, $realname = '')
	{
		// IM-Addresses could be empty
		if (!trim($address))
		{
			return;
		}

		$pos = isset($this->addresses['im']) ? sizeof($this->addresses['im']) : 0;
		$this->addresses['im'][$pos]['uid'] = trim($address);
		$this->addresses['im'][$pos]['name'] = trim($realname);
	}

	/**
	* Set the reply to address
	*/
	function replyto($address)
	{
		$this->replyto = trim($address);
	}

	/**
	* Set the from address
	*/
	function from($address)
	{
		$this->from = trim($address);
	}

	/**
	* set up subject for mail
	*/
	function subject($subject = '')
	{
		$this->subject = trim($subject);
	}

	/**
	* Adds X-AntiAbuse headers
	*
	* @param array $config		Configuration array
	* @param user $user			A user object
	*
	* @return null
	*/
	function anti_abuse_headers($config, $user)
	{
		$this->headers('X-AntiAbuse: Board servername - ' . mail_encode($config['server_name']));
		$this->headers('X-AntiAbuse: User_id - ' . $user->id);
		$this->headers('X-AntiAbuse: Username - ' . mail_encode($user->name));
		$this->headers('X-AntiAbuse: User IP - ' . $user->ip);
	}
	/**
	* set up extra mail headers
	*/
	function headers($headers)
	{
		$this->extra_headers[] = trim($headers);
	}

	/**
	* Set the email priority
	*/
	function set_mail_priority($priority = 3)
	{
		$this->mail_priority = $priority;
	}

	/**
	* Set email template to use
	*/
	function template($template_file, $template_lang = '', $template_path = '')
	{
		global $config, $phpbb_root_path, $user, $language;

		if (!trim($template_file))
		{
			trigger_error('No template file for emailing set.', E_USER_ERROR);
		}

		if (!trim($template_lang))
		{
			// fall back to board default language if the user's language is
			// missing $template_file.  If this does not exist either,
			// $tpl->set_custom_template will do a trigger_error
			$template_lang = $user->ulanguage;
		}

		// tpl_msg now holds a template object we can use to parse the template file
		if (!isset($this->tpl_msg[$template_lang . $template_file]))
		{
			$this->tpl_msg[$template_lang . $template_file] = new template();
			$tpl = &$this->tpl_msg[$template_lang . $template_file];

			$fallback_template_path = false;

			if (!$template_path)
			{
				$template_path =  'language/email/' . $template_lang ;
				// we can only specify default language fallback when the path is not a custom one for which we
				// do not know the default language alternative
				if ($template_lang !== $user->ulanguage)
				{
					$fallback_template_path = 'language/email/' . $user->ulanguage ;
				}
			}

			$tpl->set_custom_template($template_path, $template_lang . '_email', $fallback_template_path);

			$tpl->set_filenames(array(
				'body'		=> $template_file . '.txt',
			));
		}

		$this->tpl_obj = &$this->tpl_msg[$template_lang . $template_file];
		$this->vars = &$this->tpl_obj->_rootref;
		$this->tpl_msg = '';

		return true;
	}

	/**
	* assign variables to email template
	*/
	function assign_vars($vars)
	{
		if (!is_object($this->tpl_obj))
		{
			return;
		}

		$this->tpl_obj->assign_vars($vars);
	}

	function assign_block_vars($blockname, $vars)
	{
		if (!is_object($this->tpl_obj))
		{
			return;
		}

		$this->tpl_obj->assign_block_vars($blockname, $vars);
	}

	/**
	* Send the mail out to the recipients set previously in var $this->addresses
	*/
	function send($method = 0, $break = false)
	{
		global $config, $user, $sitename, $siteurl;

		// We add some standard variables we always use, no need to specify them always
		if (!isset($this->vars['U_BOARD']))
		{
			$this->assign_vars(array(
				'U_BOARD'	=> $siteurl,
			));
		}

		if (!isset($this->vars['EMAIL_SIG']))
		{
			$this->assign_vars(array(
				'EMAIL_SIG'	=> str_replace('<br />', "\n", "-- \n" . htmlspecialchars_decode($config['board_email_sig'])),
			));
		}

		if (!isset($this->vars['SITENAME']))
		{
			$this->assign_vars(array(
				'SITENAME'	=> htmlspecialchars_decode($sitename),
			));
		}

		// Parse message through template
		$this->msg = trim($this->tpl_obj->assign_display('body'));

		// Because we use \n for newlines in the body message we need to fix line encoding errors for those admins who uploaded email template files in the wrong encoding
		$this->msg = str_replace("\r\n", "\n", $this->msg);

		// We now try and pull a subject from the email body ... if it exists,
		// do this here because the subject may contain a variable
		$drop_header = '';
		$match = array();
		if (preg_match('#^(Subject:(.*?))$#m', $this->msg, $match))
		{
			$this->subject = (trim($match[2]) != '') ? trim($match[2]) : (($this->subject != '') ? $this->subject : $user->lang['NO_EMAIL_SUBJECT']);
			$drop_header .= '[\r\n]*?' . preg_quote($match[1], '#');
		}
		else
		{
			$this->subject = (($this->subject != '') ? $this->subject : $user->lang['NO_EMAIL_SUBJECT']);
		}

		if ($drop_header)
		{
			$this->msg = trim(preg_replace('#' . $drop_header . '#s', '', $this->msg));
		}

		if ($break)
		{
			return true;
		}

		switch ($method)
		{
			case 0:
				$result = $this->msg_email();
			break;

			case 1:
				$result = $this->msg_jabber();
			break;

			case 2:
				$result = $this->msg_email();
				$this->msg_jabber();
			break;
		}

		$this->reset();
		return $result;
	}

	/**
	* Add error message to log
	*/
	function error($type, $msg)
	{
		global $user, $phpEx, $phpbb_root_path, $config;

		// Session doesn't exist, create it
		//if (!isset($user->session_id) || $user->session_id === '')
		//{
		//	$user->session_begin();
		//}

		$calling_page = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : $_ENV['PHP_SELF'];

		$message = '';
		switch ($type)
		{
			case 'EMAIL':
				$message = '<strong>EMAIL/' . (($config['smtp_delivery']) ? 'SMTP' : 'PHP/' . $config['email_function_name'] . '()') . '</strong>';
			break;

			default:
				$message = "<strong>$type</strong>";
			break;
		}

		$message .= '<br /><em>' . htmlspecialchars($calling_page) . '</em><br /><br />' . $msg . '<br />';
		add_log('critical', 'LOG_ERROR_' . $type, $message);
	}

	/**
	* Save to queue
	*/
	function save_queue()
	{
		global $config;

		if ($config['email_package_size'] && $this->use_queue && !empty($this->queue))
		{
			$this->queue->save();
			return;
		}
	}

	/**
	* Return email header
	*/
	function build_header($to, $cc, $bcc)
	{
		global $config, $siteurl;

		// We could use keys here, but we won't do this for 3.0.x to retain backwards compatibility
		$headers = array();

		$headers[] = 'From: ' . $this->from;

		if ($cc)
		{
			$headers[] = 'Cc: ' . $cc;
		}

		if ($bcc)
		{
			$headers[] = 'Bcc: ' . $bcc;
		}

		$headers[] = 'Reply-To: ' . $this->replyto;
		$headers[] = 'Return-Path: <' . $config['board_email'] . '>';
		$headers[] = 'Sender: <' . $config['board_email'] . '>';
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Message-ID: <' . md5(RandomAlpha(32)) . '@' . $siteurl . '>';
		$headers[] = 'Date: ' . date('r', time());
		$headers[] = 'Content-Type: text/plain; charset=UTF-8'; // format=flowed
		$headers[] = 'Content-Transfer-Encoding: 8bit'; // 7bit

		$headers[] = 'X-Priority: ' . $this->mail_priority;
		$headers[] = 'X-MSMail-Priority: ' . (($this->mail_priority == 4) ? 'Low' : (($this->mail_priority == 3) ? 'Normal' : 'High'));
		$headers[] = 'X-Mailer: phpBB3';
		$headers[] = 'X-MimeOLE: phpBB3';
		$headers[] = 'X-phpBB-Origin: phpbb://' . str_replace(array('http://', 'https://'), array('', ''), generate_board_url());

		if (sizeof($this->extra_headers))
		{
			$headers = array_merge($headers, $this->extra_headers);
		}

		return $headers;
	}

	/**
	* Send out emails
	*/
	function msg_email()
	{
		global $config, $user;

		if (empty($config['email_enable']))
		{
			return false;
		}

		// Addresses to send to?
		if (empty($this->addresses) || (empty($this->addresses['to']) && empty($this->addresses['cc']) && empty($this->addresses['bcc'])))
		{
			// Send was successful. ;)
			return true;
		}

		$use_queue = false;
		if ($config['email_package_size'] && $this->use_queue)
		{
			if (empty($this->queue))
			{
				$this->queue = new queue();
				$this->queue->init('email', $config['email_package_size']);
			}
			$use_queue = true;
		}

		if (empty($this->replyto))
		{
			$this->replyto = '<' . $config['board_contact'] . '>';
		}

		if (empty($this->from))
		{
			$this->from = '<' . $config['board_contact'] . '>';
		}

		$encode_eol = ($config['smtp_delivery']) ? "\r\n" : $this->eol;

		// Build to, cc and bcc strings
		$to = $cc = $bcc = '';
		foreach ($this->addresses as $type => $address_ary)
		{
			if ($type == 'im')
			{
				continue;
			}

			foreach ($address_ary as $which_ary)
			{
				$$type .= (($$type != '') ? ', ' : '') . (($which_ary['name'] != '') ? mail_encode($which_ary['name'], $encode_eol) . ' <' . $which_ary['email'] . '>' : $which_ary['email']);
			}
		}

		// Build header
		$headers = $this->build_header($to, $cc, $bcc);

		// Send message ...
		if (!$use_queue)
		{
			$mail_to = ($to == '') ? 'undisclosed-recipients:;' : $to;
			$err_msg = '';

			if ($config['smtp_delivery'])
			{
				$result = smtpmail($this->addresses, mail_encode($this->subject), wordwrap(utf8_wordwrap($this->msg), 997, "\n", true), $err_msg, $headers);
			}
			else
			{
				$result = phpbb_mail($mail_to, $this->subject, $this->msg, $headers, $this->eol, $err_msg);
			}

			if (!$result)
			{
				$this->error('EMAIL', $err_msg);
				return false;
			}
		}
		else
		{
			$this->queue->put('email', array(
				'to'			=> $to,
				'addresses'		=> $this->addresses,
				'subject'		=> $this->subject,
				'msg'			=> $this->msg,
				'headers'		=> $headers)
			);
		}

		return true;
	}

	/**
	* Send jabber message out
	*/
	function msg_jabber()
	{
		global $config, $db, $db_prefix, $user, $phpbb_root_path, $phpEx;

		if (empty($config['jab_enable']) || empty($config['jab_host']) || empty($config['jab_username']) || empty($config['jab_password']))
		{
			return false;
		}

		if (empty($this->addresses['im']))
		{
			// Send was successful. ;)
			return true;
		}

		$use_queue = false;
		if ($config['jab_package_size'] && $this->use_queue)
		{
			if (empty($this->queue))
			{
				$this->queue = new queue();
				$this->queue->init('jabber', $config['jab_package_size']);
			}
			$use_queue = true;
		}

		$addresses = array();
		foreach ($this->addresses['im'] as $type => $uid_ary)
		{
			$addresses[] = $uid_ary['uid'];
		}
		$addresses = array_unique($addresses);

		if (!$use_queue)
		{
			include_once($phpbb_root_path . 'includes/functions_jabber.' . $phpEx);
			$this->jabber = new jabber($config['jab_host'], $config['jab_port'], $config['jab_username'], $config['jab_password'], $config['jab_use_ssl']);

			if (!$this->jabber->connect())
			{
				$this->error('JABBER', $user->lang['ERR_JAB_CONNECT'] . '<br />' . $this->jabber->get_log());
				return false;
			}

			if (!$this->jabber->login())
			{
				$this->error('JABBER', $user->lang['ERR_JAB_AUTH'] . '<br />' . $this->jabber->get_log());
				return false;
			}

			foreach ($addresses as $address)
			{
				$this->jabber->send_message($address, $this->msg, $this->subject);
			}

			$this->jabber->disconnect();
		}
		else
		{
			$this->queue->put('jabber', array(
				'addresses'		=> $addresses,
				'subject'		=> $this->subject,
				'msg'			=> $this->msg)
			);
		}
		unset($addresses);
		return true;
	}
}

/**
* handling email and jabber queue
* @package phpBB3
*/
class queue
{
	var $data = array();
	var $queue_data = array();
	var $package_size = 0;
	var $cache_file = '';
	var $eol = "\n";

	/**
	* constructor
	*/
	function __construct()
	{
		global $phpEx, $phpbb_root_path,$pmbt_cache;

		$this->data = array();
		$this->cache_file = $phpbb_root_path . $pmbt_cache->cache_dir . "queue.$phpEx";

		// Determine EOL character (\n for UNIX, \r\n for Windows and \r for Mac)
		$this->eol = (!defined('PHP_EOL')) ? (($eol = strtolower(substr(PHP_OS, 0, 3))) == 'win') ? "\r\n" : (($eol == 'mac') ? "\r" : "\n") : PHP_EOL;
		$this->eol = (!$this->eol) ? "\n" : $this->eol;
	}
	function queue()
	{
		$this->__construct();
	}

	/**
	* Init a queue object
	*/
	function init($object, $package_size)
	{
		$this->data[$object] = array();
		$this->data[$object]['package_size'] = $package_size;
		$this->data[$object]['data'] = array();
	}

	/**
	* Put object in queue
	*/
	function put($object, $scope)
	{
		$this->data[$object]['data'][] = $scope;
	}

	/**
	* Obtains exclusive lock on queue cache file.
	* Returns resource representing the lock
	*/
	function lock()
	{
		// For systems that can't have two processes opening
		// one file for writing simultaneously
		if (file_exists($this->cache_file . '.lock'))
		{
			$mode = 'rb';
		}
		else
		{
			$mode = 'wb';
		}

		$lock_fp = @fopen($this->cache_file . '.lock', $mode);

		if ($mode == 'wb')
		{
			if (!$lock_fp)
			{
				// Two processes may attempt to create lock file at the same time.
				// Have the losing process try opening the lock file again for reading
				// on the assumption that the winning process created it
				$mode = 'rb';
				$lock_fp = @fopen($this->cache_file . '.lock', $mode);
			}
			else
			{
				// Only need to set mode when the lock file is written
				@chmod($this->cache_file . '.lock', 0666);
			}
		}

		if ($lock_fp)
		{
			@flock($lock_fp, LOCK_EX);
		}

		return $lock_fp;
	}

	/**
	* Releases lock on queue cache file, using resource obtained from lock()
	*/
	function unlock($lock_fp)
	{
		// lock() will return null if opening lock file, and thus locking, failed.
		// Accept null values here so that client code does not need to check them
		if ($lock_fp)
		{
			@flock($lock_fp, LOCK_UN);
			fclose($lock_fp);
		}
	}

	/**
	* Process queue
	* Using lock file
	*/
	function process()
	{
		global $db, $db_prefix, $config, $phpEx, $phpbb_root_path, $user;

		$lock_fp = $this->lock();

		set_config('last_queue_run', time(), true);

		if (!file_exists($this->cache_file) || filemtime($this->cache_file) > time() - $config['queue_interval'])
		{
			$this->unlock($lock_fp);
			return;
		}
		include($this->cache_file);

		foreach ($this->queue_data as $object => $data_ary)
		{
			@set_time_limit(0);

			if (!isset($data_ary['package_size']))
			{
				$data_ary['package_size'] = 0;
			}

			$package_size = $data_ary['package_size'];
			$num_items = (!$package_size || sizeof($data_ary['data']) < $package_size) ? sizeof($data_ary['data']) : $package_size;

			/*
			* This code is commented out because it causes problems on some web hosts.
			* The core problem is rather restrictive email sending limits.
			* This code is nly useful if you have no such restrictions from the
			* web host and the package size setting is wrong.

			// If the amount of emails to be sent is way more than package_size than we need to increase it to prevent backlogs...
			if (sizeof($data_ary['data']) > $package_size * 2.5)
			{
				$num_items = sizeof($data_ary['data']);
			}
			*/

			switch ($object)
			{
				case 'email':
					// Delete the email queued objects if mailing is disabled
					if (!$config['email_enable'])
					{
						unset($this->queue_data['email']);
						continue 2;
					}
				break;

				case 'jabber':
					if (!$config['jab_enable'])
					{
						unset($this->queue_data['jabber']);
						continue 2;
					}

					include_once($phpbb_root_path . 'includes/functions_jabber.' . $phpEx);
					$this->jabber = new jabber($config['jab_host'], $config['jab_port'], $config['jab_username'], $config['jab_password'], $config['jab_use_ssl']);

					if (!$this->jabber->connect())
					{
						messenger::error('JABBER', $user->lang['ERR_JAB_CONNECT']);
						continue 2;
					}

					if (!$this->jabber->login())
					{
						messenger::error('JABBER', $user->lang['ERR_JAB_AUTH']);
						continue 2;
					}

				break;

				default:
					$this->unlock($lock_fp);
					return;
			}

			for ($i = 0; $i < $num_items; $i++)
			{
				// Make variables available...
				extract(array_shift($this->queue_data[$object]['data']));

				switch ($object)
				{
					case 'email':
						$err_msg = '';
						$to = (!$to) ? 'undisclosed-recipients:;' : $to;

						if ($config['smtp_delivery'])
						{
							$result = smtpmail($addresses, mail_encode($subject), wordwrap(utf8_wordwrap($msg), 997, "\n", true), $err_msg, $headers);
						}
						else
						{
							$result = phpbb_mail($to, $subject, $msg, $headers, $this->eol, $err_msg);
						}

						if (!$result)
						{
							messenger::error('EMAIL', $err_msg);
							continue 2;
						}
					break;

					case 'jabber':
						foreach ($addresses as $address)
						{
							if ($this->jabber->send_message($address, $msg, $subject) === false)
							{
								messenger::error('JABBER', $this->jabber->get_log());
								continue 3;
							}
						}
					break;
				}
			}

			// No more data for this object? Unset it
			if (!sizeof($this->queue_data[$object]['data']))
			{
				unset($this->queue_data[$object]);
			}

			// Post-object processing
			switch ($object)
			{
				case 'jabber':
					// Hang about a couple of secs to ensure the messages are
					// handled, then disconnect
					$this->jabber->disconnect();
				break;
			}
		}

		if (!sizeof($this->queue_data))
		{
			@unlink($this->cache_file);
		}
		else
		{
			if ($fp = @fopen($this->cache_file, 'wb'))
			{
				fwrite($fp, "<?php\nif (!defined('IN_PMBT')) exit;\n\$this->queue_data = unserialize(" . var_export(serialize($this->queue_data), true) . ");\n\n?>");
				fclose($fp);

				//phpbb_chmod($this->cache_file, CHMOD_READ | CHMOD_WRITE);
			}
		}

		$this->unlock($lock_fp);
	}

	/**
	* Save queue
	*/
	function save()
	{
		if (!sizeof($this->data))
		{
			return;
		}

		$lock_fp = $this->lock();

		if (file_exists($this->cache_file))

		{
			include($this->cache_file);

			foreach ($this->queue_data as $object => $data_ary)
			{
				if (isset($this->data[$object]) && sizeof($this->data[$object]))
				{
					$this->data[$object]['data'] = array_merge($data_ary['data'], $this->data[$object]['data']);
				}
				else
				{
					$this->data[$object]['data'] = $data_ary['data'];
				}
			}
		}

		if ($fp = @fopen($this->cache_file, 'w'))
		{
			fwrite($fp, "<?php\nif (!defined('IN_PMBT')) exit;\n\$this->queue_data = unserialize(" . var_export(serialize($this->data), true) . ");\n\n?>");
			fclose($fp);

			//phpbb_chmod($this->cache_file, CHMOD_READ | CHMOD_WRITE);
		  @chmod($this->cache_file, 0755);
		}

		$this->unlock($lock_fp);
	}
}

/**
* Replacement or substitute for PHP's mail command
*/
function smtpmail($addresses, $subject, $message, &$err_msg, $headers = false)
{
	global $config, $user, $sitename;
	require_once 'include/PHPMailerAutoload.php';
	// Fix any bare linefeeds in the message to make it RFC821 Compliant.
	$message = preg_replace("#(?<!\r)\n#si", "\r\n", $message);

	$mail_smtp = new PHPMailer();
	$mail_smtp->isSMTP();
	$mail_smtp->SMTPSecure = strtolower($config['smtp_delivery_ssl']);
	$mail_smtp->SMTPDebug = $config['smtp_debug'];
	$mail_smtp->do_debug = 3;
	$mail_smtp->Host = $config['smtp_host'];
	$mail_smtp->Port = $config['smtp_port'];
	$mail_smtp->SMTPAuth = $config['smtp_authentication'];
	$mail_smtp->Username = $config['smtp_username'];
	$mail_smtp->Password = $config['smtp_password'];
	$mail_smtp->setFrom($config['board_email'], $sitename);
	$mail_smtp->addReplyTo($config['board_contact'], $sitename);

	if (trim($subject) == '')
	{
		$err_msg = (isset($user->lang['NO_EMAIL_SUBJECT'])) ? $user->lang['NO_EMAIL_SUBJECT'] : 'No email subject specified';
		return false;
	}

	if (trim($message) == '')
	{
		$err_msg = (isset($user->lang['NO_EMAIL_MESSAGE'])) ? $user->lang['NO_EMAIL_MESSAGE'] : 'Email message was blank';
		return false;
	}


	// Build correct addresses for RCPT TO command and the client side display (TO, CC)
	if (isset($addresses['to']) && sizeof($addresses['to']))
	{
		foreach ($addresses['to'] as $which_ary)
		{
			$mail_smtp->addAddress($which_ary['email'], $which_ary['name']);
		}
	}

	if (isset($addresses['bcc']) && sizeof($addresses['bcc']))
	{
		foreach ($addresses['bcc'] as $which_ary)
		{
			$mail_smtp->addBCC($which_ary['email'], $which_ary['name']);
		}
	}

	if (isset($addresses['cc']) && sizeof($addresses['cc']))
	{
		foreach ($addresses['cc'] as $which_ary)
		{
			$mail_smtp->addCC($which_ary['email'], $which_ary['name']);
		}
	}

	$mail_smtp->Subject = $subject;
	$mail_smtp->Body = $message;
	if (!$mail_smtp->send()) {
	   return false;
	} else {
		return true;
	}
}

/**
* SMTP Class
* Auth Mechanisms originally taken from the AUTH Modules found within the PHP Extension and Application Repository (PEAR)
* See docs/AUTHORS for more details
* @package phpBB3
*/
class smtp_class
{
	var $server_response = '';
	var $socket = 0;
	var $responses = array();
	var $commands = array();
	var $numeric_response_code = 0;

	var $backtrace = false;
	var $backtrace_log = array();

	function __construct()
	{
		// Always create a backtrace for admins to identify SMTP problems
		$this->backtrace = true;
		$this->backtrace_log = array();
	}
	function smtp_class()
	{
		$this->__construct();
	}

	/**
	* Add backtrace message for debugging
	*/
	function add_backtrace($message)
	{
		if ($this->backtrace)
		{
			$this->backtrace_log[] = utf8_htmlspecialchars($message);
		}
	}

	/**
	* Send command to smtp server
	*/
	function server_send($command, $private_info = false)
	{
		fputs($this->socket, $command . "\r\n");

		(!$private_info) ? $this->add_backtrace("# $command") : $this->add_backtrace('# Omitting sensitive information');

		// We could put additional code here
	}

	/**
	* We use the line to give the support people an indication at which command the error occurred
	*/
	function server_parse($response, $line)
	{
		global $user;

		$this->server_response = '';
		$this->responses = array();
		$this->numeric_response_code = 0;

		while (substr($this->server_response, 3, 1) != ' ')
		{
			if (!($this->server_response = fgets($this->socket, 256)))
			{
				return (isset($user->lang['NO_EMAIL_RESPONSE_CODE'])) ? $user->lang['NO_EMAIL_RESPONSE_CODE'] : 'Could not get mail server response codes';
			}
			$this->responses[] = substr(rtrim($this->server_response), 4);
			$this->numeric_response_code = (int) substr($this->server_response, 0, 3);

			$this->add_backtrace("LINE: $line <- {$this->server_response}");
		}

		if (!(substr($this->server_response, 0, 3) == $response))
		{
			$this->numeric_response_code = (int) substr($this->server_response, 0, 3);
			return (isset($user->lang['EMAIL_SMTP_ERROR_RESPONSE'])) ? sprintf($user->lang['EMAIL_SMTP_ERROR_RESPONSE'], $line, $this->server_response) : "Ran into problems sending Mail at <strong>Line $line</strong>. Response: $this->server_response";
		}

		return 0;
	}

	/**
	* Close session
	*/
	function close_session(&$err_msg)
	{
		fclose($this->socket);

		if ($this->backtrace)
		{
			$message = '<h1>Backtrace</h1><p>' . implode('<br />', $this->backtrace_log) . '</p>';
			$err_msg .= $message;
		}
	}

	/**
	* Log into server and get possible auth codes if neccessary
	*/
}

/**
* Encodes the given string for proper display in UTF-8.
*
* This version is using base64 encoded data. The downside of this
* is if the mail client does not understand this encoding the user
* is basically doomed with an unreadable subject.
*
* Please note that this version fully supports RFC 2045 section 6.8.
*
* @param string $eol End of line we are using (optional to be backwards compatible)
*/
function mail_encode($str, $eol = "\r\n")
{
	// define start delimimter, end delimiter and spacer
	$start = "=?UTF-8?B?";
	$end = "?=";
	$delimiter = "$eol ";

	// Maximum length is 75. $split_length *must* be a multiple of 4, but <= 75 - strlen($start . $delimiter . $end)!!!
	$split_length = 60;
	$encoded_str = base64_encode($str);

	// If encoded string meets the limits, we just return with the correct data.
	if (strlen($encoded_str) <= $split_length)
	{
		return $start . $encoded_str . $end;
	}

	// If there is only ASCII data, we just return what we want, correctly splitting the lines.
	if (strlen($str) === utf8_strlen($str))
	{
		return $start . implode($end . $delimiter . $start, str_split($encoded_str, $split_length)) . $end;
	}

	// UTF-8 data, compose encoded lines
	$array = utf8_str_split($str);
	$str = '';

	while (sizeof($array))
	{
		$text = '';

		while (sizeof($array) && intval((strlen($text . $array[0]) + 2) / 3) << 2 <= $split_length)
		{
			$text .= array_shift($array);
		}

		$str .= $start . base64_encode($text) . $end . $delimiter;
	}

	return substr($str, 0, -strlen($delimiter));
}

/**
* Wrapper for sending out emails with the PHP's mail function
*/
function phpbb_mail($to, $subject, $msg, $headers, $eol, &$err_msg)
{
	global $config;

	// We use the EOL character for the OS here because the PHP mail function does not correctly transform line endings. On Windows SMTP is used (SMTP is \r\n), on UNIX a command is used...
	// Reference: http://bugs.php.net/bug.php?id=15841
	$headers = implode($eol, $headers);

	ob_start();
	// On some PHP Versions mail() *may* fail if there are newlines within the subject.
	// Newlines are used as a delimiter for lines in mail_encode() according to RFC 2045 section 6.8.
	// Because PHP can't decide what is wanted we revert back to the non-RFC-compliant way of separating by one space (Use '' as parameter to mail_encode() results in SPACE used)
	$result = $config['email_function_name']($to, mail_encode($subject, ''), wordwrap(utf8_wordwrap($msg), 997, "\n", true), $headers);
	$err_msg = ob_get_clean();

	return $result;
}

?>