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
*	File Name: components.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_components.php");
$componentshtml = new HTML_components();

require("classes/components.php");
$components = new components();

switch ($task){
	case "new":
	$components->addComponent($database, $dbprefix, $componentshtml, $option, $text_editor);
	break;
	case "savenew":
	$components->saveComponent($database, $dbprefix, $mytitle, $content, $position, $order, $access);
	break;
	case "edit":
	$componentid = $cid[0];
	$components->editComponent($componentshtml, $database, $dbprefix, $option, $componentid, $myname, $text_editor);
	break;
	case "saveedit":
	$components->saveeditcomponent($html, $database, $dbprefix, $mytitle, $content, $position, $show, $componentid, $order, $original, $myname, $module, $access);
	break;
	case "remove":
	$components->removecomponent($database, $dbprefix, $option, $cid);
	break;
	case "publish":
	$components->publishComponent($database, $dbprefix, $option, $cid, $componentid, $mytitle, $content, $position, $order, $original);
	break;
	case "unpublish":
	$components->unpublishComponent($database, $dbprefix, $option, $componentid, $cid);
	break;
	default:
	$components->viewcomponents($database, $dbprefix, $componentshtml, $option);
}
?>
