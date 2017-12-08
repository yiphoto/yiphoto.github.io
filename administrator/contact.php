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
*	File Name: contact.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 20-01-2003
* 	Version #: 4.0.12
*	Comments:
**/
require_once("includes/auth.php");

require ("classes/html/HTML_contact.php");
$contacthtml = new HTML_contact();

switch ($task){
	case "save":
	savecontact($database, $dbprefix, $companyname, $acn, $address, $suburb, $state, $postcode, $telephone, $facsimile, $email, $country);
	break;
	default:
	showcontact($contacthtml, $database, $dbprefix);
}


function showcontact($contacthtml, $database, $dbprefix){
	$query = "SELECT * FROM ".$dbprefix."contact_details";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$companyname = $row->name;
		$acn = $row->ACN;
		$address = $row->address;
		$suburb = $row->suburb;
		$state = $row->state;
		$country = $row->country;
		$postcode = $row->postcode;
		$telephone = $row->telephone;
		$facsimile = $row->fax;
		$email = $row->email_to;
	}
	
	$contacthtml->showcontact($companyname, $acn, $address, $suburb, $state, $postcode, $telephone, $facsimile, $email, $country);
}

function savecontact($database, $dbprefix, $companyname, $acn, $address, $suburb, $state, $postcode, $telephone, $facsimile, $email, $country){
	$query = "DELETE FROM ".$dbprefix."contact_details";
	$database->openConnectionNoReturn($query);
	
	$query = "INSERT INTO ".$dbprefix."contact_details SET name='$companyname', ACN='$acn', address='$address', suburb='$suburb', state='$state', country='$country', postcode='$postcode', telephone='$telephone', fax='$facsimile', email_to='$email'";
	$database->openConnectionNoReturn($query);
	
	print "<SCRIPT>document.location.href='index2.php'</SCRIPT>\n";
}
?>