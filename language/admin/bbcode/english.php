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
** And Joe Robertson (aka joeroberts)
** Project Leaders: Black_heart, Thor.
** File bbcode/english.php 2018-02-28 08:28:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>
        <?php if (isset($_GET['error']))
        {
        echo htmlspecialchars($_GET['error']);
        }
        ?> Error</title>

        <link rel='stylesheet' type='text/css' href='/errors/error-style.css' />
    </head>

    <body>
        <div id='container'>
        <div align='center' style='padding-top: 15px'>
            <img src='/errors/error-images/alert.png' width='89' height='94' alt='' title='' />
        </div>

        <h1 class='title'>Error 404 - Page Not Found</h1>
        <p class='sub-title' align='center'>The page that you are looking for does not appear to exist on this site.</p>
        <p>If you typed the address of the page into the address bar of your browser, please check that you typed it in correctly.</p>
        <p>If you arrived at this page after you used an old Bookmark or Favourite, the page in question has probably been moved. Try locating the page via the navigation menu and then update your bookmarks.</p>
        </div>
    </body>
    </html>

    <?php
    exit();
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    'tokens'     => array(
        'TEXT'       => 'Any Text, including Foreign Characters, Numbers, etc. You should NOT use this Token in HTML Tags. Instead try to use IDENTIFIER, INTTEXT or SIMPLETEXT.',

        'SIMPLETEXT' => 'Characters from the Latin Alphabet (A-Z), Numbers, Spaces, Commas, Dots, Minus, Plus, Hyphen and Underscore',

        'INTTEXT'    => 'Unicode Letter Characters, Numbers, Spaces, Commas, Dots, Minus, Plus, Hyphen, Underscore And White Spaces.',

        'IDENTIFIER' => 'Characters from the Latin Alphabet (A-Z), Numbers, Hyphen and Underscore',
        'NUMBER'     => 'Any Series of Digits',
        'EMAIL'      => 'A Valid email Address',
        'URL'        => 'A Valid URL using Any Protocol (http, ftp, etc. can NOT be used for JavaScript Exploits). If None is given, "http://" is Prefixed to the String.',

        'LOCAL_URL'  => 'A Local URL. The URL Must be Relative to the Topic Page and can NOT contain a Server Name or Protocol.',
        'COLOR'      => 'A HTML Colour, can be either in the Numeric form <samp>#FF1234</samp> or a <a href="http://www.w3.org/TR/CSS21/syndata.html#value-def-color">CSS Colour Keyword</a> such as <samp>fuchsia</samp> or <samp>InactiveBorder</samp>'),

    'HTML_REPLACEMENT'         => 'HTML Replacement',
    'HTML_REPLACEMENT_EXAMPLE' => '&lt;span style="background-color: {COLOR};"&gt;{TEXT}&lt;/span&gt;<br /><br />&lt;span style="font-family: {SIMPLETEXT1};"&gt;{SIMPLETEXT2}&lt;/span&gt;',

    'HTML_REPLACEMENT_EXPLAIN' => 'Here you Define the Default HTML Replacement. DO NOT forget to put back Tokens you used above!',
    'BBCODE_ADDED'             => 'BBCode Added Successfully.',
    'BBCODE_EDITED'            => 'BBCode Edited Successfully.',
    'BBCODE_NOT_EXIST'         => 'The BBCode you Selected DOES NOT Exist.',
    'BBCODE_HELPLINE'          => 'Helpline',
    'BBCODE_HELPLINE_EXPLAIN'  => 'This Field contains the mouseover Text of the BBCode.',
    'BBCODE_HELPLINE_TEXT'     => 'Helpline Text',
    'BBCODE_HELPLINE_TOO_LONG' => 'The Helpline you entered is too Long.',
    'DISPLAY_ON_POSTING'       => 'Display on Posting Page',
    'TOKEN'                    => 'Token',
    'TOKENS'                   => 'Tokens',

    'TOKENS_EXPLAIN'           => 'Tokens are Placeholders for User Input. The Input will be Validated Only if it Matches the Corresponding Definition. If needed, you can Number them by Adding a Number as the Last Character between the Braces, e.g. {TEXT1}, {TEXT2}.<br /><br />Within the HTML Replacement you can also use Any Language String present in your language/ directory like this: {L_<em>&lt;STRINGNAME&gt;</em>} where <em>&lt;STRINGNAME&gt;</em> is the Name of the Translated String you want to Add. For example, {L_WROTE} will be Displayed as &quot;wrote&quot; or its Translation according to the  User\'s Locale.<br /><br /><strong>Please Note that Only Tokens Listed below are able to be used within Custom BBCodes.</strong>',

    'TOKEN_DEFINITION'         => 'What can it be?',
    'TOO_MANY_BBCODES'         => 'You can NOT Create any more BBCodes. Please Remove one or more BBCodes then try again.',
    'BBCODE_USAGE'             => 'BBCode Usage',
    'BBCODE_USAGE_EXAMPLE'     => '[highlight={COLOR}]{TEXT}[/highlight]<br /><br />[font={SIMPLETEXT1}]{SIMPLETEXT2}[/font]',
    'BBCODE_USAGE_EXPLAIN'     => 'Here you Define How to use the BBCode. Replace any Variable Input by the Corresponding Token (%ssee below%s).',

    'ACP_BBCODES_EXPLAIN'      => 'BBCode is a Special Implementation of HTML offering greater control over what and how something is Displayed. From this Page you can Add, Remove and Edit Custom BBCodes.',

    'ACP_BBCODES'              => 'BBCodes',
    'EXAMPLES'                 => 'Examples:',
    'BBCODE_TAG'               => 'Tag',
    'ADD_BBCODE'               => 'Add a New BBCode',
    'ACP_NO_ITEMS'             => 'There are NO Items Yet!',
));

?>