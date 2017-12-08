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
*	File Name: systeminfo.php
*
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_systemInfo.php");
$systemInfohtml = new HTML_systemInfo();

switch ($task){
	case "save":
	savesystemInfo($database, $dbprefix, $sitename, $cur_theme, $col_main);
	break;
	default:
	showsystemInfo($systemInfohtml, $database, $dbprefix);
}


function showsystemInfo($systemInfohtml, $database, $dbprefix){
	$query = "SELECT * FROM ".$dbprefix."system";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$sitename = $row->sitename;
		$cur_theme = $row->cur_theme;
		$col_main = $row->col_main;
	}
	
	
	$systemInfohtml->showsystemInfo($sitename, $cur_theme, $col_main);
}

function savesystemInfo($database, $dbprefix, $sitename, $cur_theme, $col_main){
	$query = "DELETE FROM ".$dbprefix."system";
	$database->openConnectionNoReturn($query);
	$query = "INSERT INTO ".$dbprefix."system SET sitename='$sitename', cur_theme='$cur_theme', col_main='$col_main'";
	$database->openConnectionNoReturn($query);
	
	print "<SCRIPT>document.location.href='index2.php?option=systemInfo'</SCRIPT>\n";
}
?>