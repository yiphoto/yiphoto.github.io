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
*	File Name: newswindow.php
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

if ($print == "print"){
	$query = "SELECT title, introtext, fultext, newsimage, image_position FROM ".$dbprefix."stories WHERE sid=$id";
	$result=mysql_query($query) or die("Query failed with error:".mysql_error()); 
	while ($row = mysql_fetch_object($result)){
		$title = $row->title;
		$introtext = $row->introtext;
		$fultext = $row->fultext;
		$image = $row->newsimage;
		$position = $row->image_position;
	}
	
	$pat= "SRC=images";
	$replace= "SRC=../../images";
	$introtext=eregi_replace($pat, $replace, $introtext);
	$fultext=eregi_replace($pat, $replace, $fultext);
	$title=eregi_replace($pat, $replace, $title);
	
	
	$pat2= "SRC=\"images";
	$replace2= "SRC=\"../../images";
	$introtext=eregi_replace($pat2, $replace2, $introtext);
	$fultext=eregi_replace($pat2, $replace2, $fultext);
	$title=eregi_replace($pat2, $replace2, $title);
	
	$pat3="\\\\'";
	$replace3="'";
	$introtext=eregi_replace($pat3, $replace3, $introtext);
	$title=eregi_replace($pat3, $replace3, $title);
	$fultext=eregi_replace($pat3, $replace3, $fultext);
	
		?>
		<html>
		<head>
			<title>News Preview</title>
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
		<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
		<TR>
	    	<TD CLASS="componentHeading" COLSPAN="2"><?php echo $title;?></TD>
		</TR>
		<TR>
			<?php if ($image !=""){?>
				<TD VALIGN="top" HEIGHT="90%" COLSPAN="2"> <IMG SRC="../../images/stories/<?php echo $image;?>" VSPACE=5 ALIGN="<?php echo $position;?>"><?php echo "$introtext $fultext";?></TD>
			<?php }else {?>
				<TD VALIGN="top" HEIGHT="90%" COLSPAN="2"><?php echo "$introtext $fultext";?></TD>
			<?php }?>
		</TR>
		<TR>
		    <TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
			<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
		</TR>
		</TABLE>
			
	<?php }else{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>News Preview</title>
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
		
		var title=window.opener.document.adminForm.mytitle.value;
		var introtext= window.opener.document.adminForm.introtext.value;
		var fultext= window.opener.document.adminForm.fultext.value;
		
		var image = window.opener.document.imagelib.src;
		
		var myregexp = /SRC=images/g;
		var myregexp2 = /src=images/g;
		var myregexp3 = /SRC="images/g;
		var myregexp4 = /src="images/g;
		
		fultext = fultext.replace('#', '');
		introtext = introtext.replace('#', '');
		fultext = fultext.replace(myregexp, 'SRC=../../images');
		introtext = introtext.replace(myregexp, 'SRC=../../images');
		fultext = fultext.replace(myregexp2, 'src=../../images');
		introtext = introtext.replace(myregexp2, 'src=../../images');
		fultext = fultext.replace(myregexp3, 'SRC=\"../../images');
		introtext = introtext.replace(myregexp3, 'SRC=\"../../images');
		fultext = fultext.replace(myregexp4, 'src=\"../../images');
		introtext = introtext.replace(myregexp4, 'src=\"../../images');
		
	</SCRIPT>
</head>

<body bgcolor="#FFFFFF">
	<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
	<TR>
	    <TD CLASS="componentHeading" COLSPAN="2"><SCRIPT>document.write(title);</SCRIPT></TD>
		
	</TR>
	<TR>
	<?php if ($image !=""){?>
		<SCRIPT>document.write(" <TD VALIGN='top' HEIGHT='90%' COLSPAN='2'> <IMG SRC='" + image +"' VSPACE=5 ALIGN='<?php echo $position;?>'>" + introtext + " " + fultext + "</TD>");</SCRIPT>
	<?php }else {?>
		<SCRIPT>document.write("<TD VALIGN='top' HEIGHT='90%' COLSPAN='2'>" + introtext + " " + fultext + "</TD>");</SCRIPT>
	<?php }?>
	
	
	</TR>
	<TR>
	    <TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
		<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
	</TR>
	</TABLE>
<?php }?>
</body>
</html>