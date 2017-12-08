<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	04-04-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: _emailform.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 04-04-2003
* 	Version #: 4.0.12
*	Comments:
**/
?>
<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0">
    <TR> 
      <TD colspan=2><?php echo _EMAIL_FRIEND; ?></TD>
    </TR>
    <TR> 
      <TD COLSPAN=2>&nbsp;</TD>
    </TR>
    <TR> 
      <TD width=130><?php echo _EMAIL_FRIEND_ADDR; ?></TD>
      <TD><INPUT TYPE="text" NAME="email" class="inputbox" SIZE="25"></TD>
    </TR>
    <TR> 
      <TD height="27"><?php echo _EMAIL_YOUR_NAME; ?></TD>
      <TD><INPUT TYPE="text" NAME="yourname" class="inputbox" SIZE="25"></TD>
    </TR>
    <TR> 
      <TD><?php echo _EMAIL_YOUR_MAIL; ?></TD>
      <TD><INPUT TYPE="text" NAME="youremail" class="inputbox" SIZE="25"></TD>
    </TR>
    <TR> 
      <TD COLSPAN=2>&nbsp;</TD>
    </TR>
    <TR> 
      <TD COLSPAN=2><input type="submit" name="submit" class="button" value="<?php echo _BUTTON_SUBMIT_MAIL; ?>"> 
        &nbsp;&nbsp;
        <INPUT TYPE="button" NAME="cancel" VALUE="<?php echo _BUTTON_CANCEL; ?>" class="button" onClick="window.close();"></TD>
    </TR>
  </TABLE>
  <INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $id; ?>">
</FORM>
