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
** File arcade/english.php 2018-03-02 07:39:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
**/

if (!defined('IN_PMBT'))
{
    include_once './../../security.php';
    die ("You Can't Access This File Directly");
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files must use UTF-8 as their encoding and the files must Not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You Do Not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a String contains only two placeholders which are used to wrap text
// in a URL you again Do Not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'TITLE'				=>	'Arcade',
    'ACP_ADDED'          => 'ACP Modules Added Successfully.',
    'ACP_EXISTS'         => 'ACP Modules Already Exist.  Nothing Changed!',
    'ACP_MODULES'        => 'ACP Modules:',
    'ADDED_GAME'         => 'The following Game has been Added Successfully to the Database.',
    'ADD_GAME'           => 'Add Game',
    'ADD_GAME_DESC'      => 'Add a Game to the Arcade.',
    'ADD_MODULES'        => 'Add Modules',
    'ALLOW_COMMENTS'     => 'Allow Games to be Commented On',
    'ALLOW_GUEST'        => 'Allow Guest View',
    'ARCADE'             => 'Arcade Room',
    'ARCADE_WELCOME'     => 'Welcome to the Arcade Room, in the User Control Panel.  From here you can View your Favourite Games, Remove Games that are NO Longer your Favourites.',

    'AR_EXPLAIN'         => 'This Installer was written for RC7 Only and has NOT been tested on any other version of phpBB3.  If you wish to Install/Update and are using a different phpBB3 version please consult the Install.xml file in the zip that you have Downloaded.  We are going to walk you through Installing the Arcade Room today beginning with adding MySQL Databases.',

    'AR_SETTINGS'        => 'Arcade Room Settings',
    'AR_TASKS'           => 'Arcade Room Tasks',
    'AR_TO_BEGIN'        => 'To begin the Installation please Click below.',
    'AR_VERSION'         => '0.6.9c',
    'AR_WELCOME'         => 'Welcome to the Arcade Mod Installation.',
    'A_SETTINGS'         => 'Arcade Settings',
    'A_MANAGE'           =>	'Manage Arcade',
    'A_SETTINGS_DESC'    => 'Here you can Enable/Disable Several Arcade Room Features as well as perform several different tasks.',

    'BEGIN'              => 'Begin',
    'CAT'                => 'Categories',
    'CAT_MANAGE'         => 'Category Management',
    'CLICK_UPDATE'       => 'Click Here to Update your phpAR Mod',
    'COMMENT'            => ' Comment',
    'COMMENT'            => 'Comment',
    'COMMENTS'           => 'Comments',
    'COPY_DONE'          => 'File Copying Finished',
    'COPY_FILES'         => 'Copy Files',
    'COPY_PROBLEM'       => 'There was a Problem Copying ',
    'COPY_SUCCESS'       => ' Copied Successfully to ',
    'CREATE_CAT'         => 'Create Category',
    'DATABASE_ERROR'     => ' had an Error being added to the Database.',
    'DATABASE_EXISTS'    => ' Already Exists in the Database.',
    'DATABSE_SUCCESS'    => ' Successfully Added to the Database.',
    'DELETE_COMMENT'     => 'Delete Comment',
    'DELETE_PROBLEM'     => 'There was a Problem Deleting ',
    'DISABLE'            =>	'Disable',
    'EDITED_ALREADY'     => '  was Already Previously Edited.',
    'EDITED_GAME'        => 'The following Game has been Edited Successfully in the Database.',
    'EDITS_DONE'         => 'The File Edits are Done if there is a problem Please Read the install.xml to Edit the Files yourself.',

    'EDIT_FILES'         => 'Edit Files',
    'EDIT_GAME'          => 'Edit Game',
    'EDIT_GAME_DESC'     => 'Here you can Edit the Values of the Game.',
    'EDIT_SUCCESS'       => ' Edited Successfully.',
    'ENABLE_FAVORITES'   => 'Enable Game Favourites',
    'ENABLE_HOTLINK'     => 'Enable Hotlink Protection',
    'ERROR_GAME'         => 'There was an Error Uploading the Game File.  Please Try Again!',
    'ERROR_IMAGE'        => 'There was an Error Uploading the Image File.  Please Try Again!',
    'FILE_COPIES'        => 'File Copies:',
    'FILE_EDITS'         => 'File Edits:',
    'FINISH'             => 'Finish',
    'GAME'               => ' Game',
    'GAMES'              => ' Games',
    'GAMES_IN_CAT'       => ' Game in this Category.',
    'GAME_ADD'           => 'Add',
    'GAME_ADDED'         => 'The Game has been Added.',
    'GAME_CAT_C'         => 'Category: ',
    'GAME_DESC'          => 'Description',
    'GAME_DESC_C'        => 'Description: ',
    'GAME_DIR'           => 'Directions',
    'GAME_DIR_C'         => 'Directions: ',
    'GAME_DUP'           => 'A Game on the Server Already Uses that File Name, please Rename the File and try Uploading Again.',
    'GAME_FAVORITES'     => 'Game Favourites',
    'GAME_FILE_C'        => 'File: ',
    'GAME_HEIGHT_C'      => 'Height: ',
    'GAME_HIGHSCORES'    => 'High Scores',
    'GAME_HIGHSCORE_C'   => 'High Score: ',
    'GAME_IMAGE'         => 'Image',
    'GAME_IMAGE_C'       => 'Image: ',
    'GAME_IN_CAT'        => ' Game in this Category.',
    'GAME_MANAGE'        => 'Game Management',
    'GAME_NAME'          => 'Name',
    'GAME_NAME_C'        => 'Name: ',
    'GAME_NEWSCORE_C'    => 'newscore.php: ',
    'GAME_NO_HIGHSCORE'  => 'There are NO High Scores for this Game.',
    'GAME_PLAY_C'        => 'Plays: ',
    'GAME_RATING'        => 'Rating',
    'GAME_RATINGS_C'     => 'Ratings: ',
    'GAME_RATING_C'      => 'Rating: ',
    'GAME_REMOVE'        => 'Remove',
    'GAME_REMOVED'       => 'The Game has been Removed',
    'GAME_SAVED'         => 'The Game has been Saved.',
    'GAME_SIZE'          => 'Size',
    'GAME_SIZE_C'        => 'Size: ',
    'GAME_TASKS'         => 'Game Tasks',
    'GAME_WIDTH_C'       => 'Width: ',
    'GUEST_INCREASE'     => 'Guest Increases Game Plays',
    'HIGHEST_SCORE'      => 'Highest Score',
    'HIGHSCORES_FOR'     => 'High Scores for ',
    'HIGHSCORES_RESET'   => 'The High Scores for ALL Games have been Reset.',
    'HIGHSCORE_RESET'    => 'The Game you asked for High Scores to be Reset has had its High Scores Reset.',
    'IF_OK'              => 'The Installer is Done if everything is fine Click Delete to Delete the Install File and return to the Index.',

    'IMAGE_DUP'          => 'An Image on the Server Already Uses that Filename please Rename the File and try Uploading Again.',
    'LATEST'             => 'Latest Games',
    'LIMIT'              => '10MB Limit',
    'MANAGE_CAT'         => 'Manage Categories',
    'MANAGE_CAT_DESC'    => 'Here you can Add/Remove Categories.',
    'MANAGE_GAMES'       => 'Manage Games',
    'MANAGE_GAMES_DESC'  => 'Here you can Add/Edit/Remove Games.',
    'MODULES_DONE'       => 'Finished Adding Modules to the ACP if they DID NOT Add properly or Show Up in the ACP Add them yourself.',

    'MYSQL_DONE'         => 'The MySQL Edits are Done if there is a problem please Read the install.xml to Add the Databases yourself.',

    'MYSQL_EDITS'        => 'MySQL Edits:',
    'MINUTES'            =>	'Minutes',
    'NEWSCORE_DESC'      => 'newscore.php Games Only',
    'NONE_IN_CAT'        => 'There are NO Games in this Category.',
    'NO_FAVORITES_USER'  => 'This Member has NO Favourite Games',
    'OUT_NOW'            => 'is Out Now.',
    'OUT_OF_DATE'        => 'of phpAR is Out of Date, the New ',
    'RATINGS_RESET'      => 'The Ratings for ALL Games have been Reset.',
    'RATING_RESET'       => 'The Game you asked for Ratings to be Reset has had its Ratings Reset.',
    'REMOVE_IMAGE_C'     => 'Remove Image: ',
    'RESET_HIGHSCORE'    => 'Reset Highscores for this Game: ',
    'RESET_HIGHSCORES'   => 'Reset ALL Highscores For Games: ',
    'RESET_RATING'       => 'Reset Ratings for this Game: ',
    'RESET_RATINGS'      => 'Reset ALL Ratings for Games: ',
    'RESET_VIEW'         => 'Reset Views for this Game: ',
    'RESET_VIEWS'        => 'Reset ALL Views for Games: ',
    'RUN_TASK'           => 'Run Task',
    'SAVE_GAME'          => 'Save Game',
    'STATISTIC'          =>	'Statistics',
    'SERVER_ERROR'       => 'Error Contacting Update Server.',
    'SETTINGS_UPDATED'   => 'The Settings have been Updated.',
    'SPECIFY_CAT'        => 'Please Specify a Category for the Game.',
    'SPECIFY_DESC'       => 'Please Specify a Description for the Game.',
    'SPECIFY_DIR'        => 'Please Specify some Directions for the Game.',
    'SPECIFY_HEIGHT'     => 'Please Specify a Height.',
    'SPECIFY_NAME'       => 'Please Specify a Game Name.',
    'SPECIFY_WIDTH'      => 'Please Specify a Width.',
    'TOP_PLAY'           => 'Top Played',
    'TOP_RATE'           => 'Top Rated',
    'UP_GAME'            => 'You Need to Upload a Game File.',
    'UP_TO_DATE'         => 'of phpAR is Up to Date.',
    'VALUE'              =>	'Value',
    'VIEW'               => 'View',
    'VIEWS_RESET'        => 'The Views for ALL Games have been Reset.',
    'VIEW_RESET'         => 'The Game you asked for Views to be Reset has had its Views Reset.',
    'WRONG_GAME_TYPE'    => 'Incorrect Game File Type Must be a SWF Flash File.',
    'WRONG_IMAGE_TYPE'   => 'Incorrect Image File Type Must be a gif, jpeg, or png File.',
    'YOUR'               => 'Your',
    'YOUR_FAVORITE'      => 'Your Favourite Games',
    'GAME_REV_SCORE_C'   => 'Reverse Scoring: ',
    'REV_DESC'           => 'means the lower the score the better',
    'INFO'               => 'Info',
    'GAME_FILENAME'      => 'Filename',
    'GAME_ENABLED_C'     => 'Enabled: ',
    'GAME_FILENAME_C'    => 'Filename: ',
    'GAME_IMAGENAME_C'   => 'Image Name: ',
    'GAME_COST_C'        => 'Cost: ',
    'GAME_PPT_C'         => 'Points per Ticket: ',
    'GAME_PPT_EXPLAIN'   => 'every this many points means they earn one ticket',
    'GAME_NUM_RATING_C'  => 'Ratings: ',
    'GAME_NUM_FAVS_C'    => 'Favourites: ',
    'GAME_ID_C'          => 'ID: ',
    'GAME_PLAYS_C'       => 'Plays: ',
    'IMAGE_LIMIT'        => 'Images larger than 50x50 will be Scaled Down',
    'GAME_NUM_RATINGS'   => 'Ratings',
    'GAME_PLAYED'        => 'Plays',
    'SAVE'               => 'Save',
    'CATEGORY_UPDATED'   => 'The Category has been Updated.',
    'NUM_FAVORITES'      => 'Favourites',
    'GAME_ADD_REMOVE'    => 'Favourite',
    'TROPHIES'           => 'Trophies',
    'YOUR_INFO'          => 'Your Info',
    'FAVORITES'          => 'Favourites',
    'ALL_GAMES'          => 'ALL Games',
    'GAME_COST_C'        => 'Cost:',
    'GAME_COST'          => 'Cost',
    'OF'                 => 'of',
    'GAMES_LOWERCASE'    => 'Games',
    'PLAYED'             => 'Played',
    'RATED'              => 'Rated',
    'FAVORITE_GAMES'     => 'Favourite Games',
    'RANDOM_GAMES'       => 'Random Games',
    'CATEGORY_ADDED'     => 'The Category has been Added to the List.',
    'CATEGORY_REMOVED'   => 'The Category has been Removed from the List.',
    'CAT_HAS_GAMES'      => 'You can\'t Delete a Category containing any Games.',
    'YOUR_INFO_WARNING'  => 'Register or Login to see your Info',
    'NO_HIGHSCORE'       => 'User has NO High Score',
    'TROPHIES_WARNING'   => 'Trophies DO NOT show up until 3 people have received a High Score on this Game.',

    'NO_FAVS'            => 'You have NO Favourite Games to Display.',
    'VISIT_ROOM'         => 'Visit the Arcade Room',
    'TOP_PLAYERS'        => 'Top Players',
    'AR_LINK'            => '<a href="http://www.phpAR.com">patrikStar</a>',
    'AR_YEAR'            => '&copy; 2007, 2008, 2009',
    'DATABASES'          => 'Databases',
    'ARCADE_FILES'       => 'Arcade Core Files',
    'FILES'              => 'phpBB File Edits',
    'PROSILVER'          => 'subSilver File Edits',
    'MODULES'            => 'Arcade ACP Modules',
    'GAME_KEYBOARD_C'    => 'Keyboard: ',
    'GAME_MOUSE_C'       => 'Mouse: ',
    'GAME_USES'          => 'Uses',
    'FINISHED'           => 'Finish',

    'RESIZING'           => 'Resizing Requires JavaScript to be Enabled',
    'CLICK_UPDATE_ALT'   => 'Click here if you wish to Manually Update',
    'GAME_ARCHIVE_ERROR' => 'Game Archive Missing game.xml File can NOT Auto Install this Game',
    'ARCADE_QUICK'       => 'Quick Links',
    'ARCADE_RANDOM'      => 'Random Game',
    'GAME_ENABLED'       => 'Game Enabled',
    'GAME_DISABLED'      => 'Game Disabled',
    'VIEWING_ARCADE'     => 'Viewing the Arcade',
    'VIEWING_CAT'        => 'Viewing a Category in the Arcade',
    'VIEWING_GAME'       => 'Playing a Game',
    'ARCADE_STATS'       => 'Arcade Statistics',
    'TOTAL_GAMES'        => 'Total Number of Games',
    'TOTAL_PLAYS'        => 'Total Amount of Play Sessions',
    'TOTAL_RATINGS'      => 'Total Number of Ratings',
    'AVG_RATING'         => 'Average Rating',
    'TOTAL_FAVORITES'    => 'Total Number of Favourites',
    'TOTAL_COMMENTS'     => 'Total Number of Comments',
    'TOKENS_SPENT'       => 'Total Tokens Spent',
    'TICKETS_DISPENSED'  => 'Total Tickets Dispensed',
    'TOTAL_SWF_SIZE'     => 'Total Flash Size',
    'TOTAL_IMG_SIZE'     => 'Total Image Size',
    'CHOOSE_GAME'        => 'Choose a Game',
    'CHOOSE_FILE'        => 'Choose a File',
    'GAME_XML_ERROR'     => 'The game.xml File Doesn\'t have ALL the Required Parts to it.',
    'UPLOAD_ARCHIVE'     => 'Upload Archive',
    'ARCHIVE_UPLOADED'   => 'The Archive has been Uploaded',
    'UPLOAD_ERROR'       => 'Error Uploading the Selected Archive',
    'MANAGE_HIGHSCORES'  => 'Manage High Scores',
    'HIGHSCORES'         => 'High Scores',
    'HIGHSCORE'          => 'High Score',
    'HIGHSCORE_UPDATED'  => 'High Score Updated Successfully',
    'HIGHSCORE_DELETED'  => 'High Score Deleted Successfully',
    'ARCADE_STARTED'     => 'Arcade Started',
    'PLAYS_PER_DAY'      => 'Plays Per Day',
    'ARCADE_PM_ONE'      => 'You Lost the ',
    'ARCADE_PM_TWO'      => ' Trophy because of ',
    'ARCADE_PM_THREE'    => ' who Scored ',
    'ARCADE_PM_FOUR'     => ' on ',
    'DISPLAY_STATS'      => 'Display Arcade Statistics in Arcade',
    'HOTLINK_LENGTH'     => 'Hotlink Protection Length',
	'SELECT_A_GAME'		 => 'Select a Game',
));

?>