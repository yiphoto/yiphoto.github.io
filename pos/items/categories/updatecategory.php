<? include ("../../login/session.php"); 
include ("../../settings.php");
include ("../../authorization/items.php");
?>
<?
//Updates the database with any new information about the items  and checks for errors.
$ID=$_POST['id'];
$Category = $_POST['Category'];
$OldCategoryName = $_POST['OldCategoryName'];
$err = "../../errors/error.php";
$ok = "../../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "categories";
$dbTable2 = "sales";
$dbTable3 = "items";
$sel = "UPDATE $dbTable  SET Category=\"$Category\" WHERE ID=$ID";
$sel2 ="UPDATE $dbTable2 SET Category=\"$Category\" WHERE Category=\"$OldCategoryName\"";
$sel3 ="UPDATE $dbTable3 SET Category=\"$Category\" WHERE Category=\"$OldCategoryName\"";
if ($Category=='' ) {
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
echo"Category Name: "."$Category"."<BR>";
echo "<BR>";
echo"--------------------";
echo "<BR>";
echo " <a href=managecategories.php><-- Go back to Categories</a>";
}
?>
<?
	

?>
<? include ("../../login/obend.php"); ?>