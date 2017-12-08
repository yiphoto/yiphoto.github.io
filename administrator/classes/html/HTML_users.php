<?php 
/**
*	Mambo Open Source Version 4.0
*	Dynamic portal server and Content managment engine
*	17-11-2002
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0
*	File Name: HTML_users.php.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*				Emir Sakic - saka@hotmail.com
*	Date: 17/11/2002
* 	Version #: 4.0
*	Comments:
**/

class HTML_users {
		function showUsers($option, $uid, $GNameSel, $name, $username, $email, $block, $count, $offset, $rows_per_page){ ?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<?php echo $action;
				echo $pages;?>
				<TD colspan="6" CLASS="boxheading">Registered Users</TD>
				</tr><tr BGCOLOR="#999999">
				<TD CLASS="heading">&nbsp;</TD>
				<TD CLASS="heading">Name</TD>
				<TD CLASS="heading">UserID</TD>
				<TD CLASS="heading">Group</TD>
				<TD CLASS="heading">E-Mail</TD>
				<TD CLASS="heading">Blocked</TD>
			</TR>
			<?php 
		$color = array("#FFFFFF", "#CCCCCC");
		$k = 0;
			for ($i = 0; $i < count($uid); $i++){?>
			<TR BGCOLOR="<?php echo $color[$k]; ?>">
				<TD WIDTH="5"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<?php echo $uid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<TD WIDTH="20%"><?php echo $name[$i]; ?></td>
				<TD WIDTH="20%"><?php echo $username[$i]; ?></td>

				<TD WIDTH="20%"><?php echo $GNameSel[$i]; ?></td>

				<TD WIDTH="20%"><a href="mailto:<?php echo "$email[$i]"; ?>"><?php echo "$email[$i]"; ?></a></TD>
				<?php 	if ($block[$i] == "1"){
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
				<?php 		} else {?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
				<?php 			}
				}
				else {
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?php 		} else {?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?php 			}
				}
				if ($k == 1){
					$k = 0;
				}
				else {
					$k++;
						}?>
				<?php 
				}?>
			</TR>
			<TR BGCOLOR="#999999">
				<TD COLSPAN="6" ALIGN="center" CLASS="heading" WIDTH="100%"><?php 

				// By Emir Sakic <saka@hotmail.com>

				$pages_in_list = 10;				// set how many pages you want displayed in the menu

				// Calculate # of pages
				$pages = ceil($count / $rows_per_page);
				$from = ($offset-1) * $rows_per_page;

				$poffset = floor(($offset-1)/10);
				$from = $poffset*10;
				if (empty($prev)) $prev = 0;

				if ($poffset>0) {
					$prev = $poffset-1;
					$prev_offset = (($poffset-1)*10)+1;
					print "<a href=\"$PHP_SELF?option=Users&offset=1\" title=\"first list\"><b><<</b></a> \n";
					print "<a href=\"$PHP_SELF?option=Users&offset=$prev_offset\" title=\"previous list\"><b><</b></a> \n";
				}

				for ($i = $from+1; $i <= $from+$pages_in_list; $i++) {
					if (($i-1)<$pages) {
						$poffset = floor(($i-1)/10); //round down
						if ($i == $offset) {
							print "<b>$i</b> ";
						} else {
							print "<a href=\"$PHP_SELF?option=Users&offset=$i\" title=\"page $i\"><b>$i</b></a> ";
						}
					}
				}

				if (($i-1)<$pages) {
					$next = $poffset+1;
					$next_offset = $i;
					print " <a href=\"$PHP_SELF?option=Users&offset=$next_offset\" title=\"next list\"><b>></b></a>\n";
					$max_poffset = floor($pages/$pages_in_list-0.1);
					$max_offset = $max_poffset*$pages_in_list + 1;
					print " <a href=\"$PHP_SELF?option=Users&offset=$max_offset\" title=\"final list\"><b>>></b></a>";
				}

				//Loop:
				$i = $count+($offset-1)*$rows_per_page;

				?></TD>
			</TR>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<?php echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
		<?php 	}

		function edituser($option, $uid, $username, $name, $email, $block, $gidsel, $gid, $gname){?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%" BGCOLOR="#FFFFFF">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="boxheading">Edit User</TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Name:</TD>
				<TD WIDTH='90%'><?php echo $name; ?></TD>
			</TR>
			<TR>
				<TD>Username:</TD>
				<TD><?php echo $username; ?></TD>
			<TR>
				<TD>Email:</TD>
				<TD><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></TD>
			</TR>

			<TR><TD VALIGN="top">Group:</TD>
			<TD>
			<SELECT class="inputbox" NAME='ugid' SIZE='1'>
			<?php 
		for ($a = 0;$a < count($gid); $a++){
			if ($a == $gidsel[0]) {
				echo"<OPTION VALUE=".$gid[$a]." SELECTED>".$gname[$a];
			}
			else {
				echo"<OPTION VALUE=".$gid[$a].">".$gname[$a];
			}
		}
			?>
			</select>

			</TD></TR>

			<TR>
				<TD></TD>
			<?php if ($block == 1){?>
					<TD><INPUT TYPE="checkbox" NAME="block" VALUE="true" CHECKED>Block User</TD>
			<?php 		}
			   else {?>
			   		<TD><INPUT TYPE="checkbox" NAME="block" VALUE="true">Block User</TD>
			<?php 		}?>
			</TR>
			<TR>

				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR BGCOLOR=#999999>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='option' VALUE="<?php echo $option; ?>">
			<INPUT TYPE='hidden' NAME='uid' VALUE="<?php echo $uid; ?>">
			<INPUT TYPE='hidden' NAME='pname' VALUE="<?php echo $name; ?>">
			<INPUT TYPE='hidden' NAME='pemail' VALUE="<?php echo $email; ?>">
			<INPUT TYPE='hidden' NAME='puname' VALUE="<?php echo $username; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
		<?php 	}

		function newuser($option){ ?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%" BGCOLOR="#FFFFFF">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="boxheading">Add New User</TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Name:</TD>
				<TD WIDTH='90%'><INPUT class='inputbox' TYPE='text' NAME='realname' SIZE='25'></TD>
			</TR>
			<TR>
				<TD>Email:</TD>
				<TD><INPUT class='inputbox' TYPE='text' NAME='email' SIZE='25'></TD>
			</TR>
			<TR>
				<TD>Username:</TD>
				<TD><INPUT class='inputbox' TYPE='text' NAME='username' SIZE='25'></TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR BGCOLOR=#999999>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='option' VALUE="<?php echo $option; ?>">
			</FORM>
		<?php 	}
}
?>
