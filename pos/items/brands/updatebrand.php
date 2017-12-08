<? include ("../../login/session.php"); 
include ("../../settings.php");
include ("../../authorization/items.php");
?>
<?
//Updates the database with any new information about the items  and checks for errors.
$ID=$_POST['id'];
$Brand = $_POST['Brand'];
$OldBrandName = $_POST['OldBrandName'];
$err = "../../errors/error.php";
$ok = "../../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "brands";
$dbTable2 = "sales";
$dbTable3 = "items";
$sel = "UPDATE $dbTable  SET Brand=\"$Brand\" WHERE ID=$ID";
$sel2 ="UPDATE $dbTable2 SET Brand=\"$Brand\" WHERE brand=\"$OldBrandName\"";
$sel3 ="UPDATE $dbTable3 SET Brand=\"$Brand\" WHERE brand=\"$OldBrandName\"";
if ($Brand=='' ) {
include("$err");
exit;
} else {
$conn = @mysql_connect($dbHost, $dbUser, $dbPass);
$dbDB = @mysql_select_db($dbName, $conn);
$result = @mysql_query($sel, $conn);
$result2 = @mysql_query($sel2, $conn);
$result3 = @mysql_query($sel3, $conn);
include("$ok");
echo "<BR>";
echo"--------------------";
echo "<BR>";
echo"Brand Name: "."$Brand"."<BR>";
echo "<BR>";
echo"--------------------";
echo "<BR>";
echo " <a href=managebrands.php><-- Go back to Brands</a>";
}
?>
<?
	

?>
<? include ("../../login/obend.php"); ?>