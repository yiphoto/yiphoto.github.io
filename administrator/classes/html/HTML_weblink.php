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
*	File Name: HTML_weblink.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class HTML_weblinks {
		function showWeblinks($lid, $title, $option, $published, $checkedout, $editor, $categoryid, $categoryname, $categories, $approved){?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN="5" align=right>
					<SELECT class="inputbox" NAME="categories" onChange="document.location.href='index2.php?option=Weblinks&categories=' + document.adminForm.categories.options[selectedIndex].value">
						<OPTION VALUE="">Select a category</OPTION>
						<?php if ($categories =="all"){?>
							<OPTION VALUE="all" selected>Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
						<?php }elseif ($categories == "new"){?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new"selected>Select NEW</OPTION>
						<?php }else{?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
						 <?php }
						for ($i = 0; $i < count($categoryid); $i++){
							if ($categories == $categoryid[$i]){?>
								<OPTION VALUE="<?php echo $categoryid[$i]; ?>" SELECTED><?php echo $categoryname[$i]; ?></OPTION>
							<?php } else {?>
								<OPTION VALUE="<?php echo $categoryid[$i]; ?>"><?php echo $categoryname[$i]; ?></OPTION>
							<?php }
						}?>
					</SELECT>
				</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD COLSPAN="2" CLASS="boxHeading">Web Links Manager</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Published</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Checked Out</TD>
				<TD WIDTH="5%" ALIGN="center" CLASS="heading">Approved</TD>
			</TR>
			<?php 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($lid); $i++){?>
			<TR BGCOLOR="<?php echo $color[$k]; ?>">
					<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<?php echo $lid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<?php if ($approved[$i] == 0){?>
						<TD WIDTH="75%"><A HREF="index2.php?option=<?php echo $option; ?>&task=edit&lid=<?php echo $lid[$i]; ?>&categories=<?php echo $categories; ?>"><?php echo $title[$i]; ?></A></TD>
				<?php }else {?>
						<TD WIDTH="75%"><?php echo $title[$i]; ?></A></TD>
				<?php }	
				
				if ($published[$i] == 1){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
					<?php } else {?>
						<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
					<?php }
				}else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
					<?php } else {?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
					<?php }
				}
				
				if ($checkedout[$i] == 1){?>
					<TD WIDTH="10%" ALIGN="center"><?php echo $editor[$i]; ?></TD>
				<?php }	else {?>
					<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?php }
				
				if ($approved[$i]==1){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
					<?php } else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
					<?php }
				}else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
					<?php } else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
					<?php }
				}
				
				if ($k == 1){
					$k = 0;
				}else {
					$k++;
				}?>
			</TR>
			<?php }?>
			
			<INPUT TYPE='hidden' NAME='option' VALUE='<?php echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
			<?php }
			
		function editWeblinks($lid, $cid, $title, $description, $url, $option, $originalordering, $maxnum, $orderingcategory, $categorytitle, $categorycid, $categories){?>
			<SCRIPT LANGUAGE="Javascript">
			<!--
					categories = new Array();
			<?php 	for ($i = 0; $i < count($categorytitle); $i++){?>
			<?php 		$var = split(" ", $categorytitle[$i]);
			$count = count($var);
			for ($j = 0; $j < $count; $j++)
						$newvar .= $var[$j];?>
					categories["<?php echo $newvar; ?>"] = <?php echo $orderingcategory["$categorytitle[$i]"]; ?>;
			<?php 		if ($categorycid[$i] == $cid){?>
						var originalcategory = "<?php echo $newvar; ?>";
			<?php 			}?>
			<?php 		unset($newvar); ?>
			<?php 		}?>
				
				
			//-->
			</SCRIPT>
			
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="boxHeading" COLSPAN="2">Edit Web Links</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Name:</TD>
				<TD WIDTH='90%'><INPUT class="inputbox" TYPE='text' NAME='mytitle' SIZE='50' VALUE="<?php echo htmlspecialchars($title,ENT_QUOTES); ?>"></TD>
			</TR>
			<TR>
				<TD> Description:</TD>
				<TD><textarea NAME='description' COLS='50' ROWS='2'><?php echo $description; ?></TEXTAREA></TD>
			</TR>
			<TR>
				<TD>URL:</TD>
				<TD><INPUT class="inputbox" TYPE='text' NAME='url' VALUE="<?php echo $url; ?>" SIZE='50'></TD>
			</TR>
			<TR>
				<TD>Category:</TD>
				<TD>
					<SELECT class="inputbox" NAME='category'>
					<?php for ($i = 0; $i < count($categorycid); $i++){
						if ($categorycid[$i] == $cid){?>
							<OPTION VALUE='<?php echo $cid; ?>' SELECTED><?php echo $categorytitle[$i]; ?></OPTION>
							<?php }
						else {?>
							<OPTION VALUE='<?php echo $categorycid[$i]; ?>'><?php echo $categorytitle[$i]; ?></OPTION>
							<?php }
						}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='option' VALUE="<?php echo $option; ?>">
			<INPUT TYPE='hidden' NAME='lid' VALUE="<?php echo $lid; ?>">
			<INPUT TYPE='hidden' NAME='porder' VALUE="<?php echo $originalordering; ?>">
			<INPUT TYPE='hidden' NAME='categories' VALUE="<?php echo $categories; ?>">
			</FORM>
			<?php }
			
		function addweblinks($option, $categorycid, $categorytitle, $ordering, $categories){?>
			<SCRIPT LANGUAGE="Javascript">
			<!--
					categories = new Array();
			<?php 	for ($i = 0; $i < count($categorytitle); $i++){?>
			<?php 		$var = split(" ", $categorytitle[$i]);
			$count = count($var);
			for ($j = 0; $j < $count; $j++)
						$newvar .= $var[$j];?>
					categories["<?php echo $newvar; ?>"] = <?php echo $ordering["$categorytitle[$i]"]; ?>;
			<?php 		unset($newvar); ?>
			<?php 		}?>
			//-->
			</SCRIPT>
		
		
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="boxHeading" COLSPAN="2">Add Web Link</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Name:</TD>
				<TD WIDTH='90%'><INPUT class="inputbox" TYPE='text' NAME='mytitle' SIZE='50' VALUE=""></TD>
			</TR>
			 <TR>
                                <TD WIDTH='100'>Description:</TD>
				<TD WIDTH='90%'><textarea NAME='description' COLS='50' ROWS='2'><?php echo $description; ?></TEXTAREA></TD>
                        </TR>
			<TR>
				<TD>URL:</TD>
				<TD><INPUT class="inputbox" TYPE='text' NAME='url' VALUE="http://" SIZE='50'></TD>
			</TR>
			<TR>
				<TD>Category:</TD>
				<TD>
					<SELECT class="inputbox" NAME='category'>
					<?php for ($i = 0; $i < count($categorycid); $i++){?>
							<OPTION VALUE='<?php echo $categorycid[$i]; ?>'><?php echo $categorytitle[$i]; ?></OPTION>
						<?php }?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='option' VALUE="<?php echo $option; ?>">
			<INPUT TYPE='hidden' NAME='categories' VALUE="<?php echo $categories; ?>">
			</FORM>
			<?php }
		}
?>
