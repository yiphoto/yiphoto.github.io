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

//Adds the category to the database and checks for errors.
$Category = $_POST['Category'];
$msg = "Category: $Category\n";
$err = "../../errors/error.php";
$ok = "../../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "categories";
$sel = "INSERT INTO $dbTable (Category) VALUES (\"$Category\")";
if ($Category=='' ) 
{
	include ("$err");
	exit;

}
else
{
$conn = @mysql_connect($dbHost, $dbUser, $dbPass);
$dbDB = @mysql_select_db($dbName, $conn);
$result = @mysql_query($sel, $conn);
include("$ok");
}

?>

<?
include ("newcategory.php");
include ("managecategories.php");
?>

<?php 
ob_end_flush(); 
?> 