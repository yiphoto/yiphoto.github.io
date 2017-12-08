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
*	File Name: cancel.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
include ('../../regglobals.php');

session_start();
if ((!isset($_SESSION['admin_session_id'])) || ($_SESSION['admin_session_id']!=md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime']))) {
        print "<script> document.location.href='../index.php'</script>";
        exit();
}

include ("../../configuration.php");
$connection=mysql_connect($host, $user, $password);
mysql_select_db($db,$connection) or die("Query failed with error:".mysql_error());
	
if ($option == "Components"){
	$query = "UPDATE ".$dbprefix."components SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE id=$id";
}
elseif (($option == "News")  && ($act <> "categories")){
	$query = "UPDATE ".$dbprefix."stories SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE sid=$id";
}
elseif (($option == "Articles")  && ($act <> "categories")){
	$query = "UPDATE ".$dbprefix."articles SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE artid=$id";
}
elseif (($option == "Faq")  && ($act <> "categories")){
	$query = "UPDATE ".$dbprefix."faqcont SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE artid=$id";
}
elseif (($option == "Weblinks")  && ($act <> "categories")){
	$query = "UPDATE ".$dbprefix."links SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE lid=$id";
}
elseif (($option == "MenuSections") || ($option == "SubSections")){
	$query= "UPDATE ".$dbprefix."menu SET checked_out=0, checked_out_time='00:00:00', editor=NULL where id=$id";
}
elseif ($option == "Current"){
	$query= "UPDATE ".$dbprefix."banner SET checked_out=0, checked_out_time='00:00:00', editor=NULL where bid=$id";
}
elseif ($option == "Clients"){
	$query= "UPDATE ".$dbprefix."bannerclient SET checked_out=0, checked_out_time='00:00:00', editor=NULL where cid=$id";
}
elseif ($option == "Newsflash"){
	$query= "UPDATE ".$dbprefix."newsflash SET checked_out=0, checked_out_time='00:00:00', editor=NULL where newsflashID=$id";
}
elseif ($act == "categories"){
	$query = "UPDATE ".$dbprefix."categories SET checked_out=0, checked_out_time='00:00:00', editor=NULL where categoryid=$id";
}
elseif ($option == "Survey"){
	$query = "UPDATE ".$dbprefix."poll_desc SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE pollID='$id'";
}
elseif ($option == "Forums"){
	if ($act=="threads"){
		$query = "UPDATE ".$dbprefix."messages SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE ID=$id";
	}else{
		$query = "UPDATE ".$dbprefix."forum SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE ID=$id";
	}
}
mysql_query($query) or die("Query failed with error:".mysql_error());

if ($act == "categories"){
	print "<SCRIPT>document.location.href='../index2.php?option=$option&act=$act'</SCRIPT>\n";
}
else if ($act=="threads"){
	print "<SCRIPT>document.location.href='../index2.php?option=$option&act=$act&forum=$forum'</SCRIPT>\n";
}else{
	if ($sections!=""){
		print "<SCRIPT>document.location.href='../index2.php?option=$option&sections=$sections'</SCRIPT>\n";
	}else{
		print "<SCRIPT>document.location.href='../index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
}
?>