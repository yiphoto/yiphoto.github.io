<?php 
//Hit Counter//
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	06-01-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: mod_counter.php
*	Developer: Emir Sakic
*	Date: 15-02-2003
* 	Version #: 4.0.12
*	Comments: This script displays counter on your Mambo portal.
**/

include('language/'.$lang.'/lang_mod_counter.php');

$query2 = "SELECT count FROM ".$dbprefix."counter where type='OS'";
$result2=$database->openConnectionWithReturn($query2);

$content=0;

// Use mysql_fetch_row to retrieve the results
for ($count = 1; $row = mysql_fetch_row ($result2); ++$count)
{
	$content = $content + $row[0];
	$content .= " "._VISITORS;
}
?>