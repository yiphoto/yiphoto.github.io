<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>
<? 
//Deletes an order!
include ("../settings.php");
$ID=$_GET['id'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM sales WHERE ID =$ID",$db);
$myrow = mysql_fetch_assoc($result);
mysql_query ("DELETE FROM sales WHERE ID =$ID",$db);
$CustomerName=explode("[",$myrow[Customer]);
echo("You have succesfully deleted an Order by <b>$CustomerName[0] for Item <i>$myrow[Items]</i></b>.");


?>
<br>
<?

include ("cumulative.php")
?>
<? include ("../login/obend.php"); ?>