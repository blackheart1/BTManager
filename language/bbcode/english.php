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
** File bbcode/english.php 2018-04-18 09:41:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-18 - Amended the Wording of some Sentences
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ('Error 404 - Page Not Found');
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array());

$help = array(
    array(
        0 => '--',
        1 => '<strong>Introduction</strong>'
    ),

    array(
        0 => 'What is BBCode?',
        1 => '<ul>BBCode is a Special Implementation of HTML.  Whether you can actually use BBCode in your Posts on the Forum is determined by the Administrator.  In addition you can Disable BBCode on a Per Post Basis via the Posting Form.  BBCode itself is similar in style to HTML, Tags are enclosed in Square Brackets [ and ] rather than &lt; and &gt; and it offers Greater Control over what and how something is Displayed.  Depending on the Template you are using you may find adding BBCode to your Posts is made much easier through a Clickable Interface above the Message Area on the Posting Form.  Even with this you may find the following Guide useful?</ul><br />'
    ),

    array(
        0 => '--',
        1 => '<strong>Text Formatting</strong>'
    ),

    array(
        0 => 'How to Create Bold, Italic and Underlined Text',
        1 => '<ul>BBCode includes Tags to allow you to quickly change the Basic Style of your Text.  This is achieved in the following ways:<br /><br />

        To make a piece of text <strong>Bold</strong> enclose it in <strong>[b][/b]</strong>:<br /><br />

        For example: <br /><br /><strong>[b]</strong>Hello<strong>[/b]</strong><br /><br />

        Will become <strong>Hello</strong><br /><br />

        To <strong>Underline</strong> a piece of text use: <strong>[u][/u]</strong><br /><br />

        For example:<br /><br />

        <strong>[u]</strong>Good Morning<strong>[/u]</strong><br /><br />

        Will become:<br /><br />

        <span style="text-decoration: underline">Good Morning</span><br /><br />

        To <strong>Italicise</strong> a piece of text use <strong>[i][/i]</strong><br /><br />

        For example:<br /><br />

        This is <strong>[i]</strong>Great!<strong>[/i]</strong><br /><br />

        Will become: <em>Great!</em>
        </ul><br />'
    ),

    array(
        0 => 'How to Change the Text Colour or Size',
        1 => '<ul>To Alter the Colour or Size of your Text the following Tags can be used.  Keep in mind that how the output appears will depend on the viewers Browser and System:<br /><br />

        Changing the Colour of Text is achieved by wrapping it in <strong>[color=][/color]</strong>. You can Specify either a Recognised Colour Name (eg. red, blue, yellow, etc.) or the Hexadecimal Alternative, e.g. #FFFFFF, #000000.<br /><br />

        For example, to Create Red Text you could use:<br /><br />

        <strong>[color=\'red\']</strong>Hello!<strong>[/color]</strong><br /><br />

        Or <br /><br />

        <strong>[color=#FF0000]</strong>Hello!<strong>[/color]</strong><br /><br />

        Both will Output:<br /><br />

        <span style="color:red">Hello!</span><br /><br />

        Changing the Text Size is achieved in a similar way using <strong>[size=][/size]</strong>.<br /><br />

        This Tag is dependent on the Template the User has selected.  The Recommended Format is a Numerical Value representing the Text Size as a Percentage, starting at 20 (Very Small) through to 200 (Very Large).<br /><br />

        For example:<br /><br />

        <strong>[size=70]</strong>SMALL<strong>[/size]</strong><br /><br />

        Will generally be:<br /><br />

        <span style="font-size:70%;">SMALL</span><br /><br />

        Whereas:<br /><br />

        <strong>[size=30]</strong>HUGE!<strong>[/size]</strong><br /><br />

        Will be:<br /><br />

        <span style="font-size:300%;">HUGE!</span>
        </ul><br /><br />'
    ),

    array(
        0 => 'Can I combine Formatting Tags?',
        1 => '<ul>Yes, of course you can, for example to get someone\'s attention you could write:<br /><br />

        <strong>[size=200][color=\'red\'][b]</strong>LOOK AT ME!<strong>[/b][/color][/size]</strong><br /><br />

        This would output:<br /><br />

        <span style="color:red;font-size:200%;"><strong>LOOK AT ME!</strong></span><br /><br />

        We don\'t recommend you output lots of text that looks like this though!  Remember it is up to you, the Poster, to ensure Tags are Closed correctly.<br /><br />

        For example the following is Incorrect:<br /><br />

        <strong>[b][u]</strong>This is wrong<strong>[/b][/u]</strong>
        </ul><br />'
    ),

    array(
        0 => '--',
        1 => '<strong>Quoting and Outputting Fixed Width Text</strong>'
    ),

    array(
        0 => 'Quoting Text in Replies',
        1 => '<ul>There are Two Ways you can Quote Text, with or without a Reference.<br /><br />

        When you utilise the Quote Function to Reply to a Post on the Board you should notice that the Post Text is added to the Message Window enclosed in a <strong>[quote=&quot;&quot;][/quote]</strong> Block.  This method allows you to Quote with a Reference to a Person or whatever else you wanted to put!<br /><br />

        For example to Quote a piece of text Mr. Blobby wrote you would enter:<br /><br />

        <strong>[quote=&quot;Mr. Blobby&quot;]</strong>The text Mr. Blobby wrote would go here<strong>[/quote]</strong><br /><br />

        The resulting output will automatically add &quot;Mr. Blobby wrote:&quot; before the Actual Text.  Remember you <strong>must</strong> include the Quotation Marks <strong>&quot;&nbsp;&nbsp;&nbsp;&quot;</strong> around the Name you are Quoting, they are <strong>NOT</strong> Optional.<br /><br />

        The second method allows you to Blindly Quote something.  To utilise this enclose the Text in <strong>[quote][/quote]</strong> Tags.  When you view the message it will simply show the Text within a Quotation Block.
        </ul><br /><br />'
    ),

    array(
        0 => 'Outputting Code or Fixed Width Data',
        1 => '<ul>If you want to output a Piece of Code or in fact anything that requires a Fixed Width, e.g. Courier Type Font you should enclose the Text in <strong>[code][/code]</strong> Tags.<br /><br />

        For example:<br /><br />

        <strong>[code]</strong>echo &quot;This is some code&quot;;<strong>[/code]</strong><br /><br />

        All formatting used within <strong>[code][/code]</strong> Tags is retained when you later view it.  PHP Syntax Highlighting can be Enabled using <strong>[code=php][/code]</strong> and is recommended when posting PHP Code Samples as it improves readability.
        </ul><br />'
    ),

    array(
        0 => '--',
        1 => '<strong>Generating Lists</strong>'
    ),

    array(
        0 => 'Creating an Unordered list',
        1 => '<ul>BBCode supports two types of Lists, Unordered and Ordered.  They are essentially the same as their HTML equivalents.<br /><br />

        An Unordered List outputs each item in your list Sequentially, one after the other indenting each with a Bullet Character.<br /><br />

        To create an Unordered List you use <strong>[list][/list]</strong> and define each item within the List using <strong>[*]</strong>.<br /><br />

        For example to List your favourite colours you could use:<br /><br />

        <strong>[list]</strong><br />
        <strong>[*]</strong>Red<br />
        <strong>[*]</strong>Blue<br />
        <strong>[*]</strong>Yellow<br />
        <strong>[/list]</strong><br /><br />

        This would generate the following List:<br /><br />

        <ul><li>Red</li>
            <li>Blue</li>
            <li>Yellow</li>
        </ul></ul><br />'
    ),

    array(
        0 => 'Creating an Ordered list',
        1 => '<ul>The second type of List, an Ordered List, gives you control over what is output before each Item.<br /><br />

        To Create an Ordered List you use <strong>[list=1][/list]</strong> to Create a Numbered List<br /><br />

        Alternatively <strong>[list=a][/list]</strong> for an Alphabetical List.<br /><br />

        As with the Unordered List, items are specified using <strong>[*]</strong>.<br /><br />

        For example:<br /><br />

        <strong>[list=1]</strong><br />
        <strong>[*]</strong>Go to the Shops<br />
        <strong>[*]</strong>Buy a New Computer<br />
        <strong>[*]</strong>Swear at Computer when it Crashes<br />
        <strong>[/list]</strong><br /><br />

        Will generate the following:<br /><br />

        <ol style="list-style-type: decimal;">
            <li>Go to the Shops</li>
            <li>Buy a New Computer</li>
            <li>Swear at Computer when it Crashes</li>
        </ol><br />

        Whereas for an Alphabetical List you would use:<br /><br />

        <strong>[list=a]</strong><br />
        <strong>[*]</strong>The First Possible Answer<br />
        <strong>[*]</strong>The Second Possible Answer<br />
        <strong>[*]</strong>The Third Possible Answer<br />
        <strong>[/list]</strong><br /><br />

        Giving:<br /><br />

        <ol style="list-style-type: lower-alpha">
            <li>The First Possible Answer</li>
            <li>The Second Possible Answer</li>
            <li>The Third Possible Answer</li>
        </ol>
        </ul><br />'
    ),

    // This Block Will Switch The FAQ Questions To The Second Template Column
    array(
        0 => '--',
        1 => '--'
    ),

    array(
        0 => '--',
        1 => '<strong>Creating Links</strong>'
    ),

    array(
        0 => 'Linking to another Site',
        1 => '<ul>phpBB BBCode supports a number of ways of creating URI\'s (Uniform Resource Indicators) better known as URL\'s.<br /><br />

        <ul><li>The first of these uses the <strong>[url=][/url]</strong> Tag, whatever you type after the <strong>=</strong> sign will cause the contents of that Tag to act as a URL.<br /><br />

        For example to Link to phpBB.com you could use:<br /><br />

        <strong>[url=http://www.phpbb.com/]</strong>Visit phpBB!<strong>[/url]</strong><br /><br />

        This would generate the following Link:<br /><br />

        <a href="http://www.phpbb.com/">Visit phpBB!</a><br /><br />

        Please notice that the Link Opens in the Same Window or a New Window depending on the Users Browser Preferences.</li>

        <li>If you want the URL itself Displayed as the Link you can do this by simply using:<br /><br />

        <strong>[url]</strong>http://www.phpbb.com/<strong>[/url]</strong><br /><br />

        This would generate the following Link:<br /><br />

        <a href="http://www.phpbb.com/">http://www.phpbb.com/</a></li><br />

        <li>Additionally, phpBB features something called <strong><i>Magic Links</i></strong>, this will turn any syntactically correct URL into a Link without you needing to specify any Tags or even the leading http://.<br /><br />

        For example typing www.phpbb.com into your message will automatically lead to:<br /><br />

        <a href="http://www.phpbb.com/">www.phpbb.com</a><br /><br />

        being output when you view the message.</li><br />

        <li>The same thing applies equally to email addresses, you can either specify an address explicitly for example:<br /><br />

        <strong>[email]</strong>no.one@domain.adr<strong>[/email]</strong><br /><br />

        Which will output:<br /><br />

        <a href="mailto:no.one@domain.adr">no.one@domain.adr</a><br /><br />

        Or you can just type no.one@domain.adr into your message and it will be automatically converted when you view.<br /><br />

        As with ALL the BBCode Tags you can wrap URLs around any of the other Tags such as:<br /><br />

        <strong>[img][/img]</strong> (See Next Entry), <strong>[b][/b]</strong>, etc.<br /><br />

        As with the Formatting Tags it is up to you to ensure the Correct Open and Close Order is followed:<br /><br />

        For example:<br /><br />

        <strong>[url=http://www.google.com/][img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/url][/img]</strong><br /><br />

        Which is <span style="text-decoration: underline">NOT</span> Correct and could lead to your Post being Deleted so take care. </li>
        </ul><br />'
    ),

    array(
        0 => '--',
        1 => '<strong>Showing Images in Posts</strong>'
    ),

    array(
        0 => 'Adding an Image to a Post',
        1 => '<ul>phpBB BBCode incorporates a Tag for including Images in your Posts. Two very important things to remember when using this Tag are:<br /><br />

        Many Users DO NOT appreciate lots of Images being shown in Posts, secondly the Image you display must already be available on the Internet (it can NOT Exist Only on your Computer for example, unless you run a Web Server!).<br /><br />

        To display an image you must surround the URL pointing to the image with <strong>[img][/img]</strong> Tags.<br /><br />

        For example:<br /><br />

        <strong>[img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/img]</strong><br /><br />

        As noted in the URL Section above you can wrap an image in a <strong>[url][/url]</strong> Tag if you wish:<br /><br />

        For example:<br /><br />

        <strong>[url=http://www.google.com/][img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/img][/url]</strong><br /><br /><br /><br />

        Would generate:<br /><br />

        <a href="http://www.google.com/"><img src="http://www.google.com/intl/en_ALL/images/logo.gif" alt="" /></a>
        </ul><br />'
    ),

    array(
        0 => 'Adding Attachments into a Post',
        1 => '<ul>Attachments can now be placed in any part of a Post by using the New <strong>[attachment=][/attachment]</strong> BBCode.  If the Attachments functionality has been Enabled by a Board Administrator and if you are given the appropriate Permissions to Create Attachments.  Within the Posting Screen is a Drop Down Box (respectively a Button) for placing Attachments Inline.</ul><br />'
    ),

    array(
        0 => '--',
        1 => '<strong>Other Matters</strong>'
    ),

    array(
        0 => 'Can I Add my own Tags?',
        1 => '<ul>If you are an Administrator on this Board and have the proper Permissions, you can add further BBCodes through the Custom BBCode Manager.</ul><br />'
    )
);

?>