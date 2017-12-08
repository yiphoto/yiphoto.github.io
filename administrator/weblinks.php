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
*	File Name: weblinks.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_weblink.php");
$weblinkshtml = new HTML_weblinks();

require("classes/weblinks.php");
$weblinks = new weblinks();

switch($task){
	case "edit":
	$id = $cid[0];
	if ($id==""){
		$id=$lid;
	}
	$weblinks->editweblinks($weblinkshtml, $database, $dbprefix, $option, $id, $myname, $categories);
	break;
	case "saveedit":
	$weblinks->saveeditweblinks($database, $dbprefix, $option, $lid, $mytitle, $description, $url, $category, $myname, $ordering, $porder, $cid, $categories);
	break;
	case "savenew":
	$weblinks->savenewweblink($database, $dbprefix, $option, $mytitle, $description, $url, $category, $ordering, $categories);
	break;
	case "remove":
	if ($cid==""){
		$cid[0]=$lid;
	}
	$weblinks->removeweblink($database, $dbprefix, $option, $cid, $categories);
	break;
	case "new":
	$weblinks->addweblink($database, $dbprefix, $weblinkshtml, $option, $categories);
	break;
	case "publish":
	$weblinks->publishweblink($database, $dbprefix, $option, $cid, $lid, $categories);
	break;
	case "unpublish":
	$weblinks->unpublishweblink($database, $dbprefix, $option, $cid, $lid, $categories);
	break;
	case "approve":
	$weblinks->approvelink($database, $dbprefix, $option, $lid, $categories, $category, $url, $description, $mytitle, $description);
	break;
	default:
	$weblinks->showWeblinks($option, $weblinkshtml, $database, $dbprefix, $categories);
}
?>
