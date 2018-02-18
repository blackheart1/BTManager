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
** File database.php 2018-02-18 10:18:00 Black_Heart
**
** CHANGES
**
** EXAMPLE 26-04-13 - Added Auto Ban
**/
if (!defined('IN_PMBT'))die ("You can't access this file directly");
define("BEGIN_TRANSACTION",1);
define("END_TRANSACTION",-1);

switch($db_type) {

        case 'MySQL':
                require("udl/mysql.php");
                break;

        case 'MySQL4':
                require("udl/mysql4.php");
                break;
        case 'MySQLi':
                require("udl/mysqli.php");
                break;
        default:
                die("No database set!!! Check config file");

}

?>
