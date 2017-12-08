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
*	File Name: category.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_category.php");
$categoryhtml = new HTML_category;

require("classes/category.php");
$category = new category();

switch ($task){
	case "edit":
	$uid = $cid[0];
	if ($uid==""){
		print "<SCRIPT> alert('Select a category to edit'); window.history.go(-1);</SCRIPT>\n";
		exit(0);
	}
	$category->editcategory($categoryhtml, $database, $dbprefix, $option, $uid, $act, $myname);
	break;
	case "saveedit":
	$category->savecategory($categoryhtml, $database, $dbprefix, $option, $categoryname, $image, $act, $uid, $pname, $position, $access);
	break;
	case "remove":
	$category->removecategory($database, $dbprefix, $option, $cid, $act);
	break;
	case "new":
	$category->newcategory($database, $dbprefix, $option, $act, $categoryhtml);
	break;
	case "savenew":
	$category->savenewcategory($option, $database, $dbprefix, $categoryname, $act, $access, $image, $position);
	break;
	case "publish":
	$category->publishcategory($option, $database, $dbprefix, $uid, $cid, $image, $categoryname, $position);
	break;
	case "unpublish":
	$category->unpublishcategory($option, $database, $dbprefix, $uid, $cid);
	break;
	default:
	$category->showcategory($database, $dbprefix, $option, $categoryhtml, $act);
}
?>