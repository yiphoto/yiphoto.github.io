<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	03-02-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: menusections.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_menusections.php");
$menusectionshtml = new HTML_menusections();

require("classes/menusections.php");
$menusections = new menusections();

switch ($task){
	case "new":
	$menusections->addMenusection($database, $dbprefix, $menusectionshtml, $option);
	break;
	case "AddStep2":
	$menusections->addStep2($database, $dbprefix, $menusectionshtml, $option, $ItemName, $ItemType, $access);
	break;
	case "AddStep3":
	$menusections->addStep3($database, $dbprefix, $menusectionshtml, $option, $ItemName, $PageSource, $text_editor, $access);
	break;
	case "savenew":
	$menusections->saveMenusection($database, $dbprefix, $ItemName, $pagecontent, $Weblink, $moduleID, $option, $heading, $browserNav, $access);
	break;
	case "edit":
	$Itemid = $cid[0];
	$menusections->editMenusection($database, $dbprefix, $menusectionshtml, $option, $Itemid, $myname, $text_editor);
	break;
	case "saveedit":
	$menusections->saveEditMenusection($database, $dbprefix, $menusectionshtml, $option, $ItemName, $pagecontent, $filecontent, $Itemid, $order, $origOrder, $myname, $Weblink, $link2, $heading, $browserNav, $access);
	break;
	case "Upload":
	$menusections->saveFileUpload($database, $dbprefix, $option,  $userfile, $userfile_name, $Itemid);
	break;
	case "remove":
	$menusections->removeMenusection($database, $dbprefix, $option, $cid);
	break;
	case "publish":
	$menusections->publishMenusection($database, $dbprefix, $option, $Itemid, $cid);
	break;
	case "unpublish":
	$menusections->unpublishMenusection($database, $dbprefix, $option, $Itemid, $cid);
	break;
	case "saveUploadImage":
	$menusections->saveUploadImage($option, $userfile1, $userfile1_name, $userfile2, $userfile2_name, $userfile3, $userfile3_name, $userfile4, $userfile4_name, $userfile5, $userfile5_name, $sectionid);
	break;
	default:
	$menusections->viewMenuItems($database, $dbprefix, $menusectionshtml, $option);
}
?>