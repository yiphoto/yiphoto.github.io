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
*	File Name: articleswindow.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
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

if ($id <> ""){
	if ($option == "News"){
		$query = "SELECT * FROM ".$dbprefix."stories WHERE catid=$id";
	}
	elseif ($option == "Faq"){
		$query = "SELECT * FROM ".$dbprefix."faqcont WHERE catid=$id and published=1";
	}
	elseif ($option == "Articles"){
		$query = "SELECT * FROM ".$dbprefix."articles WHERE catid=$id";
	}
	elseif ($option == "Weblinks"){
		$query = "SELECT * FROM ".$dbprefix."links WHERE catid=$id";
	}
	
	$result=mysql_query($query) or die("Query failed with error:".mysql_error()); 
	$i = 0;
	while ($row = mysql_fetch_object($result)){
		$title[$i] = $row->title;
		$i++;
		$pat="\\\\'";
		$replace="'";
		$title[$i]=eregi_replace($pat, $replace, $title[$i]);
	}
	mysql_free_result($result);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Category Preview</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
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
<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0" WIDTH="100%" HEIGHT="100%">
<?php if ($position == "left"){ ?>
	<TR>
    <?php 	if ($categoryimage <> ""){
    	$pat="\\\\'";
    	$replace="'";
			$categoryname=eregi_replace($pat, $replace, $categoryname);?>
			<TD ROWSPAN="2" VALIGN="top"><IMG SRC="../../images/stories/<?php echo $categoryimage; ?>" HSPACE="5"></TD>
	<?php 		}?>
	    <TD VALIGN="top"><B><?php echo $categoryname; ?></B></TD>
	</TR>
<?php 	} 
   else { ?>
	<TR>
	    <TD VALIGN="top"><B><?php echo $categoryname; ?></B></TD>
	<?php 	if ($categoryimage <> ""){?>
			<TD ROWSPAN="2" VALIGN="top"><IMG SRC="../../images/stories/<?php echo $categoryimage; ?>" HSPACE="5"></TD>
	<?php 		}?>
	</TR>
<?php 	} ?>

<?php if ($position == "left"){
	if (count($title) == 0){?>
		<TR>
		    <TD COLSPAN="2" WIDTH="100%" HEIGHT="100%" VALIGN="top">
				There are no <?php echo $option; ?>.
			</TD>
		</TR>
		
	<?php }else {?>
		<TR>
			<TD VALIGN="top">
				<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
				 <?php for ($i = 0; $i < count($title); $i++){?>
			 	<TR>
			 		<TD><LI></TD>
					<TD>
				  <?php echo $title[$i]."<BR>"; 
				  }?>
					</TD>
				</TR>
				</TABLE>
			</TD>
			<TD>&nbsp;</TD>
		</TR>
			 <?php }?>
			  		
				
<?php 	} 
elseif ($position == "right") {
  	if (count($title) == 0){?>
		<TR>
		    <TD WIDTH="100%" HEIGHT="100%" VALIGN="top">There are no <?php echo $option; ?>.</TD>
		</TR>
		
		<?php } 
		else {?>
		<TR>
			<TD VALIGN="top" HEIGHT="100%">
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="100%">
				
					
			 <?php for ($i = 0; $i < count($title); $i++){?>
			 	<TR>
			 		<TD><LI></TD>
					<TD>
				  <?php echo $title[$i]."<BR>"; ?>
				  	</TD>
				</TR>
				<?php  }?>
				  	
				</TABLE>
			</TD>
			
		</TR>
			<?php  }?>
<?php 		} ?>
<TR>
	<TD COLSPAN="2"  ALIGN="center"><A HREF="#" onClick="self.close();">Close</A></TD>
</TR>
</TABLE>
</body>
</html>
