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
*	File Name: forums.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_forum.php");
$forumhtml = new HTML_forum;

require("classes/forum.php");
$forum = new forum();

switch ($task){
	case "edit":
	$uid = $cid[0];
	if ($uid==""){
		print "<SCRIPT> alert('Select a forum to edit'); window.history.go(-1);</SCRIPT>\n";
		exit(0);
	}
	$forum->editforum($forumhtml, $database, $dbprefix, $option, $uid, $act, $myname);
	break;
	case "saveedit":
	$forum->saveforum($forumhtml, $database, $dbprefix, $option, $forumName, $description, $moderate, $language, $uid, $moderatorID, $emailModerator);
	break;
	case "remove":
	$forum->removeforum($database, $dbprefix, $option, $cid);
	break;
	case "new":
	$forum->newforum($database, $dbprefix, $option, $act, $forumhtml);
	break;
	case "savenew":
	$forum->savenewforum($option, $database, $dbprefix, $forumName, $description, $moderate, $language, $moderatorID, $emailModerator, $numMessDisp);
	break;
	case "publish":
	$forum->publishforum($option, $database, $dbprefix, $uid, $cid, $image, $categoryname, $position);
	break;
	case "unpublish":
	$forum->unpublishforum($option, $database, $dbprefix, $uid, $cid);
	break;
	case "archive":
	$forum->archiveForum($database, $dbprefix, $option, $cid);
	break;
	case "unarchive":
	$forum->unarchiveForum($database, $dbprefix, $option, $cid);
	break;
	default:
	$forum->showforum($database, $dbprefix, $option, $forumhtml, $act);
}
?>