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
	'_admpnodonateopt'	=> array("EU"=>"EURO", "UK"=>"BPD", "US" => "USD"),
	'_admsaved'	=> 'Settings saved!',
	'_admpdonations'	=> 'Donations',
	'_admpdonationsexplain'	=> 'Donations',
	'_admppaypal_email'	=> 'PayPal E-Mail',
	'_admppaypal_emailexplain'				=> 'The E-Mail address used with your Paypal-Account. Donations to this account will update the progress bar in the Donations Block on the front page. Log on to your PayPal account, go to My Account>Profile>Instant Payment Notification Preferences, and set the url there to ' . $siteurl . '/paypal.php',
	'_admpsitecost'	=> 'Donations Goal',
	'_admpsitecostexplain'	=> 'Enter a goal for your donations drive in Dollars',
	'_admpreseaved_donations'	=> 'Donations Collected',
	'_admpreseaved_donationsexplain'	=> 'Amount of Money you\'ve already got. Any donations reported by PayPal will be added to this, if you fill in your data above.',
	'_admpdonatepage'	=> 'Donations Page',
	'_admpdonatepageexplain'	=> 'dit your Donations Page here (i.e., the page that is linked from the Donations Block on the front page). When pasting the code for the Donate-Button from PayPal, remember to click on \'Source\' in the editor first.',
	'_admpdonation_block'	=> 'Donation Block',
	'_admpdonation_blockexplain'	=> 'Check if you want a donations block to be shown on the main page.',
	'_admpnodonate'	=> 'Indicator for zero donations',
	'_admpnodonateexplain'	=> '<ul><li><b>EU</b> Displays a EURO symbol when no donations have been made yet<li><b>UK</b> Displays a British Pound symbol when no donations have been made yet<li><b>US</b>  Displays a Dollar symbol when no donations have been made yet</ul>This setting does not affect the donation currency in any way, it\'s purely optical.',
));
?>