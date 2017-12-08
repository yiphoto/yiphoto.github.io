<?php 
/**
*	Mambo Open Source Version 4.0.12
*	Dynamic portal server and Content managment engine
*	04-04-2003
*
*	Copyright (C) 2000 - 2003 Miro International Pty. Limited
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warranty provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Open Source Version 4.0.12
*	File Name: emailarticle.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 04-04-2003
* 	Version #: 4.0.12
*	Comments:
**/

include('../configuration.php');
include_once( $absolute_path.'/language/'.$lang.'/lang_email.php' );
include('../regglobals.php');
?>
<html>
<head>
<title><?php echo _EMAIL_TITLE; ?></title>
<link rel="stylesheet" href="../css/ie5.css" type="text/css">
</head>
<body>
<?php 	if (!isset($submit)){
	echo "<FORM ACTION=\"emailarticle.php\" METHOD=\"POST\">";
	include_once('_emailform.php');
}else {
	
	if (($email=="") || ($youremail=="")){
		echo "<SCRIPT>alert (\""._EMAIL_ERR_NOINFO."\"); window.history.go(-1);</SCRIPT>";
		exit(0);
	}
	
	require ("../administrator/classes/database.php");
	$database = new database();
	
	$test = split("/", $REQUEST_URI);
	if ($test[1] == 'emailfriend') {	// fix by Saka
	$test[1] = '';
	}
	$pat= "SRC=images";
	//$replace= "SRC=http://$SERVER_NAME/$test[1]/images";
	$replace= "SRC=$live_site/images";
	
	$pat2="SRC=\"images";
	//$replace2="SRC=\"http://$SERVER_NAME/$test[1]/images";
	$replace2="SRC=\"$live_site/images";
	
	$pat3=";";
	$replace3=",";
	
	$query = "SELECT title, content, author FROM ".$dbprefix."articles WHERE artid=$id";
	$result = $database->openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$title = $row->title;
		$content = $row->content;
		$author = $row->author;
	}
	
	$title =eregi_replace($pat, $replace, $title);
	$title =eregi_replace($pat, $replace, $title);
	
	$content =eregi_replace($pat, $replace, $content);
	$content =eregi_replace($pat2, $replace2, $content);
	$email =ereg_replace($pat3, $replace3, $email);
	$msg=_EMAIL_MSG;
	eval ("\$msg = \"$msg\";");
	$message = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>\n
			<html>\n
			  <head>\n
			  <title>$title</title>\n
			  <link rel=\"stylesheet\" href=\"http://$SERVER_NAME/$test[1]/css/ie5.css\" type=\"text/css\">\n
			  </head>\n
			  <body>\n
				<TABLE ALIGN=\"center\" WIDTH=\"90%\" CELLSPACING=\"2\" CELLPADDING=\"2\" BORDER=\"0\" HEIGHT=\"100%\">\n
				<TR>
					<TD COLSPAN=2> $msg </TD>\n
				</TR>\n
				<TR>\n
					<TD COLSPAN=2>&nbsp;</TD>\n
				</TR>\n
				<TR>\n
	    			<TD CLASS=\"articlehead\" COLSPAN=\"2\">$title</TD>\n
				</TR>\n
				<TR>\n
					<TD CLASS=\"small\" COLSPAN=\"2\">By $author</TD>\n
				</TR>\n
				<TR>\n
					<TD COLSPAN=2>&nbsp;</TD>\n
				</TR>\n
				<TR>\n
	    			<TD VALIGN='top' HEIGHT='90%' COLSPAN=\"2\">$content</TD>\n
				</TR>\n
				</TABLE>\n
			  </body>\n
			</html>\n";
	
	$recipient = $email;
	$subject = _EMAIL_ARTICLE." $yourname";
	
	$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
	$headers .= "From: \"$yourname\" <$youremail>\n";
	$headers .= "X-Sender: <$youremail>\n";
	$headers .= "X-Mailer: PHP\n";
	$headers .= "Return-Path: <$youremail>\n";
	mail($recipient, $subject, $message, $headers);
	echo "<span class=articlehead>"._EMAIL_SENT." $email</span><BR><BR><BR>";
	echo "<a href='javascript:window.close();'><span class=small>"._PROMPT_CLOSE."<small></a>";
}
?>
</body>
</html>