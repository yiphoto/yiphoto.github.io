<?php
//Latest News//
/**
*  Mambo Open Source Version 4.0.12
*  Dynamic portal server and Content managment engine
*  20-01-2003
*
*  Copyright (C) 2000 - 2003 Miro International Pty Ltd
*  Distributed under the terms of the GNU General Public License
*  This software may be used without warranty provided these statements are left
*  intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*  This code is available at http://sourceforge.net/projects/mambo
*
*  Site Name: Mambo Open Source Version 4.0.12
*  File Name: mod_latestnews.php
*  Date: 22/02/2003
*  Version #: 4.0.12
*  Comments: Shows the latest news as a page module
**/
$content="";
$query1="SELECT sid as stid, title as sttitle FROM ".$dbprefix."stories WHERE (frontpage=0 and published=1 and archived=0 and checked_out=0) ORDER BY time DESC LIMIT 5";
$result1=$database->openConnectionWithReturn($query1);
while ($row=mysql_fetch_object($result1)) {
	$storyid = $row->stid;
	$storytitle = $row->sttitle;
$content .="-<a href='index.php?option=news&task=viewarticle&sid=".$storyid."'>".$storytitle." </A><br>";
}
?>
