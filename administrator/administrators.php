<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	20-01-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: administrators.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_administrators.php");
$administratorshtml = new HTML_administrators();

require("classes/administrators.php");
$administrators = new administrators();

switch ($task){
	case "edit":
	$uid = $cid[0];
	$administrators->editadministrator($administratorshtml, $database, $dbprefix, $option, $uid);
	break;
	case "saveedit":
	$administrators->saveeditadministrator($administratorshtml, $database, $dbprefix, $option, $realname, $email, $username, $uid, $new_password, $pname, $pemail, $puname, $live_site, $npassword, $vpassword, $ppassword, $emailAdmin);
	break;
	case "remove":
	$administrators->removeadministrator($database, $dbprefix, $option, $cid, $userid);
	break;
	case "new":
	$administratorshtml->newadministrator($option);
	break;
	case "savenew":
	$administrators->savenewadministrator($option, $database, $dbprefix, $realname, $username, $email, $live_site);
	break;
	default:
	$administrators->showadministrators($database, $dbprefix, $option, $administratorshtml, $userid);
}
?>