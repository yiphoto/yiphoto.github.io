<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/reports.php");
?>

<?
//inserts the new order information into the database (updates old).
$ID=$_POST['id'];
$Date = $_POST['Date'];
$Customer = $_POST['Customer'];
$Items = $_POST['Items'];
$Price = $_POST['Price'];
$Quantity = $_POST['Quantity'];
$TotalCost = $_POST['TotalCost'];
$UpdateCustomer = $_POST['UpdateCustomer'];
$Tax=$TotalCost-($Price*$Quantity);
$Tax=number_format($Tax, 2, '.', ''); 
$id = $_POST['id'];
$msg = "Date: $Date\nCustomer: $Customer\nItems: $Items\nPrice: $Price\nQuantity: $Quantity\nTotalCost: $TotalCost\nUpdateCustomer: $UpdateCustomer\nTax: $Tax\nid: $id\n";
$err = "../errors/error.php";
$ok = "../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "sales";
$sel = "UPDATE $dbTable SET Date=\"$Date\", Customer=\"$Customer\", Items=\"$Items\", Price=\"$Price\", Quantity=\"$Quantity\",TotalCost=\"$TotalCost\",Tax=\"$Tax\" WHERE ID=$ID";
if (!$Date || !$Customer || !$Items || !$Price || !$Quantity || !$TotalCost) {
include("$err");
exit;
} else {
$conn = @mysql_connect($dbHost, $dbUser, $dbPass);
$dbDB = @mysql_select_db($dbName, $conn);
$result = @mysql_query($sel, $conn);
include("$ok");
}
include ("cumulative.php");
?>
<? include ("../login/obend.php"); ?>