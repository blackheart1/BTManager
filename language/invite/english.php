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
** File invite/english.php 2018-04-24 07:14:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-24 - Amended the Wording of some Sentences
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

$lang = array_merge($lang, array(
    'INVITE'                => 'Invite',
    'INVITE_HEADER'         => 'Invite System',
    'INVITES_DISSABLED'     => 'Invites Disabled',
    'INVITES_DISSABLED_EXP' => 'Our Invites System is currently Disabled.  Please have your Friend use the Registration Link',

    'INVITE_EXP'            => 'Welcome to our Invite System<br />Here you can Send out an Invite to your Friends or even Family Members.',

    'INVITES'               => 'Invites',
    'INV_MAIL_SUB'          => 'Your Invite to %1$s',

    'WELCOME'               => 'Welcome to %1$s!<br />Please Enter the Required Information below to Complete the Invite that you Received',

    'USER_NAME'             => 'Username',
    'PASSWORD_EXP'          => '(5 Characters Minimum)',
    'TERMS_CONDITION'       => 'Terms and Conditions',
    'EMAIL_ADD'             => 'Add email Address',
    'EMAIL_ADD_EXP'         => 'Please Enter a Valid email Address for the person your Sending the Invite to',
    'ADD_MESSAGE'           => 'Add a Message',
    'ADD_MESSAGE_EXP'       => 'Enter a Message to the person your Sending this Invite to so that they know Who Sent it.',
    'SUBMIT_ONES'           => 'Send Invite (PRESS ONLY ONCE)',
    'LIMMIT_REACHED'        => 'Site User Limit Reached',

    'MAX_USERS_REACHED'     => 'The Current User Account Limit (<strong>%s</strong>) has been Reached.  Inactive Accounts are Pruned ALL the time.  Please check back again later...',

    'NO_INVITES'            => 'NO Invites',

    'NO_INVITES_EXP'        => 'You DO NOT have any Invites to use at this time.<br />If you feel you reached this Error by mistake, please contact a Moderator.',

    'INVALID_ID_EXP'        => 'The ID you provided is Invalid',
    'DUPE_IP'               => 'Duplicate IP in use',
    'DUPE_IP_EXP'           => 'The IP your using is already in our System.  We DO NOT Allow Users to have Multiple Account\'s',
    'ACCOUNT_ACTIVE'        => 'This Account is Activated',
    'ACCOUNT_ACTIVE_EXP'    => 'This Account was already Activated and NO further action is required.<br />Please Login.',
    'INVALID_INVITE'        => 'The Invite is Invalid',

    'INVALID_INVITE_RXP'    => 'This Invite is NOT in our Database.<br />You may have taken Too Long to use it or the ID Number is Wrong.',

    'INVALID_ACTKEY'        => 'Invalid Activation Key',
    'INVALID_ACTKEY_EXP'    => 'There seems to be an Issue Processing the Activation Key you provided.  Please Check the Link!',
    'USE_LIM_REACHED'       => 'Sorry.  We are NOT Accepting any New Users at this time.',

    'USE_LIM_REACHED_EXP'   => 'The Current User Account Limit (<strong>%s</strong>) has been Reached.  Inactive Accounts are Pruned ALL the time.  Please check back again later...',

    'NO_MESSAGE'            => 'NO Message',
    'NO_MESSAGE_EXP'        => 'You DID NOT Add a Message for the User to know Who was Sending it.',
    'BAD_EMAIL'             => 'The email is Bad',
    'BAD_EMAIL_EXP'         => 'There seems to be an Issue with the email you are Sending this to',
    'EMAIL_USED'            => 'The email is in already in Use',
    'EMAIL_USED_EXP'        => 'The email you are Sending this to is already in Use.  Please Select a Different email Address',

    'ACTIVATION_COMPLETE'   => 'Activation Complete.  Your Account is now Activated.  You can Access our Services using the Username and Password that you provided.  Have a nice Download.',

    'USER_LINNET_REACHED'   => 'Sorry.  User Limit Reached.  Please try again later...',
    'USERNAME_NOT_SET'      => 'Username NOT Specified.',
    'BAD_ID'                => 'There seems to be an Issue with the ID.  Please Check your Link and try again.',
    'USER_IS_ACTIVE'        => 'User is already Active.  NO more Activation Required',
    'PASS_DONT_MATCH'       => 'Passwords Don\'t Match',

    'YOU_HAVE_BLANK_FEALDS' => 'You Did NOT Complete ALL the Required Fields.  Please go back and make sure ALL Fields are Filled in .',

    'INVALID_USER_NAME'     => 'You are trying to use an Invalid Username.  Please go back and try a Different Name',
    'DISCL_NOT_ACCP'        => 'You MUST ACCEPT our Disclaimer in Order to Sign Up.',
    'USER_NAME_TO_LONG'     => 'That Username is Too Long',
    'PASS_TO_SHORT'         => 'That Password is Too Short',
));

?>