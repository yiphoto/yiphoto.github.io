<?php 
//Online users//
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
*	File Name: mod_online.php
*	Developer: Emir Sakic
*	Date: 15-02-2003
* 	Version #: 4.0.12
*	Comments: This module displays list of online registrated users on your Mambo portal.
**/

include('language/'.$lang.'/lang_mod_online.php');

$query2 = "SELECT username FROM ".$dbprefix."session where (guest=0 and (usertype is NULL OR usertype='user'))";
$result2=$database->openConnectionWithReturn($query2);

$content="";

// Use mysql_fetch_row to retrieve the results
for ($count = 1; $row = mysql_fetch_row ($result2); ++$count) {
	$content.="$row[0]<br>";
}

if ($content=="") $content.=_NONE;
?>