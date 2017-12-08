<?php
/**
*       Mambo Open Source Version 4.0.12
*       Dynamic portal server and Content managment engine
*       20-01-2003
*
*       Copyright (C) 2000 - 2003 Miro International Pty. Limited
*       Distributed under the terms of the GNU General Public License
*       This software may be used without warranty provided these statements are left
*       intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*       This code is Available at http://sourceforge.net/projects/mambo
*
*       Site Name: Mambo Open Source Version 4.0.12
*       File Name: global_checkin.php
*	Developer : Robert Castley
*       Date: 20-01-2003
*       Version #: 4.0.12
*       Comments: Allows for global checkin of items in a checked out state
**/
require_once("includes/auth.php");

$lt=mysql_list_tables($db);
while (list($tn) = mysql_fetch_array($lt))
{
	$lf = mysql_list_fields($db, "$tn");
	$nf = mysql_num_fields($lf);
	for ($i = 0; $i < $nf; $i++)
	{
		if (mysql_field_name($lf, $i) == "checked_out")
		{
			$query = "UPDATE $tn SET checked_out=0, checked_out_time='00:00:00',
editor=NULL";
			$database->openConnectionNoReturn($query);
		}
	}
}
print "Checked Out items now Checked In<BR><BR>";
?>