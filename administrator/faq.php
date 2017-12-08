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
*	File Name: faq.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_faq.php");
$faqhtml = new HTML_faq();

require("classes/faq.php");
$faq = new faq();

switch ($task){
	case "edit":
	$catid = $cid[0];
	if ($catid==""){
		$catid=$artid;
	}
	$faq->editFaq($faqhtml, $database, $dbprefix, $option, $catid, $myname, $categories, $text_editor);
	break;
	case "saveedit":
	$faq->saveeditfaq($faqhtml, $database, $dbprefix, $option, $mytitle, $category, $content, $artid, $myname, $ordering, $porder, $categories, $pcategory);
	break;
	case "remove":
	if ($cid==""){
		$cid[0]=$artid;
	}
	$faq->removefaq($database, $dbprefix, $option, $cid, $categories);
	break;
	case "new":
	$faq->addFaq($faqhtml, $database, $dbprefix, $option, $text_editor, $categories);
	break;
	case "savenew":
	$faq->savefaq($database, $dbprefix, $option, $mytitle, $category, $content, $ordering, $categories);
	break;
	case "publish":
	$faq->publishfaq($database, $dbprefix, $option, $cid, $artid, $myname, $categories);
	break;
	case "unpublish":
	$faq->unpublishfaq($database, $dbprefix, $option, $cid, $artid, $myname, $categories);
	break;
	case "archive":
	$faq->archivefaq($database, $dbprefix, $option, $cid, $categories);
	break;
	case "unarchive":
	$faq->unarchivefaq($database, $dbprefix, $option, $cid, $categories);
	break;
	case "approve":
	$faq->approveFaq($database, $dbprefix, $option, $artid, $categories, $category, $content, $mytitle);
	break;
	default:
	$faq->showFaq($database, $dbprefix, $option, $faqhtml, $categories);
}
?>