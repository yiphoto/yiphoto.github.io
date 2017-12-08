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
*	File Name: category.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class category {
	function showcategory($database, $dbprefix, $option, $categoryhtml, $act){
		$query = "SELECT  categoryid, categoryname, published, checked_out, editor, access FROM ".$dbprefix."categories WHERE section='$option' ORDER BY categoryname";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$cid[$i] = $row->categoryid;
			$cname[$i] = $row->categoryname;
			$publish[$i] = $row->published;
			$checkedout[$i] = $row->checked_out;
			$editor[$i] = $row->editor;
			$access[$i] = $row->access;
			
			if ($option == "News"){
				$query = "SELECT * FROM ".$dbprefix."stories WHERE catid='$cid[$i]'";
			}
			elseif ($option == "Faq"){
				$query = "SELECT * FROM ".$dbprefix."faqcont WHERE catid=$cid[$i]";
			}
			elseif ($option == "Articles"){
				$query = "SELECT * FROM ".$dbprefix."articles WHERE catid=$cid[$i]";
			}
			elseif ($option == "Weblinks"){
				$query = "SELECT * FROM ".$dbprefix."links WHERE catid=$cid[$i]";
			}
			$result2 = $database->openConnectionWithReturn($query);
			$count[$i] = mysql_num_rows($result2);
			$i++;
		}
		mysql_free_result($result);
		
		/* Get Group Names for IDs */
		for ($g = 0; $g < count($access); $g++){
			$queryG = "SELECT name FROM ".$dbprefix."groups WHERE id='$access[$g]'";
			$resultG = $database->openConnectionWithReturn($queryG);
			while ($rowG = mysql_fetch_object($resultG)){
				$GNameSel[$g] = $rowG->name;
			}
		}
		
		$categoryhtml->showcategory($option, $cid, $cname, $act, $count, $publish, $checkedout, $editor, $GNameSel);
	}
	
	function editcategory($categoryhtml, $database, $dbprefix, $option, $uid, $act, $myname){
		$query = "SELECT categoryname, checked_out, editor FROM ".$dbprefix."categories WHERE categoryid='$uid'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$checked = $row->checked_out;
			$title = $row->categoryname;
			$editor = $row->editor;
		}
		$stringcmp = strcmp($editor,$myname);
		if (($checked == 1) && ($stringcmp <> 0)){
			print "<SCRIPT>alert('The category $title is currently being edited by another administrator'); document.location.href='index2.php?option=$option&act=categories'</SCRIPT>\n";
			exit(0);
		}
		
		$date = date("H:i:s");
		$query = "UPDATE ".$dbprefix."categories SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE categoryid='$uid'";
		$database->openConnectionNoReturn($query);
		
		$query = "SELECT categoryname FROM ".$dbprefix."categories WHERE categoryid='$uid'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$cname = $row->categoryname;
		}
		mysql_free_result($result);
		
		/* Get list of groups */
		$queryG = "SELECT id, name FROM ".$dbprefix."groups ORDER BY id";
		$resultG = $database->openConnectionWithReturn($queryG);
		$g = 0;
		while ($rowG = mysql_fetch_object($resultG)){
			$Gid[$g] = $rowG->id;
			$Gname[$g] = $rowG->name;
			$g++;
		}
		
		/* Get currently applied group */
		$queryG = "SELECT access FROM ".$dbprefix."categories WHERE categoryid='$uid'";
		$resultG = $database->openConnectionWithReturn($queryG);
		$i = 0;
		while ($rowG = mysql_fetch_object($resultG)){
			$GIDSel[$i] = $rowG->access;
		}
		
		$categoryhtml->editcategory($option, $cname, $uid, $act, $Gid, $Gname, $GIDSel);
	}
	
	function savecategory($categoryhtml, $database, $dbprefix, $option, $categoryname, $image, $act, $uid, $pname, $position, $access){
		if ($categoryname == ""){
			print "<SCRIPT> alert('Your Category must contain a title.'); window.history.go(-1); </SCRIPT>\n";
		}
		
		if ($pname <> $categoryname){
			$query = "SELECT * FROM ".$dbprefix."categories WHERE categoryname='$categoryname' AND section='$option'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				print "<SCRIPT>alert('There is a category already with that name, please try again!'); document.location.href='index2.php?option=$option&act=$act&cid=$uid'</SCRIPT>\n";
				exit(0);
			}
		}
		
		$query = "UPDATE ".$dbprefix."categories SET categoryname='$categoryname', checked_out=0, checked_out_time = '00:00:00', editor=NULL, access='$access' WHERE categoryid='$uid'";
		$database->openConnectionNoReturn($query);
		print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories'</SCRIPT>\n";
	}
	
	function newcategory($database, $dbprefix, $option, $act, $categoryhtml){
		
		/* Get list of groups */
		$queryG = "SELECT id, name FROM ".$dbprefix."groups ORDER BY id";
		$resultG = $database->openConnectionWithReturn($queryG);
		$g = 0;
		while ($rowG = mysql_fetch_object($resultG)){
			$Gid[$g] = $rowG->id;
			$Gname[$g] = $rowG->name;
			$g++;
		}
		
		$categoryhtml->addcategory($option, $act, $Gid, $Gname);
	}
	
	function savenewcategory($option, $database, $dbprefix, $categoryname, $act, $access){
		if ($categoryname == ""){
			print "<SCRIPT> alert('Your Category must contain a title.'); window.history.go(-1); </SCRIPT>\n";
		}
		
		$query = "SELECT categoryid FROM ".$dbprefix."categories WHERE categoryname='$categoryname' AND section='$option'";
		$result = $database->openConnectionWithReturn($query);
		if (mysql_num_rows($result) > 0){
			print "<SCRIPT>alert('There is a category already with that name, please try again!'); window.history.go(-1);</SCRIPT>\n";
			exit(0);
		}
		
		$query = "INSERT INTO ".$dbprefix."categories SET categoryname='$categoryname', section='$option', access='$access'";
		$database->openConnectionNoReturn($query);
		//print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories'</SCRIPT>\n";
		print "<SCRIPT>document.location.href='index2.php?option=$option&act=$act'</SCRIPT>\n";
	}
	
	function removecategory($database, $dbprefix, $option, $cid, $act){
		if (count($cid) == 0){
			print "<SCRIPT>alert('Please select a category to delete'); window.history.go(-1);</SCRIPT>\n";
		}
		
		for ($i = 0; $i < count($cid); $i++){
			$query = "SELECT categoryname FROM ".$dbprefix."categories WHERE categoryid='$cid[$i]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$name = $row->categoryname;
			}
			mysql_free_result($result);
			
			if ($option == "News"){
				$query = "SELECT * FROM ".$dbprefix."stories WHERE catid='$cid[$i]'";
			}
			elseif ($option == "Faq"){
				$query = "SELECT * FROM ".$dbprefix."faqcont WHERE catid=$cid[$i]";
			}
			elseif ($option == "Articles"){
				$query = "SELECT * FROM ".$dbprefix."articles WHERE catid=$cid[$i]";
			}
			elseif ($option == "Weblinks"){
				$query = "SELECT * FROM ".$dbprefix."links WHERE catid=$cid[$i]";
			}
			
			$result = $database->openConnectionWithReturn($query);
			
			if (mysql_num_rows($result) > 0){
				print "<SCRIPT>alert('Category $name cannot be removed, contains stories');</SCRIPT>\n";
			}
			else {
				$query = "DELETE FROM ".$dbprefix."categories WHERE categoryid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&act=$act'</SCRIPT>\n";
	}
	
	function publishcategory($option, $database, $dbprefix, $uid, $cid, $image, $categoryname, $position){
		if (count($cid) > 0){
			$count = count($cid);
			for ($i = 0; $i < $count; $i++){
				if ($option == "News"){
					$query = "SELECT checked_out FROM ".$dbprefix."stories WHERE sid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
					}
					
					if ($checked == 1){
						print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
					}
					
					for ($i = 0; $i < count($cid); $i++){
						$query = "SELECT sid FROM ".$dbprefix."stories WHERE catid='$cid[$i]' and published=1";
						$result = $database->openConnectionWithReturn($query);
						if (mysql_num_rows($result)==0){
							$query2="select categoryname from ".$dbprefix."categories where categoryid='$cid[$i]'";
							$result2=$database->openConnectionWithReturn($query2);
							list($catname)=mysql_fetch_array($result2);
							$pat="'";
							$replace="\\'";
							$catname=eregi_replace($pat, $replace, $catname);
							print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published news'); </SCRIPT>\n";
						}
						else {
							$query = "UPDATE ".$dbprefix."categories SET published='1' WHERE categoryid='$cid[$i]'";
							$database->openConnectionNoReturn($query);
						}
					}
				}
				elseif ($option == "Weblinks"){
					$query = "SELECT checked_out FROM ".$dbprefix."links WHERE catid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
					}
					
					if ($checked == 1){
						print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
					}
					
					for ($j = 0; $j < count($cid); $j++){
						$query = "SELECT lid FROM ".$dbprefix."links WHERE catid='$cid[$i]' and published=1";
						$result = $database->openConnectionWithReturn($query);
						if (mysql_num_rows($result)==0){
							$query2="select categoryname from ".$dbprefix."categories where categoryid='$cid[$i]'";
							$result2=$database->openConnectionWithReturn($query2);
							list($catname)=mysql_fetch_array($result2);
							$pat="\'";
							$replace="\\\\'";
							$catname=eregi_replace($pat, $replace, $catname);
							$pat="'";
							$replace="\\'";
							$catname=eregi_replace($pat, $replace, $catname);
							print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published links'); </SCRIPT>\n";
						}
						else {
							$query = "UPDATE ".$dbprefix."categories SET published='1' WHERE categoryid='$cid[$j]'";
							$database->openConnectionNoReturn($query);
						}
					}
				}
				elseif ($option == "Faq"){
					$query = "SELECT checked_out FROM ".$dbprefix."faqcont WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
					}
					
					if ($checked == 1){
						print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
					}
					
					for ($i = 0; $i < count($cid); $i++){
						$query = "SELECT artid FROM ".$dbprefix."faqcont WHERE catid='$cid[$i]' and published=1";
						$result = $database->openConnectionWithReturn($query);
						if (mysql_num_rows($result)==0){
							$query2="select categoryname from ".$dbprefix."categories where categoryid='$cid[$i]'";
							$result2=$database->openConnectionWithReturn($query2);
							list($catname)=mysql_fetch_array($result2);
							$pat="'";
							$replace="\\'";
							$catname=eregi_replace($pat, $replace, $catname);
							print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published faqs'); </SCRIPT>\n";
						}
						else {
							$query = "UPDATE ".$dbprefix."categories SET published='1' WHERE categoryid='$cid[$i]'";
							$database->openConnectionNoReturn($query);
						}
					}
				}
				elseif ($option == "Articles"){
					$query = "SELECT checked_out FROM ".$dbprefix."articles WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
					}
					
					if ($checked == 1){
						print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
					}
					
					for ($i = 0; $i < count($cid); $i++){
						$query = "SELECT * FROM ".$dbprefix."articles WHERE catid='$cid[$i]'";
						$result = $database->openConnectionWithReturn($query);
						if (mysql_num_rows($result) > 0){
							$query = "SELECT artid FROM ".$dbprefix."articles WHERE catid='$cid[$i]' and published=1";
							$result = $database->openConnectionWithReturn($query);
							if (mysql_num_rows($result)==0){
								$query2="select categoryname from ".$dbprefix."categories where categoryid='$cid[$i]'";
								$result2=$database->openConnectionWithReturn($query2);
								list($catname)=mysql_fetch_array($result2);
								$pat="'";
								$replace="\\'";
								$catname=eregi_replace($pat, $replace, $catname);
								print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published articles');</SCRIPT>\n";
							}
							else {
								$query = "UPDATE ".$dbprefix."categories SET published='1' WHERE categoryid='$cid[$i]'";
								$database->openConnectionNoReturn($query);
							}
						}
						else {
							print "<SCRIPT>alert('Cannot publish category, doesn\'t contain articles');</SCRIPT>\n";
						}
					}
				}
			}
		}
		elseif (isset($uid)){
			if ($option == "Articles"){
				$query = "SELECT * FROM ".$dbprefix."articles WHERE catid='$uid'";
				$result = $database->openConnectionWithReturn($query);
				if (mysql_num_rows($result) > 0){
					$query = "UPDATE ".$dbprefix."categories SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
				}
				else {
					$query = "UPDATE ".$dbprefix."categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
					print "<SCRIPT>alert('Category cannot be published because it contains no articles.');</SCRIPT>\n";
				}
			}
			if ($option == "News"){
				$query = "SELECT * FROM ".$dbprefix."stories WHERE catid='$uid'";
				$result = $database->openConnectionWithReturn($query);
				if (mysql_num_rows($result) > 0){
					$query = "UPDATE ".$dbprefix."categories SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
				}
				else {
					$query = "UPDATE ".$dbprefix."categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
					print "<SCRIPT>alert('Category cannot be published because it contains no news.');</SCRIPT>\n";
				}
			}
			if ($option == "Faq"){
				$query = "SELECT * FROM ".$dbprefix."faqcont WHERE catid='$uid'";
				$result = $database->openConnectionWithReturn($query);
				if (mysql_num_rows($result) > 0){
					$query = "UPDATE ".$dbprefix."categories SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
				}
				else {
					$query = "UPDATE ".$dbprefix."categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
					print "<SCRIPT>alert('Category cannot be published because it contains no faq\'s.');</SCRIPT>\n";
				}
			}
			if ($option == "Weblinks"){
				$query = "SELECT * FROM ".$dbprefix."links WHERE catid='$uid'";
				$result = $database->openConnectionWithReturn($query);
				if (mysql_num_rows($result) > 0){
					$query = "UPDATE ".$dbprefix."links SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
				}
				else {
					$query = "UPDATE ".$dbprefix."categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
					$database->openConnectionNoReturn($query);
					print "<SCRIPT>alert('Category cannot be published because it contains no weblinks.');</SCRIPT>\n";
				}
			}
		}
		else {
			print "<SCRIPT> alert('Select a category to publish'); window.history.go(-1);</SCRIPT>\n";
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories';</SCRIPT>\n";
	}
	
	function unpublishcategory($option, $database, $dbprefix, $uid, $cid){
		if (count($cid) > 0){
			$query = "SELECT checked_out FROM ".$dbprefix."stories WHERE sid='$cid[0]'";
			$result = $database->openConnectionWithReturn($query);
			
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
			}
			
			if ($checked == 1){
				print "<SCRIPT>alert('This category cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
				exit(0);
			}
			
			for ($i = 0; $i < count($cid); $i++){
				$query = "UPDATE ".$dbprefix."categories SET published='0' WHERE categoryid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		elseif (isset($uid)){
			$query = "UPDATE ".$dbprefix."categories SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
			$database->openConnectionNoReturn($query);
		}
		else {
			print "<SCRIPT> alert('Select a category to unpublish'); window.history.go(-1);</SCRIPT>\n";
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories';</SCRIPT>\n";
	}
}
?>