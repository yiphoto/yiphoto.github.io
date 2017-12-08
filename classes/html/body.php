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
*	File Name: body.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments: Function displays selected weblink category and titles from the database.
**/

include('language/'.$lang.'/lang_body.php');

class body {
	function indexbody($sid, $author, $introtext, $fultext, $title, $time, $newsimage, $imageposition, $col_main, $gid, $access){
		
		$columns=$col_main;
		$counter=0;
		$i=0;
		print "<table border='0' cellspacing='0' cellpadding='6' class='newspane'>";
		while ($i < count($sid)){
			if ($counter==0) {
				print "<tr>";
			}
			print "<td width='50%' valign='top'>";
			print "<span class='articlehead'>$title[$i]</span><br><br>";
			print "<span class='small'>$time[$i]";
			print "</span><br>";
			if ($newsimage[$i] != ""){
				$qtitle = htmlspecialchars( $title[$i], ENT_QUOTES );
				$size = getimagesize("images/stories/$newsimage[$i]");
				print "<IMG SRC='images/stories/$newsimage[$i]' HSPACE='12' VSPACE='12'
				ALIGN='$imageposition[$i]' WIDTH='$size[0]' HEIGHT='$size[1]' ALT='$qtitle'>";
			}
			print "<span class='newsarticle'>$introtext[$i]</span><br>";
			if ($fultext[$i] !=""){
			    if($access[$i] > $gid){
			    	print "Login or <a href='index.php?option=registration&task=register'>Register</a> to Read On...";
			    }else{
				print "<a href='index.php?option=news&task=viewarticle&sid=$sid[$i]'>";
				print "<span class='small'>"._READ_ON."</span></a>";
				}
				
			}
			print "</td>";
			$i++;
			$counter++;
			if ($counter==$columns){
				$counter=0;
				print "</tr>";
			}
		}
		print "</table>";
	}
}
?>
