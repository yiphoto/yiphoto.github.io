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
*	File Name: weblinks.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 27-11-2002
* 	Version #: 4.0.12
*	Comments:
**/

class weblinks {
	function showWeblinks($option, $weblinkshtml, $database, $dbprefix, $categories){
		$query = "SELECT categoryid, categoryname FROM ".$dbprefix."categories WHERE section='Weblinks'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$categoryid[$i] = $row->categoryid;
			$categoryname[$i] = $row->categoryname;
			$i++;
		}
		mysql_free_result($result);
		
		if ($categories == "all"){
			$query = "SELECT lid, title, published, checked_out, editor, approved FROM ".$dbprefix."links ORDER BY date";
			$result = $database->openConnectionWithReturn($query);
		}elseif ($categories == "new"){
			$query = "SELECT lid, title, published, checked_out, editor, approved FROM ".$dbprefix."links WHERE approved=0 ORDER BY date";
			$result = $database->openConnectionWithReturn($query);
		}elseif (($categories <> "all") && ($categories <> "")) {
			$query = "SELECT lid, title, published, checked_out, editor, approved FROM ".$dbprefix."links WHERE catid=$categories ORDER BY date";
			$result = $database->openConnectionWithReturn($query);
		}
		
		if ($categories <> ""){
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$lid[$i] = $row->lid;
				$title[$i] = $row->title;
				$published[$i] = $row->published;
				$checkedout[$i] = $row->checked_out;
				$editor[$i] = $row->editor;
				$approved[$i] =$row->approved;
				$i++;
			}
		}
		$weblinkshtml->showWeblinks($lid, $title, $option, $published, $checkedout, $editor, $categoryid, $categoryname, $categories, $approved);
	}
	
	function editWeblinks($weblinkshtml, $database, $dbprefix, $option, $cid, $myname, $categories){
		if ($cid == ""){
			print "<SCRIPT> alert('Please select a link to edit.'); window.history.go(-1); </SCRIPT>\n";
		}
		
		$query = "SELECT title, checked_out, editor FROM ".$dbprefix."links WHERE lid='$cid'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$checked = $row->checked_out;
			$title = $row->title;
			$editor = $row->editor;
		}
		
		$stringcmp = strcmp($editor,$myname);
		if (($checked == 1) && ($stringcmp <> 0)){
			print "<SCRIPT>alert('The web link $title is currently being edited by $editor'); document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			exit(0);
		}
		
		$date = date("H:i:s");
		$query = "UPDATE ".$dbprefix."links SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE lid='$cid'";
		$database->openConnectionNoReturn($query);
		
		$query = "SELECT lid, catid, title, description, url, ordering FROM ".$dbprefix."links WHERE lid=$cid";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$lid = $row->lid;
			$cid = $row->catid;
			$title = $row->title;
			$description = $row->description;
			$url = $row->url;
			$originalordering = $row->ordering;
		}
		mysql_free_result($result);
		$query = "SELECT MAX(ordering) AS maxnum FROM ".$dbprefix."links WHERE catid='$cid'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$maxnum = $row->maxnum;
		}
		
		$query = "SELECT categoryname, categoryid FROM ".$dbprefix."categories WHERE section='Weblinks'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		$ordering = Array();
		while ($row = mysql_fetch_object($result)){
			$categorycid[$i] = $row->categoryid;
			$categorytitle[$i] = $row->categoryname;
			$query = "SELECT * FROM ".$dbprefix."links WHERE catid=$categorycid[$i]";
			$result2 = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result2);
			$orderingcategory["$categorytitle[$i]"] = $count;
			
			$i++;
		}
		
		$weblinkshtml->editWeblinks($lid, $cid, $title, $description, $url, $option, $originalordering, $maxnum, $orderingcategory, $categorytitle, $categorycid, $categories);
	}
	
	function saveeditweblinks($database, $dbprefix, $option, $lid, $title, $description, $url, $category, $myname, $ordering, $porder, $cid, $categories){
		if (($title == "") || ($url == "") || ($category == "")){
			print "<SCRIPT> alert('Link must have title, url and category.'); window.history.go(-1); </SCRIPT>\n";
		}
		
		$query = "SELECT * FROM ".$dbprefix."links WHERE lid='$lid' AND checked_out=1 AND editor='$myname'";
		$result = $database->openConnectionWithReturn($query);
		$query = "UPDATE ".$dbprefix."links SET title='$title', description='$description', url='$url', catid='$category', checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE lid=$lid";
		$database->openConnectionNoReturn($query);
		print "<SCRIPT>document.location.href='index2.php?option=$option&cid%5B%5D=$lid&task=edit&categories=$categories'</SCRIPT>\n";
	}
	
	function addweblink($database, $dbprefix, $weblinkshtml, $option, $categories){
		$query = "SELECT categoryname, categoryid FROM ".$dbprefix."categories WHERE section='Weblinks'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		$ordering = Array();
		while ($row = mysql_fetch_object($result)){
			$categorycid[$i] = $row->categoryid;
			$categorytitle[$i] = $row->categoryname;
			$query = "SELECT * FROM ".$dbprefix."links WHERE catid=$categorycid[$i]";
			$result2 = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result2);
			$ordering["$categorytitle[$i]"] = $count;
			$i++;
		}
		mysql_free_result($result);
		$weblinkshtml->addweblinks($option, $categorycid, $categorytitle, $ordering, $categories);
	}
	
	function savenewweblink($database, $dbprefix, $option, $title, $description, $url, $category, $ordering, $categories){
		if (($title == "") || ($url == "") || ($category == "")){
			print "<SCRIPT> alert('Link must have title, url and category.'); window.history.go(-1); </SCRIPT>\n";
		}
		
		$date = date("Y-m-d G:i:s");
		
		$query = "INSERT INTO ".$dbprefix."links SET title='$title', description='$description', url='$url', catid='$category', date='$date'";
		$database->openConnectionNoReturn($query);
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function removeweblink($database, $dbprefix, $option, $cid, $categories){
		for ($i = 0; $i < count($cid); $i++){
			$query = "DELETE FROM ".$dbprefix."links WHERE lid='$cid[$i]'";
			$database->openConnectionNoReturn($query);
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function publishweblink($database, $dbprefix, $option, $cid, $lid, $categories){
		if (count($cid)){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out, approved FROM ".$dbprefix."links WHERE lid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$approved= $row->approved;
				}
				
				if ($checked == 1){
					print "<SCRIPT>alert('This Web Link cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
				}
				if ($approved == 0){
					print "<SCRIPT>alert('This Web Link cannot be published because it has not been approved yet'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
				}
				
				$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."links WHERE ".$dbprefix."links.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."links.lid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->catpub;
					$catid = $row->catid;
				}
				
				if ($isitpub == 0){
					$query = "UPDATE ".$dbprefix."links SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					$query = "UPDATE ".$dbprefix."categories SET published=1 WHERE categoryid='$catid'";
					$database->openConnectionNoReturn($query);
				}
				mysql_free_result($result);
				
				$query = "UPDATE ".$dbprefix."links SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		elseif (isset($lid)) {
			$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."links WHERE ".$dbprefix."links.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."links.lid='$lid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$isitpub = $row->catpub;
				$catid = $row->catid;
			}
			
			if ($isitpub == 0){
				$query = "UPDATE ".$dbprefix."links SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$lid'";
				$database->openConnectionNoReturn($query);
				$query = "UPDATE ".$dbprefix."categories SET published=1 WHERE categoryid='$catid'";
				$database->openConnectionNoReturn($query);
			}
			mysql_free_result($result);
			
			$query = "UPDATE ".$dbprefix."links SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$lid'";
			$database->openConnectionNoReturn($query);
		}
		else {
			print "<SCRIPT>alert('Select a Web link to publish'); window.history.go(-1);;</SCRIPT>\n";
			exit(0);
		}
		
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function unpublishweblink($database, $dbprefix, $option, $cid, $lid, $categories){
		if (count($cid) > 0){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out FROM ".$dbprefix."links WHERE lid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
				}
				
				if ($checked == 1){
					print "<SCRIPT>alert('This Web link cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
				}
				
				$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."links WHERE ".$dbprefix."links.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."links.lid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->catpub;
					$catid = $row->catid;
				}
				
				if ($isitpub == 1){
					$query = "UPDATE ".$dbprefix."links SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					//added this check 3/9/01
					if (mysql_num_rows($result) == 0){
						$query = "UPDATE ".$dbprefix."categories SET published=0 WHERE categoryid='$catid'";
						$database->openConnectionNoReturn($query);
					}
				}
				mysql_free_result($result);
				
				$query = "UPDATE ".$dbprefix."links SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
		}
		elseif (isset($lid)){
			$query = "SELECT ".$dbprefix."categories.published AS catpub, ".$dbprefix."categories.categoryid AS catid FROM ".$dbprefix."categories, ".$dbprefix."links WHERE ".$dbprefix."links.catid=".$dbprefix."categories.categoryid AND ".$dbprefix."links.lid='$lid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$isitpub = $row->catpub;
				$catid = $row->catid;
			}
			
			if ($isitpub == 1){
				$query = "UPDATE ".$dbprefix."links SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$lid'";
				$database->openConnectionNoReturn($query);
				
				$query = "SELECT * FROM ".$dbprefix."links WHERE published=1 AND lid='$lid'";
				$result = $database->openConnectionWithReturn($query);
				if (mysql_num_rows($result) == 0){
					$query = "UPDATE ".$dbprefix."categories SET published=0 WHERE categoryid='$catid'";
					$database->openConnectionNoReturn($query);
				}
			}
			mysql_free_result($result);
			
			$query = "UPDATE ".$dbprefix."links SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE lid='$lid'";
			$database->openConnectionNoReturn($query);
		}
		else {
			print "<SCRIPT>alert('Select a Web link to unpublish'); window.history.go(-1);;</SCRIPT>\n";
			exit(0);
		}
		
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
	
	function approvelink($database, $dbprefix, $option, $lid, $categories, $category, $url, $description, $title){
		$checkLink=eregi("http://", $url);
		if (!$checkLink){
			$url="http://".$url;
		}
		
		$query = "UPDATE ".$dbprefix."links SET approved=1, checked_out=0, checked_out_time='00:00:00', editor=NULL, catid=$category, url='$url', title='$title', description='$description', published='1' WHERE lid=$lid";
		$database->openConnectionNoReturn($query);
		
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
	}
}
?>
