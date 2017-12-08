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
*	File Name: faq.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class faq {
	function showFaq($database, $dbprefix, $option, $faqhtml, $categories){
		$query = "SELECT categoryid, categoryname FROM ".$dbprefix."categories WHERE section='Faq'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$categoryid[$i] = $row->categoryid;
			$categoryname[$i] = $row->categoryname;
			$i++;
		}
		mysql_free_result($result);
		
		if ($categories == "all"){
			$query = "SELECT artid, title, published, checked_out, editor, archived, approved FROM ".$dbprefix."faqcont";
		}elseif ($categories=="new") {
			$query = "SELECT artid, title, published, checked_out, editor, archived, approved FROM ".$dbprefix."faqcont WHERE approved=0";
		}elseif ($categories <> ""){
			$query = "SELECT artid, title, published, checked_out, editor, archived, approved FROM ".$dbprefix."faqcont WHERE catid=$categories";
		}
		
		if ($categories!=""){
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$artid[$i] = $row->artid;
				$title[$i] = $row->title;
				$published[$i] = $row->published;
				$editor[$i] = $row->editor;
				$checkedout[$i] = $row->checked_out;
				$archived[$i] = $row->archived;
				$approved[$i] = $row->approved;
				$i++;
			}
		}
		$faqhtml->showFaq($option, $artid, $title, $published, $editor, $archived, $checkedout, $categoryid, $categoryname, $categories, $approved);
	}
	
	function editFaq($faqhtml, $database, $dbprefix, $option, $id, $myname, $categories, $text_editor){
		$query = "SELECT title, checked_out, editor FROM ".$dbprefix."faqcont WHERE artid='$id'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$checked = $row->checked_out;
			$title = $row->title;
			$editor = $row->editor;
		}
		
		$stringcmp = strcmp($editor,$myname);
		if (($checked == 1) && ($stringcmp <> 0)){
			print "<SCRIPT>alert('The story $title is currently being edited by $editor'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
			exit(0);
		}
		
		$date = date("H:i:s");
		$query = "UPDATE ".$dbprefix."faqcont SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE artid='$id'";
		$database->openConnectionNoReturn($query);
		
		$query = "SELECT ".$dbprefix."faqcont.artid AS artid, ".$dbprefix."faqcont.catid AS catid, ".$dbprefix."faqcont.ordering AS ordering, ".$dbprefix."faqcont.title AS title, ".$dbprefix."faqcont.content AS content, ".$dbprefix."categories.categoryid AS faqcategoryid, ".$dbprefix."categories.categoryname AS faqcategoryname FROM ".$dbprefix."faqcont, ".$dbprefix."categories
					  WHERE ".$dbprefix."faqcont.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."faqcont.artid='$id'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$artid = $row->artid;
			$title = $row->title;
			$content = $row->content;
			$catid = $row->catid;
			$faqcategoryid = $row->faqcategoryid;
			$faqcategoryname = $row->faqcategoryname;
			$orderingfaq = $row->ordering;
		}
		
		mysql_free_result($result);
		
		$query = "SELECT MAX(ordering) AS maxnum FROM ".$dbprefix."faqcont WHERE catid='$faqcategoryid'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$maxnum = $row->maxnum;
		}
		
		$query = "SELECT categoryname, categoryid FROM ".$dbprefix."categories WHERE section='Faq'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		$ordering = Array();
		while ($row = mysql_fetch_object($result)){
			$categorycid[$i] = $row->categoryid;
			$categorytitle[$i] = $row->categoryname;
			$query = "SELECT * FROM ".$dbprefix."faqcont WHERE catid=$categorycid[$i]";
			$result2 = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result2);
			$ordering["$categorytitle[$i]"] = $count;
			$i++;
		}
		$faqhtml->editFaq($artid, $title, $content, $categoryid, $categoryname, $faqcategoryid, $faqcategoryname, $option, $ordering, $maxnum, $categorycid, $categorytitle, $catid, $orderingfaq, $categories, $text_editor);
	}
	
	function saveeditfaq($faqhtml, $database, $dbprefix, $option, $title, $section, $content, $artid, $myname, $ordering, $porder, $categories, $pcategory){
		if (($title == "") || ($content == "")){
			print "<SCRIPT> alert('A FAQ must contain and title and content.'); window.history.go(-1); </SCRIPT>\n";
		}
		if (!get_magic_quotes_gpc()) {
			$title = addslashes($title);
			$content = addslashes($content);
		}
		$query = "UPDATE ".$dbprefix."faqcont SET catid='$section', title='$title', content='$content', ordering='$ordering', checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE artid='$artid'";
		$database->openConnectionNoReturn($query);
		
		print "<SCRIPT>document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$artid&categories=$categories'</SCRIPT>\n";
	}
	
	function addFaq($faqhtml, $database, $dbprefix, $option, $text_editor, $categories){
		$query = "SELECT categoryname, categoryid FROM ".$dbprefix."categories WHERE section='Faq'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		$ordering = Array();
		while ($row = mysql_fetch_object($result)){
			$categorycid[$i] = $row->categoryid;
			$categorytitle[$i] = $row->categoryname;
			$query = "SELECT * FROM ".$dbprefix."faqcont WHERE catid=$categorycid[$i]";
			$result2 = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result2);
			$ordering["$categorytitle[$i]"] = $count;
			$i++;
		}
		$faqhtml->addFaq($option, $categorycid, $categorytitle, $ordering, $text_editor, $categories);
	}
	
	function savefaq($database, $dbprefix, $option, $title, $section, $content, $ordering, $categories){
		if (($title == "") || ($content == "")){
			print "<SCRIPT> alert('A FAQ must contain and title and content.'); window.history.go(-1); </SCRIPT>\n";
		}
		if (!get_magic_quotes_gpc()) {
			$title = addslashes($title);
			$content = addslashes($content);
		}
		$query = "INSERT INTO ".$dbprefix."faqcont SET catid='$section', title='$title', content='$content', ordering='$ordering'";
		$database->openConnectionNoReturn($query);
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function removefaq($database, $dbprefix, $option, $cid, $categories){
		for ($i = 0; $i < count($cid); $i++){
			$query = "SELECT catid FROM ".$dbprefix."faqcont WHERE artid='$cid[$i]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$catid = $row->catid;
			}
			
			$query = "DELETE FROM ".$dbprefix."faqcont WHERE artid='$cid[$i]'";
			$database->openConnectionNoReturn($query);
			
			$query = "SELECT * FROM ".$dbprefix."faqcont WHERE catid='$catid'";
			$result = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result);
			if ($count == 0){
				$query = "UPDATE ".$dbprefix."categories SET published=0 WHERE categoryid='$catid'";
				$database->openConnectionNoReturn($query);
			}
		}
		
		$query = "SELECT artid FROM ".$dbprefix."faqcont WHERE catid='$catid' ORDER BY ordering";
		$result = $database->openConnectionWithReturn($query);
		$i = 1;
		while ($row = mysql_fetch_object($result)){
			$sid = $row->artid;
			$query = "UPDATE ".$dbprefix."faqcont SET ordering=$i WHERE artid=$sid";
			$database->openConnectionNoReturn($query);
			$i++;
		}
		
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function publishfaq($database, $dbprefix, $option, $cid, $artid, $myname, $categories){
		if (count($cid) > 0){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out, approved FROM ".$dbprefix."faqcont WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$approved = $row->approved;
				}
				
				if ($checked == 1){
					print "<SCRIPT>alert('This faq cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
				}
				
				if ($approved == 0){
					print "<SCRIPT>alert('This faq cannot be published because it has not been approved'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
				}
				
				$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."faqcont WHERE ".$dbprefix."faqcont.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."faqcont.artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->catpub;
					$catid = $row->catid;
				}
				
				if ($isitpub == 0){
					$query = "UPDATE ".$dbprefix."faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					$query = "UPDATE ".$dbprefix."categories SET published=1 WHERE categoryid='$catid'";
					$database->openConnectionNoReturn($query);
				}
				mysql_free_result($result);
				
				$query = "UPDATE ".$dbprefix."faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		elseif (isset($artid)) {
			$query = "SELECT checked_out, editor, approved FROM ".$dbprefix."faqcont WHERE artid='$artid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$editor = $row->editor;
				$approved = $row->approved;
			}
			
			if (($checked == 1) && ($editor <> $myname)){
				print "<SCRIPT>alert('This faq cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				exit(0);
			}
			
			if ($approved == 0){
				print "<SCRIPT>alert('This faq cannot be published because it has not been approved'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				exit(0);
			}
			
			$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."faqcont WHERE ".$dbprefix."faqcont.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."faqcont.artid='$artid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$isitpub = $row->catpub;
				$catid = $row->catid;
			}
			
			if ($isitpub == 0){
				$query = "UPDATE ".$dbprefix."faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				$query = "UPDATE ".$dbprefix."categories SET published=1 WHERE categoryid='$catid'";
				$database->openConnectionNoReturn($query);
			}
			mysql_free_result($result);
			
			$query = "UPDATE ".$dbprefix."faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
			$database->openConnectionNoReturn($query);
		}else{
			print "<SCRIPT>alert('Please select a faq to publish'); window.history.go(-1);</SCRIPT>\n";
		}
		
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function unpublishfaq($database, $dbprefix, $option, $cid, $artid, $myname, $categories){
		if (count($cid) > 0){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out FROM ".$dbprefix."faqcont WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
				}
				
				if ($checked == 1){
					print "<SCRIPT>alert('This faq cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
					exit(0);
				}
				
				$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."faqcont WHERE ".$dbprefix."faqcont.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."faqcont.artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->catpub;
					$catid = $row->catid;
				}
				
				if ($isitpub == 1){
					$query = "UPDATE ".$dbprefix."faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					//added this check 3/9/01
					if (mysql_num_rows($result) == 0){
						$query = "UPDATE ".$dbprefix."categories SET published=0 WHERE categoryid='$catid'";
						$database->openConnectionNoReturn($query);
					}
				}
				mysql_free_result($result);
				
				$query = "UPDATE ".$dbprefix."faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		elseif (isset($artid)){
			$query = "SELECT checked_out, editor FROM ".$dbprefix."faqcont WHERE artid='$artid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$editor = $row->editor;
			}
			
			if (($checked == 1) && ($editor <> $myname)){
				print "<SCRIPT>alert('This faq cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				exit(0);
			}
			
			$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."faqcont WHERE ".$dbprefix."faqcont.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."faqcont.artid='$artid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$isitpub = $row->catpub;
				$catid = $row->catid;
			}
			
			if ($isitpub == 1){
				$query = "UPDATE ".$dbprefix."faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				//added this check 3/9/01
				if (mysql_num_rows($result) == 0){
					$query = "UPDATE ".$dbprefix."categories SET published=0 WHERE categoryid='$catid'";
					$database->openConnectionNoReturn($query);
				}
			}
			mysql_free_result($result);
			
			$query = "UPDATE ".$dbprefix."faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
			$database->openConnectionNoReturn($query);
		}else{
			print "<SCRIPT>alert('Please select a faq to unpublish'); window.history.go(-1);</SCRIPT>\n";
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function archivefaq($database, $dbprefix, $option, $cid, $categories){
		if (count($cid) == 0){
			print "<SCRIPT> alert('Please select an faq to archive'); window.history.go(-1); </SCRIPT>\n";
		}
		for ($i = 0; $i < count($cid); $i++){
			$query = "SELECT checked_out, approved FROM ".$dbprefix."faqcont WHERE artid='$cid[$i]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$approved = $row->approved;
			}
			
			if ($checked == 1){
				print "<SCRIPT>alert('This faq cannot be archived because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				exit(0);
			}
			
			if ($approved == 0){
				print "<SCRIPT>alert('This faq cannot be archived because it has not been approved'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				exit(0);
			}
			
			$query = "UPDATE ".$dbprefix."faqcont SET archived=1 WHERE artid='$cid[$i]'";
			$database->openConnectionNoReturn($query);
			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
		}
	}
	
	function unarchivefaq($database, $dbprefix, $option, $cid, $categories){
		if (count($cid) == 0){
			print "<SCRIPT> alert('Please select an faq to unarchive'); window.history.go(-1); </SCRIPT>\n";
		}
		
		for ($i = 0; $i < count($cid); $i++){
			$query = "SELECT checked_out FROM ".$dbprefix."faqcont WHERE artid='$cid[$i]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
			}
			
			if ($checked == 1){
				print "<SCRIPT>alert('This faq cannot be archive because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
				exit(0);
			}
			
			$query = "UPDATE ".$dbprefix."faqcont SET archived=0 WHERE artid='$cid[$i]'";
			$database->openConnectionNoReturn($query);
			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
		}
	}
	
	function approvefaq($database, $dbprefix, $option, $artid, $categories, $category, $content, $title){
		$query = "UPDATE ".$dbprefix."faqcont SET approved=1, checked_out=0, checked_out_time='00:00:00', editor=NULL, catid=$category, content='$content', title='$title', published='1' WHERE artid=$artid";
		$database->openConnectionNoReturn($query);
		
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
}?>	
