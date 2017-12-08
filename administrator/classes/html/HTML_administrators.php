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
*	File Name: HTML_administrators.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/

class HTML_administrators {
		function showadministrators($option, $uid, $name, $usertype){ ?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function isChecked(isitchecked){
					if (isitchecked == false){
						document.adminForm.boxchecked.value--;
						}
					else {
						document.adminForm.boxchecked.value++;
						}
					}
			//-->
			</SCRIPT>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD COLSPAN="2" CLASS="boxheading">Site Administrators</TD>
			</TR>
			<?php 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($uid); $i++){
				if ($usertype[$i]!="superadministrator"){
					$type="- Administrator";
				}else{
					$type="- Super Administrator";
				}?>
			<TR BGCOLOR="<?php echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<?php echo $uid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<TD WIDTH="100%"><?php echo "$name[$i] $type"; ?></TD>
				<?php if ($k == 1){
					$k = 0;
				}
				else {
					$k++;
						}?>
				<?php 
				}?>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<?php echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
		<?php 	}
		
		function editadministrator($option, $uid, $name, $email, $uname, $password, $usertype, $sendEmail, $liu){?>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%" BGCOLOR="#FFFFFF">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="boxheading">Edit Administrator</TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Name:</TD>
				<TD WIDTH='85%'><INPUT CLASS='inputbox' TYPE='text' NAME='realname' VALUE="<?php echo $name; ?>" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Email:</TD>
				<TD WIDTH='85%'><INPUT CLASS='inputbox' TYPE='text' NAME='email' VALUE="<?php echo $email; ?>" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Username:</TD>
				<TD WIDTH='85%'><INPUT CLASS='inputbox' TYPE='text' NAME='username' VALUE="<?php echo $uname; ?>" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>New Password:</TD>
				<TD WIDTH='85%'><INPUT CLASS='inputbox' TYPE='password' NAME='npassword' VALUE="" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Verify Password:</TD>
				<TD WIDTH='85%'><INPUT CLASS='inputbox' TYPE='password' NAME='vpassword' VALUE="" SIZE='25'></TD>
			</TR>
			<?php if ($usertype == "superadministrator"){?>
				<TR>
				<?php if ($sendEmail==1){?>
					<TD COLSPAN=2><INPUT TYPE="checkbox" NAME="emailAdmin" VALUE="1" Checked>&nbsp;&nbsp;Receive Email Notification</TD>
				<?php }else{?>
					<TD COLSPAN=2><INPUT TYPE="checkbox" NAME="emailAdmin" VALUE="1">&nbsp;&nbsp;Receive Email Notification</TD>
				<?php }?>
				</TR>
				<TR>
					<TD COLSPAN="2"><B>** You are currently the Super Administrator **</B></TD>
				</TR>
			<?php 	}?>	
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
			<INPUT TYPE='hidden' NAME='puname' VALUE="<?php echo $uname; ?>">
			<INPUT TYPE='hidden' NAME='ppassword' VALUE="<?php echo $password; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
		<?php 	}
		
		function newadministrator($option){ ?>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%" BGCOLOR="#FFFFFF">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="boxheading">Add New Administrator</TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Name:</TD>
				<TD WIDTH='90%'><INPUT CLASS='inputbox' TYPE='text' NAME='realname' SIZE='25'></TD>
			</TR>
			<TR>
				<TD>Email:</TD>
				<TD><INPUT CLASS='inputbox' TYPE='text' NAME='email' SIZE='25'></TD>
			</TR>
			<TR>
				<TD>Username:</TD>
				<TD><INPUT CLASS='inputbox' TYPE='text' NAME='username' SIZE='25'></TD>
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
