<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	17-11-2002
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: users.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*				Emir Sakic - saka@hotmail.com
*	Date: 17/11/2002
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_users.php");
$usershtml = new HTML_users();

require("classes/users.php");
$users = new users();

switch ($task){
	case "edit":
	$uid = $cid[0];
	$users->edituser($usershtml, $database, $dbprefix, $option, $uid);
	break;
	case "saveedit":
	$users->saveedituser($usershtml, $database, $dbprefix, $option, $pname, $pemail, $puname, $uid, $block, $ugid);
	break;
	case "remove":
	$users->removeuser($database, $dbprefix, $option, $cid);
	break;
	case "new":
	$usershtml->newuser($option);
	break;
	case "savenew":
	$users->savenewuser($option, $database, $dbprefix, $realname, $username, $email, $live_site);
	break;
	default:
	$users->showUsers($database, $dbprefix, $option, $usershtml, $offset);
}
?>