<?php
/**
*
* offers [English]
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
	'OFFERS'								=>	'Offers',
	'DESCRIPTION_EXPLAIN'					=>	'Add as much info as you can so it well make it easyer on the uploader to find what it is your looking for.',
	'OFFER_DELETED'							=>	'Your offer %1$d was Deleted by %2$d',
	'VOTE'									=>	'Vote',
	'VOTES'									=>	'Votes',
	'OFFER_VOTE'							=>	'Offer Vote',
	'VOTE_FOR'								=>	'Vote for this offer to be Uploaded.',
	'EDIT_OFFER'							=>	'Edit Offers',
	'OFFER_BY'								=>	'Offered by',
	'OFFER_EDITED'							=>	'Offer Edited',
	'OFFER_EDITED_EXP'						=>	'The offer has been success fully Edited!',
	'OFFER_DELETED'							=>	'Offer Deleted',
	'OFFER_DELETED_EXP'						=>	'The offer has been success fully removed!',
	'ERROR_DESCRIP_BLANK'					=>	'The Description Fealed can not be blank',
	'ERROR_EDIT_NOT_SAVED'					=>	'An error has accurd and the Edit was not saved',
	'PM_VOTES_REACHED'						=>	'Your Offer "%1$d" has reached 3 Votes.\nYou can now Upload it to the tracker',
	'PM_SUB_VOTES_REACHED'					=>	'Your Offered Torrent for upload',
	'THANKS_FOR_VOTE'						=>	'Thank you for your Vote',
	'VOTED_ALREADY'							=>	'You\'ve already Voted to this Offer, ONLY <strong>1</strong> Vote per Member is Allowed<br />Return to <a href=./offers.php><b>Offers List</b></a>',
	'VOTE_TAKEN'							=>	'Your Vote has been counted<br />Back to <a href=offers.php><b>Offer List</b></a>',
	'PERMISSION_DENIED'						=>	'You DO NOT have Permissions to Access Offers at this time',
	'OFFER_SHOUT'							=>	'“%1$s” is making a Offer for “%2$s”',
	'NO_NAME_GIVEN'							=>	'You should enter a name for your Offer',
));
?>