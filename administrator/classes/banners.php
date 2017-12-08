<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	03-02-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: banners.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/

class banners {
	function viewBanners_current($database, $dbprefix, $bannershtml, $option){
		$query= "select bid, name, showBanner, imptotal, impmade, clicks, editor from ".$dbprefix."banner";
		$result= $database->openConnectionWithReturn($query);
		$i=0;
		while ($row=mysql_fetch_object($result)){
			$bid[$i]=$row->bid;
			$bname[$i]=$row->name;
			$status[$i]=$row->showBanner;
			$imptotal[$i]=$row->imptotal;
			$impmade[$i]=$row->impmade;
			$clicks[$i]=$row->clicks;
			$editor[$i]=$row->editor;
			$impleft[$i]=$imptotal[$i]-$impmade[$i];
			if ($impleft[$i]<=0){
				$impleft[$i]="unlimited";
			}
			if ($impmade[$i]!=0){
				$percentClicks[$i]=substr(100 * $clicks[$i]/$impmade[$i], 0, 5);
			}else{
				$percentClicks[$i]=0;
			}
			if ($status[$i]=="1"){
				$status[$i]="yes";
			}else{
				$status[$i]="no";
			}
			$i++;
		}
		$bannershtml->showBanners_current($bid, $bname, $option, $impleft, $clicks, $percentClicks, $impmade, $status, $editor);
	}

	function viewBanners_finished($database, $dbprefix, $bannershtml, $option){
		$query="select bid, name, impressions, clicks from ".$dbprefix."bannerfinish";
		$result= $database->openConnectionWithReturn($query);
		$i=0;
		while ($row=mysql_fetch_object($result)){
			$bid[$i]=$row->bid;
			$bname[$i]=$row->name;
			$impmade[$i]=$row->impressions;
			$clicks[$i]=$row->clicks;
			$percentClicks[$i]=substr(100 * $clicks[$i]/$impmade[$i], 0, 5);
			$i++;
		}
		$bannershtml->showBanners_finished($bid, $bname, $option, $clicks, $percentClicks, $impmade);
	}

	function addBanner_current($database, $dbprefix, $bannershtml, $option){
		$query="select cid, name from ".$dbprefix."bannerclient";
		$result=$database->openConnectionWithReturn($query);
		$i=0;
		while ($row=mysql_fetch_object($result)){
			$clientNames[$i]=$row->name;
			$clientIDs[$i]=$row->cid;
			$i++;
		}

		$handle=opendir('../images/banners/');
		$i=0;
		while ($file = readdir($handle)) {
			if ((ereg("[gif]",$file)) || (ereg("[jpg]", $file))){
				$imageList[$i]=$file;
				$i++;
			}
		}
		closedir($handle);
		$bannershtml->addBanner_current($clientNames, $clientIDs, $imageList, $option);
	}

	function saveNewBanner_current($database, $dbprefix, $bname, $clientid, $imptotal, $imageurl, $clickurl, $show, $unlimited){
		if (trim($show)=="on"){
			$show=1;
		}else{
			$show=0;
		}
		if ((trim($bname) == "") || (trim($clientid) == "") || (trim($imageurl) =="") || (trim($clickurl) =="")){
			print "<SCRIPT> alert('Please complete all fields'); window.history.go(-1); </SCRIPT>\n";
		}else if ((trim($imptotal)=="") && (trim($unlimited)=="")){
			print "<SCRIPT> alert('Please enter a number of impressions or tick the unlimited box.'); window.history.go(-1); </SCRIPT>\n";
		}else{
			$date = date("Y-m-d G:i:s");
			if ($unlimited=="true"){
				$imptotal=0;
			}
			$query="insert into ".$dbprefix."banner (cid, imptotal, imageurl, clickurl, name, date) values ('$clientid', '$imptotal', '$imageurl', '$clickurl', '$bname', '$date')";
			$database->openConnectionNoReturn($query);
		}
		echo "<SCRIPT>document.location.href='index2.php?option=Current'</SCRIPT>";
	}

	function editBanner_current($bannershtml, $database, $dbprefix, $option, $show, $bannerid, $myname){
		if (trim($bannerid) == ""){
			print "<SCRIPT> alert('Select a banner to edit'); window.history.go(-1);</SCRIPT>\n";
		}

		$query = "SELECT checked_out, editor, name FROM ".$dbprefix."banner WHERE bid='$bannerid'";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$checked = $row->checked_out;
			$editor = $row->editor;
			$name=$row->name;
		}
		$stringcmp = strcmp($editor,$myname);
		if (($checked == 1) && ($stringcmp <> 0)){
			print "<SCRIPT>alert('The banner $name is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
			exit(0);
		}

