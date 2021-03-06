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
*	File Name: HTML_newsfeeds.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class HTML_newsfeeds {
		function viewnewsfeeds($option, $newsfeedsname, $newsfeedsid, $newsfeedscategory, $name, $id, $num){?>
			<SCRIPT LANGUAGE="Javascript">
			<!--
				var categories = new Array();
				var categoryid = new Array();
			<?php 	for ($i = 0; $i < count($newsfeedscategory); $i++){?>
					categories[<?php echo $i; ?>] = new Array();
			<?php 		for ($k = 0; $k < count($newsfeedsname["$newsfeedscategory[$i]"]); $k++){
						$cat = $newsfeedsname["$newsfeedscategory[$i]"][$k];?>
						categories[<?php echo $i; ?>][<?php echo $k; ?>] = "<?php echo $cat; ?>";
			<?php 			}?>
			<?php 		}?>
			
			<?php 	for ($i = 0; $i < count($newsfeedscategory); $i++){?>
					categoryid[<?php echo $i; ?>] = new Array();
			<?php 		for ($k = 0; $k < count($newsfeedsid["$newsfeedscategory[$i]"]); $k++){
						$cat = $newsfeedsid["$newsfeedscategory[$i]"][$k];?>
						categoryid[<?php echo $i; ?>][<?php echo $k; ?>] = "<?php echo $cat; ?>";
			<?php 			}?>
			<?php 		}?>
			
				function viewCategory(category){
					for (var i = 0; i < document.adminForm.newsfeeds.options.length; i++){
						document.adminForm.newsfeeds.options[i].value = "";
						document.adminForm.newsfeeds.options[i].text = "";
						}
					document.adminForm.newsfeeds.options.length = 0;
					
					for (var k = 0; k < categories[category].length; k++){
						document.adminForm.newsfeeds.options[k] = new Option(categories[category][k], categoryid[category][k]);
						}
					}
					
				function addCategory(){
					forloop1:
					for (var i = 0; i < document.adminForm.newsfeeds.length; i++){
						if (document.adminForm.newsfeeds.options[i].selected == true){
							for (var k = 0; k < document.adminForm.selections.options.length; k++){
								if (document.adminForm.selections.options[k].text == document.adminForm.newsfeeds.options[i].text){
									alert("Already added this news feed");
									break forloop1;
									}
								}
							var num = document.adminForm.selections.length;
							document.adminForm.selections.options[num] = new Option(document.adminForm.newsfeeds.options[i].text, document.adminForm.newsfeeds.options[i].value);
							}
						}
					}
					
				function removeCategory(){
					for (var i = 0; i < document.adminForm.selections.length; i++){
						if (document.adminForm.selections.options[i].selected == true){
							document.adminForm.selections.options[i] = null;
							var num = document.adminForm.selections.length;
							num;
							document.adminForm.selections.length = num;
							}
						}
					}
					
			//-->
			</SCRIPT>
			<FORM ACTON='index2.php' METHOD='GET' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%" ALIGN="center" BGCOLOR="#FFFFFF">
			<TR>
				<TD COLSPAN='2' CLASS='boxheading' BGCOLOR="#999999">News Feed Manager</TD>
			</TR>
			<TR>
				<TD COLSPAN='2' >&nbsp;</TD>
			</TR>
			<TR>
				<TD ALIGN="right" >Categories:</TD>
				<TD VALIGN="top" ALIGN="left" WIDTH="60%">
					<SELECT class="inputbox" NAME="categories" SIZE="1" WIDTH="250" style="width:250px" onChange="viewCategory(document.adminForm.categories.options[selectedIndex].value)">
					<?php 	for ($i = 0; $i < count($newsfeedscategory); $i++){?>
							<OPTION VALUE="<?php echo $i;?>"><?php echo $newsfeedscategory[$i]; ?></OPTION>
					<?php 		}?>
					</SELECT>
				</TD>
				
			</TR>
			<TR>
				<TD  ALIGN="right">News Feed name</TD>	
				<TD WIDTH="250" ALIGN="left">
					<SELECT class="inputbox" NAME="newsfeeds" SIZE="1" WIDTH="250" STYLE="width:250px">
					<SCRIPT>
					<!--
						for (var k = 0; k < categories[0].length; k++){
							document.write("<OPTION VALUE='" + categoryid[0][k] + "'>" + categories[0][k] + "</OPTION>");
							}
					//-->
					</SCRIPT>
					</SELECT>
				</TD>
				
			</TR>
			<TR>
				<TD COLSPAN="2"ALIGN="center"><INPUT class="button" TYPE="button" NAME="add" VALUE="Add" onClick="addCategory();">&nbsp;&nbsp;<INPUT class="button" TYPE="button" NAME="remove" VALUE="Remove" onClick="removeCategory();"></TD>
			</TR>
			<TR>
				<TD ALIGN="right" VALIGN="top">Your Selection</TD>
				<TD WIDTH="250" ALIGN="left">
					<SELECT class="inputbox" NAME="selections" SIZE="10" WIDTH="250" STYLE="width:250px" MULTIPLE>
					<?php 	for ($i = 0; $i < count($id); $i++){?>
							<OPTION VALUE="<?php echo $id[$i]; ?>"><?php echo $name[$i]; ?></OPTION>
					<?php 		}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
				<TD ALIGN="left">Number of articles per feed:&nbsp;&nbsp;<INPUT class="inputbox" TYPE="text" NAME="num" VALUE="<?php echo $num; ?>" SIZE="3"></TD>
			</TR>
			<TR>
				<TD COLSPAN='2' HEIGHT="40">&nbsp;</TD>
			</TR>
			<TR>
				<TD COLSPAN='2' CLASS='heading' BGCOLOR="#999999">&nbsp;</TD>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<?php echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
			</TABLE>
		<?php 	}
}
?>
