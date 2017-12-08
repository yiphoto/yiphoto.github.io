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
*	File Name: database.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class database {
	function database(){
		include ("configuration.php");
		$link=mysql_connect($host, $user, $password);
		mysql_select_db($db) or die("Query failed with error: ".mysql_error());
	}

	function openConnectionWithReturn($query){
		$result=mysql_query($query) or die("Query failed with error: ".mysql_error());
		return $result;
	}

	function openConnectionNoReturn($query){
		mysql_query($query) or die("Query failed with error: ".mysql_error());
	}
}
?>
