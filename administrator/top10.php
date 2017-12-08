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
*	File Name: top10.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_top10.php");
$top10html = new HTML_top10();

if ($task == "news"){
	$query = "SELECT counter, title FROM ".$dbprefix."stories ORDER BY counter DESC LIMIT 10";
	$result = $database->openConnectionWithReturn($query);
	$i = 0;
	while ($row = mysql_fetch_object($result)){
		$storytitle[$i] = $row->title;
		$storycounter[$i] = $row->counter;
		$i++;
	}
}
else if ($task == "articles"){
	$query = "SELECT counter, title FROM ".$dbprefix."articles ORDER BY counter DESC LIMIT 10";
	$result = $database->openConnectionWithReturn($query);
	$i = 0;
	while ($row = mysql_fetch_object($result)){
		$sectitle[$i] = $row->title;
		$seccounter[$i] = $row->counter;
		$i++;
	}
}

$top10html->showtop10($storytitle, $storycounter, $sectitle, $seccounter, $task)
?>