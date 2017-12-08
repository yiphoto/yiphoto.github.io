<?php 	
// Mambo Open Source Version 4.0.12
// Dynamic portal server and Content managment engine
//
// Copyright (C) 2000 - 2003 Miro International Pty. Limited
// Distributed under the terms of the GNU General Public License
// This software may be used without warranty provided these statements are left
// intact and a "Powered By Mambo" appears at the bottom of each HTML page.
// This code is Available at http://sourceforge.net/projects/mambo
// Designed by Dimitri - Easygoin.net - from all at easygoin and the mamboserver development team, we hope you enjoy it!

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
<LINK HREF="css/theme_mambodefault.css" type=text/css rel=stylesheet>
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
</HEAD>
<BODY bgColor=#99CC00 leftMargin=0 topMargin=0 marginheight="0" marginwidth="0" text="#5e5e5e">
<!-- USED COLOURS IN TEMPLATE:
topnavbarbg=#A187D3 
topsection & botsection bg is set by page bg=#7154AB 
main bodysection bg and boundbox edge=#e4e4e4
footer boundbox bg=#b2b2b2 
lightblue boundbox bg=#EFF3FF
lightcream boundbox bg=#f3f3f3
mambo green=#993300
mambo orange=#ff9900
yellow if wanted=#ffcc00 
-->
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align="center">
  <TBODY> 
  <TR> 
    <TD vAlign=top> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="40">
        <tr> 
          <td>&nbsp;<b><font size=6 face="Verdana, Arial, Helvetica, sans-serif" color=#ffffff>
		<?php echo $sitename; ?></font></b></td>
          <td>&nbsp;</td>
          <td align="right"> 
            <TABLE border="0" cellpadding="0" cellspacing="0">
              <TBODY> 
              <TR> 
                <TD class="white">
                  <FORM ACTION='index.php' METHOD='post'>
                    <font class="white"></font> 
                    <input class="inputbox" type="text" name="searchword" size="12" value="<?php echo _SEARCH_BOX; ?>">
                    <INPUT TYPE="image" NAME="option" VALUE="submit" src="images/themes/theme_mambodefault/btn_go_grn.gif" alt="Go" width="30" height="20" align="top">
                    &nbsp; 
                    <INPUT TYPE="hidden" NAME="option" VALUE="search">
                  </FORM>
                </TD>
              </TR>
              </TBODY> 
            </TABLE>
          </td>
        </tr>
      </table>
    </TD>
  </TR>
  </TBODY> 
</TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 height="23" align="center" background="images/themes/theme_mambodefault/hdr_bg.gif">
  <TBODY> 
  <TR> 
    <TD width="1"><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="22" height="25"></TD>
    <TD class=menubar> <A class=menubar 
                  href="index.php?Itemid=1">Home</A>&nbsp;-&nbsp;&nbsp;<A 
                  class=menubar 
                  href="index.php?option=news&amp;Itemid=2">News</A>&nbsp;-&nbsp;&nbsp;<A 
                  class=menubar 
                  href="index.php?option=articles&amp;Itemid=3">Articles</A>&nbsp;-&nbsp;&nbsp;<A 
                  class=menubar 
                  href="index.php?option=weblinks&amp;Itemid=4">Web Links</A>&nbsp;-&nbsp;&nbsp;<A class=menubar 
                  href="index.php?option=faq&amp;Itemid=5">F.A.Q</A>&nbsp;-&nbsp;&nbsp;<A 
                  class=menubar 
                  href="index.php?option=contact&amp;Itemid=6">Contact</A> 
    </TD>
    <TD align="right" class=date> <i> 
      <?php echo date(_DATE_FORMAT); ?>
      </i>&nbsp;</TD>
  </TR>
  </TBODY> 
</TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align="center" background="images/themes/theme_mambodefault/hdr_dropshdw.gif" bgcolor="#E7EDD8">
  <TBODY> 
  <TR> 
    <TD><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="1" height="7"></TD>
  </TR>
  </TBODY> 
