<? Session_Start();
$Name=$_SESSION ['Name'];

include ("login/session.php");
include ("settings.php");
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM users WHERE RealName=\"$Name\"",$db);
$myrow=mysql_fetch_assoc($result);
$auth=$myrow[Type];


?>
<HTML>
<head> 
<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url)
{
	if(confirm(message) )
  {
    parent.location.href = url;
  }
}
// --->
</SCRIPT> 

<LINK REL=stylesheet HREF="stylesheets/stylesheet.php" TYPE="text/css"> 

<title>PHP Point Of Sale</title>
</head>
<body>
<? echo "User <b>$Name</b> has logged in sucessfully."; ?>
<h3 align="center">Home</h3><br>
<? if($menu=="set")
{
?>
<table border="0" width="500" align="center">
<tr bgcolor='white'>
  <td>Welcome!  To start using PHP Point of Sale use the menu at the top to navigate!<br><br></td>
</tr>
</table>
<?
}
else
{
?>
	<table border="0" width="500" align="center">
<tr bgcolor='white'>
  <td>Welcome!  To start using PHP Point of Sale use the tabs at the top to navigate!<br><br></td>
</tr>
</table>

<?
}
if($auth=="Admin" and $menu=="notset" )
{
?>
<ul>
	<li><a href="settings/index.php">Change Settings</a>
	<li><a href="users/index.php">Create/Manage Users</a>
</ul>
<?
}
?>
<BR>
<BR>
<? if($menu=="notset")
{
?>
<A href="javascript:decision('Are you sure you want to logout?','logout.php')"><img src="images/logout.jpg" border="0" alt="Logout"></a>
<?
}
?>
</body>
</HTML>
<?
//Optimize the tables when this page is accessed.
include ("settings.php");
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
mysql_query("OPTIMIZE TABLE sales");
mysql_query("OPTIMIZE TABLE items");
mysql_query("OPTIMIZE TABLE brands");
mysql_query("OPTIMIZE TABLE categories");
mysql_query("OPTIMIZE TABLE customers");
mysql_query("OPTIMIZE TABLE users");

?>





