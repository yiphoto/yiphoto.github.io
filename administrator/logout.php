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
*	File Name: logout.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
include ('../regglobals.php');

session_start();
if ((!isset($_SESSION['admin_session_id'])) || ($_SESSION['admin_session_id']!=md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime']))) {
        print "<script> document.location.href='../index.php'</script>";
        exit();
}

include ("../configuration.php");
require ("classes/database.php");
$database = new database();

$query = "DELETE FROM ".$dbprefix."session WHERE session_id='" . $_SESSION['admin_session_id'] . "'";
$database->openConnectionNoReturn($query);

$myname="";
$fullname="";
$userid="";
$admin_session_id = "";

session_unregister("myname");
session_unregister("fullname");
session_unregister("userid");
session_unregister("usertype");
session_unregister("currenttime");
session_unregister("admin_session_id");

if (session_register("myname")){session_destroy();}
if (session_register("fullname")){session_destroy();}
if (session_register("userid")){session_destroy();}
if (session_register("usertype")){session_destroy();}
if (session_register("currenttime")){session_destroy();}
if (session_register("sessionid")){session_destroy();}

print "<SCRIPT>document.location.href='../index.php';</SCRIPT>\n";
?>
