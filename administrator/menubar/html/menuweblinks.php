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
*	File Name: menuweblinks.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/

class menusweblinks {
		function NEW_MENU_Weblinks($categories){ ?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD WIDTH="47%" VALIGN="top"><?php include ("menubar/mainmenu.php"); ?></TD>
				<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
				<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
					<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
					<TR>
						<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('savenew', 'weblinks');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Publish" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:document.location.href='index2.php?option=Weblinks&categories=<?php echo $categories; ?>'" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="470">&nbsp;</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD WIDTH="370">&nbsp;</TD>
				<TD VALIGN="bottom" ALIGN="left" BGCOLOR="#999999"><img name="shadow" src="../images/admin/shadow.gif" width="100%" height="10" border="0" VSPACE="0" HSPACE="0"></TD>
			</TR>
			</TABLE>
		<?php 	}
		
		function EDIT_MENU_Weblinks($comcid, $option, $categories, $publish, $approved){ ?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD WIDTH="47%" VALIGN="top"><?php include ("menubar/mainmenu.php"); ?></TD>
				<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
				<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
					<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
					<TR>
						<?php if ($approved==1){
							if ($publish == 0){?>
    							<td width="50" BGCOLOR="#999999" VALIGN="bottom"><a href="javascript:submitbutton('publish', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('publish','','../images/admin/publish_f2.gif',1);"><img name="publish" src="../images/admin/publish.gif" width="32" ALT="Publish" HEIGHT="47" border="0" HSPACE="5" VSPACE="0"></a></td>
							<?php }else {?>
								<td width="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><a href="javascript:submitbutton('unpublish', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('Unpublish','','../images/admin/Unpublish_f2.gif',1);"><img name="Unpublish" src="../images/admin/Unpublish.gif" width="45" ALT="Unpublish" HEIGHT="47" border="0" HSPACE="5" VSPACE="0"></a></td>
							<?php }
						}else{?>
							<td width="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><a href="javascript:submitbutton('approve', 'weblinks');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('approve','','../images/admin/approve_f2.gif',1);" ><img name="approve" src="../images/admin/approve.gif" width="38" ALT="Approve" HEIGHT="47" border="0" HSPACE="5" VSPACE="0"></a></td>
							<TD WIDTH="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><A HREF="javascript:if (confirm('Are you sure you want to delete this weblink?')){ submitbutton('remove');}" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('delete','','../images/admin/delete_f2.gif',1);"><IMG SRC="../images/admin/delete.gif" ALT="Delete" WIDTH="34" HEIGHT="47" BORDER="0" NAME="delete" HSPACE="5" VSPACE="0"></TD>
						<?php }?>
						<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('saveedit', 'weblinks');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Publish" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:document.location.href='menubar/cancel.php?id=<?php echo $comcid; ?>&option=<?php echo $option; ?>&categories=<?php echo $categories; ?>'" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="470">&nbsp;</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD WIDTH="370">&nbsp;</TD>
				<TD VALIGN="bottom" ALIGN="left" BGCOLOR="#999999"><img name="shadow" src="../images/admin/shadow.gif" width="100%" height="10" border="0" VSPACE="0" HSPACE="0"></TD>
			</TR>
			</TABLE>
		<?php 	}
}
?>
