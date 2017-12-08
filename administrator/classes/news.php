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
*	File Name: news.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*				Emir Sakic - saka@hotmail.com
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/

class news {
	function viewNews($database, $dbprefix, $newshtml, $option, $categories, $offset){
		$rows_per_page=10;		// set how many rows per page you want displayed
		if (empty($offset)) $offset=1;
		$from = ($offset-1) * $rows_per_page;

		$query = "SELECT categoryid, categoryname FROM ".$dbprefix."categories WHERE section='News'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$categoryid[$i] = $row->categoryid;
			$categoryname[$i] = $row->categoryname;
			$i++;
		}
		mysql_free_result($result);


		if ($categories == "all"){
			$count_query = "SELECT sid FROM ".$dbprefix."stories";
			$query = "SELECT sid, title, author, newsimage, published, checked_out, editor, archived, frontpage, approved, access FROM ".$dbprefix."stories ORDER BY ordering LIMIT $from, $rows_per_page";
		}elseif ($categories == "new"){
			$count_query = "SELECT sid FROM ".$dbprefix."stories WHERE approved=0";
			$query = "SELECT sid, title, author, newsimage, published, checked_out, editor, archived, frontpage, approved, access FROM ".$dbprefix."stories WHERE approved=0 ORDER BY ordering LIMIT $from, $rows_per_page";
		}elseif ($categories == "home"){
			$count_query = "SELECT sid FROM ".$dbprefix."stories WHERE frontpage=1";
			$query = "SELECT sid, title, author, newsimage, published, checked_out, editor, archived, frontpage, approved, access FROM ".$dbprefix."stories WHERE frontpage=1 ORDER BY ordering LIMIT $from, $rows_per_page";
		}elseif ($categories !=""){
			$count_query = "SELECT sid FROM ".$dbprefix."stories WHERE catid=$categories";
			$query = "SELECT sid, title, author, newsimage, published, checked_out, editor, archived, frontpage, approved, access FROM ".$dbprefix."stories WHERE catid=$categories ORDER BY ordering LIMIT $from, $rows_per_page";
		}

