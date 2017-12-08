<?
$Name=$_SESSION['Name'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM users WHERE RealName=\"$Name\"",$db);
while($myrow=mysql_fetch_assoc($result))
{
	$auth=$myrow[Type];
}
switch($auth)
{
	case $auth=="Sales Clerk": 
	echo"You are not allowed to view this page";
	exit;
	break;
	
	case $auth=="Report Viewer": 
	echo"You are not allowed to view this page";
	exit;
	break;




}




?>