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
** File bittorrent.php 2018-02-18 14:32:00 joeroberts
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
if ($use_rsa) require_once("include/rsalib.php");
require_once("include/functions.php");
require_once("include/class.user.php");
require_once("include/class.email.php");
if ($use_rsa) $rsa = New RSA($rsa_modulo, $rsa_public, $rsa_private);
if(!function_exists('str_ireplace')) {
    function str_ireplace($search, $replacement, $string){
        $delimiters = array(1,2,3,4,5,6,7,8,14,15,16,17,18,19,20,21,22,23,24,25,
        26,27,28,29,30,31,33,247,215,191,190,189,188,187,186,
        185,184,183,182,180,177,176,175,174,173,172,171,169,
        168,167,166,165,164,163,162,161,157,155,153,152,151,
        150,149,148,147,146,145,144,143,141,139,137,136,135,
        134,133,132,130,129,128,127,126,125,124,123,96,95,94,
        63,62,61,60,59,58,47,46,45,44,38,37,36,35,34);
        foreach ($delimiters as $d) {
            if (strpos($string, chr($d))===false){
                $delimiter = chr($d);
                break;
            }
        }
        if (!empty($delimiter)) {
            return preg_replace($delimiter.quotemeta($search).$delimiter.'i', $replacement, $string);
        }
        else { 
            trigger_error('Homemade str_ireplace could not find a proper delimiter.', E_USER_ERROR);
        }
    }
}
function search_word($word, $search){
if(empty($search))return $word;
$search = str_replace("+"," ",$search);
$newterm = str_ireplace($search,"<span class=\"highlight\">$search</span>",$word);
return $newterm;
}
?>