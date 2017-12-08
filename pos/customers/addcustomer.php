<? include ("../login/session.php"); 
include ("../settings.php");
include ("../authorization/customers.php");
?>
<?
//Adds a Customer to the database and checks for errors.
$FirstN = $_POST['FirstN'];
$LastN = $_POST['LastN'];
$AccountNum = $_POST['AccountNum'];
$PhoneNum = $_POST['PhoneNum'];
$Comments = $_POST['Comments'];
$AddCustomer = $_POST['AddCustomer'];
$msg = "FirstN: $FirstN\nLastN: $LastN\nAccountNum: $AccountNum\nPhoneNum: $PhoneNum\nComments: $Comments\nAddCustomer: $AddCustomer\n";
$err = "../errors/error.php";
$ok = "../errors/ok.php";
$dbHost = "$server";
$dbName = "$database";
$dbUser = "$username";
$dbPass = "$password";
$dbTable = "customers";
$sel = "INSERT INTO $dbTable (FirstN, LastN, AccountNum, PhoneNum, Comments, ID) VALUES (\"$FirstN\", \"$LastN\", \"$AccountNum\", \"$PhoneNum\", \"$Comments\", \"$\")";
if (!$FirstN || !$LastN || !$AccountNum || !$PhoneNum) {
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
echo"First Name: "."$FirstN"."<BR>";
echo"Last Name: "."$LastN"."<BR>";
echo"Account Number: "."$AccountNum"."<BR>";
echo"Phone Number: "."$PhoneNum"."<BR>";
echo"Comments: "."$Comments"."<BR>";
echo"--------------------";
echo "<BR>";
}
?>
<br>
<?
include ("newcustomer.php");
?>
<? include ("../login/obend.php"); ?>