</TABLE>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 align="center" bgcolor="#E7EDD8">
  <TBODY> 
  <TR> 
    <TD> 
      <table width="100%" border="0" cellspacing="0" cellpadding="3" name="PATHWAY">
        <tr> 
          <td> 
            <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
              <tr> 
                <TD nowrap valign="middle" width="37%"> 
                 <?php include ("pathway.php");?>
                </TD>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      
      <!-- BEGIN MAIN BODY -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0" name="MAIN CONTENT" align="center">
        <tr valign="top"> 
          <td width="1%" nowrap><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="10" height="1"></td>
          <td width="84%" nowrap><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="400" height="1"></td>
          <td width="1%" nowrap><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="7" height="1"></td>
          <td width="14%" nowrap><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="120" height="1"></td>
        </tr>
        <tr valign="top"> 
          <td width="1%"><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="10" height="10"></td>
          <td align="center" width="90%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="10"><img src="images/themes/theme_mambodefault/main_tl.gif" width="10" height="10" border="0"></td>
                <td background="images/themes/theme_mambodefault/main_top.gif" height="10" colspan="3"><img src="images/themes/theme_mambodefault/clear.gif" width="10" height="10" border="0"></td>
                <td width="10"><img src="images/themes/theme_mambodefault/main_tr.gif" width="10" height="10" border="0"></td>
              </tr>
              <tr> 
                <td background="images/themes/theme_mambodefault/main_left.gif" width="10"><img src="images/themes/theme_mambodefault/clear.gif" width="10" height="10" border="0"></td>
                <td bgcolor="#FFFFFF" valign="top"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="14%" valign="top"> 
                        <table width="160" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td width="8" height="8"><img src="images/themes/theme_mambodefault/menu_tl.gif" width="8" height="8" border="0"></td>
                            <td background="images/themes/theme_mambodefault/menu_top.gif" height="8"><img src="images/themes/theme_mambodefault/clear.gif" width="8" height="8" border="0"></td>
                            <td width="8" height="8"><img src="images/themes/theme_mambodefault/menu_tr.gif" width="8" height="8" border="0"></td>
                          </tr>
                          <tr valign="top"> 
                            <td background="images/themes/theme_mambodefault/menu_left.gif" width="8"><img src="images/themes/theme_mambodefault/clear.gif" width="8" height="8" border="0"></td>
                            <td  bgcolor="#eef3ff"> 
                              <!--<SPAN class=head>Mambo Left Component</SPAN>-->
                              <?php 
                                 $side="left";
                                 include("component.php"); 
                              ?>
                              <br>
                              <br>
                              <div align="center"><a 
            href="http://mos.mamboserver.com/banners.php?op=click&amp;bid=3" target="_blank"><img 
            src="images/themes/theme_mambodefault/sflogo.jpg" vspace=5 
            border=0 width="118" height="35" alt="SourceForge.net"></a> </div>
                            </td>
                            <td width="8" background="images/themes/theme_mambodefault/menu_right.gif"><img src="images/themes/theme_mambodefault/clear.gif" width="8" height="8" border="0"></td>
                          </tr>
                          <tr valign="top"> 
                            <td height="8" width="8"><img src="images/themes/theme_mambodefault/menu_bl.gif" width="8" height="8" border="0"></td>
                            <td height="8" background="images/themes/theme_mambodefault/menu_bottom.gif"><img src="images/themes/theme_mambodefault/clear.gif" width="1" height="8" border="0"></td>
                            <td width="8" height="8"><img src="images/themes/theme_mambodefault/menu_br.gif" width="8" height="8" border="0"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
                <td bgcolor="#FFFFFF" width="1%"><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="7" height="7"></td>
                <td bgcolor="#FFFFFF" width="90%" valign="top">
                  <!-- MAIN BODY WHITE-->
                  <?php include ("mainbody.php"); ?>
                  <!-- END MAIN BODY WHITE -->
                </td>
               
                <td width="10" background="images/themes/theme_mambodefault/main_right.gif"><img src="images/themes/theme_mambodefault/clear.gif" width="10" height="10" border="0"></td>
              </tr>
              <tr> 
                <td width="10" height="10"><img src="images/themes/theme_mambodefault/main_bl_corner.gif" width="10" height="10" border="0"></td>
                <td height="10" background="images/themes/theme_mambodefault/main_bottom.gif" colspan="3"><img src="images/themes/theme_mambodefault/clear.gif" width="10" height="10" border="0"></td>
                <td><img src="images/themes/theme_mambodefault/main_br.gif" border="0" width="10" height="10"></td>
              </tr>
            </table>
           
            <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
              <tr> 
                <td align="center"> 
                  <?php include ("banners.php"); ?>
                </td>
              </tr>
            </table>
          </td>
          <td width="1%"><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="7" height="10"></td>
          <td width="14%" align="center">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" name="NEWSFLASH">
                    <tr>
    <td><TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
                    <TBODY> 
                    <TR height="17"> 
                      <TD width="1%" height="17"><IMG height=17 
                              src="images/themes/theme_mambodefault/purple_boundbox_tl.gif" 
                              width=10 border=0></TD>
                      <TD bgcolor="#A187D3" width="98%" class="headadbox"><?php echo _NEWSFLASH_BOX; ?></TD>
                      <TD width="1%"><IMG height=17 
                              src="images/themes/theme_mambodefault/purple_boundbox_tr.gif" 
                              width=10 
                    border=0></TD>
                    </TR>
                    </TBODY> 
                  </TABLE>
				  <TABLE cellSpacing=0 cellPadding=0 width=100% bgColor=#eef3ff 
                  border=0>
                    <TBODY> 
                    <TR> 
                      <TD width=1 bgColor=#A187D3><IMG height=1 
                        src="images/themes/theme_mambodefault/clear.gif" 
                        width=1 border=0></TD>
                      <TD width=9><IMG height=8 
                        src="images/themes/theme_mambodefault/clear.gif" 
                        width=9 border=0></TD>
                      <TD valign="top"> 
                        <TABLE cellSpacing=0 cellPadding=0 border=0>
                          <TBODY> 
                          <tr> 
                            <td><IMG height=8 
                        src="images/themes/theme_mambodefault/clear.gif" 
                        width=10 border=0></td>
                          </tr>
                          <TR> 
                            <TD vAlign=top> 
                              <?php include ("newsflash.php"); ?>
                            </TD>
                          </TR>
                          </TBODY> 
                        </TABLE>
                      </TD>
                      <TD width=1 bgColor=#A187D3><IMG height=1 
                        src="images/themes/theme_mambodefault/clear.gif" 
                        width=1 border=0></TD>
                    </TR>
                    </TBODY> 
                  </TABLE>
                  <TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
                    <TBODY> 
                    <TR> 
                      <TD width="1%" rowspan=2><IMG height=10 
                              src="images/themes/theme_mambodefault/purple_boundbox_bot_bl.gif" 
                              width=11 border=0></TD>
                      <TD bgcolor="#eef3ff" valign="top" width="98%"><img src="images/themes/theme_mambodefault/clear.gif" height="9" width="155" border="0"></TD>
                      <TD width="1%" rowspan=2><IMG height=10 
                              src="images/themes/theme_mambodefault/purple_boundbox_br.gif" 
                              width=11 
                    border=0></TD>
                    </TR>
                    <TR height="1"> 
                      <TD bgcolor="#9999CC" width="98%"><img src="images/themes/theme_mambodefault/clear.gif" height="1" width="1" border="0"></TD>
                    </TR>
                    </TBODY> 
                  </TABLE>
                  </td>
  </tr>
