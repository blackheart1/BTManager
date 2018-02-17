<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
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
*------              �2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (!defined('IN_PMBT'))die("You can't access this file directly");

define("BEGIN_TRANSACTION",1);
define("END_TRANSACTION",-1);

switch($db_type) {

        case 'MySQL':
                require("include/db/mysql.php");
                break;

        case 'MySQL4':
                require("include/db/mysql4.php");
                break;

        case 'PostrgesSQL':
                require("include/db/postgres7.php");
                break;

        case 'MSSQL':
                require("include/db/mssql.php");
                break;

        case 'Oracle':
                require("include/db/oracle.php");
                break;

        case 'MSAccess':
                require("include/db/msaccess.php");
                break;

        case 'MSSQL-ODBC':
                require("include/db/mssql-odbc.php");
                break;
        case 'MySQLi':
                require("include/db/mysqli.php");
                break;

        case 'DB2':
                require("include/db/db2.php");
                break;
        default:
                die("No database set!!! Check config file");

}


?>