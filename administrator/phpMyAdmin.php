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
*	File Name: phpMyAdmin.php
*
*	Date: 04-03-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");
if ($phpmyadmin!='') { ?>
	<TABLE BGCOLOR=#FFFFFF WIDTH=350 BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
	<TR><TD ALIGN=CENTER>
	Click <a href='#' onClick="javascript:window.open('<?php echo $phpmyadmin; ?>');">here</a> to launch phpMyAdmin
	<P>
	</TD></TR></TABLE>
<?php } else { ?>
	<TABLE BGCOLOR=#FFFFFF WIDTH=500 BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
	<TR><TD ALIGN=CENTER>
	<img src='../images/admin/warning.gif'><br>
	<b>:: phpMyAdmin not installed or configured incorrectly ::</b>
	<br><br>
	phpMyAdmin is not installed or not configured in configuration.php!
	<br>Please edit your configuration.php file and enter a valid URL for phpMyAdmin.
	</TD></TR></TABLE>
<?php } ?>
