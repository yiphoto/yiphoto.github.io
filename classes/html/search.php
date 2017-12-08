<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	27-11-2002
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: search.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 07-03-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_search.php');

class search {
		function openhtml(){?>
			<TABLE CELLPADDING='3' CELLSPACING='0' BORDER='0' WIDTH='100%' class="newspane">
			<TR>
				<TD CLASS='articlehead' COLSPAN='2'><?php echo _SEARCH_TITLE; ?></TD>
			</TR>
			<TR>
				<TD HEIGHT='20' COLSPAN='2'>&nbsp;</TD>
			</TR>
			<FORM ACTION='index.php' METHOD='post'>
			<TR>
				<TD COLSPAN='2'><INPUT class=inputbox TYPE='text' NAME='searchword' VALUE='<?php echo $search;?>' SIZE='30'>&nbsp;
				<INPUT class=button TYPE='submit' value='<?php echo _BUTTON_SEARCH; ?>'></TD>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='search'>
			</FORM>
			<TR>
				<TD HEIGHT='20' COLSPAN='2'>&nbsp;</TD>
			</TR>
		<?php }
		function nokeyword(){?>
			<TR>
				<TD WIDTH='100%' COLSPAN='2'><?php echo _PROMPT_CRITERIA; ?></TD>
			</TR>
		<?php }
		function searchintro($searchword) {?>
			<TR>
				<TD WIDTH='100%' COLSPAN='2'><?php echo _PROMPT_KEYWORD; ?> <B><?php echo $searchword; ?></B></TD>
			</TR>
			<TR>
				<TD>
		<?php }
		
		function stories($id, $title, $time, $text, $searchword, $popup) {?>
			<hr>
			<span class="componentheading"><?php echo _RESULTS_STORIES; ?></span><br>
			<?php echo _NUM_RESULTS; ?> <?php echo count($id); ?><BR><BR>
			<ul>
			<?php for ($i=0; $i<count($id); $i++) {
				if ($popup) { 
					echo "<li><A HREF='popups/newswindow.php?id=$id[$i]' TARGET='new'>$title[$i]</A>, <span class=\"small\">$time[$i]</span><br>\n";
				} else {
					echo "<li><A HREF='index.php?option=news&task=viewarticle&sid=$id[$i]'>$title[$i]</A>, <span class=\"small\">$time[$i]</span><br>\n";
				}
				$words = $text[$i];
				$words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
				$words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
				$words = preg_replace('/<!--.+?-->/','',$words);
				$words = preg_replace('/{.+?}/','',$words);
				$words = strip_tags($words);
				echo substr($words,0,200); ?>&#133;</li><BR><BR>
			<?php }?>
			</ul>
		<?php }
		function articles($id, $title, $time, $text, $searchword, $popup) {?>
			<hr>
			<span class="componentheading"><?php echo _RESULTS_ARTICLES; ?></span><br>
			<?php echo _NUM_RESULTS; ?> <?php echo count($id); ?><BR><BR>
			<ul>
			<?php for ($i=0; $i<count($id); $i++) {
				if ($popup) {
					echo "<li><A HREF='popups/articleswindow.php?id=$id[$i]' TARGET='new'>$title[$i]</A>, <span class=\"small\">$time[$i]</span><br>\n";
				} else {
					echo "<li><A HREF='index.php?option=articles&task=viewarticle&artid=$id[$i]'>$title[$i]</A>, <span class=\"small\">$time[$i]</span><br>\n";
				}
				$words = $text[$i];
				$words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
				$words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
				$words = preg_replace('/<!--.+?-->/','',$words);
				$words = preg_replace('/{.+?}/','',$words);
				$words = strip_tags($words);
				echo substr($words,0,300); ?>&#133;<BR><BR>
			<?php }?>
			</ul>
		<?php }
		function faqs($id, $title, $text, $searchword, $popup) {?>
			<hr>
			<span class="componentheading"><?php echo _RESULTS_FAQS; ?></span><br>
			<?php echo _NUM_RESULTS; ?> <?php echo count($id); ?><BR><BR>
			<ul>
			<?php for ($i=0; $i<count($id); $i++) {
				if ($popup) {
					echo "<li><A HREF='popups/faqwindow.php?id=$id[$i]' TARGET='new'>$title[$i]</A><br>\n";
				} else {
					echo "<li><A HREF='index.php?option=faq&task=viewfaq&artid=$id[$i]'>$title[$i]</A><br>\n";
				}
				$words = $text[$i];
				$words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
				$words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
				$words = preg_replace('/<!--.+?-->/','',$words);
				$words = preg_replace('/{.+?}/','',$words);
				$words = strip_tags($words);
				echo substr($words,0,200); ?>&#133;<BR><BR>
			<?php }?>
			</ul>
		<?php }
		function content($id, $mid, $heading, $content, $sublevel, $searchword) {?>
			<hr>
			<span class="componentheading"><?php echo _RESULTS_CONTENT; ?></span><br>
			<?php echo _NUM_RESULTS; ?> <?php echo count($id); ?><BR><BR>
			<ul>
			<?php for ($i=0; $i<count($id); $i++) {?>
				<li><A HREF='index.php?option=displaypage&Itemid=<?php echo $mid[$i]; ?>&op=page&SubMenu="<?php if ($sublevel[$i] == 0) echo $mid[$i]; ?>'><?php echo $heading[$i]; ?></A><br>
				<?php $words = $content[$i];
				$words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
				$words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
				$words = preg_replace('/<!--.+?-->/','',$words);
				$words = preg_replace('/{.+?}/','',$words);
				$words = strip_tags($words);
				echo substr($words,0,200); ?>&#133;<BR><BR>
			<?php }?>
			</ul>
		<?php }
		function weblinks($title, $url, $description, $searchword) {?>
			<hr>
			<span class="componentheading"><?php echo ("Weblinks");?></span><br>
			<?php echo _NUM_RESULTS; ?> <?php echo count($title); ?><BR><BR>
			<ul>
			<?php for ($i=0; $i<count($title); $i++) {?>
				<li><A HREF='<?php echo $url[$i];?>' target=\"_BLANK\"><?php echo $title[$i];?></a><BR><?php echo $description[$i];?></li>
			<?php }?></ul>
		<?php }
		function conclusion($totalRows, $searchword){?>
				</TD>
			</TR>
			<TR>

    <TD WIDTH='100%' COLSPAN='2'><?php eval ('print "'._CONCLUSION.'";'); ?> <a href="http://www.google.com/search?q=<?php echo $searchword; ?>" target=_blank><img src="images/M_images/google.gif" border=0 align="texttop"></TD>
			</TR>
		<?php }
		function closehtml(){?>
			</TABLE>
		<?php }
		}
?>
