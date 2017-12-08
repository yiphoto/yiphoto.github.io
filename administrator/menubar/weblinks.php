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
*	File Name: weblinks.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("menubar/html/menuweblinks.php");
$menu = new menusweblinks();

require ("menubar/html/menudefault.php");

$comcid = $cid[0];

if ($comcid <> ""){
	$query = "SELECT published, approved FROM ".$dbprefix."links WHERE lid=$comcid";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$publish = $row->published;
		$approved = $row->approved;
	}
}

switch ($task){
	case "edit":
	if ($comcid==""){
		$comcid=$lid;
	}
	$menu->EDIT_MENU_Weblinks($comcid, $option, $categories, $publish, $approved);
	break;
	case "new":
	$menu->NEW_MENU_Weblinks($categories);
	break;
	default:
	$default = new MENU_Default($act, $option);
}
?>
