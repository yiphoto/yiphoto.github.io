<?php
/**
*	Mambo Site Server Open Source Edition Version 4.0.12
*	Dynamic portal server and Content managment engine
*
*	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Site Server Open Source Edition Version 4.0.12
*	File Name: auth.php
*	Date: 10-12-2002
* 	Version #: 4.0.12
*	Comments:
**/

require_once ("../regglobals.php");
if (!eregi("./index2\.php?", $_SERVER['PHP_SELF'])) {
	print "<SCRIPT>document.location.href='index.php'</SCRIPT>\n";
	exit();
}

session_start();
if ((!isset($_SESSION['admin_session_id'])) || ($_SESSION['admin_session_id']!=md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime']))) {
        print "<script>document.location.href='index.php'</script>";
        exit();
}

?>