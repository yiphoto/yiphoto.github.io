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
*	File Name: weblinks.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 31-01-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_weblinks.php');

class weblinks {
		function displaylist($catidtext, $catidid, $num, $title, $description, $sid, $id, $date, $url, $noauth_catidtext){ global $Itemid; ?>
			<FORM NAME="news">

  <TABLE WIDTH="98%" CELLPADDING="4" CELLSPACING="4" BORDER="0" ALIGN="center" class="newspane">
    <TR>
      <TD colspan="2">
        <p CLASS="articlehead"><?php echo _WEBLINKS_TITLE; ?></p>
      </TD>
    </TR>
    <TR>
      <TD width="60%" valign="top" class="newsarticle">
        <p><?php echo _WEBLINKS_DESC; ?></p>
        <p>
		<ul>
	<?php 	for ($i = 0; $i < count($catidid); $i++){
		if (($id == $i) && ($id <> "")){
			echo "<li><b>$catidtext[$i]</b>&nbsp;<span class=small>($num[$i])</span></li>";
		} else {
			echo "<li><a class=category href='index.php?option=weblinks&Itemid=$Itemid&topid=$i'>$catidtext[$i]</a>&nbsp;<span class=small>($num[$i])</span></li>";
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
      <TD width="40%" VALIGN=TOP><IMG SRC=images/M_images/web_links.jpg ALIGN=right HSPACE=6 ALT="Weblinks Section"></TD>
    </TR>
    <TR>
      <TD VALIGN="top" colspan="2">
        <?php 	if ($id <> ""){?>
        <hr noshade size="1">
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
								$sum = $todaydate[2] - $datesplit[0];?>
            <td width="32" height="20" align="center"><img src="images/M_images/wwwicon.gif" width="32" height="16" align="absbottom" vspace="3" hspace="10"></td>
            <td width="100%" height="20"><A HREF="<?php print $url["$catidtext[$id]"][$i]; ?>" TARGET="new">
              <?php print $title["$catidtext[$id]"][$i]; ?>
              </A><br><?php print $description["$catidtext[$id]"][$i]; ?></td>
          </tr>
          <?php 		if ($k == 1){
          	$k = 0;
          }
          else {
          	$k++;
          }
								}?>
        </table>
        <?php 		} ?>
      </TD>
    </TR>
  </TABLE>
			</FORM>
		<?php 	}
}
?>
