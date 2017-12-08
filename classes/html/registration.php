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
*	File Name: registration.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_registration.php');

class registration {
		function lostPassForm($option){?>
			<table cellpadding=5 cellspacing=0 border=0 width="60%" class="newspane">
				<tr>
					<td valign="top" class="articlehead"><?php echo _PROMPT_PASSWORD; ?></td>
				</tr>
				<tr>
					<td><?php echo _NEW_PASS_DESC; ?><br>
						<form action="index.php" method="post">
							<?php echo _PROMPT_UNAME; ?><br><input type="text" name="checkusername" class="inputbox" size=20 maxlength=25><BR>
							<BR><?php echo _PROMPT_EMAIL; ?><br><input type="text" name="confirmEmail" class="inputbox" size=25 >
							<BR><BR>
							<input type=hidden name=option value="<?php echo $option;?>">
							<input type=hidden name=task value=sendNewPass>
							<input type="submit" class="button" value="<?php echo _BUTTON_SEND_PASS; ?>">
						</form>
					</td>
				</tr>
			</table>
	  <?php }
	  
	  function registerForm($option){?>
			<table cellpadding=5 cellspacing=0 border=0 width="60%" class="newspane">
				<tr>
					<td valign="top" colspan=2 class="articlehead"><?php echo _REGISTER_TITLE; ?></td>
				</tr>
				<tr>
					<td width=100><form action="index.php" method="post">
						<?php echo _REGISTER_NAME; ?></td>
					<td><input type="text" name="yourname" class="inputbox"></td>
				</tr>
				<tr>
					<td><?php echo _REGISTER_UNAME; ?></td>
					<td><input type="text" name="username1" class="inputbox"></td>
				</tr>
				<tr>
					<td><?php echo _REGISTER_EMAIL; ?></td>
					<td><input type="text" name="email" size=30 class="inputbox"></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo _SENDING_PASSWORD; ?></td>
				</tr>
				<tr>
					<td colspan=2><input type=hidden name=option value="<?php echo $option;?>">
								  <input type=hidden name=task value=saveRegistration>
								  <input type="submit" value="<?php echo _BUTTON_SEND_REG; ?>" class="button">
						</form>
					</td>
				</tr>
			</table>
	  <?php }
}?>