		$date = date("H:i:s");
		$query = "UPDATE ".$dbprefix."banner SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE bid='$bannerid'";
		$database->openConnectionNoReturn($query);

		$query="select name, cid, imptotal, imageurl, clickurl, date, showBanner from ".$dbprefix."banner where bid='$bannerid'";
		$result= $database->openConnectionWithReturn($query);
		list($bname, $clientid, $imptotal, $imageurl, $clickurl, $date, $showBanner)=mysql_fetch_array($result);
		mysql_free_result($result);

		$query="select name from ".$dbprefix."bannerclient where cid='$clientid'";
		$result= $database->openConnectionWithReturn($query);
		list($cname)=mysql_fetch_array($result);
		mysql_free_result($result);

		$query="select cid, name from ".$dbprefix."bannerclient";
		$result=$database->openConnectionWithReturn($query);
		$i=0;
		while ($row=mysql_fetch_object($result)){
			$clientNames[$i]=$row->name;
			$clientIDs[$i]=$row->cid;
			$i++;
		}
		$handle=opendir('../images/banners/');
		$i=0;
		while ($file = readdir($handle)) {
			if ((ereg("[gif]",$file)) || (ereg("[jpg]", $file))){
				$imageList[$i]=$file;
				$i++;
			}
		}
		closedir($handle);
		$bannershtml->editBanner_current($bannerid, $bname, $cname, $clientid, $imptotal, $imageurl, $clickurl, $clientNames, $clientIDs, $imageList, $option, $myname);
	}

	function editBanner_finished($bannershtml, $database, $dbprefix, $option, $show, $bannerid){
		if (trim($bannerid) == ""){
			print "<SCRIPT> alert('Select a banner to edit'); window.history.go(-1);</SCRIPT>\n";
		}

		$query="select name, cid, impressions, clicks, datestart, dateend, imageurl from ".$dbprefix."bannerfinish where bid='$bannerid'";
		$result= $database->openConnectionWithReturn($query);
		list($bname, $clientid, $impressions, $clicks, $datestart, $dateend, $imageurl)=mysql_fetch_array($result);
		mysql_free_result($result);
		$query="select name from ".$dbprefix."bannerclient where cid='$clientid'";
		$result= $database->openConnectionWithReturn($query);
		list($cname)=mysql_fetch_array($result);
		mysql_free_result($result);

		$bannershtml->editBanner_finished($bannerid, $bname, $cname, $clientid, $impressions, $clicks, $datestart, $dateend, $imageurl, $option);
	}

	function saveEditBanner_current($bannershtml, $database, $dbprefix, $bannerid, $bname, $cname, $clientid, $imptotal, $imageurl, $clickurl, $show, $option, $myname, $unlimited){
		if ($show=="on"){
			$show=1;
		}else{
			$show="0";
		}
		if ((trim($bname) == "") || (trim($clientid) == "") || (trim($imageurl) =="") || (trim($clickurl) =="")){
			print "<SCRIPT> alert('Please complete all fields'); window.history.go(-1); </SCRIPT>\n";
		}else if ((trim($imptotal)=="") && (trim($unlimited)=="")){
			print "<SCRIPT> alert('Please enter a number of impressions or tick the unlimited box.'); window.history.go(-1); </SCRIPT>\n";
		}else{
			if ($unlimited=="true"){
				$imptotal=0;
			}
			if ($imptotal > 0){
				$query="select impmade from ".$dbprefix."banner where bid='$bannerid'";
				$result=$database->openConnectionWithReturn($query);
				list($impmade)=mysql_fetch_array($result);
				if ($impmade > $imptotal){
					print "<SCRIPT> alert('Your number of impressions cannot be less than the total number of impressions already made'); window.history.go(-1); </SCRIPT>\n";
				}
			}
			$query = "SELECT bid FROM ".$dbprefix."banner WHERE bid='$bannerid' AND checked_out=1 AND editor='$myname'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				$query1= "update ".$dbprefix."banner set name='$bname', cid='$clientid', imptotal='$imptotal', imageurl='$imageurl', clickurl='$clickurl', checked_out=0, checked_out_time='00:00:00', editor=NULL where bid='$bannerid'";
				$database->openConnectionNoReturn($query1);
				echo "<SCRIPT>document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$bannerid'</SCRIPT>";
			}
		}
	}

	function saveUploadNew_current($userfile, $userfile_name){
		if (!eregi(".gif", $userfile_name)){
			if (!eregi(".jpg", $userfile_name)){
				if (!eregi(".swf", $userfile_name)){
					$incorrectType=1;
					echo "<SCRIPT> alert('You can only upload gifs, jpgs or swfs as banners'); window.history.go(-1);</SCRIPT>\n";
				}
			}
		}
		if ($incorrectType!=1){
			$base_Dir = "../images/banners/";
			if (!move_uploaded_file($userfile, $base_Dir.$userfile_name)){
				echo "Failed to copy $userfile_name";
			}else{
				echo "<SCRIPT> window.opener.document.adminForm.imageurl.options[0].text='$userfile_name'; window.opener.document.adminForm.imageurl.options[0].value='$userfile_name';</SCRIPT>";
				echo "<SCRIPT> window.opener.document.adminForm.imageurl.options[selectedIndex]='$userfile_name';</SCRIPT>";
				echo "<SCRIPT> window.opener.document.imagelib.src='../images/banners/$userfile_name';</SCRIPT>";
				echo "<SCRIPT> window.opener.document.imageurl.focus;</SCRIPT>";
				echo "<SCRIPT>window.close(); </SCRIPT>";
			}
		}
	}

	function publishBanner_current($database, $dbprefix, $option, $bannerid, $cid){
		if (trim($bannerid)!=""){
			$query="select impmade, date from ".$dbprefix."banner where bid='$bannerid'";
			$result=$database->openConnectionWithReturn($query);
			list ($impmade, $date)=mysql_fetch_array($result);
			if ($impmade == 0 ){
				$date = date("Y-m-d G:i:s");
			}
			$query="update ".$dbprefix."banner set showBanner=1, date='$date' where bid='$bannerid'";
			$database->openConnectionNoReturn($query);
		}else{
			if (count($cid)!=0){
				for ($i=0; $i < count($cid); $i++){
					$query="select impmade, date from ".$dbprefix."banner where bid='$cid[$i]'";
					$result=$database->openConnectionWithReturn($query);
					list ($impmade, $date)=mysql_fetch_array($result);
					if ($impmade == 0 ){
						$date = date("Y-m-d G:i:s");
					}
					$query="update ".$dbprefix."banner set showBanner=1, date='$date' where bid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}else{
				echo "<SCRIPT> alert('Select a banner to publish'); window.history.go(-1);</SCRIPT>\n";
			}
		}
		$query="update ".$dbprefix."banner set checked_out=0, checked_out_time='00:00:00', editor=NULL where bid='$bannerid'";
		$database->openConnectionNoReturn($query);
		echo "<SCRIPT>document.location.href='index2.php?option=Current'</SCRIPT>";
	}

	function unpublishBanner_current($database, $dbprefix, $option, $bannerid, $cid){
		if (trim($bannerid)!=""){
			$query="update ".$dbprefix."banner set showBanner=0 where bid='$bannerid'";
			$database->openConnectionNoReturn($query);
		}else{
			if (count($cid)!=0){
				for ($i=0; $i < count($cid); $i++){
					$query="update ".$dbprefix."banner set showBanner=0 where bid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}else{
				echo "<SCRIPT> alert('Select a banner to unpublish'); window.history.go(-1);</SCRIPT>\n";
			}
		}
		$query="update ".$dbprefix."banner set checked_out=0, checked_out_time='00:00:00', editor=NULL where bid='$bannerid'";
		$database->openConnectionNoReturn($query);
		echo "<SCRIPT>document.location.href='index2.php?option=Current'</SCRIPT>";
	}

	function removeBanner_current($database, $dbprefix, $option, $cid){
		if (count($cid) == 0){
			echo "<SCRIPT> alert('Select a banner to delete'); window.history.go(-1);</SCRIPT>\n";
		}

		for ($i = 0; $i < count($cid); $i++){
			$query="delete from ".$dbprefix."banner where bid='$cid[$i]'";
			$database->openConnectionNoReturn($query);
		}
		echo "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
	}

	function removeBanner_finished($database, $dbprefix, $option, $cid){
		if (count($cid) == 0){
			echo "<SCRIPT> alert('Select a banner to delete'); window.history.go(-1);</SCRIPT>\n";
		}

		for ($i = 0; $i < count($cid); $i++){
			$query="delete from ".$dbprefix."bannerfinish where bid='$cid[$i]'";
			$database->openConnectionNoReturn($query);
		}
		echo "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
	}
	}?>