		if ($categories!=""){
			$count_result = $database->openConnectionWithReturn($count_query);
			$count = mysql_num_rows($count_result);
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$id[$i] = $row->sid;
				$title[$i] = $row->title;
				$author[$i] = $row->author;
				$newsimage[$i] = $row->newsimage;
				$published[$i] = $row->published;
				$checkedout[$i] = $row->checked_out;
				$editor[$i] = $row->editor;
				$archived[$i] = $row->archived;
				$frontpage[$i] = $row->frontpage;
				$approved[$i] = $row->approved;
				$access[$i] = $row->access;
				$i++;
			}
		}

		/* jimijon                 */
		/* Get Group Names for IDs */
		for ($g = 0; $g < count($access); $g++){
			$queryG = "SELECT name FROM ".$dbprefix."groups WHERE id='$access[$g]'";
			$resultG = $database->openConnectionWithReturn($queryG);
			while ($rowG = mysql_fetch_object($resultG)){
				$GNameSel[$g] = $rowG->name;
			}
		}

		$newshtml->showNews($id, $title, $author, $newsimage, $option, $published, $checkedout, $editor, $archived, $categoryid, $categoryname, $categories, $frontpage, $approved, $GNameSel, $count, $offset, $rows_per_page);
	}

	function newNews($database, $dbprefix, $newshtml, $option, $text_editor, $categories){
		require ("../configuration.php");
		$handle = opendir($image_path);
		$i = 0;
		while ($file = readdir($handle)) {
			if (($file <> ".") && ($file <> "..")){
				$imagename[$i] = $file;
				$i++;
			}
		}
		closedir($handle);

		$query = "SELECT categoryid, categoryname FROM ".$dbprefix."categories WHERE section='$option'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$catidid[$i] = $row->categoryid;
			$catidtext[$i] = $row->categoryname;
			$i++;
		}
		mysql_free_result($result);

		$query = "SELECT * FROM ".$dbprefix."stories WHERE frontpage=1";
		$result = $database->openConnectionWithReturn($query);
		$frontpagecount = mysql_num_rows($result);
		mysql_free_result($result);

		$query = "SELECT * FROM ".$dbprefix."stories WHERE frontpage=0";
		$result = $database->openConnectionWithReturn($query);
		$restcount = mysql_num_rows($result);
		mysql_free_result($result);

		/* jimijon            */
		/* Get list of groups */
		$queryG = "SELECT id, name FROM ".$dbprefix."groups ORDER BY id";
		$resultG = $database->openConnectionWithReturn($queryG);
		$g = 0;
		while ($rowG = mysql_fetch_object($resultG)){
			$Gid[$g] = $rowG->id;
			$Gname[$g] = $rowG->name;
			$g++;
		}

		$newshtml->addNews($option, $catidtext, $catidid, $id, $imagename, $restcount, $frontpagecount, $text_editor, $categories, $Gid, $Gname);
	}

	function saveNewNews($database, $dbprefix, $option, $author, $introtext, $fultext, $catid, $image, $title, $ordering, $position, $frontpage, $categories, $access){
		//if (($introtext == "") || ($catid == "") || ($fultext == "") || ($image == "")){
		if (($introtext == "") || ($catid == "")){
			print "<SCRIPT>alert('News must have an introduction and belong to a catid'); window.history.go(-1);</SCRIPT>\n";
			exit(0);
		}

		if ($frontpage == 1){
			shiftup($database, $dbprefix,999999999,$ordering);
		}

		if ($frontpage <> 1){
			$frontpage = 0;
		}
		if (!get_magic_quotes_gpc()) {
			$fultext=addslashes($fultext);
			$introtext=addslashes($introtext);
			$title=addslashes($title);
		}
		$date = date("Y-m-d G:i:s");
		$query = "INSERT INTO ".$dbprefix."stories SET author='$author', introtext='$introtext', fultext='$fultext', catid='$catid', newsimage='$image', time='$date', title='$title', published='0', image_position='$position', ordering=$ordering, frontpage=$frontpage, access=$access";
			$database->openConnectionNoReturn($query);?>
			<SCRIPT>
				document.location.href='index2.php?option=<?php echo $option; ?>&categories=<?php echo $categories; ?>';
			</SCRIPT>
			<?php 
	}

	function editNews($database, $dbprefix, $newshtml, $option, $storyid, $myname, $categories, $text_editor){
		require ("../configuration.php");

		$query = "SELECT title, checked_out, editor FROM ".$dbprefix."stories WHERE sid='$storyid'";
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
		$query = "UPDATE ".$dbprefix."stories SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE sid='$storyid'";
		$database->openConnectionNoReturn($query);

		$handle = opendir($image_path);

		$i = 0;
		while ($file = readdir($handle)) {
			if (($file <> ".") && ($file <> "..")){
				$imagename[$i] = $file;
				$i++;
			}
		}
		closedir($handle);

		$query = "SELECT categoryid, categoryname FROM ".$dbprefix."categories WHERE section='News'";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$categoryid[$i] = $row->categoryid;
			$categoryname[$i] = $row->categoryname;
			$i++;
		}
		mysql_free_result($result);

		$query = "SELECT image_position, title, sid, author, introtext, fultext, catid, newsimage, ordering, frontpage, access FROM ".$dbprefix."stories WHERE sid='$storyid'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$sid = $row->sid;
			$author = $row->author;
			$introtext = $row->introtext;
			$fultext = $row->fultext;
			$catidid = $row->catid;
			$title = $row->title;
			$position = $row->image_position;
			$newsimage = $row->newsimage;
			$ordering = $row->ordering;
			$frontpage = $row->frontpage;
			$GIDSel = $row->access;
		}
		mysql_free_result($result);

		$query = "SELECT * FROM ".$dbprefix."stories WHERE frontpage=1";
		$result = $database->openConnectionWithReturn($query);
		$frontpagecount = mysql_num_rows($result);
		mysql_free_result($result);

		$query = "SELECT * FROM ".$dbprefix."stories WHERE frontpage=0";
		$result = $database->openConnectionWithReturn($query);
		$restcount = mysql_num_rows($result);
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
		/*
		$queryG = "SELECT access FROM ".$dbprefix."stories WHERE categoryid='$sid'";
		$resultG = $database->openConnectionWithReturn($queryG);
		$i = 0;
		while ($rowG = mysql_fetch_object($resultG)){
			$GIDSel[$i] = $rowG->access;
		}
		*/

		$newshtml->editNews($imageid, $imagename, $categoryid, $categoryname, $sid, $author, $introtext, $fultext, $catidid, $title, $position, $newsimage, $ordering, $option, $restcount, $storyid, $categories, $frontpage, $frontpagecount, $text_editor, $Gid, $Gname, $GIDSel);
	}

	function saveeditnews($database, $dbprefix, $option, $image, $author, $introtext, $fultext, $title, $newscatid, $sid, $task, $position, $ordering1, $myname, $porder, $frontpage, $categories, $access){
		if (($title == "") || ($newscatid == "") || ($introtext == "")){
			print "<SCRIPT> alert('Please complete the Title, catid and Story fields'); window.history.go(-1); </SCRIPT>\n";
		}
		if ($frontpage == ""){
			$frontpage = 0;
		}
		if (!get_magic_quotes_gpc()) {
			$fultext=addslashes($fultext);
			$introtext=addslashes($introtext);
			$title=addslashes($title);
		}
		$query = "SELECT frontpage, catid FROM ".$dbprefix."stories WHERE sid='$sid' AND checked_out=1 AND editor='$myname'";
		$result = $database->openConnectionWithReturn($query);
		if (mysql_num_rows($result) == 1){
			list($old_frontpage,$old_catid) = mysql_fetch_array($result);
			if ($frontpage || $old_frontpage){
				if ($frontpage != $old_frontpage){
					if ($frontpage){
						$porder = 999999999;
					} else {
						$ordering1 = 999999999;
					}
				}
				if ($ordering1 > $porder){
					shiftdown($database, $dbprefix,$porder,$ordering1);
				} elseif ($ordering1 < $porder){
					shiftup($database, $dbprefix,$porder,$ordering1);
				}
			} else {
				if ($ordering1){
					shiftdown($database, $dbprefix,$porder);
					shiftup($database, $dbprefix,999999999,$ordering1);
				}
			}

			if ($ordering1 <> ""){
				$query = "UPDATE ".$dbprefix."stories SET title='$title', author='$author', introtext='$introtext', fultext='$fultext', catid='$newscatid', newsimage='$image', image_position='$position', checked_out=0, checked_out_time='00:00:00', editor=NULL, ordering=$ordering1, frontpage=$frontpage, access=$access WHERE sid='$sid'";
			}
			else {
				if ($ordering1){
					$query = "UPDATE ".$dbprefix."stories SET title='$title', author='$author', introtext='$introtext', fultext='$fultext', catid='$newscatid', image_position='$position', checked_out=0, checked_out_time='00:00:00', editor=NULL, ordering=$ordering1, frontpage=$frontpage, access=$access WHERE sid='$sid'";
				}
				else {
					$query = "UPDATE ".$dbprefix."stories SET title='$title', author='$author', introtext='$introtext', fultext='$fultext', catid='$newscatid', image_position='$position', checked_out=0, checked_out_time='00:00:00', editor=NULL, frontpage=$frontpage WHERE sid='$sid'";
				}
			}
			$database->openConnectionNoReturn($query);

			if (($newscatid != $old_catid) || ($frontpage != $old_frontpage)){
				checkcategory($database, $dbprefix,$newscatid);
				if ($newscatid!=$old_catid){
					checkcategory($database, $dbprefix,$old_catid);
				}
			}
				?>
				<SCRIPT>
					document.location.href='index2.php?option=<?php echo $option; ?>&categories=<?php echo $categories; ?>'
				</SCRIPT>
				<?php 
		}
		else {
			print "<SCRIPT>alert('Your job has timed out'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
		}
	}

	function removenews($database, $dbprefix, $option, $cid, $categories){
		if (count($cid) == 0){
			print "<SCRIPT> alert('Select a News item to delete'); window.history.go(-1);</SCRIPT>\n";
		}

		for ($i = 0; $i < count($cid); $i++){
			$query = "SELECT catid, approved, newsimage, frontpage, ordering FROM ".$dbprefix."stories WHERE sid='$cid[$i]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$query = "DELETE FROM ".$dbprefix."stories WHERE sid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				checkcategory($database, $dbprefix, $row->catid);
				if ($row->frontpage == 1){
					shiftdown($database, $dbprefix,$row->ordering);
				}
			}
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>";
	}

	function publishnews($database, $dbprefix, $option, $storyid, $cid, $categories){
		if (count($cid) == 0){
			if (!isset($storyid)){
				print "<SCRIPT> alert('Select a story to publish'); window.history.go(-1);</SCRIPT>\n";
				print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				return;
			}
			$cid = array($storyid);
		}
		for ($i = 0; $i < count($cid); $i++){
			$query  = "SELECT checked_out, published, catid FROM ".$dbprefix."stories WHERE sid='$cid[0]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				if ($row->published == 0){
					if ($row->checked_out == 1){
						print "<SCRIPT>alert('This story cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
					}
					$query = "UPDATE ".$dbprefix."stories SET published=1, editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE sid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					checkcategory($database, $dbprefix, $row->catid);
				}
			}
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
	}

	function unpublishnews($database, $dbprefix, $option, $storyid, $cid, $categories){
		if (count($cid) == 0){
			if (!isset($storyid)){
				print "<SCRIPT> alert('Select a story to unpublish'); window.history.go(-1);</SCRIPT>\n";
				print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				return;
			}
			$cid = array($storyid);
		}
		for ($i = 0; $i < count($cid); $i++){
			$query = "SELECT published, checked_out, catid, frontpage, ordering FROM ".$dbprefix."stories WHERE sid='$cid[$i]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row =  mysql_fetch_object($result)){
				if ($row->published == 1){
					if ($row->checked_out == 1){
						print "<SCRIPT>alert('This story cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
					}
					$query = "UPDATE ".$dbprefix."stories SET published=0, editor=NULL, checked_out=0, checked_out_time='00:00:00', ordering=999999999, frontpage=0 WHERE sid='$cid[$i]'";
					$database->openConnectionNoReturn($query);

					if ($row->frontpage == 1){
						shiftdown($database, $dbprefix, $row->ordering);
					}
					checkcategory($database, $dbprefix, $row->catid);
				}
			}
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
	}

	function archivenews($database, $dbprefix, $option, $storyid, $cid, $categories){
		if (count($cid) > 0){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out, archived, catid, frontpage, ordering FROM ".$dbprefix."stories WHERE sid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					if ($row->archived == 0){
						if ($row->checked_out == 1){
							print "<SCRIPT>alert('This story cannot be archived because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
							exit(0);
						}
						$query = "UPDATE ".$dbprefix."stories SET archived=1, frontpage=0, ordering=999999999 WHERE sid='$cid[$i]'";
						$database->openConnectionNoReturn($query);
						if ($row->frontpage == 1){
							shiftdown($database, $dbprefix,$row->ordering);
						}
						checkcategory($database, $dbprefix, $row->catid);
					}
				}
			}
		} else {
			print "<SCRIPT>alert('Please select a news story to archive');</SCRIPT>\n";
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
	}

	function unarchivenews($database, $dbprefix, $option, $storyid, $cid, $categories){
		if (count($cid) > 0){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out, archived, catid FROM ".$dbprefix."stories WHERE sid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					if ($row->archived == 1){
						if ($row->checked_out == 1){
							print "<SCRIPT>alert('This story cannot be unarchived because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
							exit(0);
						}
						$query = "UPDATE ".$dbprefix."stories SET archived=0 WHERE sid='$cid[$i]'";
						$database->openConnectionNoReturn($query);
						checkcategory($database, $dbprefix, $row->catid);
					}
				}
			}
		} else {
			print "<SCRIPT>alert('Please select a news story to unarchive');</SCRIPT>\n";
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
	}

	function approvenews($database, $dbprefix, $option, $author, $introtext, $fultext, $newscatid, $image, $mytitle, $ordering, $position, $frontpage, $sid, $porder, $categories, $access){
		// $query = "UPDATE ".$dbprefix."stories SET approved=1, checked_out=0, checked_out_time='00:00:00', editor=NULL, catid=$newscatid, author='$author', introtext='$introtext', fultext='$fultext',  title='$mytitle', newsimage='$image', image_position='$position', frontpage='$frontpage', published='1' WHERE sid=$sid";
		// $database->openConnectionNoReturn($query);

		if ($frontpage==1){
			if ($porder == 0){
				$porder = 999999999;
			}
			if ($ordering > $porder){
				shiftdown($database, $dbprefix,$porder,$ordering);
			} elseif ($ordering < $porder){
				shiftup($database, $dbprefix,$porder,$ordering);
			}
			$query = "UPDATE ".$dbprefix."stories SET approved=1, checked_out=0, checked_out_time='00:00:00', editor=NULL, catid=$newscatid, author='$author', introtext='$introtext', fultext='$fultext',  title='$mytitle', newsimage='$image', image_position='$position', ordering=$ordering, frontpage='$frontpage', published='1', access=$access WHERE sid=$sid";
			$database->openConnectionNoReturn($query);
		} else {
			$query = "UPDATE ".$dbprefix."stories SET approved=1, checked_out=0, checked_out_time='00:00:00', editor=NULL, catid=$newscatid, author='$author', introtext='$introtext', fultext='$fultext',  title='$mytitle', newsimage='$image', image_position='$position', frontpage='$frontpage', published='1', access=$access WHERE sid=$sid";
			$database->openConnectionNoReturn($query);
		}
		print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
	}
}

