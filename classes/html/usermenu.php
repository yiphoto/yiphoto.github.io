<?php 
/**
*	Mambo Open Source Version 4.0.12 
*	Dynamic portal server and Content managment engine
*	27-11-2002
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12 
*	File Name: weblinks.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 27-11-2002
* 	Version #: 4.0.12 
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_usermenu.php');

CLASS HTML_usermenu {
	function showMenuComponent($uName, $uid, $id, $name, $link, $option){?>
		<TABLE>
			<TR>
				<TD class=componentHeading><?php echo _UMENU_TITLE; ?></TD>
			</TR>
			<TR>
				<TD><?php echo _HI; ?> <?php echo $uName;?></TD>
			</TR>
			<?php $numItems=count($id);
				for ($i=0; $i < $numItems; $i++){
					if (trim($name[$i])!=""){?>
						<TR>
							<TD><LI><A HREF=<?php echo $link[$i];?>><?php echo $name[$i];?></A></TD>
						</TR>
					<?php }
				}?>
		</TABLE>
	<?php }
}?>
