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
*	File Name: articles.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_articles.php");
$articleshtml = new HTML_articles();

require("classes/articles.php");
$articles = new articles();

switch($task){
	case "edit":
	if ($artid==""){
		$artid = $cid[0];
	}
	$articles->editarticle($articleshtml, $database, $dbprefix, $option, $artid, $myname, $categories, $text_editor);
	break;
	case "saveedit":
	$articles->saveeditarticle($database, $dbprefix, $option, $mytitle, $artid, $content, $category, $task, $original, $ordering, $porder, $myname, $seccatid, $pcategory, $categories, $author);
	break;
	case "savenew":
	$articles->savenewarticle($database, $dbprefix, $option, $mytitle, $content, $category, $ordering, $uid, $author, $categories);
	break;
	case "remove":
	if ($artid <> "")
	$cid[0] = $artid;
	
	$articles->removearticle($database, $dbprefix, $option, $cid, $categories, $myname);
	break;
	case "new":
	$articles->addArticle($database, $dbprefix, $option, $articleshtml, $categories, $text_editor);
	break;
	case "approvearticle":
	$articles->editarticle($articleshtml, $database, $dbprefix, $option, $artid, $myname, $categories);
	break;
	case "approve":
	$articles->approvearticle($database, $dbprefix, $option, $artid, $categories, $category, $author, $content, $mytitle);
	break;
	case "publish":
	$articles->publisharticle($database, $dbprefix, $option, $cid, $artid, $myname, $categories);
	break;
	case "unpublish":
	$articles->unpublisharticle($database, $dbprefix, $option, $cid, $artid, $myname, $categories);
	break;
	case "archive":
	if ($cid[0]==""){
		print "<SCRIPT> alert('Select an article to archive'); window.history.go(-1);</SCRIPT>\n";
		exit(0);
	}
	$articles->archivearticle($database, $dbprefix, $option, $cid, $categories);
	break;
	case "unarchive":
	if ($cid[0]==""){
		print "<SCRIPT> alert('Select an article to unarchive'); window.history.go(-1);</SCRIPT>\n";
		exit(0);
	}
	$articles->unarchivearticle($database, $dbprefix, $option, $cid, $categories);
	break;
	default:
	$articles->showArticles($option, $articleshtml, $database, $dbprefix, $categories);
}
?>