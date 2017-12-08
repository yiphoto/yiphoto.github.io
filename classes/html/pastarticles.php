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
*	File Name: pastarticles.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_pastarticles.php');

class pastarticles{
	function searchArchiveForm($option, $search, $days, $type){?>
		<center>
		<table border=0 width=99% cellpadding=5 cellspacing=0 class="newspane">
		<FORM ACTION='index.php?option=<?php echo $option;?>&task=search' METHOD='POST' NAME='searchForm'>
			<tr>
			  <?php if ($type=="Articles") {$disp_type=_PA_ARTICLES;} else {$disp_type=_PA_NEWS;} ?>
				<td colspan=2 class="articlehead"><?php echo _PA_TITLE.' '.$disp_type;?></td>
			</tr>
			<tr>
				<td colspan=2 class="newsarticle"><?php echo _PA_DESC; ?>
				</td>
				<TD width="50%" ><img src="images/M_images/pastarchives.jpg" width="140" height="110"></TD>
			</tr>
			<tr>
				<td colspan=3><B><?php echo $disp_type.' '._PROMPT_TITLE;?></B>&nbsp;&nbsp;<INPUT TYPE='text' NAME='search' SIZE='20' class="inputbox" VALUE='<?php echo $search;?>'></td>
			</tr>
			<tr>
				<td colspan=2><B><?php echo $disp_type.' '._PROMPT_DATE;?></B>&nbsp;&nbsp;
					<SELECT NAME="days">
						<?php if ($days!=""){
							if ($days==0){
								$timeframe=_DATE_ALL;
							}else if ($days==7){
								$timeframe="1 "._DATE_WEEK;
							}else if ($days==30){
								$timeframe="1 "._DATE_MONTH;
							}else if ($days==90){
								$timeframe="3 "._DATE_MONTHS;
							}else if ($days==180){
								$timeframe="6 "._DATE_MONTHS;
							}else if ($days==360){
								$timeframe="1 "._DATE_YEAR;
							}else if ($days=="1080"){
								$timeframe="3 "._DATE_YEARS;
							}?>
							<option name="<?php echo $days;?>" value="<?php echo $days;?>" selected><?php echo $timeframe;?></option>
						<?php }?>									
							<option name="0"  value=0><?php echo _DATE_ALL; ?></option>
						   	<option name="7" value=7>1 <?php echo _DATE_WEEK; ?></option>
	    					<option name="30" value=30>1 <?php echo _DATE_MONTH; ?></option>
							<option name="90" value=90>3 <?php echo _DATE_MONTHS; ?></option>
							<option name="180" value=180>6 <?php echo _DATE_MONTHS; ?></option>
							<option name="360" value=360>1 <?php echo _DATE_YEAR; ?></option>
							<option name="1080" value=1080>3 <?php echo _DATE_YEARS; ?></option>
						</select>
				</td>
			</tr>
			<tr>
				<td colspan=2><INPUT TYPE="hidden" NAME="type" VALUE="<?php echo $type;?>">
							<INPUT TYPE='submit' NAME='searchbutton' class="button" VALUE='<?php echo _BUTTON_SEARCH; ?>'></td>
			</tr>
			<tr>
				<td colspan=2>&nbsp;</td>
			</tr>
		</table>
		</FORM>
	<?php }
	
	function displaySearchResults($sid, $title, $date2, $option, $length, $type, $popup){?>
		<TABLE width=99% cellpadding=5 cellspacing=0 border=0>
			<TR>
				<TD colspan=2><B><?php eval ('print "'._PA_FOUND.'";'); ?></B></TD>
			</TR>
			<?php if ($length!=0){?>
				<TR>
					<TD colspan=2><?php echo _LINK_VIEW; ?></TD>
				</TR>
			<?php }
			$numrecs=count($sid);
			if ($numrecs!=0){
				for ($i=0; $i < $numrecs; $i++){
					?>
					<TR>
						<TD><?php if ($type=="News"){
							echo"<A HREF='index.php?option=news&task=viewarticle&sid=$sid[$i]'>$title[$i]</A>\n";
	} else if ($type=="Articles") {
		if ($popup) {
			echo "<A HREF=\"#\" onClick=\"window.open('popups/articleswindow.php?id=$sid[$i]', 'win1', 'status=no,directories=no,scrollbars=yes,title=yes,menubar=no,resizable=yes,toolbar=yes,width=640,height=480');\">$title[$i]</a>\n";
		} else {
			echo "<A HREF='index.php?option=articles&task=viewarticle&artid=$sid[$i]'>$title[$i]</A>\n";
		}
								}?>
						</TD>
						<TD align='left' width=250><?php echo $date2[$i];?></TD>
					</TR>
				<?php }
			}?>
		</table>
	<?php }	
}?>