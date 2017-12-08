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
*	File Name: view.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 03-02-2003
* 	Version #: 4.0.12
*	Comments:
**/

include ("../../regglobals.php");
session_start();

if (!(isset($_SESSION['admin_session_id']) && $_SESSION['admin_session_id']==md5($_SESSION['userid'].$_SESSION['myname'].$_SESSION['usertype'].$_SESSION['logintime']))) {
        print "<script> document.location.href='../index.php'</script>";
        exit();
}

include ("../../configuration.php");
if ($delete == "Delete Files"){
	for ($i = 0; $i < count($deletepdf); $i++){
		unlink($pdf_path.$deletepdf[$i]);
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Navigation</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
	<SCRIPT>
	<!--
		function pdfcode(pdf){
			top.window.imagecode.document.codeimage.imagecode.value = '<A HREF=\"<?php echo $live_site; ?>/pdf/' + pdf + '\" TARGET=\"new\">Place text here</A>';
			}
	//-->
	</SCRIPT>

</head>

<body bgcolor="#FFFFFF">

<?php
$handle=opendir($pdf_path);
$i=0;
while ($file = readdir($handle)) {
	if ($file <> "." && $file <> "..")
	$pdffile[$i]=$file;
	$i++;
}

print "<FORM action='pdf.php'><TABLE WIDTH='100%'>";
print "<BR>";
print "<TR><TD ALIGN='center' colspan='3'><span class='articlehead'>Document Library</span><hr></TD></TR>\n";
if ($pdffile==0) {
	print "<TD><B><span class='articlehead'>There are no files available</span></TD>";
} else {
	sort ($pdffile);
	$k = 0;
	while ($k < count($pdffile)){
		print "<TR>";
		for ($r = 0; $r < 3; $r++){
			if (($pdffile[$k] <> "") && (eregi("doc$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='doc_16.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
			}
			else if (($pdffile[$k] <> "") && (eregi("pdf$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='pdf_16.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
			}
			else if (($pdffile[$k] <> "") && (eregi("xls$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='xls_16.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
			}
			else if (($pdffile[$k] <> "") && (eregi("mp3$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='realplayer.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
			}
			else if (($pdffile[$k] <> "") && (eregi("mpeg$",$pdffile[$k])) ||  (eregi("mpg$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='realplayer.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
			}
			$k++;
		}}
		print "</TR>";
}
print "<TR><TD ALIGN='center' colspan='3' height='40' valign='bottom'><INPUT class='button' TYPE='submit' NAME='delete' VALUE='Delete Files'></TD></TR>\n";
print "</TABLE></FORM>\n";
?>

</BODY>
</HTML>