</table>
        <br>
            <A 
            href="http://www.miro.com.au/" target="_blank"><IMG 
            height=73 src="images/themes/theme_mambodefault/ad_mambo_sponsoredby.gif" width=188 
            border=0 alt="Visit MIRO the open source mamboserver project sponsors"></A> 
            <br>
            <!--<SPAN class=head>Mambo Right Component</SPAN>-->
            <?php 
                 $side="right";
                 include("component.php"); 
            ?>
            <br>
            <br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr> 
                <td> 
                  <TABLE cellSpacing=0 cellPadding=0 border=0>
                    <TBODY> 
                    <TR> 
                      <TD vAlign=top><IMG height=10 
                        src="images/themes/theme_mambodefault/lightblue_adbox_top.gif" 
                        width=175></TD>
                    </TR>
                    </TBODY> 
                  </TABLE>
                  <TABLE cellSpacing=0 cellPadding=0 width=175 bgColor=#eef3ff 
                  border=0>
                    <TBODY> 
                    <TR> 
                      <TD width=1 bgColor=#c4d4f3><IMG height=10 
                              src="images/themes/theme_mambodefault/clear.gif" 
                              width=1 border=0></TD>
                      <TD vAlign=top> 
                        <TABLE cellSpacing=0 cellPadding=0 border=0>
                          <TBODY> 
                          <TR> 
                            <TD width=9><IMG height=10 
                              src="images/themes/theme_mambodefault/clear.gif" 
                              width=10 border=0></TD>
                            <TD vAlign=top><IMG height=72 
                              alt="CMS as it should be - easy quick and multi platform compatible" 
                              src="images/themes/theme_mambodefault/promo_ad_cms_lightblue.gif" 
                              width=149 border=0></TD>
                            <TD width=9><IMG height=10 
                              src="images/themes/theme_mambodefault/clear.gif" 
                              width=10 border=0></TD>
                          </TR>
                          </TBODY> 
                        </TABLE>
                      </TD>
                      <TD width=1 bgColor=#c4d4f3><IMG height=10 
                              src="images/themes/theme_mambodefault/clear.gif" 
                              width=1 border=0></TD>
                    </TR>
                    </TBODY> 
                  </TABLE>
                  <TABLE cellSpacing=0 cellPadding=0 border=0>
                    <TBODY> 
                    <TR> 
                      <TD height=10><IMG height=10 
                        src="images/themes/theme_mambodefault/lightblue_adbox_bot.gif" 
                        width=175></TD>
                    </TR>
                    <TR> 
                      <TD height=10><IMG height=10 
                        src="images/themes/theme_mambodefault/clear.gif" 
                        width=10 border=0></TD>
                    </TR>
                    </TBODY> 
                  </TABLE>
                </td>
              </tr>
            </table>
            
          </td>
        </tr>
      </table>
      <!-- END MAIN BODY -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
          <td><img src="images/themes/theme_mambodefault/clear.gif" border="0" width="50" height="10"></td>
  </tr>
</table>
    </TD>
  </TR>
  </TBODY> 
</TABLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/themes/theme_mambodefault/ftr_bg.gif">
  <tr> 
    <td height="10"><img src="images/themes/theme_mambodefault/clear.gif" border="0" height="10" width="1"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#99CC00">
  <tr> 
    <TD class=crumb align="center"><?php echo _FOOTER_INDEX; ?><br>
      <img src="images/poweredbyLong.gif" width="169" height="8" vspace="5" border="0" alt="Powered by Mambo Open Source"> 
    </TD>
  </tr>
</table>
<!-- table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center"> 
      <?php include ("configuration.php"); ?>
    </td>
  </tr>
</table -->
</BODY>
</HTML>
