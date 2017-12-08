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
*	File Name: getids.php
*	Date: 10-12-2002
* 	Version #: 4.0.12
*	Comments:
**/

function getcatids($field, $table, $gid, $db, $dbprefix){
	
	//Get all Story Topics
	$resultC = mysql_db_query ($db, "SELECT $field FROM ".$dbprefix."$table WHERE published=1") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$c = 0;
	while ($rowC = mysql_fetch_object($resultC)){
		$topic[$c] = $rowC->$field;
		$c++;
	}
	
	//Build CatID query
	$accquery="(";
	for ($a=0; $a<count($topic); $a++){
		$pos = strrpos($accquery, $topic[$a]);
		if ($pos === false) {
			$accquery = $accquery."categoryid=".$topic[$a]." OR ";
		}
	}
	
	//Strip off the final OR
	if (strlen($accquery)>4) {
		$accquery = substr($accquery,0,(strlen($accquery)-4));
	}
	$accquery=$accquery.")";
	
	//Get all CatIDs
	$resultD = mysql_db_query ($db, "SELECT categoryid FROM ".$dbprefix."categories WHERE (access<='$gid' AND published=1 AND ".$accquery.")") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$d = 0;
	while ($rowD = mysql_fetch_object($resultD)){
		$cid[$d] = $rowD->categoryid;
		$d++;
	}
	
	//Build TopicID query
	$topquery="(";
	for ($a=0; $a<count($cid); $a++){
		$pos = strrpos($topquery, $cid[$a]);
		if ($pos === false) {
			$topquery = $topquery.$field."=".$cid[$a]." OR ";
		}
	}
	
	//Strip off the final OR
	if (strlen($topquery)>4) {
		$topquery = substr($topquery,0,(strlen($topquery)-4));
		$topquery = "AND ".$topquery.")";
	} else {
		$topquery = "";
	}
	
	
	return $topquery;
}


function getmenuids($field, $table, $gid, $db, $dbprefix){
	
	//Get all Story Topics
	$resultC = mysql_db_query ($db, "SELECT $field FROM ".$dbprefix."$table WHERE inuse=1") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$c = 0;
	while ($rowC = mysql_fetch_object($resultC)){
		$topic[$c] = $rowC->$field;
		$c++;
	}
	
	//Build MenuID query
	$accquery="(";
	for ($a=0; $a<count($topic); $a++){
		$pos = strpos($accquery, $topic[$a]);
		if ($pos === false) {
			$accquery = $accquery."id=".$topic[$a]." OR ";
		}
	}
	//Strip off the final OR
	if (strlen($accquery)>4) {
		$accquery = substr($accquery,0,(strlen($accquery)-4));
	}
	$accquery=$accquery.")";
	
	//Get all MenuIDs
	$resultD = mysql_db_query ($db, "SELECT id FROM ".$dbprefix."menu WHERE (access<='$gid' AND inuse=1 AND ".$accquery.")") or $mysql_eval_err = mysql_error();
	if ($mysql_eval_err<>'') {
		return '';
	}
	$d = 0;
	while ($rowD = mysql_fetch_object($resultD)){
		$cid[$d] = $rowD->id;
		$d++;
	}
	
	//Build MenuContentID query
	$topquery="(";
	for ($a=0; $a<count($cid); $a++){
		$pos = strpos($topquery, $cid[$a]);
		if ($pos === false) {
			$topquery = $topquery."menuid"."=".$cid[$a]." OR ";
		}
	}
	
	//Strip off the final OR
	if (strlen($topquery)>4) {
		$topquery = substr($topquery,0,(strlen($topquery)-4));
		$topquery = "AND ".$topquery.")";
	} else {
		$topquery = "";
	}
	
	return $topquery;
}
?>