<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/items.php");
?>
<?
//Adds the items to the database and checks for errors.
$ItemName = $_POST['ItemName'];
$ItemID = $_POST['ItemID'];
$Description = $_POST['Description'];
$Brand = $_POST['Brand'];
$Category = $_POST['Category'];
$Price = $_POST['Price'];
$Tax = $_POST['Tax'];
$Quantity = $_POST['Quantity'];
$Submit = $_POST['Submit'];
$newtax=$Tax/100 + 1;  
$TotalCost=$Price*$newtax;
	

$TotalCost=number_format($TotalCost, 2, '.', ''); 
$price=number_format($price, 2, '.', ''); 


$msg = "ItemName: $ItemName\nItemID: $ItemID\nDescription: $Description\nBrand: $Brand\nCategory: $Category\nPrice: $Price\nTax: $Tax\nQuantity: $Quantity\nSubmit: $Submit\nTotalCost: $TotalCost\n";
$err = "../errors/error.php";
$ok = "../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "items";
$sel = "INSERT INTO $dbTable (ItemName, ItemID, Description, Brand, Category, Price, Tax, TotalCost, ID, Quantity) VALUES (\"$ItemName\", \"$ItemID\", \"$Description\", \"$Brand\", \"$Category\", \"$Price\", \"$Tax\", \"$TotalCost\", \"$\", \"$Quantity\")";
if (!$ItemName || !$ItemID || !$Brand || !$Category || !$Price || !$Tax || !$Quantity) {
include("$err");
exit;
} else {
$conn = @mysql_connect($dbHost, $dbUser, $dbPass);
$dbDB = @mysql_select_db($dbName, $conn);
$result = @mysql_query($sel, $conn);
include("$ok");
echo "<BR>";
echo"--------------------";
echo "<BR>";
echo"Item Name: "."$ItemName"."<BR>";
echo"Item ID: "."$ItemID"."<BR>";
echo"Description: "."$Description"."<BR>";
echo"Brand: "."$Brand"."<BR>";
echo"Category: "."$Category"."<BR>";
echo"Price: "."\$"."$Price"."<BR>";
echo"Tax: "."$Tax"."%"."<BR>";
echo"Quantity: "."$Quantity"."<BR>";
echo"TotalCost: "."\$"."$TotalCost"."<BR>";
echo"--------------------";
echo "<BR>";
}
?>
<?
	
	include ("newitem.php");

?>
<? include ("../login/obend.php"); ?>