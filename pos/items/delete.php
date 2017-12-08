<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/items.php");
?>
<?
//Deletes an item based on ID.
include ("../settings.php");
$ID=$_GET['id'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$result = mysql_query("SELECT * FROM items WHERE ID =$ID",$db);
$myrow = mysql_fetch_assoc($result);
mysql_query ("DELETE FROM items WHERE ID =$ID",$db);
echo("You have succesfully deleted Item <b>$myrow[ItemName]</b>.");

?>
<br>
<?

include ("manageitems.php")
?>
<? include ("../login/obend.php"); ?>