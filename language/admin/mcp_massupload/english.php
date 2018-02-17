<?php
/**
*
* acp_requests [English]
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
	'INTRO'								=>	'Massive Upload',
	'INTRO_EXP'							=>	'With this tool you can upload multiple Torrents at a time.
The Torrents must be in phpMyBitTorrent\'s subdirectory <i>massupload</i>, which should be writable (in order to delete Torrents once uploaded or duplicated).<br>
<i>Tip</i>: on UNIX systems, if you need to use a different directory for massive upload, you can change the <i>massupload</i> directory with a <i><u>ssymbolic link</u></i>.',
	'MAX_SEARCH'						=>	'Max Torrents to process (prevents memory or timeout errors)',
	'TRACKER_DISABLED'					=>	"Our Tracker has been Disabled: Only External Torrents can be Uploaded.",
	'BLACKLISTEDTRACKER'				=>	"The Tracker used by this Torrent (<b>“%1$s”</b>) has been Blacklisted. Please use a different Tracker.",
	'AUTO_DEL_DUPE_FILE'				=>	'Automatically delete duplicate Torrents',
	'BAD_TRK_RESPONCE'					=>	'Invalid Data from External Tracker. The Tracker may have Server Problems. Please try again later.',
	'SKIP_SCRAPE'						=>	'Skips external tracker check. This option skips the check of external tracker sources until the next automatic update. Useful to process large amounts of Torrents faster.',
	'UP_ANONYM'							=>	'Anonymous upload. If unchecked, the Torrent will look like you manually uploaded it.',
	'CHECK_CHMODD'						=>	'Unable to delete duplicate Torrents. Please delete them manually or check directory permissions (must be writable).',
	'TOR_EXEST'							=>	'Torrent is already here.',
	'CANNOT_CANTACT_URL'				=>	'Cannot contact URL Address. Tracker will be set as Off-line',
	'NO_MASSUPDIR'						=>	'Mass upload directory does not exist or is not readable.',
	'SEARCH_OPT'						=>	'Search options:',
	'INFO_HASH'							=>	'Info_hash',
	'MASS_DIR_EMPTY'					=>	'No Torrents there',
	'SCAN'								=>	'Scan',
	'DESCRIPTION'						=>	'Description',
	'DESCRIPTION_EXP'					=>	'Please Enter a Description that Indicates File Type and Quality, particularly in case of Media Files',
	'TOR_PROS_ALREADY'					=>	'Torrent has been already processed',
	'SUCCESFUL_UPLOAD'					=>	'Torrent successfully uploaded',
	'DECODE_ERROR'						=>	'Decoding Error. File is probabily not a valid torrent file.',
	'INVALID'							=>	'Invalid',
	'NOT_REDG_TO_TRACK'					=>	'Torrent does NOT seem to be Registered on the External Tracker. You can upload External Torrents ONLY if they\'re Active.',
	'MISSING_DATA'						=>	"Required Data Missing!",
	'DEAD_TORRENT'						=>	'Your Torrent is NOT Seeded!',
	'INVALID_FILEPATH'					=>	'Invalid file path.',
	'INVALIDE_FILE_SIZE'				=>	'Invalid file size. Must be numeric',
	'INVALID_PEASES'					=>	"Invalid Torrent Parts",
	'INVALID_ANNOUNCE'					=>	"Invalid Announce URL. Can Not be <strong> %1$s </strong>",
	'TOTLE_SIZE'						=>	'Total size',
	'NO_CAT_SET'						=>	'No Category Selected. Please go back to the Upload Form.',
	'ERROR_NOTCONS'						=>	'Torrent is not consistent!!',
	'ANNOUNCE_URL'						=>	'Announce Url.',
	'CHECK_DHT'							=>	'Checking against DHT Support in Azureus...',
	'MULTY_TRACKER_CHECK'				=>	'Checking against Multiple Trackers...',
	'UNABLE_TO_REMOVE_TORRENTS'			=>	'Unable to delete torrents that have been processed (whether successfully or not). Please delete them manually or check directory permissions (must be writable).',
 ));

?>