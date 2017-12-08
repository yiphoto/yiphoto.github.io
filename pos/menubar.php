<?
include ("login/session.php");
include ("settings.php");

$Name=$_SESSION['Name'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM users WHERE RealName=\"$Name\"",$db);
$myrow=mysql_fetch_assoc($result);
$auth=$myrow[Type];
if($menu=="set")
{
?>
<HTML>
<HEAD>

</HEAD>
<BODY BGCOLOR="ffffff">
<LEFT>

<APPLET archive="MenuBar.jar" code="MenuBar" width=2400 height=20>
<PARAM name=usertype value="<?php echo $auth;?>"> 
<PARAM name=domain value=<?
$url = sprintf("%s%s%s"," http://",$_SERVER['HTTP_HOST'],$_SERVER['SCRIPT_NAME']); 
$path=explode("menubar.php",$url);
echo "$path[0]"; 
?>>
 
Your browser does not support Java, so nothing is displayed.
</APPLET>
</LEFT>
</BODY>
</HTML>
<?
}
else
{
?>
<HTML>
<head>
<title>PHP Point Of Sale</title>
<SCRIPT LANGUAGE="JavaScript">

image0 = new Image();image0.src = "00up.jpg";
image1 = new Image();image1.src = "10up.jpg";
image2 = new Image();image2.src = "20up.jpg";
image3 = new Image();image3.src = "30up.jpg";
image4 = new Image();image4.src = "40up.jpg";

</SCRIPT>
</HEAD>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td background=images/background.jpg>
<div align="center">

 <table width= "585" border="0" cellspacing="0" cellpadding="0" >
  <tr>
   <td align='center'>
   <?
    if($auth=="Admin" )
    {
    ?>
    <a href="home.php" Target="MainFrame" onmouseover="image0.src='images/00over.jpg';"onmouseout="image0.src='images/00up.jpg';">
    <img name="image0" src="images/00up.jpg" border=0></a>
    <a href="customers/index.php" Target="MainFrame" onmouseover="image1.src='images/10over.jpg';"onmouseout="image1.src='images/10up.jpg';">
    <img name="image1" src="images/10up.jpg" border=0></a>
    <a href="items/index.php" Target="MainFrame" onmouseover="image2.src='images/20over.jpg';"onmouseout="image2.src='images/20up.jpg';">
    <img name="image2" src="images/20up.jpg" border=0></a>
    <a href="reports/index.php" Target="MainFrame" onmouseover="image3.src='images/30over.jpg';"onmouseout="image3.src='images/30up.jpg';">
    <img name="image3" src="images/30up.jpg" border=0></a>
    <a href="sales/index.php" Target="MainFrame" onmouseover="image4.src='images/40over.jpg';"onmouseout="image4.src='images/40up.jpg';">
    <img name="image4" src="images/40up.jpg" border=0></a>
     <?
   	}
   	if($auth=="Sales Clerk" )
   	{
 	?>
 	    <a href="home.php" Target="MainFrame" onmouseover="image0.src='images/00over.jpg';"onmouseout="image0.src='images/00up.jpg';">
    	<img name="image0" src="images/00up.jpg" border=0></a>
    	<a href="sales/index.php" Target="MainFrame" onmouseover="image4.src='images/40over.jpg';"onmouseout="image4.src='images/40up.jpg';">
    	<img name="image4" src="images/40up.jpg" border=0></a>
    	
    <?
    }
    if($auth=="Report Viewer" )
	{
	?>
	 <a href="home.php" Target="MainFrame" onmouseover="image0.src='images/00over.jpg';"onmouseout="image0.src='images/00up.jpg';">
    <img name="image0" src="images/00up.jpg" border=0></a>
    <a href="reports/index.php" Target="MainFrame" onmouseover="image3.src='images/30over.jpg';"onmouseout="image3.src='images/30up.jpg';">
   	 <img name="image3" src="images/30up.jpg" border=0></a>
   	  <?
    }
    
    }    
    ?>
  </td>
   </tr>
 </table>

</div>
</td>
</tr>
</table>
</body>
</HTML>