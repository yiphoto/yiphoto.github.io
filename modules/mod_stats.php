<?php 
//Site Statistics//
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
*	File Name: mod_stats.php
*	Developer: Robert Castley
*	Date: 15-02-2003
* 	Version #: 4.0.12
*	Comments:
**/

include('language/'.$lang.'/lang_mod_stats.php');

$content ="";
$content .="<b>OS      :</b> " .substr(php_uname(),0,7);
$content .="<br><b>PHP     :</b> " .phpversion();
$content .="<br><b>MySQL   :</b> " .mysql_get_server_info();
$content .="<br><b>"._TIME_STAT."    : </b>" .date("H:i");


$query1="SELECT count(id) as user_count from ".$dbprefix."users";
$result1=$database->openConnectionWithReturn($query1);
while ($row=mysql_fetch_object($result1)) {
	$uc = $row->user_count;
}
$content .="<br><b>"._MEMBERS_STAT.": </b>" .$uc;

$query2="SELECT sum(count) as count from ".$dbprefix."counter where type='browser'";
$result2=$database->openConnectionWithReturn($query2);
while ($row=mysql_fetch_object($result2)) {
	$hits = $row->count;
}
$content .="<br><b>"._HITS_STAT."    : </b>" .$hits;


$query3="SELECT count(sid) as news from ".$dbprefix."stories where published=1";
$result3=$database->openConnectionWithReturn($query3);
while ($row=mysql_fetch_object($result3)) {
	$news = $row->news;
}
$content .="<br><b>"._NEWS_STAT."    :</b> " .$news;
?>