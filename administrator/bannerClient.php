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
*	File Name: bannerClient.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_bannerClient.php");
$bannerClienthtml = new HTML_bannerClient();

require("classes/bannerClient.php");
$bannerClient = new bannerClient();


switch ($task){
	case "new":
	$bannerClient->addBannerClient($database, $dbprefix, $bannerClienthtml, $option);
	break;
	case "saveNew":
	$bannerClient->saveBannerClient($database, $dbprefix, $cname, $contact, $email, $extrainfo);
	break;
	case "edit":
	$clientid = $cid[0];
	$bannerClient->editBannerClient($bannerClienthtml, $database, $dbprefix, $option, $clientid, $myname);
	break;
	case "save":
	$bannerClient->saveEditBannerClient($bannerClienthtml, $database, $dbprefix, $clientid, $cname, $contact, $email, $extrainfo, $myname);
	break;
	case "remove":
	$bannerClient->removeBannerClient($database, $dbprefix, $option, $cid);
	break;
	default:
	$bannerClient->viewBannerClients($database, $dbprefix, $bannerClienthtml, $option);
}
?>