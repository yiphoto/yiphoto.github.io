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
*	File Name: menusubsections.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class menusubsections {
		function NEW_MENU_subsections($option, $sections){ ?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD WIDTH="47%" VALIGN="top"><?php include ("menubar/mainmenu.php"); ?></TD>
				<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
				<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
					<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
					<TR>
						<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:document.location.href='index2.php?option=<?php echo $option; ?>&sections=<?php echo $sections;?>'" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="270">&nbsp;</TD>
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
		
		function EDIT_MENU_subsections($comcid, $option, $database, $dbprefix, $sections){
			if (trim($comcid) ==""){
				print "<SCRIPT> alert('Select a menu item to edit'); window.history.go(-1);</SCRIPT>\n";
			}else{
				$query="select contenttype, inuse from ".$dbprefix."menu where id=$comcid";
				$result=$database->openConnectionWithReturn($query);
				list($type, $published)=mysql_fetch_array($result);?>
				<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
				<TR>
					<TD WIDTH="47%" VALIGN="top"><?php include ("menubar/mainmenu.php"); ?></TD>
					<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
					<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
						<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
						<TR>
							<?php if ($published==0){?>
								<TD WIDTH="50" ALIGN='center'><A HREF="javascript:submitbutton('publish', '');"><IMG SRC="../images/admin/publish.gif" NAME="Publish" ALT="Publish" WIDTH="32" HEIGHT="47" BORDER="0" HSPACE="5" VSPACE="0"></A></TD>
							<?php }else{?>
								<TD WIDTH="50" ALIGN='center'><a href="javascript:submitbutton('unpublish', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('Unpublish','','../images/admin/Unpublish_f2.gif',1);" ><IMG SRC="../images/admin/Unpublish.gif" NAME="Unpublish" ALT="Unpublish" WIDTH="45" HEIGHT="47" BORDER="0"></A></TD>
							<?php }
						  
							  if ($type=="file"){?>
								<TD WIDTH="50" ALIGN='center' BGCOLOR="#999999" VALIGN="bottom"><A HREF="#" onClick="window.open('gallery/gallery.php?directory=uploadfiles&Itemid=<?php echo $comcid;?>', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('uploadPic','','../images/admin/uploadPic_f2.gif',1);"><IMG SRC="../images/admin/uploadPic.gif" ALT="Upload Image" WIDTH="35" HEIGHT="47" BORDER="0" name="uploadPic" HSPACE="5" VSPACE="0"></A></TD>
							<?php }else if ($type=="typed"){?>
								<TD WIDTH="50" ALIGN='center' BGCOLOR="#999999" VALIGN="bottom"><A HREF="#" onClick="window.open('gallery/gallery.php', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('uploadPic','','../images/admin/uploadPic_f2.gif',1);"><IMG SRC="../images/admin/uploadPic.gif" ALT="Upload Image" WIDTH="35" HEIGHT="47" BORDER="0" name="uploadPic" HSPACE="5" VSPACE="0"></A></TD>
							<?php }
							
							if ($type=="file"){?>
								<TD WIDTH="50" ALIGN='center'><A HREF="#" onclick="javascript: window.open('popups/sectionswindow.php?sectionid=<?php echo $comcid;?>&type=<?php echo $type;?>', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" win1.focus(); onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('preview','','../images/admin/preview_f2.gif',1);"><IMG SRC="../images/admin/preview.gif" ALT="Preview" WIDTH="35" HEIGHT="47" BORDER="0" NAME="preview" HSPACE="5" VSPACE="0"></A></TD>
								<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('saveeditLink', 'subsections');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Publish" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="10" VSPACE="0"></A></TD>
							<?php }else if ($type=="typed"){?>
								<TD WIDTH="50" ALIGN='center'><A HREF="#" onclick="javascript: window.open('popups/sectionswindow.php?sectionid=<?php echo $comcid;?>&type=<?php echo $type;?>', 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" win1.focus(); onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('preview','','../images/admin/preview_f2.gif',1);"><IMG SRC="../images/admin/preview.gif" ALT="Preview" WIDTH="35" HEIGHT="47" BORDER="0" NAME="preview" HSPACE="5" VSPACE="0"></A></TD>
								<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('saveeditType', 'subsections');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Publish" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="10" VSPACE="0"></A></TD>
							<?php }else if ($type=="web"){?>
								<TD WIDTH="50" ALIGN='center'><A HREF="#" onclick="javascript:window.open('popups/sectionswindow.php?sectionid=<?php echo $comcid;?>&type=<?php echo $type;?>&link=' + document.adminForm.Weblink.value, 'win1', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('preview','','../images/admin/preview_f2.gif',1);"><IMG SRC="../images/admin/preview.gif" ALT="Preview" WIDTH="35" HEIGHT="47" BORDER="0" NAME="preview" HSPACE="5" VSPACE="0"></A></TD>
								<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('saveeditWeb', 'subsections');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Publish" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="10" VSPACE="0"></A></TD>
							<?php }else if ($type=="mambo"){?>
								<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('saveeditMambo', 'subsections');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Publish" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="10" VSPACE="0"></A></TD>
							
							<?php }?>
							<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:document.location.href='menubar/cancel.php?id=<?php echo $comcid; ?>&option=<?php echo $option; ?>&sections=<?php echo $sections;?>';" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VSPACE="0"></A></TD>
							<TD WIDTH="370">&nbsp;</TD>
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
		
		function SAVE_MENU_subsections($option, $sections, $PageSource){ ?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
				<TR>
					<TD WIDTH="47%" VALIGN="top"><img name="menu" src="../images/admin/menu.gif" width="100%" height="28" border="0"></TD>
					<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
					<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
						<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
						<TR>	
							<?php if ($PageSource!="Link"){?>			
								<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('savenew<?php echo $PageSource;?>', 'subsections');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Publish" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="5" VSPACE="0"></A></TD>
			    			<?php }?>
							<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="index2.php?option=<?php echo $option;?>&sections=<?php echo $sections;?>" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VSPACE="0"></A></TD>
							<TD WIDTH="370">&nbsp;</TD>
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
}?>

