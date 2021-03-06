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
*	File Name: survey.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("menubar/html/menusurvey.php");
$menu = new menusurvey();

require ("menubar/html/menudefault.php");

switch ($task){
	case "edit":
	$comcid = $cid[0];
	$menu->EDIT_MENU_Survey($comcid, $database, $dbprefix);
	break;
	case "new":
	$menu->NEW_MENU_Survey();
	break;
	default:
	$default = new MENU_Default($act, $option);
}
?>
