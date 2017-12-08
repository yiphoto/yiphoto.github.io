<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/users.php");
?>
<? 
//Deletes the Customer based on ID.
$ID=$_GET['id'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM users WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
mysql_query ("DELETE FROM users WHERE ID =$ID",$db);
echo("You have succesfully deleted User <b>$myrow[RealName]</b>.");


?>
<br>
<?

include ("manageusers.php")
?>
<? include ("../login/obend.php"); ?>