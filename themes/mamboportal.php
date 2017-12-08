<?php 	
/**
  *  Mambo Site Server Open Source Project Version 4.0.12
  *  Dynamic portal server and Content managment engine
  *  03-03-2003
  *
  *  Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *  Distributed under the terms of the GNU General Public License
  *  This software may be used without warrany provided these statements are left
  *  intact and a "Powered By Mambo" appears at the bottom of each HTML page.
  *  This code is available at http://sourceforge.net/projects/mambo
  *
  *  Site Name: Mambo Site Server Open Source Project Version 4.0.12
  *  File Name: mamboportal.php
  *  Original Developers: Danny Younes - danny@miro.com.au
  *                       Nicole Anderson - nicole@miro.com.au
  *  Date: 03/03/2003
  *  Version #: 4.0.12
  *  Comments:
**/

include('language/'.$lang.'/lang_theme.php');

include ("newsflashCookie.php");
if (($op=="CorrectLogin") && ($option=="user")){
	$lifetime= (time() + 100000);
	setcookie("usercookie", "$uid");
	$usercookie=$uid;
}

include ("SessionCookie.php");
if ($option=="logout"){
	setcookie("usercookie");
	$usercookie="";
	$option="";
	print "<SCRIPT> document.location.href='index.php'; </SCRIPT>\n";
}

if ($detection <> "detected"){
	include ("browserdetect.php");
	include ("OSdetect.php");
	setcookie("detection", "detected");
}
include ("configuration.php");
?>

<html>
<head>
<!-- Template x5 - Version 1.0 -->                   
<!-- Copyright 2002 - 2003 by Angiras Multimedia All Rights Reserved. -->           
<!-- Angiras Multimedia http://www.angiras.net/ -->

<!-- DISCLAIMER -->
<!-- This template is provided "as is" without warranty of any kind, either expressed 
or implied. In no event shall we be liable for any damages including, but not 
limited to, direct, indirect, special, incidental or consequential damages or 
other losses arising out of the use of or inability to use this template.  -->
<title> 
<?php echo $sitename; ?>
</title>
<?php echo _ISO; ?>
<META NAME="ROBOTS" CONTENT="index, follow">
<META HTTP-EQUIV="PRAGMA" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="WINDOW-TARGET" CONTENT="_top">
<META content="Miro International" name=Author>
<META content="mambo, mamboserver, mambo site server, mambo server, open source cms, cms, content management, wysiwyg, online editor, web site update" name=keywords>
<META content="Mambo site server - the dynamic portal engine and content management system" name=description>
<LINK REL="Bookmark" HREF="images/favicon.ico">
<link REL="SHORTCUT ICON" HREF="images/favicon.ico">
<link rel="stylesheet" type = "text/css" href="css/theme_mamboportal.css">
<SCRIPT language=JavaScript>
<!--

function reloadPage(init) {  //Nav4 Resize Fix
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
  document.pgW=innerWidth; document.pgH=innerHeight; onresize=reloadPage; }}
  else if (innerWidth!=document.pgW || innerHeight!=document.pgH) location.reload();
}
reloadPage(true);
//-->
</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>

<BODY topmargin="0">
<table width=100% border=0 cellpadding=0 cellspacing=0>
  <tr>
    <td width=77% class=c1 height=75 align=left> <div class=h1><?php echo $sitename; ?></div>
      <div class=h2>www.yourcompany.com</div>
    <td width=23% class=c1 align=right> <FORM ACTION='index.php' METHOD='post'>
                    <font class="white"></font> 
                    <input class="inputbox" type="text" name="searchword" size="12" value="<?php echo _SEARCH_BOX; ?>">
                    <INPUT TYPE="button" NAME="option" VALUE="Go">
                    &nbsp; 
                    <INPUT TYPE="hidden" NAME="option" VALUE="search">
                  </FORM></tr>
</table>
<table width=100% cellpadding=0 cellspacing=0 border=0 height=10>
<tr >
<a href="index.php"><td width=10% class=l5a onmouseover="this.className='l5b';" onmouseout="this.className='l5a';">
&nbsp;Home
</td></a>
<a href="index.php?option=news&Itemid=2"><td width=10%  class=l5a onmouseover="this.className='l5b';" onmouseout="this.className='l5a';">
&nbsp;News</td></a>
<a href="index.php?option=weblinks&Itemid=4"><td width=10% class=l5a onmouseover="this.className='l5b';" onmouseout="this.className='l5a';">
&nbsp;Contact</td></a>
<a href="index.php?option=contact&Itemid=6"><td width=10% class=l5a onmouseover="this.className='l5b';" onmouseout="this.className='l5a';">
&nbsp;FAQ</td></a>
<td class=c2 >&nbsp;</td></tr></table>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr>
<td width=10% class=c5>&nbsp;</td><td width=80% align=center class=c5>

<?php include ("pathway.php"); ?>

</td>
<td width=10% class=c5>&nbsp;</td></tr>
</table>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td colspan=3 class=c1 height=5></td></tr>
<tr>
<td class=c6 height=20 width=20% valign=top>
      <table width=100% cellpadding=0 cellspacing=0 class=c3>
        <tr>
          <td width=100% class=c4> <div class=h5>&nbsp;&nbsp;::</div></td>
        </tr>
        <tr>
          <td width=100% height=20 class=l1a onmouseover="this.className='l1b';" onmouseout="this.className='l1a';"> 
            <?php $side=left; include ("component.php"); ?>
            <div align="center"><br>
              <img src="images/poweredbyLong.gif" width="169" height="8"> </div></td>
          </a></tr>
       
      </table>

    </td>
<td width=60% valign="top">
<table width=100% cellpadding=0 cellspacing=0>
<td width=5% class=c6>
          <td width=80% class=c6 valign=top> 
            <?php include ("mainbody.php"); ?>
            <br>
            <br>
          </td>
          <td width=5%></td></tr>
</table>
<br><div align="center"><? include ("banners.php"); ?></div></td>
<td width=20% valign=top>
      <table width=100% cellpadding=0 cellspacing=0 class=c3>
        <tr>
          <td width=100% class=c4> <div class=h5>&nbsp;&nbsp;::</div></td>
        </tr>
        <tr>
          <td width=100% height=20 class=l1a onmouseover="this.className='l1b';" onmouseout="this.className='l1a';"> 
            <?php $side=right; include ("component.php"); ?>
          </td>
          </a></tr>
       
      </table>
<br>
      <table width=100% cellpadding=0 cellspacing=0 class=c3>
        <tr>
          <td width=100% class=c4> <div class=h5>&nbsp;&nbsp;<?php echo _NEWSFLASH_BOX; ?></div></td>
        </tr>
        <tr>
          <td width=100% height=20 class=l1a onmouseover="this.className='l1b';" onmouseout="this.className='l1a';"> 
            <?php include ("newsflash.php"); ?>
          </td>
          </a></tr>
      </table>
</td>
</table>

<table width=100% cellpadding=0 cellspacing=0>
<tr>
<td class=c4 height=5></td>
</tr>
<tr>
<td class=c5>
<center>
        <?php echo _FOOTER_INDEX; ?><br>
      </center>
</td></tr>

</table>
</BODY>
</HTML>
