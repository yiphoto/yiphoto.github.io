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
*	File Name: banners_finished.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require("classes/html/HTML_banners.php");
$bannershtml = new HTML_banners();

require("classes/banners.php");
$banners = new banners();

switch ($task){
	case "edit":
	$bannerid = $cid[0];
	$banners->editBanner_finished($bannershtml, $database, $dbprefix, $option, $show, $bannerid);
	break;
	case "remove":
	$banners->removeBanner_finished($database, $dbprefix, $option, $cid);
	break;
	default:
	$banners->viewBanners_finished($database, $dbprefix, $bannershtml, $option);
}
?>