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
** File rsalib.php 2018-02-18 14:32:00 joeroberts
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
class RSA {
        var $n; //modulo
        var $e; //public
        var $d; //private

        /*
        CONSTRUCTOR
        Initializes the RSA Engine with given RSA Key Pair. You must have run
        keygen.php and obtained a valid RSA Key Pair
        */
        function __construct($n = 0, $e = 0, $d = 0) {
                if ($n == 0 OR $e == 0 OR $d == 0) list ($n, $e, $d) = $this->generate_keys();
                $this->n = $n;
                $this->e = $e;
                $this->d = $d;

                $test = "Test string to test correct key pairing";
                $enc = $this->encrypt($test, $e, $n);
                $dec = $this->decrypt($enc, $d, $n);
                if ($test === $dec) {
                        return true;
                } else {
                        return false;
                }
        }
	function RSA($n = 0, $e = 0, $d = 0)
	{
		$this->__construct($n, $e, $d);
	}

        /*
        CONVERSIONS STRING-BINARY
        */
        function bin2asc ($temp) {
                $data = "";
                for ($i=0; $i<strlen($temp)-1 ; $i+=8) $data .= chr(bindec(substr($temp,$i,8)));
                return $data;
        }

        function asc2bin ($temp) {
                $data = "";
                for ($i=0; $i<$strlen($temp)-1; $i++) $data .= sprintf("%08b",ord($temp[$i]));
                return $data;
        }


        /*
        MODULUS FUNCTION
        */
        function mo ($g, $l) {
                return $g - ($l * floor ($g/$l));
        }
        /*
        RUSSIAN PAESANT method for exponentiation
        */
        function powmod ($base, $exp, $modulus) {
                $accum = 1;
                $i = 0;
                $basepow2 = $base;
                while (($exp >> $i)>0) {
                        if ((($exp >> $i) & 1) == 1) {
                                $accum = $this->mo(($accum * $basepow2) , $modulus);
                        }
                        $basepow2 = $this->mo(($basepow2 * $basepow2) , $modulus);
                        $i++;
                }
                return $accum;
        }

        /*
        ENCRYPT FUNCTION
        Returns X = M^E (mod N)

        Each letter in the message is represented as its ASCII code number - 30
        3 letters in each block with 1 in the beginning and end.
        For example string
        AAA
        will become
        13535351 (A = ASCII 65-30 = 35)
        we can build these blocks because the smalest prime available is 4507
        4507^2 = 20313049
        This means that
        1. Modulo N will always be < 19999991
        2. Letters > ASCII 128 must not occur in plain text message
        */
        function encrypt ($m) {
                //Checking against incompatible stream
                for ($i = 0; $i < strlen($m)-1; $i++) {
                        if (ord($m[$i]) > 128) return false;
                }
                $coded = "";
                $asci = array ();
                for ($i=0; $i<strlen($m); $i+=3) {
                        $tmpasci="1";
                        for ($h=0; $h<3; $h++) {
                                if ($i+$h <strlen($m)) {
                                        $tmpstr = ord (substr ($m, $i+$h, 1)) - 30;
                                        if (strlen($tmpstr) < 2) {
                                                $tmpstr ="0".$tmpstr;
                                        }
                                } else {
                                        break;
                                }
                                $tmpasci .=$tmpstr;
                        }
                        array_push($asci, $tmpasci."1");
                }

                //Each number is then encrypted using the RSA formula: block ^E mod N
                for ($k=0; $k< count ($asci); $k++) {
                        $resultmod = $this->powmod($asci[$k], $this->e, $this->n);
                        $coded .= base_convert($resultmod,10,35)." ";
                }
                return trim($coded);
        }

        /*
        DECRYPT FUNCTION
        M = X^D (mod N)
        */
        function decrypt ($c) {
                $deencrypt = "";
                $resultd = "";
                //Strip the blank spaces from the ecrypted text and store it in an array
                $decryptarray = preg_split('/ /', $c);
                for ($i=0; $i < count($decryptarray); $i++)
                        $decryptarray[$i] = base_convert($decryptarray[$i],35,10);
                for ($u=0; $u < count ($decryptarray); $u++) {
                        if ($decryptarray[$u] == "") {
                                array_splice($decryptarray, $u, 1);
                        }
                }
                //Each number is then decrypted using the RSA formula: block ^D mod N
                for ($u=0; $u < count($decryptarray); $u++) {
                        $resultmod = $this->powmod($decryptarray[$u], $this->d, $this->n);
                        //remove leading and trailing '1' digits
                        $deencrypt.= substr ($resultmod,1,strlen($resultmod)-2);
                }
                //Each ASCII code number + 30 in the message is represented as its letter
                for ($u=0; $u<strlen($deencrypt); $u+=2) {
                        $resultd .= chr(substr($deencrypt, $u, 2) + 30);
                }
                return $resultd;
        }
}
?>