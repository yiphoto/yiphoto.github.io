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
*	File Name: faq.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("menubar/html/menufaq.php");
$menu = new menufaq();

$comcid = $cid[0];

if ($comcid <> ""){
	$query = "SELECT published, approved FROM ".$dbprefix."faqcont WHERE artid=$comcid";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$publish = $row->published;
		$approved= $row->approved;
	}
}

switch ($task){
	case "edit":
	if ($comcid==""){
		$comcid=$artid;
	}
	$menu->EDIT_MENU_Faq($comcid, $option, $categories, $publish, $approved);
	break;
	case "new":
	$menu->NEW_MENU_Faq($categories);
	break;
	
	default:
	$menu->DEFAULT_MENU_Faq($act, $option);
}
?>
