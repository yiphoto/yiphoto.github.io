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
*	File Name: surveywindow.php
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

$query = "SELECT pollTitle FROM ".$dbprefix."poll_desc WHERE pollID='$id'";
$result=mysql_query($query) or die("Query failed with error:".mysql_error()); 
while ($row = mysql_fetch_object($result)){
	$title = $row->pollTitle;
}
mysql_free_result($result);

$query = "SELECT optionText FROM ".$dbprefix."poll_data WHERE pollid='$id' order by voteid";
$result=mysql_query($query) or die("Query failed with error:".mysql_error()); 
$i = 0;
while ($row = mysql_fetch_object($result)){
	$optionText[$i] = $row->optionText;
	$i++;
}
mysql_free_result($result);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Survey Preview</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
	<!--
		 Mambo Open Source
		 Dynamic portal server and Content managment engine
		 03-02-2003
 
		 Copyright (C) 2000 - 2003 Miro International Pty. Limited
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
</head>

<body bgcolor="#FFFFFF">
	<FORM>
	<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" >
	<TR>
	    <TD CLASS="componentHeading" COLSPAN='2'><?php echo $title; ?></TD>
	</TR>
	<?php for ($i = 0; $i < count($optionText); $i++){ 
		if ($optionText[$i] <> ""){
	?>
	<TR>
	    <TD VALIGN='top' HEIGHT='30'><INPUT TYPE="radio" NAME="survey" VALUE="<?php echo $optionText[$i]; ?>"></TD><TD WIDTH="100%" VALIGN="top"><?php echo $optionText[$i]; ?></TD>
	</TR>
	<?php } ?>
	<?php } ?>
	<TR>
	    <TD VALIGN='middle' HEIGHT='50' COLSPAN='2' ALIGN='center'><INPUT TYPE="button" NAME="submit" VALUE="Vote">&nbsp;&nbsp;<INPUT TYPE="button" NAME="result" VALUE="Results"></TD>
	</TR>
	<TR>
	    <TD ALIGN='center' COLSPAN='2'><A HREF="#" onClick="window.close()">Close</A></TD>
	</TR>
	</TABLE>
	</FORM>
</body>
</html>