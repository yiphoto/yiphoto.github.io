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
*	File Name: componentwindow.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 07-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
include ("../../regglobals.php");
session_start();

if (!(isset($_SESSION['admin_session_id']) && $_SESSION['admin_session_id']==md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime']))) {
        print "<script> document.location.href='../index.php'</script>";
        exit();
}

include ("../../configuration.php");
$connection=mysql_connect($host, $user, $password);
mysql_select_db($db,$connection) or die("Query failed with error:".mysql_error());

$query = "SELECT ".$dbprefix."components.module AS module, ".$dbprefix."components.title AS title, ".$dbprefix."component_module.content AS content FROM ".$dbprefix."components, ".$dbprefix."component_module WHERE ".$dbprefix."components.id='$id' AND ".$dbprefix."components.id = ".$dbprefix."component_module.componentid";
$result=mysql_query($query) or die("Query failed with error:".mysql_error()); 
while ($row = mysql_fetch_object($result)){
	$title = $row->title;
	$content = $row->content;
	$module = $row->module;
}
$pat= "SRC=images";
$replace= "SRC=../../images";
$pat2="\\\\'";
$replace2="'";
$content=eregi_replace($pat, $replace, $content);
$content=eregi_replace($pat2, $replace2, $content);
$title=eregi_replace($pat2, $replace2, $title);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Components</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
	<!--
		 Mambo Open Source
		 Dynamic portal server and Content managment engine
		 03-02-2003
 
		 Copyright (C) 2000 - 2003 Miro International Pty. Limited
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
	
	<SCRIPT>
		var content = window.opener.document.adminForm.content.value;  
		var title = window.opener.document.adminForm.mytitle.value;
		
		content = content.replace('#', '');
		title = title.replace('#', '');
		content = content.replace('SRC=images', 'SRC=../../images');
		content = content.replace('SRC=images', 'SRC=../../images');
		title = title.replace('src=images', 'src=../../images');
		content = content.replace('src=images', 'src=../../images');
		title = title.replace('SRC=\"images', 'SRC=\"../../images');
		content = content.replace('SRC=\"images', 'SRC=\"../../images');
		title = title.replace('src=\"images', 'src=\"../../images');
		content = content.replace('src=\"images', 'src=\"../../images');
		
	</SCRIPT>
</head>

<body>
	<TABLE ALIGN="center" WIDTH="160" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
	<TR>
	    <TD CLASS="componentHeading"><SCRIPT>document.write(title);</SCRIPT></TD>
	</TR>
	<TR>
	    <TD VALIGN='top' HEIGHT='90%'><SCRIPT>document.write(content);</SCRIPT></TD>
	</TR>
	<TR>
	    <TD ALIGN='center'><A HREF="#" onClick="window.close()">Close</A></TD>
	</TR>
	</TABLE>
</body>
</html>