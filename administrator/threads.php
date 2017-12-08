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
*	File Name: threads.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_threads.php");
$threadshtml = new HTML_threads();

require("classes/threads.php");
$threads = new threads();

switch($task){
	case "edit":
	if ($tid==""){
		$tid = $cid[0];
	}
	$threads->editThread($threadshtml, $database, $dbprefix, $option, $tid, $myname, $forum, $act, $text_editor);
	break;
	case "saveedit":
	$threads->saveEditThread($database, $dbprefix, $option, $subject, $tid, $content, $author, $act, $forum, $myname, $replytoid, $forumid, $origforumid, $authorid, $replyauthorid);
	break;
	case "savenew":
	$threads->savenewThread($database, $dbprefix, $option, $act, $forum, $subject, $content, $forumID, $author, $authorid);
	break;
	case "remove":
	if ($tid <> ""){
		$cid[0] = $tid;
	}
	$threads->removeThread($database, $dbprefix, $option, $cid, $forum, $act);
	break;
	case "new":
	$adminid=$userid;
	$threads->addThread($database, $dbprefix, $option, $act, $threadshtml, $forum, $myname, $text_editor, $adminid);
	break;
	case "reply":
	$threads->newReply($database, $dbprefix, $option, $act, $threadshtml, $forum, $myname, $cid, $text_editor);
	break;
	case "savenewreply":
	$threads->savenewReply($database, $dbprefix, $option, $act, $forum, $subject, $content, $forumID, $author, $authorid, $published, $archive, $repLevel, $repID, $topMessageID);
	break;
	case "publish":
	$threads->publishThread($database, $dbprefix, $option, $cid, $tid, $myname, $forum, $act, $live_site);
	break;
	case "unpublish":
	$threads->unpublishThread($database, $dbprefix, $option, $cid, $tid, $myname, $forum, $act);
	break;
	case "archive":
	$threads->archiveThread($database, $dbprefix, $option, $cid, $forum, $act);
	break;
	case "unarchive":
	$threads->unarchiveThread($database, $dbprefix, $option, $cid, $forum, $act);
	break;
	default:
	$threads->showThreads($option, $threadshtml, $database, $dbprefix, $forum, $act);
}
?>