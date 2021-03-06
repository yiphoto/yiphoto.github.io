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
*	File Name: subsections.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("menubar/html/menusubsections.php");
$menu = new menusubsections();

require ("menubar/html/menudefault.php");

switch ($task){
	case "edit":
	if (trim($checkedID)!=""){
		$comcid = $checkedID;
	}else{
		$comcid=$cid[0];
	}
	$menu->EDIT_MENU_subsections($comcid, $option, $database, $dbprefix, $categories);
	break;
	case "new":
	$menu->NEW_MENU_subsections($option, $sections);
	break;
	case "AddStep2":
	if (trim($ItemType)!="Own"){
		$menu->SAVE_MENU_subsections($option, $sections, $ItemType);
	}else{
		$menu->NEW_MENU_subsections($option, $sections);
	}
	break;
	case "AddStep3":
	$menu->SAVE_MENU_subsections($option, $sections, $PageSource);
	break;
	default:
	$default = new MENU_Default($act, $option);
}
?>


