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
*	File Name: HTML_statistics.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 29-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class HTML_statistics {
		function show_browser_stats($percentInt, $count, $ChartLabel, $sum, $task){?>
			<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0" WIDTH="400" ALIGN="center">
			<TR bgcolor="#999999">
			<?php 	if ($task == "browser"){?>
				<TD ALIGN="center" CLASS="boxheading">Browser Statistics</TD>
			<?php  } else {?>
				<TD ALIGN="center" CLASS="boxheading">Operating System Statistics</TD>
			<?php 	}?>
			</TR>
			<TR>
				<TR>
				<TD COLSPAN="3" ALIGN="center">
					<TABLE CELLPADDING="1" CELLSPACING="0" BGCOLOR="#000000" BORDER="0" WIDTH="100%">
					<TR>
						<TD>
							<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" BGCOLOR="#FFFFFF" WIDTH="100%">
				<?php 	if (count($percentInt) <> 0){
					for ($i = 0; $i < count($ChartLabel); $i++){
						if ($percentInt[$i] <> ""){
							$percentage = $count[$i]/$sum * 100;
							$percentage = round($percentage, 2);
								?>
								<TR>
									<TD VALIGN="middle" HEIGHT="40"><IMG SRC="../images/polls/Col<?php echo $i+1; ?>M.gif" WIDTH="<?php echo $percentInt[$i]/10; ?>" HEIGHT="15" VSPACE="2" HSPACE="0"><IMG SRC="../images/polls/Col<?php echo $i+1; ?>R.gif" WIDTH="10" HEIGHT="15" VSPACE="2" HSPACE="0"><BR><?php echo "$ChartLabel[$i] - $count[$i] ($percentage%)"; ?></TD>
								</TR>
						<?php 	} else {?>
								<TR>
									<TD VALIGN="middle" HEIGHT="40"><IMG SRC="../images/polls/Col<?php echo $i+1; ?>M.gif" WIDTH="1" HEIGHT="15" VSPACE="2" HSPACE="0"><IMG SRC="../images/polls/Col<?php echo $i+1; ?>R.gif" WIDTH="10" HIGHT="15" VSPACE="2" HSPACE="0"><BR><?php echo "$ChartLabel[$i] - $count[$i] (0%)"; ?></TD>
								</TR>
					<?php 			}
					unset($percentage);
					}
				}
					else {?>
							<TR>
								<TD VALIGN="bottom">There are no results for this month.</TD>
							</TR>
					<?php 		
						}?>
							</TABLE>
						</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			</TABLE>
		<?php 	}
}
?>
