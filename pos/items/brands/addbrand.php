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

//Adds the brand to the database and checks for errors
$Brand = $_POST['Brand'];
$msg = "Brand: $Brand\n";
$err = "../../errors/error.php";
$ok = "../../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "brands";
$sel = "INSERT INTO $dbTable (Brand) VALUES (\"$Brand\")";
if ($Brand=='' ) 
{
include ("$err");
exit;
}
else
{
include("$ok");

$conn = @mysql_connect($dbHost, $dbUser, $dbPass);
$dbDB = @mysql_select_db($dbName, $conn);
$result = @mysql_query($sel, $conn);
}

?>
<?
include ("newbrand.php");
include ("managebrands.php");
?>
<?php 
ob_end_flush(); 
?> 