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
*	File Name: newsflash.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_newsflash.php");
$newsflashhtml = new HTML_newsflash();

require("classes/newsflash.php");
$newsflash = new newsflash();

switch ($task){
	case "new":
	$newsflash->addNewsflash($database, $dbprefix, $newsflashhtml, $option, $text_editor);
	break;
	case "savenew":
	$newsflash->saveNewsflash($database, $dbprefix, $flashtitle, $content, $option);
	break;
	case "edit":
	$newsflashid = $cid[0];
	$newsflash->editNewsflash($newsflashhtml, $database, $dbprefix, $option, $newsflashid, $myname, $text_editor);
	break;
	case "saveedit":
	$newsflash->saveEditNewsflash($newsflashhtml, $database, $dbprefix, $flashtitle, $content, $newsflashid, $option, $myname);
	break;
	case "remove":
	$newsflash->removeNewsflash($database, $dbprefix, $option, $cid);
	break;
	case "publish":
	$newsflash->publishNewsflash($database, $dbprefix, $option, $newsflashid, $cid);
	break;
	case "unpublish":
	$newsflash->unpublishNewsflash($database, $dbprefix, $option, $newsflashid, $cid);
	break;
	default:
	$newsflash->viewNewsflash($database, $dbprefix, $newsflashhtml, $option);
}
?>