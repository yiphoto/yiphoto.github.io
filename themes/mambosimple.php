<?php 
/**
*  Mambo Open Source Version 4.0.12
*  Dynamic portal server and Content managment engine
*
*  Copyright (C) 2000 - 2003 Miro International Pty Ltd
*  Distributed under the terms of the GNU General Public License
*  This software may be used without warranty provided these statements are left
*  intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*  This code is available at http://sourceforge.net/projects/mambo
*
*  Site Name: Mambo Open Source Version 4.0
*  File Name: index_header.php
*  Original Original Developers: Danny Younes - danny@miro.com.au
*                       Nicole Anderson - nicole@miro.com.au
*  Date: 15/11/2002
*  Version #: 4.0.12
*  Comments:
**/

include('language/'.$lang.'/lang_theme.php');

include ("newsflashCookie.php");
include ("SessionCookie.php");
include ("configuration.php");
if ($option=="logout"){
	setcookie("usercookie");
	$option="";
	print "<SCRIPT> document.location.href='index.php'; </SCRIPT>\n";
}

if ($detection <> "detected"){
	include ("browserdetect.php");
	include ("OSdetect.php");
	setcookie("detection", "detected");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo $sitename; ?></title>
<!--
 Mambo Open Source Version 4.0
 Dynamic Portal Server and Content Managment Engine
 31-10-2002
 
 Copyright (C) 2000 - 2003 Miro International Pty Ltd
 Distributed under the terms of the GNU General Public License
 Available at http://sourceforge.net/projects/mambo
//-->
<link rel="stylesheet" href="css/theme_mambosimple.css" type="text/css">
<link rel="shortcut icon" href="images/favicon.ico" />
<style type="text/css">
</style>
<?php echo _ISO; ?>
<meta name="revisit-after" content="7">
<meta name="Rating" content="General">
<meta name="Pragma" content="no-cache">
<meta name="Generator" content="Mambo Open Source 4.0.12">
<meta name="distribution" content="Global">
<meta name="Copyright" content="© 2002>
<meta name="Classification" content="Web Programming">
<meta name="Author" content="Mambo Open Source Project">
<meta name="keywords" content="mambo, mambo site server, Mambo, Mambo site server">
<meta name="description" content="Mambo Siteserver - the dynamic portal engine and content management system">
</head>

<body bgcolor=#ffffff leftmargin="3" topmargin="3">
<table width="800" border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
  <tr>
    <td width="178" bgcolor="#416A8B" height="49">&nbsp;</td>
    <td bgcolor="#DBB457" height="49" valign="middle" colspan="5">
      <div align="right"><font size="6" face="Verdana, Arial, Helvetica, sans-serif" color="#F0DFB9"><b><font face="Geneva, Arial, Helvetica, san-serif">
        <?php echo $sitename; ?>
        </font></b></font></div>
    </td>
    <td bgcolor="#5687AF" width="180" align="center" height="49"> <span class="whitetext">
      <?php echo date(_DATE_FORMAT); ?>
      </span> </td>
  </tr>
  <tr>
    <td height="80" width="178"><img src="images/themes/theme_mambosimple/keyboard.jpg" border="0" height="80" width="178"></td>
    <td bgcolor="#999999" height="80" colspan="5" valign="middle"> 
      <?php include ("newsflash.php"); ?>
    </td>
    <td bgcolor="#999999" height="80" width="180" align="center">
      <FORM ACTION='index.php' METHOD='post'>
<font class="componentHeading"><?php echo _SEARCH_BOX; ?></font> 
<input class="inputbox" type="text" name="searchword" size="12">
<INPUT TYPE="hidden" NAME="option" VALUE="search">
</FORM>
    </td>
  </tr>
</table>

<table width="800" cellpadding="0" cellspacing="1" border="0">
  <tr>
    <td height="11" bgcolor="#F0DFB9" width="178">
      &nbsp;<?php include ("pathway.php"); ?>
    </td>
  </tr>
</table>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" height="19" valign="top">
      <?php 
           $side = "left"; 
           include("component.php");    
      ?>	
      
    </td>
    <td width="440" valign="top" align="center">
      <table width="99%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top">
            <?php include ("mainbody.php"); ?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" valign="bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="7" align="center"> 
    </td>
  </tr>
  <tr> 
    <td class="small"> 
      <div align="center"><font color="#999999"><?php echo _FOOTER_INDEX; ?></font></div>
    </td>
  </tr>
</table>
          </td>
        </tr>
      </table>
    </td>
    <td width="180" valign="top">
    <?php 
         $side = "right"; 
         include("component.php");    
    ?>
    </td>
  </tr>
</table>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center"> 
      <?php include ("banners.php"); ?>
    </td>
  </tr>
  <tr>
    <td align="center"><div align="center"><img src="images/poweredbyLong.gif" width="169" height="8"></div></td>
  </tr>
</table>
</body>
</html>
