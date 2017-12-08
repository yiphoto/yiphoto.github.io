<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/customers.php");
?>
<? 
//Deletes the Customer based on ID.
include ("../settings.php");
$ID=$_GET['id'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);
$result = mysql_query("SELECT * FROM customers WHERE ID=$ID",$db);
$myrow = mysql_fetch_assoc($result);
mysql_query ("DELETE FROM customers WHERE ID =$ID",$db);
echo("You have succesfully deleted Customer <b>$myrow[FirstN] $myrow[LastN]</b>.");


?>
<br>
<?

include ("managecustomers.php")
?>
<? include ("../login/obend.php"); ?>