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
*	File Name: navigation.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
include ("../../regglobals.php");
session_start();

if (!(isset($_SESSION['admin_session_id']) && $_SESSION['admin_session_id']==md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime']))) {
        print "<script> document.location.href='../index.php'</script>";
        exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Navigation</title>
<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
</head>

<body>
<BR>
<TABLE CELLSPACING="2" CELLPADDING="0" BORDER="0">
<TR>
    <TD><b>Navigation</b></td>
</tr>
<tr>
    <TD><li><A HREF="index.php?gal=0&image=jpg&directory=<?php echo $directory;?>&Itemid=<?php echo $Itemid;?>" TARGET="images">View Jpegs</A></TD>
</TR>
<TR>
    <TD><li><A HREF="index.php?gal=0&image=gif&directory=<?php echo $directory;?>&Itemid=<?php echo $Itemid;?>" TARGET="images">View Gifs</A></TD>
</TR>
<TR>
    <TD><li><A HREF="index.php?gal=0&image=png&directory=<?php echo $directory;?>&Itemid=<?php echo $Itemid;?>" TARGET="images">View PNGs</A></TD>
</TR>
<TR>
    <TD><li><A HREF="index.php?gal=0&image=swf&directory=<?php echo $directory;?>&Itemid=<?php echo $Itemid;?>" TARGET="images">View swf</A></TD>
</TR>
<TR>
    <TD><li><A HREF="pdf.php" TARGET="images">List documents</A></TD>
</TR>
<TR>
	<TD><li><A HREF="uploadimage.php?directory=<?php echo $directory;?>&Itemid=<?php echo $Itemid;?>" TARGET="images">Upload</A></TD>
</TR>
</TABLE>
</body>
</html>