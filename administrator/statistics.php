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
*	File Name: statistics.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_statistics.php");
$statisticshtml = new HTML_statistics();

require("classes/statistics.php");
$statistics = new statistics();

switch ($task){
	case "browser":
	$statistics->browser_stats($database, $dbprefix, $statisticshtml, $task);
	break;
	case "os":
	$statistics->os_stats($database, $dbprefix, $statisticshtml, $task);
	break;
}
?>