function checkcategory($database, $dbprefix, $catid){
	$query  = "SELECT * FROM ".$dbprefix."stories WHERE published=1 AND archived=0 AND catid='$catid'";
	$result = $database->openConnectionWithReturn($query);
	if (mysql_num_rows($result) == 0){
		$published = 0;
	} else {
		$published = 1;
	}
	$query = "UPDATE ".$dbprefix."categories SET published=$published WHERE categoryid=$catid";
	$database->openConnectionNoReturn($query);
}

function shiftdown($database, $dbprefix, $beginat,$endat = 999999999){
	$query = "SELECT sid FROM ".$dbprefix."stories WHERE ordering > $beginat AND ordering <= $endat AND frontpage = 1";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$query = "UPDATE ".$dbprefix."stories SET ordering=ordering - 1 WHERE sid=$row->sid";
		$database->openConnectionNoReturn($query);
	}
}

function shiftup($database, $dbprefix, $beginat,$endat = 1){
	$query = "SELECT sid FROM ".$dbprefix."stories WHERE ordering >= $endat AND ordering < $beginat AND frontpage = 1";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$query = "UPDATE ".$dbprefix."stories SET ordering=ordering + 1 WHERE sid=$row->sid";
		$database->openConnectionNoReturn($query);
	}
}
?>
