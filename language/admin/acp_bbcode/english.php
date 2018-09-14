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
** File bbcode/english.php 2018-09-14 07:03:00 Thor
**
** CHANGES
**
** 2018-02-18 - Added New Masthead
** 2018-02-18 - Added New !defined('IN_PMBT')
** 2018-02-18 - Fixed Spelling
** 2018-03-29 - Amended the Wording of some Sentences
** 2018-03-29 - Amended !defined('IN_PMBT') Corrected Path
** 2018-04-09 - Amended the Wording of some Sentences
** 2018-06-04 - Added Missing Text For Errors
**/

if (!defined('IN_PMBT'))
{
    include_once './../../../security.php';
    die ("Error 404 - Page Not Found");
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'tokens' => array(
        'TEXT'       => 'Any Text, Including Foreign Characters, Numbers etc.  You should NOT use this Token in HTML Tags.  Instead try to use IDENTIFIER, INTTEXT or SIMPLETEXT.',

        'SIMPLETEXT' => 'Characters from the Latin Alphabet (A-Z), Numbers, Spaces, Commas, Dots, Minus, Plus, Hyphen and Underscore',

        'INTTEXT'    => 'Unicode Letter Characters, Numbers, Spaces, Commas, Dots, Minus, Plus, Hyphen, Underscore and White Spaces.',

        'IDENTIFIER' => 'Characters from the Latin Alphabet (A-Z), Numbers, Hyphen and Underscore',
        'NUMBER'     => 'Any Series of Digits',
        'EMAIL'      => 'A Valid email Address',
        'URL'        => 'A Valid URL using any Protocol (http, ftp, etc.. It can NOT be used for JavaScript Exploits).  If None is given, "http://" is Prefixed to the String.',

        'LOCAL_URL'  => 'A Local URL.  The URL Must be Relative to the Topic Page and can NOT contain a Server Name or Protocol.',

        'COLOR'      => 'A HTML Colour, can be either in the Numeric form <em>#FF1234</em> or a <a href="http://www.w3.org/TR/CSS21/syndata.html#value-def-color">CSS Colour Keyword</a> such as <em>fuchsia</em> or <em>InactiveBorder</em>'),

    'ACP_BBCODES_EXPLAIN'   => 'BBCode is a Special Implementation of HTML offering Greater Control over What and How something is Displayed.  From this Page you can Add, Edit and Remove Custom BBCodes.<br /><br />',

    'ADD_BBCODE'            => 'Add a New BBCode',

    'BBCODE_DANGER'         => 'The BBCode you are trying to Add seems to use a {TEXT} Token inside a HTML Attribute.  This is a possible XSS Security Issue.  Try using the more Restrictive {SIMPLETEXT} or {INTTEXT} Types instead.  Only proceed if you understand the risks involved and you consider the use of {TEXT} absolutely unavoidable.',

    'BBCODE_DANGER_PROCEED' => 'Proceed', //'I understand the Risk'

    'BBCODE_ADDED'             => 'BBCode Added Successfully.',
    'BBCODE_EDITED'            => 'BBCode Edited Successfully.',
    'BBCODE_NOT_EXIST'         => 'The BBCode you Selected DOES NOT Exist.',
    'BBCODE_HELPLINE'          => 'Helpline',
    'BBCODE_HELPLINE_EXPLAIN'  => 'This Field contains the Mouseover Text of the BBCode.',
    'BBCODE_HELPLINE_TEXT'     => 'Helpline Text',
    'BBCODE_HELPLINE_TOO_LONG' => 'The Helpline you Entered is Too Long.',

    'BBCODE_INVALID_TAG_NAME'  => 'The BBCode Tag Name that you selected Already Exists.',
    'BBCODE_INVALID'           => 'Your BBCode is Constructed in an Invalid Form.',
    'BBCODE_OPEN_ENDED_TAG'    => 'Your Custom BBCode must contain both an Opening and a Closing Tag.',
    'BBCODE_TAG'               => 'Tag',
    'BBCODE_TAG_TOO_LONG'      => 'The Tag Name you Selected is Too Long.',
    'BBCODE_TAG_DEF_TOO_LONG'  => 'The Tag Definition that you have entered is Too Long, please Shorten your Tag Definition.',
    'BBCODE_USAGE'             => 'BBCode Usage',
    'BBCODE_USAGE_EXAMPLE'     => '[highlight={COLOR}]{TEXT}[/highlight]<br /><br />[font={SIMPLETEXT1}]{SIMPLETEXT2}[/font]',
    'BBCODE_USAGE_EXPLAIN'     => 'Here you Define How to Use the BBCode.  Replace any Variable Input by the Corresponding Token (%ssee below%s).',

    'EXAMPLE'                  => 'Example:',
    'EXAMPLES'                 => 'Examples:',

    'HTML_REPLACEMENT'         => 'HTML Replacement',
    'HTML_REPLACEMENT_EXAMPLE' => '&lt;span style="background-color: {COLOR};"&gt;{TEXT}&lt;/span&gt;<br /><br />&lt;span style="font-family: {SIMPLETEXT1};"&gt;{SIMPLETEXT2}&lt;/span&gt;',
    'HTML_REPLACEMENT_EXPLAIN' => 'Here you Define the Default HTML Replacement.  DO NOT forget to put back Tokens you used above!',

    'TOKEN'                    => 'Token',
    'TOKENS'                   => 'Tokens',
    'TOKENS_EXPLAIN'           => 'Tokens are Placeholders for User Input.  The Input will be Validated Only if it Matches the Corresponding Definition.  If needed you can Number them by Adding a Number as the Last Character between the Braces, e.g. {TEXT1}, {TEXT2}.<br /><br />Within the HTML Replacement you can also use Any Language String present in your <em>language</em> Directory like this: {L_<em>&lt;STRINGNAME&gt;</em>} where <em>&lt;STRINGNAME&gt;</em> is the Name of the Translated String you want to Add.  For example, {L_WROTE} will be Displayed as &quot;wrote&quot; or its Translation according to the  User\'s Locale.<br /><br /><strong>Please Note that Only Tokens Listed below are able to be used within Custom BBCodes.</strong>',
    'TOKEN_DEFINITION'         => 'What can it be?',
    'TOO_MANY_BBCODES'         => 'You can NOT Create any more BBCodes.  Please Remove one or more BBCodes then try again!',

    'ACP_BBCODES'              => 'BBCodes',

    'DISPLAY_ON_POSTING'       => 'Display on Posting Page',

    'EXAMPLES'                 => 'Examples:',
    'ACP_NO_ITEMS'             => 'There are NO Items Yet!',
));

?>