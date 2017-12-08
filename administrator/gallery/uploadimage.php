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
*	File Name: uploadimage.php
*	Original Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 14-01-2003
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

if (isset($fileupload)){
	if ($directory!="uploadfiles"){
		$base_Dir = "../../images/stories/";
	}else{
		$base_Dir = "../../uploadfiles/$Itemid/";
	}

	$filename = split("\.", $userfile_name);
	if (eregi("[^0-9a-zA-Z_]", $filename[0])){
		print "<SCRIPT> alert('File must only contain alphanumeric characters and no spaces please.'); window.history.go(-1);</SCRIPT>\n";
		exit();
	}

	if (file_exists($base_Dir.$userfile_name)){
		print "<SCRIPT> alert('Image $userfile_name already exists.'); window.history.go(-1);</SCRIPT>\n";
		exit();
	}
	if ((strcasecmp(substr($userfile_name,-4),".gif")) && (strcasecmp(substr($userfile_name,-4),".jpg")) && (strcasecmp(substr($userfile_name,-4),".png")) && (strcasecmp(substr($userfile_name,-4),".doc")) && (strcasecmp(substr($userfile_name,-4),".xls")) && (strcasecmp(substr($userfile_name,-4),".swf")) && (strcasecmp(substr($userfile_name,-4),".pdf"))){
		print "<SCRIPT>alert('The file must be pdf, gif, png, jpg, doc, xls or swf'); window.history.go(-1);</SCRIPT>\n";
		exit();
	}

	if ((eregi(".pdf", $userfile_name)) || (eregi(".doc", $userfile_name)) || (eregi(".xls", $userfile_name))){
		if (!(move_uploaded_file($userfile, $pdf_path.$userfile_name) && chmod($pdf_path.$userfile_name, 0644))){
			echo "Failed to copy $userfile_name";
		}
	}
	elseif (!(move_uploaded_file($userfile, $base_Dir.$userfile_name) && chmod($base_Dir.$userfile_name, 0644))){
		echo "Failed to copy $userfile_name";
	}

	if (eregi(".jpg", $userfile_name)){
		print "<SCRIPT>top.window.images.document.location.href=\"index.php?gal=0&image=jpg&directory=$directory&Itemid=$Itemid\"</SCRIPT>\n";
	}
	elseif (eregi(".pdf", $userfile_name)){
		print "<SCRIPT>top.window.images.document.location.href='pdf.php'</SCRIPT>\n";
	}
	if (eregi(".png", $userfile_name)){
		print "<SCRIPT>top.window.images.document.location.href=\"index.php?gal=0&image=png&directory=$directory&Itemid=$Itemid\"</SCRIPT>\n";
	}
	else {
		print "<SCRIPT>top.window.images.document.location.href=\"index.php?gal=0&image=gif&directory=$directory&Itemid=$Itemid\"</SCRIPT>\n";
	}
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Upload a file</title>
</head>
<link rel="stylesheet" href="../../css/ie5.css" type="text/css">

<body>
<FORM ENCTYPE="multipart/form-data" ACTION="uploadimage.php" METHOD="POST" NAME="filename">
  <table border=0 bgcolor=FFFFFF cellpadding=0 cellspacing=0 width=100%>
    <TR>
      <TD align="center" HEIGHT="50"><br><span class="articlehead">Upload a file</span><hr></td>
    </TR>
    <TR>
      <TD ALIGN="center">
        <INPUT class="inputbox" NAME="userfile" size="30" TYPE="file">
	</td>
	</tr>
	<tr><td align="center"><br>
        <input class="button" type="submit" value="Upload File" name="fileupload">
        </TD>
    </TR>
    <TR>
      <TD>
        <INPUT TYPE="hidden" NAME="directory" VALUE="<?php echo $directory;?>">
        <INPUT TYPE="hidden" NAME="Itemid" VALUE="<?php echo $Itemid;?>">
      </TD>
    </TR>
  </TABLE>
</FORM>
</body>
</html>

