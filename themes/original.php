<?php 	/**
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
	 *	File Name: index.php
	 *	Original Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 03/01/2003
	 * 	Version #: 4.0.12
	 *	Comments:
	**/

include ("configuration.php");

include('language/'.$lang.'/lang_theme.php');
include ("newsflashCookie.php");

include ("SessionCookie.php");

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
 Mambo Open Source
 Dynamic portal server and Content managment engine
 03-02-2003

 Copyright (C) 2000 - 2003 Miro International Pty. Limited
 Distributed under the terms of the GNU General Public License
 Available at http://sourceforge.net/projects/mambo
//-->
<link rel="stylesheet" href="css/ie5.css" type="text/css">
<style type="text/css">
<!--
.mastheadBG {  background: url(images/themes/theme_original/slice.gif) repeat-x}
-->
</style>
<?php echo _ISO; ?>
<meta name="revisit-after" content="7">
<meta name="Rating" content="General">
<meta name="Pragma" content="no-cache">
<meta name="Generator" content="Mambo Open Source 4.0.12">
<meta name="distribution" content="Global">
<meta name="Copyright" content="©2003">
<meta name="Classification" content="Web Programming">
<meta name="Author" content="Miro International Pty. Limited">
<meta name="keywords" content="mambo, mambo site server, Mambo, Mambo site server">
<meta name="description" content="Mambo site server - the dynamic portal enginevand content management system">
<script language="JavaScript">
<!--
<!--
function reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.pgW=innerWidth; document.pgH=innerHeight; onresize=reloadPage; }}
  else if (innerWidth!=document.pgW || innerHeight!=document.pgH) location.reload();
}
reloadPage(true);
// -->

function swapImgRestore() {
  var i,x,a=document.sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function preloadImages() {
  var d=document; if(d.images){ if(!d.p) d.p=new Array();
    var i,j=d.p.length,a=preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.p[j]=new Image; d.p[j++].src=a[i];}}
}

function findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function swapImage() {
  var i,j=0,x,a=swapImage.arguments; document.sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=findObj(a[i]))!=null){document.sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body bgcolor="#ffffff" onLoad="preloadImages('images/themes/theme_original/home_f2.gif','images/themes/theme_original/news_f2.gif','images/themes/theme_original/articles_f2.gif','images/themes/theme_original/faqs_f2.gif','images/themes/theme_original/links_f2.gif','images/themes/theme_original/contact_f2.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="630" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="630">
        <td width="12"><img name="topleft" src="images/themes/theme_original/topleft.gif" width="12" height="12" border="0"></td>
        <td rowspan="2"><img name="neo_r1_c2" src="images/themes/theme_original/neo_r1_c2.gif" width="618" height="85" border="0"></td>
        </tr>
        <tr>
          <td width="12"><img name="neo_r2_c1" src="images/themes/theme_original/neo_r2_c1.gif" width="12" height="73" border="0"></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>

<td colspan="2" bordercolor="#FF00FF"><a href="index.php" onMouseOut="swapImgRestore()"  onMouseOver="swapImage('home','','images/themes/theme_original/home_f2.gif',1);" ><img name="home" src="images/themes/theme_original/home.gif" width="90" height="30" border="0"></a></td>

<td width="101" bordercolor="#FF00FF"><a href="index.php?option=news&Itemid=2" onMouseOut="swapImgRestore()" onMouseOver="swapImage('new','','images/themes/theme_original/news_f2.gif',1);"><img name="new" border="0" src="images/themes/theme_original/news.gif" width="90" height="30"></a></td>

<td width="101" bordercolor="#FF00FF"><a href="index.php?option=articles&Itemid=3" onMouseOut="swapImgRestore()"  onMouseOver="swapImage('articles','','images/themes/theme_original/articles_f2.gif',1);" ><img name="articles" src="images/themes/theme_original/articles.gif" width="90" height="30" border="0"></a></td>

<td width="101" bordercolor="#FF00FF"><a href="index.php?option=faq&Itemid=5" onMouseOut="swapImgRestore()"  onMouseOver="swapImage('faqs','','images/themes/theme_original/faqs_f2.gif',1);" ><img name="faqs" src="images/themes/theme_original/faqs.gif" width="90" height="30" border="0"></a></td>

<td width="101" bordercolor="#FF00FF"><a href="index.php?option=weblinks&Itemid=4" onMouseOut="swapImgRestore()"  onMouseOver="swapImage('links','','images/themes/theme_original/links_f2.gif',1);" ><img name="links" src="images/themes/theme_original/links.gif" width="90" height="30" border="0"></a></td>

<td width="101" bordercolor="#FF00FF"><a href="index.php?option=contact&Itemid=6" onMouseOut="swapImgRestore()"  onMouseOver="swapImage('contact','','images/themes/theme_original/contact_f2.gif',1);" ><img name="contact" src="images/themes/theme_original/contact.gif" width="90" height="30" border="0"></a></td>

<td width="101" bordercolor="#FF00FF"><img name="neo_r3_c8" src="images/themes/theme_original/neo_r3_c8.gif" width="90" height="30" border="0"></td>
        </tr>
      </table>
    </td>
    <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td rowspan="2" class="mastheadBG" width="100%" nowrap><img src="images/M_images/6977transparent.gif" width="10" height="10"></td>
          <td width="12" height="12" valign="top"><img name="TOPrIGHT" src="images/themes/theme_original/TOPrIGHT.gif" width="12" height="12" border="0" vspace="0" hspace="0"></td>
        </tr>
        <tr>
          <td width="12" valign="top"><img name="neo2_r2_c2" src="images/themes/theme_original/neo2_r2_c2.gif" width="12" height="103" border="0" align="top" vspace="0" hspace="0"></td>
        </tr>
        <tr> </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td WIDTH="25%">
      <?php include("pathway.php"); ?>
      &nbsp;</td>
    <td WIDTH="50%" ALIGN="center">&nbsp; </td>
    <td WIDTH="25%" align="right">&nbsp; </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td width="160" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <FORM ACTION='index.php' METHOD='post'>
              <b><?php echo _SEARCH_BOX; ?></b>
              <input type="text" name="searchword" size="12">
              <INPUT TYPE="hidden" NAME="option" VALUE="search">
            </FORM>
          </td>
        </tr>
      </table>
      <br>
      <?php
         $side = "left";
         include("component.php");
      ?>
    </td>
    <td valign="top">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" bgcolor="#666666" align="center">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#FFFFFF">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <td bgcolor="#CCCCCC" height="20">
                      <div align="right"><img src="images/themes/theme_original/windowbuttons.gif" width="54" height="16" align="absmiddle" alt="Just decoration. Don't bother trying to click.">&nbsp;</div>
                    </td>
                    </tr>
                  </table>
                  <?php include ("newsflash.php");?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="98%" border="0" cellspacing="0" cellpadding="0" bgcolor="#666666" align="center">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td bgcolor="#FFFFFF">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <td bgcolor="#CCCCCC" height="20">
                      <div align="right"><img src="images/themes/theme_original/windowbuttons.gif" width="54" height="16" align="absmiddle" alt="Just decoration. Don't bother trying to click.">&nbsp;</div>
                    </td>
                    </tr>
                  </table>
                  <?php include ("mainbody.php"); ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"> <br>
            <?php include("banners.php");?>
          </td>
        </tr>
      </table>
    </td>
    <td width="160" valign="top" class="poll">
      <?php echo date(_DATE_FORMAT); ?>
      <br>
      <br>
      <?php
          $side = "right";
          include("component.php");
      ?>
      <br>
    </td>
  </tr>
</table>
<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="small">
      <div align="center"><font color="#999999"><?php echo _FOOTER_INDEX; ?></font></div>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="45" valign="bottom">
      <div align="center">&nbsp;<img src="images/poweredbyLong.gif" width="169" height="8"></div>
    </td>
  </tr>
</table>
</body>
</html>
