<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: accesscheck.php
*	Date: 10-12-2002
* 	Version #: 4.0.12
*	Comments:
**/

function checkaccess($cook, $db, $dbprefix){
	/* Get the visitor's GroupID */
	$gidf = 0;
	if ($cook<>""){
		$cryptSessionID=md5($cook);
		$queryg = "SELECT gid FROM ".$dbprefix."session WHERE session_ID='$cryptSessionID'";
		$resultg = mysql_db_query($db, $queryg) or die("Did not execute query");
		while ($rowg = mysql_fetch_object($resultg)){
			$gidf = $rowg->gid;
		}
	}
	return $gidf;
}

function menucheck($Itemid, $menu_option, $gid, $dbprefix){
	
	$dblink="index.php?option=$menu_option";
	$resultC = mysql_query ("SELECT access FROM ".$dbprefix."menu WHERE id='$Itemid' OR link='$dblink'") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		exit;
	}
	$c = 0;
	while ($rowC = mysql_fetch_object($resultC)){
		$access[$c]=$rowC->access;
	}
	
	if ($access[0]<=$gid) {
		return true;
	} else {
		return false;
	}
	
}

?>