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
*	File Name: survey.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_survey.php");
$surveyhtml = new HTML_survey();

require("classes/survey.php");
$survey = new survey();

switch($task){
	case "edit":
	$pollid = $cid[0];
	$survey->editsurvey($surveyhtml, $database, $dbprefix, $option, $pollid, $myname);
	break;
	case "saveedit":
	$selection = split("&", $REQUEST_URI);
	$selections = array();
	$k = 0;
	for ($i = 0; $i < count($selection); $i++){
		if (eregi("menu", $selection[$i])){
			$selected = split("=", $selection[$i]);
			$selections[$k] = $selected[1];
			$k++;
		}
	}
	
	for ($i = 0; $i < count($selections); $i++){
		$selections[$i] = ereg_replace( "[+]", " ", $selections[$i]);
	}
	$survey->saveeditsurvey($database, $dbprefix, $option, $pollid, $polloption, $optionCount, $pollorder, $mytitle, $selections);
	break;
	case "savenew":
	$selection = split("&", $REQUEST_URI);
	$selections = array();
	$k = 0;
	for ($i = 0; $i < count($selection); $i++){
		if (eregi("menu", $selection[$i])){
			$selected = split("=", $selection[$i]);
			$selections[$k] = $selected[1];
			$k++;
		}
	}
	
	for ($i = 0; $i < count($selections); $i++){
		$selections[$i] = ereg_replace( "[+]", " ", $selections[$i]);
	}
	
	$survey->savenewsurvey($database, $dbprefix, $option, $mytitle, $pollorder, $polloption, $selections);
	break;
	case "remove":
	$survey->removesurvey($database, $dbprefix, $option, $cid);
	break;
	case "new":
	$survey->addSurvey($option, $database, $dbprefix, $surveyhtml);
	break;
	case "publish":
	$survey->publishsurvey($option, $database, $dbprefix, $cid, $pollid);
	break;
	case "unpublish":
	$survey->unpublishsurvey($option, $database, $dbprefix, $cid, $pollid);
	break;
	default:
	$survey->showSurvey($option, $surveyhtml, $database, $dbprefix);
}
?>