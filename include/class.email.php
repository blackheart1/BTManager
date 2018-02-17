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
* @version $Id: 3.0.0 class.email.php  2010-11-04 00:22:48 joeroberts $
* @copyright (c) 2010 phpMyBitTorrent Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
class eMail {

        var $sender;
        var $recipient = Array();
        var $subject;
        var $body;

        function eMail() {
                global $admin_email, $sitename;
                $this->sender = $admin_email;
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