<?php
/**
*
* ucp [English]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpMyBitTorrent Group
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
	'CURRENT_VERSION'				=> 'Current version',
	'LATEST_VERSION'				=> 'Latest version',
	'VERSION_CHECK'					=> 'Version check',
	'VERSION_CHECK_EXPLAIN'			=> 'Checks to see if your phpMyBitTorrent installation is up to date.',
	'VERSION_NOT_UP_TO_DATE'		=> 'Your phpMyBitTorrent installation is not up to date. Please continue the update process.',
	'UPDATE_INSTRUCTIONS'			=> '

		<h1>Release announcement</h1>

		<p>Please read <a href="%1$s" title="%1$s"><strong>the release announcement for the latest version</strong></a> before you continue your update process, it may contain useful information. It also contains full download links as well as the change log.</p>

		<br />

		<h1>How to update your installation with the Automatic Update Package</h1>

		<p>The recommended way of updating your installation listed here is only valid for the automatic update package. You are also able to update your installation using the methods listed within the INSTALL.html document. The steps for updating phpMyBitTorrent3 automatically are:</p>

		<ul style="margin-left: 20px; font-size: 1.1em;">
			<li>Go to the <a href="http://sourceforge.net/projects/phpmybittorrent/files/phpMyBitTorrent-stable/" title="sourceforge.net/projects/phpmybittorrent/files/phpMyBitTorrent-stable/">phpMyBitTorrent downloads page</a> and download the "Latest version" archive.<br /><br /></li>
			<li>Unpack the archive.<br /><br /></li>
			<li>Upload the complete uncompressed install folder to your phpMyBitTorrent root directory (where your config.php file is).<br /><br /></li>
		</ul>

		<p>Once uploaded your board will be offline for normal users due to the install directory you uploaded now present.<br /><br />
		<strong><a href="%2$s" title="%2$s">Now start the update process by pointing your browser to the install folder</a>.</strong><br />
		<br />
		You will then be guided through the update process. You will be notified once the update is complete.
		</p>
	',
	'UPGRADE_INSTRUCTIONS'			=> 'A new feature release <strong>%1$s</strong> is available. Please read <a href="%2$s" title="%2$s"><strong>the release announcement</strong></a> to learn about what it has to offer, and how to upgrade.',
	'VERSION_UP_TO_DATE_ACP'		=> 'Your phpMyBitTorrent installation is up to date. There are no updates available at this time.',
	'VERSIONCHECK_FORCE_UPDATE'		=> 'Re-Check version',
	'VERSION_NOT_UP_TO_DATE_ACP'	=> 'Your phpMyBitTorrent installation is not up to date.<br />Below is a link to the release announcement, which contains more information as well as instructions on updating.',
));

?>