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
*	File Name: components.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_components.php');

class components {
		function component($title, $content, $lang){?>
<table width="95%" border="0" cellspacing="0" cellpadding="1" align=center>
  <tr>
    <td valign="top">
	  <span class="componentHeading"><?php print $title;?></span><br>
      <?php print $content;?>
    </TD>
			</tr>
      		</table>
		
			<?php }
			
		function survey($pollTitle, $optionText, $pollID, $voters, $title, $dbprefix, $lang, $absolute_path){?>

<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
<form name="form2" method="post" action="pollBooth.php">			
	<tr> 
          		<td colspan="2" class="componentHeading"><?php echo $title; ?></td>
        	</tr>
			<tr><td colspan="2" class="poll"><b><?php echo $pollTitle; ?></b></td></tr>
			<?php for ($i = 0; $i < count($optionText); $i++){ ?>
				<tr>
	          		<td valign="top"><input type="radio" name="voteID" value='<?php echo $voters[$i];?>'></td>
	          		<td class="poll" valign="top"><?php echo $optionText[$i]; ?></td>
	        	</tr>
				<?php } ?>
			<tr>
          		<td colspan="2"><div align="center"><br>
								<INPUT TYPE='hidden' NAME='polls' VALUE='<?php echo $pollID;?>'>
								<INPUT TYPE='hidden' NAME='dbprefix' VALUE='<?php echo $dbprefix;?>'>
								<INPUT TYPE='hidden' NAME='lang' VALUE='<?php echo $lang;?>'>
								<INPUT TYPE='hidden' NAME='task' VALUE='Vote'>
								<INPUT TYPE='hidden' NAME='absolute_path' VALUE='<?php echo $absolute_path;?>'>
								<INPUT TYPE='submit' NAME='task_button' class="button" VALUE='<?php echo _BUTTON_VOTE; ?>'>&nbsp;&nbsp;
								<INPUT TYPE='button' NAME='option' class="button" VALUE='<?php echo _BUTTON_RESULTS; ?>' onClick='document.location.href="index.php?option=surveyresult&task=Results&polls=<?php echo $pollID;?>&month=<?php echo date(m); ?>"'></div></td>
       	 	</tr>
			
			</FORM>
			</table>
			
			
		<?php 	} 
		
		function AuthorLogin($title, $lang){?>
			<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        	<tr> 
          		<td><span class="componentHeading"><?php echo $title; ?></span><br></td>
        	</tr>
			<tr>
				<td><FORM ACTION=usermenu.php METHOD=post NAME=login> 
					<?php echo _USERNAME; ?><br><input type="text" name="username" class="inputbox" size="10"> <br> 
					<?php echo _PASSWORD; ?><br><input type="password" name="passwd" class="inputbox" size="10">  
					<input type=hidden name="op2" value="login">
					<input type=hidden name="lang" value="<?php echo $lang; ?>">
					<input type="submit" name="Submit" class="button" value="<?php echo _BUTTON_LOGIN; ?>">
					</FORM> 
				</td>
			</tr>
			<tr>
    <td><?php echo _LOST; ?> <a href="index.php?option=registration&task=lostPassword"><?php echo _PASSWORD; ?></a>? 
    </td>
			</tr>
			<tr>
				
    <td><?php echo _NO_ACCOUNT; ?> <a href="index.php?option=registration&task=register"><?php echo _CREATE_ACCOUNT; ?></a> </td> 
			</tr>
			</table>
		<?php }
		}
?>
