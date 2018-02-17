<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'HTML_REPLACEMENT'				=> 'HTML replacement',
	'HTML_REPLACEMENT_EXAMPLE'		=> '&lt;span style="background-color: {COLOR};"&gt;{TEXT}&lt;/span&gt;<br /><br />&lt;span style="font-family: {SIMPLETEXT1};"&gt;{SIMPLETEXT2}&lt;/span&gt;',
	'HTML_REPLACEMENT_EXPLAIN'		=> 'Here you define the default HTML replacement. Do not forget to put back tokens you used above!',
	'BBCODE_ADDED'				=> 'BBCode added successfully.',
	'BBCODE_EDITED'				=> 'BBCode edited successfully.',
	'BBCODE_NOT_EXIST'			=> 'The BBCode you selected does not exist.',
	'BBCODE_HELPLINE'			=> 'Help line',
	'BBCODE_HELPLINE_EXPLAIN'	=> 'This field contains the mouse over text of the BBCode.',
	'BBCODE_HELPLINE_TEXT'		=> 'Help line text',
	'BBCODE_HELPLINE_TOO_LONG'	=> 'The help line you entered is too long.',
	'DISPLAY_ON_POSTING'		=> 'Display on posting page',
	'TOKEN'					=> 'Token',
	'TOKENS'				=> 'Tokens',
	'TOKENS_EXPLAIN'		=> 'Tokens are placeholders for user input. The input will be validated only if it matches the corresponding definition. If needed, you can number them by adding a number as the last character between the braces, e.g. {TEXT1}, {TEXT2}.<br /><br />Within the HTML replacement you can also use any language string present in your language/ directory like this: {L_<em>&lt;STRINGNAME&gt;</em>} where <em>&lt;STRINGNAME&gt;</em> is the name of the translated string you want to add. For example, {L_WROTE} will be displayed as &quot;wrote&quot; or its translation according to user\'s locale.<br /><br /><strong>Please note that only tokens listed below are able to be used within custom BBCodes.</strong>',
	'TOKEN_DEFINITION'		=> 'What can it be?',
	'TOO_MANY_BBCODES'		=> 'You cannot create any more BBCodes. Please remove one or more BBCodes then try again.',
	'BBCODE_USAGE'				=> 'BBCode usage',
	'BBCODE_USAGE_EXAMPLE'		=> '[highlight={COLOR}]{TEXT}[/highlight]<br /><br />[font={SIMPLETEXT1}]{SIMPLETEXT2}[/font]',
	'BBCODE_USAGE_EXPLAIN'		=> 'Here you define how to use the BBCode. Replace any variable input by the corresponding token (%ssee below%s).',
	'ACP_BBCODES_EXPLAIN'		=> 'BBCode is a special implementation of HTML offering greater control over what and how something is displayed. From this page you can add, remove and edit custom BBCodes.',
	'ACP_BBCODES'				=> 'BBCodes',
	'EXAMPLES'						=> 'Examples:',
	'BBCODE_TAG'				=> 'Tag',
	'ADD_BBCODE'				=> 'Add a new BBCode',
	'ACP_NO_ITEMS'				=> 'There are no items yet.',
	'tokens'	=>	array(
		'TEXT'			=> 'Any text, including foreign characters, numbers, etc… You should not use this token in HTML tags. Instead try to use IDENTIFIER, INTTEXT or SIMPLETEXT.',
		'SIMPLETEXT'	=> 'Characters from the latin alphabet (A-Z), numbers, spaces, commas, dots, minus, plus, hyphen and underscore',
		'INTTEXT'		=> 'Unicode letter characters, numbers, spaces, commas, dots, minus, plus, hyphen, underscore and whitespaces.',
		'IDENTIFIER'	=> 'Characters from the latin alphabet (A-Z), numbers, hyphen and underscore',
		'NUMBER'		=> 'Any series of digits',
		'EMAIL'			=> 'A valid e-mail address',
		'URL'			=> 'A valid URL using any protocol (http, ftp, etc… cannot be used for javascript exploits). If none is given, “http://” is prefixed to the string.',
		'LOCAL_URL'		=> 'A local URL. The URL must be relative to the topic page and cannot contain a server name or protocol.',
		'COLOR'			=> 'A HTML colour, can be either in the numeric form <samp>#FF1234</samp> or a <a href="http://www.w3.org/TR/CSS21/syndata.html#value-def-color">CSS colour keyword</a> such as <samp>fuchsia</samp> or <samp>InactiveBorder</samp>'
	),
));
?>