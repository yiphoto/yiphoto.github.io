<?

ob_start();
session_start();
if($_SESSION['Name']=='' )
{
	header("Location: ../../login.php");
	exit;
}
include ("../../settings.php");
include ("../../authorization/items.php");

//The code that deletes the brands
$ID=$_GET['id'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$result = mysql_query("SELECT * FROM brands WHERE ID =$ID",$db);
$myrow = mysql_fetch_assoc($result);
mysql_query ("DELETE FROM brands WHERE ID =$ID",$db);
echo("You have succesfully deleted Brand <b>$myrow[Brand]</b>.");

?>
<br>
<?
include ("newbrand.php");
include ("managebrands.php");
?>
<?php 
ob_end_flush(); 
?> 