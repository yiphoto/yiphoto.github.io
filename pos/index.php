<?php
ob_start();
session_start();
if($_SESSION['Name']=='' )
{
	header("Location: login.php");
	exit;
	
}
include ("settings.php");
if($menu=="set")
{

?>

	<HTML>
<head>
<title>PHP Point Of Sale</title>
</head>
<frameset border="0" frameborder="no" framespacing="0" rows="40,*">
<frame name="TopFrame" noresize scrolling="no" src="menubar.php">
<frame name="MainFrame" noresize src="home.php">
</frameset>
<noframes>
  <body bgcolor="#FFFFFF" text="#000000">
    <p>
      Your browser does not support frames!  Please download the latest version of the browser you have!
    </p>
  </body>
</noframes>
</HTML>

<?
}
else
{
?>
<HTML>
<head>
<title>PHP Point Of Sale</title>
</head>
<frameset border="0" frameborder="no" framespacing="0" rows="90,*">
<frame name="TopFrame" noresize scrolling="no" src="menubar.php">
<frame name="MainFrame" noresize src="home.php">
</frameset>
<noframes>
  <body bgcolor="#FFFFFF" text="#000000">
    <p>
      Your browser does not support frames!  Please download the latest version of the browser you have!
    </p>
  </body>
</noframes>
</HTML>
<?php 
}
ob_end_flush();
?>