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
*	File Name: displaypage.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

class displaycontent {
		function displaypage($id, $content, $heading){?>
			<TABLE CELLPADDING='0' CELLSPACING='5' BORDER='0' WIDTH='100%'>
			<?php if ($heading!=""){?>
				<TR>
					<TD class=articlehead><?php echo $heading;?></TD>
					<TD ALIGN="right"><A HREF="#" onClick="window.open('popups/contentwindow.php?id=<?php echo $id; ?>&print=print', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');"><IMG SRC="images/printButton.gif" BORDER='0' ALT='Print'></A></TD>
					<TD><A HREF="#" onClick="window.open('emailfriend/emailcontent.php?id=<?php echo $id; ?>', 'win2', 'status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=yes,width=350,height=200,directories=no,location=no');"><IMG SRC="images/emailButton.gif" BORDER='0' ALT="E-mail"></A></TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
				</TR>
			<?php }?>
				<TR>
					<TD><?php echo $content;?></TD>
				</TR>
			</TABLE>
	<?php }
}?>