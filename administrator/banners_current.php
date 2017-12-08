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
*	File Name: banners_current.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
//require_once("includes/auth.php");

require("classes/html/HTML_banners.php");
$bannershtml = new HTML_banners();

require("classes/banners.php");
$banners = new banners();


switch ($task){
	case "new":
	//check if this is the first banner to be made, there must be a client existing first!
	$query="select cid from ".$dbprefix."bannerclient";
	$result=$database->openConnectionWithReturn($query);
	if (mysql_num_rows($result)>0){
		$banners->addBanner_current($database, $dbprefix, $bannershtml, $option);
	}else{
		print "<SCRIPT> alert('You cannot add a new banner until a client has been added'); window.history.go(-1); </SCRIPT>\n";
	}
	break;
	case "saveNew":
	$banners->saveNewBanner_current($database, $dbprefix, $bname, $clientid, $imptotal, $imageurl, $clickurl, $show, $unlimited);
	break;
	case "edit":
	if (trim($bannerid)==""){
		$bannerid = $cid[0];
	}
	$banners->editBanner_current($bannershtml, $database, $dbprefix, $option, $show, $bannerid, $myname);
	break;
	case "saveEdit":
	$banners->saveEditBanner_current($bannershtml, $database, $dbprefix, $bannerid, $bname, $cname, $clientid, $imptotal, $imageurl, $clickurl, $show, $option, $myname, $unlimited);
	break;
	case "saveUploadNew":
	$banners->saveUploadNew_current($userfile, $userfile_name);
	break;
	case "remove":
	$banners->removeBanner_current($database, $dbprefix, $option, $cid);
	break;
	case "publish":
	$banners->publishBanner_current($database, $dbprefix, $option, $bannerid, $cid);
	break;
	case "unpublish":
	$banners->unpublishBanner_current($database, $dbprefix, $option, $bannerid, $cid);
	break;
	
	default:
	$banners->viewBanners_current($database, $dbprefix, $bannershtml, $option);
}
?>
