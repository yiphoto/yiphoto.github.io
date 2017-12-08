<?php
/**
*	Mambo Open Source Version 4.0.13
*	Dynamic portal server and Content managment engine
*	07-05-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.13
*	File Name: index2.php
*	Original Developers: Danny Younes - danny@miro.com.au
*                        Nicole Anderson - nicole@miro.com.au
*	Date: 07-05-2003
*	Version #: 4.0.13
*	Comments:
**/

include("../configuration.php");
include ("../regglobals.php");
require ("classes/database.php");
$database = new database();

session_start();

if (isset($_SESSION['admin_session_id']) && $_SESSION['admin_session_id']==md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime'])){
	$query = "SELECT * FROM ".$dbprefix."session WHERE session_id='".$_SESSION['admin_session_id']."' AND (usertype='administrator' OR usertype='superadministrator')";
	$result2 = $database->openConnectionWithReturn($query);
	if (mysql_num_rows($result2) <> 1){
		print "<SCRIPT>document.location.href='index.php'</SCRIPT>\n";
		exit();
	}
} else {
	print "<SCRIPT>document.location.href='index.php'</SCRIPT>\n";
	exit();
}

$current_time = time();
$query = "UPDATE ".$dbprefix."session SET time='$current_time' WHERE session_id='".$_SESSION['admin_session_id']."'";
$database->openConnectionNoReturn($query);
$past = time()-1800;
$query = "DELETE FROM ".$dbprefix."session WHERE time < $past";
$database->openConnectionNoReturn($query);

if (($option == "databaseAdmin") && ($task == "doBackup") && ($OutDest == "remote")) {
	include ("databaseAdmin.php");
	exit();
}
?>
<html>
  <head>
    <meta content=
    "HTML Tidy for Linux/x86 (vers 1st December 2002), see www.w3.org"
          name="generator">
    <title>
      Mambo Open Source - Administration
    </title>
    <LINK REL="Bookmark" HREF="../images/favicon.ico">
    <link REL="SHORTCUT ICON" HREF="../images/favicon.ico">
    <link rel="stylesheet" href="../css/admin.css" type="text/css">
    <script language="JavaScript1.2" src="js/rollover.js"
          type="text/javascript">
    </script>
    <script language="javascript" src="js/adminjavascript.js"
          type="text/javascript">
    </script>
  </head>
  <body leftmargin="0" rightmargin="0" topmargin="0">
    <?php
//if (($task != "AddStep2") && ($task != "AddStep3") && ($task !="reply")) {
{
	?>
    <script type='text/javascript'>
    //HV Menu v5- by Ger Versluis (http://www.burmees.nl/)
    //Submitted to Dynamic Drive (http://www.dynamicdrive.com)
    //Visit http://www.dynamicdrive.com for this script and more
    function Go(){return}
    </script>
    <script type='text/javascript' src='js/mambomenu_var.js'>
    </script>
    <script type='text/javascript' src='js/menu9_com.js'>
    </script>
    <noscript>Your browser does not support script</noscript>
    <?php }
    include("menubar.php");
    include ("../configuration.php");
    if (phpversion() <= "4.2.1") {
    	$browse = getenv("HTTP_USER_AGENT");
    } else {
    	$browse = $_SERVER['HTTP_USER_AGENT'];
    }
    
    if (preg_match("/MSIE/i", "$browse")){
    	if (preg_match("/Mac/i", $browse)){
    		$text_editor = false;
    	}
    	elseif (preg_match("/Windows/i", $browse)){
    		$text_editor = true;
    	}
    } elseif (preg_match("/Mozilla/i", "$browse")){
    	if (preg_match("/Mac/i", $browse)){
    		$text_editor = false;
    	} elseif (preg_match("/Windows/i", $browse)){
    		$text_editor = false;
    	}
    }
    ?>
    
<table width="98%" border="0" align=
    "center" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="middle" align="center"> 
      <?php
    /* Show list of items to edit or delete or create new */
    switch ($option){
    	case "Components":
    	include("components.php");
    	break;
    	case "News":
    	if ($act == "categories"){
    		include("category.php");
    	} else {
    		include("news.php");
    	}
    	break;
    	case "Articles":
    	if ($act == "categories"){
    		include("category.php");
    	} else {
    		include("articles.php");
    	}
    	break;
    	case "Faq":
    	if ($act == "categories"){
    		include("category.php");
    	} else {
    		include("faq.php");
    	}
    	break;
    	case "Newsflash":
    	include("newsflash.php");
    	break;
    	case "Survey":
    	include("survey.php");
    	break;
    	case "Weblinks":
    	if ($act == "categories"){
    		include("category.php");
    	} else {
    		include("weblinks.php");
    	}
    	break;
    	case "top10":
    	include("top10.php");
    	break;
    	case "Current":
    	$section="Current";
    	include("banners_current.php");
    	break;
    	case "Finished":
    	$section="Finished";
    	include("banners_finished.php");
    	break;
    	case "Clients":
    	include("bannerClient.php");
    	break;
    	case "Users":
    	include("users.php");
    	break;
    	case "Administrators":
    	include("../configuration.php");
    	include("administrators.php");
    	break;
    	case "MenuSections":
    	include("menusections.php");
    	break;
    	case "SubSections":
    	include("subsections.php");
    	break;
    	case "newsfeeds":
    	include("newsfeeds.php");
    	break;
    	case "logout";
    	include("logout.php");
    	break;
    	case "statistics":
    	include("statistics.php");
    	break;
    	case "contact":
    	include ("contact.php");
    	break;
    	case "systemInfo":
    	include ("systemInfo.php");
    	break;
    	case "global_checkin":
    	include ("global_checkin.php");
    	break;
    	case "phpMyAdmin":
    	include ("phpMyAdmin.php");
    	break;
    	case "about":
    	include ("about.php");
    	break;
    	case "module_installer":
    	include ("module_installer.php");
    	break;
    	case "component_installer":
    	include ("component_installer.php");
    	break;
    	case "Forums":
    	if ($act == "threads"){
    		include("threads.php");
    	}else {
    		include("forums.php");
    	}
    	break;
    	case "databaseAdmin":
    	include ("databaseAdmin.php");
    	break;
    	default:
 //   	print "<img src='../images/admin/admin2.jpg' width=134 height=105 border=1>&nbsp;";
   // 	print "<img src='../images/admin/admin3.jpg' width=134 height=105 border=1>&nbsp;";
//    	print "<img src='../images/admin/admin.jpg' wdith=134 height=105 border=1><br>";
	print "<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><img src='../images/admin/shansoft.JPG' border=1><br>";
    	
    }
          ?>
    </TD>
  </TR>
</TABLE>
</BODY>
</HTML>
