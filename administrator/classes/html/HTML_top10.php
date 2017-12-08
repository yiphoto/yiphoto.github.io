<?php 
/**
*	Mambo Open Source Version 4.0.11
*	Dynamic portal server and Content managment engine
*	27-11-2002
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.11
*	File Name: HTML_top10.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 27-11-2002
* 	Version #: 4.0.11
*	Comments:
**/

class HTML_top10 {
	function showtop10($storytitle, $storycounter, $sectitle, $seccounter, $task){
		$color = array("#FFFFFF", "#CCCCCC");
		$s = 0;
		?>
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR><TD class="boxheading">Top 10</TD>
			</TR>			
			<TR BGCOLOR="#707070">
				<?php $item = ucfirst($task);?>
				<TD WIDTH="50%" CLASS="heading"><?php echo $item; ?> Title</TD>
				<TD WIDTH="50%" ALIGN="center" CLASS="heading">Number of times read</TD>
			</TR>
			<?php if ($task == "news"){?>
			<?php for ($i = 0; $i < count($storytitle); $i++){
				$k = $i + 1;?>
				<TR BGCOLOR="<?php echo $color[$s]; ?>">
					<TD WIDTH='50%'><B><?php echo "$k."; ?></B> <?php echo $storytitle[$i]; ?></TD>
					<TD WIDTH="50%" ALIGN="center"><B><?php echo $storycounter[$i]; ?></B></TD>
				</TR>
				<?php if ($s == 1){
					$s = 0;
					}
			   else {
			   		$s++;
					}
				}
			} else if ($task == "articles") {
			?>
		<?php 	for ($i = 0; $i < count($sectitle); $i++){
				$k = $i + 1;?>
				<TR BGCOLOR="<?php echo $color[$s]; ?>">
					<TD WIDTH='50%'><B><?php echo "$k."; ?></B> <?php echo $sectitle[$i]; ?></B></TD>
					<TD WIDTH="10%" ALIGN="center"><B><?php echo $seccounter[$i]; ?></TD>
				</TR>
			<?php 	
			if ($s == 1){
				$s = 0;
			}
			else {
				$s++;
			}
		}
			}
			?>
			</TABLE>
		<?php 	}
		
}
?>
