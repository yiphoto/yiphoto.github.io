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
  *  File Name: mambobizz.php
  *  Original Developers: Danny Younes - danny@miro.com.au
  *                       Nicole Anderson - nicole@miro.com.au
  *  Date: 03/03/2003
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
<?php echo _ISO; ?>
<link rel="stylesheet" href="css/theme_mambobizz.css" type="text/css">
<link rel="shortcut icon" href="images/favicon.ico" />
<style type="text/css">
</style>
<meta name="revisit-after" content="7">
<meta name="Rating" content="General">
<meta name="Pragma" content="no-cache">
<meta name="Language" content="en">
<meta name="Generator" content="Mambo Site Server 4.0">
<meta name="distribution" content="Global">
<meta name="Copyright" content="© 2002>
<meta name="Classification" content="Web Programming">
<meta name="Author" content="Mambo Open Source Project">
<meta name="keywords" content="mambo, mambo site server, Mambo, Mambo site server">
<meta name="description" content="Mambo Siteserver - the dynamic portal engine and content management system">
</head>

<body class="body" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<a name="top"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" bgcolor="#DCDCDC">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr bgcolor="#FFFFFF"> 
          <td colspan="3" align="left" valign="top" bgcolor="#202020"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="20">&nbsp;</td>
                <td width="160"><table width="160" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="images/themes/theme_mambobizz/atriu_buisness_pic.jpg" width="160" height="100"></td>
                    </tr>
                  </table></td>
                <td> 
                  <table width="480" border="0" cellspacing="10" cellpadding="0">
                    <tr> 
                      <td height="18"> <div align="left"> 
                          <table width="100%" border="0" cellspacing="5" cellpadding="0">
                            <tr> 
                              <td width="3" bgcolor="#CC3300">&nbsp;</td>
                              <td><p><font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFFF"><b><font face="Verdana, Arial, Helvetica, san-serif"><?php echo $sitename; ?></font></b></font><font color="#CC3300" size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;<br>
                                  <font color="#999999">Some Text Here, Like Your 
                                  Slogan... </font></font></p>
                                </td>
                            </tr>
                          </table>
                          <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#CCFF33"><b></b></font></div></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table></td>
          <td width="160" align="center" valign="middle" bgcolor="#202020"> 
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr> 
                <td><div align="center"><span class="small"><strong>Today 
                    is:</strong><br>
                     <?php echo date(_DATE_FORMAT); ?></span></div></td>
              </tr>
            </table>
          </td>
          <td align="right" valign="top" bgcolor="#202020"> <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr> 
                <td height="69" valign="middle" align="center"> <FORM ACTION='index.php' METHOD='post'>
                    <input class="inputbox" type="text" name="searchword" size="15" value="<?php echo _SEARCH_BOX; ?>"  onBlur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onFocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';">
                    <INPUT TYPE="hidden" NAME="option" VALUE="search">
                  </FORM></td>
              </tr>
            </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="20"><table width="20" height="20" border="0" cellpadding="0" cellspacing="5">
              <tr> 
                <td align="left" valign="middle"><img src="images/themes/theme_mambobizz/arrow2right.gif" width="9" height="12" align="middle"> 
                </td>
              </tr>
            </table></td>
          <td width="160"> <table width="160" height="20" border="0" cellpadding="0" cellspacing="5">
              <tr> 
                <td align="left" valign="middle">&nbsp; </td>
              </tr>
            </table></td>
          <td width="480"> <table width="480" height="20" border="0" cellpadding="0" cellspacing="5">
              <tr> 
                <td align="left" valign="middle"> 
                  <?php include ("pathway.php"); ?>
	</td>
      </tr>
    </table></td>
  <td width="160"> <table width="160" height="20" border="0" cellpadding="0" cellspacing="5">
      <tr> 
	<td align="left" valign="middle">&nbsp; </td>
      </tr>
    </table></td>
  <td width="50%">&nbsp;</td>
</tr>
<tr class="dfault_centerbackgr">
  <td align="left" valign="top" bgcolor="#F4F4F4">&nbsp;</td>
  <td width="160" align="left" valign="top" bgcolor="#F4F4F4"> <table width="160" border="0" cellspacing="0" cellpadding="0">
      <tr> 
	<td align="left" valign="top"> <table width="160" border="0" cellspacing="5" cellpadding="0">
	    <tr> 
	      <td width="3" bgcolor="#CC3300">&nbsp;</td>
	      <td><font color="#CC3300" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>:: Main 
		Menu</strong></font></td>
	    </tr>
	  </table></td>
      </tr>
      <tr> 
	<td></td>
      </tr>
    </table>
    <table width="160" border="0" cellspacing="0" cellpadding="0">
      <tr> 
	<td align="left" valign="top"> 
			
                  <?php 
			$side="left";
			include ("component.php"); ?>
                </td>
              </tr>
            </table>
            <table width="160" border="0" cellspacing="5" cellpadding="0">
              <tr> 
                <td width="3" bgcolor="#CC3300">&nbsp;</td>
                <td><font color="#CC3300" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo _NEWSFLASH_BOX; ?></strong></font></td>
              </tr>
              <tr> 
                <td bgcolor="#CCCCCC">&nbsp;</td>
                <td> 
                  <?php include ("newsflash.php"); ?>
                </td>
              </tr>
            </table></td>
          <td width="480" align="left" valign="top" bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="left" valign="top"> 
                  <?php include ("mainbody.php"); ?>
                </td>
              </tr>
              <tr> 
                <td><hr width="100%" color='#DCDCDC' size="1" noshade> <div align="center"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td><div align="center"> <img src="images/themes/theme_mambobizz/arrow2up.gif" width="12" height="9" border="0" align="middle"> 
                            <a href="#top">Go To Top</a> <img src="images/themes/theme_mambobizz/arrow2up.gif" width="12" height="9" align="middle"></div></td>
                      </tr>
                    </table>
                  </div></td>
              </tr>
              <tr> 
                <td><hr width="100%" color='#DCDCDC' size="1" noshade> 
                  <table border="0" cellspacing="10" cellpadding="0">
                    <tr> 
                      <td><p><?php include ("banners.php"); ?></p><?php echo _FOOTER_INDEX; ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="160" align="left" valign="top" bgcolor="#F4F4F4">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> 
                  <?php 
			$side="right";
			include ("component.php"); ?>
                </td>
              </tr>
            </table>
            
          </td>
          <td bgcolor="#F4F4F4">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div align="center"><img src="images/poweredbyLong.gif" width="169" height="8"> 
</div>
</body>
</html>
