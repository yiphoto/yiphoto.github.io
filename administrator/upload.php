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
*	File Name: upload.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
include ("../regglobals.php");
session_start();

if (!(isset($_SESSION['admin_session_id']) && $_SESSION['admin_session_id']==md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime']))) {
	print "<script> document.location.href='index.php'</script>";
	exit();
}
?>
<html>
<head>
	<title>File Upload</title>
	<link rel="stylesheet" href="../css/admin.css" type="text/css">
	<!--
		 Mambo Open Source
		 Dynamic portal server and Content managment engine
		 20-01-2003

		 Copyright (C) 2000 - 2003 Miro International Pty. Limited
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
</head>
<body>
<?php $choice="saveUploadNew";?>
	<FORM ENCTYPE="multipart/form-data" ACTION="banners_current.php" METHOD=POST NAME="filename">
		<table border=0 bgcolor=FFFFFF cellpadding=4 cellspacing=0 width=99%>
			<TR>
				<TD align="left"><span class='componentHeading'>Upload An Image</span></TD>
			</TR>
			<TR>
				<TD ALIGN="Left">Upload file:  <INPUT NAME="userfile" TYPE="file"></TD>
			</TR>
			<TR>
				<TD>
					<input type=hidden name=task value="<?php echo $choice; ?>">
					<input type=hidden name=bannerid value="<?php echo $bannerid; ?>">
					<INPUT TYPE="submit" VALUE="Send File">
				</TD>
			</TR>
		</TABLE>
	</FORM>
	<a href="javascript: window.opener.focus; window.close();">Close</a>

<?php if ($sectionid!=""){
	if ($option=="MenuSections"){?>
		<FORM ENCTYPE="multipart/form-data" ACTION="menusections.php" METHOD=POST NAME="filename">
	<?php } elseif ($option=="SubSections"){?>
		<FORM ENCTYPE="multipart/form-data" ACTION="subsections.php" METHOD=POST NAME="filename">
	<?php } ?>
		<TABLE WIDTH="99%" CELLPADDING="0" CELLSPACING="3" BORDER="0" bgcolor=ffffff>
		<TR><TD class='componentHeading'>Upload Images</TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile1" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile2" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile3" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile4" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile5" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD><input type=hidden name=task value="saveUploadImage">
				<input type=hidden name=sectionid value="<?php echo $sectionid; ?>">
				<INPUT TYPE="submit" VALUE="Send File(s)"></TD></TR>
	</TABLE></CENTER>
	</FORM>
	<a href="javascript:window.opener.focus; window.close();">Close</a>
	<?php } ?>
</body>
</html>
