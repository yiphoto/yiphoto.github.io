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
*       File Name: HTML_systemInfo.php
*       Date: 20-01-2003
*       Version #: 4.0.12
*       Comments:
**/
class HTML_systemInfo {
		function showsystemInfo($sitename, $cur_theme, $col_main){?>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="2" BGCOLOR="#FFFFFF" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD COLSPAN="4" CLASS="boxheading" HEIGHT="20">Theme Manager</TD>
			</TR>
			<TR>
				<TD COLSPAN="4" CLASS="heading" HEIGHT="20">&nbsp;</TD>
			</TR>
			<TR>
                <TD valign="top">Theme Preview:</TD>
                <TD WIDTH="710">
                
                             <IMG border="1" SRC='../images/themes/<?php echo $cur_theme.".jpg"; ?>' NAME='imagelib'>
                           </TD>
                        </TR>
                        <TR>
                            <TD>&nbsp;</TD>
                        </TR>
                        <TR>
		<?php 
		if ($handle=opendir("../themes/")){
			$i=0;
			while (false !==($file = readdir($handle))) {
				if (!strcasecmp(substr($file,-4),".php") && $file != "." && $file != ".."
				&& $file !="footer.php"
				&& $file !="header.php"
				&& $file !="mainbody.php"
				&& $file !="site_search.php"){
					$nfile = substr($file,0,-4);
					$theme_name[$i]=$nfile;
					$i++;
				}
			}
		}
?>
                           <TD WIDTH="125">Select Theme:</TD>
                           <TD width="710">
                              <SELECT class="inputbox" NAME='cur_theme' onChange="document.forms[0].imagelib.src='../images/themes/' + document.forms[0].cur_theme.options[selectedIndex].value + '.jpg'">
                                 <?php 
$i = 0;
for ($i = 0; $i < count($theme_name); $i++){
                              if ($theme_name[$i] == $cur_theme){?>
                                         <OPTION VALUE='<?php echo $theme_name[$i]; ?>' SELECTED><?php echo $theme_name[$i]; ?></OPTION>
                               <?php } else {?>
                                         <OPTION VALUE='<?php echo $theme_name[$i]; ?>'><?php echo $theme_name[$i]; ?></OPTION>
                               <?php }
                                     }?>
                              </SELECT>
                         </TD>
			</TR>
			<TR>
			 <TD>&nbsp;</TD>
			</TR>
			<TR>
				<TD>No. of Columns:</TD>
			<?php 	if ($col_main == "1"){ ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="col_main" VALUE="1" CHECKED>1&nbsp;&nbsp;<INPUT TYPE="radio" NAME="col_main" VALUE="2">2</TD>
			<?php 	} else { ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="col_main" VALUE="1">1&nbsp;&nbsp;<INPUT TYPE="radio" NAME="col_main" VALUE="2" CHECKED>2</TD>
			<?php 	} ?>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="4" HEIGHT="20">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="4" HEIGHT="20">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="option" VALUE="systemInfo">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
		<?php }
}
?>
