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
*	File Name: HTML_news.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*				Emir Sakic - saka@hotmail.com
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class HTML_news {
		function showNews($id, $title, $author, $newsimage, $option, $published, $checkedout, $editor, $archived, $categoryid, $categoryname, $categories, $frontpage, $approved, $GNameSel, $count, $offset, $rows_per_page){ ?>
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
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN="9" align=right>Select A Category:&nbsp;&nbsp;
					<SELECT NAME="categories" onChange="document.location.href='index2.php?option=News&categories=' + document.adminForm.categories.options[selectedIndex].value">
						<OPTION VALUE="">Select a category</OPTION>
						<?php if ($categories =="all"){?>
							<OPTION VALUE="all" selected>Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
							<OPTION VALUE="home">Select Home</OPTION>
						<?php }elseif ($categories == "new"){?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new"selected>Select NEW</OPTION>
							<OPTION VALUE="home">Select Home</OPTION>
						<?php }elseif ($categories == "home"){?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
							<OPTION VALUE="home" selected>Select Home</OPTION>
						<?php }else{?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
							<OPTION VALUE="home">Select Home</OPTION>
						 <?php }
						for ($i = 0; $i < count($categoryid); $i++){
							if ($categories == $categoryid[$i]){?>
								<OPTION VALUE="<?php echo $categoryid[$i]; ?>" SELECTED><?php echo $categoryname[$i]; ?></OPTION>
					<?php 		} else {?>
								<OPTION VALUE="<?php echo $categoryid[$i]; ?>"><?php echo $categoryname[$i]; ?></OPTION>
					<?php 			}
							}?>
					</SELECT>
				</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD COLSPAN="2" WIDTH="45%" CLASS="boxHeading">Site News Manager</TD>
				<TD WIDTH="5%" CLASS="heading">Author</TD>
				<TD WIDTH="10%" CLASS="heading">Image</TD>
				<TD WIDTH="5%" ALIGN="center" CLASS="heading">Home</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Published</TD>
				<TD WIDTH="12%" ALIGN="center" CLASS="heading">Archived</TD>
				<TD WIDTH="12%" ALIGN="center" CLASS="heading">Checked Out</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Access</TD>
			</TR>
			<?php 
							$color = array("#FFFFFF", "#CCCCCC");
							$k = 0;
			for ($i = 0; $i < count($id); $i++){?>
			<TR BGCOLOR="<?php echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<?php echo $id[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<?php 	if ($approved[$i] == 0){?>
						<TD WIDTH="45%"><A HREF="index2.php?option=<?php echo $option; ?>&task=edit&id=<?php echo $id[$i]; ?>&categories=<?php echo $categories; ?>"><?php echo $title[$i]; ?></A></TD>
					<?php }else {
						echo "<TD WIDTH=45%>$title[$i]&nbsp;</TD>";
					}?>
				<?php 	if ($author[$i] <> "") {?>
						<TD WIDTH="10% ALIGN="center"><?php echo $author[$i]; ?></TD>
					<?php } else { ?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
					<?php } ?>
				<?php      if ($newsimage[$i] <> "") {?>
                                                <TD WIDTH="10% ALIGN="center"><?php echo $newsimage[$i]; ?></TD>
                                        <?php } else { ?>
                                                <TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
                                        <?php } ?>
			<?php 	if ($frontpage[$i] == "1"){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?php 		} else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?php 			}
			}
			else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?php 		} else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?php 			}
			}

			if ($published[$i] == "1"){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?php 		} else {?>
						<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?php 			}
			}
			else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
			<?php 		} else {?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
			<?php 			}
			}

			if ($archived[$i] == 1){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?php 		} else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?php 			}
			}
			else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?php 		} else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?php 			}
			}

				if ($editor[$i] == ""){?>
					<TD WIDTH="15%" ALIGN="center">&nbsp;</TD>
			<?php 		}
				else {?>
					<TD WIDTH="15%" ALIGN="center"><?php echo $editor[$i]; ?></TD>
			<?php 		}?>
				<TD WIDTH="10%" ALIGN="center">
					<?php echo"$GNameSel[$i]";?>
					</td>

				<?php if ($k == 1){
					$k = 0;
				}
				else {
					$k++;
						}?>
				<?php 	}?>
			</TR>

				<TR BGCOLOR="#999999">
					<TD COLSPAN="9" ALIGN="center" CLASS="heading" WIDTH="100%"><?php 

					// By Emir Sakic <saka@hotmail.com>

					$pages_in_list = 10;				// set how many pages you want displayed in the menu

					// Calculate # of pages
					$pages = ceil($count / $rows_per_page);
					$from = ($offset-1) * $rows_per_page;

					$poffset = floor(($offset-1)/10);
					$from = $poffset*10;
					if (empty($prev)) $prev = 0;

					if ($poffset>0) {
						$prev = $poffset-1;
						$prev_offset = (($poffset-1)*10)+1;
						print "<a href=\"$PHP_SELF?option=News&categories=$categories&offset=1\" title=\"first list\"><b><<</b></a> \n";
						print "<a href=\"$PHP_SELF?option=News&categories=$categories&offset=$prev_offset\" title=\"previous list\"><b><</b></a> \n";
					}

					for ($i = $from+1; $i <= $from+$pages_in_list; $i++) {
						if (($i-1)<$pages) {
							$poffset = floor(($i-1)/10); //round down
							if ($i == $offset) {
								print "<b>$i</b> ";
							} else {
								print "<a href=\"$PHP_SELF?option=News&categories=$categories&offset=$i\" title=\"page $i\"><b>$i</b></a> ";
							}
						}
					}

					if (($i-1)<$pages) {
						$next = $poffset+1;
						$next_offset = $i;
						print " <a href=\"$PHP_SELF?option=News&categories=$categories&offset=$next_offset\" title=\"next list\"><b>></b></a>\n";
						$max_poffset = floor($pages/$pages_in_list-0.1);
						$max_offset = $max_poffset*$pages_in_list + 1;
						print " <a href=\"$PHP_SELF?option=News&categories=$categories&offset=$max_offset\" title=\"final list\"><b>>></b></a>";
					}

					//Loop:
					$i = $count+($offset-1)*$rows_per_page;

					?></TD>
			</TR>

			<INPUT TYPE='hidden' NAME='option' VALUE='<?php echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" Name="delete" VALUE="">
			<INPUT TYPE="hidden" Name="cat" VALUE="<?php echo $categories; ?>">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
			<?php }

		function editNews($imageid, $imagename, $categoryid, $categoryname, $sid, $author, $introtext, $fultext, $catidid, $title, $position, $newsimage, $ordering, $option, $restcount, $storyid, $categories, $frontpage, $frontpagecount, $text_editor, $Gid, $Gname, $GIDSel){?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function chooseOrdering(){
					var frontpage = <?php echo $frontpagecount; ?>;
					var restcount = <?php echo $restcount; ?>;
					var chosen = <?php echo $frontpage; ?>;
					var orders = <?php echo $ordering; ?>;

					if (document.adminForm.frontpage.checked){
						for (var x = 0; x < restcount; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						if (chosen == 1)
							var order = 0;
						else
							var order = 1;

						for (var x = 0; x < frontpage + order; x++){
							document.adminForm.ordering.options[x] = new Option(x+1, x+1);
				   		 	}

						if (chosen == 1)
							document.adminForm.ordering.options[orders-1].selected = true;
						}
					else {
						for (var x = 0; x < frontpage; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						if (chosen == 0)
							var order = 1;
						else
							var order = 0;

						for (var x = 0; x < restcount+order; x++){
							document.adminForm.ordering.options[x] = new Option(x+order, x+order);
				   		 	}
						if (chosen == 0)
							document.adminForm.ordering.options[orders-1].selected = true;
						}
					}
			//-->
			</SCRIPT>

			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="2" BGCOLOR="#FFFFFF" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN='3' CLASS='boxHeading' BGCOLOR="#999999">Edit News Story</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='15%' VALIGN="top">Title:</TD>
				<TD WIDTH=70 VALIGN="top"><INPUT TYPE='text' NAME='mytitle' SIZE='70' VALUE="<?php echo htmlspecialchars($title,ENT_QUOTES); ?>"></TD>
				<TD ROWSPAN='2' WIDTH='50%' VALIGN="top">
					<?php if ($newsimage!=""){?>
						<IMG SRC="../images/stories/<?php echo $newsimage; ?>" NAME="imagelib" WIDTH='69' HEIGHT='77'>
					<?php } else {?>
						<IMG SRC="../images/stories/noimage.jpg" NAME="imagelib" WIDTH='69' HEIGHT='77'>
					<?php }?>
				</TD>
			</TR>
			<TR>
				<TD VALIGN="top">News Category:</TD>
				<TD VALIGN="top">
			<SELECT NAME='newscatid'>
			<?php if ($catidid==""){?>
				<OPTION VALUE='' SELECTED>Select a catid</OPTION>
			<?php }?>
			<?php for ($i = 0; $i < count($categoryid); $i++){
					if ($categoryid[$i] == $catidid){?>
						<OPTION VALUE='<?php echo $categoryid[$i]; ?>' SELECTED><?php echo $categoryname[$i]; ?></OPTION>
			<?php 			}
					else {?>
						<OPTION VALUE='<?php echo $categoryid[$i]; ?>'><?php echo $categoryname[$i]; ?></OPTION>
			<?php 			}
				} ?>
			</SELECT>
			</TD>
			</TR>
			<TR>
				<TD WIDTH='15%' VALIGN="top">Author:</TD>
				<TD WIDTH=70 VALIGN="top"><INPUT TYPE='text' NAME='author' SIZE='20' VALUE="<?php echo $author; ?>"></TD>
				</TR><TR>

			<TR>
				<TD VALIGN='top'>Introduction:</TD>
				<TD COLSPAN='2'>
      <TEXTAREA COLS='70' ROWS='7' NAME='introtext' wrap="VIRTUAL"><?php echo str_replace('&','&amp;',$introtext); ?></TEXTAREA>
    </TD>
			</TR>
			<?php if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=introtext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?php 	}?>
			<TR>
				<TD VALIGN='top'>Extended Text:</TD>
				<TD COLSPAN='2'>
      <TEXTAREA COLS='70' ROWS='7' NAME='fultext' wrap="VIRTUAL"><?php echo str_replace('&','&amp;',$fultext); ?></TEXTAREA>
    </TD>
			</TR>
			<?php if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=fultext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?php 	}?>

			<TR>
				<TD>Image:</TD>
				<TD COLSPAN="2">
				<SELECT NAME='image' onChange="document.imagelib.src='../images/stories/' + document.forms[0].image.options[selectedIndex].text">
					<OPTION VALUE=''>Select image</OPTION>
					<?php for ($i = 0; $i < count($imagename); $i++){
						if (!eregi(".swf", $imagename[$i])){
								if ($imagename[$i] == $newsimage){?>
									<OPTION VALUE='<?php echo $imagename[$i]; ?>' SELECTED><?php echo $imagename[$i]; ?></OPTION>
								<?php }
							else {?>
								<OPTION VALUE='<?php echo $imagename[$i]; ?>'><?php echo $imagename[$i]; ?></OPTION>
								<?php }
							}
						}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD VALIGN='top'>Image Position:</TD>
			<?php 	if ($position == "left"){ ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="position" VALUE="left" CHECKED>Left&nbsp;&nbsp;<INPUT TYPE="radio" NAME="position" VALUE="right">Right</TD>
			<?php 	} else { ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="position" VALUE="left">Left&nbsp;&nbsp;<INPUT TYPE="radio" NAME="position" VALUE="right" CHECKED>Right</TD>
			<?php 	} ?>
			</TR>
			<TR>
				<TD>Story ordering</TD>
				<TD COLSPAN="2">
					<SELECT NAME="ordering">
					<?php if ($frontpage == 1){
						for ($i = 1; $i < $frontpagecount+1; $i++){
								if ($ordering == $i){?>
									<OPTION VALUE="<?php echo $i; ?>" SELECTED><?php echo $i; ?></OPTION>
								<?php 	}
								else {?>
									<OPTION VALUE="<?php echo $i; ?>"><?php echo $i; ?></OPTION>
								<?php 	}
						}
					}
					else {
						for ($i = 1; $i < $restcount+1; $i++){
								if ($ordering == $i){?>
									<OPTION VALUE="<?php echo $i; ?>" SELECTED><?php echo $i; ?></OPTION>
								<?php 	}
								else {?>
									<OPTION VALUE="<?php echo $i; ?>"><?php echo $i; ?></OPTION>
								<?php 	}
						}
							}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			<?php 	if ($frontpage == 0){?>
					<TD COLSPAN='2'><INPUT TYPE="checkbox" NAME="frontpage" VALUE="1" onClick="chooseOrdering();">Shows News on Front Page</TD>
			<?php 		}
				else {?>
					<TD COLSPAN='2'><INPUT TYPE="checkbox" NAME="frontpage" VALUE="1" CHECKED onClick="chooseOrdering();">Shows News on Front Page</TD>
			<?php 		}?>
			</TR>

			<TR><TD VALIGN="top">Access Level:</TD>
			<TD>
			<SELECT NAME='access' SIZE='1'>
			<?php 
			for ($a = 0;$a < count($Gid); $a++){
				if ($a == $GIDSel[0]) {
					echo"<OPTION VALUE=".$Gid[$a]." SELECTED>".$Gname[$a];
				}
				else {
					echo"<OPTION VALUE=".$Gid[$a].">".$Gname[$a];
				}
			}
			?>
			</select>

			</TD></TR>

			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' CLASS='heading' BGCOLOR="#999999">&nbsp;</TD>
			</TR>



			<INPUT TYPE='hidden' NAME='option' VALUE='<?php echo $option; ?>'>
			<INPUT TYPE='hidden' NAME='sid' VALUE='<?php echo $storyid; ?>'>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='porder' VALUE="<?php echo $ordering; ?>">
			<INPUT TYPE='hidden' NAME='categories' VALUE="<?php echo $categories; ?>">
			</FORM>
			</TABLE>
			<?php }

		function addNews($option, $catidtext, $catidid, $id, $imagename, $restcount, $frontpagecount, $text_editor, $categories, $Gid, $Gname){?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function chooseOrdering(){
					var frontpage = <?php echo $frontpagecount; ?>;
					var restcount = <?php echo $restcount; ?>;

					if (document.adminForm.frontpage.checked){
						for (var x = 0; x < restcount+2; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						for (var x = 0; x < frontpage+1; x++){
							document.adminForm.ordering.options[x] = new Option(x+1, x+1);
				   		 	}
						}
					else {
						for (var x = 0; x < frontpage+2; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						for (var x = 0; x < restcount+1; x++){
							document.adminForm.ordering.options[x] = new Option(x+1, x+1);
				   		 	}
						}
					}
			//-->
			</SCRIPT>

			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="2" BGCOLOR="#FFFFFF" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN='3' CLASS='boxHeading' BGCOLOR="#999999">Add News Story</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
				<TR>
				<TD WIDTH='15%'>Title:</TD>
				<TD WIDTH=70><INPUT TYPE='text' NAME='mytitle' SIZE='70' VALUE="<?php echo $title; ?>"></TD>
				<TD ROWSPAN='2' WIDTH='50%'><IMG SRC="../images/M_images/6977transparent.gif" NAME="imagelib" WIDTH='69' HEIGHT='77'></TD>
			</TR>
			<TR>
				<TD>News Category:</TD>
				<TD>
			<SELECT NAME='newscatid'>
				<OPTION VALUE=''>Select Category</OPTION>
				<?php for ($i = 0; $i < count($catidid); $i++){ ?>
					<OPTION VALUE='<?php echo $catidid[$i]; ?>'><?php echo $catidtext[$i]; ?></OPTION>
				<?php } ?>
			</SELECT>
			</TD>
			</TR>
			<TR>
				<TD WIDTH='15%' VALIGN="top">Author:</TD>
                                <TD WIDTH=70 VALIGN="top"><INPUT TYPE='text' NAME='author' SIZE='20' VALUE="<?php echo $author; ?>"></TD>
			</TR>
			<TR>
				<TD VALIGN='top'>Introduction:</TD>
				<TD COLSPAN='2'><TEXTAREA COLS='70' ROWS='7' NAME='introtext'><?php echo str_replace('&','&amp;',$introtext); ?></TEXTAREA></TD>
			</TR>
			<?php if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=introtext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?php 	}?>
			<TR>
				<TD VALIGN='top'>Extended Text:</TD>
				<TD COLSPAN='2'><TEXTAREA COLS='70' ROWS='7' NAME='fultext'><?php echo str_replace('&','&amp;',$fultext); ?></TEXTAREA></TD>
			</TR>
			<?php if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=fultext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?php 	}?>
			<TR>
				<TD>Image:</TD>
				<TD>
					<SELECT NAME='image' onChange="document.imagelib.src=null; document.imagelib.src='../images/stories/' + document.forms[0].image.options[selectedIndex].text">
						<OPTION VALUE=''>Select image</OPTION>
						<?php for ($i = 0; $i < count($imagename); $i++){
								if (!eregi(".swf", $imagename[$i])){?>
							<OPTION VALUE='<?php echo $imagename[$i]; ?>'><?php echo $imagename[$i]; ?></OPTION>
							<?php 		}
								}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD VALIGN='top'>Image Position:</TD>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="position" VALUE="left" CHECKED>Left&nbsp;&nbsp;<INPUT TYPE="radio" NAME="position" VALUE="right">Right</TD>
			</TR>
			<TR>
				<TD>Story ordering</TD>
				<TD COLSPAN="2">
					<SELECT NAME="ordering">
						<?php for ($i = 1; $i < $restcount+2; $i++){?>
								<OPTION VALUE="<?php echo $i; ?>"><?php echo $i; ?></OPTION>
						<?php 	}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
				<TD COLSPAN='2'><INPUT TYPE="checkbox" NAME="frontpage" VALUE="1" onClick="chooseOrdering();">Shows News on Front Page</TD>
			</TR>


			<TR><TD VALIGN="top">Access Level:</TD>
			<TD>
			<SELECT NAME='access' SIZE='1'>
			<?php 
			for ($a = 0;$a < count($Gid); $a++){
					echo"<OPTION VALUE=".$Gid[$a].">".$Gname[$a];
			}
			?>
			</select>
			</TD></TR>

			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' CLASS='heading' BGCOLOR="#999999">&nbsp;</TD>
			</TR>

			<INPUT TYPE='hidden' NAME='option' VALUE='<?php echo $option; ?>'>
			<INPUT TYPE='hidden' NAME='sid' VALUE='<?php echo $sid; ?>'>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='categories' VALUE="<?php echo $categories; ?>">
			</FORM>
			</TABLE>
			<?php }
		}
?>
