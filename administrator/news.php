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
*	File Name: news.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/

/* jimijon - added access below */
/* savednew and savedit         */

require_once("includes/auth.php");

require ("classes/html/HTML_news.php");
$newshtml = new HTML_news();

require("classes/news.php");
$news = new news();

switch ($task){
	case "new":
	$news->newNews($database, $dbprefix, $newshtml, $option, $text_editor, $categories);
	break;
	case "edit":
	$storyid = $cid[0];
	if ($storyid==""){
		$storyid=$id;
	}
	$news->editNews($database, $dbprefix, $newshtml, $option, $storyid, $myname, $categories, $text_editor);
	break;
	case "savenew":
	$news->saveNewNews($database, $dbprefix, $option, $author, $introtext, $fultext, $newscatid, $image, $mytitle, $ordering, $position, $frontpage, $categories, $access);
	break;
	case "remove":
	if ($cid==""){
		$cid[0]=$sid;
	}
	$news->removenews($database, $dbprefix, $option, $cid, $categories);
	break;
	case "saveedit":
	$news->saveeditnews($database, $dbprefix, $option, $image, $author, $introtext, $fultext, $mytitle, $newscatid, $sid, $task, $position, $ordering, $myname, $porder, $frontpage, $categories, $access);
	break;
	case "publish":
	$news->publishnews($database, $dbprefix, $option, $sid, $cid, $categories);
	break;
	case "unpublish":
	$news->unpublishnews($database, $dbprefix, $option, $sid, $cid, $categories);
	break;
	case "archive":
	$news->archivenews($database, $dbprefix, $option, $sid, $cid, $categories);
	break;
	case "unarchive":
	$news->unarchivenews($database, $dbprefix, $option, $sid, $cid, $categories);
	break;
	case "approve":
	//echo "option:$option, intro:$introtext, ful:$fultext, catid:$newscatid, image:$image, mytitle:$mytitle, ordering:$ordering, position:$position, frontpage:$frontpage, sid:$sid, porder:$porder, categories:$categories";
	//break;
	$news->approvenews($database, $dbprefix, $option, $author, $introtext, $fultext, $newscatid, $image, $mytitle, $ordering, $position, $frontpage, $sid, $porder, $categories, $access);
	//echo "option:$option, intro:$introtext, ful:$fultext, catid:$newscatid, image:$image, mytitle:$mytitle, ordering:$ordering, position:$position, frontpage:$frontpage, sid:$sid, porder:$porder, categories:$categories";
	break;
	default:
	$news->viewNews($database, $dbprefix, $newshtml, $option, $categories, $offset);
}
?>