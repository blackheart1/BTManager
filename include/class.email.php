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
** File class.email.php 2018-02-18 14:32:00 joeroberts
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
class eMail {

        var $sender;
        var $recipient = Array();
        var $subject;
        var $body;

	/**
	* Constuctor
	* Set Admin mail
	*/
        function __construct() {
                global $admin_email, $sitename;
                $this->sender = $admin_email;
        }

	/*To not break everyone using your library, you have to keep backwards compatibility: 
	Add the PHP5-style constructor, but keep the PHP4-style one. */
		function eMail()
		{
			$this->__construct();
		}
        function Send() {
                global $admin_email, $sitename, $siteurl,$cookiedomain;
				ini_set("SMTP","smtp.".$this->sender);
				ini_set('sendmail_from', $this->sender); 
				$line_break = "\r\n";
				$headers = 'From: "' . $sitename . '" <'.$this->sender . '>' . $line_break .
				'Reply-To: ' .$this->sender . $line_break .
				'Date: ' . gmdate('D, d M Y H:i:s') . ' -0000' . $line_break .
				'MIME-Version: 1.0' . $line_break .
				'Content-type: text/plain; charset=utf-8' . $line_break .
				'X-Mailer: PHP'. $line_break ;
				//die($headers);
				mail(implode(", ", $this->recipient),$this->subject,$this->body,$headers,"-f ".$this->sender);
                return true;

        }
		
		function get_mail_text($file, $file_lang = NULL)
		{
			global $language;
			if($file_lang AND file_exists("language/email/" . $file_lang . "/" . $file . ".txt")) $file_lang = $file_lang;
			else
			$file_lang = $language;
			if (($data = @file_get_contents('language/email/' . $file_lang . '/' . $file . '.txt')) === false)
			{
				trigger_error("Failed opening template file [ language/email/" . $file_lang . "/authgrant.txt ]", E_USER_ERROR);
			}
			return $data;
		}
		
		function clean_body($pass)
		{
			global $siteurl, $sitename;
			$args = func_get_args();
			$mode			= array_shift($args);
			foreach($pass as $i=>$v)
			{
			$$i = $v;
			}
			eval('$data = "' . $data . '";');
			if (!function_exists('utf8_wordwrap'))
			{
			 include_once("include/utf/utf_tools.php");
			}
			$this->body = wordwrap(utf8_wordwrap($data), 70, "\r\n", true);
		}

        function Add($email, $name = false) {
                if (is_email($email)){
					if($name)
					{
						$this->recipient[] = $name . ' <' . $email . '>';
					}
					else
					{
						$this->recipient[] = $email;
					}
				}
        }
}



class MailingList {

                var $mails = Array();

                function Insert($mail) {

                        $this->mails[] = $mail;

                }

                function Sendmail() {

                        if (count($this->mails) <1 ) return;

                        foreach ($this->mails as $mail) {

                                $mail->Send();

                        }

                }



}

?>