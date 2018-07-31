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
** File profile/english.php 2018-04-28 07:11:00 Thor
**
** CHANGES
**
** 2018-03-02 - Added New Masthead
** 2018-03-02 - Added New !defined('IN_PMBT')
** 2018-03-02 - Fixed Spelling
** 2018-04-28 - Amended the Wording of some Sentences
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
    '_NO_ACCESS_TO_PROFILE'   => 'Your Access Level %1$s DOES NOT Allow you to View Member\'s Profile\'s',
    '_VIEWING_USER_PROFILE'   => 'Viewing Profile of: %1$s',
    'ACCOUNTACTIVATESUB'      => 'Activate your Account on %1$s',
    'PERMISSIONS_RESTORED'    => 'Successfully Restored Original Permissions.',

    'PERMISSIONS_TRANSFERRED' => 'Successfully Transferred Permissions from <strong>%s</strong>, you are now able to Browse the Board with this User\'s Permissions.<br />Please Note that Administrator Permissions were NOT Transferred.  You are able to Revert to your Permission Set at any time.',

    'POST_DAY'           => '%.2f Posts Per Day',
    'POST_PCT'           => '%.2f%% of ALL Posts',
    'USER_POST'          => '%d Post',
    'USER_POSTS'         => '%d Posts',
    'LOGIN'              => 'Login',
    'LOST_PASSWORD'      => 'Lost your Password?',

    'LOST_PASS_INTRO'    => 'If you Lost your Password, you can Regain Access to your Account by entering your Username and a <strong>NEW</strong> Password.<br />Confirmation has been Sent to the email Address associated with your Account.<br /> Make sure you can Receive Mail (i.e. your Mailbox is NOT Full) before Submitting your Request.<br />If you don\'t receive an email, please check your Spam Folder.<br /><br /><strong>(Notice: NO Changes will be made to your Current Password until you Click on the Link in the Confirmation email.)</strong>',

    'LOST_PASSWORD_SUB'  => 'Your New Password on %1$s',

    'LOST_PASSWORD_SENT' => 'A Message has been Sent to your email Address containing a Confirmation Link.  Please Click on the Link for the Password Change to take effect.',

    'REMEMBER_ME'      => 'Remember Me',
    'USER_SNATCH_LIST' => 'Torrents Snatched',

    'LOGIN_EXP'        => 'The Area you are trying to Access is Restricted to <strong>Registered Users</strong>.<br />Please provide your Access Credentials and try again. If you\'ve NOT Registered on this Site yet, you can <a href=\'user.php?op=register\'> <u>DO SO HERE</u> </a> for FREE.',

    'BONUS_TRAN_TITTLE'     => 'Bonus Transfer',
    'BONUS_TRAN_TITTLE_EXP' => 'You can Transfer your Seed Bonus Points to another Member Here',
    'HOW_MANY_POINTS_GIVE'  => 'How Many Points do you want to Give',
    'GIVE_ANONYMUSLY'       => 'Give Bonus Anonymously',
    'GIVE_BONUS_TO'         => 'Who would you like to Send this to?',
    'GIVE_BONUS_MESS'       => 'Send a Message as to Why you gave the Points<br />Leave Blank for NO Message.',
    'SEND_BONUS'            => 'Send Bonus',
    'BONUS_TRAN_TO_MUCH'    => 'You can NOT Transfer more Points than you have!',
    'BONUS_TO_SELF'         => 'You can NOT Transfer Points to Yourself!',
    'BONUS_TRANSFERD'       => 'Job Done.  Bonus Points Successfully Sent to %s',
    'BONUS_TRANSFER_PM_SUB' => 'Bonus Points Received',
    'BONUS_TRANSFER_PM'     => '%1$s has given you %2$s Bonus Points ' . "\n" . 'Here\'s a Message from them:' . "\n" . '%3$s',

    'WELCOME' => 'Welcome! <br />Register an Account to Join Our Community.  This will Enable you to use the Full Range of Services on this Site, it will only take a few minutes.  Choose a Username and Password, and provide a Valid email Address.  Within a few minutes, you\'ll Receive an email, asking you to Confirm the Registration.',

    'PASSWORD_EXP'         => '(5 Characters Minimum)',
    'TERMS_CONDITION'      => 'Terms and Conditions',
    'DISCLAIMER_ACCEPT'    => 'I Accept',
    'DISCLAIMER_DECLINE'   => 'I DO NOT Accept',
    'ERROR_LIMMET_REACHED' => 'Limit Reached',

    'SIGNUP_LIMMET_REACHED' => 'The Current User Limit (%1$s) has been Reached.  Inactive Accounts are Pruned ALL the time.  Please check back again later...',

    'SIGNUPS_CLOSED'        => 'Open Signup\'s are Closed.  The ONLY way you can Join this Site is by Invitation',
    'USER_EMAIL_ADD'        => 'email Address',
    'PROFILE_UPDATED'       => 'Your Profile has been Updated',
    'SIGN_UP_ERROR'         => 'Error during Signup Process',
    'ERR_USER_ACSEST'       => 'Username already Exists.',
    'ERR_EMAIL_NOT_VALID'   => 'The email Address you entered is NOT Valid.',

    'ERR_EMAIL_ACSEST'      => 'The email Address you entered is already Registered.  If you want to Recover your Password?  Click <a href=\'user.php?op=lostpassword\'>HERE</a>',

    'ERR_PASS_NOT_MATCH'    => 'The Passwords you entered DO NOT Match',
    'ERR_PASS_TO_SHORT'     => 'The Password you entered is Too Short.  Minimum Length is 5 Characters.',
    'DISCL_NOT_ACCP'        => 'You <strong>MUST ACCEPT</strong> our Disclaimer in Order to Signup.',
    'NO_USERNAME_SET'       => 'You MUST enter a Username',
    'NO_PASSWORD_SET'       => 'You MUST enter a Password',
    'NO_EMAIL_SET'          => 'email Address NOT Specified.',

    'REG_SUCCESS'           => 'Activation Complete.  Your Account is now Activated.  You can Access our Services using the Username and Password that you provided.  Have a nice Download.',

    'REG_SUCCESS_CONFERM'   => 'Signup Almost Complete.  You have 24 Hours to Confirm your Registration.  If you don\'t receive the email Confirmation, please check the Data you entered.  If you\'re having problems, please contact the Staff at %1$s',

    'LOGIN_ERROR_NP_WRONG'   => 'Incorrect Username or Password!!',
    'LOGIN_ERROR_NOT_ACTIVE' => 'User Registered but NOT Active!!',
    'NO_EDIT_PREV'           => 'You DO NOT have Access to Edit this Person',
    'EMAILS_NOT_MATCH'       => 'The email Address you entered DOES NOT Match!',
));

?>