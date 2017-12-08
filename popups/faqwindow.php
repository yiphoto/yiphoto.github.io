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
*	File Name: faqwindow.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 07-02-2003
* 	Version #: 4.0.12
*	Comments: Displays faq title and content in popup window.
**/

include ('../regglobals.php');
function database(){
	include ("../configuration.php");
	$link=mysql_connect($host, $user, $password);
	mysql_select_db($db) or die("Query failed with error: ".mysql_error());
}

function openConnectionWithReturn($query){
	$result=mysql_query($query) or die("Query failed with error: ".mysql_error());
	return $result;
}

function openConnectionNoReturn($query){
	mysql_query($query) or die("Query failed with error: ".mysql_error());
}

database();

include ("../configuration.php");
include('../language/'.$lang.'/lang_faq.php');
include_once ("../includes/accesscheck.php");
$gid = checkaccess($HTTP_COOKIE_VARS["usercookie"], $db, $dbprefix);
$not_auth = _NOT_VALID2;
$query = "SELECT title, content FROM ".$dbprefix."faqcont, ".$dbprefix."categories WHERE artid='$id' and ".$dbprefix."faqcont.published=1  AND ". $dbprefix."categories.access <=$gid";
$result = openConnectionWithReturn($query);
$count = mysql_num_rows($result);
if ($count==0){
	echo $not_auth;
	exit;
}
while ($row = mysql_fetch_object($result)){
	$title = $row->title;
	$content = $row->content;
}
mysql_free_result($result);

$query = "UPDATE ".$dbprefix."faqcont SET counter=counter+1 WHERE artid=$id";
openConnectionNoReturn($query);

$pat= "SRC=images";
$replace= "SRC=../images";

$pat2= "SRC=\"images";
$replace2= "SRC=\"../images";

$content=eregi_replace($pat, $replace, $content);
$content=eregi_replace($pat2, $replace2, $content);
?>
		<html>
		<head>
			<title>FAQ - <?php echo $title;?></title>
			<?php $query1 = "SELECT cur_theme FROM ".$dbprefix."system";
			  $result1 = openConnectionWithReturn($query1);
				while ($row1 = mysql_fetch_object($result1)){
			  			 $themecss = $row1->cur_theme;
							 }?>
			
		<link rel="stylesheet" href="../css/ie5.css" type="text/css">
		<link rel="stylesheet" href="../css/theme_<?php echo $themecss;?>.css" type="text/css">
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
			<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%" class="popupwindow">
			<TR>
	    		<TD CLASS="articlehead" COLSPAN="2" width=90%><?php echo $title;?></TD>
				<TD><A HREF="#" onClick="window.print(); return false");"><IMG SRC="../images/printButton.gif" BORDER='0' ALT='Print'></A></TD>
				<TD><A HREF="#" onClick="window.open('../emailfriend/emailfaq.php?id=<?php echo $id; ?>', 'win2', 'status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=yes,width=350,height=200,directories=no,location=no');"><IMG SRC="../images/emailButton.gif" BORDER='0' ALT='E-mail'></A></TD>
			</TR>
			<TR>
	    		<TD VALIGN="top" HEIGHT="90%" COLSPAN="4"><?php echo $content;?></TD>
			</TR>
			<TR>
	    		<TD ALIGN="center" COLSPAN=4 ><A HREF="#" onClick="window.close()"><?php echo _CLOSE; ?></A></TD>
			</TR>
			</TABLE>
		</body>
		</html>