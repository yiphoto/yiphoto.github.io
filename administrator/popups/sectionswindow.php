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
*	File Name: sectionswindow.php
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

?>
<html>
<head>
	<title>Sections Preview</title>
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

<body>
	<?php 
	if ($type=="typed"){?>
		<SCRIPT>
			var myregexp = /SRC=images/g;
			var myregexp2 = /src=images/g;
			var myregexp3 = /SRC="images/g;
			var myregexp4 = /src="images/g;
			
			var content=window.opener.document.adminForm.pagecontent.value;
			var heading=window.opener.document.adminForm.heading.value;
			content = content.replace('\\\\', '');
			content= content.replace(myregexp, 'SRC=../../images');
			content= content.replace(myregexp2, 'src=../../images');
			content= content.replace(myregexp3, 'SRC=\"../../images');
			content= content.replace(myregexp4, 'src=\"../../images');
		</SCRIPT>
		<?php 
	}else if ($type=="file"){?>
		<SCRIPT>
			var content=window.opener.document.adminForm.filecontent.value;
			content = content.replace('\\\\', '');
			content = content.replace('SRC=\"uploadfiles', 'SRC=\"../../uploadfiles');
			content = content.replace('SRC=uploadfiles', 'SRC=../../uploadfiles');
			content = content.replace('src=\"uploadfiles', 'src=\"../../uploadfiles');
			content = content.replace('src=uploadfiles', 'src=../../uploadfiles');
			var heading='';
		</SCRIPT>
	
		<?php }?>
	<SCRIPT>
		if (content!=""){
			document.write ("<TABLE ALIGN='center' WIDTH='90%' CELLSPACING='2' CELLPADDING='2' BORDER='0' HEIGHT='100%'>");
			if (heading!=""){
				document.write ("<TR><TD class=articlehead>" + heading + "</TD></TR>");
			}
			document.write ("<TR><TD VALIGN='top' HEIGHT='90%'>" + content + "</TD></TR>");
			document.write ("<TR><TD ALIGN='center'><A HREF='#' onClick=window.close()>Close</A></TD></TR></TABLE>");
		}
	</SCRIPT>
	
	<?php 
	if ($type=="web"){
		if ($link!=""){
			$correctLink=eregi("http://", $link);
			if ($correctLink){
				echo "<SCRIPT>document.location.href='$link';</SCRIPT>";
			}else{
				echo "<SCRIPT>document.location.href='http://$link';</SCRIPT>";
			}
		}
		}?>
</body>
</html>