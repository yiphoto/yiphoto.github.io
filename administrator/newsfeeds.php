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
*	File Name: newsfeeds.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_newsfeeds.php");
$newsfeedshtml = new HTML_newsfeeds();

require("classes/newsfeeds.php");
$newsfeeds = new newsfeeds();

$selection = split("&", $REQUEST_URI);
$selections = array();
$k = 0;
for ($i = 0; $i < count($selection); $i++){
	if (eregi("selections", $selection[$i])){
		$selected = split("=", $selection[$i]);
		$selections[$k] = $selected[1];
		$k++;
	}
}

for ($i = 0; $i < count($selections); $i++){
	$selections[$i] = ereg_replace( "[+]", " ", $selections[$i]);
}

switch ($task){
	default:
	$newsfeeds->viewnewsfeeds($database, $dbprefix, $newsfeedshtml, $option);
	break;
	case "save":
	$newsfeeds->savenewsfeeds($database, $dbprefix, $option, $selections, $num);
	break;
}
?>