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
*	File Name: subsections.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_subsections.php");
$subsectionshtml = new HTML_subsections();

require("classes/subsections.php");
$subsections = new subsections();

switch ($task){
	case "new":
	$subsections->addSubsection($database, $dbprefix, $subsectionshtml, $option, $sections);
	break;
	case "AddStep2":
	$subsections->addStep2($database, $dbprefix, $subsectionshtml, $option, $ItemName, $ItemType, $SectionID, $sections, $access);
	break;
	case "AddStep3":
	$subsections->addStep3($database, $dbprefix, $subsectionshtml, $option, $ItemName, $PageSource, $SectionID, $sections, $access);
	break;
	case "savenew":
	$subsections->saveSubsection($database, $dbprefix, $ItemName, $pagecontent, $Weblink, $moduleID, $option, $SectionID, $heading, $sections, $browserNav, $access);
	break;
	case "edit":
	$Itemid = $cid[0];
	if (trim($categories)!=""){
		$sections=$categories;
	}
	$subsections->editSubsection($database, $dbprefix, $subsectionshtml, $option, $Itemid, $checkedID, $myname, $sections);
	break;
	case "saveedit":
	$subsections->saveEditSubsection($database, $dbprefix, $menusectionshtml, $option, $ItemName, $link2, $pagecontent, $filecontent, $Itemid, $SectionID, $order, $origOrder, $myname, $origcatid, $Weblink, $heading, $browserNav, $access);
	break;
	case "Upload":
	$subsections->saveFileUpload($database, $dbprefix, $option,  $userfile, $userfile_name, $Itemid);
	break;
	case "remove":
	$subsections->removeSubsection($database, $dbprefix, $option, $cid, $sections);
	break;
	case "publish":
	$subsections->publishSubsection($database, $dbprefix, $option, $Itemid, $cid, $sections);
	break;
	case "unpublish":
	$subsections->unpublishSubsection($database, $dbprefix, $option, $Itemid, $cid, $sections);
	break;
	case "saveUploadImage":
	$subsections->saveUploadImage($database, $dbprefix, $option, $userfile1, $userfile1_name, $userfile2, $userfile2_name, $userfile3, $userfile3_name, $userfile4, $userfile4_name, $userfile5, $userfile5_name, $sectionid);
	break;
	default:
	if (trim($categories)!=""){
		$sections=$categories;
	}
	$subsections->viewSubItems($database, $dbprefix, $subsectionshtml, $option, $sections);
}
?>