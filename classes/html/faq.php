<?php
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	31-01-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: faq.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 31-01-2003
* 	Version #: 4.0.12
*	Comments: The function listing retrieves all article categories and titles from the database.
**/

include('language/'.$lang.'/lang_faq.php');

class faq {
		function faqlist($catidtext, $catidid, $num, $title, $sid, $id, $counter, $noauth_catidtext, $popup){
		global $Itemid; ?>
	<FORM NAME="news">

  <TABLE WIDTH="98%" CELLPADDING="4" CELLSPACING="4" BORDER="0" ALIGN="center" class="newspane">
    <TR>
      <TD colspan="2"> <span CLASS="articlehead"><?php echo _FAQ_TITLE; ?></span> </TD>
    </TR>
    <TR>
      <TD width="60%" valign="top" class="newsarticle">
        <p><?php echo _FAQ_DESC; ?></p>
        <p>
		<ul>
	<?php 	for ($i = 0; $i < count($catidid); $i++){
		if (($id == $i) && ($id <> "")){
			echo "<li><b>$catidtext[$i]</b>&nbsp;<span class=small>($num[$i])</span></li>";
		} else {
			echo "<li><a class=category href='index.php?option=faq&Itemid=$Itemid&topid=$i'>$catidtext[$i]</a>&nbsp;<span class=small>($num[$i])</span></li>";
		}
	}
	if (count($noauth_catidtext)>0){
		for ($j = 0; $j < count($noauth_catidtext); $j++){
			echo "<li><span class=category>$noauth_catidtext[$j] "._NOT_AUTH_SHORT."</span></li>";
		}
	}
		?>
		</ul>
        </p>
      </TD>
      <TD width="40%" VALIGN=TOP><img src="images/M_images/taking_notes.jpg" ALIGN=right width="136" height="136" ALT="FAQ Section"></TD>
    </TR>
    <TR>
      <TD VALIGN="top" colspan="2">
        <?php 	if ($id <> ""){?>
        <hr>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="32" height="20" align="center" class="sectiontableheader">&nbsp;</td>
            <td width="100%" height="20" class="sectiontableheader"><?php echo _HEADER_TITLE; ?></td>
          </tr>
          <?php
		$tabclass = array("sectiontableentry1", "sectiontableentry2");
		$k = 0;
		for ($i = 0; $i < count($sid["$catidtext[$id]"]); $i++){
			$test = $time["$catidtext[$id]"][$i];
			$count = $counter["$catidtext[$id]"][$i];
			$date = split(" ",$test);
			$datesplit = split("-", $date[0]);
				?>
          <tr class="<?php echo $tabclass[$k]; ?>">
            <?php
				$today = date("n d Y");
				$todaydate = split(" ", $today);
				$sum = $todaydate[2] - $datesplit[0];
							if (($sum < 7) && ($datesplit[2] == $todaydate[1]) && ($datesplit[1] == $todaydate[0])){?>
            <td width="32" height="20" align="center"><img src="images/M_images/newii.gif" width="19" height="11" align="absbottom" vspace="3" hspace="3"></td>
            <?php } elseif ($count > 25){?>
            <td width="32" height="20" align="center"><img src="images/M_images/hot.gif" width="19" height="11" align="absbottom" vspace="3" hspace="3"></td>
            <?php } else {?>
            <td width="32" height="20" align="center"><img src="images/M_images/document.gif" width="19" height="11" align="absbottom" vspace="3" hspace="3"></td>
            <?php 	} ?>
			<td width="100%" height="20">
			<?php if ($popup) {
				echo "<A HREF=\"#\" onClick=\"window.open('popups/faqwindow.php?id=" . $sid["$catidtext[$id]"][$i] . "', 'win1', 'status=no,directories=no,scrollbars=yes,title=yes,menubar=no,resizable=yes,toolbar=yes,width=640,height=480');\">" . $title["$catidtext[$id]"][$i] . "</A>\n";
			} else {
				echo "<A HREF='index.php?option=faq&task=viewfaq&artid=" . $sid["$catidtext[$id]"][$i] . "&Itemid=" . $Itemid . "'>" . $title["$catidtext[$id]"][$i] . "</A>";
			} ?>
			</td>
          </tr>
          <?php 	if ($k == 1){
          	$k = 0;
          }
          else {
          	$k++;
          }
							}?>
        </table>
        <?php 	} ?>
        <hr>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100%" colspan="4" height="20"><b><?php echo _LEGEND; ?>:</b></td>
          </tr>
          <tr>
            <td width="20" height="20"><img src="images/M_images/newii.gif" width="19" height="11" align="absbottom"></td>
            <td width="120" height="20"><?php echo _NEW_FAQ; ?></td>
            <td width="20" height="20"><span class="small"><img src="images/M_images/hot.gif" width="19" height="11"></span></td>
            <td width="250" height="20"><?php echo _HOT_FAQ; ?></td>
          </tr>
          <tr>
            <td width="20" height="20"><span class="small"><img src="images/M_images/document.gif" width="19" height="11"></span></td>
            <td width="120" height="20"><?php echo _REG_FAQ; ?></td>
            <td width="20" height="20"><img src="images/M_images/remote_author.gif" width="19" height="11"></td>
            <td width="250" height="20"><?php echo _REMOTE_FAQ; ?></td>
          </tr>
        </table>
      </TD>
    </TR>
  </TABLE>
			</FORM>
		<?php 	}
		function showfaqs($title, $content, $artid){
		?>
			<TABLE CELLPADDING='0' CELLSPACING='5' BORDER='0' WIDTH='100%' class="newspaneopen">
				<TR>
				    	<TD CLASS="componentHeading" WIDTH="100%"><?php echo $title;?></TD>
					<TD ALIGN="right"><A HREF="#" onClick="window.open('popups/faqwindow.php?id=<?php echo $artid; ?>&print=print', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');"><IMG SRC="images/printButton.gif" BORDER='0' ALT='Print'></A></TD>
					<TD><A HREF="#" onClick="window.open('emailfriend/emailfaq.php?id=<?php echo $artid; ?>', 'win2', 'status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=yes,width=350,height=200,directories=no,location=no');"><IMG SRC="images/emailButton.gif" BORDER='0' ALT="E-mail"></A></TD>
				</TR>
				<TR>
				    	<TD VALIGN="top" COLSPAN="3"><?php echo $content;?></TD>
				</TR>
				<TR>
			  	  	<TD COLSPAN="3" align="center"><A HREF='javascript:window.history.go(-1);'><?php echo _BACK; ?></A></TD>
				</TR>
			</TABLE>
	<?php }
}
?>
