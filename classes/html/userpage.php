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
*	File Name: weblinks.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_userpage.php');

CLASS HTML_user {
		FUNCTION newsForm($catid, $secname, $uid, $option, $ImageName, $text_editor){?>
			<FORM ACTION="index.php" METHOD="post" NAME="adminForm">
				<CENTER>
				<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR>
					<TD CLASS="articlehead" COLSPAN=2><?php echo _SUBMIT_NEWS; ?></TD>
				</TR>
				<TR>
					<TD><?php echo _IMAGE; ?></TD>
					<TD><INPUT class="inputbox" TYPE="text" NAME="ImageName" DISABLED VALUE="<?php echo $ImageName;?>">&nbsp;&nbsp;
						<?php if ($ImageName==""){?>
							<a href="#" onClick="window.open('upload.php?uid=<?php echo $uid;?>&option=<?php echo $option;?>&type=news&existingImage='+ document.adminForm.ImageName.value, 'uploadwindow', 'width=300,height=180,menubar=0,toolbar=0,resizable=1,scrollbars=0');"><?php echo _UP_IMAGE; ?></a></TD>
						<?php }?>
					<TD ROWSPAN="2" WIDTH="250"><IMG SRC="images/M_images/6977transparent.gif" NAME="imagelib" WIDTH='69' HEIGHT='77'></TD>
				</TR>
				<TR>
					<TD><?php echo _IMAGE_POS; ?></TD>
					<TD COLSPAN=2><INPUT TYPE="radio" NAME="position" VALUE="left" CHECKED><?php echo _LEFT; ?>&nbsp;&nbsp;<INPUT TYPE="radio" NAME="position" VALUE="right"><?php echo _RIGHT; ?></TD>
				</TR>
				<TR>
					<TD WIDTH="100"><?php echo _TITLE; ?></TD>
					<TD COLSPAN=2>
        <INPUT class="inputbox" TYPE="text" NAME="newstitle" SIZE="30" VALUE="<?php echo $title; ?>">
      </TD>
				</TR>
				<TR>
					<TD><?php echo _SECTION; ?></TD>
					<TD COLSPAN=2>
						<SELECT class="inputbox" NAME="newssection">
							<OPTION VALUE="" SELECTED><?php echo _SEL_SECTION; ?></OPTION>
						<?php FOR ($i = 0; $i < count($catid); $i++){?>
								<OPTION VALUE="<?php echo $catid[$i]; ?>"><?php echo $secname[$i]; ?></OPTION>
						<?php 	}?>
						</SELECT>
					</TD>
				</TR>
				<TR>
					
      <TD VALIGN="top" height="44"><?php echo _INTRO; ?></TD>
					
      <TD VALIGN="top" COLSPAN="2" height="44"> 
        <TEXTAREA class="inputbox" COLS="30" ROWS="5" NAME="introtext"><?php echo str_replace('&','&amp;',$introtext);?></TEXTAREA>
      </TD>
				</TR>
				<?php if ($text_editor == true){?>
					<TR>
						<TD>&nbsp;</TD>
						<TD VALIGN="top"><A HREF="#" onClick="window.open('administrator/inline_editor/editor.htm?content=introtext', 'win1', 'width=650, height=450, resizable=yes');"><?php echo _EDITOR; ?></A></TD>
					</TR>
				<?php }?>
				<TR>
					
      <TD VALIGN="top" height="66"><?php echo _EXT; ?></TD>
					
      <TD VALIGN="top" COLSPAN="2" height="66"> 
        <TEXTAREA class="inputbox" COLS="30" ROWS="5" NAME="fultext"><?php echo str_replace('&','&amp;',$fultext);?></TEXTAREA>
      </TD>
				</TR>
				<?php if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('administrator/inline_editor/editor.htm?content=fultext', 'win1', 'width=650, height=450, resizable=yes');"><?php echo _EDITOR; ?></A></TD>
				</TR>
				<?php }?>
				<TR>
					<TD COLSPAN=3>&nbsp;</TD>
				</TR>
				<TR>
					<TD COLSPAN=3><INPUT TYPE="hidden" NAME="option" VALUE="<?php echo $option;?>">
								  <INPUT TYPE="hidden" NAME="op" VALUE="SaveNewNews">
								  <INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
								  <INPUT TYPE="hidden" NAME="ImageName2" VALUE=<?php echo $ImageName;?>>
								  <INPUT class="button" TYPE="submit" NAME="submit" VALUE="<?php echo _BUTTON_NEWS; ?>">
					</TD>
				</TR>
			</TABLE>
		</FORM>
		<!--<A HREF='index.php?option=<?php //echo $option;?>&op=CorrectLogin&uid=<?php //echo $uid;?>'><?php echo _BACK; ?></A>-->
	<?php }
	
	FUNCTION articleForm($catid, $secname, $uid, $option, $ImageName, $text_editor){?>
		<FORM ACTION="index.php" METHOD="post" NAME="adminForm">
			<CENTER>
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD CLASS="articlehead" COLSPAN=2><?php echo _SUBMIT_ARTICLE; ?></TD>
			</TR>
			<TR>
				<TD><?php echo _IMAGE; ?></TD>
				<TD><INPUT class="inputbox" TYPE="text" NAME="ImageName" DISABLED VALUE="<?php echo $ImageName;?>">&nbsp;&nbsp;
					<?php if ($ImageName==""){?>
						<a href="#" onClick="window.open('upload.php?uid=<?php echo $uid;?>&option=<?php echo $option;?>&type=articles&existingImage='+ document.adminForm.ImageName.value, 'uploadwindow', 'width=300,height=180,menubar=0,toolbar=0,resizable=1,scrollbars=0');"><?php echo _UP_IMAGE; ?></a></TD>
					<?php }?>
				<TD WIDTH=250><IMG SRC="images/M_images/6977transparent.gif" NAME="imagelib" WIDTH='69' HEIGHT='77'></TD>
			</TR>
			<TR>
				<TD WIDTH="100"><?php echo _TITLE; ?></TD>
				<TD COLSPAN=2>
        <INPUT class="inputbox" TYPE="text" NAME="arttitle" SIZE="30" VALUE="<?php echo $title; ?>">
      </TD>
			</TR>
			<TR>
				<TD><?php echo _SECTION; ?></TD>
				<TD COLSPAN=2>
					<SELECT class="inputbox" NAME="artsection">
							<OPTION VALUE="" SELECTED><?php echo _SEL_SECTION; ?></OPTION>
						<?php FOR ($i = 0; $i < count($catid); $i++){?>
								<OPTION VALUE="<?php echo $catid[$i]; ?>"><?php echo $secname[$i]; ?></OPTION>
						<?php 	}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				
      <TD VALIGN="top" height="30"><?php echo _CONTENT; ?></TD>
				
      <TD VALIGN="top" COLSPAN="2" height="30"> 
        <TEXTAREA class="inputbox" COLS="30" ROWS="5" NAME="pagecontent"><?php echo str_replace('&','&amp;',$pagecontent);?></TEXTAREA>
      </TD>
			</TR>
			<?php if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('administrator/inline_editor/editor.htm?content=pagecontent', 'win1', 'width=650, height=450, resizable=yes');"><?php echo _EDITOR; ?></A></TD>
				</TR>
			<?php }?>
			<TR>
				<TD>&nbsp;</TD>
				<TD COLSPAN=2><?php echo _ANON; ?>&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="anonymous"></TD>
			</TR>
			
			<TR>
				<TD COLSPAN=3><INPUT TYPE="hidden" NAME="option" VALUE="<?php echo $option;?>">
							  <INPUT TYPE="hidden" NAME="op" VALUE="SaveNewArticle">
							  <INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
							  <INPUT TYPE="hidden" NAME="ImageName2" VALUE="<?php echo $ImageName;?>">
							  <INPUT class="button" TYPE="submit" NAME="submit" VALUE="<?php echo _BUTTON_ARTICLE; ?>">
				</TD>
			</TR>
			</TABLE>
		</FORM>
		<!--<A HREF='index.php?option=<?php //echo $option;?>&op=CorrectLogin&uid=<?php //echo $uid;?>'><?php echo _BACK; ?></A>-->
	<?php }
		
	function FAQForm($catid, $secname, $uid, $option, $text_editor){?>
		<FORM ACTION="index.php" METHOD="post" NAME="adminForm">
			<CENTER>
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD CLASS="articlehead" COLSPAN=5><?php echo _SUBMIT_FAQ; ?></TD>
			</TR>
			<TR>
				<TD WIDTH="100"><?php echo _TITLE; ?></TD>
				<TD COLSPAN="3">
        <INPUT class="inputbox" TYPE="text" NAME="faqtitle" SIZE="30" VALUE="<?php echo $title; ?>">
      </TD>
			</TR>
			<TR>
				<TD><?php echo _SECTION; ?></TD>
				<TD COLSPAN="3">
					<SELECT class="inputbox" NAME="faqsection">
							<OPTION VALUE="" SELECTED><?php echo _SEL_SECTION; ?></OPTION>
						<?php for ($i = 0; $i < count($catid); $i++){?>
								<OPTION VALUE="<?php echo $catid[$i]; ?>"><?php echo $secname[$i]; ?></OPTION>
						<?php 	}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				
      <TD VALIGN="top" height="60"><?php echo _CONTENT; ?></TD>
				
      <TD VALIGN="top" COLSPAN="3" height="60"> 
        <TEXTAREA class="inputbox" COLS="30" ROWS="5" NAME="pagecontent"><?php echo str_replace('&','&amp;',$pagecontent);?></TEXTAREA>
      </TD>
			</TR>
			<?php if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('administrator/inline_editor/editor.htm?content=pagecontent', 'win1', 'width=650, height=450, resizable=yes');"><?php echo _EDITOR; ?></A></TD>
				</TR>
			<?php }?>
			<TR>
				<TD COLSPAN=5><INPUT TYPE="hidden" NAME="option" VALUE="<?php echo $option;?>">
							  <INPUT TYPE="hidden" NAME="op" VALUE="SaveNewFAQ">
							  <INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
							  <INPUT class="button" TYPE="submit" NAME="submit" VALUE="<?php echo _BUTTON_FAQ; ?>">
				</TD>
			</TR>
			</TABLE>
		</FORM>
		<!--<A HREF='index.php?option=<?php echo $option;?>&op=CorrectLogin&uid=<?php echo $uid;?>'><?php echo _BACK; ?></A>-->
	<?php }
	
	function linkForm($catid, $secname, $uid, $option){?>
		<FORM ACTION="index.php" METHOD="post" NAME="NewLink">
			<CENTER>
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD CLASS="articlehead" COLSPAN=5><?php echo _SUBMIT_LINK; ?></TD>
			</TR>
			<TR>
				<TD WIDTH="100"><?php echo _NAME; ?></TD>
				<TD COLSPAN="3">
        <INPUT class="inputbox" TYPE="text" NAME="linktitle" SIZE="30">
      </TD>
			</TR>
			<TR>
				<TD><?php echo _SECTION; ?></TD>
				<TD COLSPAN="3">
					<SELECT class="inputbox" NAME="linksection">
							<OPTION VALUE="" SELECTED><?php echo _SEL_SECTION; ?></OPTION>
						<?php for ($i = 0; $i < count($catid); $i++){?>
								<OPTION VALUE="<?php echo $catid[$i]; ?>"><?php echo $secname[$i]; ?></OPTION>
						<?php 	}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD ><?php echo _URL; ?></TD>
				<TD COLSPAN="3">
        <INPUT class="inputbox" TYPE=TEXT NAME="linkUrl" size=30>
      </TD>
			</TR>
			<TR>
			<TD> Description:</TD>
			<TD COLSPAN="3">
	<TEXTAREA class="inputbox" NAME="linkdesc" COLS="30" ROWS="3"></TEXTAREA></td>
			</tr>	
			<TR>
				<TD COLSPAN=5><INPUT TYPE="hidden" NAME="option" VALUE="<?php echo $option;?>">
							  <INPUT TYPE="hidden" NAME="op" VALUE="SaveNewLink">
							  <INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
							  <INPUT class="button" TYPE="submit" NAME="submit" VALUE="<?php echo _BUTTON_LINK; ?>">
				</TD>
			</TR>
			</TABLE>
		</FORM>
		<!--<A HREF='index.php?option=<?php echo $option;?>&op=CorrectLogin&uid=<?php echo $uid;?>'><?php echo _BACK; ?></A>-->
	<?php }
	
		
	function userEdit($uid, $name, $username, $email, $option){?>
		<FORM ACTION="index.php" METHOD="post" NAME="EditUser">
			<CENTER>
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD CLASS="articlehead" COLSPAN=5><?php echo _EDIT_TITLE; ?></TD>
			</TR>
			<TR>
				<TD WIDTH=85><?php echo _YOUR_NAME; ?></TD>
				<TD><INPUT class="inputbox" TYPE="text" NAME="name2" VALUE="<?php echo $name;?>"></TD>
			</TR>
			<TR>
				<TD><?php echo _EMAIL; ?></TD>
				<TD><INPUT class="inputbox" TYPE="text" NAME="email2" VALUE="<?php echo $email;?>" SIZE=30></TD>
			<TR>
				<TD><?php echo _UNAME; ?></TD>
				<TD><INPUT class="inputbox" TYPE="text" NAME="username2" VALUE="<?php echo $username;?>"></TD>
			</TR>
			<TR>
				<TD><?php echo _PASS; ?></TD>
				<TD><INPUT class="inputbox" TYPE="password" NAME="pass2" VALUE=""></TD>
			</TR>
			<TR>
				<TD><?php echo _VPASS; ?></TD>
				<TD><input class="inputbox" type="password" name="verifyPass"></TD>
			</TR>
			<TR>
				<TD colspan=2><INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
							  <INPUT TYPE="hidden" NAME="option" VALUE="<?php echo $option;?>">
							  <INPUT TYPE="hidden" NAME="op" VALUE="saveUserEdit">
							  
        <INPUT class="button" TYPE="submit" NAME="submit" VALUE="<?php echo _BUTTON_SUBMIT; ?>">
				</TD>
			</TR>
		</TABLE>
		</FORM>
	<?php }
	
	function confirmation(){?>
		<TABLE>
			<TR>
				<TD CLASS="articlehead"><?php echo _SUBMIT_SUCCESS; ?></TD>
			</TR>
			<TR>
				<TD><?php echo _SUBMIT_SUCCESS_DESC; ?></TD>
			</TR>
		</TABLE>
	<?php }
	
	function frontpage(){?>
		<TABLE>
			<TR>
				<TD CLASS="articlehead"><?php echo _WELCOME; ?></TD>
			</TR> 
			<TR>
				<TD><?php echo _WELCOME_DESC; ?></TD>
			</TR>
		</TABLE>
	<?php }
}?>
