<?php
/**
  *  Mambo Site Server Open Source Project Version 4.0.12
  *  Version #: 4.0.12
  *  Comments:
**/

include($absolute_path.'/language/'.$lang.'/lang_theme.php');

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
<title>Yi  Chen Photography :: Seattle Wedding Photographer, Portrait photographer, Fashion Photographer in Seattle/Redmond/Bellevue</title>
<link rel="stylesheet" href="css/theme_akogreenportal.css" type="text/css">
<link rel="shortcut icon" href="images/favicon.ico" />
<style type="text/css">
</style>
<meta name="keywords" content="hosting, web hosting, affordable web hosting, content management system, mambo, mambo site server, Mambo, Mambo site server">
<meta name="description" content="Affordable Hosting by ShanSoft">
<meta name="revisit-after" content="7">
<meta name="Rating" content="General">
<meta name="Pragma" content="no-cache">
<meta name="Language" content="en">
<meta name="Generator" content="Shansoft Web Hosting">
<meta name="distribution" content="Global">
<meta name="Copyright" content="?2002>
<meta name="Classification" content="Web Programming">
<meta name="Author" content="Shansoft">
</head>

<body class="body" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<a name="top"></a>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr bgcolor="#FFFFFF">
    <td><img border="0" src="images/themes/theme_akogreenportal/logo.JPG"></td>
    <td>
      <form action="index.php" method="post"><input type="hidden" name="option" value="search"><input class="inputbox" type="text" name="searchword" size="15" value="<?php echo _SEARCH_BOX; ?>"  onBlur="if(this.value=='') this.value='<?php echo _SEARCH_BOX; ?>';" onFocus="if(this.value=='<?php echo _SEARCH_BOX; ?>') this.value='';">&nbsp;&nbsp;</form>
    </td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="navigationline" valign="center" align="left"  bgcolor="#000000">&nbsp;&nbsp;<img src="images/M_images/arrow.gif">&nbsp;<?php include ("pathway.php"); ?></td>
    <td class="navigationline" valign="center" align="right" bgcolor="#000000"><?php echo date(_DATE_FORMAT); ?>&nbsp;&nbsp;</td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td background="images/themes/theme_akogreenportal/loc_bar_back.gif"><img border="0" src="images/themes/theme_akogreenportal/loc_bar_back.gif"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"> </div></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" width="100%">
  <tr>
    <td width="8">&nbsp;</td>
    <td width="180" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td  bgcolor="#CCCCCC">
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td  bgcolor="#F0F0F0"><strong>Main Menu</strong></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">
                  <?php
                    $side="left";
                    include ("component.php");
                  ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br />
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td  bgcolor="#CCCCCC">
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td  bgcolor="#F0F0F0"><strong>Announcement</strong></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">
                  <?php
                    include ("newsflash.php");
                  ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td width="100%" valign="top"> 
      <?php
        include ("mainbody.php");
      ?>
    </td>
    <?php
      switch ($option){
        case "news":
        case "articles":
        case "com_minibb":
        case "com_downloads":
        case "weblinks":
        case "faq":
        case "displaypage":
        case "contact":
          echo "<!-- No Sidebar -->";
        break;
        default:
          ?>
            <td width="180" valign="top">
              <table width="100%" bgcolor="#CCCCCC" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td bgcolor="#FFFFFF">
                    <?php
                      $side="right";
                      include ("component.php");
                    ?>
                  </td>
                </tr>
              </table>
            </td>
          <?php
      }
      ?>
    <td width="8">&nbsp;</td>
  </tr>
</table>

<div align="center"></div>

<table align="center" border="0" cellpadding="3" cellspacing="0" width="100%">
  <tr>
    <td bgcolor="#000000"> </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" align="center"> 
      <script type="text/javascript"><!--
google_ad_client = "pub-4439681852707655";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_color_border = "666666";
google_color_bg = "666666";
google_color_link = "FFFFFF";
google_color_url = "666666";
google_color_text = "FFFFFF";
//--></script> <script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script> <script type="text/javascript">
function logclick() {

	window.focus();
		if (window.status) {
			click = new Image();
			click.src = 'http://www.shansoft.com/adsense/tracker.php?SiteID=2&SectionID=3&SetID=2&page=' + escape(document.location.href) + '&ad=' + escape(window.status) + '&type=click';
		}
};

if (document.getElementById("google_ads_frame")) {
	document.getElementById("google_ads_frame").onfocus = logclick
}

view = new Image();
view.src = 'http://www.shansoft.com/adsense/tracker.php?SiteID=2&SectionID=3&SetID=2&page=' + escape(document.location.href) + '&type=view';
</script>
      <font color="#999999" size="1" face="Verdana"><br>
      <?php include ("banners.php"); ?>
      <br>
      <?php echo _FOOTER_INDEX; ?></font><br /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><strong><font color="#FFFFFF">Google Romance Search http://www.google.com/romance/index.html Google Dating Service
<br>
Seattle wedding photographer, 
  seattle redmond bellevue wedding photography, photo studio redmond 98052, fashion 
  and wedding journalism </font></strong></p>
<p><strong><font color="#FFFFFF">style, senior portraits Michelle Burke, a professional 
  Portland photographer, also keeps chickens in her backyard &#8212; two Ameraucanas, 
  a Barred Plymouth Rock, a Silver-Laced Wyandotte and two Golden Sex Links. Burke, 
  mainly a wedding and portrait photographer, attended last year&#8217;s Tour 
  de Coops in the midst of searching for a side photography project. She decided 
  that the urban hens and their owners were extremely photo-worthy.<br>
  &#8220;I bit off more than I could chew. I posted on Craigslist.org that I wanted 
  to shoot portraits of Portlanders with their chickens. In exchange, I offered 
  a framed 8x10 or larger print from the shoot. I couldn&#8217;t believe the response 
  I got,&#8221; Burke says.<br>
  </font></strong> </p>
</body>
</html>

<!-- Start of StatCounter Code -->
<script type="text/javascript" language="javascript">
var sc_project=246433; 
</script>

<script type="text/javascript" language="javascript" src="http://www.statcounter.com/counter/counter.js"></script><noscript><a href="http://www.statcounter.com" target="_blank"><img  src="http://c1.statcounter.com/counter.php?sc_project=246433&amp;java=0" alt="free web tracker" border="0"></a> </noscript>
<!-- End of StatCounter Code -->