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
*	File Name: news.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("menubar/html/menunews.php");
$menu = new menunews();

$comcid = $cid[0];

switch ($task){
	case "edit":
	$comcid = $cid[0];
	if ($comcid==""){
		$comcid=$id;
	}
	$menu->EDIT_MENU_News($database, $dbprefix, $comcid, $option, $categories);
	break;
	case "new":
	$menu->NEW_MENU_News($categories);
	break;
	default:
	$menu->DEFAULT_MENU_News($act, $option);
}
?>
