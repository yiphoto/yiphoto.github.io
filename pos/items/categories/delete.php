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

//Does the deleting work!
$ID=$_GET['id'];
$db = mysql_connect("$server", "$username", "$password");
mysql_select_db("$database",$db);

$result = mysql_query("SELECT * FROM categories WHERE ID =$ID",$db);
$myrow = mysql_fetch_assoc($result);
mysql_query ("DELETE FROM categories WHERE ID =$ID",$db);
echo("You have succesfully deleted Category <b>$myrow[Category]</b>.");
?>
<br>
<?
include ("newcategory.php");
include ("managecategories.php");
?>
<?php 
ob_end_flush(); 
?> 