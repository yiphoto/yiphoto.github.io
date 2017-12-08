<?php 
/** Mambo Open Source Version 4.0.12
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
*	File Name: newswindow.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 07-02-2003
* 	Version #: 4.0.12
*	Comments: Displays the full story in a pop up window along with the image.
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
include('../language/'.$lang.'/lang_news.php');
include_once ("../includes/accesscheck.php");
$gid = checkaccess($HTTP_COOKIE_VARS["usercookie"], $db, $dbprefix);

$not_auth = _NOT_VALID2;

$query = "SELECT title, introtext, fultext, newsimage, ".$dbprefix."stories.image_position FROM ".$dbprefix."stories, ".$dbprefix."categories WHERE sid=$id AND ".$dbprefix."stories.access<=$gid AND ". $dbprefix."categories.access <=$gid";
$result = openConnectionWithReturn($query);
$count = mysql_num_rows($result);
if ($count==0){
	echo $not_auth;
	exit;
}
while ($row = mysql_fetch_object($result)){
	$sid = $row->sid;
	$title = $row->title;
	$introtext = $row->introtext;
	$fultext = $row->fultext;
	$image = $row->newsimage;
	$position = $row->image_position;
}

$query = "UPDATE ".$dbprefix."stories SET counter=counter+1 WHERE sid=$id";
openConnectionNoReturn($query);

$pat= "SRC=images";
$replace= "SRC=../images";
$introtext=eregi_replace($pat, $replace, $introtext);
$fultext=eregi_replace($pat, $replace, $fultext);

?>
		<html>
		<head>
		<title>News Preview</title>
		<?php 
$query1 = "SELECT cur_theme FROM ".$dbprefix."system";
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
	    	<TD CLASS="articlehead" WIDTH="90%"><?php echo $title;?></TD>
			<TD><A HREF="#" onClick="window.print(); return false");"><IMG SRC="../images/printButton.gif" BORDER='0' ALT='Print'></A></TD>
		<TD><A HREF="#" onClick="window.open('../emailfriend/emailnews.php?id=<?php echo $id; ?>', 'win2', 'status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=yes,width=350,height=200,directories=no,location=no');"><IMG SRC="../images/emailButton.gif" BORDER='0' ALT='E-mail'></A></TD>
		</TR>
		<TR>
			<?php if ($image !=""){?>
				<TD VALIGN="top" HEIGHT="90%" COLSPAN="3"> <IMG SRC="../images/stories/<?php echo $image;?>" VSPACE=5 ALIGN="<?php echo $position;?>"><?php echo "$introtext $fultext";?></TD>
			<?php }else {?>
				<TD VALIGN="top" HEIGHT="90%" COLSPAN="3"><?php echo "$introtext $fultext";?></TD>
			<?php }?>
		</TR>
		<TR>
		    <TD ALIGN='center' COLSPAN="3"><A HREF="#" onClick="window.close()"><?php echo _CLOSE; ?></A></TD>
		</TR>
		</TABLE>
			
</body>
</html>