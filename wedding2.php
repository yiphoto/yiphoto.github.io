<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META NAME="DESCRIPTION" CONTENT="Redmond based wedding and portrait photographer providing portrait, commercial, wedding, and event photography service">
<META NAME="KEYWORDS" CONTENT="seattle wedding photographer,wedding,portrait,photography,event,Bellevue,Redmond,Kirkland">
<title>Yi Chen Photography | Seattle wedding photojournalism Photographer</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("header.php"); ?>
<div id="content">
  <div id="photo"> 
  <?php 
  if( isset($_REQUEST['id']))
  {
  echo '<img src="wedding/wedding'.$_REQUEST['id'].'.jpg" class="imgb"/>';   
  }
  else
  {
  echo '<img src="wedding/wedding11.jpg" class="imgb" />';
  }
  ?>
	<div id="description"></div> 
  </div>
<?php include("wedding_thumbnail_2.php");?>
</div>
<div id="footer">Email: yichen @ yiphoto.com | Phone: 425-208-9106</div>
<div id="photogallery"  style="visibility: hidden">
<img src="wedding/wedding21.jpg" height=10 class="imgs"/>
<img src="wedding/wedding22.jpg" height=10 class="imgs"/>
<img src="wedding/wedding23.jpg" height=10 class="imgs"/>
<img src="wedding/wedding24.jpg" height=10 class="imgs"/>
<img src="wedding/wedding25.jpg" height=10 class="imgs"/>
<img src="wedding/wedding26.jpg" height=10 class="imgs"/>
<img src="wedding/wedding27.jpg" height=10 class="imgs"/>
<img src="wedding/wedding28.jpg" height=10 class="imgs"/>
<img src="wedding/wedding29.jpg" height=10 class="imgs"/>
<img src="wedding/wedding30.jpg" height=10 class="imgs"/>
<img src="wedding/wedding31.jpg" height=10 class="imgs"/>
<img src="wedding/wedding32.jpg" height=10 class="imgs"/>
<img src="wedding/wedding33.jpg" height=10 class="imgs"/>
<img src="wedding/wedding34.jpg" height=10 class="imgs"/>
<img src="wedding/wedding35.jpg" height=10 class="imgs"/>
<img src="wedding/wedding36.jpg" height=10 class="imgs"/>
<img src="wedding/wedding37.jpg" height=10 class="imgs"/>
<img src="wedding/wedding38.jpg" height=10 class="imgs"/>
<img src="wedding/wedding39.jpg" height=10 class="imgs"/>
<img src="wedding/wedding40.jpg" height=10 class="imgs"/>
</div>


<!--#include virtual="photo_gallery_fullsize.php" -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-130167-3";
urchinTracker();
</script>
</body>
</html>
