<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	27-12-2002
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: lang_registration.php
*	Developer: Matt Smith
*	Date: 27-12-2002
*	Version #: 4.0.12
**/

// registration.php
DEFINE('_ERROR_PASS','Sorry, no corresponding user was found');
DEFINE('_NEWPASS_MSG','The user account $checkusername has this email associated with it.\n'
.'A web user from $live_site has just requested that a new password be sent.\n\n'
.' Your New Password is: $newpass\n\nIf you didn\'t ask for this, don\'t worry.'
.' You are seeing this message, not them. If this was an error just login with your'
.' new password and then change your password to what you would like it to be.');
DEFINE('_NEWPASS_SUB','User Password for $checkusername');
DEFINE('_NEWPASS_SENT','New User Password Created And Sent!');
DEFINE('_REGWARN_NAME','Please enter your name.');
DEFINE('_REGWARN_UNAME','Please enter a user name.');
DEFINE('_REGWARN_MAIL','Please enter your email address.');
DEFINE('_REGWARN_PASS','Please enter a valid password.  No spaces, more than 6 characters and contain 0-9,a-z,A-Z');
DEFINE('_REGWARN_VPASS1','Please verify the password.');
DEFINE('_REGWARN_VPASS2','Password and verification do not match, please try again.');
DEFINE('_REGWARN_INUSE','This username/password already in use. Please try another.');
DEFINE('_SEND_SUB','New User Details');
DEFINE('_USEND_MSG','Hello $yourname,\n\nYou have been added as a user to $live_site.\n'
.'This email contains your username and password to log into the $live_site site:\n\n'
.'Username - $username1\n'
.'Password - $newpass\n\n\n'
.'Please do not respond to this message as it is automatically generated and is for information purposes only\n');
DEFINE('_ASEND_MSG','Hello $adminName,\n\nA new user has registered at $live_site.\n'
.'This email contains their details:\n\n'
.'Name - $yourname\n'
.'Email - $email\n'
.'Username - $username1\n\n\n'
.'Please do not respond to this message as it is automatically generated and is for information purposes only\n');
DEFINE('_REG_COMPLETE','<B>Registration Complete!</B><BR>&nbsp;&nbsp;You may now log in with your username and password.');

// classes/html/registration.php
DEFINE('_PROMPT_PASSWORD','Lost your Password?');
DEFINE('_NEW_PASS_DESC','No problem. Just type your User name and click on send button.<br>'
.'You\'ll receive a Confirmation Code by Email, then return here and retype your User name and your Code,'
.' after that you\'ll receive your new Password by Email.');
DEFINE('_PROMPT_UNAME','Username:');
DEFINE('_PROMPT_EMAIL','EMail Address:');
DEFINE('_BUTTON_SEND_PASS','Send Password');
DEFINE('_REGISTER_TITLE','Become a contributing author');
DEFINE('_REGISTER_NAME','Name:');
DEFINE('_REGISTER_UNAME','Username:');
DEFINE('_REGISTER_EMAIL','EMail:');
DEFINE('_REGISTER_PASS','Password:');
DEFINE('_REGISTER_VPASS','Verify Password:');
DEFINE('_BUTTON_SEND_REG','Send Registration');
DEFINE('_SENDING_PASSWORD','Your password will be sent to the above e-mail address.<BR>Once you have recieved your'
.' new password you can login in and change it.'); 
?>