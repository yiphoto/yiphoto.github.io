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
*	File Name: imagecode.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Mambo Open Source - Image Gallery</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">

<SCRIPT LANGUAGE="javascript">
<!--
	function changePosition(positionimage){
		
		var original = new String(document.codeimage.imagecode.value);
		if (positionimage == "left"){
			var express = /ALIGN=right/g;
			var newString = original.replace(express, "ALIGN=left");
			}
		else {
			var express = /ALIGN=left/g;
			var newString = original.replace(express, "ALIGN=right");
			}
		document.codeimage.imagecode.value = newString;
		}
	function windowclose(){
		parent.window.close();
		}
//-->
</SCRIPT>

</head>

<body bgcolor="#FFFFFF">
<FORM NAME="codeimage">
<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0" ALIGN="center">
<TR>
    <TD>Image Code:</TD>
    <TD><INPUT class="inputbox" TYPE="text" NAME="imagecode" SIZE="65"></TD>
	<TD><INPUT TYPE="radio" NAME="position" VALUE="left" CHECKED onClick="changePosition('left')";>Left</TD>
    <TD><INPUT TYPE="radio" NAME="position" VALUE="right" onClick="changePosition('right')";>Right</TD>
</TR>
<TR>
	<TD ALIGN="center" COLSPAN="3"><A HREF="#" onClick="windowclose()">Close</A></TD>
</TR>
</TABLE>
</FORM>

</body>
</html>
