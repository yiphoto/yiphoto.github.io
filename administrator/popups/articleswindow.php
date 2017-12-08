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
*	File Name: articleswindow.php
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

include ("../../configuration.php");
$connection=mysql_connect($host, $user, $password);
mysql_select_db($db,$connection) or die("Query failed with error:".mysql_error());

if ($print == "print"){
	$query = "SELECT title, content FROM ".$dbprefix."articles WHERE artid=$id";
	$result=mysql_query($query) or die("Query failed with error:".mysql_error()); 
	while ($row = mysql_fetch_object($result)){
		$title = $row->title;
		$content = $row->content;
	}
	$pat= "SRC=images";
	$replace= "SRC=../../images";
	$content=eregi_replace($pat, $replace, $content);
	
	$pat2="\\\\'";
	$replace2="'";
	$content=eregi_replace($pat2, $replace2, $content);
	$title=eregi_replace($pat2, $replace2, $title);
	$author=eregi_replace($pat2, $replace2, $author);
	
	
	$pat3="SRC=\"images";
	$replace3= "SRC=\"../../images";
	$content=eregi_replace($pat3, $replace3, $content);
	
		?>
		
		<html>
		<head>
		<title>Article Preview</title>
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
		<?php if ($author != ""){?>
				<TR><TD CLASS="small" COLSPAN="2">By <?php echo $author;?></TD></TR>
		<?php }?>
		<TR>
	    	<TD VALIGN="top" HEIGHT="90%" COLSPAN="2"><?php echo $content;?></TD>
		</TR>
		<TR>
	  	  	<TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
			<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
		</TR>
		</TABLE>
	
	<?php }else{?>
		<html>
		<head>
		<title>Article Preview</title>
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
		<!--
		var contents = window.opener.document.adminForm.content.value;
		contents = contents.replace('#', '');
		
		var author = window.opener.document.adminForm.author.value;
		author = author.replace('#', '');
		
		var titles = window.opener.document.adminForm.mytitle.value; 
		titles = titles.replace('#', '');
		
		var myregexp = /SRC=images/g;
		var myregexp2 = /src=images/g;
		var myregexp3 = /SRC="images/g;
		var myregexp4 = /src="images/g;
		
		contents = contents.replace('#', '');
		titles = titles.replace('#', '');
		contents=contents.replace(myregexp, 'SRC=../../images');
		contents= contents.replace(myregexp2, 'src=../../images');
		contents= contents.replace(myregexp3, 'SRC=\"../../images');
		contents= contents.replace(myregexp4, 'src=\"../../images');
		contents = contents.replace('\\\\', '');
		titles = titles.replace('\\\\', '');
		//-->
		</SCRIPT>

		</head>

		<body BGCOLOR="#FFFFFF">
		<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
		<TR>
	    	<TD CLASS="componentHeading" COLSPAN="2"><SCRIPT>document.write(titles);</SCRIPT></TD>
		</TR>
		<SCRIPT>
			if (author != ""){
				document.write("<TR><TD CLASS='small' COLSPAN='2'>By " + author + "</TD></TR>");
				}
		</SCRIPT>
		<TR>
	    	<TD VALIGN='top' HEIGHT='90%' COLSPAN="2"><SCRIPT>document.write(contents);</SCRIPT></TD>
		</TR>
		<TR>
	  	  	<TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
			<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
		</TR>
		</TABLE>
<?php }?>
</body>
</html>
